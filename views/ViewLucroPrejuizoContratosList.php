<?php

namespace PHPMaker2024\contratos;

// Page object
$ViewLucroPrejuizoContratosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_lucro_prejuizo_contratos: currentTable } });
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

        // Dynamic selection lists
        .setLists({
            "cliente": <?= $Page->cliente->toClientList($Page) ?>,
            "Diferenca": <?= $Page->Diferenca->toClientList($Page) ?>,
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
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fview_lucro_prejuizo_contratossrch" id="fview_lucro_prejuizo_contratossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_lucro_prejuizo_contratossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_lucro_prejuizo_contratos: currentTable } });
var currentForm;
var fview_lucro_prejuizo_contratossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_lucro_prejuizo_contratossrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
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
            "cliente": <?= $Page->cliente->toClientList($Page) ?>,
            "Diferenca": <?= $Page->Diferenca->toClientList($Page) ?>,
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
<?php if ($Page->cliente->Visible) { // cliente ?>
<?php
if (!$Page->cliente->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_cliente" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->cliente->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_cliente"
            name="x_cliente[]"
            class="form-control ew-select<?= $Page->cliente->isInvalidClass() ?>"
            data-select2-id="fview_lucro_prejuizo_contratossrch_x_cliente"
            data-table="view_lucro_prejuizo_contratos"
            data-field="x_cliente"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->cliente->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->cliente->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->cliente->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->cliente->editAttributes() ?>>
            <?= $Page->cliente->selectOptionListHtml("x_cliente", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->cliente->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fview_lucro_prejuizo_contratossrch", function() {
            var options = {
                name: "x_cliente",
                selectId: "fview_lucro_prejuizo_contratossrch_x_cliente",
                ajax: { id: "x_cliente", form: "fview_lucro_prejuizo_contratossrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.view_lucro_prejuizo_contratos.fields.cliente.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->Diferenca->Visible) { // Diferença ?>
<?php
if (!$Page->Diferenca->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_Diferenca" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->Diferenca->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_Diferenca"
            name="x_Diferenca[]"
            class="form-control ew-select<?= $Page->Diferenca->isInvalidClass() ?>"
            data-select2-id="fview_lucro_prejuizo_contratossrch_x_Diferenca"
            data-table="view_lucro_prejuizo_contratos"
            data-field="x_Diferenca"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->Diferenca->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->Diferenca->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->Diferenca->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->Diferenca->editAttributes() ?>>
            <?= $Page->Diferenca->selectOptionListHtml("x_Diferenca", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->Diferenca->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fview_lucro_prejuizo_contratossrch", function() {
            var options = {
                name: "x_Diferenca",
                selectId: "fview_lucro_prejuizo_contratossrch_x_Diferenca",
                ajax: { id: "x_Diferenca", form: "fview_lucro_prejuizo_contratossrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.view_lucro_prejuizo_contratos.fields.Diferenca.filterOptions);
            ew.createFilter(options);
        });
        </script>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_lucro_prejuizo_contratossrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_lucro_prejuizo_contratossrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_lucro_prejuizo_contratossrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_lucro_prejuizo_contratossrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
<!-- Middle Container -->
<div id="ew-middle" class="<?= $Page->MiddleContentClass ?>">
<?php } ?>
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
<!-- Content Container -->
<div id="ew-content" class="<?= $Page->ContainerClass ?>">
<?php } ?>
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
<input type="hidden" name="t" value="view_lucro_prejuizo_contratos">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_lucro_prejuizo_contratos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_lucro_prejuizo_contratoslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_lucro_prejuizo_contratos_cliente" class="view_lucro_prejuizo_contratos_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->VrCobradoR->Visible) { // Vr Cobrado R$ ?>
        <th data-name="VrCobradoR" class="<?= $Page->VrCobradoR->headerCellClass() ?>"><div id="elh_view_lucro_prejuizo_contratos_VrCobradoR" class="view_lucro_prejuizo_contratos_VrCobradoR"><?= $Page->renderFieldHeader($Page->VrCobradoR) ?></div></th>
<?php } ?>
<?php if ($Page->CustoCalculadoR->Visible) { // Custo Calculado R$ ?>
        <th data-name="CustoCalculadoR" class="<?= $Page->CustoCalculadoR->headerCellClass() ?>"><div id="elh_view_lucro_prejuizo_contratos_CustoCalculadoR" class="view_lucro_prejuizo_contratos_CustoCalculadoR"><?= $Page->renderFieldHeader($Page->CustoCalculadoR) ?></div></th>
<?php } ?>
<?php if ($Page->Diferenca->Visible) { // Diferença ?>
        <th data-name="Diferenca" class="<?= $Page->Diferenca->headerCellClass() ?>"><div id="elh_view_lucro_prejuizo_contratos_Diferenca" class="view_lucro_prejuizo_contratos_Diferenca"><?= $Page->renderFieldHeader($Page->Diferenca) ?></div></th>
<?php } ?>
<?php if ($Page->Margem->Visible) { // Margem ?>
        <th data-name="Margem" class="<?= $Page->Margem->headerCellClass() ?>"><div id="elh_view_lucro_prejuizo_contratos_Margem" class="view_lucro_prejuizo_contratos_Margem"><?= $Page->renderFieldHeader($Page->Margem) ?></div></th>
<?php } ?>
<?php if ($Page->Resultado->Visible) { // Resultado ?>
        <th data-name="Resultado" class="<?= $Page->Resultado->headerCellClass() ?>"><div id="elh_view_lucro_prejuizo_contratos_Resultado" class="view_lucro_prejuizo_contratos_Resultado"><?= $Page->renderFieldHeader($Page->Resultado) ?></div></th>
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
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_lucro_prejuizo_contratos_cliente" class="el_view_lucro_prejuizo_contratos_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VrCobradoR->Visible) { // Vr Cobrado R$ ?>
        <td data-name="VrCobradoR"<?= $Page->VrCobradoR->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_lucro_prejuizo_contratos_VrCobradoR" class="el_view_lucro_prejuizo_contratos_VrCobradoR">
<span<?= $Page->VrCobradoR->viewAttributes() ?>>
<?= $Page->VrCobradoR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CustoCalculadoR->Visible) { // Custo Calculado R$ ?>
        <td data-name="CustoCalculadoR"<?= $Page->CustoCalculadoR->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_lucro_prejuizo_contratos_CustoCalculadoR" class="el_view_lucro_prejuizo_contratos_CustoCalculadoR">
<span<?= $Page->CustoCalculadoR->viewAttributes() ?>>
<?= $Page->CustoCalculadoR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Diferenca->Visible) { // Diferença ?>
        <td data-name="Diferenca"<?= $Page->Diferenca->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_lucro_prejuizo_contratos_Diferenca" class="el_view_lucro_prejuizo_contratos_Diferenca">
<span<?= $Page->Diferenca->viewAttributes() ?>>
<?= $Page->Diferenca->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Margem->Visible) { // Margem ?>
        <td data-name="Margem"<?= $Page->Margem->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_lucro_prejuizo_contratos_Margem" class="el_view_lucro_prejuizo_contratos_Margem">
<span<?= $Page->Margem->viewAttributes() ?>>
<?= $Page->Margem->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Resultado->Visible) { // Resultado ?>
        <td data-name="Resultado"<?= $Page->Resultado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_lucro_prejuizo_contratos_Resultado" class="el_view_lucro_prejuizo_contratos_Resultado">
<span<?= $Page->Resultado->viewAttributes() ?>>
<?= $Page->Resultado->getViewValue() ?></span>
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
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente" class="<?= $Page->cliente->footerCellClass() ?>"><span id="elf_view_lucro_prejuizo_contratos_cliente" class="view_lucro_prejuizo_contratos_cliente">
        </span></td>
    <?php } ?>
    <?php if ($Page->VrCobradoR->Visible) { // Vr Cobrado R$ ?>
        <td data-name="VrCobradoR" class="<?= $Page->VrCobradoR->footerCellClass() ?>"><span id="elf_view_lucro_prejuizo_contratos_VrCobradoR" class="view_lucro_prejuizo_contratos_VrCobradoR">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->VrCobradoR->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->CustoCalculadoR->Visible) { // Custo Calculado R$ ?>
        <td data-name="CustoCalculadoR" class="<?= $Page->CustoCalculadoR->footerCellClass() ?>"><span id="elf_view_lucro_prejuizo_contratos_CustoCalculadoR" class="view_lucro_prejuizo_contratos_CustoCalculadoR">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->CustoCalculadoR->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->Diferenca->Visible) { // Diferença ?>
        <td data-name="Diferenca" class="<?= $Page->Diferenca->footerCellClass() ?>"><span id="elf_view_lucro_prejuizo_contratos_Diferenca" class="view_lucro_prejuizo_contratos_Diferenca">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->Diferenca->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->Margem->Visible) { // Margem ?>
        <td data-name="Margem" class="<?= $Page->Margem->footerCellClass() ?>"><span id="elf_view_lucro_prejuizo_contratos_Margem" class="view_lucro_prejuizo_contratos_Margem">
        </span></td>
    <?php } ?>
    <?php if ($Page->Resultado->Visible) { // Resultado ?>
        <td data-name="Resultado" class="<?= $Page->Resultado->footerCellClass() ?>"><span id="elf_view_lucro_prejuizo_contratos_Resultado" class="view_lucro_prejuizo_contratos_Resultado">
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
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
</div>
<!-- /#ew-content -->
<?php } ?>
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
</div>
<!-- /#ew-middle -->
<?php } ?>
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
<!-- Bottom Container -->
<div id="ew-bottom" class="<?= $Page->BottomContentClass ?>">
<?php } ?>
<?php
if (!$DashboardReport) {
    // Set up chart drilldown
    $Page->LucroxPrejuizo->DrillDownInPanel = $Page->DrillDownInPanel;
    echo $Page->LucroxPrejuizo->render("ew-chart-bottom");
}
?>
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
</div>
<!-- /#ew-bottom -->
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
    ew.addEventHandlers("view_lucro_prejuizo_contratos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
