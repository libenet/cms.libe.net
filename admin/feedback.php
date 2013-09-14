<?php @include("passwort.php"); if ($_COOKIE["loginadmin"] == md5($Passwort."-".$ip)){
if( isset( $_GET['file'] ) )$file=$_GET['file'];
if( isset( $_GET['setup'] ) )$setup=$_GET['setup'];
if( isset( $_GET['show'] ) )$show=$_GET['show'];

@include($wobinich."functions.php");
error_reporting(0);
if (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2)=="de")@include("de.php");else @include("en.php");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>Feedback</title>
<link rel="stylesheet" href="main.css" type="text/css" media="screen" />
<script language="javascript">
function checkAll(field)
{
for (i = 0; i < field.length; i++)
	field[i].checked = true ;
}

function uncheckAll(field)
{
for (i = 0; i < field.length; i++)
	field[i].checked = false ;
}
</script>
</head>
<body>

<?php
//check if folder and files are writeable:

//menu
echo "<div id='navi'><div id='navi2'></div>";
echo " <div style=\"position:absolute;width:200;text-align:left;left:0px;top:0px;margin:0px;float:left;\">";
if (!empty($file) or (!empty($setup))) echo "<a href=\"feedback.php\">$lang_txt_106</a> <a href=\"feedback.php?setup=approve_all&file=$file\">$lang_txt_104</a> 
<a href=\"../index.php/", $file,"\" title=\"$lang_txt_079 $lang_txt_089\">", $lang_txt_049,"</a>";




echo "<a href=\"admin.php#", $file,"\" title=\"$lang_txt_073 $lang_txt_089\">", $lang_txt_005,"</a> ";
if (empty($file)) if (empty($show)) echo "<a href=\"feedback.php?show=all\">$lang_txt_105</a>"; else echo "<a href=\"feedback.php\">$lang_txt_107</a>";

echo "</div>";
echo " <div style=\"position:absolute;width:200;text-align:right;right:0px;top:0px;margin:0px;float:right;\"><a href=\"../index.php?login=logoff\">$lang_txt_039</a> <a href=\"../\">",$lang_txt_021," [x]</a></div> </div>";

echo "</div><br><br>";


echo "<h1>Feedback</h1>";
if (!empty($file) or (!empty($setup))) echo "<input type=\"button\" name=\"UnCheckAll\" value=\"$lang_txt_108\"
onClick=\"uncheckAll(document.delete)\">
";

/*<input type=\"button\" name=\"CheckAll\" value=\"Check All\"
onClick=\"checkAll(document.delete)\">*/

if ($setup=="approve_all")
{
$dateiinhalt= file_get_contents ("../feedback/$file");
$dateiinhalt=str_replace ("--later--", "",$dateiinhalt);

	$fileopen = fopen("../feedback/$file","w+");
        fwrite($fileopen, $dateiinhalt);
	fclose($fileopen);
}

if (empty($file))
{
	$dir = "../feedback/";
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) 
			{
			while (($filex = readdir($dh)) !== false) 
				{  
				if ($filex!="." and $filex!=".txt" and $filex!=".." and $filex!="checknew" and $filex!="settings.php") 
					{

					$readfile=file_get_contents("../feedback/$filex");			

					//echo "<a href=\"feedback.php?file=$filex\">$filex</a> $filetime<br>";
					if (instr("--later--",$readfile) or $show=="all")
						{
						$filetime=date ("Y-m-d H:i:s", filemtime("../feedback/$filex"));
						$filexarray[$filex]= $filetime; unset($lang_txt_102);
						}


					}
				}
			closedir($dh);
		    	}
		}
		arsort($filexarray);
		foreach($filexarray as $key => $value) 
		{echo "<a href=\"feedback.php?file=$key\">$key</a> $value<br>";
		}
if( isset( $lang_txt_102) )echo $lang_txt_102;

}
else
{
if( isset( $_POST['sure'] ) )$sure=$_POST['sure'];
if(file_exists("../feedback/check")) unlink ("../feedback/check");
if ($_POST['submit']=="save") 
	{ 
//Prüfen:$_POST['numberofentries'] darf nicht grösser als die tatsächliche Zeilenanzahl in der Feedbackdatei sein (Page Reload)
	$dateiinhalt= file_get_contents ("../feedback/$file");
	$zeilen= explode ("<br>",$dateiinhalt);	
	if (count($zeilen) >= $_POST['numberofentries'])
		{
		$fileopen = fopen("../feedback/$file.tmp","w+");
		for ($i=0; $i<=$_POST['numberofentries']+50;$i++)
			{$deletex="delete$i";
			if ($_POST[$deletex]=="delete" and $sure=="sure") 
				{
				echo " $lang_txt_004  ", $deletex,$_POST[$deletex], " ";$checkcount++;
				}
			else
			if (!empty($zeilen[$i]))
				{//echo $zeilen[$i];echo "<br>";
				unset($zeilena);$adminfb="adminfb$i";
				$zeilena= explode ("-|-",$zeilen[$i]);
				for ($j=0; $j<(count($zeilena)-1);$j++)
					{
					
					if (get_magic_quotes_gpc()==1)$adminfbw=stripslashes($_POST[$adminfb]);else $adminfbw=$_POST[$adminfb];
						if ($j==2) fwrite($fileopen, $adminfbw);else fwrite($fileopen, $zeilena[$j]); 
						fwrite($fileopen, "-|-");
					}


				fwrite($fileopen, "<br>");$checkcount++;			
				}
			}
		fclose($fileopen);
		}else echo "ERROR Number of Entries: maybe Page reloaded?";

		if ($checkcount<=$_POST['numberofentries'])
		{
			if (!copy("../feedback/$file.tmp","../feedback/$file")) {
			   echo "copy $file error...\n";
			}else unlink ("../feedback/$file.tmp");
		}else echo "error", $checkcount+1, "=", $_POST['numberofentries'], "<br>";
}


echo "thema:", $file, "<br><form name=\"delete\" action=\"feedback.php?file=$file\" method=\"post\">";
echo "$lang_txt_109<input type=\"text\" size=\"4\" name=\"sure\" /> $lang_txt_110 <input type=\"submit\" name=\"submit\" value=\"save\"><br><br>";
		if (empty($savethetext)) $savethetext= str_replace ("\n", "<br />",file_get_contents("../feedback/$file"));
		$savethetextar=explode("<br>", $savethetext);
		for ($i=(count($savethetextar)-2); $i>=0;$i--)
		{
		if (instr("--later--",$savethetextar[$i]))echo "<b>";
		if (!empty($savethetextar[$i])) {echo "delete:<input type=\"checkbox\" name=\"delete$i\" value=\"delete\"";
		if (instr("--later--",$savethetextar[$i]))echo " checked";
		echo "><br>";
				unset ($zeilena);
				$zeilena= explode ("-|-",$savethetextar[$i]);
				for ($j=0; $j<(count($zeilena)-1);$j++)
					{ 	if ($j=="0") echo " Datum:";
						if ($j=="1") echo " IP:";
						if ($j!="2")echo $zeilena[$j]; 
						if ($j>"1")echo "<br>";
					}
		
		echo "<br>Kommentar:<input type=\"text\" value=\"$zeilena[2]\"name=\"adminfb$i\" />";
		}



		if (instr("--later--",$savethetextar[$i]))echo "</b>";echo "<hr>";
		}
$numberofentries=count($savethetextar);
echo "<input type=\"hidden\" VALUE=\"$numberofentries\" name=\"numberofentries\" />";
echo "</form>";
}
?>


<?php }else echo "denied";?>
