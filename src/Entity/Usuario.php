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
 * Entity class for "usuario" table
 */
#[Entity]
#[Table(name: "usuario")]
class Usuario extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idusuario;

    #[Column(type: "string")]
    private string $login;

    #[Column(type: "string")]
    private string $senha;

    #[Column(type: "integer")]
    private int $userlevel;

    #[Column(type: "string")]
    private string $ativo;

    public function __construct()
    {
        $this->userlevel = -1;
        $this->ativo = "Sim";
    }

    public function getIdusuario(): int
    {
        return $this->idusuario;
    }

    public function setIdusuario(int $value): static
    {
        $this->idusuario = $value;
        return $this;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $value): static
    {
        $this->login = $value;
        return $this;
    }

    public function getSenha(): string
    {
        return HtmlDecode($this->senha);
    }

    public function setSenha(string $value): static
    {
        $this->senha = RemoveXss($value);
        return $this;
    }

    public function getUserlevel(): int
    {
        return $this->userlevel;
    }

    public function setUserlevel(int $value): static
    {
        $this->userlevel = $value;
        return $this;
    }

    public function getAtivo(): string
    {
        return $this->ativo;
    }

    public function setAtivo(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'ativo' value");
        }
        $this->ativo = $value;
        return $this;
    }

    // Get login arguments
    public function getLoginArguments(): array
    {
        return [
            "userName" => $this->get('login'),
            "userId" => $this->get('idusuario'),
            "parentUserId" => null,
            "userLevel" => $this->get('userlevel') ?? AdvancedSecurity::ANONYMOUS_USER_LEVEL_ID,
            "userPrimaryKey" => $this->get('idusuario'),
        ];
    }
}
