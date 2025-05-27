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
 * Entity class for "view_insumo_proposta_consolidado" table
 */
#[Entity]
#[Table(name: "view_insumo_proposta_consolidado")]
class ViewInsumoPropostaConsolidado extends AbstractEntity
{
    #[Column(name: "proposta_idproposta", type: "integer")]
    private int $propostaIdproposta;

    #[Column(name: "idtipo_idinsumo", type: "integer")]
    private int $idtipoIdinsumo;

    #[Column(name: "tipo_insumo", type: "string")]
    private string $tipoInsumo;

    #[Column(name: "vr_anual", type: "decimal", nullable: true)]
    private ?string $vrAnual;

    #[Column(name: "vr_mensal", type: "decimal", nullable: true)]
    private ?string $vrMensal;

    public function getPropostaIdproposta(): int
    {
        return $this->propostaIdproposta;
    }

    public function setPropostaIdproposta(int $value): static
    {
        $this->propostaIdproposta = $value;
        return $this;
    }

    public function getIdtipoIdinsumo(): int
    {
        return $this->idtipoIdinsumo;
    }

    public function setIdtipoIdinsumo(int $value): static
    {
        $this->idtipoIdinsumo = $value;
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

    public function getVrAnual(): ?string
    {
        return $this->vrAnual;
    }

    public function setVrAnual(?string $value): static
    {
        $this->vrAnual = $value;
        return $this;
    }

    public function getVrMensal(): ?string
    {
        return $this->vrMensal;
    }

    public function setVrMensal(?string $value): static
    {
        $this->vrMensal = $value;
        return $this;
    }
}
