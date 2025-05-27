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
 * Entity class for "modulo" table
 */
#[Entity]
#[Table(name: "modulo")]
class Modulo extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idmodulo;

    #[Column(type: "string")]
    private string $modulo;

    #[Column(type: "integer")]
    private int $posicao;

    public function getIdmodulo(): int
    {
        return $this->idmodulo;
    }

    public function setIdmodulo(int $value): static
    {
        $this->idmodulo = $value;
        return $this;
    }

    public function getModulo(): string
    {
        return HtmlDecode($this->modulo);
    }

    public function setModulo(string $value): static
    {
        $this->modulo = RemoveXss($value);
        return $this;
    }

    public function getPosicao(): int
    {
        return $this->posicao;
    }

    public function setPosicao(int $value): static
    {
        $this->posicao = $value;
        return $this;
    }
}
