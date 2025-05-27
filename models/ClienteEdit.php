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
class ClienteEdit extends Cliente
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ClienteEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ClienteEdit";

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
        $this->idcliente->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->cliente->setVisibility();
        $this->local_idlocal->setVisibility();
        $this->cnpj->setVisibility();
        $this->endereco->setVisibility();
        $this->numero->setVisibility();
        $this->bairro->setVisibility();
        $this->cep->setVisibility();
        $this->cidade->setVisibility();
        $this->uf->setVisibility();
        $this->contato->setVisibility();
        $this->_email->setVisibility();
        $this->telefone->setVisibility();
        $this->ativo->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'cliente';
        $this->TableName = 'cliente';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (cliente)
        if (!isset($GLOBALS["cliente"]) || $GLOBALS["cliente"]::class == PROJECT_NAMESPACE . "cliente") {
            $GLOBALS["cliente"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'cliente');
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
                        $result["view"] = SameString($pageName, "ClienteView"); // If View page, no primary button
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
            $key .= @$ar['idcliente'];
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
            $this->idcliente->Visible = false;
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form overlay-wrapper";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->setupLookupOptions($this->local_idlocal);
        $this->setupLookupOptions($this->ativo);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("idcliente") ?? Key(0) ?? Route(2)) !== null) {
                $this->idcliente->setQueryStringValue($keyValue);
                $this->idcliente->setOldValue($this->idcliente->QueryStringValue);
            } elseif (Post("idcliente") !== null) {
                $this->idcliente->setFormValue(Post("idcliente"));
                $this->idcliente->setOldValue($this->idcliente->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action", "") !== "") {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("idcliente") ?? Route("idcliente")) !== null) {
                    $this->idcliente->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idcliente->CurrentValue = null;
                }
            }

            // Load result set
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Set up detail parameters
            $this->setupDetailParms();
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ClienteList"); // No matching record, return to list
                        return;
                    }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "ClienteList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ClienteList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ClienteList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
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
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = RowType::EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'idcliente' first before field var 'x_idcliente'
        $val = $CurrentForm->hasValue("idcliente") ? $CurrentForm->getValue("idcliente") : $CurrentForm->getValue("x_idcliente");
        if (!$this->idcliente->IsDetailKey) {
            $this->idcliente->setFormValue($val);
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

        // Check field name 'cliente' first before field var 'x_cliente'
        $val = $CurrentForm->hasValue("cliente") ? $CurrentForm->getValue("cliente") : $CurrentForm->getValue("x_cliente");
        if (!$this->cliente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cliente->Visible = false; // Disable update for API request
            } else {
                $this->cliente->setFormValue($val);
            }
        }

        // Check field name 'local_idlocal' first before field var 'x_local_idlocal'
        $val = $CurrentForm->hasValue("local_idlocal") ? $CurrentForm->getValue("local_idlocal") : $CurrentForm->getValue("x_local_idlocal");
        if (!$this->local_idlocal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->local_idlocal->Visible = false; // Disable update for API request
            } else {
                $this->local_idlocal->setFormValue($val);
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

        // Check field name 'numero' first before field var 'x_numero'
        $val = $CurrentForm->hasValue("numero") ? $CurrentForm->getValue("numero") : $CurrentForm->getValue("x_numero");
        if (!$this->numero->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->numero->Visible = false; // Disable update for API request
            } else {
                $this->numero->setFormValue($val);
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

        // Check field name 'cep' first before field var 'x_cep'
        $val = $CurrentForm->hasValue("cep") ? $CurrentForm->getValue("cep") : $CurrentForm->getValue("x_cep");
        if (!$this->cep->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cep->Visible = false; // Disable update for API request
            } else {
                $this->cep->setFormValue($val);
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

        // Check field name 'contato' first before field var 'x_contato'
        $val = $CurrentForm->hasValue("contato") ? $CurrentForm->getValue("contato") : $CurrentForm->getValue("x_contato");
        if (!$this->contato->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contato->Visible = false; // Disable update for API request
            } else {
                $this->contato->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'telefone' first before field var 'x_telefone'
        $val = $CurrentForm->hasValue("telefone") ? $CurrentForm->getValue("telefone") : $CurrentForm->getValue("x_telefone");
        if (!$this->telefone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefone->Visible = false; // Disable update for API request
            } else {
                $this->telefone->setFormValue($val);
            }
        }

        // Check field name 'ativo' first before field var 'x_ativo'
        $val = $CurrentForm->hasValue("ativo") ? $CurrentForm->getValue("ativo") : $CurrentForm->getValue("x_ativo");
        if (!$this->ativo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ativo->Visible = false; // Disable update for API request
            } else {
                $this->ativo->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idcliente->CurrentValue = $this->idcliente->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->cliente->CurrentValue = $this->cliente->FormValue;
        $this->local_idlocal->CurrentValue = $this->local_idlocal->FormValue;
        $this->cnpj->CurrentValue = $this->cnpj->FormValue;
        $this->endereco->CurrentValue = $this->endereco->FormValue;
        $this->numero->CurrentValue = $this->numero->FormValue;
        $this->bairro->CurrentValue = $this->bairro->FormValue;
        $this->cep->CurrentValue = $this->cep->FormValue;
        $this->cidade->CurrentValue = $this->cidade->FormValue;
        $this->uf->CurrentValue = $this->uf->FormValue;
        $this->contato->CurrentValue = $this->contato->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->telefone->CurrentValue = $this->telefone->FormValue;
        $this->ativo->CurrentValue = $this->ativo->FormValue;
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
        $this->idcliente->setDbValue($row['idcliente']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->cliente->setDbValue($row['cliente']);
        $this->local_idlocal->setDbValue($row['local_idlocal']);
        $this->cnpj->setDbValue($row['cnpj']);
        $this->endereco->setDbValue($row['endereco']);
        $this->numero->setDbValue($row['numero']);
        $this->bairro->setDbValue($row['bairro']);
        $this->cep->setDbValue($row['cep']);
        $this->cidade->setDbValue($row['cidade']);
        $this->uf->setDbValue($row['uf']);
        $this->contato->setDbValue($row['contato']);
        $this->_email->setDbValue($row['email']);
        $this->telefone->setDbValue($row['telefone']);
        $this->ativo->setDbValue($row['ativo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idcliente'] = $this->idcliente->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['cliente'] = $this->cliente->DefaultValue;
        $row['local_idlocal'] = $this->local_idlocal->DefaultValue;
        $row['cnpj'] = $this->cnpj->DefaultValue;
        $row['endereco'] = $this->endereco->DefaultValue;
        $row['numero'] = $this->numero->DefaultValue;
        $row['bairro'] = $this->bairro->DefaultValue;
        $row['cep'] = $this->cep->DefaultValue;
        $row['cidade'] = $this->cidade->DefaultValue;
        $row['uf'] = $this->uf->DefaultValue;
        $row['contato'] = $this->contato->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['telefone'] = $this->telefone->DefaultValue;
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

        // idcliente
        $this->idcliente->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // cliente
        $this->cliente->RowCssClass = "row";

        // local_idlocal
        $this->local_idlocal->RowCssClass = "row";

        // cnpj
        $this->cnpj->RowCssClass = "row";

        // endereco
        $this->endereco->RowCssClass = "row";

        // numero
        $this->numero->RowCssClass = "row";

        // bairro
        $this->bairro->RowCssClass = "row";

        // cep
        $this->cep->RowCssClass = "row";

        // cidade
        $this->cidade->RowCssClass = "row";

        // uf
        $this->uf->RowCssClass = "row";

        // contato
        $this->contato->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // telefone
        $this->telefone->RowCssClass = "row";

        // ativo
        $this->ativo->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idcliente
            $this->idcliente->ViewValue = $this->idcliente->CurrentValue;

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // cliente
            $this->cliente->ViewValue = $this->cliente->CurrentValue;
            $this->cliente->CssClass = "fw-bold";

            // local_idlocal
            $curVal = strval($this->local_idlocal->CurrentValue);
            if ($curVal != "") {
                $this->local_idlocal->ViewValue = $this->local_idlocal->lookupCacheOption($curVal);
                if ($this->local_idlocal->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->local_idlocal->Lookup->getTable()->Fields["idlocal"]->searchExpression(), "=", $curVal, $this->local_idlocal->Lookup->getTable()->Fields["idlocal"]->searchDataType(), "");
                    $sqlWrk = $this->local_idlocal->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->local_idlocal->Lookup->renderViewRow($rswrk[0]);
                        $this->local_idlocal->ViewValue = $this->local_idlocal->displayValue($arwrk);
                    } else {
                        $this->local_idlocal->ViewValue = FormatNumber($this->local_idlocal->CurrentValue, $this->local_idlocal->formatPattern());
                    }
                }
            } else {
                $this->local_idlocal->ViewValue = null;
            }
            $this->local_idlocal->CssClass = "fw-bold";

            // cnpj
            $this->cnpj->ViewValue = $this->cnpj->CurrentValue;
            $this->cnpj->CssClass = "fw-bold";

            // endereco
            $this->endereco->ViewValue = $this->endereco->CurrentValue;
            $this->endereco->CssClass = "fw-bold";

            // numero
            $this->numero->ViewValue = $this->numero->CurrentValue;
            $this->numero->CssClass = "fw-bold";

            // bairro
            $this->bairro->ViewValue = $this->bairro->CurrentValue;
            $this->bairro->CssClass = "fw-bold";

            // cep
            $this->cep->ViewValue = $this->cep->CurrentValue;
            $this->cep->CssClass = "fw-bold";

            // cidade
            $this->cidade->ViewValue = $this->cidade->CurrentValue;
            $this->cidade->CssClass = "fw-bold";

            // uf
            $this->uf->ViewValue = $this->uf->CurrentValue;
            $this->uf->CssClass = "fw-bold";

            // contato
            $this->contato->ViewValue = $this->contato->CurrentValue;
            $this->contato->CssClass = "fw-bold";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->CssClass = "fw-bold";

            // telefone
            $this->telefone->ViewValue = $this->telefone->CurrentValue;
            $this->telefone->CssClass = "fw-bold";

            // ativo
            if (strval($this->ativo->CurrentValue) != "") {
                $this->ativo->ViewValue = $this->ativo->optionCaption($this->ativo->CurrentValue);
            } else {
                $this->ativo->ViewValue = null;
            }
            $this->ativo->CssClass = "fw-bold";
            $this->ativo->CellCssStyle .= "text-align: center;";

            // idcliente
            $this->idcliente->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // cliente
            $this->cliente->HrefValue = "";

            // local_idlocal
            $this->local_idlocal->HrefValue = "";

            // cnpj
            $this->cnpj->HrefValue = "";

            // endereco
            $this->endereco->HrefValue = "";

            // numero
            $this->numero->HrefValue = "";

            // bairro
            $this->bairro->HrefValue = "";

            // cep
            $this->cep->HrefValue = "";

            // cidade
            $this->cidade->HrefValue = "";

            // uf
            $this->uf->HrefValue = "";

            // contato
            $this->contato->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // telefone
            $this->telefone->HrefValue = "";

            // ativo
            $this->ativo->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // idcliente
            $this->idcliente->setupEditAttributes();
            $this->idcliente->EditValue = $this->idcliente->CurrentValue;

            // dt_cadastro

            // cliente
            $this->cliente->setupEditAttributes();
            if (!$this->cliente->Raw) {
                $this->cliente->CurrentValue = HtmlDecode($this->cliente->CurrentValue);
            }
            $this->cliente->EditValue = HtmlEncode($this->cliente->CurrentValue);
            $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());

            // local_idlocal
            $curVal = trim(strval($this->local_idlocal->CurrentValue));
            if ($curVal != "") {
                $this->local_idlocal->ViewValue = $this->local_idlocal->lookupCacheOption($curVal);
            } else {
                $this->local_idlocal->ViewValue = $this->local_idlocal->Lookup !== null && is_array($this->local_idlocal->lookupOptions()) && count($this->local_idlocal->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->local_idlocal->ViewValue !== null) { // Load from cache
                $this->local_idlocal->EditValue = array_values($this->local_idlocal->lookupOptions());
                if ($this->local_idlocal->ViewValue == "") {
                    $this->local_idlocal->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->local_idlocal->Lookup->getTable()->Fields["idlocal"]->searchExpression(), "=", $this->local_idlocal->CurrentValue, $this->local_idlocal->Lookup->getTable()->Fields["idlocal"]->searchDataType(), "");
                }
                $sqlWrk = $this->local_idlocal->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->local_idlocal->Lookup->renderViewRow($rswrk[0]);
                    $this->local_idlocal->ViewValue = $this->local_idlocal->displayValue($arwrk);
                } else {
                    $this->local_idlocal->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->local_idlocal->EditValue = $arwrk;
            }
            $this->local_idlocal->PlaceHolder = RemoveHtml($this->local_idlocal->caption());

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

            // numero
            $this->numero->setupEditAttributes();
            if (!$this->numero->Raw) {
                $this->numero->CurrentValue = HtmlDecode($this->numero->CurrentValue);
            }
            $this->numero->EditValue = HtmlEncode($this->numero->CurrentValue);
            $this->numero->PlaceHolder = RemoveHtml($this->numero->caption());

            // bairro
            $this->bairro->setupEditAttributes();
            if (!$this->bairro->Raw) {
                $this->bairro->CurrentValue = HtmlDecode($this->bairro->CurrentValue);
            }
            $this->bairro->EditValue = HtmlEncode($this->bairro->CurrentValue);
            $this->bairro->PlaceHolder = RemoveHtml($this->bairro->caption());

            // cep
            $this->cep->setupEditAttributes();
            if (!$this->cep->Raw) {
                $this->cep->CurrentValue = HtmlDecode($this->cep->CurrentValue);
            }
            $this->cep->EditValue = HtmlEncode($this->cep->CurrentValue);
            $this->cep->PlaceHolder = RemoveHtml($this->cep->caption());

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

            // contato
            $this->contato->setupEditAttributes();
            if (!$this->contato->Raw) {
                $this->contato->CurrentValue = HtmlDecode($this->contato->CurrentValue);
            }
            $this->contato->EditValue = HtmlEncode($this->contato->CurrentValue);
            $this->contato->PlaceHolder = RemoveHtml($this->contato->caption());

            // email
            $this->_email->setupEditAttributes();
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // telefone
            $this->telefone->setupEditAttributes();
            if (!$this->telefone->Raw) {
                $this->telefone->CurrentValue = HtmlDecode($this->telefone->CurrentValue);
            }
            $this->telefone->EditValue = HtmlEncode($this->telefone->CurrentValue);
            $this->telefone->PlaceHolder = RemoveHtml($this->telefone->caption());

            // ativo
            $this->ativo->EditValue = $this->ativo->options(false);
            $this->ativo->PlaceHolder = RemoveHtml($this->ativo->caption());

            // Edit refer script

            // idcliente
            $this->idcliente->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // cliente
            $this->cliente->HrefValue = "";

            // local_idlocal
            $this->local_idlocal->HrefValue = "";

            // cnpj
            $this->cnpj->HrefValue = "";

            // endereco
            $this->endereco->HrefValue = "";

            // numero
            $this->numero->HrefValue = "";

            // bairro
            $this->bairro->HrefValue = "";

            // cep
            $this->cep->HrefValue = "";

            // cidade
            $this->cidade->HrefValue = "";

            // uf
            $this->uf->HrefValue = "";

            // contato
            $this->contato->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // telefone
            $this->telefone->HrefValue = "";

            // ativo
            $this->ativo->HrefValue = "";
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
            if ($this->idcliente->Visible && $this->idcliente->Required) {
                if (!$this->idcliente->IsDetailKey && EmptyValue($this->idcliente->FormValue)) {
                    $this->idcliente->addErrorMessage(str_replace("%s", $this->idcliente->caption(), $this->idcliente->RequiredErrorMessage));
                }
            }
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
            }
            if ($this->cliente->Visible && $this->cliente->Required) {
                if (!$this->cliente->IsDetailKey && EmptyValue($this->cliente->FormValue)) {
                    $this->cliente->addErrorMessage(str_replace("%s", $this->cliente->caption(), $this->cliente->RequiredErrorMessage));
                }
            }
            if ($this->local_idlocal->Visible && $this->local_idlocal->Required) {
                if (!$this->local_idlocal->IsDetailKey && EmptyValue($this->local_idlocal->FormValue)) {
                    $this->local_idlocal->addErrorMessage(str_replace("%s", $this->local_idlocal->caption(), $this->local_idlocal->RequiredErrorMessage));
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
            if ($this->numero->Visible && $this->numero->Required) {
                if (!$this->numero->IsDetailKey && EmptyValue($this->numero->FormValue)) {
                    $this->numero->addErrorMessage(str_replace("%s", $this->numero->caption(), $this->numero->RequiredErrorMessage));
                }
            }
            if ($this->bairro->Visible && $this->bairro->Required) {
                if (!$this->bairro->IsDetailKey && EmptyValue($this->bairro->FormValue)) {
                    $this->bairro->addErrorMessage(str_replace("%s", $this->bairro->caption(), $this->bairro->RequiredErrorMessage));
                }
            }
            if ($this->cep->Visible && $this->cep->Required) {
                if (!$this->cep->IsDetailKey && EmptyValue($this->cep->FormValue)) {
                    $this->cep->addErrorMessage(str_replace("%s", $this->cep->caption(), $this->cep->RequiredErrorMessage));
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
            if ($this->contato->Visible && $this->contato->Required) {
                if (!$this->contato->IsDetailKey && EmptyValue($this->contato->FormValue)) {
                    $this->contato->addErrorMessage(str_replace("%s", $this->contato->caption(), $this->contato->RequiredErrorMessage));
                }
            }
            if ($this->_email->Visible && $this->_email->Required) {
                if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                    $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
                }
            }
            if (!CheckEmail($this->_email->FormValue)) {
                $this->_email->addErrorMessage($this->_email->getErrorMessage(false));
            }
            if ($this->telefone->Visible && $this->telefone->Required) {
                if (!$this->telefone->IsDetailKey && EmptyValue($this->telefone->FormValue)) {
                    $this->telefone->addErrorMessage(str_replace("%s", $this->telefone->caption(), $this->telefone->RequiredErrorMessage));
                }
            }
            if ($this->ativo->Visible && $this->ativo->Required) {
                if ($this->ativo->FormValue == "") {
                    $this->ativo->addErrorMessage(str_replace("%s", $this->ativo->caption(), $this->ativo->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("FaturamentoGrid");
        if (in_array("faturamento", $detailTblVar) && $detailPage->DetailEdit) {
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

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
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

            // Update detail records
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("FaturamentoGrid");
            if (in_array("faturamento", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "faturamento"); // Load user level of detail table
                $editRow = $detailPage->gridUpdate();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
            }

            // Commit/Rollback transaction
            if ($this->getCurrentDetailTable() != "") {
                if ($editRow) {
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

        // Write JSON response
        if (IsJsonResponse() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_EDIT_ACTION"), $table => $row]);
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

        // dt_cadastro
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->getAutoUpdateValue(); // PHP
        $this->dt_cadastro->setDbValueDef($rsnew, UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->ReadOnly);

        // cliente
        $this->cliente->setDbValueDef($rsnew, $this->cliente->CurrentValue, $this->cliente->ReadOnly);

        // local_idlocal
        $this->local_idlocal->setDbValueDef($rsnew, $this->local_idlocal->CurrentValue, $this->local_idlocal->ReadOnly);

        // cnpj
        $this->cnpj->setDbValueDef($rsnew, $this->cnpj->CurrentValue, $this->cnpj->ReadOnly);

        // endereco
        $this->endereco->setDbValueDef($rsnew, $this->endereco->CurrentValue, $this->endereco->ReadOnly);

        // numero
        $this->numero->setDbValueDef($rsnew, $this->numero->CurrentValue, $this->numero->ReadOnly);

        // bairro
        $this->bairro->setDbValueDef($rsnew, $this->bairro->CurrentValue, $this->bairro->ReadOnly);

        // cep
        $this->cep->setDbValueDef($rsnew, $this->cep->CurrentValue, $this->cep->ReadOnly);

        // cidade
        $this->cidade->setDbValueDef($rsnew, $this->cidade->CurrentValue, $this->cidade->ReadOnly);

        // uf
        $this->uf->setDbValueDef($rsnew, $this->uf->CurrentValue, $this->uf->ReadOnly);

        // contato
        $this->contato->setDbValueDef($rsnew, $this->contato->CurrentValue, $this->contato->ReadOnly);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, $this->_email->ReadOnly);

        // telefone
        $this->telefone->setDbValueDef($rsnew, $this->telefone->CurrentValue, $this->telefone->ReadOnly);

        // ativo
        $this->ativo->setDbValueDef($rsnew, $this->ativo->CurrentValue, $this->ativo->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['dt_cadastro'])) { // dt_cadastro
            $this->dt_cadastro->CurrentValue = $row['dt_cadastro'];
        }
        if (isset($row['cliente'])) { // cliente
            $this->cliente->CurrentValue = $row['cliente'];
        }
        if (isset($row['local_idlocal'])) { // local_idlocal
            $this->local_idlocal->CurrentValue = $row['local_idlocal'];
        }
        if (isset($row['cnpj'])) { // cnpj
            $this->cnpj->CurrentValue = $row['cnpj'];
        }
        if (isset($row['endereco'])) { // endereco
            $this->endereco->CurrentValue = $row['endereco'];
        }
        if (isset($row['numero'])) { // numero
            $this->numero->CurrentValue = $row['numero'];
        }
        if (isset($row['bairro'])) { // bairro
            $this->bairro->CurrentValue = $row['bairro'];
        }
        if (isset($row['cep'])) { // cep
            $this->cep->CurrentValue = $row['cep'];
        }
        if (isset($row['cidade'])) { // cidade
            $this->cidade->CurrentValue = $row['cidade'];
        }
        if (isset($row['uf'])) { // uf
            $this->uf->CurrentValue = $row['uf'];
        }
        if (isset($row['contato'])) { // contato
            $this->contato->CurrentValue = $row['contato'];
        }
        if (isset($row['email'])) { // email
            $this->_email->CurrentValue = $row['email'];
        }
        if (isset($row['telefone'])) { // telefone
            $this->telefone->CurrentValue = $row['telefone'];
        }
        if (isset($row['ativo'])) { // ativo
            $this->ativo->CurrentValue = $row['ativo'];
        }
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
            if (in_array("faturamento", $detailTblVar)) {
                $detailPageObj = Container("FaturamentoGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->cliente_idcliente->IsDetailKey = true;
                    $detailPageObj->cliente_idcliente->CurrentValue = $this->idcliente->CurrentValue;
                    $detailPageObj->cliente_idcliente->setSessionValue($detailPageObj->cliente_idcliente->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ClienteList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_local_idlocal":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
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
