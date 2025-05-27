<?php

namespace PHPMaker2024\contratos;

// Page object
$ContatoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fcontatoedit" id="fcontatoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contato: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fcontatoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcontatoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idcontato", [fields.idcontato.visible && fields.idcontato.required ? ew.Validators.required(fields.idcontato.caption) : null], fields.idcontato.isInvalid],
            ["contato", [fields.contato.visible && fields.contato.required ? ew.Validators.required(fields.contato.caption) : null], fields.contato.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
            ["telefone", [fields.telefone.visible && fields.telefone.required ? ew.Validators.required(fields.telefone.caption) : null], fields.telefone.isInvalid],
            ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
            ["ativo", [fields.ativo.visible && fields.ativo.required ? ew.Validators.required(fields.ativo.caption) : null], fields.ativo.isInvalid],
            ["faturamento_idfaturamento", [fields.faturamento_idfaturamento.visible && fields.faturamento_idfaturamento.required ? ew.Validators.required(fields.faturamento_idfaturamento.caption) : null, ew.Validators.integer], fields.faturamento_idfaturamento.isInvalid]
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
            "status": <?= $Page->status->toClientList($Page) ?>,
            "ativo": <?= $Page->ativo->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="contato">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "faturamento") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="faturamento">
<input type="hidden" name="fk_idfaturamento" value="<?= HtmlEncode($Page->faturamento_idfaturamento->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idcontato->Visible) { // idcontato ?>
    <div id="r_idcontato"<?= $Page->idcontato->rowAttributes() ?>>
        <label id="elh_contato_idcontato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcontato->caption() ?><?= $Page->idcontato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idcontato->cellAttributes() ?>>
<span id="el_contato_idcontato">
<span<?= $Page->idcontato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idcontato->getDisplayValue($Page->idcontato->EditValue))) ?>"></span>
<input type="hidden" data-table="contato" data-field="x_idcontato" data-hidden="1" name="x_idcontato" id="x_idcontato" value="<?= HtmlEncode($Page->idcontato->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contato->Visible) { // contato ?>
    <div id="r_contato"<?= $Page->contato->rowAttributes() ?>>
        <label id="elh_contato_contato" for="x_contato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contato->caption() ?><?= $Page->contato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contato->cellAttributes() ?>>
<span id="el_contato_contato">
<input type="<?= $Page->contato->getInputTextType() ?>" name="x_contato" id="x_contato" data-table="contato" data-field="x_contato" value="<?= $Page->contato->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->contato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contato->formatPattern()) ?>"<?= $Page->contato->editAttributes() ?> aria-describedby="x_contato_help">
<?= $Page->contato->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contato->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_contato__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_contato__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="contato" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="50" maxlength="120" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefone->Visible) { // telefone ?>
    <div id="r_telefone"<?= $Page->telefone->rowAttributes() ?>>
        <label id="elh_contato_telefone" for="x_telefone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefone->caption() ?><?= $Page->telefone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefone->cellAttributes() ?>>
<span id="el_contato_telefone">
<input type="<?= $Page->telefone->getInputTextType() ?>" name="x_telefone" id="x_telefone" data-table="contato" data-field="x_telefone" value="<?= $Page->telefone->EditValue ?>" size="45" maxlength="60" placeholder="<?= HtmlEncode($Page->telefone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefone->formatPattern()) ?>"<?= $Page->telefone->editAttributes() ?> aria-describedby="x_telefone_help">
<?= $Page->telefone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_contato_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_contato_status">
<template id="tp_x_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contato" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_status"
    name="x_status"
    value="<?= HtmlEncode($Page->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status"
    data-target="dsl_x_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status->isInvalidClass() ?>"
    data-table="contato"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>></selection-list>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <div id="r_ativo"<?= $Page->ativo->rowAttributes() ?>>
        <label id="elh_contato_ativo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ativo->caption() ?><?= $Page->ativo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ativo->cellAttributes() ?>>
<span id="el_contato_ativo">
<template id="tp_x_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contato" data-field="x_ativo" name="x_ativo" id="x_ativo"<?= $Page->ativo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_ativo" class="ew-item-list"></div>
<selection-list hidden
    id="x_ativo"
    name="x_ativo"
    value="<?= HtmlEncode($Page->ativo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ativo"
    data-target="dsl_x_ativo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ativo->isInvalidClass() ?>"
    data-table="contato"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<?= $Page->ativo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->faturamento_idfaturamento->Visible) { // faturamento_idfaturamento ?>
    <div id="r_faturamento_idfaturamento"<?= $Page->faturamento_idfaturamento->rowAttributes() ?>>
        <label id="elh_contato_faturamento_idfaturamento" for="x_faturamento_idfaturamento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->faturamento_idfaturamento->caption() ?><?= $Page->faturamento_idfaturamento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->faturamento_idfaturamento->cellAttributes() ?>>
<?php if ($Page->faturamento_idfaturamento->getSessionValue() != "") { ?>
<span id="el_contato_faturamento_idfaturamento">
<span<?= $Page->faturamento_idfaturamento->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->faturamento_idfaturamento->getDisplayValue($Page->faturamento_idfaturamento->ViewValue))) ?>"></span>
<input type="hidden" id="x_faturamento_idfaturamento" name="x_faturamento_idfaturamento" value="<?= HtmlEncode($Page->faturamento_idfaturamento->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_contato_faturamento_idfaturamento">
<input type="<?= $Page->faturamento_idfaturamento->getInputTextType() ?>" name="x_faturamento_idfaturamento" id="x_faturamento_idfaturamento" data-table="contato" data-field="x_faturamento_idfaturamento" value="<?= $Page->faturamento_idfaturamento->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->faturamento_idfaturamento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->faturamento_idfaturamento->formatPattern()) ?>"<?= $Page->faturamento_idfaturamento->editAttributes() ?> aria-describedby="x_faturamento_idfaturamento_help">
<?= $Page->faturamento_idfaturamento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->faturamento_idfaturamento->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcontatoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcontatoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("contato");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
