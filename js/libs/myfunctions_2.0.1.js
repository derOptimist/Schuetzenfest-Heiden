var url_chatbox_submit = 'http://www.schwitte.de/heiden/chat_submit_V2.php';
var url_chatbox_refresh = 'http://www.schwitte.de/heiden/chat_refresh.php';
var url_load_infos = 'http://www.schwitte.de/heiden/ajax_test.php';
var url_load_date_checksums = 'http://www.schwitte.de/heiden/ajax_date_checksums.php';
var url_load_date_saturday = 'http://www.schwitte.de/heiden/ajax_date_saturday.php';
var url_load_date_sunday = 'http://www.schwitte.de/heiden/ajax_date_sunday.php';
var url_load_date_monday = 'http://www.schwitte.de/heiden/ajax_date_monday.php';
var url_push_save_reg_id = 'http://schwitte.de/heiden/push/save_id.php';
var chat_submit_time_old = '500000';
var chat_submit_time_new = '';
var chat_submit_diff = 10; //Differenz in Sekunden die zwischen 2 Posts liegen muss
var debug = 0;
var chat_aktiv = 0;

$(document).ready(function(){
$.mobile.defaultPageTransition = "none"
$.mobile.defaultDialogTransition = 'none';
$.mobile.useFastClick = true; 
$.mobile.touchOverflowEnabled = true;
alert("ready");
if (window.localStorage.getItem("chat_aktiv") == 0)
{
   var neuerLink = document.createElement("label");
   neuerLink.innerHTML = "Ihre Mailadresse wurde noch nicht aktiviert. F&uuml;r die Aktivierung geben Sie einfach in dem Feld 'Mailadresse' Ihre Mailadresse an und senden irgendeinen Text ab (Text wird nicht gespeichert). Dann wird Ihnen eine Aktvierungsmail mit einem Link an diese Adresse geschickt.";
   neuerLink.style.color = "#FF0000";
   document.getElementById("myform").insertBefore(neuerLink, null);
}

if(debug==1)
{
   $("#app-status-ul").append('<li>'+new Date().getTime()+' - document ready</li>');
}
// Zeige Ladebalken
$('.loading').show();

// Hole allgemeine Daten
$.ajax({
   type: 'GET',
   url: url_load_infos,
   contentType: "application/json",
   dataType: 'jsonp',
   data: {},
   crossDomain: true,
   beforeSend: function(){
      $.mobile.loading('show');
   },
   success: function(res) {
      //Hole technisches Datum für Counter
      start(res.datum_technisch);
      console.log("Counter: "+res.datum_technisch);
      //Hole Text zum Counter
      $("#output").html(res.mytext+'<br/>'+'<span style="color: #ff0000; font-weight: bold;">'+res.datum_anzeige+"</span><br/>").trigger('create');  
      console.log("Text zu Counter: "+res.datum_anzeige);
      //Hole aktuelle news
      $("#news").html(res.news).trigger('create');
      console.log("News: "+res.news);
      //Hole Chatbox                    
      document.getElementById("chat_content").value = res.chat_content;
      //console.log("chat_content: "+res.chat_content);
      //Setze gemerkten Namen der Chatbox
      document.getElementById("chat_user").value = window.localStorage.getItem("chat_user");
      console.log("chat_user: "+window.localStorage.getItem("chat_user"));
      
      $("#pictures").html(res.pictures).trigger('create');
   },
   error: function(e) {
      console.log(e.message);
   },
   complete: function(data) {
      //Ladebalken entfernen
      $.mobile.loading('hide'); 
   }
});

// Hole Schuetzenfesttermine
$.ajax({
   type: 'GET',
   url: url_load_date_checksums,
   contentType: "application/json",
   dataType: 'jsonp',
   data: {},
   crossDomain: true,
   beforeSend: function(){
      $.mobile.loading('show');
   },
   success: function(res) {
      var ldate_saturday_checksum = window.localStorage.getItem("date_saturday_checksum");
      var ldate_sunday_checksum = window.localStorage.getItem("date_sunday_checksum");
      var ldate_monday_checksum = window.localStorage.getItem("date_monday_checksum");
      // ldate_saturday_checksum = 0;
      // ldate_sunday_checksum = 0;
      // ldate_monday_checksum = 0;
      console.log("ldate_saturday_checksum: "+ldate_saturday_checksum+" - res.date_saturday_checksum: "+res.date_saturday_checksum)
      console.log("ldate_sunday_checksum: "+ldate_sunday_checksum+" - res.date_sunday_checksum: "+res.date_sunday_checksum)
      console.log("ldate_monday_checksum: "+ldate_monday_checksum+" - res.date_monday_checksum: "+res.date_monday_checksum)
      if(ldate_saturday_checksum != res.date_saturday_checksum)
      {
         load_date_saturday();
         set_gray("table_termine_samstag");
         console.log("Loaded data via ajax for date saturday");
         window.localStorage.setItem("date_saturday_checksum", res.date_saturday_checksum);
         // document.getElementById("console").value = "Loaded data via ajax";
      }
      else
      {
         var date_saturday = window.localStorage.getItem("date_saturday");
         $("#table_termine_samstag").html(date_saturday).trigger('create');
         console.log("Loaded data via cache for date saturday");
         // document.getElementById("console").value = "Loaded data via cache";
      }
      
      if(ldate_sunday_checksum != res.date_sunday_checksum)
      {
         load_date_sunday();
         set_gray("table_termine_sonntag");
         console.log("Loaded data via ajax for date sunday");
         window.localStorage.setItem("date_sunday_checksum", res.date_sunday_checksum);
      }
      else
      {
         var date_sunday = window.localStorage.getItem("date_sunday");
         $("#table_termine_sonntag").html(date_sunday).trigger('create');
         set_gray("table_termine_sonntag");
         console.log("Loaded data via cache for date sunday");
      }
      
      if(ldate_monday_checksum != res.date_monday_checksum)
      {
         load_date_monday();
         set_gray("table_termine_montag");
         console.log("Loaded data via ajax for date monday");
         set_gray("table_termine_sonntag");
         window.localStorage.setItem("date_monday_checksum", res.date_monday_checksum);
      }
      else
      {
         var date_monday = window.localStorage.getItem("date_monday");
         $("#table_termine_montag").html(date_monday).trigger('create');
         set_gray("table_termine_sonntag");
         console.log("Loaded data via cache for date monday");
      }
  },
  error: function(e) {
      console.log(e.message);
  },
  complete: function(data) {
    $.mobile.loading('hide'); 
  }
});

// //Funktionen für Galerie
// $('.slideshow').cycle({
   // fx:     'fade',
   // next:   '#vorbutton',
   // prev:   '#zurueckbutton' 
// });

//Galerie bei IOS ausblenden
var i = 0;
var h_ios = 0;
iDevice = ['iPad', 'iPhone', 'iPod'];
for ( ; i < iDevice.length ; i++ ) 
{
   if( navigator.platform === iDevice[i] ){ 
      // document.getElementById('s1').style.visibility = 'hidden';
      // document.getElementById('s1').style.display = 'none';
      // document.getElementById('s1_buttons').style.visibility = 'hidden';
      // document.getElementById('s1_buttons').style.display = 'none';
      // document.getElementById('s1_title').style.visibility = 'hidden';
      // document.getElementById('s1_title').style.display = 'none';

      // gallerie_pause(); 
      document.getElementById('webcal').style.visibility = 'visible';
      h_ios = 1;

      break; 
      }
}



   // When the browser is ready...
   $(function() {
  
      // Setup form validation on the #register-form element
      $("#myform").validate({
    
         // Specify the validation rules
         rules: {
            chat_user: "required",
            chat_text: "required"
         },
        
         // Specify the validation error messages
         messages: {
            chat_user: "Bitte eine gültige Mailadresse angeben",
            chat_text: "Dies ist ein Pflichtfeld"
         },
        
         submitHandler: function(form) {
            form.submit();
        }
      });
   });

   
//Pruefe Version
var cur_version = document.getElementById("version").innerHTML; 
var cur_version = cur_version.replace("Version ", ""); 
var cur_version = cur_version.replace(".", "");
var cur_version = cur_version.replace(".", "");
if(cur_version < "200")
{
   show_message('Bitte aktualisieren Sie auf die neue Version. Aktuelle Version ('+cur_version+')');
}
alert("ready2");
});//Ende $(document).ready(function(){
// h_ios = 1;
   


