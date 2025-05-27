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
 * Entity class for "view_rel_planilha_custo" table
 */
#[Entity]
#[Table(name: "view_rel_planilha_custo")]
class ViewRelPlanilhaCusto extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer")]
    #[GeneratedValue]
    private int $idproposta;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(type: "string")]
    private string $cliente;

    #[Column(type: "string")]
    private string $modulo;

    #[Column(type: "string")]
    private string $item;

    #[Column(type: "decimal", nullable: true)]
    private ?string $porcentagem;

    #[Column(type: "decimal")]
    private string $valor;

    #[Column(type: "string", nullable: true)]
    private ?string $obs;

    #[Column(type: "integer")]
    private int $posicao;

    #[Column(name: "idplanilha_custo", type: "integer")]
    #[GeneratedValue]
    private int $idplanilhaCusto;

    #[Column(type: "string")]
    private string $cargo;

    #[Column(name: "sub_modulos", type: "integer")]
    private int $subModulos;

    #[Column(type: "integer")]
    private int $idcliente;

    public function __construct()
    {
        $this->valor = "0.00";
    }

    public function getIdproposta(): int
    {
        return $this->idproposta;
    }

    public function setIdproposta(int $value): static
    {
        $this->idproposta = $value;
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

    public function getCliente(): string
    {
        return HtmlDecode($this->cliente);
    }

    public function setCliente(string $value): static
    {
        $this->cliente = RemoveXss($value);
        return $this;
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

    public function getItem(): string
    {
        return HtmlDecode($this->item);
    }

    public function setItem(string $value): static
    {
        $this->item = RemoveXss($value);
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

    public function getPosicao(): int
    {
        return $this->posicao;
    }

    public function setPosicao(int $value): static
    {
        $this->posicao = $value;
        return $this;
    }

    public function getIdplanilhaCusto(): int
    {
        return $this->idplanilhaCusto;
    }

    public function setIdplanilhaCusto(int $value): static
    {
        $this->idplanilhaCusto = $value;
        return $this;
    }

    public function getCargo(): string
    {
        return HtmlDecode($this->cargo);
    }

    public function setCargo(string $value): static
    {
        $this->cargo = RemoveXss($value);
        return $this;
    }

    public function getSubModulos(): int
    {
        return $this->subModulos;
    }

    public function setSubModulos(int $value): static
    {
        $this->subModulos = $value;
        return $this;
    }

    public function getIdcliente(): int
    {
        return $this->idcliente;
    }

    public function setIdcliente(int $value): static
    {
        $this->idcliente = $value;
        return $this;
    }
}
