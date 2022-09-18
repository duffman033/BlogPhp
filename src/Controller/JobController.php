<?php

namespace App\Controller;

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
        $jobManager = $this->app->get('App\Respository\JobRespository')->getJobs();
        $this->renderer->render('Admin/JobView/aboutJobView.html.twig', ['jobs' => $jobManager]);
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
        $jobManager = $this->app->get('App\Respository\JobRespository')->getJob($jobId);
        $this->renderer->render('Admin/JobView/updateJobView.html.twig', ['job' => $jobManager, 'dates' => $date_job]);
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
        $this->renderer->render('Admin/JobView/addJobView.html.twig', ['dates' => $date_job]);
    }

    /**
     *  Add a JobView using job manager
     */
    public function addJob()
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == self::$session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('name'));
                $datas['company'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('company'));
                $datas['place'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('place'));
                $datas['description'] = $this->app->get('App\Core\FormValidator')->purifyContent($request->get('description'));
                $datas['startDate'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('startDate'));
                $datas['endDate'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('endDate'));

                $result = $this->app->get('App\Respository\JobRespository')->addJob($datas);

                if ($result === false) {
                    self::$session->set('warning', "Impossible d'ajouer le métier !");
                    return;
                }
                self::$session->set('success', "Votre métier a bien été ajoutée.");
                $this->aboutJobView();
                return;
            }
            self::$session->set('warning', "Merci de bien remplir le formulaire");
            $this->addJobView();
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }

    /**
     *  Update a JobView from ID using job manager
     *
     * @param $jobId
     */
    public function updateJob($jobId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == self::$session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('name'));
                $datas['company'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('company'));
                $datas['place'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('place'));
                $datas['description'] = $this->app->get('App\Core\FormValidator')->purifyContent($request->get('description'));
                $datas['startDate'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('startDate'));
                $datas['endDate'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('endDate'));

                $result = $this->app->get('App\Respository\JobRespository')->updateJob($jobId, $datas);

                if ($result === false) {
                    self::$session->set('warning', "Impossible de modifier le métier !");
                    return;
                }
                self::$session->set('success', "Votre métier a bien été modifié.");
                $this->aboutJobView();
                return;
            }
            self::$session->set('warning', "Merci de bien remplir le formulaire");
            $this->updateJobView($jobId);
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }

    /**
     * Delete a JobView from ID using job manager
     *
     * @param $jobId
     */
    public function deleteJob($jobId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == self::$session->get('token')) {
            $deleteRequest = $this->app->get('App\Respository\JobRespository')->deleteJob($jobId);
            if ($deleteRequest === false) {
                self::$session->set('warning', "Impossible de supprimer le métier !");
                return;
            }
            self::$session->set('success', "Votre métier a bien été supprimé.");
            $this->aboutJobView();
            return;
        }
        self::$session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }
}
