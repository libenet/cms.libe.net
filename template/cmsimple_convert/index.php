<?php
$debug=0; //1 ... show all PHP Tags which are not converted<?php 

//Newsbox is ignored, because cms.libe.net has built in News from article, they are placed on the startpate if enabled in the article
/*Template
Converts CMSimple Templates to cms.libe.net, BETA
http://www.cmsimple.org/?Templates
*/


//global and head
$includeconvert = file_get_contents($templatedir."template.htm");
if (empty($includeconvert)) {echo "<h1>template.htm does not exist</h1><p>please copy the content of a CMSimple Template to <b>$templatedir</b></p>";exit;}

$includeconvert=str_replace(']?>','];?>',$includeconvert);
$includeconvert=str_replace('<?=','<?php echo ',$includeconvert);
  
$includeconvert=str_replace('; ?>',';?>',$includeconvert);
$includeconvert=str_replace('($hc, \'','($hc,\'',$includeconvert);
$includeconvert=str_replace('<!--?', '<?php',$includeconvert);
$includeconvert=str_replace('?-->', '?>',$includeconvert);
$includeconvert=str_replace('<!--<?php', '<?php',$includeconvert);
$includeconvert=str_replace('?>-->', '?>',$includeconvert);
$includeconvert=str_replace('<?php  echo', '<?php echo',$includeconvert);
$includeconvert = str_replace('<?=head();?>','<?php echo head();?>', $includeconvert);

//some variables
$includeconvert = str_replace('<?php echo sitename();?>','--**start_php**-- echo "$page_title";--**end_php**--', $includeconvert);
$includeconvert = str_replace('<?php echo sitename()?>','--**start_php**-- echo "$page_title";--**end_php**--', $includeconvert);
$includeconvert = str_replace('<?php echo $cf[\'site\'][\'title\'];?>','--**start_php**-- echo "$page_title";--**end_php**--', $includeconvert);

//Templatefolder:
$includeconvert = str_replace('<?php echo $pth[\'folder\'][\'template\'];?>','--**start_php**-- echo $firstparturl.$templatedir;--**end_php**--', $includeconvert);
$includeconvert = str_replace('<?php echo $pth[\'folder\'][\'templateimages\'];?>', '--**start_php**-- echo $firstparturl.$templatedir."images/";--**end_php**--', $includeconvert);


//CSS
//$includeconvert = preg_replace('#\<link rel=\"stylesheet\" href=\"\(.*)\"(.*)\>#Uis', '--**start_php**-- echo "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"'.$firstparturl.$templatedir.'\1\"/>";--**end_php**--', $includeconvert);
//JavaScript
//$includeconvert = preg_replace('#\<script type=\"text/javascript\" src=\"\(.*)\"\>\<\/script\>#Uis', '--**start_php**-- echo "\n<script type=\"text/javascript\" src=\"'.$firstparturl.$templatedir.'\1\"></script>";--**end_php**--', $includeconvert);

//Remove not cmsimple Warning
$includeconvert = preg_replace('#This template requires(.*)and install it first.#Uis', '', $includeconvert);

