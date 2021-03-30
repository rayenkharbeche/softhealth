<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Form\PlanningType;
use App\Repository\PlanningRepository;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/planning")
 */
class PlanningController extends AbstractController
{
    /**
     * @Route("/", name="planning_index", methods={"GET"})
     */

    public function index(PlanningRepository $calendar)
    {
        $events = $calendar->findAll();
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
        return $this->render('planning/index.html.twig', compact('data'));
    }
    /**
     * @Route("/planning/Admin", name="planning_admin", methods={"GET"})
     */
    public function indexAdmin(PlanningRepository $planningRepository): Response
    {
        $planning =$planningRepository->findAll();
        $event2=[];
        foreach ($planning as $event){
            $event2[]= $planningRepository->FindRendersByID($event->getId());
        }

        return $this->render('planning/indexC.html.twig', [
            'plannings' => $planningRepository->findAll(),
            'event' => $event2,
        ]);
    }

    /**
     * @Route("/new", name="planning_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
      //  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($planning);
            $entityManager->flush();

            return $this->redirectToRoute('planning_admin');
        }

        return $this->render('planning/new.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="planning_show", methods={"GET"})
     */
    public function show(Planning $planning): Response
    {
        return $this->render('planning/show.html.twig', [
            'planning' => $planning,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="planning_edit", methods={"GET","POST","PUT"})
     */
    public function edit(Request $request, Planning $planning): Response
    {
        //  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planning_admin');
        }

        return $this->render('planning/edit.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="planning_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Planning $planning): Response
    {
        //  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$planning->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($planning);
            $entityManager->flush();
        }

        return $this->redirectToRoute('planning_admin');
    }
    
}
