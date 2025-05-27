<?php

namespace PHPMaker2024\contratos;

// Page object
$ClienteAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cliente: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fclienteadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fclienteadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["cliente", [fields.cliente.visible && fields.cliente.required ? ew.Validators.required(fields.cliente.caption) : null], fields.cliente.isInvalid],
            ["local_idlocal", [fields.local_idlocal.visible && fields.local_idlocal.required ? ew.Validators.required(fields.local_idlocal.caption) : null], fields.local_idlocal.isInvalid],
            ["cnpj", [fields.cnpj.visible && fields.cnpj.required ? ew.Validators.required(fields.cnpj.caption) : null], fields.cnpj.isInvalid],
            ["endereco", [fields.endereco.visible && fields.endereco.required ? ew.Validators.required(fields.endereco.caption) : null], fields.endereco.isInvalid],
            ["numero", [fields.numero.visible && fields.numero.required ? ew.Validators.required(fields.numero.caption) : null], fields.numero.isInvalid],
            ["bairro", [fields.bairro.visible && fields.bairro.required ? ew.Validators.required(fields.bairro.caption) : null], fields.bairro.isInvalid],
            ["cep", [fields.cep.visible && fields.cep.required ? ew.Validators.required(fields.cep.caption) : null], fields.cep.isInvalid],
            ["cidade", [fields.cidade.visible && fields.cidade.required ? ew.Validators.required(fields.cidade.caption) : null], fields.cidade.isInvalid],
            ["uf", [fields.uf.visible && fields.uf.required ? ew.Validators.required(fields.uf.caption) : null], fields.uf.isInvalid],
            ["contato", [fields.contato.visible && fields.contato.required ? ew.Validators.required(fields.contato.caption) : null], fields.contato.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
            ["telefone", [fields.telefone.visible && fields.telefone.required ? ew.Validators.required(fields.telefone.caption) : null], fields.telefone.isInvalid]
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
            "local_idlocal": <?= $Page->local_idlocal->toClientList($Page) ?>,
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
<form name="fclienteadd" id="fclienteadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cliente">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->cliente->Visible) { // cliente ?>
    <div id="r_cliente"<?= $Page->cliente->rowAttributes() ?>>
        <label id="elh_cliente_cliente" for="x_cliente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cliente->caption() ?><?= $Page->cliente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cliente->cellAttributes() ?>>
<span id="el_cliente_cliente">
<input type="<?= $Page->cliente->getInputTextType() ?>" name="x_cliente" id="x_cliente" data-table="cliente" data-field="x_cliente" value="<?= $Page->cliente->EditValue ?>" size="80" maxlength="150" placeholder="<?= HtmlEncode($Page->cliente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cliente->formatPattern()) ?>"<?= $Page->cliente->editAttributes() ?> aria-describedby="x_cliente_help">
<?= $Page->cliente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cliente->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->local_idlocal->Visible) { // local_idlocal ?>
    <div id="r_local_idlocal"<?= $Page->local_idlocal->rowAttributes() ?>>
        <label id="elh_cliente_local_idlocal" for="x_local_idlocal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->local_idlocal->caption() ?><?= $Page->local_idlocal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->local_idlocal->cellAttributes() ?>>
<span id="el_cliente_local_idlocal">
    <select
        id="x_local_idlocal"
        name="x_local_idlocal"
        class="form-control ew-select<?= $Page->local_idlocal->isInvalidClass() ?>"
        data-select2-id="fclienteadd_x_local_idlocal"
        data-table="cliente"
        data-field="x_local_idlocal"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->local_idlocal->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->local_idlocal->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->local_idlocal->getPlaceHolder()) ?>"
        <?= $Page->local_idlocal->editAttributes() ?>>
        <?= $Page->local_idlocal->selectOptionListHtml("x_local_idlocal") ?>
    </select>
    <?= $Page->local_idlocal->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->local_idlocal->getErrorMessage() ?></div>
