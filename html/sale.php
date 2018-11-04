<?php

$page_title = 'Vehicle Sale';
include('includes/header.html');
require('../db.inc.php');
?>

<div class="content">
    <h1>Vehicle Sale</h1>

    <?php
        //Two database queries will be required to display info - first customer, then vehicle, with price field editable
        //Script flag to control when the Javascript link gets generated
        $script_flag = null;

        if(empty($_GET['c']) && empty($_GET['v'])) {
            //Only spit out the search form if the page has been accessed directly
            if($_SERVER['REQUEST_METHOD'] == 'GET') {
                echo '<form action="sale.php" method="post"><fieldset>';
                //A hidden field used to determine if the page was accessed directly. Or from the search pages
                //If the latter, there would be a ?c=xx&v=xx passed in the URL 
                echo '<input type="hidden" name="direct" id="direct" value="direct">';
                echo '<p><label for="cust_id">Customer ID:</label><input type="text" name="cust_id" id="cust_id" size="8" required></p>';
                echo '<p><label for="vehicle_id">Vehicle ID:</label><input type="text" name="vehicle_id" id="vehicle_id" size="10" required></p>';
                echo '<p><input type="submit" name="vehicle" value="Pull"></p>';
                echo '</fieldset></form>';
            }
            
        } else {
            $customer_id = $_GET['c'];
            $vehicle_id = $_GET['v'];
            $script_flag = true;
            //echo "The customer is $customer_id and the vehicle is $vehicle_id";
            display_customer($customer_id);
            display_vehicle($vehicle_id);
            
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //There are three forms on this page - Pull Vehicle, Pull Customer and Save. Need form
            //handling for all three

            if(!empty($_POST['direct'])){ 
                $customer_id = $_POST['cust_id'];
                $vehicle_id = $_POST['vehicle_id'];
                $script_flag = true;
                display_customer($customer_id);
                display_vehicle($vehicle_id);
            }
        } //end of if($_SERVER['REQUEST_METHOD] == 'POST')      


        function display_customer($customer_id) {
            $custquery = "SELECT cust_id,first_name,last_name,city,main_phone,cell_phone_1,email1 FROM customers WHERE cust_id=$customer_id";
            try {
                $pdo = connect();
                $stmt = $pdo->prepare($custquery);
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_NUM)) {
                    $custdisplay = '<p><strong>Customer No: </strong>'.$row[0].'</p>';
                    $custdisplay .= '<p><strong>Firstl Name: </strong>'.$row[1].'</p>';
                    $custdisplay .= '<p><strong>Last Name: </strong>'.$row[2].'</p>';
                    $custdisplay .= '<p><strong>City: </strong>'.$row[3].'</p>';
                    $custdisplay .= '<p><strong>Home Phone: </strong>'.$row[4].'</p>';
                    $custdisplay .= '<p><strong>Cell Phone: </strong>'.$row[5].'</p>';
                    $custdisplay .= '<p><strong>Email: </strong>'.$row[6].'</p>';
                }
            } catch(PDOException $e) {
                echo '<p id="error">An error occured '.$e->getMessage().'</p>';
            }
            echo $custdisplay;
            echo '<hr/>';

        } //end function display_customer($customer)

        function display_vehicle($vehicle_id) {

            //if($vehicle_id == '') echo 'There was no vehicle id passed in the query';

            echo '<form action="bos.php" name="sale" method="post"><fieldset><legend>Vehicle Sale</legend>';
            echo '<input type="hidden" name="sale" id="sale" value="sale">';

            $vehquery = "SELECT vehicle_id,vin,stock,make,model,year,mileage,list_price FROM vehicles WHERE vehicle_id=$vehicle_id";
                //echo $vehquery;
                try {
                    $pdo = connect();
                    $r = $pdo->query($vehquery);
                    $r->setFetchMode(PDO::FETCH_NUM);
                    while($row = $r->fetch()) {
                        echo '<p><label for="vehid">Vehicle ID:</label><input type="text" name="vehid" id="vehid" size="5" value="'.$row[0].'" readonly></p>';
                        echo '<p><label for="vin">Vin:</label><input type="text" name="vin" id="vin" size="17" value="'.$row[1].'" readonly></p>';
                        echo '<p><label for="stock">Stock No:</label><input type="text" name="stock" id="stock" size="25" value="'.$row[2].'" readonly></p>';
                        echo '<p><label for="make">Make:</label><input type="text" name="make" id="make" size="50" value="'.$row[3].'" readonly></p>';
                        echo '<p><label for="model">Model:</label><input type="text" name="model" id="model" size="50" value="'.$row[4].'" readonly></p>';
                        echo '<p><label for="year">Year:</label><input type="text" name="year" id="year" size="4" value="'.$row[5].'" readonly></p>';
                        echo '<p><label for="mileage">Mileage:</label><input type="number" name="mileage" id="mileage" min="500" max="400000" value="'.$row[6].'" readonly></p>';
                        echo '<p><label for="price">Price:</label><input type="number" name="price" id="price" min="100" max="1000000" step="0.05" value="'.$row[7].'"></p>';
                        echo '<input type="hidden" name="originalprice" id="originalprice" value="'.$row[7].'">';
                    }
                    display_options();
                    $tax_rate = pull_tax_rate();
                    echo '<p><label for="taxrate"><strong>Tax Rate:</strong></label>'.'<input type="number" name="taxrate" id="taxrate" min="0.0000" max="99.9999" value="'.number_format($tax_rate,4,'.',',').'" readonly>';
                    echo '<p><label for="taxamount">Taxes:</label><input type="number" name="taxamount" id="taxamount" min="0.00" step="0.01"></p>';
                    echo '<p><label for="total"><strong>Grand Total:</strong></label>';
                    echo '<input type="number" name="total" id="total" min="100.00" max="5000000.00" step="0.01" value="" readonly></p>';
                    echo '<p><input type="submit" name="save" id="save" value="Save" disabled>';
                } catch(PDOException $e) {
                    echo '<p id="error">An error occured '.$e->getMessage().'</p>';
                }

                

                echo '</fieldset></form>';
                echo '<button name="calculate" id="calculate">Calculate</button>';
                echo '<button name="reset" id="reset">Reset</button>';

        } //end function display_vehicle($vehicle)

        function display_options() {
            echo '<fieldset><legend>Options</legend>';
            $groupName = 'options';
            $pdo = connect();
            $optquery = 'SELECT id,description,cost_amount,sale_amount,cost_account,sale_account FROM options';
            $stmt = $pdo->prepare($optquery);
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_NUM)) {
                echo '<p><input type="checkbox" name="'.$groupName.'" value="'.$row[0].'"> '.$row[1].' ';
                echo '<input type="text" name="sale_amt" id="sale_amt" value="'.$row[3].'" readonly>';
            }
            echo '<p><label for="optionsTotal">Options Total</label><input type="number" name="optionsTotal" id="optionsTotal" value="" readonly></p>';
            echo '</fieldset>';
        }

        function pull_tax_rate() {
            $taxq = 'SELECT rate FROM taxes WHERE id=1';
            $pdo = connect();
            $stmt = $pdo->prepare($taxq);
            $stmt->execute();
            $row = $stmt->fetch();
            return $row[0];
        }

        ?>
</div>
<?php
//If the user clicks Save, we cannot make a javascript reference.
//Otherwise we start generating Javascript errors.
//This will only happen if the GET is missing a value for 's'
if($script_flag == true)
echo '<script src="js/sale.js"></script>';
?>

</body>
</html>
