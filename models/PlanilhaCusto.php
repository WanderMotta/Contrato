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
 * Table class for planilha_custo
 */
class PlanilhaCusto extends DbTable
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
    public $dt_cadastro;
    public $escala_idescala;
    public $periodo_idperiodo;
    public $tipo_intrajornada_idtipo_intrajornada;
    public $cargo_idcargo;
    public $acumulo_funcao;
    public $quantidade;
    public $usuario_idusuario;
    public $calculo_idcalculo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "planilha_custo";
        $this->TableName = 'planilha_custo';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "planilha_custo";
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
        $this->idplanilha_custo->IsForeignKey = true; // Foreign key field
        $this->idplanilha_custo->Nullable = false; // NOT NULL field
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
        $this->proposta_idproposta->IsForeignKey = true; // Foreign key field
        $this->proposta_idproposta->Nullable = false; // NOT NULL field
        $this->proposta_idproposta->Required = true; // Required field
        $this->proposta_idproposta->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proposta_idproposta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['proposta_idproposta'] = &$this->proposta_idproposta;

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

        // escala_idescala
        $this->escala_idescala = new DbField(
            $this, // Table
            'x_escala_idescala', // Variable name
            'escala_idescala', // Name
            '`escala_idescala`', // Expression
            '`escala_idescala`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`escala_idescala`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->escala_idescala->InputTextType = "text";
        $this->escala_idescala->Raw = true;
        $this->escala_idescala->Nullable = false; // NOT NULL field
        $this->escala_idescala->Required = true; // Required field
        $this->escala_idescala->Lookup = new Lookup($this->escala_idescala, 'escala', false, 'idescala', ["escala","","",""], '', '', [], ["x_cargo_idcargo"], [], [], [], [], false, '', '', "`escala`");
        $this->escala_idescala->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->escala_idescala->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['escala_idescala'] = &$this->escala_idescala;

        // periodo_idperiodo
        $this->periodo_idperiodo = new DbField(
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
            'RADIO' // Edit Tag
        );
        $this->periodo_idperiodo->InputTextType = "text";
        $this->periodo_idperiodo->Raw = true;
        $this->periodo_idperiodo->Nullable = false; // NOT NULL field
        $this->periodo_idperiodo->Required = true; // Required field
        $this->periodo_idperiodo->Lookup = new Lookup($this->periodo_idperiodo, 'periodo', false, 'idperiodo', ["periodo","","",""], '', '', [], ["x_cargo_idcargo"], [], [], [], [], false, '', '', "`periodo`");
        $this->periodo_idperiodo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->periodo_idperiodo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['periodo_idperiodo'] = &$this->periodo_idperiodo;

        // tipo_intrajornada_idtipo_intrajornada
        $this->tipo_intrajornada_idtipo_intrajornada = new DbField(
            $this, // Table
            'x_tipo_intrajornada_idtipo_intrajornada', // Variable name
            'tipo_intrajornada_idtipo_intrajornada', // Name
            '`tipo_intrajornada_idtipo_intrajornada`', // Expression
            '`tipo_intrajornada_idtipo_intrajornada`', // Basic search expression
            19, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_intrajornada_idtipo_intrajornada`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->tipo_intrajornada_idtipo_intrajornada->addMethod("getDefault", fn() => 1);
        $this->tipo_intrajornada_idtipo_intrajornada->InputTextType = "text";
        $this->tipo_intrajornada_idtipo_intrajornada->Raw = true;
        $this->tipo_intrajornada_idtipo_intrajornada->Nullable = false; // NOT NULL field
        $this->tipo_intrajornada_idtipo_intrajornada->Lookup = new Lookup($this->tipo_intrajornada_idtipo_intrajornada, 'tipo_intrajornada', false, 'idtipo_intrajornada', ["intrajornada_tipo","","",""], '', '', [], [], [], [], [], [], false, '', '', "`intrajornada_tipo`");
        $this->tipo_intrajornada_idtipo_intrajornada->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipo_intrajornada_idtipo_intrajornada->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tipo_intrajornada_idtipo_intrajornada'] = &$this->tipo_intrajornada_idtipo_intrajornada;

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
            'SELECT' // Edit Tag
        );
        $this->cargo_idcargo->InputTextType = "text";
        $this->cargo_idcargo->Raw = true;
        $this->cargo_idcargo->Nullable = false; // NOT NULL field
        $this->cargo_idcargo->Required = true; // Required field
        $this->cargo_idcargo->setSelectMultiple(false); // Select one
        $this->cargo_idcargo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cargo_idcargo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->cargo_idcargo->Lookup = new Lookup($this->cargo_idcargo, 'cargo', false, 'idcargo', ["cargo","salario","",""], '', '', ["x_periodo_idperiodo","x_escala_idescala"], [], ["periodo_idperiodo","escala_idescala"], ["x_periodo_idperiodo","x_escala_idescala"], [], [], false, '`cargo` ASC', '', "CONCAT(COALESCE(`cargo`, ''),'" . ValueSeparator(1, $this->cargo_idcargo) . "',COALESCE(`salario`,''))");
        $this->cargo_idcargo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cargo_idcargo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['cargo_idcargo'] = &$this->cargo_idcargo;

        // acumulo_funcao
        $this->acumulo_funcao = new DbField(
            $this, // Table
            'x_acumulo_funcao', // Variable name
            'acumulo_funcao', // Name
            '`acumulo_funcao`', // Expression
            '`acumulo_funcao`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`acumulo_funcao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->acumulo_funcao->addMethod("getDefault", fn() => "Nao");
        $this->acumulo_funcao->InputTextType = "text";
        $this->acumulo_funcao->Raw = true;
        $this->acumulo_funcao->Nullable = false; // NOT NULL field
        $this->acumulo_funcao->Lookup = new Lookup($this->acumulo_funcao, 'planilha_custo', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->acumulo_funcao->OptionCount = 2;
        $this->acumulo_funcao->SearchOperators = ["=", "<>"];
        $this->Fields['acumulo_funcao'] = &$this->acumulo_funcao;

        // quantidade
        $this->quantidade = new DbField(
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
        $this->Fields['quantidade'] = &$this->quantidade;

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

        // calculo_idcalculo
        $this->calculo_idcalculo = new DbField(
            $this, // Table
            'x_calculo_idcalculo', // Variable name
            'calculo_idcalculo', // Name
            '`calculo_idcalculo`', // Expression
            '`calculo_idcalculo`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`calculo_idcalculo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->calculo_idcalculo->InputTextType = "text";
        $this->calculo_idcalculo->Raw = true;
        $this->calculo_idcalculo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->calculo_idcalculo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['calculo_idcalculo'] = &$this->calculo_idcalculo;

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
        if ($this->getCurrentDetailTable() == "movimento_pla_custo") {
            $detailUrl = Container("movimento_pla_custo")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idplanilha_custo", $this->idplanilha_custo->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "PlanilhaCustoList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "planilha_custo";
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
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->escala_idescala->DbValue = $row['escala_idescala'];
        $this->periodo_idperiodo->DbValue = $row['periodo_idperiodo'];
        $this->tipo_intrajornada_idtipo_intrajornada->DbValue = $row['tipo_intrajornada_idtipo_intrajornada'];
        $this->cargo_idcargo->DbValue = $row['cargo_idcargo'];
        $this->acumulo_funcao->DbValue = $row['acumulo_funcao'];
        $this->quantidade->DbValue = $row['quantidade'];
        $this->usuario_idusuario->DbValue = $row['usuario_idusuario'];
        $this->calculo_idcalculo->DbValue = $row['calculo_idcalculo'];
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
        return $_SESSION[$name] ?? GetUrl("PlanilhaCustoList");
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
            "PlanilhaCustoView" => $Language->phrase("View"),
            "PlanilhaCustoEdit" => $Language->phrase("Edit"),
            "PlanilhaCustoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "PlanilhaCustoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "PlanilhaCustoView",
            Config("API_ADD_ACTION") => "PlanilhaCustoAdd",
            Config("API_EDIT_ACTION") => "PlanilhaCustoEdit",
            Config("API_DELETE_ACTION") => "PlanilhaCustoDelete",
            Config("API_LIST_ACTION") => "PlanilhaCustoList",
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
        return "PlanilhaCustoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PlanilhaCustoView", $parm);
        } else {
            $url = $this->keyUrl("PlanilhaCustoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "PlanilhaCustoAdd?" . $parm;
        } else {
            $url = "PlanilhaCustoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PlanilhaCustoEdit", $parm);
        } else {
            $url = $this->keyUrl("PlanilhaCustoEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("PlanilhaCustoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PlanilhaCustoAdd", $parm);
        } else {
            $url = $this->keyUrl("PlanilhaCustoAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("PlanilhaCustoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("PlanilhaCustoDelete", $parm);
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
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->escala_idescala->setDbValue($row['escala_idescala']);
        $this->periodo_idperiodo->setDbValue($row['periodo_idperiodo']);
        $this->tipo_intrajornada_idtipo_intrajornada->setDbValue($row['tipo_intrajornada_idtipo_intrajornada']);
        $this->cargo_idcargo->setDbValue($row['cargo_idcargo']);
        $this->acumulo_funcao->setDbValue($row['acumulo_funcao']);
        $this->quantidade->setDbValue($row['quantidade']);
        $this->usuario_idusuario->setDbValue($row['usuario_idusuario']);
        $this->calculo_idcalculo->setDbValue($row['calculo_idcalculo']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "PlanilhaCustoList";
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

        // dt_cadastro

        // escala_idescala

        // periodo_idperiodo

        // tipo_intrajornada_idtipo_intrajornada

        // cargo_idcargo

        // acumulo_funcao

        // quantidade

        // usuario_idusuario

        // calculo_idcalculo

        // idplanilha_custo
        $this->idplanilha_custo->ViewValue = $this->idplanilha_custo->CurrentValue;
        $this->idplanilha_custo->CssClass = "fw-bold";
        $this->idplanilha_custo->CellCssStyle .= "text-align: center;";

        // proposta_idproposta
        $this->proposta_idproposta->ViewValue = $this->proposta_idproposta->CurrentValue;
        $this->proposta_idproposta->ViewValue = FormatNumber($this->proposta_idproposta->ViewValue, $this->proposta_idproposta->formatPattern());
        $this->proposta_idproposta->CssClass = "fw-bold";
        $this->proposta_idproposta->CellCssStyle .= "text-align: center;";

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->CssClass = "fw-bold";

        // escala_idescala
        $curVal = strval($this->escala_idescala->CurrentValue);
        if ($curVal != "") {
            $this->escala_idescala->ViewValue = $this->escala_idescala->lookupCacheOption($curVal);
            if ($this->escala_idescala->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->escala_idescala->Lookup->getTable()->Fields["idescala"]->searchExpression(), "=", $curVal, $this->escala_idescala->Lookup->getTable()->Fields["idescala"]->searchDataType(), "");
                $sqlWrk = $this->escala_idescala->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->escala_idescala->Lookup->renderViewRow($rswrk[0]);
                    $this->escala_idescala->ViewValue = $this->escala_idescala->displayValue($arwrk);
                } else {
                    $this->escala_idescala->ViewValue = FormatNumber($this->escala_idescala->CurrentValue, $this->escala_idescala->formatPattern());
                }
            }
        } else {
            $this->escala_idescala->ViewValue = null;
        }
        $this->escala_idescala->CssClass = "fw-bold";

        // periodo_idperiodo
        $curVal = strval($this->periodo_idperiodo->CurrentValue);
        if ($curVal != "") {
            $this->periodo_idperiodo->ViewValue = $this->periodo_idperiodo->lookupCacheOption($curVal);
            if ($this->periodo_idperiodo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->periodo_idperiodo->Lookup->getTable()->Fields["idperiodo"]->searchExpression(), "=", $curVal, $this->periodo_idperiodo->Lookup->getTable()->Fields["idperiodo"]->searchDataType(), "");
                $sqlWrk = $this->periodo_idperiodo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->periodo_idperiodo->Lookup->renderViewRow($rswrk[0]);
                    $this->periodo_idperiodo->ViewValue = $this->periodo_idperiodo->displayValue($arwrk);
                } else {
                    $this->periodo_idperiodo->ViewValue = FormatNumber($this->periodo_idperiodo->CurrentValue, $this->periodo_idperiodo->formatPattern());
                }
            }
        } else {
            $this->periodo_idperiodo->ViewValue = null;
        }
        $this->periodo_idperiodo->CssClass = "fw-bold";

        // tipo_intrajornada_idtipo_intrajornada
        $curVal = strval($this->tipo_intrajornada_idtipo_intrajornada->CurrentValue);
        if ($curVal != "") {
            $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = $this->tipo_intrajornada_idtipo_intrajornada->lookupCacheOption($curVal);
            if ($this->tipo_intrajornada_idtipo_intrajornada->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipo_intrajornada_idtipo_intrajornada->Lookup->getTable()->Fields["idtipo_intrajornada"]->searchExpression(), "=", $curVal, $this->tipo_intrajornada_idtipo_intrajornada->Lookup->getTable()->Fields["idtipo_intrajornada"]->searchDataType(), "");
                $sqlWrk = $this->tipo_intrajornada_idtipo_intrajornada->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_intrajornada_idtipo_intrajornada->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = $this->tipo_intrajornada_idtipo_intrajornada->displayValue($arwrk);
                } else {
                    $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = FormatNumber($this->tipo_intrajornada_idtipo_intrajornada->CurrentValue, $this->tipo_intrajornada_idtipo_intrajornada->formatPattern());
                }
            }
        } else {
            $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = null;
        }
        $this->tipo_intrajornada_idtipo_intrajornada->CssClass = "fw-bold";

        // cargo_idcargo
        $curVal = strval($this->cargo_idcargo->CurrentValue);
        if ($curVal != "") {
            $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->lookupCacheOption($curVal);
            if ($this->cargo_idcargo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->cargo_idcargo->Lookup->getTable()->Fields["idcargo"]->searchExpression(), "=", $curVal, $this->cargo_idcargo->Lookup->getTable()->Fields["idcargo"]->searchDataType(), "");
                $sqlWrk = $this->cargo_idcargo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->cargo_idcargo->Lookup->renderViewRow($rswrk[0]);
                    $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->displayValue($arwrk);
                } else {
                    $this->cargo_idcargo->ViewValue = FormatNumber($this->cargo_idcargo->CurrentValue, $this->cargo_idcargo->formatPattern());
                }
            }
        } else {
            $this->cargo_idcargo->ViewValue = null;
        }
        $this->cargo_idcargo->CssClass = "fw-bold";

        // acumulo_funcao
        if (strval($this->acumulo_funcao->CurrentValue) != "") {
            $this->acumulo_funcao->ViewValue = $this->acumulo_funcao->optionCaption($this->acumulo_funcao->CurrentValue);
        } else {
            $this->acumulo_funcao->ViewValue = null;
        }
        $this->acumulo_funcao->CssClass = "fw-bold";
        $this->acumulo_funcao->CellCssStyle .= "text-align: center;";

        // quantidade
        $this->quantidade->ViewValue = $this->quantidade->CurrentValue;
        $this->quantidade->ViewValue = FormatNumber($this->quantidade->ViewValue, $this->quantidade->formatPattern());
        $this->quantidade->CssClass = "fw-bold";
        $this->quantidade->CellCssStyle .= "text-align: center;";

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

        // calculo_idcalculo
        $this->calculo_idcalculo->ViewValue = $this->calculo_idcalculo->CurrentValue;
        $this->calculo_idcalculo->ViewValue = FormatNumber($this->calculo_idcalculo->ViewValue, $this->calculo_idcalculo->formatPattern());

        // idplanilha_custo
        $this->idplanilha_custo->HrefValue = "";
        $this->idplanilha_custo->TooltipValue = "";

        // proposta_idproposta
        $this->proposta_idproposta->HrefValue = "";
        $this->proposta_idproposta->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // escala_idescala
        $this->escala_idescala->HrefValue = "";
        $this->escala_idescala->TooltipValue = "";

        // periodo_idperiodo
        $this->periodo_idperiodo->HrefValue = "";
        $this->periodo_idperiodo->TooltipValue = "";

        // tipo_intrajornada_idtipo_intrajornada
        $this->tipo_intrajornada_idtipo_intrajornada->HrefValue = "";
        $this->tipo_intrajornada_idtipo_intrajornada->TooltipValue = "";

        // cargo_idcargo
        $this->cargo_idcargo->HrefValue = "";
        $this->cargo_idcargo->TooltipValue = "";

        // acumulo_funcao
        $this->acumulo_funcao->HrefValue = "";
        $this->acumulo_funcao->TooltipValue = "";

        // quantidade
        $this->quantidade->HrefValue = "";
        $this->quantidade->TooltipValue = "";

        // usuario_idusuario
        $this->usuario_idusuario->HrefValue = "";
        $this->usuario_idusuario->TooltipValue = "";

        // calculo_idcalculo
        $this->calculo_idcalculo->HrefValue = "";
        $this->calculo_idcalculo->TooltipValue = "";

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
        if ($this->proposta_idproposta->getSessionValue() != "") {
            $this->proposta_idproposta->CurrentValue = GetForeignKeyValue($this->proposta_idproposta->getSessionValue());
            $this->proposta_idproposta->ViewValue = $this->proposta_idproposta->CurrentValue;
            $this->proposta_idproposta->ViewValue = FormatNumber($this->proposta_idproposta->ViewValue, $this->proposta_idproposta->formatPattern());
            $this->proposta_idproposta->CssClass = "fw-bold";
            $this->proposta_idproposta->CellCssStyle .= "text-align: center;";
        } else {
            $this->proposta_idproposta->EditValue = $this->proposta_idproposta->CurrentValue;
            $this->proposta_idproposta->PlaceHolder = RemoveHtml($this->proposta_idproposta->caption());
            if (strval($this->proposta_idproposta->EditValue) != "" && is_numeric($this->proposta_idproposta->EditValue)) {
                $this->proposta_idproposta->EditValue = FormatNumber($this->proposta_idproposta->EditValue, null);
            }
        }

        // dt_cadastro

        // escala_idescala
        $this->escala_idescala->PlaceHolder = RemoveHtml($this->escala_idescala->caption());

        // periodo_idperiodo
        $this->periodo_idperiodo->PlaceHolder = RemoveHtml($this->periodo_idperiodo->caption());

        // tipo_intrajornada_idtipo_intrajornada
        $this->tipo_intrajornada_idtipo_intrajornada->PlaceHolder = RemoveHtml($this->tipo_intrajornada_idtipo_intrajornada->caption());

        // cargo_idcargo
        $this->cargo_idcargo->setupEditAttributes();
        $this->cargo_idcargo->PlaceHolder = RemoveHtml($this->cargo_idcargo->caption());

        // acumulo_funcao
        $this->acumulo_funcao->EditValue = $this->acumulo_funcao->options(false);
        $this->acumulo_funcao->PlaceHolder = RemoveHtml($this->acumulo_funcao->caption());

        // quantidade
        $this->quantidade->setupEditAttributes();
        $this->quantidade->EditValue = $this->quantidade->CurrentValue;
        $this->quantidade->PlaceHolder = RemoveHtml($this->quantidade->caption());
        if (strval($this->quantidade->EditValue) != "" && is_numeric($this->quantidade->EditValue)) {
            $this->quantidade->EditValue = FormatNumber($this->quantidade->EditValue, null);
        }

        // usuario_idusuario

        // calculo_idcalculo
        $this->calculo_idcalculo->setupEditAttributes();
        $this->calculo_idcalculo->EditValue = $this->calculo_idcalculo->CurrentValue;
        $this->calculo_idcalculo->EditValue = FormatNumber($this->calculo_idcalculo->EditValue, $this->calculo_idcalculo->formatPattern());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            if (is_numeric($this->quantidade->CurrentValue)) {
                $this->quantidade->Total += $this->quantidade->CurrentValue; // Accumulate total
            }
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->quantidade->CurrentValue = $this->quantidade->Total;
            $this->quantidade->ViewValue = $this->quantidade->CurrentValue;
            $this->quantidade->ViewValue = FormatNumber($this->quantidade->ViewValue, $this->quantidade->formatPattern());
            $this->quantidade->CssClass = "fw-bold";
            $this->quantidade->CellCssStyle .= "text-align: center;";
            $this->quantidade->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->escala_idescala);
                    $doc->exportCaption($this->periodo_idperiodo);
                    $doc->exportCaption($this->tipo_intrajornada_idtipo_intrajornada);
                    $doc->exportCaption($this->cargo_idcargo);
                    $doc->exportCaption($this->acumulo_funcao);
                    $doc->exportCaption($this->quantidade);
                    $doc->exportCaption($this->usuario_idusuario);
                    $doc->exportCaption($this->calculo_idcalculo);
                } else {
                    $doc->exportCaption($this->idplanilha_custo);
                    $doc->exportCaption($this->proposta_idproposta);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->escala_idescala);
                    $doc->exportCaption($this->periodo_idperiodo);
                    $doc->exportCaption($this->tipo_intrajornada_idtipo_intrajornada);
                    $doc->exportCaption($this->cargo_idcargo);
                    $doc->exportCaption($this->acumulo_funcao);
                    $doc->exportCaption($this->quantidade);
                    $doc->exportCaption($this->usuario_idusuario);
                    $doc->exportCaption($this->calculo_idcalculo);
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
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->escala_idescala);
                        $doc->exportField($this->periodo_idperiodo);
                        $doc->exportField($this->tipo_intrajornada_idtipo_intrajornada);
                        $doc->exportField($this->cargo_idcargo);
                        $doc->exportField($this->acumulo_funcao);
                        $doc->exportField($this->quantidade);
                        $doc->exportField($this->usuario_idusuario);
                        $doc->exportField($this->calculo_idcalculo);
                    } else {
                        $doc->exportField($this->idplanilha_custo);
                        $doc->exportField($this->proposta_idproposta);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->escala_idescala);
                        $doc->exportField($this->periodo_idperiodo);
                        $doc->exportField($this->tipo_intrajornada_idtipo_intrajornada);
                        $doc->exportField($this->cargo_idcargo);
                        $doc->exportField($this->acumulo_funcao);
                        $doc->exportField($this->quantidade);
                        $doc->exportField($this->usuario_idusuario);
                        $doc->exportField($this->calculo_idcalculo);
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
                $doc->exportAggregate($this->dt_cadastro, '');
                $doc->exportAggregate($this->escala_idescala, '');
                $doc->exportAggregate($this->periodo_idperiodo, '');
                $doc->exportAggregate($this->tipo_intrajornada_idtipo_intrajornada, '');
                $doc->exportAggregate($this->cargo_idcargo, '');
                $doc->exportAggregate($this->acumulo_funcao, '');
                $doc->exportAggregate($this->quantidade, 'TOTAL');
                $doc->exportAggregate($this->usuario_idusuario, '');
                $doc->exportAggregate($this->calculo_idcalculo, '');
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
