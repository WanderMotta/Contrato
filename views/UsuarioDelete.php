<?php

namespace PHPMaker2024\contratos;

// Page object
$UsuarioDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { usuario: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fusuariodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fusuariodelete")
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
<form name="fusuariodelete" id="fusuariodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="usuario">
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
<?php if ($Page->_login->Visible) { // login ?>
        <th class="<?= $Page->_login->headerCellClass() ?>"><span id="elh_usuario__login" class="usuario__login"><?= $Page->_login->caption() ?></span></th>
<?php } ?>
<?php if ($Page->senha->Visible) { // senha ?>
        <th class="<?= $Page->senha->headerCellClass() ?>"><span id="elh_usuario_senha" class="usuario_senha"><?= $Page->senha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_userlevel->Visible) { // userlevel ?>
        <th class="<?= $Page->_userlevel->headerCellClass() ?>"><span id="elh_usuario__userlevel" class="usuario__userlevel"><?= $Page->_userlevel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <th class="<?= $Page->ativo->headerCellClass() ?>"><span id="elh_usuario_ativo" class="usuario_ativo"><?= $Page->ativo->caption() ?></span></th>
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
<?php if ($Page->_login->Visible) { // login ?>
        <td<?= $Page->_login->cellAttributes() ?>>
<span id="">
<span<?= $Page->_login->viewAttributes() ?>>
<?= $Page->_login->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->senha->Visible) { // senha ?>
        <td<?= $Page->senha->cellAttributes() ?>>
<span id="">
<span<?= $Page->senha->viewAttributes() ?>>
<?= $Page->senha->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_userlevel->Visible) { // userlevel ?>
        <td<?= $Page->_userlevel->cellAttributes() ?>>
<span id="">
<span<?= $Page->_userlevel->viewAttributes() ?>>
<?= $Page->_userlevel->getViewValue() ?></span>
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
