<link rel="stylesheet" type="text/css" href="assets/javascripts/plugins/autocomplete/autoSuggest.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="assets/javascripts/jquery-1.7.1.min.js"></script>
<?php
global $current_section;
$current_section='campaigns';

require_once '../../init.php';

// Required files
require_once MAD_PATH . '/www/cp/auth.php';

require_once MAD_PATH . '/functions/adminredirect.php';

require_once MAD_PATH . '/www/cp/restricted.php';

require_once MAD_PATH . '/www/cp/admin_functions.php';


if (!check_permission('campaigns', $user_detail['user_id'])){
exit;
}

global $current_action;
$current_action='create';

global $page_desc;
$page_desc='create_adunit';

if (isset($_POST['add'])){
    if (do_create('ad_unit', $_POST, '') && is_numeric($_GET['id'])){
        global $added;
        $added=1;
        //MAD_Admin_Redirect::redirect('view_adunits.php?id='.$_GET['id'].'&added=1');
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=view_adunits.php?id=' . $_GET['id'] . '">';exit;
    }else{
        global $added;
        $added=2;
    }
    // error occur on page
    // redirect to the same page.
}

if($added == 2){
    $editdata=$_POST;
    $radioGroup1Button1 = $_POST["creative_type"] == 1;
    $radioGroup1Button2 = $_POST["creative_type"] == 2;
    $radioGroup1Button3 = $_POST["creative_type"] == 3;
    
    $radioGroup2Button1 = $_POST["creative_type2"] == 1;
    $radioGroup2Button2 = $_POST["creative_type2"] == 2;
    $radioGroup2Button3 = $_POST["creative_type2"] == 3;
    
    $radioGroup3Button1 = $_POST["creative_type3"] == 1;
    $radioGroup3Button2 = $_POST["creative_type3"] == 2;
    $radioGroup3Button3 = $_POST["creative_type3"] == 3;
    
    $radioGroup4Button1 = $_POST["creative_type4"] == 1;
    $radioGroup4Button2 = $_POST["creative_type4"] == 2;
    $radioGroup4Button3 = $_POST["creative_type4"] == 3;
    
}
if(!isset($_POST["add"])){
    if(!($radioGroup1Button1 || $radioGroup1Button2 || $radioGroup1Button3)){
        $radioGroup1Button1 = true;
    }
    if(!($radioGroup2Button1 || $radioGroup2Button2 || $radioGroup2Button3)){
        $radioGroup2Button1 = true;
    }
    if(!($radioGroup3Button1 || $radioGroup3Button2 || $radioGroup3Button3)){
        $radioGroup3Button1 = true;
    }
    if(!($radioGroup4Button1 || $radioGroup4Button2 || $radioGroup4Button3)){
        $radioGroup4Button1 = true;
    }
}
$campaign_detail=get_campaign_detail($_GET['id']);



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
			<h1>Create Ad Unit: <?php echo $campaign_detail['campaign_name']; ?></h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			
				
			<div class="grid-24">
			
           <?php if (isset($errormessage)){ ?>
            <div class="box plain"><div class="notify notify-error"><h3>Error</h3><p><?php echo $errormessage; ?></p></div> <!-- .notify --></div>
            <?php } ?>
            
                    
				<form method="post" enctype="multipart/form-data" id="crudcampaign" name="crudcampaign" class="form uniformForm">
                <input type="hidden" name="add" value="1" />	
                <input type="hidden" name="campaign_id" value="<?php echo $_GET['id']; ?>" />		
					
				<?php require_once MAD_PATH . '/www/cp/templates/forms/crud.adunit.tpl.php';
				
				?>	
                
                <script src='assets/javascripts/all.js'></script>
                    
                    
                     <div class="actions">						
									<button type="submit" class="btn btn-quaternary btn-large">Create Ad Unit</button>
								</div> <!-- .actions -->
										
					
					
					
					</form>
					
				</div> <!-- .grid -->
                
             
<script>
<?php if (isset ($editdata['creative_type']) && $editdata['creative_type']==2){ 
//echo "creative_type('external');";
} else if (isset ($editdata['creative_type']) && $editdata['creative_type']==3){ 
//echo "creative_type('html');";
} else {
//echo "creative_type('upload');";
}

?>
if (document.forms["crudcampaign"].elements["creative_format"].value!='10'){hideadiv('widthzonediv'); hideadiv('heightzonediv');} else {showadiv('widthzonediv'); showadiv('heightzonediv');}
</script>
			
			
		</div> <!-- .container -->
		
	</div> <!-- #content -->
<?php
global $jsload; $jsload=1; require_once MAD_PATH . '/www/cp/templates/footer.tpl.php';
?>