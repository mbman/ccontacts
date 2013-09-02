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
     *
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
     * Returns the Contact model hydrator
     *
     * @return DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity
     */
    public function getContactHydrator()
    {
        return new DoctrineHydrator($this->getEntityManager(),'Contact\Entity\Contact');
    }

    /**
     *
     * @SWG\Api(
     *   path="/contact",
     *   description="Get contacts list",
     *   @SWG\Operations(
     *       @SWG\Operation(
     *           httpMethod="GET", nickname="getList",responseClass="Contact"
     *       )
     *     )
     *   )
     * )
     */
    public function getList()
    {
        $hydrator = $this->getContactHydrator();
        $contacts = [];
        foreach($this->getContactRepository()->search() as $contact) {
            $contacts[] = $hydrator->extract($contact);
        }
        return new JsonModel($contacts);
    }

    /**
     *
     * @SWG\Api(
     *   path="/contact/search/{query}",
     *   description="Search contacts list by name, e-mail, tag, company...",
     *   @SWG\Operations(
     *       @SWG\Operation(
     *           httpMethod="GET",nickname="search",responseClass="Contact",
     *           @SWG\Parameters(@SWG\Parameter(
     *             name="query",
     *             description="Search query",
     *             paramType="path",
     *             required="false",
     *             allowMultiple="false",
     *             dataType="string"
     *           ))
     *       )
     *     )
     *   )
     * )
     */
    public function searchAction()
    {
        $hydrator = $this->getContactHydrator();
        $contacts = [];
        foreach($this->getContactRepository()->search($this->params('query')) as $contact) {
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
     *           responseClass="Contact",nickname="getContactById",
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
        $hydrator = $this->getContactHydrator();
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