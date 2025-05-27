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
 * Table class for view_custo_salario
 */
class ViewCustoSalario extends DbTable
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
    public $idcargo;
    public $cargo;
    public $salario;
    public $nr_horas_mes;
    public $nr_horas_ad_noite;
    public $escala_idescala;
    public $escala;
    public $periodo_idperiodo;
    public $periodo;
    public $jornada;
    public $fator;
    public $nr_dias_mes;
    public $intra_sdf;
    public $intra_df;
    public $ad_noite;
    public $DSR_ad_noite;
    public $he_50;
    public $DSR_he_50;
    public $intra_todos;
    public $intra_SabDomFer;
    public $intra_DomFer;
    public $vt_dia;
    public $vr_dia;
    public $va_mes;
    public $benef_social;
    public $plr_mes;
    public $assis_medica;
    public $assis_odonto;
    public $desc_vt;
    public $abreviado;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "view_custo_salario";
        $this->TableName = 'view_custo_salario';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_custo_salario";
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

        // idcargo
        $this->idcargo = new DbField(
            $this, // Table
            'x_idcargo', // Variable name
            'idcargo', // Name
            '`idcargo`', // Expression
            '`idcargo`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idcargo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idcargo->InputTextType = "text";
        $this->idcargo->Raw = true;
        $this->idcargo->IsAutoIncrement = true; // Autoincrement field
        $this->idcargo->IsPrimaryKey = true; // Primary key field
        $this->idcargo->Nullable = false; // NOT NULL field
        $this->idcargo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcargo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idcargo'] = &$this->idcargo;

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
        $this->cargo->Nullable = false; // NOT NULL field
        $this->cargo->Required = true; // Required field
        $this->cargo->UseFilter = true; // Table header filter
        $this->cargo->Lookup = new Lookup($this->cargo, 'view_custo_salario', true, 'cargo', ["cargo","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->cargo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['cargo'] = &$this->cargo;

        // salario
        $this->salario = new DbField(
            $this, // Table
            'x_salario', // Variable name
            'salario', // Name
            '`salario`', // Expression
            '`salario`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`salario`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->salario->InputTextType = "text";
        $this->salario->Raw = true;
        $this->salario->Nullable = false; // NOT NULL field
        $this->salario->Required = true; // Required field
        $this->salario->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->salario->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['salario'] = &$this->salario;

        // nr_horas_mes
        $this->nr_horas_mes = new DbField(
            $this, // Table
            'x_nr_horas_mes', // Variable name
            'nr_horas_mes', // Name
            '`nr_horas_mes`', // Expression
            '`nr_horas_mes`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nr_horas_mes`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nr_horas_mes->InputTextType = "text";
        $this->nr_horas_mes->Raw = true;
        $this->nr_horas_mes->Nullable = false; // NOT NULL field
        $this->nr_horas_mes->Required = true; // Required field
        $this->nr_horas_mes->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->nr_horas_mes->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['nr_horas_mes'] = &$this->nr_horas_mes;

        // nr_horas_ad_noite
        $this->nr_horas_ad_noite = new DbField(
            $this, // Table
            'x_nr_horas_ad_noite', // Variable name
            'nr_horas_ad_noite', // Name
            '`nr_horas_ad_noite`', // Expression
            '`nr_horas_ad_noite`', // Basic search expression
            131, // Type
            7, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nr_horas_ad_noite`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nr_horas_ad_noite->addMethod("getDefault", fn() => 7.00);
        $this->nr_horas_ad_noite->InputTextType = "text";
        $this->nr_horas_ad_noite->Raw = true;
        $this->nr_horas_ad_noite->Nullable = false; // NOT NULL field
        $this->nr_horas_ad_noite->Required = true; // Required field
        $this->nr_horas_ad_noite->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->nr_horas_ad_noite->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['nr_horas_ad_noite'] = &$this->nr_horas_ad_noite;

        // escala_idescala
        $this->escala_idescala = new DbField(
            $this, // Table
            'x_escala_idescala', // Variable name
            'escala_idescala', // Name
            '`escala_idescala`', // Expression
            '`escala_idescala`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`escala_idescala`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->escala_idescala->InputTextType = "text";
        $this->escala_idescala->Raw = true;
        $this->escala_idescala->Nullable = false; // NOT NULL field
        $this->escala_idescala->Required = true; // Required field
        $this->escala_idescala->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->escala_idescala->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['escala_idescala'] = &$this->escala_idescala;

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
            'RADIO' // Edit Tag
        );
        $this->escala->InputTextType = "text";
        $this->escala->Nullable = false; // NOT NULL field
        $this->escala->Required = true; // Required field
        $this->escala->Lookup = new Lookup($this->escala, 'view_custo_salario', true, 'escala', ["escala","","",""], '', '', [], [], [], [], [], [], false, '`escala` ASC', '', "`escala`");
        $this->escala->SearchOperators = ["=", "<>"];
        $this->Fields['escala'] = &$this->escala;

        // periodo_idperiodo
        $this->periodo_idperiodo = new DbField(
            $this, // Table
            'x_periodo_idperiodo', // Variable name
            'periodo_idperiodo', // Name
            '`periodo_idperiodo`', // Expression
            '`periodo_idperiodo`', // Basic search expression
            19, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`periodo_idperiodo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->periodo_idperiodo->InputTextType = "text";
        $this->periodo_idperiodo->Raw = true;
        $this->periodo_idperiodo->Nullable = false; // NOT NULL field
        $this->periodo_idperiodo->Required = true; // Required field
        $this->periodo_idperiodo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->periodo_idperiodo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['periodo_idperiodo'] = &$this->periodo_idperiodo;

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
            'RADIO' // Edit Tag
        );
        $this->periodo->InputTextType = "text";
        $this->periodo->Nullable = false; // NOT NULL field
        $this->periodo->Required = true; // Required field
        $this->periodo->Lookup = new Lookup($this->periodo, 'view_custo_salario', true, 'periodo', ["periodo","","",""], '', '', [], [], [], [], [], [], false, '`periodo` ASC', '', "`periodo`");
        $this->periodo->SearchOperators = ["=", "<>"];
        $this->Fields['periodo'] = &$this->periodo;

        // jornada
        $this->jornada = new DbField(
            $this, // Table
            'x_jornada', // Variable name
            'jornada', // Name
            '`jornada`', // Expression
            '`jornada`', // Basic search expression
            131, // Type
            7, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`jornada`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->jornada->addMethod("getDefault", fn() => 11.00);
        $this->jornada->InputTextType = "text";
        $this->jornada->Raw = true;
        $this->jornada->Nullable = false; // NOT NULL field
        $this->jornada->Required = true; // Required field
        $this->jornada->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->jornada->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['jornada'] = &$this->jornada;

        // fator
        $this->fator = new DbField(
            $this, // Table
            'x_fator', // Variable name
            'fator', // Name
            '`fator`', // Expression
            '`fator`', // Basic search expression
            131, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`fator`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fator->addMethod("getDefault", fn() => 1.0);
        $this->fator->InputTextType = "text";
        $this->fator->Raw = true;
        $this->fator->Nullable = false; // NOT NULL field
        $this->fator->Required = true; // Required field
        $this->fator->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->fator->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['fator'] = &$this->fator;

        // nr_dias_mes
        $this->nr_dias_mes = new DbField(
            $this, // Table
            'x_nr_dias_mes', // Variable name
            'nr_dias_mes', // Name
            '`nr_dias_mes`', // Expression
            '`nr_dias_mes`', // Basic search expression
            131, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nr_dias_mes`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nr_dias_mes->InputTextType = "text";
        $this->nr_dias_mes->Raw = true;
        $this->nr_dias_mes->Nullable = false; // NOT NULL field
        $this->nr_dias_mes->Required = true; // Required field
        $this->nr_dias_mes->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->nr_dias_mes->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['nr_dias_mes'] = &$this->nr_dias_mes;

        // intra_sdf
        $this->intra_sdf = new DbField(
            $this, // Table
            'x_intra_sdf', // Variable name
            'intra_sdf', // Name
            '`intra_sdf`', // Expression
            '`intra_sdf`', // Basic search expression
            131, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`intra_sdf`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->intra_sdf->addMethod("getDefault", fn() => 0.0);
        $this->intra_sdf->InputTextType = "text";
        $this->intra_sdf->Raw = true;
        $this->intra_sdf->Nullable = false; // NOT NULL field
        $this->intra_sdf->Required = true; // Required field
        $this->intra_sdf->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->intra_sdf->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['intra_sdf'] = &$this->intra_sdf;

        // intra_df
        $this->intra_df = new DbField(
            $this, // Table
            'x_intra_df', // Variable name
            'intra_df', // Name
            '`intra_df`', // Expression
            '`intra_df`', // Basic search expression
            131, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`intra_df`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->intra_df->addMethod("getDefault", fn() => 0.0);
        $this->intra_df->InputTextType = "text";
        $this->intra_df->Raw = true;
        $this->intra_df->Nullable = false; // NOT NULL field
        $this->intra_df->Required = true; // Required field
        $this->intra_df->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->intra_df->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['intra_df'] = &$this->intra_df;

        // ad_noite
        $this->ad_noite = new DbField(
            $this, // Table
            'x_ad_noite', // Variable name
            'ad_noite', // Name
            '`ad_noite`', // Expression
            '`ad_noite`', // Basic search expression
            131, // Type
            21, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ad_noite`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ad_noite->InputTextType = "text";
        $this->ad_noite->Raw = true;
        $this->ad_noite->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->ad_noite->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['ad_noite'] = &$this->ad_noite;

        // DSR_ad_noite
        $this->DSR_ad_noite = new DbField(
            $this, // Table
            'x_DSR_ad_noite', // Variable name
            'DSR_ad_noite', // Name
            '`DSR_ad_noite`', // Expression
            '`DSR_ad_noite`', // Basic search expression
            131, // Type
            22, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`DSR_ad_noite`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->DSR_ad_noite->InputTextType = "number";
        $this->DSR_ad_noite->Raw = true;
        $this->DSR_ad_noite->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DSR_ad_noite->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['DSR_ad_noite'] = &$this->DSR_ad_noite;

        // he_50
        $this->he_50 = new DbField(
            $this, // Table
            'x_he_50', // Variable name
            'he_50', // Name
            '`he_50`', // Expression
            '`he_50`', // Basic search expression
            131, // Type
            27, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`he_50`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->he_50->InputTextType = "text";
        $this->he_50->Raw = true;
        $this->he_50->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->he_50->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['he_50'] = &$this->he_50;

        // DSR_he_50
        $this->DSR_he_50 = new DbField(
            $this, // Table
            'x_DSR_he_50', // Variable name
            'DSR_he_50', // Name
            '`DSR_he_50`', // Expression
            '`DSR_he_50`', // Basic search expression
            131, // Type
            28, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`DSR_he_50`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->DSR_he_50->InputTextType = "text";
        $this->DSR_he_50->Raw = true;
        $this->DSR_he_50->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DSR_he_50->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['DSR_he_50'] = &$this->DSR_he_50;

        // intra_todos
        $this->intra_todos = new DbField(
            $this, // Table
            'x_intra_todos', // Variable name
            'intra_todos', // Name
            '`intra_todos`', // Expression
            '`intra_todos`', // Basic search expression
            131, // Type
            19, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`intra_todos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->intra_todos->InputTextType = "text";
        $this->intra_todos->Raw = true;
        $this->intra_todos->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->intra_todos->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['intra_todos'] = &$this->intra_todos;

        // intra_SabDomFer
        $this->intra_SabDomFer = new DbField(
            $this, // Table
            'x_intra_SabDomFer', // Variable name
            'intra_SabDomFer', // Name
            '`intra_SabDomFer`', // Expression
            '`intra_SabDomFer`', // Basic search expression
            131, // Type
            19, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`intra_SabDomFer`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->intra_SabDomFer->InputTextType = "text";
        $this->intra_SabDomFer->Raw = true;
        $this->intra_SabDomFer->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->intra_SabDomFer->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['intra_SabDomFer'] = &$this->intra_SabDomFer;

        // intra_DomFer
        $this->intra_DomFer = new DbField(
            $this, // Table
            'x_intra_DomFer', // Variable name
            'intra_DomFer', // Name
            '`intra_DomFer`', // Expression
            '`intra_DomFer`', // Basic search expression
            131, // Type
            19, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`intra_DomFer`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->intra_DomFer->InputTextType = "text";
        $this->intra_DomFer->Raw = true;
        $this->intra_DomFer->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->intra_DomFer->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['intra_DomFer'] = &$this->intra_DomFer;

        // vt_dia
        $this->vt_dia = new DbField(
            $this, // Table
            'x_vt_dia', // Variable name
            'vt_dia', // Name
            '`vt_dia`', // Expression
            '`vt_dia`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`vt_dia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vt_dia->addMethod("getDefault", fn() => 0.00);
        $this->vt_dia->InputTextType = "text";
        $this->vt_dia->Raw = true;
        $this->vt_dia->Nullable = false; // NOT NULL field
        $this->vt_dia->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vt_dia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['vt_dia'] = &$this->vt_dia;

        // vr_dia
        $this->vr_dia = new DbField(
            $this, // Table
            'x_vr_dia', // Variable name
            'vr_dia', // Name
            '`vr_dia`', // Expression
            '`vr_dia`', // Basic search expression
            131, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`vr_dia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vr_dia->addMethod("getDefault", fn() => 0.00);
        $this->vr_dia->InputTextType = "text";
        $this->vr_dia->Raw = true;
        $this->vr_dia->Nullable = false; // NOT NULL field
        $this->vr_dia->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vr_dia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['vr_dia'] = &$this->vr_dia;

        // va_mes
        $this->va_mes = new DbField(
            $this, // Table
            'x_va_mes', // Variable name
            'va_mes', // Name
            '`va_mes`', // Expression
            '`va_mes`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`va_mes`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->va_mes->addMethod("getDefault", fn() => 0.00);
        $this->va_mes->InputTextType = "text";
        $this->va_mes->Raw = true;
        $this->va_mes->Nullable = false; // NOT NULL field
        $this->va_mes->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->va_mes->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['va_mes'] = &$this->va_mes;

        // benef_social
        $this->benef_social = new DbField(
            $this, // Table
            'x_benef_social', // Variable name
            'benef_social', // Name
            '`benef_social`', // Expression
            '`benef_social`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`benef_social`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->benef_social->addMethod("getDefault", fn() => 0.00);
        $this->benef_social->InputTextType = "text";
        $this->benef_social->Raw = true;
        $this->benef_social->Nullable = false; // NOT NULL field
        $this->benef_social->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->benef_social->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['benef_social'] = &$this->benef_social;

        // plr_mes
        $this->plr_mes = new DbField(
            $this, // Table
            'x_plr_mes', // Variable name
            'plr_mes', // Name
            '`plr_mes`', // Expression
            '`plr_mes`', // Basic search expression
            131, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`plr_mes`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->plr_mes->InputTextType = "text";
        $this->plr_mes->Raw = true;
        $this->plr_mes->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->plr_mes->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['plr_mes'] = &$this->plr_mes;

        // assis_medica
        $this->assis_medica = new DbField(
            $this, // Table
            'x_assis_medica', // Variable name
            'assis_medica', // Name
            '`assis_medica`', // Expression
            '`assis_medica`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`assis_medica`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->assis_medica->addMethod("getDefault", fn() => 0.00);
        $this->assis_medica->InputTextType = "text";
        $this->assis_medica->Raw = true;
        $this->assis_medica->Nullable = false; // NOT NULL field
        $this->assis_medica->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->assis_medica->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['assis_medica'] = &$this->assis_medica;

        // assis_odonto
        $this->assis_odonto = new DbField(
            $this, // Table
            'x_assis_odonto', // Variable name
            'assis_odonto', // Name
            '`assis_odonto`', // Expression
            '`assis_odonto`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`assis_odonto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->assis_odonto->addMethod("getDefault", fn() => 0.00);
        $this->assis_odonto->InputTextType = "text";
        $this->assis_odonto->Raw = true;
        $this->assis_odonto->Nullable = false; // NOT NULL field
        $this->assis_odonto->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->assis_odonto->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['assis_odonto'] = &$this->assis_odonto;

        // desc_vt
        $this->desc_vt = new DbField(
            $this, // Table
            'x_desc_vt', // Variable name
            'desc_vt', // Name
            '`desc_vt`', // Expression
            '`desc_vt`', // Basic search expression
            131, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`desc_vt`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->desc_vt->addMethod("getDefault", fn() => 0.00);
        $this->desc_vt->InputTextType = "text";
        $this->desc_vt->Raw = true;
        $this->desc_vt->Nullable = false; // NOT NULL field
        $this->desc_vt->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->desc_vt->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['desc_vt'] = &$this->desc_vt;

        // abreviado
        $this->abreviado = new DbField(
            $this, // Table
            'x_abreviado', // Variable name
            'abreviado', // Name
            '`abreviado`', // Expression
            '`abreviado`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`abreviado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->abreviado->InputTextType = "text";
        $this->abreviado->Nullable = false; // NOT NULL field
        $this->abreviado->Required = true; // Required field
        $this->abreviado->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['abreviado'] = &$this->abreviado;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_custo_salario";
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
            $this->idcargo->setDbValue($conn->lastInsertId());
            $rs['idcargo'] = $this->idcargo->DbValue;
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
            if (!isset($rs['idcargo']) && !EmptyValue($this->idcargo->CurrentValue)) {
                $rs['idcargo'] = $this->idcargo->CurrentValue;
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
            if (array_key_exists('idcargo', $rs)) {
                AddFilter($where, QuotedName('idcargo', $this->Dbid) . '=' . QuotedValue($rs['idcargo'], $this->idcargo->DataType, $this->Dbid));
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
        $this->idcargo->DbValue = $row['idcargo'];
        $this->cargo->DbValue = $row['cargo'];
        $this->salario->DbValue = $row['salario'];
        $this->nr_horas_mes->DbValue = $row['nr_horas_mes'];
        $this->nr_horas_ad_noite->DbValue = $row['nr_horas_ad_noite'];
        $this->escala_idescala->DbValue = $row['escala_idescala'];
        $this->escala->DbValue = $row['escala'];
        $this->periodo_idperiodo->DbValue = $row['periodo_idperiodo'];
        $this->periodo->DbValue = $row['periodo'];
        $this->jornada->DbValue = $row['jornada'];
        $this->fator->DbValue = $row['fator'];
        $this->nr_dias_mes->DbValue = $row['nr_dias_mes'];
        $this->intra_sdf->DbValue = $row['intra_sdf'];
        $this->intra_df->DbValue = $row['intra_df'];
        $this->ad_noite->DbValue = $row['ad_noite'];
        $this->DSR_ad_noite->DbValue = $row['DSR_ad_noite'];
        $this->he_50->DbValue = $row['he_50'];
        $this->DSR_he_50->DbValue = $row['DSR_he_50'];
        $this->intra_todos->DbValue = $row['intra_todos'];
        $this->intra_SabDomFer->DbValue = $row['intra_SabDomFer'];
        $this->intra_DomFer->DbValue = $row['intra_DomFer'];
        $this->vt_dia->DbValue = $row['vt_dia'];
        $this->vr_dia->DbValue = $row['vr_dia'];
        $this->va_mes->DbValue = $row['va_mes'];
        $this->benef_social->DbValue = $row['benef_social'];
        $this->plr_mes->DbValue = $row['plr_mes'];
        $this->assis_medica->DbValue = $row['assis_medica'];
        $this->assis_odonto->DbValue = $row['assis_odonto'];
        $this->desc_vt->DbValue = $row['desc_vt'];
        $this->abreviado->DbValue = $row['abreviado'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idcargo` = @idcargo@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idcargo->CurrentValue : $this->idcargo->OldValue;
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
                $this->idcargo->CurrentValue = $keys[0];
            } else {
                $this->idcargo->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idcargo', $row) ? $row['idcargo'] : null;
        } else {
            $val = !EmptyValue($this->idcargo->OldValue) && !$current ? $this->idcargo->OldValue : $this->idcargo->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idcargo@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ViewCustoSalarioList");
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
            "ViewCustoSalarioView" => $Language->phrase("View"),
            "ViewCustoSalarioEdit" => $Language->phrase("Edit"),
            "ViewCustoSalarioAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewCustoSalarioList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewCustoSalarioView",
            Config("API_ADD_ACTION") => "ViewCustoSalarioAdd",
            Config("API_EDIT_ACTION") => "ViewCustoSalarioEdit",
            Config("API_DELETE_ACTION") => "ViewCustoSalarioDelete",
            Config("API_LIST_ACTION") => "ViewCustoSalarioList",
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
        return "ViewCustoSalarioList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewCustoSalarioView", $parm);
        } else {
            $url = $this->keyUrl("ViewCustoSalarioView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewCustoSalarioAdd?" . $parm;
        } else {
            $url = "ViewCustoSalarioAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewCustoSalarioEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewCustoSalarioList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewCustoSalarioAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewCustoSalarioList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewCustoSalarioDelete", $parm);
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
        $json .= "\"idcargo\":" . VarToJson($this->idcargo->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idcargo->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idcargo->CurrentValue);
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
            if (($keyValue = Param("idcargo") ?? Route("idcargo")) !== null) {
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
                $this->idcargo->CurrentValue = $key;
            } else {
                $this->idcargo->OldValue = $key;
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
        $this->idcargo->setDbValue($row['idcargo']);
        $this->cargo->setDbValue($row['cargo']);
        $this->salario->setDbValue($row['salario']);
        $this->nr_horas_mes->setDbValue($row['nr_horas_mes']);
        $this->nr_horas_ad_noite->setDbValue($row['nr_horas_ad_noite']);
        $this->escala_idescala->setDbValue($row['escala_idescala']);
        $this->escala->setDbValue($row['escala']);
        $this->periodo_idperiodo->setDbValue($row['periodo_idperiodo']);
        $this->periodo->setDbValue($row['periodo']);
        $this->jornada->setDbValue($row['jornada']);
        $this->fator->setDbValue($row['fator']);
        $this->nr_dias_mes->setDbValue($row['nr_dias_mes']);
        $this->intra_sdf->setDbValue($row['intra_sdf']);
        $this->intra_df->setDbValue($row['intra_df']);
        $this->ad_noite->setDbValue($row['ad_noite']);
        $this->DSR_ad_noite->setDbValue($row['DSR_ad_noite']);
        $this->he_50->setDbValue($row['he_50']);
        $this->DSR_he_50->setDbValue($row['DSR_he_50']);
        $this->intra_todos->setDbValue($row['intra_todos']);
        $this->intra_SabDomFer->setDbValue($row['intra_SabDomFer']);
        $this->intra_DomFer->setDbValue($row['intra_DomFer']);
        $this->vt_dia->setDbValue($row['vt_dia']);
        $this->vr_dia->setDbValue($row['vr_dia']);
        $this->va_mes->setDbValue($row['va_mes']);
        $this->benef_social->setDbValue($row['benef_social']);
        $this->plr_mes->setDbValue($row['plr_mes']);
        $this->assis_medica->setDbValue($row['assis_medica']);
        $this->assis_odonto->setDbValue($row['assis_odonto']);
        $this->desc_vt->setDbValue($row['desc_vt']);
        $this->abreviado->setDbValue($row['abreviado']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewCustoSalarioList";
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

        // idcargo

        // cargo
        $this->cargo->CellCssStyle = "white-space: nowrap;";

        // salario

        // nr_horas_mes

        // nr_horas_ad_noite

        // escala_idescala

        // escala

        // periodo_idperiodo

        // periodo

        // jornada

        // fator

        // nr_dias_mes

        // intra_sdf

        // intra_df

        // ad_noite

        // DSR_ad_noite

        // he_50

        // DSR_he_50

        // intra_todos

        // intra_SabDomFer

        // intra_DomFer

        // vt_dia

        // vr_dia

        // va_mes

        // benef_social

        // plr_mes

        // assis_medica

        // assis_odonto

        // desc_vt

        // abreviado

        // idcargo
        $this->idcargo->ViewValue = $this->idcargo->CurrentValue;

        // cargo
        $this->cargo->ViewValue = $this->cargo->CurrentValue;
        $this->cargo->CssClass = "fw-bold";

        // salario
        $this->salario->ViewValue = $this->salario->CurrentValue;
        $this->salario->ViewValue = FormatCurrency($this->salario->ViewValue, $this->salario->formatPattern());
        $this->salario->CssClass = "fw-bold";
        $this->salario->CellCssStyle .= "text-align: right;";

        // nr_horas_mes
        $this->nr_horas_mes->ViewValue = $this->nr_horas_mes->CurrentValue;
        $this->nr_horas_mes->ViewValue = FormatNumber($this->nr_horas_mes->ViewValue, $this->nr_horas_mes->formatPattern());

        // nr_horas_ad_noite
        $this->nr_horas_ad_noite->ViewValue = $this->nr_horas_ad_noite->CurrentValue;
        $this->nr_horas_ad_noite->ViewValue = FormatNumber($this->nr_horas_ad_noite->ViewValue, $this->nr_horas_ad_noite->formatPattern());

        // escala_idescala
        $this->escala_idescala->ViewValue = $this->escala_idescala->CurrentValue;
        $this->escala_idescala->ViewValue = FormatNumber($this->escala_idescala->ViewValue, $this->escala_idescala->formatPattern());
        $this->escala_idescala->CssClass = "fw-bold";

        // escala
        $this->escala->ViewValue = $this->escala->CurrentValue;
        $this->escala->CssClass = "fw-bold";
        $this->escala->CellCssStyle .= "text-align: center;";

        // periodo_idperiodo
        $this->periodo_idperiodo->ViewValue = $this->periodo_idperiodo->CurrentValue;
        $this->periodo_idperiodo->ViewValue = FormatNumber($this->periodo_idperiodo->ViewValue, $this->periodo_idperiodo->formatPattern());

        // periodo
        $this->periodo->ViewValue = $this->periodo->CurrentValue;
        $this->periodo->CssClass = "fw-bold";
        $this->periodo->CellCssStyle .= "text-align: center;";

        // jornada
        $this->jornada->ViewValue = $this->jornada->CurrentValue;
        $this->jornada->ViewValue = FormatNumber($this->jornada->ViewValue, $this->jornada->formatPattern());
        $this->jornada->CssClass = "fw-bold";
        $this->jornada->CellCssStyle .= "text-align: center;";

        // fator
        $this->fator->ViewValue = $this->fator->CurrentValue;
        $this->fator->ViewValue = FormatNumber($this->fator->ViewValue, $this->fator->formatPattern());

        // nr_dias_mes
        $this->nr_dias_mes->ViewValue = $this->nr_dias_mes->CurrentValue;
        $this->nr_dias_mes->ViewValue = FormatNumber($this->nr_dias_mes->ViewValue, $this->nr_dias_mes->formatPattern());
        $this->nr_dias_mes->CssClass = "fw-bold";
        $this->nr_dias_mes->CellCssStyle .= "text-align: center;";

        // intra_sdf
        $this->intra_sdf->ViewValue = $this->intra_sdf->CurrentValue;
        $this->intra_sdf->ViewValue = FormatCurrency($this->intra_sdf->ViewValue, $this->intra_sdf->formatPattern());
        $this->intra_sdf->CssClass = "fw-bold";
        $this->intra_sdf->CellCssStyle .= "text-align: right;";

        // intra_df
        $this->intra_df->ViewValue = $this->intra_df->CurrentValue;
        $this->intra_df->ViewValue = FormatCurrency($this->intra_df->ViewValue, $this->intra_df->formatPattern());
        $this->intra_df->CssClass = "fw-bold";
        $this->intra_df->CellCssStyle .= "text-align: right;";

        // ad_noite
        $this->ad_noite->ViewValue = $this->ad_noite->CurrentValue;
        $this->ad_noite->ViewValue = FormatCurrency($this->ad_noite->ViewValue, $this->ad_noite->formatPattern());
        $this->ad_noite->CssClass = "fw-bold";
        $this->ad_noite->CellCssStyle .= "text-align: right;";

        // DSR_ad_noite
        $this->DSR_ad_noite->ViewValue = $this->DSR_ad_noite->CurrentValue;
        $this->DSR_ad_noite->ViewValue = FormatCurrency($this->DSR_ad_noite->ViewValue, $this->DSR_ad_noite->formatPattern());
        $this->DSR_ad_noite->CssClass = "fw-bold";
        $this->DSR_ad_noite->CellCssStyle .= "text-align: right;";

        // he_50
        $this->he_50->ViewValue = $this->he_50->CurrentValue;
        $this->he_50->ViewValue = FormatCurrency($this->he_50->ViewValue, $this->he_50->formatPattern());
        $this->he_50->CssClass = "fw-bold";
        $this->he_50->CellCssStyle .= "text-align: right;";

        // DSR_he_50
        $this->DSR_he_50->ViewValue = $this->DSR_he_50->CurrentValue;
        $this->DSR_he_50->ViewValue = FormatCurrency($this->DSR_he_50->ViewValue, $this->DSR_he_50->formatPattern());
        $this->DSR_he_50->CssClass = "fw-bold";
        $this->DSR_he_50->CellCssStyle .= "text-align: right;";

        // intra_todos
        $this->intra_todos->ViewValue = $this->intra_todos->CurrentValue;
        $this->intra_todos->ViewValue = FormatCurrency($this->intra_todos->ViewValue, $this->intra_todos->formatPattern());
        $this->intra_todos->CssClass = "fw-bold";
        $this->intra_todos->CellCssStyle .= "text-align: right;";

        // intra_SabDomFer
        $this->intra_SabDomFer->ViewValue = $this->intra_SabDomFer->CurrentValue;
        $this->intra_SabDomFer->ViewValue = FormatCurrency($this->intra_SabDomFer->ViewValue, $this->intra_SabDomFer->formatPattern());
        $this->intra_SabDomFer->CssClass = "fw-bold";
        $this->intra_SabDomFer->CellCssStyle .= "text-align: right;";

        // intra_DomFer
        $this->intra_DomFer->ViewValue = $this->intra_DomFer->CurrentValue;
        $this->intra_DomFer->ViewValue = FormatCurrency($this->intra_DomFer->ViewValue, $this->intra_DomFer->formatPattern());
        $this->intra_DomFer->CssClass = "fw-bold";
        $this->intra_DomFer->CellCssStyle .= "text-align: right;";

        // vt_dia
        $this->vt_dia->ViewValue = $this->vt_dia->CurrentValue;
        $this->vt_dia->ViewValue = FormatCurrency($this->vt_dia->ViewValue, $this->vt_dia->formatPattern());
        $this->vt_dia->CssClass = "fw-bold";
        $this->vt_dia->CellCssStyle .= "text-align: right;";

        // vr_dia
        $this->vr_dia->ViewValue = $this->vr_dia->CurrentValue;
        $this->vr_dia->ViewValue = FormatCurrency($this->vr_dia->ViewValue, $this->vr_dia->formatPattern());
        $this->vr_dia->CssClass = "fw-bold";
        $this->vr_dia->CellCssStyle .= "text-align: right;";

        // va_mes
        $this->va_mes->ViewValue = $this->va_mes->CurrentValue;
        $this->va_mes->ViewValue = FormatCurrency($this->va_mes->ViewValue, $this->va_mes->formatPattern());
        $this->va_mes->CssClass = "fw-bold";
        $this->va_mes->CellCssStyle .= "text-align: right;";

        // benef_social
        $this->benef_social->ViewValue = $this->benef_social->CurrentValue;
        $this->benef_social->ViewValue = FormatCurrency($this->benef_social->ViewValue, $this->benef_social->formatPattern());
        $this->benef_social->CssClass = "fw-bold";
        $this->benef_social->CellCssStyle .= "text-align: right;";

        // plr_mes
        $this->plr_mes->ViewValue = $this->plr_mes->CurrentValue;
        $this->plr_mes->ViewValue = FormatCurrency($this->plr_mes->ViewValue, $this->plr_mes->formatPattern());
        $this->plr_mes->CssClass = "fw-bold";
        $this->plr_mes->CellCssStyle .= "text-align: right;";

        // assis_medica
        $this->assis_medica->ViewValue = $this->assis_medica->CurrentValue;
        $this->assis_medica->ViewValue = FormatCurrency($this->assis_medica->ViewValue, $this->assis_medica->formatPattern());
        $this->assis_medica->CssClass = "fw-bold";
        $this->assis_medica->CellCssStyle .= "text-align: right;";

        // assis_odonto
        $this->assis_odonto->ViewValue = $this->assis_odonto->CurrentValue;
        $this->assis_odonto->ViewValue = FormatCurrency($this->assis_odonto->ViewValue, $this->assis_odonto->formatPattern());
        $this->assis_odonto->CssClass = "fw-bold";
        $this->assis_odonto->CellCssStyle .= "text-align: right;";

        // desc_vt
        $this->desc_vt->ViewValue = $this->desc_vt->CurrentValue;
        $this->desc_vt->ViewValue = FormatCurrency($this->desc_vt->ViewValue, $this->desc_vt->formatPattern());
        $this->desc_vt->CssClass = "fw-bold";
        $this->desc_vt->CellCssStyle .= "text-align: right;";

        // abreviado
        $this->abreviado->ViewValue = $this->abreviado->CurrentValue;

        // idcargo
        $this->idcargo->HrefValue = "";
        $this->idcargo->TooltipValue = "";

        // cargo
        $this->cargo->HrefValue = "";
        $this->cargo->TooltipValue = "";

        // salario
        $this->salario->HrefValue = "";
        $this->salario->TooltipValue = "";

        // nr_horas_mes
        $this->nr_horas_mes->HrefValue = "";
        $this->nr_horas_mes->TooltipValue = "";

        // nr_horas_ad_noite
        $this->nr_horas_ad_noite->HrefValue = "";
        $this->nr_horas_ad_noite->TooltipValue = "";

        // escala_idescala
        $this->escala_idescala->HrefValue = "";
        $this->escala_idescala->TooltipValue = "";

        // escala
        $this->escala->HrefValue = "";
        $this->escala->TooltipValue = "";

        // periodo_idperiodo
        $this->periodo_idperiodo->HrefValue = "";
        $this->periodo_idperiodo->TooltipValue = "";

        // periodo
        $this->periodo->HrefValue = "";
        $this->periodo->TooltipValue = "";

        // jornada
        $this->jornada->HrefValue = "";
        $this->jornada->TooltipValue = "";

        // fator
        $this->fator->HrefValue = "";
        $this->fator->TooltipValue = "";

        // nr_dias_mes
        $this->nr_dias_mes->HrefValue = "";
        $this->nr_dias_mes->TooltipValue = "";

        // intra_sdf
        $this->intra_sdf->HrefValue = "";
        $this->intra_sdf->TooltipValue = "";

        // intra_df
        $this->intra_df->HrefValue = "";
        $this->intra_df->TooltipValue = "";

        // ad_noite
        $this->ad_noite->HrefValue = "";
        $this->ad_noite->TooltipValue = "";

        // DSR_ad_noite
        $this->DSR_ad_noite->HrefValue = "";
        $this->DSR_ad_noite->TooltipValue = "";

        // he_50
        $this->he_50->HrefValue = "";
        $this->he_50->TooltipValue = "";

        // DSR_he_50
        $this->DSR_he_50->HrefValue = "";
        $this->DSR_he_50->TooltipValue = "";

        // intra_todos
        $this->intra_todos->HrefValue = "";
        $this->intra_todos->TooltipValue = "";

        // intra_SabDomFer
        $this->intra_SabDomFer->HrefValue = "";
        $this->intra_SabDomFer->TooltipValue = "";

        // intra_DomFer
        $this->intra_DomFer->HrefValue = "";
        $this->intra_DomFer->TooltipValue = "";

        // vt_dia
        $this->vt_dia->HrefValue = "";
        $this->vt_dia->TooltipValue = "";

        // vr_dia
        $this->vr_dia->HrefValue = "";
        $this->vr_dia->TooltipValue = "";

        // va_mes
        $this->va_mes->HrefValue = "";
        $this->va_mes->TooltipValue = "";

        // benef_social
        $this->benef_social->HrefValue = "";
        $this->benef_social->TooltipValue = "";

        // plr_mes
        $this->plr_mes->HrefValue = "";
        $this->plr_mes->TooltipValue = "";

        // assis_medica
        $this->assis_medica->HrefValue = "";
        $this->assis_medica->TooltipValue = "";

        // assis_odonto
        $this->assis_odonto->HrefValue = "";
        $this->assis_odonto->TooltipValue = "";

        // desc_vt
        $this->desc_vt->HrefValue = "";
        $this->desc_vt->TooltipValue = "";

        // abreviado
        $this->abreviado->HrefValue = "";
        $this->abreviado->TooltipValue = "";

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

        // idcargo
        $this->idcargo->setupEditAttributes();
        $this->idcargo->EditValue = $this->idcargo->CurrentValue;

        // cargo
        $this->cargo->setupEditAttributes();
        if (!$this->cargo->Raw) {
            $this->cargo->CurrentValue = HtmlDecode($this->cargo->CurrentValue);
        }
        $this->cargo->EditValue = $this->cargo->CurrentValue;
        $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

        // salario
        $this->salario->setupEditAttributes();
        $this->salario->EditValue = $this->salario->CurrentValue;
        $this->salario->PlaceHolder = RemoveHtml($this->salario->caption());
        if (strval($this->salario->EditValue) != "" && is_numeric($this->salario->EditValue)) {
            $this->salario->EditValue = FormatNumber($this->salario->EditValue, null);
        }

        // nr_horas_mes
        $this->nr_horas_mes->setupEditAttributes();
        $this->nr_horas_mes->EditValue = $this->nr_horas_mes->CurrentValue;
        $this->nr_horas_mes->PlaceHolder = RemoveHtml($this->nr_horas_mes->caption());
        if (strval($this->nr_horas_mes->EditValue) != "" && is_numeric($this->nr_horas_mes->EditValue)) {
            $this->nr_horas_mes->EditValue = FormatNumber($this->nr_horas_mes->EditValue, null);
        }

        // nr_horas_ad_noite
        $this->nr_horas_ad_noite->setupEditAttributes();
        $this->nr_horas_ad_noite->EditValue = $this->nr_horas_ad_noite->CurrentValue;
        $this->nr_horas_ad_noite->PlaceHolder = RemoveHtml($this->nr_horas_ad_noite->caption());
        if (strval($this->nr_horas_ad_noite->EditValue) != "" && is_numeric($this->nr_horas_ad_noite->EditValue)) {
            $this->nr_horas_ad_noite->EditValue = FormatNumber($this->nr_horas_ad_noite->EditValue, null);
        }

        // escala_idescala
        $this->escala_idescala->setupEditAttributes();
        $this->escala_idescala->EditValue = $this->escala_idescala->CurrentValue;
        $this->escala_idescala->PlaceHolder = RemoveHtml($this->escala_idescala->caption());
        if (strval($this->escala_idescala->EditValue) != "" && is_numeric($this->escala_idescala->EditValue)) {
            $this->escala_idescala->EditValue = FormatNumber($this->escala_idescala->EditValue, null);
        }

        // escala
        $this->escala->PlaceHolder = RemoveHtml($this->escala->caption());

        // periodo_idperiodo
        $this->periodo_idperiodo->setupEditAttributes();
        $this->periodo_idperiodo->EditValue = $this->periodo_idperiodo->CurrentValue;
        $this->periodo_idperiodo->PlaceHolder = RemoveHtml($this->periodo_idperiodo->caption());
        if (strval($this->periodo_idperiodo->EditValue) != "" && is_numeric($this->periodo_idperiodo->EditValue)) {
            $this->periodo_idperiodo->EditValue = FormatNumber($this->periodo_idperiodo->EditValue, null);
        }

        // periodo
        $this->periodo->PlaceHolder = RemoveHtml($this->periodo->caption());

        // jornada
        $this->jornada->setupEditAttributes();
        $this->jornada->EditValue = $this->jornada->CurrentValue;
        $this->jornada->PlaceHolder = RemoveHtml($this->jornada->caption());
        if (strval($this->jornada->EditValue) != "" && is_numeric($this->jornada->EditValue)) {
            $this->jornada->EditValue = FormatNumber($this->jornada->EditValue, null);
        }

        // fator
        $this->fator->setupEditAttributes();
        $this->fator->EditValue = $this->fator->CurrentValue;
        $this->fator->PlaceHolder = RemoveHtml($this->fator->caption());
        if (strval($this->fator->EditValue) != "" && is_numeric($this->fator->EditValue)) {
            $this->fator->EditValue = FormatNumber($this->fator->EditValue, null);
        }

        // nr_dias_mes
        $this->nr_dias_mes->setupEditAttributes();
        $this->nr_dias_mes->EditValue = $this->nr_dias_mes->CurrentValue;
        $this->nr_dias_mes->PlaceHolder = RemoveHtml($this->nr_dias_mes->caption());
        if (strval($this->nr_dias_mes->EditValue) != "" && is_numeric($this->nr_dias_mes->EditValue)) {
            $this->nr_dias_mes->EditValue = FormatNumber($this->nr_dias_mes->EditValue, null);
        }

        // intra_sdf
        $this->intra_sdf->setupEditAttributes();
        $this->intra_sdf->EditValue = $this->intra_sdf->CurrentValue;
        $this->intra_sdf->PlaceHolder = RemoveHtml($this->intra_sdf->caption());
        if (strval($this->intra_sdf->EditValue) != "" && is_numeric($this->intra_sdf->EditValue)) {
            $this->intra_sdf->EditValue = FormatNumber($this->intra_sdf->EditValue, null);
        }

        // intra_df
        $this->intra_df->setupEditAttributes();
        $this->intra_df->EditValue = $this->intra_df->CurrentValue;
        $this->intra_df->PlaceHolder = RemoveHtml($this->intra_df->caption());
        if (strval($this->intra_df->EditValue) != "" && is_numeric($this->intra_df->EditValue)) {
            $this->intra_df->EditValue = FormatNumber($this->intra_df->EditValue, null);
        }

        // ad_noite
        $this->ad_noite->setupEditAttributes();
        $this->ad_noite->EditValue = $this->ad_noite->CurrentValue;
        $this->ad_noite->PlaceHolder = RemoveHtml($this->ad_noite->caption());
        if (strval($this->ad_noite->EditValue) != "" && is_numeric($this->ad_noite->EditValue)) {
            $this->ad_noite->EditValue = FormatNumber($this->ad_noite->EditValue, null);
        }

        // DSR_ad_noite
        $this->DSR_ad_noite->setupEditAttributes();
        $this->DSR_ad_noite->EditValue = $this->DSR_ad_noite->CurrentValue;
        $this->DSR_ad_noite->PlaceHolder = RemoveHtml($this->DSR_ad_noite->caption());
        if (strval($this->DSR_ad_noite->EditValue) != "" && is_numeric($this->DSR_ad_noite->EditValue)) {
            $this->DSR_ad_noite->EditValue = FormatNumber($this->DSR_ad_noite->EditValue, null);
        }

        // he_50
        $this->he_50->setupEditAttributes();
        $this->he_50->EditValue = $this->he_50->CurrentValue;
        $this->he_50->PlaceHolder = RemoveHtml($this->he_50->caption());
        if (strval($this->he_50->EditValue) != "" && is_numeric($this->he_50->EditValue)) {
            $this->he_50->EditValue = FormatNumber($this->he_50->EditValue, null);
        }

        // DSR_he_50
        $this->DSR_he_50->setupEditAttributes();
        $this->DSR_he_50->EditValue = $this->DSR_he_50->CurrentValue;
        $this->DSR_he_50->PlaceHolder = RemoveHtml($this->DSR_he_50->caption());
        if (strval($this->DSR_he_50->EditValue) != "" && is_numeric($this->DSR_he_50->EditValue)) {
            $this->DSR_he_50->EditValue = FormatNumber($this->DSR_he_50->EditValue, null);
        }

        // intra_todos
        $this->intra_todos->setupEditAttributes();
        $this->intra_todos->EditValue = $this->intra_todos->CurrentValue;
        $this->intra_todos->PlaceHolder = RemoveHtml($this->intra_todos->caption());
        if (strval($this->intra_todos->EditValue) != "" && is_numeric($this->intra_todos->EditValue)) {
            $this->intra_todos->EditValue = FormatNumber($this->intra_todos->EditValue, null);
        }

        // intra_SabDomFer
        $this->intra_SabDomFer->setupEditAttributes();
        $this->intra_SabDomFer->EditValue = $this->intra_SabDomFer->CurrentValue;
        $this->intra_SabDomFer->PlaceHolder = RemoveHtml($this->intra_SabDomFer->caption());
        if (strval($this->intra_SabDomFer->EditValue) != "" && is_numeric($this->intra_SabDomFer->EditValue)) {
            $this->intra_SabDomFer->EditValue = FormatNumber($this->intra_SabDomFer->EditValue, null);
        }

        // intra_DomFer
        $this->intra_DomFer->setupEditAttributes();
        $this->intra_DomFer->EditValue = $this->intra_DomFer->CurrentValue;
        $this->intra_DomFer->PlaceHolder = RemoveHtml($this->intra_DomFer->caption());
        if (strval($this->intra_DomFer->EditValue) != "" && is_numeric($this->intra_DomFer->EditValue)) {
            $this->intra_DomFer->EditValue = FormatNumber($this->intra_DomFer->EditValue, null);
        }

        // vt_dia
        $this->vt_dia->setupEditAttributes();
        $this->vt_dia->EditValue = $this->vt_dia->CurrentValue;
        $this->vt_dia->PlaceHolder = RemoveHtml($this->vt_dia->caption());
        if (strval($this->vt_dia->EditValue) != "" && is_numeric($this->vt_dia->EditValue)) {
            $this->vt_dia->EditValue = FormatNumber($this->vt_dia->EditValue, null);
        }

        // vr_dia
        $this->vr_dia->setupEditAttributes();
        $this->vr_dia->EditValue = $this->vr_dia->CurrentValue;
        $this->vr_dia->PlaceHolder = RemoveHtml($this->vr_dia->caption());
        if (strval($this->vr_dia->EditValue) != "" && is_numeric($this->vr_dia->EditValue)) {
            $this->vr_dia->EditValue = FormatNumber($this->vr_dia->EditValue, null);
        }

        // va_mes
        $this->va_mes->setupEditAttributes();
        $this->va_mes->EditValue = $this->va_mes->CurrentValue;
        $this->va_mes->PlaceHolder = RemoveHtml($this->va_mes->caption());
        if (strval($this->va_mes->EditValue) != "" && is_numeric($this->va_mes->EditValue)) {
            $this->va_mes->EditValue = FormatNumber($this->va_mes->EditValue, null);
        }

        // benef_social
        $this->benef_social->setupEditAttributes();
        $this->benef_social->EditValue = $this->benef_social->CurrentValue;
        $this->benef_social->PlaceHolder = RemoveHtml($this->benef_social->caption());
        if (strval($this->benef_social->EditValue) != "" && is_numeric($this->benef_social->EditValue)) {
            $this->benef_social->EditValue = FormatNumber($this->benef_social->EditValue, null);
        }

        // plr_mes
        $this->plr_mes->setupEditAttributes();
        $this->plr_mes->EditValue = $this->plr_mes->CurrentValue;
        $this->plr_mes->PlaceHolder = RemoveHtml($this->plr_mes->caption());
        if (strval($this->plr_mes->EditValue) != "" && is_numeric($this->plr_mes->EditValue)) {
            $this->plr_mes->EditValue = FormatNumber($this->plr_mes->EditValue, null);
        }

        // assis_medica
        $this->assis_medica->setupEditAttributes();
        $this->assis_medica->EditValue = $this->assis_medica->CurrentValue;
        $this->assis_medica->PlaceHolder = RemoveHtml($this->assis_medica->caption());
        if (strval($this->assis_medica->EditValue) != "" && is_numeric($this->assis_medica->EditValue)) {
            $this->assis_medica->EditValue = FormatNumber($this->assis_medica->EditValue, null);
        }

        // assis_odonto
        $this->assis_odonto->setupEditAttributes();
        $this->assis_odonto->EditValue = $this->assis_odonto->CurrentValue;
        $this->assis_odonto->PlaceHolder = RemoveHtml($this->assis_odonto->caption());
        if (strval($this->assis_odonto->EditValue) != "" && is_numeric($this->assis_odonto->EditValue)) {
            $this->assis_odonto->EditValue = FormatNumber($this->assis_odonto->EditValue, null);
        }

        // desc_vt
        $this->desc_vt->setupEditAttributes();
        $this->desc_vt->EditValue = $this->desc_vt->CurrentValue;
        $this->desc_vt->PlaceHolder = RemoveHtml($this->desc_vt->caption());
        if (strval($this->desc_vt->EditValue) != "" && is_numeric($this->desc_vt->EditValue)) {
            $this->desc_vt->EditValue = FormatNumber($this->desc_vt->EditValue, null);
        }

        // abreviado
        $this->abreviado->setupEditAttributes();
        if (!$this->abreviado->Raw) {
            $this->abreviado->CurrentValue = HtmlDecode($this->abreviado->CurrentValue);
        }
        $this->abreviado->EditValue = $this->abreviado->CurrentValue;
        $this->abreviado->PlaceHolder = RemoveHtml($this->abreviado->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            $this->cargo->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->cargo->CurrentValue = $this->cargo->Count;
            $this->cargo->ViewValue = $this->cargo->CurrentValue;
            $this->cargo->CssClass = "fw-bold";
            $this->cargo->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->idcargo);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->salario);
                    $doc->exportCaption($this->nr_horas_mes);
                    $doc->exportCaption($this->nr_horas_ad_noite);
                    $doc->exportCaption($this->escala_idescala);
                    $doc->exportCaption($this->escala);
                    $doc->exportCaption($this->periodo_idperiodo);
                    $doc->exportCaption($this->periodo);
                    $doc->exportCaption($this->jornada);
                    $doc->exportCaption($this->fator);
                    $doc->exportCaption($this->nr_dias_mes);
                    $doc->exportCaption($this->intra_sdf);
                    $doc->exportCaption($this->intra_df);
                    $doc->exportCaption($this->ad_noite);
                    $doc->exportCaption($this->DSR_ad_noite);
                    $doc->exportCaption($this->he_50);
                    $doc->exportCaption($this->DSR_he_50);
                    $doc->exportCaption($this->intra_todos);
                    $doc->exportCaption($this->intra_SabDomFer);
                    $doc->exportCaption($this->intra_DomFer);
                    $doc->exportCaption($this->vt_dia);
                    $doc->exportCaption($this->vr_dia);
                    $doc->exportCaption($this->va_mes);
                    $doc->exportCaption($this->benef_social);
                    $doc->exportCaption($this->plr_mes);
                    $doc->exportCaption($this->assis_medica);
                    $doc->exportCaption($this->assis_odonto);
                    $doc->exportCaption($this->desc_vt);
                    $doc->exportCaption($this->abreviado);
                } else {
                    $doc->exportCaption($this->idcargo);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->salario);
                    $doc->exportCaption($this->nr_horas_mes);
                    $doc->exportCaption($this->nr_horas_ad_noite);
                    $doc->exportCaption($this->escala_idescala);
                    $doc->exportCaption($this->escala);
                    $doc->exportCaption($this->periodo_idperiodo);
                    $doc->exportCaption($this->periodo);
                    $doc->exportCaption($this->jornada);
                    $doc->exportCaption($this->fator);
                    $doc->exportCaption($this->nr_dias_mes);
                    $doc->exportCaption($this->intra_sdf);
                    $doc->exportCaption($this->intra_df);
                    $doc->exportCaption($this->ad_noite);
                    $doc->exportCaption($this->DSR_ad_noite);
                    $doc->exportCaption($this->he_50);
                    $doc->exportCaption($this->DSR_he_50);
                    $doc->exportCaption($this->intra_todos);
                    $doc->exportCaption($this->intra_SabDomFer);
                    $doc->exportCaption($this->intra_DomFer);
                    $doc->exportCaption($this->vt_dia);
                    $doc->exportCaption($this->vr_dia);
                    $doc->exportCaption($this->va_mes);
                    $doc->exportCaption($this->benef_social);
                    $doc->exportCaption($this->plr_mes);
                    $doc->exportCaption($this->assis_medica);
                    $doc->exportCaption($this->assis_odonto);
                    $doc->exportCaption($this->desc_vt);
                    $doc->exportCaption($this->abreviado);
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
                $this->aggregateListRowValues(); // Aggregate row values

                // Render row
                $this->RowType = RowType::VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->idcargo);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->salario);
                        $doc->exportField($this->nr_horas_mes);
                        $doc->exportField($this->nr_horas_ad_noite);
                        $doc->exportField($this->escala_idescala);
                        $doc->exportField($this->escala);
                        $doc->exportField($this->periodo_idperiodo);
                        $doc->exportField($this->periodo);
                        $doc->exportField($this->jornada);
                        $doc->exportField($this->fator);
                        $doc->exportField($this->nr_dias_mes);
                        $doc->exportField($this->intra_sdf);
                        $doc->exportField($this->intra_df);
                        $doc->exportField($this->ad_noite);
                        $doc->exportField($this->DSR_ad_noite);
                        $doc->exportField($this->he_50);
                        $doc->exportField($this->DSR_he_50);
                        $doc->exportField($this->intra_todos);
                        $doc->exportField($this->intra_SabDomFer);
                        $doc->exportField($this->intra_DomFer);
                        $doc->exportField($this->vt_dia);
                        $doc->exportField($this->vr_dia);
                        $doc->exportField($this->va_mes);
                        $doc->exportField($this->benef_social);
                        $doc->exportField($this->plr_mes);
                        $doc->exportField($this->assis_medica);
                        $doc->exportField($this->assis_odonto);
                        $doc->exportField($this->desc_vt);
                        $doc->exportField($this->abreviado);
                    } else {
                        $doc->exportField($this->idcargo);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->salario);
                        $doc->exportField($this->nr_horas_mes);
                        $doc->exportField($this->nr_horas_ad_noite);
                        $doc->exportField($this->escala_idescala);
                        $doc->exportField($this->escala);
                        $doc->exportField($this->periodo_idperiodo);
                        $doc->exportField($this->periodo);
                        $doc->exportField($this->jornada);
                        $doc->exportField($this->fator);
                        $doc->exportField($this->nr_dias_mes);
                        $doc->exportField($this->intra_sdf);
                        $doc->exportField($this->intra_df);
                        $doc->exportField($this->ad_noite);
                        $doc->exportField($this->DSR_ad_noite);
                        $doc->exportField($this->he_50);
                        $doc->exportField($this->DSR_he_50);
                        $doc->exportField($this->intra_todos);
                        $doc->exportField($this->intra_SabDomFer);
                        $doc->exportField($this->intra_DomFer);
                        $doc->exportField($this->vt_dia);
                        $doc->exportField($this->vr_dia);
                        $doc->exportField($this->va_mes);
                        $doc->exportField($this->benef_social);
                        $doc->exportField($this->plr_mes);
                        $doc->exportField($this->assis_medica);
                        $doc->exportField($this->assis_odonto);
                        $doc->exportField($this->desc_vt);
                        $doc->exportField($this->abreviado);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
        }

        // Export aggregates (horizontal format only)
        if ($doc->Horizontal) {
            $this->RowType = RowType::AGGREGATE;
            $this->resetAttributes();
            $this->aggregateListRow();
            if (!$doc->ExportCustom) {
                $doc->beginExportRow(-1);
                $doc->exportAggregate($this->idcargo, '');
                $doc->exportAggregate($this->cargo, 'COUNT');
                $doc->exportAggregate($this->salario, '');
                $doc->exportAggregate($this->nr_horas_mes, '');
                $doc->exportAggregate($this->nr_horas_ad_noite, '');
                $doc->exportAggregate($this->escala_idescala, '');
                $doc->exportAggregate($this->escala, '');
                $doc->exportAggregate($this->periodo_idperiodo, '');
                $doc->exportAggregate($this->periodo, '');
                $doc->exportAggregate($this->jornada, '');
                $doc->exportAggregate($this->fator, '');
                $doc->exportAggregate($this->nr_dias_mes, '');
                $doc->exportAggregate($this->intra_sdf, '');
                $doc->exportAggregate($this->intra_df, '');
                $doc->exportAggregate($this->ad_noite, '');
                $doc->exportAggregate($this->DSR_ad_noite, '');
                $doc->exportAggregate($this->he_50, '');
                $doc->exportAggregate($this->DSR_he_50, '');
                $doc->exportAggregate($this->intra_todos, '');
                $doc->exportAggregate($this->intra_SabDomFer, '');
                $doc->exportAggregate($this->intra_DomFer, '');
                $doc->exportAggregate($this->vt_dia, '');
                $doc->exportAggregate($this->vr_dia, '');
                $doc->exportAggregate($this->va_mes, '');
                $doc->exportAggregate($this->benef_social, '');
                $doc->exportAggregate($this->plr_mes, '');
                $doc->exportAggregate($this->assis_medica, '');
                $doc->exportAggregate($this->assis_odonto, '');
                $doc->exportAggregate($this->desc_vt, '');
                $doc->exportAggregate($this->abreviado, '');
                $doc->endExportRow();
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
