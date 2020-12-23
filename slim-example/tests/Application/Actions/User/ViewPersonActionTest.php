<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\User\Person;
use App\Infrastructure\Persistence\User\DatabasePeopleRepository;
use DI\Container;
use Tests\TestCase;

class ViewPersonActionTest extends TestCase
{
    public function testViewPersonAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $person = new Person(20, 'brenim', 'bsa@email.com', 92754367, '2020-12-22 14:29:00');

        $personRepositoryProphecy = $this->prophesize(DatabasePeopleRepository::class);
        $personRepositoryProphecy
            ->findUserOfId(20)
            ->willReturn($person)
            ->shouldBeCalledOnce();

        $container->set(DatabasePeopleRepository::class, $personRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/people/20');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $person);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
