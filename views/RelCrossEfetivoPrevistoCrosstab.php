<?php

namespace PHPMaker2024\contratos;

// Page object
$RelCrossEfetivoPrevistoCrosstab = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_cross_efetivo_previsto: currentTable } });
var currentPageID = ew.PAGE_ID = "crosstab";
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
<form name="frel_cross_efetivo_previstosrch" id="frel_cross_efetivo_previstosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_cross_efetivo_previstosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_cross_efetivo_previsto: currentTable } });
var currentPageID = ew.PAGE_ID = "crosstab";
var currentForm;
var frel_cross_efetivo_previstosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_cross_efetivo_previstosrch")
        .setPageId("crosstab")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["cliente", [], fields.cliente.isInvalid]
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
            "cargo": <?= $Page->cargo->toClientList($Page) ?>,
            "cliente": <?= $Page->cliente->toClientList($Page) ?>,
            "periodo": <?= $Page->periodo->toClientList($Page) ?>,
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
<?php if ($Page->cargo->Visible) { // cargo ?>
<?php
if (!$Page->cargo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_cargo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->cargo->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_cargo"
            name="x_cargo[]"
            class="form-control ew-select<?= $Page->cargo->isInvalidClass() ?>"
            data-select2-id="frel_cross_efetivo_previstosrch_x_cargo"
            data-table="rel_cross_efetivo_previsto"
            data-field="x_cargo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->cargo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->cargo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->cargo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->cargo->editAttributes() ?>>
            <?= $Page->cargo->selectOptionListHtml("x_cargo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->cargo->getErrorMessage() ?></div>
        <script>
        loadjs.ready("frel_cross_efetivo_previstosrch", function() {
            var options = {
                name: "x_cargo",
                selectId: "frel_cross_efetivo_previstosrch_x_cargo",
                ajax: { id: "x_cargo", form: "frel_cross_efetivo_previstosrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_cross_efetivo_previsto.fields.cargo.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
        <div id="el_rel_cross_efetivo_previsto_cliente" class="ew-search-field">
    <select
        id="x_cliente"
        name="x_cliente"
        class="form-control ew-select<?= $Page->cliente->isInvalidClass() ?>"
        data-select2-id="frel_cross_efetivo_previstosrch_x_cliente"
        data-table="rel_cross_efetivo_previsto"
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
loadjs.ready("frel_cross_efetivo_previstosrch", function() {
    var options = { name: "x_cliente", selectId: "frel_cross_efetivo_previstosrch_x_cliente" };
    if (frel_cross_efetivo_previstosrch.lists.cliente?.lookupOptions.length) {
        options.data = { id: "x_cliente", form: "frel_cross_efetivo_previstosrch" };
    } else {
        options.ajax = { id: "x_cliente", form: "frel_cross_efetivo_previstosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_cross_efetivo_previsto.fields.cliente.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->periodo->Visible) { // periodo ?>
<?php
if (!$Page->periodo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_periodo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->periodo->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_periodo"
            name="x_periodo[]"
            class="form-control ew-select<?= $Page->periodo->isInvalidClass() ?>"
            data-select2-id="frel_cross_efetivo_previstosrch_x_periodo"
            data-table="rel_cross_efetivo_previsto"
            data-field="x_periodo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->periodo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->periodo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->periodo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->periodo->editAttributes() ?>>
            <?= $Page->periodo->selectOptionListHtml("x_periodo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->periodo->getErrorMessage() ?></div>
        <script>
        loadjs.ready("frel_cross_efetivo_previstosrch", function() {
            var options = {
                name: "x_periodo",
                selectId: "frel_cross_efetivo_previstosrch_x_periodo",
                ajax: { id: "x_periodo", form: "frel_cross_efetivo_previstosrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_cross_efetivo_previsto.fields.periodo.filterOptions);
            ew.createFilter(options);
        });
        </script>
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
<!-- Crosstab report (begin) -->
<main class="report-crosstab<?= ($Page->TotalGroups == 0) ? " ew-no-record" : "" ?>">
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
<div id="gmp_rel_cross_efetivo_previsto" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td class="ew-rpt-col-summary" colspan="<?= $Page->GroupColumnCount ?>"><div><?= $Page->renderSummaryCaptions() ?></div></td>
<?php } ?>
        <td class="ew-rpt-col-header" colspan="<?= @$Page->ColumnSpan ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cargo->caption() ?></span>
            </div>
        </td>
    </tr>
    <tr class="ew-table-header">
<?php if ($Page->cliente->Visible) { ?>
    <td data-field="cliente"><div><?= $Page->renderFieldHeader($Page->cliente) ?></div></td>
<?php } ?>
<?php if ($Page->escala->Visible) { ?>
    <td data-field="escala"><div style="white-space: nowrap;"><?= $Page->renderFieldHeader($Page->escala) ?></div></td>
<?php } ?>
<?php if ($Page->periodo->Visible) { ?>
    <td data-field="periodo"><div><?= $Page->renderFieldHeader($Page->periodo) ?></div></td>
<?php } ?>
<?php if ($Page->jornada->Visible) { ?>
    <td data-field="jornada"><div><?= $Page->renderFieldHeader($Page->jornada) ?></div></td>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
    $cntval = count($Page->Columns);
    for ($iy = 1; $iy < $cntval; $iy++) {
        if ($Page->Columns[$iy]->Visible) {
            $Page->SummaryCurrentValues[$iy - 1] = $Page->Columns[$iy]->Caption;
            $Page->SummaryViewValues[$iy - 1] = $Page->SummaryCurrentValues[$iy - 1];
?>
        <td class="ew-table-header"<?= $Page->cargo->cellAttributes() ?>><div<?= $Page->cargo->viewAttributes() ?>><?= $Page->SummaryViewValues[$iy-1]; ?></div></td>
<?php
        }
    }
?>
<!-- Dynamic columns end -->
        <td class="ew-table-header"<?= $Page->cargo->cellAttributes() ?>><div<?= $Page->cargo->viewAttributes() ?>><?= $Page->renderSummaryCaptions() ?></div></td>
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
    $sql = $Page->buildReportSql($Page->getSqlSelect()->addSelect($Page->DistinctColumnFields), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), "", $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->cliente->Records = &$Page->DetailRecords;
    $Page->cliente->LevelBreak = true; // Set field level break
    $Page->escala->getDistinctValues($Page->cliente->Records, $Page->escala->getSort());
    foreach ($Page->escala->DistinctValues as $escala) { // Load records for this distinct value
        $Page->escala->setGroupValue($escala); // Set group value
        $Page->escala->getDistinctRecords($Page->cliente->Records, $Page->escala->groupValue());
        $Page->escala->LevelBreak = true; // Set field level break
    $Page->periodo->getDistinctValues($Page->escala->Records, $Page->periodo->getSort());
    foreach ($Page->periodo->DistinctValues as $periodo) { // Load records for this distinct value
        $Page->periodo->setGroupValue($periodo); // Set group value
        $Page->periodo->getDistinctRecords($Page->escala->Records, $Page->periodo->groupValue());
        $Page->periodo->LevelBreak = true; // Set field level break
    $Page->jornada->getDistinctValues($Page->periodo->Records, $Page->jornada->getSort());
    foreach ($Page->jornada->DistinctValues as $jornada) { // Load records for this distinct value
        $Page->jornada->setGroupValue($jornada); // Set group value
        $Page->jornada->getDistinctRecords($Page->periodo->Records, $Page->jornada->groupValue());
        $Page->jornada->LevelBreak = true; // Set field level break
        foreach ($Page->jornada->Records as $record) {
            $Page->RecordCount++;
            $Page->RecordIndex++;
            $Page->loadRowValues($record);

            // Render row
            $Page->resetAttributes();
            $Page->RowType = RowType::DETAIL;
            $Page->renderRow();
?>
	<tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->cliente->Visible) { ?>
        <!-- cliente -->
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>><span<?= $Page->cliente->viewAttributes() ?>><?= $Page->cliente->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->escala->Visible) { ?>
        <!-- escala -->
        <td data-field="escala"<?= $Page->escala->cellAttributes() ?>><span<?= $Page->escala->viewAttributes() ?>><?= $Page->escala->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->periodo->Visible) { ?>
        <!-- periodo -->
        <td data-field="periodo"<?= $Page->periodo->cellAttributes() ?>><span<?= $Page->periodo->viewAttributes() ?>><?= $Page->periodo->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->jornada->Visible) { ?>
        <!-- jornada -->
        <td data-field="jornada"<?= $Page->jornada->cellAttributes() ?>><span<?= $Page->jornada->viewAttributes() ?>><?= $Page->jornada->GroupViewValue ?></span></td>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
        $cntcol = count($Page->SummaryViewValues);
        for ($iy = 1; $iy <= $cntcol; $iy++) {
            $colShow = ($iy <= $Page->ColumnCount) ? $Page->Columns[$iy]->Visible : true;
            $colDesc = ($iy <= $Page->ColumnCount) ? $Page->Columns[$iy]->Caption : $Language->phrase("Summary");
            if ($colShow) {
?>
        <!-- <?= $colDesc; ?> -->
        <td<?= $Page->summaryCellAttributes($iy-1) ?>><?= $Page->renderSummaryFields($iy-1) ?></td>
<?php
            }
        }
?>
<!-- Dynamic columns end -->
    </tr>
<?php
    }
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
<?php
    $Page->resetAttributes();
    $Page->RowType = RowType::TOTAL;
    $Page->RowTotalType = RowSummary::GRAND;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
    <!-- Grand Total -->
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
    <td colspan="<?= $Page->GroupColumnCount ?>"><?= $Page->renderSummaryCaptions("grand") ?></td>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
    $cntcol = count($Page->SummaryViewValues);
    for ($iy = 1; $iy <= $cntcol; $iy++) {
        $colShow = ($iy <= $Page->ColumnCount) ? $Page->Columns[$iy]->Visible : true;
        $colDesc = ($iy <= $Page->ColumnCount) ? $Page->Columns[$iy]->Caption : $Language->phrase("Summary");
        if ($colShow) {
?>
        <!-- <?= $colDesc; ?> -->
        <td<?= $Page->summaryCellAttributes($iy-1) ?>><?= $Page->renderSummaryFields($iy-1) ?></td>
<?php
        }
    }
?>
<!-- Dynamic columns end -->
    </tr>
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
<!-- /.report-crosstab -->
<!-- Crosstab report (end) -->
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
