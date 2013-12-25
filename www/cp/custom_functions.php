<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* get budget for all Or selected Campaigns*/
function getBudgetForCampaigns($data){
    //if ($data['report_type']=='campaign'){
        $sql = "SELECT campaign_id,budget,bid_pricing FROM md_campaigns ";
        if(isset($data['reporting_campaign']) && $data['reporting_campaign'] > "0"){
            $sql .= "WHERE campaign_id = {$data['reporting_campaign']}";
        }
        $campaignBudgetArr = array();
        $reult = mysql_query($sql);
        while($budgetArr = mysql_fetch_array($reult)){
            //print_r($budgetArr);
            $campaignBudgetArr[$budgetArr["campaign_id"]] = array(
                "budget" => $budgetArr["budget"],
                "bidType" => $budgetArr["bid_pricing"]
                );
        }
        // now we have campaings and their budget.
        
        $sql = "SELECT * FROM md_campaign_view ";
        if($data['reporting_campaign'] > 0){
            $sql .= "WHERE campaign_id = {$data['reporting_campaign']}";
        }
        $result = mysql_query($sql);
        $clickCost = 0;
        $impressionCost = 0;
        $totalBudget = 0;
        $bidType = "";
        $uniqueCamp = array();
        while($view = mysql_fetch_array($result)){
            if(!in_array($view["campaign_id"], $uniqueCamp)){
                $totalBudget += $campaignBudgetArr[$view["campaign_id"]]["budget"];
                $bidType = $campaignBudgetArr[$view["campaign_id"]]["bidType"];
                $uniqueCamp[] = $view["campaign_id"];
            }
            if($bidType == $view["is_impression"] && $view["is_impression"] == 1){
                $impressionCost += ($view["debit"]/1000);
            }
            if($bidType == $view["is_impression"] && $view["is_impression"] == 2){
                $clickCost += $view["debit"];
            }
        }
        $remain = (float) $totalBudget-($impressionCost+$clickCost);
        return $remain;
    //}
}
function getEarningFromCampaign($data){
        $sql = "SELECT campaign_id,bid_pricing FROM md_campaigns ";
        $campaignBudgetArr = array();
        $reult = mysql_query($sql);
        while($budgetArr = mysql_fetch_array($reult)){
            //print_r($budgetArr);
            $campaignBudgetArr[$budgetArr["campaign_id"]] = array(
                "bidType" => $budgetArr["bid_pricing"]
                );
        }
        // now we have campaings and their budget.
        
    //if ($data['report_type']=='publication'){        
        $sql = "SELECT * FROM md_campaign_view ";
        if($data['reporting_publication'] > 0){
            $sql .= "WHERE publication_id = {$data['reporting_publication']}";
        }
        $result = mysql_query($sql);
        $clickCost = 0;
        $impressionCost = 0;
        //$uniqueCamp = array();
        while($view = mysql_fetch_array($result)){
            $bidType = $campaignBudgetArr[$view["campaign_id"]]["bidType"];
            if($bidType == $view["is_impression"] && $view["is_impression"] == 1){
                $impressionCost += ($view["debit"]/1000);
            }
            if($bidType == $view["is_impression"] && $view["is_impression"] == 2){
                $clickCost += $view["debit"];
            }
        }
        $earning = (float) ($impressionCost+$clickCost);
        return $earning;
    //}
}
        //get Budget for Campaign.

        /*

        //get all ad hits related to campaigns.
        $sql = "SELECT campaign_id,time_stamp,total_impressions,total_clicks FROM md_reporting ". get_rep_limitation_query($data).' '.get_rep_date_query($data).' ';
        $result = mysql_query($sql);
        $clickCost = 0;
        $impressionCost = 0;
        while($report = mysql_fetch_array($result)){
            $budget = $campaignBudgetArr[$report["campaign_id"]];
            $bidPrice = getBidPriceDuringThatTime($report["campaign_id"],$report["time_stamp"]);
            if($report["total_clicks"] == 1){
                $clickCost += $bidPrice;
            }if($report["total_impressions"] == 1){
                $impressionCost += ($bidPrice/1000);
            }
            // get comapign bids during perticular time period
            /*$sql = "SELECT campaign_id,bid_pricing,max_pricing,creation_date FROM md_campaign_bid WHERE campaign_id = {$report["campaign_id"]} ORDER BY creation_date ASC";
            $rslt = mysql_query($sql);
            $campaign_bids = mysql_fetch_array($rslt);
            $clickCost = 0;
            $impressionCost = 0;
            for($i=0;$i < count($campaign_bids);$i++){
                $compaign_bid = $campaign_bids[$i];
                $campaign_start_date = $campaign_bid["creation_date"];
                $campaign_end_date = isset($campaign_bids[$i]["creation_date"]) ?  $campaign_bids[$i]["creation_date"] : time();
                if($campaign_start_date < $report["time_stamp"] && $campaign_end_date > $report["time_stamp"]){
                    if($compaign_bid["bid_pricing"] == "1"){
                        $clickCost += $compaign_bid["max_pricing"];
                    }else if($compaign_bid["bid_pricing"] == "2"){
                        $impressionCost += ($compaign_bid["max_pricing"]/1000);
                    }
                }
            }*/

                /*$camp_bid_time_relation["campaign_id"] = array(
                        "pricing_type" => $campaign_bids[$i]["bid_pricing"],
                        "bidprice" => $campaign_bids[$i]["max_pricing"],
                        "bidstarttime" => $campaign_bids[$i]["creation_date"],
                        "bidendtime" => isset($campaign_bids[$i+1]["creation_date"]) ? $campaign_bids[$i+1]["creation_date"] : time()
                );
                /*$camp_bid_time_relation["campaign_id"] = $campaign_bids[$i]["campaign_id"];
                $camp_bid_time_relation["pricing_type"] = $campaign_bids[$i]["bid_pricing"];
                $camp_bid_time_relation["bidprice"] = $campaign_bids[$i]["max_pricing"];
                $camp_bid_time_relation["bidstarttime"] = $campaign_bids[$i]["creation_date"];
                if(isset($campaign_bids[$i+1]["creation_date"])){
                    $camp_bid_time_relation["bidendtime"] = $campaign_bids[$i+1]["creation_date"];
                }else{
                    $camp_bid_time_relation["bidendtime"] = time();
                }*/
        /*}
        //echo $budget - $clickCost - $impressionCost;
    }
}
function getBidPriceDuringThatTime($campId,$timeStamp){
    $sql = "SELECT campaign_id,max_pricing,creation_date FROM md_campaign_bid WHERE campaign_id = {$campId} ORDER BY creation_date ASC";
    $rslt = mysql_query($sql);
    $campaign_bids = array();
    while($camp =  mysql_fetch_array($rslt)){
        $campaign_bids[] = $camp;
    }
    for($i=0;$i < count($campaign_bids);$i++){
        $starttime = $campaign_bids[$i]["creation_date"];
        $endtime = isset($campaign_bids[$i+1]["creation_date"]) ? $campaign_bids[$i+1]["creation_date"] : time();
        if($starttime < $timeStamp && $endtime > $timeStamp){
            return $campaign_bids[$i]["max_pricing"];
        } 
    }
    return 0;
}
*/