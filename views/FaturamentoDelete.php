<?php

namespace PHPMaker2024\contratos;

// Page object
$FaturamentoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { faturamento: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var ffaturamentodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffaturamentodelete")
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
<form name="ffaturamentodelete" id="ffaturamentodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="faturamento">
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
<?php if ($Page->faturamento->Visible) { // faturamento ?>
        <th class="<?= $Page->faturamento->headerCellClass() ?>"><span id="elh_faturamento_faturamento" class="faturamento_faturamento"><?= $Page->faturamento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cnpj->Visible) { // cnpj ?>
        <th class="<?= $Page->cnpj->headerCellClass() ?>"><span id="elh_faturamento_cnpj" class="faturamento_cnpj"><?= $Page->cnpj->caption() ?></span></th>
<?php } ?>
<?php if ($Page->endereco->Visible) { // endereco ?>
        <th class="<?= $Page->endereco->headerCellClass() ?>"><span id="elh_faturamento_endereco" class="faturamento_endereco"><?= $Page->endereco->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bairro->Visible) { // bairro ?>
        <th class="<?= $Page->bairro->headerCellClass() ?>"><span id="elh_faturamento_bairro" class="faturamento_bairro"><?= $Page->bairro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
        <th class="<?= $Page->cidade->headerCellClass() ?>"><span id="elh_faturamento_cidade" class="faturamento_cidade"><?= $Page->cidade->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
        <th class="<?= $Page->uf->headerCellClass() ?>"><span id="elh_faturamento_uf" class="faturamento_uf"><?= $Page->uf->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dia_vencimento->Visible) { // dia_vencimento ?>
        <th class="<?= $Page->dia_vencimento->headerCellClass() ?>"><span id="elh_faturamento_dia_vencimento" class="faturamento_dia_vencimento"><?= $Page->dia_vencimento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->origem->Visible) { // origem ?>
        <th class="<?= $Page->origem->headerCellClass() ?>"><span id="elh_faturamento_origem" class="faturamento_origem"><?= $Page->origem->caption() ?></span></th>
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
<?php if ($Page->faturamento->Visible) { // faturamento ?>
        <td<?= $Page->faturamento->cellAttributes() ?>>
<span id="">
<span<?= $Page->faturamento->viewAttributes() ?>>
<?= $Page->faturamento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cnpj->Visible) { // cnpj ?>
        <td<?= $Page->cnpj->cellAttributes() ?>>
<span id="">
<span<?= $Page->cnpj->viewAttributes() ?>>
<?= $Page->cnpj->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->endereco->Visible) { // endereco ?>
        <td<?= $Page->endereco->cellAttributes() ?>>
<span id="">
<span<?= $Page->endereco->viewAttributes() ?>>
<?= $Page->endereco->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bairro->Visible) { // bairro ?>
        <td<?= $Page->bairro->cellAttributes() ?>>
<span id="">
<span<?= $Page->bairro->viewAttributes() ?>>
<?= $Page->bairro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
        <td<?= $Page->cidade->cellAttributes() ?>>
<span id="">
<span<?= $Page->cidade->viewAttributes() ?>>
<?= $Page->cidade->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
        <td<?= $Page->uf->cellAttributes() ?>>
<span id="">
<span<?= $Page->uf->viewAttributes() ?>>
<?= $Page->uf->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dia_vencimento->Visible) { // dia_vencimento ?>
        <td<?= $Page->dia_vencimento->cellAttributes() ?>>
<span id="">
<span<?= $Page->dia_vencimento->viewAttributes() ?>>
<?= $Page->dia_vencimento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->origem->Visible) { // origem ?>
        <td<?= $Page->origem->cellAttributes() ?>>
<span id="">
<span<?= $Page->origem->viewAttributes() ?>>
<?= $Page->origem->getViewValue() ?></span>
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
