<?php

$page_title = 'GL Posting';
include('includes/header.html');
require('../db.inc.php');
include('classes/objChart.php');

$chart = array();
$elements = array();
$pdo = connect();
$q = 'SELECT c.account,c.description,c.type_id,a.type FROM coa c INNER JOIN account_types a ON c.type_id = a.id';
//echo $q;
$r = $pdo->query($q);
$r->setFetchMode(PDO::FETCH_CLASS,'objChart');
while($row = $r->fetch()) {
    $elements['description'] = $row->getDescription();
    $elements['type_id'] = $row->getTypeId();
    $elements['type'] = $row->getType();
    $chart[$row->getAccount()] = $elements;

}

echo "\n<script>";
echo 'var coa = ';
echo json_encode($chart);
echo ';';
echo "</script>\n";

?>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

td,th {
    border: 1px solid black;
    text-align: left;
    padding: 8px;
}
</style>

<div class="content">
<h1>General Ledger Posting</h1>
<!--Posting Form-->
<form action="writegl.php" method="post">
    <fieldset>
        <legend>General Ledger Posting</legend>
        <p><label for="date">Transaction Date: </label><input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>"></p>
        <p><label for="debits">Debits: </label><input type="number" name="debits" id="debits" min="0.00" max="1000000.00" step="0.01" readonly/></p>
        <p><label for="credits">Credits: </label><input type="number" name="credits" id="credits" min="0.00" max="1000000.00" step="0.01" readonly/></p>
        <p><strong>Posting Description</strong></p>
        <p><textarea name="description" id="description" rows="5" cols="75" maxlength="255" placeholder="Type a posting description up to a maximum of 255 characters"></textarea></p>
        
        <hr/>

        <table>
            <thead>
            <tr><th>Line</th><th>Account</th><th>Description</th><th>Control</th><th>Ctrl Type</th><th>Dr/Cr</th><th>Amount</th></tr>
            </thead>
            <tr><td>1</td>
                <td><input type="text" name="account1" id="account1" value=""></td>
                <td><input type="text" name="desc1" id="desc1" value="" readonly></td>
                <td><input type="text" name="control1" id="control1" value="" disabled></td>
                <td>
                    <select name="type1" id="type1">
                        <option value="none">--Select--</option>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="general">General</option>
                    </select>
                </td>
                <td>
                    <select name="dc1" id="dc1">
                        <option value="D">Debit</option>
                        <option value="C">Credit</option>
                    </select>
                </td>
                <td><input type="number" name="amount1" id="amount1" min="0.00" max="1000000.00" step="0.01" value="" disabled></td>
            </tr>
            <tr><td>2</td>
                <td><input type="text" name="account2" id="account2" value=""></td>
                <td><input type="text" name="desc2" id="desc2" value="" readonly></td>
                <td><input type="text" name="control2" id="control2" value="" disabled></td>
                <td>
                    <select name="type2" id="type2">
                        <option value="none">--Select--</option>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="general">General</option>
                    </select>
                </td>
                <td>
                    <select name="dc2" id="dc2">
                        <option value="D">Debit</option>
                        <option value="C">Credit</option>
                    </select>
                </td>
                <td><input type="number" name="amount2" id="amount2" min="0.00" max="1000000.00" step="0.01" value="" disabled></td>
            </tr>
            <tr><td>3</td>
                <td><input type="text" name="account3" id="account3" value=""></td>
                <td><input type="text" name="desc3" id="desc3" value="" readonly></td>
                <td><input type="text" name="control3" id="control3" value="" disabled></td>
                <td>
                    <select name="type3" id="type3">
                        <option value="none">--Select--</option>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="general">General</option>
                    </select>
                </td>
                <td>
                    <select name="dc3" id="dc3">
                        <option value="D">Debit</option>
                        <option value="C">Credit</option>
                    </select>
                </td>
                <td><input type="number" name="amount3" id="amount3" min="0.00" max="1000000.00" step="0.01" value="" disabled></td>
            </tr>
            <tr><td>4</td>
                <td><input type="text" name="account4" id="account4" value=""></td>
                <td><input type="text" name="desc4" id="desc4" value="" readonly></td>
                <td><input type="text" name="control4" id="control4" value="" disabled></td>
                <td>
                    <select name="type4" id="type4">
                        <option value="none">--Select--</option>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="general">General</option>
                    </select>
                </td>
                <td>
                    <select name="dc4" id="dc4">
                        <option value="D">Debit</option>
                        <option value="C">Credit</option>
                    </select>
                </td>
                <td><input type="number" name="amount4" id="amount4" min="0.00" max="1000000.00" step="0.01" value="" disabled></td>
            </tr>
            <tr><td>5</td>
                <td><input type="text" name="account5" id="account5" value=""></td>
                <td><input type="text" name="desc5" id="desc5" value="" readonly></td>
                <td><input type="text" name="control5" id="control5" value="" disabled></td>
                <td>
                    <select name="type5" id="type5">
                        <option value="none">--Select--</option>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="general">General</option>
                    </select>
                </td>
                <td>
                    <select name="dc5" id="dc5">
                        <option value="D">Debit</option>
                        <option value="C">Credit</option>
                    </select>
                </td>
                <td><input type="number" name="amount5" id="amount5" min="0.00" max="1000000.00" step="0.01" value="" disabled></td>
            </tr>
            <tr><td>6</td>
                <td><input type="text" name="account6" id="account6" value=""></td>
                <td><input type="text" name="desc6" id="desc6" value="" readonly></td>
                <td><input type="text" name="control6" id="control6" value="" disabled></td>
                <td>
                    <select name="type6" id="type6">
                        <option value="none">--Select--</option>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="general">General</option>
                    </select>
                </td>
                <td>
                    <select name="dc6" id="dc6">
                        <option value="D">Debit</option>
                        <option value="C">Credit</option>
                    </select>
                </td>
                <td><input type="number" name="amount6" id="amount6" min="0.00" max="1000000.00" step="0.01" value="" disabled></td>
            </tr>
            <tr><td>7</td>
                <td><input type="text" name="account7" id="account7" value=""></td>
                <td><input type="text" name="desc7" id="desc7" value="" readonly></td>
                <td><input type="text" name="control7" id="control7" value="" disabled></td>
                <td>
                    <select name="type7" id="type7">
                        <option value="none">--Select--</option>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="general">General</option>
                    </select>
                </td>
                <td>
                    <select name="dc7" id="dc7">
                        <option value="D">Debit</option>
                        <option value="C">Credit</option>
                    </select>
                </td>
                <td><input type="number" name="amount7" id="amount7" min="0.00" max="1000000.00" step="0.01" value="" disabled></td>
            </tr>
            <tr><td>8</td>
                <td><input type="text" name="account8" id="account8" value=""></td>
                <td><input type="text" name="desc8" id="desc8" value="" readonly></td>
                <td><input type="text" name="control8" id="control8" value="" disabled></td>
                <td>
                    <select name="type8" id="type8">
                        <option value="none">--Select--</option>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="general">General</option>
                    </select>
                </td>
                <td>
                    <select name="dc8" id="dc8">
                        <option value="D">Debit</option>
                        <option value="C">Credit</option>
                    </select>
                </td>
                <td><input type="number" name="amount8" id="amount8" min="0.00" max="1000000.00" step="0.01" value="" disabled></td>
            </tr>
            <tr><td>9</td>
                <td><input type="text" name="account9" id="account9" value=""></td>
                <td><input type="text" name="desc9" id="desc9" value="" readonly></td>
                <td><input type="text" name="control9" id="control9" value="" disabled></td>
                <td>
                    <select name="type9" id="type9">
                        <option value="none">--Select--</option>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="general">General</option>
                    </select>
                </td>
                <td>
                    <select name="dc9" id="dc9">
                        <option value="D">Debit</option>
                        <option value="C">Credit</option>
                    </select>
                </td>
                <td><input type="number" name="amount9" id="amount9" min="0.00" max="1000000.00" step="0.01" value="" disabled></td>
            </tr>
            <tr><td>10</td>
                <td><input type="text" name="account10" id="account10" value=""></td>
                <td><input type="text" name="desc10" id="desc10" value="" readonly></td>
                <td><input type="text" name="control10" id="control10" value="" disabled></td>
                <td>
                    <select name="type10" id="type10">
                        <option value="none">--Select--</option>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="general">General</option>
                    </select>
                </td>
                <td>
                    <select name="dc10" id="dc10">
                        <option value="D">Debit</option>
                        <option value="C">Credit</option>
                    </select>
                </td>
                <td><input type="number" name="amount10" id="amount10" min="0.00" max="1000000.00" step="0.01" value="" disabled></td>
            </tr>
        </table>

        <p><input type="submit" name="save" id="save" value="Save" disabled><input type="reset" name="reset" id="reset" value="Reset"></p>

    </fieldset>
</form>

<p><button name="validate" id="validate">Validate</button></p>

</div>
<script src="js/gl.js"></script>
</body>
</html>
