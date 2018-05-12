<?php

namespace App\Service;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;

class AddressService
{
    const MIN_QUERY_LENGTH = 3;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var YandexService
     */
    private $yandexService;

    /**
     * AddressService constructor.
     * @param EntityManagerInterface $entityManager
     * @param YandexService $yandexService
     */

    public function __construct(EntityManagerInterface $entityManager, YandexService $yandexService)
    {
        $this->entityManager = $entityManager;
        $this->yandexService = $yandexService;
    }

    /**
     * @param string $query
     * @return Address[]|array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function matches(string $query)
    {
        if (strlen($query) < self::MIN_QUERY_LENGTH) {
            return [];
        }
        /** @var AddressRepository $addressRepo */
        $addressRepo = $this->entityManager->getRepository(Address::class);
        $local = $addressRepo->findByQuery($query);
        if (count($local) > 0) return $local;

        $list = [];

        $this->yandexService->matches($query, function ($geoObject, $text) use ($addressRepo, &$list) {
            $oneBy = $addressRepo->findOneBy(['content' => $text]);

            if ($oneBy) {
                $list[] = $oneBy;
            } else {
                try {
                    $obj = new Address();
                    $obj->setContent($text);
                    $this->entityManager->persist($obj);
                    $this->entityManager->flush();
                    $list[] = $obj;
                } catch (UniqueConstraintViolationException $exception) {
                    //
                }
            }
        });

//        $this->entityManager->flush();

        return $list;
    }
}