<?php
    $title = 'Administrative Approval for Assigned Inspector';
    
    $pageLoading = array('update' => '#ajax_div', 'evalScripts' => true, 
                'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)), 
                'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)));

    $this->Paginator->options($pageLoading); ?>

<div>
    <fieldset>
        <legend><?php echo $title; ?></legend>
        
        <div class="form">
            
            <?php if(empty($org_id)) { 
                echo $this->Form->create('LicenseModuleInitialFieldInspectorAdminApprovalSearch'); ?>
                <table cellpadding="0" cellspacing="0" border="0">                           
                    <tr>
                        <td style="padding-left:15px; text-align:right;">Search Option</td>
                        <td>
                            <?php 
                                echo $this->Form->input('search_option', 
                                        array('label' => false, 'style'=>'width:200px',
                                            'options' => 
                                                array('BasicModuleBasicInformation.full_name_of_org' => 'Organization\'s Full Name',
                                                    'BasicModuleBasicInformation.short_name_of_org' => 'Organization\'s Short Name',
                                                    'BasicModuleBasicInformation.license_no'=>'License No.')
                                                ));
                            ?>
                        </td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->input('search_keyword',array('label' => false,'style'=>'width:250px')); ?></td>
                        <td style="text-align:left;">
                           <?php
                               echo $this->Js->submit('Search', array_merge($pageLoading, array('class'=>'btnsearch')));
                            ?>
                       </td>                                
                    </tr>
                </table>
            <?php echo $this->Form->end(); } ?>
            
            
            <fieldset>
                <legend>Administrative Approval Completed</legend>
                
                <?php 
                    if(empty($values_approved) || !is_array($values_approved) || count($values_approved) < 1) {
                        echo '<p class="error-message">';
                        echo 'No data is available!';
                        echo '</p>';
                    }
                    else { 
                ?>
                
                <table class="view">
                    <tr>
                        <?php 
                            echo "<th style='width:70px;'>" . $this->Paginator->sort('BasicModuleBasicInformation.license_no', 'License No.') . "</th>";
                            echo "<th style='min-width:170px;'>" . $this->Paginator->sort('BasicModuleBasicInformation.full_name_of_org', 'Name of Organization') . "</th>";
                            echo "<th style='width:120px;'>" . $this->Paginator->sort('LookupAdminBoundaryDistrict.district_name', 'District') . "</th>";
                            echo "<th style='width:150px;'>" . $this->Paginator->sort('0.inspectors_name_with_designation_and_dept', 'Inspectors Name & Designation') . "</th>";
                            echo "<th style='width:80px;'>" . $this->Paginator->sort('LicenseModuleSuspensionFieldInspectorDetail.inspection_date', 'Inspection Date') . "</th>";
                            echo "<th style='width:75px;'>Action</th>";
                        ?>
                    </tr>
                    <?php foreach($values_approved as $value) { ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $value['BasicModuleBasicInformation']['license_no']; ?></td>
                        <td>
                            <?php 
                                $mfiName = $value['BasicModuleBasicInformation']['short_name_of_org'];
                                $mfiFullName = $value['BasicModuleBasicInformation']['full_name_of_org'];

                                if (!empty($mfiName))
                                    $mfiName = "<strong>".$mfiName.":</strong> ";
                                if (!empty($mfiFullName))
                                    $mfiName = $mfiName.$mfiFullName;

                                echo $mfiName;
                            ?>
                        </td>
                        <td><?php echo $value['LookupAdminBoundaryDistrict']['district_name']; ?></td>
                        <td><?php echo $value[0]['inspectors_name_with_designation_and_dept']; ?></td>
                        <td><?php echo date("d-m-Y", strtotime($value['LicenseModuleSuspensionFieldInspectorDetail']['inspection_date'])); ?></td>
                        <td><?php echo $this->Js->link('Approval Cancel', array('controller' => 'LicenseModuleDirectSuspensionFieldInspAdminApprovalDetails', 'action' => 'approve_cancel', $value['BasicModuleBasicInformation']['id']), array_merge($pageLoading, array('class'=>'btnlink', 'confirm'=>'Are you sure to Cancel Approval ?', 'title'=>'Administrative Approval Cancel'))); ?></td>
                    </tr>
                  <?php } ?>
                </table>
                    
                <?php                
                    if(count($values_approved) > 1 ) {
                        echo '<div class="btns-div" style="padding:7px; text-align:center;">'
                                . $this->Js->link('Update All', array('controller' => 'LicenseModuleDirectSuspensionFieldInspAdminApprovalDetailss', 'action' => 'approve_edit_all'), array_merge($pageLoading, array('class'=>'mybtns', 'title'=>'Cancel Administrative Approval of All Assigned Inspector.')))
                            . '</div>';
                    }
                ?>
                
                <?php if(!empty($values_approved) && $this->Paginator->param('pageCount') > 1) { ?>
                <div class="paginator">
                    <?php 

                    if($this->Paginator->param('pageCount')>10)
                    {
                       echo $this->Paginator->first('<<', array('class' => 'prevPg', 'title' => 'Goto first page.'), null, array('class' => 'prevPg no_link')).
                            $this->Paginator->prev('<', array('class' => 'numbers', 'title' => 'Goto previous page.'), null, array('class' => 'prevPg no_link')).
                            $this->Paginator->numbers(array('class' => 'numbers', 'separator' => '')).
                            $this->Paginator->next('>', array('class' => 'numbers', 'title' => 'Goto next page.'), null, array('class' => 'nextPg no_link')).
                            $this->Paginator->last('<<', array('class' => 'nextPg', 'title' => 'Goto next page.'), null, array('class' => 'nextPg no_link'));
                    }
                    else {
                       echo $this->Paginator->prev('<<', array('class' => 'prevPg', 'title' => 'Goto previous page.'), null, array('class' => 'prevPg no_link')).
                            $this->Paginator->numbers(array('class' => 'numbers', 'separator' => '')).
                            $this->Paginator->next('>>', array('class' => 'nextPg', 'title' => 'Goto next page.'), null, array('class' => 'nextPg no_link'));
                    }
                  ?>
                </div>
                <?php } ?>
                                
            <?php } ?>

            </fieldset>
            
            <fieldset>
                <legend>Administrative Approval Pending</legend>
                <?php 
                    if(empty($values_not_approved) || !is_array($values_not_approved) || count($values_not_approved) < 1) {
                        echo '<p class="error-message">';
                        echo 'No data is available !';
                        echo '</p>';
                    }
                    else {
                ?>
                
                <table class="view">
                    <tr>
                        <?php 
                            echo "<th style='width:70px;'>" . $this->Paginator->sort('BasicModuleBasicInformation.license_no', 'License No.') . "</th>";
                            echo "<th style='min-width:170px;'>" . $this->Paginator->sort('BasicModuleBasicInformation.full_name_of_org', 'Name of Organization') . "</th>";
                            echo "<th style='width:120px;'>" . $this->Paginator->sort('LookupAdminBoundaryDistrict.district_name', 'District') . "</th>";
                            echo "<th style='width:150px;'>" . $this->Paginator->sort('0.inspectors_name_with_designation_and_dept', 'Inspectors Name & Designation') . "</th>";
                            echo "<th style='width:80px;'>" . $this->Paginator->sort('LicenseModuleSuspensionFieldInspectorDetail.inspection_date', 'Inspection Date') . "</th>";
                            echo "<th style='width:75px;'>Action</th>";
                        ?>
                    </tr>
                    <?php foreach($values_not_approved as $value) { ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $value['BasicModuleBasicInformation']['license_no']; ?></td>
                        <td>
                            <?php 
                                $mfiName = $value['BasicModuleBasicInformation']['short_name_of_org'];
                                $mfiFullName = $value['BasicModuleBasicInformation']['full_name_of_org'];

                                if (!empty($mfiName))
                                    $mfiName = "<strong>".$mfiName.":</strong> ";
                                if (!empty($mfiFullName))
                                    $mfiName = $mfiName.$mfiFullName;

                                echo $mfiName;
                            ?>
                        </td>
                        <td><?php echo $value['LookupAdminBoundaryDistrict']['district_name']; ?></td>
                        <td><?php echo $value[0]['inspectors_name_with_designation_and_dept']; ?></td>
                        <td><?php echo date("d-m-Y", strtotime($value['LicenseModuleSuspensionFieldInspectorDetail']['inspection_date'])); ?></td>
                        <td style="height:30px; padding:2px; text-align:center;"> 
                            <?php 
                                echo $this->Js->link('Approve', array('controller' => 'LicenseModuleDirectSuspensionFieldInspAdminApprovalDetails', 'action' => 'approve', $value['BasicModuleBasicInformation']['id']), 
                                                    array_merge($pageLoading, array('class'=>'btnlink', 'confirm'=>'Are you sure to Approve this Assigned Inspector ?', 'title'=>'Administrative Approval for Assigned Inspector')))
                                        . $this->Js->link('Address Details', array('controller' => 'BasicModuleBranchInfoes', 'action' => 'details_all', $value['BasicModuleBasicInformation']['id']), 
                                                    array_merge($pageLoading, array('class'=>'btnlink', 'update' => '#popup_div')));
                            ?>
                        </td>
                    </tr>
                  <?php } ?>
                </table>

                <?php
                    if(count($values_not_approved) > 1 ) {
                        echo '<div class="btns-div" style="padding:7px; text-align:center;">'
                                . $this->Js->link('Approve All', array('controller' => 'LicenseModuleDirectSuspensionFieldInspAdminApprovalDetailss','action' => 'approve_all'), array_merge($pageLoading, array('class'=>'mybtns', 'title'=>'Administrative Approval for All Assigned Inspector')))
                            . '</div>';
                    }
                }
                ?>

            </fieldset>

        </div>
    </fieldset>
</div>
