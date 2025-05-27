<?php

namespace PHPMaker2024\contratos;

// Page object
$FuncaoView = &$Page;
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
<form name="ffuncaoview" id="ffuncaoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { funcao: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var ffuncaoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffuncaoview")
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
<input type="hidden" name="t" value="funcao">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idfuncao->Visible) { // idfuncao ?>
    <tr id="r_idfuncao"<?= $Page->idfuncao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_funcao_idfuncao"><?= $Page->idfuncao->caption() ?></span></td>
        <td data-name="idfuncao"<?= $Page->idfuncao->cellAttributes() ?>>
<span id="el_funcao_idfuncao">
<span<?= $Page->idfuncao->viewAttributes() ?>>
<?= $Page->idfuncao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->funcao->Visible) { // funcao ?>
    <tr id="r_funcao"<?= $Page->funcao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_funcao_funcao"><?= $Page->funcao->caption() ?></span></td>
        <td data-name="funcao"<?= $Page->funcao->cellAttributes() ?>>
<span id="el_funcao_funcao">
<span<?= $Page->funcao->viewAttributes() ?>>
<?= $Page->funcao->getViewValue() ?></span>
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
