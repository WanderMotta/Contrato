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
 * Table class for rel_cross_efetivo_previsto
 */
class RelCrossEfetivoPrevisto extends CrosstabTable
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
    public $cargo;
    public $salario;
    public $escala;
    public $periodo_idperiodo;
    public $jornada;
    public $idcontrato;
    public $cliente;
    public $quantidade;
    public $periodo;
    public $ac_funcao;
    public $intrajornada;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "rel_cross_efetivo_previsto";
        $this->TableName = 'rel_cross_efetivo_previsto';
        $this->TableType = "REPORT";
        $this->TableReportType = "crosstab"; // Report Type
        $this->ReportSourceTable = 'view_efetivo_previsto'; // Report source table
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
        $this->cargo->Nullable = false; // NOT NULL field
        $this->cargo->Required = true; // Required field
        $this->cargo->UseFilter = true; // Table header filter
        $this->cargo->Lookup = new Lookup($this->cargo, 'rel_cross_efetivo_previsto', true, 'cargo', ["cargo","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->cargo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->cargo->SourceTableVar = 'view_efetivo_previsto';
        $this->cargo->SearchType = "dropdown";
        $this->Fields['cargo'] = &$this->cargo;

        // salario
        $this->salario = new ReportField(
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
        $this->salario->SourceTableVar = 'view_efetivo_previsto';
        $this->Fields['salario'] = &$this->salario;

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
        $this->escala->GroupingFieldId = 2;
        $this->escala->Nullable = false; // NOT NULL field
        $this->escala->Required = true; // Required field
        $this->escala->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->escala->SourceTableVar = 'view_efetivo_previsto';
        $this->Fields['escala'] = &$this->escala;

        // periodo_idperiodo
        $this->periodo_idperiodo = new ReportField(
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
        $this->periodo_idperiodo->SourceTableVar = 'view_efetivo_previsto';
        $this->Fields['periodo_idperiodo'] = &$this->periodo_idperiodo;

        // jornada
        $this->jornada = new ReportField(
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
        $this->jornada->GroupingFieldId = 4;
        $this->jornada->Nullable = false; // NOT NULL field
        $this->jornada->Required = true; // Required field
        $this->jornada->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->jornada->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->jornada->SourceTableVar = 'view_efetivo_previsto';
        $this->Fields['jornada'] = &$this->jornada;

        // idcontrato
        $this->idcontrato = new ReportField(
            $this, // Table
            'x_idcontrato', // Variable name
            'idcontrato', // Name
            '`idcontrato`', // Expression
            '`idcontrato`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idcontrato`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idcontrato->InputTextType = "text";
        $this->idcontrato->Raw = true;
        $this->idcontrato->IsAutoIncrement = true; // Autoincrement field
        $this->idcontrato->IsPrimaryKey = true; // Primary key field
        $this->idcontrato->Nullable = false; // NOT NULL field
        $this->idcontrato->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcontrato->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->idcontrato->SourceTableVar = 'view_efetivo_previsto';
        $this->Fields['idcontrato'] = &$this->idcontrato;

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
        $this->cliente->GroupingFieldId = 1;
        $this->cliente->setSelectMultiple(false); // Select one
        $this->cliente->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cliente->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->cliente->Lookup = new Lookup($this->cliente, 'view_efetivo_previsto', true, 'cliente', ["cliente","","",""], '', '', [], [], [], [], [], [], false, '`cliente` ASC', '', "`cliente`");
        $this->cliente->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->cliente->SourceTableVar = 'view_efetivo_previsto';
        $this->cliente->SearchType = "dropdown";
        $this->Fields['cliente'] = &$this->cliente;

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
        $this->quantidade->Nullable = false; // NOT NULL field
        $this->quantidade->Required = true; // Required field
        $this->quantidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->quantidade->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->quantidade->SourceTableVar = 'view_efetivo_previsto';
        $this->Fields['quantidade'] = &$this->quantidade;

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
        $this->periodo->GroupingFieldId = 3;
        $this->periodo->Nullable = false; // NOT NULL field
        $this->periodo->Required = true; // Required field
        $this->periodo->UseFilter = true; // Table header filter
        $this->periodo->Lookup = new Lookup($this->periodo, 'rel_cross_efetivo_previsto', true, 'periodo', ["periodo","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->periodo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->periodo->SourceTableVar = 'view_efetivo_previsto';
        $this->periodo->SearchType = "dropdown";
        $this->Fields['periodo'] = &$this->periodo;

        // ac_funcao
        $this->ac_funcao = new ReportField(
            $this, // Table
            'x_ac_funcao', // Variable name
            'ac_funcao', // Name
            '`ac_funcao`', // Expression
            '`ac_funcao`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ac_funcao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->ac_funcao->addMethod("getDefault", fn() => "Nao");
        $this->ac_funcao->InputTextType = "text";
        $this->ac_funcao->Raw = true;
        $this->ac_funcao->Nullable = false; // NOT NULL field
        $this->ac_funcao->Lookup = new Lookup($this->ac_funcao, 'rel_cross_efetivo_previsto', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->ac_funcao->OptionCount = 2;
        $this->ac_funcao->SearchOperators = ["=", "<>"];
        $this->ac_funcao->SourceTableVar = 'view_efetivo_previsto';
        $this->Fields['ac_funcao'] = &$this->ac_funcao;

        // intrajornada
        $this->intrajornada = new ReportField(
            $this, // Table
            'x_intrajornada', // Variable name
            'intrajornada', // Name
            '`intrajornada`', // Expression
            '`intrajornada`', // Basic search expression
            200, // Type
            35, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`intrajornada`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->intrajornada->InputTextType = "text";
        $this->intrajornada->Nullable = false; // NOT NULL field
        $this->intrajornada->Required = true; // Required field
        $this->intrajornada->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->intrajornada->SourceTableVar = 'view_efetivo_previsto';
        $this->Fields['intrajornada'] = &$this->intrajornada;

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
        $firstGroupField = &$this->cliente;
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

    // Crosstab properties
    private $sqlSelectAggregate = null;
    private $sqlGroupByAggregate = "";

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select();
    }

    public function setSqlSelectAggregate($v)
    {
        $this->sqlSelectAggregate = $v;
    }

    // Group By Aggregate
    public function getSqlGroupByAggregate()
    {
        return ($this->sqlGroupByAggregate != "") ? $this->sqlGroupByAggregate : "";
    }

    public function setSqlGroupByAggregate($v)
    {
        $this->sqlGroupByAggregate = $v;
    }

    // Table level SQL
    private $columnField = "";
    private $columnDateType = "";
    private $columnValues = "";
    private $sqlDistinctSelect = null;
    private $sqlDistinctWhere = "";
    private $sqlDistinctOrderBy = "";
    public $Columns;
    public $ColumnCount;
    public $Col;
    public $DistinctColumnFields = "";
    private $columnLoaded = false;

    // Column field
    public function getColumnField()
    {
        return ($this->columnField != "") ? $this->columnField : "`cargo`";
    }

    public function setColumnField($v)
    {
        $this->columnField = $v;
    }

    // Column date type
    public function getColumnDateType()
    {
        return ($this->columnDateType != "") ? $this->columnDateType : "";
    }

    public function setColumnDateType($v)
    {
        $this->columnDateType = $v;
    }

    // Column values
    public function getColumnValues()
    {
        return ($this->columnValues != "") ? $this->columnValues : "";
    }

    public function setColumnValues($v)
    {
        $this->columnValues = $v;
    }

    // Select Distinct
    public function getSqlDistinctSelect()
    {
        return $this->sqlDistinctSelect ?? $this->getQueryBuilder()->select("`cargo`")->distinct();
    }

    public function setSqlDistinctSelect($v)
    {
        $this->sqlDistinctSelect = $v;
    }

    // Distinct Where
    public function getSqlDistinctWhere()
    {
        $where = ($this->sqlDistinctWhere != "") ? $this->sqlDistinctWhere : "";
        $filter = "";
        AddFilter($where, $filter);
        return $where;
    }

    public function setSqlDistinctWhere($v)
    {
        $this->sqlDistinctWhere = $v;
    }

    // Distinct Order By
    public function getSqlDistinctOrderBy()
    {
        return ($this->sqlDistinctOrderBy != "") ? $this->sqlDistinctOrderBy : "`cargo` ASC";
    }

    public function setSqlDistinctOrderBy($v)
    {
        $this->sqlDistinctOrderBy = $v;
    }

    // Load column values
    public function loadColumnValues($filter = "")
    {
        global $Language;

        // Data already loaded, return
        if ($this->columnLoaded) {
            return;
        }
        $conn = $this->getConnection();

        // Build SQL
        $sql = $this->buildReportSql($this->getSqlDistinctSelect(), $this->getSqlFrom(), $this->getSqlDistinctWhere(), "", "", $this->getSqlDistinctOrderBy(), $filter, "");

        // Load columns
        $rscol = $conn->executeQuery($sql)->fetchAllNumeric();

        // Get distinct column count
        $this->ColumnCount = count($rscol);
/* Uncomment to show phrase
        if ($this->ColumnCount == 0) {
            echo "<p>" . $Language->phrase("NoDistinctColVals") . $sql . "</p>";
            exit();
        }
*/
        $this->Columns = Init2DArray($this->ColumnCount + 1, 5, null);
        $colcnt = 0;
        foreach ($rscol as $row) {
            if ($row[0] === null) {
                $wrkValue = Config("NULL_VALUE");
                $wrkCaption = $Language->phrase("NullLabel");
            } elseif (strval($row[0]) == "") {
                $wrkValue = Config("EMPTY_VALUE");
                $wrkCaption = $Language->phrase("EmptyLabel");
            } else {
                $wrkValue = $row[0];
                $wrkCaption = $row[0];
            }
            $colcnt++;
            $this->Columns[$colcnt] = new CrosstabColumn($wrkCaption, $wrkValue, true);
        }

        // 1st dimension = no of groups (level 0 used for grand total)
        // 2nd dimension = no of distinct values
        $groupCount = 4;
        $this->SummaryFields[0] = new SummaryField('x_quantidade', 'quantidade', '`quantidade`', 'SUM');
        $this->SummaryFields[0]->SummaryCaption = $Language->phrase("RptSum");
        $this->SummaryFields[0]->SummaryValues = InitArray($this->ColumnCount + 1, null);
        $this->SummaryFields[0]->SummaryValueCounts = InitArray($this->ColumnCount + 1, null);
        $this->SummaryFields[0]->SummaryInitValue = 0;

        // Update crosstab SQL
        $sqlFlds = "";
        $cnt = count($this->SummaryFields);
        for ($is = 0; $is < $cnt; $is++) {
            $smry = &$this->SummaryFields[$is];
            for ($i = 1; $i <= $this->ColumnCount; $i++) {
                $fld = CrosstabFieldExpression($smry->SummaryType, $smry->Expression, $this->getColumnField(), $this->getColumnDateType(), $this->Columns[$i]->Value, "'", "C" . $is . $i, $this->Dbid);
                if ($sqlFlds != "") {
                    $sqlFlds .= ", ";
                }
                $sqlFlds .= $fld;
            }
        }
        $this->DistinctColumnFields = $sqlFlds ?: "NULL"; // In case ColumnCount = 0
        $this->columnLoaded = true;
    }

    // Render for lookup
    public function renderLookup()
    {
        $this->cliente->ViewValue = GetDropDownDisplayValue($this->cliente->CurrentValue, "", 0);
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_efetivo_previsto";
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
        return "`cliente`, `escala`, `periodo`, `jornada`";
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
        return $this->SqlGroupBy != "" ? $this->SqlGroupBy : "`cliente`, `escala`, `periodo`, `jornada`";
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
        return "`idcontrato` = @idcontrato@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idcontrato->CurrentValue : $this->idcontrato->OldValue;
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
                $this->idcontrato->CurrentValue = $keys[0];
            } else {
                $this->idcontrato->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idcontrato', $row) ? $row['idcontrato'] : null;
        } else {
            $val = !EmptyValue($this->idcontrato->OldValue) && !$current ? $this->idcontrato->OldValue : $this->idcontrato->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idcontrato@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return "RelCrossEfetivoPrevisto";
    }

    // API page name
    public function getApiPageName($action)
    {
        return "RelCrossEfetivoPrevistoCrosstab";
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
        $json .= "\"idcontrato\":" . VarToJson($this->idcontrato->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idcontrato->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idcontrato->CurrentValue);
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
            if (($keyValue = Param("idcontrato") ?? Route("idcontrato")) !== null) {
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
                $this->idcontrato->CurrentValue = $key;
            } else {
                $this->idcontrato->OldValue = $key;
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
