<?php

function head_windows(){
echo "
  <link rel='stylesheet' href='css/windows.css'>
  <script type='text/javascript' src='js/windows.js'></script>
  ";
}

function message_box($data,$pbuttons){
   require("windows_data_array_deploy.php");
   require("windows_colors.php");
   $caracteres=array(" ","?","!","$","%","&","/","(",")","=","¡","¿","{","}",";",",","*",":",".","[","]","1","2","3","4","5","6","7","8","9","0");
   foreach ($caracteres as $key => $value) {
      $title=str_replace($value,'_',trim($title));
   }
   echo "<div id='$title' class='windows-background'>";
    echo "<div id='$title' class='$class' style='$style;color;$Color_Texto_Ventana;border:solid 3px #232323'>";
     echo "<div id='title' class='windows-title' style='$Color_Fondo_Ventana;color:$Color_Texto_Titulo_Ventana;'>".substr($title,0,40);
       echo "<div class='windows-close-icon'>";
         echo "<img id='cerrar_nota' src='../imagenes/icon_delete.png' height='15px' onclick='close_window($title);'>";
       echo "</div>";
     echo "</div>";
     echo "<br/>";
     $image=get_window_image($type);
     echo "<div class='windows-type'><img src='../imagenes/$image' height='35px' width='35px'></div>";
     echo "<div class='windows-message-box-layout' style='color:$Color_Texto_Lamina_Ventana;font-size:14px;'><p id='message'><span style='color:white'></span>".substr($message,0,256); echo "</p></div>";
     //echo "<div>";
     echo "<div class='windows-buttons'>";
       foreach ($pbuttons as $button => $function){
           $image="";
           require("windows_image_buttons.php");
           echo "<input type='button' class='windows-button' style='$Color_Fondo_Boton_Ventana;$Color_Texto_Boton_Ventana;border-color:$Color_Borde_Boton_Ventana;min-width:90px;background:url(imagenes/$image) no-repeat;background-size:15px;background-position:3px 3px;m' id='$button-button' name='$button-button' value='".$button."' onclick='$function;' >";
       }
     echo "</div>";
    echo "</div>";
   echo "</div>";
  echo "</div>";
}

function input_box($data,$pbuttons){
   require("windows_data_array_deploy.php");
   require("windows_colors.php");
   $caracteres=array(" ","?","!","$","%","&","/","(",")","=","¡","¿","{","}",";",",","*",":",".","[","]","1","2","3","4","5","6","7","8","9","0");
   foreach ($caracteres as $key => $value) {
      $title=str_replace($value,'_',trim($title));
   }
   echo "<div id='$title' class='windows-background'>";
    echo "<div id='$title' class='$class' style='$style;$Color_Fondo_Ventana;color;$Color_Texto_Ventana'>";
     echo "<div id='title' class='windows-title' style='Color_Fondo_Ventana;color:$Color_Texto_Titulo_Ventana;'>".substr($title,0,40);
       echo "<div class='windows-close-icon'>";
         echo "<img id='cerrar_nota' src='../imagenes/icon_delete.png' height='15px' onclick='close_window($title);'>";
       echo "</div>";
     echo "</div>";
     echo "<br/>";
     $image=get_window_image($type);
     echo "<div class='windows-type'><img src='../imagenes/$image' height='35px' width='35px'></div>";
     echo "<div class='windows-layout' style='color:$Color_Texto_Lamina_Ventana;font-size:14px'><p id='message'><span style='color:white'></span>".substr($message,0,256); echo "</p>";
         $input_data="";
         echo "<input class='input-text-form' style='width:90%;' type='$type' id='input_data' name='input_data' value='".$input_data."' tabindex='1'>";
         $image="";
     echo "</div>";
         echo "<div class='windows-buttons'>";
           foreach ($pbuttons as $button => $function){
              $image="";
              require("windows_image_buttons.php");
              echo "<input type='button' class='windows-button' style='$Color_Fondo_Boton_Ventana;$Color_Texto_Boton_Ventana;border-color:$Color_Borde_Boton_Ventana;min-width:90px;background:url(imagenes/$image) no-repeat;background-size:15px;background-position:3px 3px' id='$button-button' name='$button-button' value='".$button."' onclick='$function;' >";
           }
         echo "</div>";
    echo "</div>";
   echo "</div>";

}

function alert_box($message,$title,$type){
   echo "<div id='$title' class='AlertMessage' onclick='close_alert_box($title)'>";
     echo "<form id='form_alert_box' autocomplete='off' action='' method='GET'>";
      $image="icon_alert.png";
      echo "<div class='windows-type'><img src='../imagenes/$image' height='35px' width='35px'></div>";
      echo "<img style='float:right' src='../imagenes/icon_delete.png' height='15px' onclick='close_alert_box($title)'><br/><br/>";
      echo "<div class='windows-message-box-layout'><p><span style='color:white'>Alert: </span>".substr($message,0,256); echo "</p></div>";
       echo "<div>";
        echo "</div>";
      echo "</form>";
    echo "</div>";
}

