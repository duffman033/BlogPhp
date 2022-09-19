<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Respository\UserRespository;

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
        $listUser = $this->app->get(UserRespository::class)->getUsers();
        $this->renderer->render('Admin/userView.html.twig', ['users' => $listUser]);
    }

    /**
     * Delete a User from ID using comment manager
     *
     * @param $userId
     */
    public function deleteUser($userId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == self::$session->get('token')) {
            $deleteRequest = $this->app->get(UserRespository::class)->deleteUser($userId);
            if ($deleteRequest === false) {
                self::$session->set('warning', "Impossible de supprimer l'utilisateur !");
                return;
            }
            self::$session->set('success', "L'utilisateur a bien été supprimé.");
            $this->listUser();
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }
}
