<?php
ob_start( 'ob_gzhandler' );
?>
<!DOCTYPE html>
<html>
<head>
<title>Sch&uuml;tzenfest Heiden</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width; initial-scale=1">
<meta name="date" content="2013-07-27T08:49:37+01:00">
<meta http-equiv="expires" content="Sat, 17 Aug 2013 00:00:00 GMT">
         <link rel="stylesheet" href="themes/test.min.css" />
         <link rel="stylesheet" href="themes/jquery.mobile.structure-1.3.1.min.css" /> 
         <script src="js/libs/jquery.min.js"></script> 
           <script src="js/libs/jquery.mobile-1.3.1.min.js"></script> 
</head>

 <?php 
    include( "Mydb.php" );
    if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
    }
 
//Laden des Countdown

$sql = "SELECT DATE_FORMAT(datum,'%b %d, %Y %H:%i:%S') as datum_technisch, DATE_FORMAT( datum,'am %W, den %d. %M %Y %H:%i') as datum_anzeige, mytext  
FROM`sch_termine` 
WHERE datum = ( 
SELECT min( datum ) 
FROM`sch_termine` 
WHERE datum > now()) ";

$sth = $db->prepare($sql);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_OBJ);
$datum_technisch = $result->datum_technisch;
$datum_anzeige = $result->datum_anzeige;

$datum_anzeige = str_replace("Monday", "Montag", $datum_anzeige);
$datum_anzeige = str_replace("Tuesday", "Dienst", $datum_anzeige);
$datum_anzeige = str_replace("Wednesday", "Mittwoch", $datum_anzeige);
$datum_anzeige = str_replace("Thursday", "Donnerstag", $datum_anzeige);
$datum_anzeige = str_replace("Friday", "Freitag", $datum_anzeige);
$datum_anzeige = str_replace("Saturday", "Samstag", $datum_anzeige);
$datum_anzeige = str_replace("Sunday", "Sonntag", $datum_anzeige);

$text = $result->mytext;
 	
echo '<body onload="start(\''.$datum_technisch.'\');">';
 ?> 

<div id="loading"  style="visibility=hidden">
<img src="images/ajax-loader.gif" alt="[image]" style="max-width: 100%;" />
</div>
<script type="text/javascript">
	document.getElementById('loading').style.visibility = 'visible';
</script>

 
 
<!-- Start of third page -->
<div data-role="page" id="directions_map" data-dom-cache="true"  data-ajax-dom-caching="true">

    <div data-role="header">
      <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
      <script type="text/javascript" src="js/libs/jquery-migrate-1.2.1.min.js"></script>
      <script type="text/javascript" src="js/libs/demo.js"></script>
      <script type="text/javascript" src="ui/jquery.ui.map.js"></script>
      <script type="text/javascript" src="ui/jquery.ui.map.services.js"></script>
      <script type="text/javascript" src="ui/jquery.ui.map.extensions.js"></script>
      <script type="text/javascript" >
      var mobileDemo = { 'center': '51.823349,6.935596', 'zoom': 14 };

////////////////////////////////////////////////////////////

$('#basic_map').live('pageinit', function() {
    demo.add('basic_map', function() {
        $('#map_canvas').gmap({'center': mobileDemo.center, 'zoom': mobileDemo.zoom, 'disableDefaultUI':true, 'callback': function() {
			var self = this;
			self.addMarker({'position': this.get('map').getCenter() }).click(function() {
			self.openInfoWindow({ 'content': 'Hello World!' }, this);
			});
        }}); 
    }).load('basic_map');
});

$('#basic_map').live('pageshow', function() {
    demo.add('basic_map', function() { $('#map_canvas').gmap('refresh'); }).load('basic_map');
});

////////////////////////////////////////////////////////////

$('#directions_map').live('pageinit', function() {
    demo.add('directions_map', function() {
        $('#map_canvas_1').gmap({'center': mobileDemo.center, 'zoom': mobileDemo.zoom, 'disableDefaultUI':true, 'callback': function() {
            var self = this;
            self.set('getCurrentPosition', function() {
            self.refresh();
            self.getCurrentPosition( function(position, status) {
                if ( status === 'OK' ) {
                    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
                    self.get('map').panTo(latlng);
                    self.search({ 'location': latlng }, function(results, status) {
                        if ( status === 'OK' ) {
                            $('#from').val(results[0].formatted_address);
                        }
                    });
                } else {
                    alert('Unable to get current position');
                }
            });
        });
        $('#submit').click(function() {
            self.displayDirections({ 'origin': $('#from').val(), 'destination': $('#to').val(), 'travelMode': google.maps.DirectionsTravelMode.DRIVING }, { 'panel': document.getElementById('directions')}, function(response, status) {
                ( status === 'OK' ) ? $('#results').show() : $('#results').hide();
            });
            return false;
        });
    }});
}).load('directions_map');
});
$('#directions_map').live('pageshow', function() {
    demo.add('directions_map', $('#map_canvas_1').gmap('get', 'getCurrentPosition')).load('directions_map');
});
            ////////////////////////////////////////////////////////////
