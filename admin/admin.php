<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<?php 
@include("passwort.php");

if ($_COOKIE["loginadmin"] == md5($Passwort."-".$ip)){ 
if( isset( $_GET['file'] ) )$file=$_GET['file'];
if( isset( $_GET['setup'] ) )$setup=$_GET['setup'];else $setup="";
@include($wobinich."functions.php");

ini_set("memory_limit","-1");
ini_set('max_execution_time', 900);

error_reporting(0);
if ($language=="de") $inclanguage="de"; else $inclanguage="en"; 
if ($language=="auto") $inclanguage=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
if ($inclanguage=="de")@include("de.php");else @include("en.php");
if (empty($language)) $language="auto";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>Seite bearbeiten</title>
<script language="JavaScript" type="text/javascript" src="../plugins/jquery/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="main.css" type="text/css" media="screen" />

<?php if (!empty($file)){?>
<!-- HTML5 FileUpload... -->
<script src="file-upload/js/jquery.filedrop.js"></script>
<script src="file-upload/js/script.js"></script>
<style>
#images .preview {
    float: left;z-index:999;
    height: 100px;top:0px;
    margin: 0px 0 0 5px;
    position: relative;
    text-align: center;
    width: 100px;
}
#images .uploaded{
    background: url("file-upload/img/done.png") no-repeat scroll center center rgba(255, 255, 255, 0.5);
    height: 100px;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
}
#images .preview img{max-width:100px;max-height:100px;float:left;
    text-align: center;
}
#images .preview.done .uploaded {height:100px;width:100px;
    display: block;
}

#images .progressHolder {
    background-color: #252F38;
    bottom: 0;
    box-shadow: 0 0 2px #000000;
    height: 5px;
    left: 0;
    position: absolute;
    width: 100px;
}
#images .progress {
    background-color: #fff;
    box-shadow: 0 0 1px rgba(255, 255, 255, 0.4) inset;
    height: 100%;
    left: 0;
    position: absolute;
    transition: all 0.25s ease 0s;
}
</style>
<?php $dir = "../download/dropupload";
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) 
		{
		while (($filex = readdir($dh)) !== false) 
			{  
				if ($filex!="." and $filex!="..") 
					{ 
 					 unlink($dir."/".$filex);
					}
			}
		closedir($dh);
		}
			}
rmdir($dir);
 ?>
<!-- ...HTML5 FileUpload -->

<style>body
{background:#fff;
background-image:url(bg.jpg);background-repeat:repeat-x;background-position:0px 50px;
}
</style>
<?php }?>

<?php if ($file!="dat_menu_file")  if (!empty($file) or !empty($_GET['loadmce'])) {?>
<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
        	selector : "textarea#mce",
		theme : "modern",
		skin : "lightgray_libe",
   		gecko_spellcheck : true,
		<?php if ($inclanguage=="de") echo "language : \"de\",";?>
		// Example content CSS (should be your site CSS)
		content_css : "../<?php echo $templatedir; ?>tinymce.css<?php //read tinymce.css for additional CSS to load:
		$readadditionalcss= file_get_contents("../".$templatedir."tinymce.css");
		if (instr("*INCLUDE:",$readadditionalcss)) preg_match_all("|INCLUDE:(.*?):INCLUDE|U",$readadditionalcss,$treffer, PREG_SET_ORDER);
		foreach ($treffer as $wert) {
		if (!empty($wert[1])) echo  ",".str_replace("templatedir/", $templatedir,$wert[1]);
		}
		?>"
 ,style_formats:[
                        {
                            title: "Headers",
                            items: [
                                {title: "Header 1",format: "h1"},
                                {title: "Header 2",format: "h2"},
                                {title: "Header 3",format: "h3"},
                                {title: "Header 4",format: "h4"},
                                {title: "Header 5",format: "h5"},
                                {title: "Header 6",format: "h6"}
                            ]
                        },
                        {
                            title: "Inline",items: [{title: "Bold",icon: "bold",format: "bold"}, {title: "Italic",icon: "italic",format: "italic"}, 
            {title: "Underline",icon: "underline",format: "underline"}, {title: "Strikethrough",icon: "strikethrough",format: "strikethrough"}, {title: "Superscript",icon: "superscript",format: "superscript"}, {title: "Subscript",icon: "subscript",format: "subscript"}, {title: "Code",icon: "code",format: "code"}]}, 
            {title: "Blocks",items: [{title: "Paragraph",format: "p"}, {title: "Blockquote",format: "blockquote"}, {title: "Div",format: "div"}, {title: "Pre",format: "pre"}]}, 
            {title: "Alignment",items: [{title: "Left",icon: "alignleft",format: "alignleft"}, {title: "Center",icon: "aligncenter",format: "aligncenter"}, {title: "Right",icon: "alignright",format: "alignright"}, {title: "Justify",icon: "alignjustify",format: "alignjustify"}]}, 
	    {title: "Font Size", items: [
		                        {title: '8pt', inline:'span', styles: { fontSize: '12px', 'font-size': '8px' } },
		                        {title: '10pt', inline:'span', styles: { fontSize: '12px', 'font-size': '10px' } },
		                        {title: '12pt', inline:'span', styles: { fontSize: '12px', 'font-size': '12px' } },
		                        {title: '14pt', inline:'span', styles: { fontSize: '12px', 'font-size': '14px' } },
		                        {title: '16pt', inline:'span', styles: { fontSize: '12px', 'font-size': '16px' } },
		                        {title: '18pt', inline:'span', styles: { fontSize: '12px', 'font-size': '18px' } },
		                        {title: '20pt', inline:'span', styles: { fontSize: '12px', 'font-size': '20px' } },
		                        {title: '22pt', inline:'span', styles: { fontSize: '12px', 'font-size': '22px' } },
		                        {title: '24pt', inline:'span', styles: { fontSize: '12px', 'font-size': '24px' } },
		                        {title: '26pt', inline:'span', styles: { fontSize: '12px', 'font-size': '26px' } },
		                        {title: '28pt', inline:'span', styles: { fontSize: '12px', 'font-size': '28px' } }
	]
	}],

    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor"
    ],
    toolbar1: "undo redo | styleselect | bold italic removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor emoticons",
    image_advtab: true,
	});
</script>



<style>
.mce-btn button:hover{border-width:0px;}
</style>
<!-- /TinyMCE -->


<!-- /datepicker -->
	<script src="../plugins/jquery/ui/jquery.ui.core.min.js"></script>
	<script src="../plugins/jquery/ui/jquery.ui.widget.min.js"></script>
	<script src="../plugins/jquery/ui/jquery.ui.datepicker.min.js"></script>
	<script src="../plugins/jquery/ui/jquery.ui.timepicker-addon.js"></script>

	<script>
	$(function() {
		$( "#datepicker" ).datetimepicker('');
	});

jQuery(function($){
        $.datepicker.regional['de'] = {clearText: 'löschen', clearStatus: 'aktuelles Datum löschen',
                closeText: 'schließen', closeStatus: 'ohne Änderungen schließen',
                prevText: '<zurück', prevStatus: 'letzten Monat zeigen',
                nextText: 'Vor>', nextStatus: 'nächsten Monat zeigen',
                currentText: 'heute', currentStatus: '',
                monthNames: ['Januar','Februar','M&auml;rz','April','Mai','Juni',
                'Juli','August','September','Oktober','November','Dezember'],
                monthNamesShort: ['Jan','Feb','M&auml;r','Apr','Mai','Jun',
                'Jul','Aug','Sep','Okt','Nov','Dez'],
                monthStatus: 'anderen Monat anzeigen', yearStatus: 'anderes Jahr anzeigen',
                weekHeader: 'Wo', weekStatus: 'Woche des Monats',
                dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
                dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
                dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
                dayStatus: 'Setze DD als ersten Wochentag', dateStatus: 'Wähle D, M d',
                dateFormat: 'dd.mm.yy', firstDay: 1, 
		  timeOnlyTitle: 'Uhrzeit ausw&auml;hlen',
		  timeText: 'Zeit',
		  hourText: 'Stunde',
		  minuteText: 'Minute',
		  secondText: 'Sekunde',
		  currentText: 'Jetzt',
		  closeText: 'Ausw&auml;hlen',
		  ampm: false,
		
                initStatus: 'Wähle ein Datum', isRTL: false};
        $.datepicker.setDefaults($.datepicker.regional['<?php if ($inclanguage=="de") echo "de";?>']);
});


	</script>
