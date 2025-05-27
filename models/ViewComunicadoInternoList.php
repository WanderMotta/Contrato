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
class ViewComunicadoInternoList extends ViewComunicadoInterno
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ViewComunicadoInternoList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fview_comunicado_internolist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ViewComunicadoInternoList";

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
        $this->dt_proposta->setVisibility();
        $this->consultor->setVisibility();
        $this->cliente->setVisibility();
        $this->cnpj_cli->setVisibility();
        $this->end_cli->setVisibility();
        $this->nr_cli->setVisibility();
        $this->bairro_cli->setVisibility();
        $this->cep_cli->setVisibility();
        $this->cidade_cli->setVisibility();
        $this->uf_cli->setVisibility();
        $this->contato_cli->setVisibility();
        $this->email_cli->setVisibility();
        $this->tel_cli->setVisibility();
        $this->faturamento->setVisibility();
        $this->cnpj_fat->setVisibility();
        $this->end_fat->setVisibility();
        $this->bairro_fat->setVisibility();
        $this->cidae_fat->setVisibility();
        $this->uf_fat->setVisibility();
        $this->origem_fat->setVisibility();
        $this->dia_vencto_fat->setVisibility();
        $this->quantidade->setVisibility();
        $this->cargo->setVisibility();
        $this->escala->setVisibility();
        $this->periodo->setVisibility();
        $this->intrajornada_tipo->setVisibility();
        $this->acumulo_funcao->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'view_comunicado_interno';
        $this->TableName = 'view_comunicado_interno';

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

        // Table object (view_comunicado_interno)
        if (!isset($GLOBALS["view_comunicado_interno"]) || $GLOBALS["view_comunicado_interno"]::class == PROJECT_NAMESPACE . "view_comunicado_interno") {
            $GLOBALS["view_comunicado_interno"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ViewComunicadoInternoAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ViewComunicadoInternoDelete";
        $this->MultiUpdateUrl = "ViewComunicadoInternoUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'view_comunicado_interno');
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
                    $result["view"] = SameString($pageName, "ViewComunicadoInternoView"); // If View page, no primary button
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

        // Set up lookup cache
        $this->setupLookupOptions($this->origem_fat);
        $this->setupLookupOptions($this->acumulo_funcao);

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fview_comunicado_internogrid";
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
        $filterList = Concat($filterList, $this->dt_proposta->AdvancedSearch->toJson(), ","); // Field dt_proposta
        $filterList = Concat($filterList, $this->consultor->AdvancedSearch->toJson(), ","); // Field consultor
        $filterList = Concat($filterList, $this->cliente->AdvancedSearch->toJson(), ","); // Field cliente
        $filterList = Concat($filterList, $this->cnpj_cli->AdvancedSearch->toJson(), ","); // Field cnpj_cli
        $filterList = Concat($filterList, $this->end_cli->AdvancedSearch->toJson(), ","); // Field end_cli
        $filterList = Concat($filterList, $this->nr_cli->AdvancedSearch->toJson(), ","); // Field nr_cli
        $filterList = Concat($filterList, $this->bairro_cli->AdvancedSearch->toJson(), ","); // Field bairro_cli
        $filterList = Concat($filterList, $this->cep_cli->AdvancedSearch->toJson(), ","); // Field cep_cli
        $filterList = Concat($filterList, $this->cidade_cli->AdvancedSearch->toJson(), ","); // Field cidade_cli
        $filterList = Concat($filterList, $this->uf_cli->AdvancedSearch->toJson(), ","); // Field uf_cli
        $filterList = Concat($filterList, $this->contato_cli->AdvancedSearch->toJson(), ","); // Field contato_cli
        $filterList = Concat($filterList, $this->email_cli->AdvancedSearch->toJson(), ","); // Field email_cli
        $filterList = Concat($filterList, $this->tel_cli->AdvancedSearch->toJson(), ","); // Field tel_cli
        $filterList = Concat($filterList, $this->faturamento->AdvancedSearch->toJson(), ","); // Field faturamento
        $filterList = Concat($filterList, $this->cnpj_fat->AdvancedSearch->toJson(), ","); // Field cnpj_fat
        $filterList = Concat($filterList, $this->end_fat->AdvancedSearch->toJson(), ","); // Field end_fat
        $filterList = Concat($filterList, $this->bairro_fat->AdvancedSearch->toJson(), ","); // Field bairro_fat
        $filterList = Concat($filterList, $this->cidae_fat->AdvancedSearch->toJson(), ","); // Field cidae_fat
        $filterList = Concat($filterList, $this->uf_fat->AdvancedSearch->toJson(), ","); // Field uf_fat
        $filterList = Concat($filterList, $this->origem_fat->AdvancedSearch->toJson(), ","); // Field origem_fat
        $filterList = Concat($filterList, $this->dia_vencto_fat->AdvancedSearch->toJson(), ","); // Field dia_vencto_fat
        $filterList = Concat($filterList, $this->quantidade->AdvancedSearch->toJson(), ","); // Field quantidade
        $filterList = Concat($filterList, $this->cargo->AdvancedSearch->toJson(), ","); // Field cargo
        $filterList = Concat($filterList, $this->escala->AdvancedSearch->toJson(), ","); // Field escala
        $filterList = Concat($filterList, $this->periodo->AdvancedSearch->toJson(), ","); // Field periodo
        $filterList = Concat($filterList, $this->intrajornada_tipo->AdvancedSearch->toJson(), ","); // Field intrajornada_tipo
        $filterList = Concat($filterList, $this->acumulo_funcao->AdvancedSearch->toJson(), ","); // Field acumulo_funcao
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
            Profile()->setSearchFilters("fview_comunicado_internosrch", $filters);
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

        // Field dt_proposta
        $this->dt_proposta->AdvancedSearch->SearchValue = @$filter["x_dt_proposta"];
        $this->dt_proposta->AdvancedSearch->SearchOperator = @$filter["z_dt_proposta"];
        $this->dt_proposta->AdvancedSearch->SearchCondition = @$filter["v_dt_proposta"];
        $this->dt_proposta->AdvancedSearch->SearchValue2 = @$filter["y_dt_proposta"];
        $this->dt_proposta->AdvancedSearch->SearchOperator2 = @$filter["w_dt_proposta"];
        $this->dt_proposta->AdvancedSearch->save();

        // Field consultor
        $this->consultor->AdvancedSearch->SearchValue = @$filter["x_consultor"];
        $this->consultor->AdvancedSearch->SearchOperator = @$filter["z_consultor"];
        $this->consultor->AdvancedSearch->SearchCondition = @$filter["v_consultor"];
        $this->consultor->AdvancedSearch->SearchValue2 = @$filter["y_consultor"];
        $this->consultor->AdvancedSearch->SearchOperator2 = @$filter["w_consultor"];
        $this->consultor->AdvancedSearch->save();

        // Field cliente
        $this->cliente->AdvancedSearch->SearchValue = @$filter["x_cliente"];
        $this->cliente->AdvancedSearch->SearchOperator = @$filter["z_cliente"];
        $this->cliente->AdvancedSearch->SearchCondition = @$filter["v_cliente"];
        $this->cliente->AdvancedSearch->SearchValue2 = @$filter["y_cliente"];
        $this->cliente->AdvancedSearch->SearchOperator2 = @$filter["w_cliente"];
        $this->cliente->AdvancedSearch->save();

        // Field cnpj_cli
        $this->cnpj_cli->AdvancedSearch->SearchValue = @$filter["x_cnpj_cli"];
        $this->cnpj_cli->AdvancedSearch->SearchOperator = @$filter["z_cnpj_cli"];
        $this->cnpj_cli->AdvancedSearch->SearchCondition = @$filter["v_cnpj_cli"];
        $this->cnpj_cli->AdvancedSearch->SearchValue2 = @$filter["y_cnpj_cli"];
        $this->cnpj_cli->AdvancedSearch->SearchOperator2 = @$filter["w_cnpj_cli"];
        $this->cnpj_cli->AdvancedSearch->save();

        // Field end_cli
        $this->end_cli->AdvancedSearch->SearchValue = @$filter["x_end_cli"];
        $this->end_cli->AdvancedSearch->SearchOperator = @$filter["z_end_cli"];
        $this->end_cli->AdvancedSearch->SearchCondition = @$filter["v_end_cli"];
        $this->end_cli->AdvancedSearch->SearchValue2 = @$filter["y_end_cli"];
        $this->end_cli->AdvancedSearch->SearchOperator2 = @$filter["w_end_cli"];
        $this->end_cli->AdvancedSearch->save();

        // Field nr_cli
        $this->nr_cli->AdvancedSearch->SearchValue = @$filter["x_nr_cli"];
        $this->nr_cli->AdvancedSearch->SearchOperator = @$filter["z_nr_cli"];
        $this->nr_cli->AdvancedSearch->SearchCondition = @$filter["v_nr_cli"];
        $this->nr_cli->AdvancedSearch->SearchValue2 = @$filter["y_nr_cli"];
        $this->nr_cli->AdvancedSearch->SearchOperator2 = @$filter["w_nr_cli"];
        $this->nr_cli->AdvancedSearch->save();

        // Field bairro_cli
        $this->bairro_cli->AdvancedSearch->SearchValue = @$filter["x_bairro_cli"];
        $this->bairro_cli->AdvancedSearch->SearchOperator = @$filter["z_bairro_cli"];
        $this->bairro_cli->AdvancedSearch->SearchCondition = @$filter["v_bairro_cli"];
        $this->bairro_cli->AdvancedSearch->SearchValue2 = @$filter["y_bairro_cli"];
        $this->bairro_cli->AdvancedSearch->SearchOperator2 = @$filter["w_bairro_cli"];
        $this->bairro_cli->AdvancedSearch->save();

        // Field cep_cli
        $this->cep_cli->AdvancedSearch->SearchValue = @$filter["x_cep_cli"];
        $this->cep_cli->AdvancedSearch->SearchOperator = @$filter["z_cep_cli"];
        $this->cep_cli->AdvancedSearch->SearchCondition = @$filter["v_cep_cli"];
        $this->cep_cli->AdvancedSearch->SearchValue2 = @$filter["y_cep_cli"];
        $this->cep_cli->AdvancedSearch->SearchOperator2 = @$filter["w_cep_cli"];
        $this->cep_cli->AdvancedSearch->save();

        // Field cidade_cli
        $this->cidade_cli->AdvancedSearch->SearchValue = @$filter["x_cidade_cli"];
        $this->cidade_cli->AdvancedSearch->SearchOperator = @$filter["z_cidade_cli"];
        $this->cidade_cli->AdvancedSearch->SearchCondition = @$filter["v_cidade_cli"];
        $this->cidade_cli->AdvancedSearch->SearchValue2 = @$filter["y_cidade_cli"];
        $this->cidade_cli->AdvancedSearch->SearchOperator2 = @$filter["w_cidade_cli"];
        $this->cidade_cli->AdvancedSearch->save();

        // Field uf_cli
        $this->uf_cli->AdvancedSearch->SearchValue = @$filter["x_uf_cli"];
        $this->uf_cli->AdvancedSearch->SearchOperator = @$filter["z_uf_cli"];
        $this->uf_cli->AdvancedSearch->SearchCondition = @$filter["v_uf_cli"];
        $this->uf_cli->AdvancedSearch->SearchValue2 = @$filter["y_uf_cli"];
        $this->uf_cli->AdvancedSearch->SearchOperator2 = @$filter["w_uf_cli"];
        $this->uf_cli->AdvancedSearch->save();

        // Field contato_cli
        $this->contato_cli->AdvancedSearch->SearchValue = @$filter["x_contato_cli"];
        $this->contato_cli->AdvancedSearch->SearchOperator = @$filter["z_contato_cli"];
        $this->contato_cli->AdvancedSearch->SearchCondition = @$filter["v_contato_cli"];
        $this->contato_cli->AdvancedSearch->SearchValue2 = @$filter["y_contato_cli"];
        $this->contato_cli->AdvancedSearch->SearchOperator2 = @$filter["w_contato_cli"];
        $this->contato_cli->AdvancedSearch->save();

        // Field email_cli
        $this->email_cli->AdvancedSearch->SearchValue = @$filter["x_email_cli"];
        $this->email_cli->AdvancedSearch->SearchOperator = @$filter["z_email_cli"];
        $this->email_cli->AdvancedSearch->SearchCondition = @$filter["v_email_cli"];
        $this->email_cli->AdvancedSearch->SearchValue2 = @$filter["y_email_cli"];
        $this->email_cli->AdvancedSearch->SearchOperator2 = @$filter["w_email_cli"];
        $this->email_cli->AdvancedSearch->save();

        // Field tel_cli
        $this->tel_cli->AdvancedSearch->SearchValue = @$filter["x_tel_cli"];
        $this->tel_cli->AdvancedSearch->SearchOperator = @$filter["z_tel_cli"];
        $this->tel_cli->AdvancedSearch->SearchCondition = @$filter["v_tel_cli"];
        $this->tel_cli->AdvancedSearch->SearchValue2 = @$filter["y_tel_cli"];
        $this->tel_cli->AdvancedSearch->SearchOperator2 = @$filter["w_tel_cli"];
        $this->tel_cli->AdvancedSearch->save();

        // Field faturamento
        $this->faturamento->AdvancedSearch->SearchValue = @$filter["x_faturamento"];
        $this->faturamento->AdvancedSearch->SearchOperator = @$filter["z_faturamento"];
        $this->faturamento->AdvancedSearch->SearchCondition = @$filter["v_faturamento"];
        $this->faturamento->AdvancedSearch->SearchValue2 = @$filter["y_faturamento"];
        $this->faturamento->AdvancedSearch->SearchOperator2 = @$filter["w_faturamento"];
        $this->faturamento->AdvancedSearch->save();

        // Field cnpj_fat
        $this->cnpj_fat->AdvancedSearch->SearchValue = @$filter["x_cnpj_fat"];
        $this->cnpj_fat->AdvancedSearch->SearchOperator = @$filter["z_cnpj_fat"];
        $this->cnpj_fat->AdvancedSearch->SearchCondition = @$filter["v_cnpj_fat"];
        $this->cnpj_fat->AdvancedSearch->SearchValue2 = @$filter["y_cnpj_fat"];
        $this->cnpj_fat->AdvancedSearch->SearchOperator2 = @$filter["w_cnpj_fat"];
        $this->cnpj_fat->AdvancedSearch->save();

        // Field end_fat
        $this->end_fat->AdvancedSearch->SearchValue = @$filter["x_end_fat"];
        $this->end_fat->AdvancedSearch->SearchOperator = @$filter["z_end_fat"];
        $this->end_fat->AdvancedSearch->SearchCondition = @$filter["v_end_fat"];
        $this->end_fat->AdvancedSearch->SearchValue2 = @$filter["y_end_fat"];
        $this->end_fat->AdvancedSearch->SearchOperator2 = @$filter["w_end_fat"];
        $this->end_fat->AdvancedSearch->save();

        // Field bairro_fat
        $this->bairro_fat->AdvancedSearch->SearchValue = @$filter["x_bairro_fat"];
        $this->bairro_fat->AdvancedSearch->SearchOperator = @$filter["z_bairro_fat"];
        $this->bairro_fat->AdvancedSearch->SearchCondition = @$filter["v_bairro_fat"];
        $this->bairro_fat->AdvancedSearch->SearchValue2 = @$filter["y_bairro_fat"];
        $this->bairro_fat->AdvancedSearch->SearchOperator2 = @$filter["w_bairro_fat"];
        $this->bairro_fat->AdvancedSearch->save();

        // Field cidae_fat
        $this->cidae_fat->AdvancedSearch->SearchValue = @$filter["x_cidae_fat"];
        $this->cidae_fat->AdvancedSearch->SearchOperator = @$filter["z_cidae_fat"];
        $this->cidae_fat->AdvancedSearch->SearchCondition = @$filter["v_cidae_fat"];
        $this->cidae_fat->AdvancedSearch->SearchValue2 = @$filter["y_cidae_fat"];
        $this->cidae_fat->AdvancedSearch->SearchOperator2 = @$filter["w_cidae_fat"];
        $this->cidae_fat->AdvancedSearch->save();

        // Field uf_fat
        $this->uf_fat->AdvancedSearch->SearchValue = @$filter["x_uf_fat"];
        $this->uf_fat->AdvancedSearch->SearchOperator = @$filter["z_uf_fat"];
        $this->uf_fat->AdvancedSearch->SearchCondition = @$filter["v_uf_fat"];
        $this->uf_fat->AdvancedSearch->SearchValue2 = @$filter["y_uf_fat"];
        $this->uf_fat->AdvancedSearch->SearchOperator2 = @$filter["w_uf_fat"];
        $this->uf_fat->AdvancedSearch->save();

        // Field origem_fat
        $this->origem_fat->AdvancedSearch->SearchValue = @$filter["x_origem_fat"];
        $this->origem_fat->AdvancedSearch->SearchOperator = @$filter["z_origem_fat"];
        $this->origem_fat->AdvancedSearch->SearchCondition = @$filter["v_origem_fat"];
        $this->origem_fat->AdvancedSearch->SearchValue2 = @$filter["y_origem_fat"];
        $this->origem_fat->AdvancedSearch->SearchOperator2 = @$filter["w_origem_fat"];
        $this->origem_fat->AdvancedSearch->save();

        // Field dia_vencto_fat
        $this->dia_vencto_fat->AdvancedSearch->SearchValue = @$filter["x_dia_vencto_fat"];
        $this->dia_vencto_fat->AdvancedSearch->SearchOperator = @$filter["z_dia_vencto_fat"];
        $this->dia_vencto_fat->AdvancedSearch->SearchCondition = @$filter["v_dia_vencto_fat"];
        $this->dia_vencto_fat->AdvancedSearch->SearchValue2 = @$filter["y_dia_vencto_fat"];
        $this->dia_vencto_fat->AdvancedSearch->SearchOperator2 = @$filter["w_dia_vencto_fat"];
        $this->dia_vencto_fat->AdvancedSearch->save();

        // Field quantidade
        $this->quantidade->AdvancedSearch->SearchValue = @$filter["x_quantidade"];
        $this->quantidade->AdvancedSearch->SearchOperator = @$filter["z_quantidade"];
        $this->quantidade->AdvancedSearch->SearchCondition = @$filter["v_quantidade"];
        $this->quantidade->AdvancedSearch->SearchValue2 = @$filter["y_quantidade"];
        $this->quantidade->AdvancedSearch->SearchOperator2 = @$filter["w_quantidade"];
        $this->quantidade->AdvancedSearch->save();

        // Field cargo
        $this->cargo->AdvancedSearch->SearchValue = @$filter["x_cargo"];
        $this->cargo->AdvancedSearch->SearchOperator = @$filter["z_cargo"];
        $this->cargo->AdvancedSearch->SearchCondition = @$filter["v_cargo"];
        $this->cargo->AdvancedSearch->SearchValue2 = @$filter["y_cargo"];
        $this->cargo->AdvancedSearch->SearchOperator2 = @$filter["w_cargo"];
        $this->cargo->AdvancedSearch->save();

        // Field escala
        $this->escala->AdvancedSearch->SearchValue = @$filter["x_escala"];
        $this->escala->AdvancedSearch->SearchOperator = @$filter["z_escala"];
        $this->escala->AdvancedSearch->SearchCondition = @$filter["v_escala"];
        $this->escala->AdvancedSearch->SearchValue2 = @$filter["y_escala"];
        $this->escala->AdvancedSearch->SearchOperator2 = @$filter["w_escala"];
        $this->escala->AdvancedSearch->save();

        // Field periodo
        $this->periodo->AdvancedSearch->SearchValue = @$filter["x_periodo"];
        $this->periodo->AdvancedSearch->SearchOperator = @$filter["z_periodo"];
        $this->periodo->AdvancedSearch->SearchCondition = @$filter["v_periodo"];
        $this->periodo->AdvancedSearch->SearchValue2 = @$filter["y_periodo"];
        $this->periodo->AdvancedSearch->SearchOperator2 = @$filter["w_periodo"];
        $this->periodo->AdvancedSearch->save();

        // Field intrajornada_tipo
        $this->intrajornada_tipo->AdvancedSearch->SearchValue = @$filter["x_intrajornada_tipo"];
        $this->intrajornada_tipo->AdvancedSearch->SearchOperator = @$filter["z_intrajornada_tipo"];
        $this->intrajornada_tipo->AdvancedSearch->SearchCondition = @$filter["v_intrajornada_tipo"];
        $this->intrajornada_tipo->AdvancedSearch->SearchValue2 = @$filter["y_intrajornada_tipo"];
        $this->intrajornada_tipo->AdvancedSearch->SearchOperator2 = @$filter["w_intrajornada_tipo"];
        $this->intrajornada_tipo->AdvancedSearch->save();

        // Field acumulo_funcao
        $this->acumulo_funcao->AdvancedSearch->SearchValue = @$filter["x_acumulo_funcao"];
        $this->acumulo_funcao->AdvancedSearch->SearchOperator = @$filter["z_acumulo_funcao"];
        $this->acumulo_funcao->AdvancedSearch->SearchCondition = @$filter["v_acumulo_funcao"];
        $this->acumulo_funcao->AdvancedSearch->SearchValue2 = @$filter["y_acumulo_funcao"];
        $this->acumulo_funcao->AdvancedSearch->SearchOperator2 = @$filter["w_acumulo_funcao"];
        $this->acumulo_funcao->AdvancedSearch->save();
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
        $searchFlds[] = &$this->cliente;
        $searchFlds[] = &$this->cnpj_cli;
        $searchFlds[] = &$this->end_cli;
        $searchFlds[] = &$this->nr_cli;
        $searchFlds[] = &$this->bairro_cli;
        $searchFlds[] = &$this->cep_cli;
        $searchFlds[] = &$this->cidade_cli;
        $searchFlds[] = &$this->uf_cli;
        $searchFlds[] = &$this->contato_cli;
        $searchFlds[] = &$this->email_cli;
        $searchFlds[] = &$this->tel_cli;
        $searchFlds[] = &$this->faturamento;
        $searchFlds[] = &$this->cnpj_fat;
        $searchFlds[] = &$this->end_fat;
        $searchFlds[] = &$this->bairro_fat;
        $searchFlds[] = &$this->cidae_fat;
        $searchFlds[] = &$this->uf_fat;
        $searchFlds[] = &$this->cargo;
        $searchFlds[] = &$this->escala;
        $searchFlds[] = &$this->periodo;
        $searchFlds[] = &$this->intrajornada_tipo;
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
            $this->updateSort($this->dt_proposta, $ctrl); // dt_proposta
            $this->updateSort($this->consultor, $ctrl); // consultor
            $this->updateSort($this->cliente, $ctrl); // cliente
            $this->updateSort($this->cnpj_cli, $ctrl); // cnpj_cli
            $this->updateSort($this->end_cli, $ctrl); // end_cli
            $this->updateSort($this->nr_cli, $ctrl); // nr_cli
            $this->updateSort($this->bairro_cli, $ctrl); // bairro_cli
            $this->updateSort($this->cep_cli, $ctrl); // cep_cli
            $this->updateSort($this->cidade_cli, $ctrl); // cidade_cli
            $this->updateSort($this->uf_cli, $ctrl); // uf_cli
            $this->updateSort($this->contato_cli, $ctrl); // contato_cli
            $this->updateSort($this->email_cli, $ctrl); // email_cli
            $this->updateSort($this->tel_cli, $ctrl); // tel_cli
            $this->updateSort($this->faturamento, $ctrl); // faturamento
            $this->updateSort($this->cnpj_fat, $ctrl); // cnpj_fat
            $this->updateSort($this->end_fat, $ctrl); // end_fat
            $this->updateSort($this->bairro_fat, $ctrl); // bairro_fat
            $this->updateSort($this->cidae_fat, $ctrl); // cidae_fat
            $this->updateSort($this->uf_fat, $ctrl); // uf_fat
            $this->updateSort($this->origem_fat, $ctrl); // origem_fat
            $this->updateSort($this->dia_vencto_fat, $ctrl); // dia_vencto_fat
            $this->updateSort($this->quantidade, $ctrl); // quantidade
            $this->updateSort($this->cargo, $ctrl); // cargo
            $this->updateSort($this->escala, $ctrl); // escala
            $this->updateSort($this->periodo, $ctrl); // periodo
            $this->updateSort($this->intrajornada_tipo, $ctrl); // intrajornada_tipo
            $this->updateSort($this->acumulo_funcao, $ctrl); // acumulo_funcao
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
                $this->dt_proposta->setSort("");
                $this->consultor->setSort("");
                $this->cliente->setSort("");
                $this->cnpj_cli->setSort("");
                $this->end_cli->setSort("");
                $this->nr_cli->setSort("");
                $this->bairro_cli->setSort("");
                $this->cep_cli->setSort("");
                $this->cidade_cli->setSort("");
                $this->uf_cli->setSort("");
                $this->contato_cli->setSort("");
                $this->email_cli->setSort("");
                $this->tel_cli->setSort("");
                $this->faturamento->setSort("");
                $this->cnpj_fat->setSort("");
                $this->end_fat->setSort("");
                $this->bairro_fat->setSort("");
                $this->cidae_fat->setSort("");
                $this->uf_fat->setSort("");
                $this->origem_fat->setSort("");
                $this->dia_vencto_fat->setSort("");
                $this->quantidade->setSort("");
                $this->cargo->setSort("");
                $this->escala->setSort("");
                $this->periodo->setSort("");
                $this->intrajornada_tipo->setSort("");
                $this->acumulo_funcao->setSort("");
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fview_comunicado_internolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fview_comunicado_internolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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
            $this->createColumnOption($option, "dt_proposta");
            $this->createColumnOption($option, "consultor");
            $this->createColumnOption($option, "cliente");
            $this->createColumnOption($option, "cnpj_cli");
            $this->createColumnOption($option, "end_cli");
            $this->createColumnOption($option, "nr_cli");
            $this->createColumnOption($option, "bairro_cli");
            $this->createColumnOption($option, "cep_cli");
            $this->createColumnOption($option, "cidade_cli");
            $this->createColumnOption($option, "uf_cli");
            $this->createColumnOption($option, "contato_cli");
            $this->createColumnOption($option, "email_cli");
            $this->createColumnOption($option, "tel_cli");
            $this->createColumnOption($option, "faturamento");
            $this->createColumnOption($option, "cnpj_fat");
            $this->createColumnOption($option, "end_fat");
            $this->createColumnOption($option, "bairro_fat");
            $this->createColumnOption($option, "cidae_fat");
            $this->createColumnOption($option, "uf_fat");
            $this->createColumnOption($option, "origem_fat");
            $this->createColumnOption($option, "dia_vencto_fat");
            $this->createColumnOption($option, "quantidade");
            $this->createColumnOption($option, "cargo");
            $this->createColumnOption($option, "escala");
            $this->createColumnOption($option, "periodo");
            $this->createColumnOption($option, "intrajornada_tipo");
            $this->createColumnOption($option, "acumulo_funcao");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fview_comunicado_internosrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fview_comunicado_internosrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fview_comunicado_internolist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_view_comunicado_interno", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_view_comunicado_interno",
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
        $this->dt_proposta->setDbValue($row['dt_proposta']);
        $this->consultor->setDbValue($row['consultor']);
        $this->cliente->setDbValue($row['cliente']);
        $this->cnpj_cli->setDbValue($row['cnpj_cli']);
        $this->end_cli->setDbValue($row['end_cli']);
        $this->nr_cli->setDbValue($row['nr_cli']);
        $this->bairro_cli->setDbValue($row['bairro_cli']);
        $this->cep_cli->setDbValue($row['cep_cli']);
        $this->cidade_cli->setDbValue($row['cidade_cli']);
        $this->uf_cli->setDbValue($row['uf_cli']);
        $this->contato_cli->setDbValue($row['contato_cli']);
        $this->email_cli->setDbValue($row['email_cli']);
        $this->tel_cli->setDbValue($row['tel_cli']);
        $this->faturamento->setDbValue($row['faturamento']);
        $this->cnpj_fat->setDbValue($row['cnpj_fat']);
        $this->end_fat->setDbValue($row['end_fat']);
        $this->bairro_fat->setDbValue($row['bairro_fat']);
        $this->cidae_fat->setDbValue($row['cidae_fat']);
        $this->uf_fat->setDbValue($row['uf_fat']);
        $this->origem_fat->setDbValue($row['origem_fat']);
        $this->dia_vencto_fat->setDbValue($row['dia_vencto_fat']);
        $this->quantidade->setDbValue($row['quantidade']);
        $this->cargo->setDbValue($row['cargo']);
        $this->escala->setDbValue($row['escala']);
        $this->periodo->setDbValue($row['periodo']);
        $this->intrajornada_tipo->setDbValue($row['intrajornada_tipo']);
        $this->acumulo_funcao->setDbValue($row['acumulo_funcao']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idproposta'] = $this->idproposta->DefaultValue;
        $row['dt_proposta'] = $this->dt_proposta->DefaultValue;
        $row['consultor'] = $this->consultor->DefaultValue;
        $row['cliente'] = $this->cliente->DefaultValue;
        $row['cnpj_cli'] = $this->cnpj_cli->DefaultValue;
        $row['end_cli'] = $this->end_cli->DefaultValue;
        $row['nr_cli'] = $this->nr_cli->DefaultValue;
        $row['bairro_cli'] = $this->bairro_cli->DefaultValue;
        $row['cep_cli'] = $this->cep_cli->DefaultValue;
        $row['cidade_cli'] = $this->cidade_cli->DefaultValue;
        $row['uf_cli'] = $this->uf_cli->DefaultValue;
        $row['contato_cli'] = $this->contato_cli->DefaultValue;
        $row['email_cli'] = $this->email_cli->DefaultValue;
        $row['tel_cli'] = $this->tel_cli->DefaultValue;
        $row['faturamento'] = $this->faturamento->DefaultValue;
        $row['cnpj_fat'] = $this->cnpj_fat->DefaultValue;
        $row['end_fat'] = $this->end_fat->DefaultValue;
        $row['bairro_fat'] = $this->bairro_fat->DefaultValue;
        $row['cidae_fat'] = $this->cidae_fat->DefaultValue;
        $row['uf_fat'] = $this->uf_fat->DefaultValue;
        $row['origem_fat'] = $this->origem_fat->DefaultValue;
        $row['dia_vencto_fat'] = $this->dia_vencto_fat->DefaultValue;
        $row['quantidade'] = $this->quantidade->DefaultValue;
        $row['cargo'] = $this->cargo->DefaultValue;
        $row['escala'] = $this->escala->DefaultValue;
        $row['periodo'] = $this->periodo->DefaultValue;
        $row['intrajornada_tipo'] = $this->intrajornada_tipo->DefaultValue;
        $row['acumulo_funcao'] = $this->acumulo_funcao->DefaultValue;
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

        // dt_proposta

        // consultor

        // cliente

        // cnpj_cli

        // end_cli

        // nr_cli

        // bairro_cli

        // cep_cli

        // cidade_cli

        // uf_cli

        // contato_cli

        // email_cli

        // tel_cli

        // faturamento

        // cnpj_fat

        // end_fat

        // bairro_fat

        // cidae_fat

        // uf_fat

        // origem_fat

        // dia_vencto_fat

        // quantidade

        // cargo

        // escala

        // periodo

        // intrajornada_tipo

        // acumulo_funcao

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idproposta
            $this->idproposta->ViewValue = $this->idproposta->CurrentValue;

            // dt_proposta
            $this->dt_proposta->ViewValue = $this->dt_proposta->CurrentValue;
            $this->dt_proposta->ViewValue = FormatDateTime($this->dt_proposta->ViewValue, $this->dt_proposta->formatPattern());

            // consultor
            $this->consultor->ViewValue = $this->consultor->CurrentValue;
            $this->consultor->ViewValue = FormatNumber($this->consultor->ViewValue, $this->consultor->formatPattern());

            // cliente
            $this->cliente->ViewValue = $this->cliente->CurrentValue;

            // cnpj_cli
            $this->cnpj_cli->ViewValue = $this->cnpj_cli->CurrentValue;

            // end_cli
            $this->end_cli->ViewValue = $this->end_cli->CurrentValue;

            // nr_cli
            $this->nr_cli->ViewValue = $this->nr_cli->CurrentValue;

            // bairro_cli
            $this->bairro_cli->ViewValue = $this->bairro_cli->CurrentValue;

            // cep_cli
            $this->cep_cli->ViewValue = $this->cep_cli->CurrentValue;

            // cidade_cli
            $this->cidade_cli->ViewValue = $this->cidade_cli->CurrentValue;

            // uf_cli
            $this->uf_cli->ViewValue = $this->uf_cli->CurrentValue;

            // contato_cli
            $this->contato_cli->ViewValue = $this->contato_cli->CurrentValue;

            // email_cli
            $this->email_cli->ViewValue = $this->email_cli->CurrentValue;

            // tel_cli
            $this->tel_cli->ViewValue = $this->tel_cli->CurrentValue;

            // faturamento
            $this->faturamento->ViewValue = $this->faturamento->CurrentValue;

            // cnpj_fat
            $this->cnpj_fat->ViewValue = $this->cnpj_fat->CurrentValue;

            // end_fat
            $this->end_fat->ViewValue = $this->end_fat->CurrentValue;

            // bairro_fat
            $this->bairro_fat->ViewValue = $this->bairro_fat->CurrentValue;

            // cidae_fat
            $this->cidae_fat->ViewValue = $this->cidae_fat->CurrentValue;

            // uf_fat
            $this->uf_fat->ViewValue = $this->uf_fat->CurrentValue;

            // origem_fat
            if (strval($this->origem_fat->CurrentValue) != "") {
                $this->origem_fat->ViewValue = $this->origem_fat->optionCaption($this->origem_fat->CurrentValue);
            } else {
                $this->origem_fat->ViewValue = null;
            }

            // dia_vencto_fat
            $this->dia_vencto_fat->ViewValue = $this->dia_vencto_fat->CurrentValue;
            $this->dia_vencto_fat->ViewValue = FormatNumber($this->dia_vencto_fat->ViewValue, $this->dia_vencto_fat->formatPattern());

            // quantidade
            $this->quantidade->ViewValue = $this->quantidade->CurrentValue;
            $this->quantidade->ViewValue = FormatNumber($this->quantidade->ViewValue, $this->quantidade->formatPattern());

            // cargo
            $this->cargo->ViewValue = $this->cargo->CurrentValue;

            // escala
            $this->escala->ViewValue = $this->escala->CurrentValue;

            // periodo
            $this->periodo->ViewValue = $this->periodo->CurrentValue;

            // intrajornada_tipo
            $this->intrajornada_tipo->ViewValue = $this->intrajornada_tipo->CurrentValue;

            // acumulo_funcao
            if (strval($this->acumulo_funcao->CurrentValue) != "") {
                $this->acumulo_funcao->ViewValue = $this->acumulo_funcao->optionCaption($this->acumulo_funcao->CurrentValue);
            } else {
                $this->acumulo_funcao->ViewValue = null;
            }

            // idproposta
            $this->idproposta->HrefValue = "";
            $this->idproposta->TooltipValue = "";

            // dt_proposta
            $this->dt_proposta->HrefValue = "";
            $this->dt_proposta->TooltipValue = "";

            // consultor
            $this->consultor->HrefValue = "";
            $this->consultor->TooltipValue = "";

            // cliente
            $this->cliente->HrefValue = "";
            $this->cliente->TooltipValue = "";

            // cnpj_cli
            $this->cnpj_cli->HrefValue = "";
            $this->cnpj_cli->TooltipValue = "";

            // end_cli
            $this->end_cli->HrefValue = "";
            $this->end_cli->TooltipValue = "";

            // nr_cli
            $this->nr_cli->HrefValue = "";
            $this->nr_cli->TooltipValue = "";

            // bairro_cli
            $this->bairro_cli->HrefValue = "";
            $this->bairro_cli->TooltipValue = "";

            // cep_cli
            $this->cep_cli->HrefValue = "";
            $this->cep_cli->TooltipValue = "";

            // cidade_cli
            $this->cidade_cli->HrefValue = "";
            $this->cidade_cli->TooltipValue = "";

            // uf_cli
            $this->uf_cli->HrefValue = "";
            $this->uf_cli->TooltipValue = "";

            // contato_cli
            $this->contato_cli->HrefValue = "";
            $this->contato_cli->TooltipValue = "";

            // email_cli
            $this->email_cli->HrefValue = "";
            $this->email_cli->TooltipValue = "";

            // tel_cli
            $this->tel_cli->HrefValue = "";
            $this->tel_cli->TooltipValue = "";

            // faturamento
            $this->faturamento->HrefValue = "";
            $this->faturamento->TooltipValue = "";

            // cnpj_fat
            $this->cnpj_fat->HrefValue = "";
            $this->cnpj_fat->TooltipValue = "";

            // end_fat
            $this->end_fat->HrefValue = "";
            $this->end_fat->TooltipValue = "";

            // bairro_fat
            $this->bairro_fat->HrefValue = "";
            $this->bairro_fat->TooltipValue = "";

            // cidae_fat
            $this->cidae_fat->HrefValue = "";
            $this->cidae_fat->TooltipValue = "";

            // uf_fat
            $this->uf_fat->HrefValue = "";
            $this->uf_fat->TooltipValue = "";

            // origem_fat
            $this->origem_fat->HrefValue = "";
            $this->origem_fat->TooltipValue = "";

            // dia_vencto_fat
            $this->dia_vencto_fat->HrefValue = "";
            $this->dia_vencto_fat->TooltipValue = "";

            // quantidade
            $this->quantidade->HrefValue = "";
            $this->quantidade->TooltipValue = "";

            // cargo
            $this->cargo->HrefValue = "";
            $this->cargo->TooltipValue = "";

            // escala
            $this->escala->HrefValue = "";
            $this->escala->TooltipValue = "";

            // periodo
            $this->periodo->HrefValue = "";
            $this->periodo->TooltipValue = "";

            // intrajornada_tipo
            $this->intrajornada_tipo->HrefValue = "";
            $this->intrajornada_tipo->TooltipValue = "";

            // acumulo_funcao
            $this->acumulo_funcao->HrefValue = "";
            $this->acumulo_funcao->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
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
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fview_comunicado_internolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fview_comunicado_internolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fview_comunicado_internolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fview_comunicado_internolist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fview_comunicado_internosrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_origem_fat":
                    break;
                case "x_acumulo_funcao":
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
