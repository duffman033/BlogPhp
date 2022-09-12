<?php

namespace App\Controller;

use App\Core\FormValidator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController controller for Admin
 */
class SkillController extends AdminController
{
    /**
     * Render the Skill view from the skill manager
     */
    public function skillView()
    {
        $skillManager = $this->app->get('App\Respository\SkillRespository')->getSkills();
        $type = $this->app->get('App\Respository\SkillRespository')->getSkillType();
        $this->renderer->render('Admin/aboutView.html.twig', ['skills'=>$skillManager ,'types'=>$type]);
    }

    /**
     *  Add a Skill using skill manager
     */
    public function addSkill()
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = $this->app->get('App\Core\FormValidator')->purify($request->get('name'));
                $datas['progress'] = $this->app->get('App\Core\FormValidator')->purify($request->get('progress'));
                $datas['type'] = $this->app->get('App\Core\FormValidator')->purify($request->get('type'));

                $result = $this->app->get('App\Respository\SkillRespository')->addSkill($datas);

                if ($result === false) {
                    $this->session->set('warning', "Impossible d'ajouer la compétence !");
                    return;
                }
                $this->session->set('success', "Votre compétence ".$datas['name']." a bien été ajoutée.");
                $this->skillView();
                return;
            }
            $this->session->set('warning', "Merci de bien remplir le formulaire");
            $this->skillView();
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }

    /**
     *  Update a Skill from ID using skill manager
     *
     * @param $skillId
     */
    public function updateSkill($skillId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            if (!empty($request->request->all())) {
                $datas['name'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('name'));
                $datas['progress'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('progress'));
                $datas['type'] = $this->app->get('App\Core\FormValidator')->purifyLow($request->get('type'));

                $result = $this->app->get('App\Respository\SkillRespository')->updateSkill($skillId, $datas);

                if ($result === false) {
                    $this->session->set('warning', "Impossible de modifier la compétence !");
                    return;
                }
                $this->session->set('success', "Votre compétence ".$datas['name']." a bien été modifiée.");
                $this->skillView();
                return;
            }
            $this->session->set('warning', "Merci de bien remplir le formulaire");
            $this->skillView();
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }

    /**
     * Delete a Comment from ID using comment manager
     *
     * @param $skillId
     */
    public function deleteSkill($skillId)
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {
            $deleteRequest = $this->app->get('App\Respository\SkillRespository')->deleteSkill($skillId);
            if ($deleteRequest === false) {
                $this->session->set('warning', "Impossible de supprimer la compétence !");
                return;
            }
            $this->session->set('success', "La compétence a bien été supprimée.");
            $this->skillView();
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        $this->deconnect();
    }
}
