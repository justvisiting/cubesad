<link rel="stylesheet" type="text/css" href="assets/javascripts/plugins/autocomplete/autoSuggest.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="assets/javascripts/plugins/autocomplete/jquery.autoSuggest.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<SCRIPT LANGUAGE="JavaScript">
<!-- 	
// by Nannette Thacker
// http://www.shiningstar.net
// This script checks and unchecks boxes on a form
// Checks and unchecks unlimited number in the group...
// Pass the Checkbox group name...
// call buttons as so:
// <input type=button name="CheckAll"   value="Check All"
	//onClick="checkAll(document.myform.list)">
// <input type=button name="UnCheckAll" value="Uncheck All"
	//onClick="uncheckAll(document.myform.list)">
// -->


function geo_targeting(status){
	
	if (status=="off"){
$("#geo_targeting_all").attr("checked", "true");
document.getElementById('country_target').style.display='none';
	}
	if (status=="on"){
	$("#geo_targeting_co").attr("checked", "true");
	document.getElementById('country_target').style.display='block';
	}

}


function device_targeting(status){
	
	if (status=="off"){
$("#device_targeting_all").attr("checked", "true");
document.getElementById('devicetargetingtable').style.display='none';
	}
	if (status=="on"){
	$("#device_targeting_co").attr("checked", "true");
	document.getElementById('devicetargetingtable').style.display='block';
	}

}

function publication_targeting(status){
	
	if (status=="off"){
$("#publication_targeting_all").attr("checked", "true");
document.getElementById('publicationtargetingtable').style.display='none';
	}
	if (status=="on"){
	$("#publication_targeting_co").attr("checked", "true");
	document.getElementById('publicationtargetingtable').style.display='block';
	}

}

function channel_targeting(status){
	
	if (status=="off"){
$("#channel_targeting_all").attr("checked", "true");
document.getElementById('channeltargetingtable').style.display='none';
	}
	if (status=="on"){
	$("#channel_targeting_co").attr("checked", "true");
	document.getElementById('channeltargetingtable').style.display='block';
	}

}


function startdate(status){
	
	if (status=="off"){
$("#start_date_im").attr("checked", "true");
document.getElementById('startdate').style.display='none';
	}
	if (status=="on"){
	$("#start_date_co").attr("checked", "true");
	document.getElementById('startdate').style.display='block';
	}

}

function enddate(status){
	
	if (status=="off"){
$("#end_date_no").attr("checked", "true");
document.getElementById('enddate').style.display='none';
	}
	if (status=="on"){
	$("#end_date_co").attr("checked", "true");
	document.getElementById('enddate').style.display='block';
	}

}

function network_campaign(status){
	
	if (status=="off"){
	document.getElementById('network_select').style.display='none'; document.getElementById('create_adunit').style.display='block';
	}
	if (status=="on"){
	document.getElementById('network_select').style.display='block'; document.getElementById('create_adunit').style.display='none';
	}

}

function checkAll(theForm, cName, status) {
		for (i=0,n=theForm.elements.length;i<n;i++)
		  if (theForm.elements[i].className.indexOf(cName) !=-1) {
		    theForm.elements[i].checked = status;
		  }
		}
