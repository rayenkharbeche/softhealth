<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PatiController extends AbstractController
{
    /**
     * @Route("/pati", name="pati")
     */
    public function index(): Response
    {
        return $this->render('/frontP.html.twig', [
            'controller_name' => 'PatiController',
        ]);
    }
}
