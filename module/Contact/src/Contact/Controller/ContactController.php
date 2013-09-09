<?php
namespace Contact\Controller;

use Application\Controller\EntityUsingRestfulController;
use Application\Hydrator\Strategy\CollectionStrategy;
use Zend\View\Model\JsonModel;
use Contact\Entity\Contact;
use Contact\Form\ContactForm;
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
        $hydrator = new DoctrineHydrator($this->getEntityManager(),'Contact\Entity\Contact');
        return $hydrator;
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
     *
     * RESTful get contacts list
     *
     * @return Zend\View\Model\JsonModel contacts data
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
     *
     * RESTful search contacts
     *
     * @return Zend\View\Model\JsonModel found contacts data
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
     *   description="Find contact by ID",
     *   @SWG\Operations(
     *       @SWG\Operation(
     *           httpMethod="GET", summary="Find contact by ID",
     *           responseClass="Contact",nickname="getContactById",
     *           @SWG\ErrorResponses(
     *               @SWG\ErrorResponse(code="404", reason="Contact not found")
     *           ),
     *           @SWG\Parameters(@SWG\Parameter(
     *             name="id",
     *             description="Contact ID",
     *             paramType="path",
     *             required="true",
     *             allowMultiple="false",
     *             dataType="int"
     *           ))
     *       )
     *     )
     *   )
     * )
     *
     * RESTful get contact
     *
     * @param  int $id
     * @return Zend\View\Model\JsonModel contact data
     */
    public function get($id)
    {
        $contact = $this->getContactRepository()->find($id);
        if (!$contact) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $em = $this->getEntityManager();
        $contact->setEntityManager($em);
        $hydrator = $this->getContactHydrator();
        $hydrator->addStrategy('emails', new CollectionStrategy(new DoctrineHydrator($em,'Contact\Entity\Email')));
        $hydrator->addStrategy('phones', new CollectionStrategy(new DoctrineHydrator($em,'Contact\Entity\Phone')));
        return new JsonModel($hydrator->extract($contact));
    }

    /**
     *
     * @SWG\Api(
     *   path="/contact",
     *   description="Create contact",
     *   @SWG\Operations(
     *       @SWG\Operation(
     *           httpMethod="POST", summary="Create contact",
     *           responseClass="Contact",nickname="create",
     *           @SWG\ErrorResponses(
     *               @SWG\ErrorResponse(code="404", reason="Contact not found"),
     *               @SWG\ErrorResponse(code="400", reason="Validation failed")
     *           )
     *       )
     *     )
     *   )
     * )
     *
     * RESTful create contact
     *
     * @param  array $data
     * @return Zend\View\Model\JsonModel contact data or error messages
     */
    public function create($data)
    {
        return $this->update(0, $data);
    }


    /**
     *
     * @SWG\Api(
     *   path="/contact/{contactId}",
     *   description="Update contact",
     *   @SWG\Operations(
     *       @SWG\Operation(
     *           httpMethod="PUT", summary="Update contact",
     *           responseClass="Contact",nickname="update",
     *           @SWG\ErrorResponses(
     *               @SWG\ErrorResponse(code="404", reason="Contact not found"),
     *               @SWG\ErrorResponse(code="400", reason="Validation failed")
     *           ),
     *           @SWG\Parameters(@SWG\Parameter(
     *             name="id",
     *             description="Contact ID",
     *             paramType="path",
     *             required="true",
     *             allowMultiple="false",
     *             dataType="int"
     *           ))
     *       )
     *     )
     *   )
     * )
     *
     * RESTful contact update
     *
     * @param  int $id
     * @param  array $data
     * @return Zend\View\Model\JsonModel contact data or error messages
     */
    public function update($id, $data)
    {
        $contact = new Contact;
        $em = $this->getEntityManager();
        $form = new ContactForm($em);
        if ($id > 0) {
            $contact = $em->getRepository('Contact\Entity\Contact')->find($id);
            if (!$contact) {
                $this->getResponse()->setStatusCode(404);
                return;
            }
        }
        $contact->setEntityManager($em);
        $form->bind($contact);
        $form->setInputFilter($contact->getInputFilter());
        $form->setData($data);

        if (!$form->isValid()) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel($form->getMessages());
        }
        $em->persist($contact);
        $em->flush();

        return $this->get($contact->getId());
    }


    /**
     *
     * @SWG\Api(
     *   path="/contact/{contactId}",
     *   description="Delete a contact by ID",
     *   @SWG\Operations(
     *       @SWG\Operation(
     *           httpMethod="DELETE", summary="Delete a contact by ID",
     *           nickname="deleteContactById",
     *           @SWG\ErrorResponses(
     *               @SWG\ErrorResponse(code="404", reason="Contact not found")
     *           ),
     *           @SWG\Parameters(@SWG\Parameter(
     *             name="id",
     *             description="Contact ID",
     *             paramType="path",
     *             required="true",
     *             allowMultiple="false",
     *             dataType="int"
     *           ))
     *       )
     *     )
     *   )
     * )
     *
     * RESTful delete contact
     *
     * @param  int $id
     * @return Zend\View\Model\JsonModel contact data
     */
    public function delete($id)
    {
        $contact = $this->getContactRepository()->find($id);
        if (!$contact) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $em = $this->getEntityManager();
        $em->remove($contact);
        $em->flush();
        return new JsonModel(array('success' => true));
    }
}