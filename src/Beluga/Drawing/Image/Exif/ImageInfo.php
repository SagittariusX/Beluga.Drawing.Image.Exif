<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\ImageInfo} class.
 *
 * @author         SagittariusX <unikado+sag@gmail.com>
 * @copyright  (c) 2016, SagittariusX
 * @package        Beluga\Drawing\Image\Exif
 * @since          2016-08-20
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Beluga\Drawing\Image\Exif;


use \Beluga\Drawing\Image\Exif\Tags\{Contact,Copyright,Dates,Gps,Labels,Photo,PictureLocation,Workflow};
use \Beluga\Drawing\Size;
use \Beluga\GIS\Coordinate;
use \Beluga\IO\MimeTypeTool;
use \Beluga\Date\DateTime;
use \Beluga\Web\Url;


/**
 * Contains image information. The format of the data depends to exif tool output format.
 *
 * @since v0.1.0
 */
class ImageInfo
{


   // <editor-fold desc="// = = = =   P U B L I C   F I E L D S   = = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * The absolute image file path.
    *
    * @var string
    */
   public $File;

   /**
    * Optional image source URL.
    *
    * @var \Beluga\Web\Url oder NULL
    */
   public $Url;

   /**
    * The image file creation data.
    *
    * @var \Beluga\Date\DateTime
    */
   public $FileDate;

   /**
    * The image size. ("Image Width" + "Image Height")
    *
    * @var \Beluga\Drawing\Size
    */
   public $Size; # <-- "Image Width" + "Image Height"

   /**
    * The image MIME type. ("MIME Type" or "Format")
    *
    * @var string e.g. 'image/jpeg'
    */
   public $Mimetype; # <-- "MIME Type" or "Format"

   /**
    * The image description. ("Image Description" or "Caption-Abstract" or "Description")
    *
    * @var string
    */
   public $Description; # <-- "Image Description" or "Caption-Abstract" or "Description"

   /**
    * Image copyright info.
    *
    * @var \Beluga\Drawing\Image\Exif\Tags\Copyright
    */
   public $Copyright; # <-- "Copyright", "Copyright Notice", "Rights", "URL", "Usage Terms", "Copyright Flag"

   /**
    * Image keywords als numeric indicated array.
    *
    * @var array
    */
   public $Keywords; # <-- "Keywords" + "Subject" (beide im Format "keyword1, keyword2…")

   /**
    * Image contact info
    *
    * @var \Beluga\Drawing\Image\Exif\Tags\Contact
    */
   public $Contact;

   /**
    * Image location info.
    *
    * @var \Beluga\Drawing\Image\Exif\Tags\PictureLocation
    */
   public $Location;

   /**
    * Image dates.
    *
    * @var \Beluga\Drawing\Image\Exif\Tags\Dates
    */
   public $Dates;

   /**
    * Image workflow info.
    *
    * @var \Beluga\Drawing\Image\Exif\Tags\Workflow
    */
   public $Workflow;

   /**
    * Image GPS location.
    *
    * @var \Beluga\Drawing\Image\Exif\Tags\Gps
    */
   public $Gps;

   /**
    * The 3 image labels ("Object Name", "Label", "Title")
    *
    * @var \Beluga\Drawing\Image\Exif\Tags\Labels
    */
   public $Labels;

   /**
    * The image head line.
    *
    * @var string|null
    */
   public $Headline; # <-- "Headline"

   /**
    * The image category.
    *
    * @var string|null
    */
   public $Category; # <-- "Category"

   /**
    * Other image categories.
    *
    * @var array
    */
   public $OtherCategories; # <-- "Supplemental Categories"

   /**
    * Technical image photo specific info.
    *
    * @var \Beluga\Drawing\Image\Exif\Tags\Photo
    */
   public $Photo;

