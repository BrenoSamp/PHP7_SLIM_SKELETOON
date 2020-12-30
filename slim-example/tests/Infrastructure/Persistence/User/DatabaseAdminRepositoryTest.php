<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;


use App\Domain\User\UserNotFoundException;
use App\Infrastructure\Persistence\User\DatabaseAdminRepository;
use Tests\TestCase;
use App\Database\Sql;
use PDOStatement;

class DatabaseAdminRepositoryTest extends TestCase
{
    public function testDatabaseAdminRepositoryFindAll()
    {
        $data = [
            [
                'id' => 1
            ]
        ];

        $stmt = $this->prophesize(PDOStatement::class);
        $stmt
            ->fetchAll()
            ->willReturn($data)
            ->shouldBeCalledOnce();

        $sql =  $this->prophesize(Sql::class);
        $sql
            ->query('SELECT * FROM tb_users a INNER JOIN tb_people b USING(idperson) ORDER BY b.desperson')
            ->willReturn($stmt->reveal())
            ->shouldBeCalledOnce();

        $databaseAdminRepository = new DatabaseAdminRepository($sql->reveal());





        $this->assertEquals($data, $databaseAdminRepository->findAll());
    }



    public function testDatabaseAdminRepositoryFindUserOfId()
    {
        $data = [
            'iduser' => 19
        ];

        $stmt = $this->prophesize(PDOStatement::class);
        $stmt
            ->fetch()
            ->willReturn($data)
            ->shouldBeCalledOnce();

        $sql = $this->prophesize(Sql::class);
        $sql
            ->query('SELECT * FROM tb_users a INNER JOIN tb_people b USING(idperson) WHERE a.iduser = :iduser', [
                ':iduser' => 19
            ])
            ->willReturn($stmt->reveal())
            ->shouldBeCalledOnce();

        $databaseAdminRepository = new DatabaseAdminRepository($sql->reveal());

        $this->assertEquals($data, $databaseAdminRepository->findUserOfId(19));
    }

    public function testDatabaseAdminRepositoryLogin()
    {
        $login = 'brenao_cabuloso';
        $password = '5678';

        $data = [
            'iduser' => 19,
            'idperson' => 548,
            'deslogin' => $login,
            'despassword' => '$2y$12$gOgOMv/BUdGyGHBzY/Z2Q.fm5/mA7YxK4Wx7HrpkzKKfTkkZT1wvG',
            'inadmin' => 1,
            'dtregister' => '2020-12-21 17:10:30',
            'desperson' => 'brenovisk',

        ];

        $stmt = $this->prophesize(PDOStatement::class);
        $stmt
            ->fetch()
            ->willReturn($data)
            ->shouldBeCalledOnce();

        $sql =  $this->prophesize(Sql::class);
        $sql
            ->query('SELECT * FROM tb_users a JOIN tb_people b ON a.idperson = b.idperson WHERE a.deslogin = :LOGIN', [
                ":LOGIN" => $login
            ])
            ->willReturn($stmt->reveal())
            ->shouldBeCalledOnce();

        $databaseAdminRepository = new DatabaseAdminRepository($sql->reveal());

        $this->assertEquals($data, $databaseAdminRepository->login($login, $password));
    }

    public function testDatabaseAdminRepositorySave()
    {
        $data = [
            'desperson' => 'brenim',
            'deslogin' => 'brenim22',
            'despassword' => '12345',
            'desemail' => 'brenosampaio@gmail.com',
            'nrphone' => 31997326590,
            'dtregister' => '2020-12-21 17:10:30',
            'inadmin' => 1,

        ];

        $stmt = $this->prophesize(PDOStatement::class);
        $stmt
            ->fetch()
            ->willReturn($data)
            ->shouldBeCalledOnce();

        $sql =  $this->prophesize(Sql::class);
        $sql
            ->query('CALL sp_users_save(:desperson, :deslogin, :despassword,:desemail,:nrphone,:inadmin)', [
                ":desperson" => $data['desperson'],
                ":deslogin" => $data['deslogin'],
                ":despassword" => $data['despassword'],
                ":desemail" => $data['desemail'],
                ":nrphone" => $data['nrphone'],
                ":inadmin" => $data['inadmin']
            ])
            ->willReturn($stmt->reveal())
            ->shouldBeCalledOnce();

        $databaseAdminRepository = new DatabaseAdminRepository($sql->reveal());

        $this->assertEquals($data, $databaseAdminRepository->save($data));
    }

    public function testDatabaseAdminRepositoryUpdate()
    {
        $iduser = 19;

        $data = [
            'iduser' => 22,
            'desperson' => 'brenim',
            'deslogin' => 'brenim22',
            'despassword' => '12345',
            'desemail' => 'brenosampaio@gmail.com',
            'nrphone' => 31997326590,
            'dtregister' => '2020-12-21 17:10:30',
            'inadmin' => 1,

        ];

        $stmt = $this->prophesize(PDOStatement::class);
        $stmt
            ->fetch()
            ->willReturn($data)
            ->shouldBeCalledOnce();

        $sql =  $this->prophesize(Sql::class);
        $sql
            ->query("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword,:desemail,:nrphone,:inadmin)", [
                ":iduser" => $iduser,
                ":desperson" => $data['desperson'],
                ":deslogin" => $data['deslogin'],
                ":despassword" => $data['despassword'],
                ":desemail" => $data['desemail'],
                ":nrphone" => $data['nrphone'],
                ":inadmin" => $data['inadmin']
            ])
            ->willReturn($stmt->reveal())
            ->shouldBeCalledOnce();

        $databaseAdminRepository = new DatabaseAdminRepository($sql->reveal());

        $this->assertEquals($data, $databaseAdminRepository->update($data, $iduser));
    }

    public function testDatabaseAdminRepositoryDelete()
    {
        $iduser = 19;

        $sql =  $this->prophesize(Sql::class);
        $sql
            ->query('CALL sp_users_delete(:iduser)', [
                ":iduser" => $iduser
            ])
            ->willReturn()
            ->shouldBeCalledOnce();

        $databaseAdminRepository = new DatabaseAdminRepository($sql->reveal());

        $databaseAdminRepository->delete($iduser);
    }



    // public function testFindUserOfIdThrowsNotFoundException()
    // {
    //     $userRepository = new InMemoryUserRepository([]);
    //     $this->expectException(UserNotFoundException::class);
    //     $userRepository->findUserOfId(1);
    // }
}
