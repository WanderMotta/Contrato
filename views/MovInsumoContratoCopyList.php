<?php

namespace PHPMaker2024\contratos;

// Page object
$MovInsumoContratoCopyList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mov_insumo_contrato_copy: currentTable } });
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
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.min.js?v=24.8.0", "preview");
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
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
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
<input type="hidden" name="t" value="mov_insumo_contrato_copy">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_mov_insumo_contrato_copy" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_mov_insumo_contrato_copylist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->idmov_insumo_contrato->Visible) { // idmov_insumo_contrato ?>
        <th data-name="idmov_insumo_contrato" class="<?= $Page->idmov_insumo_contrato->headerCellClass() ?>"><div id="elh_mov_insumo_contrato_copy_idmov_insumo_contrato" class="mov_insumo_contrato_copy_idmov_insumo_contrato"><?= $Page->renderFieldHeader($Page->idmov_insumo_contrato) ?></div></th>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th data-name="dt_cadastro" class="<?= $Page->dt_cadastro->headerCellClass() ?>"><div id="elh_mov_insumo_contrato_copy_dt_cadastro" class="mov_insumo_contrato_copy_dt_cadastro"><?= $Page->renderFieldHeader($Page->dt_cadastro) ?></div></th>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <th data-name="insumo_idinsumo" class="<?= $Page->insumo_idinsumo->headerCellClass() ?>"><div id="elh_mov_insumo_contrato_copy_insumo_idinsumo" class="mov_insumo_contrato_copy_insumo_idinsumo"><?= $Page->renderFieldHeader($Page->insumo_idinsumo) ?></div></th>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
        <th data-name="qtde" class="<?= $Page->qtde->headerCellClass() ?>"><div id="elh_mov_insumo_contrato_copy_qtde" class="mov_insumo_contrato_copy_qtde"><?= $Page->renderFieldHeader($Page->qtde) ?></div></th>
<?php } ?>
<?php if ($Page->vr_unit->Visible) { // vr_unit ?>
        <th data-name="vr_unit" class="<?= $Page->vr_unit->headerCellClass() ?>"><div id="elh_mov_insumo_contrato_copy_vr_unit" class="mov_insumo_contrato_copy_vr_unit"><?= $Page->renderFieldHeader($Page->vr_unit) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <th data-name="tipo_insumo_idtipo_insumo" class="<?= $Page->tipo_insumo_idtipo_insumo->headerCellClass() ?>"><div id="elh_mov_insumo_contrato_copy_tipo_insumo_idtipo_insumo" class="mov_insumo_contrato_copy_tipo_insumo_idtipo_insumo"><?= $Page->renderFieldHeader($Page->tipo_insumo_idtipo_insumo) ?></div></th>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
        <th data-name="frequencia" class="<?= $Page->frequencia->headerCellClass() ?>"><div id="elh_mov_insumo_contrato_copy_frequencia" class="mov_insumo_contrato_copy_frequencia"><?= $Page->renderFieldHeader($Page->frequencia) ?></div></th>
<?php } ?>
<?php if ($Page->contrato_idcontrato->Visible) { // contrato_idcontrato ?>
        <th data-name="contrato_idcontrato" class="<?= $Page->contrato_idcontrato->headerCellClass() ?>"><div id="elh_mov_insumo_contrato_copy_contrato_idcontrato" class="mov_insumo_contrato_copy_contrato_idcontrato"><?= $Page->renderFieldHeader($Page->contrato_idcontrato) ?></div></th>
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
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$') {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
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
    <?php if ($Page->idmov_insumo_contrato->Visible) { // idmov_insumo_contrato ?>
        <td data-name="idmov_insumo_contrato"<?= $Page->idmov_insumo_contrato->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mov_insumo_contrato_copy_idmov_insumo_contrato" class="el_mov_insumo_contrato_copy_idmov_insumo_contrato">
<span<?= $Page->idmov_insumo_contrato->viewAttributes() ?>>
<?= $Page->idmov_insumo_contrato->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mov_insumo_contrato_copy_dt_cadastro" class="el_mov_insumo_contrato_copy_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <td data-name="insumo_idinsumo"<?= $Page->insumo_idinsumo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mov_insumo_contrato_copy_insumo_idinsumo" class="el_mov_insumo_contrato_copy_insumo_idinsumo">
<span<?= $Page->insumo_idinsumo->viewAttributes() ?>>
<?= $Page->insumo_idinsumo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->qtde->Visible) { // qtde ?>
        <td data-name="qtde"<?= $Page->qtde->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mov_insumo_contrato_copy_qtde" class="el_mov_insumo_contrato_copy_qtde">
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vr_unit->Visible) { // vr_unit ?>
        <td data-name="vr_unit"<?= $Page->vr_unit->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mov_insumo_contrato_copy_vr_unit" class="el_mov_insumo_contrato_copy_vr_unit">
<span<?= $Page->vr_unit->viewAttributes() ?>>
<?= $Page->vr_unit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <td data-name="tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mov_insumo_contrato_copy_tipo_insumo_idtipo_insumo" class="el_mov_insumo_contrato_copy_tipo_insumo_idtipo_insumo">
<span<?= $Page->tipo_insumo_idtipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo_idtipo_insumo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->frequencia->Visible) { // frequencia ?>
        <td data-name="frequencia"<?= $Page->frequencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mov_insumo_contrato_copy_frequencia" class="el_mov_insumo_contrato_copy_frequencia">
<span<?= $Page->frequencia->viewAttributes() ?>>
<?= $Page->frequencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contrato_idcontrato->Visible) { // contrato_idcontrato ?>
        <td data-name="contrato_idcontrato"<?= $Page->contrato_idcontrato->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mov_insumo_contrato_copy_contrato_idcontrato" class="el_mov_insumo_contrato_copy_contrato_idcontrato">
<span<?= $Page->contrato_idcontrato->viewAttributes() ?>>
<?= $Page->contrato_idcontrato->getViewValue() ?></span>
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
    ew.addEventHandlers("mov_insumo_contrato_copy");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
