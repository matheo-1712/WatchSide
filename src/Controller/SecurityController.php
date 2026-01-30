<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    use \Symfony\Component\Security\Http\Util\TargetPathTrait;

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        // Save the referer as the target path if not already set
        $session = $request->getSession();
        $firewallName = 'main'; // Adjust this if your firewall name is different in security.yaml

        if (!$this->getTargetPath($session, $firewallName)) {
            $referer = $request->headers->get('referer');
            if ($referer && !str_contains($referer, '/login') && !str_contains($referer, '/register')) {
                $this->saveTargetPath($session, $firewallName, $referer);
            }
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
