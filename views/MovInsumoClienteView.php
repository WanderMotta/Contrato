<?php

namespace PHPMaker2024\contratos;

// Page object
$MovInsumoClienteView = &$Page;
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
<form name="fmov_insumo_clienteview" id="fmov_insumo_clienteview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mov_insumo_cliente: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fmov_insumo_clienteview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmov_insumo_clienteview")
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
<input type="hidden" name="t" value="mov_insumo_cliente">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idmov_insumo_cliente->Visible) { // idmov_insumo_cliente ?>
    <tr id="r_idmov_insumo_cliente"<?= $Page->idmov_insumo_cliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_cliente_idmov_insumo_cliente"><?= $Page->idmov_insumo_cliente->caption() ?></span></td>
        <td data-name="idmov_insumo_cliente"<?= $Page->idmov_insumo_cliente->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_idmov_insumo_cliente">
<span<?= $Page->idmov_insumo_cliente->viewAttributes() ?>>
<?= $Page->idmov_insumo_cliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_cliente_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
    <tr id="r_tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_cliente_tipo_insumo_idtipo_insumo"><?= $Page->tipo_insumo_idtipo_insumo->caption() ?></span></td>
        <td data-name="tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_tipo_insumo_idtipo_insumo">
<span<?= $Page->tipo_insumo_idtipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo_idtipo_insumo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
    <tr id="r_insumo_idinsumo"<?= $Page->insumo_idinsumo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_cliente_insumo_idinsumo"><?= $Page->insumo_idinsumo->caption() ?></span></td>
        <td data-name="insumo_idinsumo"<?= $Page->insumo_idinsumo->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_insumo_idinsumo">
<span<?= $Page->insumo_idinsumo->viewAttributes() ?>>
<?= $Page->insumo_idinsumo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
    <tr id="r_qtde"<?= $Page->qtde->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_cliente_qtde"><?= $Page->qtde->caption() ?></span></td>
        <td data-name="qtde"<?= $Page->qtde->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_qtde">
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
    <tr id="r_frequencia"<?= $Page->frequencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_cliente_frequencia"><?= $Page->frequencia->caption() ?></span></td>
        <td data-name="frequencia"<?= $Page->frequencia->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_frequencia">
<span<?= $Page->frequencia->viewAttributes() ?>>
<?= $Page->frequencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vr_unit->Visible) { // vr_unit ?>
    <tr id="r_vr_unit"<?= $Page->vr_unit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_cliente_vr_unit"><?= $Page->vr_unit->caption() ?></span></td>
        <td data-name="vr_unit"<?= $Page->vr_unit->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_vr_unit">
<span<?= $Page->vr_unit->viewAttributes() ?>>
<?= $Page->vr_unit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vr_total->Visible) { // vr_total ?>
    <tr id="r_vr_total"<?= $Page->vr_total->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_cliente_vr_total"><?= $Page->vr_total->caption() ?></span></td>
        <td data-name="vr_total"<?= $Page->vr_total->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_vr_total">
<span<?= $Page->vr_total->viewAttributes() ?>>
<?= $Page->vr_total->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
    <tr id="r_proposta_idproposta"<?= $Page->proposta_idproposta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mov_insumo_cliente_proposta_idproposta"><?= $Page->proposta_idproposta->caption() ?></span></td>
        <td data-name="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_proposta_idproposta">
<span<?= $Page->proposta_idproposta->viewAttributes() ?>>
<?= $Page->proposta_idproposta->getViewValue() ?></span>
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
