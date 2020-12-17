<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Database\Sql;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;

class DatabasePeopleRepository implements UserRepository
{
    private $sql;

    public function __construct(Sql $sql)
    {
        $this->sql = $sql;
    }


    public function findAll(): array
    {
        $stmt = $this->sql->query('SELECT * FROM tb_people');

        return $stmt->fetchAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        $stmt = $this->sql->query('SELECT * FROM tb_people WHERE idperson = :id', [
            'id' => $id
        ]);

        $user = $stmt->fetch();

        if (!$user) {
            throw new UserNotFoundException();
        }

        return new User((int)$user['idperson'], $user['desperson'], $user['desemail'], $user['nrphone'], $user['dtregister']);
    }
}
