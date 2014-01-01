<?php
global $current_section;
$current_section='dashboard';


require_once '../../init.php';

// Required files
require_once MAD_PATH . '/www/cp/auth.php';

require_once MAD_PATH . '/functions/adminredirect.php';

require_once MAD_PATH . '/www/cp/restricted.php';

require_once MAD_PATH . '/www/cp/admin_functions.php';



require_once MAD_PATH . '/www/cp/templates/header.tpl.php';

?>
<div id="content">		
    <div id="contentHeader">
        <h1>Dashboard</h1>
    </div> <!-- #contentHeader -->	
    <div class="container">
        <?php
            global $user_detail;
            global $user_right;
            if(isset($user_detail["user_id"]) && $user_detail["user_id"] > 0 && isset($user_detail["account_type"]) && $user_detail["account_type"] == 1 ){
                include_once MAD_PATH . '/www/cp/templates/admin_dashboard.php';
            }else if(isset($user_detail["user_id"]) && $user_detail["user_id"] > 0 && isset($user_detail["account_type"]) && $user_detail["account_type"] == 2){
                include_once MAD_PATH . '/www/cp/templates/adv_dashboard.php';
            }else if(isset($user_detail["inv_id"]) && $user_detail["inv_id"] > 0 && isset($user_right["publisher"])){
                include_once MAD_PATH . '/www/cp/templates/pub_dashboard.php';
            }
        ?>
    </div> <!-- .container -->
</div> <!-- #content -->
<?php
require_once MAD_PATH . '/www/cp/templates/footer.tpl.php';
?>