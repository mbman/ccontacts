<?php
namespace Contact\Controller;

use Application\Controller\EntityUsingRestfulController;
use Zend\View\Model\JsonModel;
use Contact\Entity\Contact;
use RuntimeException;

class ContactController extends EntityUsingRestfulController
{
    /**
     * @var [type]
     */
    protected $contactRepository;

    /**
     * Returns the Contact Doctrine repository
     * @return Contact\Entity\Contact
     */
    public function getContactRepository()
    {
        if (!$this->contactRepository) {
            $em = $this->getEntityManager();
            $this->contactRepository = $em->getRepository('Contact\Entity\Contact');
        }
        return $this->contactRepository;
    }

    public function getList()
    {
        $data = [];
        foreach($this->getContactRepository()->findAll() as $result) {
            $data[] = $result;
        }
        return new JsonModel(array('data' => $data));
    }
 
    public function get($id)
    {
        return new JsonModel();
    }
 
    public function create($data)
    {
        return new JsonModel();
    }
 
    public function update($id, $data)
    {
        return new JsonModel();
    }
 
    public function delete($id)
    {
        return new JsonModel();
    }
}