</script>


                       
<div class="widget">
						
						<div class="widget-header">
							<span class="icon-article"></span>
							<h3>Campaign Details</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
                        
                        <?php if ($user_detail['tooltip_setting']==1){ ?>
                         <div class="notify notify-info">						
						
                        						<p>Please enter some general details about your campaign below.</p>
					</div> <!-- .notify -->
                        <?php } ?>

						  <div class="field-group">
			
								<div class="field">
                                                                    <?php
                                                                        global $user_detail;
                                                                        // if user == advertiser
                                                                        if(isset($user_detail["account_type"]) && $user_detail["account_type"] == 2){
                                                                    ?>
                                                                        <select <?php if ($current_action=='create'){?>onchange="if (this.options[this.selectedIndex].value=='network'){document.getElementById('create_adunit').style.display='none';} else {document.getElementById('create_adunit').style.display='block';}; callme(this); "<?php } ?> id="campaign_type" name="campaign_type">
                                                                              <option <?php if (isset($editdata['campaign_type']) && $editdata['campaign_type']==1){echo 'selected="selected"'; } ?> value="1">Direct Sold</option>
                                                                              <option <?php if (isset($editdata['campaign_type']) && $editdata['campaign_type']==2){echo 'selected="selected"'; } ?> value="2">Promotional</option>
                                                                              <!--<option <?php if (isset($editdata['campaign_type']) && $editdata['campaign_type']=='network'){echo 'selected="selected"'; } ?> value="network">Ad Network</option>	  -->
                                                                        </select>
                                                                    <?php } else { ?>
                                                                        <select <?php if ($current_action=='create'){?>onchange="if (this.options[this.selectedIndex].value=='network'){document.getElementById('network_select').style.display='block'; document.getElementById('create_adunit').style.display='none';} else {document.getElementById('network_select').style.display='none'; document.getElementById('create_adunit').style.display='block';}"<?php } ?><?php if ($current_action=='edit'){?>onchange="if (this.options[this.selectedIndex].value=='network'){document.getElementById('network_select').style.display='block';} else {document.getElementById('network_select').style.display='none';}"<?php } ?> id="campaign_type" name="campaign_type">
                                                                               <option <?php if (isset($editdata['campaign_type']) && $editdata['campaign_type']==1){echo 'selected="selected"'; } ?> value="1">Direct Sold</option>
                                                                               <option <?php if (isset($editdata['campaign_type']) && $editdata['campaign_type']==2){echo 'selected="selected"'; } ?> value="2">Promotional</option>
                                                                               <option <?php if (isset($editdata['campaign_type']) && $editdata['campaign_type']=='network'){echo 'selected="selected"'; } ?> value="network">Ad Network</option>

                                                                        </select>
                                                                    <?php } ?>
                                                                        <a style="font-size:11px;" href="#" onclick="$.modal ({title: 'Campaign Types', html: '<div style=width:500px;;><h3>Direct Sold</h3>A direct sold campaign is a fixed campaign in the system, typically with a high priority and a limited number of impressions.<br><br><h3>Promotional</h3>A promotional campaign is a campaign cross-promoting other apps or products. Cross promotional campaigns typically have a low priority to only show when an ad space cannot be filled by direct sold campaigns or ad networks.<br><br><h3>Ad Network</h3>An ad network campaign is a campaign sending traffic to a particular network. If a network is unable to fill the ad-request, the system will automatically select the next campaign with a lower priority until an ad has been found. Ad Network campaigns are usually targeted by country in order to select the best-paying partner for a particular geographic.</div>'});" title="Click for more info">Info</a>
									<label for="campaign_type">Campaign Type</label>
								</div>
							</div> <!-- .field-group -->
                            
                            <div id="network_select" style="display:none;" class="field-group">
			
								<div class="field">
								<select id="campaign_networkid" name="campaign_networkid">
