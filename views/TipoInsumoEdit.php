<?php

namespace PHPMaker2024\contratos;

// Page object
$TipoInsumoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ftipo_insumoedit" id="ftipo_insumoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipo_insumo: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ftipo_insumoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipo_insumoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idtipo_insumo", [fields.idtipo_insumo.visible && fields.idtipo_insumo.required ? ew.Validators.required(fields.idtipo_insumo.caption) : null], fields.idtipo_insumo.isInvalid],
            ["tipo_insumo", [fields.tipo_insumo.visible && fields.tipo_insumo.required ? ew.Validators.required(fields.tipo_insumo.caption) : null], fields.tipo_insumo.isInvalid]
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
<input type="hidden" name="t" value="tipo_insumo">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idtipo_insumo->Visible) { // idtipo_insumo ?>
    <div id="r_idtipo_insumo"<?= $Page->idtipo_insumo->rowAttributes() ?>>
        <label id="elh_tipo_insumo_idtipo_insumo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idtipo_insumo->caption() ?><?= $Page->idtipo_insumo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idtipo_insumo->cellAttributes() ?>>
<span id="el_tipo_insumo_idtipo_insumo">
<span<?= $Page->idtipo_insumo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idtipo_insumo->getDisplayValue($Page->idtipo_insumo->EditValue))) ?>"></span>
<input type="hidden" data-table="tipo_insumo" data-field="x_idtipo_insumo" data-hidden="1" name="x_idtipo_insumo" id="x_idtipo_insumo" value="<?= HtmlEncode($Page->idtipo_insumo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
    <div id="r_tipo_insumo"<?= $Page->tipo_insumo->rowAttributes() ?>>
        <label id="elh_tipo_insumo_tipo_insumo" for="x_tipo_insumo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_insumo->caption() ?><?= $Page->tipo_insumo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_insumo->cellAttributes() ?>>
<span id="el_tipo_insumo_tipo_insumo">
<input type="<?= $Page->tipo_insumo->getInputTextType() ?>" name="x_tipo_insumo" id="x_tipo_insumo" data-table="tipo_insumo" data-field="x_tipo_insumo" value="<?= $Page->tipo_insumo->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->tipo_insumo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipo_insumo->formatPattern()) ?>"<?= $Page->tipo_insumo->editAttributes() ?> aria-describedby="x_tipo_insumo_help">
<?= $Page->tipo_insumo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_insumo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ftipo_insumoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ftipo_insumoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("tipo_insumo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
