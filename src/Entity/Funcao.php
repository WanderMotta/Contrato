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
 * Entity class for "funcao" table
 */
#[Entity]
#[Table(name: "funcao")]
class Funcao extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idfuncao;

    #[Column(type: "string")]
    private string $funcao;

    public function getIdfuncao(): int
    {
        return $this->idfuncao;
    }

    public function setIdfuncao(int $value): static
    {
        $this->idfuncao = $value;
        return $this;
    }

    public function getFuncao(): string
    {
        return HtmlDecode($this->funcao);
    }

    public function setFuncao(string $value): static
    {
        $this->funcao = RemoveXss($value);
        return $this;
    }
}
