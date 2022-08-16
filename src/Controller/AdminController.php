<?php

namespace App\Controller;

use App\Core\TwigRenderer;
use App\Manager\CategoryManager;
use App\Manager\CertificateManager;
use App\Manager\FormationManager;
use App\Manager\JobManager;
use App\Manager\LoginManager;
use App\Manager\PostManager;
use App\Manager\CommentManager;
use App\Manager\RelationManager;
use App\Core\FormValidator;
use App\Manager\SkillManager;
use App\Manager\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;


/**
 * Class AdminController controller for Admin
 */
class AdminController
{
    protected $postManager;
    protected $commentManager;
    protected $userManager;
    protected $formationManager;
    protected $jobManager;
    protected $skillManager;
    protected $certificateManager;
    protected $categoryManager;
    protected $relationManager;
    protected $loginManager;
    protected $request;
    protected $session;
    protected $renderer;

    public function __construct()
    {

        $this->postManager = new PostManager();
        $this->commentManager = New CommentManager();
        $this->userManager = New UserManager();
        $this->formationManager = new FormationManager();
        $this->jobManager = new JobManager();
        $this->skillManager = new SkillManager();
        $this->relationManager = new RelationManager();
        $this->categoryManager = new CategoryManager();
        $this->certificateManager = new CertificateManager();
        $this->loginManager = new LoginManager();
        $this->renderer = new TwigRenderer();

        if (session_status() == PHP_SESSION_NONE) {
            $this->session = new Session\Session;
            $this->session->setName('session');
            $this->session->start();
        }

        if (!$this->session->get('auth')) {
            $this->session->set('warning', "Connectez-vous pour accéder à cette page");
            header('Location: /login');
        }

        if ($this->session->get('auth')) {
            if ($this->session->get('auth')->getUserstatus() != 1) {
                header('Location: /');
            }
        }
    }

    public function __destruct()
    {
        $this->session->remove('warning');
        $this->session->remove('success');
    }

}