<?php if (!isset($editdata['campaign_networkid'])){$editdata['campaign_networkid']='';} get_network_dropdown($editdata['campaign_networkid']); ?>							  </select>		<a class="tooltip" style="font-size:11px;" href="#" onclick="$.modal ({title: 'Network Publisher IDs', html: '<div style=width:500px;;><h3>Ad Networks</h3>In order to start sending mobile traffic to an ad network of your choice, you will have to create an account with the advertising network and then enter the Publisher IDs/Site IDs on the <a href=\'ad_networks.php\' target=\'_blank\'>Network Configuration</a> page in your mAdserve ad server. mAdserve will then automatically send all your traffic to the respective ad network. Revenue and other Reporting metrics will be reported and visible directly in your account with the ad network.</div>'});">Publisher ID Info</a>
									<label for="campaign_networkid">Ad Network</label>
								</div>
							</div> <!-- .field-group -->
                            
                                                        <div class="field-group" style="display: <?php global $user_detail; echo isset($user_detail["account_type"]) && $user_detail["account_type"] == 2 ? "none" : "block"; ?>">
								<div class="field">
								<select id="campaign_priority" name="campaign_priority">
								  <?php if (!isset($editdata['campaign_priority'])){$editdata['campaign_priority']='';}  get_priority_dropdown($editdata['campaign_priority']); ?>
							  </select>		<a class="tooltip" style="font-size:11px;" href="#" title="A campaign with higher priority will show before a campaign with lower priority. If there are two campaigns with the same priority, traffic will be allocated randomly between these campaigns.">Info</a>
									<label for="campaign_priority">Campaign Priority</label>
								</div>
							</div> <!-- .field-group -->
                                                        
                                                        <script>
                                                          var allCampaignPriority = document.getElementById("campaign_priority").innerHTML;
                                                            function callme(objSelect){
                                                                var str = "";
                                                                    var priorityArr = allCampaignPriority.length > 0 ? allCampaignPriority.split("</option>") : Array();
                                                                    var dd = document.getElementById("campaign_priority");
                                                                    //console.log(priorityArr);
                                                                    //alert(priorityArr);
                                                                    for(index = 0; index < priorityArr.length ; index++){
                                                                        if(objSelect.value == 1 && priorityArr[index].indexOf("Highest") > 0){
                                                                            //str = "<option value=''>Select Priority</option>";
                                                                            str += priorityArr[index];
                                                                            break;
                                                                        }else if(objSelect.value == "network" && priorityArr[index].indexOf("Medium") > 0){
                                                                            //str = "<option value=''>Select Priority</option>";
                                                                            str += priorityArr[index];
                                                                            break;
                                                                        }else if(objSelect.value == 2 && priorityArr[index].indexOf("Lowest") > 0){
                                                                            //str = "<option value=''>Select Priority</option>";
                                                                            str += priorityArr[index];
                                                                            break;
                                                                        }
                                                                    }
                                                                    dd.value = "";
                                                                    dd.innerHTML = str;
                                                                    dd.selectedIndex = 0;
                                                                    $("#uniform-campaign_priority span").html($("#campaign_priority option:selected").text());
                                                                    //$("#campaign_priority option:first-child").attr("selected","selected");
                                                                //alert("hi");
                                                            }
                                                            <?php if(isset($user_detail["account_type"]) && $user_detail["account_type"] == 2){ ?>callme(document.getElementById("campaign_type")); <?php } ?>
                                                      </script>
                                                        
                            
                            <div class="field-group">
			
								<div class="field">
									<input type="text" value="<?php if (isset($editdata['campaign_name'])){ echo $editdata['campaign_name']; } ?>"  name="campaign_name" id="campaign_name" size="28" class="" />			
									<label for="campaign_name">Campaign Name</label>
								</div>
							</div> <!-- .field-group -->
                            
                            <div class="field-group">
			
								<div class="field">
									<textarea name="campaign_desc" id="campaign_desc" rows="3" cols="29"><?php if (isset($editdata['campaign_desc'])){ echo $editdata['campaign_desc']; } ?></textarea>	
									<label for="campaign_desc">Campaign Notes</label>
								</div>
							</div> <!-- .field-group -->
                            
                              <div class="field-group control-group inline">	
	
									<div class="field">
										<input type="radio"   onclick="document.getElementById('startdate').style.display='none';" name="start_date_type" id="start_date_im" value="1" />
										<label for="start_date_im">Start Immediately</label>
									</div>
			
									<div id="interstitialoptiobutton" class="field">
										<input type="radio"  onclick="document.getElementById('startdate').style.display='block';" name="start_date_type" id="start_date_co" value="2" />
										<label for="start_date_co">Custom Start Date</label>
									</div>
                                    
                                    <div style="color:#999; font-size:11px;">Start Date</div>
			
									
								</div>	
                                <div  style="display:none;" id="startdate" class="field-group inlineField">								
									
									<div class="field">
										<div id="startdatepicker"></div>				
									</div> <!-- .field -->								
								</div> <!-- .field-group -->
                                
                                <input type="hidden" name="startdate_value" id="startdate_value" />
                                
                                <div class="field-group control-group inline">	
	
									<div class="field">
										<input type="radio"   onclick="document.getElementById('enddate').style.display='none';" name="end_date_type" id="end_date_no" value="1" />
										<label for="end_date_no">No End Date</label>
									</div>
			
									<div id="interstitialoptiobutton" class="field">
										<input type="radio"  onclick="document.getElementById('enddate').style.display='block';" name="end_date_type" id="end_date_co" value="2" />
										<label for="end_date_co">Custom End Date</label>
									</div>
                                    <div style="color:#999; font-size:11px;">End Date</div>
			
									
								</div>	
            
            <div id="enddate" style="display:none;" class="field-group inlineField">								
									
									<div class="field">
										<div id="enddatepicker"></div>				
									</div> <!-- .field -->								
								</div> <!-- .field-group -->
                                
                                                                <input type="hidden" name="enddate_value" id="enddate_value" />

                                
                                <div class="field-group">
			
								<div class="field">
								  <label for="textfield"></label>
								  <input size="10" type="text" value="<?php if (isset($editdata['total_amount'])){ echo $editdata['total_amount']; } ?>" name="total_amount" id="total_amount" />
								  <select id="cap_type	" name="cap_type">
                                                                    <option <?php if (isset($editdata['cap_type']) && $editdata['cap_type']==1){echo 'selected="selected"'; } ?> value="1">impressions / day</option>
                                                                    <option <?php if (isset($editdata['cap_type']) && $editdata['cap_type']==2){echo 'selected="selected"'; } ?> value="2">total impressions</option>
                                                                  </select>
                                                                  <a class="tooltip" style="font-size:11px;" href="#" title="You can add either a daily impression cap or a total impression cap to your campaign. This does not make sense for network campaigns, but rather for direct sold and promotional campaigns.">Info</a>
                                                                  <label for="total_amount">Impression Cap (optional)</label>
								</div>
							</div> <!-- .field-group -->
                                                        <div class="field-group">
                                                            <div class="field">
                                                                    <label for="textfield">Budget per day</label>
                                                                    <input size="10" type="text" value="<?php if (isset($editdata['budget'])){ echo $editdata['budget']; } ?>" name="budget" id="budget" />
                                                            </div>
                                                            <div class="field">
                                                                    <label for="textfield">Bidding Type</label>
                                                                    <select id="cap_type" name="bid_pricing" onchange="changeText(this)" onclick="changeText(this)">
                                                                        <option <?php if (isset($editdata['bid_pricing']) && $editdata['bid_pricing']==1){echo 'selected="selected"'; } ?> value="1">Impression based</option>
                                                                        <option <?php if (isset($editdata['bid_pricing']) && $editdata['bid_pricing']==2){echo 'selected="selected"'; } ?> value="2">Clicked based</option>
                                                                    </select>
                                                            </div>
                                                            <div class="field">
                                                                    <label id="maxlabel" for="textfield">Max CPM</label>
                                                                    <input size="10" type="text" value="<?php if (isset($editdata['max_pricing'])){ echo $editdata['max_pricing']; } ?>" name="max_pricing" id="max_pricing"/>
                                                            </div>
                                                        </div>
                            
                            		</div> <!-- .widget-content -->
						
					</div> <!-- .widget -->
                    
                    <div class="widget">
						
						<div class="widget-header">
							<span class="icon-article"></span>
							<h3>Targeting</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
                        
                        <?php if ($user_detail['tooltip_setting']==1){ ?>
                         <div class="notify notify-info">						
						
                        						<p>Enter targeting details for your campaign below. You can target your campaign by country, region, device type, and Android/iOS version.</p>
					</div> <!-- .notify -->
                        <?php } ?>
                        
                        <div class="field-group control-group inline">	
	
									<div class="field">
										<input type="radio"   onclick="document.getElementById('country_target').style.display='none';" name="geo_targeting" id="geo_targeting_all" value="1" />
										<label for="geo_targeting_all">All Countries</label>
									</div>
			
									<div id="interstitialoptiobutton" class="field">
										<input type="radio"  onclick="document.getElementById('country_target').style.display='block';" name="geo_targeting" id="geo_targeting_co" value="2" />
										<label for="geo_targeting_co">Specific Countries/Regions</label>
									</div>
                                    
