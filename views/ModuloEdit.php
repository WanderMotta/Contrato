<?php

namespace PHPMaker2024\contratos;

// Page object
$ModuloEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fmoduloedit" id="fmoduloedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { modulo: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fmoduloedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmoduloedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idmodulo", [fields.idmodulo.visible && fields.idmodulo.required ? ew.Validators.required(fields.idmodulo.caption) : null], fields.idmodulo.isInvalid],
            ["modulo", [fields.modulo.visible && fields.modulo.required ? ew.Validators.required(fields.modulo.caption) : null], fields.modulo.isInvalid],
            ["posicao", [fields.posicao.visible && fields.posicao.required ? ew.Validators.required(fields.posicao.caption) : null, ew.Validators.integer], fields.posicao.isInvalid]
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
<input type="hidden" name="t" value="modulo">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idmodulo->Visible) { // idmodulo ?>
    <div id="r_idmodulo"<?= $Page->idmodulo->rowAttributes() ?>>
        <label id="elh_modulo_idmodulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idmodulo->caption() ?><?= $Page->idmodulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idmodulo->cellAttributes() ?>>
<span id="el_modulo_idmodulo">
<span<?= $Page->idmodulo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idmodulo->getDisplayValue($Page->idmodulo->EditValue))) ?>"></span>
<input type="hidden" data-table="modulo" data-field="x_idmodulo" data-hidden="1" name="x_idmodulo" id="x_idmodulo" value="<?= HtmlEncode($Page->idmodulo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <div id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <label id="elh_modulo_modulo" for="x_modulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo->caption() ?><?= $Page->modulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo->cellAttributes() ?>>
<span id="el_modulo_modulo">
<input type="<?= $Page->modulo->getInputTextType() ?>" name="x_modulo" id="x_modulo" data-table="modulo" data-field="x_modulo" value="<?= $Page->modulo->EditValue ?>" size="60" maxlength="200" placeholder="<?= HtmlEncode($Page->modulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->modulo->formatPattern()) ?>"<?= $Page->modulo->editAttributes() ?> aria-describedby="x_modulo_help">
<?= $Page->modulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->modulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->posicao->Visible) { // posicao ?>
    <div id="r_posicao"<?= $Page->posicao->rowAttributes() ?>>
        <label id="elh_modulo_posicao" for="x_posicao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->posicao->caption() ?><?= $Page->posicao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->posicao->cellAttributes() ?>>
<span id="el_modulo_posicao">
<input type="<?= $Page->posicao->getInputTextType() ?>" name="x_posicao" id="x_posicao" data-table="modulo" data-field="x_posicao" value="<?= $Page->posicao->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->posicao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->posicao->formatPattern()) ?>"<?= $Page->posicao->editAttributes() ?> aria-describedby="x_posicao_help">
<?= $Page->posicao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->posicao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("itens_modulo", explode(",", $Page->getCurrentDetailTable())) && $itens_modulo->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("itens_modulo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ItensModuloGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fmoduloedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fmoduloedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("modulo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
