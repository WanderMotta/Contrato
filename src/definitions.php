<?php

namespace PHPMaker2024\contratos;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Slim\HttpCache\CacheProvider;
use Slim\Flash\Messages;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Platforms;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Events;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Mime\MimeTypes;
use FastRoute\RouteParser\Std;
use Illuminate\Encryption\Encrypter;
use HTMLPurifier_Config;
use HTMLPurifier;

// Connections and entity managers
$definitions = [];
$dbids = array_keys(Config("Databases"));
foreach ($dbids as $dbid) {
    $definitions["connection." . $dbid] = \DI\factory(function (string $dbid) {
        return ConnectDb(Db($dbid));
    })->parameter("dbid", $dbid);
    $definitions["entitymanager." . $dbid] = \DI\factory(function (ContainerInterface $c, string $dbid) {
        $cache = IsDevelopment()
            ? DoctrineProvider::wrap(new ArrayAdapter())
            : DoctrineProvider::wrap(new FilesystemAdapter(directory: Config("DOCTRINE.CACHE_DIR")));
        $config = Setup::createAttributeMetadataConfiguration(
            Config("DOCTRINE.METADATA_DIRS"),
            IsDevelopment(),
            null,
            $cache
        );
        $conn = $c->get("connection." . $dbid);
        return new EntityManager($conn, $config);
    })->parameter("dbid", $dbid);
}

