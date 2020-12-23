<?php

declare(strict_types=1);

namespace App\Domain\User;

interface NewUserRepository
{
    /**
     * 
     */
    public function findAll(): array;
    public function findUserOfId($iduser): array;
    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
   



    public function login(string $login, string $password);
    public function update($admin,$iduser);
    public function delete($iduser);
    public function save($admin);

}
