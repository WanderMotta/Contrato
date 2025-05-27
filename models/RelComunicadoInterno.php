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
 * Table class for rel_comunicado_interno
 */
class RelComunicadoInterno extends ReportTable
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
    public $ShowGroupHeaderAsRow = false;
    public $ShowCompactSummaryFooter = true;

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
        $this->TableVar = "rel_comunicado_interno";
        $this->TableName = 'rel_comunicado_interno';
        $this->TableType = "REPORT";
        $this->TableReportType = "summary"; // Report Type
        $this->ReportSourceTable = 'view_comunicado_interno'; // Report source table
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (report only)

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
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions

        // idproposta
        $this->idproposta = new ReportField(
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
            'SELECT' // Edit Tag
        );
        $this->idproposta->InputTextType = "text";
        $this->idproposta->Raw = true;
        $this->idproposta->IsAutoIncrement = true; // Autoincrement field
        $this->idproposta->IsPrimaryKey = true; // Primary key field
        $this->idproposta->Nullable = false; // NOT NULL field
        $this->idproposta->setSelectMultiple(false); // Select one
        $this->idproposta->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idproposta->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->idproposta->Lookup = new Lookup($this->idproposta, 'view_comunicado_interno', false, 'idproposta', ["idproposta","cliente","",""], '', '', [], [], [], [], [], [], false, '', '', "CONCAT(COALESCE(`idproposta`, ''),'" . ValueSeparator(1, $this->idproposta) . "',COALESCE(`cliente`,''))");
        $this->idproposta->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idproposta->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->idproposta->SourceTableVar = 'view_comunicado_interno';
        $this->idproposta->SearchType = "dropdown";
        $this->Fields['idproposta'] = &$this->idproposta;

        // dt_proposta
        $this->dt_proposta = new ReportField(
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
        $this->dt_proposta->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['dt_proposta'] = &$this->dt_proposta;

        // consultor
        $this->consultor = new ReportField(
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
        $this->consultor->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['consultor'] = &$this->consultor;

        // cliente
        $this->cliente = new ReportField(
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
        $this->cliente->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['cliente'] = &$this->cliente;

        // cnpj_cli
        $this->cnpj_cli = new ReportField(
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
        $this->cnpj_cli->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['cnpj_cli'] = &$this->cnpj_cli;

        // end_cli
        $this->end_cli = new ReportField(
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
        $this->end_cli->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['end_cli'] = &$this->end_cli;

        // nr_cli
        $this->nr_cli = new ReportField(
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
        $this->nr_cli->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['nr_cli'] = &$this->nr_cli;

        // bairro_cli
        $this->bairro_cli = new ReportField(
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
        $this->bairro_cli->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['bairro_cli'] = &$this->bairro_cli;

        // cep_cli
        $this->cep_cli = new ReportField(
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
        $this->cep_cli->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['cep_cli'] = &$this->cep_cli;

        // cidade_cli
        $this->cidade_cli = new ReportField(
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
        $this->cidade_cli->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['cidade_cli'] = &$this->cidade_cli;

        // uf_cli
        $this->uf_cli = new ReportField(
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
        $this->uf_cli->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['uf_cli'] = &$this->uf_cli;

        // contato_cli
        $this->contato_cli = new ReportField(
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
        $this->contato_cli->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['contato_cli'] = &$this->contato_cli;

        // email_cli
        $this->email_cli = new ReportField(
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
        $this->email_cli->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['email_cli'] = &$this->email_cli;

        // tel_cli
        $this->tel_cli = new ReportField(
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
        $this->tel_cli->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['tel_cli'] = &$this->tel_cli;

        // faturamento
        $this->faturamento = new ReportField(
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
        $this->faturamento->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['faturamento'] = &$this->faturamento;

        // cnpj_fat
        $this->cnpj_fat = new ReportField(
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
        $this->cnpj_fat->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['cnpj_fat'] = &$this->cnpj_fat;

        // end_fat
        $this->end_fat = new ReportField(
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
        $this->end_fat->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['end_fat'] = &$this->end_fat;

        // bairro_fat
        $this->bairro_fat = new ReportField(
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
        $this->bairro_fat->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['bairro_fat'] = &$this->bairro_fat;

        // cidae_fat
        $this->cidae_fat = new ReportField(
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
        $this->cidae_fat->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['cidae_fat'] = &$this->cidae_fat;

        // uf_fat
        $this->uf_fat = new ReportField(
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
        $this->uf_fat->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['uf_fat'] = &$this->uf_fat;

        // origem_fat
        $this->origem_fat = new ReportField(
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
        $this->origem_fat->Lookup = new Lookup($this->origem_fat, 'rel_comunicado_interno', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->origem_fat->OptionCount = 2;
        $this->origem_fat->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->origem_fat->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['origem_fat'] = &$this->origem_fat;

        // dia_vencto_fat
        $this->dia_vencto_fat = new ReportField(
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
        $this->dia_vencto_fat->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['dia_vencto_fat'] = &$this->dia_vencto_fat;

        // quantidade
        $this->quantidade = new ReportField(
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
        $this->quantidade->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['quantidade'] = &$this->quantidade;

        // cargo
        $this->cargo = new ReportField(
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
        $this->cargo->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['cargo'] = &$this->cargo;

        // escala
        $this->escala = new ReportField(
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
        $this->escala->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['escala'] = &$this->escala;

        // periodo
        $this->periodo = new ReportField(
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
        $this->periodo->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['periodo'] = &$this->periodo;

        // intrajornada_tipo
        $this->intrajornada_tipo = new ReportField(
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
        $this->intrajornada_tipo->SourceTableVar = 'view_comunicado_interno';
        $this->Fields['intrajornada_tipo'] = &$this->intrajornada_tipo;

        // acumulo_funcao
        $this->acumulo_funcao = new ReportField(
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
        $this->acumulo_funcao->Lookup = new Lookup($this->acumulo_funcao, 'rel_comunicado_interno', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->acumulo_funcao->OptionCount = 2;
        $this->acumulo_funcao->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->acumulo_funcao->SourceTableVar = 'view_comunicado_interno';
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

    // Multiple column sort
    protected function updateSort(&$fld, $ctrl)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($fld->GroupingFieldId == 0) {
                if ($ctrl) {
                    $orderBy = $this->getDetailOrderBy();
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
                    $this->setDetailOrderBy($orderBy); // Save to Session
                } else {
                    $this->setDetailOrderBy($curOrderBy); // Save to Session
                }
            }
        } else {
            if ($fld->GroupingFieldId == 0 && !$ctrl) {
                $fld->setSort("");
            }
        }
    }

    // Get Sort SQL
    protected function sortSql()
    {
        $dtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
        $grps = [];
        foreach ($this->Fields as $fld) {
            if (in_array($fld->getSort(), ["ASC", "DESC"])) {
                $fldsql = $fld->Expression;
                if ($fld->GroupingFieldId > 0) {
                    if ($fld->GroupSql != "") {
                        $grps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->GroupSql) . " " . $fld->getSort();
                    } else {
                        $grps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
                    }
                }
            }
        }
        $sortSql = implode(", ", array_values($grps));
        if ($dtlSortSql != "") {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $dtlSortSql;
        }
        return $sortSql;
    }

    // Summary properties
    private $sqlSelectAggregate = null;
    private $sqlAggregatePrefix = "";
    private $sqlAggregateSuffix = "";
    private $sqlSelectCount = null;

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("*");
    }

    public function setSqlSelectAggregate($v)
    {
        $this->sqlSelectAggregate = $v;
    }

    // Aggregate Prefix
    public function getSqlAggregatePrefix()
    {
        return ($this->sqlAggregatePrefix != "") ? $this->sqlAggregatePrefix : "";
    }

    public function setSqlAggregatePrefix($v)
    {
        $this->sqlAggregatePrefix = $v;
    }

    // Aggregate Suffix
    public function getSqlAggregateSuffix()
    {
        return ($this->sqlAggregateSuffix != "") ? $this->sqlAggregateSuffix : "";
    }

    public function setSqlAggregateSuffix($v)
    {
        $this->sqlAggregateSuffix = $v;
    }

    // Select Count
    public function getSqlSelectCount()
    {
        return $this->sqlSelectCount ?? $this->getQueryBuilder()->select("COUNT(*)");
    }

    public function setSqlSelectCount($v)
    {
        $this->sqlSelectCount = $v;
    }

    // Render for lookup
    public function renderLookup()
    {
        $this->idproposta->ViewValue = GetDropDownDisplayValue($this->idproposta->CurrentValue, "", 0);
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
    public function getSqlSelect()
    {
        if ($this->SqlSelect) {
            return $this->SqlSelect;
        }
        $select = $this->getQueryBuilder()->select($this->sqlSelectFields());
        return $select;
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
        return $_SESSION[$name] ?? GetUrl("");
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
            "" => $Language->phrase("View"),
            "" => $Language->phrase("Edit"),
            "" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "RelComunicadoInterno";
    }

    // API page name
    public function getApiPageName($action)
    {
        return "RelComunicadoInternoSummary";
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
        return "";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("", $parm);
        } else {
            $url = $this->keyUrl("", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "?" . $parm;
        } else {
            $url = "";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("", $parm);
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
            $this->DrillDown ||
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
