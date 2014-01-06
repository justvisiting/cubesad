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
$current_action='edit';

$adData = get_adunit_detail($_GET['id']); 

if (isset($_POST['update'])){
if (do_edit('adunit', $_POST, $_GET['id'])){
global $edited;
$edited=1;
//MAD_Admin_Redirect::redirect('edit_ad_unit.php?edited=1&id='.$_GET['id'].'');
$campaignId = isset( $adData["campaign_id"] ) ? $adData["campaign_id"] : "";
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=view_adunits.php?id=' . $campaignId .'">';exit;
}
else
{
global $edited;
$edited=2;
}
}


if ($edited!=2){
    $editdata=$adData;
    $editdata['creative_type']=$editdata['adv_type'];
    $editdata['custom_creative_width']=$editdata['adv_width'];
    $editdata['custom_creative_height']=$editdata['adv_height'];
    
    $editdata['click_url']=$editdata['adv_click_url'];
    $editdata['tracking_pixel']=$editdata['adv_impression_tracking_url'];
    $editdata['creative_url']=$editdata['adv_bannerurl'];
    $editdata['html_body']=$editdata['adv_chtml'];
    $editdata["adv_mraid"] = $editdata["adv_mraid"];
    
    $radioGroup1Button1 =  isset($editdata["unit_hash"]) && strlen($editdata['unit_hash']) >0 ;
    $radioGroup1Button2 = isset($editdata['adv_bannerurl']) && strlen($editdata['adv_bannerurl']) >0 ;
    $radioGroup1Button3 = isset($editdata['adv_chtml']) && strlen($editdata['adv_chtml']) >0 ;
    
    $radioGroup2Button1 =  isset($editdata["unit_hash_2"]) && strlen($editdata['unit_hash_2']) >0 ;
    $radioGroup2Button2 = isset($editdata['banner_url2']) && strlen($editdata['banner_url2']) >0 ;
    $radioGroup2Button3 = isset($editdata['adv_chtml_2']) && strlen($editdata['adv_chtml_2']) >0 ;
    
    $radioGroup3Button1 =  isset($editdata["unit_hash_3"]) && strlen($editdata['unit_hash_3']) >0 ;
    $radioGroup3Button2 = isset($editdata['banner_url3']) && strlen($editdata['banner_url3']) >0 ;
    $radioGroup3Button3 = isset($editdata['adv_chtml_3']) && strlen($editdata['adv_chtml_3']) >0 ;
    
    $radioGroup4Button1 =  isset($editdata["unit_hash_4"]) && strlen($editdata['unit_hash_4']) >0 ;
    $radioGroup4Button2 = isset($editdata['banner_url4']) && strlen($editdata['banner_url4']) >0 ;
    $radioGroup4Button3 = isset($editdata['adv_chtml_4']) && strlen($editdata['adv_chtml_4']) >0 ;
    
    
    // custom data
    $editdata["creative_format"] = $editdata["creative_format"];
    $editdata["ad_description"] = $editdata["ad_description"];
    
    // 2nd upload container.
    $editdata['creative_url2']=$editdata['banner_url2'];
    $editdata['html_body2']=$editdata['adv_chtml_2'];
    $editdata['click_url2']=$editdata['click_url_2'];
    
    // 3rd upload container.
    $editdata['creative_url3']=$editdata['banner_url3'];
    $editdata['html_body3']=$editdata['adv_chtml_3'];
    $editdata['click_url3']=$editdata['click_url_3'];
    
    // 4rd upload container.
    $editdata['creative_url4']=$editdata['banner_url4'];
    $editdata['html_body4']=$editdata['adv_chtml_4'];
    $editdata['click_url4']=$editdata['click_url_4'];
    
    
    //checkboxs under html container.
    $editdata["adv_mraid2"] = $editdata["adv_mraid_2"];
    $editdata["adv_mraid3"] = $editdata["adv_mraid_3"];
    $editdata["adv_mraid4"] = $editdata["adv_mraid_4"];
}else{
    // error occur on page
    // redirect to the same page.
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

if(!isset($_POST["update"])){
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

require_once MAD_PATH . '/www/cp/templates/header.tpl.php';



?>
<script src="assets/javascripts/jquery-1.7.1.min.js"></script>
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
			<h1>Edit Ad Unit: <?php echo $editdata['adv_name']; ?></h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			
				
			<div class="grid-24">
			
           <?php if ($edited==1){?>	
            <div class="box plain"><div class="notify notify-success"><h3>Successfully Updated</h3><p>Your Ad Unit has successfully been updated.</p></div> <!-- .notify --></div>
            <?php } else if ($edited==2){ ?>
            <div class="box plain"><div class="notify notify-error"><h3>Error</h3><p><?php echo $errormessage; ?></p></div> <!-- .notify --></div>
            <?php } ?>
            
                    
				<form method="post" enctype="multipart/form-data" id="crudcampaign" name="crudcampaign" class="form uniformForm">
                <input type="hidden" name="update" value="1" />	
					
				<?php require_once MAD_PATH . '/www/cp/templates/forms/crud.edit_adunit.tpl.php';
				
				?>	
                
                <script src='assets/javascripts/all.js'></script>
                    
                    
                     <div class="actions">						
									<button type="submit" class="btn btn-quaternary btn-large">Edit Ad Unit</button>
								</div> <!-- .actions -->
										
					
					
					
					</form>
					
				</div> <!-- .grid -->
                
             
<script>
<?php if ($editdata['creative_type']==2){ 
//echo "creative_type('external');";
} else if ($editdata['creative_type']==3){ 
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