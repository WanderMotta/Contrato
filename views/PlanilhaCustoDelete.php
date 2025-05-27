<?php

namespace PHPMaker2024\contratos;

// Page object
$PlanilhaCustoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { planilha_custo: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fplanilha_custodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplanilha_custodelete")
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
<form name="fplanilha_custodelete" id="fplanilha_custodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="planilha_custo">
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
<?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
        <th class="<?= $Page->idplanilha_custo->headerCellClass() ?>"><span id="elh_planilha_custo_idplanilha_custo" class="planilha_custo_idplanilha_custo"><?= $Page->idplanilha_custo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <th class="<?= $Page->proposta_idproposta->headerCellClass() ?>"><span id="elh_planilha_custo_proposta_idproposta" class="planilha_custo_proposta_idproposta"><?= $Page->proposta_idproposta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <th class="<?= $Page->escala_idescala->headerCellClass() ?>"><span id="elh_planilha_custo_escala_idescala" class="planilha_custo_escala_idescala"><?= $Page->escala_idescala->caption() ?></span></th>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <th class="<?= $Page->periodo_idperiodo->headerCellClass() ?>"><span id="elh_planilha_custo_periodo_idperiodo" class="planilha_custo_periodo_idperiodo"><?= $Page->periodo_idperiodo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <th class="<?= $Page->tipo_intrajornada_idtipo_intrajornada->headerCellClass() ?>"><span id="elh_planilha_custo_tipo_intrajornada_idtipo_intrajornada" class="planilha_custo_tipo_intrajornada_idtipo_intrajornada"><?= $Page->tipo_intrajornada_idtipo_intrajornada->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <th class="<?= $Page->cargo_idcargo->headerCellClass() ?>"><span id="elh_planilha_custo_cargo_idcargo" class="planilha_custo_cargo_idcargo"><?= $Page->cargo_idcargo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <th class="<?= $Page->acumulo_funcao->headerCellClass() ?>"><span id="elh_planilha_custo_acumulo_funcao" class="planilha_custo_acumulo_funcao"><?= $Page->acumulo_funcao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
        <th class="<?= $Page->quantidade->headerCellClass() ?>"><span id="elh_planilha_custo_quantidade" class="planilha_custo_quantidade"><?= $Page->quantidade->caption() ?></span></th>
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
<?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
        <td<?= $Page->idplanilha_custo->cellAttributes() ?>>
<span id="">
<span<?= $Page->idplanilha_custo->viewAttributes() ?>>
<?= $Page->idplanilha_custo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <td<?= $Page->proposta_idproposta->cellAttributes() ?>>
<span id="">
<span<?= $Page->proposta_idproposta->viewAttributes() ?>>
<?= $Page->proposta_idproposta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <td<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="">
<span<?= $Page->escala_idescala->viewAttributes() ?>>
<?= $Page->escala_idescala->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <td<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="">
<span<?= $Page->periodo_idperiodo->viewAttributes() ?>>
<?= $Page->periodo_idperiodo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <td<?= $Page->tipo_intrajornada_idtipo_intrajornada->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_intrajornada_idtipo_intrajornada->viewAttributes() ?>>
<?= $Page->tipo_intrajornada_idtipo_intrajornada->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <td<?= $Page->cargo_idcargo->cellAttributes() ?>>
<span id="">
<span<?= $Page->cargo_idcargo->viewAttributes() ?>>
<?= $Page->cargo_idcargo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <td<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span id="">
<span<?= $Page->acumulo_funcao->viewAttributes() ?>>
<?= $Page->acumulo_funcao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
        <td<?= $Page->quantidade->cellAttributes() ?>>
<span id="">
<span<?= $Page->quantidade->viewAttributes() ?>>
<?= $Page->quantidade->getViewValue() ?></span>
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
