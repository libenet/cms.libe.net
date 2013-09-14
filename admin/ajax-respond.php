<?php 
header('Content-Type: text/html; charset=iso-8859-1');  
error_reporting(0);
@include("passwort.php");
@include($wobinich."functions.php");

//language:
if ($language=="de") $inclanguage="de"; else $inclanguage="en"; 
if ($language=="auto") $inclanguage=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
if ($inclanguage=="de")@include("de.php");else @include("en.php");

if ($_COOKIE["loginadmin"] == md5($Passwort."-".$ip)){
		/*** read entry***/
		if (!empty($_GET["loadimages"])) $file=$_GET["loadimages"]; else $file="dat_menu_file";
		
		$Pfad= "../daten/$file.dat";
		$datei = fopen($Pfad, "r");
		$savethetext=fread($datei, filesize($Pfad));
		fclose($datei);
		$arrayseite = explode ("---///___", $savethetext);
		$text= $arrayseite[2];
		$menuarray=explode ("\n",$text);

//only for preview:
$arrayseiteadd = explode ("---xxx___", $arrayseite[1]);
if( isset( $arrayseiteadd[6] ) )$preview =$arrayseiteadd[6];else $preview="";



/*** read ADDITIONAL***/
$file="dat_menu_file2";
$Pfad= "../daten/$file.dat";$datei = fopen($Pfad, "r");$savethetext=fread($datei, filesize($Pfad));fclose($datei);
$menuarray2=explode ("\n",$savethetext);

//Backlinks and levels
function backlinksandlevels($article)
{global $menuarray,$titelarray,$titelmenuarray;

		for ($i=0; $i<count($menuarray);$i++){
		$this_level=strlen(str_replace(trim($menuarray[$i]), "",chop($menuarray[$i])));
		$menulevel[$i]=$this_level+1; //remember level
		//$menuback[$this_level]=$menuarray[$i];
		$menuback[$this_level]= encodeurl($menuarray[$i]);
		$menubackforlevel[$this_level]=$titelarray[$i];
		
		if (!empty($titelmenuarray[$i]))$menubacktitel[$this_level]=$titelmenuarray[$i];else $menubacktitel[$this_level]=$menuarray[$i];
		$menuarray[$i]=preg_replace("/\r|\n/s", "", $menuarray[$i]);

		//Backlinks
		if (trim($article)==trim(encodeurl($menuarray[$i])))
		{
			$level=$this_level+1;$start_sub_menu=$new_sub_begin;$me=$i;
			for ($e=0; $e<count($menuback);$e++){if ($this_level>$e) if (!empty($menuback[$e])){$backlink=" - <a href=\"admin.php?file=".trim($menuback[$e])."\" style=\"font-size:10px;color:#555;\">".$menubacktitel[$e]. "</a> ".$backlink;$menuforlevel[$e+1]=$menubacktitel[$e];$urlforlevel[$e+1]=$menuback[$e];$titelforlevel[$e+1]=$menubackforlevel[$e];}}
			//if (!empty($titelmenuarray[$i])) $backlink=$backlink." / ". $titelmenuarray[$i]; else $backlink=$backlink." / ". $menubacktitel[$e];$menuforlevel[$level]=$menuarray[$i];
		}				
		//Backlinks
		}
return $backlink;
}

//... backlinksandlevels
if (!empty($_GET["backlinksandlevels"])){
@include(getcwd()."../buildpage.php");
echo backlinksandlevels($_GET["backlinksandlevels"]);
} 
//...backlinksandlevels



//load topics for images
$topic=$_GET["topic"];


//loadfiles...
$loadfiles=$_GET["loadfiles"];
if (!empty($_GET["deletefile2"]) or !empty($_GET["deletefile"])) $loadfiles="delete";
//...loadfiles

//...load topics for images

if (!empty($_GET["loadimages"]) or !empty($topic) or (!empty($loadfiles))){

// HTML5 FileUpload...
$dir = "../download/dropupload";
include('SimpleImage.php');

	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) 
		{
		while (($filex = readdir($dh)) !== false) 
			{  
				if ($filex!="." and $filex!="..") 
					{ //echo $filex,$dir."/".$filex,"../",$topic;
					 multiimagesave($filex,$dir."/".$filex,"../",$_GET["loadimages"]);
 					 unlink($dir."/".$filex);
					}
			}
		closedir($dh);
		}
			}
