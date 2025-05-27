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
 * Entity class for "view_uniforme_cargo_consolidado" table
 */
#[Entity]
#[Table(name: "view_uniforme_cargo_consolidado")]
class ViewUniformeCargoConsolidado extends AbstractEntity
{
    #[Column(type: "integer")]
    private int $idcargo;

    #[Column(type: "string")]
    private string $cargo;

    #[Column(name: "tipo_uniforme", type: "string")]
    private string $tipoUniforme;

    #[Column(name: "vr_anual", type: "decimal", nullable: true)]
    private ?string $vrAnual;

    #[Column(name: "vr_mensal", type: "decimal", nullable: true)]
    private ?string $vrMensal;

    public function __construct()
    {
        $this->idcargo = 000;
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

    public function getVrMensal(): ?string
    {
        return $this->vrMensal;
    }

    public function setVrMensal(?string $value): static
    {
        $this->vrMensal = $value;
        return $this;
    }
}
