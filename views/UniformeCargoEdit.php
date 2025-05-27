<?php

namespace PHPMaker2024\contratos;

// Page object
$UniformeCargoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="funiforme_cargoedit" id="funiforme_cargoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { uniforme_cargo: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var funiforme_cargoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("funiforme_cargoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["iduniforme_cargo", [fields.iduniforme_cargo.visible && fields.iduniforme_cargo.required ? ew.Validators.required(fields.iduniforme_cargo.caption) : null], fields.iduniforme_cargo.isInvalid],
            ["uniforme_iduniforme", [fields.uniforme_iduniforme.visible && fields.uniforme_iduniforme.required ? ew.Validators.required(fields.uniforme_iduniforme.caption) : null], fields.uniforme_iduniforme.isInvalid],
            ["tipo_uniforme_idtipo_uniforme", [fields.tipo_uniforme_idtipo_uniforme.visible && fields.tipo_uniforme_idtipo_uniforme.required ? ew.Validators.required(fields.tipo_uniforme_idtipo_uniforme.caption) : null], fields.tipo_uniforme_idtipo_uniforme.isInvalid]
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
            "uniforme_iduniforme": <?= $Page->uniforme_iduniforme->toClientList($Page) ?>,
            "tipo_uniforme_idtipo_uniforme": <?= $Page->tipo_uniforme_idtipo_uniforme->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="uniforme_cargo">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "tipo_uniforme") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="tipo_uniforme">
<input type="hidden" name="fk_idtipo_uniforme" value="<?= HtmlEncode($Page->tipo_uniforme_idtipo_uniforme->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->iduniforme_cargo->Visible) { // iduniforme_cargo ?>
    <div id="r_iduniforme_cargo"<?= $Page->iduniforme_cargo->rowAttributes() ?>>
        <label id="elh_uniforme_cargo_iduniforme_cargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->iduniforme_cargo->caption() ?><?= $Page->iduniforme_cargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->iduniforme_cargo->cellAttributes() ?>>
<span id="el_uniforme_cargo_iduniforme_cargo">
<span<?= $Page->iduniforme_cargo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iduniforme_cargo->getDisplayValue($Page->iduniforme_cargo->EditValue))) ?>"></span>
<input type="hidden" data-table="uniforme_cargo" data-field="x_iduniforme_cargo" data-hidden="1" name="x_iduniforme_cargo" id="x_iduniforme_cargo" value="<?= HtmlEncode($Page->iduniforme_cargo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uniforme_iduniforme->Visible) { // uniforme_iduniforme ?>
    <div id="r_uniforme_iduniforme"<?= $Page->uniforme_iduniforme->rowAttributes() ?>>
        <label id="elh_uniforme_cargo_uniforme_iduniforme" for="x_uniforme_iduniforme" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uniforme_iduniforme->caption() ?><?= $Page->uniforme_iduniforme->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uniforme_iduniforme->cellAttributes() ?>>
<span id="el_uniforme_cargo_uniforme_iduniforme">
    <select
        id="x_uniforme_iduniforme"
        name="x_uniforme_iduniforme"
        class="form-control ew-select<?= $Page->uniforme_iduniforme->isInvalidClass() ?>"
        data-select2-id="funiforme_cargoedit_x_uniforme_iduniforme"
        data-table="uniforme_cargo"
        data-field="x_uniforme_iduniforme"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->uniforme_iduniforme->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->uniforme_iduniforme->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->uniforme_iduniforme->getPlaceHolder()) ?>"
        <?= $Page->uniforme_iduniforme->editAttributes() ?>>
        <?= $Page->uniforme_iduniforme->selectOptionListHtml("x_uniforme_iduniforme") ?>
    </select>
    <?= $Page->uniforme_iduniforme->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->uniforme_iduniforme->getErrorMessage() ?></div>
<?= $Page->uniforme_iduniforme->Lookup->getParamTag($Page, "p_x_uniforme_iduniforme") ?>
<script>
loadjs.ready("funiforme_cargoedit", function() {
    var options = { name: "x_uniforme_iduniforme", selectId: "funiforme_cargoedit_x_uniforme_iduniforme" };
    if (funiforme_cargoedit.lists.uniforme_iduniforme?.lookupOptions.length) {
        options.data = { id: "x_uniforme_iduniforme", form: "funiforme_cargoedit" };
    } else {
        options.ajax = { id: "x_uniforme_iduniforme", form: "funiforme_cargoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.uniforme_cargo.fields.uniforme_iduniforme.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
    <div id="r_tipo_uniforme_idtipo_uniforme"<?= $Page->tipo_uniforme_idtipo_uniforme->rowAttributes() ?>>
        <label id="elh_uniforme_cargo_tipo_uniforme_idtipo_uniforme" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_uniforme_idtipo_uniforme->caption() ?><?= $Page->tipo_uniforme_idtipo_uniforme->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_uniforme_idtipo_uniforme->cellAttributes() ?>>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->getSessionValue() != "") { ?>
<span id="el_uniforme_cargo_tipo_uniforme_idtipo_uniforme">
<span<?= $Page->tipo_uniforme_idtipo_uniforme->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->tipo_uniforme_idtipo_uniforme->getDisplayValue($Page->tipo_uniforme_idtipo_uniforme->ViewValue) ?></span></span>
<input type="hidden" id="x_tipo_uniforme_idtipo_uniforme" name="x_tipo_uniforme_idtipo_uniforme" value="<?= HtmlEncode($Page->tipo_uniforme_idtipo_uniforme->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_uniforme_cargo_tipo_uniforme_idtipo_uniforme">
<template id="tp_x_tipo_uniforme_idtipo_uniforme">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="uniforme_cargo" data-field="x_tipo_uniforme_idtipo_uniforme" name="x_tipo_uniforme_idtipo_uniforme" id="x_tipo_uniforme_idtipo_uniforme"<?= $Page->tipo_uniforme_idtipo_uniforme->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo_uniforme_idtipo_uniforme" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo_uniforme_idtipo_uniforme"
    name="x_tipo_uniforme_idtipo_uniforme"
    value="<?= HtmlEncode($Page->tipo_uniforme_idtipo_uniforme->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_uniforme_idtipo_uniforme"
    data-target="dsl_x_tipo_uniforme_idtipo_uniforme"
    data-repeatcolumn="10"
    class="form-control<?= $Page->tipo_uniforme_idtipo_uniforme->isInvalidClass() ?>"
    data-table="uniforme_cargo"
    data-field="x_tipo_uniforme_idtipo_uniforme"
    data-value-separator="<?= $Page->tipo_uniforme_idtipo_uniforme->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_uniforme_idtipo_uniforme->editAttributes() ?>></selection-list>
<?= $Page->tipo_uniforme_idtipo_uniforme->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_uniforme_idtipo_uniforme->getErrorMessage() ?></div>
<?= $Page->tipo_uniforme_idtipo_uniforme->Lookup->getParamTag($Page, "p_x_tipo_uniforme_idtipo_uniforme") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="funiforme_cargoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="funiforme_cargoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("uniforme_cargo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
