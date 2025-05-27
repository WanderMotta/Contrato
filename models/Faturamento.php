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
 * Table class for faturamento
 */
class Faturamento extends DbTable
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
    public $idfaturamento;
    public $faturamento;
    public $cnpj;
    public $endereco;
    public $bairro;
    public $cidade;
    public $uf;
    public $dia_vencimento;
    public $origem;
    public $obs;
    public $cliente_idcliente;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "faturamento";
        $this->TableName = 'faturamento';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "faturamento";
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

        // idfaturamento
        $this->idfaturamento = new DbField(
            $this, // Table
            'x_idfaturamento', // Variable name
            'idfaturamento', // Name
            '`idfaturamento`', // Expression
            '`idfaturamento`', // Basic search expression
            19, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idfaturamento`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idfaturamento->InputTextType = "text";
        $this->idfaturamento->Raw = true;
        $this->idfaturamento->IsAutoIncrement = true; // Autoincrement field
        $this->idfaturamento->IsPrimaryKey = true; // Primary key field
        $this->idfaturamento->IsForeignKey = true; // Foreign key field
        $this->idfaturamento->Nullable = false; // NOT NULL field
        $this->idfaturamento->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idfaturamento->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idfaturamento'] = &$this->idfaturamento;

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
        $this->faturamento->Nullable = false; // NOT NULL field
        $this->faturamento->Required = true; // Required field
        $this->faturamento->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['faturamento'] = &$this->faturamento;

        // cnpj
        $this->cnpj = new DbField(
            $this, // Table
            'x_cnpj', // Variable name
            'cnpj', // Name
            '`cnpj`', // Expression
            '`cnpj`', // Basic search expression
            200, // Type
            18, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cnpj`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cnpj->InputTextType = "text";
        $this->cnpj->Nullable = false; // NOT NULL field
        $this->cnpj->Required = true; // Required field
        $this->cnpj->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['cnpj'] = &$this->cnpj;

        // endereco
        $this->endereco = new DbField(
            $this, // Table
            'x_endereco', // Variable name
            'endereco', // Name
            '`endereco`', // Expression
            '`endereco`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`endereco`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->endereco->InputTextType = "text";
        $this->endereco->Nullable = false; // NOT NULL field
        $this->endereco->Required = true; // Required field
        $this->endereco->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['endereco'] = &$this->endereco;

        // bairro
        $this->bairro = new DbField(
            $this, // Table
            'x_bairro', // Variable name
            'bairro', // Name
            '`bairro`', // Expression
            '`bairro`', // Basic search expression
            200, // Type
            45, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`bairro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->bairro->InputTextType = "text";
        $this->bairro->Nullable = false; // NOT NULL field
        $this->bairro->Required = true; // Required field
        $this->bairro->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['bairro'] = &$this->bairro;

        // cidade
        $this->cidade = new DbField(
            $this, // Table
            'x_cidade', // Variable name
            'cidade', // Name
            '`cidade`', // Expression
            '`cidade`', // Basic search expression
            200, // Type
            45, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cidade->addMethod("getDefault", fn() => "São Paulo");
        $this->cidade->InputTextType = "text";
        $this->cidade->Nullable = false; // NOT NULL field
        $this->cidade->Required = true; // Required field
        $this->cidade->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['cidade'] = &$this->cidade;

        // uf
        $this->uf = new DbField(
            $this, // Table
            'x_uf', // Variable name
            'uf', // Name
            '`uf`', // Expression
            '`uf`', // Basic search expression
            200, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`uf`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->uf->addMethod("getDefault", fn() => "SP");
        $this->uf->InputTextType = "text";
        $this->uf->Nullable = false; // NOT NULL field
        $this->uf->Required = true; // Required field
        $this->uf->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['uf'] = &$this->uf;

        // dia_vencimento
        $this->dia_vencimento = new DbField(
            $this, // Table
            'x_dia_vencimento', // Variable name
            'dia_vencimento', // Name
            '`dia_vencimento`', // Expression
            '`dia_vencimento`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`dia_vencimento`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dia_vencimento->addMethod("getDefault", fn() => 10);
        $this->dia_vencimento->InputTextType = "text";
        $this->dia_vencimento->Raw = true;
        $this->dia_vencimento->Nullable = false; // NOT NULL field
        $this->dia_vencimento->DefaultErrorMessage = str_replace(["%1", "%2"], ["1", "30"], $Language->phrase("IncorrectRange"));
        $this->dia_vencimento->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dia_vencimento'] = &$this->dia_vencimento;

        // origem
        $this->origem = new DbField(
            $this, // Table
            'x_origem', // Variable name
            'origem', // Name
            '`origem`', // Expression
            '`origem`', // Basic search expression
            200, // Type
            14, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`origem`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->origem->addMethod("getDefault", fn() => "Condominio");
        $this->origem->InputTextType = "text";
        $this->origem->Raw = true;
        $this->origem->Nullable = false; // NOT NULL field
        $this->origem->Required = true; // Required field
        $this->origem->Lookup = new Lookup($this->origem, 'faturamento', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->origem->OptionCount = 2;
        $this->origem->SearchOperators = ["=", "<>"];
        $this->Fields['origem'] = &$this->origem;

        // obs
        $this->obs = new DbField(
            $this, // Table
            'x_obs', // Variable name
            'obs', // Name
            '`obs`', // Expression
            '`obs`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`obs`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->obs->InputTextType = "text";
        $this->obs->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['obs'] = &$this->obs;

        // cliente_idcliente
        $this->cliente_idcliente = new DbField(
            $this, // Table
            'x_cliente_idcliente', // Variable name
            'cliente_idcliente', // Name
            '`cliente_idcliente`', // Expression
            '`cliente_idcliente`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cliente_idcliente`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cliente_idcliente->InputTextType = "text";
        $this->cliente_idcliente->Raw = true;
        $this->cliente_idcliente->IsForeignKey = true; // Foreign key field
        $this->cliente_idcliente->Nullable = false; // NOT NULL field
        $this->cliente_idcliente->Required = true; // Required field
        $this->cliente_idcliente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cliente_idcliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['cliente_idcliente'] = &$this->cliente_idcliente;

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
        if ($this->getCurrentMasterTable() == "cliente") {
            $masterTable = Container("cliente");
            if ($this->cliente_idcliente->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->idcliente, $this->cliente_idcliente->getSessionValue(), $masterTable->idcliente->DataType, $masterTable->Dbid);
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
        if ($this->getCurrentMasterTable() == "cliente") {
            $masterTable = Container("cliente");
            if ($this->cliente_idcliente->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->cliente_idcliente, $this->cliente_idcliente->getSessionValue(), $masterTable->idcliente->DataType, $this->Dbid);
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
            case "cliente":
                $key = $keys["cliente_idcliente"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->idcliente->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->idcliente, $keys["cliente_idcliente"], $this->cliente_idcliente->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "cliente":
                return GetKeyFilter($this->cliente_idcliente, $masterTable->idcliente->DbValue, $masterTable->idcliente->DataType, $masterTable->Dbid);
        }
        return "";
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")) ?? "";
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "contato") {
            $detailUrl = Container("contato")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idfaturamento", $this->idfaturamento->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "FaturamentoList";
        }
        return $detailUrl;
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "faturamento";
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
            $this->idfaturamento->setDbValue($conn->lastInsertId());
            $rs['idfaturamento'] = $this->idfaturamento->DbValue;
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
        // Cascade Update detail table 'contato'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['idfaturamento']) && $rsold['idfaturamento'] != $rs['idfaturamento'])) { // Update detail field 'faturamento_idfaturamento'
            $cascadeUpdate = true;
            $rscascade['faturamento_idfaturamento'] = $rs['idfaturamento'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("contato")->loadRs("`faturamento_idfaturamento` = " . QuotedValue($rsold['idfaturamento'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'idcontato';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("contato")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("contato")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("contato")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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
            if (!isset($rs['idfaturamento']) && !EmptyValue($this->idfaturamento->CurrentValue)) {
                $rs['idfaturamento'] = $this->idfaturamento->CurrentValue;
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
            if (array_key_exists('idfaturamento', $rs)) {
                AddFilter($where, QuotedName('idfaturamento', $this->Dbid) . '=' . QuotedValue($rs['idfaturamento'], $this->idfaturamento->DataType, $this->Dbid));
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

        // Cascade delete detail table 'contato'
        $dtlrows = Container("contato")->loadRs("`faturamento_idfaturamento` = " . QuotedValue($rs['idfaturamento'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("contato")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("contato")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("contato")->rowDeleted($dtlrow);
            }
        }
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
        $this->idfaturamento->DbValue = $row['idfaturamento'];
        $this->faturamento->DbValue = $row['faturamento'];
        $this->cnpj->DbValue = $row['cnpj'];
        $this->endereco->DbValue = $row['endereco'];
        $this->bairro->DbValue = $row['bairro'];
        $this->cidade->DbValue = $row['cidade'];
        $this->uf->DbValue = $row['uf'];
        $this->dia_vencimento->DbValue = $row['dia_vencimento'];
        $this->origem->DbValue = $row['origem'];
        $this->obs->DbValue = $row['obs'];
        $this->cliente_idcliente->DbValue = $row['cliente_idcliente'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idfaturamento` = @idfaturamento@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idfaturamento->CurrentValue : $this->idfaturamento->OldValue;
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
                $this->idfaturamento->CurrentValue = $keys[0];
            } else {
                $this->idfaturamento->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idfaturamento', $row) ? $row['idfaturamento'] : null;
        } else {
            $val = !EmptyValue($this->idfaturamento->OldValue) && !$current ? $this->idfaturamento->OldValue : $this->idfaturamento->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idfaturamento@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("FaturamentoList");
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
            "FaturamentoView" => $Language->phrase("View"),
            "FaturamentoEdit" => $Language->phrase("Edit"),
            "FaturamentoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "FaturamentoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "FaturamentoView",
            Config("API_ADD_ACTION") => "FaturamentoAdd",
            Config("API_EDIT_ACTION") => "FaturamentoEdit",
            Config("API_DELETE_ACTION") => "FaturamentoDelete",
            Config("API_LIST_ACTION") => "FaturamentoList",
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
        return "FaturamentoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FaturamentoView", $parm);
        } else {
            $url = $this->keyUrl("FaturamentoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "FaturamentoAdd?" . $parm;
        } else {
            $url = "FaturamentoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FaturamentoEdit", $parm);
        } else {
            $url = $this->keyUrl("FaturamentoEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("FaturamentoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FaturamentoAdd", $parm);
        } else {
            $url = $this->keyUrl("FaturamentoAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("FaturamentoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("FaturamentoDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "cliente" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_idcliente", $this->cliente_idcliente->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"idfaturamento\":" . VarToJson($this->idfaturamento->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idfaturamento->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idfaturamento->CurrentValue);
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
            if (($keyValue = Param("idfaturamento") ?? Route("idfaturamento")) !== null) {
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
                $this->idfaturamento->CurrentValue = $key;
            } else {
                $this->idfaturamento->OldValue = $key;
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
        $this->idfaturamento->setDbValue($row['idfaturamento']);
        $this->faturamento->setDbValue($row['faturamento']);
        $this->cnpj->setDbValue($row['cnpj']);
        $this->endereco->setDbValue($row['endereco']);
        $this->bairro->setDbValue($row['bairro']);
        $this->cidade->setDbValue($row['cidade']);
        $this->uf->setDbValue($row['uf']);
        $this->dia_vencimento->setDbValue($row['dia_vencimento']);
        $this->origem->setDbValue($row['origem']);
        $this->obs->setDbValue($row['obs']);
        $this->cliente_idcliente->setDbValue($row['cliente_idcliente']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "FaturamentoList";
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

        // idfaturamento

        // faturamento

        // cnpj

        // endereco

        // bairro

        // cidade

        // uf

        // dia_vencimento

        // origem

        // obs

        // cliente_idcliente

        // idfaturamento
        $this->idfaturamento->ViewValue = $this->idfaturamento->CurrentValue;

        // faturamento
        $this->faturamento->ViewValue = $this->faturamento->CurrentValue;
        $this->faturamento->CssClass = "fw-bold";

        // cnpj
        $this->cnpj->ViewValue = $this->cnpj->CurrentValue;
        $this->cnpj->CssClass = "fw-bold";

        // endereco
        $this->endereco->ViewValue = $this->endereco->CurrentValue;
        $this->endereco->CssClass = "fw-bold";

        // bairro
        $this->bairro->ViewValue = $this->bairro->CurrentValue;
        $this->bairro->CssClass = "fw-bold";

        // cidade
        $this->cidade->ViewValue = $this->cidade->CurrentValue;
        $this->cidade->CssClass = "fw-bold";

        // uf
        $this->uf->ViewValue = $this->uf->CurrentValue;
        $this->uf->CssClass = "fw-bold";

        // dia_vencimento
        $this->dia_vencimento->ViewValue = $this->dia_vencimento->CurrentValue;
        $this->dia_vencimento->ViewValue = FormatNumber($this->dia_vencimento->ViewValue, $this->dia_vencimento->formatPattern());
        $this->dia_vencimento->CssClass = "fw-bold";
        $this->dia_vencimento->CellCssStyle .= "text-align: center;";

        // origem
        if (strval($this->origem->CurrentValue) != "") {
            $this->origem->ViewValue = $this->origem->optionCaption($this->origem->CurrentValue);
        } else {
            $this->origem->ViewValue = null;
        }
        $this->origem->CssClass = "fw-bold";

        // obs
        $this->obs->ViewValue = $this->obs->CurrentValue;
        $this->obs->CssClass = "fw-bold";

        // cliente_idcliente
        $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->CurrentValue;
        $this->cliente_idcliente->ViewValue = FormatNumber($this->cliente_idcliente->ViewValue, $this->cliente_idcliente->formatPattern());
        $this->cliente_idcliente->CssClass = "fw-bold";
        $this->cliente_idcliente->CellCssStyle .= "text-align: center;";

        // idfaturamento
        $this->idfaturamento->HrefValue = "";
        $this->idfaturamento->TooltipValue = "";

        // faturamento
        $this->faturamento->HrefValue = "";
        $this->faturamento->TooltipValue = "";

        // cnpj
        $this->cnpj->HrefValue = "";
        $this->cnpj->TooltipValue = "";

        // endereco
        $this->endereco->HrefValue = "";
        $this->endereco->TooltipValue = "";

        // bairro
        $this->bairro->HrefValue = "";
        $this->bairro->TooltipValue = "";

        // cidade
        $this->cidade->HrefValue = "";
        $this->cidade->TooltipValue = "";

        // uf
        $this->uf->HrefValue = "";
        $this->uf->TooltipValue = "";

        // dia_vencimento
        $this->dia_vencimento->HrefValue = "";
        $this->dia_vencimento->TooltipValue = "";

        // origem
        $this->origem->HrefValue = "";
        $this->origem->TooltipValue = "";

        // obs
        $this->obs->HrefValue = "";
        $this->obs->TooltipValue = "";

        // cliente_idcliente
        $this->cliente_idcliente->HrefValue = "";
        $this->cliente_idcliente->TooltipValue = "";

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

        // idfaturamento
        $this->idfaturamento->setupEditAttributes();
        $this->idfaturamento->EditValue = $this->idfaturamento->CurrentValue;

        // faturamento
        $this->faturamento->setupEditAttributes();
        if (!$this->faturamento->Raw) {
            $this->faturamento->CurrentValue = HtmlDecode($this->faturamento->CurrentValue);
        }
        $this->faturamento->EditValue = $this->faturamento->CurrentValue;
        $this->faturamento->PlaceHolder = RemoveHtml($this->faturamento->caption());

        // cnpj
        $this->cnpj->setupEditAttributes();
        if (!$this->cnpj->Raw) {
            $this->cnpj->CurrentValue = HtmlDecode($this->cnpj->CurrentValue);
        }
        $this->cnpj->EditValue = $this->cnpj->CurrentValue;
        $this->cnpj->PlaceHolder = RemoveHtml($this->cnpj->caption());

        // endereco
        $this->endereco->setupEditAttributes();
        if (!$this->endereco->Raw) {
            $this->endereco->CurrentValue = HtmlDecode($this->endereco->CurrentValue);
        }
        $this->endereco->EditValue = $this->endereco->CurrentValue;
        $this->endereco->PlaceHolder = RemoveHtml($this->endereco->caption());

        // bairro
        $this->bairro->setupEditAttributes();
        if (!$this->bairro->Raw) {
            $this->bairro->CurrentValue = HtmlDecode($this->bairro->CurrentValue);
        }
        $this->bairro->EditValue = $this->bairro->CurrentValue;
        $this->bairro->PlaceHolder = RemoveHtml($this->bairro->caption());

        // cidade
        $this->cidade->setupEditAttributes();
        if (!$this->cidade->Raw) {
            $this->cidade->CurrentValue = HtmlDecode($this->cidade->CurrentValue);
        }
        $this->cidade->EditValue = $this->cidade->CurrentValue;
        $this->cidade->PlaceHolder = RemoveHtml($this->cidade->caption());

        // uf
        $this->uf->setupEditAttributes();
        if (!$this->uf->Raw) {
            $this->uf->CurrentValue = HtmlDecode($this->uf->CurrentValue);
        }
        $this->uf->EditValue = $this->uf->CurrentValue;
        $this->uf->PlaceHolder = RemoveHtml($this->uf->caption());

        // dia_vencimento
        $this->dia_vencimento->setupEditAttributes();
        $this->dia_vencimento->EditValue = $this->dia_vencimento->CurrentValue;
        $this->dia_vencimento->PlaceHolder = RemoveHtml($this->dia_vencimento->caption());
        if (strval($this->dia_vencimento->EditValue) != "" && is_numeric($this->dia_vencimento->EditValue)) {
            $this->dia_vencimento->EditValue = FormatNumber($this->dia_vencimento->EditValue, null);
        }

        // origem
        $this->origem->EditValue = $this->origem->options(false);
        $this->origem->PlaceHolder = RemoveHtml($this->origem->caption());

        // obs
        $this->obs->setupEditAttributes();
        $this->obs->EditValue = $this->obs->CurrentValue;
        $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

        // cliente_idcliente
        $this->cliente_idcliente->setupEditAttributes();
        if ($this->cliente_idcliente->getSessionValue() != "") {
            $this->cliente_idcliente->CurrentValue = GetForeignKeyValue($this->cliente_idcliente->getSessionValue());
            $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->CurrentValue;
            $this->cliente_idcliente->ViewValue = FormatNumber($this->cliente_idcliente->ViewValue, $this->cliente_idcliente->formatPattern());
            $this->cliente_idcliente->CssClass = "fw-bold";
            $this->cliente_idcliente->CellCssStyle .= "text-align: center;";
        } else {
            $this->cliente_idcliente->EditValue = $this->cliente_idcliente->CurrentValue;
            $this->cliente_idcliente->PlaceHolder = RemoveHtml($this->cliente_idcliente->caption());
            if (strval($this->cliente_idcliente->EditValue) != "" && is_numeric($this->cliente_idcliente->EditValue)) {
                $this->cliente_idcliente->EditValue = FormatNumber($this->cliente_idcliente->EditValue, null);
            }
        }

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
                    $doc->exportCaption($this->idfaturamento);
                    $doc->exportCaption($this->faturamento);
                    $doc->exportCaption($this->cnpj);
                    $doc->exportCaption($this->endereco);
                    $doc->exportCaption($this->bairro);
                    $doc->exportCaption($this->cidade);
                    $doc->exportCaption($this->uf);
                    $doc->exportCaption($this->dia_vencimento);
                    $doc->exportCaption($this->origem);
                    $doc->exportCaption($this->obs);
                    $doc->exportCaption($this->cliente_idcliente);
                } else {
                    $doc->exportCaption($this->idfaturamento);
                    $doc->exportCaption($this->faturamento);
                    $doc->exportCaption($this->cnpj);
                    $doc->exportCaption($this->endereco);
                    $doc->exportCaption($this->bairro);
                    $doc->exportCaption($this->cidade);
                    $doc->exportCaption($this->uf);
                    $doc->exportCaption($this->dia_vencimento);
                    $doc->exportCaption($this->origem);
                    $doc->exportCaption($this->obs);
                    $doc->exportCaption($this->cliente_idcliente);
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
                        $doc->exportField($this->idfaturamento);
                        $doc->exportField($this->faturamento);
                        $doc->exportField($this->cnpj);
                        $doc->exportField($this->endereco);
                        $doc->exportField($this->bairro);
                        $doc->exportField($this->cidade);
                        $doc->exportField($this->uf);
                        $doc->exportField($this->dia_vencimento);
                        $doc->exportField($this->origem);
                        $doc->exportField($this->obs);
                        $doc->exportField($this->cliente_idcliente);
                    } else {
                        $doc->exportField($this->idfaturamento);
                        $doc->exportField($this->faturamento);
                        $doc->exportField($this->cnpj);
                        $doc->exportField($this->endereco);
                        $doc->exportField($this->bairro);
                        $doc->exportField($this->cidade);
                        $doc->exportField($this->uf);
                        $doc->exportField($this->dia_vencimento);
                        $doc->exportField($this->origem);
                        $doc->exportField($this->obs);
                        $doc->exportField($this->cliente_idcliente);
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
