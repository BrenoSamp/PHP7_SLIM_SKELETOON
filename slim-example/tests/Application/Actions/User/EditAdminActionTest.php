<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\User\Person;
use App\Infrastructure\Persistence\User\DatabaseAdminRepository;

use DI\Container;
use Tests\TestCase;

class EditAdminActionTest extends TestCase
{
    public function testViewAdminAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $iduser = 19;


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
            ->willReturn($newData)
            ->shouldBeCalledOnce();

        $container->set(DatabaseAdminRepository::class, $adminRepositoryProphecy->reveal());

        $req = $this->createRequest('POST', '/admin/list/19',);
        $request = $req->withParsedBody($newData);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $newData);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
