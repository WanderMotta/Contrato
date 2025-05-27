<?php

namespace PHPMaker2024\contratos;

// Page object
$ItensModuloDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { itens_modulo: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fitens_modulodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fitens_modulodelete")
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
<form name="fitens_modulodelete" id="fitens_modulodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="itens_modulo">
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
<?php if ($Page->item->Visible) { // item ?>
        <th class="<?= $Page->item->headerCellClass() ?>"><span id="elh_itens_modulo_item" class="itens_modulo_item"><?= $Page->item->caption() ?></span></th>
<?php } ?>
<?php if ($Page->porcentagem_valor->Visible) { // porcentagem_valor ?>
        <th class="<?= $Page->porcentagem_valor->headerCellClass() ?>"><span id="elh_itens_modulo_porcentagem_valor" class="itens_modulo_porcentagem_valor"><?= $Page->porcentagem_valor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->incidencia_inss->Visible) { // incidencia_inss ?>
        <th class="<?= $Page->incidencia_inss->headerCellClass() ?>"><span id="elh_itens_modulo_incidencia_inss" class="itens_modulo_incidencia_inss"><?= $Page->incidencia_inss->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <th class="<?= $Page->ativo->headerCellClass() ?>"><span id="elh_itens_modulo_ativo" class="itens_modulo_ativo"><?= $Page->ativo->caption() ?></span></th>
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
<?php if ($Page->item->Visible) { // item ?>
        <td<?= $Page->item->cellAttributes() ?>>
<span id="">
<span<?= $Page->item->viewAttributes() ?>>
<?= $Page->item->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->porcentagem_valor->Visible) { // porcentagem_valor ?>
        <td<?= $Page->porcentagem_valor->cellAttributes() ?>>
<span id="">
<span<?= $Page->porcentagem_valor->viewAttributes() ?>>
<?= $Page->porcentagem_valor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->incidencia_inss->Visible) { // incidencia_inss ?>
        <td<?= $Page->incidencia_inss->cellAttributes() ?>>
<span id="">
<span<?= $Page->incidencia_inss->viewAttributes() ?>>
<?= $Page->incidencia_inss->getViewValue() ?></span>
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
