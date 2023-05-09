<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        MailerInterface $mailer
    ): Response {
        $user = new User();
        $registerForm = $this->createForm(UserType::class, $user);

        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

            $userRepository->save($user, true);

            $mail = (new TemplatedEmail())
                ->from('admin@local.test')
                ->to('mauger@cefim.eu')
                ->subject('Bienvenue ' . $user->getFirstname() . ' ' . $user->getLastname() . ' !')
                ->htmlTemplate('mail/register.html.twig')
                ->context(['user' => $user])
            ;

            $mailer->send($mail);

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('register/index.html.twig', [
            'register_form' => $registerForm->createView()
        ]);
    }
}
