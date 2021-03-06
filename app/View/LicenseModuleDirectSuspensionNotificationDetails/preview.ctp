<div id="recEvalInfo" title="Detail Information" style="margin:0px; padding:8px; background-color:#fafdff;">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Suspension Details</a></li>
            <li><a href="#tabs-2">Explanation Details</a></li>
            <li><a href="#tabs-3">Explanation Verification</a></li>
            <li><a href="#tabs-4">Suspension Status Details</a></li>
            <li><a href="#tabs-5">Review Application Details</a></li>
            <li><a href="#tabs-6">Review Acceptance Details</a></li>
            <li><a href="#tabs-7">Suspension Notification</a></li> 
        </ul> 
        <div id="tabs-1">
            <?php echo $this->requestAction(array('controller' => 'LicenseModuleDirectSuspensionAndAskForExplanationDetails', 'action' => 'details', $org_id), array('return')); ?>            
        </div>
        <div id="tabs-2">
            <?php echo $this->requestAction(array('controller' => 'LicenseModuleDirectSuspensionMfiExplanationDetails', 'action' => 'details', $org_id), array('return')); ?>            
        </div>
        <div id="tabs-3">
            <?php echo $this->requestAction(array('controller' => 'LicenseModuleDirectSuspensionExplanationVerifyDetails', 'action' => 'verification_details', $org_id), array('return')); ?>
        </div>
        <div id="tabs-4">
            <?php echo $this->requestAction(array('controller' => 'LicenseModuleDirectSuspensionContinueOrDiscontinueDetails', 'action' => 'details', $org_id), array('return')); ?>
        </div>
        <div id="tabs-5">
            <?php echo $this->requestAction(array('controller' => 'LicenseModuleDirectSuspensionApplicationOfReviewDetails', 'action' => 'details', $org_id), array('return')); ?>
        </div>
        <div id="tabs-6">
            <?php echo $this->requestAction(array('controller' => 'LicenseModuleDirectSuspensionAcceptanceOfReviewDetails', 'action' => 'details', $org_id), array('return')); ?>
        </div> 
        <div id="tabs-7">
            <?php echo $this->requestAction(array('controller' => 'LicenseModuleDirectSuspensionNotificationDetails', 'action' => 'details', $org_id), array('return')); ?>
        </div>
    </div>        
</div>

<script>
    $(function () {        
        $("#tabs").tabs({active: -1});
        //$("#tabs").tabs({event: "mouseover"});
        
        $("#recEvalInfo").dialog({
            modal: true, width: 'auto', height: 'auto', resizable: false, dialogClass: 'my-dialog-box', 
            buttons: {
                Close: function () {
                    $(this).dialog("close");
                }
            },
            create: function(evt, ui) {
                $(this).css("minWidth", "850px").css("maxWidth", "1000px");
            }
        });
    });
</script>