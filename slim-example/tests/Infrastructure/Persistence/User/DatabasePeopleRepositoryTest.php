<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\User\Person;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Infrastructure\Persistence\User\DatabasePeopleRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use Tests\TestCase;
use App\Database\Sql;
use PDOStatement;

class DatabasePeopleRepositoryTest extends TestCase
{
    public function testDatabasePeopleRepositoryFindAll()
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
            ->query('SELECT * FROM tb_people')
            ->willReturn($stmt->reveal())
            ->shouldBeCalledOnce();

        $databasePeopleRepository = new DatabasePeopleRepository($sql->reveal());



        $this->assertEquals($data, $databasePeopleRepository->findAll());
    }

    // public function testFindAllUsersByDefault()
    // {
    //     $person = [
    //         1 => new Person(1, 'breno', 'bsampaio8@hotmail.com', 92838486, '2020-12-23 15:33:00'),
    //         2 => new Person(2, 'billy', 'billy@hotmail.com', 95894093, '2020-12-23 15:33:00'),
    //         3 => new Person(3, 'jhow', 'jhow@hotmail.com', 92475042, '2020-12-23 15:33:00'),
    //     ];

    //     $peopleRepository =  $this->sql->DatabasePeopleRepository();

    //     $this->assertEquals(array_values($person), $peopleRepository->findAll());
    // }

    public function testDatabasePeopleFindUserOfId()
    {

        $data = [
            'id' => 200
        ];

        $stmt = $this->prophesize(PDOStatement::class);
        $stmt
            ->fetch()
            ->willReturn($data)
            ->shouldBeCalledOnce();

        $sql = $this->prophesize(Sql::class);
        $sql
            ->query('SELECT * FROM tb_people WHERE idperson = 200;')
            ->willReturn($stmt->reveal())
            ->shouldBeCalledOnce();

        $user = $stmt;

        $databasePeopleRepository = new DatabasePeopleRepository($sql->reveal());

        $this->assertEquals($data, $databasePeopleRepository->findUserOfId(200));
    }

    // public function testFindUserOfIdThrowsNotFoundException()
    // {
    //     $userRepository = new InMemoryUserRepository([]);
    //     $this->expectException(UserNotFoundException::class);
    //     $userRepository->findUserOfId(1);
    // }
}
