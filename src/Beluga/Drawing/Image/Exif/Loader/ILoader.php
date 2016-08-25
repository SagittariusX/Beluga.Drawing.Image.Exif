<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Loader\ILoader} interface.
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
 * Interface that should be implemented by each exif data loader.
 *
 * @since v0.1.0
 */
interface ILoader
{
   

   /**
    * Loads all found EXIF data from defined image file.
    *
    * @param string|\Beluga\Web\Url|\Beluga\IO\File $imagefile
    * @return \Beluga\Drawing\Image\Exif\ImageInfo oder NULL
    */
   function load( $imagefile );

   /**
    * Set config values, depending to used loader implementation.
    *
    * @param array $configData
    * @throws \Beluga\ArgumentError If a config value is invalid
    */
   function configure( array $configData );

   /**
    * Gets if the implemeting loader is configured right for execution.
    *
    * @return bool
    */
   function isConfigured();
   

}

