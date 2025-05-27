<?php

namespace PHPMaker2024\contratos;

// Page object
$BeneficiosAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { beneficios: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fbeneficiosadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fbeneficiosadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["data", [fields.data.visible && fields.data.required ? ew.Validators.required(fields.data.caption) : null, ew.Validators.datetime(fields.data.clientFormatPattern)], fields.data.isInvalid],
            ["vt_dia", [fields.vt_dia.visible && fields.vt_dia.required ? ew.Validators.required(fields.vt_dia.caption) : null, ew.Validators.float], fields.vt_dia.isInvalid],
            ["vr_dia", [fields.vr_dia.visible && fields.vr_dia.required ? ew.Validators.required(fields.vr_dia.caption) : null, ew.Validators.float], fields.vr_dia.isInvalid],
            ["va_mes", [fields.va_mes.visible && fields.va_mes.required ? ew.Validators.required(fields.va_mes.caption) : null, ew.Validators.float], fields.va_mes.isInvalid],
            ["benef_social", [fields.benef_social.visible && fields.benef_social.required ? ew.Validators.required(fields.benef_social.caption) : null, ew.Validators.float], fields.benef_social.isInvalid],
            ["plr", [fields.plr.visible && fields.plr.required ? ew.Validators.required(fields.plr.caption) : null, ew.Validators.float], fields.plr.isInvalid],
            ["assis_medica", [fields.assis_medica.visible && fields.assis_medica.required ? ew.Validators.required(fields.assis_medica.caption) : null, ew.Validators.float], fields.assis_medica.isInvalid],
            ["assis_odonto", [fields.assis_odonto.visible && fields.assis_odonto.required ? ew.Validators.required(fields.assis_odonto.caption) : null, ew.Validators.float], fields.assis_odonto.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fbeneficiosadd" id="fbeneficiosadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="beneficios">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "dissidio_anual") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="dissidio_anual">
<input type="hidden" name="fk_iddissidio_anual" value="<?= HtmlEncode($Page->dissidio_anual_iddissidio_anual->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->data->Visible) { // data ?>
    <div id="r_data"<?= $Page->data->rowAttributes() ?>>
        <label id="elh_beneficios_data" for="x_data" class="<?= $Page->LeftColumnClass ?>"><?= $Page->data->caption() ?><?= $Page->data->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->data->cellAttributes() ?>>
<span id="el_beneficios_data">
<input type="<?= $Page->data->getInputTextType() ?>" name="x_data" id="x_data" data-table="beneficios" data-field="x_data" value="<?= $Page->data->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->data->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->data->formatPattern()) ?>"<?= $Page->data->editAttributes() ?> aria-describedby="x_data_help">
<?= $Page->data->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->data->getErrorMessage() ?></div>
<?php if (!$Page->data->ReadOnly && !$Page->data->Disabled && !isset($Page->data->EditAttrs["readonly"]) && !isset($Page->data->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbeneficiosadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fbeneficiosadd", "x_data", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
    <div id="r_vt_dia"<?= $Page->vt_dia->rowAttributes() ?>>
        <label id="elh_beneficios_vt_dia" for="x_vt_dia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vt_dia->caption() ?><?= $Page->vt_dia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vt_dia->cellAttributes() ?>>
<span id="el_beneficios_vt_dia">
<input type="<?= $Page->vt_dia->getInputTextType() ?>" name="x_vt_dia" id="x_vt_dia" data-table="beneficios" data-field="x_vt_dia" value="<?= $Page->vt_dia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->vt_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vt_dia->formatPattern()) ?>"<?= $Page->vt_dia->editAttributes() ?> aria-describedby="x_vt_dia_help">
<?= $Page->vt_dia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vt_dia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
    <div id="r_vr_dia"<?= $Page->vr_dia->rowAttributes() ?>>
        <label id="elh_beneficios_vr_dia" for="x_vr_dia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vr_dia->caption() ?><?= $Page->vr_dia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vr_dia->cellAttributes() ?>>
<span id="el_beneficios_vr_dia">
<input type="<?= $Page->vr_dia->getInputTextType() ?>" name="x_vr_dia" id="x_vr_dia" data-table="beneficios" data-field="x_vr_dia" value="<?= $Page->vr_dia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->vr_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_dia->formatPattern()) ?>"<?= $Page->vr_dia->editAttributes() ?> aria-describedby="x_vr_dia_help">
<?= $Page->vr_dia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vr_dia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
    <div id="r_va_mes"<?= $Page->va_mes->rowAttributes() ?>>
        <label id="elh_beneficios_va_mes" for="x_va_mes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->va_mes->caption() ?><?= $Page->va_mes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->va_mes->cellAttributes() ?>>
<span id="el_beneficios_va_mes">
<input type="<?= $Page->va_mes->getInputTextType() ?>" name="x_va_mes" id="x_va_mes" data-table="beneficios" data-field="x_va_mes" value="<?= $Page->va_mes->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->va_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->va_mes->formatPattern()) ?>"<?= $Page->va_mes->editAttributes() ?> aria-describedby="x_va_mes_help">
<?= $Page->va_mes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->va_mes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
    <div id="r_benef_social"<?= $Page->benef_social->rowAttributes() ?>>
        <label id="elh_beneficios_benef_social" for="x_benef_social" class="<?= $Page->LeftColumnClass ?>"><?= $Page->benef_social->caption() ?><?= $Page->benef_social->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->benef_social->cellAttributes() ?>>
<span id="el_beneficios_benef_social">
<input type="<?= $Page->benef_social->getInputTextType() ?>" name="x_benef_social" id="x_benef_social" data-table="beneficios" data-field="x_benef_social" value="<?= $Page->benef_social->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->benef_social->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->benef_social->formatPattern()) ?>"<?= $Page->benef_social->editAttributes() ?> aria-describedby="x_benef_social_help">
<?= $Page->benef_social->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->benef_social->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
    <div id="r_plr"<?= $Page->plr->rowAttributes() ?>>
        <label id="elh_beneficios_plr" for="x_plr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->plr->caption() ?><?= $Page->plr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->plr->cellAttributes() ?>>
<span id="el_beneficios_plr">
<input type="<?= $Page->plr->getInputTextType() ?>" name="x_plr" id="x_plr" data-table="beneficios" data-field="x_plr" value="<?= $Page->plr->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->plr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->plr->formatPattern()) ?>"<?= $Page->plr->editAttributes() ?> aria-describedby="x_plr_help">
<?= $Page->plr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->plr->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
    <div id="r_assis_medica"<?= $Page->assis_medica->rowAttributes() ?>>
        <label id="elh_beneficios_assis_medica" for="x_assis_medica" class="<?= $Page->LeftColumnClass ?>"><?= $Page->assis_medica->caption() ?><?= $Page->assis_medica->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->assis_medica->cellAttributes() ?>>
<span id="el_beneficios_assis_medica">
<input type="<?= $Page->assis_medica->getInputTextType() ?>" name="x_assis_medica" id="x_assis_medica" data-table="beneficios" data-field="x_assis_medica" value="<?= $Page->assis_medica->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->assis_medica->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_medica->formatPattern()) ?>"<?= $Page->assis_medica->editAttributes() ?> aria-describedby="x_assis_medica_help">
<?= $Page->assis_medica->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->assis_medica->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
    <div id="r_assis_odonto"<?= $Page->assis_odonto->rowAttributes() ?>>
        <label id="elh_beneficios_assis_odonto" for="x_assis_odonto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->assis_odonto->caption() ?><?= $Page->assis_odonto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->assis_odonto->cellAttributes() ?>>
<span id="el_beneficios_assis_odonto">
<input type="<?= $Page->assis_odonto->getInputTextType() ?>" name="x_assis_odonto" id="x_assis_odonto" data-table="beneficios" data-field="x_assis_odonto" value="<?= $Page->assis_odonto->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->assis_odonto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_odonto->formatPattern()) ?>"<?= $Page->assis_odonto->editAttributes() ?> aria-describedby="x_assis_odonto_help">
<?= $Page->assis_odonto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->assis_odonto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <?php if (strval($Page->dissidio_anual_iddissidio_anual->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_dissidio_anual_iddissidio_anual" id="x_dissidio_anual_iddissidio_anual" value="<?= HtmlEncode(strval($Page->dissidio_anual_iddissidio_anual->getSessionValue())) ?>">
    <?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fbeneficiosadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fbeneficiosadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("beneficios");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
