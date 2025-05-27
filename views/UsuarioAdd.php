<?php

namespace PHPMaker2024\contratos;

// Page object
$UsuarioAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { usuario: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fusuarioadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fusuarioadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["_login", [fields._login.visible && fields._login.required ? ew.Validators.required(fields._login.caption) : null], fields._login.isInvalid],
            ["senha", [fields.senha.visible && fields.senha.required ? ew.Validators.required(fields.senha.caption) : null], fields.senha.isInvalid],
            ["_userlevel", [fields._userlevel.visible && fields._userlevel.required ? ew.Validators.required(fields._userlevel.caption) : null], fields._userlevel.isInvalid]
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
            "_userlevel": <?= $Page->_userlevel->toClientList($Page) ?>,
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
<form name="fusuarioadd" id="fusuarioadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="usuario">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->_login->Visible) { // login ?>
    <div id="r__login"<?= $Page->_login->rowAttributes() ?>>
        <label id="elh_usuario__login" for="x__login" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_login->caption() ?><?= $Page->_login->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_login->cellAttributes() ?>>
<span id="el_usuario__login">
<input type="<?= $Page->_login->getInputTextType() ?>" name="x__login" id="x__login" data-table="usuario" data-field="x__login" value="<?= $Page->_login->EditValue ?>" size="30" maxlength="35" placeholder="<?= HtmlEncode($Page->_login->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_login->formatPattern()) ?>"<?= $Page->_login->editAttributes() ?> aria-describedby="x__login_help">
<?= $Page->_login->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_login->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->senha->Visible) { // senha ?>
    <div id="r_senha"<?= $Page->senha->rowAttributes() ?>>
        <label id="elh_usuario_senha" for="x_senha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->senha->caption() ?><?= $Page->senha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->senha->cellAttributes() ?>>
<span id="el_usuario_senha">
<div class="input-group">
    <input type="password" name="x_senha" id="x_senha" autocomplete="new-password" data-table="usuario" data-field="x_senha" size="25" maxlength="25" placeholder="<?= HtmlEncode($Page->senha->getPlaceHolder()) ?>"<?= $Page->senha->editAttributes() ?> aria-describedby="x_senha_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
</div>
<?= $Page->senha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->senha->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_userlevel->Visible) { // userlevel ?>
    <div id="r__userlevel"<?= $Page->_userlevel->rowAttributes() ?>>
        <label id="elh_usuario__userlevel" for="x__userlevel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_userlevel->caption() ?><?= $Page->_userlevel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_userlevel->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_usuario__userlevel">
<span class="form-control-plaintext"><?= $Page->_userlevel->getDisplayValue($Page->_userlevel->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_usuario__userlevel">
    <select
        id="x__userlevel"
        name="x__userlevel"
        class="form-select ew-select<?= $Page->_userlevel->isInvalidClass() ?>"
        <?php if (!$Page->_userlevel->IsNativeSelect) { ?>
        data-select2-id="fusuarioadd_x__userlevel"
        <?php } ?>
        data-table="usuario"
        data-field="x__userlevel"
        data-value-separator="<?= $Page->_userlevel->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_userlevel->getPlaceHolder()) ?>"
        <?= $Page->_userlevel->editAttributes() ?>>
        <?= $Page->_userlevel->selectOptionListHtml("x__userlevel") ?>
    </select>
    <?= $Page->_userlevel->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->_userlevel->getErrorMessage() ?></div>
<?= $Page->_userlevel->Lookup->getParamTag($Page, "p_x__userlevel") ?>
<?php if (!$Page->_userlevel->IsNativeSelect) { ?>
<script>
loadjs.ready("fusuarioadd", function() {
    var options = { name: "x__userlevel", selectId: "fusuarioadd_x__userlevel" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusuarioadd.lists._userlevel?.lookupOptions.length) {
        options.data = { id: "x__userlevel", form: "fusuarioadd" };
    } else {
        options.ajax = { id: "x__userlevel", form: "fusuarioadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.usuario.fields._userlevel.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fusuarioadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fusuarioadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("usuario");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
