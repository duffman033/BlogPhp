<?php

namespace App\Respository;

use App\Core\Database;
use App\Entity\Relation;

/**
 * RelationRespository Queries for Relation
 */
class RelationRespository extends Database
{

    /**
     * Return Relation by postId
     *
     * @return array
     */
    public function getRelation($postId)
    {
        $relation = 'SELECT * FROM relation WHERE post_id = :postId';
        $parameters = [':postId' => $postId];
        $result = $this->sql($relation, $parameters);
        $custom_array = [];

        while ($datas = $result->fetch(\PDO::FETCH_ASSOC)) {
            array_push($custom_array, New Relation($datas));
        }

        return $custom_array;
    }

    /**
     * Add a Relation
     *
     * @param $relation
     * @return bool|false|\PDOStatement
     */
    public function addRelation($relation)
    {
        $newRel = 'INSERT INTO relation (cat_id, post_id) VALUES (:catId, :postId)';
        $parameters = [
            ':catId' => $relation['catId'],
            ':postId' => $relation['postId']
        ];

        $this->sql($newRel, $parameters);
    }

    /**
     * Update a Relation
     *
     * @param $relation
     * @return bool|false|\PDOStatement
     */
    public function updateRelation($relation)
    {

        $editedRel = 'INSERT INTO relation (cat_id, post_id) VALUES (:catId, :postId)';
        $parameters = [
            ':catId' => $relation['catId'],
            ':postId' => $relation['postId']
        ];

        $this->sql($editedRel, $parameters);
    }

    /**
     * Delete Relation
     *
     * @param $relId
     * @return bool|false|\PDOStatement
     */
    public function deleteRelation($relId)
    {
        $rel = 'DELETE FROM relation WHERE post_id=:postId';
        $parameters = [':postId' => $relId];

        $this->sql($rel, $parameters);
    }

}
