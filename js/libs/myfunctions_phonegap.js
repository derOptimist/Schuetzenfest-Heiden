  // var url_chatbox_submit = 'http://www.schwitte.de/heiden/chat_submit.php';
   // var url_chatbox_refresh = 'http://www.schwitte.de/heiden/chat_refresh.php';
   // var url_load_infos = 'http://www.schwitte.de/heiden/ajax.php';
   // var url_load_date_checksums = 'http://www.schwitte.de/heiden/ajax_date_checksums.php';
   // var url_load_date_saturday = 'http://www.schwitte.de/heiden/ajax_date_saturday.php';
   // var url_load_date_sunday = 'http://www.schwitte.de/heiden/ajax_date_sunday.php';
   // var url_load_date_monday = 'http://www.schwitte.de/heiden/ajax_date_monday.php';
   // var url_push_save_reg_id = 'http://schwitte.de/heiden/push/save_id.php';

   
   
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

downloadFile();
    // $("#app-status-ul").append('<li>deviceready event received</li>');
                    
    // document.addEventListener("backbutton", function(e)
    // {
        // // $("#app-status-ul").append('<li>backbutton event received</li>');
    
        // // if( $("#home").length > 0)
        // // {
            // // // call this to get a new token each time. don't call it to reuse existing token.
            // // //pushNotification.unregister(successHandler, errorHandler);
            // // e.preventDefault();
            // // navigator.app.exitApp();
        // // }
        // // else
        // // {
            // // navigator.app.backHistory();
        // // }
        
        // navigator.app.backHistory();
    // }, false);
    
    try
    {
        pushNotification = window.plugins.pushNotification;
        if (device.platform == 'android' || device.platform == 'Android') {
            // $("#app-status-ul").append('<li>registering android</li>');
            pushNotification.register(successHandler, errorHandler, {"senderID":"855034647454","ecb":"onNotificationGCM"});	// required!
            
            // //Mit Backbutton die App beenden können
            // navigator.Backbutton.goHome(function() {
              // console.log('success')
            // }, function() {
              // console.log('fail')
            // });
            
        } else {
            // $("#app-status-ul").append('<li>registering iOS</li>');
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
         // $("#app-status-ul").append('<li>push-notification: ' + e.alert + '</li>');
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
    // $("#app-status-ul").append('<li>EVENT -> RECEIVED:' + e.event + '</li>');
    switch( e.event )
    {
        case 'registered':
        if ( e.regid.length > 0 )
        {
            // $("#app-status-ul").append('<li>REGISTERED -> REGID:' + e.regid + "</li>");
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
        // else
        // {	    // otherwise we were launched because the user touched a notification in the notification tray.
            // if (e.coldstart)
            // $("#app-status-ul").append('<li>--COLDSTART NOTIFICATION--' + '</li>');
            // else
            // $("#app-status-ul").append('<li>--BACKGROUND NOTIFICATION--' + '</li>');
        // }

        // $("#app-status-ul").append('<li>MESSAGE -> MSG: ' + e.payload.message + '</li>');
        // $("#app-status-ul").append('<li>MESSAGE -> MSGCNT: ' + e.payload.msgcnt + '</li>');
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
    // $("#app-status-ul").append('<li>success:'+ result +'</li>');
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
            //$('.loading').show();
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
            //$('.loading').hide();
        }
    });
         
      

    

};



function downloadFile(){
alert("asdf");



var b = new FileManager();
 b.download_file('http://schwitte.de/heiden/js/libs/test.js','assets/www/js/libs/','test.js',alert('downloaded sucess'));

 
$.getScript("assets/www/js/libs/test.js");
alert("asdf1");

    }


document.addEventListener('deviceready', onDeviceReady, false);
document.addEventListener("resume", onDeviceResume, false);
//End Push