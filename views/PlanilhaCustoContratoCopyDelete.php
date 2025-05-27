<?php

namespace PHPMaker2024\contratos;

// Page object
$PlanilhaCustoContratoCopyDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { planilha_custo_contrato_copy: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fplanilha_custo_contrato_copydelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplanilha_custo_contrato_copydelete")
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
<form name="fplanilha_custo_contrato_copydelete" id="fplanilha_custo_contrato_copydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="planilha_custo_contrato_copy">
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
<?php if ($Page->idplanilha_custo_contrato->Visible) { // idplanilha_custo_contrato ?>
        <th class="<?= $Page->idplanilha_custo_contrato->headerCellClass() ?>"><span id="elh_planilha_custo_contrato_copy_idplanilha_custo_contrato" class="planilha_custo_contrato_copy_idplanilha_custo_contrato"><?= $Page->idplanilha_custo_contrato->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th class="<?= $Page->dt_cadastro->headerCellClass() ?>"><span id="elh_planilha_custo_contrato_copy_dt_cadastro" class="planilha_custo_contrato_copy_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
        <th class="<?= $Page->quantidade->headerCellClass() ?>"><span id="elh_planilha_custo_contrato_copy_quantidade" class="planilha_custo_contrato_copy_quantidade"><?= $Page->quantidade->caption() ?></span></th>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <th class="<?= $Page->acumulo_funcao->headerCellClass() ?>"><span id="elh_planilha_custo_contrato_copy_acumulo_funcao" class="planilha_custo_contrato_copy_acumulo_funcao"><?= $Page->acumulo_funcao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <th class="<?= $Page->periodo_idperiodo->headerCellClass() ?>"><span id="elh_planilha_custo_contrato_copy_periodo_idperiodo" class="planilha_custo_contrato_copy_periodo_idperiodo"><?= $Page->periodo_idperiodo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <th class="<?= $Page->cargo_idcargo->headerCellClass() ?>"><span id="elh_planilha_custo_contrato_copy_cargo_idcargo" class="planilha_custo_contrato_copy_cargo_idcargo"><?= $Page->cargo_idcargo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <th class="<?= $Page->tipo_intrajornada_idtipo_intrajornada->headerCellClass() ?>"><span id="elh_planilha_custo_contrato_copy_tipo_intrajornada_idtipo_intrajornada" class="planilha_custo_contrato_copy_tipo_intrajornada_idtipo_intrajornada"><?= $Page->tipo_intrajornada_idtipo_intrajornada->caption() ?></span></th>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <th class="<?= $Page->escala_idescala->headerCellClass() ?>"><span id="elh_planilha_custo_contrato_copy_escala_idescala" class="planilha_custo_contrato_copy_escala_idescala"><?= $Page->escala_idescala->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><span id="elh_planilha_custo_contrato_copy_usuario_idusuario" class="planilha_custo_contrato_copy_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contrato_idcontrato->Visible) { // contrato_idcontrato ?>
        <th class="<?= $Page->contrato_idcontrato->headerCellClass() ?>"><span id="elh_planilha_custo_contrato_copy_contrato_idcontrato" class="planilha_custo_contrato_copy_contrato_idcontrato"><?= $Page->contrato_idcontrato->caption() ?></span></th>
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
<?php if ($Page->idplanilha_custo_contrato->Visible) { // idplanilha_custo_contrato ?>
        <td<?= $Page->idplanilha_custo_contrato->cellAttributes() ?>>
<span id="">
<span<?= $Page->idplanilha_custo_contrato->viewAttributes() ?>>
<?= $Page->idplanilha_custo_contrato->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
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
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <td<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span id="">
<span<?= $Page->acumulo_funcao->viewAttributes() ?>>
<?= $Page->acumulo_funcao->getViewValue() ?></span>
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
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <td<?= $Page->cargo_idcargo->cellAttributes() ?>>
<span id="">
<span<?= $Page->cargo_idcargo->viewAttributes() ?>>
<?= $Page->cargo_idcargo->getViewValue() ?></span>
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
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <td<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="">
<span<?= $Page->escala_idescala->viewAttributes() ?>>
<?= $Page->escala_idescala->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contrato_idcontrato->Visible) { // contrato_idcontrato ?>
        <td<?= $Page->contrato_idcontrato->cellAttributes() ?>>
<span id="">
<span<?= $Page->contrato_idcontrato->viewAttributes() ?>>
<?= $Page->contrato_idcontrato->getViewValue() ?></span>
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
