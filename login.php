<?php
@include("var.php");
@include("functions.php");
@include("admin/passwort.php");
$ip = $_SERVER['REMOTE_ADDR']; 
$edit="0";
if ($edit=="logout"){setcookie ("loginadmin", "!logout!");echo "ausgeloggt";}else{
// Passwortüberprüfung: (alles in der Klammer wird nur mit gültigem Cookie angezeigt:!)
if (!empty($_COOKIE['loginadmin'])){$loginadmin=$_COOKIE["loginadmin"];} else $loginadmin="0";

if ($loginadmin == md5($Passwort."-".$ip)){
echo "<meta http-equiv='refresh' content='1 URL=", $Pfadadmin, "/admin.php'><script language=\"javascript\">window.location.href = \"",$Pfadadmin,"/admin.php\"</script><a href=", $Pfadadmin,"/admin.php>$lang_txt_018</a>";}
}
?>
