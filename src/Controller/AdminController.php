<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

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
     * @Route("/getCards, name="get_cards")
     */
    public function getCards(ProductsRepository $repository, Serializer $serialize)
    {
        $cards = $repository->findAll();
        $json = $serialize->serialize($cards, 'json');

        return $json;
    }
}
