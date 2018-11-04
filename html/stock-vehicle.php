<?php

//Create date May 15, 2018

//To do list - see if we can use the if (isset($_POST)) in a select statement?? 

$page_title="Stock-In Vehicle";
include ('includes/header.html');
require ('../mysqli_connect.php');
?>

<div class="content">
<h1>Stock Vehicle</h1>
<p><strong>Fields marked with an asterisk are mandatory</strong></p>

<form action="stock-vehicle.php" method="post">
    <fieldset>
        <legend>Add A Vehicle</legend>
        <p><label for="vin">VIN(*):</label>
        <input type="text" name="vin" id="vin" size="17" maxlength="17" value="<?php if (isset($_POST['vin'])) echo $_POST['vin']; ?>" required></p>
        <p><label for="stock">Stock No.(*):</label>
        <input type="text" name="stock" id="stock" size="25" maxlength="25" value="<?php if (isset($_POST['stock'])) echo $_POST['stock']; ?>" required></p>
        <p><label for="make">Make:</label>
        <select name="make" id="make">
        <?php 
        //Create Make list for Select field
        $qm = "SELECT make FROM makes ORDER BY make";
        $r = @mysqli_query($dbc,$qm);
        while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
            echo '<option value="'.$row['make'].'">'.$row['make'].'</option>';
        }
        ?>
        </select></p>
        
        <p><label for="model">Model:</label>
        <select name="model" id="model">
        <?php
            //Create model list
            $qmm = 'SELECT description FROM models ORDER BY description';
            $r = @mysqli_query($dbc,$qmm);
            while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
                echo '<option value="'.$row['description'].'">'.$row['description'].'</option>';
            }
            ?>
            </select></p>
        <p><label for="year">Year(*):</label>
        <input type="text" name="year" id="year" size="4" maxlength="4" value="<?php if (isset($_POST['year'])) echo $_POST['year']; ?>" required></p>
        <p><label for="colour">Colour:</label>
        <input type="text" name="colour" id="colour" size="35" maxlength="35" value="<?php if (isset($_POST['colour'])) echo $_POST['colour']; ?>"></p>
        <p><label for="mileage">Mileage(*) (500km-400,000km):</label>
        <input type="number" name="mileage" id="mileage" min="500" max="400000" step="500" value="<?php if (isset($_POST['mileage'])) echo $_POST['mileage']; ?>" required></p>
        <p><label for="original_sold_date">Orig. Sold Date:</label>
        <input type="date" name="original_sold_date" id="original_sold_date" size="12" maxlength="12" value="<?php if (isset($_POST['original_sold_date'])) echo $_POST['original_sold_date']; ?>"></p>
        <p><label for="warranty_expiry">Warranty Expiry:</label>
        <input type="date" name="warranty_expiry" id="warranty_expiry" size="12" maxlength="12" value="<?php if (isset($_POST['warranty_expiry'])) echo $_POST['warranty_expiry']; ?>"></p>
        <p><label for="num_previous_owners"># of Prev. Owners (1-10):</label>
        <input type="number" name="num_previous_owners" id="num_previous_owners" min="1" max="10" value="<?php if (isset($_POST['num_previous_owners'])) echo $_POST['num_previous_owners']; ?>"></p>
        
        <p><label for="status">Status:</label>
        <select name="status" id="status">
            <option value="available">Available</option>
            <option value="pending">Pending</option>
            <option value="test drive"> Test Drive</option>
            <option value="offer">Offer</option>
            <option value="sold">Sold</option>
    </select></p>

        <p><label for="engine_type">Engine Type:</label>
        <select name="engine_type" id="engine_type">
            <option value="combustion">Combustion</option>
            <option value="hybrid">Hybrid</option>
            <option value="electric">Electric</option>
    </select></p>

        <p><label for="drive_type">Drive Type:</label>
        <select name="drive_type" id="drive_type">
            <option value="4WD">4WD</option>
            <option value="2WD FRONT" selected="selected">2WD Front</option>
            <option value="2WD REAR">2WD Rear</option>
            <option value="AWD">AWD</option>
            <option value="N/A">N/A</option>
    </select></p>

        <p><label for="cylinders">Cylinders (1-16):</label>
        <input type="number" name="cylinders" id="cylinders" min="1" max="16" value="<?php if (isset($_POST['cylinders'])) echo $_POST['cylinders']; ?>"></p>    
        <p><label for="horsepower">Horsepower (50hp-2,000hp):</label>
        <input type="number" name="horsepower" id="horsepower" min="50" max="2000" value="<?php if (isset($_POST['horsepower'])) echo $_POST['horsepower']; ?>"></p>
        
        <p><label for="transmission">Transmission:</label>
        <select name="transmission" id="transmission">
            <option value="automatic">Automatic</option>
            <option value="manual">Manual</option>
            <option value="none">None</option>
        </select></p>
        
        <p><label for="speeds">Speeds (1-18):</label>
        <input type="number" name="speeds" id="speeds" min="1" max="18" value="<?php if (isset($_POST['speeds'])) echo $_POST['speeds']; ?>"></p>
        <p><label for="fuel_hwy">Highway Fuel (10km-1,00km):</label>
        <input type="number" name="fuel_hwy" id="fuel_hwy" min="10" max="1000" step="0.10" value="<?php if (isset($_POST['fuel_hwy'])) echo $_POST['fuel_hwy']; ?>"></p>
        <p><label for="fuel_city">City Fuel (10km-1,000km):</label>
        <input type="number" name="fuel_city" id="fuel_city" min="10" max="1000" step="0.10" value="<?php if (isset($_POST['fuel_city'])) echo $_POST['fuel_city']; ?>"></p>
        <p><label for="seats">Seats (2-50):</label>
        <input type="number" name="seats" id="seats" min="2" max="50" step="1" value="<?php if (isset($_POST['seats'])) echo $_POST['seats']; ?>"></p>
        <p><label for="doors">Doors (2-10):</label>
        <input type="number" name="doors" id="doors" min="2" max="10" value="<?php if (isset($_POST['doors'])) echo $_POST['doors']; ?>"></p>
        <p><label for="electric_range">Battery Range (50km-2,000km):</label>
        <input type="number" name="electric_range" id="electric_range" min="50" max="2000" step="50" value="<?php if (isset($_POST['electric_range'])) echo $_POST['electric_range']; ?>"> Electric Vehicles Only</p>
        <p><label for="motor_size">Battery Size (50Kw-1,000Kw):</label>
        <input type="number" name="motor_size" id="motor_size" min="50" max="1000" step="20" value="<?php if (isset($_POST['motor_size'])) echo $_POST['motor_size']; ?>"> Electric Vehicle Only</p>
        <p><label for="chg120">Charge Time at 120V (10-36):</label>
        <input type="number" name="chg120" id="chg120" min="10" max="30" value="<?php if (isset($_POST['chg120'])) echo $_POST['chg120']; ?>"> Electric Vehicle Only</p>
        <p><label for="chg240">Charge Time at 240V (1-24):</label>
        <input type="number" name="chg240" id="chg240" min="1" max="24" value="<?php if (isset($_POST['chg240'])) echo $_POST['chg240']; ?>"> Electric Vehicle Only</p>
        <p><label for="purchase_price">Purchase Price ($100-$500,000):</label>
        <input type="number" name="purchase_price" id="purchase_price" min="100" max="500000" step="0.5" value="<?php if(isset($_POST['purchase_price'])) echo $_POST['purchase_price'];?>"></p>
        <p><label for="list_price">List Price ($100-$1 million):</label>
        <input type="number" name="list_price" id="list_price" min="100" max="1000000" step="0.5" value="<?php if(isset($_POST['list_price'])) echo $_POST['list_price'];?>"></p>
        <p><label for="inventory">Inventory Account:</label>
        <select name="inventory" id="inventory">
            <?php
            //Grab list of inventory account from coa where type_id=11
            $qi = "SELECT account,description FROM coa WHERE type_id=11";
            $r = @mysqli_query($dbc,$qi);
            while($row = mysqli_fetch_row($r)) {
                echo '<option value="'.$row[0].'">'.$row[0].'-'.$row[1].'</option>';
            }
            ?>
            </select></p>

        <p><input type="submit" name="submit" value="Save"></p>
    </fieldset>
