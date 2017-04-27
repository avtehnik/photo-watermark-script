#!/usr/local/php5/bin/php -q
<?php
/* Create some objects */


const FOLDER_NAME = 'watermark';

$workDir = $_SERVER['PWD'];

$replace = false;

$output = $workDir . '/' . FOLDER_NAME;

if (array_key_exists('1', $argv)) {
    if ($argv['1'] == '--help' || $argv['1'] == '-h') {
        echo 'use -r to replace images, otherwise photos will be saved to watermark folder';
    } elseif ($argv['1'] == '-r' || $argv['1'] == '-h') {
        $replace = true;
        $output  = $workDir;
    }
}


if ( ! is_dir($output)) {
    mkdir($output);
}


function watermark($img, $folder, $name = null)
{

    $filename = pathinfo($img, PATHINFO_BASENAME);

    $image = new Imagick($img);

    $draw = new ImagickDraw();
    /* Black text */
    $draw->setFillColor('#ffffff');
    $draw->setStrokeColor('#C4C4C4');
$draw->setStrokeWidth(2);
//$draw->setStrokeAntialias(true);
//$draw->setTextAntialias(true);
//    $draw->setFillAlpha(0.5);

    /* Font properties */
    $draw->setFont('/etc/watermark/Pacifico.ttf');
    $text = 'Vitaliy Pitvalo';

    $orientation = $image->getImageOrientation();


    if ($orientation == 6 || $orientation == 8) {
    } else {
        $draw->setFontSize(70);
    }
    $draw->setFontSize(100);

    $textData = $image->queryFontMetrics($draw, $text);

    $textData['textWidth'];
    $textData['textHeight'];


    $offset = 200;

//    print_r($textData);
    $orientation = $image->getImageOrientation();

    $angle = 0;

    $draw->setGravity(\Imagick::GRAVITY_SOUTHEAST);
    if ($orientation == 6 || $orientation == 8) {
        if ($orientation == 8) {
            $angle = 90;
            $y     = ($offset+$textData['textWidth'])-180;
            $x     = $offset-95;
            $draw->setGravity(\Imagick::GRAVITY_SOUTHWEST);

        } else {
            $angle = -90;
            $y     = $offset - $textData['textHeight'] - $textData['descender'];
            $x     = $offset;
            $draw->setGravity(\Imagick::GRAVITY_NORTHEAST);
        }
    } else {
        $y = 50;
        $x = 50;
    }
//    $image->annotateImage($draw, $x-3, $y-3, $angle, $text);
//    $draw->setFillColor('#1a8bff');
    $image->annotateImage($draw, $x, $y, $angle, $text);

    $image->writeImage($folder . '/' . $filename); //also works

}

$files = scandir($workDir);


$newFiles = [];
foreach ($files as $file) {

    $filepath = $workDir . '/' . $file;

    if (is_file($file)) {

        $extension = strtolower(pathinfo($file,PATHINFO_EXTENSION));
        if (in_array($extension,['jpg','jpeg','png'])) {
            $newFiles[$file] = $filepath;
        }
    }
}




$count = count($newFiles);
$index = 1;

foreach($newFiles as $name=> $path){
    echo number_format(($index/$count)*100,2)."% - $name                                                           \r";
    watermark($path, $output);
    $index++;
}

echo 'Finish';
