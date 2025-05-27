<?php

namespace PHPMaker2024\contratos;

// Page object
$MovInsumoContratoCopyView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<form name="fmov_insumo_contrato_copyview" id="fmov_insumo_contrato_copyview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mov_insumo_contrato_copy: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fmov_insumo_contrato_copyview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmov_insumo_contrato_copyview")
        .setPageId("view")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mov_insumo_contrato_copy">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idmov_insumo_contrato->Visible) { // idmov_insumo_contrato ?>
    <tr id="r_idmov_insumo_contrato"<?= $Page->idmov_insumo_contrato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_contrato_copy_idmov_insumo_contrato"><?= $Page->idmov_insumo_contrato->caption() ?></span></td>
        <td data-name="idmov_insumo_contrato"<?= $Page->idmov_insumo_contrato->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_idmov_insumo_contrato">
<span<?= $Page->idmov_insumo_contrato->viewAttributes() ?>>
<?= $Page->idmov_insumo_contrato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_contrato_copy_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
    <tr id="r_insumo_idinsumo"<?= $Page->insumo_idinsumo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_contrato_copy_insumo_idinsumo"><?= $Page->insumo_idinsumo->caption() ?></span></td>
        <td data-name="insumo_idinsumo"<?= $Page->insumo_idinsumo->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_insumo_idinsumo">
<span<?= $Page->insumo_idinsumo->viewAttributes() ?>>
<?= $Page->insumo_idinsumo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
    <tr id="r_qtde"<?= $Page->qtde->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_contrato_copy_qtde"><?= $Page->qtde->caption() ?></span></td>
        <td data-name="qtde"<?= $Page->qtde->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_qtde">
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vr_unit->Visible) { // vr_unit ?>
    <tr id="r_vr_unit"<?= $Page->vr_unit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_contrato_copy_vr_unit"><?= $Page->vr_unit->caption() ?></span></td>
        <td data-name="vr_unit"<?= $Page->vr_unit->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_vr_unit">
<span<?= $Page->vr_unit->viewAttributes() ?>>
<?= $Page->vr_unit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
    <tr id="r_tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_contrato_copy_tipo_insumo_idtipo_insumo"><?= $Page->tipo_insumo_idtipo_insumo->caption() ?></span></td>
        <td data-name="tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_tipo_insumo_idtipo_insumo">
<span<?= $Page->tipo_insumo_idtipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo_idtipo_insumo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
    <tr id="r_frequencia"<?= $Page->frequencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_contrato_copy_frequencia"><?= $Page->frequencia->caption() ?></span></td>
        <td data-name="frequencia"<?= $Page->frequencia->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_frequencia">
<span<?= $Page->frequencia->viewAttributes() ?>>
<?= $Page->frequencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contrato_idcontrato->Visible) { // contrato_idcontrato ?>
    <tr id="r_contrato_idcontrato"<?= $Page->contrato_idcontrato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_contrato_copy_contrato_idcontrato"><?= $Page->contrato_idcontrato->caption() ?></span></td>
        <td data-name="contrato_idcontrato"<?= $Page->contrato_idcontrato->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_contrato_idcontrato">
<span<?= $Page->contrato_idcontrato->viewAttributes() ?>>
<?= $Page->contrato_idcontrato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
