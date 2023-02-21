<?php

session_start();
$captchaCode= substr(md5(time()),0,8);


$_SESSION['captcha'] =$captchaCode;

$captchaImage= imagecreatefrompng("fundocaptch.png");


$captchaFont = imageloadfont("anonymous.gdf");
$captchaColor = imagecolorallocate($captchaImage, 0, 100, 200);
imagestring($captchaImage, $captchaFont, 15, 5, $captchaCode, $captchaColor);

imagepng($captchaImage);
imagedestroy($captchaImage);

//session_destroy();

