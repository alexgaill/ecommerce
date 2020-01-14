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
        $total = $session->get('total');
        return $this->render('basket/index.html.twig',[
            'panier' => $panier,
            'total' => $total
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
            'new' => intval($form->get('new')),
            'correct' => intval($form->get('correct')),
            'occasion' => intval($form->get('occasion')),
            'abimee' => intval($form->get('abimee')),
            'totalNew' => $price * intval($form->get('new')),
            'totalCorrect' => $price * intval($form->get('correct')) * 0.9,
            'totalOccasion' => $price * intval($form->get('occasion')) * 0.8,
            'totalAbimee' => $price * intval($form->get('abimee')) * 0.6,
            'poids' => 2 * (intval($form->get('new')) + intval($form->get('correct')) + intval($form->get('occasion')) + intval($form->get('abimee'))),
            'total' => $price * intval($form->get('new')) + $price * intval($form->get('correct')) * 0.9 + $price * intval($form->get('occasion')) * 0.8 + $price * intval($form->get('abimee')) * 0.6
        ];
        $poids = 0;
        $total = 0;
        foreach ($panier as $article){
            $poids += $article["poids"];
            $total += $article["total"];
        }
        
        $session->set('poids', $poids);
        $session->set('total', $total);
        $session->set('panier', $panier);

        return $this->redirectToRoute('basket');
    }

    /** 
    * @Route("/remove/{id}", name="basket_remove")
    **/
    public function removeFromBasket (SessionInterface $session, $id)
    {
        $panier = $session->get('panier', []);
        $poids = $session->get('poids');
        $total = $session->get('total');
        $poids -= $panier[$id]['poids']; 
        $total -= $panier[$id]['total']; 
        unset($panier[$id]);
        $session->set('panier', $panier);
        $session->set('poids', $poids);
        $session->set('total', $total);
        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/validation", name="validation")
     */
    public function validation(SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        $poids = $session->get('poids');
        $total = $session->get('total');

        return $this->render('basket/validation.html.twig', [
            'panier' => $panier,
            'poids' => $poids,
            'total' => $total
        ]);
    }
}
