<?php
/**
 * This file defines the {@see \Beluga\Drawing\Image\Exif\ImageInfoLocaleConverter} class.
 *
 * @author         SagittariusX <unikado+sag@gmail.com>
 * @copyright  (c) 2016, SagittariusX
 * @package        Beluga\Drawing\Image\Exif
 * @since          2016-08-20
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Beluga\Drawing\Image\Exif;


/**
 * A static internal helper for convert EXIF image data into different languages, and back.
 *
 * @since v0.1
 */
abstract class ImageInfoLocaleConverter
{


   # <editor-fold desc="= = =   P U B L I C   S T A T I C   F I E L D S   = = = = = = = = = = = = = = = = = = =">

   /**
    * All EXIF/IPTC field name translations.
    *
    * <code>
    * // Setting new translations to other languages
    * ImageInfoLocaleConverter::$Localizations[ 'fr' ] = [
    *     'Image Width'  => '…', 'Image Height' => '…', # etc…
    * );
    * </code>
    *
    * Available keys are:
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
    * @var array
    */
   public static $Localizations = [
      'de' => [
         'Image Width'                     => 'Breite',
         'Image Height'                    => 'Höhe',
         'MIME Type'                       => 'MIME-Type',
         'Format'                          => 'Bildformat',
         'Image Description'               => 'Bildbeschreibung',
         'Caption-Abstract'                => 'Abstrakte Beschreibung',
         'Description'                     => 'Beschreibung',
         'Copyright'                       => 'Copyright',
         'Copyright Notice'                => 'Copyright Hinweis',
         'Rights'                          => 'Copyright Rechte',
         'URL'                             => 'Copyright URL',
         'Usage Terms'                     => 'Nutzungsbedingungen',
         'Copyright Flag'                  => 'Copyright Flag',
         'Keywords'                        => 'Schlüsselworte',
         'Subject'                         => 'Tags',
         'Creator'                         => 'Ersteller',
         'Artist'                          => 'Künstler',
         'By-line'                         => 'Urheber',
         'Authors Position'                => 'Autor-Position',
         'By-line Title'                   => 'Autor-Anrede',
         'Creator Address'                 => 'Autor-Adresse',
         'Creator City'                    => 'Autor Stadt',
         'Creator Region'                  => 'Autor Region',
         'Creator Postal Code'             => 'Autor PLZ',
         'Creator Country'                 => 'Autor Stadt',
         'Creator Work Telephone'          => 'Autor Telefon',
         'Creator Work Email'              => 'Autor EMail',
         'Creator Work URL'                => 'Autor-Webadressen',
         'Location'                        => 'Bild-Standort',
         'Sub-location'                    => 'Bild-Substandort',
         'State'                           => 'Bild-Region',
         'Province-State'                  => 'Bild-Bundesland/Kanton',
         'Country Code'                    => 'Bild-Landeskennung',
         'Country-Primary Location Code'   => 'Bild-Ländercode',
         'City'                            => 'Bild-Stadt',
         'Country'                         => 'Bild-Land',
         'Country-Primary Location Name'   => 'Bild-Landesname',
         'Intellectual Genre'              => 'Bild-Genre',
         'Scene'                           => 'Bild-Szene',
         'Modify Date'                     => 'Änderungsdatum',
         'Date/Time Original'              => 'Datum/Zeit original',
         'Create Date'                     => 'Erstellungszeitpunkt',
         'Date Created'                    => 'Zeitpunkt Erstellung',
         'Date/Time Created'               => 'Erstellungs Datum/Zeit',
         'Digital Creation Date/Time'      => 'Dig. Erstellungs Datum/Zeit',
         'Digital Creation Date'           => 'Digit. Erstellungs Datum',
         'Digital Creation Time'           => 'Digit. Erstellungs Zeit',
         'Instructions'                    => 'Anweisungen',
         'Special Instructions'            => 'Spez. Anweisungen',
         'Transmission Reference'          => 'Jobkennung',
         'Original Transmission Reference' => 'Orig. Jobkennung',
         'Credit'                          => 'Anbieter',
         'Source'                          => 'Quelle',
         'GPS Latitude'                    => 'GPS-Breite',
         'GPS Longitude'                   => 'GPS-Länge',
         'GPS Position'                    => 'GPS-Position',
         'GPS Latitude Ref'                => 'GPS-Breiten Ref.',
         'GPS Longitude Ref'               => 'GPS-Längen Ref.',
         'Object Name'                     => 'Objektname',
         'Label'                           => 'Label',
         'Title'                           => 'Titel',
         'Headline'                        => 'Kopfzeile',
         'Category'                        => 'Kategorie',
         'Supplemental Categories'         => 'Zusätzliche Kategorien',
         'Make'                            => 'Hersteller',
         'Camera Model Name'               => 'Kamera-Modell',
         'Exposure Time'                   => 'Belichtungszeit',
         'Shutter Speed Value'             => 'Belichtungszeitwert',
         'Shutter Speed'                   => 'Zeit Belichtung',
         'F Number'                        => 'Blende',
         'Aperture Value'                  => 'Blendenwert',
         'ISO'                             => 'ISO',
         'Lens ID'                         => 'Objektiv',
         'Lens Info'                       => 'Objektivinfo',
         'Exposure Program'                => 'Belichtungsprogramm',
         'Exposure Compensation'           => 'Belichtungskompens.',
         'Metering Mode'                   => 'Messmodus',
         'Flash'                           => 'Blitz',
         'Focal Length'                    => 'Brennweite',
         'Exposure Mode'                   => 'Belichtungsmodus',
         'Caption Writer'                  => 'Autor-Beschreibung',
         'Writer-Editor'                   => 'Verfasser'
      ],
      'en' => [
         'Image Width'                     => 'Width',
         'Image Height'                    => 'Height',
         'MIME Type'                       => 'MIME-Type',
         'Format'                          => 'Image format',
         'Image Description'               => 'Image description',
         'Caption-Abstract'                => 'Abstract Caption',
         'Description'                     => 'Description',
         'Copyright'                       => 'Copyright',
         'Copyright Notice'                => 'Copyright notice',
         'Rights'                          => 'Copyright Rights',
         'URL'                             => 'Copyright URL',
         'Usage Terms'                     => 'Usage terms',
         'Copyright Flag'                  => 'Copyright flag',
         'Keywords'                        => 'Keywords',
         'Subject'                         => 'Tags',
         'Creator'                         => 'Creator',
         'Artist'                          => 'Artist',
         'By-line'                         => 'Author',
         'Authors Position'                => 'Author position',
         'By-line Title'                   => 'Author title',
         'Creator Address'                 => 'Creator address',
         'Creator City'                    => 'Creator city',
         'Creator Region'                  => 'Creator region',
         'Creator Postal Code'             => 'Creator postal code',
         'Creator Country'                 => 'Creator country',
         'Creator Work Telephone'          => 'Creator telephone',
         'Creator Work Email'              => 'Creator e-mail',
         'Creator Work URL'                => 'Creator URL',
         'Location'                        => 'Location',
         'Sub-location'                    => 'Sub location',
         'State'                           => 'State',
         'Province-State'                  => 'Province state',
         'Country Code'                    => 'Country code',
         'Country-Primary Location Code'   => 'Country primary location code',
         'City'                            => 'City',
         'Country'                         => 'Country',
         'Country-Primary Location Name'   => 'Country primary location name',
         'Intellectual Genre'              => 'Genre',
         'Scene'                           => 'Scene',
         'Modify Date'                     => 'Modify date',
         'Date/Time Original'              => 'Date/Time original',
         'Create Date'                     => 'Create date',
         'Date Created'                    => 'Date created',
         'Date/Time Created'               => 'Date/Time created',
         'Digital Creation Date/Time'      => 'Dig. creation Date/Time',
         'Digital Creation Date'           => 'Dig. creation Date',
         'Digital Creation Time'           => 'Dig. creation Time',
         'Instructions'                    => 'Instructions',
         'Special Instructions'            => 'Special Instructions',
         'Transmission Reference'          => 'Job reference',
         'Original Transmission Reference' => 'Orig. job reference',
         'Credit'                          => 'Credit',
         'Source'                          => 'Source',
         'GPS Latitude'                    => 'Latitude',
         'GPS Longitude'                   => 'Longitude',
         'GPS Position'                    => 'GPS-Position',
         'GPS Latitude Ref'                => 'Latitude Ref.',
         'GPS Longitude Ref'               => 'Longitude Ref.',
         'Object Name'                     => 'Object name',
         'Label'                           => 'Label',
         'Title'                           => 'Title',
         'Headline'                        => 'Headline',
         'Category'                        => 'Category',
         'Supplemental Categories'         => 'Supplemental categories',
         'Make'                            => 'Camera make',
         'Camera Model Name'               => 'Camera model',
         'Exposure Time'                   => 'Exposure time',
         'Shutter Speed Value'             => 'Shutter speed value',
         'Shutter Speed'                   => 'Shutter Speed',
         'F Number'                        => 'Aperture number',
         'Aperture Value'                  => 'Aperture value',
         'ISO'                             => 'ISO',
         'Lens ID'                         => 'Lens ID',
         'Lens Info'                       => 'Lens info',
         'Exposure Program'                => 'Exposure program',
         'Exposure Compensation'           => 'Exposure compensation',
         'Metering Mode'                   => 'Metering mode',
         'Flash'                           => 'Flash',
         'Focal Length'                    => 'Focal length',
         'Exposure Mode'                   => 'Exposure mode',
         'Caption Writer'                  => 'Caption writer',
         'Writer-Editor'                   => 'Writer-Editor'
      ]
   ];

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   S T A T I C   M E T H O D S   = = = = = = = = = = = = = = = = = =">

