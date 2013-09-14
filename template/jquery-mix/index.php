<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<title><?php echo $titel;?></title>
<?php if (!empty($meta)) echo "<meta name=\"description\" content=\"", $meta,"\" />";
if (empty($cssload))$cssload="main.css";
?>
<link rel="stylesheet" type="text/css" href="<?php echo $firstparturl,$templatedir,$cssload;?>" />

<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery-1.7.2.min.js"></script>


<!-- bgstretcher ... -->
<link rel="stylesheet" type="text/css" href="<?php echo $firstparturl;?>plugins/bgstretcher/bgstretcher.css" />
<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/bgstretcher/bgstretcher.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	
        //  Initialize Backgound Stretcher	   
		$('BODY').bgStretcher({
			images: ['<?php echo $firstparturl,$templatedir;?>bgstretch.jpg'],
			imageWidth: 800, 
			imageHeight: 500, 
			slideDirection: 'N',
			slideShowSpeed: 1000,
			transitionEffect: 'fade',
			sequenceMode: 'normal',
			buttonPrev: '#prev',
			buttonNext: '#next',
			pagination: '#nav',
			anchoring: 'center top',
			anchoringImg: 'center top'
		});
		
	});
</script>
<!-- ...bgstretcher -->
		

<!-- superfish  ... -->
		<link rel="stylesheet" type="text/css" href="<?php echo $firstparturl;?>plugins/superfish/css/superfish.css" media="screen">
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/superfish/js/hoverIntent.js"></script>
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/superfish/js/superfish.js"></script>
		<script type="text/javascript">
		// initialise plugins
		jQuery(function(){
			jQuery('ul.sf-menu').superfish({ 
			    delay:       500,                            // one second delay on mouseout 
			    animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
			    speed:       'fast',                          // faster animation speed 
			    autoArrows:  true,                           // disable generation of arrow mark-up 
			    dropShadows: false,                            // disable drop shadows 
			    hoverClass:    'sfHover',          // the class applied to hovered list items 
		   	    pathClass:     'overideThisToUse', // the class you have applied to list items that lead to the current page 
			});
		});
		</script>
		<style>
		<?php $sfwidth="780";?>
		ul.sf-menu li { width: <?php echo floor($sfwidth/(1+substr_count(buildmenu("1","1","1"),"<div")));?>px; margin-top: -1px; }
		.sf-menu ul {width:<?php echo floor($sfwidth/(1+substr_count(buildmenu("1","1","1"),"<div")));?>px;}
		ul.sf-menu li li{ width:150px;}	
		ul.sf-menu li li:hover ul,
		ul.sf-menu li li.sfHover ul {left:<?php echo floor($sfwidth/(1+substr_count(buildmenu("1","1","1"),"<li")));?>px;}
		ul.sf-menu li li li:hover ul,
		ul.sf-menu li li li.sfHover ul {left:<?php echo floor($sfwidth/(1+substr_count(buildmenu("1","1","1"),"<li")));?>px;}
		.sf-menu li {z-index:99;
			background: #ccc;filter:alpha(opacity=90);opacity: .9;-moz-opacity: .9;
		}

		.sf-menu li:hover, .sf-menu li.sfHover,
		.sf-menu a:focus, .sf-menu a:hover, .sf-menu a:active {
			background: url('<?php echo $firstparturl,$templatedir;?>superfish.png');
			outline:		0;color:#fff;
		}
		
		.sf-menu{margin-top:30px;}
		
		.sf-menu li li {
		background:		#ccc;
		}
		.sf-menu li li li {
			background:		#ddd;
		}
		.sf-menu a {
			border:	0px;
		</style>
<!-- ... superfish -->

<!-- corner -->
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquerycorner/jquery.corner.js"></script>
		<script type="text/javascript">
			
			$('#headline-menu ul li').corner("2px cc:#ccc sc:#fff top  sc:#ddd bottom keep").corner("tear 10px");
			$('#center').corner("bottom 10px");
			$('#right').corner("10px");
			$('#footer a').corner("10px");
		</script>
<!-- ... corner -->

<!-- AnySlider ...
		//to load anyslider: you need a topic called effects-startpage, put pictures into it and load the effect in an other topic by typing: ***effects-startpage-PLACEHOLDER*** -->
		<?php if (inStr("***effects-startpage-PLACEHOLDER***",$text)) {?>
		<script>window.jQuery || document.write('<script src="<?php echo $firstparturl;?>plugins/any-slider/js/jquery.min.js"><\/script>')</script>
		<link rel="stylesheet" href="<?php echo $firstparturl,$templatedir;?>any-slider.css">
		<!-- Anything Slider -->
		<link rel="stylesheet" href="<?php echo $firstparturl;?>plugins/any-slider/css/anythingslider.css">
		<script src="<?php echo $firstparturl;?>plugins/any-slider/js/jquery.anythingslider.js"></script>
		<!-- Anything Slider optional plugins -->
		<script src="<?php echo $firstparturl;?>plugins/jquery/jquery.easing.1.2.js"></script>
		<link rel="stylesheet" href="<?php echo $firstparturl;?>plugins/any-slider/css/theme-metallic.css">
		<!-- Define slider dimensions here -->
		<style>
		#slider { width: 400px; height: 300px;}
		div.anythingSlider .anythingWindow {height: 300px;}
		</style>
		<script>
		<!-- AnythingSlider initialization -->
			// DOM Ready
			$(function(){
				$('#slider').anythingSlider({
	 			autoPlay      : true,
				buildArrows         : true,     // If true, builds the forwards and backwards buttons
				buildNavigation     : true,   	// If true, builds a list of anchor links to link to each panel
				buildStartStop      : true, 	// If true, builds the start/stop button
				theme           : 'metallic',
				easing          : 'easeInOutBack'     
				});
			});
		</script>
		<!-- Older IE stylesheet, to reposition navigation arrows, added AFTER the theme stylesheet -->
		<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php echo $firstparturl,$templatedir;?>anythingslider-ie.css" type="text/css" media="screen" />
		<![endif]-->
		<?php 
		//Placeholder: ***EFFECT-SLIDER-PLACEHOLDER*** replaced by anythingSlider: 
		$effect=loadcontent("effects-startpage");//load the Content of topic effects-startpage->
		$text=str_replace("***effects-startpage-PLACEHOLDER***", "<ul id=\"slider\">$effect</ul>", $text);//put the loaded content in <ul id=..></ul>
		}
		?>
<!-- ... AnySlider -->

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

<!-- ... Shadow animation jQuery plugin... -->
<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery.animate-shadow-min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
	    $("#headline-menu ul li").animate({boxShadow: '5 5 5px #000'});
            $("#center").animate({boxShadow: '0 0 30px #000'});
	    $("#right").animate({boxShadow: '5 5 10px #000'});
    });
