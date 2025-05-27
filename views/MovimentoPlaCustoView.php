<?php

namespace PHPMaker2024\contratos;

// Page object
$MovimentoPlaCustoView = &$Page;
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
<form name="fmovimento_pla_custoview" id="fmovimento_pla_custoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { movimento_pla_custo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fmovimento_pla_custoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmovimento_pla_custoview")
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
<input type="hidden" name="t" value="movimento_pla_custo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idmovimento_pla_custo->Visible) { // idmovimento_pla_custo ?>
    <tr id="r_idmovimento_pla_custo"<?= $Page->idmovimento_pla_custo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_movimento_pla_custo_idmovimento_pla_custo"><?= $Page->idmovimento_pla_custo->caption() ?></span></td>
        <td data-name="idmovimento_pla_custo"<?= $Page->idmovimento_pla_custo->cellAttributes() ?>>
<span id="el_movimento_pla_custo_idmovimento_pla_custo">
<span<?= $Page->idmovimento_pla_custo->viewAttributes() ?>>
<?= $Page->idmovimento_pla_custo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
    <tr id="r_planilha_custo_idplanilha_custo"<?= $Page->planilha_custo_idplanilha_custo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_movimento_pla_custo_planilha_custo_idplanilha_custo"><?= $Page->planilha_custo_idplanilha_custo->caption() ?></span></td>
        <td data-name="planilha_custo_idplanilha_custo"<?= $Page->planilha_custo_idplanilha_custo->cellAttributes() ?>>
<span id="el_movimento_pla_custo_planilha_custo_idplanilha_custo">
<span<?= $Page->planilha_custo_idplanilha_custo->viewAttributes() ?>>
<?= $Page->planilha_custo_idplanilha_custo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_movimento_pla_custo_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_movimento_pla_custo_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
    <tr id="r_modulo_idmodulo"<?= $Page->modulo_idmodulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_movimento_pla_custo_modulo_idmodulo"><?= $Page->modulo_idmodulo->caption() ?></span></td>
        <td data-name="modulo_idmodulo"<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<span id="el_movimento_pla_custo_modulo_idmodulo">
<span<?= $Page->modulo_idmodulo->viewAttributes() ?>>
<?= $Page->modulo_idmodulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
    <tr id="r_itens_modulo_iditens_modulo"<?= $Page->itens_modulo_iditens_modulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_movimento_pla_custo_itens_modulo_iditens_modulo"><?= $Page->itens_modulo_iditens_modulo->caption() ?></span></td>
        <td data-name="itens_modulo_iditens_modulo"<?= $Page->itens_modulo_iditens_modulo->cellAttributes() ?>>
<span id="el_movimento_pla_custo_itens_modulo_iditens_modulo">
<span<?= $Page->itens_modulo_iditens_modulo->viewAttributes() ?>>
<?= $Page->itens_modulo_iditens_modulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { // porcentagem ?>
    <tr id="r_porcentagem"<?= $Page->porcentagem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_movimento_pla_custo_porcentagem"><?= $Page->porcentagem->caption() ?></span></td>
        <td data-name="porcentagem"<?= $Page->porcentagem->cellAttributes() ?>>
<span id="el_movimento_pla_custo_porcentagem">
<span<?= $Page->porcentagem->viewAttributes() ?>>
<?= $Page->porcentagem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
    <tr id="r_valor"<?= $Page->valor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_movimento_pla_custo_valor"><?= $Page->valor->caption() ?></span></td>
        <td data-name="valor"<?= $Page->valor->cellAttributes() ?>>
<span id="el_movimento_pla_custo_valor">
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_movimento_pla_custo_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_movimento_pla_custo_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
    <tr id="r_calculo_idcalculo"<?= $Page->calculo_idcalculo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_movimento_pla_custo_calculo_idcalculo"><?= $Page->calculo_idcalculo->caption() ?></span></td>
        <td data-name="calculo_idcalculo"<?= $Page->calculo_idcalculo->cellAttributes() ?>>
<span id="el_movimento_pla_custo_calculo_idcalculo">
<span<?= $Page->calculo_idcalculo->viewAttributes() ?>>
<?= $Page->calculo_idcalculo->getViewValue() ?></span>
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
