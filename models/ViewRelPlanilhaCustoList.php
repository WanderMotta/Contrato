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
class ViewRelPlanilhaCustoList extends ViewRelPlanilhaCusto
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ViewRelPlanilhaCustoList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fview_rel_planilha_custolist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ViewRelPlanilhaCustoList";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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
        $this->idproposta->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->cliente->setVisibility();
        $this->modulo->setVisibility();
        $this->item->setVisibility();
        $this->porcentagem->setVisibility();
        $this->valor->setVisibility();
        $this->obs->setVisibility();
        $this->posicao->setVisibility();
        $this->idplanilha_custo->setVisibility();
        $this->cargo->setVisibility();
        $this->sub_modulos->setVisibility();
        $this->idcliente->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'view_rel_planilha_custo';
        $this->TableName = 'view_rel_planilha_custo';

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
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (view_rel_planilha_custo)
        if (!isset($GLOBALS["view_rel_planilha_custo"]) || $GLOBALS["view_rel_planilha_custo"]::class == PROJECT_NAMESPACE . "view_rel_planilha_custo") {
            $GLOBALS["view_rel_planilha_custo"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ViewRelPlanilhaCustoAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ViewRelPlanilhaCustoDelete";
        $this->MultiUpdateUrl = "ViewRelPlanilhaCustoUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'view_rel_planilha_custo');
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

        // Export options
        $this->ExportOptions = new ListOptions(TagClassName: "ew-export-option");

        // Import options
        $this->ImportOptions = new ListOptions(TagClassName: "ew-import-option");

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions(
            TagClassName: "ew-add-edit-option",
            UseDropDownButton: false,
            DropDownButtonPhrase: $Language->phrase("ButtonAddEdit"),
            UseButtonGroup: true
        );

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(TagClassName: "ew-detail-option");
        // Actions
        $this->OtherOptions["action"] = new ListOptions(TagClassName: "ew-action-option");

        // Column visibility
        $this->OtherOptions["column"] = new ListOptions(
            TableVar: $this->TableVar,
            TagClassName: "ew-column-option",
            ButtonGroupClass: "ew-column-dropdown",
            UseDropDownButton: true,
            DropDownButtonPhrase: $Language->phrase("Columns"),
            DropDownAutoClose: "outside",
            UseButtonGroup: false
        );

        // Filter options
        $this->FilterOptions = new ListOptions(TagClassName: "ew-filter-option");

        // List actions
        $this->ListActions = new ListActions();
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

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }
        DispatchEvent(new PageUnloadedEvent($this), PageUnloadedEvent::NAME);
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $pageName = GetPageName($url);
                $result = ["url" => GetUrl($url), "modal" => "1"];  // Assume return to modal for simplicity
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "ViewRelPlanilhaCustoView"); // If View page, no primary button
                } else { // List page
                    $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                    $this->clearFailureMessage();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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
                        if ($fld->DataType == DataType::MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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
            $key .= @$ar['idproposta'];
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
            $this->idproposta->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->idplanilha_custo->Visible = false;
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
    public $TopContentClass = "ew-top";
    public $MiddleContentClass = "ew-middle";
    public $BottomContentClass = "ew-bottom";
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

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportType = $this->Export; // Get export parameter, used in header
        if ($ExportType != "") {
            global $SkipHeaderFooter;
            $SkipHeaderFooter = true;
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();

        // Setup export options
        $this->setupExportOptions();
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

        // Setup other options
        $this->setupOtherOptions();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fview_rel_planilha_custogrid";
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

        // Process list action first
        if ($this->processListAction()) { // Ajax request
            $this->terminate();
            return;
        }

        // Set up records per page
        $this->setupDisplayRecords();

        // Handle reset command
        $this->resetCmd();

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

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

        // Hide options
        if ($this->isExport() || !(EmptyValue($this->CurrentAction) || $this->isSearch())) {
            $this->ExportOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
            $this->ImportOptions->hideAllOptions();
        }

        // Hide other options
        if ($this->isExport()) {
            $this->OtherOptions->hideAllOptions();
        }

        // Get default search criteria
        AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));
        AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

        // Get basic search values
        $this->loadBasicSearchValues();

        // Get and validate search values for advanced search
        if (EmptyValue($this->UserAction)) { // Skip if user action
            $this->loadSearchValues();
        }

        // Process filter list
        if ($this->processFilterList()) {
            $this->terminate();
            return;
        }
        if (!$this->validateSearch()) {
            // Nothing to do
        }

        // Restore search parms from Session if not searching / reset / export
        if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
            $this->restoreSearchParms();
        }

        // Call Recordset SearchValidated event
        $this->recordsetSearchValidated();

        // Set up sorting order
        $this->setupSortOrder();

        // Get basic search criteria
        if (!$this->hasInvalidFields()) {
            $srchBasic = $this->basicSearchWhere();
        }

        // Get advanced search criteria
        if (!$this->hasInvalidFields()) {
            $srchAdvanced = $this->advancedSearchWhere();
        }

        // Get query builder criteria
        $query = $DashboardReport ? "" : $this->queryBuilderWhere();

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 50; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms() && !$query) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere(); // Save to session
            }

            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere(); // Save to session
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Build search criteria
        if ($query) {
            AddFilter($this->SearchWhere, $query);
        } else {
            AddFilter($this->SearchWhere, $srchAdvanced);
            AddFilter($this->SearchWhere, $srchBasic);
        }

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json" && !$query) {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        if (!$Security->canList()) {
            $this->Filter = "(0=1)"; // Filter all records
        }
        AddFilter($this->Filter, $this->DbDetailFilter);
        AddFilter($this->Filter, $this->SearchWhere);

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
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
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
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if ((EmptyValue($this->CurrentAction) || $this->isSearch()) && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Set up list action columns
        foreach ($this->ListActions as $listAction) {
            if ($listAction->Allowed) {
                if ($listAction->Select == ACTION_MULTIPLE) { // Show checkbox column if multiple action
                    $this->ListOptions["checkbox"]->Visible = true;
                } elseif ($listAction->Select == ACTION_SINGLE) { // Show list action column
                        $this->ListOptions["listactions"]->Visible = true; // Set visible if any list action is allowed
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            if ($query) { // Hide search panel if using QueryBuilder
                RemoveClass($this->SearchPanelClass, "show");
            } else {
                AppendClass($this->SearchPanelClass, "show");
            }
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

    // Get list of filters
    public function getFilterList()
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->idproposta->AdvancedSearch->toJson(), ","); // Field idproposta
        $filterList = Concat($filterList, $this->dt_cadastro->AdvancedSearch->toJson(), ","); // Field dt_cadastro
        $filterList = Concat($filterList, $this->cliente->AdvancedSearch->toJson(), ","); // Field cliente
        $filterList = Concat($filterList, $this->modulo->AdvancedSearch->toJson(), ","); // Field modulo
        $filterList = Concat($filterList, $this->item->AdvancedSearch->toJson(), ","); // Field item
        $filterList = Concat($filterList, $this->porcentagem->AdvancedSearch->toJson(), ","); // Field porcentagem
        $filterList = Concat($filterList, $this->valor->AdvancedSearch->toJson(), ","); // Field valor
        $filterList = Concat($filterList, $this->obs->AdvancedSearch->toJson(), ","); // Field obs
        $filterList = Concat($filterList, $this->posicao->AdvancedSearch->toJson(), ","); // Field posicao
        $filterList = Concat($filterList, $this->idplanilha_custo->AdvancedSearch->toJson(), ","); // Field idplanilha_custo
        $filterList = Concat($filterList, $this->cargo->AdvancedSearch->toJson(), ","); // Field cargo
        $filterList = Concat($filterList, $this->sub_modulos->AdvancedSearch->toJson(), ","); // Field sub_modulos
        $filterList = Concat($filterList, $this->idcliente->AdvancedSearch->toJson(), ","); // Field idcliente
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            Profile()->setSearchFilters("fview_rel_planilha_custosrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field idproposta
        $this->idproposta->AdvancedSearch->SearchValue = @$filter["x_idproposta"];
        $this->idproposta->AdvancedSearch->SearchOperator = @$filter["z_idproposta"];
        $this->idproposta->AdvancedSearch->SearchCondition = @$filter["v_idproposta"];
        $this->idproposta->AdvancedSearch->SearchValue2 = @$filter["y_idproposta"];
        $this->idproposta->AdvancedSearch->SearchOperator2 = @$filter["w_idproposta"];
        $this->idproposta->AdvancedSearch->save();

        // Field dt_cadastro
        $this->dt_cadastro->AdvancedSearch->SearchValue = @$filter["x_dt_cadastro"];
        $this->dt_cadastro->AdvancedSearch->SearchOperator = @$filter["z_dt_cadastro"];
        $this->dt_cadastro->AdvancedSearch->SearchCondition = @$filter["v_dt_cadastro"];
        $this->dt_cadastro->AdvancedSearch->SearchValue2 = @$filter["y_dt_cadastro"];
        $this->dt_cadastro->AdvancedSearch->SearchOperator2 = @$filter["w_dt_cadastro"];
        $this->dt_cadastro->AdvancedSearch->save();

        // Field cliente
        $this->cliente->AdvancedSearch->SearchValue = @$filter["x_cliente"];
        $this->cliente->AdvancedSearch->SearchOperator = @$filter["z_cliente"];
        $this->cliente->AdvancedSearch->SearchCondition = @$filter["v_cliente"];
        $this->cliente->AdvancedSearch->SearchValue2 = @$filter["y_cliente"];
        $this->cliente->AdvancedSearch->SearchOperator2 = @$filter["w_cliente"];
        $this->cliente->AdvancedSearch->save();

        // Field modulo
        $this->modulo->AdvancedSearch->SearchValue = @$filter["x_modulo"];
        $this->modulo->AdvancedSearch->SearchOperator = @$filter["z_modulo"];
        $this->modulo->AdvancedSearch->SearchCondition = @$filter["v_modulo"];
        $this->modulo->AdvancedSearch->SearchValue2 = @$filter["y_modulo"];
        $this->modulo->AdvancedSearch->SearchOperator2 = @$filter["w_modulo"];
        $this->modulo->AdvancedSearch->save();

        // Field item
        $this->item->AdvancedSearch->SearchValue = @$filter["x_item"];
        $this->item->AdvancedSearch->SearchOperator = @$filter["z_item"];
        $this->item->AdvancedSearch->SearchCondition = @$filter["v_item"];
        $this->item->AdvancedSearch->SearchValue2 = @$filter["y_item"];
        $this->item->AdvancedSearch->SearchOperator2 = @$filter["w_item"];
        $this->item->AdvancedSearch->save();

        // Field porcentagem
        $this->porcentagem->AdvancedSearch->SearchValue = @$filter["x_porcentagem"];
        $this->porcentagem->AdvancedSearch->SearchOperator = @$filter["z_porcentagem"];
        $this->porcentagem->AdvancedSearch->SearchCondition = @$filter["v_porcentagem"];
        $this->porcentagem->AdvancedSearch->SearchValue2 = @$filter["y_porcentagem"];
        $this->porcentagem->AdvancedSearch->SearchOperator2 = @$filter["w_porcentagem"];
        $this->porcentagem->AdvancedSearch->save();

        // Field valor
        $this->valor->AdvancedSearch->SearchValue = @$filter["x_valor"];
        $this->valor->AdvancedSearch->SearchOperator = @$filter["z_valor"];
        $this->valor->AdvancedSearch->SearchCondition = @$filter["v_valor"];
        $this->valor->AdvancedSearch->SearchValue2 = @$filter["y_valor"];
        $this->valor->AdvancedSearch->SearchOperator2 = @$filter["w_valor"];
        $this->valor->AdvancedSearch->save();

        // Field obs
        $this->obs->AdvancedSearch->SearchValue = @$filter["x_obs"];
        $this->obs->AdvancedSearch->SearchOperator = @$filter["z_obs"];
        $this->obs->AdvancedSearch->SearchCondition = @$filter["v_obs"];
        $this->obs->AdvancedSearch->SearchValue2 = @$filter["y_obs"];
        $this->obs->AdvancedSearch->SearchOperator2 = @$filter["w_obs"];
        $this->obs->AdvancedSearch->save();

        // Field posicao
        $this->posicao->AdvancedSearch->SearchValue = @$filter["x_posicao"];
        $this->posicao->AdvancedSearch->SearchOperator = @$filter["z_posicao"];
        $this->posicao->AdvancedSearch->SearchCondition = @$filter["v_posicao"];
        $this->posicao->AdvancedSearch->SearchValue2 = @$filter["y_posicao"];
        $this->posicao->AdvancedSearch->SearchOperator2 = @$filter["w_posicao"];
        $this->posicao->AdvancedSearch->save();

        // Field idplanilha_custo
        $this->idplanilha_custo->AdvancedSearch->SearchValue = @$filter["x_idplanilha_custo"];
        $this->idplanilha_custo->AdvancedSearch->SearchOperator = @$filter["z_idplanilha_custo"];
        $this->idplanilha_custo->AdvancedSearch->SearchCondition = @$filter["v_idplanilha_custo"];
        $this->idplanilha_custo->AdvancedSearch->SearchValue2 = @$filter["y_idplanilha_custo"];
        $this->idplanilha_custo->AdvancedSearch->SearchOperator2 = @$filter["w_idplanilha_custo"];
        $this->idplanilha_custo->AdvancedSearch->save();

        // Field cargo
        $this->cargo->AdvancedSearch->SearchValue = @$filter["x_cargo"];
        $this->cargo->AdvancedSearch->SearchOperator = @$filter["z_cargo"];
        $this->cargo->AdvancedSearch->SearchCondition = @$filter["v_cargo"];
        $this->cargo->AdvancedSearch->SearchValue2 = @$filter["y_cargo"];
        $this->cargo->AdvancedSearch->SearchOperator2 = @$filter["w_cargo"];
        $this->cargo->AdvancedSearch->save();

        // Field sub_modulos
        $this->sub_modulos->AdvancedSearch->SearchValue = @$filter["x_sub_modulos"];
        $this->sub_modulos->AdvancedSearch->SearchOperator = @$filter["z_sub_modulos"];
        $this->sub_modulos->AdvancedSearch->SearchCondition = @$filter["v_sub_modulos"];
        $this->sub_modulos->AdvancedSearch->SearchValue2 = @$filter["y_sub_modulos"];
        $this->sub_modulos->AdvancedSearch->SearchOperator2 = @$filter["w_sub_modulos"];
        $this->sub_modulos->AdvancedSearch->save();

        // Field idcliente
        $this->idcliente->AdvancedSearch->SearchValue = @$filter["x_idcliente"];
        $this->idcliente->AdvancedSearch->SearchOperator = @$filter["z_idcliente"];
        $this->idcliente->AdvancedSearch->SearchCondition = @$filter["v_idcliente"];
        $this->idcliente->AdvancedSearch->SearchValue2 = @$filter["y_idcliente"];
        $this->idcliente->AdvancedSearch->SearchOperator2 = @$filter["w_idcliente"];
        $this->idcliente->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Advanced search WHERE clause based on QueryString
    public function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->idproposta, $default, false); // idproposta
        $this->buildSearchSql($where, $this->dt_cadastro, $default, false); // dt_cadastro
        $this->buildSearchSql($where, $this->cliente, $default, false); // cliente
        $this->buildSearchSql($where, $this->modulo, $default, false); // modulo
        $this->buildSearchSql($where, $this->item, $default, false); // item
        $this->buildSearchSql($where, $this->porcentagem, $default, false); // porcentagem
        $this->buildSearchSql($where, $this->valor, $default, false); // valor
        $this->buildSearchSql($where, $this->obs, $default, false); // obs
        $this->buildSearchSql($where, $this->posicao, $default, false); // posicao
        $this->buildSearchSql($where, $this->idplanilha_custo, $default, false); // idplanilha_custo
        $this->buildSearchSql($where, $this->cargo, $default, false); // cargo
        $this->buildSearchSql($where, $this->sub_modulos, $default, false); // sub_modulos
        $this->buildSearchSql($where, $this->idcliente, $default, false); // idcliente

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->idproposta->AdvancedSearch->save(); // idproposta
            $this->dt_cadastro->AdvancedSearch->save(); // dt_cadastro
            $this->cliente->AdvancedSearch->save(); // cliente
            $this->modulo->AdvancedSearch->save(); // modulo
            $this->item->AdvancedSearch->save(); // item
            $this->porcentagem->AdvancedSearch->save(); // porcentagem
            $this->valor->AdvancedSearch->save(); // valor
            $this->obs->AdvancedSearch->save(); // obs
            $this->posicao->AdvancedSearch->save(); // posicao
            $this->idplanilha_custo->AdvancedSearch->save(); // idplanilha_custo
            $this->cargo->AdvancedSearch->save(); // cargo
            $this->sub_modulos->AdvancedSearch->save(); // sub_modulos
            $this->idcliente->AdvancedSearch->save(); // idcliente

            // Clear rules for QueryBuilder
            $this->setSessionRules("");
        }
        return $where;
    }

    // Query builder rules
    public function queryBuilderRules()
    {
        return Post("rules") ?? $this->getSessionRules();
    }

    // Quey builder WHERE clause
    public function queryBuilderWhere($fieldName = "")
    {
        global $Security;
        if (!$Security->canSearch()) {
            return "";
        }

        // Get rules by query builder
        $rules = $this->queryBuilderRules();

        // Decode and parse rules
        $where = $rules ? $this->parseRules(json_decode($rules, true), $fieldName) : "";

        // Clear other search and save rules to session
        if ($where && $fieldName == "") { // Skip if get query for specific field
            $this->resetSearchParms();
            $this->idproposta->AdvancedSearch->save(); // idproposta
            $this->dt_cadastro->AdvancedSearch->save(); // dt_cadastro
            $this->cliente->AdvancedSearch->save(); // cliente
            $this->modulo->AdvancedSearch->save(); // modulo
            $this->item->AdvancedSearch->save(); // item
            $this->porcentagem->AdvancedSearch->save(); // porcentagem
            $this->valor->AdvancedSearch->save(); // valor
            $this->obs->AdvancedSearch->save(); // obs
            $this->posicao->AdvancedSearch->save(); // posicao
            $this->idplanilha_custo->AdvancedSearch->save(); // idplanilha_custo
            $this->cargo->AdvancedSearch->save(); // cargo
            $this->sub_modulos->AdvancedSearch->save(); // sub_modulos
            $this->idcliente->AdvancedSearch->save(); // idcliente
            $this->setSessionRules($rules);
        }

        // Return query
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, $fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = $default ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = $default ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $fldVal = ConvertSearchValue($fldVal, $fldOpr, $fld);
        $fldVal2 = ConvertSearchValue($fldVal2, $fldOpr2, $fld);
        $fldOpr = ConvertSearchOperator($fldOpr, $fld, $fldVal);
        $fldOpr2 = ConvertSearchOperator($fldOpr2, $fld, $fldVal2);
        $wrk = "";
        $sep = $fld->UseFilter ? Config("FILTER_OPTION_SEPARATOR") : Config("MULTIPLE_OPTION_SEPARATOR");
        if (is_array($fldVal)) {
            $fldVal = implode($sep, $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode($sep, $fldVal2);
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 && !$fld->UseFilter || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = $fldVal2 != "" ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            AddFilter($wrk, $wrk2, $fldCond);
        } else {
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        if ($this->SearchOption == "AUTO" && in_array($this->BasicSearch->getType(), ["AND", "OR"])) {
            $cond = $this->BasicSearch->getType();
        } else {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
        }
        AddFilter($where, $wrk, $cond);
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Field idproposta
        $filter = $this->queryBuilderWhere("idproposta");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->idproposta, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->idproposta->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field dt_cadastro
        $filter = $this->queryBuilderWhere("dt_cadastro");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->dt_cadastro, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->dt_cadastro->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cliente
        $filter = $this->queryBuilderWhere("cliente");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cliente, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cliente->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field modulo
        $filter = $this->queryBuilderWhere("modulo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->modulo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->modulo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field item
        $filter = $this->queryBuilderWhere("item");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->item, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->item->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field porcentagem
        $filter = $this->queryBuilderWhere("porcentagem");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->porcentagem, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->porcentagem->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field valor
        $filter = $this->queryBuilderWhere("valor");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->valor, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->valor->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field obs
        $filter = $this->queryBuilderWhere("obs");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->obs, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->obs->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field posicao
        $filter = $this->queryBuilderWhere("posicao");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->posicao, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->posicao->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field idplanilha_custo
        $filter = $this->queryBuilderWhere("idplanilha_custo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->idplanilha_custo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->idplanilha_custo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cargo
        $filter = $this->queryBuilderWhere("cargo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cargo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cargo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field sub_modulos
        $filter = $this->queryBuilderWhere("sub_modulos");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->sub_modulos, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->sub_modulos->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field idcliente
        $filter = $this->queryBuilderWhere("idcliente");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->idcliente, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->idcliente->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }
        if ($this->BasicSearch->Keyword != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $Language->phrase("BasicSearchKeyword") . "</span>" . $captionSuffix . $this->BasicSearch->Keyword . "</div>";
        }

        // Show Filters
        if ($filterList != "") {
            $message = "<div id=\"ew-filter-list\" class=\"callout callout-info d-table\"><div id=\"ew-current-filters\">" .
                $Language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
            $this->messageShowing($message, "");
            Write($message);
        } else { // Output empty tag
            Write("<div id=\"ew-filter-list\"></div>");
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    public function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }

        // Fields to search
        $searchFlds = [];
        $searchFlds[] = &$this->cliente;
        $searchFlds[] = &$this->modulo;
        $searchFlds[] = &$this->item;
        $searchFlds[] = &$this->obs;
        $searchFlds[] = &$this->cargo;
        $searchKeyword = $default ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = $default ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            $searchStr = GetQuickSearchFilter($searchFlds, $ar, $searchType, Config("BASIC_SEARCH_ANY_FIELDS"), $this->Dbid);
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);

            // Clear rules for QueryBuilder
            $this->setSessionRules("");
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        if ($this->idproposta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->dt_cadastro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cliente->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->modulo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->item->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->porcentagem->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->valor->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->obs->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->posicao->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->idplanilha_custo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cargo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->sub_modulos->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->idcliente->AdvancedSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();

        // Clear queryBuilder
        $this->setSessionRules("");
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
        $this->idproposta->AdvancedSearch->unsetSession();
        $this->dt_cadastro->AdvancedSearch->unsetSession();
        $this->cliente->AdvancedSearch->unsetSession();
        $this->modulo->AdvancedSearch->unsetSession();
        $this->item->AdvancedSearch->unsetSession();
        $this->porcentagem->AdvancedSearch->unsetSession();
        $this->valor->AdvancedSearch->unsetSession();
        $this->obs->AdvancedSearch->unsetSession();
        $this->posicao->AdvancedSearch->unsetSession();
        $this->idplanilha_custo->AdvancedSearch->unsetSession();
        $this->cargo->AdvancedSearch->unsetSession();
        $this->sub_modulos->AdvancedSearch->unsetSession();
        $this->idcliente->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->idproposta->AdvancedSearch->load();
        $this->dt_cadastro->AdvancedSearch->load();
        $this->cliente->AdvancedSearch->load();
        $this->modulo->AdvancedSearch->load();
        $this->item->AdvancedSearch->load();
        $this->porcentagem->AdvancedSearch->load();
        $this->valor->AdvancedSearch->load();
        $this->obs->AdvancedSearch->load();
        $this->posicao->AdvancedSearch->load();
        $this->idplanilha_custo->AdvancedSearch->load();
        $this->cargo->AdvancedSearch->load();
        $this->sub_modulos->AdvancedSearch->load();
        $this->idcliente->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = ""; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for Ctrl pressed
        $ctrl = Get("ctrl") !== null;

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->idproposta, $ctrl); // idproposta
            $this->updateSort($this->dt_cadastro, $ctrl); // dt_cadastro
            $this->updateSort($this->cliente, $ctrl); // cliente
            $this->updateSort($this->modulo, $ctrl); // modulo
            $this->updateSort($this->item, $ctrl); // item
            $this->updateSort($this->porcentagem, $ctrl); // porcentagem
            $this->updateSort($this->valor, $ctrl); // valor
            $this->updateSort($this->obs, $ctrl); // obs
            $this->updateSort($this->posicao, $ctrl); // posicao
            $this->updateSort($this->idplanilha_custo, $ctrl); // idplanilha_custo
            $this->updateSort($this->cargo, $ctrl); // cargo
            $this->updateSort($this->sub_modulos, $ctrl); // sub_modulos
            $this->updateSort($this->idcliente, $ctrl); // idcliente
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
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->idproposta->setSort("");
                $this->dt_cadastro->setSort("");
                $this->cliente->setSort("");
                $this->modulo->setSort("");
                $this->item->setSort("");
                $this->porcentagem->setSort("");
                $this->valor->setSort("");
                $this->obs->setSort("");
                $this->posicao->setSort("");
                $this->idplanilha_custo->setSort("");
                $this->cargo->setSort("");
                $this->sub_modulos->setSort("");
                $this->idcliente->setSort("");
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

        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = true;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = true;
        $item->Header = "<div class=\"form-check\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"form-check-input\" data-ew-action=\"select-all-keys\"></div>";
        if ($item->OnLeft) {
            $item->moveTo(0);
        }
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

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
        $this->setupListOptionsExt();
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
        $pageUrl = $this->pageUrl(false);
        if ($this->CurrentMode == "view") { // Check view mode
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions as $listAction) {
                $action = $listAction->Action;
                $allowed = $listAction->Allowed;
                $disabled = false;
                if ($listAction->Select == ACTION_SINGLE && $allowed) {
                    $caption = $listAction->Caption;
                    $title = HtmlTitle($caption);
                    if ($action != "") {
                        $icon = ($listAction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listAction->Icon)) . "\" data-caption=\"" . $title . "\"></i> " : "";
                        $link = $disabled
                            ? "<li><div class=\"alert alert-light\">" . $icon . " " . $caption . "</div></li>"
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fview_rel_planilha_custolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fview_rel_planilha_custolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
                        }
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = implode(array_map(fn($link) => "<li>" . $link . "</li>", $links));
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->idproposta->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "idproposta");
            $this->createColumnOption($option, "dt_cadastro");
            $this->createColumnOption($option, "cliente");
            $this->createColumnOption($option, "modulo");
            $this->createColumnOption($option, "item");
            $this->createColumnOption($option, "porcentagem");
            $this->createColumnOption($option, "valor");
            $this->createColumnOption($option, "obs");
            $this->createColumnOption($option, "posicao");
            $this->createColumnOption($option, "idplanilha_custo");
            $this->createColumnOption($option, "cargo");
            $this->createColumnOption($option, "sub_modulos");
            $this->createColumnOption($option, "idcliente");
        }

        // Set up custom actions
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions[$name] = $action;
        }

        // Set up options default
        foreach ($options as $name => $option) {
            if ($name != "column") { // Always use dropdown for column
                $option->UseDropDownButton = false;
                $option->UseButtonGroup = true;
            }
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fview_rel_planilha_custosrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fview_rel_planilha_custosrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Page header/footer options
        $this->HeaderOptions = new ListOptions(TagClassName: "ew-header-option", UseDropDownButton: false, UseButtonGroup: false);
        $item = &$this->HeaderOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
        $this->FooterOptions = new ListOptions(TagClassName: "ew-footer-option", UseDropDownButton: false, UseButtonGroup: false);
        $item = &$this->FooterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Show active user count from SQL
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
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions as $listAction) {
            if ($listAction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listAction->Action);
                $caption = $listAction->Caption;
                $icon = ($listAction->Icon != "") ? '<i class="' . HtmlEncode($listAction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fview_rel_planilha_custolist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
                $item->Visible = $listAction->Allowed;
            }
        }

        // Hide multi edit, grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security, $Response;
        $users = [];
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("action", "");
        if ($filter != "" && $userAction != "") {
            $conn = $this->getConnection();
            // Clear current action
            $this->CurrentAction = "";
            // Check permission first
            $actionCaption = $userAction;
            $listAction = $this->ListActions[$userAction] ?? null;
            if ($listAction) {
                $this->UserAction = $userAction;
                $actionCaption = $listAction->Caption ?: $listAction->Action;
                if (!$listAction->Allowed) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            } else {
                // Skip checking, handle by Row_CustomAction
            }
            $rows = $this->loadRs($filter)->fetchAllAssociative();
            $this->SelectedCount = count($rows);
            $this->ActionValue = Post("actionvalue");

            // Call row action event
            if ($this->SelectedCount > 0) {
                if ($this->UseTransaction) {
                    $conn->beginTransaction();
                }
                $this->SelectedIndex = 0;
                foreach ($rows as $row) {
                    $this->SelectedIndex++;
                    if ($listAction) {
                        $processed = $listAction->handle($row, $this);
                        if (!$processed) {
                            break;
                        }
                    }
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                }
                if ($processed) {
                    if ($this->UseTransaction) { // Commit transaction
                        if ($conn->isTransactionActive()) {
                            $conn->commit();
                        }
                    }
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($listAction->SuccessMessage);
                    }
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage(str_replace("%s", $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        if ($conn->isTransactionActive()) {
                            $conn->rollback();
                        }
                    }
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($listAction->FailureMessage);
                    }

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if (Post("ajax") == $userAction) { // Ajax
                if (WithJsonResponse()) { // List action returns JSON
                    $this->clearSuccessMessage(); // Clear success message
                    $this->clearFailureMessage(); // Clear failure message
                } else {
                    if ($this->getSuccessMessage() != "") {
                        echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                        $this->clearSuccessMessage(); // Clear success message
                    }
                    if ($this->getFailureMessage() != "") {
                        echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                        $this->clearFailureMessage(); // Clear failure message
                    }
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up Grid
    public function setupGrid()
    {
        global $CurrentForm;
        if ($this->ExportAll && $this->isExport()) {
            $this->StopRecord = $this->TotalRecords;
        } else {
            // Set the last record to display
            if ($this->TotalRecords > $this->StartRecord + $this->DisplayRecords - 1) {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            } else {
                $this->StopRecord = $this->TotalRecords;
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_view_rel_planilha_custo", "data-rowtype" => RowType::ADD]);
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

        // Set up key count
        $this->KeyCount = $this->RowIndex;

        // Init row class and style
        $this->resetAttributes();
        $this->CssClass = "";
        if ($this->isCopy() && $this->InlineRowCount == 0 && !$this->loadRow()) { // Inline copy
            $this->CurrentAction = "add";
        }
        if ($this->isAdd() && $this->InlineRowCount == 0 || $this->isGridAdd()) {
            $this->loadRowValues(); // Load default values
            $this->OldKey = "";
            $this->setKey($this->OldKey);
        } elseif ($this->isInlineInserted() && $this->UseInfiniteScroll) {
            // Nothing to do, just use current values
        } elseif (!($this->isCopy() && $this->InlineRowCount == 0)) {
            $this->loadRowValues($this->CurrentRow); // Load row values
            if ($this->isGridEdit() || $this->isMultiEdit()) {
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
                $this->setKey($this->OldKey);
            }
        }
        $this->RowType = RowType::VIEW; // Render view
        if (($this->isAdd() || $this->isCopy()) && $this->InlineRowCount == 0 || $this->isGridAdd()) { // Add
            $this->RowType = RowType::ADD; // Render add
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
            "id" => "r" . $this->RowCount . "_view_rel_planilha_custo",
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

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // Load query builder rules
        $rules = Post("rules");
        if ($rules && $this->Command == "") {
            $this->QueryRules = $rules;
            $this->Command = "search";
        }

        // idproposta
        if ($this->idproposta->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->idproposta->AdvancedSearch->SearchValue != "" || $this->idproposta->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // dt_cadastro
        if ($this->dt_cadastro->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->dt_cadastro->AdvancedSearch->SearchValue != "" || $this->dt_cadastro->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cliente
        if ($this->cliente->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cliente->AdvancedSearch->SearchValue != "" || $this->cliente->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // modulo
        if ($this->modulo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->modulo->AdvancedSearch->SearchValue != "" || $this->modulo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // item
        if ($this->item->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->item->AdvancedSearch->SearchValue != "" || $this->item->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // porcentagem
        if ($this->porcentagem->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->porcentagem->AdvancedSearch->SearchValue != "" || $this->porcentagem->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // valor
        if ($this->valor->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->valor->AdvancedSearch->SearchValue != "" || $this->valor->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // obs
        if ($this->obs->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->obs->AdvancedSearch->SearchValue != "" || $this->obs->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // posicao
        if ($this->posicao->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->posicao->AdvancedSearch->SearchValue != "" || $this->posicao->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // idplanilha_custo
        if ($this->idplanilha_custo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->idplanilha_custo->AdvancedSearch->SearchValue != "" || $this->idplanilha_custo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cargo
        if ($this->cargo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cargo->AdvancedSearch->SearchValue != "" || $this->cargo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // sub_modulos
        if ($this->sub_modulos->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->sub_modulos->AdvancedSearch->SearchValue != "" || $this->sub_modulos->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // idcliente
        if ($this->idcliente->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->idcliente->AdvancedSearch->SearchValue != "" || $this->idcliente->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
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

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idproposta'] = $this->idproposta->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['cliente'] = $this->cliente->DefaultValue;
        $row['modulo'] = $this->modulo->DefaultValue;
        $row['item'] = $this->item->DefaultValue;
        $row['porcentagem'] = $this->porcentagem->DefaultValue;
        $row['valor'] = $this->valor->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
        $row['posicao'] = $this->posicao->DefaultValue;
        $row['idplanilha_custo'] = $this->idplanilha_custo->DefaultValue;
        $row['cargo'] = $this->cargo->DefaultValue;
        $row['sub_modulos'] = $this->sub_modulos->DefaultValue;
        $row['idcliente'] = $this->idcliente->DefaultValue;
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
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

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

        // View row
        if ($this->RowType == RowType::VIEW) {
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
        } elseif ($this->RowType == RowType::SEARCH) {
            // idproposta
            $this->idproposta->setupEditAttributes();
            $this->idproposta->EditValue = $this->idproposta->AdvancedSearch->SearchValue;
            $this->idproposta->PlaceHolder = RemoveHtml($this->idproposta->caption());

            // dt_cadastro
            $this->dt_cadastro->setupEditAttributes();
            $this->dt_cadastro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->formatPattern()));
            $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

            // cliente
            $this->cliente->setupEditAttributes();
            if (!$this->cliente->Raw) {
                $this->cliente->AdvancedSearch->SearchValue = HtmlDecode($this->cliente->AdvancedSearch->SearchValue);
            }
            $this->cliente->EditValue = HtmlEncode($this->cliente->AdvancedSearch->SearchValue);
            $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());

            // modulo
            $this->modulo->setupEditAttributes();
            if (!$this->modulo->Raw) {
                $this->modulo->AdvancedSearch->SearchValue = HtmlDecode($this->modulo->AdvancedSearch->SearchValue);
            }
            $this->modulo->EditValue = HtmlEncode($this->modulo->AdvancedSearch->SearchValue);
            $this->modulo->PlaceHolder = RemoveHtml($this->modulo->caption());

            // item
            $this->item->setupEditAttributes();
            if (!$this->item->Raw) {
                $this->item->AdvancedSearch->SearchValue = HtmlDecode($this->item->AdvancedSearch->SearchValue);
            }
            $this->item->EditValue = HtmlEncode($this->item->AdvancedSearch->SearchValue);
            $this->item->PlaceHolder = RemoveHtml($this->item->caption());

            // porcentagem
            $this->porcentagem->setupEditAttributes();
            $this->porcentagem->EditValue = $this->porcentagem->AdvancedSearch->SearchValue;
            $this->porcentagem->PlaceHolder = RemoveHtml($this->porcentagem->caption());

            // valor
            $this->valor->setupEditAttributes();
            $this->valor->EditValue = $this->valor->AdvancedSearch->SearchValue;
            $this->valor->PlaceHolder = RemoveHtml($this->valor->caption());

            // obs
            $this->obs->setupEditAttributes();
            if (!$this->obs->Raw) {
                $this->obs->AdvancedSearch->SearchValue = HtmlDecode($this->obs->AdvancedSearch->SearchValue);
            }
            $this->obs->EditValue = HtmlEncode($this->obs->AdvancedSearch->SearchValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // posicao
            $this->posicao->setupEditAttributes();
            $this->posicao->EditValue = $this->posicao->AdvancedSearch->SearchValue;
            $this->posicao->PlaceHolder = RemoveHtml($this->posicao->caption());

            // idplanilha_custo
            $curVal = trim(strval($this->idplanilha_custo->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->idplanilha_custo->AdvancedSearch->ViewValue = $this->idplanilha_custo->lookupCacheOption($curVal);
            } else {
                $this->idplanilha_custo->AdvancedSearch->ViewValue = $this->idplanilha_custo->Lookup !== null && is_array($this->idplanilha_custo->lookupOptions()) && count($this->idplanilha_custo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->idplanilha_custo->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->idplanilha_custo->EditValue = array_values($this->idplanilha_custo->lookupOptions());
                if ($this->idplanilha_custo->AdvancedSearch->ViewValue == "") {
                    $this->idplanilha_custo->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->idplanilha_custo->Lookup->getTable()->Fields["idplanilha_custo"]->searchExpression(), "=", $this->idplanilha_custo->AdvancedSearch->SearchValue, $this->idplanilha_custo->Lookup->getTable()->Fields["idplanilha_custo"]->searchDataType(), "");
                }
                $sqlWrk = $this->idplanilha_custo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idplanilha_custo->Lookup->renderViewRow($rswrk[0]);
                    $this->idplanilha_custo->AdvancedSearch->ViewValue = $this->idplanilha_custo->displayValue($arwrk);
                } else {
                    $this->idplanilha_custo->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->idplanilha_custo->EditValue = $arwrk;
            }
            $this->idplanilha_custo->PlaceHolder = RemoveHtml($this->idplanilha_custo->caption());

            // cargo
            $this->cargo->setupEditAttributes();
            if (!$this->cargo->Raw) {
                $this->cargo->AdvancedSearch->SearchValue = HtmlDecode($this->cargo->AdvancedSearch->SearchValue);
            }
            $this->cargo->EditValue = HtmlEncode($this->cargo->AdvancedSearch->SearchValue);
            $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

            // sub_modulos
            $this->sub_modulos->setupEditAttributes();
            $this->sub_modulos->EditValue = $this->sub_modulos->AdvancedSearch->SearchValue;
            $this->sub_modulos->PlaceHolder = RemoveHtml($this->sub_modulos->caption());

            // idcliente
            $this->idcliente->setupEditAttributes();
            $this->idcliente->EditValue = $this->idcliente->AdvancedSearch->SearchValue;
            $this->idcliente->PlaceHolder = RemoveHtml($this->idcliente->caption());
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->idproposta->AdvancedSearch->load();
        $this->dt_cadastro->AdvancedSearch->load();
        $this->cliente->AdvancedSearch->load();
        $this->modulo->AdvancedSearch->load();
        $this->item->AdvancedSearch->load();
        $this->porcentagem->AdvancedSearch->load();
        $this->valor->AdvancedSearch->load();
        $this->obs->AdvancedSearch->load();
        $this->posicao->AdvancedSearch->load();
        $this->idplanilha_custo->AdvancedSearch->load();
        $this->cargo->AdvancedSearch->load();
        $this->sub_modulos->AdvancedSearch->load();
        $this->idcliente->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        if ($type == "print" || $custom) { // Printer friendly / custom export
            $pageUrl = $this->pageUrl(false);
            $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        } else { // Export API URL
            $exportUrl = GetApiUrl(Config("API_EXPORT_ACTION") . "/" . $type . "/" . $this->TableVar);
        }
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fview_rel_planilha_custolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fview_rel_planilha_custolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fview_rel_planilha_custolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\">" . $Language->phrase("ExportToPdf") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtml", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtml", true)) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXml", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXml", true)) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsv", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsv", true)) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ' data-url="' . $exportUrl . '"' : '';
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fview_rel_planilha_custolist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language, $Security;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = true;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = false;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = false;

        // Export to XML
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        $item->Visible = false;

        // Export to CSV
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        $item->Visible = false;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = true;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
        if (!$Security->canExport()) { // Export not allowed
            $this->ExportOptions->hideAllOptions();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl(false);
        $this->SearchOptions = new ListOptions(TagClassName: "ew-search-option");

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fview_rel_planilha_custosrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        if ($this->UseCustomTemplate || !$this->UseAjaxActions) {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" data-ew-action=\"refresh\" data-url=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        }
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction && $this->CurrentAction != "search") {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return true;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($doc)
    {
        global $Language;
        $rs = null;
        $this->TotalRecords = $this->listRecordCount();

        // Export all
        if ($this->ExportAll) {
            if (Config("EXPORT_ALL_TIME_LIMIT") >= 0) {
                @set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
            }
            $this->DisplayRecords = $this->TotalRecords;
            $this->StopRecord = $this->TotalRecords;
        } else { // Export one page only
            $this->setupStartRecord(); // Set up start record position
            // Set the last record to display
            if ($this->DisplayRecords <= 0) {
                $this->StopRecord = $this->TotalRecords;
            } else {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            }
        }
        $rs = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords);
        if (!$rs || !$doc) {
            RemoveHeader("Content-Type"); // Remove header
            RemoveHeader("Content-Disposition");
            $this->showMessage();
            return;
        }
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;

        // Call Page Exporting server event
        $doc->ExportCustom = !$this->pageExporting($doc);

        // Page header
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        $doc->Text .= $header;
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "");
        $rs->free();

        // Page footer
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        $doc->Text .= $footer;

        // Export header and footer
        $doc->exportHeaderAndFooter();

        // Call Page Exported server event
        $this->pageExported($doc);
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset(all)
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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
                case "x_idplanilha_custo":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = ConvertToBool(Param("infinitescroll"));
        if ($pageNo !== null) { // Check for "pageno" parameter first
            $pageNo = ParseInteger($pageNo);
            if (is_numeric($pageNo)) {
                $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                if ($this->StartRecord <= 0) {
                    $this->StartRecord = 1;
                } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                    $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                }
            }
        } elseif ($startRec !== null && is_numeric($startRec)) { // Check for "start" parameter
            $this->StartRecord = $startRec;
        } elseif (!$infiniteScroll) {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount() {
        return ceil($this->TotalRecords / $this->DisplayRecords);
    }

    // Parse query builder rule
    protected function parseRules($group, $fieldName = "", $itemName = "") {
        $group["condition"] ??= "AND";
        if (!in_array($group["condition"], ["AND", "OR"])) {
            throw new \Exception("Unable to build SQL query with condition '" . $group["condition"] . "'");
        }
        if (!is_array($group["rules"] ?? null)) {
            return "";
        }
        $parts = [];
        foreach ($group["rules"] as $rule) {
            if (is_array($rule["rules"] ?? null) && count($rule["rules"]) > 0) {
                $part = $this->parseRules($rule, $fieldName, $itemName);
                if ($part) {
                    $parts[] = "(" . " " . $part . " " . ")" . " ";
                }
            } else {
                $field = $rule["field"];
                $fld = $this->fieldByParam($field);
                $dbid = $this->Dbid;
                if ($fld instanceof ReportField && is_array($fld->DashboardSearchSourceFields)) {
                    $item = $fld->DashboardSearchSourceFields[$itemName] ?? null;
                    if ($item) {
                        $tbl = Container($item["table"]);
                        $dbid = $tbl->Dbid;
                        $fld = $tbl->Fields[$item["field"]];
                    } else {
                        $fld = null;
                    }
                }
                if ($fld && ($fieldName == "" || $fld->Name == $fieldName)) { // Field name not specified or matched field name
                    $fldOpr = array_search($rule["operator"], Config("CLIENT_SEARCH_OPERATORS"));
                    $ope = Config("QUERY_BUILDER_OPERATORS")[$rule["operator"]] ?? null;
                    if (!$ope || !$fldOpr) {
                        throw new \Exception("Unknown SQL operation for operator '" . $rule["operator"] . "'");
                    }
                    if ($ope["nb_inputs"] > 0 && isset($rule["value"]) && !EmptyValue($rule["value"]) || IsNullOrEmptyOperator($fldOpr)) {
                        $fldVal = $rule["value"];
                        if (is_array($fldVal)) {
                            $fldVal = $fld->isMultiSelect() ? implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal) : $fldVal[0];
                        }
                        $useFilter = $fld->UseFilter; // Query builder does not use filter
                        try {
                            if ($fld instanceof ReportField) { // Search report fields
                                if ($fld->SearchType == "dropdown") {
                                    if (is_array($fldVal)) {
                                        $sql = "";
                                        foreach ($fldVal as $val) {
                                            AddFilter($sql, DropDownFilter($fld, $val, $fldOpr, $dbid), "OR");
                                        }
                                        $parts[] = $sql;
                                    } else {
                                        $parts[] = DropDownFilter($fld, $fldVal, $fldOpr, $dbid);
                                    }
                                } else {
                                    $fld->AdvancedSearch->SearchOperator = $fldOpr;
                                    $fld->AdvancedSearch->SearchValue = $fldVal;
                                    $parts[] = GetReportFilter($fld, false, $dbid);
                                }
                            } else { // Search normal fields
                                if ($fld->isMultiSelect()) {
                                    $parts[] = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, ConvertSearchValue($fldVal, $fldOpr, $fld), $this->Dbid) : "";
                                } else {
                                    $fldVal2 = ContainsString($fldOpr, "BETWEEN") ? $rule["value"][1] : ""; // BETWEEN
                                    if (is_array($fldVal2)) {
                                        $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
                                    }
                                    $fld->AdvancedSearch->SearchValue = ConvertSearchValue($fldVal, $fldOpr, $fld);
                                    $fld->AdvancedSearch->SearchValue2 = ConvertSearchValue($fldVal2, $fldOpr, $fld);
                                    $parts[] = GetSearchSql(
                                        $fld,
                                        $fld->AdvancedSearch->SearchValue, // SearchValue
                                        $fldOpr,
                                        "", // $fldCond not used
                                        $fld->AdvancedSearch->SearchValue2, // SearchValue2
                                        "", // $fldOpr2 not used
                                        $this->Dbid
                                    );
                                }
                            }
                        } finally {
                            $fld->UseFilter = $useFilter;
                        }
                    }
                }
            }
        }
        $where = "";
        foreach ($parts as $part) {
            AddFilter($where, $part, $group["condition"]);
        }
        if ($where && ($group["not"] ?? false)) {
            $where = "NOT (" . $where . ")";
        }
        return $where;
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

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $doc = export object
    public function pageExporting(&$doc)
    {
        //$doc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $doc = export document object
    public function rowExport($doc, $rs)
    {
        //$doc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $doc = export document object
    public function pageExported($doc)
    {
        //$doc->Text .= "my footer"; // Export footer
        //Log($doc->Text);
    }

    // Page Importing event
    public function pageImporting(&$builder, &$options)
    {
        //var_dump($options); // Show all options for importing
        //$builder = fn($workflow) => $workflow->addStep($myStep);
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($obj, $results)
    {
        //var_dump($obj); // Workflow result object
        //var_dump($results); // Import results
    }
}
