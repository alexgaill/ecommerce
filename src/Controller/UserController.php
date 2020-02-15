<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Notification\InscriptionNotification;
use App\Repository\UserRepository;
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
     * @var mixed
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
     /**
     * @Route("/login", name="login")
     */
    public function login()
    {
		return $this->render('user/login.html.twig');
    }

    /**
     * @Route("/signup", name="signup")
     */
    public function signup(Request $request, UserPasswordEncoderInterface $encoder, InscriptionNotification $notification)
    {
        $user = new User();
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

            return $this->redirectToRoute('validationCreation');
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
     * @Route("/validationCreation", name="validationCreation")
     */
    public function validationCreation(){
        return $this->render('user/create.html.twig');
    }

    /**
     * @Route("/validationCompte/{token}", name="validationCompte")
     * * @param string $token
     */
    public function validationCompte($token, UserRepository $repository){
        $user = $repository->findOneBy(["code_validation" => $token]);

        if (!is_null($user)){
            $user->setValide(true);
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->render('user/accountValidate.html.twig');
        }
        return $this->render('home');
    }
}
