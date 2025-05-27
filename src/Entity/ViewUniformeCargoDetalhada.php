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
 * Entity class for "view_uniforme_cargo_detalhada" table
 */
#[Entity]
#[Table(name: "view_uniforme_cargo_detalhada")]
class ViewUniformeCargoDetalhada extends AbstractEntity
{
    #[Id]
    #[Column(name: "iduniforme_cargo", type: "integer")]
    #[GeneratedValue]
    private int $iduniformeCargo;

    #[Column(name: "uniforme_iduniforme", type: "integer")]
    private int $uniformeIduniforme;

    #[Column(type: "string")]
    private string $cargo;

    #[Column(type: "integer")]
    #[GeneratedValue]
    private int $idcargo;

    #[Column(name: "tipo_uniforme", type: "string")]
    private string $tipoUniforme;

    #[Column(name: "tipo_uniforme_idtipo_uniforme", type: "integer")]
    private int $tipoUniformeIdtipoUniforme;

    #[Column(type: "string")]
    private string $uniforme;

    #[Column(type: "integer")]
    private int $qtde;

    #[Column(name: "periodo_troca", type: "integer")]
    private int $periodoTroca;

    #[Column(name: "vr_unitario", type: "decimal")]
    private string $vrUnitario;

    #[Column(name: "vr_mensal", type: "decimal", nullable: true)]
    private ?string $vrMensal;

    #[Column(name: "vr_anual", type: "decimal")]
    private string $vrAnual;

    public function __construct()
    {
        $this->qtde = 2;
        $this->periodoTroca = 2;
        $this->vrAnual = "0.00";
    }

    public function getIduniformeCargo(): int
    {
        return $this->iduniformeCargo;
    }

    public function setIduniformeCargo(int $value): static
    {
        $this->iduniformeCargo = $value;
        return $this;
    }

    public function getUniformeIduniforme(): int
    {
        return $this->uniformeIduniforme;
    }

    public function setUniformeIduniforme(int $value): static
    {
        $this->uniformeIduniforme = $value;
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

    public function getIdcargo(): int
    {
        return $this->idcargo;
    }

    public function setIdcargo(int $value): static
    {
        $this->idcargo = $value;
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

    public function getTipoUniformeIdtipoUniforme(): int
    {
        return $this->tipoUniformeIdtipoUniforme;
    }

    public function setTipoUniformeIdtipoUniforme(int $value): static
    {
        $this->tipoUniformeIdtipoUniforme = $value;
        return $this;
    }

    public function getUniforme(): string
    {
        return HtmlDecode($this->uniforme);
    }

    public function setUniforme(string $value): static
    {
        $this->uniforme = RemoveXss($value);
        return $this;
    }

    public function getQtde(): int
    {
        return $this->qtde;
    }

    public function setQtde(int $value): static
    {
        $this->qtde = $value;
        return $this;
    }

    public function getPeriodoTroca(): int
    {
        return $this->periodoTroca;
    }

    public function setPeriodoTroca(int $value): static
    {
        $this->periodoTroca = $value;
        return $this;
    }

    public function getVrUnitario(): string
    {
        return $this->vrUnitario;
    }

    public function setVrUnitario(string $value): static
    {
        $this->vrUnitario = $value;
        return $this;
    }

    public function getVrMensal(): ?string
    {
        return $this->vrMensal;
    }

    public function setVrMensal(?string $value): static
    {
        $this->vrMensal = $value;
        return $this;
    }

    public function getVrAnual(): string
    {
        return $this->vrAnual;
    }

    public function setVrAnual(string $value): static
    {
        $this->vrAnual = $value;
        return $this;
    }
}
