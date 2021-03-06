<?php

App::uses('AppController', 'Controller');

class LookupAffiliationTypesController extends AppController {
 
   public $helpers = array('Html','Form','Js','Paginator');   
   public $components = array('Paginator');   
   public $paginate = array(
        'limit' => 5,
        'order' => array('LookupAffiliationType.serial_no' => 'ASC')
   );

   public function view()
   {            
        if ($this->request->is('post'))
        {
            $option = $this->request->data['LookupAffiliationType']['search_option'];  
            $keyword = $this->request->data['LookupAffiliationType']['search_keyword'];
            $condition = array("$option LIKE '%$keyword%'"); 
            
            $this->paginate = array(
            'order' => array('LookupAffiliationType.serial_no' => 'ASC'),
            'limit' => 10,
            'conditions' => $condition);
        }

        $this->LookupAffiliationType->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $values = $this->Paginator->paginate('LookupAffiliationType');
        $this->set(compact('values'));
   }

   public function add()
   {       
        if(!empty($this->request->data))
        {
            if($this->LookupAffiliationType->save($this->request->data))
            {
                $this->LookupAffiliationType->save($this->request->data);
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

        $post = $this->LookupAffiliationType->findById($id);
        if (!$post) 
        {
            throw new NotFoundException('Invalid Licensing Status');
        }

        if ($this->request->is(array('post', 'put')))
        {
            $this->LookupAffiliationType->id = $id;
            if ($this->LookupAffiliationType->save($this->request->data)) {                
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
        if ($this->LookupAffiliationType->delete($id))
        {            
            return $this->redirect(array('action' => 'view'));            
        }             
    }

}
