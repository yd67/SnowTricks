<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Triks;
use App\Form\TriksType;
use App\Repository\TriksRepository;
use App\Services\TriksFileUpload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTriksController extends AbstractController
{
    public function __construct(TriksFileUpload $upload, TriksRepository $triksRepo ,EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->upload = $upload ;
        $this->triksRepo = $triksRepo ;
    }

    /**
     * @Route("/admin/triks", name="admin_triks")
     */
    public function index(): Response
    {

        return $this->render('admin/triks/index.html.twig', [
            'controller_name' => 'AdminTriksController',
        ]);
    }

     /**
     * @Route("/admin/ajout-figures", name="admin_add_triks")
     */
    public function addTriks(Request $request,SluggerInterface $slugger): Response
    {
        $triks = new Triks ;
        $form = $this->createForm(TriksType::class,$triks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images =  $form->get('images')->getData();
           
            $slug = $slugger->slug($form->get('name')->getData());
            $triks->setSlug($slug);
            $triks->setCreator($this->getUser());

            foreach ($images as $image) {
               $img = new Image ;
               $path = $this->getParameter('triks_folder_upload');
               $img->setTriks($triks) ;
               $img->setPath($path);
               
               $fileName = $this->upload->upload($image);
               $img->setFilename($fileName);
               
               $this->em->persist($img);
            }
            $this->em->persist($triks);
            $this->em->flush();
        }

        return $this->render('admin/triks/addTriks.html.twig', [
            'controller_name' => 'ajout figures',
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/admin/modification/{slug}", name="admin_update_triks")
     */
    public function updateTriks($slug,Request $request)
    {

        $triks = $this->triksRepo->findOneBy(['slug' => $slug]) ;
        $form = $this->createForm(TriksType::class,$triks);
        $form->handleRequest($request);

        return $this->render('admin/triks/updateTriks.html.twig',[
            'triks' => $triks ,
            'form' => $form->createView()
        ]);

    }
}
