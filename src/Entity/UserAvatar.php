<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class UserAvatar
{
    private int $id;
    private ?string $avatar;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public static function findById(int $userId): self
    {
        $req = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT id, avatar
            FROM user
            WHERE id = :id
            SQL
        );
        $req->execute(['id' => $userId]);
        $res = $req->fetchObject(UserAvatar::class);
        if (false === $res) {
            throw new EntityNotFoundException('Aucun utilisateur trouvé');
        }

        return $res;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;
        $this->save();
        return $this;
    }

    public function save(): self
    {
        $req = MyPdo::getInstance()->prepare(
            <<<'SQL'
            UPDATE user
            SET avatar = :avatar
            WHERE id = :login
            SQL
        );
        $req->execute(['login' => $this->getId(), 'avatar' => $this->getAvatar()]);
        return $this;
    }
}
