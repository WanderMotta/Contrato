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
 * Entity class for "view_rel_insumos_contratos" table
 */
#[Entity]
#[Table(name: "view_rel_insumos_contratos")]
class ViewRelInsumosContrato extends AbstractEntity
{
    #[Column(type: "string")]
    private string $cliente;

    #[Column(type: "string")]
    private string $insumo;

    #[Column(type: "decimal")]
    private string $frequencia;

    #[Column(type: "decimal")]
    private string $qtde;

    #[Column(name: "`Vr Mensal`", options: ["name" => "Vr Mensal"], type: "decimal", nullable: true)]
    private ?string $vrMensal;

    #[Column(name: "`Vr Total`", options: ["name" => "Vr Total"], type: "decimal", nullable: true)]
    private ?string $vrTotal;

    #[Column(name: "tipo_insumo", type: "string")]
    private string $tipoInsumo;

    #[Column(type: "integer")]
    private int $idcontrato;

    public function __construct()
    {
        $this->frequencia = "12.0";
        $this->qtde = "1.00";
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

    public function getInsumo(): string
    {
        return HtmlDecode($this->insumo);
    }

    public function setInsumo(string $value): static
    {
        $this->insumo = RemoveXss($value);
        return $this;
    }

    public function getFrequencia(): string
    {
        return $this->frequencia;
    }

    public function setFrequencia(string $value): static
    {
        $this->frequencia = $value;
        return $this;
    }

    public function getQtde(): string
    {
        return $this->qtde;
    }

    public function setQtde(string $value): static
    {
        $this->qtde = $value;
        return $this;
    }

    public function getVrMensal(): ?string
    {
        return $this->vrMensal;
    }

    public function setVrMensal(?string $value): static
    {
        $this->vrMensal = $value;
        return $this;
    }

    public function getVrTotal(): ?string
    {
        return $this->vrTotal;
    }

    public function setVrTotal(?string $value): static
    {
        $this->vrTotal = $value;
        return $this;
    }

    public function getTipoInsumo(): string
    {
        return HtmlDecode($this->tipoInsumo);
    }

    public function setTipoInsumo(string $value): static
    {
        $this->tipoInsumo = RemoveXss($value);
        return $this;
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
}
