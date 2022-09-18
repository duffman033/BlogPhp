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
use App\Respository\SkillRespository;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use App\Core\DIC;

/**
 * Class FrontController controller for Frontend
 */
class FrontController
{
    protected Request $request;
    protected static ?Session\Session $session = null;
    protected TwigRenderer $renderer;
    protected DIC $app;

    public function __construct()
    {
        $this->app = new DIC;
        $this->renderer = new TwigRenderer();

        if (self::$session == null) {
            self::$session = new Session\Session;
            self::$session->setName('session');
            self::$session->start();
        }
    }

    public function __destruct()
    {
        if (self::$session != null) {
            self::$session->remove('warning');
            self::$session->remove('success');
        }
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
        $list_posts = $this->app->get(PostRespository::class)->getPosts();
        $this->renderer->render('User/postsView.html.twig', ['listposts' => $list_posts ,'current' => 2]);
    }

    /**
     * Render the Post view from the post manager
     *
     * @param $postId
     */
    public function post($postId)
    {
        $post = $this->app->get(PostRespository::class)->getPost($postId);
        $list_comments = $this->app->get(CommentRespository::class)->getValidComments($postId);
        $category = $this->app->get(CategoryRespository::class)->getCategory($postId);
        $this->renderer->render('User/postView.html.twig', ['post' => $post, 'listcomments' => $list_comments, 'current' => 2, 'categories' => $category]);
    }

    /**
     * Add a Comment using comment manager
     */
    public function addComment()
    {
        $request = Request::createFromGlobals();

        if ($request->get('formtoken') == self::$session->get('token')) {
            if (!empty($request->request->all())) {
                $postId = $this->app->get(FormValidator::class)->purify($request->get('postid'));
                $authorId = $this->app->get(FormValidator::class)->purify($request->get('authorid'));
                $description = $this->app->get(FormValidator::class)->purifyContent($request->get('description'));

                $request = $this->app->get(CommentRespository::class)->addComment($postId, $authorId, $description);

                if ($request === false) {
                    self::$session->set('warning', "Impossible d'ajouter le commentaire");
                }
                self::$session->set('success', "Votre commentaire va être soumis à validation.");
                $this->post($postId);
                return;
            }
        }
        self::$session->set('warning', "Veuillez pour reconnecter");
        $this->login();
    }

    /**
     * Render About
     */
    public function about()
    {
        $formationManager = $this->app->get(FormationRespository::class)->getFormations();
        $jobManager =$this->app->get(JobRespository::class)->getJobs();
        $certificateManager = $this->app->get(CertificateRespository::class)->getCertificate();
        $skillManager = $this->app->get(SkillRespository::class)->getSkills();
        $type = $this->app->get(SkillRespository::class)->getSkillType();
        $this->renderer->render('User/aboutView.html.twig', ['formations'=>$formationManager ,'jobs'=>$jobManager ,'certificates'=>$certificateManager ,'skills'=>$skillManager ,'types'=>$type ,"current" => 3]);
    }


    /**
     * Render the Contact View
     */
    public function contactView()
    {
        $this->renderer->render('User/contactView.html.twig', ['current' => 4]);
    }

    /**
     * Send an email from contact form using manager
     * @throws TransportExceptionInterface
     */
    public function contactForm()
    {
        $request = Request::createFromGlobals();
        if (!empty($request->request->all()) && FormValidator::is_email($request->get('email'))) {
            $name = $this->app->get(FormValidator::class)->purify($request->get('name'));
            $forename = $this->app->get(FormValidator::class)->purify($request->get('forename'));
            $message = $this->app->get(FormValidator::class)->purify($request->get('message'));
            $email = $this->app->get(FormValidator::class)->purify($request->get('email'));

            $this->app->get(FormManager::class)->formTraitment($name, $forename, $email, $message);
            self::$session->set('success', "Votre formulaire a bien été envoyé.");
            $this->contactView();
            return;
        }
        self::$session->set('warning', "Tous les champs ne sont pas remplis ou corrects.");
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
        self::$session->set('warning', "Le fichier n'existe pas ou le nom de fichier n'est pas défini.");
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
     * @throws Exception
     */
    public function connect()
    {
        $request = Request::createFromGlobals();
        $username = $this->app->get(FormValidator::class)->purify($request->get('username'));
        $password = $this->app->get(FormValidator::class)->purify($request->get('password'));

        if (!FormValidator::is_alphanum($username)) {
            self::$session->set('warning', "Votre pseudo $username n'est pas valide");
            $this->login();
        } elseif (!FormValidator::is_alphanum($password)) {
            self::$session->set('warning', "Votre mot de passe n'est pas valide");
            $this->login();
        } else {
            $user = $this->app->get(LoginRespository::class)->getLogin($username);

            if (!$user) {
                self::$session->set('warning', "Cette identifiant n'existe pas");
                $this->login();
            } else {
                $isPasswordCorrect = password_verify($password, $user->getPassword());

                if ($isPasswordCorrect == false) {
                    self::$session->set('warning', "Mot de passe incorrect");
                    $this->login();
                } else {
                    self::$session->set('auth', $user);
                    self::$session->set('token', bin2hex(random_bytes(16)));

                    if (self::$session->get('auth')->getUserStatus() == '1') {
                        $this->app->get(UserController::class)->listUser();
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
     * @throws TransportExceptionInterface
     */
    public function register()
    {
        $request = Request::createFromGlobals();
        if (!empty($request->request->all())) {
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
                    self::$session->set('warning', "Merci d'inserer une image valide (Jpeg, Png ou Webp)");
                    $this->registerView();
                    return;
                }
            }

            $email = $this->app->get(FormValidator::class)->purify($request->get('email'));
            $username = $this->app->get(FormValidator::class)->purify($request->get('username'));
            $password = $this->app->get(FormValidator::class)->purify($request->get('password'));
            $passwordConfirm = $this->app->get(FormValidator::class)->purify($request->get('password_confirm'));
            $img_url = $repertory . $fileName;
            if (!FormValidator::is_alphanum($username)) {
                self::$session->set('warning', "Votre pseudo n'est pas valide");
                $this->registerView();
                return;
            } elseif (!$this->app->get(FormValidator::class)->is_alphanum($password) || !$this->app->get(FormValidator::class)->is_alphanum($passwordConfirm)) {
                self::$session->set('warning', "Votre mot de passe n'est pas valide");
                $this->registerView();
                return;
            } elseif (!$this->app->get(FormValidator::class)->is_email($email)) {
                self::$session->set('warning', "Votre email n'est pas valide");
                $this->registerView();
                return;
            }
            if ($this->app->get(LoginRespository::class)->isMemberExists($username, $email)) {
                if ($this->app->get(LoginRespository::class)->checkPassword($password, $passwordConfirm)) {
                    $this->app->get(LoginRespository::class)->registerUser($username, $password, $email, $img_url);
                    $this->app->get(FormManager::class)->registerTraitment($email, $username);
                    self::$session->set('success', "Votre inscription a bien été prise en compte");
                    $this->login();
                    return;
                }
                self::$session->set('warning', "Les mots de passe ne sont pas identiques");
                $this->registerView();
                return;
            }
            self::$session->set('warning', "Cet utilisateur existe déjà");
            $this->registerView();
            return;
        }
        self::$session->set('warning', "Merci de bien remplir le formulaire");
        $this->registerView();
    }

    /**
     * Disconnect a User
     */
    public function deconnect()
    {
        self::$session->clear();
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
