<?php
if (!empty($organization_options)){
    echo $this->Form->input('LicenseModuleCancelByMraFieldInspectorDetail.org_id',array('type'=>'select','multiple'=>'checkbox', 'options'=>$organization_options, 'selected'=>$org_selected_values, 'label'=>false));    
}
?>