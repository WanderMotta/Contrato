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
class MovimentoPlaCustoGrid extends MovimentoPlaCusto
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "MovimentoPlaCustoGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fmovimento_pla_custogrid";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "MovimentoPlaCustoGrid";

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
        $this->idmovimento_pla_custo->Visible = false;
        $this->planilha_custo_idplanilha_custo->setVisibility();
        $this->dt_cadastro->Visible = false;
        $this->modulo_idmodulo->setVisibility();
        $this->itens_modulo_iditens_modulo->setVisibility();
        $this->porcentagem->setVisibility();
        $this->valor->setVisibility();
        $this->obs->setVisibility();
        $this->calculo_idcalculo->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'movimento_pla_custo';
        $this->TableName = 'movimento_pla_custo';

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

        // Table object (movimento_pla_custo)
        if (!isset($GLOBALS["movimento_pla_custo"]) || $GLOBALS["movimento_pla_custo"]::class == PROJECT_NAMESPACE . "movimento_pla_custo") {
            $GLOBALS["movimento_pla_custo"] = &$this;
        }
        $this->AddUrl = "MovimentoPlaCustoAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'movimento_pla_custo');
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
            $key .= @$ar['idmovimento_pla_custo'];
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
            $this->idmovimento_pla_custo->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->dt_cadastro->Visible = false;
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
        $this->setupLookupOptions($this->modulo_idmodulo);
        $this->setupLookupOptions($this->itens_modulo_iditens_modulo);

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fmovimento_pla_custogrid";
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
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "planilha_custo") {
            $masterTbl = Container("planilha_custo");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("PlanilhaCustoList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = RowType::MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "calculo") {
            $masterTbl = Container("calculo");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("CalculoList"); // Return to master page
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
        $this->porcentagem->FormValue = ""; // Clear form value
        $this->valor->FormValue = ""; // Clear form value
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
                    $key .= $this->idmovimento_pla_custo->CurrentValue;

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
            $CurrentForm->hasValue("x_planilha_custo_idplanilha_custo") &&
            $CurrentForm->hasValue("o_planilha_custo_idplanilha_custo") &&
            $this->planilha_custo_idplanilha_custo->CurrentValue != $this->planilha_custo_idplanilha_custo->DefaultValue &&
            !($this->planilha_custo_idplanilha_custo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->planilha_custo_idplanilha_custo->CurrentValue == $this->planilha_custo_idplanilha_custo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_modulo_idmodulo") &&
            $CurrentForm->hasValue("o_modulo_idmodulo") &&
            $this->modulo_idmodulo->CurrentValue != $this->modulo_idmodulo->DefaultValue &&
            !($this->modulo_idmodulo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->modulo_idmodulo->CurrentValue == $this->modulo_idmodulo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_itens_modulo_iditens_modulo") &&
            $CurrentForm->hasValue("o_itens_modulo_iditens_modulo") &&
            $this->itens_modulo_iditens_modulo->CurrentValue != $this->itens_modulo_iditens_modulo->DefaultValue &&
            !($this->itens_modulo_iditens_modulo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->itens_modulo_iditens_modulo->CurrentValue == $this->itens_modulo_iditens_modulo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_porcentagem") &&
            $CurrentForm->hasValue("o_porcentagem") &&
            $this->porcentagem->CurrentValue != $this->porcentagem->DefaultValue &&
            !($this->porcentagem->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->porcentagem->CurrentValue == $this->porcentagem->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_valor") &&
            $CurrentForm->hasValue("o_valor") &&
            $this->valor->CurrentValue != $this->valor->DefaultValue &&
            !($this->valor->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->valor->CurrentValue == $this->valor->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_obs") &&
            $CurrentForm->hasValue("o_obs") &&
            $this->obs->CurrentValue != $this->obs->DefaultValue &&
            !($this->obs->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->obs->CurrentValue == $this->obs->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_calculo_idcalculo") &&
            $CurrentForm->hasValue("o_calculo_idcalculo") &&
            $this->calculo_idcalculo->CurrentValue != $this->calculo_idcalculo->DefaultValue &&
            !($this->calculo_idcalculo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->calculo_idcalculo->CurrentValue == $this->calculo_idcalculo->getSessionValue())
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
            $defaultSort = $this->modulo_idmodulo->Expression . " ASC"; // Set up default sort
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
                        $this->planilha_custo_idplanilha_custo->setSessionValue("");
                        $this->calculo_idcalculo->setSessionValue("");
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
        // Preview extension
        $this->ListOptions->hideDetailItemsForDropDown(); // Hide detail items for dropdown if necessary
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
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"movimento_pla_custo\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"movimento_pla_custo\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"movimento_pla_custo\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("CopyLink") . "</a>";
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
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"movimento_pla_custo\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_movimento_pla_custo", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_movimento_pla_custo",
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
        $this->valor->DefaultValue = $this->valor->getDefault(); // PHP
        $this->valor->OldValue = $this->valor->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'planilha_custo_idplanilha_custo' first before field var 'x_planilha_custo_idplanilha_custo'
        $val = $CurrentForm->hasValue("planilha_custo_idplanilha_custo") ? $CurrentForm->getValue("planilha_custo_idplanilha_custo") : $CurrentForm->getValue("x_planilha_custo_idplanilha_custo");
        if (!$this->planilha_custo_idplanilha_custo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->planilha_custo_idplanilha_custo->Visible = false; // Disable update for API request
            } else {
                $this->planilha_custo_idplanilha_custo->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_planilha_custo_idplanilha_custo")) {
            $this->planilha_custo_idplanilha_custo->setOldValue($CurrentForm->getValue("o_planilha_custo_idplanilha_custo"));
        }

        // Check field name 'modulo_idmodulo' first before field var 'x_modulo_idmodulo'
        $val = $CurrentForm->hasValue("modulo_idmodulo") ? $CurrentForm->getValue("modulo_idmodulo") : $CurrentForm->getValue("x_modulo_idmodulo");
        if (!$this->modulo_idmodulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->modulo_idmodulo->Visible = false; // Disable update for API request
            } else {
                $this->modulo_idmodulo->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_modulo_idmodulo")) {
            $this->modulo_idmodulo->setOldValue($CurrentForm->getValue("o_modulo_idmodulo"));
        }

        // Check field name 'itens_modulo_iditens_modulo' first before field var 'x_itens_modulo_iditens_modulo'
        $val = $CurrentForm->hasValue("itens_modulo_iditens_modulo") ? $CurrentForm->getValue("itens_modulo_iditens_modulo") : $CurrentForm->getValue("x_itens_modulo_iditens_modulo");
        if (!$this->itens_modulo_iditens_modulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->itens_modulo_iditens_modulo->Visible = false; // Disable update for API request
            } else {
                $this->itens_modulo_iditens_modulo->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_itens_modulo_iditens_modulo")) {
            $this->itens_modulo_iditens_modulo->setOldValue($CurrentForm->getValue("o_itens_modulo_iditens_modulo"));
        }

        // Check field name 'porcentagem' first before field var 'x_porcentagem'
        $val = $CurrentForm->hasValue("porcentagem") ? $CurrentForm->getValue("porcentagem") : $CurrentForm->getValue("x_porcentagem");
        if (!$this->porcentagem->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->porcentagem->Visible = false; // Disable update for API request
            } else {
                $this->porcentagem->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_porcentagem")) {
            $this->porcentagem->setOldValue($CurrentForm->getValue("o_porcentagem"));
        }

        // Check field name 'valor' first before field var 'x_valor'
        $val = $CurrentForm->hasValue("valor") ? $CurrentForm->getValue("valor") : $CurrentForm->getValue("x_valor");
        if (!$this->valor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->valor->Visible = false; // Disable update for API request
            } else {
                $this->valor->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_valor")) {
            $this->valor->setOldValue($CurrentForm->getValue("o_valor"));
        }

        // Check field name 'obs' first before field var 'x_obs'
        $val = $CurrentForm->hasValue("obs") ? $CurrentForm->getValue("obs") : $CurrentForm->getValue("x_obs");
        if (!$this->obs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->obs->Visible = false; // Disable update for API request
            } else {
                $this->obs->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_obs")) {
            $this->obs->setOldValue($CurrentForm->getValue("o_obs"));
        }

        // Check field name 'calculo_idcalculo' first before field var 'x_calculo_idcalculo'
        $val = $CurrentForm->hasValue("calculo_idcalculo") ? $CurrentForm->getValue("calculo_idcalculo") : $CurrentForm->getValue("x_calculo_idcalculo");
        if (!$this->calculo_idcalculo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->calculo_idcalculo->Visible = false; // Disable update for API request
            } else {
                $this->calculo_idcalculo->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_calculo_idcalculo")) {
            $this->calculo_idcalculo->setOldValue($CurrentForm->getValue("o_calculo_idcalculo"));
        }

        // Check field name 'idmovimento_pla_custo' first before field var 'x_idmovimento_pla_custo'
        $val = $CurrentForm->hasValue("idmovimento_pla_custo") ? $CurrentForm->getValue("idmovimento_pla_custo") : $CurrentForm->getValue("x_idmovimento_pla_custo");
        if (!$this->idmovimento_pla_custo->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->idmovimento_pla_custo->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->idmovimento_pla_custo->CurrentValue = $this->idmovimento_pla_custo->FormValue;
        }
        $this->planilha_custo_idplanilha_custo->CurrentValue = $this->planilha_custo_idplanilha_custo->FormValue;
        $this->modulo_idmodulo->CurrentValue = $this->modulo_idmodulo->FormValue;
        $this->itens_modulo_iditens_modulo->CurrentValue = $this->itens_modulo_iditens_modulo->FormValue;
        $this->porcentagem->CurrentValue = $this->porcentagem->FormValue;
        $this->valor->CurrentValue = $this->valor->FormValue;
        $this->obs->CurrentValue = $this->obs->FormValue;
        $this->calculo_idcalculo->CurrentValue = $this->calculo_idcalculo->FormValue;
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
        $this->idmovimento_pla_custo->setDbValue($row['idmovimento_pla_custo']);
        $this->planilha_custo_idplanilha_custo->setDbValue($row['planilha_custo_idplanilha_custo']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->modulo_idmodulo->setDbValue($row['modulo_idmodulo']);
        $this->itens_modulo_iditens_modulo->setDbValue($row['itens_modulo_iditens_modulo']);
        $this->porcentagem->setDbValue($row['porcentagem']);
        $this->valor->setDbValue($row['valor']);
        $this->obs->setDbValue($row['obs']);
        $this->calculo_idcalculo->setDbValue($row['calculo_idcalculo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idmovimento_pla_custo'] = $this->idmovimento_pla_custo->DefaultValue;
        $row['planilha_custo_idplanilha_custo'] = $this->planilha_custo_idplanilha_custo->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['modulo_idmodulo'] = $this->modulo_idmodulo->DefaultValue;
        $row['itens_modulo_iditens_modulo'] = $this->itens_modulo_iditens_modulo->DefaultValue;
        $row['porcentagem'] = $this->porcentagem->DefaultValue;
        $row['valor'] = $this->valor->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
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

        // idmovimento_pla_custo

        // planilha_custo_idplanilha_custo

        // dt_cadastro

        // modulo_idmodulo

        // itens_modulo_iditens_modulo

        // porcentagem

        // valor

        // obs

        // calculo_idcalculo

        // Accumulate aggregate value
        if ($this->RowType != RowType::AGGREGATEINIT && $this->RowType != RowType::AGGREGATE && $this->RowType != RowType::PREVIEWFIELD) {
            $this->itens_modulo_iditens_modulo->Count++; // Increment count
            if (is_numeric($this->porcentagem->CurrentValue)) {
                $this->porcentagem->Total += $this->porcentagem->CurrentValue; // Accumulate total
            }
            if (is_numeric($this->valor->CurrentValue)) {
                $this->valor->Total += $this->valor->CurrentValue; // Accumulate total
            }
        }

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idmovimento_pla_custo
            $this->idmovimento_pla_custo->ViewValue = $this->idmovimento_pla_custo->CurrentValue;

            // planilha_custo_idplanilha_custo
            $this->planilha_custo_idplanilha_custo->ViewValue = $this->planilha_custo_idplanilha_custo->CurrentValue;
            $this->planilha_custo_idplanilha_custo->ViewValue = FormatNumber($this->planilha_custo_idplanilha_custo->ViewValue, $this->planilha_custo_idplanilha_custo->formatPattern());
            $this->planilha_custo_idplanilha_custo->CssClass = "fw-bold";
            $this->planilha_custo_idplanilha_custo->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

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

            // itens_modulo_iditens_modulo
            $curVal = strval($this->itens_modulo_iditens_modulo->CurrentValue);
            if ($curVal != "") {
                $this->itens_modulo_iditens_modulo->ViewValue = $this->itens_modulo_iditens_modulo->lookupCacheOption($curVal);
                if ($this->itens_modulo_iditens_modulo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->itens_modulo_iditens_modulo->Lookup->getTable()->Fields["iditens_modulo"]->searchExpression(), "=", $curVal, $this->itens_modulo_iditens_modulo->Lookup->getTable()->Fields["iditens_modulo"]->searchDataType(), "");
                    $sqlWrk = $this->itens_modulo_iditens_modulo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->itens_modulo_iditens_modulo->Lookup->renderViewRow($rswrk[0]);
                        $this->itens_modulo_iditens_modulo->ViewValue = $this->itens_modulo_iditens_modulo->displayValue($arwrk);
                    } else {
                        $this->itens_modulo_iditens_modulo->ViewValue = FormatNumber($this->itens_modulo_iditens_modulo->CurrentValue, $this->itens_modulo_iditens_modulo->formatPattern());
                    }
                }
            } else {
                $this->itens_modulo_iditens_modulo->ViewValue = null;
            }
            $this->itens_modulo_iditens_modulo->CssClass = "fw-bold";

            // porcentagem
            $this->porcentagem->ViewValue = $this->porcentagem->CurrentValue;
            $this->porcentagem->ViewValue = FormatCurrency($this->porcentagem->ViewValue, $this->porcentagem->formatPattern());
            $this->porcentagem->CssClass = "fw-bold";
            $this->porcentagem->CellCssStyle .= "text-align: right;";

            // valor
            $this->valor->ViewValue = $this->valor->CurrentValue;
            $this->valor->ViewValue = FormatCurrency($this->valor->ViewValue, $this->valor->formatPattern());
            $this->valor->CssClass = "fw-bold";
            $this->valor->CellCssStyle .= "text-align: right;";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->CssClass = "fw-bold";

            // calculo_idcalculo
            $this->calculo_idcalculo->ViewValue = $this->calculo_idcalculo->CurrentValue;
            $this->calculo_idcalculo->ViewValue = FormatNumber($this->calculo_idcalculo->ViewValue, $this->calculo_idcalculo->formatPattern());

            // planilha_custo_idplanilha_custo
            $this->planilha_custo_idplanilha_custo->HrefValue = "";
            $this->planilha_custo_idplanilha_custo->TooltipValue = "";

            // modulo_idmodulo
            $this->modulo_idmodulo->HrefValue = "";
            $this->modulo_idmodulo->TooltipValue = "";

            // itens_modulo_iditens_modulo
            $this->itens_modulo_iditens_modulo->HrefValue = "";
            $this->itens_modulo_iditens_modulo->TooltipValue = "";

            // porcentagem
            $this->porcentagem->HrefValue = "";
            $this->porcentagem->TooltipValue = "";

            // valor
            $this->valor->HrefValue = "";
            $this->valor->TooltipValue = "";

            // obs
            $this->obs->HrefValue = "";
            $this->obs->TooltipValue = "";

            // calculo_idcalculo
            $this->calculo_idcalculo->HrefValue = "";
            $this->calculo_idcalculo->TooltipValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // planilha_custo_idplanilha_custo
            $this->planilha_custo_idplanilha_custo->setupEditAttributes();
            if ($this->planilha_custo_idplanilha_custo->getSessionValue() != "") {
                $this->planilha_custo_idplanilha_custo->CurrentValue = GetForeignKeyValue($this->planilha_custo_idplanilha_custo->getSessionValue());
                $this->planilha_custo_idplanilha_custo->OldValue = $this->planilha_custo_idplanilha_custo->CurrentValue;
                $this->planilha_custo_idplanilha_custo->ViewValue = $this->planilha_custo_idplanilha_custo->CurrentValue;
                $this->planilha_custo_idplanilha_custo->ViewValue = FormatNumber($this->planilha_custo_idplanilha_custo->ViewValue, $this->planilha_custo_idplanilha_custo->formatPattern());
                $this->planilha_custo_idplanilha_custo->CssClass = "fw-bold";
                $this->planilha_custo_idplanilha_custo->CellCssStyle .= "text-align: center;";
            } else {
                $this->planilha_custo_idplanilha_custo->EditValue = $this->planilha_custo_idplanilha_custo->CurrentValue;
                $this->planilha_custo_idplanilha_custo->PlaceHolder = RemoveHtml($this->planilha_custo_idplanilha_custo->caption());
                if (strval($this->planilha_custo_idplanilha_custo->EditValue) != "" && is_numeric($this->planilha_custo_idplanilha_custo->EditValue)) {
                    $this->planilha_custo_idplanilha_custo->EditValue = FormatNumber($this->planilha_custo_idplanilha_custo->EditValue, null);
                }
            }

            // modulo_idmodulo
            $curVal = trim(strval($this->modulo_idmodulo->CurrentValue));
            if ($curVal != "") {
                $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->lookupCacheOption($curVal);
            } else {
                $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->Lookup !== null && is_array($this->modulo_idmodulo->lookupOptions()) && count($this->modulo_idmodulo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->modulo_idmodulo->ViewValue !== null) { // Load from cache
                $this->modulo_idmodulo->EditValue = array_values($this->modulo_idmodulo->lookupOptions());
                if ($this->modulo_idmodulo->ViewValue == "") {
                    $this->modulo_idmodulo->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->modulo_idmodulo->Lookup->getTable()->Fields["idmodulo"]->searchExpression(), "=", $this->modulo_idmodulo->CurrentValue, $this->modulo_idmodulo->Lookup->getTable()->Fields["idmodulo"]->searchDataType(), "");
                }
                $sqlWrk = $this->modulo_idmodulo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->modulo_idmodulo->Lookup->renderViewRow($rswrk[0]);
                    $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->displayValue($arwrk);
                } else {
                    $this->modulo_idmodulo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->modulo_idmodulo->EditValue = $arwrk;
            }
            $this->modulo_idmodulo->PlaceHolder = RemoveHtml($this->modulo_idmodulo->caption());

            // itens_modulo_iditens_modulo
            $curVal = trim(strval($this->itens_modulo_iditens_modulo->CurrentValue));
            if ($curVal != "") {
                $this->itens_modulo_iditens_modulo->ViewValue = $this->itens_modulo_iditens_modulo->lookupCacheOption($curVal);
            } else {
                $this->itens_modulo_iditens_modulo->ViewValue = $this->itens_modulo_iditens_modulo->Lookup !== null && is_array($this->itens_modulo_iditens_modulo->lookupOptions()) && count($this->itens_modulo_iditens_modulo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->itens_modulo_iditens_modulo->ViewValue !== null) { // Load from cache
                $this->itens_modulo_iditens_modulo->EditValue = array_values($this->itens_modulo_iditens_modulo->lookupOptions());
                if ($this->itens_modulo_iditens_modulo->ViewValue == "") {
                    $this->itens_modulo_iditens_modulo->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->itens_modulo_iditens_modulo->Lookup->getTable()->Fields["iditens_modulo"]->searchExpression(), "=", $this->itens_modulo_iditens_modulo->CurrentValue, $this->itens_modulo_iditens_modulo->Lookup->getTable()->Fields["iditens_modulo"]->searchDataType(), "");
                }
                $sqlWrk = $this->itens_modulo_iditens_modulo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->itens_modulo_iditens_modulo->Lookup->renderViewRow($rswrk[0]);
                    $this->itens_modulo_iditens_modulo->ViewValue = $this->itens_modulo_iditens_modulo->displayValue($arwrk);
                } else {
                    $this->itens_modulo_iditens_modulo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->itens_modulo_iditens_modulo->EditValue = $arwrk;
            }
            $this->itens_modulo_iditens_modulo->PlaceHolder = RemoveHtml($this->itens_modulo_iditens_modulo->caption());

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
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // calculo_idcalculo
            $this->calculo_idcalculo->setupEditAttributes();
            if ($this->calculo_idcalculo->getSessionValue() != "") {
                $this->calculo_idcalculo->CurrentValue = GetForeignKeyValue($this->calculo_idcalculo->getSessionValue());
                $this->calculo_idcalculo->OldValue = $this->calculo_idcalculo->CurrentValue;
                $this->calculo_idcalculo->ViewValue = $this->calculo_idcalculo->CurrentValue;
                $this->calculo_idcalculo->ViewValue = FormatNumber($this->calculo_idcalculo->ViewValue, $this->calculo_idcalculo->formatPattern());
            } else {
                $this->calculo_idcalculo->EditValue = $this->calculo_idcalculo->CurrentValue;
                $this->calculo_idcalculo->PlaceHolder = RemoveHtml($this->calculo_idcalculo->caption());
                if (strval($this->calculo_idcalculo->EditValue) != "" && is_numeric($this->calculo_idcalculo->EditValue)) {
                    $this->calculo_idcalculo->EditValue = FormatNumber($this->calculo_idcalculo->EditValue, null);
                }
            }

            // Add refer script

            // planilha_custo_idplanilha_custo
            $this->planilha_custo_idplanilha_custo->HrefValue = "";

            // modulo_idmodulo
            $this->modulo_idmodulo->HrefValue = "";

            // itens_modulo_iditens_modulo
            $this->itens_modulo_iditens_modulo->HrefValue = "";

            // porcentagem
            $this->porcentagem->HrefValue = "";

            // valor
            $this->valor->HrefValue = "";

            // obs
            $this->obs->HrefValue = "";

            // calculo_idcalculo
            $this->calculo_idcalculo->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // planilha_custo_idplanilha_custo
            $this->planilha_custo_idplanilha_custo->setupEditAttributes();
            if ($this->planilha_custo_idplanilha_custo->getSessionValue() != "") {
                $this->planilha_custo_idplanilha_custo->CurrentValue = GetForeignKeyValue($this->planilha_custo_idplanilha_custo->getSessionValue());
                $this->planilha_custo_idplanilha_custo->OldValue = $this->planilha_custo_idplanilha_custo->CurrentValue;
                $this->planilha_custo_idplanilha_custo->ViewValue = $this->planilha_custo_idplanilha_custo->CurrentValue;
                $this->planilha_custo_idplanilha_custo->ViewValue = FormatNumber($this->planilha_custo_idplanilha_custo->ViewValue, $this->planilha_custo_idplanilha_custo->formatPattern());
                $this->planilha_custo_idplanilha_custo->CssClass = "fw-bold";
                $this->planilha_custo_idplanilha_custo->CellCssStyle .= "text-align: center;";
            } else {
                $this->planilha_custo_idplanilha_custo->EditValue = $this->planilha_custo_idplanilha_custo->CurrentValue;
                $this->planilha_custo_idplanilha_custo->PlaceHolder = RemoveHtml($this->planilha_custo_idplanilha_custo->caption());
                if (strval($this->planilha_custo_idplanilha_custo->EditValue) != "" && is_numeric($this->planilha_custo_idplanilha_custo->EditValue)) {
                    $this->planilha_custo_idplanilha_custo->EditValue = FormatNumber($this->planilha_custo_idplanilha_custo->EditValue, null);
                }
            }

            // modulo_idmodulo
            $curVal = trim(strval($this->modulo_idmodulo->CurrentValue));
            if ($curVal != "") {
                $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->lookupCacheOption($curVal);
            } else {
                $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->Lookup !== null && is_array($this->modulo_idmodulo->lookupOptions()) && count($this->modulo_idmodulo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->modulo_idmodulo->ViewValue !== null) { // Load from cache
                $this->modulo_idmodulo->EditValue = array_values($this->modulo_idmodulo->lookupOptions());
                if ($this->modulo_idmodulo->ViewValue == "") {
                    $this->modulo_idmodulo->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->modulo_idmodulo->Lookup->getTable()->Fields["idmodulo"]->searchExpression(), "=", $this->modulo_idmodulo->CurrentValue, $this->modulo_idmodulo->Lookup->getTable()->Fields["idmodulo"]->searchDataType(), "");
                }
                $sqlWrk = $this->modulo_idmodulo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->modulo_idmodulo->Lookup->renderViewRow($rswrk[0]);
                    $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->displayValue($arwrk);
                } else {
                    $this->modulo_idmodulo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->modulo_idmodulo->EditValue = $arwrk;
            }
            $this->modulo_idmodulo->PlaceHolder = RemoveHtml($this->modulo_idmodulo->caption());

            // itens_modulo_iditens_modulo
            $curVal = trim(strval($this->itens_modulo_iditens_modulo->CurrentValue));
            if ($curVal != "") {
                $this->itens_modulo_iditens_modulo->ViewValue = $this->itens_modulo_iditens_modulo->lookupCacheOption($curVal);
            } else {
                $this->itens_modulo_iditens_modulo->ViewValue = $this->itens_modulo_iditens_modulo->Lookup !== null && is_array($this->itens_modulo_iditens_modulo->lookupOptions()) && count($this->itens_modulo_iditens_modulo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->itens_modulo_iditens_modulo->ViewValue !== null) { // Load from cache
                $this->itens_modulo_iditens_modulo->EditValue = array_values($this->itens_modulo_iditens_modulo->lookupOptions());
                if ($this->itens_modulo_iditens_modulo->ViewValue == "") {
                    $this->itens_modulo_iditens_modulo->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->itens_modulo_iditens_modulo->Lookup->getTable()->Fields["iditens_modulo"]->searchExpression(), "=", $this->itens_modulo_iditens_modulo->CurrentValue, $this->itens_modulo_iditens_modulo->Lookup->getTable()->Fields["iditens_modulo"]->searchDataType(), "");
                }
                $sqlWrk = $this->itens_modulo_iditens_modulo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->itens_modulo_iditens_modulo->Lookup->renderViewRow($rswrk[0]);
                    $this->itens_modulo_iditens_modulo->ViewValue = $this->itens_modulo_iditens_modulo->displayValue($arwrk);
                } else {
                    $this->itens_modulo_iditens_modulo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->itens_modulo_iditens_modulo->EditValue = $arwrk;
            }
            $this->itens_modulo_iditens_modulo->PlaceHolder = RemoveHtml($this->itens_modulo_iditens_modulo->caption());

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
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // calculo_idcalculo
            $this->calculo_idcalculo->setupEditAttributes();
            if ($this->calculo_idcalculo->getSessionValue() != "") {
                $this->calculo_idcalculo->CurrentValue = GetForeignKeyValue($this->calculo_idcalculo->getSessionValue());
                $this->calculo_idcalculo->OldValue = $this->calculo_idcalculo->CurrentValue;
                $this->calculo_idcalculo->ViewValue = $this->calculo_idcalculo->CurrentValue;
                $this->calculo_idcalculo->ViewValue = FormatNumber($this->calculo_idcalculo->ViewValue, $this->calculo_idcalculo->formatPattern());
            } else {
                $this->calculo_idcalculo->EditValue = $this->calculo_idcalculo->CurrentValue;
                $this->calculo_idcalculo->PlaceHolder = RemoveHtml($this->calculo_idcalculo->caption());
                if (strval($this->calculo_idcalculo->EditValue) != "" && is_numeric($this->calculo_idcalculo->EditValue)) {
                    $this->calculo_idcalculo->EditValue = FormatNumber($this->calculo_idcalculo->EditValue, null);
                }
            }

            // Edit refer script

            // planilha_custo_idplanilha_custo
            $this->planilha_custo_idplanilha_custo->HrefValue = "";

            // modulo_idmodulo
            $this->modulo_idmodulo->HrefValue = "";

            // itens_modulo_iditens_modulo
            $this->itens_modulo_iditens_modulo->HrefValue = "";

            // porcentagem
            $this->porcentagem->HrefValue = "";

            // valor
            $this->valor->HrefValue = "";

            // obs
            $this->obs->HrefValue = "";

            // calculo_idcalculo
            $this->calculo_idcalculo->HrefValue = "";
        } elseif ($this->RowType == RowType::AGGREGATEINIT) { // Initialize aggregate row
                $this->itens_modulo_iditens_modulo->Count = 0; // Initialize count
                    $this->porcentagem->Total = 0; // Initialize total
                    $this->valor->Total = 0; // Initialize total
        } elseif ($this->RowType == RowType::AGGREGATE) { // Aggregate row
            $this->itens_modulo_iditens_modulo->CurrentValue = $this->itens_modulo_iditens_modulo->Count;
            $this->itens_modulo_iditens_modulo->ViewValue = $this->itens_modulo_iditens_modulo->CurrentValue;
            $this->itens_modulo_iditens_modulo->CssClass = "fw-bold";
            $this->itens_modulo_iditens_modulo->HrefValue = ""; // Clear href value
            $this->porcentagem->CurrentValue = $this->porcentagem->Total;
            $this->porcentagem->ViewValue = $this->porcentagem->CurrentValue;
            $this->porcentagem->ViewValue = FormatCurrency($this->porcentagem->ViewValue, $this->porcentagem->formatPattern());
            $this->porcentagem->CssClass = "fw-bold";
            $this->porcentagem->CellCssStyle .= "text-align: right;";
            $this->porcentagem->HrefValue = ""; // Clear href value
            $this->valor->CurrentValue = $this->valor->Total;
            $this->valor->ViewValue = $this->valor->CurrentValue;
            $this->valor->ViewValue = FormatCurrency($this->valor->ViewValue, $this->valor->formatPattern());
            $this->valor->CssClass = "fw-bold";
            $this->valor->CellCssStyle .= "text-align: right;";
            $this->valor->HrefValue = ""; // Clear href value
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
            if ($this->planilha_custo_idplanilha_custo->Visible && $this->planilha_custo_idplanilha_custo->Required) {
                if (!$this->planilha_custo_idplanilha_custo->IsDetailKey && EmptyValue($this->planilha_custo_idplanilha_custo->FormValue)) {
                    $this->planilha_custo_idplanilha_custo->addErrorMessage(str_replace("%s", $this->planilha_custo_idplanilha_custo->caption(), $this->planilha_custo_idplanilha_custo->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->planilha_custo_idplanilha_custo->FormValue)) {
                $this->planilha_custo_idplanilha_custo->addErrorMessage($this->planilha_custo_idplanilha_custo->getErrorMessage(false));
            }
            if ($this->modulo_idmodulo->Visible && $this->modulo_idmodulo->Required) {
                if (!$this->modulo_idmodulo->IsDetailKey && EmptyValue($this->modulo_idmodulo->FormValue)) {
                    $this->modulo_idmodulo->addErrorMessage(str_replace("%s", $this->modulo_idmodulo->caption(), $this->modulo_idmodulo->RequiredErrorMessage));
                }
            }
            if ($this->itens_modulo_iditens_modulo->Visible && $this->itens_modulo_iditens_modulo->Required) {
                if (!$this->itens_modulo_iditens_modulo->IsDetailKey && EmptyValue($this->itens_modulo_iditens_modulo->FormValue)) {
                    $this->itens_modulo_iditens_modulo->addErrorMessage(str_replace("%s", $this->itens_modulo_iditens_modulo->caption(), $this->itens_modulo_iditens_modulo->RequiredErrorMessage));
                }
            }
            if ($this->porcentagem->Visible && $this->porcentagem->Required) {
                if (!$this->porcentagem->IsDetailKey && EmptyValue($this->porcentagem->FormValue)) {
                    $this->porcentagem->addErrorMessage(str_replace("%s", $this->porcentagem->caption(), $this->porcentagem->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->porcentagem->FormValue)) {
                $this->porcentagem->addErrorMessage($this->porcentagem->getErrorMessage(false));
            }
            if ($this->valor->Visible && $this->valor->Required) {
                if (!$this->valor->IsDetailKey && EmptyValue($this->valor->FormValue)) {
                    $this->valor->addErrorMessage(str_replace("%s", $this->valor->caption(), $this->valor->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->valor->FormValue)) {
                $this->valor->addErrorMessage($this->valor->getErrorMessage(false));
            }
            if ($this->obs->Visible && $this->obs->Required) {
                if (!$this->obs->IsDetailKey && EmptyValue($this->obs->FormValue)) {
                    $this->obs->addErrorMessage(str_replace("%s", $this->obs->caption(), $this->obs->RequiredErrorMessage));
                }
            }
            if ($this->calculo_idcalculo->Visible && $this->calculo_idcalculo->Required) {
                if (!$this->calculo_idcalculo->IsDetailKey && EmptyValue($this->calculo_idcalculo->FormValue)) {
                    $this->calculo_idcalculo->addErrorMessage(str_replace("%s", $this->calculo_idcalculo->caption(), $this->calculo_idcalculo->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->calculo_idcalculo->FormValue)) {
                $this->calculo_idcalculo->addErrorMessage($this->calculo_idcalculo->getErrorMessage(false));
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
            $thisKey .= $row['idmovimento_pla_custo'];

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

        // planilha_custo_idplanilha_custo
        if ($this->planilha_custo_idplanilha_custo->getSessionValue() != "") {
            $this->planilha_custo_idplanilha_custo->ReadOnly = true;
        }
        $this->planilha_custo_idplanilha_custo->setDbValueDef($rsnew, $this->planilha_custo_idplanilha_custo->CurrentValue, $this->planilha_custo_idplanilha_custo->ReadOnly);

        // modulo_idmodulo
        $this->modulo_idmodulo->setDbValueDef($rsnew, $this->modulo_idmodulo->CurrentValue, $this->modulo_idmodulo->ReadOnly);

        // itens_modulo_iditens_modulo
        $this->itens_modulo_iditens_modulo->setDbValueDef($rsnew, $this->itens_modulo_iditens_modulo->CurrentValue, $this->itens_modulo_iditens_modulo->ReadOnly);

        // porcentagem
        $this->porcentagem->setDbValueDef($rsnew, $this->porcentagem->CurrentValue, $this->porcentagem->ReadOnly);

        // valor
        $this->valor->setDbValueDef($rsnew, $this->valor->CurrentValue, $this->valor->ReadOnly);

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, $this->obs->ReadOnly);

        // calculo_idcalculo
        if ($this->calculo_idcalculo->getSessionValue() != "") {
            $this->calculo_idcalculo->ReadOnly = true;
        }
        $this->calculo_idcalculo->setDbValueDef($rsnew, $this->calculo_idcalculo->CurrentValue, $this->calculo_idcalculo->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['planilha_custo_idplanilha_custo'])) { // planilha_custo_idplanilha_custo
            $this->planilha_custo_idplanilha_custo->CurrentValue = $row['planilha_custo_idplanilha_custo'];
        }
        if (isset($row['modulo_idmodulo'])) { // modulo_idmodulo
            $this->modulo_idmodulo->CurrentValue = $row['modulo_idmodulo'];
        }
        if (isset($row['itens_modulo_iditens_modulo'])) { // itens_modulo_iditens_modulo
            $this->itens_modulo_iditens_modulo->CurrentValue = $row['itens_modulo_iditens_modulo'];
        }
        if (isset($row['porcentagem'])) { // porcentagem
            $this->porcentagem->CurrentValue = $row['porcentagem'];
        }
        if (isset($row['valor'])) { // valor
            $this->valor->CurrentValue = $row['valor'];
        }
        if (isset($row['obs'])) { // obs
            $this->obs->CurrentValue = $row['obs'];
        }
        if (isset($row['calculo_idcalculo'])) { // calculo_idcalculo
            $this->calculo_idcalculo->CurrentValue = $row['calculo_idcalculo'];
        }
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "planilha_custo") {
            $this->planilha_custo_idplanilha_custo->Visible = true; // Need to insert foreign key
            $this->planilha_custo_idplanilha_custo->CurrentValue = $this->planilha_custo_idplanilha_custo->getSessionValue();
        }
        if ($this->getCurrentMasterTable() == "calculo") {
            $this->calculo_idcalculo->Visible = true; // Need to insert foreign key
            $this->calculo_idcalculo->CurrentValue = $this->calculo_idcalculo->getSessionValue();
        }

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
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

        // planilha_custo_idplanilha_custo
        $this->planilha_custo_idplanilha_custo->setDbValueDef($rsnew, $this->planilha_custo_idplanilha_custo->CurrentValue, false);

        // modulo_idmodulo
        $this->modulo_idmodulo->setDbValueDef($rsnew, $this->modulo_idmodulo->CurrentValue, false);

        // itens_modulo_iditens_modulo
        $this->itens_modulo_iditens_modulo->setDbValueDef($rsnew, $this->itens_modulo_iditens_modulo->CurrentValue, false);

        // porcentagem
        $this->porcentagem->setDbValueDef($rsnew, $this->porcentagem->CurrentValue, false);

        // valor
        $this->valor->setDbValueDef($rsnew, $this->valor->CurrentValue, strval($this->valor->CurrentValue) == "");

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, false);

        // calculo_idcalculo
        $this->calculo_idcalculo->setDbValueDef($rsnew, $this->calculo_idcalculo->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['planilha_custo_idplanilha_custo'])) { // planilha_custo_idplanilha_custo
            $this->planilha_custo_idplanilha_custo->setFormValue($row['planilha_custo_idplanilha_custo']);
        }
        if (isset($row['modulo_idmodulo'])) { // modulo_idmodulo
            $this->modulo_idmodulo->setFormValue($row['modulo_idmodulo']);
        }
        if (isset($row['itens_modulo_iditens_modulo'])) { // itens_modulo_iditens_modulo
            $this->itens_modulo_iditens_modulo->setFormValue($row['itens_modulo_iditens_modulo']);
        }
        if (isset($row['porcentagem'])) { // porcentagem
            $this->porcentagem->setFormValue($row['porcentagem']);
        }
        if (isset($row['valor'])) { // valor
            $this->valor->setFormValue($row['valor']);
        }
        if (isset($row['obs'])) { // obs
            $this->obs->setFormValue($row['obs']);
        }
        if (isset($row['calculo_idcalculo'])) { // calculo_idcalculo
            $this->calculo_idcalculo->setFormValue($row['calculo_idcalculo']);
        }
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "planilha_custo") {
            $masterTbl = Container("planilha_custo");
            $this->planilha_custo_idplanilha_custo->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        if ($masterTblVar == "calculo") {
            $masterTbl = Container("calculo");
            $this->calculo_idcalculo->Visible = false;
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
                case "x_modulo_idmodulo":
                    break;
                case "x_itens_modulo_iditens_modulo":
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
