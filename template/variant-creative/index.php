<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
			
<title><?php echo $titel;?></title>
<?php if (!empty($meta)) echo "<meta name=\"description\" content=\"", $meta,"\" />";
?>
<link href="<?php echo $firstparturl,$templatedir;?>variant-creative.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery-1.7.2.min.js"></script>
<!-- Lightbox -->
		<?php if (inStr("lightbox[roadtrip]",$text)) { ?>

		<link rel="stylesheet" href="<?php echo $firstparturl;?>plugins/lightbox/css/lightbox.css" type="text/css" media="screen" />
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery-ui-1.8.18.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery.smooth-scroll.min.js"></script>
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/lightbox/js/lightbox.js"></script>
		<?php }?>
<!-- ... Lightbox -->

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
<div id="wrap">
	<div id="header">
		<h1><a href="<?php echo $firstparturl;?>"><?php echo $page_title;?></a></h1>
		<p><?php echo $page_description;?></p>
	</div>

	<div id="leftside">
		<h2 class="hide">Sample menu:</h2>
		<div class="extras">
			<p><?php if (!empty($article)) echo $backlink;?></p>
		</div>
		<ul class="avmenu">

							<?php 
							echo buildmenuul();?>

		</ul>


	</div>

	<div id="extras">
		<?php echo loadcontent("additional-area");?>	
	</div>

    <div id="content">
					<?php	//h1 titel:
						if ($start!=1) echo "<h1 class=\"h1head\">". $titel. "</h1>";?>

					<?php 	//<h2> smalldescription
						if (!empty($smalldescription)) echo "<h2>". $smalldescription. "</h2><br>";?>
					
					<?php  	//Startpage only: New Entries if there are any: count the stringlength and deside if there is an entry
						if ($start==1) {$newest= newest(3,0,1,1); if (strlen($newest)>81){echo "<h1 class=\"h1head\">New Topics <a href=\"$firstparturl"."rss.php\"><img src=\"". $firstparturl. "image/rss.png\" alt=\"Newsfeed\" style=\"border:0\"></a></h1><br><br><br><br>"; echo str_replace('"150"','"100"',$newest); }}?>
					
					<?php 	//$text write the content  add toc if there are more then 3 headers:
						if (substr_count($text, '<h')>3 and $start!=1) echo "<h4>$lang_txt_022</h4><ol id=\"toc\"></ol><div id=\"toccontent\"><div style=\"clear:left;\"></div>$text</div>";else echo $text;?>
					
					<?php 	//if there are subtopics build a menu (links and thumbnails)
						if ($start!=1) echo str_replace('"150"','"100"', buildmenu($level+1,$level+1,$level+1,"0","1"));?>
					
					<?php	//add user Feedbacks to the site:
						if ($start!=1) if ($addfeedback==1) {echo "<div style=\"clear:left;\"></div><br><h1>Feedback:</h1>";include("plugins/libe/feedback.php");}?>
	</div>

	<div id="footer">
		<p>
		Template design by <a href="http://andreasviklund.com/">Andreas Viklund</a> <a href="http://cms.libe.net">powered by cms.libe.net</a></p>
	</div>

</div>
</body>
</html>
