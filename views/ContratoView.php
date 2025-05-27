<?php

namespace PHPMaker2024\contratos;

// Page object
$ContratoView = &$Page;
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
<form name="fcontratoview" id="fcontratoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contrato: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcontratoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcontratoview")
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
<input type="hidden" name="t" value="contrato">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idcontrato->Visible) { // idcontrato ?>
    <tr id="r_idcontrato"<?= $Page->idcontrato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_idcontrato"><?= $Page->idcontrato->caption() ?></span></td>
        <td data-name="idcontrato"<?= $Page->idcontrato->cellAttributes() ?>>
<span id="el_contrato_idcontrato">
<span<?= $Page->idcontrato->viewAttributes() ?>>
<?= $Page->idcontrato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
    <tr id="r_cliente_idcliente"<?= $Page->cliente_idcliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_cliente_idcliente"><?= $Page->cliente_idcliente->caption() ?></span></td>
        <td data-name="cliente_idcliente"<?= $Page->cliente_idcliente->cellAttributes() ?>>
<span id="el_contrato_cliente_idcliente">
<span<?= $Page->cliente_idcliente->viewAttributes() ?>>
<?= $Page->cliente_idcliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
    <tr id="r_valor"<?= $Page->valor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_valor"><?= $Page->valor->caption() ?></span></td>
        <td data-name="valor"<?= $Page->valor->cellAttributes() ?>>
<span id="el_contrato_valor">
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_contrato_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_contrato_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <tr id="r_ativo"<?= $Page->ativo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_ativo"><?= $Page->ativo->caption() ?></span></td>
        <td data-name="ativo"<?= $Page->ativo->cellAttributes() ?>>
<span id="el_contrato_ativo">
<span<?= $Page->ativo->viewAttributes() ?>>
<?= $Page->ativo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <tr id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></td>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_contrato_usuario_idusuario">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->valor_antes->Visible) { // valor_antes ?>
    <tr id="r_valor_antes"<?= $Page->valor_antes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_valor_antes"><?= $Page->valor_antes->caption() ?></span></td>
        <td data-name="valor_antes"<?= $Page->valor_antes->cellAttributes() ?>>
<span id="el_contrato_valor_antes">
<span<?= $Page->valor_antes->viewAttributes() ?>>
<?= $Page->valor_antes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("planilha_custo_contrato", explode(",", $Page->getCurrentDetailTable())) && $planilha_custo_contrato->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("planilha_custo_contrato", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PlanilhaCustoContratoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("mov_insumo_contrato", explode(",", $Page->getCurrentDetailTable())) && $mov_insumo_contrato->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("mov_insumo_contrato", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MovInsumoContratoGrid.php" ?>
<?php } ?>
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
