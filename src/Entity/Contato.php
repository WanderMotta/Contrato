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
 * Entity class for "contato" table
 */
#[Entity]
#[Table(name: "contato")]
class Contato extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idcontato;

    #[Column(type: "string")]
    private string $contato;

    #[Column(type: "string")]
    private string $email;

    #[Column(type: "string", nullable: true)]
    private ?string $telefone;

    #[Column(type: "string")]
    private string $status;

    #[Column(type: "string")]
    private string $ativo;

    #[Column(name: "faturamento_idfaturamento", type: "integer")]
    private int $faturamentoIdfaturamento;

    public function __construct()
    {
        $this->status = "Admistradora";
        $this->ativo = "Sim";
    }

    public function getIdcontato(): int
    {
        return $this->idcontato;
    }

    public function setIdcontato(int $value): static
    {
        $this->idcontato = $value;
        return $this;
    }

    public function getContato(): string
    {
        return HtmlDecode($this->contato);
    }

    public function setContato(string $value): static
    {
        $this->contato = RemoveXss($value);
        return $this;
    }

    public function getEmail(): string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(string $value): static
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $value): static
    {
        if (!in_array($value, ["Admistradora", "Sindico", "Conselho", "Outros"])) {
            throw new \InvalidArgumentException("Invalid 'status' value");
        }
        $this->status = $value;
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

    public function getFaturamentoIdfaturamento(): int
    {
        return $this->faturamentoIdfaturamento;
    }

    public function setFaturamentoIdfaturamento(int $value): static
    {
        $this->faturamentoIdfaturamento = $value;
        return $this;
    }
}
