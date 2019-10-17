<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\EntryRepository;
use App\Repository\ArrivageRepository;
use App\Repository\ProductsRepository;
use App\Repository\StockRepository;

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
    public function index(ArrivageRepository $repository, EntryRepository $repo) : Response
    {
        $this->repository = $repository;
        $this->repo = $repo;
        
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
    public function shop(ProductsRepository $repository, StockRepository $repo) : Response
    {
        $this->repository = $repository;
        $this->repo = $repo;

        $setCodes = $this->repository->set_codes();
        $products = $this->repository->findAllGrouped();
        $listStockType = $this->repo->listStockType();

        $count=[$this->repository->countCard('new'), 
                $this->repository->countCard('correct'),
                $this->repository->countCard('occasion'),
                $this->repository->countCard('abimee')
                ];
        return $this->render('shop/shop.html.twig', [
            'products' => $products,
            'setCodes' => $setCodes,
            'count' => $count,
            'listStockType' => $listStockType
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