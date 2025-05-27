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
 * Entity class for "view_mov_pla_custo_modulos" table
 */
#[Entity]
#[Table(name: "view_mov_pla_custo_modulos")]
class ViewMovPlaCustoModulo extends AbstractEntity
{
    #[Column(type: "string")]
    private string $modulo;

    #[Column(type: "decimal", nullable: true)]
    private ?string $valor;

    #[Column(type: "string", nullable: true)]
    private ?string $ativo;

    public function __construct()
    {
        $this->ativo = "Sim";
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

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(?string $value): static
    {
        $this->valor = $value;
        return $this;
    }

    public function getAtivo(): ?string
    {
        return $this->ativo;
    }

    public function setAtivo(?string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'ativo' value");
        }
        $this->ativo = $value;
        return $this;
    }
}
