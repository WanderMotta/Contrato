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
 * Entity class for "tipo_intrajornada" table
 */
#[Entity]
#[Table(name: "tipo_intrajornada")]
class TipoIntrajornada extends AbstractEntity
{
    #[Id]
    #[Column(name: "idtipo_intrajornada", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idtipoIntrajornada;

    #[Column(name: "intrajornada_tipo", type: "string")]
    private string $intrajornadaTipo;

    public function getIdtipoIntrajornada(): int
    {
        return $this->idtipoIntrajornada;
    }

    public function setIdtipoIntrajornada(int $value): static
    {
        $this->idtipoIntrajornada = $value;
        return $this;
    }

    public function getIntrajornadaTipo(): string
    {
        return HtmlDecode($this->intrajornadaTipo);
    }

    public function setIntrajornadaTipo(string $value): static
    {
        $this->intrajornadaTipo = RemoveXss($value);
        return $this;
    }
}
