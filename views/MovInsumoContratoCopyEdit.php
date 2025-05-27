<?php

namespace PHPMaker2024\contratos;

// Page object
$MovInsumoContratoCopyEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fmov_insumo_contrato_copyedit" id="fmov_insumo_contrato_copyedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mov_insumo_contrato_copy: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fmov_insumo_contrato_copyedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmov_insumo_contrato_copyedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idmov_insumo_contrato", [fields.idmov_insumo_contrato.visible && fields.idmov_insumo_contrato.required ? ew.Validators.required(fields.idmov_insumo_contrato.caption) : null], fields.idmov_insumo_contrato.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null, ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["insumo_idinsumo", [fields.insumo_idinsumo.visible && fields.insumo_idinsumo.required ? ew.Validators.required(fields.insumo_idinsumo.caption) : null, ew.Validators.integer], fields.insumo_idinsumo.isInvalid],
            ["qtde", [fields.qtde.visible && fields.qtde.required ? ew.Validators.required(fields.qtde.caption) : null, ew.Validators.float], fields.qtde.isInvalid],
            ["vr_unit", [fields.vr_unit.visible && fields.vr_unit.required ? ew.Validators.required(fields.vr_unit.caption) : null, ew.Validators.float], fields.vr_unit.isInvalid],
            ["tipo_insumo_idtipo_insumo", [fields.tipo_insumo_idtipo_insumo.visible && fields.tipo_insumo_idtipo_insumo.required ? ew.Validators.required(fields.tipo_insumo_idtipo_insumo.caption) : null, ew.Validators.integer], fields.tipo_insumo_idtipo_insumo.isInvalid],
            ["frequencia", [fields.frequencia.visible && fields.frequencia.required ? ew.Validators.required(fields.frequencia.caption) : null, ew.Validators.float], fields.frequencia.isInvalid],
            ["contrato_idcontrato", [fields.contrato_idcontrato.visible && fields.contrato_idcontrato.required ? ew.Validators.required(fields.contrato_idcontrato.caption) : null, ew.Validators.integer], fields.contrato_idcontrato.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
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
<input type="hidden" name="t" value="mov_insumo_contrato_copy">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idmov_insumo_contrato->Visible) { // idmov_insumo_contrato ?>
    <div id="r_idmov_insumo_contrato"<?= $Page->idmov_insumo_contrato->rowAttributes() ?>>
        <label id="elh_mov_insumo_contrato_copy_idmov_insumo_contrato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idmov_insumo_contrato->caption() ?><?= $Page->idmov_insumo_contrato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idmov_insumo_contrato->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_idmov_insumo_contrato">
<span<?= $Page->idmov_insumo_contrato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idmov_insumo_contrato->getDisplayValue($Page->idmov_insumo_contrato->EditValue))) ?>"></span>
<input type="hidden" data-table="mov_insumo_contrato_copy" data-field="x_idmov_insumo_contrato" data-hidden="1" name="x_idmov_insumo_contrato" id="x_idmov_insumo_contrato" value="<?= HtmlEncode($Page->idmov_insumo_contrato->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label id="elh_mov_insumo_contrato_copy_dt_cadastro" for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dt_cadastro->caption() ?><?= $Page->dt_cadastro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_dt_cadastro">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="mov_insumo_contrato_copy" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?> aria-describedby="x_dt_cadastro_help">
<?= $Page->dt_cadastro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage() ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmov_insumo_contrato_copyedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fmov_insumo_contrato_copyedit", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
    <div id="r_insumo_idinsumo"<?= $Page->insumo_idinsumo->rowAttributes() ?>>
        <label id="elh_mov_insumo_contrato_copy_insumo_idinsumo" for="x_insumo_idinsumo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->insumo_idinsumo->caption() ?><?= $Page->insumo_idinsumo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->insumo_idinsumo->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_insumo_idinsumo">
<input type="<?= $Page->insumo_idinsumo->getInputTextType() ?>" name="x_insumo_idinsumo" id="x_insumo_idinsumo" data-table="mov_insumo_contrato_copy" data-field="x_insumo_idinsumo" value="<?= $Page->insumo_idinsumo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->insumo_idinsumo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->insumo_idinsumo->formatPattern()) ?>"<?= $Page->insumo_idinsumo->editAttributes() ?> aria-describedby="x_insumo_idinsumo_help">
<?= $Page->insumo_idinsumo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->insumo_idinsumo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
    <div id="r_qtde"<?= $Page->qtde->rowAttributes() ?>>
        <label id="elh_mov_insumo_contrato_copy_qtde" for="x_qtde" class="<?= $Page->LeftColumnClass ?>"><?= $Page->qtde->caption() ?><?= $Page->qtde->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->qtde->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_qtde">
