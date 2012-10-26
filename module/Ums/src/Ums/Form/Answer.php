<?php

namespace Ums\Form;

use Zend\Form\Form;

class Answer extends Form {

    public function __construct($name = null) {
        parent::__construct('answer');

        $this->add(array(
            'name' => 'answer',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'What is the andwer to your question',
            ),
            'attributes' => array(
                'id' => 'email',
            ),
        ));


        $this->add(array(
            'name' => 'user',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'id' => 'user',
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

