<?php

namespace PHPMaker2024\contratos;

// Page object
$RelViewRelInsumosContratosSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_rel_insumos_contratos: currentTable } });
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
<form name="frel_view_rel_insumos_contratossrch" id="frel_view_rel_insumos_contratossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_view_rel_insumos_contratossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_rel_insumos_contratos: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_view_rel_insumos_contratossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_view_rel_insumos_contratossrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["cliente", [], fields.cliente.isInvalid],
            ["insumo", [], fields.insumo.isInvalid],
            ["tipo_insumo", [], fields.tipo_insumo.isInvalid]
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
            "insumo": <?= $Page->insumo->toClientList($Page) ?>,
            "tipo_insumo": <?= $Page->tipo_insumo->toClientList($Page) ?>,
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
        <div id="el_rel_view_rel_insumos_contratos_cliente" class="ew-search-field">
    <select
        id="x_cliente"
        name="x_cliente"
        class="form-control ew-select<?= $Page->cliente->isInvalidClass() ?>"
        data-select2-id="frel_view_rel_insumos_contratossrch_x_cliente"
        data-table="rel_view_rel_insumos_contratos"
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
loadjs.ready("frel_view_rel_insumos_contratossrch", function() {
    var options = { name: "x_cliente", selectId: "frel_view_rel_insumos_contratossrch_x_cliente" };
    if (frel_view_rel_insumos_contratossrch.lists.cliente?.lookupOptions.length) {
        options.data = { id: "x_cliente", form: "frel_view_rel_insumos_contratossrch" };
    } else {
        options.ajax = { id: "x_cliente", form: "frel_view_rel_insumos_contratossrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_view_rel_insumos_contratos.fields.cliente.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->insumo->Visible) { // insumo ?>
<?php
if (!$Page->insumo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_insumo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->insumo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_insumo" class="ew-search-caption ew-label"><?= $Page->insumo->caption() ?></label>
        </div>
        <div id="el_rel_view_rel_insumos_contratos_insumo" class="ew-search-field">
    <select
        id="x_insumo"
        name="x_insumo"
        class="form-control ew-select<?= $Page->insumo->isInvalidClass() ?>"
        data-select2-id="frel_view_rel_insumos_contratossrch_x_insumo"
        data-table="rel_view_rel_insumos_contratos"
        data-field="x_insumo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->insumo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->insumo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->insumo->getPlaceHolder()) ?>"
        <?= $Page->insumo->editAttributes() ?>>
        <?= $Page->insumo->selectOptionListHtml("x_insumo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->insumo->getErrorMessage() ?></div>
<?= $Page->insumo->Lookup->getParamTag($Page, "p_x_insumo") ?>
<script>
loadjs.ready("frel_view_rel_insumos_contratossrch", function() {
    var options = { name: "x_insumo", selectId: "frel_view_rel_insumos_contratossrch_x_insumo" };
    if (frel_view_rel_insumos_contratossrch.lists.insumo?.lookupOptions.length) {
        options.data = { id: "x_insumo", form: "frel_view_rel_insumos_contratossrch" };
    } else {
        options.ajax = { id: "x_insumo", form: "frel_view_rel_insumos_contratossrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_view_rel_insumos_contratos.fields.insumo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
<?php
if (!$Page->tipo_insumo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_tipo_insumo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->tipo_insumo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->tipo_insumo->caption() ?></label>
        </div>
        <div id="el_rel_view_rel_insumos_contratos_tipo_insumo" class="ew-search-field">
<template id="tp_x_tipo_insumo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="rel_view_rel_insumos_contratos" data-field="x_tipo_insumo" name="x_tipo_insumo" id="x_tipo_insumo"<?= $Page->tipo_insumo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo_insumo" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo_insumo"
    name="x_tipo_insumo"
    value="<?= HtmlEncode($Page->tipo_insumo->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_insumo"
    data-target="dsl_x_tipo_insumo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_insumo->isInvalidClass() ?>"
    data-table="rel_view_rel_insumos_contratos"
    data-field="x_tipo_insumo"
    data-value-separator="<?= $Page->tipo_insumo->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_insumo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->tipo_insumo->getErrorMessage() ?></div>
<?= $Page->tipo_insumo->Lookup->getParamTag($Page, "p_x_tipo_insumo") ?>
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
while ($Page->RecordCount < count($Page->DetailRecords) && $Page->RecordCount < $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<div class="<?= $Page->ReportContainerClass ?>">
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Top pager -->
<div class="card-header ew-grid-upper-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_rel_view_rel_insumos_contratos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->cliente->Visible) { ?>
    <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>" style="white-space: nowrap;"><div class="rel_view_rel_insumos_contratos_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->insumo->Visible) { ?>
    <th data-name="insumo" class="<?= $Page->insumo->headerCellClass() ?>" style="white-space: nowrap;"><div class="rel_view_rel_insumos_contratos_insumo"><?= $Page->renderFieldHeader($Page->insumo) ?></div></th>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
    <th data-name="qtde" class="<?= $Page->qtde->headerCellClass() ?>"><div class="rel_view_rel_insumos_contratos_qtde"><?= $Page->renderFieldHeader($Page->qtde) ?></div></th>
<?php } ?>
<?php if ($Page->VrMensal->Visible) { ?>
    <th data-name="VrMensal" class="<?= $Page->VrMensal->headerCellClass() ?>"><div class="rel_view_rel_insumos_contratos_VrMensal"><?= $Page->renderFieldHeader($Page->VrMensal) ?></div></th>
<?php } ?>
<?php if ($Page->VrTotal->Visible) { ?>
    <th data-name="VrTotal" class="<?= $Page->VrTotal->headerCellClass() ?>"><div class="rel_view_rel_insumos_contratos_VrTotal"><?= $Page->renderFieldHeader($Page->VrTotal) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_insumo->Visible) { ?>
    <th data-name="tipo_insumo" class="<?= $Page->tipo_insumo->headerCellClass() ?>"><div class="rel_view_rel_insumos_contratos_tipo_insumo"><?= $Page->renderFieldHeader($Page->tipo_insumo) ?></div></th>
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
    $Page->loadRowValues($Page->DetailRecords[$Page->RecordCount]);
    $Page->RecordCount++;
    $Page->RecordIndex++;
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = RowType::DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->insumo->Visible) { ?>
        <td data-field="insumo"<?= $Page->insumo->cellAttributes() ?>>
<span<?= $Page->insumo->viewAttributes() ?>>
<?= $Page->insumo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
        <td data-field="qtde"<?= $Page->qtde->cellAttributes() ?>>
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->VrMensal->Visible) { ?>
        <td data-field="VrMensal"<?= $Page->VrMensal->cellAttributes() ?>>
<span<?= $Page->VrMensal->viewAttributes() ?>>
<?= $Page->VrMensal->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->VrTotal->Visible) { ?>
        <td data-field="VrTotal"<?= $Page->VrTotal->cellAttributes() ?>>
<span<?= $Page->VrTotal->viewAttributes() ?>>
<?= $Page->VrTotal->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tipo_insumo->Visible) { ?>
        <td data-field="tipo_insumo"<?= $Page->tipo_insumo->cellAttributes() ?>>
<span<?= $Page->tipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
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
<?php if ($Page->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->insumo->Visible) { ?>
        <td data-field="insumo"<?= $Page->insumo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
        <td data-field="qtde"<?= $Page->qtde->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->VrMensal->Visible) { ?>
        <td data-field="VrMensal"<?= $Page->VrMensal->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->VrTotal->Visible) { ?>
        <td data-field="VrTotal"<?= $Page->VrTotal->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->VrTotal->viewAttributes() ?>><?= $Page->VrTotal->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->tipo_insumo->Visible) { ?>
        <td data-field="tipo_insumo"<?= $Page->tipo_insumo->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->insumo->Visible) { ?>
        <td data-field="insumo"<?= $Page->insumo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
        <td data-field="qtde"<?= $Page->qtde->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->VrMensal->Visible) { ?>
        <td data-field="VrMensal"<?= $Page->VrMensal->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->VrTotal->Visible) { ?>
        <td data-field="VrTotal"<?= $Page->VrTotal->cellAttributes() ?>><span class="ew-aggregate"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateColon") ?>
<span<?= $Page->VrTotal->viewAttributes() ?>>
<?= $Page->VrTotal->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->tipo_insumo->Visible) { ?>
        <td data-field="tipo_insumo"<?= $Page->tipo_insumo->cellAttributes() ?>></td>
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
