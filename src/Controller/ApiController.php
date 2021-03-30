<?php

namespace App\Controller;


use App\Entity\Planning;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
    /**
     * @Route("/api/{id}/edit", name="api_event_edit", methods={"PUT"})
     */
  public function majEvent(?Planning $calendar,Request $request): Response
    {
        // On récupére les données
        $donnees = json_decode($request->getContent());
        if (
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->dateDebut) && !empty($donnees->dateDebut) &&
            isset($donnees->dateFin ) && !empty($donnees->dateFin) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->renders) && !empty($donnees->renders) &&
            isset($donnees->personnel) && !empty($donnees->personnel)
        ){
            //les données sont complétes
            // on initialise un code
            $code =200;
            // on verifie si l'id existe
      /*      if (!Planning){
                //on instancier un redezVous
                $calendar = new Planning;

                // On change le code
                $code =201;
            }*/
            //On hydrate l'objet avec les donnees
            $calendar->setNomP()($donnees->title);
            $calendar->setDescriptionP()($donnees->description);
            $calendar->setDateDebut(new DateTime($donnees->dateDebut));

            $calendar->setDateFin(new DateTime($donnees->dateFin));
            $calendar->setRenders($donnees->renders);
            $calendar->setPersonnel($donnees->personnel);
            $em =$this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            //On retourne un code
            return new Response('OK',$code);
        }else{
            //les donnéés sont incomplétes
            return new Response('Données incomplétes',404);
        }

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
    /**
     * @Route("/api/{id}/editR", name="api_event_editR", methods={"PUT"})
     */
    public function majEventR(?calendar $calendar,Request $request): Response
    {
        // On récupére les données
        $donnees = json_decode($request->getContent());
        if (
            isset($donnees->nomRDV) && !empty($donnees->nomRDV) &&
            isset($donnees->dateRDV) && !empty($donnees->RDV) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->plannings) && !empty($donnees->plannings) &&
            isset($donnees->user) && !empty($donnees->user) &&
            isset($donnees->patient) && !empty($donnees->patient)
        ){
            //les données sont complétes
            // on initialise un code
            $code =200;
            // on verifie si l'id existe
            if (!calendar){
                //on instancier un redezVous
                $calendar = new calendar;

                // On change le code
                $code =201;
            }
            //On hydrate l'objet avec les donnees
            $calendar->setNomRDV($donnees->nomRDV);
            $calendar->setDescription()($donnees->description);
            $calendar->setDateRDV(new DateTime($donnees->dateRDV));
            $calendar->setPlannings($donnees->plannings);
            $calendar->setUser($donnees->user);
            $calendar->setPatient($donnees->patient);
            $em =$this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            //On retourne un code
            return new Response('OK',$code);
        }else{
            //les donnéés sont incomplétes
            return new Response('Données incomplétes',404);
        }

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}
