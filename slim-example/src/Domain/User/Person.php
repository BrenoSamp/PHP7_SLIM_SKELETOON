<?php
declare(strict_types=1);

namespace App\Domain\User;

use JsonSerializable;

class Person implements JsonSerializable
{
    /**
     * @var int
     */
    private $idperson;

    /**
     * @var string
     */
    private $desperson;

    /**
     * @var bool
     */
    private $desemail;

    private $nrphone;

    private $dtregister;


    public function __construct($idperson, $desperson ,$desemail, $nrphone, $dtregister )
    {
        $this->idperson = $idperson;
        $this->desperson = $desperson;
        $this->desemail = $desemail;
        $this->nrphone = $nrphone;
        $this->dtregister = $dtregister;

    }

    /**
     * @return int|null
     */
    public function getIdperson(): ?int
    {
        return $this->idperson;
    }

    /**
     * @return string
     */
    public function getDesperson(): string
    {
        return $this->desperson;
    }

    /**
     * @return string
     */
    public function getDesemail()
    {
        return $this->desemail;
    }

    public function getNrphone()
    {
        return $this->nrphone;
    }

    public function getDtregister()
    {
        return $this->dtregister;
    }


    

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'idperson' => $this->idperson,
            'desperson' => $this->desperson,
            'desemail' => $this->desemail,
            'nrphone' => $this->nrphone,
            'dtregister' => $this->dtregister
        ];
    }
}
