<?php

namespace PHPMaker2024\contratos;

// Page object
$ItensModuloList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { itens_modulo: currentTable } });
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

        // Add fields
        .setFields([
            ["item", [fields.item.visible && fields.item.required ? ew.Validators.required(fields.item.caption) : null], fields.item.isInvalid],
            ["porcentagem_valor", [fields.porcentagem_valor.visible && fields.porcentagem_valor.required ? ew.Validators.required(fields.porcentagem_valor.caption) : null, ew.Validators.float], fields.porcentagem_valor.isInvalid],
            ["incidencia_inss", [fields.incidencia_inss.visible && fields.incidencia_inss.required ? ew.Validators.required(fields.incidencia_inss.caption) : null], fields.incidencia_inss.isInvalid],
            ["ativo", [fields.ativo.visible && fields.ativo.required ? ew.Validators.required(fields.ativo.caption) : null], fields.ativo.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["item",false],["porcentagem_valor",false],["incidencia_inss",false],["ativo",false]];
                if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
                    return false;
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
            "incidencia_inss": <?= $Page->incidencia_inss->toClientList($Page) ?>,
            "ativo": <?= $Page->ativo->toClientList($Page) ?>,
        })
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "modulo") {
    if ($Page->MasterRecordExists) {
        include_once "views/ModuloMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fitens_modulosrch" id="fitens_modulosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fitens_modulosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { itens_modulo: currentTable } });
var currentForm;
var fitens_modulosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fitens_modulosrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fitens_modulosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fitens_modulosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fitens_modulosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fitens_modulosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="itens_modulo">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "modulo" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="modulo">
<input type="hidden" name="fk_idmodulo" value="<?= HtmlEncode($Page->modulo_idmodulo->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_itens_modulo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_itens_modulolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->item->Visible) { // item ?>
        <th data-name="item" class="<?= $Page->item->headerCellClass() ?>"><div id="elh_itens_modulo_item" class="itens_modulo_item"><?= $Page->renderFieldHeader($Page->item) ?></div></th>
<?php } ?>
<?php if ($Page->porcentagem_valor->Visible) { // porcentagem_valor ?>
        <th data-name="porcentagem_valor" class="<?= $Page->porcentagem_valor->headerCellClass() ?>"><div id="elh_itens_modulo_porcentagem_valor" class="itens_modulo_porcentagem_valor"><?= $Page->renderFieldHeader($Page->porcentagem_valor) ?></div></th>
<?php } ?>
<?php if ($Page->incidencia_inss->Visible) { // incidencia_inss ?>
        <th data-name="incidencia_inss" class="<?= $Page->incidencia_inss->headerCellClass() ?>"><div id="elh_itens_modulo_incidencia_inss" class="itens_modulo_incidencia_inss"><?= $Page->renderFieldHeader($Page->incidencia_inss) ?></div></th>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <th data-name="ativo" class="<?= $Page->ativo->headerCellClass() ?>"><div id="elh_itens_modulo_ativo" class="itens_modulo_ativo"><?= $Page->renderFieldHeader($Page->ativo) ?></div></th>
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

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow()) &&
            $Page->RowAction != "hide"
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->item->Visible) { // item ?>
        <td data-name="item"<?= $Page->item->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_item" class="el_itens_modulo_item">
<input type="<?= $Page->item->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_item" id="x<?= $Page->RowIndex ?>_item" data-table="itens_modulo" data-field="x_item" value="<?= $Page->item->EditValue ?>" size="50" maxlength="155" placeholder="<?= HtmlEncode($Page->item->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->item->formatPattern()) ?>"<?= $Page->item->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->item->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="itens_modulo" data-field="x_item" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_item" id="o<?= $Page->RowIndex ?>_item" value="<?= HtmlEncode($Page->item->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_item" class="el_itens_modulo_item">
<input type="<?= $Page->item->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_item" id="x<?= $Page->RowIndex ?>_item" data-table="itens_modulo" data-field="x_item" value="<?= $Page->item->EditValue ?>" size="50" maxlength="155" placeholder="<?= HtmlEncode($Page->item->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->item->formatPattern()) ?>"<?= $Page->item->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->item->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_item" class="el_itens_modulo_item">
<span<?= $Page->item->viewAttributes() ?>>
<?= $Page->item->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->porcentagem_valor->Visible) { // porcentagem_valor ?>
        <td data-name="porcentagem_valor"<?= $Page->porcentagem_valor->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_porcentagem_valor" class="el_itens_modulo_porcentagem_valor">
<input type="<?= $Page->porcentagem_valor->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_porcentagem_valor" id="x<?= $Page->RowIndex ?>_porcentagem_valor" data-table="itens_modulo" data-field="x_porcentagem_valor" value="<?= $Page->porcentagem_valor->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Page->porcentagem_valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porcentagem_valor->formatPattern()) ?>"<?= $Page->porcentagem_valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->porcentagem_valor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="itens_modulo" data-field="x_porcentagem_valor" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_porcentagem_valor" id="o<?= $Page->RowIndex ?>_porcentagem_valor" value="<?= HtmlEncode($Page->porcentagem_valor->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_porcentagem_valor" class="el_itens_modulo_porcentagem_valor">
<input type="<?= $Page->porcentagem_valor->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_porcentagem_valor" id="x<?= $Page->RowIndex ?>_porcentagem_valor" data-table="itens_modulo" data-field="x_porcentagem_valor" value="<?= $Page->porcentagem_valor->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Page->porcentagem_valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porcentagem_valor->formatPattern()) ?>"<?= $Page->porcentagem_valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->porcentagem_valor->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_porcentagem_valor" class="el_itens_modulo_porcentagem_valor">
<span<?= $Page->porcentagem_valor->viewAttributes() ?>>
<?= $Page->porcentagem_valor->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->incidencia_inss->Visible) { // incidencia_inss ?>
        <td data-name="incidencia_inss"<?= $Page->incidencia_inss->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_incidencia_inss" class="el_itens_modulo_incidencia_inss">
<template id="tp_x<?= $Page->RowIndex ?>_incidencia_inss">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="itens_modulo" data-field="x_incidencia_inss" name="x<?= $Page->RowIndex ?>_incidencia_inss" id="x<?= $Page->RowIndex ?>_incidencia_inss"<?= $Page->incidencia_inss->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_incidencia_inss" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_incidencia_inss"
    name="x<?= $Page->RowIndex ?>_incidencia_inss"
    value="<?= HtmlEncode($Page->incidencia_inss->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_incidencia_inss"
    data-target="dsl_x<?= $Page->RowIndex ?>_incidencia_inss"
    data-repeatcolumn="5"
    class="form-control<?= $Page->incidencia_inss->isInvalidClass() ?>"
    data-table="itens_modulo"
    data-field="x_incidencia_inss"
    data-value-separator="<?= $Page->incidencia_inss->displayValueSeparatorAttribute() ?>"
    <?= $Page->incidencia_inss->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->incidencia_inss->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="itens_modulo" data-field="x_incidencia_inss" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_incidencia_inss" id="o<?= $Page->RowIndex ?>_incidencia_inss" value="<?= HtmlEncode($Page->incidencia_inss->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_incidencia_inss" class="el_itens_modulo_incidencia_inss">
<template id="tp_x<?= $Page->RowIndex ?>_incidencia_inss">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="itens_modulo" data-field="x_incidencia_inss" name="x<?= $Page->RowIndex ?>_incidencia_inss" id="x<?= $Page->RowIndex ?>_incidencia_inss"<?= $Page->incidencia_inss->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_incidencia_inss" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_incidencia_inss"
    name="x<?= $Page->RowIndex ?>_incidencia_inss"
    value="<?= HtmlEncode($Page->incidencia_inss->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_incidencia_inss"
    data-target="dsl_x<?= $Page->RowIndex ?>_incidencia_inss"
    data-repeatcolumn="5"
    class="form-control<?= $Page->incidencia_inss->isInvalidClass() ?>"
    data-table="itens_modulo"
    data-field="x_incidencia_inss"
    data-value-separator="<?= $Page->incidencia_inss->displayValueSeparatorAttribute() ?>"
    <?= $Page->incidencia_inss->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->incidencia_inss->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_incidencia_inss" class="el_itens_modulo_incidencia_inss">
<span<?= $Page->incidencia_inss->viewAttributes() ?>>
<?= $Page->incidencia_inss->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ativo->Visible) { // ativo ?>
        <td data-name="ativo"<?= $Page->ativo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_ativo" class="el_itens_modulo_ativo">
<template id="tp_x<?= $Page->RowIndex ?>_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="itens_modulo" data-field="x_ativo" name="x<?= $Page->RowIndex ?>_ativo" id="x<?= $Page->RowIndex ?>_ativo"<?= $Page->ativo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_ativo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_ativo"
    name="x<?= $Page->RowIndex ?>_ativo"
    value="<?= HtmlEncode($Page->ativo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_ativo"
    data-target="dsl_x<?= $Page->RowIndex ?>_ativo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ativo->isInvalidClass() ?>"
    data-table="itens_modulo"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="itens_modulo" data-field="x_ativo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_ativo" id="o<?= $Page->RowIndex ?>_ativo" value="<?= HtmlEncode($Page->ativo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_ativo" class="el_itens_modulo_ativo">
<template id="tp_x<?= $Page->RowIndex ?>_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="itens_modulo" data-field="x_ativo" name="x<?= $Page->RowIndex ?>_ativo" id="x<?= $Page->RowIndex ?>_ativo"<?= $Page->ativo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_ativo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_ativo"
    name="x<?= $Page->RowIndex ?>_ativo"
    value="<?= HtmlEncode($Page->ativo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_ativo"
    data-target="dsl_x<?= $Page->RowIndex ?>_ativo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ativo->isInvalidClass() ?>"
    data-table="itens_modulo"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_itens_modulo_ativo" class="el_itens_modulo_ativo">
<span<?= $Page->ativo->viewAttributes() ?>>
<?= $Page->ativo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == RowType::ADD || $Page->RowType == RowType::EDIT) { ?>
<script data-rowindex="<?= $Page->RowIndex ?>">
loadjs.ready(["<?= $Page->FormName ?>","load"], () => <?= $Page->FormName ?>.updateLists(<?= $Page->RowIndex ?><?= $Page->isAdd() || $Page->isEdit() || $Page->isCopy() || $Page->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

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
    <?php if ($Page->item->Visible) { // item ?>
        <td data-name="item" class="<?= $Page->item->footerCellClass() ?>"><span id="elf_itens_modulo_item" class="itens_modulo_item">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->item->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->porcentagem_valor->Visible) { // porcentagem_valor ?>
        <td data-name="porcentagem_valor" class="<?= $Page->porcentagem_valor->footerCellClass() ?>"><span id="elf_itens_modulo_porcentagem_valor" class="itens_modulo_porcentagem_valor">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->porcentagem_valor->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->incidencia_inss->Visible) { // incidencia_inss ?>
        <td data-name="incidencia_inss" class="<?= $Page->incidencia_inss->footerCellClass() ?>"><span id="elf_itens_modulo_incidencia_inss" class="itens_modulo_incidencia_inss">
        </span></td>
    <?php } ?>
    <?php if ($Page->ativo->Visible) { // ativo ?>
        <td data-name="ativo" class="<?= $Page->ativo->footerCellClass() ?>"><span id="elf_itens_modulo_ativo" class="itens_modulo_ativo">
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
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } elseif ($Page->isMultiEdit()) { ?>
<input type="hidden" name="action" id="action" value="multiupdate">
<?php } ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
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
    ew.addEventHandlers("itens_modulo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
