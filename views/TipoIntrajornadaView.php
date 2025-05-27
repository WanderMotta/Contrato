<?php

namespace PHPMaker2024\contratos;

// Page object
$TipoIntrajornadaView = &$Page;
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
<form name="ftipo_intrajornadaview" id="ftipo_intrajornadaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipo_intrajornada: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var ftipo_intrajornadaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipo_intrajornadaview")
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
<input type="hidden" name="t" value="tipo_intrajornada">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idtipo_intrajornada->Visible) { // idtipo_intrajornada ?>
    <tr id="r_idtipo_intrajornada"<?= $Page->idtipo_intrajornada->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_intrajornada_idtipo_intrajornada"><?= $Page->idtipo_intrajornada->caption() ?></span></td>
        <td data-name="idtipo_intrajornada"<?= $Page->idtipo_intrajornada->cellAttributes() ?>>
<span id="el_tipo_intrajornada_idtipo_intrajornada">
<span<?= $Page->idtipo_intrajornada->viewAttributes() ?>>
<?= $Page->idtipo_intrajornada->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->intrajornada_tipo->Visible) { // intrajornada_tipo ?>
    <tr id="r_intrajornada_tipo"<?= $Page->intrajornada_tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_intrajornada_intrajornada_tipo"><?= $Page->intrajornada_tipo->caption() ?></span></td>
        <td data-name="intrajornada_tipo"<?= $Page->intrajornada_tipo->cellAttributes() ?>>
<span id="el_tipo_intrajornada_intrajornada_tipo">
<span<?= $Page->intrajornada_tipo->viewAttributes() ?>>
<?= $Page->intrajornada_tipo->getViewValue() ?></span>
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
