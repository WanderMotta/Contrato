<?php

namespace PHPMaker2024\contratos;

// Page object
$RelViewUnformePlaCustoSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_unforme_pla_custo: currentTable } });
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
<form name="frel_view_unforme_pla_custosrch" id="frel_view_unforme_pla_custosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_view_unforme_pla_custosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_unforme_pla_custo: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_view_unforme_pla_custosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_view_unforme_pla_custosrch")
        .setPageId("summary")
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
            "idplanilha_custo": <?= $Page->idplanilha_custo->toClientList($Page) ?>,
            "cliente": <?= $Page->cliente->toClientList($Page) ?>,
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
            data-select2-id="frel_view_unforme_pla_custosrch_x_idplanilha_custo"
            data-table="rel_view_unforme_pla_custo"
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
        loadjs.ready("frel_view_unforme_pla_custosrch", function() {
            var options = {
                name: "x_idplanilha_custo",
                selectId: "frel_view_unforme_pla_custosrch_x_idplanilha_custo",
                ajax: { id: "x_idplanilha_custo", form: "frel_view_unforme_pla_custosrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_view_unforme_pla_custo.fields.idplanilha_custo.filterOptions);
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
            <label class="ew-search-caption ew-label"><?= $Page->cliente->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_cliente" id="z_cliente" value="LIKE">
</div>
        </div>
        <div id="el_rel_view_unforme_pla_custo_cliente" class="ew-search-field">
    <select
        id="x_cliente"
        name="x_cliente"
        class="form-control ew-select<?= $Page->cliente->isInvalidClass() ?>"
        data-select2-id="frel_view_unforme_pla_custosrch_x_cliente"
        data-table="rel_view_unforme_pla_custo"
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
loadjs.ready("frel_view_unforme_pla_custosrch", function() {
    var options = { name: "x_cliente", selectId: "frel_view_unforme_pla_custosrch_x_cliente" };
    if (frel_view_unforme_pla_custosrch.lists.cliente?.lookupOptions.length) {
        options.data = { id: "x_cliente", form: "frel_view_unforme_pla_custosrch" };
    } else {
        options.ajax = { id: "x_cliente", form: "frel_view_unforme_pla_custosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_view_unforme_pla_custo.fields.cliente.modalLookupOptions);
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
<div id="gmp_rel_view_unforme_pla_custo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->proposta_idproposta->Visible) { ?>
    <?php if ($Page->proposta_idproposta->ShowGroupHeaderAsRow) { ?>
    <th data-name="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->proposta_idproposta->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="proposta_idproposta" class="<?= $Page->proposta_idproposta->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_proposta_idproposta"><?= $Page->renderFieldHeader($Page->proposta_idproposta) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
    <?php if ($Page->idplanilha_custo->ShowGroupHeaderAsRow) { ?>
    <th data-name="idplanilha_custo">&nbsp;</th>
    <?php } else { ?>
    <th data-name="idplanilha_custo" class="<?= $Page->idplanilha_custo->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_idplanilha_custo"><?= $Page->renderFieldHeader($Page->idplanilha_custo) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->qtde_cargos->Visible) { ?>
    <?php if ($Page->qtde_cargos->ShowGroupHeaderAsRow) { ?>
    <th data-name="qtde_cargos">&nbsp;</th>
    <?php } else { ?>
    <th data-name="qtde_cargos" class="<?= $Page->qtde_cargos->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_qtde_cargos"><?= $Page->renderFieldHeader($Page->qtde_cargos) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <?php if ($Page->cargo->ShowGroupHeaderAsRow) { ?>
    <th data-name="cargo">&nbsp;</th>
    <?php } else { ?>
    <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
    <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->uniforme->Visible) { ?>
    <th data-name="uniforme" class="<?= $Page->uniforme->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_uniforme"><?= $Page->renderFieldHeader($Page->uniforme) ?></div></th>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
    <th data-name="qtde" class="<?= $Page->qtde->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_qtde"><?= $Page->renderFieldHeader($Page->qtde) ?></div></th>
<?php } ?>
<?php if ($Page->periodo_troca->Visible) { ?>
    <th data-name="periodo_troca" class="<?= $Page->periodo_troca->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_periodo_troca"><?= $Page->renderFieldHeader($Page->periodo_troca) ?></div></th>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { ?>
    <th data-name="vr_unitario" class="<?= $Page->vr_unitario->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_vr_unitario"><?= $Page->renderFieldHeader($Page->vr_unitario) ?></div></th>
<?php } ?>
<?php if ($Page->vr_anual->Visible) { ?>
    <th data-name="vr_anual" class="<?= $Page->vr_anual->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_vr_anual"><?= $Page->renderFieldHeader($Page->vr_anual) ?></div></th>
<?php } ?>
<?php if ($Page->vr_mesal->Visible) { ?>
    <th data-name="vr_mesal" class="<?= $Page->vr_mesal->headerCellClass() ?>"><div class="rel_view_unforme_pla_custo_vr_mesal"><?= $Page->renderFieldHeader($Page->vr_mesal) ?></div></th>
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
    $where = DetailFilterSql($Page->proposta_idproposta, $Page->getSqlFirstGroupField(), $Page->proposta_idproposta->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->proposta_idproposta->Records = &$Page->DetailRecords;
    $Page->proposta_idproposta->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->proposta_idproposta->getCnt($Page->proposta_idproposta->Records); // Get record count
?>
<?php if ($Page->proposta_idproposta->Visible && $Page->proposta_idproposta->ShowGroupHeaderAsRow) { ?>
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
<?php if ($Page->proposta_idproposta->Visible) { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->proposta_idproposta->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="proposta_idproposta" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->proposta_idproposta->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_unforme_pla_custo_proposta_idproposta"><?= $Page->renderFieldHeader($Page->proposta_idproposta) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->proposta_idproposta->viewAttributes() ?>><?= $Page->proposta_idproposta->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->proposta_idproposta->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->idplanilha_custo->getDistinctValues($Page->proposta_idproposta->Records, $Page->idplanilha_custo->getSort());
    $Page->setGroupCount(count($Page->idplanilha_custo->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->idplanilha_custo->DistinctValues as $idplanilha_custo) { // Load records for this distinct value
        $Page->idplanilha_custo->setGroupValue($idplanilha_custo); // Set group value
        $Page->idplanilha_custo->getDistinctRecords($Page->proposta_idproposta->Records, $Page->idplanilha_custo->groupValue());
        $Page->idplanilha_custo->LevelBreak = true; // Set field level break
        $Page->GroupCounter[2]++;
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
        $Page->RowGroupLevel = 2;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->proposta_idproposta->Visible) { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->idplanilha_custo->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="idplanilha_custo" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->idplanilha_custo->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_unforme_pla_custo_idplanilha_custo"><?= $Page->renderFieldHeader($Page->idplanilha_custo) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->idplanilha_custo->viewAttributes() ?>><?= $Page->idplanilha_custo->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->idplanilha_custo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->qtde_cargos->getDistinctValues($Page->idplanilha_custo->Records, $Page->qtde_cargos->getSort());
    $Page->setGroupCount(count($Page->qtde_cargos->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2]);
    $Page->GroupCounter[3] = 0; // Init group count index
    foreach ($Page->qtde_cargos->DistinctValues as $qtde_cargos) { // Load records for this distinct value
        $Page->qtde_cargos->setGroupValue($qtde_cargos); // Set group value
        $Page->qtde_cargos->getDistinctRecords($Page->idplanilha_custo->Records, $Page->qtde_cargos->groupValue());
        $Page->qtde_cargos->LevelBreak = true; // Set field level break
        $Page->GroupCounter[3]++;
        $Page->qtde_cargos->getCnt($Page->qtde_cargos->Records); // Get record count
?>
<?php if ($Page->qtde_cargos->Visible && $Page->qtde_cargos->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->qtde_cargos->setDbValue($qtde_cargos); // Set current value for qtde_cargos
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 3;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->proposta_idproposta->Visible) { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->qtde_cargos->Visible) { ?>
        <td data-field="qtde_cargos"<?= $Page->qtde_cargos->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->qtde_cargos->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="qtde_cargos" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 3) ?>"<?= $Page->qtde_cargos->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_unforme_pla_custo_qtde_cargos"><?= $Page->renderFieldHeader($Page->qtde_cargos) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->qtde_cargos->viewAttributes() ?>><?= $Page->qtde_cargos->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->qtde_cargos->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->cargo->getDistinctValues($Page->qtde_cargos->Records, $Page->cargo->getSort());
    $Page->setGroupCount(count($Page->cargo->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3]);
    $Page->GroupCounter[4] = 0; // Init group count index
    foreach ($Page->cargo->DistinctValues as $cargo) { // Load records for this distinct value
        $Page->cargo->setGroupValue($cargo); // Set group value
        $Page->cargo->getDistinctRecords($Page->qtde_cargos->Records, $Page->cargo->groupValue());
        $Page->cargo->LevelBreak = true; // Set field level break
        $Page->GroupCounter[4]++;
        $Page->cargo->getCnt($Page->cargo->Records); // Get record count
        $Page->setGroupCount($Page->cargo->Count, $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3], $Page->GroupCounter[4]);
?>
<?php if ($Page->cargo->Visible && $Page->cargo->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->cargo->setDbValue($cargo); // Set current value for cargo
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 4;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->proposta_idproposta->Visible) { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->qtde_cargos->Visible) { ?>
        <td data-field="qtde_cargos"<?= $Page->qtde_cargos->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->cargo->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="cargo" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 4) ?>"<?= $Page->cargo->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_unforme_pla_custo_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->cargo->viewAttributes() ?>><?= $Page->cargo->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->cargo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->cargo->Records as $record) {
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
<?php if ($Page->proposta_idproposta->Visible) { ?>
    <?php if ($Page->proposta_idproposta->ShowGroupHeaderAsRow) { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>><span<?= $Page->proposta_idproposta->viewAttributes() ?>><?= $Page->proposta_idproposta->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
    <?php if ($Page->idplanilha_custo->ShowGroupHeaderAsRow) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>><span<?= $Page->idplanilha_custo->viewAttributes() ?>><?= $Page->idplanilha_custo->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->qtde_cargos->Visible) { ?>
    <?php if ($Page->qtde_cargos->ShowGroupHeaderAsRow) { ?>
        <td data-field="qtde_cargos"<?= $Page->qtde_cargos->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="qtde_cargos"<?= $Page->qtde_cargos->cellAttributes() ?>><span<?= $Page->qtde_cargos->viewAttributes() ?>><?= $Page->qtde_cargos->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <?php if ($Page->cargo->ShowGroupHeaderAsRow) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>><span<?= $Page->cargo->viewAttributes() ?>><?= $Page->cargo->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->uniforme->Visible) { ?>
        <td data-field="uniforme"<?= $Page->uniforme->cellAttributes() ?>>
<span<?= $Page->uniforme->viewAttributes() ?>>
<?= $Page->uniforme->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
        <td data-field="qtde"<?= $Page->qtde->cellAttributes() ?>>
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->periodo_troca->Visible) { ?>
        <td data-field="periodo_troca"<?= $Page->periodo_troca->cellAttributes() ?>>
<span<?= $Page->periodo_troca->viewAttributes() ?>>
<?= $Page->periodo_troca->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { ?>
        <td data-field="vr_unitario"<?= $Page->vr_unitario->cellAttributes() ?>>
<span<?= $Page->vr_unitario->viewAttributes() ?>>
<?= $Page->vr_unitario->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->vr_anual->Visible) { ?>
        <td data-field="vr_anual"<?= $Page->vr_anual->cellAttributes() ?>>
<span<?= $Page->vr_anual->viewAttributes() ?>>
<?= $Page->vr_anual->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->vr_mesal->Visible) { ?>
        <td data-field="vr_mesal"<?= $Page->vr_mesal->cellAttributes() ?>>
<span<?= $Page->vr_mesal->viewAttributes() ?>>
<?= $Page->vr_mesal->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
    }
    } // End group level 3
    } // End group level 2
?>
<?php if ($Page->TotalGroups > 0) { ?>
<?php
    $Page->qtde->getSum($Page->idplanilha_custo->Records, false); // Get Sum
    $Page->vr_anual->getSum($Page->idplanilha_custo->Records, false); // Get Sum
    $Page->vr_mesal->getSum($Page->idplanilha_custo->Records, false); // Get Sum
    $Page->resetAttributes();
    $Page->RowType = RowType::TOTAL;
    $Page->RowTotalType = RowSummary::GROUP;
    $Page->RowTotalSubType = RowTotal::FOOTER;
    $Page->RowGroupLevel = 2;
    $Page->renderRow();
?>
<?php if ($Page->idplanilha_custo->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->proposta_idproposta->Visible) { ?>
    <?php if ($Page->proposta_idproposta->ShowGroupHeaderAsRow) { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 1) { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->proposta_idproposta->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { ?>
    <?php if ($Page->idplanilha_custo->ShowGroupHeaderAsRow) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 2) { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->idplanilha_custo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->qtde_cargos->Visible) { ?>
    <?php if ($Page->qtde_cargos->ShowGroupHeaderAsRow) { ?>
        <td data-field="qtde_cargos"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 3) { ?>
        <td data-field="qtde_cargos"<?= $Page->idplanilha_custo->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="qtde_cargos"<?= $Page->idplanilha_custo->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->qtde_cargos->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <?php if ($Page->cargo->ShowGroupHeaderAsRow) { ?>
        <td data-field="cargo"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
    <?php } elseif ($Page->RowGroupLevel != 4) { ?>
        <td data-field="cargo"<?= $Page->idplanilha_custo->cellAttributes() ?>>
        </td>
    <?php } else { ?>
        <td data-field="cargo"<?= $Page->idplanilha_custo->cellAttributes() ?>>
            <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->cargo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span></span>
        </td>
    <?php } ?>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->uniforme->Visible) { ?>
        <td data-field="uniforme"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
        <td data-field="qtde"<?= $Page->idplanilha_custo->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->qtde->viewAttributes() ?>><?= $Page->qtde->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->periodo_troca->Visible) { ?>
        <td data-field="periodo_troca"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { ?>
        <td data-field="vr_unitario"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_anual->Visible) { ?>
        <td data-field="vr_anual"<?= $Page->idplanilha_custo->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->vr_anual->viewAttributes() ?>><?= $Page->vr_anual->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->vr_mesal->Visible) { ?>
        <td data-field="vr_mesal"<?= $Page->idplanilha_custo->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->vr_mesal->viewAttributes() ?>><?= $Page->vr_mesal->SumViewValue ?></span></span></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->proposta_idproposta->Visible) { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->SubGroupColumnCount + $Page->DetailColumnCount > 0) { ?>
        <td colspan="<?= ($Page->SubGroupColumnCount + $Page->DetailColumnCount) ?>"<?= $Page->idplanilha_custo->cellAttributes() ?>><?= str_replace(["%v", "%c"], [$Page->idplanilha_custo->GroupViewValue, $Page->idplanilha_custo->caption()], $Language->phrase("RptSumHead")) ?> <span class="ew-dir-ltr">(<?= FormatNumber($Page->idplanilha_custo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td>
<?php } ?>
    </tr>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->proposta_idproposta->Visible) { ?>
        <td data-field="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= ($Page->GroupColumnCount - 1) ?>"<?= $Page->idplanilha_custo->cellAttributes() ?>><?= $Language->phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->uniforme->Visible) { ?>
        <td data-field="uniforme"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
        <td data-field="qtde"<?= $Page->qtde->cellAttributes() ?>>
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->periodo_troca->Visible) { ?>
        <td data-field="periodo_troca"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { ?>
        <td data-field="vr_unitario"<?= $Page->idplanilha_custo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_anual->Visible) { ?>
        <td data-field="vr_anual"<?= $Page->vr_anual->cellAttributes() ?>>
<span<?= $Page->vr_anual->viewAttributes() ?>>
<?= $Page->vr_anual->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->vr_mesal->Visible) { ?>
        <td data-field="vr_mesal"<?= $Page->vr_mesal->cellAttributes() ?>>
<span<?= $Page->vr_mesal->viewAttributes() ?>>
<?= $Page->vr_mesal->SumViewValue ?></span>
</td>
<?php } ?>
    </tr>
<?php } ?>
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
    $Page->RowTotalType = RowSummary::GRAND;
    $Page->RowTotalSubType = RowTotal::FOOTER;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
<?php if ($Page->proposta_idproposta->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->uniforme->Visible) { ?>
        <td data-field="uniforme"<?= $Page->uniforme->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
        <td data-field="qtde"<?= $Page->qtde->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->qtde->viewAttributes() ?>><?= $Page->qtde->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->periodo_troca->Visible) { ?>
        <td data-field="periodo_troca"<?= $Page->periodo_troca->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { ?>
        <td data-field="vr_unitario"<?= $Page->vr_unitario->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_anual->Visible) { ?>
        <td data-field="vr_anual"<?= $Page->vr_anual->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->vr_anual->viewAttributes() ?>><?= $Page->vr_anual->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->vr_mesal->Visible) { ?>
        <td data-field="vr_mesal"<?= $Page->vr_mesal->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->vr_mesal->viewAttributes() ?>><?= $Page->vr_mesal->SumViewValue ?></span></span></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"><?= $Language->phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->uniforme->Visible) { ?>
        <td data-field="uniforme"<?= $Page->uniforme->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->qtde->Visible) { ?>
        <td data-field="qtde"<?= $Page->qtde->cellAttributes() ?>>
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->periodo_troca->Visible) { ?>
        <td data-field="periodo_troca"<?= $Page->periodo_troca->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { ?>
        <td data-field="vr_unitario"<?= $Page->vr_unitario->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->vr_anual->Visible) { ?>
        <td data-field="vr_anual"<?= $Page->vr_anual->cellAttributes() ?>>
<span<?= $Page->vr_anual->viewAttributes() ?>>
<?= $Page->vr_anual->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->vr_mesal->Visible) { ?>
        <td data-field="vr_mesal"<?= $Page->vr_mesal->cellAttributes() ?>>
<span<?= $Page->vr_mesal->viewAttributes() ?>>
<?= $Page->vr_mesal->SumViewValue ?></span>
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
