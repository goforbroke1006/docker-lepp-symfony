<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\AddressService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController //extends Controller
{
    private $addressService;

    /**
     * DefaultController constructor.
     * @param AddressService $addressService
     */
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * @Route("/homepage")
     *
     * @return Response
     */
    public function homepage()
    {
        return new Response('Welcome!');
        //return $this->render('default/homepage.html.twig', array());
    }

    /**
     * @Route("/api/address/{query}")
     *
     * @param string $query
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addressOptions(string $query)
    {
        $result = $this->addressService->matches($query);
        return new JsonResponse($result);
    }
}