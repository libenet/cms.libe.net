<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/
 
class SimpleImage {
   
   var $image;
   var $image_type;
 
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=85, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }   
}

// libe save images ...
   function multiimagesave($image,$imagetemp,$path,$file, $ori=0) {
	global $lang_txt_002,$lang_txt_031;
	//$path="../"; //Path relativ to admin folder="../"
	//$image=$_FILES["uploaded_image"]["name"];
	//$imagetemp=$_FILES["uploaded_image"]["tmp"];
	//$ori=$_POST['original_picture'];
	//$file=$file;
	$simage = new SimpleImage();
	$simage->load($imagetemp);
	$imgname= $path ."image/" .$file. "-1";

	for( $xf = 1; $xf < 999; $xf++ )
	{
		if(file_exists($imgname .".jpg") or file_exists($imgname .".png") or file_exists($imgname .".gif")) 
		{
		$imgname= $path ."image/".$file. "-". $xf;
		}else break;
	}

	$endung=substr($image, strripos($image,"."));
	if (strtolower($endung)==".jpeg" or strtolower($endung)==".jpg" or strtolower($endung)==".gif" or strtolower($endung)==".png")$fileinfo="Image"; else $fileinfo="Datei";

			if ($fileinfo!="Datei")
			{
				$image_info = getimagesize($imagetemp);
				$myimageinfo=explode("height=", $image_info[3]);$endung="jpg";if ($image_info[2]=="3") $endung="png";if ($image_info[2]=="1") $endung="gif";						
				$x=str_replace("\"", "", str_replace("width=\"", "", trim($myimageinfo[0])));
				$y=str_replace("\"", "", str_replace("height=\"", "", trim($myimageinfo[1])));					
				if ($endung=="jpg")
				{
									if ($x > $y) $simage->resizeToWidth(150);else $simage->resizeToHeight(150);
								      	$simage->save($imgname. "-150.". $endung);
									$simage->load($imagetemp);					
									if ($x > 500 or $y > 500) {if ($x>$y) $simage->resizeToWidth(500);else $simage->resizeToHeight(500);}
									$simage->save($imgname. ".".$endung);
									$simage->load($imagetemp);					
									if ($x > 799 or $y > 799) {if ($x>$y) $simage->resizeToWidth(800);else $simage->resizeToHeight(800);}
								      	$simage->save($imgname. "-800.".$endung);
									if ($ori==1) copy($imagetemp, $imgname. "-ori.".$endung);
									}
									else
									{
									$copied = copy($imagetemp, $imgname. ".".$endung);
										if (!$copied) 
										{
											echo '<h1>', $lang_txt_002, '</h1>';
											$errors=1;
										}
				}
			}
			else
			{
			//Files:
								$filename= encodeurl(str_replace($endung, "",$image)).$endung;
								$copied = copy($imagetemp, $path."download/". $filename);

								if ($endung==".zip" and $ori!=1)
								{
									//try to unzip and look if there are Images in the file:
									echo "<div style=\"position:absolute;right:0px;background:#fff; padding:2px;border:1px solid #ccc;z-index:999;width:200px;\"> try to Unzip and look if there are Images in the Archive:";
									 $jpgsinzip=0;
								     $zip = new ZipArchive;
								     $res = $zip->open($path."download/". $filename);
								     if ($res === TRUE) {	
									$zip->extractTo($path."download/temp/");
									 for($i = 0; $i <= $zip->numFiles; $i++) 
										 {$jpgsinzip++;
										 multiimagesave($zip->getNameIndex($i),$path."download/temp/". $zip->getNameIndex($i),$path,$file, $ori);		 							
										 }
									 $zip->close();
									 echo "Unzip ok";
								     } else {
									 echo "failed";
								     }
								echo "</div>";
								}

									//cleanup:
									 		foreach (scandir($path."download/temp/") as $item) {
												if ($item == '.' || $item == '..') continue;unlink($path."download/temp/".$item);
											}
											if ($jpgsinzip==$i and $ori!=1 and trim(strtolower($endung))==".zip") {unlink($path."download/". $filename);echo "<div style=\"position:absolute;right:0px;background:#fff; padding:2px;border:1px solid #ccc;z-index:999;width:200px;\">all jpgs extracted: deleted:", $filename, " <br>use 'ori' if zip should not be deleted</div>";}
											else echo "<div style=\"position:absolute;top:170px;background:#fff;border:1px solid #ccc; padding:3px;left:330px;z-index:999;\"> <a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,'<a href=../download/$filename>$filename</a>');\">$lang_txt_031: $filename</a></div>";

									//..cleanup

			}
	unlink($imagetemp); //temp löschen
   } 
//...libe save images
?>


