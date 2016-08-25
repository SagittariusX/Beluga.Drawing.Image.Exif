<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Tags\Workflow} class.
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


/**
 * @since v0.1
 */
class Workflow
{


   // <editor-fold desc="// = = = =   P U B L I C   F I E L D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * The instructions. ("Instructions" or "Special Instructions")
    *
    * @var string|null
    */
   public $Instructions; # <-- "Instructions" oder "Special Instructions"

   /**
    * The transmission reference. ("Transmission Reference" or "Original Transmission Reference")
    *
    * @var string|null
    */
   public $TransmissionReference; # <-- "Transmission Reference" oder "Original Transmission Reference"

   /**
    * The credit ("Credit")
    *
    * @var string|null
    */
   public $Credit;  # <-- "Credit"

   /**
    * The source ("Source")
    *
    * @var string|null
    */
   public $Source;  # <-- "Source"

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   C O N S T R U C T O R   = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Init the new instance from an associative array.
    *
    * This elements will be handled:
    *
    * 'Instructions', 'Special Instructions', 'Transmission Reference', 'Original Transmission Reference',
    * 'Credit', 'Source'
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param  array $data
    */
   public function __construct( array $data = array() )
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
    * 'Instructions', 'Special Instructions', 'Transmission Reference', 'Original Transmission Reference',
    * 'Credit', 'Source'
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param array $data
    */
   public final function initFromArray( array $data )
   {

      $this->Instructions = isset( $data[ 'Instructions' ] )
         ? $data[ 'Instructions' ]
         : ( isset( $data[ 'Special Instructions' ] )
            ? $data[ 'Special Instructions' ]
            : null
         );

      $this->TransmissionReference = isset( $data[ 'Transmission Reference' ] )
         ? $data[ 'Transmission Reference' ]
         : ( isset( $data[ 'Original Transmission Reference' ] )
            ? $data[ 'Original Transmission Reference' ]
            : null
         );

      $this->Credit = isset( $data[ 'Credit' ] ) ? $data[ 'Credit' ] : null;
      $this->Source = isset( $data[ 'Source' ] ) ? $data[ 'Source' ] : null;

   }

   /**
    * Add all current declared elements to $array. They will be added with the keys:
    *
    * 'Instructions', 'Special Instructions', 'Transmission Reference', 'Original Transmission Reference',
    * 'Credit', 'Source'
    *
    * if they are defined
    *
    * @param array $array
    */
   public final function addToArray( array &$array )
   {

      if ( ! \is_null( $this->Instructions ) && ( '' != $this->Instructions ) )
      {
         $array[ 'Instructions' ] = $this->Instructions;
         $array[ 'Special Instructions' ] = $this->Instructions;
      }

      if ( ! \is_null( $this->TransmissionReference ) && ( '' != $this->TransmissionReference ) )
      {
         $array[ 'Transmission Reference' ] = $this->TransmissionReference;
         $array[ 'Original Transmission Reference' ] = $this->TransmissionReference;
      }

      if ( ! \is_null( $this->Credit ) && ( '' != $this->Credit ) )
      {
         $array[ 'Credit' ] = $this->Credit;
      }

      if ( ! \is_null( $this->Source ) && ( '' != $this->Source ) )
      {
         $array[ 'Credit' ] = $this->Source;
      }

   }

   // </editor-fold>


}

