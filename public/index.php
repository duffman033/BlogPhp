<?php

require '../vendor/autoload.php';

use App\Controller\Router;



$router = new Router();

    //Front management
    $router->map('GET', '/', 'FrontController#home');
    $router->map('GET', '/posts', 'FrontController#listPosts');
    $router->map('GET', '/post/[i:id]', 'FrontController#post');
    $router->map('GET', '/about', 'FrontController#about');
    $router->map('GET', '/register', 'FrontController#registerView');
    $router->map('POST', '/register', 'FrontController#register');
    $router->map('POST', '/comment/add', 'FrontController#addComment');
    $router->map('GET', '/contact', 'FrontController#contactView');
    $router->map('POST', '/contactForm', 'FrontController#contactForm');
    $router->map('GET', '/cv', 'FrontController#cvDownload');
    $router->map('GET', '/mentions', 'FrontController#mentions');
    $router->map('GET', '/RGPD', 'FrontController#rgpd');

    //Admin Management

    //Users management
    $router->map('GET', '/admin', 'UserController#listUser');
    $router->map('POST', '/admin/users/delete/[i:id]', 'UserController#deleteUser');

    //Jobs management
    $router->map('GET', '/admin/job', 'JobController#aboutJobView');
    $router->map('GET', '/admin/job/add', 'JobController#addJobView');
    $router->map('GET', '/admin/job/update/[i:id]', 'JobController#updateJobView');
    $router->map('POST', '/admin/job/update/[i:id]', 'JobController#updateJob');
    $router->map('POST', '/admin/job/add', 'JobController#addJob');
    $router->map('POST', '/admin/job/delete/[i:id]', 'JobController#deleteJob');

    //Formation management
    $router->map('GET', '/admin/formation', 'FormationController#aboutFormView');
    $router->map('GET', '/admin/formation/add', 'FormationController#addFormView');
    $router->map('GET', '/admin/formation/update/[i:id]', 'FormationController#updateFormView');
    $router->map('POST', '/admin/formation/update/[i:id]', 'FormationController#updateFormation');
    $router->map('POST', '/admin/formation/add', 'FormationController#addFormation');
    $router->map('POST', '/admin/formation/delete/[i:id]', 'FormationController#deleteFormation');

    //Skills management
    $router->map('GET', '/admin/skill', 'SkillController#skillView');
    $router->map('POST', '/admin/skill/update/[i:id]', 'SkillController#updateSkill');
    $router->map('POST', '/admin/skill/add', 'SkillController#addSkill');
    $router->map('POST', '/admin/skill/delete/[i:id]', 'SkillController#deleteSkill');

    //Posts management
    $router->map('GET', '/admin/post', 'PostController#listPosts');
    $router->map('GET', '/admin/post/[i:id]', 'PostController#updatePostView');
    $router->map('POST', '/admin/post/update/[i:id]', 'PostController#updatePost');
    $router->map('POST', '/admin/post/delete/[i:id]', 'PostController#deletePost');
    $router->map('GET', '/admin/add', 'PostController#addPostView');
    $router->map('POST', '/admin/addpost', 'PostController#addPost');

    //Comments management
    $router->map('GET', '/admin/comments', 'CommentController#listComments');
    $router->map('POST', '/admin/comment/delete/[i:id]', 'CommentController#deleteComment');
    $router->map('POST', '/admin/comment/validate/[i:id]', 'CommentController#validateComment');

    //Categories management
    $router->map('GET', '/admin/categorie', 'CategorieController#categoriesView');
    $router->map('POST', '/admin/categorie/delete/[i:id]', 'CategorieController#deleteCategorie');
    $router->map('POST', '/admin/categorie/update/[i:id]', 'CategorieController#updateCategory');
    $router->map('POST', '/admin/categorie/add', 'CategorieController#addCategory');

    //login Management
    $router->map('GET', '/login', 'FrontController#login');
    $router->map('POST', '/connect', 'FrontController#connect');
    $router->map('GET', '/logout', 'FrontController#deconnect');
    $match = $router->match();

    if ($match == false){
        return $router->errorView();
    }

    $router->routerRequest($match['target'], $match['params']);
