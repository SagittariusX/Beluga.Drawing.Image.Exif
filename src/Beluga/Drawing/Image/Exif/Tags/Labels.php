<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\Tags\Labels} class.
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
 * Fast die 3 Label/Title Möglichkeiten aus Exif + IPTC zusammen
 *
 * @since v0.1
 */
class Labels
{


   // <editor-fold desc="// = = = =   P U B L I C   F I E L D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Object Name
    *
    * @var string
    */
   public $ObjectName;

   /**
    * Label element
    *
    * @var string
    */
   public $Label;

   /**
    * IPTC "Title" element
    *
    * @var string
    */
   public $Title;

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   C O N S T R U C T O R   = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Init the current instance from an associative array.
    *
    * This elements will be handled:
    *
    * 'Label', 'Title', 'Object-Name'
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param  array $data
    */
   public function __construct( array $data = [ ] )
   {

      $this->initFromArray( $data );

   }

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   M E T H O D S   = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Gets the label value, found first from list of $preferes. If no list is defined
    * [ 'Label', 'Title', 'ObjectName' ] is used.
    *
    * @param  array $preferes
    * @return string
    */
   public final function getPreferedLabel( array $preferes = null )
   {

      if ( ! \is_array( $preferes ) || \count( $preferes ) < 1 )
      {
         $preferes = [ 'label', 'title', 'object' ];
      }

      foreach ( $preferes as $pref )
      {
         switch ( \strtolower( $pref ) )
         {
            case 'object':
            case 'objekt':
            case 'name':
            case 'objectname':
            case 'objektname':
            case 'object-name':
            case 'objekt-name':
            case 'object.name':
            case 'objekt.name':
            case 'object name':
            case 'objekt name':
               if ( ! \is_null( $this->ObjectName ) && '' != $this->ObjectName )
               {
                  return $this->ObjectName;
               }
               break;
            case 'label':
            case 'etikett':
            case 'beschriftung':
            case 'aufschrift':
               if ( ! \is_null( $this->Label ) && '' != $this->Label )
               {
                  return $this->Label;
               }
               break;
            case 'title':
            case 'titel':
            case 'überschrift':
            case 'ueberschrift':
            case 'bezeichnung':
               if ( ! \is_null( $this->Title ) && '' != $this->Title )
               {
                  return $this->Title;
               }
               break;
            default:
               break;
         }
      }

      if ( ! \is_null( $this->Label ) && '' != $this->Label )
      {
         return $this->Label;
      }

      if ( ! \is_null( $this->Title ) && '' != $this->Title )
      {
         return $this->Title;
      }

      if ( ! \is_null( $this->ObjectName ) )
      {
         return $this->ObjectName;
      }

      return '';

   }

   /**
    * @return string
    */
   public final function __toString()
   {

      return $this->getPreferedLabel();

   }

   /**
    * Init the current instance from an associative array.
    *
    * This elements will be handled:
    *
    * 'Label', 'Title', 'Object-Name'
    *
    * If one of the elements is not defined it will be declared by a NULL value.
    *
    * @param array $data
    */
   public final function initFromArray( array $data )
   {

      $this->Label = isset( $data[ 'Label' ] ) ? $data[ 'Label' ] : null;
      $this->Title = isset( $data[ 'Title' ] ) ? $data[ 'Title' ] : null;
      $this->ObjectName = isset( $data[ 'Object-Name' ] )
         ? $data[ 'Object-Name' ]
         : ( isset( $data[ 'Object Name' ] )
            ? $data[ 'Object Name' ]
            : null );

   }

   /**
    * Add all current declared elements to $array. They will be added with the keys:
    *
    * 'Label', 'Title', 'Object-Name'
    *
    * if they are defined
    *
    * @param array $array The reference to the array where the data should be added.
    */
   public final function addToArray( array &$array )
   {

      if ( ! \is_null( $this->Label )      && '' != $this->Label )
      {
         $array[ 'Label' ] = $this->Label;
      }

      if ( ! \is_null( $this->Title )      && '' != $this->Title )
      {
         $array[ 'Title' ] = $this->Title;
      }

      if ( ! \is_null( $this->ObjectName ) && '' != $this->ObjectName )
      {
         $array[ 'Object-Name' ] = $this->ObjectName;
      }

   }

   // </editor-fold>


}

