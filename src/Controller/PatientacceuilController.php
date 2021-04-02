<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientacceuilController extends AbstractController
{
    /**
     * @Route("/patientacceuil", name="patientacceuil")
     */
    public function index(): Response
    {
        return $this->render('patientacceuil/index.html.twig', [
            'controller_name' => 'PatientacceuilController',
        ]);
    }
}
