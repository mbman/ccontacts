<?php
namespace Contact\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager as EntityManager;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Swagger\Annotations as SWG;

/**
* @ORM\Entity(repositoryClass="ContactRepository")
* @ORM\HasLifecycleCallbacks
* @ORM\Table(indexes={
*     @ORM\Index(name="fullName", columns={"firstName","lastName"}),
*     @ORM\Index(name="firstName", columns={"firstName"}),
*     @ORM\Index(name="lastName", columns={"lastName"}),
*     @ORM\Index(name="job", columns={"job"}),
*     @ORM\Index(name="company", columns={"company"}),
*     @ORM\Index(name="city", columns={"city"}),
*     @ORM\Index(name="tags", columns={"tags"})})
*
* @SWG\Model(id="Contact")
*/
class Contact implements InputFilterAwareInterface
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    * @SWG\Property(name="id",type="int")
    * @var int
    */
    protected $id;

    /**
     * Creation date
     * @ORM\Column(type="datetime")
     * @SWG\Property(name="created",type="datetime")
     * @var DateTime
     */
    protected $created;

    /**
     * Last edit date
     * @ORM\Column(type="datetime",nullable=true)
     * @SWG\Property(name="edited",type="datetime")
     * @var DateTime
     */
    protected $edited;

    /**
     * @ORM\Column(type="string",length=255,nullable=false)
     * @SWG\Property(name="lastName",type="string")
     * @var string
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string",length=255,nullable=false)
     * @SWG\Property(name="firstName",type="string")
     * @var string
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @SWG\Property(name="company",type="string")
     * @var string
     */
    protected $company;

    /**
     * @ORM\Column(type="string",length=80,nullable=true)
     * @SWG\Property(name="job",type="string")
     * @var string
     */
    protected $job;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @SWG\Property(name="address",type="string")
     * @var string
     */
    protected $address;

    /**
     * @ORM\Column(type="string",length=120,nullable=true)
     * @SWG\Property(name="city",type="string")
     * @var string
     */
    protected $city;

    /**
     * @ORM\Column(type="string",length=120,nullable=true)
     * @SWG\Property(name="state",type="string")
     * @var string
     */
    protected $state;

    /**
     * @ORM\Column(type="string",length=10,nullable=true)
     * @SWG\Property(name="zip",type="string")
     * @var string
     */
    protected $zip;

    /**
     * @ORM\Column(type="string",length=120,nullable=true)
     * @SWG\Property(name="country",type="string")
     * @var string
     */
    protected $country;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @SWG\Property(name="tags",type="string")
     * @var string
     */
    protected $tags;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @SWG\Property(name="notes",type="string")
     * @var string
     */
    protected $notes;

    /**
     * @ORM\OneToMany(targetEntity="Contact\Entity\Email",mappedBy="contact",cascade={"persist","refresh","remove"})
     * @var \Doctrine\Common\Collections\ArrayCollection
     * */
    protected $emails;

    /**
     * @var ContactRepository
     */
    protected $repository;

    /**
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     * Doctrine EntityManager
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function __construct()
    {
        $this->emails = new ArrayCollection();
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() + " " + $this->getLastName();
    }

    /**
     * @param string $firstName
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     * @return Contact
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $job
     * @return Contact
     */
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }

    /**
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param string $state
     * @return Contact
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $zip
     * @return Contact
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $country
     * @return Contact
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $notes
     * @return Contact
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $tags
     * @return Contact
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     * @return Contact
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Contact
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Contact
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Returns the ContactRepository
     * @return ContactRepository
     */
    public function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = $this->getEntityManager()->getRepository('Contact\Entity\Contact');
        }
        return $this->repository;
    }

    /**
     * Sets the creation datetime to now
     *
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new \DateTime('now');
    }

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Sets the last edit datetime to now
     *
     * @ORM\PreUpdate
     */
    public function setEdited()
    {
        $this->edited = new \DateTime('now');
    }

    /**
     * @return DateTime
     */
    public function getEdited()
    {
        return $this->edited;
    }

    /** @param Email $email */
    public function addEmail(Email $email) {
        if (!$email->getEmail()) {
            return false;
        }
        $email->setContact($this);
        $this->emails->add($email);
    }

    public function addEmails(Collection $emails)
    {
        foreach ($emails as $email) {
            $this->addEmail($email);
        }
    }

    public function removeEmails(Collection $emails)
    {
        foreach ($emails as $email) {
            $email->setContact(null);
            $this->emails->removeElement($email);
        }
    }

    /**
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
    * Set input method
    *
    * @param InputFilterInterface $inputFilter
    */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    /**
    * Get input filter
    *
    * @return InputFilterInterface
    */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            $em = $this->getEntityManager();

            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => false,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'firstName',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'lastName',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'company',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 255,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'job',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 80,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'address',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 255,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'city',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 120,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'state',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 120,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'zip',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 10,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'country',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 120,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'tags',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 255,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'notes',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 255,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

