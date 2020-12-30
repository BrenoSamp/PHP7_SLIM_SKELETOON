<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\User\Person;
use App\Infrastructure\Persistence\User\DatabaseAdminRepository;

use DI\Container;
use Tests\TestCase;

class CreateAdminActionTest extends TestCase
{
    public function testCreateAdminAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $data = [
            "desperson" => 'breno_teste',
            "deslogin" => 'teste',
            "despassword" => 'teste123',
            "desemail" => 'emailteste@email.com',
            "nrphone" => '992546960',
            "inadmin" => 1

        ];

        $adminRepositoryProphecy = $this->prophesize(DatabaseAdminRepository::class);
        $adminRepositoryProphecy
            ->save($data)
            ->willReturn($data)
            ->shouldBeCalledOnce();

        $container->set(DatabaseAdminRepository::class, $adminRepositoryProphecy->reveal());

        $req = $this->createRequest('POST', '/admin/create');
        $request = $req->withParsedBody($data);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $data);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

}
