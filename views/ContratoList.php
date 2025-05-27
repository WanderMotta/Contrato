<?php

namespace PHPMaker2024\contratos;

// Page object
$ContratoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contrato: currentTable } });
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
            ["idcontrato", [fields.idcontrato.visible && fields.idcontrato.required ? ew.Validators.required(fields.idcontrato.caption) : null], fields.idcontrato.isInvalid],
            ["cliente_idcliente", [fields.cliente_idcliente.visible && fields.cliente_idcliente.required ? ew.Validators.required(fields.cliente_idcliente.caption) : null], fields.cliente_idcliente.isInvalid],
            ["valor", [fields.valor.visible && fields.valor.required ? ew.Validators.required(fields.valor.caption) : null, ew.Validators.float], fields.valor.isInvalid],
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
            "cliente_idcliente": <?= $Page->cliente_idcliente->toClientList($Page) ?>,
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
<form name="fcontratosrch" id="fcontratosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fcontratosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contrato: currentTable } });
var currentForm;
var fcontratosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fcontratosrch")
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
        <div id="el_contrato_ativo" class="ew-search-field">
<template id="tp_x_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contrato" data-field="x_ativo" name="x_ativo" id="x_ativo"<?= $Page->ativo->editAttributes() ?>>
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
    data-table="contrato"
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fcontratosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fcontratosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fcontratosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fcontratosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="contrato">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_contrato" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_contratolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="idcontrato" class="<?= $Page->idcontrato->headerCellClass() ?>"><div id="elh_contrato_idcontrato" class="contrato_idcontrato"><?= $Page->renderFieldHeader($Page->idcontrato) ?></div></th>
<?php } ?>
<?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <th data-name="cliente_idcliente" class="<?= $Page->cliente_idcliente->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_contrato_cliente_idcliente" class="contrato_cliente_idcliente"><?= $Page->renderFieldHeader($Page->cliente_idcliente) ?></div></th>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <th data-name="valor" class="<?= $Page->valor->headerCellClass() ?>"><div id="elh_contrato_valor" class="contrato_valor"><?= $Page->renderFieldHeader($Page->valor) ?></div></th>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <th data-name="ativo" class="<?= $Page->ativo->headerCellClass() ?>"><div id="elh_contrato_ativo" class="contrato_ativo"><?= $Page->renderFieldHeader($Page->ativo) ?></div></th>
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
    <?php if ($Page->idcontrato->Visible) { // idcontrato ?>
        <td data-name="idcontrato"<?= $Page->idcontrato->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_idcontrato" class="el_contrato_idcontrato"></span>
<input type="hidden" data-table="contrato" data-field="x_idcontrato" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_idcontrato" id="o<?= $Page->RowIndex ?>_idcontrato" value="<?= HtmlEncode($Page->idcontrato->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_idcontrato" class="el_contrato_idcontrato">
<span<?= $Page->idcontrato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idcontrato->getDisplayValue($Page->idcontrato->EditValue))) ?>"></span>
<input type="hidden" data-table="contrato" data-field="x_idcontrato" data-hidden="1" name="x<?= $Page->RowIndex ?>_idcontrato" id="x<?= $Page->RowIndex ?>_idcontrato" value="<?= HtmlEncode($Page->idcontrato->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_idcontrato" class="el_contrato_idcontrato">
<span<?= $Page->idcontrato->viewAttributes() ?>>
<?= $Page->idcontrato->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="contrato" data-field="x_idcontrato" data-hidden="1" name="x<?= $Page->RowIndex ?>_idcontrato" id="x<?= $Page->RowIndex ?>_idcontrato" value="<?= HtmlEncode($Page->idcontrato->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <td data-name="cliente_idcliente"<?= $Page->cliente_idcliente->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_cliente_idcliente" class="el_contrato_cliente_idcliente">
    <select
        id="x<?= $Page->RowIndex ?>_cliente_idcliente"
        name="x<?= $Page->RowIndex ?>_cliente_idcliente"
        class="form-control ew-select<?= $Page->cliente_idcliente->isInvalidClass() ?>"
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_cliente_idcliente"
        data-table="contrato"
        data-field="x_cliente_idcliente"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->cliente_idcliente->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->cliente_idcliente->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cliente_idcliente->getPlaceHolder()) ?>"
        <?= $Page->cliente_idcliente->editAttributes() ?>>
        <?= $Page->cliente_idcliente->selectOptionListHtml("x{$Page->RowIndex}_cliente_idcliente") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->cliente_idcliente->getErrorMessage() ?></div>
