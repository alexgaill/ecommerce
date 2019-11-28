<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/admin")
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/commandes", name="commandes")
     */
    public function commandes()
    {
        // return $this->render('admin/index.html.twig', [
        //     'controller_name' => 'AdminController',
        // ]);
    }

    /**
     * @Route("/achats", name="achats")
     */
    public function achats()
    {
        return $this->render('admin/achats.html.twig');
    }

    /**
     * @Route("/getCards", name="get_cards")
     * @Method("GET")
     */
    public function getCards(ProductsRepository $repository)
    {
        $cards = $repository->findAllName();
        $response = new JsonResponse($cards);

        return $response;
    }

    /**
     * @Route("/getSetCode/{id}", name="get_setCode")
     * @Method("GET")
     */
    public function getSetCode(ProductsRepository $repository, $name)
    {
        $cards = $repository->findSetCodes($name);
        $response = new JsonResponse($cards);

        return $response;
    }
}
