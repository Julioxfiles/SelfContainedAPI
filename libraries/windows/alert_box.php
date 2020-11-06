<?php
session_start();
include("../../functions.php");
include("windows.php");

if (isset($_POST["data"])){
   $dataObject=$_POST["data"];
   $row=json_decode($dataObject,true);
   $title=$row["title"];
   $type=$row["type"];
   $message=$row["message"];
   $buttons=$row["buttons"];
   // Las siguientes lineas dibujan la messagebox.
   //$message=xl($message);
   if (empty($buttons)){
      $buttons=array("Cancel"=>"","Ok"=>"");
   }else{
      $buttons=explode("&",$buttons);
      $buttons=array_flip($buttons);
   }
   $style="height:130px;top:35%;background-color:rgba(0,0,0,0.7);";
   $data=array("title"=>$title,"type"=>$type,"message"=>$message,"class"=>"windows","style"=>$style);
   message_box($data,$buttons);
}else{
   echo "data does not exist";
}

?>