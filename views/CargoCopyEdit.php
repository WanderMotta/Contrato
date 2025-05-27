<?php

namespace PHPMaker2024\contratos;

// Page object
$CargoCopyEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fcargo_copyedit" id="fcargo_copyedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cargo_copy: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fcargo_copyedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcargo_copyedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idcargo", [fields.idcargo.visible && fields.idcargo.required ? ew.Validators.required(fields.idcargo.caption) : null], fields.idcargo.isInvalid],
            ["cargo", [fields.cargo.visible && fields.cargo.required ? ew.Validators.required(fields.cargo.caption) : null], fields.cargo.isInvalid],
            ["abreviado", [fields.abreviado.visible && fields.abreviado.required ? ew.Validators.required(fields.abreviado.caption) : null], fields.abreviado.isInvalid],
            ["salario", [fields.salario.visible && fields.salario.required ? ew.Validators.required(fields.salario.caption) : null, ew.Validators.float], fields.salario.isInvalid],
            ["nr_horas_mes", [fields.nr_horas_mes.visible && fields.nr_horas_mes.required ? ew.Validators.required(fields.nr_horas_mes.caption) : null, ew.Validators.integer], fields.nr_horas_mes.isInvalid],
            ["jornada", [fields.jornada.visible && fields.jornada.required ? ew.Validators.required(fields.jornada.caption) : null, ew.Validators.float], fields.jornada.isInvalid],
            ["vt_dia", [fields.vt_dia.visible && fields.vt_dia.required ? ew.Validators.required(fields.vt_dia.caption) : null, ew.Validators.float], fields.vt_dia.isInvalid],
            ["vr_dia", [fields.vr_dia.visible && fields.vr_dia.required ? ew.Validators.required(fields.vr_dia.caption) : null, ew.Validators.float], fields.vr_dia.isInvalid],
            ["va_mes", [fields.va_mes.visible && fields.va_mes.required ? ew.Validators.required(fields.va_mes.caption) : null, ew.Validators.float], fields.va_mes.isInvalid],
            ["benef_social", [fields.benef_social.visible && fields.benef_social.required ? ew.Validators.required(fields.benef_social.caption) : null, ew.Validators.float], fields.benef_social.isInvalid],
            ["plr", [fields.plr.visible && fields.plr.required ? ew.Validators.required(fields.plr.caption) : null, ew.Validators.float], fields.plr.isInvalid],
            ["assis_medica", [fields.assis_medica.visible && fields.assis_medica.required ? ew.Validators.required(fields.assis_medica.caption) : null, ew.Validators.float], fields.assis_medica.isInvalid],
            ["assis_odonto", [fields.assis_odonto.visible && fields.assis_odonto.required ? ew.Validators.required(fields.assis_odonto.caption) : null, ew.Validators.float], fields.assis_odonto.isInvalid],
            ["modulo_idmodulo", [fields.modulo_idmodulo.visible && fields.modulo_idmodulo.required ? ew.Validators.required(fields.modulo_idmodulo.caption) : null, ew.Validators.integer], fields.modulo_idmodulo.isInvalid],
            ["periodo_idperiodo", [fields.periodo_idperiodo.visible && fields.periodo_idperiodo.required ? ew.Validators.required(fields.periodo_idperiodo.caption) : null, ew.Validators.integer], fields.periodo_idperiodo.isInvalid],
            ["escala_idescala", [fields.escala_idescala.visible && fields.escala_idescala.required ? ew.Validators.required(fields.escala_idescala.caption) : null, ew.Validators.integer], fields.escala_idescala.isInvalid],
            ["nr_horas_ad_noite", [fields.nr_horas_ad_noite.visible && fields.nr_horas_ad_noite.required ? ew.Validators.required(fields.nr_horas_ad_noite.caption) : null, ew.Validators.float], fields.nr_horas_ad_noite.isInvalid],
            ["intrajornada", [fields.intrajornada.visible && fields.intrajornada.required ? ew.Validators.required(fields.intrajornada.caption) : null], fields.intrajornada.isInvalid],
            ["tipo_uniforme_idtipo_uniforme", [fields.tipo_uniforme_idtipo_uniforme.visible && fields.tipo_uniforme_idtipo_uniforme.required ? ew.Validators.required(fields.tipo_uniforme_idtipo_uniforme.caption) : null, ew.Validators.integer], fields.tipo_uniforme_idtipo_uniforme.isInvalid],
            ["salario_antes", [fields.salario_antes.visible && fields.salario_antes.required ? ew.Validators.required(fields.salario_antes.caption) : null, ew.Validators.float], fields.salario_antes.isInvalid],
            ["vt_dia_antes", [fields.vt_dia_antes.visible && fields.vt_dia_antes.required ? ew.Validators.required(fields.vt_dia_antes.caption) : null, ew.Validators.float], fields.vt_dia_antes.isInvalid],
            ["vr_dia_antes", [fields.vr_dia_antes.visible && fields.vr_dia_antes.required ? ew.Validators.required(fields.vr_dia_antes.caption) : null, ew.Validators.float], fields.vr_dia_antes.isInvalid],
            ["va_mes_antes", [fields.va_mes_antes.visible && fields.va_mes_antes.required ? ew.Validators.required(fields.va_mes_antes.caption) : null, ew.Validators.float], fields.va_mes_antes.isInvalid],
            ["benef_social_antes", [fields.benef_social_antes.visible && fields.benef_social_antes.required ? ew.Validators.required(fields.benef_social_antes.caption) : null, ew.Validators.float], fields.benef_social_antes.isInvalid],
            ["plr_antes", [fields.plr_antes.visible && fields.plr_antes.required ? ew.Validators.required(fields.plr_antes.caption) : null, ew.Validators.float], fields.plr_antes.isInvalid],
            ["assis_medica_antes", [fields.assis_medica_antes.visible && fields.assis_medica_antes.required ? ew.Validators.required(fields.assis_medica_antes.caption) : null, ew.Validators.float], fields.assis_medica_antes.isInvalid],
            ["assis_odonto_antes", [fields.assis_odonto_antes.visible && fields.assis_odonto_antes.required ? ew.Validators.required(fields.assis_odonto_antes.caption) : null, ew.Validators.float], fields.assis_odonto_antes.isInvalid],
            ["funcao_idfuncao", [fields.funcao_idfuncao.visible && fields.funcao_idfuncao.required ? ew.Validators.required(fields.funcao_idfuncao.caption) : null, ew.Validators.integer], fields.funcao_idfuncao.isInvalid],
            ["salario1", [fields.salario1.visible && fields.salario1.required ? ew.Validators.required(fields.salario1.caption) : null, ew.Validators.float], fields.salario1.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code in JAVASCRIPT here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "intrajornada": <?= $Page->intrajornada->toClientList($Page) ?>,
        })
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cargo_copy">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idcargo->Visible) { // idcargo ?>
    <div id="r_idcargo"<?= $Page->idcargo->rowAttributes() ?>>
        <label id="elh_cargo_copy_idcargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcargo->caption() ?><?= $Page->idcargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idcargo->cellAttributes() ?>>
