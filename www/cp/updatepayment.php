<?php
global $current_section;
$current_section='payment';
$report_active=0;

require_once '../../init.php';

// Required files
require_once MAD_PATH . '/www/cp/auth.php';

require_once MAD_PATH . '/functions/adminredirect.php';

require_once MAD_PATH . '/www/cp/restricted.php';

require_once MAD_PATH . '/www/cp/admin_functions.php';

require_once MAD_PATH . '/www/cp/templates/header.tpl.php';

?>
<?php 
    if(isset($_POST["profile"])){
        global $user_detail;
        global $maindb;
        $location = isset($_POST["location"]) && strlen($_POST["location"]) > 0 ? sanitize($_POST["location"]) : NULL;
        $paypal_id = isset($_POST["paypal_id"]) && strlen($_POST["paypal_id"]) > 0 ? sanitize($_POST["paypal_id"]) : NULL;
        $bank_acc = isset($_POST["bank_acc"]) && strlen($_POST["bank_acc"]) > 0 ? sanitize($_POST["bank_acc"]) : NULL;
        
        if($location == NULL || $location == "Select Location"){
            global $errormessage;
            $errormessage='Select a location';
            global $editdata;
            $editdata=$_POST;
        }else if($paypal_id == NULL && $bank_acc == NULL){
            global $errormessage;
            $errormessage='Enter paypal id or bank account number.';
            global $editdata;
            $editdata=$_POST;
        }else{
            if(isset($user_detail["inv_id"])){
                $sql = "UPDATE md_publications SET location = '$location' , bank_acc = '$bank_acc' , paypal_id = '$paypal_id' WHERE inv_id = {$user_detail["inv_id"]}";
                mysql_query($sql,$maindb);
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=payment.php">';exit;
            }
        }
    }
?>


<script language="JavaScript">  

function showadiv(id) {  
//safe function to show an element with a specified id
		  
	if (document.getElementById) { // DOM3 = IE5, NS6
		document.getElementById(id).style.visibility = 'visible';
	}
	else {
		if (document.layers) { // Netscape 4
			document.id.visibility = 'visible';
		}
		else { // IE 4
			document.all.id.style.visibility = 'visible';
		}
	}
}

function hideadiv(id) {  
//safe function to hide an element with a specified id
	if (document.getElementById) { // DOM3 = IE5, NS6
		document.getElementById(id).style.visibility = 'collapse';
	}
	else {
		if (document.layers) { // Netscape 4
			document.id.visibility = 'collapse';
		}
		else { // IE 4
			document.all.id.style.visibility = 'collapse';
		}
	}

}

</script>

<div id="content">		
		
		<div id="contentHeader">
                    <h1>Payment Settings </h1>
		</div> <!-- #contentHeader -->	
		<div class="container">
			<div class="grid-24">
                            <div class="widget">
                                <div class="widget-header">
                                    <span class="icon-article"></span>
                                    <h3>Payment Profile</h3>
                                </div>
                                <div class="widget-content">
                                    <?php if (isset($errormessage)){ ?>
                                        <div class="box plain"><div class="notify notify-error"><h3>Error</h3><p><?php echo $errormessage; ?></p></div> <!-- .notify --></div>
                                    <?php } ?>
                                        <form method="post">
                                            <input type="hidden" name="profile">
                                            <table width="100%" cellspacing="10">
                                                <tr>
                                                    <td style="white-space: nowrap">
                                                        Payment Location
                                                    </td>
                                                    <td>
                                                        <select name="location" style="width: 300px;">
                                                            <?php
                                                                $value = isset($editdata["location"]) ? $editdata["location"] : NULL;
                                                                $value = isset($value) ? $value : $user_detail["location"];
                                                                $value = isset($value) && strlen($value) > 0 ? $value : "Select Location";
                                                                $str = '<option value="'.$value.'" selected="selected">'.$value.'</option>';
                                                                echo $str;
                                                            ?>
                                                            <?php //if (!isset ($editdata['location']) or empty($editdata['location'])){echo '<option value="" selected="selected">Select Location</option>'; } else { echo '<option value="'.$editdata['location'].'" selected="selected">'.$editdata["location"].'</option>'; }?>
                                                            <?php echo getCountries();?>
                                                        </select>
                                                    </td>
                                                    <td style="white-space: nowrap">
                                                        Paypal ID
                                                    </td>
                                                    <td>
                                                        <input type='text' name='paypal_id' value="<?php echo isset($editdata["paypal_id"]) ? $editdata["paypal_id"] : $user_detail["paypal_id"]; ?>">
                                                    </td>
                                                    <td style="white-space: nowrap">
                                                        Bank Account
                                                    </td>
                                                    <td>
                                                        <input type='text' disabled="true" name='bank_acc' value="<?php echo isset($user_detail["bank_acc"]) ? $user_detail["bank_acc"] : "";?>">
                                                        <br/><label for="bank_acc" style="color:gray">(coming soon)</label>
                                                    </td>
                                                </tr>
                                                <tr align="center">
                                                    <td  colspan="6">
                                                        <input type="submit" value="Update" style="height: 40px; width: 200px;"  class="btn-orange">
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            <script src='assets/javascripts/all.js'></script>
                    	</div> <!-- .grid -->
		</div> <!-- .container -->
	</div> <!-- #content -->
<?php
global $jsload; $jsload=1; require_once MAD_PATH . '/www/cp/templates/footer.tpl.php';
?>