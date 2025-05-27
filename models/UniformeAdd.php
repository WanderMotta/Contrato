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
class UniformeAdd extends Uniforme
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "UniformeAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "UniformeAdd";

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
        $this->iduniforme->Visible = false;
        $this->uniforme->setVisibility();
        $this->qtde->setVisibility();
        $this->periodo_troca->setVisibility();
        $this->vr_unitario->setVisibility();
        $this->vr_total->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'uniforme';
        $this->TableName = 'uniforme';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (uniforme)
        if (!isset($GLOBALS["uniforme"]) || $GLOBALS["uniforme"]::class == PROJECT_NAMESPACE . "uniforme") {
            $GLOBALS["uniforme"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'uniforme');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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
                if (
                    SameString($pageName, GetPageName($this->getListUrl())) ||
                    SameString($pageName, GetPageName($this->getViewUrl())) ||
                    SameString($pageName, GetPageName(CurrentMasterTable()?->getViewUrl() ?? ""))
                ) { // List / View / Master View page
                    if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                        $result["caption"] = $this->getModalCaption($pageName);
                        $result["view"] = SameString($pageName, "UniformeView"); // If View page, no primary button
                    } else { // List page
                        $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                        $this->clearFailureMessage();
                    }
                } else { // Other pages (add messages and then clear messages)
                    $result = array_merge($this->getMessages(), ["modal" => "1"]);
                    $this->clearMessages();
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
            $key .= @$ar['iduniforme'];
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
            $this->iduniforme->Visible = false;
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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

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
        $this->CurrentAction = Param("action"); // Set up current action
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

        // Set up lookup cache
        $this->setupLookupOptions($this->periodo_troca);

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("iduniforme") ?? Route("iduniforme")) !== null) {
                $this->iduniforme->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("UniformeList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "UniformeList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "UniformeView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "UniformeList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "UniformeList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = RowType::ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->qtde->DefaultValue = $this->qtde->getDefault(); // PHP
        $this->qtde->OldValue = $this->qtde->DefaultValue;
        $this->periodo_troca->DefaultValue = $this->periodo_troca->getDefault(); // PHP
        $this->periodo_troca->OldValue = $this->periodo_troca->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'uniforme' first before field var 'x_uniforme'
        $val = $CurrentForm->hasValue("uniforme") ? $CurrentForm->getValue("uniforme") : $CurrentForm->getValue("x_uniforme");
        if (!$this->uniforme->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->uniforme->Visible = false; // Disable update for API request
            } else {
                $this->uniforme->setFormValue($val);
            }
        }

        // Check field name 'qtde' first before field var 'x_qtde'
        $val = $CurrentForm->hasValue("qtde") ? $CurrentForm->getValue("qtde") : $CurrentForm->getValue("x_qtde");
        if (!$this->qtde->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->qtde->Visible = false; // Disable update for API request
            } else {
                $this->qtde->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'periodo_troca' first before field var 'x_periodo_troca'
        $val = $CurrentForm->hasValue("periodo_troca") ? $CurrentForm->getValue("periodo_troca") : $CurrentForm->getValue("x_periodo_troca");
        if (!$this->periodo_troca->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->periodo_troca->Visible = false; // Disable update for API request
            } else {
                $this->periodo_troca->setFormValue($val);
            }
        }

        // Check field name 'vr_unitario' first before field var 'x_vr_unitario'
        $val = $CurrentForm->hasValue("vr_unitario") ? $CurrentForm->getValue("vr_unitario") : $CurrentForm->getValue("x_vr_unitario");
        if (!$this->vr_unitario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vr_unitario->Visible = false; // Disable update for API request
            } else {
                $this->vr_unitario->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'vr_total' first before field var 'x_vr_total'
        $val = $CurrentForm->hasValue("vr_total") ? $CurrentForm->getValue("vr_total") : $CurrentForm->getValue("x_vr_total");
        if (!$this->vr_total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vr_total->Visible = false; // Disable update for API request
            } else {
                $this->vr_total->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'iduniforme' first before field var 'x_iduniforme'
        $val = $CurrentForm->hasValue("iduniforme") ? $CurrentForm->getValue("iduniforme") : $CurrentForm->getValue("x_iduniforme");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->uniforme->CurrentValue = $this->uniforme->FormValue;
        $this->qtde->CurrentValue = $this->qtde->FormValue;
        $this->periodo_troca->CurrentValue = $this->periodo_troca->FormValue;
        $this->vr_unitario->CurrentValue = $this->vr_unitario->FormValue;
        $this->vr_total->CurrentValue = $this->vr_total->FormValue;
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
        $this->iduniforme->setDbValue($row['iduniforme']);
        $this->uniforme->setDbValue($row['uniforme']);
        $this->qtde->setDbValue($row['qtde']);
        $this->periodo_troca->setDbValue($row['periodo_troca']);
        $this->vr_unitario->setDbValue($row['vr_unitario']);
        $this->vr_total->setDbValue($row['vr_total']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['iduniforme'] = $this->iduniforme->DefaultValue;
        $row['uniforme'] = $this->uniforme->DefaultValue;
        $row['qtde'] = $this->qtde->DefaultValue;
        $row['periodo_troca'] = $this->periodo_troca->DefaultValue;
        $row['vr_unitario'] = $this->vr_unitario->DefaultValue;
        $row['vr_total'] = $this->vr_total->DefaultValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // iduniforme
        $this->iduniforme->RowCssClass = "row";

        // uniforme
        $this->uniforme->RowCssClass = "row";

        // qtde
        $this->qtde->RowCssClass = "row";

        // periodo_troca
        $this->periodo_troca->RowCssClass = "row";

        // vr_unitario
        $this->vr_unitario->RowCssClass = "row";

        // vr_total
        $this->vr_total->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // iduniforme
            $this->iduniforme->ViewValue = $this->iduniforme->CurrentValue;

            // uniforme
            $this->uniforme->ViewValue = $this->uniforme->CurrentValue;
            $this->uniforme->CssClass = "fw-bold";

            // qtde
            $this->qtde->ViewValue = $this->qtde->CurrentValue;
            $this->qtde->ViewValue = FormatNumber($this->qtde->ViewValue, $this->qtde->formatPattern());
            $this->qtde->CssClass = "fw-bold";
            $this->qtde->CellCssStyle .= "text-align: center;";

            // periodo_troca
            if (strval($this->periodo_troca->CurrentValue) != "") {
                $this->periodo_troca->ViewValue = $this->periodo_troca->optionCaption($this->periodo_troca->CurrentValue);
            } else {
                $this->periodo_troca->ViewValue = null;
            }
            $this->periodo_troca->CssClass = "fw-bold";
            $this->periodo_troca->CellCssStyle .= "text-align: center;";

            // vr_unitario
            $this->vr_unitario->ViewValue = $this->vr_unitario->CurrentValue;
            $this->vr_unitario->ViewValue = FormatCurrency($this->vr_unitario->ViewValue, $this->vr_unitario->formatPattern());
            $this->vr_unitario->CssClass = "fw-bold";
            $this->vr_unitario->CellCssStyle .= "text-align: right;";

            // vr_total
            $this->vr_total->ViewValue = $this->vr_total->CurrentValue;
            $this->vr_total->ViewValue = FormatCurrency($this->vr_total->ViewValue, $this->vr_total->formatPattern());
            $this->vr_total->CssClass = "fw-bold";
            $this->vr_total->CellCssStyle .= "text-align: right;";

            // uniforme
            $this->uniforme->HrefValue = "";

            // qtde
            $this->qtde->HrefValue = "";

            // periodo_troca
            $this->periodo_troca->HrefValue = "";

            // vr_unitario
            $this->vr_unitario->HrefValue = "";

            // vr_total
            $this->vr_total->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // uniforme
            $this->uniforme->setupEditAttributes();
            if (!$this->uniforme->Raw) {
                $this->uniforme->CurrentValue = HtmlDecode($this->uniforme->CurrentValue);
            }
            $this->uniforme->EditValue = HtmlEncode($this->uniforme->CurrentValue);
            $this->uniforme->PlaceHolder = RemoveHtml($this->uniforme->caption());

            // qtde
            $this->qtde->setupEditAttributes();
            $this->qtde->EditValue = $this->qtde->CurrentValue;
            $this->qtde->PlaceHolder = RemoveHtml($this->qtde->caption());
            if (strval($this->qtde->EditValue) != "" && is_numeric($this->qtde->EditValue)) {
                $this->qtde->EditValue = FormatNumber($this->qtde->EditValue, null);
            }

            // periodo_troca
            $this->periodo_troca->EditValue = $this->periodo_troca->options(false);
            $this->periodo_troca->PlaceHolder = RemoveHtml($this->periodo_troca->caption());

            // vr_unitario
            $this->vr_unitario->setupEditAttributes();
            $this->vr_unitario->EditValue = $this->vr_unitario->CurrentValue;
            $this->vr_unitario->PlaceHolder = RemoveHtml($this->vr_unitario->caption());
            if (strval($this->vr_unitario->EditValue) != "" && is_numeric($this->vr_unitario->EditValue)) {
                $this->vr_unitario->EditValue = FormatNumber($this->vr_unitario->EditValue, null);
            }

            // vr_total
            $this->vr_total->setupEditAttributes();
            $this->vr_total->EditValue = $this->vr_total->CurrentValue;
            $this->vr_total->PlaceHolder = RemoveHtml($this->vr_total->caption());
            if (strval($this->vr_total->EditValue) != "" && is_numeric($this->vr_total->EditValue)) {
                $this->vr_total->EditValue = FormatNumber($this->vr_total->EditValue, null);
            }

            // Add refer script

            // uniforme
            $this->uniforme->HrefValue = "";

            // qtde
            $this->qtde->HrefValue = "";

            // periodo_troca
            $this->periodo_troca->HrefValue = "";

            // vr_unitario
            $this->vr_unitario->HrefValue = "";

            // vr_total
            $this->vr_total->HrefValue = "";
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
            if ($this->uniforme->Visible && $this->uniforme->Required) {
                if (!$this->uniforme->IsDetailKey && EmptyValue($this->uniforme->FormValue)) {
                    $this->uniforme->addErrorMessage(str_replace("%s", $this->uniforme->caption(), $this->uniforme->RequiredErrorMessage));
                }
            }
            if ($this->qtde->Visible && $this->qtde->Required) {
                if (!$this->qtde->IsDetailKey && EmptyValue($this->qtde->FormValue)) {
                    $this->qtde->addErrorMessage(str_replace("%s", $this->qtde->caption(), $this->qtde->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->qtde->FormValue)) {
                $this->qtde->addErrorMessage($this->qtde->getErrorMessage(false));
            }
            if ($this->periodo_troca->Visible && $this->periodo_troca->Required) {
                if ($this->periodo_troca->FormValue == "") {
                    $this->periodo_troca->addErrorMessage(str_replace("%s", $this->periodo_troca->caption(), $this->periodo_troca->RequiredErrorMessage));
                }
            }
            if ($this->vr_unitario->Visible && $this->vr_unitario->Required) {
                if (!$this->vr_unitario->IsDetailKey && EmptyValue($this->vr_unitario->FormValue)) {
                    $this->vr_unitario->addErrorMessage(str_replace("%s", $this->vr_unitario->caption(), $this->vr_unitario->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->vr_unitario->FormValue)) {
                $this->vr_unitario->addErrorMessage($this->vr_unitario->getErrorMessage(false));
            }
            if ($this->vr_total->Visible && $this->vr_total->Required) {
                if (!$this->vr_total->IsDetailKey && EmptyValue($this->vr_total->FormValue)) {
                    $this->vr_total->addErrorMessage(str_replace("%s", $this->vr_total->caption(), $this->vr_total->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->vr_total->FormValue)) {
                $this->vr_total->addErrorMessage($this->vr_total->getErrorMessage(false));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

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

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
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

        // uniforme
        $this->uniforme->setDbValueDef($rsnew, $this->uniforme->CurrentValue, false);

        // qtde
        $this->qtde->setDbValueDef($rsnew, $this->qtde->CurrentValue, strval($this->qtde->CurrentValue) == "");

        // periodo_troca
        $this->periodo_troca->setDbValueDef($rsnew, $this->periodo_troca->CurrentValue, strval($this->periodo_troca->CurrentValue) == "");

        // vr_unitario
        $this->vr_unitario->setDbValueDef($rsnew, $this->vr_unitario->CurrentValue, false);

        // vr_total
        $this->vr_total->setDbValueDef($rsnew, $this->vr_total->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['uniforme'])) { // uniforme
            $this->uniforme->setFormValue($row['uniforme']);
        }
        if (isset($row['qtde'])) { // qtde
            $this->qtde->setFormValue($row['qtde']);
        }
        if (isset($row['periodo_troca'])) { // periodo_troca
            $this->periodo_troca->setFormValue($row['periodo_troca']);
        }
        if (isset($row['vr_unitario'])) { // vr_unitario
            $this->vr_unitario->setFormValue($row['vr_unitario']);
        }
        if (isset($row['vr_total'])) { // vr_total
            $this->vr_total->setFormValue($row['vr_total']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("UniformeList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_periodo_troca":
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
}
