<?php
//Create date May 16, 2018
$page_title="Search Vehicles";
include ('includes/header.html'); //Menu header
require ('../mysqli_connect.php'); //Database connection
?>

<div class="content">
    <h1>Search Vehicles</h1>
<form action="search-vehicles.php" method="post">
    <fieldset>
        <legend>Search A Vehicle</legend>
        <p><label for="stock">Stock No.:</label>
        <input type="text" name="stock" id="stock" size="25" maxlength="25"></p>
        <p><label for="make">Make:</label>
        <select name="make" id="make"><option value="nomake">--Select Make--</option>
        <?php
            //Grab list of makes from the database
            $q = 'SELECT make FROM makes ORDER BY make';
            $r = @mysqli_query($dbc,$q);
            while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
                echo '<option value="'.$row['make'].'">'.$row['make'].'</option>';
            }
        ?>
        </select></p>
        <p><label for="model">Model:</label>
        <select name="model" id="model"><option value="nomodel">--Select Model--</option>
        <?php 
        //Grab list of makes from the database
        $q = 'SELECT description FROM models ORDER BY description';
        $r = @mysqli_query($dbc,$q);
        while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
            echo '<option value="'.$row['description'].'">'.$row['description'].'</option>';
        }
        ?>
        </select></p>
        <p><label for="min_year">Min Year:</label>
        <select name="min_year" id="min_year"><option value="nominyear">--Select Year--</option>
        <?php 
        //Initialize beginning and ending year going back 20 years
        $current_year = date("Y");
        $oldest_year = $current_year - 20;
        $all_years = [];
        $x = $current_year;
        //Populate an array with all years from current year and going back 20 years
        //This array will be used in a foreach loop for both min & max years
        while ($x >= $oldest_year) {
            $all_years[] = $x;
            $x = $x - 1;
        }

        foreach($all_years as $list_years) {
            echo '<option value="'.$list_years.'">'.$list_years.'</option>';
        }
        ?>
        </select></p>
        <p><label for="max_year">Max Year:</label>
        <select name="max_year" id="max_year"><option value="nomaxyear">--Select Year--</option>
            <?php
            foreach ($all_years as $list_years) {
                echo '<option value="'.$list_years.'">'.$list_years.'</option>';
            }
            ?>
        </select></p>
        <p><label for="min_mileage">Minimum Mileage (500km-400,000km):</label>
        <input type="number" name="min_mileage" id="min_mileage" min="500" max="400000"></p>
        <p><label for="max_mileage">Maximum Mileage (500km-400,000km):</label>
        <input type="number" name="max_mileage" id="max_mileage" min="500" max="400000"></p>
        <p><label for="min_price">Minimum Price:</label>
        <input type="number" name="min_price" id="min_price" min="100" max="1000000" step="50"></p>
        <p><label for="max_price">Maximum Price:</label>
        <input type="number" name="max_price" id="max_price" min="100" max="1000000" step="50"></p>
        <p><input type="submit" name="submit" value="Search"></p>
    </fieldset>        
</form>

