<?php

namespace PHPMaker2024\contratos;

// Page object
$UniformeCargoView = &$Page;
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
<form name="funiforme_cargoview" id="funiforme_cargoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { uniforme_cargo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var funiforme_cargoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("funiforme_cargoview")
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
<input type="hidden" name="t" value="uniforme_cargo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->iduniforme_cargo->Visible) { // iduniforme_cargo ?>
    <tr id="r_iduniforme_cargo"<?= $Page->iduniforme_cargo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_uniforme_cargo_iduniforme_cargo"><?= $Page->iduniforme_cargo->caption() ?></span></td>
        <td data-name="iduniforme_cargo"<?= $Page->iduniforme_cargo->cellAttributes() ?>>
<span id="el_uniforme_cargo_iduniforme_cargo">
<span<?= $Page->iduniforme_cargo->viewAttributes() ?>>
<?= $Page->iduniforme_cargo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uniforme_iduniforme->Visible) { // uniforme_iduniforme ?>
    <tr id="r_uniforme_iduniforme"<?= $Page->uniforme_iduniforme->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_uniforme_cargo_uniforme_iduniforme"><?= $Page->uniforme_iduniforme->caption() ?></span></td>
        <td data-name="uniforme_iduniforme"<?= $Page->uniforme_iduniforme->cellAttributes() ?>>
<span id="el_uniforme_cargo_uniforme_iduniforme">
<span<?= $Page->uniforme_iduniforme->viewAttributes() ?>>
<?= $Page->uniforme_iduniforme->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
    <tr id="r_tipo_uniforme_idtipo_uniforme"<?= $Page->tipo_uniforme_idtipo_uniforme->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_uniforme_cargo_tipo_uniforme_idtipo_uniforme"><?= $Page->tipo_uniforme_idtipo_uniforme->caption() ?></span></td>
        <td data-name="tipo_uniforme_idtipo_uniforme"<?= $Page->tipo_uniforme_idtipo_uniforme->cellAttributes() ?>>
<span id="el_uniforme_cargo_tipo_uniforme_idtipo_uniforme">
<span<?= $Page->tipo_uniforme_idtipo_uniforme->viewAttributes() ?>>
<?= $Page->tipo_uniforme_idtipo_uniforme->getViewValue() ?></span>
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
