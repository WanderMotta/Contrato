<?php

namespace PHPMaker2024\contratos;

// Page object
$UniformeEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="funiformeedit" id="funiformeedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { uniforme: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var funiformeedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("funiformeedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["iduniforme", [fields.iduniforme.visible && fields.iduniforme.required ? ew.Validators.required(fields.iduniforme.caption) : null], fields.iduniforme.isInvalid],
            ["uniforme", [fields.uniforme.visible && fields.uniforme.required ? ew.Validators.required(fields.uniforme.caption) : null], fields.uniforme.isInvalid],
            ["qtde", [fields.qtde.visible && fields.qtde.required ? ew.Validators.required(fields.qtde.caption) : null, ew.Validators.integer], fields.qtde.isInvalid],
            ["periodo_troca", [fields.periodo_troca.visible && fields.periodo_troca.required ? ew.Validators.required(fields.periodo_troca.caption) : null], fields.periodo_troca.isInvalid],
            ["vr_unitario", [fields.vr_unitario.visible && fields.vr_unitario.required ? ew.Validators.required(fields.vr_unitario.caption) : null, ew.Validators.float], fields.vr_unitario.isInvalid],
            ["vr_total", [fields.vr_total.visible && fields.vr_total.required ? ew.Validators.required(fields.vr_total.caption) : null, ew.Validators.float], fields.vr_total.isInvalid]
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
            "periodo_troca": <?= $Page->periodo_troca->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="uniforme">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->iduniforme->Visible) { // iduniforme ?>
    <div id="r_iduniforme"<?= $Page->iduniforme->rowAttributes() ?>>
        <label id="elh_uniforme_iduniforme" class="<?= $Page->LeftColumnClass ?>"><?= $Page->iduniforme->caption() ?><?= $Page->iduniforme->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->iduniforme->cellAttributes() ?>>
<span id="el_uniforme_iduniforme">
<span<?= $Page->iduniforme->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iduniforme->getDisplayValue($Page->iduniforme->EditValue))) ?>"></span>
<input type="hidden" data-table="uniforme" data-field="x_iduniforme" data-hidden="1" name="x_iduniforme" id="x_iduniforme" value="<?= HtmlEncode($Page->iduniforme->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uniforme->Visible) { // uniforme ?>
    <div id="r_uniforme"<?= $Page->uniforme->rowAttributes() ?>>
        <label id="elh_uniforme_uniforme" for="x_uniforme" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uniforme->caption() ?><?= $Page->uniforme->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uniforme->cellAttributes() ?>>
<span id="el_uniforme_uniforme">
<input type="<?= $Page->uniforme->getInputTextType() ?>" name="x_uniforme" id="x_uniforme" data-table="uniforme" data-field="x_uniforme" value="<?= $Page->uniforme->EditValue ?>" size="50" maxlength="150" placeholder="<?= HtmlEncode($Page->uniforme->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->uniforme->formatPattern()) ?>"<?= $Page->uniforme->editAttributes() ?> aria-describedby="x_uniforme_help">
<?= $Page->uniforme->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uniforme->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
    <div id="r_qtde"<?= $Page->qtde->rowAttributes() ?>>
        <label id="elh_uniforme_qtde" for="x_qtde" class="<?= $Page->LeftColumnClass ?>"><?= $Page->qtde->caption() ?><?= $Page->qtde->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->qtde->cellAttributes() ?>>
<span id="el_uniforme_qtde">
<input type="<?= $Page->qtde->getInputTextType() ?>" name="x_qtde" id="x_qtde" data-table="uniforme" data-field="x_qtde" value="<?= $Page->qtde->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Page->qtde->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->qtde->formatPattern()) ?>"<?= $Page->qtde->editAttributes() ?> aria-describedby="x_qtde_help">
<?= $Page->qtde->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->qtde->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->periodo_troca->Visible) { // periodo_troca ?>
    <div id="r_periodo_troca"<?= $Page->periodo_troca->rowAttributes() ?>>
        <label id="elh_uniforme_periodo_troca" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periodo_troca->caption() ?><?= $Page->periodo_troca->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periodo_troca->cellAttributes() ?>>
<span id="el_uniforme_periodo_troca">
<template id="tp_x_periodo_troca">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="uniforme" data-field="x_periodo_troca" name="x_periodo_troca" id="x_periodo_troca"<?= $Page->periodo_troca->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_periodo_troca" class="ew-item-list"></div>
<selection-list hidden
    id="x_periodo_troca"
    name="x_periodo_troca"
    value="<?= HtmlEncode($Page->periodo_troca->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_periodo_troca"
    data-target="dsl_x_periodo_troca"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodo_troca->isInvalidClass() ?>"
    data-table="uniforme"
    data-field="x_periodo_troca"
    data-value-separator="<?= $Page->periodo_troca->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodo_troca->editAttributes() ?>></selection-list>
<?= $Page->periodo_troca->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->periodo_troca->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { // vr_unitario ?>
    <div id="r_vr_unitario"<?= $Page->vr_unitario->rowAttributes() ?>>
        <label id="elh_uniforme_vr_unitario" for="x_vr_unitario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vr_unitario->caption() ?><?= $Page->vr_unitario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vr_unitario->cellAttributes() ?>>
<span id="el_uniforme_vr_unitario">
<input type="<?= $Page->vr_unitario->getInputTextType() ?>" name="x_vr_unitario" id="x_vr_unitario" data-table="uniforme" data-field="x_vr_unitario" value="<?= $Page->vr_unitario->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->vr_unitario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_unitario->formatPattern()) ?>"<?= $Page->vr_unitario->editAttributes() ?> aria-describedby="x_vr_unitario_help">
<?= $Page->vr_unitario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vr_unitario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vr_total->Visible) { // vr_total ?>
    <div id="r_vr_total"<?= $Page->vr_total->rowAttributes() ?>>
        <label id="elh_uniforme_vr_total" for="x_vr_total" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vr_total->caption() ?><?= $Page->vr_total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vr_total->cellAttributes() ?>>
<span id="el_uniforme_vr_total">
<input type="<?= $Page->vr_total->getInputTextType() ?>" name="x_vr_total" id="x_vr_total" data-table="uniforme" data-field="x_vr_total" value="<?= $Page->vr_total->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->vr_total->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_total->formatPattern()) ?>"<?= $Page->vr_total->editAttributes() ?> aria-describedby="x_vr_total_help">
<?= $Page->vr_total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vr_total->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="funiformeedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="funiformeedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("uniforme");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
