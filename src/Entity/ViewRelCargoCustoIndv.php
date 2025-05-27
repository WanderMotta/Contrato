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
 * Entity class for "view_rel_cargo_custo_indv" table
 */
#[Entity]
#[Table(name: "view_rel_cargo_custo_indv")]
class ViewRelCargoCustoIndv extends AbstractEntity
{
    #[Column(type: "integer")]
    private int $idcontrato;

    #[Column(type: "string")]
    private string $cliente;

    #[Column(name: "vr_contrato", type: "decimal")]
    private string $vrContrato;

    #[Column(type: "string")]
    private string $cargo;

    #[Column(type: "integer")]
    private int $idmodulo;

    #[Column(type: "string")]
    private string $modulo;

    #[Column(name: "cargo_idcargo", type: "integer")]
    private int $cargoIdcargo;

    #[Column(type: "integer")]
    private int $quantidade;

    #[Column(type: "decimal")]
    private string $valor;

    #[Column(type: "decimal", nullable: true)]
    private ?string $total;

    public function __construct()
    {
        $this->idcontrato = 000;
        $this->vrContrato = "0.00";
        $this->idmodulo = 00;
        $this->quantidade = 1;
        $this->valor = "0.00";
    }

    public function getIdcontrato(): int
    {
        return $this->idcontrato;
    }

    public function setIdcontrato(int $value): static
    {
        $this->idcontrato = $value;
        return $this;
    }

    public function getCliente(): string
    {
        return HtmlDecode($this->cliente);
    }

    public function setCliente(string $value): static
    {
        $this->cliente = RemoveXss($value);
        return $this;
    }

    public function getVrContrato(): string
    {
        return $this->vrContrato;
    }

    public function setVrContrato(string $value): static
    {
        $this->vrContrato = $value;
        return $this;
    }

    public function getCargo(): string
    {
        return HtmlDecode($this->cargo);
    }

    public function setCargo(string $value): static
    {
        $this->cargo = RemoveXss($value);
        return $this;
    }

    public function getIdmodulo(): int
    {
        return $this->idmodulo;
    }

    public function setIdmodulo(int $value): static
    {
        $this->idmodulo = $value;
        return $this;
    }

    public function getModulo(): string
    {
        return HtmlDecode($this->modulo);
    }

    public function setModulo(string $value): static
    {
        $this->modulo = RemoveXss($value);
        return $this;
    }

    public function getCargoIdcargo(): int
    {
        return $this->cargoIdcargo;
    }

    public function setCargoIdcargo(int $value): static
    {
        $this->cargoIdcargo = $value;
        return $this;
    }

    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $value): static
    {
        $this->quantidade = $value;
        return $this;
    }

    public function getValor(): string
    {
        return $this->valor;
    }

    public function setValor(string $value): static
    {
        $this->valor = $value;
        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(?string $value): static
    {
        $this->total = $value;
        return $this;
    }
}
