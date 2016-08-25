<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Loader\JSon} class.
 *
 * @author         SagittariusX <unikado+sag@gmail.com>
 * @copyright  (c) 2016, SagittariusX
 * @package        Beluga\Drawing\Image\Exif
 * @since          2016-08-20
 * @subpackage     Loader
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Beluga\Drawing\Image\Exif\Loader;


use \Beluga\Drawing\Image\Exif\ImageInfo;
use \Beluga\IO\File;


/**
 * Loads EXIF data from an JSON sidecar file in relation to the image file.
 *
 * <code>
 * # Image File   :  /foo/bar/bar/image.jpg
 * # => JSON File :  /foo/bar/bar/image.jpg.json
 * #    or        :  /foo/bar/bar/image.json
 * </code>
 *
 * @since v0.1.0
 */
class JSon implements ILoader
{

   
   # <editor-fold desc="= = =   P U B L I C   C O N S T U C T O R   = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Inits a new instance.
    */
   public function __construct() { }

   // </editor-fold>

   
   # <editor-fold desc="= = =   P U B L I C   M E T H O D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Set config values, depending to used loader implementation.
    *
    * @param array $configData
    * @throws \Beluga\ArgumentError If a config value is invalid
    */
   public function configure( array $configData ) { }

   /**
    * Gets if the implemeting loader is configured right for execution.
    *
    * @return bool
    */
   public function isConfigured() { return true; }

   /**
    * Loads all found EXIF data from defined image file.
    *
    * @param string|\Beluga\Web\Url|\Beluga\IO\File $imageFile
    * @return \Beluga\Drawing\Image\Exif\ImageInfo oder NULL
    */
   public function load( $imageFile )
   {

      if ( ! \file_exists( $imageFile ) )
      {
         // Do nothing if the defined image file does not exist.
         return null;
      }

      // Build the first case of a usable JSON file path (/origin/image.jpg.json)
      $jsonFile = $imageFile . '.json';

      if ( ! \file_exists( $jsonFile ) )
      {

         // The first case JSON file does not exist
         // Build the second case of a usable JSON file path (/origin/image.json)
         $jsonFile = File::ChangeExtension( $imageFile, 'json' );

         if ( ! \file_exists( $jsonFile ) )
         {
            // Do nothing because the required JSON file does not exist
            return null;
         }

      }

      // OK: Now we have a usable image + JSON file.

      try
      {

         // read + parse the JSON data from file
         $data = \json_decode( \file_get_contents( $jsonFile ), true );

         if ( ! \is_array( $data ) || \count( $data ) < 1 )
         {
            // Uuhhh, wrong JSON file format or content. So we are done here
            return null;
         }

         // Return the resulting ImageInfo instance
         return new ImageInfo( $data, $imageFile );

      }
      catch ( \Throwable $ex )
      {
         // Bad news: The parsing of the JSON file fails :-(
         $ex = null;
         return null;
      }

   }

   // </editor-fold>

   
}