rmdir($dir);
// ...HTML5 FileUpload -->


$file=$_GET["loadimages"];//$view=$_GET["view"];

if (!empty($topic))$file=$topic;

$view=$_GET["view"];

//rotate image...
if (!empty($_GET["rotateimg"]))
{
$rotated=0;
if (file_exists("../image/" .$file. "-". $_GET['rotateimg'].".ro1")){
multiimagerename($file,$_GET['rotateimg'],"ro1","ro2");
multiimagerotate($file,$_GET['rotateimg'],"ro2","180");
$rotated=1;
}
if (file_exists("../image/" .$file. "-". $_GET['rotateimg'].".ro2") and $rotated==0){
multiimagerename($file,$_GET['rotateimg'],"ro2","ro3");
multiimagerotate($file,$_GET['rotateimg'],"ro3","270");
$rotated=1;
}
if (file_exists("../image/" .$file. "-". $_GET['rotateimg'].".ro3") and $rotated==0){
	multiimagerename($file,$_GET['rotateimg'],"ro3","sav");
	copy("../image/" .$file. "-". $_GET['rotateimg'].".sav", "../image/" .$file. "-". $_GET['rotateimg'].".jpg");
	copy("../image/" .$file. "-". $_GET['rotateimg']."-150.sav", "../image/" .$file. "-". $_GET['rotateimg']."-150.jpg");
	copy("../image/" .$file. "-". $_GET['rotateimg']."-800.sav", "../image/" .$file. "-". $_GET['rotateimg']."-800.jpg");
	copy("../image/" .$file. "-". $_GET['rotateimg']."-ori.sav", "../image/" .$file. "-". $_GET['rotateimg']."-ori.jpg");

$rotated=1;
}

if ($rotated==0) {
	multiimagerename($file,$_GET['rotateimg'],"jpg","ro1");
	multiimagerotate($file,$_GET['rotateimg'],"ro1","90");
}

}

//...rotate image

