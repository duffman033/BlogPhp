<?php

namespace App\Controller;


use App\Core\FormValidator;
use App\Respository\FormationRespository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormationController controller for Formation
 */
class FormationController extends AdminController
{
    /**
     * Render the Jobs view from the job manager
     */
    public function aboutFormView()
    {
        $formManager = $this->app->get(FormationRespository::class)->getFormations();
        $this->renderer->render('Admin/FormationView/formationView.html.twig', ['formations' => $formManager]);
    }

    /**
     * Render Update Job View
     *
     * @param $formId
     */
    public function updateFormView($formId)
    {
        $date_form = [];
        for ($i = 2017; $i <= date('Y') + 4; $i++) {
            array_push($date_form, $i);
        }
        $formManager = $this->app->get(FormationRespository::class)->getFormation($formId);
        $this->renderer->render('Admin/FormationView/updateFormationView.html.twig', ['formation' => $formManager, 'dates' => $date_form]);
    }

    /**
     * Render the Add JobView View
     */
    public function addFormView()
    {
        $date_form = [];
        for ($i = 2017; $i <= date('Y') + 4; $i++) {
            array_push($date_form, $i);
        }
        $this->renderer->render('Admin/FormationView/addFormationView.html.twig', ['dates' => $date_form]);
    }

    /**
     *  Add a Formation using job manager
     */
    public function addFormation()
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == self::$session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = $this->app->get(FormValidator::class)->purifyLow($request->get('name'));
                $datas['school'] = $this->app->get(FormValidator::class)->purifyLow($request->get('school'));
                $datas['place'] = $this->app->get(FormValidator::class)->purifyLow($request->get('place'));
                $datas['description'] = $this->app->get(FormValidator::class)->purifyContent($request->get('description'));
                $datas['startDate'] = $this->app->get(FormValidator::class)->purifyLow($request->get('startDate'));
                $datas['endDate'] = $this->app->get(FormValidator::class)->purifyLow($request->get('endDate'));

                $result = $this->app->get(FormationRespository::class)->addFormation($datas);

                if ($result === false) {
                    self::$session->set('warning', "Impossible d'ajouer la formation !");
                    return;
                }
                self::$session->set('success', "Votre formation a bien été ajoutée.");
                $this->aboutFormView();
                return;
            }
            self::$session->set('warning', "Merci de bien remplir le formulaire");
            $this->addFormView();
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }

    /**
     *  Update a JobView from ID using job manager
     *
     * @param $formId
     */
    public function updateFormation($formId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == self::$session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = $this->app->get(FormValidator::class)->purify($request->get('name'));
                $datas['school'] = $this->app->get(FormValidator::class)->purify($request->get('school'));
                $datas['place'] = $this->app->get(FormValidator::class)->purify($request->get('place'));
                $datas['description'] = $this->app->get(FormValidator::class)->purifyContent($request->get('description'));
                $datas['startDate'] = $this->app->get(FormValidator::class)->purify($request->get('startDate'));
                $datas['endDate'] = $this->app->get(FormValidator::class)->purify($request->get('endDate'));

                $result = $this->app->get(FormationRespository::class)->updateFormation($formId, $datas);

                if ($result === false) {
                    self::$session->set('warning', "Impossible de modifier la formation !");
                    return;
                }
                self::$session->set('success', "Votre formation a bien été modifié.");
                $this->aboutFormView();
                return;
            }
            self::$session->set('warning', "Merci de bien remplir le formulaire");
            $this->updateFormView($formId);
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }

    /**
     * Delete a JobView from ID using job manager
     *
     * @param $formId
     */
    public function deleteFormation($formId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == self::$session->get('token')) {
            $deleteRequest = $this->app->get(FormationRespository::class)->deleteFormation($formId);

            if ($deleteRequest === false) {
                self::$session->set('warning', "Impossible de supprimer la formation !");
                return;
            }
            self::$session->set('success', "Votre formation a bien été supprimé.");
            $this->aboutFormView();
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }
}
