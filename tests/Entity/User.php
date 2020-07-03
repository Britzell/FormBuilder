<?php

namespace Britzel\Form\Tests\Entity;



class User
{

    private $id;
    private $email;
    private $password;
    private $password_confirm;
    private $firstname;
    private $lastname;
    private $birthday;
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getPasswordConfirm()
    {
        return $this->password_confirm;
    }

    public function setPasswordConfirm($password_confirm): void
    {
        $this->password_confirm = $password_confirm;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTime $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function hydrate($data) {
        if (isset($data['id']))
            $this->setId($data['id']);
        if (isset($data['email']))
            $this->setEmail($data['email']);
        if (isset($data['password']))
            $this->setPassword($data['password']);
        if (isset($data['password_confirm']))
            $this->setPasswordConfirm($data['password_confirm']);
        if (isset($data['firstname']))
            $this->setFirstname($data['firstname']);
        if (isset($data['lastname']))
            $this->setLastname($data['lastname']);
        if (isset($data['birthday']))
            $this->setBirthday($data['birthday']);
        if (isset($data['created_at']))
            $this->setCreatedAt($data['created_at']);
    }

}