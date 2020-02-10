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
       $datas = [];
        
        foreach ($arrivage as $line) {
            foreach ($repo->quantity($line["id"]) as $quantities){
                foreach ($quantities as $quantity) {
                    array_push($line, $quantity);
                }
            }
            array_push($datas, $line);
        }
        return $this->render('shop/index.html.twig', [
            'arrivages' => $datas
            ]);
    }

     /**
     * @Route("/shop", name="shop")
     * @return Response
     */
    public function shop(ProductsRepository $repository, StockRepository $repo, PaginatorInterface $paginator, Request $request) : Response
    {
        if (!is_null($request->query->get('search')) && !empty($request->query->get('search'))) {
            $products = $paginator->paginate(
                $repository->findSearch($request->query->get('search')),
                $request->query->getInt('page', 1),
                24
            );

        } else {
            $products = $paginator->paginate(
                $repository->findAllGrouped(),
                $request->query->getInt('page', 1),
                24
            );
        }

        if (!is_null($request->query->get('setCode')) && !empty($request->query->get('setCode'))) {
            
            $newList = [];
            foreach ($products as $product) {
                if ($product->getSetCode() == $request->query->get('setCode')) {
                    $newList[$product->getId()] = $product;
                }
            }
            $products = $paginator->paginate(
                $newList,
                $request->query->getInt('page', 1),
                24
            );
        }

        if (!is_null($request->query->get('type')) && !empty($request->query->get('type'))) {
            $listType = explode(',', $request->query->get('type'));
            $productsWithResearch = [];
            foreach ($listType as $type) {
                foreach ($products as $product) {
                    foreach ($product->getStocksList() as $stockLine) {
                        if($stockLine->getStockType() == $type)
                        $productsWithResearch[$product->getId()] = $product;
                    }
                }
            }
             $products = $paginator->paginate(
                $productsWithResearch,
                $request->query->getInt('page', 1),
                24
            );
        }
        if (!is_null($request->query->get('etat')) && !empty($request->query->get('etat'))) {
            $listEtat = explode(',', $request->query->get('etat'));
            $productsWithResearch = [];
            foreach ($listEtat as $etat) {
                foreach ($products as $product) {
                    foreach ($product->getStocksList() as $stockLine) {
                        if ($etat == "new") {
                            if($stockLine->getNew() > 0){
                                $productsWithResearch[$product->getId()] = $product;
                            }
                        }
                        if ($etat == "correct") {
                            if($stockLine->getCorrect() > 0){
                                $productsWithResearch[$product->getId()] = $product;
                            }
                        }
                        if ($etat == "occasion") {
                            if($stockLine->getOccasion() > 0){
                                $productsWithResearch[$product->getId()] = $product;
                            }
                        }
                        if ($etat == "abimee") {
                            if($stockLine->getAbimee() > 0){
                                $productsWithResearch[$product->getId()] = $product;
                            }
                        }
                    }
                }
            }
             $products = $paginator->paginate(
                $productsWithResearch,
                $request->query->getInt('page', 1),
                24
            );
        }


        $setCodes = $repository->set_codes();

        $listStockType = $repo->listStockType();

        $count=[$repository->countCard('new'), 
                $repository->countCard('correct'),
                $repository->countCard('occasion'),
                $repository->countCard('abimee')
                ];
        dump($products);
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
        $setList = $repository->setSearch($product->getName());

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
    public function arrivage($id, ProductsRepository $productsRepository, EntryRepository $entryRepository)
    {

        $entries = $entryRepository->getEntriesWithName($id);
        $datas = [];
        foreach ($entries as $entry) {
            $product = $productsRepository->find($entry["id"]);
            array_push($entry, $product->getSlug());
            array_push($datas, $entry);
        }
        dump($datas);
        return $this->render('shop/arrivage.html.twig', [
            'products' => $datas
        ]);
    }
} 