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
 * Entity class for "movimento_pla_custo" table
 */
#[Entity]
#[Table(name: "movimento_pla_custo")]
class MovimentoPlaCusto extends AbstractEntity
{
    #[Id]
    #[Column(name: "idmovimento_pla_custo", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idmovimentoPlaCusto;

    #[Column(name: "planilha_custo_idplanilha_custo", type: "integer")]
    private int $planilhaCustoIdplanilhaCusto;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "modulo_idmodulo", type: "integer")]
    private int $moduloIdmodulo;

    #[Column(name: "itens_modulo_iditens_modulo", type: "integer")]
    private int $itensModuloIditensModulo;

    #[Column(type: "decimal", nullable: true)]
    private ?string $porcentagem;

    #[Column(type: "decimal")]
    private string $valor;

    #[Column(type: "string", nullable: true)]
    private ?string $obs;

    #[Column(name: "calculo_idcalculo", type: "integer", nullable: true)]
    private ?int $calculoIdcalculo;

    public function __construct()
    {
        $this->valor = "0.00";
    }

    public function getIdmovimentoPlaCusto(): int
    {
        return $this->idmovimentoPlaCusto;
    }

    public function setIdmovimentoPlaCusto(int $value): static
    {
        $this->idmovimentoPlaCusto = $value;
        return $this;
    }

    public function getPlanilhaCustoIdplanilhaCusto(): int
    {
        return $this->planilhaCustoIdplanilhaCusto;
    }

    public function setPlanilhaCustoIdplanilhaCusto(int $value): static
    {
        $this->planilhaCustoIdplanilhaCusto = $value;
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

    public function getModuloIdmodulo(): int
    {
        return $this->moduloIdmodulo;
    }

    public function setModuloIdmodulo(int $value): static
    {
        $this->moduloIdmodulo = $value;
        return $this;
    }

    public function getItensModuloIditensModulo(): int
    {
        return $this->itensModuloIditensModulo;
    }

    public function setItensModuloIditensModulo(int $value): static
    {
        $this->itensModuloIditensModulo = $value;
        return $this;
    }

    public function getPorcentagem(): ?string
    {
        return $this->porcentagem;
    }

    public function setPorcentagem(?string $value): static
    {
        $this->porcentagem = $value;
        return $this;
    }

    public function getValor(): string
    {
        return $this->valor;
    }

    public function setValor(string $value): static
    {
        $this->valor = $value;
        return $this;
    }

    public function getObs(): ?string
    {
        return HtmlDecode($this->obs);
    }

    public function setObs(?string $value): static
    {
        $this->obs = RemoveXss($value);
        return $this;
    }

    public function getCalculoIdcalculo(): ?int
    {
        return $this->calculoIdcalculo;
    }

    public function setCalculoIdcalculo(?int $value): static
    {
        $this->calculoIdcalculo = $value;
        return $this;
    }
}
