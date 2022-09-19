<?php


namespace App\Entity;

class User
{
    private ?int $userId = null;

    private ?string $username = null;

    private string $email;

    private ?string $password = null;

    private string $userStatus;

    private string $userImgUrl;

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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId($userid): self
    {
        $this->userId = $userid;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getUserStatus(): ?string
    {
        return $this->userStatus;
    }

    public function setUserStatus($status): self
    {
        $this->userStatus = $status;
        return $this;
    }

    public function getUserImgUrl(): ?string
    {
        return $this->userImgUrl;
    }

    public function setUserImgUrl($userImgUrl): self
    {
        $this->userImgUrl = $userImgUrl;
        return $this;
    }
}
