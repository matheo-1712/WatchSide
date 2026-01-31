<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();

        // Store referer/redirect_to if it's a new visit (GET)
        if ($request->isMethod('GET')) {
            $targetPath = $request->query->get('redirect_to');

            if (!$targetPath) {
                $referer = $request->headers->get('referer');
                if ($referer && !str_contains($referer, '/login') && !str_contains($referer, '/register')) {
                    $targetPath = $referer;
                }
            }

            if ($targetPath) {
                $session->set('_registration_target_path', $targetPath);
            }
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setMot_de_passe($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            // Redirect to stored target path if it exists
            if ($targetPath = $session->get('_registration_target_path')) {
                $session->remove('_registration_target_path');
                return $this->redirect($targetPath);
            }

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
