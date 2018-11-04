<?php

$page_title = "Attach Customer to Vehicle";
include('includes/header.html');
?>

<div class="content">
<h1>Attach Customer &amp; Vehicle</h1>

<?php

if((!isset($_GET['c'])) && (!isset($_GET['v'])) && ($_SERVER['REQUEST_METHOD'] != 'POST')) {
    echo '<p id="error">This page was called incorrectly. Please go to either
    <a href="search-cust.php">Customer Search</a> OR
    <a href="search-vehicles.php">Vehicle Search</a> to start the Sales Process</p>';
}

if(isset($_GET['c'])) {
    $customer = $_GET['c'];

    display_customer($customer);
    display_vehicle_search($customer);

} elseif(isset($_GET['v'])) {
    $vehicle = $_GET['v'];
    display_vehicle($vehicle);
    display_customer_search($vehicle);
    
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['vehicle_id'])) {
        //echo 'This is going to be a customer search';
        //If no fields have been filled in. Warn user and redo the forms.
        if(empty($_POST['last']) && empty($_POST['phone']) && empty($_POST['cell']) && empty($_POST['email'])) {
            echo '<p id="error">You must fill in at least one search criteria</p>';
            $vehicle = $_POST['vehicle_id'];
            //echo "The vehicle is $vehicle";
            display_vehicle($vehicle);
            display_customer_search($vehicle);
        } else {
            $vehicle = $_POST['vehicle_id'];
            //echo '<p>Let us do a search!</p>';
            display_vehicle($vehicle);
            echo '<hr/>';
            $fieldcount = 0;
            //Start the query sentence 
            $custquery = 'SELECT cust_id,first_name,last_name,city,main_phone,cell_phone_1,email1 FROM customers WHERE ';

            //Verify each field and if filled in, then append to query
            if(!empty($_POST['last'])) {
                $ln = $_POST['last'];
                if($fieldcount == 0) {
                    $custquery .= "last_name = '$ln'";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $custquery .= " AND last_name ='$ln'";
                    $fieldcount = $fieldcount + 1;
                }
            } //end of if(!empty($_POST['last']))

            if(!empty($_POST['phone'])) {
                $phone = $_POST['phone'];
                if($fieldcount == 0) {
                    $custquery .= "main_phone='$phone'";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $custquery .= " AND main_phone='$phone'";
                    $fieldcount = $fieldcount + 1;
                }
            } //end of if(!empty($_POST['phone']))

            if(!empty($_POST['cell'])) {
                $cell = $_POST['cell'];
                if($fieldcount == 0) {
                    $custquery .= "cell_phone_1='$cell'";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $custquery .= " AND cell_phone_1='$cell'";
                    $fieldcount = $fieldcount + 1;
                }
            }//end of if(!empty($_POST[cell]))

            if(!empty($_POST['email'])) {
                $email = $_POST['email'];
                if($fieldcount == 0) {
                    $custquery .= "email1='$email'";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $custquery .= " AND email1='$email'";
                    $fieldcount = $fieldcount + 1;
                }
            }//end if(!empty($_POST['email']))

            //Add a sort clause
            $custquery .= ' ORDER BY last_name';

            //debugging
            //echo $custquery;
            try {
                $pdo = new PDO('mysql:dbname=dealer;host=localhost','alex@localhost','munsey123');
                $stmt = $pdo->prepare($custquery);
                $stmt->execute();

                //if no errors spit out customer table header
                ctableheader();
                while($row = $stmt->fetch(PDO::FETCH_NUM)) {
                    echo "<tr><td align=\"left\">$row[0]</td><td align=\"left\">$row[1]</td><td align=\"left\">$row[2]</td><td align=\"left\">$row[3]</td><td align=\"left\">$row[4]</td><td align=\"left\">$row[5]</td><td align=\"left\">$row[6]</td><td><a href=\"attach.php?v=$vehicle\">Yes</a></td><td><a href=\"sale.php?c=$row[0]&v=$vehicle\">Yes</a></td></tr>\n";
                }
                echo '</tbody></table>';

            } catch(PDOException $e) {
                echo '<p id="error">An error occured '.$e->getMessage().'</p>';
            }

        }
    } elseif(isset($_POST['cust_id'])) {
        //echo 'This is going to be a vehicle search';
        //Check to make sure at least one field is filled in
        $customer_id = $_POST['cust_id'];
        if( (empty($_POST['stock'])) && ($_POST['make'] == 'nomake') && ($_POST['model'] == 'nomodel') && ($_POST['min_year'] == 'nominyear') && ($_POST['max_year'] == 'nomaxyear') && (empty($_POST['min_mileage'])) && (empty($_POST['max_mileage'])) && (empty($_POST['min_price'])) && (empty($_POST['max_price']))) {
            echo '<p id="error">You must fill in at least one search critera</p>';
            display_customer($customer_id);
            display_vehicle_search($customer_id);
        } else {
            //echo '<p>We is gonna do a search again</p>';
            //echo "The customer number is $customer_id";
            display_customer($customer_id);
            echo '<hr/>';
            //Initialize a field count variable that determines when to use AND in the query
            $fieldcount = 0;
            //Start the query 
            $vehquery = 'SELECT vehicle_id,vin,stock,make,model,year,mileage,list_price FROM vehicles WHERE ';

            //Grab stock number if filled in
            if(!empty($_POST['stock'])) {
                $stockno = $_POST['stock'];
                if($fieldcount == 0) {
                    $vehquery .= "stock='$stockno'";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $vehquery .= " AND stock='$stockno'";
                    $fieldcount = $fieldcount + 1;
                }
            } //end of if(!empty($_POST['stock']))

            if($_POST['make'] != 'nomake') {
                    $make = $_POST['make'];
                    if($fieldcount == 0) {
                        $vehquery .= "make='$make'";
                        $fieldcount = $fieldcount + 1;
                    } else {
                        $vehquery .= " AND make='$make'";
                        $fieldcount = $fieldcount + 1;
                    }
            } //end if($_POST['make'] != 'nomake')

            if($_POST['model'] != 'nomodel') {
                $model = $_POST['model'];
                if($fieldcount == 0) {
                    $vehquery .= "model='$model'";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $vehquery .= " AND model='$model'";
                    $fieldcount = $fieldcount + 1;
                }
            } //END IF($_POST['model'] != 'nomodel

            if($_POST['min_year'] != 'nominyear') {
                $min_year = $_POST['min_year'];
                if($fieldcount == 0) {
                    $vehquery .= "year >= $min_year";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $vehquery .= " AND year >= $min_year";
                    $fieldcount = $fieldcount + 1;
                }
            } //end if($_POST['min_year] != 'nominyear')

            if($_POST['max_year'] != 'nomaxyear') {
                $max_year = $_POST['max_year'];
                if($fieldcount == 0) {
                    $vehquery .= "year <= $max_year";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $vehquery .= " AND year <= $max_year";
                    $fieldcount = $fieldcount + 1;
                }
            } //end if($_POST['max_year'] != 'nomaxyear')

            if(!empty($_POST['min_mileage'])) {
                $mini_mileage = $_POST['min_mileage'];
                if($fieldcount == 0) {
                    $vehquery .= "mileage >= $mini_mileage";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $vehquery .= " AND mileage >= $mini_mileage";
                    $fieldcount = $fieldcount + 1;
                }
            } //end if(!empty($_POST['min_mileage']))

            if(!empty($_POST['max_mileage'])) {
                $maxi_mileage = $_POST['max_mileage'];
                if($fieldcount == 0) {
                    $vehquery .= "mileage <= $maxi_mileage";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $vehquery .= " AND mileage <= $maxi_mileage";
                    $fieldcount = $fielcount + 1;
                }
            } //end if(!empty($_POST['max_mileage]))

            if(!empty($_POST['min_price'])) {
                $price_floor = $_POST['min_price'];
                if($fieldcount == 0) {
                    $vehquery .= "list_price >= $price_floor";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $vehquery .= " AND list_price >= $price_floor";
                    $fieldcount = $fieldcount + 1;
                }
            } //end if(!empty($_POST['min_price']))

            if(!empty($_POST['max_price'])) {
                $price_ceiling = $_POST['max_price']; 
                    if($fieldcount == 0) {
                        $vehquery .= "list_price <= $price_ceiling";
                        $fieldcount = $fieldcount + 1;
                    } else {
                        $vehquery .= " AND list_price <= $price_ceiling";
                        $fieldcount = $fieldcount + 1;
                    }
                } //end if(!empty($_POST['max_price']))

                //Order results by list price
                $vehquery .= ' ORDER BY list_price';

                //Debugging line
                //echo $vehquery;
                try {
                    $pdo = new PDO('mysql:dbname=dealer;host=localhost','alex@localhost','munsey123');
                    $stmt = $pdo->prepare($vehquery);
                    $stmt->execute();

                    //If all is good, spit out table header
                    vtableheader();
                    while($results = $stmt->fetch(PDO::FETCH_NUM)) {
                        echo "<tr><td align=\"left\">$results[0]</td><td align=\"left\">$results[1]</td><td align=\"left\">$results[2]</td><td align=\"left\">$results[3]</td><td align=\"left\">$results[4]</td><td align=\"left\">$results[5]</td><td align=\"left\">".number_format($results[6])."</td><td align=\"left\">".'$'.number_format($results[7],2,'.',',')."</td><td><a href=\"attach.php?c=$customer_id\">Yes</a></td><td><a href=\"sale.php?c=$customer_id&v=$results[0]\">Yes</a></td></tr>";
                    }
                } catch(PDOException $e) {
                    echo '<p id="error">An error occured '.$e->getMessage().'</p>';
                }
            }

        }
    } //end of if($_SERVER['REQUEST_METHOD] == 'POST') - line31

