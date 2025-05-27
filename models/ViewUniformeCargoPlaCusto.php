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
 * Table class for view_uniforme_cargo_pla_custo
 */
class ViewUniformeCargoPlaCusto extends DbTable
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
    public $idplanilha_custo;
    public $proposta_idproposta;
    public $dt_proposta;
    public $qtde_cargos;
    public $cargo_idcargo;
    public $cargo;
    public $uniforme;
    public $qtde;
    public $periodo_troca;
    public $vr_unitario;
    public $tipo_uniforme;
    public $vr_anual;
    public $vr_mesal;
    public $cliente;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "view_uniforme_cargo_pla_custo";
        $this->TableName = 'view_uniforme_cargo_pla_custo';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_uniforme_cargo_pla_custo";
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
            'NO' // Edit Tag
        );
        $this->idplanilha_custo->InputTextType = "text";
        $this->idplanilha_custo->Raw = true;
        $this->idplanilha_custo->IsAutoIncrement = true; // Autoincrement field
        $this->idplanilha_custo->IsPrimaryKey = true; // Primary key field
        $this->idplanilha_custo->Nullable = false; // NOT NULL field
        $this->idplanilha_custo->UseFilter = true; // Table header filter
        $this->idplanilha_custo->Lookup = new Lookup($this->idplanilha_custo, 'view_uniforme_cargo_pla_custo', true, 'idplanilha_custo', ["idplanilha_custo","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->idplanilha_custo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idplanilha_custo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idplanilha_custo'] = &$this->idplanilha_custo;

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
        $this->proposta_idproposta->Nullable = false; // NOT NULL field
        $this->proposta_idproposta->Required = true; // Required field
        $this->proposta_idproposta->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proposta_idproposta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['proposta_idproposta'] = &$this->proposta_idproposta;

        // dt_proposta
        $this->dt_proposta = new DbField(
            $this, // Table
            'x_dt_proposta', // Variable name
            'dt_proposta', // Name
            '`dt_proposta`', // Expression
            CastDateFieldForLike("`dt_proposta`", 14, "DB"), // Basic search expression
            133, // Type
            10, // Size
            14, // Date/Time format
            false, // Is upload field
            '`dt_proposta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dt_proposta->InputTextType = "text";
        $this->dt_proposta->Raw = true;
        $this->dt_proposta->DefaultErrorMessage = str_replace("%s", DateFormat(14), $Language->phrase("IncorrectDate"));
        $this->dt_proposta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['dt_proposta'] = &$this->dt_proposta;

        // qtde_cargos
        $this->qtde_cargos = new DbField(
            $this, // Table
            'x_qtde_cargos', // Variable name
            'qtde_cargos', // Name
            '`qtde_cargos`', // Expression
            '`qtde_cargos`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`qtde_cargos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->qtde_cargos->addMethod("getDefault", fn() => 1);
        $this->qtde_cargos->InputTextType = "text";
        $this->qtde_cargos->Raw = true;
        $this->qtde_cargos->Nullable = false; // NOT NULL field
        $this->qtde_cargos->Required = true; // Required field
        $this->qtde_cargos->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->qtde_cargos->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['qtde_cargos'] = &$this->qtde_cargos;

        // cargo_idcargo
        $this->cargo_idcargo = new DbField(
            $this, // Table
            'x_cargo_idcargo', // Variable name
            'cargo_idcargo', // Name
            '`cargo_idcargo`', // Expression
            '`cargo_idcargo`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cargo_idcargo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cargo_idcargo->InputTextType = "text";
        $this->cargo_idcargo->Raw = true;
        $this->cargo_idcargo->Nullable = false; // NOT NULL field
        $this->cargo_idcargo->Required = true; // Required field
        $this->cargo_idcargo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cargo_idcargo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['cargo_idcargo'] = &$this->cargo_idcargo;

        // cargo
        $this->cargo = new DbField(
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
        $this->cargo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['cargo'] = &$this->cargo;

        // uniforme
        $this->uniforme = new DbField(
            $this, // Table
            'x_uniforme', // Variable name
            'uniforme', // Name
            '`uniforme`', // Expression
            '`uniforme`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`uniforme`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->uniforme->InputTextType = "text";
        $this->uniforme->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['uniforme'] = &$this->uniforme;

        // qtde
        $this->qtde = new DbField(
            $this, // Table
            'x_qtde', // Variable name
            'qtde', // Name
            '`qtde`', // Expression
            '`qtde`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`qtde`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->qtde->addMethod("getDefault", fn() => 2);
        $this->qtde->InputTextType = "text";
        $this->qtde->Raw = true;
        $this->qtde->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->qtde->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['qtde'] = &$this->qtde;

        // periodo_troca
        $this->periodo_troca = new DbField(
            $this, // Table
            'x_periodo_troca', // Variable name
            'periodo_troca', // Name
            '`periodo_troca`', // Expression
            '`periodo_troca`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`periodo_troca`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->periodo_troca->addMethod("getDefault", fn() => 2);
        $this->periodo_troca->InputTextType = "text";
        $this->periodo_troca->Raw = true;
        $this->periodo_troca->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->periodo_troca->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['periodo_troca'] = &$this->periodo_troca;

        // vr_unitario
        $this->vr_unitario = new DbField(
            $this, // Table
            'x_vr_unitario', // Variable name
            'vr_unitario', // Name
            '`vr_unitario`', // Expression
            '`vr_unitario`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`vr_unitario`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vr_unitario->InputTextType = "text";
        $this->vr_unitario->Raw = true;
        $this->vr_unitario->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vr_unitario->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['vr_unitario'] = &$this->vr_unitario;

        // tipo_uniforme
        $this->tipo_uniforme = new DbField(
            $this, // Table
            'x_tipo_uniforme', // Variable name
            'tipo_uniforme', // Name
            '`tipo_uniforme`', // Expression
            '`tipo_uniforme`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_uniforme`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tipo_uniforme->InputTextType = "text";
        $this->tipo_uniforme->Nullable = false; // NOT NULL field
        $this->tipo_uniforme->Required = true; // Required field
        $this->tipo_uniforme->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['tipo_uniforme'] = &$this->tipo_uniforme;

        // vr_anual
        $this->vr_anual = new DbField(
            $this, // Table
            'x_vr_anual', // Variable name
            'vr_anual', // Name
            '`vr_anual`', // Expression
            '`vr_anual`', // Basic search expression
            131, // Type
            42, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`vr_anual`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vr_anual->InputTextType = "text";
        $this->vr_anual->Raw = true;
        $this->vr_anual->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vr_anual->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['vr_anual'] = &$this->vr_anual;

        // vr_mesal
        $this->vr_mesal = new DbField(
            $this, // Table
            'x_vr_mesal', // Variable name
            'vr_mesal', // Name
            '`vr_mesal`', // Expression
            '`vr_mesal`', // Basic search expression
            131, // Type
            43, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`vr_mesal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vr_mesal->InputTextType = "text";
        $this->vr_mesal->Raw = true;
        $this->vr_mesal->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->vr_mesal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['vr_mesal'] = &$this->vr_mesal;

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
        $this->cliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cliente'] = &$this->cliente;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_uniforme_cargo_pla_custo";
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
            if (array_key_exists('idplanilha_custo', $rs)) {
                AddFilter($where, QuotedName('idplanilha_custo', $this->Dbid) . '=' . QuotedValue($rs['idplanilha_custo'], $this->idplanilha_custo->DataType, $this->Dbid));
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
        $this->idplanilha_custo->DbValue = $row['idplanilha_custo'];
        $this->proposta_idproposta->DbValue = $row['proposta_idproposta'];
        $this->dt_proposta->DbValue = $row['dt_proposta'];
        $this->qtde_cargos->DbValue = $row['qtde_cargos'];
        $this->cargo_idcargo->DbValue = $row['cargo_idcargo'];
        $this->cargo->DbValue = $row['cargo'];
        $this->uniforme->DbValue = $row['uniforme'];
        $this->qtde->DbValue = $row['qtde'];
        $this->periodo_troca->DbValue = $row['periodo_troca'];
        $this->vr_unitario->DbValue = $row['vr_unitario'];
        $this->tipo_uniforme->DbValue = $row['tipo_uniforme'];
        $this->vr_anual->DbValue = $row['vr_anual'];
        $this->vr_mesal->DbValue = $row['vr_mesal'];
        $this->cliente->DbValue = $row['cliente'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idplanilha_custo` = @idplanilha_custo@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idplanilha_custo->CurrentValue : $this->idplanilha_custo->OldValue;
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
                $this->idplanilha_custo->CurrentValue = $keys[0];
            } else {
                $this->idplanilha_custo->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idplanilha_custo', $row) ? $row['idplanilha_custo'] : null;
        } else {
            $val = !EmptyValue($this->idplanilha_custo->OldValue) && !$current ? $this->idplanilha_custo->OldValue : $this->idplanilha_custo->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idplanilha_custo@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ViewUniformeCargoPlaCustoList");
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
            "ViewUniformeCargoPlaCustoView" => $Language->phrase("View"),
            "ViewUniformeCargoPlaCustoEdit" => $Language->phrase("Edit"),
            "ViewUniformeCargoPlaCustoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewUniformeCargoPlaCustoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewUniformeCargoPlaCustoView",
            Config("API_ADD_ACTION") => "ViewUniformeCargoPlaCustoAdd",
            Config("API_EDIT_ACTION") => "ViewUniformeCargoPlaCustoEdit",
            Config("API_DELETE_ACTION") => "ViewUniformeCargoPlaCustoDelete",
            Config("API_LIST_ACTION") => "ViewUniformeCargoPlaCustoList",
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
        return "ViewUniformeCargoPlaCustoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewUniformeCargoPlaCustoView", $parm);
        } else {
            $url = $this->keyUrl("ViewUniformeCargoPlaCustoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewUniformeCargoPlaCustoAdd?" . $parm;
        } else {
            $url = "ViewUniformeCargoPlaCustoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewUniformeCargoPlaCustoEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewUniformeCargoPlaCustoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewUniformeCargoPlaCustoAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewUniformeCargoPlaCustoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewUniformeCargoPlaCustoDelete", $parm);
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
        $json .= "\"idplanilha_custo\":" . VarToJson($this->idplanilha_custo->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idplanilha_custo->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idplanilha_custo->CurrentValue);
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
            if (($keyValue = Param("idplanilha_custo") ?? Route("idplanilha_custo")) !== null) {
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
                $this->idplanilha_custo->CurrentValue = $key;
            } else {
                $this->idplanilha_custo->OldValue = $key;
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
        $this->idplanilha_custo->setDbValue($row['idplanilha_custo']);
        $this->proposta_idproposta->setDbValue($row['proposta_idproposta']);
        $this->dt_proposta->setDbValue($row['dt_proposta']);
        $this->qtde_cargos->setDbValue($row['qtde_cargos']);
        $this->cargo_idcargo->setDbValue($row['cargo_idcargo']);
        $this->cargo->setDbValue($row['cargo']);
        $this->uniforme->setDbValue($row['uniforme']);
        $this->qtde->setDbValue($row['qtde']);
        $this->periodo_troca->setDbValue($row['periodo_troca']);
        $this->vr_unitario->setDbValue($row['vr_unitario']);
        $this->tipo_uniforme->setDbValue($row['tipo_uniforme']);
        $this->vr_anual->setDbValue($row['vr_anual']);
        $this->vr_mesal->setDbValue($row['vr_mesal']);
        $this->cliente->setDbValue($row['cliente']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewUniformeCargoPlaCustoList";
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

        // idplanilha_custo

        // proposta_idproposta

        // dt_proposta

        // qtde_cargos

        // cargo_idcargo

        // cargo

        // uniforme

        // qtde

        // periodo_troca

        // vr_unitario

        // tipo_uniforme

        // vr_anual

        // vr_mesal

        // cliente

        // idplanilha_custo
        $this->idplanilha_custo->ViewValue = $this->idplanilha_custo->CurrentValue;
        $this->idplanilha_custo->CssClass = "fw-bold";
        $this->idplanilha_custo->CellCssStyle .= "text-align: center;";

        // proposta_idproposta
        $this->proposta_idproposta->ViewValue = $this->proposta_idproposta->CurrentValue;
        $this->proposta_idproposta->ViewValue = FormatNumber($this->proposta_idproposta->ViewValue, $this->proposta_idproposta->formatPattern());
        $this->proposta_idproposta->CssClass = "fw-bold";
        $this->proposta_idproposta->CellCssStyle .= "text-align: center;";

        // dt_proposta
        $this->dt_proposta->ViewValue = $this->dt_proposta->CurrentValue;
        $this->dt_proposta->ViewValue = FormatDateTime($this->dt_proposta->ViewValue, $this->dt_proposta->formatPattern());
        $this->dt_proposta->CssClass = "fw-bold";

        // qtde_cargos
        $this->qtde_cargos->ViewValue = $this->qtde_cargos->CurrentValue;
        $this->qtde_cargos->ViewValue = FormatNumber($this->qtde_cargos->ViewValue, $this->qtde_cargos->formatPattern());
        $this->qtde_cargos->CssClass = "fw-bold";
        $this->qtde_cargos->CellCssStyle .= "text-align: right;";

        // cargo_idcargo
        $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->CurrentValue;
        $this->cargo_idcargo->ViewValue = FormatNumber($this->cargo_idcargo->ViewValue, $this->cargo_idcargo->formatPattern());
        $this->cargo_idcargo->CssClass = "fw-bold";

        // cargo
        $this->cargo->ViewValue = $this->cargo->CurrentValue;
        $this->cargo->CssClass = "fw-bold";

        // uniforme
        $this->uniforme->ViewValue = $this->uniforme->CurrentValue;
        $this->uniforme->CssClass = "fw-bold";

        // qtde
        $this->qtde->ViewValue = $this->qtde->CurrentValue;
        $this->qtde->ViewValue = FormatNumber($this->qtde->ViewValue, $this->qtde->formatPattern());
        $this->qtde->CssClass = "fw-bold";
        $this->qtde->CellCssStyle .= "text-align: right;";

        // periodo_troca
        $this->periodo_troca->ViewValue = $this->periodo_troca->CurrentValue;
        $this->periodo_troca->ViewValue = FormatNumber($this->periodo_troca->ViewValue, $this->periodo_troca->formatPattern());
        $this->periodo_troca->CssClass = "fw-bold";
        $this->periodo_troca->CellCssStyle .= "text-align: center;";

        // vr_unitario
        $this->vr_unitario->ViewValue = $this->vr_unitario->CurrentValue;
        $this->vr_unitario->ViewValue = FormatCurrency($this->vr_unitario->ViewValue, $this->vr_unitario->formatPattern());
        $this->vr_unitario->CssClass = "fw-bold";
        $this->vr_unitario->CellCssStyle .= "text-align: right;";

        // tipo_uniforme
        $this->tipo_uniforme->ViewValue = $this->tipo_uniforme->CurrentValue;
        $this->tipo_uniforme->CssClass = "fw-bold";

        // vr_anual
        $this->vr_anual->ViewValue = $this->vr_anual->CurrentValue;
        $this->vr_anual->ViewValue = FormatCurrency($this->vr_anual->ViewValue, $this->vr_anual->formatPattern());
        $this->vr_anual->CssClass = "fw-bold";
        $this->vr_anual->CellCssStyle .= "text-align: right;";

        // vr_mesal
        $this->vr_mesal->ViewValue = $this->vr_mesal->CurrentValue;
        $this->vr_mesal->ViewValue = FormatCurrency($this->vr_mesal->ViewValue, $this->vr_mesal->formatPattern());
        $this->vr_mesal->CssClass = "fw-bold";
        $this->vr_mesal->CellCssStyle .= "text-align: right;";

        // cliente
        $this->cliente->ViewValue = $this->cliente->CurrentValue;

        // idplanilha_custo
        $this->idplanilha_custo->HrefValue = "";
        $this->idplanilha_custo->TooltipValue = "";

        // proposta_idproposta
        $this->proposta_idproposta->HrefValue = "";
        $this->proposta_idproposta->TooltipValue = "";

        // dt_proposta
        $this->dt_proposta->HrefValue = "";
        $this->dt_proposta->TooltipValue = "";

        // qtde_cargos
        $this->qtde_cargos->HrefValue = "";
        $this->qtde_cargos->TooltipValue = "";

        // cargo_idcargo
        $this->cargo_idcargo->HrefValue = "";
        $this->cargo_idcargo->TooltipValue = "";

        // cargo
        $this->cargo->HrefValue = "";
        $this->cargo->TooltipValue = "";

        // uniforme
        $this->uniforme->HrefValue = "";
        $this->uniforme->TooltipValue = "";

        // qtde
        $this->qtde->HrefValue = "";
        $this->qtde->TooltipValue = "";

        // periodo_troca
        $this->periodo_troca->HrefValue = "";
        $this->periodo_troca->TooltipValue = "";

        // vr_unitario
        $this->vr_unitario->HrefValue = "";
        $this->vr_unitario->TooltipValue = "";

        // tipo_uniforme
        $this->tipo_uniforme->HrefValue = "";
        $this->tipo_uniforme->TooltipValue = "";

        // vr_anual
        $this->vr_anual->HrefValue = "";
        $this->vr_anual->TooltipValue = "";

        // vr_mesal
        $this->vr_mesal->HrefValue = "";
        $this->vr_mesal->TooltipValue = "";

        // cliente
        $this->cliente->HrefValue = "";
        $this->cliente->TooltipValue = "";

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

        // idplanilha_custo
        $this->idplanilha_custo->setupEditAttributes();
        $this->idplanilha_custo->EditValue = $this->idplanilha_custo->CurrentValue;
        $this->idplanilha_custo->CssClass = "fw-bold";
        $this->idplanilha_custo->CellCssStyle .= "text-align: center;";

        // proposta_idproposta
        $this->proposta_idproposta->setupEditAttributes();
        $this->proposta_idproposta->EditValue = $this->proposta_idproposta->CurrentValue;
        $this->proposta_idproposta->PlaceHolder = RemoveHtml($this->proposta_idproposta->caption());
        if (strval($this->proposta_idproposta->EditValue) != "" && is_numeric($this->proposta_idproposta->EditValue)) {
            $this->proposta_idproposta->EditValue = FormatNumber($this->proposta_idproposta->EditValue, null);
        }

        // dt_proposta
        $this->dt_proposta->setupEditAttributes();
        $this->dt_proposta->EditValue = FormatDateTime($this->dt_proposta->CurrentValue, $this->dt_proposta->formatPattern());
        $this->dt_proposta->PlaceHolder = RemoveHtml($this->dt_proposta->caption());

        // qtde_cargos
        $this->qtde_cargos->setupEditAttributes();
        $this->qtde_cargos->EditValue = $this->qtde_cargos->CurrentValue;
        $this->qtde_cargos->PlaceHolder = RemoveHtml($this->qtde_cargos->caption());
        if (strval($this->qtde_cargos->EditValue) != "" && is_numeric($this->qtde_cargos->EditValue)) {
            $this->qtde_cargos->EditValue = FormatNumber($this->qtde_cargos->EditValue, null);
        }

        // cargo_idcargo
        $this->cargo_idcargo->setupEditAttributes();
        $this->cargo_idcargo->EditValue = $this->cargo_idcargo->CurrentValue;
        $this->cargo_idcargo->PlaceHolder = RemoveHtml($this->cargo_idcargo->caption());
        if (strval($this->cargo_idcargo->EditValue) != "" && is_numeric($this->cargo_idcargo->EditValue)) {
            $this->cargo_idcargo->EditValue = FormatNumber($this->cargo_idcargo->EditValue, null);
        }

        // cargo
        $this->cargo->setupEditAttributes();
        if (!$this->cargo->Raw) {
            $this->cargo->CurrentValue = HtmlDecode($this->cargo->CurrentValue);
        }
        $this->cargo->EditValue = $this->cargo->CurrentValue;
        $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

        // uniforme
        $this->uniforme->setupEditAttributes();
        if (!$this->uniforme->Raw) {
            $this->uniforme->CurrentValue = HtmlDecode($this->uniforme->CurrentValue);
        }
        $this->uniforme->EditValue = $this->uniforme->CurrentValue;
        $this->uniforme->PlaceHolder = RemoveHtml($this->uniforme->caption());

        // qtde
        $this->qtde->setupEditAttributes();
        $this->qtde->EditValue = $this->qtde->CurrentValue;
        $this->qtde->PlaceHolder = RemoveHtml($this->qtde->caption());
        if (strval($this->qtde->EditValue) != "" && is_numeric($this->qtde->EditValue)) {
            $this->qtde->EditValue = FormatNumber($this->qtde->EditValue, null);
        }

        // periodo_troca
        $this->periodo_troca->setupEditAttributes();
        $this->periodo_troca->EditValue = $this->periodo_troca->CurrentValue;
        $this->periodo_troca->PlaceHolder = RemoveHtml($this->periodo_troca->caption());
        if (strval($this->periodo_troca->EditValue) != "" && is_numeric($this->periodo_troca->EditValue)) {
            $this->periodo_troca->EditValue = FormatNumber($this->periodo_troca->EditValue, null);
        }

        // vr_unitario
        $this->vr_unitario->setupEditAttributes();
        $this->vr_unitario->EditValue = $this->vr_unitario->CurrentValue;
        $this->vr_unitario->PlaceHolder = RemoveHtml($this->vr_unitario->caption());
        if (strval($this->vr_unitario->EditValue) != "" && is_numeric($this->vr_unitario->EditValue)) {
            $this->vr_unitario->EditValue = FormatNumber($this->vr_unitario->EditValue, null);
        }

        // tipo_uniforme
        $this->tipo_uniforme->setupEditAttributes();
        if (!$this->tipo_uniforme->Raw) {
            $this->tipo_uniforme->CurrentValue = HtmlDecode($this->tipo_uniforme->CurrentValue);
        }
        $this->tipo_uniforme->EditValue = $this->tipo_uniforme->CurrentValue;
        $this->tipo_uniforme->PlaceHolder = RemoveHtml($this->tipo_uniforme->caption());

        // vr_anual
        $this->vr_anual->setupEditAttributes();
        $this->vr_anual->EditValue = $this->vr_anual->CurrentValue;
        $this->vr_anual->PlaceHolder = RemoveHtml($this->vr_anual->caption());
        if (strval($this->vr_anual->EditValue) != "" && is_numeric($this->vr_anual->EditValue)) {
            $this->vr_anual->EditValue = FormatNumber($this->vr_anual->EditValue, null);
        }

        // vr_mesal
        $this->vr_mesal->setupEditAttributes();
        $this->vr_mesal->EditValue = $this->vr_mesal->CurrentValue;
        $this->vr_mesal->PlaceHolder = RemoveHtml($this->vr_mesal->caption());
        if (strval($this->vr_mesal->EditValue) != "" && is_numeric($this->vr_mesal->EditValue)) {
            $this->vr_mesal->EditValue = FormatNumber($this->vr_mesal->EditValue, null);
        }

        // cliente
        $this->cliente->setupEditAttributes();
        if (!$this->cliente->Raw) {
            $this->cliente->CurrentValue = HtmlDecode($this->cliente->CurrentValue);
        }
        $this->cliente->EditValue = $this->cliente->CurrentValue;
        $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            if (is_numeric($this->qtde->CurrentValue)) {
                $this->qtde->Total += $this->qtde->CurrentValue; // Accumulate total
            }
            if (is_numeric($this->vr_anual->CurrentValue)) {
                $this->vr_anual->Total += $this->vr_anual->CurrentValue; // Accumulate total
            }
            if (is_numeric($this->vr_mesal->CurrentValue)) {
                $this->vr_mesal->Total += $this->vr_mesal->CurrentValue; // Accumulate total
            }
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->qtde->CurrentValue = $this->qtde->Total;
            $this->qtde->ViewValue = $this->qtde->CurrentValue;
            $this->qtde->ViewValue = FormatNumber($this->qtde->ViewValue, $this->qtde->formatPattern());
            $this->qtde->CssClass = "fw-bold";
            $this->qtde->CellCssStyle .= "text-align: right;";
            $this->qtde->HrefValue = ""; // Clear href value
            $this->vr_anual->CurrentValue = $this->vr_anual->Total;
            $this->vr_anual->ViewValue = $this->vr_anual->CurrentValue;
            $this->vr_anual->ViewValue = FormatCurrency($this->vr_anual->ViewValue, $this->vr_anual->formatPattern());
            $this->vr_anual->CssClass = "fw-bold";
            $this->vr_anual->CellCssStyle .= "text-align: right;";
            $this->vr_anual->HrefValue = ""; // Clear href value
            $this->vr_mesal->CurrentValue = $this->vr_mesal->Total;
            $this->vr_mesal->ViewValue = $this->vr_mesal->CurrentValue;
            $this->vr_mesal->ViewValue = FormatCurrency($this->vr_mesal->ViewValue, $this->vr_mesal->formatPattern());
            $this->vr_mesal->CssClass = "fw-bold";
            $this->vr_mesal->CellCssStyle .= "text-align: right;";
            $this->vr_mesal->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->idplanilha_custo);
                    $doc->exportCaption($this->proposta_idproposta);
                    $doc->exportCaption($this->dt_proposta);
                    $doc->exportCaption($this->qtde_cargos);
                    $doc->exportCaption($this->cargo_idcargo);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->uniforme);
                    $doc->exportCaption($this->qtde);
                    $doc->exportCaption($this->periodo_troca);
                    $doc->exportCaption($this->vr_unitario);
                    $doc->exportCaption($this->tipo_uniforme);
                    $doc->exportCaption($this->vr_anual);
                    $doc->exportCaption($this->vr_mesal);
                    $doc->exportCaption($this->cliente);
                } else {
                    $doc->exportCaption($this->idplanilha_custo);
                    $doc->exportCaption($this->proposta_idproposta);
                    $doc->exportCaption($this->dt_proposta);
                    $doc->exportCaption($this->qtde_cargos);
                    $doc->exportCaption($this->cargo_idcargo);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->uniforme);
                    $doc->exportCaption($this->qtde);
                    $doc->exportCaption($this->periodo_troca);
                    $doc->exportCaption($this->vr_unitario);
                    $doc->exportCaption($this->tipo_uniforme);
                    $doc->exportCaption($this->vr_anual);
                    $doc->exportCaption($this->vr_mesal);
                    $doc->exportCaption($this->cliente);
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
                        $doc->exportField($this->idplanilha_custo);
                        $doc->exportField($this->proposta_idproposta);
                        $doc->exportField($this->dt_proposta);
                        $doc->exportField($this->qtde_cargos);
                        $doc->exportField($this->cargo_idcargo);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->uniforme);
                        $doc->exportField($this->qtde);
                        $doc->exportField($this->periodo_troca);
                        $doc->exportField($this->vr_unitario);
                        $doc->exportField($this->tipo_uniforme);
                        $doc->exportField($this->vr_anual);
                        $doc->exportField($this->vr_mesal);
                        $doc->exportField($this->cliente);
                    } else {
                        $doc->exportField($this->idplanilha_custo);
                        $doc->exportField($this->proposta_idproposta);
                        $doc->exportField($this->dt_proposta);
                        $doc->exportField($this->qtde_cargos);
                        $doc->exportField($this->cargo_idcargo);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->uniforme);
                        $doc->exportField($this->qtde);
                        $doc->exportField($this->periodo_troca);
                        $doc->exportField($this->vr_unitario);
                        $doc->exportField($this->tipo_uniforme);
                        $doc->exportField($this->vr_anual);
                        $doc->exportField($this->vr_mesal);
                        $doc->exportField($this->cliente);
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
                $doc->exportAggregate($this->idplanilha_custo, '');
                $doc->exportAggregate($this->proposta_idproposta, '');
                $doc->exportAggregate($this->dt_proposta, '');
                $doc->exportAggregate($this->qtde_cargos, '');
                $doc->exportAggregate($this->cargo_idcargo, '');
                $doc->exportAggregate($this->cargo, '');
                $doc->exportAggregate($this->uniforme, '');
                $doc->exportAggregate($this->qtde, 'TOTAL');
                $doc->exportAggregate($this->periodo_troca, '');
                $doc->exportAggregate($this->vr_unitario, '');
                $doc->exportAggregate($this->tipo_uniforme, '');
                $doc->exportAggregate($this->vr_anual, 'TOTAL');
                $doc->exportAggregate($this->vr_mesal, 'TOTAL');
                $doc->exportAggregate($this->cliente, '');
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
