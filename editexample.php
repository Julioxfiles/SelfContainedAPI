<?php
session_start();

// generate CSRF token to prevent data from being sent from third party sites
// should be unique on every page load

if( !isset($_POST['APICommand']) && !isset($_POST['SaveAll']) ){

    $token = md5(uniqid(rand(), TRUE));     // generate random number and md5 to create unique token
    $_SESSION['token'] = $token;            // store token in session, we will compare submissions with this token

}else{

    // the request is coming from previous page load so should have old token
    $token = $_SESSION['token'];
}

$bf = array();
$recordkeys = array(
    array( "key" => 'abcd', "tablename" => 'table1'),
    array( "key" => 'abce', "tablename" => 'table1'),
    array( "key" => 'abcf', "tablename" => 'table2'),
    array( "key" => 'abcg', "tablename" => 'table2'),
    array( "key" => 'abch', "tablename" => 'table3')
);
# echo '<pre>'; print_r($recordkeys); echo '</pre>';

####### API #########
if( isset($_POST['APICommand']) ) {

    $allowedcolumns = array('name', 'description');

    // to get field value using API
    if( $_POST['APICommand']=='get' && isset($_POST['tablename']) && isset($_POST['fieldname']) && isset($_POST['z']) ){

        // required value must be allowed to be edited
        if( array_search($_POST['fieldname'], $allowedcolumns) ){
            die(DatabaseSimulator('get', $_POST['z'], $_POST['tablename'], $_POST['fieldname']));
        }else{
            die("Requested field is not available");
        }

        // to update field value using API
    }else if( $_POST['APICommand']=='put' && isset($_POST['tablename']) && isset($_POST['fieldname']) && isset($_POST['fieldvalue']) && isset($_POST['z']) && isset($_POST['token']) && $_POST['token'] == $token ) {

        if( array_search($_POST['fieldname'], $allowedcolumns) ) {
            die(DatabaseSimulator('put', $_POST['z'], $_POST['tablename'], $_POST['fieldname'], $_POST['fieldvalue']));
        }else{
            die("Requested field is not available");
        }

    }

    die;

}

