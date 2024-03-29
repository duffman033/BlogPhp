<?php

namespace App\Respository;

use App\Core\Database;
use App\Entity\Category;
use PDO;
use PDOStatement;

/**
 * PostRespository Queries for Posts
 */
class CategoryRespository extends Database
{

    /**
     * Return All Categorys
     *
     * @return array|mixed
     */
    public function getCategorys()
    {
        $req = 'SELECT * FROM categories ORDER BY type ASC';
        $result = $this->sql($req);
        $customArray = [];

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($customArray, new Category($datas));
        }

        return $customArray;
    }

    /**
     * Return Category by postId
     *
     * @param $postId
     * @return array
     */
    public function getCategory($postId)
    {
        $category = 'SELECT * FROM categories INNER JOIN relation on categories.cat_id=relation.cat_id WHERE relation.post_id = :postid';
        $parameters = [':postid' => $postId];
        $result = $this->sql($category, $parameters);
        $customArray = [];

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            $customArray[] = new Category($datas);
        }

        return $customArray;
    }

    /**
     * Add a Category
     *
     * @param $cat
     * @return bool|false|PDOStatement
     */
    public function addCategory($cat)
    {
        $newCat = 'INSERT INTO categories( type ) VALUES (:type)';
        $parameters = [
            ':type' => $cat['type']
        ];

        return $this->sql($newCat, $parameters);
    }

    /**
     * Update a Category
     *
     * @param $catId
     * @param $datas
     * @return bool|false|PDOStatement
     */
    public function updateCategory($catId, $datas)
    {
        $editedCat = 'UPDATE categories SET type=:type WHERE cat_id=:id';
        $parameters = [
            ':id' => $catId,
            ':type' => $datas['type']
        ];

        return $this->sql($editedCat, $parameters);
    }

    /**
     * Delete Category
     *
     * @param $catId
     * @return bool|false|PDOStatement
     */
    public function deleteCategory($catId)
    {
        $cat = 'DELETE FROM categories WHERE cat_id= :id';
        $parameters = [':id' => $catId];

        return $this->sql($cat, $parameters);
    }
}