//head:
$replaces=0;
$includeconvert = str_replace('<?php echo onload();?>','<?php echo onload=\"\"?>', $includeconvert);
$includeconvert = str_replace('<?php echo head();?>', '--**start_php**-- echo "<title>$titel</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"'.$firstparturl.$templatedir.'stylesheet.css\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"'.$firstparturl.$templatedir.'tinymce.css\" />
<script type=\"text/javascript\" src=\"".$firstparturl."plugins/jquery/jquery-1.7.2.min.js\"></script>\n";
if (!empty($meta)) echo "<meta name=\"description\" content=\"". $meta."\" />";--**end_php**--', $includeconvert, $replaces);
if ($replaces==0) echo "<h1>ERROR: Template Converter: was not able to find the HEADER</h1>";


//locator
$replaces=0;
$includeconvert = str_replace('<?php echo $tx[\'locator\'][\'text\'];?>','You are here: &nbsp;', $includeconvert);
$includeconvert = str_replace('<?php echo locator();?>','--**start_php**-- echo $backlink;--**end_php**--', $includeconvert,$replaces);
if ($replaces==0) $includeconvert = str_replace('<?php echo locator();?>','--**start_php**-- echo $backlink;--**end_php**--', $includeconvert,$replaces);
if ($replaces==0) $includeconvert = str_replace('<?php echo searchbox();?>','--**start_php**-- echo $backlink;--**end_php**--', $includeconvert,$replaces);

$includeconvert = str_replace('<?php echo searchbox();?>','', $includeconvert);//cms.libe.net currently has no search function, maybe in future ...

//menu doc:
$replaces=0;
$includeconvert = str_replace('<?=toc()?>','<?php echo toc();?>', $includeconvert);
$includeconvert = str_replace('<?php echo toc();?>','--**start_php**-- echo "<ul class=\"menulevel1\">"; if ($start=="1") echo "<li class=\"sdoc\"><a href=\"$firstparturl\" class=\"mainmenu_active\">HOME</a></li>";else echo "<li class=\"doc\"><a href=\"$firstparturl\" class=\"mainmenu_link\">HOME</a></li>";echo str_replace("\"level2\"","\"menulevel3\"",str_replace("\"level1\"","\"menulevel2\"",str_replace("\"link\"","\"doc\"",str_replace("\"level0\"","\"menulevel1\"",str_replace("1_011", "", str_replace("\"current\"","\"sdoc\"",buildmenuul(1,0,3)))))));--**end_php**--', $includeconvert,$replaces)."</ul>";
if ($replaces==0) $includeconvert = str_replace('<?php echo xtoc(1);?>','--**start_php**-- echo "<ul class=\"menulevel1\">"; if ($start=="1") echo "<li class=\"sdoc\"><a href=\"$firstparturl\" class=\"mainmenu_active\">HOME</a></li>";else echo "<li class=\"doc\"><a href=\"$firstparturl\" class=\"mainmenu_link\">HOME</a></li>";echo str_replace("\"level2\"","\"menulevel3\"",str_replace("\"level1\"","\"menulevel2\"",str_replace("\"link\"","\"doc\"",str_replace("\"level0\"","\"menulevel1\"",str_replace("1_011", "", str_replace("\"current\"","\"sdoc\"",buildmenuul(1,0,1)))))));--**end_php**--', $includeconvert,$replaces)."</ul>";
if ($replaces==0) $includeconvert = str_replace('<?php echo xtoc();?>','--**start_php**-- echo "<ul class=\"menulevel1\">"; if ($start=="1") echo "<li class=\"sdoc\"><a href=\"$firstparturl\" class=\"mainmenu_active\">HOME</a></li>";else echo "<li class=\"doc\"><a href=\"$firstparturl\" class=\"mainmenu_link\">HOME</a></li>";echo str_replace("\"level2\"","\"menulevel3\"",str_replace("\"level1\"","\"menulevel2\"",str_replace("\"link\"","\"doc\"",str_replace("\"level0\"","\"menulevel1\"",str_replace("1_011", "", str_replace("\"current\"","\"sdoc\"",buildmenuul(1,0,3)))))));--**end_php**--', $includeconvert,$replaces)."</ul>";
if ($replaces==0) $includeconvert = str_replace('<?php echo tb_li_h($hc,\'menulevel\');?>', '--**start_php**-- echo "<ul class=\"art-hmenu\">"; if ($start=="1") echo "<li class=\"sdoc\"><a href=\"$firstparturl\" class=\"mainmenu_active\">HOME</a></li>";else echo "<li class=\"doc\"><a href=\"$firstparturl\" class=\"mainmenu_link\">HOME</a></li>";echo str_replace("\"link\"","\"doc\"",str_replace("\"current\"","\"sdoc\"",buildmenuul(3,0,3)));--**end_php**--', $includeconvert,$replaces)."</ul>";
if ($replaces==0) $includeconvert = str_replace('<?php echo li($hc,\'menulevel\');?>', '--**start_php**-- echo "<ul class=\"art-hmenu\">"; if ($start=="1") echo "<li class=\"sdoc\"><a href=\"$firstparturl\" class=\"mainmenu_active\">HOME</a></li>";else echo "<li class=\"doc\"><a href=\"$firstparturl\" class=\"mainmenu_link\">HOME</a></li>";echo str_replace("\"link\"","\"doc\"",str_replace("\"current\"","\"sdoc\"",buildmenuul(3,0,3)));--**end_php**--', $includeconvert,$replaces)."</ul>";
if ($replaces==0) echo "<h1>ERROR: Template Converter: was not able to find the MENU</h1>";

$includeconvert = preg_replace('#\<\?php echo xtoc\((.*)\,(.*)\)\;\?\>#Uis', '--**start_php**-- echo "<ul class=\"menulevel\1\">"; echo str_replace("level_2_2","\"doc\"", str_replace("\"link\"","\"doc\"",str_replace("\"current\"","\"sdoc\"",buildmenu(\1,\1,\1))));echo "</ul>";--**end_php**--', $includeconvert);
$includeconvert = str_replace('level_1_011','doc', $includeconvert);

$includeconvert = str_replace('<?php echo printlink();?>','---removeit---', $includeconvert);
$includeconvert = str_replace('<?php echo sitemaplink();?>','---removeit---', $includeconvert);
$includeconvert = str_replace('<?php echo mailformlink();?>','---removeit---', $includeconvert);
$includeconvert = preg_replace('#\<li\>---removeit---\<\/li\>#Uis', '', $includeconvert);
$includeconvert = str_replace('---removeit---','', $includeconvert);


$includeconvert = str_replace('<?php echo editmenu();?>','', $includeconvert);
$includeconvert = str_replace('<?php echo submenu();?>','--**start_php**-- if ($start!=1) echo str_replace("\"150\"","\"100\"", buildmenu($level+1,$level+1,$level+1,0,1));--**end_php**--', $includeconvert,$replacessub);


//Content:
$replaces=0;

//$replacessub
$maincontent='--**start_php**-- 
if ($start!=1) echo "<h1 class=\'h1head\'>$titel</h1>";
if (!empty($smalldescription)) echo "<h2>$smalldescription</h2><br>";else echo "<br>";
if ($start==1) {$newest= newest(3,0,1,1); if (strlen($newest)>81){echo "<h1>New Topics <a href=\"$firstparturl\".\"rss.php\"><img src=\"". $firstparturl. "image/rss.png\" alt=\"Newsfeed\" style=\"border:0\"></a></h1>"; echo str_replace(\'\"150\"\',\'\"100\"\',$newest); echo "<br>";}}
echo $text;';
if ($replacessub==0) $maincontent= $maincontent.'if ($start!=1) echo str_replace("\"150\"","\"100\"", buildmenu($level+1,$level+1,$level+1,"\"0\"","\"1\""));';
$maincontent=$maincontent.'
if ($start!=1) if ($addfeedback==1) {echo "<div style=\"clear:left;\"></div><br><h1>Feedback:</h1>";include("plugins/libe/feedback.php");}
--**end_php**--';

$includeconvert = str_replace('<?php echo content();?>',$maincontent, $includeconvert,$replaces);
if ($replaces==0) echo "<h1>ERROR: Template Converter: was not able to find the Contentarea</h1>";

$includeconvert = str_replace('<?php echo previouspage();?>','--**start_php**-- echo $prev_topic;--**end_php**--', $includeconvert);
$includeconvert = str_replace('<?php echo top();?>','', $includeconvert);
$includeconvert = str_replace('<?php echo nextpage();?>','--**start_php**-- echo $next_topic;--**end_php**--', $includeconvert);
$includeconvert = str_replace('<?php echo newsbox(\'News01\');?>','', $includeconvert);
$includeconvert = str_replace('<?php echo newsbox(\'News02\');?>','', $includeconvert);
$includeconvert = str_replace('<?php echo newsbox(\'News03\');?>','', $includeconvert);
$includeconvert = str_replace('<?php echo loginlink();?>','', $includeconvert);
$includeconvert = str_replace('powered by','Powered by', $includeconvert);
$includeconvert = str_replace('Powered by','Powered by <a href="http://cms.libe.net/">cms.libe.net</a> | Template converted from: ', $includeconvert);
$includeconvert = str_replace('<?php echo languagemenu();?>','', $includeconvert);


if ($debug==1){
$includeconvert = str_replace('<?php',htmlspecialchars("<?php"), $includeconvert);
$includeconvert = str_replace('?>',strip_tags("?>"), $includeconvert);
}else $includeconvert=preg_replace(array('#<\?(?:php)?(.*?)\?>#s'), array(''), $includeconvert);

$includeconvert = str_replace('--**start_php**--','<?php', $includeconvert);
$includeconvert = str_replace('--**end_php**--','?>', $includeconvert);

eval(' ?>'.$includeconvert.'<?php ');
?>