######## PROCESS FORM SAVES AND SHOW THE PAGE ########
if( isset($_POST['SaveAll']) AND $token == $_POST['token'] ){

    foreach($_POST as $ky => $vl) {
        if(substr($ky, 0, 6) == 'name_*') { # a field exists for this key (either blank or filled)
            $z = substr($ky, 6);
            DatabaseSimulator('put', $z, $_POST['table_'.$z], 'name', $_POST['name_'.$z]);
        }
    }

}
?>
    <html>
    <head>

        <title>Multi Record Editing</title>

        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }

            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content/Box */
            .modal-content {
                background-color: #fefefe;
                margin: 8% auto; /* 15% from the top and centered */
                padding: 20px;
                border: 1px solid #888;
                width: 30%; /* Could be more or less, depending on screen size */
            }

            /* The Close Button */
            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
            .myBtn{
                cursor : pointer;
            }
        </style>

    </head>
    <body>

    <h2>Multi-Record Editing</h2>
    <form method="POST" name="saveproduct" action="<?php MakeLink(); ?>">
        <table id="table">
            <tr>
                <td>Key</td>
                <td>Name</td>
                <td>Description</td>
                <td>Edit</td>
            </tr>


            <?php

            // display data from DB for editing
            $count = 1;
            foreach($recordkeys as $z) {    // here $z is now array

                $thisrow = DatabaseSimulator('get', $z['key'], $z['tablename']);
                echo '<tr>';
                echo "\n".'<td>'.$z['key'].'</td>';
                echo '<td>';
                echo '<input name="name_'.$z['key'].'" value="'.htmlentities($thisrow['name']).'">';
                echo '<input type="hidden" value="1" name="name_*'.$z['key'].'" />';
                echo '<input type="hidden" value="'.$z['tablename'].'" name="table_'.$z['key'].'" />';
                echo '</td>';
                echo "\n ".'<td style="font-style:italic; color:#888888; font-size:80%;"><span id="'.$z['tablename'].'_description_'.$z['key'].'">'.$thisrow['description'].'</span></td>';
                echo "\n  ".'<td><span  id="btn_'.$z['key'].'" data-id="'.$z['key'].'" data-table="'.$z['tablename'].'" class="myBtn">&#9998;</span></td>';
                echo '</tr>';
                $count++;
            }

            ?>

        </table>

        <!-- token to authenticate origin of request -->
        <input name="token" id="token" value="<?php echo $token; ?>" style="display: none;">

        <button type="submit" name="SaveAll" value="1">Save Names via PHP</button>

    </form>


    <!-- Modal to Edit Description -->
    <div id="myModal" class="modal" style="display: none">
        <div class="modal-content">
            <span class="close">&times;</span>
            <u><h2>Description</h2></u>
            <textarea id="value_modal"  class="form-control" rows="5" style="padding: 5px; border-radius: 6px; width: 100%; max-width: 100%; resize: vertical;"></textarea>
            <br>
            <br>
            <input name="token_modal" id="token_modal" value="<?php echo $token; ?>" style="display: none;">
            <input type="submit" id="submit_btn" value="SAVE" id="update" style="padding: 5px 15px; border-radius: 5px; ">
        </div>
    </div>

    <script>
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];
        var key = "";
        var tablename  = "";

        // Get all elements from myBtn class
        let btn_new = document.querySelectorAll(".myBtn");

        btn_new.forEach(function (btn) {
            btn.onclick = function () {
                let data = btn.getAttribute("data-id");
                let table = btn.getAttribute("data-table");
                let description = document.getElementById(table+"_description_"+data).innerText;
                document.getElementById("value_modal").value = description;
                key = data;
                tablename = table;
                modal.style.display = "block";

            };
        });


        // close modal
        span.onclick = function(e) {
            e.preventDefault();
            modal.style.display = "none";
        };

        // close modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // get new value on form submit and send request to DB
        document.getElementById("submit_btn").onclick = function() {

            var new_value = document.getElementById("value_modal").value;
            var token = document.getElementById("token_modal").value;

            var request_url = "editexample.php";
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                console.log(xhttp);
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == "") {
                        //set value
                        document.getElementById(tablename+"_description_"+key).innerHTML = new_value;
                        //hide modal
                        modal.style.display = "none";
                    } else {
                        alert(this.responseText);
                    }
                }
            };

            xhttp.open("POST", request_url, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("APICommand=put&tablename=" + tablename + "&fieldname=description&fieldvalue=" + new_value + "&z=" + key + "&token=" + token);
        }
    </script>
    </body>
    </html>

<?php

// generate form submission link
function MakeLink($param=null){ return 'editexample.php'.(!is_null($param)?'?'.$param:''); }

// simulate database operations using a text file
function DatabaseSimulator($operation, $z, $tablename = null, $fieldname=null, $fieldvalue=null){
    static $f;
    global $recordkeys;
    if(!isset($f)) { # initialize
        if(!file_exists('exampledatabase.txt')) {
            $n=310;
            foreach($recordkeys as $z) {
                //$f[$z]['description']="A middle temperature smooth stoneware clay";
                echo "{$z['tablename']} {$z['key']}<br />";
                $f[$z['tablename']][$z['key']]['description'] = "clay";
                $f[$z['tablename']][$z['key']]['name'] ="M".$n++;
            }
            file_put_contents('exampledatabase.txt', serialize($f));
        } else {
            $f = unserialize(file_get_contents('exampledatabase.txt'));
            # echo '<pre>'; print_r($f); echo '</pre>';
        }
    }
    if($operation == 'put') {
        $f[$tablename][$z][$fieldname] = $fieldvalue;
        file_put_contents('exampledatabase.txt', serialize($f));
    } else { # get
        if(is_null($fieldname)) { # whole record
            foreach($f[$tablename][$z] as $ky => $vl) {
                $row[$ky]=$vl;
            }
            return $row;
        }
        return $f[$tablename][$z][$fieldname];
    }
}

echo '<h2>Code</h2>';
echo '<pre>';
$a = file('editexample.php');
foreach($a as $line) {
    echo htmlentities($line);
}
echo '</pre>';
?>
