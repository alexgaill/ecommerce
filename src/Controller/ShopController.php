<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\EntryRepository;
use App\Repository\ArrivageRepository;
use App\Repository\ProductsRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(ObjectManager $manager, ArrivageRepository $repository, EntryRepository $repo) : Response
    {
        $this->repository = $repository;
        $this->repo = $repo;
        $this->manager = $manager;
        
        $arrivage = $this->repository->findLastTen();
        
        foreach ($arrivage as $line) {
            array_push($line, $this->repo->quantity($line->getId()));
        }

        return $this->render('shop/index.html.twig', [
            'arrivages' => $arrivage
            ]);
    }

     /**
     * @Route("/shop", name="shop")
     * @return Response
     */
    public function shop(ObjectManager $manager, ProductsRepository $repository) : Response
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $setCodes = $this->repository->set_codes();
        dump($setCodes);
        $products = $this->repository->findAll();
        return $this->render('shop/shop.html.twig', [
            'products' => $products,
            'setCodes' => $setCodes
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