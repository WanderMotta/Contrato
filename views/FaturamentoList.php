<?php

namespace PHPMaker2024\contratos;

// Page object
$FaturamentoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { faturamento: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")
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
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "cliente") {
    if ($Page->MasterRecordExists) {
        include_once "views/ClienteMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="faturamento">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "cliente" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="cliente">
<input type="hidden" name="fk_idcliente" value="<?= HtmlEncode($Page->cliente_idcliente->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_faturamento" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_faturamentolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->faturamento->Visible) { // faturamento ?>
        <th data-name="faturamento" class="<?= $Page->faturamento->headerCellClass() ?>"><div id="elh_faturamento_faturamento" class="faturamento_faturamento"><?= $Page->renderFieldHeader($Page->faturamento) ?></div></th>
<?php } ?>
<?php if ($Page->cnpj->Visible) { // cnpj ?>
        <th data-name="cnpj" class="<?= $Page->cnpj->headerCellClass() ?>"><div id="elh_faturamento_cnpj" class="faturamento_cnpj"><?= $Page->renderFieldHeader($Page->cnpj) ?></div></th>
<?php } ?>
<?php if ($Page->endereco->Visible) { // endereco ?>
        <th data-name="endereco" class="<?= $Page->endereco->headerCellClass() ?>"><div id="elh_faturamento_endereco" class="faturamento_endereco"><?= $Page->renderFieldHeader($Page->endereco) ?></div></th>
<?php } ?>
<?php if ($Page->bairro->Visible) { // bairro ?>
        <th data-name="bairro" class="<?= $Page->bairro->headerCellClass() ?>"><div id="elh_faturamento_bairro" class="faturamento_bairro"><?= $Page->renderFieldHeader($Page->bairro) ?></div></th>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
        <th data-name="cidade" class="<?= $Page->cidade->headerCellClass() ?>"><div id="elh_faturamento_cidade" class="faturamento_cidade"><?= $Page->renderFieldHeader($Page->cidade) ?></div></th>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
        <th data-name="uf" class="<?= $Page->uf->headerCellClass() ?>"><div id="elh_faturamento_uf" class="faturamento_uf"><?= $Page->renderFieldHeader($Page->uf) ?></div></th>
<?php } ?>
<?php if ($Page->dia_vencimento->Visible) { // dia_vencimento ?>
        <th data-name="dia_vencimento" class="<?= $Page->dia_vencimento->headerCellClass() ?>"><div id="elh_faturamento_dia_vencimento" class="faturamento_dia_vencimento"><?= $Page->renderFieldHeader($Page->dia_vencimento) ?></div></th>
<?php } ?>
<?php if ($Page->origem->Visible) { // origem ?>
        <th data-name="origem" class="<?= $Page->origem->headerCellClass() ?>"><div id="elh_faturamento_origem" class="faturamento_origem"><?= $Page->renderFieldHeader($Page->origem) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
$isInlineAddOrCopy = ($Page->isCopy() || $Page->isAdd());
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Page->RowIndex == 0) {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        !($isInlineAddOrCopy && $Page->RowIndex == 0)
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->faturamento->Visible) { // faturamento ?>
        <td data-name="faturamento"<?= $Page->faturamento->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_faturamento_faturamento" class="el_faturamento_faturamento">
<span<?= $Page->faturamento->viewAttributes() ?>>
<?= $Page->faturamento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cnpj->Visible) { // cnpj ?>
        <td data-name="cnpj"<?= $Page->cnpj->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_faturamento_cnpj" class="el_faturamento_cnpj">
<span<?= $Page->cnpj->viewAttributes() ?>>
<?= $Page->cnpj->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->endereco->Visible) { // endereco ?>
        <td data-name="endereco"<?= $Page->endereco->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_faturamento_endereco" class="el_faturamento_endereco">
<span<?= $Page->endereco->viewAttributes() ?>>
<?= $Page->endereco->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bairro->Visible) { // bairro ?>
        <td data-name="bairro"<?= $Page->bairro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_faturamento_bairro" class="el_faturamento_bairro">
<span<?= $Page->bairro->viewAttributes() ?>>
<?= $Page->bairro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cidade->Visible) { // cidade ?>
        <td data-name="cidade"<?= $Page->cidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_faturamento_cidade" class="el_faturamento_cidade">
<span<?= $Page->cidade->viewAttributes() ?>>
<?= $Page->cidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uf->Visible) { // uf ?>
        <td data-name="uf"<?= $Page->uf->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_faturamento_uf" class="el_faturamento_uf">
<span<?= $Page->uf->viewAttributes() ?>>
<?= $Page->uf->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dia_vencimento->Visible) { // dia_vencimento ?>
        <td data-name="dia_vencimento"<?= $Page->dia_vencimento->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_faturamento_dia_vencimento" class="el_faturamento_dia_vencimento">
<span<?= $Page->dia_vencimento->viewAttributes() ?>>
<?= $Page->dia_vencimento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->origem->Visible) { // origem ?>
        <td data-name="origem"<?= $Page->origem->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_faturamento_origem" class="el_faturamento_origem">
<span<?= $Page->origem->viewAttributes() ?>>
<?= $Page->origem->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
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
<?php } ?>
