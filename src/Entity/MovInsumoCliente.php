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
 * Entity class for "mov_insumo_cliente" table
 */
#[Entity]
#[Table(name: "mov_insumo_cliente")]
class MovInsumoCliente extends AbstractEntity
{
    #[Id]
    #[Column(name: "idmov_insumo_cliente", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idmovInsumoCliente;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "tipo_insumo_idtipo_insumo", type: "integer")]
    private int $tipoInsumoIdtipoInsumo;

    #[Column(name: "insumo_idinsumo", type: "integer")]
    private int $insumoIdinsumo;

    #[Column(type: "decimal")]
    private string $qtde;

    #[Column(type: "decimal")]
    private string $frequencia;

    #[Column(name: "vr_unit", type: "decimal")]
    private string $vrUnit;

    #[Column(name: "proposta_idproposta", type: "integer")]
    private int $propostaIdproposta;

    public function __construct()
    {
        $this->qtde = "1.00";
        $this->frequencia = "12.0";
        $this->vrUnit = "0";
    }

    public function getIdmovInsumoCliente(): int
    {
        return $this->idmovInsumoCliente;
    }

    public function setIdmovInsumoCliente(int $value): static
    {
        $this->idmovInsumoCliente = $value;
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

    public function getFrequencia(): string
    {
        return $this->frequencia;
    }

    public function setFrequencia(string $value): static
    {
        $this->frequencia = $value;
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

    public function getPropostaIdproposta(): int
    {
        return $this->propostaIdproposta;
    }

    public function setPropostaIdproposta(int $value): static
    {
        $this->propostaIdproposta = $value;
        return $this;
    }
}
