<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 
<style>
    .ui-accordion .ui-accordion-header .ui-icon{
        left: 11.5em;
    }
</style>
<script>
  $(function() {
    $( "#accordion" ).accordion({
    });
  });
</script>
<script language="javascript">
 function creative_type(status){
	
	if (status=="upload"){
            $("#creative_type_upload").attr("checked", "true");
            document.getElementById('creative_url_div').style.display='none'; 
            document.getElementById('html_div').style.display='none'; 
            document.getElementById('creative_upload_div').style.display='block';
            document.getElementById('creative_upload_div').style.display='block';
            //document.getElementById('click_url_div').style.display='block';
	}
	
	if (status=="external"){
            $("#creative_type_url").attr("checked", "true");
            document.getElementById('creative_upload_div').style.display='none'; 
            document.getElementById('html_div').style.display='none'; 
            document.getElementById('creative_url_div').style.display='block'; 
            document.getElementById('creative_upload_div').style.display='block'; 
            document.getElementById('creative_upload_div').style.display='none'; 
            //document.getElementById('click_url_div').style.display='block';	
        }
	
	if (status=="html"){
            $("#creative_type_html").attr("checked", "true");
            document.getElementById('creative_upload_div').style.display='none';
            document.getElementById('creative_url_div').style.display='none'; 
            //document.getElementById('click_url_div').style.display='none';
            document.getElementById('html_div').style.display='block';
	}
	

}
    $(document).ready(function(){
        $("#creative_format").change(function(){
            $("#ad_desc_div").hide();
            //$("#click_url_div_text").hide();
            $("#smallImage").hide();
            $("#accordion").show();
            var accordion = $( "#accordion" ).accordion();
            accordion.find( ".ui-accordion-header:eq(1)" ).hide();
            accordion.find( ".ui-accordion-header:eq(2)" ).hide();
            accordion.find( ".ui-accordion-header:eq(3)" ).hide();
            var active = accordion.accordion( "option", "active" );
            if ( active >= 1 ) {
                accordion.accordion( "option", "active", 0 );
            }
            if($(this).val() == "11"){
                //$("#click_url_div_text").show();
                $("#ad_desc_div").show();
                $("#accordion").hide();
            }
            if($(this).val() == 15){
                $("#ad_desc_div").show();
            }
            if($(this).val() >= 15){
                $("#accordion").show();
                accordion.find( ".ui-accordion-header:eq(1)" ).show();
                accordion.find( ".ui-accordion-header:eq(2)" ).show();
                accordion.find( ".ui-accordion-header:eq(3)" ).show();
            }
            if($(this).val() == 16){
                $("#smallImage").show();
            }
        });
    });
 </script>
 <div id="create_adunit" class="widget">					
        <div class="widget-header">
                <span class="icon-article"></span>
                <h3 class="icon aperture"><?php if ($current_action=='create'){?>Create Ad Unit<?php } else if ($current_action=='edit'){ ?>Edit Ad Unit<?php } ?></h3>
        </div> <!-- .widget-header -->

        <div class="widget-content">     
                <?php if ($user_detail['tooltip_setting']==1){ ?>
               <div class="notify notify-info">						
                    <p>Please create your first ad-unit below. Once the campaign is setup, you will be able to add additional ad units to the campaign.</p>
                </div> <!-- .notify -->
              <?php } ?>
                        
                <div class="field-group">
                       <div class="field">
                               <input type="text" value="<?php  if (!isset($page_desc)){$page_desc=''; } if ($current_action=="create" && empty($editdata['adv_name']) && $page_desc!='create_adunit'){ echo "Creative 1"; } else if (!empty($editdata['adv_name'])){echo $editdata['adv_name']; }?>"  name="adv_name" id="adv_name" size="28" class="" />			
                               <label for="adv_name">Creative Name</label>
                       </div>
               </div> <!-- .field-group -->
                        
                            <div id="zonesize" class="field-group">
                                <?php if ($current_action=='edit'){?>
                                    <div class="field">
                                            <select onchange="if (this.options[this.selectedIndex].value=='10'){showadiv('widthzonediv'); showadiv('heightzonediv');} else {hideadiv('widthzonediv'); hideadiv('heightzonediv');}" id="creative_format" name="creative_format">
                                                <option>- Phone  -</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==5){echo 'selected="selected"'; } ?> value="5">300x50 Banner</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==1){echo 'selected="selected"'; } ?> value="1">320x50 Banner</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==2){echo 'selected="selected"'; } ?> value="2">300x250 Medium Banner</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==6){echo 'selected="selected"'; } ?> value="6">320x480 Full Screen</option>

                                                <option>- Tablet  -</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==3){echo 'selected="selected"'; } ?> value="3">728x90 Leaderboard</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==2){echo 'selected="selected"'; } ?> value="2">300x250 Medium Tablet Banner</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==4){echo 'selected="selected"'; } ?> value="4">160x600 Skyscraper</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==1){echo 'selected="selected"'; } ?> value="1">320x50 Tablet Banner</option>

                                                <option>- Smartwatch -</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==11){echo 'selected="selected"'; } ?> value="11">Text</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==12){echo 'selected="selected"'; } ?> value="12">Banner</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==13){echo 'selected="selected"'; } ?> value="13">Interstitial</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==14){echo 'selected="selected"'; } ?> value="14">Logo</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==15){echo 'selected="selected"'; } ?> value="15">Multipart Text</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==16){echo 'selected="selected"'; } ?> value="16">Multipart Banner</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==17){echo 'selected="selected"'; } ?> value="17">Multipart Interstitial</option>
                                                <option <?php if (isset($editdata['creative_format']) && $editdata['creative_format']==10){echo 'selected="selected"'; } ?> value="10">Custom Size:</option>
                                              </select>
                                            <label for="creative_format">Creative Format</label>
                                    </div>
                                <?php } ?>
                                <div id="widthzonediv" class="field">
                                    <input type="text" value="<?php if (isset($editdata['custom_creative_width'])){ echo $editdata['custom_creative_width']; } ?>" name="custom_creative_width" id="custom_creative_width" size="3" class="" />		x	
                                    <label for="last_name">Width</label>
                                </div>
                               
                                <div id="heightzonediv" class="field">
                                        <input type="text" value="<?php if (isset($editdata['custom_creative_height'])){ echo $editdata['custom_creative_height']; } ?>" name="custom_creative_height" id="custom_creative_height" size="3" class="" />			
                                        <label for="last_name">Height</label>
                                    </div>
                                </div> <!-- .field-group -->
                                                        
                            <div id="ad_desc_div" class="field-group" style="display: none;">
                                <div class="field">
                                    <input type="text" name="ad_description" id="ad_description" maxlength="60" size="28" value="<?php if (isset($editdata['ad_description'])){ echo $editdata['ad_description']; } ?>">	
                                    <label for="ad_description">Ad Description</label><br />
                                </div>
                            </div> <!-- .field-group -->
                            
                            <div id="smallImage" class="field-group" style="display: none;">
                                <div style="height: 1px;border: 1px solid lightgray;background: lightgray"></div>
                                <br/>
                                <div class="field">
                                    <label for="small_img">Upload Small Image</label>
                                    <input type="file" name="small_img" id="small_img" />
                                </div>
                                <div style="height: 1px;border: 1px solid lightgray;background: lightgray"></div>
                                <br/><br/>
                            </div> <!-- .field-group -->
                            
                           <!--<div id="click_url_div_text" class="field-group" style="display: none;">
                                <div class="field">
                                    <input type="text" value="<?php if (isset($editdata['click_url'])){ echo $editdata['click_url']; } ?>"  name="click_url_text" id="click_url_text" size="28" class="" />			
                                    <label for="click_url">Click URL</label>
                                </div>
                            </div> <!-- .field-group -->
                            <!---->
                            
                            <!---->
                            <div id="accordion">
                                <h3>Creative Upload 1</h3>
                                <div id="img-group1" >
                                <div class="field-group control-group inline">
                                    <div class="field">
                                        <input type="radio" <?php echo $radioGroup1Button1 ? "checked" : ""; ?>  onclick="document.getElementById('creative_url_div').style.display='none'; document.getElementById('html_div').style.display='none'; document.getElementById('creative_upload_div').style.display='block'; document.getElementById('creative_upload_div').style.display='block';" name="creative_type" id="creative_type_upload" value="1" />
                                            <label for="creative_type_upload">Creative Upload</label>
                                    </div>
                                    
                                    <div class="field">
                                            <input type="radio" <?php echo $radioGroup1Button2 ? "checked" : ""; ?>  onclick="document.getElementById('creative_upload_div').style.display='none'; document.getElementById('html_div').style.display='none'; document.getElementById('creative_url_div').style.display='block'; document.getElementById('creative_upload_div').style.display='block'; document.getElementById('creative_upload_div').style.display='none';" name="creative_type" id="creative_type_url" value="2" />
                                            <label for="creative_type_url">External Image URL</label>
                                    </div>
                                    
                                    <div class="field">
                                            <input type="radio" <?php echo $radioGroup1Button3 ? "checked" : ""; ?> onclick="document.getElementById('creative_upload_div').style.display='none'; document.getElementById('creative_url_div').style.display='none'; document.getElementById('html_div').style.display='block';" name="creative_type" id="creative_type_html" value="3" />
                                            <label for="creative_type_html">HTML (MRAID supported)</label>
                                    </div>
                                    <div style="color:#999; font-size:11px;">Creative Type</div>
                                </div>
                                                                       
                                <div id="creative_url_div" class="field-group" style="display: <?php echo $radioGroup1Button2 ? "block" : "none"; ?>">
                                    <div class="field">
                                        <input type="text" value="<?php if (isset($editdata['creative_url'])){echo $editdata['creative_url']; } ?>"  name="creative_url" id="creative_url" size="28" class="" />			
                                        <label for="creative_url">Creative Image URL</label>
                                    </div>
                                </div> <!-- .field-group -->

                                <div id="creative_upload_div" class="field-group inlineField" style="display: <?php echo $radioGroup1Button1 ? "block" : "none"; ?>">	
                                        <label for="creative_file">Creative Upload: <?php if ($current_action=='edit'){?>(Updates current creative)<?php } ?></label>
                                        <div class="field">
                                                <input type="file" name="creative_file" id="creative_file" />
                                        </div>	
                                </div><!-- .field-group -->

                                <div id="html_div" class="field-group" style="display: <?php echo $radioGroup1Button3 ? "block" : "none"; ?>">
                                    <div class="field">
                                            <textarea name="html_body" id="html_body" rows="5" cols="38"><?php if (isset($editdata['html_body'])){ echo $editdata['html_body']; } ?></textarea>	
                                            <label for="html_body">HTML Body</label><br /><input <?php if (isset($editdata['adv_mraid']) && $editdata['adv_mraid']==1){echo 'checked="checked"'; } ?> type="checkbox" name="adv_mraid" id="adv_mraid" value="1" /> <label for="adv_mraid">This is an MRAID ad</label>
                                    </div>
                                </div> <!-- .field-group -->
                                <br/><br/><br/><br/><br/><br/>
                            </div>
                                <h3>Creative Upload 2</h3>
                            <div id="img-group2">
                                <div class="field-group control-group inline">
                                    <div class="field">
                                            <input type="radio" <?php echo $radioGroup2Button1 ? "checked" : ""; ?> onclick="document.getElementById('creative_url_div2').style.display='none'; document.getElementById('html_div2').style.display='none'; document.getElementById('creative_upload_div2').style.display='block'; document.getElementById('creative_upload_div2').style.display='block';" name="creative_type2" id="creative_type_upload2" value="1" />
                                            <label for="creative_type_upload2">Creative Upload</label>
                                    </div>
                                    <div class="field">
                                        <input type="radio" <?php echo $radioGroup2Button2 ? "checked" : ""; ?> onclick="document.getElementById('creative_upload_div2').style.display='none'; document.getElementById('html_div2').style.display='none'; document.getElementById('creative_url_div2').style.display='block'; document.getElementById('creative_upload_div2').style.display='block'; document.getElementById('creative_upload_div2').style.display='none';" name="creative_type2" id="creative_type_url2" value="2"  />
                                            <label for="creative_type_url2">External Image URL</label>
                                    </div>
                                    <div class="field">
                                            <input type="radio" <?php echo $radioGroup2Button3 ? "checked" : ""; ?> onclick="document.getElementById('creative_upload_div2').style.display='none'; document.getElementById('creative_url_div2').style.display='none';document.getElementById('html_div2').style.display='block';" name="creative_type2" id="creative_type_html2" value="3" />
                                            <label for="creative_type_html2">HTML (MRAID supported)</label>
                                    </div>
                                    <div style="color:#999; font-size:11px;">Creative Type</div>
                                </div>
                                                                       
                                <div id="creative_url_div2" class="field-group" style="display: <?php echo $radioGroup2Button2 ? "block" : "none"; ?>">
                                    <div class="field">
                                        <input type="text" value="<?php if (isset($editdata['creative_url2'])){echo $editdata['creative_url2']; } ?>"  name="creative_url2" id="creative_url2" size="28" class="" />			
                                        <label for="creative_url2">Creative Image URL</label>
                                    </div>
                                </div> <!-- .field-group -->

                                <div id="creative_upload_div2" class="field-group inlineField" style="display: <?php echo $radioGroup2Button1 ? "block" : "none"; ?>">
                                        <label for="creative_file2">Creative Upload: <?php if ($current_action=='edit'){?>(Updates current creative)<?php } ?></label>
                                        <div class="field">
                                                <input type="file" name="creative_file2" id="creative_file2" />
                                        </div>	
                                </div><!-- .field-group -->

                                <div id="html_div2" class="field-group" style="display: <?php echo $radioGroup2Button3 ? "block" : "none"; ?>">
                                        <div class="field">
                                                <textarea name="html_body2" id="html_body2" rows="5" cols="38"><?php if (isset($editdata['html_body2'])){ echo $editdata['html_body2']; } ?></textarea>	
                                                <label for="html_body2">HTML Body</label><br /><input <?php if (isset($editdata['adv_mraid_2']) && $editdata['adv_mraid_2']==1){echo 'checked="checked"'; } ?> type="checkbox" name="adv_mraid2" id="adv_mraid2" value="1" /> <label for="adv_mraid2">This is an MRAID ad</label>
                                        </div>
                                </div> <!-- .field-group -->
                                <!--<div id="click_url_div2" class="field-group" style="display: <?php echo $radioGroup2Button2 || $radioGroup2Button1 ? "block" : "none"; ?>">
                                    <div class="field">
                                            <input type="text" value="<?php if (isset($editdata['click_url2'])){ echo $editdata['click_url2']; } ?>"  name="click_url2" id="click_url2" size="28" class="" />			
                                            <label for="click_url2">Click URL</label>
                                    </div>
                                </div> <!-- .field-group -->
                                <br/><br/><br/><br/><br/><br/>
                            </div>
                                <h3>Creative Upload 3</h3>
                            <div id="img-group3">
                                <div class="field-group control-group inline">
                                    <div class="field">
                                            <input type="radio" <?php echo $radioGroup3Button1 ? "checked" : ""; ?> onclick="document.getElementById('creative_url_div3').style.display='none'; document.getElementById('html_div3').style.display='none'; document.getElementById('creative_upload_div3').style.display='block'; document.getElementById('creative_upload_div3').style.display='block';" name="creative_type3" id="creative_type_upload3" value="1" />
                                            <label for="creative_type_upload3">Creative Upload</label>
                                    </div>
                                    <div class="field">
                                        <input type="radio" <?php echo $radioGroup3Button2 ? "checked" : ""; ?> onclick="document.getElementById('creative_upload_div3').style.display='none'; document.getElementById('html_div3').style.display='none'; document.getElementById('creative_url_div3').style.display='block'; document.getElementById('creative_upload_div3').style.display='block'; document.getElementById('creative_upload_div3').style.display='none';" name="creative_type3" id="creative_type_url3" value="2" />
                                            <label for="creative_type_url3">External Image URL</label>
                                    </div>
                                    <div class="field">
                                            <input type="radio" <?php echo $radioGroup3Button3 ? "checked" : ""; ?>  onclick="document.getElementById('creative_upload_div3').style.display='none'; document.getElementById('creative_url_div3').style.display='none'; document.getElementById('html_div3').style.display='block';" name="creative_type3" id="creative_type_html3" value="3" />
                                            <label for="creative_type_html3">HTML (MRAID supported)</label>
                                    </div>
                                    <div style="color:#999; font-size:11px;">Creative Type</div>
                                </div>
                                                                       
                                <div id="creative_url_div3" class="field-group" style="display: <?php echo $radioGroup3Button2 ? "block" : "none"; ?>">
                                    <div class="field">
                                        <input type="text" value="<?php if (isset($editdata['creative_url3'])){echo $editdata['creative_url3']; } ?>"  name="creative_url3" id="creative_url3" size="28" class="" />			
                                        <label for="creative_url3">Creative Image URL</label>
                                    </div>
                                </div> <!-- .field-group -->

                                <div id="creative_upload_div3" class="field-group inlineField" style="display: <?php echo $radioGroup3Button1 ? "block" : "none"; ?>">	
                                        <label for="creative_file3">Creative Upload: <?php if ($current_action=='edit'){?>(Updates current creative)<?php } ?></label>

                                        <div class="field">
                                                <input type="file" name="creative_file3" id="creative_file3" />
                                        </div>	
                                </div><!-- .field-group -->

                                <div id="html_div3" class="field-group" style="display: <?php echo $radioGroup3Button3 ? "block" : "none"; ?>">
                                        <div class="field">
                                                <textarea name="html_body3" id="html_body3" rows="5" cols="38"><?php if (isset($editdata['html_body3'])){ echo $editdata['html_body3']; } ?></textarea>	
                                                <label for="html_body3">HTML Body</label><br /><input <?php if (isset($editdata['adv_mraid3']) && $editdata['adv_mraid3']==1){echo 'checked="checked"'; } ?> type="checkbox" name="adv_mraid3" id="adv_mraid3" value="1" /> <label for="adv_mraid3">This is an MRAID ad</label>
                                        </div>
                                </div> <!-- .field-group -->
                                <!--<div id="click_url_div3" class="field-group" style="display: <?php echo $radioGroup3Button2 || $radioGroup3Button1 ? "block" : "none"; ?>">
                                    <div class="field">
                                            <input type="text" value="<?php if (isset($editdata['click_url3'])){ echo $editdata['click_url3']; } ?>"  name="click_url3" id="click_url3" size="28" class="" />			
                                            <label for="click_url3">Click URL</label>
                                    </div>
                                </div> <!-- .field-group -->
                                <br/><br/><br/><br/><br/><br/>
                            </div>
                                <h3>Creative Upload 4</h3>
                            <div id="img-group4">
                                <div class="field-group control-group inline">
                                    <div class="field">
                                            <input type="radio" <?php echo $radioGroup4Button1 ? "checked" : ""; ?> onclick="document.getElementById('creative_url_div4').style.display='none'; document.getElementById('html_div4').style.display='none'; document.getElementById('creative_upload_div4').style.display='block'; document.getElementById('creative_upload_div4').style.display='block';" name="creative_type4" id="creative_type_upload4" value="1" />
                                            <label for="creative_type_upload4">Creative Upload</label>
                                    </div>
                                    <div class="field">
                                        <input type="radio" <?php echo $radioGroup4Button2 ? "checked" : ""; ?> onclick="document.getElementById('creative_upload_div4').style.display='none'; document.getElementById('html_div4').style.display='none'; document.getElementById('creative_url_div4').style.display='block'; document.getElementById('creative_upload_div4').style.display='block'; document.getElementById('creative_upload_div4').style.display='none';" name="creative_type4" id="creative_type_url4" value="2" />
                                        <label for="creative_type_url4">External Image URL</label>
                                    </div>
                                    <div class="field">
                                        <input type="radio" <?php echo $radioGroup4Button3 ? "checked" : ""; ?> onclick="document.getElementById('creative_upload_div4').style.display='none'; document.getElementById('creative_url_div4').style.display='none';document.getElementById('html_div4').style.display='block';" name="creative_type4" id="creative_type_html4" value="3"/>
                                        <label for="creative_type_html4">HTML (MRAID supported)</label>
                                    </div>
                                    <div style="color:#999; font-size:11px;">Creative Type</div>
                                </div>
                                                                       
                                <div id="creative_url_div4" class="field-group" style="display: <?php echo $radioGroup4Button2 ? "block" : "none"; ?>">
                                    <div class="field">
                                        <input type="text" value="<?php if (isset($editdata['creative_url4'])){echo $editdata['creative_url4']; } ?>"  name="creative_url4" id="creative_url4" size="28" class="" />			
                                        <label for="creative_url4">Creative Image URL</label>
                                    </div>
                                </div> <!-- .field-group -->

                                <div id="creative_upload_div4" class="field-group inlineField" style="display: <?php echo $radioGroup4Button1 ? "block" : "none"; ?>">	
                                        <label for="creative_file4">Creative Upload: <?php if ($current_action=='edit'){?>(Updates current creative)<?php } ?></label>

                                        <div class="field">
                                                <input type="file" name="creative_file4" id="creative_file4" />
                                        </div>	
                                </div><!-- .field-group -->

                                <div id="html_div4" class="field-group" style="display: <?php echo $radioGroup4Button3 ? "block" : "none"; ?>">
                                        <div class="field">
                                                <textarea name="html_body4" id="html_body4" rows="5" cols="38"><?php if (isset($editdata['html_body4'])){ echo $editdata['html_body4']; } ?></textarea>	
                                                <label for="html_body4">HTML Body</label><br /><input <?php if (isset($editdata['adv_mraid4']) && $editdata['adv_mraid4']==1){echo 'checked="checked"'; } ?> type="checkbox" name="adv_mraid4" id="adv_mraid4" value="1" /> <label for="adv_mraid4">This is an MRAID ad</label>
                                        </div>
                                </div> <!-- .field-group -->
                                <!--<div id="click_url_div4" class="field-group" style="display: <?php echo $radioGroup4Button2 || $radioGroup4Button1 ? "block" : "none"; ?>">
                                    <div class="field">
                                            <input type="text" value="<?php if (isset($editdata['click_url4'])){ echo $editdata['click_url4']; } ?>"  name="click_url4" id="click_url4" size="28" class="" />			
                                            <label for="click_url4">Click URL</label>
                                    </div>
                                </div> <!-- .field-group -->
                                <br/><br/><br/><br/><br/><br/>
                            </div>
                            </div>
                            <br/>
                            <div id="click_url_div" class="field-group">
                                <div class="field">
                                    <input type="text" value="<?php if (isset($editdata['click_url'])){ echo $editdata['click_url']; } ?>"  name="click_url" id="click_url" size="28" class="" />			
                                    <label for="click_url">Click URL</label>
                                </div>
                            </div> <!-- .field-group -->
                            <div id="tracking_pixel_div" class="field-group">
                                <div class="field">
                                    <input type="text" value="<?php if ( isset($editdata['tracking_pixel'])){ echo $editdata['tracking_pixel']; } ?>"  name="tracking_pixel" id="tracking_pixel" size="28" class="" />			
                                    <label for="tracking_pixel">Tracking Pixel URL</label>
                                </div>
                            </div> <!-- .field-group -->
                            
							
						</div> <!-- .widget-content -->
						
					</div> <!-- .widget -->	
                    
<script>
        $(document).ready(function(){
            $("#ad_desc_div").hide();
            $("#click_url_div_text").hide();
            $("#smallImage").hide();
            $("#accordion").show();
            var accordion = $( "#accordion" ).accordion();
            accordion.find( ".ui-accordion-header:eq(1)" ).hide();
            accordion.find( ".ui-accordion-header:eq(2)" ).hide();
            accordion.find( ".ui-accordion-header:eq(3)" ).hide();
            var active = accordion.accordion( "option", "active" );
            if ( active >= 1 ) {
                accordion.accordion( "option", "active", 0 );
            }
            if($("#creative_format").val() == "11"){
                $("#click_url_div_text").show();
                $("#ad_desc_div").show();
                $("accordion").hide();
            }
            if($("#creative_format").val() == 15){
                $("#ad_desc_div").show();
            }
            if($("#creative_format").val() >= 15){
                $("#accordion").show();
                accordion.find( ".ui-accordion-header:eq(1)" ).show();
                accordion.find( ".ui-accordion-header:eq(2)" ).show();
                accordion.find( ".ui-accordion-header:eq(3)" ).show();
            }
            if($("#creative_format").val() == 16){
                $("#smallImage").show();
            }
        });
</script>