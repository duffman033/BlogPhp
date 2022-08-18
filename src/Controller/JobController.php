<?php

namespace App\Controller;

use App\Core\FormValidator;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class JobController controller for Jobs
 */
class JobController extends AdminController
{
    /**
     * Render the Jobs view from the job manager
     */
    public function aboutJobView()
    {
        $jobManager = $this->jobManager->getJobs();
        $this->renderer->render('Admin/JobView/aboutJobView.html', ['jobs' => $jobManager]);
    }

    /**
     * Render Update Job View
     *
     * @param $jobId
     */
    public function updateJobView($jobId)
    {
        $date_job = [];
        for ($i = 2017; $i <= date('Y'); $i++) {
            array_push($date_job, $i);
        }
        $jobManager = $this->jobManager->getJob($jobId);
        $this->renderer->render('Admin/JobView/updateJobView.html', ['job' => $jobManager, 'dates' => $date_job]);
    }

    /**
     * Render the Add JobView View
     */
    public function addJobView()
    {
        $date_job = [];
        for ($i = 2017; $i <= date('Y'); $i++) {
            array_push($date_job, $i);
        }
        $this->renderer->render('Admin/JobView/addJobView.html', ['dates' => $date_job]);
    }

    /**
     *  Add a JobView using job manager
     */
    public function addJob()
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = FormValidator::purifyLow($request->get('name'));
                $datas['company'] = FormValidator::purifyLow($request->get('company'));
                $datas['place'] = FormValidator::purifyLow($request->get('place'));
                $datas['description'] = FormValidator::purifyContent($request->get('description'));
                $datas['startDate'] = FormValidator::purifyLow($request->get('startDate'));
                $datas['endDate'] = FormValidator::purifyLow($request->get('endDate'));

                $result = $this->jobManager->addJob($datas);

                if ($result === false) {
                    $this->session->set('warning', "Impossible d'ajouer le métier !");
                }
                $this->session->set('success', "Votre métier a bien été ajoutée.");
                header('Location: /admin/job');
            }
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }

    /**
     *  Update a JobView from ID using job manager
     *
     * @param $jobId
     */
    public function updateJob($jobId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = FormValidator::purifyLow($request->get('name'));
                $datas['company'] = FormValidator::purifyLow($request->get('company'));
                $datas['place'] = FormValidator::purifyLow($request->get('place'));
                $datas['description'] = FormValidator::purifyContent($request->get('description'));
                $datas['startDate'] = FormValidator::purifyLow($request->get('startDate'));
                $datas['endDate'] = FormValidator::purifyLow($request->get('endDate'));

                $result = $this->jobManager->updateJob($jobId,$datas);

                if ($result === false) {
                    $this->session->set('warning', "Impossible de modifier le métier !");
                }
                $this->session->set('success', "Votre métier a bien été modifié.");
                header('Location: /admin/job');
            }
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }

    /**
     * Delete a JobView from ID using job manager
     *
     * @param $jobId
     */
    public function deleteJob($jobId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {

            $deleteRequest = $this->jobManager->deleteJob($jobId);
            if ($deleteRequest === false) {
                $this->session->set('warning', "Impossible de supprimer le métier !");
            }
            $this->session->set('success', "Votre métier a bien été supprimé.");
            header('Location: /admin/job');
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }
}