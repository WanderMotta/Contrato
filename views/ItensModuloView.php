<?php

namespace PHPMaker2024\contratos;

// Page object
$ItensModuloView = &$Page;
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
<form name="fitens_moduloview" id="fitens_moduloview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { itens_modulo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fitens_moduloview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fitens_moduloview")
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
<input type="hidden" name="t" value="itens_modulo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->iditens_modulo->Visible) { // iditens_modulo ?>
    <tr id="r_iditens_modulo"<?= $Page->iditens_modulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_itens_modulo_iditens_modulo"><?= $Page->iditens_modulo->caption() ?></span></td>
        <td data-name="iditens_modulo"<?= $Page->iditens_modulo->cellAttributes() ?>>
<span id="el_itens_modulo_iditens_modulo">
<span<?= $Page->iditens_modulo->viewAttributes() ?>>
<?= $Page->iditens_modulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
    <tr id="r_modulo_idmodulo"<?= $Page->modulo_idmodulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_itens_modulo_modulo_idmodulo"><?= $Page->modulo_idmodulo->caption() ?></span></td>
        <td data-name="modulo_idmodulo"<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<span id="el_itens_modulo_modulo_idmodulo">
<span<?= $Page->modulo_idmodulo->viewAttributes() ?>>
<?= $Page->modulo_idmodulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->item->Visible) { // item ?>
    <tr id="r_item"<?= $Page->item->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_itens_modulo_item"><?= $Page->item->caption() ?></span></td>
        <td data-name="item"<?= $Page->item->cellAttributes() ?>>
<span id="el_itens_modulo_item">
<span<?= $Page->item->viewAttributes() ?>>
<?= $Page->item->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->porcentagem_valor->Visible) { // porcentagem_valor ?>
    <tr id="r_porcentagem_valor"<?= $Page->porcentagem_valor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_itens_modulo_porcentagem_valor"><?= $Page->porcentagem_valor->caption() ?></span></td>
        <td data-name="porcentagem_valor"<?= $Page->porcentagem_valor->cellAttributes() ?>>
<span id="el_itens_modulo_porcentagem_valor">
<span<?= $Page->porcentagem_valor->viewAttributes() ?>>
<?= $Page->porcentagem_valor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->incidencia_inss->Visible) { // incidencia_inss ?>
    <tr id="r_incidencia_inss"<?= $Page->incidencia_inss->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_itens_modulo_incidencia_inss"><?= $Page->incidencia_inss->caption() ?></span></td>
        <td data-name="incidencia_inss"<?= $Page->incidencia_inss->cellAttributes() ?>>
<span id="el_itens_modulo_incidencia_inss">
<span<?= $Page->incidencia_inss->viewAttributes() ?>>
<?= $Page->incidencia_inss->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <tr id="r_ativo"<?= $Page->ativo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_itens_modulo_ativo"><?= $Page->ativo->caption() ?></span></td>
        <td data-name="ativo"<?= $Page->ativo->cellAttributes() ?>>
<span id="el_itens_modulo_ativo">
<span<?= $Page->ativo->viewAttributes() ?>>
<?= $Page->ativo->getViewValue() ?></span>
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
