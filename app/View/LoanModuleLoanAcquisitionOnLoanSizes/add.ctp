<?php 

    if(!empty($msg)) {
        if(is_array($msg)) {
            echo $this->Html->scriptBlock('msg.init('.json_encode($msg).');', array('inline'=>true));
        }
        else {
            echo $this->Html->scriptBlock("msg.init('error', 'Error...', '$msg');", array('inline'=>true));
        }
    }
   
    $title = "Loan Acquisition on Loan Size Partition";
    $pageLoading = array('update'=>'#ajax_div', 'evalScripts'=>true, 'class'=>'mybtns', 
                'before'=>$this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer'=>false)), 
                'complete'=>$this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer'=>false)));
?> 

<div>
    <fieldset>
        <legend><?php echo $title." (Add)"; ?></legend>         
        <?php echo $this->Form->create('LoanModuleLoanAcquisitionOnLoanSize'); ?>
        
            <div class="form">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>Name of Organization</td>
                        <td class="colons">:</td>
                        <td>
                            <?php 
                                if(!empty($org_id))
                                    echo $this->Form->input('org_id', array('type'=>'text', 'value'=>$orgNameOptions[$org_id], 'disabled'=>'disabled', 'label'=>false));
                                else
                                    echo $this->Form->input('org_id', array('type'=>'select', 'options'=>$orgNameOptions, 'value'=>$org_id, 'id'=>'org_names', 'empty'=>'---Select---', 'label'=>false));
                            ?>
                        </td>
                    </tr>             
                    <tr>
                        <td>Branch Name</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->input('branch_id', array('type'=>'select', 'options'=>$branch_name_options, 'empty' =>'---Select---', 'id'=>'branch_names', 'label'=>false));?></td>
                    </tr>
                    <tr>
                        <td>Loan Size Partition on the basis of Loan Disbursed</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->input('loan_size_partition_disburse_id',array('type'=>'select','options'=>$loan_size_partition_disbursed_options,'empty'=>'---Select---','label'=>false));?></td>
                    </tr> 
                    <tr>
                        <td>Loan Size Partition on the basis of Loan Outstanding</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->input('loan_size_partition_outstanding_id',array('type'=>'select','options'=>$loan_size_partition_outstanding_options,'empty'=>'---Select---','label'=>false));?></td>
                    </tr>
                    <tr>
                        <td>Year & Month</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->year('year_and_month', date('Y') - 15, date('Y'), array('empty'=>"--Select Year--", 'style'=>'width:192px;margin:7px 2px 7px 5px;')).$this->Form->month('year_and_month', array('empty'=>"--Select Month--", 'style'=>'width:192px;margin:2px 2px 2px 0px;')).$this->Form->day('year_and_month', array('empty'=>false, 'style'=>'display:none;')); ?> </td>
                    </tr>                
                    <tr>
                        <td>Date of Update</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->month('date_of_update', array('empty'=>"--Month--", 'style'=>'width:127px; margin:7px 2px 7px 5px;')).$this->Form->day('date_of_update', array('empty'=>"--Day--", 'style'=>'width:127px;margin:7px 2px 7px 0px;')).$this->Form->year('date_of_update', date('Y') - 15, date('Y'), array('empty'=>"--Year--", 'style'=>'width:128px;margin:7px 2px 7px 0px;')); ?> </td>                        
                    </tr>
                    <tr>
                        <td>No. Of Borrowers</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->input('no_of_borrowers',array('type'=>'text','class'=>'integers','label'=>false));?></td>
                    </tr>               
                    <tr>
                        <td>No. of Male Borrowers</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->input('no_of_male_borrowers',array('type'=>'text','class'=>'integers','label'=>false));?></td>
                    </tr>
                    <tr>
                        <td>No. of Female Borrowers</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->input('no_of_female_borrowers',array('type'=>'text','class'=>'integers','label'=>false));?></td>
                    </tr>
                    <tr>
                        <td>Amount of Total Principal Balance</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->input('amount_of_total_principal_balance',array('type'=>'text','class'=>'decimals','label'=>false));?></td>
                    </tr>
                    <tr>
                        <td>No. of Loans Disbursed</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->input('no_of_loans_disbursed',array('type'=>'text','class'=>'integers','label'=>false));?></td>
                    </tr>                
                    <tr>
                        <td>Amount of Total Disbursed Loan Balance</td>
                        <td class="colons">:</td>
                        <td><?php echo $this->Form->input('amount_of_total_disbursed_loan_balance',array('type'=>'text','class'=>'decimals','label'=>false));?></td>
                    </tr>
                </table>
            </div>

            <div class="btns-div"> 
                <table style="margin:0 auto; padding:0;" cellspacing="5">
                    <tr>
                        <td></td>
                        <td>
                            <?php 
                                $data_mode = $this->Session->read('Data.Mode');
                                $isNew = empty($data_mode) || $data_mode=='insert';

                                if ($isNew) { 
                                    echo $this->Js->submit('Save', array_merge($pageLoading, 
                                                                    array('success'=>"msg.init('success', '$title', '$title has been added successfully.');", 
                                                                          'error'=>"msg.init('error', '$title', '$title Insertion failed !');")));
                                } 
                                else {
                                    echo $this->Js->submit('Update', array_merge($pageLoading, 
                                                                    array('update'=>'#popup_div', 
                                                                        'success'=>"msg.init('success', '$title', '$title has been update successfully.');", 
                                                                        'error'=>"msg.init('error', '$title', '$title has been failed to update !');")));
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo $this->Js->link('Close', array('controller'=>'LoanModuleLoanAcquisitionOnLoanSizes', 'action'=>'view'), 
                                                                array_merge($pageLoading, array('confirm'=>'Are you sure to close ?')));
                            ?>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        
        <?php  echo $this->Form->end(); ?>                 
    </fieldset>
</div>

<script>
    
    $(document).ready(function () {
        $('.integers').numeric({ decimal: false, negative: false });
        $('.decimals').numeric({ decimal: ".", negative: false });
    });
    
</script>
<?php
$this->Js->get('#org_names')->event('change', 
    $this->Js->request(array(
        'controller'=>'LoanModuleLoanAcquisitionOnLoanSizes',
        'action'=>'branch_select'
        ), array(
        'update'=>'#branch_names',            
        'async'=>true,
        'method'=>'post',
        'dataExpression'=>true,
        'data'=> $this->Js->serializeForm(array(
                'isForm'=>true,
                'inline'=>true
            ))
        ))
    );   
?>

<?php
    if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) 
            echo $this->Js->writeBuffer();
?>
