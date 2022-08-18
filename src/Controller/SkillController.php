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
        $skillManager = $this->skillManager->getSkills();
        $type = $this->skillManager->getSkillType();
        $this->renderer->render('Admin/aboutView.html', ['skills'=>$skillManager ,'types'=>$type]);
    }

    /**
     *  Add a Skill using skill manager
     */
    public function addSkill(){
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')){
            if (!empty($request->request->all())) {
                $datas['name'] = FormValidator::purify($request->get('name'));
                $datas['progress'] = FormValidator::purify($request->get('progress'));
                $datas['type'] = FormValidator::purify($request->get('type'));

                $result = $this->skillManager->addSkill($datas);

                if ($result === false) {
                    $this->session->set('warning', "Impossible d'ajouer la compétence !");
                    return;
                }
                $this->session->set('success', "Votre compétence ".$datas['name']." a bien été ajoutée.");
                header('Location: /admin/skill');
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
     *  Update a Skill from ID using skill manager
     *
     * @param $skillId
     */
    public function updateSkill($skillId){
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')){
            if (!empty($request->request->all())) {
                $datas['name'] = FormValidator::purifyLow($request->get('name'));
                $datas['progress'] = FormValidator::purifyLow($request->get('progress'));
                $datas['type'] = FormValidator::purifyLow($request->get('type'));

                $result = $this->skillManager->updateSkill($skillId, $datas);

                if ($result === false) {
                    $this->session->set('warning', "Impossible de modifier la compétence !");
                    return;
                }
                $this->session->set('success', "Votre compétence ".$datas['name']." a bien été modifiée.");
                header('Location: /admin/skill');
                return;
            }
            $this->session->set('warning', "Merci de bien remplir le formulaire");
            header('Location: /admin/skill/update/' . $skillId);
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
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
            $deleteRequest = $this->skillManager->deleteSkill($skillId);
            if ($deleteRequest === false) {
                $this->session->set('warning', "Impossible de supprimer la compétence !");
                return;
            }
            $this->session->set('success', "La compétence a bien été supprimée.");
            header('Location: /admin/skill');
            return;
        }
        $this->session->set('warning', "Problème de token, veuillez vous reconnecter");
        header('Location: /logout');
    }
}