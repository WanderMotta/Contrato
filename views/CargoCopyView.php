<?php

namespace PHPMaker2024\contratos;

// Page object
$CargoCopyView = &$Page;
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
<form name="fcargo_copyview" id="fcargo_copyview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cargo_copy: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcargo_copyview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcargo_copyview")
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
<input type="hidden" name="t" value="cargo_copy">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idcargo->Visible) { // idcargo ?>
    <tr id="r_idcargo"<?= $Page->idcargo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_idcargo"><?= $Page->idcargo->caption() ?></span></td>
        <td data-name="idcargo"<?= $Page->idcargo->cellAttributes() ?>>
<span id="el_cargo_copy_idcargo">
<span<?= $Page->idcargo->viewAttributes() ?>>
<?= $Page->idcargo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
    <tr id="r_cargo"<?= $Page->cargo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_cargo"><?= $Page->cargo->caption() ?></span></td>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span id="el_cargo_copy_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->abreviado->Visible) { // abreviado ?>
    <tr id="r_abreviado"<?= $Page->abreviado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_abreviado"><?= $Page->abreviado->caption() ?></span></td>
        <td data-name="abreviado"<?= $Page->abreviado->cellAttributes() ?>>
<span id="el_cargo_copy_abreviado">
<span<?= $Page->abreviado->viewAttributes() ?>>
<?= $Page->abreviado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->salario->Visible) { // salario ?>
    <tr id="r_salario"<?= $Page->salario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_salario"><?= $Page->salario->caption() ?></span></td>
        <td data-name="salario"<?= $Page->salario->cellAttributes() ?>>
<span id="el_cargo_copy_salario">
<span<?= $Page->salario->viewAttributes() ?>>
<?= $Page->salario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nr_horas_mes->Visible) { // nr_horas_mes ?>
    <tr id="r_nr_horas_mes"<?= $Page->nr_horas_mes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_nr_horas_mes"><?= $Page->nr_horas_mes->caption() ?></span></td>
        <td data-name="nr_horas_mes"<?= $Page->nr_horas_mes->cellAttributes() ?>>
<span id="el_cargo_copy_nr_horas_mes">
<span<?= $Page->nr_horas_mes->viewAttributes() ?>>
<?= $Page->nr_horas_mes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jornada->Visible) { // jornada ?>
    <tr id="r_jornada"<?= $Page->jornada->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_jornada"><?= $Page->jornada->caption() ?></span></td>
        <td data-name="jornada"<?= $Page->jornada->cellAttributes() ?>>
<span id="el_cargo_copy_jornada">
<span<?= $Page->jornada->viewAttributes() ?>>
<?= $Page->jornada->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
    <tr id="r_vt_dia"<?= $Page->vt_dia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_vt_dia"><?= $Page->vt_dia->caption() ?></span></td>
        <td data-name="vt_dia"<?= $Page->vt_dia->cellAttributes() ?>>
<span id="el_cargo_copy_vt_dia">
<span<?= $Page->vt_dia->viewAttributes() ?>>
<?= $Page->vt_dia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
    <tr id="r_vr_dia"<?= $Page->vr_dia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_vr_dia"><?= $Page->vr_dia->caption() ?></span></td>
        <td data-name="vr_dia"<?= $Page->vr_dia->cellAttributes() ?>>
<span id="el_cargo_copy_vr_dia">
<span<?= $Page->vr_dia->viewAttributes() ?>>
<?= $Page->vr_dia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
    <tr id="r_va_mes"<?= $Page->va_mes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_va_mes"><?= $Page->va_mes->caption() ?></span></td>
        <td data-name="va_mes"<?= $Page->va_mes->cellAttributes() ?>>
<span id="el_cargo_copy_va_mes">
<span<?= $Page->va_mes->viewAttributes() ?>>
<?= $Page->va_mes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
    <tr id="r_benef_social"<?= $Page->benef_social->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_benef_social"><?= $Page->benef_social->caption() ?></span></td>
        <td data-name="benef_social"<?= $Page->benef_social->cellAttributes() ?>>
<span id="el_cargo_copy_benef_social">
<span<?= $Page->benef_social->viewAttributes() ?>>
<?= $Page->benef_social->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
    <tr id="r_plr"<?= $Page->plr->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_plr"><?= $Page->plr->caption() ?></span></td>
        <td data-name="plr"<?= $Page->plr->cellAttributes() ?>>
<span id="el_cargo_copy_plr">
<span<?= $Page->plr->viewAttributes() ?>>
<?= $Page->plr->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
    <tr id="r_assis_medica"<?= $Page->assis_medica->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_assis_medica"><?= $Page->assis_medica->caption() ?></span></td>
        <td data-name="assis_medica"<?= $Page->assis_medica->cellAttributes() ?>>
<span id="el_cargo_copy_assis_medica">
<span<?= $Page->assis_medica->viewAttributes() ?>>
<?= $Page->assis_medica->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
    <tr id="r_assis_odonto"<?= $Page->assis_odonto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_assis_odonto"><?= $Page->assis_odonto->caption() ?></span></td>
        <td data-name="assis_odonto"<?= $Page->assis_odonto->cellAttributes() ?>>
<span id="el_cargo_copy_assis_odonto">
<span<?= $Page->assis_odonto->viewAttributes() ?>>
<?= $Page->assis_odonto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
    <tr id="r_modulo_idmodulo"<?= $Page->modulo_idmodulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_modulo_idmodulo"><?= $Page->modulo_idmodulo->caption() ?></span></td>
        <td data-name="modulo_idmodulo"<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<span id="el_cargo_copy_modulo_idmodulo">
<span<?= $Page->modulo_idmodulo->viewAttributes() ?>>
<?= $Page->modulo_idmodulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
    <tr id="r_periodo_idperiodo"<?= $Page->periodo_idperiodo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_periodo_idperiodo"><?= $Page->periodo_idperiodo->caption() ?></span></td>
        <td data-name="periodo_idperiodo"<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="el_cargo_copy_periodo_idperiodo">
<span<?= $Page->periodo_idperiodo->viewAttributes() ?>>
<?= $Page->periodo_idperiodo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
    <tr id="r_escala_idescala"<?= $Page->escala_idescala->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_escala_idescala"><?= $Page->escala_idescala->caption() ?></span></td>
        <td data-name="escala_idescala"<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="el_cargo_copy_escala_idescala">
<span<?= $Page->escala_idescala->viewAttributes() ?>>
<?= $Page->escala_idescala->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nr_horas_ad_noite->Visible) { // nr_horas_ad_noite ?>
    <tr id="r_nr_horas_ad_noite"<?= $Page->nr_horas_ad_noite->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_nr_horas_ad_noite"><?= $Page->nr_horas_ad_noite->caption() ?></span></td>
        <td data-name="nr_horas_ad_noite"<?= $Page->nr_horas_ad_noite->cellAttributes() ?>>
<span id="el_cargo_copy_nr_horas_ad_noite">
<span<?= $Page->nr_horas_ad_noite->viewAttributes() ?>>
<?= $Page->nr_horas_ad_noite->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->intrajornada->Visible) { // intrajornada ?>
    <tr id="r_intrajornada"<?= $Page->intrajornada->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_intrajornada"><?= $Page->intrajornada->caption() ?></span></td>
        <td data-name="intrajornada"<?= $Page->intrajornada->cellAttributes() ?>>
<span id="el_cargo_copy_intrajornada">
<span<?= $Page->intrajornada->viewAttributes() ?>>
<?= $Page->intrajornada->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
    <tr id="r_tipo_uniforme_idtipo_uniforme"<?= $Page->tipo_uniforme_idtipo_uniforme->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_tipo_uniforme_idtipo_uniforme"><?= $Page->tipo_uniforme_idtipo_uniforme->caption() ?></span></td>
        <td data-name="tipo_uniforme_idtipo_uniforme"<?= $Page->tipo_uniforme_idtipo_uniforme->cellAttributes() ?>>
<span id="el_cargo_copy_tipo_uniforme_idtipo_uniforme">
<span<?= $Page->tipo_uniforme_idtipo_uniforme->viewAttributes() ?>>
<?= $Page->tipo_uniforme_idtipo_uniforme->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->salario_antes->Visible) { // salario_antes ?>
    <tr id="r_salario_antes"<?= $Page->salario_antes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_salario_antes"><?= $Page->salario_antes->caption() ?></span></td>
        <td data-name="salario_antes"<?= $Page->salario_antes->cellAttributes() ?>>
<span id="el_cargo_copy_salario_antes">
<span<?= $Page->salario_antes->viewAttributes() ?>>
<?= $Page->salario_antes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vt_dia_antes->Visible) { // vt_dia_antes ?>
    <tr id="r_vt_dia_antes"<?= $Page->vt_dia_antes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_vt_dia_antes"><?= $Page->vt_dia_antes->caption() ?></span></td>
        <td data-name="vt_dia_antes"<?= $Page->vt_dia_antes->cellAttributes() ?>>
<span id="el_cargo_copy_vt_dia_antes">
<span<?= $Page->vt_dia_antes->viewAttributes() ?>>
<?= $Page->vt_dia_antes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vr_dia_antes->Visible) { // vr_dia_antes ?>
    <tr id="r_vr_dia_antes"<?= $Page->vr_dia_antes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_vr_dia_antes"><?= $Page->vr_dia_antes->caption() ?></span></td>
        <td data-name="vr_dia_antes"<?= $Page->vr_dia_antes->cellAttributes() ?>>
<span id="el_cargo_copy_vr_dia_antes">
<span<?= $Page->vr_dia_antes->viewAttributes() ?>>
<?= $Page->vr_dia_antes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->va_mes_antes->Visible) { // va_mes_antes ?>
    <tr id="r_va_mes_antes"<?= $Page->va_mes_antes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_va_mes_antes"><?= $Page->va_mes_antes->caption() ?></span></td>
        <td data-name="va_mes_antes"<?= $Page->va_mes_antes->cellAttributes() ?>>
<span id="el_cargo_copy_va_mes_antes">
<span<?= $Page->va_mes_antes->viewAttributes() ?>>
<?= $Page->va_mes_antes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->benef_social_antes->Visible) { // benef_social_antes ?>
    <tr id="r_benef_social_antes"<?= $Page->benef_social_antes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_benef_social_antes"><?= $Page->benef_social_antes->caption() ?></span></td>
        <td data-name="benef_social_antes"<?= $Page->benef_social_antes->cellAttributes() ?>>
<span id="el_cargo_copy_benef_social_antes">
<span<?= $Page->benef_social_antes->viewAttributes() ?>>
<?= $Page->benef_social_antes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->plr_antes->Visible) { // plr_antes ?>
    <tr id="r_plr_antes"<?= $Page->plr_antes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_plr_antes"><?= $Page->plr_antes->caption() ?></span></td>
        <td data-name="plr_antes"<?= $Page->plr_antes->cellAttributes() ?>>
<span id="el_cargo_copy_plr_antes">
<span<?= $Page->plr_antes->viewAttributes() ?>>
<?= $Page->plr_antes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->assis_medica_antes->Visible) { // assis_medica_antes ?>
    <tr id="r_assis_medica_antes"<?= $Page->assis_medica_antes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_assis_medica_antes"><?= $Page->assis_medica_antes->caption() ?></span></td>
        <td data-name="assis_medica_antes"<?= $Page->assis_medica_antes->cellAttributes() ?>>
<span id="el_cargo_copy_assis_medica_antes">
<span<?= $Page->assis_medica_antes->viewAttributes() ?>>
<?= $Page->assis_medica_antes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->assis_odonto_antes->Visible) { // assis_odonto_antes ?>
    <tr id="r_assis_odonto_antes"<?= $Page->assis_odonto_antes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_assis_odonto_antes"><?= $Page->assis_odonto_antes->caption() ?></span></td>
        <td data-name="assis_odonto_antes"<?= $Page->assis_odonto_antes->cellAttributes() ?>>
<span id="el_cargo_copy_assis_odonto_antes">
<span<?= $Page->assis_odonto_antes->viewAttributes() ?>>
<?= $Page->assis_odonto_antes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->funcao_idfuncao->Visible) { // funcao_idfuncao ?>
    <tr id="r_funcao_idfuncao"<?= $Page->funcao_idfuncao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_funcao_idfuncao"><?= $Page->funcao_idfuncao->caption() ?></span></td>
        <td data-name="funcao_idfuncao"<?= $Page->funcao_idfuncao->cellAttributes() ?>>
<span id="el_cargo_copy_funcao_idfuncao">
<span<?= $Page->funcao_idfuncao->viewAttributes() ?>>
<?= $Page->funcao_idfuncao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->salario1->Visible) { // salario1 ?>
    <tr id="r_salario1"<?= $Page->salario1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cargo_copy_salario1"><?= $Page->salario1->caption() ?></span></td>
        <td data-name="salario1"<?= $Page->salario1->cellAttributes() ?>>
<span id="el_cargo_copy_salario1">
<span<?= $Page->salario1->viewAttributes() ?>>
<?= $Page->salario1->getViewValue() ?></span>
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
