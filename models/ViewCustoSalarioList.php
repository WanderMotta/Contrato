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
class ViewCustoSalarioList extends ViewCustoSalario
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ViewCustoSalarioList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fview_custo_salariolist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ViewCustoSalarioList";

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
        $this->idcargo->Visible = false;
        $this->cargo->setVisibility();
        $this->salario->setVisibility();
        $this->nr_horas_mes->Visible = false;
        $this->nr_horas_ad_noite->Visible = false;
        $this->escala_idescala->Visible = false;
        $this->escala->setVisibility();
        $this->periodo_idperiodo->Visible = false;
        $this->periodo->setVisibility();
        $this->jornada->setVisibility();
        $this->fator->Visible = false;
        $this->nr_dias_mes->setVisibility();
        $this->intra_sdf->Visible = false;
        $this->intra_df->Visible = false;
        $this->ad_noite->setVisibility();
        $this->DSR_ad_noite->setVisibility();
        $this->he_50->setVisibility();
        $this->DSR_he_50->setVisibility();
        $this->intra_todos->setVisibility();
        $this->intra_SabDomFer->setVisibility();
        $this->intra_DomFer->setVisibility();
        $this->vt_dia->setVisibility();
        $this->vr_dia->setVisibility();
        $this->va_mes->setVisibility();
        $this->benef_social->setVisibility();
        $this->plr_mes->setVisibility();
        $this->assis_medica->setVisibility();
        $this->assis_odonto->setVisibility();
        $this->desc_vt->setVisibility();
        $this->abreviado->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'view_custo_salario';
        $this->TableName = 'view_custo_salario';

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

        // Table object (view_custo_salario)
        if (!isset($GLOBALS["view_custo_salario"]) || $GLOBALS["view_custo_salario"]::class == PROJECT_NAMESPACE . "view_custo_salario") {
            $GLOBALS["view_custo_salario"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ViewCustoSalarioAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ViewCustoSalarioDelete";
        $this->MultiUpdateUrl = "ViewCustoSalarioUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'view_custo_salario');
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
                    $result["view"] = SameString($pageName, "ViewCustoSalarioView"); // If View page, no primary button
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
            $key .= @$ar['idcargo'];
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
            $this->idcargo->Visible = false;
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
            $this->FormName = "fview_custo_salariogrid";
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
        $filterList = Concat($filterList, $this->idcargo->AdvancedSearch->toJson(), ","); // Field idcargo
        $filterList = Concat($filterList, $this->cargo->AdvancedSearch->toJson(), ","); // Field cargo
        $filterList = Concat($filterList, $this->salario->AdvancedSearch->toJson(), ","); // Field salario
        $filterList = Concat($filterList, $this->nr_horas_mes->AdvancedSearch->toJson(), ","); // Field nr_horas_mes
        $filterList = Concat($filterList, $this->nr_horas_ad_noite->AdvancedSearch->toJson(), ","); // Field nr_horas_ad_noite
        $filterList = Concat($filterList, $this->escala_idescala->AdvancedSearch->toJson(), ","); // Field escala_idescala
        $filterList = Concat($filterList, $this->escala->AdvancedSearch->toJson(), ","); // Field escala
        $filterList = Concat($filterList, $this->periodo_idperiodo->AdvancedSearch->toJson(), ","); // Field periodo_idperiodo
        $filterList = Concat($filterList, $this->periodo->AdvancedSearch->toJson(), ","); // Field periodo
        $filterList = Concat($filterList, $this->jornada->AdvancedSearch->toJson(), ","); // Field jornada
        $filterList = Concat($filterList, $this->fator->AdvancedSearch->toJson(), ","); // Field fator
        $filterList = Concat($filterList, $this->nr_dias_mes->AdvancedSearch->toJson(), ","); // Field nr_dias_mes
        $filterList = Concat($filterList, $this->intra_sdf->AdvancedSearch->toJson(), ","); // Field intra_sdf
        $filterList = Concat($filterList, $this->intra_df->AdvancedSearch->toJson(), ","); // Field intra_df
        $filterList = Concat($filterList, $this->ad_noite->AdvancedSearch->toJson(), ","); // Field ad_noite
        $filterList = Concat($filterList, $this->DSR_ad_noite->AdvancedSearch->toJson(), ","); // Field DSR_ad_noite
        $filterList = Concat($filterList, $this->he_50->AdvancedSearch->toJson(), ","); // Field he_50
        $filterList = Concat($filterList, $this->DSR_he_50->AdvancedSearch->toJson(), ","); // Field DSR_he_50
        $filterList = Concat($filterList, $this->intra_todos->AdvancedSearch->toJson(), ","); // Field intra_todos
        $filterList = Concat($filterList, $this->intra_SabDomFer->AdvancedSearch->toJson(), ","); // Field intra_SabDomFer
        $filterList = Concat($filterList, $this->intra_DomFer->AdvancedSearch->toJson(), ","); // Field intra_DomFer
        $filterList = Concat($filterList, $this->vt_dia->AdvancedSearch->toJson(), ","); // Field vt_dia
        $filterList = Concat($filterList, $this->vr_dia->AdvancedSearch->toJson(), ","); // Field vr_dia
        $filterList = Concat($filterList, $this->va_mes->AdvancedSearch->toJson(), ","); // Field va_mes
        $filterList = Concat($filterList, $this->benef_social->AdvancedSearch->toJson(), ","); // Field benef_social
        $filterList = Concat($filterList, $this->plr_mes->AdvancedSearch->toJson(), ","); // Field plr_mes
        $filterList = Concat($filterList, $this->assis_medica->AdvancedSearch->toJson(), ","); // Field assis_medica
        $filterList = Concat($filterList, $this->assis_odonto->AdvancedSearch->toJson(), ","); // Field assis_odonto
        $filterList = Concat($filterList, $this->desc_vt->AdvancedSearch->toJson(), ","); // Field desc_vt
        $filterList = Concat($filterList, $this->abreviado->AdvancedSearch->toJson(), ","); // Field abreviado
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
            Profile()->setSearchFilters("fview_custo_salariosrch", $filters);
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

        // Field idcargo
        $this->idcargo->AdvancedSearch->SearchValue = @$filter["x_idcargo"];
        $this->idcargo->AdvancedSearch->SearchOperator = @$filter["z_idcargo"];
        $this->idcargo->AdvancedSearch->SearchCondition = @$filter["v_idcargo"];
        $this->idcargo->AdvancedSearch->SearchValue2 = @$filter["y_idcargo"];
        $this->idcargo->AdvancedSearch->SearchOperator2 = @$filter["w_idcargo"];
        $this->idcargo->AdvancedSearch->save();

        // Field cargo
        $this->cargo->AdvancedSearch->SearchValue = @$filter["x_cargo"];
        $this->cargo->AdvancedSearch->SearchOperator = @$filter["z_cargo"];
        $this->cargo->AdvancedSearch->SearchCondition = @$filter["v_cargo"];
        $this->cargo->AdvancedSearch->SearchValue2 = @$filter["y_cargo"];
        $this->cargo->AdvancedSearch->SearchOperator2 = @$filter["w_cargo"];
        $this->cargo->AdvancedSearch->save();

        // Field salario
        $this->salario->AdvancedSearch->SearchValue = @$filter["x_salario"];
        $this->salario->AdvancedSearch->SearchOperator = @$filter["z_salario"];
        $this->salario->AdvancedSearch->SearchCondition = @$filter["v_salario"];
        $this->salario->AdvancedSearch->SearchValue2 = @$filter["y_salario"];
        $this->salario->AdvancedSearch->SearchOperator2 = @$filter["w_salario"];
        $this->salario->AdvancedSearch->save();

        // Field nr_horas_mes
        $this->nr_horas_mes->AdvancedSearch->SearchValue = @$filter["x_nr_horas_mes"];
        $this->nr_horas_mes->AdvancedSearch->SearchOperator = @$filter["z_nr_horas_mes"];
        $this->nr_horas_mes->AdvancedSearch->SearchCondition = @$filter["v_nr_horas_mes"];
        $this->nr_horas_mes->AdvancedSearch->SearchValue2 = @$filter["y_nr_horas_mes"];
        $this->nr_horas_mes->AdvancedSearch->SearchOperator2 = @$filter["w_nr_horas_mes"];
        $this->nr_horas_mes->AdvancedSearch->save();

        // Field nr_horas_ad_noite
        $this->nr_horas_ad_noite->AdvancedSearch->SearchValue = @$filter["x_nr_horas_ad_noite"];
        $this->nr_horas_ad_noite->AdvancedSearch->SearchOperator = @$filter["z_nr_horas_ad_noite"];
        $this->nr_horas_ad_noite->AdvancedSearch->SearchCondition = @$filter["v_nr_horas_ad_noite"];
        $this->nr_horas_ad_noite->AdvancedSearch->SearchValue2 = @$filter["y_nr_horas_ad_noite"];
        $this->nr_horas_ad_noite->AdvancedSearch->SearchOperator2 = @$filter["w_nr_horas_ad_noite"];
        $this->nr_horas_ad_noite->AdvancedSearch->save();

        // Field escala_idescala
        $this->escala_idescala->AdvancedSearch->SearchValue = @$filter["x_escala_idescala"];
        $this->escala_idescala->AdvancedSearch->SearchOperator = @$filter["z_escala_idescala"];
        $this->escala_idescala->AdvancedSearch->SearchCondition = @$filter["v_escala_idescala"];
        $this->escala_idescala->AdvancedSearch->SearchValue2 = @$filter["y_escala_idescala"];
        $this->escala_idescala->AdvancedSearch->SearchOperator2 = @$filter["w_escala_idescala"];
        $this->escala_idescala->AdvancedSearch->save();

        // Field escala
        $this->escala->AdvancedSearch->SearchValue = @$filter["x_escala"];
        $this->escala->AdvancedSearch->SearchOperator = @$filter["z_escala"];
        $this->escala->AdvancedSearch->SearchCondition = @$filter["v_escala"];
        $this->escala->AdvancedSearch->SearchValue2 = @$filter["y_escala"];
        $this->escala->AdvancedSearch->SearchOperator2 = @$filter["w_escala"];
        $this->escala->AdvancedSearch->save();

        // Field periodo_idperiodo
        $this->periodo_idperiodo->AdvancedSearch->SearchValue = @$filter["x_periodo_idperiodo"];
        $this->periodo_idperiodo->AdvancedSearch->SearchOperator = @$filter["z_periodo_idperiodo"];
        $this->periodo_idperiodo->AdvancedSearch->SearchCondition = @$filter["v_periodo_idperiodo"];
        $this->periodo_idperiodo->AdvancedSearch->SearchValue2 = @$filter["y_periodo_idperiodo"];
        $this->periodo_idperiodo->AdvancedSearch->SearchOperator2 = @$filter["w_periodo_idperiodo"];
        $this->periodo_idperiodo->AdvancedSearch->save();

        // Field periodo
        $this->periodo->AdvancedSearch->SearchValue = @$filter["x_periodo"];
        $this->periodo->AdvancedSearch->SearchOperator = @$filter["z_periodo"];
        $this->periodo->AdvancedSearch->SearchCondition = @$filter["v_periodo"];
        $this->periodo->AdvancedSearch->SearchValue2 = @$filter["y_periodo"];
        $this->periodo->AdvancedSearch->SearchOperator2 = @$filter["w_periodo"];
        $this->periodo->AdvancedSearch->save();

        // Field jornada
        $this->jornada->AdvancedSearch->SearchValue = @$filter["x_jornada"];
        $this->jornada->AdvancedSearch->SearchOperator = @$filter["z_jornada"];
        $this->jornada->AdvancedSearch->SearchCondition = @$filter["v_jornada"];
        $this->jornada->AdvancedSearch->SearchValue2 = @$filter["y_jornada"];
        $this->jornada->AdvancedSearch->SearchOperator2 = @$filter["w_jornada"];
        $this->jornada->AdvancedSearch->save();

        // Field fator
        $this->fator->AdvancedSearch->SearchValue = @$filter["x_fator"];
        $this->fator->AdvancedSearch->SearchOperator = @$filter["z_fator"];
        $this->fator->AdvancedSearch->SearchCondition = @$filter["v_fator"];
        $this->fator->AdvancedSearch->SearchValue2 = @$filter["y_fator"];
        $this->fator->AdvancedSearch->SearchOperator2 = @$filter["w_fator"];
        $this->fator->AdvancedSearch->save();

        // Field nr_dias_mes
        $this->nr_dias_mes->AdvancedSearch->SearchValue = @$filter["x_nr_dias_mes"];
        $this->nr_dias_mes->AdvancedSearch->SearchOperator = @$filter["z_nr_dias_mes"];
        $this->nr_dias_mes->AdvancedSearch->SearchCondition = @$filter["v_nr_dias_mes"];
        $this->nr_dias_mes->AdvancedSearch->SearchValue2 = @$filter["y_nr_dias_mes"];
        $this->nr_dias_mes->AdvancedSearch->SearchOperator2 = @$filter["w_nr_dias_mes"];
        $this->nr_dias_mes->AdvancedSearch->save();

        // Field intra_sdf
        $this->intra_sdf->AdvancedSearch->SearchValue = @$filter["x_intra_sdf"];
        $this->intra_sdf->AdvancedSearch->SearchOperator = @$filter["z_intra_sdf"];
        $this->intra_sdf->AdvancedSearch->SearchCondition = @$filter["v_intra_sdf"];
        $this->intra_sdf->AdvancedSearch->SearchValue2 = @$filter["y_intra_sdf"];
        $this->intra_sdf->AdvancedSearch->SearchOperator2 = @$filter["w_intra_sdf"];
        $this->intra_sdf->AdvancedSearch->save();

        // Field intra_df
        $this->intra_df->AdvancedSearch->SearchValue = @$filter["x_intra_df"];
        $this->intra_df->AdvancedSearch->SearchOperator = @$filter["z_intra_df"];
        $this->intra_df->AdvancedSearch->SearchCondition = @$filter["v_intra_df"];
        $this->intra_df->AdvancedSearch->SearchValue2 = @$filter["y_intra_df"];
        $this->intra_df->AdvancedSearch->SearchOperator2 = @$filter["w_intra_df"];
        $this->intra_df->AdvancedSearch->save();

        // Field ad_noite
        $this->ad_noite->AdvancedSearch->SearchValue = @$filter["x_ad_noite"];
        $this->ad_noite->AdvancedSearch->SearchOperator = @$filter["z_ad_noite"];
        $this->ad_noite->AdvancedSearch->SearchCondition = @$filter["v_ad_noite"];
        $this->ad_noite->AdvancedSearch->SearchValue2 = @$filter["y_ad_noite"];
        $this->ad_noite->AdvancedSearch->SearchOperator2 = @$filter["w_ad_noite"];
        $this->ad_noite->AdvancedSearch->save();

        // Field DSR_ad_noite
        $this->DSR_ad_noite->AdvancedSearch->SearchValue = @$filter["x_DSR_ad_noite"];
        $this->DSR_ad_noite->AdvancedSearch->SearchOperator = @$filter["z_DSR_ad_noite"];
        $this->DSR_ad_noite->AdvancedSearch->SearchCondition = @$filter["v_DSR_ad_noite"];
        $this->DSR_ad_noite->AdvancedSearch->SearchValue2 = @$filter["y_DSR_ad_noite"];
        $this->DSR_ad_noite->AdvancedSearch->SearchOperator2 = @$filter["w_DSR_ad_noite"];
        $this->DSR_ad_noite->AdvancedSearch->save();

        // Field he_50
        $this->he_50->AdvancedSearch->SearchValue = @$filter["x_he_50"];
        $this->he_50->AdvancedSearch->SearchOperator = @$filter["z_he_50"];
        $this->he_50->AdvancedSearch->SearchCondition = @$filter["v_he_50"];
        $this->he_50->AdvancedSearch->SearchValue2 = @$filter["y_he_50"];
        $this->he_50->AdvancedSearch->SearchOperator2 = @$filter["w_he_50"];
        $this->he_50->AdvancedSearch->save();

        // Field DSR_he_50
        $this->DSR_he_50->AdvancedSearch->SearchValue = @$filter["x_DSR_he_50"];
        $this->DSR_he_50->AdvancedSearch->SearchOperator = @$filter["z_DSR_he_50"];
        $this->DSR_he_50->AdvancedSearch->SearchCondition = @$filter["v_DSR_he_50"];
        $this->DSR_he_50->AdvancedSearch->SearchValue2 = @$filter["y_DSR_he_50"];
        $this->DSR_he_50->AdvancedSearch->SearchOperator2 = @$filter["w_DSR_he_50"];
        $this->DSR_he_50->AdvancedSearch->save();

        // Field intra_todos
        $this->intra_todos->AdvancedSearch->SearchValue = @$filter["x_intra_todos"];
        $this->intra_todos->AdvancedSearch->SearchOperator = @$filter["z_intra_todos"];
        $this->intra_todos->AdvancedSearch->SearchCondition = @$filter["v_intra_todos"];
        $this->intra_todos->AdvancedSearch->SearchValue2 = @$filter["y_intra_todos"];
        $this->intra_todos->AdvancedSearch->SearchOperator2 = @$filter["w_intra_todos"];
        $this->intra_todos->AdvancedSearch->save();

        // Field intra_SabDomFer
        $this->intra_SabDomFer->AdvancedSearch->SearchValue = @$filter["x_intra_SabDomFer"];
        $this->intra_SabDomFer->AdvancedSearch->SearchOperator = @$filter["z_intra_SabDomFer"];
        $this->intra_SabDomFer->AdvancedSearch->SearchCondition = @$filter["v_intra_SabDomFer"];
        $this->intra_SabDomFer->AdvancedSearch->SearchValue2 = @$filter["y_intra_SabDomFer"];
        $this->intra_SabDomFer->AdvancedSearch->SearchOperator2 = @$filter["w_intra_SabDomFer"];
        $this->intra_SabDomFer->AdvancedSearch->save();

        // Field intra_DomFer
        $this->intra_DomFer->AdvancedSearch->SearchValue = @$filter["x_intra_DomFer"];
        $this->intra_DomFer->AdvancedSearch->SearchOperator = @$filter["z_intra_DomFer"];
        $this->intra_DomFer->AdvancedSearch->SearchCondition = @$filter["v_intra_DomFer"];
        $this->intra_DomFer->AdvancedSearch->SearchValue2 = @$filter["y_intra_DomFer"];
        $this->intra_DomFer->AdvancedSearch->SearchOperator2 = @$filter["w_intra_DomFer"];
        $this->intra_DomFer->AdvancedSearch->save();

        // Field vt_dia
        $this->vt_dia->AdvancedSearch->SearchValue = @$filter["x_vt_dia"];
        $this->vt_dia->AdvancedSearch->SearchOperator = @$filter["z_vt_dia"];
        $this->vt_dia->AdvancedSearch->SearchCondition = @$filter["v_vt_dia"];
        $this->vt_dia->AdvancedSearch->SearchValue2 = @$filter["y_vt_dia"];
        $this->vt_dia->AdvancedSearch->SearchOperator2 = @$filter["w_vt_dia"];
        $this->vt_dia->AdvancedSearch->save();

        // Field vr_dia
        $this->vr_dia->AdvancedSearch->SearchValue = @$filter["x_vr_dia"];
        $this->vr_dia->AdvancedSearch->SearchOperator = @$filter["z_vr_dia"];
        $this->vr_dia->AdvancedSearch->SearchCondition = @$filter["v_vr_dia"];
        $this->vr_dia->AdvancedSearch->SearchValue2 = @$filter["y_vr_dia"];
        $this->vr_dia->AdvancedSearch->SearchOperator2 = @$filter["w_vr_dia"];
        $this->vr_dia->AdvancedSearch->save();

        // Field va_mes
        $this->va_mes->AdvancedSearch->SearchValue = @$filter["x_va_mes"];
        $this->va_mes->AdvancedSearch->SearchOperator = @$filter["z_va_mes"];
        $this->va_mes->AdvancedSearch->SearchCondition = @$filter["v_va_mes"];
        $this->va_mes->AdvancedSearch->SearchValue2 = @$filter["y_va_mes"];
        $this->va_mes->AdvancedSearch->SearchOperator2 = @$filter["w_va_mes"];
        $this->va_mes->AdvancedSearch->save();

        // Field benef_social
        $this->benef_social->AdvancedSearch->SearchValue = @$filter["x_benef_social"];
        $this->benef_social->AdvancedSearch->SearchOperator = @$filter["z_benef_social"];
        $this->benef_social->AdvancedSearch->SearchCondition = @$filter["v_benef_social"];
        $this->benef_social->AdvancedSearch->SearchValue2 = @$filter["y_benef_social"];
        $this->benef_social->AdvancedSearch->SearchOperator2 = @$filter["w_benef_social"];
        $this->benef_social->AdvancedSearch->save();

        // Field plr_mes
        $this->plr_mes->AdvancedSearch->SearchValue = @$filter["x_plr_mes"];
        $this->plr_mes->AdvancedSearch->SearchOperator = @$filter["z_plr_mes"];
        $this->plr_mes->AdvancedSearch->SearchCondition = @$filter["v_plr_mes"];
        $this->plr_mes->AdvancedSearch->SearchValue2 = @$filter["y_plr_mes"];
        $this->plr_mes->AdvancedSearch->SearchOperator2 = @$filter["w_plr_mes"];
        $this->plr_mes->AdvancedSearch->save();

        // Field assis_medica
        $this->assis_medica->AdvancedSearch->SearchValue = @$filter["x_assis_medica"];
        $this->assis_medica->AdvancedSearch->SearchOperator = @$filter["z_assis_medica"];
        $this->assis_medica->AdvancedSearch->SearchCondition = @$filter["v_assis_medica"];
        $this->assis_medica->AdvancedSearch->SearchValue2 = @$filter["y_assis_medica"];
        $this->assis_medica->AdvancedSearch->SearchOperator2 = @$filter["w_assis_medica"];
        $this->assis_medica->AdvancedSearch->save();

        // Field assis_odonto
        $this->assis_odonto->AdvancedSearch->SearchValue = @$filter["x_assis_odonto"];
        $this->assis_odonto->AdvancedSearch->SearchOperator = @$filter["z_assis_odonto"];
        $this->assis_odonto->AdvancedSearch->SearchCondition = @$filter["v_assis_odonto"];
        $this->assis_odonto->AdvancedSearch->SearchValue2 = @$filter["y_assis_odonto"];
        $this->assis_odonto->AdvancedSearch->SearchOperator2 = @$filter["w_assis_odonto"];
        $this->assis_odonto->AdvancedSearch->save();

        // Field desc_vt
        $this->desc_vt->AdvancedSearch->SearchValue = @$filter["x_desc_vt"];
        $this->desc_vt->AdvancedSearch->SearchOperator = @$filter["z_desc_vt"];
        $this->desc_vt->AdvancedSearch->SearchCondition = @$filter["v_desc_vt"];
        $this->desc_vt->AdvancedSearch->SearchValue2 = @$filter["y_desc_vt"];
        $this->desc_vt->AdvancedSearch->SearchOperator2 = @$filter["w_desc_vt"];
        $this->desc_vt->AdvancedSearch->save();

        // Field abreviado
        $this->abreviado->AdvancedSearch->SearchValue = @$filter["x_abreviado"];
        $this->abreviado->AdvancedSearch->SearchOperator = @$filter["z_abreviado"];
        $this->abreviado->AdvancedSearch->SearchCondition = @$filter["v_abreviado"];
        $this->abreviado->AdvancedSearch->SearchValue2 = @$filter["y_abreviado"];
        $this->abreviado->AdvancedSearch->SearchOperator2 = @$filter["w_abreviado"];
        $this->abreviado->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->idcargo, $default, false); // idcargo
        $this->buildSearchSql($where, $this->cargo, $default, true); // cargo
        $this->buildSearchSql($where, $this->salario, $default, false); // salario
        $this->buildSearchSql($where, $this->nr_horas_mes, $default, false); // nr_horas_mes
        $this->buildSearchSql($where, $this->nr_horas_ad_noite, $default, false); // nr_horas_ad_noite
        $this->buildSearchSql($where, $this->escala_idescala, $default, false); // escala_idescala
        $this->buildSearchSql($where, $this->escala, $default, false); // escala
        $this->buildSearchSql($where, $this->periodo_idperiodo, $default, false); // periodo_idperiodo
        $this->buildSearchSql($where, $this->periodo, $default, false); // periodo
        $this->buildSearchSql($where, $this->jornada, $default, false); // jornada
        $this->buildSearchSql($where, $this->fator, $default, false); // fator
        $this->buildSearchSql($where, $this->nr_dias_mes, $default, false); // nr_dias_mes
        $this->buildSearchSql($where, $this->intra_sdf, $default, false); // intra_sdf
        $this->buildSearchSql($where, $this->intra_df, $default, false); // intra_df
        $this->buildSearchSql($where, $this->ad_noite, $default, false); // ad_noite
        $this->buildSearchSql($where, $this->DSR_ad_noite, $default, false); // DSR_ad_noite
        $this->buildSearchSql($where, $this->he_50, $default, false); // he_50
        $this->buildSearchSql($where, $this->DSR_he_50, $default, false); // DSR_he_50
        $this->buildSearchSql($where, $this->intra_todos, $default, false); // intra_todos
        $this->buildSearchSql($where, $this->intra_SabDomFer, $default, false); // intra_SabDomFer
        $this->buildSearchSql($where, $this->intra_DomFer, $default, false); // intra_DomFer
        $this->buildSearchSql($where, $this->vt_dia, $default, false); // vt_dia
        $this->buildSearchSql($where, $this->vr_dia, $default, false); // vr_dia
        $this->buildSearchSql($where, $this->va_mes, $default, false); // va_mes
        $this->buildSearchSql($where, $this->benef_social, $default, false); // benef_social
        $this->buildSearchSql($where, $this->plr_mes, $default, false); // plr_mes
        $this->buildSearchSql($where, $this->assis_medica, $default, false); // assis_medica
        $this->buildSearchSql($where, $this->assis_odonto, $default, false); // assis_odonto
        $this->buildSearchSql($where, $this->desc_vt, $default, false); // desc_vt
        $this->buildSearchSql($where, $this->abreviado, $default, false); // abreviado

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->idcargo->AdvancedSearch->save(); // idcargo
            $this->cargo->AdvancedSearch->save(); // cargo
            $this->salario->AdvancedSearch->save(); // salario
            $this->nr_horas_mes->AdvancedSearch->save(); // nr_horas_mes
            $this->nr_horas_ad_noite->AdvancedSearch->save(); // nr_horas_ad_noite
            $this->escala_idescala->AdvancedSearch->save(); // escala_idescala
            $this->escala->AdvancedSearch->save(); // escala
            $this->periodo_idperiodo->AdvancedSearch->save(); // periodo_idperiodo
            $this->periodo->AdvancedSearch->save(); // periodo
            $this->jornada->AdvancedSearch->save(); // jornada
            $this->fator->AdvancedSearch->save(); // fator
            $this->nr_dias_mes->AdvancedSearch->save(); // nr_dias_mes
            $this->intra_sdf->AdvancedSearch->save(); // intra_sdf
            $this->intra_df->AdvancedSearch->save(); // intra_df
            $this->ad_noite->AdvancedSearch->save(); // ad_noite
            $this->DSR_ad_noite->AdvancedSearch->save(); // DSR_ad_noite
            $this->he_50->AdvancedSearch->save(); // he_50
            $this->DSR_he_50->AdvancedSearch->save(); // DSR_he_50
            $this->intra_todos->AdvancedSearch->save(); // intra_todos
            $this->intra_SabDomFer->AdvancedSearch->save(); // intra_SabDomFer
            $this->intra_DomFer->AdvancedSearch->save(); // intra_DomFer
            $this->vt_dia->AdvancedSearch->save(); // vt_dia
            $this->vr_dia->AdvancedSearch->save(); // vr_dia
            $this->va_mes->AdvancedSearch->save(); // va_mes
            $this->benef_social->AdvancedSearch->save(); // benef_social
            $this->plr_mes->AdvancedSearch->save(); // plr_mes
            $this->assis_medica->AdvancedSearch->save(); // assis_medica
            $this->assis_odonto->AdvancedSearch->save(); // assis_odonto
            $this->desc_vt->AdvancedSearch->save(); // desc_vt
            $this->abreviado->AdvancedSearch->save(); // abreviado

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
            $this->idcargo->AdvancedSearch->save(); // idcargo
            $this->cargo->AdvancedSearch->save(); // cargo
            $this->salario->AdvancedSearch->save(); // salario
            $this->nr_horas_mes->AdvancedSearch->save(); // nr_horas_mes
            $this->nr_horas_ad_noite->AdvancedSearch->save(); // nr_horas_ad_noite
            $this->escala_idescala->AdvancedSearch->save(); // escala_idescala
            $this->escala->AdvancedSearch->save(); // escala
            $this->periodo_idperiodo->AdvancedSearch->save(); // periodo_idperiodo
            $this->periodo->AdvancedSearch->save(); // periodo
            $this->jornada->AdvancedSearch->save(); // jornada
            $this->fator->AdvancedSearch->save(); // fator
            $this->nr_dias_mes->AdvancedSearch->save(); // nr_dias_mes
            $this->intra_sdf->AdvancedSearch->save(); // intra_sdf
            $this->intra_df->AdvancedSearch->save(); // intra_df
            $this->ad_noite->AdvancedSearch->save(); // ad_noite
            $this->DSR_ad_noite->AdvancedSearch->save(); // DSR_ad_noite
            $this->he_50->AdvancedSearch->save(); // he_50
            $this->DSR_he_50->AdvancedSearch->save(); // DSR_he_50
            $this->intra_todos->AdvancedSearch->save(); // intra_todos
            $this->intra_SabDomFer->AdvancedSearch->save(); // intra_SabDomFer
            $this->intra_DomFer->AdvancedSearch->save(); // intra_DomFer
            $this->vt_dia->AdvancedSearch->save(); // vt_dia
            $this->vr_dia->AdvancedSearch->save(); // vr_dia
            $this->va_mes->AdvancedSearch->save(); // va_mes
            $this->benef_social->AdvancedSearch->save(); // benef_social
            $this->plr_mes->AdvancedSearch->save(); // plr_mes
            $this->assis_medica->AdvancedSearch->save(); // assis_medica
            $this->assis_odonto->AdvancedSearch->save(); // assis_odonto
            $this->desc_vt->AdvancedSearch->save(); // desc_vt
            $this->abreviado->AdvancedSearch->save(); // abreviado
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

        // Field cargo
        $filter = $this->queryBuilderWhere("cargo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cargo, false, true);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cargo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field salario
        $filter = $this->queryBuilderWhere("salario");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->salario, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->salario->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field escala
        $filter = $this->queryBuilderWhere("escala");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->escala, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->escala->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field periodo
        $filter = $this->queryBuilderWhere("periodo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->periodo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->periodo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field jornada
        $filter = $this->queryBuilderWhere("jornada");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->jornada, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->jornada->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field nr_dias_mes
        $filter = $this->queryBuilderWhere("nr_dias_mes");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->nr_dias_mes, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->nr_dias_mes->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field ad_noite
        $filter = $this->queryBuilderWhere("ad_noite");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->ad_noite, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->ad_noite->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field DSR_ad_noite
        $filter = $this->queryBuilderWhere("DSR_ad_noite");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->DSR_ad_noite, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->DSR_ad_noite->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field he_50
        $filter = $this->queryBuilderWhere("he_50");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->he_50, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->he_50->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field DSR_he_50
        $filter = $this->queryBuilderWhere("DSR_he_50");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->DSR_he_50, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->DSR_he_50->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field intra_todos
        $filter = $this->queryBuilderWhere("intra_todos");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->intra_todos, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->intra_todos->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field intra_SabDomFer
        $filter = $this->queryBuilderWhere("intra_SabDomFer");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->intra_SabDomFer, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->intra_SabDomFer->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field intra_DomFer
        $filter = $this->queryBuilderWhere("intra_DomFer");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->intra_DomFer, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->intra_DomFer->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field vt_dia
        $filter = $this->queryBuilderWhere("vt_dia");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->vt_dia, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->vt_dia->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field vr_dia
        $filter = $this->queryBuilderWhere("vr_dia");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->vr_dia, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->vr_dia->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field va_mes
        $filter = $this->queryBuilderWhere("va_mes");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->va_mes, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->va_mes->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field benef_social
        $filter = $this->queryBuilderWhere("benef_social");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->benef_social, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->benef_social->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field plr_mes
        $filter = $this->queryBuilderWhere("plr_mes");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->plr_mes, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->plr_mes->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field assis_medica
        $filter = $this->queryBuilderWhere("assis_medica");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->assis_medica, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->assis_medica->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field assis_odonto
        $filter = $this->queryBuilderWhere("assis_odonto");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->assis_odonto, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->assis_odonto->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field desc_vt
        $filter = $this->queryBuilderWhere("desc_vt");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->desc_vt, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->desc_vt->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
        if ($this->idcargo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cargo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->salario->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nr_horas_mes->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nr_horas_ad_noite->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->escala_idescala->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->escala->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->periodo_idperiodo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->periodo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->jornada->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fator->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nr_dias_mes->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->intra_sdf->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->intra_df->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ad_noite->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->DSR_ad_noite->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->he_50->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->DSR_he_50->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->intra_todos->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->intra_SabDomFer->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->intra_DomFer->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->vt_dia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->vr_dia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->va_mes->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->benef_social->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->plr_mes->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->assis_medica->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->assis_odonto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->desc_vt->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->abreviado->AdvancedSearch->issetSession()) {
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
        $this->idcargo->AdvancedSearch->unsetSession();
        $this->cargo->AdvancedSearch->unsetSession();
        $this->salario->AdvancedSearch->unsetSession();
        $this->nr_horas_mes->AdvancedSearch->unsetSession();
        $this->nr_horas_ad_noite->AdvancedSearch->unsetSession();
        $this->escala_idescala->AdvancedSearch->unsetSession();
        $this->escala->AdvancedSearch->unsetSession();
        $this->periodo_idperiodo->AdvancedSearch->unsetSession();
        $this->periodo->AdvancedSearch->unsetSession();
        $this->jornada->AdvancedSearch->unsetSession();
        $this->fator->AdvancedSearch->unsetSession();
        $this->nr_dias_mes->AdvancedSearch->unsetSession();
        $this->intra_sdf->AdvancedSearch->unsetSession();
        $this->intra_df->AdvancedSearch->unsetSession();
        $this->ad_noite->AdvancedSearch->unsetSession();
        $this->DSR_ad_noite->AdvancedSearch->unsetSession();
        $this->he_50->AdvancedSearch->unsetSession();
        $this->DSR_he_50->AdvancedSearch->unsetSession();
        $this->intra_todos->AdvancedSearch->unsetSession();
        $this->intra_SabDomFer->AdvancedSearch->unsetSession();
        $this->intra_DomFer->AdvancedSearch->unsetSession();
        $this->vt_dia->AdvancedSearch->unsetSession();
        $this->vr_dia->AdvancedSearch->unsetSession();
        $this->va_mes->AdvancedSearch->unsetSession();
        $this->benef_social->AdvancedSearch->unsetSession();
        $this->plr_mes->AdvancedSearch->unsetSession();
        $this->assis_medica->AdvancedSearch->unsetSession();
        $this->assis_odonto->AdvancedSearch->unsetSession();
        $this->desc_vt->AdvancedSearch->unsetSession();
        $this->abreviado->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->idcargo->AdvancedSearch->load();
        $this->cargo->AdvancedSearch->load();
        $this->salario->AdvancedSearch->load();
        $this->nr_horas_mes->AdvancedSearch->load();
        $this->nr_horas_ad_noite->AdvancedSearch->load();
        $this->escala_idescala->AdvancedSearch->load();
        $this->escala->AdvancedSearch->load();
        $this->periodo_idperiodo->AdvancedSearch->load();
        $this->periodo->AdvancedSearch->load();
        $this->jornada->AdvancedSearch->load();
        $this->fator->AdvancedSearch->load();
        $this->nr_dias_mes->AdvancedSearch->load();
        $this->intra_sdf->AdvancedSearch->load();
        $this->intra_df->AdvancedSearch->load();
        $this->ad_noite->AdvancedSearch->load();
        $this->DSR_ad_noite->AdvancedSearch->load();
        $this->he_50->AdvancedSearch->load();
        $this->DSR_he_50->AdvancedSearch->load();
        $this->intra_todos->AdvancedSearch->load();
        $this->intra_SabDomFer->AdvancedSearch->load();
        $this->intra_DomFer->AdvancedSearch->load();
        $this->vt_dia->AdvancedSearch->load();
        $this->vr_dia->AdvancedSearch->load();
        $this->va_mes->AdvancedSearch->load();
        $this->benef_social->AdvancedSearch->load();
        $this->plr_mes->AdvancedSearch->load();
        $this->assis_medica->AdvancedSearch->load();
        $this->assis_odonto->AdvancedSearch->load();
        $this->desc_vt->AdvancedSearch->load();
        $this->abreviado->AdvancedSearch->load();
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
            $this->updateSort($this->cargo, $ctrl); // cargo
            $this->updateSort($this->salario, $ctrl); // salario
            $this->updateSort($this->escala, $ctrl); // escala
            $this->updateSort($this->periodo, $ctrl); // periodo
            $this->updateSort($this->jornada, $ctrl); // jornada
            $this->updateSort($this->nr_dias_mes, $ctrl); // nr_dias_mes
            $this->updateSort($this->ad_noite, $ctrl); // ad_noite
            $this->updateSort($this->DSR_ad_noite, $ctrl); // DSR_ad_noite
            $this->updateSort($this->he_50, $ctrl); // he_50
            $this->updateSort($this->DSR_he_50, $ctrl); // DSR_he_50
            $this->updateSort($this->intra_todos, $ctrl); // intra_todos
            $this->updateSort($this->intra_SabDomFer, $ctrl); // intra_SabDomFer
            $this->updateSort($this->intra_DomFer, $ctrl); // intra_DomFer
            $this->updateSort($this->vt_dia, $ctrl); // vt_dia
            $this->updateSort($this->vr_dia, $ctrl); // vr_dia
            $this->updateSort($this->va_mes, $ctrl); // va_mes
            $this->updateSort($this->benef_social, $ctrl); // benef_social
            $this->updateSort($this->plr_mes, $ctrl); // plr_mes
            $this->updateSort($this->assis_medica, $ctrl); // assis_medica
            $this->updateSort($this->assis_odonto, $ctrl); // assis_odonto
            $this->updateSort($this->desc_vt, $ctrl); // desc_vt
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
                $this->idcargo->setSort("");
                $this->cargo->setSort("");
                $this->salario->setSort("");
                $this->nr_horas_mes->setSort("");
                $this->nr_horas_ad_noite->setSort("");
                $this->escala_idescala->setSort("");
                $this->escala->setSort("");
                $this->periodo_idperiodo->setSort("");
                $this->periodo->setSort("");
                $this->jornada->setSort("");
                $this->fator->setSort("");
                $this->nr_dias_mes->setSort("");
                $this->intra_sdf->setSort("");
                $this->intra_df->setSort("");
                $this->ad_noite->setSort("");
                $this->DSR_ad_noite->setSort("");
                $this->he_50->setSort("");
                $this->DSR_he_50->setSort("");
                $this->intra_todos->setSort("");
                $this->intra_SabDomFer->setSort("");
                $this->intra_DomFer->setSort("");
                $this->vt_dia->setSort("");
                $this->vr_dia->setSort("");
                $this->va_mes->setSort("");
                $this->benef_social->setSort("");
                $this->plr_mes->setSort("");
                $this->assis_medica->setSort("");
                $this->assis_odonto->setSort("");
                $this->desc_vt->setSort("");
                $this->abreviado->setSort("");
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fview_custo_salariolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fview_custo_salariolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->idcargo->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
            $this->createColumnOption($option, "cargo");
            $this->createColumnOption($option, "salario");
            $this->createColumnOption($option, "escala");
            $this->createColumnOption($option, "periodo");
            $this->createColumnOption($option, "jornada");
            $this->createColumnOption($option, "nr_dias_mes");
            $this->createColumnOption($option, "ad_noite");
            $this->createColumnOption($option, "DSR_ad_noite");
            $this->createColumnOption($option, "he_50");
            $this->createColumnOption($option, "DSR_he_50");
            $this->createColumnOption($option, "intra_todos");
            $this->createColumnOption($option, "intra_SabDomFer");
            $this->createColumnOption($option, "intra_DomFer");
            $this->createColumnOption($option, "vt_dia");
            $this->createColumnOption($option, "vr_dia");
            $this->createColumnOption($option, "va_mes");
            $this->createColumnOption($option, "benef_social");
            $this->createColumnOption($option, "plr_mes");
            $this->createColumnOption($option, "assis_medica");
            $this->createColumnOption($option, "assis_odonto");
            $this->createColumnOption($option, "desc_vt");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fview_custo_salariosrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fview_custo_salariosrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fview_custo_salariolist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_view_custo_salario", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_view_custo_salario",
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

        // idcargo
        if ($this->idcargo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->idcargo->AdvancedSearch->SearchValue != "" || $this->idcargo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // salario
        if ($this->salario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->salario->AdvancedSearch->SearchValue != "" || $this->salario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nr_horas_mes
        if ($this->nr_horas_mes->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nr_horas_mes->AdvancedSearch->SearchValue != "" || $this->nr_horas_mes->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nr_horas_ad_noite
        if ($this->nr_horas_ad_noite->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nr_horas_ad_noite->AdvancedSearch->SearchValue != "" || $this->nr_horas_ad_noite->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // escala_idescala
        if ($this->escala_idescala->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->escala_idescala->AdvancedSearch->SearchValue != "" || $this->escala_idescala->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // escala
        if ($this->escala->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->escala->AdvancedSearch->SearchValue != "" || $this->escala->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // periodo_idperiodo
        if ($this->periodo_idperiodo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->periodo_idperiodo->AdvancedSearch->SearchValue != "" || $this->periodo_idperiodo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // periodo
        if ($this->periodo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->periodo->AdvancedSearch->SearchValue != "" || $this->periodo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // jornada
        if ($this->jornada->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->jornada->AdvancedSearch->SearchValue != "" || $this->jornada->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fator
        if ($this->fator->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fator->AdvancedSearch->SearchValue != "" || $this->fator->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nr_dias_mes
        if ($this->nr_dias_mes->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nr_dias_mes->AdvancedSearch->SearchValue != "" || $this->nr_dias_mes->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // intra_sdf
        if ($this->intra_sdf->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->intra_sdf->AdvancedSearch->SearchValue != "" || $this->intra_sdf->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // intra_df
        if ($this->intra_df->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->intra_df->AdvancedSearch->SearchValue != "" || $this->intra_df->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ad_noite
        if ($this->ad_noite->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ad_noite->AdvancedSearch->SearchValue != "" || $this->ad_noite->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // DSR_ad_noite
        if ($this->DSR_ad_noite->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->DSR_ad_noite->AdvancedSearch->SearchValue != "" || $this->DSR_ad_noite->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // he_50
        if ($this->he_50->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->he_50->AdvancedSearch->SearchValue != "" || $this->he_50->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // DSR_he_50
        if ($this->DSR_he_50->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->DSR_he_50->AdvancedSearch->SearchValue != "" || $this->DSR_he_50->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // intra_todos
        if ($this->intra_todos->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->intra_todos->AdvancedSearch->SearchValue != "" || $this->intra_todos->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // intra_SabDomFer
        if ($this->intra_SabDomFer->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->intra_SabDomFer->AdvancedSearch->SearchValue != "" || $this->intra_SabDomFer->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // intra_DomFer
        if ($this->intra_DomFer->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->intra_DomFer->AdvancedSearch->SearchValue != "" || $this->intra_DomFer->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // vt_dia
        if ($this->vt_dia->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->vt_dia->AdvancedSearch->SearchValue != "" || $this->vt_dia->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // vr_dia
        if ($this->vr_dia->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->vr_dia->AdvancedSearch->SearchValue != "" || $this->vr_dia->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // va_mes
        if ($this->va_mes->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->va_mes->AdvancedSearch->SearchValue != "" || $this->va_mes->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // benef_social
        if ($this->benef_social->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->benef_social->AdvancedSearch->SearchValue != "" || $this->benef_social->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // plr_mes
        if ($this->plr_mes->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->plr_mes->AdvancedSearch->SearchValue != "" || $this->plr_mes->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // assis_medica
        if ($this->assis_medica->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->assis_medica->AdvancedSearch->SearchValue != "" || $this->assis_medica->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // assis_odonto
        if ($this->assis_odonto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->assis_odonto->AdvancedSearch->SearchValue != "" || $this->assis_odonto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // desc_vt
        if ($this->desc_vt->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->desc_vt->AdvancedSearch->SearchValue != "" || $this->desc_vt->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // abreviado
        if ($this->abreviado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->abreviado->AdvancedSearch->SearchValue != "" || $this->abreviado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        $this->idcargo->setDbValue($row['idcargo']);
        $this->cargo->setDbValue($row['cargo']);
        $this->salario->setDbValue($row['salario']);
        $this->nr_horas_mes->setDbValue($row['nr_horas_mes']);
        $this->nr_horas_ad_noite->setDbValue($row['nr_horas_ad_noite']);
        $this->escala_idescala->setDbValue($row['escala_idescala']);
        $this->escala->setDbValue($row['escala']);
        $this->periodo_idperiodo->setDbValue($row['periodo_idperiodo']);
        $this->periodo->setDbValue($row['periodo']);
        $this->jornada->setDbValue($row['jornada']);
        $this->fator->setDbValue($row['fator']);
        $this->nr_dias_mes->setDbValue($row['nr_dias_mes']);
        $this->intra_sdf->setDbValue($row['intra_sdf']);
        $this->intra_df->setDbValue($row['intra_df']);
        $this->ad_noite->setDbValue($row['ad_noite']);
        $this->DSR_ad_noite->setDbValue($row['DSR_ad_noite']);
        $this->he_50->setDbValue($row['he_50']);
        $this->DSR_he_50->setDbValue($row['DSR_he_50']);
        $this->intra_todos->setDbValue($row['intra_todos']);
        $this->intra_SabDomFer->setDbValue($row['intra_SabDomFer']);
        $this->intra_DomFer->setDbValue($row['intra_DomFer']);
        $this->vt_dia->setDbValue($row['vt_dia']);
        $this->vr_dia->setDbValue($row['vr_dia']);
        $this->va_mes->setDbValue($row['va_mes']);
        $this->benef_social->setDbValue($row['benef_social']);
        $this->plr_mes->setDbValue($row['plr_mes']);
        $this->assis_medica->setDbValue($row['assis_medica']);
        $this->assis_odonto->setDbValue($row['assis_odonto']);
        $this->desc_vt->setDbValue($row['desc_vt']);
        $this->abreviado->setDbValue($row['abreviado']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idcargo'] = $this->idcargo->DefaultValue;
        $row['cargo'] = $this->cargo->DefaultValue;
        $row['salario'] = $this->salario->DefaultValue;
        $row['nr_horas_mes'] = $this->nr_horas_mes->DefaultValue;
        $row['nr_horas_ad_noite'] = $this->nr_horas_ad_noite->DefaultValue;
        $row['escala_idescala'] = $this->escala_idescala->DefaultValue;
        $row['escala'] = $this->escala->DefaultValue;
        $row['periodo_idperiodo'] = $this->periodo_idperiodo->DefaultValue;
        $row['periodo'] = $this->periodo->DefaultValue;
        $row['jornada'] = $this->jornada->DefaultValue;
        $row['fator'] = $this->fator->DefaultValue;
        $row['nr_dias_mes'] = $this->nr_dias_mes->DefaultValue;
        $row['intra_sdf'] = $this->intra_sdf->DefaultValue;
        $row['intra_df'] = $this->intra_df->DefaultValue;
        $row['ad_noite'] = $this->ad_noite->DefaultValue;
        $row['DSR_ad_noite'] = $this->DSR_ad_noite->DefaultValue;
        $row['he_50'] = $this->he_50->DefaultValue;
        $row['DSR_he_50'] = $this->DSR_he_50->DefaultValue;
        $row['intra_todos'] = $this->intra_todos->DefaultValue;
        $row['intra_SabDomFer'] = $this->intra_SabDomFer->DefaultValue;
        $row['intra_DomFer'] = $this->intra_DomFer->DefaultValue;
        $row['vt_dia'] = $this->vt_dia->DefaultValue;
        $row['vr_dia'] = $this->vr_dia->DefaultValue;
        $row['va_mes'] = $this->va_mes->DefaultValue;
        $row['benef_social'] = $this->benef_social->DefaultValue;
        $row['plr_mes'] = $this->plr_mes->DefaultValue;
        $row['assis_medica'] = $this->assis_medica->DefaultValue;
        $row['assis_odonto'] = $this->assis_odonto->DefaultValue;
        $row['desc_vt'] = $this->desc_vt->DefaultValue;
        $row['abreviado'] = $this->abreviado->DefaultValue;
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

        // idcargo

        // cargo
        $this->cargo->CellCssStyle = "white-space: nowrap;";

        // salario

        // nr_horas_mes

        // nr_horas_ad_noite

        // escala_idescala

        // escala

        // periodo_idperiodo

        // periodo

        // jornada

        // fator

        // nr_dias_mes

        // intra_sdf

        // intra_df

        // ad_noite

        // DSR_ad_noite

        // he_50

        // DSR_he_50

        // intra_todos

        // intra_SabDomFer

        // intra_DomFer

        // vt_dia

        // vr_dia

        // va_mes

        // benef_social

        // plr_mes

        // assis_medica

        // assis_odonto

        // desc_vt

        // abreviado

        // Accumulate aggregate value
        if ($this->RowType != RowType::AGGREGATEINIT && $this->RowType != RowType::AGGREGATE && $this->RowType != RowType::PREVIEWFIELD) {
            $this->cargo->Count++; // Increment count
        }

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idcargo
            $this->idcargo->ViewValue = $this->idcargo->CurrentValue;

            // cargo
            $this->cargo->ViewValue = $this->cargo->CurrentValue;
            $this->cargo->CssClass = "fw-bold";

            // salario
            $this->salario->ViewValue = $this->salario->CurrentValue;
            $this->salario->ViewValue = FormatCurrency($this->salario->ViewValue, $this->salario->formatPattern());
            $this->salario->CssClass = "fw-bold";
            $this->salario->CellCssStyle .= "text-align: right;";

            // nr_horas_mes
            $this->nr_horas_mes->ViewValue = $this->nr_horas_mes->CurrentValue;
            $this->nr_horas_mes->ViewValue = FormatNumber($this->nr_horas_mes->ViewValue, $this->nr_horas_mes->formatPattern());

            // nr_horas_ad_noite
            $this->nr_horas_ad_noite->ViewValue = $this->nr_horas_ad_noite->CurrentValue;
            $this->nr_horas_ad_noite->ViewValue = FormatNumber($this->nr_horas_ad_noite->ViewValue, $this->nr_horas_ad_noite->formatPattern());

            // escala_idescala
            $this->escala_idescala->ViewValue = $this->escala_idescala->CurrentValue;
            $this->escala_idescala->ViewValue = FormatNumber($this->escala_idescala->ViewValue, $this->escala_idescala->formatPattern());
            $this->escala_idescala->CssClass = "fw-bold";

            // escala
            $this->escala->ViewValue = $this->escala->CurrentValue;
            $this->escala->CssClass = "fw-bold";
            $this->escala->CellCssStyle .= "text-align: center;";

            // periodo_idperiodo
            $this->periodo_idperiodo->ViewValue = $this->periodo_idperiodo->CurrentValue;
            $this->periodo_idperiodo->ViewValue = FormatNumber($this->periodo_idperiodo->ViewValue, $this->periodo_idperiodo->formatPattern());

            // periodo
            $this->periodo->ViewValue = $this->periodo->CurrentValue;
            $this->periodo->CssClass = "fw-bold";
            $this->periodo->CellCssStyle .= "text-align: center;";

            // jornada
            $this->jornada->ViewValue = $this->jornada->CurrentValue;
            $this->jornada->ViewValue = FormatNumber($this->jornada->ViewValue, $this->jornada->formatPattern());
            $this->jornada->CssClass = "fw-bold";
            $this->jornada->CellCssStyle .= "text-align: center;";

            // fator
            $this->fator->ViewValue = $this->fator->CurrentValue;
            $this->fator->ViewValue = FormatNumber($this->fator->ViewValue, $this->fator->formatPattern());

            // nr_dias_mes
            $this->nr_dias_mes->ViewValue = $this->nr_dias_mes->CurrentValue;
            $this->nr_dias_mes->ViewValue = FormatNumber($this->nr_dias_mes->ViewValue, $this->nr_dias_mes->formatPattern());
            $this->nr_dias_mes->CssClass = "fw-bold";
            $this->nr_dias_mes->CellCssStyle .= "text-align: center;";

            // intra_sdf
            $this->intra_sdf->ViewValue = $this->intra_sdf->CurrentValue;
            $this->intra_sdf->ViewValue = FormatCurrency($this->intra_sdf->ViewValue, $this->intra_sdf->formatPattern());
            $this->intra_sdf->CssClass = "fw-bold";
            $this->intra_sdf->CellCssStyle .= "text-align: right;";

            // intra_df
            $this->intra_df->ViewValue = $this->intra_df->CurrentValue;
            $this->intra_df->ViewValue = FormatCurrency($this->intra_df->ViewValue, $this->intra_df->formatPattern());
            $this->intra_df->CssClass = "fw-bold";
            $this->intra_df->CellCssStyle .= "text-align: right;";

            // ad_noite
            $this->ad_noite->ViewValue = $this->ad_noite->CurrentValue;
            $this->ad_noite->ViewValue = FormatCurrency($this->ad_noite->ViewValue, $this->ad_noite->formatPattern());
            $this->ad_noite->CssClass = "fw-bold";
            $this->ad_noite->CellCssStyle .= "text-align: right;";

            // DSR_ad_noite
            $this->DSR_ad_noite->ViewValue = $this->DSR_ad_noite->CurrentValue;
            $this->DSR_ad_noite->ViewValue = FormatCurrency($this->DSR_ad_noite->ViewValue, $this->DSR_ad_noite->formatPattern());
            $this->DSR_ad_noite->CssClass = "fw-bold";
            $this->DSR_ad_noite->CellCssStyle .= "text-align: right;";

            // he_50
            $this->he_50->ViewValue = $this->he_50->CurrentValue;
            $this->he_50->ViewValue = FormatCurrency($this->he_50->ViewValue, $this->he_50->formatPattern());
            $this->he_50->CssClass = "fw-bold";
            $this->he_50->CellCssStyle .= "text-align: right;";

            // DSR_he_50
            $this->DSR_he_50->ViewValue = $this->DSR_he_50->CurrentValue;
            $this->DSR_he_50->ViewValue = FormatCurrency($this->DSR_he_50->ViewValue, $this->DSR_he_50->formatPattern());
            $this->DSR_he_50->CssClass = "fw-bold";
            $this->DSR_he_50->CellCssStyle .= "text-align: right;";

            // intra_todos
            $this->intra_todos->ViewValue = $this->intra_todos->CurrentValue;
            $this->intra_todos->ViewValue = FormatCurrency($this->intra_todos->ViewValue, $this->intra_todos->formatPattern());
            $this->intra_todos->CssClass = "fw-bold";
            $this->intra_todos->CellCssStyle .= "text-align: right;";

            // intra_SabDomFer
            $this->intra_SabDomFer->ViewValue = $this->intra_SabDomFer->CurrentValue;
            $this->intra_SabDomFer->ViewValue = FormatCurrency($this->intra_SabDomFer->ViewValue, $this->intra_SabDomFer->formatPattern());
            $this->intra_SabDomFer->CssClass = "fw-bold";
            $this->intra_SabDomFer->CellCssStyle .= "text-align: right;";

            // intra_DomFer
            $this->intra_DomFer->ViewValue = $this->intra_DomFer->CurrentValue;
            $this->intra_DomFer->ViewValue = FormatCurrency($this->intra_DomFer->ViewValue, $this->intra_DomFer->formatPattern());
            $this->intra_DomFer->CssClass = "fw-bold";
            $this->intra_DomFer->CellCssStyle .= "text-align: right;";

            // vt_dia
            $this->vt_dia->ViewValue = $this->vt_dia->CurrentValue;
            $this->vt_dia->ViewValue = FormatCurrency($this->vt_dia->ViewValue, $this->vt_dia->formatPattern());
            $this->vt_dia->CssClass = "fw-bold";
            $this->vt_dia->CellCssStyle .= "text-align: right;";

            // vr_dia
            $this->vr_dia->ViewValue = $this->vr_dia->CurrentValue;
            $this->vr_dia->ViewValue = FormatCurrency($this->vr_dia->ViewValue, $this->vr_dia->formatPattern());
            $this->vr_dia->CssClass = "fw-bold";
            $this->vr_dia->CellCssStyle .= "text-align: right;";

            // va_mes
            $this->va_mes->ViewValue = $this->va_mes->CurrentValue;
            $this->va_mes->ViewValue = FormatCurrency($this->va_mes->ViewValue, $this->va_mes->formatPattern());
            $this->va_mes->CssClass = "fw-bold";
            $this->va_mes->CellCssStyle .= "text-align: right;";

            // benef_social
            $this->benef_social->ViewValue = $this->benef_social->CurrentValue;
            $this->benef_social->ViewValue = FormatCurrency($this->benef_social->ViewValue, $this->benef_social->formatPattern());
            $this->benef_social->CssClass = "fw-bold";
            $this->benef_social->CellCssStyle .= "text-align: right;";

            // plr_mes
            $this->plr_mes->ViewValue = $this->plr_mes->CurrentValue;
            $this->plr_mes->ViewValue = FormatCurrency($this->plr_mes->ViewValue, $this->plr_mes->formatPattern());
            $this->plr_mes->CssClass = "fw-bold";
            $this->plr_mes->CellCssStyle .= "text-align: right;";

            // assis_medica
            $this->assis_medica->ViewValue = $this->assis_medica->CurrentValue;
            $this->assis_medica->ViewValue = FormatCurrency($this->assis_medica->ViewValue, $this->assis_medica->formatPattern());
            $this->assis_medica->CssClass = "fw-bold";
            $this->assis_medica->CellCssStyle .= "text-align: right;";

            // assis_odonto
            $this->assis_odonto->ViewValue = $this->assis_odonto->CurrentValue;
            $this->assis_odonto->ViewValue = FormatCurrency($this->assis_odonto->ViewValue, $this->assis_odonto->formatPattern());
            $this->assis_odonto->CssClass = "fw-bold";
            $this->assis_odonto->CellCssStyle .= "text-align: right;";

            // desc_vt
            $this->desc_vt->ViewValue = $this->desc_vt->CurrentValue;
            $this->desc_vt->ViewValue = FormatCurrency($this->desc_vt->ViewValue, $this->desc_vt->formatPattern());
            $this->desc_vt->CssClass = "fw-bold";
            $this->desc_vt->CellCssStyle .= "text-align: right;";

            // abreviado
            $this->abreviado->ViewValue = $this->abreviado->CurrentValue;

            // cargo
            $this->cargo->HrefValue = "";
            $this->cargo->TooltipValue = "";

            // salario
            $this->salario->HrefValue = "";
            $this->salario->TooltipValue = "";

            // escala
            $this->escala->HrefValue = "";
            $this->escala->TooltipValue = "";

            // periodo
            $this->periodo->HrefValue = "";
            $this->periodo->TooltipValue = "";

            // jornada
            $this->jornada->HrefValue = "";
            $this->jornada->TooltipValue = "";

            // nr_dias_mes
            $this->nr_dias_mes->HrefValue = "";
            $this->nr_dias_mes->TooltipValue = "";

            // ad_noite
            $this->ad_noite->HrefValue = "";
            $this->ad_noite->TooltipValue = "";

            // DSR_ad_noite
            $this->DSR_ad_noite->HrefValue = "";
            $this->DSR_ad_noite->TooltipValue = "";

            // he_50
            $this->he_50->HrefValue = "";
            $this->he_50->TooltipValue = "";

            // DSR_he_50
            $this->DSR_he_50->HrefValue = "";
            $this->DSR_he_50->TooltipValue = "";

            // intra_todos
            $this->intra_todos->HrefValue = "";
            $this->intra_todos->TooltipValue = "";

            // intra_SabDomFer
            $this->intra_SabDomFer->HrefValue = "";
            $this->intra_SabDomFer->TooltipValue = "";

            // intra_DomFer
            $this->intra_DomFer->HrefValue = "";
            $this->intra_DomFer->TooltipValue = "";

            // vt_dia
            $this->vt_dia->HrefValue = "";
            $this->vt_dia->TooltipValue = "";

            // vr_dia
            $this->vr_dia->HrefValue = "";
            $this->vr_dia->TooltipValue = "";

            // va_mes
            $this->va_mes->HrefValue = "";
            $this->va_mes->TooltipValue = "";

            // benef_social
            $this->benef_social->HrefValue = "";
            $this->benef_social->TooltipValue = "";

            // plr_mes
            $this->plr_mes->HrefValue = "";
            $this->plr_mes->TooltipValue = "";

            // assis_medica
            $this->assis_medica->HrefValue = "";
            $this->assis_medica->TooltipValue = "";

            // assis_odonto
            $this->assis_odonto->HrefValue = "";
            $this->assis_odonto->TooltipValue = "";

            // desc_vt
            $this->desc_vt->HrefValue = "";
            $this->desc_vt->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // cargo
            if ($this->cargo->UseFilter && !EmptyValue($this->cargo->AdvancedSearch->SearchValue)) {
                if (is_array($this->cargo->AdvancedSearch->SearchValue)) {
                    $this->cargo->AdvancedSearch->SearchValue = implode(Config("FILTER_OPTION_SEPARATOR"), $this->cargo->AdvancedSearch->SearchValue);
                }
                $this->cargo->EditValue = explode(Config("FILTER_OPTION_SEPARATOR"), $this->cargo->AdvancedSearch->SearchValue);
            }

            // salario
            $this->salario->setupEditAttributes();
            $this->salario->EditValue = $this->salario->AdvancedSearch->SearchValue;
            $this->salario->PlaceHolder = RemoveHtml($this->salario->caption());

            // escala
            $curVal = trim(strval($this->escala->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->escala->AdvancedSearch->ViewValue = $this->escala->lookupCacheOption($curVal);
            } else {
                $this->escala->AdvancedSearch->ViewValue = $this->escala->Lookup !== null && is_array($this->escala->lookupOptions()) && count($this->escala->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->escala->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->escala->EditValue = array_values($this->escala->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->escala->Lookup->getTable()->Fields["escala"]->searchExpression(), "=", $this->escala->AdvancedSearch->SearchValue, $this->escala->Lookup->getTable()->Fields["escala"]->searchDataType(), "");
                }
                $sqlWrk = $this->escala->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->escala->EditValue = $arwrk;
            }
            $this->escala->PlaceHolder = RemoveHtml($this->escala->caption());

            // periodo
            $curVal = trim(strval($this->periodo->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->periodo->AdvancedSearch->ViewValue = $this->periodo->lookupCacheOption($curVal);
            } else {
                $this->periodo->AdvancedSearch->ViewValue = $this->periodo->Lookup !== null && is_array($this->periodo->lookupOptions()) && count($this->periodo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->periodo->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->periodo->EditValue = array_values($this->periodo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->periodo->Lookup->getTable()->Fields["periodo"]->searchExpression(), "=", $this->periodo->AdvancedSearch->SearchValue, $this->periodo->Lookup->getTable()->Fields["periodo"]->searchDataType(), "");
                }
                $sqlWrk = $this->periodo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->periodo->EditValue = $arwrk;
            }
            $this->periodo->PlaceHolder = RemoveHtml($this->periodo->caption());

            // jornada
            $this->jornada->setupEditAttributes();
            $this->jornada->EditValue = $this->jornada->AdvancedSearch->SearchValue;
            $this->jornada->PlaceHolder = RemoveHtml($this->jornada->caption());

            // nr_dias_mes
            $this->nr_dias_mes->setupEditAttributes();
            $this->nr_dias_mes->EditValue = $this->nr_dias_mes->AdvancedSearch->SearchValue;
            $this->nr_dias_mes->PlaceHolder = RemoveHtml($this->nr_dias_mes->caption());

            // ad_noite
            $this->ad_noite->setupEditAttributes();
            $this->ad_noite->EditValue = $this->ad_noite->AdvancedSearch->SearchValue;
            $this->ad_noite->PlaceHolder = RemoveHtml($this->ad_noite->caption());

            // DSR_ad_noite
            $this->DSR_ad_noite->setupEditAttributes();
            $this->DSR_ad_noite->EditValue = $this->DSR_ad_noite->AdvancedSearch->SearchValue;
            $this->DSR_ad_noite->PlaceHolder = RemoveHtml($this->DSR_ad_noite->caption());

            // he_50
            $this->he_50->setupEditAttributes();
            $this->he_50->EditValue = $this->he_50->AdvancedSearch->SearchValue;
            $this->he_50->PlaceHolder = RemoveHtml($this->he_50->caption());

            // DSR_he_50
            $this->DSR_he_50->setupEditAttributes();
            $this->DSR_he_50->EditValue = $this->DSR_he_50->AdvancedSearch->SearchValue;
            $this->DSR_he_50->PlaceHolder = RemoveHtml($this->DSR_he_50->caption());

            // intra_todos
            $this->intra_todos->setupEditAttributes();
            $this->intra_todos->EditValue = $this->intra_todos->AdvancedSearch->SearchValue;
            $this->intra_todos->PlaceHolder = RemoveHtml($this->intra_todos->caption());

            // intra_SabDomFer
            $this->intra_SabDomFer->setupEditAttributes();
            $this->intra_SabDomFer->EditValue = $this->intra_SabDomFer->AdvancedSearch->SearchValue;
            $this->intra_SabDomFer->PlaceHolder = RemoveHtml($this->intra_SabDomFer->caption());

            // intra_DomFer
            $this->intra_DomFer->setupEditAttributes();
            $this->intra_DomFer->EditValue = $this->intra_DomFer->AdvancedSearch->SearchValue;
            $this->intra_DomFer->PlaceHolder = RemoveHtml($this->intra_DomFer->caption());

            // vt_dia
            $this->vt_dia->setupEditAttributes();
            $this->vt_dia->EditValue = $this->vt_dia->AdvancedSearch->SearchValue;
            $this->vt_dia->PlaceHolder = RemoveHtml($this->vt_dia->caption());

            // vr_dia
            $this->vr_dia->setupEditAttributes();
            $this->vr_dia->EditValue = $this->vr_dia->AdvancedSearch->SearchValue;
            $this->vr_dia->PlaceHolder = RemoveHtml($this->vr_dia->caption());

            // va_mes
            $this->va_mes->setupEditAttributes();
            $this->va_mes->EditValue = $this->va_mes->AdvancedSearch->SearchValue;
            $this->va_mes->PlaceHolder = RemoveHtml($this->va_mes->caption());

            // benef_social
            $this->benef_social->setupEditAttributes();
            $this->benef_social->EditValue = $this->benef_social->AdvancedSearch->SearchValue;
            $this->benef_social->PlaceHolder = RemoveHtml($this->benef_social->caption());

            // plr_mes
            $this->plr_mes->setupEditAttributes();
            $this->plr_mes->EditValue = $this->plr_mes->AdvancedSearch->SearchValue;
            $this->plr_mes->PlaceHolder = RemoveHtml($this->plr_mes->caption());

            // assis_medica
            $this->assis_medica->setupEditAttributes();
            $this->assis_medica->EditValue = $this->assis_medica->AdvancedSearch->SearchValue;
            $this->assis_medica->PlaceHolder = RemoveHtml($this->assis_medica->caption());

            // assis_odonto
            $this->assis_odonto->setupEditAttributes();
            $this->assis_odonto->EditValue = $this->assis_odonto->AdvancedSearch->SearchValue;
            $this->assis_odonto->PlaceHolder = RemoveHtml($this->assis_odonto->caption());

            // desc_vt
            $this->desc_vt->setupEditAttributes();
            $this->desc_vt->EditValue = $this->desc_vt->AdvancedSearch->SearchValue;
            $this->desc_vt->PlaceHolder = RemoveHtml($this->desc_vt->caption());
        } elseif ($this->RowType == RowType::AGGREGATEINIT) { // Initialize aggregate row
                $this->cargo->Count = 0; // Initialize count
        } elseif ($this->RowType == RowType::AGGREGATE) { // Aggregate row
            $this->cargo->CurrentValue = $this->cargo->Count;
            $this->cargo->ViewValue = $this->cargo->CurrentValue;
            $this->cargo->CssClass = "fw-bold";
            $this->cargo->HrefValue = ""; // Clear href value
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
        $this->idcargo->AdvancedSearch->load();
        $this->cargo->AdvancedSearch->load();
        $this->salario->AdvancedSearch->load();
        $this->nr_horas_mes->AdvancedSearch->load();
        $this->nr_horas_ad_noite->AdvancedSearch->load();
        $this->escala_idescala->AdvancedSearch->load();
        $this->escala->AdvancedSearch->load();
        $this->periodo_idperiodo->AdvancedSearch->load();
        $this->periodo->AdvancedSearch->load();
        $this->jornada->AdvancedSearch->load();
        $this->fator->AdvancedSearch->load();
        $this->nr_dias_mes->AdvancedSearch->load();
        $this->intra_sdf->AdvancedSearch->load();
        $this->intra_df->AdvancedSearch->load();
        $this->ad_noite->AdvancedSearch->load();
        $this->DSR_ad_noite->AdvancedSearch->load();
        $this->he_50->AdvancedSearch->load();
        $this->DSR_he_50->AdvancedSearch->load();
        $this->intra_todos->AdvancedSearch->load();
        $this->intra_SabDomFer->AdvancedSearch->load();
        $this->intra_DomFer->AdvancedSearch->load();
        $this->vt_dia->AdvancedSearch->load();
        $this->vr_dia->AdvancedSearch->load();
        $this->va_mes->AdvancedSearch->load();
        $this->benef_social->AdvancedSearch->load();
        $this->plr_mes->AdvancedSearch->load();
        $this->assis_medica->AdvancedSearch->load();
        $this->assis_odonto->AdvancedSearch->load();
        $this->desc_vt->AdvancedSearch->load();
        $this->abreviado->AdvancedSearch->load();
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
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fview_custo_salariolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fview_custo_salariolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fview_custo_salariolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fview_custo_salariolist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fview_custo_salariosrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_escala":
                    break;
                case "x_periodo":
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
