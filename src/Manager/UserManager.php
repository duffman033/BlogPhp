<?php

namespace App\Manager;

use App\Core\Database;
use App\Model\User;

/**
 * UserManager Queries for Comments
 */
class UserManager extends Database
{
    /**
     * Return All Users
     *
     * @return array
     */
    public function getUsers()
    {
        $users = 'SELECT * FROM users';
        $result = $this->sql($users);
        $custom_array = [];

        while ($datas = $result->fetch(\PDO::FETCH_ASSOC)) {
            array_push($custom_array, New User($datas));
        }

        return $custom_array;

    }

    /**
     * Delete a User
     *
     * @param $userId
     * @return bool|false|\PDOStatement
     */
    public function deleteUser($userId)
    {
        $users = 'DELETE FROM users WHERE user_id= :id';
        $parameters = [':id' => $userId];

        $this->sql($users, $parameters);

        header('Location: /admin');

    }
}