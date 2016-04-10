<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MonitorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MonitorRepository extends EntityRepository
{
    public function findFreeMonitors()
    {
        return $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.employee IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function  findAllOrdered()
    {
        return $this->createQueryBuilder('m')
            ->select('m, e')
            ->leftJoin('m.employee', 'e')
            ->orderBy('e.lastName', 'ASC')
            ->getQuery()
            ->getResult();
    }


}
