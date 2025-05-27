<?php

namespace PHPMaker2024\contratos;

// Page object
$TipoInsumoView = &$Page;
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
<form name="ftipo_insumoview" id="ftipo_insumoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipo_insumo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var ftipo_insumoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipo_insumoview")
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
<input type="hidden" name="t" value="tipo_insumo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idtipo_insumo->Visible) { // idtipo_insumo ?>
    <tr id="r_idtipo_insumo"<?= $Page->idtipo_insumo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_insumo_idtipo_insumo"><?= $Page->idtipo_insumo->caption() ?></span></td>
        <td data-name="idtipo_insumo"<?= $Page->idtipo_insumo->cellAttributes() ?>>
<span id="el_tipo_insumo_idtipo_insumo">
<span<?= $Page->idtipo_insumo->viewAttributes() ?>>
<?= $Page->idtipo_insumo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
    <tr id="r_tipo_insumo"<?= $Page->tipo_insumo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_insumo_tipo_insumo"><?= $Page->tipo_insumo->caption() ?></span></td>
        <td data-name="tipo_insumo"<?= $Page->tipo_insumo->cellAttributes() ?>>
<span id="el_tipo_insumo_tipo_insumo">
<span<?= $Page->tipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo->getViewValue() ?></span>
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
