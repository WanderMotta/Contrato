<?php

namespace PHPMaker2024\contratos;

// Page object
$PlanilhaCustoContratoCopyView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<form name="fplanilha_custo_contrato_copyview" id="fplanilha_custo_contrato_copyview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { planilha_custo_contrato_copy: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fplanilha_custo_contrato_copyview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplanilha_custo_contrato_copyview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="planilha_custo_contrato_copy">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idplanilha_custo_contrato->Visible) { // idplanilha_custo_contrato ?>
    <tr id="r_idplanilha_custo_contrato"<?= $Page->idplanilha_custo_contrato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_planilha_custo_contrato_copy_idplanilha_custo_contrato"><?= $Page->idplanilha_custo_contrato->caption() ?></span></td>
        <td data-name="idplanilha_custo_contrato"<?= $Page->idplanilha_custo_contrato->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_idplanilha_custo_contrato">
<span<?= $Page->idplanilha_custo_contrato->viewAttributes() ?>>
<?= $Page->idplanilha_custo_contrato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_planilha_custo_contrato_copy_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
    <tr id="r_quantidade"<?= $Page->quantidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_planilha_custo_contrato_copy_quantidade"><?= $Page->quantidade->caption() ?></span></td>
        <td data-name="quantidade"<?= $Page->quantidade->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_quantidade">
<span<?= $Page->quantidade->viewAttributes() ?>>
<?= $Page->quantidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
    <tr id="r_acumulo_funcao"<?= $Page->acumulo_funcao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_planilha_custo_contrato_copy_acumulo_funcao"><?= $Page->acumulo_funcao->caption() ?></span></td>
        <td data-name="acumulo_funcao"<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_acumulo_funcao">
<span<?= $Page->acumulo_funcao->viewAttributes() ?>>
<?= $Page->acumulo_funcao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
    <tr id="r_periodo_idperiodo"<?= $Page->periodo_idperiodo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_planilha_custo_contrato_copy_periodo_idperiodo"><?= $Page->periodo_idperiodo->caption() ?></span></td>
        <td data-name="periodo_idperiodo"<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_periodo_idperiodo">
<span<?= $Page->periodo_idperiodo->viewAttributes() ?>>
<?= $Page->periodo_idperiodo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
    <tr id="r_cargo_idcargo"<?= $Page->cargo_idcargo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_planilha_custo_contrato_copy_cargo_idcargo"><?= $Page->cargo_idcargo->caption() ?></span></td>
        <td data-name="cargo_idcargo"<?= $Page->cargo_idcargo->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_cargo_idcargo">
<span<?= $Page->cargo_idcargo->viewAttributes() ?>>
<?= $Page->cargo_idcargo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
    <tr id="r_tipo_intrajornada_idtipo_intrajornada"<?= $Page->tipo_intrajornada_idtipo_intrajornada->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_planilha_custo_contrato_copy_tipo_intrajornada_idtipo_intrajornada"><?= $Page->tipo_intrajornada_idtipo_intrajornada->caption() ?></span></td>
        <td data-name="tipo_intrajornada_idtipo_intrajornada"<?= $Page->tipo_intrajornada_idtipo_intrajornada->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_tipo_intrajornada_idtipo_intrajornada">
<span<?= $Page->tipo_intrajornada_idtipo_intrajornada->viewAttributes() ?>>
<?= $Page->tipo_intrajornada_idtipo_intrajornada->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
    <tr id="r_escala_idescala"<?= $Page->escala_idescala->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_planilha_custo_contrato_copy_escala_idescala"><?= $Page->escala_idescala->caption() ?></span></td>
        <td data-name="escala_idescala"<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_escala_idescala">
<span<?= $Page->escala_idescala->viewAttributes() ?>>
<?= $Page->escala_idescala->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <tr id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_planilha_custo_contrato_copy_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></td>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_usuario_idusuario">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contrato_idcontrato->Visible) { // contrato_idcontrato ?>
    <tr id="r_contrato_idcontrato"<?= $Page->contrato_idcontrato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_planilha_custo_contrato_copy_contrato_idcontrato"><?= $Page->contrato_idcontrato->caption() ?></span></td>
        <td data-name="contrato_idcontrato"<?= $Page->contrato_idcontrato->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_contrato_idcontrato">
<span<?= $Page->contrato_idcontrato->viewAttributes() ?>>
<?= $Page->contrato_idcontrato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
