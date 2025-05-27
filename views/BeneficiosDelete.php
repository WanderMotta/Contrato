<?php

namespace PHPMaker2024\contratos;

// Page object
$BeneficiosDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { beneficios: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fbeneficiosdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fbeneficiosdelete")
        .setPageId("delete")
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fbeneficiosdelete" id="fbeneficiosdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="beneficios">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->data->Visible) { // data ?>
        <th class="<?= $Page->data->headerCellClass() ?>"><span id="elh_beneficios_data" class="beneficios_data"><?= $Page->data->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <th class="<?= $Page->vt_dia->headerCellClass() ?>"><span id="elh_beneficios_vt_dia" class="beneficios_vt_dia"><?= $Page->vt_dia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <th class="<?= $Page->vr_dia->headerCellClass() ?>"><span id="elh_beneficios_vr_dia" class="beneficios_vr_dia"><?= $Page->vr_dia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
        <th class="<?= $Page->va_mes->headerCellClass() ?>"><span id="elh_beneficios_va_mes" class="beneficios_va_mes"><?= $Page->va_mes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
        <th class="<?= $Page->benef_social->headerCellClass() ?>"><span id="elh_beneficios_benef_social" class="beneficios_benef_social"><?= $Page->benef_social->caption() ?></span></th>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
        <th class="<?= $Page->plr->headerCellClass() ?>"><span id="elh_beneficios_plr" class="beneficios_plr"><?= $Page->plr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <th class="<?= $Page->assis_medica->headerCellClass() ?>"><span id="elh_beneficios_assis_medica" class="beneficios_assis_medica"><?= $Page->assis_medica->caption() ?></span></th>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <th class="<?= $Page->assis_odonto->headerCellClass() ?>"><span id="elh_beneficios_assis_odonto" class="beneficios_assis_odonto"><?= $Page->assis_odonto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dissidio_anual_iddissidio_anual->Visible) { // dissidio_anual_iddissidio_anual ?>
        <th class="<?= $Page->dissidio_anual_iddissidio_anual->headerCellClass() ?>"><span id="elh_beneficios_dissidio_anual_iddissidio_anual" class="beneficios_dissidio_anual_iddissidio_anual"><?= $Page->dissidio_anual_iddissidio_anual->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->data->Visible) { // data ?>
        <td<?= $Page->data->cellAttributes() ?>>
<span id="">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <td<?= $Page->vt_dia->cellAttributes() ?>>
<span id="">
<span<?= $Page->vt_dia->viewAttributes() ?>>
<?= $Page->vt_dia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <td<?= $Page->vr_dia->cellAttributes() ?>>
<span id="">
<span<?= $Page->vr_dia->viewAttributes() ?>>
<?= $Page->vr_dia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
        <td<?= $Page->va_mes->cellAttributes() ?>>
<span id="">
<span<?= $Page->va_mes->viewAttributes() ?>>
<?= $Page->va_mes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
        <td<?= $Page->benef_social->cellAttributes() ?>>
<span id="">
<span<?= $Page->benef_social->viewAttributes() ?>>
<?= $Page->benef_social->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
        <td<?= $Page->plr->cellAttributes() ?>>
<span id="">
<span<?= $Page->plr->viewAttributes() ?>>
<?= $Page->plr->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <td<?= $Page->assis_medica->cellAttributes() ?>>
<span id="">
<span<?= $Page->assis_medica->viewAttributes() ?>>
<?= $Page->assis_medica->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <td<?= $Page->assis_odonto->cellAttributes() ?>>
<span id="">
<span<?= $Page->assis_odonto->viewAttributes() ?>>
<?= $Page->assis_odonto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dissidio_anual_iddissidio_anual->Visible) { // dissidio_anual_iddissidio_anual ?>
        <td<?= $Page->dissidio_anual_iddissidio_anual->cellAttributes() ?>>
<span id="">
<span<?= $Page->dissidio_anual_iddissidio_anual->viewAttributes() ?>>
<?= $Page->dissidio_anual_iddissidio_anual->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
