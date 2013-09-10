<?php
namespace Contact\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager as EntityManager;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* @ORM\Entity
* @ORM\HasLifecycleCallbacks
* @ORM\Table(indexes={
*     @ORM\Index(name="email", columns={"email"})})
*/
class Email
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    * @var int
    */
    private $id;

    /**
     * Creation date
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $created;

    /**
     * @ORM\Column(type="string",length=255,nullable=false)
     * @var string
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Contact\Entity\Contact",inversedBy="emails")
     * @var \Contact\Entity\Contact
     * */
    private $contact;

    /**
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     * Doctrine EntityManager
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function setEntityManager(EntityManager $entityManager)
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Set contact
     *
     * @param Contact\Entity\Contact|null $contact
     * @return  Email
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @return Contact\Entity\Contact
     */
    public function getContact()
    {
        return $this->contact;
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
}