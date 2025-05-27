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
 * Entity class for "contrato" table
 */
#[Entity]
#[Table(name: "contrato")]
class Contrato extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idcontrato;

    #[Column(name: "cliente_idcliente", type: "integer")]
    private int $clienteIdcliente;

    #[Column(type: "decimal")]
    private string $valor;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(type: "string", nullable: true)]
    private ?string $obs;

    #[Column(type: "string")]
    private string $ativo;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    #[Column(name: "valor_antes", type: "decimal")]
    private string $valorAntes;

    public function __construct()
    {
        $this->valor = "0.00";
        $this->ativo = "Sim";
        $this->valorAntes = "0.00";
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

    public function getClienteIdcliente(): int
    {
        return $this->clienteIdcliente;
    }

    public function setClienteIdcliente(int $value): static
    {
        $this->clienteIdcliente = $value;
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

    public function getDtCadastro(): DateTime
    {
        return $this->dtCadastro;
    }

    public function setDtCadastro(DateTime $value): static
    {
        $this->dtCadastro = $value;
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

    public function getUsuarioIdusuario(): int
    {
        return $this->usuarioIdusuario;
    }

    public function setUsuarioIdusuario(int $value): static
    {
        $this->usuarioIdusuario = $value;
        return $this;
    }

    public function getValorAntes(): string
    {
        return $this->valorAntes;
    }

    public function setValorAntes(string $value): static
    {
        $this->valorAntes = $value;
        return $this;
    }
}
