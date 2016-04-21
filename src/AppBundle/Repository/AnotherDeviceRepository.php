<?php
/**
 * Created by PhpStorm.
 * User: fumus
 * Date: 09.04.16
 * Time: 17:39
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class AnotherDeviceRepository extends EntityRepository
{
    
    public function  findAllOrdered()
    {
        return $this->createQueryBuilder('a')
            ->select('a, e')
            ->leftJoin('a.employee', 'e')
            ->orderBy('a.type', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findFreeDevices()
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.employee IS NULL')
            ->orderBy('a.type', 'ASC')
            ->getQuery()
            ->getResult();
    }

}