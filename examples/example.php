<?php


include __DIR__ . '/../vendor/autoload.php';


$loader = new \Beluga\Drawing\Image\Exif\Loader\PHP();

$data = $loader->load( __DIR__ . '/IMG_0169-2.JPG' );

print_r( $data );
