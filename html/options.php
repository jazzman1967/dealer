<?php

$page_title = 'Create Vehicle Options';
require('../db.inc.php');
include('includes/header.html');

?>

<div class="content">
    <h1>Create Vehicle Options</h1>
    <form action="options.php" method="post">
        <fieldset>
            <legend>Create Vehicle Options</legend>
            <p><label for="id">Option ID:</label><input type="text" name="id" id="id" size="10" maxlength="10" value="<?php if(isset($_POST['id'])) echo $_POST['id'];?>" required></p>            
            <p><label for="description">Description:</label><input type="text" name="description" id="description" size="100" maxlength="100" value="<?php if(isset($_POST['description'])) echo $_POST['description'];?>" required></p>
            <p><label for="cost_amt">Cost Amount:</label><input type="number" name="cost_amt" id="cost_amt" min="1.00" max="20000.00" step="0.5" value="<?php if(isset($_POST['cost_amt'])) echo $_POST['cost_amt'];?>"></p>
            <p><label for="sale_amt">Sale Amount:</label><input type="number" name="sale_amt" id="sale_amt" min="1.00" max="100000.00" step="0.5" value="<?php if(isset($_POST['sale_amt'])) echo $_POST['sale_amt'];?>" required></p>
            <p><label for="cost_acct">Cost Account:</label>
            <select name="cost_acct" id="cost_acct">
                <option value="nocostaccount">--Select Cost Account--</option>
            <?php
                //Grab list of non-vehicle cost of sale accounts
                $qcost = 'SELECT account,description FROM coa WHERE type_id=12';
                try {
                    $pdo = connect();
                    $stmt = $pdo->prepare($qcost);
                    $stmt->execute();
                    while($row = $stmt->fetch(PDO::FETCH_NUM)) {
                        echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].'</option>';
                    }
                } catch(PDOException $e) {
                    echo '<option value="error">'.$e->getMessage().'</option';
                }
            ?>
            </select></p>
            <p><label for="sale_acct">Sale Account:</label>
            <select name="sale_acct" id="sale_acct">
                <option value="nosaleaccount">--Select Sale Account--</option>
            <?php
            //Grab list of non-vehicle sale accounts
            $qsale = 'SELECT account,description FROM coa WHERE type_id=13';
            try{
                $pdo = connect();
                $stmt = $pdo->prepare($qsale);
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_NUM)) {
                    echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].'</option>';
                }

            } catch(PDOException $e) {
                echo '<option value="error">'.$e->getMessage().'</option';
            }
            ?>
            </select></p>
            <p><input type="submit" name="submit" value="Save">
        </fieldset>
    </form>
    <?php
    //Process the form and save the data
    //Initialize an error array to collect validation errors
    //Mandatory fields are: ID, Description, Sale Amount
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(empty($_POST['id'])) {
            $errors[] = 'The Option ID is a mandatory field';
        } else {
            $opt_id = $_POST['id'];
        }

        if(empty($_POST['description'])) {
            $errors[] = 'Description is a mandatory field';
        } else {
            $description = $_POST['description'];
        }

        if(empty($_POST['sale_amt'])) {
            $errors[] = 'A Sale Amount Must be Entered';
        } else {
            $sale_amount = $_POST['sale_amt'];
        }

        if($_POST['sale_acct'] == 'nosaleaccount') {
            $errors[] = 'You must pick a sale account';
        } else{
            $sale_account = $_POST['sale_acct'];
        }

        //Grab non-mandatory fields and set numeric fields to null if not filled in
        if(!empty($_POST['cost_amt'])) {
            $cost_amount = $_POST['cost_amt'];
        } else {
            $cost_amount = 'null';
        }
        
        if($_POST['cost_acct'] != 'nocostaccount') {
            $cost_account = $_POST['cost_acct'];
        } else {
            $cost_account = 'null';
        }

        //If there are no errors at this point, insert data into database
        if(empty($errors)) {
            $optquery = "INSERT INTO options (id,description,cost_amount,sale_amount,cost_account,sale_account) VALUES('$opt_id','$description',$cost_amount,$sale_amount,$cost_account,$sale_account)";
            //echo $optquery;

            $pdo = connect();
            $stmt = $pdo->prepare($optquery);
            if($stmt->execute()) {
                echo '<p>Record Successfully Saved</p>';
            } else {
                echo '<p id="error">An unkown error occured</p>';
            }
        } else {
            echo '<h2 id="error">There were errors</h2>';
            echo '<p><strong>The following error(s) occured</strong></p>';
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
