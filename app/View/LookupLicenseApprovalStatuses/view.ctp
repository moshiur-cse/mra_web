<div id="frmTypeOfOrg_view">
    <?php
        $title = "Approval status information"; 
        $pageLoading = array('update'=>'#ajax_div', 'evalScripts'=>true, 
                    'before'=>$this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer'=>false)), 
                    'complete'=>$this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer'=>false)));

        $this->Paginator->options($pageLoading);
    ?>
    <fieldset>
        <legend>
          <?php echo $title; ?>  
        </legend>         
        <div class="form"> 
            <table >
                <tr>        
                    <td style="text-align: justify;font-family: verdana,helvetica,arial;" colspan="4">
                        <?php 
                            $message = "";
                            if (!empty($msg)){
                                $message = $msg;
                            }
                            echo $this->Form->create('LookupLicenseApprovalStatus');
                        ?>
                        <table cellpadding="0" cellspacing="0" border="0">          
                            <tr>
                                <td style="padding-left:15px; text-align:right;">Search By</td>
                                <td>
                                    <?php
                                        echo $this->Form->input('search_option', 
                                                array('label' => false, 'style'=>'width:200px',
                                                    'options' => array('LookupLicenseApprovalStatus.serial_no' => 'Serial no.',
                                                            'LookupLicenseApprovalStatus.approval_status' => 'Status'))
                                                    );
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
                        <?php  echo $this->Form->end(); ?> 
                    </td>        
                </tr>
                <tr>
                    <td>
                        <div id="searching" style="width:700px;">              
                            <table class="view">
                                <tr>
                                    <?php
                                        echo "<th style='min-width:50px;'>" . $this->Paginator->sort('LookupLicenseApprovalStatus.serial_no', 'Serial no.') . "</th>";
                                        echo "<th style='width:450px;'>" . $this->Paginator->sort('LookupLicenseApprovalStatus.approval_status.', 'Status') . "</th>";
                                        echo "<th style='width:120px;'>Action</th>";
                                   ?>
                                </tr>
                               <?php foreach($values as $value){ ?>
                                <tr>
                                    <td style="text-align: center; ;"><?php echo $value['LookupLicenseApprovalStatus']['serial_no']; ?></td>
                                    <td style="text-align: center;"><?php echo $value['LookupLicenseApprovalStatus']['approval_status']; ?></td>        
                                    <td style="text-align: center;">
                                        <?php 
                                            echo $this->Js->link('Edit', array('controller' => 'LookupLicenseApprovalStatuses','action' => 'edit', $value['LookupLicenseApprovalStatus']['id']), array_merge($pageLoading, array('class'=>'btnlink')))
                                                .$this->Js->link('Delete', array('controller' => 'LookupLicenseApprovalStatuses','action' => 'delete', $value['LookupLicenseApprovalStatus']['id']), 
                                                    array_merge($pageLoading, array('confirm' => 'Are you sure to delete?', 'success' => "msg.init('success', '$title', '$title has been deleted successfully.');", 'error' => "msg.init('error', '$title', 'Deletion failed!');",'class'=>'btnlink')));
                                       ?>
                                    </td>
                                </tr>
                               <?php  } ?>
                            </table> 
                        </div>
                    </td>                
                </tr>
            </table>
        </div>
        <?php if($values && $this->Paginator->param('pageCount')>1) { ?>
        <div class="paginator">
          <?php 
            echo $this->Paginator->prev('<<', array('class'=>'prevPg'), null, array('class'=>'prevPg no_link')).
                    $this->Paginator->numbers(array('class'=>'numbers', 'separator'=>'')).
                    $this->Paginator->next('>>', array('class'=>'nextPg'), null, array('class'=>'nextPg no_link'));
          ?>
        </div>
        <?php } ?> 
        <div class="btns-div">  
            <table style="margin:0 auto; padding:0;" cellspacing="7">
                <tr>
                    <td></td>
                    <td>
                        <?php  echo $this->Js->link('Add New', array('controller'=>'LookupLicenseApprovalStatuses','action'=>'add'), array_merge($pageLoading, array('class'=>'mybtns', 'title'=>'')));  ?>     
                    </td>
                    <td></td>   
                </tr>
            </table>
        </div>
    </fieldset>
</div>  

<script>    
    $(document).ready(function(){
        $(".paging a").click(function(){
            $("#ajax_div").load(this.href);
            return false;
        })        
    });     
</script>