<?php

namespace PHPMaker2024\contratos;

// Page object
$CalculoView = &$Page;
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
<form name="fcalculoview" id="fcalculoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { calculo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcalculoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcalculoview")
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
<input type="hidden" name="t" value="calculo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idcalculo->Visible) { // idcalculo ?>
    <tr id="r_idcalculo"<?= $Page->idcalculo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_calculo_idcalculo"><?= $Page->idcalculo->caption() ?></span></td>
        <td data-name="idcalculo"<?= $Page->idcalculo->cellAttributes() ?>>
<span id="el_calculo_idcalculo">
<span<?= $Page->idcalculo->viewAttributes() ?>>
<?= $Page->idcalculo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_calculo_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_calculo_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->calculo->Visible) { // calculo ?>
    <tr id="r_calculo"<?= $Page->calculo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_calculo_calculo"><?= $Page->calculo->caption() ?></span></td>
        <td data-name="calculo"<?= $Page->calculo->cellAttributes() ?>>
<span id="el_calculo_calculo">
<span<?= $Page->calculo->viewAttributes() ?>>
<?= $Page->calculo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("movimento_pla_custo", explode(",", $Page->getCurrentDetailTable())) && $movimento_pla_custo->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("movimento_pla_custo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MovimentoPlaCustoGrid.php" ?>
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
