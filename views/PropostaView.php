<?php

namespace PHPMaker2024\contratos;

// Page object
$PropostaView = &$Page;
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
<form name="fpropostaview" id="fpropostaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposta: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fpropostaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpropostaview")
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
<input type="hidden" name="t" value="proposta">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idproposta->Visible) { // idproposta ?>
    <tr id="r_idproposta"<?= $Page->idproposta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposta_idproposta"><?= $Page->idproposta->caption() ?></span></td>
        <td data-name="idproposta"<?= $Page->idproposta->cellAttributes() ?>>
<span id="el_proposta_idproposta">
<span<?= $Page->idproposta->viewAttributes() ?>>
<?= $Page->idproposta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposta_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_proposta_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
    <tr id="r_cliente_idcliente"<?= $Page->cliente_idcliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposta_cliente_idcliente"><?= $Page->cliente_idcliente->caption() ?></span></td>
        <td data-name="cliente_idcliente"<?= $Page->cliente_idcliente->cellAttributes() ?>>
<span id="el_proposta_cliente_idcliente">
<span<?= $Page->cliente_idcliente->viewAttributes() ?>>
<?= $Page->cliente_idcliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->validade->Visible) { // validade ?>
    <tr id="r_validade"<?= $Page->validade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposta_validade"><?= $Page->validade->caption() ?></span></td>
        <td data-name="validade"<?= $Page->validade->cellAttributes() ?>>
<span id="el_proposta_validade">
<span<?= $Page->validade->viewAttributes() ?>>
<?= $Page->validade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mes_ano_conv_coletiva->Visible) { // mes_ano_conv_coletiva ?>
    <tr id="r_mes_ano_conv_coletiva"<?= $Page->mes_ano_conv_coletiva->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposta_mes_ano_conv_coletiva"><?= $Page->mes_ano_conv_coletiva->caption() ?></span></td>
        <td data-name="mes_ano_conv_coletiva"<?= $Page->mes_ano_conv_coletiva->cellAttributes() ?>>
<span id="el_proposta_mes_ano_conv_coletiva">
<span<?= $Page->mes_ano_conv_coletiva->viewAttributes() ?>>
<?= $Page->mes_ano_conv_coletiva->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sindicato->Visible) { // sindicato ?>
    <tr id="r_sindicato"<?= $Page->sindicato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposta_sindicato"><?= $Page->sindicato->caption() ?></span></td>
        <td data-name="sindicato"<?= $Page->sindicato->cellAttributes() ?>>
<span id="el_proposta_sindicato">
<span<?= $Page->sindicato->viewAttributes() ?>>
<?= $Page->sindicato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
    <tr id="r_cidade"<?= $Page->cidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposta_cidade"><?= $Page->cidade->caption() ?></span></td>
        <td data-name="cidade"<?= $Page->cidade->cellAttributes() ?>>
<span id="el_proposta_cidade">
<span<?= $Page->cidade->viewAttributes() ?>>
<?= $Page->cidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nr_meses->Visible) { // nr_meses ?>
    <tr id="r_nr_meses"<?= $Page->nr_meses->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposta_nr_meses"><?= $Page->nr_meses->caption() ?></span></td>
        <td data-name="nr_meses"<?= $Page->nr_meses->cellAttributes() ?>>
<span id="el_proposta_nr_meses">
<span<?= $Page->nr_meses->viewAttributes() ?>>
<?= $Page->nr_meses->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <tr id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposta_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></td>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_proposta_usuario_idusuario">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposta_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_proposta_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("planilha_custo", explode(",", $Page->getCurrentDetailTable())) && $planilha_custo->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("planilha_custo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PlanilhaCustoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("mov_insumo_cliente", explode(",", $Page->getCurrentDetailTable())) && $mov_insumo_cliente->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("mov_insumo_cliente", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MovInsumoClienteGrid.php" ?>
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
