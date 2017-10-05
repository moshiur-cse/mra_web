<?php

App::uses('AppController', 'Controller');

class LookupMemberTypesController extends AppController {

   public $helpers = array('Html','Form','Js','Paginator');   
   public $components = array('Paginator');   
   public $paginate = array(
        'limit' => 5,
        'order' => array('LookupMemberType.serial_no' => 'ASC')
   );

   public function view()
   {            
        if ($this->request->is('post'))
        {
            $option = $this->request->data['LookupMemberType']['search_option'];  
            $keyword = $this->request->data['LookupMemberType']['search_keyword'];
            $condition = array("$option LIKE '%$keyword%'"); 
            
            $this->paginate = array(
            'order' => array('LookupMemberType.serial_no' => 'ASC'),
            'limit' => 10,
            'conditions' => $condition);
        }

        $this->LookupMemberType->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $values = $this->Paginator->paginate('LookupMemberType');
        $this->set(compact('values'));
   }

   public function add()
   {       
        if ($this->request->is('post'))
        {
            $this->LookupMemberType->create();
            if ($this->LookupMemberType->save($this->request->data)) {
                 $this->redirect(array('action'=>'view'));     
            }
        }
    } 

    public function edit($id = null)
    {
        if (!$id) 
        {
            throw new NotFoundException('Invalid Licensing Status');
        }

        $post = $this->LookupMemberType->findById($id);
        if (!$post) 
        {
            throw new NotFoundException('Invalid Licensing Status');
        }

        if ($this->request->is(array('post', 'put')))
        {
            $this->LookupMemberType->id = $id;
            if ($this->LookupMemberType->save($this->request->data)) {                
                return $this->redirect(array('action'=>'view'));            
            }            
        }
        
        if (!$this->request->data)
        {
            $this->request->data = $post;
        }
    }

    public function delete($id)
    {      
        if ($this->LookupMemberType->delete($id))
        {            
            return $this->redirect(array('action' => 'view'));            
        }             
    }

}