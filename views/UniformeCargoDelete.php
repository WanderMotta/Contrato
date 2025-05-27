<?php

namespace PHPMaker2024\contratos;

// Page object
$UniformeCargoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { uniforme_cargo: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var funiforme_cargodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("funiforme_cargodelete")
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
<form name="funiforme_cargodelete" id="funiforme_cargodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="uniforme_cargo">
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
<?php if ($Page->uniforme_iduniforme->Visible) { // uniforme_iduniforme ?>
        <th class="<?= $Page->uniforme_iduniforme->headerCellClass() ?>"><span id="elh_uniforme_cargo_uniforme_iduniforme" class="uniforme_cargo_uniforme_iduniforme"><?= $Page->uniforme_iduniforme->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <th class="<?= $Page->tipo_uniforme_idtipo_uniforme->headerCellClass() ?>"><span id="elh_uniforme_cargo_tipo_uniforme_idtipo_uniforme" class="uniforme_cargo_tipo_uniforme_idtipo_uniforme"><?= $Page->tipo_uniforme_idtipo_uniforme->caption() ?></span></th>
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
<?php if ($Page->uniforme_iduniforme->Visible) { // uniforme_iduniforme ?>
        <td<?= $Page->uniforme_iduniforme->cellAttributes() ?>>
<span id="">
<span<?= $Page->uniforme_iduniforme->viewAttributes() ?>>
<?= $Page->uniforme_iduniforme->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <td<?= $Page->tipo_uniforme_idtipo_uniforme->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_uniforme_idtipo_uniforme->viewAttributes() ?>>
<?= $Page->tipo_uniforme_idtipo_uniforme->getViewValue() ?></span>
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
