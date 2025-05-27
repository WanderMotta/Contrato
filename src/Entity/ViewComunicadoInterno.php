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
 * Entity class for "view_comunicado_interno" table
 */
#[Entity]
#[Table(name: "view_comunicado_interno")]
class ViewComunicadoInterno extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer")]
    #[GeneratedValue]
    private int $idproposta;

    #[Column(name: "dt_proposta", type: "date")]
    private DateTime $dtProposta;

    #[Column(type: "integer")]
    private int $consultor;

    #[Column(type: "string", nullable: true)]
    private ?string $cliente;

    #[Column(name: "cnpj_cli", type: "string", nullable: true)]
    private ?string $cnpjCli;

    #[Column(name: "end_cli", type: "string", nullable: true)]
    private ?string $endCli;

    #[Column(name: "nr_cli", type: "string", nullable: true)]
    private ?string $nrCli;

    #[Column(name: "bairro_cli", type: "string", nullable: true)]
    private ?string $bairroCli;

    #[Column(name: "cep_cli", type: "string", nullable: true)]
    private ?string $cepCli;

    #[Column(name: "cidade_cli", type: "string", nullable: true)]
    private ?string $cidadeCli;

    #[Column(name: "uf_cli", type: "string", nullable: true)]
    private ?string $ufCli;

    #[Column(name: "contato_cli", type: "string", nullable: true)]
    private ?string $contatoCli;

    #[Column(name: "email_cli", type: "string", nullable: true)]
    private ?string $emailCli;

    #[Column(name: "tel_cli", type: "string", nullable: true)]
    private ?string $telCli;

    #[Column(type: "string", nullable: true)]
    private ?string $faturamento;

    #[Column(name: "cnpj_fat", type: "string", nullable: true)]
    private ?string $cnpjFat;

    #[Column(name: "end_fat", type: "string", nullable: true)]
    private ?string $endFat;

    #[Column(name: "bairro_fat", type: "string", nullable: true)]
    private ?string $bairroFat;

    #[Column(name: "cidae_fat", type: "string", nullable: true)]
    private ?string $cidaeFat;

    #[Column(name: "uf_fat", type: "string", nullable: true)]
    private ?string $ufFat;

    #[Column(name: "origem_fat", type: "string", nullable: true)]
    private ?string $origemFat;

    #[Column(name: "dia_vencto_fat", type: "integer", nullable: true)]
    private ?int $diaVenctoFat;

    #[Column(type: "integer", nullable: true)]
    private ?int $quantidade;

    #[Column(type: "string", nullable: true)]
    private ?string $cargo;

    #[Column(type: "string", nullable: true)]
    private ?string $escala;

    #[Column(type: "string", nullable: true)]
    private ?string $periodo;

    #[Column(name: "intrajornada_tipo", type: "string", nullable: true)]
    private ?string $intrajornadaTipo;

    #[Column(name: "acumulo_funcao", type: "string", nullable: true)]
    private ?string $acumuloFuncao;

    public function __construct()
    {
        $this->ufCli = "SP";
        $this->cidaeFat = "São Paulo";
        $this->ufFat = "SP";
        $this->origemFat = "Condominio";
        $this->diaVenctoFat = 10;
        $this->quantidade = 1;
        $this->acumuloFuncao = "Nao";
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

    public function getDtProposta(): DateTime
    {
        return $this->dtProposta;
    }

    public function setDtProposta(DateTime $value): static
    {
        $this->dtProposta = $value;
        return $this;
    }

    public function getConsultor(): int
    {
        return $this->consultor;
    }

    public function setConsultor(int $value): static
    {
        $this->consultor = $value;
        return $this;
    }

    public function getCliente(): ?string
    {
        return HtmlDecode($this->cliente);
    }

    public function setCliente(?string $value): static
    {
        $this->cliente = RemoveXss($value);
        return $this;
    }

    public function getCnpjCli(): ?string
    {
        return HtmlDecode($this->cnpjCli);
    }

    public function setCnpjCli(?string $value): static
    {
        $this->cnpjCli = RemoveXss($value);
        return $this;
    }

    public function getEndCli(): ?string
    {
        return HtmlDecode($this->endCli);
    }

    public function setEndCli(?string $value): static
    {
        $this->endCli = RemoveXss($value);
        return $this;
    }

    public function getNrCli(): ?string
    {
        return HtmlDecode($this->nrCli);
    }

    public function setNrCli(?string $value): static
    {
        $this->nrCli = RemoveXss($value);
        return $this;
    }

    public function getBairroCli(): ?string
    {
        return HtmlDecode($this->bairroCli);
    }

    public function setBairroCli(?string $value): static
    {
        $this->bairroCli = RemoveXss($value);
        return $this;
    }

    public function getCepCli(): ?string
    {
        return HtmlDecode($this->cepCli);
    }

    public function setCepCli(?string $value): static
    {
        $this->cepCli = RemoveXss($value);
        return $this;
    }

    public function getCidadeCli(): ?string
    {
        return HtmlDecode($this->cidadeCli);
    }

    public function setCidadeCli(?string $value): static
    {
        $this->cidadeCli = RemoveXss($value);
        return $this;
    }

    public function getUfCli(): ?string
    {
        return HtmlDecode($this->ufCli);
    }

    public function setUfCli(?string $value): static
    {
        $this->ufCli = RemoveXss($value);
        return $this;
    }

    public function getContatoCli(): ?string
    {
        return HtmlDecode($this->contatoCli);
    }

    public function setContatoCli(?string $value): static
    {
        $this->contatoCli = RemoveXss($value);
        return $this;
    }

    public function getEmailCli(): ?string
    {
        return HtmlDecode($this->emailCli);
    }

    public function setEmailCli(?string $value): static
    {
        $this->emailCli = RemoveXss($value);
        return $this;
    }

    public function getTelCli(): ?string
    {
        return HtmlDecode($this->telCli);
    }

    public function setTelCli(?string $value): static
    {
        $this->telCli = RemoveXss($value);
        return $this;
    }

    public function getFaturamento(): ?string
    {
        return HtmlDecode($this->faturamento);
    }

    public function setFaturamento(?string $value): static
    {
        $this->faturamento = RemoveXss($value);
        return $this;
    }

    public function getCnpjFat(): ?string
    {
        return HtmlDecode($this->cnpjFat);
    }

    public function setCnpjFat(?string $value): static
    {
        $this->cnpjFat = RemoveXss($value);
        return $this;
    }

    public function getEndFat(): ?string
    {
        return HtmlDecode($this->endFat);
    }

    public function setEndFat(?string $value): static
    {
        $this->endFat = RemoveXss($value);
        return $this;
    }

    public function getBairroFat(): ?string
    {
        return HtmlDecode($this->bairroFat);
    }

    public function setBairroFat(?string $value): static
    {
        $this->bairroFat = RemoveXss($value);
        return $this;
    }

    public function getCidaeFat(): ?string
    {
        return HtmlDecode($this->cidaeFat);
    }

    public function setCidaeFat(?string $value): static
    {
        $this->cidaeFat = RemoveXss($value);
        return $this;
    }

    public function getUfFat(): ?string
    {
        return HtmlDecode($this->ufFat);
    }

    public function setUfFat(?string $value): static
    {
        $this->ufFat = RemoveXss($value);
        return $this;
    }

    public function getOrigemFat(): ?string
    {
        return $this->origemFat;
    }

    public function setOrigemFat(?string $value): static
    {
        if (!in_array($value, ["Condominio", "Administradora"])) {
            throw new \InvalidArgumentException("Invalid 'origem_fat' value");
        }
        $this->origemFat = $value;
        return $this;
    }

    public function getDiaVenctoFat(): ?int
    {
        return $this->diaVenctoFat;
    }

    public function setDiaVenctoFat(?int $value): static
    {
        $this->diaVenctoFat = $value;
        return $this;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(?int $value): static
    {
        $this->quantidade = $value;
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

    public function getEscala(): ?string
    {
        return HtmlDecode($this->escala);
    }

    public function setEscala(?string $value): static
    {
        $this->escala = RemoveXss($value);
        return $this;
    }

    public function getPeriodo(): ?string
    {
        return HtmlDecode($this->periodo);
    }

    public function setPeriodo(?string $value): static
    {
        $this->periodo = RemoveXss($value);
        return $this;
    }

    public function getIntrajornadaTipo(): ?string
    {
        return HtmlDecode($this->intrajornadaTipo);
    }

    public function setIntrajornadaTipo(?string $value): static
    {
        $this->intrajornadaTipo = RemoveXss($value);
        return $this;
    }

    public function getAcumuloFuncao(): ?string
    {
        return $this->acumuloFuncao;
    }

    public function setAcumuloFuncao(?string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'acumulo_funcao' value");
        }
        $this->acumuloFuncao = $value;
        return $this;
    }
}
