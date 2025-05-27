<?php

namespace PHPMaker2024\contratos;

// Page object
$PeriodoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { periodo: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fperiodoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fperiodoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["periodo", [fields.periodo.visible && fields.periodo.required ? ew.Validators.required(fields.periodo.caption) : null], fields.periodo.isInvalid],
            ["fator", [fields.fator.visible && fields.fator.required ? ew.Validators.required(fields.fator.caption) : null, ew.Validators.float], fields.fator.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fperiodoadd" id="fperiodoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="periodo">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->periodo->Visible) { // periodo ?>
    <div id="r_periodo"<?= $Page->periodo->rowAttributes() ?>>
        <label id="elh_periodo_periodo" for="x_periodo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periodo->caption() ?><?= $Page->periodo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periodo->cellAttributes() ?>>
<span id="el_periodo_periodo">
<input type="<?= $Page->periodo->getInputTextType() ?>" name="x_periodo" id="x_periodo" data-table="periodo" data-field="x_periodo" value="<?= $Page->periodo->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->periodo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->periodo->formatPattern()) ?>"<?= $Page->periodo->editAttributes() ?> aria-describedby="x_periodo_help">
<?= $Page->periodo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->periodo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fator->Visible) { // fator ?>
    <div id="r_fator"<?= $Page->fator->rowAttributes() ?>>
        <label id="elh_periodo_fator" for="x_fator" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fator->caption() ?><?= $Page->fator->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fator->cellAttributes() ?>>
<span id="el_periodo_fator">
<input type="<?= $Page->fator->getInputTextType() ?>" name="x_fator" id="x_fator" data-table="periodo" data-field="x_fator" value="<?= $Page->fator->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Page->fator->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fator->formatPattern()) ?>"<?= $Page->fator->editAttributes() ?> aria-describedby="x_fator_help">
<?= $Page->fator->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fator->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fperiodoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fperiodoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("periodo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
