<?php

namespace PHPMaker2024\contratos;

// Page object
$ItensModuloAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { itens_modulo: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fitens_moduloadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fitens_moduloadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["modulo_idmodulo", [fields.modulo_idmodulo.visible && fields.modulo_idmodulo.required ? ew.Validators.required(fields.modulo_idmodulo.caption) : null], fields.modulo_idmodulo.isInvalid],
            ["item", [fields.item.visible && fields.item.required ? ew.Validators.required(fields.item.caption) : null], fields.item.isInvalid],
            ["porcentagem_valor", [fields.porcentagem_valor.visible && fields.porcentagem_valor.required ? ew.Validators.required(fields.porcentagem_valor.caption) : null, ew.Validators.float], fields.porcentagem_valor.isInvalid],
            ["incidencia_inss", [fields.incidencia_inss.visible && fields.incidencia_inss.required ? ew.Validators.required(fields.incidencia_inss.caption) : null], fields.incidencia_inss.isInvalid]
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
            "modulo_idmodulo": <?= $Page->modulo_idmodulo->toClientList($Page) ?>,
            "incidencia_inss": <?= $Page->incidencia_inss->toClientList($Page) ?>,
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
<form name="fitens_moduloadd" id="fitens_moduloadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="itens_modulo">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "modulo") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="modulo">
<input type="hidden" name="fk_idmodulo" value="<?= HtmlEncode($Page->modulo_idmodulo->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
    <div id="r_modulo_idmodulo"<?= $Page->modulo_idmodulo->rowAttributes() ?>>
        <label id="elh_itens_modulo_modulo_idmodulo" for="x_modulo_idmodulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo_idmodulo->caption() ?><?= $Page->modulo_idmodulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<?php if ($Page->modulo_idmodulo->getSessionValue() != "") { ?>
<span id="el_itens_modulo_modulo_idmodulo">
<span<?= $Page->modulo_idmodulo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->modulo_idmodulo->getDisplayValue($Page->modulo_idmodulo->ViewValue) ?></span></span>
<input type="hidden" id="x_modulo_idmodulo" name="x_modulo_idmodulo" value="<?= HtmlEncode($Page->modulo_idmodulo->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_itens_modulo_modulo_idmodulo">
    <select
        id="x_modulo_idmodulo"
        name="x_modulo_idmodulo"
        class="form-select ew-select<?= $Page->modulo_idmodulo->isInvalidClass() ?>"
        <?php if (!$Page->modulo_idmodulo->IsNativeSelect) { ?>
        data-select2-id="fitens_moduloadd_x_modulo_idmodulo"
        <?php } ?>
        data-table="itens_modulo"
        data-field="x_modulo_idmodulo"
        data-value-separator="<?= $Page->modulo_idmodulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->modulo_idmodulo->getPlaceHolder()) ?>"
        <?= $Page->modulo_idmodulo->editAttributes() ?>>
        <?= $Page->modulo_idmodulo->selectOptionListHtml("x_modulo_idmodulo") ?>
    </select>
    <?= $Page->modulo_idmodulo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->modulo_idmodulo->getErrorMessage() ?></div>
<?= $Page->modulo_idmodulo->Lookup->getParamTag($Page, "p_x_modulo_idmodulo") ?>
<?php if (!$Page->modulo_idmodulo->IsNativeSelect) { ?>
<script>
loadjs.ready("fitens_moduloadd", function() {
    var options = { name: "x_modulo_idmodulo", selectId: "fitens_moduloadd_x_modulo_idmodulo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fitens_moduloadd.lists.modulo_idmodulo?.lookupOptions.length) {
        options.data = { id: "x_modulo_idmodulo", form: "fitens_moduloadd" };
    } else {
        options.ajax = { id: "x_modulo_idmodulo", form: "fitens_moduloadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.itens_modulo.fields.modulo_idmodulo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->item->Visible) { // item ?>
    <div id="r_item"<?= $Page->item->rowAttributes() ?>>
        <label id="elh_itens_modulo_item" for="x_item" class="<?= $Page->LeftColumnClass ?>"><?= $Page->item->caption() ?><?= $Page->item->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->item->cellAttributes() ?>>
<span id="el_itens_modulo_item">
<input type="<?= $Page->item->getInputTextType() ?>" name="x_item" id="x_item" data-table="itens_modulo" data-field="x_item" value="<?= $Page->item->EditValue ?>" size="50" maxlength="155" placeholder="<?= HtmlEncode($Page->item->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->item->formatPattern()) ?>"<?= $Page->item->editAttributes() ?> aria-describedby="x_item_help">
<?= $Page->item->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->item->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->porcentagem_valor->Visible) { // porcentagem_valor ?>
    <div id="r_porcentagem_valor"<?= $Page->porcentagem_valor->rowAttributes() ?>>
        <label id="elh_itens_modulo_porcentagem_valor" for="x_porcentagem_valor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->porcentagem_valor->caption() ?><?= $Page->porcentagem_valor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->porcentagem_valor->cellAttributes() ?>>
<span id="el_itens_modulo_porcentagem_valor">
<input type="<?= $Page->porcentagem_valor->getInputTextType() ?>" name="x_porcentagem_valor" id="x_porcentagem_valor" data-table="itens_modulo" data-field="x_porcentagem_valor" value="<?= $Page->porcentagem_valor->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Page->porcentagem_valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porcentagem_valor->formatPattern()) ?>"<?= $Page->porcentagem_valor->editAttributes() ?> aria-describedby="x_porcentagem_valor_help">
<?= $Page->porcentagem_valor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->porcentagem_valor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->incidencia_inss->Visible) { // incidencia_inss ?>
    <div id="r_incidencia_inss"<?= $Page->incidencia_inss->rowAttributes() ?>>
        <label id="elh_itens_modulo_incidencia_inss" class="<?= $Page->LeftColumnClass ?>"><?= $Page->incidencia_inss->caption() ?><?= $Page->incidencia_inss->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->incidencia_inss->cellAttributes() ?>>
<span id="el_itens_modulo_incidencia_inss">
<template id="tp_x_incidencia_inss">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="itens_modulo" data-field="x_incidencia_inss" name="x_incidencia_inss" id="x_incidencia_inss"<?= $Page->incidencia_inss->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_incidencia_inss" class="ew-item-list"></div>
<selection-list hidden
    id="x_incidencia_inss"
    name="x_incidencia_inss"
    value="<?= HtmlEncode($Page->incidencia_inss->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_incidencia_inss"
    data-target="dsl_x_incidencia_inss"
    data-repeatcolumn="5"
    class="form-control<?= $Page->incidencia_inss->isInvalidClass() ?>"
    data-table="itens_modulo"
    data-field="x_incidencia_inss"
    data-value-separator="<?= $Page->incidencia_inss->displayValueSeparatorAttribute() ?>"
    <?= $Page->incidencia_inss->editAttributes() ?>></selection-list>
<?= $Page->incidencia_inss->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->incidencia_inss->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fitens_moduloadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fitens_moduloadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("itens_modulo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
