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
 * Entity class for "uniforme_cargo" table
 */
#[Entity]
#[Table(name: "uniforme_cargo")]
class UniformeCargo extends AbstractEntity
{
    #[Id]
    #[Column(name: "iduniforme_cargo", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $iduniformeCargo;

    #[Column(name: "uniforme_iduniforme", type: "integer")]
    private int $uniformeIduniforme;

    #[Column(name: "tipo_uniforme_idtipo_uniforme", type: "integer")]
    private int $tipoUniformeIdtipoUniforme;

    public function getIduniformeCargo(): int
    {
        return $this->iduniformeCargo;
    }

    public function setIduniformeCargo(int $value): static
    {
        $this->iduniformeCargo = $value;
        return $this;
    }

    public function getUniformeIduniforme(): int
    {
        return $this->uniformeIduniforme;
    }

    public function setUniformeIduniforme(int $value): static
    {
        $this->uniformeIduniforme = $value;
        return $this;
    }

    public function getTipoUniformeIdtipoUniforme(): int
    {
        return $this->tipoUniformeIdtipoUniforme;
    }

    public function setTipoUniformeIdtipoUniforme(int $value): static
    {
        $this->tipoUniformeIdtipoUniforme = $value;
        return $this;
    }
}
