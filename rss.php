<?php
@include("var.php");
@include("functions.php");
@include("buildpage.php");
$firstparturl= str_replace ("rss.php", "", $firstparturl);
function decodehtmlent($decode)
{
$decode= str_replace ("&uuml;", "ü", $decode);
$decode= str_replace ("&Uuml;", "Ü", $decode);
$decode= str_replace ("&Auml;", "Ä", $decode);
$decode= str_replace ("&auml;", "ä", $decode);
$decode= str_replace ("&Uuml;", "Ü", $decode);
$decode= str_replace ("&ouml;", "ö", $decode);
$decode= str_replace ("&Ouml;", "Ö", $decode);
$decode= str_replace ("&szlig;", "ß", $decode);
$decode= str_replace ("&nbsp;", " ", $decode);
$decode= str_replace ("&quot;", " ", $decode);
$decode= preg_replace("/[^a-zA-Z0-9äöüÄÖÜß ]/", "", $decode);
return $decode;
}



echo "<?xml version=\"1.0\"?>\n<rss version=\"2.0\">
";

$zahlneu=10; //Anzahl der Themen

$title= str_replace ("http://", "", $firstparturl);
$xmlurl=$meineurl. "/rss.php";
// Kopf für XML:

echo "<channel>
   <title>",$page_title, "</title>
   <link>", $firstparturl,"</link>
   <description>",$page_description, "</description>
   <pubDate>" , date("r"), "</pubDate>
   <language>",$language, "</language>";


if (file_exists($templatedir."cms-default.png")) $defaultimg=$firstparturl. $templatedir."cms-default.png";else {if (file_exists($templatedir."cms-default.jpg")) $defaultimg=str_replace ("rss_title_desc.php", "", $firstparturl. $templatedir)."cms-default.jpg";else $defaultimg=$firstparturl."image/cms-default.png";}

rssnewest(10,1);

echo "      
</channel>\n\n</rss>";


//aus build

function rssnewest($maxentries, $images)
{global $newsentryarray,$datumarray,$fileandpathnamearray,$menuarray,$titelmenuarray,$firstparturl,$defaultimg,$smalldescriptionarray,$titelarray;
//$layout: 12 ... 1; 2,. ...
					arsort($datumarray);
					foreach($datumarray as $key => $value) 
					{
					if ($newsentryarray[$key]==1) 
						{if (!empty($menuarray[$key])) $nummer++;
						if ($nummer>$start)
							{



							if (!empty($fileandpathnamearray[$key]))$linkurl= $fileandpathnamearray[$key] ;else $linkurl="index.php/".encodeurl($menuarray[$key]);
							echo "\n<item>\n";
							echo "<title>",decodehtmlent(utf8_encode($titelmenuarray[$key])), "</title>\n";
							echo "<guid>", $firstparturl. str_replace ("rss.php", "",$linkurl). "</guid>\n";
							echo "<link>", $firstparturl. str_replace ("rss.php", "",$linkurl). "</link>\n
							<pubDate>" , date("r",$datumarray[$key]), "</pubDate>\n";
							echo "<description>"; 

							//Images:
							if ($images==1){
							if (!empty($titelmenuarray[$key])) {
							if (empty($previewarray[$key])) $preview=1; else $preview=$previewarray[$key];
								echo "\n<![CDATA[";
								if(file_exists("image/". encodeurl($menuarray[$key])."-$preview-150.jpg")) 
								echo "<img src=\"".str_replace ("rss_title_desc.php", "", $firstparturl."image/". encodeurl($menuarray[$key]))."-$preview-150.jpg\" width=\"150\" ";else echo "<img src=\"",$defaultimg,"\" width=\"150\" ";
								
								echo "alt=\"".encodeurl(trim($titelarray[$key]))."\">";			
												}
								//extend news show beginning topic look for <!-- pagebreak --> in the topic... 
								$Pfad= "daten/".trim(encodeurl($menuarray[$key])).".dat";$datei = fopen($Pfad, "r");$savethetext=fread($datei, filesize($Pfad));fclose($datei);
								$arrayseite = explode ("---///___", $savethetext);
								$arrayseite[2]= str_replace("../image/", $firstparturl. "image/",$arrayseite[2]);
								$arrayseite[2]= str_replace("../download/", $firstparturl. "download/",$arrayseite[2]);	
								$arrayseite[2]= str_replace("//image/", "/image/",$arrayseite[2]);
								if (instr("<!-- pagebreak -->", $arrayseite[2])) {$ttxxtnews=explode ("<!-- pagebreak -->", $arrayseite[2]); echo $ttxxtnews[0];}
								//...extend news show beginning topic	

							echo "\n\n";
									}					
							//... Images

							echo $titelarray[$key], " ", decodehtmlent(utf8_encode($smalldescriptionarray[$key])),"\n]]>\n</description>\n";

			echo "</item>";

							if ($nummer>$maxentries){break;}
							}

						}
					}
}

?>

