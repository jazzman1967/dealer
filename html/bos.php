<?php
require('../db.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Bill of Sale</title>
    </head>
    <body>
        <img src="images/car.png" width="150" height="100">
        <p><strong>Dealer Name:</strong> Clusterfuck Motors<strong> Dealer Address:</strong> 12254 Yorkdale Boulevard</p>
        <p><strong>Dealer City:</strong><strong>Dealer Province:</strong></p>
        <p><strong>Dealer Postal Code:</strong><strong>Dealer Phone:</strong></p>
        <p><strong>Dealer Website:</strong></p>

        <!--Purchaser Information-->
        <p id="date"><label for="day">Day: </label><input type="text" name="day" id="day" value=""><label for="month"> Month: </label><input type="text" name="month" id="month" value=""><label for="year"> Year: </label><input type="text" name="year" id="year" value=""></p>
        <p id="purchaser"><strong>Purchaser's Information</strong></p>
        <p><label for="first">First Name: </label><input type="text" name="first" id="first" length="50" value=""><label for="middle"> Middle Name: </label><input type="text" name="middle" id="middle" length="50" value=""><label for="last"> Last Name: </label><input type="text" name="last" id="last" length="50" value=""></p>
        <p><label for="address1">Address 1: </label><input type="text" name="address1" id="address1" length="100"><label for="address2"> Address 2: </label><input type="text" name="address2" id="address2" length="100" value=""></p>
        <p><label for="city">City: </label><input type="text" name="city" id="city" length="100" value=""><label for="province"> Province: </label><input type="text" name="province" id="province" length="27" value=""><label for="postal_code"> Postal Code: </label><input type="text" name="postal_code" id="postal_code" length="7" value=""></p>
        <p><label for="phone">Home Phone: </label><input type="text" name="phone" id="phone" length="10" value=""><label for="cell"> Cell Phone: </label><input type="text" name="cell" id="cell" value=""></p>
        <p><label for="license">Driver's License: </label><input type="text" name="license" id="license" value=""><label for="lic_expiry"> Expiry Date: </label><input type="date" name="lic_expiry" id="lic_expiry"></p>
        <p><label for="email1">Email Address: </label><input type="email" name="email1" id="email1" length="100" value=""></p>

        <!--Vehicle Information-->
        <p id="vehicle"><strong>Vehicle Information</strong></p>
        <p><label for="vyear">Year: </label><input type="text" name="vyear" id="vyear" length="4"><label for="make"> Make: </label><input type="text" name="make" id="make" length="50" value=""><label for="model"> Model: </label><input type="text" name="model" id="model" length="50" value=""><label for="trim"> Trim: </label><input type="text" name="trim" id="trim" value=""><label for="colour"> Colour: </label><input type="text" name="colour" id="colour" value=""><label for="stock"> Stock #: </label><input type="text" name="stock" id="stock" value=""></p>
        <p><label for="vin">VIN: </label><input type="text" name="vin" id="vin" length="34"></p>
        <p><label for="mileage">Mileage: </label><input type="number" name="mileage" id="mileage" min="500" max="400000" step="1"></p>
        <p><label for="sold_date">In-Service Date </label><input type="date" name="sold_date" id="sold_date"><label for="delivery"> Original Delivery Date: </label><input type="date" name="delivery" id="delivery"><label for="del_comments">Details of Delivery: </label><input type="text" name="del_comments" id="del_comments"></p>
        <p>Vehicle will be delivered with a Safety Standard Certificate: <label for="ssc_yes">Yes: </label><input type="checkbox" id="ssc_yes" value="Yes"><label for="ssc_no"> No: </label><input type="checkbox" id="ssc_no" value="No"></p>

<?php

//This is a form (without headers) to print off. Client signs and the confirm button 
//posts information to sales, general ledger, update chart of account balances, customers, vehicles. 
?>
</html>