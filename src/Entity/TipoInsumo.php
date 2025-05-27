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
 * Entity class for "tipo_insumo" table
 */
#[Entity]
#[Table(name: "tipo_insumo")]
class TipoInsumo extends AbstractEntity
{
    #[Id]
    #[Column(name: "idtipo_insumo", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idtipoInsumo;

    #[Column(name: "tipo_insumo", type: "string")]
    private string $tipoInsumo;

    public function getIdtipoInsumo(): int
    {
        return $this->idtipoInsumo;
    }

    public function setIdtipoInsumo(int $value): static
    {
        $this->idtipoInsumo = $value;
        return $this;
    }

    public function getTipoInsumo(): string
    {
        return HtmlDecode($this->tipoInsumo);
    }

    public function setTipoInsumo(string $value): static
    {
        $this->tipoInsumo = RemoveXss($value);
        return $this;
    }
}
