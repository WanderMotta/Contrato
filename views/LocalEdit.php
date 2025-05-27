<?php

namespace PHPMaker2024\contratos;

// Page object
$LocalEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="flocaledit" id="flocaledit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { local: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var flocaledit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flocaledit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idlocal", [fields.idlocal.visible && fields.idlocal.required ? ew.Validators.required(fields.idlocal.caption) : null], fields.idlocal.isInvalid],
            ["local", [fields.local.visible && fields.local.required ? ew.Validators.required(fields.local.caption) : null], fields.local.isInvalid]
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
<input type="hidden" name="t" value="local">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idlocal->Visible) { // idlocal ?>
    <div id="r_idlocal"<?= $Page->idlocal->rowAttributes() ?>>
        <label id="elh_local_idlocal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idlocal->caption() ?><?= $Page->idlocal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idlocal->cellAttributes() ?>>
<span id="el_local_idlocal">
<span<?= $Page->idlocal->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idlocal->getDisplayValue($Page->idlocal->EditValue))) ?>"></span>
<input type="hidden" data-table="local" data-field="x_idlocal" data-hidden="1" name="x_idlocal" id="x_idlocal" value="<?= HtmlEncode($Page->idlocal->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->local->Visible) { // local ?>
    <div id="r_local"<?= $Page->local->rowAttributes() ?>>
        <label id="elh_local_local" for="x_local" class="<?= $Page->LeftColumnClass ?>"><?= $Page->local->caption() ?><?= $Page->local->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->local->cellAttributes() ?>>
<span id="el_local_local">
<input type="<?= $Page->local->getInputTextType() ?>" name="x_local" id="x_local" data-table="local" data-field="x_local" value="<?= $Page->local->EditValue ?>" size="80" maxlength="120" placeholder="<?= HtmlEncode($Page->local->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->local->formatPattern()) ?>"<?= $Page->local->editAttributes() ?> aria-describedby="x_local_help">
<?= $Page->local->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->local->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="flocaledit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="flocaledit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("local");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
