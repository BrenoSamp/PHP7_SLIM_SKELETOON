<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\User\Person;
use App\Infrastructure\Persistence\User\DatabaseAdminRepository;

use DI\Container;
use Tests\TestCase;

class ListAdminActionTest extends TestCase
{
    public function testListAdminAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();
        
        $data = [];

        $adminRepositoryProphecy = $this->prophesize(DatabaseAdminRepository::class);
        $adminRepositoryProphecy
            ->findAll()
            ->willReturn($data)
            ->shouldBeCalledOnce();

        $container->set(DatabaseAdminRepository::class, $adminRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/admin/list');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $data);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
