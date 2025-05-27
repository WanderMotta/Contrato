<?php

namespace PHPMaker2024\contratos;

// Page object
$DissidioAnualView = &$Page;
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
<form name="fdissidio_anualview" id="fdissidio_anualview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dissidio_anual: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fdissidio_anualview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdissidio_anualview")
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
<input type="hidden" name="t" value="dissidio_anual">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->iddissidio_anual->Visible) { // iddissidio_anual ?>
    <tr id="r_iddissidio_anual"<?= $Page->iddissidio_anual->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dissidio_anual_iddissidio_anual"><?= $Page->iddissidio_anual->caption() ?></span></td>
        <td data-name="iddissidio_anual"<?= $Page->iddissidio_anual->cellAttributes() ?>>
<span id="el_dissidio_anual_iddissidio_anual">
<span<?= $Page->iddissidio_anual->viewAttributes() ?>>
<?= $Page->iddissidio_anual->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <tr id="r_data"<?= $Page->data->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dissidio_anual_data"><?= $Page->data->caption() ?></span></td>
        <td data-name="data"<?= $Page->data->cellAttributes() ?>>
<span id="el_dissidio_anual_data">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dissidio_anual_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_dissidio_anual_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("dissidio", explode(",", $Page->getCurrentDetailTable())) && $dissidio->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("dissidio", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "DissidioGrid.php" ?>
<?php } ?>
<?php
    if (in_array("beneficios", explode(",", $Page->getCurrentDetailTable())) && $beneficios->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("beneficios", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "BeneficiosGrid.php" ?>
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
