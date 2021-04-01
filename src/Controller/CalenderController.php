<?php

namespace App\Controller;

use App\Repository\PlanningRepository;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalenderController extends AbstractController
{
    /**
     * @Route("/calender", name="calender")
     */
    public function index(PlanningRepository $calendar)
    {
        $events = $calendar->findAll();
        $rdvs =[];
        foreach ($events as $event){
            $rdvs[]= [
                'id' => $event->getId(),
                'start' => $event->getDateDebut()->format('Y-m-d H:i:s'),
                'end' => $event->getDateFin()->format('Y-m-d H:i:s'),
                'title' => $event->getNomP(),
                'description' => $event->getDescriptionP(),
                'renders' => $event->getRenders(),
                'personnel' => $event->getPersonnel()
            ];
        }
        $data = json_encode($rdvs);
        return $this->render('calender/index.html.twig', compact('data'));
    }
    /**
     * @Route("/calenderR", name="calenderR")
     */
    public function indexRendezvous(RendezVousRepository $calendar)
    {
        $events = $calendar->findAll();
        $rdvs =[];
        foreach ($events as $event){
            $rdvs[]= [
                'id' => $event->getId(),
                'start' => $event->getDateRDV()->format('Y-m-d H:i:s'),
                'title' => $event->getNomRDV(),
                'description' => $event->getDescription(),
                'planning' => $event->getPlannings(),
                'personnel' => $event->getUser(),
                'patient' => $event->getPatient()
            ];
        }
        $data = json_encode($rdvs);
        return $this->render('calender/indexRendezvous.html.twig', compact('data'));
    }
}