// Programm für Samstag laden
function load_date_saturday(){
    $.ajax({
        type: 'GET',
        url: url_load_date_saturday,
        contentType: "application/json",
        dataType: 'jsonp',
        data: {},
        crossDomain: true,
        beforeSend: function(){
            $.mobile.loading('show');
        },
        success: function(res) {
            $("#table_termine_samstag").html(res.date_saturday).trigger('create');
            window.localStorage.setItem("date_saturday", res.date_saturday);
        },
        error: function(e) {
            console.log(e.message);
        },
        complete: function(data) {
          $.mobile.loading('hide'); 
        }
    });
};
    
// Programm für Sonntag laden
function load_date_sunday(){
    $.ajax({
        type: 'GET',
        url: url_load_date_sunday,
        contentType: "application/json",
        dataType: 'jsonp',
        data: {},
        crossDomain: true,
        beforeSend: function(){
            $.mobile.loading('show');
        },
        success: function(res) {
            $("#table_termine_sonntag").html(res.date_sunday).trigger('create');
            window.localStorage.setItem("date_sunday", res.date_sunday);
        },
        error: function(e) {
            console.log(e.message);
        },
        complete: function(data) {
          $.mobile.loading('hide'); 
        }
    });
};
    
// Programm für Montag laden
function load_date_monday(){
    $.ajax({
        type: 'GET',
        url: url_load_date_monday,
        contentType: "application/json",
        dataType: 'jsonp',
        data: {},
        crossDomain: true,
        beforeSend: function(){
            $.mobile.loading('show');
        },
        success: function(res) {
            $("#table_termine_montag").html(res.date_monday).trigger('create');
            window.localStorage.setItem("date_monday", res.date_monday);
        },
        error: function(e) {
            console.log(e.message);
        },
        complete: function(data) {
          $.mobile.loading('hide'); 
        }
    });
};
   
