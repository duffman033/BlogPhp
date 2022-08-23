<?php

namespace App\Controller;

use App\Core\TwigRenderer;
use App\Respository\CategoryRespository;
use App\Respository\CertificateRespository;
use App\Respository\FormationRespository;
use App\Respository\FormManager;
use App\Respository\JobRespository;
use App\Respository\LoginRespository;
use App\Respository\PostRespository;
use App\Respository\CommentRespository;
use App\Respository\RelationRespository;
use App\Core\FormValidator;
use App\Respository\SkillRespository;
use App\Respository\UserRespository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;


/**
 * Class AdminController controller for Admin
 */
class AdminController extends FrontController
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->get('auth')) {
            $this->session->set('warning', "Connectez-vous pour accéder à cette page");
            FrontController::connect();
        }

        if ($this->session->get('auth')) {
            if ($this->session->get('auth')->getUserstatus() != 1) {
                FrontController::home();
            }
        }
    }

    public function __destruct()
    {
        $this->session->remove('warning');
        $this->session->remove('success');
    }

}