<!--                                    <div style="color:#999; font-size:11px;">Geographic Targeting</div>
 -->			
            <div style="margin-top:7px; list-style:none; list-style-type:none; z-index:10000;" id="country_target" class="field-group">
			
								<div class="field">
									<input type="text" value="<?php if (isset($editdata['inv_name'])){ echo $editdata['inv_name']; } ?>" placeholder="Start typing a country or region name..."  name="country_targeting" id="country_targeting" style="width:280px; background-color:#EBEBEB; -moz-border-radius: 5px; border-radius: 5px;" />			
								</div>
							</div> <!-- .field-group -->
                            
                            <script language="javascript">
<?php json_regions('', 'data'); ?>

<?php 
if ($current_action=='create' && !empty($editdata['as_values_1'])){
json_prefill_countrylist('create', $editdata['as_values_1']);
}
else if ($current_action=='edit' && isset($editdata['preload_country']) && $editdata['preload_country']==1){
json_prefill_countrylist('edit', $_GET['id']);
}
else if ($current_action=='edit' && !empty($editdata['as_values_1'])){
json_prefill_countrylist('create', $editdata['as_values_1']);
}
else {
?>

var selecteddata = {items: [
]};
<?php } ?>
$("input[id=country_targeting]").autoSuggest(data.items, {selectedItemProp: "name", searchObjProps: "name", asHtmlID: "1", preFill:selecteddata.items, neverSubmit:true});
</script>
            
									
								</div>	
                            
                        
                                        <div class="field-group control-group inline" style="display:<?php global $user_detail; echo isset($user_detail["user_id"]) && $user_detail["account_type"] == 2 ? "none" : "block"; ?>">	
  
	
									<div class="field">
										<input type="radio"   onclick="document.getElementById('publicationtargetingtable').style.display='none';" name="publication_targeting" id="publication_targeting_all" value="1" />
										<label for="publication_targeting_all">All Publications</label>
									</div>
			
									<div id="interstitialoptiobutton" class="field">
										<input type="radio"  onclick="document.getElementById('publicationtargetingtable').style.display='block';" name="publication_targeting" id="publication_targeting_co" value="2" />
										<label for="publication_targeting_co">Specific Publications & Placements</label>
									</div>
                                    