</form>

<?php
//Initialize errors array
$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(empty($_POST['vin'])) {
        $errors[] = 'The VIN is a mandatory field';
    } else {
        $vin = mysqli_real_escape_string($dbc,trim($_POST['vin']));
    }

    if(empty($_POST['stock'])) {
        $errors[] = 'The Stock Number is a mandatory field';
    } else {
        $stock = $_POST['stock'];
    }

    if(empty($_POST['year'])) {
        $errors[] = 'The year is amandatory field';
    } else {
        $year = mysqli_real_escape_string($dbc,trim($_POST['year']));
    }

    if(empty($_POST['mileage'])) {
        $errors[] = 'The mileage is a mandatory field';
    } else {
        $mileage = mysqli_real_escape_string($dbc,trim($_POST['mileage']));
    }

    if(empty($_POST['purchase_price'])) {
        $errors[] = 'The Purchase Price is a mandatory field';
    } else {
        $purchase = mysqli_real_escape_string($dbc,trim($_POST['purchase_price']));
    }

    if(empty($_POST['list_price'])) {
        $errors[] = 'The List Price is a mandatory field';
    } else {
        $list = mysqli_real_escape_string($dbc,trim($_POST['list_price']));
    }

    //Grab non-mandatory fields

    if(!empty($_POST['make'])) {
        $make = mysqli_real_escape_string($dbc,trim($_POST['make']));
    }

    if(!empty($_POST['model'])) {
        $model = mysqli_real_escape_string($dbc,trim($_POST['model']));
    }

    if(!empty($_POST['colour'])) {
        $colour = mysqli_real_escape_string($dbc,trim($_POST['colour']));
    }

    if(!empty($_POST['original_sold_date'])) {
        $solddate = mysqli_real_escape_string($dbc,trim($_POST['original_sold_date']));
        $solddate = "'".$solddate."'";
    } else {
        $solddate = 'null';
    }

    if(!empty($_POST['warranty_expiry'])) {
        $warranty = mysqli_real_escape_string($dbc,trim($_POST['warranty_expiry']));
        $warranty = "'".$warranty."'";
    } else {
        $warranty = 'null';
    }

    if(!empty($_POST['num_previous_owners'])) {
        $previous = mysqli_real_escape_string($dbc,trim($_POST['num_previous_owners']));
    } else {
        $previous = 'null';
    }

    if(!empty($_POST['status'])) {
        $status = mysqli_real_escape_string($dbc,trim($_POST['status']));
    }

    if(!empty($_POST['engine_type'])) {
        $engine = mysqli_real_escape_string($dbc,trim($_POST['engine_type']));
    }

    if(!empty($_POST['drive_type'])) {
        $dtype = mysqli_real_escape_string($dbc,trim($_POST['drive_type']));
    }

    if(!empty($_POST['cylinders'])) {
        $cylinders = mysqli_real_escape_string($dbc,trim($_POST['cylinders']));
    } else {
        $cylinders = 'null';
    }

    if(!empty($_POST['horsepower'])) {
        $horsies = mysqli_real_escape_string($dbc,trim($_POST['horsepower']));
    } else {
        $horsies = 'null';
    }

    if(!empty($_POST['transmission'])) {
        $transmission = mysqli_real_escape_string($dbc,trim($_POST['transmission']));
    }

    if(!empty($_POST['speeds'])) {
        $speeds = mysqli_real_escape_string($dbc,trim($_POST['speeds']));
    } else {
        $speeds = 'null';
    }

    if(!empty($_POST['fuel_hwy'])) {
        $hwyfuel = mysqli_real_escape_string($dbc,trim($_POST['fuel_hwy']));
    } else {
        $hwyfuel = 'null';
    }

    if(!empty($_POST['fuel_city'])) {
        $cityfuel = mysqli_real_escape_string($dbc,trim($_POST['fuel_city']));
    } else {
        $cityfuel = 'null';
    }

    if(!empty($_POST['seats'])) {
        $seats = mysqli_real_escape_string($dbc,trim($_POST['seats']));
    } else {
        $seats = 'null';
    }

    if(!empty($_POST['doors'])) {
        $doors = mysqli_real_escape_string($dbc,trim($_POST['doors']));
    } else {
        $doors = 'null';
    }

    if(!empty($_POST['electric_range'])) {
        $electricrange = mysqli_real_escape_string($dbc,trim($_POST['electric_range']));
    } else {
        $electricrange = 'null';
    }

    if(!empty($_POST['motor_size'])) {
        $kwh = mysqli_real_escape_string($dbc,trim($_POST['motor_size']));
    } else {
        $kwh = 'null';
    }

    if(!empty($_POST['chg120'])) {
        $chg120 = mysqli_real_escape_string($dbc,trim($_POST['chg120']));
    } else {
        $chg120 = 'null';
    }

    if(!empty($_POST['chg240'])) {
        $chg240 = mysqli_real_escape_string($dbc,trim($_POST['chg240']));
    } else {
        $chg240 = 'null';
    }

    $account = $_POST['inventory'];

    if(empty($errors)) {
        $query = 'INSERT INTO vehicles (vin,stock,make,model,year,colour,mileage,original_sold_date,warranty_expiry,num_previous_owners,status,engine_type,drive_type,cylinders,horsepower,transmission,speeds,fuel_hwy,fuel_city,seats,doors,electric_range,motor_size,chg120,chg240,purchase_price,list_price,inventory_account)';
        $query .= " VALUES ('$vin','$stock','$make','$model',$year,'$colour',$mileage,$solddate,$warranty,$previous,'$status','$engine','$dtype',$cylinders,$horsies,'$transmission',$speeds,$hwyfuel,$cityfuel,$seats,$doors,$electricrange,$kwh,$chg120,$chg240,$purchase,$list,$account)";
        //echo $query;
        $r = @mysqli_query($dbc,$query);
        
        if($r) {
            echo '<p>Vehicle Saved!';
        } else {
            echo '<p id="error">An unkonwn error occured. Please contact support</p>';
        }
    } else {
        echo '<h2 id="error">Error!</h2>';
        echo "<p><strong>The following eror(s) occured:</strong></p>";
        echo '<ul>';
        foreach($errors as $msg) {
            echo '<li>'.$msg.'</li>';
        }
        echo '</ul>';
    } 

}

?>
</div>
</body>
</html>
