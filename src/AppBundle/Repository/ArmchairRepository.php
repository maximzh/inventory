<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArmchairRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArmchairRepository extends EntityRepository
{
    public function findFreeArmchairs()
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.employee IS NULL')
            ->getQuery()
            ->getResult();
    }
}
