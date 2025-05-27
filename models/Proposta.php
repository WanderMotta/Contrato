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
 * Table class for proposta
 */
class Proposta extends DbTable
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
    public $cliente_idcliente;
    public $validade;
    public $mes_ano_conv_coletiva;
    public $sindicato;
    public $cidade;
    public $nr_meses;
    public $usuario_idusuario;
    public $obs;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "proposta";
        $this->TableName = 'proposta';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "proposta";
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
        $this->idproposta->IsForeignKey = true; // Foreign key field
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
            CastDateFieldForLike("`dt_cadastro`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
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
        $this->dt_cadastro->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->dt_cadastro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dt_cadastro'] = &$this->dt_cadastro;

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
            'SELECT' // Edit Tag
        );
        $this->cliente_idcliente->InputTextType = "text";
        $this->cliente_idcliente->Raw = true;
        $this->cliente_idcliente->Nullable = false; // NOT NULL field
        $this->cliente_idcliente->Required = true; // Required field
        $this->cliente_idcliente->setSelectMultiple(false); // Select one
        $this->cliente_idcliente->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cliente_idcliente->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->cliente_idcliente->Lookup = new Lookup($this->cliente_idcliente, 'cliente', false, 'idcliente', ["cliente","","",""], '', '', [], [], [], [], [], [], false, '`cliente` ASC', '', "`cliente`");
        $this->cliente_idcliente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cliente_idcliente->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['cliente_idcliente'] = &$this->cliente_idcliente;

        // validade
        $this->validade = new DbField(
            $this, // Table
            'x_validade', // Variable name
            'validade', // Name
            '`validade`', // Expression
            CastDateFieldForLike("`validade`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`validade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->validade->InputTextType = "text";
        $this->validade->Raw = true;
        $this->validade->Nullable = false; // NOT NULL field
        $this->validade->Required = true; // Required field
        $this->validade->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->validade->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['validade'] = &$this->validade;

        // mes_ano_conv_coletiva
        $this->mes_ano_conv_coletiva = new DbField(
            $this, // Table
            'x_mes_ano_conv_coletiva', // Variable name
            'mes_ano_conv_coletiva', // Name
            '`mes_ano_conv_coletiva`', // Expression
            '`mes_ano_conv_coletiva`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`mes_ano_conv_coletiva`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->mes_ano_conv_coletiva->addMethod("getDefault", fn() => "Jan/2024");
        $this->mes_ano_conv_coletiva->InputTextType = "text";
        $this->mes_ano_conv_coletiva->Nullable = false; // NOT NULL field
        $this->mes_ano_conv_coletiva->Required = true; // Required field
        $this->mes_ano_conv_coletiva->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['mes_ano_conv_coletiva'] = &$this->mes_ano_conv_coletiva;

        // sindicato
        $this->sindicato = new DbField(
            $this, // Table
            'x_sindicato', // Variable name
            'sindicato', // Name
            '`sindicato`', // Expression
            '`sindicato`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`sindicato`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->sindicato->addMethod("getDefault", fn() => "Siemaco");
        $this->sindicato->InputTextType = "text";
        $this->sindicato->Nullable = false; // NOT NULL field
        $this->sindicato->Required = true; // Required field
        $this->sindicato->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['sindicato'] = &$this->sindicato;

        // cidade
        $this->cidade = new DbField(
            $this, // Table
            'x_cidade', // Variable name
            'cidade', // Name
            '`cidade`', // Expression
            '`cidade`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cidade->addMethod("getDefault", fn() => "São Paulo/SP");
        $this->cidade->InputTextType = "text";
        $this->cidade->Nullable = false; // NOT NULL field
        $this->cidade->Required = true; // Required field
        $this->cidade->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['cidade'] = &$this->cidade;

        // nr_meses
        $this->nr_meses = new DbField(
            $this, // Table
            'x_nr_meses', // Variable name
            'nr_meses', // Name
            '`nr_meses`', // Expression
            '`nr_meses`', // Basic search expression
            200, // Type
            45, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nr_meses`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nr_meses->addMethod("getDefault", fn() => "24 Meses");
        $this->nr_meses->InputTextType = "text";
        $this->nr_meses->Nullable = false; // NOT NULL field
        $this->nr_meses->Required = true; // Required field
        $this->nr_meses->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['nr_meses'] = &$this->nr_meses;

        // usuario_idusuario
        $this->usuario_idusuario = new DbField(
            $this, // Table
            'x_usuario_idusuario', // Variable name
            'usuario_idusuario', // Name
            '`usuario_idusuario`', // Expression
            '`usuario_idusuario`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usuario_idusuario`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->usuario_idusuario->addMethod("getAutoUpdateValue", fn() => CurrentUserID());
        $this->usuario_idusuario->InputTextType = "text";
        $this->usuario_idusuario->Raw = true;
        $this->usuario_idusuario->Nullable = false; // NOT NULL field
        $this->usuario_idusuario->setSelectMultiple(false); // Select one
        $this->usuario_idusuario->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->usuario_idusuario->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->usuario_idusuario->Lookup = new Lookup($this->usuario_idusuario, 'usuario', false, 'idusuario', ["login","","",""], '', '', [], [], [], [], [], [], false, '', '', "`login`");
        $this->usuario_idusuario->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuario_idusuario->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['usuario_idusuario'] = &$this->usuario_idusuario;

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
        if ($this->getCurrentDetailTable() == "planilha_custo") {
            $detailUrl = Container("planilha_custo")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idproposta", $this->idproposta->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "mov_insumo_cliente") {
            $detailUrl = Container("mov_insumo_cliente")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idproposta", $this->idproposta->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "PropostaList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "proposta";
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
        // Cascade Update detail table 'planilha_custo'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['idproposta']) && $rsold['idproposta'] != $rs['idproposta'])) { // Update detail field 'proposta_idproposta'
            $cascadeUpdate = true;
            $rscascade['proposta_idproposta'] = $rs['idproposta'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("planilha_custo")->loadRs("`proposta_idproposta` = " . QuotedValue($rsold['idproposta'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'idplanilha_custo';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("planilha_custo")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("planilha_custo")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("planilha_custo")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'mov_insumo_cliente'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['idproposta']) && $rsold['idproposta'] != $rs['idproposta'])) { // Update detail field 'proposta_idproposta'
            $cascadeUpdate = true;
            $rscascade['proposta_idproposta'] = $rs['idproposta'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("mov_insumo_cliente")->loadRs("`proposta_idproposta` = " . QuotedValue($rsold['idproposta'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'idmov_insumo_cliente';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("mov_insumo_cliente")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("mov_insumo_cliente")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("mov_insumo_cliente")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['idproposta']) && !EmptyValue($this->idproposta->CurrentValue)) {
                $rs['idproposta'] = $this->idproposta->CurrentValue;
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

        // Cascade delete detail table 'planilha_custo'
        $dtlrows = Container("planilha_custo")->loadRs("`proposta_idproposta` = " . QuotedValue($rs['idproposta'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("planilha_custo")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("planilha_custo")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("planilha_custo")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'mov_insumo_cliente'
        $dtlrows = Container("mov_insumo_cliente")->loadRs("`proposta_idproposta` = " . QuotedValue($rs['idproposta'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("mov_insumo_cliente")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("mov_insumo_cliente")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("mov_insumo_cliente")->rowDeleted($dtlrow);
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
        $this->idproposta->DbValue = $row['idproposta'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->cliente_idcliente->DbValue = $row['cliente_idcliente'];
        $this->validade->DbValue = $row['validade'];
        $this->mes_ano_conv_coletiva->DbValue = $row['mes_ano_conv_coletiva'];
        $this->sindicato->DbValue = $row['sindicato'];
        $this->cidade->DbValue = $row['cidade'];
        $this->nr_meses->DbValue = $row['nr_meses'];
        $this->usuario_idusuario->DbValue = $row['usuario_idusuario'];
        $this->obs->DbValue = $row['obs'];
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
        return $_SESSION[$name] ?? GetUrl("PropostaList");
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
            "PropostaView" => $Language->phrase("View"),
            "PropostaEdit" => $Language->phrase("Edit"),
            "PropostaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "PropostaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "PropostaView",
            Config("API_ADD_ACTION") => "PropostaAdd",
            Config("API_EDIT_ACTION") => "PropostaEdit",
            Config("API_DELETE_ACTION") => "PropostaDelete",
            Config("API_LIST_ACTION") => "PropostaList",
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
        return "PropostaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PropostaView", $parm);
        } else {
            $url = $this->keyUrl("PropostaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "PropostaAdd?" . $parm;
        } else {
            $url = "PropostaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PropostaEdit", $parm);
        } else {
            $url = $this->keyUrl("PropostaEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("PropostaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PropostaAdd", $parm);
        } else {
            $url = $this->keyUrl("PropostaAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("PropostaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("PropostaDelete", $parm);
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
        $this->cliente_idcliente->setDbValue($row['cliente_idcliente']);
        $this->validade->setDbValue($row['validade']);
        $this->mes_ano_conv_coletiva->setDbValue($row['mes_ano_conv_coletiva']);
        $this->sindicato->setDbValue($row['sindicato']);
        $this->cidade->setDbValue($row['cidade']);
        $this->nr_meses->setDbValue($row['nr_meses']);
        $this->usuario_idusuario->setDbValue($row['usuario_idusuario']);
        $this->obs->setDbValue($row['obs']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "PropostaList";
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

        // cliente_idcliente

        // validade

        // mes_ano_conv_coletiva

        // sindicato

        // cidade

        // nr_meses

        // usuario_idusuario

        // obs

        // idproposta
        $this->idproposta->ViewValue = $this->idproposta->CurrentValue;
        $this->idproposta->CssClass = "fw-bold";
        $this->idproposta->CellCssStyle .= "text-align: center;";

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->CssClass = "fw-bold";

        // cliente_idcliente
        $curVal = strval($this->cliente_idcliente->CurrentValue);
        if ($curVal != "") {
            $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->lookupCacheOption($curVal);
            if ($this->cliente_idcliente->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->cliente_idcliente->Lookup->getTable()->Fields["idcliente"]->searchExpression(), "=", $curVal, $this->cliente_idcliente->Lookup->getTable()->Fields["idcliente"]->searchDataType(), "");
                $sqlWrk = $this->cliente_idcliente->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->cliente_idcliente->Lookup->renderViewRow($rswrk[0]);
                    $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->displayValue($arwrk);
                } else {
                    $this->cliente_idcliente->ViewValue = FormatNumber($this->cliente_idcliente->CurrentValue, $this->cliente_idcliente->formatPattern());
                }
            }
        } else {
            $this->cliente_idcliente->ViewValue = null;
        }
        $this->cliente_idcliente->CssClass = "fw-bold";

        // validade
        $this->validade->ViewValue = $this->validade->CurrentValue;
        $this->validade->ViewValue = FormatDateTime($this->validade->ViewValue, $this->validade->formatPattern());
        $this->validade->CssClass = "fw-bold";

        // mes_ano_conv_coletiva
        $this->mes_ano_conv_coletiva->ViewValue = $this->mes_ano_conv_coletiva->CurrentValue;
        $this->mes_ano_conv_coletiva->CssClass = "fw-bold";

        // sindicato
        $this->sindicato->ViewValue = $this->sindicato->CurrentValue;
        $this->sindicato->CssClass = "fw-bold";

        // cidade
        $this->cidade->ViewValue = $this->cidade->CurrentValue;
        $this->cidade->CssClass = "fw-bold";

        // nr_meses
        $this->nr_meses->ViewValue = $this->nr_meses->CurrentValue;
        $this->nr_meses->CssClass = "fw-bold";

        // usuario_idusuario
        $curVal = strval($this->usuario_idusuario->CurrentValue);
        if ($curVal != "") {
            $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->lookupCacheOption($curVal);
            if ($this->usuario_idusuario->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->usuario_idusuario->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->usuario_idusuario->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                $sqlWrk = $this->usuario_idusuario->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->usuario_idusuario->Lookup->renderViewRow($rswrk[0]);
                    $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->displayValue($arwrk);
                } else {
                    $this->usuario_idusuario->ViewValue = FormatNumber($this->usuario_idusuario->CurrentValue, $this->usuario_idusuario->formatPattern());
                }
            }
        } else {
            $this->usuario_idusuario->ViewValue = null;
        }
        $this->usuario_idusuario->CssClass = "fw-bold";

        // obs
        $this->obs->ViewValue = $this->obs->CurrentValue;
        $this->obs->CssClass = "fw-bold";

        // idproposta
        $this->idproposta->HrefValue = "";
        $this->idproposta->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // cliente_idcliente
        $this->cliente_idcliente->HrefValue = "";
        $this->cliente_idcliente->TooltipValue = "";

        // validade
        $this->validade->HrefValue = "";
        $this->validade->TooltipValue = "";

        // mes_ano_conv_coletiva
        $this->mes_ano_conv_coletiva->HrefValue = "";
        $this->mes_ano_conv_coletiva->TooltipValue = "";

        // sindicato
        $this->sindicato->HrefValue = "";
        $this->sindicato->TooltipValue = "";

        // cidade
        $this->cidade->HrefValue = "";
        $this->cidade->TooltipValue = "";

        // nr_meses
        $this->nr_meses->HrefValue = "";
        $this->nr_meses->TooltipValue = "";

        // usuario_idusuario
        $this->usuario_idusuario->HrefValue = "";
        $this->usuario_idusuario->TooltipValue = "";

        // obs
        $this->obs->HrefValue = "";
        $this->obs->TooltipValue = "";

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
        $this->idproposta->CssClass = "fw-bold";
        $this->idproposta->CellCssStyle .= "text-align: center;";

        // dt_cadastro

        // cliente_idcliente
        $this->cliente_idcliente->setupEditAttributes();
        $this->cliente_idcliente->PlaceHolder = RemoveHtml($this->cliente_idcliente->caption());

        // validade
        $this->validade->setupEditAttributes();
        $this->validade->EditValue = FormatDateTime($this->validade->CurrentValue, $this->validade->formatPattern());
        $this->validade->PlaceHolder = RemoveHtml($this->validade->caption());

        // mes_ano_conv_coletiva
        $this->mes_ano_conv_coletiva->setupEditAttributes();
        if (!$this->mes_ano_conv_coletiva->Raw) {
            $this->mes_ano_conv_coletiva->CurrentValue = HtmlDecode($this->mes_ano_conv_coletiva->CurrentValue);
        }
        $this->mes_ano_conv_coletiva->EditValue = $this->mes_ano_conv_coletiva->CurrentValue;
        $this->mes_ano_conv_coletiva->PlaceHolder = RemoveHtml($this->mes_ano_conv_coletiva->caption());

        // sindicato
        $this->sindicato->setupEditAttributes();
        if (!$this->sindicato->Raw) {
            $this->sindicato->CurrentValue = HtmlDecode($this->sindicato->CurrentValue);
        }
        $this->sindicato->EditValue = $this->sindicato->CurrentValue;
        $this->sindicato->PlaceHolder = RemoveHtml($this->sindicato->caption());

        // cidade
        $this->cidade->setupEditAttributes();
        if (!$this->cidade->Raw) {
            $this->cidade->CurrentValue = HtmlDecode($this->cidade->CurrentValue);
        }
        $this->cidade->EditValue = $this->cidade->CurrentValue;
        $this->cidade->PlaceHolder = RemoveHtml($this->cidade->caption());

        // nr_meses
        $this->nr_meses->setupEditAttributes();
        if (!$this->nr_meses->Raw) {
            $this->nr_meses->CurrentValue = HtmlDecode($this->nr_meses->CurrentValue);
        }
        $this->nr_meses->EditValue = $this->nr_meses->CurrentValue;
        $this->nr_meses->PlaceHolder = RemoveHtml($this->nr_meses->caption());

        // usuario_idusuario

        // obs
        $this->obs->setupEditAttributes();
        $this->obs->EditValue = $this->obs->CurrentValue;
        $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            $this->cliente_idcliente->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->cliente_idcliente->CurrentValue = $this->cliente_idcliente->Count;
            $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->CurrentValue;
            $this->cliente_idcliente->CssClass = "fw-bold";
            $this->cliente_idcliente->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->cliente_idcliente);
                    $doc->exportCaption($this->validade);
                    $doc->exportCaption($this->mes_ano_conv_coletiva);
                    $doc->exportCaption($this->sindicato);
                    $doc->exportCaption($this->cidade);
                    $doc->exportCaption($this->nr_meses);
                    $doc->exportCaption($this->usuario_idusuario);
                    $doc->exportCaption($this->obs);
                } else {
                    $doc->exportCaption($this->idproposta);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->cliente_idcliente);
                    $doc->exportCaption($this->validade);
                    $doc->exportCaption($this->mes_ano_conv_coletiva);
                    $doc->exportCaption($this->sindicato);
                    $doc->exportCaption($this->cidade);
                    $doc->exportCaption($this->nr_meses);
                    $doc->exportCaption($this->usuario_idusuario);
                    $doc->exportCaption($this->obs);
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
                        $doc->exportField($this->idproposta);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->cliente_idcliente);
                        $doc->exportField($this->validade);
                        $doc->exportField($this->mes_ano_conv_coletiva);
                        $doc->exportField($this->sindicato);
                        $doc->exportField($this->cidade);
                        $doc->exportField($this->nr_meses);
                        $doc->exportField($this->usuario_idusuario);
                        $doc->exportField($this->obs);
                    } else {
                        $doc->exportField($this->idproposta);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->cliente_idcliente);
                        $doc->exportField($this->validade);
                        $doc->exportField($this->mes_ano_conv_coletiva);
                        $doc->exportField($this->sindicato);
                        $doc->exportField($this->cidade);
                        $doc->exportField($this->nr_meses);
                        $doc->exportField($this->usuario_idusuario);
                        $doc->exportField($this->obs);
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
                $doc->exportAggregate($this->idproposta, '');
                $doc->exportAggregate($this->dt_cadastro, '');
                $doc->exportAggregate($this->cliente_idcliente, 'COUNT');
                $doc->exportAggregate($this->validade, '');
                $doc->exportAggregate($this->mes_ano_conv_coletiva, '');
                $doc->exportAggregate($this->sindicato, '');
                $doc->exportAggregate($this->cidade, '');
                $doc->exportAggregate($this->nr_meses, '');
                $doc->exportAggregate($this->usuario_idusuario, '');
                $doc->exportAggregate($this->obs, '');
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
