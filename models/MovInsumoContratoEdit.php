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
class MovInsumoContratoEdit extends MovInsumoContrato
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "MovInsumoContratoEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "MovInsumoContratoEdit";

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
        $this->idmov_insumo_contrato->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->tipo_insumo_idtipo_insumo->setVisibility();
        $this->insumo_idinsumo->setVisibility();
        $this->qtde->setVisibility();
        $this->vr_unit->setVisibility();
        $this->frequencia->setVisibility();
        $this->contrato_idcontrato->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'mov_insumo_contrato';
        $this->TableName = 'mov_insumo_contrato';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (mov_insumo_contrato)
        if (!isset($GLOBALS["mov_insumo_contrato"]) || $GLOBALS["mov_insumo_contrato"]::class == PROJECT_NAMESPACE . "mov_insumo_contrato") {
            $GLOBALS["mov_insumo_contrato"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'mov_insumo_contrato');
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
                        $result["view"] = SameString($pageName, "MovInsumoContratoView"); // If View page, no primary button
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
            $key .= @$ar['idmov_insumo_contrato'];
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
            $this->idmov_insumo_contrato->Visible = false;
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
        $this->vr_unit->Required = false;

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
        $this->setupLookupOptions($this->tipo_insumo_idtipo_insumo);
        $this->setupLookupOptions($this->insumo_idinsumo);
        $this->setupLookupOptions($this->frequencia);

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
            if (($keyValue = Get("idmov_insumo_contrato") ?? Key(0) ?? Route(2)) !== null) {
                $this->idmov_insumo_contrato->setQueryStringValue($keyValue);
                $this->idmov_insumo_contrato->setOldValue($this->idmov_insumo_contrato->QueryStringValue);
            } elseif (Post("idmov_insumo_contrato") !== null) {
                $this->idmov_insumo_contrato->setFormValue(Post("idmov_insumo_contrato"));
                $this->idmov_insumo_contrato->setOldValue($this->idmov_insumo_contrato->FormValue);
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
                if (($keyValue = Get("idmov_insumo_contrato") ?? Route("idmov_insumo_contrato")) !== null) {
                    $this->idmov_insumo_contrato->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idmov_insumo_contrato->CurrentValue = null;
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
                        $this->terminate("MovInsumoContratoList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "MovInsumoContratoList") {
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
                        if (GetPageName($returnUrl) != "MovInsumoContratoList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "MovInsumoContratoList"; // Return list page content
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

        // Check field name 'idmov_insumo_contrato' first before field var 'x_idmov_insumo_contrato'
        $val = $CurrentForm->hasValue("idmov_insumo_contrato") ? $CurrentForm->getValue("idmov_insumo_contrato") : $CurrentForm->getValue("x_idmov_insumo_contrato");
        if (!$this->idmov_insumo_contrato->IsDetailKey) {
            $this->idmov_insumo_contrato->setFormValue($val);
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

        // Check field name 'tipo_insumo_idtipo_insumo' first before field var 'x_tipo_insumo_idtipo_insumo'
        $val = $CurrentForm->hasValue("tipo_insumo_idtipo_insumo") ? $CurrentForm->getValue("tipo_insumo_idtipo_insumo") : $CurrentForm->getValue("x_tipo_insumo_idtipo_insumo");
        if (!$this->tipo_insumo_idtipo_insumo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_insumo_idtipo_insumo->Visible = false; // Disable update for API request
            } else {
                $this->tipo_insumo_idtipo_insumo->setFormValue($val);
            }
        }

        // Check field name 'insumo_idinsumo' first before field var 'x_insumo_idinsumo'
        $val = $CurrentForm->hasValue("insumo_idinsumo") ? $CurrentForm->getValue("insumo_idinsumo") : $CurrentForm->getValue("x_insumo_idinsumo");
        if (!$this->insumo_idinsumo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->insumo_idinsumo->Visible = false; // Disable update for API request
            } else {
                $this->insumo_idinsumo->setFormValue($val);
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

        // Check field name 'vr_unit' first before field var 'x_vr_unit'
        $val = $CurrentForm->hasValue("vr_unit") ? $CurrentForm->getValue("vr_unit") : $CurrentForm->getValue("x_vr_unit");
        if (!$this->vr_unit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vr_unit->Visible = false; // Disable update for API request
            } else {
                $this->vr_unit->setFormValue($val);
            }
        }

        // Check field name 'frequencia' first before field var 'x_frequencia'
        $val = $CurrentForm->hasValue("frequencia") ? $CurrentForm->getValue("frequencia") : $CurrentForm->getValue("x_frequencia");
        if (!$this->frequencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->frequencia->Visible = false; // Disable update for API request
            } else {
                $this->frequencia->setFormValue($val);
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
        $this->idmov_insumo_contrato->CurrentValue = $this->idmov_insumo_contrato->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->tipo_insumo_idtipo_insumo->CurrentValue = $this->tipo_insumo_idtipo_insumo->FormValue;
        $this->insumo_idinsumo->CurrentValue = $this->insumo_idinsumo->FormValue;
        $this->qtde->CurrentValue = $this->qtde->FormValue;
        $this->vr_unit->CurrentValue = $this->vr_unit->FormValue;
        $this->frequencia->CurrentValue = $this->frequencia->FormValue;
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
        $this->idmov_insumo_contrato->setDbValue($row['idmov_insumo_contrato']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->tipo_insumo_idtipo_insumo->setDbValue($row['tipo_insumo_idtipo_insumo']);
        $this->insumo_idinsumo->setDbValue($row['insumo_idinsumo']);
        $this->qtde->setDbValue($row['qtde']);
        $this->vr_unit->setDbValue($row['vr_unit']);
        $this->frequencia->setDbValue($row['frequencia']);
        $this->contrato_idcontrato->setDbValue($row['contrato_idcontrato']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idmov_insumo_contrato'] = $this->idmov_insumo_contrato->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['tipo_insumo_idtipo_insumo'] = $this->tipo_insumo_idtipo_insumo->DefaultValue;
        $row['insumo_idinsumo'] = $this->insumo_idinsumo->DefaultValue;
        $row['qtde'] = $this->qtde->DefaultValue;
        $row['vr_unit'] = $this->vr_unit->DefaultValue;
        $row['frequencia'] = $this->frequencia->DefaultValue;
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

        // idmov_insumo_contrato
        $this->idmov_insumo_contrato->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // tipo_insumo_idtipo_insumo
        $this->tipo_insumo_idtipo_insumo->RowCssClass = "row";

        // insumo_idinsumo
        $this->insumo_idinsumo->RowCssClass = "row";

        // qtde
        $this->qtde->RowCssClass = "row";

        // vr_unit
        $this->vr_unit->RowCssClass = "row";

        // frequencia
        $this->frequencia->RowCssClass = "row";

        // contrato_idcontrato
        $this->contrato_idcontrato->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idmov_insumo_contrato
            $this->idmov_insumo_contrato->ViewValue = $this->idmov_insumo_contrato->CurrentValue;

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // tipo_insumo_idtipo_insumo
            $curVal = strval($this->tipo_insumo_idtipo_insumo->CurrentValue);
            if ($curVal != "") {
                $this->tipo_insumo_idtipo_insumo->ViewValue = $this->tipo_insumo_idtipo_insumo->lookupCacheOption($curVal);
                if ($this->tipo_insumo_idtipo_insumo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_insumo_idtipo_insumo->Lookup->getTable()->Fields["idtipo_insumo"]->searchExpression(), "=", $curVal, $this->tipo_insumo_idtipo_insumo->Lookup->getTable()->Fields["idtipo_insumo"]->searchDataType(), "");
                    $sqlWrk = $this->tipo_insumo_idtipo_insumo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_insumo_idtipo_insumo->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_insumo_idtipo_insumo->ViewValue = $this->tipo_insumo_idtipo_insumo->displayValue($arwrk);
                    } else {
                        $this->tipo_insumo_idtipo_insumo->ViewValue = FormatNumber($this->tipo_insumo_idtipo_insumo->CurrentValue, $this->tipo_insumo_idtipo_insumo->formatPattern());
                    }
                }
            } else {
                $this->tipo_insumo_idtipo_insumo->ViewValue = null;
            }
            $this->tipo_insumo_idtipo_insumo->CssClass = "fw-bold";

            // insumo_idinsumo
            $curVal = strval($this->insumo_idinsumo->CurrentValue);
            if ($curVal != "") {
                $this->insumo_idinsumo->ViewValue = $this->insumo_idinsumo->lookupCacheOption($curVal);
                if ($this->insumo_idinsumo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->insumo_idinsumo->Lookup->getTable()->Fields["idinsumo"]->searchExpression(), "=", $curVal, $this->insumo_idinsumo->Lookup->getTable()->Fields["idinsumo"]->searchDataType(), "");
                    $sqlWrk = $this->insumo_idinsumo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->insumo_idinsumo->Lookup->renderViewRow($rswrk[0]);
                        $this->insumo_idinsumo->ViewValue = $this->insumo_idinsumo->displayValue($arwrk);
                    } else {
                        $this->insumo_idinsumo->ViewValue = FormatNumber($this->insumo_idinsumo->CurrentValue, $this->insumo_idinsumo->formatPattern());
                    }
                }
            } else {
                $this->insumo_idinsumo->ViewValue = null;
            }
            $this->insumo_idinsumo->CssClass = "fw-bold";

            // qtde
            $this->qtde->ViewValue = $this->qtde->CurrentValue;
            $this->qtde->ViewValue = FormatNumber($this->qtde->ViewValue, $this->qtde->formatPattern());
            $this->qtde->CssClass = "fw-bold";
            $this->qtde->CellCssStyle .= "text-align: right;";

            // vr_unit
            $this->vr_unit->ViewValue = $this->vr_unit->CurrentValue;
            $this->vr_unit->ViewValue = FormatCurrency($this->vr_unit->ViewValue, $this->vr_unit->formatPattern());
            $this->vr_unit->CssClass = "fw-bold";
            $this->vr_unit->CellCssStyle .= "text-align: right;";

            // frequencia
            if (strval($this->frequencia->CurrentValue) != "") {
                $this->frequencia->ViewValue = $this->frequencia->optionCaption($this->frequencia->CurrentValue);
            } else {
                $this->frequencia->ViewValue = null;
            }
            $this->frequencia->CssClass = "fw-bold";
            $this->frequencia->CellCssStyle .= "text-align: center;";

            // contrato_idcontrato
            $this->contrato_idcontrato->ViewValue = $this->contrato_idcontrato->CurrentValue;
            $this->contrato_idcontrato->ViewValue = FormatNumber($this->contrato_idcontrato->ViewValue, $this->contrato_idcontrato->formatPattern());
            $this->contrato_idcontrato->CssClass = "fw-bold";
            $this->contrato_idcontrato->CellCssStyle .= "text-align: center;";

            // idmov_insumo_contrato
            $this->idmov_insumo_contrato->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // tipo_insumo_idtipo_insumo
            $this->tipo_insumo_idtipo_insumo->HrefValue = "";

            // insumo_idinsumo
            $this->insumo_idinsumo->HrefValue = "";

            // qtde
            $this->qtde->HrefValue = "";

            // vr_unit
            $this->vr_unit->HrefValue = "";
            $this->vr_unit->TooltipValue = "";

            // frequencia
            $this->frequencia->HrefValue = "";

            // contrato_idcontrato
            $this->contrato_idcontrato->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // idmov_insumo_contrato
            $this->idmov_insumo_contrato->setupEditAttributes();
            $this->idmov_insumo_contrato->EditValue = $this->idmov_insumo_contrato->CurrentValue;

            // dt_cadastro

            // tipo_insumo_idtipo_insumo
            $curVal = trim(strval($this->tipo_insumo_idtipo_insumo->CurrentValue));
            if ($curVal != "") {
                $this->tipo_insumo_idtipo_insumo->ViewValue = $this->tipo_insumo_idtipo_insumo->lookupCacheOption($curVal);
            } else {
                $this->tipo_insumo_idtipo_insumo->ViewValue = $this->tipo_insumo_idtipo_insumo->Lookup !== null && is_array($this->tipo_insumo_idtipo_insumo->lookupOptions()) && count($this->tipo_insumo_idtipo_insumo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_insumo_idtipo_insumo->ViewValue !== null) { // Load from cache
                $this->tipo_insumo_idtipo_insumo->EditValue = array_values($this->tipo_insumo_idtipo_insumo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_insumo_idtipo_insumo->Lookup->getTable()->Fields["idtipo_insumo"]->searchExpression(), "=", $this->tipo_insumo_idtipo_insumo->CurrentValue, $this->tipo_insumo_idtipo_insumo->Lookup->getTable()->Fields["idtipo_insumo"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipo_insumo_idtipo_insumo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_insumo_idtipo_insumo->EditValue = $arwrk;
            }
            $this->tipo_insumo_idtipo_insumo->PlaceHolder = RemoveHtml($this->tipo_insumo_idtipo_insumo->caption());

            // insumo_idinsumo
            $curVal = trim(strval($this->insumo_idinsumo->CurrentValue));
            if ($curVal != "") {
                $this->insumo_idinsumo->ViewValue = $this->insumo_idinsumo->lookupCacheOption($curVal);
            } else {
                $this->insumo_idinsumo->ViewValue = $this->insumo_idinsumo->Lookup !== null && is_array($this->insumo_idinsumo->lookupOptions()) && count($this->insumo_idinsumo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->insumo_idinsumo->ViewValue !== null) { // Load from cache
                $this->insumo_idinsumo->EditValue = array_values($this->insumo_idinsumo->lookupOptions());
                if ($this->insumo_idinsumo->ViewValue == "") {
                    $this->insumo_idinsumo->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->insumo_idinsumo->Lookup->getTable()->Fields["idinsumo"]->searchExpression(), "=", $this->insumo_idinsumo->CurrentValue, $this->insumo_idinsumo->Lookup->getTable()->Fields["idinsumo"]->searchDataType(), "");
                }
                $sqlWrk = $this->insumo_idinsumo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->insumo_idinsumo->Lookup->renderViewRow($rswrk[0]);
                    $this->insumo_idinsumo->ViewValue = $this->insumo_idinsumo->displayValue($arwrk);
                } else {
                    $this->insumo_idinsumo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->insumo_idinsumo->Lookup->renderViewRow($row);
                }
                $this->insumo_idinsumo->EditValue = $arwrk;
            }
            $this->insumo_idinsumo->PlaceHolder = RemoveHtml($this->insumo_idinsumo->caption());

            // qtde
            $this->qtde->setupEditAttributes();
            $this->qtde->EditValue = $this->qtde->CurrentValue;
            $this->qtde->PlaceHolder = RemoveHtml($this->qtde->caption());
            if (strval($this->qtde->EditValue) != "" && is_numeric($this->qtde->EditValue)) {
                $this->qtde->EditValue = FormatNumber($this->qtde->EditValue, null);
            }

            // vr_unit
            $this->vr_unit->setupEditAttributes();
            $this->vr_unit->EditValue = $this->vr_unit->CurrentValue;
            $this->vr_unit->EditValue = FormatCurrency($this->vr_unit->EditValue, $this->vr_unit->formatPattern());
            $this->vr_unit->CssClass = "fw-bold";
            $this->vr_unit->CellCssStyle .= "text-align: right;";

            // frequencia
            $this->frequencia->EditValue = $this->frequencia->options(false);
            $this->frequencia->PlaceHolder = RemoveHtml($this->frequencia->caption());

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

            // idmov_insumo_contrato
            $this->idmov_insumo_contrato->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // tipo_insumo_idtipo_insumo
            $this->tipo_insumo_idtipo_insumo->HrefValue = "";

            // insumo_idinsumo
            $this->insumo_idinsumo->HrefValue = "";

            // qtde
            $this->qtde->HrefValue = "";

            // vr_unit
            $this->vr_unit->HrefValue = "";
            $this->vr_unit->TooltipValue = "";

            // frequencia
            $this->frequencia->HrefValue = "";

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
            if ($this->idmov_insumo_contrato->Visible && $this->idmov_insumo_contrato->Required) {
                if (!$this->idmov_insumo_contrato->IsDetailKey && EmptyValue($this->idmov_insumo_contrato->FormValue)) {
                    $this->idmov_insumo_contrato->addErrorMessage(str_replace("%s", $this->idmov_insumo_contrato->caption(), $this->idmov_insumo_contrato->RequiredErrorMessage));
                }
            }
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
            }
            if ($this->tipo_insumo_idtipo_insumo->Visible && $this->tipo_insumo_idtipo_insumo->Required) {
                if ($this->tipo_insumo_idtipo_insumo->FormValue == "") {
                    $this->tipo_insumo_idtipo_insumo->addErrorMessage(str_replace("%s", $this->tipo_insumo_idtipo_insumo->caption(), $this->tipo_insumo_idtipo_insumo->RequiredErrorMessage));
                }
            }
            if ($this->insumo_idinsumo->Visible && $this->insumo_idinsumo->Required) {
                if (!$this->insumo_idinsumo->IsDetailKey && EmptyValue($this->insumo_idinsumo->FormValue)) {
                    $this->insumo_idinsumo->addErrorMessage(str_replace("%s", $this->insumo_idinsumo->caption(), $this->insumo_idinsumo->RequiredErrorMessage));
                }
            }
            if ($this->qtde->Visible && $this->qtde->Required) {
                if (!$this->qtde->IsDetailKey && EmptyValue($this->qtde->FormValue)) {
                    $this->qtde->addErrorMessage(str_replace("%s", $this->qtde->caption(), $this->qtde->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->qtde->FormValue)) {
                $this->qtde->addErrorMessage($this->qtde->getErrorMessage(false));
            }
            if ($this->vr_unit->Visible && $this->vr_unit->Required) {
                if (!$this->vr_unit->IsDetailKey && EmptyValue($this->vr_unit->FormValue)) {
                    $this->vr_unit->addErrorMessage(str_replace("%s", $this->vr_unit->caption(), $this->vr_unit->RequiredErrorMessage));
                }
            }
            if ($this->frequencia->Visible && $this->frequencia->Required) {
                if ($this->frequencia->FormValue == "") {
                    $this->frequencia->addErrorMessage(str_replace("%s", $this->frequencia->caption(), $this->frequencia->RequiredErrorMessage));
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

        // tipo_insumo_idtipo_insumo
        $this->tipo_insumo_idtipo_insumo->setDbValueDef($rsnew, $this->tipo_insumo_idtipo_insumo->CurrentValue, $this->tipo_insumo_idtipo_insumo->ReadOnly);

        // insumo_idinsumo
        $this->insumo_idinsumo->setDbValueDef($rsnew, $this->insumo_idinsumo->CurrentValue, $this->insumo_idinsumo->ReadOnly);

        // qtde
        $this->qtde->setDbValueDef($rsnew, $this->qtde->CurrentValue, $this->qtde->ReadOnly);

        // frequencia
        $this->frequencia->setDbValueDef($rsnew, $this->frequencia->CurrentValue, $this->frequencia->ReadOnly);

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
        if (isset($row['tipo_insumo_idtipo_insumo'])) { // tipo_insumo_idtipo_insumo
            $this->tipo_insumo_idtipo_insumo->CurrentValue = $row['tipo_insumo_idtipo_insumo'];
        }
        if (isset($row['insumo_idinsumo'])) { // insumo_idinsumo
            $this->insumo_idinsumo->CurrentValue = $row['insumo_idinsumo'];
        }
        if (isset($row['qtde'])) { // qtde
            $this->qtde->CurrentValue = $row['qtde'];
        }
        if (isset($row['frequencia'])) { // frequencia
            $this->frequencia->CurrentValue = $row['frequencia'];
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("MovInsumoContratoList"), "", $this->TableVar, true);
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
                case "x_tipo_insumo_idtipo_insumo":
                    break;
                case "x_insumo_idinsumo":
                    break;
                case "x_frequencia":
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
