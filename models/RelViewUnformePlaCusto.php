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
 * Table class for rel_view_unforme_pla_custo
 */
class RelViewUnformePlaCusto extends ReportTable
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
    public $idplanilha_custo;
    public $proposta_idproposta;
    public $cliente;
    public $dt_proposta;
    public $qtde_cargos;
    public $cargo_idcargo;
    public $cargo;
    public $uniforme;
    public $qtde;
    public $periodo_troca;
    public $vr_unitario;
    public $tipo_uniforme;
    public $vr_anual;
    public $vr_mesal;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "rel_view_unforme_pla_custo";
        $this->TableName = 'rel_view_unforme_pla_custo';
        $this->TableType = "REPORT";
        $this->TableReportType = "summary"; // Report Type
        $this->ReportSourceTable = 'view_uniforme_cargo_pla_custo'; // Report source table
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

        // idplanilha_custo
        $this->idplanilha_custo = new ReportField(
            $this, // Table
            'x_idplanilha_custo', // Variable name
            'idplanilha_custo', // Name
            '`idplanilha_custo`', // Expression
            '`idplanilha_custo`', // Basic search expression
            19, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idplanilha_custo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idplanilha_custo->InputTextType = "text";
        $this->idplanilha_custo->Raw = true;
        $this->idplanilha_custo->GroupingFieldId = 2;
        $this->idplanilha_custo->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
        $this->idplanilha_custo->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
        $this->idplanilha_custo->GroupByType = "";
        $this->idplanilha_custo->GroupInterval = "0";
        $this->idplanilha_custo->GroupSql = "";
        $this->idplanilha_custo->IsAutoIncrement = true; // Autoincrement field
        $this->idplanilha_custo->IsPrimaryKey = true; // Primary key field
        $this->idplanilha_custo->Nullable = false; // NOT NULL field
        $this->idplanilha_custo->UseFilter = true; // Table header filter
        $this->idplanilha_custo->Lookup = new Lookup($this->idplanilha_custo, 'rel_view_unforme_pla_custo', true, 'idplanilha_custo', ["idplanilha_custo","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->idplanilha_custo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idplanilha_custo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->idplanilha_custo->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->idplanilha_custo->SearchType = "dropdown";
        $this->Fields['idplanilha_custo'] = &$this->idplanilha_custo;

        // proposta_idproposta
        $this->proposta_idproposta = new ReportField(
            $this, // Table
            'x_proposta_idproposta', // Variable name
            'proposta_idproposta', // Name
            '`proposta_idproposta`', // Expression
            '`proposta_idproposta`', // Basic search expression
            19, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`proposta_idproposta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->proposta_idproposta->InputTextType = "text";
        $this->proposta_idproposta->Raw = true;
        $this->proposta_idproposta->GroupingFieldId = 1;
        $this->proposta_idproposta->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
        $this->proposta_idproposta->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
        $this->proposta_idproposta->GroupByType = "";
        $this->proposta_idproposta->GroupInterval = "0";
        $this->proposta_idproposta->GroupSql = "";
        $this->proposta_idproposta->Nullable = false; // NOT NULL field
        $this->proposta_idproposta->Required = true; // Required field
        $this->proposta_idproposta->setSelectMultiple(false); // Select one
        $this->proposta_idproposta->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->proposta_idproposta->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->proposta_idproposta->Lookup = new Lookup($this->proposta_idproposta, 'rel_view_unforme_pla_custo', true, 'proposta_idproposta', ["proposta_idproposta","cliente","",""], '', '', [], [], [], [], [], [], false, '`proposta_idproposta` DESC', '', "CONCAT(COALESCE(`proposta_idproposta`, ''),'" . ValueSeparator(1, $this->proposta_idproposta) . "',COALESCE(`cliente`,''))");
        $this->proposta_idproposta->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proposta_idproposta->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->proposta_idproposta->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['proposta_idproposta'] = &$this->proposta_idproposta;

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
        $this->cliente->Lookup = new Lookup($this->cliente, 'rel_view_unforme_pla_custo', true, 'cliente', ["cliente","","",""], '', '', [], [], [], [], [], [], false, '`cliente` ASC', '', "`cliente`");
        $this->cliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->cliente->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['cliente'] = &$this->cliente;

        // dt_proposta
        $this->dt_proposta = new ReportField(
            $this, // Table
            'x_dt_proposta', // Variable name
            'dt_proposta', // Name
            '`dt_proposta`', // Expression
            CastDateFieldForLike("`dt_proposta`", 14, "DB"), // Basic search expression
            133, // Type
            10, // Size
            14, // Date/Time format
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
        $this->dt_proposta->DefaultErrorMessage = str_replace("%s", DateFormat(14), $Language->phrase("IncorrectDate"));
        $this->dt_proposta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->dt_proposta->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['dt_proposta'] = &$this->dt_proposta;

        // qtde_cargos
        $this->qtde_cargos = new ReportField(
            $this, // Table
            'x_qtde_cargos', // Variable name
            'qtde_cargos', // Name
            '`qtde_cargos`', // Expression
            '`qtde_cargos`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`qtde_cargos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->qtde_cargos->addMethod("getDefault", fn() => 1);
        $this->qtde_cargos->InputTextType = "text";
        $this->qtde_cargos->Raw = true;
        $this->qtde_cargos->GroupingFieldId = 3;
        $this->qtde_cargos->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
        $this->qtde_cargos->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
        $this->qtde_cargos->GroupByType = "";
        $this->qtde_cargos->GroupInterval = "0";
        $this->qtde_cargos->GroupSql = "";
        $this->qtde_cargos->Nullable = false; // NOT NULL field
        $this->qtde_cargos->Required = true; // Required field
        $this->qtde_cargos->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->qtde_cargos->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->qtde_cargos->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['qtde_cargos'] = &$this->qtde_cargos;

        // cargo_idcargo
        $this->cargo_idcargo = new ReportField(
            $this, // Table
            'x_cargo_idcargo', // Variable name
            'cargo_idcargo', // Name
            '`cargo_idcargo`', // Expression
            '`cargo_idcargo`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cargo_idcargo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cargo_idcargo->InputTextType = "text";
        $this->cargo_idcargo->Raw = true;
        $this->cargo_idcargo->Nullable = false; // NOT NULL field
        $this->cargo_idcargo->Required = true; // Required field
        $this->cargo_idcargo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cargo_idcargo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->cargo_idcargo->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['cargo_idcargo'] = &$this->cargo_idcargo;

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
        $this->cargo->GroupingFieldId = 4;
        $this->cargo->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
        $this->cargo->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
        $this->cargo->GroupByType = "";
        $this->cargo->GroupInterval = "0";
        $this->cargo->GroupSql = "";
        $this->cargo->Nullable = false; // NOT NULL field
        $this->cargo->Required = true; // Required field
        $this->cargo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->cargo->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['cargo'] = &$this->cargo;

        // uniforme
        $this->uniforme = new ReportField(
            $this, // Table
            'x_uniforme', // Variable name
            'uniforme', // Name
            '`uniforme`', // Expression
            '`uniforme`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`uniforme`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->uniforme->InputTextType = "text";
        $this->uniforme->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->uniforme->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['uniforme'] = &$this->uniforme;

        // qtde
        $this->qtde = new ReportField(
            $this, // Table
            'x_qtde', // Variable name
            'qtde', // Name
            '`qtde`', // Expression
            '`qtde`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`qtde`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->qtde->addMethod("getDefault", fn() => 2);
        $this->qtde->InputTextType = "text";
        $this->qtde->Raw = true;
        $this->qtde->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->qtde->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->qtde->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['qtde'] = &$this->qtde;

        // periodo_troca
        $this->periodo_troca = new ReportField(
            $this, // Table
            'x_periodo_troca', // Variable name
            'periodo_troca', // Name
            '`periodo_troca`', // Expression
            '`periodo_troca`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`periodo_troca`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->periodo_troca->addMethod("getDefault", fn() => 2);
        $this->periodo_troca->InputTextType = "text";
        $this->periodo_troca->Raw = true;
        $this->periodo_troca->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->periodo_troca->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->periodo_troca->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['periodo_troca'] = &$this->periodo_troca;

        // vr_unitario
        $this->vr_unitario = new ReportField(
            $this, // Table
            'x_vr_unitario', // Variable name
            'vr_unitario', // Name
            '`vr_unitario`', // Expression
            '`vr_unitario`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`vr_unitario`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vr_unitario->InputTextType = "text";
        $this->vr_unitario->Raw = true;
        $this->vr_unitario->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vr_unitario->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->vr_unitario->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['vr_unitario'] = &$this->vr_unitario;

        // tipo_uniforme
        $this->tipo_uniforme = new ReportField(
            $this, // Table
            'x_tipo_uniforme', // Variable name
            'tipo_uniforme', // Name
            '`tipo_uniforme`', // Expression
            '`tipo_uniforme`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_uniforme`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tipo_uniforme->InputTextType = "text";
        $this->tipo_uniforme->Nullable = false; // NOT NULL field
        $this->tipo_uniforme->Required = true; // Required field
        $this->tipo_uniforme->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->tipo_uniforme->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['tipo_uniforme'] = &$this->tipo_uniforme;

        // vr_anual
        $this->vr_anual = new ReportField(
            $this, // Table
            'x_vr_anual', // Variable name
            'vr_anual', // Name
            '`vr_anual`', // Expression
            '`vr_anual`', // Basic search expression
            131, // Type
            42, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`vr_anual`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vr_anual->InputTextType = "text";
        $this->vr_anual->Raw = true;
        $this->vr_anual->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vr_anual->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->vr_anual->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['vr_anual'] = &$this->vr_anual;

        // vr_mesal
        $this->vr_mesal = new ReportField(
            $this, // Table
            'x_vr_mesal', // Variable name
            'vr_mesal', // Name
            '`vr_mesal`', // Expression
            '`vr_mesal`', // Basic search expression
            131, // Type
            43, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`vr_mesal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vr_mesal->InputTextType = "text";
        $this->vr_mesal->Raw = true;
        $this->vr_mesal->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vr_mesal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->vr_mesal->SourceTableVar = 'view_uniforme_cargo_pla_custo';
        $this->Fields['vr_mesal'] = &$this->vr_mesal;

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

    // Table Level Group SQL
    private $sqlFirstGroupField = "";
    private $sqlSelectGroup = null;
    private $sqlOrderByGroup = "";

    // First Group Field
    public function getSqlFirstGroupField($alias = false)
    {
        if ($this->sqlFirstGroupField != "") {
            return $this->sqlFirstGroupField;
        }
        $firstGroupField = &$this->proposta_idproposta;
        $expr = $firstGroupField->Expression;
        if ($firstGroupField->GroupSql != "") {
            $expr = str_replace("%s", $firstGroupField->Expression, $firstGroupField->GroupSql);
            if ($alias) {
                $expr .= " AS " . QuotedName($firstGroupField->getGroupName(), $this->Dbid);
            }
        }
        return $expr;
    }

    public function setSqlFirstGroupField($v)
    {
        $this->sqlFirstGroupField = $v;
    }

    // Select Group
    public function getSqlSelectGroup()
    {
        return $this->sqlSelectGroup ?? $this->getQueryBuilder()->select($this->getSqlFirstGroupField(true))->distinct();
    }

    public function setSqlSelectGroup($v)
    {
        $this->sqlSelectGroup = $v;
    }

    // Order By Group
    public function getSqlOrderByGroup()
    {
        if ($this->sqlOrderByGroup != "") {
            return $this->sqlOrderByGroup;
        }
        return $this->getSqlFirstGroupField() . " ASC";
    }

    public function setSqlOrderByGroup($v)
    {
        $this->sqlOrderByGroup = $v;
    }

    // Summary properties
    private $sqlSelectAggregate = null;
    private $sqlAggregatePrefix = "";
    private $sqlAggregateSuffix = "";
    private $sqlSelectCount = null;

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("SUM(`qtde`) AS sum_qtde, SUM(`vr_anual`) AS sum_vr_anual, SUM(`vr_mesal`) AS sum_vr_mesal");
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
        $this->cliente->ViewValue = $this->cliente->CurrentValue;
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_uniforme_cargo_pla_custo";
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
        $groupField = &$this->proposta_idproposta;
        if ($groupField->GroupSql != "") {
            $expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
            $select->addSelect($expr);
        }
        $groupField = &$this->idplanilha_custo;
        if ($groupField->GroupSql != "") {
            $expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
            $select->addSelect($expr);
        }
        $groupField = &$this->qtde_cargos;
        if ($groupField->GroupSql != "") {
            $expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
            $select->addSelect($expr);
        }
        $groupField = &$this->cargo;
        if ($groupField->GroupSql != "") {
            $expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
            $select->addSelect($expr);
        }
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
        return "`idplanilha_custo` = @idplanilha_custo@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idplanilha_custo->CurrentValue : $this->idplanilha_custo->OldValue;
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
                $this->idplanilha_custo->CurrentValue = $keys[0];
            } else {
                $this->idplanilha_custo->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idplanilha_custo', $row) ? $row['idplanilha_custo'] : null;
        } else {
            $val = !EmptyValue($this->idplanilha_custo->OldValue) && !$current ? $this->idplanilha_custo->OldValue : $this->idplanilha_custo->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idplanilha_custo@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return "RelViewUnformePlaCusto";
    }

    // API page name
    public function getApiPageName($action)
    {
        return "RelViewUnformePlaCustoSummary";
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
        $json .= "\"idplanilha_custo\":" . VarToJson($this->idplanilha_custo->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idplanilha_custo->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idplanilha_custo->CurrentValue);
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
            if (($keyValue = Param("idplanilha_custo") ?? Route("idplanilha_custo")) !== null) {
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
                $this->idplanilha_custo->CurrentValue = $key;
            } else {
                $this->idplanilha_custo->OldValue = $key;
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
