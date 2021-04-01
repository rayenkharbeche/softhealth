<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Form\RechercheTypeMail;
use App\Form\RechercheTypeNom;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * @Route("/users")
 */
class UsersController extends AbstractController
{
    /**

     * @Route("/", name="users_index", methods={"GET"})
     */
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/trierparN",name="listUsersTrieCIN")
     */
    public function treeN(Request $request):Response
    {

        $userN=$this->getDoctrine()->getRepository(Users::class)->trie();
        $form=$this->createForm(RechercheTypeNom::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $username=$form->getData()->getCin();
            $usernameResult=$this->getDoctrine()->getRepository(Users::class)->RechercheC($data);
            return $this->render('users/listUsersTrieNom.html.twig',
            array('userN'=>$usernameResult, 'form'=>$form->createView()));
        }
        return $this->render('users/listUsersTrieNom.html.twig',
        array('userN'=>$userN,'form' => $form->createView()));
    }
    /**
     * @Route("/trie" , name="liste_User_Tree")
     */
    public function Tree(Request $request):Response
    {
       $userM=$this->getDoctrine()->getRepository(Users::class)->ListeUparMail();
       $form=$this->createForm(RechercheTypeMail::class);
       $form->handleRequest($request);
       if($form->isSubmitted()){
           $mail=$form->getData()->getEmail();
           $MailResult=$this->getDoctrine()->getRepository(Users::class)->Recherche($data);
           return $this->render("users/rechercheOrderBy.html.twig" , 
           array('userM' => $MailResult , 'form' =>$form->createView()));
       }
       return $this->render("users/rechercheOrderBy.html.twig" ,
       array('userM' => $userM , 'form' =>$form->createView()));
    }


     
    /**
     * @Route("/pdf", name="pdf")
     */
    public function print(Request $request,UsersRepository $repository)
    {

        $User = $repository->findAll();

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('users/mypdf.html.twig', [
            'title' => "Welcome to our PDF Test", "users" => $User
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

     * @Route("/new", name="users_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('users_index');
        }

        return $this->render('users/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="users_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="users_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Users $user): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_index');
        }

        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="users_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Users $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('users_index');
    }

    /**
     * @Route("/trie",name="listUsersTrie")
     */
    public function trie(Request $request)
    {

        $user=$this->getDoctrine()->getRepository(Users::class)->trie();
        $form=$this->createForm(RechercheType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $cin=$form->getData()->getCin();
            $userResult=$this->getDoctrine()->getRepository(Users::class)->recherche($cin);
            return $this->render('users/listUsersTrie.html.twig',array('user'=>$userResult,
                'formUserT'=>$form->createView()));
        }
        return $this->render('Users/listUsersTrie.html.twig',array('user'=>$user,
            'formUserT'=>$form->createView()));
    }

    
    
 
    /**
     * @Route("/rechercheUCin",name="recherche")
     */
    function RechercheC(UsersRepository $repository,Request $request)
    {
        $data=$request->get('search ');
        $User=$repository->findBy(['cin'=>$data]);
        return $this->render('users/index.html.twig',['User'=>$User]);
    }

    

    
    
}