<!--                                    <div style="color:#999; font-size:11px;">Device Targeting</div>
 -->			
 
 <table width="584" border="0" cellpadding="6" cellspacing="0" id="publicationtargetingtable" style="-moz-border-radius: 5px; border-radius: 5px; margin-top:5px;">
  <?php if (!isset($editdata['placement_select'])){$editdata['placement_select']='';} list_placements_campaign($editdata['placement_select']); ?>
  
  <!--<tr>
    <td><div align="left"><a class="tooltip" style="font-size:11px;" onclick="" href="#" >Select All</a> | <a class="tooltip" style="font-size:11px;" href="#" >Un-Select All</a></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> -->
</table>
 
									
		  </div>	
          
          <div class="field-group control-group inline">	
  
	
									<div class="field">
										<input type="radio"   onclick="document.getElementById('channeltargetingtable').style.display='none';" name="channel_targeting" id="channel_targeting_all" value="1" />
										<label for="channel_targeting_all">All Channels</label>
									</div>
			
									<div id="interstitialoptiobutton" class="field">
										<input type="radio"  onclick="document.getElementById('channeltargetingtable').style.display='block';" name="channel_targeting" id="channel_targeting_co" value="2" />
										<label for="channel_targeting_co">Specific Channels</label>
									</div>
                                    
<!--                                    <div style="color:#999; font-size:11px;">Device Targeting</div>
 -->			
 
 <table width="584" border="0" cellpadding="6" cellspacing="0" id="channeltargetingtable" style="-moz-border-radius: 5px; border-radius: 5px; margin-top:5px;">
  <?php if (!isset($editdata['channel_select'])){$editdata['channel_select']='';} list_channels_campaign($editdata['channel_select']); ?>
 
</table>
 
									
		  </div>	
          

  <div class="field-group control-group inline">	
  
	
									<div class="field">
									  <input type="radio"   onclick="document.getElementById('devicetargetingtable').style.display='none';" name="device_targeting" id="device_targeting_all" value="1" />
										<label for="device_targeting_all">All Devices</label>
									</div>
			
									<div id="interstitialoptiobutton" class="field">
									  <input type="radio"  onclick="document.getElementById('devicetargetingtable').style.display='block';" name="device_targeting" id="device_targeting_co" value="2" />
										<label for="device_targeting_co">Specific Device/OS</label>
									</div>
                                    
