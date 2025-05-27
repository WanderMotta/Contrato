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
class CargoCopyEdit extends CargoCopy
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "CargoCopyEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "CargoCopyEdit";

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
        $this->idcargo->setVisibility();
        $this->cargo->setVisibility();
        $this->abreviado->setVisibility();
        $this->salario->setVisibility();
        $this->nr_horas_mes->setVisibility();
        $this->jornada->setVisibility();
        $this->vt_dia->setVisibility();
        $this->vr_dia->setVisibility();
        $this->va_mes->setVisibility();
        $this->benef_social->setVisibility();
        $this->plr->setVisibility();
        $this->assis_medica->setVisibility();
        $this->assis_odonto->setVisibility();
        $this->modulo_idmodulo->setVisibility();
        $this->periodo_idperiodo->setVisibility();
        $this->escala_idescala->setVisibility();
        $this->nr_horas_ad_noite->setVisibility();
        $this->intrajornada->setVisibility();
        $this->tipo_uniforme_idtipo_uniforme->setVisibility();
        $this->salario_antes->setVisibility();
        $this->vt_dia_antes->setVisibility();
        $this->vr_dia_antes->setVisibility();
        $this->va_mes_antes->setVisibility();
        $this->benef_social_antes->setVisibility();
        $this->plr_antes->setVisibility();
        $this->assis_medica_antes->setVisibility();
        $this->assis_odonto_antes->setVisibility();
        $this->funcao_idfuncao->setVisibility();
        $this->salario1->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'cargo_copy';
        $this->TableName = 'cargo_copy';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (cargo_copy)
        if (!isset($GLOBALS["cargo_copy"]) || $GLOBALS["cargo_copy"]::class == PROJECT_NAMESPACE . "cargo_copy") {
            $GLOBALS["cargo_copy"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'cargo_copy');
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
                        $result["view"] = SameString($pageName, "CargoCopyView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->intrajornada);

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
            if (($keyValue = Get("idcargo") ?? Key(0) ?? Route(2)) !== null) {
                $this->idcargo->setQueryStringValue($keyValue);
                $this->idcargo->setOldValue($this->idcargo->QueryStringValue);
            } elseif (Post("idcargo") !== null) {
                $this->idcargo->setFormValue(Post("idcargo"));
                $this->idcargo->setOldValue($this->idcargo->FormValue);
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
                if (($keyValue = Get("idcargo") ?? Route("idcargo")) !== null) {
                    $this->idcargo->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idcargo->CurrentValue = null;
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
                        $this->terminate("CargoCopyList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "CargoCopyList") {
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
                        if (GetPageName($returnUrl) != "CargoCopyList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "CargoCopyList"; // Return list page content
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

        // Check field name 'idcargo' first before field var 'x_idcargo'
        $val = $CurrentForm->hasValue("idcargo") ? $CurrentForm->getValue("idcargo") : $CurrentForm->getValue("x_idcargo");
        if (!$this->idcargo->IsDetailKey) {
            $this->idcargo->setFormValue($val);
        }

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

        // Check field name 'nr_horas_mes' first before field var 'x_nr_horas_mes'
        $val = $CurrentForm->hasValue("nr_horas_mes") ? $CurrentForm->getValue("nr_horas_mes") : $CurrentForm->getValue("x_nr_horas_mes");
        if (!$this->nr_horas_mes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nr_horas_mes->Visible = false; // Disable update for API request
            } else {
                $this->nr_horas_mes->setFormValue($val, true, $validate);
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

        // Check field name 'modulo_idmodulo' first before field var 'x_modulo_idmodulo'
        $val = $CurrentForm->hasValue("modulo_idmodulo") ? $CurrentForm->getValue("modulo_idmodulo") : $CurrentForm->getValue("x_modulo_idmodulo");
        if (!$this->modulo_idmodulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->modulo_idmodulo->Visible = false; // Disable update for API request
            } else {
                $this->modulo_idmodulo->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'periodo_idperiodo' first before field var 'x_periodo_idperiodo'
        $val = $CurrentForm->hasValue("periodo_idperiodo") ? $CurrentForm->getValue("periodo_idperiodo") : $CurrentForm->getValue("x_periodo_idperiodo");
        if (!$this->periodo_idperiodo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->periodo_idperiodo->Visible = false; // Disable update for API request
            } else {
                $this->periodo_idperiodo->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'escala_idescala' first before field var 'x_escala_idescala'
        $val = $CurrentForm->hasValue("escala_idescala") ? $CurrentForm->getValue("escala_idescala") : $CurrentForm->getValue("x_escala_idescala");
        if (!$this->escala_idescala->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->escala_idescala->Visible = false; // Disable update for API request
            } else {
                $this->escala_idescala->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'nr_horas_ad_noite' first before field var 'x_nr_horas_ad_noite'
        $val = $CurrentForm->hasValue("nr_horas_ad_noite") ? $CurrentForm->getValue("nr_horas_ad_noite") : $CurrentForm->getValue("x_nr_horas_ad_noite");
        if (!$this->nr_horas_ad_noite->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nr_horas_ad_noite->Visible = false; // Disable update for API request
            } else {
                $this->nr_horas_ad_noite->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'intrajornada' first before field var 'x_intrajornada'
        $val = $CurrentForm->hasValue("intrajornada") ? $CurrentForm->getValue("intrajornada") : $CurrentForm->getValue("x_intrajornada");
        if (!$this->intrajornada->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->intrajornada->Visible = false; // Disable update for API request
            } else {
                $this->intrajornada->setFormValue($val);
            }
        }

        // Check field name 'tipo_uniforme_idtipo_uniforme' first before field var 'x_tipo_uniforme_idtipo_uniforme'
        $val = $CurrentForm->hasValue("tipo_uniforme_idtipo_uniforme") ? $CurrentForm->getValue("tipo_uniforme_idtipo_uniforme") : $CurrentForm->getValue("x_tipo_uniforme_idtipo_uniforme");
        if (!$this->tipo_uniforme_idtipo_uniforme->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_uniforme_idtipo_uniforme->Visible = false; // Disable update for API request
            } else {
                $this->tipo_uniforme_idtipo_uniforme->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'salario_antes' first before field var 'x_salario_antes'
        $val = $CurrentForm->hasValue("salario_antes") ? $CurrentForm->getValue("salario_antes") : $CurrentForm->getValue("x_salario_antes");
        if (!$this->salario_antes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->salario_antes->Visible = false; // Disable update for API request
            } else {
                $this->salario_antes->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'vt_dia_antes' first before field var 'x_vt_dia_antes'
        $val = $CurrentForm->hasValue("vt_dia_antes") ? $CurrentForm->getValue("vt_dia_antes") : $CurrentForm->getValue("x_vt_dia_antes");
        if (!$this->vt_dia_antes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vt_dia_antes->Visible = false; // Disable update for API request
            } else {
                $this->vt_dia_antes->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'vr_dia_antes' first before field var 'x_vr_dia_antes'
        $val = $CurrentForm->hasValue("vr_dia_antes") ? $CurrentForm->getValue("vr_dia_antes") : $CurrentForm->getValue("x_vr_dia_antes");
        if (!$this->vr_dia_antes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vr_dia_antes->Visible = false; // Disable update for API request
            } else {
                $this->vr_dia_antes->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'va_mes_antes' first before field var 'x_va_mes_antes'
        $val = $CurrentForm->hasValue("va_mes_antes") ? $CurrentForm->getValue("va_mes_antes") : $CurrentForm->getValue("x_va_mes_antes");
        if (!$this->va_mes_antes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->va_mes_antes->Visible = false; // Disable update for API request
            } else {
                $this->va_mes_antes->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'benef_social_antes' first before field var 'x_benef_social_antes'
        $val = $CurrentForm->hasValue("benef_social_antes") ? $CurrentForm->getValue("benef_social_antes") : $CurrentForm->getValue("x_benef_social_antes");
        if (!$this->benef_social_antes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->benef_social_antes->Visible = false; // Disable update for API request
            } else {
                $this->benef_social_antes->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'plr_antes' first before field var 'x_plr_antes'
        $val = $CurrentForm->hasValue("plr_antes") ? $CurrentForm->getValue("plr_antes") : $CurrentForm->getValue("x_plr_antes");
        if (!$this->plr_antes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->plr_antes->Visible = false; // Disable update for API request
            } else {
                $this->plr_antes->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'assis_medica_antes' first before field var 'x_assis_medica_antes'
        $val = $CurrentForm->hasValue("assis_medica_antes") ? $CurrentForm->getValue("assis_medica_antes") : $CurrentForm->getValue("x_assis_medica_antes");
        if (!$this->assis_medica_antes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->assis_medica_antes->Visible = false; // Disable update for API request
            } else {
                $this->assis_medica_antes->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'assis_odonto_antes' first before field var 'x_assis_odonto_antes'
        $val = $CurrentForm->hasValue("assis_odonto_antes") ? $CurrentForm->getValue("assis_odonto_antes") : $CurrentForm->getValue("x_assis_odonto_antes");
        if (!$this->assis_odonto_antes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->assis_odonto_antes->Visible = false; // Disable update for API request
            } else {
                $this->assis_odonto_antes->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'funcao_idfuncao' first before field var 'x_funcao_idfuncao'
        $val = $CurrentForm->hasValue("funcao_idfuncao") ? $CurrentForm->getValue("funcao_idfuncao") : $CurrentForm->getValue("x_funcao_idfuncao");
        if (!$this->funcao_idfuncao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->funcao_idfuncao->Visible = false; // Disable update for API request
            } else {
                $this->funcao_idfuncao->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'salario1' first before field var 'x_salario1'
        $val = $CurrentForm->hasValue("salario1") ? $CurrentForm->getValue("salario1") : $CurrentForm->getValue("x_salario1");
        if (!$this->salario1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->salario1->Visible = false; // Disable update for API request
            } else {
                $this->salario1->setFormValue($val, true, $validate);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idcargo->CurrentValue = $this->idcargo->FormValue;
        $this->cargo->CurrentValue = $this->cargo->FormValue;
        $this->abreviado->CurrentValue = $this->abreviado->FormValue;
        $this->salario->CurrentValue = $this->salario->FormValue;
        $this->nr_horas_mes->CurrentValue = $this->nr_horas_mes->FormValue;
        $this->jornada->CurrentValue = $this->jornada->FormValue;
        $this->vt_dia->CurrentValue = $this->vt_dia->FormValue;
        $this->vr_dia->CurrentValue = $this->vr_dia->FormValue;
        $this->va_mes->CurrentValue = $this->va_mes->FormValue;
        $this->benef_social->CurrentValue = $this->benef_social->FormValue;
        $this->plr->CurrentValue = $this->plr->FormValue;
        $this->assis_medica->CurrentValue = $this->assis_medica->FormValue;
        $this->assis_odonto->CurrentValue = $this->assis_odonto->FormValue;
        $this->modulo_idmodulo->CurrentValue = $this->modulo_idmodulo->FormValue;
        $this->periodo_idperiodo->CurrentValue = $this->periodo_idperiodo->FormValue;
        $this->escala_idescala->CurrentValue = $this->escala_idescala->FormValue;
        $this->nr_horas_ad_noite->CurrentValue = $this->nr_horas_ad_noite->FormValue;
        $this->intrajornada->CurrentValue = $this->intrajornada->FormValue;
        $this->tipo_uniforme_idtipo_uniforme->CurrentValue = $this->tipo_uniforme_idtipo_uniforme->FormValue;
        $this->salario_antes->CurrentValue = $this->salario_antes->FormValue;
        $this->vt_dia_antes->CurrentValue = $this->vt_dia_antes->FormValue;
        $this->vr_dia_antes->CurrentValue = $this->vr_dia_antes->FormValue;
        $this->va_mes_antes->CurrentValue = $this->va_mes_antes->FormValue;
        $this->benef_social_antes->CurrentValue = $this->benef_social_antes->FormValue;
        $this->plr_antes->CurrentValue = $this->plr_antes->FormValue;
        $this->assis_medica_antes->CurrentValue = $this->assis_medica_antes->FormValue;
        $this->assis_odonto_antes->CurrentValue = $this->assis_odonto_antes->FormValue;
        $this->funcao_idfuncao->CurrentValue = $this->funcao_idfuncao->FormValue;
        $this->salario1->CurrentValue = $this->salario1->FormValue;
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
        $this->idcargo->setDbValue($row['idcargo']);
        $this->cargo->setDbValue($row['cargo']);
        $this->abreviado->setDbValue($row['abreviado']);
        $this->salario->setDbValue($row['salario']);
        $this->nr_horas_mes->setDbValue($row['nr_horas_mes']);
        $this->jornada->setDbValue($row['jornada']);
        $this->vt_dia->setDbValue($row['vt_dia']);
        $this->vr_dia->setDbValue($row['vr_dia']);
        $this->va_mes->setDbValue($row['va_mes']);
        $this->benef_social->setDbValue($row['benef_social']);
        $this->plr->setDbValue($row['plr']);
        $this->assis_medica->setDbValue($row['assis_medica']);
        $this->assis_odonto->setDbValue($row['assis_odonto']);
        $this->modulo_idmodulo->setDbValue($row['modulo_idmodulo']);
        $this->periodo_idperiodo->setDbValue($row['periodo_idperiodo']);
        $this->escala_idescala->setDbValue($row['escala_idescala']);
        $this->nr_horas_ad_noite->setDbValue($row['nr_horas_ad_noite']);
        $this->intrajornada->setDbValue($row['intrajornada']);
        $this->tipo_uniforme_idtipo_uniforme->setDbValue($row['tipo_uniforme_idtipo_uniforme']);
        $this->salario_antes->setDbValue($row['salario_antes']);
        $this->vt_dia_antes->setDbValue($row['vt_dia_antes']);
        $this->vr_dia_antes->setDbValue($row['vr_dia_antes']);
        $this->va_mes_antes->setDbValue($row['va_mes_antes']);
        $this->benef_social_antes->setDbValue($row['benef_social_antes']);
        $this->plr_antes->setDbValue($row['plr_antes']);
        $this->assis_medica_antes->setDbValue($row['assis_medica_antes']);
        $this->assis_odonto_antes->setDbValue($row['assis_odonto_antes']);
        $this->funcao_idfuncao->setDbValue($row['funcao_idfuncao']);
        $this->salario1->setDbValue($row['salario1']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idcargo'] = $this->idcargo->DefaultValue;
        $row['cargo'] = $this->cargo->DefaultValue;
        $row['abreviado'] = $this->abreviado->DefaultValue;
        $row['salario'] = $this->salario->DefaultValue;
        $row['nr_horas_mes'] = $this->nr_horas_mes->DefaultValue;
        $row['jornada'] = $this->jornada->DefaultValue;
        $row['vt_dia'] = $this->vt_dia->DefaultValue;
        $row['vr_dia'] = $this->vr_dia->DefaultValue;
        $row['va_mes'] = $this->va_mes->DefaultValue;
        $row['benef_social'] = $this->benef_social->DefaultValue;
        $row['plr'] = $this->plr->DefaultValue;
        $row['assis_medica'] = $this->assis_medica->DefaultValue;
        $row['assis_odonto'] = $this->assis_odonto->DefaultValue;
        $row['modulo_idmodulo'] = $this->modulo_idmodulo->DefaultValue;
        $row['periodo_idperiodo'] = $this->periodo_idperiodo->DefaultValue;
        $row['escala_idescala'] = $this->escala_idescala->DefaultValue;
        $row['nr_horas_ad_noite'] = $this->nr_horas_ad_noite->DefaultValue;
        $row['intrajornada'] = $this->intrajornada->DefaultValue;
        $row['tipo_uniforme_idtipo_uniforme'] = $this->tipo_uniforme_idtipo_uniforme->DefaultValue;
        $row['salario_antes'] = $this->salario_antes->DefaultValue;
        $row['vt_dia_antes'] = $this->vt_dia_antes->DefaultValue;
        $row['vr_dia_antes'] = $this->vr_dia_antes->DefaultValue;
        $row['va_mes_antes'] = $this->va_mes_antes->DefaultValue;
        $row['benef_social_antes'] = $this->benef_social_antes->DefaultValue;
        $row['plr_antes'] = $this->plr_antes->DefaultValue;
        $row['assis_medica_antes'] = $this->assis_medica_antes->DefaultValue;
        $row['assis_odonto_antes'] = $this->assis_odonto_antes->DefaultValue;
        $row['funcao_idfuncao'] = $this->funcao_idfuncao->DefaultValue;
        $row['salario1'] = $this->salario1->DefaultValue;
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

        // idcargo
        $this->idcargo->RowCssClass = "row";

        // cargo
        $this->cargo->RowCssClass = "row";

        // abreviado
        $this->abreviado->RowCssClass = "row";

        // salario
        $this->salario->RowCssClass = "row";

        // nr_horas_mes
        $this->nr_horas_mes->RowCssClass = "row";

        // jornada
        $this->jornada->RowCssClass = "row";

        // vt_dia
        $this->vt_dia->RowCssClass = "row";

        // vr_dia
        $this->vr_dia->RowCssClass = "row";

        // va_mes
        $this->va_mes->RowCssClass = "row";

        // benef_social
        $this->benef_social->RowCssClass = "row";

        // plr
        $this->plr->RowCssClass = "row";

        // assis_medica
        $this->assis_medica->RowCssClass = "row";

        // assis_odonto
        $this->assis_odonto->RowCssClass = "row";

        // modulo_idmodulo
        $this->modulo_idmodulo->RowCssClass = "row";

        // periodo_idperiodo
        $this->periodo_idperiodo->RowCssClass = "row";

        // escala_idescala
        $this->escala_idescala->RowCssClass = "row";

        // nr_horas_ad_noite
        $this->nr_horas_ad_noite->RowCssClass = "row";

        // intrajornada
        $this->intrajornada->RowCssClass = "row";

        // tipo_uniforme_idtipo_uniforme
        $this->tipo_uniforme_idtipo_uniforme->RowCssClass = "row";

        // salario_antes
        $this->salario_antes->RowCssClass = "row";

        // vt_dia_antes
        $this->vt_dia_antes->RowCssClass = "row";

        // vr_dia_antes
        $this->vr_dia_antes->RowCssClass = "row";

        // va_mes_antes
        $this->va_mes_antes->RowCssClass = "row";

        // benef_social_antes
        $this->benef_social_antes->RowCssClass = "row";

        // plr_antes
        $this->plr_antes->RowCssClass = "row";

        // assis_medica_antes
        $this->assis_medica_antes->RowCssClass = "row";

        // assis_odonto_antes
        $this->assis_odonto_antes->RowCssClass = "row";

        // funcao_idfuncao
        $this->funcao_idfuncao->RowCssClass = "row";

        // salario1
        $this->salario1->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idcargo
            $this->idcargo->ViewValue = $this->idcargo->CurrentValue;

            // cargo
            $this->cargo->ViewValue = $this->cargo->CurrentValue;

            // abreviado
            $this->abreviado->ViewValue = $this->abreviado->CurrentValue;

            // salario
            $this->salario->ViewValue = $this->salario->CurrentValue;
            $this->salario->ViewValue = FormatNumber($this->salario->ViewValue, $this->salario->formatPattern());

            // nr_horas_mes
            $this->nr_horas_mes->ViewValue = $this->nr_horas_mes->CurrentValue;
            $this->nr_horas_mes->ViewValue = FormatNumber($this->nr_horas_mes->ViewValue, $this->nr_horas_mes->formatPattern());

            // jornada
            $this->jornada->ViewValue = $this->jornada->CurrentValue;
            $this->jornada->ViewValue = FormatNumber($this->jornada->ViewValue, $this->jornada->formatPattern());

            // vt_dia
            $this->vt_dia->ViewValue = $this->vt_dia->CurrentValue;
            $this->vt_dia->ViewValue = FormatNumber($this->vt_dia->ViewValue, $this->vt_dia->formatPattern());

            // vr_dia
            $this->vr_dia->ViewValue = $this->vr_dia->CurrentValue;
            $this->vr_dia->ViewValue = FormatNumber($this->vr_dia->ViewValue, $this->vr_dia->formatPattern());

            // va_mes
            $this->va_mes->ViewValue = $this->va_mes->CurrentValue;
            $this->va_mes->ViewValue = FormatNumber($this->va_mes->ViewValue, $this->va_mes->formatPattern());

            // benef_social
            $this->benef_social->ViewValue = $this->benef_social->CurrentValue;
            $this->benef_social->ViewValue = FormatNumber($this->benef_social->ViewValue, $this->benef_social->formatPattern());

            // plr
            $this->plr->ViewValue = $this->plr->CurrentValue;
            $this->plr->ViewValue = FormatNumber($this->plr->ViewValue, $this->plr->formatPattern());

            // assis_medica
            $this->assis_medica->ViewValue = $this->assis_medica->CurrentValue;
            $this->assis_medica->ViewValue = FormatNumber($this->assis_medica->ViewValue, $this->assis_medica->formatPattern());

            // assis_odonto
            $this->assis_odonto->ViewValue = $this->assis_odonto->CurrentValue;
            $this->assis_odonto->ViewValue = FormatNumber($this->assis_odonto->ViewValue, $this->assis_odonto->formatPattern());

            // modulo_idmodulo
            $this->modulo_idmodulo->ViewValue = $this->modulo_idmodulo->CurrentValue;
            $this->modulo_idmodulo->ViewValue = FormatNumber($this->modulo_idmodulo->ViewValue, $this->modulo_idmodulo->formatPattern());

            // periodo_idperiodo
            $this->periodo_idperiodo->ViewValue = $this->periodo_idperiodo->CurrentValue;
            $this->periodo_idperiodo->ViewValue = FormatNumber($this->periodo_idperiodo->ViewValue, $this->periodo_idperiodo->formatPattern());

            // escala_idescala
            $this->escala_idescala->ViewValue = $this->escala_idescala->CurrentValue;
            $this->escala_idescala->ViewValue = FormatNumber($this->escala_idescala->ViewValue, $this->escala_idescala->formatPattern());

            // nr_horas_ad_noite
            $this->nr_horas_ad_noite->ViewValue = $this->nr_horas_ad_noite->CurrentValue;
            $this->nr_horas_ad_noite->ViewValue = FormatNumber($this->nr_horas_ad_noite->ViewValue, $this->nr_horas_ad_noite->formatPattern());

            // intrajornada
            if (strval($this->intrajornada->CurrentValue) != "") {
                $this->intrajornada->ViewValue = $this->intrajornada->optionCaption($this->intrajornada->CurrentValue);
            } else {
                $this->intrajornada->ViewValue = null;
            }

            // tipo_uniforme_idtipo_uniforme
            $this->tipo_uniforme_idtipo_uniforme->ViewValue = $this->tipo_uniforme_idtipo_uniforme->CurrentValue;
            $this->tipo_uniforme_idtipo_uniforme->ViewValue = FormatNumber($this->tipo_uniforme_idtipo_uniforme->ViewValue, $this->tipo_uniforme_idtipo_uniforme->formatPattern());

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

            // funcao_idfuncao
            $this->funcao_idfuncao->ViewValue = $this->funcao_idfuncao->CurrentValue;
            $this->funcao_idfuncao->ViewValue = FormatNumber($this->funcao_idfuncao->ViewValue, $this->funcao_idfuncao->formatPattern());

            // salario1
            $this->salario1->ViewValue = $this->salario1->CurrentValue;
            $this->salario1->ViewValue = FormatNumber($this->salario1->ViewValue, $this->salario1->formatPattern());

            // idcargo
            $this->idcargo->HrefValue = "";

            // cargo
            $this->cargo->HrefValue = "";

            // abreviado
            $this->abreviado->HrefValue = "";

            // salario
            $this->salario->HrefValue = "";

            // nr_horas_mes
            $this->nr_horas_mes->HrefValue = "";

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

            // modulo_idmodulo
            $this->modulo_idmodulo->HrefValue = "";

            // periodo_idperiodo
            $this->periodo_idperiodo->HrefValue = "";

            // escala_idescala
            $this->escala_idescala->HrefValue = "";

            // nr_horas_ad_noite
            $this->nr_horas_ad_noite->HrefValue = "";

            // intrajornada
            $this->intrajornada->HrefValue = "";

            // tipo_uniforme_idtipo_uniforme
            $this->tipo_uniforme_idtipo_uniforme->HrefValue = "";

            // salario_antes
            $this->salario_antes->HrefValue = "";

            // vt_dia_antes
            $this->vt_dia_antes->HrefValue = "";

            // vr_dia_antes
            $this->vr_dia_antes->HrefValue = "";

            // va_mes_antes
            $this->va_mes_antes->HrefValue = "";

            // benef_social_antes
            $this->benef_social_antes->HrefValue = "";

            // plr_antes
            $this->plr_antes->HrefValue = "";

            // assis_medica_antes
            $this->assis_medica_antes->HrefValue = "";

            // assis_odonto_antes
            $this->assis_odonto_antes->HrefValue = "";

            // funcao_idfuncao
            $this->funcao_idfuncao->HrefValue = "";

            // salario1
            $this->salario1->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // idcargo
            $this->idcargo->setupEditAttributes();
            $this->idcargo->EditValue = $this->idcargo->CurrentValue;

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

            // nr_horas_mes
            $this->nr_horas_mes->setupEditAttributes();
            $this->nr_horas_mes->EditValue = $this->nr_horas_mes->CurrentValue;
            $this->nr_horas_mes->PlaceHolder = RemoveHtml($this->nr_horas_mes->caption());
            if (strval($this->nr_horas_mes->EditValue) != "" && is_numeric($this->nr_horas_mes->EditValue)) {
                $this->nr_horas_mes->EditValue = FormatNumber($this->nr_horas_mes->EditValue, null);
            }

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

            // modulo_idmodulo
            $this->modulo_idmodulo->setupEditAttributes();
            $this->modulo_idmodulo->EditValue = $this->modulo_idmodulo->CurrentValue;
            $this->modulo_idmodulo->PlaceHolder = RemoveHtml($this->modulo_idmodulo->caption());
            if (strval($this->modulo_idmodulo->EditValue) != "" && is_numeric($this->modulo_idmodulo->EditValue)) {
                $this->modulo_idmodulo->EditValue = FormatNumber($this->modulo_idmodulo->EditValue, null);
            }

            // periodo_idperiodo
            $this->periodo_idperiodo->setupEditAttributes();
            $this->periodo_idperiodo->EditValue = $this->periodo_idperiodo->CurrentValue;
            $this->periodo_idperiodo->PlaceHolder = RemoveHtml($this->periodo_idperiodo->caption());
            if (strval($this->periodo_idperiodo->EditValue) != "" && is_numeric($this->periodo_idperiodo->EditValue)) {
                $this->periodo_idperiodo->EditValue = FormatNumber($this->periodo_idperiodo->EditValue, null);
            }

            // escala_idescala
            $this->escala_idescala->setupEditAttributes();
            $this->escala_idescala->EditValue = $this->escala_idescala->CurrentValue;
            $this->escala_idescala->PlaceHolder = RemoveHtml($this->escala_idescala->caption());
            if (strval($this->escala_idescala->EditValue) != "" && is_numeric($this->escala_idescala->EditValue)) {
                $this->escala_idescala->EditValue = FormatNumber($this->escala_idescala->EditValue, null);
            }

            // nr_horas_ad_noite
            $this->nr_horas_ad_noite->setupEditAttributes();
            $this->nr_horas_ad_noite->EditValue = $this->nr_horas_ad_noite->CurrentValue;
            $this->nr_horas_ad_noite->PlaceHolder = RemoveHtml($this->nr_horas_ad_noite->caption());
            if (strval($this->nr_horas_ad_noite->EditValue) != "" && is_numeric($this->nr_horas_ad_noite->EditValue)) {
                $this->nr_horas_ad_noite->EditValue = FormatNumber($this->nr_horas_ad_noite->EditValue, null);
            }

            // intrajornada
            $this->intrajornada->EditValue = $this->intrajornada->options(false);
            $this->intrajornada->PlaceHolder = RemoveHtml($this->intrajornada->caption());

            // tipo_uniforme_idtipo_uniforme
            $this->tipo_uniforme_idtipo_uniforme->setupEditAttributes();
            $this->tipo_uniforme_idtipo_uniforme->EditValue = $this->tipo_uniforme_idtipo_uniforme->CurrentValue;
            $this->tipo_uniforme_idtipo_uniforme->PlaceHolder = RemoveHtml($this->tipo_uniforme_idtipo_uniforme->caption());
            if (strval($this->tipo_uniforme_idtipo_uniforme->EditValue) != "" && is_numeric($this->tipo_uniforme_idtipo_uniforme->EditValue)) {
                $this->tipo_uniforme_idtipo_uniforme->EditValue = FormatNumber($this->tipo_uniforme_idtipo_uniforme->EditValue, null);
            }

            // salario_antes
            $this->salario_antes->setupEditAttributes();
            $this->salario_antes->EditValue = $this->salario_antes->CurrentValue;
            $this->salario_antes->PlaceHolder = RemoveHtml($this->salario_antes->caption());
            if (strval($this->salario_antes->EditValue) != "" && is_numeric($this->salario_antes->EditValue)) {
                $this->salario_antes->EditValue = FormatNumber($this->salario_antes->EditValue, null);
            }

            // vt_dia_antes
            $this->vt_dia_antes->setupEditAttributes();
            $this->vt_dia_antes->EditValue = $this->vt_dia_antes->CurrentValue;
            $this->vt_dia_antes->PlaceHolder = RemoveHtml($this->vt_dia_antes->caption());
            if (strval($this->vt_dia_antes->EditValue) != "" && is_numeric($this->vt_dia_antes->EditValue)) {
                $this->vt_dia_antes->EditValue = FormatNumber($this->vt_dia_antes->EditValue, null);
            }

            // vr_dia_antes
            $this->vr_dia_antes->setupEditAttributes();
            $this->vr_dia_antes->EditValue = $this->vr_dia_antes->CurrentValue;
            $this->vr_dia_antes->PlaceHolder = RemoveHtml($this->vr_dia_antes->caption());
            if (strval($this->vr_dia_antes->EditValue) != "" && is_numeric($this->vr_dia_antes->EditValue)) {
                $this->vr_dia_antes->EditValue = FormatNumber($this->vr_dia_antes->EditValue, null);
            }

            // va_mes_antes
            $this->va_mes_antes->setupEditAttributes();
            $this->va_mes_antes->EditValue = $this->va_mes_antes->CurrentValue;
            $this->va_mes_antes->PlaceHolder = RemoveHtml($this->va_mes_antes->caption());
            if (strval($this->va_mes_antes->EditValue) != "" && is_numeric($this->va_mes_antes->EditValue)) {
                $this->va_mes_antes->EditValue = FormatNumber($this->va_mes_antes->EditValue, null);
            }

            // benef_social_antes
            $this->benef_social_antes->setupEditAttributes();
            $this->benef_social_antes->EditValue = $this->benef_social_antes->CurrentValue;
            $this->benef_social_antes->PlaceHolder = RemoveHtml($this->benef_social_antes->caption());
            if (strval($this->benef_social_antes->EditValue) != "" && is_numeric($this->benef_social_antes->EditValue)) {
                $this->benef_social_antes->EditValue = FormatNumber($this->benef_social_antes->EditValue, null);
            }

            // plr_antes
            $this->plr_antes->setupEditAttributes();
            $this->plr_antes->EditValue = $this->plr_antes->CurrentValue;
            $this->plr_antes->PlaceHolder = RemoveHtml($this->plr_antes->caption());
            if (strval($this->plr_antes->EditValue) != "" && is_numeric($this->plr_antes->EditValue)) {
                $this->plr_antes->EditValue = FormatNumber($this->plr_antes->EditValue, null);
            }

            // assis_medica_antes
            $this->assis_medica_antes->setupEditAttributes();
            $this->assis_medica_antes->EditValue = $this->assis_medica_antes->CurrentValue;
            $this->assis_medica_antes->PlaceHolder = RemoveHtml($this->assis_medica_antes->caption());
            if (strval($this->assis_medica_antes->EditValue) != "" && is_numeric($this->assis_medica_antes->EditValue)) {
                $this->assis_medica_antes->EditValue = FormatNumber($this->assis_medica_antes->EditValue, null);
            }

            // assis_odonto_antes
            $this->assis_odonto_antes->setupEditAttributes();
            $this->assis_odonto_antes->EditValue = $this->assis_odonto_antes->CurrentValue;
            $this->assis_odonto_antes->PlaceHolder = RemoveHtml($this->assis_odonto_antes->caption());
            if (strval($this->assis_odonto_antes->EditValue) != "" && is_numeric($this->assis_odonto_antes->EditValue)) {
                $this->assis_odonto_antes->EditValue = FormatNumber($this->assis_odonto_antes->EditValue, null);
            }

            // funcao_idfuncao
            $this->funcao_idfuncao->setupEditAttributes();
            $this->funcao_idfuncao->EditValue = $this->funcao_idfuncao->CurrentValue;
            $this->funcao_idfuncao->PlaceHolder = RemoveHtml($this->funcao_idfuncao->caption());
            if (strval($this->funcao_idfuncao->EditValue) != "" && is_numeric($this->funcao_idfuncao->EditValue)) {
                $this->funcao_idfuncao->EditValue = FormatNumber($this->funcao_idfuncao->EditValue, null);
            }

            // salario1
            $this->salario1->setupEditAttributes();
            $this->salario1->EditValue = $this->salario1->CurrentValue;
            $this->salario1->PlaceHolder = RemoveHtml($this->salario1->caption());
            if (strval($this->salario1->EditValue) != "" && is_numeric($this->salario1->EditValue)) {
                $this->salario1->EditValue = FormatNumber($this->salario1->EditValue, null);
            }

            // Edit refer script

            // idcargo
            $this->idcargo->HrefValue = "";

            // cargo
            $this->cargo->HrefValue = "";

            // abreviado
            $this->abreviado->HrefValue = "";

            // salario
            $this->salario->HrefValue = "";

            // nr_horas_mes
            $this->nr_horas_mes->HrefValue = "";

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

            // modulo_idmodulo
            $this->modulo_idmodulo->HrefValue = "";

            // periodo_idperiodo
            $this->periodo_idperiodo->HrefValue = "";

            // escala_idescala
            $this->escala_idescala->HrefValue = "";

            // nr_horas_ad_noite
            $this->nr_horas_ad_noite->HrefValue = "";

            // intrajornada
            $this->intrajornada->HrefValue = "";

            // tipo_uniforme_idtipo_uniforme
            $this->tipo_uniforme_idtipo_uniforme->HrefValue = "";

            // salario_antes
            $this->salario_antes->HrefValue = "";

            // vt_dia_antes
            $this->vt_dia_antes->HrefValue = "";

            // vr_dia_antes
            $this->vr_dia_antes->HrefValue = "";

            // va_mes_antes
            $this->va_mes_antes->HrefValue = "";

            // benef_social_antes
            $this->benef_social_antes->HrefValue = "";

            // plr_antes
            $this->plr_antes->HrefValue = "";

            // assis_medica_antes
            $this->assis_medica_antes->HrefValue = "";

            // assis_odonto_antes
            $this->assis_odonto_antes->HrefValue = "";

            // funcao_idfuncao
            $this->funcao_idfuncao->HrefValue = "";

            // salario1
            $this->salario1->HrefValue = "";
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
            if ($this->idcargo->Visible && $this->idcargo->Required) {
                if (!$this->idcargo->IsDetailKey && EmptyValue($this->idcargo->FormValue)) {
                    $this->idcargo->addErrorMessage(str_replace("%s", $this->idcargo->caption(), $this->idcargo->RequiredErrorMessage));
                }
            }
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
            if ($this->nr_horas_mes->Visible && $this->nr_horas_mes->Required) {
                if (!$this->nr_horas_mes->IsDetailKey && EmptyValue($this->nr_horas_mes->FormValue)) {
                    $this->nr_horas_mes->addErrorMessage(str_replace("%s", $this->nr_horas_mes->caption(), $this->nr_horas_mes->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->nr_horas_mes->FormValue)) {
                $this->nr_horas_mes->addErrorMessage($this->nr_horas_mes->getErrorMessage(false));
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
            if ($this->modulo_idmodulo->Visible && $this->modulo_idmodulo->Required) {
                if (!$this->modulo_idmodulo->IsDetailKey && EmptyValue($this->modulo_idmodulo->FormValue)) {
                    $this->modulo_idmodulo->addErrorMessage(str_replace("%s", $this->modulo_idmodulo->caption(), $this->modulo_idmodulo->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->modulo_idmodulo->FormValue)) {
                $this->modulo_idmodulo->addErrorMessage($this->modulo_idmodulo->getErrorMessage(false));
            }
            if ($this->periodo_idperiodo->Visible && $this->periodo_idperiodo->Required) {
                if (!$this->periodo_idperiodo->IsDetailKey && EmptyValue($this->periodo_idperiodo->FormValue)) {
                    $this->periodo_idperiodo->addErrorMessage(str_replace("%s", $this->periodo_idperiodo->caption(), $this->periodo_idperiodo->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->periodo_idperiodo->FormValue)) {
                $this->periodo_idperiodo->addErrorMessage($this->periodo_idperiodo->getErrorMessage(false));
            }
            if ($this->escala_idescala->Visible && $this->escala_idescala->Required) {
                if (!$this->escala_idescala->IsDetailKey && EmptyValue($this->escala_idescala->FormValue)) {
                    $this->escala_idescala->addErrorMessage(str_replace("%s", $this->escala_idescala->caption(), $this->escala_idescala->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->escala_idescala->FormValue)) {
                $this->escala_idescala->addErrorMessage($this->escala_idescala->getErrorMessage(false));
            }
            if ($this->nr_horas_ad_noite->Visible && $this->nr_horas_ad_noite->Required) {
                if (!$this->nr_horas_ad_noite->IsDetailKey && EmptyValue($this->nr_horas_ad_noite->FormValue)) {
                    $this->nr_horas_ad_noite->addErrorMessage(str_replace("%s", $this->nr_horas_ad_noite->caption(), $this->nr_horas_ad_noite->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->nr_horas_ad_noite->FormValue)) {
                $this->nr_horas_ad_noite->addErrorMessage($this->nr_horas_ad_noite->getErrorMessage(false));
            }
            if ($this->intrajornada->Visible && $this->intrajornada->Required) {
                if ($this->intrajornada->FormValue == "") {
                    $this->intrajornada->addErrorMessage(str_replace("%s", $this->intrajornada->caption(), $this->intrajornada->RequiredErrorMessage));
                }
            }
            if ($this->tipo_uniforme_idtipo_uniforme->Visible && $this->tipo_uniforme_idtipo_uniforme->Required) {
                if (!$this->tipo_uniforme_idtipo_uniforme->IsDetailKey && EmptyValue($this->tipo_uniforme_idtipo_uniforme->FormValue)) {
                    $this->tipo_uniforme_idtipo_uniforme->addErrorMessage(str_replace("%s", $this->tipo_uniforme_idtipo_uniforme->caption(), $this->tipo_uniforme_idtipo_uniforme->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->tipo_uniforme_idtipo_uniforme->FormValue)) {
                $this->tipo_uniforme_idtipo_uniforme->addErrorMessage($this->tipo_uniforme_idtipo_uniforme->getErrorMessage(false));
            }
            if ($this->salario_antes->Visible && $this->salario_antes->Required) {
                if (!$this->salario_antes->IsDetailKey && EmptyValue($this->salario_antes->FormValue)) {
                    $this->salario_antes->addErrorMessage(str_replace("%s", $this->salario_antes->caption(), $this->salario_antes->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->salario_antes->FormValue)) {
                $this->salario_antes->addErrorMessage($this->salario_antes->getErrorMessage(false));
            }
            if ($this->vt_dia_antes->Visible && $this->vt_dia_antes->Required) {
                if (!$this->vt_dia_antes->IsDetailKey && EmptyValue($this->vt_dia_antes->FormValue)) {
                    $this->vt_dia_antes->addErrorMessage(str_replace("%s", $this->vt_dia_antes->caption(), $this->vt_dia_antes->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->vt_dia_antes->FormValue)) {
                $this->vt_dia_antes->addErrorMessage($this->vt_dia_antes->getErrorMessage(false));
            }
            if ($this->vr_dia_antes->Visible && $this->vr_dia_antes->Required) {
                if (!$this->vr_dia_antes->IsDetailKey && EmptyValue($this->vr_dia_antes->FormValue)) {
                    $this->vr_dia_antes->addErrorMessage(str_replace("%s", $this->vr_dia_antes->caption(), $this->vr_dia_antes->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->vr_dia_antes->FormValue)) {
                $this->vr_dia_antes->addErrorMessage($this->vr_dia_antes->getErrorMessage(false));
            }
            if ($this->va_mes_antes->Visible && $this->va_mes_antes->Required) {
                if (!$this->va_mes_antes->IsDetailKey && EmptyValue($this->va_mes_antes->FormValue)) {
                    $this->va_mes_antes->addErrorMessage(str_replace("%s", $this->va_mes_antes->caption(), $this->va_mes_antes->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->va_mes_antes->FormValue)) {
                $this->va_mes_antes->addErrorMessage($this->va_mes_antes->getErrorMessage(false));
            }
            if ($this->benef_social_antes->Visible && $this->benef_social_antes->Required) {
                if (!$this->benef_social_antes->IsDetailKey && EmptyValue($this->benef_social_antes->FormValue)) {
                    $this->benef_social_antes->addErrorMessage(str_replace("%s", $this->benef_social_antes->caption(), $this->benef_social_antes->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->benef_social_antes->FormValue)) {
                $this->benef_social_antes->addErrorMessage($this->benef_social_antes->getErrorMessage(false));
            }
            if ($this->plr_antes->Visible && $this->plr_antes->Required) {
                if (!$this->plr_antes->IsDetailKey && EmptyValue($this->plr_antes->FormValue)) {
                    $this->plr_antes->addErrorMessage(str_replace("%s", $this->plr_antes->caption(), $this->plr_antes->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->plr_antes->FormValue)) {
                $this->plr_antes->addErrorMessage($this->plr_antes->getErrorMessage(false));
            }
            if ($this->assis_medica_antes->Visible && $this->assis_medica_antes->Required) {
                if (!$this->assis_medica_antes->IsDetailKey && EmptyValue($this->assis_medica_antes->FormValue)) {
                    $this->assis_medica_antes->addErrorMessage(str_replace("%s", $this->assis_medica_antes->caption(), $this->assis_medica_antes->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->assis_medica_antes->FormValue)) {
                $this->assis_medica_antes->addErrorMessage($this->assis_medica_antes->getErrorMessage(false));
            }
            if ($this->assis_odonto_antes->Visible && $this->assis_odonto_antes->Required) {
                if (!$this->assis_odonto_antes->IsDetailKey && EmptyValue($this->assis_odonto_antes->FormValue)) {
                    $this->assis_odonto_antes->addErrorMessage(str_replace("%s", $this->assis_odonto_antes->caption(), $this->assis_odonto_antes->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->assis_odonto_antes->FormValue)) {
                $this->assis_odonto_antes->addErrorMessage($this->assis_odonto_antes->getErrorMessage(false));
            }
            if ($this->funcao_idfuncao->Visible && $this->funcao_idfuncao->Required) {
                if (!$this->funcao_idfuncao->IsDetailKey && EmptyValue($this->funcao_idfuncao->FormValue)) {
                    $this->funcao_idfuncao->addErrorMessage(str_replace("%s", $this->funcao_idfuncao->caption(), $this->funcao_idfuncao->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->funcao_idfuncao->FormValue)) {
                $this->funcao_idfuncao->addErrorMessage($this->funcao_idfuncao->getErrorMessage(false));
            }
            if ($this->salario1->Visible && $this->salario1->Required) {
                if (!$this->salario1->IsDetailKey && EmptyValue($this->salario1->FormValue)) {
                    $this->salario1->addErrorMessage(str_replace("%s", $this->salario1->caption(), $this->salario1->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->salario1->FormValue)) {
                $this->salario1->addErrorMessage($this->salario1->getErrorMessage(false));
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

        // cargo
        $this->cargo->setDbValueDef($rsnew, $this->cargo->CurrentValue, $this->cargo->ReadOnly);

        // abreviado
        $this->abreviado->setDbValueDef($rsnew, $this->abreviado->CurrentValue, $this->abreviado->ReadOnly);

        // salario
        $this->salario->setDbValueDef($rsnew, $this->salario->CurrentValue, $this->salario->ReadOnly);

        // nr_horas_mes
        $this->nr_horas_mes->setDbValueDef($rsnew, $this->nr_horas_mes->CurrentValue, $this->nr_horas_mes->ReadOnly);

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

        // modulo_idmodulo
        $this->modulo_idmodulo->setDbValueDef($rsnew, $this->modulo_idmodulo->CurrentValue, $this->modulo_idmodulo->ReadOnly);

        // periodo_idperiodo
        $this->periodo_idperiodo->setDbValueDef($rsnew, $this->periodo_idperiodo->CurrentValue, $this->periodo_idperiodo->ReadOnly);

        // escala_idescala
        $this->escala_idescala->setDbValueDef($rsnew, $this->escala_idescala->CurrentValue, $this->escala_idescala->ReadOnly);

        // nr_horas_ad_noite
        $this->nr_horas_ad_noite->setDbValueDef($rsnew, $this->nr_horas_ad_noite->CurrentValue, $this->nr_horas_ad_noite->ReadOnly);

        // intrajornada
        $this->intrajornada->setDbValueDef($rsnew, $this->intrajornada->CurrentValue, $this->intrajornada->ReadOnly);

        // tipo_uniforme_idtipo_uniforme
        $this->tipo_uniforme_idtipo_uniforme->setDbValueDef($rsnew, $this->tipo_uniforme_idtipo_uniforme->CurrentValue, $this->tipo_uniforme_idtipo_uniforme->ReadOnly);

        // salario_antes
        $this->salario_antes->setDbValueDef($rsnew, $this->salario_antes->CurrentValue, $this->salario_antes->ReadOnly);

        // vt_dia_antes
        $this->vt_dia_antes->setDbValueDef($rsnew, $this->vt_dia_antes->CurrentValue, $this->vt_dia_antes->ReadOnly);

        // vr_dia_antes
        $this->vr_dia_antes->setDbValueDef($rsnew, $this->vr_dia_antes->CurrentValue, $this->vr_dia_antes->ReadOnly);

        // va_mes_antes
        $this->va_mes_antes->setDbValueDef($rsnew, $this->va_mes_antes->CurrentValue, $this->va_mes_antes->ReadOnly);

        // benef_social_antes
        $this->benef_social_antes->setDbValueDef($rsnew, $this->benef_social_antes->CurrentValue, $this->benef_social_antes->ReadOnly);

        // plr_antes
        $this->plr_antes->setDbValueDef($rsnew, $this->plr_antes->CurrentValue, $this->plr_antes->ReadOnly);

        // assis_medica_antes
        $this->assis_medica_antes->setDbValueDef($rsnew, $this->assis_medica_antes->CurrentValue, $this->assis_medica_antes->ReadOnly);

        // assis_odonto_antes
        $this->assis_odonto_antes->setDbValueDef($rsnew, $this->assis_odonto_antes->CurrentValue, $this->assis_odonto_antes->ReadOnly);

        // funcao_idfuncao
        $this->funcao_idfuncao->setDbValueDef($rsnew, $this->funcao_idfuncao->CurrentValue, $this->funcao_idfuncao->ReadOnly);

        // salario1
        $this->salario1->setDbValueDef($rsnew, $this->salario1->CurrentValue, $this->salario1->ReadOnly);
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
        if (isset($row['nr_horas_mes'])) { // nr_horas_mes
            $this->nr_horas_mes->CurrentValue = $row['nr_horas_mes'];
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
        if (isset($row['modulo_idmodulo'])) { // modulo_idmodulo
            $this->modulo_idmodulo->CurrentValue = $row['modulo_idmodulo'];
        }
        if (isset($row['periodo_idperiodo'])) { // periodo_idperiodo
            $this->periodo_idperiodo->CurrentValue = $row['periodo_idperiodo'];
        }
        if (isset($row['escala_idescala'])) { // escala_idescala
            $this->escala_idescala->CurrentValue = $row['escala_idescala'];
        }
        if (isset($row['nr_horas_ad_noite'])) { // nr_horas_ad_noite
            $this->nr_horas_ad_noite->CurrentValue = $row['nr_horas_ad_noite'];
        }
        if (isset($row['intrajornada'])) { // intrajornada
            $this->intrajornada->CurrentValue = $row['intrajornada'];
        }
        if (isset($row['tipo_uniforme_idtipo_uniforme'])) { // tipo_uniforme_idtipo_uniforme
            $this->tipo_uniforme_idtipo_uniforme->CurrentValue = $row['tipo_uniforme_idtipo_uniforme'];
        }
        if (isset($row['salario_antes'])) { // salario_antes
            $this->salario_antes->CurrentValue = $row['salario_antes'];
        }
        if (isset($row['vt_dia_antes'])) { // vt_dia_antes
            $this->vt_dia_antes->CurrentValue = $row['vt_dia_antes'];
        }
        if (isset($row['vr_dia_antes'])) { // vr_dia_antes
            $this->vr_dia_antes->CurrentValue = $row['vr_dia_antes'];
        }
        if (isset($row['va_mes_antes'])) { // va_mes_antes
            $this->va_mes_antes->CurrentValue = $row['va_mes_antes'];
        }
        if (isset($row['benef_social_antes'])) { // benef_social_antes
            $this->benef_social_antes->CurrentValue = $row['benef_social_antes'];
        }
        if (isset($row['plr_antes'])) { // plr_antes
            $this->plr_antes->CurrentValue = $row['plr_antes'];
        }
        if (isset($row['assis_medica_antes'])) { // assis_medica_antes
            $this->assis_medica_antes->CurrentValue = $row['assis_medica_antes'];
        }
        if (isset($row['assis_odonto_antes'])) { // assis_odonto_antes
            $this->assis_odonto_antes->CurrentValue = $row['assis_odonto_antes'];
        }
        if (isset($row['funcao_idfuncao'])) { // funcao_idfuncao
            $this->funcao_idfuncao->CurrentValue = $row['funcao_idfuncao'];
        }
        if (isset($row['salario1'])) { // salario1
            $this->salario1->CurrentValue = $row['salario1'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("CargoCopyList"), "", $this->TableVar, true);
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
                case "x_intrajornada":
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
