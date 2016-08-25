<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Tags\Gps} class.
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


use \Beluga\GIS\Coordinate;


/**
 * @since v0.1
 */
class Gps
{


   // <editor-fold desc="// = = = =   P U B L I C   F I E L D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * The GPS coordinate if defined. ("GPS Latitude" + "GPS Longitude" or "GPS Position")
    *
    * @var \Beluga\GIS\Coordinate|NULL
    */
   public $Coordinate; # <-- ("GPS Latitude" + "GPS Longitude") oder "GPS Position"

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   C O N S T R U C T O R   = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Inits a new instance.
    *
    * @param  array $data Daten zur Initialisierung. Mögliche verwertete Keys sind 'GPS Latitude', 'GPS Longitude',
    *                     'GPS Position'
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
    * 'GPS Latitude', 'GPS Longitude', 'GPS Position'
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param array $data
    */
   public final function initFromArray( array $data )
   {

      $coord = null;

      if ( isset( $data[ 'GPS Latitude' ] ) && isset( $data[ 'GPS Longitude' ] ) )
      {
         if ( Coordinate::TryParse( $data[ 'GPS Latitude' ] . ', ' . $data[ 'GPS Longitude' ], $coord ) )
         {
            $this->Coordinate = $coord;
            return;
         }
      }

      if ( isset( $data[ 'GPS Position' ] ) )
      {
         if ( Coordinate::TryParse( $data[ 'GPS Position' ], $coord ) )
         {
            $this->Coordinate = $coord;
            return;
         }
      }

      $this->Coordinate = null;

   }

   /**
    * Add all current declared elements to $array. They will be added with the keys:
    *
    * 'GPS Latitude', 'GPS Longitude', 'GPS Position', 'GPS Latitude Ref', 'GPS Longitude Ref'
    *
    * if they are defined
    *
    * @param array $array The reference to the array where the data should be added.
    */
   public final function addToArray( array &$array )
   {

      if ( ! \is_null( $this->Coordinate )
        && ( $this->Coordinate instanceof Coordinate )
        &&   $this->Coordinate->isValid() )
      {

         $array[ 'GPS Latitude' ]  = $this->Coordinate->Latitude->formatExifLike();
         $array[ 'GPS Longitude' ] = $this->Coordinate->Longitude->formatExifLike();
         $array[ 'GPS Position' ]  = $this->Coordinate->formatExifLike();

         switch ( $this->Coordinate->Latitude->getDirection() )
         {
            case 'N':
               $array[ 'GPS Latitude Ref' ] = 'North';
               break;
            default:
               $array[ 'GPS Latitude Ref' ] = 'South';
               break;
         }
         switch ( $this->Coordinate->Longitude->getDirection() )
         {
            case 'E':
               $array[ 'GPS Longitude Ref' ] = 'East';
               break;
            default:
               $array[ 'GPS Longitude Ref' ] = 'West';
               break;
         }

      }

   }

   // </editor-fold>


}

