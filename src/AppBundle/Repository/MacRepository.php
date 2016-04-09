<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MacRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MacRepository extends EntityRepository
{
    public function findFreeMacs()
    {
        return $this->createQueryBuilder('m')
            ->select('m, e')
            ->leftJoin('m.employee', 'e')
            ->where('e.mac IS NULL')
            ->getQuery()
            ->getResult();
    }
}
