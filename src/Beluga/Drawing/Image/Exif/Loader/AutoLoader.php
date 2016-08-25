<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Loader\AutoLoader} class.
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


/**
 * Static EXIF data loader helper class
 *
 * @since v0.1.0
 */
abstract class AutoLoader
{


   /**
    * Gets the image exif data by calling ExifTool, ExiV2, PHP-Plain, and JSon loaders (in this order)
    *
    * The first Loader that returns usable data is used.
    *
    * @param string $imageFile
    * @param string $exiftoolPath
    * @param string $exiv2Path
    * @return \Beluga\Drawing\Image\Exif\ImageInfo|NULL
    */
   public static function Load( string $imageFile, $exiftoolPath = null, $exiv2Path = null )
   {

      $loader = new Exiftool();

      if ( ! $loader->isConfigured() && ! empty( $exiftoolPath ) )
      {
         try { $loader->configure( [ 'path' => $exiftoolPath ] ); }
         catch ( \Throwable $ex ) { $ex = null; }
      }

      if ( $loader->isConfigured() )
      {
         try { return $loader->load( $imageFile ); }
         catch ( \Throwable $ex ) { $ex = null; }
      }

      $loader1 = new ExiV2();

      if ( ! $loader1->isConfigured() && ! empty( $exiv2Path ) )
      {
         try { $loader1->configure( [ 'path' => $exiv2Path ] ); }
         catch ( \Throwable $ex ) { $ex = null; }
      }
      if ( $loader1->isConfigured() )
      {
         try { return $loader1->load( $imageFile ); }
         catch ( \Throwable $ex ) { $ex = null; }
      }

      $loader2 = new PHP();
      try { return $loader2->load( $imageFile ); }
      catch ( \Throwable $ex ) { $ex = null; }

      $loader3 = new JSon();
      try { return $loader3->load( $imageFile ); }
      catch ( \Throwable $ex ) { $ex = null; }

      return null;


   }

}

