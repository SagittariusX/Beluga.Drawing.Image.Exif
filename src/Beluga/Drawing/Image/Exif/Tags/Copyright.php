<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Tags\Copyright} class.
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


use \Beluga\Web\Url;


/**
 * @since v0.1
 */
class Copyright
{

   
   // <editor-fold desc="// = = = =   P U B L I C   F I E L D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * The copyright text (Fields: 'Copyright' or 'Copyright Notice' or 'Rights' )
    *
    * @var string
    */
   public $Notice; # <-- 'Copyright' oder 'Copyright Notice' oder 'Rights'

   /**
    * The optional copyright URL.
    *
    * @var \Beluga\Web\Url oder NULL
    */
   public $InfoUrl; # <-- 'URL'

   /**
    * The optional copyright 'Usage Terms'.
    *
    * @var string|null
    */
   public $UsageTerms; # <-- 'Usage Terms'

   /**
    * Copyright Flag
    *
    * @var bool
    */
   public $Flag; # <-- 'Copyright Flag'

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   C O N S T R U C T O R   = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Inits a new instance.
    *
    * @param  array $data Daten zur Initialisierung. Mögliche verwertete Keys sind 'Copyright', 'Copyright Notice',
    *                     'Rights', 'URL', 'Usage Terms', 'Copyright Flag'
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
    * 'Copyright' or 'Copyright Notice' or 'Rights'
    * and optional 'URL', 'Usage Terms', 'Copyright Flag'.
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param array $array
    */
   public final function initFromArray( array $array )
   {

      $this->Notice = isset( $array[ 'Copyright' ] )
         ? $array[ 'Copyright' ]
         : ( isset( $array[ 'Copyright Notice' ] )
            ? $array[ 'Copyright Notice' ]
            : ( isset( $array[ 'Rights' ] )
               ? $array[ 'Rights' ]
               : null
            )
         );

      $this->InfoUrl = isset( $array[ 'URL' ] ) ? Url::Parse( $array[ 'URL' ] ) : null;
      $this->UsageTerms = isset( $array[ 'Usage Terms' ] ) ? $array[ 'Usage Terms' ] : null;
      $this->Flag = isset( $array[ 'Copyright Flag' ] ) ? ( 'True' === $array[ 'Copyright Flag' ] ) : false;

   }

   /**
    * Add all current declared elements to $array. They will be added with the keys:
    *
    * 'Copyright', 'Copyright Notice', 'Rights', 'URL', 'Usage Terms', 'Copyright Flag'
    *
    * if they are defined
    *
    * @param array $array The reference to the array where the data should be added.
    */
   public final function addToArray( array &$array )
   {

      $array[ 'Copyright' ]        = $this->Notice;
      $array[ 'Copyright Notice' ] = $this->Notice;
      $array[ 'Rights' ]           = $this->Notice;
      
      if ( ! \is_null( $this->InfoUrl ) && ( $this->InfoUrl instanceof \Beluga\Web\Url ) )
      {
         $array[ 'URL' ] = (string) $this->InfoUrl;
      }
      
      if ( ! \is_null( $this->UsageTerms ) && '' != $this->UsageTerms )
      {
         $array[ 'Usage Terms' ] = $this->UsageTerms;
      }
      
      if ( $this->Flag )
      {
         $array[ 'Copyright Flag' ] = 'True';
      }

   }

   // </editor-fold>


}