if (empty($_GET['deletefile']) and empty($_GET['deletefile2']) and empty($_GET['deletefile2']) and empty($_GET['deleteimg']) and empty($_GET['deleteimg2']) and empty($_GET['rotateimg']))
{
		echo "<div style=\"position:relative;";
		if (!empty($loadfiles)) echo "background:#fff;-moz-box-shadow:inset 1px 1px 1px 1px #777;
				-webkit-box-shadow: inset  1px 1px 1px 1px #777;
				box-shadow:      inset    1px 1px 1px 1px #777; ";else echo "background:#eee;-moz-box-shadow:1px 1px 1px 1px #777;
				-webkit-box-shadow: 1px 1px 1px 1px #777;
				box-shadow:        1px 1px 1px 1px #777;";
		echo "float:right;padding:3px;border-left:1px solid #999;border-right:1px solid #999;margin-right:5px;border-top:1px solid #999;border-radius: 3px 3px 0px 0px;\"> <b><a href=\"#\" style=\"font-size:10px;\" onclick=\"loadfiles()\">Downloads</a> </b></div> ";

		echo " <div style=\"position:relative;float:right;";
		if (empty($loadfiles)) echo "background:#fff;-moz-box-shadow: inset  1px 1px 1px 1px #777;
				-webkit-box-shadow:inset 1px 1px 1px 1px #777;
				box-shadow:        inset  1px 1px 1px 1px #777;";else echo "background:#eee;-moz-box-shadow: 1px 1px 1px 1px #777;
				-webkit-box-shadow:  1px 1px 1px 1px #777;
				box-shadow:         1px 1px 1px 1px #777;";	
		echo "padding:3px;border-left:1px solid #999;border-right:1px solid #999;border-top:1px solid #999;border-radius: 3px 3px 0px 0px;\"> <b style=\"padding-right:5px;\"><a href=\"#\" style=\"font-size:10px;\" onclick=\"reloadimgs()\">$lang_txt_159</a> </b>";
	 

	echo "";

	echo "<span style=\"color:#555;font-size:10px;float:right;\">";
	if (empty($loadfiles)){
	if (empty($topic)) {echo "<a href=\"#\" style=\"font-size:10px;\" onclick=\"loadtopicimgs('overview')\">$lang_txt_162</a> ";

		if ($view=="oldtonew") echo "| <a href=\"#\" style=\"font-size:10px;\" onclick=\"reloadimgs('')\">$lang_txt_160</a> ";else
		 
		echo "| <a href=\"#\" style=\"font-size:10px;\" onclick=\"reloadimgs('oldtonew')\">$lang_txt_161</a>";}
		else  echo "<a href=\"#\" style=\"font-size:10px;\" onclick=\"reloadimgs('')\">$lang_txt_106</a>";
	}
	echo "</span>";

	echo "</div><div id=\"images2\" style=\"max-height:500px;min-width:170px;overflow:auto;border:1px #ccc solid;background:#fff;padding:20px;-moz-box-shadow:inset 1px 3px 2px 3px #777;
				-webkit-box-shadow: inset 1px 3px 2px 3px #777;
				box-shadow:        inset  1px 3px 2px 3px #777;padding-left:20px;clear:right;\">";
}




$countfiles=0;

//Files löschen..

if (!empty($_GET['deletefile'])) {unlink("../download/" .$_GET['deletefile']);
echo $_GET['deletefile']." $lang_txt_004<hr>";}

//Files löschen

//Files:
if (!empty($loadfiles))
{
$dir = "../download/";
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) 
		{
		while (($filex = readdir($dh)) !== false) 
			{  
				if ($filex!="." and $filex!=".." and !is_dir("../download/".$filex)) 
					{
 					 $countfiles++;$afile[$countfiles]=$filex;
					}
			}
		closedir($dh);

			asort($afile);
			foreach ($afile as $key => $val) 
			{
						echo "<a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,'<a href=../download/$afile[$key]>$afile[$key]</a>');\">$afile[$key]</a>";
						echo " <a href=\"#\" onclick=\"deletefile2('".urlencode($afile[$key])."')\"> (X)</a><br>";
						if (!empty($_GET['deletefile2']) and ($afile[$key]==$_GET['deletefile2'])) echo "<a name=\"delete\"></a><a href=\"#\" onclick=\"deletefile('".urlencode($afile[$key])."')\" title=\"",$lang_txt_018,"\" style=\"float:right;position:absolute;float:right;margin-top:0px;margin-left:-50px;padding:3px;border:1px solid #ccc;background:#fff;\">$lang_txt_166</a>";
			}  

	    	}
	}
if ($countfiles==0) echo $lang_txt_165;
}
//...Files




//load Images ....
//Bild löschen ....


if (!empty($_GET['deleteimg']))
{echo "<div style=\"position:absolute;float:right;top:190px;\">../image/" .$file. "-". $_GET['deleteimg'].".jpg ", $lang_txt_004,"</div>";
unlink("../image/" .$file. "-". $_GET['deleteimg'].".jpg");
unlink("../image/" .$file. "-". $_GET['deleteimg']."-150.jpg");
unlink("../image/" .$file. "-". $_GET['deleteimg']."-800.jpg");
unlink("../image/" .$file. "-". $_GET['deleteimg']."-ori.jpg");
unlink("../image/" .$file. "-". $_GET['deleteimg'].".png");
unlink("../image/" .$file. "-". $_GET['deleteimg']."-150.png");
unlink("../image/" .$file. "-". $_GET['deleteimg']."-800.png");
unlink("../image/" .$file. "-". $_GET['deleteimg'].".gif");
unlink("../image/" .$file. "-". $_GET['deleteimg']."-150.gif");
unlink("../image/" .$file. "-". $_GET['deleteimg']."-800.gif");
}
//ende bild löschen


