<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\AddressService;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddressRestController extends FOSRestController
{
    private $addressService;

    /**
     * AddressRestController constructor.
     * @param AddressService $addressService
     */
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * @Route("/api/address/{query}")
     *
     * @param string $query
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addressOptions(string $query)
    {
        return $this->addressService->matches($query);
    }
}