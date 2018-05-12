<?php
/**
 * Created by PhpStorm.
 * User: goforbroke
 * Date: 12.05.18
 * Time: 11:56
 */

namespace App\Repository;

use App\Entity\Address;
use Doctrine\ORM\EntityRepository;

class AddressRepository extends EntityRepository
{
    /**
     * @param string $query
     * @return array|Address[]
     */
    public function findByQuery(string $query): array
    {
        $qb = $this->createQueryBuilder('addr');
        $qb->andWhere(
            $qb->expr()->like('addr.content', ':query')
        );
        $qb->setParameter('query', "%{$query}%");
        return $qb->getQuery()->getResult();
    }
}