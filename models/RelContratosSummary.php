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
class RelContratosSummary extends RelContratos
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RelContratosSummary";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $ReportContainerClass = "ew-grid";
    public $CurrentPageName = "RelContratos";

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
        $this->TableVar = 'rel_contratos';
        $this->TableName = 'rel_contratos';

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

        // Table object (rel_contratos)
        if (!isset($GLOBALS["rel_contratos"]) || $GLOBALS["rel_contratos"]::class == PROJECT_NAMESPACE . "rel_contratos") {
            $GLOBALS["rel_contratos"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'rel_contratos');
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
        $this->quantidade->setVisibility();
        $this->cargo->setVisibility();
        $this->salario->setVisibility();
        $this->acumulo_funcao->setVisibility();
        $this->escala->setVisibility();
        $this->periodo->setVisibility();
        $this->jornada->setVisibility();
        $this->intrajornada_tipo->setVisibility();

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
            $this->cliente->setGroupValue(reset($this->GroupRecords[$this->GroupCount]));
        } else {
            $this->cliente->setGroupValue("");
        }
    }

    // Load row values
    public function loadRowValues($record)
    {
        $data = [];
        $data["idcontrato"] = $record['idcontrato'];
        $data["cliente"] = $record['cliente'];
        $data["valor"] = $record['valor'];
        $data["insumos"] = $record['insumos'];
        $data["quantidade"] = $record['quantidade'];
        $data["cargo"] = $record['cargo'];
        $data["salario"] = $record['salario'];
        $data["acumulo_funcao"] = $record['acumulo_funcao'];
        $data["escala"] = $record['escala'];
        $data["periodo"] = $record['periodo'];
        $data["jornada"] = $record['jornada'];
        $data["intrajornada_tipo"] = $record['intrajornada_tipo'];
        $data["ativo"] = $record['ativo'];
        $data["cnpj"] = $record['cnpj'];
        $data["contato"] = $record['contato'];
        $data["_email"] = $record['email'];
        $data["telefone"] = $record['telefone'];
        $data["endereco"] = $record['endereco'];
        $this->Rows[] = $data;
        $this->idcontrato->setDbValue($record['idcontrato']);
        $this->cliente->setDbValue(GroupValue($this->cliente, $record['cliente']));
        $this->valor->setDbValue($record['valor']);
        $this->insumos->setDbValue($record['insumos']);
        $this->quantidade->setDbValue($record['quantidade']);
        $this->cargo->setDbValue($record['cargo']);
        $this->salario->setDbValue($record['salario']);
        $this->acumulo_funcao->setDbValue($record['acumulo_funcao']);
        $this->escala->setDbValue($record['escala']);
        $this->periodo->setDbValue($record['periodo']);
        $this->jornada->setDbValue($record['jornada']);
        $this->intrajornada_tipo->setDbValue($record['intrajornada_tipo']);
        $this->ativo->setDbValue($record['ativo']);
        $this->cnpj->setDbValue($record['cnpj']);
        $this->contato->setDbValue($record['contato']);
        $this->_email->setDbValue($record['email']);
        $this->telefone->setDbValue($record['telefone']);
        $this->endereco->setDbValue($record['endereco']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == RowType::TOTAL && $this->RowTotalSubType == RowTotal::FOOTER && $this->RowTotalType == RowSummary::PAGE) {
            // Build detail SQL
            $firstGrpFld = &$this->cliente;
            $firstGrpFld->getDistinctValues($this->GroupRecords);
            $where = DetailFilterSql($firstGrpFld, $this->getSqlFirstGroupField(), $firstGrpFld->DistinctValues, $this->Dbid);
            AddFilter($where, $this->Filter);
            $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $where, $this->Sort);
            $rs = $sql->executeQuery();
            $records = $rs?->fetchAll() ?? [];
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

        // cliente
        $this->cliente->CellCssStyle = "white-space: nowrap;";

        // valor

        // insumos

        // quantidade

        // cargo
        $this->cargo->CellCssStyle = "white-space: nowrap;";

        // salario

        // acumulo_funcao

        // escala

        // periodo

        // jornada

        // intrajornada_tipo
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

            // cargo
            $curVal = trim(strval($this->cargo->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->cargo->AdvancedSearch->ViewValue = $this->cargo->lookupCacheOption($curVal);
            } else {
                $this->cargo->AdvancedSearch->ViewValue = $this->cargo->Lookup !== null && is_array($this->cargo->lookupOptions()) && count($this->cargo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cargo->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->cargo->EditValue = array_values($this->cargo->lookupOptions());
                if ($this->cargo->AdvancedSearch->ViewValue == "") {
                    $this->cargo->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cargo->Lookup->getTable()->Fields["cargo"]->searchExpression(), "=", $this->cargo->AdvancedSearch->SearchValue, $this->cargo->Lookup->getTable()->Fields["cargo"]->searchDataType(), "");
                }
                $sqlWrk = $this->cargo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->cargo->Lookup->renderViewRow($rswrk[0]);
                    $this->cargo->AdvancedSearch->ViewValue = $this->cargo->displayValue($arwrk);
                } else {
                    $this->cargo->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->cargo->EditValue = $arwrk;
            }
            $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

            // escala
            if ($this->escala->UseFilter && !EmptyValue($this->escala->AdvancedSearch->SearchValue)) {
                if (is_array($this->escala->AdvancedSearch->SearchValue)) {
                    $this->escala->AdvancedSearch->SearchValue = implode(Config("FILTER_OPTION_SEPARATOR"), $this->escala->AdvancedSearch->SearchValue);
                }
                $this->escala->EditValue = explode(Config("FILTER_OPTION_SEPARATOR"), $this->escala->AdvancedSearch->SearchValue);
            }

            // intrajornada_tipo
            if ($this->intrajornada_tipo->UseFilter && !EmptyValue($this->intrajornada_tipo->AdvancedSearch->SearchValue)) {
                if (is_array($this->intrajornada_tipo->AdvancedSearch->SearchValue)) {
                    $this->intrajornada_tipo->AdvancedSearch->SearchValue = implode(Config("FILTER_OPTION_SEPARATOR"), $this->intrajornada_tipo->AdvancedSearch->SearchValue);
                }
                $this->intrajornada_tipo->EditValue = explode(Config("FILTER_OPTION_SEPARATOR"), $this->intrajornada_tipo->AdvancedSearch->SearchValue);
            }
        } elseif ($this->RowType == RowType::TOTAL && !($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class
            if ($this->RowTotalType == RowSummary::GROUP) {
                $this->RowAttrs["data-group"] = $this->cliente->groupValue(); // Set up group attribute
            }
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowGroupLevel >= 2) {
                $this->RowAttrs["data-group-2"] = $this->valor->groupValue(); // Set up group attribute 2
            }
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowGroupLevel >= 3) {
                $this->RowAttrs["data-group-3"] = $this->insumos->groupValue(); // Set up group attribute 3
            }

            // cliente
            $arwrk = [];
            $arwrk["lf"] = $this->cliente->CurrentValue;
            $arwrk["df"] = $this->cliente->CurrentValue;
            $arwrk = $this->cliente->Lookup->renderViewRow($arwrk, $this);
            $dispVal = $this->cliente->displayValue($arwrk);
            if ($dispVal != "") {
                $this->cliente->GroupViewValue = $dispVal;
            }
            $this->cliente->CssClass = "fw-bold";
            $this->cliente->CellCssClass = ($this->RowGroupLevel == 1 ? "ew-rpt-grp-summary-1" : "ew-rpt-grp-field-1");
            $this->cliente->GroupViewValue = DisplayGroupValue($this->cliente, $this->cliente->GroupViewValue);

            // valor
            $this->valor->GroupViewValue = $this->valor->groupValue();
            $this->valor->GroupViewValue = FormatCurrency($this->valor->GroupViewValue, $this->valor->formatPattern());
            $this->valor->CssClass = "fw-bold";
            $this->valor->CellCssClass = ($this->RowGroupLevel == 2 ? "ew-rpt-grp-summary-2" : "ew-rpt-grp-field-2");
            $this->valor->CellCssStyle .= "text-align: right;";
            $this->valor->GroupViewValue = DisplayGroupValue($this->valor, $this->valor->GroupViewValue);

            // insumos
            $this->insumos->GroupViewValue = $this->insumos->groupValue();
            $this->insumos->GroupViewValue = FormatCurrency($this->insumos->GroupViewValue, $this->insumos->formatPattern());
            $this->insumos->CssClass = "fw-bold";
            $this->insumos->CellCssClass = ($this->RowGroupLevel == 3 ? "ew-rpt-grp-summary-3" : "ew-rpt-grp-field-3");
            $this->insumos->CellCssStyle .= "text-align: right;";
            $this->insumos->GroupViewValue = DisplayGroupValue($this->insumos, $this->insumos->GroupViewValue);

            // cliente
            $this->cliente->HrefValue = "";

            // valor
            $this->valor->HrefValue = "";

            // insumos
            $this->insumos->HrefValue = "";

            // quantidade
            $this->quantidade->HrefValue = "";

            // cargo
            $this->cargo->HrefValue = "";

            // salario
            $this->salario->HrefValue = "";

            // acumulo_funcao
            $this->acumulo_funcao->HrefValue = "";

            // escala
            $this->escala->HrefValue = "";

            // periodo
            $this->periodo->HrefValue = "";

            // jornada
            $this->jornada->HrefValue = "";

            // intrajornada_tipo
            $this->intrajornada_tipo->HrefValue = "";
        } else {
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER) {
                $this->RowAttrs["data-group"] = $this->cliente->groupValue(); // Set up group attribute
                if ($this->RowGroupLevel >= 2) {
                    $this->RowAttrs["data-group-2"] = $this->valor->groupValue(); // Set up group attribute 2
                }
                if ($this->RowGroupLevel >= 3) {
                    $this->RowAttrs["data-group-3"] = $this->insumos->groupValue(); // Set up group attribute 3
                }
            } else {
                $this->RowAttrs["data-group"] = $this->cliente->groupValue(); // Set up group attribute
                $this->RowAttrs["data-group-2"] = $this->valor->groupValue(); // Set up group attribute 2
                $this->RowAttrs["data-group-3"] = $this->insumos->groupValue(); // Set up group attribute 3
            }

            // cliente
            $arwrk = [];
            $arwrk["lf"] = $this->cliente->CurrentValue;
            $arwrk["df"] = $this->cliente->CurrentValue;
            $arwrk = $this->cliente->Lookup->renderViewRow($arwrk, $this);
            $dispVal = $this->cliente->displayValue($arwrk);
            if ($dispVal != "") {
                $this->cliente->GroupViewValue = $dispVal;
            }
            $this->cliente->CssClass = "fw-bold";
            $this->cliente->CellCssClass = "ew-rpt-grp-field-1";
            $this->cliente->GroupViewValue = DisplayGroupValue($this->cliente, $this->cliente->GroupViewValue);
            if (!$this->cliente->LevelBreak) {
                $this->cliente->GroupViewValue = "";
            } else {
                $this->cliente->LevelBreak = false;
            }

            // valor
            $this->valor->GroupViewValue = $this->valor->groupValue();
            $this->valor->GroupViewValue = FormatCurrency($this->valor->GroupViewValue, $this->valor->formatPattern());
            $this->valor->CssClass = "fw-bold";
            $this->valor->CellCssClass = "ew-rpt-grp-field-2";
            $this->valor->CellCssStyle .= "text-align: right;";
            $this->valor->GroupViewValue = DisplayGroupValue($this->valor, $this->valor->GroupViewValue);
            if (!$this->valor->LevelBreak) {
                $this->valor->GroupViewValue = "";
            } else {
                $this->valor->LevelBreak = false;
            }

            // insumos
            $this->insumos->GroupViewValue = $this->insumos->groupValue();
            $this->insumos->GroupViewValue = FormatCurrency($this->insumos->GroupViewValue, $this->insumos->formatPattern());
            $this->insumos->CssClass = "fw-bold";
            $this->insumos->CellCssClass = "ew-rpt-grp-field-3";
            $this->insumos->CellCssStyle .= "text-align: right;";
            $this->insumos->GroupViewValue = DisplayGroupValue($this->insumos, $this->insumos->GroupViewValue);
            if (!$this->insumos->LevelBreak) {
                $this->insumos->GroupViewValue = "";
            } else {
                $this->insumos->LevelBreak = false;
            }

            // Increment RowCount
            if ($this->RowType == RowType::DETAIL) {
                $this->RowCount++;
            }

            // quantidade
            $this->quantidade->ViewValue = $this->quantidade->CurrentValue;
            $this->quantidade->ViewValue = FormatNumber($this->quantidade->ViewValue, $this->quantidade->formatPattern());
            $this->quantidade->CssClass = "fw-bold";
            $this->quantidade->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->quantidade->CellCssStyle .= "text-align: center;";

            // cargo
            $arwrk = [];
            $arwrk["lf"] = $this->cargo->CurrentValue;
            $arwrk["df"] = $this->cargo->CurrentValue;
            $arwrk = $this->cargo->Lookup->renderViewRow($arwrk, $this);
            $dispVal = $this->cargo->displayValue($arwrk);
            if ($dispVal != "") {
                $this->cargo->ViewValue = $dispVal;
            }
            $this->cargo->CssClass = "fw-bold";
            $this->cargo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // salario
            $this->salario->ViewValue = $this->salario->CurrentValue;
            $this->salario->ViewValue = FormatCurrency($this->salario->ViewValue, $this->salario->formatPattern());
            $this->salario->CssClass = "fw-bold";
            $this->salario->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->salario->CellCssStyle .= "text-align: right;";

            // acumulo_funcao
            if (strval($this->acumulo_funcao->CurrentValue) != "") {
                $this->acumulo_funcao->ViewValue = $this->acumulo_funcao->optionCaption($this->acumulo_funcao->CurrentValue);
            } else {
                $this->acumulo_funcao->ViewValue = null;
            }
            $this->acumulo_funcao->CssClass = "fw-bold";
            $this->acumulo_funcao->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->acumulo_funcao->CellCssStyle .= "text-align: center;";

            // escala
            $this->escala->ViewValue = $this->escala->CurrentValue;
            $this->escala->CssClass = "fw-bold";
            $this->escala->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->escala->CellCssStyle .= "text-align: center;";

            // periodo
            $this->periodo->ViewValue = $this->periodo->CurrentValue;
            $this->periodo->CssClass = "fw-bold";
            $this->periodo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->periodo->CellCssStyle .= "text-align: center;";

            // jornada
            $this->jornada->ViewValue = $this->jornada->CurrentValue;
            $this->jornada->ViewValue = FormatNumber($this->jornada->ViewValue, $this->jornada->formatPattern());
            $this->jornada->CssClass = "fw-bold";
            $this->jornada->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->jornada->CellCssStyle .= "text-align: center;";

            // intrajornada_tipo
            $this->intrajornada_tipo->ViewValue = $this->intrajornada_tipo->CurrentValue;
            $this->intrajornada_tipo->CssClass = "fw-bold";
            $this->intrajornada_tipo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // cliente
            $this->cliente->HrefValue = "";
            $this->cliente->TooltipValue = "";

            // valor
            $this->valor->HrefValue = "";
            $this->valor->TooltipValue = "";

            // insumos
            $this->insumos->HrefValue = "";
            $this->insumos->TooltipValue = "";

            // quantidade
            $this->quantidade->HrefValue = "";
            $this->quantidade->TooltipValue = "";

            // cargo
            $this->cargo->HrefValue = "";
            $this->cargo->TooltipValue = "";

            // salario
            $this->salario->HrefValue = "";
            $this->salario->TooltipValue = "";

            // acumulo_funcao
            $this->acumulo_funcao->HrefValue = "";
            $this->acumulo_funcao->TooltipValue = "";

            // escala
            $this->escala->HrefValue = "";
            $this->escala->TooltipValue = "";

            // periodo
            $this->periodo->HrefValue = "";
            $this->periodo->TooltipValue = "";

            // jornada
            $this->jornada->HrefValue = "";
            $this->jornada->TooltipValue = "";

            // intrajornada_tipo
            $this->intrajornada_tipo->HrefValue = "";
            $this->intrajornada_tipo->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == RowType::TOTAL) {
            // cliente
            $currentValue = $this->cliente->GroupViewValue;
            $viewValue = &$this->cliente->GroupViewValue;
            $viewAttrs = &$this->cliente->ViewAttrs;
            $cellAttrs = &$this->cliente->CellAttrs;
            $hrefValue = &$this->cliente->HrefValue;
            $linkAttrs = &$this->cliente->LinkAttrs;
            $this->cellRendered($this->cliente, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // valor
            $currentValue = $this->valor->GroupViewValue;
            $viewValue = &$this->valor->GroupViewValue;
            $viewAttrs = &$this->valor->ViewAttrs;
            $cellAttrs = &$this->valor->CellAttrs;
            $hrefValue = &$this->valor->HrefValue;
            $linkAttrs = &$this->valor->LinkAttrs;
            $this->cellRendered($this->valor, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // insumos
            $currentValue = $this->insumos->GroupViewValue;
            $viewValue = &$this->insumos->GroupViewValue;
            $viewAttrs = &$this->insumos->ViewAttrs;
            $cellAttrs = &$this->insumos->CellAttrs;
            $hrefValue = &$this->insumos->HrefValue;
            $linkAttrs = &$this->insumos->LinkAttrs;
            $this->cellRendered($this->insumos, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        } else {
            // cliente
            $currentValue = $this->cliente->groupValue();
            $viewValue = &$this->cliente->GroupViewValue;
            $viewAttrs = &$this->cliente->ViewAttrs;
            $cellAttrs = &$this->cliente->CellAttrs;
            $hrefValue = &$this->cliente->HrefValue;
            $linkAttrs = &$this->cliente->LinkAttrs;
            $this->cellRendered($this->cliente, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // valor
            $currentValue = $this->valor->groupValue();
            $viewValue = &$this->valor->GroupViewValue;
            $viewAttrs = &$this->valor->ViewAttrs;
            $cellAttrs = &$this->valor->CellAttrs;
            $hrefValue = &$this->valor->HrefValue;
            $linkAttrs = &$this->valor->LinkAttrs;
            $this->cellRendered($this->valor, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // insumos
            $currentValue = $this->insumos->groupValue();
            $viewValue = &$this->insumos->GroupViewValue;
            $viewAttrs = &$this->insumos->ViewAttrs;
            $cellAttrs = &$this->insumos->CellAttrs;
            $hrefValue = &$this->insumos->HrefValue;
            $linkAttrs = &$this->insumos->LinkAttrs;
            $this->cellRendered($this->insumos, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // quantidade
            $currentValue = $this->quantidade->CurrentValue;
            $viewValue = &$this->quantidade->ViewValue;
            $viewAttrs = &$this->quantidade->ViewAttrs;
            $cellAttrs = &$this->quantidade->CellAttrs;
            $hrefValue = &$this->quantidade->HrefValue;
            $linkAttrs = &$this->quantidade->LinkAttrs;
            $this->cellRendered($this->quantidade, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cargo
            $currentValue = $this->cargo->CurrentValue;
            $viewValue = &$this->cargo->ViewValue;
            $viewAttrs = &$this->cargo->ViewAttrs;
            $cellAttrs = &$this->cargo->CellAttrs;
            $hrefValue = &$this->cargo->HrefValue;
            $linkAttrs = &$this->cargo->LinkAttrs;
            $this->cellRendered($this->cargo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // salario
            $currentValue = $this->salario->CurrentValue;
            $viewValue = &$this->salario->ViewValue;
            $viewAttrs = &$this->salario->ViewAttrs;
            $cellAttrs = &$this->salario->CellAttrs;
            $hrefValue = &$this->salario->HrefValue;
            $linkAttrs = &$this->salario->LinkAttrs;
            $this->cellRendered($this->salario, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // acumulo_funcao
            $currentValue = $this->acumulo_funcao->CurrentValue;
            $viewValue = &$this->acumulo_funcao->ViewValue;
            $viewAttrs = &$this->acumulo_funcao->ViewAttrs;
            $cellAttrs = &$this->acumulo_funcao->CellAttrs;
            $hrefValue = &$this->acumulo_funcao->HrefValue;
            $linkAttrs = &$this->acumulo_funcao->LinkAttrs;
            $this->cellRendered($this->acumulo_funcao, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // escala
            $currentValue = $this->escala->CurrentValue;
            $viewValue = &$this->escala->ViewValue;
            $viewAttrs = &$this->escala->ViewAttrs;
            $cellAttrs = &$this->escala->CellAttrs;
            $hrefValue = &$this->escala->HrefValue;
            $linkAttrs = &$this->escala->LinkAttrs;
            $this->cellRendered($this->escala, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // periodo
            $currentValue = $this->periodo->CurrentValue;
            $viewValue = &$this->periodo->ViewValue;
            $viewAttrs = &$this->periodo->ViewAttrs;
            $cellAttrs = &$this->periodo->CellAttrs;
            $hrefValue = &$this->periodo->HrefValue;
            $linkAttrs = &$this->periodo->LinkAttrs;
            $this->cellRendered($this->periodo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // jornada
            $currentValue = $this->jornada->CurrentValue;
            $viewValue = &$this->jornada->ViewValue;
            $viewAttrs = &$this->jornada->ViewAttrs;
            $cellAttrs = &$this->jornada->CellAttrs;
            $hrefValue = &$this->jornada->HrefValue;
            $linkAttrs = &$this->jornada->LinkAttrs;
            $this->cellRendered($this->jornada, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // intrajornada_tipo
            $currentValue = $this->intrajornada_tipo->CurrentValue;
            $viewValue = &$this->intrajornada_tipo->ViewValue;
            $viewAttrs = &$this->intrajornada_tipo->ViewAttrs;
            $cellAttrs = &$this->intrajornada_tipo->CellAttrs;
            $hrefValue = &$this->intrajornada_tipo->HrefValue;
            $linkAttrs = &$this->intrajornada_tipo->LinkAttrs;
            $this->cellRendered($this->intrajornada_tipo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
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
        if ($this->cliente->Visible) {
            $this->GroupColumnCount += 1;
        }
        if ($this->valor->Visible) {
            $this->GroupColumnCount += 1;
            $this->SubGroupColumnCount += 1;
        }
        if ($this->insumos->Visible) {
            $this->GroupColumnCount += 1;
            $this->SubGroupColumnCount += 1;
        }
        if ($this->quantidade->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cargo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->salario->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->acumulo_funcao->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->escala->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->periodo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->jornada->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->intrajornada_tipo->Visible) {
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"frel_contratossrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
        return $this->cliente->Visible || $this->cargo->Visible || $this->escala->Visible || $this->intrajornada_tipo->Visible;
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
                case "x_cargo":
                    break;
                case "x_acumulo_funcao":
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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"frel_contratossrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"frel_contratossrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
            $this->cliente->setSort("");
            $this->valor->setSort("");
            $this->insumos->setSort("");
            $this->quantidade->setSort("");
            $this->cargo->setSort("");
            $this->salario->setSort("");
            $this->acumulo_funcao->setSort("");
            $this->escala->setSort("");
            $this->periodo->setSort("");
            $this->jornada->setSort("");
            $this->intrajornada_tipo->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->cliente, $ctrl); // cliente
            $this->updateSort($this->valor, $ctrl); // valor
            $this->updateSort($this->insumos, $ctrl); // insumos
            $this->updateSort($this->quantidade, $ctrl); // quantidade
            $this->updateSort($this->cargo, $ctrl); // cargo
            $this->updateSort($this->salario, $ctrl); // salario
            $this->updateSort($this->acumulo_funcao, $ctrl); // acumulo_funcao
            $this->updateSort($this->escala, $ctrl); // escala
            $this->updateSort($this->periodo, $ctrl); // periodo
            $this->updateSort($this->jornada, $ctrl); // jornada
            $this->updateSort($this->intrajornada_tipo, $ctrl); // intrajornada_tipo
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
            $this->cliente->AdvancedSearch->unsetSession();
            $this->cargo->AdvancedSearch->unsetSession();
            $this->escala->AdvancedSearch->unsetSession();
            $this->intrajornada_tipo->AdvancedSearch->unsetSession();
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;

            // Field cliente
            $this->getDropDownValue($this->cliente);

            // Field cargo
            $this->getDropDownValue($this->cargo);

            // Field escala
            $this->getDropDownValue($this->escala);

            // Field intrajornada_tipo
            $this->getDropDownValue($this->intrajornada_tipo);
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
            if ($this->cargo->AdvancedSearch->issetSession()) { // Field cargo
                $this->cargo->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->escala->AdvancedSearch->issetSession()) { // Field escala
                $this->escala->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->intrajornada_tipo->AdvancedSearch->issetSession()) { // Field intrajornada_tipo
                $this->intrajornada_tipo->AdvancedSearch->load();
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
        $this->buildDropDownFilter($this->cargo, $filter, false, true); // Field cargo
        $this->cargo->AdvancedSearch->save();
        $this->buildDropDownFilter($this->escala, $filter, false, true); // Field escala
        $this->escala->AdvancedSearch->save();
        $this->buildDropDownFilter($this->intrajornada_tipo, $filter, false, true); // Field intrajornada_tipo
        $this->intrajornada_tipo->AdvancedSearch->save();

        // Field cliente
        LoadDropDownList($this->cliente->EditValue, $this->cliente->AdvancedSearch->SearchValue);

        // Field cargo
        LoadDropDownList($this->cargo->EditValue, $this->cargo->AdvancedSearch->SearchValue);
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

        // Field cargo
        $this->cargo->AdvancedSearch->loadDefault();

        // Field escala
        $this->escala->AdvancedSearch->loadDefault();

        // Field intrajornada_tipo
        $this->intrajornada_tipo->AdvancedSearch->loadDefault();
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

        // Field cargo
        $extWrk = "";
        $this->buildDropDownFilter($this->cargo, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cargo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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

        // Field cargo
        $wrk = "";
        $wrk = $this->cargo->AdvancedSearch->SearchValue;
        if (is_array($wrk)) {
            $wrk = implode("||", $wrk);
        }
        if ($wrk != "") {
            $wrk = "\"x_cargo\":\"" . JsEncode($wrk) . "\"";
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

        // Field cargo
        if (!$this->cargo->AdvancedSearch->get($filter)) {
            $this->cargo->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->cargo->AdvancedSearch->save();
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
