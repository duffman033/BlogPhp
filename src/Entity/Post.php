<?php


namespace App\Entity;

use Exception;

class Post
{
    /**
     * @var int $post_id post id
     */
    private int $postId;
    /**
     * @var string $title title post
     */
    private string $title;

    /**
     * @var string $chapo chapo post
     */
    private string $chapo;

    /**
     * @var string $description description post
     */
    private string $description;

    /**
     * @var int $authorid author post
     */
    private int $authorId;

    /**
     * @var string $date_creation post date creation
     */
    private string $dateCreation;

    /**
     * @var string $date_update post date update
     */
    private string $dateUpdate;

    /**
     * @var string $username post username
     */
    private string $username;

    /**
     * @var string $imgUrl img url
     */
    private string $imgUrl;

    /**
     * @var string $userImgUrl post user img_url
     */
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
     * @param $authorid
     * @return Post
     */
    public function setAuthorId($authorid)
    {
        $this->authorId = $authorid;
        return $this;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getdateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param string $dateCreation
     * @return Post
     */
    public function setdateCreation($dateCreation)
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
    public function setdateUpdate($dateUpdate)
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
     * @return Post
     */
    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
        return $this;
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
        return $this;
    }


}

