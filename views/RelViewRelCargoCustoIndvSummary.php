<?php

namespace PHPMaker2024\contratos;

// Page object
$RelViewRelCargoCustoIndvSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_rel_cargo_custo_indv: currentTable } });
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
<form name="frel_view_rel_cargo_custo_indvsrch" id="frel_view_rel_cargo_custo_indvsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_view_rel_cargo_custo_indvsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_rel_cargo_custo_indv: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_view_rel_cargo_custo_indvsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_view_rel_cargo_custo_indvsrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["cliente", [], fields.cliente.isInvalid],
            ["cargo", [], fields.cargo.isInvalid]
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
            "cliente": <?= $Page->cliente->toClientList($Page) ?>,
            "cargo": <?= $Page->cargo->toClientList($Page) ?>,
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
<?php if ($Page->cliente->Visible) { // cliente ?>
<?php
if (!$Page->cliente->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_cliente" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->cliente->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_cliente" class="ew-search-caption ew-label"><?= $Page->cliente->caption() ?></label>
        </div>
        <div id="el_rel_view_rel_cargo_custo_indv_cliente" class="ew-search-field">
    <select
        id="x_cliente"
        name="x_cliente"
        class="form-control ew-select<?= $Page->cliente->isInvalidClass() ?>"
        data-select2-id="frel_view_rel_cargo_custo_indvsrch_x_cliente"
        data-table="rel_view_rel_cargo_custo_indv"
        data-field="x_cliente"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->cliente->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->cliente->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cliente->getPlaceHolder()) ?>"
        <?= $Page->cliente->editAttributes() ?>>
        <?= $Page->cliente->selectOptionListHtml("x_cliente") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->cliente->getErrorMessage() ?></div>
<?= $Page->cliente->Lookup->getParamTag($Page, "p_x_cliente") ?>
<script>
loadjs.ready("frel_view_rel_cargo_custo_indvsrch", function() {
    var options = { name: "x_cliente", selectId: "frel_view_rel_cargo_custo_indvsrch_x_cliente" };
    if (frel_view_rel_cargo_custo_indvsrch.lists.cliente?.lookupOptions.length) {
        options.data = { id: "x_cliente", form: "frel_view_rel_cargo_custo_indvsrch" };
    } else {
        options.ajax = { id: "x_cliente", form: "frel_view_rel_cargo_custo_indvsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_view_rel_cargo_custo_indv.fields.cliente.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
<?php
if (!$Page->cargo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_cargo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->cargo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_cargo" class="ew-search-caption ew-label"><?= $Page->cargo->caption() ?></label>
        </div>
        <div id="el_rel_view_rel_cargo_custo_indv_cargo" class="ew-search-field">
    <select
        id="x_cargo"
        name="x_cargo"
        class="form-control ew-select<?= $Page->cargo->isInvalidClass() ?>"
        data-select2-id="frel_view_rel_cargo_custo_indvsrch_x_cargo"
        data-table="rel_view_rel_cargo_custo_indv"
        data-field="x_cargo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->cargo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->cargo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cargo->getPlaceHolder()) ?>"
        <?= $Page->cargo->editAttributes() ?>>
        <?= $Page->cargo->selectOptionListHtml("x_cargo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->cargo->getErrorMessage() ?></div>
<?= $Page->cargo->Lookup->getParamTag($Page, "p_x_cargo") ?>
<script>
loadjs.ready("frel_view_rel_cargo_custo_indvsrch", function() {
    var options = { name: "x_cargo", selectId: "frel_view_rel_cargo_custo_indvsrch_x_cargo" };
    if (frel_view_rel_cargo_custo_indvsrch.lists.cargo?.lookupOptions.length) {
        options.data = { id: "x_cargo", form: "frel_view_rel_cargo_custo_indvsrch" };
    } else {
        options.ajax = { id: "x_cargo", form: "frel_view_rel_cargo_custo_indvsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_view_rel_cargo_custo_indv.fields.cargo.modalLookupOptions);
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
<div id="gmp_rel_view_rel_cargo_custo_indv" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->cliente->Visible) { ?>
    <?php if ($Page->cliente->ShowGroupHeaderAsRow) { ?>
    <th data-name="cliente"<?= $Page->cliente->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->cliente->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div class="rel_view_rel_cargo_custo_indv_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->vr_contrato->Visible) { ?>
    <?php if ($Page->vr_contrato->ShowGroupHeaderAsRow) { ?>
    <th data-name="vr_contrato">&nbsp;</th>
    <?php } else { ?>
    <th data-name="vr_contrato" class="<?= $Page->vr_contrato->headerCellClass() ?>"><div class="rel_view_rel_cargo_custo_indv_vr_contrato"><?= $Page->renderFieldHeader($Page->vr_contrato) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <?php if ($Page->cargo->ShowGroupHeaderAsRow) { ?>
    <th data-name="cargo">&nbsp;</th>
    <?php } else { ?>
    <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div class="rel_view_rel_cargo_custo_indv_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->modulo->Visible) { ?>
    <?php if ($Page->modulo->ShowGroupHeaderAsRow) { ?>
    <th data-name="modulo">&nbsp;</th>
    <?php } else { ?>
    <th data-name="modulo" class="<?= $Page->modulo->headerCellClass() ?>"><div class="rel_view_rel_cargo_custo_indv_modulo"><?= $Page->renderFieldHeader($Page->modulo) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->quantidade->Visible) { ?>
    <th data-name="quantidade" class="<?= $Page->quantidade->headerCellClass() ?>"><div class="rel_view_rel_cargo_custo_indv_quantidade"><?= $Page->renderFieldHeader($Page->quantidade) ?></div></th>
<?php } ?>
<?php if ($Page->total->Visible) { ?>
    <th data-name="total" class="<?= $Page->total->headerCellClass() ?>"><div class="rel_view_rel_cargo_custo_indv_total"><?= $Page->renderFieldHeader($Page->total) ?></div></th>
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
    $where = DetailFilterSql($Page->cliente, $Page->getSqlFirstGroupField(), $Page->cliente->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->cliente->Records = &$Page->DetailRecords;
    $Page->cliente->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->cliente->getCnt($Page->cliente->Records); // Get record count
?>
<?php if ($Page->cliente->Visible && $Page->cliente->ShowGroupHeaderAsRow) { ?>
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
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->cliente->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="cliente" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->cliente->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_rel_cargo_custo_indv_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->cliente->viewAttributes() ?>><?= $Page->cliente->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->cliente->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->vr_contrato->getDistinctValues($Page->cliente->Records, $Page->vr_contrato->getSort());
    $Page->setGroupCount(count($Page->vr_contrato->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->vr_contrato->DistinctValues as $vr_contrato) { // Load records for this distinct value
        $Page->vr_contrato->setGroupValue($vr_contrato); // Set group value
        $Page->vr_contrato->getDistinctRecords($Page->cliente->Records, $Page->vr_contrato->groupValue());
        $Page->vr_contrato->LevelBreak = true; // Set field level break
        $Page->GroupCounter[2]++;
        $Page->vr_contrato->getCnt($Page->vr_contrato->Records); // Get record count
?>
<?php if ($Page->vr_contrato->Visible && $Page->vr_contrato->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->vr_contrato->setDbValue($vr_contrato); // Set current value for vr_contrato
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 2;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_contrato->Visible) { ?>
        <td data-field="vr_contrato"<?= $Page->vr_contrato->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->vr_contrato->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="vr_contrato" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->vr_contrato->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_rel_cargo_custo_indv_vr_contrato"><?= $Page->renderFieldHeader($Page->vr_contrato) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->vr_contrato->viewAttributes() ?>><?= $Page->vr_contrato->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->vr_contrato->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->cargo->getDistinctValues($Page->vr_contrato->Records, $Page->cargo->getSort());
    $Page->setGroupCount(count($Page->cargo->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2]);
    $Page->GroupCounter[3] = 0; // Init group count index
    foreach ($Page->cargo->DistinctValues as $cargo) { // Load records for this distinct value
        $Page->cargo->setGroupValue($cargo); // Set group value
        $Page->cargo->getDistinctRecords($Page->vr_contrato->Records, $Page->cargo->groupValue());
        $Page->cargo->LevelBreak = true; // Set field level break
        $Page->GroupCounter[3]++;
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
        $Page->RowGroupLevel = 3;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_contrato->Visible) { ?>
        <td data-field="vr_contrato"<?= $Page->vr_contrato->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->cargo->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="cargo" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 3) ?>"<?= $Page->cargo->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_rel_cargo_custo_indv_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->cargo->viewAttributes() ?>><?= $Page->cargo->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->cargo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->modulo->getDistinctValues($Page->cargo->Records, $Page->modulo->getSort());
    $Page->setGroupCount(count($Page->modulo->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3]);
    $Page->GroupCounter[4] = 0; // Init group count index
    foreach ($Page->modulo->DistinctValues as $modulo) { // Load records for this distinct value
        $Page->modulo->setGroupValue($modulo); // Set group value
        $Page->modulo->getDistinctRecords($Page->cargo->Records, $Page->modulo->groupValue());
        $Page->modulo->LevelBreak = true; // Set field level break
        $Page->GroupCounter[4]++;
        $Page->modulo->getCnt($Page->modulo->Records); // Get record count
        $Page->setGroupCount($Page->modulo->Count, $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3], $Page->GroupCounter[4]);
?>
<?php if ($Page->modulo->Visible && $Page->modulo->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->modulo->setDbValue($modulo); // Set current value for modulo
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 4;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_contrato->Visible) { ?>
        <td data-field="vr_contrato"<?= $Page->vr_contrato->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->modulo->Visible) { ?>
        <td data-field="modulo"<?= $Page->modulo->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->modulo->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="modulo" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 4) ?>"<?= $Page->modulo->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_rel_cargo_custo_indv_modulo"><?= $Page->renderFieldHeader($Page->modulo) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->modulo->viewAttributes() ?>><?= $Page->modulo->GroupViewValue ?></span>
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
<?php if ($Page->cliente->Visible) { ?>
    <?php if ($Page->cliente->ShowGroupHeaderAsRow) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>><span<?= $Page->cliente->viewAttributes() ?>><?= $Page->cliente->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->vr_contrato->Visible) { ?>
    <?php if ($Page->vr_contrato->ShowGroupHeaderAsRow) { ?>
        <td data-field="vr_contrato"<?= $Page->vr_contrato->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="vr_contrato"<?= $Page->vr_contrato->cellAttributes() ?>><span<?= $Page->vr_contrato->viewAttributes() ?>><?= $Page->vr_contrato->GroupViewValue ?></span></td>
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
<?php if ($Page->quantidade->Visible) { ?>
        <td data-field="quantidade"<?= $Page->quantidade->cellAttributes() ?>>
<span<?= $Page->quantidade->viewAttributes() ?>>
<?= $Page->quantidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->total->Visible) { ?>
        <td data-field="total"<?= $Page->total->cellAttributes() ?>>
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
    }
    } // End group level 3
?>
<?php if ($Page->TotalGroups > 0) { ?>
<?php
    $Page->total->getSum($Page->cargo->Records, false); // Get Sum
    $Page->resetAttributes();
    $Page->RowType = RowType::TOTAL;
    $Page->RowTotalType = RowSummary::GROUP;
    $Page->RowTotalSubType = RowTotal::FOOTER;
    $Page->RowGroupLevel = 3;
    $Page->renderRow();
?>
<?php if ($Page->cargo->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->cliente->Visible) { ?>
    <?php if ($Page->cliente->ShowGroupHeaderAsRow) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 1) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->cliente->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->vr_contrato->Visible) { ?>
    <?php if ($Page->vr_contrato->ShowGroupHeaderAsRow) { ?>
        <td data-field="vr_contrato"<?= $Page->vr_contrato->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 2) { ?>
        <td data-field="vr_contrato"<?= $Page->vr_contrato->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="vr_contrato"<?= $Page->vr_contrato->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->vr_contrato->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <?php if ($Page->cargo->ShowGroupHeaderAsRow) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 3) { ?>
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
        <td data-field="modulo"<?= $Page->cargo->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 4) { ?>
        <td data-field="modulo"<?= $Page->cargo->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="modulo"<?= $Page->cargo->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->modulo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->quantidade->Visible) { ?>
        <td data-field="quantidade"<?= $Page->cargo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->total->Visible) { ?>
        <td data-field="total"<?= $Page->cargo->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->total->viewAttributes() ?>><?= $Page->total->SumViewValue ?></span></span></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_contrato->Visible) { ?>
        <td data-field="vr_contrato"<?= $Page->vr_contrato->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->SubGroupColumnCount + $Page->DetailColumnCount - 1 > 0) { ?>
        <td colspan="<?= ($Page->SubGroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->cargo->cellAttributes() ?>><?= str_replace(["%v", "%c"], [$Page->cargo->GroupViewValue, $Page->cargo->caption()], $Language->phrase("RptSumHead")) ?> <span class="ew-dir-ltr">(<?= FormatNumber($Page->cargo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td>
<?php } ?>
    </tr>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_contrato->Visible) { ?>
        <td data-field="vr_contrato"<?= $Page->vr_contrato->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= ($Page->GroupColumnCount - 2) ?>"<?= $Page->cargo->cellAttributes() ?>><?= $Language->phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->quantidade->Visible) { ?>
        <td data-field="quantidade"<?= $Page->cargo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->total->Visible) { ?>
        <td data-field="total"<?= $Page->total->cellAttributes() ?>>
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->SumViewValue ?></span>
</td>
<?php } ?>
    </tr>
<?php } ?>
<?php } ?>
<?php
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
<?php
    $Page->resetAttributes();
    $Page->RowType = RowType::TOTAL;
    $Page->RowTotalType = RowSummary::GRAND;
    $Page->RowTotalSubType = RowTotal::FOOTER;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
<?php if ($Page->cliente->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"></td>
<?php } ?>
<?php if ($Page->quantidade->Visible) { ?>
        <td data-field="quantidade"<?= $Page->quantidade->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->total->Visible) { ?>
        <td data-field="total"<?= $Page->total->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->total->viewAttributes() ?>><?= $Page->total->SumViewValue ?></span></span></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"><?= $Language->phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->quantidade->Visible) { ?>
        <td data-field="quantidade"<?= $Page->quantidade->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->total->Visible) { ?>
        <td data-field="total"<?= $Page->total->cellAttributes() ?>>
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->SumViewValue ?></span>
</td>
<?php } ?>
    </tr>
<?php } ?>
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
