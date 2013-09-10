<?php
namespace Contact\Entity;
use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository
{
    protected static $searchFields = array(
        'c.firstName',
        'c.lastName',
        'c.company',
        'c.city',
        'c.job',
        'c.tags',
        'p.phone',
        'e.email',
        );
    /**
     * Returns all contacts who match $searchTerm in their name, company, tag,
     * e-mail or phone number.
     *
     * @param  string $searchTerm
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function search($searchTerm = '')
    {
        $dql = "select c from Contact\Entity\Contact c JOIN c.emails e JOIN c.phones p ";
        if (!empty($searchTerm)) {
            $dql .= "where ".implode(" like ?1 or ", self::$searchFields).' like ?1 ';
        }
        $dql .= "order by c.firstName ASC, c.lastName ASC";
        $query = $this->_em->createQuery($dql);
        if (!empty($searchTerm)) {
            $query->setParameter(1, "%$searchTerm%");
        }
        return $query->getResult();
    }
}