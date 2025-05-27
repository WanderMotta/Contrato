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
 * Entity class for "itens_modulo" table
 */
#[Entity]
#[Table(name: "itens_modulo")]
class ItensModulo extends AbstractEntity
{
    #[Id]
    #[Column(name: "iditens_modulo", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $iditensModulo;

    #[Column(name: "modulo_idmodulo", type: "integer")]
    private int $moduloIdmodulo;

    #[Column(type: "string")]
    private string $item;

    #[Column(name: "porcentagem_valor", type: "decimal")]
    private string $porcentagemValor;

    #[Column(name: "incidencia_inss", type: "string")]
    private string $incidenciaInss;

    #[Column(type: "string")]
    private string $ativo;

    public function __construct()
    {
        $this->incidenciaInss = "Sim";
        $this->ativo = "Sim";
    }

    public function getIditensModulo(): int
    {
        return $this->iditensModulo;
    }

    public function setIditensModulo(int $value): static
    {
        $this->iditensModulo = $value;
        return $this;
    }

    public function getModuloIdmodulo(): int
    {
        return $this->moduloIdmodulo;
    }

    public function setModuloIdmodulo(int $value): static
    {
        $this->moduloIdmodulo = $value;
        return $this;
    }

    public function getItem(): string
    {
        return HtmlDecode($this->item);
    }

    public function setItem(string $value): static
    {
        $this->item = RemoveXss($value);
        return $this;
    }

    public function getPorcentagemValor(): string
    {
        return $this->porcentagemValor;
    }

    public function setPorcentagemValor(string $value): static
    {
        $this->porcentagemValor = $value;
        return $this;
    }

    public function getIncidenciaInss(): string
    {
        return $this->incidenciaInss;
    }

    public function setIncidenciaInss(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'incidencia_inss' value");
        }
        $this->incidenciaInss = $value;
        return $this;
    }

    public function getAtivo(): string
    {
        return $this->ativo;
    }

    public function setAtivo(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'ativo' value");
        }
        $this->ativo = $value;
        return $this;
    }
}
