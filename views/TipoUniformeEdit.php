<?php

namespace PHPMaker2024\contratos;

// Page object
$TipoUniformeEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ftipo_uniformeedit" id="ftipo_uniformeedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipo_uniforme: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ftipo_uniformeedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipo_uniformeedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idtipo_uniforme", [fields.idtipo_uniforme.visible && fields.idtipo_uniforme.required ? ew.Validators.required(fields.idtipo_uniforme.caption) : null], fields.idtipo_uniforme.isInvalid],
            ["tipo_uniforme", [fields.tipo_uniforme.visible && fields.tipo_uniforme.required ? ew.Validators.required(fields.tipo_uniforme.caption) : null], fields.tipo_uniforme.isInvalid]
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
<input type="hidden" name="t" value="tipo_uniforme">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idtipo_uniforme->Visible) { // idtipo_uniforme ?>
    <div id="r_idtipo_uniforme"<?= $Page->idtipo_uniforme->rowAttributes() ?>>
        <label id="elh_tipo_uniforme_idtipo_uniforme" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idtipo_uniforme->caption() ?><?= $Page->idtipo_uniforme->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idtipo_uniforme->cellAttributes() ?>>
<span id="el_tipo_uniforme_idtipo_uniforme">
<span<?= $Page->idtipo_uniforme->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idtipo_uniforme->getDisplayValue($Page->idtipo_uniforme->EditValue))) ?>"></span>
<input type="hidden" data-table="tipo_uniforme" data-field="x_idtipo_uniforme" data-hidden="1" name="x_idtipo_uniforme" id="x_idtipo_uniforme" value="<?= HtmlEncode($Page->idtipo_uniforme->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_uniforme->Visible) { // tipo_uniforme ?>
    <div id="r_tipo_uniforme"<?= $Page->tipo_uniforme->rowAttributes() ?>>
        <label id="elh_tipo_uniforme_tipo_uniforme" for="x_tipo_uniforme" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_uniforme->caption() ?><?= $Page->tipo_uniforme->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_uniforme->cellAttributes() ?>>
<span id="el_tipo_uniforme_tipo_uniforme">
<input type="<?= $Page->tipo_uniforme->getInputTextType() ?>" name="x_tipo_uniforme" id="x_tipo_uniforme" data-table="tipo_uniforme" data-field="x_tipo_uniforme" value="<?= $Page->tipo_uniforme->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->tipo_uniforme->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipo_uniforme->formatPattern()) ?>"<?= $Page->tipo_uniforme->editAttributes() ?> aria-describedby="x_tipo_uniforme_help">
<?= $Page->tipo_uniforme->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_uniforme->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("uniforme_cargo", explode(",", $Page->getCurrentDetailTable())) && $uniforme_cargo->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("uniforme_cargo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "UniformeCargoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ftipo_uniformeedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ftipo_uniformeedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("tipo_uniforme");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
