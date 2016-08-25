<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Tags\Photo} class.
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
class Photo
{


   // <editor-fold desc="// = = = =   P U B L I C   F I E L D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * The camera maker ('Make')
    *
    * @var string|null
    */
   public $Make; # <-- 'Make'

   /**
    * The camera model. ('Camera Model Name')
    *
    * @var string|null
    */
   public $CameraModel; # <-- 'Camera Model Name'

   /**
    * The exposure time with format: 1/nnn ("Exposure Time", "Shutter Speed Value", "Shutter Speed")
    *
    * @var string|null
    */
   public $Exposure; # <-- "Exposure Time", "Shutter Speed Value", "Shutter Speed"

   /**
    * The aperture Value ("F Number", "Aperture Value")
    *
    * @var string|null
    */
   public $Aperture; # <-- "F Number", "Aperture Value"

   /**
    * ISO
    *
    * @var int
    */
   public $Iso; # <-- "ISO"

   /**
    * The ID of the used lens. ("Lens ID", "Lens Info")
    *
    * @var string|null
    */
   public $LensID; # <-- "Lens ID", "Lens Info"

   /**
    * The exposure program. ("Exposure Program")
    *
    * @var string|null
    */
   public $ExposureProgram; # <-- "Exposure Program"

   /**
    * The exposure compensation. ("Exposure Compensation")
    *
    * @var string|null
    */
   public $ExposureCompensation; # <-- "Exposure Compensation"

   /**
    * The metering mode. ("Metering Mode")
    *
    * @var string|null
    */
   public $MeteringMode; # <-- "Metering Mode"

   /**
    * Flash
    *
    * @var string|null
    */
   public $Flash; # <-- "Flash"

   /**
    * Focal Length
    *
    * @var string|null
    */
   public $FocalLength; # <-- "Focal Length"

   /**
    * Exposure Mode
    *
    * @var string|null
    */
   public $ExposureMode; # <-- "Exposure Mode"

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   C O N S T R U C T O R   = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Init the current instance from an associative array.
    *
    * This elements will be handled:
    *
    * 'Make', 'Camera Model Name', 'Exposure Time', 'Shutter Speed Value', 'Shutter Speed', 'F Number',
    * 'Aperture Value', 'ISO', 'Lens ID', 'Lens Info', 'Exposure Program', 'Exposure Compensation', 'Metering Mode',
    * 'Flash', 'Focal Length', 'Exposure Mode'
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param  array $data
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
    * 'Make', 'Camera Model Name', 'Exposure Time', 'Shutter Speed Value', 'Shutter Speed', 'F Number',
    * 'Aperture Value', 'ISO', 'Lens ID', 'Lens Info', 'Exposure Program', 'Exposure Compensation', 'Metering Mode',
    * 'Flash', 'Focal Length', 'Exposure Mode'
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param array $data
    */
   public final function initFromArray( array $data )
   {

      $this->Make        = isset( $data[ 'Make' ] ) ? $data[ 'Make' ] : null;
      $this->CameraModel = isset( $data[ 'Camera Model Name' ] ) ? $data[ 'Camera Model Name' ] : null;

      $this->Exposure = isset( $data[ 'Exposure Time' ] )
         ? $data[ 'Exposure Time' ]
         : ( isset( $data[ 'Shutter Speed Value' ] )
            ? $data[ 'Shutter Speed Value' ]
            : ( isset( $data[ 'Shutter Speed' ] )
               ? $data[ 'Shutter Speed' ]
               : null
            )
         );

      $this->Aperture = isset( $data[ 'F Number' ] )
         ? $data[ 'F Number' ]
         : ( isset( $data[ 'Aperture Value' ] )
            ? $data[ 'Aperture Value' ]
            : null
         );

      $this->Iso = isset( $data[ 'ISO' ] ) ? \intval( $data[ 'ISO' ] ) : 0;

      $this->LensID = isset( $data[ 'Lens ID' ] ) ? $data[ 'Lens ID' ] : null;
      if ( \is_null( $this->LensID ) || \preg_match( '~^\d+$~', $this->LensID ) )
      {
         $this->LensID = isset( $data[ 'Lens Info' ] ) ? $data[ 'Lens Info' ] : $this->LensID;
      }

      $this->ExposureProgram = isset( $data[ 'Exposure Program' ] ) ? $data[ 'Exposure Program' ] : null;

      $this->ExposureCompensation = isset( $data[ 'Exposure Compensation' ] )
         ? $data[ 'Exposure Compensation' ]
         : null;

      $this->MeteringMode = isset( $data[ 'Metering Mode' ] ) ? $data[ 'Metering Mode' ] : null;
      $this->Flash        = isset( $data[ 'Flash' ] ) ? $data[ 'Flash' ] : null;
      $this->FocalLength  = isset( $data[ 'Focal Length' ] ) ? $data[ 'Focal Length' ] : null;
      $this->ExposureMode = isset( $data[ 'Exposure Mode' ] ) ? $data[ 'Exposure Mode' ] : null;

   }

