<?php

namespace Ums\Form;

use Zend\Form\Form;

class Login extends Form {

    public function __construct($name = null) {
        parent::__construct('loginform');

        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'options' => array(
                'label' => 'What\'s your email',
            ),
            'attributes' => array(
                'id' => 'email',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'What\'s your password',
            ),
            'attributes' => array(
                'id' => 'password',
            ),
        ));
        
        $this->add(array(
            'name' => 'cookie',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' =>array(
                'label' => 'Stay logged in'
            ),
            'attributes' => array(
                'id' => 'cookie'
            ),
        ));
        
         $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Login',
                'class' => 'btn-success',
            )
            
        ));
    }

}

