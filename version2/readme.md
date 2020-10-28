## Installation

Include this in the `<head>`:

```<link rel='stylesheet' href='/var/www/mastercopies/js/libraries/windows/windows.css' type='text/css'>
<script src='/var/www/mastercopies/js/libraries/windows/windows.js'></script>
<!-- <script src='/var/www/mastercopies/js/js_field_editor/js/jquery.min.js'></script> -->
<script src="/var/www/mastercopies/js/js_field_editor/js/jquery-1.12.4.js"></script>
<script src='/var/www/mastercopies/js/js_field_editor/js/jquery-3.3.1.min.js'></script>
<!-- <script src='/var/www/mastercopies/js/js_field_editor/js/jquery-3.5.1.js'></script> -->
<script src="/var/www/mastercopies/js/js_field_editor/js/jquery-ui.js"></script>
<script src="/var/www/mastercopies/js/js_field_editor/js/field_editor.js"></script>
<script type="text/javascript">
  // The r variable has to be initialized
  var r = false;
</script>
```

/* 1.- You must require the required_files.php which itselft contanis more requires.
    required_files.php content. */
  
  `<?php
		require("libraries/windows/windows.php");
		require("functions.php");
		require("colors.php");     // This is not necesary. I was in my tests.
   		require("sessions.php");   // This is not necesary. I was in my tests.
	?>`

	/* 2.- The css files and the js files descrip in the next points 3 and 4 must be wrapped up into divs so nobody sees the js code.
	   You will need to call the repeat function like this:
	   
     `<?php repeat("<div>",100); ?>
	       .. links to css
	       .. links js
	   <?php repeat("</div>",100); ?>`
	*/


    // 3.- This are the files you need to link for css.
    <link rel='stylesheet' href='libraries/windows/windows.css' type='text/css'>

    // 4.- This are the files you need to link for js.
    
    `<script src='libraries/windows/windows.js'></script>
  	<script src='js/jquery.min.js'></script>
  	<script src='js/jquery-3.1.1.min.js'></script>
    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/field_editor.js"></script>`

    /* 5.- A php array with the settings must be created. Of course you must change the db and table keys.
       You must provide a fields key with the name of fields (acording with the table) that will be edit.
       validate_regexp - Defines if you will use regular expresion validation. Posible values (true,false)
       js_regexp - Defines the javascript regular expresion to use. Javascript of course will work in the client side.
       php_regexp - Defines the php regular expresion to use. php of course will work in the server side.
       regexp_message - Defines the message to be return in case validation fails.
    */
    
 `$js_field_editor = [
						// Conection data
						'db' => 'digitalfire',
						'table' => 'products',

						'fields' =>  [
									'observation' => [
														'validate_regexp' => false,
														'js_regexp' => '[a-zA-Z]',
														'php_regexp' => '[a-zA-Z]',
														'regexp_message' => 'Only leters and numbers are accepted.',
													],
									'note' => [
														'validate_regexp' => false,
														'js_regexp' => '[a-zA-Z]',
														'php_regexp' => '[a-zA-Z]',
														'regexp_message' => 'Only leters are accepted.',
													],

								  ]

			   	  ];`

		/* 6.- The settings are printed in the DOM by php and hidden into 100 divs, so prevent someone read this data.
		   There, they will be read by js.
		*/
   		`repeat("<div>",100);
  			echo "<div id='js_field_editor' class='hidden'>";
	    		echo json_encode(array("js_field_editor"=>$js_field_editor),JSON_FORCE_OBJECT);
	  		echo "</div>";
  		repeat("</div>",100);`

  		/* 7. Each data to be edited in a td table of the datagrid must have an id and name attribute.
  			  The name attribute does not need an _$id sufix, but the id attribute does.
  			  Examples:
`  			  id='observation_$id' name='observation'
  			  id='note_$id' name='note'`
          
  			  An img tag must be in the next <td> to the field to edit. And must have the following attributes:
  			    `id='obse_$id' data-field='observation' onclick='edit_field(this)'`

  			    Note please, the id='obse_$id' attribute. See that a prefix of 5 letter exist (obse_). You have to put a
  			    5 letter prefix on each id of the img tag

  			    Where $id is the id of the record in the table.
  			    Where data-field is the name of the field in the table
  			    Where onclick will call always to the edit_field js function passing the complet element or object thanks to the "this' param
  			    And of course the img tag must have an image src, you can use whatever.

  			  Examples:
  			    `echo "<td class='ta-l' id='observation_$id' name='observation'> $observation</td>";
    		    echo "<td class='ta-l' > <img id='obse_$id' data-table='products' data-field='observation' onclick='edit_field(this)' src='imagenes/icon_edit.png' heigh='15px' width='15px' > </td>";

    		    echo "<td class='ta-l' id='note_$id' name='note' > $note </td>";
    		    echo "<td class='ta-l' > <img id='note_$id' data-table='products' data-field='note' onclick='edit_field(this)' src='imagenes/icon_edit.png' heigh='15px' width='15px' > </td>";`

  		The complete example;
`  		echo "<tr>";
    		echo "<td class='ta-c' id='id_$id' name='id' > $id </td>";
    		echo "<td class='ta-l' id='name_$id' name='name' > $name </td>";
    		echo "<td class='ta-c' id='price_$id' name='price' > $price </td>";
    		echo "<td class='ta-l' id='brand_$id' name='brand' > $brand </td>";
    		echo "<td class='ta-l' id='model_$id' name='model' > $model </td>";
    		echo "<td class='ta-l' id='serial_number_$id' name='serial_number' > $serial_number </td>";
    		echo "<td class='ta-l' id='observation_$id' name='observation'> $observation</td>";
    		echo "<td class='ta-l' > <img id='obse_$id' data-table='products' data-field='observation' onclick='edit_field(this)' src='imagenes/icon_edit.png' heigh='15px' width='15px' > </td>";
    		echo "<td class='ta-l' id='color_$id' name='color' > $color </td>";
    		echo "<td class='ta-l' id='note_$id' name='note' > $note </td>";
    		echo "<td class='ta-l' > <img id='note_$id' data-table='products' data-field='note' onclick='edit_field(this)' src='imagenes/icon_edit.png' heigh='15px' width='15px' > </td>";
  		echo "</tr>";
  		*/`

  		// Note - No divs are need to draw in the DOM afert each tr or row to show the popup windows. When the user clicks in the edit
  		          image of each row a popup note windows is call (will be created) contaning the current html data of the closest column. And when the
  		          save button of the note window is clicked this call to a function called save_field() passing al the data need it to save.
  		          This save_filed() function will call to a /controllers/save_field.php file which will recieve the parameters and
  		          save the data.

  		          In order to save the data save_field.php calls a function called dbConnect() whichs is in the function.php
  		          file. You must provide user and password to the database so dbConnect() can connect.