return [
    "app.cache" => \DI\create(CacheProvider::class),
    "app.flash" => fn(ContainerInterface $c) => new Messages(),
    "app.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "views/"),
    "email.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "lang/"),
    "sms.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "lang/"),
    "app.audit" => fn(ContainerInterface $c) => (new Logger("audit"))->pushHandler(new AuditTrailHandler($GLOBALS["RELATIVE_PATH"] . "log/audit.log")), // For audit trail
    "app.logger" => fn(ContainerInterface $c) => (new Logger("log"))->pushHandler(new RotatingFileHandler($GLOBALS["RELATIVE_PATH"] . "log/log.log")),
    "sql.logger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debug.stack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "app.csrf" => fn(ContainerInterface $c) => new Guard($GLOBALS["ResponseFactory"], Config("CSRF_PREFIX")),
    "html.purifier.config" => fn(ContainerInterface $c) => HTMLPurifier_Config::createDefault(),
    "html.purifier" => fn(ContainerInterface $c) => new HTMLPurifier($c->get("html.purifier.config")),
    "debug.stack" => \DI\create(DebugStack::class),
    "debug.sql.logger" => \DI\create(DebugSqlLogger::class),
    "debug.timer" => \DI\create(Timer::class),
    "app.security" => \DI\create(AdvancedSecurity::class),
    "user.profile" => \DI\create(UserProfile::class),
    "app.session" => \DI\create(HttpSession::class),
    "mime.types" => \DI\create(MimeTypes::class),
    "app.language" => \DI\create(Language::class),
    PermissionMiddleware::class => \DI\create(PermissionMiddleware::class),
    ApiPermissionMiddleware::class => \DI\create(ApiPermissionMiddleware::class),
    JwtMiddleware::class => \DI\create(JwtMiddleware::class),
    Std::class => \DI\create(Std::class),
    Encrypter::class => fn(ContainerInterface $c) => new Encrypter(AesEncryptionKey(base64_decode(Config("AES_ENCRYPTION_KEY"))), Config("AES_ENCRYPTION_CIPHER")),

    // Tables
    "cargo" => \DI\create(Cargo::class),
    "cliente" => \DI\create(Cliente::class),
    "contato" => \DI\create(Contato::class),
    "contrato" => \DI\create(Contrato::class),
    "escala" => \DI\create(Escala::class),
    "faturamento" => \DI\create(Faturamento::class),
    "insumo" => \DI\create(Insumo::class),
    "itens_modulo" => \DI\create(ItensModulo::class),
    "modulo" => \DI\create(Modulo::class),
    "mov_insumo_cliente" => \DI\create(MovInsumoCliente::class),
    "mov_insumo_contrato" => \DI\create(MovInsumoContrato::class),
    "movimento_pla_custo" => \DI\create(MovimentoPlaCusto::class),
    "periodo" => \DI\create(Periodo::class),
    "planilha_custo" => \DI\create(PlanilhaCusto::class),
    "planilha_custo_contrato" => \DI\create(PlanilhaCustoContrato::class),
    "proposta" => \DI\create(Proposta::class),
    "rel_comunicado_interno" => \DI\create(RelComunicadoInterno::class),
    "rel_cross_proposta" => \DI\create(RelCrossProposta::class),
    "rel_insumo_proposta" => \DI\create(RelInsumoProposta::class),
    "rel_planilha_custo" => \DI\create(RelPlanilhaCusto::class),
    "rel_teste" => \DI\create(RelTeste::class),
    "rel_view_unforme_pla_custo" => \DI\create(RelViewUnformePlaCusto::class),
    "tipo_insumo" => \DI\create(TipoInsumo::class),
    "tipo_intrajornada" => \DI\create(TipoIntrajornada::class),
    "tipo_uniforme" => \DI\create(TipoUniforme::class),
    "uniforme" => \DI\create(Uniforme::class),
    "uniforme_cargo" => \DI\create(UniformeCargo::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "usuario" => \DI\create(Usuario::class),
    "view_comunicado_interno" => \DI\create(ViewComunicadoInterno::class),
    "view_custo_salario" => \DI\create(ViewCustoSalario::class),
    "view_insumo_proposta_consolidado" => \DI\create(ViewInsumoPropostaConsolidado::class),
    "view_insumo_proposta_detalhada" => \DI\create(ViewInsumoPropostaDetalhada::class),
    "view_rel_planilha_custo" => \DI\create(ViewRelPlanilhaCusto::class),
    "view_uniforme_cargo_consolidado" => \DI\create(ViewUniformeCargoConsolidado::class),
    "view_uniforme_cargo_detalhada" => \DI\create(ViewUniformeCargoDetalhada::class),
    "view_uniforme_cargo_pla_custo" => \DI\create(ViewUniformeCargoPlaCusto::class),
    "view_contratos" => \DI\create(ViewContratos::class),
    "rel_contratos" => \DI\create(RelContratos::class),
    "view_lucro_prejuizo_contratos" => \DI\create(ViewLucroPrejuizoContratos::class),
    "view_efetivo_previsto" => \DI\create(ViewEfetivoPrevisto::class),
    "rel_cross_efetivo_previsto" => \DI\create(RelCrossEfetivoPrevisto::class),
    "view_mov_pla_custo_modulos" => \DI\create(ViewMovPlaCustoModulos::class),
    "calculo" => \DI\create(Calculo::class),
    "rel_orcamento_mensal" => \DI\create(RelOrcamentoMensal::class),
    "rel_view_lucro_prejuizo" => \DI\create(RelViewLucroPrejuizo::class),
    "view_rel_insumos_contratos" => \DI\create(ViewRelInsumosContratos::class),
    "rel_view_rel_insumos_contratos" => \DI\create(RelViewRelInsumosContratos::class),
    "funcao" => \DI\create(Funcao::class),
    "local" => \DI\create(Local::class),
    "view_export_previsto" => \DI\create(ViewExportPrevisto::class),
    "cargo_copy" => \DI\create(CargoCopy::class),
    "dissidio" => \DI\create(Dissidio::class),
    "beneficios" => \DI\create(Beneficios::class),
    "dissidio_anual" => \DI\create(DissidioAnual::class),
    "view_contrato_valor_atualizado" => \DI\create(ViewContratoValorAtualizado::class),
    "rel_view_contrato_vr_atualizado" => \DI\create(RelViewContratoVrAtualizado::class),
    "view_rel_cargo_custo_indv" => \DI\create(ViewRelCargoCustoIndv::class),
    "rel_view_rel_cargo_custo_indv" => \DI\create(RelViewRelCargoCustoIndv::class),

    // User table
    "usertable" => \DI\get("usuario"),
] + $definitions;