<?php
    //If stock number is filled in then we can start search right away as there will only be one result
    if($_SERVER['REQUEST_METHOD'] == 'POST' && (!empty($_POST['stock']))) {
        echo "<p>There is 1 vehicle that matches your search criteria</p>";
        $stockno = $_POST['stock'];
        $q = "SELECT vehicle_id,vin,stock,make,model,year,mileage,list_price FROM vehicles WHERE stock='$stockno'";
        //echo $q;
        $r = @mysqli_query($dbc,$q);
        tableheader();
        while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
            echo '<tr><td align="left">'.$row['vin'].'</td><td align="left">'.$row['stock'].'</td><td align="left">'.$row['make'].'</td><td align="left">'.$row['model'].'</td><td align="left">'.$row['year'].'</td><td align="left">'.number_format($row['mileage']).'</td><td align="left">'.'$'.number_format($row['list_price'],2,'.',',').'</td><td><a href="view-vehicle.php?vehid='.$row['vehicle_id'].'">View Vehicle</a></td><td><a href="attach.php?v='.$row['vehicle_id'].'">Start Sale</a></td></tr>'."\n";
        }
        echo '</tbody></table>';
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //if nothing has been filled in warn user and stop
        if((empty($_POST['stock'])) && ($_POST['make'] == 'nomake') && ($_POST['model'] == 'nomodel') && ($_POST['min_year'] == 'nominyear') && ($_POST['max_year'] == 'nomaxyear') && (empty($_POST['min_mileage'])) && (empty($_POST['max_mileage'])) && (empty($_POST['min_price'])) && (empty($_POST['max_price']))) {
            echo '<p><strong>You must fill in at least one search criteria</strong></p>';
        } else { 
            //Construct query based on what was selected
            //Initialize a field count to determine how many fields have been filled in
            $fieldcount = 0;
            //Start the query
            $q = "SELECT vehicle_id,vin,stock,make,model,year,mileage,list_price FROM vehicles WHERE";

            //Figure out which fields have been filled in 
            if($_POST['make'] != 'nomake') { //A make has been selected
                //Grab the value and store it
                $make = mysqli_real_escape_string($dbc,trim($_POST['make']));
                //If this is all that is selected, we don't need the AND 
                if($fieldcount == 0) {
                    $q .= " make='$make'";
                    $fieldcount = $fieldcount + 1;
                } else { //another field was select, include the AND
                    $q .= " AND make='$make'";
                    $fieldcount = $fieldcount + 1;
                }
            
            } //End of check on make

            if($_POST['model'] != 'nomodel') { //A model has been selected
                $model = mysqli_real_escape_string($dbc,trim($_POST['model']));

                if($fieldcount == 0) {
                    $q .= " model='$model'";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $q .= " AND model='$model'";
                    $fieldcount = $fieldcount + 1;
                }
            } //End of check on model

            if($_POST['min_year'] != 'nominyear') { //A minimum year has been selected
                $minyear = mysqli_real_escape_string($dbc,trim($_POST['min_year']));

                if($fieldcount == 0) {
                    $q .= " year >= $minyear";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $q .= " AND year >= $minyear";
                    $fieldcount = $fieldcount + 1;
                }
            } //End of check on minimum year

            if($_POST['max_year'] != 'nomaxyear') {
                $maxyear = mysqli_real_escape_string($dbc,trim($_POST['max_year']));

                if($fieldcount == 0) {
                    $q .= " year <= $maxyear";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $q .= " AND year <= $maxyear";
                    $fieldcount = $fieldcount + 1;
                }
            } //End of check on maximum year

            if(!empty($_POST['min_mileage'])) {
                $minmileage = mysqli_real_escape_string($dbc,trim($_POST['min_mileage']));

                if($fieldcount == 0) {
                    $q .= " mileage >= $minmileage";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $q .= " AND mileage >= $minmileage";
                    $fieldcount = $fieldcount + 1;
                }
            } //end of check on miminum mileage

            if(!empty($_POST['max_mileage'])) {
                $maxmileage = mysqli_real_escape_string($dbc,trim($_POST['max_mileage']));

                if($fieldcount == 0) {
                    $q .= " mileage <= $maxmileage";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $q .= " AND mileage <= $maxmileage";
                    $fieldcount = $fieldcount + 1;
                }
            } //end of check on maximum mileage

            if(!empty($_POST['min_price'])) {
                $minimumprice = mysqli_real_escape_string($dbc,trim($_POST['min_price']));

                if($fieldcount == 0) {
                    $q .= " list_price >= $minimumprice";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $q .= " AND list_price >= $minimumprice";
                    $fieldcount = $fieldcount + 1;
                }
            } //end of check on minimum price
            
            if(!empty($_POST['max_price'])) {
                $maximumprice = mysqli_real_escape_string($dbc,trim($_POST['max_price']));

                if($fieldcount == 0) {
                    $q .= " list_price <= $maximumprice";
                    $fieldcount = $fieldcount + 1;
                } else {
                    $q .= " AND list_price <= $maximumprice";
                    $fieldcount = $fieldcount + 1;
                }
            } //end of check on maximum price

            //Order results by List Price
            $q .= " ORDER BY list_price";
            //Execute query
            $r = @mysqli_query($dbc,$q);
            $number = mysqli_num_rows($r);
            echo "<p>There are $number record(s) that match your search criteria</p>";
            tableheader();
            while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
                echo '<tr><td align="left">'.$row['vin'].'</td><td align="left">'.$row['stock'].'</td><td align="left">'.$row['make'].'</td><td align="left">'.$row['model'].'</td><td align="left">'.$row['year'].'</td><td align="left">'.number_format($row['mileage']).'</td><td align="left">'.'$'.number_format($row['list_price'],2,'.',',').'</td><td><a href="view-vehicle.php?vehid='.$row['vehicle_id'].'">View Vehicle</a></td><td><a href="attach.php?v='.$row['vehicle_id'].'">Start Sale</a></td></tr>'."\n";
            }
            echo '</tbody></table>';
         } // end of else (line 84)

         //echo "<p>$q</p>";
    } //end of elseif ($_SERVER['REQUEST_METHOD'] == 'POST')

    function tableheader() {
        //spit out table headers before presenting results. This can get called by either:
            //if($_SERVER['REQUEST_METHOD'] == 'POST' && (!empty($_POST['stock']))) AND
            //if ($_SERVER['REQUEST_METHOD'] == 'POST)
        
        $theader =  "\n".'<table width="90%">'."\n<thead>\n"."\n<tr>\n";
        $theader .= '<th align="left"><strong>VIN</strong></th>';
        $theader .= '<th align="left"><strong>Stock #</strong></th>';
        $theader .= '<th align="left"><strong>Make</strong></th>';
        $theader .= '<th align="left"><strong>Model</strong></th>';
        $theader .= '<th align="left"><strong>Year</strong></th>';
        $theader .= '<th align="left"><strong>Mileage</strong></th>';
        $theader .= '<th align="left"><strong>Price</strong></th>';
        $theader .= '<th align="left"><strong>View</strong></th>';
        $theader .= '<th align="left"><strong>Start Sale</strong></th>';
        $theader .= "\n</tr>\n</thead>\n<tbody>";

        echo $theader;
    }
?>
    




</div>
</body>
</html>