function display_customer($customer) {
        $display = '';
    try {
        $pdo = new PDO('mysql:dbname=dealer;host=localhost','alex@localhost','munsey123');

        $q = 'SELECT first_name,last_name,address1,city,province,post_code,main_phone,email1 FROM customers WHERE cust_id='.$customer;
        $r = $pdo->query($q);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        while($row = $r->fetch()) {

            $display = '<p><strong>First Name: </strong>'.$row['first_name'].'</p>';
            $display .= '<p><strong>Last Name: </strong>'.$row['last_name'].'</p>';
            $display .= '<p><strong>Address: </strong>'.$row['address1'].'</p>';
            $display .= '<p><strong>City: </strong>'.$row['city'].'</p>';
            $display .= '<p><strong>Province: </strong>'.$row['province'].'</p>';
            $display .= '<p><strong>Postal Code: </strong>'.$row['post_code'].'</p>';
            $display .= '<p><strong>Phone: </strong>'.$row['main_phone'].'</p>';
            $display .= '<p><strong>Email: </strong>'.$row['email1'].'</p>';
        }
    } catch(PDOException $e) {
        echo '<p id="error">An error occured: '.$e->getMessage().'</p>';
    }

    echo $display;
    unset($pdo);
} //end of display_customer($customer)

function display_vehicle_search($customer) {
    echo '<form action="attach.php" method="post"><fieldset><legend>Search A Vehicle</legend>';
    echo '<input type="hidden" name="cust_id" id="cust_id" value="'.$customer.'">';
    echo '<p><label for="stock">Stock No.</label><input type="text" name="stock" id="stock" size="25" maxlength="25"></p>';
    echo '<p><label for="make">Make:</label><select name="make" id="make"><option value="nomake">--Select Make--</option>';
    
    try {
        $pdo = new PDO('mysql:dbname=dealer;host=localhost','alex@localhost','munsey123');
        $qmake = 'SELECT make FROM makes ORDER BY make';
        $rmake = $pdo->query($qmake);
        $rmake->setFetchMode(PDO::FETCH_NUM);
        while($makes = $rmake->fetch()) {
            echo '<option value="'.$makes[0].'">'.$makes[0].'</option>';
        }
    } catch(PDOException $e) {
        echo '<p id="error">An error occured: '.$e->getMessage().'</p>';
    }
    echo '</select></p>';
    echo '<p><label for="model">Model:</label><select name="model" id="model"><option value="nomodel">--Select Model--</option>';
    try {
        $qmodel = 'SELECT description FROM models ORDER BY description';
        $rmodel = $pdo->query($qmodel);
        $rmodel->setFetchMode(PDO::FETCH_NUM);
        while($models = $rmodel->fetch()) {
            echo '<option value="'.$models[0].'">'.$models[0].'</option>';
        }
    } catch (PDOException $e) {
        echo '<p id="error">An error occured: '.$e->getMessage().'</p>';
    }

    echo '</select></p>';
    echo '<p><label for="min_year">Min Year</label><select name="min_year" id="min_year"><option value="nominyear">--Select Year--</option>';
    $current_year = date("Y");
    $oldest_year = $current_year - 20;
    $all_years = [];
    $x = $current_year;
    while($x >= $oldest_year) {
        $all_years[] = $x;
        $x = $x - 1;
    }

    foreach($all_years as $list_year) {
        echo '<option value="'.$list_year.'">'.$list_year.'</option>';
    }
    echo '</select></p>';
    echo '<p><label for="max_year">Max Year</label><select name="max_year" id="max_year"><option value="nomaxyear">--Select Year--</option>';
    foreach($all_years as $list_year) {
        echo '<option value="'.$list_year.'">'.$list_year.'</option>';
    }

    echo '</select></p>';
    echo '<p><label for="min_mileage">Min Mileage</label><input type="number" name="min_mileage" id="min_mileage" min="500" max="400000"></p>';
    echo '<p><label for="max_mileage">Max Mileage</label><input type="number" name="max_mileage" id="max_mileage" min="500" max="400000"></p>';
    echo '<p><label for="min_price">Min Price</label><input type="number" name="min_price" id="min_price" min="100" max="1000000"></p>';
    echo '<p><label for="max_price">Max Price</label><input type="number" name="max_price" id="max_price" min="100" max="1000000"></p>';
    echo '<p><input type="submit" name="submit" value="Search Vehicle"></p>';
    echo '</fieldset></form>';

    unset($pdo);
} //end of function display_vehicle_search($customer)

