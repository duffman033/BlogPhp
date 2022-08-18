<?php

namespace App\Controller;

use App\Core\FormValidator;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class AdminController controller for Admin
 */
class PostController extends AdminController
{
    /**
     * Render the Posts view from the post manager
     */
    public function listPosts()
    {
        $list_posts = $this->postManager->getPosts();
        $this->renderer->render('Admin/PostView/postView.html', ['posts' => $list_posts]);
    }

    /**
     * Render the Post View
     */
    public function addPostView()
    {
        $cat = $this->categoryManager->getCategorys();
        $this->renderer->render('Admin/PostView/addPostView.html', ['categories' => $cat]);
    }

    /**
     * Add a Post using post manager
     */
    public function addPost()
    {
        $request = Request::createFromGlobals();
        $cat = $this->categoryManager->getCategorys();
        if ($request->get('formtoken') == $this->session->get('token')) {
            $file = $request->files->get('image');
            $accept = ["image/jpeg","image/png","image/webp"];
            if (!empty($request->request->all())){
                if (in_array($file->getClientMimeType() , $accept)) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $repertory = "uploads/images/";
                    $file->move($repertory, $fileName);

                    $datas['author_id'] = FormValidator::purifyLow($request->get('author_id'));
                    $datas['author'] = FormValidator::purifyLow($request->get('author'));
                    $datas['title'] = FormValidator::purifyLow($request->get('title'));
                    $datas['chapo'] = FormValidator::purifyLow($request->get('chapo'));
                    $datas['description'] = FormValidator::purifyContent($request->get('description'));
                    $datas['img_url'] = $repertory.$fileName;

                    $result = $this->postManager->addPost($datas);

                    $lastPost = $this->postManager->getlastPosts();
                    foreach ($cat as $catId){
                        $value = $request->get($catId->getType());
                        if ($value == 1){
                            $relation['catId'] = $catId->getCatId();
                            $relation['postId'] = $lastPost["post_id"];

                            $this->relationManager->addRelation($relation);
                        }
                    }


                    if ($result === false) {
                        $this->session->set('warning', "Impossible d'ajouter le projet !");
                        return;
                    }
                    $this->session->set('success', "Votre projet a bien été ajouté.");
                    header('Location: /admin/post');
                    return;
                }
                $this->session->set('warning', "Merci d'inserer une image valide (Jpeg, Png ou Webp)");
                header('Location: /admin/add');
                return;
            }
            $this->session->set('warning', "Merci de bien remplir le formulaire");
            header('Location: /admin/add');
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }

    /**
     * Render Update Post View
     *
     * @param $postId
     */
    public function updatePostView($postId)
    {
        $cat = $this->categoryManager->getCategorys();
        $relation = $this->relationManager->getRelation($postId);
        $post = $this->postManager->getPost($postId);
        $this->renderer->render('Admin/PostView/updatePostView.html', ['listpost' => $post, 'categories' => $cat, 'relations' => $relation]);
    }

    /**
     * Update a Post from ID using post manager
     *
     * @param $postId
     */
    public function updatePost($postId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')){
            $fileName = $this->postManager->selectImgPost($postId);
            $file = $request->files->get('image');
            $accept = ["image/jpeg","image/png","image/webp"];
            $repertory='';
            if (!empty($request->request->all())) {
                if (!empty($file)) {
                    if (in_array($file->getClientMimeType(), $accept)) {
                        if (!empty($fileName)) {
                            unlink($fileName);
                        }
                        $fileName = md5(uniqid()).'.'.$file->guessExtension();
                        $repertory = "uploads/images/";
                        $file->move($repertory, $fileName);
                    }
                    $this->session->set('warning', "Merci d'inserer une image valide (Jpeg, Png ou Webp)");
                    header('Location: /admin/post/' . $postId);
                    return;
                }
                $datas['title'] = FormValidator::purifyLow($request->get('title'));
                $datas['chapo'] = FormValidator::purifyLow($request->get('chapo'));
                $datas['description'] = FormValidator::purifyContent($request->get('description'));
                $datas['img_url'] = $repertory.$fileName;

                $result = $this->postManager->updatePost($postId, $datas);
                $this->relationManager->deleteRelation($postId);

                $cat = $this->categoryManager->getCategorys();

                foreach ($cat as $catId){
                    $value = $request->get($catId->getType());
                    if ($value == 1){
                        $relation['catId'] = $catId->getCatId();
                        $relation['postId'] = $postId;

                        $this->relationManager->updateRelation($relation);
                    }
                }

                if ($result === false) {
                    $this->session->set('warning', "Impossible de modifier le projet !");
                    return;
                }
                $this->session->set('success', "Votre projet a bien été modifié.");
                header('Location: /admin/post');
                return;
            }
            $this->session->set('warning', "Merci de bien remplir le formulaire");
            header('Location: /admin/post/' . $postId);
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }

    /**
     * Delete a Post from ID using post manager
     *
     * @param $postId
     */
    public function deletePost($postId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {

            $deleteRequest = $this->postManager->deletePost($postId);
            if ($deleteRequest === false) {
                $this->session->set('warning', "Impossible de supprimer le projet !");
                return;
            }
            $this->session->set('success', "Votre projet a bien été supprimé.");
            header('Location: /admin/post');
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }
}