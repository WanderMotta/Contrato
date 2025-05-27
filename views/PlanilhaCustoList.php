<?php

namespace PHPMaker2024\contratos;

// Page object
$PlanilhaCustoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { planilha_custo: currentTable } });
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "proposta") {
    if ($Page->MasterRecordExists) {
        include_once "views/PropostaMaster.php";
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
<input type="hidden" name="t" value="planilha_custo">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "proposta" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="proposta">
<input type="hidden" name="fk_idproposta" value="<?= HtmlEncode($Page->proposta_idproposta->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_planilha_custo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_planilha_custolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
        <th data-name="idplanilha_custo" class="<?= $Page->idplanilha_custo->headerCellClass() ?>"><div id="elh_planilha_custo_idplanilha_custo" class="planilha_custo_idplanilha_custo"><?= $Page->renderFieldHeader($Page->idplanilha_custo) ?></div></th>
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <th data-name="proposta_idproposta" class="<?= $Page->proposta_idproposta->headerCellClass() ?>"><div id="elh_planilha_custo_proposta_idproposta" class="planilha_custo_proposta_idproposta"><?= $Page->renderFieldHeader($Page->proposta_idproposta) ?></div></th>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <th data-name="escala_idescala" class="<?= $Page->escala_idescala->headerCellClass() ?>"><div id="elh_planilha_custo_escala_idescala" class="planilha_custo_escala_idescala"><?= $Page->renderFieldHeader($Page->escala_idescala) ?></div></th>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <th data-name="periodo_idperiodo" class="<?= $Page->periodo_idperiodo->headerCellClass() ?>"><div id="elh_planilha_custo_periodo_idperiodo" class="planilha_custo_periodo_idperiodo"><?= $Page->renderFieldHeader($Page->periodo_idperiodo) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <th data-name="tipo_intrajornada_idtipo_intrajornada" class="<?= $Page->tipo_intrajornada_idtipo_intrajornada->headerCellClass() ?>"><div id="elh_planilha_custo_tipo_intrajornada_idtipo_intrajornada" class="planilha_custo_tipo_intrajornada_idtipo_intrajornada"><?= $Page->renderFieldHeader($Page->tipo_intrajornada_idtipo_intrajornada) ?></div></th>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <th data-name="cargo_idcargo" class="<?= $Page->cargo_idcargo->headerCellClass() ?>"><div id="elh_planilha_custo_cargo_idcargo" class="planilha_custo_cargo_idcargo"><?= $Page->renderFieldHeader($Page->cargo_idcargo) ?></div></th>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <th data-name="acumulo_funcao" class="<?= $Page->acumulo_funcao->headerCellClass() ?>"><div id="elh_planilha_custo_acumulo_funcao" class="planilha_custo_acumulo_funcao"><?= $Page->renderFieldHeader($Page->acumulo_funcao) ?></div></th>
<?php } ?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
        <th data-name="quantidade" class="<?= $Page->quantidade->headerCellClass() ?>"><div id="elh_planilha_custo_quantidade" class="planilha_custo_quantidade"><?= $Page->renderFieldHeader($Page->quantidade) ?></div></th>
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
    <?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
        <td data-name="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_planilha_custo_idplanilha_custo" class="el_planilha_custo_idplanilha_custo">
<span<?= $Page->idplanilha_custo->viewAttributes() ?>>
<?= $Page->idplanilha_custo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <td data-name="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_planilha_custo_proposta_idproposta" class="el_planilha_custo_proposta_idproposta">
<span<?= $Page->proposta_idproposta->viewAttributes() ?>>
<?= $Page->proposta_idproposta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <td data-name="escala_idescala"<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_planilha_custo_escala_idescala" class="el_planilha_custo_escala_idescala">
<span<?= $Page->escala_idescala->viewAttributes() ?>>
<?= $Page->escala_idescala->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <td data-name="periodo_idperiodo"<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_planilha_custo_periodo_idperiodo" class="el_planilha_custo_periodo_idperiodo">
<span<?= $Page->periodo_idperiodo->viewAttributes() ?>>
<?= $Page->periodo_idperiodo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <td data-name="tipo_intrajornada_idtipo_intrajornada"<?= $Page->tipo_intrajornada_idtipo_intrajornada->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_planilha_custo_tipo_intrajornada_idtipo_intrajornada" class="el_planilha_custo_tipo_intrajornada_idtipo_intrajornada">
<span<?= $Page->tipo_intrajornada_idtipo_intrajornada->viewAttributes() ?>>
<?= $Page->tipo_intrajornada_idtipo_intrajornada->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <td data-name="cargo_idcargo"<?= $Page->cargo_idcargo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_planilha_custo_cargo_idcargo" class="el_planilha_custo_cargo_idcargo">
<span<?= $Page->cargo_idcargo->viewAttributes() ?>>
<?= $Page->cargo_idcargo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <td data-name="acumulo_funcao"<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_planilha_custo_acumulo_funcao" class="el_planilha_custo_acumulo_funcao">
<span<?= $Page->acumulo_funcao->viewAttributes() ?>>
<?= $Page->acumulo_funcao->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantidade->Visible) { // quantidade ?>
        <td data-name="quantidade"<?= $Page->quantidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_planilha_custo_quantidade" class="el_planilha_custo_quantidade">
<span<?= $Page->quantidade->viewAttributes() ?>>
<?= $Page->quantidade->getViewValue() ?></span>
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
<?php
// Render aggregate row
$Page->RowType = RowType::AGGREGATE;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->TotalRecords > 0 && !$Page->isGridAdd() && !$Page->isGridEdit() && !$Page->isMultiEdit()) { ?>
<tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (footer, left)
$Page->ListOptions->render("footer", "left");
?>
    <?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
        <td data-name="idplanilha_custo" class="<?= $Page->idplanilha_custo->footerCellClass() ?>"><span id="elf_planilha_custo_idplanilha_custo" class="planilha_custo_idplanilha_custo">
        </span></td>
    <?php } ?>
    <?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <td data-name="proposta_idproposta" class="<?= $Page->proposta_idproposta->footerCellClass() ?>"><span id="elf_planilha_custo_proposta_idproposta" class="planilha_custo_proposta_idproposta">
        </span></td>
    <?php } ?>
    <?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <td data-name="escala_idescala" class="<?= $Page->escala_idescala->footerCellClass() ?>"><span id="elf_planilha_custo_escala_idescala" class="planilha_custo_escala_idescala">
        </span></td>
    <?php } ?>
    <?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <td data-name="periodo_idperiodo" class="<?= $Page->periodo_idperiodo->footerCellClass() ?>"><span id="elf_planilha_custo_periodo_idperiodo" class="planilha_custo_periodo_idperiodo">
        </span></td>
    <?php } ?>
    <?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <td data-name="tipo_intrajornada_idtipo_intrajornada" class="<?= $Page->tipo_intrajornada_idtipo_intrajornada->footerCellClass() ?>"><span id="elf_planilha_custo_tipo_intrajornada_idtipo_intrajornada" class="planilha_custo_tipo_intrajornada_idtipo_intrajornada">
        </span></td>
    <?php } ?>
    <?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <td data-name="cargo_idcargo" class="<?= $Page->cargo_idcargo->footerCellClass() ?>"><span id="elf_planilha_custo_cargo_idcargo" class="planilha_custo_cargo_idcargo">
        </span></td>
    <?php } ?>
    <?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <td data-name="acumulo_funcao" class="<?= $Page->acumulo_funcao->footerCellClass() ?>"><span id="elf_planilha_custo_acumulo_funcao" class="planilha_custo_acumulo_funcao">
        </span></td>
    <?php } ?>
    <?php if ($Page->quantidade->Visible) { // quantidade ?>
        <td data-name="quantidade" class="<?= $Page->quantidade->footerCellClass() ?>"><span id="elf_planilha_custo_quantidade" class="planilha_custo_quantidade">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->quantidade->ViewValue ?></span>
        </span></td>
    <?php } ?>
<?php
// Render list options (footer, right)
$Page->ListOptions->render("footer", "right");
?>
    </tr>
</tfoot>
<?php } ?>
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
    ew.addEventHandlers("planilha_custo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
