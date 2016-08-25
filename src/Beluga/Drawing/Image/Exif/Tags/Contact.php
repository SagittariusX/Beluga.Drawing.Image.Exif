<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Tags\Contact} class.
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


use \Beluga\Web\MailAddress;


/**
 * @since v0.1
 */
class Contact
{


   // <editor-fold desc="// = = = =   P U B L I C   F I E L D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Der Autor/Künstler/Ersteller/Bildner des Bildes (Creator|Artist|By-line)
    *
    * @var string|null
    */
   public $Author; # <-- "Creator" oder "Artist" oder "By-line"

   /**
    * Die Berufsbezeichnung des Autors. (By-line Title|Authors Position)
    *
    * @var string|null
    */
   public $JobTitle; # <-- "By-line Title" oder "Authors Position"

   /**
    * Adressezeile der Autoradresse (typischer Weise Strasse + Hausnummer) (Creator Address)
    *
    * @var string|null
    */
   public $Address; # <-- "Creator Address"

   /**
    * Ort der Autoradresse. (Creator City)
    *
    * @var string|null
    */
   public $City; # <-- "Creator City"

   /**
    * Bundesland/Kanton der Autoradresse. (Creator Region)
    *
    * @var string|null
    */
   public $Region; # <-- "Creator Region"

   /**
    * PLZ der Autoradresse. (Creator Postal Code)
    *
    * @var string|null
    */
   public $PostalCode; # <-- "Creator Postal Code"

   /**
    * Land (Name) der Autoradresse. (Creator Country)
    *
    * @var string|null
    */
   public $Country; # <-- "Creator Country"

   /**
    * Telefonnummer des Autors. (Creator Work Telephone)
    *
    * @var string|null
    */
   public $Telephone; # <-- "Creator Work Telephone"

   /**
    * Mailadresse des Autors. (Creator Work Email)
    *
    * @var \Beluga\Web\MailAddress oder NULL
    */
   public $Email; # <-- "Creator Work Email"

   /**
    * URLs vom Autor des Bildes. ("Creator Work URL" 0-n Urls)
    *
    * @var array
    */
   public $Urls; # <-- "Creator Work URL" 0-n Urls

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   C O N S T R U C T O R   = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Inits a new instance.
    *
    * @param  array $data Daten zur Initialisierung. Mögliche verwertete Keys sind 'Creator', 'Artist', 'By-line',
    *                     'Authors Position', 'By-line Title', 'Creator Address', 'Creator City', 'Creator Region',
    *                     'Creator Postal Code', 'Creator Country', 'Creator Work Telephone', 'Creator Work Email',
    *                     'Creator Work URL'
    */
   public function __construct( array $data = [ ] )
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
    * 'Creator', 'Artist', 'By-line', 'Authors Position', 'By-line Title', 'Creator Address', 'Creator City',
    * 'Creator Region', 'Creator Postal Code', 'Creator Country', 'Creator Work Telephone', 'Creator Work Email',
    * 'Creator Work URL'
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param array $data
    */
   public final function initFromArray( array $data )
   {

      $this->Author = isset( $data[ 'Creator' ] )
         ? $data[ 'Creator' ]
         : ( isset( $data[ 'Artist' ] )
            ? $data[ 'Artist' ]
            : ( isset( $data[ 'By-line' ] )
               ? $data[ 'By-line' ]
               : null
            )
         );

      if ( \is_null( $this->Author ) )
      {
         $this->Author = isset( $data[ 'Owner Name' ] )
            ? $data[ 'Owner Name' ]
            : null;
      }

      $this->JobTitle = isset( $data[ 'Authors Position' ] )
         ? $data[ 'Authors Position' ]
         : ( isset( $data[ 'By-line Title' ] )
            ? $data[ 'By-line Title' ]
            : null
         );

      $this->Address = isset( $data[ 'Creator Address' ] ) ? $data[ 'Creator Address' ] : null;
      $this->City = isset( $data[ 'Creator City' ] ) ? $data[ 'Creator City' ] : null;
      $this->Region = isset( $data[ 'Creator Region' ] ) ? $data[ 'Creator Region' ] : null;
      $this->PostalCode = isset( $data[ 'Creator Postal Code' ] ) ? $data[ 'Creator Postal Code' ] : null;
      $this->Country = isset( $data[ 'Creator Country' ] ) ? $data[ 'Creator Country' ] : null;
      $this->Telephone = isset( $data[ 'Creator Work Telephone' ] ) ? $data[ 'Creator Work Telephone' ] : null;

      try
      {
         $this->Email = isset( $data[ 'Creator Work Email' ] )
            ? MailAddress::Parse( $data[ 'Creator Work Email' ] )
            : null;
      }
      catch ( \Throwable $ex )
      {
         $ex = null;
         $this->Email = null;
      }

      $this->Urls = isset( $data[ 'Creator Work URL' ] )
         ? \explode( ' ', $data[ 'Creator Work URL' ] )
         : [];

      for ( $i = 0; $i < \count( $this->Urls ); ++$i )
      {
         $this->Urls[ $i ] = \trim( $this->Urls[ $i ], ' \t;.:' );
      }

   }

   /**
    * Add all current declared elements to $array. They will be added with the keys:
    *
    * 'Creator', 'Artist', 'By-line', 'Authors Position', 'By-line Title', 'Creator Address', 'Creator City',
    * 'Creator Region', 'Creator Postal Code', 'Creator Country', 'Creator Work Telephone', 'Creator Work Email',
    * 'Creator Work URL'
    *
    * if they are defined
    *
    * @param array $array The reference to the array where the data should be added.
    */
   public final function addToArray( array &$array )
   {

      if ( ! \is_null( $this->Author ) && '' != $this->Author )
      {
         $array[ 'Creator' ] = $this->Author;
         $array[ 'Artist' ]  = $this->Author;
         $array[ 'By-line' ] = $this->Author;
      }

      if ( ! \is_null( $this->JobTitle ) && '' != $this->JobTitle )
      {
         $array[ 'Authors Position' ] = $this->JobTitle;
         $array[ 'By-line Title' ]    = $this->JobTitle;
      }

      if ( ! \is_null( $this->Address ) && '' != $this->Address )
      {
         $array[ 'Creator Address' ] = $this->Address;
      }

      if ( ! \is_null( $this->City ) && '' != $this->City )
      {
         $array[ 'Creator City' ] = $this->City;
      }

      if ( ! \is_null( $this->Region ) && '' != $this->Region )
      {
         $array[ 'Creator Region' ] = $this->Region;
      }

      if ( ! \is_null( $this->PostalCode ) && '' != $this->PostalCode )
      {
         $array[ 'Creator Postal Code' ] = $this->PostalCode;
      }

      if ( ! \is_null( $this->Country ) && '' != $this->Country )
      {
         $array[ 'Creator Country' ] = $this->Country;
      }

      if ( ! \is_null( $this->Telephone ) && '' != $this->Telephone )
      {
         $array[ 'Creator Work Telephone' ] = $this->Telephone;
      }

      if ( ! \is_null( $this->Email ) && ( $this->Email instanceof \Beluga\Web\MailAddress ) )
      {
         $array[ 'Creator Work Email' ] = (string) $this->Email;
      }

      if ( \count( $this->Urls ) > 0 )
      {
         $array[ 'Creator Work URL' ] = \join( ' ', $this->Urls );
      }

   }

   // </editor-fold>


}

