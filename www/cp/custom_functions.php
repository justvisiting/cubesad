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
function setPublisherSession(){
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
}