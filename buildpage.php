<?php
		/** SEO **/
		$requri = explode("/", $_SERVER['REQUEST_URI']);
		//URL..
		$requesturi=$_SERVER['REQUEST_URI'];
		$requesturia = explode( '-feedback-', $requesturi);
		$requesturi=$requesturia[0];
		if (!empty($requesturia[1]) and instr(".php",$requesturia[1]))$requesturi=$requesturi.".php";		
		$requesturia = explode( '?', $requesturi);
		$requesturi=$requesturia[0];
		//..URL

		$article=$requri[count($requri)-1];
		$pieces = explode( '-feedback-', $article );
		$article=$pieces[0];
		$pieces = explode( '?', $article );
		$article=$pieces[0];
		$url="http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"];
		$urlparts=explode('index', $url);
		$firstparturl= $urlparts[0];
		//$requesturi="/".substr($requesturi, 1);
		$IP=getenv('REMOTE_ADDR');
		/** SEO **/

		/** Template Variables **/
			$page_title=html_entity_decode(str_replace("0AND0", "&",str_replace("0SPACE0", " ", str_replace("0EQUAL0", "=",str_replace("0SLASH0", "/",str_replace("0COLON0", ":",str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $page_title)))))))));
			$page_description=html_entity_decode(str_replace("0AND0", "&",str_replace("0SPACE0", " ", str_replace("0EQUAL0", "=",str_replace("0SLASH0", "/",str_replace("0COLON0", ":",str_replace("0SEMI0", ";",str_replace("0DOT0", ".",str_replace("0AT0", "@", $page_description)))))))));
		/** Template Variables **/

		/*** read ADDITIONAL***/
		$file="dat_menu_file2";
		$Pfad= "daten/$file.dat";$datei = fopen($Pfad, "r");$savethetext=fread($datei, filesize($Pfad));fclose($datei);
		$menuarray2=explode ("\n",$savethetext);

		//modification for feedback-module
		$pieces = explode( "-feedback-", $_SERVER['REQUEST_URI'] );
		if (instr("-feedback-", $_SERVER['REQUEST_URI'])){$feedbacktitelext= str_replace(".php", "",$pieces[1]);
		if (substr($_SERVER['REQUEST_URI'], -4, 4)==".php") $pieces[0]="$pieces[0].php";
		}if (!empty($pieces[0])) $pathdisplay=$pieces[0];else $pathdisplay=$_SERVER['REQUEST_URI'];
		$pieces = explode( '?', $pathdisplay );
		$pathdisplay=$pieces[0];
		$pieces = explode( '-feedback-', $pathdisplay );
		$pathdisplay=$pieces[0];

		//modification for feedback-module

		for ($i=0; $i<count($menuarray2);$i++)
		{unset($arrayseiteadd);
		$arrayseiteadd = explode ("---///___", $menuarray2[$i]);
		$datumarray[$i]= trim($arrayseiteadd[0]);
		$titelarray[$i]= trim($arrayseiteadd[1]);
		$titelmenuarray[$i]= trim($arrayseiteadd[5]);
		$metaarray[$i]= trim($arrayseiteadd[2]);
		$fileandpathnamearray[$i]= trim($arrayseiteadd[3]);
		$smalldescriptionarray[$i]= trim($arrayseiteadd[6]);
		$newsentryarray[$i]= trim($arrayseiteadd[7]);
		$previewarray[$i]= trim($arrayseiteadd[8]);
		if ("/".$fileandpathnamearray[$i] == $pathdisplay) $article=$arrayseiteadd[4];//... for Mod Rewrite
		$pieces = explode( '-feedback-', $article );
		$article=$pieces[0];
		}
		/*** read ADDITIONAL***/


	/*** read page content, build variables: $titel, $meta, $text...***/
		/*** read entry***/
		$file=$article;

		if ($file==$index or (empty($file))){$file="Startseite";$start=1;}
		$Pfad= "daten/$file.dat";$datei = fopen($Pfad, "r");$savethetext=fread($datei, filesize($Pfad));fclose($datei);
		$arrayseite = explode ("---///___", $savethetext);
		$titel= trim($arrayseite[0]);
		$metaadd = explode ("---xxx___", $arrayseite[1]);
		$meta= $metaadd[0];
		//feedback
		if (!empty($feedbacktitelext)) {$titel="Feedback - $titel - Page: $feedbacktitelext";unset($meta);}
		if (empty($titel))$titel=$article;
		//..feeback


		//move permanently, mit Meta Description "move301-http://url"
		if (instr("move301-", $meta)) 
			{$permanentlymove=str_replace("move301-", "",$meta);
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: $permanentlymove");exit;
			}


		if ($language=="de") $datetime= date("d.m.Y H:i",$metaadd[1]); else $datetime= date("m/d/Y H:i",$metaadd[1]);
		if (empty($loginadmin)) if ($metaadd[1]> time()) {echo "topic not released"; exit;}
		$fileandpathname=$metaadd[2];
		
		//if modrewrite on, move 301 to custom path:
		if (!empty($fileandpathname) and instr($fileandpathname,$requesturi)!=1 and $modrewrite=="on")
        	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".$firstparturl.$fileandpathname);exit;
		}

		$menutitel=$metaadd[3];
		$smalldescription=$metaadd[4];
		$addfeedback= $metaadd[8];
		$text= str_replace("../image/", $firstparturl. "image/",$arrayseite[2]);
		$text= str_replace("../download/", $firstparturl. "download/",$text);	
		$text= str_replace("//image/", "/image/",$text);

		$text= str_replace("tinymce/jscripts/tiny_mce/plugins/emotions/img/", $firstparturl. "image/emotions/",$text);
		if (instr("-feedback-", $_SERVER['REQUEST_URI'])) $text=$lang_txt_015;

		/*** read entry***/
		$file="dat_menu_file";
		$Pfad= "daten/$file.dat";$datei = fopen($Pfad, "r");$savethetext=fread($datei, filesize($Pfad));fclose($datei);
		$arrayseite = explode ("---///___", $savethetext);
		$menuarray=explode ("\n",$arrayseite[2]);
		if ($modrewrite!="on") {unset($fileandpathnamearray);unset($fileandpathname);}

		//cleanup array (tag disabled entries: do_not_display)..
		$startx=0;
		if (leftspaces($menuarray[0])==0) {$startx=1;} //if first MenuEntry = without spaces at the beginning, start with it ...
		$article_in_menu=0; //
		foreach($menuarray as $key => $value) 
		{
			if (trim($article)==trim(encodeurl($menuarray[$key]))) {$mykey=$key;$article_in_menu=1;}   //is this the actual topic, used for disabledmenu?
			$trimit=trim($value);if ($menulevel[$key]==1 and $key<=$me)$currentmenu=$key;	
			//find out the next enabled entry:
			$nextenabled="";
			for ($tr=$key; $tr<count($menuarray);$tr++){if ($datumarray[$key+$tr-$key+1]<=time()) {if (leftspaces($menuarray[$key+$tr-$key+1])==0) break; $nextenabled=$menuarray[$key+$tr-$key+1];break;}}
			if($trimit{0}=="'" or $value == "") {if (empty($mykey)) $disabledmenu=$menuarray[$key];$disabledarray[$menuarray[$key]]=$nextenabled;unset($previewarray[$key]);unset($newsentryarray[$key]);unset($smalldescriptionarray[$key]);unset($menuarray[$key]);unset($titelarray[$key]);unset($titelmenuarray[$key]);unset($fileandpathnamearray[$key]);unset($datumarray[$key]);} //this line removes disabled and empty menuentries
			if (leftspaces($value)==0) {$disabledarray[$menuarray[$key]]=$nextenabled;} //do not only stored disabled menus, store every other top level menu

			//disabledarray for buildmenuul .. to make small menu units
			if ($startx==0) if (leftspaces($menuarray[$key])>0) {unset($newsentryarray[$key]);unset($previewarray[$key]);unset($smalldescriptionarray[$key]);unset($titelarray[$key]);unset($menuarray[$key]);unset($titelmenuarray[$key]);unset($fileandpathnamearray[$key]);unset($datumarray[$key]);$startx=1;} //this line removes menuentries at the beginning of the menu starting with a space
			if ($end_level>0)if (leftspaces($menuarray[$key])>$end_level-1){unset($newsentryarray[$key]);unset($previewarray[$key]);unset($smalldescriptionarray[$key]);unset($titelarray[$key]);unset($menuarray[$key]);unset($titelmenuarray[$key]);unset($fileandpathnamearray[$key]);unset($datumarray);}
			if (strlen($menuarray[$key])<2){unset($newsentryarray[$key]);unset($smalldescriptionarray[$key]);unset($previewarray[$key]);unset($menuarray[$key]);unset($titelarray[$key]);unset($titelmenuarray[$key]);unset($fileandpathnamearray[$key]);unset($datumarray[$key]);}
			if ($datumarray[$key]>time()) {unset($previewarray[$key]);unset($newsentryarray[$key]);unset($smalldescriptionarray[$key]);unset($menuarray[$key]);unset($titelarray[$key]);unset($titelmenuarray[$key]);unset($fileandpathnamearray[$key]);unset($datumarray[$key]);}
		}
		if ($start!=1 and $article_in_menu==0) $text="<br><h1>$lang_txt_020</h1><br>"; //if article is not in menustructure write an error message
		$menuarray = array_values($menuarray); 
		$previewarray = array_values($previewarray);
		$titelmenuarray = array_values($titelmenuarray);
		$titelarray = array_values($titelarray);
		$datumarray = array_values($datumarray);
		$fileandpathnamearray = array_values($fileandpathnamearray);
		$smalldescriptionarray = array_values($smalldescriptionarray);
		$newsentryarray = array_values($newsentryarray);
		// .. cleanup
	/*** ... read page content, build variables: $titel, $meta, $text: $titel, $meta, $text ***/


	/*** read site-navigation, build variables: $mainmenu , $submenu ,$backlink ...***/
		$backlink="<a href=".$firstparturl.">Home</a>";

	//Backlinks and levels
		for ($i=0; $i<count($menuarray);$i++){
		$this_level=strlen(str_replace(trim($menuarray[$i]), "",chop($menuarray[$i])));
		$menulevel[$i]=$this_level+1; //remember level
		//$menuback[$this_level]=$menuarray[$i];
		if (!empty($fileandpathnamearray[$i]))$menuback[$this_level]=$fileandpathnamearray[$i];else $menuback[$this_level]=$index. "/".encodeurl($menuarray[$i]);
		$menubackforlevel[$this_level]=$titelarray[$i];
		
		if (!empty($titelmenuarray[$i]))$menubacktitel[$this_level]=$titelmenuarray[$i];else $menubacktitel[$this_level]=$menuarray[$i];
		$menuarray[$i]=preg_replace("/\r|\n/s", "", $menuarray[$i]);

		//Backlinks
		if (trim($article)==trim(encodeurl($menuarray[$i])))
		{
			$level=$this_level+1;$start_sub_menu=$new_sub_begin;$me=$i;
			for ($e=0; $e<count($menuback);$e++){if ($this_level>$e) if (!empty($menuback[$e])){$backlink=$backlink." / <a href=".  $firstparturl. $menuback[$e].">".$menubacktitel[$e]. "</a>";$menuforlevel[$e+1]=$menubacktitel[$e];$urlforlevel[$e+1]=$menuback[$e];$titelforlevel[$e+1]=$menubackforlevel[$e];}}
			if (!empty($titelmenuarray[$i])) $backlink=$backlink." / ". $titelmenuarray[$i]; else $backlink=$backlink." / ". $menubacktitel[$e];$menuforlevel[$level]=$menuarray[$i];
		}				
		//Backlinks
		}

	//prev and next topic

		//prevtopic
		for ($k=$me-1;$k>=0;$k--) 
		{ if ($menulevel[$k]<$level) break;
		if ($menulevel[$k]==$level) {
		if (!empty($fileandpathnamearray[$k]))$linkurl= $fileandpathnamearray[$k] ;else $linkurl=$index. "/".encodeurl($menuarray[$k]);
		if (strlen($titelmenuarray[$k])>1)$topictitle=$titelmenuarray[$k]; else $topictitle=$menuarray[$k];
		$prev_topic="<a href=\"".$firstparturl. $linkurl."\" class=\"prev_topic\">".$topictitle. "</a>\n";break;}
		}

		//next
		for ($k=$me+1;$k<count($menuarray);$k++) 
		{ if ($menulevel[$k]<$level) break;
		if ($menulevel[$k]==$level) {
		if (!empty($fileandpathnamearray[$k]))$linkurl= $fileandpathnamearray[$k] ;else $linkurl=$index. "/".encodeurl($menuarray[$k]);
		if (strlen($titelmenuarray[$k])>1)$topictitle=$titelmenuarray[$k]; else $topictitle=$menuarray[$k];
		$next_topic="<a href=\"".$firstparturl. $linkurl."\" class=\"next_topic\">".$topictitle. "</a>\n";break;}
		}

	//...prev and next topic
	/*** ...read site-navigation, build variables:$backlink***/

