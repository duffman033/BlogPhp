<?php
require "models/BlogManager.class.php";

class BlogController{
    private $blogManager;

    public function __construct(){
        $this->blogManager = new BlogManager;
        $this->blogManager->chargementBlogs();
    }

    public function afficherBlogs(){
        $blogs = $this->blogManager->getBlogs();
        require "views/blogs.view.php";
        unset($_SESSION['alert']);
    }

    public function afficherBlog($id){
        $blog = $this->blogManager->getBlogById($id);
        require "views/afficherBlog.view.php";
    }

    public function gestionBlogs(){
        $blogs = $this->blogManager->getBlogs();
        require "views/blogsGestion.view.php";
        unset($_SESSION['alert']);
    }

    public function ajoutBlog()
    {
        require "views/ajoutBlog.view.php";
    }

    public function ajoutBlogValidator()
    {
        $file = $_FILES['image'];
        $repertory = "public/images/";
        $imageUpload = $this->ajoutImage($file, $repertory);
        $this->blogManager->ajoutBlogBD($_POST["title"],$_POST["chapo"],$_POST["article"],$imageUpload);
        $_SESSION['alert'] =[
            "type" => "success",
            "msg" => "Ajout réalisé"
        ];
        header('Location: '.URL."blogs");
    }

    private function ajoutImage($file, $dir){
        if(!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");

        if(!file_exists($dir)) mkdir($dir,0777);

        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        $random = rand(0,99999);
        $target_file = $dir.$random."_".$file['name'];

        if(!getimagesize($file["tmp_name"]))
            throw new Exception("Le fichier n'est pas une image");
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");
        if(file_exists($target_file))
            throw new Exception("Le fichier existe déjà");
        if($file['size'] > 500000)
            throw new Exception("Le fichier est trop gros");
        if(!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
        else return ($random."_".$file['name']);
    }

    public function supprimerBlogs($id){
        $image = $this->blogManager->getBlogById($id)->getImgUrl();
        unlink("public/images/".$image);
        $this->blogManager->suppressionBlogBd($id);
        $_SESSION['alert'] =[
            "type" => "success",
            "msg" => "Suppression réalisé"
        ];
        header('Location: '.URL.'dashboard');
    }

    public function updateBlog(string $int){
        $blog = $this->blogManager->getBlogById($int);
        require "views/updateBlog.view.php";
    }

    public function updateBlogValidator(){
        $image = $this->blogManager->getBlogById($_POST["id"])->getImgUrl();
        $file = $_FILES['image'];
        if($file['size']>0){
            unlink("public/images/".$image);
            $dir = "public/images/";
            $imageUpdated = $this->ajoutImage($file, $dir);
        }else{
            $imageUpdated = $image;
        }
        $this->blogManager->updateBlogBd($_POST["id"], $_POST["title"],$_POST["chapo"],$_POST["article"],$imageUpdated);
        $_SESSION['alert'] =[
            "type" => "success",
            "msg" => "Modification réalisé"
        ];
        header('Location: '.URL.'blogs');
    }
}