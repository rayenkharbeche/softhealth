<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Form\RechercheDateType;
use App\Form\ConsultationNumType;
use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/consultation")
 */
class ConsultationController extends AbstractController
{
    /**
     * @Route("/", name="consultation_index", methods={"GET"})
     */
    public function index(ConsultationRepository $consultationRepository): Response
    {
        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/trierparDate",name="listDateTrie")
     */
    public function treeCDate(Request $request):Response
    {

        $consultationD=$this->getDoctrine()->getRepository(Consultation::class)->trieDate();
        $form=$this->createForm(RechercheDateType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $dateC=$form->getData()->getDateC();
            $dateResult=$this->getDoctrine()->getRepository(Consultation::class)->RechercheC($data);
            return $this->render('consultation/trieCDate.html.twig',
                array('consultationD'=>$dateResult, 'form'=>$form->createView()));
        }
        return $this->render('consultation/trieCDate.html.twig',
            array('consultationD'=>$consultationD,'form' => $form->createView()));
    }

    /**
     * @Route("/trierparNum",name="listNumTrie")
     */
    public function treeCNum(Request $request):Response
    {

        $consultationN=$this->getDoctrine()->getRepository(Consultation::class)->trieNum();
        $form=$this->createForm(ConsultationNumType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $numC=$form->getData()->getNumC();
            $numCResult=$this->getDoctrine()->getRepository(Consultation::class)->RechercheN($data);
            return $this->render('consultation/trieCnum.html.twig',
                array('consultationN'=>$numCResult, 'form'=>$form->createView()));

        }
        return $this->render('consultation/trieCnum.html.twig',
            array('consultationN'=>$consultationN,'form' => $form->createView()));
    }
   // /**
    // * @Route("/recherche", name="recherhce")
     //*/
    /*public function recherche(Request $request){
        $search =$request->query->get('consultation');
        $repo = $this->getDoctrine()->getRepository(Consultation::class);

        $consultation = $repo->findMulti($search);

        return $this->render('consultation/recherche.html.twig',
            ["consultation" => $consultation]);




    }*/
    /**
     * @Route("/pdf", name="pdf")
     */
    public function print(Request $request,ConsultationRepository $consultationRepository)
    {

        $consultation = $consultationRepository->findAll();

// Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('consultation/mypdf.html.twig', [
            'title' => "Welcome to our PDF Test", "consultation" => $consultation
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);

    }
    /**
     * @Route("/new", name="consultation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('consultation_index');
        }

        return $this->render('consultation/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consultation_show", methods={"GET"})
     */
    public function show(Consultation $consultation): Response
    {
        return $this->render('consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }
    



    /**
     * @Route("/{id}/edit", name="consultation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Consultation $consultation): Response
    {
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('consultation_index');
        }

        return $this->render('consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);
    }

    ///**
     //* @Route("/{id}", name="consultation_delete", methods={"DELETE"})
     //*/

   /* public function delete(Request $request, Consultation $consultation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($consultation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('consultation_index');
    }*/
    /**
     * @Route("/consultation_delete/{id}", name="consultation_delete")
     */
    public function consultation_delete($id)
    {
        $consultation = $this->getDoctrine()->getRepository(Consultation::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($consultation);
        $em->flush();
        return $this->redirectToRoute("consultation_index");
    }




}