<?= $Page->cliente_idcliente->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_cliente_idcliente") ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_cliente_idcliente", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_cliente_idcliente" };
    if (<?= $Page->FormName ?>.lists.cliente_idcliente?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_cliente_idcliente", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_cliente_idcliente", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.contrato.fields.cliente_idcliente.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="contrato" data-field="x_cliente_idcliente" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_cliente_idcliente" id="o<?= $Page->RowIndex ?>_cliente_idcliente" value="<?= HtmlEncode($Page->cliente_idcliente->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_cliente_idcliente" class="el_contrato_cliente_idcliente">
    <select
        id="x<?= $Page->RowIndex ?>_cliente_idcliente"
        name="x<?= $Page->RowIndex ?>_cliente_idcliente"
        class="form-control ew-select<?= $Page->cliente_idcliente->isInvalidClass() ?>"
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_cliente_idcliente"
        data-table="contrato"
        data-field="x_cliente_idcliente"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->cliente_idcliente->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->cliente_idcliente->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cliente_idcliente->getPlaceHolder()) ?>"
        <?= $Page->cliente_idcliente->editAttributes() ?>>
        <?= $Page->cliente_idcliente->selectOptionListHtml("x{$Page->RowIndex}_cliente_idcliente") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->cliente_idcliente->getErrorMessage() ?></div>
<?= $Page->cliente_idcliente->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_cliente_idcliente") ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_cliente_idcliente", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_cliente_idcliente" };
    if (<?= $Page->FormName ?>.lists.cliente_idcliente?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_cliente_idcliente", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_cliente_idcliente", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.contrato.fields.cliente_idcliente.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_cliente_idcliente" class="el_contrato_cliente_idcliente">
<span<?= $Page->cliente_idcliente->viewAttributes() ?>>
<?= $Page->cliente_idcliente->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->valor->Visible) { // valor ?>
        <td data-name="valor"<?= $Page->valor->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_valor" class="el_contrato_valor">
<input type="<?= $Page->valor->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_valor" id="x<?= $Page->RowIndex ?>_valor" data-table="contrato" data-field="x_valor" value="<?= $Page->valor->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valor->formatPattern()) ?>"<?= $Page->valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->valor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="contrato" data-field="x_valor" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_valor" id="o<?= $Page->RowIndex ?>_valor" value="<?= HtmlEncode($Page->valor->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_valor" class="el_contrato_valor">
<input type="<?= $Page->valor->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_valor" id="x<?= $Page->RowIndex ?>_valor" data-table="contrato" data-field="x_valor" value="<?= $Page->valor->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valor->formatPattern()) ?>"<?= $Page->valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->valor->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_valor" class="el_contrato_valor">
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ativo->Visible) { // ativo ?>
        <td data-name="ativo"<?= $Page->ativo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_ativo" class="el_contrato_ativo">
<template id="tp_x<?= $Page->RowIndex ?>_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contrato" data-field="x_ativo" name="x<?= $Page->RowIndex ?>_ativo" id="x<?= $Page->RowIndex ?>_ativo"<?= $Page->ativo->editAttributes() ?>>
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
    data-table="contrato"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="contrato" data-field="x_ativo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_ativo" id="o<?= $Page->RowIndex ?>_ativo" value="<?= HtmlEncode($Page->ativo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_ativo" class="el_contrato_ativo">
<template id="tp_x<?= $Page->RowIndex ?>_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contrato" data-field="x_ativo" name="x<?= $Page->RowIndex ?>_ativo" id="x<?= $Page->RowIndex ?>_ativo"<?= $Page->ativo->editAttributes() ?>>
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
    data-table="contrato"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_contrato_ativo" class="el_contrato_ativo">
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
    <?php if ($Page->idcontrato->Visible) { // idcontrato ?>
        <td data-name="idcontrato" class="<?= $Page->idcontrato->footerCellClass() ?>"><span id="elf_contrato_idcontrato" class="contrato_idcontrato">
        </span></td>
    <?php } ?>
    <?php if ($Page->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <td data-name="cliente_idcliente" class="<?= $Page->cliente_idcliente->footerCellClass() ?>"><span id="elf_contrato_cliente_idcliente" class="contrato_cliente_idcliente">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->cliente_idcliente->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->valor->Visible) { // valor ?>
        <td data-name="valor" class="<?= $Page->valor->footerCellClass() ?>"><span id="elf_contrato_valor" class="contrato_valor">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->valor->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->ativo->Visible) { // ativo ?>
        <td data-name="ativo" class="<?= $Page->ativo->footerCellClass() ?>"><span id="elf_contrato_ativo" class="contrato_ativo">
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
    ew.addEventHandlers("contrato");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
