<?php

namespace PHPMaker2024\contratos;

// Page object
$ViewUniformeCargoPlaCustoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_uniforme_cargo_pla_custo: currentTable } });
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
            "idplanilha_custo": <?= $Page->idplanilha_custo->toClientList($Page) ?>,
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
<form name="fview_uniforme_cargo_pla_custosrch" id="fview_uniforme_cargo_pla_custosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_uniforme_cargo_pla_custosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_uniforme_cargo_pla_custo: currentTable } });
var currentForm;
var fview_uniforme_cargo_pla_custosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_uniforme_cargo_pla_custosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["proposta_idproposta", [ew.Validators.integer], fields.proposta_idproposta.isInvalid]
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
        <select
            id="x_idplanilha_custo"
            name="x_idplanilha_custo[]"
            class="form-control ew-select<?= $Page->idplanilha_custo->isInvalidClass() ?>"
            data-select2-id="fview_uniforme_cargo_pla_custosrch_x_idplanilha_custo"
            data-table="view_uniforme_cargo_pla_custo"
            data-field="x_idplanilha_custo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->idplanilha_custo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->idplanilha_custo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->idplanilha_custo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->idplanilha_custo->editAttributes() ?>>
            <?= $Page->idplanilha_custo->selectOptionListHtml("x_idplanilha_custo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->idplanilha_custo->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fview_uniforme_cargo_pla_custosrch", function() {
            var options = {
                name: "x_idplanilha_custo",
                selectId: "fview_uniforme_cargo_pla_custosrch_x_idplanilha_custo",
                ajax: { id: "x_idplanilha_custo", form: "fview_uniforme_cargo_pla_custosrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.view_uniforme_cargo_pla_custo.fields.idplanilha_custo.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
<?php
if (!$Page->proposta_idproposta->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_proposta_idproposta" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->proposta_idproposta->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_proposta_idproposta" class="ew-search-caption ew-label"><?= $Page->proposta_idproposta->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_proposta_idproposta" id="z_proposta_idproposta" value="=">
</div>
        </div>
        <div id="el_view_uniforme_cargo_pla_custo_proposta_idproposta" class="ew-search-field">
<input type="<?= $Page->proposta_idproposta->getInputTextType() ?>" name="x_proposta_idproposta" id="x_proposta_idproposta" data-table="view_uniforme_cargo_pla_custo" data-field="x_proposta_idproposta" value="<?= $Page->proposta_idproposta->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->proposta_idproposta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->proposta_idproposta->formatPattern()) ?>"<?= $Page->proposta_idproposta->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->proposta_idproposta->getErrorMessage(false) ?></div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_uniforme_cargo_pla_custosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_uniforme_cargo_pla_custosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_uniforme_cargo_pla_custosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_uniforme_cargo_pla_custosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_uniforme_cargo_pla_custo">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_uniforme_cargo_pla_custo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_uniforme_cargo_pla_custolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="idplanilha_custo" class="<?= $Page->idplanilha_custo->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_idplanilha_custo" class="view_uniforme_cargo_pla_custo_idplanilha_custo"><?= $Page->renderFieldHeader($Page->idplanilha_custo) ?></div></th>
<?php } ?>
<?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <th data-name="proposta_idproposta" class="<?= $Page->proposta_idproposta->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_proposta_idproposta" class="view_uniforme_cargo_pla_custo_proposta_idproposta"><?= $Page->renderFieldHeader($Page->proposta_idproposta) ?></div></th>
<?php } ?>
<?php if ($Page->dt_proposta->Visible) { // dt_proposta ?>
        <th data-name="dt_proposta" class="<?= $Page->dt_proposta->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_dt_proposta" class="view_uniforme_cargo_pla_custo_dt_proposta"><?= $Page->renderFieldHeader($Page->dt_proposta) ?></div></th>
<?php } ?>
<?php if ($Page->qtde_cargos->Visible) { // qtde_cargos ?>
        <th data-name="qtde_cargos" class="<?= $Page->qtde_cargos->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_qtde_cargos" class="view_uniforme_cargo_pla_custo_qtde_cargos"><?= $Page->renderFieldHeader($Page->qtde_cargos) ?></div></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
        <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_cargo" class="view_uniforme_cargo_pla_custo_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->uniforme->Visible) { // uniforme ?>
        <th data-name="uniforme" class="<?= $Page->uniforme->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_uniforme" class="view_uniforme_cargo_pla_custo_uniforme"><?= $Page->renderFieldHeader($Page->uniforme) ?></div></th>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
        <th data-name="qtde" class="<?= $Page->qtde->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_qtde" class="view_uniforme_cargo_pla_custo_qtde"><?= $Page->renderFieldHeader($Page->qtde) ?></div></th>
<?php } ?>
<?php if ($Page->periodo_troca->Visible) { // periodo_troca ?>
        <th data-name="periodo_troca" class="<?= $Page->periodo_troca->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_periodo_troca" class="view_uniforme_cargo_pla_custo_periodo_troca"><?= $Page->renderFieldHeader($Page->periodo_troca) ?></div></th>
<?php } ?>
<?php if ($Page->vr_unitario->Visible) { // vr_unitario ?>
        <th data-name="vr_unitario" class="<?= $Page->vr_unitario->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_vr_unitario" class="view_uniforme_cargo_pla_custo_vr_unitario"><?= $Page->renderFieldHeader($Page->vr_unitario) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_uniforme->Visible) { // tipo_uniforme ?>
        <th data-name="tipo_uniforme" class="<?= $Page->tipo_uniforme->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_tipo_uniforme" class="view_uniforme_cargo_pla_custo_tipo_uniforme"><?= $Page->renderFieldHeader($Page->tipo_uniforme) ?></div></th>
<?php } ?>
<?php if ($Page->vr_anual->Visible) { // vr_anual ?>
        <th data-name="vr_anual" class="<?= $Page->vr_anual->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_vr_anual" class="view_uniforme_cargo_pla_custo_vr_anual"><?= $Page->renderFieldHeader($Page->vr_anual) ?></div></th>
<?php } ?>
<?php if ($Page->vr_mesal->Visible) { // vr_mesal ?>
        <th data-name="vr_mesal" class="<?= $Page->vr_mesal->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_vr_mesal" class="view_uniforme_cargo_pla_custo_vr_mesal"><?= $Page->renderFieldHeader($Page->vr_mesal) ?></div></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div id="elh_view_uniforme_cargo_pla_custo_cliente" class="view_uniforme_cargo_pla_custo_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_idplanilha_custo" class="el_view_uniforme_cargo_pla_custo_idplanilha_custo">
<span<?= $Page->idplanilha_custo->viewAttributes() ?>>
<?= $Page->idplanilha_custo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <td data-name="proposta_idproposta"<?= $Page->proposta_idproposta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_proposta_idproposta" class="el_view_uniforme_cargo_pla_custo_proposta_idproposta">
<span<?= $Page->proposta_idproposta->viewAttributes() ?>>
<?= $Page->proposta_idproposta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dt_proposta->Visible) { // dt_proposta ?>
        <td data-name="dt_proposta"<?= $Page->dt_proposta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_dt_proposta" class="el_view_uniforme_cargo_pla_custo_dt_proposta">
<span<?= $Page->dt_proposta->viewAttributes() ?>>
<?= $Page->dt_proposta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->qtde_cargos->Visible) { // qtde_cargos ?>
        <td data-name="qtde_cargos"<?= $Page->qtde_cargos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_qtde_cargos" class="el_view_uniforme_cargo_pla_custo_qtde_cargos">
<span<?= $Page->qtde_cargos->viewAttributes() ?>>
<?= $Page->qtde_cargos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_cargo" class="el_view_uniforme_cargo_pla_custo_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uniforme->Visible) { // uniforme ?>
        <td data-name="uniforme"<?= $Page->uniforme->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_uniforme" class="el_view_uniforme_cargo_pla_custo_uniforme">
<span<?= $Page->uniforme->viewAttributes() ?>>
<?= $Page->uniforme->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->qtde->Visible) { // qtde ?>
        <td data-name="qtde"<?= $Page->qtde->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_qtde" class="el_view_uniforme_cargo_pla_custo_qtde">
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->periodo_troca->Visible) { // periodo_troca ?>
        <td data-name="periodo_troca"<?= $Page->periodo_troca->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_periodo_troca" class="el_view_uniforme_cargo_pla_custo_periodo_troca">
<span<?= $Page->periodo_troca->viewAttributes() ?>>
<?= $Page->periodo_troca->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vr_unitario->Visible) { // vr_unitario ?>
        <td data-name="vr_unitario"<?= $Page->vr_unitario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_vr_unitario" class="el_view_uniforme_cargo_pla_custo_vr_unitario">
<span<?= $Page->vr_unitario->viewAttributes() ?>>
<?= $Page->vr_unitario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_uniforme->Visible) { // tipo_uniforme ?>
        <td data-name="tipo_uniforme"<?= $Page->tipo_uniforme->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_tipo_uniforme" class="el_view_uniforme_cargo_pla_custo_tipo_uniforme">
<span<?= $Page->tipo_uniforme->viewAttributes() ?>>
<?= $Page->tipo_uniforme->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vr_anual->Visible) { // vr_anual ?>
        <td data-name="vr_anual"<?= $Page->vr_anual->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_vr_anual" class="el_view_uniforme_cargo_pla_custo_vr_anual">
<span<?= $Page->vr_anual->viewAttributes() ?>>
<?= $Page->vr_anual->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vr_mesal->Visible) { // vr_mesal ?>
        <td data-name="vr_mesal"<?= $Page->vr_mesal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_vr_mesal" class="el_view_uniforme_cargo_pla_custo_vr_mesal">
<span<?= $Page->vr_mesal->viewAttributes() ?>>
<?= $Page->vr_mesal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_uniforme_cargo_pla_custo_cliente" class="el_view_uniforme_cargo_pla_custo_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
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
        <td data-name="idplanilha_custo" class="<?= $Page->idplanilha_custo->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_idplanilha_custo" class="view_uniforme_cargo_pla_custo_idplanilha_custo">
        </span></td>
    <?php } ?>
    <?php if ($Page->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <td data-name="proposta_idproposta" class="<?= $Page->proposta_idproposta->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_proposta_idproposta" class="view_uniforme_cargo_pla_custo_proposta_idproposta">
        </span></td>
    <?php } ?>
    <?php if ($Page->dt_proposta->Visible) { // dt_proposta ?>
        <td data-name="dt_proposta" class="<?= $Page->dt_proposta->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_dt_proposta" class="view_uniforme_cargo_pla_custo_dt_proposta">
        </span></td>
    <?php } ?>
    <?php if ($Page->qtde_cargos->Visible) { // qtde_cargos ?>
        <td data-name="qtde_cargos" class="<?= $Page->qtde_cargos->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_qtde_cargos" class="view_uniforme_cargo_pla_custo_qtde_cargos">
        </span></td>
    <?php } ?>
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo" class="<?= $Page->cargo->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_cargo" class="view_uniforme_cargo_pla_custo_cargo">
        </span></td>
    <?php } ?>
    <?php if ($Page->uniforme->Visible) { // uniforme ?>
        <td data-name="uniforme" class="<?= $Page->uniforme->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_uniforme" class="view_uniforme_cargo_pla_custo_uniforme">
        </span></td>
    <?php } ?>
    <?php if ($Page->qtde->Visible) { // qtde ?>
        <td data-name="qtde" class="<?= $Page->qtde->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_qtde" class="view_uniforme_cargo_pla_custo_qtde">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->qtde->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->periodo_troca->Visible) { // periodo_troca ?>
        <td data-name="periodo_troca" class="<?= $Page->periodo_troca->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_periodo_troca" class="view_uniforme_cargo_pla_custo_periodo_troca">
        </span></td>
    <?php } ?>
    <?php if ($Page->vr_unitario->Visible) { // vr_unitario ?>
        <td data-name="vr_unitario" class="<?= $Page->vr_unitario->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_vr_unitario" class="view_uniforme_cargo_pla_custo_vr_unitario">
        </span></td>
    <?php } ?>
    <?php if ($Page->tipo_uniforme->Visible) { // tipo_uniforme ?>
        <td data-name="tipo_uniforme" class="<?= $Page->tipo_uniforme->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_tipo_uniforme" class="view_uniforme_cargo_pla_custo_tipo_uniforme">
        </span></td>
    <?php } ?>
    <?php if ($Page->vr_anual->Visible) { // vr_anual ?>
        <td data-name="vr_anual" class="<?= $Page->vr_anual->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_vr_anual" class="view_uniforme_cargo_pla_custo_vr_anual">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->vr_anual->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->vr_mesal->Visible) { // vr_mesal ?>
        <td data-name="vr_mesal" class="<?= $Page->vr_mesal->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_vr_mesal" class="view_uniforme_cargo_pla_custo_vr_mesal">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->vr_mesal->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente" class="<?= $Page->cliente->footerCellClass() ?>"><span id="elf_view_uniforme_cargo_pla_custo_cliente" class="view_uniforme_cargo_pla_custo_cliente">
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
    ew.addEventHandlers("view_uniforme_cargo_pla_custo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
