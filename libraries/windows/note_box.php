<?php
session_start();
include("../../functions.php");
include("windows.php");
if (isset($_POST["data"])){
   $dataObject=$_POST["data"];
   $row=json_decode($dataObject,true);
   $title=$row["title"];
   $style=$row["style"];
   $message=$row["message"];
   $buttons=$row["buttons"];
   // Las siguientes lineas dibujan la messagebox.
   //$message=xl($message);
   if (empty($buttons)){
      $buttons=array("Close"=>"","Ok"=>"");
   }else{
      $buttons=explode("&",$buttons);
      $buttons=array_flip($buttons);
   }
   //$style="top:35%;left:5%";
   $data=array("title"=>$title,"style"=>$style,"message"=>$message,"class"=>"indicacion_activa","style"=>$style);
   note_box($data,$buttons);
}else{
   echo "data does not exist";
}
?>