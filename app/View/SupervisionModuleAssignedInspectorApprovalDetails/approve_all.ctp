<?php
if (isset($msg) && !empty($msg)) {
    if (is_array($msg)) {
        echo $this->Html->scriptBlock('msg.init(' . json_encode($msg) . ');', array('inline' => true));
    } else {
        echo $this->Html->scriptBlock("msg.init('error', 'Error...', '$msg');", array('inline' => true));
    }
}

if (empty($approvalType))
    $approvalType = "Director's";

$title = "$approvalType Approval for Assigned Inspector";

$pageLoading = array('update' => '#ajax_div', 'evalScripts' => true,
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)));

$this->Paginator->options($pageLoading);
?>

<div>
    <fieldset>
        <legend><?php echo $title; ?></legend>
        <?php echo $this->Form->create('SupervisionModuleAssignedInspectorApprovalDetailAll'); ?>

        <div style="width:780px; height:auto; padding:0; overflow-x:auto;">
            <?php
            if (empty($values_not_approved) || !is_array($values_not_approved) || count($values_not_approved) < 1) {
                echo '<p class="error-message"> No data is available ! </p>';
            } else {
                ?>

                <table class="view">
                    <tr>
                        <?php
                        echo "<th style='width:80px;'>" . $this->Paginator->sort('BasicModuleBasicInformation.license_no', 'License No.') . "</th>";
                        echo "<th style='width:120px;'>" . $this->Paginator->sort('BasicModuleBasicInformation.full_name_of_org', 'Name of Organization') . "</th>";
                        echo "<th style='width:100px;'>" . $this->Paginator->sort('LookupAdminBoundaryDistrict.district_name', 'District') . "</th>";
                        echo "<th style='width:150px;'>" . $this->Paginator->sort('0.name_with_designation_and_dept', 'Inspectors Name & Designation') . "</th>";
                        echo "<th style='width:80px;'>Inspection Date</th>";
                        echo "<th style='width:80px;'>Comments</th>";
                        echo "<th style='width:80px;'>Approve All <input type='checkbox' id='chkbApprovalAll'/> </th>";
                        ?>
                    </tr>
                    <?php
                    $rc = -1;                    
                    foreach ($values_not_approved as $value) {
                        ++$rc;
                        ?>
                        <tr>
                            <td style="text-align:center;">
                                <?php
                                echo $this->Form->input("$rc.supervision_basic_id", array('type' => 'hidden', 'value' => $value['SupervisionModuleBasicInformation']['id'], 'label' => false));
                                echo $value['BasicModuleBasicInformation']['license_no'];
                                ?>
                            </td>
                            <td>
                                <?php
                                $orgName = $value['BasicModuleBasicInformation']['short_name_of_org'];
                                $orgFullName = $value['BasicModuleBasicInformation']['full_name_of_org'];
                                $orgFullName = $orgFullName . ((!empty($orgFullName) && !empty($orgName)) ? " (" . $orgName . ")" : $orgName);
                                echo $this->Js->link($orgFullName, array('controller' => 'SupervisionModuleAssignedInspectorApprovalDetails', 'action' => 'preview', $value['SupervisionModuleAssignedInspectorApprovalDetail']['supervision_basic_id'], $value['BasicModuleBranchInfo']['id']), array_merge($pageLoading, array('update' => '#popup_div')))
                                ?>
                            </td>
                            <td><?php echo $value['LookupAdminBoundaryDistrict']['district_name']; ?></td>
                            <td><?php echo $value['name_with_designation_and_dept']; ?></td>
                            <td><?php echo date("d-m-Y", strtotime($value['SupervisionModuleAssignedInspectorApprovalDetail']['inspection_date'])); ?></td>
                            <td><?php echo $this->Form->input("$rc.tier_wise_comments", array('type' => 'text', 'class' => 'small', 'div' => false, 'label' => false)); ?></td>
                            <td style="text-align:center;"><?php echo $this->Form->input("$rc.is_approved", array('type' => 'checkbox', 'class' => 'isApproved', 'div' => false, 'label' => 'Approve')); ?></td>
                        </tr>
                    <?php } ?>
                </table>

                <?php if ($values_not_approved && $this->Paginator->param('pageCount') > 1) { ?>
                    <div class="paginator">
                        <?php
                        if ($this->Paginator->param('pageCount') > 10) {
                            echo $this->Paginator->first('<<', array('class' => 'prevPg', 'title' => 'Goto first page.'), null, array('class' => 'prevPg no_link')) .
                            $this->Paginator->prev('<', array('class' => 'numbers', 'title' => 'Goto previous page.'), null, array('class' => 'prevPg no_link')) .
                            $this->Paginator->numbers(array('class' => 'numbers', 'separator' => '')) .
                            $this->Paginator->next('>', array('class' => 'numbers', 'title' => 'Goto next page.'), null, array('class' => 'nextPg no_link')) .
                            $this->Paginator->last('<<', array('class' => 'nextPg', 'title' => 'Goto next page.'), null, array('class' => 'nextPg no_link'));
                        } else {
                            echo $this->Paginator->prev('<<', array('class' => 'prevPg', 'title' => 'Goto previous page.'), null, array('class' => 'prevPg no_link')) .
                            $this->Paginator->numbers(array('class' => 'numbers', 'separator' => '')) .
                            $this->Paginator->next('>>', array('class' => 'nextPg', 'title' => 'Goto next page.'), null, array('class' => 'nextPg no_link'));
                        }
                        ?>
                    </div>
                <?php } ?>

            <?php } ?>
        </div>

        <div class="btns-div">                
            <table style="margin:0 auto; padding:5px;" cellspacing="7">
                <tr>
                    <td>
                        <?php
                        echo $this->Js->link('Close', array('controller' => 'SupervisionModuleAssignedInspectorApprovalDetails', 'action' => 'view'), array_merge($pageLoading, array('class' => 'mybtns', 'confirm' => 'Are you sure to Close ?', 'title' => 'Back to Previous Page')));
                        ?> 
                    </td>
                    <td style="text-align:center;">
                        <?php
                        echo $this->Js->submit('Approve All', array_merge($pageLoading, array('class' => 'mybtns', 'confirm' => 'Are you sure to Approve all ?', 'title' => 'Approve All Inspector Assignment',
                            'success' => "msg.init('success', '$title', '$title has been added successfully.');",
                            'error' => "msg.init('error', '$title', 'Insertion failed!');")));
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <?php echo $this->Form->end(); ?>
    </fieldset>
</div>

<script>
    $(document).ready(function () {
        $("#chkbApprovalAll").on("change", function () {
            $(":checkbox.isApproved").prop("checked", this.checked);
        });

        $(":checkbox.isApproved").on("change", function () {
            var total = $(":checkbox.isApproved").length;
            var checked = $(":checkbox.isApproved:checked").length;
            if (total === checked) {
                $("#chkbApprovalAll").prop('checked', true);
                $("#chkbApprovalAll").prop('indeterminate', false);
            } else if (checked === 0) {
                $("#chkbApprovalAll").prop('checked', false);
                $("#chkbApprovalAll").prop('indeterminate', false);
            } else {
                $("#chkbApprovalAll").prop('indeterminate', true);
            }
        });

    });
</script>
