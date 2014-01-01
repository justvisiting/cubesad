<li id="navForms" class="nav<?php if ($current_section=="inventory"){echo " active"; } ?>">
    <span class="icon-iphone"></span>
    <a href="#">Inventory</a>
    <ul class="subNav">
        <li><a href="add_placement.php">+ Add Placement</a></li>
        <li><a href="integration.php">Integration</a></li>
    </ul>								
</li>
<li id="navCharts" class="nav<?php if ($current_section=="reporting"){echo " active"; } ?>">
        <span class="icon-chart"></span>
        <a href="#">Reporting</a>
        <ul class="subNav">
            <li><a href="reporting.php?type=publication">Publication Reporting</a></li>
        </ul>	
</li>
<li id="navCharts" class="nav<?php if ($current_section=="payment"){echo " active"; } ?>">
        <span class="icon-transfer"></span>
        <a href="#">Payment</a>
        <ul class="subNav">
            <li><a href="payment.php">Payment</a></li>
        </ul>	
</li>