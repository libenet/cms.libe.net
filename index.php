<?php
if (!empty($HTTP_POST_VARS["Name"]))setcookie ("cmslibefeedback", $HTTP_POST_VARS["Name"]);
if (!empty($HTTP_POST_VARS["Name*"]))setcookie ("cmslibefeedback", $HTTP_POST_VARS["Name*"]);
//vars...
$PWgueltigkeit=0;
$templateloaded=0;
if( isset( $_COOKIE["loginadmin"] ) ) $loginadmin=$_COOKIE["loginadmin"]; else $loginadmin="";
if( isset( $_GET['login'] ) )$login=$_GET['login'];
if( isset( $_GET['login'] ) ) if ($login=="logoff") setcookie ("loginadmin", "logoff", time()+$PWgueltigkeit);
//...vars
$maintenance="";
@include("var.php");
if (file_exists("demo.php")) @include("demo.php");
@include("functions.php");
if ($language=="auto") $language=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
if ($language=="de")@include("lang/de.php");else @include("lang/en.php");
@include("buildpage.php");
if (!empty($loginadmin) or ($maintenance!="on")){
if  (file_exists($templatedir."/phone-".$index) or file_exists($templatedir."/tablet-".$index)) 
{
    require_once 'plugins/mobile-detect/Mobile_Detect.php';
    $detect = new Mobile_Detect;
    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
    if ($deviceType=="phone" and file_exists($templatedir."/phone-".$index)) {@include($templatedir."/phone-".$index);$templateloaded=1;}
    if ($deviceType=="tablet" and file_exists($templatedir."/tablet-".$index) and $templateloaded!=1) {@include($templatedir."/tablet-".$index);$templateloaded=1;}
}
if ($templateloaded!=1) @include($templatedir."/".$index);


if ($maintenance=="on") echo "<div style=\"position:absolute;color:fff;left:0px;top:0px;z-index:999;background:#000;margin:1px;opacity:0.6;filter:alpha(opacity=60);font-size:10px;padding:10px;\">Website Maintenance!<br> <small>the content is only visible to you, <br>because you are looged in<br><a href=\"index.php?login=logoff\">log-off</a></small></div>";
}else echo "<div style=\"color:000;z-index:999;text-align:center;background:#ccc;margin:1px;padding:10px;\"><h1>This website is under temporary maintenance</h1></div><div style=\"text-align:right\"><a href=\"http://cms.libe.net\">simple cms solution cms.libe.net</a>";

	if (!empty($loginadmin))
	{echo "<div style=\"position:absolute;top:1px;right:1px;padding:1px;opacity:0.6;filter:alpha(opacity=60);background:#fff;\">";
	if(file_exists("feedback/check")) {$datelast =file_get_contents("feedback/check"); echo "<a href=\"".$firstparturl."admin/feedback.php\" style=\"text-decoration:none;font-size:13px;align:0px;padding:0px;color:#F00;\">[new Feedback(s):".date("d.m.Y H:i",$datelast)."]</a>";}
	echo "<a href=\"".$firstparturl."admin/admin.php?file=".$article."&title=". urlencode(decodeurl($article))."\" style=\"text-decoration:none;font-size:10px;align:0px;padding:0px;color:#999;\">[edit]</a>";
	echo "</div>";
	}
?>
