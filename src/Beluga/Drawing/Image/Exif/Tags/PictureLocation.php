<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Tags\PictureLocation} class.
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
class PictureLocation
{


   // <editor-fold desc="// = = = =   P U B L I C   F I E L D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * The picture location. ("Location" or "Sub-location")
    *
    * @var string|null
    */
   public $Region; # <-- "Location" oder "Sub-location"

   /**
    * The picture location state ("State" or "Province-State")
    *
    * @var string|null
    */
   public $State; # <-- "State" oder "Province-State"

   /**
    * The picture location 2 char country code. ("Country Code" or "Country-Primary Location Code")
    *
    * @var string|null
    */
   public $CountryCode; # <-- "Country Code" oder "Country-Primary Location Code"

   /**
    * The picture location city. ("City")
    *
    * @var string|null
    */
   public $City; # <-- "City"

   /**
    * The picture location country. ("Country" or "Country-Primary Location Name")
    *
    * @var string|null
    */
   public $Country; # <-- "Country" oder "Country-Primary Location Name"

   /**
    * The picture genre. ("Intellectual Genre")
    *
    * @var string|null
    */
   public $Genre; # <-- "Intellectual Genre"

   /**
    * The picture scene ("Scene")
    *
    * @var string|null
    */
   public $Scene; # <-- "Scene"

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   C O N S T R U C T O R   = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Init the new instance from an associative array.
    *
    * This elements will be handled:
    *
    * 'Location', 'Sub-location', 'State', 'Province-State', 'Country Code', 'Country-Primary Location Code',
    * 'City', 'Country', 'Country-Primary Location Name', 'Intellectual Genre', 'Scene'
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
    * 'Location', 'Sub-location', 'State', 'Province-State', 'Country Code', 'Country-Primary Location Code',
    * 'City', 'Country', 'Country-Primary Location Name', 'Intellectual Genre', 'Scene'
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param array $data
    */
   public final function initFromArray( array $data )
   {

      $this->Region = isset( $data[ 'Location' ] )
         ? $data[ 'Location' ]
         : ( isset( $data[ 'Sub-location' ] )
            ? $data[ 'Sub-location' ]
            : null
         );

      $this->State = isset( $data[ 'State' ] )
         ? $data[ 'State' ]
         : ( isset( $data[ 'Province-State' ] )
            ? $data[ 'Province-State' ]
            : null
         );

      $this->CountryCode = isset( $data[ 'Country Code' ] )
         ? $data[ 'Country Code' ]
         : ( isset( $data[ 'Country-Primary Location Code' ] )
            ? $data[ 'Country-Primary Location Code' ]
            : null
         );

      $this->City = isset( $data[ 'Creator City' ] ) ? $data[ 'Creator City' ] : null;

      $this->Country = isset( $data[ 'Country' ] )
         ? $data[ 'Country' ]
         : ( isset( $data[ 'Country-Primary Location Name' ] )
            ? $data[ 'Country-Primary Location Name' ]
            : null
         );

      $this->Genre = isset( $data[ 'Intellectual Genre' ] ) ? $data[ 'Intellectual Genre' ] : null;
      $this->Scene = isset( $data[ 'Scene' ] ) ? $data[ 'Scene' ] : null;

   }

   /**
    * Add all current declared elements to $array. They will be added with the keys:
    *
    * 'Location', 'Sub-location', 'State', 'Province-State', 'Country Code', 'Country-Primary Location Code',
    * 'City', 'Country', 'Country-Primary Location Name', 'Intellectual Genre', 'Scene'
    *
    * if they are defined
    *
    * @param array $array
    */
   public final function addToArray( array &$array )
   {

      if ( ! \is_null( $this->Region ) && '' != $this->Region )
      {
         $array[ 'Location' ] = $this->Region;
         $array[ 'Sub-location' ] = $this->Region;
      }

      if ( ! \is_null( $this->State ) && '' != $this->State )
      {
         $array[ 'State' ] = $this->State;
         $array[ 'Province-State' ] = $this->State;
      }

      if ( ! \is_null( $this->CountryCode ) && '' != $this->CountryCode )
      {
         $array[ 'Country Code' ] = $this->CountryCode;
         $array[ 'Country-Primary Location Code' ] = $this->CountryCode;
      }

      if ( ! \is_null( $this->City ) && '' != $this->City )
      {
         $array[ 'City' ] = $this->City;
      }

      if ( ! \is_null( $this->Country ) && '' != $this->Country )
      {
         $array[ 'Country' ] = $this->Country;
         $array[ 'Country-Primary Location Name' ] = $this->Country;
      }

      if ( ! \is_null( $this->Genre ) && '' != $this->Genre )
      {
         $array[ 'Intellectual Genre' ] = $this->Genre;
      }

      if ( ! \is_null( $this->Scene ) && '' != $this->Scene )
      {
         $array[ 'Scene' ] = $this->Scene;
      }

   }

   // </editor-fold>


}

