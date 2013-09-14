<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(0);
function encodeurl($match)
{
$match = trim(str_replace ("ä", "ae;", $match));
$match = str_replace ("ö", "oe;", $match);
$match = str_replace ("ü", "ue;", $match);
$match = str_replace ("Ä", "Ae;", $match);
$match = str_replace ("Ö", "Oe;", $match);
$match = str_replace ("Ü", "Ue;", $match);
$match = str_replace('ß','ss', $match);
$match = str_replace('&auml;','ae', $match);
$match = str_replace('&ouml;','oe', $match);
$match = str_replace('&uuml;','ue', $match);
$match = str_replace('&ndash;','-', $match);
$match = str_replace('szlig;','ss', $match);
$match = str_replace('é','e', $match);
$match = str_replace("039","", $match);
$match = str_replace('eacute;','e', $match);
$match = preg_replace("|&#[0-9]{3,4};|",null, $match);
$match = str_replace('amp;','und', $match);
$match=urlencode(str_replace('--','-',str_replace('--','-', preg_replace('#[^A-Za-z0-9\s-]#',null, str_replace(' ','-',$match)))));

if (substr($match, -1) == '-') {
    $match = substr($match, 0, -1);
} 
return $match;
}
function decodeurl($match)
{
$match=urldecode($match);
$match = str_replace ("-", " " , $match);
$match = str_replace ("ae", "&auml;" , $match);
$match = str_replace ("oe", "&ouml;", $match);
$match = str_replace ("ue", "&uuml;", $match);
$match = str_replace ("Ae", "Ä;", $match);
$match = str_replace ("Oe", "Ö;", $match);
$match = str_replace ("UE", "Ü;", $match);
$match = str_replace('ß','ss', $match);
$match = str_replace('-','&ndash;', $match);
$match = preg_replace("|&#[0-9]{3,4};|",null, $match);
$match = str_replace('amp;','und', $match);

if (substr($match, -1) == '-') {
    $match = substr($match, 0, -1);
}return $match;}

function inStr ($needle, $haystack)
{
  $needlechars = strlen($needle); 
  $i = 0;
  for($i=0; $i < strlen($haystack); $i++) 
  {
    if(substr($haystack, $i, $needlechars) == $needle) 
    {
      return TRUE; 
    }
  }
  return FALSE;
}  

function to_unixtime ($datum)
{ 
  $convertdatum = explode(" ",$datum);$datumc=$convertdatum[0];
  if (instr("/",$datum)) $tagmonatjahr=explode("/",$datumc); else $tagmonatjahr=explode(".",$datumc);
$hum=explode(":",$convertdatum[1]);
  if (instr("/",$datum)) $datum=mktime($hum[0],$hum[1], "0",$tagmonatjahr[0],$tagmonatjahr[1],$tagmonatjahr[2]);else
  $datum=mktime($hum[0],$hum[1], "0",$tagmonatjahr[1],$tagmonatjahr[0],$tagmonatjahr[2]);
  return $datum;
}  
function leftspaces($entry)
{
$spaces= strlen($entry)-strlen(ltrim($entry));
return $spaces;
}

function rrmdir($dir) { 
  foreach(glob($dir . '/*') as $file) { 
    if(is_dir($file)) rrmdir($file); else unlink($file); 
  } rmdir($dir); 
}

function multiimagerename($file,$imgnr,$fromendung,$toendung) { 
	rename("../image/" .$file. "-". $imgnr.".".$fromendung, "../image/" .$file. "-". $_GET['rotateimg'].".".$toendung);
	rename("../image/" .$file. "-". $imgnr."-150.".$fromendung, "../image/" .$file. "-". $_GET['rotateimg']."-150.".$toendung);
	rename("../image/" .$file. "-". $imgnr."-800.".$fromendung, "../image/" .$file. "-". $_GET['rotateimg']."-800.".$toendung);
	rename("../image/" .$file. "-". $imgnr."-ori.".$fromendung, "../image/" .$file. "-". $_GET['rotateimg']."-ori.".$toendung);
}

