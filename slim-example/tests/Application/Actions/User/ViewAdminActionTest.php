<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\User\Person;
use App\Infrastructure\Persistence\User\DatabaseAdminRepository;

use DI\Container;
use Tests\TestCase;

class ViewAdminActionTest extends TestCase
{
    public function testViewAdminAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $iduser = 19;

        $data = [
            "idperson" => 548,
            "iduser" => $iduser,
            "deslogin" => 'teste',
            "despassword" => 'teste123',
            "inadmin" => 1,
            "dtregister" => "2020-12-22 20:15:34",
            "desperson" => 'breno_teste',
            "desemail" => 'emailteste@email.com',
            "nrphone" => '992546960'
        ];

        $newData = [
            "iduser" => $iduser,
            "desperson" => 'breno_teste',
            "deslogin" => 'teste',
            "despassword" => 'teste123',
            "desemail" => 'emailteste@email.com',
            "nrphone" => '992546960',
            "inadmin" => 1

        ];

        $adminRepositoryProphecy = $this->prophesize(DatabaseAdminRepository::class);
        $adminRepositoryProphecy
            ->update($newData, $iduser)
            ->willReturn($data)
            ->shouldBeCalledOnce();

        $container->set(DatabaseAdminRepository::class, $adminRepositoryProphecy->reveal());

        $request = $this->createRequest('POST', '/admin/list/19', [
            'data' => [
                "idperson" => 548,
                "iduser" => $iduser,
                "deslogin" => 'teste',
                "despassword" => 'teste123',
                "inadmin" => 1,
                "dtregister" => "2020-12-22 20:15:34",
                "desperson" => 'breno_teste',
                "desemail" => 'emailteste@email.com',
                "nrphone" => '992546960'
            ]
        ]);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $newData);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testViewPersonActionPostman()
    {
        $app = $this->getAppInstance();

        $person = new Person('200', 'marciao', 'marcio@hotmail.com', '997326590', '2011-03-12 00:00:00');

        $request = $this->createRequest('GET', '/people/200');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $person);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
