<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\Admin;
use App\Domain\User\User;
use Tests\TestCase;

class AdminTest extends TestCase
{
    public function adminProvider()
    {
        return [
            [19, 548, 'brenao_cabuloso', '5678', 1, '2020-12-21 17:10:30'],
            [20, 549, 'brenao', '9012', 1, '2020-12-21 17:10:30'],
            [21, 550, 'brenim', '3456', 1, '2020-12-21 17:10:30'],
            [22, 551, 'brenato', '7890', 1, '2020-12-21 17:10:30']
        ];
    }

    /**
     * @dataProvider adminProvider
     * @param int    $iduser
     * @param int    $idperson
     * @param string $deslogin
     * @param string $despassword
     * @param bool $inadmin
     * @param string $dtregister
     */
    public function testAdminGetters(int $iduser, int $idperson, string $deslogin, string $despassword, int $inadmin, string $dtregister)
    {
        $admin = new Admin($iduser, $idperson, $deslogin, $despassword, $inadmin, $dtregister);

        $this->assertEquals($iduser, $admin->getIduser());
        $this->assertEquals($idperson, $admin->getIdperson());
        $this->assertEquals($deslogin, $admin->getDeslogin());
        $this->assertEquals($despassword, $admin->getDespassword());
        $this->assertEquals($inadmin, $admin->getInadmin());
        $this->assertEquals($dtregister, $admin->getDtregister());
    }

    /**
     * @dataProvider adminProvider
     * @param int    $iduser
     * @param int    $idperson
     * @param string $deslogin
     * @param string $despassword
     * @param int    $inadmin
     * @param string $dtregister
     */
    public function testAdminJsonSerialize(int $iduser, int $idperson, string $deslogin, string $despassword, int $inadmin, string $dtregister)
    {
        $admin = new Admin($iduser, $idperson, $deslogin, $despassword, $inadmin, $dtregister);

        $expectedPayload = json_encode([
            'iduser' => $iduser,
            'idperson' => $idperson,
            'deslogin' => $deslogin,
            'despassword' => $despassword,
            'inadmin' => $inadmin,
            'dtregister' => $dtregister
        ]);

        $this->assertEquals($expectedPayload, json_encode($admin));
    }
}