function window($data,$pbuttons){
   require("windows_data_array_deploy.php");
   require("windows_colors.php");
   $caracteres=array(" ","?","!","$","%","&","/","(",")","=","¡","¿","{","}",";",",","*",":",".","[","]","1","2","3","4","5","6","7","8","9","0");
   foreach ($caracteres as $key => $value) {
      $title=str_replace($value,' ',trim($title));
   }
   echo "<div id='$title' class='windows-background'>";
    echo "<div id='$title' class='$class' style='$style;background-color:$Color_Fondo_Ventana;color:$Color_Texto_Ventana;'>";
     echo "<div id='title' class='windows-title' style='$Color_Fondo_Titulo_Ventana;color:$Color_Texto_Titulo_Ventana;'>".substr($title,0,40);
       echo "<div class='windows-close-icon'>";
         echo "<img id='cerrar_nota' src='imagenes/icon_delete.png' height='15px' onclick='close_window($title);'>";
       echo "</div>";
     echo "</div>";
     echo "<br/>";
      $image=get_window_image($type);
      echo "<div class='windows-layout' style='margin-left:5px;height:90%;width:97%;$Color_Fondo_Ventana;color:$Color_Texto_Lamina_Ventana;'><p><span id='message-title' style='color:white'></span><span id='message'>".substr($message,0,256); echo "</span></p>";
        echo "<div id='window_content' class='windows-content' style='width:98%;$Color_Fondo_Ventana;color:$Color_Texto_Lamina_Ventana;'>";
        echo "</div>";
        echo "<div class='windows-buttons'>";
         foreach ($pbuttons as $button => $function){
            $image="";
            require("windows_image_buttons.php");
            echo "<input type='button' class='windows-button' style='$Color_Fondo_Boton_Ventana;$Color_Texto_Boton_Ventana;border-color:$Color_Borde_Boton_Ventana;min-width:90px;background:url(imagenes/$image) no-repeat;background-size:15px;background-position:3px 3px' id='$button-button' name='$button-button' value='".$button."' onclick='$function;' >";
         }
       echo "</div>";  // windows-buttons
      echo "</div>";
     echo "</div>";  // windows-layout
    echo "</div>";  // title $class zoom
   echo "</div>";  // windows-background
}

function note_box($data,$pbuttons){
   require("windows_data_array_deploy.php");
   require("windows_colors.php");
   $caracteres=array(" ","?","!","$","%","&","/","(",")","=","¡","¿","{","}",";",",","*",":",".","[","]","1","2","3","4","5","6","7","8","9","0");
   foreach ($caracteres as $key => $value) {
      $title=str_replace($value,' ',trim($title));
   }
   echo "<div id='$title'>";
      echo "<div id='$title' class='$class draggable' style='$style'>";
        echo "<Strong>$title:</Strong>";
        echo "<img style='float:right' src='../imagenes/icon_delete.png' height='15px' onclick='close_window($title);'>";
        echo "<div id='window_content'>";
         echo "<textarea id='input_note' style='background-color:inherit;color:black;height:75%;width:100%;border:none;border:0' rows='10' cols='25' placeholder='$message'>$message</textarea>";
        echo "</div>";
         // El atributo autofocus se elimino de la linea de codigo anterior.
         //echo "<input type='button' class='button' value='Close' onclick='close_window($title)'>";
        echo "<div class='windows-buttons' style='margin-top:0px;'>";
         foreach ($pbuttons as $button => $function){
            $image="";
            require("windows_image_buttons.php");
            //echo "<input type='button' class='button' style='float:right;' id='$button-button' name='$button-button' value='".xl($button)."' onclick='$function;' >";
            echo "<input type='button' class='button' style='float:right;margin-left:10px' id='$button-button' name='$button-button' value='.$button.' onclick='$function;' >";
         }
       echo "</div>";  // windows-buttons

     echo "</div>"; // Cierre de td de indicacion.
   echo "</div>";
}

function get_window_image($type){
   $image="";
   if ($type=="Wait" || $type=="Espere"){$image="icon_loading.gif";}
   if ($type=="Question" || $type=="Pregunta"){$image="icon_question.png";}
   if ($type=="Info" || $type=="Informacion"){$image="icon_info.png";}
   if ($type=="Warning" || $type=="Advertencia"){$image="icon_alert.png";}
   if ($type=="Alert" || $type=="Alerta"){$image="icon_alert.png";}
   if ($type=="Success" || $type=="Exito"){$image="icon_success.png";}
   if ($type=="Input" || $type=="Entrada"){$image="icon_input.png";}
   if ($type=="Password" || $type=="Clave"){$image="icon_input.png";}
   if ($type=="Error" || $type=="Error"){$image="icon_error.png";}
   if ($type=="Loading" || $type=="Cargando"){$image="icon_loading.gif";}
   if ($type=="Save" || $type=="Grabar"){$image="icon_save.png";}
   if ($type=="Exit" || $type=="Grabar"){$image="icon_exit.png";}
   if ($type=="Next" || $type=="Siguiente"){$image="icon_next_green_arrow.png";}
   if ($type=="Download" || $type=="Descargar"){$image="icon_download.png";}
   if ($type=="Downloading" || $type=="Descargando"){$image="icon_donloading.gif";}
   if ($type=="Burn" || $type=="Quemar"){$image="icon_burn_cd.png";}
   if ($type=="Burning" || $type=="Quemando"){$image="icon_burning_cd.gif";}
   if ($type=="Recycle" || $type=="Reciclar"){$image="icon_recycle_wastebasquet.png";}
   if ($type=="Recycling" || $type=="Reciclando"){$image="icon_recycling.gif";}
   if ($type=="Folder" || $type=="Carpeta"){$image="icon_open_file_folder.gif";}
   if ($type=="Transfering" || $type=="Transfiriendo"){$image="icon_matrix.gif";}
   if ($type=="Zip" || $type=="zip"){$image="icon_zip_file.png";}
   return $image;
}

?>