<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* get budget for all Or selected Campaigns*/
function getBudgetForCampaigns($data){
    //if ($data['report_type']=='campaign'){
        $clickCost = 0;
        $impressionCost = 0;
        $totalBudget = 0;
        $budgetTtl = 0;
        $sql = "SELECT campaign_id,budget FROM md_campaigns ";
        if(isset($data['reporting_campaign']) && $data['reporting_campaign'] > "0"){
            $sql .= "WHERE campaign_id = {$data['reporting_campaign']}";
        }
        $campaignBudgetArr = array();
        $reult = mysql_query($sql);
        while($budgetArr = mysql_fetch_array($reult)){
            $budgetTtl += $budgetArr["budget"];
            //print_r($budgetArr);
            $campaignBudgetArr[$budgetArr["campaign_id"]] = $budgetArr["budget"];
        }
        // now we have campaings and their budget.
        
        $sql2 = "SELECT * FROM md_campaign_view ";
        if($data['reporting_campaign'] > 0){
            $sql2 .= "WHERE campaign_id = {$data['reporting_campaign']}";
        }
        $result = mysql_query($sql2);
        
        $uniqueCamp = array();
        $countOfTotalClickOrImpression = 0;
        while($view = mysql_fetch_array($result)){
            $countOfTotalClickOrImpression++;
            if(!in_array($view["campaign_id"], $uniqueCamp)){
                $totalBudget += $campaignBudgetArr[$view["campaign_id"]];
                $uniqueCamp[] = $view["campaign_id"];
            }
            //means its an impression
            if($view["is_impression"] == 1){
                $impressionCost += ($view["debit"]/1000);
            }else if($view["is_impression"] == 2){
                //means its a click.
                $clickCost += $view["debit"];
            }
        }
        // when there is no click or impression then on ad
        // total balance will be calculated like this.
        if($countOfTotalClickOrImpression==0){
            $totalBudget = $budgetTtl;
        }
        $remain = (float) $totalBudget-($impressionCost+$clickCost);
        return $remain;
    //}
}
        //get earnings for all or selected publisher
function getEarningFromCampaign($data){
    $sql = "SELECT * FROM md_campaign_view ";
    if($data['reporting_publication'] > 0){
        $sql .= "WHERE publication_id = {$data['reporting_publication']}";
    }
    $result = mysql_query($sql);
    $clickCost = 0;
    $impressionCost = 0;
    while($view = mysql_fetch_array($result)){
        //means its an impression
        if($view["is_impression"] == 1){
            $impressionCost += ($view["debit"]/1000);
        }else if($view["is_impression"] == 2){
            //means its a click.
            $clickCost += $view["debit"];
        }
    }
    $earning = (float) ($impressionCost+$clickCost);
    return $earning;
}


function insertDeviceTargeting($targetDevices,$campaignId,$dbLink,$data){
    // delete old records from md_device_targeting because 
    // count of selected target device may be different
    // thats why we delete the old records and add the new selected devices [rather than update each device each time.]
    $sql = "DELETE FROM md_device_targeting WHERE campaign_id = $campaignId";
    mysql_query($sql,$dbLink);
    if(count($targetDevices) > 0){
    // Insert device to campaigns
        $sql = "INSERT INTO md_device_targeting (campaign_id,device_id,max,min) VALUES ";
        $comma = "";
        foreach($targetDevices as $td){
            $min = isset($data["version_min$td"]) && strlen(trim($data["version_min$td"])) > 0 ? trim($data["version_min$td"]) : 0;
            $max = isset($data["version_max$td"])  && strlen(trim($data["version_max$td"])) > 0 ? trim($data["version_max$td"]) : 0;
            $sql .= $comma . "($campaignId,$td,$max,$min)";
            $comma = ",";
        }
        //echo $sql;
        mysql_query($sql, $dbLink);
    }
}

function insertClickOrImpression($campaign_id,$current_timestamp,$publication_id,$add_impression,$add_click,$dblink){
    $qry = "SELECT max_pricing,campaign_owner,bid_type FROM md_campaigns WHERE campaign_id = $campaign_id";
    $result = mysql_query($qry,$dblink);
    if(!$result){
        die("db error");
    }
    $row = mysql_fetch_row($result);
    $debit = $row[0];
    $advertiser_id = $row[1];
    $bidType = 0;
    if($row[2]== 1 && $add_impression == 1){
        $bidType = 1;
        $sql = "INSERT INTO md_campaign_view (timestamp, is_impression, debit, advertiser_id,publication_id,campaign_id) VALUES($current_timestamp,$bidType,$debit,$advertiser_id,$publication_id,$campaign_id)";
        mysql_query($sql,$dblink);
    }else if($row[2] == 2 && $add_click == 1){
        $bidType = 2;
        $sql = "INSERT INTO md_campaign_view (timestamp, is_impression, debit, advertiser_id,publication_id,campaign_id) VALUES($current_timestamp,$bidType,$debit,$advertiser_id,$publication_id,$campaign_id)";
        mysql_query($sql,$dblink);
    }
    
}
// check for duplicate publication email id on add,edit.
// for edit we pass $pubId.
function pub_isDuplicateEmail($email,$dblink,$pubId=""){
    $sql = "SELECT inv_id FROM md_publications WHERE email_address = '$email'";
    if(strlen($pubId) > 0 ){
        $sql .= " AND inv_id NOT IN($pubId)";
    }
    $result = mysql_query($sql,$dblink);
    $count = 0;
    if(!$result){
        die("db error");
    }else{
        while($view = mysql_fetch_array($result)){
            $count++;
            break;
        }   
    }
    return $count == 0 ? false : true;
}

