<?php

namespace PHPMaker2024\contratos;

// Page object
$MovimentoPlaCustoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { movimento_pla_custo: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fmovimento_pla_custoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmovimento_pla_custoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["planilha_custo_idplanilha_custo", [fields.planilha_custo_idplanilha_custo.visible && fields.planilha_custo_idplanilha_custo.required ? ew.Validators.required(fields.planilha_custo_idplanilha_custo.caption) : null, ew.Validators.integer], fields.planilha_custo_idplanilha_custo.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["modulo_idmodulo", [fields.modulo_idmodulo.visible && fields.modulo_idmodulo.required ? ew.Validators.required(fields.modulo_idmodulo.caption) : null], fields.modulo_idmodulo.isInvalid],
            ["itens_modulo_iditens_modulo", [fields.itens_modulo_iditens_modulo.visible && fields.itens_modulo_iditens_modulo.required ? ew.Validators.required(fields.itens_modulo_iditens_modulo.caption) : null], fields.itens_modulo_iditens_modulo.isInvalid],
            ["porcentagem", [fields.porcentagem.visible && fields.porcentagem.required ? ew.Validators.required(fields.porcentagem.caption) : null, ew.Validators.float], fields.porcentagem.isInvalid],
            ["valor", [fields.valor.visible && fields.valor.required ? ew.Validators.required(fields.valor.caption) : null, ew.Validators.float], fields.valor.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
            ["calculo_idcalculo", [fields.calculo_idcalculo.visible && fields.calculo_idcalculo.required ? ew.Validators.required(fields.calculo_idcalculo.caption) : null, ew.Validators.integer], fields.calculo_idcalculo.isInvalid]
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
            "modulo_idmodulo": <?= $Page->modulo_idmodulo->toClientList($Page) ?>,
            "itens_modulo_iditens_modulo": <?= $Page->itens_modulo_iditens_modulo->toClientList($Page) ?>,
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
<form name="fmovimento_pla_custoadd" id="fmovimento_pla_custoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="movimento_pla_custo">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "planilha_custo") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="planilha_custo">
<input type="hidden" name="fk_idplanilha_custo" value="<?= HtmlEncode($Page->planilha_custo_idplanilha_custo->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "calculo") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="calculo">
<input type="hidden" name="fk_idcalculo" value="<?= HtmlEncode($Page->calculo_idcalculo->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
    <div id="r_planilha_custo_idplanilha_custo"<?= $Page->planilha_custo_idplanilha_custo->rowAttributes() ?>>
        <label id="elh_movimento_pla_custo_planilha_custo_idplanilha_custo" for="x_planilha_custo_idplanilha_custo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->planilha_custo_idplanilha_custo->caption() ?><?= $Page->planilha_custo_idplanilha_custo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->planilha_custo_idplanilha_custo->cellAttributes() ?>>
<?php if ($Page->planilha_custo_idplanilha_custo->getSessionValue() != "") { ?>
<span id="el_movimento_pla_custo_planilha_custo_idplanilha_custo">
<span<?= $Page->planilha_custo_idplanilha_custo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->planilha_custo_idplanilha_custo->getDisplayValue($Page->planilha_custo_idplanilha_custo->ViewValue))) ?>"></span>
<input type="hidden" id="x_planilha_custo_idplanilha_custo" name="x_planilha_custo_idplanilha_custo" value="<?= HtmlEncode($Page->planilha_custo_idplanilha_custo->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_movimento_pla_custo_planilha_custo_idplanilha_custo">
<input type="<?= $Page->planilha_custo_idplanilha_custo->getInputTextType() ?>" name="x_planilha_custo_idplanilha_custo" id="x_planilha_custo_idplanilha_custo" data-table="movimento_pla_custo" data-field="x_planilha_custo_idplanilha_custo" value="<?= $Page->planilha_custo_idplanilha_custo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->planilha_custo_idplanilha_custo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->planilha_custo_idplanilha_custo->formatPattern()) ?>"<?= $Page->planilha_custo_idplanilha_custo->editAttributes() ?> aria-describedby="x_planilha_custo_idplanilha_custo_help">
<?= $Page->planilha_custo_idplanilha_custo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->planilha_custo_idplanilha_custo->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
    <div id="r_modulo_idmodulo"<?= $Page->modulo_idmodulo->rowAttributes() ?>>
        <label id="elh_movimento_pla_custo_modulo_idmodulo" for="x_modulo_idmodulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo_idmodulo->caption() ?><?= $Page->modulo_idmodulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<span id="el_movimento_pla_custo_modulo_idmodulo">
    <select
        id="x_modulo_idmodulo"
        name="x_modulo_idmodulo"
        class="form-control ew-select<?= $Page->modulo_idmodulo->isInvalidClass() ?>"
        data-select2-id="fmovimento_pla_custoadd_x_modulo_idmodulo"
        data-table="movimento_pla_custo"
        data-field="x_modulo_idmodulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->modulo_idmodulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->modulo_idmodulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->modulo_idmodulo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->modulo_idmodulo->editAttributes() ?>>
        <?= $Page->modulo_idmodulo->selectOptionListHtml("x_modulo_idmodulo") ?>
    </select>
    <?= $Page->modulo_idmodulo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->modulo_idmodulo->getErrorMessage() ?></div>
<?= $Page->modulo_idmodulo->Lookup->getParamTag($Page, "p_x_modulo_idmodulo") ?>
<script>
loadjs.ready("fmovimento_pla_custoadd", function() {
    var options = { name: "x_modulo_idmodulo", selectId: "fmovimento_pla_custoadd_x_modulo_idmodulo" };
    if (fmovimento_pla_custoadd.lists.modulo_idmodulo?.lookupOptions.length) {
        options.data = { id: "x_modulo_idmodulo", form: "fmovimento_pla_custoadd" };
    } else {
        options.ajax = { id: "x_modulo_idmodulo", form: "fmovimento_pla_custoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.movimento_pla_custo.fields.modulo_idmodulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
    <div id="r_itens_modulo_iditens_modulo"<?= $Page->itens_modulo_iditens_modulo->rowAttributes() ?>>
        <label id="elh_movimento_pla_custo_itens_modulo_iditens_modulo" for="x_itens_modulo_iditens_modulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->itens_modulo_iditens_modulo->caption() ?><?= $Page->itens_modulo_iditens_modulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->itens_modulo_iditens_modulo->cellAttributes() ?>>
<span id="el_movimento_pla_custo_itens_modulo_iditens_modulo">
    <select
        id="x_itens_modulo_iditens_modulo"
        name="x_itens_modulo_iditens_modulo"
        class="form-control ew-select<?= $Page->itens_modulo_iditens_modulo->isInvalidClass() ?>"
        data-select2-id="fmovimento_pla_custoadd_x_itens_modulo_iditens_modulo"
        data-table="movimento_pla_custo"
        data-field="x_itens_modulo_iditens_modulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->itens_modulo_iditens_modulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->itens_modulo_iditens_modulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->itens_modulo_iditens_modulo->getPlaceHolder()) ?>"
        <?= $Page->itens_modulo_iditens_modulo->editAttributes() ?>>
        <?= $Page->itens_modulo_iditens_modulo->selectOptionListHtml("x_itens_modulo_iditens_modulo") ?>
    </select>
    <?= $Page->itens_modulo_iditens_modulo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->itens_modulo_iditens_modulo->getErrorMessage() ?></div>
<?= $Page->itens_modulo_iditens_modulo->Lookup->getParamTag($Page, "p_x_itens_modulo_iditens_modulo") ?>
<script>
loadjs.ready("fmovimento_pla_custoadd", function() {
    var options = { name: "x_itens_modulo_iditens_modulo", selectId: "fmovimento_pla_custoadd_x_itens_modulo_iditens_modulo" };
    if (fmovimento_pla_custoadd.lists.itens_modulo_iditens_modulo?.lookupOptions.length) {
        options.data = { id: "x_itens_modulo_iditens_modulo", form: "fmovimento_pla_custoadd" };
    } else {
        options.ajax = { id: "x_itens_modulo_iditens_modulo", form: "fmovimento_pla_custoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.movimento_pla_custo.fields.itens_modulo_iditens_modulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { // porcentagem ?>
    <div id="r_porcentagem"<?= $Page->porcentagem->rowAttributes() ?>>
        <label id="elh_movimento_pla_custo_porcentagem" for="x_porcentagem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->porcentagem->caption() ?><?= $Page->porcentagem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->porcentagem->cellAttributes() ?>>
<span id="el_movimento_pla_custo_porcentagem">
<input type="<?= $Page->porcentagem->getInputTextType() ?>" name="x_porcentagem" id="x_porcentagem" data-table="movimento_pla_custo" data-field="x_porcentagem" value="<?= $Page->porcentagem->EditValue ?>" size="5" maxlength="5" placeholder="<?= HtmlEncode($Page->porcentagem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porcentagem->formatPattern()) ?>"<?= $Page->porcentagem->editAttributes() ?> aria-describedby="x_porcentagem_help">
<?= $Page->porcentagem->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->porcentagem->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
    <div id="r_valor"<?= $Page->valor->rowAttributes() ?>>
        <label id="elh_movimento_pla_custo_valor" for="x_valor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valor->caption() ?><?= $Page->valor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valor->cellAttributes() ?>>
<span id="el_movimento_pla_custo_valor">
<input type="<?= $Page->valor->getInputTextType() ?>" name="x_valor" id="x_valor" data-table="movimento_pla_custo" data-field="x_valor" value="<?= $Page->valor->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valor->formatPattern()) ?>"<?= $Page->valor->editAttributes() ?> aria-describedby="x_valor_help">
<?= $Page->valor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_movimento_pla_custo_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_movimento_pla_custo_obs">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="movimento_pla_custo" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="50" maxlength="155" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help">
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
    <div id="r_calculo_idcalculo"<?= $Page->calculo_idcalculo->rowAttributes() ?>>
        <label id="elh_movimento_pla_custo_calculo_idcalculo" for="x_calculo_idcalculo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->calculo_idcalculo->caption() ?><?= $Page->calculo_idcalculo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->calculo_idcalculo->cellAttributes() ?>>
<?php if ($Page->calculo_idcalculo->getSessionValue() != "") { ?>
<span id="el_movimento_pla_custo_calculo_idcalculo">
<span<?= $Page->calculo_idcalculo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->calculo_idcalculo->getDisplayValue($Page->calculo_idcalculo->ViewValue))) ?>"></span>
<input type="hidden" id="x_calculo_idcalculo" name="x_calculo_idcalculo" value="<?= HtmlEncode($Page->calculo_idcalculo->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_movimento_pla_custo_calculo_idcalculo">
<input type="<?= $Page->calculo_idcalculo->getInputTextType() ?>" name="x_calculo_idcalculo" id="x_calculo_idcalculo" data-table="movimento_pla_custo" data-field="x_calculo_idcalculo" value="<?= $Page->calculo_idcalculo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->calculo_idcalculo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->calculo_idcalculo->formatPattern()) ?>"<?= $Page->calculo_idcalculo->editAttributes() ?> aria-describedby="x_calculo_idcalculo_help">
<?= $Page->calculo_idcalculo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->calculo_idcalculo->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fmovimento_pla_custoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fmovimento_pla_custoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("movimento_pla_custo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
