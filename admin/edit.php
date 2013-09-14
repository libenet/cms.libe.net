<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>Editor</title>
<link rel="stylesheet" href="main.css" type="text/css" media="screen" />
</head><body>
<?php 
error_reporting(0);
@include("passwort.php");
@include($wobinich."functions.php");

//@include("$Pfaddateien/oben.php");
if ($_COOKIE["loginadmin"] == md5($Passwort."-".$ip)){

echo "<div id='navi'><div id='navi2'></div>";
echo " <div style=\"position:absolute;width:200;text-align:left;left:0px;top:0px;margin:0px;float:left;\">";
echo "<a href='admin.php?setup=layout' class=\"links\">back</a><br><br>";
echo "</div></div><br><br><br>";

if($_POST['submit']){
$dateiei = fopen("../".$templatedir.$_POST['RELPATH'], "w+");
if (get_magic_quotes_gpc()==1) $FILEDATAd= stripslashes($_POST['FILEDATA']);else $FILEDATAd= $_POST['FILEDATA'];
fwrite($dateiei, $FILEDATAd);
fclose($dateiei);
chmod ($_POST['RELPATH'], 0777);
echo "file saved<br><br>";
}
if (empty($_GET['edit']))

	$dir = "../".$templatedir;
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {   
				if (is_writable("../".$templatedir.$file) and !instr("~",$file) and (instr(".php",$file) or (instr(".js",$file)) or (instr(".html",$file))or (instr(".css",$file)))) echo "| <a href='edit.php?edit=".$file."' class=\"links\">".$file."</a> ";
			}
			closedir($dh);
		    }
		}





if (isset( $_GET['edit'] )){ 
	$fh = fopen("../".$templatedir. str_replace("/", "",$_GET['edit']),"a+");
		rewind($fh) ;
		$fstr = fread($fh,filesize("../".$templatedir.$_GET['edit'])) ;
		fclose($fh) ;
		$fstr = htmlentities($fstr);
echo "<br><br><form name='data' action='edit.php' method='post'><TEXTAREA NAME='FILEDATA' ROWS=25 COLS=120 WRAP='OFF'>", $fstr, "</TEXTAREA>";
echo "<br><INPUT TYPE='hidden' SIZE=70 MAXLENGTH=255 NAME='RELPATH' VALUE='", $_GET['edit']. "'>";
echo "<INPUT TYPE='hidden' NAME='submit' VALUE='submit'>";
echo "<INPUT TYPE='RESET' VALUE='RESET'>";
echo "<INPUT TYPE='SUBMIT' VALUE='speichern!'></form>";
}
}
?>
