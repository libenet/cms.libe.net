<?php
$PWgueltigkeit ="2678400";$Reloadsperre =5;
$ip = $_SERVER['REMOTE_ADDR']; 
$wobinich= ""; for ($c = 0; $c <= 10; $c++) if(file_exists($wobinich."var.php"))break; else  $wobinich="../$wobinich";
$Pfaddaten=$wobinich.daten;$Pfadadmin=$wobinich.admin;
@include($wobinich."var.php");
if (file_exists($wobinich."demo.php")) @include($wobinich."demo.php");
if (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2)=="de")@include($wobinich."lang/de.php");else @include($wobinich."lang/en.php");

if (!empty($_POST['kennwort'])){ 
if ($_POST['kennwort'] == $Passwort){

if ($_COOKIE["Passwortfalsch"] != 1){

setcookie ("loginadmin", md5($_POST['kennwort']."-".$ip), time()+$PWgueltigkeit);
echo "<head>";
echo "<meta http-equiv='refresh' content='0 URL=", $Pfadadmin,"/admin.php'><script language=\"javascript\">window.location.href = \"",$Pfadadmin,"/admin.php\"</script></head>";
echo "<body>saving Cookie ... <a href=", $Pfadadmin,"/admin.php>$lang_txt_018</a></body></html>";
}
else echo $lang_txt_017;

}
else 
{
setcookie ("Passwortfalsch", 1, time()+$Reloadsperre);
echo $TEXTPWfalsch;
}}
else
if ($_COOKIE["loginadmin"] != md5($Passwort."-".$ip)){
$phpself = explode ("/", $_SERVER['PHP_SELF']);
if ($phpself[sizeof($phpself)-1]!="login.php") echo "<meta http-equiv='refresh' content='0 URL=", $wobinich,"login.php'><script language=\"javascript\">window.location.href = \"",$wobinich,"login.php\"</script><a href=", $wobinich,"login.php>$lang_txt_018</a>";
else
{
echo "<html><head><link rel=\"stylesheet\" href=\"admin/main.css\" type=\"text/css\" media=\"screen\" /></head><body><form name='data' action='login.php' method='post'><br><br><h1>$lang_txt_016</h1><br>
";
if ($Passwort=="password") echo "$lang_txt_019";
echo"<input name='kennwort' type='password' size='12' maxlength='33'>
<input type='submit' name='weiter' class='submit' value='login'>
</form></body></html>";
}
}
?>
