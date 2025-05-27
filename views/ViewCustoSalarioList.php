<?php

namespace PHPMaker2024\contratos;

// Page object
$ViewCustoSalarioList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_custo_salario: currentTable } });
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
            "cargo": <?= $Page->cargo->toClientList($Page) ?>,
            "escala": <?= $Page->escala->toClientList($Page) ?>,
            "periodo": <?= $Page->periodo->toClientList($Page) ?>,
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
<form name="fview_custo_salariosrch" id="fview_custo_salariosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_custo_salariosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_custo_salario: currentTable } });
var currentForm;
var fview_custo_salariosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_custo_salariosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["escala", [], fields.escala.isInvalid],
            ["periodo", [], fields.periodo.isInvalid]
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
            "cargo": <?= $Page->cargo->toClientList($Page) ?>,
            "escala": <?= $Page->escala->toClientList($Page) ?>,
            "periodo": <?= $Page->periodo->toClientList($Page) ?>,
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
<?php if ($Page->cargo->Visible) { // cargo ?>
<?php
if (!$Page->cargo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_cargo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->cargo->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_cargo"
            name="x_cargo[]"
            class="form-control ew-select<?= $Page->cargo->isInvalidClass() ?>"
            data-select2-id="fview_custo_salariosrch_x_cargo"
            data-table="view_custo_salario"
            data-field="x_cargo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->cargo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->cargo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->cargo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->cargo->editAttributes() ?>>
            <?= $Page->cargo->selectOptionListHtml("x_cargo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->cargo->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fview_custo_salariosrch", function() {
            var options = {
                name: "x_cargo",
                selectId: "fview_custo_salariosrch_x_cargo",
                ajax: { id: "x_cargo", form: "fview_custo_salariosrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.view_custo_salario.fields.cargo.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->escala->Visible) { // escala ?>
<?php
if (!$Page->escala->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_escala" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->escala->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->escala->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_escala" id="z_escala" value="LIKE">
</div>
        </div>
        <div id="el_view_custo_salario_escala" class="ew-search-field">
<template id="tp_x_escala">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="view_custo_salario" data-field="x_escala" name="x_escala" id="x_escala"<?= $Page->escala->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_escala" class="ew-item-list"></div>
<selection-list hidden
    id="x_escala"
    name="x_escala"
    value="<?= HtmlEncode($Page->escala->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_escala"
    data-target="dsl_x_escala"
    data-repeatcolumn="5"
    class="form-control<?= $Page->escala->isInvalidClass() ?>"
    data-table="view_custo_salario"
    data-field="x_escala"
    data-value-separator="<?= $Page->escala->displayValueSeparatorAttribute() ?>"
    <?= $Page->escala->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->escala->getErrorMessage(false) ?></div>
<?= $Page->escala->Lookup->getParamTag($Page, "p_x_escala") ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->periodo->Visible) { // periodo ?>
<?php
if (!$Page->periodo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_periodo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->periodo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->periodo->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_periodo" id="z_periodo" value="LIKE">
</div>
        </div>
        <div id="el_view_custo_salario_periodo" class="ew-search-field">
<template id="tp_x_periodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="view_custo_salario" data-field="x_periodo" name="x_periodo" id="x_periodo"<?= $Page->periodo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_periodo" class="ew-item-list"></div>
<selection-list hidden
    id="x_periodo"
    name="x_periodo"
    value="<?= HtmlEncode($Page->periodo->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_periodo"
    data-target="dsl_x_periodo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodo->isInvalidClass() ?>"
    data-table="view_custo_salario"
    data-field="x_periodo"
    data-value-separator="<?= $Page->periodo->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->periodo->getErrorMessage(false) ?></div>
<?= $Page->periodo->Lookup->getParamTag($Page, "p_x_periodo") ?>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_custo_salariosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_custo_salariosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_custo_salariosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_custo_salariosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_custo_salario">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_custo_salario" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_custo_salariolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->cargo->Visible) { // cargo ?>
        <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_view_custo_salario_cargo" class="view_custo_salario_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->salario->Visible) { // salario ?>
        <th data-name="salario" class="<?= $Page->salario->headerCellClass() ?>"><div id="elh_view_custo_salario_salario" class="view_custo_salario_salario"><?= $Page->renderFieldHeader($Page->salario) ?></div></th>
<?php } ?>
<?php if ($Page->escala->Visible) { // escala ?>
        <th data-name="escala" class="<?= $Page->escala->headerCellClass() ?>"><div id="elh_view_custo_salario_escala" class="view_custo_salario_escala"><?= $Page->renderFieldHeader($Page->escala) ?></div></th>
<?php } ?>
<?php if ($Page->periodo->Visible) { // periodo ?>
        <th data-name="periodo" class="<?= $Page->periodo->headerCellClass() ?>"><div id="elh_view_custo_salario_periodo" class="view_custo_salario_periodo"><?= $Page->renderFieldHeader($Page->periodo) ?></div></th>
<?php } ?>
<?php if ($Page->jornada->Visible) { // jornada ?>
        <th data-name="jornada" class="<?= $Page->jornada->headerCellClass() ?>"><div id="elh_view_custo_salario_jornada" class="view_custo_salario_jornada"><?= $Page->renderFieldHeader($Page->jornada) ?></div></th>
<?php } ?>
<?php if ($Page->nr_dias_mes->Visible) { // nr_dias_mes ?>
        <th data-name="nr_dias_mes" class="<?= $Page->nr_dias_mes->headerCellClass() ?>"><div id="elh_view_custo_salario_nr_dias_mes" class="view_custo_salario_nr_dias_mes"><?= $Page->renderFieldHeader($Page->nr_dias_mes) ?></div></th>
<?php } ?>
<?php if ($Page->ad_noite->Visible) { // ad_noite ?>
        <th data-name="ad_noite" class="<?= $Page->ad_noite->headerCellClass() ?>"><div id="elh_view_custo_salario_ad_noite" class="view_custo_salario_ad_noite"><?= $Page->renderFieldHeader($Page->ad_noite) ?></div></th>
<?php } ?>
<?php if ($Page->DSR_ad_noite->Visible) { // DSR_ad_noite ?>
        <th data-name="DSR_ad_noite" class="<?= $Page->DSR_ad_noite->headerCellClass() ?>"><div id="elh_view_custo_salario_DSR_ad_noite" class="view_custo_salario_DSR_ad_noite"><?= $Page->renderFieldHeader($Page->DSR_ad_noite) ?></div></th>
<?php } ?>
<?php if ($Page->he_50->Visible) { // he_50 ?>
        <th data-name="he_50" class="<?= $Page->he_50->headerCellClass() ?>"><div id="elh_view_custo_salario_he_50" class="view_custo_salario_he_50"><?= $Page->renderFieldHeader($Page->he_50) ?></div></th>
<?php } ?>
<?php if ($Page->DSR_he_50->Visible) { // DSR_he_50 ?>
        <th data-name="DSR_he_50" class="<?= $Page->DSR_he_50->headerCellClass() ?>"><div id="elh_view_custo_salario_DSR_he_50" class="view_custo_salario_DSR_he_50"><?= $Page->renderFieldHeader($Page->DSR_he_50) ?></div></th>
<?php } ?>
<?php if ($Page->intra_todos->Visible) { // intra_todos ?>
        <th data-name="intra_todos" class="<?= $Page->intra_todos->headerCellClass() ?>"><div id="elh_view_custo_salario_intra_todos" class="view_custo_salario_intra_todos"><?= $Page->renderFieldHeader($Page->intra_todos) ?></div></th>
<?php } ?>
<?php if ($Page->intra_SabDomFer->Visible) { // intra_SabDomFer ?>
        <th data-name="intra_SabDomFer" class="<?= $Page->intra_SabDomFer->headerCellClass() ?>"><div id="elh_view_custo_salario_intra_SabDomFer" class="view_custo_salario_intra_SabDomFer"><?= $Page->renderFieldHeader($Page->intra_SabDomFer) ?></div></th>
<?php } ?>
<?php if ($Page->intra_DomFer->Visible) { // intra_DomFer ?>
        <th data-name="intra_DomFer" class="<?= $Page->intra_DomFer->headerCellClass() ?>"><div id="elh_view_custo_salario_intra_DomFer" class="view_custo_salario_intra_DomFer"><?= $Page->renderFieldHeader($Page->intra_DomFer) ?></div></th>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <th data-name="vt_dia" class="<?= $Page->vt_dia->headerCellClass() ?>"><div id="elh_view_custo_salario_vt_dia" class="view_custo_salario_vt_dia"><?= $Page->renderFieldHeader($Page->vt_dia) ?></div></th>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <th data-name="vr_dia" class="<?= $Page->vr_dia->headerCellClass() ?>"><div id="elh_view_custo_salario_vr_dia" class="view_custo_salario_vr_dia"><?= $Page->renderFieldHeader($Page->vr_dia) ?></div></th>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
        <th data-name="va_mes" class="<?= $Page->va_mes->headerCellClass() ?>"><div id="elh_view_custo_salario_va_mes" class="view_custo_salario_va_mes"><?= $Page->renderFieldHeader($Page->va_mes) ?></div></th>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
        <th data-name="benef_social" class="<?= $Page->benef_social->headerCellClass() ?>"><div id="elh_view_custo_salario_benef_social" class="view_custo_salario_benef_social"><?= $Page->renderFieldHeader($Page->benef_social) ?></div></th>
<?php } ?>
<?php if ($Page->plr_mes->Visible) { // plr_mes ?>
        <th data-name="plr_mes" class="<?= $Page->plr_mes->headerCellClass() ?>"><div id="elh_view_custo_salario_plr_mes" class="view_custo_salario_plr_mes"><?= $Page->renderFieldHeader($Page->plr_mes) ?></div></th>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <th data-name="assis_medica" class="<?= $Page->assis_medica->headerCellClass() ?>"><div id="elh_view_custo_salario_assis_medica" class="view_custo_salario_assis_medica"><?= $Page->renderFieldHeader($Page->assis_medica) ?></div></th>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <th data-name="assis_odonto" class="<?= $Page->assis_odonto->headerCellClass() ?>"><div id="elh_view_custo_salario_assis_odonto" class="view_custo_salario_assis_odonto"><?= $Page->renderFieldHeader($Page->assis_odonto) ?></div></th>
<?php } ?>
<?php if ($Page->desc_vt->Visible) { // desc_vt ?>
        <th data-name="desc_vt" class="<?= $Page->desc_vt->headerCellClass() ?>"><div id="elh_view_custo_salario_desc_vt" class="view_custo_salario_desc_vt"><?= $Page->renderFieldHeader($Page->desc_vt) ?></div></th>
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
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_cargo" class="el_view_custo_salario_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->salario->Visible) { // salario ?>
        <td data-name="salario"<?= $Page->salario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_salario" class="el_view_custo_salario_salario">
<span<?= $Page->salario->viewAttributes() ?>>
<?= $Page->salario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->escala->Visible) { // escala ?>
        <td data-name="escala"<?= $Page->escala->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_escala" class="el_view_custo_salario_escala">
<span<?= $Page->escala->viewAttributes() ?>>
<?= $Page->escala->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->periodo->Visible) { // periodo ?>
        <td data-name="periodo"<?= $Page->periodo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_periodo" class="el_view_custo_salario_periodo">
<span<?= $Page->periodo->viewAttributes() ?>>
<?= $Page->periodo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jornada->Visible) { // jornada ?>
        <td data-name="jornada"<?= $Page->jornada->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_jornada" class="el_view_custo_salario_jornada">
<span<?= $Page->jornada->viewAttributes() ?>>
<?= $Page->jornada->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nr_dias_mes->Visible) { // nr_dias_mes ?>
        <td data-name="nr_dias_mes"<?= $Page->nr_dias_mes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_nr_dias_mes" class="el_view_custo_salario_nr_dias_mes">
<span<?= $Page->nr_dias_mes->viewAttributes() ?>>
<?= $Page->nr_dias_mes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ad_noite->Visible) { // ad_noite ?>
        <td data-name="ad_noite"<?= $Page->ad_noite->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_ad_noite" class="el_view_custo_salario_ad_noite">
<span<?= $Page->ad_noite->viewAttributes() ?>>
<?= $Page->ad_noite->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DSR_ad_noite->Visible) { // DSR_ad_noite ?>
        <td data-name="DSR_ad_noite"<?= $Page->DSR_ad_noite->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_DSR_ad_noite" class="el_view_custo_salario_DSR_ad_noite">
<span<?= $Page->DSR_ad_noite->viewAttributes() ?>>
<?= $Page->DSR_ad_noite->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->he_50->Visible) { // he_50 ?>
        <td data-name="he_50"<?= $Page->he_50->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_he_50" class="el_view_custo_salario_he_50">
<span<?= $Page->he_50->viewAttributes() ?>>
<?= $Page->he_50->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DSR_he_50->Visible) { // DSR_he_50 ?>
        <td data-name="DSR_he_50"<?= $Page->DSR_he_50->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_DSR_he_50" class="el_view_custo_salario_DSR_he_50">
<span<?= $Page->DSR_he_50->viewAttributes() ?>>
<?= $Page->DSR_he_50->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->intra_todos->Visible) { // intra_todos ?>
        <td data-name="intra_todos"<?= $Page->intra_todos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_intra_todos" class="el_view_custo_salario_intra_todos">
<span<?= $Page->intra_todos->viewAttributes() ?>>
<?= $Page->intra_todos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->intra_SabDomFer->Visible) { // intra_SabDomFer ?>
        <td data-name="intra_SabDomFer"<?= $Page->intra_SabDomFer->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_intra_SabDomFer" class="el_view_custo_salario_intra_SabDomFer">
<span<?= $Page->intra_SabDomFer->viewAttributes() ?>>
<?= $Page->intra_SabDomFer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->intra_DomFer->Visible) { // intra_DomFer ?>
        <td data-name="intra_DomFer"<?= $Page->intra_DomFer->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_intra_DomFer" class="el_view_custo_salario_intra_DomFer">
<span<?= $Page->intra_DomFer->viewAttributes() ?>>
<?= $Page->intra_DomFer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <td data-name="vt_dia"<?= $Page->vt_dia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_vt_dia" class="el_view_custo_salario_vt_dia">
<span<?= $Page->vt_dia->viewAttributes() ?>>
<?= $Page->vt_dia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <td data-name="vr_dia"<?= $Page->vr_dia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_vr_dia" class="el_view_custo_salario_vr_dia">
<span<?= $Page->vr_dia->viewAttributes() ?>>
<?= $Page->vr_dia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->va_mes->Visible) { // va_mes ?>
        <td data-name="va_mes"<?= $Page->va_mes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_va_mes" class="el_view_custo_salario_va_mes">
<span<?= $Page->va_mes->viewAttributes() ?>>
<?= $Page->va_mes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->benef_social->Visible) { // benef_social ?>
        <td data-name="benef_social"<?= $Page->benef_social->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_benef_social" class="el_view_custo_salario_benef_social">
<span<?= $Page->benef_social->viewAttributes() ?>>
<?= $Page->benef_social->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->plr_mes->Visible) { // plr_mes ?>
        <td data-name="plr_mes"<?= $Page->plr_mes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_plr_mes" class="el_view_custo_salario_plr_mes">
<span<?= $Page->plr_mes->viewAttributes() ?>>
<?= $Page->plr_mes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <td data-name="assis_medica"<?= $Page->assis_medica->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_assis_medica" class="el_view_custo_salario_assis_medica">
<span<?= $Page->assis_medica->viewAttributes() ?>>
<?= $Page->assis_medica->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <td data-name="assis_odonto"<?= $Page->assis_odonto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_assis_odonto" class="el_view_custo_salario_assis_odonto">
<span<?= $Page->assis_odonto->viewAttributes() ?>>
<?= $Page->assis_odonto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->desc_vt->Visible) { // desc_vt ?>
        <td data-name="desc_vt"<?= $Page->desc_vt->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_custo_salario_desc_vt" class="el_view_custo_salario_desc_vt">
<span<?= $Page->desc_vt->viewAttributes() ?>>
<?= $Page->desc_vt->getViewValue() ?></span>
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
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo" class="<?= $Page->cargo->footerCellClass() ?>"><span id="elf_view_custo_salario_cargo" class="view_custo_salario_cargo">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->cargo->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->salario->Visible) { // salario ?>
        <td data-name="salario" class="<?= $Page->salario->footerCellClass() ?>"><span id="elf_view_custo_salario_salario" class="view_custo_salario_salario">
        </span></td>
    <?php } ?>
    <?php if ($Page->escala->Visible) { // escala ?>
        <td data-name="escala" class="<?= $Page->escala->footerCellClass() ?>"><span id="elf_view_custo_salario_escala" class="view_custo_salario_escala">
        </span></td>
    <?php } ?>
    <?php if ($Page->periodo->Visible) { // periodo ?>
        <td data-name="periodo" class="<?= $Page->periodo->footerCellClass() ?>"><span id="elf_view_custo_salario_periodo" class="view_custo_salario_periodo">
        </span></td>
    <?php } ?>
    <?php if ($Page->jornada->Visible) { // jornada ?>
        <td data-name="jornada" class="<?= $Page->jornada->footerCellClass() ?>"><span id="elf_view_custo_salario_jornada" class="view_custo_salario_jornada">
        </span></td>
    <?php } ?>
    <?php if ($Page->nr_dias_mes->Visible) { // nr_dias_mes ?>
        <td data-name="nr_dias_mes" class="<?= $Page->nr_dias_mes->footerCellClass() ?>"><span id="elf_view_custo_salario_nr_dias_mes" class="view_custo_salario_nr_dias_mes">
        </span></td>
    <?php } ?>
    <?php if ($Page->ad_noite->Visible) { // ad_noite ?>
        <td data-name="ad_noite" class="<?= $Page->ad_noite->footerCellClass() ?>"><span id="elf_view_custo_salario_ad_noite" class="view_custo_salario_ad_noite">
        </span></td>
    <?php } ?>
    <?php if ($Page->DSR_ad_noite->Visible) { // DSR_ad_noite ?>
        <td data-name="DSR_ad_noite" class="<?= $Page->DSR_ad_noite->footerCellClass() ?>"><span id="elf_view_custo_salario_DSR_ad_noite" class="view_custo_salario_DSR_ad_noite">
        </span></td>
    <?php } ?>
    <?php if ($Page->he_50->Visible) { // he_50 ?>
        <td data-name="he_50" class="<?= $Page->he_50->footerCellClass() ?>"><span id="elf_view_custo_salario_he_50" class="view_custo_salario_he_50">
        </span></td>
    <?php } ?>
    <?php if ($Page->DSR_he_50->Visible) { // DSR_he_50 ?>
        <td data-name="DSR_he_50" class="<?= $Page->DSR_he_50->footerCellClass() ?>"><span id="elf_view_custo_salario_DSR_he_50" class="view_custo_salario_DSR_he_50">
        </span></td>
    <?php } ?>
    <?php if ($Page->intra_todos->Visible) { // intra_todos ?>
        <td data-name="intra_todos" class="<?= $Page->intra_todos->footerCellClass() ?>"><span id="elf_view_custo_salario_intra_todos" class="view_custo_salario_intra_todos">
        </span></td>
    <?php } ?>
    <?php if ($Page->intra_SabDomFer->Visible) { // intra_SabDomFer ?>
        <td data-name="intra_SabDomFer" class="<?= $Page->intra_SabDomFer->footerCellClass() ?>"><span id="elf_view_custo_salario_intra_SabDomFer" class="view_custo_salario_intra_SabDomFer">
        </span></td>
    <?php } ?>
    <?php if ($Page->intra_DomFer->Visible) { // intra_DomFer ?>
        <td data-name="intra_DomFer" class="<?= $Page->intra_DomFer->footerCellClass() ?>"><span id="elf_view_custo_salario_intra_DomFer" class="view_custo_salario_intra_DomFer">
        </span></td>
    <?php } ?>
    <?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <td data-name="vt_dia" class="<?= $Page->vt_dia->footerCellClass() ?>"><span id="elf_view_custo_salario_vt_dia" class="view_custo_salario_vt_dia">
        </span></td>
    <?php } ?>
    <?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <td data-name="vr_dia" class="<?= $Page->vr_dia->footerCellClass() ?>"><span id="elf_view_custo_salario_vr_dia" class="view_custo_salario_vr_dia">
        </span></td>
    <?php } ?>
    <?php if ($Page->va_mes->Visible) { // va_mes ?>
        <td data-name="va_mes" class="<?= $Page->va_mes->footerCellClass() ?>"><span id="elf_view_custo_salario_va_mes" class="view_custo_salario_va_mes">
        </span></td>
    <?php } ?>
    <?php if ($Page->benef_social->Visible) { // benef_social ?>
        <td data-name="benef_social" class="<?= $Page->benef_social->footerCellClass() ?>"><span id="elf_view_custo_salario_benef_social" class="view_custo_salario_benef_social">
        </span></td>
    <?php } ?>
    <?php if ($Page->plr_mes->Visible) { // plr_mes ?>
        <td data-name="plr_mes" class="<?= $Page->plr_mes->footerCellClass() ?>"><span id="elf_view_custo_salario_plr_mes" class="view_custo_salario_plr_mes">
        </span></td>
    <?php } ?>
    <?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <td data-name="assis_medica" class="<?= $Page->assis_medica->footerCellClass() ?>"><span id="elf_view_custo_salario_assis_medica" class="view_custo_salario_assis_medica">
        </span></td>
    <?php } ?>
    <?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <td data-name="assis_odonto" class="<?= $Page->assis_odonto->footerCellClass() ?>"><span id="elf_view_custo_salario_assis_odonto" class="view_custo_salario_assis_odonto">
        </span></td>
    <?php } ?>
    <?php if ($Page->desc_vt->Visible) { // desc_vt ?>
        <td data-name="desc_vt" class="<?= $Page->desc_vt->footerCellClass() ?>"><span id="elf_view_custo_salario_desc_vt" class="view_custo_salario_desc_vt">
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
    ew.addEventHandlers("view_custo_salario");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
