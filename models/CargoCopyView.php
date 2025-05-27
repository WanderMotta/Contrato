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
class CargoCopyView extends CargoCopy
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "CargoCopyView";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "CargoCopyView";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-view-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (cargo_copy)
        if (!isset($GLOBALS["cargo_copy"]) || $GLOBALS["cargo_copy"]::class == PROJECT_NAMESPACE . "cargo_copy") {
            $GLOBALS["cargo_copy"] = &$this;
        }

        // Set up record key
        if (($keyValue = Get("idcargo") ?? Route("idcargo")) !== null) {
            $this->RecKey["idcargo"] = $keyValue;
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

        // Export options
        $this->ExportOptions = new ListOptions(TagClassName: "ew-export-option");

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(TagClassName: "ew-detail-option");
        // Actions
        $this->OtherOptions["action"] = new ListOptions(TagClassName: "ew-action-option");
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
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "CargoCopyView"); // If View page, no primary button
                } else { // List page
                    $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                    $this->clearFailureMessage();
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
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;

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

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
        if (($keyValue = Get("idcargo") ?? Route("idcargo")) !== null) {
            $this->idcargo->setQueryStringValue($keyValue);
            $this->RecKey["idcargo"] = $this->idcargo->QueryStringValue;
        } elseif (Post("idcargo") !== null) {
            $this->idcargo->setFormValue(Post("idcargo"));
            $this->RecKey["idcargo"] = $this->idcargo->FormValue;
        } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
            $this->idcargo->setQueryStringValue($keyValue);
            $this->RecKey["idcargo"] = $this->idcargo->QueryStringValue;
        } elseif (!$loadCurrentRecord) {
            $returnUrl = "CargoCopyList"; // Return to list
        }

        // Get action
        $this->CurrentAction = "show"; // Display
        switch ($this->CurrentAction) {
            case "show": // Get a record to display

                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $res = ($this->Recordset = ExecuteQuery($sql, $conn));
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "CargoCopyList"; // No matching record, return to list
                    }
                break;
        }
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = RowType::VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Normal return
        if (IsApi()) {
            if (!$this->isExport()) {
                $row = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
                $this->Recordset?->free();
                WriteJson(["success" => true, "action" => Config("API_VIEW_ACTION"), $this->TableVar => $row]);
                $this->terminate(true);
            }
            return;
        }

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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Disable Add/Edit/Copy/Delete for Modal and UseAjaxActions
        /*
        if ($this->IsModal && $this->UseAjaxActions) {
            $this->AddUrl = "";
            $this->EditUrl = "";
            $this->CopyUrl = "";
            $this->DeleteUrl = "";
        }
        */
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = $this->EditUrl != "" && $Security->canEdit();

        // Copy
        $item = &$option->add("copy");
        $copycaption = HtmlTitle($Language->phrase("ViewPageCopyLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        }
        $item->Visible = $this->CopyUrl != "" && $Security->canAdd();

        // Delete
        $item = &$option->add("delete");
        $url = GetUrl($this->DeleteUrl);
        $item->Body = "<a class=\"ew-action ew-delete\"" .
            ($this->InlineDelete || $this->IsModal ? " data-ew-action=\"inline-delete\"" : "") .
            " title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) .
            "\" href=\"" . HtmlEncode($url) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        $item->Visible = $this->DeleteUrl != "" && $Security->canDelete();

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = !IsJsonResponse() && false;
        $option->UseButtonGroup = true;
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // idcargo

        // cargo

        // abreviado

        // salario

        // nr_horas_mes

        // jornada

        // vt_dia

        // vr_dia

        // va_mes

        // benef_social

        // plr

        // assis_medica

        // assis_odonto

        // modulo_idmodulo

        // periodo_idperiodo

        // escala_idescala

        // nr_horas_ad_noite

        // intrajornada

        // tipo_uniforme_idtipo_uniforme

        // salario_antes

        // vt_dia_antes

        // vr_dia_antes

        // va_mes_antes

        // benef_social_antes

        // plr_antes

        // assis_medica_antes

        // assis_odonto_antes

        // funcao_idfuncao

        // salario1

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
            $this->idcargo->TooltipValue = "";

            // cargo
            $this->cargo->HrefValue = "";
            $this->cargo->TooltipValue = "";

            // abreviado
            $this->abreviado->HrefValue = "";
            $this->abreviado->TooltipValue = "";

            // salario
            $this->salario->HrefValue = "";
            $this->salario->TooltipValue = "";

            // nr_horas_mes
            $this->nr_horas_mes->HrefValue = "";
            $this->nr_horas_mes->TooltipValue = "";

            // jornada
            $this->jornada->HrefValue = "";
            $this->jornada->TooltipValue = "";

            // vt_dia
            $this->vt_dia->HrefValue = "";
            $this->vt_dia->TooltipValue = "";

            // vr_dia
            $this->vr_dia->HrefValue = "";
            $this->vr_dia->TooltipValue = "";

            // va_mes
            $this->va_mes->HrefValue = "";
            $this->va_mes->TooltipValue = "";

            // benef_social
            $this->benef_social->HrefValue = "";
            $this->benef_social->TooltipValue = "";

            // plr
            $this->plr->HrefValue = "";
            $this->plr->TooltipValue = "";

            // assis_medica
            $this->assis_medica->HrefValue = "";
            $this->assis_medica->TooltipValue = "";

            // assis_odonto
            $this->assis_odonto->HrefValue = "";
            $this->assis_odonto->TooltipValue = "";

            // modulo_idmodulo
            $this->modulo_idmodulo->HrefValue = "";
            $this->modulo_idmodulo->TooltipValue = "";

            // periodo_idperiodo
            $this->periodo_idperiodo->HrefValue = "";
            $this->periodo_idperiodo->TooltipValue = "";

            // escala_idescala
            $this->escala_idescala->HrefValue = "";
            $this->escala_idescala->TooltipValue = "";

            // nr_horas_ad_noite
            $this->nr_horas_ad_noite->HrefValue = "";
            $this->nr_horas_ad_noite->TooltipValue = "";

            // intrajornada
            $this->intrajornada->HrefValue = "";
            $this->intrajornada->TooltipValue = "";

            // tipo_uniforme_idtipo_uniforme
            $this->tipo_uniforme_idtipo_uniforme->HrefValue = "";
            $this->tipo_uniforme_idtipo_uniforme->TooltipValue = "";

            // salario_antes
            $this->salario_antes->HrefValue = "";
            $this->salario_antes->TooltipValue = "";

            // vt_dia_antes
            $this->vt_dia_antes->HrefValue = "";
            $this->vt_dia_antes->TooltipValue = "";

            // vr_dia_antes
            $this->vr_dia_antes->HrefValue = "";
            $this->vr_dia_antes->TooltipValue = "";

            // va_mes_antes
            $this->va_mes_antes->HrefValue = "";
            $this->va_mes_antes->TooltipValue = "";

            // benef_social_antes
            $this->benef_social_antes->HrefValue = "";
            $this->benef_social_antes->TooltipValue = "";

            // plr_antes
            $this->plr_antes->HrefValue = "";
            $this->plr_antes->TooltipValue = "";

            // assis_medica_antes
            $this->assis_medica_antes->HrefValue = "";
            $this->assis_medica_antes->TooltipValue = "";

            // assis_odonto_antes
            $this->assis_odonto_antes->HrefValue = "";
            $this->assis_odonto_antes->TooltipValue = "";

            // funcao_idfuncao
            $this->funcao_idfuncao->HrefValue = "";
            $this->funcao_idfuncao->TooltipValue = "";

            // salario1
            $this->salario1->HrefValue = "";
            $this->salario1->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("CargoCopyList"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
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

    // Page Exporting event
    // $doc = export object
    public function pageExporting(&$doc)
    {
        //$doc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $doc = export document object
    public function rowExport($doc, $rs)
    {
        //$doc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $doc = export document object
    public function pageExported($doc)
    {
        //$doc->Text .= "my footer"; // Export footer
        //Log($doc->Text);
    }
}
