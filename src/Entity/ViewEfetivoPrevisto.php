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
 * Entity class for "view_efetivo_previsto" table
 */
#[Entity]
#[Table(name: "view_efetivo_previsto")]
class ViewEfetivoPrevisto extends AbstractEntity
{
    #[Column(type: "string")]
    private string $cargo;

    #[Column(type: "decimal")]
    private string $salario;

    #[Column(type: "string")]
    private string $escala;

    #[Column(name: "periodo_idperiodo", type: "integer")]
    private int $periodoIdperiodo;

    #[Column(type: "decimal")]
    private string $jornada;

    #[Id]
    #[Column(type: "integer")]
    #[GeneratedValue]
    private int $idcontrato;

    #[Column(type: "string", nullable: true)]
    private ?string $cliente;

    #[Column(type: "integer")]
    private int $quantidade;

    #[Column(type: "string")]
    private string $periodo;

    #[Column(name: "ac_funcao", type: "string")]
    private string $acFuncao;

    #[Column(type: "string")]
    private string $intrajornada;

    public function __construct()
    {
        $this->jornada = "11.00";
        $this->quantidade = 1;
        $this->acFuncao = "Nao";
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

    public function getSalario(): string
    {
        return $this->salario;
    }

    public function setSalario(string $value): static
    {
        $this->salario = $value;
        return $this;
    }

    public function getEscala(): string
    {
        return HtmlDecode($this->escala);
    }

    public function setEscala(string $value): static
    {
        $this->escala = RemoveXss($value);
        return $this;
    }

    public function getPeriodoIdperiodo(): int
    {
        return $this->periodoIdperiodo;
    }

    public function setPeriodoIdperiodo(int $value): static
    {
        $this->periodoIdperiodo = $value;
        return $this;
    }

    public function getJornada(): string
    {
        return $this->jornada;
    }

    public function setJornada(string $value): static
    {
        $this->jornada = $value;
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

    public function getCliente(): ?string
    {
        return HtmlDecode($this->cliente);
    }

    public function setCliente(?string $value): static
    {
        $this->cliente = RemoveXss($value);
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

    public function getPeriodo(): string
    {
        return HtmlDecode($this->periodo);
    }

    public function setPeriodo(string $value): static
    {
        $this->periodo = RemoveXss($value);
        return $this;
    }

    public function getAcFuncao(): string
    {
        return $this->acFuncao;
    }

    public function setAcFuncao(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'ac_funcao' value");
        }
        $this->acFuncao = $value;
        return $this;
    }

    public function getIntrajornada(): string
    {
        return HtmlDecode($this->intrajornada);
    }

    public function setIntrajornada(string $value): static
    {
        $this->intrajornada = RemoveXss($value);
        return $this;
    }
}
