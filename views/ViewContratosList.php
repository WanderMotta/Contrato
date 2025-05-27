<?php

namespace PHPMaker2024\contratos;

// Page object
$ViewContratosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_contratos: currentTable } });
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
<?php if (!$Page->IsModal) { ?>
<form name="fview_contratossrch" id="fview_contratossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_contratossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_contratos: currentTable } });
var currentForm;
var fview_contratossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_contratossrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_contratossrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_contratossrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_contratossrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_contratossrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_contratos">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_contratos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_contratoslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->idcontrato->Visible) { // idcontrato ?>
        <th data-name="idcontrato" class="<?= $Page->idcontrato->headerCellClass() ?>"><div id="elh_view_contratos_idcontrato" class="view_contratos_idcontrato"><?= $Page->renderFieldHeader($Page->idcontrato) ?></div></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div id="elh_view_contratos_cliente" class="view_contratos_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <th data-name="valor" class="<?= $Page->valor->headerCellClass() ?>"><div id="elh_view_contratos_valor" class="view_contratos_valor"><?= $Page->renderFieldHeader($Page->valor) ?></div></th>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <th data-name="ativo" class="<?= $Page->ativo->headerCellClass() ?>"><div id="elh_view_contratos_ativo" class="view_contratos_ativo"><?= $Page->renderFieldHeader($Page->ativo) ?></div></th>
<?php } ?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
        <th data-name="quantidade" class="<?= $Page->quantidade->headerCellClass() ?>"><div id="elh_view_contratos_quantidade" class="view_contratos_quantidade"><?= $Page->renderFieldHeader($Page->quantidade) ?></div></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
        <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div id="elh_view_contratos_cargo" class="view_contratos_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <th data-name="acumulo_funcao" class="<?= $Page->acumulo_funcao->headerCellClass() ?>"><div id="elh_view_contratos_acumulo_funcao" class="view_contratos_acumulo_funcao"><?= $Page->renderFieldHeader($Page->acumulo_funcao) ?></div></th>
