<?php

namespace PHPMaker2024\contratos;

// Page object
$ContratoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fcontratoedit" id="fcontratoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contrato: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fcontratoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcontratoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idcontrato", [fields.idcontrato.visible && fields.idcontrato.required ? ew.Validators.required(fields.idcontrato.caption) : null], fields.idcontrato.isInvalid],
            ["cliente_idcliente", [fields.cliente_idcliente.visible && fields.cliente_idcliente.required ? ew.Validators.required(fields.cliente_idcliente.caption) : null], fields.cliente_idcliente.isInvalid],
            ["valor", [fields.valor.visible && fields.valor.required ? ew.Validators.required(fields.valor.caption) : null, ew.Validators.float], fields.valor.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
            ["ativo", [fields.ativo.visible && fields.ativo.required ? ew.Validators.required(fields.ativo.caption) : null], fields.ativo.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
            ["valor_antes", [fields.valor_antes.visible && fields.valor_antes.required ? ew.Validators.required(fields.valor_antes.caption) : null], fields.valor_antes.isInvalid]
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
            "cliente_idcliente": <?= $Page->cliente_idcliente->toClientList($Page) ?>,
            "ativo": <?= $Page->ativo->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="contrato">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idcontrato->Visible) { // idcontrato ?>
    <div id="r_idcontrato"<?= $Page->idcontrato->rowAttributes() ?>>
        <label id="elh_contrato_idcontrato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcontrato->caption() ?><?= $Page->idcontrato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idcontrato->cellAttributes() ?>>
<span id="el_contrato_idcontrato">
<span<?= $Page->idcontrato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idcontrato->getDisplayValue($Page->idcontrato->EditValue))) ?>"></span>
<input type="hidden" data-table="contrato" data-field="x_idcontrato" data-hidden="1" name="x_idcontrato" id="x_idcontrato" value="<?= HtmlEncode($Page->idcontrato->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
    <div id="r_cliente_idcliente"<?= $Page->cliente_idcliente->rowAttributes() ?>>
        <label id="elh_contrato_cliente_idcliente" for="x_cliente_idcliente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cliente_idcliente->caption() ?><?= $Page->cliente_idcliente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cliente_idcliente->cellAttributes() ?>>
<span id="el_contrato_cliente_idcliente">
    <select
        id="x_cliente_idcliente"
        name="x_cliente_idcliente"
        class="form-control ew-select<?= $Page->cliente_idcliente->isInvalidClass() ?>"
        data-select2-id="fcontratoedit_x_cliente_idcliente"
        data-table="contrato"
        data-field="x_cliente_idcliente"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->cliente_idcliente->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->cliente_idcliente->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cliente_idcliente->getPlaceHolder()) ?>"
        <?= $Page->cliente_idcliente->editAttributes() ?>>
        <?= $Page->cliente_idcliente->selectOptionListHtml("x_cliente_idcliente") ?>
    </select>
    <?= $Page->cliente_idcliente->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cliente_idcliente->getErrorMessage() ?></div>
<?= $Page->cliente_idcliente->Lookup->getParamTag($Page, "p_x_cliente_idcliente") ?>
<script>
loadjs.ready("fcontratoedit", function() {
    var options = { name: "x_cliente_idcliente", selectId: "fcontratoedit_x_cliente_idcliente" };
    if (fcontratoedit.lists.cliente_idcliente?.lookupOptions.length) {
        options.data = { id: "x_cliente_idcliente", form: "fcontratoedit" };
    } else {
        options.ajax = { id: "x_cliente_idcliente", form: "fcontratoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.contrato.fields.cliente_idcliente.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
    <div id="r_valor"<?= $Page->valor->rowAttributes() ?>>
        <label id="elh_contrato_valor" for="x_valor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valor->caption() ?><?= $Page->valor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valor->cellAttributes() ?>>
<span id="el_contrato_valor">
<input type="<?= $Page->valor->getInputTextType() ?>" name="x_valor" id="x_valor" data-table="contrato" data-field="x_valor" value="<?= $Page->valor->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valor->formatPattern()) ?>"<?= $Page->valor->editAttributes() ?> aria-describedby="x_valor_help">
<?= $Page->valor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_contrato_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_contrato_obs">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="contrato" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="50" maxlength="120" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help">
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <div id="r_ativo"<?= $Page->ativo->rowAttributes() ?>>
        <label id="elh_contrato_ativo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ativo->caption() ?><?= $Page->ativo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ativo->cellAttributes() ?>>
<span id="el_contrato_ativo">
<template id="tp_x_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contrato" data-field="x_ativo" name="x_ativo" id="x_ativo"<?= $Page->ativo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_ativo" class="ew-item-list"></div>
<selection-list hidden
    id="x_ativo"
    name="x_ativo"
    value="<?= HtmlEncode($Page->ativo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ativo"
    data-target="dsl_x_ativo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ativo->isInvalidClass() ?>"
    data-table="contrato"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<?= $Page->ativo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valor_antes->Visible) { // valor_antes ?>
    <div id="r_valor_antes"<?= $Page->valor_antes->rowAttributes() ?>>
        <label id="elh_contrato_valor_antes" for="x_valor_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valor_antes->caption() ?><?= $Page->valor_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valor_antes->cellAttributes() ?>>
<span id="el_contrato_valor_antes">
<span<?= $Page->valor_antes->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->valor_antes->getDisplayValue($Page->valor_antes->EditValue))) ?>"></span>
<input type="hidden" data-table="contrato" data-field="x_valor_antes" data-hidden="1" name="x_valor_antes" id="x_valor_antes" value="<?= HtmlEncode($Page->valor_antes->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("planilha_custo_contrato", explode(",", $Page->getCurrentDetailTable())) && $planilha_custo_contrato->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("planilha_custo_contrato", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PlanilhaCustoContratoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("mov_insumo_contrato", explode(",", $Page->getCurrentDetailTable())) && $mov_insumo_contrato->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("mov_insumo_contrato", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MovInsumoContratoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcontratoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcontratoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("contrato");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
