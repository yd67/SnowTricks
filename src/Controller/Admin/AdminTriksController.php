<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Triks;
use App\Form\TriksType;
use App\Repository\ImageRepository;
use App\Repository\TriksRepository;
use App\Repository\VideoRepository;
use App\Services\TriksFileUpload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTriksController extends AbstractController
{
    public function __construct(TriksFileUpload $upload,TriksRepository $triksRepo ,EntityManagerInterface $entityManager)
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

            $images =  $form->get('image')->getData();
            foreach ($images as $image) {
                $file = $image->getFile();
                $filename = $this->upload->upload($file) ;
                $image->setFilename($filename);
            }
            $slug = $slugger->slug($form->get('name')->getData());
            $triks->setSlug($slug);
            $triks->setCreator($this->getUser());

            $this->em->persist($triks);
            $this->em->flush();

            $this->addFlash(
                'success',
                'la figure a bien été créer '
            );
            return $this->redirectToRoute('app_home') ;
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

        $trik = $this->triksRepo->findOneBy(['slug' => $slug]) ;
        $form = $this->createForm(TriksType::class,$trik);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {
            $images =  $form->get('image')->getData();  

            foreach ($images as $image) {
                $file = $image->getFile();
                if (!empty($file)) {
                    
                    // delete old image 
                    $this->upload->remove($image->getFilename());

                    $filename = $this->upload->upload($file) ;
                    $image->setFilename($filename);
                }
            }
            $this->em->persist($trik);
            $this->em->flush();

            $this->addFlash(
                'success',
                'modification réussi'
            );
             return $this->redirectToRoute('app_trik_detail',['slug' => $trik->getSlug()]);
        }

        return $this->render('admin/triks/updateTriks.html.twig',[
            'trik' => $trik ,
            'form' => $form->createView()
        ]);

    }

     /**
     * @Route("/admin/triks-{id}/delete/", name="delete_trik")
     */
    public function deleteTrik($id)
    {
        $triks = $this->triksRepo->findOneBy(['id' => $id]) ;

        if (!empty($triks)) {

            $images = $triks->getImage() ;
            foreach ($images as $image) {
                $this->upload->remove($image->getFilename()) ;
            }

            $this->em->remove($triks) ;
            $this->em->flush();


            $this->addFlash(
                'success',
                'la figure a bien été supprimer'
            );
        }
        return $this->redirectToRoute('app_home') ;
    }


     /**
     * @Route("/admin/delete/image-{id}/{slug}", name="delete_trik_image")
     */
    public function deleteTriksImage($id,$slug,ImageRepository $imageRepo )
    {
        $image = $imageRepo->findOneBy(['id' => $id ,]) ;
        if (!empty($image)) {

            $this->upload->remove($image->getFilename());

            $this->em->remove($image);
            $this->em->flush();

            $this->addFlash(
                'success',
                'l`\'image a bien été supprimer'
            );
        }
        return $this->redirectToRoute('admin_update_triks',['slug'=> $slug ]) ;
    }

     /**
     * @Route("/admin/delete/video-{id}/{slug}", name="delete_trik_video")
     */
    public function deleteTriksVideo($id,$slug,VideoRepository $videoRepo)
    {
        $video = $videoRepo->findOneBy(['id' => $id ,]) ;
        if (!empty($video)) {

            $this->em->remove($video);
            $this->em->flush();

            $this->addFlash(
                'success',
                'la video a bien été supprimer'
            );
        }
        return $this->redirectToRoute('admin_update_triks',['slug'=> $slug ]) ;
    }
}
