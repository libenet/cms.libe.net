<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License
--><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
				
<link rel="stylesheet" href="<?php echo $firstparturl,$templatedir;?>default.css" type="text/css" />
<title><?php echo $titel;?></title>
<?php if (!empty($meta)) echo "<meta name=\"description\" content=\"", $meta,"\" />";
?>
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

<body id="toc-top">
<div id="logo">
	<h1><?php echo $page_title;?></h1><br>
	<h2><a href="<?php echo $firstparturl;?>"><?php echo $page_description;?></a></h2>
</div>
<div id="menu">
												<?php 
												$menu=buildmenuul("1","0","1"); if(!empty($menu)) {echo "<ul>";
												if ($start=="1")echo "<li class=\"level_1_010\"><a href=\"$firstparturl\" class=\"mainmenu_active\">HOME</a></li>";else echo "<li class=\"level_2_222\"><a href=\"$firstparturl\" class=\"mainmenu_link\">HOME</a></li>";	
												echo $menu; 
													echo "</ul>
												</li>";} ?>

</div>
<div id="content">
	<div id="sidebar">

												<?php 
												$menu=buildmenuul("1",$menuforlevel[1],"5"); if(!empty($menu)) {

												echo "		<div id=\"login\" class=\"boxed\">
													<h2 class=\"title\">$menuforlevel[1]</h2>
													<div class=\"content\"><ul>";
												echo $menu; 
												echo "</ul>
												</li></div></div>";} ?>
			
		

	</div>
	<div id="main">
		<div id="welcome" class="post"><?php if (!empty($article)) echo $backlink, "<br /><br />";?>
					<?php	//h1 titel:
						if ($start!=1) echo "<h1 class=\"h1head\">". $titel. "</h1>";?>

					<?php 	//<h2> smalldescription
						if (!empty($smalldescription)) echo "<h2>". $smalldescription. "</h2><br>";?>
					
					<?php  	//Startpage only: New Entries if there are any: count the stringlength and deside if there is an entry
						if ($start==1) {$newest= newest(3,0,1,1); if (strlen($newest)>81){echo "<h1 class=\"h1head\">New Topics <a href=\"$firstparturl"."rss.php\"><img src=\"". $firstparturl. "image/rss.png\" alt=\"Newsfeed\" style=\"border:0\"></a></h1>"; echo str_replace('"150"','"100"',$newest); echo "<br>";}}?>
					
					<?php 	//$text write the content  add toc if there are more then 3 headers:
						if (substr_count($text, '<h')>3 and $start!=1) echo "<h4>$lang_txt_022</h4><ol id=\"toc\"></ol><div id=\"toccontent\"><div style=\"clear:left;\"></div>$text</div>";else echo $text;?>
					
					<?php 	//if there are subtopics build a menu (links and thumbnails)
						if ($start!=1) echo str_replace('"150"','"100"', buildmenu($level+1,$level+1,$level+1,"0","1"));?>
					
					<?php	//add user Feedbacks to the site:
						if ($start!=1) if ($addfeedback==1) {echo "<div style=\"clear:left;\"></div><br><h1>Feedback:</h1>";include("plugins/libe/feedback.php");}?>
		</div>


	</div>
				<?php if ($start!=1){?>
					<div id="prevnext">
						<?php if (!empty($prev_topic)) echo $prev_topic;
						if (!empty($next_topic)) echo " ", $next_topic;?>
					</div>
					<?php }?>
	<div id="extra" style="clear: both;"></div>
</div><br />
<div id="footer">
	<p id="legal">Copyright (c) 2007 The Wild. All Rights Reserved. Designed by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.<!--%@##--> Design provided by <a href="http://www.freewebtemplates.com">Free Website Templates</a>.<!--##@%--></p>
	<p id="links"><a href="http://cms.libe.net">powered by cms.libe.net</a>
</div>
</body></html>
