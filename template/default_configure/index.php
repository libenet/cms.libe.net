<?php
//Template Variables can be configured here:
$topheight="100"; //height for top image
$containerwidth="900";//Container width
$leftmargin="10"; //Left width
$leftwidth="170"; //Left width
$rightwidth="20"; //Left width
$backgroundimage="";
$backgroundcolor="555";
$fontfamily="sans-serif";
$fontcolor="555";
$fontsize="14";
$topimage="";
$containerimage="background.jpg";
$containerbackground="fff"; //image should be placed in Template Folder
$footerimage="";
$effectshadow="ccc";
?><!DOCTYPE html>
<html lang="de">
<head>
<meta charset="windows-1252" />

<link rel="stylesheet" href="<?php echo $firstparturl,$templatedir;?>main.css" type="text/css" />

<title><?php echo $titel;?></title>

<style>
#container{width:<?php echo $containerwidth;?>px;background-image: url('<?php echo $firstparturl,$templatedir,$containerimage;?>');background-color:#<?php echo $containerbackground;?>;
-moz-box-shadow:    1px 4px 3px 4px #<?php echo $effectshadow;?>;-webkit-box-shadow: 1px 4px 3px 4px #<?php echo $effectshadow;?>;box-shadow:         1px 4px 3px 4px #<?php echo $effectshadow;?>;
}
#headline {height:<?php echo $topheight;?>px;width:<?php echo $containerwidth;?>px;background: url('<?php echo $firstparturl,$templatedir,$topimage;?>');}
#left	{width:<?php echo $leftwidth;?>px;margin-left:<?php echo $leftmargin;?>px;}
#line {margin-left:<?php echo $leftmargin;?>px;}
#content{width:<?php echo $containerwidth-$leftwidth-20;?>px;}
#center{width:<?php echo $containerwidth-$leftwidth-$rightwidth-20;?>px;margin-right:<?php echo $rightwidth;?>px;}
#footer	{width:<?php echo $containerwidth;?>px;background-image: url('<?php echo $firstparturl,$templatedir,$footerimage;?>');}
body	{background-color:#<?php echo $backgroundcolor;?>;background-image: url('<?php echo $firstparturl,$templatedir,$backgroundimage;?>');}
body, td 	{font-family:<?php echo $fontfamily;?>; font-size: <?php echo $fontsize;?>px; color: #<?php echo $fontcolor;?>;}
P img, td img, .nimage img {-moz-box-shadow:    1px 4px 3px 4px #<?php echo $effectshadow;?>;-webkit-box-shadow: 1px 4px 3px 4px #<?php echo $effectshadow;?>;box-shadow:         1px 4px 3px 4px #<?php echo $effectshadow;?>;}
.feedback hr	{color:#<?php echo $fontcolor;?>;background-color: #<?php echo $fontcolor;?>;}

</style>

<?php //writes Meta Description
if (!empty($meta)) echo "<meta name=\"description\" content=\"", $meta,"\" />";?>

<!-- jquery used for Lightbox and other Plugins: default-template: only for Lightbox -->
<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery-1.7.2.min.js"></script>
<!-- jquery used for Lightbox and other Plugins -->

<!-- Lightbox -->
		<?php if (inStr("lightbox[roadtrip]",$text)) { ?>
		<link rel="stylesheet" href="<?php echo $firstparturl;?>plugins/lightbox/css/lightbox.css" type="text/css" media="screen" />
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery-ui-1.8.18.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery.smooth-scroll.min.js"></script>
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/lightbox/js/lightbox.js"></script>
		<!-- to pass html5 validation....-->
		<script>$(document).ready(function(){ $('a[data-rel]').each(function() {$(this).attr('rel', $(this).data('rel'));});});</script>
		<?php $text=str_replace('" rel="','" data-rel="',$text);?>
		<!-- ...to pass html5 validation: -->
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
	<div id="container">
		<div id="headline">
			<h1><?php echo $page_title;?></h1>
			<p><?php echo $page_description;?></p>
		</div>
		<div id="line"> <?php if (!empty($article)) echo $backlink;?>
		</div>
			<div id="left">								
				<?php 
				$menu=buildmenuul(); if(!empty($menu)) {echo "<ul>";
				if ($start=="1")echo "<li class=\"current\"><a href=\"$firstparturl\" class=\"mainmenu_active\">HOME</a></li>";else echo "<li class=\"linkg\"><a href=\"$firstparturl\" class=\"mainmenu_link\">HOME</a></li>";	
				echo $menu;echo "</ul>";} ?>							
			</div>

			<div id="content">
				<div id="right">
				</div>
				<div id="center">
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

					<?php if ($start!=1){?>
					<br /><div id="prevnext">
						<?php if (!empty($prev_topic)) echo $prev_topic;
						if (!empty($next_topic)) echo " ", $next_topic;?>
					</div>
					<?php }?>
			</div>

	</div>
	<div id="footer"><a href="http://cms.libe.net">powered by cms.libe.net</a>
	</div>

</body>
</html>
