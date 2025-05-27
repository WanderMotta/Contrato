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
class ItensModuloAdd extends ItensModulo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ItensModuloAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ItensModuloAdd";

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
        $this->iditens_modulo->Visible = false;
        $this->modulo_idmodulo->setVisibility();
        $this->item->setVisibility();
        $this->porcentagem_valor->setVisibility();
        $this->incidencia_inss->setVisibility();
        $this->ativo->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'itens_modulo';
        $this->TableName = 'itens_modulo';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (itens_modulo)
        if (!isset($GLOBALS["itens_modulo"]) || $GLOBALS["itens_modulo"]::class == PROJECT_NAMESPACE . "itens_modulo") {
            $GLOBALS["itens_modulo"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'itens_modulo');
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
                        $result["view"] = SameString($pageName, "ItensModuloView"); // If View page, no primary button
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
            $key .= @$ar['iditens_modulo'];
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
            $this->iditens_modulo->Visible = false;
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
        $this->setupLookupOptions($this->modulo_idmodulo);
        $this->setupLookupOptions($this->incidencia_inss);
        $this->setupLookupOptions($this->ativo);

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
            if (($keyValue = Get("iditens_modulo") ?? Route("iditens_modulo")) !== null) {
                $this->iditens_modulo->setQueryStringValue($keyValue);
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

        // Set up master/detail parameters
        // NOTE: Must be after loadOldRecord to prevent master key values being overwritten
        $this->setupMasterParms();

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
                    $this->terminate("ItensModuloList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "ItensModuloList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ItensModuloView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ItensModuloList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ItensModuloList"; // Return list page content
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
        $this->incidencia_inss->DefaultValue = $this->incidencia_inss->getDefault(); // PHP
        $this->incidencia_inss->OldValue = $this->incidencia_inss->DefaultValue;
        $this->ativo->DefaultValue = $this->ativo->getDefault(); // PHP
        $this->ativo->OldValue = $this->ativo->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'modulo_idmodulo' first before field var 'x_modulo_idmodulo'
        $val = $CurrentForm->hasValue("modulo_idmodulo") ? $CurrentForm->getValue("modulo_idmodulo") : $CurrentForm->getValue("x_modulo_idmodulo");
        if (!$this->modulo_idmodulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->modulo_idmodulo->Visible = false; // Disable update for API request
            } else {
                $this->modulo_idmodulo->setFormValue($val);
            }
        }

        // Check field name 'item' first before field var 'x_item'
        $val = $CurrentForm->hasValue("item") ? $CurrentForm->getValue("item") : $CurrentForm->getValue("x_item");
        if (!$this->item->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->item->Visible = false; // Disable update for API request
            } else {
                $this->item->setFormValue($val);
            }
        }

        // Check field name 'porcentagem_valor' first before field var 'x_porcentagem_valor'
        $val = $CurrentForm->hasValue("porcentagem_valor") ? $CurrentForm->getValue("porcentagem_valor") : $CurrentForm->getValue("x_porcentagem_valor");
        if (!$this->porcentagem_valor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->porcentagem_valor->Visible = false; // Disable update for API request
            } else {
                $this->porcentagem_valor->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'incidencia_inss' first before field var 'x_incidencia_inss'
        $val = $CurrentForm->hasValue("incidencia_inss") ? $CurrentForm->getValue("incidencia_inss") : $CurrentForm->getValue("x_incidencia_inss");
        if (!$this->incidencia_inss->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->incidencia_inss->Visible = false; // Disable update for API request
            } else {
                $this->incidencia_inss->setFormValue($val);
            }
        }

        // Check field name 'iditens_modulo' first before field var 'x_iditens_modulo'
        $val = $CurrentForm->hasValue("iditens_modulo") ? $CurrentForm->getValue("iditens_modulo") : $CurrentForm->getValue("x_iditens_modulo");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->modulo_idmodulo->CurrentValue = $this->modulo_idmodulo->FormValue;
        $this->item->CurrentValue = $this->item->FormValue;
        $this->porcentagem_valor->CurrentValue = $this->porcentagem_valor->FormValue;
        $this->incidencia_inss->CurrentValue = $this->incidencia_inss->FormValue;
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
        $this->iditens_modulo->setDbValue($row['iditens_modulo']);
        $this->modulo_idmodulo->setDbValue($row['modulo_idmodulo']);
        $this->item->setDbValue($row['item']);
        $this->porcentagem_valor->setDbValue($row['porcentagem_valor']);
        $this->incidencia_inss->setDbValue($row['incidencia_inss']);
        $this->ativo->setDbValue($row['ativo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['iditens_modulo'] = $this->iditens_modulo->DefaultValue;
        $row['modulo_idmodulo'] = $this->modulo_idmodulo->DefaultValue;
        $row['item'] = $this->item->DefaultValue;
        $row['porcentagem_valor'] = $this->porcentagem_valor->DefaultValue;
        $row['incidencia_inss'] = $this->incidencia_inss->DefaultValue;
        $row['ativo'] = $this->ativo->DefaultValue;
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

        // iditens_modulo
        $this->iditens_modulo->RowCssClass = "row";

        // modulo_idmodulo
        $this->modulo_idmodulo->RowCssClass = "row";

        // item
        $this->item->RowCssClass = "row";

        // porcentagem_valor
        $this->porcentagem_valor->RowCssClass = "row";

        // incidencia_inss
        $this->incidencia_inss->RowCssClass = "row";

        // ativo
        $this->ativo->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // iditens_modulo
            $this->iditens_modulo->ViewValue = $this->iditens_modulo->CurrentValue;

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

            // item
            $this->item->ViewValue = $this->item->CurrentValue;
            $this->item->CssClass = "fw-bold";

            // porcentagem_valor
            $this->porcentagem_valor->ViewValue = $this->porcentagem_valor->CurrentValue;
            $this->porcentagem_valor->ViewValue = FormatCurrency($this->porcentagem_valor->ViewValue, $this->porcentagem_valor->formatPattern());
            $this->porcentagem_valor->CssClass = "fw-bold";
            $this->porcentagem_valor->CellCssStyle .= "text-align: right;";

            // incidencia_inss
            if (strval($this->incidencia_inss->CurrentValue) != "") {
                $this->incidencia_inss->ViewValue = $this->incidencia_inss->optionCaption($this->incidencia_inss->CurrentValue);
            } else {
                $this->incidencia_inss->ViewValue = null;
            }
            $this->incidencia_inss->CssClass = "fw-bold";
            $this->incidencia_inss->CellCssStyle .= "text-align: center;";

            // ativo
            if (strval($this->ativo->CurrentValue) != "") {
                $this->ativo->ViewValue = $this->ativo->optionCaption($this->ativo->CurrentValue);
            } else {
                $this->ativo->ViewValue = null;
            }
            $this->ativo->CssClass = "fw-bold";
            $this->ativo->CellCssStyle .= "text-align: center;";

            // modulo_idmodulo
            $this->modulo_idmodulo->HrefValue = "";

            // item
            $this->item->HrefValue = "";

            // porcentagem_valor
            $this->porcentagem_valor->HrefValue = "";

            // incidencia_inss
            $this->incidencia_inss->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // modulo_idmodulo
            $this->modulo_idmodulo->setupEditAttributes();
            if ($this->modulo_idmodulo->getSessionValue() != "") {
                $this->modulo_idmodulo->CurrentValue = GetForeignKeyValue($this->modulo_idmodulo->getSessionValue());
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
            } else {
                $curVal = trim(strval($this->modulo_idmodulo->CurrentValue));
                if ($curVal != "") {
                    $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->lookupCacheOption($curVal);
                } else {
                    $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->Lookup !== null && is_array($this->modulo_idmodulo->lookupOptions()) && count($this->modulo_idmodulo->lookupOptions()) > 0 ? $curVal : null;
                }
                if ($this->modulo_idmodulo->ViewValue !== null) { // Load from cache
                    $this->modulo_idmodulo->EditValue = array_values($this->modulo_idmodulo->lookupOptions());
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
                    $arwrk = $rswrk;
                    $this->modulo_idmodulo->EditValue = $arwrk;
                }
                $this->modulo_idmodulo->PlaceHolder = RemoveHtml($this->modulo_idmodulo->caption());
            }

            // item
            $this->item->setupEditAttributes();
            if (!$this->item->Raw) {
                $this->item->CurrentValue = HtmlDecode($this->item->CurrentValue);
            }
            $this->item->EditValue = HtmlEncode($this->item->CurrentValue);
            $this->item->PlaceHolder = RemoveHtml($this->item->caption());

            // porcentagem_valor
            $this->porcentagem_valor->setupEditAttributes();
            $this->porcentagem_valor->EditValue = $this->porcentagem_valor->CurrentValue;
            $this->porcentagem_valor->PlaceHolder = RemoveHtml($this->porcentagem_valor->caption());
            if (strval($this->porcentagem_valor->EditValue) != "" && is_numeric($this->porcentagem_valor->EditValue)) {
                $this->porcentagem_valor->EditValue = FormatNumber($this->porcentagem_valor->EditValue, null);
            }

            // incidencia_inss
            $this->incidencia_inss->EditValue = $this->incidencia_inss->options(false);
            $this->incidencia_inss->PlaceHolder = RemoveHtml($this->incidencia_inss->caption());

            // Add refer script

            // modulo_idmodulo
            $this->modulo_idmodulo->HrefValue = "";

            // item
            $this->item->HrefValue = "";

            // porcentagem_valor
            $this->porcentagem_valor->HrefValue = "";

            // incidencia_inss
            $this->incidencia_inss->HrefValue = "";
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
            if ($this->modulo_idmodulo->Visible && $this->modulo_idmodulo->Required) {
                if (!$this->modulo_idmodulo->IsDetailKey && EmptyValue($this->modulo_idmodulo->FormValue)) {
                    $this->modulo_idmodulo->addErrorMessage(str_replace("%s", $this->modulo_idmodulo->caption(), $this->modulo_idmodulo->RequiredErrorMessage));
                }
            }
            if ($this->item->Visible && $this->item->Required) {
                if (!$this->item->IsDetailKey && EmptyValue($this->item->FormValue)) {
                    $this->item->addErrorMessage(str_replace("%s", $this->item->caption(), $this->item->RequiredErrorMessage));
                }
            }
            if ($this->porcentagem_valor->Visible && $this->porcentagem_valor->Required) {
                if (!$this->porcentagem_valor->IsDetailKey && EmptyValue($this->porcentagem_valor->FormValue)) {
                    $this->porcentagem_valor->addErrorMessage(str_replace("%s", $this->porcentagem_valor->caption(), $this->porcentagem_valor->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->porcentagem_valor->FormValue)) {
                $this->porcentagem_valor->addErrorMessage($this->porcentagem_valor->getErrorMessage(false));
            }
            if ($this->incidencia_inss->Visible && $this->incidencia_inss->Required) {
                if ($this->incidencia_inss->FormValue == "") {
                    $this->incidencia_inss->addErrorMessage(str_replace("%s", $this->incidencia_inss->caption(), $this->incidencia_inss->RequiredErrorMessage));
                }
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

        // Check referential integrity for master table 'itens_modulo'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["modulo_idmodulo"] = $this->modulo_idmodulo->CurrentValue;
        $masterTable = Container("modulo");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "modulo", $Language->phrase("RelatedRecordRequired"));
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

        // modulo_idmodulo
        $this->modulo_idmodulo->setDbValueDef($rsnew, $this->modulo_idmodulo->CurrentValue, false);

        // item
        $this->item->setDbValueDef($rsnew, $this->item->CurrentValue, false);

        // porcentagem_valor
        $this->porcentagem_valor->setDbValueDef($rsnew, $this->porcentagem_valor->CurrentValue, false);

        // incidencia_inss
        $this->incidencia_inss->setDbValueDef($rsnew, $this->incidencia_inss->CurrentValue, strval($this->incidencia_inss->CurrentValue) == "");
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['modulo_idmodulo'])) { // modulo_idmodulo
            $this->modulo_idmodulo->setFormValue($row['modulo_idmodulo']);
        }
        if (isset($row['item'])) { // item
            $this->item->setFormValue($row['item']);
        }
        if (isset($row['porcentagem_valor'])) { // porcentagem_valor
            $this->porcentagem_valor->setFormValue($row['porcentagem_valor']);
        }
        if (isset($row['incidencia_inss'])) { // incidencia_inss
            $this->incidencia_inss->setFormValue($row['incidencia_inss']);
        }
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        $foreignKeys = [];
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "modulo") {
                $validMaster = true;
                $masterTbl = Container("modulo");
                if (($parm = Get("fk_idmodulo", Get("modulo_idmodulo"))) !== null) {
                    $masterTbl->idmodulo->setQueryStringValue($parm);
                    $this->modulo_idmodulo->QueryStringValue = $masterTbl->idmodulo->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->modulo_idmodulo->setSessionValue($this->modulo_idmodulo->QueryStringValue);
                    $foreignKeys["modulo_idmodulo"] = $this->modulo_idmodulo->QueryStringValue;
                    if (!is_numeric($masterTbl->idmodulo->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "modulo") {
                $validMaster = true;
                $masterTbl = Container("modulo");
                if (($parm = Post("fk_idmodulo", Post("modulo_idmodulo"))) !== null) {
                    $masterTbl->idmodulo->setFormValue($parm);
                    $this->modulo_idmodulo->FormValue = $masterTbl->idmodulo->FormValue;
                    $this->modulo_idmodulo->setSessionValue($this->modulo_idmodulo->FormValue);
                    $foreignKeys["modulo_idmodulo"] = $this->modulo_idmodulo->FormValue;
                    if (!is_numeric($masterTbl->idmodulo->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "modulo") {
                if (!array_key_exists("modulo_idmodulo", $foreignKeys)) { // Not current foreign key
                    $this->modulo_idmodulo->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ItensModuloList"), "", $this->TableVar, true);
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
                case "x_modulo_idmodulo":
                    break;
                case "x_incidencia_inss":
                    break;
                case "x_ativo":
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
