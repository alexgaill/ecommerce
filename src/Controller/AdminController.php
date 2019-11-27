<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
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
     */
    public function getCards(ProductsRepository $repository, SerializerInterface $serialize)
    {
        $cards = $repository->findAllName();
        $response = new JsonResponse($cards);

        return $response;
    }
}
