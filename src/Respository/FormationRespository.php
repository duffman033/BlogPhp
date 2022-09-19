<?php

namespace App\Respository;

use App\Core\Database;
use App\Entity\Formation;
use PDO;
use PDOStatement;

/**
 * FormationRespository Queries for Formation
 */
class FormationRespository extends Database
{
    /**
     * Return Formation
     *
     * @return array|mixed
     */
    public function getFormations()
    {
        $req = 'SELECT * FROM formation ORDER BY start_date DESC';
        $result = $this->sql($req);
        $customArray = [];

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($customArray, new Formation($datas));
        }

        return $customArray;
    }

    /**
     * Return Formation
     *
     * @param $formId
     * @return array|mixed
     */
    public function getFormation($formId)
    {
        $form = 'SELECT * FROM formation WHERE formation_id= :id';
        $parameters = [':id' => $formId];
        $result = $this->sql($form, $parameters);
        $data = $result->fetch(PDO::FETCH_ASSOC);

        return new Formation($data);
    }

    /**
     * Add a Formation
     *
     * @param $form
     * @return bool|false|PDOStatement
     */
    public function addFormation($form)
    {
        $newForm = 'INSERT INTO formation ( name, school, place, description , start_date, end_date ) VALUES (:name, :school, :place, :description, :start_date, :end_date)';
        $parameters = [
            ':name' => $form['name'],
            ':school' => $form['school'],
            ':place' => $form['place'],
            ':description' => $form['description'],
            ':start_date' => $form['startDate'],
            ':end_date' => $form['endDate']
        ];

        return $this->sql($newForm, $parameters);
    }

    /**
     * Update a Formation
     *
     * @param $formId
     * @param $datas
     * @return bool|false|PDOStatement
     */
    public function updateFormation($formId, $datas)
    {
        $editedForm = 'UPDATE formation SET name=:name, school=:school, place=:place, description=:description, start_date=:start_date, end_date=:end_date WHERE formation_id=:id';
        $parameters = [
            ':id' => $formId,
            ':name' => $datas['name'],
            ':school' => $datas['school'],
            ':place' => $datas['place'],
            ':description' => $datas['description'],
            ':start_date' => $datas['startDate'],
            ':end_date' => $datas['endDate']
        ];

        return $this->sql($editedForm, $parameters);
    }

    /**
     * Delete a Formation
     *
     * @param $formId
     * @return bool|false|PDOStatement
     */
    public function deleteFormation($formId)
    {
        $form = 'DELETE FROM formation WHERE formation_id= :id';
        $parameters = [':id' => $formId];

        return $this->sql($form, $parameters);
    }
}
