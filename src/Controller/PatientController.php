<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Form\RechercheTypeCINType;
use App\Form\RechercherEmailType;
use App\Repository\PatientRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/patient")
 */
class PatientController extends AbstractController
{
    /**
     * @Route("/", name="patient_index", methods={"GET"})
     */
    public function index(PatientRepository $patientRepository): Response
    {


        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),


        ]);
    }
    /**
     * @Route ("/searchPatient", name="searchPatient",methods={"GET"})
     * @param Request $request
     * @param NormalizerInterface $Normalizer
     */
    public function searchPatient(Request $request,NormalizerInterface $Normalizer){

        $repository=$this->getDoctrine()->getRepository(Patient::class);
        $requestString=$request->get('searchValue');
        $patient=$repository->SearchName($requestString);
        $jsonContent= $Normalizer->normalize($patient, 'json',[
            'groups' => 'patient'
        ]);
        $retour=json_encode($jsonContent);
        return new Response($retour);
    }


    /**
     * @Route("/trierparPCIN",name="listCINTrie")
     */
    public function treePCIN(Request $request):Response
    {

        $patientCIN=$this->getDoctrine()->getRepository(Patient::class)->trieCIN();
        $form=$this->createForm(RechercheTypeCINType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $cin=$form->getData()->getCin();
            $cinResult=$this->getDoctrine()->getRepository(Patient::class)->RechercheC($data);
            return $this->render('patient/triePCIN.html.twig',
                array('patientCIN'=>$cinResult, 'form'=>$form->createView()));
        }
        return $this->render('patient/triePCIN.html.twig',
            array('patientCIN'=>$patientCIN,'form' => $form->createView()));
    }

    /**
     * @Route("/trierparEmail",name="listEmailTrie")
     */
    public function treePEmail(Request $request):Response
    {

        $patientM=$this->getDoctrine()->getRepository(Patient::class)->trieEmail();
        $form=$this->createForm(RechercherEmailType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $email=$form->getData()->getCin();
            $emailResult=$this->getDoctrine()->getRepository(Patient::class)->RechercheC($data);
            return $this->render('patient/triePemail.html.twig',
                array('patientM'=>$emailResult, 'form'=>$form->createView()));
        }
        return $this->render('patient/triePemail.html.twig',
            array('patientM'=>$patientM,'form' => $form->createView()));
    }
    /**
     * @Route("/pdf", name="pdf")
     */
    public function print(Request $request,PatientRepository $patientRepository)
    {

        $patient = $patientRepository->findAll();

// Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('patient/patient_pdf.html.twig', [
            'title' => "Welcome to our PDF Test", "patients" => $patientRepository->findAll()
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("patient_pdf.pdf", [
            "Attachment" => true
        ]);

    }
    /**
     * @Route("/new", name="patient_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patient_show", methods={"GET"})
     */
    public function show(Patient $patient): Response
    {

        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="patient_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Patient $patient): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patient_delete", methods={"DELETE"})
     */

    public function delete(Request $request, Patient $patient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('patient_index');
    }

}
