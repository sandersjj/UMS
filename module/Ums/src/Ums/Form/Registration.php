<?php
namespace Ums\Form;

use Zend\Form\Form;


class Registration extends Form{
    
    /**
     * 
     * @param type $name
     */
    public function __construct($name = null) {
        parent::__construct('register');
        
        $this->add(array(
            'name' => 'firstname',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'What\'s your first name',
            ),
            'attributes' => array(
              'id'=> 'firstname',
            ),
        ));
        $this->add(array(
            'name' => 'surname',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'What\'s your surname',
            ),
            'attributes' => array(
              'id'=> 'surname' ,
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'options' => array(
                'label' => 'What\'s your email',
            ),
            'attributes' => array(
              'id'=> 'email' ,
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'What\'s your password',
            ),
            'attributes' => array(
              'id'=> 'password' ,
            ),
        ));
        $this->add(array(
            'name' => 'question',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Select your security question',
                'options' => array(
                    'dog' => 'What\'s the name of your dog?',
                    'motherinlaw' => 'How old is your mother in law when  you got married?',
                    'color'  => 'What is your favorite color?',
                    
                )
            ),
            'attributes' => array(
              'id'=> 'question' ,
            ),
        ));
        $this->add(array(
            'name' => 'answer',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'What\'s the answer to your security question',
            ),
            'attributes' => array(
              'id'=> 'answer' ,
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Save',
                'class' => 'btn-success',
            )
            
        ));
    }
    
    
    
}