<?php

namespace PHPMaker2024\contratos;

// Page object
$FuncaoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ffuncaoedit" id="ffuncaoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { funcao: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ffuncaoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffuncaoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idfuncao", [fields.idfuncao.visible && fields.idfuncao.required ? ew.Validators.required(fields.idfuncao.caption) : null], fields.idfuncao.isInvalid],
            ["funcao", [fields.funcao.visible && fields.funcao.required ? ew.Validators.required(fields.funcao.caption) : null], fields.funcao.isInvalid]
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
<input type="hidden" name="t" value="funcao">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idfuncao->Visible) { // idfuncao ?>
    <div id="r_idfuncao"<?= $Page->idfuncao->rowAttributes() ?>>
        <label id="elh_funcao_idfuncao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idfuncao->caption() ?><?= $Page->idfuncao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idfuncao->cellAttributes() ?>>
<span id="el_funcao_idfuncao">
<span<?= $Page->idfuncao->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idfuncao->getDisplayValue($Page->idfuncao->EditValue))) ?>"></span>
<input type="hidden" data-table="funcao" data-field="x_idfuncao" data-hidden="1" name="x_idfuncao" id="x_idfuncao" value="<?= HtmlEncode($Page->idfuncao->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->funcao->Visible) { // funcao ?>
    <div id="r_funcao"<?= $Page->funcao->rowAttributes() ?>>
        <label id="elh_funcao_funcao" for="x_funcao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->funcao->caption() ?><?= $Page->funcao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->funcao->cellAttributes() ?>>
<span id="el_funcao_funcao">
<input type="<?= $Page->funcao->getInputTextType() ?>" name="x_funcao" id="x_funcao" data-table="funcao" data-field="x_funcao" value="<?= $Page->funcao->EditValue ?>" size="60" maxlength="60" placeholder="<?= HtmlEncode($Page->funcao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->funcao->formatPattern()) ?>"<?= $Page->funcao->editAttributes() ?> aria-describedby="x_funcao_help">
<?= $Page->funcao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->funcao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffuncaoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ffuncaoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("funcao");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
