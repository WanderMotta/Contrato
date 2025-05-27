<?php

namespace PHPMaker2024\contratos;

// Page object
$InsumoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { insumo: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var finsumoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("finsumoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["insumo", [fields.insumo.visible && fields.insumo.required ? ew.Validators.required(fields.insumo.caption) : null], fields.insumo.isInvalid],
            ["tipo_insumo_idtipo_insumo", [fields.tipo_insumo_idtipo_insumo.visible && fields.tipo_insumo_idtipo_insumo.required ? ew.Validators.required(fields.tipo_insumo_idtipo_insumo.caption) : null], fields.tipo_insumo_idtipo_insumo.isInvalid],
            ["vr_unitario", [fields.vr_unitario.visible && fields.vr_unitario.required ? ew.Validators.required(fields.vr_unitario.caption) : null, ew.Validators.float], fields.vr_unitario.isInvalid]
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
<form name="finsumoadd" id="finsumoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="insumo">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->insumo->Visible) { // insumo ?>
    <div id="r_insumo"<?= $Page->insumo->rowAttributes() ?>>
        <label id="elh_insumo_insumo" for="x_insumo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->insumo->caption() ?><?= $Page->insumo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->insumo->cellAttributes() ?>>
<span id="el_insumo_insumo">
<input type="<?= $Page->insumo->getInputTextType() ?>" name="x_insumo" id="x_insumo" data-table="insumo" data-field="x_insumo" value="<?= $Page->insumo->EditValue ?>" size="50" maxlength="150" placeholder="<?= HtmlEncode($Page->insumo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->insumo->formatPattern()) ?>"<?= $Page->insumo->editAttributes() ?> aria-describedby="x_insumo_help">
<?= $Page->insumo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->insumo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
    <div id="r_tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->rowAttributes() ?>>
        <label id="elh_insumo_tipo_insumo_idtipo_insumo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_insumo_idtipo_insumo->caption() ?><?= $Page->tipo_insumo_idtipo_insumo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<span id="el_insumo_tipo_insumo_idtipo_insumo">
<template id="tp_x_tipo_insumo_idtipo_insumo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="insumo" data-field="x_tipo_insumo_idtipo_insumo" name="x_tipo_insumo_idtipo_insumo" id="x_tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->editAttributes() ?>>
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
    data-table="insumo"
    data-field="x_tipo_insumo_idtipo_insumo"
    data-value-separator="<?= $Page->tipo_insumo_idtipo_insumo->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_insumo_idtipo_insumo->editAttributes() ?>></selection-list>
<?= $Page->tipo_insumo_idtipo_insumo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_insumo_idtipo_insumo->getErrorMessage() ?></div>
<?= $Page->tipo_insumo_idtipo_insumo->Lookup->getParamTag($Page, "p_x_tipo_insumo_idtipo_insumo") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { // vr_unitario ?>
    <div id="r_vr_unitario"<?= $Page->vr_unitario->rowAttributes() ?>>
        <label id="elh_insumo_vr_unitario" for="x_vr_unitario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vr_unitario->caption() ?><?= $Page->vr_unitario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vr_unitario->cellAttributes() ?>>
<span id="el_insumo_vr_unitario">
<input type="<?= $Page->vr_unitario->getInputTextType() ?>" name="x_vr_unitario" id="x_vr_unitario" data-table="insumo" data-field="x_vr_unitario" value="<?= $Page->vr_unitario->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->vr_unitario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_unitario->formatPattern()) ?>"<?= $Page->vr_unitario->editAttributes() ?> aria-describedby="x_vr_unitario_help">
<?= $Page->vr_unitario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vr_unitario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="finsumoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="finsumoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("insumo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
