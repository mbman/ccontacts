<?php
namespace Contact\Form;

use Contact\Entity\Phone;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class PhoneFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('contact');
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new Phone());
        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Phone',
            ),
        ));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            array(
                'name' => 'phone',
                'required' => false,
                'allow_empty' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 20,
                        ),
                    ),
                ),
            ),
        );
    }
}