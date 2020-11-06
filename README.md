# Javascript Pop-Up Field Editor

We are implementing this first in plainsmanclays.com/store/addedit.php.

Nov 6, 2020

Add this at the beginning

```// js_field_editor
// 1.- The require files are called.
require("../libraries/windows/windows.php");
//require("../js_field_editor/functions.php");

// 2.- The js_field_editor array is created. This array can have any name.
$js_field_editor = [
	// Conection data
	//'db' => 'plainsman',
	'table' => 'variation',

	'fields' =>  [
		'shelf_num_from_top' => [
			'type' => 'number',
			'validate_regexp' => false,
			'js_regexp' => '[a-zA-Z]',
			'php_regexp' => '[a-zA-Z]',
			'regexp_message' => 'Only leters and numbers are accepted.',
		],
		'notes' => [
			'type' => 'textarea',
			'validate_regexp' => false,
			'js_regexp' => '[a-zA-Z]',
			'php_regexp' => '[a-zA-Z]',
			'regexp_message' => 'Only leters are accepted.',
		],
	]
];

// 3.- The $js_field_editor array is printed in the DOM from where its information will be read.
//repeat("<div>",100);
  			echo "<div id='js_field_editor' class='hidden' style='display:none'>";
	    		echo json_encode(array("js_field_editor"=>$js_field_editor),JSON_FORCE_OBJECT);
	  		echo "</div>";
//repeat("</div>",100);
```
In the place for the edit: Line 1676

```$shelf = 0;
$ed1[] = '<td style="'.$tstyle.'"> <span id="shelf_num_from_top_'.$var['var_id'].'" style="font-size:75%; color:#aaaaaa;">'.$var['shelf_num_from_top'].'</span> <span data-id="'.$var['var_id'].'" data-field="shelf_num_from_top" onclick="edit_field(this)"> &#10000 </span> </td>';
```

Line 1689

```					$ed1[] = '<td style="width:200px; line-height: 1em;"><span id="myBtn_'.$count.'" data-id="'.$var['var_id'].'" class="myBtn"  data-field="notes" onclick="edit_field(this)"> &#10000 </span> <span id="notes_'.$var['var_id'].'" style="font-size:75%; color:#aaaaaa;">'.($var['notes']?' '.substr($var['notes'],0,10):'No desc').'</span></td>'; # Variation-specific note coming here (with pop-up editor)
```





This project is so valuable to me that I am willing to spend a month on it. It needs to work on any browser, on phones and tablets. We must be willing to sacrifice aesthetics for functionality and compatibility. Simplicity, not being too dependent on outside code that goes out-of-date, being documented well on my github account - these will make it easy-to-adopt and reliable. It only needs to edit one field, simplicity is much more important than window resizeability and moveability.

# Goals

Create a step-by-step procedure here to introduce to a web page the ability to click on a field and edit a record column in a popup dialog.

* Simplicity: Employs an absolute minimum of external code, making it easy to implement in a webpage.

* Standardized: All external code (js, css) is in one directory at /js. Each file there is documented in a txt file (e.g. xyz.js has an xyz.js.txt that explains it).

* Compatibility: Works on phones, tablets, desktop.

* Works on Normal Pages: No special divs needed. Fields just need an ID to identify them and an identified div that js can write data into.

* Does not read or write from a database: Uses an external API to get the data, save the data.

* Is documented thorouoghly here: The documentation grows as we improve the above features. It is in English and Spanish.

* Demonstrated: A general-purpose demonstration page is maintained somewhere that shows how it works.


## The Old Version from 2018

Following is the description of the original version.

This one simple PHP source file implements three sub-systems often deployed in separate PHP frameworks that can occupy hundreds (even thousands) of files. Since this code does not call any external code, you need only the minimum to preserve the simplicity.

* A pop-up javascript modal dialog that can present the column-value of a table record for editing, save it to the database (via an API call to this same page), and update the DOM with the edited value.

* An API that can respond to calls to get and put data to the desired table, record and column.

* A traditional PHP-generated multi-record table that can present columns for editing and a PHP handler that can respond to form saves and write SQL data.

A database simulator is employed to remove the complexities of dealing with SQL.

## Getting Started

The self-contained PHP file acts as both frontend and API backend to handle saving of multiple fields in any number of database tables. CSRF ( Cross Site Request Forgery ) check has been added to ensure requests can not be generated from third-party / unauthorized sites.

Pop-up and AJAX requests have been created in vanilla JavaScript to remove any dependency on third-party libraries and to avoid un-necessary overhead.

The API supports following functions

PUT: To store fields using POST request to script. Field id, name and CSRF token must be supplied for operation to succeed.

GET: To retrieve field values from database using POST request. Field id, name and CSRF token must be supplied for operation to succeed.

Script execution starts with Record Keys, which is a two dimensional array containing information about the record id, that needs to be updated and the table, in which that record exists.

$recordkeys = array(
array( "key" => 'abcd', "tablename" => 'table1'),
array( "key" => 'abce', "tablename" => 'table1'),
array( "key" => 'abcf', "tablename" => 'table2'),
array( "key" => 'abcg', "tablename" => 'table2'),
array( "key" => 'abch', "tablename" => 'table3')
);

This script automatically generates a table, containing rows for record editing, which allows the user to save names and edit description for each each field using simple UI and Pop-up respectively.

## Prerequisites

The directory, containing script, or the file "exampledatabase.txt" must be writable by the PHP script for testing purposes (since script reads from and writes to this text file to simulate SQL calls).

Once in production i.e. after removal of database simulator and integration of actual SQL calls, write permission can be removed.

## Installing

Copy PHP file into directory of your choice and execute on any server with PHP support.

https://localhost/dir/editexample.php

Once executed successfully, give your fields a name using the auto-generated table and press "Save Names" via PHP when you are done. This will save the fields in exampledatabase.txt file. This operation is handled using PHP:

```
if( isset($_POST['SaveAll']) AND $token == $_POST['token'] ){
  foreach($_POST as $ky => $vl) {
    if(substr($ky, 0, 6) == 'name_*') { # a field exists for this key (either blank or filled)
      $z = substr($ky, 6);
      DatabaseSimulator('put', $z, $_POST['table_'.$z], 'name', $_POST['name_'.$z]);
    }
  }
}
```
where variable inputs for DatabaseSimulator are Record Id, Table Name, and Field Value respectively.

Now you can click Edit (pencil) icon infront of any field to edit the field description in a javascript Pop-up using API. API requests are handled by same page after CSRF check has passed.

## Authors

Tony Hensen

## Contributing

We welcome all contributions from github users as long as they follow proper coding standards and do not add unnecessary dependencies e.g. use of JavaScript libraries to handle calls or frameworks like Bootstrap.

## License

This project is licensed under the MIT License.
Please add this description on GitHub