if ($topic=="overview") {echo "<h1>$lang_txt_163</h1>";


	 echo "<ol class=\"dd-list\">";
	//hier angepasste buildmenuul

		$mainmenu="";
		for ($i=0; $i<count($menuarray);$i++)
			{ 
							if ($i==0 and leftspaces($menuarray[$i])>0) {$mainmenu= "$mainmenu
							<li class=\"dd-item\" id=\"no-handle\" data-id=\"not-used-in-menu\">  
							<div title=\"$lang_txt_133\" class=\"no-handle\">$lang_txt_132</div>";
							for ($k=0;$k<leftspaces($menuarray[$i]);$k++) $mainmenu= "$mainmenu <ol class=\"dd-list\">";
							}
							
							$arrayseiteadd = explode ("---///___", $menuarray2[$i]);
							$datumarray[$i]= trim($arrayseiteadd[0]);
							$titelmenuarray[$i]= trim($arrayseiteadd[5]);
							$mainmenu= "$mainmenu \n<li class=\"dd-item\"> ";							
							if (!empty($titelmenuarray[$i]))$displaytitle=$titelmenuarray[$i];else $displaytitle=$menuarray[$i];unset ($linkurl);
							if (!empty($fileandpathnamearray[$i]))$linkurl= $fileandpathnamearray[$i] ;else $linkurl=$index. "/".encodeurl($menuarray[$i]);
							$mainmenu= "$mainmenu \n<a href=\"#\"";
							$trimit=trim($menuarray[$i]);
							if (empty($ignoreleftspaces)) if (leftspaces($menuarray[$i])<1 and $trimit{0}!="'")$ignoreleftspaces="donotignore";							
							if ($datumarray[$i]>time() or empty($ignoreleftspaces) or $trimit{0}=="'")$mainmenu= "$mainmenu class=\"color1\"";
							elseif (leftspaces($menuarray[$i])!=0)$mainmenu= "$mainmenu class=\"color2\"";
							//trim($displaytitle)
							$mainmenu= "$mainmenu onclick=\"loadtopicimgs('". trim(encodeurl($menuarray[$i]))."')\">".trim($displaytitle). "</a>";
							if ($datumarray[$i]>time())$mainmenu= $mainmenu." <font style=\"font-size:8px;color:#aaa;float:left;\">(".date("d.m.Y H:i",$datumarray[$i]).")</font>";

							$mainmenu= $mainmenu."<div class=\"dd-handle\"></div>";



							//if ($i==0) $mainmenu="$mainmenu </li>"; //nicht sicher ob das passt ...
							if (isset($menuarray[$i+1])){$nextmenu=$menuarray[$i+1];}

					
							if (leftspaces($menuarray[$i])==leftspaces($nextmenu)) $mainmenu= "$mainmenu </li>\n";

							for ($k=0;$k<leftspaces($menuarray[$i])-leftspaces($nextmenu);$k++) $mainmenu= "$mainmenu \n</li>\n</ol>";
							//for ($k=0;$k<leftspaces($menuarray[$i])-leftspaces($nextmenu);$k++) $mainmenu= "$mainmenu \n</ol>";
							
						for ($k=0;$k<leftspaces($nextmenu)-leftspaces($menuarray[$i]);$k++) $mainmenu= "$mainmenu \n<ol class=\"dd-list\">";
							


						

			}
	if (count($menuarray)!=1 or strlen($menuarray[0])>1) echo $mainmenu; else echo "<li class=\"dd-item\" data-id=\"not-used-in-menu\"><div title=\"$lang_txt_133\" class=\"no-handle\">$lang_txt_132</div></li>";

	//show tips for the first start:
	if (count($menuarray)==1)echo "<div class=\"intro\">", $lang_txt_148, "</div>";


	echo "</ol>";

}else if (!empty($topic)) echo "<h1>$file</h1>";



						$imageexists="0";
						$imgname= "../image/" .$file;

						//new sortable...
						for( $xf = 999; $xf > 0; $xf-- )
						{$endung="";
						if(file_exists($imgname ."-".$xf.".jpg")) $endung="jpg";if(file_exists($imgname ."-".$xf.".png")) $endung="png";if(file_exists($imgname ."-".$xf.".gif")) $endung="gif";
						if (!empty($endung)) {
						$arrimg[$xf]=filemtime($imgname ."-".$xf.".".$endung);
						$arrimgend[$xf]=$endung;}
						}
						if (count($arrimg)==0 and (empty($loadfiles))) echo $lang_txt_164;						
						if ($view=="oldtonew") asort($arrimg); else arsort($arrimg);
						foreach ($arrimg as $key => $val) 
						{
							if (!empty($arrimgend[$key]))echo "<div class=\"minibox\">";
							if (!empty($arrimgend[$key])){echo "<div style=\"float:left\">";
								if (empty($topic)){
								echo "<input type=\"radio\" name=\"preview\" value=\"$key\"";$imageexists=1;
								if ($_GET['deleteimg']== $preview) $preview=0;
								if ($preview==$key) echo " checked";
								if ($alreadychecked!=1)if ($preview==0) {echo " checked";$alreadychecked=1;}
								echo " title=\"",$lang_txt_067,"\">";}
								if($arrimgend[$key]=="jpg")
								{if(file_exists($imgname ."-".$key."-800.jpg")) $img800present=1;else $img800present=0;
								if ($img800present==1) echo "<a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,' <a href=$imgname-$key-800.", $arrimgend[$key]," rel=lightbox[roadtrip]><img src=$imgname-$key-150.", $arrimgend[$key],"?cache=", $filetime,"></a> ');\" title=\"", $lang_txt_064,"\">S</a> <a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,'<img src=$imgname-$key-800.", $arrimgend[$key],"?cache=", $filetime,">');\" title=\"", $lang_txt_115,"\">L</a> ";
								else echo "<a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,' <a href=$imgname-$key.", $arrimgend[$key]," rel=lightbox[roadtrip]><img src=$imgname-$key-150.", $arrimgend[$key],"?cache=", $filetime,"></a> ');\" title=\"", $lang_txt_064,"\">S</a> ";
								if ($img800present==0) echo "<a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,' <a href=$imgname-$key.", $arrimgend[$key]," rel=lightbox[roadtrip]><img src=$imgname-$key.", $arrimgend[$key],"?cache=", $filetime,"></a> ');\" title=\"", $lang_txt_065,"\">L</a>";
								}
								if(file_exists($imgname ."-".$key."-ori.jpg")) echo " <a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,'<img src=$imgname-$key-ori.", $arrimgend[$key],"?cache=", $filetime,">');\" title=\"$lang_txt_142\">O</a>";
								if (!empty($_GET['deleteimg2']) and ($key==$_GET['deleteimg2'])) echo "<a name=\"delete\"></a><a href=\"#\" onclick=\"deleteimgs('".$_GET['deleteimg2']."','$view')\" title=\"",$lang_txt_018,"\" style=\"float:right;position:absolute;float:right;margin-top:30px;margin-left:-40px;padding:3px;border:1px solid #ccc;background:#fff;\">$lang_txt_003</a>";

								echo "</div>";}
							if (!empty($arrimgend[$key]) and (empty($topic))){echo "<small><small>"; if ($arrimgend[$key]=="jpg") echo "<a href=\"#\" onclick=\"rotateimg('".$key."','$view')\" title=\"$lang_txt_167\" style=\"float:left;margin-left:10px;\">r</a>"; echo "<a href=\"#\" onclick=\"deleteimgs2('".$key."','$view')\" title=\"",$lang_txt_018,"\" style=\"float:right\">X</a> </small></small>";}
							if($arrimgend[$key]=="jpg"){$filetime=date ("Y-m-dH-i-s", filemtime($imgname ."-".$key.".jpg"));
						
							if ($img800present==1) { echo " <a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,' <a href=$imgname-$key-800.", $arrimgend[$key]," rel=lightbox[roadtrip]><img src=$imgname-$key.", $arrimgend[$key],"?cache=", $filetime,"></a> ');\"><img src=\"", $imgname,"-",$key,"-150.", $arrimgend[$key],"?cache=", $filetime,"\" title=\"", $lang_txt_015, $arrimgend[$key],"\"/></a>";

							$rememberallimagesforminipictures=$rememberallimagesforminipictures. " <a href=$imgname-$key-800.". $arrimgend[$key]." rel=lightbox[roadtrip]><img src=$imgname-$key-150.". $arrimgend[$key]."?cache=". $filetime."></a>";
							}
							else {echo " <a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,'<img src=$imgname-$key.", $arrimgend[$key],"?cache=", $filetime,">');\"> <img src=\"", $imgname,"-",$key,"-150.", $arrimgend[$key],"?cache=", $filetime, "\" title=\"", $lang_txt_016, $arrimgend[$key],"\"/></a>";	
							$rememberallimagesforminipictures=$rememberallimagesforminipictures. " <a href=$imgname-$key.". $arrimgend[$key]." rel=lightbox[roadtrip]><img src=$imgname-$key-150.". $arrimgend[$key]."?cache=". $filetime."></a>";
								}			
							}

							if($arrimgend[$key]=="png" or $arrimgend[$key]=="gif")
							{if($arrimgend[$key]=="png")$filetime=date ("Y-m-dH-i-s", filemtime($imgname ."-".$key.".png"));else $filetime=date ("Y-m-dH-i-s", filemtime($imgname ."-".$key.".gif"));
							echo "<a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,'<img src=$imgname-$key.", $arrimgend[$key],"?cache=", $filetime,">');\"><img src=\"", $imgname,"-",$key, ".", $arrimgend[$key],"?cache=", $filetime,"\" width=200px title=\"",$lang_txt_017, $arrimgend[$key],"\"/></a>";}
							if (!empty($arrimgend[$key]))echo "</div>";
							
						}
						//...new sortable				
echo "</div>";
if (empty($_GET['deletefile']) and empty($_GET['deletefile2']) and empty($_GET['deletefile2']) and empty($_GET['deleteimg']) and empty($_GET['deleteimg2']) and empty($_GET['rotateimg']))
{

	if ($imageexists==1) {echo "<div class=\"miniboxall\" style=\"float:right;\">",$lang_txt_066,"<br><a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,'".$rememberallimagesforminipictures. "');\" style=\"color:#444;\" title=\"", $lang_txt_062,"\">150px ";if ($view=="oldtonew") echo "(",$lang_txt_161,")"; else echo "(",$lang_txt_160,")"; echo "</a> ";
	echo "<br><a href=\"javascript:;\" onmousedown=\"tinyMCE.execCommand('mceInsertContent',false,'".str_replace ("-150", "", $rememberallimagesforminipictures). "');\" style=\"color:#444;\" title=\"", $lang_txt_063,"\">500px ";if ($view=="oldtonew") echo "(",$lang_txt_161,")"; else echo "(",$lang_txt_160,")";echo " </a></div>";}
	}
}
//...load IMages

}//password
?>
