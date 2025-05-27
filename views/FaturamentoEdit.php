<?php

namespace PHPMaker2024\contratos;

// Page object
$FaturamentoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ffaturamentoedit" id="ffaturamentoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { faturamento: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ffaturamentoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffaturamentoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idfaturamento", [fields.idfaturamento.visible && fields.idfaturamento.required ? ew.Validators.required(fields.idfaturamento.caption) : null], fields.idfaturamento.isInvalid],
            ["faturamento", [fields.faturamento.visible && fields.faturamento.required ? ew.Validators.required(fields.faturamento.caption) : null], fields.faturamento.isInvalid],
            ["cnpj", [fields.cnpj.visible && fields.cnpj.required ? ew.Validators.required(fields.cnpj.caption) : null], fields.cnpj.isInvalid],
            ["endereco", [fields.endereco.visible && fields.endereco.required ? ew.Validators.required(fields.endereco.caption) : null], fields.endereco.isInvalid],
            ["bairro", [fields.bairro.visible && fields.bairro.required ? ew.Validators.required(fields.bairro.caption) : null], fields.bairro.isInvalid],
            ["cidade", [fields.cidade.visible && fields.cidade.required ? ew.Validators.required(fields.cidade.caption) : null], fields.cidade.isInvalid],
            ["uf", [fields.uf.visible && fields.uf.required ? ew.Validators.required(fields.uf.caption) : null], fields.uf.isInvalid],
            ["dia_vencimento", [fields.dia_vencimento.visible && fields.dia_vencimento.required ? ew.Validators.required(fields.dia_vencimento.caption) : null, ew.Validators.range(1, 30)], fields.dia_vencimento.isInvalid],
            ["origem", [fields.origem.visible && fields.origem.required ? ew.Validators.required(fields.origem.caption) : null], fields.origem.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
            ["cliente_idcliente", [fields.cliente_idcliente.visible && fields.cliente_idcliente.required ? ew.Validators.required(fields.cliente_idcliente.caption) : null, ew.Validators.integer], fields.cliente_idcliente.isInvalid]
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
            "origem": <?= $Page->origem->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="faturamento">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "cliente") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="cliente">
<input type="hidden" name="fk_idcliente" value="<?= HtmlEncode($Page->cliente_idcliente->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idfaturamento->Visible) { // idfaturamento ?>
    <div id="r_idfaturamento"<?= $Page->idfaturamento->rowAttributes() ?>>
        <label id="elh_faturamento_idfaturamento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idfaturamento->caption() ?><?= $Page->idfaturamento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idfaturamento->cellAttributes() ?>>
<span id="el_faturamento_idfaturamento">
<span<?= $Page->idfaturamento->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idfaturamento->getDisplayValue($Page->idfaturamento->EditValue))) ?>"></span>
<input type="hidden" data-table="faturamento" data-field="x_idfaturamento" data-hidden="1" name="x_idfaturamento" id="x_idfaturamento" value="<?= HtmlEncode($Page->idfaturamento->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->faturamento->Visible) { // faturamento ?>
    <div id="r_faturamento"<?= $Page->faturamento->rowAttributes() ?>>
        <label id="elh_faturamento_faturamento" for="x_faturamento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->faturamento->caption() ?><?= $Page->faturamento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->faturamento->cellAttributes() ?>>