<!--      <div style="color:#999; font-size:11px;">Device Targeting</div>
 -->                                    
                                    <table style=" -moz-border-radius: 5px; border-radius: 5px; margin-top:5px;" id="devicetargetingtable" width="800" border="0">
                                        
                                            <?php
                                                $selOnPostDevices = $_POST["device"];
                                                $compaign_id = isset($_GET["id"]) && strlen($_GET["id"]) > 0 && is_numeric($_GET["id"]) ? $_GET["id"] : NULL ;
                                                $qry = "SELECT device_id,max,min FROM md_device_targeting WHERE campaign_id = $compaign_id";
                                                $selDevices = mysql_query($qry,$maindb);
                                                $sDevices = array();
                                                while($dev = mysql_fetch_array($selDevices)){
                                                    $sDevices[$dev["device_id"]] = array(
                                                        "max" => $dev["max"],
                                                        "min" => $dev["min"]
                                                    );
                                                }
                                                if(count($sDevices) == 0 && count($selOnPostDevices) > 0){
                                                    foreach($selOnPostDevices as $sel){
                                                        $sDevices[$sel] = array();
                                                    }
                                                }
                                                
                                                $sql = "SELECT * FROM md_device";
                                                $devices = mysql_query($sql,$maindb);
                                                //print_r($devices);
                                                
                                                while($device = mysql_fetch_array($devices)){
                                                    $checked = "";
                                                    if(in_array($device["device_id"],  array_keys($sDevices))){
                                                        $checked = "checked";
                                                    }
                                                    echo <<<EOT
                                                    <tr>
                                                        <td width='30%'><input $checked type="checkbox" name='device[]' value='{$device['device_id']}'>{$device["device_name"]}</td>
                                                        <td>Min</td>
                                                        <td>
EOT;
                                                    /*$check = "";
                                                    if(in_array($device["device_id"],$sDevices)){
                                                        $check = "checked";
                                                    }*/
                                                        
                                                   
                                                      
                                                    $deviceId = $device["device_id"];
                                                    $str = '<select name="version_min'.$device[device_id].'">
                                                                <option value="">No Min</option>
                                                            <option ';
                                                            if( $sDevices[$deviceId]["min"] == "2.0") { 
                                                                $str.= "selected" ;
                                                            } 
                                                    $str.=' value="2.0">2.0</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["min"] == "2.1"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="2.1">2.1</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["min"] == "3.0"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="3.0">3.0</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["min"] == "3.1"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="3.1">3.1</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["min"] == "3.2"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="3.2">3.2</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["min"] == "4.0"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="4.0">4.0</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["min"] == "4.1"){
                                                       $str.= "selected" ;
                                                    }
                                                    $str.=' value="4.1">4.1</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["min"] == "4.2"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="4.2">4.2</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["min"] == "4.3"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="4.3">4.3</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["min"] == "5.0"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="5.0">5.0</option>';
                                                    $str.='</td>
                                                        <td>Max</td>
                                                        <td>
                                                            <select name="version_max'.$device[device_id].'">
                                                                <option value="">No Max</option>
                                                               
 <option ';
                                                            if( $sDevices[$deviceId]["max"] == "2.0") { 
                                                                $str.= "selected" ;
                                                            } 
                                                    $str.=' value="2.0">2.0</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["max"] == "2.1"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="2.1">2.1</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["max"] == "3.0"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="3.0">3.0</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["max"] == "3.1"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="3.1">3.1</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["max"] == "3.2"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="3.2">3.2</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["max"] == "4.0"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="4.0">4.0</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["max"] == "4.1"){
                                                       $str.= "selected" ;
                                                    }
                                                    $str.=' value="4.1">4.1</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["max"] == "4.2"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="4.2">4.2</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["max"] == "4.3"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="4.3">4.3</option>';
                                                    $str.='<option ';
                                                    if($sDevices[$deviceId]["max"] == "5.0"){
                                                        $str.= "selected" ;
                                                    }
                                                    $str.=' value="5.0">5.0</option></select>
                                                        </td>
                                                    </tr>';
                                                    
                                                    echo $str;
                                                }
                                            ?>
</table>
			
									
						  </div>	
                                
                                  
                   
                            
                            		</div> <!-- .widget-content -->
						
					</div> <!-- .widget -->
                    
                   
                                                    
                                                    
                                <script src='assets/javascripts/all.js'></script>
                                <script>
                                    function changeText(obj) {
                                        //alert(obj.value);
                                        if(obj.value == 2){
                                            document.getElementById("maxlabel").innerHTML = "Max CPC";
                                        }else{
                                            document.getElementById("maxlabel").innerHTML = "Max CPM";
                                        }
                                    }
                                </script>
                                
                               

                            
                        


                            
                            
                            
                                                        
                           
                             
                             
                            
                          
                            
			
							
							
						
				