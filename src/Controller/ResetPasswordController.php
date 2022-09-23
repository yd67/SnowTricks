<?php

namespace App\Controller;

use App\Services\Mailer;
use App\Form\NewPasswordType;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ResetPasswordController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepo, TokenGeneratorInterface $token)
    {
        $this->em = $entityManager;
        $this->userRepo = $userRepo;
        $this->token = $token;
    }

    /**
     * @Route("/reset/password", name="app_reset_password")
     */
    public function forgotPassword(Request $request, Mailer $mailer): Response
    {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $this->userRepo->findOneBy(['email' => $email]);

            if (!empty($user)) {
                $token = $this->token->generateToken();
                $user->setToken($token);

                $this->em->persist($user);
                $this->em->flush();

                $url = $this->generateUrl('app_new_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                $mailer->sendResetPass($email, $url);

                $this->addFlash(
                    'warning',
                    'si votre compte existe, un email de réinitialisation de mot de passe vous a été envoyé'
                );
            }
            // return $this->redirectToRoute('app_reset_password') ;

        }

        return $this->render('reset_password/forgotPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/new/password-{token}", name="app_new_password")
     */
    public function newPassword($token, Request $request, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = $this->userRepo->findOneBy(['token' => $token]);
        if (empty($user)) {
            return $this->redirectToRoute('app_reset_password');
        }

        $form = $this->createForm(NewPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setToken(null);

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash(
                'success',
                'le mot de passe a bien été changé '
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/newPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
