<?php

namespace PHPMaker2024\contratos;

// Page object
$InsumoView = &$Page;
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
<form name="finsumoview" id="finsumoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { insumo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var finsumoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("finsumoview")
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
<input type="hidden" name="t" value="insumo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idinsumo->Visible) { // idinsumo ?>
    <tr id="r_idinsumo"<?= $Page->idinsumo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_insumo_idinsumo"><?= $Page->idinsumo->caption() ?></span></td>
        <td data-name="idinsumo"<?= $Page->idinsumo->cellAttributes() ?>>
<span id="el_insumo_idinsumo">
<span<?= $Page->idinsumo->viewAttributes() ?>>
<?= $Page->idinsumo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->insumo->Visible) { // insumo ?>
    <tr id="r_insumo"<?= $Page->insumo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_insumo_insumo"><?= $Page->insumo->caption() ?></span></td>
        <td data-name="insumo"<?= $Page->insumo->cellAttributes() ?>>
<span id="el_insumo_insumo">
<span<?= $Page->insumo->viewAttributes() ?>>
<?= $Page->insumo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
    <tr id="r_tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_insumo_tipo_insumo_idtipo_insumo"><?= $Page->tipo_insumo_idtipo_insumo->caption() ?></span></td>
        <td data-name="tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<span id="el_insumo_tipo_insumo_idtipo_insumo">
<span<?= $Page->tipo_insumo_idtipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo_idtipo_insumo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { // vr_unitario ?>
    <tr id="r_vr_unitario"<?= $Page->vr_unitario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_insumo_vr_unitario"><?= $Page->vr_unitario->caption() ?></span></td>
        <td data-name="vr_unitario"<?= $Page->vr_unitario->cellAttributes() ?>>
<span id="el_insumo_vr_unitario">
<span<?= $Page->vr_unitario->viewAttributes() ?>>
<?= $Page->vr_unitario->getViewValue() ?></span>
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
