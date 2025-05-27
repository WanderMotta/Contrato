<?php

namespace PHPMaker2024\contratos;

// Page object
$RelViewLucroPrejuizoSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_lucro_prejuizo: currentTable } });
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
<form name="frel_view_lucro_prejuizosrch" id="frel_view_lucro_prejuizosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_view_lucro_prejuizosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_lucro_prejuizo: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_view_lucro_prejuizosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_view_lucro_prejuizosrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["cliente", [], fields.cliente.isInvalid],
            ["Diferenca", [ew.Validators.float], fields.Diferenca.isInvalid],
            ["y_Diferenca", [ew.Validators.between], false]
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
            "Resultado": <?= $Page->Resultado->toClientList($Page) ?>,
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
        <div id="el_rel_view_lucro_prejuizo_cliente" class="ew-search-field">
    <select
        id="x_cliente"
        name="x_cliente"
        class="form-control ew-select<?= $Page->cliente->isInvalidClass() ?>"
        data-select2-id="frel_view_lucro_prejuizosrch_x_cliente"
        data-table="rel_view_lucro_prejuizo"
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
loadjs.ready("frel_view_lucro_prejuizosrch", function() {
    var options = { name: "x_cliente", selectId: "frel_view_lucro_prejuizosrch_x_cliente" };
    if (frel_view_lucro_prejuizosrch.lists.cliente?.lookupOptions.length) {
        options.data = { id: "x_cliente", form: "frel_view_lucro_prejuizosrch" };
    } else {
        options.ajax = { id: "x_cliente", form: "frel_view_lucro_prejuizosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_view_lucro_prejuizo.fields.cliente.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->Diferenca->Visible) { // Diferença ?>
<?php
if (!$Page->Diferenca->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_Diferenca" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->Diferenca->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_Diferenca" class="ew-search-caption ew-label"><?= $Page->Diferenca->caption() ?></label>
            <div class="ew-search-operator">
<select name="z_Diferenca" id="z_Diferenca" class="form-select ew-operator-select" data-ew-action="search-operator">
<?php foreach ($Page->Diferenca->SearchOperators as $opr) { ?>
<option value="<?= HtmlEncode($opr) ?>"<?= $Page->Diferenca->AdvancedSearch->SearchOperator == $opr ? " selected" : "" ?>><?= $Language->phrase($opr == "=" ? "EQUAL" : $opr) ?></option>
<?php } ?>
</select>
</div>
        </div>
        <div id="el_rel_view_lucro_prejuizo_Diferenca" class="ew-search-field">
<input type="<?= $Page->Diferenca->getInputTextType() ?>" name="x_Diferenca" id="x_Diferenca" data-table="rel_view_lucro_prejuizo" data-field="x_Diferenca" value="<?= $Page->Diferenca->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->Diferenca->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Diferenca->formatPattern()) ?>"<?= $Page->Diferenca->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Diferenca->getErrorMessage() ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and d-none"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_rel_view_lucro_prejuizo_Diferenca" class="ew-search-field2 d-none">
<input type="<?= $Page->Diferenca->getInputTextType() ?>" name="y_Diferenca" id="y_Diferenca" data-table="rel_view_lucro_prejuizo" data-field="x_Diferenca" value="<?= $Page->Diferenca->EditValue2 ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->Diferenca->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Diferenca->formatPattern()) ?>"<?= $Page->Diferenca->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Diferenca->getErrorMessage() ?></div>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->Resultado->Visible) { // Resultado ?>
<?php
if (!$Page->Resultado->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_Resultado" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->Resultado->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_Resultado"
            name="x_Resultado[]"
            class="form-control ew-select<?= $Page->Resultado->isInvalidClass() ?>"
            data-select2-id="frel_view_lucro_prejuizosrch_x_Resultado"
            data-table="rel_view_lucro_prejuizo"
            data-field="x_Resultado"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->Resultado->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->Resultado->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->Resultado->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->Resultado->editAttributes() ?>>
            <?= $Page->Resultado->selectOptionListHtml("x_Resultado", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->Resultado->getErrorMessage() ?></div>
        <script>
        loadjs.ready("frel_view_lucro_prejuizosrch", function() {
            var options = {
                name: "x_Resultado",
                selectId: "frel_view_lucro_prejuizosrch_x_Resultado",
                ajax: { id: "x_Resultado", form: "frel_view_lucro_prejuizosrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_view_lucro_prejuizo.fields.Resultado.filterOptions);
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
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Middle Container -->
<div id="ew-middle" class="<?= $Page->MiddleContentClass ?>">
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Content Container -->
<div id="ew-content" class="<?= $Page->ContainerClass ?>">
<?php } ?>
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
<div id="gmp_rel_view_lucro_prejuizo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->cliente->Visible) { ?>
    <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>" style="white-space: nowrap;"><div class="rel_view_lucro_prejuizo_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->CustoCalculadoR->Visible) { ?>
    <th data-name="CustoCalculadoR" class="<?= $Page->CustoCalculadoR->headerCellClass() ?>"><div class="rel_view_lucro_prejuizo_CustoCalculadoR"><?= $Page->renderFieldHeader($Page->CustoCalculadoR) ?></div></th>
<?php } ?>
<?php if ($Page->VrCobradoR->Visible) { ?>
    <th data-name="VrCobradoR" class="<?= $Page->VrCobradoR->headerCellClass() ?>"><div class="rel_view_lucro_prejuizo_VrCobradoR"><?= $Page->renderFieldHeader($Page->VrCobradoR) ?></div></th>
<?php } ?>
<?php if ($Page->Diferenca->Visible) { ?>
    <th data-name="Diferenca" class="<?= $Page->Diferenca->headerCellClass() ?>"><div class="rel_view_lucro_prejuizo_Diferenca"><?= $Page->renderFieldHeader($Page->Diferenca) ?></div></th>
<?php } ?>
<?php if ($Page->Margem->Visible) { ?>
    <th data-name="Margem" class="<?= $Page->Margem->headerCellClass() ?>"><div class="rel_view_lucro_prejuizo_Margem"><?= $Page->renderFieldHeader($Page->Margem) ?></div></th>
<?php } ?>
<?php if ($Page->Resultado->Visible) { ?>
    <th data-name="Resultado" class="<?= $Page->Resultado->headerCellClass() ?>"><div class="rel_view_lucro_prejuizo_Resultado"><?= $Page->renderFieldHeader($Page->Resultado) ?></div></th>
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
<?php if ($Page->CustoCalculadoR->Visible) { ?>
        <td data-field="CustoCalculadoR"<?= $Page->CustoCalculadoR->cellAttributes() ?>>
<span<?= $Page->CustoCalculadoR->viewAttributes() ?>>
<?= $Page->CustoCalculadoR->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->VrCobradoR->Visible) { ?>
        <td data-field="VrCobradoR"<?= $Page->VrCobradoR->cellAttributes() ?>>
<span<?= $Page->VrCobradoR->viewAttributes() ?>>
<?= $Page->VrCobradoR->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Diferenca->Visible) { ?>
        <td data-field="Diferenca"<?= $Page->Diferenca->cellAttributes() ?>>
<span<?= $Page->Diferenca->viewAttributes() ?>>
<?= $Page->Diferenca->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Margem->Visible) { ?>
        <td data-field="Margem"<?= $Page->Margem->cellAttributes() ?>>
<span<?= $Page->Margem->viewAttributes() ?>>
<?= $Page->Margem->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Resultado->Visible) { ?>
        <td data-field="Resultado"<?= $Page->Resultado->cellAttributes() ?>>
<span<?= $Page->Resultado->viewAttributes() ?>>
<?= $Page->Resultado->getViewValue() ?></span>
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
<?php if ($Page->CustoCalculadoR->Visible) { ?>
        <td data-field="CustoCalculadoR"<?= $Page->CustoCalculadoR->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->CustoCalculadoR->viewAttributes() ?>><?= $Page->CustoCalculadoR->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->VrCobradoR->Visible) { ?>
        <td data-field="VrCobradoR"<?= $Page->VrCobradoR->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->VrCobradoR->viewAttributes() ?>><?= $Page->VrCobradoR->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->Diferenca->Visible) { ?>
        <td data-field="Diferenca"<?= $Page->Diferenca->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->Diferenca->viewAttributes() ?>><?= $Page->Diferenca->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->Margem->Visible) { ?>
        <td data-field="Margem"<?= $Page->Margem->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->Resultado->Visible) { ?>
        <td data-field="Resultado"<?= $Page->Resultado->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->CustoCalculadoR->Visible) { ?>
        <td data-field="CustoCalculadoR"<?= $Page->CustoCalculadoR->cellAttributes() ?>><span class="ew-aggregate"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateColon") ?>
<span<?= $Page->CustoCalculadoR->viewAttributes() ?>>
<?= $Page->CustoCalculadoR->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->VrCobradoR->Visible) { ?>
        <td data-field="VrCobradoR"<?= $Page->VrCobradoR->cellAttributes() ?>><span class="ew-aggregate"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateColon") ?>
<span<?= $Page->VrCobradoR->viewAttributes() ?>>
<?= $Page->VrCobradoR->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->Diferenca->Visible) { ?>
        <td data-field="Diferenca"<?= $Page->Diferenca->cellAttributes() ?>><span class="ew-aggregate"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateColon") ?>
<span<?= $Page->Diferenca->viewAttributes() ?>>
<?= $Page->Diferenca->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->Margem->Visible) { ?>
        <td data-field="Margem"<?= $Page->Margem->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->Resultado->Visible) { ?>
        <td data-field="Resultado"<?= $Page->Resultado->cellAttributes() ?>></td>
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
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /#ew-content -->
<?php } ?>
<?php
if (!$DashboardReport) {
    // Set up chart drilldown
    $Page->LucroxPrejuizo->DrillDownInPanel = $Page->DrillDownInPanel;
    echo $Page->LucroxPrejuizo->render("ew-chart-bottom");
}
?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /#ew-middle -->
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
