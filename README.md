# Beluga.Drawing.Image.Exif

Some tools for easy getting image EXIF and IPTC meta data

## Installation

```bash
composer require sagittariusx/beluga.drawing.image.exif
```

or include it inside you're composer.json

```json
{
   "require": {
      "sagittariusx/beluga.drawing.image.exif": "^0.1.0"
   }
}
```

## Usage

If you want to load some EXIF and/or IPTC data from an image you can do it by 4 different ways:

### With PHP only

```php
// Init the PHP only loader that get the data directly without requirement of some PHP extensions or something else
$loader = new \Beluga\Drawing\Image\Exif\Loader\PHP();

// Load the META data from a image
$data = $loader->load( __DIR__ . '/IMG_0169-2.JPG' );

// Debug output the META data
print_r( $data );
```

### With ExifTool

If you have installed the exiftool (available for Win, MAC and Linux) commandline utility you can use it to get
more detailed META data.

```php
// Init the loader
$loader = new \Beluga\Drawing\Image\Exif\Loader\ExifTool();

if ( ! $loader->isConfigured() )
{
   // Exiftool is not known to the system, declare it manually
   try
   {
      $loader->configure( [ 'path' => '\usr\local\bin\exiftool' ] );
   }
   catch ( \Throwable $ex ) { echo $ex; exit; }
}

if ( ! $loader->isConfigured() )
{
   // The loader for exiftool is not configured right
   // Use the PHP loader as fallback. It will always do the job
   $loader = new \Beluga\Drawing\Image\Exif\Loader\PHP();
}


// Load the META data from a image
$data = $loader->load( __DIR__ . '/IMG_0169-2.JPG' );

// Debug output the META data
print_r( $data );
```

### With ExiV2

Its the same like exiftool but with the `exiv2` executable.

### With JSON sidecar files

If the images have sidecar files with JSON format, that declares the image META data, this load is the right one.

If the image has for example the name `foo.jpg` it will use the sidecar files `foo.jpg.json` or `foo.json`

```php
// Init the JSon sidecar files loader
$loader = new \Beluga\Drawing\Image\Exif\Loader\JSon();

// Load the META data from a image
$data = $loader->load( __DIR__ . '/IMG_0169-2.JPG' );

// Debug output the META data
print_r( $data );
```