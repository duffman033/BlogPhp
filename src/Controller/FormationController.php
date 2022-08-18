<?php

namespace App\Controller;

use App\Core\FormValidator;
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
        $formManager = $this->formationManager->getFormations();
        $this->renderer->render('Admin/FormationView/formationView.html', ['formations' => $formManager]);
    }

    /**
     * Render Update Job View
     *
     * @param $formId
     */
    public function updateFormView($formId)
    {
        $date_form = [];
        for ($i = 2017; $i <= date('Y')+4; $i++) {
            array_push($date_form, $i);
        }
        $formManager = $this->formationManager->getFormation($formId);
        $this->renderer->render('Admin/FormationView/updateFormationView.html', ['formation' => $formManager, 'dates' => $date_form]);
    }

    /**
     * Render the Add JobView View
     */
    public function addFormView()
    {
        $date_form = [];
        for ($i = 2017; $i <= date('Y')+4; $i++) {
            array_push($date_form, $i);
        }
        $this->renderer->render('Admin/FormationView/addFormationView.html', ['dates' => $date_form]);
    }

    /**
     *  Add a Formation using job manager
     */
    public function addFormation()
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = FormValidator::purifyLow($request->get('name'));
                $datas['school'] = FormValidator::purifyLow($request->get('school'));
                $datas['place'] = FormValidator::purifyLow($request->get('place'));
                $datas['description'] = FormValidator::purifyContent($request->get('description'));
                $datas['startDate'] = FormValidator::purifyLow($request->get('startDate'));
                $datas['endDate'] = FormValidator::purifyLow($request->get('endDate'));

                $result = $this->formationManager->addFormation($datas);

                if ($result === false) {
                    $this->session->set('warning', "Impossible d'ajouer la formation !");
                }
                $this->session->set('success', "Votre formation a bien été ajoutée.");
                header('Location: /admin/formation');
            }
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }

    /**
     *  Update a JobView from ID using job manager
     *
     * @param $formId
     */
    public function updateFormation($formId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = FormValidator::purify($request->get('name'));
                $datas['school'] = FormValidator::purify($request->get('school'));
                $datas['place'] = FormValidator::purify($request->get('place'));
                $datas['description'] = FormValidator::purifyContent($request->get('description'));
                $datas['startDate'] = FormValidator::purify($request->get('startDate'));
                $datas['endDate'] = FormValidator::purify($request->get('endDate'));

                $result = $this->formationManager->updateFormation($formId,$datas);

                if ($result === false) {
                    $this->session->set('warning', "Impossible de modifier la formation !");
                }
                $this->session->set('success', "Votre formation a bien été modifié.");
                header('Location: /admin/formation');
            }
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }

    /**
     * Delete a JobView from ID using job manager
     *
     * @param $formId
     */
    public function deleteFormation($formId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {

            $deleteRequest = $this->jobManager->deleteFormation($formId);
            if ($deleteRequest === false) {
                $this->session->set('warning', "Impossible de supprimer la formation !");
            }
            $this->session->set('success', "Votre formation a bien été supprimé.");
            header('Location: /admin/formation');
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }
}