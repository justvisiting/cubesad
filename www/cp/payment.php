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
                                    <h3>Payment Details</h3>
                                </div> <!-- .widget-header -->
                                <div class="widget-content">
                                    <?php if (isset($errormessage)){ ?>
                                        <div class="box plain"><div class="notify notify-error"><h3>Error</h3><p><?php echo $errormessage; ?></p></div> <!-- .notify --></div>
                                    <?php } ?>

                                    <?php
                                        global $user_detail;
                                        global $user_right;
                                        global $maindb;
                                        $havePaymentProfile = (isset($user_detail["bank_acc"]) && strlen($user_detail["bank_acc"]) > 0) || isset($user_detail["paypal_id"]) && strlen($user_detail["paypal_id"]);
                                        if($havePaymentProfile){
                                            echo <<<EOT
                                            <table border="1" width="100%">
                                                <tr style="font-size:15px;background-color:gray;color:white">
                                                    <th>Location</th>
                                                    <th>Paypal ID</th>
                                                    <th>Bank Account Number</th>
                                                </tr>
                                                <tr align="center" style="background-color:lightgray">
                                                    <td style="white-space: nowrap">
                                                        {$user_detail["location"]}
                                                    </td>

                                                    <td style="white-space: nowrap">
                                                        {$user_detail["paypal_id"]}
                                                    </td>

                                                    <td style="white-space: nowrap">
                                                        {$user_detail["bank_acc"]}
                                                    </td>
                                                </tr>
                                            </table>
                                            <br/><br/>
                                            <a href="updatepayment.php" style="width: 200px;height: 40px;padding:20px;text-decoration:none;font-size:15px;" class="btn-primary">Update Payment Profile</a>
EOT;
                                        }else{
                                            echo <<<EOT
                                            <div class="box plain">
                                                <div class="notify notify-info"><h3>No payment profile has been configured yet.</h3>
                                                    <p>All your ads will remain inactive until you add a valid payment profile.</p>
                                                </div>
                                            </div>
                                            <a href="updatepayment.php" style="width: 200px;height: 40px;padding:20px;text-decoration:none;" class="btn-primary">Add Payment Profile</a>
EOT;
                                        }
                                    ?>
                                    <br/><br/>
                                </div>
                            </div>
                            <div class="widget">
                                <div class="widget-header">
                                    <span class="icon-article"></span>
                                    <h3>Last 5 pay-outs Made</h3>
                                </div>
                                <div class="widget-content">
                                    <table width="50%" cellspacing="5" cellpadding="5">
                                        <tr style="background:lightgray">
                                            <td>
                                                Date
                                            </td>
                                            <td>
                                                Transfered To
                                            </td>
                                            <td>
                                                Amount (USD)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                No payments Found.
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <script src='assets/javascripts/all.js'></script>
                    	</div> <!-- .grid -->
		</div> <!-- .container -->
	</div> <!-- #content -->
<?php
global $jsload; $jsload=1; require_once MAD_PATH . '/www/cp/templates/footer.tpl.php';
?>