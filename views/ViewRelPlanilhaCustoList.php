<?php

namespace PHPMaker2024\contratos;

// Page object
$ViewRelPlanilhaCustoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_rel_planilha_custo: currentTable } });
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
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fview_rel_planilha_custosrch" id="fview_rel_planilha_custosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_rel_planilha_custosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_rel_planilha_custo: currentTable } });
var currentForm;
var fview_rel_planilha_custosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_rel_planilha_custosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idplanilha_custo", [], fields.idplanilha_custo.isInvalid]
        ])
        // Validate form
        .setValidate(
            async function () {
                if (!this.validateRequired)
                    return true; // Ignore validation
                let fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
                return true;
            }
        )

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
            "idplanilha_custo": <?= $Page->idplanilha_custo->toClientList($Page) ?>,
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
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = RowType::SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
<?php
if (!$Page->idplanilha_custo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_idplanilha_custo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->idplanilha_custo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->idplanilha_custo->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idplanilha_custo" id="z_idplanilha_custo" value="=">
</div>
        </div>
        <div id="el_view_rel_planilha_custo_idplanilha_custo" class="ew-search-field">
    <select
        id="x_idplanilha_custo"
        name="x_idplanilha_custo"
        class="form-control ew-select<?= $Page->idplanilha_custo->isInvalidClass() ?>"
        data-select2-id="fview_rel_planilha_custosrch_x_idplanilha_custo"
        data-table="view_rel_planilha_custo"
        data-field="x_idplanilha_custo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->idplanilha_custo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->idplanilha_custo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idplanilha_custo->getPlaceHolder()) ?>"
        <?= $Page->idplanilha_custo->editAttributes() ?>>
        <?= $Page->idplanilha_custo->selectOptionListHtml("x_idplanilha_custo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->idplanilha_custo->getErrorMessage(false) ?></div>
<?= $Page->idplanilha_custo->Lookup->getParamTag($Page, "p_x_idplanilha_custo") ?>
<script>
loadjs.ready("fview_rel_planilha_custosrch", function() {
    var options = { name: "x_idplanilha_custo", selectId: "fview_rel_planilha_custosrch_x_idplanilha_custo" };
    if (fview_rel_planilha_custosrch.lists.idplanilha_custo?.lookupOptions.length) {
        options.data = { id: "x_idplanilha_custo", form: "fview_rel_planilha_custosrch" };
    } else {
        options.ajax = { id: "x_idplanilha_custo", form: "fview_rel_planilha_custosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.view_rel_planilha_custo.fields.idplanilha_custo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_rel_planilha_custosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_rel_planilha_custosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_rel_planilha_custosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_rel_planilha_custosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_rel_planilha_custo">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_rel_planilha_custo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_rel_planilha_custolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="idproposta" class="<?= $Page->idproposta->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_idproposta" class="view_rel_planilha_custo_idproposta"><?= $Page->renderFieldHeader($Page->idproposta) ?></div></th>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th data-name="dt_cadastro" class="<?= $Page->dt_cadastro->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_dt_cadastro" class="view_rel_planilha_custo_dt_cadastro"><?= $Page->renderFieldHeader($Page->dt_cadastro) ?></div></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_cliente" class="view_rel_planilha_custo_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <th data-name="modulo" class="<?= $Page->modulo->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_modulo" class="view_rel_planilha_custo_modulo"><?= $Page->renderFieldHeader($Page->modulo) ?></div></th>
<?php } ?>
<?php if ($Page->item->Visible) { // item ?>
        <th data-name="item" class="<?= $Page->item->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_item" class="view_rel_planilha_custo_item"><?= $Page->renderFieldHeader($Page->item) ?></div></th>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { // porcentagem ?>
        <th data-name="porcentagem" class="<?= $Page->porcentagem->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_porcentagem" class="view_rel_planilha_custo_porcentagem"><?= $Page->renderFieldHeader($Page->porcentagem) ?></div></th>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <th data-name="valor" class="<?= $Page->valor->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_valor" class="view_rel_planilha_custo_valor"><?= $Page->renderFieldHeader($Page->valor) ?></div></th>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
        <th data-name="obs" class="<?= $Page->obs->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_obs" class="view_rel_planilha_custo_obs"><?= $Page->renderFieldHeader($Page->obs) ?></div></th>
<?php } ?>
<?php if ($Page->posicao->Visible) { // posicao ?>
        <th data-name="posicao" class="<?= $Page->posicao->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_posicao" class="view_rel_planilha_custo_posicao"><?= $Page->renderFieldHeader($Page->posicao) ?></div></th>
<?php } ?>
<?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
        <th data-name="idplanilha_custo" class="<?= $Page->idplanilha_custo->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_idplanilha_custo" class="view_rel_planilha_custo_idplanilha_custo"><?= $Page->renderFieldHeader($Page->idplanilha_custo) ?></div></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
        <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_cargo" class="view_rel_planilha_custo_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->sub_modulos->Visible) { // sub_modulos ?>
        <th data-name="sub_modulos" class="<?= $Page->sub_modulos->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_sub_modulos" class="view_rel_planilha_custo_sub_modulos"><?= $Page->renderFieldHeader($Page->sub_modulos) ?></div></th>
<?php } ?>
<?php if ($Page->idcliente->Visible) { // idcliente ?>
        <th data-name="idcliente" class="<?= $Page->idcliente->headerCellClass() ?>"><div id="elh_view_rel_planilha_custo_idcliente" class="view_rel_planilha_custo_idcliente"><?= $Page->renderFieldHeader($Page->idcliente) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_idproposta" class="el_view_rel_planilha_custo_idproposta">
<span<?= $Page->idproposta->viewAttributes() ?>>
<?= $Page->idproposta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_dt_cadastro" class="el_view_rel_planilha_custo_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_cliente" class="el_view_rel_planilha_custo_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->modulo->Visible) { // modulo ?>
        <td data-name="modulo"<?= $Page->modulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_modulo" class="el_view_rel_planilha_custo_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->item->Visible) { // item ?>
        <td data-name="item"<?= $Page->item->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_item" class="el_view_rel_planilha_custo_item">
<span<?= $Page->item->viewAttributes() ?>>
<?= $Page->item->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->porcentagem->Visible) { // porcentagem ?>
        <td data-name="porcentagem"<?= $Page->porcentagem->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_porcentagem" class="el_view_rel_planilha_custo_porcentagem">
<span<?= $Page->porcentagem->viewAttributes() ?>>
<?= $Page->porcentagem->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->valor->Visible) { // valor ?>
        <td data-name="valor"<?= $Page->valor->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_valor" class="el_view_rel_planilha_custo_valor">
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->obs->Visible) { // obs ?>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_obs" class="el_view_rel_planilha_custo_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->posicao->Visible) { // posicao ?>
        <td data-name="posicao"<?= $Page->posicao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_posicao" class="el_view_rel_planilha_custo_posicao">
<span<?= $Page->posicao->viewAttributes() ?>>
<?= $Page->posicao->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idplanilha_custo->Visible) { // idplanilha_custo ?>
        <td data-name="idplanilha_custo"<?= $Page->idplanilha_custo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_idplanilha_custo" class="el_view_rel_planilha_custo_idplanilha_custo">
<span<?= $Page->idplanilha_custo->viewAttributes() ?>>
<?= $Page->idplanilha_custo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_cargo" class="el_view_rel_planilha_custo_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sub_modulos->Visible) { // sub_modulos ?>
        <td data-name="sub_modulos"<?= $Page->sub_modulos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_sub_modulos" class="el_view_rel_planilha_custo_sub_modulos">
<span<?= $Page->sub_modulos->viewAttributes() ?>>
<?= $Page->sub_modulos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idcliente->Visible) { // idcliente ?>
        <td data-name="idcliente"<?= $Page->idcliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_rel_planilha_custo_idcliente" class="el_view_rel_planilha_custo_idcliente">
<span<?= $Page->idcliente->viewAttributes() ?>>
<?= $Page->idcliente->getViewValue() ?></span>
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
    ew.addEventHandlers("view_rel_planilha_custo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
