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
class RelComunicadoInternoSummary extends RelComunicadoInterno
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RelComunicadoInternoSummary";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $ReportContainerClass = "ew-grid";
    public $CurrentPageName = "RelComunicadoInterno";

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
        $this->TableVar = 'rel_comunicado_interno';
        $this->TableName = 'rel_comunicado_interno';

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

        // Table object (rel_comunicado_interno)
        if (!isset($GLOBALS["rel_comunicado_interno"]) || $GLOBALS["rel_comunicado_interno"]::class == PROJECT_NAMESPACE . "rel_comunicado_interno") {
            $GLOBALS["rel_comunicado_interno"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'rel_comunicado_interno');
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
        $this->idproposta->setVisibility();
        $this->dt_proposta->setVisibility();
        $this->consultor->setVisibility();
        $this->cliente->setVisibility();
        $this->cnpj_cli->setVisibility();
        $this->end_cli->setVisibility();
        $this->nr_cli->setVisibility();
        $this->bairro_cli->setVisibility();
        $this->cep_cli->setVisibility();
        $this->cidade_cli->setVisibility();
        $this->uf_cli->setVisibility();
        $this->contato_cli->setVisibility();
        $this->email_cli->setVisibility();
        $this->tel_cli->setVisibility();
        $this->faturamento->setVisibility();
        $this->cnpj_fat->setVisibility();
        $this->end_fat->setVisibility();
        $this->bairro_fat->setVisibility();
        $this->cidae_fat->setVisibility();
        $this->uf_fat->setVisibility();
        $this->origem_fat->setVisibility();
        $this->dia_vencto_fat->setVisibility();
        $this->quantidade->setVisibility();
        $this->cargo->setVisibility();
        $this->escala->setVisibility();
        $this->periodo->setVisibility();
        $this->intrajornada_tipo->setVisibility();
        $this->acumulo_funcao->setVisibility();

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
        $data["idproposta"] = $record['idproposta'];
        $data["dt_proposta"] = $record['dt_proposta'];
        $data["consultor"] = $record['consultor'];
        $data["cliente"] = $record['cliente'];
        $data["cnpj_cli"] = $record['cnpj_cli'];
        $data["end_cli"] = $record['end_cli'];
        $data["nr_cli"] = $record['nr_cli'];
        $data["bairro_cli"] = $record['bairro_cli'];
        $data["cep_cli"] = $record['cep_cli'];
        $data["cidade_cli"] = $record['cidade_cli'];
        $data["uf_cli"] = $record['uf_cli'];
        $data["contato_cli"] = $record['contato_cli'];
        $data["email_cli"] = $record['email_cli'];
        $data["tel_cli"] = $record['tel_cli'];
        $data["faturamento"] = $record['faturamento'];
        $data["cnpj_fat"] = $record['cnpj_fat'];
        $data["end_fat"] = $record['end_fat'];
        $data["bairro_fat"] = $record['bairro_fat'];
        $data["cidae_fat"] = $record['cidae_fat'];
        $data["uf_fat"] = $record['uf_fat'];
        $data["origem_fat"] = $record['origem_fat'];
        $data["dia_vencto_fat"] = $record['dia_vencto_fat'];
        $data["quantidade"] = $record['quantidade'];
        $data["cargo"] = $record['cargo'];
        $data["escala"] = $record['escala'];
        $data["periodo"] = $record['periodo'];
        $data["intrajornada_tipo"] = $record['intrajornada_tipo'];
        $data["acumulo_funcao"] = $record['acumulo_funcao'];
        $this->Rows[] = $data;
        $this->idproposta->setDbValue($record['idproposta']);
        $this->dt_proposta->setDbValue($record['dt_proposta']);
        $this->consultor->setDbValue($record['consultor']);
        $this->cliente->setDbValue($record['cliente']);
        $this->cnpj_cli->setDbValue($record['cnpj_cli']);
        $this->end_cli->setDbValue($record['end_cli']);
        $this->nr_cli->setDbValue($record['nr_cli']);
        $this->bairro_cli->setDbValue($record['bairro_cli']);
        $this->cep_cli->setDbValue($record['cep_cli']);
        $this->cidade_cli->setDbValue($record['cidade_cli']);
        $this->uf_cli->setDbValue($record['uf_cli']);
        $this->contato_cli->setDbValue($record['contato_cli']);
        $this->email_cli->setDbValue($record['email_cli']);
        $this->tel_cli->setDbValue($record['tel_cli']);
        $this->faturamento->setDbValue($record['faturamento']);
        $this->cnpj_fat->setDbValue($record['cnpj_fat']);
        $this->end_fat->setDbValue($record['end_fat']);
        $this->bairro_fat->setDbValue($record['bairro_fat']);
        $this->cidae_fat->setDbValue($record['cidae_fat']);
        $this->uf_fat->setDbValue($record['uf_fat']);
        $this->origem_fat->setDbValue($record['origem_fat']);
        $this->dia_vencto_fat->setDbValue($record['dia_vencto_fat']);
        $this->quantidade->setDbValue($record['quantidade']);
        $this->cargo->setDbValue($record['cargo']);
        $this->escala->setDbValue($record['escala']);
        $this->periodo->setDbValue($record['periodo']);
        $this->intrajornada_tipo->setDbValue($record['intrajornada_tipo']);
        $this->acumulo_funcao->setDbValue($record['acumulo_funcao']);
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

        // idproposta

        // dt_proposta

        // consultor

        // cliente

        // cnpj_cli

        // end_cli

        // nr_cli

        // bairro_cli

        // cep_cli

        // cidade_cli

        // uf_cli

        // contato_cli

        // email_cli

        // tel_cli

        // faturamento

        // cnpj_fat

        // end_fat

        // bairro_fat

        // cidae_fat

        // uf_fat

        // origem_fat

        // dia_vencto_fat

        // quantidade

        // cargo

        // escala

        // periodo

        // intrajornada_tipo

        // acumulo_funcao
        if ($this->RowType == RowType::SEARCH) {
            // idproposta
            $this->idproposta->setupEditAttributes();
            $curVal = trim(strval($this->idproposta->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->idproposta->AdvancedSearch->ViewValue = $this->idproposta->lookupCacheOption($curVal);
            } else {
                $this->idproposta->AdvancedSearch->ViewValue = $this->idproposta->Lookup !== null && is_array($this->idproposta->lookupOptions()) && count($this->idproposta->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->idproposta->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->idproposta->EditValue = array_values($this->idproposta->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->idproposta->Lookup->getTable()->Fields["idproposta"]->searchExpression(), "=", $this->idproposta->AdvancedSearch->SearchValue, $this->idproposta->Lookup->getTable()->Fields["idproposta"]->searchDataType(), "");
                }
                $sqlWrk = $this->idproposta->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idproposta->EditValue = $arwrk;
            }
            $this->idproposta->PlaceHolder = RemoveHtml($this->idproposta->caption());
        } elseif ($this->RowType == RowType::TOTAL && !($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class

            // idproposta
            $this->idproposta->HrefValue = "";

            // dt_proposta
            $this->dt_proposta->HrefValue = "";

            // consultor
            $this->consultor->HrefValue = "";

            // cliente
            $this->cliente->HrefValue = "";

            // cnpj_cli
            $this->cnpj_cli->HrefValue = "";

            // end_cli
            $this->end_cli->HrefValue = "";

            // nr_cli
            $this->nr_cli->HrefValue = "";

            // bairro_cli
            $this->bairro_cli->HrefValue = "";

            // cep_cli
            $this->cep_cli->HrefValue = "";

            // cidade_cli
            $this->cidade_cli->HrefValue = "";

            // uf_cli
            $this->uf_cli->HrefValue = "";

            // contato_cli
            $this->contato_cli->HrefValue = "";

            // email_cli
            $this->email_cli->HrefValue = "";

            // tel_cli
            $this->tel_cli->HrefValue = "";

            // faturamento
            $this->faturamento->HrefValue = "";

            // cnpj_fat
            $this->cnpj_fat->HrefValue = "";

            // end_fat
            $this->end_fat->HrefValue = "";

            // bairro_fat
            $this->bairro_fat->HrefValue = "";

            // cidae_fat
            $this->cidae_fat->HrefValue = "";

            // uf_fat
            $this->uf_fat->HrefValue = "";

            // origem_fat
            $this->origem_fat->HrefValue = "";

            // dia_vencto_fat
            $this->dia_vencto_fat->HrefValue = "";

            // quantidade
            $this->quantidade->HrefValue = "";

            // cargo
            $this->cargo->HrefValue = "";

            // escala
            $this->escala->HrefValue = "";

            // periodo
            $this->periodo->HrefValue = "";

            // intrajornada_tipo
            $this->intrajornada_tipo->HrefValue = "";

            // acumulo_funcao
            $this->acumulo_funcao->HrefValue = "";
        } else {
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER) {
            } else {
            }

            // Increment RowCount
            if ($this->RowType == RowType::DETAIL) {
                $this->RowCount++;
            }

            // idproposta
            $arwrk = [];
            $arwrk["lf"] = $this->idproposta->CurrentValue;
            $arwrk["df"] = $this->idproposta->CurrentValue;
            $arwrk["df2"] = $this->cliente->CurrentValue;
            $arwrk = $this->idproposta->Lookup->renderViewRow($arwrk, $this);
            $dispVal = $this->idproposta->displayValue($arwrk);
            if ($dispVal != "") {
                $this->idproposta->ViewValue = $dispVal;
            }
            $this->idproposta->CssClass = "fw-bold";
            $this->idproposta->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // dt_proposta
            $this->dt_proposta->ViewValue = $this->dt_proposta->CurrentValue;
            $this->dt_proposta->ViewValue = FormatDateTime($this->dt_proposta->ViewValue, $this->dt_proposta->formatPattern());
            $this->dt_proposta->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // consultor
            $this->consultor->ViewValue = $this->consultor->CurrentValue;
            $this->consultor->ViewValue = FormatNumber($this->consultor->ViewValue, $this->consultor->formatPattern());
            $this->consultor->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // cliente
            $this->cliente->ViewValue = $this->cliente->CurrentValue;
            $this->cliente->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // cnpj_cli
            $this->cnpj_cli->ViewValue = $this->cnpj_cli->CurrentValue;
            $this->cnpj_cli->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // end_cli
            $this->end_cli->ViewValue = $this->end_cli->CurrentValue;
            $this->end_cli->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // nr_cli
            $this->nr_cli->ViewValue = $this->nr_cli->CurrentValue;
            $this->nr_cli->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // bairro_cli
            $this->bairro_cli->ViewValue = $this->bairro_cli->CurrentValue;
            $this->bairro_cli->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // cep_cli
            $this->cep_cli->ViewValue = $this->cep_cli->CurrentValue;
            $this->cep_cli->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // cidade_cli
            $this->cidade_cli->ViewValue = $this->cidade_cli->CurrentValue;
            $this->cidade_cli->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // uf_cli
            $this->uf_cli->ViewValue = $this->uf_cli->CurrentValue;
            $this->uf_cli->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // contato_cli
            $this->contato_cli->ViewValue = $this->contato_cli->CurrentValue;
            $this->contato_cli->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // email_cli
            $this->email_cli->ViewValue = $this->email_cli->CurrentValue;
            $this->email_cli->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // tel_cli
            $this->tel_cli->ViewValue = $this->tel_cli->CurrentValue;
            $this->tel_cli->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // faturamento
            $this->faturamento->ViewValue = $this->faturamento->CurrentValue;
            $this->faturamento->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // cnpj_fat
            $this->cnpj_fat->ViewValue = $this->cnpj_fat->CurrentValue;
            $this->cnpj_fat->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // end_fat
            $this->end_fat->ViewValue = $this->end_fat->CurrentValue;
            $this->end_fat->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // bairro_fat
            $this->bairro_fat->ViewValue = $this->bairro_fat->CurrentValue;
            $this->bairro_fat->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // cidae_fat
            $this->cidae_fat->ViewValue = $this->cidae_fat->CurrentValue;
            $this->cidae_fat->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // uf_fat
            $this->uf_fat->ViewValue = $this->uf_fat->CurrentValue;
            $this->uf_fat->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // origem_fat
            if (strval($this->origem_fat->CurrentValue) != "") {
                $this->origem_fat->ViewValue = $this->origem_fat->optionCaption($this->origem_fat->CurrentValue);
            } else {
                $this->origem_fat->ViewValue = null;
            }
            $this->origem_fat->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // dia_vencto_fat
            $this->dia_vencto_fat->ViewValue = $this->dia_vencto_fat->CurrentValue;
            $this->dia_vencto_fat->ViewValue = FormatNumber($this->dia_vencto_fat->ViewValue, $this->dia_vencto_fat->formatPattern());
            $this->dia_vencto_fat->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // quantidade
            $this->quantidade->ViewValue = $this->quantidade->CurrentValue;
            $this->quantidade->ViewValue = FormatNumber($this->quantidade->ViewValue, $this->quantidade->formatPattern());
            $this->quantidade->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // cargo
            $this->cargo->ViewValue = $this->cargo->CurrentValue;
            $this->cargo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // escala
            $this->escala->ViewValue = $this->escala->CurrentValue;
            $this->escala->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // periodo
            $this->periodo->ViewValue = $this->periodo->CurrentValue;
            $this->periodo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // intrajornada_tipo
            $this->intrajornada_tipo->ViewValue = $this->intrajornada_tipo->CurrentValue;
            $this->intrajornada_tipo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // acumulo_funcao
            if (strval($this->acumulo_funcao->CurrentValue) != "") {
                $this->acumulo_funcao->ViewValue = $this->acumulo_funcao->optionCaption($this->acumulo_funcao->CurrentValue);
            } else {
                $this->acumulo_funcao->ViewValue = null;
            }
            $this->acumulo_funcao->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // idproposta
            $this->idproposta->HrefValue = "";
            $this->idproposta->TooltipValue = "";

            // dt_proposta
            $this->dt_proposta->HrefValue = "";
            $this->dt_proposta->TooltipValue = "";

            // consultor
            $this->consultor->HrefValue = "";
            $this->consultor->TooltipValue = "";

            // cliente
            $this->cliente->HrefValue = "";
            $this->cliente->TooltipValue = "";

            // cnpj_cli
            $this->cnpj_cli->HrefValue = "";
            $this->cnpj_cli->TooltipValue = "";

            // end_cli
            $this->end_cli->HrefValue = "";
            $this->end_cli->TooltipValue = "";

            // nr_cli
            $this->nr_cli->HrefValue = "";
            $this->nr_cli->TooltipValue = "";

            // bairro_cli
            $this->bairro_cli->HrefValue = "";
            $this->bairro_cli->TooltipValue = "";

            // cep_cli
            $this->cep_cli->HrefValue = "";
            $this->cep_cli->TooltipValue = "";

            // cidade_cli
            $this->cidade_cli->HrefValue = "";
            $this->cidade_cli->TooltipValue = "";

            // uf_cli
            $this->uf_cli->HrefValue = "";
            $this->uf_cli->TooltipValue = "";

            // contato_cli
            $this->contato_cli->HrefValue = "";
            $this->contato_cli->TooltipValue = "";

            // email_cli
            $this->email_cli->HrefValue = "";
            $this->email_cli->TooltipValue = "";

            // tel_cli
            $this->tel_cli->HrefValue = "";
            $this->tel_cli->TooltipValue = "";

            // faturamento
            $this->faturamento->HrefValue = "";
            $this->faturamento->TooltipValue = "";

            // cnpj_fat
            $this->cnpj_fat->HrefValue = "";
            $this->cnpj_fat->TooltipValue = "";

            // end_fat
            $this->end_fat->HrefValue = "";
            $this->end_fat->TooltipValue = "";

            // bairro_fat
            $this->bairro_fat->HrefValue = "";
            $this->bairro_fat->TooltipValue = "";

            // cidae_fat
            $this->cidae_fat->HrefValue = "";
            $this->cidae_fat->TooltipValue = "";

            // uf_fat
            $this->uf_fat->HrefValue = "";
            $this->uf_fat->TooltipValue = "";

            // origem_fat
            $this->origem_fat->HrefValue = "";
            $this->origem_fat->TooltipValue = "";

            // dia_vencto_fat
            $this->dia_vencto_fat->HrefValue = "";
            $this->dia_vencto_fat->TooltipValue = "";

            // quantidade
            $this->quantidade->HrefValue = "";
            $this->quantidade->TooltipValue = "";

            // cargo
            $this->cargo->HrefValue = "";
            $this->cargo->TooltipValue = "";

            // escala
            $this->escala->HrefValue = "";
            $this->escala->TooltipValue = "";

            // periodo
            $this->periodo->HrefValue = "";
            $this->periodo->TooltipValue = "";

            // intrajornada_tipo
            $this->intrajornada_tipo->HrefValue = "";
            $this->intrajornada_tipo->TooltipValue = "";

            // acumulo_funcao
            $this->acumulo_funcao->HrefValue = "";
            $this->acumulo_funcao->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == RowType::TOTAL) { // Summary row
        } else {
            // idproposta
            $currentValue = $this->idproposta->CurrentValue;
            $viewValue = &$this->idproposta->ViewValue;
            $viewAttrs = &$this->idproposta->ViewAttrs;
            $cellAttrs = &$this->idproposta->CellAttrs;
            $hrefValue = &$this->idproposta->HrefValue;
            $linkAttrs = &$this->idproposta->LinkAttrs;
            $this->cellRendered($this->idproposta, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dt_proposta
            $currentValue = $this->dt_proposta->CurrentValue;
            $viewValue = &$this->dt_proposta->ViewValue;
            $viewAttrs = &$this->dt_proposta->ViewAttrs;
            $cellAttrs = &$this->dt_proposta->CellAttrs;
            $hrefValue = &$this->dt_proposta->HrefValue;
            $linkAttrs = &$this->dt_proposta->LinkAttrs;
            $this->cellRendered($this->dt_proposta, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // consultor
            $currentValue = $this->consultor->CurrentValue;
            $viewValue = &$this->consultor->ViewValue;
            $viewAttrs = &$this->consultor->ViewAttrs;
            $cellAttrs = &$this->consultor->CellAttrs;
            $hrefValue = &$this->consultor->HrefValue;
            $linkAttrs = &$this->consultor->LinkAttrs;
            $this->cellRendered($this->consultor, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cliente
            $currentValue = $this->cliente->CurrentValue;
            $viewValue = &$this->cliente->ViewValue;
            $viewAttrs = &$this->cliente->ViewAttrs;
            $cellAttrs = &$this->cliente->CellAttrs;
            $hrefValue = &$this->cliente->HrefValue;
            $linkAttrs = &$this->cliente->LinkAttrs;
            $this->cellRendered($this->cliente, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cnpj_cli
            $currentValue = $this->cnpj_cli->CurrentValue;
            $viewValue = &$this->cnpj_cli->ViewValue;
            $viewAttrs = &$this->cnpj_cli->ViewAttrs;
            $cellAttrs = &$this->cnpj_cli->CellAttrs;
            $hrefValue = &$this->cnpj_cli->HrefValue;
            $linkAttrs = &$this->cnpj_cli->LinkAttrs;
            $this->cellRendered($this->cnpj_cli, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // end_cli
            $currentValue = $this->end_cli->CurrentValue;
            $viewValue = &$this->end_cli->ViewValue;
            $viewAttrs = &$this->end_cli->ViewAttrs;
            $cellAttrs = &$this->end_cli->CellAttrs;
            $hrefValue = &$this->end_cli->HrefValue;
            $linkAttrs = &$this->end_cli->LinkAttrs;
            $this->cellRendered($this->end_cli, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // nr_cli
            $currentValue = $this->nr_cli->CurrentValue;
            $viewValue = &$this->nr_cli->ViewValue;
            $viewAttrs = &$this->nr_cli->ViewAttrs;
            $cellAttrs = &$this->nr_cli->CellAttrs;
            $hrefValue = &$this->nr_cli->HrefValue;
            $linkAttrs = &$this->nr_cli->LinkAttrs;
            $this->cellRendered($this->nr_cli, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // bairro_cli
            $currentValue = $this->bairro_cli->CurrentValue;
            $viewValue = &$this->bairro_cli->ViewValue;
            $viewAttrs = &$this->bairro_cli->ViewAttrs;
            $cellAttrs = &$this->bairro_cli->CellAttrs;
            $hrefValue = &$this->bairro_cli->HrefValue;
            $linkAttrs = &$this->bairro_cli->LinkAttrs;
            $this->cellRendered($this->bairro_cli, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cep_cli
            $currentValue = $this->cep_cli->CurrentValue;
            $viewValue = &$this->cep_cli->ViewValue;
            $viewAttrs = &$this->cep_cli->ViewAttrs;
            $cellAttrs = &$this->cep_cli->CellAttrs;
            $hrefValue = &$this->cep_cli->HrefValue;
            $linkAttrs = &$this->cep_cli->LinkAttrs;
            $this->cellRendered($this->cep_cli, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cidade_cli
            $currentValue = $this->cidade_cli->CurrentValue;
            $viewValue = &$this->cidade_cli->ViewValue;
            $viewAttrs = &$this->cidade_cli->ViewAttrs;
            $cellAttrs = &$this->cidade_cli->CellAttrs;
            $hrefValue = &$this->cidade_cli->HrefValue;
            $linkAttrs = &$this->cidade_cli->LinkAttrs;
            $this->cellRendered($this->cidade_cli, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // uf_cli
            $currentValue = $this->uf_cli->CurrentValue;
            $viewValue = &$this->uf_cli->ViewValue;
            $viewAttrs = &$this->uf_cli->ViewAttrs;
            $cellAttrs = &$this->uf_cli->CellAttrs;
            $hrefValue = &$this->uf_cli->HrefValue;
            $linkAttrs = &$this->uf_cli->LinkAttrs;
            $this->cellRendered($this->uf_cli, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // contato_cli
            $currentValue = $this->contato_cli->CurrentValue;
            $viewValue = &$this->contato_cli->ViewValue;
            $viewAttrs = &$this->contato_cli->ViewAttrs;
            $cellAttrs = &$this->contato_cli->CellAttrs;
            $hrefValue = &$this->contato_cli->HrefValue;
            $linkAttrs = &$this->contato_cli->LinkAttrs;
            $this->cellRendered($this->contato_cli, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // email_cli
            $currentValue = $this->email_cli->CurrentValue;
            $viewValue = &$this->email_cli->ViewValue;
            $viewAttrs = &$this->email_cli->ViewAttrs;
            $cellAttrs = &$this->email_cli->CellAttrs;
            $hrefValue = &$this->email_cli->HrefValue;
            $linkAttrs = &$this->email_cli->LinkAttrs;
            $this->cellRendered($this->email_cli, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // tel_cli
            $currentValue = $this->tel_cli->CurrentValue;
            $viewValue = &$this->tel_cli->ViewValue;
            $viewAttrs = &$this->tel_cli->ViewAttrs;
            $cellAttrs = &$this->tel_cli->CellAttrs;
            $hrefValue = &$this->tel_cli->HrefValue;
            $linkAttrs = &$this->tel_cli->LinkAttrs;
            $this->cellRendered($this->tel_cli, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // faturamento
            $currentValue = $this->faturamento->CurrentValue;
            $viewValue = &$this->faturamento->ViewValue;
            $viewAttrs = &$this->faturamento->ViewAttrs;
            $cellAttrs = &$this->faturamento->CellAttrs;
            $hrefValue = &$this->faturamento->HrefValue;
            $linkAttrs = &$this->faturamento->LinkAttrs;
            $this->cellRendered($this->faturamento, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cnpj_fat
            $currentValue = $this->cnpj_fat->CurrentValue;
            $viewValue = &$this->cnpj_fat->ViewValue;
            $viewAttrs = &$this->cnpj_fat->ViewAttrs;
            $cellAttrs = &$this->cnpj_fat->CellAttrs;
            $hrefValue = &$this->cnpj_fat->HrefValue;
            $linkAttrs = &$this->cnpj_fat->LinkAttrs;
            $this->cellRendered($this->cnpj_fat, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // end_fat
            $currentValue = $this->end_fat->CurrentValue;
            $viewValue = &$this->end_fat->ViewValue;
            $viewAttrs = &$this->end_fat->ViewAttrs;
            $cellAttrs = &$this->end_fat->CellAttrs;
            $hrefValue = &$this->end_fat->HrefValue;
            $linkAttrs = &$this->end_fat->LinkAttrs;
            $this->cellRendered($this->end_fat, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // bairro_fat
            $currentValue = $this->bairro_fat->CurrentValue;
            $viewValue = &$this->bairro_fat->ViewValue;
            $viewAttrs = &$this->bairro_fat->ViewAttrs;
            $cellAttrs = &$this->bairro_fat->CellAttrs;
            $hrefValue = &$this->bairro_fat->HrefValue;
            $linkAttrs = &$this->bairro_fat->LinkAttrs;
            $this->cellRendered($this->bairro_fat, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cidae_fat
            $currentValue = $this->cidae_fat->CurrentValue;
            $viewValue = &$this->cidae_fat->ViewValue;
            $viewAttrs = &$this->cidae_fat->ViewAttrs;
            $cellAttrs = &$this->cidae_fat->CellAttrs;
            $hrefValue = &$this->cidae_fat->HrefValue;
            $linkAttrs = &$this->cidae_fat->LinkAttrs;
            $this->cellRendered($this->cidae_fat, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // uf_fat
            $currentValue = $this->uf_fat->CurrentValue;
            $viewValue = &$this->uf_fat->ViewValue;
            $viewAttrs = &$this->uf_fat->ViewAttrs;
            $cellAttrs = &$this->uf_fat->CellAttrs;
            $hrefValue = &$this->uf_fat->HrefValue;
            $linkAttrs = &$this->uf_fat->LinkAttrs;
            $this->cellRendered($this->uf_fat, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // origem_fat
            $currentValue = $this->origem_fat->CurrentValue;
            $viewValue = &$this->origem_fat->ViewValue;
            $viewAttrs = &$this->origem_fat->ViewAttrs;
            $cellAttrs = &$this->origem_fat->CellAttrs;
            $hrefValue = &$this->origem_fat->HrefValue;
            $linkAttrs = &$this->origem_fat->LinkAttrs;
            $this->cellRendered($this->origem_fat, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dia_vencto_fat
            $currentValue = $this->dia_vencto_fat->CurrentValue;
            $viewValue = &$this->dia_vencto_fat->ViewValue;
            $viewAttrs = &$this->dia_vencto_fat->ViewAttrs;
            $cellAttrs = &$this->dia_vencto_fat->CellAttrs;
            $hrefValue = &$this->dia_vencto_fat->HrefValue;
            $linkAttrs = &$this->dia_vencto_fat->LinkAttrs;
            $this->cellRendered($this->dia_vencto_fat, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

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

            // intrajornada_tipo
            $currentValue = $this->intrajornada_tipo->CurrentValue;
            $viewValue = &$this->intrajornada_tipo->ViewValue;
            $viewAttrs = &$this->intrajornada_tipo->ViewAttrs;
            $cellAttrs = &$this->intrajornada_tipo->CellAttrs;
            $hrefValue = &$this->intrajornada_tipo->HrefValue;
            $linkAttrs = &$this->intrajornada_tipo->LinkAttrs;
            $this->cellRendered($this->intrajornada_tipo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // acumulo_funcao
            $currentValue = $this->acumulo_funcao->CurrentValue;
            $viewValue = &$this->acumulo_funcao->ViewValue;
            $viewAttrs = &$this->acumulo_funcao->ViewAttrs;
            $cellAttrs = &$this->acumulo_funcao->CellAttrs;
            $hrefValue = &$this->acumulo_funcao->HrefValue;
            $linkAttrs = &$this->acumulo_funcao->LinkAttrs;
            $this->cellRendered($this->acumulo_funcao, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
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
            $this->DetailColumnCount += 1;
        }
        if ($this->dt_proposta->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->consultor->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cliente->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cnpj_cli->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->end_cli->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->nr_cli->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->bairro_cli->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cep_cli->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cidade_cli->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->uf_cli->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->contato_cli->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->email_cli->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->tel_cli->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->faturamento->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cnpj_fat->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->end_fat->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->bairro_fat->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cidae_fat->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->uf_fat->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->origem_fat->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->dia_vencto_fat->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->quantidade->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cargo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->escala->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->periodo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->intrajornada_tipo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->acumulo_funcao->Visible) {
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"frel_comunicado_internosrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
        return $this->idproposta->Visible;
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
                case "x_idproposta":
                    break;
                case "x_origem_fat":
                    break;
                case "x_acumulo_funcao":
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"frel_comunicado_internosrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"frel_comunicado_internosrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
            $this->idproposta->setSort("");
            $this->dt_proposta->setSort("");
            $this->consultor->setSort("");
            $this->cliente->setSort("");
            $this->cnpj_cli->setSort("");
            $this->end_cli->setSort("");
            $this->nr_cli->setSort("");
            $this->bairro_cli->setSort("");
            $this->cep_cli->setSort("");
            $this->cidade_cli->setSort("");
            $this->uf_cli->setSort("");
            $this->contato_cli->setSort("");
            $this->email_cli->setSort("");
            $this->tel_cli->setSort("");
            $this->faturamento->setSort("");
            $this->cnpj_fat->setSort("");
            $this->end_fat->setSort("");
            $this->bairro_fat->setSort("");
            $this->cidae_fat->setSort("");
            $this->uf_fat->setSort("");
            $this->origem_fat->setSort("");
            $this->dia_vencto_fat->setSort("");
            $this->quantidade->setSort("");
            $this->cargo->setSort("");
            $this->escala->setSort("");
            $this->periodo->setSort("");
            $this->intrajornada_tipo->setSort("");
            $this->acumulo_funcao->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->idproposta, $ctrl); // idproposta
            $this->updateSort($this->dt_proposta, $ctrl); // dt_proposta
            $this->updateSort($this->consultor, $ctrl); // consultor
            $this->updateSort($this->cliente, $ctrl); // cliente
            $this->updateSort($this->cnpj_cli, $ctrl); // cnpj_cli
            $this->updateSort($this->end_cli, $ctrl); // end_cli
            $this->updateSort($this->nr_cli, $ctrl); // nr_cli
            $this->updateSort($this->bairro_cli, $ctrl); // bairro_cli
            $this->updateSort($this->cep_cli, $ctrl); // cep_cli
            $this->updateSort($this->cidade_cli, $ctrl); // cidade_cli
            $this->updateSort($this->uf_cli, $ctrl); // uf_cli
            $this->updateSort($this->contato_cli, $ctrl); // contato_cli
            $this->updateSort($this->email_cli, $ctrl); // email_cli
            $this->updateSort($this->tel_cli, $ctrl); // tel_cli
            $this->updateSort($this->faturamento, $ctrl); // faturamento
            $this->updateSort($this->cnpj_fat, $ctrl); // cnpj_fat
            $this->updateSort($this->end_fat, $ctrl); // end_fat
            $this->updateSort($this->bairro_fat, $ctrl); // bairro_fat
            $this->updateSort($this->cidae_fat, $ctrl); // cidae_fat
            $this->updateSort($this->uf_fat, $ctrl); // uf_fat
            $this->updateSort($this->origem_fat, $ctrl); // origem_fat
            $this->updateSort($this->dia_vencto_fat, $ctrl); // dia_vencto_fat
            $this->updateSort($this->quantidade, $ctrl); // quantidade
            $this->updateSort($this->cargo, $ctrl); // cargo
            $this->updateSort($this->escala, $ctrl); // escala
            $this->updateSort($this->periodo, $ctrl); // periodo
            $this->updateSort($this->intrajornada_tipo, $ctrl); // intrajornada_tipo
            $this->updateSort($this->acumulo_funcao, $ctrl); // acumulo_funcao
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
            $this->idproposta->AdvancedSearch->unsetSession();
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;

            // Field idproposta
            $this->getDropDownValue($this->idproposta);
            if (!$this->validateForm()) {
                return $filter;
            }
        }

        // Restore session
        if ($restoreSession) {
            $restoreDefault = true;
            if ($this->idproposta->AdvancedSearch->issetSession()) { // Field idproposta
                $this->idproposta->AdvancedSearch->load();
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
        $this->buildDropDownFilter($this->idproposta, $filter, false, true); // Field idproposta
        $this->idproposta->AdvancedSearch->save();

        // Field idproposta
        LoadDropDownList($this->idproposta->EditValue, $this->idproposta->AdvancedSearch->SearchValue);
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
        // Field idproposta
        $this->idproposta->AdvancedSearch->loadDefault();
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Field idproposta
        $extWrk = "";
        $this->buildDropDownFilter($this->idproposta, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->idproposta->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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

        // Field idproposta
        $wrk = "";
        $wrk = $this->idproposta->AdvancedSearch->SearchValue;
        if (is_array($wrk)) {
            $wrk = implode("||", $wrk);
        }
        if ($wrk != "") {
            $wrk = "\"x_idproposta\":\"" . JsEncode($wrk) . "\"";
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

        // Field idproposta
        if (!$this->idproposta->AdvancedSearch->get($filter)) {
            $this->idproposta->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->idproposta->AdvancedSearch->save();
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
