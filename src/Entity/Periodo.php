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
 * Entity class for "periodo" table
 */
#[Entity]
#[Table(name: "periodo")]
class Periodo extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idperiodo;

    #[Column(type: "string")]
    private string $periodo;

    #[Column(type: "decimal")]
    private string $fator;

    public function __construct()
    {
        $this->fator = "1.0";
    }

    public function getIdperiodo(): int
    {
        return $this->idperiodo;
    }

    public function setIdperiodo(int $value): static
    {
        $this->idperiodo = $value;
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

    public function getFator(): string
    {
        return $this->fator;
    }

    public function setFator(string $value): static
    {
        $this->fator = $value;
        return $this;
    }
}
