<?php

namespace PHPMaker2024\contratos;

// Page object
$InsumoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { insumo: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var finsumodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("finsumodelete")
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
<form name="finsumodelete" id="finsumodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="insumo">
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
<?php if ($Page->insumo->Visible) { // insumo ?>
        <th class="<?= $Page->insumo->headerCellClass() ?>"><span id="elh_insumo_insumo" class="insumo_insumo"><?= $Page->insumo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <th class="<?= $Page->tipo_insumo_idtipo_insumo->headerCellClass() ?>"><span id="elh_insumo_tipo_insumo_idtipo_insumo" class="insumo_tipo_insumo_idtipo_insumo"><?= $Page->tipo_insumo_idtipo_insumo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { // vr_unitario ?>
        <th class="<?= $Page->vr_unitario->headerCellClass() ?>"><span id="elh_insumo_vr_unitario" class="insumo_vr_unitario"><?= $Page->vr_unitario->caption() ?></span></th>
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
<?php if ($Page->insumo->Visible) { // insumo ?>
        <td<?= $Page->insumo->cellAttributes() ?>>
<span id="">
<span<?= $Page->insumo->viewAttributes() ?>>
<?= $Page->insumo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <td<?= $Page->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_insumo_idtipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo_idtipo_insumo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { // vr_unitario ?>
        <td<?= $Page->vr_unitario->cellAttributes() ?>>
<span id="">
<span<?= $Page->vr_unitario->viewAttributes() ?>>
<?= $Page->vr_unitario->getViewValue() ?></span>
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
