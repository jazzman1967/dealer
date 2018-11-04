<?php
//Create date May 18, 2018

$page_title="Accounting Template";
include ('includes/header.html');
require ('../mysqli_connect.php');

?>

<div class="content">

<h1>Accounting Template for Sales</h1>
<form action="templates.php" method="post">
    <fieldset>
        <legend>Add Sales Accounting Template</legend>
    <p><label for="description">Description:</label>
    <input type="text" name="description" id="description" size="50" maxlength="50" value="<?php if(isset($_POST['template'])) echo $_POST['template']; ?>"></p>
    <p><label for="sale_account">Sale Account:</label>
    <select name="sale_account" id="sale_account"><option value="nosale">--Select Sale Account--</option>
        <?php
        //Grab list of Sale Accounts from coa with type = 1
        $qs = "SELECT account,description FROM coa WHERE type_id=1";
        $r = @mysqli_query($dbc,$qs);
        while($row = mysqli_fetch_row($r)) {
            echo '<option value="'.$row[0].'">'.$row[0].'-'.$row[1].'</option>';
        }
        ?>
        </select></p>
        <p><label for="cost_account">Cost Account:</label>
        <select name="cost_account" id="cost_account"><option value="nocost">--Select Cost Account--</option>
            <?php 
            //Grab list of Cost Account from coa with type = 3
            $qc = "SELECT account,description FROM coa WHERE type_id=3";
            $r = @mysqli_query($dbc,$qc);
            while($row = mysqli_fetch_row($r)) {
                echo '<option value="'.$row[0].'">'.$row[0]."-".$row[1].'</option>';
            }
            ?>
            </select></p>
            <input type="submit" name="submit" value="Save">
        </fieldset>
        </form>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    //All fields must be filled in!
    if(empty($_POST['description']) && (($_POST['sale_account']) == 'nosale') && (($_POST['cost_account']) == 'nocost')) {
        echo '<p id="error">All fields must be filled in</p>';
    } else {
        //Grab the data
        $description = mysqli_real_escape_string($dbc,trim($_POST['description']));
        $sale = mysqli_real_escape_string($dbc,trim($_POST['sale_account']));
        $cost = mysqli_real_escape_string($dbc,trim($_POST['cost_account']));
        $q = "INSERT INTO templates (description,sale_account,cost_account) VALUES('$description',$sale,$cost)";
        //echo $q;
        $r = @mysqli_query($dbc,$q);
        if($r) {
            echo "<p>Template Saved!</p>";
        } else {
            echo '<p class="error">An unkown error occured. Please contact support</p>';
        }
    } 
} //end if($_SERVER['REQUEST_METHOD'] == 'POST')

?>




</div>
</body>
</html>
