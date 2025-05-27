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
 * Page class
 */
class PlanilhaCustoGrid extends PlanilhaCusto
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "PlanilhaCustoGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fplanilha_custogrid";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "PlanilhaCustoGrid";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<div id="ew-page-header">' . $header . '</div>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<div id="ew-page-footer">' . $footer . '</div>';
        }
    }

    // Set field visibility
    public function setVisibility()
    {
        $this->idplanilha_custo->setVisibility();
        $this->proposta_idproposta->setVisibility();
        $this->dt_cadastro->Visible = false;
        $this->escala_idescala->setVisibility();
        $this->periodo_idperiodo->setVisibility();
        $this->tipo_intrajornada_idtipo_intrajornada->setVisibility();
        $this->cargo_idcargo->setVisibility();
        $this->acumulo_funcao->setVisibility();
        $this->quantidade->setVisibility();
        $this->usuario_idusuario->Visible = false;
        $this->calculo_idcalculo->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'planilha_custo';
        $this->TableName = 'planilha_custo';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->TableGridClass, $this->ContextClass);

        // Fixed header table
        if (!$this->UseCustomTemplate) {
            $this->setFixedHeaderTable(Config("USE_FIXED_HEADER_TABLE"), Config("FIXED_HEADER_TABLE_HEIGHT"));
        }

        // Initialize
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (planilha_custo)
        if (!isset($GLOBALS["planilha_custo"]) || $GLOBALS["planilha_custo"]::class == PROJECT_NAMESPACE . "planilha_custo") {
            $GLOBALS["planilha_custo"] = &$this;
        }
        $this->AddUrl = "PlanilhaCustoAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'planilha_custo');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions(Tag: "td", TableVar: $this->TableVar);

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions(
            TagClassName: "ew-add-edit-option",
            UseDropDownButton: false,
            DropDownButtonPhrase: $Language->phrase("ButtonAddEdit"),
            UseButtonGroup: true
        );
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return $Response?->getBody() ?? ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (WithJsonResponse()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from result set
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Result set
            while ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($row);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DataType::BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['idplanilha_custo'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->idplanilha_custo->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->dt_cadastro->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->usuario_idusuario->Visible = false;
        }
    }

    // Lookup data
    public function lookup(array $req = [], bool $response = true)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $req["field"] ?? null;
        if (!$fieldName) {
            return [];
        }
        $fld = $this->Fields[$fieldName];
        $lookup = $fld->Lookup;
        $name = $req["name"] ?? "";
        if (ContainsString($name, "query_builder_rule")) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $req["ajax"] ?? "unknown";
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $req["q"] ?? $req["sv"] ?? "";
            $pageSize = $req["n"] ?? $req["recperpage"] ?? 10;
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $req["q"] ?? "";
            $pageSize = $req["n"] ?? -1;
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $req["start"] ?? -1;
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $req["page"] ?? -1;
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($req["s"] ?? "");
        $userFilter = Decrypt($req["f"] ?? "");
        $userOrderBy = Decrypt($req["o"] ?? "");
        $keys = $req["keys"] ?? null;
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $req["v0"] ?? $req["lookupValue"] ?? "";
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $req["v" . $i] ?? "";
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, $response); // Use settings from current page
    }

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $HeaderOptions; // Header options
    public $FooterOptions; // Footer options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $ShowOtherOptions = false;
    public $DisplayRecords = 50;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $InlineRowCount = 0;
    public $StartRowCount = 1;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $MultiColumnGridClass = "row-cols-md";
    public $MultiColumnEditClass = "col-12 w-100";
    public $MultiColumnCardClass = "card h-100 ew-card";
    public $MultiColumnListOptionsPosition = "bottom-start";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $UserAction; // User action
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $PageAction;
    public $RecKeys = [];
    public $IsModal = false;
    protected $FilterForModalActions = "";
    private $UseInfiniteScroll = false;

    /**
     * Load result set from filter
     *
     * @return void
     */
    public function loadRecordsetFromFilter($filter)
    {
        // Set up list options
        $this->setupListOptions();

        // Search options
        $this->setupSearchOptions();

        // Other options
        $this->setupOtherOptions();

        // Set visibility
        $this->setVisibility();

        // Load result set
        $this->TotalRecords = $this->loadRecordCount($filter);
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords;
        $this->CurrentFilter = $filter;
        $this->Recordset = $this->loadRecordset();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
    }

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $DashboardReport;

        // Multi column button position
        $this->MultiColumnListOptionsPosition = Config("MULTI_COLUMN_LIST_OPTIONS_POSITION");
        $DashboardReport ??= Param(Config("PAGE_DASHBOARD"));

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
        if (Param("export") !== null) {
            $this->Export = Param("export");
        }

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->escala_idescala);
        $this->setupLookupOptions($this->periodo_idperiodo);
        $this->setupLookupOptions($this->tipo_intrajornada_idtipo_intrajornada);
        $this->setupLookupOptions($this->cargo_idcargo);
        $this->setupLookupOptions($this->acumulo_funcao);
        $this->setupLookupOptions($this->usuario_idusuario);

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fplanilha_custogrid";
        }

        // Set up page action
        $this->PageAction = CurrentPageUrl(false);

        // Set up infinite scroll
        $this->UseInfiniteScroll = ConvertToBool(Param("infinitescroll"));

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $query = ""; // Query builder

        // Set up Dashboard Filter
        if ($DashboardReport) {
            AddFilter($this->Filter, $this->getDashboardFilter($DashboardReport, $this->TableVar));
        }

        // Get command
        $this->Command = strtolower(Get("cmd", ""));

        // Set up records per page
        $this->setupDisplayRecords();

        // Handle reset command
        $this->resetCmd();

        // Hide list options
        if ($this->isExport()) {
            $this->ListOptions->hideAllOptions(["sequence"]);
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        } elseif ($this->isGridAdd() || $this->isGridEdit() || $this->isMultiEdit() || $this->isConfirm()) {
            $this->ListOptions->hideAllOptions();
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        }

        // Hide other options
        if ($this->isExport()) {
            $this->OtherOptions->hideAllOptions();
        }

        // Show grid delete link for grid add / grid edit
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $item = $this->ListOptions["griddelete"];
                if ($item) {
                    $item->Visible = $Security->allowDelete(CurrentProjectID() . $this->TableName);
                }
            }
        }

        // Set up sorting order
        $this->setupSortOrder();

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 50; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Build filter
        if (!$Security->canList()) {
            $this->Filter = "(0=1)"; // Filter all records
        }

        // Restore master/detail filter from session
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Restore master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Restore detail filter from session
        AddFilter($this->Filter, $this->DbDetailFilter);
        AddFilter($this->Filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "proposta") {
            $masterTbl = Container("proposta");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("PropostaList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = RowType::MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $this->Filter;
        } else {
            $this->setSessionWhere($this->Filter);
            $this->CurrentFilter = "";
        }
        $this->Filter = $this->applyUserIDFilters($this->Filter);
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } elseif (($this->isEdit() || $this->isCopy() || $this->isInlineInserted() || $this->isInlineUpdated()) && $this->UseInfiniteScroll) { // Get current record only
            $this->CurrentFilter = $this->isInlineUpdated() ? $this->getRecordFilter() : $this->getFilterFromRecordKeys();
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Recordset = $this->loadRecordset();
        } elseif (
            $this->UseInfiniteScroll && $this->isGridInserted() ||
            $this->UseInfiniteScroll && ($this->isGridEdit() || $this->isGridUpdated()) ||
            $this->isMultiEdit() ||
            $this->UseInfiniteScroll && $this->isMultiUpdated()
        ) { // Get current records only
            $this->CurrentFilter = $this->FilterForModalActions; // Restore filter
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Recordset = $this->loadRecordset();
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
        }

        // API list action
        if (IsApi()) {
            if (Route(0) == Config("API_LIST_ACTION")) {
                if (!$this->isExport()) {
                    $rows = $this->getRecordsFromRecordset($this->Recordset);
                    $this->Recordset?->free();
                    WriteJson([
                        "success" => true,
                        "action" => Config("API_LIST_ACTION"),
                        $this->TableVar => $rows,
                        "totalRecordCount" => $this->TotalRecords
                    ]);
                    $this->terminate(true);
                }
                return;
            } elseif ($this->getFailureMessage() != "") {
                WriteJson(["error" => $this->getFailureMessage()]);
                $this->clearFailureMessage();
                $this->terminate(true);
                return;
            }
        }

        // Render other options
        $this->renderOtherOptions();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set ReturnUrl in header if necessary
        if ($returnUrl = Container("app.flash")->getFirstMessage("Return-Url")) {
            AddHeader("Return-Url", GetUrl($returnUrl));
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            DispatchEvent(new PageRenderingEvent($this), PageRenderingEvent::NAME);

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Get page number
    public function getPageNumber()
    {
        return ($this->DisplayRecords > 0 && $this->StartRecord > 0) ? ceil($this->StartRecord / $this->DisplayRecords) : 1;
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 50; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to grid add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to grid edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old result set
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAllAssociative();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }
        $this->loadDefaultValues();
        $wrkfilter = "";
        $key = "";

        // Update row index and get row key
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete" && $rowaction != "hide") { // Skip insert then deleted rows / hidden rows for grid edit
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                        if ($gridUpdate) { // Get inserted or updated filter
                            AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                        }
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($gridUpdate) {
            $this->FilterForModalActions = $wrkfilter;

            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Perform grid add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }
        $this->loadDefaultValues();

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            $rsold = null;
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $rsold = $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success
                $gridInsert = $this->addRow($rsold); // Insert row (already validated by validateGridForm())
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->idplanilha_custo->CurrentValue;

                    // Add filter for this record
                    AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $this->FilterForModalActions = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if (
            $CurrentForm->hasValue("x_proposta_idproposta") &&
            $CurrentForm->hasValue("o_proposta_idproposta") &&
            $this->proposta_idproposta->CurrentValue != $this->proposta_idproposta->DefaultValue &&
            !($this->proposta_idproposta->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->proposta_idproposta->CurrentValue == $this->proposta_idproposta->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_escala_idescala") &&
            $CurrentForm->hasValue("o_escala_idescala") &&
            $this->escala_idescala->CurrentValue != $this->escala_idescala->DefaultValue &&
            !($this->escala_idescala->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->escala_idescala->CurrentValue == $this->escala_idescala->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_periodo_idperiodo") &&
            $CurrentForm->hasValue("o_periodo_idperiodo") &&
            $this->periodo_idperiodo->CurrentValue != $this->periodo_idperiodo->DefaultValue &&
            !($this->periodo_idperiodo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->periodo_idperiodo->CurrentValue == $this->periodo_idperiodo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_tipo_intrajornada_idtipo_intrajornada") &&
            $CurrentForm->hasValue("o_tipo_intrajornada_idtipo_intrajornada") &&
            $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue != $this->tipo_intrajornada_idtipo_intrajornada->DefaultValue &&
            !($this->tipo_intrajornada_idtipo_intrajornada->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue == $this->tipo_intrajornada_idtipo_intrajornada->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_cargo_idcargo") &&
            $CurrentForm->hasValue("o_cargo_idcargo") &&
            $this->cargo_idcargo->CurrentValue != $this->cargo_idcargo->DefaultValue &&
            !($this->cargo_idcargo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->cargo_idcargo->CurrentValue == $this->cargo_idcargo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_acumulo_funcao") &&
            $CurrentForm->hasValue("o_acumulo_funcao") &&
            $this->acumulo_funcao->CurrentValue != $this->acumulo_funcao->DefaultValue &&
            !($this->acumulo_funcao->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->acumulo_funcao->CurrentValue == $this->acumulo_funcao->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_quantidade") &&
            $CurrentForm->hasValue("o_quantidade") &&
            $this->quantidade->CurrentValue != $this->quantidade->DefaultValue &&
            !($this->quantidade->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->quantidade->CurrentValue == $this->quantidade->getSessionValue())
        ) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;

        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Load default values for emptyRow checking
        $this->loadDefaultValues();

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete" && $rowaction != "hide") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    $this->ValidationErrors[$rowindex] = $this->getValidationErrors();
                    $this->EventCancelled = true;
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        foreach ($this->Fields as $field) {
            $field->clearErrorMessage();
        }
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->idplanilha_custo->Expression . " DESC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->setStartRecordNumber(1); // Reset start position
        }

        // Update field sort
        $this->updateFieldSort();
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->proposta_idproposta->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = true;
            $item->Visible = false; // Default hidden
        }

        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = true;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = true;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = true;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Set up list options (extensions)
    protected function setupListOptionsExt()
    {
            // Set up list options (to be implemented by extensions)
    }

    // Add "hash" parameter to URL
    public function urlAddHash($url, $hash)
    {
        return $this->UseAjaxActions ? $url : UrlAddQuery($url, "hash=" . $hash);
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->allowDelete(CurrentProjectID() . $this->TableName) && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"planilha_custo\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                if ($this->ModalEdit && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"planilha_custo\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                if ($this->ModalAdd && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"planilha_custo\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("CopyLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
                $deleteCaption = $Language->phrase("DeleteLink");
                $deleteTitle = HtmlTitle($deleteCaption);
                if ($this->UseAjaxActions) {
                    $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"inline\" data-action=\"delete\" title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" data-key= \"" . HtmlEncode($this->getKey(true)) . "\" data-url=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $deleteCaption . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-delete\"" .
                        ($this->InlineDelete ? " data-ew-action=\"inline-delete\"" : "") .
                        " title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $deleteCaption . "</a>";
                }
            } else {
                $opt->Body = "";
            }
        } // End View mode
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Render list options (extensions)
    protected function renderListOptionsExt()
    {
        // Render list options (to be implemented by extensions)
        global $Security, $Language;
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $option = $this->OtherOptions["addedit"];
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            if ($this->ModalAdd && !IsMobile()) {
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"planilha_custo\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
            } else {
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            }
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
    }

    // Active user filter
    // - Get active users by SQL (SELECT COUNT(*) FROM UserTable WHERE ProfileField LIKE '%"SessionID":%')
    protected function activeUserFilter()
    {
        if (UserProfile::$FORCE_LOGOUT_USER) {
            $userProfileField = $this->Fields[Config("USER_PROFILE_FIELD_NAME")];
            return $userProfileField->Expression . " LIKE '%\"" . UserProfile::$SESSION_ID . "\":%'";
        }
        return "0=1"; // No active users
    }

    // Create new column option
    protected function createColumnOption($option, $name)
    {
        $field = $this->Fields[$name] ?? null;
        if ($field?->Visible) {
            $item = $option->add($field->Name);
            $item->Body = '<button class="dropdown-item">' .
                '<div class="form-check ew-dropdown-checkbox">' .
                '<div class="form-check-input ew-dropdown-check-input" data-field="' . $field->Param . '"></div>' .
                '<label class="form-check-label ew-dropdown-check-label">' . $field->caption() . '</label></div></button>';
        }
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
            if (in_array($this->CurrentMode, ["add", "copy", "edit"]) && !$this->isConfirm()) { // Check add/copy/edit mode
                if ($this->AllowAddDeleteRow) {
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                    $this->ShowOtherOptions = $item->Visible;
                }
            }
            if ($this->CurrentMode == "view") { // Check view mode
                $option = $options["addedit"];
                $item = $option["add"];
                $this->ShowOtherOptions = $item?->Visible ?? false;
            }
    }

    // Set up Grid
    public function setupGrid()
    {
        global $CurrentForm;
        $this->StartRecord = 1;
        $this->StopRecord = $this->TotalRecords; // Show all records

        // Restore number of post back records
        if ($CurrentForm && ($this->isConfirm() || $this->EventCancelled)) {
            $CurrentForm->resetIndex();
            if ($CurrentForm->hasValue($this->FormKeyCountName) && ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm())) {
                $this->KeyCount = $CurrentForm->getValue($this->FormKeyCountName);
                $this->StopRecord = $this->StartRecord + $this->KeyCount - 1;
            }
        }
        $this->RecordCount = $this->StartRecord - 1;
        if ($this->CurrentRow !== false) {
            // Nothing to do
        } elseif ($this->isGridAdd() && !$this->AllowAddDeleteRow && $this->StopRecord == 0) { // Grid-Add with no records
            $this->StopRecord = $this->GridAddRowCount;
        } elseif ($this->isAdd() && $this->TotalRecords == 0) { // Inline-Add with no records
            $this->StopRecord = 1;
        }

        // Initialize aggregate
        $this->RowType = RowType::AGGREGATEINIT;
        $this->resetAttributes();
        $this->renderRow();
        if (($this->isGridAdd() || $this->isGridEdit())) { // Render template row first
            $this->RowIndex = '$rowindex$';
        }
    }

    // Set up Row
    public function setupRow()
    {
        global $CurrentForm;
        if ($this->isGridAdd() || $this->isGridEdit()) {
            if ($this->RowIndex === '$rowindex$') { // Render template row first
                $this->loadRowValues();

                // Set row properties
                $this->resetAttributes();
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_planilha_custo", "data-rowtype" => RowType::ADD]);
                $this->RowAttrs->appendClass("ew-template");
                // Render row
                $this->RowType = RowType::ADD;
                $this->renderRow();

                // Render list options
                $this->renderListOptions();

                // Reset record count for template row
                $this->RecordCount--;
                return;
            }
        }
        if ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm() || $this->isMultiEdit()) {
            $this->RowIndex++;
            $CurrentForm->Index = $this->RowIndex;
            if ($CurrentForm->hasValue($this->FormActionName) && ($this->isConfirm() || $this->EventCancelled)) {
                $this->RowAction = strval($CurrentForm->getValue($this->FormActionName));
            } elseif ($this->isGridAdd()) {
                $this->RowAction = "insert";
            } else {
                $this->RowAction = "";
            }
        }

        // Set up key count
        $this->KeyCount = $this->RowIndex;

        // Init row class and style
        $this->resetAttributes();
        $this->CssClass = "";
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->loadRowValues($this->CurrentRow); // Load row values
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
            } else {
                $this->loadRowValues(); // Load default values
                $this->OldKey = "";
            }
        } else {
            $this->loadRowValues($this->CurrentRow); // Load row values
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
        }
        $this->setKey($this->OldKey);
        $this->RowType = RowType::VIEW; // Render view
        if (($this->isAdd() || $this->isCopy()) && $this->InlineRowCount == 0 || $this->isGridAdd()) { // Add
            $this->RowType = RowType::ADD; // Render add
        }
        if ($this->isGridAdd() && $this->EventCancelled && !$CurrentForm->hasValue($this->FormBlankRowName)) { // Insert failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }
        if ($this->isGridEdit()) { // Grid edit
            if ($this->EventCancelled) {
                $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
            }
            if ($this->RowAction == "insert") {
                $this->RowType = RowType::ADD; // Render add
            } else {
                $this->RowType = RowType::EDIT; // Render edit
            }
        }
        if ($this->isGridEdit() && ($this->RowType == RowType::EDIT || $this->RowType == RowType::ADD) && $this->EventCancelled) { // Update failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }
        if ($this->isConfirm()) { // Confirm row
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }

        // Inline Add/Copy row (row 0)
        if ($this->RowType == RowType::ADD && ($this->isAdd() || $this->isCopy())) {
            $this->InlineRowCount++;
            $this->RecordCount--; // Reset record count for inline add/copy row
            if ($this->TotalRecords == 0) { // Reset stop record if no records
                $this->StopRecord = 0;
            }
        } else {
            // Inline Edit row
            if ($this->RowType == RowType::EDIT && $this->isEdit()) {
                $this->InlineRowCount++;
            }
            $this->RowCount++; // Increment row count
        }

        // Set up row attributes
        $this->RowAttrs->merge([
            "data-rowindex" => $this->RowCount,
            "data-key" => $this->getKey(true),
            "id" => "r" . $this->RowCount . "_planilha_custo",
            "data-rowtype" => $this->RowType,
            "data-inline" => ($this->isAdd() || $this->isCopy() || $this->isEdit()) ? "true" : "false", // Inline-Add/Copy/Edit
            "class" => ($this->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($this->isAdd() && $this->RowType == RowType::ADD || $this->isEdit() && $this->RowType == RowType::EDIT) { // Inline-Add/Edit row
            $this->RowAttrs->appendClass("table-active");
        }

        // Render row
        $this->renderRow();

        // Render list options
        $this->renderListOptions();
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->tipo_intrajornada_idtipo_intrajornada->DefaultValue = $this->tipo_intrajornada_idtipo_intrajornada->getDefault(); // PHP
        $this->tipo_intrajornada_idtipo_intrajornada->OldValue = $this->tipo_intrajornada_idtipo_intrajornada->DefaultValue;
        $this->acumulo_funcao->DefaultValue = $this->acumulo_funcao->getDefault(); // PHP
        $this->acumulo_funcao->OldValue = $this->acumulo_funcao->DefaultValue;
        $this->quantidade->DefaultValue = $this->quantidade->getDefault(); // PHP
        $this->quantidade->OldValue = $this->quantidade->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'idplanilha_custo' first before field var 'x_idplanilha_custo'
        $val = $CurrentForm->hasValue("idplanilha_custo") ? $CurrentForm->getValue("idplanilha_custo") : $CurrentForm->getValue("x_idplanilha_custo");
        if (!$this->idplanilha_custo->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->idplanilha_custo->setFormValue($val);
        }

        // Check field name 'proposta_idproposta' first before field var 'x_proposta_idproposta'
        $val = $CurrentForm->hasValue("proposta_idproposta") ? $CurrentForm->getValue("proposta_idproposta") : $CurrentForm->getValue("x_proposta_idproposta");
        if (!$this->proposta_idproposta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->proposta_idproposta->Visible = false; // Disable update for API request
            } else {
                $this->proposta_idproposta->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_proposta_idproposta")) {
            $this->proposta_idproposta->setOldValue($CurrentForm->getValue("o_proposta_idproposta"));
        }

        // Check field name 'escala_idescala' first before field var 'x_escala_idescala'
        $val = $CurrentForm->hasValue("escala_idescala") ? $CurrentForm->getValue("escala_idescala") : $CurrentForm->getValue("x_escala_idescala");
        if (!$this->escala_idescala->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->escala_idescala->Visible = false; // Disable update for API request
            } else {
                $this->escala_idescala->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_escala_idescala")) {
            $this->escala_idescala->setOldValue($CurrentForm->getValue("o_escala_idescala"));
        }

        // Check field name 'periodo_idperiodo' first before field var 'x_periodo_idperiodo'
        $val = $CurrentForm->hasValue("periodo_idperiodo") ? $CurrentForm->getValue("periodo_idperiodo") : $CurrentForm->getValue("x_periodo_idperiodo");
        if (!$this->periodo_idperiodo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->periodo_idperiodo->Visible = false; // Disable update for API request
            } else {
                $this->periodo_idperiodo->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_periodo_idperiodo")) {
            $this->periodo_idperiodo->setOldValue($CurrentForm->getValue("o_periodo_idperiodo"));
        }

        // Check field name 'tipo_intrajornada_idtipo_intrajornada' first before field var 'x_tipo_intrajornada_idtipo_intrajornada'
        $val = $CurrentForm->hasValue("tipo_intrajornada_idtipo_intrajornada") ? $CurrentForm->getValue("tipo_intrajornada_idtipo_intrajornada") : $CurrentForm->getValue("x_tipo_intrajornada_idtipo_intrajornada");
        if (!$this->tipo_intrajornada_idtipo_intrajornada->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_intrajornada_idtipo_intrajornada->Visible = false; // Disable update for API request
            } else {
                $this->tipo_intrajornada_idtipo_intrajornada->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_tipo_intrajornada_idtipo_intrajornada")) {
            $this->tipo_intrajornada_idtipo_intrajornada->setOldValue($CurrentForm->getValue("o_tipo_intrajornada_idtipo_intrajornada"));
        }

        // Check field name 'cargo_idcargo' first before field var 'x_cargo_idcargo'
        $val = $CurrentForm->hasValue("cargo_idcargo") ? $CurrentForm->getValue("cargo_idcargo") : $CurrentForm->getValue("x_cargo_idcargo");
        if (!$this->cargo_idcargo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cargo_idcargo->Visible = false; // Disable update for API request
            } else {
                $this->cargo_idcargo->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_cargo_idcargo")) {
            $this->cargo_idcargo->setOldValue($CurrentForm->getValue("o_cargo_idcargo"));
        }

        // Check field name 'acumulo_funcao' first before field var 'x_acumulo_funcao'
        $val = $CurrentForm->hasValue("acumulo_funcao") ? $CurrentForm->getValue("acumulo_funcao") : $CurrentForm->getValue("x_acumulo_funcao");
        if (!$this->acumulo_funcao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->acumulo_funcao->Visible = false; // Disable update for API request
            } else {
                $this->acumulo_funcao->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_acumulo_funcao")) {
            $this->acumulo_funcao->setOldValue($CurrentForm->getValue("o_acumulo_funcao"));
        }

        // Check field name 'quantidade' first before field var 'x_quantidade'
        $val = $CurrentForm->hasValue("quantidade") ? $CurrentForm->getValue("quantidade") : $CurrentForm->getValue("x_quantidade");
        if (!$this->quantidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->quantidade->Visible = false; // Disable update for API request
            } else {
                $this->quantidade->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_quantidade")) {
            $this->quantidade->setOldValue($CurrentForm->getValue("o_quantidade"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->idplanilha_custo->CurrentValue = $this->idplanilha_custo->FormValue;
        }
        $this->proposta_idproposta->CurrentValue = $this->proposta_idproposta->FormValue;
        $this->escala_idescala->CurrentValue = $this->escala_idescala->FormValue;
        $this->periodo_idperiodo->CurrentValue = $this->periodo_idperiodo->FormValue;
        $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue = $this->tipo_intrajornada_idtipo_intrajornada->FormValue;
        $this->cargo_idcargo->CurrentValue = $this->cargo_idcargo->FormValue;
        $this->acumulo_funcao->CurrentValue = $this->acumulo_funcao->FormValue;
        $this->quantidade->CurrentValue = $this->quantidade->FormValue;
    }

    /**
     * Load result set
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return Doctrine\DBAL\Result Result
     */
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        if (property_exists($this, "TotalRecords") && $rowcnt < 0) {
            $this->TotalRecords = $result->rowCount();
            if ($this->TotalRecords <= 0) { // Handle database drivers that does not return rowCount()
                $this->TotalRecords = $this->getRecordCount($this->getListSql());
            }
        }

        // Call Recordset Selected event
        $this->recordsetSelected($result);
        return $result;
    }

    /**
     * Load records as associative array
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return void
     */
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        return $result->fetchAllAssociative();
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from result set or record
     *
     * @param array $row Record
     * @return void
     */
    public function loadRowValues($row = null)
    {
        $row = is_array($row) ? $row : $this->newRow();

        // Call Row Selected event
        $this->rowSelected($row);
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

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idplanilha_custo'] = $this->idplanilha_custo->DefaultValue;
        $row['proposta_idproposta'] = $this->proposta_idproposta->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['escala_idescala'] = $this->escala_idescala->DefaultValue;
        $row['periodo_idperiodo'] = $this->periodo_idperiodo->DefaultValue;
        $row['tipo_intrajornada_idtipo_intrajornada'] = $this->tipo_intrajornada_idtipo_intrajornada->DefaultValue;
        $row['cargo_idcargo'] = $this->cargo_idcargo->DefaultValue;
        $row['acumulo_funcao'] = $this->acumulo_funcao->DefaultValue;
        $row['quantidade'] = $this->quantidade->DefaultValue;
        $row['usuario_idusuario'] = $this->usuario_idusuario->DefaultValue;
        $row['calculo_idcalculo'] = $this->calculo_idcalculo->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = ExecuteQuery($sql, $conn);
            if ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

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

        // Accumulate aggregate value
        if ($this->RowType != RowType::AGGREGATEINIT && $this->RowType != RowType::AGGREGATE && $this->RowType != RowType::PREVIEWFIELD) {
            if (is_numeric($this->quantidade->CurrentValue)) {
                $this->quantidade->Total += $this->quantidade->CurrentValue; // Accumulate total
            }
        }

        // View row
        if ($this->RowType == RowType::VIEW) {
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
        } elseif ($this->RowType == RowType::ADD) {
            // idplanilha_custo

            // proposta_idproposta
            $this->proposta_idproposta->setupEditAttributes();
            if ($this->proposta_idproposta->getSessionValue() != "") {
                $this->proposta_idproposta->CurrentValue = GetForeignKeyValue($this->proposta_idproposta->getSessionValue());
                $this->proposta_idproposta->OldValue = $this->proposta_idproposta->CurrentValue;
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

            // escala_idescala
            $curVal = trim(strval($this->escala_idescala->CurrentValue));
            if ($curVal != "") {
                $this->escala_idescala->ViewValue = $this->escala_idescala->lookupCacheOption($curVal);
            } else {
                $this->escala_idescala->ViewValue = $this->escala_idescala->Lookup !== null && is_array($this->escala_idescala->lookupOptions()) && count($this->escala_idescala->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->escala_idescala->ViewValue !== null) { // Load from cache
                $this->escala_idescala->EditValue = array_values($this->escala_idescala->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->escala_idescala->Lookup->getTable()->Fields["idescala"]->searchExpression(), "=", $this->escala_idescala->CurrentValue, $this->escala_idescala->Lookup->getTable()->Fields["idescala"]->searchDataType(), "");
                }
                $sqlWrk = $this->escala_idescala->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->escala_idescala->EditValue = $arwrk;
            }
            $this->escala_idescala->PlaceHolder = RemoveHtml($this->escala_idescala->caption());

            // periodo_idperiodo
            $curVal = trim(strval($this->periodo_idperiodo->CurrentValue));
            if ($curVal != "") {
                $this->periodo_idperiodo->ViewValue = $this->periodo_idperiodo->lookupCacheOption($curVal);
            } else {
                $this->periodo_idperiodo->ViewValue = $this->periodo_idperiodo->Lookup !== null && is_array($this->periodo_idperiodo->lookupOptions()) && count($this->periodo_idperiodo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->periodo_idperiodo->ViewValue !== null) { // Load from cache
                $this->periodo_idperiodo->EditValue = array_values($this->periodo_idperiodo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->periodo_idperiodo->Lookup->getTable()->Fields["idperiodo"]->searchExpression(), "=", $this->periodo_idperiodo->CurrentValue, $this->periodo_idperiodo->Lookup->getTable()->Fields["idperiodo"]->searchDataType(), "");
                }
                $sqlWrk = $this->periodo_idperiodo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->periodo_idperiodo->EditValue = $arwrk;
            }
            $this->periodo_idperiodo->PlaceHolder = RemoveHtml($this->periodo_idperiodo->caption());

            // tipo_intrajornada_idtipo_intrajornada
            $curVal = trim(strval($this->tipo_intrajornada_idtipo_intrajornada->CurrentValue));
            if ($curVal != "") {
                $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = $this->tipo_intrajornada_idtipo_intrajornada->lookupCacheOption($curVal);
            } else {
                $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = $this->tipo_intrajornada_idtipo_intrajornada->Lookup !== null && is_array($this->tipo_intrajornada_idtipo_intrajornada->lookupOptions()) && count($this->tipo_intrajornada_idtipo_intrajornada->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_intrajornada_idtipo_intrajornada->ViewValue !== null) { // Load from cache
                $this->tipo_intrajornada_idtipo_intrajornada->EditValue = array_values($this->tipo_intrajornada_idtipo_intrajornada->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_intrajornada_idtipo_intrajornada->Lookup->getTable()->Fields["idtipo_intrajornada"]->searchExpression(), "=", $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue, $this->tipo_intrajornada_idtipo_intrajornada->Lookup->getTable()->Fields["idtipo_intrajornada"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipo_intrajornada_idtipo_intrajornada->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_intrajornada_idtipo_intrajornada->EditValue = $arwrk;
            }
            $this->tipo_intrajornada_idtipo_intrajornada->PlaceHolder = RemoveHtml($this->tipo_intrajornada_idtipo_intrajornada->caption());

            // cargo_idcargo
            $this->cargo_idcargo->setupEditAttributes();
            $curVal = trim(strval($this->cargo_idcargo->CurrentValue));
            if ($curVal != "") {
                $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->lookupCacheOption($curVal);
            } else {
                $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->Lookup !== null && is_array($this->cargo_idcargo->lookupOptions()) && count($this->cargo_idcargo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cargo_idcargo->ViewValue !== null) { // Load from cache
                $this->cargo_idcargo->EditValue = array_values($this->cargo_idcargo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cargo_idcargo->Lookup->getTable()->Fields["idcargo"]->searchExpression(), "=", $this->cargo_idcargo->CurrentValue, $this->cargo_idcargo->Lookup->getTable()->Fields["idcargo"]->searchDataType(), "");
                }
                $sqlWrk = $this->cargo_idcargo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->cargo_idcargo->Lookup->renderViewRow($row);
                }
                $this->cargo_idcargo->EditValue = $arwrk;
            }
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

            // Add refer script

            // idplanilha_custo
            $this->idplanilha_custo->HrefValue = "";

            // proposta_idproposta
            $this->proposta_idproposta->HrefValue = "";

            // escala_idescala
            $this->escala_idescala->HrefValue = "";

            // periodo_idperiodo
            $this->periodo_idperiodo->HrefValue = "";

            // tipo_intrajornada_idtipo_intrajornada
            $this->tipo_intrajornada_idtipo_intrajornada->HrefValue = "";

            // cargo_idcargo
            $this->cargo_idcargo->HrefValue = "";

            // acumulo_funcao
            $this->acumulo_funcao->HrefValue = "";

            // quantidade
            $this->quantidade->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // idplanilha_custo
            $this->idplanilha_custo->setupEditAttributes();
            $this->idplanilha_custo->EditValue = $this->idplanilha_custo->CurrentValue;
            $this->idplanilha_custo->CssClass = "fw-bold";
            $this->idplanilha_custo->CellCssStyle .= "text-align: center;";

            // proposta_idproposta
            $this->proposta_idproposta->setupEditAttributes();
            if ($this->proposta_idproposta->getSessionValue() != "") {
                $this->proposta_idproposta->CurrentValue = GetForeignKeyValue($this->proposta_idproposta->getSessionValue());
                $this->proposta_idproposta->OldValue = $this->proposta_idproposta->CurrentValue;
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

            // escala_idescala
            $curVal = trim(strval($this->escala_idescala->CurrentValue));
            if ($curVal != "") {
                $this->escala_idescala->ViewValue = $this->escala_idescala->lookupCacheOption($curVal);
            } else {
                $this->escala_idescala->ViewValue = $this->escala_idescala->Lookup !== null && is_array($this->escala_idescala->lookupOptions()) && count($this->escala_idescala->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->escala_idescala->ViewValue !== null) { // Load from cache
                $this->escala_idescala->EditValue = array_values($this->escala_idescala->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->escala_idescala->Lookup->getTable()->Fields["idescala"]->searchExpression(), "=", $this->escala_idescala->CurrentValue, $this->escala_idescala->Lookup->getTable()->Fields["idescala"]->searchDataType(), "");
                }
                $sqlWrk = $this->escala_idescala->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->escala_idescala->EditValue = $arwrk;
            }
            $this->escala_idescala->PlaceHolder = RemoveHtml($this->escala_idescala->caption());

            // periodo_idperiodo
            $curVal = trim(strval($this->periodo_idperiodo->CurrentValue));
            if ($curVal != "") {
                $this->periodo_idperiodo->ViewValue = $this->periodo_idperiodo->lookupCacheOption($curVal);
            } else {
                $this->periodo_idperiodo->ViewValue = $this->periodo_idperiodo->Lookup !== null && is_array($this->periodo_idperiodo->lookupOptions()) && count($this->periodo_idperiodo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->periodo_idperiodo->ViewValue !== null) { // Load from cache
                $this->periodo_idperiodo->EditValue = array_values($this->periodo_idperiodo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->periodo_idperiodo->Lookup->getTable()->Fields["idperiodo"]->searchExpression(), "=", $this->periodo_idperiodo->CurrentValue, $this->periodo_idperiodo->Lookup->getTable()->Fields["idperiodo"]->searchDataType(), "");
                }
                $sqlWrk = $this->periodo_idperiodo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->periodo_idperiodo->EditValue = $arwrk;
            }
            $this->periodo_idperiodo->PlaceHolder = RemoveHtml($this->periodo_idperiodo->caption());

            // tipo_intrajornada_idtipo_intrajornada
            $curVal = trim(strval($this->tipo_intrajornada_idtipo_intrajornada->CurrentValue));
            if ($curVal != "") {
                $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = $this->tipo_intrajornada_idtipo_intrajornada->lookupCacheOption($curVal);
            } else {
                $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = $this->tipo_intrajornada_idtipo_intrajornada->Lookup !== null && is_array($this->tipo_intrajornada_idtipo_intrajornada->lookupOptions()) && count($this->tipo_intrajornada_idtipo_intrajornada->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_intrajornada_idtipo_intrajornada->ViewValue !== null) { // Load from cache
                $this->tipo_intrajornada_idtipo_intrajornada->EditValue = array_values($this->tipo_intrajornada_idtipo_intrajornada->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_intrajornada_idtipo_intrajornada->Lookup->getTable()->Fields["idtipo_intrajornada"]->searchExpression(), "=", $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue, $this->tipo_intrajornada_idtipo_intrajornada->Lookup->getTable()->Fields["idtipo_intrajornada"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipo_intrajornada_idtipo_intrajornada->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_intrajornada_idtipo_intrajornada->EditValue = $arwrk;
            }
            $this->tipo_intrajornada_idtipo_intrajornada->PlaceHolder = RemoveHtml($this->tipo_intrajornada_idtipo_intrajornada->caption());

            // cargo_idcargo
            $this->cargo_idcargo->setupEditAttributes();
            $curVal = trim(strval($this->cargo_idcargo->CurrentValue));
            if ($curVal != "") {
                $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->lookupCacheOption($curVal);
            } else {
                $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->Lookup !== null && is_array($this->cargo_idcargo->lookupOptions()) && count($this->cargo_idcargo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cargo_idcargo->ViewValue !== null) { // Load from cache
                $this->cargo_idcargo->EditValue = array_values($this->cargo_idcargo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cargo_idcargo->Lookup->getTable()->Fields["idcargo"]->searchExpression(), "=", $this->cargo_idcargo->CurrentValue, $this->cargo_idcargo->Lookup->getTable()->Fields["idcargo"]->searchDataType(), "");
                }
                $sqlWrk = $this->cargo_idcargo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->cargo_idcargo->Lookup->renderViewRow($row);
                }
                $this->cargo_idcargo->EditValue = $arwrk;
            }
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

            // Edit refer script

            // idplanilha_custo
            $this->idplanilha_custo->HrefValue = "";

            // proposta_idproposta
            $this->proposta_idproposta->HrefValue = "";

            // escala_idescala
            $this->escala_idescala->HrefValue = "";

            // periodo_idperiodo
            $this->periodo_idperiodo->HrefValue = "";

            // tipo_intrajornada_idtipo_intrajornada
            $this->tipo_intrajornada_idtipo_intrajornada->HrefValue = "";

            // cargo_idcargo
            $this->cargo_idcargo->HrefValue = "";

            // acumulo_funcao
            $this->acumulo_funcao->HrefValue = "";

            // quantidade
            $this->quantidade->HrefValue = "";
        } elseif ($this->RowType == RowType::AGGREGATEINIT) { // Initialize aggregate row
                    $this->quantidade->Total = 0; // Initialize total
        } elseif ($this->RowType == RowType::AGGREGATE) { // Aggregate row
            $this->quantidade->CurrentValue = $this->quantidade->Total;
            $this->quantidade->ViewValue = $this->quantidade->CurrentValue;
            $this->quantidade->ViewValue = FormatNumber($this->quantidade->ViewValue, $this->quantidade->formatPattern());
            $this->quantidade->CssClass = "fw-bold";
            $this->quantidade->CellCssStyle .= "text-align: center;";
            $this->quantidade->HrefValue = ""; // Clear href value
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
            if ($this->idplanilha_custo->Visible && $this->idplanilha_custo->Required) {
                if (!$this->idplanilha_custo->IsDetailKey && EmptyValue($this->idplanilha_custo->FormValue)) {
                    $this->idplanilha_custo->addErrorMessage(str_replace("%s", $this->idplanilha_custo->caption(), $this->idplanilha_custo->RequiredErrorMessage));
                }
            }
            if ($this->proposta_idproposta->Visible && $this->proposta_idproposta->Required) {
                if (!$this->proposta_idproposta->IsDetailKey && EmptyValue($this->proposta_idproposta->FormValue)) {
                    $this->proposta_idproposta->addErrorMessage(str_replace("%s", $this->proposta_idproposta->caption(), $this->proposta_idproposta->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->proposta_idproposta->FormValue)) {
                $this->proposta_idproposta->addErrorMessage($this->proposta_idproposta->getErrorMessage(false));
            }
            if ($this->escala_idescala->Visible && $this->escala_idescala->Required) {
                if ($this->escala_idescala->FormValue == "") {
                    $this->escala_idescala->addErrorMessage(str_replace("%s", $this->escala_idescala->caption(), $this->escala_idescala->RequiredErrorMessage));
                }
            }
            if ($this->periodo_idperiodo->Visible && $this->periodo_idperiodo->Required) {
                if ($this->periodo_idperiodo->FormValue == "") {
                    $this->periodo_idperiodo->addErrorMessage(str_replace("%s", $this->periodo_idperiodo->caption(), $this->periodo_idperiodo->RequiredErrorMessage));
                }
            }
            if ($this->tipo_intrajornada_idtipo_intrajornada->Visible && $this->tipo_intrajornada_idtipo_intrajornada->Required) {
                if ($this->tipo_intrajornada_idtipo_intrajornada->FormValue == "") {
                    $this->tipo_intrajornada_idtipo_intrajornada->addErrorMessage(str_replace("%s", $this->tipo_intrajornada_idtipo_intrajornada->caption(), $this->tipo_intrajornada_idtipo_intrajornada->RequiredErrorMessage));
                }
            }
            if ($this->cargo_idcargo->Visible && $this->cargo_idcargo->Required) {
                if (!$this->cargo_idcargo->IsDetailKey && EmptyValue($this->cargo_idcargo->FormValue)) {
                    $this->cargo_idcargo->addErrorMessage(str_replace("%s", $this->cargo_idcargo->caption(), $this->cargo_idcargo->RequiredErrorMessage));
                }
            }
            if ($this->acumulo_funcao->Visible && $this->acumulo_funcao->Required) {
                if ($this->acumulo_funcao->FormValue == "") {
                    $this->acumulo_funcao->addErrorMessage(str_replace("%s", $this->acumulo_funcao->caption(), $this->acumulo_funcao->RequiredErrorMessage));
                }
            }
            if ($this->quantidade->Visible && $this->quantidade->Required) {
                if (!$this->quantidade->IsDetailKey && EmptyValue($this->quantidade->FormValue)) {
                    $this->quantidade->addErrorMessage(str_replace("%s", $this->quantidade->caption(), $this->quantidade->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->quantidade->FormValue)) {
                $this->quantidade->addErrorMessage($this->quantidade->getErrorMessage(false));
            }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['idplanilha_custo'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if (!$deleteRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        return $deleteRows;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Load old values
            $this->loadDbValues($rsold);
        }

        // Get new row
        $rsnew = $this->getEditRow($rsold);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'proposta'
        $detailKeys = [];
        $keyValue = $rsnew['proposta_idproposta'] ?? $rsold['proposta_idproposta'];
        $detailKeys['proposta_idproposta'] = $keyValue;
        $masterTable = Container("proposta");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "proposta", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }
        return $editRow;
    }

    /**
     * Get edit row
     *
     * @return array
     */
    protected function getEditRow($rsold)
    {
        global $Security;
        $rsnew = [];

        // proposta_idproposta
        if ($this->proposta_idproposta->getSessionValue() != "") {
            $this->proposta_idproposta->ReadOnly = true;
        }
        $this->proposta_idproposta->setDbValueDef($rsnew, $this->proposta_idproposta->CurrentValue, $this->proposta_idproposta->ReadOnly);

        // escala_idescala
        $this->escala_idescala->setDbValueDef($rsnew, $this->escala_idescala->CurrentValue, $this->escala_idescala->ReadOnly);

        // periodo_idperiodo
        $this->periodo_idperiodo->setDbValueDef($rsnew, $this->periodo_idperiodo->CurrentValue, $this->periodo_idperiodo->ReadOnly);

        // tipo_intrajornada_idtipo_intrajornada
        $this->tipo_intrajornada_idtipo_intrajornada->setDbValueDef($rsnew, $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue, $this->tipo_intrajornada_idtipo_intrajornada->ReadOnly);

        // cargo_idcargo
        $this->cargo_idcargo->setDbValueDef($rsnew, $this->cargo_idcargo->CurrentValue, $this->cargo_idcargo->ReadOnly);

        // acumulo_funcao
        $this->acumulo_funcao->setDbValueDef($rsnew, $this->acumulo_funcao->CurrentValue, $this->acumulo_funcao->ReadOnly);

        // quantidade
        $this->quantidade->setDbValueDef($rsnew, $this->quantidade->CurrentValue, $this->quantidade->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['proposta_idproposta'])) { // proposta_idproposta
            $this->proposta_idproposta->CurrentValue = $row['proposta_idproposta'];
        }
        if (isset($row['escala_idescala'])) { // escala_idescala
            $this->escala_idescala->CurrentValue = $row['escala_idescala'];
        }
        if (isset($row['periodo_idperiodo'])) { // periodo_idperiodo
            $this->periodo_idperiodo->CurrentValue = $row['periodo_idperiodo'];
        }
        if (isset($row['tipo_intrajornada_idtipo_intrajornada'])) { // tipo_intrajornada_idtipo_intrajornada
            $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue = $row['tipo_intrajornada_idtipo_intrajornada'];
        }
        if (isset($row['cargo_idcargo'])) { // cargo_idcargo
            $this->cargo_idcargo->CurrentValue = $row['cargo_idcargo'];
        }
        if (isset($row['acumulo_funcao'])) { // acumulo_funcao
            $this->acumulo_funcao->CurrentValue = $row['acumulo_funcao'];
        }
        if (isset($row['quantidade'])) { // quantidade
            $this->quantidade->CurrentValue = $row['quantidade'];
        }
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "proposta") {
            $this->proposta_idproposta->Visible = true; // Need to insert foreign key
            $this->proposta_idproposta->CurrentValue = $this->proposta_idproposta->getSessionValue();
        }

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'planilha_custo'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["proposta_idproposta"] = $this->proposta_idproposta->CurrentValue;
        $masterTable = Container("proposta");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "proposta", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }
        return $addRow;
    }

    /**
     * Get add row
     *
     * @return array
     */
    protected function getAddRow()
    {
        global $Security;
        $rsnew = [];

        // proposta_idproposta
        $this->proposta_idproposta->setDbValueDef($rsnew, $this->proposta_idproposta->CurrentValue, false);

        // escala_idescala
        $this->escala_idescala->setDbValueDef($rsnew, $this->escala_idescala->CurrentValue, false);

        // periodo_idperiodo
        $this->periodo_idperiodo->setDbValueDef($rsnew, $this->periodo_idperiodo->CurrentValue, false);

        // tipo_intrajornada_idtipo_intrajornada
        $this->tipo_intrajornada_idtipo_intrajornada->setDbValueDef($rsnew, $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue, strval($this->tipo_intrajornada_idtipo_intrajornada->CurrentValue) == "");

        // cargo_idcargo
        $this->cargo_idcargo->setDbValueDef($rsnew, $this->cargo_idcargo->CurrentValue, false);

        // acumulo_funcao
        $this->acumulo_funcao->setDbValueDef($rsnew, $this->acumulo_funcao->CurrentValue, strval($this->acumulo_funcao->CurrentValue) == "");

        // quantidade
        $this->quantidade->setDbValueDef($rsnew, $this->quantidade->CurrentValue, strval($this->quantidade->CurrentValue) == "");
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['proposta_idproposta'])) { // proposta_idproposta
            $this->proposta_idproposta->setFormValue($row['proposta_idproposta']);
        }
        if (isset($row['escala_idescala'])) { // escala_idescala
            $this->escala_idescala->setFormValue($row['escala_idescala']);
        }
        if (isset($row['periodo_idperiodo'])) { // periodo_idperiodo
            $this->periodo_idperiodo->setFormValue($row['periodo_idperiodo']);
        }
        if (isset($row['tipo_intrajornada_idtipo_intrajornada'])) { // tipo_intrajornada_idtipo_intrajornada
            $this->tipo_intrajornada_idtipo_intrajornada->setFormValue($row['tipo_intrajornada_idtipo_intrajornada']);
        }
        if (isset($row['cargo_idcargo'])) { // cargo_idcargo
            $this->cargo_idcargo->setFormValue($row['cargo_idcargo']);
        }
        if (isset($row['acumulo_funcao'])) { // acumulo_funcao
            $this->acumulo_funcao->setFormValue($row['acumulo_funcao']);
        }
        if (isset($row['quantidade'])) { // quantidade
            $this->quantidade->setFormValue($row['quantidade']);
        }
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "proposta") {
            $masterTbl = Container("proposta");
            $this->proposta_idproposta->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_escala_idescala":
                    break;
                case "x_periodo_idperiodo":
                    break;
                case "x_tipo_intrajornada_idtipo_intrajornada":
                    break;
                case "x_cargo_idcargo":
                    break;
                case "x_acumulo_funcao":
                    break;
                case "x_usuario_idusuario":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == "success") {
            //$msg = "your success message";
        } elseif ($type == "failure") {
            //$msg = "your failure message";
        } elseif ($type == "warning") {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->moveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }
}