<style>
.ui-datepicker {
	width: 17em;
	padding: .2em .2em 0;
	display: none;background:#fff;position:relative;padding:5px;border:1px solid #555;
}
.ui-state-highlight{color:#999;}
.ui-state-active{color:#999;border:1px solid #ddd;}
.ui-datepicker .ui-datepicker-header {
	position: relative;
	padding: .2em 0;
}
.ui-datepicker .ui-datepicker-prev,
.ui-datepicker .ui-datepicker-next {
	position: absolute;
	top: 2px;
	width: 1.8em;
	height: 1.8em;
}
.ui-datepicker .ui-datepicker-prev-hover,
.ui-datepicker .ui-datepicker-next-hover {
	top: 1px;
}
.ui-datepicker .ui-datepicker-prev {
	left: 2px;
}
.ui-datepicker .ui-datepicker-next {
	right: 2px;
}
.ui-datepicker .ui-datepicker-prev-hover {
	left: 1px;
}
.ui-datepicker .ui-datepicker-next-hover {
	right: 1px;
}
.ui-datepicker .ui-datepicker-prev span,
.ui-datepicker .ui-datepicker-next span {
	display: block;
	position: absolute;
	left: 50%;
	margin-left: -8px;
	top: 50%;
	margin-top: -8px;
}
.ui-datepicker .ui-datepicker-title {
	margin: 0 2.3em;
	line-height: 1.8em;
	text-align: center;
}
.ui-datepicker .ui-datepicker-title select {
	font-size: 1em;
	margin: 1px 0;
}
.ui-datepicker select.ui-datepicker-month-year {
	width: 100%;
}
.ui-datepicker select.ui-datepicker-month,
.ui-datepicker select.ui-datepicker-year {
	width: 49%;
}
.ui-datepicker table {
	width: 100%;
	font-size: .9em;
	border-collapse: collapse;
	margin: 0 0 .4em;
}
.ui-datepicker th {
	padding: .7em .3em;
	text-align: center;
	font-weight: bold;
	border: 0;
}
.ui-datepicker td {
	border: 0;
	padding: 1px;
}
.ui-datepicker td span,
.ui-datepicker td a {
	display: block;
	padding: .2em;
	text-align: right;
	text-decoration: none;
}
.ui-datepicker .ui-datepicker-buttonpane {
	background-image: none;
	margin: .7em 0 0 0;
	padding: 0 .2em;
	border-left: 0;
	border-right: 0;
	border-bottom: 0;
}
.ui-datepicker .ui-datepicker-buttonpane button {
	float: right;
	margin: .5em .2em .4em;
	cursor: pointer;
	padding: .2em .6em .3em .6em;
	width: auto;
	overflow: visible;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	float: left;
}

/* with multiple calendars */
.ui-datepicker.ui-datepicker-multi {
	width: auto;
}
.ui-datepicker-multi .ui-datepicker-group {
	float: left;
}
.ui-datepicker-multi .ui-datepicker-group table {
	width: 95%;
	margin: 0 auto .4em;
}
.ui-datepicker-multi-2 .ui-datepicker-group {
	width: 50%;
}
.ui-datepicker-multi-3 .ui-datepicker-group {
	width: 33.3%;
}
.ui-datepicker-multi-4 .ui-datepicker-group {
	width: 25%;
}
.ui-datepicker-multi .ui-datepicker-group-last .ui-datepicker-header,
.ui-datepicker-multi .ui-datepicker-group-middle .ui-datepicker-header {
	border-left-width: 0;
}
.ui-datepicker-multi .ui-datepicker-buttonpane {
	clear: left;
}
.ui-datepicker-row-break {
	clear: both;
	width: 100%;
	font-size: 0;
}

/* RTL support */
.ui-datepicker-rtl {
	direction: rtl;
}
.ui-datepicker-rtl .ui-datepicker-prev {
	right: 2px;
	left: auto;
}
.ui-datepicker-rtl .ui-datepicker-next {
	left: 2px;
	right: auto;
}
.ui-datepicker-rtl .ui-datepicker-prev:hover {
	right: 1px;
	left: auto;
}
.ui-datepicker-rtl .ui-datepicker-next:hover {
	left: 1px;
	right: auto;
}
.ui-datepicker-rtl .ui-datepicker-buttonpane {
	clear: right;
}
.ui-datepicker-rtl .ui-datepicker-buttonpane button {
	float: left;
}
.ui-datepicker-rtl .ui-datepicker-buttonpane button.ui-datepicker-current,
.ui-datepicker-rtl .ui-datepicker-group {
	float: right;
}
.ui-datepicker-rtl .ui-datepicker-group-last .ui-datepicker-header,
.ui-datepicker-rtl .ui-datepicker-group-middle .ui-datepicker-header {
	border-right-width: 0;
	border-left-width: 1px;
}
}

/* css for timepicker */
.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
.ui-timepicker-div dl { text-align: left; }
.ui-timepicker-div dl dt { float: left; clear:left; padding: 0 0 0 5px; }
.ui-timepicker-div dl dd { margin: 0 10px 10px 45%; }
.ui-timepicker-div td { font-size: 90%; }
.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }

.ui-timepicker-rtl{ direction: rtl; }
.ui-timepicker-rtl dl { text-align: right; padding: 0 5px 0 0; }
.ui-timepicker-rtl dl dt{ float: right; clear: right; }
.ui-timepicker-rtl dl dd { margin: 0 45% 10px 10px; }
<!-- /datepicker -->
</style>
<?php }?>

<?php 
if (empty($setup)) echo "<link rel=\"stylesheet\" href=\"nestable-style.css\" type=\"text/css\" media=\"screen\" />";
?>

<?php if ($file=="dat_menu_file") echo "<style> textarea{color:#cc0000;}</style>";?>

<!--[if IE 9]>
<style>
.nestable-menu input{margin:14px;padding:1px;float:left;}
</style>
<![endif]-->
<style>
#loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;background:#000;opacity: 0.4;  -moz-opacity: 0.4;   -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";filter:alpha(opacity=40); }
#loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
</style>
</head>
<body>
<script type="text/javascript">
window.onload = function(){ $("#loading").fadeOut(100); } 
$(document).ready(function() {
$('#articleform').submit(function(){
  $('#loading').fadeIn(100);
});
})
</script>


<div id="loading">
<img id="loading-image" src="../plugins/lightbox/images/loading.gif" alt="Loading..." />
</div>


<br><br>
<?php
//save Konfig changes to var.php File:
if (!empty($setup) and $setup!="settings" and $setup!="layout")
{
if ($setup=="maintenance_on")$maintenance="on";
if ($setup=="maintenance_off")$maintenance="off";
if ($setup=="modrewrite_on")$modrewrite="on";
if ($setup=="modrewrite_off")$modrewrite="off";
if ($setup=="expand_all")$expand_all="all";
if ($setup=="collapse_all")$expand_all="collapse";
if ($setup=="collapse_li")$expand_all="collapseli";
if ($setup=="feedback"){
	$email=encodeurl(str_replace(";", "0SEMI0",str_replace(".", "0DOT0",str_replace("@", "0AT0", $_POST['email']))));
	$sendermail=encodeurl(str_replace(".", "0DOT0",str_replace("@", "0AT0", $_POST['sendermail'])));
	$badwords=encodeurl(str_replace("=", "0EQUAL0",str_replace(":", "0COLON0",str_replace(";", "0SEMI0",str_replace(".", "0DOT0",str_replace("@", "0AT0",str_replace("/", "0SLASH0", $_POST['badwords'])))))));
	$feedbackformular=encodeurl(str_replace("|", "0AREA0",str_replace("*", "0STAR0",str_replace(":", "0COLON0",str_replace(";", "0SEMI0",str_replace(".", "0DOT0",str_replace("@", "0AT0",str_replace("/", "0SLASH0", $_POST['feedbackformular']))))))));
	$feedbackapprove=$_POST['feedbackapprove'];}
if ($setup=="template"){
	$page_title=encodeurl(str_replace("&", "0AND0",str_replace(" ", "0SPACE0",str_replace("=", "0EQUAL0",str_replace(":", "0COLON0",str_replace(";", "0SEMI0",str_replace(".", "0DOT0",str_replace("@", "0AT0",str_replace("/", "0SLASH0", htmlentities($_POST['page_title']))))))))));
	$page_description=encodeurl(str_replace("&", "0AND0",str_replace(" ", "0SPACE0",str_replace("=", "0EQUAL0",str_replace(":", "0COLON0",str_replace(";", "0SEMI0",str_replace(".", "0DOT0",str_replace("@", "0AT0",str_replace("/", "0SLASH0", htmlentities($_POST['page_description']))))))))));

}

if ($setup=="password")
{
if ($_POST['password1']==encodeurl($_POST['password1']) and strlen($_POST['password1'])>5)
	{
	if ($_POST['password1']==$_POST['password2'])
		{
		$Passwort=encodeurl($_POST['password1']);echo $lang_txt_098;
		}else 
		{echo "<div class=\"warning\">$lang_txt_099 </div>";$setup=settings;}	
	}else echo "<div class=\"warning\">$lang_txt_100 </div>";
}
if ($setup=="language") $language=$_POST['language'];


if ($setup=="change_layout"){$layout=$_GET['layout'];
if (get_magic_quotes_gpc()==1) $layout=stripslashes($layout);$templatedir ="template/". $layout. "/"; echo "<br>layout changed to: $templatedir";}

$dateieix = fopen("../var.php", "w+");
$write = array("<", "?php ", 
"$", "templatedir =\"", $templatedir,"\"", ";", 
"$", "feedbackapprove =\"", $feedbackapprove,"\"", ";", 
"$", "email =\"", $email,"\"", ";", 
"$", "sendermail =\"",$sendermail,"\"", ";", 
"$", "language =\"",$language,"\"", ";",
"$", "expand_all =\"",$expand_all,"\"", ";",
"$", "page_title =\"",$page_title,"\"", ";",
"$", "page_description =\"",$page_description,"\"", ";",
"$", "badwords =\"", $badwords,"\"", ";",
"$", "feedbackformular =\"", $feedbackformular,"\"", ";",
"$", "index =\"", "index.php\"", ";", 
"$", "maintenance =\"",$maintenance,"\"", ";", 
"$", "modrewrite =\"", $modrewrite, "\"", ";", 
"$", "Passwort =\"", $Passwort, "\"", ";", 
"?", ">");
for ($i = 0; $i <= sizeof($write); $i++) fwrite($dateieix, "$write[$i]");fclose($dateieix);
if ($setup!="newversion2" and $setup!="newversion") echo "<br>$lang_txt_143";
}



