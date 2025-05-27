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
 * Table class for itens_modulo
 */
class ItensModulo extends DbTable
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
    public $iditens_modulo;
    public $modulo_idmodulo;
    public $item;
    public $porcentagem_valor;
    public $incidencia_inss;
    public $ativo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "itens_modulo";
        $this->TableName = 'itens_modulo';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "itens_modulo";
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

        // iditens_modulo
        $this->iditens_modulo = new DbField(
            $this, // Table
            'x_iditens_modulo', // Variable name
            'iditens_modulo', // Name
            '`iditens_modulo`', // Expression
            '`iditens_modulo`', // Basic search expression
            19, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`iditens_modulo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->iditens_modulo->InputTextType = "text";
        $this->iditens_modulo->Raw = true;
        $this->iditens_modulo->IsAutoIncrement = true; // Autoincrement field
        $this->iditens_modulo->IsPrimaryKey = true; // Primary key field
        $this->iditens_modulo->Nullable = false; // NOT NULL field
        $this->iditens_modulo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->iditens_modulo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['iditens_modulo'] = &$this->iditens_modulo;

        // modulo_idmodulo
        $this->modulo_idmodulo = new DbField(
            $this, // Table
            'x_modulo_idmodulo', // Variable name
            'modulo_idmodulo', // Name
            '`modulo_idmodulo`', // Expression
            '`modulo_idmodulo`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`modulo_idmodulo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->modulo_idmodulo->InputTextType = "text";
        $this->modulo_idmodulo->Raw = true;
        $this->modulo_idmodulo->IsForeignKey = true; // Foreign key field
        $this->modulo_idmodulo->Nullable = false; // NOT NULL field
        $this->modulo_idmodulo->Required = true; // Required field
        $this->modulo_idmodulo->setSelectMultiple(false); // Select one
        $this->modulo_idmodulo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->modulo_idmodulo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->modulo_idmodulo->Lookup = new Lookup($this->modulo_idmodulo, 'modulo', false, 'idmodulo', ["modulo","","",""], '', '', [], [], [], [], [], [], false, '', '', "`modulo`");
        $this->modulo_idmodulo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->modulo_idmodulo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['modulo_idmodulo'] = &$this->modulo_idmodulo;

        // item
        $this->item = new DbField(
            $this, // Table
            'x_item', // Variable name
            'item', // Name
            '`item`', // Expression
            '`item`', // Basic search expression
            200, // Type
            155, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`item`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->item->InputTextType = "text";
        $this->item->Nullable = false; // NOT NULL field
        $this->item->Required = true; // Required field
        $this->item->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['item'] = &$this->item;

        // porcentagem_valor
        $this->porcentagem_valor = new DbField(
            $this, // Table
            'x_porcentagem_valor', // Variable name
            'porcentagem_valor', // Name
            '`porcentagem_valor`', // Expression
            '`porcentagem_valor`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`porcentagem_valor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->porcentagem_valor->InputTextType = "text";
        $this->porcentagem_valor->Raw = true;
        $this->porcentagem_valor->Nullable = false; // NOT NULL field
        $this->porcentagem_valor->Required = true; // Required field
        $this->porcentagem_valor->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->porcentagem_valor->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['porcentagem_valor'] = &$this->porcentagem_valor;

        // incidencia_inss
        $this->incidencia_inss = new DbField(
            $this, // Table
            'x_incidencia_inss', // Variable name
            'incidencia_inss', // Name
            '`incidencia_inss`', // Expression
            '`incidencia_inss`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`incidencia_inss`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->incidencia_inss->addMethod("getDefault", fn() => "Sim");
        $this->incidencia_inss->InputTextType = "text";
        $this->incidencia_inss->Raw = true;
        $this->incidencia_inss->Nullable = false; // NOT NULL field
        $this->incidencia_inss->Lookup = new Lookup($this->incidencia_inss, 'itens_modulo', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->incidencia_inss->OptionCount = 2;
        $this->incidencia_inss->SearchOperators = ["=", "<>"];
        $this->Fields['incidencia_inss'] = &$this->incidencia_inss;

        // ativo
        $this->ativo = new DbField(
            $this, // Table
            'x_ativo', // Variable name
            'ativo', // Name
            '`ativo`', // Expression
            '`ativo`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ativo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->ativo->addMethod("getDefault", fn() => "Sim");
        $this->ativo->InputTextType = "text";
        $this->ativo->Raw = true;
        $this->ativo->Nullable = false; // NOT NULL field
        $this->ativo->Required = true; // Required field
        $this->ativo->Lookup = new Lookup($this->ativo, 'itens_modulo', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->ativo->OptionCount = 2;
        $this->ativo->SearchOperators = ["=", "<>"];
        $this->Fields['ativo'] = &$this->ativo;

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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "modulo") {
            $masterTable = Container("modulo");
            if ($this->modulo_idmodulo->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->idmodulo, $this->modulo_idmodulo->getSessionValue(), $masterTable->idmodulo->DataType, $masterTable->Dbid);
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "modulo") {
            $masterTable = Container("modulo");
            if ($this->modulo_idmodulo->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->modulo_idmodulo, $this->modulo_idmodulo->getSessionValue(), $masterTable->idmodulo->DataType, $this->Dbid);
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter($masterTable, $keys)
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "modulo":
                $key = $keys["modulo_idmodulo"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->idmodulo->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->idmodulo, $keys["modulo_idmodulo"], $this->modulo_idmodulo->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "modulo":
                return GetKeyFilter($this->modulo_idmodulo, $masterTable->idmodulo->DbValue, $masterTable->idmodulo->DataType, $masterTable->Dbid);
        }
        return "";
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "itens_modulo";
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
            $this->iditens_modulo->setDbValue($conn->lastInsertId());
            $rs['iditens_modulo'] = $this->iditens_modulo->DbValue;
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
            if (!isset($rs['iditens_modulo']) && !EmptyValue($this->iditens_modulo->CurrentValue)) {
                $rs['iditens_modulo'] = $this->iditens_modulo->CurrentValue;
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
            if (array_key_exists('iditens_modulo', $rs)) {
                AddFilter($where, QuotedName('iditens_modulo', $this->Dbid) . '=' . QuotedValue($rs['iditens_modulo'], $this->iditens_modulo->DataType, $this->Dbid));
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
        $this->iditens_modulo->DbValue = $row['iditens_modulo'];
        $this->modulo_idmodulo->DbValue = $row['modulo_idmodulo'];
        $this->item->DbValue = $row['item'];
        $this->porcentagem_valor->DbValue = $row['porcentagem_valor'];
        $this->incidencia_inss->DbValue = $row['incidencia_inss'];
        $this->ativo->DbValue = $row['ativo'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`iditens_modulo` = @iditens_modulo@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->iditens_modulo->CurrentValue : $this->iditens_modulo->OldValue;
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
                $this->iditens_modulo->CurrentValue = $keys[0];
            } else {
                $this->iditens_modulo->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('iditens_modulo', $row) ? $row['iditens_modulo'] : null;
        } else {
            $val = !EmptyValue($this->iditens_modulo->OldValue) && !$current ? $this->iditens_modulo->OldValue : $this->iditens_modulo->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@iditens_modulo@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ItensModuloList");
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
            "ItensModuloView" => $Language->phrase("View"),
            "ItensModuloEdit" => $Language->phrase("Edit"),
            "ItensModuloAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ItensModuloList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ItensModuloView",
            Config("API_ADD_ACTION") => "ItensModuloAdd",
            Config("API_EDIT_ACTION") => "ItensModuloEdit",
            Config("API_DELETE_ACTION") => "ItensModuloDelete",
            Config("API_LIST_ACTION") => "ItensModuloList",
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
        return "ItensModuloList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ItensModuloView", $parm);
        } else {
            $url = $this->keyUrl("ItensModuloView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ItensModuloAdd?" . $parm;
        } else {
            $url = "ItensModuloAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ItensModuloEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ItensModuloList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ItensModuloAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ItensModuloList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ItensModuloDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "modulo" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_idmodulo", $this->modulo_idmodulo->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"iditens_modulo\":" . VarToJson($this->iditens_modulo->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->iditens_modulo->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->iditens_modulo->CurrentValue);
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
            if (($keyValue = Param("iditens_modulo") ?? Route("iditens_modulo")) !== null) {
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
                $this->iditens_modulo->CurrentValue = $key;
            } else {
                $this->iditens_modulo->OldValue = $key;
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
        $this->iditens_modulo->setDbValue($row['iditens_modulo']);
        $this->modulo_idmodulo->setDbValue($row['modulo_idmodulo']);
        $this->item->setDbValue($row['item']);
        $this->porcentagem_valor->setDbValue($row['porcentagem_valor']);
        $this->incidencia_inss->setDbValue($row['incidencia_inss']);
        $this->ativo->setDbValue($row['ativo']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ItensModuloList";
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

        // iditens_modulo

        // modulo_idmodulo

        // item

        // porcentagem_valor

        // incidencia_inss

        // ativo

        // iditens_modulo
        $this->iditens_modulo->ViewValue = $this->iditens_modulo->CurrentValue;

        // modulo_idmodulo
        $curVal = strval($this->modulo_idmodulo->CurrentValue);
        if ($curVal != "") {
            $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->lookupCacheOption($curVal);
            if ($this->modulo_idmodulo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->modulo_idmodulo->Lookup->getTable()->Fields["idmodulo"]->searchExpression(), "=", $curVal, $this->modulo_idmodulo->Lookup->getTable()->Fields["idmodulo"]->searchDataType(), "");
                $sqlWrk = $this->modulo_idmodulo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->modulo_idmodulo->Lookup->renderViewRow($rswrk[0]);
                    $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->displayValue($arwrk);
                } else {
                    $this->modulo_idmodulo->ViewValue = FormatNumber($this->modulo_idmodulo->CurrentValue, $this->modulo_idmodulo->formatPattern());
                }
            }
        } else {
            $this->modulo_idmodulo->ViewValue = null;
        }
        $this->modulo_idmodulo->CssClass = "fw-bold";

        // item
        $this->item->ViewValue = $this->item->CurrentValue;
        $this->item->CssClass = "fw-bold";

        // porcentagem_valor
        $this->porcentagem_valor->ViewValue = $this->porcentagem_valor->CurrentValue;
        $this->porcentagem_valor->ViewValue = FormatCurrency($this->porcentagem_valor->ViewValue, $this->porcentagem_valor->formatPattern());
        $this->porcentagem_valor->CssClass = "fw-bold";
        $this->porcentagem_valor->CellCssStyle .= "text-align: right;";

        // incidencia_inss
        if (strval($this->incidencia_inss->CurrentValue) != "") {
            $this->incidencia_inss->ViewValue = $this->incidencia_inss->optionCaption($this->incidencia_inss->CurrentValue);
        } else {
            $this->incidencia_inss->ViewValue = null;
        }
        $this->incidencia_inss->CssClass = "fw-bold";
        $this->incidencia_inss->CellCssStyle .= "text-align: center;";

        // ativo
        if (strval($this->ativo->CurrentValue) != "") {
            $this->ativo->ViewValue = $this->ativo->optionCaption($this->ativo->CurrentValue);
        } else {
            $this->ativo->ViewValue = null;
        }
        $this->ativo->CssClass = "fw-bold";
        $this->ativo->CellCssStyle .= "text-align: center;";

        // iditens_modulo
        $this->iditens_modulo->HrefValue = "";
        $this->iditens_modulo->TooltipValue = "";

        // modulo_idmodulo
        $this->modulo_idmodulo->HrefValue = "";
        $this->modulo_idmodulo->TooltipValue = "";

        // item
        $this->item->HrefValue = "";
        $this->item->TooltipValue = "";

        // porcentagem_valor
        $this->porcentagem_valor->HrefValue = "";
        $this->porcentagem_valor->TooltipValue = "";

        // incidencia_inss
        $this->incidencia_inss->HrefValue = "";
        $this->incidencia_inss->TooltipValue = "";

        // ativo
        $this->ativo->HrefValue = "";
        $this->ativo->TooltipValue = "";

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

        // iditens_modulo
        $this->iditens_modulo->setupEditAttributes();
        $this->iditens_modulo->EditValue = $this->iditens_modulo->CurrentValue;

        // modulo_idmodulo
        $this->modulo_idmodulo->setupEditAttributes();
        if ($this->modulo_idmodulo->getSessionValue() != "") {
            $this->modulo_idmodulo->CurrentValue = GetForeignKeyValue($this->modulo_idmodulo->getSessionValue());
            $curVal = strval($this->modulo_idmodulo->CurrentValue);
            if ($curVal != "") {
                $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->lookupCacheOption($curVal);
                if ($this->modulo_idmodulo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->modulo_idmodulo->Lookup->getTable()->Fields["idmodulo"]->searchExpression(), "=", $curVal, $this->modulo_idmodulo->Lookup->getTable()->Fields["idmodulo"]->searchDataType(), "");
                    $sqlWrk = $this->modulo_idmodulo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->modulo_idmodulo->Lookup->renderViewRow($rswrk[0]);
                        $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->displayValue($arwrk);
                    } else {
                        $this->modulo_idmodulo->ViewValue = FormatNumber($this->modulo_idmodulo->CurrentValue, $this->modulo_idmodulo->formatPattern());
                    }
                }
            } else {
                $this->modulo_idmodulo->ViewValue = null;
            }
            $this->modulo_idmodulo->CssClass = "fw-bold";
        } else {
            $this->modulo_idmodulo->PlaceHolder = RemoveHtml($this->modulo_idmodulo->caption());
        }

        // item
        $this->item->setupEditAttributes();
        if (!$this->item->Raw) {
            $this->item->CurrentValue = HtmlDecode($this->item->CurrentValue);
        }
        $this->item->EditValue = $this->item->CurrentValue;
        $this->item->PlaceHolder = RemoveHtml($this->item->caption());

        // porcentagem_valor
        $this->porcentagem_valor->setupEditAttributes();
        $this->porcentagem_valor->EditValue = $this->porcentagem_valor->CurrentValue;
        $this->porcentagem_valor->PlaceHolder = RemoveHtml($this->porcentagem_valor->caption());
        if (strval($this->porcentagem_valor->EditValue) != "" && is_numeric($this->porcentagem_valor->EditValue)) {
            $this->porcentagem_valor->EditValue = FormatNumber($this->porcentagem_valor->EditValue, null);
        }

        // incidencia_inss
        $this->incidencia_inss->EditValue = $this->incidencia_inss->options(false);
        $this->incidencia_inss->PlaceHolder = RemoveHtml($this->incidencia_inss->caption());

        // ativo
        $this->ativo->EditValue = $this->ativo->options(false);
        $this->ativo->PlaceHolder = RemoveHtml($this->ativo->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            $this->item->Count++; // Increment count
            if (is_numeric($this->porcentagem_valor->CurrentValue)) {
                $this->porcentagem_valor->Total += $this->porcentagem_valor->CurrentValue; // Accumulate total
            }
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->item->CurrentValue = $this->item->Count;
            $this->item->ViewValue = $this->item->CurrentValue;
            $this->item->CssClass = "fw-bold";
            $this->item->HrefValue = ""; // Clear href value
            $this->porcentagem_valor->CurrentValue = $this->porcentagem_valor->Total;
            $this->porcentagem_valor->ViewValue = $this->porcentagem_valor->CurrentValue;
            $this->porcentagem_valor->ViewValue = FormatCurrency($this->porcentagem_valor->ViewValue, $this->porcentagem_valor->formatPattern());
            $this->porcentagem_valor->CssClass = "fw-bold";
            $this->porcentagem_valor->CellCssStyle .= "text-align: right;";
            $this->porcentagem_valor->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->iditens_modulo);
                    $doc->exportCaption($this->modulo_idmodulo);
                    $doc->exportCaption($this->item);
                    $doc->exportCaption($this->porcentagem_valor);
                    $doc->exportCaption($this->incidencia_inss);
                    $doc->exportCaption($this->ativo);
                } else {
                    $doc->exportCaption($this->iditens_modulo);
                    $doc->exportCaption($this->modulo_idmodulo);
                    $doc->exportCaption($this->item);
                    $doc->exportCaption($this->porcentagem_valor);
                    $doc->exportCaption($this->incidencia_inss);
                    $doc->exportCaption($this->ativo);
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
                        $doc->exportField($this->iditens_modulo);
                        $doc->exportField($this->modulo_idmodulo);
                        $doc->exportField($this->item);
                        $doc->exportField($this->porcentagem_valor);
                        $doc->exportField($this->incidencia_inss);
                        $doc->exportField($this->ativo);
                    } else {
                        $doc->exportField($this->iditens_modulo);
                        $doc->exportField($this->modulo_idmodulo);
                        $doc->exportField($this->item);
                        $doc->exportField($this->porcentagem_valor);
                        $doc->exportField($this->incidencia_inss);
                        $doc->exportField($this->ativo);
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
                $doc->exportAggregate($this->iditens_modulo, '');
                $doc->exportAggregate($this->modulo_idmodulo, '');
                $doc->exportAggregate($this->item, 'COUNT');
                $doc->exportAggregate($this->porcentagem_valor, 'TOTAL');
                $doc->exportAggregate($this->incidencia_inss, '');
                $doc->exportAggregate($this->ativo, '');
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