   /**
    * Add all current declared elements to $array. They will be added with the keys:
    *
    * 'Make', 'Camera Model Name', 'Exposure Time', 'Shutter Speed Value', 'Shutter Speed', 'F Number',
    * 'Aperture Value', 'ISO', 'Lens ID', 'Lens Info', 'Exposure Program', 'Exposure Compensation',
    * 'Metering Mode', 'Flash', 'Focal Length', 'Exposure Mode'
    *
    * if they are defined
    *
    * @param array $array
    */
   public final function addToArray( array &$array )
   {

      if ( ! \is_null( $this->Make ) || ('' != $this->Make) )
      {
         $array[ 'Make' ] = $this->Make;
      }

      if ( ! \is_null( $this->CameraModel ) || ('' != $this->CameraModel) )
      {
         $array[ 'Camera Model Name' ] = $this->CameraModel;
      }

      if ( ! \is_null( $this->Exposure ) || ('' != $this->Exposure) )
      {
         $array[ 'Exposure Time' ] = $this->Exposure;
         $array[ 'Shutter Speed Value' ] = $this->Exposure;
         $array[ 'Shutter Speed' ] = $this->Exposure;
      }

      if ( !\is_null( $this->Aperture ) || ('' != $this->Aperture) )
      {
         $array[ 'F Number' ] = $this->Aperture;
         $array[ 'Aperture Value' ] = $this->Aperture;
      }

      if ( ! \is_null( $this->Iso ) || (0 < $this->Iso) )
      {
         $array[ 'ISO' ] = $this->Iso;
      }

      if ( ! \is_null( $this->LensID ) || ('' != $this->LensID) )
      {
         $array[ 'Lens ID' ] = $this->LensID;
      }

      if ( ! \is_null( $this->ExposureProgram ) || ('' != $this->ExposureProgram) )
      {
         $array[ 'Exposure Program' ] = $this->ExposureProgram;
      }

      if ( ! \is_null( $this->ExposureCompensation ) || ('' != $this->ExposureCompensation) )
      {
         $array[ 'Exposure Compensation' ] = $this->ExposureCompensation;
      }

      if ( ! \is_null( $this->MeteringMode ) || ('' != $this->MeteringMode) )
      {
         $array[ 'Metering Mode' ] = $this->MeteringMode;
      }

      if ( ! \is_null( $this->Flash ) || ('' != $this->Flash) )
      {
         $array[ 'Flash' ] = $this->Flash;
      }

      if ( ! \is_null( $this->FocalLength ) || ('' != $this->FocalLength) )
      {
         $array[ 'Focal Length' ] = $this->FocalLength;
      }

      if ( ! \is_null( $this->ExposureMode ) || ('' != $this->ExposureMode) )
      {
         $array[ 'Exposure Mode' ] = $this->ExposureMode;
      }

   }

   // </editor-fold>


}

