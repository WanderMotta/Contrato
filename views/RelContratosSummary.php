<?php

namespace PHPMaker2024\contratos;

// Page object
$RelContratosSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_contratos: currentTable } });
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
<form name="frel_contratossrch" id="frel_contratossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_contratossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_contratos: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_contratossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_contratossrch")
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
            "escala": <?= $Page->escala->toClientList($Page) ?>,
            "intrajornada_tipo": <?= $Page->intrajornada_tipo->toClientList($Page) ?>,
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
        <div id="el_rel_contratos_cliente" class="ew-search-field">
    <select
        id="x_cliente"
        name="x_cliente"
        class="form-control ew-select<?= $Page->cliente->isInvalidClass() ?>"
        data-select2-id="frel_contratossrch_x_cliente"
        data-table="rel_contratos"
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
loadjs.ready("frel_contratossrch", function() {
    var options = { name: "x_cliente", selectId: "frel_contratossrch_x_cliente" };
    if (frel_contratossrch.lists.cliente?.lookupOptions.length) {
        options.data = { id: "x_cliente", form: "frel_contratossrch" };
    } else {
        options.ajax = { id: "x_cliente", form: "frel_contratossrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_contratos.fields.cliente.modalLookupOptions);
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
        <div id="el_rel_contratos_cargo" class="ew-search-field">
    <select
        id="x_cargo"
        name="x_cargo"
        class="form-control ew-select<?= $Page->cargo->isInvalidClass() ?>"
        data-select2-id="frel_contratossrch_x_cargo"
        data-table="rel_contratos"
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
loadjs.ready("frel_contratossrch", function() {
    var options = { name: "x_cargo", selectId: "frel_contratossrch_x_cargo" };
    if (frel_contratossrch.lists.cargo?.lookupOptions.length) {
        options.data = { id: "x_cargo", form: "frel_contratossrch" };
    } else {
        options.ajax = { id: "x_cargo", form: "frel_contratossrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rel_contratos.fields.cargo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->escala->Visible) { // escala ?>
<?php
if (!$Page->escala->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_escala" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->escala->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_escala"
            name="x_escala[]"
            class="form-control ew-select<?= $Page->escala->isInvalidClass() ?>"
            data-select2-id="frel_contratossrch_x_escala"
            data-table="rel_contratos"
            data-field="x_escala"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->escala->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->escala->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->escala->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->escala->editAttributes() ?>>
            <?= $Page->escala->selectOptionListHtml("x_escala", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->escala->getErrorMessage() ?></div>
        <script>
        loadjs.ready("frel_contratossrch", function() {
            var options = {
                name: "x_escala",
                selectId: "frel_contratossrch_x_escala",
                ajax: { id: "x_escala", form: "frel_contratossrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_contratos.fields.escala.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->intrajornada_tipo->Visible) { // intrajornada_tipo ?>
<?php
if (!$Page->intrajornada_tipo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_intrajornada_tipo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->intrajornada_tipo->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_intrajornada_tipo"
            name="x_intrajornada_tipo[]"
            class="form-control ew-select<?= $Page->intrajornada_tipo->isInvalidClass() ?>"
            data-select2-id="frel_contratossrch_x_intrajornada_tipo"
            data-table="rel_contratos"
            data-field="x_intrajornada_tipo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->intrajornada_tipo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->intrajornada_tipo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->intrajornada_tipo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->intrajornada_tipo->editAttributes() ?>>
            <?= $Page->intrajornada_tipo->selectOptionListHtml("x_intrajornada_tipo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->intrajornada_tipo->getErrorMessage() ?></div>
        <script>
        loadjs.ready("frel_contratossrch", function() {
            var options = {
                name: "x_intrajornada_tipo",
                selectId: "frel_contratossrch_x_intrajornada_tipo",
                ajax: { id: "x_intrajornada_tipo", form: "frel_contratossrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_contratos.fields.intrajornada_tipo.filterOptions);
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
<div id="gmp_rel_contratos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->cliente->Visible) { ?>
    <?php if ($Page->cliente->ShowGroupHeaderAsRow) { ?>
    <th data-name="cliente"<?= $Page->cliente->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->cliente->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>" style="white-space: nowrap;"><div class="rel_contratos_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->valor->Visible) { ?>
    <?php if ($Page->valor->ShowGroupHeaderAsRow) { ?>
    <th data-name="valor">&nbsp;</th>
    <?php } else { ?>
    <th data-name="valor" class="<?= $Page->valor->headerCellClass() ?>"><div class="rel_contratos_valor"><?= $Page->renderFieldHeader($Page->valor) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->insumos->Visible) { ?>
    <?php if ($Page->insumos->ShowGroupHeaderAsRow) { ?>
    <th data-name="insumos">&nbsp;</th>
    <?php } else { ?>
    <th data-name="insumos" class="<?= $Page->insumos->headerCellClass() ?>"><div class="rel_contratos_insumos"><?= $Page->renderFieldHeader($Page->insumos) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->quantidade->Visible) { ?>
    <th data-name="quantidade" class="<?= $Page->quantidade->headerCellClass() ?>"><div class="rel_contratos_quantidade"><?= $Page->renderFieldHeader($Page->quantidade) ?></div></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>" style="white-space: nowrap;"><div class="rel_contratos_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->salario->Visible) { ?>
    <th data-name="salario" class="<?= $Page->salario->headerCellClass() ?>"><div class="rel_contratos_salario"><?= $Page->renderFieldHeader($Page->salario) ?></div></th>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { ?>
    <th data-name="acumulo_funcao" class="<?= $Page->acumulo_funcao->headerCellClass() ?>"><div class="rel_contratos_acumulo_funcao"><?= $Page->renderFieldHeader($Page->acumulo_funcao) ?></div></th>
<?php } ?>
<?php if ($Page->escala->Visible) { ?>
    <th data-name="escala" class="<?= $Page->escala->headerCellClass() ?>"><div class="rel_contratos_escala"><?= $Page->renderFieldHeader($Page->escala) ?></div></th>
<?php } ?>
<?php if ($Page->periodo->Visible) { ?>
    <th data-name="periodo" class="<?= $Page->periodo->headerCellClass() ?>"><div class="rel_contratos_periodo"><?= $Page->renderFieldHeader($Page->periodo) ?></div></th>
<?php } ?>
<?php if ($Page->jornada->Visible) { ?>
    <th data-name="jornada" class="<?= $Page->jornada->headerCellClass() ?>"><div class="rel_contratos_jornada"><?= $Page->renderFieldHeader($Page->jornada) ?></div></th>
<?php } ?>
<?php if ($Page->intrajornada_tipo->Visible) { ?>
    <th data-name="intrajornada_tipo" class="<?= $Page->intrajornada_tipo->headerCellClass() ?>"><div class="rel_contratos_intrajornada_tipo"><?= $Page->renderFieldHeader($Page->intrajornada_tipo) ?></div></th>
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
            <span class="ew-summary-caption rel_contratos_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->cliente->viewAttributes() ?>><?= $Page->cliente->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->cliente->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->valor->getDistinctValues($Page->cliente->Records, $Page->valor->getSort());
    $Page->setGroupCount(count($Page->valor->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->valor->DistinctValues as $valor) { // Load records for this distinct value
        $Page->valor->setGroupValue($valor); // Set group value
        $Page->valor->getDistinctRecords($Page->cliente->Records, $Page->valor->groupValue());
        $Page->valor->LevelBreak = true; // Set field level break
        $Page->GroupCounter[2]++;
        $Page->valor->getCnt($Page->valor->Records); // Get record count
?>
<?php if ($Page->valor->Visible && $Page->valor->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->valor->setDbValue($valor); // Set current value for valor
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
<?php if ($Page->valor->Visible) { ?>
        <td data-field="valor"<?= $Page->valor->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->valor->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="valor" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->valor->cellAttributes() ?>>
            <span class="ew-summary-caption rel_contratos_valor"><?= $Page->renderFieldHeader($Page->valor) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->valor->viewAttributes() ?>><?= $Page->valor->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->valor->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->insumos->getDistinctValues($Page->valor->Records, $Page->insumos->getSort());
    $Page->setGroupCount(count($Page->insumos->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2]);
    $Page->GroupCounter[3] = 0; // Init group count index
    foreach ($Page->insumos->DistinctValues as $insumos) { // Load records for this distinct value
        $Page->insumos->setGroupValue($insumos); // Set group value
        $Page->insumos->getDistinctRecords($Page->valor->Records, $Page->insumos->groupValue());
        $Page->insumos->LevelBreak = true; // Set field level break
        $Page->GroupCounter[3]++;
        $Page->insumos->getCnt($Page->insumos->Records); // Get record count
        $Page->setGroupCount($Page->insumos->Count, $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3]);
?>
<?php if ($Page->insumos->Visible && $Page->insumos->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->insumos->setDbValue($insumos); // Set current value for insumos
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
<?php if ($Page->valor->Visible) { ?>
        <td data-field="valor"<?= $Page->valor->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->insumos->Visible) { ?>
        <td data-field="insumos"<?= $Page->insumos->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->insumos->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="insumos" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 3) ?>"<?= $Page->insumos->cellAttributes() ?>>
            <span class="ew-summary-caption rel_contratos_insumos"><?= $Page->renderFieldHeader($Page->insumos) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->insumos->viewAttributes() ?>><?= $Page->insumos->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->insumos->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->insumos->Records as $record) {
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
<?php if ($Page->valor->Visible) { ?>
    <?php if ($Page->valor->ShowGroupHeaderAsRow) { ?>
        <td data-field="valor"<?= $Page->valor->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="valor"<?= $Page->valor->cellAttributes() ?>><span<?= $Page->valor->viewAttributes() ?>><?= $Page->valor->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->insumos->Visible) { ?>
    <?php if ($Page->insumos->ShowGroupHeaderAsRow) { ?>
        <td data-field="insumos"<?= $Page->insumos->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="insumos"<?= $Page->insumos->cellAttributes() ?>><span<?= $Page->insumos->viewAttributes() ?>><?= $Page->insumos->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->quantidade->Visible) { ?>
        <td data-field="quantidade"<?= $Page->quantidade->cellAttributes() ?>>
<span<?= $Page->quantidade->viewAttributes() ?>>
<?= $Page->quantidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->salario->Visible) { ?>
        <td data-field="salario"<?= $Page->salario->cellAttributes() ?>>
<span<?= $Page->salario->viewAttributes() ?>>
<?= $Page->salario->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { ?>
        <td data-field="acumulo_funcao"<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span<?= $Page->acumulo_funcao->viewAttributes() ?>>
<?= $Page->acumulo_funcao->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->escala->Visible) { ?>
        <td data-field="escala"<?= $Page->escala->cellAttributes() ?>>
<span<?= $Page->escala->viewAttributes() ?>>
<?= $Page->escala->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->periodo->Visible) { ?>
        <td data-field="periodo"<?= $Page->periodo->cellAttributes() ?>>
<span<?= $Page->periodo->viewAttributes() ?>>
<?= $Page->periodo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jornada->Visible) { ?>
        <td data-field="jornada"<?= $Page->jornada->cellAttributes() ?>>
<span<?= $Page->jornada->viewAttributes() ?>>
<?= $Page->jornada->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->intrajornada_tipo->Visible) { ?>
        <td data-field="intrajornada_tipo"<?= $Page->intrajornada_tipo->cellAttributes() ?>>
<span<?= $Page->intrajornada_tipo->viewAttributes() ?>>
<?= $Page->intrajornada_tipo->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
    }
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
