<?php
namespace Contact\Form;

use Zend\Form\Form;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity as DoctrineHydrator;

class ContactForm extends Form
{

    public function __construct($entityManager)
    {
        parent::__construct('contact');
        $this->setAttribute('method', 'post');

        $hydrator = new DoctrineHydrator($entityManager,'Contact\Entity\Contact');
        $this->setHydrator($hydrator);

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'lastName',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Last name',
            ),
        ));

        $this->add(array(
            'name' => 'firstName',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'First name',
            ),
        ));
        $this->add(array(
            'name' => 'company',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Company',
            ),
        ));
        $this->add(array(
            'name' => 'job',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Job title',
            ),
        ));
        $this->add(array(
            'name' => 'address',
            'type' => 'text',
            'attributes' => array(
            ),
            'options' => array(
                'label' => 'Address',
            ),
        ));
        $this->add(array(
            'name' => 'city',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'City',
            ),
        ));
        $this->add(array(
            'name' => 'state',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'State/Province',
            ),
        ));
        $this->add(array(
            'name' => 'zip',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'ZIP',
            ),
        ));
        $this->add(array(
            'name' => 'country',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Country/Region',
            ),
        ));
        $this->add(array(
            'name' => 'tags',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Tags',
            ),
        ));
        $this->add(array(
            'name' => 'notes',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Notes',
            ),
        ));
        $this->add(array(
            'name' => 'emails',
            'type' => 'Collection',
            'options' => array(
                'label' => 'Emails',
                'should_create_template' => true,
                'allowAdd' => true,
                'count' => 0,
                'template_placeholder' => '__placeholder__',
                'target_element' => array(
                    'type' => 'Contact\Form\EmailFieldset',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'phones',
            'type' => 'Collection',
            'options' => array(
                'label' => 'Emails',
                'should_create_template' => true,
                'allowAdd' => true,
                'count' => 0,
                'template_placeholder' => '__placeholder__',
                'target_element' => array(
                    'type' => 'Contact\Form\PhoneFieldset',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
    }
}