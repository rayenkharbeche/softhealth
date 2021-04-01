<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



class SecController extends AbstractController
{
    /**
     * @Route("/sec", name="sec")
     */
    public function index(): Response
    {
        return $this->render('/frontSec.html.twig', [
            'controller_name' => 'SecController',
        ]);
    }
}
