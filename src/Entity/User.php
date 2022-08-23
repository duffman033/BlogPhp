<?php


namespace App\Entity;


class User
{
    /**
     * @var int $user_id user ID
     */
    private $userId;

    /**
     * @var string $username user name
     */
    private $username;

    /**
     * @var string $mail user email
     */
    private $email;

    /**
     * @var string $password password
     */
    private $password;

    /**
     * @var string $user_status user status
     */
    private $userStatus;

    /**
     * @var string $userImgUrl user img url
     */
    private $userImgUrl;

    public function __construct($datas = [])
    {
        if (!empty($datas)) {
            $this->hydrate($datas);
        }
    }

    public function hydrate($datas)
    {

        foreach ($datas as $key => $value) {
            $key = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userid
     * @return User
     */
    public function setUserId($userid)
    {
        $this->userId = $userid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    /**
     * @param string $status
     * @return User
     */
    public function setUserStatus($status)
    {
        $this->userStatus = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserImgUrl()
    {
        return $this->userImgUrl;
    }

    /**
     * @param string $userImgUrl
     */
    public function setUserImgUrl($userImgUrl)
    {
        $this->userImgUrl = $userImgUrl;
    }
}