<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Database\Sql;
use App\Domain\User\PeopleRepository;
use App\Domain\User\Person;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;


class DatabasePeopleRepository implements PeopleRepository
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
    public function findUserOfId(int $id): Person
    {
        $stmt = $this->sql->query('SELECT * FROM tb_people WHERE idperson = :id', [
            'id' => $id
        ]);

        $user = $stmt->fetch();

        if (!$user) {
            throw new UserNotFoundException();
        }

        return new Person($user['idperson'], $user['desperson'], $user['desemail'], $user['nrphone'], $user['dtregister']);
    }
}
