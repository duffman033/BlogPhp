<?php

namespace App\Controller;

use App\Respository\CommentRespository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CommentController controller for Comments
 */
class CommentController extends AdminController
{
    /**
     * Render the Comments view from the comment manager
     */
    public function listComments()
    {
        $comments = $this->app->get(CommentRespository::class)->getInvalidComments();
        $this->renderer->render('Admin/commentView.html.twig', ['listcomments' => $comments]);
    }

    /**
     * Delete a Comment from ID using comment manager
     *
     * @param $commentId
     */
    public function deletecomment($commentId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == self::$session->get('token')) {
            $deleteRequest = $this->app->get(CommentRespository::class)->deleteComment($commentId);

            if ($deleteRequest === false) {
                self::$session->set('warning', "Impossible de supprimer le commentaire !");
                $this->listComments();
                return;
            }
            self::$session->set('success', "Le commentaire a bien été supprimé.");
            $this->listComments();
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }

    /**
     * Validate a Comment from ID using comment manager
     *
     * @param $commentId
     */
    public function validateComment($commentId)
    {
        $request = $this->app->get(CommentRespository::class)->validateComment($commentId);
        if ($request === false) {
            self::$session->set('warning', "Impossible de valider le commentaire !");
            $this->listComments();
            return;
        }
        self::$session->set('success', "Le commentaire a bien été validé.");
        $this->listComments();
    }

}
