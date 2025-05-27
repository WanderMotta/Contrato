<?php

namespace PHPMaker2024\contratos;

// Page object
$PropostaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposta: currentTable } });
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
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fpropostasrch" id="fpropostasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fpropostasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposta: currentTable } });
var currentForm;
var fpropostasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fpropostasrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fpropostasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fpropostasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fpropostasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fpropostasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="proposta">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_proposta" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_propostalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->idproposta->Visible) { // idproposta ?>
        <th data-name="idproposta" class="<?= $Page->idproposta->headerCellClass() ?>"><div id="elh_proposta_idproposta" class="proposta_idproposta"><?= $Page->renderFieldHeader($Page->idproposta) ?></div></th>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th data-name="dt_cadastro" class="<?= $Page->dt_cadastro->headerCellClass() ?>"><div id="elh_proposta_dt_cadastro" class="proposta_dt_cadastro"><?= $Page->renderFieldHeader($Page->dt_cadastro) ?></div></th>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <th data-name="cliente_idcliente" class="<?= $Page->cliente_idcliente->headerCellClass() ?>"><div id="elh_proposta_cliente_idcliente" class="proposta_cliente_idcliente"><?= $Page->renderFieldHeader($Page->cliente_idcliente) ?></div></th>
<?php } ?>
<?php if ($Page->validade->Visible) { // validade ?>
        <th data-name="validade" class="<?= $Page->validade->headerCellClass() ?>"><div id="elh_proposta_validade" class="proposta_validade"><?= $Page->renderFieldHeader($Page->validade) ?></div></th>
<?php } ?>
<?php if ($Page->mes_ano_conv_coletiva->Visible) { // mes_ano_conv_coletiva ?>
        <th data-name="mes_ano_conv_coletiva" class="<?= $Page->mes_ano_conv_coletiva->headerCellClass() ?>"><div id="elh_proposta_mes_ano_conv_coletiva" class="proposta_mes_ano_conv_coletiva"><?= $Page->renderFieldHeader($Page->mes_ano_conv_coletiva) ?></div></th>
<?php } ?>
<?php if ($Page->sindicato->Visible) { // sindicato ?>
        <th data-name="sindicato" class="<?= $Page->sindicato->headerCellClass() ?>"><div id="elh_proposta_sindicato" class="proposta_sindicato"><?= $Page->renderFieldHeader($Page->sindicato) ?></div></th>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
        <th data-name="cidade" class="<?= $Page->cidade->headerCellClass() ?>"><div id="elh_proposta_cidade" class="proposta_cidade"><?= $Page->renderFieldHeader($Page->cidade) ?></div></th>
<?php } ?>
<?php if ($Page->nr_meses->Visible) { // nr_meses ?>
        <th data-name="nr_meses" class="<?= $Page->nr_meses->headerCellClass() ?>"><div id="elh_proposta_nr_meses" class="proposta_nr_meses"><?= $Page->renderFieldHeader($Page->nr_meses) ?></div></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th data-name="usuario_idusuario" class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><div id="elh_proposta_usuario_idusuario" class="proposta_usuario_idusuario"><?= $Page->renderFieldHeader($Page->usuario_idusuario) ?></div></th>
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
    <?php if ($Page->idproposta->Visible) { // idproposta ?>
        <td data-name="idproposta"<?= $Page->idproposta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_proposta_idproposta" class="el_proposta_idproposta">
<span<?= $Page->idproposta->viewAttributes() ?>>
<?= $Page->idproposta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_proposta_dt_cadastro" class="el_proposta_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <td data-name="cliente_idcliente"<?= $Page->cliente_idcliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_proposta_cliente_idcliente" class="el_proposta_cliente_idcliente">
<span<?= $Page->cliente_idcliente->viewAttributes() ?>>
<?= $Page->cliente_idcliente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->validade->Visible) { // validade ?>
        <td data-name="validade"<?= $Page->validade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_proposta_validade" class="el_proposta_validade">
<span<?= $Page->validade->viewAttributes() ?>>
<?= $Page->validade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->mes_ano_conv_coletiva->Visible) { // mes_ano_conv_coletiva ?>
        <td data-name="mes_ano_conv_coletiva"<?= $Page->mes_ano_conv_coletiva->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_proposta_mes_ano_conv_coletiva" class="el_proposta_mes_ano_conv_coletiva">
<span<?= $Page->mes_ano_conv_coletiva->viewAttributes() ?>>
<?= $Page->mes_ano_conv_coletiva->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sindicato->Visible) { // sindicato ?>
        <td data-name="sindicato"<?= $Page->sindicato->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_proposta_sindicato" class="el_proposta_sindicato">
<span<?= $Page->sindicato->viewAttributes() ?>>
<?= $Page->sindicato->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cidade->Visible) { // cidade ?>
        <td data-name="cidade"<?= $Page->cidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_proposta_cidade" class="el_proposta_cidade">
<span<?= $Page->cidade->viewAttributes() ?>>
<?= $Page->cidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nr_meses->Visible) { // nr_meses ?>
        <td data-name="nr_meses"<?= $Page->nr_meses->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_proposta_nr_meses" class="el_proposta_nr_meses">
<span<?= $Page->nr_meses->viewAttributes() ?>>
<?= $Page->nr_meses->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_proposta_usuario_idusuario" class="el_proposta_usuario_idusuario">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
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
    <?php if ($Page->idproposta->Visible) { // idproposta ?>
        <td data-name="idproposta" class="<?= $Page->idproposta->footerCellClass() ?>"><span id="elf_proposta_idproposta" class="proposta_idproposta">
        </span></td>
    <?php } ?>
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro" class="<?= $Page->dt_cadastro->footerCellClass() ?>"><span id="elf_proposta_dt_cadastro" class="proposta_dt_cadastro">
        </span></td>
    <?php } ?>
    <?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <td data-name="cliente_idcliente" class="<?= $Page->cliente_idcliente->footerCellClass() ?>"><span id="elf_proposta_cliente_idcliente" class="proposta_cliente_idcliente">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->cliente_idcliente->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->validade->Visible) { // validade ?>
        <td data-name="validade" class="<?= $Page->validade->footerCellClass() ?>"><span id="elf_proposta_validade" class="proposta_validade">
        </span></td>
    <?php } ?>
    <?php if ($Page->mes_ano_conv_coletiva->Visible) { // mes_ano_conv_coletiva ?>
        <td data-name="mes_ano_conv_coletiva" class="<?= $Page->mes_ano_conv_coletiva->footerCellClass() ?>"><span id="elf_proposta_mes_ano_conv_coletiva" class="proposta_mes_ano_conv_coletiva">
        </span></td>
    <?php } ?>
    <?php if ($Page->sindicato->Visible) { // sindicato ?>
        <td data-name="sindicato" class="<?= $Page->sindicato->footerCellClass() ?>"><span id="elf_proposta_sindicato" class="proposta_sindicato">
        </span></td>
    <?php } ?>
    <?php if ($Page->cidade->Visible) { // cidade ?>
        <td data-name="cidade" class="<?= $Page->cidade->footerCellClass() ?>"><span id="elf_proposta_cidade" class="proposta_cidade">
        </span></td>
    <?php } ?>
    <?php if ($Page->nr_meses->Visible) { // nr_meses ?>
        <td data-name="nr_meses" class="<?= $Page->nr_meses->footerCellClass() ?>"><span id="elf_proposta_nr_meses" class="proposta_nr_meses">
        </span></td>
    <?php } ?>
    <?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td data-name="usuario_idusuario" class="<?= $Page->usuario_idusuario->footerCellClass() ?>"><span id="elf_proposta_usuario_idusuario" class="proposta_usuario_idusuario">
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
    ew.addEventHandlers("proposta");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
