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
 * Entity class for "escala" table
 */
#[Entity]
#[Table(name: "escala")]
class Escala extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idescala;

    #[Column(type: "string")]
    private string $escala;

    #[Column(name: "nr_dias_mes", type: "decimal")]
    private string $nrDiasMes;

    #[Column(name: "intra_sdf", type: "decimal")]
    private string $intraSdf;

    #[Column(name: "intra_df", type: "decimal")]
    private string $intraDf;

    public function __construct()
    {
        $this->intraSdf = "0.0";
        $this->intraDf = "0.0";
    }

    public function getIdescala(): int
    {
        return $this->idescala;
    }

    public function setIdescala(int $value): static
    {
        $this->idescala = $value;
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
}
