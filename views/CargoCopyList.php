<?php

namespace PHPMaker2024\contratos;

// Page object
$CargoCopyList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cargo_copy: currentTable } });
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
<form name="fcargo_copysrch" id="fcargo_copysrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fcargo_copysrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cargo_copy: currentTable } });
var currentForm;
var fcargo_copysrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fcargo_copysrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fcargo_copysrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fcargo_copysrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fcargo_copysrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fcargo_copysrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="cargo_copy">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_cargo_copy" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_cargo_copylist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->idcargo->Visible) { // idcargo ?>
        <th data-name="idcargo" class="<?= $Page->idcargo->headerCellClass() ?>"><div id="elh_cargo_copy_idcargo" class="cargo_copy_idcargo"><?= $Page->renderFieldHeader($Page->idcargo) ?></div></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
        <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div id="elh_cargo_copy_cargo" class="cargo_copy_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->abreviado->Visible) { // abreviado ?>
        <th data-name="abreviado" class="<?= $Page->abreviado->headerCellClass() ?>"><div id="elh_cargo_copy_abreviado" class="cargo_copy_abreviado"><?= $Page->renderFieldHeader($Page->abreviado) ?></div></th>
<?php } ?>
<?php if ($Page->salario->Visible) { // salario ?>
        <th data-name="salario" class="<?= $Page->salario->headerCellClass() ?>"><div id="elh_cargo_copy_salario" class="cargo_copy_salario"><?= $Page->renderFieldHeader($Page->salario) ?></div></th>
<?php } ?>
<?php if ($Page->nr_horas_mes->Visible) { // nr_horas_mes ?>
        <th data-name="nr_horas_mes" class="<?= $Page->nr_horas_mes->headerCellClass() ?>"><div id="elh_cargo_copy_nr_horas_mes" class="cargo_copy_nr_horas_mes"><?= $Page->renderFieldHeader($Page->nr_horas_mes) ?></div></th>
<?php } ?>
<?php if ($Page->jornada->Visible) { // jornada ?>
        <th data-name="jornada" class="<?= $Page->jornada->headerCellClass() ?>"><div id="elh_cargo_copy_jornada" class="cargo_copy_jornada"><?= $Page->renderFieldHeader($Page->jornada) ?></div></th>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <th data-name="vt_dia" class="<?= $Page->vt_dia->headerCellClass() ?>"><div id="elh_cargo_copy_vt_dia" class="cargo_copy_vt_dia"><?= $Page->renderFieldHeader($Page->vt_dia) ?></div></th>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <th data-name="vr_dia" class="<?= $Page->vr_dia->headerCellClass() ?>"><div id="elh_cargo_copy_vr_dia" class="cargo_copy_vr_dia"><?= $Page->renderFieldHeader($Page->vr_dia) ?></div></th>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
        <th data-name="va_mes" class="<?= $Page->va_mes->headerCellClass() ?>"><div id="elh_cargo_copy_va_mes" class="cargo_copy_va_mes"><?= $Page->renderFieldHeader($Page->va_mes) ?></div></th>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
        <th data-name="benef_social" class="<?= $Page->benef_social->headerCellClass() ?>"><div id="elh_cargo_copy_benef_social" class="cargo_copy_benef_social"><?= $Page->renderFieldHeader($Page->benef_social) ?></div></th>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
        <th data-name="plr" class="<?= $Page->plr->headerCellClass() ?>"><div id="elh_cargo_copy_plr" class="cargo_copy_plr"><?= $Page->renderFieldHeader($Page->plr) ?></div></th>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <th data-name="assis_medica" class="<?= $Page->assis_medica->headerCellClass() ?>"><div id="elh_cargo_copy_assis_medica" class="cargo_copy_assis_medica"><?= $Page->renderFieldHeader($Page->assis_medica) ?></div></th>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <th data-name="assis_odonto" class="<?= $Page->assis_odonto->headerCellClass() ?>"><div id="elh_cargo_copy_assis_odonto" class="cargo_copy_assis_odonto"><?= $Page->renderFieldHeader($Page->assis_odonto) ?></div></th>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <th data-name="modulo_idmodulo" class="<?= $Page->modulo_idmodulo->headerCellClass() ?>"><div id="elh_cargo_copy_modulo_idmodulo" class="cargo_copy_modulo_idmodulo"><?= $Page->renderFieldHeader($Page->modulo_idmodulo) ?></div></th>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <th data-name="periodo_idperiodo" class="<?= $Page->periodo_idperiodo->headerCellClass() ?>"><div id="elh_cargo_copy_periodo_idperiodo" class="cargo_copy_periodo_idperiodo"><?= $Page->renderFieldHeader($Page->periodo_idperiodo) ?></div></th>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <th data-name="escala_idescala" class="<?= $Page->escala_idescala->headerCellClass() ?>"><div id="elh_cargo_copy_escala_idescala" class="cargo_copy_escala_idescala"><?= $Page->renderFieldHeader($Page->escala_idescala) ?></div></th>
<?php } ?>
<?php if ($Page->nr_horas_ad_noite->Visible) { // nr_horas_ad_noite ?>
        <th data-name="nr_horas_ad_noite" class="<?= $Page->nr_horas_ad_noite->headerCellClass() ?>"><div id="elh_cargo_copy_nr_horas_ad_noite" class="cargo_copy_nr_horas_ad_noite"><?= $Page->renderFieldHeader($Page->nr_horas_ad_noite) ?></div></th>
<?php } ?>
<?php if ($Page->intrajornada->Visible) { // intrajornada ?>
        <th data-name="intrajornada" class="<?= $Page->intrajornada->headerCellClass() ?>"><div id="elh_cargo_copy_intrajornada" class="cargo_copy_intrajornada"><?= $Page->renderFieldHeader($Page->intrajornada) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <th data-name="tipo_uniforme_idtipo_uniforme" class="<?= $Page->tipo_uniforme_idtipo_uniforme->headerCellClass() ?>"><div id="elh_cargo_copy_tipo_uniforme_idtipo_uniforme" class="cargo_copy_tipo_uniforme_idtipo_uniforme"><?= $Page->renderFieldHeader($Page->tipo_uniforme_idtipo_uniforme) ?></div></th>
<?php } ?>
<?php if ($Page->salario_antes->Visible) { // salario_antes ?>
        <th data-name="salario_antes" class="<?= $Page->salario_antes->headerCellClass() ?>"><div id="elh_cargo_copy_salario_antes" class="cargo_copy_salario_antes"><?= $Page->renderFieldHeader($Page->salario_antes) ?></div></th>
<?php } ?>
<?php if ($Page->vt_dia_antes->Visible) { // vt_dia_antes ?>
        <th data-name="vt_dia_antes" class="<?= $Page->vt_dia_antes->headerCellClass() ?>"><div id="elh_cargo_copy_vt_dia_antes" class="cargo_copy_vt_dia_antes"><?= $Page->renderFieldHeader($Page->vt_dia_antes) ?></div></th>
<?php } ?>
<?php if ($Page->vr_dia_antes->Visible) { // vr_dia_antes ?>
        <th data-name="vr_dia_antes" class="<?= $Page->vr_dia_antes->headerCellClass() ?>"><div id="elh_cargo_copy_vr_dia_antes" class="cargo_copy_vr_dia_antes"><?= $Page->renderFieldHeader($Page->vr_dia_antes) ?></div></th>
<?php } ?>
<?php if ($Page->va_mes_antes->Visible) { // va_mes_antes ?>
        <th data-name="va_mes_antes" class="<?= $Page->va_mes_antes->headerCellClass() ?>"><div id="elh_cargo_copy_va_mes_antes" class="cargo_copy_va_mes_antes"><?= $Page->renderFieldHeader($Page->va_mes_antes) ?></div></th>
<?php } ?>
<?php if ($Page->benef_social_antes->Visible) { // benef_social_antes ?>
        <th data-name="benef_social_antes" class="<?= $Page->benef_social_antes->headerCellClass() ?>"><div id="elh_cargo_copy_benef_social_antes" class="cargo_copy_benef_social_antes"><?= $Page->renderFieldHeader($Page->benef_social_antes) ?></div></th>
<?php } ?>
<?php if ($Page->plr_antes->Visible) { // plr_antes ?>
        <th data-name="plr_antes" class="<?= $Page->plr_antes->headerCellClass() ?>"><div id="elh_cargo_copy_plr_antes" class="cargo_copy_plr_antes"><?= $Page->renderFieldHeader($Page->plr_antes) ?></div></th>
<?php } ?>
<?php if ($Page->assis_medica_antes->Visible) { // assis_medica_antes ?>
        <th data-name="assis_medica_antes" class="<?= $Page->assis_medica_antes->headerCellClass() ?>"><div id="elh_cargo_copy_assis_medica_antes" class="cargo_copy_assis_medica_antes"><?= $Page->renderFieldHeader($Page->assis_medica_antes) ?></div></th>
<?php } ?>
<?php if ($Page->assis_odonto_antes->Visible) { // assis_odonto_antes ?>
        <th data-name="assis_odonto_antes" class="<?= $Page->assis_odonto_antes->headerCellClass() ?>"><div id="elh_cargo_copy_assis_odonto_antes" class="cargo_copy_assis_odonto_antes"><?= $Page->renderFieldHeader($Page->assis_odonto_antes) ?></div></th>
<?php } ?>
<?php if ($Page->funcao_idfuncao->Visible) { // funcao_idfuncao ?>
        <th data-name="funcao_idfuncao" class="<?= $Page->funcao_idfuncao->headerCellClass() ?>"><div id="elh_cargo_copy_funcao_idfuncao" class="cargo_copy_funcao_idfuncao"><?= $Page->renderFieldHeader($Page->funcao_idfuncao) ?></div></th>
<?php } ?>
<?php if ($Page->salario1->Visible) { // salario1 ?>
        <th data-name="salario1" class="<?= $Page->salario1->headerCellClass() ?>"><div id="elh_cargo_copy_salario1" class="cargo_copy_salario1"><?= $Page->renderFieldHeader($Page->salario1) ?></div></th>
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
    <?php if ($Page->idcargo->Visible) { // idcargo ?>
        <td data-name="idcargo"<?= $Page->idcargo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_idcargo" class="el_cargo_copy_idcargo">
<span<?= $Page->idcargo->viewAttributes() ?>>
<?= $Page->idcargo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_cargo" class="el_cargo_copy_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->abreviado->Visible) { // abreviado ?>
        <td data-name="abreviado"<?= $Page->abreviado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_abreviado" class="el_cargo_copy_abreviado">
<span<?= $Page->abreviado->viewAttributes() ?>>
<?= $Page->abreviado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->salario->Visible) { // salario ?>
        <td data-name="salario"<?= $Page->salario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_salario" class="el_cargo_copy_salario">
<span<?= $Page->salario->viewAttributes() ?>>
<?= $Page->salario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nr_horas_mes->Visible) { // nr_horas_mes ?>
        <td data-name="nr_horas_mes"<?= $Page->nr_horas_mes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_nr_horas_mes" class="el_cargo_copy_nr_horas_mes">
<span<?= $Page->nr_horas_mes->viewAttributes() ?>>
<?= $Page->nr_horas_mes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jornada->Visible) { // jornada ?>
        <td data-name="jornada"<?= $Page->jornada->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_jornada" class="el_cargo_copy_jornada">
<span<?= $Page->jornada->viewAttributes() ?>>
<?= $Page->jornada->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <td data-name="vt_dia"<?= $Page->vt_dia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_vt_dia" class="el_cargo_copy_vt_dia">
<span<?= $Page->vt_dia->viewAttributes() ?>>
<?= $Page->vt_dia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <td data-name="vr_dia"<?= $Page->vr_dia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_vr_dia" class="el_cargo_copy_vr_dia">
<span<?= $Page->vr_dia->viewAttributes() ?>>
<?= $Page->vr_dia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->va_mes->Visible) { // va_mes ?>
        <td data-name="va_mes"<?= $Page->va_mes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_va_mes" class="el_cargo_copy_va_mes">
<span<?= $Page->va_mes->viewAttributes() ?>>
<?= $Page->va_mes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->benef_social->Visible) { // benef_social ?>
        <td data-name="benef_social"<?= $Page->benef_social->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_benef_social" class="el_cargo_copy_benef_social">
<span<?= $Page->benef_social->viewAttributes() ?>>
<?= $Page->benef_social->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->plr->Visible) { // plr ?>
        <td data-name="plr"<?= $Page->plr->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_plr" class="el_cargo_copy_plr">
<span<?= $Page->plr->viewAttributes() ?>>
<?= $Page->plr->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <td data-name="assis_medica"<?= $Page->assis_medica->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_assis_medica" class="el_cargo_copy_assis_medica">
<span<?= $Page->assis_medica->viewAttributes() ?>>
<?= $Page->assis_medica->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <td data-name="assis_odonto"<?= $Page->assis_odonto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_assis_odonto" class="el_cargo_copy_assis_odonto">
<span<?= $Page->assis_odonto->viewAttributes() ?>>
<?= $Page->assis_odonto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <td data-name="modulo_idmodulo"<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_modulo_idmodulo" class="el_cargo_copy_modulo_idmodulo">
<span<?= $Page->modulo_idmodulo->viewAttributes() ?>>
<?= $Page->modulo_idmodulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <td data-name="periodo_idperiodo"<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_periodo_idperiodo" class="el_cargo_copy_periodo_idperiodo">
<span<?= $Page->periodo_idperiodo->viewAttributes() ?>>
<?= $Page->periodo_idperiodo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <td data-name="escala_idescala"<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_escala_idescala" class="el_cargo_copy_escala_idescala">
<span<?= $Page->escala_idescala->viewAttributes() ?>>
<?= $Page->escala_idescala->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nr_horas_ad_noite->Visible) { // nr_horas_ad_noite ?>
        <td data-name="nr_horas_ad_noite"<?= $Page->nr_horas_ad_noite->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_nr_horas_ad_noite" class="el_cargo_copy_nr_horas_ad_noite">
<span<?= $Page->nr_horas_ad_noite->viewAttributes() ?>>
<?= $Page->nr_horas_ad_noite->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->intrajornada->Visible) { // intrajornada ?>
        <td data-name="intrajornada"<?= $Page->intrajornada->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_intrajornada" class="el_cargo_copy_intrajornada">
<span<?= $Page->intrajornada->viewAttributes() ?>>
<?= $Page->intrajornada->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <td data-name="tipo_uniforme_idtipo_uniforme"<?= $Page->tipo_uniforme_idtipo_uniforme->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_tipo_uniforme_idtipo_uniforme" class="el_cargo_copy_tipo_uniforme_idtipo_uniforme">
<span<?= $Page->tipo_uniforme_idtipo_uniforme->viewAttributes() ?>>
<?= $Page->tipo_uniforme_idtipo_uniforme->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->salario_antes->Visible) { // salario_antes ?>
        <td data-name="salario_antes"<?= $Page->salario_antes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_salario_antes" class="el_cargo_copy_salario_antes">
<span<?= $Page->salario_antes->viewAttributes() ?>>
<?= $Page->salario_antes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vt_dia_antes->Visible) { // vt_dia_antes ?>
        <td data-name="vt_dia_antes"<?= $Page->vt_dia_antes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_vt_dia_antes" class="el_cargo_copy_vt_dia_antes">
<span<?= $Page->vt_dia_antes->viewAttributes() ?>>
<?= $Page->vt_dia_antes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vr_dia_antes->Visible) { // vr_dia_antes ?>
        <td data-name="vr_dia_antes"<?= $Page->vr_dia_antes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_vr_dia_antes" class="el_cargo_copy_vr_dia_antes">
<span<?= $Page->vr_dia_antes->viewAttributes() ?>>
<?= $Page->vr_dia_antes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->va_mes_antes->Visible) { // va_mes_antes ?>
        <td data-name="va_mes_antes"<?= $Page->va_mes_antes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_va_mes_antes" class="el_cargo_copy_va_mes_antes">
<span<?= $Page->va_mes_antes->viewAttributes() ?>>
<?= $Page->va_mes_antes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->benef_social_antes->Visible) { // benef_social_antes ?>
        <td data-name="benef_social_antes"<?= $Page->benef_social_antes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_benef_social_antes" class="el_cargo_copy_benef_social_antes">
<span<?= $Page->benef_social_antes->viewAttributes() ?>>
<?= $Page->benef_social_antes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->plr_antes->Visible) { // plr_antes ?>
        <td data-name="plr_antes"<?= $Page->plr_antes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_plr_antes" class="el_cargo_copy_plr_antes">
<span<?= $Page->plr_antes->viewAttributes() ?>>
<?= $Page->plr_antes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->assis_medica_antes->Visible) { // assis_medica_antes ?>
        <td data-name="assis_medica_antes"<?= $Page->assis_medica_antes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_assis_medica_antes" class="el_cargo_copy_assis_medica_antes">
<span<?= $Page->assis_medica_antes->viewAttributes() ?>>
<?= $Page->assis_medica_antes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->assis_odonto_antes->Visible) { // assis_odonto_antes ?>
        <td data-name="assis_odonto_antes"<?= $Page->assis_odonto_antes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_assis_odonto_antes" class="el_cargo_copy_assis_odonto_antes">
<span<?= $Page->assis_odonto_antes->viewAttributes() ?>>
<?= $Page->assis_odonto_antes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->funcao_idfuncao->Visible) { // funcao_idfuncao ?>
        <td data-name="funcao_idfuncao"<?= $Page->funcao_idfuncao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_funcao_idfuncao" class="el_cargo_copy_funcao_idfuncao">
<span<?= $Page->funcao_idfuncao->viewAttributes() ?>>
<?= $Page->funcao_idfuncao->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->salario1->Visible) { // salario1 ?>
        <td data-name="salario1"<?= $Page->salario1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cargo_copy_salario1" class="el_cargo_copy_salario1">
<span<?= $Page->salario1->viewAttributes() ?>>
<?= $Page->salario1->getViewValue() ?></span>
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
    ew.addEventHandlers("cargo_copy");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
