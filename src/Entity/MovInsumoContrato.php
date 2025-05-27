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
 * Entity class for "mov_insumo_contrato" table
 */
#[Entity]
#[Table(name: "mov_insumo_contrato")]
class MovInsumoContrato extends AbstractEntity
{
    #[Id]
    #[Column(name: "idmov_insumo_contrato", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idmovInsumoContrato;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "tipo_insumo_idtipo_insumo", type: "integer")]
    private int $tipoInsumoIdtipoInsumo;

    #[Column(name: "insumo_idinsumo", type: "integer")]
    private int $insumoIdinsumo;

    #[Column(type: "decimal")]
    private string $qtde;

    #[Column(name: "vr_unit", type: "decimal")]
    private string $vrUnit;

    #[Column(type: "decimal")]
    private string $frequencia;

    #[Column(name: "contrato_idcontrato", type: "integer")]
    private int $contratoIdcontrato;

    public function __construct()
    {
        $this->qtde = "1.00";
        $this->frequencia = "12.0";
    }

    public function getIdmovInsumoContrato(): int
    {
        return $this->idmovInsumoContrato;
    }

    public function setIdmovInsumoContrato(int $value): static
    {
        $this->idmovInsumoContrato = $value;
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

    public function getTipoInsumoIdtipoInsumo(): int
    {
        return $this->tipoInsumoIdtipoInsumo;
    }

    public function setTipoInsumoIdtipoInsumo(int $value): static
    {
        $this->tipoInsumoIdtipoInsumo = $value;
        return $this;
    }

    public function getInsumoIdinsumo(): int
    {
        return $this->insumoIdinsumo;
    }

    public function setInsumoIdinsumo(int $value): static
    {
        $this->insumoIdinsumo = $value;
        return $this;
    }

    public function getQtde(): string
    {
        return $this->qtde;
    }

    public function setQtde(string $value): static
    {
        $this->qtde = $value;
        return $this;
    }

    public function getVrUnit(): string
    {
        return $this->vrUnit;
    }

    public function setVrUnit(string $value): static
    {
        $this->vrUnit = $value;
        return $this;
    }

    public function getFrequencia(): string
    {
        return $this->frequencia;
    }

    public function setFrequencia(string $value): static
    {
        $this->frequencia = $value;
        return $this;
    }

    public function getContratoIdcontrato(): int
    {
        return $this->contratoIdcontrato;
    }

    public function setContratoIdcontrato(int $value): static
    {
        $this->contratoIdcontrato = $value;
        return $this;
    }
}
