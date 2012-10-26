<?php

namespace Ums\Controller;

use Ums\Form\Memo as MemoForm;

class MemoController extends AbstractUmsController {
    
    
    public function addAction(){
        
        $id = $this->params()->fromRoute('id');
        
        
        $memoForm = new MemoForm();
        $memoForm->populateValues(array('user'=>  $id));
        
        
        $request = $this->getRequest();
        
        if($request->isPost()){
            $memoForm->setData($request->getPost());
            if($memoForm->isValid()){
                $em = $this->getEntityManager();
                $userRepo = $em->getRepository('Ums\Entity\User');
                $userRepo->addMemo($request->getPost());
                
            }
            
        }
        
        
        
        return array('form' => $memoForm);
    }
    
}