<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Entity\RendezVous;
use App\Form\PlanningType;
use App\Form\RechercheRDVType;
use App\Form\RendezVousType;
use App\Repository\PlanningRepository;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/rendez/vous")
 */
class RendezVousController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="rendez_vous_index", methods={"GET"})
     */
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findAll(),
        ]);
    }
    /**
     * @Route ("/searchRDV", name="searchRDV",methods={"GET"})
     */
    public function searchRDV(Request $request,NormalizableInterface $Normalizable){
        //  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        //  $this->denyAccessUnlessGranted('ROLE_SECRETARY');
        //  $this->denyAccessUnlessGranted('ROLE_DOCTOR');
        //  $this->denyAccessUnlessGranted('ROLE_PATIENT');
        $repository=$this->getDoctrine()->getRepository(RendezVous::class);
        $requestString=$request->get('seaValue');
        $rendez_vouses=$repository->SearchName($requestString);
        $jsonContent= $Normalizable->normalize($rendez_vouses, 'json',[
            'groups' => 'rendez_vouses'
        ]);
        $retour=json_encode($jsonContent);
        return new Response($retour);
    }

    /**
     * @param Request $request
     * @param NormalizableInterface $Normalizable
     * @return Response
     * @Route("/allRDV", name ="allRDS", methods={"GET"})
     */
    public function allRDV(Request $request, NormalizableInterface $Normalizable): Response
    {
        $repository= $this->getDoctrine()->getRepository(RendezVous::class);
        $rendezvous =$repository->findAll();
        $jsonContent = $Normalizable->normalize($rendezvous,'json',['groups'=>'post:read']);
        return $this->render('rendez_vous/allRDV.html.twig',[
            'date'=>$jsonContent,
        ]);

    }

    /**
     * @IsGranted("Admin")
     * @Route("/c", name="rendez_vous_c", methods={"GET"})
     */
    public function indexC(RendezVousRepository $calendar): Response
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
        return $this->render('rendez_vous/indexC.html.twig', compact('data'));
    }

    /**
     * @Route("/new", name="rendez_vous_new", methods={"GET","POST"})
     * @throws \Symfony\Component\Form\Exception\RuntimeException
     */
    public function new(Request $request,RendezVousRepository $rendezVousRepository,PlanningRepository $planningRepository): Response
    {
        //  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        //  $this->denyAccessUnlessGranted('ROLE_SECRETARY');
        //  $this->denyAccessUnlessGranted('ROLE_DOCTOR');
        //  $this->denyAccessUnlessGranted('ROLE_PATIENT');
        $rendezVou = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);
        $user=$form->getData()->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rendezVou);
            $idP = $rendezVousRepository->findPlannigsByUser($user);
            foreach ($idP as $idPs){
                $Planning=$planningRepository->FindByID($idPs);


                foreach ($Planning as $planning){
                $planning->addRenders($rendezVou);
                //console.log("existe pas");
                }
                $entityManager->flush();



            }


            return $this->redirectToRoute('rendez_vous_index');
        }

        return $this->render('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @IsGranted("Admin")
     * @Route("/trie", name="rendez_vous_Tree")
     */
    public function Tree(Request $request): Response
    {
        $RDV=$this->getDoctrine()->getRepository(RendezVous::class)->ListRendezVousOrderByDATE();
        $form=$this->createForm(RechercheRDVType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $date=$form->getData()->getDateRDV();
            $RDVResult=$this->getDoctrine()->getRepository(RendezVous::class)->Recherche($date);
            return $this->render("rendez_vous/rechercheOrederBy.html.twig",
                array('rendez_vouses'=>$RDVResult,'form'=>$form->createView()));
        }
        return $this->render("rendez_vous/rechercheOrederBy.html.twig",
            array('rendez_vouses'=>$RDV,'form'=>$form->createView()));
    }

    /**
     * @Route("/{id}", name="rendez_vous_show", methods={"GET"})
     */
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rendez_vous_edit", methods={"GET","POST","PUT"})
     */
    public function edit(Request $request, RendezVous $rendezVou): Response
    {
        //  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        //  $this->denyAccessUnlessGranted('ROLE_SECRETARY');
        //  $this->denyAccessUnlessGranted('ROLE_DOCTOR');
        //  $this->denyAccessUnlessGranted('ROLE_PATIENT');
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rendez_vous_index');
        }

        return $this->render('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="rendez_vous_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RendezVous $rendezVou): Response
    {
        //  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        //  $this->denyAccessUnlessGranted('ROLE_SECRETARY');
        //  $this->denyAccessUnlessGranted('ROLE_DOCTOR');
        //  $this->denyAccessUnlessGranted('ROLE_PATIENT');
        if ($this->isCsrfTokenValid('delete'.$rendezVou->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rendez_vous_index');
    }


}

