<?php

namespace PHPMaker2024\contratos;

// Page object
$PropostaAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposta: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fpropostaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpropostaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["cliente_idcliente", [fields.cliente_idcliente.visible && fields.cliente_idcliente.required ? ew.Validators.required(fields.cliente_idcliente.caption) : null], fields.cliente_idcliente.isInvalid],
            ["validade", [fields.validade.visible && fields.validade.required ? ew.Validators.required(fields.validade.caption) : null, ew.Validators.datetime(fields.validade.clientFormatPattern)], fields.validade.isInvalid],
            ["mes_ano_conv_coletiva", [fields.mes_ano_conv_coletiva.visible && fields.mes_ano_conv_coletiva.required ? ew.Validators.required(fields.mes_ano_conv_coletiva.caption) : null], fields.mes_ano_conv_coletiva.isInvalid],
            ["sindicato", [fields.sindicato.visible && fields.sindicato.required ? ew.Validators.required(fields.sindicato.caption) : null], fields.sindicato.isInvalid],
            ["cidade", [fields.cidade.visible && fields.cidade.required ? ew.Validators.required(fields.cidade.caption) : null], fields.cidade.isInvalid],
            ["nr_meses", [fields.nr_meses.visible && fields.nr_meses.required ? ew.Validators.required(fields.nr_meses.caption) : null], fields.nr_meses.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid]
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
            "cliente_idcliente": <?= $Page->cliente_idcliente->toClientList($Page) ?>,
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
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
<form name="fpropostaadd" id="fpropostaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proposta">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
    <div id="r_cliente_idcliente"<?= $Page->cliente_idcliente->rowAttributes() ?>>
        <label id="elh_proposta_cliente_idcliente" for="x_cliente_idcliente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cliente_idcliente->caption() ?><?= $Page->cliente_idcliente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cliente_idcliente->cellAttributes() ?>>
<span id="el_proposta_cliente_idcliente">
    <select
        id="x_cliente_idcliente"
        name="x_cliente_idcliente"
        class="form-control ew-select<?= $Page->cliente_idcliente->isInvalidClass() ?>"
        data-select2-id="fpropostaadd_x_cliente_idcliente"
        data-table="proposta"
        data-field="x_cliente_idcliente"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->cliente_idcliente->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->cliente_idcliente->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cliente_idcliente->getPlaceHolder()) ?>"
        <?= $Page->cliente_idcliente->editAttributes() ?>>
        <?= $Page->cliente_idcliente->selectOptionListHtml("x_cliente_idcliente") ?>
    </select>
    <?= $Page->cliente_idcliente->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cliente_idcliente->getErrorMessage() ?></div>
