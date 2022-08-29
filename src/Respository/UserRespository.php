<?php

namespace App\Respository;

use App\Core\Database;
use App\Entity\User;
use PDO;
use PDOStatement;

/**
 * UserRespository Queries for Comments
 */
class UserRespository extends Database
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

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($custom_array, new User($datas));
        }

        return $custom_array;
    }

    /**
     * Delete a User
     *
     * @param $userId
     * @return bool|false|PDOStatement
     */
    public function deleteUser($userId)
    {
        $users = 'DELETE FROM users WHERE user_id= :id';
        $parameters = [':id' => $userId];

        return $this->sql($users, $parameters);
    }
}
