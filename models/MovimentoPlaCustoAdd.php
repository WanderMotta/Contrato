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
class MovimentoPlaCustoAdd extends MovimentoPlaCusto
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "MovimentoPlaCustoAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "MovimentoPlaCustoAdd";

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
        $this->dt_cadastro->setVisibility();
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
        $this->TableVar = 'movimento_pla_custo';
        $this->TableName = 'movimento_pla_custo';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (movimento_pla_custo)
        if (!isset($GLOBALS["movimento_pla_custo"]) || $GLOBALS["movimento_pla_custo"]::class == PROJECT_NAMESPACE . "movimento_pla_custo") {
            $GLOBALS["movimento_pla_custo"] = &$this;
        }

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
                        $result["view"] = SameString($pageName, "MovimentoPlaCustoView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->itens_modulo_iditens_modulo);

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
            if (($keyValue = Get("idmovimento_pla_custo") ?? Route("idmovimento_pla_custo")) !== null) {
                $this->idmovimento_pla_custo->setQueryStringValue($keyValue);
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
                    $this->terminate("MovimentoPlaCustoList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "MovimentoPlaCustoList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "MovimentoPlaCustoView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "MovimentoPlaCustoList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "MovimentoPlaCustoList"; // Return list page content
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
        $this->valor->DefaultValue = $this->valor->getDefault(); // PHP
        $this->valor->OldValue = $this->valor->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
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

        // Check field name 'dt_cadastro' first before field var 'x_dt_cadastro'
        $val = $CurrentForm->hasValue("dt_cadastro") ? $CurrentForm->getValue("dt_cadastro") : $CurrentForm->getValue("x_dt_cadastro");
        if (!$this->dt_cadastro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dt_cadastro->Visible = false; // Disable update for API request
            } else {
                $this->dt_cadastro->setFormValue($val);
            }
            $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
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

        // Check field name 'itens_modulo_iditens_modulo' first before field var 'x_itens_modulo_iditens_modulo'
        $val = $CurrentForm->hasValue("itens_modulo_iditens_modulo") ? $CurrentForm->getValue("itens_modulo_iditens_modulo") : $CurrentForm->getValue("x_itens_modulo_iditens_modulo");
        if (!$this->itens_modulo_iditens_modulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->itens_modulo_iditens_modulo->Visible = false; // Disable update for API request
            } else {
                $this->itens_modulo_iditens_modulo->setFormValue($val);
            }
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

        // Check field name 'valor' first before field var 'x_valor'
        $val = $CurrentForm->hasValue("valor") ? $CurrentForm->getValue("valor") : $CurrentForm->getValue("x_valor");
        if (!$this->valor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->valor->Visible = false; // Disable update for API request
            } else {
                $this->valor->setFormValue($val, true, $validate);
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

        // Check field name 'calculo_idcalculo' first before field var 'x_calculo_idcalculo'
        $val = $CurrentForm->hasValue("calculo_idcalculo") ? $CurrentForm->getValue("calculo_idcalculo") : $CurrentForm->getValue("x_calculo_idcalculo");
        if (!$this->calculo_idcalculo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->calculo_idcalculo->Visible = false; // Disable update for API request
            } else {
                $this->calculo_idcalculo->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'idmovimento_pla_custo' first before field var 'x_idmovimento_pla_custo'
        $val = $CurrentForm->hasValue("idmovimento_pla_custo") ? $CurrentForm->getValue("idmovimento_pla_custo") : $CurrentForm->getValue("x_idmovimento_pla_custo");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->planilha_custo_idplanilha_custo->CurrentValue = $this->planilha_custo_idplanilha_custo->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->modulo_idmodulo->CurrentValue = $this->modulo_idmodulo->FormValue;
        $this->itens_modulo_iditens_modulo->CurrentValue = $this->itens_modulo_iditens_modulo->FormValue;
        $this->porcentagem->CurrentValue = $this->porcentagem->FormValue;
        $this->valor->CurrentValue = $this->valor->FormValue;
        $this->obs->CurrentValue = $this->obs->FormValue;
        $this->calculo_idcalculo->CurrentValue = $this->calculo_idcalculo->FormValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // idmovimento_pla_custo
        $this->idmovimento_pla_custo->RowCssClass = "row";

        // planilha_custo_idplanilha_custo
        $this->planilha_custo_idplanilha_custo->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // modulo_idmodulo
        $this->modulo_idmodulo->RowCssClass = "row";

        // itens_modulo_iditens_modulo
        $this->itens_modulo_iditens_modulo->RowCssClass = "row";

        // porcentagem
        $this->porcentagem->RowCssClass = "row";

        // valor
        $this->valor->RowCssClass = "row";

        // obs
        $this->obs->RowCssClass = "row";

        // calculo_idcalculo
        $this->calculo_idcalculo->RowCssClass = "row";

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

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

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
        } elseif ($this->RowType == RowType::ADD) {
            // planilha_custo_idplanilha_custo
            $this->planilha_custo_idplanilha_custo->setupEditAttributes();
            if ($this->planilha_custo_idplanilha_custo->getSessionValue() != "") {
                $this->planilha_custo_idplanilha_custo->CurrentValue = GetForeignKeyValue($this->planilha_custo_idplanilha_custo->getSessionValue());
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

            // dt_cadastro

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

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

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
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
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

        // planilha_custo_idplanilha_custo
        $this->planilha_custo_idplanilha_custo->setDbValueDef($rsnew, $this->planilha_custo_idplanilha_custo->CurrentValue, false);

        // dt_cadastro
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->getAutoUpdateValue(); // PHP
        $this->dt_cadastro->setDbValueDef($rsnew, UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern()), false);

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
        if (isset($row['dt_cadastro'])) { // dt_cadastro
            $this->dt_cadastro->setFormValue($row['dt_cadastro']);
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
            if ($masterTblVar == "planilha_custo") {
                $validMaster = true;
                $masterTbl = Container("planilha_custo");
                if (($parm = Get("fk_idplanilha_custo", Get("planilha_custo_idplanilha_custo"))) !== null) {
                    $masterTbl->idplanilha_custo->setQueryStringValue($parm);
                    $this->planilha_custo_idplanilha_custo->QueryStringValue = $masterTbl->idplanilha_custo->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->planilha_custo_idplanilha_custo->setSessionValue($this->planilha_custo_idplanilha_custo->QueryStringValue);
                    $foreignKeys["planilha_custo_idplanilha_custo"] = $this->planilha_custo_idplanilha_custo->QueryStringValue;
                    if (!is_numeric($masterTbl->idplanilha_custo->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "calculo") {
                $validMaster = true;
                $masterTbl = Container("calculo");
                if (($parm = Get("fk_idcalculo", Get("calculo_idcalculo"))) !== null) {
                    $masterTbl->idcalculo->setQueryStringValue($parm);
                    $this->calculo_idcalculo->QueryStringValue = $masterTbl->idcalculo->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->calculo_idcalculo->setSessionValue($this->calculo_idcalculo->QueryStringValue);
                    $foreignKeys["calculo_idcalculo"] = $this->calculo_idcalculo->QueryStringValue;
                    if (!is_numeric($masterTbl->idcalculo->QueryStringValue)) {
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
            if ($masterTblVar == "planilha_custo") {
                $validMaster = true;
                $masterTbl = Container("planilha_custo");
                if (($parm = Post("fk_idplanilha_custo", Post("planilha_custo_idplanilha_custo"))) !== null) {
                    $masterTbl->idplanilha_custo->setFormValue($parm);
                    $this->planilha_custo_idplanilha_custo->FormValue = $masterTbl->idplanilha_custo->FormValue;
                    $this->planilha_custo_idplanilha_custo->setSessionValue($this->planilha_custo_idplanilha_custo->FormValue);
                    $foreignKeys["planilha_custo_idplanilha_custo"] = $this->planilha_custo_idplanilha_custo->FormValue;
                    if (!is_numeric($masterTbl->idplanilha_custo->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "calculo") {
                $validMaster = true;
                $masterTbl = Container("calculo");
                if (($parm = Post("fk_idcalculo", Post("calculo_idcalculo"))) !== null) {
                    $masterTbl->idcalculo->setFormValue($parm);
                    $this->calculo_idcalculo->FormValue = $masterTbl->idcalculo->FormValue;
                    $this->calculo_idcalculo->setSessionValue($this->calculo_idcalculo->FormValue);
                    $foreignKeys["calculo_idcalculo"] = $this->calculo_idcalculo->FormValue;
                    if (!is_numeric($masterTbl->idcalculo->FormValue)) {
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
            if ($masterTblVar != "planilha_custo") {
                if (!array_key_exists("planilha_custo_idplanilha_custo", $foreignKeys)) { // Not current foreign key
                    $this->planilha_custo_idplanilha_custo->setSessionValue("");
                }
            }
            if ($masterTblVar != "calculo") {
                if (!array_key_exists("calculo_idcalculo", $foreignKeys)) { // Not current foreign key
                    $this->calculo_idcalculo->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("MovimentoPlaCustoList"), "", $this->TableVar, true);
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
}
