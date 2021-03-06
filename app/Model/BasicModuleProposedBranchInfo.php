<?php

App::uses('AppModel', 'Model');

class BasicModuleProposedBranchInfo extends AppModel {

    public $actsAs = array('Containable');
    public $belongsTo = array(
        'LookupBasicProposedOfficeType' => array(
            'className' => 'LookupBasicProposedOfficeType',
            'foreignKey' => 'office_type_id'
        ),
        'LookupAdminBoundaryDistrict' => array(
            'className' => 'LookupAdminBoundaryDistrict',
            'foreignKey' => 'district_id'
        ),
        'LookupAdminBoundaryUpazila' => array(
            'className' => 'LookupAdminBoundaryUpazila',
            'foreignKey' => 'upazila_id'
        ),
        'LookupAdminBoundaryUnion' => array(
            'className' => 'LookupAdminBoundaryUnion',
            'foreignKey' => 'union_id'
        ),
        'LookupAdminBoundaryMauza' => array(
            'className' => 'LookupAdminBoundaryMauza',
            'foreignKey' => 'mauza_id'
        ),
        'BasicModuleBasicInformation' => array(
            'className' => 'BasicModuleBasicInformation',
            'fields' => 'id, license_no, full_name_of_org, short_name_of_org, name_of_org',
            'foreignKey' => 'org_id'
        )
    );
    public $hasOne = array(
        'BasicModuleProposedBranchImage' => array(
            'className' => 'BasicModuleProposedBranchImage',
            'foreignKey' => 'branch_id'
    ));
    public $virtualFields = array(
        'branch_with_address' => "SELECT CONCAT_WS(', ', CONCAT_WS('', branch_name, CASE WHEN branch_name != '' AND branch_code != '' THEN CONCAT_WS('', ' (', branch_code, ')') ELSE branch_code END), union_name, upazila_name, district_name) FROM basic_module_branch_infos, lookup_admin_boundary_unions, lookup_admin_boundary_upazilas, lookup_admin_boundary_districts WHERE (basic_module_branch_infos.id = BasicModuleProposedBranchInfo.id AND lookup_admin_boundary_unions.id = BasicModuleProposedBranchInfo.union_id AND lookup_admin_boundary_upazilas.id = BasicModuleProposedBranchInfo.upazila_id AND lookup_admin_boundary_districts.id = BasicModuleProposedBranchInfo.district_id)",
        'branch_with_code' => "CONCAT_WS('', branch_name, CASE WHEN branch_name != '' AND branch_code != '' THEN CONCAT_WS('', ' (<strong>', branch_code, '</strong>)') ELSE branch_code END)",
        'contract_info' => "SELECT CONCAT_WS(', ', CASE WHEN email_address IS NOT NULL AND REPLACE(email_address, ' ','') != '' THEN email_address ELSE NULL END, REPLACE(phone_no, ' ',''), CASE WHEN fax IS NOT NULL AND REPLACE(fax, ' ','') != '' THEN CONCAT(' fax: ', fax) ELSE NULL END) FROM basic_module_branch_infos WHERE (basic_module_branch_infos.id = BasicModuleProposedBranchInfo.id)"
    );

    public $validate = array(
        'office_type_id' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notBlank'),
            'on' => 'null',
            'message' => 'An office type is required'
        ),
        'branch_name' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notBlank'),
            'on' => 'null',
            'message' => 'Office name is required'
        ),
        'mailing_address' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notBlank'),
            'on' => 'null',
            'message' => 'Mailing address is required'
        ),
        'district_id' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notBlank'),
            'on' => 'null',
            'message' => 'A district name is required'
        ),
        'upazila_id' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notBlank'),
            'on' => 'null',
            'message' => 'A upazilla name is required'
        ),
        'mohalla_or_post_office' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notBlank'),
            'on' => 'null',
            'message' => 'A mahalla/post office name is required'
        ),
        'road_name_or_village' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notBlank'),
            'on' => 'null',
            'message' => 'A road name/village name is required'
        ),
        'mobile_no' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notBlank'),
            'on' => 'null',
            'message' => 'A mobile no. is required'
        ),
        'lat' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notBlank'),
            'on' => 'null',
            'message' => 'A Latitude value is required'
        ),
        'long' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notBlank'),
            'on' => 'null',
            'message' => 'A Longitude value is required'
        )
    );

}
