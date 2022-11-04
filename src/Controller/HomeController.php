<?php

namespace App\Controller;

use App\Repository\TriksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(TriksRepository $triksRepo): Response
    {
        $triks = $triksRepo->findBy([],['createdAt'=> 'DESC']) ;

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'triks' => $triks
        ]);
    }
}
