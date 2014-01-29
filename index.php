<?php
ob_start( 'ob_gzhandler' );
?>
<!DOCTYPE html>
<html manifest="cache.manifest">
<head>
<title>Sch&uuml;tzenfest Heiden</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width; initial-scale=1">
<meta name="date" content="2013-07-27T08:49:37+01:00">
<meta http-equiv="expires" content="Sat, 17 Aug 2013 00:00:00 GMT">
<link rel="stylesheet" href="themes/add2home.css">
<link rel="apple-touch-icon" href="images/background.png"/>
<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png"/>
<link rel="shortcut icon" href="images/background.png" />
<script src="js/libs/jquery.min.js"></script> 
<script src="js/libs/jquery.mobile-1.3.1.min.js"></script> 
<link rel="stylesheet" href="themes/test.min.css" />
<link rel="stylesheet" href="themes/jquery.mobile.structure-1.3.1.min.css" /> 
<!-- Start of Countdown -->
<script type="text/javascript" src="js/libs/countdown.js">
</script>
<!-- End of Countdown -->
<!-- Start of Homescreenbutton -->
<script type="application/javascript" src="js/libs/add2home.js" charset="utf-8"></script>
<!-- End of Homescreenbutton --> 
</head>

<div id="loading"  style="visibility=hidden">
<img src="themes/images/ajax-loader.gif" alt="[image]" style="max-width: 100%;" />
</div>
<script type="text/javascript">
         $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: "function=start",
                success: function(data){
                    var json = $.parseJSON(data);
                    start(json.datum_technisch);
                    $("#output").html('<span style="color: #ff0000; font-weight: bold;">'+json.datum_anzeige+"</span><br/>"+json.mytext+'<br/>');
                    $("#news").html(json.news).trigger("create");
                    $("#pictures").html(json.pictures).trigger("create");
                }
            });
         });
         document.getElementById('loading').style.visibility = 'visible';
</script>
<!-- Start of first page -->
<div data-role="page" id="Aktuelles" data-dom-cache="true"  data-ajax-dom-caching="true" >

    <div data-role="header">
        <h1>Aktuelles</h1>
    </div><!-- /header -->
    <div data-role="content">
        <div data-role="collapsible-set" data-theme="c" data-content-theme="d" data-expanded-icon="arrow-d" data-collapsed-icon="arrow-r">
            <p>
               <b>N&auml;chster Termin:</b>
            </p>
            <form name="form1" action="">
                <input type="hidden" name="time2" size="0" value="" /><input type="text" name="time" size="28" value=" " />
                <div id="output"></div>
            </form>
            <b>Neuigkeiten:</b>
           <div id="news" data-role="collapsible-set" data-theme="c" data-content-theme="d" data-expanded-icon="arrow-d" data-collapsed-icon="arrow-r">

           </div>
        </div>
    </div><!-- /content -->

    <div data-role="footer" style="overflow:hidden;" data-position="fixed">
        <h4 style="text-align:center;">Sch&uuml;tzenfest Heiden</h4>
        <div data-role="navbar">
            <ul>
                <li><a href="#Aktuelles">Aktuelles</a></li>
                <li><a href="#Festprogramm">Festprogramm</a></li>
                <li><a href="#Galerie">Galerie</a></li>
                <!-- <li><a href="maps.php" id="maps" target="_self">Maps</a></li> -->
            </ul>
        </div><!-- /navbar -->
    </div><!-- /footer -->
</div><!-- /page -->



<!-- Start of second page -->
<div data-role="page" id="Festprogramm" data-dom-cache="true"  data-ajax-dom-caching="true">

    <div data-role="header">
        <h1>Festprogramm</h1>
    </div><!-- /header -->

    <div data-role="content">
        <div data-role="collapsible-set" data-theme="c" data-content-theme="d" data-expanded-icon="arrow-d" data-collapsed-icon="arrow-r">
            <div data-role="collapsible">
                <h3>Kaiserschie&szlig;en Samstag</h3>
                <img src="images/Flyer_1a.jpg" alt="[image]" style="max-width: 100%;" /><br />
            </div>
            <div data-role="collapsible">
                <h3>Kaiserschie&szlig;en Sonntag</h3>
                <img src="images/Flyer_1b.jpg" alt="[image]" style="max-width: 100%;" /><br />
            </div>
            <div data-role="collapsible">
                <h3>Sch&uuml;tzenfest Samstag</h3>
                <img src="images/Flyer_2a.jpg" alt="[image]" style="max-width: 100%;" /><br />
            </div>
            <div data-role="collapsible">
                <h3>Sch&uuml;tzenfest Sonntag</h3>
                <img src="images/Flyer_2b.jpg" alt="[image]" style="max-width: 100%;" /><br />
            </div>
            <div data-role="collapsible">
                <h3>Sch&uuml;tzenfest Montag</h3>
                <img src="images/Flyer_2c.jpg" alt="[image]" style="max-width: 100%;" /><br />
            </div>
        </div>
    </div><!-- /content -->

    <div data-role="footer" style="overflow:hidden;" data-position="fixed">
        <h4 style="text-align:center;">Sch&uuml;tzenfest Heiden</h4>
        <div data-role="navbar">
            <ul>
                <li><a href="#Aktuelles">Aktuelles</a></li>
                <li><a href="#Festprogramm">Festprogramm</a></li>
                <li><a href="#Galerie">Galerie</a></li>
                <!-- <li><a href="maps.php" id="maps" target="_self">Maps</a></li> -->
            </ul>
        </div><!-- /navbar -->
    </div><!-- /footer -->
</div><!-- /page -->




<!-- Start of third page -->
<div data-role="page" id="Galerie" data-dom-cache="true"  data-ajax-dom-caching="true">
    <div data-role="header">
       
         <h1>Galerie</h1>
    </div><!-- /header -->
    <div data-role="content">
        <div data-role="collapsible-set" data-theme="c" data-content-theme="d" data-expanded-icon="arrow-d" data-collapsed-icon="arrow-r">
            <div class="slideshow">
               <div id="pictures"></div>
            </div>
        </div>
    </div><!-- /content -->

    <div data-role="footer" style="overflow:hidden;" data-position="fixed">
        <h4 style="text-align:center;">Sch&uuml;tzenfest Heiden</h4>
        <div data-role="navbar">
            <ul>
                <li><a href="#Aktuelles">Aktuelles</a></li>
                <li><a href="#Festprogramm">Festprogramm</a></li>
                <li><a href="#Galerie">Galerie</a></li>
                <!-- <li><a href="maps.php" id="maps" target="_self">Maps</a></li> -->
            </ul>
        </div><!-- /navbar -->
    </div><!-- /footer -->
</div><!-- /page -->




<script type="text/javascript">
	document.getElementById('loading').style.visibility = 'hidden';
</script>

</body>