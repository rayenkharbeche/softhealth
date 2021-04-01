<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PharController extends AbstractController
{
    /**
     * @Route("/phar", name="phar")
     */
    public function index(): Response
    {
        return $this->render('phar/index.html.twig', [
            'controller_name' => 'PharController',
        ]);
    }
}
