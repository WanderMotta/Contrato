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
 * Table class for beneficios
 */
class Beneficios extends DbTable
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
    public $idbeneficios;
    public $data;
    public $vt_dia;
    public $vr_dia;
    public $va_mes;
    public $benef_social;
    public $plr;
    public $assis_medica;
    public $assis_odonto;
    public $dissidio_anual_iddissidio_anual;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "beneficios";
        $this->TableName = 'beneficios';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "beneficios";
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

        // idbeneficios
        $this->idbeneficios = new DbField(
            $this, // Table
            'x_idbeneficios', // Variable name
            'idbeneficios', // Name
            '`idbeneficios`', // Expression
            '`idbeneficios`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idbeneficios`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idbeneficios->InputTextType = "text";
        $this->idbeneficios->Raw = true;
        $this->idbeneficios->IsAutoIncrement = true; // Autoincrement field
        $this->idbeneficios->IsPrimaryKey = true; // Primary key field
        $this->idbeneficios->Nullable = false; // NOT NULL field
        $this->idbeneficios->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idbeneficios->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idbeneficios'] = &$this->idbeneficios;

        // data
        $this->data = new DbField(
            $this, // Table
            'x_data', // Variable name
            'data', // Name
            '`data`', // Expression
            CastDateFieldForLike("`data`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`data`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->data->InputTextType = "text";
        $this->data->Raw = true;
        $this->data->Nullable = false; // NOT NULL field
        $this->data->Required = true; // Required field
        $this->data->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->data->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['data'] = &$this->data;

        // vt_dia
        $this->vt_dia = new DbField(
            $this, // Table
            'x_vt_dia', // Variable name
            'vt_dia', // Name
            '`vt_dia`', // Expression
            '`vt_dia`', // Basic search expression
            131, // Type
            12, // Size
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
            12, // Size
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

        // plr
        $this->plr = new DbField(
            $this, // Table
            'x_plr', // Variable name
            'plr', // Name
            '`plr`', // Expression
            '`plr`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`plr`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->plr->addMethod("getDefault", fn() => 0.00);
        $this->plr->InputTextType = "text";
        $this->plr->Raw = true;
        $this->plr->Nullable = false; // NOT NULL field
        $this->plr->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->plr->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['plr'] = &$this->plr;

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

        // dissidio_anual_iddissidio_anual
        $this->dissidio_anual_iddissidio_anual = new DbField(
            $this, // Table
            'x_dissidio_anual_iddissidio_anual', // Variable name
            'dissidio_anual_iddissidio_anual', // Name
            '`dissidio_anual_iddissidio_anual`', // Expression
            '`dissidio_anual_iddissidio_anual`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`dissidio_anual_iddissidio_anual`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dissidio_anual_iddissidio_anual->InputTextType = "text";
        $this->dissidio_anual_iddissidio_anual->Raw = true;
        $this->dissidio_anual_iddissidio_anual->IsForeignKey = true; // Foreign key field
        $this->dissidio_anual_iddissidio_anual->Nullable = false; // NOT NULL field
        $this->dissidio_anual_iddissidio_anual->Required = true; // Required field
        $this->dissidio_anual_iddissidio_anual->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->dissidio_anual_iddissidio_anual->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dissidio_anual_iddissidio_anual'] = &$this->dissidio_anual_iddissidio_anual;

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
        if ($this->getCurrentMasterTable() == "dissidio_anual") {
            $masterTable = Container("dissidio_anual");
            if ($this->dissidio_anual_iddissidio_anual->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->iddissidio_anual, $this->dissidio_anual_iddissidio_anual->getSessionValue(), $masterTable->iddissidio_anual->DataType, $masterTable->Dbid);
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
        if ($this->getCurrentMasterTable() == "dissidio_anual") {
            $masterTable = Container("dissidio_anual");
            if ($this->dissidio_anual_iddissidio_anual->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->dissidio_anual_iddissidio_anual, $this->dissidio_anual_iddissidio_anual->getSessionValue(), $masterTable->iddissidio_anual->DataType, $this->Dbid);
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
            case "dissidio_anual":
                $key = $keys["dissidio_anual_iddissidio_anual"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->iddissidio_anual->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->iddissidio_anual, $keys["dissidio_anual_iddissidio_anual"], $this->dissidio_anual_iddissidio_anual->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "dissidio_anual":
                return GetKeyFilter($this->dissidio_anual_iddissidio_anual, $masterTable->iddissidio_anual->DbValue, $masterTable->iddissidio_anual->DataType, $masterTable->Dbid);
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "beneficios";
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
            $this->idbeneficios->setDbValue($conn->lastInsertId());
            $rs['idbeneficios'] = $this->idbeneficios->DbValue;
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
            if (!isset($rs['idbeneficios']) && !EmptyValue($this->idbeneficios->CurrentValue)) {
                $rs['idbeneficios'] = $this->idbeneficios->CurrentValue;
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
            if (array_key_exists('idbeneficios', $rs)) {
                AddFilter($where, QuotedName('idbeneficios', $this->Dbid) . '=' . QuotedValue($rs['idbeneficios'], $this->idbeneficios->DataType, $this->Dbid));
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
        $this->idbeneficios->DbValue = $row['idbeneficios'];
        $this->data->DbValue = $row['data'];
        $this->vt_dia->DbValue = $row['vt_dia'];
        $this->vr_dia->DbValue = $row['vr_dia'];
        $this->va_mes->DbValue = $row['va_mes'];
        $this->benef_social->DbValue = $row['benef_social'];
        $this->plr->DbValue = $row['plr'];
        $this->assis_medica->DbValue = $row['assis_medica'];
        $this->assis_odonto->DbValue = $row['assis_odonto'];
        $this->dissidio_anual_iddissidio_anual->DbValue = $row['dissidio_anual_iddissidio_anual'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idbeneficios` = @idbeneficios@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idbeneficios->CurrentValue : $this->idbeneficios->OldValue;
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
                $this->idbeneficios->CurrentValue = $keys[0];
            } else {
                $this->idbeneficios->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idbeneficios', $row) ? $row['idbeneficios'] : null;
        } else {
            $val = !EmptyValue($this->idbeneficios->OldValue) && !$current ? $this->idbeneficios->OldValue : $this->idbeneficios->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idbeneficios@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("BeneficiosList");
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
            "BeneficiosView" => $Language->phrase("View"),
            "BeneficiosEdit" => $Language->phrase("Edit"),
            "BeneficiosAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "BeneficiosList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "BeneficiosView",
            Config("API_ADD_ACTION") => "BeneficiosAdd",
            Config("API_EDIT_ACTION") => "BeneficiosEdit",
            Config("API_DELETE_ACTION") => "BeneficiosDelete",
            Config("API_LIST_ACTION") => "BeneficiosList",
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
        return "BeneficiosList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("BeneficiosView", $parm);
        } else {
            $url = $this->keyUrl("BeneficiosView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "BeneficiosAdd?" . $parm;
        } else {
            $url = "BeneficiosAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("BeneficiosEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("BeneficiosList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("BeneficiosAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("BeneficiosList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("BeneficiosDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "dissidio_anual" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_iddissidio_anual", $this->dissidio_anual_iddissidio_anual->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"idbeneficios\":" . VarToJson($this->idbeneficios->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idbeneficios->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idbeneficios->CurrentValue);
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
            if (($keyValue = Param("idbeneficios") ?? Route("idbeneficios")) !== null) {
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
                $this->idbeneficios->CurrentValue = $key;
            } else {
                $this->idbeneficios->OldValue = $key;
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
        $this->idbeneficios->setDbValue($row['idbeneficios']);
        $this->data->setDbValue($row['data']);
        $this->vt_dia->setDbValue($row['vt_dia']);
        $this->vr_dia->setDbValue($row['vr_dia']);
        $this->va_mes->setDbValue($row['va_mes']);
        $this->benef_social->setDbValue($row['benef_social']);
        $this->plr->setDbValue($row['plr']);
        $this->assis_medica->setDbValue($row['assis_medica']);
        $this->assis_odonto->setDbValue($row['assis_odonto']);
        $this->dissidio_anual_iddissidio_anual->setDbValue($row['dissidio_anual_iddissidio_anual']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "BeneficiosList";
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

        // idbeneficios

        // data

        // vt_dia

        // vr_dia

        // va_mes

        // benef_social

        // plr

        // assis_medica

        // assis_odonto

        // dissidio_anual_iddissidio_anual

        // idbeneficios
        $this->idbeneficios->ViewValue = $this->idbeneficios->CurrentValue;

        // data
        $this->data->ViewValue = $this->data->CurrentValue;
        $this->data->ViewValue = FormatDateTime($this->data->ViewValue, $this->data->formatPattern());
        $this->data->CssClass = "fw-bold";

        // vt_dia
        $this->vt_dia->ViewValue = $this->vt_dia->CurrentValue;
        $this->vt_dia->ViewValue = FormatNumber($this->vt_dia->ViewValue, $this->vt_dia->formatPattern());
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

        // plr
        $this->plr->ViewValue = $this->plr->CurrentValue;
        $this->plr->ViewValue = FormatCurrency($this->plr->ViewValue, $this->plr->formatPattern());
        $this->plr->CssClass = "fw-bold";
        $this->plr->CellCssStyle .= "text-align: right;";

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

        // dissidio_anual_iddissidio_anual
        $this->dissidio_anual_iddissidio_anual->ViewValue = $this->dissidio_anual_iddissidio_anual->CurrentValue;
        $this->dissidio_anual_iddissidio_anual->ViewValue = FormatNumber($this->dissidio_anual_iddissidio_anual->ViewValue, $this->dissidio_anual_iddissidio_anual->formatPattern());

        // idbeneficios
        $this->idbeneficios->HrefValue = "";
        $this->idbeneficios->TooltipValue = "";

        // data
        $this->data->HrefValue = "";
        $this->data->TooltipValue = "";

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

        // plr
        $this->plr->HrefValue = "";
        $this->plr->TooltipValue = "";

        // assis_medica
        $this->assis_medica->HrefValue = "";
        $this->assis_medica->TooltipValue = "";

        // assis_odonto
        $this->assis_odonto->HrefValue = "";
        $this->assis_odonto->TooltipValue = "";

        // dissidio_anual_iddissidio_anual
        $this->dissidio_anual_iddissidio_anual->HrefValue = "";
        $this->dissidio_anual_iddissidio_anual->TooltipValue = "";

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

        // idbeneficios
        $this->idbeneficios->setupEditAttributes();
        $this->idbeneficios->EditValue = $this->idbeneficios->CurrentValue;

        // data
        $this->data->setupEditAttributes();
        $this->data->EditValue = $this->data->CurrentValue;
        $this->data->EditValue = FormatDateTime($this->data->EditValue, $this->data->formatPattern());
        $this->data->CssClass = "fw-bold";

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

        // plr
        $this->plr->setupEditAttributes();
        $this->plr->EditValue = $this->plr->CurrentValue;
        $this->plr->PlaceHolder = RemoveHtml($this->plr->caption());
        if (strval($this->plr->EditValue) != "" && is_numeric($this->plr->EditValue)) {
            $this->plr->EditValue = FormatNumber($this->plr->EditValue, null);
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

        // dissidio_anual_iddissidio_anual
        $this->dissidio_anual_iddissidio_anual->setupEditAttributes();
        $this->dissidio_anual_iddissidio_anual->EditValue = $this->dissidio_anual_iddissidio_anual->CurrentValue;
        $this->dissidio_anual_iddissidio_anual->EditValue = FormatNumber($this->dissidio_anual_iddissidio_anual->EditValue, $this->dissidio_anual_iddissidio_anual->formatPattern());

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
                    $doc->exportCaption($this->idbeneficios);
                    $doc->exportCaption($this->data);
                    $doc->exportCaption($this->vt_dia);
                    $doc->exportCaption($this->vr_dia);
                    $doc->exportCaption($this->va_mes);
                    $doc->exportCaption($this->benef_social);
                    $doc->exportCaption($this->plr);
                    $doc->exportCaption($this->assis_medica);
                    $doc->exportCaption($this->assis_odonto);
                    $doc->exportCaption($this->dissidio_anual_iddissidio_anual);
                } else {
                    $doc->exportCaption($this->idbeneficios);
                    $doc->exportCaption($this->data);
                    $doc->exportCaption($this->vt_dia);
                    $doc->exportCaption($this->vr_dia);
                    $doc->exportCaption($this->va_mes);
                    $doc->exportCaption($this->benef_social);
                    $doc->exportCaption($this->plr);
                    $doc->exportCaption($this->assis_medica);
                    $doc->exportCaption($this->assis_odonto);
                    $doc->exportCaption($this->dissidio_anual_iddissidio_anual);
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
                        $doc->exportField($this->idbeneficios);
                        $doc->exportField($this->data);
                        $doc->exportField($this->vt_dia);
                        $doc->exportField($this->vr_dia);
                        $doc->exportField($this->va_mes);
                        $doc->exportField($this->benef_social);
                        $doc->exportField($this->plr);
                        $doc->exportField($this->assis_medica);
                        $doc->exportField($this->assis_odonto);
                        $doc->exportField($this->dissidio_anual_iddissidio_anual);
                    } else {
                        $doc->exportField($this->idbeneficios);
                        $doc->exportField($this->data);
                        $doc->exportField($this->vt_dia);
                        $doc->exportField($this->vr_dia);
                        $doc->exportField($this->va_mes);
                        $doc->exportField($this->benef_social);
                        $doc->exportField($this->plr);
                        $doc->exportField($this->assis_medica);
                        $doc->exportField($this->assis_odonto);
                        $doc->exportField($this->dissidio_anual_iddissidio_anual);
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
