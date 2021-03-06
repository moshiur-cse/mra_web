<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class LicenseModuleInitialAssessmentVerificationsController extends AppController {
    public $helpers = array('Form', 'Html', 'Js', 'Paginator', 'Time');
    public $components = array('Paginator');
    public $paginate = array();
    var $uses = array('BasicModuleBasicInformation','AdminModuleUser','LicenseModuleInitialAssessmentVerification');

    public function view() {        
        $this_state_ids = $this->request->query('this_state_ids');        
        if (!empty($this_state_ids))
            $this->Session->write('Current.StateIds', $this_state_ids);
        else
            $this_state_ids = $this->Session->read('Current.StateIds');

        if (!empty($this_state_ids)) {
            $thisStateIds = explode('_', $this_state_ids);
        } 
        else {
            $msg = array(
                'type' => 'warning',
                'title' => 'Warning... . . !',
                'msg' => 'Invalid State Information !'
            );
            $this->set(compact('msg'));
            return;
        }        
        $current_year = $this->Session->read('Current.LicensingYear');
        if (empty($current_year)) {
            $msg = array(
                'type' => 'warning',
                'title' => 'Warning... . . !',
                'msg' => 'Invalid Licensing Year Information !'
            );
            $this->set(compact('msg'));
            return;
        }
        $pending_value_condition = array('licensing_year' => $current_year, 'licensing_state_id' => $thisStateIds[0]);
        $completed_value_condition = array('licensing_year' => $current_year, 'licensing_state_id' => $thisStateIds[1]);

        $pending_values = array();
        $this->Paginator->settings =  array('conditions' => $pending_value_condition, 'limit' => 8 );
        $this->BasicModuleBasicInformation->recursive = -1;
        $pending_values = $this->Paginator->paginate('BasicModuleBasicInformation');

        $history_data = array();
        $this->LicenseModuleInitialAssessmentVerification->recursive=1;
        $verification_status_values = $this->LicenseModuleInitialAssessmentVerification->find('all');
        
        foreach($verification_status_values as $history_value){            
            $history_values['org_id'] = $history_value['LicenseModuleInitialAssessmentVerification']['org_id'];
            $history_values['org_name'] = $history_value['BasicModuleBasicInformation']['full_name_of_org'].'('.$history_value['BasicModuleBasicInformation']['short_name_of_org'].')';
            $history_values['user_id'] = $history_value['LicenseModuleInitialAssessmentVerification']['user_id'];
            $history_values['user_name'] = $history_value['AdminModuleUserProfile']['full_name_of_user'].'('.$history_value['AdminModuleUser']['user_name'].')';
            $history_values['verification_date'] = $history_value['LicenseModuleInitialAssessmentVerification']['verification_date'];
            $history_values['verification_status_id'] = $history_value['LicenseModuleInitialAssessmentVerification']['verification_status_id'];

            if($history_value['LicenseModuleInitialAssessmentVerification']['verification_status_id']=='1'){
                $history_values['verification_status'] = 'Verified';
            }
            else{
                $history_values['verification_status'] = 'Pending';
            }
            $history_values['comments'] = $history_value['LicenseModuleInitialAssessmentVerification']['comments'];
            $history_data[] = $history_values;
        }

        $completed_values = array();
        $this->Paginator->settings = array('conditions' => $completed_value_condition, 'limit' => 8 );        
        $completed_values = $this->Paginator->paginate('BasicModuleBasicInformation');                   
        
        if ($this->request->is('post')){
            $completed_option = $this->request->data['LicenseModuleInitialAssessmentVerificationCompleted']['completed_search_option'];  
            $completed_keyword = $this->request->data['LicenseModuleInitialAssessmentVerificationCompleted']['completed_search_keyword'];
            $completed_condition = array('LicenseModuleInitialAssessmentVerification.verification_status_id' => '0',"$completed_option LIKE '%$completed_keyword%'"); 

            $this->paginate = array(
            'order' => array('LicenseModuleInitialAssessmentVerification.id' => 'ASC'),
            'limit' => 8,
            'conditions' => $completed_condition);            
            $this->Paginator->settings = $this->paginate;
            $completed_values = $this->Paginator->paginate('LicenseModuleInitialAssessmentVerification');            
        }
        
        $this->set(compact('completed_values','history_data','pending_values','is_verified_by_user','thisStateIds'));
    }

    public function verify($org_id = null, $next_state_id = null) {
        if (empty($next_state_id)) {
            $msg = array(
                'type' => 'warning',
                'title' => 'Warning... . . !',
                'msg' => 'Invalid next state information !'
            );
            $this->set(compact('msg'));
            return;
        }
        $user_group_id = $this->Session->read('User.GroupIds');              
        $is_exists = false;

        $org_infos = $this->BasicModuleBasicInformation->find('first',array('fields'=>array('BasicModuleBasicInformation.id,  BasicModuleBasicInformation.full_name_of_org, BasicModuleBasicInformation.short_name_of_org, BasicModuleBasicInformation.license_no, BasicModuleBasicInformation.license_issue_date'),'conditions'=>array('BasicModuleBasicInformation.id'=>$org_id)));
        $orgName = $org_infos['BasicModuleBasicInformation']['full_name_of_org'].' ('.$org_infos['BasicModuleBasicInformation']['short_name_of_org'].')';

        $user_id = '';
        if(!in_array(1,$user_group_id )){
            $user_id = $this->Session->read('User.Id');
            $this->AdminModuleUser->recursive = 0;
            $user_name_infos = $this->AdminModuleUser->find('first',array('fields'=>array('AdminModuleUser.user_name','AdminModuleUserProfile.full_name_of_user'), 'conditions'=>array('AdminModuleUser.id'=>$user_id)));
            $user_full_name = $user_name_infos['AdminModuleUserProfile']['full_name_of_user'];
            $user_name = $user_name_infos['AdminModuleUser']['user_name'];
            $condition = array('LicenseModuleInitialAssessmentVerification.user_id'=>$user_id,'LicenseModuleInitialAssessmentVerification.org_id'=>$org_id);
            $this->LicenseModuleInitialAssessmentVerification->recursive = -1;
            $cancel_request_verification_infos = $this->LicenseModuleInitialAssessmentVerification->find('first',array('conditions'=>$condition));
            
            if(!empty($cancel_request_verification_infos)){
                $this->request->data = $cancel_request_verification_infos;
                $is_exists = true;                
            }
        }
        $this->set(compact('is_exists','org_id','orgName'));

        if ($this->request->is('post')){
            if(!empty($cancel_request_verification_infos)){
                return;
            }
            else{  
                $Email = new CakeEmail('gmail');
                $this->AdminModuleUser->recursive = 0;
                $user_email_infos = $this->AdminModuleUser->find('all',array('fields'=>array('AdminModuleUserProfile.email'), 'conditions'=>array('AdminModuleUserGroupDistribution.user_group_id'=>$user_group_id)));
                foreach($user_email_infos as $email_info){                    
                    $Email->addTo($email_info['AdminModuleUserProfile']['email']);
                }                                
                $Email->from(array('mfi.dbms.mra@gmail.com' => 'Message From MFI DBMS of MRA'))                      
                      ->subject('Verification of License Cancel Request');

                $verification_status_id = $this->request->data['LicenseModuleInitialAssessmentVerification']['verification_status_id'];
                $comments = $this->request->data['LicenseModuleInitialAssessmentVerification']['comments'];
                $data_to_save_in_cancel_request_verification = array(
                    'user_id' => (int)$user_id,
                    'org_id' => (int)$org_id,  
                    'verification_date' => date('Y-m-d'),                    
                    'comments' => $comments,
                    'verification_status_id' => (int)$verification_status_id               
                );                
                if($verification_status_id=='0'){//delete all
                    $this->LicenseModuleInitialAssessmentVerification->deleteAll(array('LicenseModuleInitialAssessmentVerification.org_id' => $org_id), false);
                    $message_body = 'Dear User,' . "\r\n" . "\r\n" . "User Name: $user_name and Full Name: $user_full_name". ' did not verify the cancel request of '. $orgName . ' As a result the verification status of all members has been reset'. " \r\n" . "\r\n" . 'Thanks' . "\r\n" . 'Microcredit Regulatory Authority';
                    $Email->send($message_body);
                    $this->redirect(array('action' => 'view?this_state_ids=100_101'));
                }
                else if($verification_status_id=='1'){
                    if($is_exists){
                        $msg = array(
                            'type' => 'error',
                            'title' => 'Error... . . !',
                            'msg' => 'A previous verification record is already exists!'
                        );
                        $this->set(compact('msg'));
                    }
                    else{
                        $this->LicenseModuleInitialAssessmentVerification->create();
                        $this->LicenseModuleInitialAssessmentVerification->save($data_to_save_in_cancel_request_verification);                    
                    }

                    $group_user_count = $this->AdminModuleUser->find('count', array('conditions' => array('AdminModuleUserGroupDistribution.user_group_id' => $user_group_id)));
                    $verification_count = $this->LicenseModuleInitialAssessmentVerification->find('count', array('conditions' => array('LicenseModuleInitialAssessmentVerification.org_id'=>$org_id)));
                    $verification_infos = $this->LicenseModuleInitialAssessmentVerification->find('all',array('conditions'=>array('LicenseModuleInitialAssessmentVerification.org_id'=>$org_id)));
                    $is_approved_by_all = false;
                    foreach($verification_infos as $info){
                        $status_id = $info['LicenseModuleInitialAssessmentVerification']['verification_status_id'];
                        if(($status_id=='1')&&($verification_count==$group_user_count)){
                            $is_approved_by_all = true;
                        }else{
                            $is_approved_by_all = false;
                            break;
                        }
                    }
                    if($is_approved_by_all){
                        $basic_info_condition = array('BasicModuleBasicInformation.id'=>$org_id);
                        $data_to_save_in_basic_info = array('licensing_state_id'=>$next_state_id);
                        $this->BasicModuleBasicInformation->updateAll($data_to_save_in_basic_info,$basic_info_condition);
                        $message_body = 'Dear User,' . "\r\n" . "\r\n" . 'The license cancel request of '. $orgName . ' has been verified by all of the committee members'. " \r\n" . "\r\n" . 'Thanks' . "\r\n" . 'Microcredit Regulatory Authority';
                        $Email->send($message_body);
                    }
                    $this->redirect(array('action' => 'view?this_state_ids=100_101'));
                }
            }
        }
    }

    public function preview_completed($org_id = null){   
        $this->LicenseModuleCancelRequest->recursive=1;        
        $allDetails = $this->LicenseModuleCancelRequest->find('first', array('conditions' => array('org_id'=>$org_id)));
        $this->set(compact('allDetails')); 
    }

    public function preview_history($user_id = null, $org_id = null){        
        $history_data = array();
        $this->LicenseModuleInitialAssessmentVerification->recursive=2;
        $allDetails = $this->LicenseModuleInitialAssessmentVerification->find('first', array('conditions'=>array('LicenseModuleInitialAssessmentVerification.org_id' => $org_id, 'LicenseModuleInitialAssessmentVerification.user_id' => $user_id)));        
        $this->set(compact('allDetails'));
    }

    public function preview_pending($org_id = null){   
        $this->LicenseModuleCancelRequest->recursive=1;        
        $allDetails = $this->LicenseModuleCancelRequest->find('first', array('conditions' => array('org_id'=>$org_id)));
        $this->set(compact('allDetails')); 
    }
}
