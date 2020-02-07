<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Notification\CommandeNotification;
use App\Repository\UserRepository;
use App\Repository\ProductsRepository;
use App\Repository\StockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/basket")
 */
class BasketController extends AbstractController
{
    /**
     * @var mixed
     */
    private $session;

    /**
     * @var mixed
     */
    private $request;

    /**
     * @var mixed
     */
    private $productsRepository;

    public function __construc(SessionInterface $session, Request $request, ProductsRepository $productsRepository)
    {
        $this->session = $session;
        $this->request = $request;
        $this->productsRepository = $productsRepository;
    }

    /**
     * @Route("/", name="basket")
     */
    public function index()
    {
        $panier = $this->session->get('panier');
        $total = $this->session->get('total');
        return $this->render('basket/index.html.twig',[
            'panier' => $panier,
            'total' => $total
        ]);
    }

    /** 
    * @Route("/add/{id}", name="basket_add")
    * @param mixed $id
    */
    public function addToBasket($id)
    {
        $product = $this->productsRepository->find($id);
        $price = $product->getPrice();
        $panier = $this->session->get('panier', []);
        
        $form = $this->request->request;
        $quantity = $form->all();
        $quantity = array_chunk($quantity, 4, true);

        foreach ($quantity as $type) {
            $key = array_key_first($type);
            $key = explode("new", $key)[1];

            $panier[$id.$key] = [
                'id' => $id,
                'name' => $product->getName(),
                'imgSmall' => $product->getImgSmall(),
                'price' => $price,
                'setCode' => $product->getSetCode(),
                'type' => $key,
                'new' => intval($type["new".$key]),
                'correct' => intval($type["correct".$key]),
                'occasion' => intval($type["occasion".$key]),
                'abimee' => intval($type["abimee".$key]),
                'totalNew' => round($price * $type["new".$key], 2),
                'totalCorrect' => round(($price * $type["correct".$key] * 0.9), 2),
                'totalOccasion' => round(($price * $type["occasion".$key] * 0.8), 2),
                'totalAbimee' => round(($price * $type["abimee".$key] * 0.6), 2),
                'poids' => 2 * (intval($type["new".$key]) + intval($type["correct".$key]) + intval($type["occasion".$key]) + intval($type["abimee".$key])),
                'total' => $price * intval($type["new".$key]) + 
                            $price * intval($type["correct".$key]) * 0.9 + 
                            $price * intval($type["occasion".$key]) * 0.8 + 
                            $price * intval($type["abimee".$key]) * 0.6
            ];

        }

        $poids = 0;
        $total = 0;
        foreach ($panier as $article){
            $poids += $article["poids"];
            $total += $article["total"];
        }
        
        $this->session->set('poids', $poids);
        $this->session->set('total', $total);
        $this->session->set('panier', $panier);

        return $this->redirectToRoute('/');
    }

    /** 
    * @Route("/remove/{id}{type}", name="basket_remove")
    * @param mixed $id
    * @param string $type
    **/
    public function removeFromBasket ($id, $type)
    {
        $panier = $this->session->get('panier', []);
        $poids = $this->session->get('poids');
        $total = $this->session->get('total');
        $poids -= $panier[$id.$type]['poids']; 
        $total -= $panier[$id.$type]['total']; 
        unset($panier[$id.$type]);
        $this->session->set('panier', $panier);
        $this->session->set('poids', $poids);
        $this->session->set('total', $total);
        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/validation", name="validation")
     */
    public function validation()
    {
        $panier = $this->session->get('panier', []);
        $poids = $this->session->get('poids');
        $total = $this->session->get('total');

        return $this->render('basket/validation.html.twig', [
            'panier' => $panier,
            'poids' => $poids,
            'total' => $total
        ]);
    }

    /**
     * @Route("/saveCommande", name="save_commande")
     */
    public function saveCommande(EntityManagerInterface $manager, 
                                UserRepository $userRepository, StockRepository $stockRepository, 
                                Security $security, CommandeNotification $notification)
    {
        $data = $this->request->request;
        $dataUser = $data->get('user');
        $panier = $this->session->get('panier', []);
        $poids = $this->session->get('poids');
        $total = $this->session->get('total');

        if ($dataUser != null) {
            $user = $userRepository->findOneBy(['nom' => $dataUser['nom']]);

            $user->setNom($dataUser["nom"])
                ->setPrenom($dataUser["prenom"])
                ->setTelephone($dataUser["telephone"])
                ->setEmail($dataUser["mail"])
                ->setAdresse($dataUser["adresse"])
                ->setCodePostal($dataUser["codePostal"])
                ->setVille($dataUser["ville"]);
            
                $manager->persist($user);
        }else{
            $user = $security->getUser();
        }

        $commande = new Commande();
        $commande->setUserId($user)
                ->setCommandeDate(new \DateTime())
                ->setMontant($total)
                ->setLivraison($data->get('livraison'))
                ->setTarifLivraison($data->get('tarif'))
                ->setTypeLivraison($data->get('typeLivraison'))
                ->setMontantTotal($total + $data->get('tarif'))
                ->setStatut('attente')
                ->setPoids($poids)
                ->setTypePaiement($data->get('paiement'));
        
        $manager->persist($commande);

        foreach ($panier as $ligne) {
            $productLine = $this->productsRepository->find($ligne["id"]);
            $ligneCommande = new LigneCommande();
            $ligneCommande  ->setProductId($productLine)
                            ->setCommandeId($commande)
                            ->setType($ligne["type"])
                            ->setSetCode($ligne["setCode"])
                            ->setNew($ligne["new"])
                            ->setCorrect($ligne["correct"])
                            ->setOccasion($ligne["occasion"])
                            ->setAbimee($ligne["abimee"])
                            ->setPoids($ligne["poids"])
                            ->setTotal($ligne["total"])
                            ->setPrixUnitaire($ligne["price"]);
        $manager->persist($ligneCommande);

        $stock = $stockRepository->findOneBy(["card_id" => $ligne["id"], "stockType" => $ligne["type"]]);
        $stock  ->setNew($stock->getNew() - $ligne["new"])
                ->setCorrect($stock->getCorrect() - $ligne["correct"])
                ->setOccasion($stock->getOccasion() - $ligne["occasion"])
                ->setAbimee($stock->getAbimee() - $ligne["abimee"]);

        }

        $manager->flush();

        $notification->notify($commande);

        return new JsonResponse('ok');
    }

    /**
     * @Route("/thanks", name="thanks")
     */
    public function thanks()
    {
        $this->session->set('panier', []);
        $this->session->set('poids', '');
        $this->session->set('total', '');

        return $this->render('basket/thanks.html.twig');
    }

    /**
     * @Route("/test", name="test")
     */
    // public function test(UserRepository $user)
    // {
    //     $user = $user->find(1);
    //     return $this->render('emails/inscription.html.twig', [
    //         'user' => $user
    //     ]);
    // }
}
