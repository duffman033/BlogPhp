<?php

namespace App\Manager;

use App\Core\Database;
use App\Model\Formation;

/**
 * FormationManager Queries for Formation
 */
class FormationManager extends Database
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
        $custom_array = [];

        while ($datas = $result->fetch(\PDO::FETCH_ASSOC)) {
            array_push($custom_array, New Formation($datas));
        }

        return $custom_array;

    }

    /**
     * Return Formation
     *
     * @param $formId
     * @return array|mixed
     */
    public function getFormation($formId)
    {
        $form = 'SELECT * FROM formation WHERE id= :id';
        $parameters = [':id' => $formId];
        $result = $this->sql($form, $parameters);
        $data = $result->fetch(\PDO::FETCH_ASSOC);

        return new Formation($data);

    }

    /**
     * Add a Formation
     *
     * @param $form
     * @return bool|false|\PDOStatement
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

        $this->sql($newForm, $parameters);

    }

    /**
     * Update a Formation
     *
     * @param $form
     * @return bool|false|\PDOStatement
     */
    public function updateFormation($formId, $datas)
    {
        $editedForm = 'UPDATE formation SET name=:name, school=:school, place=:place, description=:description, start_date=:start_date, end_date=:end_date WHERE id=:id';
        $parameters = [
            ':id' => $formId,
            ':name' => $datas['name'],
            ':school' => $datas['school'],
            ':place' => $datas['place'],
            ':description' => $datas['description'],
            ':start_date' => $datas['startDate'],
            ':end_date' => $datas['endDate']
        ];

        $this->sql($editedForm, $parameters);

    }

    /**
     * Delete a Formation
     *
     * @param $formId
     * @return bool|false|\PDOStatement
     */
    public function deleteFormation($formId)
    {
        $form = 'DELETE FROM formation WHERE id= :id';
        $parameters = [':id' => $formId];

        $this->sql($form, $parameters);

    }
}