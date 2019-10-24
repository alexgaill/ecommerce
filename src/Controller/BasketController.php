<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/basket")
 */
class BasketController extends AbstractController
{
    /**
     * @Route("/", name="basket")
     * @return Response
     */
    public function index(SessionInterface $session)
    {
        $panier = $session->get('panier');
        dump($panier);
        return $this->render('basket/index.html.twig',[
            'panier' => $panier
        ]);
    }

    /** 
    * @Route("/add/{id}", name="basket_add")
    **/
    public function addToBasket(SessionInterface $session, Request $request, $id)
    {
        $form = $request->request;
        
        $panier = $session->get('panier', []);
        $panier[$id] = [
            'id' => $id,
            'new' => $form->get('new'),
            'correct' => $form->get('correct'),
            'occasion' => $form->get('occasion'),
            'abimee' => $form->get('abimee')
        ];

        $session->set('panier', $panier);
        return $this->redirectToRoute('basket');

    }
}
