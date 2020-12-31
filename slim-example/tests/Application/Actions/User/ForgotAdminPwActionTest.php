<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Infrastructure\Persistence\User\DatabaseAdminRepository;

use DI\Container;
use Tests\TestCase;

class AdminForgotActionTest extends TestCase
{

    public function testAdminRecoveryPasswordWithExistentAdminEmail()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $params = [
            'email' => 'bsampaio8@hotmail.com'
        ];
        $ipAddress = '177.44.64.255';

        $data = [
            "idperson" => 552,
            "desperson" => "Mirian",
            "desemail" => "bsampaio8@hotmail.com",
            "nrphone" => "998370102",
            "dtregister" => "2020-12-30 23:42:33",
            "iduser" => 23,
            "deslogin" => "mirianrf_",
            "despassword" => "3012",
            "inadmin" => 1
        ];

        $adminRepositoryMock = $this->createMock(DatabaseAdminRepository::class);
        $adminRepositoryMock
            ->expects($this->once())
            ->method('getForgot')
            ->with($params['email'], $ipAddress)
            ->willReturn($data);

        $container->set(DatabaseAdminRepository::class, $adminRepositoryMock);

        $req = $this->createRequest('POST', '/admin/login/forgot');
        $request = $req->withParsedBody($params);
        $request = $request->withHeader('True-Client-Ip', $ipAddress);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $data);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
