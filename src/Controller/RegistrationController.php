<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\Mailer;
use App\Services\UserFileUpload;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager ;

     /** @var TokenGeneratorInterface */
     private $tokenGenerator;
    
    public function __construct(EntityManagerInterface $entityManager,TokenGeneratorInterface $token)
    {
        $this->entityManager = $entityManager;
        $this->tokenGenerator = $token;

    }

    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(Request $request,UserFileUpload $upload ,UserPasswordHasherInterface $userPasswordHasher,Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setAvatar('default.jpg');
            $file = $form->get('avatar')->getData() ;
            if ($file) {
                $filename = $upload->upload($file) ;
                $user->setAvatar($filename) ;
            }
            
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // generate token
            $token = $this->tokenGenerator->generateToken();
            $user->setToken($token);
            $user->setIsVerified(false);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // send email for verif email
            $url = $this->generateUrl('app_confirm_email', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
            $mailer->sendVerifEmail($form->get('email')->getData(), $url);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

     /**
     * @Route("/inscription/valider-compte/{token}", name="app_confirm_email")
     */
    public function confirmEmail($token,UserRepository $repoUser)
    {
        $user = $repoUser->findOneBy(['token' => $token ]) ;

        if (!empty($user)) {
            $user->setIsVerified(true);
            $user->setToken(null);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été valider'
            );
        }
        return $this->redirectToRoute('app_home');
    }
}
