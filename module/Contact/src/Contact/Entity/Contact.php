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
* @ORM\Table(indexes={@ORM\Index(name="search_idx", columns={"firstName", "lastName","company","city"})})
*
* @SWG\Model(id="Contact")
*/
class Contact implements InputFilterAwareInterface
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    * @var int
    */
    protected $id;

    /**
     * Creation date
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    protected $created;

    /**
     * Last edit date
     * @ORM\Column(type="datetime",nullable=true)
     * @var DateTime
     */
    protected $edited;

    /**
     * @ORM\Column(type="string",length=255,nullable=false)
     * @var string
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string",length=255,nullable=false)
     * @var string
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @var string
     */
    protected $company;

    /**
     * @ORM\Column(type="string",length=255,nullable=false)
     * @var string
     */
    protected $job;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @var string
     */
    protected $address;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @var string
     */
    protected $city;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @var string
     */
    protected $state;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @var string
     */
    protected $zip;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @var string
     */
    protected $country;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @var string
     */
    protected $notes;

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
        return $this->fullName;
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

    public function setStartDate($datetime)
    {
        if ($datetime instanceof \DateTime) {
            $this->startDate = $datetime;
        } else {
            $this->startDate =
                $datetime != '' ? new \DateTime($datetime) : null;
        }
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getStartDateFormated($html5Format = false)
    {
        return $this->startDate !== null ?
                    $this->startDate->format($html5Format ? 'Y-m-d\TH:i' : 'M-d-Y H:i') : '';
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
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

