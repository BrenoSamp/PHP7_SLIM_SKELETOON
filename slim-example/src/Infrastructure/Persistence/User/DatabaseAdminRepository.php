<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Database\Sql;
use App\Domain\User\Admin;
use App\Domain\User\Mailer;
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
        $stmt = $this->sql->query('SELECT * FROM tb_users a JOIN tb_people b USING(idperson) ORDER BY b.desperson');

        return $stmt->fetchAll();
    }

    public function findUserOfId($iduser): array
    {

        $stmt = $this->sql->query('SELECT * FROM tb_users a JOIN tb_people b USING(idperson) WHERE a.iduser = :iduser', [
            ":iduser" => $iduser
        ]);

        $admin = $stmt->fetch();

        return $admin;
    }

    /**
     * {@inheritdoc}
     */
    public function login(string $login, string $password): array
    {
        $stmt = $this->sql->query(
            "SELECT * FROM tb_users a JOIN tb_people b ON a.idperson = b.idperson WHERE a.deslogin = :LOGIN",
            [
                ":LOGIN"  => $login
            ]
        );

        $admin = $stmt->fetch();

        if (!$admin) {
            throw new UserNotFoundException('Usuário não existe');
        }

        if (password_verify($password, $admin["despassword"])) {
            return $admin;
        } else {
            throw new UserNotFoundException('Usuário ou senha Inválida');
        }
    }

    public function getForgot(string $email, string $userIp): array
    {
        $stmt = $this->sql->query('SELECT * FROM tb_people a JOIN tb_users b USING(idperson) WHERE a.desemail = :email', [
            ":email" => $email
        ]);

        $user = $stmt->fetch();

        $stmt2 = $this->sql->query("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)", [
            ":iduser" => $user['iduser'],
            ":desip" => $userIp
        ]);

         $dataRecovery = $stmt2->fetch();
        // $dataRecovery['idrecovery'] = password_hash($dataRecovery['idrecovery'], PASSWORD_DEFAULT, ['cost' => 12]);

        $mailer = new Mailer($user['desemail'], $user['desperson'], "Recuperar Senha", $dataRecovery['idrecovery']);

        $mailer->send();

        if (!$mailer->send()) {
            echo "Message was not sent";
        }

        return $user;
    }

    public function validForgotDecrypt(int $idrecovery):array 
    {
        $stmt = $this->sql->query('SELECT * FROM tb_userspasswordsrecoveries a JOIN tb_users b USING(iduser) JOIN tb_people c USING(idperson)
        WHERE 
            a.idrecovery = :idrecovery
            AND
            DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW();
    ', [
            ":idrecovery" => $idrecovery
    ]);
    
    $result = $stmt->fetch();

    return $result;

    }

    public function setForgotUser($idrecovery)
    {
        $this->sql->query('UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW() WHERE idrecovery = :idrecovery', [
            ":idrecovery" => $idrecovery
        ]);
    }

    public function setPassword($password,$iduser)
	{
		$this->sql->query("UPDATE tb_users SET despassword = :password WHERE iduser = :iduser", array(
			":password"=>$password,
			":iduser"=>$iduser
		));
	}




    public function save(array $admin): array
    {


        $stmt = $this->sql->query("CALL sp_users_save(:desperson, :deslogin, :despassword,:desemail,:nrphone,:inadmin)", [
            ":desperson" => $admin['desperson'],
            ":deslogin" => $admin['deslogin'],
            ":despassword" => $admin['despassword'],
            ":desemail" => $admin['desemail'],
            ":nrphone" => $admin['nrphone'],
            ":inadmin" => $admin['inadmin']

        ]);

        $admin = $stmt->fetch();

        return $admin;
    }


    public function update(array $admin, int $iduser): array
    {
        $stmt = $this->sql->query("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword,:desemail,:nrphone,:inadmin)", [
            ":iduser" => $iduser,
            ":desperson" => $admin['desperson'],
            ":deslogin" => $admin['deslogin'],
            ":despassword" => $admin['despassword'],
            ":desemail" => $admin['desemail'],
            ":nrphone" => $admin['nrphone'],
            ":inadmin" => $admin['inadmin']

        ]);

        $admin =  $stmt->fetch();

        return $admin;
    }


    public function delete($iduser)
    {
        $this->sql->query('CALL sp_users_delete(:iduser)', [
            ":iduser" => $iduser
        ]);
    }
}
