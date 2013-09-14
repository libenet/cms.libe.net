<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="robots" content="follow" />

<title><?php echo $titel;?></title>
<?php if (!empty($meta)) echo "\n<meta name=\"description\" content=\"", $meta,"\" />";
?>

<link rel="stylesheet" type="text/css" href="<?php echo $firstparturl,$templatedir;?>phone-main.css" />

<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery-1.7.2.min.js"></script>
<!-- remove AnySlider ... -->
		<?php $text=str_replace("***effects-startpage-PLACEHOLDER***", "", $text);?>
<!-- ... remove AnySlider -->

<!-- mobile -->
<?php if ($cssload!="main.css"){?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script type="text/javascript">
function toggleDiv(divId) {
   $("#"+divId).toggle();
}
</script>
<?php }?> 
<!-- mobile -->



</head>
<body>



	<div id="headline-menu">
		<h1><?php echo $page_title;?></h1><h2><?php echo $page_description;?></h2>
	</div>

	<div id="container">

			
				<?php
				echo "<div id=\"right\">";
				if ($cssload!="main.css") echo "<a href=\"javascript:toggleDiv('mobile');\" style=\"background-color: #ddd;border-top:solid #666;border-right:solid #666;border-bottom:solid #666;padding: 5px 10px; line-height:70px;width:100%;\">Topics</a><div id=\"mobile\"><h1 style=\"color:#085faf;\">Topics</h1><ul>";
				else echo "<h1>Topics</h1>";

				echo buildmenuul();
				echo "</ul></div>";
				if ($cssload!="main.css") echo "</div>";//end for mobile Menu Toggle
				?>

			<div id="center">
				<div id="backlink">
							<?php if (!empty($article)) echo $backlink;?>
				</div><br />
					<?php if (!empty($smalldescription)) echo "<h1>". $smalldescription. "</h1><br>";?>
					<?php if ($start==1) {$newest= newest(3,0,1,12); if (strlen($newest)>35){echo "<h1>New Topics</h1>"; echo $newest; echo "<br>";}} //New Entries if there are any: count the stringlengh and deside if there is an entry ?>
					<?php echo $text;?>
					<?php if (empty($text) and $start!=1) echo str_replace('width="150"','width="100"', buildmenu($level+1,$level+1,$level+1,"0","1"));//if there is no text in an topic build a menu?>


				<br /><div id="prevnext">
					<?php if (!empty($prev_topic)) echo "<", $prev_topic, "... ";
					if (!empty($next_topic)) echo " ...", $next_topic, ">";?>
				</div>
					<?php if ($start!=1) if ($addfeedback==1) {echo "<div style=\"clear:left;\"></div><br><h1>Kommentare</h1>";include("plugins/libe/feedback.php");}?>
			</div>
			

	</div>

	<div id="footer"> <?php echo date("d.m.Y H:i");?>
		<a href="http://cms.libe.net">powered by cms.libe.net</a>
	</div>

</body>
</html>

