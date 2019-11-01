<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
     /**
     * @Route("/user/login", name="login")
     * @return Response
     */
    public function login()
    {
		return $this->render('user/login.html.twig');
    }

    /**
     * @Route("/user/signup", name="signup")
     * @return Response
     */
    public function signup(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
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
            return $this->redirectToRoute('login');
        }

        return $this->render('user/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/logout", name="logout")
     */

    public function logout()
    {

    }
}
