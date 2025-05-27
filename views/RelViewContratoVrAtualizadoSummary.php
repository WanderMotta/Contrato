<?php

namespace PHPMaker2024\contratos;

// Page object
$RelViewContratoVrAtualizadoSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_contrato_vr_atualizado: currentTable } });
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
<form name="frel_view_contrato_vr_atualizadosrch" id="frel_view_contrato_vr_atualizadosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_view_contrato_vr_atualizadosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_contrato_vr_atualizado: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_view_contrato_vr_atualizadosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_view_contrato_vr_atualizadosrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["diferenca", [ew.Validators.float], fields.diferenca.isInvalid],
            ["y_diferenca", [ew.Validators.between], false]
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
            "margem": <?= $Page->margem->toClientList($Page) ?>,
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
<?php if ($Page->diferenca->Visible) { // diferenca ?>
<?php
if (!$Page->diferenca->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_diferenca" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->diferenca->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_diferenca" class="ew-search-caption ew-label"><?= $Page->diferenca->caption() ?></label>
            <div class="ew-search-operator">
<select name="z_diferenca" id="z_diferenca" class="form-select ew-operator-select" data-ew-action="search-operator">
<?php foreach ($Page->diferenca->SearchOperators as $opr) { ?>
<option value="<?= HtmlEncode($opr) ?>"<?= $Page->diferenca->AdvancedSearch->SearchOperator == $opr ? " selected" : "" ?>><?= $Language->phrase($opr == "=" ? "EQUAL" : $opr) ?></option>
<?php } ?>
</select>
</div>
        </div>
        <div id="el_rel_view_contrato_vr_atualizado_diferenca" class="ew-search-field">
<input type="<?= $Page->diferenca->getInputTextType() ?>" name="x_diferenca" id="x_diferenca" data-table="rel_view_contrato_vr_atualizado" data-field="x_diferenca" value="<?= $Page->diferenca->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->diferenca->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->diferenca->formatPattern()) ?>"<?= $Page->diferenca->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->diferenca->getErrorMessage() ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and d-none"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_rel_view_contrato_vr_atualizado_diferenca" class="ew-search-field2 d-none">
<input type="<?= $Page->diferenca->getInputTextType() ?>" name="y_diferenca" id="y_diferenca" data-table="rel_view_contrato_vr_atualizado" data-field="x_diferenca" value="<?= $Page->diferenca->EditValue2 ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->diferenca->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->diferenca->formatPattern()) ?>"<?= $Page->diferenca->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->diferenca->getErrorMessage() ?></div>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->margem->Visible) { // margem ?>
<?php
if (!$Page->margem->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_margem" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->margem->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_margem"
            name="x_margem[]"
            class="form-control ew-select<?= $Page->margem->isInvalidClass() ?>"
            data-select2-id="frel_view_contrato_vr_atualizadosrch_x_margem"
            data-table="rel_view_contrato_vr_atualizado"
            data-field="x_margem"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->margem->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->margem->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->margem->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->margem->editAttributes() ?>>
            <?= $Page->margem->selectOptionListHtml("x_margem", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->margem->getErrorMessage() ?></div>
        <script>
        loadjs.ready("frel_view_contrato_vr_atualizadosrch", function() {
            var options = {
                name: "x_margem",
                selectId: "frel_view_contrato_vr_atualizadosrch_x_margem",
                ajax: { id: "x_margem", form: "frel_view_contrato_vr_atualizadosrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_view_contrato_vr_atualizado.fields.margem.filterOptions);
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
<div id="gmp_rel_view_contrato_vr_atualizado" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->idcontrato->Visible) { ?>
    <th data-name="idcontrato" class="<?= $Page->idcontrato->headerCellClass() ?>"><div class="rel_view_contrato_vr_atualizado_idcontrato"><?= $Page->renderFieldHeader($Page->idcontrato) ?></div></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
    <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div class="rel_view_contrato_vr_atualizado_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->vr_cobrado_anterior->Visible) { ?>
    <th data-name="vr_cobrado_anterior" class="<?= $Page->vr_cobrado_anterior->headerCellClass() ?>"><div class="rel_view_contrato_vr_atualizado_vr_cobrado_anterior"><?= $Page->renderFieldHeader($Page->vr_cobrado_anterior) ?></div></th>
<?php } ?>
<?php if ($Page->valor_reajustado->Visible) { ?>
    <th data-name="valor_reajustado" class="<?= $Page->valor_reajustado->headerCellClass() ?>"><div class="rel_view_contrato_vr_atualizado_valor_reajustado"><?= $Page->renderFieldHeader($Page->valor_reajustado) ?></div></th>
<?php } ?>
<?php if ($Page->diferenca->Visible) { ?>
    <th data-name="diferenca" class="<?= $Page->diferenca->headerCellClass() ?>"><div class="rel_view_contrato_vr_atualizado_diferenca"><?= $Page->renderFieldHeader($Page->diferenca) ?></div></th>
<?php } ?>
<?php if ($Page->margem->Visible) { ?>
    <th data-name="margem" class="<?= $Page->margem->headerCellClass() ?>"><div class="rel_view_contrato_vr_atualizado_margem"><?= $Page->renderFieldHeader($Page->margem) ?></div></th>
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
<?php if ($Page->idcontrato->Visible) { ?>
        <td data-field="idcontrato"<?= $Page->idcontrato->cellAttributes() ?>>
<span<?= $Page->idcontrato->viewAttributes() ?>>
<?= $Page->idcontrato->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->vr_cobrado_anterior->Visible) { ?>
        <td data-field="vr_cobrado_anterior"<?= $Page->vr_cobrado_anterior->cellAttributes() ?>>
<span<?= $Page->vr_cobrado_anterior->viewAttributes() ?>>
<?= $Page->vr_cobrado_anterior->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->valor_reajustado->Visible) { ?>
        <td data-field="valor_reajustado"<?= $Page->valor_reajustado->cellAttributes() ?>>
<span<?= $Page->valor_reajustado->viewAttributes() ?>>
<?= $Page->valor_reajustado->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->diferenca->Visible) { ?>
        <td data-field="diferenca"<?= $Page->diferenca->cellAttributes() ?>>
<span<?= $Page->diferenca->viewAttributes() ?>>
<?= $Page->diferenca->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->margem->Visible) { ?>
        <td data-field="margem"<?= $Page->margem->cellAttributes() ?>>
<span<?= $Page->margem->viewAttributes() ?>>
<?= $Page->margem->getViewValue() ?></span>
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
<?php if ($Page->idcontrato->Visible) { ?>
        <td data-field="idcontrato"<?= $Page->idcontrato->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_cobrado_anterior->Visible) { ?>
        <td data-field="vr_cobrado_anterior"<?= $Page->vr_cobrado_anterior->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->vr_cobrado_anterior->viewAttributes() ?>><?= $Page->vr_cobrado_anterior->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->valor_reajustado->Visible) { ?>
        <td data-field="valor_reajustado"<?= $Page->valor_reajustado->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->valor_reajustado->viewAttributes() ?>><?= $Page->valor_reajustado->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->diferenca->Visible) { ?>
        <td data-field="diferenca"<?= $Page->diferenca->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->diferenca->viewAttributes() ?>><?= $Page->diferenca->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->margem->Visible) { ?>
        <td data-field="margem"<?= $Page->margem->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->idcontrato->Visible) { ?>
        <td data-field="idcontrato"<?= $Page->idcontrato->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_cobrado_anterior->Visible) { ?>
        <td data-field="vr_cobrado_anterior"<?= $Page->vr_cobrado_anterior->cellAttributes() ?>><span class="ew-aggregate"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateColon") ?>
<span<?= $Page->vr_cobrado_anterior->viewAttributes() ?>>
<?= $Page->vr_cobrado_anterior->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->valor_reajustado->Visible) { ?>
        <td data-field="valor_reajustado"<?= $Page->valor_reajustado->cellAttributes() ?>><span class="ew-aggregate"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateColon") ?>
<span<?= $Page->valor_reajustado->viewAttributes() ?>>
<?= $Page->valor_reajustado->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->diferenca->Visible) { ?>
        <td data-field="diferenca"<?= $Page->diferenca->cellAttributes() ?>><span class="ew-aggregate"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateColon") ?>
<span<?= $Page->diferenca->viewAttributes() ?>>
<?= $Page->diferenca->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->margem->Visible) { ?>
        <td data-field="margem"<?= $Page->margem->cellAttributes() ?>></td>
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
