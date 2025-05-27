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
 * Entity class for "cargo" table
 */
#[Entity]
#[Table(name: "cargo")]
class Cargo extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idcargo;

    #[Column(type: "string")]
    private string $cargo;

    #[Column(type: "string")]
    private string $abreviado;

    #[Column(name: "funcao_idfuncao", type: "integer")]
    private int $funcaoIdfuncao;

    #[Column(type: "decimal")]
    private string $salario;

    #[Column(name: "tipo_uniforme_idtipo_uniforme", type: "integer")]
    private int $tipoUniformeIdtipoUniforme;

    #[Column(name: "escala_idescala", type: "integer")]
    private int $escalaIdescala;

    #[Column(name: "periodo_idperiodo", type: "integer")]
    private int $periodoIdperiodo;

    #[Column(type: "decimal")]
    private string $jornada;

    #[Column(name: "nr_horas_mes", type: "integer")]
    private int $nrHorasMes;

    #[Column(name: "nr_horas_ad_noite", type: "decimal")]
    private string $nrHorasAdNoite;

    #[Column(type: "string")]
    private string $intrajornada;

    #[Column(name: "vt_dia", type: "decimal")]
    private string $vtDia;

    #[Column(name: "vr_dia", type: "decimal")]
    private string $vrDia;

    #[Column(name: "va_mes", type: "decimal")]
    private string $vaMes;

    #[Column(name: "benef_social", type: "decimal")]
    private string $benefSocial;

    #[Column(type: "decimal")]
    private string $plr;

    #[Column(name: "assis_medica", type: "decimal")]
    private string $assisMedica;

    #[Column(name: "assis_odonto", type: "decimal")]
    private string $assisOdonto;

    #[Column(name: "modulo_idmodulo", type: "integer")]
    private int $moduloIdmodulo;

    #[Column(name: "salario_antes", type: "decimal", nullable: true)]
    private ?string $salarioAntes;

    #[Column(name: "vt_dia_antes", type: "decimal", nullable: true)]
    private ?string $vtDiaAntes;

    #[Column(name: "vr_dia_antes", type: "decimal", nullable: true)]
    private ?string $vrDiaAntes;

    #[Column(name: "va_mes_antes", type: "decimal", nullable: true)]
    private ?string $vaMesAntes;

    #[Column(name: "benef_social_antes", type: "decimal", nullable: true)]
    private ?string $benefSocialAntes;

    #[Column(name: "plr_antes", type: "decimal", nullable: true)]
    private ?string $plrAntes;

    #[Column(name: "assis_medica_antes", type: "decimal", nullable: true)]
    private ?string $assisMedicaAntes;

    #[Column(name: "assis_odonto_antes", type: "decimal", nullable: true)]
    private ?string $assisOdontoAntes;

    public function __construct()
    {
        $this->jornada = "11.00";
        $this->nrHorasAdNoite = "7.00";
        $this->intrajornada = "Nao";
        $this->vtDia = "9.24";
        $this->vrDia = "19.01";
        $this->vaMes = "132.48";
        $this->benefSocial = "0.00";
        $this->plr = "0.00";
        $this->assisMedica = "0.00";
        $this->assisOdonto = "0.00";
        $this->moduloIdmodulo = 1;
        $this->salarioAntes = "0.00";
        $this->vtDiaAntes = "0.00";
        $this->vrDiaAntes = "0.00";
        $this->vaMesAntes = "0.00";
        $this->benefSocialAntes = "0.00";
        $this->plrAntes = "0.00";
        $this->assisMedicaAntes = "0.00";
        $this->assisOdontoAntes = "0.00";
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

    public function getAbreviado(): string
    {
        return HtmlDecode($this->abreviado);
    }

    public function setAbreviado(string $value): static
    {
        $this->abreviado = RemoveXss($value);
        return $this;
    }

    public function getFuncaoIdfuncao(): int
    {
        return $this->funcaoIdfuncao;
    }

    public function setFuncaoIdfuncao(int $value): static
    {
        $this->funcaoIdfuncao = $value;
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

    public function getTipoUniformeIdtipoUniforme(): int
    {
        return $this->tipoUniformeIdtipoUniforme;
    }

    public function setTipoUniformeIdtipoUniforme(int $value): static
    {
        $this->tipoUniformeIdtipoUniforme = $value;
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

    public function getPeriodoIdperiodo(): int
    {
        return $this->periodoIdperiodo;
    }

    public function setPeriodoIdperiodo(int $value): static
    {
        $this->periodoIdperiodo = $value;
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

    public function getIntrajornada(): string
    {
        return $this->intrajornada;
    }

    public function setIntrajornada(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'intrajornada' value");
        }
        $this->intrajornada = $value;
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

    public function getPlr(): string
    {
        return $this->plr;
    }

    public function setPlr(string $value): static
    {
        $this->plr = $value;
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

    public function getModuloIdmodulo(): int
    {
        return $this->moduloIdmodulo;
    }

    public function setModuloIdmodulo(int $value): static
    {
        $this->moduloIdmodulo = $value;
        return $this;
    }

    public function getSalarioAntes(): ?string
    {
        return $this->salarioAntes;
    }

    public function setSalarioAntes(?string $value): static
    {
        $this->salarioAntes = $value;
        return $this;
    }

    public function getVtDiaAntes(): ?string
    {
        return $this->vtDiaAntes;
    }

    public function setVtDiaAntes(?string $value): static
    {
        $this->vtDiaAntes = $value;
        return $this;
    }

    public function getVrDiaAntes(): ?string
    {
        return $this->vrDiaAntes;
    }

    public function setVrDiaAntes(?string $value): static
    {
        $this->vrDiaAntes = $value;
        return $this;
    }

    public function getVaMesAntes(): ?string
    {
        return $this->vaMesAntes;
    }

    public function setVaMesAntes(?string $value): static
    {
        $this->vaMesAntes = $value;
        return $this;
    }

    public function getBenefSocialAntes(): ?string
    {
        return $this->benefSocialAntes;
    }

    public function setBenefSocialAntes(?string $value): static
    {
        $this->benefSocialAntes = $value;
        return $this;
    }

    public function getPlrAntes(): ?string
    {
        return $this->plrAntes;
    }

    public function setPlrAntes(?string $value): static
    {
        $this->plrAntes = $value;
        return $this;
    }

    public function getAssisMedicaAntes(): ?string
    {
        return $this->assisMedicaAntes;
    }

    public function setAssisMedicaAntes(?string $value): static
    {
        $this->assisMedicaAntes = $value;
        return $this;
    }

    public function getAssisOdontoAntes(): ?string
    {
        return $this->assisOdontoAntes;
    }

    public function setAssisOdontoAntes(?string $value): static
    {
        $this->assisOdontoAntes = $value;
        return $this;
    }
}