<?php } ?>
<?php if ($Page->escala->Visible) { // escala ?>
        <th data-name="escala" class="<?= $Page->escala->headerCellClass() ?>"><div id="elh_view_contratos_escala" class="view_contratos_escala"><?= $Page->renderFieldHeader($Page->escala) ?></div></th>
<?php } ?>
<?php if ($Page->periodo->Visible) { // periodo ?>
        <th data-name="periodo" class="<?= $Page->periodo->headerCellClass() ?>"><div id="elh_view_contratos_periodo" class="view_contratos_periodo"><?= $Page->renderFieldHeader($Page->periodo) ?></div></th>
<?php } ?>
<?php if ($Page->jornada->Visible) { // jornada ?>
        <th data-name="jornada" class="<?= $Page->jornada->headerCellClass() ?>"><div id="elh_view_contratos_jornada" class="view_contratos_jornada"><?= $Page->renderFieldHeader($Page->jornada) ?></div></th>
<?php } ?>
<?php if ($Page->salario->Visible) { // salario ?>
        <th data-name="salario" class="<?= $Page->salario->headerCellClass() ?>"><div id="elh_view_contratos_salario" class="view_contratos_salario"><?= $Page->renderFieldHeader($Page->salario) ?></div></th>
<?php } ?>
<?php if ($Page->intrajornada_tipo->Visible) { // intrajornada_tipo ?>
        <th data-name="intrajornada_tipo" class="<?= $Page->intrajornada_tipo->headerCellClass() ?>"><div id="elh_view_contratos_intrajornada_tipo" class="view_contratos_intrajornada_tipo"><?= $Page->renderFieldHeader($Page->intrajornada_tipo) ?></div></th>
<?php } ?>
<?php if ($Page->insumos->Visible) { // insumos ?>
        <th data-name="insumos" class="<?= $Page->insumos->headerCellClass() ?>"><div id="elh_view_contratos_insumos" class="view_contratos_insumos"><?= $Page->renderFieldHeader($Page->insumos) ?></div></th>
<?php } ?>
<?php if ($Page->cnpj->Visible) { // cnpj ?>
        <th data-name="cnpj" class="<?= $Page->cnpj->headerCellClass() ?>"><div id="elh_view_contratos_cnpj" class="view_contratos_cnpj"><?= $Page->renderFieldHeader($Page->cnpj) ?></div></th>
<?php } ?>
<?php if ($Page->contato->Visible) { // contato ?>
        <th data-name="contato" class="<?= $Page->contato->headerCellClass() ?>"><div id="elh_view_contratos_contato" class="view_contratos_contato"><?= $Page->renderFieldHeader($Page->contato) ?></div></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Page->_email->headerCellClass() ?>"><div id="elh_view_contratos__email" class="view_contratos__email"><?= $Page->renderFieldHeader($Page->_email) ?></div></th>
<?php } ?>
<?php if ($Page->telefone->Visible) { // telefone ?>
        <th data-name="telefone" class="<?= $Page->telefone->headerCellClass() ?>"><div id="elh_view_contratos_telefone" class="view_contratos_telefone"><?= $Page->renderFieldHeader($Page->telefone) ?></div></th>
<?php } ?>
<?php if ($Page->endereco->Visible) { // endereco ?>
        <th data-name="endereco" class="<?= $Page->endereco->headerCellClass() ?>"><div id="elh_view_contratos_endereco" class="view_contratos_endereco"><?= $Page->renderFieldHeader($Page->endereco) ?></div></th>
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
    <?php if ($Page->idcontrato->Visible) { // idcontrato ?>
        <td data-name="idcontrato"<?= $Page->idcontrato->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_idcontrato" class="el_view_contratos_idcontrato">
<span<?= $Page->idcontrato->viewAttributes() ?>>
<?= $Page->idcontrato->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_cliente" class="el_view_contratos_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->valor->Visible) { // valor ?>
        <td data-name="valor"<?= $Page->valor->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_valor" class="el_view_contratos_valor">
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ativo->Visible) { // ativo ?>
        <td data-name="ativo"<?= $Page->ativo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_ativo" class="el_view_contratos_ativo">
<span<?= $Page->ativo->viewAttributes() ?>>
<?= $Page->ativo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantidade->Visible) { // quantidade ?>
        <td data-name="quantidade"<?= $Page->quantidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_quantidade" class="el_view_contratos_quantidade">
<span<?= $Page->quantidade->viewAttributes() ?>>
<?= $Page->quantidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_cargo" class="el_view_contratos_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <td data-name="acumulo_funcao"<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_acumulo_funcao" class="el_view_contratos_acumulo_funcao">
<span<?= $Page->acumulo_funcao->viewAttributes() ?>>
<?= $Page->acumulo_funcao->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->escala->Visible) { // escala ?>
        <td data-name="escala"<?= $Page->escala->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_escala" class="el_view_contratos_escala">
<span<?= $Page->escala->viewAttributes() ?>>
<?= $Page->escala->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->periodo->Visible) { // periodo ?>
        <td data-name="periodo"<?= $Page->periodo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_periodo" class="el_view_contratos_periodo">
<span<?= $Page->periodo->viewAttributes() ?>>
<?= $Page->periodo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jornada->Visible) { // jornada ?>
        <td data-name="jornada"<?= $Page->jornada->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_jornada" class="el_view_contratos_jornada">
<span<?= $Page->jornada->viewAttributes() ?>>
<?= $Page->jornada->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->salario->Visible) { // salario ?>
        <td data-name="salario"<?= $Page->salario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_salario" class="el_view_contratos_salario">
<span<?= $Page->salario->viewAttributes() ?>>
<?= $Page->salario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->intrajornada_tipo->Visible) { // intrajornada_tipo ?>
        <td data-name="intrajornada_tipo"<?= $Page->intrajornada_tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_intrajornada_tipo" class="el_view_contratos_intrajornada_tipo">
<span<?= $Page->intrajornada_tipo->viewAttributes() ?>>
<?= $Page->intrajornada_tipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->insumos->Visible) { // insumos ?>
        <td data-name="insumos"<?= $Page->insumos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_insumos" class="el_view_contratos_insumos">
<span<?= $Page->insumos->viewAttributes() ?>>
<?= $Page->insumos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cnpj->Visible) { // cnpj ?>
        <td data-name="cnpj"<?= $Page->cnpj->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_cnpj" class="el_view_contratos_cnpj">
<span<?= $Page->cnpj->viewAttributes() ?>>
<?= $Page->cnpj->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contato->Visible) { // contato ?>
        <td data-name="contato"<?= $Page->contato->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_contato" class="el_view_contratos_contato">
<span<?= $Page->contato->viewAttributes() ?>>
<?= $Page->contato->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos__email" class="el_view_contratos__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->telefone->Visible) { // telefone ?>
        <td data-name="telefone"<?= $Page->telefone->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_telefone" class="el_view_contratos_telefone">
<span<?= $Page->telefone->viewAttributes() ?>>
<?= $Page->telefone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->endereco->Visible) { // endereco ?>
        <td data-name="endereco"<?= $Page->endereco->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_contratos_endereco" class="el_view_contratos_endereco">
<span<?= $Page->endereco->viewAttributes() ?>>
<?= $Page->endereco->getViewValue() ?></span>
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
    ew.addEventHandlers("view_contratos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
