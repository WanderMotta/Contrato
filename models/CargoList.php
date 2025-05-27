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
class CargoList extends Cargo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "CargoList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fcargolist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "CargoList";

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
        $this->abreviado->setVisibility();
        $this->funcao_idfuncao->Visible = false;
        $this->salario->setVisibility();
        $this->tipo_uniforme_idtipo_uniforme->Visible = false;
        $this->escala_idescala->setVisibility();
        $this->periodo_idperiodo->setVisibility();
        $this->jornada->setVisibility();
        $this->nr_horas_mes->Visible = false;
        $this->nr_horas_ad_noite->Visible = false;
        $this->intrajornada->Visible = false;
        $this->vt_dia->setVisibility();
        $this->vr_dia->setVisibility();
        $this->va_mes->setVisibility();
        $this->benef_social->setVisibility();
        $this->plr->setVisibility();
        $this->assis_medica->setVisibility();
        $this->assis_odonto->setVisibility();
        $this->modulo_idmodulo->Visible = false;
        $this->salario_antes->Visible = false;
        $this->vt_dia_antes->Visible = false;
        $this->vr_dia_antes->Visible = false;
        $this->va_mes_antes->Visible = false;
        $this->benef_social_antes->Visible = false;
        $this->plr_antes->Visible = false;
        $this->assis_medica_antes->Visible = false;
        $this->assis_odonto_antes->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'cargo';
        $this->TableName = 'cargo';

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

        // Table object (cargo)
        if (!isset($GLOBALS["cargo"]) || $GLOBALS["cargo"]::class == PROJECT_NAMESPACE . "cargo") {
            $GLOBALS["cargo"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "CargoAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "CargoDelete";
        $this->MultiUpdateUrl = "CargoUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'cargo');
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
                    $result["view"] = SameString($pageName, "CargoView"); // If View page, no primary button
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

        // Create form object
        $CurrentForm = new HttpForm();

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

        // Set up lookup cache
        $this->setupLookupOptions($this->funcao_idfuncao);
        $this->setupLookupOptions($this->tipo_uniforme_idtipo_uniforme);
        $this->setupLookupOptions($this->escala_idescala);
        $this->setupLookupOptions($this->periodo_idperiodo);
        $this->setupLookupOptions($this->intrajornada);
        $this->setupLookupOptions($this->modulo_idmodulo);

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fcargogrid";
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

        // Check QueryString parameters
        if (Get("action") !== null) {
            $this->CurrentAction = Get("action");
        } else {
            if (Post("action") !== null && Post("action") !== $this->UserAction) {
                $this->CurrentAction = Post("action"); // Get action
            } elseif (Session(SESSION_INLINE_MODE) == "gridedit") { // Previously in grid edit mode
                if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) { // Stay in grid edit mode if paging
                    $this->gridEditMode();
                } else { // Reset grid edit
                    $this->clearInlineMode();
                }
            }
        }

        // Clear inline mode
        if ($this->isCancel()) {
            $this->clearInlineMode();
        }

        // Switch to grid edit mode
        if ($this->isGridEdit()) {
            $this->gridEditMode();
        }

        // Grid Update
        if (IsPost() && ($this->isGridUpdate() || $this->isMultiUpdate() || $this->isGridOverwrite()) && (Session(SESSION_INLINE_MODE) == "gridedit" || Session(SESSION_INLINE_MODE) == "multiedit")) {
            if ($this->validateGridForm()) {
                $gridUpdate = $this->gridUpdate();
            } else {
                $gridUpdate = false;
            }
            if ($gridUpdate) {
                // Handle modal grid edit and multi edit, redirect to list page directly
                if ($this->IsModal && !$this->UseAjaxActions) {
                    $this->terminate("CargoList");
                    return;
                }
            } else {
                $this->EventCancelled = true;
                if ($this->UseAjaxActions) {
                    WriteJson([
                        "success" => false,
                        "validation" => $this->ValidationErrors,
                        "error" => $this->getFailureMessage()
                    ]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                }
                if ($this->isMultiUpdate()) { // Stay in Multi-Edit mode
                    $this->FilterForModalActions = $this->getFilterFromRecords($this->getGridFormValues());
                    $this->multiEditMode();
                } else { // Stay in grid edit mode
                    $this->gridEditMode();
                }
            }
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

        // Show grid delete link for grid add / grid edit
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $item = $this->ListOptions["griddelete"];
                if ($item) {
                    $item->Visible = false;
                }
            }
        }

        // Get default search criteria
        AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));

        // Get basic search values
        $this->loadBasicSearchValues();

        // Process filter list
        if ($this->processFilterList()) {
            $this->terminate();
            return;
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

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->salario->FormValue = ""; // Clear form value
        $this->jornada->FormValue = ""; // Clear form value
        $this->vt_dia->FormValue = ""; // Clear form value
        $this->vr_dia->FormValue = ""; // Clear form value
        $this->va_mes->FormValue = ""; // Clear form value
        $this->benef_social->FormValue = ""; // Clear form value
        $this->plr->FormValue = ""; // Clear form value
        $this->assis_medica->FormValue = ""; // Clear form value
        $this->assis_odonto->FormValue = ""; // Clear form value
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
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

        // Begin transaction
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }
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
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }
            $this->FilterForModalActions = $wrkfilter;

            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
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

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if (
            $CurrentForm->hasValue("x_cargo") &&
            $CurrentForm->hasValue("o_cargo") &&
            $this->cargo->CurrentValue != $this->cargo->DefaultValue &&
            !($this->cargo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->cargo->CurrentValue == $this->cargo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_abreviado") &&
            $CurrentForm->hasValue("o_abreviado") &&
            $this->abreviado->CurrentValue != $this->abreviado->DefaultValue &&
            !($this->abreviado->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->abreviado->CurrentValue == $this->abreviado->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_salario") &&
            $CurrentForm->hasValue("o_salario") &&
            $this->salario->CurrentValue != $this->salario->DefaultValue &&
            !($this->salario->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->salario->CurrentValue == $this->salario->getSessionValue())
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
            $CurrentForm->hasValue("x_jornada") &&
            $CurrentForm->hasValue("o_jornada") &&
            $this->jornada->CurrentValue != $this->jornada->DefaultValue &&
            !($this->jornada->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->jornada->CurrentValue == $this->jornada->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_vt_dia") &&
            $CurrentForm->hasValue("o_vt_dia") &&
            $this->vt_dia->CurrentValue != $this->vt_dia->DefaultValue &&
            !($this->vt_dia->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->vt_dia->CurrentValue == $this->vt_dia->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_vr_dia") &&
            $CurrentForm->hasValue("o_vr_dia") &&
            $this->vr_dia->CurrentValue != $this->vr_dia->DefaultValue &&
            !($this->vr_dia->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->vr_dia->CurrentValue == $this->vr_dia->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_va_mes") &&
            $CurrentForm->hasValue("o_va_mes") &&
            $this->va_mes->CurrentValue != $this->va_mes->DefaultValue &&
            !($this->va_mes->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->va_mes->CurrentValue == $this->va_mes->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_benef_social") &&
            $CurrentForm->hasValue("o_benef_social") &&
            $this->benef_social->CurrentValue != $this->benef_social->DefaultValue &&
            !($this->benef_social->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->benef_social->CurrentValue == $this->benef_social->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_plr") &&
            $CurrentForm->hasValue("o_plr") &&
            $this->plr->CurrentValue != $this->plr->DefaultValue &&
            !($this->plr->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->plr->CurrentValue == $this->plr->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_assis_medica") &&
            $CurrentForm->hasValue("o_assis_medica") &&
            $this->assis_medica->CurrentValue != $this->assis_medica->DefaultValue &&
            !($this->assis_medica->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->assis_medica->CurrentValue == $this->assis_medica->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_assis_odonto") &&
            $CurrentForm->hasValue("o_assis_odonto") &&
            $this->assis_odonto->CurrentValue != $this->assis_odonto->DefaultValue &&
            !($this->assis_odonto->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->assis_odonto->CurrentValue == $this->assis_odonto->getSessionValue())
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

    // Get list of filters
    public function getFilterList()
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->idcargo->AdvancedSearch->toJson(), ","); // Field idcargo
        $filterList = Concat($filterList, $this->cargo->AdvancedSearch->toJson(), ","); // Field cargo
        $filterList = Concat($filterList, $this->abreviado->AdvancedSearch->toJson(), ","); // Field abreviado
        $filterList = Concat($filterList, $this->funcao_idfuncao->AdvancedSearch->toJson(), ","); // Field funcao_idfuncao
        $filterList = Concat($filterList, $this->salario->AdvancedSearch->toJson(), ","); // Field salario
        $filterList = Concat($filterList, $this->tipo_uniforme_idtipo_uniforme->AdvancedSearch->toJson(), ","); // Field tipo_uniforme_idtipo_uniforme
        $filterList = Concat($filterList, $this->escala_idescala->AdvancedSearch->toJson(), ","); // Field escala_idescala
        $filterList = Concat($filterList, $this->periodo_idperiodo->AdvancedSearch->toJson(), ","); // Field periodo_idperiodo
        $filterList = Concat($filterList, $this->jornada->AdvancedSearch->toJson(), ","); // Field jornada
        $filterList = Concat($filterList, $this->nr_horas_mes->AdvancedSearch->toJson(), ","); // Field nr_horas_mes
        $filterList = Concat($filterList, $this->nr_horas_ad_noite->AdvancedSearch->toJson(), ","); // Field nr_horas_ad_noite
        $filterList = Concat($filterList, $this->intrajornada->AdvancedSearch->toJson(), ","); // Field intrajornada
        $filterList = Concat($filterList, $this->vt_dia->AdvancedSearch->toJson(), ","); // Field vt_dia
        $filterList = Concat($filterList, $this->vr_dia->AdvancedSearch->toJson(), ","); // Field vr_dia
        $filterList = Concat($filterList, $this->va_mes->AdvancedSearch->toJson(), ","); // Field va_mes
        $filterList = Concat($filterList, $this->benef_social->AdvancedSearch->toJson(), ","); // Field benef_social
        $filterList = Concat($filterList, $this->plr->AdvancedSearch->toJson(), ","); // Field plr
        $filterList = Concat($filterList, $this->assis_medica->AdvancedSearch->toJson(), ","); // Field assis_medica
        $filterList = Concat($filterList, $this->assis_odonto->AdvancedSearch->toJson(), ","); // Field assis_odonto
        $filterList = Concat($filterList, $this->modulo_idmodulo->AdvancedSearch->toJson(), ","); // Field modulo_idmodulo
        $filterList = Concat($filterList, $this->salario_antes->AdvancedSearch->toJson(), ","); // Field salario_antes
        $filterList = Concat($filterList, $this->vt_dia_antes->AdvancedSearch->toJson(), ","); // Field vt_dia_antes
        $filterList = Concat($filterList, $this->vr_dia_antes->AdvancedSearch->toJson(), ","); // Field vr_dia_antes
        $filterList = Concat($filterList, $this->va_mes_antes->AdvancedSearch->toJson(), ","); // Field va_mes_antes
        $filterList = Concat($filterList, $this->benef_social_antes->AdvancedSearch->toJson(), ","); // Field benef_social_antes
        $filterList = Concat($filterList, $this->plr_antes->AdvancedSearch->toJson(), ","); // Field plr_antes
        $filterList = Concat($filterList, $this->assis_medica_antes->AdvancedSearch->toJson(), ","); // Field assis_medica_antes
        $filterList = Concat($filterList, $this->assis_odonto_antes->AdvancedSearch->toJson(), ","); // Field assis_odonto_antes
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
            Profile()->setSearchFilters("fcargosrch", $filters);
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

        // Field abreviado
        $this->abreviado->AdvancedSearch->SearchValue = @$filter["x_abreviado"];
        $this->abreviado->AdvancedSearch->SearchOperator = @$filter["z_abreviado"];
        $this->abreviado->AdvancedSearch->SearchCondition = @$filter["v_abreviado"];
        $this->abreviado->AdvancedSearch->SearchValue2 = @$filter["y_abreviado"];
        $this->abreviado->AdvancedSearch->SearchOperator2 = @$filter["w_abreviado"];
        $this->abreviado->AdvancedSearch->save();

        // Field funcao_idfuncao
        $this->funcao_idfuncao->AdvancedSearch->SearchValue = @$filter["x_funcao_idfuncao"];
        $this->funcao_idfuncao->AdvancedSearch->SearchOperator = @$filter["z_funcao_idfuncao"];
        $this->funcao_idfuncao->AdvancedSearch->SearchCondition = @$filter["v_funcao_idfuncao"];
        $this->funcao_idfuncao->AdvancedSearch->SearchValue2 = @$filter["y_funcao_idfuncao"];
        $this->funcao_idfuncao->AdvancedSearch->SearchOperator2 = @$filter["w_funcao_idfuncao"];
        $this->funcao_idfuncao->AdvancedSearch->save();

        // Field salario
        $this->salario->AdvancedSearch->SearchValue = @$filter["x_salario"];
        $this->salario->AdvancedSearch->SearchOperator = @$filter["z_salario"];
        $this->salario->AdvancedSearch->SearchCondition = @$filter["v_salario"];
        $this->salario->AdvancedSearch->SearchValue2 = @$filter["y_salario"];
        $this->salario->AdvancedSearch->SearchOperator2 = @$filter["w_salario"];
        $this->salario->AdvancedSearch->save();

        // Field tipo_uniforme_idtipo_uniforme
        $this->tipo_uniforme_idtipo_uniforme->AdvancedSearch->SearchValue = @$filter["x_tipo_uniforme_idtipo_uniforme"];
        $this->tipo_uniforme_idtipo_uniforme->AdvancedSearch->SearchOperator = @$filter["z_tipo_uniforme_idtipo_uniforme"];
        $this->tipo_uniforme_idtipo_uniforme->AdvancedSearch->SearchCondition = @$filter["v_tipo_uniforme_idtipo_uniforme"];
        $this->tipo_uniforme_idtipo_uniforme->AdvancedSearch->SearchValue2 = @$filter["y_tipo_uniforme_idtipo_uniforme"];
        $this->tipo_uniforme_idtipo_uniforme->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_uniforme_idtipo_uniforme"];
        $this->tipo_uniforme_idtipo_uniforme->AdvancedSearch->save();

        // Field escala_idescala
        $this->escala_idescala->AdvancedSearch->SearchValue = @$filter["x_escala_idescala"];
        $this->escala_idescala->AdvancedSearch->SearchOperator = @$filter["z_escala_idescala"];
        $this->escala_idescala->AdvancedSearch->SearchCondition = @$filter["v_escala_idescala"];
        $this->escala_idescala->AdvancedSearch->SearchValue2 = @$filter["y_escala_idescala"];
        $this->escala_idescala->AdvancedSearch->SearchOperator2 = @$filter["w_escala_idescala"];
        $this->escala_idescala->AdvancedSearch->save();

        // Field periodo_idperiodo
        $this->periodo_idperiodo->AdvancedSearch->SearchValue = @$filter["x_periodo_idperiodo"];
        $this->periodo_idperiodo->AdvancedSearch->SearchOperator = @$filter["z_periodo_idperiodo"];
        $this->periodo_idperiodo->AdvancedSearch->SearchCondition = @$filter["v_periodo_idperiodo"];
        $this->periodo_idperiodo->AdvancedSearch->SearchValue2 = @$filter["y_periodo_idperiodo"];
        $this->periodo_idperiodo->AdvancedSearch->SearchOperator2 = @$filter["w_periodo_idperiodo"];
        $this->periodo_idperiodo->AdvancedSearch->save();

        // Field jornada
        $this->jornada->AdvancedSearch->SearchValue = @$filter["x_jornada"];
        $this->jornada->AdvancedSearch->SearchOperator = @$filter["z_jornada"];
        $this->jornada->AdvancedSearch->SearchCondition = @$filter["v_jornada"];
        $this->jornada->AdvancedSearch->SearchValue2 = @$filter["y_jornada"];
        $this->jornada->AdvancedSearch->SearchOperator2 = @$filter["w_jornada"];
        $this->jornada->AdvancedSearch->save();

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

        // Field intrajornada
        $this->intrajornada->AdvancedSearch->SearchValue = @$filter["x_intrajornada"];
        $this->intrajornada->AdvancedSearch->SearchOperator = @$filter["z_intrajornada"];
        $this->intrajornada->AdvancedSearch->SearchCondition = @$filter["v_intrajornada"];
        $this->intrajornada->AdvancedSearch->SearchValue2 = @$filter["y_intrajornada"];
        $this->intrajornada->AdvancedSearch->SearchOperator2 = @$filter["w_intrajornada"];
        $this->intrajornada->AdvancedSearch->save();

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

        // Field plr
        $this->plr->AdvancedSearch->SearchValue = @$filter["x_plr"];
        $this->plr->AdvancedSearch->SearchOperator = @$filter["z_plr"];
        $this->plr->AdvancedSearch->SearchCondition = @$filter["v_plr"];
        $this->plr->AdvancedSearch->SearchValue2 = @$filter["y_plr"];
        $this->plr->AdvancedSearch->SearchOperator2 = @$filter["w_plr"];
        $this->plr->AdvancedSearch->save();

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

        // Field modulo_idmodulo
        $this->modulo_idmodulo->AdvancedSearch->SearchValue = @$filter["x_modulo_idmodulo"];
        $this->modulo_idmodulo->AdvancedSearch->SearchOperator = @$filter["z_modulo_idmodulo"];
        $this->modulo_idmodulo->AdvancedSearch->SearchCondition = @$filter["v_modulo_idmodulo"];
        $this->modulo_idmodulo->AdvancedSearch->SearchValue2 = @$filter["y_modulo_idmodulo"];
        $this->modulo_idmodulo->AdvancedSearch->SearchOperator2 = @$filter["w_modulo_idmodulo"];
        $this->modulo_idmodulo->AdvancedSearch->save();

        // Field salario_antes
        $this->salario_antes->AdvancedSearch->SearchValue = @$filter["x_salario_antes"];
        $this->salario_antes->AdvancedSearch->SearchOperator = @$filter["z_salario_antes"];
        $this->salario_antes->AdvancedSearch->SearchCondition = @$filter["v_salario_antes"];
        $this->salario_antes->AdvancedSearch->SearchValue2 = @$filter["y_salario_antes"];
        $this->salario_antes->AdvancedSearch->SearchOperator2 = @$filter["w_salario_antes"];
        $this->salario_antes->AdvancedSearch->save();

        // Field vt_dia_antes
        $this->vt_dia_antes->AdvancedSearch->SearchValue = @$filter["x_vt_dia_antes"];
        $this->vt_dia_antes->AdvancedSearch->SearchOperator = @$filter["z_vt_dia_antes"];
        $this->vt_dia_antes->AdvancedSearch->SearchCondition = @$filter["v_vt_dia_antes"];
        $this->vt_dia_antes->AdvancedSearch->SearchValue2 = @$filter["y_vt_dia_antes"];
        $this->vt_dia_antes->AdvancedSearch->SearchOperator2 = @$filter["w_vt_dia_antes"];
        $this->vt_dia_antes->AdvancedSearch->save();

        // Field vr_dia_antes
        $this->vr_dia_antes->AdvancedSearch->SearchValue = @$filter["x_vr_dia_antes"];
        $this->vr_dia_antes->AdvancedSearch->SearchOperator = @$filter["z_vr_dia_antes"];
        $this->vr_dia_antes->AdvancedSearch->SearchCondition = @$filter["v_vr_dia_antes"];
        $this->vr_dia_antes->AdvancedSearch->SearchValue2 = @$filter["y_vr_dia_antes"];
        $this->vr_dia_antes->AdvancedSearch->SearchOperator2 = @$filter["w_vr_dia_antes"];
        $this->vr_dia_antes->AdvancedSearch->save();

        // Field va_mes_antes
        $this->va_mes_antes->AdvancedSearch->SearchValue = @$filter["x_va_mes_antes"];
        $this->va_mes_antes->AdvancedSearch->SearchOperator = @$filter["z_va_mes_antes"];
        $this->va_mes_antes->AdvancedSearch->SearchCondition = @$filter["v_va_mes_antes"];
        $this->va_mes_antes->AdvancedSearch->SearchValue2 = @$filter["y_va_mes_antes"];
        $this->va_mes_antes->AdvancedSearch->SearchOperator2 = @$filter["w_va_mes_antes"];
        $this->va_mes_antes->AdvancedSearch->save();

        // Field benef_social_antes
        $this->benef_social_antes->AdvancedSearch->SearchValue = @$filter["x_benef_social_antes"];
        $this->benef_social_antes->AdvancedSearch->SearchOperator = @$filter["z_benef_social_antes"];
        $this->benef_social_antes->AdvancedSearch->SearchCondition = @$filter["v_benef_social_antes"];
        $this->benef_social_antes->AdvancedSearch->SearchValue2 = @$filter["y_benef_social_antes"];
        $this->benef_social_antes->AdvancedSearch->SearchOperator2 = @$filter["w_benef_social_antes"];
        $this->benef_social_antes->AdvancedSearch->save();

        // Field plr_antes
        $this->plr_antes->AdvancedSearch->SearchValue = @$filter["x_plr_antes"];
        $this->plr_antes->AdvancedSearch->SearchOperator = @$filter["z_plr_antes"];
        $this->plr_antes->AdvancedSearch->SearchCondition = @$filter["v_plr_antes"];
        $this->plr_antes->AdvancedSearch->SearchValue2 = @$filter["y_plr_antes"];
        $this->plr_antes->AdvancedSearch->SearchOperator2 = @$filter["w_plr_antes"];
        $this->plr_antes->AdvancedSearch->save();

        // Field assis_medica_antes
        $this->assis_medica_antes->AdvancedSearch->SearchValue = @$filter["x_assis_medica_antes"];
        $this->assis_medica_antes->AdvancedSearch->SearchOperator = @$filter["z_assis_medica_antes"];
        $this->assis_medica_antes->AdvancedSearch->SearchCondition = @$filter["v_assis_medica_antes"];
        $this->assis_medica_antes->AdvancedSearch->SearchValue2 = @$filter["y_assis_medica_antes"];
        $this->assis_medica_antes->AdvancedSearch->SearchOperator2 = @$filter["w_assis_medica_antes"];
        $this->assis_medica_antes->AdvancedSearch->save();

        // Field assis_odonto_antes
        $this->assis_odonto_antes->AdvancedSearch->SearchValue = @$filter["x_assis_odonto_antes"];
        $this->assis_odonto_antes->AdvancedSearch->SearchOperator = @$filter["z_assis_odonto_antes"];
        $this->assis_odonto_antes->AdvancedSearch->SearchCondition = @$filter["v_assis_odonto_antes"];
        $this->assis_odonto_antes->AdvancedSearch->SearchValue2 = @$filter["y_assis_odonto_antes"];
        $this->assis_odonto_antes->AdvancedSearch->SearchOperator2 = @$filter["w_assis_odonto_antes"];
        $this->assis_odonto_antes->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";
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
        $searchFlds[] = &$this->abreviado;
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

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->cargo->Expression . " ASC"; // Set up default sort
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
            $this->updateSort($this->abreviado, $ctrl); // abreviado
            $this->updateSort($this->salario, $ctrl); // salario
            $this->updateSort($this->escala_idescala, $ctrl); // escala_idescala
            $this->updateSort($this->periodo_idperiodo, $ctrl); // periodo_idperiodo
            $this->updateSort($this->jornada, $ctrl); // jornada
            $this->updateSort($this->vt_dia, $ctrl); // vt_dia
            $this->updateSort($this->vr_dia, $ctrl); // vr_dia
            $this->updateSort($this->va_mes, $ctrl); // va_mes
            $this->updateSort($this->benef_social, $ctrl); // benef_social
            $this->updateSort($this->plr, $ctrl); // plr
            $this->updateSort($this->assis_medica, $ctrl); // assis_medica
            $this->updateSort($this->assis_odonto, $ctrl); // assis_odonto
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
                $this->abreviado->setSort("");
                $this->funcao_idfuncao->setSort("");
                $this->salario->setSort("");
                $this->tipo_uniforme_idtipo_uniforme->setSort("");
                $this->escala_idescala->setSort("");
                $this->periodo_idperiodo->setSort("");
                $this->jornada->setSort("");
                $this->nr_horas_mes->setSort("");
                $this->nr_horas_ad_noite->setSort("");
                $this->intrajornada->setSort("");
                $this->vt_dia->setSort("");
                $this->vr_dia->setSort("");
                $this->va_mes->setSort("");
                $this->benef_social->setSort("");
                $this->plr->setSort("");
                $this->assis_medica->setSort("");
                $this->assis_odonto->setSort("");
                $this->modulo_idmodulo->setSort("");
                $this->salario_antes->setSort("");
                $this->vt_dia_antes->setSort("");
                $this->vr_dia_antes->setSort("");
                $this->va_mes_antes->setSort("");
                $this->benef_social_antes->setSort("");
                $this->plr_antes->setSort("");
                $this->assis_medica_antes->setSort("");
                $this->assis_odonto_antes->setSort("");
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
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        $pageUrl = $this->pageUrl(false);
        if ($this->CurrentMode == "view") {
            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                if ($this->ModalEdit && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"cargo\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"cargo\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("CopyLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fcargolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fcargolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        if ($this->ModalAdd && !IsMobile()) {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"cargo\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();

        // Add grid edit
        $option = $options["addedit"];
        $item = &$option->add("gridedit");
        if ($this->ModalGridEdit && !IsMobile()) {
            $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . $Language->phrase("GridEditLink", true) . "\" data-caption=\"" . $Language->phrase("GridEditLink", true) . "\" data-ew-action=\"modal\" data-btn=\"GridSaveLink\" data-url=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $Language->phrase("GridEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . $Language->phrase("GridEditLink", true) . "\" data-caption=\"" . $Language->phrase("GridEditLink", true) . "\" href=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $Language->phrase("GridEditLink") . "</a>";
        }
        $item->Visible = $this->GridEditUrl != "" && $Security->canEdit();
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "cargo");
            $this->createColumnOption($option, "abreviado");
            $this->createColumnOption($option, "salario");
            $this->createColumnOption($option, "escala_idescala");
            $this->createColumnOption($option, "periodo_idperiodo");
            $this->createColumnOption($option, "jornada");
            $this->createColumnOption($option, "vt_dia");
            $this->createColumnOption($option, "vr_dia");
            $this->createColumnOption($option, "va_mes");
            $this->createColumnOption($option, "benef_social");
            $this->createColumnOption($option, "plr");
            $this->createColumnOption($option, "assis_medica");
            $this->createColumnOption($option, "assis_odonto");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fcargosrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fcargosrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
        if (!$this->isGridAdd() && !$this->isGridEdit() && !$this->isMultiEdit()) { // Not grid add/grid edit/multi edit mode
            $option = $options["action"];
            // Set up list action buttons
            foreach ($this->ListActions as $listAction) {
                if ($listAction->Select == ACTION_MULTIPLE) {
                    $item = &$option->add("custom_" . $listAction->Action);
                    $caption = $listAction->Caption;
                    $icon = ($listAction->Icon != "") ? '<i class="' . HtmlEncode($listAction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                    $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fcargolist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
        } else { // Grid add/grid edit/multi edit mode
            // Hide all options first
            foreach ($options as $option) {
                $option->hideAllOptions();
            }
            $pageUrl = $this->pageUrl(false);

            // Grid-Edit
            if ($this->isGridEdit()) {
                    if ($this->AllowAddDeleteRow) {
                        // Add add blank row
                        $option = $options["addedit"];
                        $option->UseDropDownButton = false;
                        $item = &$option->add("addblankrow");
                        $item->Body = "<button class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</button>";
                        $item->Visible = $Security->canAdd();
                    }
                if (!($this->ModalGridEdit && !IsMobile())) {
                    $option = $options["action"];
                    $option->UseDropDownButton = false;
                        $item = &$option->add("gridsave");
                        $item->Body = "<button class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" form=\"fcargolist\" formaction=\"" . GetUrl($this->pageName()) . "\">" . $Language->phrase("GridSaveLink") . "</button>";
                        $item = &$option->add("gridcancel");
                        $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                        $item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
                }
            }
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_cargo", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_cargo",
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

    // Load default values
    protected function loadDefaultValues()
    {
        $this->jornada->DefaultValue = $this->jornada->getDefault(); // PHP
        $this->jornada->OldValue = $this->jornada->DefaultValue;
        $this->nr_horas_ad_noite->DefaultValue = $this->nr_horas_ad_noite->getDefault(); // PHP
        $this->nr_horas_ad_noite->OldValue = $this->nr_horas_ad_noite->DefaultValue;
        $this->intrajornada->DefaultValue = $this->intrajornada->getDefault(); // PHP
        $this->intrajornada->OldValue = $this->intrajornada->DefaultValue;
        $this->vt_dia->DefaultValue = $this->vt_dia->getDefault(); // PHP
        $this->vt_dia->OldValue = $this->vt_dia->DefaultValue;
        $this->vr_dia->DefaultValue = $this->vr_dia->getDefault(); // PHP
        $this->vr_dia->OldValue = $this->vr_dia->DefaultValue;
        $this->va_mes->DefaultValue = $this->va_mes->getDefault(); // PHP
        $this->va_mes->OldValue = $this->va_mes->DefaultValue;
        $this->benef_social->DefaultValue = $this->benef_social->getDefault(); // PHP
        $this->benef_social->OldValue = $this->benef_social->DefaultValue;
        $this->plr->DefaultValue = $this->plr->getDefault(); // PHP
        $this->plr->OldValue = $this->plr->DefaultValue;
        $this->assis_medica->DefaultValue = $this->assis_medica->getDefault(); // PHP
        $this->assis_medica->OldValue = $this->assis_medica->DefaultValue;
        $this->assis_odonto->DefaultValue = $this->assis_odonto->getDefault(); // PHP
        $this->assis_odonto->OldValue = $this->assis_odonto->DefaultValue;
        $this->modulo_idmodulo->DefaultValue = $this->modulo_idmodulo->getDefault(); // PHP
        $this->modulo_idmodulo->OldValue = $this->modulo_idmodulo->DefaultValue;
        $this->salario_antes->DefaultValue = $this->salario_antes->getDefault(); // PHP
        $this->salario_antes->OldValue = $this->salario_antes->DefaultValue;
        $this->vt_dia_antes->DefaultValue = $this->vt_dia_antes->getDefault(); // PHP
        $this->vt_dia_antes->OldValue = $this->vt_dia_antes->DefaultValue;
        $this->vr_dia_antes->DefaultValue = $this->vr_dia_antes->getDefault(); // PHP
        $this->vr_dia_antes->OldValue = $this->vr_dia_antes->DefaultValue;
        $this->va_mes_antes->DefaultValue = $this->va_mes_antes->getDefault(); // PHP
        $this->va_mes_antes->OldValue = $this->va_mes_antes->DefaultValue;
        $this->benef_social_antes->DefaultValue = $this->benef_social_antes->getDefault(); // PHP
        $this->benef_social_antes->OldValue = $this->benef_social_antes->DefaultValue;
        $this->plr_antes->DefaultValue = $this->plr_antes->getDefault(); // PHP
        $this->plr_antes->OldValue = $this->plr_antes->DefaultValue;
        $this->assis_medica_antes->DefaultValue = $this->assis_medica_antes->getDefault(); // PHP
        $this->assis_medica_antes->OldValue = $this->assis_medica_antes->DefaultValue;
        $this->assis_odonto_antes->DefaultValue = $this->assis_odonto_antes->getDefault(); // PHP
        $this->assis_odonto_antes->OldValue = $this->assis_odonto_antes->DefaultValue;
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'cargo' first before field var 'x_cargo'
        $val = $CurrentForm->hasValue("cargo") ? $CurrentForm->getValue("cargo") : $CurrentForm->getValue("x_cargo");
        if (!$this->cargo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cargo->Visible = false; // Disable update for API request
            } else {
                $this->cargo->setFormValue($val);
            }
        }

        // Check field name 'abreviado' first before field var 'x_abreviado'
        $val = $CurrentForm->hasValue("abreviado") ? $CurrentForm->getValue("abreviado") : $CurrentForm->getValue("x_abreviado");
        if (!$this->abreviado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->abreviado->Visible = false; // Disable update for API request
            } else {
                $this->abreviado->setFormValue($val);
            }
        }

        // Check field name 'salario' first before field var 'x_salario'
        $val = $CurrentForm->hasValue("salario") ? $CurrentForm->getValue("salario") : $CurrentForm->getValue("x_salario");
        if (!$this->salario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->salario->Visible = false; // Disable update for API request
            } else {
                $this->salario->setFormValue($val, true, $validate);
            }
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

        // Check field name 'periodo_idperiodo' first before field var 'x_periodo_idperiodo'
        $val = $CurrentForm->hasValue("periodo_idperiodo") ? $CurrentForm->getValue("periodo_idperiodo") : $CurrentForm->getValue("x_periodo_idperiodo");
        if (!$this->periodo_idperiodo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->periodo_idperiodo->Visible = false; // Disable update for API request
            } else {
                $this->periodo_idperiodo->setFormValue($val);
            }
        }

        // Check field name 'jornada' first before field var 'x_jornada'
        $val = $CurrentForm->hasValue("jornada") ? $CurrentForm->getValue("jornada") : $CurrentForm->getValue("x_jornada");
        if (!$this->jornada->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jornada->Visible = false; // Disable update for API request
            } else {
                $this->jornada->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'vt_dia' first before field var 'x_vt_dia'
        $val = $CurrentForm->hasValue("vt_dia") ? $CurrentForm->getValue("vt_dia") : $CurrentForm->getValue("x_vt_dia");
        if (!$this->vt_dia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vt_dia->Visible = false; // Disable update for API request
            } else {
                $this->vt_dia->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'vr_dia' first before field var 'x_vr_dia'
        $val = $CurrentForm->hasValue("vr_dia") ? $CurrentForm->getValue("vr_dia") : $CurrentForm->getValue("x_vr_dia");
        if (!$this->vr_dia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vr_dia->Visible = false; // Disable update for API request
            } else {
                $this->vr_dia->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'va_mes' first before field var 'x_va_mes'
        $val = $CurrentForm->hasValue("va_mes") ? $CurrentForm->getValue("va_mes") : $CurrentForm->getValue("x_va_mes");
        if (!$this->va_mes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->va_mes->Visible = false; // Disable update for API request
            } else {
                $this->va_mes->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'benef_social' first before field var 'x_benef_social'
        $val = $CurrentForm->hasValue("benef_social") ? $CurrentForm->getValue("benef_social") : $CurrentForm->getValue("x_benef_social");
        if (!$this->benef_social->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->benef_social->Visible = false; // Disable update for API request
            } else {
                $this->benef_social->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'plr' first before field var 'x_plr'
        $val = $CurrentForm->hasValue("plr") ? $CurrentForm->getValue("plr") : $CurrentForm->getValue("x_plr");
        if (!$this->plr->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->plr->Visible = false; // Disable update for API request
            } else {
                $this->plr->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'assis_medica' first before field var 'x_assis_medica'
        $val = $CurrentForm->hasValue("assis_medica") ? $CurrentForm->getValue("assis_medica") : $CurrentForm->getValue("x_assis_medica");
        if (!$this->assis_medica->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->assis_medica->Visible = false; // Disable update for API request
            } else {
                $this->assis_medica->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'assis_odonto' first before field var 'x_assis_odonto'
        $val = $CurrentForm->hasValue("assis_odonto") ? $CurrentForm->getValue("assis_odonto") : $CurrentForm->getValue("x_assis_odonto");
        if (!$this->assis_odonto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->assis_odonto->Visible = false; // Disable update for API request
            } else {
                $this->assis_odonto->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'idcargo' first before field var 'x_idcargo'
        $val = $CurrentForm->hasValue("idcargo") ? $CurrentForm->getValue("idcargo") : $CurrentForm->getValue("x_idcargo");
        if (!$this->idcargo->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->idcargo->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->idcargo->CurrentValue = $this->idcargo->FormValue;
        }
        $this->cargo->CurrentValue = $this->cargo->FormValue;
        $this->abreviado->CurrentValue = $this->abreviado->FormValue;
        $this->salario->CurrentValue = $this->salario->FormValue;
        $this->escala_idescala->CurrentValue = $this->escala_idescala->FormValue;
        $this->periodo_idperiodo->CurrentValue = $this->periodo_idperiodo->FormValue;
        $this->jornada->CurrentValue = $this->jornada->FormValue;
        $this->vt_dia->CurrentValue = $this->vt_dia->FormValue;
        $this->vr_dia->CurrentValue = $this->vr_dia->FormValue;
        $this->va_mes->CurrentValue = $this->va_mes->FormValue;
        $this->benef_social->CurrentValue = $this->benef_social->FormValue;
        $this->plr->CurrentValue = $this->plr->FormValue;
        $this->assis_medica->CurrentValue = $this->assis_medica->FormValue;
        $this->assis_odonto->CurrentValue = $this->assis_odonto->FormValue;
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
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
            }
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
        $this->abreviado->setDbValue($row['abreviado']);
        $this->funcao_idfuncao->setDbValue($row['funcao_idfuncao']);
        $this->salario->setDbValue($row['salario']);
        $this->tipo_uniforme_idtipo_uniforme->setDbValue($row['tipo_uniforme_idtipo_uniforme']);
        $this->escala_idescala->setDbValue($row['escala_idescala']);
        $this->periodo_idperiodo->setDbValue($row['periodo_idperiodo']);
        $this->jornada->setDbValue($row['jornada']);
        $this->nr_horas_mes->setDbValue($row['nr_horas_mes']);
        $this->nr_horas_ad_noite->setDbValue($row['nr_horas_ad_noite']);
        $this->intrajornada->setDbValue($row['intrajornada']);
        $this->vt_dia->setDbValue($row['vt_dia']);
        $this->vr_dia->setDbValue($row['vr_dia']);
        $this->va_mes->setDbValue($row['va_mes']);
        $this->benef_social->setDbValue($row['benef_social']);
        $this->plr->setDbValue($row['plr']);
        $this->assis_medica->setDbValue($row['assis_medica']);
        $this->assis_odonto->setDbValue($row['assis_odonto']);
        $this->modulo_idmodulo->setDbValue($row['modulo_idmodulo']);
        $this->salario_antes->setDbValue($row['salario_antes']);
        $this->vt_dia_antes->setDbValue($row['vt_dia_antes']);
        $this->vr_dia_antes->setDbValue($row['vr_dia_antes']);
        $this->va_mes_antes->setDbValue($row['va_mes_antes']);
        $this->benef_social_antes->setDbValue($row['benef_social_antes']);
        $this->plr_antes->setDbValue($row['plr_antes']);
        $this->assis_medica_antes->setDbValue($row['assis_medica_antes']);
        $this->assis_odonto_antes->setDbValue($row['assis_odonto_antes']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idcargo'] = $this->idcargo->DefaultValue;
        $row['cargo'] = $this->cargo->DefaultValue;
        $row['abreviado'] = $this->abreviado->DefaultValue;
        $row['funcao_idfuncao'] = $this->funcao_idfuncao->DefaultValue;
        $row['salario'] = $this->salario->DefaultValue;
        $row['tipo_uniforme_idtipo_uniforme'] = $this->tipo_uniforme_idtipo_uniforme->DefaultValue;
        $row['escala_idescala'] = $this->escala_idescala->DefaultValue;
        $row['periodo_idperiodo'] = $this->periodo_idperiodo->DefaultValue;
        $row['jornada'] = $this->jornada->DefaultValue;
        $row['nr_horas_mes'] = $this->nr_horas_mes->DefaultValue;
        $row['nr_horas_ad_noite'] = $this->nr_horas_ad_noite->DefaultValue;
        $row['intrajornada'] = $this->intrajornada->DefaultValue;
        $row['vt_dia'] = $this->vt_dia->DefaultValue;
        $row['vr_dia'] = $this->vr_dia->DefaultValue;
        $row['va_mes'] = $this->va_mes->DefaultValue;
        $row['benef_social'] = $this->benef_social->DefaultValue;
        $row['plr'] = $this->plr->DefaultValue;
        $row['assis_medica'] = $this->assis_medica->DefaultValue;
        $row['assis_odonto'] = $this->assis_odonto->DefaultValue;
        $row['modulo_idmodulo'] = $this->modulo_idmodulo->DefaultValue;
        $row['salario_antes'] = $this->salario_antes->DefaultValue;
        $row['vt_dia_antes'] = $this->vt_dia_antes->DefaultValue;
        $row['vr_dia_antes'] = $this->vr_dia_antes->DefaultValue;
        $row['va_mes_antes'] = $this->va_mes_antes->DefaultValue;
        $row['benef_social_antes'] = $this->benef_social_antes->DefaultValue;
        $row['plr_antes'] = $this->plr_antes->DefaultValue;
        $row['assis_medica_antes'] = $this->assis_medica_antes->DefaultValue;
        $row['assis_odonto_antes'] = $this->assis_odonto_antes->DefaultValue;
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

        // abreviado

        // funcao_idfuncao

        // salario

        // tipo_uniforme_idtipo_uniforme

        // escala_idescala

        // periodo_idperiodo

        // jornada

        // nr_horas_mes

        // nr_horas_ad_noite

        // intrajornada

        // vt_dia

        // vr_dia

        // va_mes

        // benef_social

        // plr

        // assis_medica

        // assis_odonto

        // modulo_idmodulo

        // salario_antes

        // vt_dia_antes

        // vr_dia_antes

        // va_mes_antes

        // benef_social_antes

        // plr_antes

        // assis_medica_antes

        // assis_odonto_antes

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

            // abreviado
            $this->abreviado->ViewValue = $this->abreviado->CurrentValue;
            $this->abreviado->CssClass = "fw-bold";

            // funcao_idfuncao
            $curVal = strval($this->funcao_idfuncao->CurrentValue);
            if ($curVal != "") {
                $this->funcao_idfuncao->ViewValue = $this->funcao_idfuncao->lookupCacheOption($curVal);
                if ($this->funcao_idfuncao->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->funcao_idfuncao->Lookup->getTable()->Fields["idfuncao"]->searchExpression(), "=", $curVal, $this->funcao_idfuncao->Lookup->getTable()->Fields["idfuncao"]->searchDataType(), "");
                    $lookupFilter = $this->funcao_idfuncao->getSelectFilter($this); // PHP
                    $sqlWrk = $this->funcao_idfuncao->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->funcao_idfuncao->Lookup->renderViewRow($rswrk[0]);
                        $this->funcao_idfuncao->ViewValue = $this->funcao_idfuncao->displayValue($arwrk);
                    } else {
                        $this->funcao_idfuncao->ViewValue = FormatNumber($this->funcao_idfuncao->CurrentValue, $this->funcao_idfuncao->formatPattern());
                    }
                }
            } else {
                $this->funcao_idfuncao->ViewValue = null;
            }
            $this->funcao_idfuncao->CssClass = "fw-bold";

            // salario
            $this->salario->ViewValue = $this->salario->CurrentValue;
            $this->salario->ViewValue = FormatCurrency($this->salario->ViewValue, $this->salario->formatPattern());
            $this->salario->CssClass = "fw-bold";
            $this->salario->CellCssStyle .= "text-align: right;";

            // tipo_uniforme_idtipo_uniforme
            $curVal = strval($this->tipo_uniforme_idtipo_uniforme->CurrentValue);
            if ($curVal != "") {
                $this->tipo_uniforme_idtipo_uniforme->ViewValue = $this->tipo_uniforme_idtipo_uniforme->lookupCacheOption($curVal);
                if ($this->tipo_uniforme_idtipo_uniforme->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_uniforme_idtipo_uniforme->Lookup->getTable()->Fields["idtipo_uniforme"]->searchExpression(), "=", $curVal, $this->tipo_uniforme_idtipo_uniforme->Lookup->getTable()->Fields["idtipo_uniforme"]->searchDataType(), "");
                    $sqlWrk = $this->tipo_uniforme_idtipo_uniforme->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_uniforme_idtipo_uniforme->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_uniforme_idtipo_uniforme->ViewValue = $this->tipo_uniforme_idtipo_uniforme->displayValue($arwrk);
                    } else {
                        $this->tipo_uniforme_idtipo_uniforme->ViewValue = FormatNumber($this->tipo_uniforme_idtipo_uniforme->CurrentValue, $this->tipo_uniforme_idtipo_uniforme->formatPattern());
                    }
                }
            } else {
                $this->tipo_uniforme_idtipo_uniforme->ViewValue = null;
            }
            $this->tipo_uniforme_idtipo_uniforme->CssClass = "fw-bold";

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
            $this->escala_idescala->CellCssStyle .= "text-align: center;";

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
            $this->periodo_idperiodo->CellCssStyle .= "text-align: center;";

            // jornada
            $this->jornada->ViewValue = $this->jornada->CurrentValue;
            $this->jornada->ViewValue = FormatNumber($this->jornada->ViewValue, $this->jornada->formatPattern());
            $this->jornada->CssClass = "fw-bold";
            $this->jornada->CellCssStyle .= "text-align: center;";

            // nr_horas_mes
            $this->nr_horas_mes->ViewValue = $this->nr_horas_mes->CurrentValue;
            $this->nr_horas_mes->ViewValue = FormatNumber($this->nr_horas_mes->ViewValue, $this->nr_horas_mes->formatPattern());
            $this->nr_horas_mes->CssClass = "fw-bold";
            $this->nr_horas_mes->CellCssStyle .= "text-align: center;";

            // nr_horas_ad_noite
            $this->nr_horas_ad_noite->ViewValue = $this->nr_horas_ad_noite->CurrentValue;
            $this->nr_horas_ad_noite->ViewValue = FormatNumber($this->nr_horas_ad_noite->ViewValue, $this->nr_horas_ad_noite->formatPattern());
            $this->nr_horas_ad_noite->CssClass = "fw-bold";
            $this->nr_horas_ad_noite->CellCssStyle .= "text-align: center;";

            // intrajornada
            if (strval($this->intrajornada->CurrentValue) != "") {
                $this->intrajornada->ViewValue = $this->intrajornada->optionCaption($this->intrajornada->CurrentValue);
            } else {
                $this->intrajornada->ViewValue = null;
            }
            $this->intrajornada->CssClass = "fw-bold";
            $this->intrajornada->CellCssStyle .= "text-align: center;";

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

            // plr
            $this->plr->ViewValue = $this->plr->CurrentValue;
            $this->plr->ViewValue = FormatCurrency($this->plr->ViewValue, $this->plr->formatPattern());
            $this->plr->CssClass = "fw-bold";
            $this->plr->CellCssStyle .= "text-align: right;";

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

            // salario_antes
            $this->salario_antes->ViewValue = $this->salario_antes->CurrentValue;
            $this->salario_antes->ViewValue = FormatNumber($this->salario_antes->ViewValue, $this->salario_antes->formatPattern());

            // vt_dia_antes
            $this->vt_dia_antes->ViewValue = $this->vt_dia_antes->CurrentValue;
            $this->vt_dia_antes->ViewValue = FormatNumber($this->vt_dia_antes->ViewValue, $this->vt_dia_antes->formatPattern());

            // vr_dia_antes
            $this->vr_dia_antes->ViewValue = $this->vr_dia_antes->CurrentValue;
            $this->vr_dia_antes->ViewValue = FormatNumber($this->vr_dia_antes->ViewValue, $this->vr_dia_antes->formatPattern());

            // va_mes_antes
            $this->va_mes_antes->ViewValue = $this->va_mes_antes->CurrentValue;
            $this->va_mes_antes->ViewValue = FormatNumber($this->va_mes_antes->ViewValue, $this->va_mes_antes->formatPattern());

            // benef_social_antes
            $this->benef_social_antes->ViewValue = $this->benef_social_antes->CurrentValue;
            $this->benef_social_antes->ViewValue = FormatNumber($this->benef_social_antes->ViewValue, $this->benef_social_antes->formatPattern());

            // plr_antes
            $this->plr_antes->ViewValue = $this->plr_antes->CurrentValue;
            $this->plr_antes->ViewValue = FormatNumber($this->plr_antes->ViewValue, $this->plr_antes->formatPattern());

            // assis_medica_antes
            $this->assis_medica_antes->ViewValue = $this->assis_medica_antes->CurrentValue;
            $this->assis_medica_antes->ViewValue = FormatNumber($this->assis_medica_antes->ViewValue, $this->assis_medica_antes->formatPattern());

            // assis_odonto_antes
            $this->assis_odonto_antes->ViewValue = $this->assis_odonto_antes->CurrentValue;
            $this->assis_odonto_antes->ViewValue = FormatNumber($this->assis_odonto_antes->ViewValue, $this->assis_odonto_antes->formatPattern());

            // cargo
            $this->cargo->HrefValue = "";
            $this->cargo->TooltipValue = "";

            // abreviado
            $this->abreviado->HrefValue = "";
            $this->abreviado->TooltipValue = "";

            // salario
            $this->salario->HrefValue = "";
            $this->salario->TooltipValue = "";

            // escala_idescala
            $this->escala_idescala->HrefValue = "";
            $this->escala_idescala->TooltipValue = "";

            // periodo_idperiodo
            $this->periodo_idperiodo->HrefValue = "";
            $this->periodo_idperiodo->TooltipValue = "";

            // jornada
            $this->jornada->HrefValue = "";
            $this->jornada->TooltipValue = "";

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

            // plr
            $this->plr->HrefValue = "";
            $this->plr->TooltipValue = "";

            // assis_medica
            $this->assis_medica->HrefValue = "";
            $this->assis_medica->TooltipValue = "";

            // assis_odonto
            $this->assis_odonto->HrefValue = "";
            $this->assis_odonto->TooltipValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // cargo
            $this->cargo->setupEditAttributes();
            if (!$this->cargo->Raw) {
                $this->cargo->CurrentValue = HtmlDecode($this->cargo->CurrentValue);
            }
            $this->cargo->EditValue = HtmlEncode($this->cargo->CurrentValue);
            $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

            // abreviado
            $this->abreviado->setupEditAttributes();
            if (!$this->abreviado->Raw) {
                $this->abreviado->CurrentValue = HtmlDecode($this->abreviado->CurrentValue);
            }
            $this->abreviado->EditValue = HtmlEncode($this->abreviado->CurrentValue);
            $this->abreviado->PlaceHolder = RemoveHtml($this->abreviado->caption());

            // salario
            $this->salario->setupEditAttributes();
            $this->salario->EditValue = $this->salario->CurrentValue;
            $this->salario->PlaceHolder = RemoveHtml($this->salario->caption());
            if (strval($this->salario->EditValue) != "" && is_numeric($this->salario->EditValue)) {
                $this->salario->EditValue = FormatNumber($this->salario->EditValue, null);
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

            // jornada
            $this->jornada->setupEditAttributes();
            $this->jornada->EditValue = $this->jornada->CurrentValue;
            $this->jornada->PlaceHolder = RemoveHtml($this->jornada->caption());
            if (strval($this->jornada->EditValue) != "" && is_numeric($this->jornada->EditValue)) {
                $this->jornada->EditValue = FormatNumber($this->jornada->EditValue, null);
            }

            // vt_dia
            $this->vt_dia->setupEditAttributes();
            $this->vt_dia->EditValue = $this->vt_dia->CurrentValue;
            $this->vt_dia->PlaceHolder = RemoveHtml($this->vt_dia->caption());
            if (strval($this->vt_dia->EditValue) != "" && is_numeric($this->vt_dia->EditValue)) {
                $this->vt_dia->EditValue = FormatNumber($this->vt_dia->EditValue, null);
            }

            // vr_dia
            $this->vr_dia->setupEditAttributes();
            $this->vr_dia->EditValue = $this->vr_dia->CurrentValue;
            $this->vr_dia->PlaceHolder = RemoveHtml($this->vr_dia->caption());
            if (strval($this->vr_dia->EditValue) != "" && is_numeric($this->vr_dia->EditValue)) {
                $this->vr_dia->EditValue = FormatNumber($this->vr_dia->EditValue, null);
            }

            // va_mes
            $this->va_mes->setupEditAttributes();
            $this->va_mes->EditValue = $this->va_mes->CurrentValue;
            $this->va_mes->PlaceHolder = RemoveHtml($this->va_mes->caption());
            if (strval($this->va_mes->EditValue) != "" && is_numeric($this->va_mes->EditValue)) {
                $this->va_mes->EditValue = FormatNumber($this->va_mes->EditValue, null);
            }

            // benef_social
            $this->benef_social->setupEditAttributes();
            $this->benef_social->EditValue = $this->benef_social->CurrentValue;
            $this->benef_social->PlaceHolder = RemoveHtml($this->benef_social->caption());
            if (strval($this->benef_social->EditValue) != "" && is_numeric($this->benef_social->EditValue)) {
                $this->benef_social->EditValue = FormatNumber($this->benef_social->EditValue, null);
            }

            // plr
            $this->plr->setupEditAttributes();
            $this->plr->EditValue = $this->plr->CurrentValue;
            $this->plr->PlaceHolder = RemoveHtml($this->plr->caption());
            if (strval($this->plr->EditValue) != "" && is_numeric($this->plr->EditValue)) {
                $this->plr->EditValue = FormatNumber($this->plr->EditValue, null);
            }

            // assis_medica
            $this->assis_medica->setupEditAttributes();
            $this->assis_medica->EditValue = $this->assis_medica->CurrentValue;
            $this->assis_medica->PlaceHolder = RemoveHtml($this->assis_medica->caption());
            if (strval($this->assis_medica->EditValue) != "" && is_numeric($this->assis_medica->EditValue)) {
                $this->assis_medica->EditValue = FormatNumber($this->assis_medica->EditValue, null);
            }

            // assis_odonto
            $this->assis_odonto->setupEditAttributes();
            $this->assis_odonto->EditValue = $this->assis_odonto->CurrentValue;
            $this->assis_odonto->PlaceHolder = RemoveHtml($this->assis_odonto->caption());
            if (strval($this->assis_odonto->EditValue) != "" && is_numeric($this->assis_odonto->EditValue)) {
                $this->assis_odonto->EditValue = FormatNumber($this->assis_odonto->EditValue, null);
            }

            // Add refer script

            // cargo
            $this->cargo->HrefValue = "";

            // abreviado
            $this->abreviado->HrefValue = "";

            // salario
            $this->salario->HrefValue = "";

            // escala_idescala
            $this->escala_idescala->HrefValue = "";

            // periodo_idperiodo
            $this->periodo_idperiodo->HrefValue = "";

            // jornada
            $this->jornada->HrefValue = "";

            // vt_dia
            $this->vt_dia->HrefValue = "";

            // vr_dia
            $this->vr_dia->HrefValue = "";

            // va_mes
            $this->va_mes->HrefValue = "";

            // benef_social
            $this->benef_social->HrefValue = "";

            // plr
            $this->plr->HrefValue = "";

            // assis_medica
            $this->assis_medica->HrefValue = "";

            // assis_odonto
            $this->assis_odonto->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // cargo
            $this->cargo->setupEditAttributes();
            if (!$this->cargo->Raw) {
                $this->cargo->CurrentValue = HtmlDecode($this->cargo->CurrentValue);
            }
            $this->cargo->EditValue = HtmlEncode($this->cargo->CurrentValue);
            $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

            // abreviado
            $this->abreviado->setupEditAttributes();
            if (!$this->abreviado->Raw) {
                $this->abreviado->CurrentValue = HtmlDecode($this->abreviado->CurrentValue);
            }
            $this->abreviado->EditValue = HtmlEncode($this->abreviado->CurrentValue);
            $this->abreviado->PlaceHolder = RemoveHtml($this->abreviado->caption());

            // salario
            $this->salario->setupEditAttributes();
            $this->salario->EditValue = $this->salario->CurrentValue;
            $this->salario->PlaceHolder = RemoveHtml($this->salario->caption());
            if (strval($this->salario->EditValue) != "" && is_numeric($this->salario->EditValue)) {
                $this->salario->EditValue = FormatNumber($this->salario->EditValue, null);
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

            // jornada
            $this->jornada->setupEditAttributes();
            $this->jornada->EditValue = $this->jornada->CurrentValue;
            $this->jornada->PlaceHolder = RemoveHtml($this->jornada->caption());
            if (strval($this->jornada->EditValue) != "" && is_numeric($this->jornada->EditValue)) {
                $this->jornada->EditValue = FormatNumber($this->jornada->EditValue, null);
            }

            // vt_dia
            $this->vt_dia->setupEditAttributes();
            $this->vt_dia->EditValue = $this->vt_dia->CurrentValue;
            $this->vt_dia->PlaceHolder = RemoveHtml($this->vt_dia->caption());
            if (strval($this->vt_dia->EditValue) != "" && is_numeric($this->vt_dia->EditValue)) {
                $this->vt_dia->EditValue = FormatNumber($this->vt_dia->EditValue, null);
            }

            // vr_dia
            $this->vr_dia->setupEditAttributes();
            $this->vr_dia->EditValue = $this->vr_dia->CurrentValue;
            $this->vr_dia->PlaceHolder = RemoveHtml($this->vr_dia->caption());
            if (strval($this->vr_dia->EditValue) != "" && is_numeric($this->vr_dia->EditValue)) {
                $this->vr_dia->EditValue = FormatNumber($this->vr_dia->EditValue, null);
            }

            // va_mes
            $this->va_mes->setupEditAttributes();
            $this->va_mes->EditValue = $this->va_mes->CurrentValue;
            $this->va_mes->PlaceHolder = RemoveHtml($this->va_mes->caption());
            if (strval($this->va_mes->EditValue) != "" && is_numeric($this->va_mes->EditValue)) {
                $this->va_mes->EditValue = FormatNumber($this->va_mes->EditValue, null);
            }

            // benef_social
            $this->benef_social->setupEditAttributes();
            $this->benef_social->EditValue = $this->benef_social->CurrentValue;
            $this->benef_social->PlaceHolder = RemoveHtml($this->benef_social->caption());
            if (strval($this->benef_social->EditValue) != "" && is_numeric($this->benef_social->EditValue)) {
                $this->benef_social->EditValue = FormatNumber($this->benef_social->EditValue, null);
            }

            // plr
            $this->plr->setupEditAttributes();
            $this->plr->EditValue = $this->plr->CurrentValue;
            $this->plr->PlaceHolder = RemoveHtml($this->plr->caption());
            if (strval($this->plr->EditValue) != "" && is_numeric($this->plr->EditValue)) {
                $this->plr->EditValue = FormatNumber($this->plr->EditValue, null);
            }

            // assis_medica
            $this->assis_medica->setupEditAttributes();
            $this->assis_medica->EditValue = $this->assis_medica->CurrentValue;
            $this->assis_medica->PlaceHolder = RemoveHtml($this->assis_medica->caption());
            if (strval($this->assis_medica->EditValue) != "" && is_numeric($this->assis_medica->EditValue)) {
                $this->assis_medica->EditValue = FormatNumber($this->assis_medica->EditValue, null);
            }

            // assis_odonto
            $this->assis_odonto->setupEditAttributes();
            $this->assis_odonto->EditValue = $this->assis_odonto->CurrentValue;
            $this->assis_odonto->PlaceHolder = RemoveHtml($this->assis_odonto->caption());
            if (strval($this->assis_odonto->EditValue) != "" && is_numeric($this->assis_odonto->EditValue)) {
                $this->assis_odonto->EditValue = FormatNumber($this->assis_odonto->EditValue, null);
            }

            // Edit refer script

            // cargo
            $this->cargo->HrefValue = "";

            // abreviado
            $this->abreviado->HrefValue = "";

            // salario
            $this->salario->HrefValue = "";

            // escala_idescala
            $this->escala_idescala->HrefValue = "";

            // periodo_idperiodo
            $this->periodo_idperiodo->HrefValue = "";

            // jornada
            $this->jornada->HrefValue = "";

            // vt_dia
            $this->vt_dia->HrefValue = "";

            // vr_dia
            $this->vr_dia->HrefValue = "";

            // va_mes
            $this->va_mes->HrefValue = "";

            // benef_social
            $this->benef_social->HrefValue = "";

            // plr
            $this->plr->HrefValue = "";

            // assis_medica
            $this->assis_medica->HrefValue = "";

            // assis_odonto
            $this->assis_odonto->HrefValue = "";
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

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
            if ($this->cargo->Visible && $this->cargo->Required) {
                if (!$this->cargo->IsDetailKey && EmptyValue($this->cargo->FormValue)) {
                    $this->cargo->addErrorMessage(str_replace("%s", $this->cargo->caption(), $this->cargo->RequiredErrorMessage));
                }
            }
            if ($this->abreviado->Visible && $this->abreviado->Required) {
                if (!$this->abreviado->IsDetailKey && EmptyValue($this->abreviado->FormValue)) {
                    $this->abreviado->addErrorMessage(str_replace("%s", $this->abreviado->caption(), $this->abreviado->RequiredErrorMessage));
                }
            }
            if ($this->salario->Visible && $this->salario->Required) {
                if (!$this->salario->IsDetailKey && EmptyValue($this->salario->FormValue)) {
                    $this->salario->addErrorMessage(str_replace("%s", $this->salario->caption(), $this->salario->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->salario->FormValue)) {
                $this->salario->addErrorMessage($this->salario->getErrorMessage(false));
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
            if ($this->jornada->Visible && $this->jornada->Required) {
                if (!$this->jornada->IsDetailKey && EmptyValue($this->jornada->FormValue)) {
                    $this->jornada->addErrorMessage(str_replace("%s", $this->jornada->caption(), $this->jornada->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->jornada->FormValue)) {
                $this->jornada->addErrorMessage($this->jornada->getErrorMessage(false));
            }
            if ($this->vt_dia->Visible && $this->vt_dia->Required) {
                if (!$this->vt_dia->IsDetailKey && EmptyValue($this->vt_dia->FormValue)) {
                    $this->vt_dia->addErrorMessage(str_replace("%s", $this->vt_dia->caption(), $this->vt_dia->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->vt_dia->FormValue)) {
                $this->vt_dia->addErrorMessage($this->vt_dia->getErrorMessage(false));
            }
            if ($this->vr_dia->Visible && $this->vr_dia->Required) {
                if (!$this->vr_dia->IsDetailKey && EmptyValue($this->vr_dia->FormValue)) {
                    $this->vr_dia->addErrorMessage(str_replace("%s", $this->vr_dia->caption(), $this->vr_dia->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->vr_dia->FormValue)) {
                $this->vr_dia->addErrorMessage($this->vr_dia->getErrorMessage(false));
            }
            if ($this->va_mes->Visible && $this->va_mes->Required) {
                if (!$this->va_mes->IsDetailKey && EmptyValue($this->va_mes->FormValue)) {
                    $this->va_mes->addErrorMessage(str_replace("%s", $this->va_mes->caption(), $this->va_mes->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->va_mes->FormValue)) {
                $this->va_mes->addErrorMessage($this->va_mes->getErrorMessage(false));
            }
            if ($this->benef_social->Visible && $this->benef_social->Required) {
                if (!$this->benef_social->IsDetailKey && EmptyValue($this->benef_social->FormValue)) {
                    $this->benef_social->addErrorMessage(str_replace("%s", $this->benef_social->caption(), $this->benef_social->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->benef_social->FormValue)) {
                $this->benef_social->addErrorMessage($this->benef_social->getErrorMessage(false));
            }
            if ($this->plr->Visible && $this->plr->Required) {
                if (!$this->plr->IsDetailKey && EmptyValue($this->plr->FormValue)) {
                    $this->plr->addErrorMessage(str_replace("%s", $this->plr->caption(), $this->plr->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->plr->FormValue)) {
                $this->plr->addErrorMessage($this->plr->getErrorMessage(false));
            }
            if ($this->assis_medica->Visible && $this->assis_medica->Required) {
                if (!$this->assis_medica->IsDetailKey && EmptyValue($this->assis_medica->FormValue)) {
                    $this->assis_medica->addErrorMessage(str_replace("%s", $this->assis_medica->caption(), $this->assis_medica->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->assis_medica->FormValue)) {
                $this->assis_medica->addErrorMessage($this->assis_medica->getErrorMessage(false));
            }
            if ($this->assis_odonto->Visible && $this->assis_odonto->Required) {
                if (!$this->assis_odonto->IsDetailKey && EmptyValue($this->assis_odonto->FormValue)) {
                    $this->assis_odonto->addErrorMessage(str_replace("%s", $this->assis_odonto->caption(), $this->assis_odonto->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->assis_odonto->FormValue)) {
                $this->assis_odonto->addErrorMessage($this->assis_odonto->getErrorMessage(false));
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
            $thisKey .= $row['idcargo'];

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

        // Check field with unique index (abreviado)
        if ($this->abreviado->CurrentValue != "") {
            $filterChk = "(`abreviado` = '" . AdjustSql($this->abreviado->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->abreviado->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->abreviado->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
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

        // cargo
        $this->cargo->setDbValueDef($rsnew, $this->cargo->CurrentValue, $this->cargo->ReadOnly);

        // abreviado
        $this->abreviado->setDbValueDef($rsnew, $this->abreviado->CurrentValue, $this->abreviado->ReadOnly);

        // salario
        $this->salario->setDbValueDef($rsnew, $this->salario->CurrentValue, $this->salario->ReadOnly);

        // escala_idescala
        $this->escala_idescala->setDbValueDef($rsnew, $this->escala_idescala->CurrentValue, $this->escala_idescala->ReadOnly);

        // periodo_idperiodo
        $this->periodo_idperiodo->setDbValueDef($rsnew, $this->periodo_idperiodo->CurrentValue, $this->periodo_idperiodo->ReadOnly);

        // jornada
        $this->jornada->setDbValueDef($rsnew, $this->jornada->CurrentValue, $this->jornada->ReadOnly);

        // vt_dia
        $this->vt_dia->setDbValueDef($rsnew, $this->vt_dia->CurrentValue, $this->vt_dia->ReadOnly);

        // vr_dia
        $this->vr_dia->setDbValueDef($rsnew, $this->vr_dia->CurrentValue, $this->vr_dia->ReadOnly);

        // va_mes
        $this->va_mes->setDbValueDef($rsnew, $this->va_mes->CurrentValue, $this->va_mes->ReadOnly);

        // benef_social
        $this->benef_social->setDbValueDef($rsnew, $this->benef_social->CurrentValue, $this->benef_social->ReadOnly);

        // plr
        $this->plr->setDbValueDef($rsnew, $this->plr->CurrentValue, $this->plr->ReadOnly);

        // assis_medica
        $this->assis_medica->setDbValueDef($rsnew, $this->assis_medica->CurrentValue, $this->assis_medica->ReadOnly);

        // assis_odonto
        $this->assis_odonto->setDbValueDef($rsnew, $this->assis_odonto->CurrentValue, $this->assis_odonto->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['cargo'])) { // cargo
            $this->cargo->CurrentValue = $row['cargo'];
        }
        if (isset($row['abreviado'])) { // abreviado
            $this->abreviado->CurrentValue = $row['abreviado'];
        }
        if (isset($row['salario'])) { // salario
            $this->salario->CurrentValue = $row['salario'];
        }
        if (isset($row['escala_idescala'])) { // escala_idescala
            $this->escala_idescala->CurrentValue = $row['escala_idescala'];
        }
        if (isset($row['periodo_idperiodo'])) { // periodo_idperiodo
            $this->periodo_idperiodo->CurrentValue = $row['periodo_idperiodo'];
        }
        if (isset($row['jornada'])) { // jornada
            $this->jornada->CurrentValue = $row['jornada'];
        }
        if (isset($row['vt_dia'])) { // vt_dia
            $this->vt_dia->CurrentValue = $row['vt_dia'];
        }
        if (isset($row['vr_dia'])) { // vr_dia
            $this->vr_dia->CurrentValue = $row['vr_dia'];
        }
        if (isset($row['va_mes'])) { // va_mes
            $this->va_mes->CurrentValue = $row['va_mes'];
        }
        if (isset($row['benef_social'])) { // benef_social
            $this->benef_social->CurrentValue = $row['benef_social'];
        }
        if (isset($row['plr'])) { // plr
            $this->plr->CurrentValue = $row['plr'];
        }
        if (isset($row['assis_medica'])) { // assis_medica
            $this->assis_medica->CurrentValue = $row['assis_medica'];
        }
        if (isset($row['assis_odonto'])) { // assis_odonto
            $this->assis_odonto->CurrentValue = $row['assis_odonto'];
        }
    }

    // Load row hash
    protected function loadRowHash()
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssociative($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : ""; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash($row)
    {
        if (!$row) {
            return "";
        }
        $hash = "";
        $hash .= GetFieldHash($row['cargo']); // cargo
        $hash .= GetFieldHash($row['abreviado']); // abreviado
        $hash .= GetFieldHash($row['salario']); // salario
        $hash .= GetFieldHash($row['escala_idescala']); // escala_idescala
        $hash .= GetFieldHash($row['periodo_idperiodo']); // periodo_idperiodo
        $hash .= GetFieldHash($row['jornada']); // jornada
        $hash .= GetFieldHash($row['vt_dia']); // vt_dia
        $hash .= GetFieldHash($row['vr_dia']); // vr_dia
        $hash .= GetFieldHash($row['va_mes']); // va_mes
        $hash .= GetFieldHash($row['benef_social']); // benef_social
        $hash .= GetFieldHash($row['plr']); // plr
        $hash .= GetFieldHash($row['assis_medica']); // assis_medica
        $hash .= GetFieldHash($row['assis_odonto']); // assis_odonto
        return md5($hash);
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
        if ($this->abreviado->CurrentValue != "") { // Check field with unique index
            $filter = "(`abreviado` = '" . AdjustSql($this->abreviado->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->abreviado->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->abreviado->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
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

        // cargo
        $this->cargo->setDbValueDef($rsnew, $this->cargo->CurrentValue, false);

        // abreviado
        $this->abreviado->setDbValueDef($rsnew, $this->abreviado->CurrentValue, false);

        // salario
        $this->salario->setDbValueDef($rsnew, $this->salario->CurrentValue, false);

        // escala_idescala
        $this->escala_idescala->setDbValueDef($rsnew, $this->escala_idescala->CurrentValue, false);

        // periodo_idperiodo
        $this->periodo_idperiodo->setDbValueDef($rsnew, $this->periodo_idperiodo->CurrentValue, false);

        // jornada
        $this->jornada->setDbValueDef($rsnew, $this->jornada->CurrentValue, strval($this->jornada->CurrentValue) == "");

        // vt_dia
        $this->vt_dia->setDbValueDef($rsnew, $this->vt_dia->CurrentValue, strval($this->vt_dia->CurrentValue) == "");

        // vr_dia
        $this->vr_dia->setDbValueDef($rsnew, $this->vr_dia->CurrentValue, strval($this->vr_dia->CurrentValue) == "");

        // va_mes
        $this->va_mes->setDbValueDef($rsnew, $this->va_mes->CurrentValue, strval($this->va_mes->CurrentValue) == "");

        // benef_social
        $this->benef_social->setDbValueDef($rsnew, $this->benef_social->CurrentValue, strval($this->benef_social->CurrentValue) == "");

        // plr
        $this->plr->setDbValueDef($rsnew, $this->plr->CurrentValue, strval($this->plr->CurrentValue) == "");

        // assis_medica
        $this->assis_medica->setDbValueDef($rsnew, $this->assis_medica->CurrentValue, strval($this->assis_medica->CurrentValue) == "");

        // assis_odonto
        $this->assis_odonto->setDbValueDef($rsnew, $this->assis_odonto->CurrentValue, strval($this->assis_odonto->CurrentValue) == "");
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['cargo'])) { // cargo
            $this->cargo->setFormValue($row['cargo']);
        }
        if (isset($row['abreviado'])) { // abreviado
            $this->abreviado->setFormValue($row['abreviado']);
        }
        if (isset($row['salario'])) { // salario
            $this->salario->setFormValue($row['salario']);
        }
        if (isset($row['escala_idescala'])) { // escala_idescala
            $this->escala_idescala->setFormValue($row['escala_idescala']);
        }
        if (isset($row['periodo_idperiodo'])) { // periodo_idperiodo
            $this->periodo_idperiodo->setFormValue($row['periodo_idperiodo']);
        }
        if (isset($row['jornada'])) { // jornada
            $this->jornada->setFormValue($row['jornada']);
        }
        if (isset($row['vt_dia'])) { // vt_dia
            $this->vt_dia->setFormValue($row['vt_dia']);
        }
        if (isset($row['vr_dia'])) { // vr_dia
            $this->vr_dia->setFormValue($row['vr_dia']);
        }
        if (isset($row['va_mes'])) { // va_mes
            $this->va_mes->setFormValue($row['va_mes']);
        }
        if (isset($row['benef_social'])) { // benef_social
            $this->benef_social->setFormValue($row['benef_social']);
        }
        if (isset($row['plr'])) { // plr
            $this->plr->setFormValue($row['plr']);
        }
        if (isset($row['assis_medica'])) { // assis_medica
            $this->assis_medica->setFormValue($row['assis_medica']);
        }
        if (isset($row['assis_odonto'])) { // assis_odonto
            $this->assis_odonto->setFormValue($row['assis_odonto']);
        }
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
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fcargolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fcargolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fcargolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fcargolist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fcargosrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_funcao_idfuncao":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_tipo_uniforme_idtipo_uniforme":
                    break;
                case "x_escala_idescala":
                    break;
                case "x_periodo_idperiodo":
                    break;
                case "x_intrajornada":
                    break;
                case "x_modulo_idmodulo":
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
