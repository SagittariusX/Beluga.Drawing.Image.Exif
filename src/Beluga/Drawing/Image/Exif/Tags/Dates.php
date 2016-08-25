<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Tags\Dates} class.
 *
 * @author         SagittariusX <unikado+sag@gmail.com>
 * @copyright  (c) 2016, SagittariusX
 * @package        Beluga\Drawing\Image\Exif
 * @since          2016-08-20
 * @subpackage     Tags
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Beluga\Drawing\Image\Exif\Tags;


use \Beluga\Date\DateTime;


/**
 * @since v0.1
 */
class Dates
{


   // <editor-fold desc="// = = = =   P U B L I C   F I E L D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * The date time of last image change. ("Modify Date")
    *
    * @var \Beluga\Date\DateTime|NULL
    */
   public $LastModified; # <-- "Modify Date"

   /**
    * The date time of image creation/shot. ("Create Date", "Date Created", "Date/Time Created", "Date/Time Original")
    *
    * @var \Beluga\Date\DateTime|NULL
    */
   public $Created;      # <-- "Create Date" oder "Date Created" oder "Date/Time Created" oder "Date/Time Original"

   /**
    * The date time where the image was digitized. ("Digital Creation Date/Time" or
    * "Digital Creation Date" + "Digital Creation Time")
    *
    * @var \Beluga\Date\DateTime|NULL
    */
   public $Digitized;  # <-- "Digital Creation Date/Time" oder "Digital Creation Date" + "Digital Creation Time"

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   C O N S T R U C T O R   = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Inits a new instance.
    *
    * @param  array $data Daten zur Initialisierung. Mögliche verwertete Keys sind 'Modify Date', 'Create Date',
    *                     'Date Created', 'Date/Time Created', 'Date/Time Original', 'Digital Creation Date/Time',
    *                     'Digital Creation Date', 'Digital Creation Time'
    */
   public function __construct( array $data = [] )
   {

      $this->initFromArray( $data );

   }

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   M E T H O D S   = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Init the current instance from an associative array.
    *
    * This elements will be handled:
    *
    * 'Modify Date', 'Create Date', 'Date Created', 'Date/Time Created', 'Date/Time Original',
    * 'Digital Creation Date/Time', 'Digital Creation Date', 'Digital Creation Time'
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param array $data
    */
   public final function initFromArray( array $data )
   {

      $this->LastModified = isset( $data[ 'Modify Date' ] ) ? self::ParseDateTime( $data[ 'Modify Date' ] ) : null;
      $dt     = [
         isset( $data[ 'Create Date' ] )        ? self::ParseDateTime( $data[ 'Create Date' ] )        : null,
         isset( $data[ 'Date Created' ] )       ? self::ParseDateTime( $data[ 'Date Created' ] )       : null,
         isset( $data[ 'Date/Time Created' ] )  ? self::ParseDateTime( $data[ 'Date/Time Created' ] )  : null,
         isset( $data[ 'Date/Time Original' ] ) ? self::ParseDateTime( $data[ 'Date/Time Original' ] ) : null
      ];
      $oldest = null;

      for ( $i = 0; $i < 4; ++$i )
      {
         if ( \is_null( $dt[ $i ] ) )
         {
            continue;
         }
         if ( \is_null( $oldest ) )
         {
            $oldest = $dt[ $i ];
            continue;
         }
         $oldest = new DateTime();
         if ( $oldest > $dt[ $i ] )
         {
            $oldest = $dt[ $i ];
         }
      }

      $this->Created = $oldest;
      $dt   = [
         isset( $data[ 'Digital Creation Date/Time' ] )
            ? self::ParseDateTime( $data[ 'Digital Creation Date/Time' ] )
            : null,
         ( isset( $data[ 'Digital Creation Date' ] ) && isset( $data[ 'Digital Creation Time' ] ) )
            ? self::ParseDateTime( $data[ 'Digital Creation Date' ] . ' ' . $data[ 'Digital Creation Time' ] )
            : null,
         $this->Created
      ];
      $oldest = null;

      for ( $i = 0; $i < 3; ++$i )
      {
         if ( \is_null( $dt[ $i ] ) )
         {
            continue;
         }
         if ( \is_null( $oldest ) )
         {
            $oldest = $dt[ $i ];
            continue;
         }
         if ( $oldest > $dt[ $i ] )
         {
            $oldest = $dt[ $i ];
         }
      }

      $this->Digitized = $oldest;

      if ( \is_null( $this->LastModified ) )
      {
         if ( \is_null( $this->Created ) )
         {
            if ( \is_null( $this->Digitized ) )
            {
               return;
            }
            $this->Created      = $this->Digitized;
            $this->LastModified = $this->Digitized;
            return;
         }
         if ( \is_null( $this->Digitized ) )
         {
            $this->Digitized = $this->Created;
         }
         $this->LastModified = $this->Created;
      }
      else if ( \is_null( $this->Created ) )
      {
         if ( \is_null( $this->Digitized ) )
         {
            $this->Created = $this->LastModified;
         }
         $this->Created = $this->Digitized;
      }
      else if ( \is_null( $this->Digitized ) )
      {
         $this->Digitized = $this->Created;
      }

   }

