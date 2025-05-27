<?php

namespace PHPMaker2024\contratos;

// Page object
$ContratoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contrato: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcontratodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcontratodelete")
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
<form name="fcontratodelete" id="fcontratodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="contrato">
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
<?php if ($Page->idcontrato->Visible) { // idcontrato ?>
        <th class="<?= $Page->idcontrato->headerCellClass() ?>"><span id="elh_contrato_idcontrato" class="contrato_idcontrato"><?= $Page->idcontrato->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <th class="<?= $Page->cliente_idcliente->headerCellClass() ?>"><span id="elh_contrato_cliente_idcliente" class="contrato_cliente_idcliente"><?= $Page->cliente_idcliente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <th class="<?= $Page->valor->headerCellClass() ?>"><span id="elh_contrato_valor" class="contrato_valor"><?= $Page->valor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <th class="<?= $Page->ativo->headerCellClass() ?>"><span id="elh_contrato_ativo" class="contrato_ativo"><?= $Page->ativo->caption() ?></span></th>
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
<?php if ($Page->idcontrato->Visible) { // idcontrato ?>
        <td<?= $Page->idcontrato->cellAttributes() ?>>
<span id="">
<span<?= $Page->idcontrato->viewAttributes() ?>>
<?= $Page->idcontrato->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <td<?= $Page->cliente_idcliente->cellAttributes() ?>>
<span id="">
<span<?= $Page->cliente_idcliente->viewAttributes() ?>>
<?= $Page->cliente_idcliente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <td<?= $Page->valor->cellAttributes() ?>>
<span id="">
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <td<?= $Page->ativo->cellAttributes() ?>>
<span id="">
<span<?= $Page->ativo->viewAttributes() ?>>
<?= $Page->ativo->getViewValue() ?></span>
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