<?= $Page->cliente_idcliente->Lookup->getParamTag($Page, "p_x_cliente_idcliente") ?>
<script>
loadjs.ready("fpropostaadd", function() {
    var options = { name: "x_cliente_idcliente", selectId: "fpropostaadd_x_cliente_idcliente" };
    if (fpropostaadd.lists.cliente_idcliente?.lookupOptions.length) {
        options.data = { id: "x_cliente_idcliente", form: "fpropostaadd" };
    } else {
        options.ajax = { id: "x_cliente_idcliente", form: "fpropostaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.proposta.fields.cliente_idcliente.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->validade->Visible) { // validade ?>
    <div id="r_validade"<?= $Page->validade->rowAttributes() ?>>
        <label id="elh_proposta_validade" for="x_validade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validade->caption() ?><?= $Page->validade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->validade->cellAttributes() ?>>
<span id="el_proposta_validade">
<input type="<?= $Page->validade->getInputTextType() ?>" name="x_validade" id="x_validade" data-table="proposta" data-field="x_validade" value="<?= $Page->validade->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->validade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->validade->formatPattern()) ?>"<?= $Page->validade->editAttributes() ?> aria-describedby="x_validade_help">
<?= $Page->validade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->validade->getErrorMessage() ?></div>
<?php if (!$Page->validade->ReadOnly && !$Page->validade->Disabled && !isset($Page->validade->EditAttrs["readonly"]) && !isset($Page->validade->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpropostaadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fpropostaadd", "x_validade", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mes_ano_conv_coletiva->Visible) { // mes_ano_conv_coletiva ?>
    <div id="r_mes_ano_conv_coletiva"<?= $Page->mes_ano_conv_coletiva->rowAttributes() ?>>
        <label id="elh_proposta_mes_ano_conv_coletiva" for="x_mes_ano_conv_coletiva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mes_ano_conv_coletiva->caption() ?><?= $Page->mes_ano_conv_coletiva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mes_ano_conv_coletiva->cellAttributes() ?>>
<span id="el_proposta_mes_ano_conv_coletiva">
<input type="<?= $Page->mes_ano_conv_coletiva->getInputTextType() ?>" name="x_mes_ano_conv_coletiva" id="x_mes_ano_conv_coletiva" data-table="proposta" data-field="x_mes_ano_conv_coletiva" value="<?= $Page->mes_ano_conv_coletiva->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->mes_ano_conv_coletiva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->mes_ano_conv_coletiva->formatPattern()) ?>"<?= $Page->mes_ano_conv_coletiva->editAttributes() ?> aria-describedby="x_mes_ano_conv_coletiva_help">
<?= $Page->mes_ano_conv_coletiva->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mes_ano_conv_coletiva->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sindicato->Visible) { // sindicato ?>
    <div id="r_sindicato"<?= $Page->sindicato->rowAttributes() ?>>
        <label id="elh_proposta_sindicato" for="x_sindicato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sindicato->caption() ?><?= $Page->sindicato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sindicato->cellAttributes() ?>>
<span id="el_proposta_sindicato">
<input type="<?= $Page->sindicato->getInputTextType() ?>" name="x_sindicato" id="x_sindicato" data-table="proposta" data-field="x_sindicato" value="<?= $Page->sindicato->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->sindicato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sindicato->formatPattern()) ?>"<?= $Page->sindicato->editAttributes() ?> aria-describedby="x_sindicato_help">
<?= $Page->sindicato->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sindicato->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
    <div id="r_cidade"<?= $Page->cidade->rowAttributes() ?>>
        <label id="elh_proposta_cidade" for="x_cidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cidade->caption() ?><?= $Page->cidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cidade->cellAttributes() ?>>
<span id="el_proposta_cidade">
<input type="<?= $Page->cidade->getInputTextType() ?>" name="x_cidade" id="x_cidade" data-table="proposta" data-field="x_cidade" value="<?= $Page->cidade->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->cidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cidade->formatPattern()) ?>"<?= $Page->cidade->editAttributes() ?> aria-describedby="x_cidade_help">
<?= $Page->cidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cidade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nr_meses->Visible) { // nr_meses ?>
    <div id="r_nr_meses"<?= $Page->nr_meses->rowAttributes() ?>>
        <label id="elh_proposta_nr_meses" for="x_nr_meses" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nr_meses->caption() ?><?= $Page->nr_meses->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nr_meses->cellAttributes() ?>>
<span id="el_proposta_nr_meses">
<input type="<?= $Page->nr_meses->getInputTextType() ?>" name="x_nr_meses" id="x_nr_meses" data-table="proposta" data-field="x_nr_meses" value="<?= $Page->nr_meses->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->nr_meses->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nr_meses->formatPattern()) ?>"<?= $Page->nr_meses->editAttributes() ?> aria-describedby="x_nr_meses_help">
<?= $Page->nr_meses->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nr_meses->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_proposta_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_proposta_obs">
<textarea data-table="proposta" data-field="x_obs" name="x_obs" id="x_obs" cols="40" rows="3" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help"><?= $Page->obs->EditValue ?></textarea>
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("planilha_custo", explode(",", $Page->getCurrentDetailTable())) && $planilha_custo->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("planilha_custo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PlanilhaCustoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("mov_insumo_cliente", explode(",", $Page->getCurrentDetailTable())) && $mov_insumo_cliente->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("mov_insumo_cliente", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MovInsumoClienteGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fpropostaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fpropostaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("proposta");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
