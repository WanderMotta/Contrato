<?php

namespace PHPMaker2024\contratos;

// Page object
$ModuloView = &$Page;
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
<form name="fmoduloview" id="fmoduloview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { modulo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fmoduloview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmoduloview")
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
<input type="hidden" name="t" value="modulo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idmodulo->Visible) { // idmodulo ?>
    <tr id="r_idmodulo"<?= $Page->idmodulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_modulo_idmodulo"><?= $Page->idmodulo->caption() ?></span></td>
        <td data-name="idmodulo"<?= $Page->idmodulo->cellAttributes() ?>>
<span id="el_modulo_idmodulo">
<span<?= $Page->idmodulo->viewAttributes() ?>>
<?= $Page->idmodulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <tr id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_modulo_modulo"><?= $Page->modulo->caption() ?></span></td>
        <td data-name="modulo"<?= $Page->modulo->cellAttributes() ?>>
<span id="el_modulo_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->posicao->Visible) { // posicao ?>
    <tr id="r_posicao"<?= $Page->posicao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_modulo_posicao"><?= $Page->posicao->caption() ?></span></td>
        <td data-name="posicao"<?= $Page->posicao->cellAttributes() ?>>
<span id="el_modulo_posicao">
<span<?= $Page->posicao->viewAttributes() ?>>
<?= $Page->posicao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("itens_modulo", explode(",", $Page->getCurrentDetailTable())) && $itens_modulo->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("itens_modulo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ItensModuloGrid.php" ?>
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
