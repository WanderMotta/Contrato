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
 * Entity class for "view_custo_salario" table
 */
#[Entity]
#[Table(name: "view_custo_salario")]
class ViewCustoSalario extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer")]
    #[GeneratedValue]
    private int $idcargo;

    #[Column(type: "string")]
    private string $cargo;

    #[Column(type: "decimal")]
    private string $salario;

    #[Column(name: "nr_horas_mes", type: "integer")]
    private int $nrHorasMes;

    #[Column(name: "nr_horas_ad_noite", type: "decimal")]
    private string $nrHorasAdNoite;

    #[Column(name: "escala_idescala", type: "integer")]
    private int $escalaIdescala;

    #[Column(type: "string")]
    private string $escala;

    #[Column(name: "periodo_idperiodo", type: "integer")]
    private int $periodoIdperiodo;

    #[Column(type: "string")]
    private string $periodo;

    #[Column(type: "decimal")]
    private string $jornada;

    #[Column(type: "decimal")]
    private string $fator;

    #[Column(name: "nr_dias_mes", type: "decimal")]
    private string $nrDiasMes;

    #[Column(name: "intra_sdf", type: "decimal")]
    private string $intraSdf;

    #[Column(name: "intra_df", type: "decimal")]
    private string $intraDf;

    #[Column(name: "ad_noite", type: "decimal", nullable: true)]
    private ?string $adNoite;

    #[Column(name: "DSR_ad_noite", type: "decimal", nullable: true)]
    private ?string $dsrAdNoite;

    #[Column(name: "he_50", type: "decimal", nullable: true)]
    private ?string $he50;

    #[Column(name: "DSR_he_50", type: "decimal", nullable: true)]
    private ?string $dsrHe50;

    #[Column(name: "intra_todos", type: "decimal", nullable: true)]
    private ?string $intraTodos;

    #[Column(name: "intra_SabDomFer", type: "decimal", nullable: true)]
    private ?string $intraSabDomFer;

    #[Column(name: "intra_DomFer", type: "decimal", nullable: true)]
    private ?string $intraDomFer;

    #[Column(name: "vt_dia", type: "decimal")]
    private string $vtDia;

    #[Column(name: "vr_dia", type: "decimal")]
    private string $vrDia;

    #[Column(name: "va_mes", type: "decimal")]
    private string $vaMes;

    #[Column(name: "benef_social", type: "decimal")]
    private string $benefSocial;

    #[Column(name: "plr_mes", type: "decimal", nullable: true)]
    private ?string $plrMes;

    #[Column(name: "assis_medica", type: "decimal")]
    private string $assisMedica;

    #[Column(name: "assis_odonto", type: "decimal")]
    private string $assisOdonto;

    #[Column(name: "desc_vt", type: "decimal")]
    private string $descVt;

    #[Column(type: "string")]
    private string $abreviado;

    public function __construct()
    {
        $this->nrHorasAdNoite = "7.00";
        $this->jornada = "11.00";
        $this->fator = "1.0";
        $this->intraSdf = "0.0";
        $this->intraDf = "0.0";
        $this->vtDia = "0.00";
        $this->vrDia = "0.00";
        $this->vaMes = "0.00";
        $this->benefSocial = "0.00";
        $this->assisMedica = "0.00";
        $this->assisOdonto = "0.00";
        $this->descVt = "0.00";
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

    public function getNrHorasMes(): int
    {
        return $this->nrHorasMes;
    }

    public function setNrHorasMes(int $value): static
    {
        $this->nrHorasMes = $value;
        return $this;
    }

    public function getNrHorasAdNoite(): string
    {
        return $this->nrHorasAdNoite;
    }

    public function setNrHorasAdNoite(string $value): static
    {
        $this->nrHorasAdNoite = $value;
        return $this;
    }

    public function getEscalaIdescala(): int
    {
        return $this->escalaIdescala;
    }

    public function setEscalaIdescala(int $value): static
    {
        $this->escalaIdescala = $value;
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

    public function getFator(): string
    {
        return $this->fator;
    }

    public function setFator(string $value): static
    {
        $this->fator = $value;
        return $this;
    }

    public function getNrDiasMes(): string
    {
        return $this->nrDiasMes;
    }

    public function setNrDiasMes(string $value): static
    {
        $this->nrDiasMes = $value;
        return $this;
    }

    public function getIntraSdf(): string
    {
        return $this->intraSdf;
    }

    public function setIntraSdf(string $value): static
    {
        $this->intraSdf = $value;
        return $this;
    }

    public function getIntraDf(): string
    {
        return $this->intraDf;
    }

    public function setIntraDf(string $value): static
    {
        $this->intraDf = $value;
        return $this;
    }

    public function getAdNoite(): ?string
    {
        return $this->adNoite;
    }

    public function setAdNoite(?string $value): static
    {
        $this->adNoite = $value;
        return $this;
    }

    public function getDsrAdNoite(): ?string
    {
        return $this->dsrAdNoite;
    }

    public function setDsrAdNoite(?string $value): static
    {
        $this->dsrAdNoite = $value;
        return $this;
    }

    public function getHe50(): ?string
    {
        return $this->he50;
    }

    public function setHe50(?string $value): static
    {
        $this->he50 = $value;
        return $this;
    }

    public function getDsrHe50(): ?string
    {
        return $this->dsrHe50;
    }

    public function setDsrHe50(?string $value): static
    {
        $this->dsrHe50 = $value;
        return $this;
    }

    public function getIntraTodos(): ?string
    {
        return $this->intraTodos;
    }

    public function setIntraTodos(?string $value): static
    {
        $this->intraTodos = $value;
        return $this;
    }

    public function getIntraSabDomFer(): ?string
    {
        return $this->intraSabDomFer;
    }

    public function setIntraSabDomFer(?string $value): static
    {
        $this->intraSabDomFer = $value;
        return $this;
    }

    public function getIntraDomFer(): ?string
    {
        return $this->intraDomFer;
    }

    public function setIntraDomFer(?string $value): static
    {
        $this->intraDomFer = $value;
        return $this;
    }

    public function getVtDia(): string
    {
        return $this->vtDia;
    }

    public function setVtDia(string $value): static
    {
        $this->vtDia = $value;
        return $this;
    }

    public function getVrDia(): string
    {
        return $this->vrDia;
    }

    public function setVrDia(string $value): static
    {
        $this->vrDia = $value;
        return $this;
    }

    public function getVaMes(): string
    {
        return $this->vaMes;
    }

    public function setVaMes(string $value): static
    {
        $this->vaMes = $value;
        return $this;
    }

    public function getBenefSocial(): string
    {
        return $this->benefSocial;
    }

    public function setBenefSocial(string $value): static
    {
        $this->benefSocial = $value;
        return $this;
    }

    public function getPlrMes(): ?string
    {
        return $this->plrMes;
    }

    public function setPlrMes(?string $value): static
    {
        $this->plrMes = $value;
        return $this;
    }

    public function getAssisMedica(): string
    {
        return $this->assisMedica;
    }

    public function setAssisMedica(string $value): static
    {
        $this->assisMedica = $value;
        return $this;
    }

    public function getAssisOdonto(): string
    {
        return $this->assisOdonto;
    }

    public function setAssisOdonto(string $value): static
    {
        $this->assisOdonto = $value;
        return $this;
    }

    public function getDescVt(): string
    {
        return $this->descVt;
    }

    public function setDescVt(string $value): static
    {
        $this->descVt = $value;
        return $this;
    }

    public function getAbreviado(): string
    {
        return HtmlDecode($this->abreviado);
    }

    public function setAbreviado(string $value): static
    {
        $this->abreviado = RemoveXss($value);
        return $this;
    }
}
