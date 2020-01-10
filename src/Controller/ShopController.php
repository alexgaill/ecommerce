<?php

namespace App\Controller;

use App\Entity\Products;

use App\Repository\EntryRepository;
use App\Repository\StockRepository;
use App\Repository\ArrivageRepository;
use App\Repository\ProductsRepository;

use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\Request;
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
       $arrivage = $repository->findLastTen();
        
        // foreach ($arrivage as $line) {
        //     array_push($line, $repo->quantity($line->getId()));
        // }

        return $this->render('shop/index.html.twig', [
            'arrivages' => $arrivage
            ]);
    }

     /**
     * @Route("/shop", name="shop")
     * @return Response
     */
    public function shop(ProductsRepository $repository, StockRepository $repo, PaginatorInterface $paginator, Request $request) : Response
    {
        $this->repository = $repository;
        $this->repo = $repo;

        $setCodes = $this->repository->set_codes();
        $products = $paginator->paginate(
            $this->repository->findAllGrouped(),
            $request->query->getInt('page', 1),
            24
        );

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

    /**
     * @Route("/card/{slug}-{id}", name="card", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function card(string $slug, Products $product, ProductsRepository $repository) : Response
    {
        $this->repository = $repository;

        $setList = $this->repository->setSearch( $product->getName());

        if ($product->getSlug() !== $slug) {
            return $this->redirectToRoute('shop/card.html.twig', [
                'id' => $product->getId(),
                'setList' => $setList,
                'slug' => $product->getSlug()
            ], 301);
        }

        return $this->render('shop/card.html.twig', [
            'product' => $product,
            'setList' => $setList,
            'slug' => $product->getSlug()
            ]);
    }

    /** 
     * @Route("/arrivage/{id}", name="arrivage")
     */
    public function arrivage($id, ArrivageRepository $repository)
    {
        $arrivage = $repository->find($id);
        return $this->render('shop/arrivage.html.twig', [
            'products' => $arrivage->getEntries()
        ]);
    }
} 