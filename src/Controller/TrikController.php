<?php

namespace App\Controller;

use App\Repository\TriksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrikController extends AbstractController
{

    public function __construct( TriksRepository $triksRepo )
    {
        $this->triksRepo = $triksRepo ;
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
    public function trikDetails($slug): Response
    {
        $trik = $this->triksRepo->findOneBy(['slug' => $slug]) ;

        return $this->render('trik/details.html.twig', [
            'controller_name' => 'TrikController',
            'trik' => $trik,
        ]);
    }
}
