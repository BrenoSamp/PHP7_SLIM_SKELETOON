<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Database\Sql;
use App\Domain\User\Admin;
use App\Domain\User\NewUserRepository;
use App\Domain\User\Person;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;


class DatabaseAdminRepository implements NewUserRepository
{

    private $sql;


    public function __construct(Sql $sql)
    {
        $this->sql = $sql;
    }


    public function findAll(): array
    {
        $stmt = $this->sql->query('SELECT * FROM tb_users a INNER JOIN tb_people b USING(idperson) ORDER BY b.desperson');

        return $stmt->fetchAll();
    }

    /**
     * {@inheritdoc}
     */
    public function login(string $login, string $password)
    {
        $stmt = $this->sql->query('SELECT * FROM tb_users a INNER JOIN tb_people b ON a.idperson = b.idperson WHERE a.deslogin = :LOGIN', [
            'LOGIN' => $login
        ]);

        $admin = $stmt->fetch();

        
        if (!$admin) {
            throw new UserNotFoundException();
        }
        


        if (password_verify($password,$admin['despassword']) === true) {
            $admin['desperson'] = utf8_encode($admin['desperson']);
            return $admin;
        } else {
            
        throw new UserNotFoundException();

         }
    }

    public function get($iduser)
    {
        $stmt = $this->sql->query("SELECT * FROM tb_users a INNER JOIN tb_people b USING(idperson) WHERE a.iduser = :iduser", [
            ":iduser" => $iduser
        ]);

        $data = $stmt->fetch();
        return $data['desperson'];
    }

    public function save($admin)
    {


        $stmt = $this->sql->query("CALL sp_users_save(:desperson, :deslogin, :despassword,:desemail,:nrphone,:inadmin)", [
            ":desperson" => $admin['desperson'],
            ":deslogin" => $admin['deslogin'],
            ":despassword" => $admin['despassword'],
            ":desemail" => $admin['desemail'],
            ":nrphone" => $admin['nrphone'],
            ":inadmin" => $admin['inadmin']

        ]);

        $user = $stmt->fetch();

        return $user;
    }
}
