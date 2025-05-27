<?php

namespace PHPMaker2024\contratos;

// Page object
$PropostaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposta: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fpropostadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpropostadelete")
        .setPageId("delete")
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
<form name="fpropostadelete" id="fpropostadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proposta">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->idproposta->Visible) { // idproposta ?>
        <th class="<?= $Page->idproposta->headerCellClass() ?>"><span id="elh_proposta_idproposta" class="proposta_idproposta"><?= $Page->idproposta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th class="<?= $Page->dt_cadastro->headerCellClass() ?>"><span id="elh_proposta_dt_cadastro" class="proposta_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <th class="<?= $Page->cliente_idcliente->headerCellClass() ?>"><span id="elh_proposta_cliente_idcliente" class="proposta_cliente_idcliente"><?= $Page->cliente_idcliente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->validade->Visible) { // validade ?>
        <th class="<?= $Page->validade->headerCellClass() ?>"><span id="elh_proposta_validade" class="proposta_validade"><?= $Page->validade->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mes_ano_conv_coletiva->Visible) { // mes_ano_conv_coletiva ?>
        <th class="<?= $Page->mes_ano_conv_coletiva->headerCellClass() ?>"><span id="elh_proposta_mes_ano_conv_coletiva" class="proposta_mes_ano_conv_coletiva"><?= $Page->mes_ano_conv_coletiva->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sindicato->Visible) { // sindicato ?>
        <th class="<?= $Page->sindicato->headerCellClass() ?>"><span id="elh_proposta_sindicato" class="proposta_sindicato"><?= $Page->sindicato->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
        <th class="<?= $Page->cidade->headerCellClass() ?>"><span id="elh_proposta_cidade" class="proposta_cidade"><?= $Page->cidade->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nr_meses->Visible) { // nr_meses ?>
        <th class="<?= $Page->nr_meses->headerCellClass() ?>"><span id="elh_proposta_nr_meses" class="proposta_nr_meses"><?= $Page->nr_meses->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><span id="elh_proposta_usuario_idusuario" class="proposta_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->idproposta->Visible) { // idproposta ?>
        <td<?= $Page->idproposta->cellAttributes() ?>>
<span id="">
<span<?= $Page->idproposta->viewAttributes() ?>>
<?= $Page->idproposta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <td<?= $Page->cliente_idcliente->cellAttributes() ?>>
<span id="">
<span<?= $Page->cliente_idcliente->viewAttributes() ?>>
<?= $Page->cliente_idcliente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->validade->Visible) { // validade ?>
        <td<?= $Page->validade->cellAttributes() ?>>
<span id="">
<span<?= $Page->validade->viewAttributes() ?>>
<?= $Page->validade->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mes_ano_conv_coletiva->Visible) { // mes_ano_conv_coletiva ?>
        <td<?= $Page->mes_ano_conv_coletiva->cellAttributes() ?>>
<span id="">
<span<?= $Page->mes_ano_conv_coletiva->viewAttributes() ?>>
<?= $Page->mes_ano_conv_coletiva->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sindicato->Visible) { // sindicato ?>
        <td<?= $Page->sindicato->cellAttributes() ?>>
<span id="">
<span<?= $Page->sindicato->viewAttributes() ?>>
<?= $Page->sindicato->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
        <td<?= $Page->cidade->cellAttributes() ?>>
<span id="">
<span<?= $Page->cidade->viewAttributes() ?>>
<?= $Page->cidade->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nr_meses->Visible) { // nr_meses ?>
        <td<?= $Page->nr_meses->cellAttributes() ?>>
<span id="">
<span<?= $Page->nr_meses->viewAttributes() ?>>
<?= $Page->nr_meses->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