$('#gps_map').live('pageinit', function() {
    demo.add('gps_map', function() {
        $('#map_canvas_2').gmap({'center': mobileDemo.center, 'zoom': mobileDemo.zoom, 'disableDefaultUI':true, 'callback': function(map) {
            var self = this;
            self.watchPosition(function(position, status) {
                if ( status === 'OK' ) {
                    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    if ( !self.get('markers').client ) {
                        self.addMarker({ 'id': 'client', 'position': latlng, 'bounds': true });
                    } else {
                        self.get('markers').client.setPosition(latlng);
                        map.panTo(latlng);
                    }
                }
            });
        }});
    }).load('gps_map');
});
            
$('#gps_map').live('pageshow', function() {
    demo.add('gps_map', function() { $('#map_canvas_2').gmap('refresh'); }).load('gps_map');
});

$('#gps_map').live("pagehide", function() {
    demo.add('gps_map', function() { $('#map_canvas_2').gmap('clearWatch'); }).load('gps_map');
});

////////////////////////////////////////////////////////////

$('#places').live('pageinit', function() {
    demo.add('places_1', function() {
                    $('#map_canvas_3').gmap({'center': mobileDemo.center, 'zoom': mobileDemo.zoom, 'disableDefaultUI':true, 'callback': function() {
                        var self = this;
                        var control = self.get('control', function() {
                            $(self.el).append('<div id="control"><div><input id="places-search" class="ui-bar-d ui-input-text ui-body-null ui-corner-all ui-shadow-inset ui-body-d ui-autocomplete-input" type="text"/></div></div>');
                            self.autocomplete($('#places-search')[0], function(ui) {
                                self.clear('markers');
                                self.set('bounds', null);
                                self.placesSearch({ 'location': ui.item.position, 'radius': '5000' }, function(results, status) {
                                    if ( status === 'OK' ) {
                                        $.each(results, function(i, item) {
                                            self.addMarker({ 'id': item.id, 'position': item.geometry.location, 'bounds':true }).click(function() {
                                                self.openInfoWindow({'content': '<h4>'+item.name+'</h4>'}, this);
                                            });
                                        });
                                    }
                                });
                            });
                            return $('#control')[0];
                        });
                        self.addControl(new control(), 1);
                    }});
                }).load('places_1');
            });
            
            $('#places').live('pageshow', function() {
                demo.add('places_2', function() { $('#map_canvas_3').gmap('refresh'); }).load('places_2');
            });
 
  // <!-- End of Maps -->
      
      </script>
        <h1>Anfahrt</h1>
    </div><!-- /header -->

    <div data-role="content">
            <div data-role="content">    
                <div class="ui-bar-c ui-corner-all ui-shadow" style="padding:1em;">
                    <div id="map_canvas_1" style="height:300px;max-width: 100%;"></div>
                    <p>
                        <label for="from">From</label>
                        <input id="from" class="ui-bar-c" type="text" value="Bahnhofstr. 2, Heiden, Germany" />
                    </p>
                    <p>
                        <label for="to">To</label>
                        <input id="to" class="ui-bar-c" type="text" value="Am Sportzentrum 3, Heiden, Germany" />
                    </p>
                    <a id="submit" href="#" data-role="button" data-icon="search">F&uuml;hre mich</a>
                </div>
                <div id="results" class="ui-listview ui-listview-inset ui-corner-all ui-shadow" style="display:none;">
                    <div class="ui-li ui-li-divider ui-btn ui-bar-b ui-corner-top ui-btn-up-undefined">Results</div>
                    <div id="directions"></div>
                    <div class="ui-li ui-li-divider ui-btn ui-bar-b ui-corner-bottom ui-btn-up-undefined"></div>
                </div>
            </div>
    </div><!-- /content -->

    <div data-role="footer" style="overflow:hidden;" data-position="fixed">
        <h4 style="text-align:center;">Sch&uuml;tzenfest Heiden</h4>
        <div data-role="navbar">
            <ul>
                <li><a href="index.php" id="index" target="_self">Aktuelles</a></li>
                <li><a href="index.php#Festprogramm" id="Festprogramm" target="_self">Festprogramm</a></li>
                <li><a href="index.php#Galerie" id="Galerie" target="_self">Festprogramm</a></li>
                <li><a href="maps.php" id="maps" target="_self">Maps</a></li>
            </ul>
        </div><!-- /navbar -->
    </div><!-- /footer -->
</div><!-- /page -->







<script type="text/javascript">
	document.getElementById('loading').style.visibility = 'hidden';
</script>

</body>
<?php ob_end_flush(); ?>