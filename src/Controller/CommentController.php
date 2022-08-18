<?php

namespace App\Controller;

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
        $comments = $this->commentManager->getInvalidComments();
        $this->renderer->render('Admin/commentView.html', ['listcomments' => $comments]);
    }

    /**
     * Delete a Comment from ID using comment manager
     *
     * @param $commentId
     */
    public function deletecomment($commentId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            $deleteRequest = $this->commentManager->deleteComment($commentId);
            if ($deleteRequest === false) {
                $this->session->set('warning', "Impossible de supprimer le commentaire !");
                return;
            }
            $this->session->set('success', "Le commentaire a bien été supprimé.");
            header('Location: /admin/comments');
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }

    /**
     * Validate a Comment from ID using comment manager
     *
     * @param $commentId
     */
    public function validateComment($commentId)
    {
        $request = $this->commentManager->validateComment($commentId);
        if ($request === false) {
            $this->session->set('warning', "Impossible de valider le commentaire !");
            return;
        }
        $this->session->set('success', "Le commentaire a bien été validé.");
        header('Location: /admin/comments');
    }

}
