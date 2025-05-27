<?php

namespace PHPMaker2024\contratos;

// Page object
$RelCrossPropostaCrosstab = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_cross_proposta: currentTable } });
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
<form name="frel_cross_propostasrch" id="frel_cross_propostasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_cross_propostasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_cross_proposta: currentTable } });
var currentPageID = ew.PAGE_ID = "crosstab";
var currentForm;
var frel_cross_propostasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_cross_propostasrch")
        .setPageId("crosstab")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["cliente", [], fields.cliente.isInvalid],
            ["modulo", [], fields.modulo.isInvalid]
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
            "modulo": <?= $Page->modulo->toClientList($Page) ?>,
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
        <div id="el_rel_cross_proposta_cliente" class="ew-search-field">
    <select
        id="x_cliente"
        name="x_cliente"
        class="form-control ew-select<?= $Page->cliente->isInvalidClass() ?>"
        data-select2-id="frel_cross_propostasrch_x_cliente"
        data-table="rel_cross_proposta"
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
loadjs.ready("frel_cross_propostasrch", function() {
    var options = { name: "x_cliente", selectId: "frel_cross_propostasrch_x_cliente" };
    if (frel_cross_propostasrch.lists.cliente?.lookupOptions.length) {
        options.data = { id: "x_cliente", form: "frel_cross_propostasrch" };
    } else {
        options.ajax = { id: "x_cliente", form: "frel_cross_propostasrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_cross_proposta.fields.cliente.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
<?php
if (!$Page->modulo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_modulo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->modulo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_modulo" class="ew-search-caption ew-label"><?= $Page->modulo->caption() ?></label>
        </div>
        <div id="el_rel_cross_proposta_modulo" class="ew-search-field">
    <select
        id="x_modulo"
        name="x_modulo"
        class="form-control ew-select<?= $Page->modulo->isInvalidClass() ?>"
        data-select2-id="frel_cross_propostasrch_x_modulo"
        data-table="rel_cross_proposta"
        data-field="x_modulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->modulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->modulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->modulo->getPlaceHolder()) ?>"
        <?= $Page->modulo->editAttributes() ?>>
        <?= $Page->modulo->selectOptionListHtml("x_modulo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->modulo->getErrorMessage() ?></div>
<?= $Page->modulo->Lookup->getParamTag($Page, "p_x_modulo") ?>
<script>
loadjs.ready("frel_cross_propostasrch", function() {
    var options = { name: "x_modulo", selectId: "frel_cross_propostasrch_x_modulo" };
    if (frel_cross_propostasrch.lists.modulo?.lookupOptions.length) {
        options.data = { id: "x_modulo", form: "frel_cross_propostasrch" };
    } else {
        options.ajax = { id: "x_modulo", form: "frel_cross_propostasrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_cross_proposta.fields.modulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
<?php
if (!$Page->idplanilha_custo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_idplanilha_custo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->idplanilha_custo->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_idplanilha_custo"
            name="x_idplanilha_custo[]"
            class="form-control ew-select<?= $Page->idplanilha_custo->isInvalidClass() ?>"
            data-select2-id="frel_cross_propostasrch_x_idplanilha_custo"
            data-table="rel_cross_proposta"
            data-field="x_idplanilha_custo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->idplanilha_custo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->idplanilha_custo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->idplanilha_custo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->idplanilha_custo->editAttributes() ?>>
            <?= $Page->idplanilha_custo->selectOptionListHtml("x_idplanilha_custo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->idplanilha_custo->getErrorMessage() ?></div>
        <?= $Page->idplanilha_custo->Lookup->getParamTag($Page, "p_x_idplanilha_custo") ?>
        <script>
        loadjs.ready("frel_cross_propostasrch", function() {
            var options = {
                name: "x_idplanilha_custo",
                selectId: "frel_cross_propostasrch_x_idplanilha_custo",
                ajax: { id: "x_idplanilha_custo", form: "frel_cross_propostasrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_cross_proposta.fields.idplanilha_custo.filterOptions);
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
<div id="gmp_rel_cross_proposta" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
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
<?php if ($Page->modulo->Visible) { ?>
    <td data-field="modulo"><div><?= $Page->renderFieldHeader($Page->modulo) ?></div></td>
<?php } ?>
<?php if ($Page->item->Visible) { ?>
    <td data-field="item"><div><?= $Page->renderFieldHeader($Page->item) ?></div></td>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { ?>
    <td data-field="porcentagem"><div><?= $Page->renderFieldHeader($Page->porcentagem) ?></div></td>
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
    $Page->modulo->getDistinctValues($Page->cliente->Records, $Page->modulo->getSort());
    foreach ($Page->modulo->DistinctValues as $modulo) { // Load records for this distinct value
        $Page->modulo->setGroupValue($modulo); // Set group value
        $Page->modulo->getDistinctRecords($Page->cliente->Records, $Page->modulo->groupValue());
        $Page->modulo->LevelBreak = true; // Set field level break
    $Page->item->getDistinctValues($Page->modulo->Records, $Page->item->getSort());
    foreach ($Page->item->DistinctValues as $item) { // Load records for this distinct value
        $Page->item->setGroupValue($item); // Set group value
        $Page->item->getDistinctRecords($Page->modulo->Records, $Page->item->groupValue());
        $Page->item->LevelBreak = true; // Set field level break
    $Page->porcentagem->getDistinctValues($Page->item->Records, $Page->porcentagem->getSort());
    foreach ($Page->porcentagem->DistinctValues as $porcentagem) { // Load records for this distinct value
        $Page->porcentagem->setGroupValue($porcentagem); // Set group value
        $Page->porcentagem->getDistinctRecords($Page->item->Records, $Page->porcentagem->groupValue());
        $Page->porcentagem->LevelBreak = true; // Set field level break
        foreach ($Page->porcentagem->Records as $record) {
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
<?php if ($Page->modulo->Visible) { ?>
        <!-- modulo -->
        <td data-field="modulo"<?= $Page->modulo->cellAttributes() ?>><span<?= $Page->modulo->viewAttributes() ?>><?= $Page->modulo->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->item->Visible) { ?>
        <!-- item -->
        <td data-field="item"<?= $Page->item->cellAttributes() ?>><span<?= $Page->item->viewAttributes() ?>><?= $Page->item->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { ?>
        <!-- porcentagem -->
        <td data-field="porcentagem"<?= $Page->porcentagem->cellAttributes() ?>><span<?= $Page->porcentagem->viewAttributes() ?>><?= $Page->porcentagem->GroupViewValue ?></span></td>
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
?>
<?php if ($Page->TotalGroups > 0) { ?>
<?php
    $Page->getSummaryValues($Page->modulo->Records); // Get crosstab summaries from records
    $Page->resetAttributes();
    $Page->RowType = RowType::TOTAL;
    $Page->RowTotalType = RowSummary::GROUP;
    $Page->RowTotalSubType = RowTotal::FOOTER;
    $Page->RowGroupLevel = 2;
    $Page->renderRow();
?>
    <!-- Summary modulo (level 2) -->
    <tr<?= $Page->rowAttributes(); ?>>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
        <td colspan="<?= ($Page->GroupColumnCount - 1) ?>"<?= $Page->modulo->cellAttributes() ?>><?= str_replace(["%v", "%c"], [$Page->modulo->GroupViewValue, $Page->modulo->caption()], $Language->phrase("CrosstabSummary")) ?></td>
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
<?php } ?>
<?php
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
    $Page->RowTotalType = RowSummary::PAGE;
    $Page->RowAttrs["class"] = "ew-rpt-page-summary";
    $Page->renderRow();
?>
    <!-- Page Summary -->
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
    <td colspan="<?= $Page->GroupColumnCount ?>"><?= $Page->renderSummaryCaptions("page") ?></td>
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