<?= $Page->local_idlocal->Lookup->getParamTag($Page, "p_x_local_idlocal") ?>
<script>
loadjs.ready("fclienteadd", function() {
    var options = { name: "x_local_idlocal", selectId: "fclienteadd_x_local_idlocal" };
    if (fclienteadd.lists.local_idlocal?.lookupOptions.length) {
        options.data = { id: "x_local_idlocal", form: "fclienteadd" };
    } else {
        options.ajax = { id: "x_local_idlocal", form: "fclienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.cliente.fields.local_idlocal.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cnpj->Visible) { // cnpj ?>
    <div id="r_cnpj"<?= $Page->cnpj->rowAttributes() ?>>
        <label id="elh_cliente_cnpj" for="x_cnpj" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cnpj->caption() ?><?= $Page->cnpj->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cnpj->cellAttributes() ?>>
<span id="el_cliente_cnpj">
<input type="<?= $Page->cnpj->getInputTextType() ?>" name="x_cnpj" id="x_cnpj" data-table="cliente" data-field="x_cnpj" value="<?= $Page->cnpj->EditValue ?>" size="18" maxlength="18" placeholder="<?= HtmlEncode($Page->cnpj->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cnpj->formatPattern()) ?>"<?= $Page->cnpj->editAttributes() ?> aria-describedby="x_cnpj_help">
<?= $Page->cnpj->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cnpj->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->endereco->Visible) { // endereco ?>
    <div id="r_endereco"<?= $Page->endereco->rowAttributes() ?>>
        <label id="elh_cliente_endereco" for="x_endereco" class="<?= $Page->LeftColumnClass ?>"><?= $Page->endereco->caption() ?><?= $Page->endereco->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->endereco->cellAttributes() ?>>
<span id="el_cliente_endereco">
<input type="<?= $Page->endereco->getInputTextType() ?>" name="x_endereco" id="x_endereco" data-table="cliente" data-field="x_endereco" value="<?= $Page->endereco->EditValue ?>" size="50" maxlength="150" placeholder="<?= HtmlEncode($Page->endereco->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->endereco->formatPattern()) ?>"<?= $Page->endereco->editAttributes() ?> aria-describedby="x_endereco_help">
<?= $Page->endereco->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->endereco->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->numero->Visible) { // numero ?>
    <div id="r_numero"<?= $Page->numero->rowAttributes() ?>>
        <label id="elh_cliente_numero" for="x_numero" class="<?= $Page->LeftColumnClass ?>"><?= $Page->numero->caption() ?><?= $Page->numero->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->numero->cellAttributes() ?>>
<span id="el_cliente_numero">
<input type="<?= $Page->numero->getInputTextType() ?>" name="x_numero" id="x_numero" data-table="cliente" data-field="x_numero" value="<?= $Page->numero->EditValue ?>" size="5" maxlength="5" placeholder="<?= HtmlEncode($Page->numero->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->numero->formatPattern()) ?>"<?= $Page->numero->editAttributes() ?> aria-describedby="x_numero_help">
<?= $Page->numero->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->numero->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bairro->Visible) { // bairro ?>
    <div id="r_bairro"<?= $Page->bairro->rowAttributes() ?>>
        <label id="elh_cliente_bairro" for="x_bairro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bairro->caption() ?><?= $Page->bairro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->bairro->cellAttributes() ?>>
<span id="el_cliente_bairro">
<input type="<?= $Page->bairro->getInputTextType() ?>" name="x_bairro" id="x_bairro" data-table="cliente" data-field="x_bairro" value="<?= $Page->bairro->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->bairro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->bairro->formatPattern()) ?>"<?= $Page->bairro->editAttributes() ?> aria-describedby="x_bairro_help">
<?= $Page->bairro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bairro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cep->Visible) { // cep ?>
    <div id="r_cep"<?= $Page->cep->rowAttributes() ?>>
        <label id="elh_cliente_cep" for="x_cep" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cep->caption() ?><?= $Page->cep->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cep->cellAttributes() ?>>
<span id="el_cliente_cep">
<input type="<?= $Page->cep->getInputTextType() ?>" name="x_cep" id="x_cep" data-table="cliente" data-field="x_cep" value="<?= $Page->cep->EditValue ?>" size="9" maxlength="9" placeholder="<?= HtmlEncode($Page->cep->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cep->formatPattern()) ?>"<?= $Page->cep->editAttributes() ?> aria-describedby="x_cep_help">
<?= $Page->cep->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cep->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
    <div id="r_cidade"<?= $Page->cidade->rowAttributes() ?>>
        <label id="elh_cliente_cidade" for="x_cidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cidade->caption() ?><?= $Page->cidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cidade->cellAttributes() ?>>
<span id="el_cliente_cidade">
<input type="<?= $Page->cidade->getInputTextType() ?>" name="x_cidade" id="x_cidade" data-table="cliente" data-field="x_cidade" value="<?= $Page->cidade->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->cidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cidade->formatPattern()) ?>"<?= $Page->cidade->editAttributes() ?> aria-describedby="x_cidade_help">
<?= $Page->cidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cidade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
    <div id="r_uf"<?= $Page->uf->rowAttributes() ?>>
        <label id="elh_cliente_uf" for="x_uf" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uf->caption() ?><?= $Page->uf->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uf->cellAttributes() ?>>
<span id="el_cliente_uf">
<input type="<?= $Page->uf->getInputTextType() ?>" name="x_uf" id="x_uf" data-table="cliente" data-field="x_uf" value="<?= $Page->uf->EditValue ?>" size="2" maxlength="2" placeholder="<?= HtmlEncode($Page->uf->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->uf->formatPattern()) ?>"<?= $Page->uf->editAttributes() ?> aria-describedby="x_uf_help">
<?= $Page->uf->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uf->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contato->Visible) { // contato ?>
    <div id="r_contato"<?= $Page->contato->rowAttributes() ?>>
        <label id="elh_cliente_contato" for="x_contato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contato->caption() ?><?= $Page->contato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contato->cellAttributes() ?>>
<span id="el_cliente_contato">
<input type="<?= $Page->contato->getInputTextType() ?>" name="x_contato" id="x_contato" data-table="cliente" data-field="x_contato" value="<?= $Page->contato->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->contato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contato->formatPattern()) ?>"<?= $Page->contato->editAttributes() ?> aria-describedby="x_contato_help">
<?= $Page->contato->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contato->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_cliente__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_cliente__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="cliente" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefone->Visible) { // telefone ?>
    <div id="r_telefone"<?= $Page->telefone->rowAttributes() ?>>
        <label id="elh_cliente_telefone" for="x_telefone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefone->caption() ?><?= $Page->telefone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefone->cellAttributes() ?>>
<span id="el_cliente_telefone">
<input type="<?= $Page->telefone->getInputTextType() ?>" name="x_telefone" id="x_telefone" data-table="cliente" data-field="x_telefone" value="<?= $Page->telefone->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->telefone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefone->formatPattern()) ?>"<?= $Page->telefone->editAttributes() ?> aria-describedby="x_telefone_help">
<?= $Page->telefone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("faturamento", explode(",", $Page->getCurrentDetailTable())) && $faturamento->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("faturamento", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FaturamentoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fclienteadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fclienteadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("cliente");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