//check if folder and files are writeable:
if (!is_writable('../var.php')) echo "<div class=\"warning\">",$lang_txt_023, "</div>";
if (!is_writable('../image')) echo "<div class=\"warning\">",$lang_txt_024, "</div>";
if (!is_writable('../daten')) echo "<div class=\"warning\">",$lang_txt_025, "</div>";
if (!is_writable('../download')) echo "<div class=\"warning\">",$lang_txt_030, "</div>";
if (!is_writable('../daten/dat_menu_file.dat')) echo "<div class=\"warning\">",$lang_txt_027, "</div>";
if (file_exists("../.htaccess") and $modrewrite=="on" and !is_writable('../.htaccess')) echo "<div class=\"warning\">",$lang_txt_053, "</div>";
$dir = "../daten/";
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) 
		{
		while (($filex = readdir($dh)) !== false) 
			{  
			if (!is_writable("../daten/".$filex) and $filex!="." and $filex!=".txt" and $filex!="..") echo "<div class=\"warning\">/daten/", $filex, " ",$lang_txt_026, "</div>>";
			}
		closedir($dh);
	    	}
	}

//check for default Password:
if ($Passwort=="password") echo "<div class=\"warning\">", $lang_txt_028, "</div><br>";
if ($setup=="newversion")
{
echo "<h1>Software Update:</h1><div class=\"settings\"><br>$lang_txt_150<br><a href=\"admin.php?setup=newversion2\" title=\"\" style=\"color: #F00;\">$lang_txt_151</a> </div>";
}
if ($setup=="newversion2")
{
	echo "<h1>Software Update</h1>$lang_txt_152<br>";
	$timestamp = date("YmdHis",time());
 	echo "$lang_txt_153:  /download/backup-".$timestamp; 
	$time_start = microtime(true);//logging
	$timenow=microtime(true)-$time_start;file_put_contents("update.log", "\nstarting..".$timenow, FILE_APPEND | LOCK_EX);//logging
	$path = '../download/temp-update.zip'; //address of local file
	$con=file_get_contents('http://cms.libe.net/download/update.zip');
	$timenow=microtime(true)-$time_start;file_put_contents("update.log", "\nDownload finished:".$timenow, FILE_APPEND | LOCK_EX);//logging
	$updatedneeded=0;$countupdate=0;$donotneedupdate=0;
	if ($con !== false) {
			file_put_contents($path, $con);
			$zip = new ZipArchive;
			mkdir("../download/update-temp-extract", 0755);//dir for temp zip extract
			$res = $zip->open("../download/temp-update.zip");

			$timenow=microtime(true)-$time_start;file_put_contents("update.log", "\nzip opened:".$timenow, FILE_APPEND | LOCK_EX);//logging
			if ($res === TRUE) {	

			if ($zip->extractTo("../download/update-temp-extract/") ===TRUE) 
			{

			for($i = 0; $i < $zip->numFiles; $i++) 
			{
			$timenow=microtime(true)-$time_start;file_put_contents("update.log", "\npre get name index". $timenow, FILE_APPEND | LOCK_EX);//logging
	
			$filename2 = $zip->getNameIndex($i);
			$timenow=microtime(true)-$time_start;file_put_contents("update.log", "\nfile..".$filename2."". $timenow, FILE_APPEND | LOCK_EX);//logging
										 
			$outputFile="../". $filename2;

			

			if ($filename2[strlen($filename2)-1]!= "/" and $filename2[strlen($filename2)-1]!= "~")
				{ $timenow=microtime(true)-$time_start;file_put_contents("update.log", "\npre md5 post extract.".$filename2." ". $timenow, FILE_APPEND | LOCK_EX);//logging
						if (md5_file($outputFile)!=md5_file("../download/update-temp-extract/".$filename2))
						//if (!compare_files($outputFile, "../download/update-temp-extract/".$filename2))
						{$timenow=microtime(true)-$time_start;file_put_contents("update.log", "\nFiles are different..".$filename2." ". $timenow, FILE_APPEND | LOCK_EX);//logging

							if (file_exists($outputFile)) mkdir(dirname("../download/backup-".$timestamp."/".$filename2), 0755,true);
							if (!copy($outputFile, "../download/backup-".$timestamp."/".$filename2) and file_exists($outputFile)) 
							{
							  echo "<br>", $outputFile," BACKUPERROR "; 
							}else 
							{echo "<br> FILE:", $outputFile," Extract OK, BackupOK";
								$timenow=microtime(true)-$time_start;file_put_contents("update.log", "\n post extract ok backup ok ". $timenow, FILE_APPEND | LOCK_EX);//logging
								mkdir(dirname("../".$filename2), 0755,true);
								if (!copy("../download/update-temp-extract/". $filename2, "../".$filename2)) {
								  chmod("../".$filename2, 777);
								$timenow=microtime(true)-$time_start;file_put_contents("update.log", "\n post copy and chmod ". $timenow, FILE_APPEND | LOCK_EX);//logging

								  echo "<b style=\"color:#f00\">$lang_txt_158</b>";
								  if (md5_file("../".$filename2)==md5_file("../download/backup-".$timestamp."/".$filename2))
								  //if (!compare_files("../".$filename2, "../download/backup-".$timestamp."/".$filename2))
								  unlink("../download/backup-".$timestamp."/".$filename2);echo "Backup cleanup";
								$timenow=microtime(true)-$time_start;file_put_contents("update.log", "\n post cleanup ". $timenow, FILE_APPEND | LOCK_EX);//logging

								}else {echo " <b style=\"color:#309830\">Update-OK</b>";$updatedneeded++;}
							}
						} else $donotneedupdate++; $countupdate++;


				}
			} 
			}else echo "<br>", $outputFile,"ZIPExtractERROR";
			$zip->close();		
			$timenow=microtime(true)-$time_start;file_put_contents("update.log", "\n zip close ". $timenow, FILE_APPEND | LOCK_EX);//logging
			echo "<hr><br>", $countupdate, " $lang_txt_154"; 
			echo "<br>", $updatedneeded, " $lang_txt_155";
			echo "<br>", $donotneedupdate, "$lang_txt_156";
			if ($countupdate==$donotneedupdate and $countupdate!=0) echo "<h2>$lang_txt_157!</h2>";
			rrmdir("../download/update-temp-extract");
			unlink("../download/temp-update.zip");

			}


	} else {
	   echo "Update not supported: file_get_contents not able to access cms.libe.net/Download make sure  PHP-allow_url_fopen is set to on in php.ini";
	}

}

