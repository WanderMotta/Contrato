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
class RelTesteSummary extends RelTeste
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RelTesteSummary";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $ReportContainerClass = "ew-grid";
    public $CurrentPageName = "RelTeste";

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

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'rel_teste';
        $this->TableName = 'rel_teste';

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->ReportContainerClass, $this->ContextClass);

        // Custom template
        $this->UseCustomTemplate = true;

        // Fixed header table
        if (!$this->UseCustomTemplate) {
            $this->setFixedHeaderTable(Config("USE_FIXED_HEADER_TABLE"), Config("FIXED_HEADER_TABLE_HEIGHT"));
        }

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (rel_teste)
        if (!isset($GLOBALS["rel_teste"]) || $GLOBALS["rel_teste"]::class == PROJECT_NAMESPACE . "rel_teste") {
            $GLOBALS["rel_teste"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'rel_teste');
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

        // Filter options
        $this->FilterOptions = new ListOptions(TagClassName: "ew-filter-option");
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

        // Close connection if not in dashboard
        if (!$DashboardReport) {
            CloseConnections();
        }

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
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
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
        if ($fld instanceof ReportField) {
            $lookup->RenderViewFunc = "renderLookup"; // Set up view renderer
        }
        $lookup->RenderEditFunc = ""; // Set up edit renderer

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

    // Options
    public $HideOptions = false;
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $FilterOptions; // Filter options

    // Records
    public $GroupRecords = [];
    public $DetailRecords = [];
    public $DetailRecordCount = 0;

    // Paging variables
    public $RecordIndex = 0; // Record index
    public $RecordCount = 0; // Record count (start from 1 for each group)
    public $StartGroup = 0; // Start group
    public $StopGroup = 0; // Stop group
    public $TotalGroups = 0; // Total groups
    public $GroupCount = 0; // Group count
    public $GroupCounter = []; // Group counter
    public $DisplayGroups = 50; // Groups per page
    public $GroupRange = 10;
    public $PageSizes = "1,2,3,5,50,-1"; // Page sizes (comma separated)
    public $PageFirstGroupFilter = "";
    public $UserIDFilter = "";
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = "";
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $DrillDownList = "";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $SearchCommand = false;
    public $ShowHeader = true;
    public $GroupColumnCount = 0;
    public $SubGroupColumnCount = 0;
    public $DetailColumnCount = 0;
    public $TotalCount;
    public $PageTotalCount;
    public $TopContentClass = "ew-top";
    public $MiddleContentClass = "ew-middle";
    public $BottomContentClass = "ew-bottom";

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $DrillDownInPanel, $Breadcrumb, $DashboardReport;

        // Set up dashboard report
        $DashboardReport ??= Param(Config("PAGE_DASHBOARD"));
        if ($DashboardReport) {
            $this->UseAjaxActions = true;
            AddFilter($this->Filter, $this->getDashboardFilter($DashboardReport, $this->TableVar)); // Set up Dashboard Filter
        }

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        }
        $ExportType = $this->Export; // Get export parameter, used in header
        if ($ExportType != "") {
            global $SkipHeaderFooter;
            $SkipHeaderFooter = true;
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Setup export options
        $this->setupExportOptions();

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up table class
        if ($this->isExport("word") || $this->isExport("excel") || $this->isExport("pdf")) {
            $this->TableClass = "ew-table table-bordered table-sm";
        } else {
            PrependClass($this->TableClass, "table ew-table table-bordered table-sm");
        }

        // Set up report container class
        if (!$this->isExport("word") && !$this->isExport("excel")) {
            $this->ReportContainerClass .= " card ew-card";
        }

        // Hide main table for custom layout
        if ($this->isExport() || $this->UseCustomTemplate) {
            $this->ReportContainerClass .= " d-none";
        }

        // Set field visibility for detail fields
        $this->idplanilha_custo->setVisibility();
        $this->proposta_idproposta->setVisibility();
        $this->dt_proposta->setVisibility();
        $this->qtde_cargos->setVisibility();
        $this->cargo_idcargo->setVisibility();
        $this->cargo->setVisibility();
        $this->uniforme->setVisibility();
        $this->qtde->setVisibility();
        $this->periodo_troca->setVisibility();
        $this->vr_unitario->setVisibility();
        $this->tipo_uniforme->setVisibility();
        $this->vr_anual->setVisibility();
        $this->vr_mesal->setVisibility();
        $this->cliente->setVisibility();

        // Set up groups per page dynamically
        $this->setupDisplayGroups();

        // Set up Breadcrumb
        if (!$this->isExport() && !$DashboardReport) {
            $this->setupBreadcrumb();
        }

        // Check if search command
        $this->SearchCommand = (Get("cmd", "") == "search");

        // Load custom filters
        $this->pageFilterLoad();

        // Extended filter
        $extendedFilter = "";

        // Restore filter list
        $this->restoreFilterList();

        // Build extended filter
        $extendedFilter = $this->getExtendedFilter();
        AddFilter($this->SearchWhere, $extendedFilter);

        // Call Page Selecting event
        $this->pageSelecting($this->SearchWhere);

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Get sort
        $this->Sort = $this->getSort();

        // Search options
        $this->setupSearchOptions();

        // Update filter
        AddFilter($this->Filter, $this->SearchWhere);

        // Get total count
        $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
        $this->TotalGroups = $this->getRecordCount($sql);
        if ($this->DisplayGroups <= 0 || $this->DrillDown) { // Display all groups
            $this->DisplayGroups = $this->TotalGroups;
        }
        $this->StartGroup = 1;

        // Set up start position if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->DisplayGroups = $this->TotalGroups;
        } else {
            $this->setupStartGroup();
        }

        // Set no record found message
        if ($this->TotalGroups == 0) {
            $this->ShowHeader = false;
            if ($Security->canList()) {
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            } else {
                $this->setWarningMessage(DeniedMessage());
            }
        }

        // Hide export options if export/dashboard report/hide options
        if ($this->isExport() || $DashboardReport || $this->HideOptions) {
            $this->ExportOptions->hideAllOptions();
        }

        // Hide search/filter options if export/drilldown/dashboard report/hide options
        if ($this->isExport() || $this->DrillDown || $DashboardReport || $this->HideOptions) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }

        // Get current page records
        if ($this->TotalGroups > 0) {
            $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, $this->Sort);
            $rs = $sql->setFirstResult(max($this->StartGroup - 1, 0))->setMaxResults($this->DisplayGroups)->executeQuery();
            $this->DetailRecords = $rs->fetchAll(); // Get records
            $this->GroupCount = 1;
        }
        $this->setupFieldCount();

        // Set the last group to display if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->StopGroup = $this->TotalGroups;
        } else {
            $this->StopGroup = $this->StartGroup + $this->DisplayGroups - 1;
        }

        // Stop group <= total number of groups
        if (intval($this->StopGroup) > intval($this->TotalGroups)) {
            $this->StopGroup = $this->TotalGroups;
        }
        $this->RecordCount = 0;
        $this->RecordIndex = 0;
        $this->setGroupCount($this->StopGroup - $this->StartGroup + 1, 1);

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartGroup, $this->DisplayGroups, $this->TotalGroups, $this->PageSizes, $this->GroupRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Check if no records
        if ($this->TotalGroups == 0) {
            $this->ReportContainerClass .= " ew-no-record";
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

    // Load row values
    public function loadRowValues($record)
    {
        $data = [];
        $data["idplanilha_custo"] = $record['idplanilha_custo'];
        $data["proposta_idproposta"] = $record['proposta_idproposta'];
        $data["dt_proposta"] = $record['dt_proposta'];
        $data["qtde_cargos"] = $record['qtde_cargos'];
        $data["cargo_idcargo"] = $record['cargo_idcargo'];
        $data["cargo"] = $record['cargo'];
        $data["uniforme"] = $record['uniforme'];
        $data["qtde"] = $record['qtde'];
        $data["periodo_troca"] = $record['periodo_troca'];
        $data["vr_unitario"] = $record['vr_unitario'];
        $data["tipo_uniforme"] = $record['tipo_uniforme'];
        $data["vr_anual"] = $record['vr_anual'];
        $data["vr_mesal"] = $record['vr_mesal'];
        $data["cliente"] = $record['cliente'];
        $this->Rows[] = $data;
        $this->idplanilha_custo->setDbValue($record['idplanilha_custo']);
        $this->proposta_idproposta->setDbValue($record['proposta_idproposta']);
        $this->dt_proposta->setDbValue($record['dt_proposta']);
        $this->qtde_cargos->setDbValue($record['qtde_cargos']);
        $this->cargo_idcargo->setDbValue($record['cargo_idcargo']);
        $this->cargo->setDbValue($record['cargo']);
        $this->uniforme->setDbValue($record['uniforme']);
        $this->qtde->setDbValue($record['qtde']);
        $this->periodo_troca->setDbValue($record['periodo_troca']);
        $this->vr_unitario->setDbValue($record['vr_unitario']);
        $this->tipo_uniforme->setDbValue($record['tipo_uniforme']);
        $this->vr_anual->setDbValue($record['vr_anual']);
        $this->vr_mesal->setDbValue($record['vr_mesal']);
        $this->cliente->setDbValue($record['cliente']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == RowType::TOTAL && $this->RowTotalSubType == RowTotal::FOOTER && $this->RowTotalType == RowSummary::PAGE) { // Get Page total
            $records = &$this->DetailRecords;
            $this->PageTotalCount = count($records);
        } elseif ($this->RowType == RowType::TOTAL && $this->RowTotalSubType == RowTotal::FOOTER && $this->RowTotalType == RowSummary::GRAND) { // Get Grand total
            $hasCount = false;
            $hasSummary = false;

            // Get total count from SQL directly
            $sql = $this->buildReportSql($this->getSqlSelectCount(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
            $rstot = $conn->executeQuery($sql);
            if ($rstot && $cnt = $rstot->fetchOne()) {
                $hasCount = true;
            } else {
                $cnt = 0;
            }
            $this->TotalCount = $cnt;
            $hasSummary = true;

            // Accumulate grand summary from detail records
            if (!$hasCount || !$hasSummary) {
                $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
                $rs = $sql->executeQuery();
                $this->DetailRecords = $rs?->fetchAll() ?? [];
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // idplanilha_custo

        // proposta_idproposta

        // dt_proposta

        // qtde_cargos

        // cargo_idcargo

        // cargo

        // uniforme

        // qtde

        // periodo_troca

        // vr_unitario

        // tipo_uniforme

        // vr_anual

        // vr_mesal

        // cliente
        if ($this->RowType == RowType::SEARCH) {
            // idplanilha_custo
            if ($this->idplanilha_custo->UseFilter && !EmptyValue($this->idplanilha_custo->AdvancedSearch->SearchValue)) {
                if (is_array($this->idplanilha_custo->AdvancedSearch->SearchValue)) {
                    $this->idplanilha_custo->AdvancedSearch->SearchValue = implode(Config("FILTER_OPTION_SEPARATOR"), $this->idplanilha_custo->AdvancedSearch->SearchValue);
                }
                $this->idplanilha_custo->EditValue = explode(Config("FILTER_OPTION_SEPARATOR"), $this->idplanilha_custo->AdvancedSearch->SearchValue);
            }
        } elseif ($this->RowType == RowType::TOTAL && !($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class

            // idplanilha_custo
            $this->idplanilha_custo->HrefValue = "";

            // proposta_idproposta
            $this->proposta_idproposta->HrefValue = "";

            // dt_proposta
            $this->dt_proposta->HrefValue = "";

            // qtde_cargos
            $this->qtde_cargos->HrefValue = "";

            // cargo_idcargo
            $this->cargo_idcargo->HrefValue = "";

            // cargo
            $this->cargo->HrefValue = "";

            // uniforme
            $this->uniforme->HrefValue = "";

            // qtde
            $this->qtde->HrefValue = "";

            // periodo_troca
            $this->periodo_troca->HrefValue = "";

            // vr_unitario
            $this->vr_unitario->HrefValue = "";

            // tipo_uniforme
            $this->tipo_uniforme->HrefValue = "";

            // vr_anual
            $this->vr_anual->HrefValue = "";

            // vr_mesal
            $this->vr_mesal->HrefValue = "";

            // cliente
            $this->cliente->HrefValue = "";
        } else {
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER) {
            } else {
            }

            // Increment RowCount
            if ($this->RowType == RowType::DETAIL) {
                $this->RowCount++;
            }

            // idplanilha_custo
            $this->idplanilha_custo->ViewValue = $this->idplanilha_custo->CurrentValue;
            $this->idplanilha_custo->CssClass = "fw-bold";
            $this->idplanilha_custo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->idplanilha_custo->CellCssStyle .= "text-align: center;";

            // proposta_idproposta
            $this->proposta_idproposta->ViewValue = $this->proposta_idproposta->CurrentValue;
            $this->proposta_idproposta->ViewValue = FormatNumber($this->proposta_idproposta->ViewValue, $this->proposta_idproposta->formatPattern());
            $this->proposta_idproposta->CssClass = "fw-bold";
            $this->proposta_idproposta->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->proposta_idproposta->CellCssStyle .= "text-align: center;";

            // dt_proposta
            $this->dt_proposta->ViewValue = $this->dt_proposta->CurrentValue;
            $this->dt_proposta->ViewValue = FormatDateTime($this->dt_proposta->ViewValue, $this->dt_proposta->formatPattern());
            $this->dt_proposta->CssClass = "fw-bold";
            $this->dt_proposta->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // qtde_cargos
            $this->qtde_cargos->ViewValue = $this->qtde_cargos->CurrentValue;
            $this->qtde_cargos->ViewValue = FormatNumber($this->qtde_cargos->ViewValue, $this->qtde_cargos->formatPattern());
            $this->qtde_cargos->CssClass = "fw-bold";
            $this->qtde_cargos->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->qtde_cargos->CellCssStyle .= "text-align: right;";

            // cargo_idcargo
            $this->cargo_idcargo->ViewValue = $this->cargo_idcargo->CurrentValue;
            $this->cargo_idcargo->ViewValue = FormatNumber($this->cargo_idcargo->ViewValue, $this->cargo_idcargo->formatPattern());
            $this->cargo_idcargo->CssClass = "fw-bold";
            $this->cargo_idcargo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // cargo
            $this->cargo->ViewValue = $this->cargo->CurrentValue;
            $this->cargo->CssClass = "fw-bold";
            $this->cargo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // uniforme
            $this->uniforme->ViewValue = $this->uniforme->CurrentValue;
            $this->uniforme->CssClass = "fw-bold";
            $this->uniforme->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // qtde
            $this->qtde->ViewValue = $this->qtde->CurrentValue;
            $this->qtde->ViewValue = FormatNumber($this->qtde->ViewValue, $this->qtde->formatPattern());
            $this->qtde->CssClass = "fw-bold";
            $this->qtde->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->qtde->CellCssStyle .= "text-align: right;";

            // periodo_troca
            $this->periodo_troca->ViewValue = $this->periodo_troca->CurrentValue;
            $this->periodo_troca->ViewValue = FormatNumber($this->periodo_troca->ViewValue, $this->periodo_troca->formatPattern());
            $this->periodo_troca->CssClass = "fw-bold";
            $this->periodo_troca->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->periodo_troca->CellCssStyle .= "text-align: center;";

            // vr_unitario
            $this->vr_unitario->ViewValue = $this->vr_unitario->CurrentValue;
            $this->vr_unitario->ViewValue = FormatCurrency($this->vr_unitario->ViewValue, $this->vr_unitario->formatPattern());
            $this->vr_unitario->CssClass = "fw-bold";
            $this->vr_unitario->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->vr_unitario->CellCssStyle .= "text-align: right;";

            // tipo_uniforme
            $this->tipo_uniforme->ViewValue = $this->tipo_uniforme->CurrentValue;
            $this->tipo_uniforme->CssClass = "fw-bold";
            $this->tipo_uniforme->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // vr_anual
            $this->vr_anual->ViewValue = $this->vr_anual->CurrentValue;
            $this->vr_anual->ViewValue = FormatCurrency($this->vr_anual->ViewValue, $this->vr_anual->formatPattern());
            $this->vr_anual->CssClass = "fw-bold";
            $this->vr_anual->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->vr_anual->CellCssStyle .= "text-align: right;";

            // vr_mesal
            $this->vr_mesal->ViewValue = $this->vr_mesal->CurrentValue;
            $this->vr_mesal->ViewValue = FormatCurrency($this->vr_mesal->ViewValue, $this->vr_mesal->formatPattern());
            $this->vr_mesal->CssClass = "fw-bold";
            $this->vr_mesal->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->vr_mesal->CellCssStyle .= "text-align: right;";

            // cliente
            $this->cliente->ViewValue = $this->cliente->CurrentValue;
            $this->cliente->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // idplanilha_custo
            $this->idplanilha_custo->HrefValue = "";
            $this->idplanilha_custo->TooltipValue = "";

            // proposta_idproposta
            $this->proposta_idproposta->HrefValue = "";
            $this->proposta_idproposta->TooltipValue = "";

            // dt_proposta
            $this->dt_proposta->HrefValue = "";
            $this->dt_proposta->TooltipValue = "";

            // qtde_cargos
            $this->qtde_cargos->HrefValue = "";
            $this->qtde_cargos->TooltipValue = "";

            // cargo_idcargo
            $this->cargo_idcargo->HrefValue = "";
            $this->cargo_idcargo->TooltipValue = "";

            // cargo
            $this->cargo->HrefValue = "";
            $this->cargo->TooltipValue = "";

            // uniforme
            $this->uniforme->HrefValue = "";
            $this->uniforme->TooltipValue = "";

            // qtde
            $this->qtde->HrefValue = "";
            $this->qtde->TooltipValue = "";

            // periodo_troca
            $this->periodo_troca->HrefValue = "";
            $this->periodo_troca->TooltipValue = "";

            // vr_unitario
            $this->vr_unitario->HrefValue = "";
            $this->vr_unitario->TooltipValue = "";

            // tipo_uniforme
            $this->tipo_uniforme->HrefValue = "";
            $this->tipo_uniforme->TooltipValue = "";

            // vr_anual
            $this->vr_anual->HrefValue = "";
            $this->vr_anual->TooltipValue = "";

            // vr_mesal
            $this->vr_mesal->HrefValue = "";
            $this->vr_mesal->TooltipValue = "";

            // cliente
            $this->cliente->HrefValue = "";
            $this->cliente->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == RowType::TOTAL) { // Summary row
        } else {
            // idplanilha_custo
            $currentValue = $this->idplanilha_custo->CurrentValue;
            $viewValue = &$this->idplanilha_custo->ViewValue;
            $viewAttrs = &$this->idplanilha_custo->ViewAttrs;
            $cellAttrs = &$this->idplanilha_custo->CellAttrs;
            $hrefValue = &$this->idplanilha_custo->HrefValue;
            $linkAttrs = &$this->idplanilha_custo->LinkAttrs;
            $this->cellRendered($this->idplanilha_custo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // proposta_idproposta
            $currentValue = $this->proposta_idproposta->CurrentValue;
            $viewValue = &$this->proposta_idproposta->ViewValue;
            $viewAttrs = &$this->proposta_idproposta->ViewAttrs;
            $cellAttrs = &$this->proposta_idproposta->CellAttrs;
            $hrefValue = &$this->proposta_idproposta->HrefValue;
            $linkAttrs = &$this->proposta_idproposta->LinkAttrs;
            $this->cellRendered($this->proposta_idproposta, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dt_proposta
            $currentValue = $this->dt_proposta->CurrentValue;
            $viewValue = &$this->dt_proposta->ViewValue;
            $viewAttrs = &$this->dt_proposta->ViewAttrs;
            $cellAttrs = &$this->dt_proposta->CellAttrs;
            $hrefValue = &$this->dt_proposta->HrefValue;
            $linkAttrs = &$this->dt_proposta->LinkAttrs;
            $this->cellRendered($this->dt_proposta, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // qtde_cargos
            $currentValue = $this->qtde_cargos->CurrentValue;
            $viewValue = &$this->qtde_cargos->ViewValue;
            $viewAttrs = &$this->qtde_cargos->ViewAttrs;
            $cellAttrs = &$this->qtde_cargos->CellAttrs;
            $hrefValue = &$this->qtde_cargos->HrefValue;
            $linkAttrs = &$this->qtde_cargos->LinkAttrs;
            $this->cellRendered($this->qtde_cargos, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cargo_idcargo
            $currentValue = $this->cargo_idcargo->CurrentValue;
            $viewValue = &$this->cargo_idcargo->ViewValue;
            $viewAttrs = &$this->cargo_idcargo->ViewAttrs;
            $cellAttrs = &$this->cargo_idcargo->CellAttrs;
            $hrefValue = &$this->cargo_idcargo->HrefValue;
            $linkAttrs = &$this->cargo_idcargo->LinkAttrs;
            $this->cellRendered($this->cargo_idcargo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cargo
            $currentValue = $this->cargo->CurrentValue;
            $viewValue = &$this->cargo->ViewValue;
            $viewAttrs = &$this->cargo->ViewAttrs;
            $cellAttrs = &$this->cargo->CellAttrs;
            $hrefValue = &$this->cargo->HrefValue;
            $linkAttrs = &$this->cargo->LinkAttrs;
            $this->cellRendered($this->cargo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // uniforme
            $currentValue = $this->uniforme->CurrentValue;
            $viewValue = &$this->uniforme->ViewValue;
            $viewAttrs = &$this->uniforme->ViewAttrs;
            $cellAttrs = &$this->uniforme->CellAttrs;
            $hrefValue = &$this->uniforme->HrefValue;
            $linkAttrs = &$this->uniforme->LinkAttrs;
            $this->cellRendered($this->uniforme, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // qtde
            $currentValue = $this->qtde->CurrentValue;
            $viewValue = &$this->qtde->ViewValue;
            $viewAttrs = &$this->qtde->ViewAttrs;
            $cellAttrs = &$this->qtde->CellAttrs;
            $hrefValue = &$this->qtde->HrefValue;
            $linkAttrs = &$this->qtde->LinkAttrs;
            $this->cellRendered($this->qtde, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // periodo_troca
            $currentValue = $this->periodo_troca->CurrentValue;
            $viewValue = &$this->periodo_troca->ViewValue;
            $viewAttrs = &$this->periodo_troca->ViewAttrs;
            $cellAttrs = &$this->periodo_troca->CellAttrs;
            $hrefValue = &$this->periodo_troca->HrefValue;
            $linkAttrs = &$this->periodo_troca->LinkAttrs;
            $this->cellRendered($this->periodo_troca, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // vr_unitario
            $currentValue = $this->vr_unitario->CurrentValue;
            $viewValue = &$this->vr_unitario->ViewValue;
            $viewAttrs = &$this->vr_unitario->ViewAttrs;
            $cellAttrs = &$this->vr_unitario->CellAttrs;
            $hrefValue = &$this->vr_unitario->HrefValue;
            $linkAttrs = &$this->vr_unitario->LinkAttrs;
            $this->cellRendered($this->vr_unitario, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // tipo_uniforme
            $currentValue = $this->tipo_uniforme->CurrentValue;
            $viewValue = &$this->tipo_uniforme->ViewValue;
            $viewAttrs = &$this->tipo_uniforme->ViewAttrs;
            $cellAttrs = &$this->tipo_uniforme->CellAttrs;
            $hrefValue = &$this->tipo_uniforme->HrefValue;
            $linkAttrs = &$this->tipo_uniforme->LinkAttrs;
            $this->cellRendered($this->tipo_uniforme, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // vr_anual
            $currentValue = $this->vr_anual->CurrentValue;
            $viewValue = &$this->vr_anual->ViewValue;
            $viewAttrs = &$this->vr_anual->ViewAttrs;
            $cellAttrs = &$this->vr_anual->CellAttrs;
            $hrefValue = &$this->vr_anual->HrefValue;
            $linkAttrs = &$this->vr_anual->LinkAttrs;
            $this->cellRendered($this->vr_anual, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // vr_mesal
            $currentValue = $this->vr_mesal->CurrentValue;
            $viewValue = &$this->vr_mesal->ViewValue;
            $viewAttrs = &$this->vr_mesal->ViewAttrs;
            $cellAttrs = &$this->vr_mesal->CellAttrs;
            $hrefValue = &$this->vr_mesal->HrefValue;
            $linkAttrs = &$this->vr_mesal->LinkAttrs;
            $this->cellRendered($this->vr_mesal, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cliente
            $currentValue = $this->cliente->CurrentValue;
            $viewValue = &$this->cliente->ViewValue;
            $viewAttrs = &$this->cliente->ViewAttrs;
            $cellAttrs = &$this->cliente->CellAttrs;
            $hrefValue = &$this->cliente->HrefValue;
            $linkAttrs = &$this->cliente->LinkAttrs;
            $this->cellRendered($this->cliente, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        }

        // Call Row_Rendered event
        $this->rowRendered();
        $this->setupFieldCount();
    }
    private $groupCounts = [];

    // Get group count
    public function getGroupCount(...$args)
    {
        $key = implode("_", array_map(fn($arg) => strval($arg), $args));
        if ($key == "") {
            return -1;
        } elseif ($key == "0") { // Number of first level groups
            $i = 1;
            while (isset($this->groupCounts[strval($i)])) {
                $i++;
            }
            return $i - 1;
        }
        return isset($this->groupCounts[$key]) ? $this->groupCounts[$key] : -1;
    }

    // Set group count
    public function setGroupCount($value, ...$args)
    {
        $key = implode("_", array_map(fn($arg) => strval($arg), $args));
        if ($key == "") {
            return;
        }
        $this->groupCounts[$key] = $value;
    }

    // Setup field count
    protected function setupFieldCount()
    {
        $this->GroupColumnCount = 0;
        $this->SubGroupColumnCount = 0;
        $this->DetailColumnCount = 0;
        if ($this->idplanilha_custo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->proposta_idproposta->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->dt_proposta->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->qtde_cargos->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cargo_idcargo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cargo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->uniforme->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->qtde->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->periodo_troca->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->vr_unitario->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->tipo_uniforme->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->vr_anual->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->vr_mesal->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cliente->Visible) {
            $this->DetailColumnCount += 1;
        }
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        if ($type == "print" || $custom) { // Printer friendly / custom export
            $pageUrl = $this->pageUrl(false);
            $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        } else { // Export API URL
            $exportUrl = GetApiUrl(Config("API_EXPORT_ACTION") . "/" . $type . "/" . $this->TableVar);
        }
        if (SameText($type, "excel")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-excel" title="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-ew-action="export" data-export="excel" data-custom="true" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToExcel") . '</button>';
        } elseif (SameText($type, "word")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-word" title="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-ew-action="export" data-export="word" data-custom="true" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToWord") . '</button>';
        } elseif (SameText($type, "pdf")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-pdf" title="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-ew-action="export" data-export="pdf" data-custom="true" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToPdf") . '</button>';
        } elseif (SameText($type, "html")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-html" title="' . HtmlEncode($Language->phrase("ExportToHtml", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToHtml", true)) . '" data-ew-action="export" data-export="html" data-custom="true" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToHtml") . '</button>';
        } elseif (SameText($type, "email")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-ew-action="email" data-custom="true" data-export-selected="false" data-hdr="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language, $Security;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = true;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel", true);
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word", true);
        $item->Visible = false;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html", true);
        $item->Visible = false;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf", true);
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email", true);
        $item->Visible = true;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide options for export
        if ($this->isExport()) {
            $this->ExportOptions->hideAllOptions();
        }
        if (!$Security->canExport()) { // Export not allowed
            $this->ExportOptions->hideAllOptions();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl(false);
        $this->SearchOptions = new ListOptions(TagClassName: "ew-search-option");

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        if ($this->UseCustomTemplate || !$this->UseAjaxActions) {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" data-ew-action=\"refresh\" data-url=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        }
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction && $this->CurrentAction != "search") {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return $this->idplanilha_custo->Visible;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset(all)
        $Breadcrumb->add("summary", $this->TableVar, $url, "", $this->TableVar, true);
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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"frel_testesrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"frel_testesrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up starting group
    protected function setupStartGroup()
    {
        // Exit if no groups
        if ($this->DisplayGroups == 0) {
            return;
        }
        $startGrp = Param(Config("TABLE_START_GROUP"));
        $pageNo = Param(Config("TABLE_PAGE_NUMBER"));

        // Check for a 'start' parameter
        if ($startGrp !== null) {
            $this->StartGroup = $startGrp;
            $this->setStartGroup($this->StartGroup);
        } elseif ($pageNo !== null) {
            $pageNo = ParseInteger($pageNo);
            if (is_numeric($pageNo)) {
                $this->StartGroup = ($pageNo - 1) * $this->DisplayGroups + 1;
                if ($this->StartGroup <= 0) {
                    $this->StartGroup = 1;
                } elseif ($this->StartGroup >= intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1) {
                    $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1;
                }
                $this->setStartGroup($this->StartGroup);
            } else {
                $this->StartGroup = $this->getStartGroup();
            }
        } else {
            $this->StartGroup = $this->getStartGroup();
        }

        // Check if correct start group counter
        if (!is_numeric($this->StartGroup) || intval($this->StartGroup) <= 0) { // Avoid invalid start group counter
            $this->StartGroup = 1; // Reset start group counter
            $this->setStartGroup($this->StartGroup);
        } elseif (intval($this->StartGroup) > intval($this->TotalGroups)) { // Avoid starting group > total groups
            $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to last page first group
            $this->setStartGroup($this->StartGroup);
        } elseif (($this->StartGroup - 1) % $this->DisplayGroups != 0) {
            $this->StartGroup = intval(($this->StartGroup - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to page boundary
            $this->setStartGroup($this->StartGroup);
        }
    }

    // Reset pager
    protected function resetPager()
    {
        // Reset start position (reset command)
        $this->StartGroup = 1;
        $this->setStartGroup($this->StartGroup);
    }

    // Set up number of groups displayed per page
    protected function setupDisplayGroups()
    {
        if (Param(Config("TABLE_GROUP_PER_PAGE")) !== null) {
            $wrk = Param(Config("TABLE_GROUP_PER_PAGE"));
            if (is_numeric($wrk)) {
                $this->DisplayGroups = intval($wrk);
            } else {
                if (SameText($wrk, "ALL")) { // Display all groups
                    $this->DisplayGroups = -1;
                } else {
                    $this->DisplayGroups = 50; // Non-numeric, load default
                }
            }
            $this->setGroupPerPage($this->DisplayGroups); // Save to session

            // Reset start position (reset command)
            $this->StartGroup = 1;
            $this->setStartGroup($this->StartGroup);
        } else {
            if ($this->getGroupPerPage() != "") {
                $this->DisplayGroups = $this->getGroupPerPage(); // Restore from session
            } else {
                $this->DisplayGroups = 50; // Load default
            }
        }
    }

    // Get sort parameters based on sort links clicked
    protected function getSort()
    {
        if ($this->DrillDown) {
            return "";
        }
        $resetSort = Param("cmd") === "resetsort";
        $orderBy = Param("order", "");
        $orderType = Param("ordertype", "");

        // Check for Ctrl pressed
        $ctrl = (Param("ctrl") !== null);

        // Check for a resetsort command
        if ($resetSort) {
            $this->setOrderBy("");
            $this->setStartGroup(1);
            $this->idplanilha_custo->setSort("");
            $this->proposta_idproposta->setSort("");
            $this->dt_proposta->setSort("");
            $this->qtde_cargos->setSort("");
            $this->cargo_idcargo->setSort("");
            $this->cargo->setSort("");
            $this->uniforme->setSort("");
            $this->qtde->setSort("");
            $this->periodo_troca->setSort("");
            $this->vr_unitario->setSort("");
            $this->tipo_uniforme->setSort("");
            $this->vr_anual->setSort("");
            $this->vr_mesal->setSort("");
            $this->cliente->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->idplanilha_custo, $ctrl); // idplanilha_custo
            $this->updateSort($this->proposta_idproposta, $ctrl); // proposta_idproposta
            $this->updateSort($this->dt_proposta, $ctrl); // dt_proposta
            $this->updateSort($this->qtde_cargos, $ctrl); // qtde_cargos
            $this->updateSort($this->cargo_idcargo, $ctrl); // cargo_idcargo
            $this->updateSort($this->cargo, $ctrl); // cargo
            $this->updateSort($this->uniforme, $ctrl); // uniforme
            $this->updateSort($this->qtde, $ctrl); // qtde
            $this->updateSort($this->periodo_troca, $ctrl); // periodo_troca
            $this->updateSort($this->vr_unitario, $ctrl); // vr_unitario
            $this->updateSort($this->tipo_uniforme, $ctrl); // tipo_uniforme
            $this->updateSort($this->vr_anual, $ctrl); // vr_anual
            $this->updateSort($this->vr_mesal, $ctrl); // vr_mesal
            $this->updateSort($this->cliente, $ctrl); // cliente
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }
        return $this->getOrderBy();
    }

    // Return extended filter
    protected function getExtendedFilter()
    {
        $filter = "";
        if ($this->DrillDown) {
            return "";
        }
        $restoreSession = false;
        $restoreDefault = false;
        // Reset search command
        if (Get("cmd") == "reset") {
            // Set default values
            $this->idplanilha_custo->AdvancedSearch->unsetSession();
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;

            // Field idplanilha_custo
            $this->getDropDownValue($this->idplanilha_custo);
            if (!$this->validateForm()) {
                return $filter;
            }
        }

        // Restore session
        if ($restoreSession) {
            $restoreDefault = true;
            if ($this->idplanilha_custo->AdvancedSearch->issetSession()) { // Field idplanilha_custo
                $this->idplanilha_custo->AdvancedSearch->load();
                $restoreDefault = false;
            }
        }

        // Restore default
        if ($restoreDefault) {
            $this->loadDefaultFilters();
        }

        // Call page filter validated event
        $this->pageFilterValidated();

        // Build SQL and save to session
        $this->buildDropDownFilter($this->idplanilha_custo, $filter, false, true); // Field idplanilha_custo
        $this->idplanilha_custo->AdvancedSearch->save();
        return $filter;
    }

    // Build dropdown filter
    protected function buildDropDownFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        if (!EmptyValue($fld->DateFilter)) {
            $fldVal2 = "";
        } elseif ($fld->UseFilter) {
            $fldOpr = "";
            $fldVal2 = "";
        }
        $sql = "";
        if (is_array($fldVal)) {
            foreach ($fldVal as $val) {
                $wrk = DropDownFilter($fld, $val, $fldOpr, $this->Dbid);

                // Call Page Filtering event
                if (StartsString("@@", $val)) {
                    $this->pageFiltering($fld, $wrk, "custom", substr($val, 2));
                } else {
                    $this->pageFiltering($fld, $wrk, "dropdown", $fldOpr, $val);
                }
                AddFilter($sql, $wrk, "OR");
            }
        } else {
            $sql = DropDownFilter($fld, $fldVal, $fldOpr, $this->Dbid, $fldVal2);

            // Call Page Filtering event
            if (StartsString("@@", $fldVal)) {
                $this->pageFiltering($fld, $sql, "custom", substr($fldVal, 2));
            } else {
                $this->pageFiltering($fld, $sql, "dropdown", $fldOpr, $fldVal, "", "", $fldVal2);
            }
        }
        if ($sql != "") {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
            AddFilter($filterClause, $sql, $cond);
            if ($saveFilter) {
                $fld->CurrentFilter = $sql;
            }
        }
    }

    // Build extended filter
    protected function buildExtendedFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $wrk = GetReportFilter($fld, $default, $this->Dbid);
        if (!$default) {
            $this->pageFiltering($fld, $wrk, "extended", $fld->AdvancedSearch->SearchOperator, $fld->AdvancedSearch->SearchValue, $fld->AdvancedSearch->SearchCondition, $fld->AdvancedSearch->SearchOperator2, $fld->AdvancedSearch->SearchValue2);
        }
        if ($wrk != "") {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
            AddFilter($filterClause, $wrk, $cond);
            if ($saveFilter) {
                $fld->CurrentFilter = $wrk;
            }
        }
    }

    // Get drop down value from querystring
    protected function getDropDownValue(&$fld)
    {
        if (IsPost()) {
            return false; // Skip post back
        }
        $res = false;
        $parm = $fld->Param;
        $sep = $fld->UseFilter ? Config("FILTER_OPTION_SEPARATOR") : Config("MULTIPLE_OPTION_SEPARATOR");
        $opr = Get("z_$parm");
        if ($opr !== null) {
            $fld->AdvancedSearch->SearchOperator = $opr;
        }
        $val = Get("x_$parm");
        if ($val !== null) {
            if (is_array($val)) {
                $val = implode($sep, $val);
            }
            $fld->AdvancedSearch->setSearchValue($val);
            $res = true;
        }
        $val2 = Get("y_$parm");
        if ($val2 !== null) {
            if (is_array($val2)) {
                $val2 = implode($sep, $val2);
            }
            $fld->AdvancedSearch->setSearchValue2($val2);
            $res = true;
        }
        return $res;
    }

    // Dropdown filter exist
    protected function dropDownFilterExist(&$fld)
    {
        $wrk = "";
        $this->buildDropDownFilter($fld, $wrk);
        return ($wrk != "");
    }

    // Extended filter exist
    protected function extendedFilterExist(&$fld)
    {
        $extWrk = "";
        $this->buildExtendedFilter($fld, $extWrk);
        return ($extWrk != "");
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Load default value for filters
    protected function loadDefaultFilters()
    {
        // Field idplanilha_custo
        $this->idplanilha_custo->AdvancedSearch->loadDefault();
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Show Filters
        if ($filterList != "") {
            $message = "<template id=\"tp_current_filters\">" . $filterList . "</template>";
            $this->messageShowing($message, "");
            Write($message);
        } else { // Output empty tag
            Write("<template id=\"tp_current_filters\"></template>");
        }
    }

    // Get list of filters
    public function getFilterList()
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Return filter list in json
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd", "") != "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter", ""), true);
        return $this->setupFilterList($filter);
    }

    // Setup list of filters
    protected function setupFilterList($filter)
    {
        if (!is_array($filter)) {
            return false;
        }
        return true;
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

    // Page Selecting event
    public function pageSelecting(&$filter)
    {
        // Enter your code here
    }

    // Load Filters event
    public function pageFilterLoad()
    {
        // Enter your code here
        // Example: Register/Unregister Custom Extended Filter
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
        //UnregisterFilter($this-><Field>, 'StartsWithA');
    }

    // Page Filter Validated event
    public function pageFilterValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Page Filtering event
    public function pageFiltering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "")
    {
        // Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
        //if ($typ == "dropdown" && $fld->Name == "MyField") // Dropdown filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "extended" && $fld->Name == "MyField") // Extended filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "custom" && $opr == "..." && $fld->Name == "MyField") // Custom filter, $opr is the custom filter ID
        //    $filter = "..."; // Modify the filter
    }

    // Cell Rendered event
    public function cellRendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs)
    {
        //$ViewValue = "xxx";
        //$ViewAttrs["class"] = "xxx";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
