<?php

namespace App\Controller;


use App\Repository\ProductsRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function achats(UserRepository $repository)
    {
        $users = $repository->findAll();
        return $this->render('admin/achats.html.twig',[
            'users' => $users
        ]);
    }

    /**
     * @Route("/getSeller/{id}", name="get_seller")
     */
    public function getSeller(UserRepository $repository, $id)
    {
        $user = $repository->findSeller($id);

        return new JsonResponse($user);
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
     * @Route("/getCost/{setCode}", name="get_cost")
     * @Method("GET")
     */
    public function getSetCode(ProductsRepository $repository, $setCode)
    {
        $cards = $repository->findCost($setCode);
        $response = new JsonResponse($cards);

        return $response;
    }
}
