<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;

use App\Repository\UserRepository;
use App\Repository\ProductsRepository;
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
        return $this->render('basket/index.html.twig',[
            'panier' => $panier
        ]);
    }

    /** 
    * @Route("/add/{id}", name="basket_add")
    **/
    public function addToBasket(SessionInterface $session, Request $request, $id, ProductsRepository $repository)
    {
        $product = $repository->find($id);
        $price = $product->getPrice();
        
        $form = $request->request;
        
        $panier = $session->get('panier', []);
        $panier[$id] = [
            'id' => $id,
            'name' => $product->getName(),
            'imgSmall' => $product->getImgSmall(),
            'price' => $price,
            'setCode' => $product->getSetCode(),
            'new' => $form->get('new'),
            'correct' => $form->get('correct'),
            'occasion' => $form->get('occasion'),
            'abimee' => $form->get('abimee'),
            'totalNew' => $price * intval($form->get('new')),
            'totalCorrect' => $price * intval($form->get('correct')) * 0.9,
            'totalOccasion' => $price * intval($form->get('occasion')) * 0.8,
            'totalAbimee' => $price * intval($form->get('abimee')) * 0.6
        ];
        
        $session->set('panier', $panier);
        return $this->redirectToRoute('basket');
    }

    /** 
    * @Route("/remove/{id}", name="basket_remove")
    **/
    public function removeFromBasket (SessionInterface $session, $id)
    {
        $panier = $session->get('panier', []);
        unset($panier[$id]);
        $session->set('panier', $panier);
        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/validation", name="validation")
     */
    public function validation()
    {
        return $this->render('basket/validation.html.twig');
    }
}