if ($setup=="settings")
{
echo "<br><h1>Software Update</h1><div class=\"settings\"><a href=\"admin.php?setup=newversion\" title=\"\" style=\"color: #F00;\">$lang_txt_149</a> </div>";
	echo "<h1>$lang_txt_050</h1>";
	//echo "<div style=\"position:absolute;left:00px;top:0px;margin-left:470px;float:left;\">";
	
	
if (function_exists('apache_get_modules')) {
   $modules = apache_get_modules();
   $mod_rewrite_enabled = in_array('mod_rewrite', $modules);
 } else {
   $mod_rewrite_enabled =  getenv('HTTP_MOD_REWRITE')=='On' ? true : false ;
 }


	if ($mod_rewrite_enabled==1){
	if  ($modrewrite=="on") echo "<div class=\"settings\"><a href=\"admin.php?setup=modrewrite_off\" style=\"color: #666;\">$lang_txt_043</a> </div></div><br>";
	else echo "<div  class=\"settings\"><a href=\"admin.php?setup=modrewrite_on\" style=\"color: #666;\">$lang_txt_044</a></div></div> <br>";
	//echo "</div>";
	} else {
	    echo "<div class=\"settings\">$lang_txt_045</div></div><br>";
	}
if ($maintenance=="on") echo "<div class=\"settings\">$lang_txt_038<a href=\"admin.php?setup=maintenance_off\" title=\"$lang_txt_094\" style=\"color: #F00;\">$lang_txt_037</a> </div></div><br>";
else if (empty($file)) echo "<div class=\"settings\">$lang_txt_035 <a href=\"admin.php?setup=maintenance_on\" title=\"$lang_txt_093\">$lang_txt_036</a></div></div> <br>";

echo $lang_txt_134;
echo "<div class=\"settings\"><a href=\"admin.php?setup=expand_all\" title=\"default expand\">$lang_txt_135</a> </div>";
echo "<div class=\"settings\"><a href=\"admin.php?setup=collapse_all\" title=\"default collapse\">$lang_txt_136</a></div>";
echo "<div class=\"settings\"><a href=\"admin.php?setup=collapse_li\" title=\"default collapseli\">$lang_txt_147</a></div></div> <br>";


echo "<div class=\"settings\"><a href=\"admin.php?setup=layout\" title=\"$lang_txt_095\">",$lang_txt_009,"</a>";
if (empty($_GET['layout'])) echo " <small>(",str_replace("/", "", str_replace("template/", "", $templatedir)), ")</small>"; else echo " <small>(",$_GET['layout'], ")</small>";
echo "</div> <br />"; 

echo "Language / Sprache: <div class=\"settings\"><form action=\"admin.php?setup=language\" enctype=\"multipart/form-data\" method=\"post\">";
echo "Deutsch<input type=\"radio\" name=\"language\" value=\"de\" ";
if ($language=="de") echo "checked=\"checked\"";
echo "><br>";
echo "English<input type=\"radio\" name=\"language\" value=\"en\"";
if ($language=="en") echo "checked=\"checked\"";
echo "\"><br>";
echo "auto<input type=\"radio\" name=\"language\" value=\"auto\"";
if ($language=="auto") echo "checked=\"checked\"";
echo "\">";
echo "<input type=\"submit\" value=\"change\">"; 
echo "</form></div></div>";

echo "<form action=\"admin.php?setup=password\" enctype=\"multipart/form-data\" method=\"post\">";
echo "<br><div class=\"settings\">$lang_txt_097<br>";
echo "<input type=\"password\" title=\"$lang_txt_097\" autocomplete=\"off\" name=\"password1\" value=\"\"><br>";
echo "<input type=\"password\" title=\"$lang_txt_097\" autocomplete=\"off\" name=\"password2\" value=\"\">";


echo "<input type=\"submit\" value=\"save\">"; 
echo "</form></div><br><br>";

echo "<h1>Template $lang_txt_050</h1><div  class=\"settings\">";
echo "<form action=\"admin.php?setup=template\" enctype=\"multipart/form-data\" method=\"post\">";
$page_title=html_entity_decode(str_replace("0AND0", "&",str_replace("0SPACE0", " ", str_replace("0EQUAL0", "=",str_replace("0SLASH0", "/",str_replace("0COLON0", ":",str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $page_title)))))))));
$page_description=html_entity_decode(str_replace("0AND0", "&",str_replace("0SPACE0", " ", str_replace("0EQUAL0", "=",str_replace("0SLASH0", "/",str_replace("0COLON0", ":",str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $page_description)))))))));

echo "Page Title: <textarea style=\"color: #000000;background-color: #fff;\" type=\"text\" title=\"$lang_txt_113\" name=\"page_title\" ROWS=1 COLS=40 WRAP='virtual'>",$page_title, "</textarea>";
echo "<br>Page description: <textarea style=\"color: #000000;background-color: #fff;\" type=\"text\" title=\"$lang_txt_114\" name=\"page_description\" ROWS=1 COLS=40 WRAP='virtual'>",$page_description, "</textarea>";

echo "<input type=\"submit\" value=\"save\">"; 
echo "</form></div><br><br>";


echo "<form action=\"admin.php?setup=feedback\" enctype=\"multipart/form-data\" method=\"post\">";
$email=str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $email)));
echo "<h1>Feedback $lang_txt_050</h1><div  class=\"settings\">";
echo "$lang_txt_103 <input type=\"checkbox\" title=\"$lang_txt_102\" name=\"feedbackapprove\" value=\"later\" ";if ($feedbackapprove=="later") echo "checked"; echo "><br>";

echo "Email: <textarea style=\"color: #000000;background-color: #fff;\" type=\"text\" title=\"$lang_txt_092\" name=\"email\" ROWS=1 COLS=40 WRAP='virtual'>",$email, "</textarea>";
$feedbackformular=str_replace("0AREA0", "|",str_replace("0STAR0", "*",str_replace("0SLASH0", "/",str_replace("0COLON0", ":",str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $feedbackformular)))))));
echo "<br>Formular: <textarea style=\"color: #000000;background-color: #fff;\" type=\"text\" title=\"$lang_txt_101\" name=\"feedbackformular\" ROWS=1 COLS=40 WRAP='virtual'>",$feedbackformular, "</textarea>";
$sendermail=str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $sendermail)));
echo "<br>Sender Email: <textarea style=\"color: #000000;background-color: #fff;\" type=\"text\" title=\"$lang_txt_092\" name=\"sendermail\" ROWS=1 COLS=40 WRAP='virtual'>",$sendermail, "</textarea>";

$badwords=str_replace("0EQUAL0", "=",str_replace("0SLASH0", "/",str_replace("0COLON0", ":",str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $badwords))))));
echo "<br>Bad Words: <textarea style=\"color: #000000;background-color: #fff;\" type=\"text\" title=\"$lang_txt_093\" name=\"badwords\" ROWS=1 COLS=40 WRAP='virtual'>",$badwords, "</textarea>";

echo "<input type=\"submit\" value=\"save\">"; 
echo "</form></div>";



}
?>

<?php
//menu
echo "<div id='navi'><div id='navi2'></div>";
echo " <div style=\"position:absolute;width:200;text-align:left;left:0px;top:0px;margin:0px;float:left;\">";
//if (!empty($file) or (!empty($setup))) echo "<a href=\"admin.php#", $file,"\" title=\"$lang_txt_073 $lang_txt_089\">", $lang_txt_005,"</a> ";
if (!empty($file) or (!empty($setup))) echo "<a href=\"admin.php\" title=\"$lang_txt_073 $lang_txt_089\">", $lang_txt_005,"</a> ";
if (!empty($file)) if ($file!="dat_menu_file") if ($setup!="layout") {echo "<a href=\"../"; if ($file!="Startseite") echo "index.php/".$file; echo"\" title=\"$lang_txt_079 $lang_txt_089\">", $lang_txt_049,"</a> ";}
if (empty($setup) and empty($file)) echo "<a href=\"admin.php?file=dat_menu_file\" title=\"$lang_txt_070 $lang_txt_069\">",$lang_txt_008, "</a> ";
if ($setup=="layout") echo "<a href=\"edit.php\" title=\"Editor\">edit</a> ";

echo "</div>";
if (empty($file)) {
echo " <div style=\"position:absolute;width:200;text-align:right;right:0px;top:0px;margin:0px;float:right;\">";
if ($setup!="settings" and empty($file)){
echo " <a href=\"admin.php?setup=settings\" title=\"$lang_txt_075\">$lang_txt_050</a> ";
}
if(file_exists("../feedback/check")) {$datelast =file_get_contents("../feedback/check"); $datelast="new Feedback(s):". date("d.m.Y H:i",$datelast);}else $datelast="Feedback(s)";

if(file_exists("feedback.php")) {echo "<a href=\"feedback.php\""; if ($datelast!="Feedback(s)")echo " style=\"background-color:#F00\""; echo " title=\"$lang_txt_076\">$datelast</a> ";}
if(file_exists("anmeldeformular.php")) echo "<a href=\"anmeldeformular.php\">Anmeldungen</a> ";
echo "<a href=\"../index.php?login=logoff\" title=\"$lang_txt_077\">$lang_txt_039</a> <a href=\"../\" title=\"$lang_txt_078\">",$lang_txt_021," [x]</a></div> </div>";
}
echo "</div>";
?>

<?php



if (!empty($setup))
{	
	if ($setup=="layout")
	{
	unset($file);
	$dir = "../template/";$current_template= str_replace("/", "", str_replace("template/", "", $templatedir));
	echo "<h1>", $lang_txt_022, "</h1>";
		// Open a known directory, and proceed to read its contents
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {

			while (($file = readdir($dh)) !== false) {    
			    if (!is_dir($file)) $file_array[$file]=$file;
			}
			closedir($dh);
		    }
		}

	asort($file_array, SORT_STRING);

		foreach($file_array as $key => $value)
		{
		  //display results
		  //echo $key;    // is $file
		  //echo $value;  //is $tfile
		$file=$key;
		if ($current_template!=$file) {echo "<table><tr><td width=300px><a href=\"admin.php?setup=change_layout&layout=$file\"><img src=\"", $dir,$file, "/template_mini.png\" border=\"0\" alt=\"",$file,"\"></a></td><td width=400px style=\"background:#fff;vertical-align:top;\"><b><a href=\"admin.php?setup=change_layout&layout=$file\">$file</a></b><br>";@include($dir.$file. "/template_description.htm");echo "</td></tr></table>";}
		else {echo "<br><div style=\"border-style:solid;width:700px;\"><table><tr><td width=300px><a href=\"admin.php?setup=change_layout&layout=$file\"><img src=\"", $dir,$file, "/template_mini.png\" border=\"0\" alt=\"",$file,"\"></a></td><td width=400px style=\"background:#fff;vertical-align:top;\"><b><a href=\"admin.php?setup=change_layout&layout=$file\">$file</a></b><br>";@include($dir.$file. "/template_description.htm");echo "</td></tr></table></div>";}

		}
	unset($file);
	}
}

