<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function findAllUsers()
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->getQuery()
            ->getResult();
    }
}
