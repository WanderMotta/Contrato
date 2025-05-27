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
 * Entity class for "view_uniforme_cargo_pla_custo" table
 */
#[Entity]
#[Table(name: "view_uniforme_cargo_pla_custo")]
class ViewUniformeCargoPlaCusto extends AbstractEntity
{
    #[Id]
    #[Column(name: "idplanilha_custo", type: "integer")]
    #[GeneratedValue]
    private int $idplanilhaCusto;

    #[Column(name: "proposta_idproposta", type: "integer")]
    private int $propostaIdproposta;

    #[Column(name: "dt_proposta", type: "date", nullable: true)]
    private ?DateTime $dtProposta;

    #[Column(name: "qtde_cargos", type: "integer")]
    private int $qtdeCargos;

    #[Column(name: "cargo_idcargo", type: "integer")]
    private int $cargoIdcargo;

    #[Column(type: "string")]
    private string $cargo;

    #[Column(type: "string", nullable: true)]
    private ?string $uniforme;

    #[Column(type: "integer", nullable: true)]
    private ?int $qtde;

    #[Column(name: "periodo_troca", type: "integer", nullable: true)]
    private ?int $periodoTroca;

    #[Column(name: "vr_unitario", type: "decimal", nullable: true)]
    private ?string $vrUnitario;

    #[Column(name: "tipo_uniforme", type: "string")]
    private string $tipoUniforme;

    #[Column(name: "vr_anual", type: "decimal", nullable: true)]
    private ?string $vrAnual;

    #[Column(name: "vr_mesal", type: "decimal", nullable: true)]
    private ?string $vrMesal;

    #[Column(type: "string", nullable: true)]
    private ?string $cliente;

    public function __construct()
    {
        $this->qtdeCargos = 1;
        $this->qtde = 2;
        $this->periodoTroca = 2;
    }

    public function getIdplanilhaCusto(): int
    {
        return $this->idplanilhaCusto;
    }

    public function setIdplanilhaCusto(int $value): static
    {
        $this->idplanilhaCusto = $value;
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

    public function getDtProposta(): ?DateTime
    {
        return $this->dtProposta;
    }

    public function setDtProposta(?DateTime $value): static
    {
        $this->dtProposta = $value;
        return $this;
    }

    public function getQtdeCargos(): int
    {
        return $this->qtdeCargos;
    }

    public function setQtdeCargos(int $value): static
    {
        $this->qtdeCargos = $value;
        return $this;
    }

    public function getCargoIdcargo(): int
    {
        return $this->cargoIdcargo;
    }

    public function setCargoIdcargo(int $value): static
    {
        $this->cargoIdcargo = $value;
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

    public function getUniforme(): ?string
    {
        return HtmlDecode($this->uniforme);
    }

    public function setUniforme(?string $value): static
    {
        $this->uniforme = RemoveXss($value);
        return $this;
    }

    public function getQtde(): ?int
    {
        return $this->qtde;
    }

    public function setQtde(?int $value): static
    {
        $this->qtde = $value;
        return $this;
    }

    public function getPeriodoTroca(): ?int
    {
        return $this->periodoTroca;
    }

    public function setPeriodoTroca(?int $value): static
    {
        $this->periodoTroca = $value;
        return $this;
    }

    public function getVrUnitario(): ?string
    {
        return $this->vrUnitario;
    }

    public function setVrUnitario(?string $value): static
    {
        $this->vrUnitario = $value;
        return $this;
    }

    public function getTipoUniforme(): string
    {
        return HtmlDecode($this->tipoUniforme);
    }

    public function setTipoUniforme(string $value): static
    {
        $this->tipoUniforme = RemoveXss($value);
        return $this;
    }

    public function getVrAnual(): ?string
    {
        return $this->vrAnual;
    }

    public function setVrAnual(?string $value): static
    {
        $this->vrAnual = $value;
        return $this;
    }

    public function getVrMesal(): ?string
    {
        return $this->vrMesal;
    }

    public function setVrMesal(?string $value): static
    {
        $this->vrMesal = $value;
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
