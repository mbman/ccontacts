<?php
namespace Application\Hydrator\Strategy;

use Doctrine\Common\Collections\Collection;
use DoctrineModule\Stdlib\Hydrator\Strategy\AllowRemoveByValue;

class CollectionStrategy extends AllowRemoveByValue
{
    protected $hydrator;

    public function __construct($hydrator = null) {
        $this->hydrator = $hydrator;
    }
    public function extract($value)
    {
        if ($value instanceof Collection) {
            $return = array();
            foreach ($value as $entity) {
                $return[] = $this->hydrator->extract($entity);
            }
            return $return;
        }
        return $value;
    }
}