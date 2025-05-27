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
class PlanilhaCustoContratoEdit extends PlanilhaCustoContrato
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "PlanilhaCustoContratoEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "PlanilhaCustoContratoEdit";

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
        $this->idplanilha_custo_contrato->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->quantidade->setVisibility();
        $this->escala_idescala->setVisibility();
        $this->periodo_idperiodo->setVisibility();
        $this->tipo_intrajornada_idtipo_intrajornada->setVisibility();
        $this->cargo_idcargo->setVisibility();
        $this->acumulo_funcao->setVisibility();
        $this->usuario_idusuario->setVisibility();
        $this->contrato_idcontrato->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'planilha_custo_contrato';
        $this->TableName = 'planilha_custo_contrato';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (planilha_custo_contrato)
        if (!isset($GLOBALS["planilha_custo_contrato"]) || $GLOBALS["planilha_custo_contrato"]::class == PROJECT_NAMESPACE . "planilha_custo_contrato") {
            $GLOBALS["planilha_custo_contrato"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'planilha_custo_contrato');
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
                        $result["view"] = SameString($pageName, "PlanilhaCustoContratoView"); // If View page, no primary button
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
            $key .= @$ar['idplanilha_custo_contrato'];
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
            $this->idplanilha_custo_contrato->Visible = false;
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
        $this->setupLookupOptions($this->escala_idescala);
        $this->setupLookupOptions($this->periodo_idperiodo);
        $this->setupLookupOptions($this->tipo_intrajornada_idtipo_intrajornada);
        $this->setupLookupOptions($this->cargo_idcargo);
        $this->setupLookupOptions($this->acumulo_funcao);
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
            if (($keyValue = Get("idplanilha_custo_contrato") ?? Key(0) ?? Route(2)) !== null) {
                $this->idplanilha_custo_contrato->setQueryStringValue($keyValue);
                $this->idplanilha_custo_contrato->setOldValue($this->idplanilha_custo_contrato->QueryStringValue);
            } elseif (Post("idplanilha_custo_contrato") !== null) {
                $this->idplanilha_custo_contrato->setFormValue(Post("idplanilha_custo_contrato"));
                $this->idplanilha_custo_contrato->setOldValue($this->idplanilha_custo_contrato->FormValue);
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
                if (($keyValue = Get("idplanilha_custo_contrato") ?? Route("idplanilha_custo_contrato")) !== null) {
                    $this->idplanilha_custo_contrato->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idplanilha_custo_contrato->CurrentValue = null;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

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
                        $this->terminate("PlanilhaCustoContratoList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "PlanilhaCustoContratoList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "PlanilhaCustoContratoList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "PlanilhaCustoContratoList"; // Return list page content
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

        // Check field name 'idplanilha_custo_contrato' first before field var 'x_idplanilha_custo_contrato'
        $val = $CurrentForm->hasValue("idplanilha_custo_contrato") ? $CurrentForm->getValue("idplanilha_custo_contrato") : $CurrentForm->getValue("x_idplanilha_custo_contrato");
        if (!$this->idplanilha_custo_contrato->IsDetailKey) {
            $this->idplanilha_custo_contrato->setFormValue($val);
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

        // Check field name 'quantidade' first before field var 'x_quantidade'
        $val = $CurrentForm->hasValue("quantidade") ? $CurrentForm->getValue("quantidade") : $CurrentForm->getValue("x_quantidade");
        if (!$this->quantidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->quantidade->Visible = false; // Disable update for API request
            } else {
                $this->quantidade->setFormValue($val, true, $validate);
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

        // Check field name 'tipo_intrajornada_idtipo_intrajornada' first before field var 'x_tipo_intrajornada_idtipo_intrajornada'
        $val = $CurrentForm->hasValue("tipo_intrajornada_idtipo_intrajornada") ? $CurrentForm->getValue("tipo_intrajornada_idtipo_intrajornada") : $CurrentForm->getValue("x_tipo_intrajornada_idtipo_intrajornada");
        if (!$this->tipo_intrajornada_idtipo_intrajornada->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_intrajornada_idtipo_intrajornada->Visible = false; // Disable update for API request
            } else {
                $this->tipo_intrajornada_idtipo_intrajornada->setFormValue($val);
            }
        }

        // Check field name 'cargo_idcargo' first before field var 'x_cargo_idcargo'
        $val = $CurrentForm->hasValue("cargo_idcargo") ? $CurrentForm->getValue("cargo_idcargo") : $CurrentForm->getValue("x_cargo_idcargo");
        if (!$this->cargo_idcargo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cargo_idcargo->Visible = false; // Disable update for API request
            } else {
                $this->cargo_idcargo->setFormValue($val);
            }
        }

        // Check field name 'acumulo_funcao' first before field var 'x_acumulo_funcao'
        $val = $CurrentForm->hasValue("acumulo_funcao") ? $CurrentForm->getValue("acumulo_funcao") : $CurrentForm->getValue("x_acumulo_funcao");
        if (!$this->acumulo_funcao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->acumulo_funcao->Visible = false; // Disable update for API request
            } else {
                $this->acumulo_funcao->setFormValue($val);
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

        // Check field name 'contrato_idcontrato' first before field var 'x_contrato_idcontrato'
        $val = $CurrentForm->hasValue("contrato_idcontrato") ? $CurrentForm->getValue("contrato_idcontrato") : $CurrentForm->getValue("x_contrato_idcontrato");
        if (!$this->contrato_idcontrato->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contrato_idcontrato->Visible = false; // Disable update for API request
            } else {
                $this->contrato_idcontrato->setFormValue($val, true, $validate);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idplanilha_custo_contrato->CurrentValue = $this->idplanilha_custo_contrato->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->quantidade->CurrentValue = $this->quantidade->FormValue;
        $this->escala_idescala->CurrentValue = $this->escala_idescala->FormValue;
        $this->periodo_idperiodo->CurrentValue = $this->periodo_idperiodo->FormValue;
        $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue = $this->tipo_intrajornada_idtipo_intrajornada->FormValue;
        $this->cargo_idcargo->CurrentValue = $this->cargo_idcargo->FormValue;
        $this->acumulo_funcao->CurrentValue = $this->acumulo_funcao->FormValue;
        $this->usuario_idusuario->CurrentValue = $this->usuario_idusuario->FormValue;
        $this->contrato_idcontrato->CurrentValue = $this->contrato_idcontrato->FormValue;
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
        $this->idplanilha_custo_contrato->setDbValue($row['idplanilha_custo_contrato']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->quantidade->setDbValue($row['quantidade']);
        $this->escala_idescala->setDbValue($row['escala_idescala']);
        $this->periodo_idperiodo->setDbValue($row['periodo_idperiodo']);
        $this->tipo_intrajornada_idtipo_intrajornada->setDbValue($row['tipo_intrajornada_idtipo_intrajornada']);
        $this->cargo_idcargo->setDbValue($row['cargo_idcargo']);
        $this->acumulo_funcao->setDbValue($row['acumulo_funcao']);
        $this->usuario_idusuario->setDbValue($row['usuario_idusuario']);
        $this->contrato_idcontrato->setDbValue($row['contrato_idcontrato']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idplanilha_custo_contrato'] = $this->idplanilha_custo_contrato->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['quantidade'] = $this->quantidade->DefaultValue;
        $row['escala_idescala'] = $this->escala_idescala->DefaultValue;
        $row['periodo_idperiodo'] = $this->periodo_idperiodo->DefaultValue;
        $row['tipo_intrajornada_idtipo_intrajornada'] = $this->tipo_intrajornada_idtipo_intrajornada->DefaultValue;
        $row['cargo_idcargo'] = $this->cargo_idcargo->DefaultValue;
        $row['acumulo_funcao'] = $this->acumulo_funcao->DefaultValue;
        $row['usuario_idusuario'] = $this->usuario_idusuario->DefaultValue;
        $row['contrato_idcontrato'] = $this->contrato_idcontrato->DefaultValue;
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

        // idplanilha_custo_contrato
        $this->idplanilha_custo_contrato->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // quantidade
        $this->quantidade->RowCssClass = "row";

        // escala_idescala
        $this->escala_idescala->RowCssClass = "row";

        // periodo_idperiodo
        $this->periodo_idperiodo->RowCssClass = "row";

        // tipo_intrajornada_idtipo_intrajornada
        $this->tipo_intrajornada_idtipo_intrajornada->RowCssClass = "row";

        // cargo_idcargo
        $this->cargo_idcargo->RowCssClass = "row";

        // acumulo_funcao
        $this->acumulo_funcao->RowCssClass = "row";

        // usuario_idusuario
        $this->usuario_idusuario->RowCssClass = "row";

        // contrato_idcontrato
        $this->contrato_idcontrato->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idplanilha_custo_contrato
            $this->idplanilha_custo_contrato->ViewValue = $this->idplanilha_custo_contrato->CurrentValue;
            $this->idplanilha_custo_contrato->ViewValue = FormatNumber($this->idplanilha_custo_contrato->ViewValue, $this->idplanilha_custo_contrato->formatPattern());
            $this->idplanilha_custo_contrato->CssClass = "fw-bold";
            $this->idplanilha_custo_contrato->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // quantidade
            $this->quantidade->ViewValue = $this->quantidade->CurrentValue;
            $this->quantidade->ViewValue = FormatNumber($this->quantidade->ViewValue, $this->quantidade->formatPattern());
            $this->quantidade->CssClass = "fw-bold";
            $this->quantidade->CellCssStyle .= "text-align: center;";

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

            // tipo_intrajornada_idtipo_intrajornada
            $curVal = strval($this->tipo_intrajornada_idtipo_intrajornada->CurrentValue);
            if ($curVal != "") {
                $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = $this->tipo_intrajornada_idtipo_intrajornada->lookupCacheOption($curVal);
                if ($this->tipo_intrajornada_idtipo_intrajornada->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_intrajornada_idtipo_intrajornada->Lookup->getTable()->Fields["idtipo_intrajornada"]->searchExpression(), "=", $curVal, $this->tipo_intrajornada_idtipo_intrajornada->Lookup->getTable()->Fields["idtipo_intrajornada"]->searchDataType(), "");
                    $sqlWrk = $this->tipo_intrajornada_idtipo_intrajornada->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_intrajornada_idtipo_intrajornada->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = $this->tipo_intrajornada_idtipo_intrajornada->displayValue($arwrk);
                    } else {
                        $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = FormatNumber($this->tipo_intrajornada_idtipo_intrajornada->CurrentValue, $this->tipo_intrajornada_idtipo_intrajornada->formatPattern());
                    }
                }
            } else {
                $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = null;
            }
            $this->tipo_intrajornada_idtipo_intrajornada->CssClass = "fw-bold";

            // cargo_idcargo
            $curVal = strval($this->cargo_idcargo->CurrentValue);
            if ($curVal != "") {
                $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->lookupCacheOption($curVal);
                if ($this->cargo_idcargo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->cargo_idcargo->Lookup->getTable()->Fields["idcargo"]->searchExpression(), "=", $curVal, $this->cargo_idcargo->Lookup->getTable()->Fields["idcargo"]->searchDataType(), "");
                    $sqlWrk = $this->cargo_idcargo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->cargo_idcargo->Lookup->renderViewRow($rswrk[0]);
                        $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->displayValue($arwrk);
                    } else {
                        $this->cargo_idcargo->ViewValue = FormatNumber($this->cargo_idcargo->CurrentValue, $this->cargo_idcargo->formatPattern());
                    }
                }
            } else {
                $this->cargo_idcargo->ViewValue = null;
            }
            $this->cargo_idcargo->CssClass = "fw-bold";

            // acumulo_funcao
            if (strval($this->acumulo_funcao->CurrentValue) != "") {
                $this->acumulo_funcao->ViewValue = $this->acumulo_funcao->optionCaption($this->acumulo_funcao->CurrentValue);
            } else {
                $this->acumulo_funcao->ViewValue = null;
            }
            $this->acumulo_funcao->CssClass = "fw-bold";
            $this->acumulo_funcao->CellCssStyle .= "text-align: center;";

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

            // contrato_idcontrato
            $this->contrato_idcontrato->ViewValue = $this->contrato_idcontrato->CurrentValue;
            $this->contrato_idcontrato->ViewValue = FormatNumber($this->contrato_idcontrato->ViewValue, $this->contrato_idcontrato->formatPattern());
            $this->contrato_idcontrato->CssClass = "fw-bold";
            $this->contrato_idcontrato->CellCssStyle .= "text-align: center;";

            // idplanilha_custo_contrato
            $this->idplanilha_custo_contrato->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // quantidade
            $this->quantidade->HrefValue = "";

            // escala_idescala
            $this->escala_idescala->HrefValue = "";

            // periodo_idperiodo
            $this->periodo_idperiodo->HrefValue = "";

            // tipo_intrajornada_idtipo_intrajornada
            $this->tipo_intrajornada_idtipo_intrajornada->HrefValue = "";

            // cargo_idcargo
            $this->cargo_idcargo->HrefValue = "";

            // acumulo_funcao
            $this->acumulo_funcao->HrefValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";

            // contrato_idcontrato
            $this->contrato_idcontrato->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // idplanilha_custo_contrato
            $this->idplanilha_custo_contrato->setupEditAttributes();
            $this->idplanilha_custo_contrato->EditValue = $this->idplanilha_custo_contrato->CurrentValue;
            $this->idplanilha_custo_contrato->EditValue = FormatNumber($this->idplanilha_custo_contrato->EditValue, $this->idplanilha_custo_contrato->formatPattern());
            $this->idplanilha_custo_contrato->CssClass = "fw-bold";
            $this->idplanilha_custo_contrato->CellCssStyle .= "text-align: center;";

            // dt_cadastro

            // quantidade
            $this->quantidade->setupEditAttributes();
            $this->quantidade->EditValue = $this->quantidade->CurrentValue;
            $this->quantidade->PlaceHolder = RemoveHtml($this->quantidade->caption());
            if (strval($this->quantidade->EditValue) != "" && is_numeric($this->quantidade->EditValue)) {
                $this->quantidade->EditValue = FormatNumber($this->quantidade->EditValue, null);
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

            // tipo_intrajornada_idtipo_intrajornada
            $curVal = trim(strval($this->tipo_intrajornada_idtipo_intrajornada->CurrentValue));
            if ($curVal != "") {
                $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = $this->tipo_intrajornada_idtipo_intrajornada->lookupCacheOption($curVal);
            } else {
                $this->tipo_intrajornada_idtipo_intrajornada->ViewValue = $this->tipo_intrajornada_idtipo_intrajornada->Lookup !== null && is_array($this->tipo_intrajornada_idtipo_intrajornada->lookupOptions()) && count($this->tipo_intrajornada_idtipo_intrajornada->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_intrajornada_idtipo_intrajornada->ViewValue !== null) { // Load from cache
                $this->tipo_intrajornada_idtipo_intrajornada->EditValue = array_values($this->tipo_intrajornada_idtipo_intrajornada->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_intrajornada_idtipo_intrajornada->Lookup->getTable()->Fields["idtipo_intrajornada"]->searchExpression(), "=", $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue, $this->tipo_intrajornada_idtipo_intrajornada->Lookup->getTable()->Fields["idtipo_intrajornada"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipo_intrajornada_idtipo_intrajornada->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_intrajornada_idtipo_intrajornada->EditValue = $arwrk;
            }
            $this->tipo_intrajornada_idtipo_intrajornada->PlaceHolder = RemoveHtml($this->tipo_intrajornada_idtipo_intrajornada->caption());

            // cargo_idcargo
            $curVal = trim(strval($this->cargo_idcargo->CurrentValue));
            if ($curVal != "") {
                $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->lookupCacheOption($curVal);
            } else {
                $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->Lookup !== null && is_array($this->cargo_idcargo->lookupOptions()) && count($this->cargo_idcargo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cargo_idcargo->ViewValue !== null) { // Load from cache
                $this->cargo_idcargo->EditValue = array_values($this->cargo_idcargo->lookupOptions());
                if ($this->cargo_idcargo->ViewValue == "") {
                    $this->cargo_idcargo->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cargo_idcargo->Lookup->getTable()->Fields["idcargo"]->searchExpression(), "=", $this->cargo_idcargo->CurrentValue, $this->cargo_idcargo->Lookup->getTable()->Fields["idcargo"]->searchDataType(), "");
                }
                $sqlWrk = $this->cargo_idcargo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->cargo_idcargo->Lookup->renderViewRow($rswrk[0]);
                    $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->displayValue($arwrk);
                } else {
                    $this->cargo_idcargo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->cargo_idcargo->Lookup->renderViewRow($row);
                }
                $this->cargo_idcargo->EditValue = $arwrk;
            }
            $this->cargo_idcargo->PlaceHolder = RemoveHtml($this->cargo_idcargo->caption());

            // acumulo_funcao
            $this->acumulo_funcao->EditValue = $this->acumulo_funcao->options(false);
            $this->acumulo_funcao->PlaceHolder = RemoveHtml($this->acumulo_funcao->caption());

            // usuario_idusuario

            // contrato_idcontrato
            $this->contrato_idcontrato->setupEditAttributes();
            if ($this->contrato_idcontrato->getSessionValue() != "") {
                $this->contrato_idcontrato->CurrentValue = GetForeignKeyValue($this->contrato_idcontrato->getSessionValue());
                $this->contrato_idcontrato->ViewValue = $this->contrato_idcontrato->CurrentValue;
                $this->contrato_idcontrato->ViewValue = FormatNumber($this->contrato_idcontrato->ViewValue, $this->contrato_idcontrato->formatPattern());
                $this->contrato_idcontrato->CssClass = "fw-bold";
                $this->contrato_idcontrato->CellCssStyle .= "text-align: center;";
            } else {
                $this->contrato_idcontrato->EditValue = $this->contrato_idcontrato->CurrentValue;
                $this->contrato_idcontrato->PlaceHolder = RemoveHtml($this->contrato_idcontrato->caption());
                if (strval($this->contrato_idcontrato->EditValue) != "" && is_numeric($this->contrato_idcontrato->EditValue)) {
                    $this->contrato_idcontrato->EditValue = FormatNumber($this->contrato_idcontrato->EditValue, null);
                }
            }

            // Edit refer script

            // idplanilha_custo_contrato
            $this->idplanilha_custo_contrato->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // quantidade
            $this->quantidade->HrefValue = "";

            // escala_idescala
            $this->escala_idescala->HrefValue = "";

            // periodo_idperiodo
            $this->periodo_idperiodo->HrefValue = "";

            // tipo_intrajornada_idtipo_intrajornada
            $this->tipo_intrajornada_idtipo_intrajornada->HrefValue = "";

            // cargo_idcargo
            $this->cargo_idcargo->HrefValue = "";

            // acumulo_funcao
            $this->acumulo_funcao->HrefValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";

            // contrato_idcontrato
            $this->contrato_idcontrato->HrefValue = "";
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
            if ($this->idplanilha_custo_contrato->Visible && $this->idplanilha_custo_contrato->Required) {
                if (!$this->idplanilha_custo_contrato->IsDetailKey && EmptyValue($this->idplanilha_custo_contrato->FormValue)) {
                    $this->idplanilha_custo_contrato->addErrorMessage(str_replace("%s", $this->idplanilha_custo_contrato->caption(), $this->idplanilha_custo_contrato->RequiredErrorMessage));
                }
            }
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
            }
            if ($this->quantidade->Visible && $this->quantidade->Required) {
                if (!$this->quantidade->IsDetailKey && EmptyValue($this->quantidade->FormValue)) {
                    $this->quantidade->addErrorMessage(str_replace("%s", $this->quantidade->caption(), $this->quantidade->RequiredErrorMessage));
                }
            }
            if (!CheckRange($this->quantidade->FormValue, 1, 10)) {
                $this->quantidade->addErrorMessage($this->quantidade->getErrorMessage(false));
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
            if ($this->tipo_intrajornada_idtipo_intrajornada->Visible && $this->tipo_intrajornada_idtipo_intrajornada->Required) {
                if ($this->tipo_intrajornada_idtipo_intrajornada->FormValue == "") {
                    $this->tipo_intrajornada_idtipo_intrajornada->addErrorMessage(str_replace("%s", $this->tipo_intrajornada_idtipo_intrajornada->caption(), $this->tipo_intrajornada_idtipo_intrajornada->RequiredErrorMessage));
                }
            }
            if ($this->cargo_idcargo->Visible && $this->cargo_idcargo->Required) {
                if (!$this->cargo_idcargo->IsDetailKey && EmptyValue($this->cargo_idcargo->FormValue)) {
                    $this->cargo_idcargo->addErrorMessage(str_replace("%s", $this->cargo_idcargo->caption(), $this->cargo_idcargo->RequiredErrorMessage));
                }
            }
            if ($this->acumulo_funcao->Visible && $this->acumulo_funcao->Required) {
                if ($this->acumulo_funcao->FormValue == "") {
                    $this->acumulo_funcao->addErrorMessage(str_replace("%s", $this->acumulo_funcao->caption(), $this->acumulo_funcao->RequiredErrorMessage));
                }
            }
            if ($this->usuario_idusuario->Visible && $this->usuario_idusuario->Required) {
                if (!$this->usuario_idusuario->IsDetailKey && EmptyValue($this->usuario_idusuario->FormValue)) {
                    $this->usuario_idusuario->addErrorMessage(str_replace("%s", $this->usuario_idusuario->caption(), $this->usuario_idusuario->RequiredErrorMessage));
                }
            }
            if ($this->contrato_idcontrato->Visible && $this->contrato_idcontrato->Required) {
                if (!$this->contrato_idcontrato->IsDetailKey && EmptyValue($this->contrato_idcontrato->FormValue)) {
                    $this->contrato_idcontrato->addErrorMessage(str_replace("%s", $this->contrato_idcontrato->caption(), $this->contrato_idcontrato->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->contrato_idcontrato->FormValue)) {
                $this->contrato_idcontrato->addErrorMessage($this->contrato_idcontrato->getErrorMessage(false));
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

        // Check referential integrity for master table 'contrato'
        $detailKeys = [];
        $keyValue = $rsnew['contrato_idcontrato'] ?? $rsold['contrato_idcontrato'];
        $detailKeys['contrato_idcontrato'] = $keyValue;
        $masterTable = Container("contrato");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "contrato", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
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

        // quantidade
        $this->quantidade->setDbValueDef($rsnew, $this->quantidade->CurrentValue, $this->quantidade->ReadOnly);

        // escala_idescala
        $this->escala_idescala->setDbValueDef($rsnew, $this->escala_idescala->CurrentValue, $this->escala_idescala->ReadOnly);

        // periodo_idperiodo
        $this->periodo_idperiodo->setDbValueDef($rsnew, $this->periodo_idperiodo->CurrentValue, $this->periodo_idperiodo->ReadOnly);

        // tipo_intrajornada_idtipo_intrajornada
        $this->tipo_intrajornada_idtipo_intrajornada->setDbValueDef($rsnew, $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue, $this->tipo_intrajornada_idtipo_intrajornada->ReadOnly);

        // cargo_idcargo
        $this->cargo_idcargo->setDbValueDef($rsnew, $this->cargo_idcargo->CurrentValue, $this->cargo_idcargo->ReadOnly);

        // acumulo_funcao
        $this->acumulo_funcao->setDbValueDef($rsnew, $this->acumulo_funcao->CurrentValue, $this->acumulo_funcao->ReadOnly);

        // usuario_idusuario
        $this->usuario_idusuario->CurrentValue = $this->usuario_idusuario->getAutoUpdateValue(); // PHP
        $this->usuario_idusuario->setDbValueDef($rsnew, $this->usuario_idusuario->CurrentValue, $this->usuario_idusuario->ReadOnly);

        // contrato_idcontrato
        if ($this->contrato_idcontrato->getSessionValue() != "") {
            $this->contrato_idcontrato->ReadOnly = true;
        }
        $this->contrato_idcontrato->setDbValueDef($rsnew, $this->contrato_idcontrato->CurrentValue, $this->contrato_idcontrato->ReadOnly);
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
        if (isset($row['quantidade'])) { // quantidade
            $this->quantidade->CurrentValue = $row['quantidade'];
        }
        if (isset($row['escala_idescala'])) { // escala_idescala
            $this->escala_idescala->CurrentValue = $row['escala_idescala'];
        }
        if (isset($row['periodo_idperiodo'])) { // periodo_idperiodo
            $this->periodo_idperiodo->CurrentValue = $row['periodo_idperiodo'];
        }
        if (isset($row['tipo_intrajornada_idtipo_intrajornada'])) { // tipo_intrajornada_idtipo_intrajornada
            $this->tipo_intrajornada_idtipo_intrajornada->CurrentValue = $row['tipo_intrajornada_idtipo_intrajornada'];
        }
        if (isset($row['cargo_idcargo'])) { // cargo_idcargo
            $this->cargo_idcargo->CurrentValue = $row['cargo_idcargo'];
        }
        if (isset($row['acumulo_funcao'])) { // acumulo_funcao
            $this->acumulo_funcao->CurrentValue = $row['acumulo_funcao'];
        }
        if (isset($row['usuario_idusuario'])) { // usuario_idusuario
            $this->usuario_idusuario->CurrentValue = $row['usuario_idusuario'];
        }
        if (isset($row['contrato_idcontrato'])) { // contrato_idcontrato
            $this->contrato_idcontrato->CurrentValue = $row['contrato_idcontrato'];
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
            if ($masterTblVar == "contrato") {
                $validMaster = true;
                $masterTbl = Container("contrato");
                if (($parm = Get("fk_idcontrato", Get("contrato_idcontrato"))) !== null) {
                    $masterTbl->idcontrato->setQueryStringValue($parm);
                    $this->contrato_idcontrato->QueryStringValue = $masterTbl->idcontrato->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->contrato_idcontrato->setSessionValue($this->contrato_idcontrato->QueryStringValue);
                    $foreignKeys["contrato_idcontrato"] = $this->contrato_idcontrato->QueryStringValue;
                    if (!is_numeric($masterTbl->idcontrato->QueryStringValue)) {
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
            if ($masterTblVar == "contrato") {
                $validMaster = true;
                $masterTbl = Container("contrato");
                if (($parm = Post("fk_idcontrato", Post("contrato_idcontrato"))) !== null) {
                    $masterTbl->idcontrato->setFormValue($parm);
                    $this->contrato_idcontrato->FormValue = $masterTbl->idcontrato->FormValue;
                    $this->contrato_idcontrato->setSessionValue($this->contrato_idcontrato->FormValue);
                    $foreignKeys["contrato_idcontrato"] = $this->contrato_idcontrato->FormValue;
                    if (!is_numeric($masterTbl->idcontrato->FormValue)) {
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
            $this->setSessionWhere($this->getDetailFilterFromSession());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "contrato") {
                if (!array_key_exists("contrato_idcontrato", $foreignKeys)) { // Not current foreign key
                    $this->contrato_idcontrato->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PlanilhaCustoContratoList"), "", $this->TableVar, true);
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
                case "x_escala_idescala":
                    break;
                case "x_periodo_idperiodo":
                    break;
                case "x_tipo_intrajornada_idtipo_intrajornada":
                    break;
                case "x_cargo_idcargo":
                    break;
                case "x_acumulo_funcao":
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
