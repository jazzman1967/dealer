<?php
//Create date May 17, 2018
$page_title="Add GL Account";
include ('includes/header.html');
require ('../mysqli_connect.php');
?>

<div class="content">
<h1>Add GL Account</h1>

<form action="add-gl.php" method="post">
    <fieldset>
        <legend>Add A General Ledger Account</legend>
        <p><label for="account">Account (Max 65,535):</label>
        <input type="text" name="account" id="account" size="5" maxlength="5" value="<?php if(isset($_POST['account'])) echo $_POST['account']; ?>" required></p>
        <p><label for="description">Description:</label>
        <input type="text" name="description" id="description" size="50" maxlength="50" value="<?php if(isset($_POST['description'])) echo $_POST['description']; ?>" required></p>
        <p><label for="type_id">Type:</label>
        <select name="type_id" id="type_id">
            <?php 
            //Grab list of account types from mysql
            $q = "SELECT id,description FROM account_types";
            $r = @mysqli_query($dbc,$q);
            while($row = mysqli_fetch_array($r)) {
                echo '<option value="'.$row[0].'">'.$row[1].'</option>';
            }

            ?>
            </select></p>
        <p><label for="balance">Opening Balance:</label>
        <input type="number" name="balance" id="balance" value="<?php if (isset($_POST['balance'])) echo $_POST['balance']; ?>"></p>
        <p><input type="submit" name="submit" value="Save"></p>
</fieldset>
</form>

<?php 
//Initalize array to hold errors
$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(empty($_POST['account']) || (!is_numeric($_POST['account']))) {
        $errors [] = '<p>The Account is a mandatory field and MUST be numeric</p>';
    } else {
        $account = mysqli_real_escape_string($dbc,trim($_POST['account']));
    }
    

    if(empty($_POST['description'])) {
        $errors[] = '<p>The Description is a mandatory field</p>';
    } else {
        $description = mysqli_real_escape_string($dbc,trim($_POST['description']));
    }

    //Grab the other fields
    if(!empty($_POST['type_id'])) {
        $acctype = mysqli_real_escape_string($dbc,trim($_POST['type_id']));
    }

    if(!empty($_POST['balance'])) {
        $balance = mysqli_real_escape_string($dbc,trim($_POST['balance']));
    } else {
        $balance = 'null';
    }

    if(empty($errors)) {
        //Prepare the statement
        $query = "INSERT INTO coa (account,description,type_id,balance) VALUES($account,'$description',$acctype,$balance)";
        //echo $query;
        $r = @mysqli_query($dbc,$query);
        if($r) { 
            echo '<p>Account Saved!</p>';
        } else {
            //Hopefully we never get here!
            echo '<p>An unkown error occured. Please contact support</p>';
        }
    } else {
        echo '<h2>Error!</h2>';
        echo '<p>The following error(s) occured: </p>';
        foreach($errors as $msg) {
            echo $msg;
        }
    }  
} //end if($_SERVER['REQUEST_METHOD'] == 'POST') 
    


?>
</div>
<script src="js/gl.js"></script>
</body>
</html>
