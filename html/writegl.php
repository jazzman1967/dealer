<?php
$page_title = 'Post GL Entry';
include('includes/header.html');
require('../db.inc.php');
?>

<div class="content">
<?php
/*Grab fields to make sure we are capturing right information
GL Header Fields from form: Date & Posting Description, total debits, total credits
GL Detail Fields from form: account, cust_id, vendor_id, vehicle_id, control, type, amount
Although total debits & credits are calculated, this script will recalculate debit/credit to make sure everything balanced
Source depends on where the posting came from. If from posting entry screen, source will be 'General'.
Transaction ID is manually generated as this number need to be used in both gl_header & gl_detail tables
*/

$line_counter = 0;
$accounts = array();
$types = array();
$amounts = array();
$control_types = array();
$controls = array();

//Constants
define('CUS','cust_id');
define('VEN','vendor_id');
define('VEH','vehicle_id');
define('GEN','control');
define('NONO','none');

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    //echo '<p>We are in the POST routine</p>';
    $post_date = $_POST['date'];
    $post_description = $_POST['description'];
    $total_debits = $_POST['debits'];
    $total_credits = $_POST['credits'];
    
    //Line 1
    if(isset($_POST['account1']) && isset($_POST['amount1'])) {
        $line_counter++;
        array_push($accounts,$_POST['account1']);
        array_push($amounts,$_POST['amount1']);
        array_push($types,$_POST['dc1']);
        if(isset($_POST['control1'])) {
            $ctrl_type = $_POST['type1'];
            $ctrl_no = $_POST['control1'];
            switch($ctrl_type) {
                case 'customer':
                    array_push($control_types,CUS);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vendor':
                    array_push($control_types,VEN);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vehicle':
                    array_push($control_types,VEH);
                    array_push($controls,$ctrl_no);
                    break;
                case 'general':
                    array_push($control_types,GEN);
                    array_push($controls,$ctrl_no);
                    break;
                default:
                    array_push($control_types,NONO);
                    array_push($controls,NONO);
            }
        } else {
            array_push($control_types,NONO);
            array_push($controls,NONO);
        }
    } //end of if(isset($_POST[account1]) && isset($_POST[amount1])

    //Line 2
    if(isset($_POST['account2']) && isset($_POST['amount2'])) {
        $line_counter++;
        array_push($accounts,$_POST['account2']);
        array_push($amounts,$_POST['amount2']);
        array_push($types,$_POST['dc2']);
        if(isset($_POST['control2'])) {
            $ctrl_type = $_POST['type2'];
            $ctrl_no = $_POST['control2'];
            switch($ctrl_type) {
                case 'customer':
                    array_push($control_types,CUS);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vendor':
                    array_push($control_types,VEN);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vehicle':
                    array_push($control_types,VEH);
                    array_push($controls,$ctrl_no);
                    break;
                case 'general':
                    array_push($control_types,GEN);
                    array_push($controls,$ctrl_no);
                    break;
                default:
                    array_push($control_types,NONO);
                    array_push($controls,NONO);
            }
        } else {
            array_push($control_types,NONO);
            array_push($controls,NONO);
        }
    } //end of if(isset($_POST[account2]) && isset($_POST[amount2])

    //Line 3
    if(isset($_POST['account3']) && isset($_POST['amount3'])) {
        $line_counter++;
        array_push($accounts,$_POST['account3']);
        array_push($amounts,$_POST['amount3']);
        array_push($types,$_POST['dc3']);
        if(isset($_POST['control3'])) {
            $ctrl_type = $_POST['type3'];
            $ctrl_no = $_POST['control3'];
            switch($ctrl_type) {
                case 'customer':
                    array_push($control_types,CUS);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vendor':
                    array_push($control_types,VEN);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vehicle':
                    array_push($control_types,VEH);
                    array_push($controls,$ctrl_no);
                    break;
                case 'general':
                    array_push($control_types,GEN);
                    array_push($controls,$ctrl_no);
                    break;
                default:
                    array_push($control_types,NONO);
                    array_push($controls,NONO);
            }
        } else {
            array_push($control_types,NONO);
            array_push($controls,NONO);
        }
    } //end of if(isset($_POST[account3]) && isset($_POST[amount3])

    //Line 4
    if(isset($_POST['account4']) && isset($_POST['amount4'])) {
        $line_counter++;
        array_push($accounts,$_POST['account4']);
        array_push($amounts,$_POST['amount4']);
        array_push($types,$_POST['dc4']);
        if(isset($_POST['control4'])) {
            $ctrl_type = $_POST['type4'];
            $ctrl_no = $_POST['control4'];
            switch($ctrl_type) {
                case 'customer':
                    array_push($control_types,CUS);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vendor':
                    array_push($control_types,VEN);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vehicle':
                    array_push($control_types,VEH);
                    array_push($controls,$ctrl_no);
                    break;
                case 'general':
                    array_push($control_types,GEN);
                    array_push($controls,$ctrl_no);
                    break;
                default:
                    array_push($control_types,NONO);
                    array_push($controls,NONO);
            }
        } else {
            array_push($control_types,NONO);
            array_push($controls,NONO);
        }
    } //end of if(isset($_POST[account4]) && isset($_POST[amount4])

    //Line 5
    if(isset($_POST['account5']) && isset($_POST['amount5'])) {
        $line_counter++;
        array_push($accounts,$_POST['account5']);
        array_push($amounts,$_POST['amount5']);
        array_push($types,$_POST['dc5']);
        if(isset($_POST['control5'])) {
            $ctrl_type = $_POST['type5'];
            $ctrl_no = $_POST['control5'];
            switch($ctrl_type) {
                case 'customer':
                    array_push($control_types,CUS);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vendor':
                    array_push($control_types,VEN);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vehicle':
                    array_push($control_types,VEH);
                    array_push($controls,$ctrl_no);
                    break;
                case 'general':
                    array_push($control_types,GEN);
                    array_push($controls,$ctrl_no);
                    break;
                default:
                    array_push($control_types,NONO);
                    array_push($controls,NONO);
            }
        } else {
            array_push($control_types,NONO);
            array_push($controls,NONO);
        }
    } //end of if(isset($_POST[account5]) && isset($_POST[amount5])

    //Line 6
    if(isset($_POST['account6']) && isset($_POST['amount6'])) {
        $line_counter++;
        array_push($accounts,$_POST['account6']);
        array_push($amounts,$_POST['amount6']);
        array_push($types,$_POST['dc6']);
        if(isset($_POST['control6'])) {
            $ctrl_type = $_POST['type6'];
            $ctrl_no = $_POST['control6'];
            switch($ctrl_type) {
                case 'customer':
                    array_push($control_types,CUS);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vendor':
                    array_push($control_types,VEN);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vehicle':
                    array_push($control_types,VEH);
                    array_push($controls,$ctrl_no);
                    break;
                case 'general':
                    array_push($control_types,GEN);
                    array_push($controls,$ctrl_no);
                    break;
                default:
                    array_push($control_types,NONO);
                    array_push($controls,NONO);
            }
        } else {
            array_push($control_types,NONO);
            array_push($controls,NONO);
        }
    } //end of if(isset($_POST[account6]) && isset($_POST[amount6])

    //Line 7
    if(isset($_POST['account7']) && isset($_POST['amount7'])) {
        $line_counter++;
        array_push($accounts,$_POST['account7']);
        array_push($amounts,$_POST['amount7']);
        array_push($types,$_POST['dc7']);
        if(isset($_POST['control7'])) {
            $ctrl_type = $_POST['type7'];
            $ctrl_no = $_POST['control7'];
            switch($ctrl_type) {
                case 'customer':
                    array_push($control_types,CUS);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vendor':
                    array_push($control_types,VEN);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vehicle':
                    array_push($control_types,VEH);
                    array_push($controls,$ctrl_no);
                    break;
                case 'general':
                    array_push($control_types,GEN);
                    array_push($controls,$ctrl_no);
                    break;
                default:
                    array_push($control_types,NONO);
                    array_push($controls,NONO);
            }
        } else {
            array_push($control_types,NONO);
            array_push($controls,NONO);
        }
    } //end of if(isset($_POST[account7]) && isset($_POST[amount7])

    //Line 8
    if(isset($_POST['account8']) && isset($_POST['amount8'])) {
        $line_counter++;
        array_push($accounts,$_POST['account8']);
        array_push($amounts,$_POST['amount8']);
        array_push($types,$_POST['dc8']);
        if(isset($_POST['control8'])) {
            $ctrl_type = $_POST['type8'];
            $ctrl_no = $_POST['control8'];
            switch($ctrl_type) {
                case 'customer':
                    array_push($control_types,CUS);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vendor':
                    array_push($control_types,VEN);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vehicle':
                    array_push($control_types,VEH);
                    array_push($controls,$ctrl_no);
                    break;
                case 'general':
                    array_push($control_types,GEN);
                    array_push($controls,$ctrl_no);
                    break;
                default:
                    array_push($control_types,NONO);
                    array_push($controls,NONO);
            }
        } else {
            array_push($control_types,NONO);
            array_push($controls,NONO);
        }
    } //end of if(isset($_POST[account8]) && isset($_POST[amount8])

    //Line 9
    if(isset($_POST['account9']) && isset($_POST['amount9'])) {
        $line_counter++;
        array_push($accounts,$_POST['account9']);
        array_push($amounts,$_POST['amount9']);
        array_push($types,$_POST['dc9']);
        if(isset($_POST['control9'])) {
            $ctrl_type = $_POST['type9'];
            $ctrl_no = $_POST['control9'];
            switch($ctrl_type) {
                case 'customer':
                    array_push($control_types,CUS);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vendor':
                    array_push($control_types,VEN);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vehicle':
                    array_push($control_types,VEH);
                    array_push($controls,$ctrl_no);
                    break;
                case 'general':
                    array_push($control_types,GEN);
                    array_push($controls,$ctrl_no);
                    break;
                default:
                    array_push($control_types,NONO);
                    array_push($controls,NONO);
            }
        } else {
            array_push($control_types,NONO);
            array_push($controls,NONO);
        }
    } //end of if(isset($_POST[account9]) && isset($_POST[amount9])

    //Line 10
    if(isset($_POST['account10']) && isset($_POST['amount10'])) {
        $line_counter++;
        array_push($accounts,$_POST['account10']);
        array_push($amounts,$_POST['amount10']);
        array_push($types,$_POST['dc10']);
        if(isset($_POST['control10'])) {
            $ctrl_type = $_POST['type10'];
            $ctrl_no = $_POST['control10'];
            switch($ctrl_type) {
                case 'customer':
                    array_push($control_types,CUS);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vendor':
                    array_push($control_types,VEN);
                    array_push($controls,$ctrl_no);
                    break;
                case 'vehicle':
                    array_push($control_types,VEH);
                    array_push($controls,$ctrl_no);
                    break;
                case 'general':
                    array_push($control_types,GEN);
                    array_push($controls,$ctrl_no);
                    break;
                default:
                    array_push($control_types,NONO);
                    array_push($controls,NONO);
            }
        } else {
            array_push($control_types,NONO);
            array_push($controls,NONO);
        }
    } //end of if(isset($_POST[account10]) && isset($_POST[amount10])

    echo '<p>The line counter is currently at '.$line_counter.'</p>';

    //Prepare SQL statements. 
    $tx_id_sql = 'SELECT MAX(tx_id) FROM gltxid';
    $gl_hdr_sql = 'INSERT INTO gl_header(tx_id,tx_date,total_dr_amount,total_cr_amount,post_description,line_count,source) VALUES(?,?,?,?,?,?,?)';
    $gl_dtl_sql = 'INSERT INTO gl_detail(tx_id,line_number,account,journal_id,cust_id,vendor_id,vehicle_id,control,type,amount) VALUES(?,?,?,?,?,?,?,?,?,?)';

    $source = 'General';
    $journal_id = 4;

    try{
        $pdo = connect();
        $pdo->beginTransaction();
        $stmt1 = $pdo->prepare($tx_id_sql);
        $stmt1->execute();
        $row = $stmt1->fetch();
        $cur_tx_id = $row[0];
        //echo '<p>Current transaction id is '.$cur_tx_id.'</p>';
        $new_tx_id = $cur_tx_id + 1;
        //Update gl header
        $gl_hdr_query = $pdo->prepare($gl_hdr_sql);
        $gl_hdr_query->execute(array($new_tx_id,$post_date,$total_debits, $total_credits, $post_description,$line_counter,$source));

        for($i = $line_counter; $i <= $line_counter; $i++) {
            
        }

        
    } catch(PDOException $e) {
        $pdo->rollBack();
        $e->getMessage();
    }


} //end of if($_SERVER['REQUEST_METHOD] == 'POST')

?>


</div>
</body>
</html>