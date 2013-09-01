<?php
namespace Application\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class GetIdStrategy implements StrategyInterface
{
    public function extract($value)
    {
        if (is_numeric($value) || $value === null) {
            return $value;
        }

        return $value->getId();
    }

    public function hydrate($value)
    {
        return $value;
    }
}