<?php


namespace App\Entity;

class Comment
{
    private ?int $commentId = null;

    private int $authorId;

    private string $comment;

    private int $postId;

    private string $commentDate;

    private bool $isValid;

    private string $username;

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

    public function setCommentId(int $commentId): self
    {
        $this->commentId = $commentId;
        return $this;
    }

    public function getCommentId(): ?int
    {
        return $this->commentId;
    }

    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    public function setAuthorId(int $author): self
    {
        $this->authorId = $author;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPostId(): ?int
    {
        return $this->postId;
    }

    public function setPostId(int $postId): self
    {
        $this->postId = $postId;

        return $this;
    }

    public function getCommentDate(): ?string
    {
        return $this->commentDate;
    }

    public function setCommentDate(string $commentDate): self
    {
        $this->commentDate = $commentDate;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUserImgUrl(): ?string
    {
        return $this->userImgUrl;
    }

    public function setUserImgUrl(string $userImgUrl): self
    {
        $this->userImgUrl = $userImgUrl;

        return $this;
    }
}