   /**
    * The image description author.
    *
    * @var string|null
    */
   public $CaptionWriter; # <-- 'Caption Writer' oder 'Writer-Editor'

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   C O N S T R U C T O R   = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Init a new instance.
    *
    * The following key of $data are used:
    *
    * "Image Width", "Image Height", "MIME Type", "Format", "Image Description",
    * "Caption-Abstract", "Description", "Copyright", "Copyright Notice", "Rights",
    * "URL", "Usage Terms", "Copyright Flag", "Keywords", "Subject", 'Creator',
    * 'Artist', 'By-line', 'Authors Position', 'By-line Title', 'Creator Address',
    * 'Creator City', 'Creator Region', 'Creator Postal Code', 'Creator Country',
    * 'Creator Work Telephone', 'Creator Work Email', 'Creator Work URL',
    * 'Location', 'Sub-location', 'State', 'Province-State', 'Country Code',
    * 'Country-Primary Location Code', 'City', 'Country', 'Country-Primary Location Name',
    * 'Intellectual Genre', 'Scene', 'Modify Date', 'Date/Time Original',
    * 'Create Date', 'Date Created', 'Date/Time Created', 'Digital Creation Date/Time',
    * 'Digital Creation Date', 'Digital Creation Time', 'Instructions',
    * 'Special Instructions', 'Transmission Reference', 'Original Transmission Reference',
    * 'Credit', 'Source', 'GPS Latitude', 'GPS Longitude', 'GPS Position',
    * 'GPS Latitude Ref ', 'GPS Longitude Ref', 'Object Name', 'Label', 'Title',
    * "Headline", "Category", "Supplemental Categories", 'Make', 'Camera Model Name',
    * 'Exposure Time', 'Shutter Speed Value', 'Shutter Speed', 'F Number',
    * 'Aperture Value', 'ISO', 'Lens ID', 'Lens Info', 'Exposure Program',
    * 'Exposure Compensation', 'Metering Mode', 'Flash', 'Focal Length',
    * 'Exposure Mode', 'Caption Writer', 'Writer-Editor'
    *
    * @param array           $data
    * @param string          $file
    * @param \Beluga\Web\Url $url  Optional image source url
    */
   public function __construct( array $data, $file, Url $url = null )
   {

      // File
      $this->File = ! empty( $data[ 'Image-File' ] ) ? $data[ 'Image-File' ] : $file;

      // Url
      $this->Url = $url;

      // FileDate
      $this->FileDate = DateTime::FromFile( $file );

      // Size
      if ( ! empty( $data['Image Width'] ) && ! empty( $data['Image Height'] ) )
      {
         $this->Size = new Size(
            \intval( $data[ 'Image Width' ] ),
            \intval( $data[ 'Image Height' ] )
         );
      }
      else
      {
         $this->Size = Size::FromImageFile( $file );
      }

      // Mimetype
      $this->Mimetype = ! empty( $data[ 'MIME Type' ] )
         ? $data[ 'MIME Type' ]
         : ( ! empty( $data[ 'Format' ] ) ? $data[ 'Format' ] : null );
      if ( empty( $this->Mimetype ) )
      {
         $this->Mimetype = MimeTypeTool::GetByFileName( $file );
      }

      // Description
      $this->Description = ! empty( $data[ 'Description' ] )
         ? $data[ 'Description' ]
         : ( ! empty( $data[ 'Image Description' ] )
            ? $data[ 'Image Description' ]
            : ( ! empty( $data[ 'Caption-Abstract' ] )
               ? $data[ 'Caption-Abstract' ] : null )
         );

      // Copyright
      $this->Copyright = new Copyright( $data );

      // Keywords
      $this->Keywords = array();
      if ( ! empty( $data[ 'Keywords' ] ) )
      {
         $tmpArray = \explode( ',', $data[ 'Keywords' ] );
         $this->Keywords = array();
         for( $i = 0; $i < \count( $tmpArray ); ++$i )
         {
            $item = \trim( $tmpArray[ $i ] );
            if ( $item === '' )
            {
               continue;
            }
            $this->Keywords[] = $item;
         }
      }
      if ( ! empty( $data[ 'Subject' ] ) )
      {
         $tmpArray1 = \explode( ',', $data[ 'Subject' ] );
         $tmpArray2 = array();
         for( $i = 0; $i < \count( $tmpArray1 ); ++$i )
         {
            $item = \trim( $tmpArray1[ $i ] );
            if ( $item === '' )
            {
               continue;
            }
            $tmpArray2[] = $item;
         }
         $this->Keywords = \array_merge( $this->Keywords, $tmpArray2 );
      }
      $this->Keywords = array_map( '\trim', $this->Keywords );
      $this->Keywords = \array_intersect_key(
         $this->Keywords,
         \array_unique( \array_map( '\strtolower', $this->Keywords ) )
      );

      // Contact
      $this->Contact = new Contact( $data );

      // Location
      $this->Location = new PictureLocation( $data );

      // Dates
      $this->Dates = new Dates( $data );

      // Workflow
      $this->Workflow = new Workflow($data);

      // Gps
      $this->Gps = new Gps( $data );

      // Labels
      $this->Labels = new Labels( $data );

      // Headline
      $this->Headline = ! empty( $data[ 'Headline' ] ) ? $data[ 'Headline' ] : null;

      // Category
      $this->Category = ! empty( $data[ 'Category' ] ) ? $data[ 'Category' ] : null;

      // OtherCategories
      $this->OtherCategories = ! empty( $data[ 'Supplemental Categories' ] )
         ? \explode( ', ', $data[ 'Supplemental Categories' ] )
         : array();
      $this->OtherCategories = \array_map( '\trim', $this->OtherCategories );

      // Photo
      $this->Photo         = new Photo( $data );

      // CaptionWriter
      $this->CaptionWriter = ! empty( $data[ 'Caption Writer' ] )
         ? $data[ 'Caption Writer' ]
         : ( ! empty( $data[ 'Writer-Editor' ] )
            ? $data[ 'Writer-Editor' ] : null
         );

   }

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   M E T H O D S   = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Gets all defined data as 1-dimensional associative array.
    *
    * Keys are:
    *
    * "Image Width", "Image Height", "MIME Type", "Format", "Image Description", "Caption-Abstract", "Description",
    * "Copyright", "Copyright Notice", "Rights", "URL", "Usage Terms", "Copyright Flag", "Keywords", "Subject",
    * 'Creator', 'Artist', 'By-line', 'Authors Position', 'By-line Title', 'Creator Address', 'Creator City',
    * 'Creator Region', 'Creator Postal Code', 'Creator Country', 'Creator Work Telephone', 'Creator Work Email',
    * 'Creator Work URL', 'Location', 'Sub-location', 'State', 'Province-State', 'Country Code',
    * 'Country-Primary Location Code', 'City', 'Country', 'Country-Primary Location Name', 'Intellectual Genre',
    * 'Scene', 'Modify Date', 'Date/Time Original', 'Create Date', 'Date Created', 'Date/Time Created',
    * 'Digital Creation Date/Time', 'Digital Creation Date', 'Digital Creation Time', 'Instructions',
    * 'Special Instructions', 'Transmission Reference', 'Original Transmission Reference', 'Credit', 'Source',
    * 'GPS Latitude', 'GPS Longitude', 'GPS Position', 'GPS Latitude Ref ', 'GPS Longitude Ref', 'Object Name', 'Label',
    * 'Title', "Headline", "Category", "Supplemental Categories", 'Make', 'Camera Model Name', 'Exposure Time',
    * 'Shutter Speed Value', 'Shutter Speed', 'F Number', 'Aperture Value', 'ISO', 'Lens ID', 'Lens Info',
    * 'Exposure Program', 'Exposure Compensation', 'Metering Mode', 'Flash', 'Focal Length', 'Exposure Mode',
    * 'Caption Writer', 'Writer-Editor'
    *
    * @return array
    */
   public final function toArray()
   {

      $result = array(
         'Image Width'  => $this->Size->Width,
         'Image Height' => $this->Size->Height
      );

      if ( ! empty( $this->Mimetype ) )
      {
         $result[ 'MIME Type' ] = $this->Mimetype;
         $result[ 'Format' ]    = $this->Mimetype;
      }

      if ( ! empty( $this->Description ) )
      {
         $result[ 'Description' ]       = $this->Description;
         $result[ 'Image Description' ] = $this->Description;
         $result[ 'Caption-Abstract' ]  = $this->Description;
      }

      if ( \count( $this->Keywords ) > 0 )
      {
         $result[ 'Keywords' ] = \join( ', ', $this->Keywords );
         $result[ 'Subject' ]  = $result[ 'Keywords' ];
      }

      $result[ 'Image-File' ] = $this->File;
      $this->Contact->addToArray( $result );
      $this->Location->addToArray( $result );
      $this->Dates->addToArray( $result );
      $this->Workflow->addToArray( $result );
      $this->Gps->addToArray( $result );
      $this->Labels->addToArray( $result );

      if ( ! empty( $this->Headline ) )
      {
         $result[ 'Headline' ] = $this->Headline;
      }

      if ( ! empty( $this->Category ) )
      {
         $result[ 'Category' ] = $this->Category;
      }

      if ( \count( $this->OtherCategories ) > 0 )
      {
         $result[ 'Supplemental Categories' ] = \join( ', ', $this->OtherCategories );
      }

      $this->Photo->addToArray( $result );

      if ( ! empty( $this->CaptionWriter ) )
      {
         $result[ 'Caption Writer' ] = $this->CaptionWriter;
         $result[ 'Writer-Editor' ]  = $this->CaptionWriter;
      }

      return $result;

   }

