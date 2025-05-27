<?php

namespace PHPMaker2024\contratos\Entity;

use DateTime;
use DateTimeImmutable;
use DateInterval;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\DBAL\Types\Types;
use PHPMaker2024\contratos\AbstractEntity;
use PHPMaker2024\contratos\AdvancedSecurity;
use PHPMaker2024\contratos\UserProfile;
use function PHPMaker2024\contratos\Config;
use function PHPMaker2024\contratos\EntityManager;
use function PHPMaker2024\contratos\RemoveXss;
use function PHPMaker2024\contratos\HtmlDecode;
use function PHPMaker2024\contratos\EncryptPassword;

/**
 * Entity class for "view_export_previsto" table
 */
#[Entity]
#[Table(name: "view_export_previsto")]
class ViewExportPrevisto extends AbstractEntity
{
    #[Column(type: "integer", nullable: true)]
    private ?int $idcliente;

    #[Column(type: "string", nullable: true)]
    private ?string $cliente;

    #[Column(name: "local_idlocal", type: "integer", nullable: true)]
    private ?int $localIdlocal;

    #[Column(type: "string", nullable: true)]
    private ?string $cargo;

    #[Column(name: "funcao_idfuncao", type: "integer", nullable: true)]
    private ?int $funcaoIdfuncao;

    #[Column(type: "decimal", nullable: true)]
    private ?string $qtde;

    public function __construct()
    {
        $this->idcliente = 000;
    }

    public function getIdcliente(): ?int
    {
        return $this->idcliente;
    }

    public function setIdcliente(?int $value): static
    {
        $this->idcliente = $value;
        return $this;
    }

    public function getCliente(): ?string
    {
        return HtmlDecode($this->cliente);
    }

    public function setCliente(?string $value): static
    {
        $this->cliente = RemoveXss($value);
        return $this;
    }

    public function getLocalIdlocal(): ?int
    {
        return $this->localIdlocal;
    }

    public function setLocalIdlocal(?int $value): static
    {
        $this->localIdlocal = $value;
        return $this;
    }

    public function getCargo(): ?string
    {
        return HtmlDecode($this->cargo);
    }

    public function setCargo(?string $value): static
    {
        $this->cargo = RemoveXss($value);
        return $this;
    }

    public function getFuncaoIdfuncao(): ?int
    {
        return $this->funcaoIdfuncao;
    }

    public function setFuncaoIdfuncao(?int $value): static
    {
        $this->funcaoIdfuncao = $value;
        return $this;
    }

    public function getQtde(): ?string
    {
        return $this->qtde;
    }

    public function setQtde(?string $value): static
    {
        $this->qtde = $value;
        return $this;
    }
}
