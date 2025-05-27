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
 * Entity class for "dissidio" table
 */
#[Entity]
#[Table(name: "dissidio")]
class Dissidio extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    private int $idcargo;

    #[Column(type: "string", nullable: true)]
    private ?string $cargo;

    #[Column(name: "salario_antes", type: "decimal", nullable: true)]
    private ?string $salarioAntes;

    #[Column(name: "salario_atual", type: "decimal", nullable: true)]
    private ?string $salarioAtual;

    #[Column(name: "dissidio_anual_iddissidio_anual", type: "integer")]
    private int $dissidioAnualIddissidioAnual;

    public function getIdcargo(): int
    {
        return $this->idcargo;
    }

    public function setIdcargo(int $value): static
    {
        $this->idcargo = $value;
        return $this;
    }

    public function getCargo(): ?string
    {
        return HtmlDecode($this->cargo);
    }

    public function setCargo(?string $value): static
    {
        $this->cargo = RemoveXss($value);
        return $this;
    }

    public function getSalarioAntes(): ?string
    {
        return $this->salarioAntes;
    }

    public function setSalarioAntes(?string $value): static
    {
        $this->salarioAntes = $value;
        return $this;
    }

    public function getSalarioAtual(): ?string
    {
        return $this->salarioAtual;
    }

    public function setSalarioAtual(?string $value): static
    {
        $this->salarioAtual = $value;
        return $this;
    }

    public function getDissidioAnualIddissidioAnual(): int
    {
        return $this->dissidioAnualIddissidioAnual;
    }

    public function setDissidioAnualIddissidioAnual(int $value): static
    {
        $this->dissidioAnualIddissidioAnual = $value;
        return $this;
    }
}
