<?php

namespace Ums\Form;

use Zend\Form\Form;

class Email extends Form {

    public function __construct($name = null) {
        parent::__construct('email');

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
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Recover',
                'class' => 'btn-success',
            )
            
        ));
    }

}

