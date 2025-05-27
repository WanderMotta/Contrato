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
 * Entity class for "view_lucro_prejuizo_contratos" table
 */
#[Entity]
#[Table(name: "view_lucro_prejuizo_contratos")]
class ViewLucroPrejuizoContrato extends AbstractEntity
{
    #[Column(type: "string", nullable: true)]
    private ?string $cliente;

    #[Column(name: "`Vr Cobrado R$`", options: ["name" => "Vr Cobrado R$"], type: "decimal")]
    private string $vrCobradoR;

    #[Column(name: "`Custo Calculado R$`", options: ["name" => "Custo Calculado R$"], type: "decimal", nullable: true)]
    private ?string $custoCalculadoR;

    #[Column(name: "`Diferença`", options: ["name" => "Diferença"], type: "decimal", nullable: true)]
    private ?string $diferenca;

    #[Column(name: "Margem", type: "decimal", nullable: true)]
    private ?string $margem;

    #[Column(name: "Resultado", type: "string", nullable: true)]
    private ?string $resultado;

    public function __construct()
    {
        $this->vrCobradoR = "0.00";
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

    public function getVrCobradoR(): string
    {
        return $this->vrCobradoR;
    }

    public function setVrCobradoR(string $value): static
    {
        $this->vrCobradoR = $value;
        return $this;
    }

    public function getCustoCalculadoR(): ?string
    {
        return $this->custoCalculadoR;
    }

    public function setCustoCalculadoR(?string $value): static
    {
        $this->custoCalculadoR = $value;
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

    public function getResultado(): ?string
    {
        return HtmlDecode($this->resultado);
    }

    public function setResultado(?string $value): static
    {
        $this->resultado = RemoveXss($value);
        return $this;
    }
}
