<?php


namespace App\Model;


class Relation
{
    /**
     * @var int $cat_id cat ID
     */
    private $catId;

    /**
     * @var int $postId post ID
     */
    private $postId;

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
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     * @param int $catId
     */
    public function setCatId($catId)
    {
        $this->catId = $catId;
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
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;
    }
}