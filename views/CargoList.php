<?php

namespace PHPMaker2024\contratos;

// Page object
$CargoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cargo: currentTable } });
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
            ["cargo", [fields.cargo.visible && fields.cargo.required ? ew.Validators.required(fields.cargo.caption) : null], fields.cargo.isInvalid],
            ["abreviado", [fields.abreviado.visible && fields.abreviado.required ? ew.Validators.required(fields.abreviado.caption) : null], fields.abreviado.isInvalid],
            ["salario", [fields.salario.visible && fields.salario.required ? ew.Validators.required(fields.salario.caption) : null, ew.Validators.float], fields.salario.isInvalid],
            ["escala_idescala", [fields.escala_idescala.visible && fields.escala_idescala.required ? ew.Validators.required(fields.escala_idescala.caption) : null], fields.escala_idescala.isInvalid],
            ["periodo_idperiodo", [fields.periodo_idperiodo.visible && fields.periodo_idperiodo.required ? ew.Validators.required(fields.periodo_idperiodo.caption) : null], fields.periodo_idperiodo.isInvalid],
            ["jornada", [fields.jornada.visible && fields.jornada.required ? ew.Validators.required(fields.jornada.caption) : null, ew.Validators.float], fields.jornada.isInvalid],
            ["vt_dia", [fields.vt_dia.visible && fields.vt_dia.required ? ew.Validators.required(fields.vt_dia.caption) : null, ew.Validators.float], fields.vt_dia.isInvalid],
            ["vr_dia", [fields.vr_dia.visible && fields.vr_dia.required ? ew.Validators.required(fields.vr_dia.caption) : null, ew.Validators.float], fields.vr_dia.isInvalid],
            ["va_mes", [fields.va_mes.visible && fields.va_mes.required ? ew.Validators.required(fields.va_mes.caption) : null, ew.Validators.float], fields.va_mes.isInvalid],
            ["benef_social", [fields.benef_social.visible && fields.benef_social.required ? ew.Validators.required(fields.benef_social.caption) : null, ew.Validators.float], fields.benef_social.isInvalid],
            ["plr", [fields.plr.visible && fields.plr.required ? ew.Validators.required(fields.plr.caption) : null, ew.Validators.float], fields.plr.isInvalid],
            ["assis_medica", [fields.assis_medica.visible && fields.assis_medica.required ? ew.Validators.required(fields.assis_medica.caption) : null, ew.Validators.float], fields.assis_medica.isInvalid],
            ["assis_odonto", [fields.assis_odonto.visible && fields.assis_odonto.required ? ew.Validators.required(fields.assis_odonto.caption) : null, ew.Validators.float], fields.assis_odonto.isInvalid]
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
            "escala_idescala": <?= $Page->escala_idescala->toClientList($Page) ?>,
            "periodo_idperiodo": <?= $Page->periodo_idperiodo->toClientList($Page) ?>,
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
<?php if (!$Page->IsModal) { ?>
<form name="fcargosrch" id="fcargosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fcargosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cargo: currentTable } });
var currentForm;
var fcargosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fcargosrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fcargosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fcargosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fcargosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fcargosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="cargo">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_cargo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_cargolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_cargo_cargo" class="cargo_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->abreviado->Visible) { // abreviado ?>
        <th data-name="abreviado" class="<?= $Page->abreviado->headerCellClass() ?>"><div id="elh_cargo_abreviado" class="cargo_abreviado"><?= $Page->renderFieldHeader($Page->abreviado) ?></div></th>
<?php } ?>
<?php if ($Page->salario->Visible) { // salario ?>
        <th data-name="salario" class="<?= $Page->salario->headerCellClass() ?>"><div id="elh_cargo_salario" class="cargo_salario"><?= $Page->renderFieldHeader($Page->salario) ?></div></th>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <th data-name="escala_idescala" class="<?= $Page->escala_idescala->headerCellClass() ?>"><div id="elh_cargo_escala_idescala" class="cargo_escala_idescala"><?= $Page->renderFieldHeader($Page->escala_idescala) ?></div></th>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <th data-name="periodo_idperiodo" class="<?= $Page->periodo_idperiodo->headerCellClass() ?>"><div id="elh_cargo_periodo_idperiodo" class="cargo_periodo_idperiodo"><?= $Page->renderFieldHeader($Page->periodo_idperiodo) ?></div></th>
<?php } ?>
<?php if ($Page->jornada->Visible) { // jornada ?>
        <th data-name="jornada" class="<?= $Page->jornada->headerCellClass() ?>"><div id="elh_cargo_jornada" class="cargo_jornada"><?= $Page->renderFieldHeader($Page->jornada) ?></div></th>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <th data-name="vt_dia" class="<?= $Page->vt_dia->headerCellClass() ?>"><div id="elh_cargo_vt_dia" class="cargo_vt_dia"><?= $Page->renderFieldHeader($Page->vt_dia) ?></div></th>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <th data-name="vr_dia" class="<?= $Page->vr_dia->headerCellClass() ?>"><div id="elh_cargo_vr_dia" class="cargo_vr_dia"><?= $Page->renderFieldHeader($Page->vr_dia) ?></div></th>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
        <th data-name="va_mes" class="<?= $Page->va_mes->headerCellClass() ?>"><div id="elh_cargo_va_mes" class="cargo_va_mes"><?= $Page->renderFieldHeader($Page->va_mes) ?></div></th>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
        <th data-name="benef_social" class="<?= $Page->benef_social->headerCellClass() ?>"><div id="elh_cargo_benef_social" class="cargo_benef_social"><?= $Page->renderFieldHeader($Page->benef_social) ?></div></th>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
        <th data-name="plr" class="<?= $Page->plr->headerCellClass() ?>"><div id="elh_cargo_plr" class="cargo_plr"><?= $Page->renderFieldHeader($Page->plr) ?></div></th>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <th data-name="assis_medica" class="<?= $Page->assis_medica->headerCellClass() ?>"><div id="elh_cargo_assis_medica" class="cargo_assis_medica"><?= $Page->renderFieldHeader($Page->assis_medica) ?></div></th>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <th data-name="assis_odonto" class="<?= $Page->assis_odonto->headerCellClass() ?>"><div id="elh_cargo_assis_odonto" class="cargo_assis_odonto"><?= $Page->renderFieldHeader($Page->assis_odonto) ?></div></th>
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
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_cargo" class="el_cargo_cargo">
<input type="<?= $Page->cargo->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_cargo" id="x<?= $Page->RowIndex ?>_cargo" data-table="cargo" data-field="x_cargo" value="<?= $Page->cargo->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->cargo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cargo->formatPattern()) ?>"<?= $Page->cargo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cargo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_cargo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_cargo" id="o<?= $Page->RowIndex ?>_cargo" value="<?= HtmlEncode($Page->cargo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_cargo" class="el_cargo_cargo">
<input type="<?= $Page->cargo->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_cargo" id="x<?= $Page->RowIndex ?>_cargo" data-table="cargo" data-field="x_cargo" value="<?= $Page->cargo->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->cargo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cargo->formatPattern()) ?>"<?= $Page->cargo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cargo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_cargo" class="el_cargo_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->abreviado->Visible) { // abreviado ?>
        <td data-name="abreviado"<?= $Page->abreviado->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_abreviado" class="el_cargo_abreviado">
<input type="<?= $Page->abreviado->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_abreviado" id="x<?= $Page->RowIndex ?>_abreviado" data-table="cargo" data-field="x_abreviado" value="<?= $Page->abreviado->EditValue ?>" size="25" maxlength="25" placeholder="<?= HtmlEncode($Page->abreviado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->abreviado->formatPattern()) ?>"<?= $Page->abreviado->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->abreviado->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_abreviado" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_abreviado" id="o<?= $Page->RowIndex ?>_abreviado" value="<?= HtmlEncode($Page->abreviado->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_abreviado" class="el_cargo_abreviado">
<input type="<?= $Page->abreviado->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_abreviado" id="x<?= $Page->RowIndex ?>_abreviado" data-table="cargo" data-field="x_abreviado" value="<?= $Page->abreviado->EditValue ?>" size="25" maxlength="25" placeholder="<?= HtmlEncode($Page->abreviado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->abreviado->formatPattern()) ?>"<?= $Page->abreviado->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->abreviado->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_abreviado" class="el_cargo_abreviado">
<span<?= $Page->abreviado->viewAttributes() ?>>
<?= $Page->abreviado->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->salario->Visible) { // salario ?>
        <td data-name="salario"<?= $Page->salario->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_salario" class="el_cargo_salario">
<input type="<?= $Page->salario->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_salario" id="x<?= $Page->RowIndex ?>_salario" data-table="cargo" data-field="x_salario" value="<?= $Page->salario->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->salario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->salario->formatPattern()) ?>"<?= $Page->salario->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->salario->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_salario" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_salario" id="o<?= $Page->RowIndex ?>_salario" value="<?= HtmlEncode($Page->salario->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_salario" class="el_cargo_salario">
<input type="<?= $Page->salario->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_salario" id="x<?= $Page->RowIndex ?>_salario" data-table="cargo" data-field="x_salario" value="<?= $Page->salario->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->salario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->salario->formatPattern()) ?>"<?= $Page->salario->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->salario->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_salario" class="el_cargo_salario">
<span<?= $Page->salario->viewAttributes() ?>>
<?= $Page->salario->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <td data-name="escala_idescala"<?= $Page->escala_idescala->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_escala_idescala" class="el_cargo_escala_idescala">
<template id="tp_x<?= $Page->RowIndex ?>_escala_idescala">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cargo" data-field="x_escala_idescala" name="x<?= $Page->RowIndex ?>_escala_idescala" id="x<?= $Page->RowIndex ?>_escala_idescala"<?= $Page->escala_idescala->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_escala_idescala" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_escala_idescala"
    name="x<?= $Page->RowIndex ?>_escala_idescala"
    value="<?= HtmlEncode($Page->escala_idescala->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_escala_idescala"
    data-target="dsl_x<?= $Page->RowIndex ?>_escala_idescala"
    data-repeatcolumn="10"
    class="form-control<?= $Page->escala_idescala->isInvalidClass() ?>"
    data-table="cargo"
    data-field="x_escala_idescala"
    data-value-separator="<?= $Page->escala_idescala->displayValueSeparatorAttribute() ?>"
    <?= $Page->escala_idescala->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->escala_idescala->getErrorMessage() ?></div>
<?= $Page->escala_idescala->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_escala_idescala") ?>
</span>
<input type="hidden" data-table="cargo" data-field="x_escala_idescala" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_escala_idescala" id="o<?= $Page->RowIndex ?>_escala_idescala" value="<?= HtmlEncode($Page->escala_idescala->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_escala_idescala" class="el_cargo_escala_idescala">
<template id="tp_x<?= $Page->RowIndex ?>_escala_idescala">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cargo" data-field="x_escala_idescala" name="x<?= $Page->RowIndex ?>_escala_idescala" id="x<?= $Page->RowIndex ?>_escala_idescala"<?= $Page->escala_idescala->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_escala_idescala" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_escala_idescala"
    name="x<?= $Page->RowIndex ?>_escala_idescala"
    value="<?= HtmlEncode($Page->escala_idescala->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_escala_idescala"
    data-target="dsl_x<?= $Page->RowIndex ?>_escala_idescala"
    data-repeatcolumn="10"
    class="form-control<?= $Page->escala_idescala->isInvalidClass() ?>"
    data-table="cargo"
    data-field="x_escala_idescala"
    data-value-separator="<?= $Page->escala_idescala->displayValueSeparatorAttribute() ?>"
    <?= $Page->escala_idescala->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->escala_idescala->getErrorMessage() ?></div>
<?= $Page->escala_idescala->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_escala_idescala") ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_escala_idescala" class="el_cargo_escala_idescala">
<span<?= $Page->escala_idescala->viewAttributes() ?>>
<?= $Page->escala_idescala->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <td data-name="periodo_idperiodo"<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_periodo_idperiodo" class="el_cargo_periodo_idperiodo">
<template id="tp_x<?= $Page->RowIndex ?>_periodo_idperiodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cargo" data-field="x_periodo_idperiodo" name="x<?= $Page->RowIndex ?>_periodo_idperiodo" id="x<?= $Page->RowIndex ?>_periodo_idperiodo"<?= $Page->periodo_idperiodo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_periodo_idperiodo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_periodo_idperiodo"
    name="x<?= $Page->RowIndex ?>_periodo_idperiodo"
    value="<?= HtmlEncode($Page->periodo_idperiodo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_periodo_idperiodo"
    data-target="dsl_x<?= $Page->RowIndex ?>_periodo_idperiodo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodo_idperiodo->isInvalidClass() ?>"
    data-table="cargo"
    data-field="x_periodo_idperiodo"
    data-value-separator="<?= $Page->periodo_idperiodo->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodo_idperiodo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->periodo_idperiodo->getErrorMessage() ?></div>
<?= $Page->periodo_idperiodo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_periodo_idperiodo") ?>
</span>
<input type="hidden" data-table="cargo" data-field="x_periodo_idperiodo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_periodo_idperiodo" id="o<?= $Page->RowIndex ?>_periodo_idperiodo" value="<?= HtmlEncode($Page->periodo_idperiodo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_periodo_idperiodo" class="el_cargo_periodo_idperiodo">
<template id="tp_x<?= $Page->RowIndex ?>_periodo_idperiodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cargo" data-field="x_periodo_idperiodo" name="x<?= $Page->RowIndex ?>_periodo_idperiodo" id="x<?= $Page->RowIndex ?>_periodo_idperiodo"<?= $Page->periodo_idperiodo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_periodo_idperiodo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_periodo_idperiodo"
    name="x<?= $Page->RowIndex ?>_periodo_idperiodo"
    value="<?= HtmlEncode($Page->periodo_idperiodo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_periodo_idperiodo"
    data-target="dsl_x<?= $Page->RowIndex ?>_periodo_idperiodo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodo_idperiodo->isInvalidClass() ?>"
    data-table="cargo"
    data-field="x_periodo_idperiodo"
    data-value-separator="<?= $Page->periodo_idperiodo->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodo_idperiodo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->periodo_idperiodo->getErrorMessage() ?></div>
<?= $Page->periodo_idperiodo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_periodo_idperiodo") ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_periodo_idperiodo" class="el_cargo_periodo_idperiodo">
<span<?= $Page->periodo_idperiodo->viewAttributes() ?>>
<?= $Page->periodo_idperiodo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->jornada->Visible) { // jornada ?>
        <td data-name="jornada"<?= $Page->jornada->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_jornada" class="el_cargo_jornada">
<input type="<?= $Page->jornada->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_jornada" id="x<?= $Page->RowIndex ?>_jornada" data-table="cargo" data-field="x_jornada" value="<?= $Page->jornada->EditValue ?>" size="5" maxlength="2" placeholder="<?= HtmlEncode($Page->jornada->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->jornada->formatPattern()) ?>"<?= $Page->jornada->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->jornada->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_jornada" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_jornada" id="o<?= $Page->RowIndex ?>_jornada" value="<?= HtmlEncode($Page->jornada->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_jornada" class="el_cargo_jornada">
<input type="<?= $Page->jornada->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_jornada" id="x<?= $Page->RowIndex ?>_jornada" data-table="cargo" data-field="x_jornada" value="<?= $Page->jornada->EditValue ?>" size="5" maxlength="2" placeholder="<?= HtmlEncode($Page->jornada->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->jornada->formatPattern()) ?>"<?= $Page->jornada->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->jornada->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_jornada" class="el_cargo_jornada">
<span<?= $Page->jornada->viewAttributes() ?>>
<?= $Page->jornada->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <td data-name="vt_dia"<?= $Page->vt_dia->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_vt_dia" class="el_cargo_vt_dia">
<input type="<?= $Page->vt_dia->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_vt_dia" id="x<?= $Page->RowIndex ?>_vt_dia" data-table="cargo" data-field="x_vt_dia" value="<?= $Page->vt_dia->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->vt_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vt_dia->formatPattern()) ?>"<?= $Page->vt_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vt_dia->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_vt_dia" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_vt_dia" id="o<?= $Page->RowIndex ?>_vt_dia" value="<?= HtmlEncode($Page->vt_dia->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_vt_dia" class="el_cargo_vt_dia">
<input type="<?= $Page->vt_dia->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_vt_dia" id="x<?= $Page->RowIndex ?>_vt_dia" data-table="cargo" data-field="x_vt_dia" value="<?= $Page->vt_dia->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->vt_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vt_dia->formatPattern()) ?>"<?= $Page->vt_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vt_dia->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_vt_dia" class="el_cargo_vt_dia">
<span<?= $Page->vt_dia->viewAttributes() ?>>
<?= $Page->vt_dia->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <td data-name="vr_dia"<?= $Page->vr_dia->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_vr_dia" class="el_cargo_vr_dia">
<input type="<?= $Page->vr_dia->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_vr_dia" id="x<?= $Page->RowIndex ?>_vr_dia" data-table="cargo" data-field="x_vr_dia" value="<?= $Page->vr_dia->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->vr_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_dia->formatPattern()) ?>"<?= $Page->vr_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vr_dia->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_vr_dia" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_vr_dia" id="o<?= $Page->RowIndex ?>_vr_dia" value="<?= HtmlEncode($Page->vr_dia->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_vr_dia" class="el_cargo_vr_dia">
<input type="<?= $Page->vr_dia->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_vr_dia" id="x<?= $Page->RowIndex ?>_vr_dia" data-table="cargo" data-field="x_vr_dia" value="<?= $Page->vr_dia->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->vr_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_dia->formatPattern()) ?>"<?= $Page->vr_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vr_dia->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_vr_dia" class="el_cargo_vr_dia">
<span<?= $Page->vr_dia->viewAttributes() ?>>
<?= $Page->vr_dia->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->va_mes->Visible) { // va_mes ?>
        <td data-name="va_mes"<?= $Page->va_mes->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_va_mes" class="el_cargo_va_mes">
<input type="<?= $Page->va_mes->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_va_mes" id="x<?= $Page->RowIndex ?>_va_mes" data-table="cargo" data-field="x_va_mes" value="<?= $Page->va_mes->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->va_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->va_mes->formatPattern()) ?>"<?= $Page->va_mes->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->va_mes->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_va_mes" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_va_mes" id="o<?= $Page->RowIndex ?>_va_mes" value="<?= HtmlEncode($Page->va_mes->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_va_mes" class="el_cargo_va_mes">
<input type="<?= $Page->va_mes->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_va_mes" id="x<?= $Page->RowIndex ?>_va_mes" data-table="cargo" data-field="x_va_mes" value="<?= $Page->va_mes->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->va_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->va_mes->formatPattern()) ?>"<?= $Page->va_mes->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->va_mes->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_va_mes" class="el_cargo_va_mes">
<span<?= $Page->va_mes->viewAttributes() ?>>
<?= $Page->va_mes->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->benef_social->Visible) { // benef_social ?>
        <td data-name="benef_social"<?= $Page->benef_social->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_benef_social" class="el_cargo_benef_social">
<input type="<?= $Page->benef_social->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_benef_social" id="x<?= $Page->RowIndex ?>_benef_social" data-table="cargo" data-field="x_benef_social" value="<?= $Page->benef_social->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->benef_social->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->benef_social->formatPattern()) ?>"<?= $Page->benef_social->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->benef_social->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_benef_social" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_benef_social" id="o<?= $Page->RowIndex ?>_benef_social" value="<?= HtmlEncode($Page->benef_social->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_benef_social" class="el_cargo_benef_social">
<input type="<?= $Page->benef_social->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_benef_social" id="x<?= $Page->RowIndex ?>_benef_social" data-table="cargo" data-field="x_benef_social" value="<?= $Page->benef_social->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->benef_social->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->benef_social->formatPattern()) ?>"<?= $Page->benef_social->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->benef_social->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_benef_social" class="el_cargo_benef_social">
<span<?= $Page->benef_social->viewAttributes() ?>>
<?= $Page->benef_social->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->plr->Visible) { // plr ?>
        <td data-name="plr"<?= $Page->plr->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_plr" class="el_cargo_plr">
<input type="<?= $Page->plr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_plr" id="x<?= $Page->RowIndex ?>_plr" data-table="cargo" data-field="x_plr" value="<?= $Page->plr->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->plr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->plr->formatPattern()) ?>"<?= $Page->plr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->plr->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_plr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_plr" id="o<?= $Page->RowIndex ?>_plr" value="<?= HtmlEncode($Page->plr->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_plr" class="el_cargo_plr">
<input type="<?= $Page->plr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_plr" id="x<?= $Page->RowIndex ?>_plr" data-table="cargo" data-field="x_plr" value="<?= $Page->plr->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->plr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->plr->formatPattern()) ?>"<?= $Page->plr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->plr->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_plr" class="el_cargo_plr">
<span<?= $Page->plr->viewAttributes() ?>>
<?= $Page->plr->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <td data-name="assis_medica"<?= $Page->assis_medica->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_assis_medica" class="el_cargo_assis_medica">
<input type="<?= $Page->assis_medica->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_assis_medica" id="x<?= $Page->RowIndex ?>_assis_medica" data-table="cargo" data-field="x_assis_medica" value="<?= $Page->assis_medica->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->assis_medica->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_medica->formatPattern()) ?>"<?= $Page->assis_medica->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assis_medica->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_assis_medica" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_assis_medica" id="o<?= $Page->RowIndex ?>_assis_medica" value="<?= HtmlEncode($Page->assis_medica->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_assis_medica" class="el_cargo_assis_medica">
<input type="<?= $Page->assis_medica->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_assis_medica" id="x<?= $Page->RowIndex ?>_assis_medica" data-table="cargo" data-field="x_assis_medica" value="<?= $Page->assis_medica->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->assis_medica->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_medica->formatPattern()) ?>"<?= $Page->assis_medica->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assis_medica->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_assis_medica" class="el_cargo_assis_medica">
<span<?= $Page->assis_medica->viewAttributes() ?>>
<?= $Page->assis_medica->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <td data-name="assis_odonto"<?= $Page->assis_odonto->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_assis_odonto" class="el_cargo_assis_odonto">
<input type="<?= $Page->assis_odonto->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_assis_odonto" id="x<?= $Page->RowIndex ?>_assis_odonto" data-table="cargo" data-field="x_assis_odonto" value="<?= $Page->assis_odonto->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->assis_odonto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_odonto->formatPattern()) ?>"<?= $Page->assis_odonto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assis_odonto->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cargo" data-field="x_assis_odonto" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_assis_odonto" id="o<?= $Page->RowIndex ?>_assis_odonto" value="<?= HtmlEncode($Page->assis_odonto->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_assis_odonto" class="el_cargo_assis_odonto">
<input type="<?= $Page->assis_odonto->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_assis_odonto" id="x<?= $Page->RowIndex ?>_assis_odonto" data-table="cargo" data-field="x_assis_odonto" value="<?= $Page->assis_odonto->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->assis_odonto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_odonto->formatPattern()) ?>"<?= $Page->assis_odonto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assis_odonto->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_assis_odonto" class="el_cargo_assis_odonto">
<span<?= $Page->assis_odonto->viewAttributes() ?>>
<?= $Page->assis_odonto->getViewValue() ?></span>
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
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo" class="<?= $Page->cargo->footerCellClass() ?>"><span id="elf_cargo_cargo" class="cargo_cargo">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->cargo->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->abreviado->Visible) { // abreviado ?>
        <td data-name="abreviado" class="<?= $Page->abreviado->footerCellClass() ?>"><span id="elf_cargo_abreviado" class="cargo_abreviado">
        </span></td>
    <?php } ?>
    <?php if ($Page->salario->Visible) { // salario ?>
        <td data-name="salario" class="<?= $Page->salario->footerCellClass() ?>"><span id="elf_cargo_salario" class="cargo_salario">
        </span></td>
    <?php } ?>
    <?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <td data-name="escala_idescala" class="<?= $Page->escala_idescala->footerCellClass() ?>"><span id="elf_cargo_escala_idescala" class="cargo_escala_idescala">
        </span></td>
    <?php } ?>
    <?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <td data-name="periodo_idperiodo" class="<?= $Page->periodo_idperiodo->footerCellClass() ?>"><span id="elf_cargo_periodo_idperiodo" class="cargo_periodo_idperiodo">
        </span></td>
    <?php } ?>
    <?php if ($Page->jornada->Visible) { // jornada ?>
        <td data-name="jornada" class="<?= $Page->jornada->footerCellClass() ?>"><span id="elf_cargo_jornada" class="cargo_jornada">
        </span></td>
    <?php } ?>
    <?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <td data-name="vt_dia" class="<?= $Page->vt_dia->footerCellClass() ?>"><span id="elf_cargo_vt_dia" class="cargo_vt_dia">
        </span></td>
    <?php } ?>
    <?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <td data-name="vr_dia" class="<?= $Page->vr_dia->footerCellClass() ?>"><span id="elf_cargo_vr_dia" class="cargo_vr_dia">
        </span></td>
    <?php } ?>
    <?php if ($Page->va_mes->Visible) { // va_mes ?>
        <td data-name="va_mes" class="<?= $Page->va_mes->footerCellClass() ?>"><span id="elf_cargo_va_mes" class="cargo_va_mes">
        </span></td>
    <?php } ?>
    <?php if ($Page->benef_social->Visible) { // benef_social ?>
        <td data-name="benef_social" class="<?= $Page->benef_social->footerCellClass() ?>"><span id="elf_cargo_benef_social" class="cargo_benef_social">
        </span></td>
    <?php } ?>
    <?php if ($Page->plr->Visible) { // plr ?>
        <td data-name="plr" class="<?= $Page->plr->footerCellClass() ?>"><span id="elf_cargo_plr" class="cargo_plr">
        </span></td>
    <?php } ?>
    <?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <td data-name="assis_medica" class="<?= $Page->assis_medica->footerCellClass() ?>"><span id="elf_cargo_assis_medica" class="cargo_assis_medica">
        </span></td>
    <?php } ?>
    <?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <td data-name="assis_odonto" class="<?= $Page->assis_odonto->footerCellClass() ?>"><span id="elf_cargo_assis_odonto" class="cargo_assis_odonto">
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
    ew.addEventHandlers("cargo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
