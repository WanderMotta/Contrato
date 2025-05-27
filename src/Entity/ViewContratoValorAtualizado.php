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
 * Entity class for "view_contrato_valor_atualizado" table
 */
#[Entity]
#[Table(name: "view_contrato_valor_atualizado")]
class ViewContratoValorAtualizado extends AbstractEntity
{
    #[Column(type: "integer")]
    private int $idcontrato;

    #[Column(type: "string")]
    private string $cliente;

    #[Column(name: "vr_cobrado_anterior", type: "decimal")]
    private string $vrCobradoAnterior;

    #[Column(name: "valor_reajustado", type: "decimal", nullable: true)]
    private ?string $valorReajustado;

    #[Column(type: "decimal", nullable: true)]
    private ?string $diferenca;

    #[Column(type: "decimal", nullable: true)]
    private ?string $margem;

    public function __construct()
    {
        $this->idcontrato = 000;
        $this->vrCobradoAnterior = "0.00";
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

    public function getVrCobradoAnterior(): string
    {
        return $this->vrCobradoAnterior;
    }

    public function setVrCobradoAnterior(string $value): static
    {
        $this->vrCobradoAnterior = $value;
        return $this;
    }

    public function getValorReajustado(): ?string
    {
        return $this->valorReajustado;
    }

    public function setValorReajustado(?string $value): static
    {
        $this->valorReajustado = $value;
        return $this;
    }

    public function getDiferenca(): ?string
    {
        return $this->diferenca;
    }

    public function setDiferenca(?string $value): static
    {
        $this->diferenca = $value;
        return $this;
    }

    public function getMargem(): ?string
    {
        return $this->margem;
    }

    public function setMargem(?string $value): static
    {
        $this->margem = $value;
        return $this;
    }
}
