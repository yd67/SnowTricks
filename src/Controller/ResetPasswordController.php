<?php

namespace App\Controller;

use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ResetPasswordController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager,UserRepository $userRepo,TokenGeneratorInterface $token)
    {
        $this->em = $entityManager;
        $this->userRepo = $userRepo ;
        $this->token = $token ;
        
    }

    /**
     * @Route("/reset/password", name="app_reset_password")
     */
    public function forgotPassword(Request $request): Response
    {
        $form = $this->createForm(ForgotPasswordType::class) ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $this->userRepo->findOneBy(['email' => $email]) ;

            if (!empty($user)) {
                $token = $this->token->generateToken() ;
                $user->setToken($token) ;
                 dd($user);

                // $this->em->persist($user);
                // $this->em->flush() ;

                // envoie de mail 

            }

        }
        
        $this->addFlash(
            'warning',
            'si votre compte existe, un email de réinitialisation de mot de passe mot vous a été envoyé'
        );

        return $this->render('reset_password/forgotPassword.html.twig', [
            'form' => $form->createView() ,
        ]);
    }
}
