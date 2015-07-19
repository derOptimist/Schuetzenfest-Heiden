var debug = 0;

//Funktion um die Gallerie zu pausieren
function gallerie_pause() {
   $('#s1').cycle('toggle');
   current_src = document.getElementById("pausebutton").src.substr(document.getElementById("pausebutton").src.lastIndexOf("/") + 1);
   if(current_src == "pause.png")
   {
      document.getElementById("pausebutton").src = "themes/images/play.png";
   }
   else
   {
      document.getElementById("pausebutton").src = "themes/images/pause.png";
   }
}
   
//Start Push

var pushNotification;
function onDeviceReady() {
try
{

    pushNotification = window.plugins.pushNotification;
    if (device.platform == 'android' || device.platform == 'Android') {
        if(debug==1)
        {
           $("#app-status-ul").append('<li>registering android</li>');
        }
        pushNotification.register(successHandler, errorHandler, {"senderID":"855034647454","ecb":"onNotificationGCM"});	// required!
    } else {
        if(debug==1)
        {
           $("#app-status-ul").append('<li>registering iOS</li>');
        }
        pushNotification.register(tokenHandler, errorHandler, {"badge":"true","sound":"true","alert":"true","ecb":"onNotificationAPN"});	// required!
    }
}
catch(err)
{
    txt="There was an error on this page.\n\n";
    txt+="Error description: " + err.message + "\n\n";
    alert(txt);
}
}

function onDeviceResume() {
window.location.reload();
}

// handle APNS notifications for iOS
function onNotificationAPN(e) {
if (e.alert) {
     if(debug==1)
     {
        $("#app-status-ul").append('<li>push-notification: ' + e.alert + '</li>');
     }
     navigator.notification.alert(e.alert);
}
    
if (e.sound) {
    var snd = new Media(e.sound);
    snd.play();
}

if (e.badge) {
    pushNotification.setApplicationIconBadgeNumber(successHandler, e.badge);
}
}
            
// handle GCM notifications for Android
function onNotificationGCM(e) {
if(debug==1)
{
   $("#app-status-ul").append('<li>EVENT -> RECEIVED:' + e.event + '</li>');
}
switch( e.event )
{
    case 'registered':
    if ( e.regid.length > 0 )
    {
        if(debug==1)
        {
           $("#app-status-ul").append('<li>REGISTERED -> REGID:' + e.regid + "</li>");
        }
        // Your GCM push server needs to know the regID before it can push to this device
        // here is where you might want to send it the regID for later use.
        console.log("regID = " + e.regid);
        reg_id_submit(e.regid);
        //document.getElementById("console").value = e.regid;
    }
    break;

    case 'message':
    // if this flag is set, this notification happened while we were in the foreground.
    // you might want to play a sound to get the user's attention, throw up a dialog, etc.
    if (e.foreground)
    {
        $("#app-status-ul").append('<li>--' + e.payload.message + '</li>');

        // if the notification contains a soundname, play it.
        var my_media = new Media("/android_asset/www/"+e.soundname);
        my_media.play();
    }
    break;

    case 'error':
    $("#app-status-ul").append('<li>ERROR -> MSG:' + e.msg + '</li>');
    break;
                    
    default:
    $("#app-status-ul").append('<li>EVENT -> Unknown, an event was received and we do not know what it is</li>');
    break;
}
}
            
function tokenHandler (result) {
    $("#app-status-ul").append('<li>token: '+ result +'</li>');
    // Your iOS push server needs to know the token before it can push to this device
    // here is where you might want to send it the token for later use.
}

function successHandler (result) {
    if(debug==1)
    {
       $("#app-status-ul").append('<li>success:'+ result +'</li>');
    }
}
            
function errorHandler (error) {
    $("#app-status-ul").append('<li>error:'+ error +'</li>');
}

// Funktion um Chatnachricht zu versenden
function reg_id_submit(reg_id_value){

    console.log(url_push_save_reg_id);
    console.log(reg_id_value);

    $.ajax({
        type: 'GET',
        url: url_push_save_reg_id,
        contentType: "application/json",
        dataType: 'jsonp',
        data: { reg_id : reg_id_value, secretkey : '0'},
        crossDomain: true,
        beforeSend: function(){
        },
        success: function(res) {
             console.log(url_push_save_reg_id);
             console.log(reg_id_value);
             return false;
        },
        error: function(e) {
            console.log("Fehler");
        },
        complete: function(data) {
        }
    });
};
//End Push



//Start Upload
function win(r) {
    console.log("Code = " + r.responseCode);
    console.log("Response = " + r.response);
    console.log("Sent = " + r.bytesSent);
}

function fail(error) {
    alert("An error has occurred: Code = " + error.code);
    console.log("upload error source " + error.source);
    console.log("upload error target " + error.target);
}

function uploadfile{
$( ".progressbar" ).progressbar( "enable" );
var uri = encodeURI("http://schwitte.de/heiden/upload/process.php");

var options = new FileUploadOptions();
options.fileKey="file";
options.fileName=document.getElementById("img_file");
options.mimeType="text/plain";

var headers={'headerParam':'headerValue'};

options.headers = headers;

var ft = new FileTransfer();
ft.onprogress = function(progressEvent) {
    if (progressEvent.lengthComputable) {
      loadingStatus.setPercentage(progressEvent.loaded / progressEvent.total);
    } else {
      loadingStatus.increment();
    }
};
ft.upload(fileURL, uri, win, fail, options);
}

//End Upload