   private function encode( $str )
   {

      $out = '';

      for ( $i = 0; $i < \strlen( $str ); ++$i )
      {
         $char = $str[ $i ];
         if ( \mt_rand( 0, 2 ) < 1 )
         {
            $out .= $char;
         }
         else
         {
            $out .= '&#' . \ord( $char ) . ';';
         }
      }

      return $out;

   }

   public final function toInfoArray( $showModel = true, $datetimeFormat = 'Y-m-d H:i' )
   {

      $result = array();
      $autor = $this->Contact->Author;

      if ( empty( $autor ) )
      {
         $autor = $this->CaptionWriter;
      }

      if ( ! empty( $autor ) )
      {
         $result['Autor'] = $this->encode( $autor );
      }

      $oldestDate = $this->Dates->getOldest();

      if ( ! \is_null( $oldestDate ) )
      {
         $result[ 'Datum' ] = $oldestDate->format( $datetimeFormat );
      }
      else
      {
         $result[ 'Datum' ] = DateTime::FromFile( $this->File )->format( $datetimeFormat );
      }

      if ( $showModel )
      {
         if ( ! empty( $this->Photo->CameraModel ) )
         {
            $result[ 'Kamera' ] = $this->Photo->CameraModel;
         }
         else if ( ! empty( $this->Photo->Make ) )
         {
            $result[ 'Kamera' ] = $this->Photo->Make;
         }
      }

      if ( ! empty( $this->Photo->LensID ) )
      {
         $result[ 'Objektiv' ] = $this->Photo->LensID;
      }

      if ( ! empty( $this->Photo->Aperture ) )
      {
         $result[ 'Blende' ] = $this->Photo->Aperture;
      }

      if ( ! empty( $this->Photo->FocalLength ) )
      {
         $result[ 'Brennw.' ] = $this->Photo->FocalLength;
      }

      if ( ! empty( $this->Photo->Iso ) )
      {
         $result[ 'ISO' ] = $this->Photo->Iso;
      }

      if ( ! empty( $this->Photo->Exposure ) )
      {
         $result[ 'Bel.-zeit' ] = $this->Photo->Exposure . ' Sek.';
      }

      return $result;

   }

