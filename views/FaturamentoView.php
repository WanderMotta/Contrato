<?php

namespace PHPMaker2024\contratos;

// Page object
$FaturamentoView = &$Page;
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
<form name="ffaturamentoview" id="ffaturamentoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { faturamento: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var ffaturamentoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffaturamentoview")
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
<input type="hidden" name="t" value="faturamento">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idfaturamento->Visible) { // idfaturamento ?>
    <tr id="r_idfaturamento"<?= $Page->idfaturamento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_idfaturamento"><?= $Page->idfaturamento->caption() ?></span></td>
        <td data-name="idfaturamento"<?= $Page->idfaturamento->cellAttributes() ?>>
<span id="el_faturamento_idfaturamento">
<span<?= $Page->idfaturamento->viewAttributes() ?>>
<?= $Page->idfaturamento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->faturamento->Visible) { // faturamento ?>
    <tr id="r_faturamento"<?= $Page->faturamento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_faturamento"><?= $Page->faturamento->caption() ?></span></td>
        <td data-name="faturamento"<?= $Page->faturamento->cellAttributes() ?>>
<span id="el_faturamento_faturamento">
<span<?= $Page->faturamento->viewAttributes() ?>>
<?= $Page->faturamento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cnpj->Visible) { // cnpj ?>
    <tr id="r_cnpj"<?= $Page->cnpj->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_cnpj"><?= $Page->cnpj->caption() ?></span></td>
        <td data-name="cnpj"<?= $Page->cnpj->cellAttributes() ?>>
<span id="el_faturamento_cnpj">
<span<?= $Page->cnpj->viewAttributes() ?>>
<?= $Page->cnpj->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->endereco->Visible) { // endereco ?>
    <tr id="r_endereco"<?= $Page->endereco->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_endereco"><?= $Page->endereco->caption() ?></span></td>
        <td data-name="endereco"<?= $Page->endereco->cellAttributes() ?>>
<span id="el_faturamento_endereco">
<span<?= $Page->endereco->viewAttributes() ?>>
<?= $Page->endereco->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bairro->Visible) { // bairro ?>
    <tr id="r_bairro"<?= $Page->bairro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_bairro"><?= $Page->bairro->caption() ?></span></td>
        <td data-name="bairro"<?= $Page->bairro->cellAttributes() ?>>
<span id="el_faturamento_bairro">
<span<?= $Page->bairro->viewAttributes() ?>>
<?= $Page->bairro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
    <tr id="r_cidade"<?= $Page->cidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_cidade"><?= $Page->cidade->caption() ?></span></td>
        <td data-name="cidade"<?= $Page->cidade->cellAttributes() ?>>
<span id="el_faturamento_cidade">
<span<?= $Page->cidade->viewAttributes() ?>>
<?= $Page->cidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
    <tr id="r_uf"<?= $Page->uf->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_uf"><?= $Page->uf->caption() ?></span></td>
        <td data-name="uf"<?= $Page->uf->cellAttributes() ?>>
<span id="el_faturamento_uf">
<span<?= $Page->uf->viewAttributes() ?>>
<?= $Page->uf->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dia_vencimento->Visible) { // dia_vencimento ?>
    <tr id="r_dia_vencimento"<?= $Page->dia_vencimento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_dia_vencimento"><?= $Page->dia_vencimento->caption() ?></span></td>
        <td data-name="dia_vencimento"<?= $Page->dia_vencimento->cellAttributes() ?>>
<span id="el_faturamento_dia_vencimento">
<span<?= $Page->dia_vencimento->viewAttributes() ?>>
<?= $Page->dia_vencimento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->origem->Visible) { // origem ?>
    <tr id="r_origem"<?= $Page->origem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_origem"><?= $Page->origem->caption() ?></span></td>
        <td data-name="origem"<?= $Page->origem->cellAttributes() ?>>
<span id="el_faturamento_origem">
<span<?= $Page->origem->viewAttributes() ?>>
<?= $Page->origem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_faturamento_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
    <tr id="r_cliente_idcliente"<?= $Page->cliente_idcliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_faturamento_cliente_idcliente"><?= $Page->cliente_idcliente->caption() ?></span></td>
        <td data-name="cliente_idcliente"<?= $Page->cliente_idcliente->cellAttributes() ?>>
<span id="el_faturamento_cliente_idcliente">
<span<?= $Page->cliente_idcliente->viewAttributes() ?>>
<?= $Page->cliente_idcliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("contato", explode(",", $Page->getCurrentDetailTable())) && $contato->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("contato", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ContatoGrid.php" ?>
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
