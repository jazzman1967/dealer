<?php

$page_title='Tax Options';
include('includes/header.html');
require('../db.inc.php');
?>

<div class="content">
    <h1>Tax Options</h1>
    <form action="taxes.php" method="post">
        <fieldset>
            <legend>Tax Options</legend>
            <p><label for="description">Description</label><input type="text" name="description" id="description" length="100" maxlength="100" value="<?php if(isset($_POST['description'])) echo $_POST['description'];?>" required></p>
            <p><label for="rate">Rate:</label><input type="number" name="rate" id="rate" min="0.0000" max="99.9999" step="0.0001" value="<?php if(isset($_POST['rate'])) echo $_POST['rate'];?>" required> (Format is xx.xxxx)</p>
            <p><input type="submit" name="submit" value="Save"></p>
        </fieldset>
    </form>

<?php

//Process the form and save it in the database
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //If both fields are empty do not process and warn user
    if(empty($_POST['description']) || empty($_POST['rate'])) {
        echo '<p id="error">Both fields must be filled in.</p>';
    } else {
        //Both fields are filled in. ID will automatically be assigned by MySQL
        $description = $_POST['description'];
        $rate = $_POST['rate'];
        $q = "INSERT INTO taxes(description,rate) VALUES('$description',$rate)";
        //echo $q;
        $pdo = connect();
        $stmt = $pdo->prepare($q);
        if($stmt->execute()) {
            echo '<p>Record saved successfully</p>';
        } else {
            echo '<p id="error>There was an error saving the record</p>';
        }
    }
}

?>

</div>
</body>
</html>
