<?php

namespace PHPMaker2024\contratos;

// Page object
$EscalaView = &$Page;
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
<form name="fescalaview" id="fescalaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { escala: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fescalaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fescalaview")
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
<input type="hidden" name="t" value="escala">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idescala->Visible) { // idescala ?>
    <tr id="r_idescala"<?= $Page->idescala->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escala_idescala"><?= $Page->idescala->caption() ?></span></td>
        <td data-name="idescala"<?= $Page->idescala->cellAttributes() ?>>
<span id="el_escala_idescala">
<span<?= $Page->idescala->viewAttributes() ?>>
<?= $Page->idescala->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->escala->Visible) { // escala ?>
    <tr id="r_escala"<?= $Page->escala->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escala_escala"><?= $Page->escala->caption() ?></span></td>
        <td data-name="escala"<?= $Page->escala->cellAttributes() ?>>
<span id="el_escala_escala">
<span<?= $Page->escala->viewAttributes() ?>>
<?= $Page->escala->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nr_dias_mes->Visible) { // nr_dias_mes ?>
    <tr id="r_nr_dias_mes"<?= $Page->nr_dias_mes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escala_nr_dias_mes"><?= $Page->nr_dias_mes->caption() ?></span></td>
        <td data-name="nr_dias_mes"<?= $Page->nr_dias_mes->cellAttributes() ?>>
<span id="el_escala_nr_dias_mes">
<span<?= $Page->nr_dias_mes->viewAttributes() ?>>
<?= $Page->nr_dias_mes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->intra_sdf->Visible) { // intra_sdf ?>
    <tr id="r_intra_sdf"<?= $Page->intra_sdf->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escala_intra_sdf"><?= $Page->intra_sdf->caption() ?></span></td>
        <td data-name="intra_sdf"<?= $Page->intra_sdf->cellAttributes() ?>>
<span id="el_escala_intra_sdf">
<span<?= $Page->intra_sdf->viewAttributes() ?>>
<?= $Page->intra_sdf->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->intra_df->Visible) { // intra_df ?>
    <tr id="r_intra_df"<?= $Page->intra_df->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escala_intra_df"><?= $Page->intra_df->caption() ?></span></td>
        <td data-name="intra_df"<?= $Page->intra_df->cellAttributes() ?>>
<span id="el_escala_intra_df">
<span<?= $Page->intra_df->viewAttributes() ?>>
<?= $Page->intra_df->getViewValue() ?></span>
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
