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
 * Table class for cliente
 */
class Cliente extends DbTable
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
    public $idcliente;
    public $dt_cadastro;
    public $cliente;
    public $local_idlocal;
    public $cnpj;
    public $endereco;
    public $numero;
    public $bairro;
    public $cep;
    public $cidade;
    public $uf;
    public $contato;
    public $_email;
    public $telefone;
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
        $this->TableVar = "cliente";
        $this->TableName = 'cliente';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "cliente";
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
            'NO' // Edit Tag
        );
        $this->idcliente->InputTextType = "text";
        $this->idcliente->Raw = true;
        $this->idcliente->IsAutoIncrement = true; // Autoincrement field
        $this->idcliente->IsPrimaryKey = true; // Primary key field
        $this->idcliente->IsForeignKey = true; // Foreign key field
        $this->idcliente->Nullable = false; // NOT NULL field
        $this->idcliente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idcliente'] = &$this->idcliente;

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

        // local_idlocal
        $this->local_idlocal = new DbField(
            $this, // Table
            'x_local_idlocal', // Variable name
            'local_idlocal', // Name
            '`local_idlocal`', // Expression
            '`local_idlocal`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`local_idlocal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->local_idlocal->InputTextType = "text";
        $this->local_idlocal->Raw = true;
        $this->local_idlocal->Nullable = false; // NOT NULL field
        $this->local_idlocal->Required = true; // Required field
        $this->local_idlocal->setSelectMultiple(false); // Select one
        $this->local_idlocal->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->local_idlocal->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->local_idlocal->Lookup = new Lookup($this->local_idlocal, 'local', false, 'idlocal', ["local","","",""], '', '', [], [], [], [], [], [], false, '`local` ASC', '', "`local`");
        $this->local_idlocal->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->local_idlocal->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['local_idlocal'] = &$this->local_idlocal;

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

        // numero
        $this->numero = new DbField(
            $this, // Table
            'x_numero', // Variable name
            'numero', // Name
            '`numero`', // Expression
            '`numero`', // Basic search expression
            200, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`numero`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->numero->InputTextType = "text";
        $this->numero->Nullable = false; // NOT NULL field
        $this->numero->Required = true; // Required field
        $this->numero->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['numero'] = &$this->numero;

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

        // cep
        $this->cep = new DbField(
            $this, // Table
            'x_cep', // Variable name
            'cep', // Name
            '`cep`', // Expression
            '`cep`', // Basic search expression
            200, // Type
            9, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cep`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cep->InputTextType = "text";
        $this->cep->Nullable = false; // NOT NULL field
        $this->cep->Required = true; // Required field
        $this->cep->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['cep'] = &$this->cep;

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
        $this->uf->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['uf'] = &$this->uf;

        // contato
        $this->contato = new DbField(
            $this, // Table
            'x_contato', // Variable name
            'contato', // Name
            '`contato`', // Expression
            '`contato`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`contato`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->contato->InputTextType = "text";
        $this->contato->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['contato'] = &$this->contato;

        // email
        $this->_email = new DbField(
            $this, // Table
            'x__email', // Variable name
            'email', // Name
            '`email`', // Expression
            '`email`', // Basic search expression
            200, // Type
            120, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`email`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->_email->InputTextType = "text";
        $this->_email->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->_email->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['email'] = &$this->_email;

        // telefone
        $this->telefone = new DbField(
            $this, // Table
            'x_telefone', // Variable name
            'telefone', // Name
            '`telefone`', // Expression
            '`telefone`', // Basic search expression
            200, // Type
            120, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telefone`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->telefone->InputTextType = "text";
        $this->telefone->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['telefone'] = &$this->telefone;

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
        $this->ativo->Lookup = new Lookup($this->ativo, 'cliente', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
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
        if ($this->getCurrentDetailTable() == "faturamento") {
            $detailUrl = Container("faturamento")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idcliente", $this->idcliente->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ClienteList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "cliente";
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
            $this->idcliente->setDbValue($conn->lastInsertId());
            $rs['idcliente'] = $this->idcliente->DbValue;
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
        // Cascade Update detail table 'faturamento'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['idcliente']) && $rsold['idcliente'] != $rs['idcliente'])) { // Update detail field 'cliente_idcliente'
            $cascadeUpdate = true;
            $rscascade['cliente_idcliente'] = $rs['idcliente'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("faturamento")->loadRs("`cliente_idcliente` = " . QuotedValue($rsold['idcliente'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'idfaturamento';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("faturamento")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("faturamento")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("faturamento")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['idcliente']) && !EmptyValue($this->idcliente->CurrentValue)) {
                $rs['idcliente'] = $this->idcliente->CurrentValue;
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
            if (array_key_exists('idcliente', $rs)) {
                AddFilter($where, QuotedName('idcliente', $this->Dbid) . '=' . QuotedValue($rs['idcliente'], $this->idcliente->DataType, $this->Dbid));
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

        // Cascade delete detail table 'faturamento'
        $dtlrows = Container("faturamento")->loadRs("`cliente_idcliente` = " . QuotedValue($rs['idcliente'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("faturamento")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("faturamento")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("faturamento")->rowDeleted($dtlrow);
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
        $this->idcliente->DbValue = $row['idcliente'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->cliente->DbValue = $row['cliente'];
        $this->local_idlocal->DbValue = $row['local_idlocal'];
        $this->cnpj->DbValue = $row['cnpj'];
        $this->endereco->DbValue = $row['endereco'];
        $this->numero->DbValue = $row['numero'];
        $this->bairro->DbValue = $row['bairro'];
        $this->cep->DbValue = $row['cep'];
        $this->cidade->DbValue = $row['cidade'];
        $this->uf->DbValue = $row['uf'];
        $this->contato->DbValue = $row['contato'];
        $this->_email->DbValue = $row['email'];
        $this->telefone->DbValue = $row['telefone'];
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
        return "`idcliente` = @idcliente@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idcliente->CurrentValue : $this->idcliente->OldValue;
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
                $this->idcliente->CurrentValue = $keys[0];
            } else {
                $this->idcliente->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idcliente', $row) ? $row['idcliente'] : null;
        } else {
            $val = !EmptyValue($this->idcliente->OldValue) && !$current ? $this->idcliente->OldValue : $this->idcliente->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idcliente@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ClienteList");
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
            "ClienteView" => $Language->phrase("View"),
            "ClienteEdit" => $Language->phrase("Edit"),
            "ClienteAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ClienteList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ClienteView",
            Config("API_ADD_ACTION") => "ClienteAdd",
            Config("API_EDIT_ACTION") => "ClienteEdit",
            Config("API_DELETE_ACTION") => "ClienteDelete",
            Config("API_LIST_ACTION") => "ClienteList",
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
        return "ClienteList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ClienteView", $parm);
        } else {
            $url = $this->keyUrl("ClienteView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ClienteAdd?" . $parm;
        } else {
            $url = "ClienteAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ClienteEdit", $parm);
        } else {
            $url = $this->keyUrl("ClienteEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ClienteList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ClienteAdd", $parm);
        } else {
            $url = $this->keyUrl("ClienteAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ClienteList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ClienteDelete", $parm);
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
        $json .= "\"idcliente\":" . VarToJson($this->idcliente->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idcliente->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idcliente->CurrentValue);
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
            if (($keyValue = Param("idcliente") ?? Route("idcliente")) !== null) {
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
                $this->idcliente->CurrentValue = $key;
            } else {
                $this->idcliente->OldValue = $key;
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
        $this->idcliente->setDbValue($row['idcliente']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->cliente->setDbValue($row['cliente']);
        $this->local_idlocal->setDbValue($row['local_idlocal']);
        $this->cnpj->setDbValue($row['cnpj']);
        $this->endereco->setDbValue($row['endereco']);
        $this->numero->setDbValue($row['numero']);
        $this->bairro->setDbValue($row['bairro']);
        $this->cep->setDbValue($row['cep']);
        $this->cidade->setDbValue($row['cidade']);
        $this->uf->setDbValue($row['uf']);
        $this->contato->setDbValue($row['contato']);
        $this->_email->setDbValue($row['email']);
        $this->telefone->setDbValue($row['telefone']);
        $this->ativo->setDbValue($row['ativo']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ClienteList";
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

        // idcliente

        // dt_cadastro

        // cliente
        $this->cliente->CellCssStyle = "white-space: nowrap;";

        // local_idlocal
        $this->local_idlocal->CellCssStyle = "white-space: nowrap;";

        // cnpj

        // endereco

        // numero

        // bairro

        // cep

        // cidade

        // uf

        // contato

        // email

        // telefone

        // ativo

        // idcliente
        $this->idcliente->ViewValue = $this->idcliente->CurrentValue;

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->CssClass = "fw-bold";

        // cliente
        $this->cliente->ViewValue = $this->cliente->CurrentValue;
        $this->cliente->CssClass = "fw-bold";

        // local_idlocal
        $curVal = strval($this->local_idlocal->CurrentValue);
        if ($curVal != "") {
            $this->local_idlocal->ViewValue = $this->local_idlocal->lookupCacheOption($curVal);
            if ($this->local_idlocal->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->local_idlocal->Lookup->getTable()->Fields["idlocal"]->searchExpression(), "=", $curVal, $this->local_idlocal->Lookup->getTable()->Fields["idlocal"]->searchDataType(), "");
                $sqlWrk = $this->local_idlocal->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->local_idlocal->Lookup->renderViewRow($rswrk[0]);
                    $this->local_idlocal->ViewValue = $this->local_idlocal->displayValue($arwrk);
                } else {
                    $this->local_idlocal->ViewValue = FormatNumber($this->local_idlocal->CurrentValue, $this->local_idlocal->formatPattern());
                }
            }
        } else {
            $this->local_idlocal->ViewValue = null;
        }
        $this->local_idlocal->CssClass = "fw-bold";

        // cnpj
        $this->cnpj->ViewValue = $this->cnpj->CurrentValue;
        $this->cnpj->CssClass = "fw-bold";

        // endereco
        $this->endereco->ViewValue = $this->endereco->CurrentValue;
        $this->endereco->CssClass = "fw-bold";

        // numero
        $this->numero->ViewValue = $this->numero->CurrentValue;
        $this->numero->CssClass = "fw-bold";

        // bairro
        $this->bairro->ViewValue = $this->bairro->CurrentValue;
        $this->bairro->CssClass = "fw-bold";

        // cep
        $this->cep->ViewValue = $this->cep->CurrentValue;
        $this->cep->CssClass = "fw-bold";

        // cidade
        $this->cidade->ViewValue = $this->cidade->CurrentValue;
        $this->cidade->CssClass = "fw-bold";

        // uf
        $this->uf->ViewValue = $this->uf->CurrentValue;
        $this->uf->CssClass = "fw-bold";

        // contato
        $this->contato->ViewValue = $this->contato->CurrentValue;
        $this->contato->CssClass = "fw-bold";

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;
        $this->_email->CssClass = "fw-bold";

        // telefone
        $this->telefone->ViewValue = $this->telefone->CurrentValue;
        $this->telefone->CssClass = "fw-bold";

        // ativo
        if (strval($this->ativo->CurrentValue) != "") {
            $this->ativo->ViewValue = $this->ativo->optionCaption($this->ativo->CurrentValue);
        } else {
            $this->ativo->ViewValue = null;
        }
        $this->ativo->CssClass = "fw-bold";
        $this->ativo->CellCssStyle .= "text-align: center;";

        // idcliente
        $this->idcliente->HrefValue = "";
        $this->idcliente->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // cliente
        $this->cliente->HrefValue = "";
        $this->cliente->TooltipValue = "";

        // local_idlocal
        $this->local_idlocal->HrefValue = "";
        $this->local_idlocal->TooltipValue = "";

        // cnpj
        $this->cnpj->HrefValue = "";
        $this->cnpj->TooltipValue = "";

        // endereco
        $this->endereco->HrefValue = "";
        $this->endereco->TooltipValue = "";

        // numero
        $this->numero->HrefValue = "";
        $this->numero->TooltipValue = "";

        // bairro
        $this->bairro->HrefValue = "";
        $this->bairro->TooltipValue = "";

        // cep
        $this->cep->HrefValue = "";
        $this->cep->TooltipValue = "";

        // cidade
        $this->cidade->HrefValue = "";
        $this->cidade->TooltipValue = "";

        // uf
        $this->uf->HrefValue = "";
        $this->uf->TooltipValue = "";

        // contato
        $this->contato->HrefValue = "";
        $this->contato->TooltipValue = "";

        // email
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // telefone
        $this->telefone->HrefValue = "";
        $this->telefone->TooltipValue = "";

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

        // idcliente
        $this->idcliente->setupEditAttributes();
        $this->idcliente->EditValue = $this->idcliente->CurrentValue;

        // dt_cadastro

        // cliente
        $this->cliente->setupEditAttributes();
        if (!$this->cliente->Raw) {
            $this->cliente->CurrentValue = HtmlDecode($this->cliente->CurrentValue);
        }
        $this->cliente->EditValue = $this->cliente->CurrentValue;
        $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());

        // local_idlocal
        $this->local_idlocal->setupEditAttributes();
        $this->local_idlocal->PlaceHolder = RemoveHtml($this->local_idlocal->caption());

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

        // numero
        $this->numero->setupEditAttributes();
        if (!$this->numero->Raw) {
            $this->numero->CurrentValue = HtmlDecode($this->numero->CurrentValue);
        }
        $this->numero->EditValue = $this->numero->CurrentValue;
        $this->numero->PlaceHolder = RemoveHtml($this->numero->caption());

        // bairro
        $this->bairro->setupEditAttributes();
        if (!$this->bairro->Raw) {
            $this->bairro->CurrentValue = HtmlDecode($this->bairro->CurrentValue);
        }
        $this->bairro->EditValue = $this->bairro->CurrentValue;
        $this->bairro->PlaceHolder = RemoveHtml($this->bairro->caption());

        // cep
        $this->cep->setupEditAttributes();
        if (!$this->cep->Raw) {
            $this->cep->CurrentValue = HtmlDecode($this->cep->CurrentValue);
        }
        $this->cep->EditValue = $this->cep->CurrentValue;
        $this->cep->PlaceHolder = RemoveHtml($this->cep->caption());

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

        // contato
        $this->contato->setupEditAttributes();
        if (!$this->contato->Raw) {
            $this->contato->CurrentValue = HtmlDecode($this->contato->CurrentValue);
        }
        $this->contato->EditValue = $this->contato->CurrentValue;
        $this->contato->PlaceHolder = RemoveHtml($this->contato->caption());

        // email
        $this->_email->setupEditAttributes();
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // telefone
        $this->telefone->setupEditAttributes();
        if (!$this->telefone->Raw) {
            $this->telefone->CurrentValue = HtmlDecode($this->telefone->CurrentValue);
        }
        $this->telefone->EditValue = $this->telefone->CurrentValue;
        $this->telefone->PlaceHolder = RemoveHtml($this->telefone->caption());

        // ativo
        $this->ativo->EditValue = $this->ativo->options(false);
        $this->ativo->PlaceHolder = RemoveHtml($this->ativo->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            $this->cliente->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->cliente->CurrentValue = $this->cliente->Count;
            $this->cliente->ViewValue = $this->cliente->CurrentValue;
            $this->cliente->CssClass = "fw-bold";
            $this->cliente->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->idcliente);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->local_idlocal);
                    $doc->exportCaption($this->cnpj);
                    $doc->exportCaption($this->endereco);
                    $doc->exportCaption($this->numero);
                    $doc->exportCaption($this->bairro);
                    $doc->exportCaption($this->cep);
                    $doc->exportCaption($this->cidade);
                    $doc->exportCaption($this->uf);
                    $doc->exportCaption($this->contato);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->telefone);
                    $doc->exportCaption($this->ativo);
                } else {
                    $doc->exportCaption($this->idcliente);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->local_idlocal);
                    $doc->exportCaption($this->cnpj);
                    $doc->exportCaption($this->endereco);
                    $doc->exportCaption($this->numero);
                    $doc->exportCaption($this->bairro);
                    $doc->exportCaption($this->cep);
                    $doc->exportCaption($this->cidade);
                    $doc->exportCaption($this->uf);
                    $doc->exportCaption($this->contato);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->telefone);
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
                        $doc->exportField($this->idcliente);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->local_idlocal);
                        $doc->exportField($this->cnpj);
                        $doc->exportField($this->endereco);
                        $doc->exportField($this->numero);
                        $doc->exportField($this->bairro);
                        $doc->exportField($this->cep);
                        $doc->exportField($this->cidade);
                        $doc->exportField($this->uf);
                        $doc->exportField($this->contato);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->telefone);
                        $doc->exportField($this->ativo);
                    } else {
                        $doc->exportField($this->idcliente);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->local_idlocal);
                        $doc->exportField($this->cnpj);
                        $doc->exportField($this->endereco);
                        $doc->exportField($this->numero);
                        $doc->exportField($this->bairro);
                        $doc->exportField($this->cep);
                        $doc->exportField($this->cidade);
                        $doc->exportField($this->uf);
                        $doc->exportField($this->contato);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->telefone);
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
                $doc->exportAggregate($this->idcliente, '');
                $doc->exportAggregate($this->dt_cadastro, '');
                $doc->exportAggregate($this->cliente, 'COUNT');
                $doc->exportAggregate($this->local_idlocal, '');
                $doc->exportAggregate($this->cnpj, '');
                $doc->exportAggregate($this->endereco, '');
                $doc->exportAggregate($this->numero, '');
                $doc->exportAggregate($this->bairro, '');
                $doc->exportAggregate($this->cep, '');
                $doc->exportAggregate($this->cidade, '');
                $doc->exportAggregate($this->uf, '');
                $doc->exportAggregate($this->contato, '');
                $doc->exportAggregate($this->_email, '');
                $doc->exportAggregate($this->telefone, '');
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
