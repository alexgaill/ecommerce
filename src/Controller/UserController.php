<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
     /**
     * @Route("/user/login", name="login")
     * @return Response
     */
    public function login() : Response
    {
        // $products = $this->repository->findAll();
        return $this->render('user/login.html.twig', [
            // 'products' => $products
        ]);
    }

    /**
     * @Route("/user/signup", name="signup")
     * @return Response
     */
    public function signup(Request $request, ObjectManager $manager)
    {
        $user = new User();
        $this->manager = $manager;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash("success", "Votre compte est créé avec succès");
            return $this->redirectToRoute('login');
        }

        // $products = $this->repository->findAll();
        return $this->render('user/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
