<div id="basicInfo" title="Detail Information of Organization" style="margin:0px; padding:10px; background-color:#fafdff;"> 
    <fieldset>        
        <div class="datagrid" style="max-height:430px; overflow-y:auto; color:#232428;">
            <table cellpadding="7" cellspacing="8" border="0">              
                <tr>
                    <td style="width:25%;">Short Name of Organization</td>
                    <td class="colons">:</td>
                    <td><?php echo $allDetails['BasicModuleBasicInformation']['short_name_of_org']; ?></td>
                </tr>
                <tr>
                    <td>Full Name of Organization</td>
                    <td class="colons">:</td>
                    <td><?php echo $allDetails['BasicModuleBasicInformation']['full_name_of_org']; ?></td>
                </tr>
                <tr>
                    <td>License No</td>
                    <td class="colons">:</td>
                    <td><?php echo $allDetails['BasicModuleBasicInformation']['license_no']; ?></td>
                </tr>
                <tr>
                    <td>License Issue Date</td>
                    <td class="colons">:</td>
                    <td><?php echo $allDetails['BasicModuleBasicInformation']['license_issue_date']; ?></td>
                </tr>
                <tr>
                    <td>Date of Suspend Order</td>
                    <td class="colons">:</td>
                    <td><?php echo $allDetails['LicenseModuleDirectSuspensionAndAskForExplanationDetail']['suspension_order_date']; ?></td>
                </tr>
                <tr>
                    <td>Reasons</td>
                    <td class="colons">:</td>
                    <td><?php echo $allDetails['LicenseModuleDirectSuspensionAndAskForExplanationDetail']['suspension_reasons']; ?></td>
                </tr>
                <tr>
                    <td>Ask for Explanation Details</td>
                    <td class="colons">:</td>
                    <td><?php echo $allDetails['LicenseModuleDirectSuspensionAndAskForExplanationDetail']['ask_for_explanation_details']; ?></td>
                </tr>
            </table>
        </div>
    </fieldset>
</div>