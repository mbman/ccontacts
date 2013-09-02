<?php
namespace Contact\Entity;
use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository
{

    /**
     * Returns all contacts who match $searchTerm in their name, company, tag,
     * e-mail or phone number.
     *
     * @param  string $searchTerm
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function search($searchTerm = '')
    {
        $dql = "select u from Contact\Entity\Contact u ";
        if (!empty($searchTerm)) {
            $dql .= "where u.firstName like ?1 or u.lastName like ?1
                 or u.company like ?1 or u.city like ?1 ";
        }
        $dql .= "order by u.firstName ASC, u.lastName ASC";
        $query = $this->_em->createQuery($dql);
        if (!empty($searchTerm)) {
            $query->setParameter(1, "%$searchTerm%");
        }
        return $query->getResult();
    }
}