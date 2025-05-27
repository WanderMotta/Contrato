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
 * Entity class for "calculo" table
 */
#[Entity]
#[Table(name: "calculo")]
class Calculo extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idcalculo;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(type: "string")]
    private string $calculo;

    public function getIdcalculo(): int
    {
        return $this->idcalculo;
    }

    public function setIdcalculo(int $value): static
    {
        $this->idcalculo = $value;
        return $this;
    }

    public function getDtCadastro(): DateTime
    {
        return $this->dtCadastro;
    }

    public function setDtCadastro(DateTime $value): static
    {
        $this->dtCadastro = $value;
        return $this;
    }

    public function getCalculo(): string
    {
        return HtmlDecode($this->calculo);
    }

    public function setCalculo(string $value): static
    {
        $this->calculo = RemoveXss($value);
        return $this;
    }
}
