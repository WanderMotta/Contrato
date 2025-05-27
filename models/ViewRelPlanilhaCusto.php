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
 * Table class for view_rel_planilha_custo
 */
class ViewRelPlanilhaCusto extends DbTable
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
    public $idproposta;
    public $dt_cadastro;
    public $cliente;
    public $modulo;
    public $item;
    public $porcentagem;
    public $valor;
    public $obs;
    public $posicao;
    public $idplanilha_custo;
    public $cargo;
    public $sub_modulos;
    public $idcliente;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "view_rel_planilha_custo";
        $this->TableName = 'view_rel_planilha_custo';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_rel_planilha_custo";
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

        // idproposta
        $this->idproposta = new DbField(
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
            'NO' // Edit Tag
        );
        $this->idproposta->InputTextType = "text";
        $this->idproposta->Raw = true;
        $this->idproposta->IsAutoIncrement = true; // Autoincrement field
        $this->idproposta->IsPrimaryKey = true; // Primary key field
        $this->idproposta->Nullable = false; // NOT NULL field
        $this->idproposta->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idproposta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idproposta'] = &$this->idproposta;

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
        $this->dt_cadastro->InputTextType = "text";
        $this->dt_cadastro->Raw = true;
        $this->dt_cadastro->Nullable = false; // NOT NULL field
        $this->dt_cadastro->Required = true; // Required field
        $this->dt_cadastro->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_cadastro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dt_cadastro'] = &$this->dt_cadastro;

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
        $this->cliente->Nullable = false; // NOT NULL field
        $this->cliente->Required = true; // Required field
        $this->cliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['cliente'] = &$this->cliente;

        // modulo
        $this->modulo = new DbField(
            $this, // Table
            'x_modulo', // Variable name
            'modulo', // Name
            '`modulo`', // Expression
            '`modulo`', // Basic search expression
            200, // Type
            200, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`modulo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->modulo->InputTextType = "text";
        $this->modulo->Nullable = false; // NOT NULL field
        $this->modulo->Required = true; // Required field
        $this->modulo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['modulo'] = &$this->modulo;

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

        // porcentagem
        $this->porcentagem = new DbField(
            $this, // Table
            'x_porcentagem', // Variable name
            'porcentagem', // Name
            '`porcentagem`', // Expression
            '`porcentagem`', // Basic search expression
            131, // Type
            7, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`porcentagem`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->porcentagem->InputTextType = "text";
        $this->porcentagem->Raw = true;
        $this->porcentagem->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->porcentagem->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['porcentagem'] = &$this->porcentagem;

        // valor
        $this->valor = new DbField(
            $this, // Table
            'x_valor', // Variable name
            'valor', // Name
            '`valor`', // Expression
            '`valor`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`valor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->valor->addMethod("getDefault", fn() => 0.00);
        $this->valor->InputTextType = "text";
        $this->valor->Raw = true;
        $this->valor->Nullable = false; // NOT NULL field
        $this->valor->Required = true; // Required field
        $this->valor->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->valor->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['valor'] = &$this->valor;

        // obs
        $this->obs = new DbField(
            $this, // Table
            'x_obs', // Variable name
            'obs', // Name
            '`obs`', // Expression
            '`obs`', // Basic search expression
            200, // Type
            155, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`obs`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->obs->InputTextType = "text";
        $this->obs->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['obs'] = &$this->obs;

        // posicao
        $this->posicao = new DbField(
            $this, // Table
            'x_posicao', // Variable name
            'posicao', // Name
            '`posicao`', // Expression
            '`posicao`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`posicao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->posicao->InputTextType = "text";
        $this->posicao->Raw = true;
        $this->posicao->Nullable = false; // NOT NULL field
        $this->posicao->Required = true; // Required field
        $this->posicao->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->posicao->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['posicao'] = &$this->posicao;

        // idplanilha_custo
        $this->idplanilha_custo = new DbField(
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
            'RADIO' // Edit Tag
        );
        $this->idplanilha_custo->InputTextType = "text";
        $this->idplanilha_custo->Raw = true;
        $this->idplanilha_custo->IsAutoIncrement = true; // Autoincrement field
        $this->idplanilha_custo->Nullable = false; // NOT NULL field
        $this->idplanilha_custo->Lookup = new Lookup($this->idplanilha_custo, 'view_rel_planilha_custo', true, 'idplanilha_custo', ["idplanilha_custo","","",""], '', '', [], [], [], [], [], [], false, '`idplanilha_custo` ASC', '', "`idplanilha_custo`");
        $this->idplanilha_custo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idplanilha_custo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idplanilha_custo'] = &$this->idplanilha_custo;

        // cargo
        $this->cargo = new DbField(
            $this, // Table
            'x_cargo', // Variable name
            'cargo', // Name
            '`cargo`', // Expression
            '`cargo`', // Basic search expression
            200, // Type
            25, // Size
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
        $this->cargo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['cargo'] = &$this->cargo;

        // sub_modulos
        $this->sub_modulos = new DbField(
            $this, // Table
            'x_sub_modulos', // Variable name
            'sub_modulos', // Name
            '`sub_modulos`', // Expression
            '`sub_modulos`', // Basic search expression
            19, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`sub_modulos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->sub_modulos->InputTextType = "text";
        $this->sub_modulos->Raw = true;
        $this->sub_modulos->Nullable = false; // NOT NULL field
        $this->sub_modulos->Required = true; // Required field
        $this->sub_modulos->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sub_modulos->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['sub_modulos'] = &$this->sub_modulos;

        // idcliente
        $this->idcliente = new DbField(
            $this, // Table
            'x_idcliente', // Variable name
            'idcliente', // Name
            '`idcliente`', // Expression
            '`idcliente`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idcliente`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->idcliente->InputTextType = "text";
        $this->idcliente->Raw = true;
        $this->idcliente->Nullable = false; // NOT NULL field
        $this->idcliente->Required = true; // Required field
        $this->idcliente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idcliente'] = &$this->idcliente;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_rel_planilha_custo";
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
            $this->idproposta->setDbValue($conn->lastInsertId());
            $rs['idproposta'] = $this->idproposta->DbValue;
            $this->idplanilha_custo->setDbValue($conn->lastInsertId());
            $rs['idplanilha_custo'] = $this->idplanilha_custo->DbValue;
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
            if (!isset($rs['idproposta']) && !EmptyValue($this->idproposta->CurrentValue)) {
                $rs['idproposta'] = $this->idproposta->CurrentValue;
            }
        }

        // Return auto increment field
        if ($success) {
            if (!isset($rs['idplanilha_custo']) && !EmptyValue($this->idplanilha_custo->CurrentValue)) {
                $rs['idplanilha_custo'] = $this->idplanilha_custo->CurrentValue;
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
            if (array_key_exists('idproposta', $rs)) {
                AddFilter($where, QuotedName('idproposta', $this->Dbid) . '=' . QuotedValue($rs['idproposta'], $this->idproposta->DataType, $this->Dbid));
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
        $this->idproposta->DbValue = $row['idproposta'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->cliente->DbValue = $row['cliente'];
        $this->modulo->DbValue = $row['modulo'];
        $this->item->DbValue = $row['item'];
        $this->porcentagem->DbValue = $row['porcentagem'];
        $this->valor->DbValue = $row['valor'];
        $this->obs->DbValue = $row['obs'];
        $this->posicao->DbValue = $row['posicao'];
        $this->idplanilha_custo->DbValue = $row['idplanilha_custo'];
        $this->cargo->DbValue = $row['cargo'];
        $this->sub_modulos->DbValue = $row['sub_modulos'];
        $this->idcliente->DbValue = $row['idcliente'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
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
        return $_SESSION[$name] ?? GetUrl("ViewRelPlanilhaCustoList");
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
            "ViewRelPlanilhaCustoView" => $Language->phrase("View"),
            "ViewRelPlanilhaCustoEdit" => $Language->phrase("Edit"),
            "ViewRelPlanilhaCustoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewRelPlanilhaCustoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewRelPlanilhaCustoView",
            Config("API_ADD_ACTION") => "ViewRelPlanilhaCustoAdd",
            Config("API_EDIT_ACTION") => "ViewRelPlanilhaCustoEdit",
            Config("API_DELETE_ACTION") => "ViewRelPlanilhaCustoDelete",
            Config("API_LIST_ACTION") => "ViewRelPlanilhaCustoList",
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
        return "ViewRelPlanilhaCustoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewRelPlanilhaCustoView", $parm);
        } else {
            $url = $this->keyUrl("ViewRelPlanilhaCustoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewRelPlanilhaCustoAdd?" . $parm;
        } else {
            $url = "ViewRelPlanilhaCustoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewRelPlanilhaCustoEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewRelPlanilhaCustoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewRelPlanilhaCustoAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewRelPlanilhaCustoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewRelPlanilhaCustoDelete", $parm);
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
        $this->idproposta->setDbValue($row['idproposta']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->cliente->setDbValue($row['cliente']);
        $this->modulo->setDbValue($row['modulo']);
        $this->item->setDbValue($row['item']);
        $this->porcentagem->setDbValue($row['porcentagem']);
        $this->valor->setDbValue($row['valor']);
        $this->obs->setDbValue($row['obs']);
        $this->posicao->setDbValue($row['posicao']);
        $this->idplanilha_custo->setDbValue($row['idplanilha_custo']);
        $this->cargo->setDbValue($row['cargo']);
        $this->sub_modulos->setDbValue($row['sub_modulos']);
        $this->idcliente->setDbValue($row['idcliente']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewRelPlanilhaCustoList";
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

        // idproposta

        // dt_cadastro

        // cliente

        // modulo

        // item

        // porcentagem

        // valor

        // obs

        // posicao

        // idplanilha_custo

        // cargo

        // sub_modulos

        // idcliente

        // idproposta
        $this->idproposta->ViewValue = $this->idproposta->CurrentValue;

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());

        // cliente
        $this->cliente->ViewValue = $this->cliente->CurrentValue;

        // modulo
        $this->modulo->ViewValue = $this->modulo->CurrentValue;

        // item
        $this->item->ViewValue = $this->item->CurrentValue;

        // porcentagem
        $this->porcentagem->ViewValue = $this->porcentagem->CurrentValue;
        $this->porcentagem->ViewValue = FormatNumber($this->porcentagem->ViewValue, $this->porcentagem->formatPattern());

        // valor
        $this->valor->ViewValue = $this->valor->CurrentValue;
        $this->valor->ViewValue = FormatNumber($this->valor->ViewValue, $this->valor->formatPattern());

        // obs
        $this->obs->ViewValue = $this->obs->CurrentValue;

        // posicao
        $this->posicao->ViewValue = $this->posicao->CurrentValue;
        $this->posicao->ViewValue = FormatNumber($this->posicao->ViewValue, $this->posicao->formatPattern());

        // idplanilha_custo
        $this->idplanilha_custo->ViewValue = $this->idplanilha_custo->CurrentValue;
        $this->idplanilha_custo->CssClass = "fw-bold";
        $this->idplanilha_custo->CellCssStyle .= "text-align: center;";

        // cargo
        $this->cargo->ViewValue = $this->cargo->CurrentValue;

        // sub_modulos
        $this->sub_modulos->ViewValue = $this->sub_modulos->CurrentValue;
        $this->sub_modulos->ViewValue = FormatNumber($this->sub_modulos->ViewValue, $this->sub_modulos->formatPattern());

        // idcliente
        $this->idcliente->ViewValue = $this->idcliente->CurrentValue;
        $this->idcliente->ViewValue = FormatNumber($this->idcliente->ViewValue, $this->idcliente->formatPattern());

        // idproposta
        $this->idproposta->HrefValue = "";
        $this->idproposta->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // cliente
        $this->cliente->HrefValue = "";
        $this->cliente->TooltipValue = "";

        // modulo
        $this->modulo->HrefValue = "";
        $this->modulo->TooltipValue = "";

        // item
        $this->item->HrefValue = "";
        $this->item->TooltipValue = "";

        // porcentagem
        $this->porcentagem->HrefValue = "";
        $this->porcentagem->TooltipValue = "";

        // valor
        $this->valor->HrefValue = "";
        $this->valor->TooltipValue = "";

        // obs
        $this->obs->HrefValue = "";
        $this->obs->TooltipValue = "";

        // posicao
        $this->posicao->HrefValue = "";
        $this->posicao->TooltipValue = "";

        // idplanilha_custo
        $this->idplanilha_custo->HrefValue = "";
        $this->idplanilha_custo->TooltipValue = "";

        // cargo
        $this->cargo->HrefValue = "";
        $this->cargo->TooltipValue = "";

        // sub_modulos
        $this->sub_modulos->HrefValue = "";
        $this->sub_modulos->TooltipValue = "";

        // idcliente
        $this->idcliente->HrefValue = "";
        $this->idcliente->TooltipValue = "";

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

        // idproposta
        $this->idproposta->setupEditAttributes();
        $this->idproposta->EditValue = $this->idproposta->CurrentValue;

        // dt_cadastro
        $this->dt_cadastro->setupEditAttributes();
        $this->dt_cadastro->EditValue = FormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

        // cliente
        $this->cliente->setupEditAttributes();
        if (!$this->cliente->Raw) {
            $this->cliente->CurrentValue = HtmlDecode($this->cliente->CurrentValue);
        }
        $this->cliente->EditValue = $this->cliente->CurrentValue;
        $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());

        // modulo
        $this->modulo->setupEditAttributes();
        if (!$this->modulo->Raw) {
            $this->modulo->CurrentValue = HtmlDecode($this->modulo->CurrentValue);
        }
        $this->modulo->EditValue = $this->modulo->CurrentValue;
        $this->modulo->PlaceHolder = RemoveHtml($this->modulo->caption());

        // item
        $this->item->setupEditAttributes();
        if (!$this->item->Raw) {
            $this->item->CurrentValue = HtmlDecode($this->item->CurrentValue);
        }
        $this->item->EditValue = $this->item->CurrentValue;
        $this->item->PlaceHolder = RemoveHtml($this->item->caption());

        // porcentagem
        $this->porcentagem->setupEditAttributes();
        $this->porcentagem->EditValue = $this->porcentagem->CurrentValue;
        $this->porcentagem->PlaceHolder = RemoveHtml($this->porcentagem->caption());
        if (strval($this->porcentagem->EditValue) != "" && is_numeric($this->porcentagem->EditValue)) {
            $this->porcentagem->EditValue = FormatNumber($this->porcentagem->EditValue, null);
        }

        // valor
        $this->valor->setupEditAttributes();
        $this->valor->EditValue = $this->valor->CurrentValue;
        $this->valor->PlaceHolder = RemoveHtml($this->valor->caption());
        if (strval($this->valor->EditValue) != "" && is_numeric($this->valor->EditValue)) {
            $this->valor->EditValue = FormatNumber($this->valor->EditValue, null);
        }

        // obs
        $this->obs->setupEditAttributes();
        if (!$this->obs->Raw) {
            $this->obs->CurrentValue = HtmlDecode($this->obs->CurrentValue);
        }
        $this->obs->EditValue = $this->obs->CurrentValue;
        $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

        // posicao
        $this->posicao->setupEditAttributes();
        $this->posicao->EditValue = $this->posicao->CurrentValue;
        $this->posicao->PlaceHolder = RemoveHtml($this->posicao->caption());
        if (strval($this->posicao->EditValue) != "" && is_numeric($this->posicao->EditValue)) {
            $this->posicao->EditValue = FormatNumber($this->posicao->EditValue, null);
        }

        // idplanilha_custo
        $this->idplanilha_custo->PlaceHolder = RemoveHtml($this->idplanilha_custo->caption());

        // cargo
        $this->cargo->setupEditAttributes();
        if (!$this->cargo->Raw) {
            $this->cargo->CurrentValue = HtmlDecode($this->cargo->CurrentValue);
        }
        $this->cargo->EditValue = $this->cargo->CurrentValue;
        $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

        // sub_modulos
        $this->sub_modulos->setupEditAttributes();
        $this->sub_modulos->EditValue = $this->sub_modulos->CurrentValue;
        $this->sub_modulos->PlaceHolder = RemoveHtml($this->sub_modulos->caption());
        if (strval($this->sub_modulos->EditValue) != "" && is_numeric($this->sub_modulos->EditValue)) {
            $this->sub_modulos->EditValue = FormatNumber($this->sub_modulos->EditValue, null);
        }

        // idcliente
        $this->idcliente->setupEditAttributes();
        $this->idcliente->EditValue = $this->idcliente->CurrentValue;
        $this->idcliente->PlaceHolder = RemoveHtml($this->idcliente->caption());
        if (strval($this->idcliente->EditValue) != "" && is_numeric($this->idcliente->EditValue)) {
            $this->idcliente->EditValue = FormatNumber($this->idcliente->EditValue, null);
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
                    $doc->exportCaption($this->idproposta);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->modulo);
                    $doc->exportCaption($this->item);
                    $doc->exportCaption($this->porcentagem);
                    $doc->exportCaption($this->valor);
                    $doc->exportCaption($this->obs);
                    $doc->exportCaption($this->posicao);
                    $doc->exportCaption($this->idplanilha_custo);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->sub_modulos);
                    $doc->exportCaption($this->idcliente);
                } else {
                    $doc->exportCaption($this->idproposta);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->modulo);
                    $doc->exportCaption($this->item);
                    $doc->exportCaption($this->porcentagem);
                    $doc->exportCaption($this->valor);
                    $doc->exportCaption($this->obs);
                    $doc->exportCaption($this->posicao);
                    $doc->exportCaption($this->idplanilha_custo);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->sub_modulos);
                    $doc->exportCaption($this->idcliente);
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
                        $doc->exportField($this->idproposta);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->modulo);
                        $doc->exportField($this->item);
                        $doc->exportField($this->porcentagem);
                        $doc->exportField($this->valor);
                        $doc->exportField($this->obs);
                        $doc->exportField($this->posicao);
                        $doc->exportField($this->idplanilha_custo);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->sub_modulos);
                        $doc->exportField($this->idcliente);
                    } else {
                        $doc->exportField($this->idproposta);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->modulo);
                        $doc->exportField($this->item);
                        $doc->exportField($this->porcentagem);
                        $doc->exportField($this->valor);
                        $doc->exportField($this->obs);
                        $doc->exportField($this->posicao);
                        $doc->exportField($this->idplanilha_custo);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->sub_modulos);
                        $doc->exportField($this->idcliente);
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
