<div class="grid-17">
    <div class="widget widget-plain">
        <div class="widget-content">
            <h2 class="dashboard_title">
                Today - Server Statistics
                <span>All Metrics are displayed in Real Time</span></h2>
                <?php
                    global $user_detail;
                    global $user_right;
                    if(isset($user_right["publisher"])){
                        $reportingdata_main=get_reporting_data("publisher", $today_day, $today_month, $today_year, $user_detail["inv_id"]);
                    }else{
                        $reportingdata_main=get_reporting_data("publisher", $today_day, $today_month, $today_year, '');
                    }
                ?>
                <div class="dashboard_report first activeState">
                    <div class="pad">
                            <span class="value"><?php echo number_format($reportingdata_main['total_requests']); ?></span> Ad Requests
                    </div> <!-- .pad -->
                </div>

                <div class="dashboard_report defaultState">
                    <div class="pad">
                            <span class="value"><?php echo number_format($reportingdata_main['total_impressions']); ?></span> Impressions
                    </div> <!-- .pad -->
                </div>

                <div class="dashboard_report defaultState">
                    <div class="pad">
                            <span class="value"><?php echo number_format($reportingdata_main['total_clicks']); ?></span> Clicks
                    </div> <!-- .pad -->
                </div>
                <div class="dashboard_report defaultState last">
                    <div class="pad">
                            <span class="value"><?php echo $reportingdata_main['ctr']; ?>%</span> CTR
                    </div> <!-- .pad -->
                </div>
            </div> <!-- .widget-content -->		
    </div> <!-- .widget -->
    <?php graph_report_widget("dashboard", "publisher-all", "lastsevendays"); ?>
    <?php quick_publication_report(); ?>
</div> <!-- .grid -->