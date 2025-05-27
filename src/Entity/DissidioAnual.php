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
 * Entity class for "dissidio_anual" table
 */
#[Entity]
#[Table(name: "dissidio_anual")]
class DissidioAnual extends AbstractEntity
{
    #[Id]
    #[Column(name: "iddissidio_anual", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $iddissidioAnual;

    #[Column(type: "date")]
    private DateTime $data;

    #[Column(type: "string")]
    private string $obs;

    public function __construct()
    {
        $this->obs = "Dissidio Anual";
    }

    public function getIddissidioAnual(): int
    {
        return $this->iddissidioAnual;
    }

    public function setIddissidioAnual(int $value): static
    {
        $this->iddissidioAnual = $value;
        return $this;
    }

    public function getData(): DateTime
    {
        return $this->data;
    }

    public function setData(DateTime $value): static
    {
        $this->data = $value;
        return $this;
    }

    public function getObs(): string
    {
        return HtmlDecode($this->obs);
    }

    public function setObs(string $value): static
    {
        $this->obs = RemoveXss($value);
        return $this;
    }
}
