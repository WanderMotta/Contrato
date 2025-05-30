<?php

namespace PHPMaker2024\contratos;

// Page object
$MovimentoPlaCustoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { movimento_pla_custo: currentTable } });
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
ew.PREVIEW_SELECTOR ??= ".ew-preview-btn";
ew.PREVIEW_TYPE ??= "row";
ew.PREVIEW_NAV_STYLE ??= "tabs"; // tabs/pills/underline
ew.PREVIEW_MODAL_CLASS ??= "modal modal-fullscreen-sm-down";
ew.PREVIEW_ROW ??= true;
ew.PREVIEW_SINGLE_ROW ??= false;
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.min.js?v=24.16.0", "preview");
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
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "planilha_custo") {
    if ($Page->MasterRecordExists) {
        include_once "views/PlanilhaCustoMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "calculo") {
    if ($Page->MasterRecordExists) {
        include_once "views/CalculoMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fmovimento_pla_custosrch" id="fmovimento_pla_custosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fmovimento_pla_custosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { movimento_pla_custo: currentTable } });
var currentForm;
var fmovimento_pla_custosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fmovimento_pla_custosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fmovimento_pla_custosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fmovimento_pla_custosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fmovimento_pla_custosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fmovimento_pla_custosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
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
<input type="hidden" name="t" value="movimento_pla_custo">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "planilha_custo" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="planilha_custo">
<input type="hidden" name="fk_idplanilha_custo" value="<?= HtmlEncode($Page->planilha_custo_idplanilha_custo->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "calculo" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="calculo">
<input type="hidden" name="fk_idcalculo" value="<?= HtmlEncode($Page->calculo_idcalculo->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_movimento_pla_custo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_movimento_pla_custolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
        <th data-name="planilha_custo_idplanilha_custo" class="<?= $Page->planilha_custo_idplanilha_custo->headerCellClass() ?>"><div id="elh_movimento_pla_custo_planilha_custo_idplanilha_custo" class="movimento_pla_custo_planilha_custo_idplanilha_custo"><?= $Page->renderFieldHeader($Page->planilha_custo_idplanilha_custo) ?></div></th>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <th data-name="modulo_idmodulo" class="<?= $Page->modulo_idmodulo->headerCellClass() ?>"><div id="elh_movimento_pla_custo_modulo_idmodulo" class="movimento_pla_custo_modulo_idmodulo"><?= $Page->renderFieldHeader($Page->modulo_idmodulo) ?></div></th>
<?php } ?>
<?php if ($Page->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
        <th data-name="itens_modulo_iditens_modulo" class="<?= $Page->itens_modulo_iditens_modulo->headerCellClass() ?>"><div id="elh_movimento_pla_custo_itens_modulo_iditens_modulo" class="movimento_pla_custo_itens_modulo_iditens_modulo"><?= $Page->renderFieldHeader($Page->itens_modulo_iditens_modulo) ?></div></th>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { // porcentagem ?>
        <th data-name="porcentagem" class="<?= $Page->porcentagem->headerCellClass() ?>"><div id="elh_movimento_pla_custo_porcentagem" class="movimento_pla_custo_porcentagem"><?= $Page->renderFieldHeader($Page->porcentagem) ?></div></th>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <th data-name="valor" class="<?= $Page->valor->headerCellClass() ?>"><div id="elh_movimento_pla_custo_valor" class="movimento_pla_custo_valor"><?= $Page->renderFieldHeader($Page->valor) ?></div></th>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
        <th data-name="obs" class="<?= $Page->obs->headerCellClass() ?>"><div id="elh_movimento_pla_custo_obs" class="movimento_pla_custo_obs"><?= $Page->renderFieldHeader($Page->obs) ?></div></th>
<?php } ?>
<?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
        <th data-name="calculo_idcalculo" class="<?= $Page->calculo_idcalculo->headerCellClass() ?>"><div id="elh_movimento_pla_custo_calculo_idcalculo" class="movimento_pla_custo_calculo_idcalculo"><?= $Page->renderFieldHeader($Page->calculo_idcalculo) ?></div></th>
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
    <?php if ($Page->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
        <td data-name="planilha_custo_idplanilha_custo"<?= $Page->planilha_custo_idplanilha_custo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_movimento_pla_custo_planilha_custo_idplanilha_custo" class="el_movimento_pla_custo_planilha_custo_idplanilha_custo">
<span<?= $Page->planilha_custo_idplanilha_custo->viewAttributes() ?>>
<?= $Page->planilha_custo_idplanilha_custo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <td data-name="modulo_idmodulo"<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_movimento_pla_custo_modulo_idmodulo" class="el_movimento_pla_custo_modulo_idmodulo">
<span<?= $Page->modulo_idmodulo->viewAttributes() ?>>
<?= $Page->modulo_idmodulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
        <td data-name="itens_modulo_iditens_modulo"<?= $Page->itens_modulo_iditens_modulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_movimento_pla_custo_itens_modulo_iditens_modulo" class="el_movimento_pla_custo_itens_modulo_iditens_modulo">
<span<?= $Page->itens_modulo_iditens_modulo->viewAttributes() ?>>
<?= $Page->itens_modulo_iditens_modulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->porcentagem->Visible) { // porcentagem ?>
        <td data-name="porcentagem"<?= $Page->porcentagem->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_movimento_pla_custo_porcentagem" class="el_movimento_pla_custo_porcentagem">
<span<?= $Page->porcentagem->viewAttributes() ?>>
<?= $Page->porcentagem->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->valor->Visible) { // valor ?>
        <td data-name="valor"<?= $Page->valor->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_movimento_pla_custo_valor" class="el_movimento_pla_custo_valor">
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->obs->Visible) { // obs ?>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_movimento_pla_custo_obs" class="el_movimento_pla_custo_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
        <td data-name="calculo_idcalculo"<?= $Page->calculo_idcalculo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_movimento_pla_custo_calculo_idcalculo" class="el_movimento_pla_custo_calculo_idcalculo">
<span<?= $Page->calculo_idcalculo->viewAttributes() ?>>
<?= $Page->calculo_idcalculo->getViewValue() ?></span>
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
    <?php if ($Page->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
        <td data-name="planilha_custo_idplanilha_custo" class="<?= $Page->planilha_custo_idplanilha_custo->footerCellClass() ?>"><span id="elf_movimento_pla_custo_planilha_custo_idplanilha_custo" class="movimento_pla_custo_planilha_custo_idplanilha_custo">
        </span></td>
    <?php } ?>
    <?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <td data-name="modulo_idmodulo" class="<?= $Page->modulo_idmodulo->footerCellClass() ?>"><span id="elf_movimento_pla_custo_modulo_idmodulo" class="movimento_pla_custo_modulo_idmodulo">
        </span></td>
    <?php } ?>
    <?php if ($Page->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
        <td data-name="itens_modulo_iditens_modulo" class="<?= $Page->itens_modulo_iditens_modulo->footerCellClass() ?>"><span id="elf_movimento_pla_custo_itens_modulo_iditens_modulo" class="movimento_pla_custo_itens_modulo_iditens_modulo">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->itens_modulo_iditens_modulo->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->porcentagem->Visible) { // porcentagem ?>
        <td data-name="porcentagem" class="<?= $Page->porcentagem->footerCellClass() ?>"><span id="elf_movimento_pla_custo_porcentagem" class="movimento_pla_custo_porcentagem">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->porcentagem->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->valor->Visible) { // valor ?>
        <td data-name="valor" class="<?= $Page->valor->footerCellClass() ?>"><span id="elf_movimento_pla_custo_valor" class="movimento_pla_custo_valor">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->valor->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->obs->Visible) { // obs ?>
        <td data-name="obs" class="<?= $Page->obs->footerCellClass() ?>"><span id="elf_movimento_pla_custo_obs" class="movimento_pla_custo_obs">
        </span></td>
    <?php } ?>
    <?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
        <td data-name="calculo_idcalculo" class="<?= $Page->calculo_idcalculo->footerCellClass() ?>"><span id="elf_movimento_pla_custo_calculo_idcalculo" class="movimento_pla_custo_calculo_idcalculo">
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
    ew.addEventHandlers("movimento_pla_custo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
