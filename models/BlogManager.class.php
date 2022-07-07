<?php
require_once __DIR__ . "/class/Model.class.php";
require_once __DIR__ . "/class/Blog.class.php";

class BlogManager extends Model {
    private $blogs;

    public function __construct(){
    }

    public function ajoutBlog($blog){
        $this->blogs[] = $blog;
    }

    public function getBlogs(){
        return $this->blogs;
    }

    public function chargementBlogs(){
        $req = $this->getBdd()->prepare("SELECT * FROM blogs ORDER BY id DESC");
        $req->execute();
        $blogs = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();

        foreach ($blogs as $blog){
            $b = new Blogs($blog["id"],$blog["blogTitle"],$blog["chapo"],$blog["article"],$blog["autor"],$blog["dateUpdate"],$blog["imgUrl"]);
            $this->ajoutBlog($b);
        }
    }

    public function getBlogById($id)
    {
        for($i = 0 ; $i < count ($this->blogs) ; $i++){
            if ($this->blogs[$i]->getId() == $id){
                return $this->blogs[$i];
            }
        }
        throw new Exception("Le post demandé n'existe pas");
    }

    public function ajoutBlogBD($title, $chapo, $article, $imgUrl)
    {
        $autor = 'Bastien Moreau';
        $dateUpdate = date('Y-m-d H:i:s');
        $req = "
        INSERT INTO blogs (blogTitle, chapo, article, autor, dateUpdate, imgUrl)
        values (:blogTitle, :chapo, :article, :autor , :dateUpdate ,:imgUrl)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":blogTitle",$title,PDO::PARAM_STR);
        $stmt->bindValue(":chapo",$chapo,PDO::PARAM_STR);
        $stmt->bindValue(":article",$article,PDO::PARAM_STR);
        $stmt->bindValue(":autor",$autor,PDO::PARAM_STR);
        $stmt->bindValue(":dateUpdate",$dateUpdate,PDO::PARAM_STR);
        $stmt->bindValue(":imgUrl",$imgUrl,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if($resultat > 0){
            $blog = new Blogs($this->getBdd()->lastInsertId(),$title,$chapo,$article,$autor,$dateUpdate,$imgUrl);
            $this->ajoutBlog($blog);
        }
    }

    public function suppressionBlogBd($id){
        $req = "
        Delete FROM blogs WHERE id = :blogId
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":blogId",$id,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            $blog = $this->getBlogById($id);
            unset($blog);
        }
    }

    public function updateBlogBd($id, $title, $chapo, $article, $imgUrl){
        $autor = 'Bastien Moreau';
        $dateUpdate = date('Y-m-d H:i:s');
        $req = "
        UPDATE blogs 
        SET blogTitle = :blogTitle, chapo = :chapo, article = :article, autor = :autor, dateUpdate = :dateUpdate, imgUrl = :imgUrl
        WHERE id = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id",$id,PDO::PARAM_STR);
        $stmt->bindValue(":blogTitle",$title,PDO::PARAM_STR);
        $stmt->bindValue(":chapo",$chapo,PDO::PARAM_STR);
        $stmt->bindValue(":article",$article,PDO::PARAM_STR);
        $stmt->bindValue(":autor",$autor,PDO::PARAM_STR);
        $stmt->bindValue(":dateUpdate",$dateUpdate,PDO::PARAM_STR);
        $stmt->bindValue(":imgUrl",$imgUrl,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if($resultat > 0){
            $this->getBlogById($id)->setBlogTitle($title);
            $this->getBlogById($id)->setChapo($chapo);
            $this->getBlogById($id)->setArticle($article);
            $this->getBlogById($id)->setAutor($autor);
            $this->getBlogById($id)->setDateUpdate($dateUpdate);
            $this->getBlogById($id)->setImgUrl($imgUrl);
        }
    }
}
