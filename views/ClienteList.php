<?php

namespace PHPMaker2024\contratos;

// Page object
$ClienteList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cliente: currentTable } });
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
            ["cliente", [fields.cliente.visible && fields.cliente.required ? ew.Validators.required(fields.cliente.caption) : null], fields.cliente.isInvalid],
            ["contato", [fields.contato.visible && fields.contato.required ? ew.Validators.required(fields.contato.caption) : null], fields.contato.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
            ["telefone", [fields.telefone.visible && fields.telefone.required ? ew.Validators.required(fields.telefone.caption) : null], fields.telefone.isInvalid],
            ["ativo", [fields.ativo.visible && fields.ativo.required ? ew.Validators.required(fields.ativo.caption) : null], fields.ativo.isInvalid]
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
            "ativo": <?= $Page->ativo->toClientList($Page) ?>,
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
<form name="fclientesrch" id="fclientesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fclientesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cliente: currentTable } });
var currentForm;
var fclientesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fclientesrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["ativo", [], fields.ativo.isInvalid]
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
            "ativo": <?= $Page->ativo->toClientList($Page) ?>,
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
<?php if ($Page->ativo->Visible) { // ativo ?>
<?php
if (!$Page->ativo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_ativo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->ativo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->ativo->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ativo" id="z_ativo" value="=">
</div>
        </div>
        <div id="el_cliente_ativo" class="ew-search-field">
<template id="tp_x_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cliente" data-field="x_ativo" name="x_ativo" id="x_ativo"<?= $Page->ativo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_ativo" class="ew-item-list"></div>
<selection-list hidden
    id="x_ativo"
    name="x_ativo"
    value="<?= HtmlEncode($Page->ativo->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_ativo"
    data-target="dsl_x_ativo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ativo->isInvalidClass() ?>"
    data-table="cliente"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage(false) ?></div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fclientesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fclientesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fclientesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fclientesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="cliente">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_cliente" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_clientelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_cliente_cliente" class="cliente_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->contato->Visible) { // contato ?>
        <th data-name="contato" class="<?= $Page->contato->headerCellClass() ?>"><div id="elh_cliente_contato" class="cliente_contato"><?= $Page->renderFieldHeader($Page->contato) ?></div></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Page->_email->headerCellClass() ?>"><div id="elh_cliente__email" class="cliente__email"><?= $Page->renderFieldHeader($Page->_email) ?></div></th>
<?php } ?>
<?php if ($Page->telefone->Visible) { // telefone ?>
        <th data-name="telefone" class="<?= $Page->telefone->headerCellClass() ?>"><div id="elh_cliente_telefone" class="cliente_telefone"><?= $Page->renderFieldHeader($Page->telefone) ?></div></th>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <th data-name="ativo" class="<?= $Page->ativo->headerCellClass() ?>"><div id="elh_cliente_ativo" class="cliente_ativo"><?= $Page->renderFieldHeader($Page->ativo) ?></div></th>
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
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_cliente" class="el_cliente_cliente">
<input type="<?= $Page->cliente->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_cliente" id="x<?= $Page->RowIndex ?>_cliente" data-table="cliente" data-field="x_cliente" value="<?= $Page->cliente->EditValue ?>" size="80" maxlength="150" placeholder="<?= HtmlEncode($Page->cliente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cliente->formatPattern()) ?>"<?= $Page->cliente->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cliente->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cliente" data-field="x_cliente" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_cliente" id="o<?= $Page->RowIndex ?>_cliente" value="<?= HtmlEncode($Page->cliente->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_cliente" class="el_cliente_cliente">
<input type="<?= $Page->cliente->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_cliente" id="x<?= $Page->RowIndex ?>_cliente" data-table="cliente" data-field="x_cliente" value="<?= $Page->cliente->EditValue ?>" size="80" maxlength="150" placeholder="<?= HtmlEncode($Page->cliente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cliente->formatPattern()) ?>"<?= $Page->cliente->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cliente->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_cliente" class="el_cliente_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->contato->Visible) { // contato ?>
        <td data-name="contato"<?= $Page->contato->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_contato" class="el_cliente_contato">
<input type="<?= $Page->contato->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_contato" id="x<?= $Page->RowIndex ?>_contato" data-table="cliente" data-field="x_contato" value="<?= $Page->contato->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->contato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contato->formatPattern()) ?>"<?= $Page->contato->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->contato->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cliente" data-field="x_contato" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_contato" id="o<?= $Page->RowIndex ?>_contato" value="<?= HtmlEncode($Page->contato->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_contato" class="el_cliente_contato">
<input type="<?= $Page->contato->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_contato" id="x<?= $Page->RowIndex ?>_contato" data-table="cliente" data-field="x_contato" value="<?= $Page->contato->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->contato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contato->formatPattern()) ?>"<?= $Page->contato->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->contato->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_contato" class="el_cliente_contato">
<span<?= $Page->contato->viewAttributes() ?>>
<?= $Page->contato->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente__email" class="el_cliente__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" data-table="cliente" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cliente" data-field="x__email" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>__email" id="o<?= $Page->RowIndex ?>__email" value="<?= HtmlEncode($Page->_email->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente__email" class="el_cliente__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" data-table="cliente" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente__email" class="el_cliente__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->telefone->Visible) { // telefone ?>
        <td data-name="telefone"<?= $Page->telefone->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_telefone" class="el_cliente_telefone">
<input type="<?= $Page->telefone->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_telefone" id="x<?= $Page->RowIndex ?>_telefone" data-table="cliente" data-field="x_telefone" value="<?= $Page->telefone->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->telefone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefone->formatPattern()) ?>"<?= $Page->telefone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->telefone->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cliente" data-field="x_telefone" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_telefone" id="o<?= $Page->RowIndex ?>_telefone" value="<?= HtmlEncode($Page->telefone->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_telefone" class="el_cliente_telefone">
<input type="<?= $Page->telefone->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_telefone" id="x<?= $Page->RowIndex ?>_telefone" data-table="cliente" data-field="x_telefone" value="<?= $Page->telefone->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->telefone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefone->formatPattern()) ?>"<?= $Page->telefone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->telefone->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_telefone" class="el_cliente_telefone">
<span<?= $Page->telefone->viewAttributes() ?>>
<?= $Page->telefone->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ativo->Visible) { // ativo ?>
        <td data-name="ativo"<?= $Page->ativo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_ativo" class="el_cliente_ativo">
<template id="tp_x<?= $Page->RowIndex ?>_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cliente" data-field="x_ativo" name="x<?= $Page->RowIndex ?>_ativo" id="x<?= $Page->RowIndex ?>_ativo"<?= $Page->ativo->editAttributes() ?>>
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
    data-table="cliente"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cliente" data-field="x_ativo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_ativo" id="o<?= $Page->RowIndex ?>_ativo" value="<?= HtmlEncode($Page->ativo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_ativo" class="el_cliente_ativo">
<template id="tp_x<?= $Page->RowIndex ?>_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cliente" data-field="x_ativo" name="x<?= $Page->RowIndex ?>_ativo" id="x<?= $Page->RowIndex ?>_ativo"<?= $Page->ativo->editAttributes() ?>>
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
    data-table="cliente"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cliente_ativo" class="el_cliente_ativo">
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
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente" class="<?= $Page->cliente->footerCellClass() ?>"><span id="elf_cliente_cliente" class="cliente_cliente">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->cliente->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->contato->Visible) { // contato ?>
        <td data-name="contato" class="<?= $Page->contato->footerCellClass() ?>"><span id="elf_cliente_contato" class="cliente_contato">
        </span></td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email" class="<?= $Page->_email->footerCellClass() ?>"><span id="elf_cliente__email" class="cliente__email">
        </span></td>
    <?php } ?>
    <?php if ($Page->telefone->Visible) { // telefone ?>
        <td data-name="telefone" class="<?= $Page->telefone->footerCellClass() ?>"><span id="elf_cliente_telefone" class="cliente_telefone">
        </span></td>
    <?php } ?>
    <?php if ($Page->ativo->Visible) { // ativo ?>
        <td data-name="ativo" class="<?= $Page->ativo->footerCellClass() ?>"><span id="elf_cliente_ativo" class="cliente_ativo">
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
    ew.addEventHandlers("cliente");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
