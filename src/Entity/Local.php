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
 * Entity class for "local" table
 */
#[Entity]
#[Table(name: "local")]
class Local extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idlocal;

    #[Column(type: "string")]
    private string $local;

    public function getIdlocal(): int
    {
        return $this->idlocal;
    }

    public function setIdlocal(int $value): static
    {
        $this->idlocal = $value;
        return $this;
    }

    public function getLocal(): string
    {
        return HtmlDecode($this->local);
    }

    public function setLocal(string $value): static
    {
        $this->local = RemoveXss($value);
        return $this;
    }
}
