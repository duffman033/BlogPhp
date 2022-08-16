<?php

namespace App\Manager;

use App\Core\Database;
use App\Model\Category;

/**
 * PostManager Queries for Posts
 */
class CategoryManager extends Database
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
        $custom_array = [];

        while ($datas = $result->fetch(\PDO::FETCH_ASSOC)) {
            array_push($custom_array, New Category($datas));
        }

        return $custom_array;

    }

    /**
     * Return Category by postId
     *
     * @return array
     */
    public function getCategory($postId)
    {
        $category = 'SELECT * FROM categories INNER JOIN relation on categories.cat_id=relation.cat_id WHERE relation.post_id = :postid';
        $parameters = [':postid' => $postId];
        $result = $this->sql($category, $parameters);
        $custom_array = [];

        while ($datas = $result->fetch(\PDO::FETCH_ASSOC)) {
            array_push($custom_array, New Category($datas));
        }

        return $custom_array;
    }

    /**
     * Add a Category
     *
     * @param $cat
     * @return bool|false|\PDOStatement
     */
    public function addCategory($cat)
    {
        $newCat = 'INSERT INTO categories( type ) VALUES (:type)';
        $parameters = [
            ':type' => $cat['type']
        ];

        $this->sql($newCat, $parameters);

    }

    /**
     * Update a Category
     *
     * @param $catId
     * @return bool|false|\PDOStatement
     */
    public function updateCategory($catId, $datas)
    {
        $editedCat = 'UPDATE categories SET type=:type WHERE cat_id=:id';
        $parameters = [
            ':id' => $catId,
            ':type' => $datas['type']
        ];

        $this->sql($editedCat, $parameters);

    }

    /**
     * Delete Category
     *
     * @param $catId
     * @return bool|false|\PDOStatement
     */
    public function deleteCategory($catId)
    {
        $cat = 'DELETE FROM categories WHERE cat_id= :id';
        $parameters = [':id' => $catId];

        $this->sql($cat, $parameters);

    }
}