<?php

namespace App\Controller;

use App\Core\FormValidator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategorieController controller for Categorie
 */
class CategorieController extends AdminController
{
    /**
     * Render the Jobs view from the job manager
     */
    public function categoriesView()
    {
        $catManager = $this->app->get('App\Respository\CategoryRespository')->getCategorys();
        $this->renderer->render('Admin/categoriesView.html.twig', ['categories' => $catManager]);
    }

    /**
     *  Add a JobView using job manager
     */
    public function addCategory()
    {
        $request = Request::createFromGlobals();
        if ($request->get('formtoken') == $this->session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['type'] = FormValidator::purify($request->get('type'));
                $result = $this->app->get('App\Respository\CategoryRespository')->addCategory($datas);
                if ($result === false) {
                    $this->session->set('warning', "Impossible d'ajouer le catégorie !");
                    $this->categoriesView();
                    return;
                }
                $this->session->set('success', "Votre catégorie a bien été ajoutée.");
                $this->categoriesView();

                return;
            }
            $this->session->set('warning', "Merci de bien remplir le formulaire");
            $this->categoriesView();
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }

    /**
     *  Update a Category from ID using Category manager
     *
     * @param $catId
     */
    public function updateCategory($catId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['type'] = $this->app->get('App\Core\FormValidator')->purify($request->get('type'));
                $result = $this->app->get('App\Respository\CategoryRespository')->updateCategory($catId, $datas);
                if ($result === false) {
                    $this->session->set('warning', "Impossible de modifier le catégorie !");
                    $this->categoriesView();
                    return;
                }
                $this->session->set('success', "Votre catégorie a bien été modifiée.");
                $this->categoriesView();
                return;
            }
            $this->session->set('warning', "Merci de bien remplir le formulaire");
            $this->categoriesView();
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }

    /**
     * Delete a Categorie from ID using Categorie manager
     *
     * @param $catId
     */
    public function deleteCategorie($catId)
    {
        $request = Request::createFromGlobals();
        if ($request->get('formtoken') == $this->session->get('token')) {
            $deleteRequest = $this->app->get('App\Respository\CategoryRespository')->deleteCategory($catId);
            if ($deleteRequest === false) {
                $this->session->set('warning', "Impossible de supprimer la catégorie !");
                $this->categoriesView();
                return;
            }
            $this->session->set('success', "Votre catégorie a bien été supprimée.");
            $this->categoriesView();
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }
}
