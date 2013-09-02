<?php
namespace Contact\Controller;

use Application\Controller\EntityUsingRestfulController;
use Zend\View\Model\JsonModel;
use Contact\Entity\Contact;
use RuntimeException;
use Swagger\Annotations as SWG;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity as DoctrineHydrator;

/**
 * @SWG\Resource(
 *     apiVersion="0.1",
 *     swaggerVersion="1.1",
 *     resourcePath="/contact"
 * )
 */
class ContactController extends EntityUsingRestfulController
{
    /**
     * @var Contact\Entity\ContactRepository
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

    /**
     *
     * @SWG\Api(
     *   path="/contact",
     *   description="Get contacts list",
     *   @SWG\Operations(
     *       @SWG\Operation(
     *           httpMethod="GET", nickname="getContacts",responseClass="Contact"
     *       )
     *     )
     *   )
     * )
     */
    public function getList()
    {
        $hydrator = new DoctrineHydrator($this->getEntityManager(),'Contact\Entity\Contact');
        $contacts = [];
        foreach($this->getContactRepository()->findAll() as $contact) {
            $contacts[] = $hydrator->extract($contact);
        }
        return new JsonModel($contacts);
    }


    /**
     *
     * @SWG\Api(
     *   path="/contact/{contactId}",
     *   description="Contacts RESTful operations",
     *   @SWG\Operations(
     *       @SWG\Operation(
     *           httpMethod="GET", summary="Find contact by ID", notes="Returns a contact by ID",
     *           responseClass="Contact", nickname="getContactById",
     *           @SWG\ErrorResponses(
     *               @SWG\ErrorResponse(code="404", reason="Contact not found")
     *           )
     *       )
     *     )
     *   )
     * )
     */
    public function get($id)
    {
        $contact = $this->getContactRepository()->find($id);
        if (!$contact) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $hydrator = new DoctrineHydrator($this->getEntityManager(),'Contact\Entity\Contact');
        return new JsonModel($hydrator->extract($contact));
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