<div id="recEvalInfo" title="Detail Information" style="margin:0px; padding:8px; background-color:#fafdff;">
    <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Reason Details</a></li>
          <li><a href="#tabs-2">Explanation Details</a></li>          
        </ul>        
        <div id="tabs-1">
            <?php echo $this->requestAction(array('controller'=>'LicenseModuleDirectSuspensionAndAskForExplanationDetails', 'action'=>'details', $org_id), array('return')); ?>            
        </div>
        <div id="tabs-2">
            <?php echo $this->requestAction(array('controller' => 'LicenseModuleDirectSuspensionMfiExplanationDetails', 'action' => 'details', $org_id), array('return')); ?>
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