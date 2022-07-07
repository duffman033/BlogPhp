<?php
session_start();

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/BlogController.controller.php";
$blogController = new BlogController;
//$userController = new UserController;

try{
    if(empty($_GET['page'])){
        require "views/accueil.view.php";
    }else{
        $url = explode("/", filter_var($_GET['page']),FILTER_SANITIZE_URL);

        switch($url[0]){
            case "accueil" : require "views/accueil.view.php";
            break;
            case "blogs" :
                if (empty($url[1])){
                    $blogController->afficherBlogs();
                }else if($url[1] === "l"){
                    $blogController->afficherBlog($url[2]);
                }else if($url[1] === "a"){
                    $blogController->ajoutBlog();
                }else if($url[1] === "m"){
                    $blogController->updateBlog($url[2]);
                }else if($url[1] === "s"){
                    $blogController->supprimerBlogs($url[2]);
                }else if($url[1] === "av"){
                    $blogController->ajoutBlogValidator();
                }else if($url[1] === "mv"){
                    $blogController->updateBlogValidator();
                }else{
                    throw new Exception("La page n'existe pas");
                }
            break;
            case "dashboard": $blogController->gestionBlogs();
            break;
            case "login": $userController->login();
            break;
            default : throw new Exception("La page n'existe pas");
        }
    }
}catch (Exception $e){
    $msg = $e->getMessage();
    require "views/error.view.php";
}