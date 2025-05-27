<?php

namespace PHPMaker2024\contratos;

// Page object
$PlanilhaCustoContratoCopyAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { planilha_custo_contrato_copy: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fplanilha_custo_contrato_copyadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplanilha_custo_contrato_copyadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null, ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["quantidade", [fields.quantidade.visible && fields.quantidade.required ? ew.Validators.required(fields.quantidade.caption) : null, ew.Validators.integer], fields.quantidade.isInvalid],
            ["acumulo_funcao", [fields.acumulo_funcao.visible && fields.acumulo_funcao.required ? ew.Validators.required(fields.acumulo_funcao.caption) : null], fields.acumulo_funcao.isInvalid],
            ["periodo_idperiodo", [fields.periodo_idperiodo.visible && fields.periodo_idperiodo.required ? ew.Validators.required(fields.periodo_idperiodo.caption) : null, ew.Validators.integer], fields.periodo_idperiodo.isInvalid],
            ["cargo_idcargo", [fields.cargo_idcargo.visible && fields.cargo_idcargo.required ? ew.Validators.required(fields.cargo_idcargo.caption) : null, ew.Validators.integer], fields.cargo_idcargo.isInvalid],
            ["tipo_intrajornada_idtipo_intrajornada", [fields.tipo_intrajornada_idtipo_intrajornada.visible && fields.tipo_intrajornada_idtipo_intrajornada.required ? ew.Validators.required(fields.tipo_intrajornada_idtipo_intrajornada.caption) : null, ew.Validators.integer], fields.tipo_intrajornada_idtipo_intrajornada.isInvalid],
            ["escala_idescala", [fields.escala_idescala.visible && fields.escala_idescala.required ? ew.Validators.required(fields.escala_idescala.caption) : null, ew.Validators.integer], fields.escala_idescala.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null, ew.Validators.integer], fields.usuario_idusuario.isInvalid],
            ["contrato_idcontrato", [fields.contrato_idcontrato.visible && fields.contrato_idcontrato.required ? ew.Validators.required(fields.contrato_idcontrato.caption) : null, ew.Validators.integer], fields.contrato_idcontrato.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "acumulo_funcao": <?= $Page->acumulo_funcao->toClientList($Page) ?>,
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
<form name="fplanilha_custo_contrato_copyadd" id="fplanilha_custo_contrato_copyadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="planilha_custo_contrato_copy">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_copy_dt_cadastro" for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dt_cadastro->caption() ?><?= $Page->dt_cadastro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_dt_cadastro">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="planilha_custo_contrato_copy" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?> aria-describedby="x_dt_cadastro_help">
<?= $Page->dt_cadastro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage() ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplanilha_custo_contrato_copyadd", "datetimepicker"], function () {
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
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fplanilha_custo_contrato_copyadd", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
    <div id="r_quantidade"<?= $Page->quantidade->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_copy_quantidade" for="x_quantidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->quantidade->caption() ?><?= $Page->quantidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->quantidade->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_quantidade">
<input type="<?= $Page->quantidade->getInputTextType() ?>" name="x_quantidade" id="x_quantidade" data-table="planilha_custo_contrato_copy" data-field="x_quantidade" value="<?= $Page->quantidade->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->quantidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->quantidade->formatPattern()) ?>"<?= $Page->quantidade->editAttributes() ?> aria-describedby="x_quantidade_help">
<?= $Page->quantidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->quantidade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
    <div id="r_acumulo_funcao"<?= $Page->acumulo_funcao->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_copy_acumulo_funcao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acumulo_funcao->caption() ?><?= $Page->acumulo_funcao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_acumulo_funcao">
<template id="tp_x_acumulo_funcao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato_copy" data-field="x_acumulo_funcao" name="x_acumulo_funcao" id="x_acumulo_funcao"<?= $Page->acumulo_funcao->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_acumulo_funcao" class="ew-item-list"></div>
<selection-list hidden
    id="x_acumulo_funcao"
    name="x_acumulo_funcao"
    value="<?= HtmlEncode($Page->acumulo_funcao->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_acumulo_funcao"
    data-target="dsl_x_acumulo_funcao"
    data-repeatcolumn="5"
    class="form-control<?= $Page->acumulo_funcao->isInvalidClass() ?>"
    data-table="planilha_custo_contrato_copy"
    data-field="x_acumulo_funcao"
    data-value-separator="<?= $Page->acumulo_funcao->displayValueSeparatorAttribute() ?>"
    <?= $Page->acumulo_funcao->editAttributes() ?>></selection-list>
<?= $Page->acumulo_funcao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->acumulo_funcao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
    <div id="r_periodo_idperiodo"<?= $Page->periodo_idperiodo->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_copy_periodo_idperiodo" for="x_periodo_idperiodo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periodo_idperiodo->caption() ?><?= $Page->periodo_idperiodo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_periodo_idperiodo">
<input type="<?= $Page->periodo_idperiodo->getInputTextType() ?>" name="x_periodo_idperiodo" id="x_periodo_idperiodo" data-table="planilha_custo_contrato_copy" data-field="x_periodo_idperiodo" value="<?= $Page->periodo_idperiodo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->periodo_idperiodo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->periodo_idperiodo->formatPattern()) ?>"<?= $Page->periodo_idperiodo->editAttributes() ?> aria-describedby="x_periodo_idperiodo_help">
<?= $Page->periodo_idperiodo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->periodo_idperiodo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
    <div id="r_cargo_idcargo"<?= $Page->cargo_idcargo->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_copy_cargo_idcargo" for="x_cargo_idcargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cargo_idcargo->caption() ?><?= $Page->cargo_idcargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cargo_idcargo->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_cargo_idcargo">
<input type="<?= $Page->cargo_idcargo->getInputTextType() ?>" name="x_cargo_idcargo" id="x_cargo_idcargo" data-table="planilha_custo_contrato_copy" data-field="x_cargo_idcargo" value="<?= $Page->cargo_idcargo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->cargo_idcargo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cargo_idcargo->formatPattern()) ?>"<?= $Page->cargo_idcargo->editAttributes() ?> aria-describedby="x_cargo_idcargo_help">
<?= $Page->cargo_idcargo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cargo_idcargo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
    <div id="r_tipo_intrajornada_idtipo_intrajornada"<?= $Page->tipo_intrajornada_idtipo_intrajornada->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_copy_tipo_intrajornada_idtipo_intrajornada" for="x_tipo_intrajornada_idtipo_intrajornada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_intrajornada_idtipo_intrajornada->caption() ?><?= $Page->tipo_intrajornada_idtipo_intrajornada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_intrajornada_idtipo_intrajornada->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_tipo_intrajornada_idtipo_intrajornada">
<input type="<?= $Page->tipo_intrajornada_idtipo_intrajornada->getInputTextType() ?>" name="x_tipo_intrajornada_idtipo_intrajornada" id="x_tipo_intrajornada_idtipo_intrajornada" data-table="planilha_custo_contrato_copy" data-field="x_tipo_intrajornada_idtipo_intrajornada" value="<?= $Page->tipo_intrajornada_idtipo_intrajornada->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tipo_intrajornada_idtipo_intrajornada->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipo_intrajornada_idtipo_intrajornada->formatPattern()) ?>"<?= $Page->tipo_intrajornada_idtipo_intrajornada->editAttributes() ?> aria-describedby="x_tipo_intrajornada_idtipo_intrajornada_help">
<?= $Page->tipo_intrajornada_idtipo_intrajornada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_intrajornada_idtipo_intrajornada->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
    <div id="r_escala_idescala"<?= $Page->escala_idescala->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_copy_escala_idescala" for="x_escala_idescala" class="<?= $Page->LeftColumnClass ?>"><?= $Page->escala_idescala->caption() ?><?= $Page->escala_idescala->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_escala_idescala">
<input type="<?= $Page->escala_idescala->getInputTextType() ?>" name="x_escala_idescala" id="x_escala_idescala" data-table="planilha_custo_contrato_copy" data-field="x_escala_idescala" value="<?= $Page->escala_idescala->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->escala_idescala->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->escala_idescala->formatPattern()) ?>"<?= $Page->escala_idescala->editAttributes() ?> aria-describedby="x_escala_idescala_help">
<?= $Page->escala_idescala->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->escala_idescala->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_copy_usuario_idusuario" for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_idusuario->caption() ?><?= $Page->usuario_idusuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_usuario_idusuario">
<input type="<?= $Page->usuario_idusuario->getInputTextType() ?>" name="x_usuario_idusuario" id="x_usuario_idusuario" data-table="planilha_custo_contrato_copy" data-field="x_usuario_idusuario" value="<?= $Page->usuario_idusuario->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->usuario_idusuario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->usuario_idusuario->formatPattern()) ?>"<?= $Page->usuario_idusuario->editAttributes() ?> aria-describedby="x_usuario_idusuario_help">
<?= $Page->usuario_idusuario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->usuario_idusuario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contrato_idcontrato->Visible) { // contrato_idcontrato ?>
    <div id="r_contrato_idcontrato"<?= $Page->contrato_idcontrato->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_copy_contrato_idcontrato" for="x_contrato_idcontrato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contrato_idcontrato->caption() ?><?= $Page->contrato_idcontrato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contrato_idcontrato->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_copy_contrato_idcontrato">
<input type="<?= $Page->contrato_idcontrato->getInputTextType() ?>" name="x_contrato_idcontrato" id="x_contrato_idcontrato" data-table="planilha_custo_contrato_copy" data-field="x_contrato_idcontrato" value="<?= $Page->contrato_idcontrato->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->contrato_idcontrato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contrato_idcontrato->formatPattern()) ?>"<?= $Page->contrato_idcontrato->editAttributes() ?> aria-describedby="x_contrato_idcontrato_help">
<?= $Page->contrato_idcontrato->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contrato_idcontrato->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fplanilha_custo_contrato_copyadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fplanilha_custo_contrato_copyadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("planilha_custo_contrato_copy");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