if (empty($level))$level=0;

function loadcontent($file)
{global $firstparturl;
$Pfad= "daten/$file.dat";$datei = fopen($Pfad, "r");$savethetext=fread($datei, filesize($Pfad));fclose($datei);$arrayseite = explode ("---///___", $savethetext);$text2= str_replace("../image/", $firstparturl. "/image/",$arrayseite[2]);$text2= str_replace("//image/", "/image/",$text2);
return $text2;
}

function buildmenu($start_level, $end_level, $end_this, $limit = '0', $picture = '0', $ignoredisabled = '0')
{global $menuarray,$menulevel,$article,$level,$firstparturl,$index, $me,$titelmenuarray,$fileandpathnamearray,$templatedir,$smalldescriptionarray,$previewarray;$limitcount=$limit;
if ($start_level==1)$start_level=0;
if ($stop==0)$stop=count($menuarray);//if $stop is 0 the function would endless loop 

	if ($picture=="1") $mainmenu=$mainmenu."<table class=\"submenu\">";
	for ($i=0; $i<=count($menuarray);$i++)
		{	if ($ignoredisabled=='0'){ if (empty($ignoreleftspaces)) if (leftspaces($menuarray[$i])<1)$ignoreleftspaces="donotignore";}else $ignoreleftspaces="donotignore";
				if ($ignoreleftspaces=="donotignore")
						{
							if (file_exists($templatedir."cms-default.png")) $defaultimg=$firstparturl. $templatedir."cms-default.png";else {if (file_exists($templatedir."cms-default.jpg")) $defaultimg=$firstparturl. $templatedir."cms-default.jpg";else $defaultimg=$firstparturl."image/cms-default.png";}
							for ($e=$i-1; $e>=$stop;$e--) if ($menulevel[$e]<$menulevel[$i]) {$stop=$i;} //speichert in $e+1 das vorhergehende Menu
							$stop=count($menuarray);for ($f=$i+1; $f<=$stop;$f++){if ($menulevel[$f]<$menulevel[$i]) $stop=$i;}$stop=0; //speichert in $f-1 das Ende des Submenues ($f-1 ist bereits das andere Menü
							//echo  "p", $e+1, " e", $f-1, " ",$i, "x", $menulevel[$i], " - ",$menuarray[$i];
							if ($menulevel[$i]>$start_level and $menulevel[$i]<=$end_level) $enable=1; else $enable=0;
							if (empty($end_this) or ($end_this>=$menulevel[$i])) {if (($e < $me) and ($f-1 >$me)) $enable=1;} //enabled selected menues
							if ($start_level>1) if ($menulevel[$i]<$start_level) $enable=0; 
			
							if ($enable==1 and strlen(trim($menuarray[$i]))>0)					
								{$limit--;
								if ($limitcount==0 or $limit >= 0)
									{
									if($picture==1) {
										if (empty($previewarray[$i])) $preview=1; else $preview=$previewarray[$i];
										if(file_exists("image/". encodeurl($menuarray[$i])."-". $preview."-150.jpg")) $picture_load= "<img src=\"".$firstparturl."image/". encodeurl($menuarray[$i])."-" .$preview."-150.jpg\" width=\"150\" alt=\"".trim($menuarray[$i])."\"> ";
										else $picture_load="<img src=\"".$defaultimg."\"  width=\"150\" alt=\"".trim($menuarray[$i])."\">";

									}else $picture_load="";


										if ($picture==1) $mainmenu =  $mainmenu."<tr><td style=\"text-align:center\"><div style=\"max-height:150;overflow:hidden;float:left;\">";	
										$trimit=trim($menuarray[$i]);
										if (!empty($titelmenuarray[$i]))$displaytitle=$titelmenuarray[$i];else $displaytitle=$menuarray[$i];
										if (!empty($fileandpathnamearray[$i]))$linkurl= $fileandpathnamearray[$i] ;else $linkurl=$index. "/".encodeurl($menuarray[$i]);
										if ($trimit{0}!="'")
										{
								 		$mainmenu= "$mainmenu <div class=\"level_$menulevel[$i]"."_". $start_level.$end_level.$end_this."\"><a href=\"".$firstparturl. $linkurl."\" class=\"";
										if ($article==encodeurl($menuarray[$i])) $mainmenu= $mainmenu."mainmenu_active"; else $mainmenu= $mainmenu."mainmenu_link";
										$mainmenu= "$mainmenu \"";
										if ($picture==1) $mainmenu= $mainmenu.">".$picture_load. "</a></div></div></td>\n";else $mainmenu= $mainmenu.">".$picture_load.trim($displaytitle). "</a></div>\n";
										if ($picture==1) $mainmenu= $mainmenu ."<td style=\"padding-left:10px;\"><a href=\"".$firstparturl. $linkurl. "\">".trim($displaytitle). "</a><br />". $smalldescriptionarray[$i]."</td></tr>";
										}
									}				
								}	
						}
						
		}

if ($picture=="1")$mainmenu=$mainmenu."</table>";
return $mainmenu;
}
function buildmenuul($end_level='1', $submenu = '0', $collapse= '3', $limit = '0')
{global $article,$firstparturl,$index, $me,$currentmenu,$disabledarray,$menulevel, $start;
$menuarray=$GLOBALS["menuarray"];$titelmenuarray=$GLOBALS["titelmenuarray"];$fileandpathnamearray=$GLOBALS["fileandpathnamearray"];

if (!empty($submenu)) {$end_level=$end_level+1;$collapse=$collapse+1;}

		//if you use buildmenuul to build a submenu out of the whole menu: form a new menuarray, titelmenuarray, fileandpathnamearray, ...
		if (!empty($submenu))$startthemenu=0;else $startthemenu=1;

if ($end_level==0 and $start==1) $end_level=1; // to show initial menu on Pageload: Startpage

		for ($i=0; $i<count($menuarray);$i++)
			{ 
				if (!empty($submenu))
				{

					foreach($disabledarray as $key => $value) 
					{if ((trim($key)=="'$submenu" or trim($key)==trim($submenu)) and trim($value)==trim($menuarray[$i])) {$startthemenu=1;}
					if ($startthemenu>1 and trim($value)==trim($menuarray[$i]))$menuarray[$i]="0";//to stop if there begins another menu ...
					}

					$trimit=trim($menuarray[$i]); if (leftspaces($menuarray[$i])=="0") if ($startthemenu>1) break;
				}
	
				if ($collapse>0){
							//for end_level 0 collapse the selected menu same es buildmenu
							for ($e=$i-1; $e>=$stop;$e--) if ($menulevel[$e]<$menulevel[$i]) {$stop=$i;} //speichert in $e+1 das vorhergehende Menu
							$stop=count($menuarray);for ($f=$i+1; $f<=$stop;$f++){if ($menulevel[$f]<$menulevel[$i]) $stop=$i;}$stop=0; //speichert in $f-1 das Ende des Submenues ($f-1 ist bereits das andere Menü
							if ($menulevel[$i]<=$end_level) $enable=1; else $enable=0;
							if (($e < $me) and ($f-1 >$me)and $menulevel[$i]<=$collapse) $enable=1; //enabled selected menues
						}


				if ($startthemenu>=1)
				if (strlen(trim($menuarray[$i]))>0)
				if (($enable==1) or ($menulevel[$i]>$start_level and $menulevel[$i]<=$end_level))
				{$newmenuarray[$startthemenu-1]=$menuarray[$i];
				if (!empty($submenu)) $newmenuarray[$startthemenu-1]=substr($menuarray[$i],1);
				$newtitelmenuarray[$startthemenu-1]=$titelmenuarray[$i];
				$newfileandpathnamearray[$startthemenu-1]=$newfileandpathnamearray[$i];	
				$startthemenu++; if (!empty($limit))if ($startthemenu>$limit)break;}
			}
		$menuarray=$newmenuarray; 
		$titelmenuarray=$newtitelmenuarray;
		$fileandpathnamearray=$newfileandpathnamearray;
		
		//...if you use buildmenuul to build a submenu out of the whole menu: form a new menuarray, titelmenuarray, fileandpathnamearray
		

	for ($i=0; $i<count($menuarray);$i++)
		{	if (empty($ignoreleftspaces)) if (leftspaces($menuarray[$i])<1)$ignoreleftspaces="donotignore";	
				if ($ignoreleftspaces=="donotignore")
						{
						if ($article==encodeurl($menuarray[$i])) $mainmenu= "$mainmenu \n<li class=\"current\"> ";else $mainmenu= "$mainmenu \n<li class=\"link\"> ";							
						if (!empty($titelmenuarray[$i]))$displaytitle=$titelmenuarray[$i];else $displaytitle=$menuarray[$i];unset ($linkurl);
						if (!empty($fileandpathnamearray[$i]))$linkurl= $fileandpathnamearray[$i] ;else $linkurl=$index. "/".encodeurl($menuarray[$i]);
						if ($article==encodeurl($menuarray[$i]))
				 		$mainmenu= "$mainmenu <a href=\"".$firstparturl.  $linkurl."\" class=\"mainmenu_active\">".$picture_load.trim($displaytitle). "</a>";
						else 
						$mainmenu= "$mainmenu <a href=\"".$firstparturl.  $linkurl."\" class=\"mainmenu_link\">".$picture_load.trim($displaytitle). "</a>";			
						unset($nextmenu);
						for ($j=$i+1; $j<=count($menuarray);$j++) {$trimit=trim($menuarray[$j]);if ($trimit{0}!="'") {$nextmenu=$menuarray[$j];break;}}
						if (leftspaces($menuarray[$i])==leftspaces($nextmenu)) $mainmenu= "$mainmenu </li>\n";
						for ($k=0;$k<leftspaces($nextmenu)-leftspaces($menuarray[$i]);$k++) $mainmenu= "$mainmenu \n<ul class=\"level". leftspaces($nextmenu)."\">";					
						for ($k=0;$k<leftspaces($menuarray[$i])-leftspaces($nextmenu);$k++) $mainmenu= "$mainmenu \n</li>\n</ul>";
						}

		}

return $mainmenu;
}

