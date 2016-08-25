<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Loader\Exiftool} class.
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


use \Beluga\ArgumentError;
use \Beluga\Drawing\Image\Exif\ImageInfo;


/**
 * Allow the loading of EXIF data via the external exiftool commandline utility.
 *
 * The exiftool must be installed for it!
 *
 * @since v0.1.0
 */
class Exiftool implements ILoader
{


   # <editor-fold desc="= = =   P R I V A T E   F I E L D S   = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * The path of the exiftool binary.
    *
    * @var string
    */
   private $path;

   // </editor-fold>


   # <editor-fold desc="= = =   P U B L I C   C O N S T U C T O R   = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Inits a new instance.
    */
   public function __construct()
   {

      $this->path = $this->find();

   }

   // </editor-fold>


   # <editor-fold desc="= = =   P R I V A T E   M E T H O D S   = = = = = = = = = = = = = = = = = = = = = = = = =">

   private function find()
   {

      $file = 'exiftool';

      if ( \is_executable( $file ) )
      {
         return $file;
      }

      if ( \DIRECTORY_SEPARATOR === '\\' )
      {

         $file2 = 'exiftool.exe';

         $path = 'C:\\Windows\\' . $file;
         if ( \is_executable( $path ) )
         {
            return $path;
         }

         $path = 'C:\\Windows\\' . $file2;
         if ( \is_executable( $path ) )
         {
            return $path;
         }

         $path = 'C:\\Program Files\\exiftool\\' . $file;
         if ( \is_executable( $path ) )
         {
            return $path;
         }

         $path = 'C:\\Program Files\\exiftool\\' . $file2;
         if ( \is_executable( $path ) )
         {
            return $path;
         }

         // Get By Environment paths

         $envPath = isset( $_ENV[ 'PATH' ] )
            ? $_ENV[ 'PATH' ]
            : ( isset( $_ENV[ 'Path' ] )
               ? $_ENV[ 'Path' ]
               : null
            );

         if ( ! empty( $envPath ) )
         {
            $pathElements = \explode( \PATH_SEPARATOR, $envPath );
            foreach ( $pathElements as $pathElement )
            {
               if ( ( '.' === $pathElement ) || ( '..' === $pathElement ) )
               {
                  continue;
               }
               if ( ! \is_dir( $pathElement ) )
               {
                  continue;
               }
               $path = rtrim( $pathElement, '\\/' ) . \DIRECTORY_SEPARATOR . $file;
               if ( \is_executable( $path ) )
               {
                  return $path;
               }
               $path = rtrim( $pathElement, '\\/' ) . \DIRECTORY_SEPARATOR . $file2;
               if ( \is_executable( $path ) )
               {
                  return $path;
               }
            }
         }

         $old = \chdir( 'C:\\' );
         $lines = \explode( "\n", \str_replace( "\r\n", "\n", \trim( `dir $file2 /s 2>&1` ) ) );
         \chdir( $old );
         $found = array( 'primary' => '', 'programs' => '' );
         $m = null;
         for ( $i = 0; $i < \count( $lines ); ++$i )
         {
            if ( ! empty( $found[ 'primary' ] ) && ! empty( $found[ 'programs' ] ) )
            {
               break;
            }
            $line = \trim( $lines[ $i ] );
            if ( '' === $line )
            {
               continue;
            }
            if ( empty( $found[ 'primary' ] ) && \preg_match( '~(c:\\\\.+?exiftool)$~i', $line, $m ) )
            {
               $found[ 'primary' ] = \rtrim( $m[ 1 ], '\\' ) . '\\' . $file;
               continue;
            }
            if ( empty( $found[ 'programs' ] ) && \preg_match( '~(c:\\\\program.+)$~i', $line, $m ) )
            {
               $found[ 'programs' ] = \rtrim( $m[ 1 ], '\\' ) . '\\' . $file;
            }
         }
         if ( ! empty( $found[ 'primary' ] ) )
         {
            return $found[ 'primary' ];
         }
         if ( ! empty( $found[ 'programs' ] ) )
         {
            return $found[ 'programs' ];
         }
         return null;
      }

      $path = '/usr/bin/' . $file;
      if ( \is_executable( $path ) )
      {
         return $path;
      }

      $path = '/bin/' . $file;
      if ( \is_executable( $path ) )
      {
         return $path;
      }

      $value = \trim( `witch $file 2>&1` );
      if ( ('' !== $value) || ! \preg_match( '~not found~i', $value ) )
      {
         return $value;
      }

      return null;

   }

   // </editor-fold>


   # <editor-fold desc="= = =   P U B L I C   M E T H O D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Set config values, depending to used loader implementation.
    *
    * @param array $configData
    * @throws \Beluga\ArgumentError If a config value is invalid
    */
   public function configure( array $configData )
   {

      if ( empty( $configData[ 'path' ] ) )
      {
         throw new ArgumentError(
            '$configData',
            $configData,
            'Drawing.Image.Exif.Loader',
            "Missing 'path' for exiftool executable"
         );
      }

      if ( ! \file_exists( $configData[ 'path' ] ) )
      {
         if ( ! \is_executable( $configData[ 'path' ] ) )
         {
            throw new ArgumentError(
               'configData[\'path\']',
               $configData[ 'path' ],
               'Drawing.Image.Exif.Loader',
               "Defined 'path' dont points to a exiftool executable!"
            );
         }
         $this->path = $configData[ 'path' ];
      }
      else if ( ! \is_executable( $configData[ 'path' ] ) )
      {
         throw new ArgumentError(
            'configData[\'path\']',
            $configData[ 'path' ],
            'Drawing.Image.Exif.Loader',
            "Defined 'path' dont points to a exiftool executable!"
         );
      }
      else
      {
         $this->path = $configData[ 'path' ];
      }

   }

   /**
    * Gets if the implemeting loader is configured right for execution.
    *
    * @return bool
    */
   public function isConfigured()
   {

      return ! empty( $this->path );

   }

   /**
    * Loads all found EXIF data from defined image file.
    *
    * @param string|\Beluga\Web\Url|\Beluga\IO\File $imageFile
    * @return \Beluga\Drawing\Image\Exif\ImageInfo oder NULL
    */
   public function load( $imageFile )
   {

      if ( ! $this->isConfigured() )
      {
         return null;
      }

      if ( ! \file_exists( $imageFile ) )
      {
         return null;
      }

      if ( ! \is_readable( $imageFile ) )
      {
         return null;
      }

      $file = \Beluga\strContains( $imageFile, ' ' ) ? ('"' . $imageFile . '"') : $imageFile;

      try
      {

         $output = `$this->path $file`;
         $lines = \explode( "\n", \str_replace( [ "\r\n", "\r" ], [ "\n", "\n" ], $output ) );
         $array = [];
         for ( $i = 0, $c = \count( $lines ); $i < $c; ++$i )
         {
            $line = \trim( $lines[ $i ] );
            if ( '' === $line )
            {
               continue;
            }
            $tmp = \explode( ':', $line, 2 );
            if ( \count( $tmp ) != 2 )
            {
               continue;
            }
            $tmp[ 0 ] = \trim( $tmp[ 0 ] );
            if ( isset( $array[ $tmp[ 0 ] ] ) )
            {
               continue;
            }
            $array[ $tmp[ 0 ] ] = \trim( $tmp[ 1 ] );
         }

         return new ImageInfo( $array, $imageFile );

      }
      catch ( \Throwable $ex )
      {
         $ex = null;
         return null;
      }

   }

   // </editor-fold>


}

