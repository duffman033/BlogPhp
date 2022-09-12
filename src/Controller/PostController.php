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
     * Render the Admin Posts view from the post manager
     */
    public function listPosts()
    {
        $list_posts = $this->app->get('App\Respository\PostRespository')->getPosts();
        $this->renderer->render('Admin/PostView/postView.html.twig', ['posts' => $list_posts]);
    }

    /**
     * Render the Post View
     */
    public function addPostView()
    {
        $cat = $this->categoryManager->getCategorys();
        $this->renderer->render('Admin/PostView/addPostView.html.twig', ['categories' => $cat]);
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
            if (!empty($request->request->all())) {
                if (in_array($file->getClientMimeType(), $accept)) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $repertory = "uploads/images/";
                    $file->move($repertory, $fileName);

                    $datas['author_id'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('author_id'));
                    $datas['author'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('author'));
                    $datas['title'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('title'));
                    $datas['chapo'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('chapo'));
                    $datas['description'] = $this->app->get('App\Core\FormValidator')->purifyContent($request->get('description'));
                    $datas['img_url'] = $repertory.$fileName;

                    $result = $this->app->get('App\Respository\PostRespository')->addPost($datas);

                    $lastPost = $this->app->get('App\Respository\PostRespository')->getlastPosts();
                    foreach ($cat as $catId) {
                        $value = $request->get($catId->getType());
                        if ($value == 1) {
                            $relation['catId'] = $catId->getCatId();
                            $relation['postId'] = $lastPost["post_id"];

                            $this->app->get('App\Respository\RelationRespository')->addRelation($relation);
                        }
                    }


                    if ($result === false) {
                        $this->session->set('warning', "Impossible d'ajouter le projet !");
                        return;
                    }
                    $this->session->set('success', "Votre projet a bien été ajouté.");
                    $this->listPosts();
                    return;
                }
                $this->session->set('warning', "Merci d'inserer une image valide (Jpeg, Png ou Webp)");
                $this->addPostView();
                return;
            }
            $this->session->set('warning', "Merci de bien remplir le formulaire");
            $this->addPostView();
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }

    /**
     * Render Update Post View
     *
     * @param $postId
     */
    public function updatePostView($postId)
    {
        $cat = $this->categoryManager->getCategorys();
        $relation = $this->app->get('App\Respository\RelationRespository')->getRelation($postId);
        $post = $this->app->get('App\Respository\PostRespository')->getPost($postId);
        $this->renderer->render('Admin/PostView/updatePostView.html.twig', ['listpost' => $post, 'categories' => $cat, 'relations' => $relation]);
    }

    /**
     * Update a Post from ID using post manager
     *
     * @param $postId
     */
    public function updatePost($postId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            $fileName = $this->app->get('App\Respository\PostRespository')->selectImgPost($postId);
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
                    $this->updatePostView($postId);
                    return;
                }
                $datas['title'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('title'));
                $datas['chapo'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('chapo'));
                $datas['description'] = $this->app->get('App\Core\FormValidator')->purifyContent($request->get('description'));
                $datas['img_url'] = $repertory.$fileName;

                $result = $this->app->get('App\Respository\PostRespository')->updatePost($postId, $datas);
                $this->app->get('App\Respository\RelationRespository')->deleteRelation($postId);

                $cat = $this->categoryManager->getCategorys();

                foreach ($cat as $catId) {
                    $value = $request->get($catId->getType());
                    if ($value == 1) {
                        $relation['catId'] = $catId->getCatId();
                        $relation['postId'] = $postId;

                        $this->app->get('App\Respository\RelationRespository')->updateRelation($relation);
                    }
                }

                if ($result === false) {
                    $this->session->set('warning', "Impossible de modifier le projet !");
                    return;
                }
                $this->session->set('success', "Votre projet a bien été modifié.");
                $this->listPosts();
                return;
            }
            $this->session->set('warning', "Merci de bien remplir le formulaire");
            $this->updatePostView($postId);
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
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
            $deleteRequest = $this->app->get('App\Respository\PostRespository')->deletePost($postId);
            if ($deleteRequest === false) {
                $this->session->set('warning', "Impossible de supprimer le projet !");
                return;
            }
            $this->session->set('success', "Votre projet a bien été supprimé.");
            $this->listPosts();
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }
}
