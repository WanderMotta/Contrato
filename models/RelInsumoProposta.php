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
 * Table class for rel_insumo_proposta
 */
class RelInsumoProposta extends ReportTable
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
    public $idmov_insumo_cliente;
    public $proposta_idproposta;
    public $cliente;
    public $insumo_idinsumo;
    public $tipo_insumo;
    public $insumo;
    public $qtde;
    public $frequencia;
    public $vr_unit;
    public $anual;
    public $mensal;
    public $idtipo_idinsumo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "rel_insumo_proposta";
        $this->TableName = 'rel_insumo_proposta';
        $this->TableType = "REPORT";
        $this->TableReportType = "summary"; // Report Type
        $this->ReportSourceTable = 'view_insumo_proposta_detalhada'; // Report source table
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

        // idmov_insumo_cliente
        $this->idmov_insumo_cliente = new ReportField(
            $this, // Table
            'x_idmov_insumo_cliente', // Variable name
            'idmov_insumo_cliente', // Name
            '`idmov_insumo_cliente`', // Expression
            '`idmov_insumo_cliente`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idmov_insumo_cliente`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idmov_insumo_cliente->InputTextType = "text";
        $this->idmov_insumo_cliente->Raw = true;
        $this->idmov_insumo_cliente->IsAutoIncrement = true; // Autoincrement field
        $this->idmov_insumo_cliente->IsPrimaryKey = true; // Primary key field
        $this->idmov_insumo_cliente->Nullable = false; // NOT NULL field
        $this->idmov_insumo_cliente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idmov_insumo_cliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->idmov_insumo_cliente->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->Fields['idmov_insumo_cliente'] = &$this->idmov_insumo_cliente;

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
            'TEXT' // Edit Tag
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
        $this->proposta_idproposta->Sortable = false; // Allow sort
        $this->proposta_idproposta->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proposta_idproposta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->proposta_idproposta->SourceTableVar = 'view_insumo_proposta_detalhada';
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
            'SELECT' // Edit Tag
        );
        $this->cliente->InputTextType = "text";
        $this->cliente->Sortable = false; // Allow sort
        $this->cliente->setSelectMultiple(false); // Select one
        $this->cliente->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cliente->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->cliente->Lookup = new Lookup($this->cliente, 'view_insumo_proposta_detalhada', true, 'cliente', ["cliente","","",""], '', '', [], [], [], [], [], [], false, '`cliente` ASC', '', "`cliente`");
        $this->cliente->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->cliente->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->cliente->SearchType = "dropdown";
        $this->Fields['cliente'] = &$this->cliente;

        // insumo_idinsumo
        $this->insumo_idinsumo = new ReportField(
            $this, // Table
            'x_insumo_idinsumo', // Variable name
            'insumo_idinsumo', // Name
            '`insumo_idinsumo`', // Expression
            '`insumo_idinsumo`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`insumo_idinsumo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->insumo_idinsumo->InputTextType = "text";
        $this->insumo_idinsumo->Raw = true;
        $this->insumo_idinsumo->Nullable = false; // NOT NULL field
        $this->insumo_idinsumo->Required = true; // Required field
        $this->insumo_idinsumo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->insumo_idinsumo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->insumo_idinsumo->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->Fields['insumo_idinsumo'] = &$this->insumo_idinsumo;

        // tipo_insumo
        $this->tipo_insumo = new ReportField(
            $this, // Table
            'x_tipo_insumo', // Variable name
            'tipo_insumo', // Name
            '`tipo_insumo`', // Expression
            '`tipo_insumo`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_insumo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->tipo_insumo->InputTextType = "text";
        $this->tipo_insumo->Nullable = false; // NOT NULL field
        $this->tipo_insumo->Required = true; // Required field
        $this->tipo_insumo->Lookup = new Lookup($this->tipo_insumo, 'rel_insumo_proposta', true, 'tipo_insumo', ["tipo_insumo","","",""], '', '', [], [], [], [], [], [], false, '`tipo_insumo` ASC', '', "`tipo_insumo`");
        $this->tipo_insumo->SearchOperators = ["=", "<>"];
        $this->tipo_insumo->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->tipo_insumo->SearchType = "dropdown";
        $this->Fields['tipo_insumo'] = &$this->tipo_insumo;

        // insumo
        $this->insumo = new ReportField(
            $this, // Table
            'x_insumo', // Variable name
            'insumo', // Name
            '`insumo`', // Expression
            '`insumo`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`insumo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->insumo->InputTextType = "text";
        $this->insumo->Nullable = false; // NOT NULL field
        $this->insumo->Required = true; // Required field
        $this->insumo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->insumo->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->Fields['insumo'] = &$this->insumo;

        // qtde
        $this->qtde = new ReportField(
            $this, // Table
            'x_qtde', // Variable name
            'qtde', // Name
            '`qtde`', // Expression
            '`qtde`', // Basic search expression
            131, // Type
            7, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`qtde`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->qtde->addMethod("getDefault", fn() => 1.00);
        $this->qtde->InputTextType = "text";
        $this->qtde->Raw = true;
        $this->qtde->Nullable = false; // NOT NULL field
        $this->qtde->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->qtde->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->qtde->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->Fields['qtde'] = &$this->qtde;

        // frequencia
        $this->frequencia = new ReportField(
            $this, // Table
            'x_frequencia', // Variable name
            'frequencia', // Name
            '`frequencia`', // Expression
            '`frequencia`', // Basic search expression
            131, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`frequencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->frequencia->addMethod("getDefault", fn() => 12.0);
        $this->frequencia->InputTextType = "text";
        $this->frequencia->Raw = true;
        $this->frequencia->Nullable = false; // NOT NULL field
        $this->frequencia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->frequencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->frequencia->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->Fields['frequencia'] = &$this->frequencia;

        // vr_unit
        $this->vr_unit = new ReportField(
            $this, // Table
            'x_vr_unit', // Variable name
            'vr_unit', // Name
            '`vr_unit`', // Expression
            '`vr_unit`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`vr_unit`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vr_unit->InputTextType = "text";
        $this->vr_unit->Raw = true;
        $this->vr_unit->Nullable = false; // NOT NULL field
        $this->vr_unit->Required = true; // Required field
        $this->vr_unit->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vr_unit->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->vr_unit->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->Fields['vr_unit'] = &$this->vr_unit;

        // anual
        $this->anual = new ReportField(
            $this, // Table
            'x_anual', // Variable name
            'anual', // Name
            '`anual`', // Expression
            '`anual`', // Basic search expression
            131, // Type
            18, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`anual`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->anual->addMethod("getDefault", fn() => 0.00);
        $this->anual->InputTextType = "text";
        $this->anual->Raw = true;
        $this->anual->Nullable = false; // NOT NULL field
        $this->anual->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->anual->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->anual->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->Fields['anual'] = &$this->anual;

        // mensal
        $this->mensal = new ReportField(
            $this, // Table
            'x_mensal', // Variable name
            'mensal', // Name
            '`mensal`', // Expression
            '`mensal`', // Basic search expression
            131, // Type
            18, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`mensal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->mensal->InputTextType = "text";
        $this->mensal->Raw = true;
        $this->mensal->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->mensal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->mensal->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->Fields['mensal'] = &$this->mensal;

        // idtipo_idinsumo
        $this->idtipo_idinsumo = new ReportField(
            $this, // Table
            'x_idtipo_idinsumo', // Variable name
            'idtipo_idinsumo', // Name
            '`idtipo_idinsumo`', // Expression
            '`idtipo_idinsumo`', // Basic search expression
            19, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idtipo_idinsumo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->idtipo_idinsumo->InputTextType = "text";
        $this->idtipo_idinsumo->Raw = true;
        $this->idtipo_idinsumo->Nullable = false; // NOT NULL field
        $this->idtipo_idinsumo->Required = true; // Required field
        $this->idtipo_idinsumo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idtipo_idinsumo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->idtipo_idinsumo->SourceTableVar = 'view_insumo_proposta_detalhada';
        $this->Fields['idtipo_idinsumo'] = &$this->idtipo_idinsumo;

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
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("SUM(`qtde`) AS sum_qtde, SUM(`anual`) AS sum_anual, SUM(`mensal`) AS sum_mensal");
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
        $this->cliente->ViewValue = GetDropDownDisplayValue($this->cliente->CurrentValue, "", 0);
        $this->tipo_insumo->ViewValue = GetDropDownDisplayValue($this->tipo_insumo->CurrentValue, "", 0);
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_insumo_proposta_detalhada";
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
        return "`idmov_insumo_cliente` = @idmov_insumo_cliente@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idmov_insumo_cliente->CurrentValue : $this->idmov_insumo_cliente->OldValue;
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
                $this->idmov_insumo_cliente->CurrentValue = $keys[0];
            } else {
                $this->idmov_insumo_cliente->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idmov_insumo_cliente', $row) ? $row['idmov_insumo_cliente'] : null;
        } else {
            $val = !EmptyValue($this->idmov_insumo_cliente->OldValue) && !$current ? $this->idmov_insumo_cliente->OldValue : $this->idmov_insumo_cliente->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idmov_insumo_cliente@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return "RelInsumoProposta";
    }

    // API page name
    public function getApiPageName($action)
    {
        return "RelInsumoPropostaSummary";
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
        $json .= "\"idmov_insumo_cliente\":" . VarToJson($this->idmov_insumo_cliente->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idmov_insumo_cliente->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idmov_insumo_cliente->CurrentValue);
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
            if (($keyValue = Param("idmov_insumo_cliente") ?? Route("idmov_insumo_cliente")) !== null) {
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
                $this->idmov_insumo_cliente->CurrentValue = $key;
            } else {
                $this->idmov_insumo_cliente->OldValue = $key;
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
