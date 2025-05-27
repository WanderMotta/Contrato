<?php

namespace PHPMaker2024\contratos;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Closure;

/**
 * Table class for view_comunicado_interno
 */
class ViewComunicadoInterno extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $DbErrorMessage = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Ajax / Modal
    public $UseAjaxActions = false;
    public $ModalSearch = false;
    public $ModalView = false;
    public $ModalAdd = false;
    public $ModalEdit = false;
    public $ModalUpdate = false;
    public $InlineDelete = false;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $idproposta;
    public $dt_proposta;
    public $consultor;
    public $cliente;
    public $cnpj_cli;
    public $end_cli;
    public $nr_cli;
    public $bairro_cli;
    public $cep_cli;
    public $cidade_cli;
    public $uf_cli;
    public $contato_cli;
    public $email_cli;
    public $tel_cli;
    public $faturamento;
    public $cnpj_fat;
    public $end_fat;
    public $bairro_fat;
    public $cidae_fat;
    public $uf_fat;
    public $origem_fat;
    public $dia_vencto_fat;
    public $quantidade;
    public $cargo;
    public $escala;
    public $periodo;
    public $intrajornada_tipo;
    public $acumulo_funcao;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "view_comunicado_interno";
        $this->TableName = 'view_comunicado_interno';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_comunicado_interno";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // idproposta
        $this->idproposta = new DbField(
            $this, // Table
            'x_idproposta', // Variable name
            'idproposta', // Name
            '`idproposta`', // Expression
            '`idproposta`', // Basic search expression
            19, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idproposta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idproposta->InputTextType = "text";
        $this->idproposta->Raw = true;
        $this->idproposta->IsAutoIncrement = true; // Autoincrement field
        $this->idproposta->IsPrimaryKey = true; // Primary key field
        $this->idproposta->Nullable = false; // NOT NULL field
        $this->idproposta->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idproposta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idproposta'] = &$this->idproposta;

        // dt_proposta
        $this->dt_proposta = new DbField(
            $this, // Table
            'x_dt_proposta', // Variable name
            'dt_proposta', // Name
            '`dt_proposta`', // Expression
            CastDateFieldForLike("`dt_proposta`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`dt_proposta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dt_proposta->InputTextType = "text";
        $this->dt_proposta->Raw = true;
        $this->dt_proposta->Nullable = false; // NOT NULL field
        $this->dt_proposta->Required = true; // Required field
        $this->dt_proposta->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_proposta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dt_proposta'] = &$this->dt_proposta;

        // consultor
        $this->consultor = new DbField(
            $this, // Table
            'x_consultor', // Variable name
            'consultor', // Name
            '`consultor`', // Expression
            '`consultor`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`consultor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->consultor->InputTextType = "text";
        $this->consultor->Raw = true;
        $this->consultor->Nullable = false; // NOT NULL field
        $this->consultor->Required = true; // Required field
        $this->consultor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->consultor->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['consultor'] = &$this->consultor;

        // cliente
        $this->cliente = new DbField(
            $this, // Table
            'x_cliente', // Variable name
            'cliente', // Name
            '`cliente`', // Expression
            '`cliente`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cliente`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cliente->InputTextType = "text";
        $this->cliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cliente'] = &$this->cliente;

        // cnpj_cli
        $this->cnpj_cli = new DbField(
            $this, // Table
            'x_cnpj_cli', // Variable name
            'cnpj_cli', // Name
            '`cnpj_cli`', // Expression
            '`cnpj_cli`', // Basic search expression
            200, // Type
            18, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cnpj_cli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cnpj_cli->InputTextType = "text";
        $this->cnpj_cli->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cnpj_cli'] = &$this->cnpj_cli;

        // end_cli
        $this->end_cli = new DbField(
            $this, // Table
            'x_end_cli', // Variable name
            'end_cli', // Name
            '`end_cli`', // Expression
            '`end_cli`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`end_cli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->end_cli->InputTextType = "text";
        $this->end_cli->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['end_cli'] = &$this->end_cli;

        // nr_cli
        $this->nr_cli = new DbField(
            $this, // Table
            'x_nr_cli', // Variable name
            'nr_cli', // Name
            '`nr_cli`', // Expression
            '`nr_cli`', // Basic search expression
            200, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nr_cli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nr_cli->InputTextType = "text";
        $this->nr_cli->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nr_cli'] = &$this->nr_cli;

        // bairro_cli
        $this->bairro_cli = new DbField(
            $this, // Table
            'x_bairro_cli', // Variable name
            'bairro_cli', // Name
            '`bairro_cli`', // Expression
            '`bairro_cli`', // Basic search expression
            200, // Type
            45, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`bairro_cli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->bairro_cli->InputTextType = "text";
        $this->bairro_cli->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['bairro_cli'] = &$this->bairro_cli;

        // cep_cli
        $this->cep_cli = new DbField(
            $this, // Table
            'x_cep_cli', // Variable name
            'cep_cli', // Name
            '`cep_cli`', // Expression
            '`cep_cli`', // Basic search expression
            200, // Type
            9, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cep_cli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cep_cli->InputTextType = "text";
        $this->cep_cli->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cep_cli'] = &$this->cep_cli;

        // cidade_cli
        $this->cidade_cli = new DbField(
            $this, // Table
            'x_cidade_cli', // Variable name
            'cidade_cli', // Name
            '`cidade_cli`', // Expression
            '`cidade_cli`', // Basic search expression
            200, // Type
            45, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cidade_cli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cidade_cli->InputTextType = "text";
        $this->cidade_cli->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cidade_cli'] = &$this->cidade_cli;

        // uf_cli
        $this->uf_cli = new DbField(
            $this, // Table
            'x_uf_cli', // Variable name
            'uf_cli', // Name
            '`uf_cli`', // Expression
            '`uf_cli`', // Basic search expression
            200, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`uf_cli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->uf_cli->addMethod("getDefault", fn() => "SP");
        $this->uf_cli->InputTextType = "text";
        $this->uf_cli->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['uf_cli'] = &$this->uf_cli;

        // contato_cli
        $this->contato_cli = new DbField(
            $this, // Table
            'x_contato_cli', // Variable name
            'contato_cli', // Name
            '`contato_cli`', // Expression
            '`contato_cli`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`contato_cli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->contato_cli->InputTextType = "text";
        $this->contato_cli->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['contato_cli'] = &$this->contato_cli;

        // email_cli
        $this->email_cli = new DbField(
            $this, // Table
            'x_email_cli', // Variable name
            'email_cli', // Name
            '`email_cli`', // Expression
            '`email_cli`', // Basic search expression
            200, // Type
            120, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`email_cli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->email_cli->InputTextType = "text";
        $this->email_cli->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['email_cli'] = &$this->email_cli;

        // tel_cli
        $this->tel_cli = new DbField(
            $this, // Table
            'x_tel_cli', // Variable name
            'tel_cli', // Name
            '`tel_cli`', // Expression
            '`tel_cli`', // Basic search expression
            200, // Type
            120, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tel_cli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tel_cli->InputTextType = "text";
        $this->tel_cli->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['tel_cli'] = &$this->tel_cli;

        // faturamento
        $this->faturamento = new DbField(
            $this, // Table
            'x_faturamento', // Variable name
            'faturamento', // Name
            '`faturamento`', // Expression
            '`faturamento`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`faturamento`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->faturamento->InputTextType = "text";
        $this->faturamento->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['faturamento'] = &$this->faturamento;

        // cnpj_fat
        $this->cnpj_fat = new DbField(
            $this, // Table
            'x_cnpj_fat', // Variable name
            'cnpj_fat', // Name
            '`cnpj_fat`', // Expression
            '`cnpj_fat`', // Basic search expression
            200, // Type
            18, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cnpj_fat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cnpj_fat->InputTextType = "text";
        $this->cnpj_fat->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cnpj_fat'] = &$this->cnpj_fat;

        // end_fat
        $this->end_fat = new DbField(
            $this, // Table
            'x_end_fat', // Variable name
            'end_fat', // Name
            '`end_fat`', // Expression
            '`end_fat`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`end_fat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->end_fat->InputTextType = "text";
        $this->end_fat->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['end_fat'] = &$this->end_fat;

        // bairro_fat
        $this->bairro_fat = new DbField(
            $this, // Table
            'x_bairro_fat', // Variable name
            'bairro_fat', // Name
            '`bairro_fat`', // Expression
            '`bairro_fat`', // Basic search expression
            200, // Type
            45, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`bairro_fat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->bairro_fat->InputTextType = "text";
        $this->bairro_fat->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['bairro_fat'] = &$this->bairro_fat;

        // cidae_fat
        $this->cidae_fat = new DbField(
            $this, // Table
            'x_cidae_fat', // Variable name
            'cidae_fat', // Name
            '`cidae_fat`', // Expression
            '`cidae_fat`', // Basic search expression
            200, // Type
            45, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cidae_fat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cidae_fat->addMethod("getDefault", fn() => "São Paulo");
        $this->cidae_fat->InputTextType = "text";
        $this->cidae_fat->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cidae_fat'] = &$this->cidae_fat;

        // uf_fat
        $this->uf_fat = new DbField(
            $this, // Table
            'x_uf_fat', // Variable name
            'uf_fat', // Name
            '`uf_fat`', // Expression
            '`uf_fat`', // Basic search expression
            200, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`uf_fat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->uf_fat->addMethod("getDefault", fn() => "SP");
        $this->uf_fat->InputTextType = "text";
        $this->uf_fat->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['uf_fat'] = &$this->uf_fat;

        // origem_fat
        $this->origem_fat = new DbField(
            $this, // Table
            'x_origem_fat', // Variable name
            'origem_fat', // Name
            '`origem_fat`', // Expression
            '`origem_fat`', // Basic search expression
            200, // Type
            14, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`origem_fat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->origem_fat->addMethod("getDefault", fn() => "Condominio");
        $this->origem_fat->InputTextType = "text";
        $this->origem_fat->Raw = true;
        $this->origem_fat->Lookup = new Lookup($this->origem_fat, 'view_comunicado_interno', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->origem_fat->OptionCount = 2;
        $this->origem_fat->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['origem_fat'] = &$this->origem_fat;

        // dia_vencto_fat
        $this->dia_vencto_fat = new DbField(
            $this, // Table
            'x_dia_vencto_fat', // Variable name
            'dia_vencto_fat', // Name
            '`dia_vencto_fat`', // Expression
            '`dia_vencto_fat`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`dia_vencto_fat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dia_vencto_fat->addMethod("getDefault", fn() => 10);
        $this->dia_vencto_fat->InputTextType = "text";
        $this->dia_vencto_fat->Raw = true;
        $this->dia_vencto_fat->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->dia_vencto_fat->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['dia_vencto_fat'] = &$this->dia_vencto_fat;

        // quantidade
        $this->quantidade = new DbField(
            $this, // Table
            'x_quantidade', // Variable name
            'quantidade', // Name
            '`quantidade`', // Expression
            '`quantidade`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`quantidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->quantidade->addMethod("getDefault", fn() => 1);
        $this->quantidade->InputTextType = "text";
        $this->quantidade->Raw = true;
        $this->quantidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->quantidade->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['quantidade'] = &$this->quantidade;

        // cargo
        $this->cargo = new DbField(
            $this, // Table
            'x_cargo', // Variable name
            'cargo', // Name
            '`cargo`', // Expression
            '`cargo`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cargo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cargo->InputTextType = "text";
        $this->cargo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cargo'] = &$this->cargo;

        // escala
        $this->escala = new DbField(
            $this, // Table
            'x_escala', // Variable name
            'escala', // Name
            '`escala`', // Expression
            '`escala`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`escala`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->escala->InputTextType = "text";
        $this->escala->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['escala'] = &$this->escala;

        // periodo
        $this->periodo = new DbField(
            $this, // Table
            'x_periodo', // Variable name
            'periodo', // Name
            '`periodo`', // Expression
            '`periodo`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`periodo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->periodo->InputTextType = "text";
        $this->periodo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['periodo'] = &$this->periodo;

        // intrajornada_tipo
        $this->intrajornada_tipo = new DbField(
            $this, // Table
            'x_intrajornada_tipo', // Variable name
            'intrajornada_tipo', // Name
            '`intrajornada_tipo`', // Expression
            '`intrajornada_tipo`', // Basic search expression
            200, // Type
            35, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`intrajornada_tipo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->intrajornada_tipo->InputTextType = "text";
        $this->intrajornada_tipo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['intrajornada_tipo'] = &$this->intrajornada_tipo;

        // acumulo_funcao
        $this->acumulo_funcao = new DbField(
            $this, // Table
            'x_acumulo_funcao', // Variable name
            'acumulo_funcao', // Name
            '`acumulo_funcao`', // Expression
            '`acumulo_funcao`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`acumulo_funcao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->acumulo_funcao->addMethod("getDefault", fn() => "Nao");
        $this->acumulo_funcao->InputTextType = "text";
        $this->acumulo_funcao->Raw = true;
        $this->acumulo_funcao->Lookup = new Lookup($this->acumulo_funcao, 'view_comunicado_interno', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->acumulo_funcao->OptionCount = 2;
        $this->acumulo_funcao->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['acumulo_funcao'] = &$this->acumulo_funcao;

        // Add Doctrine Cache
        $this->Cache = new \Symfony\Component\Cache\Adapter\ArrayAdapter();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);

        // Call Table Load event
        $this->tableLoad();
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Multiple column sort
    public function updateSort(&$fld, $ctrl)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($ctrl) {
                $orderBy = $this->getSessionOrderBy();
                $arOrderBy = !empty($orderBy) ? explode(", ", $orderBy) : [];
                if ($lastOrderBy != "" && in_array($lastOrderBy, $arOrderBy)) {
                    foreach ($arOrderBy as $key => $val) {
                        if ($val == $lastOrderBy) {
                            if ($curOrderBy == "") {
                                unset($arOrderBy[$key]);
                            } else {
                                $arOrderBy[$key] = $curOrderBy;
                            }
                        }
                    }
                } elseif ($curOrderBy != "") {
                    $arOrderBy[] = $curOrderBy;
                }
                $orderBy = implode(", ", $arOrderBy);
                $this->setSessionOrderBy($orderBy); // Save to Session
            } else {
                $this->setSessionOrderBy($curOrderBy); // Save to Session
            }
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_comunicado_interno";
    }

    // Get FROM clause (for backward compatibility)
    public function sqlFrom()
    {
        return $this->getSqlFrom();
    }

    // Set FROM clause
    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    // Get SELECT clause
    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select($this->sqlSelectFields());
    }

    // Get list of fields
    private function sqlSelectFields()
    {
        $useFieldNames = false;
        $fieldNames = [];
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($this->Fields as $field) {
            $expr = $field->Expression;
            $customExpr = $field->CustomDataType?->convertToPHPValueSQL($expr, $platform) ?? $expr;
            if ($customExpr != $expr) {
                $fieldNames[] = $customExpr . " AS " . QuotedName($field->Name, $this->Dbid);
                $useFieldNames = true;
            } else {
                $fieldNames[] = $expr;
            }
        }
        return $useFieldNames ? implode(", ", $fieldNames) : "*";
    }

    // Get SELECT clause (for backward compatibility)
    public function sqlSelect()
    {
        return $this->getSqlSelect();
    }

    // Set SELECT clause
    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    // Get WHERE clause
    public function getSqlWhere()
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    // Get WHERE clause (for backward compatibility)
    public function sqlWhere()
    {
        return $this->getSqlWhere();
    }

    // Set WHERE clause
    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    // Get GROUP BY clause
    public function getSqlGroupBy()
    {
        return $this->SqlGroupBy != "" ? $this->SqlGroupBy : "";
    }

    // Get GROUP BY clause (for backward compatibility)
    public function sqlGroupBy()
    {
        return $this->getSqlGroupBy();
    }

    // set GROUP BY clause
    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    // Get HAVING clause
    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    // Get HAVING clause (for backward compatibility)
    public function sqlHaving()
    {
        return $this->getSqlHaving();
    }

    // Set HAVING clause
    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    // Get ORDER BY clause
    public function getSqlOrderBy()
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    // Get ORDER BY clause (for backward compatibility)
    public function sqlOrderBy()
    {
        return $this->getSqlOrderBy();
    }

    // set ORDER BY clause
    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return ($allow & Allow::ADD->value) == Allow::ADD->value;
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return ($allow & Allow::EDIT->value) == Allow::EDIT->value;
            case "delete":
                return ($allow & Allow::DELETE->value) == Allow::DELETE->value;
            case "view":
                return ($allow & Allow::VIEW->value) == Allow::VIEW->value;
            case "search":
                return ($allow & Allow::SEARCH->value) == Allow::SEARCH->value;
            case "lookup":
                return ($allow & Allow::LOOKUP->value) == Allow::LOOKUP->value;
            default:
                return ($allow & Allow::LIST->value) == Allow::LIST->value;
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $sqlwrk = $sql instanceof QueryBuilder // Query builder
            ? (clone $sql)->resetQueryPart("orderBy")->getSQL()
            : $sql;
        $pattern = '/^SELECT\s([\s\S]+?)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            in_array($this->TableType, ["TABLE", "VIEW", "LINKTABLE"]) &&
            preg_match($pattern, $sqlwrk) &&
            !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*SELECT\s+DISTINCT\s+/i', $sqlwrk) &&
            !preg_match('/\s+ORDER\s+BY\s+/i', $sqlwrk)
        ) {
            $sqlcnt = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlcnt = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlcnt);
        if ($cnt !== false) {
            return (int)$cnt;
        }
        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        $result = $conn->executeQuery($sqlwrk);
        $cnt = $result->rowCount();
        if ($cnt == 0) { // Unable to get record count, count directly
            while ($result->fetch()) {
                $cnt++;
            }
        }
        return $cnt;
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->getSqlAsQueryBuilder($where, $orderBy)->getSQL();
    }

    // Get QueryBuilder
    public function getSqlAsQueryBuilder($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        );
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->setValue($field->Expression, $parm);
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        try {
            $queryBuilder = $this->insertSql($rs);
            $result = $queryBuilder->executeStatement();
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $result = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($result) {
            $this->idproposta->setDbValue($conn->lastInsertId());
            $rs['idproposta'] = $this->idproposta->DbValue;
        }
        return $result;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->set($field->Expression, $parm);
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        try {
            $success = $this->updateSql($rs, $where, $curfilter)->executeStatement();
            $success = $success > 0 ? $success : true;
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }

        // Return auto increment field
        if ($success) {
            if (!isset($rs['idproposta']) && !EmptyValue($this->idproposta->CurrentValue)) {
                $rs['idproposta'] = $this->idproposta->CurrentValue;
            }
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('idproposta', $rs)) {
                AddFilter($where, QuotedName('idproposta', $this->Dbid) . '=' . QuotedValue($rs['idproposta'], $this->idproposta->DataType, $this->Dbid));
            }
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            try {
                $success = $this->deleteSql($rs, $where, $curfilter)->executeStatement();
                $this->DbErrorMessage = "";
            } catch (\Exception $e) {
                $success = false;
                $this->DbErrorMessage = $e->getMessage();
            }
        }
        return $success;
    }

    // Load DbValue from result set or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->idproposta->DbValue = $row['idproposta'];
        $this->dt_proposta->DbValue = $row['dt_proposta'];
        $this->consultor->DbValue = $row['consultor'];
        $this->cliente->DbValue = $row['cliente'];
        $this->cnpj_cli->DbValue = $row['cnpj_cli'];
        $this->end_cli->DbValue = $row['end_cli'];
        $this->nr_cli->DbValue = $row['nr_cli'];
        $this->bairro_cli->DbValue = $row['bairro_cli'];
        $this->cep_cli->DbValue = $row['cep_cli'];
        $this->cidade_cli->DbValue = $row['cidade_cli'];
        $this->uf_cli->DbValue = $row['uf_cli'];
        $this->contato_cli->DbValue = $row['contato_cli'];
        $this->email_cli->DbValue = $row['email_cli'];
        $this->tel_cli->DbValue = $row['tel_cli'];
        $this->faturamento->DbValue = $row['faturamento'];
        $this->cnpj_fat->DbValue = $row['cnpj_fat'];
        $this->end_fat->DbValue = $row['end_fat'];
        $this->bairro_fat->DbValue = $row['bairro_fat'];
        $this->cidae_fat->DbValue = $row['cidae_fat'];
        $this->uf_fat->DbValue = $row['uf_fat'];
        $this->origem_fat->DbValue = $row['origem_fat'];
        $this->dia_vencto_fat->DbValue = $row['dia_vencto_fat'];
        $this->quantidade->DbValue = $row['quantidade'];
        $this->cargo->DbValue = $row['cargo'];
        $this->escala->DbValue = $row['escala'];
        $this->periodo->DbValue = $row['periodo'];
        $this->intrajornada_tipo->DbValue = $row['intrajornada_tipo'];
        $this->acumulo_funcao->DbValue = $row['acumulo_funcao'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idproposta` = @idproposta@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idproposta->CurrentValue : $this->idproposta->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Set Key
    public function setKey($key, $current = false, $keySeparator = null)
    {
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        $this->OldKey = strval($key);
        $keys = explode($keySeparator, $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->idproposta->CurrentValue = $keys[0];
            } else {
                $this->idproposta->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idproposta', $row) ? $row['idproposta'] : null;
        } else {
            $val = !EmptyValue($this->idproposta->OldValue) && !$current ? $this->idproposta->OldValue : $this->idproposta->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idproposta@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("ViewComunicadoInternoList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        return match ($pageName) {
            "ViewComunicadoInternoView" => $Language->phrase("View"),
            "ViewComunicadoInternoEdit" => $Language->phrase("Edit"),
            "ViewComunicadoInternoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewComunicadoInternoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewComunicadoInternoView",
            Config("API_ADD_ACTION") => "ViewComunicadoInternoAdd",
            Config("API_EDIT_ACTION") => "ViewComunicadoInternoEdit",
            Config("API_DELETE_ACTION") => "ViewComunicadoInternoDelete",
            Config("API_LIST_ACTION") => "ViewComunicadoInternoList",
            default => ""
        };
    }

    // Current URL
    public function getCurrentUrl($parm = "")
    {
        $url = CurrentPageUrl(false);
        if ($parm != "") {
            $url = $this->keyUrl($url, $parm);
        } else {
            $url = $this->keyUrl($url, Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // List URL
    public function getListUrl()
    {
        return "ViewComunicadoInternoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewComunicadoInternoView", $parm);
        } else {
            $url = $this->keyUrl("ViewComunicadoInternoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewComunicadoInternoAdd?" . $parm;
        } else {
            $url = "ViewComunicadoInternoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewComunicadoInternoEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewComunicadoInternoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewComunicadoInternoAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewComunicadoInternoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewComunicadoInternoDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"idproposta\":" . VarToJson($this->idproposta->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idproposta->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idproposta->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($this->PageID != "grid" && $fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="2"';
            if ($this->ContextClass) { // Add context
                $attrs .= ' data-context="' . HtmlEncode($this->ContextClass) . '"';
            }
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($this->PageID != "grid" && !$this->isExport() && $fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") .
                (is_array($fld->EditValue) ? str_replace("%c", count($fld->EditValue), $Language->phrase("FilterCount")) : '') .
                '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport;
            }
            return $this->addMasterUrl($this->CurrentPageName . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            $isApi = IsApi();
            $keyValues = $isApi
                ? (Route(0) == "export"
                    ? array_map(fn ($i) => Route($i + 3), range(0, 0))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, 0))) // Other API
                : []; // Non-API
            if (($keyValue = Param("idproposta") ?? Route("idproposta")) !== null) {
                $arKeys[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(0) ?? $keyValues[0] ?? null) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from records
    public function getFilterFromRecords($rows)
    {
        return implode(" OR ", array_map(fn($row) => "(" . $this->getRecordFilter($row) . ")", $rows));
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->idproposta->CurrentValue = $key;
            } else {
                $this->idproposta->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load result set based on filter/sort
    public function loadRs($filter, $sort = "")
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->idproposta->setDbValue($row['idproposta']);
        $this->dt_proposta->setDbValue($row['dt_proposta']);
        $this->consultor->setDbValue($row['consultor']);
        $this->cliente->setDbValue($row['cliente']);
        $this->cnpj_cli->setDbValue($row['cnpj_cli']);
        $this->end_cli->setDbValue($row['end_cli']);
        $this->nr_cli->setDbValue($row['nr_cli']);
        $this->bairro_cli->setDbValue($row['bairro_cli']);
        $this->cep_cli->setDbValue($row['cep_cli']);
        $this->cidade_cli->setDbValue($row['cidade_cli']);
        $this->uf_cli->setDbValue($row['uf_cli']);
        $this->contato_cli->setDbValue($row['contato_cli']);
        $this->email_cli->setDbValue($row['email_cli']);
        $this->tel_cli->setDbValue($row['tel_cli']);
        $this->faturamento->setDbValue($row['faturamento']);
        $this->cnpj_fat->setDbValue($row['cnpj_fat']);
        $this->end_fat->setDbValue($row['end_fat']);
        $this->bairro_fat->setDbValue($row['bairro_fat']);
        $this->cidae_fat->setDbValue($row['cidae_fat']);
        $this->uf_fat->setDbValue($row['uf_fat']);
        $this->origem_fat->setDbValue($row['origem_fat']);
        $this->dia_vencto_fat->setDbValue($row['dia_vencto_fat']);
        $this->quantidade->setDbValue($row['quantidade']);
        $this->cargo->setDbValue($row['cargo']);
        $this->escala->setDbValue($row['escala']);
        $this->periodo->setDbValue($row['periodo']);
        $this->intrajornada_tipo->setDbValue($row['intrajornada_tipo']);
        $this->acumulo_funcao->setDbValue($row['acumulo_funcao']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewComunicadoInternoList";
        $listClass = PROJECT_NAMESPACE . $listPage;
        $page = new $listClass();
        $page->loadRecordsetFromFilter($filter);
        $view = Container("app.view");
        $template = $listPage . ".php"; // View
        $GLOBALS["Title"] ??= $page->Title; // Title
        try {
            $Response = $view->render($Response, $template, $GLOBALS);
        } finally {
            $page->terminate(); // Terminate page and clean up
        }
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // idproposta

        // dt_proposta

        // consultor

        // cliente

        // cnpj_cli

        // end_cli

        // nr_cli

        // bairro_cli

        // cep_cli

        // cidade_cli

        // uf_cli

        // contato_cli

        // email_cli

        // tel_cli

        // faturamento

        // cnpj_fat

        // end_fat

        // bairro_fat

        // cidae_fat

        // uf_fat

        // origem_fat

        // dia_vencto_fat

        // quantidade

        // cargo

        // escala

        // periodo

        // intrajornada_tipo

        // acumulo_funcao

        // idproposta
        $this->idproposta->ViewValue = $this->idproposta->CurrentValue;

        // dt_proposta
        $this->dt_proposta->ViewValue = $this->dt_proposta->CurrentValue;
        $this->dt_proposta->ViewValue = FormatDateTime($this->dt_proposta->ViewValue, $this->dt_proposta->formatPattern());

        // consultor
        $this->consultor->ViewValue = $this->consultor->CurrentValue;
        $this->consultor->ViewValue = FormatNumber($this->consultor->ViewValue, $this->consultor->formatPattern());

        // cliente
        $this->cliente->ViewValue = $this->cliente->CurrentValue;

        // cnpj_cli
        $this->cnpj_cli->ViewValue = $this->cnpj_cli->CurrentValue;

        // end_cli
        $this->end_cli->ViewValue = $this->end_cli->CurrentValue;

        // nr_cli
        $this->nr_cli->ViewValue = $this->nr_cli->CurrentValue;

        // bairro_cli
        $this->bairro_cli->ViewValue = $this->bairro_cli->CurrentValue;

        // cep_cli
        $this->cep_cli->ViewValue = $this->cep_cli->CurrentValue;

        // cidade_cli
        $this->cidade_cli->ViewValue = $this->cidade_cli->CurrentValue;

        // uf_cli
        $this->uf_cli->ViewValue = $this->uf_cli->CurrentValue;

        // contato_cli
        $this->contato_cli->ViewValue = $this->contato_cli->CurrentValue;

        // email_cli
        $this->email_cli->ViewValue = $this->email_cli->CurrentValue;

        // tel_cli
        $this->tel_cli->ViewValue = $this->tel_cli->CurrentValue;

        // faturamento
        $this->faturamento->ViewValue = $this->faturamento->CurrentValue;

        // cnpj_fat
        $this->cnpj_fat->ViewValue = $this->cnpj_fat->CurrentValue;

        // end_fat
        $this->end_fat->ViewValue = $this->end_fat->CurrentValue;

        // bairro_fat
        $this->bairro_fat->ViewValue = $this->bairro_fat->CurrentValue;

        // cidae_fat
        $this->cidae_fat->ViewValue = $this->cidae_fat->CurrentValue;

        // uf_fat
        $this->uf_fat->ViewValue = $this->uf_fat->CurrentValue;

        // origem_fat
        if (strval($this->origem_fat->CurrentValue) != "") {
            $this->origem_fat->ViewValue = $this->origem_fat->optionCaption($this->origem_fat->CurrentValue);
        } else {
            $this->origem_fat->ViewValue = null;
        }

        // dia_vencto_fat
        $this->dia_vencto_fat->ViewValue = $this->dia_vencto_fat->CurrentValue;
        $this->dia_vencto_fat->ViewValue = FormatNumber($this->dia_vencto_fat->ViewValue, $this->dia_vencto_fat->formatPattern());

        // quantidade
        $this->quantidade->ViewValue = $this->quantidade->CurrentValue;
        $this->quantidade->ViewValue = FormatNumber($this->quantidade->ViewValue, $this->quantidade->formatPattern());

        // cargo
        $this->cargo->ViewValue = $this->cargo->CurrentValue;

        // escala
        $this->escala->ViewValue = $this->escala->CurrentValue;

        // periodo
        $this->periodo->ViewValue = $this->periodo->CurrentValue;

        // intrajornada_tipo
        $this->intrajornada_tipo->ViewValue = $this->intrajornada_tipo->CurrentValue;

        // acumulo_funcao
        if (strval($this->acumulo_funcao->CurrentValue) != "") {
            $this->acumulo_funcao->ViewValue = $this->acumulo_funcao->optionCaption($this->acumulo_funcao->CurrentValue);
        } else {
            $this->acumulo_funcao->ViewValue = null;
        }

        // idproposta
        $this->idproposta->HrefValue = "";
        $this->idproposta->TooltipValue = "";

        // dt_proposta
        $this->dt_proposta->HrefValue = "";
        $this->dt_proposta->TooltipValue = "";

        // consultor
        $this->consultor->HrefValue = "";
        $this->consultor->TooltipValue = "";

        // cliente
        $this->cliente->HrefValue = "";
        $this->cliente->TooltipValue = "";

        // cnpj_cli
        $this->cnpj_cli->HrefValue = "";
        $this->cnpj_cli->TooltipValue = "";

        // end_cli
        $this->end_cli->HrefValue = "";
        $this->end_cli->TooltipValue = "";

        // nr_cli
        $this->nr_cli->HrefValue = "";
        $this->nr_cli->TooltipValue = "";

        // bairro_cli
        $this->bairro_cli->HrefValue = "";
        $this->bairro_cli->TooltipValue = "";

        // cep_cli
        $this->cep_cli->HrefValue = "";
        $this->cep_cli->TooltipValue = "";

        // cidade_cli
        $this->cidade_cli->HrefValue = "";
        $this->cidade_cli->TooltipValue = "";

        // uf_cli
        $this->uf_cli->HrefValue = "";
        $this->uf_cli->TooltipValue = "";

        // contato_cli
        $this->contato_cli->HrefValue = "";
        $this->contato_cli->TooltipValue = "";

        // email_cli
        $this->email_cli->HrefValue = "";
        $this->email_cli->TooltipValue = "";

        // tel_cli
        $this->tel_cli->HrefValue = "";
        $this->tel_cli->TooltipValue = "";

        // faturamento
        $this->faturamento->HrefValue = "";
        $this->faturamento->TooltipValue = "";

        // cnpj_fat
        $this->cnpj_fat->HrefValue = "";
        $this->cnpj_fat->TooltipValue = "";

        // end_fat
        $this->end_fat->HrefValue = "";
        $this->end_fat->TooltipValue = "";

        // bairro_fat
        $this->bairro_fat->HrefValue = "";
        $this->bairro_fat->TooltipValue = "";

        // cidae_fat
        $this->cidae_fat->HrefValue = "";
        $this->cidae_fat->TooltipValue = "";

        // uf_fat
        $this->uf_fat->HrefValue = "";
        $this->uf_fat->TooltipValue = "";

        // origem_fat
        $this->origem_fat->HrefValue = "";
        $this->origem_fat->TooltipValue = "";

        // dia_vencto_fat
        $this->dia_vencto_fat->HrefValue = "";
        $this->dia_vencto_fat->TooltipValue = "";

        // quantidade
        $this->quantidade->HrefValue = "";
        $this->quantidade->TooltipValue = "";

        // cargo
        $this->cargo->HrefValue = "";
        $this->cargo->TooltipValue = "";

        // escala
        $this->escala->HrefValue = "";
        $this->escala->TooltipValue = "";

        // periodo
        $this->periodo->HrefValue = "";
        $this->periodo->TooltipValue = "";

        // intrajornada_tipo
        $this->intrajornada_tipo->HrefValue = "";
        $this->intrajornada_tipo->TooltipValue = "";

        // acumulo_funcao
        $this->acumulo_funcao->HrefValue = "";
        $this->acumulo_funcao->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // idproposta
        $this->idproposta->setupEditAttributes();
        $this->idproposta->EditValue = $this->idproposta->CurrentValue;

        // dt_proposta
        $this->dt_proposta->setupEditAttributes();
        $this->dt_proposta->EditValue = FormatDateTime($this->dt_proposta->CurrentValue, $this->dt_proposta->formatPattern());
        $this->dt_proposta->PlaceHolder = RemoveHtml($this->dt_proposta->caption());

        // consultor
        $this->consultor->setupEditAttributes();
        $this->consultor->EditValue = $this->consultor->CurrentValue;
        $this->consultor->PlaceHolder = RemoveHtml($this->consultor->caption());
        if (strval($this->consultor->EditValue) != "" && is_numeric($this->consultor->EditValue)) {
            $this->consultor->EditValue = FormatNumber($this->consultor->EditValue, null);
        }

        // cliente
        $this->cliente->setupEditAttributes();
        if (!$this->cliente->Raw) {
            $this->cliente->CurrentValue = HtmlDecode($this->cliente->CurrentValue);
        }
        $this->cliente->EditValue = $this->cliente->CurrentValue;
        $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());

        // cnpj_cli
        $this->cnpj_cli->setupEditAttributes();
        if (!$this->cnpj_cli->Raw) {
            $this->cnpj_cli->CurrentValue = HtmlDecode($this->cnpj_cli->CurrentValue);
        }
        $this->cnpj_cli->EditValue = $this->cnpj_cli->CurrentValue;
        $this->cnpj_cli->PlaceHolder = RemoveHtml($this->cnpj_cli->caption());

        // end_cli
        $this->end_cli->setupEditAttributes();
        if (!$this->end_cli->Raw) {
            $this->end_cli->CurrentValue = HtmlDecode($this->end_cli->CurrentValue);
        }
        $this->end_cli->EditValue = $this->end_cli->CurrentValue;
        $this->end_cli->PlaceHolder = RemoveHtml($this->end_cli->caption());

        // nr_cli
        $this->nr_cli->setupEditAttributes();
        if (!$this->nr_cli->Raw) {
            $this->nr_cli->CurrentValue = HtmlDecode($this->nr_cli->CurrentValue);
        }
        $this->nr_cli->EditValue = $this->nr_cli->CurrentValue;
        $this->nr_cli->PlaceHolder = RemoveHtml($this->nr_cli->caption());

        // bairro_cli
        $this->bairro_cli->setupEditAttributes();
        if (!$this->bairro_cli->Raw) {
            $this->bairro_cli->CurrentValue = HtmlDecode($this->bairro_cli->CurrentValue);
        }
        $this->bairro_cli->EditValue = $this->bairro_cli->CurrentValue;
        $this->bairro_cli->PlaceHolder = RemoveHtml($this->bairro_cli->caption());

        // cep_cli
        $this->cep_cli->setupEditAttributes();
        if (!$this->cep_cli->Raw) {
            $this->cep_cli->CurrentValue = HtmlDecode($this->cep_cli->CurrentValue);
        }
        $this->cep_cli->EditValue = $this->cep_cli->CurrentValue;
        $this->cep_cli->PlaceHolder = RemoveHtml($this->cep_cli->caption());

        // cidade_cli
        $this->cidade_cli->setupEditAttributes();
        if (!$this->cidade_cli->Raw) {
            $this->cidade_cli->CurrentValue = HtmlDecode($this->cidade_cli->CurrentValue);
        }
        $this->cidade_cli->EditValue = $this->cidade_cli->CurrentValue;
        $this->cidade_cli->PlaceHolder = RemoveHtml($this->cidade_cli->caption());

        // uf_cli
        $this->uf_cli->setupEditAttributes();
        if (!$this->uf_cli->Raw) {
            $this->uf_cli->CurrentValue = HtmlDecode($this->uf_cli->CurrentValue);
        }
        $this->uf_cli->EditValue = $this->uf_cli->CurrentValue;
        $this->uf_cli->PlaceHolder = RemoveHtml($this->uf_cli->caption());

        // contato_cli
        $this->contato_cli->setupEditAttributes();
        if (!$this->contato_cli->Raw) {
            $this->contato_cli->CurrentValue = HtmlDecode($this->contato_cli->CurrentValue);
        }
        $this->contato_cli->EditValue = $this->contato_cli->CurrentValue;
        $this->contato_cli->PlaceHolder = RemoveHtml($this->contato_cli->caption());

        // email_cli
        $this->email_cli->setupEditAttributes();
        if (!$this->email_cli->Raw) {
            $this->email_cli->CurrentValue = HtmlDecode($this->email_cli->CurrentValue);
        }
        $this->email_cli->EditValue = $this->email_cli->CurrentValue;
        $this->email_cli->PlaceHolder = RemoveHtml($this->email_cli->caption());

        // tel_cli
        $this->tel_cli->setupEditAttributes();
        if (!$this->tel_cli->Raw) {
            $this->tel_cli->CurrentValue = HtmlDecode($this->tel_cli->CurrentValue);
        }
        $this->tel_cli->EditValue = $this->tel_cli->CurrentValue;
        $this->tel_cli->PlaceHolder = RemoveHtml($this->tel_cli->caption());

        // faturamento
        $this->faturamento->setupEditAttributes();
        if (!$this->faturamento->Raw) {
            $this->faturamento->CurrentValue = HtmlDecode($this->faturamento->CurrentValue);
        }
        $this->faturamento->EditValue = $this->faturamento->CurrentValue;
        $this->faturamento->PlaceHolder = RemoveHtml($this->faturamento->caption());

        // cnpj_fat
        $this->cnpj_fat->setupEditAttributes();
        if (!$this->cnpj_fat->Raw) {
            $this->cnpj_fat->CurrentValue = HtmlDecode($this->cnpj_fat->CurrentValue);
        }
        $this->cnpj_fat->EditValue = $this->cnpj_fat->CurrentValue;
        $this->cnpj_fat->PlaceHolder = RemoveHtml($this->cnpj_fat->caption());

        // end_fat
        $this->end_fat->setupEditAttributes();
        if (!$this->end_fat->Raw) {
            $this->end_fat->CurrentValue = HtmlDecode($this->end_fat->CurrentValue);
        }
        $this->end_fat->EditValue = $this->end_fat->CurrentValue;
        $this->end_fat->PlaceHolder = RemoveHtml($this->end_fat->caption());

        // bairro_fat
        $this->bairro_fat->setupEditAttributes();
        if (!$this->bairro_fat->Raw) {
            $this->bairro_fat->CurrentValue = HtmlDecode($this->bairro_fat->CurrentValue);
        }
        $this->bairro_fat->EditValue = $this->bairro_fat->CurrentValue;
        $this->bairro_fat->PlaceHolder = RemoveHtml($this->bairro_fat->caption());

        // cidae_fat
        $this->cidae_fat->setupEditAttributes();
        if (!$this->cidae_fat->Raw) {
            $this->cidae_fat->CurrentValue = HtmlDecode($this->cidae_fat->CurrentValue);
        }
        $this->cidae_fat->EditValue = $this->cidae_fat->CurrentValue;
        $this->cidae_fat->PlaceHolder = RemoveHtml($this->cidae_fat->caption());

        // uf_fat
        $this->uf_fat->setupEditAttributes();
        if (!$this->uf_fat->Raw) {
            $this->uf_fat->CurrentValue = HtmlDecode($this->uf_fat->CurrentValue);
        }
        $this->uf_fat->EditValue = $this->uf_fat->CurrentValue;
        $this->uf_fat->PlaceHolder = RemoveHtml($this->uf_fat->caption());

        // origem_fat
        $this->origem_fat->EditValue = $this->origem_fat->options(false);
        $this->origem_fat->PlaceHolder = RemoveHtml($this->origem_fat->caption());

        // dia_vencto_fat
        $this->dia_vencto_fat->setupEditAttributes();
        $this->dia_vencto_fat->EditValue = $this->dia_vencto_fat->CurrentValue;
        $this->dia_vencto_fat->PlaceHolder = RemoveHtml($this->dia_vencto_fat->caption());
        if (strval($this->dia_vencto_fat->EditValue) != "" && is_numeric($this->dia_vencto_fat->EditValue)) {
            $this->dia_vencto_fat->EditValue = FormatNumber($this->dia_vencto_fat->EditValue, null);
        }

        // quantidade
        $this->quantidade->setupEditAttributes();
        $this->quantidade->EditValue = $this->quantidade->CurrentValue;
        $this->quantidade->PlaceHolder = RemoveHtml($this->quantidade->caption());
        if (strval($this->quantidade->EditValue) != "" && is_numeric($this->quantidade->EditValue)) {
            $this->quantidade->EditValue = FormatNumber($this->quantidade->EditValue, null);
        }

        // cargo
        $this->cargo->setupEditAttributes();
        if (!$this->cargo->Raw) {
            $this->cargo->CurrentValue = HtmlDecode($this->cargo->CurrentValue);
        }
        $this->cargo->EditValue = $this->cargo->CurrentValue;
        $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

        // escala
        $this->escala->setupEditAttributes();
        if (!$this->escala->Raw) {
            $this->escala->CurrentValue = HtmlDecode($this->escala->CurrentValue);
        }
        $this->escala->EditValue = $this->escala->CurrentValue;
        $this->escala->PlaceHolder = RemoveHtml($this->escala->caption());

        // periodo
        $this->periodo->setupEditAttributes();
        if (!$this->periodo->Raw) {
            $this->periodo->CurrentValue = HtmlDecode($this->periodo->CurrentValue);
        }
        $this->periodo->EditValue = $this->periodo->CurrentValue;
        $this->periodo->PlaceHolder = RemoveHtml($this->periodo->caption());

        // intrajornada_tipo
        $this->intrajornada_tipo->setupEditAttributes();
        if (!$this->intrajornada_tipo->Raw) {
            $this->intrajornada_tipo->CurrentValue = HtmlDecode($this->intrajornada_tipo->CurrentValue);
        }
        $this->intrajornada_tipo->EditValue = $this->intrajornada_tipo->CurrentValue;
        $this->intrajornada_tipo->PlaceHolder = RemoveHtml($this->intrajornada_tipo->caption());

        // acumulo_funcao
        $this->acumulo_funcao->EditValue = $this->acumulo_funcao->options(false);
        $this->acumulo_funcao->PlaceHolder = RemoveHtml($this->acumulo_funcao->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $result, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$result || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->idproposta);
                    $doc->exportCaption($this->dt_proposta);
                    $doc->exportCaption($this->consultor);
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->cnpj_cli);
                    $doc->exportCaption($this->end_cli);
                    $doc->exportCaption($this->nr_cli);
                    $doc->exportCaption($this->bairro_cli);
                    $doc->exportCaption($this->cep_cli);
                    $doc->exportCaption($this->cidade_cli);
                    $doc->exportCaption($this->uf_cli);
                    $doc->exportCaption($this->contato_cli);
                    $doc->exportCaption($this->email_cli);
                    $doc->exportCaption($this->tel_cli);
                    $doc->exportCaption($this->faturamento);
                    $doc->exportCaption($this->cnpj_fat);
                    $doc->exportCaption($this->end_fat);
                    $doc->exportCaption($this->bairro_fat);
                    $doc->exportCaption($this->cidae_fat);
                    $doc->exportCaption($this->uf_fat);
                    $doc->exportCaption($this->origem_fat);
                    $doc->exportCaption($this->dia_vencto_fat);
                    $doc->exportCaption($this->quantidade);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->escala);
                    $doc->exportCaption($this->periodo);
                    $doc->exportCaption($this->intrajornada_tipo);
                    $doc->exportCaption($this->acumulo_funcao);
                } else {
                    $doc->exportCaption($this->idproposta);
                    $doc->exportCaption($this->dt_proposta);
                    $doc->exportCaption($this->consultor);
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->cnpj_cli);
                    $doc->exportCaption($this->end_cli);
                    $doc->exportCaption($this->nr_cli);
                    $doc->exportCaption($this->bairro_cli);
                    $doc->exportCaption($this->cep_cli);
                    $doc->exportCaption($this->cidade_cli);
                    $doc->exportCaption($this->uf_cli);
                    $doc->exportCaption($this->contato_cli);
                    $doc->exportCaption($this->email_cli);
                    $doc->exportCaption($this->tel_cli);
                    $doc->exportCaption($this->faturamento);
                    $doc->exportCaption($this->cnpj_fat);
                    $doc->exportCaption($this->end_fat);
                    $doc->exportCaption($this->bairro_fat);
                    $doc->exportCaption($this->cidae_fat);
                    $doc->exportCaption($this->uf_fat);
                    $doc->exportCaption($this->origem_fat);
                    $doc->exportCaption($this->dia_vencto_fat);
                    $doc->exportCaption($this->quantidade);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->escala);
                    $doc->exportCaption($this->periodo);
                    $doc->exportCaption($this->intrajornada_tipo);
                    $doc->exportCaption($this->acumulo_funcao);
                }
                $doc->endExportRow();
            }
        }
        $recCnt = $startRec - 1;
        $stopRec = $stopRec > 0 ? $stopRec : PHP_INT_MAX;
        while (($row = $result->fetch()) && $recCnt < $stopRec) {
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = RowType::VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->idproposta);
                        $doc->exportField($this->dt_proposta);
                        $doc->exportField($this->consultor);
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->cnpj_cli);
                        $doc->exportField($this->end_cli);
                        $doc->exportField($this->nr_cli);
                        $doc->exportField($this->bairro_cli);
                        $doc->exportField($this->cep_cli);
                        $doc->exportField($this->cidade_cli);
                        $doc->exportField($this->uf_cli);
                        $doc->exportField($this->contato_cli);
                        $doc->exportField($this->email_cli);
                        $doc->exportField($this->tel_cli);
                        $doc->exportField($this->faturamento);
                        $doc->exportField($this->cnpj_fat);
                        $doc->exportField($this->end_fat);
                        $doc->exportField($this->bairro_fat);
                        $doc->exportField($this->cidae_fat);
                        $doc->exportField($this->uf_fat);
                        $doc->exportField($this->origem_fat);
                        $doc->exportField($this->dia_vencto_fat);
                        $doc->exportField($this->quantidade);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->escala);
                        $doc->exportField($this->periodo);
                        $doc->exportField($this->intrajornada_tipo);
                        $doc->exportField($this->acumulo_funcao);
                    } else {
                        $doc->exportField($this->idproposta);
                        $doc->exportField($this->dt_proposta);
                        $doc->exportField($this->consultor);
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->cnpj_cli);
                        $doc->exportField($this->end_cli);
                        $doc->exportField($this->nr_cli);
                        $doc->exportField($this->bairro_cli);
                        $doc->exportField($this->cep_cli);
                        $doc->exportField($this->cidade_cli);
                        $doc->exportField($this->uf_cli);
                        $doc->exportField($this->contato_cli);
                        $doc->exportField($this->email_cli);
                        $doc->exportField($this->tel_cli);
                        $doc->exportField($this->faturamento);
                        $doc->exportField($this->cnpj_fat);
                        $doc->exportField($this->end_fat);
                        $doc->exportField($this->bairro_fat);
                        $doc->exportField($this->cidae_fat);
                        $doc->exportField($this->uf_fat);
                        $doc->exportField($this->origem_fat);
                        $doc->exportField($this->dia_vencto_fat);
                        $doc->exportField($this->quantidade);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->escala);
                        $doc->exportField($this->periodo);
                        $doc->exportField($this->intrajornada_tipo);
                        $doc->exportField($this->acumulo_funcao);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;

        // No binary fields
        return false;
    }

    // Table level events

    // Table Load event
    public function tableLoad()
    {
        // Enter your code here
    }

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected($rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted($rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, $args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
