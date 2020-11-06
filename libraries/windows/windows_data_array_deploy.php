<?php
  $title="";$message="";$type="";$buttons_type="";$buttons="";$class="";$styles="";
  foreach ($data as $key => $value) {
     if ($key=="title"){
        $title=$value;
     }elseif ($key=="message"){
        $message=$value;
     }elseif ($key=="type"){
        $type=$value;
     }elseif ($key=="buttons_type"){
        $buttons_type=$value;
     }elseif ($key=="buttons"){
        $buttons=$value;
     }elseif ($key=="class"){
        $class=$value;
     }elseif ($key=="style"){            
        $style=$value;
     }  
  }
?>