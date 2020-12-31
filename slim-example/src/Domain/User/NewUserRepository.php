<?php

declare(strict_types=1);

namespace App\Domain\User;

interface NewUserRepository
{
    public function findAll(): array;
    public function findUserOfId($iduser): array;
    public function login(string $login, string $password): array;
    public function update(array $admin,int $iduser): array;
    public function getForgot(string $email,string $userIp);
    public function delete(int $iduser);
    public function save(array $admin): array;
}
