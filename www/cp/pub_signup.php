<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
    include_once 'custom_functions.php';
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <title>Publisher - Signup</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="author" content="" />		
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" href="assets/stylesheets/all.css" type="text/css" />

    <!--[if gte IE 9]>
    <link rel="stylesheet" href="assets/stylesheets/ie9.css" type="text/css" />
    <![endif]-->

    <!--[if gte IE 8]>
    <link rel="stylesheet" href="assets/stylesheets/ie8.css" type="text/css" />
    <![endif]-->
</head>
<body class="frontSignup">
    
    <?php
        global $current_section;
        $current_section='configuration';
        require_once '../../init.php';
        // Required files
        require_once MAD_PATH . '/www/cp/auth.php';
        require_once MAD_PATH . '/functions/adminredirect.php';
        //require_once MAD_PATH . '/www/cp/restricted.php';
        require_once MAD_PATH . '/www/cp/admin_functions.php';
        global $current_action;
        $current_action = 'create';
        if (isset($_POST['add'])){
            //$data = $_POST;
            $email = isset($_POST["email_address"]) && strlen(trim($_POST["email_address"])) > 0 ? $_POST["email_address"] : NULL;
            if($email != NULL){
                global $maindb;
                if(pub_isDuplicateEmail($email,$maindb) == FALSE){
                    if (do_create('publication', $_POST, '')){
                        global $added;
                        $added=1;
                         echo '<META HTTP-EQUIV="Refresh" Content="0; URL=thanks.php">';exit;
                    }else{
                        global $added;
                        $added=2;
                    }
                }else{
                    global $errormessage;
                    $errormessage='A user with this e-mail address already exists in the system.';
                    global $editdata;
                    $editdata=$data;
                    
                }
            }else{
                global $errormessage;
                $errormessage='Enter Valid Email Address.';
                global $editdata;
                $editdata=$data;
                
            }
        }
    ?>
    <div id="content">
        <div id="contentHeader">
            <h1>Add Publisher</h1>
        </div>
        <div class="container">
                <div class="grid-24">
                    <?php if (isset($errormessage)){ ?>
                <div class="box plain"><div class="notify notify-error"><h3>Error</h3><p><?php echo $errormessage; ?></p></div> <!-- .notify --></div>
                <?php } ?>
                <form method="post" id="crudpublication" name="crudpublication" class="form uniformForm">
                    <input type="hidden" name="add" value="1" />	
                    <div class="widget">
						
						<div class="widget-header">
							<span class="icon-article"></span>
							<h3>Publisher Details</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
                        
                        <?php if ($user_detail['tooltip_setting']==1){ ?>
                         <div class="notify notify-info">						
						
                        						<p>Please enter some general details about your publication below. If you are adding an iOS or Android application, it makes sense to enter the App Store or Google Play URL in the 'Publisher URL' field.</p>
					</div> <!-- .notify -->
                        <?php } ?>

						
                            
                            <div class="field-group">
			
								<div class="field">
									<input type="text" value="<?php if (isset($editdata['inv_name'])){  echo $editdata['inv_name']; } ?>"  name="inv_name" id="inv_name" size="28" class="" />			
									<label for="inv_name">Publisher Name</label>
								</div>
							</div> <!-- .field-group -->
                            
                            <div class="field-group">
			
								<div class="field">
                                                                    <!--<div class="selector" id="uniform-zone_size">-->
                                                                        <select <?php if ($current_action=='create'){?>onchange="if (this.options[this.selectedIndex].value=='3'){hideadiv('interstitialoptiobutton');} else {showadiv('interstitialoptiobutton');}"<?php } ?> id="inv_type" name="inv_type">
                                                                          <?php if (!isset($editdata['inv_type'])){$editdata['inv_type']='';} get_pubtype_dropdown($editdata['inv_type']); ?>
                                                                        </select>		
                                                                    <!--</div> -->
                                                                    <label for="inv_type">Publisher Type</label>
								</div>
							</div> <!-- .field-group -->
                            
                            <div class="field-group">
			
								<div class="field">
									<input type="text" value="<?php if (isset($editdata['inv_address'])){ echo $editdata['inv_address']; } else { echo 'http://'; } ?>"  name="inv_address" id="inv_address" size="28" class="" />			
									<label for="inv_address">Publisher URL (Web URL or App Store URL)</label>
								</div>
							</div> <!-- .field-group -->
                            
                                                        <div class="field-group">

                                                            <div class="field">
                                                                    <select id="inv_defaultchannel" name="inv_defaultchannel">
                                                              <option>- Select Channel  -</option>
                                                                    <?php  if (!isset($editdata['inv_defaultchannel'])){$editdata['inv_defaultchannel']='';} get_channel_dropdown($editdata['inv_defaultchannel']); ?>								</select>					
                                                                    <label for="inv_defaultchannel">Main Channel</label>
                                                            </div>
                                                        </div> <!-- .field-group -->
                                                        <!--custome fields -->
                                                        
                                                        <div class="field-group">
                                                            <div class="field">
                                                                    <input type="text" value="<?php if (isset($editdata['email_address'])){ echo $editdata['email_address']; } ?>"  name="email_address" id="email_address" size="28" class="" />
                                                                    <label for="email_address">Email Address</label>
                                                            </div>
                                                        </div> <!-- .field-group -->
                                                        
                                                        <div class="field-group">
                                                            <div class="field">
                                                                <input type="password" value=""  name="pass_word" id="pass_word" size="28" class="" />
                                                                <label for="pass_word">Password</label>
                                                            </div>
                                                        </div> <!-- .field-group -->
                                                        
                                                        <div class="field-group">
                                                            <div class="field">
                                                                <input type="password" value=""  name="confirm_pass_word" id="confirm_pass_word" size="28" class="" />
                                                                <label for="confirm_pass_word">Confirm Password</label>
                                                            </div>
                                                        </div> <!-- .field-group -->
                                                        
                                                        <div class="field-group">
                                                            <div class="field">
                                                                <input type="text" value="<?php if (isset($editdata['paypal_id'])){ echo $editdata['paypal_id']; } ?>"  name="paypal_id" id="paypal_id" size="28" class="" />
                                                                <label for="paypal_id">Paypal ID</label>
                                                            </div>
                                                        </div> <!-- .field-group -->
                                                        <!--end custome fields-->
                            
                                                        <div class="field-group">
			
								<div class="field">
									<textarea name="inv_description" id="inv_description" rows="5" cols="50"><?php if (isset($editdata['inv_description'])){ echo $editdata['inv_description']; } ?></textarea>	
									<label for="inv_description">Description</label>
								</div>
							</div> <!-- .field-group -->
                                                        
                                                        <!---- next section --->
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

