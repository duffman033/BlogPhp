<?php

namespace App\Controller;

use App\Core\FormValidator;
use App\Respository\JobRespository;
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
        $jobManager = $this->app->get(JobRespository::class)->getJobs();
        $this->renderer->render('Admin/JobView/aboutJobView.html.twig', ['jobs' => $jobManager]);
    }

    /**
     * Render Update Job View
     *
     * @param $jobId
     */
    public function updateJobView($jobId)
    {
        $dateJob = [];
        for ($i = 2017; $i <= date('Y'); $i++) {
            array_push($dateJob, $i);
        }
        $jobManager = $this->app->get(JobRespository::class)->getJob($jobId);
        $this->renderer->render('Admin/JobView/updateJobView.html.twig', ['job' => $jobManager, 'dates' => $dateJob]);
    }

    /**
     * Render the Add JobView View
     */
    public function addJobView()
    {
        $dateJob = [];
        for ($i = 2017; $i <= date('Y'); $i++) {
            array_push($dateJob, $i);
        }
        $this->renderer->render('Admin/JobView/addJobView.html.twig', ['dates' => $dateJob]);
    }

    /**
     *  Add a JobView using job manager
     */
    public function addJob()
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == self::$session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = $this->app->get(FormValidator::class)->purifyLow($request->get('name'));
                $datas['company'] = $this->app->get(FormValidator::class)->purifyLow($request->get('company'));
                $datas['place'] = $this->app->get(FormValidator::class)->purifyLow($request->get('place'));
                $datas['description'] = $this->app->get(FormValidator::class)->purifyContent($request->get('description'));
                $datas['startDate'] = $this->app->get(FormValidator::class)->purifyLow($request->get('startDate'));
                $datas['endDate'] = $this->app->get(FormValidator::class)->purifyLow($request->get('endDate'));

                $result = $this->app->get(JobRespository::class)->addJob($datas);

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
                $datas['name'] = $this->app->get(FormValidator::class)->purifyLow($request->get('name'));
                $datas['company'] = $this->app->get(FormValidator::class)->purifyLow($request->get('company'));
                $datas['place'] = $this->app->get(FormValidator::class)->purifyLow($request->get('place'));
                $datas['description'] = $this->app->get(FormValidator::class)->purifyContent($request->get('description'));
                $datas['startDate'] = $this->app->get(FormValidator::class)->purifyLow($request->get('startDate'));
                $datas['endDate'] = $this->app->get(FormValidator::class)->purifyLow($request->get('endDate'));

                $result = $this->app->get(JobRespository::class)->updateJob($jobId, $datas);

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
            $deleteRequest = $this->app->get(JobRespository::class)->deleteJob($jobId);
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
