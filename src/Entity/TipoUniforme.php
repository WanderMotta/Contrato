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
 * Entity class for "tipo_uniforme" table
 */
#[Entity]
#[Table(name: "tipo_uniforme")]
class TipoUniforme extends AbstractEntity
{
    #[Id]
    #[Column(name: "idtipo_uniforme", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idtipoUniforme;

    #[Column(name: "tipo_uniforme", type: "string")]
    private string $tipoUniforme;

    public function getIdtipoUniforme(): int
    {
        return $this->idtipoUniforme;
    }

    public function setIdtipoUniforme(int $value): static
    {
        $this->idtipoUniforme = $value;
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
}
