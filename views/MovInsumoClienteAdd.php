<?php

namespace PHPMaker2024\contratos;

// Page object
$MovInsumoClienteAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mov_insumo_cliente: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fmov_insumo_clienteadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmov_insumo_clienteadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["tipo_insumo_idtipo_insumo", [fields.tipo_insumo_idtipo_insumo.visible && fields.tipo_insumo_idtipo_insumo.required ? ew.Validators.required(fields.tipo_insumo_idtipo_insumo.caption) : null], fields.tipo_insumo_idtipo_insumo.isInvalid],
            ["insumo_idinsumo", [fields.insumo_idinsumo.visible && fields.insumo_idinsumo.required ? ew.Validators.required(fields.insumo_idinsumo.caption) : null], fields.insumo_idinsumo.isInvalid],
            ["qtde", [fields.qtde.visible && fields.qtde.required ? ew.Validators.required(fields.qtde.caption) : null, ew.Validators.float], fields.qtde.isInvalid],
            ["frequencia", [fields.frequencia.visible && fields.frequencia.required ? ew.Validators.required(fields.frequencia.caption) : null], fields.frequencia.isInvalid],
            ["proposta_idproposta", [fields.proposta_idproposta.visible && fields.proposta_idproposta.required ? ew.Validators.required(fields.proposta_idproposta.caption) : null, ew.Validators.integer], fields.proposta_idproposta.isInvalid]
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
            "tipo_insumo_idtipo_insumo": <?= $Page->tipo_insumo_idtipo_insumo->toClientList($Page) ?>,
            "insumo_idinsumo": <?= $Page->insumo_idinsumo->toClientList($Page) ?>,
            "frequencia": <?= $Page->frequencia->toClientList($Page) ?>,
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
<form name="fmov_insumo_clienteadd" id="fmov_insumo_clienteadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mov_insumo_cliente">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "proposta") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="proposta">
<input type="hidden" name="fk_idproposta" value="<?= HtmlEncode($Page->proposta_idproposta->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
    <div id="r_tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->rowAttributes() ?>>
        <label id="elh_mov_insumo_cliente_tipo_insumo_idtipo_insumo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_insumo_idtipo_insumo->caption() ?><?= $Page->tipo_insumo_idtipo_insumo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_tipo_insumo_idtipo_insumo">
<template id="tp_x_tipo_insumo_idtipo_insumo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="mov_insumo_cliente" data-field="x_tipo_insumo_idtipo_insumo" name="x_tipo_insumo_idtipo_insumo" id="x_tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo_insumo_idtipo_insumo" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo_insumo_idtipo_insumo"
    name="x_tipo_insumo_idtipo_insumo"
    value="<?= HtmlEncode($Page->tipo_insumo_idtipo_insumo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_insumo_idtipo_insumo"
    data-target="dsl_x_tipo_insumo_idtipo_insumo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_insumo_idtipo_insumo->isInvalidClass() ?>"
    data-table="mov_insumo_cliente"
    data-field="x_tipo_insumo_idtipo_insumo"
    data-value-separator="<?= $Page->tipo_insumo_idtipo_insumo->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Page->tipo_insumo_idtipo_insumo->editAttributes() ?>></selection-list>
<?= $Page->tipo_insumo_idtipo_insumo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_insumo_idtipo_insumo->getErrorMessage() ?></div>
<?= $Page->tipo_insumo_idtipo_insumo->Lookup->getParamTag($Page, "p_x_tipo_insumo_idtipo_insumo") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
    <div id="r_insumo_idinsumo"<?= $Page->insumo_idinsumo->rowAttributes() ?>>
        <label id="elh_mov_insumo_cliente_insumo_idinsumo" for="x_insumo_idinsumo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->insumo_idinsumo->caption() ?><?= $Page->insumo_idinsumo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->insumo_idinsumo->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_insumo_idinsumo">
    <select
        id="x_insumo_idinsumo"
        name="x_insumo_idinsumo"
        class="form-control ew-select<?= $Page->insumo_idinsumo->isInvalidClass() ?>"
        data-select2-id="fmov_insumo_clienteadd_x_insumo_idinsumo"
        data-table="mov_insumo_cliente"
        data-field="x_insumo_idinsumo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->insumo_idinsumo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->insumo_idinsumo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->insumo_idinsumo->getPlaceHolder()) ?>"
        <?= $Page->insumo_idinsumo->editAttributes() ?>>
        <?= $Page->insumo_idinsumo->selectOptionListHtml("x_insumo_idinsumo") ?>
    </select>
    <?= $Page->insumo_idinsumo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->insumo_idinsumo->getErrorMessage() ?></div>
