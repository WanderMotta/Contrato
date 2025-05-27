<?php

namespace PHPMaker2024\contratos;

// Page object
$UsuarioView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<form name="fusuarioview" id="fusuarioview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { usuario: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fusuarioview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fusuarioview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="usuario">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idusuario->Visible) { // idusuario ?>
    <tr id="r_idusuario"<?= $Page->idusuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_usuario_idusuario"><?= $Page->idusuario->caption() ?></span></td>
        <td data-name="idusuario"<?= $Page->idusuario->cellAttributes() ?>>
<span id="el_usuario_idusuario">
<span<?= $Page->idusuario->viewAttributes() ?>>
<?= $Page->idusuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
    <tr id="r__login"<?= $Page->_login->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_usuario__login"><?= $Page->_login->caption() ?></span></td>
        <td data-name="_login"<?= $Page->_login->cellAttributes() ?>>
<span id="el_usuario__login">
<span<?= $Page->_login->viewAttributes() ?>>
<?= $Page->_login->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->senha->Visible) { // senha ?>
    <tr id="r_senha"<?= $Page->senha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_usuario_senha"><?= $Page->senha->caption() ?></span></td>
        <td data-name="senha"<?= $Page->senha->cellAttributes() ?>>
<span id="el_usuario_senha">
<span<?= $Page->senha->viewAttributes() ?>>
<?= $Page->senha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_userlevel->Visible) { // userlevel ?>
    <tr id="r__userlevel"<?= $Page->_userlevel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_usuario__userlevel"><?= $Page->_userlevel->caption() ?></span></td>
        <td data-name="_userlevel"<?= $Page->_userlevel->cellAttributes() ?>>
<span id="el_usuario__userlevel">
<span<?= $Page->_userlevel->viewAttributes() ?>>
<?= $Page->_userlevel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <tr id="r_ativo"<?= $Page->ativo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_usuario_ativo"><?= $Page->ativo->caption() ?></span></td>
        <td data-name="ativo"<?= $Page->ativo->cellAttributes() ?>>
<span id="el_usuario_ativo">
<span<?= $Page->ativo->viewAttributes() ?>>
<?= $Page->ativo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