   /**
    * Add all current declared elements to $array. They will be added with the keys:
    *
    * 'Modify Date', 'Create Date', 'Date Created', 'Date/Time Created', 'Date/Time Original',
    * 'Digital Creation Date/Time', 'Digital Creation Date', 'Digital Creation Time'
    *
    * if they are defined
    *
    * @param array $array The reference to the array where the data should be added.
    */
   public final function addToArray( array &$array )
   {

      if ( ! \is_null( $this->LastModified ) && ( $this->LastModified instanceof \DateTimeInterface ) )
      {
         $array[ 'Modify Date' ] = $this->LastModified->format( 'Y:m:d H:i:s' );
      }

      if ( ! \is_null( $this->Created ) && ( $this->Created instanceof \DateTimeInterface ) )
      {
         $array[ 'Create Date' ]        = $this->Created->format( 'Y:m:d H:i:s' );
         $array[ 'Date Created' ]       = $array[ 'Create Date' ];
         $array[ 'Date/Time Created' ]  = $array[ 'Create Date' ];
         $array[ 'Date/Time Original' ] = $array[ 'Create Date' ];
      }

      if ( ! \is_null( $this->Digitized ) && ( $this->Digitized instanceof \DateTimeInterface ) )
      {
         $array[ 'Digital Creation Date/Time' ] = $this->Digitized->format( 'Y:m:d H:i:s' );
         $array[ 'Digital Creation Date' ]      = $this->Digitized->format( 'Y:m:d' );
         $array[ 'Digital Creation Time' ]      = $this->Digitized->format( 'Y:m:d' );
      }

   }

   /**
    * Gets the oldest defined date time if defined.
    *
    * @return \Beluga\Date\DateTime oder NULL
    */
   public final function getOldest()
   {

      $isLM = ( ! \is_null( $this->LastModified ) && ( $this->LastModified instanceof \DateTimeInterface ) );
      $isCR = ( ! \is_null( $this->Created )      && ( $this->Created instanceof \DateTimeInterface ) );
      $isDI = ( ! \is_null( $this->Digitized )    && ( $this->Digitized instanceof \DateTimeInterface ) );

      $array = [];

      if ( $isLM )
      {
         $array[] = $this->LastModified;
      }

      if ( $isDI )
      {
         $array[] = $this->Digitized;
      }

      if ( $isCR )
      {
         $array[] = $this->Created;
      }

      $stamp = \PHP_INT_MAX;

      $idx   = -1;
      for ( $i = 0; $i < \count( $array ); ++$i )
      {
         if ( $array[ $i ]->getTimestamp() >= $stamp )
         {
            continue;
         }
         $idx = $i;
         $stamp = $array[ $i ]->getTimestamp();
      }

      if ( $idx < 0 )
      {
         return null;
      }

      return $array[ $idx ];

   }

   /**
    * Returns if a usable datetime value is currently defined.
    *
    * @return boolean
    */
   public final function hasValue()
      : bool
   {

      return ( ! \is_null( $this->LastModified ) && ( $this->LastModified instanceof \DateTimeInterface ) )
          || ( ! \is_null( $this->Created )      && ( $this->Created      instanceof \DateTimeInterface ) )
          || ( ! \is_null( $this->Digitized )    && ( $this->Digitized    instanceof \DateTimeInterface ) );

   }

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   S T A T I C   M E T H O D S   = = = = = = = = = = = = = = = = = =">

   /**
    * Extracts a DateTime instance from a string datetime.
    *
    * @param  string $str
    * @return \Beluga\Date\DateTime
    */
   public static function ParseDateTime( string $str )
      : DateTime
   {
      
      if ( \is_null( $str ) || ! \is_string( $str ) || '' === $str )
      {
         return null;
      }

      $tmp = \explode( '.', $str );
      if ( \count( $tmp ) == 2 )
      {
         $str = \trim( $tmp[ 0 ] );
      }

      $tmp = \explode( ' ', $str, 2 );
      if ( \count( $tmp ) != 2 )
      {
         return null;
      }

      $tmp[ 0 ] = \str_replace( ':', '-', $tmp[ 0 ] );

      return new DateTime( \join( ' ', $tmp ) );

   }

   // </editor-fold>


}

