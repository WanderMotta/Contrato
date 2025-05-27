<?php

namespace PHPMaker2024\contratos;

// Page object
$PlanilhaCustoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fplanilha_custoedit" id="fplanilha_custoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { planilha_custo: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fplanilha_custoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplanilha_custoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idplanilha_custo", [fields.idplanilha_custo.visible && fields.idplanilha_custo.required ? ew.Validators.required(fields.idplanilha_custo.caption) : null], fields.idplanilha_custo.isInvalid],
            ["proposta_idproposta", [fields.proposta_idproposta.visible && fields.proposta_idproposta.required ? ew.Validators.required(fields.proposta_idproposta.caption) : null, ew.Validators.integer], fields.proposta_idproposta.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["escala_idescala", [fields.escala_idescala.visible && fields.escala_idescala.required ? ew.Validators.required(fields.escala_idescala.caption) : null], fields.escala_idescala.isInvalid],
            ["periodo_idperiodo", [fields.periodo_idperiodo.visible && fields.periodo_idperiodo.required ? ew.Validators.required(fields.periodo_idperiodo.caption) : null], fields.periodo_idperiodo.isInvalid],
            ["tipo_intrajornada_idtipo_intrajornada", [fields.tipo_intrajornada_idtipo_intrajornada.visible && fields.tipo_intrajornada_idtipo_intrajornada.required ? ew.Validators.required(fields.tipo_intrajornada_idtipo_intrajornada.caption) : null], fields.tipo_intrajornada_idtipo_intrajornada.isInvalid],
            ["cargo_idcargo", [fields.cargo_idcargo.visible && fields.cargo_idcargo.required ? ew.Validators.required(fields.cargo_idcargo.caption) : null], fields.cargo_idcargo.isInvalid],
            ["acumulo_funcao", [fields.acumulo_funcao.visible && fields.acumulo_funcao.required ? ew.Validators.required(fields.acumulo_funcao.caption) : null], fields.acumulo_funcao.isInvalid],
            ["quantidade", [fields.quantidade.visible && fields.quantidade.required ? ew.Validators.required(fields.quantidade.caption) : null, ew.Validators.integer], fields.quantidade.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
            ["calculo_idcalculo", [fields.calculo_idcalculo.visible && fields.calculo_idcalculo.required ? ew.Validators.required(fields.calculo_idcalculo.caption) : null], fields.calculo_idcalculo.isInvalid]
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="planilha_custo">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "proposta") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="proposta">
<input type="hidden" name="fk_idproposta" value="<?= HtmlEncode($Page->proposta_idproposta->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
    <div id="r_idplanilha_custo"<?= $Page->idplanilha_custo->rowAttributes() ?>>
        <label id="elh_planilha_custo_idplanilha_custo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idplanilha_custo->caption() ?><?= $Page->idplanilha_custo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idplanilha_custo->cellAttributes() ?>>
<span id="el_planilha_custo_idplanilha_custo">
<span<?= $Page->idplanilha_custo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idplanilha_custo->getDisplayValue($Page->idplanilha_custo->EditValue))) ?>"></span>
<input type="hidden" data-table="planilha_custo" data-field="x_idplanilha_custo" data-hidden="1" name="x_idplanilha_custo" id="x_idplanilha_custo" value="<?= HtmlEncode($Page->idplanilha_custo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
    <div id="r_proposta_idproposta"<?= $Page->proposta_idproposta->rowAttributes() ?>>
        <label id="elh_planilha_custo_proposta_idproposta" for="x_proposta_idproposta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->proposta_idproposta->caption() ?><?= $Page->proposta_idproposta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->proposta_idproposta->cellAttributes() ?>>
<?php if ($Page->proposta_idproposta->getSessionValue() != "") { ?>
<span id="el_planilha_custo_proposta_idproposta">
<span<?= $Page->proposta_idproposta->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->proposta_idproposta->getDisplayValue($Page->proposta_idproposta->ViewValue))) ?>"></span>
<input type="hidden" id="x_proposta_idproposta" name="x_proposta_idproposta" value="<?= HtmlEncode($Page->proposta_idproposta->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_planilha_custo_proposta_idproposta">
<input type="<?= $Page->proposta_idproposta->getInputTextType() ?>" name="x_proposta_idproposta" id="x_proposta_idproposta" data-table="planilha_custo" data-field="x_proposta_idproposta" value="<?= $Page->proposta_idproposta->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->proposta_idproposta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->proposta_idproposta->formatPattern()) ?>"<?= $Page->proposta_idproposta->editAttributes() ?> aria-describedby="x_proposta_idproposta_help">
<?= $Page->proposta_idproposta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->proposta_idproposta->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
    <div id="r_escala_idescala"<?= $Page->escala_idescala->rowAttributes() ?>>
        <label id="elh_planilha_custo_escala_idescala" class="<?= $Page->LeftColumnClass ?>"><?= $Page->escala_idescala->caption() ?><?= $Page->escala_idescala->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="el_planilha_custo_escala_idescala">
<template id="tp_x_escala_idescala">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo" data-field="x_escala_idescala" name="x_escala_idescala" id="x_escala_idescala"<?= $Page->escala_idescala->editAttributes() ?>>
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
    data-table="planilha_custo"
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
        <label id="elh_planilha_custo_periodo_idperiodo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periodo_idperiodo->caption() ?><?= $Page->periodo_idperiodo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="el_planilha_custo_periodo_idperiodo">
