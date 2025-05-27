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
 * Entity class for "beneficios" table
 */
#[Entity]
#[Table(name: "beneficios")]
class Beneficio extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idbeneficios;

    #[Column(type: "date")]
    private DateTime $data;

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

    #[Column(name: "dissidio_anual_iddissidio_anual", type: "integer")]
    private int $dissidioAnualIddissidioAnual;

    public function __construct()
    {
        $this->vtDia = "0.00";
        $this->vrDia = "0.00";
        $this->vaMes = "0.00";
        $this->benefSocial = "0.00";
        $this->plr = "0.00";
        $this->assisMedica = "0.00";
        $this->assisOdonto = "0.00";
    }

    public function getIdbeneficios(): int
    {
        return $this->idbeneficios;
    }

    public function setIdbeneficios(int $value): static
    {
        $this->idbeneficios = $value;
        return $this;
    }

    public function getData(): DateTime
    {
        return $this->data;
    }

    public function setData(DateTime $value): static
    {
        $this->data = $value;
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

    public function getDissidioAnualIddissidioAnual(): int
    {
        return $this->dissidioAnualIddissidioAnual;
    }

    public function setDissidioAnualIddissidioAnual(int $value): static
    {
        $this->dissidioAnualIddissidioAnual = $value;
        return $this;
    }
}
