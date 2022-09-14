<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\TriksRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrikController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager,TriksRepository $triksRepo,CommentsRepository $commentsRepo )
    {
        $this->em = $entityManager;
        $this->triksRepo = $triksRepo ;
        $this->commentsRepo  = $commentsRepo ;
    }

    /**
     * @Route("/trik", name="app_trik")
     */
    public function index(): Response
    {
        return $this->render('trik/index.html.twig', [
            'controller_name' => 'TrikController',
        ]);
    }

     /**
     * @Route("/figures/-{slug}", name="app_trik_detail")
     */
    public function trikDetails($slug,Request $request): Response
    {
        $trik = $this->triksRepo->findOneBy(['slug' => $slug]) ;

        $comment = new Comments ;
        $commentForm = $this->createForm(CommentsType::class,$comment) ;
        $commentForm->handleRequest($request) ;

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $user = $this->getUser() ;
            $comment->setCreator($user);
            $comment->setTriks($trik);
            
            $parentField = $commentForm->get('parent')->getData() ;
            if ($parentField != null) {
                $parentComment = $this->commentsRepo->findOneBy(['id' => $parentField]) ;
                $comment->setParent($parentComment) ;
            }

            $this->em->persist($comment) ;
            $this->em->flush() ;

            $this->addFlash(
                'success',
                'envoie de message reuissi '
            );

            return $this->redirectToRoute('app_trik_detail',['slug'=> $slug ]) ;
        }

        return $this->render('trik/details.html.twig', [
            'trik' => $trik,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