   public final function toMetaDataArray( $showModel = true, $datetimeFormat = 'Y-m-d H:i' )
   {

      $result = array();

      if ( ! empty( $this->Description ) )
      {
         $result[ 'Beschreibung' ] = $this->Description;
      }

      if ( \count( $this->Keywords ) > 0 )
      {
         $result[ 'Keywords' ] = \join( ', ', $this->Keywords );
      }

      if ( ! \is_null( $this->Dates->LastModified ) && ( $this->Dates->LastModified instanceof \DateTimeInterface ) )
      {
         $array[ 'Datum - Letzte Änderung' ] = $this->Dates->LastModified->format( $datetimeFormat );
      }

      if ( ! \is_null( $this->Dates->Created ) && ( $this->Dates->Created instanceof \DateTimeInterface ) )
      {
         $array[ 'Datum - Erstellung' ] = $this->Dates->Created->format( $datetimeFormat );
      }

      if ( ! \is_null( $this->Dates->Digitized ) && ( $this->Dates->Digitized instanceof \DateTimeInterface ) )
      {
         $array[ 'Datum - Digitalisierung' ] = $this->Dates->Digitized->format( $datetimeFormat );
      }

      if ( ! empty( $this->Labels->Label ) )
      {
         $array[ 'Label' ] = $this->Labels->Label;
      }

      if ( ! empty( $this->Labels->Title ) )
      {
         $array[ 'Titel' ] = $this->Labels->Title;
      }

      if ( ! empty( $this->Headline ) )
      {
         $result[ 'Kopfzeile' ] = $this->Headline;
      }

      if ( ! empty( $this->Contact->Author ) )
      {
         $array[ 'Autor' ] = $this->encode( $this->Contact->Author );
      }

      if ( ! empty( $this->Contact->Country ) )
      {
         $array[ 'Autor - Land' ] = $this->Contact->Country;
      }

      if ( \count( $this->Contact->Urls ) > 0 )
      {
         $res = '';
         $i = 0;
         foreach ( $this->Contact->Urls as $url )
         {
            if ( $i > 0 )
            {
               $res .= ', ';
            }
            else
            {
               ++$i;
            }
            $res .= '<a href="' . $url . '">' . $url . '</a>';
         }
         $array[ 'Autor - URLs' ] = $res;
      }

      if ( ! empty( $this->Location->City ) )
      {
         $array[ 'Location - Stadt' ] = $this->Location->City;
      }

      if ( ! empty( $this->Location->Region ) )
      {
         $array[ 'Location - Region' ] = $this->Location->Region;
      }

      if ( ! empty( $this->Location->State ) )
      {
         $array[ 'Location - Bundesland' ] = $this->Location->State;
      }

      if ( ! empty( $this->Location->CountryCode ) )
      {
         $array[ 'Location - Ländercode' ] = $this->Location->CountryCode;
      }

      if ( ! empty( $this->Location->Country ) )
      {
         $array[ 'Location-Land' ] = $this->Location->Country;
      }

      if ( ! \is_null( $this->Gps->Coordinate )
        && ( $this->Gps->Coordinate instanceof Coordinate )
        && $this->Gps->Coordinate->isValid() )
      {
         $array[ 'GPS - Latitude' ] = $this->Gps->Coordinate->Latitude->formatDMS();
         $array[ 'GPS - Longitude' ] = $this->Gps->Coordinate->Longitude->formatDMS();
      }

      if ( ! empty( $this->Category ) )
      {
         $result[ 'Kategorie' ] = $this->Category;
      }

      if ( \count( $this->OtherCategories ) > 0 )
      {
         $result[ 'Andere Kategorien' ] = \join( ', ', $this->OtherCategories );
      }

      if ( $showModel && ! empty( $this->Photo->Make ) )
      {
         $array[ 'Make' ] = $this->Photo->Make;
      }

      if ( $showModel && ! empty( $this->Photo->CameraModel ) )
      {
         $array[ 'Model' ] = $this->Photo->CameraModel;
      }

      if ( ! empty( $this->Photo->Exposure ) )
      {
         $array[ 'Belichtungszeit' ] = $this->Photo->Exposure . ' Sek.';
      }

      if ( ! empty( $this->Photo->Aperture ) )
      {
         $array[ 'Blende' ] = 'f/' . $this->Photo->Aperture;
      }

      if ( ! \is_null( $this->Photo->Iso ) || (0 < $this->Photo->Iso) )
      {
         $array[ 'ISO' ] = $this->Photo->Iso;
      }

      if ( ! empty( $this->Photo->LensID ) )
      {
         $array[ 'Objektiv/Linse' ] = $this->Photo->LensID;
      }

      if ( ! empty( $this->Photo->ExposureProgram ) )
      {
         $array[ 'Belichtungsprogram' ] = $this->Photo->ExposureProgram;
      }

      if ( ! empty( $this->Photo->ExposureCompensation ) )
      {
         $array[ 'Belichtungsausgleich' ] = $this->Photo->ExposureCompensation;
      }

      if ( ! empty( $this->Photo->MeteringMode ) )
      {
         $array[ 'Messmodus' ] = $this->Photo->MeteringMode;
      }

      if ( ! empty( $this->Photo->Flash ) )
      {
         $array[ 'Blitz' ] = $this->Photo->Flash;
      }

      if ( ! empty( $this->Photo->FocalLength ) )
      {
         $array[ 'Brennweite' ] = $this->Photo->FocalLength;
      }

   }

