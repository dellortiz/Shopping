<?php 
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 5);
$_SESSION['captcha_code'] = $code; // Guardar el código en la sesión

$width = 150;
$height = 50;
$font = '../funcs/font/Consolas.ttf';
$fontsize = 30;

$img = imagecreatetruecolor($width, $height);
$backgroundcolor = imagecolorallocate($img, 255, 255, 255);
imagefill($img, 0, 0, $backgroundcolor);
$colorText = imagecolorallocate($img, 50, 50, 50); 
$colorSecond = imagecolorallocate($img, 0, 0, 128);

for ($i = 0; $i < 6; $i++) {
imageline($img, 0, rand(0, $height), $width, rand(0, $height), $colorSecond);
}
for ($i = 0; $i < 1000; $i++) {
imagesetpixel($img, rand(0, $width), rand(0, $height), $colorSecond);
}

imagettftext($img, $fontsize, -5, 10, 35, $colorText, $font, $code);

header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
?>
