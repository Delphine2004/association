<?php

namespace App\Security;

use App\Enum\UserRole;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Routing\RouterInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(private RouterInterface $router) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $roles = $token->getRoleNames();

        if (in_array(UserRole::ADMIN->value, $roles, true)) {
            // Redirection pour l’admin
            return new RedirectResponse($this->router->generate('admin_dashboard'));
        }

        if (in_array(UserRole::EMPLOYE->value, $roles, true)) {
            // Redirection pour l’admin
            return new RedirectResponse($this->router->generate('employee_dashboard'));
        }

        // Redirection par défaut si pas de rôle
        return new RedirectResponse($this->router->generate('home'));
    }
}
