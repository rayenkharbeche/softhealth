<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RechercheRDVType;
use App\Repository\PlanningRepository;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionPRDVController extends AbstractController
{
    /**
     * @Route("/gestion/planning", name="gestion_planning")
     */
    public function indexPlanning(PlanningRepository $planningRepository): Response
    {
        $user = $this->getUser()->getEmail();
        $plannings= $planningRepository->findPlanning($user);
        /*  $resulth=[];
            foreach ($planning as $planning) {
                $resulth[] = $planning;
            }
            foreach ($renders as $renders) {
                $resulth[] = $renders;
            }*/
        return $this->render('gestion_prdv/indexP.html.twig', [
            'plannings' => $plannings ,
        ]);
    }

    /**
     * @Route("/gestion/renders", name="gestion_renders")
     */
    public function indexRenders(PlanningRepository $planningRepository,RendezVousRepository $rendezVousRepository): Response
    {
        $user = $this->getUser()->getEmail();
        $renders=$rendezVousRepository->findRenders($user);

        return $this->render('gestion_prdv/indexR.html.twig', [
            'rendez_vouses' => $renders ,
        ]);
    }

    /**
     * @Route("/gestion/cr", name="gestion_cr", methods={"GET"})
     */
    public function indexCR(RendezVousRepository $calendar): Response
    {
        $user = $this->getUser()->getEmail();
        $events=$calendar->findRenders($user);
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
        return $this->render('gestion_prdv/indexCR.html.twig', compact('data'));
    }

    /**
     * @Route("/gestion/cp", name="gestion_cp", methods={"GET"})
     */

    public function indexCP(PlanningRepository $calendar)
    {
        $user = $this->getUser()->getEmail();
        $events = $calendar->findPlanning($user);
        $rdvs =[];
        foreach ($events as $event){
            $event2= $calendar->FindRendersByID($event->getId());
            $rdvs[]= [
                'id' => $event->getId(),
                'start' => $event->getDateDebut()->format('Y-m-d H:i:s'),
                'end' => $event->getDateFin()->format('Y-m-d H:i:s'),
                'title' => $event->getNomP(),
                'description' => $event->getDescriptionP(),
                'backgroundColor' => $event2,
                'textColor' => $event->getPersonnel()
            ];
        }
        $data = json_encode($rdvs);
        return $this->render('gestion_prdv/indexCP.html.twig', compact('data'));
    }
    /**
     * @Route("/gestion/trie", name="gestion_tree")
     */
    public function GestionTree(Request $request,RendezVousRepository $rendezVousRepository): Response
    {
        $user = $this->getUser()->getEmail();
        $events = $rendezVousRepository->findPlanning($user);
        $RDV=$this->getDoctrine()->getRepository(RendezVous::class)->ListRendezVousOrderByDATE();
        $form=$this->createForm(RechercheRDVType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $date=$form->getData()->getDateRDV();
            $RDVResult=$this->getDoctrine()->getRepository(RendezVous::class)->Recherche($date);
            return $this->render("rendez_vous/rechercheOrederBy.html.twig",
                array('rendez_vouses'=>$RDVResult,'form'=>$form->createView()));
        }
        return $this->render("gestion_prdv/treeRDV.html.twig",
            array('rendez_vouses'=>$RDV,'form'=>$form->createView()));
    }
}