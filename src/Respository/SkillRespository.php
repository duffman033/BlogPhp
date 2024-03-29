<?php

namespace App\Respository;

use App\Core\Database;
use App\Entity\Skill;
use PDO;
use PDOStatement;

/**
 * SkillRespository Queries for Skill
 */
class SkillRespository extends Database
{
    /**
     * Return Skill
     *
     * @return array|mixed
     */
    public function getSkills()
    {
        $req = 'SELECT * FROM skills ORDER BY type DESC';
        $result = $this->sql($req);
        $customArray = [];

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($customArray, new Skill($datas));
        }

        return $customArray;
    }

    /**
     * Return Skill type
     *
     * @return array|mixed
     */
    public function getSkillType()
    {
        $req = 'SELECT type FROM skills GROUP BY type';
        $result = $this->sql($req);
        $customArray = [];

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($customArray, new Skill($datas));
        }
        return $customArray;
    }

    /**
     * Add a Skill
     *
     * @param $skill
     * @return bool|false|PDOStatement
     */
    public function addSkill($skill)
    {
        $newPost = 'INSERT INTO skills( name, progress, type) VALUES (:name, :progress, :type)';
        $parameters = [
            ':name' => $skill['name'],
            ':progress' => $skill['progress'],
            ':type' => $skill['type']
        ];

        return $this->sql($newPost, $parameters);
    }

    /**
     * Delete a Skill
     *
     * @param $skillId
     * @return bool|false|PDOStatement
     */
    public function deleteSkill($skillId)
    {
        $post = 'DELETE FROM skills WHERE skill_id= :id';
        $parameters = [':id' => $skillId];

        return $this->sql($post, $parameters);
    }

    /**
     * Update a Skill
     *
     * @param $skillId
     * @param $datas
     * @return bool|false|PDOStatement
     */
    public function updateSkill($skillId, $datas)
    {
        $editedSkill = 'UPDATE skills SET name=:name, progress=:progress, type=:type WHERE skill_id=:id';
        $parameters = [
            ':id' => $skillId,
            ':name' => $datas['name'],
            ':progress' => $datas['progress'],
            ':type' => $datas['type']

        ];
        return $this->sql($editedSkill, $parameters);
    }
}
