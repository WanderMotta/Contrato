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
class FaturamentoAdd extends Faturamento
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "FaturamentoAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "FaturamentoAdd";

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
        $this->idfaturamento->Visible = false;
        $this->faturamento->setVisibility();
        $this->cnpj->setVisibility();
        $this->endereco->setVisibility();
        $this->bairro->setVisibility();
        $this->cidade->setVisibility();
        $this->uf->setVisibility();
        $this->dia_vencimento->setVisibility();
        $this->origem->setVisibility();
        $this->obs->setVisibility();
        $this->cliente_idcliente->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'faturamento';
        $this->TableName = 'faturamento';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (faturamento)
        if (!isset($GLOBALS["faturamento"]) || $GLOBALS["faturamento"]::class == PROJECT_NAMESPACE . "faturamento") {
            $GLOBALS["faturamento"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'faturamento');
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
                        $result["view"] = SameString($pageName, "FaturamentoView"); // If View page, no primary button
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
            $key .= @$ar['idfaturamento'];
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
            $this->idfaturamento->Visible = false;
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
        $this->setupLookupOptions($this->origem);

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
            if (($keyValue = Get("idfaturamento") ?? Route("idfaturamento")) !== null) {
                $this->idfaturamento->setQueryStringValue($keyValue);
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

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("FaturamentoList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "FaturamentoList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "FaturamentoView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "FaturamentoList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "FaturamentoList"; // Return list page content
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->cidade->DefaultValue = $this->cidade->getDefault(); // PHP
        $this->cidade->OldValue = $this->cidade->DefaultValue;
        $this->uf->DefaultValue = $this->uf->getDefault(); // PHP
        $this->uf->OldValue = $this->uf->DefaultValue;
        $this->dia_vencimento->DefaultValue = $this->dia_vencimento->getDefault(); // PHP
        $this->dia_vencimento->OldValue = $this->dia_vencimento->DefaultValue;
        $this->origem->DefaultValue = $this->origem->getDefault(); // PHP
        $this->origem->OldValue = $this->origem->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'faturamento' first before field var 'x_faturamento'
        $val = $CurrentForm->hasValue("faturamento") ? $CurrentForm->getValue("faturamento") : $CurrentForm->getValue("x_faturamento");
        if (!$this->faturamento->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->faturamento->Visible = false; // Disable update for API request
            } else {
                $this->faturamento->setFormValue($val);
            }
        }

        // Check field name 'cnpj' first before field var 'x_cnpj'
        $val = $CurrentForm->hasValue("cnpj") ? $CurrentForm->getValue("cnpj") : $CurrentForm->getValue("x_cnpj");
        if (!$this->cnpj->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cnpj->Visible = false; // Disable update for API request
            } else {
                $this->cnpj->setFormValue($val);
            }
        }

        // Check field name 'endereco' first before field var 'x_endereco'
        $val = $CurrentForm->hasValue("endereco") ? $CurrentForm->getValue("endereco") : $CurrentForm->getValue("x_endereco");
        if (!$this->endereco->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->endereco->Visible = false; // Disable update for API request
            } else {
                $this->endereco->setFormValue($val);
            }
        }

        // Check field name 'bairro' first before field var 'x_bairro'
        $val = $CurrentForm->hasValue("bairro") ? $CurrentForm->getValue("bairro") : $CurrentForm->getValue("x_bairro");
        if (!$this->bairro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bairro->Visible = false; // Disable update for API request
            } else {
                $this->bairro->setFormValue($val);
            }
        }

        // Check field name 'cidade' first before field var 'x_cidade'
        $val = $CurrentForm->hasValue("cidade") ? $CurrentForm->getValue("cidade") : $CurrentForm->getValue("x_cidade");
        if (!$this->cidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cidade->Visible = false; // Disable update for API request
            } else {
                $this->cidade->setFormValue($val);
            }
        }

        // Check field name 'uf' first before field var 'x_uf'
        $val = $CurrentForm->hasValue("uf") ? $CurrentForm->getValue("uf") : $CurrentForm->getValue("x_uf");
        if (!$this->uf->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->uf->Visible = false; // Disable update for API request
            } else {
                $this->uf->setFormValue($val);
            }
        }

        // Check field name 'dia_vencimento' first before field var 'x_dia_vencimento'
        $val = $CurrentForm->hasValue("dia_vencimento") ? $CurrentForm->getValue("dia_vencimento") : $CurrentForm->getValue("x_dia_vencimento");
        if (!$this->dia_vencimento->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dia_vencimento->Visible = false; // Disable update for API request
            } else {
                $this->dia_vencimento->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'origem' first before field var 'x_origem'
        $val = $CurrentForm->hasValue("origem") ? $CurrentForm->getValue("origem") : $CurrentForm->getValue("x_origem");
        if (!$this->origem->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->origem->Visible = false; // Disable update for API request
            } else {
                $this->origem->setFormValue($val);
            }
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

        // Check field name 'cliente_idcliente' first before field var 'x_cliente_idcliente'
        $val = $CurrentForm->hasValue("cliente_idcliente") ? $CurrentForm->getValue("cliente_idcliente") : $CurrentForm->getValue("x_cliente_idcliente");
        if (!$this->cliente_idcliente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cliente_idcliente->Visible = false; // Disable update for API request
            } else {
                $this->cliente_idcliente->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'idfaturamento' first before field var 'x_idfaturamento'
        $val = $CurrentForm->hasValue("idfaturamento") ? $CurrentForm->getValue("idfaturamento") : $CurrentForm->getValue("x_idfaturamento");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->faturamento->CurrentValue = $this->faturamento->FormValue;
        $this->cnpj->CurrentValue = $this->cnpj->FormValue;
        $this->endereco->CurrentValue = $this->endereco->FormValue;
        $this->bairro->CurrentValue = $this->bairro->FormValue;
        $this->cidade->CurrentValue = $this->cidade->FormValue;
        $this->uf->CurrentValue = $this->uf->FormValue;
        $this->dia_vencimento->CurrentValue = $this->dia_vencimento->FormValue;
        $this->origem->CurrentValue = $this->origem->FormValue;
        $this->obs->CurrentValue = $this->obs->FormValue;
        $this->cliente_idcliente->CurrentValue = $this->cliente_idcliente->FormValue;
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
        $this->idfaturamento->setDbValue($row['idfaturamento']);
        $this->faturamento->setDbValue($row['faturamento']);
        $this->cnpj->setDbValue($row['cnpj']);
        $this->endereco->setDbValue($row['endereco']);
        $this->bairro->setDbValue($row['bairro']);
        $this->cidade->setDbValue($row['cidade']);
        $this->uf->setDbValue($row['uf']);
        $this->dia_vencimento->setDbValue($row['dia_vencimento']);
        $this->origem->setDbValue($row['origem']);
        $this->obs->setDbValue($row['obs']);
        $this->cliente_idcliente->setDbValue($row['cliente_idcliente']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idfaturamento'] = $this->idfaturamento->DefaultValue;
        $row['faturamento'] = $this->faturamento->DefaultValue;
        $row['cnpj'] = $this->cnpj->DefaultValue;
        $row['endereco'] = $this->endereco->DefaultValue;
        $row['bairro'] = $this->bairro->DefaultValue;
        $row['cidade'] = $this->cidade->DefaultValue;
        $row['uf'] = $this->uf->DefaultValue;
        $row['dia_vencimento'] = $this->dia_vencimento->DefaultValue;
        $row['origem'] = $this->origem->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
        $row['cliente_idcliente'] = $this->cliente_idcliente->DefaultValue;
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

        // idfaturamento
        $this->idfaturamento->RowCssClass = "row";

        // faturamento
        $this->faturamento->RowCssClass = "row";

        // cnpj
        $this->cnpj->RowCssClass = "row";

        // endereco
        $this->endereco->RowCssClass = "row";

        // bairro
        $this->bairro->RowCssClass = "row";

        // cidade
        $this->cidade->RowCssClass = "row";

        // uf
        $this->uf->RowCssClass = "row";

        // dia_vencimento
        $this->dia_vencimento->RowCssClass = "row";

        // origem
        $this->origem->RowCssClass = "row";

        // obs
        $this->obs->RowCssClass = "row";

        // cliente_idcliente
        $this->cliente_idcliente->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idfaturamento
            $this->idfaturamento->ViewValue = $this->idfaturamento->CurrentValue;

            // faturamento
            $this->faturamento->ViewValue = $this->faturamento->CurrentValue;
            $this->faturamento->CssClass = "fw-bold";

            // cnpj
            $this->cnpj->ViewValue = $this->cnpj->CurrentValue;
            $this->cnpj->CssClass = "fw-bold";

            // endereco
            $this->endereco->ViewValue = $this->endereco->CurrentValue;
            $this->endereco->CssClass = "fw-bold";

            // bairro
            $this->bairro->ViewValue = $this->bairro->CurrentValue;
            $this->bairro->CssClass = "fw-bold";

            // cidade
            $this->cidade->ViewValue = $this->cidade->CurrentValue;
            $this->cidade->CssClass = "fw-bold";

            // uf
            $this->uf->ViewValue = $this->uf->CurrentValue;
            $this->uf->CssClass = "fw-bold";

            // dia_vencimento
            $this->dia_vencimento->ViewValue = $this->dia_vencimento->CurrentValue;
            $this->dia_vencimento->ViewValue = FormatNumber($this->dia_vencimento->ViewValue, $this->dia_vencimento->formatPattern());
            $this->dia_vencimento->CssClass = "fw-bold";
            $this->dia_vencimento->CellCssStyle .= "text-align: center;";

            // origem
            if (strval($this->origem->CurrentValue) != "") {
                $this->origem->ViewValue = $this->origem->optionCaption($this->origem->CurrentValue);
            } else {
                $this->origem->ViewValue = null;
            }
            $this->origem->CssClass = "fw-bold";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->CssClass = "fw-bold";

            // cliente_idcliente
            $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->CurrentValue;
            $this->cliente_idcliente->ViewValue = FormatNumber($this->cliente_idcliente->ViewValue, $this->cliente_idcliente->formatPattern());
            $this->cliente_idcliente->CssClass = "fw-bold";
            $this->cliente_idcliente->CellCssStyle .= "text-align: center;";

            // faturamento
            $this->faturamento->HrefValue = "";

            // cnpj
            $this->cnpj->HrefValue = "";

            // endereco
            $this->endereco->HrefValue = "";

            // bairro
            $this->bairro->HrefValue = "";

            // cidade
            $this->cidade->HrefValue = "";

            // uf
            $this->uf->HrefValue = "";

            // dia_vencimento
            $this->dia_vencimento->HrefValue = "";

            // origem
            $this->origem->HrefValue = "";

            // obs
            $this->obs->HrefValue = "";

            // cliente_idcliente
            $this->cliente_idcliente->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // faturamento
            $this->faturamento->setupEditAttributes();
            if (!$this->faturamento->Raw) {
                $this->faturamento->CurrentValue = HtmlDecode($this->faturamento->CurrentValue);
            }
            $this->faturamento->EditValue = HtmlEncode($this->faturamento->CurrentValue);
            $this->faturamento->PlaceHolder = RemoveHtml($this->faturamento->caption());

            // cnpj
            $this->cnpj->setupEditAttributes();
            if (!$this->cnpj->Raw) {
                $this->cnpj->CurrentValue = HtmlDecode($this->cnpj->CurrentValue);
            }
            $this->cnpj->EditValue = HtmlEncode($this->cnpj->CurrentValue);
            $this->cnpj->PlaceHolder = RemoveHtml($this->cnpj->caption());

            // endereco
            $this->endereco->setupEditAttributes();
            if (!$this->endereco->Raw) {
                $this->endereco->CurrentValue = HtmlDecode($this->endereco->CurrentValue);
            }
            $this->endereco->EditValue = HtmlEncode($this->endereco->CurrentValue);
            $this->endereco->PlaceHolder = RemoveHtml($this->endereco->caption());

            // bairro
            $this->bairro->setupEditAttributes();
            if (!$this->bairro->Raw) {
                $this->bairro->CurrentValue = HtmlDecode($this->bairro->CurrentValue);
            }
            $this->bairro->EditValue = HtmlEncode($this->bairro->CurrentValue);
            $this->bairro->PlaceHolder = RemoveHtml($this->bairro->caption());

            // cidade
            $this->cidade->setupEditAttributes();
            if (!$this->cidade->Raw) {
                $this->cidade->CurrentValue = HtmlDecode($this->cidade->CurrentValue);
            }
            $this->cidade->EditValue = HtmlEncode($this->cidade->CurrentValue);
            $this->cidade->PlaceHolder = RemoveHtml($this->cidade->caption());

            // uf
            $this->uf->setupEditAttributes();
            if (!$this->uf->Raw) {
                $this->uf->CurrentValue = HtmlDecode($this->uf->CurrentValue);
            }
            $this->uf->EditValue = HtmlEncode($this->uf->CurrentValue);
            $this->uf->PlaceHolder = RemoveHtml($this->uf->caption());

            // dia_vencimento
            $this->dia_vencimento->setupEditAttributes();
            $this->dia_vencimento->EditValue = $this->dia_vencimento->CurrentValue;
            $this->dia_vencimento->PlaceHolder = RemoveHtml($this->dia_vencimento->caption());
            if (strval($this->dia_vencimento->EditValue) != "" && is_numeric($this->dia_vencimento->EditValue)) {
                $this->dia_vencimento->EditValue = FormatNumber($this->dia_vencimento->EditValue, null);
            }

            // origem
            $this->origem->EditValue = $this->origem->options(false);
            $this->origem->PlaceHolder = RemoveHtml($this->origem->caption());

            // obs
            $this->obs->setupEditAttributes();
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // cliente_idcliente
            $this->cliente_idcliente->setupEditAttributes();
            if ($this->cliente_idcliente->getSessionValue() != "") {
                $this->cliente_idcliente->CurrentValue = GetForeignKeyValue($this->cliente_idcliente->getSessionValue());
                $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->CurrentValue;
                $this->cliente_idcliente->ViewValue = FormatNumber($this->cliente_idcliente->ViewValue, $this->cliente_idcliente->formatPattern());
                $this->cliente_idcliente->CssClass = "fw-bold";
                $this->cliente_idcliente->CellCssStyle .= "text-align: center;";
            } else {
                $this->cliente_idcliente->EditValue = $this->cliente_idcliente->CurrentValue;
                $this->cliente_idcliente->PlaceHolder = RemoveHtml($this->cliente_idcliente->caption());
                if (strval($this->cliente_idcliente->EditValue) != "" && is_numeric($this->cliente_idcliente->EditValue)) {
                    $this->cliente_idcliente->EditValue = FormatNumber($this->cliente_idcliente->EditValue, null);
                }
            }

            // Add refer script

            // faturamento
            $this->faturamento->HrefValue = "";

            // cnpj
            $this->cnpj->HrefValue = "";

            // endereco
            $this->endereco->HrefValue = "";

            // bairro
            $this->bairro->HrefValue = "";

            // cidade
            $this->cidade->HrefValue = "";

            // uf
            $this->uf->HrefValue = "";

            // dia_vencimento
            $this->dia_vencimento->HrefValue = "";

            // origem
            $this->origem->HrefValue = "";

            // obs
            $this->obs->HrefValue = "";

            // cliente_idcliente
            $this->cliente_idcliente->HrefValue = "";
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
            if ($this->faturamento->Visible && $this->faturamento->Required) {
                if (!$this->faturamento->IsDetailKey && EmptyValue($this->faturamento->FormValue)) {
                    $this->faturamento->addErrorMessage(str_replace("%s", $this->faturamento->caption(), $this->faturamento->RequiredErrorMessage));
                }
            }
            if ($this->cnpj->Visible && $this->cnpj->Required) {
                if (!$this->cnpj->IsDetailKey && EmptyValue($this->cnpj->FormValue)) {
                    $this->cnpj->addErrorMessage(str_replace("%s", $this->cnpj->caption(), $this->cnpj->RequiredErrorMessage));
                }
            }
            if ($this->endereco->Visible && $this->endereco->Required) {
                if (!$this->endereco->IsDetailKey && EmptyValue($this->endereco->FormValue)) {
                    $this->endereco->addErrorMessage(str_replace("%s", $this->endereco->caption(), $this->endereco->RequiredErrorMessage));
                }
            }
            if ($this->bairro->Visible && $this->bairro->Required) {
                if (!$this->bairro->IsDetailKey && EmptyValue($this->bairro->FormValue)) {
                    $this->bairro->addErrorMessage(str_replace("%s", $this->bairro->caption(), $this->bairro->RequiredErrorMessage));
                }
            }
            if ($this->cidade->Visible && $this->cidade->Required) {
                if (!$this->cidade->IsDetailKey && EmptyValue($this->cidade->FormValue)) {
                    $this->cidade->addErrorMessage(str_replace("%s", $this->cidade->caption(), $this->cidade->RequiredErrorMessage));
                }
            }
            if ($this->uf->Visible && $this->uf->Required) {
                if (!$this->uf->IsDetailKey && EmptyValue($this->uf->FormValue)) {
                    $this->uf->addErrorMessage(str_replace("%s", $this->uf->caption(), $this->uf->RequiredErrorMessage));
                }
            }
            if ($this->dia_vencimento->Visible && $this->dia_vencimento->Required) {
                if (!$this->dia_vencimento->IsDetailKey && EmptyValue($this->dia_vencimento->FormValue)) {
                    $this->dia_vencimento->addErrorMessage(str_replace("%s", $this->dia_vencimento->caption(), $this->dia_vencimento->RequiredErrorMessage));
                }
            }
            if (!CheckRange($this->dia_vencimento->FormValue, 1, 30)) {
                $this->dia_vencimento->addErrorMessage($this->dia_vencimento->getErrorMessage(false));
            }
            if ($this->origem->Visible && $this->origem->Required) {
                if ($this->origem->FormValue == "") {
                    $this->origem->addErrorMessage(str_replace("%s", $this->origem->caption(), $this->origem->RequiredErrorMessage));
                }
            }
            if ($this->obs->Visible && $this->obs->Required) {
                if (!$this->obs->IsDetailKey && EmptyValue($this->obs->FormValue)) {
                    $this->obs->addErrorMessage(str_replace("%s", $this->obs->caption(), $this->obs->RequiredErrorMessage));
                }
            }
            if ($this->cliente_idcliente->Visible && $this->cliente_idcliente->Required) {
                if (!$this->cliente_idcliente->IsDetailKey && EmptyValue($this->cliente_idcliente->FormValue)) {
                    $this->cliente_idcliente->addErrorMessage(str_replace("%s", $this->cliente_idcliente->caption(), $this->cliente_idcliente->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->cliente_idcliente->FormValue)) {
                $this->cliente_idcliente->addErrorMessage($this->cliente_idcliente->getErrorMessage(false));
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ContatoGrid");
        if (in_array("contato", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

        // Check referential integrity for master table 'faturamento'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["cliente_idcliente"] = $this->cliente_idcliente->CurrentValue;
        $masterTable = Container("cliente");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "cliente", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("ContatoGrid");
            if (in_array("contato", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->faturamento_idfaturamento->setSessionValue($this->idfaturamento->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "contato"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->faturamento_idfaturamento->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                if ($this->UseTransaction) { // Commit transaction
                    if ($conn->isTransactionActive()) {
                        $conn->commit();
                    }
                }
            } else {
                if ($this->UseTransaction) { // Rollback transaction
                    if ($conn->isTransactionActive()) {
                        $conn->rollback();
                    }
                }
            }
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

        // faturamento
        $this->faturamento->setDbValueDef($rsnew, $this->faturamento->CurrentValue, false);

        // cnpj
        $this->cnpj->setDbValueDef($rsnew, $this->cnpj->CurrentValue, false);

        // endereco
        $this->endereco->setDbValueDef($rsnew, $this->endereco->CurrentValue, false);

        // bairro
        $this->bairro->setDbValueDef($rsnew, $this->bairro->CurrentValue, false);

        // cidade
        $this->cidade->setDbValueDef($rsnew, $this->cidade->CurrentValue, strval($this->cidade->CurrentValue) == "");

        // uf
        $this->uf->setDbValueDef($rsnew, $this->uf->CurrentValue, strval($this->uf->CurrentValue) == "");

        // dia_vencimento
        $this->dia_vencimento->setDbValueDef($rsnew, $this->dia_vencimento->CurrentValue, strval($this->dia_vencimento->CurrentValue) == "");

        // origem
        $this->origem->setDbValueDef($rsnew, $this->origem->CurrentValue, strval($this->origem->CurrentValue) == "");

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, false);

        // cliente_idcliente
        $this->cliente_idcliente->setDbValueDef($rsnew, $this->cliente_idcliente->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['faturamento'])) { // faturamento
            $this->faturamento->setFormValue($row['faturamento']);
        }
        if (isset($row['cnpj'])) { // cnpj
            $this->cnpj->setFormValue($row['cnpj']);
        }
        if (isset($row['endereco'])) { // endereco
            $this->endereco->setFormValue($row['endereco']);
        }
        if (isset($row['bairro'])) { // bairro
            $this->bairro->setFormValue($row['bairro']);
        }
        if (isset($row['cidade'])) { // cidade
            $this->cidade->setFormValue($row['cidade']);
        }
        if (isset($row['uf'])) { // uf
            $this->uf->setFormValue($row['uf']);
        }
        if (isset($row['dia_vencimento'])) { // dia_vencimento
            $this->dia_vencimento->setFormValue($row['dia_vencimento']);
        }
        if (isset($row['origem'])) { // origem
            $this->origem->setFormValue($row['origem']);
        }
        if (isset($row['obs'])) { // obs
            $this->obs->setFormValue($row['obs']);
        }
        if (isset($row['cliente_idcliente'])) { // cliente_idcliente
            $this->cliente_idcliente->setFormValue($row['cliente_idcliente']);
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
            if ($masterTblVar == "cliente") {
                $validMaster = true;
                $masterTbl = Container("cliente");
                if (($parm = Get("fk_idcliente", Get("cliente_idcliente"))) !== null) {
                    $masterTbl->idcliente->setQueryStringValue($parm);
                    $this->cliente_idcliente->QueryStringValue = $masterTbl->idcliente->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->cliente_idcliente->setSessionValue($this->cliente_idcliente->QueryStringValue);
                    $foreignKeys["cliente_idcliente"] = $this->cliente_idcliente->QueryStringValue;
                    if (!is_numeric($masterTbl->idcliente->QueryStringValue)) {
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
            if ($masterTblVar == "cliente") {
                $validMaster = true;
                $masterTbl = Container("cliente");
                if (($parm = Post("fk_idcliente", Post("cliente_idcliente"))) !== null) {
                    $masterTbl->idcliente->setFormValue($parm);
                    $this->cliente_idcliente->FormValue = $masterTbl->idcliente->FormValue;
                    $this->cliente_idcliente->setSessionValue($this->cliente_idcliente->FormValue);
                    $foreignKeys["cliente_idcliente"] = $this->cliente_idcliente->FormValue;
                    if (!is_numeric($masterTbl->idcliente->FormValue)) {
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
            if ($masterTblVar != "cliente") {
                if (!array_key_exists("cliente_idcliente", $foreignKeys)) { // Not current foreign key
                    $this->cliente_idcliente->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("contato", $detailTblVar)) {
                $detailPageObj = Container("ContatoGrid");
                if ($detailPageObj->DetailAdd) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->faturamento_idfaturamento->IsDetailKey = true;
                    $detailPageObj->faturamento_idfaturamento->CurrentValue = $this->idfaturamento->CurrentValue;
                    $detailPageObj->faturamento_idfaturamento->setSessionValue($detailPageObj->faturamento_idfaturamento->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FaturamentoList"), "", $this->TableVar, true);
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
                case "x_origem":
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