//save images and files ...
						//http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
						   if(!empty($_FILES['uploaded_image']['tmp_name'])) 
							{
							include('SimpleImage.php');
							multiimagesave($_FILES["uploaded_image"]["name"],$_FILES['uploaded_image']['tmp_name'],"../",$file,$_POST['original_picture']);
							}
//... save image and files




if (!empty($file))
	{
	$Pfad= "../daten/$file.dat";

	/*** update entry***/
	if( isset( $_POST['submit'] ) ) if ($_POST['submit']=="update")
		{

		$warning="";
		if (empty($text))$text=$_POST['text'];

		//check for valid menu entries
		if ($file=="dat_menu_file")
			{
			
				//translate for nestable:
				if (!empty($_POST['menusaved']))
				{
					//echo $_POST['menusaved'];
				
					if (get_magic_quotes_gpc()) {
					    $menusaved = stripslashes($_POST['menusaved']);
					}
					else {
					    $menusaved = $_POST['menusaved'];
					}
					//echo $menusaved;
					
					$menusaved=str_replace('"id":', '', $menusaved);
					
					if (!empty($_POST['new'])) {
					$menusaved=str_replace('new----entry', $_POST['newentry'],$menusaved , $wasitreplaced);
					if ($wasitreplaced==0) $menusaved="---+1---{---+1---{".$_POST['newentry']."----1-------1---".$menusaved;
								}
					$menusaved=str_replace('"children":', '', $menusaved);
					$menusaved=str_replace('\n', '', $menusaved);
					$menusaved=str_replace('not-used-in-menu', '', $menusaved);
					$menusaved=str_replace('"', "", $menusaved);
					$menusaved=str_replace('}', '', $menusaved);
					$menusaved=str_replace('",', '', $menusaved);
					$menusaved=str_replace(',', '', $menusaved);
					$menusaved=str_replace('[', '---+1---', $menusaved);
					$menusaved=str_replace(']', '----1---', $menusaved);
					$menusaved=str_replace('new----entry', '', $menusaved);
					
					
					//echo "<br>", $menusaved;
					$array = explode ('{', $menusaved);
		
					$ebene=0;//echo count($array);
						for ($i=1; $i<(count($array));$i++)
						{
						 	if ($array[$i]!="" and $array[$i]!=" " and $array[$i]!="\n" and (!empty($array[$i])))
							{
							if ($i>2 and $array[$i]!="---+1---" and $array[$i]!="----1---") $text=  $text."\n";
							if ($i==2 and leftspaces($array[$i-1])==0 and $array[$i-1]!="---+1---" and $array[$i-1]!="----1---" and $array[$i-1]!="") $text=  $text."\n";
							if (leftspaces($array[$i])==0 and strlen($array[$i]>0) and $i==1) $text=  $text."\n";

							$text= $text.str_repeat(" ", $ebene).trim(str_replace('----1---', '',str_replace('---+1---', '', $array[$i])));
							if (leftspaces($array[1])==0 and $i==1) $text=trim($text);	//remove linebreaks at the Beginn
							$ebene=$ebene+substr_count($array[$i], '---+1---');
							$ebene=$ebene-substr_count($array[$i], '----1---');
							}	
						}
				}
				$text=rtrim($text);//remove linebreaks at the End	
				//echo $array[0];
				
				//...translate for nestable
				 //if (substr($myStr, $text, 1)=="\n") echo "fistlinebreak";
				$readmenuentries = file_get_contents($Pfad); 
				$arraymenues = explode ("---///___", $readmenuentries);
				$menues= $arraymenues[2];
				$menuentries=explode ("\n",$menues);
				if (count($menuentries)==1) $text=trim($text); //first entries should not be disabled
				$menuentriesnew=explode ("\n",$text);
				//alt

				//load details for warning (if article was renamed for example)...
				/*** read ADDITIONAL***/
				$filex="dat_menu_file2";
				$Pfadx= "../daten/$filex.dat";$dateix = fopen($Pfadx, "r");$savethetextx=fread($dateix, filesize($Pfadx));fclose($dateix);
				$menuarray2x=explode ("\n",$savethetextx);
				//...load details for warning (if article was renamed for example)


				for ($i=0; $i<count($menuentries);$i++)
				{ $is_old_entry_still_there="0";
					if (strlen(trim($menuentries[$i]))>1) 
					{$found=0;
					
						for ($j=0; $j<count($menuentriesnew);$j++){ if (trim(str_replace(",","",str_replace("\"","",str_replace("'","",str_replace("\'","",trim($menuentriesnew[$j]))))))==trim(str_replace(",","",str_replace("\"","",str_replace("'","",str_replace("\'","",trim($menuentries[$i]))))))){$is_old_entry_still_there="found_it";$found++;}}
						if ($is_old_entry_still_there=="0") {
						//load details for warning (if article was renamed for example)
						$arrayseiteaddx = explode ("---///___", $menuarray2x[$i]);										
						
						$warning="$warning $menuentries[$i] ($arrayseiteaddx[5])<br />";}
						if ($found>1) $warning="$menuentries[$i] $lang_txt_048<br />";
					} 
				}
			}
		if( isset( $_POST['i_know_what_i_do'] ) ) if ($_POST['i_know_what_i_do']=="yes") $warning="";
		//ende check

		$datum=to_unixtime($_POST['datum']);
		$savethetext=str_replace("\r","",str_replace("\n","",htmlentities($_POST['titel']))) ."---///___". str_replace("\r","",str_replace("\n","",htmlentities($_POST['meta'])))."---xxx___". str_replace("\r","",str_replace("\n","",$datum))."---xxx___". str_replace("\r","",str_replace("\n","",ltrim($_POST['fileandpathname'],'/')))."---xxx___". str_replace("\r","",str_replace("\n","",htmlentities($_POST['titelmenu'])))."---xxx___". str_replace("\r","",str_replace("\n","",htmlentities($_POST['smalldescription'])))."---xxx___". str_replace("\r","",str_replace("\n","",$_POST['newsentry']))."---xxx___". str_replace("\r","",str_replace("\n","",$_POST['preview']))."---xxx___". time()."---xxx___". $_POST['addfeedback']."---///___". $text;
		if (get_magic_quotes_gpc()==1) $savethetext=stripslashes($savethetext);
	
		if ($warning=="") 
			{

				if (!empty($savethetext))
				{

							//old Versions...
							if ($_POST['reload_backup']=="save article and RestorePoint RP")
							{
							for( $xf = 100; $xf >= 0; $xf-- )
							{ 
								$Pfadbu= "../daten/xxbu_".$xf."_$file.dat";
								if(file_exists("../daten/xxbu_last_rp_$file.dat"))$xfp1=$xf+2;else $xfp1=$xf+1;
								$Pfadbup1="../daten/xxbu_". $xfp1 ."_$file.dat";
								if ($xf==0) $Pfadbu=$Pfad;
								if(file_exists($Pfadbu)){copy($Pfadbu, $Pfadbup1);}	
							}
							if(file_exists("../daten/xxbu_last_rp_$file.dat")){copy("../daten/xxbu_last_rp_".$file.".dat", "../daten/xxbu_1_".$file.".dat");unlink("../daten/xxbu_last_rp_$file.dat");}
							//...old Versions
							}else {if(!file_exists("../daten/xxbu_last_rp_$file.dat")){copy($Pfad, "../daten/xxbu_last_rp_$file.dat");;}}

				$datei = fopen($Pfad, "w+");
				fwrite($datei, $savethetext);
				fclose($datei);
				

				}
			}




		/*** save additional Infos write file dat_menu_file2.dat ***/
			/*** read entry***/
			$fileadd="dat_menu_file";
			$Pfadadd= "../daten/$fileadd.dat";
			$dateiadd = fopen($Pfadadd, "r");$filesize=filesize($Pfadadd);
			$savethetextadd=fread($dateiadd, $filesize);
			fclose($dateiadd);
			$arrayseiteadd = explode ("---///___", $savethetextadd);
			$textadd= $arrayseiteadd[2];
			$menuarrayadd=explode ("\n",$textadd);


		for ($i=0; $i<count($menuarrayadd);$i++)
		{
			$fileadd=encodeurl(trim($menuarrayadd[$i]));
			
			$Pfadadd= "../daten/$fileadd.dat";
			$dateiadd = fopen($Pfadadd, "r");
			$savethetextadd=fread($dateiadd, filesize($Pfadadd));
			fclose($dateiadd);unset ($arrayseiteadd);unset($datumadd);unset($titeladd);unset($metaadd);unset($fileandpathnameadd);
			$arrayseiteadd = explode ("---///___", str_replace("\n", "",$savethetextadd));
			$titeladd= trim(str_replace("\n", "",$arrayseiteadd[0]));
			$arrayseiteaddd = explode ("---xxx___", str_replace("\n", "",$arrayseiteadd[1]));
			$metaadd= str_replace("\n", "",$arrayseiteaddd[0]);
			$datumadd= str_replace("\n", "",$arrayseiteaddd[1]);
			if ($fileadd==encodeurl(trim($_POST['newentry']))) $datumadd=999999999;
			$titelmenuadd = str_replace("\n", "",$arrayseiteaddd[3]); if (empty($titelmenu))$titelmenu=decodeurl($file);
			$fileandpathnameadd= trim(str_replace(" ", "", str_replace("\n", "",$arrayseiteaddd[2])));$trimit=trim($menuarrayadd[$i]);
			$smalldescriptionadd =str_replace("\n", "",$arrayseiteaddd[4]);
			$newsentryadd =$arrayseiteaddd[5];
			$preview =$arrayseiteaddd[6];
			if (!empty($menuarrayadd[$i]) and !empty($datumadd)){$savethetextremember="$savethetextremember".$datumadd ."---///___". $titeladd."---///___". $metaadd."---///___". $fileandpathnameadd."---///___". $fileadd."---///___". $titelmenuadd."---///___". $smalldescriptionadd."---///___". $newsentryadd."---///___". $preview. "\n";
			//$savethetextremember=str_replace("\n", "",str_replace("\n", "",$savethetextremember));

			if (!empty($fileandpathnameadd))$savethetextmodrewrite=$savethetextmodrewrite. " RewriteRule ". $fileandpathnameadd."$ index.php/".$fileadd." [L]\n";
			}else $savethetextremember="$savethetextremember"."\n";



		}
			/*** write dat_menu_file2.dat ...***/
			if (!empty($savethetextremember))
			{$Pfadadd="../daten/dat_menu_file2.dat";
			$dateiadd = fopen($Pfadadd, "w");
			fwrite($dateiadd, $savethetextremember);
			fclose($dateiadd);
			}
			/***... write dat_menu_file2.dat ***/

			if (function_exists('apache_get_modules')) {
				   $modules = apache_get_modules();
				   $mod_rewrite_enabled = in_array('mod_rewrite', $modules);
				 } else {
				   $mod_rewrite_enabled =  getenv('HTTP_MOD_REWRITE')=='On' ? true : false ;
			 }
			 if ($mod_rewrite_enabled==1)
			 {
			/*** write Mod Rewrite file ...***/
			$Pfadhto= "../htaccess";
			$dateihto = fopen($Pfadhto, "r");
			$savethetexthto=fread($dateihto, filesize($Pfadhto));
			fclose($dateihto);
			$Pfadhtotemp= "../$templatedir"."htaccess";
			$dateihtotemp = fopen($Pfadhtotemp, "r");
			$savethetexthtotemp=fread($dateihtotemp, filesize($Pfadhtotemp));
			fclose($dateihtotemp);
			$Pfadht="../.htaccess";
			$dateiht = fopen($Pfadht, "w");
			fwrite($dateiht, "RewriteEngine on\n");

			fwrite($dateiht, $savethetextmodrewrite);
			fwrite($dateiht, $savethetexthto);
			fwrite($dateiht, $savethetexthtotemp);
			fclose($dateiht);
			}
			//RewriteRule themen/help.php$ index.php/help [L]
			/*** ...write Mod Rewrite file 

		/***... save additional Infos***/

		if ($file=="dat_menu_file" and $warning==""){ if (!empty($_POST['new'])) {
				echo "<script language=\"javascript\">window.location.href = \"",$Pfadadmin,"/admin.php?file=", encodeurl($_POST['newentry']), "&title=",urlencode($_POST['newentry']),"\"</script>";}
				else echo "<script language=\"javascript\">window.location.href = \"",$Pfadadmin,"/admin.php\"</script>";}
		}



	/*** read entry***/
	if ($_POST['reload_backup']!="save article and RestorePoint RP" and !empty($_POST['reload_backup'])){ $versiontoload= explode ("-",$_POST['reload_backup']); $savethetext= file_get_contents("../daten/xxbu_".$versiontoload[1]."_$file.dat");}
	if ($_POST['reload_backup']=="undo last restore") $savethetext= file_get_contents("../daten/xxbu_last_rp_$file.dat");
	if (empty($savethetext)) $savethetext= file_get_contents($Pfad);
	$arrayseite = explode ("---///___", $savethetext);
	if (empty($titel))$titel= $arrayseite[0];if (empty($titel))$titel=trim(urldecode($_GET['title']));
	$text= $arrayseite[2];
	$arrayseiteadd = explode ("---xxx___", $arrayseite[1]);
	$meta= $arrayseiteadd[0];
	$titelmenu =$arrayseiteadd[3]; if (empty($titelmenu))$titelmenu=trim(urldecode($_GET['title']));if (empty($titelmenu))$titelmenu=$titel;
	$smalldescription =$arrayseiteadd[4];
	$newsentry =$arrayseiteadd[5];
	if( isset( $arrayseiteadd[6] ) )$preview =$arrayseiteadd[6];else $preview="";
	$addfeedback=$arrayseiteadd[8];
	$datum= $arrayseiteadd[1];
	$fileandpathname= $arrayseiteadd[2];
	echo "<form action=\"admin.php?file=",$file, "\" onsubmit=\"return saveScrollPositions(this);\" enctype=\"multipart/form-data\" id=\"articleform\" method=\"post\">";
//scrollposTinyMCE
	echo "<input type=\"hidden\" name=\"scrolly\" id=\"scrolly\" value=\"0\" />"; //remember Scrollpos TinyMCE needs from: onsubmit .
?>
<script type="text/javascript">
function saveScrollPositions(theForm) {
if(theForm) {
var scrolly = tinymce.DOM.getViewPort(tinymce.activeEditor.getWin()).y;
theForm.scrolly.value = scrolly;
}
}
//reloadscroll
<?php if(!empty($_REQUEST['scrolly'])) {?>
jQuery(document).ready(function() {
	//do stuff
setTimeout(function(){document.getElementById('mce_ifr').contentWindow.scrollTo(0,<?php echo $_REQUEST['scrolly'] ?>);}, 300);
})
<?php } ?>
//reloadscroll

</script>
<!-- scrollposTinyMCE --><?php

	if ($file=="dat_menu_file") {echo "<br>", $lang_txt_006;
		if ($warning!="") echo "<div style=\"color:red;background:white;\"> $lang_txt_032 <blockquote>$warning</blockquote></div> $lang_txt_033<input type=\"checkbox\" name=\"i_know_what_i_do\" value=\"yes\"><br />";}

	echo "<br><div class=\"editor\">";	if ($file=="dat_menu_file") echo "<h1>$lang_txt_008</h1>";
	echo "<div style=\"float:left;width:250px\">";

	//zurückwandeln: $datum=mktime($datum);
	if ($file!="dat_menu_file")echo "", $lang_txt_019, "<br /><textarea class=\"input1\" type=\"text\" title=\"$lang_txt_081\" name=\"titel\" ROWS=2 COLS=28 WRAP='virtual'>",$titel, "</textarea>";
	if ($file!="dat_menu_file" and $file!="Startseite")echo "<small>", $lang_txt_046, "<br /><textarea class=\"input1\" type=\"text\" name=\"smalldescription\" title=\"$lang_txt_084\" ROWS=2 COLS=28 WRAP='virtual'>",$smalldescription, "</textarea></small>";
	echo "</div><div style=\"margin:0px;float:left;\">";
	if ($file!="dat_menu_file" and $file!="Startseite")echo "<small>", $lang_txt_042, "</small><br /><textarea class=\"input1\" type=\"text\" title=\"$lang_txt_085\" name=\"titelmenu\" ROWS=2 COLS=28 WRAP='virtual'>",$titelmenu, "</textarea>";	

 if ($inclanguage=="de")
	{if (empty($datum)) $datum= @date("d.m.Y H:i",time());else $datum=@date("d.m.Y H:i",$datum);}else
	{if (empty($datum)) $datum= @date("m/d/Y H:i",time());else $datum=@date("m/d/Y H:i",$datum);}


	if ($file!="dat_menu_file" and $file!="Startseite")echo "<br /><small>", $lang_txt_040, "</small><br /><input type=\"text\" id=\"datepicker\" title=\"$lang_txt_083\" name=\"datum\" value=\"$datum\">";
	echo "</div><div style=\"margin-left:10px;float:left;\">";
	if ($file!="dat_menu_file")
		{
		if (empty($meta)) echo "<script type=\"text/javascript\">
		$(function(){
		$('.hide').fadeOut(0);
		    $(\".showhide\").click( 
			function(){ $(\".hide\").slideDown(); }
		    );
		});
		</script>";
		echo "<div class=\"showhide\" style=\"margin:0px;padding:0px; cursor: pointer;\"><small style=\"text-decoration:underline\">", $lang_txt_020, "
		<div class=\"hide\" style=\"margin:0px;padding:0px;\">
		<textarea class=\"input2\" title=\"$lang_txt_082\" type=\"text\" name=\"meta\" ROWS=2 COLS=28 WRAP='virtual'>",$meta, "</textarea></small></div></div>";
		}
	if ($modrewrite=="on") {
		if (empty($fileandpathname)) echo "<script type=\"text/javascript\">
		$(function(){
		$('.hide2').fadeOut(0);
		    $(\".showhide2\").click( 
			function(){ $(\".hide2\").slideDown(); }
		    );
		});
		</script>";

			if ($file!="dat_menu_file" and $file!="Startseite")
			echo "<div class=\"showhide2\" style=\"margin:0px;padding:0px; cursor: pointer;\"><small style=\"text-decoration:underline\">", $lang_txt_041, "</small><br />
			<div class=\"hide2\" style=\"margin:0px;padding:0px;\">
			<textarea class=\"input2\" type=\"text\" name=\"fileandpathname\" ROWS=2 COLS=28 WRAP='virtual'>",$fileandpathname, "</textarea></div></div>";
				}
	if ($file!="dat_menu_file" and $file!="Startseite"){echo "<small>", $lang_txt_047, "<input type=\"checkbox\" title=\"$lang_txt_086\" name=\"newsentry\" value=\"1\" ";if ($newsentry==1) echo "checked"; echo ">";}
	if ($file!="dat_menu_file" and $file!="Startseite"){echo "<br />", $lang_txt_090, "<input type=\"checkbox\" title=\"$lang_txt_091\" name=\"addfeedback\" value=\"1\" ";if ($addfeedback==1) echo "checked"; echo "></small>";}

	echo "</div><div style=\"clear:both;margin:0px;\"></div>";

	echo "<INPUT TYPE='HIDDEN' NAME='submit' VALUE='update'>";
	echo "<input type=\"hidden\" name=\"preview\" id=\"preview\" value=\"",$preview,"\" />"; //remember Preview



	echo "<textarea type=\"text\"";
	if ($file!="dat_menu_file") echo " id=\"mce\""; 
	echo " name=\"text\"";
	if ($file=="dat_menu_file") echo " title=\"$lang_txt_072\"";
	echo " ROWS=30 COLS=100>",htmlentities($text), "</textarea>";
	echo "</div><table style=\"right:0px;position:relative;background:#ddd;box-shadow: 3px 2px 2px 1px #777777; height:90px;padding-top:10px;border-radius: 0px 5px 5px 0px;margin-top:0px;margin-bottom:10px;\"><tr><td valign=\"top\">";

	echo "", $lang_txt_007, "<input type=\"submit\" class=\"submit\" title=\"$lang_txt_080\" value=\"update\"><hr>";

		if (!empty($_POST['submit']) and $_POST['reload_backup']==("save article and RestorePoint RP")) echo "<script type=\"text/javascript\">
		$(function(){
		$('#saved').fadeOut(5000);
		});
		</script><div id=\"saved\" style=\"color:#f00;background:#fff;top:14px;position:absolute;padding:2px;margin-left:-20px;text-align:right;border:1px solid #ccc;width:95px;\">$lang_txt_143</div>";
	 	
		if (!empty($_POST['submit']) and $_POST['reload_backup']!=("save article and RestorePoint RP"))echo "<div id=\"saved\" style=\"color:#f00;background:#fff;position:relative;padding:2px;text-align:right;border:1px solid #ccc;width:300px;\">$lang_txt_144", $versiontoload[1], " $lang_txt_145</div>";


	if ($file!="dat_menu_file") echo " $lang_txt_012 <input type=\"file\" title=\"$lang_txt_087\" name=\"uploaded_image\" />";
	if ($file!="dat_menu_file") {
		echo " ori:<input type=\"checkbox\" name=\"original_picture\" title=\"$lang_txt_141\"value=\"1\"><div style=\"color:#aaa;font-size:10px;\">Server-File-Limit:", (int)(ini_get('upload_max_filesize')) ,"MB</div>";

	}
	

if ($file!="dat_menu_file") {
		echo "<select style=\"float:right; font-size:10px;\" title=\"$lang_txt_088\" name=\"reload_backup\"><option>save article and RestorePoint RP</option>";
					
 		if ($_POST['reload_backup']!="save article and RestorePoint RP" and !empty($_POST['reload_backup'])) echo "<option>undo last restore</option>";

							for( $xx = 1; $xx < 100; $xx++ )
							{ 
								$Pfadbu= "../daten/xxbu_".$xx."_$file.dat";
								if (file_exists($Pfadbu)) {
										//read
										$datei = fopen($Pfadbu, "r");
										$savethetext=fread($datei, filesize($Pfad));
										fclose($datei);
										$arrayseite = explode ("---///___", $savethetext);
										//$text= $arrayseite[2];
										//$menuarray=explode ("\n",$text);
											//$text= $arrayseite[2];
											$arrayseiteadd = explode ("---xxx___", $arrayseite[1]);
											$moddate= $arrayseiteadd[7];
										
											 if ($inclanguage=="de")
												{echo "<option>load version: ", date("d.m.Y H:i",$moddate);}else
												{echo "<option>load version: ", date("m/d/Y H:i",$moddate);}
										echo " RP-",$xx,"</option>";
								}
							}echo "</select><br>";
			}
	echo "</td></tr></table>";



if ($file!="dat_menu_file")echo "<img id=\"loading-aimage\" src=\"../plugins/lightbox/images/loading.gif\" style=\"position:absolute;top:200px;left:800px;\" alt=\"Loading...\" /><div id=\"images\">";

//ajax load images ...
echo "
<script>
$.ajaxSetup({ cache: false,     
	beforeSend: function(){
        $('#loading-aimage').show();
    	},
    	complete: function(){
        $('#loading-aimage').hide();},
    	success: function(){
        $('#loading-aimage').hide();}
	});

  function reloadimgs (view)
  {
    $(\"#images\").load(\"ajax-respond.php?loadimages=".$file."&view=\"+view);
  }

  function loadtopicimgs (topic)
  {
    $(\"#images\").load(\"ajax-respond.php?topic=\"+topic);
  }

  function loadfiles ()
  {
    $(\"#images\").load(\"ajax-respond.php?loadfiles=load\");
  }

  function deletefile (file)
  {
    $(\"#images2\").load(\"ajax-respond.php?deletefile=\"+file);
  }
  function deletefile2 (file)
  {
    $(\"#images2\").load(\"ajax-respond.php?deletefile2=\"+file);
  }

  function deleteimgs (deleteimg,view)
  {var deleteimg=deleteimg;
    $(\"#images2\").load(\"ajax-respond.php?loadimages=".$file."&deleteimg=\"+deleteimg+\"&view=\"+view);
  }
  function deleteimgs2 (deleteimg,view)
  {var deleteimg=deleteimg;
    $(\"#images2\").load(\"ajax-respond.php?loadimages=".$file."&deleteimg2=\"+deleteimg+\"&view=\"+view);
  }

  function rotateimg (rotateimg,view)
  {var rotateimg=rotateimg;
    $(\"#images2\").load(\"ajax-respond.php?loadimages=".$file."&rotateimg=\"+rotateimg+\"&view=\"+view);
  }


$(document).ready(function(){
reloadimgs ()
});
$(function(){
	$( \"#target\" ).click(function() {
	    reloadimgs ()
	}); 
});
</script>";
if ($file!="dat_menu_file")echo "</div>";	
if ($file!="dat_menu_file") echo "<iframe src=\"supa/img.php?load=iframe&tag=$file\" frameborder=\"0\" width=\"280\" height=\"55\" style=\"float:right;right:0px;\" scrolling=\"no\"></iframe>";

//...ajax load images

							
		echo "</form>";



}else
{
if (empty($setup))
{ 
		/*** read entry***/
		$file="dat_menu_file";
		$Pfad= "../daten/$file.dat";
		$datei = fopen($Pfad, "r");
		$savethetext=fread($datei, filesize($Pfad));
		fclose($datei);
		$arrayseite = explode ("---///___", $savethetext);
		$text= $arrayseite[2];
		$menuarray=explode ("\n",$text);



		/*** read ADDITIONAL***/
		$file="dat_menu_file2";
		$Pfad= "../daten/$file.dat";$datei = fopen($Pfad, "r");$savethetext=fread($datei, filesize($Pfad));fclose($datei);
		$menuarray2=explode ("\n",$savethetext);


	echo "<br><h1 id=\"scrollUp\" style=\"margin-left:0px;width:400px;\">", $lang_txt_010,"</h1>";
	echo "";


//nestable
?>	    
		<menu id="nestable-menu">

		<?php 
		if (instr("MSIE 8.0",$_SERVER['HTTP_USER_AGENT']) or instr("MSIE 7.0",$_SERVER['HTTP_USER_AGENT']) or instr("MSIE 6.0",$_SERVER['HTTP_USER_AGENT'])) {
		$support_browser="no";}else {echo "<a href=\"admin.php\" id=\"discard\" title=\"$lang_txt_140\">$lang_txt_139</a>";
		echo "<form action=\"admin.php?file=dat_menu_file\" enctype=\"multipart/form-data\" method=\"post\">";
		echo "<input type=\"submit\" class=\"submit\" title=\"$lang_txt_118\" value=\"$lang_txt_117\">";
		}?>

		<button type="button" data-action="collapse-li" title="<?php echo $lang_txt_147;?>"><?php echo $lang_txt_146;?></button>
		<button type="button" data-action="expand-all" title="<?php echo $lang_txt_130;?>"><?php echo $lang_txt_119;?></button>
		<button type="button" data-action="collapse-all" title="<?php echo $lang_txt_131;?>"><?php echo $lang_txt_120;?></button>
		

<a href=admin.php?file=Startseite title="<?php echo $lang_txt_011." ".$lang_txt_069;?>" style="float:left;width:100px;text-align:left;" class="startseite"><?php echo $lang_txt_011;?></a>
	    	</menu>	

	<div class="cf nestable-lists">
	<div class="dd" id="nestable" style="width:49%;height:78%;position:absolute;overflow:auto;float:left;">

	 <ol class="dd-list"> 



	<?php 

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
							$mainmenu= "$mainmenu \n<li class=\"dd-item\" data-id=\"".trim($menuarray[$i])."\"> ";							
							if (!empty($titelmenuarray[$i]))$displaytitle=$titelmenuarray[$i];else $displaytitle=$menuarray[$i];unset ($linkurl);
							if (!empty($fileandpathnamearray[$i]))$linkurl= $fileandpathnamearray[$i] ;else $linkurl=$index. "/".encodeurl($menuarray[$i]);
							$mainmenu= "$mainmenu \n<a href=\"admin.php?file=". encodeurl($menuarray[$i])."&title=".urlencode(str_replace("'","",trim($menuarray[$i])))."\"";
							$trimit=trim($menuarray[$i]);
							if (empty($ignoreleftspaces)) if (leftspaces($menuarray[$i])<1 and $trimit{0}!="'")$ignoreleftspaces="donotignore";							
							if ($datumarray[$i]>time() or empty($ignoreleftspaces) or $trimit{0}=="'")$mainmenu= "$mainmenu class=\"color1\"";
							elseif (leftspaces($menuarray[$i])!=0)$mainmenu= "$mainmenu class=\"color2\"";
							//trim($displaytitle)
							$mainmenu= "$mainmenu>".trim($displaytitle). "</a>";
							if ($datumarray[$i]>time()) {
								if ($inclanguage=="de"){$mainmenu= $mainmenu." <font style=\"font-size:8px;color:#aaa;float:left;\">(".date("d.m.Y H:i",$datumarray[$i]).")</font>";}else 
								{$mainmenu= $mainmenu." <font style=\"font-size:8px;color:#aaa;float:left;\">(".date("m/d/Y H:i",$datumarray[$i]).")</font>";}
							}
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
	?>

	</ol>
		

	</div>
	<div id="scrollDown" style="position:absolute; bottom:0; left:0; width:50%;">&nbsp;</div>
	<div class="right" id="right" style="">
	<div class="dd" id="nestable2" style="float:left;padding:4px;">


		<br>
<?php 
if ($support_browser=="no") echo "<div class=\"warning\">$lang_txt_122</div>";else 
{?>
	
	<div class="newtopic" title="<?php echo $lang_txt_129;?>">
<h1 style="margin-left:0px"><?php echo $lang_txt_123;?></h1>
	    <input type="hidden" id="nestable-output" name="menusaved">
	<input type="hidden" value="update" name="submit">
	<?php echo $lang_txt_123;?> <small style="line-height:10px"><?php echo $lang_txt_124;?></small><br>
	<input type="text" placeholder='<?php echo $lang_txt_125;?>' value="" size="40" style="line-height:15x;height:15x;" name="newentry" title="<?php echo $lang_txt_126;?>">
	<input type="submit" class="submit" name="new" title="<?php echo $lang_txt_127;?>" value="<?php echo $lang_txt_137;?>">
	</form>	<?php if (count($menuarray)!=1){?>
	<li class="dd-item" data-id="new----entry">
	<div class="dd-handle" title="<?php echo $lang_txt_128;?>"><?php echo $lang_txt_121;?></div>
	</li><br>	
	<?php echo $lang_txt_138;}?>
		      </div>

<?php }?>

	    

	


		<script>
		var scrolling = false;
		$("#scrollUp").bind("mouseover", function(event) {
		    scrolling = true;
		    scrollContent("up");
		});
		$("#nestable").bind("mouseover", function(event) {
		    scrolling = false;
		});
		$("#navi2").bind("mouseover", function(event) {
		    scrolling = false;
		});

		$("#scrollDown").bind("mouseover", function(event) {
		    scrolling = true;
		    scrollContent("down");
		});

		function scrollContent(direction) {
		    var amount = (direction === "up" ? "-=10px" : "+=10px");
		    $("#nestable").animate({
			scrollTop: amount
		    }, 1, function() {
			if (scrolling) {
			    scrollContent(direction);
			}
		    });
		}</script>

	<script src="jquery.nestable.js"></script>
	<script>


	$(document).ready(function()
	{
	     var updateOutput = function(e)
	    {
		var list = e.length ? e : $(e.target),
		    output = list.data('output');
		if (window.JSON) {
		    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
		} else {
		    output.val('JSON browser support required for this demo.');
		}
	    };

	    // activate Nestable for list 1
	    $('#nestable').nestable({
		group: 1
	    })
	    .on('change', updateOutput);
	    <?php if ($expand_all=="collapse") echo "$('#nestable').nestable('collapseAll');";
		if ($expand_all=="collapseli") echo "$('#nestable').nestable('collapseli');";?>
	    // activate Nestable for list 2
	    $('#nestable2').nestable({
		group: 1
	    })
	    .on('change', updateOutput);

	    // output initial serialised data
	    updateOutput($('#nestable').data('output', $('#nestable-output')));
	    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

	    $('#nestable-menu').on('click', function(e)
	    {
		var target = $(e.target),
		    action = target.data('action');
		if (action === 'expand-all') {
		    $('.dd').nestable('expandAll');
		}
		if (action === 'collapse-all') {
		    $('.dd').nestable('collapseAll');
		}
		if (action === 'collapse-li') {
 		    $('.dd').nestable('expandAll');
		    $('.dd').nestable('collapseli');
		}
	    });

	    $('#nestable3').nestable();

	});
	</script>
<?php
//..nestable

/*old working Menu:
	for ($i=0; $i<count($menuarray);$i++){
		$arrayseiteadd = explode ("---///___", $menuarray2[$i]);
		$datumarray[$i]= trim($arrayseiteadd[0]);

	$ebene=strlen(str_replace(trim($menuarray[$i]), "",chop($menuarray[$i])));
	echo str_repeat("&nbsp;-", $ebene);
	echo "<a name=\"",encodeurl($menuarray[$i]),"\"><a href=admin.php?file=", encodeurl($menuarray[$i]), "&title=",urlencode(str_replace("'","",trim($menuarray[$i])));
	$trimit=trim($menuarray[$i]);
	if (empty($ignoreleftspaces)) if (leftspaces($menuarray[$i])<1 and $trimit{0}!="'")$ignoreleftspaces="donotignore";	

	if ($datumarray[$i]>time() or empty($ignoreleftspaces) or $trimit{0}=="'")echo " class=\"color1\"";
	elseif (leftspaces($menuarray[$i])!=0)echo " class=\"color2\"";

	echo " title=\"$lang_txt_071:$menuarray[$i] $lang_txt_069\">",$menuarray[$i],"</a></a>";if ($datumarray[$i]>time())echo "<font style=\"font-size:8px;color:#aaa;\">(",date("d.m.Y H:i",$datumarray[$i]),")</font>";
	echo"<br>";}
old working menu*/



//right admin links ..
//latest ...
//echo "<div style=\"float:right;height:90%;position:absolute;margin-left:50%; overflow:auto;width:47%;\">

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
if (count($menuarray)!=1){
echo "<br><div class=\"newsufuture\">
<h1 style=\"margin-left:0px;\">", $lang_txt_052,"</h1>";
@include(getcwd()."../buildpage.php");
arsort($datumarray);$nummer=0;
foreach($datumarray as $key => $value) 
	{
 	if (!empty($menuarray[$key]) and !empty($datumarray[$key])) {if ($datumarray[$key]<time()) {$nummer++; if (empty($onlyonce)) { echo "<h1 style=\"margin-left:0px;padding-top:10px;clear:both;\">", $lang_txt_051,"</h1>"; $onlyonce=1;}}
	echo "<div style=\"clear:left;float:left;\">";
	 if ($inclanguage=="de") echo date("d.m.Y H:i",$datumarray[$key]); else echo date("m/d/Y H:i",$datumarray[$key]);
	echo " </div> <a href=\"admin.php?file=". encodeurl(trim($menuarray[$key])), "&title=", urlencode(trim($menuarray[$key])),"\" style=\"float:left;\" class=\"color2\">".$titelmenuarray[$key],"</a>";}

echo "<script>
$(document).ready(function(){
    $(\"#",encodeurl(trim($menuarray[$key])),"\").load(\"ajax-respond.php?backlinksandlevels=".encodeurl(trim($menuarray[$key]))."\");
});
</script><div style=\"float:left;\" id=\"". encodeurl(trim($menuarray[$key])). "\"></div>";
	if ($nummer>15){break;}
	}
//ende latest

}
	
echo "</div>";} // background
echo "</div>";
//right admin links
}

?>
</div>
<?php if (count($menuarray)!=1){?>
<script>
$('#nestable a').attr('title','<?php echo "$lang_txt_071 $lang_txt_069";?>');
$('#nestable2 a').attr('title','<?php echo "$lang_txt_071 $lang_txt_069";?>');
$('#nestable .dd-handle').attr('title','<?php echo "$lang_txt_116";?>');
</script>
<?php }?>
<?php }else echo "denied";?>
</body></html>