</script>
<!-- ... Shadow animation jQuery plugin -->

<!-- Page Transition fade ...-->
<script type="text/javascript">
    $(document).ready(function() {
            $("body").css("display", "none");
            $("body").fadeIn(1000);
    });
</script>
<!-- ...Page Transition fade-->

</head>
<body id="toc-top">



	<div id="headline-menu">
		<h1><?php echo $page_title;?></h1><h2><?php echo $page_description;?></h2>
			<ul class="sf-menu">
				<?php 
				if ($start=="1")echo "<li class=\"level_1_010\"><a href=\"$firstparturl\" id=\"mainmenu_active\">HOME</a></li>";else echo "<li class=\"level_2_222\"><a href=\"$firstparturl\" id=\"mainmenu_link\">HOME</a></li>";	
				echo buildmenuul("2");
				?>
			</ul>

	</div>



	</div>
	<div id="container">

			
				<?php

				
				

				$menu=buildmenuul("1",$menuforlevel[1],"5"); if(!empty($menu) and $start!=1) {
				echo "<div id=\"right\">";
				echo "<h1>Topics</h1>";
				echo "<h3>",$menuforlevel[1],"</h3>";
				echo "<ul>";
				echo $menu;echo "</ul>";echo "</div>";}
				

				//echo loadcontent("additional-area");
				?>
			
			<div id="center">
				<div id="backlink">
							<?php if (!empty($menuforlevel[$level])) echo "<h2>", $menuforlevel[$level-1], "</h2>"; if (!empty($article)) echo $backlink;?>
				</div>
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
			<div id="prevnext">
				<?php if (!empty($prev_topic)) echo $prev_topic;
				if (!empty($next_topic)) echo $next_topic;?>
			</div>
	</div>
	<div id="footer">
		<a href="http://cms.libe.net">powered by cms.libe.net</a>
	</div>
</body>
</html>
