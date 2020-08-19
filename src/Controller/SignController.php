<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SignController extends AbstractController
{
    /**
     * @Route("/signin", name="sign_in")
     */
    public function signIn()
    {
        return $this->render('sign/signin.html.twig', [
            'controller_name' => 'SignController',
        ]);
    }
}
