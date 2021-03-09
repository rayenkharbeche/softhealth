<?php

namespace App\Controller;
use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Form\RechercheType;

use App\Repository\ChambreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;





class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre")
     */

    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
        ]);
    }




    /**
     * @Route("/remove/{num}", name="remove_chambre")
     */

    public function remove($num){
        $chambre=$this->getDoctrine()->getRepository(Chambre::class)->find($num);

        $em=$this->getDoctrine()->getManager();
        $em->remove($chambre);

        $em->flush();
        return $this->redirectToRoute('chambre_show');

    }
    /**
     *@param Request $request
     *@return \Symfony\Component\HttpFoundation\Response
     * @Route("/for", name="for")
     */


        /**
         * @Route("/listchambre", name="chambre_show")
         */
        public function listchambre()
    {
        $chambres=$this->getDoctrine()->getRepository(chambre::class)->findAll();
        return $this->render("chambre/show.html.twig",array("chambres"=>$chambres));

    }

    /**
     * @Route("/chambre/new", name="chambre_create")
     */
    public function create (Request $request){
            $chambre=new chambre();
        $form=$this->createForm(ChambreType::class,$chambre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($chambre);
            $em->flush();
            return $this->redirectToRoute("chambre_show");
        }
        return $this->render('chambre/create.html.twig' , ['formChambre' =>$form->createView()]);
    }
    /**
     * @Route("/chambre/{num}/edit", name="edit_chambre")
     */
    function Update(ChambreRepository  $repository, $num,Request $request)
    {
        $chambre = $repository->find($num);
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chambre);
            $em->flush();

            return $this->redirectToRoute("chambre_show");


        }
        return $this->render('chambre/Updatechambre.html.twig', ['fChambre' => $form->createView()]);}

    /**
     * @Route("/trie",name="listChambreOrderBy")
     */
    public function trie(Request $request){

        $chambre=$this->getDoctrine()->getRepository(Chambre::class)->trie();
        $form=$this->createForm(RechercheType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $num=$form->getData()->getNum();
            $chambreResult=$this->getDoctrine()->getRepository(Chambre::class)->recherche($num);
            return $this->render('chambre/listChambreOrderBy.html.twig',array('chambre'=>$chambreResult,
                'formChambre'=>$form->createView()));
        }
        return $this->render('chambre/show.html.twig',array('chambre'=>$chambre,
            'formChambre'=>$form->createView()));
    }

}
