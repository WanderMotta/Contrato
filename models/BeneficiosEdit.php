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
class BeneficiosEdit extends Beneficios
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "BeneficiosEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "BeneficiosEdit";

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
        $this->idbeneficios->setVisibility();
        $this->data->setVisibility();
        $this->vt_dia->setVisibility();
        $this->vr_dia->setVisibility();
        $this->va_mes->setVisibility();
        $this->benef_social->setVisibility();
        $this->plr->setVisibility();
        $this->assis_medica->setVisibility();
        $this->assis_odonto->setVisibility();
        $this->dissidio_anual_iddissidio_anual->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'beneficios';
        $this->TableName = 'beneficios';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (beneficios)
        if (!isset($GLOBALS["beneficios"]) || $GLOBALS["beneficios"]::class == PROJECT_NAMESPACE . "beneficios") {
            $GLOBALS["beneficios"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'beneficios');
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
                        $result["view"] = SameString($pageName, "BeneficiosView"); // If View page, no primary button
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
            $key .= @$ar['idbeneficios'];
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
            $this->idbeneficios->Visible = false;
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
        $this->data->Required = false;

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
            if (($keyValue = Get("idbeneficios") ?? Key(0) ?? Route(2)) !== null) {
                $this->idbeneficios->setQueryStringValue($keyValue);
                $this->idbeneficios->setOldValue($this->idbeneficios->QueryStringValue);
            } elseif (Post("idbeneficios") !== null) {
                $this->idbeneficios->setFormValue(Post("idbeneficios"));
                $this->idbeneficios->setOldValue($this->idbeneficios->FormValue);
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
                if (($keyValue = Get("idbeneficios") ?? Route("idbeneficios")) !== null) {
                    $this->idbeneficios->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idbeneficios->CurrentValue = null;
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
                        $this->terminate("BeneficiosList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "BeneficiosList") {
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
                        if (GetPageName($returnUrl) != "BeneficiosList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "BeneficiosList"; // Return list page content
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

        // Check field name 'idbeneficios' first before field var 'x_idbeneficios'
        $val = $CurrentForm->hasValue("idbeneficios") ? $CurrentForm->getValue("idbeneficios") : $CurrentForm->getValue("x_idbeneficios");
        if (!$this->idbeneficios->IsDetailKey) {
            $this->idbeneficios->setFormValue($val);
        }

        // Check field name 'data' first before field var 'x_data'
        $val = $CurrentForm->hasValue("data") ? $CurrentForm->getValue("data") : $CurrentForm->getValue("x_data");
        if (!$this->data->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->data->Visible = false; // Disable update for API request
            } else {
                $this->data->setFormValue($val);
            }
            $this->data->CurrentValue = UnFormatDateTime($this->data->CurrentValue, $this->data->formatPattern());
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idbeneficios->CurrentValue = $this->idbeneficios->FormValue;
        $this->data->CurrentValue = $this->data->FormValue;
        $this->data->CurrentValue = UnFormatDateTime($this->data->CurrentValue, $this->data->formatPattern());
        $this->vt_dia->CurrentValue = $this->vt_dia->FormValue;
        $this->vr_dia->CurrentValue = $this->vr_dia->FormValue;
        $this->va_mes->CurrentValue = $this->va_mes->FormValue;
        $this->benef_social->CurrentValue = $this->benef_social->FormValue;
        $this->plr->CurrentValue = $this->plr->FormValue;
        $this->assis_medica->CurrentValue = $this->assis_medica->FormValue;
        $this->assis_odonto->CurrentValue = $this->assis_odonto->FormValue;
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
        $this->idbeneficios->setDbValue($row['idbeneficios']);
        $this->data->setDbValue($row['data']);
        $this->vt_dia->setDbValue($row['vt_dia']);
        $this->vr_dia->setDbValue($row['vr_dia']);
        $this->va_mes->setDbValue($row['va_mes']);
        $this->benef_social->setDbValue($row['benef_social']);
        $this->plr->setDbValue($row['plr']);
        $this->assis_medica->setDbValue($row['assis_medica']);
        $this->assis_odonto->setDbValue($row['assis_odonto']);
        $this->dissidio_anual_iddissidio_anual->setDbValue($row['dissidio_anual_iddissidio_anual']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idbeneficios'] = $this->idbeneficios->DefaultValue;
        $row['data'] = $this->data->DefaultValue;
        $row['vt_dia'] = $this->vt_dia->DefaultValue;
        $row['vr_dia'] = $this->vr_dia->DefaultValue;
        $row['va_mes'] = $this->va_mes->DefaultValue;
        $row['benef_social'] = $this->benef_social->DefaultValue;
        $row['plr'] = $this->plr->DefaultValue;
        $row['assis_medica'] = $this->assis_medica->DefaultValue;
        $row['assis_odonto'] = $this->assis_odonto->DefaultValue;
        $row['dissidio_anual_iddissidio_anual'] = $this->dissidio_anual_iddissidio_anual->DefaultValue;
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

        // idbeneficios
        $this->idbeneficios->RowCssClass = "row";

        // data
        $this->data->RowCssClass = "row";

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

        // dissidio_anual_iddissidio_anual
        $this->dissidio_anual_iddissidio_anual->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idbeneficios
            $this->idbeneficios->ViewValue = $this->idbeneficios->CurrentValue;

            // data
            $this->data->ViewValue = $this->data->CurrentValue;
            $this->data->ViewValue = FormatDateTime($this->data->ViewValue, $this->data->formatPattern());
            $this->data->CssClass = "fw-bold";

            // vt_dia
            $this->vt_dia->ViewValue = $this->vt_dia->CurrentValue;
            $this->vt_dia->ViewValue = FormatNumber($this->vt_dia->ViewValue, $this->vt_dia->formatPattern());
            $this->vt_dia->CssClass = "fw-bold";
            $this->vt_dia->CellCssStyle .= "text-align: right;";

            // vr_dia
            $this->vr_dia->ViewValue = $this->vr_dia->CurrentValue;
            $this->vr_dia->ViewValue = FormatCurrency($this->vr_dia->ViewValue, $this->vr_dia->formatPattern());
            $this->vr_dia->CssClass = "fw-bold";
            $this->vr_dia->CellCssStyle .= "text-align: right;";

            // va_mes
            $this->va_mes->ViewValue = $this->va_mes->CurrentValue;
            $this->va_mes->ViewValue = FormatCurrency($this->va_mes->ViewValue, $this->va_mes->formatPattern());
            $this->va_mes->CssClass = "fw-bold";
            $this->va_mes->CellCssStyle .= "text-align: right;";

            // benef_social
            $this->benef_social->ViewValue = $this->benef_social->CurrentValue;
            $this->benef_social->ViewValue = FormatCurrency($this->benef_social->ViewValue, $this->benef_social->formatPattern());
            $this->benef_social->CssClass = "fw-bold";
            $this->benef_social->CellCssStyle .= "text-align: right;";

            // plr
            $this->plr->ViewValue = $this->plr->CurrentValue;
            $this->plr->ViewValue = FormatCurrency($this->plr->ViewValue, $this->plr->formatPattern());
            $this->plr->CssClass = "fw-bold";
            $this->plr->CellCssStyle .= "text-align: right;";

            // assis_medica
            $this->assis_medica->ViewValue = $this->assis_medica->CurrentValue;
            $this->assis_medica->ViewValue = FormatCurrency($this->assis_medica->ViewValue, $this->assis_medica->formatPattern());
            $this->assis_medica->CssClass = "fw-bold";
            $this->assis_medica->CellCssStyle .= "text-align: right;";

            // assis_odonto
            $this->assis_odonto->ViewValue = $this->assis_odonto->CurrentValue;
            $this->assis_odonto->ViewValue = FormatCurrency($this->assis_odonto->ViewValue, $this->assis_odonto->formatPattern());
            $this->assis_odonto->CssClass = "fw-bold";
            $this->assis_odonto->CellCssStyle .= "text-align: right;";

            // dissidio_anual_iddissidio_anual
            $this->dissidio_anual_iddissidio_anual->ViewValue = $this->dissidio_anual_iddissidio_anual->CurrentValue;
            $this->dissidio_anual_iddissidio_anual->ViewValue = FormatNumber($this->dissidio_anual_iddissidio_anual->ViewValue, $this->dissidio_anual_iddissidio_anual->formatPattern());

            // idbeneficios
            $this->idbeneficios->HrefValue = "";

            // data
            $this->data->HrefValue = "";
            $this->data->TooltipValue = "";

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
        } elseif ($this->RowType == RowType::EDIT) {
            // idbeneficios
            $this->idbeneficios->setupEditAttributes();
            $this->idbeneficios->EditValue = $this->idbeneficios->CurrentValue;

            // data
            $this->data->setupEditAttributes();
            $this->data->EditValue = $this->data->CurrentValue;
            $this->data->EditValue = FormatDateTime($this->data->EditValue, $this->data->formatPattern());
            $this->data->CssClass = "fw-bold";

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

            // Edit refer script

            // idbeneficios
            $this->idbeneficios->HrefValue = "";

            // data
            $this->data->HrefValue = "";
            $this->data->TooltipValue = "";

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
            if ($this->idbeneficios->Visible && $this->idbeneficios->Required) {
                if (!$this->idbeneficios->IsDetailKey && EmptyValue($this->idbeneficios->FormValue)) {
                    $this->idbeneficios->addErrorMessage(str_replace("%s", $this->idbeneficios->caption(), $this->idbeneficios->RequiredErrorMessage));
                }
            }
            if ($this->data->Visible && $this->data->Required) {
                if (!$this->data->IsDetailKey && EmptyValue($this->data->FormValue)) {
                    $this->data->addErrorMessage(str_replace("%s", $this->data->caption(), $this->data->RequiredErrorMessage));
                }
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

        // Check referential integrity for master table 'dissidio_anual'
        $detailKeys = [];
        $keyValue = $rsnew['dissidio_anual_iddissidio_anual'] ?? $rsold['dissidio_anual_iddissidio_anual'];
        $detailKeys['dissidio_anual_iddissidio_anual'] = $keyValue;
        $masterTable = Container("dissidio_anual");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "dissidio_anual", $Language->phrase("RelatedRecordRequired"));
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
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
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
            if ($masterTblVar == "dissidio_anual") {
                $validMaster = true;
                $masterTbl = Container("dissidio_anual");
                if (($parm = Get("fk_iddissidio_anual", Get("dissidio_anual_iddissidio_anual"))) !== null) {
                    $masterTbl->iddissidio_anual->setQueryStringValue($parm);
                    $this->dissidio_anual_iddissidio_anual->QueryStringValue = $masterTbl->iddissidio_anual->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->dissidio_anual_iddissidio_anual->setSessionValue($this->dissidio_anual_iddissidio_anual->QueryStringValue);
                    $foreignKeys["dissidio_anual_iddissidio_anual"] = $this->dissidio_anual_iddissidio_anual->QueryStringValue;
                    if (!is_numeric($masterTbl->iddissidio_anual->QueryStringValue)) {
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
            if ($masterTblVar == "dissidio_anual") {
                $validMaster = true;
                $masterTbl = Container("dissidio_anual");
                if (($parm = Post("fk_iddissidio_anual", Post("dissidio_anual_iddissidio_anual"))) !== null) {
                    $masterTbl->iddissidio_anual->setFormValue($parm);
                    $this->dissidio_anual_iddissidio_anual->FormValue = $masterTbl->iddissidio_anual->FormValue;
                    $this->dissidio_anual_iddissidio_anual->setSessionValue($this->dissidio_anual_iddissidio_anual->FormValue);
                    $foreignKeys["dissidio_anual_iddissidio_anual"] = $this->dissidio_anual_iddissidio_anual->FormValue;
                    if (!is_numeric($masterTbl->iddissidio_anual->FormValue)) {
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
            if ($masterTblVar != "dissidio_anual") {
                if (!array_key_exists("dissidio_anual_iddissidio_anual", $foreignKeys)) { // Not current foreign key
                    $this->dissidio_anual_iddissidio_anual->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("BeneficiosList"), "", $this->TableVar, true);
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