<span id="el_cargo_copy_idcargo">
<span<?= $Page->idcargo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idcargo->getDisplayValue($Page->idcargo->EditValue))) ?>"></span>
<input type="hidden" data-table="cargo_copy" data-field="x_idcargo" data-hidden="1" name="x_idcargo" id="x_idcargo" value="<?= HtmlEncode($Page->idcargo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
    <div id="r_cargo"<?= $Page->cargo->rowAttributes() ?>>
        <label id="elh_cargo_copy_cargo" for="x_cargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cargo->caption() ?><?= $Page->cargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cargo->cellAttributes() ?>>
<span id="el_cargo_copy_cargo">
<input type="<?= $Page->cargo->getInputTextType() ?>" name="x_cargo" id="x_cargo" data-table="cargo_copy" data-field="x_cargo" value="<?= $Page->cargo->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->cargo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cargo->formatPattern()) ?>"<?= $Page->cargo->editAttributes() ?> aria-describedby="x_cargo_help">
<?= $Page->cargo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cargo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->abreviado->Visible) { // abreviado ?>
    <div id="r_abreviado"<?= $Page->abreviado->rowAttributes() ?>>
        <label id="elh_cargo_copy_abreviado" for="x_abreviado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->abreviado->caption() ?><?= $Page->abreviado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->abreviado->cellAttributes() ?>>
<span id="el_cargo_copy_abreviado">
<input type="<?= $Page->abreviado->getInputTextType() ?>" name="x_abreviado" id="x_abreviado" data-table="cargo_copy" data-field="x_abreviado" value="<?= $Page->abreviado->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->abreviado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->abreviado->formatPattern()) ?>"<?= $Page->abreviado->editAttributes() ?> aria-describedby="x_abreviado_help">
<?= $Page->abreviado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->abreviado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->salario->Visible) { // salario ?>
    <div id="r_salario"<?= $Page->salario->rowAttributes() ?>>
        <label id="elh_cargo_copy_salario" for="x_salario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->salario->caption() ?><?= $Page->salario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->salario->cellAttributes() ?>>
<span id="el_cargo_copy_salario">
<input type="<?= $Page->salario->getInputTextType() ?>" name="x_salario" id="x_salario" data-table="cargo_copy" data-field="x_salario" value="<?= $Page->salario->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->salario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->salario->formatPattern()) ?>"<?= $Page->salario->editAttributes() ?> aria-describedby="x_salario_help">
<?= $Page->salario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->salario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nr_horas_mes->Visible) { // nr_horas_mes ?>
    <div id="r_nr_horas_mes"<?= $Page->nr_horas_mes->rowAttributes() ?>>
        <label id="elh_cargo_copy_nr_horas_mes" for="x_nr_horas_mes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nr_horas_mes->caption() ?><?= $Page->nr_horas_mes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nr_horas_mes->cellAttributes() ?>>
<span id="el_cargo_copy_nr_horas_mes">
<input type="<?= $Page->nr_horas_mes->getInputTextType() ?>" name="x_nr_horas_mes" id="x_nr_horas_mes" data-table="cargo_copy" data-field="x_nr_horas_mes" value="<?= $Page->nr_horas_mes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nr_horas_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nr_horas_mes->formatPattern()) ?>"<?= $Page->nr_horas_mes->editAttributes() ?> aria-describedby="x_nr_horas_mes_help">
<?= $Page->nr_horas_mes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nr_horas_mes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jornada->Visible) { // jornada ?>
    <div id="r_jornada"<?= $Page->jornada->rowAttributes() ?>>
        <label id="elh_cargo_copy_jornada" for="x_jornada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jornada->caption() ?><?= $Page->jornada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->jornada->cellAttributes() ?>>
<span id="el_cargo_copy_jornada">
<input type="<?= $Page->jornada->getInputTextType() ?>" name="x_jornada" id="x_jornada" data-table="cargo_copy" data-field="x_jornada" value="<?= $Page->jornada->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->jornada->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->jornada->formatPattern()) ?>"<?= $Page->jornada->editAttributes() ?> aria-describedby="x_jornada_help">
<?= $Page->jornada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jornada->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
    <div id="r_vt_dia"<?= $Page->vt_dia->rowAttributes() ?>>
        <label id="elh_cargo_copy_vt_dia" for="x_vt_dia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vt_dia->caption() ?><?= $Page->vt_dia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vt_dia->cellAttributes() ?>>
<span id="el_cargo_copy_vt_dia">
<input type="<?= $Page->vt_dia->getInputTextType() ?>" name="x_vt_dia" id="x_vt_dia" data-table="cargo_copy" data-field="x_vt_dia" value="<?= $Page->vt_dia->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->vt_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vt_dia->formatPattern()) ?>"<?= $Page->vt_dia->editAttributes() ?> aria-describedby="x_vt_dia_help">
<?= $Page->vt_dia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vt_dia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
    <div id="r_vr_dia"<?= $Page->vr_dia->rowAttributes() ?>>
        <label id="elh_cargo_copy_vr_dia" for="x_vr_dia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vr_dia->caption() ?><?= $Page->vr_dia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vr_dia->cellAttributes() ?>>
<span id="el_cargo_copy_vr_dia">
<input type="<?= $Page->vr_dia->getInputTextType() ?>" name="x_vr_dia" id="x_vr_dia" data-table="cargo_copy" data-field="x_vr_dia" value="<?= $Page->vr_dia->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->vr_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_dia->formatPattern()) ?>"<?= $Page->vr_dia->editAttributes() ?> aria-describedby="x_vr_dia_help">
<?= $Page->vr_dia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vr_dia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
    <div id="r_va_mes"<?= $Page->va_mes->rowAttributes() ?>>
        <label id="elh_cargo_copy_va_mes" for="x_va_mes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->va_mes->caption() ?><?= $Page->va_mes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->va_mes->cellAttributes() ?>>
<span id="el_cargo_copy_va_mes">
<input type="<?= $Page->va_mes->getInputTextType() ?>" name="x_va_mes" id="x_va_mes" data-table="cargo_copy" data-field="x_va_mes" value="<?= $Page->va_mes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->va_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->va_mes->formatPattern()) ?>"<?= $Page->va_mes->editAttributes() ?> aria-describedby="x_va_mes_help">
<?= $Page->va_mes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->va_mes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
    <div id="r_benef_social"<?= $Page->benef_social->rowAttributes() ?>>
        <label id="elh_cargo_copy_benef_social" for="x_benef_social" class="<?= $Page->LeftColumnClass ?>"><?= $Page->benef_social->caption() ?><?= $Page->benef_social->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->benef_social->cellAttributes() ?>>
<span id="el_cargo_copy_benef_social">
<input type="<?= $Page->benef_social->getInputTextType() ?>" name="x_benef_social" id="x_benef_social" data-table="cargo_copy" data-field="x_benef_social" value="<?= $Page->benef_social->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->benef_social->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->benef_social->formatPattern()) ?>"<?= $Page->benef_social->editAttributes() ?> aria-describedby="x_benef_social_help">
<?= $Page->benef_social->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->benef_social->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
    <div id="r_plr"<?= $Page->plr->rowAttributes() ?>>
        <label id="elh_cargo_copy_plr" for="x_plr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->plr->caption() ?><?= $Page->plr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->plr->cellAttributes() ?>>
<span id="el_cargo_copy_plr">
<input type="<?= $Page->plr->getInputTextType() ?>" name="x_plr" id="x_plr" data-table="cargo_copy" data-field="x_plr" value="<?= $Page->plr->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->plr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->plr->formatPattern()) ?>"<?= $Page->plr->editAttributes() ?> aria-describedby="x_plr_help">
<?= $Page->plr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->plr->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
    <div id="r_assis_medica"<?= $Page->assis_medica->rowAttributes() ?>>
        <label id="elh_cargo_copy_assis_medica" for="x_assis_medica" class="<?= $Page->LeftColumnClass ?>"><?= $Page->assis_medica->caption() ?><?= $Page->assis_medica->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->assis_medica->cellAttributes() ?>>
<span id="el_cargo_copy_assis_medica">
<input type="<?= $Page->assis_medica->getInputTextType() ?>" name="x_assis_medica" id="x_assis_medica" data-table="cargo_copy" data-field="x_assis_medica" value="<?= $Page->assis_medica->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->assis_medica->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_medica->formatPattern()) ?>"<?= $Page->assis_medica->editAttributes() ?> aria-describedby="x_assis_medica_help">
<?= $Page->assis_medica->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->assis_medica->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
    <div id="r_assis_odonto"<?= $Page->assis_odonto->rowAttributes() ?>>
        <label id="elh_cargo_copy_assis_odonto" for="x_assis_odonto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->assis_odonto->caption() ?><?= $Page->assis_odonto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->assis_odonto->cellAttributes() ?>>
<span id="el_cargo_copy_assis_odonto">
<input type="<?= $Page->assis_odonto->getInputTextType() ?>" name="x_assis_odonto" id="x_assis_odonto" data-table="cargo_copy" data-field="x_assis_odonto" value="<?= $Page->assis_odonto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->assis_odonto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_odonto->formatPattern()) ?>"<?= $Page->assis_odonto->editAttributes() ?> aria-describedby="x_assis_odonto_help">
<?= $Page->assis_odonto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->assis_odonto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
    <div id="r_modulo_idmodulo"<?= $Page->modulo_idmodulo->rowAttributes() ?>>
        <label id="elh_cargo_copy_modulo_idmodulo" for="x_modulo_idmodulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo_idmodulo->caption() ?><?= $Page->modulo_idmodulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<span id="el_cargo_copy_modulo_idmodulo">
<input type="<?= $Page->modulo_idmodulo->getInputTextType() ?>" name="x_modulo_idmodulo" id="x_modulo_idmodulo" data-table="cargo_copy" data-field="x_modulo_idmodulo" value="<?= $Page->modulo_idmodulo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->modulo_idmodulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->modulo_idmodulo->formatPattern()) ?>"<?= $Page->modulo_idmodulo->editAttributes() ?> aria-describedby="x_modulo_idmodulo_help">
<?= $Page->modulo_idmodulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->modulo_idmodulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
    <div id="r_periodo_idperiodo"<?= $Page->periodo_idperiodo->rowAttributes() ?>>
        <label id="elh_cargo_copy_periodo_idperiodo" for="x_periodo_idperiodo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periodo_idperiodo->caption() ?><?= $Page->periodo_idperiodo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="el_cargo_copy_periodo_idperiodo">
<input type="<?= $Page->periodo_idperiodo->getInputTextType() ?>" name="x_periodo_idperiodo" id="x_periodo_idperiodo" data-table="cargo_copy" data-field="x_periodo_idperiodo" value="<?= $Page->periodo_idperiodo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->periodo_idperiodo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->periodo_idperiodo->formatPattern()) ?>"<?= $Page->periodo_idperiodo->editAttributes() ?> aria-describedby="x_periodo_idperiodo_help">
<?= $Page->periodo_idperiodo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->periodo_idperiodo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
    <div id="r_escala_idescala"<?= $Page->escala_idescala->rowAttributes() ?>>
        <label id="elh_cargo_copy_escala_idescala" for="x_escala_idescala" class="<?= $Page->LeftColumnClass ?>"><?= $Page->escala_idescala->caption() ?><?= $Page->escala_idescala->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="el_cargo_copy_escala_idescala">
<input type="<?= $Page->escala_idescala->getInputTextType() ?>" name="x_escala_idescala" id="x_escala_idescala" data-table="cargo_copy" data-field="x_escala_idescala" value="<?= $Page->escala_idescala->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->escala_idescala->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->escala_idescala->formatPattern()) ?>"<?= $Page->escala_idescala->editAttributes() ?> aria-describedby="x_escala_idescala_help">
<?= $Page->escala_idescala->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->escala_idescala->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nr_horas_ad_noite->Visible) { // nr_horas_ad_noite ?>
    <div id="r_nr_horas_ad_noite"<?= $Page->nr_horas_ad_noite->rowAttributes() ?>>
        <label id="elh_cargo_copy_nr_horas_ad_noite" for="x_nr_horas_ad_noite" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nr_horas_ad_noite->caption() ?><?= $Page->nr_horas_ad_noite->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nr_horas_ad_noite->cellAttributes() ?>>
<span id="el_cargo_copy_nr_horas_ad_noite">
<input type="<?= $Page->nr_horas_ad_noite->getInputTextType() ?>" name="x_nr_horas_ad_noite" id="x_nr_horas_ad_noite" data-table="cargo_copy" data-field="x_nr_horas_ad_noite" value="<?= $Page->nr_horas_ad_noite->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nr_horas_ad_noite->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nr_horas_ad_noite->formatPattern()) ?>"<?= $Page->nr_horas_ad_noite->editAttributes() ?> aria-describedby="x_nr_horas_ad_noite_help">
<?= $Page->nr_horas_ad_noite->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nr_horas_ad_noite->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->intrajornada->Visible) { // intrajornada ?>
    <div id="r_intrajornada"<?= $Page->intrajornada->rowAttributes() ?>>
        <label id="elh_cargo_copy_intrajornada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->intrajornada->caption() ?><?= $Page->intrajornada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->intrajornada->cellAttributes() ?>>
<span id="el_cargo_copy_intrajornada">
<template id="tp_x_intrajornada">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cargo_copy" data-field="x_intrajornada" name="x_intrajornada" id="x_intrajornada"<?= $Page->intrajornada->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_intrajornada" class="ew-item-list"></div>
<selection-list hidden
    id="x_intrajornada"
    name="x_intrajornada"
    value="<?= HtmlEncode($Page->intrajornada->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_intrajornada"
    data-target="dsl_x_intrajornada"
    data-repeatcolumn="5"
    class="form-control<?= $Page->intrajornada->isInvalidClass() ?>"
    data-table="cargo_copy"
    data-field="x_intrajornada"
    data-value-separator="<?= $Page->intrajornada->displayValueSeparatorAttribute() ?>"
    <?= $Page->intrajornada->editAttributes() ?>></selection-list>
<?= $Page->intrajornada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->intrajornada->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
    <div id="r_tipo_uniforme_idtipo_uniforme"<?= $Page->tipo_uniforme_idtipo_uniforme->rowAttributes() ?>>
        <label id="elh_cargo_copy_tipo_uniforme_idtipo_uniforme" for="x_tipo_uniforme_idtipo_uniforme" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_uniforme_idtipo_uniforme->caption() ?><?= $Page->tipo_uniforme_idtipo_uniforme->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_uniforme_idtipo_uniforme->cellAttributes() ?>>
<span id="el_cargo_copy_tipo_uniforme_idtipo_uniforme">
<input type="<?= $Page->tipo_uniforme_idtipo_uniforme->getInputTextType() ?>" name="x_tipo_uniforme_idtipo_uniforme" id="x_tipo_uniforme_idtipo_uniforme" data-table="cargo_copy" data-field="x_tipo_uniforme_idtipo_uniforme" value="<?= $Page->tipo_uniforme_idtipo_uniforme->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tipo_uniforme_idtipo_uniforme->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipo_uniforme_idtipo_uniforme->formatPattern()) ?>"<?= $Page->tipo_uniforme_idtipo_uniforme->editAttributes() ?> aria-describedby="x_tipo_uniforme_idtipo_uniforme_help">
<?= $Page->tipo_uniforme_idtipo_uniforme->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_uniforme_idtipo_uniforme->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->salario_antes->Visible) { // salario_antes ?>
    <div id="r_salario_antes"<?= $Page->salario_antes->rowAttributes() ?>>
        <label id="elh_cargo_copy_salario_antes" for="x_salario_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->salario_antes->caption() ?><?= $Page->salario_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->salario_antes->cellAttributes() ?>>
<span id="el_cargo_copy_salario_antes">
<input type="<?= $Page->salario_antes->getInputTextType() ?>" name="x_salario_antes" id="x_salario_antes" data-table="cargo_copy" data-field="x_salario_antes" value="<?= $Page->salario_antes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->salario_antes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->salario_antes->formatPattern()) ?>"<?= $Page->salario_antes->editAttributes() ?> aria-describedby="x_salario_antes_help">
<?= $Page->salario_antes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->salario_antes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vt_dia_antes->Visible) { // vt_dia_antes ?>
    <div id="r_vt_dia_antes"<?= $Page->vt_dia_antes->rowAttributes() ?>>
        <label id="elh_cargo_copy_vt_dia_antes" for="x_vt_dia_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vt_dia_antes->caption() ?><?= $Page->vt_dia_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vt_dia_antes->cellAttributes() ?>>
<span id="el_cargo_copy_vt_dia_antes">
<input type="<?= $Page->vt_dia_antes->getInputTextType() ?>" name="x_vt_dia_antes" id="x_vt_dia_antes" data-table="cargo_copy" data-field="x_vt_dia_antes" value="<?= $Page->vt_dia_antes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->vt_dia_antes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vt_dia_antes->formatPattern()) ?>"<?= $Page->vt_dia_antes->editAttributes() ?> aria-describedby="x_vt_dia_antes_help">
<?= $Page->vt_dia_antes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vt_dia_antes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vr_dia_antes->Visible) { // vr_dia_antes ?>
    <div id="r_vr_dia_antes"<?= $Page->vr_dia_antes->rowAttributes() ?>>
        <label id="elh_cargo_copy_vr_dia_antes" for="x_vr_dia_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vr_dia_antes->caption() ?><?= $Page->vr_dia_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vr_dia_antes->cellAttributes() ?>>
<span id="el_cargo_copy_vr_dia_antes">
<input type="<?= $Page->vr_dia_antes->getInputTextType() ?>" name="x_vr_dia_antes" id="x_vr_dia_antes" data-table="cargo_copy" data-field="x_vr_dia_antes" value="<?= $Page->vr_dia_antes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->vr_dia_antes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_dia_antes->formatPattern()) ?>"<?= $Page->vr_dia_antes->editAttributes() ?> aria-describedby="x_vr_dia_antes_help">
<?= $Page->vr_dia_antes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vr_dia_antes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->va_mes_antes->Visible) { // va_mes_antes ?>
    <div id="r_va_mes_antes"<?= $Page->va_mes_antes->rowAttributes() ?>>
        <label id="elh_cargo_copy_va_mes_antes" for="x_va_mes_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->va_mes_antes->caption() ?><?= $Page->va_mes_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->va_mes_antes->cellAttributes() ?>>
<span id="el_cargo_copy_va_mes_antes">
<input type="<?= $Page->va_mes_antes->getInputTextType() ?>" name="x_va_mes_antes" id="x_va_mes_antes" data-table="cargo_copy" data-field="x_va_mes_antes" value="<?= $Page->va_mes_antes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->va_mes_antes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->va_mes_antes->formatPattern()) ?>"<?= $Page->va_mes_antes->editAttributes() ?> aria-describedby="x_va_mes_antes_help">
<?= $Page->va_mes_antes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->va_mes_antes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->benef_social_antes->Visible) { // benef_social_antes ?>
    <div id="r_benef_social_antes"<?= $Page->benef_social_antes->rowAttributes() ?>>
        <label id="elh_cargo_copy_benef_social_antes" for="x_benef_social_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->benef_social_antes->caption() ?><?= $Page->benef_social_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->benef_social_antes->cellAttributes() ?>>
<span id="el_cargo_copy_benef_social_antes">
<input type="<?= $Page->benef_social_antes->getInputTextType() ?>" name="x_benef_social_antes" id="x_benef_social_antes" data-table="cargo_copy" data-field="x_benef_social_antes" value="<?= $Page->benef_social_antes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->benef_social_antes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->benef_social_antes->formatPattern()) ?>"<?= $Page->benef_social_antes->editAttributes() ?> aria-describedby="x_benef_social_antes_help">
<?= $Page->benef_social_antes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->benef_social_antes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->plr_antes->Visible) { // plr_antes ?>
    <div id="r_plr_antes"<?= $Page->plr_antes->rowAttributes() ?>>
        <label id="elh_cargo_copy_plr_antes" for="x_plr_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->plr_antes->caption() ?><?= $Page->plr_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->plr_antes->cellAttributes() ?>>
<span id="el_cargo_copy_plr_antes">
<input type="<?= $Page->plr_antes->getInputTextType() ?>" name="x_plr_antes" id="x_plr_antes" data-table="cargo_copy" data-field="x_plr_antes" value="<?= $Page->plr_antes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->plr_antes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->plr_antes->formatPattern()) ?>"<?= $Page->plr_antes->editAttributes() ?> aria-describedby="x_plr_antes_help">
<?= $Page->plr_antes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->plr_antes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->assis_medica_antes->Visible) { // assis_medica_antes ?>
    <div id="r_assis_medica_antes"<?= $Page->assis_medica_antes->rowAttributes() ?>>
        <label id="elh_cargo_copy_assis_medica_antes" for="x_assis_medica_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->assis_medica_antes->caption() ?><?= $Page->assis_medica_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->assis_medica_antes->cellAttributes() ?>>
<span id="el_cargo_copy_assis_medica_antes">
<input type="<?= $Page->assis_medica_antes->getInputTextType() ?>" name="x_assis_medica_antes" id="x_assis_medica_antes" data-table="cargo_copy" data-field="x_assis_medica_antes" value="<?= $Page->assis_medica_antes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->assis_medica_antes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_medica_antes->formatPattern()) ?>"<?= $Page->assis_medica_antes->editAttributes() ?> aria-describedby="x_assis_medica_antes_help">
<?= $Page->assis_medica_antes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->assis_medica_antes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->assis_odonto_antes->Visible) { // assis_odonto_antes ?>
    <div id="r_assis_odonto_antes"<?= $Page->assis_odonto_antes->rowAttributes() ?>>
        <label id="elh_cargo_copy_assis_odonto_antes" for="x_assis_odonto_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->assis_odonto_antes->caption() ?><?= $Page->assis_odonto_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->assis_odonto_antes->cellAttributes() ?>>
<span id="el_cargo_copy_assis_odonto_antes">
<input type="<?= $Page->assis_odonto_antes->getInputTextType() ?>" name="x_assis_odonto_antes" id="x_assis_odonto_antes" data-table="cargo_copy" data-field="x_assis_odonto_antes" value="<?= $Page->assis_odonto_antes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->assis_odonto_antes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_odonto_antes->formatPattern()) ?>"<?= $Page->assis_odonto_antes->editAttributes() ?> aria-describedby="x_assis_odonto_antes_help">
<?= $Page->assis_odonto_antes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->assis_odonto_antes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->funcao_idfuncao->Visible) { // funcao_idfuncao ?>
    <div id="r_funcao_idfuncao"<?= $Page->funcao_idfuncao->rowAttributes() ?>>
        <label id="elh_cargo_copy_funcao_idfuncao" for="x_funcao_idfuncao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->funcao_idfuncao->caption() ?><?= $Page->funcao_idfuncao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->funcao_idfuncao->cellAttributes() ?>>
<span id="el_cargo_copy_funcao_idfuncao">
<input type="<?= $Page->funcao_idfuncao->getInputTextType() ?>" name="x_funcao_idfuncao" id="x_funcao_idfuncao" data-table="cargo_copy" data-field="x_funcao_idfuncao" value="<?= $Page->funcao_idfuncao->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->funcao_idfuncao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->funcao_idfuncao->formatPattern()) ?>"<?= $Page->funcao_idfuncao->editAttributes() ?> aria-describedby="x_funcao_idfuncao_help">
<?= $Page->funcao_idfuncao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->funcao_idfuncao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->salario1->Visible) { // salario1 ?>
    <div id="r_salario1"<?= $Page->salario1->rowAttributes() ?>>
        <label id="elh_cargo_copy_salario1" for="x_salario1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->salario1->caption() ?><?= $Page->salario1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->salario1->cellAttributes() ?>>
<span id="el_cargo_copy_salario1">
<input type="<?= $Page->salario1->getInputTextType() ?>" name="x_salario1" id="x_salario1" data-table="cargo_copy" data-field="x_salario1" value="<?= $Page->salario1->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->salario1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->salario1->formatPattern()) ?>"<?= $Page->salario1->editAttributes() ?> aria-describedby="x_salario1_help">
<?= $Page->salario1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->salario1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcargo_copyedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcargo_copyedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("cargo_copy");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
