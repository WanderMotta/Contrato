<?php

namespace PHPMaker2024\contratos;

// Page object
$ContatoView = &$Page;
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
<form name="fcontatoview" id="fcontatoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contato: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcontatoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcontatoview")
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
<input type="hidden" name="t" value="contato">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idcontato->Visible) { // idcontato ?>
    <tr id="r_idcontato"<?= $Page->idcontato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contato_idcontato"><?= $Page->idcontato->caption() ?></span></td>
        <td data-name="idcontato"<?= $Page->idcontato->cellAttributes() ?>>
<span id="el_contato_idcontato">
<span<?= $Page->idcontato->viewAttributes() ?>>
<?= $Page->idcontato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contato->Visible) { // contato ?>
    <tr id="r_contato"<?= $Page->contato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contato_contato"><?= $Page->contato->caption() ?></span></td>
        <td data-name="contato"<?= $Page->contato->cellAttributes() ?>>
<span id="el_contato_contato">
<span<?= $Page->contato->viewAttributes() ?>>
<?= $Page->contato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contato__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_contato__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefone->Visible) { // telefone ?>
    <tr id="r_telefone"<?= $Page->telefone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contato_telefone"><?= $Page->telefone->caption() ?></span></td>
        <td data-name="telefone"<?= $Page->telefone->cellAttributes() ?>>
<span id="el_contato_telefone">
<span<?= $Page->telefone->viewAttributes() ?>>
<?= $Page->telefone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contato_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_contato_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <tr id="r_ativo"<?= $Page->ativo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contato_ativo"><?= $Page->ativo->caption() ?></span></td>
        <td data-name="ativo"<?= $Page->ativo->cellAttributes() ?>>
<span id="el_contato_ativo">
<span<?= $Page->ativo->viewAttributes() ?>>
<?= $Page->ativo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->faturamento_idfaturamento->Visible) { // faturamento_idfaturamento ?>
    <tr id="r_faturamento_idfaturamento"<?= $Page->faturamento_idfaturamento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contato_faturamento_idfaturamento"><?= $Page->faturamento_idfaturamento->caption() ?></span></td>
        <td data-name="faturamento_idfaturamento"<?= $Page->faturamento_idfaturamento->cellAttributes() ?>>
<span id="el_contato_faturamento_idfaturamento">
<span<?= $Page->faturamento_idfaturamento->viewAttributes() ?>>
<?= $Page->faturamento_idfaturamento->getViewValue() ?></span>
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
