<?php

namespace PHPMaker2024\contratos;

// Page object
$PlanilhaCustoContratoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { planilha_custo_contrato: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fplanilha_custo_contratoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplanilha_custo_contratoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["quantidade", [fields.quantidade.visible && fields.quantidade.required ? ew.Validators.required(fields.quantidade.caption) : null, ew.Validators.range(1, 10)], fields.quantidade.isInvalid],
            ["escala_idescala", [fields.escala_idescala.visible && fields.escala_idescala.required ? ew.Validators.required(fields.escala_idescala.caption) : null], fields.escala_idescala.isInvalid],
            ["periodo_idperiodo", [fields.periodo_idperiodo.visible && fields.periodo_idperiodo.required ? ew.Validators.required(fields.periodo_idperiodo.caption) : null], fields.periodo_idperiodo.isInvalid],
            ["tipo_intrajornada_idtipo_intrajornada", [fields.tipo_intrajornada_idtipo_intrajornada.visible && fields.tipo_intrajornada_idtipo_intrajornada.required ? ew.Validators.required(fields.tipo_intrajornada_idtipo_intrajornada.caption) : null], fields.tipo_intrajornada_idtipo_intrajornada.isInvalid],
            ["cargo_idcargo", [fields.cargo_idcargo.visible && fields.cargo_idcargo.required ? ew.Validators.required(fields.cargo_idcargo.caption) : null], fields.cargo_idcargo.isInvalid],
            ["acumulo_funcao", [fields.acumulo_funcao.visible && fields.acumulo_funcao.required ? ew.Validators.required(fields.acumulo_funcao.caption) : null], fields.acumulo_funcao.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
            ["contrato_idcontrato", [fields.contrato_idcontrato.visible && fields.contrato_idcontrato.required ? ew.Validators.required(fields.contrato_idcontrato.caption) : null, ew.Validators.integer], fields.contrato_idcontrato.isInvalid]
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
            "escala_idescala": <?= $Page->escala_idescala->toClientList($Page) ?>,
            "periodo_idperiodo": <?= $Page->periodo_idperiodo->toClientList($Page) ?>,
            "tipo_intrajornada_idtipo_intrajornada": <?= $Page->tipo_intrajornada_idtipo_intrajornada->toClientList($Page) ?>,
            "cargo_idcargo": <?= $Page->cargo_idcargo->toClientList($Page) ?>,
            "acumulo_funcao": <?= $Page->acumulo_funcao->toClientList($Page) ?>,
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
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
<form name="fplanilha_custo_contratoadd" id="fplanilha_custo_contratoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="planilha_custo_contrato">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "contrato") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="contrato">
<input type="hidden" name="fk_idcontrato" value="<?= HtmlEncode($Page->contrato_idcontrato->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->quantidade->Visible) { // quantidade ?>
    <div id="r_quantidade"<?= $Page->quantidade->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_quantidade" for="x_quantidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->quantidade->caption() ?><?= $Page->quantidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->quantidade->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_quantidade">
<input type="<?= $Page->quantidade->getInputTextType() ?>" name="x_quantidade" id="x_quantidade" data-table="planilha_custo_contrato" data-field="x_quantidade" value="<?= $Page->quantidade->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Page->quantidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->quantidade->formatPattern()) ?>"<?= $Page->quantidade->editAttributes() ?> aria-describedby="x_quantidade_help">
<?= $Page->quantidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->quantidade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
    <div id="r_escala_idescala"<?= $Page->escala_idescala->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_escala_idescala" class="<?= $Page->LeftColumnClass ?>"><?= $Page->escala_idescala->caption() ?><?= $Page->escala_idescala->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_escala_idescala">
<template id="tp_x_escala_idescala">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_escala_idescala" name="x_escala_idescala" id="x_escala_idescala"<?= $Page->escala_idescala->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_escala_idescala" class="ew-item-list"></div>
<selection-list hidden
    id="x_escala_idescala"
    name="x_escala_idescala"
    value="<?= HtmlEncode($Page->escala_idescala->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_escala_idescala"
    data-target="dsl_x_escala_idescala"
    data-repeatcolumn="10"
    class="form-control<?= $Page->escala_idescala->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_escala_idescala"
    data-value-separator="<?= $Page->escala_idescala->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Page->escala_idescala->editAttributes() ?>></selection-list>
<?= $Page->escala_idescala->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->escala_idescala->getErrorMessage() ?></div>
<?= $Page->escala_idescala->Lookup->getParamTag($Page, "p_x_escala_idescala") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
    <div id="r_periodo_idperiodo"<?= $Page->periodo_idperiodo->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_periodo_idperiodo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periodo_idperiodo->caption() ?><?= $Page->periodo_idperiodo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_periodo_idperiodo">
<template id="tp_x_periodo_idperiodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_periodo_idperiodo" name="x_periodo_idperiodo" id="x_periodo_idperiodo"<?= $Page->periodo_idperiodo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_periodo_idperiodo" class="ew-item-list"></div>
<selection-list hidden
    id="x_periodo_idperiodo"
    name="x_periodo_idperiodo"
    value="<?= HtmlEncode($Page->periodo_idperiodo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_periodo_idperiodo"
    data-target="dsl_x_periodo_idperiodo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodo_idperiodo->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_periodo_idperiodo"
    data-value-separator="<?= $Page->periodo_idperiodo->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Page->periodo_idperiodo->editAttributes() ?>></selection-list>
<?= $Page->periodo_idperiodo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->periodo_idperiodo->getErrorMessage() ?></div>
<?= $Page->periodo_idperiodo->Lookup->getParamTag($Page, "p_x_periodo_idperiodo") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
    <div id="r_tipo_intrajornada_idtipo_intrajornada"<?= $Page->tipo_intrajornada_idtipo_intrajornada->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_intrajornada_idtipo_intrajornada->caption() ?><?= $Page->tipo_intrajornada_idtipo_intrajornada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_intrajornada_idtipo_intrajornada->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada">
<template id="tp_x_tipo_intrajornada_idtipo_intrajornada">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_tipo_intrajornada_idtipo_intrajornada" name="x_tipo_intrajornada_idtipo_intrajornada" id="x_tipo_intrajornada_idtipo_intrajornada"<?= $Page->tipo_intrajornada_idtipo_intrajornada->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo_intrajornada_idtipo_intrajornada" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo_intrajornada_idtipo_intrajornada"
    name="x_tipo_intrajornada_idtipo_intrajornada"
    value="<?= HtmlEncode($Page->tipo_intrajornada_idtipo_intrajornada->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_intrajornada_idtipo_intrajornada"
    data-target="dsl_x_tipo_intrajornada_idtipo_intrajornada"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_intrajornada_idtipo_intrajornada->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_tipo_intrajornada_idtipo_intrajornada"
    data-value-separator="<?= $Page->tipo_intrajornada_idtipo_intrajornada->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_intrajornada_idtipo_intrajornada->editAttributes() ?>></selection-list>
<?= $Page->tipo_intrajornada_idtipo_intrajornada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_intrajornada_idtipo_intrajornada->getErrorMessage() ?></div>
<?= $Page->tipo_intrajornada_idtipo_intrajornada->Lookup->getParamTag($Page, "p_x_tipo_intrajornada_idtipo_intrajornada") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
    <div id="r_cargo_idcargo"<?= $Page->cargo_idcargo->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_cargo_idcargo" for="x_cargo_idcargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cargo_idcargo->caption() ?><?= $Page->cargo_idcargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cargo_idcargo->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_cargo_idcargo">
    <select
        id="x_cargo_idcargo"
        name="x_cargo_idcargo"
        class="form-control ew-select<?= $Page->cargo_idcargo->isInvalidClass() ?>"
        data-select2-id="fplanilha_custo_contratoadd_x_cargo_idcargo"
        data-table="planilha_custo_contrato"
        data-field="x_cargo_idcargo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->cargo_idcargo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->cargo_idcargo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cargo_idcargo->getPlaceHolder()) ?>"
        <?= $Page->cargo_idcargo->editAttributes() ?>>
        <?= $Page->cargo_idcargo->selectOptionListHtml("x_cargo_idcargo") ?>
    </select>
    <?= $Page->cargo_idcargo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cargo_idcargo->getErrorMessage() ?></div>
<?= $Page->cargo_idcargo->Lookup->getParamTag($Page, "p_x_cargo_idcargo") ?>
<script>
loadjs.ready("fplanilha_custo_contratoadd", function() {
    var options = { name: "x_cargo_idcargo", selectId: "fplanilha_custo_contratoadd_x_cargo_idcargo" };
    if (fplanilha_custo_contratoadd.lists.cargo_idcargo?.lookupOptions.length) {
        options.data = { id: "x_cargo_idcargo", form: "fplanilha_custo_contratoadd" };
    } else {
        options.ajax = { id: "x_cargo_idcargo", form: "fplanilha_custo_contratoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.planilha_custo_contrato.fields.cargo_idcargo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
    <div id="r_acumulo_funcao"<?= $Page->acumulo_funcao->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_acumulo_funcao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acumulo_funcao->caption() ?><?= $Page->acumulo_funcao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span id="el_planilha_custo_contrato_acumulo_funcao">
<template id="tp_x_acumulo_funcao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_acumulo_funcao" name="x_acumulo_funcao" id="x_acumulo_funcao"<?= $Page->acumulo_funcao->editAttributes() ?>>
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
    data-table="planilha_custo_contrato"
    data-field="x_acumulo_funcao"
    data-value-separator="<?= $Page->acumulo_funcao->displayValueSeparatorAttribute() ?>"
    <?= $Page->acumulo_funcao->editAttributes() ?>></selection-list>
<?= $Page->acumulo_funcao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->acumulo_funcao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contrato_idcontrato->Visible) { // contrato_idcontrato ?>
    <div id="r_contrato_idcontrato"<?= $Page->contrato_idcontrato->rowAttributes() ?>>
        <label id="elh_planilha_custo_contrato_contrato_idcontrato" for="x_contrato_idcontrato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contrato_idcontrato->caption() ?><?= $Page->contrato_idcontrato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contrato_idcontrato->cellAttributes() ?>>
<?php if ($Page->contrato_idcontrato->getSessionValue() != "") { ?>
<span id="el_planilha_custo_contrato_contrato_idcontrato">
<span<?= $Page->contrato_idcontrato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->contrato_idcontrato->getDisplayValue($Page->contrato_idcontrato->ViewValue))) ?>"></span>
<input type="hidden" id="x_contrato_idcontrato" name="x_contrato_idcontrato" value="<?= HtmlEncode($Page->contrato_idcontrato->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_planilha_custo_contrato_contrato_idcontrato">
<input type="<?= $Page->contrato_idcontrato->getInputTextType() ?>" name="x_contrato_idcontrato" id="x_contrato_idcontrato" data-table="planilha_custo_contrato" data-field="x_contrato_idcontrato" value="<?= $Page->contrato_idcontrato->EditValue ?>" size="4" maxlength="4" placeholder="<?= HtmlEncode($Page->contrato_idcontrato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contrato_idcontrato->formatPattern()) ?>"<?= $Page->contrato_idcontrato->editAttributes() ?> aria-describedby="x_contrato_idcontrato_help">
<?= $Page->contrato_idcontrato->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contrato_idcontrato->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fplanilha_custo_contratoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fplanilha_custo_contratoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("planilha_custo_contrato");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
