<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
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
<link href="<?php echo $firstparturl,$templatedir;?>styles.css" rel="stylesheet" type="text/css" />

<style>#buttons a {width: <?php echo floor(690/(1+substr_count(buildmenu("1","1","1"),"<div")));?>px;}</style>

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
<div class="bg_foot">
<div id="main">
<!-- header begins -->
<div id="header">
    <div id="buttons">


	<?php 
	$menu=buildmenuul("1","0","1"); if(!empty($menu)) {
	if ($start=="1")echo "<li class=\"level_1_010\"><a href=\"$firstparturl\" id=\"mainmenu_active\">HOME</a></li>";else echo "<li class=\"level_2_222\"><a href=\"$firstparturl\" id=\"mainmenu_link\">HOME</a></li>";	
	echo $menu; 
	} ?>

    </div>
	<div id="logo"><a href="#"><?php echo $page_title;?></a>
	  <h3><?php echo $page_description;?></h3>
	</div>
</div>
<!-- header ends -->
        <!-- content begins -->
        <div id="content">
            <div id="left">
           	    <div class="left_t"><?php if ($start!=1) echo $backlink;if (!empty($titel)) echo "<h2>", $titel, "</h2>";?></div>
                <div class="left_b">


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
            

			<?php
			$menu=buildmenuul("1",$menuforlevel[1],"5"); if(!empty($menu) and $start!=1) {

            	echo "<div id=\"right\">  <h1>",$menuforlevel[1],"</h1>
                <div class=\"tit_bot\">
                  <ul>

			$menu 

                  </ul>
                  <br /></div>
           	  </div>";} ?>
         
         <div style="clear: both;"><img src="images/spaser.gif" alt="" width="1" height="1" /></div>
					<?php if ($start!=1){?>
					<br /><div id="prevnext">
						<?php if (!empty($prev_topic)) echo $prev_topic;
						if (!empty($next_topic)) echo " ", $next_topic;?>
					</div>
					<?php }?>
</div>
<!-- content ends -->
 <!-- footer begins -->
<div id="footer">
  Copyright  <?php echo $page_title;?> Designed by <a href="http://www.metamorphozis.com/" title="Flash Templates">Flash Templates</a>  <a href="http://cms.libe.net">powered by cms.libe.net</a><br />
<!-- footer ends -->
</div>
</div>
</body>
</html>
