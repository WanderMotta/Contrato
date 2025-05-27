<?php

namespace PHPMaker2024\contratos;

// Page object
$ViewInsumoPropostaDetalhadaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_insumo_proposta_detalhada: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
ew.PREVIEW_SELECTOR ??= ".ew-preview-btn";
ew.PREVIEW_TYPE ??= "row";
ew.PREVIEW_NAV_STYLE ??= "tabs"; // tabs/pills/underline
ew.PREVIEW_MODAL_CLASS ??= "modal modal-fullscreen-sm-down";
ew.PREVIEW_ROW ??= true;
ew.PREVIEW_SINGLE_ROW ??= false;
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.min.js?v=24.16.0", "preview");
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fview_insumo_proposta_detalhadasrch" id="fview_insumo_proposta_detalhadasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_insumo_proposta_detalhadasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_insumo_proposta_detalhada: currentTable } });
var currentForm;
var fview_insumo_proposta_detalhadasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_insumo_proposta_detalhadasrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_insumo_proposta_detalhadasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_insumo_proposta_detalhadasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_insumo_proposta_detalhadasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_insumo_proposta_detalhadasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
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
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_insumo_proposta_detalhada">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_insumo_proposta_detalhada" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_insumo_proposta_detalhadalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->idmov_insumo_cliente->Visible) { // idmov_insumo_cliente ?>
        <th data-name="idmov_insumo_cliente" class="<?= $Page->idmov_insumo_cliente->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_idmov_insumo_cliente" class="view_insumo_proposta_detalhada_idmov_insumo_cliente"><?= $Page->renderFieldHeader($Page->idmov_insumo_cliente) ?></div></th>
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <th data-name="proposta_idproposta" class="<?= $Page->proposta_idproposta->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_proposta_idproposta" class="view_insumo_proposta_detalhada_proposta_idproposta"><?= $Page->renderFieldHeader($Page->proposta_idproposta) ?></div></th>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <th data-name="insumo_idinsumo" class="<?= $Page->insumo_idinsumo->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_insumo_idinsumo" class="view_insumo_proposta_detalhada_insumo_idinsumo"><?= $Page->renderFieldHeader($Page->insumo_idinsumo) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
        <th data-name="tipo_insumo" class="<?= $Page->tipo_insumo->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_tipo_insumo" class="view_insumo_proposta_detalhada_tipo_insumo"><?= $Page->renderFieldHeader($Page->tipo_insumo) ?></div></th>
<?php } ?>
<?php if ($Page->insumo->Visible) { // insumo ?>
        <th data-name="insumo" class="<?= $Page->insumo->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_insumo" class="view_insumo_proposta_detalhada_insumo"><?= $Page->renderFieldHeader($Page->insumo) ?></div></th>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
        <th data-name="qtde" class="<?= $Page->qtde->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_qtde" class="view_insumo_proposta_detalhada_qtde"><?= $Page->renderFieldHeader($Page->qtde) ?></div></th>
<?php } ?>
<?php if ($Page->vr_unit->Visible) { // vr_unit ?>
        <th data-name="vr_unit" class="<?= $Page->vr_unit->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_vr_unit" class="view_insumo_proposta_detalhada_vr_unit"><?= $Page->renderFieldHeader($Page->vr_unit) ?></div></th>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
        <th data-name="frequencia" class="<?= $Page->frequencia->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_frequencia" class="view_insumo_proposta_detalhada_frequencia"><?= $Page->renderFieldHeader($Page->frequencia) ?></div></th>
<?php } ?>
<?php if ($Page->anual->Visible) { // anual ?>
        <th data-name="anual" class="<?= $Page->anual->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_anual" class="view_insumo_proposta_detalhada_anual"><?= $Page->renderFieldHeader($Page->anual) ?></div></th>
<?php } ?>
<?php if ($Page->mensal->Visible) { // mensal ?>
        <th data-name="mensal" class="<?= $Page->mensal->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_mensal" class="view_insumo_proposta_detalhada_mensal"><?= $Page->renderFieldHeader($Page->mensal) ?></div></th>
<?php } ?>
<?php if ($Page->idtipo_idinsumo->Visible) { // idtipo_idinsumo ?>
        <th data-name="idtipo_idinsumo" class="<?= $Page->idtipo_idinsumo->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_idtipo_idinsumo" class="view_insumo_proposta_detalhada_idtipo_idinsumo"><?= $Page->renderFieldHeader($Page->idtipo_idinsumo) ?></div></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div id="elh_view_insumo_proposta_detalhada_cliente" class="view_insumo_proposta_detalhada_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
$isInlineAddOrCopy = ($Page->isCopy() || $Page->isAdd());
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Page->RowIndex == 0) {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        !($isInlineAddOrCopy && $Page->RowIndex == 0)
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->idmov_insumo_cliente->Visible) { // idmov_insumo_cliente ?>
        <td data-name="idmov_insumo_cliente"<?= $Page->idmov_insumo_cliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_idmov_insumo_cliente" class="el_view_insumo_proposta_detalhada_idmov_insumo_cliente">
<span<?= $Page->idmov_insumo_cliente->viewAttributes() ?>>
<?= $Page->idmov_insumo_cliente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <td data-name="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_proposta_idproposta" class="el_view_insumo_proposta_detalhada_proposta_idproposta">
<span<?= $Page->proposta_idproposta->viewAttributes() ?>>
<?= $Page->proposta_idproposta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <td data-name="insumo_idinsumo"<?= $Page->insumo_idinsumo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_insumo_idinsumo" class="el_view_insumo_proposta_detalhada_insumo_idinsumo">
<span<?= $Page->insumo_idinsumo->viewAttributes() ?>>
<?= $Page->insumo_idinsumo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
        <td data-name="tipo_insumo"<?= $Page->tipo_insumo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_tipo_insumo" class="el_view_insumo_proposta_detalhada_tipo_insumo">
<span<?= $Page->tipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->insumo->Visible) { // insumo ?>
        <td data-name="insumo"<?= $Page->insumo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_insumo" class="el_view_insumo_proposta_detalhada_insumo">
<span<?= $Page->insumo->viewAttributes() ?>>
<?= $Page->insumo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->qtde->Visible) { // qtde ?>
        <td data-name="qtde"<?= $Page->qtde->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_qtde" class="el_view_insumo_proposta_detalhada_qtde">
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vr_unit->Visible) { // vr_unit ?>
        <td data-name="vr_unit"<?= $Page->vr_unit->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_vr_unit" class="el_view_insumo_proposta_detalhada_vr_unit">
<span<?= $Page->vr_unit->viewAttributes() ?>>
<?= $Page->vr_unit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->frequencia->Visible) { // frequencia ?>
        <td data-name="frequencia"<?= $Page->frequencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_frequencia" class="el_view_insumo_proposta_detalhada_frequencia">
<span<?= $Page->frequencia->viewAttributes() ?>>
<?= $Page->frequencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->anual->Visible) { // anual ?>
        <td data-name="anual"<?= $Page->anual->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_anual" class="el_view_insumo_proposta_detalhada_anual">
<span<?= $Page->anual->viewAttributes() ?>>
<?= $Page->anual->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->mensal->Visible) { // mensal ?>
        <td data-name="mensal"<?= $Page->mensal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_mensal" class="el_view_insumo_proposta_detalhada_mensal">
<span<?= $Page->mensal->viewAttributes() ?>>
<?= $Page->mensal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idtipo_idinsumo->Visible) { // idtipo_idinsumo ?>
        <td data-name="idtipo_idinsumo"<?= $Page->idtipo_idinsumo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_idtipo_idinsumo" class="el_view_insumo_proposta_detalhada_idtipo_idinsumo">
<span<?= $Page->idtipo_idinsumo->viewAttributes() ?>>
<?= $Page->idtipo_idinsumo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_insumo_proposta_detalhada_cliente" class="el_view_insumo_proposta_detalhada_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("view_insumo_proposta_detalhada");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
