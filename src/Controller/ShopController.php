<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Products;
use App\Repository\ProductsRepository;

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

} 