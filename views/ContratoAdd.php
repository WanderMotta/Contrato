<?php

namespace PHPMaker2024\contratos;

// Page object
$ContratoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contrato: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fcontratoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcontratoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["cliente_idcliente", [fields.cliente_idcliente.visible && fields.cliente_idcliente.required ? ew.Validators.required(fields.cliente_idcliente.caption) : null], fields.cliente_idcliente.isInvalid],
            ["valor", [fields.valor.visible && fields.valor.required ? ew.Validators.required(fields.valor.caption) : null, ew.Validators.float], fields.valor.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["ativo", [fields.ativo.visible && fields.ativo.required ? ew.Validators.required(fields.ativo.caption) : null], fields.ativo.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcontratoadd" id="fcontratoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="contrato">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
    <div id="r_cliente_idcliente"<?= $Page->cliente_idcliente->rowAttributes() ?>>
        <label id="elh_contrato_cliente_idcliente" for="x_cliente_idcliente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cliente_idcliente->caption() ?><?= $Page->cliente_idcliente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cliente_idcliente->cellAttributes() ?>>
<span id="el_contrato_cliente_idcliente">
    <select
        id="x_cliente_idcliente"
        name="x_cliente_idcliente"
        class="form-control ew-select<?= $Page->cliente_idcliente->isInvalidClass() ?>"
        data-select2-id="fcontratoadd_x_cliente_idcliente"
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
loadjs.ready("fcontratoadd", function() {
    var options = { name: "x_cliente_idcliente", selectId: "fcontratoadd_x_cliente_idcliente" };
    if (fcontratoadd.lists.cliente_idcliente?.lookupOptions.length) {
        options.data = { id: "x_cliente_idcliente", form: "fcontratoadd" };
    } else {
        options.ajax = { id: "x_cliente_idcliente", form: "fcontratoadd", limit: ew.LOOKUP_PAGE_SIZE };
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
</div><!-- /page* -->
<?php
    if (in_array("planilha_custo_contrato", explode(",", $Page->getCurrentDetailTable())) && $planilha_custo_contrato->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("planilha_custo_contrato", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PlanilhaCustoContratoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("mov_insumo_contrato", explode(",", $Page->getCurrentDetailTable())) && $mov_insumo_contrato->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("mov_insumo_contrato", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MovInsumoContratoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcontratoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcontratoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("contrato");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
