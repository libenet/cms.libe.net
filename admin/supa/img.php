<?php @include("../passwort.php"); if ($_COOKIE["loginadmin"] == md5($Passwort."-".$ip)){ ?>

<?php 
if( isset( $_GET['tag'] ) )$tag=urlencode($_GET['tag']);
if( isset( $_GET['load'] ) )$load=urlencode($_GET['load']);else $load=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html14/loose.dtd">
<html>
<?php if ($load=="ok"){?>
<head>
  <title>SUPA - the Screenshot Upload Applet</title>
  <script type="text/javascript" src="Supa.js"></script>
<script language="JavaScript" type="text/javascript" src="../../plugins/jquery/jquery-1.7.2.min.js"></script>
<style type="text/css">
body
{
 font-family:Arial;
  font-style: normal;
  font-size: 12px;
  color: #222;
}</style>
</head>
<body>

  <form name="form" action="#none">
<table><tr><td valign="top">
    <input type="button" value="Img from Clipboard" onclick="return pasteandload();">
</td><td>
    <div style="border: 1px solid">
      <applet id="SupaApplet"
              archive="../../plugins/supa/Supa.jar"
              code="de.christophlinder.supa.SupaApplet" 
              width="100" 
              height="20">
        <!--param name="clickforpaste" value="true"-->
        <param name="imagecodec" value="png">
        <param name="encoding" value="base64">
        <param name="previewscaler" value="fit to canvas">
        <!--param name="trace" value="true"-->
        Applets disabled :(
      </applet>
    </div>
</td></tr></table>
    <!-- the value of this input element is POSTed, too -->


<input name="otherparam" value="<?php echo $tag;?>" type="hidden">

  </form>
  <script type="text/javascript">
  <!--
    function pasteandload() {
      // Call the paste() method of the applet.
      // This will paste the image from the clipboard into the applet :)
      try {
        var applet = document.getElementById( "SupaApplet" );
        var err = applet.pasteFromClipboard(); 
        switch( err ) {
          case 0:
            /* no error */
            break;
          case 1: 
            alert( "Unknown Error" );
            break;
          case 2:
            alert( "Empty clipboard" );
            break;
          case 3:
            break;
          case 4:
            alert( "Clipboard in use by another application. Please try again in a few seconds." );
            break;
          default:
            alert( "Unknown error code: "+err );
        }
      } catch( e ) {
        alert(e);
        throw e;
      }

      // Get the base64 encoded data from the applet and POST it via an AJAX 
      // request. See the included Supa.js for details
      var s = new supa();
      var applet = document.getElementById( "SupaApplet" );

      try { 
        var result = s.ajax_post( 
          applet,       // applet reference
          "../../admin/supa/upload.php", // call this url
          "screenshot", // this is the name of the POSTed file-element
          "screenshot.png", // this is the filename of tthe POSTed file
          { form: document.forms["form"] } // elements of this form will get POSTed, too
        );
        if( result.match( "^OK" ) ) {
          var url = result.substr( 3 );
          //window.open( url, "_blank" );
        } else {
          alert( result );
        }

      } catch( ex ) {
        if( ex == "no_data_found" ) {
          alert( "Please paste an image first" );
        } else {
          alert( ex );
        }
      }
	parent.reloadimgs ();
	window.location.reload()
	copy(test)
	
      return false; // prevent changing the page
    }

  //-->


function copy(inElement) {
  if (inElement.createTextRange) {
    var range = inElement.createTextRange();
    if (range && BodyLoaded==1)
      range.execCommand('Copy');
  } else {
    var flashcopier = 'flashcopier';
    if(!document.getElementById(flashcopier)) {
      var divholder = document.createElement('div');
      divholder.id = flashcopier;
      document.body.appendChild(divholder);
    }
    document.getElementById(flashcopier).innerHTML = '';
    var divinfo = '<embed src="_clipboard.swf" FlashVars="clipboard='+encodeURIComponent(inElement.value)+'" width="0" height="0" type="application/x-shockwave-flash"></embed>';
    document.getElementById(flashcopier).innerHTML = divinfo;
  }
}
  </script>
<?php }else echo "<head>
  <title>SUPA - the Screenshot Upload Applet</title>
<style type=\"text/css\">
body
{
 font-family:Arial;
  font-style: normal;
  font-size: 12px;
  color: #222;
}</style>
</head>
<body><a href=\"img.php?load=ok&tag=$tag\" title=\"upload Pictures directly from Clipboard\"style=\"text-decoration: none;color:#222;\">load SUPA: Clipboard upload</a>"; ?>
</body>
</html>
<?php }?>
