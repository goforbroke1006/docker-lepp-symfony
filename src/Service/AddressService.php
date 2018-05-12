<?php

namespace App\Service;

use App\Entity\Address;
use App\Repository\AddressRepository;
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

        $url = 'https://geocode-maps.yandex.ru/1.x/?format=json&geocode=' . $query;
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        $res = $res["response"]["GeoObjectCollection"]["featureMember"];

        $list = [];
        foreach ($res as $addr) {
            $raw = $addr["GeoObject"]["metaDataProperty"]["GeocoderMetaData"]["text"];
            $obj = new Address();
            $obj->setContent($raw);
            $this->entityManager->persist($obj);
            $list[] = $obj;
        }
        $this->entityManager->flush();

        return $list;
    }
}