function multiimagerotate($file,$imgnr,$endung,$angle) { 
	imagefilerotate("../image/" .$file. "-". $imgnr.".".$endung,"../image/" .$file. "-". $imgnr.".jpg",$angle);
	imagefilerotate("../image/" .$file. "-". $imgnr."-150.".$endung,"../image/" .$file. "-". $imgnr."-150.jpg",$angle);
	imagefilerotate("../image/" .$file. "-". $imgnr."-800.".$endung,"../image/" .$file. "-". $imgnr."-800.jpg",$angle);
	imagefilerotate("../image/" .$file. "-". $imgnr."-ori.".$endung,"../image/" .$file. "-". $imgnr."-ori.jpg",$angle);
}

function imagefilerotate($imgfrom,$imgto,$angle) { 
// Content type
header('Content-type: image/jpeg');
$source = imagecreatefromjpeg($imgfrom);
$rotate = imagerotate($source, $angle, 0);
imagejpeg($rotate,$imgto,90);
imagedestroy($source);
imagedestroy($rotate);
}

if(!function_exists("imagerotate")) {
    function imagerotate(&$srcImg, $angle, $bgcolor, $ignore_transparent = 0) {
        return imagerotateEquivalent::rotate(&$srcImg, $angle, $bgcolor, $ignore_transparent);
    }
}

//imagerotate for older php versions http://php.net/manual/de/function.imagerotate.php

if(!function_exists("imagerotate")) {
    function imagerotate(&$srcImg, $angle, $bgcolor, $ignore_transparent = 0) {
        return imagerotateEquivalent::rotate(&$srcImg, $angle, $bgcolor, $ignore_transparent);
    }
}

class imagerotateEquivalent {

    static private function rotateX($x, $y, $theta){
        return $x * cos($theta) - $y * sin($theta);
    }

    static private function rotateY($x, $y, $theta){
        return $x * sin($theta) + $y * cos($theta);
    }

    public static function rotate(&$srcImg, $angle, $bgcolor, $ignore_transparent = 0) {
       
        $srcw = imagesx($srcImg);
        $srch = imagesy($srcImg);

        if($angle == 0) return $srcImg;

        // Convert the angle to radians
        $theta = deg2rad ($angle);

        // Calculate the width of the destination image.
        $temp = array (    self::rotateX(0,     0, 0-$theta),
                        self::rotateX($srcw, 0, 0-$theta),
                        self::rotateX(0,     $srch, 0-$theta),
                        self::rotateX($srcw, $srch, 0-$theta)
                    );
        $minX = floor(min($temp));
        $maxX = ceil(max($temp));
        $width = $maxX - $minX;

        // Calculate the height of the destination image.
        $temp = array (    self::rotateY(0,     0, 0-$theta),
                        self::rotateY($srcw, 0, 0-$theta),
                        self::rotateY(0,     $srch, 0-$theta),
                        self::rotateY($srcw, $srch, 0-$theta)
                    );
        $minY = floor(min($temp));
        $maxY = ceil(max($temp));
        $height = $maxY - $minY;

        $destimg = imagecreatetruecolor($width, $height);
        imagefill($destimg, 0, 0, imagecolorallocate($destimg, 0,255, 0));

        // sets all pixels in the new image
        for($x=$minX;$x<$maxX;$x++) {
            for($y=$minY;$y<$maxY;$y++)
            {
                // fetch corresponding pixel from the source image
                $srcX = round(self::rotateX($x, $y, $theta));
                $srcY = round(self::rotateY($x, $y, $theta));
                if($srcX >= 0 && $srcX < $srcw && $srcY >= 0 && $srcY < $srch)
                {
                    $color = imagecolorat($srcImg, $srcX, $srcY );
                }
                else
                {
                    $color = $bgcolor;
                }
                imagesetpixel($destimg, $x-$minX, $y-$minY, $color);
            }
        }
        return $destimg;
    }
}
//...image rotate 
?>
