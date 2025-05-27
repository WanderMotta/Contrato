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
class RelPlanilhaCustoSummary extends RelPlanilhaCusto
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RelPlanilhaCustoSummary";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $ReportContainerClass = "ew-grid";
    public $CurrentPageName = "RelPlanilhaCusto";

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
        $this->TableVar = 'rel_planilha_custo';
        $this->TableName = 'rel_planilha_custo';

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->ReportContainerClass, $this->ContextClass);

        // Fixed header table
        if (!$this->UseCustomTemplate) {
            $this->setFixedHeaderTable(Config("USE_FIXED_HEADER_TABLE"), Config("FIXED_HEADER_TABLE_HEIGHT"));
        }

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (rel_planilha_custo)
        if (!isset($GLOBALS["rel_planilha_custo"]) || $GLOBALS["rel_planilha_custo"]::class == PROJECT_NAMESPACE . "rel_planilha_custo") {
            $GLOBALS["rel_planilha_custo"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'rel_planilha_custo');
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

        // Set field visibility for detail fields
        $this->item->setVisibility();
        $this->porcentagem->setVisibility();
        $this->valor->setVisibility();
        $this->obs->setVisibility();

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

        // Requires search criteria
        if (($this->SearchWhere == "") && !$this->DrillDown) {
            $this->SearchWhere = "0=101";
        }

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

        // Get total group count
        $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
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

        // Get group records
        if ($this->TotalGroups > 0) {
            $grpSort = UpdateSortFields($this->getSqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
            $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderByGroup(), $this->Filter, $grpSort);
            $grpRs = $sql->setFirstResult(max($this->StartGroup - 1, 0))->setMaxResults($this->DisplayGroups)->executeQuery();
            $this->GroupRecords = $grpRs->fetchAll(); // Get records of first grouping field
            $this->loadGroupRowValues();
            $this->GroupCount = 1;
        }

        // Init detail records
        $this->DetailRecords = [];
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

    // Load group row values
    public function loadGroupRowValues()
    {
        $cnt = count($this->GroupRecords); // Get record count
        if ($this->GroupCount < $cnt) {
            $this->idproposta->setGroupValue(reset($this->GroupRecords[$this->GroupCount]));
        } else {
            $this->idproposta->setGroupValue("");
        }
    }

    // Load row values
    public function loadRowValues($record)
    {
        $data = [];
        $data["idproposta"] = $record['idproposta'];
        $data["dt_cadastro"] = $record['dt_cadastro'];
        $data["cliente"] = $record['cliente'];
        $data["modulo"] = $record['modulo'];
        $data["item"] = $record['item'];
        $data["porcentagem"] = $record['porcentagem'];
        $data["valor"] = $record['valor'];
        $data["obs"] = $record['obs'];
        $data["posicao"] = $record['posicao'];
        $data["idplanilha_custo"] = $record['idplanilha_custo'];
        $data["cargo"] = $record['cargo'];
        $data["sub_modulos"] = $record['sub_modulos'];
        $data["idcliente"] = $record['idcliente'];
        $this->Rows[] = $data;
        $this->idproposta->setDbValue(GroupValue($this->idproposta, $record['idproposta']));
        $this->dt_cadastro->setDbValue($record['dt_cadastro']);
        $this->cliente->setDbValue($record['cliente']);
        $this->modulo->setDbValue($record['modulo']);
        $this->item->setDbValue($record['item']);
        $this->porcentagem->setDbValue($record['porcentagem']);
        $this->valor->setDbValue($record['valor']);
        $this->obs->setDbValue($record['obs']);
        $this->posicao->setDbValue($record['posicao']);
        $this->idplanilha_custo->setDbValue($record['idplanilha_custo']);
        $this->cargo->setDbValue($record['cargo']);
        $this->sub_modulos->setDbValue($record['sub_modulos']);
        $this->idcliente->setDbValue($record['idcliente']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == RowType::TOTAL && $this->RowTotalSubType == RowTotal::FOOTER && $this->RowTotalType == RowSummary::PAGE) {
            // Build detail SQL
            $firstGrpFld = &$this->idproposta;
            $firstGrpFld->getDistinctValues($this->GroupRecords);
            $where = DetailFilterSql($firstGrpFld, $this->getSqlFirstGroupField(), $firstGrpFld->DistinctValues, $this->Dbid);
            AddFilter($where, $this->Filter);
            $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $where, $this->Sort);
            $rs = $sql->executeQuery();
            $records = $rs?->fetchAll() ?? [];
            $this->porcentagem->getSum($records, false);
            $this->valor->getSum($records, false);
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

            // Get total from SQL directly
            $sql = $this->buildReportSql($this->getSqlSelectAggregate(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
            $sql = $this->getSqlAggregatePrefix() . $sql . $this->getSqlAggregateSuffix();
            $rsagg = $conn->fetchAssociative($sql);
            if ($rsagg) {
                $this->item->Count = $this->TotalCount;
                $this->porcentagem->Count = $this->TotalCount;
                $this->porcentagem->SumValue = $rsagg["sum_porcentagem"];
                $this->valor->Count = $this->TotalCount;
                $this->valor->SumValue = $rsagg["sum_valor"];
                $this->obs->Count = $this->TotalCount;
                $hasSummary = true;
            }

            // Accumulate grand summary from detail records
            if (!$hasCount || !$hasSummary) {
                $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
                $rs = $sql->executeQuery();
                $this->DetailRecords = $rs?->fetchAll() ?? [];
                $this->porcentagem->getSum($this->DetailRecords, false);
                $this->valor->getSum($this->DetailRecords, false);
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // idproposta

        // dt_cadastro

        // cliente

        // idplanilha_custo

        // cargo

        // modulo

        // item

        // porcentagem

        // valor

        // obs
        if ($this->RowType == RowType::SEARCH) {
            // modulo
            if ($this->modulo->UseFilter && !EmptyValue($this->modulo->AdvancedSearch->SearchValue)) {
                if (is_array($this->modulo->AdvancedSearch->SearchValue)) {
                    $this->modulo->AdvancedSearch->SearchValue = implode(Config("FILTER_OPTION_SEPARATOR"), $this->modulo->AdvancedSearch->SearchValue);
                }
                $this->modulo->EditValue = explode(Config("FILTER_OPTION_SEPARATOR"), $this->modulo->AdvancedSearch->SearchValue);
            }

            // item
            if ($this->item->UseFilter && !EmptyValue($this->item->AdvancedSearch->SearchValue)) {
                if (is_array($this->item->AdvancedSearch->SearchValue)) {
                    $this->item->AdvancedSearch->SearchValue = implode(Config("FILTER_OPTION_SEPARATOR"), $this->item->AdvancedSearch->SearchValue);
                }
                $this->item->EditValue = explode(Config("FILTER_OPTION_SEPARATOR"), $this->item->AdvancedSearch->SearchValue);
            }

            // idplanilha_custo
            $curVal = trim(strval($this->idplanilha_custo->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->idplanilha_custo->AdvancedSearch->ViewValue = $this->idplanilha_custo->lookupCacheOption($curVal);
            } else {
                $this->idplanilha_custo->AdvancedSearch->ViewValue = $this->idplanilha_custo->Lookup !== null && is_array($this->idplanilha_custo->lookupOptions()) && count($this->idplanilha_custo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->idplanilha_custo->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->idplanilha_custo->EditValue = array_values($this->idplanilha_custo->lookupOptions());
                if ($this->idplanilha_custo->AdvancedSearch->ViewValue == "") {
                    $this->idplanilha_custo->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->idplanilha_custo->Lookup->getTable()->Fields["idplanilha_custo"]->searchExpression(), "=", $this->idplanilha_custo->AdvancedSearch->SearchValue, $this->idplanilha_custo->Lookup->getTable()->Fields["idplanilha_custo"]->searchDataType(), "");
                }
                $sqlWrk = $this->idplanilha_custo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idplanilha_custo->Lookup->renderViewRow($rswrk[0]);
                    $this->idplanilha_custo->AdvancedSearch->ViewValue = $this->idplanilha_custo->displayValue($arwrk);
                } else {
                    $this->idplanilha_custo->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->idplanilha_custo->EditValue = $arwrk;
            }
            $this->idplanilha_custo->PlaceHolder = RemoveHtml($this->idplanilha_custo->caption());
        } elseif ($this->RowType == RowType::TOTAL && !($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class
            if ($this->RowTotalType == RowSummary::GROUP) {
                $this->RowAttrs["data-group"] = $this->idproposta->groupValue(); // Set up group attribute
            }
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowGroupLevel >= 2) {
                $this->RowAttrs["data-group-2"] = $this->dt_cadastro->groupValue(); // Set up group attribute 2
            }
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowGroupLevel >= 3) {
                $this->RowAttrs["data-group-3"] = $this->cliente->groupValue(); // Set up group attribute 3
            }
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowGroupLevel >= 4) {
                $this->RowAttrs["data-group-4"] = $this->idplanilha_custo->groupValue(); // Set up group attribute 4
            }
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowGroupLevel >= 5) {
                $this->RowAttrs["data-group-5"] = $this->cargo->groupValue(); // Set up group attribute 5
            }
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowGroupLevel >= 6) {
                $this->RowAttrs["data-group-6"] = $this->modulo->groupValue(); // Set up group attribute 6
            }

            // idproposta
            $this->idproposta->GroupViewValue = $this->idproposta->groupValue();
            $this->idproposta->CssClass = "fw-bold";
            $this->idproposta->CellCssClass = ($this->RowGroupLevel == 1 ? "ew-rpt-grp-summary-1" : "ew-rpt-grp-field-1");
            $this->idproposta->CellCssStyle .= "text-align: center;";
            $this->idproposta->GroupViewValue = DisplayGroupValue($this->idproposta, $this->idproposta->GroupViewValue);

            // dt_cadastro
            $this->dt_cadastro->GroupViewValue = $this->dt_cadastro->groupValue();
            $this->dt_cadastro->GroupViewValue = FormatDateTime($this->dt_cadastro->GroupViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";
            $this->dt_cadastro->CellCssClass = ($this->RowGroupLevel == 2 ? "ew-rpt-grp-summary-2" : "ew-rpt-grp-field-2");
            $this->dt_cadastro->GroupViewValue = DisplayGroupValue($this->dt_cadastro, $this->dt_cadastro->GroupViewValue);

            // cliente
            $this->cliente->GroupViewValue = $this->cliente->groupValue();
            $this->cliente->CssClass = "fw-bold";
            $this->cliente->CellCssClass = ($this->RowGroupLevel == 3 ? "ew-rpt-grp-summary-3" : "ew-rpt-grp-field-3");
            $this->cliente->GroupViewValue = DisplayGroupValue($this->cliente, $this->cliente->GroupViewValue);

            // idplanilha_custo
            $arwrk = [];
            $arwrk["lf"] = $this->idplanilha_custo->CurrentValue;
            $arwrk["df"] = $this->idplanilha_custo->CurrentValue;
            $arwrk["df2"] = $this->cliente->CurrentValue;
            $arwrk["df3"] = $this->cargo->CurrentValue;
            $arwrk = $this->idplanilha_custo->Lookup->renderViewRow($arwrk, $this);
            $dispVal = $this->idplanilha_custo->displayValue($arwrk);
            if ($dispVal != "") {
                $this->idplanilha_custo->GroupViewValue = $dispVal;
            }
            $this->idplanilha_custo->CssClass = "fw-bold";
            $this->idplanilha_custo->CellCssClass = ($this->RowGroupLevel == 4 ? "ew-rpt-grp-summary-4" : "ew-rpt-grp-field-4");
            $this->idplanilha_custo->CellCssStyle .= "text-align: center;";
            $this->idplanilha_custo->GroupViewValue = DisplayGroupValue($this->idplanilha_custo, $this->idplanilha_custo->GroupViewValue);

            // cargo
            $this->cargo->GroupViewValue = $this->cargo->groupValue();
            $this->cargo->CssClass = "fw-bold";
            $this->cargo->CellCssClass = ($this->RowGroupLevel == 5 ? "ew-rpt-grp-summary-5" : "ew-rpt-grp-field-5");
            $this->cargo->GroupViewValue = DisplayGroupValue($this->cargo, $this->cargo->GroupViewValue);

            // modulo
            $curVal = strval($this->modulo->groupValue());
            if ($curVal != "") {
                $this->modulo->GroupViewValue = $this->modulo->lookupCacheOption($curVal);
                if ($this->modulo->GroupViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->modulo->Lookup->getTable()->Fields["modulo"]->searchExpression(), "=", $curVal, $this->modulo->Lookup->getTable()->Fields["modulo"]->searchDataType(), "");
                    $sqlWrk = $this->modulo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->modulo->Lookup->renderViewRow($rswrk[0]);
                        $this->modulo->GroupViewValue = $this->modulo->displayValue($arwrk);
                    } else {
                        $this->modulo->GroupViewValue = $this->modulo->groupValue();
                    }
                }
            } else {
                $this->modulo->GroupViewValue = null;
            }
            $this->modulo->CssClass = "fw-bold";
            $this->modulo->CellCssClass = ($this->RowGroupLevel == 6 ? "ew-rpt-grp-summary-6" : "ew-rpt-grp-field-6");
            $this->modulo->GroupViewValue = DisplayGroupValue($this->modulo, $this->modulo->GroupViewValue);

            // porcentagem
            $this->porcentagem->SumViewValue = $this->porcentagem->SumValue;
            $this->porcentagem->SumViewValue = FormatNumber($this->porcentagem->SumViewValue, $this->porcentagem->formatPattern());
            $this->porcentagem->CssClass = "fw-bold";
            $this->porcentagem->CellCssStyle .= "text-align: right;";
            $this->porcentagem->CellAttrs["class"] = ($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : "ew-rpt-grp-summary-" . $this->RowGroupLevel;

            // valor
            $this->valor->SumViewValue = $this->valor->SumValue;
            $this->valor->SumViewValue = FormatCurrency($this->valor->SumViewValue, $this->valor->formatPattern());
            $this->valor->CssClass = "fw-bold";
            $this->valor->CellCssStyle .= "text-align: right;";
            $this->valor->CellAttrs["class"] = ($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : "ew-rpt-grp-summary-" . $this->RowGroupLevel;

            // idproposta
            $this->idproposta->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // cliente
            $this->cliente->HrefValue = "";

            // idplanilha_custo
            $this->idplanilha_custo->HrefValue = "";

            // cargo
            $this->cargo->HrefValue = "";

            // modulo
            $this->modulo->HrefValue = "";

            // item
            $this->item->HrefValue = "";

            // porcentagem
            $this->porcentagem->HrefValue = "";

            // valor
            $this->valor->HrefValue = "";

            // obs
            $this->obs->HrefValue = "";
        } else {
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER) {
                $this->RowAttrs["data-group"] = $this->idproposta->groupValue(); // Set up group attribute
                if ($this->RowGroupLevel >= 2) {
                    $this->RowAttrs["data-group-2"] = $this->dt_cadastro->groupValue(); // Set up group attribute 2
                }
                if ($this->RowGroupLevel >= 3) {
                    $this->RowAttrs["data-group-3"] = $this->cliente->groupValue(); // Set up group attribute 3
                }
                if ($this->RowGroupLevel >= 4) {
                    $this->RowAttrs["data-group-4"] = $this->idplanilha_custo->groupValue(); // Set up group attribute 4
                }
                if ($this->RowGroupLevel >= 5) {
                    $this->RowAttrs["data-group-5"] = $this->cargo->groupValue(); // Set up group attribute 5
                }
                if ($this->RowGroupLevel >= 6) {
                    $this->RowAttrs["data-group-6"] = $this->modulo->groupValue(); // Set up group attribute 6
                }
            } else {
                $this->RowAttrs["data-group"] = $this->idproposta->groupValue(); // Set up group attribute
                $this->RowAttrs["data-group-2"] = $this->dt_cadastro->groupValue(); // Set up group attribute 2
                $this->RowAttrs["data-group-3"] = $this->cliente->groupValue(); // Set up group attribute 3
                $this->RowAttrs["data-group-4"] = $this->idplanilha_custo->groupValue(); // Set up group attribute 4
                $this->RowAttrs["data-group-5"] = $this->cargo->groupValue(); // Set up group attribute 5
                $this->RowAttrs["data-group-6"] = $this->modulo->groupValue(); // Set up group attribute 6
            }

            // idproposta
            $this->idproposta->GroupViewValue = $this->idproposta->groupValue();
            $this->idproposta->CssClass = "fw-bold";
            $this->idproposta->CellCssClass = "ew-rpt-grp-field-1";
            $this->idproposta->CellCssStyle .= "text-align: center;";
            $this->idproposta->GroupViewValue = DisplayGroupValue($this->idproposta, $this->idproposta->GroupViewValue);
            if (!$this->idproposta->LevelBreak) {
                $this->idproposta->GroupViewValue = "";
            } else {
                $this->idproposta->LevelBreak = false;
            }

            // dt_cadastro
            $this->dt_cadastro->GroupViewValue = $this->dt_cadastro->groupValue();
            $this->dt_cadastro->GroupViewValue = FormatDateTime($this->dt_cadastro->GroupViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";
            $this->dt_cadastro->CellCssClass = "ew-rpt-grp-field-2";
            $this->dt_cadastro->GroupViewValue = DisplayGroupValue($this->dt_cadastro, $this->dt_cadastro->GroupViewValue);
            if (!$this->dt_cadastro->LevelBreak) {
                $this->dt_cadastro->GroupViewValue = "";
            } else {
                $this->dt_cadastro->LevelBreak = false;
            }

            // cliente
            $this->cliente->GroupViewValue = $this->cliente->groupValue();
            $this->cliente->CssClass = "fw-bold";
            $this->cliente->CellCssClass = "ew-rpt-grp-field-3";
            $this->cliente->GroupViewValue = DisplayGroupValue($this->cliente, $this->cliente->GroupViewValue);
            if (!$this->cliente->LevelBreak) {
                $this->cliente->GroupViewValue = "";
            } else {
                $this->cliente->LevelBreak = false;
            }

            // idplanilha_custo
            $arwrk = [];
            $arwrk["lf"] = $this->idplanilha_custo->CurrentValue;
            $arwrk["df"] = $this->idplanilha_custo->CurrentValue;
            $arwrk["df2"] = $this->cliente->CurrentValue;
            $arwrk["df3"] = $this->cargo->CurrentValue;
            $arwrk = $this->idplanilha_custo->Lookup->renderViewRow($arwrk, $this);
            $dispVal = $this->idplanilha_custo->displayValue($arwrk);
            if ($dispVal != "") {
                $this->idplanilha_custo->GroupViewValue = $dispVal;
            }
            $this->idplanilha_custo->CssClass = "fw-bold";
            $this->idplanilha_custo->CellCssClass = "ew-rpt-grp-field-4";
            $this->idplanilha_custo->CellCssStyle .= "text-align: center;";
            $this->idplanilha_custo->GroupViewValue = DisplayGroupValue($this->idplanilha_custo, $this->idplanilha_custo->GroupViewValue);
            if (!$this->idplanilha_custo->LevelBreak) {
                $this->idplanilha_custo->GroupViewValue = "";
            } else {
                $this->idplanilha_custo->LevelBreak = false;
            }

            // cargo
            $this->cargo->GroupViewValue = $this->cargo->groupValue();
            $this->cargo->CssClass = "fw-bold";
            $this->cargo->CellCssClass = "ew-rpt-grp-field-5";
            $this->cargo->GroupViewValue = DisplayGroupValue($this->cargo, $this->cargo->GroupViewValue);
            if (!$this->cargo->LevelBreak) {
                $this->cargo->GroupViewValue = "";
            } else {
                $this->cargo->LevelBreak = false;
            }

            // modulo
            $curVal = strval($this->modulo->groupValue());
            if ($curVal != "") {
                $this->modulo->GroupViewValue = $this->modulo->lookupCacheOption($curVal);
                if ($this->modulo->GroupViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->modulo->Lookup->getTable()->Fields["modulo"]->searchExpression(), "=", $curVal, $this->modulo->Lookup->getTable()->Fields["modulo"]->searchDataType(), "");
                    $sqlWrk = $this->modulo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->modulo->Lookup->renderViewRow($rswrk[0]);
                        $this->modulo->GroupViewValue = $this->modulo->displayValue($arwrk);
                    } else {
                        $this->modulo->GroupViewValue = $this->modulo->groupValue();
                    }
                }
            } else {
                $this->modulo->GroupViewValue = null;
            }
            $this->modulo->CssClass = "fw-bold";
            $this->modulo->CellCssClass = "ew-rpt-grp-field-6";
            $this->modulo->GroupViewValue = DisplayGroupValue($this->modulo, $this->modulo->GroupViewValue);
            if (!$this->modulo->LevelBreak) {
                $this->modulo->GroupViewValue = "";
            } else {
                $this->modulo->LevelBreak = false;
            }

            // Increment RowCount
            if ($this->RowType == RowType::DETAIL) {
                $this->RowCount++;
            }

            // item
            $this->item->ViewValue = $this->item->CurrentValue;
            $this->item->CssClass = "fw-bold";
            $this->item->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // porcentagem
            $this->porcentagem->ViewValue = $this->porcentagem->CurrentValue;
            $this->porcentagem->ViewValue = FormatNumber($this->porcentagem->ViewValue, $this->porcentagem->formatPattern());
            $this->porcentagem->CssClass = "fw-bold";
            $this->porcentagem->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->porcentagem->CellCssStyle .= "text-align: right;";

            // valor
            $this->valor->ViewValue = $this->valor->CurrentValue;
            $this->valor->ViewValue = FormatCurrency($this->valor->ViewValue, $this->valor->formatPattern());
            $this->valor->CssClass = "fw-bold";
            $this->valor->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->valor->CellCssStyle .= "text-align: right;";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->CssClass = "fw-bold";
            $this->obs->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // idproposta
            $this->idproposta->HrefValue = "";
            $this->idproposta->TooltipValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";
            $this->dt_cadastro->TooltipValue = "";

            // cliente
            $this->cliente->HrefValue = "";
            $this->cliente->TooltipValue = "";

            // idplanilha_custo
            $this->idplanilha_custo->HrefValue = "";
            $this->idplanilha_custo->TooltipValue = "";

            // cargo
            $this->cargo->HrefValue = "";
            $this->cargo->TooltipValue = "";

            // modulo
            $this->modulo->HrefValue = "";
            $this->modulo->TooltipValue = "";

            // item
            $this->item->HrefValue = "";
            $this->item->TooltipValue = "";

            // porcentagem
            $this->porcentagem->HrefValue = "";
            $this->porcentagem->TooltipValue = "";

            // valor
            $this->valor->HrefValue = "";
            $this->valor->TooltipValue = "";

            // obs
            $this->obs->HrefValue = "";
            $this->obs->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == RowType::TOTAL) {
            // idproposta
            $currentValue = $this->idproposta->GroupViewValue;
            $viewValue = &$this->idproposta->GroupViewValue;
            $viewAttrs = &$this->idproposta->ViewAttrs;
            $cellAttrs = &$this->idproposta->CellAttrs;
            $hrefValue = &$this->idproposta->HrefValue;
            $linkAttrs = &$this->idproposta->LinkAttrs;
            $this->cellRendered($this->idproposta, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dt_cadastro
            $currentValue = $this->dt_cadastro->GroupViewValue;
            $viewValue = &$this->dt_cadastro->GroupViewValue;
            $viewAttrs = &$this->dt_cadastro->ViewAttrs;
            $cellAttrs = &$this->dt_cadastro->CellAttrs;
            $hrefValue = &$this->dt_cadastro->HrefValue;
            $linkAttrs = &$this->dt_cadastro->LinkAttrs;
            $this->cellRendered($this->dt_cadastro, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cliente
            $currentValue = $this->cliente->GroupViewValue;
            $viewValue = &$this->cliente->GroupViewValue;
            $viewAttrs = &$this->cliente->ViewAttrs;
            $cellAttrs = &$this->cliente->CellAttrs;
            $hrefValue = &$this->cliente->HrefValue;
            $linkAttrs = &$this->cliente->LinkAttrs;
            $this->cellRendered($this->cliente, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // idplanilha_custo
            $currentValue = $this->idplanilha_custo->GroupViewValue;
            $viewValue = &$this->idplanilha_custo->GroupViewValue;
            $viewAttrs = &$this->idplanilha_custo->ViewAttrs;
            $cellAttrs = &$this->idplanilha_custo->CellAttrs;
            $hrefValue = &$this->idplanilha_custo->HrefValue;
            $linkAttrs = &$this->idplanilha_custo->LinkAttrs;
            $this->cellRendered($this->idplanilha_custo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cargo
            $currentValue = $this->cargo->GroupViewValue;
            $viewValue = &$this->cargo->GroupViewValue;
            $viewAttrs = &$this->cargo->ViewAttrs;
            $cellAttrs = &$this->cargo->CellAttrs;
            $hrefValue = &$this->cargo->HrefValue;
            $linkAttrs = &$this->cargo->LinkAttrs;
            $this->cellRendered($this->cargo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // modulo
            $currentValue = $this->modulo->GroupViewValue;
            $viewValue = &$this->modulo->GroupViewValue;
            $viewAttrs = &$this->modulo->ViewAttrs;
            $cellAttrs = &$this->modulo->CellAttrs;
            $hrefValue = &$this->modulo->HrefValue;
            $linkAttrs = &$this->modulo->LinkAttrs;
            $this->cellRendered($this->modulo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // porcentagem
            $currentValue = $this->porcentagem->SumValue;
            $viewValue = &$this->porcentagem->SumViewValue;
            $viewAttrs = &$this->porcentagem->ViewAttrs;
            $cellAttrs = &$this->porcentagem->CellAttrs;
            $hrefValue = &$this->porcentagem->HrefValue;
            $linkAttrs = &$this->porcentagem->LinkAttrs;
            $this->cellRendered($this->porcentagem, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // valor
            $currentValue = $this->valor->SumValue;
            $viewValue = &$this->valor->SumViewValue;
            $viewAttrs = &$this->valor->ViewAttrs;
            $cellAttrs = &$this->valor->CellAttrs;
            $hrefValue = &$this->valor->HrefValue;
            $linkAttrs = &$this->valor->LinkAttrs;
            $this->cellRendered($this->valor, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        } else {
            // idproposta
            $currentValue = $this->idproposta->groupValue();
            $viewValue = &$this->idproposta->GroupViewValue;
            $viewAttrs = &$this->idproposta->ViewAttrs;
            $cellAttrs = &$this->idproposta->CellAttrs;
            $hrefValue = &$this->idproposta->HrefValue;
            $linkAttrs = &$this->idproposta->LinkAttrs;
            $this->cellRendered($this->idproposta, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dt_cadastro
            $currentValue = $this->dt_cadastro->groupValue();
            $viewValue = &$this->dt_cadastro->GroupViewValue;
            $viewAttrs = &$this->dt_cadastro->ViewAttrs;
            $cellAttrs = &$this->dt_cadastro->CellAttrs;
            $hrefValue = &$this->dt_cadastro->HrefValue;
            $linkAttrs = &$this->dt_cadastro->LinkAttrs;
            $this->cellRendered($this->dt_cadastro, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cliente
            $currentValue = $this->cliente->groupValue();
            $viewValue = &$this->cliente->GroupViewValue;
            $viewAttrs = &$this->cliente->ViewAttrs;
            $cellAttrs = &$this->cliente->CellAttrs;
            $hrefValue = &$this->cliente->HrefValue;
            $linkAttrs = &$this->cliente->LinkAttrs;
            $this->cellRendered($this->cliente, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // idplanilha_custo
            $currentValue = $this->idplanilha_custo->groupValue();
            $viewValue = &$this->idplanilha_custo->GroupViewValue;
            $viewAttrs = &$this->idplanilha_custo->ViewAttrs;
            $cellAttrs = &$this->idplanilha_custo->CellAttrs;
            $hrefValue = &$this->idplanilha_custo->HrefValue;
            $linkAttrs = &$this->idplanilha_custo->LinkAttrs;
            $this->cellRendered($this->idplanilha_custo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cargo
            $currentValue = $this->cargo->groupValue();
            $viewValue = &$this->cargo->GroupViewValue;
            $viewAttrs = &$this->cargo->ViewAttrs;
            $cellAttrs = &$this->cargo->CellAttrs;
            $hrefValue = &$this->cargo->HrefValue;
            $linkAttrs = &$this->cargo->LinkAttrs;
            $this->cellRendered($this->cargo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // modulo
            $currentValue = $this->modulo->groupValue();
            $viewValue = &$this->modulo->GroupViewValue;
            $viewAttrs = &$this->modulo->ViewAttrs;
            $cellAttrs = &$this->modulo->CellAttrs;
            $hrefValue = &$this->modulo->HrefValue;
            $linkAttrs = &$this->modulo->LinkAttrs;
            $this->cellRendered($this->modulo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // item
            $currentValue = $this->item->CurrentValue;
            $viewValue = &$this->item->ViewValue;
            $viewAttrs = &$this->item->ViewAttrs;
            $cellAttrs = &$this->item->CellAttrs;
            $hrefValue = &$this->item->HrefValue;
            $linkAttrs = &$this->item->LinkAttrs;
            $this->cellRendered($this->item, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // porcentagem
            $currentValue = $this->porcentagem->CurrentValue;
            $viewValue = &$this->porcentagem->ViewValue;
            $viewAttrs = &$this->porcentagem->ViewAttrs;
            $cellAttrs = &$this->porcentagem->CellAttrs;
            $hrefValue = &$this->porcentagem->HrefValue;
            $linkAttrs = &$this->porcentagem->LinkAttrs;
            $this->cellRendered($this->porcentagem, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // valor
            $currentValue = $this->valor->CurrentValue;
            $viewValue = &$this->valor->ViewValue;
            $viewAttrs = &$this->valor->ViewAttrs;
            $cellAttrs = &$this->valor->CellAttrs;
            $hrefValue = &$this->valor->HrefValue;
            $linkAttrs = &$this->valor->LinkAttrs;
            $this->cellRendered($this->valor, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // obs
            $currentValue = $this->obs->CurrentValue;
            $viewValue = &$this->obs->ViewValue;
            $viewAttrs = &$this->obs->ViewAttrs;
            $cellAttrs = &$this->obs->CellAttrs;
            $hrefValue = &$this->obs->HrefValue;
            $linkAttrs = &$this->obs->LinkAttrs;
            $this->cellRendered($this->obs, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
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
        if ($this->idproposta->Visible) {
            $this->GroupColumnCount += 1;
        }
        if ($this->dt_cadastro->Visible) {
            $this->GroupColumnCount += 1;
            $this->SubGroupColumnCount += 1;
        }
        if ($this->cliente->Visible) {
            $this->GroupColumnCount += 1;
            $this->SubGroupColumnCount += 1;
        }
        if ($this->idplanilha_custo->Visible) {
            $this->GroupColumnCount += 1;
            $this->SubGroupColumnCount += 1;
        }
        if ($this->cargo->Visible) {
            $this->GroupColumnCount += 1;
            $this->SubGroupColumnCount += 1;
        }
        if ($this->modulo->Visible) {
            $this->GroupColumnCount += 1;
            $this->SubGroupColumnCount += 1;
        }
        if ($this->item->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->porcentagem->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->valor->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->obs->Visible) {
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
            return '<button type="button" class="btn btn-default ew-export-link ew-excel" title="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-ew-action="export" data-export="excel" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToExcel") . '</button>';
        } elseif (SameText($type, "word")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-word" title="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-ew-action="export" data-export="word" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToWord") . '</button>';
        } elseif (SameText($type, "pdf")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-pdf" title="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-ew-action="export" data-export="pdf" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToPdf") . '</button>';
        } elseif (SameText($type, "html")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-html" title="' . HtmlEncode($Language->phrase("ExportToHtml", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToHtml", true)) . '" data-ew-action="export" data-export="html" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToHtml") . '</button>';
        } elseif (SameText($type, "email")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-ew-action="email" data-custom="false" data-export-selected="false" data-hdr="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = false;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = false;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
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

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"frel_planilha_custosrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        if ($this->UseCustomTemplate || !$this->UseAjaxActions) {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ResetSearch") . "\" data-caption=\"" . $Language->phrase("ResetSearch") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ResetSearchBtn") . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ResetSearch") . "\" data-caption=\"" . $Language->phrase("ResetSearch") . "\" data-ew-action=\"refresh\" data-url=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ResetSearchBtn") . "</a>";
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
        return $this->modulo->Visible || $this->item->Visible || $this->idplanilha_custo->Visible;
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
                case "x_modulo":
                    break;
                case "x_idplanilha_custo":
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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"frel_planilha_custosrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"frel_planilha_custosrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
            return "modulo ASC,item ASC";
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
            $this->idproposta->setSort("");
            $this->dt_cadastro->setSort("");
            $this->cliente->setSort("");
            $this->modulo->setSort("");
            $this->item->setSort("");
            $this->porcentagem->setSort("");
            $this->valor->setSort("");
            $this->obs->setSort("");
            $this->idplanilha_custo->setSort("");
            $this->cargo->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->idproposta, $ctrl); // idproposta
            $this->updateSort($this->dt_cadastro, $ctrl); // dt_cadastro
            $this->updateSort($this->cliente, $ctrl); // cliente
            $this->updateSort($this->modulo, $ctrl); // modulo
            $this->updateSort($this->item, $ctrl); // item
            $this->updateSort($this->porcentagem, $ctrl); // porcentagem
            $this->updateSort($this->valor, $ctrl); // valor
            $this->updateSort($this->obs, $ctrl); // obs
            $this->updateSort($this->idplanilha_custo, $ctrl); // idplanilha_custo
            $this->updateSort($this->cargo, $ctrl); // cargo
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }

        // Set up default sort
        if ($this->getOrderBy() == "") {
            $useDefaultSort = true;
            if ($useDefaultSort) {
                $this->setOrderBy("modulo ASC,item ASC");
            }
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
            $this->modulo->AdvancedSearch->unsetSession();
            $this->item->AdvancedSearch->unsetSession();
            $this->idplanilha_custo->AdvancedSearch->unsetSession();
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;

            // Field modulo
            $this->getDropDownValue($this->modulo);

            // Field item
            $this->getDropDownValue($this->item);

            // Field idplanilha_custo
            $this->getDropDownValue($this->idplanilha_custo);
            if (!$this->validateForm()) {
                return $filter;
            }
        }

        // Restore session
        if ($restoreSession) {
            $restoreDefault = true;
            if ($this->modulo->AdvancedSearch->issetSession()) { // Field modulo
                $this->modulo->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->item->AdvancedSearch->issetSession()) { // Field item
                $this->item->AdvancedSearch->load();
                $restoreDefault = false;
            }
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
        $this->buildDropDownFilter($this->modulo, $filter, false, true); // Field modulo
        $this->modulo->AdvancedSearch->save();
        $this->buildDropDownFilter($this->item, $filter, false, true); // Field item
        $this->item->AdvancedSearch->save();
        $this->buildDropDownFilter($this->idplanilha_custo, $filter, false, true); // Field idplanilha_custo
        $this->idplanilha_custo->AdvancedSearch->save();

        // Field idplanilha_custo
        LoadDropDownList($this->idplanilha_custo->EditValue, $this->idplanilha_custo->AdvancedSearch->SearchValue);
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
        // Field modulo
        $this->modulo->AdvancedSearch->loadDefault();

        // Field item
        $this->item->AdvancedSearch->loadDefault();

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

        // Field idplanilha_custo
        $extWrk = "";
        $this->buildDropDownFilter($this->idplanilha_custo, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->idplanilha_custo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Show Filters
        if ($filterList != "") {
            $message = "<div id=\"ew-filter-list\" class=\"callout callout-info d-table\"><div id=\"ew-current-filters\">" .
                $Language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
            $this->messageShowing($message, "");
            Write($message);
        } else { // Output empty tag
            Write("<div id=\"ew-filter-list\"></div>");
        }
    }

    // Get list of filters
    public function getFilterList()
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Field idplanilha_custo
        $wrk = "";
        $wrk = $this->idplanilha_custo->AdvancedSearch->SearchValue;
        if (is_array($wrk)) {
            $wrk = implode("||", $wrk);
        }
        if ($wrk != "") {
            $wrk = "\"x_idplanilha_custo\":\"" . JsEncode($wrk) . "\"";
        }
        if ($wrk != "") {
            if ($filterList != "") {
                $filterList .= ",";
            }
            $filterList .= $wrk;
        }

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

        // Field idplanilha_custo
        if (!$this->idplanilha_custo->AdvancedSearch->get($filter)) {
            $this->idplanilha_custo->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->idplanilha_custo->AdvancedSearch->save();
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
