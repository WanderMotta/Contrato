<?php

namespace PHPMaker2024\contratos;

// Page object
$RelPlanilhaCustoSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_planilha_custo: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<a id="top"></a>
<!-- Content Container -->
<div id="ew-report" class="ew-report container-fluid">
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
    $Page->FilterOptions->render("body");
}
?>
</div>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<form name="frel_planilha_custosrch" id="frel_planilha_custosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_planilha_custosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_planilha_custo: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_planilha_custosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_planilha_custosrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idplanilha_custo", [], fields.idplanilha_custo.isInvalid]
        ])
        // Validate form
        .setValidate(
            async function () {
                if (!this.validateRequired)
                    return true; // Ignore validation
                let fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
                return true;
            }
        )

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code in JAVASCRIPT here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "modulo": <?= $Page->modulo->toClientList($Page) ?>,
            "item": <?= $Page->item->toClientList($Page) ?>,
            "idplanilha_custo": <?= $Page->idplanilha_custo->toClientList($Page) ?>,
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = RowType::SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->modulo->Visible) { // modulo ?>
<?php
if (!$Page->modulo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_modulo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->modulo->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_modulo"
            name="x_modulo[]"
            class="form-control ew-select<?= $Page->modulo->isInvalidClass() ?>"
            data-select2-id="frel_planilha_custosrch_x_modulo"
            data-table="rel_planilha_custo"
            data-field="x_modulo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->modulo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->modulo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->modulo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->modulo->editAttributes() ?>>
            <?= $Page->modulo->selectOptionListHtml("x_modulo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->modulo->getErrorMessage() ?></div>
        <?= $Page->modulo->Lookup->getParamTag($Page, "p_x_modulo") ?>
        <script>
        loadjs.ready("frel_planilha_custosrch", function() {
            var options = {
                name: "x_modulo",
                selectId: "frel_planilha_custosrch_x_modulo",
                ajax: { id: "x_modulo", form: "frel_planilha_custosrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_planilha_custo.fields.modulo.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->item->Visible) { // item ?>
<?php
if (!$Page->item->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_item" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->item->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_item"
            name="x_item[]"
            class="form-control ew-select<?= $Page->item->isInvalidClass() ?>"
            data-select2-id="frel_planilha_custosrch_x_item"
            data-table="rel_planilha_custo"
            data-field="x_item"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->item->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->item->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->item->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->item->editAttributes() ?>>
            <?= $Page->item->selectOptionListHtml("x_item", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->item->getErrorMessage() ?></div>
        <script>
        loadjs.ready("frel_planilha_custosrch", function() {
            var options = {
                name: "x_item",
                selectId: "frel_planilha_custosrch_x_item",
                ajax: { id: "x_item", form: "frel_planilha_custosrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_planilha_custo.fields.item.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
<?php
if (!$Page->idplanilha_custo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_idplanilha_custo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->idplanilha_custo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_idplanilha_custo" class="ew-search-caption ew-label"><?= $Page->idplanilha_custo->caption() ?></label>
        </div>
        <div id="el_rel_planilha_custo_idplanilha_custo" class="ew-search-field">
    <select
        id="x_idplanilha_custo"
        name="x_idplanilha_custo"
        class="form-control ew-select<?= $Page->idplanilha_custo->isInvalidClass() ?>"
        data-select2-id="frel_planilha_custosrch_x_idplanilha_custo"
        data-table="rel_planilha_custo"
        data-field="x_idplanilha_custo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->idplanilha_custo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->idplanilha_custo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idplanilha_custo->getPlaceHolder()) ?>"
        <?= $Page->idplanilha_custo->editAttributes() ?>>
        <?= $Page->idplanilha_custo->selectOptionListHtml("x_idplanilha_custo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->idplanilha_custo->getErrorMessage() ?></div>
<?= $Page->idplanilha_custo->Lookup->getParamTag($Page, "p_x_idplanilha_custo") ?>
<script>
loadjs.ready("frel_planilha_custosrch", function() {
    var options = { name: "x_idplanilha_custo", selectId: "frel_planilha_custosrch_x_idplanilha_custo" };
    if (frel_planilha_custosrch.lists.idplanilha_custo?.lookupOptions.length) {
        options.data = { id: "x_idplanilha_custo", form: "frel_planilha_custosrch" };
    } else {
        options.ajax = { id: "x_idplanilha_custo", form: "frel_planilha_custosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_planilha_custo.fields.idplanilha_custo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->ShowReport) { ?>
<!-- Summary report (begin) -->
<main class="report-summary<?= ($Page->TotalGroups == 0) ? " ew-no-record" : "" ?>">
<?php
while ($Page->GroupCount <= count($Page->GroupRecords) && $Page->GroupCount <= $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<?php if ($Page->GroupCount > 1) { ?>
</tbody>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if ($Page->TotalGroups > 0) { ?>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?= $Page->PageBreakHtml ?>
<?php } ?>
<div class="<?= $Page->ReportContainerClass ?>">
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Top pager -->
<div class="card-header ew-grid-upper-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_rel_planilha_custo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->idproposta->Visible) { ?>
    <?php if ($Page->idproposta->ShowGroupHeaderAsRow) { ?>
    <th data-name="idproposta"<?= $Page->idproposta->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->idproposta->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="idproposta" class="<?= $Page->idproposta->headerCellClass() ?>"><div class="rel_planilha_custo_idproposta"><?= $Page->renderFieldHeader($Page->idproposta) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
    <?php if ($Page->dt_cadastro->ShowGroupHeaderAsRow) { ?>
    <th data-name="dt_cadastro">&nbsp;</th>
    <?php } else { ?>
    <th data-name="dt_cadastro" class="<?= $Page->dt_cadastro->headerCellClass() ?>"><div class="rel_planilha_custo_dt_cadastro"><?= $Page->renderFieldHeader($Page->dt_cadastro) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
    <?php if ($Page->cliente->ShowGroupHeaderAsRow) { ?>
    <th data-name="cliente">&nbsp;</th>
    <?php } else { ?>
    <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div class="rel_planilha_custo_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
    <?php if ($Page->idplanilha_custo->ShowGroupHeaderAsRow) { ?>
    <th data-name="idplanilha_custo">&nbsp;</th>
    <?php } else { ?>
    <th data-name="idplanilha_custo" class="<?= $Page->idplanilha_custo->headerCellClass() ?>"><div class="rel_planilha_custo_idplanilha_custo"><?= $Page->renderFieldHeader($Page->idplanilha_custo) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <?php if ($Page->cargo->ShowGroupHeaderAsRow) { ?>
    <th data-name="cargo">&nbsp;</th>
    <?php } else { ?>
    <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div class="rel_planilha_custo_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->modulo->Visible) { ?>
    <?php if ($Page->modulo->ShowGroupHeaderAsRow) { ?>
    <th data-name="modulo">&nbsp;</th>
    <?php } else { ?>
    <th data-name="modulo" class="<?= $Page->modulo->headerCellClass() ?>"><div class="rel_planilha_custo_modulo"><?= $Page->renderFieldHeader($Page->modulo) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->item->Visible) { ?>
    <th data-name="item" class="<?= $Page->item->headerCellClass() ?>"><div class="rel_planilha_custo_item"><?= $Page->renderFieldHeader($Page->item) ?></div></th>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { ?>
    <th data-name="porcentagem" class="<?= $Page->porcentagem->headerCellClass() ?>"><div class="rel_planilha_custo_porcentagem"><?= $Page->renderFieldHeader($Page->porcentagem) ?></div></th>
<?php } ?>
<?php if ($Page->valor->Visible) { ?>
    <th data-name="valor" class="<?= $Page->valor->headerCellClass() ?>"><div class="rel_planilha_custo_valor"><?= $Page->renderFieldHeader($Page->valor) ?></div></th>
<?php } ?>
<?php if ($Page->obs->Visible) { ?>
    <th data-name="obs" class="<?= $Page->obs->headerCellClass() ?>"><div class="rel_planilha_custo_obs"><?= $Page->renderFieldHeader($Page->obs) ?></div></th>
<?php } ?>
    </tr>
</thead>
<tbody>
<?php
        if ($Page->TotalGroups == 0) {
            break; // Show header only
        }
        $Page->ShowHeader = false;
    } // End show header
?>
<?php

    // Build detail SQL
    $where = DetailFilterSql($Page->idproposta, $Page->getSqlFirstGroupField(), $Page->idproposta->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->idproposta->Records = &$Page->DetailRecords;
    $Page->idproposta->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->idproposta->getCnt($Page->idproposta->Records); // Get record count
?>
<?php if ($Page->idproposta->Visible && $Page->idproposta->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 1;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->idproposta->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="idproposta" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->idproposta->cellAttributes() ?>>
            <span class="ew-summary-caption rel_planilha_custo_idproposta"><?= $Page->renderFieldHeader($Page->idproposta) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->idproposta->viewAttributes() ?>><?= $Page->idproposta->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->idproposta->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->dt_cadastro->getDistinctValues($Page->idproposta->Records, $Page->dt_cadastro->getSort());
    $Page->setGroupCount(count($Page->dt_cadastro->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->dt_cadastro->DistinctValues as $dt_cadastro) { // Load records for this distinct value
        $Page->dt_cadastro->setGroupValue($dt_cadastro); // Set group value
        $Page->dt_cadastro->getDistinctRecords($Page->idproposta->Records, $Page->dt_cadastro->groupValue());
        $Page->dt_cadastro->LevelBreak = true; // Set field level break
        $Page->GroupCounter[2]++;
        $Page->dt_cadastro->getCnt($Page->dt_cadastro->Records); // Get record count
?>
<?php if ($Page->dt_cadastro->Visible && $Page->dt_cadastro->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->dt_cadastro->setDbValue($dt_cadastro); // Set current value for dt_cadastro
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 2;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->dt_cadastro->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="dt_cadastro" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->dt_cadastro->cellAttributes() ?>>
            <span class="ew-summary-caption rel_planilha_custo_dt_cadastro"><?= $Page->renderFieldHeader($Page->dt_cadastro) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->dt_cadastro->viewAttributes() ?>><?= $Page->dt_cadastro->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->dt_cadastro->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->cliente->getDistinctValues($Page->dt_cadastro->Records, $Page->cliente->getSort());
    $Page->setGroupCount(count($Page->cliente->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2]);
    $Page->GroupCounter[3] = 0; // Init group count index
    foreach ($Page->cliente->DistinctValues as $cliente) { // Load records for this distinct value
        $Page->cliente->setGroupValue($cliente); // Set group value
        $Page->cliente->getDistinctRecords($Page->dt_cadastro->Records, $Page->cliente->groupValue());
        $Page->cliente->LevelBreak = true; // Set field level break
        $Page->GroupCounter[3]++;
        $Page->cliente->getCnt($Page->cliente->Records); // Get record count
?>
<?php if ($Page->cliente->Visible && $Page->cliente->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->cliente->setDbValue($cliente); // Set current value for cliente
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 3;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->cliente->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="cliente" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 3) ?>"<?= $Page->cliente->cellAttributes() ?>>
            <span class="ew-summary-caption rel_planilha_custo_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->cliente->viewAttributes() ?>><?= $Page->cliente->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->cliente->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->idplanilha_custo->getDistinctValues($Page->cliente->Records, $Page->idplanilha_custo->getSort());
    $Page->setGroupCount(count($Page->idplanilha_custo->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3]);
    $Page->GroupCounter[4] = 0; // Init group count index
    foreach ($Page->idplanilha_custo->DistinctValues as $idplanilha_custo) { // Load records for this distinct value
        $Page->idplanilha_custo->setGroupValue($idplanilha_custo); // Set group value
        $Page->idplanilha_custo->getDistinctRecords($Page->cliente->Records, $Page->idplanilha_custo->groupValue());
        $Page->idplanilha_custo->LevelBreak = true; // Set field level break
        $Page->GroupCounter[4]++;
        $Page->idplanilha_custo->getCnt($Page->idplanilha_custo->Records); // Get record count
?>
<?php if ($Page->idplanilha_custo->Visible && $Page->idplanilha_custo->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->idplanilha_custo->setDbValue($idplanilha_custo); // Set current value for idplanilha_custo
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 4;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->idplanilha_custo->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="idplanilha_custo" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 4) ?>"<?= $Page->idplanilha_custo->cellAttributes() ?>>
            <span class="ew-summary-caption rel_planilha_custo_idplanilha_custo"><?= $Page->renderFieldHeader($Page->idplanilha_custo) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->idplanilha_custo->viewAttributes() ?>><?= $Page->idplanilha_custo->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->idplanilha_custo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->cargo->getDistinctValues($Page->idplanilha_custo->Records, $Page->cargo->getSort());
    $Page->setGroupCount(count($Page->cargo->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3], $Page->GroupCounter[4]);
    $Page->GroupCounter[5] = 0; // Init group count index
    foreach ($Page->cargo->DistinctValues as $cargo) { // Load records for this distinct value
        $Page->cargo->setGroupValue($cargo); // Set group value
        $Page->cargo->getDistinctRecords($Page->idplanilha_custo->Records, $Page->cargo->groupValue());
        $Page->cargo->LevelBreak = true; // Set field level break
        $Page->GroupCounter[5]++;
        $Page->cargo->getCnt($Page->cargo->Records); // Get record count
?>
<?php if ($Page->cargo->Visible && $Page->cargo->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->cargo->setDbValue($cargo); // Set current value for cargo
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 5;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->cargo->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="cargo" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 5) ?>"<?= $Page->cargo->cellAttributes() ?>>
            <span class="ew-summary-caption rel_planilha_custo_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->cargo->viewAttributes() ?>><?= $Page->cargo->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->cargo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->modulo->getDistinctValues($Page->cargo->Records, $Page->modulo->getSort());
    $Page->setGroupCount(count($Page->modulo->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3], $Page->GroupCounter[4], $Page->GroupCounter[5]);
    $Page->GroupCounter[6] = 0; // Init group count index
    foreach ($Page->modulo->DistinctValues as $modulo) { // Load records for this distinct value
        $Page->modulo->setGroupValue($modulo); // Set group value
        $Page->modulo->getDistinctRecords($Page->cargo->Records, $Page->modulo->groupValue());
        $Page->modulo->LevelBreak = true; // Set field level break
        $Page->GroupCounter[6]++;
        $Page->modulo->getCnt($Page->modulo->Records); // Get record count
        $Page->setGroupCount($Page->modulo->Count, $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3], $Page->GroupCounter[4], $Page->GroupCounter[5], $Page->GroupCounter[6]);
?>
<?php if ($Page->modulo->Visible && $Page->modulo->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->modulo->setDbValue($modulo); // Set current value for modulo
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 6;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->modulo->Visible) { ?>
        <td data-field="modulo"<?= $Page->modulo->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->modulo->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="modulo" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 6) ?>"<?= $Page->modulo->cellAttributes() ?>>
            <span class="ew-summary-caption rel_planilha_custo_modulo"><?= $Page->renderFieldHeader($Page->modulo) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->modulo->viewAttributes() ?>><?= $Page->modulo->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->modulo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->modulo->Records as $record) {
            $Page->RecordCount++;
            $Page->RecordIndex++;
            $Page->loadRowValues($record);
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = RowType::DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
    <?php if ($Page->idproposta->ShowGroupHeaderAsRow) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>><span<?= $Page->idproposta->viewAttributes() ?>><?= $Page->idproposta->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
    <?php if ($Page->dt_cadastro->ShowGroupHeaderAsRow) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>><span<?= $Page->dt_cadastro->viewAttributes() ?>><?= $Page->dt_cadastro->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
    <?php if ($Page->cliente->ShowGroupHeaderAsRow) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>><span<?= $Page->cliente->viewAttributes() ?>><?= $Page->cliente->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
    <?php if ($Page->idplanilha_custo->ShowGroupHeaderAsRow) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>><span<?= $Page->idplanilha_custo->viewAttributes() ?>><?= $Page->idplanilha_custo->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <?php if ($Page->cargo->ShowGroupHeaderAsRow) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>><span<?= $Page->cargo->viewAttributes() ?>><?= $Page->cargo->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->modulo->Visible) { ?>
    <?php if ($Page->modulo->ShowGroupHeaderAsRow) { ?>
        <td data-field="modulo"<?= $Page->modulo->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="modulo"<?= $Page->modulo->cellAttributes() ?>><span<?= $Page->modulo->viewAttributes() ?>><?= $Page->modulo->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->item->Visible) { ?>
        <td data-field="item"<?= $Page->item->cellAttributes() ?>>
<span<?= $Page->item->viewAttributes() ?>>
<?= $Page->item->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { ?>
        <td data-field="porcentagem"<?= $Page->porcentagem->cellAttributes() ?>>
<span<?= $Page->porcentagem->viewAttributes() ?>>
<?= $Page->porcentagem->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->valor->Visible) { ?>
        <td data-field="valor"<?= $Page->valor->cellAttributes() ?>>
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->obs->Visible) { ?>
        <td data-field="obs"<?= $Page->obs->cellAttributes() ?>>
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
    }
?>
<?php if ($Page->TotalGroups > 0) { ?>
<?php
    $Page->porcentagem->getSum($Page->modulo->Records, false); // Get Sum
    $Page->valor->getSum($Page->modulo->Records, false); // Get Sum
    $Page->resetAttributes();
    $Page->RowType = RowType::TOTAL;
    $Page->RowTotalType = RowSummary::GROUP;
    $Page->RowTotalSubType = RowTotal::FOOTER;
    $Page->RowGroupLevel = 6;
    $Page->renderRow();
?>
<?php if ($Page->modulo->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
    <?php if ($Page->idproposta->ShowGroupHeaderAsRow) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 1) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->idproposta->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
    <?php if ($Page->dt_cadastro->ShowGroupHeaderAsRow) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 2) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->dt_cadastro->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
    <?php if ($Page->cliente->ShowGroupHeaderAsRow) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 3) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->cliente->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
    <?php if ($Page->idplanilha_custo->ShowGroupHeaderAsRow) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 4) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->idplanilha_custo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <?php if ($Page->cargo->ShowGroupHeaderAsRow) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 5) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->cargo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->modulo->Visible) { ?>
    <?php if ($Page->modulo->ShowGroupHeaderAsRow) { ?>
        <td data-field="modulo"<?= $Page->modulo->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 6) { ?>
        <td data-field="modulo"<?= $Page->modulo->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="modulo"<?= $Page->modulo->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->modulo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->item->Visible) { ?>
        <td data-field="item"<?= $Page->modulo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { ?>
        <td data-field="porcentagem"<?= $Page->modulo->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->porcentagem->viewAttributes() ?>><?= $Page->porcentagem->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->valor->Visible) { ?>
        <td data-field="valor"<?= $Page->modulo->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->valor->viewAttributes() ?>><?= $Page->valor->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->obs->Visible) { ?>
        <td data-field="obs"<?= $Page->modulo->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->SubGroupColumnCount + $Page->DetailColumnCount - 4 > 0) { ?>
        <td colspan="<?= ($Page->SubGroupColumnCount + $Page->DetailColumnCount - 4) ?>"<?= $Page->modulo->cellAttributes() ?>><?= str_replace(["%v", "%c"], [$Page->modulo->GroupViewValue, $Page->modulo->caption()], $Language->phrase("RptSumHead")) ?> <span class="ew-dir-ltr">(<?= FormatNumber($Page->modulo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td>
<?php } ?>
    </tr>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= ($Page->GroupColumnCount - 5) ?>"<?= $Page->modulo->cellAttributes() ?>><?= $Language->phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->item->Visible) { ?>
        <td data-field="item"<?= $Page->modulo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { ?>
        <td data-field="porcentagem"<?= $Page->porcentagem->cellAttributes() ?>>
<span<?= $Page->porcentagem->viewAttributes() ?>>
<?= $Page->porcentagem->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->valor->Visible) { ?>
        <td data-field="valor"<?= $Page->valor->cellAttributes() ?>>
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->obs->Visible) { ?>
        <td data-field="obs"<?= $Page->modulo->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } ?>
<?php } ?>
<?php
    } // End group level 5
    } // End group level 4
    } // End group level 3
    } // End group level 2
    } // End group level 1
?>
<?php

    // Next group
    $Page->loadGroupRowValues();

    // Show header if page break
    if ($Page->isExport()) {
        $Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? false : ($Page->GroupCount % $Page->ExportPageBreakCount == 0);
    }

    // Page_Breaking server event
    if ($Page->ShowHeader) {
        $Page->pageBreaking($Page->ShowHeader, $Page->PageBreakHtml);
    }
    $Page->GroupCount++;
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
</tfoot>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if ($Page->TotalGroups > 0) { ?>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
</main>
<!-- /.report-summary -->
<!-- Summary report (end) -->
<?php } ?>
</div>
<!-- /.ew-report -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
