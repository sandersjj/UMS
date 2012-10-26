<?php

namespace Ums\Form;

Use Zend\Form\Form;

class Memo extends Form {

    public function __construct($name = null) {
        parent::__construct('memoForm');
        $this->add(array(
            'name' => 'memo',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Add a message',
            ),
            'attributes' => array(
                'id' => 'memo',
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
                'value' => 'add',
                'class' => 'btn-success',
            )
            
        ));
    }

}