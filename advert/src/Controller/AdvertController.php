<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Advert;
use App\Entity\AdvertSkill;
use App\Entity\Image;
use App\Entity\Application;
use App\Entity\User;
use App\Form\AdvertSkillType;
use App\Form\ApplicationType;
use App\Form\AdvertType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use App\Personne\Personne as pers;
use App\Entity\Personne;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends AbstractController
{

    /**
     * @Route("/advert", name="advert")
     */
    public function index()
    {
    	$em = $this->getDoctrine()->getManager(); 
        $advert = $em->getRepository(Advert::class)->findAll();
        $adapter = new ArrayAdapter($advert);

        $advertskills = new Pagerfanta( $adapter);


        $advertskills->setCurrentPage(1); // 1 by default
        $currentPage = $advertskills->getCurrentPage();

        $nbResults = $advertskills->getNbResults();
        $currentPageResults = $advertskills->getCurrentPageResults();

        if (isset($_GET["page"])) {
            $advertskills->setCurrentPage($_GET["page"]);
        }
        $img = $em->getRepository(Image::class)->findAll();
        return $this->render('advert/index.html.twig', [
            'advertTab' => $advertskills, 'image' => $img,
        ]);
    }

    /**
     * @Route("/advert/{id}", name="advertdetails")
     */
    public function advertdetails($id)
    {

        $em = $this->getDoctrine()->getManager(); 

        $advert = $em->getRepository(Advert::class)->find($id);
        $advertTo = $em->getRepository(AdvertSkill::class)->findBy(array('Advert'=>$advert));
        return $this->render('advert/advertdetails.html.twig', [
            'advertTo' => $advertTo,
        ]);
    }

    /**
     * @Route("/advertAdd/add", name="advertAdd")
     */
    public function advertAdd(Request $request)
    {
        $task = new AdvertSkill();


        $form = $this->createForm(AdvertSkillType::class , $task);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('advert');
        }

        return $this->render('advert/addForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/advert/remove/{id}", name="remove")
     */
    public function advertRemove($id)
    {          
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository(Advert::class)->find($id);
        $advertTo = $em->getRepository(AdvertSkill::class)->findOneBy(array('Advert'=>$advert));

        $em->remove($advertTo);
        $em->flush();

        return $this->redirectToRoute("advert");
    }

    /**
     * @Route("/advert/update/{id}", name="update")
     */
    public function advertupdate($id)
    {          
        $em = $this->getDoctrine()->getManager();
        $advertTo = $em->getRepository(Advert::class)->find($id);

        return $this->render('advert/update.html.twig', [
            'advertTo' => $advertTo,
        ]);
    } 

    /**
     * @Route("/advert/update/{id}/exe", name="updateExe")
     */
    public function advertupdateExe($id, Request $request)
    {   
    	

        $entityManager = $this->getDoctrine()->getManager();

        $task = $entityManager->getRepository(Advert::class)->find($id);

        $form = $this->createForm(AdvertType::class , $task);
        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('advert');
        }

     //   return $this->redirectToRoute("advert");
        return $this->render('advert/updateForm.html.twig', ['form'=>$form->createView(),'advertTo'=>$task
          
    ]);
    }

    /**
     * @Route("/advert/post/{id}", name="postulate")
     */
    public function postulateform($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = new Application();
        $advert = $entityManager->getRepository(Advert::class)->find($id);
        $form = $this->createForm(ApplicationType::class , $task);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $task->setAdvert($advert);
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('advertdetails', array('id'=> $id)) ;
        }

        return $this->render('advert/addForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/sendmail", name="sendmail")
     */
    public function send(pers $personne)
    {   
        $sendmail = $personne->mailsend();
        return new Response($sendmail);
    }
    
}
