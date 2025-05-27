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
 * Entity class for "planilha_custo_contrato" table
 */
#[Entity]
#[Table(name: "planilha_custo_contrato")]
class PlanilhaCustoContrato extends AbstractEntity
{
    #[Id]
    #[Column(name: "idplanilha_custo_contrato", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idplanilhaCustoContrato;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(type: "integer")]
    private int $quantidade;

    #[Column(name: "escala_idescala", type: "integer")]
    private int $escalaIdescala;

    #[Column(name: "periodo_idperiodo", type: "integer")]
    private int $periodoIdperiodo;

    #[Column(name: "tipo_intrajornada_idtipo_intrajornada", type: "integer")]
    private int $tipoIntrajornadaIdtipoIntrajornada;

    #[Column(name: "cargo_idcargo", type: "integer")]
    private int $cargoIdcargo;

    #[Column(name: "acumulo_funcao", type: "string")]
    private string $acumuloFuncao;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    #[Column(name: "contrato_idcontrato", type: "integer")]
    private int $contratoIdcontrato;

    public function __construct()
    {
        $this->quantidade = 1;
        $this->tipoIntrajornadaIdtipoIntrajornada = 1;
        $this->acumuloFuncao = "Nao";
    }

    public function getIdplanilhaCustoContrato(): int
    {
        return $this->idplanilhaCustoContrato;
    }

    public function setIdplanilhaCustoContrato(int $value): static
    {
        $this->idplanilhaCustoContrato = $value;
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

    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $value): static
    {
        $this->quantidade = $value;
        return $this;
    }

    public function getEscalaIdescala(): int
    {
        return $this->escalaIdescala;
    }

    public function setEscalaIdescala(int $value): static
    {
        $this->escalaIdescala = $value;
        return $this;
    }

    public function getPeriodoIdperiodo(): int
    {
        return $this->periodoIdperiodo;
    }

    public function setPeriodoIdperiodo(int $value): static
    {
        $this->periodoIdperiodo = $value;
        return $this;
    }

    public function getTipoIntrajornadaIdtipoIntrajornada(): int
    {
        return $this->tipoIntrajornadaIdtipoIntrajornada;
    }

    public function setTipoIntrajornadaIdtipoIntrajornada(int $value): static
    {
        $this->tipoIntrajornadaIdtipoIntrajornada = $value;
        return $this;
    }

    public function getCargoIdcargo(): int
    {
        return $this->cargoIdcargo;
    }

    public function setCargoIdcargo(int $value): static
    {
        $this->cargoIdcargo = $value;
        return $this;
    }

    public function getAcumuloFuncao(): string
    {
        return $this->acumuloFuncao;
    }

    public function setAcumuloFuncao(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'acumulo_funcao' value");
        }
        $this->acumuloFuncao = $value;
        return $this;
    }

    public function getUsuarioIdusuario(): int
    {
        return $this->usuarioIdusuario;
    }

    public function setUsuarioIdusuario(int $value): static
    {
        $this->usuarioIdusuario = $value;
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