<input type="<?= $Page->qtde->getInputTextType() ?>" name="x_qtde" id="x_qtde" data-table="mov_insumo_contrato_copy" data-field="x_qtde" value="<?= $Page->qtde->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->qtde->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->qtde->formatPattern()) ?>"<?= $Page->qtde->editAttributes() ?> aria-describedby="x_qtde_help">
<?= $Page->qtde->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->qtde->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vr_unit->Visible) { // vr_unit ?>
    <div id="r_vr_unit"<?= $Page->vr_unit->rowAttributes() ?>>
        <label id="elh_mov_insumo_contrato_copy_vr_unit" for="x_vr_unit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vr_unit->caption() ?><?= $Page->vr_unit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vr_unit->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_vr_unit">
<input type="<?= $Page->vr_unit->getInputTextType() ?>" name="x_vr_unit" id="x_vr_unit" data-table="mov_insumo_contrato_copy" data-field="x_vr_unit" value="<?= $Page->vr_unit->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->vr_unit->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_unit->formatPattern()) ?>"<?= $Page->vr_unit->editAttributes() ?> aria-describedby="x_vr_unit_help">
<?= $Page->vr_unit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vr_unit->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
    <div id="r_tipo_insumo_idtipo_insumo"<?= $Page->tipo_insumo_idtipo_insumo->rowAttributes() ?>>
        <label id="elh_mov_insumo_contrato_copy_tipo_insumo_idtipo_insumo" for="x_tipo_insumo_idtipo_insumo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_insumo_idtipo_insumo->caption() ?><?= $Page->tipo_insumo_idtipo_insumo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_tipo_insumo_idtipo_insumo">
<input type="<?= $Page->tipo_insumo_idtipo_insumo->getInputTextType() ?>" name="x_tipo_insumo_idtipo_insumo" id="x_tipo_insumo_idtipo_insumo" data-table="mov_insumo_contrato_copy" data-field="x_tipo_insumo_idtipo_insumo" value="<?= $Page->tipo_insumo_idtipo_insumo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tipo_insumo_idtipo_insumo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipo_insumo_idtipo_insumo->formatPattern()) ?>"<?= $Page->tipo_insumo_idtipo_insumo->editAttributes() ?> aria-describedby="x_tipo_insumo_idtipo_insumo_help">
<?= $Page->tipo_insumo_idtipo_insumo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_insumo_idtipo_insumo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
    <div id="r_frequencia"<?= $Page->frequencia->rowAttributes() ?>>
        <label id="elh_mov_insumo_contrato_copy_frequencia" for="x_frequencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->frequencia->caption() ?><?= $Page->frequencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->frequencia->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_frequencia">
<input type="<?= $Page->frequencia->getInputTextType() ?>" name="x_frequencia" id="x_frequencia" data-table="mov_insumo_contrato_copy" data-field="x_frequencia" value="<?= $Page->frequencia->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->frequencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->frequencia->formatPattern()) ?>"<?= $Page->frequencia->editAttributes() ?> aria-describedby="x_frequencia_help">
<?= $Page->frequencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->frequencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contrato_idcontrato->Visible) { // contrato_idcontrato ?>
    <div id="r_contrato_idcontrato"<?= $Page->contrato_idcontrato->rowAttributes() ?>>
        <label id="elh_mov_insumo_contrato_copy_contrato_idcontrato" for="x_contrato_idcontrato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contrato_idcontrato->caption() ?><?= $Page->contrato_idcontrato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contrato_idcontrato->cellAttributes() ?>>
<span id="el_mov_insumo_contrato_copy_contrato_idcontrato">
<input type="<?= $Page->contrato_idcontrato->getInputTextType() ?>" name="x_contrato_idcontrato" id="x_contrato_idcontrato" data-table="mov_insumo_contrato_copy" data-field="x_contrato_idcontrato" value="<?= $Page->contrato_idcontrato->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->contrato_idcontrato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contrato_idcontrato->formatPattern()) ?>"<?= $Page->contrato_idcontrato->editAttributes() ?> aria-describedby="x_contrato_idcontrato_help">
<?= $Page->contrato_idcontrato->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contrato_idcontrato->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fmov_insumo_contrato_copyedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fmov_insumo_contrato_copyedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("mov_insumo_contrato_copy");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
