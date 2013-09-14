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

<?php if ($start!=1){?><style>#mobile {display: none;background-color: #ddd;}</style><?php }?> 
<!-- mobile -->


<!-- toc add Table of Contents for Articles having more then 3 headers; needs jquery-->
	<?php if ($start!=1 and substr_count($text, '<h')>3) {?>
		<script src="<?php echo $firstparturl;?>plugins/toc/jquery.tableofcontents.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
		  $(document).ready(function(){$("#toc").tableOfContents( $("#toccontent"),// Scoped to div#wrapper
		      { startLevel: 1,    // H1 and up
			depth:      4,    // H1 through H3,
			topLinks:   true, // Add "Top" Links to Each Header
		      });});
		<!-- smooth scroll:-->
			$(document).ready(function(){$('a[href^="#"]').on('click',function (e) {e.preventDefault();var target = this.hash,$target = $(target);$('html, body').stop().animate({'scrollTop': $target.offset().top}, 900, 'swing', function () {window.location.hash = target;});});});
		</script>
	<?php }?>
<!-- ..toc -->


</head>
<body id="toc-top">


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
				</div>
					<?php	//h1 titel:
						if ($start!=1) echo "<h1 class=\"h1head\">". $titel. "</h1>";?>

					<?php 	//<h2> smalldescription
						if (!empty($smalldescription)) echo "<h2>". $smalldescription. "</h2><br>";?>
					
					<?php  	//Startpage only: New Entries if there are any: count the stringlength and deside if there is an entry
						if ($start==1) {$newest= newest(3,0,1,1); if (strlen($newest)>81){echo "<h1 class=\"h1head\">New Topics <a href=\"$firstparturl"."rss.php\"><img src=\"". $firstparturl. "image/rss.png\" alt=\"Newsfeed\" style=\"border:0\"></a></h1>"; echo str_replace('"150"','"100"',$newest); echo "<br>";}}?>
					
					<?php 	//$text write the content  add toc if there are more then 3 headers:
						if ($start!=1 and substr_count($text, '<h')>3) echo "<h4>$lang_txt_022</h4><ol id=\"toc\"></ol><div id=\"toccontent\"><div style=\"clear:left;\"></div>$text</div>";else echo $text;?>

					<?php 	//if there are subtopics build a menu (links and thumbnails)
						if ($start!=1) echo str_replace('"150"','"100"', buildmenu($level+1,$level+1,$level+1,"0","1"));?>
					
					<?php	//add user Feedbacks to the site:
						if ($start!=1) if ($addfeedback==1) {echo "<div style=\"clear:left;\"></div><br><h1>Feedback:</h1>";include("plugins/libe/feedback.php");}?>


				<br />
				<div id="prevnext">
					<?php if (!empty($prev_topic)) echo "<", $prev_topic, "... ";
					if (!empty($next_topic)) echo " ...", $next_topic, ">";?>
				</div>
			</div>
			

	</div>

	<div id="footer"> <?php echo date("d.m.Y H:i");?>
		<a href="http://cms.libe.net">powered by cms.libe.net</a>
	</div>

</body>
</html>

