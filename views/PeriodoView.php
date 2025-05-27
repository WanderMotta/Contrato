<?php

namespace PHPMaker2024\contratos;

// Page object
$PeriodoView = &$Page;
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
<form name="fperiodoview" id="fperiodoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { periodo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fperiodoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fperiodoview")
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
<input type="hidden" name="t" value="periodo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idperiodo->Visible) { // idperiodo ?>
    <tr id="r_idperiodo"<?= $Page->idperiodo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_periodo_idperiodo"><?= $Page->idperiodo->caption() ?></span></td>
        <td data-name="idperiodo"<?= $Page->idperiodo->cellAttributes() ?>>
<span id="el_periodo_idperiodo">
<span<?= $Page->idperiodo->viewAttributes() ?>>
<?= $Page->idperiodo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->periodo->Visible) { // periodo ?>
    <tr id="r_periodo"<?= $Page->periodo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_periodo_periodo"><?= $Page->periodo->caption() ?></span></td>
        <td data-name="periodo"<?= $Page->periodo->cellAttributes() ?>>
<span id="el_periodo_periodo">
<span<?= $Page->periodo->viewAttributes() ?>>
<?= $Page->periodo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fator->Visible) { // fator ?>
    <tr id="r_fator"<?= $Page->fator->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_periodo_fator"><?= $Page->fator->caption() ?></span></td>
        <td data-name="fator"<?= $Page->fator->cellAttributes() ?>>
<span id="el_periodo_fator">
<span<?= $Page->fator->viewAttributes() ?>>
<?= $Page->fator->getViewValue() ?></span>
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
