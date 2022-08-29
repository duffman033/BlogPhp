<?php


namespace App\Entity;

class Comment
{

    /**
     * @var int $comment_id comment id
     */
    private int $commentId;
    /**
     * @var int $authorId author id
     */
    private int $authorId;
    /**
     * @var string $comment comment content
     */
    private string $comment;
    /**
     * @var int $post_id post id
     */
    private int $postId;
    /**
     * @var string $comment_date comment date update
     */
    private string $commentDate;
    /**
     * @var bool $is_valid comment status
     */
    private bool $isValid;
    /**
     * @var string $username comment username
     */
    private string $username;
    /**
     * @var string $userImgUrl comment user img_url
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
     * @param int $commentId
     * @return Comment
     */
    public function setCommentId(int $commentId)
    {
        $this->commentId = $commentId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $author
     * @return Comment
     */
    public function setAuthorId(int $author)
    {
        $this->authorId = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Comment
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @param int $postId
     * @return Comment
     */
    public function setPostId(int $postId)
    {
        $this->postId = $postId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommentDate()
    {
        return $this->commentDate;
    }

    /**
     * @param string $commentDate
     * @return Comment
     */
    public function setCommentDate(string $commentDate)
    {
        $this->commentDate = $commentDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * @param mixed $isValid
     * @return Comment
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return Comment
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserImgUrl()
    {
        return $this->userImgUrl;
    }

    /**
     * @param mixed $userImgUrl
     * @return Comment
     */
    public function setUserImgUrl($userImgUrl)
    {
        $this->userImgUrl = $userImgUrl;
        return $this;
    }
}
