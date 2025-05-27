<?php

namespace PHPMaker2024\contratos;

// Page object
$BeneficiosView = &$Page;
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
<form name="fbeneficiosview" id="fbeneficiosview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { beneficios: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fbeneficiosview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fbeneficiosview")
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
<input type="hidden" name="t" value="beneficios">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idbeneficios->Visible) { // idbeneficios ?>
    <tr id="r_idbeneficios"<?= $Page->idbeneficios->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_beneficios_idbeneficios"><?= $Page->idbeneficios->caption() ?></span></td>
        <td data-name="idbeneficios"<?= $Page->idbeneficios->cellAttributes() ?>>
<span id="el_beneficios_idbeneficios">
<span<?= $Page->idbeneficios->viewAttributes() ?>>
<?= $Page->idbeneficios->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <tr id="r_data"<?= $Page->data->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_beneficios_data"><?= $Page->data->caption() ?></span></td>
        <td data-name="data"<?= $Page->data->cellAttributes() ?>>
<span id="el_beneficios_data">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
    <tr id="r_vt_dia"<?= $Page->vt_dia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_beneficios_vt_dia"><?= $Page->vt_dia->caption() ?></span></td>
        <td data-name="vt_dia"<?= $Page->vt_dia->cellAttributes() ?>>
<span id="el_beneficios_vt_dia">
<span<?= $Page->vt_dia->viewAttributes() ?>>
<?= $Page->vt_dia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
    <tr id="r_vr_dia"<?= $Page->vr_dia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_beneficios_vr_dia"><?= $Page->vr_dia->caption() ?></span></td>
        <td data-name="vr_dia"<?= $Page->vr_dia->cellAttributes() ?>>
<span id="el_beneficios_vr_dia">
<span<?= $Page->vr_dia->viewAttributes() ?>>
<?= $Page->vr_dia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
    <tr id="r_va_mes"<?= $Page->va_mes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_beneficios_va_mes"><?= $Page->va_mes->caption() ?></span></td>
        <td data-name="va_mes"<?= $Page->va_mes->cellAttributes() ?>>
<span id="el_beneficios_va_mes">
<span<?= $Page->va_mes->viewAttributes() ?>>
<?= $Page->va_mes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
    <tr id="r_benef_social"<?= $Page->benef_social->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_beneficios_benef_social"><?= $Page->benef_social->caption() ?></span></td>
        <td data-name="benef_social"<?= $Page->benef_social->cellAttributes() ?>>
<span id="el_beneficios_benef_social">
<span<?= $Page->benef_social->viewAttributes() ?>>
<?= $Page->benef_social->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
    <tr id="r_plr"<?= $Page->plr->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_beneficios_plr"><?= $Page->plr->caption() ?></span></td>
        <td data-name="plr"<?= $Page->plr->cellAttributes() ?>>
<span id="el_beneficios_plr">
<span<?= $Page->plr->viewAttributes() ?>>
<?= $Page->plr->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
    <tr id="r_assis_medica"<?= $Page->assis_medica->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_beneficios_assis_medica"><?= $Page->assis_medica->caption() ?></span></td>
        <td data-name="assis_medica"<?= $Page->assis_medica->cellAttributes() ?>>
<span id="el_beneficios_assis_medica">
<span<?= $Page->assis_medica->viewAttributes() ?>>
<?= $Page->assis_medica->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
    <tr id="r_assis_odonto"<?= $Page->assis_odonto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_beneficios_assis_odonto"><?= $Page->assis_odonto->caption() ?></span></td>
        <td data-name="assis_odonto"<?= $Page->assis_odonto->cellAttributes() ?>>
<span id="el_beneficios_assis_odonto">
<span<?= $Page->assis_odonto->viewAttributes() ?>>
<?= $Page->assis_odonto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dissidio_anual_iddissidio_anual->Visible) { // dissidio_anual_iddissidio_anual ?>
    <tr id="r_dissidio_anual_iddissidio_anual"<?= $Page->dissidio_anual_iddissidio_anual->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_beneficios_dissidio_anual_iddissidio_anual"><?= $Page->dissidio_anual_iddissidio_anual->caption() ?></span></td>
        <td data-name="dissidio_anual_iddissidio_anual"<?= $Page->dissidio_anual_iddissidio_anual->cellAttributes() ?>>
<span id="el_beneficios_dissidio_anual_iddissidio_anual">
<span<?= $Page->dissidio_anual_iddissidio_anual->viewAttributes() ?>>
<?= $Page->dissidio_anual_iddissidio_anual->getViewValue() ?></span>
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