// Vergangene Termine grau unterlegen
function set_gray(tablename) {
   var tabelle = document.getElementById(tablename);
   var trs = tabelle.getElementsByTagName("tr");

   for(zeilenzaehler=0;zeilenzaehler<trs.length;zeilenzaehler++)
   {
      var x = document.getElementById(tablename).getElementsByTagName("td")[zeilenzaehler].innerHTML.substring(0,17);
      var termin = new Date(x.substring(6, 10), x.substring(3, 5)-1, x.substring(0, 2), x.substring(11, 13), x.substring(14, 16));   
      termin = termin.getTime();
         
      var jetzt = new Date();
      jetzt = jetzt.getTime();

      if(jetzt > termin)
      {
         var col=document.getElementById(tablename).getElementsByTagName("tr")[zeilenzaehler];
         col.style.background="#C7C7C7";
      }
   }   
} 
         
       
         
         
// Funktion um Chatnachricht zu versenden
function chat_submit(){

   if(document.getElementById("chat_text").value == '')
   {
      show_message('Bitte Text angeben');
   }
   else if(document.getElementById("chat_user").value == '')
   {
      show_message('Bitte Mailadresse angeben');
   }
   else
   {
      var submit_new_date = new Date();   //Startzeitpunkt
      chat_submit_time_new = submit_new_date.getTime();  
      
      var rest = (chat_submit_time_new - chat_submit_time_old) / 1000; //Differenz bilden und in Sekunden umwandeln
      
      //Es müssen mindestens x Sekunden seit dem letzten Eintrag vergangen sein
      if(rest > chat_submit_diff)
      {
         $.ajax({
             type: 'GET',
             url: url_chatbox_submit,
             contentType: "application/json",
             dataType: 'jsonp',
             data: { chat_text : document.getElementById("chat_text").value, chat_user : document.getElementById("chat_user").value},
             crossDomain: true,
             beforeSend: function(){
                 $('.loading').show();
             },
             success: function(res) {
                  show_message(res.returntext);
                  chat_refresh();
                  if(res.returntext == "Gesendet")
                  {
                     document.getElementById("chat_text").value = "";
                     chat_aktiv = 1;
                     window.localStorage.setItem("chat_aktiv", chat_aktiv);
                  }
                  else
                  {
                     chat_aktiv = 0;
                     window.localStorage.setItem("chat_aktiv", chat_aktiv);
                  }
                  return false;
             },
             error: function(e) {
                 console.log("Fehler");
             },
             complete: function(data) {
                 $('.loading').hide();
             }
         });
         
         var submit_old_date = new Date();   //Startzeitpunkt setzen
         chat_submit_time_old = submit_old_date.getTime(); 
      }
      else
      {
         var wait_seconds;
         wait_seconds = chat_submit_diff - rest;
         show_message('Es müssen ' + chat_submit_diff + ' Sekunden zwischen 2 Posts liegen. Gedulde dich noch ' + wait_seconds + ' Sekunden');
      }
      
      //Chat Benutzername merken
      window.localStorage.setItem("chat_user", document.getElementById("chat_user").value);
   }
};
         
// Funktion um Chatbox zu aktualisieren
function chat_refresh(){
   
   $.ajax({
       type: 'GET',
       url: url_chatbox_refresh,
       contentType: "application/json",
       dataType: 'jsonp',
       data: { },
       crossDomain: true,
       beforeSend: function(){
           $('.loading').show();
       },
       success: function(res) {
            document.getElementById("chat_content").value = res.chat_content;
            return false;
       },
       error: function(e) {
           console.log("Fehler");
       },
       complete: function(data) {
           $('.loading').hide();
       }
   });
};
 

function show_message(txt){
   try
   {
      navigator.notification.alert(txt,function() {}, 'Information', 'Ok');
   }
   catch(err)
   {
      alert(txt);
   }
}