<?php 
$page_title = 'Add Customer';
include ('includes/header.html');
require ('../mysqli_connect.php');    
?>

<div class="content">

<h1>Add Customer</h1>
<p><strong>Fields marked with asterisk (*) are mandatory fields</strong></p>
<form action="customers.php" method="post">
    <fieldset>
        <legend>Add A Customer</legend>
        <p><label for="first_name">First Name(*):</label>
        <input type="text" name="first_name" id="first_name" size="50" maxlength="50" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" required></p>
        <p><label for="middle_name">Middle Name:</label>
        <input type="text" name="middle_name" id="middle_name" size="50" maxlength="50" value="<?php if (isset($_POST['middle_name'])) echo $_POST['middle_name'];?>"></p>
        <p><label for="last_name">Last Name(*):</label>
        <input type="text" name="last_name" id="last_name" size="50" maxlength="50" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']?>" required></p>
        <p><label for="address1">Address 1(*):</label>
        <input type="text" name="address1" id="address1" size="100" maxlength="100" value="<?php if (isset($_POST['address1'])) echo $_POST['address1']?>" required></p>
        <p><label for="address2">Address 2:</label>
        <input type="text" name="address2" id="address2" size="100" maxlength="100" value="<?php if (isset($_POST['address2'])) echo $_POST['address2']?>"></p>
        <p><label for="city">City(*):</label>
        <input type="text" name="city" id="city" size="100" maxlength="100" value="<?php if (isset($_POST['city'])) echo $_POST['city']?>" required></p>
        <p><label for="province">Province:</label>
        <select name="province" id="province">
        <?php 

            //Create Select for Provinces 

            $q = "SELECT province FROM provinces ORDER BY prov_id";
            $r = mysqli_query($dbc, $q); // Run the query.

            while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
                if($row['province'] == 'Ontario') {
                    echo '<option value="'.$row['province'].'" selected="selected">'.$row['province'].'</option>';
                } else {
                echo '<option value="'.$row['province'].'">'.$row['province'].'</option>';
                }
            }
        ?>
        </select></p>
        
        <p><label for="post_code">Postal Code:</label>
        <input type="text" name="post_code" id="post_code" size="7" maxlength="7" value="<?php if (isset($_POST['post_code'])) echo $_POST['post_code']?>"></p>
        <p><label for="main_phone">Main Phone(*):</label>
        <input type="tel" name="main_phone" id="main_phone" size="12" maxlength="12" value="<?php if (isset($_POST['main_phone'])) echo $_POST['main_phone']?>" required> Please enter a 10 digit number with no dashes or parentheses</p>
        <p><label for="work_phone">Work Phone:</label>
        <input type="tel" name="work_phone" id="work_phone" size="12" maxlength="12" value="<?php if (isset($_POST['work_phone'])) echo $_POST['work_phone']?>"> Please enter a 10 digit number with no dashes or parentheses</p>
        <p><label for="work_ext">Work Extension:</label>
        <input type="text" name="work_ext" id="work_ext" size="10" maxlength="10" value="<?php if (isset($_POST['work_ext'])) echo $_POST['work_ext']?>"></p>
        <p><label for="cell_phone_1">Cell Phone 1:</label>
        <input type="tel" name="cell_phone_1" id="cell_phone_1" size="12" maxlength="12" value="<?php if (isset($_POST['cell_phone_1'])) echo $_POST['cell_phone_1']?>"> Please enter a 10 digit number with no dashes or parentheses</p>
        <p><label for="cell_phone_2">Cell Phone 2:</label>
        <input type="tel" name="cell_phone_2" id="cell_phone_2" size="12" maxlength="12" value="<?php if (isset($_POST['cell_phone_2'])) echo $_POST['cell_phone_2']?>"> Please enter a 10 digit number with no dashes or parentheses</p>
        <p><label for="email1">Email 1 (*):</label>
        <input type="email" name="email1" id="email1" size="100" maxlength="100" value="<?php if (isset($_POST['email1'])) echo $_POST['email1']?>" required></p>
        <p><label for="email2">Email 2:</label>
        <input type="email" name="email2" id="email2" size="100" maxlength="100" value="<?php if (isset($_POST['email2'])) echo $_POST['email2']?>"></p>
<p><input type="submit" name="submit" value="Save"></p>
    </fieldset>
</form>

