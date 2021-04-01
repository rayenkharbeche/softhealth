<?php

namespace App\Controller;
use App\Entity\Reclamation;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ReclamationType;

class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => 'ReclamationController',
        ]);
    }

    /**
     * @Route("/listReclamation", name="listReclamation")
     */
    public function listReclamation()
    {
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        return $this->render('reclamation/list.html.twig', array("reclamations" => $reclamations));
    }


    /**
     * @Route("/delete/{id}", name="deleteReclamation")
     */
    public function deleteReclamation($id)
    {
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reclamations);
        $em->flush();
        return $this->redirectToRoute("listReclamation");
    }


    /**
     * @Route("/addReclamation", name="addReclamation")
     */
    public function addReclamation(Request $request)
    {
        $reclamation = new Reclamation();


        $reclamation->setCreatedAt(new \Datetime('now'));
       // die(var_dump(new \Datetime('now')));
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('listReclamation');
        }
        return $this->render("reclamation/add.html.twig",array('form'=>$form->createView()));
    }
     /**
     * @Route("/listReclamationP", name="listReclamationP")
     */
    public function listReclamationP()
    {
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        return $this->render('frontP/listP.html.twig', array("reclamations" => $reclamations));
    }

     /**
     * @Route("/addReclamationP", name="addReclamationP")
     */
    public function addReclamationP(Request $request)
    {
        $reclamation = new Reclamation();


        $reclamation->setCreatedAt(new \Datetime('now'));
       // die(var_dump(new \Datetime('now')));
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('listReclamationP');
        }
        return $this->render("frontP/addreclamation.html.twig",array('form'=>$form->createView()));
    }

     
    /**
     * @Route("/update/{id}", name="updateReclamation")
     */
    public function updateReclamation(Request $request,$id)
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listReclamation');
        }
        return $this->render("reclamation/update.html.twig",array('form'=>$form->createView()));
    }








}
