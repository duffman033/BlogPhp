<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;


/**
 * Class AdminController controller for Admin
 */
class UserController extends AdminController
{
    /**
     * Render the User view from the post manager
     */
    public function listUser()
    {
        $list_user = $this->userManager->getUsers();
        $this->renderer->render('Admin/userView.html.twig', ['users' => $list_user]);
    }

    /**
     * Delete a User from ID using comment manager
     *
     * @param $userId
     */
    public function deleteUser($userId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            $deleteRequest = $this->userManager->deleteUser($userId);
            if ($deleteRequest === false) {
                $this->session->set('warning', "Impossible de supprimer l'utilisateur !");
                return;
            }
            $this->session->set('success', "L'utilisateur a bien été supprimé.");
            $this->listUser();
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        FrontController::deconnect();
    }
}