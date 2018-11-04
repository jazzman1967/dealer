<?php
$page_title="Search Customer";
include ('includes/header.html');
require ('../mysqli_connect.php');
?>

<div class="content">
<h1>Search Customer</h1>
<form action="search-cust.php" method="post">
    <fieldset>
        <legend>Search Customer</legend>
        <p><label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" size="50" maxlength="50"></p>
        <p><label for="main_phone">Phone:</label>
        <input type="text" name="main_phone" id="main_phone" size="12" maxlength="12"> Please enter a 10 digit number with no dashes or parentheses</p>
        <p><label for="cell_phone_1">Cell Phone:</label>
        <input type="text" name="cell_phone_1" id="cell_phone_1" size="12" maxlength="12"> Please enter a 10 digit number with no dashes or parentheses</p>
        <p><label for="email1">Email:</label>
        <input type="text" name="email1" id="email1" size="100" maxlength="100"></p>
        <p><input type="submit" name="submit" value="Search"></p>
    </fieldset>
</form>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    //Initialize a counter to determine whether or not an OR clause is required
    $fieldcount = 0;

    //If no fields are filled in, then stop and give warning
    if(empty($_POST['last_name']) && empty($_POST['main_phone']) && empty($_POST['cell_phone_1']) && empty($_POST['email1'])) {
        echo "<p><strong>You must fill in at least one field</strong></p>";
     } else { 
        
        //Start query sentence
        $q = "SELECT cust_id,first_name,last_name,city,main_phone,cell_phone_1,email1 FROM customers WHERE ";

        //See which fields have been filled in 
        if(!empty($_POST['last_name'])) {
            $ln = mysqli_real_escape_string($dbc,trim($_POST['last_name']));
            
            //If this is the only field selected, then we don't need an OR clause. Otherwise we DO need the OR clause
            if($fieldcount == 0){
                $q = $q."last_name='".$ln."'";
                $fieldcount = $fieldcount + 1;
            } else {
                $q = $q." OR last_name='".$ln."'";
                $fieldcount = $fieldcount + 1;
            }
        
        }
        
        if(!empty($_POST['main_phone'])) {
            $phone = mysqli_real_escape_string($dbc,trim($_POST['main_phone']));
            if($fieldcount == 0) {
                $q = $q."main_phone='".$phone."'";
                $fieldcount = $fieldcount + 1;
            } else {
                $q = $q." OR main_phone='".$phone."'";
                $fieldcount = $fieldcount + 1;
            }
            
        }

        if(!empty($_POST['cell_phone_1'])) {
            $cell = mysqli_real_escape_string($dbc,trim($_POST['cell_phone_1']));
            if($fieldcount == 0) {
                $q = $q."cell_phone_1='".$cell."'";
                $fieldcount = $fieldcount + 1;
            } else {
                $q = $q." OR cell_phone_1='".$cell."'";
                $fieldcount = $fieldcount + 1;
            }
            
        }

        if(!empty($_POST['email1'])) {
            $email = mysqli_real_escape_string($dbc,trim($_POST['email1']));
            if($fieldcount == 0) {
                $q = $q."email1='".$email."'";
                $fieldcount = $fieldcount + 1;
            } else {
                $q = $q." OR email1='".$email."'";
                $fieldcount = $fieldcount + 1;
            }
            
        }

    } //end else statement

    //Execute the query
    $r = mysqli_query($dbc,$q);
    $num = mysqli_num_rows($r);

    //Display results
    if($num > 0) {
        echo "<p>There are $num record(s) that match the search</p>";

        //Generate table headers
        $theader =  '<table width="75%">'."\n<thead>\n"."\n<tr>\n";
        $theader .= '<th align="left"><strong>First Name</strong></th>';
        $theader .= '<th align="left"><strong>Last Name</strong></th>';
        $theader .= '<th align="left"><strong>City</strong></th>';
        $theader .= '<th align="left"><strong>Phone</strong></th>';
        $theader .= '<th align="left"><strong>Cell Phone</strong></th>';
        $theader .= '<th align="left"><strong>Email</strong></th>';
        $theader .= '<th align="left"><strong>Edit</strong></th>';
        $theader .= '<th align="left"><strong>Delete</strong></th>';
        $theader .= '<th align="left"><strong>Start Sale</strong</th>';
        $theader .= "\n</tr>\n</thead>\n<tbody>";

        echo $theader;

        while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
            echo '<tr><td align="left">'.$row['first_name'].'</td><td align="left">'.$row['last_name'].'</td><td>'.$row['city'].'</td><td>'.$row['main_phone'].'</td><td>'.$row['cell_phone_1'].'</td><td>'.$row['email1'].'</td><td><a href="edit-customer.php?cust-id='.$row['cust_id'].'">Edit</a></td><td><a href="delete-customer.php?cust-id='.$row['cust_id'].'">Delete</a></td><td><a href="attach.php?c='.$row['cust_id'].'">Start Sale</a></td></tr>'."\n";
        }
    echo "</tbody></table>";
    } else {
        echo "<p><strong>There are no records that match the search</strong></p>";
    }

} //End if($_SERVER['REQUEST_METHOD] == 'POST)
?>

</div>
</body>
</html>
