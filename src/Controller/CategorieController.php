<?php

namespace App\Controller;

use App\Core\FormValidator;
use App\Respository\CategoryRespository;
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
        $catManager = $this->app->get(CategoryRespository::class)->getCategorys();
        $this->renderer->render('Admin/categoriesView.html.twig', ['categories' => $catManager]);
    }

    /**
     *  Add a JobView using job manager
     */
    public function addCategory()
    {
        $request = Request::createFromGlobals();
        if ($request->get('formtoken') == self::$session->get('token')) {
            if (!empty($request->request->all())) {

                $datas['type'] = $this->app->get(FormValidator::class)->purify($request->get('type'));
                $result = $this->app->get(CategoryRespository::class)->addCategory($datas);

                if ($result === false) {
                    self::$session->set('warning', "Impossible d'ajouer le catégorie !");
                    $this->categoriesView();
                    return;
                }
                self::$session->set('success', "Votre catégorie a bien été ajoutée.");
                $this->categoriesView();

                return;
            }
            self::$session->set('warning', "Merci de bien remplir le formulaire");
            $this->categoriesView();
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
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

        if ($request->get('formtoken') == self::$session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['type'] = $this->app->get(FormValidator::class)->purify($request->get('type'));
                $result = $this->app->get(CategoryRespository::class)->updateCategory($catId, $datas);
                if ($result === false) {
                    self::$session->set('warning', "Impossible de modifier le catégorie !");
                    $this->categoriesView();
                    return;
                }
                self::$session->set('success', "Votre catégorie a bien été modifiée.");
                $this->categoriesView();
                return;
            }
            self::$session->set('warning', "Merci de bien remplir le formulaire");
            $this->categoriesView();
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
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
        if ($request->get('formtoken') == self::$session->get('token')) {
            $deleteRequest = $this->app->get(CategoryRespository::class)->deleteCategory($catId);
            if ($deleteRequest === false) {
                self::$session->set('warning', "Impossible de supprimer la catégorie !");
                $this->categoriesView();
                return;
            }
            self::$session->set('success', "Votre catégorie a bien été supprimée.");
            $this->categoriesView();
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }
}
