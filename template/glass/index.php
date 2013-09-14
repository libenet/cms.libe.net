<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="windows-1252" />
<title><?php echo $titel;?></title>
<?php if (!empty($meta)) echo "<meta name=\"description\" content=\"", $meta,"\" />";
?>
<link rel="stylesheet" type="text/css" href="<?php echo $firstparturl,$templatedir;?>main.css" />
<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery-1.7.2.min.js"></script>

		

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
			    autoArrows:  false,                           // disable generation of arrow mark-up 
			    dropShadows: false,                            // disable drop shadows 
			    hoverClass:    'sfHover',          // the class applied to hovered list items 
		   	    pathClass:     'overideThisToUse' // the class you have applied to list items that lead to the current page 
			});
		});
		</script>
		<style>
		<?php $sfwidth="600";?>
		ul.sf-menu li { width:150px; margin-top: -1px;
    		-webkit-border-radius: 4px 4px 0px 0px;
            	border-radius: 4px 4px 0px 0px;}
		ul.sf-menu li li { width:200px;}
		.sf-menu ul {width:150px;}
		ul.sf-menu li li:hover ul,
		ul.sf-menu li li.sfHover ul {left:200px;}
		ul.sf-menu li li li:hover ul,
		ul.sf-menu li li li.sfHover ul {left:200px;}
		.sf-menu li {border-right:#fff 1px solid;
			background: #435a79;font-family: 'Verdana', cursive;filter:alpha(opacity=90);opacity: .9;-moz-opacity: .9;text-transform:capitalize;
		}

		
		.sf-menu a:focus, .sf-menu li a:hover, .sf-menu a:active {
			outline:		0;color:#fff;
		}
		
		.sf-menu{margin-top:0px;}
		
		.sf-menu li li a,.sf-menu li li a:hover{
		background:#435a79 none;  border-style:solid;
  			border-width:2px;font-size:11px;height:10px;
 			 border-color:#fff;text-transform:uppercase;
    		-webkit-border-radius: 4px;
            	border-radius: 4px;
		}
		.sf-menu li li a:hover,.sf-menu li a:hover{    		
		-webkit-border-radius: 4px 4px 0px 0px;
            	border-radius: 4px 4px 0px 0px;
		background:#000}
		.sf-menu li a{
			border:	0px;height:12px;background: color:#000;line-height:16px;

			}
		.sf-menu a, .sf-menu a:visited {
		    color: #fff;
		}
		</style>
<!-- ... superfish -->

<!-- corner -->
		<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquerycorner/jquery.corner.js"></script>
		<script type="text/javascript">
			$('#center').corner("bottom 10px");
			$('#right').corner("10px");
			$('#footer a').corner("10px");
		</script>
<!-- ... corner -->


<!-- Lightbox -->
		<?php if (inStr("lightbox",$text)) { ?>
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

<!-- ... Shadow animation jQuery plugin... -->
<script type="text/javascript" src="<?php echo $firstparturl;?>plugins/jquery/jquery.animate-shadow-min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
            $("#center").animate({boxShadow: '0 0 30px #000'});
	    $("#right").animate({boxShadow: '5 5 10px #000'});
    });
</script>
<!-- ... Shadow animation jQuery plugin -->


<style>ul.sf-menu li  {width: <?php echo floor(800/(1+substr_count(buildmenu("1","1","1"),"<div")));?>px;}</style>


</head>
<body id="toc-top">

<div style="color:#000;text-align:center;font-size:50px;text-shadow: 3px 3px 3px #000;font-family: 'Verdana', cursive;"><?php echo $page_title;?></div>
<div style="color:#000;text-align:center;margin-left:100px;font-size:30px;text-shadow: 3px 3px 3px #000;font-family: 'Verdana', cursive;"><?php echo $page_description;?></div>

<div class="container">

	 <div class="glass-oben">

	 </div>
	 <div class="glass-mitte">

		<div id="headline-menu">	


				<ul class="sf-menu">
					<?php 
					echo buildmenuul("3");
					?>
				</ul>	

		</div>	
				<div id="backlink">
					<?php if (!empty($article)) echo $backlink;?>
				</div>

				<div id="menu-left">				
				<?php //in Menu Left display news on startpage / menuentries in submenus
				if ($start!=1) echo "<ul class=\"leftmen\">",buildmenuul("1",$menuforlevel[1],"5"), "</ul>";else
				//Startpage only: New Entries if there are any: count the stringlength and deside if there is an entry
				{$newest= newest(3,0,1,1); if (strlen($newest)>81){echo "<h1 class=\"h1head\">New Topics <a href=\"$firstparturl"."rss.php\"><img src=\"". $firstparturl. "image/rss.png\" alt=\"Newsfeed\" style=\"border:0\"></a></h1>"; echo str_replace('"150"','"100"',$newest); echo "<br>";}}
				?>		
				</div>	
			


				<div class="centertext">

					<?php	//h1 titel:
						if ($start!=1) echo "<h1 class=\"h1head\">". $titel. "</h1>";?>

					<?php 	//<h2> smalldescription
						if (!empty($smalldescription)) echo "<h2>". $smalldescription. "</h2><br>";?>
									
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

				<div class="glass-unten">
						
				</div>



				<div id="footer">
				 <br/><a href="http://cms.libe.net">powered by cms.libe.net</a>
				</div>
</div>


</body>
</html>

