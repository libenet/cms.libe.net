<?php
//Variablen:
$feedbackformular=str_replace("0AREA0", "|",str_replace("0STAR0", "*",str_replace("0SLASH0", "/",str_replace("0COLON0", ":",str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $feedbackformular)))))));
//loaded via global variables
$spalten = explode(";", $feedbackformular);

//$feedbackapprove="later"; //loaded via global variables

$emails=explode(";", str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $email))));
$badwordsa=explode(";", str_replace("0EQUAL0", "=",str_replace("0SLASH0", "/",str_replace("0COLON0", ":",str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $badwords)))))));

if (!empty($article)){
 //$$$ Feedback $$$
if( !isset( $HTTP_GET_VARS ) )
$HTTP_GET_VARS =& $_GET;
if( !isset( $HTTP_POST_VARS ) )
$HTTP_POST_VARS =& $_POST;
if( !isset( $HTTP_SERVER_VARS ) )
$HTTP_SERVER_VARS =& $_SERVER;
$magicquotes=get_magic_quotes_gpc();

for($i=0; $i < count($spalten); $i++)
   {if ($magicquotes==1)$$spalten[$i]=stripslashes($HTTP_POST_VARS[$spalten[$i]]);else $$spalten[$i]=$HTTP_POST_VARS[$spalten[$i]];
   
   }

$submit=$HTTP_POST_VARS['submit'];

//Findout Feedback Page
$requri = explode("/", $_SERVER['REQUEST_URI']);
$article2=$requri[count($requri)-1];
$pieces = explode( '-feedback-', $article2 );
$teilseite=$pieces[1];$teilseite=str_replace (".php", "", $teilseite);


if (empty($feedback))$feedback="n/a";

$maxeintraege=10;
echo "<a name=\"feedback\"></a>";

//-----------------------------------------------Feedback-----------------------------------------------
echo "<div class=\"feedback\">";
//Auslesen:

$teill1="feedback/";

$article=str_replace (".php", "", $article);
$teill2=$article;
$teill2=str_replace (".php", "", $teill2);

$woises1 =$teill1.$teill2;
$dateiinhalt= file_get_contents ("feedback/$article");

if ($feedbackapprove=="later") $dateiinhalta=explode("--later--",$dateiinhalt);else $dateiinhalta[0]=$dateiinhalt;

$zeilen= explode ("<br>", str_replace ("--later--", "",$dateiinhalta[0]));

$seiten=round(((sizeof($zeilen)-1)/$maxeintraege)+0.5)-1;
$rest=($maxeintraege*($seiten+1))-(sizeof($zeilen)-1);
// echo "rest bis vollständige Seite:",$rest, " ";
if (empty($teilseite))$teilseite=$seiten;
$teilstart=($maxeintraege*$teilseite)-1-$rest+$maxeintraege; //Eintag NR neuerster Kommentar
if ($teilseite==1)$teilende=0; else $teilende=$teilstart-$maxeintraege+1;//Eintag NR ältester Kommentar

echo "<br />";
function buildnavi()
{global $maxeintraege,$teilseite,$seiten,$zeilen,$teilseiteurl,$article,$submit,$fileandpathname,$requesturi,$lang_txt_004,$lang_txt_003,$lang_txt_002,$lang_txt_001;



		if ($submit!="submit") if ((sizeof($zeilen))>$maxeintraege*2)
		{
			echo "<table width=\"100%\"><tr><td class=\"center\">";
		if ($teilseite!=$seiten)
		{
			if (($teilseite+1)!=$seiten) {$teilseiteurl=$teilseite+1;
			echo "<a href=\"",$requesturi,"-feedback-", $teilseiteurl, "#feedback \" class=\"url\">&lt; $lang_txt_004</a> ";}else echo "<a href=\"",$requesturi, "#feedback \" class=\"url\">&lt; zur&uuml;ck</a> ";
		}
		
			echo "</td><td class=\"center\">$lang_txt_002: ";
			for ($w = $seiten; $w >= 1; $w--)
			{
				if ($teilseite!=$w)
				{	
					if  ((($teilseite < $w+5) && ($teilseite > $w-5)) || ($w == $seiten) || ($w == 1))
					{  if ($teilseite > 5) if ($w==1) echo " ... ";
						if ($w!=$seiten) {echo " <a href=\"", $requesturi,"-feedback-", $w, "#feedback \" class=\"url\">",$w,"</a> ";}else echo " <a href=\"", $requesturi,"#feedback \" class=\"url\">",$w,"</a> ";
						if ($teilseite < ($seiten-5)) if ($w==$seiten) echo " ... ";
					}
				}
				else echo " ",$w; 
			}
				echo "</td><td class=\"center\">";
				if ($teilseite!=1) {$teilseiteurl=$teilseite-1;
				echo "<a href=\"",$requesturi,"-feedback-",$teilseiteurl,"#feedback\" class=\"url\">$lang_txt_003 &gt;</a> ";}
				echo "</td></tr></table><br />";
		}
}

buildnavi();

if ((sizeof($zeilen))<=1) echo $lang_txt_005;else
for ($w = $teilstart; $w >= $teilende ; $w--)
{ 
	$arraysplit = explode ("-|-", $zeilen[$w]);

	if ($submit!="submit") if (!empty($arraysplit[0]))
		{
		 echo "<hr><small>(Nr.:",$w+1,")</small> $lang_txt_001:", $arraysplit[0], "<br>";
                 for($i=0; $i < count($spalten); $i++)
  		 {if (!empty($arraysplit[$i+3]))echo "<b>", str_replace("*", "",str_replace("|", "",$spalten[$i])), " :</b><p> ", nl2br($arraysplit[$i+3]), "</p>";}
		echo "";
		if (!empty($arraysplit[2]))echo "<br><b>$lang_txt_014 </b>", $arraysplit[2], "<br />";
		}
}

buildnavi();

if ($submit!="submit") echo $lang_txt_006;


$seiten=round(((sizeof($zeilen)-1)/$maxeintraege)+0.5)-1;
$rest=($maxeintraege*($seiten+1))-(sizeof($zeilen)-1);
// echo "rest bis vollständige Seite:",$rest, " ";
if (empty($teilseite))$teilseite=$seiten;
$teilstart=($maxeintraege*$teilseite)-1-$rest+$maxeintraege; //Eintag NR neuerster Kommentar
if ($teilseite==1)$teilende=0; else $teilende=$teilstart-$maxeintraege+1;//Eintag NR ältester Kommentar

echo "<br />";

$time= microtime(); $timestartar = explode (" ", $time); $timepost=$timestartar[0]+$timestartar[1];
$libefeed = explode ("|||", $HTTP_COOKIE_VARS["cmsfeedback"]);
if ($submit=="submit") {

	for($i=0; $i < count($spalten); $i++)
	   {
		if (empty($$spalten[$i])){if (instr("*",$spalten[$i])){unset($submit); echo "$lang_txt_013 ", str_replace("*", "",str_replace("|", "",$spalten[$i]));}}
	   }
}

if ($submit!="submit") {echo "
<form name=\"data\" action=\"",$requesturi,"\" method=\"post\"><table width=600 class=\"auswahl\">";
	for($i=0; $i < count($spalten); $i++)
	   { echo "<tr><td width=\"20\" valign=\"top\">",str_replace("|", "",$spalten[$i]), ":</td><td>";
		if ($spalten[$i]=="Name*" or $spalten[$i]=="Name") if (!empty($_COOKIE["cmslibefeedback"]))$$spalten[$i]=$_COOKIE["cmslibefeedback"];
	     if (instr("|",$spalten[$i])) echo "<textarea name=\"",$spalten[$i],"\" rows=\"5\" cols=\"50\">", $$spalten[$i],"</textarea>";
			else echo "<input type=\"text\" size=\"20\" maxlength=\"255\" name=\"", $spalten[$i], "\" value=\"", $$spalten[$i],"\" />";
	     echo "</td></tr>";
	   }

echo "
<tr><td><input type=\"hidden\" name=\"submit\" value=\"submit\" />
<input type=\"hidden\" name=\"teill2\" value=\"", $teill2, "\" />
<br /><br /><input type=\"submit\" value=\"$lang_txt_007\" /></td></tr></table></form>";
}else 
{

// save the Entry:
$fehler="kein";
$arraysplit = explode ("-|-", $zeilen[sizeof($zeilen)-2]);

if($fehler=="kein"){
	echo "<center><b>$lang_txt_008 ";
	if ($feedbackapprove=="later") echo "<br>$lang_txt_009";
	echo "</b></center>";
	$zeit =date("d.m.Y H:i");

	if ($magicquotes==1)$feedback=stripslashes(nl2br(htmlentities($feedback)));else $feedback=nl2br(htmlentities($feedback));
	$feedback= str_replace ("\n", " ", $feedback);
	$feedback= str_replace ("\r", " ", $feedback);

        //bad check
	$mergefeedback=$mergefeedback. $_SERVER['HTTP_HOST'].$_SERVER['REMOTE_ADDR'];
	for($i=0; $i < count($spalten); $i++)
	   { 
		$mergefeedback=$mergefeedback. $$spalten[$i];
	   }

	for($i=0; $i < count($badwordsa); $i++)
	   { 
		if (instr($badwordsa[$i], $mergefeedback)) $bad=1;
	   }
	//bad check


	if ($bad==1) echo "ERROR SPAM";
	if ($bad!=1){

$Betreff="$lang_txt_011: " .$article;

$emailtext="$lang_txt_012 http://". $_SERVER['HTTP_HOST']."/login.php";
	for($i=0; $i < count($spalten); $i++)
	   {$txtxx=$$spalten[$i];
		 $emailtext= "$emailtext
		 $spalten[$i] : $txtxx";
	  }

$sendermail=str_replace("0EQUAL0", "=",str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $sendermail))));
$headers = "From:" . $sendermail;

	for($i=0; $i < count($emails); $i++)
	   { 
		mail($emails[$i], $Betreff, $emailtext,$headers, "-f $sendermail");
	   }

	$txt="txt
	";
        $IP=$_SERVER['REMOTE_ADDR'];
	$count = fopen("$woises1","a+");
          fwrite($count, "--later--");
	  fwrite($count, $zeit);
	  fwrite($count, "-|-");
	  fwrite($count,  $IP);
	  fwrite($count, "-|-");
	  fwrite($count, "-|-");
	for($i=0; $i < count($spalten); $i++)
	   {
		  fwrite($count, $$spalten[$i]);
		  fwrite($count, "-|-");
	   }

	  fwrite($count, "<br>");
	  fclose($count);

	  $count = fopen("feedback/check","w+");
	  fwrite($count, time());
	  fclose($count);
	  }
	//echo "<head><meta http-equiv='refresh' content='0 URL=", $HTTP_SERVER_VARS['PHP_SELF'], "'></head>";

	}else echo "$lang_txt_010";
}
//

echo "</div>";
//-----------------------------------------------Feedback-----------------------------------------------
}//empty article close
?>
