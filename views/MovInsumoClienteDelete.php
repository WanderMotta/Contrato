<?php

namespace PHPMaker2024\contratos;

// Page object
$MovInsumoClienteDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mov_insumo_cliente: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fmov_insumo_clientedelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmov_insumo_clientedelete")
        .setPageId("delete")
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fmov_insumo_clientedelete" id="fmov_insumo_clientedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mov_insumo_cliente">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <th class="<?= $Page->tipo_insumo_idtipo_insumo->headerCellClass() ?>"><span id="elh_mov_insumo_cliente_tipo_insumo_idtipo_insumo" class="mov_insumo_cliente_tipo_insumo_idtipo_insumo"><?= $Page->tipo_insumo_idtipo_insumo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <th class="<?= $Page->insumo_idinsumo->headerCellClass() ?>"><span id="elh_mov_insumo_cliente_insumo_idinsumo" class="mov_insumo_cliente_insumo_idinsumo"><?= $Page->insumo_idinsumo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
        <th class="<?= $Page->qtde->headerCellClass() ?>"><span id="elh_mov_insumo_cliente_qtde" class="mov_insumo_cliente_qtde"><?= $Page->qtde->caption() ?></span></th>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
        <th class="<?= $Page->frequencia->headerCellClass() ?>"><span id="elh_mov_insumo_cliente_frequencia" class="mov_insumo_cliente_frequencia"><?= $Page->frequencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vr_unit->Visible) { // vr_unit ?>
        <th class="<?= $Page->vr_unit->headerCellClass() ?>"><span id="elh_mov_insumo_cliente_vr_unit" class="mov_insumo_cliente_vr_unit"><?= $Page->vr_unit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vr_total->Visible) { // vr_total ?>
        <th class="<?= $Page->vr_total->headerCellClass() ?>"><span id="elh_mov_insumo_cliente_vr_total" class="mov_insumo_cliente_vr_total"><?= $Page->vr_total->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <td<?= $Page->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_insumo_idtipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo_idtipo_insumo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <td<?= $Page->insumo_idinsumo->cellAttributes() ?>>
<span id="">
<span<?= $Page->insumo_idinsumo->viewAttributes() ?>>
<?= $Page->insumo_idinsumo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
        <td<?= $Page->qtde->cellAttributes() ?>>
<span id="">
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
        <td<?= $Page->frequencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->frequencia->viewAttributes() ?>>
<?= $Page->frequencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vr_unit->Visible) { // vr_unit ?>
        <td<?= $Page->vr_unit->cellAttributes() ?>>
<span id="">
<span<?= $Page->vr_unit->viewAttributes() ?>>
<?= $Page->vr_unit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vr_total->Visible) { // vr_total ?>
        <td<?= $Page->vr_total->cellAttributes() ?>>
<span id="">
<span<?= $Page->vr_total->viewAttributes() ?>>
<?= $Page->vr_total->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
