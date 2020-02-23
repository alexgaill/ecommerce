<?php

namespace App\Controller;

use App\Entity\Entry;
use App\Entity\Stock;
use App\Entity\Arrivage;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use App\Repository\StockRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function commandes(CommandeRepository $commandeRepository, Request $request, EntityManagerInterface $manager)
    {
        if (!is_null($request->request->get('statut')) && !empty($request->request->get('statut'))) {
            $commande = $commandeRepository->find($request->request->get('id'));
            $commande->setStatut($request->request->get('statut'));
            $manager->flush();
        }
        $commandes = $commandeRepository->findAll();
        return $this->render('admin/commandes.html.twig', [
            'commandes' => $commandes
        ]);
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

    /**
     * @Route("/saveArrivage", name="save_arrivage")
     * @Method("POST & GET")
     */
    public function saveArrivage(Request $request, EntityManagerInterface $manager, UserRepository $userRepository, StockRepository $stockRepository, ProductsRepository $productsRepository)
    {
        $cartes = $request->getContent();
        $client = $request->get('client');
        $cartes = $request->get('cartes');
        $total= 0;

        foreach ($cartes as $carte) {
            $total += $carte["totalHT"];
        }

        $rechercheClient = $userRepository->find($client["id"]);

        if ($rechercheClient->getNom() != $client["nom"] || $rechercheClient->getPrenom() != $client["prenom"] || $rechercheClient->getTelephone() != $client["telephone"] || $rechercheClient->getEmail() != $client["mail"] || $rechercheClient->getAdresse() != $client["adresse"] || $rechercheClient->getCodePostal() != $client["codePostal"] || $rechercheClient->getVille() != $client["ville"]) {

            $rechercheClient->setNom($client["nom"])
                            ->setPrenom($client["prenom"])
                            ->setEmail($client["mail"])
                            ->setTelephone($client["telephone"])
                            ->setAdresse($client["adresse"])
                            ->setCodePostal($client["codePostal"])
                            ->setVille($client["ville"]);
            $manager->flush();
        }

        $arrivage = new Arrivage();
        $arrivage->setName($request->get('nomArrivage'))
                ->setCreatedAt(new \DateTime())
                ->setType("achat")
                ->setIdClient($rechercheClient)
                ->setTotalTTC($total);
        $manager->persist($arrivage);

        foreach ($cartes as $carte){

            $rechercheProduct = $productsRepository->findId($carte["setCode"]);
            $rechercheProductQuery = $productsRepository->findIdQuery($carte["setCode"]);
            $rechercheStock = $stockRepository->findOneBy(["card_id" => $rechercheProduct["id"], "stockType" => $carte["type"]]);

            if (empty($carte["new"])) {
                $carte["new"] = 0;
            }
            if (empty($carte["correct"])) {
                $carte["correct"] = 0;
            }
            if (empty($carte["occasion"])) {
                $carte["occasion"] = 0;
            }
            if (empty($carte["abimee"])) {
                $carte["abimee"] = 0;
            }

            if ($rechercheStock == null){
                $rechercheStock = new Stock();
                $rechercheStock->setCardId($rechercheProductQuery)
                    ->setStockType($carte["type"])
                    ->setNew($carte["new"])
                    ->setCorrect($carte["correct"])
                    ->setOccasion($carte["occasion"])
                    ->setAbimee($carte["abimee"]);
                    $manager->persist($rechercheStock);
            }else{
                $rechercheStock->setNew($rechercheStock->getNew() + $carte["new"]);
                $rechercheStock->setCorrect($rechercheStock->getCorrect() + $carte["correct"]);
                $rechercheStock->setOccasion($rechercheStock->getOccasion() + $carte["occasion"]);
                $rechercheStock->setAbimee($rechercheStock->getAbimee() + $carte["abimee"]);

                $manager->flush();
            }

            $entry = new Entry();
            $entry->setIdArrivage($arrivage)
                    ->setIdStock($rechercheStock)
                    ->setNew($carte["new"])
                    ->setCorrect($carte["correct"])
                    ->setOccasion($carte["occasion"])
                    ->setAbimee($carte["abimee"])
                    ->setTotalTTC($carte["totalHT"]);
            
                    
            $manager->persist($entry);
            $arrivage->addEntry($entry);
            $manager->persist($arrivage);
            $manager->flush();

        }
        return new JsonResponse($total);
    }

    /**
     * @Route("/products", name="products")
     */
    public function products(ProductsRepository $productsRepository)
    {
        $products = $productsRepository->findAll();
        $emptyProducts = array();

        foreach ($products as $product) {
            if (is_null($product->getSetCode()) || is_null($product->getSetName()) || 
                $product->getCost() == 0 || $product->getPrice() == 0  || 
                is_null($product->getSetRarity()))
            {
                array_push($emptyProducts, $product);
            }
        }

        return $this->render('admin/products.html.twig', [
            'emptyProducts' => $emptyProducts
        ]);
    }

    /**
     * @Route("/productInfos/{id}", name="productInfos")
     * @param int $id
     */
    public function productInfos ($id, ProductsRepository $productsRepository)
    {
        $product = $productsRepository->find($id);

        // $url = "https://db.ygoprodeck.com/api/v5/cardinfo.php?set_code=" . $product->getName();
        // $infos = file_get_contents($url);
        // $card = json_decode($infos);

        return $this->render('admin/productInfos.html.twig', [
            'product' => $product
            // 'card' => $card
        ]);
    }
}
