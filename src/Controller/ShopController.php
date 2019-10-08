<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    public function __construct(ObjectManager $manager, ProductsRepository $repository)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index() : Response
    {
        $products = $this->repository->findAll();
        return $this->render('shop/index.html.twig', [
            'products' => $products
            ]);
    }

     /**
     * @Route("/shop", name="shop")
     * @return Response
     */
    public function shop() : Response
    {
        $products = $this->repository->findAll();
        return $this->render('shop/shop.html.twig', [
            'products' => $products
            ]);
    }
    
     /**
     * @Route("/collection", name="collection")
     * @return Response
     */
    public function collection() : Response
    {
        $products = $this->repository->findAll();
        return $this->render('shop/collection.html.twig', [
            'products' => $products
            ]);
    }
} 