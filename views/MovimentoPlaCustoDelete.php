<?php

namespace PHPMaker2024\contratos;

// Page object
$MovimentoPlaCustoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { movimento_pla_custo: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fmovimento_pla_custodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmovimento_pla_custodelete")
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
<form name="fmovimento_pla_custodelete" id="fmovimento_pla_custodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="movimento_pla_custo">
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
<?php if ($Page->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
        <th class="<?= $Page->planilha_custo_idplanilha_custo->headerCellClass() ?>"><span id="elh_movimento_pla_custo_planilha_custo_idplanilha_custo" class="movimento_pla_custo_planilha_custo_idplanilha_custo"><?= $Page->planilha_custo_idplanilha_custo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <th class="<?= $Page->modulo_idmodulo->headerCellClass() ?>"><span id="elh_movimento_pla_custo_modulo_idmodulo" class="movimento_pla_custo_modulo_idmodulo"><?= $Page->modulo_idmodulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
        <th class="<?= $Page->itens_modulo_iditens_modulo->headerCellClass() ?>"><span id="elh_movimento_pla_custo_itens_modulo_iditens_modulo" class="movimento_pla_custo_itens_modulo_iditens_modulo"><?= $Page->itens_modulo_iditens_modulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { // porcentagem ?>
        <th class="<?= $Page->porcentagem->headerCellClass() ?>"><span id="elh_movimento_pla_custo_porcentagem" class="movimento_pla_custo_porcentagem"><?= $Page->porcentagem->caption() ?></span></th>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <th class="<?= $Page->valor->headerCellClass() ?>"><span id="elh_movimento_pla_custo_valor" class="movimento_pla_custo_valor"><?= $Page->valor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
        <th class="<?= $Page->obs->headerCellClass() ?>"><span id="elh_movimento_pla_custo_obs" class="movimento_pla_custo_obs"><?= $Page->obs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
        <th class="<?= $Page->calculo_idcalculo->headerCellClass() ?>"><span id="elh_movimento_pla_custo_calculo_idcalculo" class="movimento_pla_custo_calculo_idcalculo"><?= $Page->calculo_idcalculo->caption() ?></span></th>
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
<?php if ($Page->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
        <td<?= $Page->planilha_custo_idplanilha_custo->cellAttributes() ?>>
<span id="">
<span<?= $Page->planilha_custo_idplanilha_custo->viewAttributes() ?>>
<?= $Page->planilha_custo_idplanilha_custo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <td<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<span id="">
<span<?= $Page->modulo_idmodulo->viewAttributes() ?>>
<?= $Page->modulo_idmodulo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
        <td<?= $Page->itens_modulo_iditens_modulo->cellAttributes() ?>>
<span id="">
<span<?= $Page->itens_modulo_iditens_modulo->viewAttributes() ?>>
<?= $Page->itens_modulo_iditens_modulo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { // porcentagem ?>
        <td<?= $Page->porcentagem->cellAttributes() ?>>
<span id="">
<span<?= $Page->porcentagem->viewAttributes() ?>>
<?= $Page->porcentagem->getViewValue() ?></span>
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
<?php if ($Page->obs->Visible) { // obs ?>
        <td<?= $Page->obs->cellAttributes() ?>>
<span id="">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
        <td<?= $Page->calculo_idcalculo->cellAttributes() ?>>
<span id="">
<span<?= $Page->calculo_idcalculo->viewAttributes() ?>>
<?= $Page->calculo_idcalculo->getViewValue() ?></span>
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
