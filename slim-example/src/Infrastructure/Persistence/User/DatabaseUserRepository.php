<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Database\Sql;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;

class DatabaseUserRepository implements UserRepository
{
    private $sql;

    public function __construct(Sql $sql)
    {
        $this->sql = $sql;
    }


    public function findAll(): array
    {
        $stmt = $this->sql->query('SELECT * FROM usuarios');

        return $stmt->fetchAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        $stmt = $this->sql->query('SELECT * FROM usuarios WHERE id = :idusuario', [
            'idusuario' => $id
        ]);

        $user = $stmt->fetch();

        if (!$user) {
            throw new UserNotFoundException();
        }

        return new User((int)$user['id'], $user['username'], $user['firstname'], $user['lastname']);
    }
}