function pub_login($username,$password){    	
    global $maindb;
    $username = mysql_real_escape_string(stripslashes($username));
    $password = mysql_real_escape_string(stripslashes($password));
    $username=strtolower($username);
    if (logincheck()){
        return true;
    }
    $resultu=mysql_query("select * from md_publications where email_address='$username'", $maindb);
    $usert1=mysql_fetch_array($resultu);



    $username_db = $usert1['email_address'];
    $password_db = $usert1['pass_word'];
    //$account_status = $usert1['account_status'];

    $login_username=$username;
    $login_password=md5($password);

    $code_p = uniqid ($username, true); // GENERATE SESSION ID
    $sessid = md5($code_p);


    if ($username_db==$login_username && $login_password==$password_db){
        //if ($account_status=="1"){
            $date_n        = mktime(date("G"), date("i"), date("s"), date("m")  , date("d")+100, date("Y")); // Generate date
            mysql_query("INSERT INTO `md_usessions` VALUES('', '$sessid', '$date_n', '1', '$username', '$login_password', '1', '', '".time()."')", $maindb);
            $inTwoMonths = 60 * 60 * 24 * 60 + time();
            setcookie('md_loginsession', $sessid, $inTwoMonths); 
            return true;
        //}
    }
    return false;
}
/*function setPublisherSession(){
    if(isset($_COOKIE["md_loginsession"])){
        $sessionId = $_COOKIE["md_loginsession"];
        $sql = "SELECT user_identification FROM md_usessions WHERE session_id = '$sessionId' AND session_status = 1";
        $result = mysql_query($sql);
        $userExists = false;
        $email = NULL;
        while($row = mysql_fetch_array($result)){
            $email = $row["user_identification"];
        }
        if($email != NULL){
            $sql = "SELECT inv_name,email_address FROM md_publications WHERE email_address = '$email'";
            $result = mysql_query($sql);
            global $user_detail;
            $user_detail = mysql_fetch_array($result);
        }
    }
}*/