   public final function getCopyrightText()
   {

      if ( ! empty( $this->Copyright->Notice ) )
      {
         return $this->Copyright->Notice;
      }

      $result = '©' . $this->Dates->getOldest()->getYear();

      if ( ! \is_null( $this->Contact->Email ) )
      {
         return ( $result . ' ' . $this->Contact->Email );
      }

      if ( ! empty( $this->Contact->Author ) )
      {
         return ( $result . ' ' . $this->Contact->Author );
      }

      if ( ! empty( $this->CaptionWriter ) )
      {
         return ( $result . ' ' . $this->CaptionWriter );
      }

      return $result;

   }

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   S T A T I C   M E T H O D S   = = = = = = = = = = = = = = = = = =">

   /**
    * @param  string $jsonStr
    * @param  string $imageFile
    * @return \Beluga\Drawing\Image\Exif\ImageInfo oder NULL
    */
   public static function ParseJSON( $jsonStr, $imageFile )
   {

      if ( empty( $jsonStr ) )
      {
         return null;
      }

      try
      {
         $array = \json_decode( $jsonStr, true );
         if ( ! \is_array( $array ) )
         {
            return null;
         }
         return new self( $array, $imageFile );
      }
      catch ( \Exception $ex ) { $ex = null; return null; }

   }

   // </editor-fold>


}