   /**
    * Convert the array keys of declared array $data to the language $lang depending translation.
    * The values will not be changed.
    *
    * @param array  $data
    * @param string $lang The 2 char is language id (e.g. 'en')
    * @return array
    */
   public static function ConvertTo( array $data, $lang = 'de' )
   {

      if ( ! isset( self::$Localizations[ $lang ] ) )
      {
         return $data;
      }

      $result = [];

      foreach ( $data as $key => $value )
      {
         if ( ! isset( self::$Localizations[ $lang ][ $key ] ) )
         {
            $result[ $key ] = $value;
         }
         else
         {
            $result[ self::$Localizations[ $lang ][ $key ] ] = $value;
         }
      }

      return $result;

   }

   /**
    * Convert the array keys of declared array $data from defined language back to original english.
    * The values will not be changed.
    *
    * @param array  $data
    * @param string $lang The 2 char is language id (e.g. 'en')
    * @return array
    */
   public static function ConvertFrom( array $data, $lang = 'de' )
   {

      if ( ! isset( self::$Localizations[ $lang ] ) )
      {
         return $data;
      }

      $result = array();

      foreach ( $data as $key => $value )
      {
         $oKey = \array_search( $key, self::$Localizations[ $lang ] );
         if ( ! $oKey )
         {
            $oKey = $key;
         }
         $result[ $oKey ] = $value;
      }

      return $result;

   }

   // </editor-fold>


}

