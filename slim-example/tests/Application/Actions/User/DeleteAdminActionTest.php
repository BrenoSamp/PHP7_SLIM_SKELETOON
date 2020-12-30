<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\User\Person;
use App\Infrastructure\Persistence\User\DatabaseAdminRepository;

use DI\Container;
use Tests\TestCase;

class DeleteAdminActionTest extends TestCase
{

    
    public function testDeleteAdminAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();
        
        $adminRepositoryProphecy = $this->prophesize(DatabaseAdminRepository::class);
        $adminRepositoryProphecy
            ->delete(19)
            ->willReturn()
            ->shouldBeCalledOnce();

        $container->set(DatabaseAdminRepository::class, $adminRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/admin/delete/19');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
