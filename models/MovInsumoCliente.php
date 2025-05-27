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
 * Table class for mov_insumo_cliente
 */
class MovInsumoCliente extends DbTable
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
    public $idmov_insumo_cliente;
    public $dt_cadastro;
    public $tipo_insumo_idtipo_insumo;
    public $insumo_idinsumo;
    public $qtde;
    public $frequencia;
    public $vr_unit;
    public $vr_total;
    public $proposta_idproposta;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "mov_insumo_cliente";
        $this->TableName = 'mov_insumo_cliente';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "mov_insumo_cliente";
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

        // idmov_insumo_cliente
        $this->idmov_insumo_cliente = new DbField(
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
        $this->Fields['idmov_insumo_cliente'] = &$this->idmov_insumo_cliente;

        // dt_cadastro
        $this->dt_cadastro = new DbField(
            $this, // Table
            'x_dt_cadastro', // Variable name
            'dt_cadastro', // Name
            '`dt_cadastro`', // Expression
            CastDateFieldForLike("`dt_cadastro`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`dt_cadastro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dt_cadastro->addMethod("getAutoUpdateValue", fn() => CurrentDate());
        $this->dt_cadastro->InputTextType = "text";
        $this->dt_cadastro->Raw = true;
        $this->dt_cadastro->Nullable = false; // NOT NULL field
        $this->dt_cadastro->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_cadastro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dt_cadastro'] = &$this->dt_cadastro;

        // tipo_insumo_idtipo_insumo
        $this->tipo_insumo_idtipo_insumo = new DbField(
            $this, // Table
            'x_tipo_insumo_idtipo_insumo', // Variable name
            'tipo_insumo_idtipo_insumo', // Name
            '`tipo_insumo_idtipo_insumo`', // Expression
            '`tipo_insumo_idtipo_insumo`', // Basic search expression
            19, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_insumo_idtipo_insumo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->tipo_insumo_idtipo_insumo->InputTextType = "text";
        $this->tipo_insumo_idtipo_insumo->Raw = true;
        $this->tipo_insumo_idtipo_insumo->Nullable = false; // NOT NULL field
        $this->tipo_insumo_idtipo_insumo->Required = true; // Required field
        $this->tipo_insumo_idtipo_insumo->Lookup = new Lookup($this->tipo_insumo_idtipo_insumo, 'tipo_insumo', false, 'idtipo_insumo', ["tipo_insumo","","",""], '', '', [], ["x_insumo_idinsumo"], [], [], [], [], false, '`tipo_insumo` ASC', '', "`tipo_insumo`");
        $this->tipo_insumo_idtipo_insumo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipo_insumo_idtipo_insumo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tipo_insumo_idtipo_insumo'] = &$this->tipo_insumo_idtipo_insumo;

        // insumo_idinsumo
        $this->insumo_idinsumo = new DbField(
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
            'SELECT' // Edit Tag
        );
        $this->insumo_idinsumo->InputTextType = "text";
        $this->insumo_idinsumo->Raw = true;
        $this->insumo_idinsumo->Nullable = false; // NOT NULL field
        $this->insumo_idinsumo->Required = true; // Required field
        $this->insumo_idinsumo->setSelectMultiple(false); // Select one
        $this->insumo_idinsumo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->insumo_idinsumo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->insumo_idinsumo->Lookup = new Lookup($this->insumo_idinsumo, 'insumo', false, 'idinsumo', ["insumo","vr_unitario","",""], '', '', ["x_tipo_insumo_idtipo_insumo"], [], ["tipo_insumo_idtipo_insumo"], ["x_tipo_insumo_idtipo_insumo"], [], [], false, '`insumo` ASC', '', "CONCAT(COALESCE(`insumo`, ''),'" . ValueSeparator(1, $this->insumo_idinsumo) . "',COALESCE(`vr_unitario`,''))");
        $this->insumo_idinsumo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->insumo_idinsumo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['insumo_idinsumo'] = &$this->insumo_idinsumo;

        // qtde
        $this->qtde = new DbField(
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
        $this->Fields['qtde'] = &$this->qtde;

        // frequencia
        $this->frequencia = new DbField(
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
            'RADIO' // Edit Tag
        );
        $this->frequencia->addMethod("getDefault", fn() => 12.0);
        $this->frequencia->InputTextType = "text";
        $this->frequencia->Raw = true;
        $this->frequencia->Nullable = false; // NOT NULL field
        $this->frequencia->Lookup = new Lookup($this->frequencia, 'mov_insumo_cliente', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->frequencia->OptionCount = 6;
        $this->frequencia->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->frequencia->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['frequencia'] = &$this->frequencia;

        // vr_unit
        $this->vr_unit = new DbField(
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
        $this->vr_unit->addMethod("getDefault", fn() => 0);
        $this->vr_unit->InputTextType = "text";
        $this->vr_unit->Raw = true;
        $this->vr_unit->Nullable = false; // NOT NULL field
        $this->vr_unit->Required = true; // Required field
        $this->vr_unit->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vr_unit->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['vr_unit'] = &$this->vr_unit;

        // vr_total
        $this->vr_total = new DbField(
            $this, // Table
            'x_vr_total', // Variable name
            'vr_total', // Name
            'qtde * vr_unit', // Expression
            'qtde * vr_unit', // Basic search expression
            131, // Type
            17, // Size
            -1, // Date/Time format
            false, // Is upload field
            'qtde * vr_unit', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vr_total->InputTextType = "text";
        $this->vr_total->Raw = true;
        $this->vr_total->IsCustom = true; // Custom field
        $this->vr_total->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vr_total->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['vr_total'] = &$this->vr_total;

        // proposta_idproposta
        $this->proposta_idproposta = new DbField(
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
        $this->proposta_idproposta->IsForeignKey = true; // Foreign key field
        $this->proposta_idproposta->Nullable = false; // NOT NULL field
        $this->proposta_idproposta->Required = true; // Required field
        $this->proposta_idproposta->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proposta_idproposta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['proposta_idproposta'] = &$this->proposta_idproposta;

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
        if ($this->getCurrentMasterTable() == "proposta") {
            $masterTable = Container("proposta");
            if ($this->proposta_idproposta->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->idproposta, $this->proposta_idproposta->getSessionValue(), $masterTable->idproposta->DataType, $masterTable->Dbid);
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
        if ($this->getCurrentMasterTable() == "proposta") {
            $masterTable = Container("proposta");
            if ($this->proposta_idproposta->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->proposta_idproposta, $this->proposta_idproposta->getSessionValue(), $masterTable->idproposta->DataType, $this->Dbid);
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
            case "proposta":
                $key = $keys["proposta_idproposta"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->idproposta->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->idproposta, $keys["proposta_idproposta"], $this->proposta_idproposta->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "proposta":
                return GetKeyFilter($this->proposta_idproposta, $masterTable->idproposta->DbValue, $masterTable->idproposta->DataType, $masterTable->Dbid);
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "mov_insumo_cliente";
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
        return "*, qtde * vr_unit AS `vr_total`";
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
            $this->idmov_insumo_cliente->setDbValue($conn->lastInsertId());
            $rs['idmov_insumo_cliente'] = $this->idmov_insumo_cliente->DbValue;
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
            if (!isset($rs['idmov_insumo_cliente']) && !EmptyValue($this->idmov_insumo_cliente->CurrentValue)) {
                $rs['idmov_insumo_cliente'] = $this->idmov_insumo_cliente->CurrentValue;
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
            if (array_key_exists('idmov_insumo_cliente', $rs)) {
                AddFilter($where, QuotedName('idmov_insumo_cliente', $this->Dbid) . '=' . QuotedValue($rs['idmov_insumo_cliente'], $this->idmov_insumo_cliente->DataType, $this->Dbid));
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
        $this->idmov_insumo_cliente->DbValue = $row['idmov_insumo_cliente'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->tipo_insumo_idtipo_insumo->DbValue = $row['tipo_insumo_idtipo_insumo'];
        $this->insumo_idinsumo->DbValue = $row['insumo_idinsumo'];
        $this->qtde->DbValue = $row['qtde'];
        $this->frequencia->DbValue = $row['frequencia'];
        $this->vr_unit->DbValue = $row['vr_unit'];
        $this->vr_total->DbValue = $row['vr_total'];
        $this->proposta_idproposta->DbValue = $row['proposta_idproposta'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
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
        return $_SESSION[$name] ?? GetUrl("MovInsumoClienteList");
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
            "MovInsumoClienteView" => $Language->phrase("View"),
            "MovInsumoClienteEdit" => $Language->phrase("Edit"),
            "MovInsumoClienteAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "MovInsumoClienteList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "MovInsumoClienteView",
            Config("API_ADD_ACTION") => "MovInsumoClienteAdd",
            Config("API_EDIT_ACTION") => "MovInsumoClienteEdit",
            Config("API_DELETE_ACTION") => "MovInsumoClienteDelete",
            Config("API_LIST_ACTION") => "MovInsumoClienteList",
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
        return "MovInsumoClienteList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("MovInsumoClienteView", $parm);
        } else {
            $url = $this->keyUrl("MovInsumoClienteView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "MovInsumoClienteAdd?" . $parm;
        } else {
            $url = "MovInsumoClienteAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("MovInsumoClienteEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("MovInsumoClienteList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("MovInsumoClienteAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("MovInsumoClienteList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("MovInsumoClienteDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "proposta" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_idproposta", $this->proposta_idproposta->getSessionValue()); // Use Session Value
        }
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
        $this->idmov_insumo_cliente->setDbValue($row['idmov_insumo_cliente']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->tipo_insumo_idtipo_insumo->setDbValue($row['tipo_insumo_idtipo_insumo']);
        $this->insumo_idinsumo->setDbValue($row['insumo_idinsumo']);
        $this->qtde->setDbValue($row['qtde']);
        $this->frequencia->setDbValue($row['frequencia']);
        $this->vr_unit->setDbValue($row['vr_unit']);
        $this->vr_total->setDbValue($row['vr_total']);
        $this->proposta_idproposta->setDbValue($row['proposta_idproposta']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "MovInsumoClienteList";
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

        // idmov_insumo_cliente

        // dt_cadastro

        // tipo_insumo_idtipo_insumo

        // insumo_idinsumo

        // qtde

        // frequencia

        // vr_unit

        // vr_total

        // proposta_idproposta

        // idmov_insumo_cliente
        $this->idmov_insumo_cliente->ViewValue = $this->idmov_insumo_cliente->CurrentValue;

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());

        // tipo_insumo_idtipo_insumo
        $curVal = strval($this->tipo_insumo_idtipo_insumo->CurrentValue);
        if ($curVal != "") {
            $this->tipo_insumo_idtipo_insumo->ViewValue = $this->tipo_insumo_idtipo_insumo->lookupCacheOption($curVal);
            if ($this->tipo_insumo_idtipo_insumo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipo_insumo_idtipo_insumo->Lookup->getTable()->Fields["idtipo_insumo"]->searchExpression(), "=", $curVal, $this->tipo_insumo_idtipo_insumo->Lookup->getTable()->Fields["idtipo_insumo"]->searchDataType(), "");
                $sqlWrk = $this->tipo_insumo_idtipo_insumo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_insumo_idtipo_insumo->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_insumo_idtipo_insumo->ViewValue = $this->tipo_insumo_idtipo_insumo->displayValue($arwrk);
                } else {
                    $this->tipo_insumo_idtipo_insumo->ViewValue = FormatNumber($this->tipo_insumo_idtipo_insumo->CurrentValue, $this->tipo_insumo_idtipo_insumo->formatPattern());
                }
            }
        } else {
            $this->tipo_insumo_idtipo_insumo->ViewValue = null;
        }
        $this->tipo_insumo_idtipo_insumo->CssClass = "fw-bold";

        // insumo_idinsumo
        $curVal = strval($this->insumo_idinsumo->CurrentValue);
        if ($curVal != "") {
            $this->insumo_idinsumo->ViewValue = $this->insumo_idinsumo->lookupCacheOption($curVal);
            if ($this->insumo_idinsumo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->insumo_idinsumo->Lookup->getTable()->Fields["idinsumo"]->searchExpression(), "=", $curVal, $this->insumo_idinsumo->Lookup->getTable()->Fields["idinsumo"]->searchDataType(), "");
                $sqlWrk = $this->insumo_idinsumo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->insumo_idinsumo->Lookup->renderViewRow($rswrk[0]);
                    $this->insumo_idinsumo->ViewValue = $this->insumo_idinsumo->displayValue($arwrk);
                } else {
                    $this->insumo_idinsumo->ViewValue = FormatNumber($this->insumo_idinsumo->CurrentValue, $this->insumo_idinsumo->formatPattern());
                }
            }
        } else {
            $this->insumo_idinsumo->ViewValue = null;
        }
        $this->insumo_idinsumo->CssClass = "fw-bold";

        // qtde
        $this->qtde->ViewValue = $this->qtde->CurrentValue;
        $this->qtde->ViewValue = FormatNumber($this->qtde->ViewValue, $this->qtde->formatPattern());
        $this->qtde->CssClass = "fw-bold";
        $this->qtde->CellCssStyle .= "text-align: center;";

        // frequencia
        if (strval($this->frequencia->CurrentValue) != "") {
            $this->frequencia->ViewValue = $this->frequencia->optionCaption($this->frequencia->CurrentValue);
        } else {
            $this->frequencia->ViewValue = null;
        }
        $this->frequencia->CssClass = "fw-bold";
        $this->frequencia->CellCssStyle .= "text-align: center;";

        // vr_unit
        $this->vr_unit->ViewValue = $this->vr_unit->CurrentValue;
        $this->vr_unit->ViewValue = FormatCurrency($this->vr_unit->ViewValue, $this->vr_unit->formatPattern());
        $this->vr_unit->CssClass = "fw-bold";
        $this->vr_unit->CellCssStyle .= "text-align: right;";

        // vr_total
        $this->vr_total->ViewValue = $this->vr_total->CurrentValue;
        $this->vr_total->ViewValue = FormatCurrency($this->vr_total->ViewValue, $this->vr_total->formatPattern());
        $this->vr_total->CssClass = "fw-bold";
        $this->vr_total->CellCssStyle .= "text-align: right;";

        // proposta_idproposta
        $this->proposta_idproposta->ViewValue = $this->proposta_idproposta->CurrentValue;
        $this->proposta_idproposta->ViewValue = FormatNumber($this->proposta_idproposta->ViewValue, $this->proposta_idproposta->formatPattern());

        // idmov_insumo_cliente
        $this->idmov_insumo_cliente->HrefValue = "";
        $this->idmov_insumo_cliente->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // tipo_insumo_idtipo_insumo
        $this->tipo_insumo_idtipo_insumo->HrefValue = "";
        $this->tipo_insumo_idtipo_insumo->TooltipValue = "";

        // insumo_idinsumo
        $this->insumo_idinsumo->HrefValue = "";
        $this->insumo_idinsumo->TooltipValue = "";

        // qtde
        $this->qtde->HrefValue = "";
        $this->qtde->TooltipValue = "";

        // frequencia
        $this->frequencia->HrefValue = "";
        $this->frequencia->TooltipValue = "";

        // vr_unit
        $this->vr_unit->HrefValue = "";
        $this->vr_unit->TooltipValue = "";

        // vr_total
        $this->vr_total->HrefValue = "";
        $this->vr_total->TooltipValue = "";

        // proposta_idproposta
        $this->proposta_idproposta->HrefValue = "";
        $this->proposta_idproposta->TooltipValue = "";

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

        // idmov_insumo_cliente
        $this->idmov_insumo_cliente->setupEditAttributes();
        $this->idmov_insumo_cliente->EditValue = $this->idmov_insumo_cliente->CurrentValue;

        // dt_cadastro

        // tipo_insumo_idtipo_insumo
        $this->tipo_insumo_idtipo_insumo->PlaceHolder = RemoveHtml($this->tipo_insumo_idtipo_insumo->caption());

        // insumo_idinsumo
        $this->insumo_idinsumo->setupEditAttributes();
        $this->insumo_idinsumo->PlaceHolder = RemoveHtml($this->insumo_idinsumo->caption());

        // qtde
        $this->qtde->setupEditAttributes();
        $this->qtde->EditValue = $this->qtde->CurrentValue;
        $this->qtde->PlaceHolder = RemoveHtml($this->qtde->caption());
        if (strval($this->qtde->EditValue) != "" && is_numeric($this->qtde->EditValue)) {
            $this->qtde->EditValue = FormatNumber($this->qtde->EditValue, null);
        }

        // frequencia
        $this->frequencia->EditValue = $this->frequencia->options(false);
        $this->frequencia->PlaceHolder = RemoveHtml($this->frequencia->caption());

        // vr_unit
        $this->vr_unit->setupEditAttributes();
        $this->vr_unit->EditValue = $this->vr_unit->CurrentValue;
        $this->vr_unit->EditValue = FormatCurrency($this->vr_unit->EditValue, $this->vr_unit->formatPattern());
        $this->vr_unit->CssClass = "fw-bold";
        $this->vr_unit->CellCssStyle .= "text-align: right;";

        // vr_total
        $this->vr_total->setupEditAttributes();
        $this->vr_total->EditValue = $this->vr_total->CurrentValue;
        $this->vr_total->EditValue = FormatCurrency($this->vr_total->EditValue, $this->vr_total->formatPattern());
        $this->vr_total->CssClass = "fw-bold";
        $this->vr_total->CellCssStyle .= "text-align: right;";

        // proposta_idproposta
        $this->proposta_idproposta->setupEditAttributes();
        if ($this->proposta_idproposta->getSessionValue() != "") {
            $this->proposta_idproposta->CurrentValue = GetForeignKeyValue($this->proposta_idproposta->getSessionValue());
            $this->proposta_idproposta->ViewValue = $this->proposta_idproposta->CurrentValue;
            $this->proposta_idproposta->ViewValue = FormatNumber($this->proposta_idproposta->ViewValue, $this->proposta_idproposta->formatPattern());
        } else {
            $this->proposta_idproposta->EditValue = $this->proposta_idproposta->CurrentValue;
            $this->proposta_idproposta->PlaceHolder = RemoveHtml($this->proposta_idproposta->caption());
            if (strval($this->proposta_idproposta->EditValue) != "" && is_numeric($this->proposta_idproposta->EditValue)) {
                $this->proposta_idproposta->EditValue = FormatNumber($this->proposta_idproposta->EditValue, null);
            }
        }

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            if (is_numeric($this->vr_total->CurrentValue)) {
                $this->vr_total->Total += $this->vr_total->CurrentValue; // Accumulate total
            }
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->vr_total->CurrentValue = $this->vr_total->Total;
            $this->vr_total->ViewValue = $this->vr_total->CurrentValue;
            $this->vr_total->ViewValue = FormatCurrency($this->vr_total->ViewValue, $this->vr_total->formatPattern());
            $this->vr_total->CssClass = "fw-bold";
            $this->vr_total->CellCssStyle .= "text-align: right;";
            $this->vr_total->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->idmov_insumo_cliente);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->tipo_insumo_idtipo_insumo);
                    $doc->exportCaption($this->insumo_idinsumo);
                    $doc->exportCaption($this->qtde);
                    $doc->exportCaption($this->frequencia);
                    $doc->exportCaption($this->vr_unit);
                    $doc->exportCaption($this->vr_total);
                    $doc->exportCaption($this->proposta_idproposta);
                } else {
                    $doc->exportCaption($this->idmov_insumo_cliente);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->tipo_insumo_idtipo_insumo);
                    $doc->exportCaption($this->insumo_idinsumo);
                    $doc->exportCaption($this->qtde);
                    $doc->exportCaption($this->frequencia);
                    $doc->exportCaption($this->vr_unit);
                    $doc->exportCaption($this->vr_total);
                    $doc->exportCaption($this->proposta_idproposta);
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
                        $doc->exportField($this->idmov_insumo_cliente);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->tipo_insumo_idtipo_insumo);
                        $doc->exportField($this->insumo_idinsumo);
                        $doc->exportField($this->qtde);
                        $doc->exportField($this->frequencia);
                        $doc->exportField($this->vr_unit);
                        $doc->exportField($this->vr_total);
                        $doc->exportField($this->proposta_idproposta);
                    } else {
                        $doc->exportField($this->idmov_insumo_cliente);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->tipo_insumo_idtipo_insumo);
                        $doc->exportField($this->insumo_idinsumo);
                        $doc->exportField($this->qtde);
                        $doc->exportField($this->frequencia);
                        $doc->exportField($this->vr_unit);
                        $doc->exportField($this->vr_total);
                        $doc->exportField($this->proposta_idproposta);
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
                $doc->exportAggregate($this->idmov_insumo_cliente, '');
                $doc->exportAggregate($this->dt_cadastro, '');
                $doc->exportAggregate($this->tipo_insumo_idtipo_insumo, '');
                $doc->exportAggregate($this->insumo_idinsumo, '');
                $doc->exportAggregate($this->qtde, '');
                $doc->exportAggregate($this->frequencia, '');
                $doc->exportAggregate($this->vr_unit, '');
                $doc->exportAggregate($this->vr_total, 'TOTAL');
                $doc->exportAggregate($this->proposta_idproposta, '');
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
        $idinsumo = $rsnew[('insumo_idinsumo')];
        $rsnew[('vr_unit')] = ExecuteScalar("SELECT vr_unitario from insumo WHERE idinsumo = $idinsumo");
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
        $idinsumo = $rsnew[('insumo_idinsumo')];
        $rsnew[('vr_unit')] = ExecuteScalar("SELECT vr_unitario from insumo WHERE idinsumo = $idinsumo");
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
