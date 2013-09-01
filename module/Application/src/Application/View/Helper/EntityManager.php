<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class EntityManager extends AbstractHelper
{
  /**
    * @var EntityManager
    */
    protected $entityManager;

    /**
    * Sets the EntityManager
    *
    * @param EntityManager $em
    * @return PostController
    */
    public function setEntityManager(\Doctrine\ORM\EntityManager $em)
    {
        $this->entityManager = $em;
        return $this;
    }

    /**
    * @return EntityManager
    */
    public function getEntityManager()
    {
       return $this->entityManager;
    }

    /**
    * @return EntityManager
    */
    public function __invoke()
    {
       return $this->getEntityManager();
    }
}