<?php

namespace App\Respository;

use App\Core\Database;
use App\Entity\Post;
use PDO;
use PDOStatement;

/**
 * PostRespository Queries for Posts
 */
class PostRespository extends Database
{

    /**
     * Return All Posts
     *
     * @return array
     */
    public function getPosts()
    {
        $posts = 'SELECT post_id, title, chapo, description, author_id, users.username, DATE_FORMAT(date_creation, \'%d/%m/%Y\') AS date_creation, DATE_FORMAT(date_update, \'%d/%m/%Y\') AS date_update , posts.img_url
        FROM posts INNER JOIN users ON posts.author_id = users.user_id ORDER BY date_creation DESC';
        $result = $this->sql($posts);
        $custom_array = [];

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($custom_array, new Post($datas));
        }

        return $custom_array;
    }

    /**
     * Return last id Posts
     *
     * @return mixed
     */
    public function getlastPosts()
    {
        $posts = 'SELECT post_id FROM posts ORDER BY post_id DESC LIMIT 1';
        $result = $this->sql($posts);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Return one Post from ID
     *
     * @param $postId
     * @return mixed
     */
    public function getPost($postId)
    {
        $post = 'SELECT post_id, title, chapo, description, author_id, users.username, DATE_FORMAT(date_creation, \'%d/%m/%Y\') AS date_creation, DATE_FORMAT(date_update, \'%d/%m/%Y\') AS date_update , posts.img_url, users.user_img_url
                FROM posts INNER JOIN users ON posts.author_id = users.user_id WHERE post_id= :postId';
        $parameters = [':postId' => $postId];
        $result = $this->sql($post, $parameters);
        $data = $result->fetch(PDO::FETCH_ASSOC);

        return new Post($data);
    }

    /**
     * Add a Post
     *
     * @param $post
     * @return bool|false|PDOStatement
     */
    public function addPost($post)
    {
        $newPost = 'INSERT INTO posts( title, chapo, description, date_creation, date_update, author_id, img_url) VALUES (:title, :chapo, :description, NOW(),NOW(), :author_id, :img_url)';
        $parameters = [
            ':title' => $post['title'],
            ':chapo' => $post['chapo'],
            ':description' => $post['description'],
            ':author_id' => $post['author_id'],
            ':img_url' => $post['img_url'],
        ];

        return $this->sql($newPost, $parameters);
    }

    /**
     * Delete a Post
     *
     * @param $postId
     * @return bool|false|PDOStatement
     */
    public function deletePost($postId)
    {
        $post = 'DELETE FROM posts WHERE post_id= :id';
        $parameters = [':id' => $postId];

        return $this->sql($post, $parameters);
    }

    /**
     * Update a Post
     *
     * @param $postId
     * @param $datas
     * @return bool|false|PDOStatement
     */
    public function updatePost($postId, $datas)
    {
        $editedPost = 'UPDATE posts SET title=:title, chapo=:chapo, description=:description, date_update=NOW() ,img_url=:img_url WHERE post_id=:id';
        $parameters = [
            ':id' => $postId,
            ':title' => $datas['title'],
            ':chapo' => $datas['chapo'],
            ':description' => $datas['description'],
            ':img_url' => $datas['img_url'],

        ];
        return $this->sql($editedPost, $parameters);
    }

    /**
     * Select by Id
     *
     * @param $postId
     * @return bool|false|PDOStatement
     */
    public function selectImgPost($postId)
    {
        $selectPost = 'SELECT * FROM posts WHERE post_id=:id ';
        $parameters = [
            ':id' => $postId,
        ];
        $result = $this->sql($selectPost, $parameters);
        $data = $result->fetch(PDO::FETCH_ASSOC);

        $datas = new Post($data);
        return $datas->getImgUrl();
    }
}
