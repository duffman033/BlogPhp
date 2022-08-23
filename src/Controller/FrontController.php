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
use App\Core\FormValidator;
use App\Respository\RelationRespository;
use App\Respository\SkillRespository;
use App\Respository\UserRespository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;


/**
 * Class FrontController controller for Frontend
 */
Class FrontController
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
    protected $formManager;
    protected $request;
    protected $session;
    protected $renderer;

    public function __construct()
    {
        $this->renderer = new TwigRenderer();
        $this->postManager = new PostRespository();
        $this->commentManager = New CommentRespository();
        $this->loginManager = new LoginRespository();
        $this->categoryManager = new CategoryRespository();
        $this->formationManager = new FormationRespository();
        $this->jobManager = new JobRespository();
        $this->skillManager = new SkillRespository();
        $this->certificateManager = new CertificateRespository();
        $this->formManager = new FormManager();
        $this->userManager = New UserRespository();
        $this->relationManager = new RelationRespository();

        if (session_status() == PHP_SESSION_NONE) {
            $this->session = new Session\Session;
            $this->session->setName('session');
            $this->session->start();
        }

    }

    public function __destruct()
    {
        //$this->session->getFlashBag()->clear();
        $this->session->remove('warning');
        $this->session->remove('success');
    }

    /**
     * Render Home
     */
    public function home()
    {
        $this->renderer->render('User/homepage.html.twig', ["current" => 1]);
    }

    /**
     * Render the Posts view from the post manager
     */
    public function listPosts()
    {
        $list_posts = $this->postManager->getPosts();
        $this->renderer->render('User/postsView.html.twig', ['listposts' => $list_posts ,'current' => 2]);
    }

    /**
     * Render the Post view from the post manager
     *
     * @param $postId
     */
    public function post($postId)
    {
        $post = $this->postManager->getPost($postId);
        $list_comments = $this->commentManager->getValidComments($postId);
        $category = $this->categoryManager->getCategory($postId);
        $this->renderer->render('User/postView.html.twig', ['post' => $post, 'listcomments' => $list_comments, 'current' => 2, 'categories' => $category]);
    }

    /**
     * Add a Comment using comment manager
     */
    public function addComment()
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == $this->session->get('token')) {

            if (!empty($request->request->all())) {

                $postId = FormValidator::purify($request->get('postid'));
                $authorId = FormValidator::purify($request->get('authorid'));
                $description = FormValidator::purifyContent($request->get('description'));

                $request = $this->commentManager->addComment($postId, $authorId, $description);

                if ($request === false) {
                    $this->session->set('warning', "Impossible d'ajouter le commentaire");
                }
                $this->session->set('success', "Votre commentaire va être soumis à validation.");
                $this->post($postId);
                return;
            }
        }
        $this->session->set('warning', "Veuillez pour reconnecter");
        $this->login();
    }

    /**
     * Render About
     */
    public function about()
    {
        $formationManager = $this->formationManager->getFormations();
        $jobManager = $this->jobManager->getJobs();
        $certificateManager = $this->certificateManager->getCertificate();
        $skillManager = $this->skillManager->getSkills();
        $type = $this->skillManager->getSkillType();
        $this->renderer->render('User/aboutView.html.twig', ['formations'=>$formationManager ,'jobs'=>$jobManager ,'certificates'=>$certificateManager ,'skills'=>$skillManager ,'types'=>$type ,"current" => 3]);
    }


    /**
     * Render the Contact View
     */
    public function contactView()
    {
        $this->renderer->render('User/contactView.html.twig', ['current'=>4]);
    }

    /**
     * Send an email from contact form using manager
     */
    public function contactForm()
    {
        $request = Request::createFromGlobals();
        if (!empty($request->request->all()) && FormValidator::is_email($request->get('email'))) {
            $name = FormValidator::purify($request->get('name'));
            $forename = FormValidator::purify($request->get('forename'));
            $message = FormValidator::purify($request->get('message'));
            $email = FormValidator::purify($request->get('email'));

            $this->formManager->formTraitment($name, $forename, $email, $message);
            $this->session->set('success', "Votre formulaire a bien été envoyé.");
            $this->contactView();
            return;

        }
        $this->session->set('warning', "Tous les champs ne sont pas remplis ou corrects.");
        $this->contactView();
    }

    /**
     * Download the CV
     */
    public function cv()
    {
        $file = '../public/pdf/CV.pdf';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            return;
        }
        echo "Le fichier n'existe pas ou le nom de fichier n'est pas défini.";
    }

    /**
     * Render the Login View
     */
    public function login()
    {
        $this->renderer->render('User/loginView.html.twig');
    }

    /**
     * Connect a User using manager
     *
     * @throws \Exception
     */
    public function connect()
    {
        $request = Request::createFromGlobals();
        $username = FormValidator::purify($request->get('username'));
        $password = FormValidator::purify($request->get('password'));

        if (!FormValidator::is_alphanum($username)) {
            $this->session->set('warning', "Votre pseudo $username n'est pas valide");
            $this->login();

        } elseif (!FormValidator::is_alphanum($password)) {
            $this->session->set('warning', "Votre mot de passe n'est pas valide");
            $this->login();

        } else {
            $user = $this->loginManager->getLogin($username);

            if (!$user) {
                $this->session->set('warning', "Cette identifiant n'existe pas");
                $this->login();

            } else {
                $isPasswordCorrect = password_verify($password, $user->getPassword());

                if ($isPasswordCorrect == false) {
                    $this->session->set('warning', "Mot de passe incorrect");
                    $this->login();

                } else {
                    $this->session->set('auth', $user);
                    $this->session->set('token', bin2hex(random_bytes(16)));

                    if ($this->session->get('auth')->getUserStatus() == '1') {
                        header('location: /admin');
                    } else {
                        $this->home();
                    }
                }
            }
        }
    }

    /**
     * Render the Register View
     */
    public function registerView()
    {
        $this->renderer->render('User/registerView.html.twig');
    }

    /**
     * Register a User using login manager
     */
    public function register()
    {
        $request = Request::createFromGlobals();
        if (!empty($request->request->all())){
            $repertory = "uploads/images/";
            $fileName = "unknow.jpg";
            $file = $request->files->get('image');
            $accept = ["image/jpeg", "image/png", "image/webp"];
            if (!empty($file)) {
                if (in_array($file->getClientMimeType(), $accept)) {
                    if (!empty($file)) {
                        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                        $file->move($repertory, $fileName);
                    }
                    $this->session->set('warning', "Merci d'inserer une image valide (Jpeg, Png ou Webp)");
                    $this->registerView();
                    return;
                }
            }

            $email = FormValidator::purify($request->get('email'));
            $username = FormValidator::purify($request->get('username'));
            $password = FormValidator::purify($request->get('password'));
            $passwordConfirm = FormValidator::purify($request->get('password_confirm'));
            $img_url = $repertory . $fileName;
            if (!FormValidator::is_alphanum($username)) {
                $this->session->set('warning', "Votre pseudo n'est pas valide");
                $this->registerView();
                return;

            } elseif (!FormValidator::is_alphanum($password) || !FormValidator::is_alphanum($passwordConfirm)) {
                $this->session->set('warning', "Votre mot de passe n'est pas valide");
                $this->registerView();
                return;

            } elseif (!FormValidator::is_email($email)) {
                $this->session->set('warning', "Votre email n'est pas valide");
                $this->registerView();
                return;
            }
            if ($this->loginManager->isMemberExists($username, $email)) {
                if ($this->loginManager->checkPassword($password, $passwordConfirm)) {

                    $this->loginManager->registerUser($username, $password, $email, $img_url);
                    $this->formManager->registerTraitment($email, $username);
                    $this->session->set('success', "Votre inscription a bien été prise en compte");
                    $this->login();
                    return;
                }
                $this->session->set('warning', "Les mots de passe ne sont pas identiques");
                $this->registerView();
                return;
            }
            $this->session->set('warning', "Cet utilisateur existe déjà");
            $this->registerView();
            return;
        }
        $this->session->set('warning', "Merci de bien remplir le formulaire");
        $this->registerView();
    }

    /**
     * Disconnect a User
     */
    public function deconnect()
    {
        $this->session->clear();
        $this->home();
    }

    /**
     * Render the CGV View
     */
    public function mentions()
    {
        $this->renderer->render('User/mentionsView.html.twig');
    }

    /**
     * Render the RGPD View
     */
    public function rgpd()
    {
        $this->renderer->render('User/rgpdView.html.twig');
    }

}
