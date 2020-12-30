<?php

declare(strict_types=1);

namespace App\Domain\User;

use JsonSerializable;

class Admin implements JsonSerializable
{
    /**
     * @var array
     */
    private $iduser;

    private $idperson;

    private $deslogin;

    private $despassword;

    private $inadmin;

    private $dtregister;



    /**
     * @return array
     */

    public function __construct(int $iduser, int $idperson, string $deslogin, string $despassword, int $inadmin, string $dtregister)
    {
        $this->iduser = $iduser;
        $this->idperson = $idperson;
        $this->deslogin = $deslogin;
        $this->despassword = $despassword;
        $this->inadmin = $inadmin;
        $this->dtregister = $dtregister;
    }


    /**
     * @return int
     */
    public function getIduser()
    {

        return $this->iduser;
    }
    /**
     * @return int
     */
    public function getIdperson()
    {
        return $this->idperson;
    }

    /**
     * @return string
     */
    public function getDeslogin()
    {
        return $this->deslogin;
    }

    /**
     * @return string
     */
    public function getDespassword()
    {
        return $this->despassword;
    }


    public function getInadmin()
    {
        return $this->inadmin;
    }
    public function getDtregister(): string
    {
        return $this->dtregister;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'iduser' => $this->iduser,
            'idperson' => $this->idperson,
            'deslogin' => $this->deslogin,
            'despassword' => $this->despassword,
            'inadmin' => $this->inadmin,
            'dtregister' => $this->dtregister,
        ];
    }
}