<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    //First see if customer exists by last name, home phone, work phone, cell phone 1, or email 1

    //Find out which fields have been filled in
    if (!empty($_POST['last_name'])) {
        $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
        $q1 = 'SELECT cust_id,first_name,last_name,email1 FROM customers WHERE last_name ='."'".$ln."'";
    } else {
        echo 'You must fill in a Last Name before proceeding.';
    }

    if(!empty($_POST['main_phone'])) {
        //Strip parentheses and dashes from phone
        $mainp = mysqli_real_escape_string($dbc,trim($_POST['main_phone']));
        $mainp = str_replace("(",'',$mainp);
        $mainp = str_replace(")",'',$mainp);
        $mainp = str_replace("-",'',$mainp);
    }

    if(!empty($_POST['work_phone'])) {
        $wp = mysqli_real_escape_string($dbc,trim($_POST['work_phone']));
        $wp = str_replace("(",'',$wp);
        $wp = str_replace(")",'',$wp);
        $wp = str_replace("-",'',$wp);
    }

    if(!empty($_POST['cell_phone_1'])) {
        $cp1 = mysqli_real_escape_string($dbc,trim($_POST['cell_phone_1']));
        $cp1 = str_replace("(",'',$cp1);
        $cp1 = str_replace(")",'',$cp1);
        $cp1 = str_replace("-",'',$cp1);
    }

    if(!empty($_POST['email1'])) {
        $em1 = mysqli_real_escape_string($dbc,trim($_POST['email1']));
    }    

    //Construct query based on what was filled in 
    if(strlen($hp) > 0) {
        $q1 = $q1.' OR main_phone ='."'".$hp."'";
    }

    if(strlen($wp) > 0) {
        $q1 = $q1.' OR work_phone = '."'".$wp."'";
    }

    if(strlen($cp1) > 0) {
        $q1 = $q1.' OR cell_phone_1 ='."'".$cp1."'";
    }

    if(strlen($em1) > 0) {
        $q1 = $q1.' OR email1 ='."'".$em1."'";
    }

    //Execute query

    $r = @mysqli_query($dbc,$q1);
    $num = mysqli_num_rows($r);

    //If we have a customer in the database, notify user and pull up record
    if ($num > 0) {

        echo "<h2>This customer possibly already exists in the database</h2>";
        while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
            echo '<p><strong>Cust No: </strong>'.$row['cust_id'].'<strong> First Name: </strong>'.$row['first_name'].'<strong> Last Name: </strong>'.$row['last_name'].'<strong> Email: </strong>'.$row['email1'].'<strong> Edit Customer: </strong>'.'<a href="edit-customer.php?cust-id='.$row['cust_id'].'">Click Here</a></p>';
        }
        
    } else {
        //Enter the customer in the database
        //Initialize an array to hold errors

        $errors = [];

        if (empty($_POST['first_name'])) {
            $errors[] = 'First Name is a mandatory field.';
        } else {
            $fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
        }

        if (empty($_POST['last_name'])) {
            $errors[] = 'Last Name is a mandatory field.';
        } else {
            $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
        }

        if (empty($_POST['address1'])) {
            $errors[] = 'Address 1 is a mandatory field.';
        } else {
            $ad1 = mysqli_real_escape_string($dbc, trim($_POST['address1']));
        }

        if (empty($_POST['city'])) {
            $errors[] = 'City is a mandatory field.';
        } else {
            $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
        }

        if (empty($_POST['main_phone'])) {
            $errors[] = 'Main Phone is a mandatory field.';
        } else {
            $mainp  = mysqli_real_escape_string($dbc, trim($_POST['main_phone']));
            $mainp = str_replace("(",'',$mainp);
            $mainp = str_replace(")",'',$mainp);
            $mainp = str_replace("-",'',$mainp);
        }

        if (empty($_POST['email1'])) {
            $errors[] = 'Email 1 is a mandatory field.';
        } else {
            $em1 = mysqli_real_escape_string($dbc, trim($_POST['email1']));
        }

        //Collect non-mandatory fields
        if (!empty($_POST['middle_name'])) {
            $mid = mysqli_real_escape_string($dbc,trim(($_POST['middle_name'])));
        }

        if (!empty($_POST['address2'])) {
            $ad2 = mysqli_real_escape_string($dbc,trim(($_POST['address2'])));
        }

        if(!empty($_POST['province'])) {
            $prov = mysqli_real_escape_string($dbc,trim($_POST['province']));
        }

        if(!empty($_POST['post_code'])) {
            $pcode = mysqli_real_escape_string($dbc,trim($_POST['post_code']));
        }
        
        if(!empty($_POST['work_phone'])) {
            $wp = mysqli_real_escape_string($dbc,trim($_POST['work_phone']));
            $wp = str_replace("(",'',$wp);
            $wp = str_replace(")",'',$wp);
            $wp = str_replace("-",'',$wp);
        }

        if(!empty($_POST['work_ext'])) {
            $ext = mysqli_real_escape_string($dbc,trim($_POST['work_ext']));
        }

        if(!empty($_POST['cell_phone_1'])) {
            $cp1 = mysqli_real_escape_string($dbc,trim($_POST['cell_phone_1']));
            $cp1 = str_replace("(",'',$cp1);
            $cp1 = str_replace(")",'',$cp1);
            $cp1 = str_replace("-",'',$cp1);
        }

        if(!empty($_POST['cell_phone_2'])) {
            $cp2 = mysqli_real_escape_string($dbc,trim($_POST['cell_phone_2']));
            $cp2 = str_replace("(",'',$cp2);
            $cp2 = str_replace(")",'',$cp2);
            $cp2 = str_replace("-",'',$cp2);
        }

        if(!empty($_POST['email2'])) {
            $em2 = mysqli_real_escape_string($dbc,trim($_POST['email2']));
        }

        //If no errors, then write to the database
        if (empty($errors)) {
            $q2 = "INSERT INTO customers (first_name,middle_name,last_name,address1,address2,city,province,post_code,main_phone,work_phone,work_ext,cell_phone_1,cell_phone_2,email1,email2)";
            $q2 = $q2." VALUES ('$fn','$mid','$ln','$ad1','$ad2','$city','$prov','$pcode','$mainp','$wp','$ext','$cp1','$cp2','$em1','$em2')";

            $r = @mysqli_query($dbc,$q2);

            if($r) {
                echo "<p>Customer Saved!</p>";
        } else {
            echo '<h2>Error!</h2>';
            echo '<p>The Following error(s) occured</p>';
            foreach($errors as $msg) {
                echo " . $msg<br/>\n";
            }
            echo '<p>Please try again</p>';
        }
    }

    } //end { else clause to check for existing user

    

    

} // end $_SERVER['REQUEST_METHOD] == 'POST'
?>

</div>
</body>
</html>
