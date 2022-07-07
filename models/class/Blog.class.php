<?php

class Blogs{
    private $id;
    private $blogTitle;
    private $chapo;
    private $article;
    private $autor;
    private $dateUpdate;
    private $imgUrl;


    public function __construct($id, $blogTitle, $chapo, $article, $autor, $dateUpdate, $imgUrl){
        $this->id = $id;
        $this->blogTitle = $blogTitle;
        $this->chapo = $chapo;
        $this->article = $article;
        $this->autor = $autor;
        $this->dateUpdate = $dateUpdate;
        $this->imgUrl = $imgUrl;

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBlogTitle()
    {
        return $this->blogTitle;
    }

    /**
     * @param mixed $blogTitle
     */
    public function setBlogTitle($blogTitle): void
    {
        $this->blogTitle = $blogTitle;
    }

    /**
     * @return mixed
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * @param mixed $chapo
     */
    public function setChapo($chapo): void
    {
        $this->chapo = $chapo;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article): void
    {
        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     */
    public function setAutor($autor): void
    {
        $this->autor = $autor;
    }

    /**
     * @return mixed
     */
    public function getDateUpdate()
    {
        $dateUpdateFormat = strtotime($this->dateUpdate);
        return date('d-m-Y',$dateUpdateFormat);
    }

    /**
     * @param mixed $dateUpdate
     */
    public function setDateUpdate($dateUpdate): void
    {
        $this->dateUpdate = $dateUpdate;
    }

    /**
     * @return mixed
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * @param mixed $imgUrl
     */
    public function setImgUrl($imgUrl): void
    {
        $this->imgUrl = $imgUrl;
    }

}