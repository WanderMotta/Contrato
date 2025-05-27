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
 * Entity class for "view_insumo_proposta_detalhada" table
 */
#[Entity]
#[Table(name: "view_insumo_proposta_detalhada")]
class ViewInsumoPropostaDetalhada extends AbstractEntity
{
    #[Id]
    #[Column(name: "idmov_insumo_cliente", type: "integer")]
    #[GeneratedValue]
    private int $idmovInsumoCliente;

    #[Column(name: "proposta_idproposta", type: "integer")]
    private int $propostaIdproposta;

    #[Column(name: "insumo_idinsumo", type: "integer")]
    private int $insumoIdinsumo;

    #[Column(name: "tipo_insumo", type: "string")]
    private string $tipoInsumo;

    #[Column(type: "string")]
    private string $insumo;

    #[Column(type: "decimal")]
    private string $qtde;

    #[Column(name: "vr_unit", type: "decimal")]
    private string $vrUnit;

    #[Column(type: "decimal")]
    private string $frequencia;

    #[Column(type: "decimal")]
    private string $anual;

    #[Column(type: "decimal", nullable: true)]
    private ?string $mensal;

    #[Column(name: "idtipo_idinsumo", type: "integer")]
    private int $idtipoIdinsumo;

    #[Column(type: "string", nullable: true)]
    private ?string $cliente;

    public function __construct()
    {
        $this->qtde = "1.00";
        $this->frequencia = "12.0";
        $this->anual = "0.00";
    }

    public function getIdmovInsumoCliente(): int
    {
        return $this->idmovInsumoCliente;
    }

    public function setIdmovInsumoCliente(int $value): static
    {
        $this->idmovInsumoCliente = $value;
        return $this;
    }

    public function getPropostaIdproposta(): int
    {
        return $this->propostaIdproposta;
    }

    public function setPropostaIdproposta(int $value): static
    {
        $this->propostaIdproposta = $value;
        return $this;
    }

    public function getInsumoIdinsumo(): int
    {
        return $this->insumoIdinsumo;
    }

    public function setInsumoIdinsumo(int $value): static
    {
        $this->insumoIdinsumo = $value;
        return $this;
    }

    public function getTipoInsumo(): string
    {
        return HtmlDecode($this->tipoInsumo);
    }

    public function setTipoInsumo(string $value): static
    {
        $this->tipoInsumo = RemoveXss($value);
        return $this;
    }

    public function getInsumo(): string
    {
        return HtmlDecode($this->insumo);
    }

    public function setInsumo(string $value): static
    {
        $this->insumo = RemoveXss($value);
        return $this;
    }

    public function getQtde(): string
    {
        return $this->qtde;
    }

    public function setQtde(string $value): static
    {
        $this->qtde = $value;
        return $this;
    }

    public function getVrUnit(): string
    {
        return $this->vrUnit;
    }

    public function setVrUnit(string $value): static
    {
        $this->vrUnit = $value;
        return $this;
    }

    public function getFrequencia(): string
    {
        return $this->frequencia;
    }

    public function setFrequencia(string $value): static
    {
        $this->frequencia = $value;
        return $this;
    }

    public function getAnual(): string
    {
        return $this->anual;
    }

    public function setAnual(string $value): static
    {
        $this->anual = $value;
        return $this;
    }

    public function getMensal(): ?string
    {
        return $this->mensal;
    }

    public function setMensal(?string $value): static
    {
        $this->mensal = $value;
        return $this;
    }

    public function getIdtipoIdinsumo(): int
    {
        return $this->idtipoIdinsumo;
    }

    public function setIdtipoIdinsumo(int $value): static
    {
        $this->idtipoIdinsumo = $value;
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
}
