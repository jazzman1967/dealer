<?php

//Create date May 15, 2018
//To do list: Make sure that a cust-id is present before executing update. Otherwise ALL records will get updated!!

$page_title="Edit Customer";
include ('includes/header.html'); //Menu header
require ('../mysqli_connect.php'); //Database connection

//If we have a GET request, grab the customer id and pull data from database
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $custno = $_GET['cust-id'];

    //Initialize array to hold data
    $data = [];
    
    $qq = "SELECT first_name,middle_name,last_name,address1,address2,city,province,post_code,main_phone,work_phone,work_ext,cell_phone_1,cell_phone_2,email1,email2 FROM customers WHERE cust_id = $custno";
    $r = @mysqli_query($dbc,$qq);
    while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
        $data[0] = $row['first_name'];
        $data[1] = $row['middle_name'];
        $data[2] = $row['last_name'];
        $data[3] = $row['address1'];
        $data[4] = $row['address2'];
        $data[5] = $row['city'];
        $data[6] = $row['province'];
        $data[7] = $row['post_code'];
        $data[8] = $row['main_phone'];
        $data[9] = $row['work_phone'];
        $data[10] = $row['work_ext'];
        $data[11] = $row['cell_phone_1'];
        $data[12] = $row['cell_phone_2'];
        $data[13] = $row['email1'];
        $data[14] = $row['email2'];
    }
}

?>
<div class="content">
<h1>Edit Customer</h1>

<form action="edit-customer.php" method="post">
<fieldset>

<p>Customer Number: <input type ="text" name="cust_id" size="3" readonly value="<?php echo $custno;?>"></p>
<p>First Name (*): <input type="text" name="first_name" size="50" maxlength="50" value="<?php echo $data[0];?>"></p>
<p>Middle Name: <input type="text" name="middle_name" size="50" maxlength="50" value="<?php echo $data[1];?>"></p>
<p>Last Name (*): <input type="text" name="last_name" size="50" maxlength="50" value="<?php echo $data[2];?>"></p>
<p>Address 1 (*): <input type="text" name="address1" size="100" maxlength="100" value="<?php echo $data[3];?>"></p>
<p>Address 2: <input type="text" name="address2" size="100" maxlength="100" value="<?php echo $data[4];?>"></p>
<p>City: <input type="text" name="city" size="100" maxlength="100" value="<?php echo $data[5];?>"></p>
<p>Province: <select name="province">
    <?php
    //Create Select List from provinces table 
    $q = "SELECT province FROM provinces ORDER BY prov_id";
    $r = mysqli_query($dbc,$q);
    while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
        if ($row['province'] == $data[6]) {
            echo '<option value"'.$row['province'].'" selected="selected">'.$row['province'].'</option>';
        } else {
        echo '<option value="'.$row['province'].'">'.$row['province'].'</option>';
        }
    }
    ?>
</select></p>
<p>Postal Code: <input type="text" name="post_code" size="7" maxlength="7" value="<?php echo $data[7];?>"></p>
<p>Main Phone (*): <input type="tel" name="main_phone" size="12" maxlength="12" value="<?php echo $data[8];?>"> Please enter a 10 digit number with no dashes or parenthese</p>
<p>Work Phone: <input type="tel" name="work_phone" size="12" maxlength="12" value="<?php echo $data[9];?>"> Please enter a 10 digit number with no dashes or parenthese</p>
<p>Work Extension: <input type="text" name="work_ext" size="10" maxlength="10" value="<?php echo $data[10];?>"></p>
<p>Cell Phone 1: <input type="tel" name="cell_phone_1" size="12" maxlength="12" value="<?php echo $data[11];?>"> Please enter a 10 digit number with no dashes or parenthese</p>
<p>Cell Phone 2: <input type="tel" name="cell_phone_2" size="12" maxlength="12" value="<?php echo $data[12];?>"> Please enter a 10 digit number with no dashes or parenthese</p>
<p>Email 1 (*): <input type="email" name="email1" size="100" maxlength="100" value="<?php echo $data[13];?>"></p>
<p>Email 2: <input type="email" name="email2" size="100" maxlength="100" value="<?php echo $data[14];?>"></p>
<p><input type="submit" name="submit" value="Update"></p>

</form>
</fieldset>
</div>
</body>
</html>

<?php 

//If we have a POST method, then run the update routine
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Grab values from form submission
    $custno = mysqli_real_escape_string($dbc,trim($_POST{'cust_id'}));
    $fn = mysqli_real_escape_string($dbc,trim($_POST['first_name']));
    $mid = mysqli_real_escape_string($dbc,trim($_POST['middle_name']));
    $ln = mysqli_real_escape_string($dbc,trim($_POST['last_name']));
    $ad1 = mysqli_real_escape_string($dbc,trim($_POST['address1']));
    $ad2 = mysqli_real_escape_string($dbc,trim($_POST['address2']));
    $city = mysqli_real_escape_string($dbc,trim($_POST['city']));
    $prov = mysqli_real_escape_string($dbc,trim($_POST['province']));
    $pcode = mysqli_real_escape_string($dbc,trim($_POST['post_code']));
    $phone = mysqli_real_escape_string($dbc,trim($_POST['main_phone']));
    $wp = mysqli_real_escape_string($dbc,trim($_POST['work_phone']));
    $ext = mysqli_real_escape_string($dbc,trim($_POST['work_ext']));
    $cp1 = mysqli_real_escape_string($dbc,trim($_POST['cell_phone_1']));
    $cp2 = mysqli_real_escape_string($dbc,trim($_POST['cell_phone_2']));
    $em1 = mysqli_real_escape_string($dbc,trim($_POST['email1']));
    $em2 = mysqli_real_escape_string($dbc,trim($_POST['email2']));

    //Check that mandatory fields are filled in. If not, populate the errors array
    $errors = [];

    if(empty($_POST['first_name'])) {
        $errors[] = 'The First Name is a mandatory field';
    }

    if(empty($_POST['last_name'])) {
        $errors[] = 'The Last Name is a mandatory field';
    }

    if(empty($_POST['address1'])) {
        $errors[] = 'Address 1 is a mandatory field';
    }

    if(empty($_POST['main_phone'])) {
        $errors[] = 'Main phone is a mandatory field';
    }

    if(empty($_POST['email1'])) {
        $errors[] = 'Email 1 is a mandatory field';
    }

    //If there are no errors, then run the update
    if(empty($errors)) {
    //Construct query
        $qu = "UPDATE customers SET first_name='$fn',middle_name='$mid',last_name='$ln',address1='$ad1',address2='$ad2',city='$city',province='$prov',post_code='$pcode',main_phone='$phone',work_phone='$wp',work_ext='$ext',cell_phone_1='$cp1',cell_phone_2='$cp2',email1='$em1',email2='$em2' WHERE cust_id=$custno";
        //echo $qu;
        $r = @mysqli_query($dbc,$qu);
        if(mysqli_affected_rows($dbc) == 1) {
            echo "<p>The customer had been updated!</p>";
        }
    } else {
        echo '<h2>Error!</h2>';
        echo '<p>The following error(s) occured:</p>';
        foreach($errors as $msg) {
            echo " . $msg<br/>\n";
        }
    }
}


?>
