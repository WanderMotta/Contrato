<?php

namespace PHPMaker2024\contratos;

// Page object
$RelTesteSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_teste: currentTable } });
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
<form name="frel_testesrch" id="frel_testesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_testesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_teste: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_testesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_testesrch")
        .setPageId("summary")

        // Add fields
        .addFields([
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
            data-select2-id="frel_testesrch_x_idplanilha_custo"
            data-table="rel_teste"
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
        <script>
        loadjs.ready("frel_testesrch", function() {
            var options = {
                name: "x_idplanilha_custo",
                selectId: "frel_testesrch_x_idplanilha_custo",
                ajax: { id: "x_idplanilha_custo", form: "frel_testesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_teste.fields.idplanilha_custo.filterOptions);
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
<div id="gmp_rel_teste" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->idplanilha_custo->Visible) { ?>
    <th data-name="idplanilha_custo" class="<?= $Page->idplanilha_custo->headerCellClass() ?>"><div class="rel_teste_idplanilha_custo"><?= $Page->renderFieldHeader($Page->idplanilha_custo) ?></div></th>
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { ?>
    <th data-name="proposta_idproposta" class="<?= $Page->proposta_idproposta->headerCellClass() ?>"><div class="rel_teste_proposta_idproposta"><?= $Page->renderFieldHeader($Page->proposta_idproposta) ?></div></th>
<?php } ?>
<?php if ($Page->dt_proposta->Visible) { ?>
    <th data-name="dt_proposta" class="<?= $Page->dt_proposta->headerCellClass() ?>"><div class="rel_teste_dt_proposta"><?= $Page->renderFieldHeader($Page->dt_proposta) ?></div></th>
<?php } ?>
<?php if ($Page->qtde_cargos->Visible) { ?>
    <th data-name="qtde_cargos" class="<?= $Page->qtde_cargos->headerCellClass() ?>"><div class="rel_teste_qtde_cargos"><?= $Page->renderFieldHeader($Page->qtde_cargos) ?></div></th>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { ?>
    <th data-name="cargo_idcargo" class="<?= $Page->cargo_idcargo->headerCellClass() ?>"><div class="rel_teste_cargo_idcargo"><?= $Page->renderFieldHeader($Page->cargo_idcargo) ?></div></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div class="rel_teste_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->uniforme->Visible) { ?>
    <th data-name="uniforme" class="<?= $Page->uniforme->headerCellClass() ?>"><div class="rel_teste_uniforme"><?= $Page->renderFieldHeader($Page->uniforme) ?></div></th>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
    <th data-name="qtde" class="<?= $Page->qtde->headerCellClass() ?>"><div class="rel_teste_qtde"><?= $Page->renderFieldHeader($Page->qtde) ?></div></th>
<?php } ?>
<?php if ($Page->periodo_troca->Visible) { ?>
    <th data-name="periodo_troca" class="<?= $Page->periodo_troca->headerCellClass() ?>"><div class="rel_teste_periodo_troca"><?= $Page->renderFieldHeader($Page->periodo_troca) ?></div></th>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { ?>
    <th data-name="vr_unitario" class="<?= $Page->vr_unitario->headerCellClass() ?>"><div class="rel_teste_vr_unitario"><?= $Page->renderFieldHeader($Page->vr_unitario) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_uniforme->Visible) { ?>
    <th data-name="tipo_uniforme" class="<?= $Page->tipo_uniforme->headerCellClass() ?>"><div class="rel_teste_tipo_uniforme"><?= $Page->renderFieldHeader($Page->tipo_uniforme) ?></div></th>
<?php } ?>
<?php if ($Page->vr_anual->Visible) { ?>
    <th data-name="vr_anual" class="<?= $Page->vr_anual->headerCellClass() ?>"><div class="rel_teste_vr_anual"><?= $Page->renderFieldHeader($Page->vr_anual) ?></div></th>
<?php } ?>
<?php if ($Page->vr_mesal->Visible) { ?>
    <th data-name="vr_mesal" class="<?= $Page->vr_mesal->headerCellClass() ?>"><div class="rel_teste_vr_mesal"><?= $Page->renderFieldHeader($Page->vr_mesal) ?></div></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
    <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div class="rel_teste_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
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
<?php if ($Page->idplanilha_custo->Visible) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_idplanilha_custo">
<span<?= $Page->idplanilha_custo->viewAttributes() ?>>
<?= $Page->idplanilha_custo->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_proposta_idproposta">
<span<?= $Page->proposta_idproposta->viewAttributes() ?>>
<?= $Page->proposta_idproposta->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->dt_proposta->Visible) { ?>
        <td data-field="dt_proposta"<?= $Page->dt_proposta->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_dt_proposta">
<span<?= $Page->dt_proposta->viewAttributes() ?>>
<?= $Page->dt_proposta->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->qtde_cargos->Visible) { ?>
        <td data-field="qtde_cargos"<?= $Page->qtde_cargos->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_qtde_cargos">
<span<?= $Page->qtde_cargos->viewAttributes() ?>>
<?= $Page->qtde_cargos->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { ?>
        <td data-field="cargo_idcargo"<?= $Page->cargo_idcargo->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_cargo_idcargo">
<span<?= $Page->cargo_idcargo->viewAttributes() ?>>
<?= $Page->cargo_idcargo->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->uniforme->Visible) { ?>
        <td data-field="uniforme"<?= $Page->uniforme->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_uniforme">
<span<?= $Page->uniforme->viewAttributes() ?>>
<?= $Page->uniforme->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
        <td data-field="qtde"<?= $Page->qtde->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_qtde">
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->periodo_troca->Visible) { ?>
        <td data-field="periodo_troca"<?= $Page->periodo_troca->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_periodo_troca">
<span<?= $Page->periodo_troca->viewAttributes() ?>>
<?= $Page->periodo_troca->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { ?>
        <td data-field="vr_unitario"<?= $Page->vr_unitario->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_vr_unitario">
<span<?= $Page->vr_unitario->viewAttributes() ?>>
<?= $Page->vr_unitario->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->tipo_uniforme->Visible) { ?>
        <td data-field="tipo_uniforme"<?= $Page->tipo_uniforme->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_tipo_uniforme">
<span<?= $Page->tipo_uniforme->viewAttributes() ?>>
<?= $Page->tipo_uniforme->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->vr_anual->Visible) { ?>
        <td data-field="vr_anual"<?= $Page->vr_anual->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_vr_anual">
<span<?= $Page->vr_anual->viewAttributes() ?>>
<?= $Page->vr_anual->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->vr_mesal->Visible) { ?>
        <td data-field="vr_mesal"<?= $Page->vr_mesal->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_vr_mesal">
<span<?= $Page->vr_mesal->viewAttributes() ?>>
<?= $Page->vr_mesal->getViewValue() ?></span>
</template>
</td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>>
<template id="tpx<?= $Page->RecordCount ?>_<?= $Page->RecordCount ?>_rel_teste_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</template>
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
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
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
<?php if ($Page->isExport() || $Page->UseCustomTemplate) { ?>
<div id="tpd_rel_testesummary"></div>
<template id="tpm_rel_testesummary">
<div id="ct_RelTesteSummary"><?php $k = 1; ?><?php
$i = 1;
?>
<?php
for ($j = 1; $j <= $Page->getGroupCount($i); $j++) {
?>
<table style="border-collapse: collapse; width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 33.3333%;">Proposta Nr <slot class="ew-slot" name="tpx<?= $j ?>_<?= $j ?>_rel_teste_proposta_idproposta"></slot></td>
<td style="width: 33.3333%;">Data: <slot class="ew-slot" name="tpx<?= $j ?>_<?= $j ?>_rel_teste_dt_proposta"></slot></td>
<td style="width: 33.3333%;">Consultor: </td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<table style="width: 100%; border-collapse: collapse; margin-left: auto; margin-right: auto;" border="1">
<tbody>
<tr>
<td style="width: 33.3333%;" colspan="3">Dados do Cliente: <slot class="ew-slot" name="tpx<?= $j ?>_<?= $j ?>_rel_teste_uniforme"></slot></td>
</tr>
<tr>
<td style="width: 33.3333%;" colspan="2"><slot class="ew-slot" name="tpx<?= $j ?>_<?= $j ?>_rel_teste_cargo"></slot></td>
<td style="width: 33.3333%;">&nbsp;</td>
</tr>
<tr>
<td style="width: 33.3333%;"><slot class="ew-slot" name="tpx<?= $j ?>_<?= $j ?>_rel_teste_vr_anual"></slot></td>
<td style="width: 33.3333%;">&nbsp;</td>
<td style="width: 33.3333%;">&nbsp;</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<?php
$k++;
}
?>
<?php
if ($Page->ExportPageBreakCount > 0 && $Page->isExport()) {
if ($i % $Page->ExportPageBreakCount == 0 && $i < $cnt) {
?>
<slot class="ew-slot" name="tpb<?= $i ?>_rel_teste"></slot>
<?php
}
}
?>
</div>
</template>
<?php } ?>
<!-- Summary report (end) -->
<?php } ?>
</div>
<!-- /.ew-report -->
<script class="ew-apply-template">
loadjs.ready(ew.applyTemplateId, function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_rel_testesummary", "tpm_rel_testesummary", "rel_testesummary", "<?= $Page->Export ?>", "rel_teste", ew.templateData, false);
    loadjs.done("customtemplate");
});
</script>
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
