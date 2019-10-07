<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Products;
use App\Repository\ProductsRepository;

use Symfony\Component\HttpFoundation\Request;
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
     * @Route("../user/login", name="login")
     * @return Response
     */
    public function login() : Response
    {
        $products = $this->repository->findAll();
        return $this->render('user/login.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("../user/signup", name="signup")
     * @return Response
     */
    public function signup(User $user, Request $request) : Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash("success", "Votre compte est créé avec succès");
            return $this->redirectToRoute('login');
        }

        $products = $this->repository->findAll();
        return $this->render('user/signup.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

} 