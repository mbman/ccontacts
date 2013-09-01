<?php
namespace Contact\Controller;

use Application\Controller\EntityUsingRestfulController;
use Zend\View\Model\JsonModel;
use Contact\Entity\Contact;
use RuntimeException;

class ContactController extends EntityUsingRestfulController
{
    public function getList()
    {
        # code...
    }
 
    public function get($id)
    {
        # code...
    }
 
    public function create($data)
    {
        # code...
    }
 
    public function update($id, $data)
    {
        # code...
    }
 
    public function delete($id)
    {
        # code...
    }
}