<?php

namespace PHPMaker2024\contratos;

// Page object
$EscalaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fescalaedit" id="fescalaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { escala: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fescalaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fescalaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idescala", [fields.idescala.visible && fields.idescala.required ? ew.Validators.required(fields.idescala.caption) : null], fields.idescala.isInvalid],
            ["escala", [fields.escala.visible && fields.escala.required ? ew.Validators.required(fields.escala.caption) : null], fields.escala.isInvalid],
            ["nr_dias_mes", [fields.nr_dias_mes.visible && fields.nr_dias_mes.required ? ew.Validators.required(fields.nr_dias_mes.caption) : null, ew.Validators.float], fields.nr_dias_mes.isInvalid],
            ["intra_sdf", [fields.intra_sdf.visible && fields.intra_sdf.required ? ew.Validators.required(fields.intra_sdf.caption) : null, ew.Validators.float], fields.intra_sdf.isInvalid],
            ["intra_df", [fields.intra_df.visible && fields.intra_df.required ? ew.Validators.required(fields.intra_df.caption) : null, ew.Validators.float], fields.intra_df.isInvalid]
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
<input type="hidden" name="t" value="escala">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idescala->Visible) { // idescala ?>
    <div id="r_idescala"<?= $Page->idescala->rowAttributes() ?>>
        <label id="elh_escala_idescala" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idescala->caption() ?><?= $Page->idescala->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idescala->cellAttributes() ?>>
<span id="el_escala_idescala">
<span<?= $Page->idescala->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idescala->getDisplayValue($Page->idescala->EditValue))) ?>"></span>
<input type="hidden" data-table="escala" data-field="x_idescala" data-hidden="1" name="x_idescala" id="x_idescala" value="<?= HtmlEncode($Page->idescala->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->escala->Visible) { // escala ?>
    <div id="r_escala"<?= $Page->escala->rowAttributes() ?>>
        <label id="elh_escala_escala" for="x_escala" class="<?= $Page->LeftColumnClass ?>"><?= $Page->escala->caption() ?><?= $Page->escala->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->escala->cellAttributes() ?>>
<span id="el_escala_escala">
<input type="<?= $Page->escala->getInputTextType() ?>" name="x_escala" id="x_escala" data-table="escala" data-field="x_escala" value="<?= $Page->escala->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->escala->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->escala->formatPattern()) ?>"<?= $Page->escala->editAttributes() ?> aria-describedby="x_escala_help">
<?= $Page->escala->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->escala->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nr_dias_mes->Visible) { // nr_dias_mes ?>
    <div id="r_nr_dias_mes"<?= $Page->nr_dias_mes->rowAttributes() ?>>
        <label id="elh_escala_nr_dias_mes" for="x_nr_dias_mes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nr_dias_mes->caption() ?><?= $Page->nr_dias_mes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nr_dias_mes->cellAttributes() ?>>
<span id="el_escala_nr_dias_mes">
<input type="<?= $Page->nr_dias_mes->getInputTextType() ?>" name="x_nr_dias_mes" id="x_nr_dias_mes" data-table="escala" data-field="x_nr_dias_mes" value="<?= $Page->nr_dias_mes->EditValue ?>" size="5" maxlength="2" placeholder="<?= HtmlEncode($Page->nr_dias_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nr_dias_mes->formatPattern()) ?>"<?= $Page->nr_dias_mes->editAttributes() ?> aria-describedby="x_nr_dias_mes_help">
<?= $Page->nr_dias_mes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nr_dias_mes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->intra_sdf->Visible) { // intra_sdf ?>
    <div id="r_intra_sdf"<?= $Page->intra_sdf->rowAttributes() ?>>
        <label id="elh_escala_intra_sdf" for="x_intra_sdf" class="<?= $Page->LeftColumnClass ?>"><?= $Page->intra_sdf->caption() ?><?= $Page->intra_sdf->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->intra_sdf->cellAttributes() ?>>
<span id="el_escala_intra_sdf">
<input type="<?= $Page->intra_sdf->getInputTextType() ?>" name="x_intra_sdf" id="x_intra_sdf" data-table="escala" data-field="x_intra_sdf" value="<?= $Page->intra_sdf->EditValue ?>" size="5" maxlength="2" placeholder="<?= HtmlEncode($Page->intra_sdf->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->intra_sdf->formatPattern()) ?>"<?= $Page->intra_sdf->editAttributes() ?> aria-describedby="x_intra_sdf_help">
<?= $Page->intra_sdf->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->intra_sdf->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->intra_df->Visible) { // intra_df ?>
    <div id="r_intra_df"<?= $Page->intra_df->rowAttributes() ?>>
        <label id="elh_escala_intra_df" for="x_intra_df" class="<?= $Page->LeftColumnClass ?>"><?= $Page->intra_df->caption() ?><?= $Page->intra_df->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->intra_df->cellAttributes() ?>>
<span id="el_escala_intra_df">
<input type="<?= $Page->intra_df->getInputTextType() ?>" name="x_intra_df" id="x_intra_df" data-table="escala" data-field="x_intra_df" value="<?= $Page->intra_df->EditValue ?>" size="5" maxlength="2" placeholder="<?= HtmlEncode($Page->intra_df->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->intra_df->formatPattern()) ?>"<?= $Page->intra_df->editAttributes() ?> aria-describedby="x_intra_df_help">
<?= $Page->intra_df->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->intra_df->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fescalaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fescalaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("escala");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