function newest($maxentries, $start = '0', $images = '0')
{global $newsentryarray,$datumarray,$language,$fileandpathnamearray,$menuarray,$lang_txt_021,$titelmenuarray,$templatedir,$firstparturl,$smalldescriptionarray,$titelarray, $previewarray,$index;
//$layout: 12 ... 1; 2,. ...
$newest= $newest."\n<ul class=\"newest1\">";	
		if (file_exists($templatedir."cms-default.png")) $defaultimg=$firstparturl. $templatedir."cms-default.png";else {if (file_exists($templatedir."cms-default.jpg")) $defaultimg=$firstparturl. $templatedir."cms-default.jpg";else $defaultimg=$firstparturl."image/cms-default.png";}
			
					arsort($datumarray); 
					foreach($datumarray as $key => $value) 
					{
					if ($newsentryarray[$key]==1) 
						{
						if (!empty($menuarray[$key])) $nummer++;
						if ($nummer>$start)
							{
							//divs öffnen...
							if ($images==1 and !empty($titelmenuarray[$key])) 
							{
							$newest= $newest."\n<li class=\"newest1\">";
							}
							//...divs öffnen
							if (!empty($fileandpathnamearray[$key]))$linkurl= $fileandpathnamearray[$key] ;else $linkurl=$index. "/".encodeurl($menuarray[$key]);
							//Images:
							if ($images==1){
							if (!empty($titelmenuarray[$key])) {
								if (empty($previewarray[$key])) $preview=1; else $preview=$previewarray[$key];
								$newest= $newest."<div class=\"nimage\"><a href=\"".$firstparturl. $linkurl."\">";//Low-Level-Format-1-150.jpg
								if(file_exists("image/". encodeurl($menuarray[$key])."-". $preview."-150.jpg")) $newest= $newest."<img src=\"".$firstparturl."image/". encodeurl($menuarray[$key])."-". $preview."-150.jpg\"";else $newest=$newest."<img src=\"".$defaultimg."\"";			
								$newest= $newest." width=\"150\" alt=\"".trim($titelarray[$key])."\"> </a></div>\n";				
												}
									}					
							//... Images
							if ($images==1) 
							{	if (!empty($titelmenuarray[$key])) 
								{
									 if ($language=="de") $newest= $newest. "<span class=\"ndate\">".date("d.m.Y H:i",$datumarray[$key]). " </span>";else
									$newest= $newest. "<span class=\"ndate\">".date("m/d/Y H:i",$datumarray[$key]). " </span>";
								}
								if (!empty($smalldescriptionarray[$key])) $newest= $newest." <span class=\"ndesc\"><a href=\"".$firstparturl. $linkurl."\">". $smalldescriptionarray[$key]. "</a> </span>";
								$newest= $newest." ";
								//extend news show beginning topic look for <!-- pagebreak --> in the topic... 
								$Pfad= "daten/".trim(encodeurl($menuarray[$key])).".dat";$datei = fopen($Pfad, "r");$savethetext=fread($datei, filesize($Pfad));fclose($datei);
								$arrayseite = explode ("---///___", $savethetext);
								$arrayseite[2]= str_replace("../image/", $firstparturl. "image/",$arrayseite[2]);
								$arrayseite[2]= str_replace("../download/", $firstparturl. "download/",$arrayseite[2]);	
								$arrayseite[2]= str_replace("//image/", "/image/",$arrayseite[2]);
								if (instr("<!-- pagebreak -->", $arrayseite[2])) {$ttxxtnews=explode ("<!-- pagebreak -->", $arrayseite[2]); $newest=$newest. $ttxxtnews[0];}
								//...extend news show beginning topic		

							}else $newest= $newest. "";
							if (instr("<!-- pagebreak -->", $arrayseite[2]) and $images==1)
							$newest= $newest."<span class=\"nlink\"><a href=\"".$firstparturl. $linkurl."\">".$lang_txt_021.": $titelarray[$key] </a> </span>";else
							$newest= $newest."<span class=\"nlink\"><a href=\"".$firstparturl. $linkurl."\">".$titelarray[$key]. "</a> </span>";
							

							//divs wieder schließen...
							if ($images==1 and !empty($titelmenuarray[$key])) 
							{							
							$newest= $newest."</li>\n";			
							if ($nummer>=$maxentries) {$newest=$newest."</ul>\n";return $newest;}
							}
							if ($images!=1)if ($nummer>=($maxentries+$start)) {$newest=$newest."</ul>\n";return $newest;}
							//...divs wieder schließen
							}

						}
					}

$newest= $newest."</ul>";return $newest;
}
?>
