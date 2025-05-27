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
class PropostaEdit extends Proposta
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "PropostaEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "PropostaEdit";

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
        $this->cliente_idcliente->setVisibility();
        $this->validade->setVisibility();
        $this->mes_ano_conv_coletiva->setVisibility();
        $this->sindicato->setVisibility();
        $this->cidade->setVisibility();
        $this->nr_meses->setVisibility();
        $this->usuario_idusuario->setVisibility();
        $this->obs->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'proposta';
        $this->TableName = 'proposta';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (proposta)
        if (!isset($GLOBALS["proposta"]) || $GLOBALS["proposta"]::class == PROJECT_NAMESPACE . "proposta") {
            $GLOBALS["proposta"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'proposta');
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
                        $result["view"] = SameString($pageName, "PropostaView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->cliente_idcliente);
        $this->setupLookupOptions($this->usuario_idusuario);

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
            if (($keyValue = Get("idproposta") ?? Key(0) ?? Route(2)) !== null) {
                $this->idproposta->setQueryStringValue($keyValue);
                $this->idproposta->setOldValue($this->idproposta->QueryStringValue);
            } elseif (Post("idproposta") !== null) {
                $this->idproposta->setFormValue(Post("idproposta"));
                $this->idproposta->setOldValue($this->idproposta->FormValue);
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
                if (($keyValue = Get("idproposta") ?? Route("idproposta")) !== null) {
                    $this->idproposta->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idproposta->CurrentValue = null;
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
                        $this->terminate("PropostaList"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "PropostaList") {
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
                        if (GetPageName($returnUrl) != "PropostaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "PropostaList"; // Return list page content
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

        // Check field name 'idproposta' first before field var 'x_idproposta'
        $val = $CurrentForm->hasValue("idproposta") ? $CurrentForm->getValue("idproposta") : $CurrentForm->getValue("x_idproposta");
        if (!$this->idproposta->IsDetailKey) {
            $this->idproposta->setFormValue($val);
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

        // Check field name 'cliente_idcliente' first before field var 'x_cliente_idcliente'
        $val = $CurrentForm->hasValue("cliente_idcliente") ? $CurrentForm->getValue("cliente_idcliente") : $CurrentForm->getValue("x_cliente_idcliente");
        if (!$this->cliente_idcliente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cliente_idcliente->Visible = false; // Disable update for API request
            } else {
                $this->cliente_idcliente->setFormValue($val);
            }
        }

        // Check field name 'validade' first before field var 'x_validade'
        $val = $CurrentForm->hasValue("validade") ? $CurrentForm->getValue("validade") : $CurrentForm->getValue("x_validade");
        if (!$this->validade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->validade->Visible = false; // Disable update for API request
            } else {
                $this->validade->setFormValue($val, true, $validate);
            }
            $this->validade->CurrentValue = UnFormatDateTime($this->validade->CurrentValue, $this->validade->formatPattern());
        }

        // Check field name 'mes_ano_conv_coletiva' first before field var 'x_mes_ano_conv_coletiva'
        $val = $CurrentForm->hasValue("mes_ano_conv_coletiva") ? $CurrentForm->getValue("mes_ano_conv_coletiva") : $CurrentForm->getValue("x_mes_ano_conv_coletiva");
        if (!$this->mes_ano_conv_coletiva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mes_ano_conv_coletiva->Visible = false; // Disable update for API request
            } else {
                $this->mes_ano_conv_coletiva->setFormValue($val);
            }
        }

        // Check field name 'sindicato' first before field var 'x_sindicato'
        $val = $CurrentForm->hasValue("sindicato") ? $CurrentForm->getValue("sindicato") : $CurrentForm->getValue("x_sindicato");
        if (!$this->sindicato->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sindicato->Visible = false; // Disable update for API request
            } else {
                $this->sindicato->setFormValue($val);
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

        // Check field name 'nr_meses' first before field var 'x_nr_meses'
        $val = $CurrentForm->hasValue("nr_meses") ? $CurrentForm->getValue("nr_meses") : $CurrentForm->getValue("x_nr_meses");
        if (!$this->nr_meses->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nr_meses->Visible = false; // Disable update for API request
            } else {
                $this->nr_meses->setFormValue($val);
            }
        }

        // Check field name 'usuario_idusuario' first before field var 'x_usuario_idusuario'
        $val = $CurrentForm->hasValue("usuario_idusuario") ? $CurrentForm->getValue("usuario_idusuario") : $CurrentForm->getValue("x_usuario_idusuario");
        if (!$this->usuario_idusuario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuario_idusuario->Visible = false; // Disable update for API request
            } else {
                $this->usuario_idusuario->setFormValue($val);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idproposta->CurrentValue = $this->idproposta->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->cliente_idcliente->CurrentValue = $this->cliente_idcliente->FormValue;
        $this->validade->CurrentValue = $this->validade->FormValue;
        $this->validade->CurrentValue = UnFormatDateTime($this->validade->CurrentValue, $this->validade->formatPattern());
        $this->mes_ano_conv_coletiva->CurrentValue = $this->mes_ano_conv_coletiva->FormValue;
        $this->sindicato->CurrentValue = $this->sindicato->FormValue;
        $this->cidade->CurrentValue = $this->cidade->FormValue;
        $this->nr_meses->CurrentValue = $this->nr_meses->FormValue;
        $this->usuario_idusuario->CurrentValue = $this->usuario_idusuario->FormValue;
        $this->obs->CurrentValue = $this->obs->FormValue;
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
        $this->cliente_idcliente->setDbValue($row['cliente_idcliente']);
        $this->validade->setDbValue($row['validade']);
        $this->mes_ano_conv_coletiva->setDbValue($row['mes_ano_conv_coletiva']);
        $this->sindicato->setDbValue($row['sindicato']);
        $this->cidade->setDbValue($row['cidade']);
        $this->nr_meses->setDbValue($row['nr_meses']);
        $this->usuario_idusuario->setDbValue($row['usuario_idusuario']);
        $this->obs->setDbValue($row['obs']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idproposta'] = $this->idproposta->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['cliente_idcliente'] = $this->cliente_idcliente->DefaultValue;
        $row['validade'] = $this->validade->DefaultValue;
        $row['mes_ano_conv_coletiva'] = $this->mes_ano_conv_coletiva->DefaultValue;
        $row['sindicato'] = $this->sindicato->DefaultValue;
        $row['cidade'] = $this->cidade->DefaultValue;
        $row['nr_meses'] = $this->nr_meses->DefaultValue;
        $row['usuario_idusuario'] = $this->usuario_idusuario->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
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

        // idproposta
        $this->idproposta->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // cliente_idcliente
        $this->cliente_idcliente->RowCssClass = "row";

        // validade
        $this->validade->RowCssClass = "row";

        // mes_ano_conv_coletiva
        $this->mes_ano_conv_coletiva->RowCssClass = "row";

        // sindicato
        $this->sindicato->RowCssClass = "row";

        // cidade
        $this->cidade->RowCssClass = "row";

        // nr_meses
        $this->nr_meses->RowCssClass = "row";

        // usuario_idusuario
        $this->usuario_idusuario->RowCssClass = "row";

        // obs
        $this->obs->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idproposta
            $this->idproposta->ViewValue = $this->idproposta->CurrentValue;
            $this->idproposta->CssClass = "fw-bold";
            $this->idproposta->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // cliente_idcliente
            $curVal = strval($this->cliente_idcliente->CurrentValue);
            if ($curVal != "") {
                $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->lookupCacheOption($curVal);
                if ($this->cliente_idcliente->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->cliente_idcliente->Lookup->getTable()->Fields["idcliente"]->searchExpression(), "=", $curVal, $this->cliente_idcliente->Lookup->getTable()->Fields["idcliente"]->searchDataType(), "");
                    $sqlWrk = $this->cliente_idcliente->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->cliente_idcliente->Lookup->renderViewRow($rswrk[0]);
                        $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->displayValue($arwrk);
                    } else {
                        $this->cliente_idcliente->ViewValue = FormatNumber($this->cliente_idcliente->CurrentValue, $this->cliente_idcliente->formatPattern());
                    }
                }
            } else {
                $this->cliente_idcliente->ViewValue = null;
            }
            $this->cliente_idcliente->CssClass = "fw-bold";

            // validade
            $this->validade->ViewValue = $this->validade->CurrentValue;
            $this->validade->ViewValue = FormatDateTime($this->validade->ViewValue, $this->validade->formatPattern());
            $this->validade->CssClass = "fw-bold";

            // mes_ano_conv_coletiva
            $this->mes_ano_conv_coletiva->ViewValue = $this->mes_ano_conv_coletiva->CurrentValue;
            $this->mes_ano_conv_coletiva->CssClass = "fw-bold";

            // sindicato
            $this->sindicato->ViewValue = $this->sindicato->CurrentValue;
            $this->sindicato->CssClass = "fw-bold";

            // cidade
            $this->cidade->ViewValue = $this->cidade->CurrentValue;
            $this->cidade->CssClass = "fw-bold";

            // nr_meses
            $this->nr_meses->ViewValue = $this->nr_meses->CurrentValue;
            $this->nr_meses->CssClass = "fw-bold";

            // usuario_idusuario
            $curVal = strval($this->usuario_idusuario->CurrentValue);
            if ($curVal != "") {
                $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->lookupCacheOption($curVal);
                if ($this->usuario_idusuario->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->usuario_idusuario->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->usuario_idusuario->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                    $sqlWrk = $this->usuario_idusuario->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->usuario_idusuario->Lookup->renderViewRow($rswrk[0]);
                        $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->displayValue($arwrk);
                    } else {
                        $this->usuario_idusuario->ViewValue = FormatNumber($this->usuario_idusuario->CurrentValue, $this->usuario_idusuario->formatPattern());
                    }
                }
            } else {
                $this->usuario_idusuario->ViewValue = null;
            }
            $this->usuario_idusuario->CssClass = "fw-bold";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->CssClass = "fw-bold";

            // idproposta
            $this->idproposta->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // cliente_idcliente
            $this->cliente_idcliente->HrefValue = "";

            // validade
            $this->validade->HrefValue = "";

            // mes_ano_conv_coletiva
            $this->mes_ano_conv_coletiva->HrefValue = "";

            // sindicato
            $this->sindicato->HrefValue = "";

            // cidade
            $this->cidade->HrefValue = "";

            // nr_meses
            $this->nr_meses->HrefValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";

            // obs
            $this->obs->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // idproposta
            $this->idproposta->setupEditAttributes();
            $this->idproposta->EditValue = $this->idproposta->CurrentValue;
            $this->idproposta->CssClass = "fw-bold";
            $this->idproposta->CellCssStyle .= "text-align: center;";

            // dt_cadastro

            // cliente_idcliente
            $curVal = trim(strval($this->cliente_idcliente->CurrentValue));
            if ($curVal != "") {
                $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->lookupCacheOption($curVal);
            } else {
                $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->Lookup !== null && is_array($this->cliente_idcliente->lookupOptions()) && count($this->cliente_idcliente->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cliente_idcliente->ViewValue !== null) { // Load from cache
                $this->cliente_idcliente->EditValue = array_values($this->cliente_idcliente->lookupOptions());
                if ($this->cliente_idcliente->ViewValue == "") {
                    $this->cliente_idcliente->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cliente_idcliente->Lookup->getTable()->Fields["idcliente"]->searchExpression(), "=", $this->cliente_idcliente->CurrentValue, $this->cliente_idcliente->Lookup->getTable()->Fields["idcliente"]->searchDataType(), "");
                }
                $sqlWrk = $this->cliente_idcliente->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->cliente_idcliente->Lookup->renderViewRow($rswrk[0]);
                    $this->cliente_idcliente->ViewValue = $this->cliente_idcliente->displayValue($arwrk);
                } else {
                    $this->cliente_idcliente->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->cliente_idcliente->EditValue = $arwrk;
            }
            $this->cliente_idcliente->PlaceHolder = RemoveHtml($this->cliente_idcliente->caption());

            // validade
            $this->validade->setupEditAttributes();
            $this->validade->EditValue = HtmlEncode(FormatDateTime($this->validade->CurrentValue, $this->validade->formatPattern()));
            $this->validade->PlaceHolder = RemoveHtml($this->validade->caption());

            // mes_ano_conv_coletiva
            $this->mes_ano_conv_coletiva->setupEditAttributes();
            if (!$this->mes_ano_conv_coletiva->Raw) {
                $this->mes_ano_conv_coletiva->CurrentValue = HtmlDecode($this->mes_ano_conv_coletiva->CurrentValue);
            }
            $this->mes_ano_conv_coletiva->EditValue = HtmlEncode($this->mes_ano_conv_coletiva->CurrentValue);
            $this->mes_ano_conv_coletiva->PlaceHolder = RemoveHtml($this->mes_ano_conv_coletiva->caption());

            // sindicato
            $this->sindicato->setupEditAttributes();
            if (!$this->sindicato->Raw) {
                $this->sindicato->CurrentValue = HtmlDecode($this->sindicato->CurrentValue);
            }
            $this->sindicato->EditValue = HtmlEncode($this->sindicato->CurrentValue);
            $this->sindicato->PlaceHolder = RemoveHtml($this->sindicato->caption());

            // cidade
            $this->cidade->setupEditAttributes();
            if (!$this->cidade->Raw) {
                $this->cidade->CurrentValue = HtmlDecode($this->cidade->CurrentValue);
            }
            $this->cidade->EditValue = HtmlEncode($this->cidade->CurrentValue);
            $this->cidade->PlaceHolder = RemoveHtml($this->cidade->caption());

            // nr_meses
            $this->nr_meses->setupEditAttributes();
            if (!$this->nr_meses->Raw) {
                $this->nr_meses->CurrentValue = HtmlDecode($this->nr_meses->CurrentValue);
            }
            $this->nr_meses->EditValue = HtmlEncode($this->nr_meses->CurrentValue);
            $this->nr_meses->PlaceHolder = RemoveHtml($this->nr_meses->caption());

            // usuario_idusuario

            // obs
            $this->obs->setupEditAttributes();
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // Edit refer script

            // idproposta
            $this->idproposta->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // cliente_idcliente
            $this->cliente_idcliente->HrefValue = "";

            // validade
            $this->validade->HrefValue = "";

            // mes_ano_conv_coletiva
            $this->mes_ano_conv_coletiva->HrefValue = "";

            // sindicato
            $this->sindicato->HrefValue = "";

            // cidade
            $this->cidade->HrefValue = "";

            // nr_meses
            $this->nr_meses->HrefValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";

            // obs
            $this->obs->HrefValue = "";
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
            if ($this->idproposta->Visible && $this->idproposta->Required) {
                if (!$this->idproposta->IsDetailKey && EmptyValue($this->idproposta->FormValue)) {
                    $this->idproposta->addErrorMessage(str_replace("%s", $this->idproposta->caption(), $this->idproposta->RequiredErrorMessage));
                }
            }
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
            }
            if ($this->cliente_idcliente->Visible && $this->cliente_idcliente->Required) {
                if (!$this->cliente_idcliente->IsDetailKey && EmptyValue($this->cliente_idcliente->FormValue)) {
                    $this->cliente_idcliente->addErrorMessage(str_replace("%s", $this->cliente_idcliente->caption(), $this->cliente_idcliente->RequiredErrorMessage));
                }
            }
            if ($this->validade->Visible && $this->validade->Required) {
                if (!$this->validade->IsDetailKey && EmptyValue($this->validade->FormValue)) {
                    $this->validade->addErrorMessage(str_replace("%s", $this->validade->caption(), $this->validade->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->validade->FormValue, $this->validade->formatPattern())) {
                $this->validade->addErrorMessage($this->validade->getErrorMessage(false));
            }
            if ($this->mes_ano_conv_coletiva->Visible && $this->mes_ano_conv_coletiva->Required) {
                if (!$this->mes_ano_conv_coletiva->IsDetailKey && EmptyValue($this->mes_ano_conv_coletiva->FormValue)) {
                    $this->mes_ano_conv_coletiva->addErrorMessage(str_replace("%s", $this->mes_ano_conv_coletiva->caption(), $this->mes_ano_conv_coletiva->RequiredErrorMessage));
                }
            }
            if ($this->sindicato->Visible && $this->sindicato->Required) {
                if (!$this->sindicato->IsDetailKey && EmptyValue($this->sindicato->FormValue)) {
                    $this->sindicato->addErrorMessage(str_replace("%s", $this->sindicato->caption(), $this->sindicato->RequiredErrorMessage));
                }
            }
            if ($this->cidade->Visible && $this->cidade->Required) {
                if (!$this->cidade->IsDetailKey && EmptyValue($this->cidade->FormValue)) {
                    $this->cidade->addErrorMessage(str_replace("%s", $this->cidade->caption(), $this->cidade->RequiredErrorMessage));
                }
            }
            if ($this->nr_meses->Visible && $this->nr_meses->Required) {
                if (!$this->nr_meses->IsDetailKey && EmptyValue($this->nr_meses->FormValue)) {
                    $this->nr_meses->addErrorMessage(str_replace("%s", $this->nr_meses->caption(), $this->nr_meses->RequiredErrorMessage));
                }
            }
            if ($this->usuario_idusuario->Visible && $this->usuario_idusuario->Required) {
                if (!$this->usuario_idusuario->IsDetailKey && EmptyValue($this->usuario_idusuario->FormValue)) {
                    $this->usuario_idusuario->addErrorMessage(str_replace("%s", $this->usuario_idusuario->caption(), $this->usuario_idusuario->RequiredErrorMessage));
                }
            }
            if ($this->obs->Visible && $this->obs->Required) {
                if (!$this->obs->IsDetailKey && EmptyValue($this->obs->FormValue)) {
                    $this->obs->addErrorMessage(str_replace("%s", $this->obs->caption(), $this->obs->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("PlanilhaCustoGrid");
        if (in_array("planilha_custo", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("MovInsumoClienteGrid");
        if (in_array("mov_insumo_cliente", $detailTblVar) && $detailPage->DetailEdit) {
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
            $detailPage = Container("PlanilhaCustoGrid");
            if (in_array("planilha_custo", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "planilha_custo"); // Load user level of detail table
                $editRow = $detailPage->gridUpdate();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
            }
            $detailPage = Container("MovInsumoClienteGrid");
            if (in_array("mov_insumo_cliente", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "mov_insumo_cliente"); // Load user level of detail table
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

        // cliente_idcliente
        $this->cliente_idcliente->setDbValueDef($rsnew, $this->cliente_idcliente->CurrentValue, $this->cliente_idcliente->ReadOnly);

        // validade
        $this->validade->setDbValueDef($rsnew, UnFormatDateTime($this->validade->CurrentValue, $this->validade->formatPattern()), $this->validade->ReadOnly);

        // mes_ano_conv_coletiva
        $this->mes_ano_conv_coletiva->setDbValueDef($rsnew, $this->mes_ano_conv_coletiva->CurrentValue, $this->mes_ano_conv_coletiva->ReadOnly);

        // sindicato
        $this->sindicato->setDbValueDef($rsnew, $this->sindicato->CurrentValue, $this->sindicato->ReadOnly);

        // cidade
        $this->cidade->setDbValueDef($rsnew, $this->cidade->CurrentValue, $this->cidade->ReadOnly);

        // nr_meses
        $this->nr_meses->setDbValueDef($rsnew, $this->nr_meses->CurrentValue, $this->nr_meses->ReadOnly);

        // usuario_idusuario
        $this->usuario_idusuario->CurrentValue = $this->usuario_idusuario->getAutoUpdateValue(); // PHP
        $this->usuario_idusuario->setDbValueDef($rsnew, $this->usuario_idusuario->CurrentValue, $this->usuario_idusuario->ReadOnly);

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, $this->obs->ReadOnly);
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
        if (isset($row['cliente_idcliente'])) { // cliente_idcliente
            $this->cliente_idcliente->CurrentValue = $row['cliente_idcliente'];
        }
        if (isset($row['validade'])) { // validade
            $this->validade->CurrentValue = $row['validade'];
        }
        if (isset($row['mes_ano_conv_coletiva'])) { // mes_ano_conv_coletiva
            $this->mes_ano_conv_coletiva->CurrentValue = $row['mes_ano_conv_coletiva'];
        }
        if (isset($row['sindicato'])) { // sindicato
            $this->sindicato->CurrentValue = $row['sindicato'];
        }
        if (isset($row['cidade'])) { // cidade
            $this->cidade->CurrentValue = $row['cidade'];
        }
        if (isset($row['nr_meses'])) { // nr_meses
            $this->nr_meses->CurrentValue = $row['nr_meses'];
        }
        if (isset($row['usuario_idusuario'])) { // usuario_idusuario
            $this->usuario_idusuario->CurrentValue = $row['usuario_idusuario'];
        }
        if (isset($row['obs'])) { // obs
            $this->obs->CurrentValue = $row['obs'];
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
            if (in_array("planilha_custo", $detailTblVar)) {
                $detailPageObj = Container("PlanilhaCustoGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->proposta_idproposta->IsDetailKey = true;
                    $detailPageObj->proposta_idproposta->CurrentValue = $this->idproposta->CurrentValue;
                    $detailPageObj->proposta_idproposta->setSessionValue($detailPageObj->proposta_idproposta->CurrentValue);
                }
            }
            if (in_array("mov_insumo_cliente", $detailTblVar)) {
                $detailPageObj = Container("MovInsumoClienteGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->proposta_idproposta->IsDetailKey = true;
                    $detailPageObj->proposta_idproposta->CurrentValue = $this->idproposta->CurrentValue;
                    $detailPageObj->proposta_idproposta->setSessionValue($detailPageObj->proposta_idproposta->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PropostaList"), "", $this->TableVar, true);
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
                case "x_cliente_idcliente":
                    break;
                case "x_usuario_idusuario":
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
