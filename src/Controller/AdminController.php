<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/admin")
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/commandes", name="commandes")
     */
    public function commandes()
    {
        // return $this->render('admin/index.html.twig', [
        //     'controller_name' => 'AdminController',
        // ]);
    }

    /**
     * @Route("/achats", name="achats")
     */
    public function achats()
    {
        return $this->render('admin/achats.html.twig');
    }
}
