<?php


namespace App\Entity;

use Exception;

class Post
{
    private ?int $postId = null;

    private string $title;

    private string $chapo;

    private string $description;

    private int $authorId;

    private string $dateCreation;

    private string $dateUpdate;

    private string $username;

    private string $imgUrl;

    private string $userImgUrl;

    public function __construct($datas = [])
    {
        if (!empty($datas)) {
            $this->hydrate($datas);
        }
    }

    public function hydrate($datas)
    {

        foreach ($datas as $key => $value) {
            $key = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getPostId(): ?int
    {
        return $this->postId;
    }

    public function setPostId($postId): self
    {
        $this->postId = $postId;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getChapo(): ?string
    {
        return $this->chapo;
    }

    public function setChapo($chapo): self
    {
        $this->chapo = $chapo;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getAuthorId(): ?string
    {
        return $this->authorId;
    }

    public function setAuthorId($authorid): self
    {
        $this->authorId = $authorid;
        return $this;
    }

    public function getdateCreation(): ?string
    {
        return $this->dateCreation;
    }

    public function setdateCreation($dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getdateUpdate(): ?string
    {
        return $this->dateUpdate;
    }

    public function setdateUpdate($dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl($imgUrl): self
    {
        $this->imgUrl = $imgUrl;
        return $this;
    }

    public function getUserImgUrl(): ?string
    {
        return $this->userImgUrl;
    }

    public function setUserImgUrl($userImgUrl): self
    {
        $this->userImgUrl = $userImgUrl;
        return $this;
    }


}

