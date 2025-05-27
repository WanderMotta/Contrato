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
 * Entity class for "view_contratos" table
 */
#[Entity]
#[Table(name: "view_contratos")]
class ViewContrato extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer")]
    private int $idcontrato;

    #[Column(type: "string")]
    private string $cliente;

    #[Column(type: "decimal")]
    private string $valor;

    #[Column(type: "string")]
    private string $ativo;

    #[Column(type: "integer")]
    private int $quantidade;

    #[Column(type: "string")]
    private string $cargo;

    #[Column(name: "acumulo_funcao", type: "string")]
    private string $acumuloFuncao;

    #[Column(type: "string")]
    private string $escala;

    #[Column(type: "string")]
    private string $periodo;

    #[Column(type: "decimal")]
    private string $jornada;

    #[Column(type: "decimal")]
    private string $salario;

    #[Column(name: "intrajornada_tipo", type: "string")]
    private string $intrajornadaTipo;

    #[Column(type: "decimal")]
    private string $insumos;

    #[Column(type: "string")]
    private string $cnpj;

    #[Column(type: "string", nullable: true)]
    private ?string $contato;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "string", nullable: true)]
    private ?string $telefone;

    #[Column(type: "string", nullable: true)]
    private ?string $endereco;

    public function __construct()
    {
        $this->valor = "0.00";
        $this->ativo = "Sim";
        $this->quantidade = 1;
        $this->acumuloFuncao = "Nao";
        $this->jornada = "11.00";
        $this->insumos = "0.00";
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

    public function getValor(): string
    {
        return $this->valor;
    }

    public function setValor(string $value): static
    {
        $this->valor = $value;
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

    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $value): static
    {
        $this->quantidade = $value;
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

    public function getAcumuloFuncao(): string
    {
        return $this->acumuloFuncao;
    }

    public function setAcumuloFuncao(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'acumulo_funcao' value");
        }
        $this->acumuloFuncao = $value;
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

    public function getPeriodo(): string
    {
        return HtmlDecode($this->periodo);
    }

    public function setPeriodo(string $value): static
    {
        $this->periodo = RemoveXss($value);
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

    public function getSalario(): string
    {
        return $this->salario;
    }

    public function setSalario(string $value): static
    {
        $this->salario = $value;
        return $this;
    }

    public function getIntrajornadaTipo(): string
    {
        return HtmlDecode($this->intrajornadaTipo);
    }

    public function setIntrajornadaTipo(string $value): static
    {
        $this->intrajornadaTipo = RemoveXss($value);
        return $this;
    }

    public function getInsumos(): string
    {
        return $this->insumos;
    }

    public function setInsumos(string $value): static
    {
        $this->insumos = $value;
        return $this;
    }

    public function getCnpj(): string
    {
        return HtmlDecode($this->cnpj);
    }

    public function setCnpj(string $value): static
    {
        $this->cnpj = RemoveXss($value);
        return $this;
    }

    public function getContato(): ?string
    {
        return HtmlDecode($this->contato);
    }

    public function setContato(?string $value): static
    {
        $this->contato = RemoveXss($value);
        return $this;
    }

    public function getEmail(): ?string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(?string $value): static
    {
        $this->email = RemoveXss($value);
        return $this;
    }

    public function getTelefone(): ?string
    {
        return HtmlDecode($this->telefone);
    }

    public function setTelefone(?string $value): static
    {
        $this->telefone = RemoveXss($value);
        return $this;
    }

    public function getEndereco(): ?string
    {
        return HtmlDecode($this->endereco);
    }

    public function setEndereco(?string $value): static
    {
        $this->endereco = RemoveXss($value);
        return $this;
    }
}
