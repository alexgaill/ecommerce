<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\InscriptionNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Notification\ForgetPasswordNotification;
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
            $date = $newDate->format('Y-m-d H:i:s');
            $code = $user->createCode($user->getEmail(), $date);

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
     * @Route("/forgetPassword", name="forgetPassword")
     */
    public function forgetPassword(Request $request, UserRepository $repository, ForgetPasswordNotification $notification)
    {
        $message = false;
        $sendMessage = false;

        if (!is_null($request->request->get('email')) && !empty($request->request->get('email'))) {
            $user = $repository->findOneBy(["email" => $request->request->get('email')]);
            if (is_null($user)) {
                $message = true;
            } else {
                $notification->notify($user);
                $sendMessage = true;
            }
        }
        return $this->render('user/forgetPassword.html.twig', [
            'message' => $message,
            'sendMessage' => $sendMessage
        ]);

    }

    /**
     * @Route("/backupPassword/{token}", name="backupPassword")
     * @param string $token
     */
    public function backupPassword($token, UserRepository $repository, Request $request, UserPasswordEncoderInterface $encoder)
    {
        
        $modifyPassword = false;
        $notSame = false;

        if(!is_null($request->request->get('password')) && !empty($request->request->get('password')) &&
        !is_null($request->request->get('passwordVerify')) && !empty($request->request->get('passwordVerify'))) {
            if ($request->request->get('password') == $request->request->get('passwordVerify')) {
                
                $user = $repository->findOneBy(["code_validation" => $token]);

                $password = $encoder->encodePassword($user, $request->request->get('password'));
                $user->setPassword($password);
                    $this->manager->persist($user);
                    $this->manager->flush();
                    $modifyPassword = true;
            } else {
                $modifyPassword = false;
                $notSame = true;
            }
        }

        return $this->render('user/backupPassword.html.twig', [
            'modifyPassword' => $modifyPassword,
            'notSame' => $notSame,
            'token' => $token
        ]);
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
        $result = false;

        if (!is_null($user)){
            $user->setValide(true);
            $this->manager->persist($user);
            $this->manager->flush();
            $result = true;
        }

        return $this->render('user/accountValidate.html.twig', [
            'result' => $result
        ]);
    }

    /**
     * @Route("/sendMail", name="sendMail")
     */
    public function sendMail (Request $request, UserRepository $repository, InscriptionNotification $notification){
        if (!is_null($request->request->get('email')) && !empty($request->request->get('email'))) {
            $user = $repository->findOneBy(['email' => $request->request->get('email')]);
            $result = false;
            
            if ($user->getValide() == false){
                $notification->notify($user);
                $result = true;
            }

            return $this->render('user/sendAgain.html.twig', [
                'result' => $result
            ]);
        } else {
            return $this->render('user/accountValidate.html.twig', [
                'result' => false
            ]);
        }
    }
}
