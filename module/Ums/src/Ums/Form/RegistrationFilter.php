<?php

namespace Ums\Form;

use Zend\InputFilter\InputFilter;

class RegistrationFilter extends InputFilter {

    public function __construct() {
        $this->add(array(
            'name' => 'firstname',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
        ));
        $this->add(array(
            'name' => 'surname',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
                array('name' => 'EmailAddress'),
            )
        ));
        $this->add(array(
            'name' => 'password',
            'required' => true,
            'validators' => array(
                array('name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 4,
                        'max' => 20,
                        'messages' => array(
                            'stringLengthTooShort' => 'Please enter User Name between 4 to 20 character!',
                            'stringLengthTooLong' => 'Please enter User Name between 4 to 20 character!'
                        ),
                    ),
                ),
            ),
        ));



        $this->add(array(
            'name' => 'question',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'answer',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
        ));
    }

}
