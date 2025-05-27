<?php

namespace PHPMaker2024\contratos;

// Page object
$ClienteView = &$Page;
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
<form name="fclienteview" id="fclienteview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cliente: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fclienteview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fclienteview")
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
<input type="hidden" name="t" value="cliente">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idcliente->Visible) { // idcliente ?>
    <tr id="r_idcliente"<?= $Page->idcliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_idcliente"><?= $Page->idcliente->caption() ?></span></td>
        <td data-name="idcliente"<?= $Page->idcliente->cellAttributes() ?>>
<span id="el_cliente_idcliente">
<span<?= $Page->idcliente->viewAttributes() ?>>
<?= $Page->idcliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_cliente_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
    <tr id="r_cliente"<?= $Page->cliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_cliente"><?= $Page->cliente->caption() ?></span></td>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el_cliente_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->local_idlocal->Visible) { // local_idlocal ?>
    <tr id="r_local_idlocal"<?= $Page->local_idlocal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_local_idlocal"><?= $Page->local_idlocal->caption() ?></span></td>
        <td data-name="local_idlocal"<?= $Page->local_idlocal->cellAttributes() ?>>
<span id="el_cliente_local_idlocal">
<span<?= $Page->local_idlocal->viewAttributes() ?>>
<?= $Page->local_idlocal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cnpj->Visible) { // cnpj ?>
    <tr id="r_cnpj"<?= $Page->cnpj->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_cnpj"><?= $Page->cnpj->caption() ?></span></td>
        <td data-name="cnpj"<?= $Page->cnpj->cellAttributes() ?>>
<span id="el_cliente_cnpj">
<span<?= $Page->cnpj->viewAttributes() ?>>
<?= $Page->cnpj->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->endereco->Visible) { // endereco ?>
    <tr id="r_endereco"<?= $Page->endereco->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_endereco"><?= $Page->endereco->caption() ?></span></td>
        <td data-name="endereco"<?= $Page->endereco->cellAttributes() ?>>
<span id="el_cliente_endereco">
<span<?= $Page->endereco->viewAttributes() ?>>
<?= $Page->endereco->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->numero->Visible) { // numero ?>
    <tr id="r_numero"<?= $Page->numero->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_numero"><?= $Page->numero->caption() ?></span></td>
        <td data-name="numero"<?= $Page->numero->cellAttributes() ?>>
<span id="el_cliente_numero">
<span<?= $Page->numero->viewAttributes() ?>>
<?= $Page->numero->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bairro->Visible) { // bairro ?>
    <tr id="r_bairro"<?= $Page->bairro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_bairro"><?= $Page->bairro->caption() ?></span></td>
        <td data-name="bairro"<?= $Page->bairro->cellAttributes() ?>>
<span id="el_cliente_bairro">
<span<?= $Page->bairro->viewAttributes() ?>>
<?= $Page->bairro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cep->Visible) { // cep ?>
    <tr id="r_cep"<?= $Page->cep->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_cep"><?= $Page->cep->caption() ?></span></td>
        <td data-name="cep"<?= $Page->cep->cellAttributes() ?>>
<span id="el_cliente_cep">
<span<?= $Page->cep->viewAttributes() ?>>
<?= $Page->cep->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
    <tr id="r_cidade"<?= $Page->cidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_cidade"><?= $Page->cidade->caption() ?></span></td>
        <td data-name="cidade"<?= $Page->cidade->cellAttributes() ?>>
<span id="el_cliente_cidade">
<span<?= $Page->cidade->viewAttributes() ?>>
<?= $Page->cidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
    <tr id="r_uf"<?= $Page->uf->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_uf"><?= $Page->uf->caption() ?></span></td>
        <td data-name="uf"<?= $Page->uf->cellAttributes() ?>>
<span id="el_cliente_uf">
<span<?= $Page->uf->viewAttributes() ?>>
<?= $Page->uf->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contato->Visible) { // contato ?>
    <tr id="r_contato"<?= $Page->contato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_contato"><?= $Page->contato->caption() ?></span></td>
        <td data-name="contato"<?= $Page->contato->cellAttributes() ?>>
<span id="el_cliente_contato">
<span<?= $Page->contato->viewAttributes() ?>>
<?= $Page->contato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_cliente__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefone->Visible) { // telefone ?>
    <tr id="r_telefone"<?= $Page->telefone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_telefone"><?= $Page->telefone->caption() ?></span></td>
        <td data-name="telefone"<?= $Page->telefone->cellAttributes() ?>>
<span id="el_cliente_telefone">
<span<?= $Page->telefone->viewAttributes() ?>>
<?= $Page->telefone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <tr id="r_ativo"<?= $Page->ativo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cliente_ativo"><?= $Page->ativo->caption() ?></span></td>
        <td data-name="ativo"<?= $Page->ativo->cellAttributes() ?>>
<span id="el_cliente_ativo">
<span<?= $Page->ativo->viewAttributes() ?>>
<?= $Page->ativo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("faturamento", explode(",", $Page->getCurrentDetailTable())) && $faturamento->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("faturamento", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FaturamentoGrid.php" ?>
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
