<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class User
{
    private int $id;
    private string $lastName;
    private string $firstName;
    private string $login;
    private string $phone;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public static function findByCredentials(string $login, string $password): self
    {
        $req = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT id, lastName, firstName, login, phone
            FROM user
            WHERE login = :login AND sha512pass = SHA2(:password,512)
            SQL
        );
        $req->execute(['login' => $login, 'password' => $password]);
        $res = $req->fetchObject(User::class);
        if (false === $res) {
            throw new EntityNotFoundException('Aucun utilisateur trouvé');
        }

        return $res;
    }
}
