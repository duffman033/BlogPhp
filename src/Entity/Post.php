<?php


namespace App\Entity;

use DateTime;

class Post
{
    /**
     * @var int $post_id post id
     */
    private $postId;
    /**
     * @var string $title title post
     */
    private $title;

    /**
     * @var string $chapo chapo post
     */
    private $chapo;

    /**
     * @var string $description description post
     */
    private $description;

    /**
     * @var int $authorid author post
     */
    private $authorId;

    /**
     * @var string $date_creation post date creation
     */
    private $dateCreation;

    /**
     * @var string $date_update post date update
     */
    private $dateUpdate;

    /**
     * @var string $username post username
     */
    private $username;

    /**
     * @var string $imgUrl img url
     */
    private $imgUrl;

    /**
     * @var string $userImgUrl post user img_url
     */
    private $userImgUrl;

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

    /**
     * @return int
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param int $postId
     * @return Post
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * @param string $chapo
     * @return Post
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @param string $author
     * @return Post
     */
    public function setAuthorId($authorid)
    {
        $this->authorId = $authorid;
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getdateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param string $dateCreation
     * @return Post
     */
    public function setdateCreation($dateCreation = null)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return string
     */
    public function getdateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * @param string $dateUpdate
     * @return Post
     */
    public function setdateUpdate($dateUpdate = null)
    {
        $this->dateUpdate = $dateUpdate;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Post
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * @param string $imgUrl
     */
    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @return string
     */
    public function getUserImgUrl()
    {
        return $this->userImgUrl;
    }

    /**
     * @param string $userImgUrl
     * @return Post
     */
    public function setUserImgUrl($userImgUrl)
    {
        $this->userImgUrl = $userImgUrl;
    }


}