<?= $Page->insumo_idinsumo->Lookup->getParamTag($Page, "p_x_insumo_idinsumo") ?>
<script>
loadjs.ready("fmov_insumo_clienteadd", function() {
    var options = { name: "x_insumo_idinsumo", selectId: "fmov_insumo_clienteadd_x_insumo_idinsumo" };
    if (fmov_insumo_clienteadd.lists.insumo_idinsumo?.lookupOptions.length) {
        options.data = { id: "x_insumo_idinsumo", form: "fmov_insumo_clienteadd" };
    } else {
        options.ajax = { id: "x_insumo_idinsumo", form: "fmov_insumo_clienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.mov_insumo_cliente.fields.insumo_idinsumo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
    <div id="r_qtde"<?= $Page->qtde->rowAttributes() ?>>
        <label id="elh_mov_insumo_cliente_qtde" for="x_qtde" class="<?= $Page->LeftColumnClass ?>"><?= $Page->qtde->caption() ?><?= $Page->qtde->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->qtde->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_qtde">
<input type="<?= $Page->qtde->getInputTextType() ?>" name="x_qtde" id="x_qtde" data-table="mov_insumo_cliente" data-field="x_qtde" value="<?= $Page->qtde->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Page->qtde->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->qtde->formatPattern()) ?>"<?= $Page->qtde->editAttributes() ?> aria-describedby="x_qtde_help">
<?= $Page->qtde->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->qtde->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
    <div id="r_frequencia"<?= $Page->frequencia->rowAttributes() ?>>
        <label id="elh_mov_insumo_cliente_frequencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->frequencia->caption() ?><?= $Page->frequencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->frequencia->cellAttributes() ?>>
<span id="el_mov_insumo_cliente_frequencia">
<template id="tp_x_frequencia">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="mov_insumo_cliente" data-field="x_frequencia" name="x_frequencia" id="x_frequencia"<?= $Page->frequencia->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_frequencia" class="ew-item-list"></div>
<selection-list hidden
    id="x_frequencia"
    name="x_frequencia"
    value="<?= HtmlEncode($Page->frequencia->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_frequencia"
    data-target="dsl_x_frequencia"
    data-repeatcolumn="6"
    class="form-control<?= $Page->frequencia->isInvalidClass() ?>"
    data-table="mov_insumo_cliente"
    data-field="x_frequencia"
    data-value-separator="<?= $Page->frequencia->displayValueSeparatorAttribute() ?>"
    <?= $Page->frequencia->editAttributes() ?>></selection-list>
<?= $Page->frequencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->frequencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
    <div id="r_proposta_idproposta"<?= $Page->proposta_idproposta->rowAttributes() ?>>
        <label id="elh_mov_insumo_cliente_proposta_idproposta" for="x_proposta_idproposta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->proposta_idproposta->caption() ?><?= $Page->proposta_idproposta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->proposta_idproposta->cellAttributes() ?>>
<?php if ($Page->proposta_idproposta->getSessionValue() != "") { ?>
<span id="el_mov_insumo_cliente_proposta_idproposta">
<span<?= $Page->proposta_idproposta->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->proposta_idproposta->getDisplayValue($Page->proposta_idproposta->ViewValue))) ?>"></span>
<input type="hidden" id="x_proposta_idproposta" name="x_proposta_idproposta" value="<?= HtmlEncode($Page->proposta_idproposta->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_mov_insumo_cliente_proposta_idproposta">
<input type="<?= $Page->proposta_idproposta->getInputTextType() ?>" name="x_proposta_idproposta" id="x_proposta_idproposta" data-table="mov_insumo_cliente" data-field="x_proposta_idproposta" value="<?= $Page->proposta_idproposta->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->proposta_idproposta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->proposta_idproposta->formatPattern()) ?>"<?= $Page->proposta_idproposta->editAttributes() ?> aria-describedby="x_proposta_idproposta_help">
<?= $Page->proposta_idproposta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->proposta_idproposta->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fmov_insumo_clienteadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fmov_insumo_clienteadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("mov_insumo_cliente");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
