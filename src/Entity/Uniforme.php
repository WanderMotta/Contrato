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
 * Entity class for "uniforme" table
 */
#[Entity]
#[Table(name: "uniforme")]
class Uniforme extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $iduniforme;

    #[Column(type: "string")]
    private string $uniforme;

    #[Column(type: "integer")]
    private int $qtde;

    #[Column(name: "periodo_troca", type: "integer")]
    private int $periodoTroca;

    #[Column(name: "vr_unitario", type: "decimal")]
    private string $vrUnitario;

    public function __construct()
    {
        $this->qtde = 2;
        $this->periodoTroca = 2;
    }

    public function getIduniforme(): int
    {
        return $this->iduniforme;
    }

    public function setIduniforme(int $value): static
    {
        $this->iduniforme = $value;
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
}