function getCountries(){
    $str = <<<EOT
    <option value="United States">United States</option> 
<option value="United Kingdom">United Kingdom</option> 
<option value="Afghanistan">Afghanistan</option> 
<option value="Albania">Albania</option> 
<option value="Algeria">Algeria</option> 
<option value="American Samoa">American Samoa</option> 
<option value="Andorra">Andorra</option> 
<option value="Angola">Angola</option> 
<option value="Anguilla">Anguilla</option> 
<option value="Antarctica">Antarctica</option> 
<option value="Antigua and Barbuda">Antigua and Barbuda</option> 
<option value="Argentina">Argentina</option> 
<option value="Armenia">Armenia</option> 
<option value="Aruba">Aruba</option> 
<option value="Australia">Australia</option> 
<option value="Austria">Austria</option> 
<option value="Azerbaijan">Azerbaijan</option> 
<option value="Bahamas">Bahamas</option> 
<option value="Bahrain">Bahrain</option> 
<option value="Bangladesh">Bangladesh</option> 
<option value="Barbados">Barbados</option> 
<option value="Belarus">Belarus</option> 
<option value="Belgium">Belgium</option> 
<option value="Belize">Belize</option> 
<option value="Benin">Benin</option> 
<option value="Bermuda">Bermuda</option> 
<option value="Bhutan">Bhutan</option> 
<option value="Bolivia">Bolivia</option> 
<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
<option value="Botswana">Botswana</option> 
<option value="Bouvet Island">Bouvet Island</option> 
<option value="Brazil">Brazil</option> 
<option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
<option value="Brunei Darussalam">Brunei Darussalam</option> 
<option value="Bulgaria">Bulgaria</option> 
<option value="Burkina Faso">Burkina Faso</option> 
<option value="Burundi">Burundi</option> 
<option value="Cambodia">Cambodia</option> 
<option value="Cameroon">Cameroon</option> 
<option value="Canada">Canada</option> 
<option value="Cape Verde">Cape Verde</option> 
<option value="Cayman Islands">Cayman Islands</option> 
<option value="Central African Republic">Central African Republic</option> 
<option value="Chad">Chad</option> 
<option value="Chile">Chile</option> 
<option value="China">China</option> 
<option value="Christmas Island">Christmas Island</option> 
<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
<option value="Colombia">Colombia</option> 
<option value="Comoros">Comoros</option> 
<option value="Congo">Congo</option> 
<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> 
<option value="Cook Islands">Cook Islands</option> 
<option value="Costa Rica">Costa Rica</option> 
<option value="Cote D'ivoire">Cote D'ivoire</option> 
<option value="Croatia">Croatia</option> 
<option value="Cuba">Cuba</option> 
<option value="Cyprus">Cyprus</option> 
<option value="Czech Republic">Czech Republic</option> 
<option value="Denmark">Denmark</option> 
<option value="Djibouti">Djibouti</option> 
<option value="Dominica">Dominica</option> 
<option value="Dominican Republic">Dominican Republic</option> 
<option value="Ecuador">Ecuador</option> 
<option value="Egypt">Egypt</option> 
<option value="El Salvador">El Salvador</option> 
<option value="Equatorial Guinea">Equatorial Guinea</option> 
<option value="Eritrea">Eritrea</option> 
<option value="Estonia">Estonia</option> 
<option value="Ethiopia">Ethiopia</option> 
<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
<option value="Faroe Islands">Faroe Islands</option> 
<option value="Fiji">Fiji</option> 
<option value="Finland">Finland</option> 
<option value="France">France</option> 
<option value="French Guiana">French Guiana</option> 
<option value="French Polynesia">French Polynesia</option> 
<option value="French Southern Territories">French Southern Territories</option> 
<option value="Gabon">Gabon</option> 
<option value="Gambia">Gambia</option> 
<option value="Georgia">Georgia</option> 
<option value="Germany">Germany</option> 
<option value="Ghana">Ghana</option> 
<option value="Gibraltar">Gibraltar</option> 
<option value="Greece">Greece</option> 
<option value="Greenland">Greenland</option> 
<option value="Grenada">Grenada</option> 
<option value="Guadeloupe">Guadeloupe</option> 
<option value="Guam">Guam</option> 
<option value="Guatemala">Guatemala</option> 
<option value="Guinea">Guinea</option> 
<option value="Guinea-bissau">Guinea-bissau</option> 
<option value="Guyana">Guyana</option> 
<option value="Haiti">Haiti</option> 
<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> 
<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
<option value="Honduras">Honduras</option> 
<option value="Hong Kong">Hong Kong</option> 
<option value="Hungary">Hungary</option> 
<option value="Iceland">Iceland</option> 
<option value="India">India</option> 
<option value="Indonesia">Indonesia</option> 
<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option> 
<option value="Iraq">Iraq</option> 
<option value="Ireland">Ireland</option> 
<option value="Israel">Israel</option> 
<option value="Italy">Italy</option> 
<option value="Jamaica">Jamaica</option> 
<option value="Japan">Japan</option> 
<option value="Jordan">Jordan</option> 
<option value="Kazakhstan">Kazakhstan</option> 
<option value="Kenya">Kenya</option> 
<option value="Kiribati">Kiribati</option> 
<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> 
<option value="Korea, Republic of">Korea, Republic of</option> 
<option value="Kuwait">Kuwait</option> 
<option value="Kyrgyzstan">Kyrgyzstan</option> 
<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> 
<option value="Latvia">Latvia</option> 
<option value="Lebanon">Lebanon</option> 
<option value="Lesotho">Lesotho</option> 
<option value="Liberia">Liberia</option> 
<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
<option value="Liechtenstein">Liechtenstein</option> 
<option value="Lithuania">Lithuania</option> 
<option value="Luxembourg">Luxembourg</option> 
<option value="Macao">Macao</option> 
<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> 
<option value="Madagascar">Madagascar</option> 
<option value="Malawi">Malawi</option> 
<option value="Malaysia">Malaysia</option> 
<option value="Maldives">Maldives</option> 
<option value="Mali">Mali</option> 
<option value="Malta">Malta</option> 
<option value="Marshall Islands">Marshall Islands</option> 
<option value="Martinique">Martinique</option> 
<option value="Mauritania">Mauritania</option> 
<option value="Mauritius">Mauritius</option> 
<option value="Mayotte">Mayotte</option> 
<option value="Mexico">Mexico</option> 
<option value="Micronesia, Federated States of">Micronesia, Federated States of</option> 
<option value="Moldova, Republic of">Moldova, Republic of</option> 
<option value="Monaco">Monaco</option> 
<option value="Mongolia">Mongolia</option> 
<option value="Montserrat">Montserrat</option> 
<option value="Morocco">Morocco</option> 
<option value="Mozambique">Mozambique</option> 
<option value="Myanmar">Myanmar</option> 
<option value="Namibia">Namibia</option> 
<option value="Nauru">Nauru</option> 
<option value="Nepal">Nepal</option> 
<option value="Netherlands">Netherlands</option> 
<option value="Netherlands Antilles">Netherlands Antilles</option> 
<option value="New Caledonia">New Caledonia</option> 
<option value="New Zealand">New Zealand</option> 
<option value="Nicaragua">Nicaragua</option> 
<option value="Niger">Niger</option> 
<option value="Nigeria">Nigeria</option> 
<option value="Niue">Niue</option> 
<option value="Norfolk Island">Norfolk Island</option> 
<option value="Northern Mariana Islands">Northern Mariana Islands</option> 
<option value="Norway">Norway</option> 
<option value="Oman">Oman</option> 
<option value="Pakistan">Pakistan</option> 
<option value="Palau">Palau</option> 
<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
<option value="Panama">Panama</option> 
<option value="Papua New Guinea">Papua New Guinea</option> 
<option value="Paraguay">Paraguay</option> 
<option value="Peru">Peru</option> 
<option value="Philippines">Philippines</option> 
<option value="Pitcairn">Pitcairn</option> 
<option value="Poland">Poland</option> 
<option value="Portugal">Portugal</option> 
<option value="Puerto Rico">Puerto Rico</option> 
<option value="Qatar">Qatar</option> 
<option value="Reunion">Reunion</option> 
<option value="Romania">Romania</option> 
<option value="Russian Federation">Russian Federation</option> 
<option value="Rwanda">Rwanda</option> 
<option value="Saint Helena">Saint Helena</option> 
<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
<option value="Saint Lucia">Saint Lucia</option> 
<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
<option value="Samoa">Samoa</option> 
<option value="San Marino">San Marino</option> 
<option value="Sao Tome and Principe">Sao Tome and Principe</option> 
<option value="Saudi Arabia">Saudi Arabia</option> 
<option value="Senegal">Senegal</option> 
<option value="Serbia and Montenegro">Serbia and Montenegro</option> 
<option value="Seychelles">Seychelles</option> 
<option value="Sierra Leone">Sierra Leone</option> 
<option value="Singapore">Singapore</option> 
<option value="Slovakia">Slovakia</option> 
<option value="Slovenia">Slovenia</option> 
<option value="Solomon Islands">Solomon Islands</option> 
<option value="Somalia">Somalia</option> 
<option value="South Africa">South Africa</option> 
<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> 
<option value="Spain">Spain</option> 
<option value="Sri Lanka">Sri Lanka</option> 
<option value="Sudan">Sudan</option> 
<option value="Suriname">Suriname</option> 
<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
<option value="Swaziland">Swaziland</option> 
<option value="Sweden">Sweden</option> 
<option value="Switzerland">Switzerland</option> 
<option value="Syrian Arab Republic">Syrian Arab Republic</option> 
<option value="Taiwan, Province of China">Taiwan, Province of China</option> 
<option value="Tajikistan">Tajikistan</option> 
<option value="Tanzania, United Republic of">Tanzania, United Republic of</option> 
<option value="Thailand">Thailand</option> 
<option value="Timor-leste">Timor-leste</option> 
<option value="Togo">Togo</option> 
<option value="Tokelau">Tokelau</option> 
<option value="Tonga">Tonga</option> 
<option value="Trinidad and Tobago">Trinidad and Tobago</option> 
<option value="Tunisia">Tunisia</option> 
<option value="Turkey">Turkey</option> 
<option value="Turkmenistan">Turkmenistan</option> 
<option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
<option value="Tuvalu">Tuvalu</option> 
<option value="Uganda">Uganda</option> 
<option value="Ukraine">Ukraine</option> 
<option value="United Arab Emirates">United Arab Emirates</option> 
<option value="United Kingdom">United Kingdom</option> 
<option value="United States">United States</option> 
<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
<option value="Uruguay">Uruguay</option> 
<option value="Uzbekistan">Uzbekistan</option> 
<option value="Vanuatu">Vanuatu</option> 
<option value="Venezuela">Venezuela</option> 
<option value="Viet Nam">Viet Nam</option> 
<option value="Virgin Islands, British">Virgin Islands, British</option> 
<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
<option value="Wallis and Futuna">Wallis and Futuna</option> 
<option value="Western Sahara">Western Sahara</option> 
<option value="Yemen">Yemen</option> 
<option value="Zambia">Zambia</option> 
<option value="Zimbabwe">Zimbabwe</option>
EOT;
    return $str;
}