<?php

namespace PHPMaker2024\contratos;

// Page object
$ClienteDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cliente: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fclientedelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fclientedelete")
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
<form name="fclientedelete" id="fclientedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cliente">
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
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th class="<?= $Page->cliente->headerCellClass() ?>"><span id="elh_cliente_cliente" class="cliente_cliente"><?= $Page->cliente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contato->Visible) { // contato ?>
        <th class="<?= $Page->contato->headerCellClass() ?>"><span id="elh_cliente_contato" class="cliente_contato"><?= $Page->contato->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_cliente__email" class="cliente__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->telefone->Visible) { // telefone ?>
        <th class="<?= $Page->telefone->headerCellClass() ?>"><span id="elh_cliente_telefone" class="cliente_telefone"><?= $Page->telefone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <th class="<?= $Page->ativo->headerCellClass() ?>"><span id="elh_cliente_ativo" class="cliente_ativo"><?= $Page->ativo->caption() ?></span></th>
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
<?php if ($Page->cliente->Visible) { // cliente ?>
        <td<?= $Page->cliente->cellAttributes() ?>>
<span id="">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contato->Visible) { // contato ?>
        <td<?= $Page->contato->cellAttributes() ?>>
<span id="">
<span<?= $Page->contato->viewAttributes() ?>>
<?= $Page->contato->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td<?= $Page->_email->cellAttributes() ?>>
<span id="">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->telefone->Visible) { // telefone ?>
        <td<?= $Page->telefone->cellAttributes() ?>>
<span id="">
<span<?= $Page->telefone->viewAttributes() ?>>
<?= $Page->telefone->getViewValue() ?></span>
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
