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
 * Entity class for "proposta" table
 */
#[Entity]
#[Table(name: "proposta")]
class Proposta extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idproposta;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "cliente_idcliente", type: "integer")]
    private int $clienteIdcliente;

    #[Column(type: "date")]
    private DateTime $validade;

    #[Column(name: "mes_ano_conv_coletiva", type: "string")]
    private string $mesAnoConvColetiva;

    #[Column(type: "string")]
    private string $sindicato;

    #[Column(type: "string")]
    private string $cidade;

    #[Column(name: "nr_meses", type: "string")]
    private string $nrMeses;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    #[Column(type: "text", nullable: true)]
    private ?string $obs;

    public function __construct()
    {
        $this->mesAnoConvColetiva = "Jan/2024";
        $this->sindicato = "Siemaco";
        $this->cidade = "São Paulo/SP";
        $this->nrMeses = "24 Meses";
    }

    public function getIdproposta(): int
    {
        return $this->idproposta;
    }

    public function setIdproposta(int $value): static
    {
        $this->idproposta = $value;
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

    public function getClienteIdcliente(): int
    {
        return $this->clienteIdcliente;
    }

    public function setClienteIdcliente(int $value): static
    {
        $this->clienteIdcliente = $value;
        return $this;
    }

    public function getValidade(): DateTime
    {
        return $this->validade;
    }

    public function setValidade(DateTime $value): static
    {
        $this->validade = $value;
        return $this;
    }

    public function getMesAnoConvColetiva(): string
    {
        return HtmlDecode($this->mesAnoConvColetiva);
    }

    public function setMesAnoConvColetiva(string $value): static
    {
        $this->mesAnoConvColetiva = RemoveXss($value);
        return $this;
    }

    public function getSindicato(): string
    {
        return HtmlDecode($this->sindicato);
    }

    public function setSindicato(string $value): static
    {
        $this->sindicato = RemoveXss($value);
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

    public function getNrMeses(): string
    {
        return HtmlDecode($this->nrMeses);
    }

    public function setNrMeses(string $value): static
    {
        $this->nrMeses = RemoveXss($value);
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

    public function getObs(): ?string
    {
        return HtmlDecode($this->obs);
    }

    public function setObs(?string $value): static
    {
        $this->obs = RemoveXss($value);
        return $this;
    }
}
