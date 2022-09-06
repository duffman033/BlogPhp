<?php


namespace App\Entity;

class Relation
{

    private ?int $catId = null;

    private int $postId;

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

    public function getCatId(): ?int
    {
        return $this->catId;
    }

    public function setCatId($catId): self
    {
        $this->catId = $catId;
        return $this;
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
}