function vtableheader() {
    $theader = '<table width="75%">'."\n<thead>\n<tr>\n";
    $theader .= '<th align="left"><strong>Vehicle ID</strong></th>';
    $theader .= '<th align="left"><strong>VIN</strong></th>';
    $theader .= '<th align="left"><strong>Stock #</strong></th>';
    $theader .= '<th align="left"><strong>Make</strong></th>';
    $theader .= '<th align="left"><strong>Model</strong></th>';
    $theader .= '<th align="left"><strong>Year</strong></th>';
    $theader .= '<th align="left"><strong>Mileage</strong></th>';
    $theader .= '<th align="left"><strong>Price</strong></th>';
    $theader .= '<th align="left"><strong>Start Over</strong></th>';
    $theader .= '<th align="left"><strong>Confirm</strong><th>';
    $theader .= "\n</tr>\n</thead>\n<tbody>";

    echo $theader;
}

function ctableheader() {
    $cheader = '<table width="75%">'."\n<thead>\n<tr>\n";
    $cheader .= '<th align="left"><strong>Customer No.</strong></th>';
    $cheader .= '<th align="left"><strong>First Name</strong></th>';
    $cheader .= '<th align="left"><strong>Last Name</strong></th>';
    $cheader .= '<th align="left"><strong>City</strong></th>';
    $cheader .= '<th align="left"><strong>Home Phone</strong></th>';
    $cheader .= '<th align="left"><strong>Cell Phone</strong></th>';
    $cheader .= '<th align="left"><strong>Email</strong></th>';
    $cheader .= '<td align="left"><strong>Start Over</strong></th>';
    $cheader .= '<td align="left"><strong>Confirm</strong></th>';
    $cheader .= "\n</tr>\n</thead>\n<tbody>";

    echo $cheader;

}

