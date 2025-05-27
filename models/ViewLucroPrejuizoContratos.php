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
 * Table class for view_lucro_prejuizo_contratos
 */
class ViewLucroPrejuizoContratos extends DbTable
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
    public $LucroxPrejuizo;

    // Fields
    public $cliente;
    public $VrCobradoR;
    public $CustoCalculadoR;
    public $Diferenca;
    public $Margem;
    public $Resultado;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "view_lucro_prejuizo_contratos";
        $this->TableName = 'view_lucro_prejuizo_contratos';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_lucro_prejuizo_contratos";
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
        $this->cliente->UseFilter = true; // Table header filter
        $this->cliente->Lookup = new Lookup($this->cliente, 'view_lucro_prejuizo_contratos', true, 'cliente', ["cliente","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->cliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cliente'] = &$this->cliente;

        // Vr Cobrado R$
        $this->VrCobradoR = new DbField(
            $this, // Table
            'x_VrCobradoR', // Variable name
            'Vr Cobrado R$', // Name
            '`Vr Cobrado R$`', // Expression
            '`Vr Cobrado R$`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Vr Cobrado R$`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->VrCobradoR->addMethod("getDefault", fn() => 0.00);
        $this->VrCobradoR->InputTextType = "text";
        $this->VrCobradoR->Raw = true;
        $this->VrCobradoR->Nullable = false; // NOT NULL field
        $this->VrCobradoR->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->VrCobradoR->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Vr Cobrado R$'] = &$this->VrCobradoR;

        // Custo Calculado R$
        $this->CustoCalculadoR = new DbField(
            $this, // Table
            'x_CustoCalculadoR', // Variable name
            'Custo Calculado R$', // Name
            '`Custo Calculado R$`', // Expression
            '`Custo Calculado R$`', // Basic search expression
            131, // Type
            34, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Custo Calculado R$`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->CustoCalculadoR->InputTextType = "text";
        $this->CustoCalculadoR->Raw = true;
        $this->CustoCalculadoR->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->CustoCalculadoR->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Custo Calculado R$'] = &$this->CustoCalculadoR;

        // Diferença
        $this->Diferenca = new DbField(
            $this, // Table
            'x_Diferenca', // Variable name
            'Diferença', // Name
            '`Diferença`', // Expression
            '`Diferença`', // Basic search expression
            131, // Type
            35, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Diferença`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Diferenca->InputTextType = "text";
        $this->Diferenca->Raw = true;
        $this->Diferenca->UseFilter = true; // Table header filter
        $this->Diferenca->Lookup = new Lookup($this->Diferenca, 'view_lucro_prejuizo_contratos', true, 'Diferença', ["Diferença","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->Diferenca->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Diferenca->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Diferença'] = &$this->Diferenca;

        // Margem
        $this->Margem = new DbField(
            $this, // Table
            'x_Margem', // Variable name
            'Margem', // Name
            '`Margem`', // Expression
            '`Margem`', // Basic search expression
            131, // Type
            41, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Margem`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Margem->InputTextType = "text";
        $this->Margem->Raw = true;
        $this->Margem->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Margem->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Margem'] = &$this->Margem;

        // Resultado
        $this->Resultado = new DbField(
            $this, // Table
            'x_Resultado', // Variable name
            'Resultado', // Name
            '`Resultado`', // Expression
            '`Resultado`', // Basic search expression
            200, // Type
            8, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Resultado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Resultado->InputTextType = "text";
        $this->Resultado->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Resultado'] = &$this->Resultado;

        // Lucro x Prejuizo
        $this->LucroxPrejuizo = new DbChart($this, 'LucroxPrejuizo', 'Lucro x Prejuizo', 'cliente', 'Diferença', 1001, '', 0, 'SUM', 600, 500);
        $this->LucroxPrejuizo->Position = 4;
        $this->LucroxPrejuizo->PageBreakType = "before";
        $this->LucroxPrejuizo->YAxisFormat = ["Currency"];
        $this->LucroxPrejuizo->YFieldFormat = ["Currency"];
        $this->LucroxPrejuizo->SortType = 3;
        $this->LucroxPrejuizo->SortSequence = "";
        $this->LucroxPrejuizo->SqlSelect = $this->getQueryBuilder()->select("`cliente`", "''", "SUM(`Diferença`)");
        $this->LucroxPrejuizo->SqlGroupBy = "`cliente`";
        $this->LucroxPrejuizo->SqlOrderBy = "";
        $this->LucroxPrejuizo->SeriesDateType = "";
        $this->LucroxPrejuizo->ID = "view_lucro_prejuizo_contratos_LucroxPrejuizo"; // Chart ID
        $this->LucroxPrejuizo->setParameters([
            ["type", "1001"],
            ["seriestype", "0"]
        ]); // Chart type / Chart series type
        $this->LucroxPrejuizo->setParameters([
            ["caption", $this->LucroxPrejuizo->caption()],
            ["xaxisname", $this->LucroxPrejuizo->xAxisName()]
        ]); // Chart caption / X axis name
        $this->LucroxPrejuizo->setParameter("yaxisname", $this->LucroxPrejuizo->yAxisName()); // Y axis name
        $this->LucroxPrejuizo->setParameters([
            ["shownames", "1"],
            ["showvalues", "1"],
            ["showhovercap", "1"]
        ]); // Show names / Show values / Show hover
        $this->LucroxPrejuizo->setParameter("alpha", DbChart::getDefaultAlpha()); // Chart alpha (datasets background color)
        $this->LucroxPrejuizo->setParameters([["options.plugins.legend.display",true],["options.plugins.legend.fullWidth",false],["options.plugins.legend.reverse",false],["options.plugins.legend.rtl",false],["options.plugins.legend.labels.usePointStyle",false],["options.plugins.title.display",true],["options.plugins.tooltip.enabled",true],["options.plugins.tooltip.intersect",false],["options.plugins.tooltip.displayColors",false],["options.plugins.tooltip.rtl",false],["options.plugins.filler.propagate",false],["options.animation.animateRotate",false],["options.animation.animateScale",false],["options.scales.r.angleLines.display",false],["options.plugins.stacked100.enable",false],["dataset.showLine",false],["dataset.spanGaps",false],["dataset.steppedLine",false],["dataset.circular",false],["scale.offset",false],["scale.gridLines.offsetGridLines",false],["options.plugins.datalabels.clamp",false],["options.plugins.datalabels.clip",false],["options.plugins.datalabels.display",false],["annotation1.show",false],["annotation1.secondaryYAxis",false],["annotation2.show",false],["annotation2.secondaryYAxis",false],["annotation3.show",false],["annotation3.secondaryYAxis",false],["annotation4.show",false],["annotation4.secondaryYAxis",false]]);
        $this->Charts[$this->LucroxPrejuizo->ID] = &$this->LucroxPrejuizo;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_lucro_prejuizo_contratos";
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
        $this->cliente->DbValue = $row['cliente'];
        $this->VrCobradoR->DbValue = $row['Vr Cobrado R$'];
        $this->CustoCalculadoR->DbValue = $row['Custo Calculado R$'];
        $this->Diferenca->DbValue = $row['Diferença'];
        $this->Margem->DbValue = $row['Margem'];
        $this->Resultado->DbValue = $row['Resultado'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Set Key
    public function setKey($key, $current = false, $keySeparator = null)
    {
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        $this->OldKey = strval($key);
        $keys = explode($keySeparator, $this->OldKey);
        if (count($keys) == 0) {
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
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
        return $_SESSION[$name] ?? GetUrl("ViewLucroPrejuizoContratosList");
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
            "ViewLucroPrejuizoContratosView" => $Language->phrase("View"),
            "ViewLucroPrejuizoContratosEdit" => $Language->phrase("Edit"),
            "ViewLucroPrejuizoContratosAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewLucroPrejuizoContratosList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewLucroPrejuizoContratosView",
            Config("API_ADD_ACTION") => "ViewLucroPrejuizoContratosAdd",
            Config("API_EDIT_ACTION") => "ViewLucroPrejuizoContratosEdit",
            Config("API_DELETE_ACTION") => "ViewLucroPrejuizoContratosDelete",
            Config("API_LIST_ACTION") => "ViewLucroPrejuizoContratosList",
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
        return "ViewLucroPrejuizoContratosList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewLucroPrejuizoContratosView", $parm);
        } else {
            $url = $this->keyUrl("ViewLucroPrejuizoContratosView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewLucroPrejuizoContratosAdd?" . $parm;
        } else {
            $url = "ViewLucroPrejuizoContratosAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewLucroPrejuizoContratosEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewLucroPrejuizoContratosList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewLucroPrejuizoContratosAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewLucroPrejuizoContratosList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewLucroPrejuizoContratosDelete", $parm);
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
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
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
                    ? array_map(fn ($i) => Route($i + 3), range(0, -1))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, -1))) // Other API
                : []; // Non-API
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
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
        $this->cliente->setDbValue($row['cliente']);
        $this->VrCobradoR->setDbValue($row['Vr Cobrado R$']);
        $this->CustoCalculadoR->setDbValue($row['Custo Calculado R$']);
        $this->Diferenca->setDbValue($row['Diferença']);
        $this->Margem->setDbValue($row['Margem']);
        $this->Resultado->setDbValue($row['Resultado']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewLucroPrejuizoContratosList";
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

        // cliente
        $this->cliente->CellCssStyle = "white-space: nowrap;";

        // Vr Cobrado R$

        // Custo Calculado R$

        // Diferença

        // Margem

        // Resultado

        // cliente
        $this->cliente->ViewValue = $this->cliente->CurrentValue;
        $this->cliente->CssClass = "fw-bold";

        // Vr Cobrado R$
        $this->VrCobradoR->ViewValue = $this->VrCobradoR->CurrentValue;
        $this->VrCobradoR->ViewValue = FormatCurrency($this->VrCobradoR->ViewValue, $this->VrCobradoR->formatPattern());
        $this->VrCobradoR->CssClass = "fw-bold";
        $this->VrCobradoR->CellCssStyle .= "text-align: right;";

        // Custo Calculado R$
        $this->CustoCalculadoR->ViewValue = $this->CustoCalculadoR->CurrentValue;
        $this->CustoCalculadoR->ViewValue = FormatCurrency($this->CustoCalculadoR->ViewValue, $this->CustoCalculadoR->formatPattern());
        $this->CustoCalculadoR->CssClass = "fw-bold";
        $this->CustoCalculadoR->CellCssStyle .= "text-align: right;";

        // Diferença
        $this->Diferenca->ViewValue = $this->Diferenca->CurrentValue;
        $this->Diferenca->ViewValue = FormatCurrency($this->Diferenca->ViewValue, $this->Diferenca->formatPattern());
        $this->Diferenca->CssClass = "fw-bold";
        $this->Diferenca->CellCssStyle .= "text-align: right;";

        // Margem
        $this->Margem->ViewValue = $this->Margem->CurrentValue;
        $this->Margem->ViewValue = FormatNumber($this->Margem->ViewValue, $this->Margem->formatPattern());
        $this->Margem->CssClass = "fw-bold";
        $this->Margem->CellCssStyle .= "text-align: center;";

        // Resultado
        $this->Resultado->ViewValue = $this->Resultado->CurrentValue;

        // cliente
        $this->cliente->HrefValue = "";
        $this->cliente->TooltipValue = "";

        // Vr Cobrado R$
        $this->VrCobradoR->HrefValue = "";
        $this->VrCobradoR->TooltipValue = "";

        // Custo Calculado R$
        $this->CustoCalculadoR->HrefValue = "";
        $this->CustoCalculadoR->TooltipValue = "";

        // Diferença
        $this->Diferenca->HrefValue = "";
        $this->Diferenca->TooltipValue = "";

        // Margem
        $this->Margem->HrefValue = "";
        $this->Margem->TooltipValue = "";

        // Resultado
        $this->Resultado->HrefValue = "";
        $this->Resultado->TooltipValue = "";

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

        // cliente
        $this->cliente->setupEditAttributes();
        if (!$this->cliente->Raw) {
            $this->cliente->CurrentValue = HtmlDecode($this->cliente->CurrentValue);
        }
        $this->cliente->EditValue = $this->cliente->CurrentValue;
        $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());

        // Vr Cobrado R$
        $this->VrCobradoR->setupEditAttributes();
        $this->VrCobradoR->EditValue = $this->VrCobradoR->CurrentValue;
        $this->VrCobradoR->PlaceHolder = RemoveHtml($this->VrCobradoR->caption());
        if (strval($this->VrCobradoR->EditValue) != "" && is_numeric($this->VrCobradoR->EditValue)) {
            $this->VrCobradoR->EditValue = FormatNumber($this->VrCobradoR->EditValue, null);
        }

        // Custo Calculado R$
        $this->CustoCalculadoR->setupEditAttributes();
        $this->CustoCalculadoR->EditValue = $this->CustoCalculadoR->CurrentValue;
        $this->CustoCalculadoR->PlaceHolder = RemoveHtml($this->CustoCalculadoR->caption());
        if (strval($this->CustoCalculadoR->EditValue) != "" && is_numeric($this->CustoCalculadoR->EditValue)) {
            $this->CustoCalculadoR->EditValue = FormatNumber($this->CustoCalculadoR->EditValue, null);
        }

        // Diferença
        $this->Diferenca->setupEditAttributes();
        $this->Diferenca->EditValue = $this->Diferenca->CurrentValue;
        $this->Diferenca->PlaceHolder = RemoveHtml($this->Diferenca->caption());
        if (strval($this->Diferenca->EditValue) != "" && is_numeric($this->Diferenca->EditValue)) {
            $this->Diferenca->EditValue = FormatNumber($this->Diferenca->EditValue, null);
        }

        // Margem
        $this->Margem->setupEditAttributes();
        $this->Margem->EditValue = $this->Margem->CurrentValue;
        $this->Margem->PlaceHolder = RemoveHtml($this->Margem->caption());
        if (strval($this->Margem->EditValue) != "" && is_numeric($this->Margem->EditValue)) {
            $this->Margem->EditValue = FormatNumber($this->Margem->EditValue, null);
        }

        // Resultado
        $this->Resultado->setupEditAttributes();
        if (!$this->Resultado->Raw) {
            $this->Resultado->CurrentValue = HtmlDecode($this->Resultado->CurrentValue);
        }
        $this->Resultado->EditValue = $this->Resultado->CurrentValue;
        $this->Resultado->PlaceHolder = RemoveHtml($this->Resultado->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            if (is_numeric($this->VrCobradoR->CurrentValue)) {
                $this->VrCobradoR->Total += $this->VrCobradoR->CurrentValue; // Accumulate total
            }
            if (is_numeric($this->CustoCalculadoR->CurrentValue)) {
                $this->CustoCalculadoR->Total += $this->CustoCalculadoR->CurrentValue; // Accumulate total
            }
            if (is_numeric($this->Diferenca->CurrentValue)) {
                $this->Diferenca->Total += $this->Diferenca->CurrentValue; // Accumulate total
            }
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->VrCobradoR->CurrentValue = $this->VrCobradoR->Total;
            $this->VrCobradoR->ViewValue = $this->VrCobradoR->CurrentValue;
            $this->VrCobradoR->ViewValue = FormatCurrency($this->VrCobradoR->ViewValue, $this->VrCobradoR->formatPattern());
            $this->VrCobradoR->CssClass = "fw-bold";
            $this->VrCobradoR->CellCssStyle .= "text-align: right;";
            $this->VrCobradoR->HrefValue = ""; // Clear href value
            $this->CustoCalculadoR->CurrentValue = $this->CustoCalculadoR->Total;
            $this->CustoCalculadoR->ViewValue = $this->CustoCalculadoR->CurrentValue;
            $this->CustoCalculadoR->ViewValue = FormatCurrency($this->CustoCalculadoR->ViewValue, $this->CustoCalculadoR->formatPattern());
            $this->CustoCalculadoR->CssClass = "fw-bold";
            $this->CustoCalculadoR->CellCssStyle .= "text-align: right;";
            $this->CustoCalculadoR->HrefValue = ""; // Clear href value
            $this->Diferenca->CurrentValue = $this->Diferenca->Total;
            $this->Diferenca->ViewValue = $this->Diferenca->CurrentValue;
            $this->Diferenca->ViewValue = FormatCurrency($this->Diferenca->ViewValue, $this->Diferenca->formatPattern());
            $this->Diferenca->CssClass = "fw-bold";
            $this->Diferenca->CellCssStyle .= "text-align: right;";
            $this->Diferenca->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->VrCobradoR);
                    $doc->exportCaption($this->CustoCalculadoR);
                    $doc->exportCaption($this->Diferenca);
                    $doc->exportCaption($this->Margem);
                    $doc->exportCaption($this->Resultado);
                } else {
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->VrCobradoR);
                    $doc->exportCaption($this->CustoCalculadoR);
                    $doc->exportCaption($this->Diferenca);
                    $doc->exportCaption($this->Margem);
                    $doc->exportCaption($this->Resultado);
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
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->VrCobradoR);
                        $doc->exportField($this->CustoCalculadoR);
                        $doc->exportField($this->Diferenca);
                        $doc->exportField($this->Margem);
                        $doc->exportField($this->Resultado);
                    } else {
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->VrCobradoR);
                        $doc->exportField($this->CustoCalculadoR);
                        $doc->exportField($this->Diferenca);
                        $doc->exportField($this->Margem);
                        $doc->exportField($this->Resultado);
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
                $doc->exportAggregate($this->cliente, '');
                $doc->exportAggregate($this->VrCobradoR, 'TOTAL');
                $doc->exportAggregate($this->CustoCalculadoR, 'TOTAL');
                $doc->exportAggregate($this->Diferenca, 'TOTAL');
                $doc->exportAggregate($this->Margem, '');
                $doc->exportAggregate($this->Resultado, '');
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
