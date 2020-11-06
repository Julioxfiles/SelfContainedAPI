
        function edit_field($obj){
            var $pos = $obj.offsetParent;
            var $top = $pos.offsetTop;
            var $left = $pos.offsetLeft;
            $top = $top + 170;
            $left = $left - 220;
            //console.log($top+" "+$left);

            let $id = $obj.getAttribute("data-id");
            $data = $("#js_field_editor").html();
            $data = JSON.parse($data);
            let $field = $obj.getAttribute("data-field");
            let $table = $data.js_field_editor["table"];
            //alert($table);
            var $field_settings = $data.js_field_editor["fields"][$field];
            var $type = $field_settings["type"];
            if ($type == 'textarea' || $type == ''){
                get_field($table,$field,$id,function($data){
                     $style="background-color:#FDFBB8;border:solid 0.5px #FDFBB8;top:"+$top+"px;left:"+$left+"px;resize:both";
                     note_box($field.toString(),$style,$data,"Close&Save",function(){
                        if (r){
                            save_field($type,$obj,$id,$table,$field,$input_note.trim(),$field_settings);
                        }
                     });
                });
            }else{
                //alert($type);
                var element_exists = document.getElementById('input_'+$id);
                if (!element_exists){
                    var $input = document.createElement("input");
                    $input.setAttribute('type',$type);
                    $input.setAttribute('id', 'input_'+$id);
                    $input.style.width = '70px';

                    get_field($table,$field,$id,function($data){
                        var $value = $data;
                        var $span = $($obj).closest('span').prev('span');

                        $($obj).closest('span').prev('span').text('');
                        if ($type == 'number'){
                            $value = parseFloat($value);
                        }
                        $input.value = $value;
                        $span.append($input);

                        var $img_back = document.createElement('img');
                        $img_back.src = '../imagenes/icon_back.png';
                        $img_back.setAttribute('height', '18px');
                        $img_back.setAttribute('id', 'icon_back_'+$id);
                        $img_back.setAttribute('onclick', 'undo_edit("'+$field+'","'+$id+'","'+$value+'")');
                        $span.append($img_back);

                        var $img_save = document.createElement('img');
                        $img_save.src = '../imagenes/icon_save.png';
                        $img_save.setAttribute('height', '18px');
                        $img_save.setAttribute('id', 'icon_save_'+$id);
                        $img_save.setAttribute('onclick','save_field("'+$type+'","'+$obj+'","'+$id+'","'+$table+'","'+$field+'","'+$value+'","'+$field_settings+'")');
                        $span.append($img_save);
                    });
                }

            }
        }

        function undo_edit($field,$id,$value){
            //alert($field+$id+$value);
            $("#input_"+$id).remove();
            $("#icon_back_"+$id).remove();
            $("#icon_save_"+$id).remove();
            $("#"+$field+"_"+$id).html($value);
        }

        function get_field($table,$field,$id,callback){
           //alert($table);
           $.ajax({
             type:"GET",
             url: "https://plainsmanclays.com/get/"+$table+"/"+$id+"/field/"+$field,
             beforeSend: function(){
              //message_box("Wait","Wait","Processiog...please wait.","Close","Accept");
             },
             success: function(response){
               var resp = JSON.parse(response);
               if (resp.status = '200'){
                   $("#"+$field+"_"+$id).html(resp.data);
                   return callback(resp.data);
               }else{
                   alert_box("Info","Info",resp.result,"Accept"); return false;
               }
             },
             error: function(jqXHR,textStatus,errorThrown){
               close_box("Wait"); alert_box("Error","Error","An internal error has occurred.","Accept"); return false;
             }
           });

        }

        function save_field($type,$obj,$id,$table,$field,$value,$field_settings){
           if ($type != 'textarea'){
               $value = $("#input_"+$id).val();
           }
           if ($field_settings["validate_regexp"]){
  				    var regexp = new RegExp($field_settings["js_regexp"]);
  				    var res = regexp.test($value);
  				    if (!res){
	  				      alert($field_settings["regexp_message"]);
                  return false;
  				    }
  			   }
           $table = $data.js_field_editor["table"];
           $.ajax({
             type:"GET",
             url:"https://plainsmanclays.com/put/"+$table+"/"+$id+"/field/"+$field+"/"+$value,
             beforeSend: function(){
               //message_box("Wait","Wait","Processiog...please wait.","Close","Accept");
             },
             success: function(response){
               //close_box("Wait");
               var resp = JSON.parse(response);
               //alert(resp.data == true);
               if (resp.status = '200'){
                   $("#"+$field+"_"+$id).html($value.substr(0,10));
                   //alert_box("Success","Success","Data was save successfully.","Accept"); return true;
                   //alert("Data was save successfully");
               }else{
                   alert(resp.message);
               	   //alert_box("Info","Info",resp.data,"Accept"); return false;
               }
             },
             error: function(jqXHR,textStatus,errorThrown){
               //close_box("Wait"); alert_box("Error","Error","An internal error has occurred.","Accept"); return false;
             }
           });

        }

        function getClickPosition(e) {
            var parentPosition = getPosition(e.currentTarget);
            var xPosition = e.clientX - parentPosition.x - (theThing.clientWidth / 2);
            var yPosition = e.clientY - parentPosition.y - (theThing.clientHeight / 2);

            theThing.style.left = xPosition + "px";
            theThing.style.top = yPosition + "px";
         }

         function getPosition(e) {
            var xPos = 0;
            var yPos = 0;

            while (e) {
              if (e.tagName == "BODY") {
                 // deal with browser quirks with body/window/document and page scroll
                 var xScroll = e.scrollLeft || document.documenteement.scrollLeft;
                 var yScroll = e.scrollTop || document.documenteement.scrollTop;
                 xPos += (e.offsetLeft - xScroll + e.clientLeft);
                 yPos += (e.offsetTop - yScroll + e.clientTop);
              } else {
                  // for all other non-BODY eements
                 xPos += (e.offsetLeft - e.scrollLeft + e.clientLeft);
                 yPos += (e.offsetTop - e.scrollTop + e.clientTop);
              }
              e = e.offsetParent;
           }
           return {
             x: xPos,
             y: yPos
           };
       }