<template id="tp_x_periodo_idperiodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo" data-field="x_periodo_idperiodo" name="x_periodo_idperiodo" id="x_periodo_idperiodo"<?= $Page->periodo_idperiodo->editAttributes() ?>>
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
    data-table="planilha_custo"
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
        <label id="elh_planilha_custo_tipo_intrajornada_idtipo_intrajornada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_intrajornada_idtipo_intrajornada->caption() ?><?= $Page->tipo_intrajornada_idtipo_intrajornada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_intrajornada_idtipo_intrajornada->cellAttributes() ?>>
<span id="el_planilha_custo_tipo_intrajornada_idtipo_intrajornada">
<template id="tp_x_tipo_intrajornada_idtipo_intrajornada">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo" data-field="x_tipo_intrajornada_idtipo_intrajornada" name="x_tipo_intrajornada_idtipo_intrajornada" id="x_tipo_intrajornada_idtipo_intrajornada"<?= $Page->tipo_intrajornada_idtipo_intrajornada->editAttributes() ?>>
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
    data-table="planilha_custo"
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
        <label id="elh_planilha_custo_cargo_idcargo" for="x_cargo_idcargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cargo_idcargo->caption() ?><?= $Page->cargo_idcargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cargo_idcargo->cellAttributes() ?>>
<span id="el_planilha_custo_cargo_idcargo">
    <select
        id="x_cargo_idcargo"
        name="x_cargo_idcargo"
        class="form-select ew-select<?= $Page->cargo_idcargo->isInvalidClass() ?>"
        <?php if (!$Page->cargo_idcargo->IsNativeSelect) { ?>
        data-select2-id="fplanilha_custoedit_x_cargo_idcargo"
        <?php } ?>
        data-table="planilha_custo"
        data-field="x_cargo_idcargo"
        data-value-separator="<?= $Page->cargo_idcargo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cargo_idcargo->getPlaceHolder()) ?>"
        <?= $Page->cargo_idcargo->editAttributes() ?>>
        <?= $Page->cargo_idcargo->selectOptionListHtml("x_cargo_idcargo") ?>
    </select>
    <?= $Page->cargo_idcargo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cargo_idcargo->getErrorMessage() ?></div>
<?= $Page->cargo_idcargo->Lookup->getParamTag($Page, "p_x_cargo_idcargo") ?>
<?php if (!$Page->cargo_idcargo->IsNativeSelect) { ?>
<script>
loadjs.ready("fplanilha_custoedit", function() {
    var options = { name: "x_cargo_idcargo", selectId: "fplanilha_custoedit_x_cargo_idcargo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplanilha_custoedit.lists.cargo_idcargo?.lookupOptions.length) {
        options.data = { id: "x_cargo_idcargo", form: "fplanilha_custoedit" };
    } else {
        options.ajax = { id: "x_cargo_idcargo", form: "fplanilha_custoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.planilha_custo.fields.cargo_idcargo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
    <div id="r_acumulo_funcao"<?= $Page->acumulo_funcao->rowAttributes() ?>>
        <label id="elh_planilha_custo_acumulo_funcao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acumulo_funcao->caption() ?><?= $Page->acumulo_funcao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span id="el_planilha_custo_acumulo_funcao">
<template id="tp_x_acumulo_funcao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo" data-field="x_acumulo_funcao" name="x_acumulo_funcao" id="x_acumulo_funcao"<?= $Page->acumulo_funcao->editAttributes() ?>>
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
    data-table="planilha_custo"
    data-field="x_acumulo_funcao"
    data-value-separator="<?= $Page->acumulo_funcao->displayValueSeparatorAttribute() ?>"
    <?= $Page->acumulo_funcao->editAttributes() ?>></selection-list>
<?= $Page->acumulo_funcao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->acumulo_funcao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
    <div id="r_quantidade"<?= $Page->quantidade->rowAttributes() ?>>
        <label id="elh_planilha_custo_quantidade" for="x_quantidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->quantidade->caption() ?><?= $Page->quantidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->quantidade->cellAttributes() ?>>
<span id="el_planilha_custo_quantidade">
<input type="<?= $Page->quantidade->getInputTextType() ?>" name="x_quantidade" id="x_quantidade" data-table="planilha_custo" data-field="x_quantidade" value="<?= $Page->quantidade->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Page->quantidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->quantidade->formatPattern()) ?>"<?= $Page->quantidade->editAttributes() ?> aria-describedby="x_quantidade_help">
<?= $Page->quantidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->quantidade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
    <div id="r_calculo_idcalculo"<?= $Page->calculo_idcalculo->rowAttributes() ?>>
        <label id="elh_planilha_custo_calculo_idcalculo" for="x_calculo_idcalculo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->calculo_idcalculo->caption() ?><?= $Page->calculo_idcalculo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->calculo_idcalculo->cellAttributes() ?>>
<span id="el_planilha_custo_calculo_idcalculo">
<span<?= $Page->calculo_idcalculo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->calculo_idcalculo->getDisplayValue($Page->calculo_idcalculo->EditValue))) ?>"></span>
<input type="hidden" data-table="planilha_custo" data-field="x_calculo_idcalculo" data-hidden="1" name="x_calculo_idcalculo" id="x_calculo_idcalculo" value="<?= HtmlEncode($Page->calculo_idcalculo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("movimento_pla_custo", explode(",", $Page->getCurrentDetailTable())) && $movimento_pla_custo->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("movimento_pla_custo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MovimentoPlaCustoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fplanilha_custoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fplanilha_custoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("planilha_custo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
