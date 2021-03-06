<div id="frmBasicInfo_add">
    <?php
        //debug($this->request->data['CDBNonMfiBasicInfo']['name_of_org']); 
        $title = "Update Primary Information"; 
        $pageLoading = array('update'=>'#ajax_div', 'evalScripts'=>true, 'class'=>'mybtns', 
                    'before'=>$this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer'=>false)), 
                    'complete'=>$this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer'=>false)));
    ?>
     <fieldset>
        <legend>
          <?php echo $title; ?>   
        </legend>
        <?php                 
            echo $this->Form->create('CDBNonMfiBasicInfo');
        ?>
        <div class="form">            
<!--            <table cellpadding="0" cellspacing="0" border="0"> 
                <tr>
                    <td>Organization Name</td>
                    <td class="colons">:</td>
                    <td style="padding: 2px 5px; font-weight: bold;"><?php if(!empty($this->request->data)) echo $this->request->data['CDBNonMfiBasicInfo']['name_of_org']; ?></td>
                </tr>
                <tr>
                    <td>Registration No.</td>
                    <td class="colons">:</td>
                    <td style="padding: 2px 5px; font-weight: bold;"><?php if(!empty($this->request->data)) echo $this->request->data['CDBNonMfiBasicInfo']['registration_no']; ?></td>
                </tr>
                <tr>
                    <td>Ministry/Authority</td>
                    <td class="colons">:</td>
                    <td><?php echo $this->Form->input('CDBNonMfiBasicInfo.ministry_or_authority_id', array('type' => 'select', 'class' => 'medium', 'options' => $ministry_or_authority_options, 'empty' => '-----Select-----', 'label' => false)); ?></td>
                </tr>                
                <tr>
                    <td>Name of the Officer</td>
                    <td class="colons">:</td>
                    <td><?php echo $this->Form->input('name_of_officer',array('label'=>false)); ?></td>
                </tr>                
                <tr>
                    <td>Designation</td>
                    <td class="colons">:</td>
                    <td><?php echo $this->Form->input('designation_of_officer',array('label'=>false)); ?></td>
                </tr>                                
            </table>-->
        </div>
        <div class="btns-div"> 
            <table style="margin:0 auto; padding:0;" cellspacing="5">
                <tr>
                    <td></td>
                    <td>
                        <?php                        
                            echo $this->Js->submit('Save', array_merge($pageLoading, 
                                    array('success'=>"msg.init('success', '$title', '$title has been updated successfully.');", 
                                          'error'=>"msg.init('error', '$title', '$title has been failed to update!');")));
                        
                        ?>
                    </td>
                    <td>
                        <?php 
                            echo $this->Js->link('Close', array('controller'=>'CDBNonMfiBasicInfos', 'action'=>'view', 'all'), 
                                                            array_merge($pageLoading, array('confirm'=>'Are you sure to close ?')));
                        ?>
                    </td>                    
                    <td></td>   
                </tr>
            </table>
        </div>            
    <?php echo $this->Form->end(); ?>
    </fieldset>
</div>
<?php
    //echo $this->element('homefooter', array("variable_name"=>"current")); 
?>