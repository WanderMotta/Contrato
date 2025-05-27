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
 * Entity class for "cliente" table
 */
#[Entity]
#[Table(name: "cliente")]
class Cliente extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idcliente;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(type: "string")]
    private string $cliente;

    #[Column(name: "local_idlocal", type: "integer")]
    private int $localIdlocal;

    #[Column(type: "string")]
    private string $cnpj;

    #[Column(type: "string")]
    private string $endereco;

    #[Column(type: "string")]
    private string $numero;

    #[Column(type: "string")]
    private string $bairro;

    #[Column(type: "string")]
    private string $cep;

    #[Column(type: "string")]
    private string $cidade;

    #[Column(type: "string")]
    private string $uf;

    #[Column(type: "string", nullable: true)]
    private ?string $contato;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "string", nullable: true)]
    private ?string $telefone;

    #[Column(type: "string")]
    private string $ativo;

    public function __construct()
    {
        $this->uf = "SP";
        $this->ativo = "Sim";
    }

    public function getIdcliente(): int
    {
        return $this->idcliente;
    }

    public function setIdcliente(int $value): static
    {
        $this->idcliente = $value;
        return $this;
    }

    public function getDtCadastro(): DateTime
    {
        return $this->dtCadastro;
    }

    public function setDtCadastro(DateTime $value): static
    {
        $this->dtCadastro = $value;
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

    public function getLocalIdlocal(): int
    {
        return $this->localIdlocal;
    }

    public function setLocalIdlocal(int $value): static
    {
        $this->localIdlocal = $value;
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

    public function getNumero(): string
    {
        return HtmlDecode($this->numero);
    }

    public function setNumero(string $value): static
    {
        $this->numero = RemoveXss($value);
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

    public function getCep(): string
    {
        return HtmlDecode($this->cep);
    }

    public function setCep(string $value): static
    {
        $this->cep = RemoveXss($value);
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
