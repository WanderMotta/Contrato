<?php

namespace PHPMaker2024\contratos;

// Page object
$TipoIntrajornadaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ftipo_intrajornadaedit" id="ftipo_intrajornadaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipo_intrajornada: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ftipo_intrajornadaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipo_intrajornadaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idtipo_intrajornada", [fields.idtipo_intrajornada.visible && fields.idtipo_intrajornada.required ? ew.Validators.required(fields.idtipo_intrajornada.caption) : null], fields.idtipo_intrajornada.isInvalid],
            ["intrajornada_tipo", [fields.intrajornada_tipo.visible && fields.intrajornada_tipo.required ? ew.Validators.required(fields.intrajornada_tipo.caption) : null], fields.intrajornada_tipo.isInvalid]
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
<input type="hidden" name="t" value="tipo_intrajornada">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idtipo_intrajornada->Visible) { // idtipo_intrajornada ?>
    <div id="r_idtipo_intrajornada"<?= $Page->idtipo_intrajornada->rowAttributes() ?>>
        <label id="elh_tipo_intrajornada_idtipo_intrajornada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idtipo_intrajornada->caption() ?><?= $Page->idtipo_intrajornada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idtipo_intrajornada->cellAttributes() ?>>
<span id="el_tipo_intrajornada_idtipo_intrajornada">
<span<?= $Page->idtipo_intrajornada->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idtipo_intrajornada->getDisplayValue($Page->idtipo_intrajornada->EditValue))) ?>"></span>
<input type="hidden" data-table="tipo_intrajornada" data-field="x_idtipo_intrajornada" data-hidden="1" name="x_idtipo_intrajornada" id="x_idtipo_intrajornada" value="<?= HtmlEncode($Page->idtipo_intrajornada->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->intrajornada_tipo->Visible) { // intrajornada_tipo ?>
    <div id="r_intrajornada_tipo"<?= $Page->intrajornada_tipo->rowAttributes() ?>>
        <label id="elh_tipo_intrajornada_intrajornada_tipo" for="x_intrajornada_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->intrajornada_tipo->caption() ?><?= $Page->intrajornada_tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->intrajornada_tipo->cellAttributes() ?>>
<span id="el_tipo_intrajornada_intrajornada_tipo">
<input type="<?= $Page->intrajornada_tipo->getInputTextType() ?>" name="x_intrajornada_tipo" id="x_intrajornada_tipo" data-table="tipo_intrajornada" data-field="x_intrajornada_tipo" value="<?= $Page->intrajornada_tipo->EditValue ?>" size="30" maxlength="35" placeholder="<?= HtmlEncode($Page->intrajornada_tipo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->intrajornada_tipo->formatPattern()) ?>"<?= $Page->intrajornada_tipo->editAttributes() ?> aria-describedby="x_intrajornada_tipo_help">
<?= $Page->intrajornada_tipo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->intrajornada_tipo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ftipo_intrajornadaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ftipo_intrajornadaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("tipo_intrajornada");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
