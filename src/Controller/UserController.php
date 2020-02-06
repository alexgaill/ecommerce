<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Notification\InscriptionNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
     /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function login()
    {
		return $this->render('user/login.html.twig');
    }

    /**
     * @Route("/signup", name="signup")
     * @return Response
     */
    public function signup(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, InscriptionNotification $notification)
    {
        $user = new User();
        $this->manager = $manager;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $newDate = new \DateTime();
            $date = $newDate->format('Y-m-d');
            $code = $user->createCode($user->getNom(), $date);

            $user->setValide(false)
                ->setCodeValidation($code)
                ->setCreatedAt($newDate);
            
            $this->manager->persist($user);
            $this->manager->flush();
            $notification->notify($user);

            return $this->redirectToRoute('login');
        }

        return $this->render('user/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/account", name="account")
     */
    public function account()
    {

    }

    /**
     * @Route("/validationCompte/{token}", name="validationCompte")
     */
    public function validationCompte($token){
        return $this->render('validation.html.twig');
    }
}
