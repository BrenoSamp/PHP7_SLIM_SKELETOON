<?php
declare(strict_types=1);

namespace App\Domain\User;

interface PeopleRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): Person;
}
