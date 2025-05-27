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
 * Entity class for "insumo" table
 */
#[Entity]
#[Table(name: "insumo")]
class Insumo extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idinsumo;

    #[Column(type: "string")]
    private string $insumo;

    #[Column(name: "tipo_insumo_idtipo_insumo", type: "integer")]
    private int $tipoInsumoIdtipoInsumo;

    #[Column(name: "vr_unitario", type: "decimal")]
    private string $vrUnitario;

    public function __construct()
    {
        $this->vrUnitario = "0.00";
    }

    public function getIdinsumo(): int
    {
        return $this->idinsumo;
    }

    public function setIdinsumo(int $value): static
    {
        $this->idinsumo = $value;
        return $this;
    }

    public function getInsumo(): string
    {
        return HtmlDecode($this->insumo);
    }

    public function setInsumo(string $value): static
    {
        $this->insumo = RemoveXss($value);
        return $this;
    }

    public function getTipoInsumoIdtipoInsumo(): int
    {
        return $this->tipoInsumoIdtipoInsumo;
    }

    public function setTipoInsumoIdtipoInsumo(int $value): static
    {
        $this->tipoInsumoIdtipoInsumo = $value;
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
