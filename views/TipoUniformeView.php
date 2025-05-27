<?php

namespace PHPMaker2024\contratos;

// Page object
$TipoUniformeView = &$Page;
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
<form name="ftipo_uniformeview" id="ftipo_uniformeview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipo_uniforme: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var ftipo_uniformeview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipo_uniformeview")
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
<input type="hidden" name="t" value="tipo_uniforme">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idtipo_uniforme->Visible) { // idtipo_uniforme ?>
    <tr id="r_idtipo_uniforme"<?= $Page->idtipo_uniforme->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_uniforme_idtipo_uniforme"><?= $Page->idtipo_uniforme->caption() ?></span></td>
        <td data-name="idtipo_uniforme"<?= $Page->idtipo_uniforme->cellAttributes() ?>>
<span id="el_tipo_uniforme_idtipo_uniforme">
<span<?= $Page->idtipo_uniforme->viewAttributes() ?>>
<?= $Page->idtipo_uniforme->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_uniforme->Visible) { // tipo_uniforme ?>
    <tr id="r_tipo_uniforme"<?= $Page->tipo_uniforme->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_uniforme_tipo_uniforme"><?= $Page->tipo_uniforme->caption() ?></span></td>
        <td data-name="tipo_uniforme"<?= $Page->tipo_uniforme->cellAttributes() ?>>
<span id="el_tipo_uniforme_tipo_uniforme">
<span<?= $Page->tipo_uniforme->viewAttributes() ?>>
<?= $Page->tipo_uniforme->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("uniforme_cargo", explode(",", $Page->getCurrentDetailTable())) && $uniforme_cargo->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("uniforme_cargo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "UniformeCargoGrid.php" ?>
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