function checkdivs(){
if (document.forms['crudpublication'].elements['zone_size'].value=='10'){hideadiv('widthzonediv'); hideadiv('heightzonediv');}
}

function checkdivsreopen(){
if (document.forms['crudpublication'].elements['zone_size'].value=='10'){showadiv('widthzonediv'); showadiv('heightzonediv');}
}


</script>
                    
                    <div class="widget">
						
						<div class="widget-header">
							<span class="icon-article"></span>
							<h3>Ad Unit / Placement Details</h3>
						</div> <!-- .widget-header -->
                        
						
						<div class="widget-content">
                        
                        <?php if ($user_detail['tooltip_setting']==1){ ?>
                        <div class="notify notify-info">						
						
						<p>A placement is a single place in your mobile application or website in which an advertisement can appear. You can create an unlimited number of placements for your publication, and a placement can either be a banner or a full page interstitial.</p>
					</div> <!-- .notify -->
						<?php } ?>
                            
                            <div class="field-group">
			
								<div class="field">
									<input type="text" value="<?php if (isset($editdata['zone_name']) && !empty($editdata['zone_name'])){ echo $editdata['zone_name']; } else { echo 'Main Placement'; } ?>"  name="zone_name" id="zone_name" size="28" class="" />			
									<label for="zone_name">Placement Name</label>
								</div>
							</div> <!-- .field-group -->
                           
                                                       <div class="field-group">
                     <div class="field">
									<textarea name="zone_description" id="zone_description" rows="5" cols="50"><?php if (isset($editdata['zone_description'])){ echo $editdata['zone_description']; } ?></textarea>	
									<label for="zone_description">Description</label>
								</div>
							</div> <!-- .field-group -->
                            
                            <div class="field-group control-group inline">	
			
									<div class="field">
										<input type="radio" <?php if (isset($editdata['zone_type']) && $editdata['zone_type']=='banner'){echo'checked="checked"'; }?>  onclick="showadiv('zonesize'); checkdivsreopen();" name="zone_type" id="zone_type_banner" value="banner" />
										<label for="zone_type_banner">Banner Ad</label>
									</div>
			
									<div id="interstitialoptiobutton" class="field">
										<input type="radio" <?php if (isset($editdata['zone_type']) && $editdata['zone_type']=='interstitial'){echo'checked="checked"'; }?> onclick="hideadiv('zonesize'); checkdivs();" name="zone_type" id="zone_type_interstitial" value="interstitial" />
										<label for="zone_type_interstitial">Full Page Interstitial</label>
									</div>
			
									
								</div>	
                                
                                <div id="zonesize" class="field-group">
			                    <?php if ($current_action=='create'){?>
								<div class="field">
									<select onchange="if (this.options[this.selectedIndex].value=='10'){showadiv('widthzonediv'); showadiv('heightzonediv');} else {hideadiv('widthzonediv'); hideadiv('heightzonediv');}" id="zone_size" name="zone_size">
								  <option>- Phone  -</option>
								  <option value="1">320x50 Banner</option>
								  <option value="2">300x250 Medium Banner</option>
                                  <option>- Tablet  -</option>
								  <option value="3">728x90 Leaderboard</option>
								  <option value="2">300x250 Medium Tablet Banner</option>
								  <option value="4">160x600 Skyscraper</option>
								  <option value="1">320x50 Tablet Banner</option>
                                  <option value="10">Custom Size:</option>
								</select>					
									<label for="zone_size">Ad Unit Size</label>
								</div>
                                <?php } ?>
                                <div id="widthzonediv" class="field">
									<input type="text" value="<?php  if (isset($editdata['zone_width'])){ echo $editdata['zone_width']; } ?>" name="custom_zone_width" id="custom_zone_width" size="3" class="" />		x	
									<label for="last_name">Width</label>
								</div>
                               
                                <div id="heightzonediv" class="field">
									<input type="text" value="<?php if (isset($editdata['zone_height'])){ echo $editdata['zone_height']; } ?>" name="custom_zone_height" id="custom_zone_height" size="3" class="" />			
									<label for="last_name">Height</label>
								</div>
							</div> <!-- .field-group -->
                            
                            <div class="field-group">
			
								<div class="field">
									<select id="zone_channel" name="zone_channel">
								  <option>- Use publisher default channel  -</option>
	 <?php if (!isset($editdata['zone_channel'])){$editdata['zone_channel']=''; } get_channel_dropdown($editdata['zone_channel']); ?>
								</select>					
									<label for="zone_channel">Channel Override</label>
								</div>
							</div> <!-- .field-group -->
                            
                            <div class="field-group">
			
								<div class="field">
									<input type="text" value="<?php if (isset ($editdata['zone_refresh']) && !empty($editdata['zone_refresh'])){ echo $editdata['zone_refresh']; } else { echo '30'; } ?>"  name="zone_refresh" id="zone_refresh" size="1" class="" /> seconds	
									<label for="zone_refresh">Refresh Interval (enter 0 for no refresh)</label>
								</div>
							</div> <!-- .field-group -->
                            
						</div> <!-- .widget-content -->
						
					</div> <!-- .widget -->
                    
                    <div class="notify">			
                        <p><input name="mobfox_backfill_active" id="mobfox_backfill_active" type="checkbox" value="1" /><label for="mobfox_backfill_active"><strong>BackFill - </strong>Attempt to show an ad from the MobFox:Connect network before an ad space remains unfilled. (recommended)</label></p>
                    </div> <!-- .notify -->
                  <script language="javascript">if (document.forms["crudpublication"].elements["zone_size"].value!='10'){hideadiv('widthzonediv'); hideadiv('heightzonediv');} else {showadiv('widthzonediv'); showadiv('heightzonediv');} if (document.forms["crudpublication"].elements["inv_type"].value=='3'){hideadiv('interstitialoptiobutton');} else {showadiv('interstitialoptiobutton');}
</script><?php if (isset ($editdata['zone_type']) && $editdata['zone_type']=='interstitial'){?><script language="javascript">hideadiv('zonesize'); checkdivs();</script><?php } ?>
						</div> <!-- .widget-content -->
						
					</div> <!-- .widget -->
                                        
                    <div class="actions">
                        <button type="submit" class="btn btn-quaternary btn-large">Submit</button>
                    </div> <!-- .actions -->
                </form>
            </div>
        </div>
    </div>
</body>
</html>