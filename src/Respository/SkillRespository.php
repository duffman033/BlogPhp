<?php

namespace App\Respository;

use App\Core\Database;
use App\Entity\Skill;

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
        $custom_array = [];

        while ($datas = $result->fetch(\PDO::FETCH_ASSOC)) {
            array_push($custom_array, New Skill($datas));
        }

        return $custom_array;

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
        $custom_array = [];

        while ($datas = $result->fetch(\PDO::FETCH_ASSOC)) {
            array_push($custom_array, New Skill($datas));
        }
        return $custom_array;

    }

    /**
     * Add a Skill
     *
     * @param $skill
     * @return bool|false|\PDOStatement
     */
    public function addSkill($skill)
    {
        $newPost = 'INSERT INTO skills( name, progress, type) VALUES (:name, :progress, :type)';
        $parameters = [
            ':name' => $skill['name'],
            ':progress' => $skill['progress'],
            ':type' => $skill['type']
        ];

        $this->sql($newPost, $parameters);

    }

    /**
     * Delete a Skill
     *
     * @param $skillId
     * @return bool|false|\PDOStatement
     */
    public function deleteSkill($skillId)
    {
        $post = 'DELETE FROM skills WHERE skill_id= :id';
        $parameters = [':id' => $skillId];

        $this->sql($post, $parameters);

    }

    /**
     * Update a Skill
     *
     * @param $skillId
     * @return bool|false|\PDOStatement
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
        $this->sql($editedSkill, $parameters);
    }

}
