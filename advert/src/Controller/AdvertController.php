<?php

namespace App\Controller;

use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Advert;
use App\Entity\AdvertSkill;
use App\Entity\Image;
use App\Entity\Application;
use App\Form\AdvertSkillType;
use App\Form\ApplicationType;
use App\Form\AdvertType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use App\Personne\Personne as pers;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/advert", name="advert")
     */
    public function index(Request $request, AdvertRepository $advertRepository)
    {
        $adverts = $advertRepository->findAll();
        $adapter = new ArrayAdapter($adverts);

        $advertskills = new Pagerfanta( $adapter);

        $advertskills->setCurrentPage(1); // 1 by default
        $currentPage = $advertskills->getCurrentPage();

        $nbResults = $advertskills->getNbResults();
        $currentPageResults = $advertskills->getCurrentPageResults();

        if ($request->get('page')) {
            $advertskills->setCurrentPage($request->get('page'));
        }
        $img = $this->em->getRepository(Image::class)->findAll();

        return $this->render('advert/index.html.twig', [
            'advertTab' => $advertskills, 'image' => $img,
        ]);
    }

    /**
     * @Route("/advert/{id}", name="advert_details")
     */
    public function advertdetails(Advert $advert)
    {
        $advertTo = $this->em->getRepository(AdvertSkill::class)->findBy(array('Advert'=>$advert));

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

            $this->em->persist($task);
            $this->em->flush();

            return $this->redirectToRoute('advert');
        }

        return $this->render('advert/addForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/advert/remove/{id}", name="remove")
     */
    public function advertRemove(Advert $advert)
    {
        $advertTo = $this->em->getRepository(AdvertSkill::class)->findOneBy(array('Advert'=>$advert));

        $this->em->remove($advertTo);
        $this->em->flush();

        return $this->redirectToRoute("advert");
    }

    /**
     * @Route("/advert/update/{id}", name="update")
     */
    public function advertupdate(Advert $advert)
    {
        return $this->render('advert/update.html.twig', [
            'advertTo' => $advert,
        ]);
    } 

    /**
     * @Route("/advert/update/{id}/exe", name="updateExe")
     */
    public function advertupdateExe(Advert $advert, Request $request)
    {
        $form = $this->createForm(AdvertType::class , $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            
            $this->em->persist($task);
            $this->em->flush();

            return $this->redirectToRoute('advert');
        }

     //   return $this->redirectToRoute("advert");
        return $this->render('advert/updateForm.html.twig', [
            'form' => $form->createView(),
            'advertTo' => $advert
        ]);
    }

    /**
     * @Route("/advert/post/{id}", name="postulate")
     */
    public function postulateform(Advert $advert, Request $request)
    {
        $task = new Application();
        $form = $this->createForm(ApplicationType::class , $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task->setAdvert($advert);

            $this->em->persist($task);
            $this->em->flush();

            return $this->redirectToRoute('advertdetails', array('id'=> $advert->getId())) ;
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
