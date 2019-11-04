# SelfContained API

This one simple PHP source file implements three sub-systems often deployed in separate PHP frameworks that can occupy hundreds (even thousands) of files. This simplicity enables making an easier inventory of vulnerabilities. Since this code does not call any external code, you need only the minimum to preserve the simplicity.

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
