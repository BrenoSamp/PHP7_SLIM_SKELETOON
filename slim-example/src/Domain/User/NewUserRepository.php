<?php

declare(strict_types=1);

namespace App\Domain\User;

interface NewUserRepository
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
   



    public function login(string $login, string $password);
    public function get($iduser);
    public function save($admin);

}