function display_vehicle($vehicle) {
    $vehicle_display = '';
    try {
        $pdo = new PDO('mysql:dbname=dealer;host=localhost','alex@localhost','munsey123');
        $vquery = 'SELECT vin,stock,make,model,year,mileage,list_price FROM vehicles WHERE vehicle_id='.$vehicle;
        //echo $vquery;
        $vr = $pdo->query($vquery);
        $vr->setFetchMode(PDO::FETCH_ASSOC);
        while($row = $vr->fetch()) {

            //7 fields to show - vin, stock, make, model, year, mileage, list_price.
            $vehicle_display = '<p><strong>VIN: </strong>'.$row['vin'].'</p>';
            $vehicle_display .= '<p><strong>Stock #: </strong>'.$row['stock'].'</p>';
            $vehicle_display .= '<p><strong>Make: </strong>'.$row['make'].'</p>';
            $vehicle_display .= '<p><strong>Model: </strong>'.$row['model'].'</p>';
            $vehicle_display .= '<p><strong>Year: </strong>'.$row['year'].'</p>';
            $vehicle_display .= '<p><strong>Mileage: </strong>'.number_format($row['mileage']).'</p>';
            $vehicle_display .= '<p><strong>List Price: </strong>$'.number_format($row['list_price'],2,'.',',').'</p>';
        }
    } catch(PDOException $e) {
        echo '<p id="error">An error occured: '.$e->getMessage().'</p>';
    }

    echo $vehicle_display;
    unset($pdo);
} //end function display_vehicle($vehicle)

function display_customer_search($vehicle) {
    echo '<form action="attach.php" method="post"><fieldset><legend>Search A Customer</legend>';
    echo '<input type="hidden" name="vehicle_id" id="vehicle_id" value="'.$vehicle.'">';
    echo '<p><label for="last">Last Name:</label><input type="text" name="last" id="last" size="50" maxlength="50"></p>';
    echo '<p><label for="phone">Phone:</label><input type="text" name="phone" id="phone" size="12" maxlength="12"> Please enter a 10 digit number with no dashes or parentheses</p>';
    echo '<p><label for="cell">Cell:</label><input type="text" name="cell" id="cell" size="12" maxlength="12"> Please enter a 10 digit number with no dashes or parentheses</p>';
    echo '<p><label for="email">Email:</label><input type="text" name="email" id="email" size="100" maxlength="100">';
    echo '<p><input type="submit" name="submit" value="Search"></p>';
    echo '</fieldset></form>';

} //end function display_customer_search($vehicle)

?>
</div>
</body>
</html>