<span id="el_faturamento_faturamento">
<input type="<?= $Page->faturamento->getInputTextType() ?>" name="x_faturamento" id="x_faturamento" data-table="faturamento" data-field="x_faturamento" value="<?= $Page->faturamento->EditValue ?>" size="50" maxlength="150" placeholder="<?= HtmlEncode($Page->faturamento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->faturamento->formatPattern()) ?>"<?= $Page->faturamento->editAttributes() ?> aria-describedby="x_faturamento_help">
<?= $Page->faturamento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->faturamento->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cnpj->Visible) { // cnpj ?>
    <div id="r_cnpj"<?= $Page->cnpj->rowAttributes() ?>>
        <label id="elh_faturamento_cnpj" for="x_cnpj" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cnpj->caption() ?><?= $Page->cnpj->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cnpj->cellAttributes() ?>>
<span id="el_faturamento_cnpj">
<input type="<?= $Page->cnpj->getInputTextType() ?>" name="x_cnpj" id="x_cnpj" data-table="faturamento" data-field="x_cnpj" value="<?= $Page->cnpj->EditValue ?>" size="18" maxlength="18" placeholder="<?= HtmlEncode($Page->cnpj->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cnpj->formatPattern()) ?>"<?= $Page->cnpj->editAttributes() ?> aria-describedby="x_cnpj_help">
<?= $Page->cnpj->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cnpj->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->endereco->Visible) { // endereco ?>
    <div id="r_endereco"<?= $Page->endereco->rowAttributes() ?>>
        <label id="elh_faturamento_endereco" for="x_endereco" class="<?= $Page->LeftColumnClass ?>"><?= $Page->endereco->caption() ?><?= $Page->endereco->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->endereco->cellAttributes() ?>>
<span id="el_faturamento_endereco">
<input type="<?= $Page->endereco->getInputTextType() ?>" name="x_endereco" id="x_endereco" data-table="faturamento" data-field="x_endereco" value="<?= $Page->endereco->EditValue ?>" size="50" maxlength="150" placeholder="<?= HtmlEncode($Page->endereco->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->endereco->formatPattern()) ?>"<?= $Page->endereco->editAttributes() ?> aria-describedby="x_endereco_help">
<?= $Page->endereco->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->endereco->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bairro->Visible) { // bairro ?>
    <div id="r_bairro"<?= $Page->bairro->rowAttributes() ?>>
        <label id="elh_faturamento_bairro" for="x_bairro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bairro->caption() ?><?= $Page->bairro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->bairro->cellAttributes() ?>>
<span id="el_faturamento_bairro">
<input type="<?= $Page->bairro->getInputTextType() ?>" name="x_bairro" id="x_bairro" data-table="faturamento" data-field="x_bairro" value="<?= $Page->bairro->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->bairro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->bairro->formatPattern()) ?>"<?= $Page->bairro->editAttributes() ?> aria-describedby="x_bairro_help">
<?= $Page->bairro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bairro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
    <div id="r_cidade"<?= $Page->cidade->rowAttributes() ?>>
        <label id="elh_faturamento_cidade" for="x_cidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cidade->caption() ?><?= $Page->cidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cidade->cellAttributes() ?>>
<span id="el_faturamento_cidade">
<input type="<?= $Page->cidade->getInputTextType() ?>" name="x_cidade" id="x_cidade" data-table="faturamento" data-field="x_cidade" value="<?= $Page->cidade->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->cidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cidade->formatPattern()) ?>"<?= $Page->cidade->editAttributes() ?> aria-describedby="x_cidade_help">
<?= $Page->cidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cidade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
    <div id="r_uf"<?= $Page->uf->rowAttributes() ?>>
        <label id="elh_faturamento_uf" for="x_uf" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uf->caption() ?><?= $Page->uf->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uf->cellAttributes() ?>>
<span id="el_faturamento_uf">
<input type="<?= $Page->uf->getInputTextType() ?>" name="x_uf" id="x_uf" data-table="faturamento" data-field="x_uf" value="<?= $Page->uf->EditValue ?>" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->uf->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->uf->formatPattern()) ?>"<?= $Page->uf->editAttributes() ?> aria-describedby="x_uf_help">
<?= $Page->uf->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uf->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dia_vencimento->Visible) { // dia_vencimento ?>
    <div id="r_dia_vencimento"<?= $Page->dia_vencimento->rowAttributes() ?>>
        <label id="elh_faturamento_dia_vencimento" for="x_dia_vencimento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dia_vencimento->caption() ?><?= $Page->dia_vencimento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dia_vencimento->cellAttributes() ?>>
<span id="el_faturamento_dia_vencimento">
<input type="<?= $Page->dia_vencimento->getInputTextType() ?>" name="x_dia_vencimento" id="x_dia_vencimento" data-table="faturamento" data-field="x_dia_vencimento" value="<?= $Page->dia_vencimento->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->dia_vencimento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dia_vencimento->formatPattern()) ?>"<?= $Page->dia_vencimento->editAttributes() ?> aria-describedby="x_dia_vencimento_help">
<?= $Page->dia_vencimento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dia_vencimento->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->origem->Visible) { // origem ?>
    <div id="r_origem"<?= $Page->origem->rowAttributes() ?>>
        <label id="elh_faturamento_origem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->origem->caption() ?><?= $Page->origem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->origem->cellAttributes() ?>>
<span id="el_faturamento_origem">
<template id="tp_x_origem">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="faturamento" data-field="x_origem" name="x_origem" id="x_origem"<?= $Page->origem->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_origem" class="ew-item-list"></div>
<selection-list hidden
    id="x_origem"
    name="x_origem"
    value="<?= HtmlEncode($Page->origem->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_origem"
    data-target="dsl_x_origem"
    data-repeatcolumn="5"
    class="form-control<?= $Page->origem->isInvalidClass() ?>"
    data-table="faturamento"
    data-field="x_origem"
    data-value-separator="<?= $Page->origem->displayValueSeparatorAttribute() ?>"
    <?= $Page->origem->editAttributes() ?>></selection-list>
<?= $Page->origem->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->origem->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_faturamento_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_faturamento_obs">
<textarea data-table="faturamento" data-field="x_obs" name="x_obs" id="x_obs" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help"><?= $Page->obs->EditValue ?></textarea>
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
    <div id="r_cliente_idcliente"<?= $Page->cliente_idcliente->rowAttributes() ?>>
        <label id="elh_faturamento_cliente_idcliente" for="x_cliente_idcliente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cliente_idcliente->caption() ?><?= $Page->cliente_idcliente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cliente_idcliente->cellAttributes() ?>>
<?php if ($Page->cliente_idcliente->getSessionValue() != "") { ?>
<span id="el_faturamento_cliente_idcliente">
<span<?= $Page->cliente_idcliente->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cliente_idcliente->getDisplayValue($Page->cliente_idcliente->ViewValue))) ?>"></span>
<input type="hidden" id="x_cliente_idcliente" name="x_cliente_idcliente" value="<?= HtmlEncode($Page->cliente_idcliente->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_faturamento_cliente_idcliente">
<input type="<?= $Page->cliente_idcliente->getInputTextType() ?>" name="x_cliente_idcliente" id="x_cliente_idcliente" data-table="faturamento" data-field="x_cliente_idcliente" value="<?= $Page->cliente_idcliente->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->cliente_idcliente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cliente_idcliente->formatPattern()) ?>"<?= $Page->cliente_idcliente->editAttributes() ?> aria-describedby="x_cliente_idcliente_help">
<?= $Page->cliente_idcliente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cliente_idcliente->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("contato", explode(",", $Page->getCurrentDetailTable())) && $contato->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("contato", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ContatoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffaturamentoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ffaturamentoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("faturamento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
