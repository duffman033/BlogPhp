<?php

namespace App\Respository;

use App\Core\Database;
use App\Entity\Comment;
use PDO;
use PDOStatement;

/**
 * CommentRespository Queries for Comments
 */
class CommentRespository extends Database
{

    /**
     * Return Comments from a post
     *
     * @return array|mixed
     */
    public function getComments()
    {
        $req = 'SELECT comment_id, author_id, comment, is_valid, post_id, users.username, DATE_FORMAT(comment_date, \'%d/%m/%Y\') AS commentdate FROM comments INNER JOIN users on comments.author_id=users.user_id WHERE is_valid = :is_valid ORDER BY commentdate DESC';
        $parameters = [':is_valid' => 0];
        $result = $this->sql($req, $parameters);
        $customArray = [];

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($customArray, new Comment($datas));
        }

        return $customArray;
    }

    /**
     * Return Comment from ID
     *
     * @param $commentId
     * @return bool|false|PDOStatement
     */
    public function getComment($commentId)
    {
        $req = 'SELECT comment_id, author_id, comment, is_valid, post_id, users.username, DATE_FORMAT(comment_date, \'%d/%m/%Y\') AS comment_date FROM comments INNER JOIN users on comments.author_id=users.user_id WHERE comments.id = :id';
        $parameters = [':id' => $commentId];

        return $this->sql($req, $parameters);
    }

    /**
     * Add Comment from a user
     *
     * @param $postId
     * @param $authorId
     * @param $comment
     * @return bool|false|PDOStatement
     */
    public function addComment($postId, $authorId, $comment)
    {
        $newComments = 'INSERT INTO comments(post_id, author_id, comment, comment_date, is_valid) VALUES (:postId,:authorId,:comment, DATE(NOW()), :valid )';
        $parameters = [':postId' => $postId, ':authorId' => $authorId, ':comment' => $comment, ':valid' => 0];

        return $this->sql($newComments, $parameters);
    }

    /**
     * Delete Comment from ID
     *
     * @param $commentId
     * @return bool|false|PDOStatement
     */
    public function deleteComment($commentId)
    {
        $comment = 'DELETE FROM comments WHERE comment_id= :id';
        $parameters = [':id' => $commentId];

        return $this->sql($comment, $parameters);
    }

    /**
     * Get Only Valid Comments
     *
     * @param $postId
     * @return array|mixed
     */
    public function getValidComments($postId)
    {
        $validComments = 'SELECT comment_id, author_id, comment, is_valid, post_id, users.username, DATE_FORMAT(comment_date, \'%d/%m/%Y\') AS comment_date , users.user_img_url FROM comments INNER JOIN users on comments.author_id=users.user_id WHERE is_valid = :valid AND post_id = :postid ORDER BY comment_date DESC';
        $parameters = [':valid' => 1, ':postid' => $postId];
        $result = $this->sql($validComments, $parameters);
        $customArray = [];

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($customArray, new Comment($datas));
        }

        return $customArray;
    }

    /**
     * Get Only Invalid Comments
     *
     * @return array|mixed
     */
    public function getInvalidComments()
    {
        $invalidComments = 'SELECT *, author_id FROM comments INNER JOIN users on comments.author_id=users.user_id WHERE is_valid = :valid';
        $parameters = [':valid' => 0];
        $result = $this->sql($invalidComments, $parameters);
        $customArray = [];

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($customArray, new Comment($datas));
        }
        return $customArray;
    }

    /**
     * Validate a Comment
     *
     * @param $commentId
     * @return bool|false|PDOStatement
     */
    public function validateComment($commentId)
    {
        $validate = 'UPDATE comments SET is_valid = :valid WHERE comment_id = :id';
        $parameters = [':id' => $commentId, ':valid' => 1];

        return $this->sql($validate, $parameters);
    }
}
