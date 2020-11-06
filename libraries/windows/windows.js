
function open_window($title){
    $("#"+$title).show();
    $("#"+$title).css("visibility","visible");
    $("#"+$title+".windows").show();
    $("#"+$title+".windows").css("visibility","visible");
}

function close_window($title){
   $($title).hide();
   $($title).remove();
}

function open_box($title){
   $("#"+$title).show();
   $("#"+$title).css("visibility","visible");
   $("#"+$title+".windows").show();
   $("#"+$title+".windows").css("visibility","visible");
}

function close_box($title){
   $("#"+$title).hide();
   $("#"+$title).remove();
}

function window_box($title,$style){
   var $datos='{"title":"'+$title+'","style":"'+$style+'"}';
   // var $datos=JSON.stringify($datos);
   $.ajax({
       type:"POST",
       datatype:"json",
       data:{"data":$datos},
       url:"../libraries/windows/window_box.php",
   })
   .done( function (data) {
       $("body").append(data);
       open_window($title);
       $("#"+$title+" #Close-button").click(function(){
          close_window($title);
          $("#"+$title).remove();
          return false;
       });
       return r;
   })
   .fail( function (jqXHR, textStatus, errorThrown) {

   });
}

function close_window_when_press_escape_key($window){
   $("#"+$window).on('keydown',function ( e ) {
     if ( e.keyCode === 27 ) { // ESC
        $("#"+$window).hide();
        $("#"+$window).remove();
     }
   });
}

function confirm_box($title,$type,$message,$buttons,callback){
   var buttons=$buttons.split("&");
   var $datos='{"title":"'+$title+'","type":"'+$type+'","message":"'+$message+'","buttons":"'+$buttons+'"}';
   // var $datos=JSON.stringify($datos);
   $.ajax({
       type:"POST",
       datatype:"json",
       data:{"data":$datos},
       url:"../libraries/windows/confirm_box.php",
   })
   .done( function (data) {
       $("body").append(data);
       $("#"+$title+" .indicacion_activa").draggable();
       open_box($title);
       $("#"+$title+" #"+buttons[1]+"-button").click(function(){
          close_box($title);
          r=true;
          return callback(r);
       });
       $("#"+$title+" #"+buttons[0]+"-button").click(function(){
          close_box($title);
          r=false;
          return callback(r);
       });
   })
   .fail( function (jqXHR, textStatus, errorThrown) {

   });
}

function input_box($title,$type,$message,$buttons,callback){
   var buttons=$buttons.split("&");
   var $datos='{"title":"'+$title+'","type":"'+$type+'","message":"'+$message+'","buttons":"'+$buttons+'"}';
   // var $datos=JSON.stringify($datos);
   $.ajax({
       type:"POST",
       datatype:"json",
       data:{"data":$datos},
       url:"../libraries/windows/input_box.php",
   })
   .done( function (data) {
       $("body").append(data);
       $("#"+$title+" .indicacion_activa").draggable();
       open_box($title);
       $(document).ready(function(){
          $("#input_data").focus();
       });
       $("#"+$title+" #"+buttons[1]+"-button").click(function(){
          input_data=$("#input_data").val();
          close_box($title);
          r=true;
          return callback(r);
       });
       $("#"+$title+" #"+buttons[0]+"-button").click(function(){
          close_box($title);
          r=false;
          return callback(r);
       });
   })
   .fail( function (jqXHR, textStatus, errorThrown) {

   });
}

function message_box($title,$type,$message,$buttons){
   var buttons=$buttons.split("&");
   var $datos='{"title":"'+$title+'","type":"'+$type+'","message":"'+$message+'","buttons":"'+$buttons+'"}';
   // var $datos=JSON.stringify($datos);
   $.ajax({
       type:"POST",
       datatype:"json",
       data:{"data":$datos},
       url:"../libraries/windows/message_box.php",
   })
   .done( function (data) {
       $("body").append(data);
       $("#"+$title+" .indicacion_activa").draggable();
       open_box($title);
       $("#"+$title+" #"+buttons[0]+"-button").click(function(){
          close_box($title);
          $("#"+$title).remove();
          return false;
       });
       return r;
   })
   .fail( function (jqXHR, textStatus, errorThrown) {

   });
}

function alert_box($title,$type,$message,$buttons){
   var buttons=$buttons.split("&");
   var $datos='{"title":"'+$title+'","type":"'+$type+'","message":"'+$message+'","buttons":"'+$buttons+'"}';
   // var $datos=JSON.stringify($datos);
   $.ajax({
       type:"POST",
       datatype:"json",
       data:{"data":$datos},
       url:"../libraries/windows/alert_box.php",
   })
   .done( function (data) {
       $("body").append(data);
       $("#"+$title+" .indicacion_activa").draggable();
       open_box($title);
       $("#"+$title+" #"+buttons[0]+"-button").click(function(){
          close_box($title);
          $("#"+$title).remove();
          return false;
       });
       return r;
   })
   .fail( function (jqXHR, textStatus, errorThrown) {

   });
}

function note_box($title,$style,$message,$buttons,callback){
   var buttons=$buttons.split("&");
   var $datos='{"title":"'+$title+'","style":"'+$style+'","message":"'+$message+'","buttons":"'+$buttons+'"}';
   // var $datos=JSON.stringify($datos);
   $.ajax({
       type:"POST",
       datatype:"json",
       data:{"data":$datos},
       url:"../libraries/windows/note_box.php",
   })
   .done( function (data) {
       $("body").append(data);
       $("#"+$title+" .indicacion_activa").draggable();
       open_box($title);
       document.getElementById("input_note").focus();
       close_window_when_press_escape_key($title);
       $("#"+$title+" #"+buttons[1]+"-button").click(function(){
          $input_note = document.getElementById("input_note").value;
          close_box($title);
          r=true;
          return callback(r);
       });
       $("#"+$title+" #"+buttons[0]+"-button").click(function(){
          close_box($title);
          r=false;
          return callback(r);
       });
   })
   .fail( function (jqXHR, textStatus, errorThrown) {

   });
}