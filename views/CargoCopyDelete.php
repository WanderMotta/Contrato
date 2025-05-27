<?php

namespace PHPMaker2024\contratos;

// Page object
$CargoCopyDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cargo_copy: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcargo_copydelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcargo_copydelete")
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
<form name="fcargo_copydelete" id="fcargo_copydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cargo_copy">
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
<?php if ($Page->idcargo->Visible) { // idcargo ?>
        <th class="<?= $Page->idcargo->headerCellClass() ?>"><span id="elh_cargo_copy_idcargo" class="cargo_copy_idcargo"><?= $Page->idcargo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
        <th class="<?= $Page->cargo->headerCellClass() ?>"><span id="elh_cargo_copy_cargo" class="cargo_copy_cargo"><?= $Page->cargo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->abreviado->Visible) { // abreviado ?>
        <th class="<?= $Page->abreviado->headerCellClass() ?>"><span id="elh_cargo_copy_abreviado" class="cargo_copy_abreviado"><?= $Page->abreviado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->salario->Visible) { // salario ?>
        <th class="<?= $Page->salario->headerCellClass() ?>"><span id="elh_cargo_copy_salario" class="cargo_copy_salario"><?= $Page->salario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nr_horas_mes->Visible) { // nr_horas_mes ?>
        <th class="<?= $Page->nr_horas_mes->headerCellClass() ?>"><span id="elh_cargo_copy_nr_horas_mes" class="cargo_copy_nr_horas_mes"><?= $Page->nr_horas_mes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jornada->Visible) { // jornada ?>
        <th class="<?= $Page->jornada->headerCellClass() ?>"><span id="elh_cargo_copy_jornada" class="cargo_copy_jornada"><?= $Page->jornada->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <th class="<?= $Page->vt_dia->headerCellClass() ?>"><span id="elh_cargo_copy_vt_dia" class="cargo_copy_vt_dia"><?= $Page->vt_dia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <th class="<?= $Page->vr_dia->headerCellClass() ?>"><span id="elh_cargo_copy_vr_dia" class="cargo_copy_vr_dia"><?= $Page->vr_dia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
        <th class="<?= $Page->va_mes->headerCellClass() ?>"><span id="elh_cargo_copy_va_mes" class="cargo_copy_va_mes"><?= $Page->va_mes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
        <th class="<?= $Page->benef_social->headerCellClass() ?>"><span id="elh_cargo_copy_benef_social" class="cargo_copy_benef_social"><?= $Page->benef_social->caption() ?></span></th>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
        <th class="<?= $Page->plr->headerCellClass() ?>"><span id="elh_cargo_copy_plr" class="cargo_copy_plr"><?= $Page->plr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <th class="<?= $Page->assis_medica->headerCellClass() ?>"><span id="elh_cargo_copy_assis_medica" class="cargo_copy_assis_medica"><?= $Page->assis_medica->caption() ?></span></th>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <th class="<?= $Page->assis_odonto->headerCellClass() ?>"><span id="elh_cargo_copy_assis_odonto" class="cargo_copy_assis_odonto"><?= $Page->assis_odonto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <th class="<?= $Page->modulo_idmodulo->headerCellClass() ?>"><span id="elh_cargo_copy_modulo_idmodulo" class="cargo_copy_modulo_idmodulo"><?= $Page->modulo_idmodulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <th class="<?= $Page->periodo_idperiodo->headerCellClass() ?>"><span id="elh_cargo_copy_periodo_idperiodo" class="cargo_copy_periodo_idperiodo"><?= $Page->periodo_idperiodo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <th class="<?= $Page->escala_idescala->headerCellClass() ?>"><span id="elh_cargo_copy_escala_idescala" class="cargo_copy_escala_idescala"><?= $Page->escala_idescala->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nr_horas_ad_noite->Visible) { // nr_horas_ad_noite ?>
        <th class="<?= $Page->nr_horas_ad_noite->headerCellClass() ?>"><span id="elh_cargo_copy_nr_horas_ad_noite" class="cargo_copy_nr_horas_ad_noite"><?= $Page->nr_horas_ad_noite->caption() ?></span></th>
<?php } ?>
<?php if ($Page->intrajornada->Visible) { // intrajornada ?>
        <th class="<?= $Page->intrajornada->headerCellClass() ?>"><span id="elh_cargo_copy_intrajornada" class="cargo_copy_intrajornada"><?= $Page->intrajornada->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <th class="<?= $Page->tipo_uniforme_idtipo_uniforme->headerCellClass() ?>"><span id="elh_cargo_copy_tipo_uniforme_idtipo_uniforme" class="cargo_copy_tipo_uniforme_idtipo_uniforme"><?= $Page->tipo_uniforme_idtipo_uniforme->caption() ?></span></th>
<?php } ?>
<?php if ($Page->salario_antes->Visible) { // salario_antes ?>
        <th class="<?= $Page->salario_antes->headerCellClass() ?>"><span id="elh_cargo_copy_salario_antes" class="cargo_copy_salario_antes"><?= $Page->salario_antes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vt_dia_antes->Visible) { // vt_dia_antes ?>
        <th class="<?= $Page->vt_dia_antes->headerCellClass() ?>"><span id="elh_cargo_copy_vt_dia_antes" class="cargo_copy_vt_dia_antes"><?= $Page->vt_dia_antes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vr_dia_antes->Visible) { // vr_dia_antes ?>
        <th class="<?= $Page->vr_dia_antes->headerCellClass() ?>"><span id="elh_cargo_copy_vr_dia_antes" class="cargo_copy_vr_dia_antes"><?= $Page->vr_dia_antes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->va_mes_antes->Visible) { // va_mes_antes ?>
        <th class="<?= $Page->va_mes_antes->headerCellClass() ?>"><span id="elh_cargo_copy_va_mes_antes" class="cargo_copy_va_mes_antes"><?= $Page->va_mes_antes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->benef_social_antes->Visible) { // benef_social_antes ?>
        <th class="<?= $Page->benef_social_antes->headerCellClass() ?>"><span id="elh_cargo_copy_benef_social_antes" class="cargo_copy_benef_social_antes"><?= $Page->benef_social_antes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->plr_antes->Visible) { // plr_antes ?>
        <th class="<?= $Page->plr_antes->headerCellClass() ?>"><span id="elh_cargo_copy_plr_antes" class="cargo_copy_plr_antes"><?= $Page->plr_antes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->assis_medica_antes->Visible) { // assis_medica_antes ?>
        <th class="<?= $Page->assis_medica_antes->headerCellClass() ?>"><span id="elh_cargo_copy_assis_medica_antes" class="cargo_copy_assis_medica_antes"><?= $Page->assis_medica_antes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->assis_odonto_antes->Visible) { // assis_odonto_antes ?>
        <th class="<?= $Page->assis_odonto_antes->headerCellClass() ?>"><span id="elh_cargo_copy_assis_odonto_antes" class="cargo_copy_assis_odonto_antes"><?= $Page->assis_odonto_antes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->funcao_idfuncao->Visible) { // funcao_idfuncao ?>
        <th class="<?= $Page->funcao_idfuncao->headerCellClass() ?>"><span id="elh_cargo_copy_funcao_idfuncao" class="cargo_copy_funcao_idfuncao"><?= $Page->funcao_idfuncao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->salario1->Visible) { // salario1 ?>
        <th class="<?= $Page->salario1->headerCellClass() ?>"><span id="elh_cargo_copy_salario1" class="cargo_copy_salario1"><?= $Page->salario1->caption() ?></span></th>
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
<?php if ($Page->idcargo->Visible) { // idcargo ?>
        <td<?= $Page->idcargo->cellAttributes() ?>>
<span id="">
<span<?= $Page->idcargo->viewAttributes() ?>>
<?= $Page->idcargo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
        <td<?= $Page->cargo->cellAttributes() ?>>
<span id="">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->abreviado->Visible) { // abreviado ?>
        <td<?= $Page->abreviado->cellAttributes() ?>>
<span id="">
<span<?= $Page->abreviado->viewAttributes() ?>>
<?= $Page->abreviado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->salario->Visible) { // salario ?>
        <td<?= $Page->salario->cellAttributes() ?>>
<span id="">
<span<?= $Page->salario->viewAttributes() ?>>
<?= $Page->salario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nr_horas_mes->Visible) { // nr_horas_mes ?>
        <td<?= $Page->nr_horas_mes->cellAttributes() ?>>
<span id="">
<span<?= $Page->nr_horas_mes->viewAttributes() ?>>
<?= $Page->nr_horas_mes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jornada->Visible) { // jornada ?>
        <td<?= $Page->jornada->cellAttributes() ?>>
<span id="">
<span<?= $Page->jornada->viewAttributes() ?>>
<?= $Page->jornada->getViewValue() ?></span>
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
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <td<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<span id="">
<span<?= $Page->modulo_idmodulo->viewAttributes() ?>>
<?= $Page->modulo_idmodulo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <td<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="">
<span<?= $Page->periodo_idperiodo->viewAttributes() ?>>
<?= $Page->periodo_idperiodo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <td<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="">
<span<?= $Page->escala_idescala->viewAttributes() ?>>
<?= $Page->escala_idescala->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nr_horas_ad_noite->Visible) { // nr_horas_ad_noite ?>
        <td<?= $Page->nr_horas_ad_noite->cellAttributes() ?>>
<span id="">
<span<?= $Page->nr_horas_ad_noite->viewAttributes() ?>>
<?= $Page->nr_horas_ad_noite->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->intrajornada->Visible) { // intrajornada ?>
        <td<?= $Page->intrajornada->cellAttributes() ?>>
<span id="">
<span<?= $Page->intrajornada->viewAttributes() ?>>
<?= $Page->intrajornada->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <td<?= $Page->tipo_uniforme_idtipo_uniforme->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_uniforme_idtipo_uniforme->viewAttributes() ?>>
<?= $Page->tipo_uniforme_idtipo_uniforme->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->salario_antes->Visible) { // salario_antes ?>
        <td<?= $Page->salario_antes->cellAttributes() ?>>
<span id="">
<span<?= $Page->salario_antes->viewAttributes() ?>>
<?= $Page->salario_antes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vt_dia_antes->Visible) { // vt_dia_antes ?>
        <td<?= $Page->vt_dia_antes->cellAttributes() ?>>
<span id="">
<span<?= $Page->vt_dia_antes->viewAttributes() ?>>
<?= $Page->vt_dia_antes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vr_dia_antes->Visible) { // vr_dia_antes ?>
        <td<?= $Page->vr_dia_antes->cellAttributes() ?>>
<span id="">
<span<?= $Page->vr_dia_antes->viewAttributes() ?>>
<?= $Page->vr_dia_antes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->va_mes_antes->Visible) { // va_mes_antes ?>
        <td<?= $Page->va_mes_antes->cellAttributes() ?>>
<span id="">
<span<?= $Page->va_mes_antes->viewAttributes() ?>>
<?= $Page->va_mes_antes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->benef_social_antes->Visible) { // benef_social_antes ?>
        <td<?= $Page->benef_social_antes->cellAttributes() ?>>
<span id="">
<span<?= $Page->benef_social_antes->viewAttributes() ?>>
<?= $Page->benef_social_antes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->plr_antes->Visible) { // plr_antes ?>
        <td<?= $Page->plr_antes->cellAttributes() ?>>
<span id="">
<span<?= $Page->plr_antes->viewAttributes() ?>>
<?= $Page->plr_antes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->assis_medica_antes->Visible) { // assis_medica_antes ?>
        <td<?= $Page->assis_medica_antes->cellAttributes() ?>>
<span id="">
<span<?= $Page->assis_medica_antes->viewAttributes() ?>>
<?= $Page->assis_medica_antes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->assis_odonto_antes->Visible) { // assis_odonto_antes ?>
        <td<?= $Page->assis_odonto_antes->cellAttributes() ?>>
<span id="">
<span<?= $Page->assis_odonto_antes->viewAttributes() ?>>
<?= $Page->assis_odonto_antes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->funcao_idfuncao->Visible) { // funcao_idfuncao ?>
        <td<?= $Page->funcao_idfuncao->cellAttributes() ?>>
<span id="">
<span<?= $Page->funcao_idfuncao->viewAttributes() ?>>
<?= $Page->funcao_idfuncao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->salario1->Visible) { // salario1 ?>
        <td<?= $Page->salario1->cellAttributes() ?>>
<span id="">
<span<?= $Page->salario1->viewAttributes() ?>>
<?= $Page->salario1->getViewValue() ?></span>
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
