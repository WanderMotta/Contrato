<?php

namespace PHPMaker2024\contratos;

// Page object
$DissidioEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fdissidioedit" id="fdissidioedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dissidio: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fdissidioedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdissidioedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idcargo", [fields.idcargo.visible && fields.idcargo.required ? ew.Validators.required(fields.idcargo.caption) : null, ew.Validators.integer], fields.idcargo.isInvalid],
            ["cargo", [fields.cargo.visible && fields.cargo.required ? ew.Validators.required(fields.cargo.caption) : null], fields.cargo.isInvalid],
            ["salario_antes", [fields.salario_antes.visible && fields.salario_antes.required ? ew.Validators.required(fields.salario_antes.caption) : null], fields.salario_antes.isInvalid],
            ["salario_atual", [fields.salario_atual.visible && fields.salario_atual.required ? ew.Validators.required(fields.salario_atual.caption) : null, ew.Validators.float], fields.salario_atual.isInvalid]
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
<input type="hidden" name="t" value="dissidio">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "dissidio_anual") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="dissidio_anual">
<input type="hidden" name="fk_iddissidio_anual" value="<?= HtmlEncode($Page->dissidio_anual_iddissidio_anual->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idcargo->Visible) { // idcargo ?>
    <div id="r_idcargo"<?= $Page->idcargo->rowAttributes() ?>>
        <label id="elh_dissidio_idcargo" for="x_idcargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcargo->caption() ?><?= $Page->idcargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idcargo->cellAttributes() ?>>
<span id="el_dissidio_idcargo">
<input type="<?= $Page->idcargo->getInputTextType() ?>" name="x_idcargo" id="x_idcargo" data-table="dissidio" data-field="x_idcargo" value="<?= $Page->idcargo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->idcargo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idcargo->formatPattern()) ?>"<?= $Page->idcargo->editAttributes() ?> aria-describedby="x_idcargo_help">
<?= $Page->idcargo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idcargo->getErrorMessage() ?></div>
<input type="hidden" data-table="dissidio" data-field="x_idcargo" data-hidden="1" data-old name="o_idcargo" id="o_idcargo" value="<?= HtmlEncode($Page->idcargo->OldValue ?? $Page->idcargo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
    <div id="r_cargo"<?= $Page->cargo->rowAttributes() ?>>
        <label id="elh_dissidio_cargo" for="x_cargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cargo->caption() ?><?= $Page->cargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cargo->cellAttributes() ?>>
<span id="el_dissidio_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cargo->getDisplayValue($Page->cargo->EditValue))) ?>"></span>
<input type="hidden" data-table="dissidio" data-field="x_cargo" data-hidden="1" name="x_cargo" id="x_cargo" value="<?= HtmlEncode($Page->cargo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->salario_antes->Visible) { // salario_antes ?>
    <div id="r_salario_antes"<?= $Page->salario_antes->rowAttributes() ?>>
        <label id="elh_dissidio_salario_antes" for="x_salario_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->salario_antes->caption() ?><?= $Page->salario_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->salario_antes->cellAttributes() ?>>
<span id="el_dissidio_salario_antes">
<span<?= $Page->salario_antes->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->salario_antes->getDisplayValue($Page->salario_antes->EditValue))) ?>"></span>
<input type="hidden" data-table="dissidio" data-field="x_salario_antes" data-hidden="1" name="x_salario_antes" id="x_salario_antes" value="<?= HtmlEncode($Page->salario_antes->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->salario_atual->Visible) { // salario_atual ?>
    <div id="r_salario_atual"<?= $Page->salario_atual->rowAttributes() ?>>
        <label id="elh_dissidio_salario_atual" for="x_salario_atual" class="<?= $Page->LeftColumnClass ?>"><?= $Page->salario_atual->caption() ?><?= $Page->salario_atual->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->salario_atual->cellAttributes() ?>>
<span id="el_dissidio_salario_atual">
<input type="<?= $Page->salario_atual->getInputTextType() ?>" name="x_salario_atual" id="x_salario_atual" data-table="dissidio" data-field="x_salario_atual" value="<?= $Page->salario_atual->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->salario_atual->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->salario_atual->formatPattern()) ?>"<?= $Page->salario_atual->editAttributes() ?> aria-describedby="x_salario_atual_help">
<?= $Page->salario_atual->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->salario_atual->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdissidioedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdissidioedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("dissidio");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
