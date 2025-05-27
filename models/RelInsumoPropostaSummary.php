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
class RelInsumoPropostaSummary extends RelInsumoProposta
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RelInsumoPropostaSummary";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $ReportContainerClass = "ew-grid";
    public $CurrentPageName = "RelInsumoProposta";

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
        $this->TableVar = 'rel_insumo_proposta';
        $this->TableName = 'rel_insumo_proposta';

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

        // Table object (rel_insumo_proposta)
        if (!isset($GLOBALS["rel_insumo_proposta"]) || $GLOBALS["rel_insumo_proposta"]::class == PROJECT_NAMESPACE . "rel_insumo_proposta") {
            $GLOBALS["rel_insumo_proposta"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'rel_insumo_proposta');
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
        $this->cliente->setVisibility();
        $this->tipo_insumo->setVisibility();
        $this->insumo->setVisibility();
        $this->qtde->setVisibility();
        $this->frequencia->setVisibility();
        $this->vr_unit->setVisibility();
        $this->anual->setVisibility();
        $this->mensal->setVisibility();

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
            $this->proposta_idproposta->setGroupValue(reset($this->GroupRecords[$this->GroupCount]));
        } else {
            $this->proposta_idproposta->setGroupValue("");
        }
    }

    // Load row values
    public function loadRowValues($record)
    {
        $data = [];
        $data["idmov_insumo_cliente"] = $record['idmov_insumo_cliente'];
        $data["proposta_idproposta"] = $record['proposta_idproposta'];
        $data["cliente"] = $record['cliente'];
        $data["insumo_idinsumo"] = $record['insumo_idinsumo'];
        $data["tipo_insumo"] = $record['tipo_insumo'];
        $data["insumo"] = $record['insumo'];
        $data["qtde"] = $record['qtde'];
        $data["frequencia"] = $record['frequencia'];
        $data["vr_unit"] = $record['vr_unit'];
        $data["anual"] = $record['anual'];
        $data["mensal"] = $record['mensal'];
        $data["idtipo_idinsumo"] = $record['idtipo_idinsumo'];
        $this->Rows[] = $data;
        $this->idmov_insumo_cliente->setDbValue($record['idmov_insumo_cliente']);
        $this->proposta_idproposta->setDbValue(GroupValue($this->proposta_idproposta, $record['proposta_idproposta']));
        $this->cliente->setDbValue($record['cliente']);
        $this->insumo_idinsumo->setDbValue($record['insumo_idinsumo']);
        $this->tipo_insumo->setDbValue($record['tipo_insumo']);
        $this->insumo->setDbValue($record['insumo']);
        $this->qtde->setDbValue($record['qtde']);
        $this->frequencia->setDbValue($record['frequencia']);
        $this->vr_unit->setDbValue($record['vr_unit']);
        $this->anual->setDbValue($record['anual']);
        $this->mensal->setDbValue($record['mensal']);
        $this->idtipo_idinsumo->setDbValue($record['idtipo_idinsumo']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == RowType::TOTAL && $this->RowTotalSubType == RowTotal::FOOTER && $this->RowTotalType == RowSummary::PAGE) {
            // Build detail SQL
            $firstGrpFld = &$this->proposta_idproposta;
            $firstGrpFld->getDistinctValues($this->GroupRecords);
            $where = DetailFilterSql($firstGrpFld, $this->getSqlFirstGroupField(), $firstGrpFld->DistinctValues, $this->Dbid);
            AddFilter($where, $this->Filter);
            $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $where, $this->Sort);
            $rs = $sql->executeQuery();
            $records = $rs?->fetchAll() ?? [];
            $this->qtde->getSum($records, false);
            $this->anual->getSum($records, false);
            $this->mensal->getSum($records, false);
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
                $this->cliente->Count = $this->TotalCount;
                $this->tipo_insumo->Count = $this->TotalCount;
                $this->insumo->Count = $this->TotalCount;
                $this->qtde->Count = $this->TotalCount;
                $this->qtde->SumValue = $rsagg["sum_qtde"];
                $this->frequencia->Count = $this->TotalCount;
                $this->vr_unit->Count = $this->TotalCount;
                $this->anual->Count = $this->TotalCount;
                $this->anual->SumValue = $rsagg["sum_anual"];
                $this->mensal->Count = $this->TotalCount;
                $this->mensal->SumValue = $rsagg["sum_mensal"];
                $hasSummary = true;
            }

            // Accumulate grand summary from detail records
            if (!$hasCount || !$hasSummary) {
                $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
                $rs = $sql->executeQuery();
                $this->DetailRecords = $rs?->fetchAll() ?? [];
                $this->qtde->getSum($this->DetailRecords, false);
                $this->anual->getSum($this->DetailRecords, false);
                $this->mensal->getSum($this->DetailRecords, false);
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // proposta_idproposta
        $this->proposta_idproposta->CellCssStyle = "white-space: nowrap;";

        // cliente
        $this->cliente->CellCssStyle = "white-space: nowrap;";

        // tipo_insumo

        // insumo

        // qtde

        // frequencia

        // vr_unit

        // anual

        // mensal
        if ($this->RowType == RowType::SEARCH) {
            // cliente
            $curVal = trim(strval($this->cliente->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->cliente->AdvancedSearch->ViewValue = $this->cliente->lookupCacheOption($curVal);
            } else {
                $this->cliente->AdvancedSearch->ViewValue = $this->cliente->Lookup !== null && is_array($this->cliente->lookupOptions()) && count($this->cliente->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cliente->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->cliente->EditValue = array_values($this->cliente->lookupOptions());
                if ($this->cliente->AdvancedSearch->ViewValue == "") {
                    $this->cliente->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cliente->Lookup->getTable()->Fields["cliente"]->searchExpression(), "=", $this->cliente->AdvancedSearch->SearchValue, $this->cliente->Lookup->getTable()->Fields["cliente"]->searchDataType(), "");
                }
                $sqlWrk = $this->cliente->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->cliente->Lookup->renderViewRow($rswrk[0]);
                    $this->cliente->AdvancedSearch->ViewValue = $this->cliente->displayValue($arwrk);
                } else {
                    $this->cliente->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->cliente->EditValue = $arwrk;
            }
            $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());

            // tipo_insumo
            $curVal = trim(strval($this->tipo_insumo->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->tipo_insumo->AdvancedSearch->ViewValue = $this->tipo_insumo->lookupCacheOption($curVal);
            } else {
                $this->tipo_insumo->AdvancedSearch->ViewValue = $this->tipo_insumo->Lookup !== null && is_array($this->tipo_insumo->lookupOptions()) && count($this->tipo_insumo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_insumo->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->tipo_insumo->EditValue = array_values($this->tipo_insumo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_insumo->Lookup->getTable()->Fields["tipo_insumo"]->searchExpression(), "=", $this->tipo_insumo->AdvancedSearch->SearchValue, $this->tipo_insumo->Lookup->getTable()->Fields["tipo_insumo"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipo_insumo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_insumo->EditValue = $arwrk;
            }
            $this->tipo_insumo->PlaceHolder = RemoveHtml($this->tipo_insumo->caption());
        } elseif ($this->RowType == RowType::TOTAL && !($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class
            if ($this->RowTotalType == RowSummary::GROUP) {
                $this->RowAttrs["data-group"] = $this->proposta_idproposta->groupValue(); // Set up group attribute
            }

            // proposta_idproposta
            $this->proposta_idproposta->GroupViewValue = $this->proposta_idproposta->groupValue();
            $this->proposta_idproposta->GroupViewValue = FormatNumber($this->proposta_idproposta->GroupViewValue, $this->proposta_idproposta->formatPattern());
            $this->proposta_idproposta->CssClass = "fw-bold";
            $this->proposta_idproposta->CellCssClass = ($this->RowGroupLevel == 1 ? "ew-rpt-grp-summary-1" : "ew-rpt-grp-field-1");
            $this->proposta_idproposta->CellCssStyle .= "text-align: center;";
            $this->proposta_idproposta->GroupViewValue = DisplayGroupValue($this->proposta_idproposta, $this->proposta_idproposta->GroupViewValue);

            // qtde
            $this->qtde->SumViewValue = $this->qtde->SumValue;
            $this->qtde->SumViewValue = FormatNumber($this->qtde->SumViewValue, $this->qtde->formatPattern());
            $this->qtde->CssClass = "fw-bold";
            $this->qtde->CellCssStyle .= "text-align: center;";
            $this->qtde->CellAttrs["class"] = ($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : "ew-rpt-grp-summary-" . $this->RowGroupLevel;

            // anual
            $this->anual->SumViewValue = $this->anual->SumValue;
            $this->anual->SumViewValue = FormatCurrency($this->anual->SumViewValue, $this->anual->formatPattern());
            $this->anual->CssClass = "fw-bold";
            $this->anual->CellCssStyle .= "text-align: right;";
            $this->anual->CellAttrs["class"] = ($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : "ew-rpt-grp-summary-" . $this->RowGroupLevel;

            // mensal
            $this->mensal->SumViewValue = $this->mensal->SumValue;
            $this->mensal->SumViewValue = FormatCurrency($this->mensal->SumViewValue, $this->mensal->formatPattern());
            $this->mensal->CssClass = "fw-bold";
            $this->mensal->CellCssStyle .= "text-align: right;";
            $this->mensal->CellAttrs["class"] = ($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : "ew-rpt-grp-summary-" . $this->RowGroupLevel;

            // proposta_idproposta
            $this->proposta_idproposta->HrefValue = "";

            // cliente
            $this->cliente->HrefValue = "";

            // tipo_insumo
            $this->tipo_insumo->HrefValue = "";

            // insumo
            $this->insumo->HrefValue = "";

            // qtde
            $this->qtde->HrefValue = "";

            // frequencia
            $this->frequencia->HrefValue = "";

            // vr_unit
            $this->vr_unit->HrefValue = "";

            // anual
            $this->anual->HrefValue = "";

            // mensal
            $this->mensal->HrefValue = "";
        } else {
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER) {
                $this->RowAttrs["data-group"] = $this->proposta_idproposta->groupValue(); // Set up group attribute
            } else {
                $this->RowAttrs["data-group"] = $this->proposta_idproposta->groupValue(); // Set up group attribute
            }

            // proposta_idproposta
            $this->proposta_idproposta->GroupViewValue = $this->proposta_idproposta->groupValue();
            $this->proposta_idproposta->GroupViewValue = FormatNumber($this->proposta_idproposta->GroupViewValue, $this->proposta_idproposta->formatPattern());
            $this->proposta_idproposta->CssClass = "fw-bold";
            $this->proposta_idproposta->CellCssClass = "ew-rpt-grp-field-1";
            $this->proposta_idproposta->CellCssStyle .= "text-align: center;";
            $this->proposta_idproposta->GroupViewValue = DisplayGroupValue($this->proposta_idproposta, $this->proposta_idproposta->GroupViewValue);
            if (!$this->proposta_idproposta->LevelBreak) {
                $this->proposta_idproposta->GroupViewValue = "";
            } else {
                $this->proposta_idproposta->LevelBreak = false;
            }

            // Increment RowCount
            if ($this->RowType == RowType::DETAIL) {
                $this->RowCount++;
            }

            // cliente
            $arwrk = [];
            $arwrk["lf"] = $this->cliente->CurrentValue;
            $arwrk["df"] = $this->cliente->CurrentValue;
            $arwrk = $this->cliente->Lookup->renderViewRow($arwrk, $this);
            $dispVal = $this->cliente->displayValue($arwrk);
            if ($dispVal != "") {
                $this->cliente->ViewValue = $dispVal;
            }
            $this->cliente->CssClass = "fw-bold";
            $this->cliente->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // tipo_insumo
            $this->tipo_insumo->ViewValue = $this->tipo_insumo->CurrentValue;
            $this->tipo_insumo->CssClass = "fw-bold";
            $this->tipo_insumo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // insumo
            $this->insumo->ViewValue = $this->insumo->CurrentValue;
            $this->insumo->CssClass = "fw-bold";
            $this->insumo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // qtde
            $this->qtde->ViewValue = $this->qtde->CurrentValue;
            $this->qtde->ViewValue = FormatNumber($this->qtde->ViewValue, $this->qtde->formatPattern());
            $this->qtde->CssClass = "fw-bold";
            $this->qtde->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->qtde->CellCssStyle .= "text-align: center;";

            // frequencia
            $this->frequencia->ViewValue = $this->frequencia->CurrentValue;
            $this->frequencia->ViewValue = FormatNumber($this->frequencia->ViewValue, $this->frequencia->formatPattern());
            $this->frequencia->CssClass = "fw-bold";
            $this->frequencia->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->frequencia->CellCssStyle .= "text-align: center;";

            // vr_unit
            $this->vr_unit->ViewValue = $this->vr_unit->CurrentValue;
            $this->vr_unit->ViewValue = FormatCurrency($this->vr_unit->ViewValue, $this->vr_unit->formatPattern());
            $this->vr_unit->CssClass = "fw-bold";
            $this->vr_unit->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->vr_unit->CellCssStyle .= "text-align: right;";

            // anual
            $this->anual->ViewValue = $this->anual->CurrentValue;
            $this->anual->ViewValue = FormatCurrency($this->anual->ViewValue, $this->anual->formatPattern());
            $this->anual->CssClass = "fw-bold";
            $this->anual->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->anual->CellCssStyle .= "text-align: right;";

            // mensal
            $this->mensal->ViewValue = $this->mensal->CurrentValue;
            $this->mensal->ViewValue = FormatCurrency($this->mensal->ViewValue, $this->mensal->formatPattern());
            $this->mensal->CssClass = "fw-bold";
            $this->mensal->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->mensal->CellCssStyle .= "text-align: right;";

            // proposta_idproposta
            $this->proposta_idproposta->HrefValue = "";
            $this->proposta_idproposta->TooltipValue = "";

            // cliente
            $this->cliente->HrefValue = "";
            $this->cliente->TooltipValue = "";

            // tipo_insumo
            $this->tipo_insumo->HrefValue = "";
            $this->tipo_insumo->TooltipValue = "";

            // insumo
            $this->insumo->HrefValue = "";
            $this->insumo->TooltipValue = "";

            // qtde
            $this->qtde->HrefValue = "";
            $this->qtde->TooltipValue = "";

            // frequencia
            $this->frequencia->HrefValue = "";
            $this->frequencia->TooltipValue = "";

            // vr_unit
            $this->vr_unit->HrefValue = "";
            $this->vr_unit->TooltipValue = "";

            // anual
            $this->anual->HrefValue = "";
            $this->anual->TooltipValue = "";

            // mensal
            $this->mensal->HrefValue = "";
            $this->mensal->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == RowType::TOTAL) {
            // proposta_idproposta
            $currentValue = $this->proposta_idproposta->GroupViewValue;
            $viewValue = &$this->proposta_idproposta->GroupViewValue;
            $viewAttrs = &$this->proposta_idproposta->ViewAttrs;
            $cellAttrs = &$this->proposta_idproposta->CellAttrs;
            $hrefValue = &$this->proposta_idproposta->HrefValue;
            $linkAttrs = &$this->proposta_idproposta->LinkAttrs;
            $this->cellRendered($this->proposta_idproposta, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // qtde
            $currentValue = $this->qtde->SumValue;
            $viewValue = &$this->qtde->SumViewValue;
            $viewAttrs = &$this->qtde->ViewAttrs;
            $cellAttrs = &$this->qtde->CellAttrs;
            $hrefValue = &$this->qtde->HrefValue;
            $linkAttrs = &$this->qtde->LinkAttrs;
            $this->cellRendered($this->qtde, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // anual
            $currentValue = $this->anual->SumValue;
            $viewValue = &$this->anual->SumViewValue;
            $viewAttrs = &$this->anual->ViewAttrs;
            $cellAttrs = &$this->anual->CellAttrs;
            $hrefValue = &$this->anual->HrefValue;
            $linkAttrs = &$this->anual->LinkAttrs;
            $this->cellRendered($this->anual, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // mensal
            $currentValue = $this->mensal->SumValue;
            $viewValue = &$this->mensal->SumViewValue;
            $viewAttrs = &$this->mensal->ViewAttrs;
            $cellAttrs = &$this->mensal->CellAttrs;
            $hrefValue = &$this->mensal->HrefValue;
            $linkAttrs = &$this->mensal->LinkAttrs;
            $this->cellRendered($this->mensal, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        } else {
            // proposta_idproposta
            $currentValue = $this->proposta_idproposta->groupValue();
            $viewValue = &$this->proposta_idproposta->GroupViewValue;
            $viewAttrs = &$this->proposta_idproposta->ViewAttrs;
            $cellAttrs = &$this->proposta_idproposta->CellAttrs;
            $hrefValue = &$this->proposta_idproposta->HrefValue;
            $linkAttrs = &$this->proposta_idproposta->LinkAttrs;
            $this->cellRendered($this->proposta_idproposta, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cliente
            $currentValue = $this->cliente->CurrentValue;
            $viewValue = &$this->cliente->ViewValue;
            $viewAttrs = &$this->cliente->ViewAttrs;
            $cellAttrs = &$this->cliente->CellAttrs;
            $hrefValue = &$this->cliente->HrefValue;
            $linkAttrs = &$this->cliente->LinkAttrs;
            $this->cellRendered($this->cliente, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // tipo_insumo
            $currentValue = $this->tipo_insumo->CurrentValue;
            $viewValue = &$this->tipo_insumo->ViewValue;
            $viewAttrs = &$this->tipo_insumo->ViewAttrs;
            $cellAttrs = &$this->tipo_insumo->CellAttrs;
            $hrefValue = &$this->tipo_insumo->HrefValue;
            $linkAttrs = &$this->tipo_insumo->LinkAttrs;
            $this->cellRendered($this->tipo_insumo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // insumo
            $currentValue = $this->insumo->CurrentValue;
            $viewValue = &$this->insumo->ViewValue;
            $viewAttrs = &$this->insumo->ViewAttrs;
            $cellAttrs = &$this->insumo->CellAttrs;
            $hrefValue = &$this->insumo->HrefValue;
            $linkAttrs = &$this->insumo->LinkAttrs;
            $this->cellRendered($this->insumo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // qtde
            $currentValue = $this->qtde->CurrentValue;
            $viewValue = &$this->qtde->ViewValue;
            $viewAttrs = &$this->qtde->ViewAttrs;
            $cellAttrs = &$this->qtde->CellAttrs;
            $hrefValue = &$this->qtde->HrefValue;
            $linkAttrs = &$this->qtde->LinkAttrs;
            $this->cellRendered($this->qtde, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // frequencia
            $currentValue = $this->frequencia->CurrentValue;
            $viewValue = &$this->frequencia->ViewValue;
            $viewAttrs = &$this->frequencia->ViewAttrs;
            $cellAttrs = &$this->frequencia->CellAttrs;
            $hrefValue = &$this->frequencia->HrefValue;
            $linkAttrs = &$this->frequencia->LinkAttrs;
            $this->cellRendered($this->frequencia, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // vr_unit
            $currentValue = $this->vr_unit->CurrentValue;
            $viewValue = &$this->vr_unit->ViewValue;
            $viewAttrs = &$this->vr_unit->ViewAttrs;
            $cellAttrs = &$this->vr_unit->CellAttrs;
            $hrefValue = &$this->vr_unit->HrefValue;
            $linkAttrs = &$this->vr_unit->LinkAttrs;
            $this->cellRendered($this->vr_unit, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // anual
            $currentValue = $this->anual->CurrentValue;
            $viewValue = &$this->anual->ViewValue;
            $viewAttrs = &$this->anual->ViewAttrs;
            $cellAttrs = &$this->anual->CellAttrs;
            $hrefValue = &$this->anual->HrefValue;
            $linkAttrs = &$this->anual->LinkAttrs;
            $this->cellRendered($this->anual, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // mensal
            $currentValue = $this->mensal->CurrentValue;
            $viewValue = &$this->mensal->ViewValue;
            $viewAttrs = &$this->mensal->ViewAttrs;
            $cellAttrs = &$this->mensal->CellAttrs;
            $hrefValue = &$this->mensal->HrefValue;
            $linkAttrs = &$this->mensal->LinkAttrs;
            $this->cellRendered($this->mensal, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
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
        if ($this->proposta_idproposta->Visible) {
            $this->GroupColumnCount += 1;
        }
        if ($this->cliente->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->tipo_insumo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->insumo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->qtde->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->frequencia->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->vr_unit->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->anual->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->mensal->Visible) {
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"frel_insumo_propostasrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

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
        return $this->cliente->Visible || $this->tipo_insumo->Visible;
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
                case "x_cliente":
                    break;
                case "x_tipo_insumo":
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"frel_insumo_propostasrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"frel_insumo_propostasrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
            return "insumo ASC";
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
            $this->cliente->setSort("");
            $this->tipo_insumo->setSort("");
            $this->insumo->setSort("");
            $this->qtde->setSort("");
            $this->frequencia->setSort("");
            $this->vr_unit->setSort("");
            $this->anual->setSort("");
            $this->mensal->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->cliente, $ctrl); // cliente
            $this->updateSort($this->tipo_insumo, $ctrl); // tipo_insumo
            $this->updateSort($this->insumo, $ctrl); // insumo
            $this->updateSort($this->qtde, $ctrl); // qtde
            $this->updateSort($this->frequencia, $ctrl); // frequencia
            $this->updateSort($this->vr_unit, $ctrl); // vr_unit
            $this->updateSort($this->anual, $ctrl); // anual
            $this->updateSort($this->mensal, $ctrl); // mensal
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }

        // Set up default sort
        if ($this->getOrderBy() == "") {
            $useDefaultSort = true;
            if ($useDefaultSort) {
                $this->setOrderBy("insumo ASC");
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
            $this->cliente->AdvancedSearch->unsetSession();
            $this->tipo_insumo->AdvancedSearch->unsetSession();
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;

            // Field cliente
            $this->getDropDownValue($this->cliente);

            // Field tipo_insumo
            $this->getDropDownValue($this->tipo_insumo);
            if (!$this->validateForm()) {
                return $filter;
            }
        }

        // Restore session
        if ($restoreSession) {
            $restoreDefault = true;
            if ($this->cliente->AdvancedSearch->issetSession()) { // Field cliente
                $this->cliente->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->tipo_insumo->AdvancedSearch->issetSession()) { // Field tipo_insumo
                $this->tipo_insumo->AdvancedSearch->load();
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
        $this->buildDropDownFilter($this->cliente, $filter, false, true); // Field cliente
        $this->cliente->AdvancedSearch->save();
        $this->buildDropDownFilter($this->tipo_insumo, $filter, false, true); // Field tipo_insumo
        $this->tipo_insumo->AdvancedSearch->save();

        // Field cliente
        LoadDropDownList($this->cliente->EditValue, $this->cliente->AdvancedSearch->SearchValue);

        // Field tipo_insumo
        LoadDropDownList($this->tipo_insumo->EditValue, $this->tipo_insumo->AdvancedSearch->SearchValue);
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
        // Field cliente
        $this->cliente->AdvancedSearch->loadDefault();

        // Field tipo_insumo
        $this->tipo_insumo->AdvancedSearch->loadDefault();
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Field cliente
        $extWrk = "";
        $this->buildDropDownFilter($this->cliente, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cliente->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field tipo_insumo
        $extWrk = "";
        $this->buildDropDownFilter($this->tipo_insumo, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tipo_insumo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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

        // Field cliente
        $wrk = "";
        $wrk = $this->cliente->AdvancedSearch->SearchValue;
        if (is_array($wrk)) {
            $wrk = implode("||", $wrk);
        }
        if ($wrk != "") {
            $wrk = "\"x_cliente\":\"" . JsEncode($wrk) . "\"";
        }
        if ($wrk != "") {
            if ($filterList != "") {
                $filterList .= ",";
            }
            $filterList .= $wrk;
        }

        // Field tipo_insumo
        $wrk = "";
        $wrk = $this->tipo_insumo->AdvancedSearch->SearchValue;
        if (is_array($wrk)) {
            $wrk = implode("||", $wrk);
        }
        if ($wrk != "") {
            $wrk = "\"x_tipo_insumo\":\"" . JsEncode($wrk) . "\"";
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

        // Field cliente
        if (!$this->cliente->AdvancedSearch->get($filter)) {
            $this->cliente->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->cliente->AdvancedSearch->save();

        // Field tipo_insumo
        if (!$this->tipo_insumo->AdvancedSearch->get($filter)) {
            $this->tipo_insumo->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->tipo_insumo->AdvancedSearch->save();
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
