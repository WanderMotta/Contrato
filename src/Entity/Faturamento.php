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
 * Entity class for "faturamento" table
 */
#[Entity]
#[Table(name: "faturamento")]
class Faturamento extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idfaturamento;

    #[Column(type: "string")]
    private string $faturamento;

    #[Column(type: "string")]
    private string $cnpj;

    #[Column(type: "string")]
    private string $endereco;

    #[Column(type: "string")]
    private string $bairro;

    #[Column(type: "string")]
    private string $cidade;

    #[Column(type: "string")]
    private string $uf;

    #[Column(name: "dia_vencimento", type: "integer")]
    private int $diaVencimento;

    #[Column(type: "string")]
    private string $origem;

    #[Column(type: "text", nullable: true)]
    private ?string $obs;

    #[Column(name: "cliente_idcliente", type: "integer")]
    private int $clienteIdcliente;

    public function __construct()
    {
        $this->cidade = "São Paulo";
        $this->uf = "SP";
        $this->diaVencimento = 10;
        $this->origem = "Condominio";
    }

    public function getIdfaturamento(): int
    {
        return $this->idfaturamento;
    }

    public function setIdfaturamento(int $value): static
    {
        $this->idfaturamento = $value;
        return $this;
    }

    public function getFaturamento(): string
    {
        return HtmlDecode($this->faturamento);
    }

    public function setFaturamento(string $value): static
    {
        $this->faturamento = RemoveXss($value);
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

    public function getEndereco(): string
    {
        return HtmlDecode($this->endereco);
    }

    public function setEndereco(string $value): static
    {
        $this->endereco = RemoveXss($value);
        return $this;
    }

    public function getBairro(): string
    {
        return HtmlDecode($this->bairro);
    }

    public function setBairro(string $value): static
    {
        $this->bairro = RemoveXss($value);
        return $this;
    }

    public function getCidade(): string
    {
        return HtmlDecode($this->cidade);
    }

    public function setCidade(string $value): static
    {
        $this->cidade = RemoveXss($value);
        return $this;
    }

    public function getUf(): string
    {
        return HtmlDecode($this->uf);
    }

    public function setUf(string $value): static
    {
        $this->uf = RemoveXss($value);
        return $this;
    }

    public function getDiaVencimento(): int
    {
        return $this->diaVencimento;
    }

    public function setDiaVencimento(int $value): static
    {
        $this->diaVencimento = $value;
        return $this;
    }

    public function getOrigem(): string
    {
        return $this->origem;
    }

    public function setOrigem(string $value): static
    {
        if (!in_array($value, ["Condominio", "Administradora"])) {
            throw new \InvalidArgumentException("Invalid 'origem' value");
        }
        $this->origem = $value;
        return $this;
    }

    public function getObs(): ?string
    {
        return HtmlDecode($this->obs);
    }

    public function setObs(?string $value): static
    {
        $this->obs = RemoveXss($value);
        return $this;
    }

    public function getClienteIdcliente(): int
    {
        return $this->clienteIdcliente;
    }

    public function setClienteIdcliente(int $value): static
    {
        $this->clienteIdcliente = $value;
        return $this;
    }
}
