<?php

namespace PHPMaker2024\contratos;

// Page object
$ViewComunicadoInternoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_comunicado_interno: currentTable } });
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
<form name="fview_comunicado_internosrch" id="fview_comunicado_internosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_comunicado_internosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_comunicado_interno: currentTable } });
var currentForm;
var fview_comunicado_internosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_comunicado_internosrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_comunicado_internosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_comunicado_internosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_comunicado_internosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_comunicado_internosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_comunicado_interno">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_comunicado_interno" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_comunicado_internolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="idproposta" class="<?= $Page->idproposta->headerCellClass() ?>"><div id="elh_view_comunicado_interno_idproposta" class="view_comunicado_interno_idproposta"><?= $Page->renderFieldHeader($Page->idproposta) ?></div></th>
<?php } ?>
<?php if ($Page->dt_proposta->Visible) { // dt_proposta ?>
        <th data-name="dt_proposta" class="<?= $Page->dt_proposta->headerCellClass() ?>"><div id="elh_view_comunicado_interno_dt_proposta" class="view_comunicado_interno_dt_proposta"><?= $Page->renderFieldHeader($Page->dt_proposta) ?></div></th>
<?php } ?>
<?php if ($Page->consultor->Visible) { // consultor ?>
        <th data-name="consultor" class="<?= $Page->consultor->headerCellClass() ?>"><div id="elh_view_comunicado_interno_consultor" class="view_comunicado_interno_consultor"><?= $Page->renderFieldHeader($Page->consultor) ?></div></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div id="elh_view_comunicado_interno_cliente" class="view_comunicado_interno_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->cnpj_cli->Visible) { // cnpj_cli ?>
        <th data-name="cnpj_cli" class="<?= $Page->cnpj_cli->headerCellClass() ?>"><div id="elh_view_comunicado_interno_cnpj_cli" class="view_comunicado_interno_cnpj_cli"><?= $Page->renderFieldHeader($Page->cnpj_cli) ?></div></th>
<?php } ?>
<?php if ($Page->end_cli->Visible) { // end_cli ?>
        <th data-name="end_cli" class="<?= $Page->end_cli->headerCellClass() ?>"><div id="elh_view_comunicado_interno_end_cli" class="view_comunicado_interno_end_cli"><?= $Page->renderFieldHeader($Page->end_cli) ?></div></th>
<?php } ?>
<?php if ($Page->nr_cli->Visible) { // nr_cli ?>
        <th data-name="nr_cli" class="<?= $Page->nr_cli->headerCellClass() ?>"><div id="elh_view_comunicado_interno_nr_cli" class="view_comunicado_interno_nr_cli"><?= $Page->renderFieldHeader($Page->nr_cli) ?></div></th>
<?php } ?>
<?php if ($Page->bairro_cli->Visible) { // bairro_cli ?>
        <th data-name="bairro_cli" class="<?= $Page->bairro_cli->headerCellClass() ?>"><div id="elh_view_comunicado_interno_bairro_cli" class="view_comunicado_interno_bairro_cli"><?= $Page->renderFieldHeader($Page->bairro_cli) ?></div></th>
<?php } ?>
<?php if ($Page->cep_cli->Visible) { // cep_cli ?>
        <th data-name="cep_cli" class="<?= $Page->cep_cli->headerCellClass() ?>"><div id="elh_view_comunicado_interno_cep_cli" class="view_comunicado_interno_cep_cli"><?= $Page->renderFieldHeader($Page->cep_cli) ?></div></th>
<?php } ?>
<?php if ($Page->cidade_cli->Visible) { // cidade_cli ?>
        <th data-name="cidade_cli" class="<?= $Page->cidade_cli->headerCellClass() ?>"><div id="elh_view_comunicado_interno_cidade_cli" class="view_comunicado_interno_cidade_cli"><?= $Page->renderFieldHeader($Page->cidade_cli) ?></div></th>
<?php } ?>
<?php if ($Page->uf_cli->Visible) { // uf_cli ?>
        <th data-name="uf_cli" class="<?= $Page->uf_cli->headerCellClass() ?>"><div id="elh_view_comunicado_interno_uf_cli" class="view_comunicado_interno_uf_cli"><?= $Page->renderFieldHeader($Page->uf_cli) ?></div></th>
<?php } ?>
<?php if ($Page->contato_cli->Visible) { // contato_cli ?>
        <th data-name="contato_cli" class="<?= $Page->contato_cli->headerCellClass() ?>"><div id="elh_view_comunicado_interno_contato_cli" class="view_comunicado_interno_contato_cli"><?= $Page->renderFieldHeader($Page->contato_cli) ?></div></th>
<?php } ?>
<?php if ($Page->email_cli->Visible) { // email_cli ?>
        <th data-name="email_cli" class="<?= $Page->email_cli->headerCellClass() ?>"><div id="elh_view_comunicado_interno_email_cli" class="view_comunicado_interno_email_cli"><?= $Page->renderFieldHeader($Page->email_cli) ?></div></th>
<?php } ?>
<?php if ($Page->tel_cli->Visible) { // tel_cli ?>
        <th data-name="tel_cli" class="<?= $Page->tel_cli->headerCellClass() ?>"><div id="elh_view_comunicado_interno_tel_cli" class="view_comunicado_interno_tel_cli"><?= $Page->renderFieldHeader($Page->tel_cli) ?></div></th>
<?php } ?>
<?php if ($Page->faturamento->Visible) { // faturamento ?>
        <th data-name="faturamento" class="<?= $Page->faturamento->headerCellClass() ?>"><div id="elh_view_comunicado_interno_faturamento" class="view_comunicado_interno_faturamento"><?= $Page->renderFieldHeader($Page->faturamento) ?></div></th>
<?php } ?>
<?php if ($Page->cnpj_fat->Visible) { // cnpj_fat ?>
        <th data-name="cnpj_fat" class="<?= $Page->cnpj_fat->headerCellClass() ?>"><div id="elh_view_comunicado_interno_cnpj_fat" class="view_comunicado_interno_cnpj_fat"><?= $Page->renderFieldHeader($Page->cnpj_fat) ?></div></th>
<?php } ?>
<?php if ($Page->end_fat->Visible) { // end_fat ?>
        <th data-name="end_fat" class="<?= $Page->end_fat->headerCellClass() ?>"><div id="elh_view_comunicado_interno_end_fat" class="view_comunicado_interno_end_fat"><?= $Page->renderFieldHeader($Page->end_fat) ?></div></th>
<?php } ?>
<?php if ($Page->bairro_fat->Visible) { // bairro_fat ?>
        <th data-name="bairro_fat" class="<?= $Page->bairro_fat->headerCellClass() ?>"><div id="elh_view_comunicado_interno_bairro_fat" class="view_comunicado_interno_bairro_fat"><?= $Page->renderFieldHeader($Page->bairro_fat) ?></div></th>
<?php } ?>
<?php if ($Page->cidae_fat->Visible) { // cidae_fat ?>
        <th data-name="cidae_fat" class="<?= $Page->cidae_fat->headerCellClass() ?>"><div id="elh_view_comunicado_interno_cidae_fat" class="view_comunicado_interno_cidae_fat"><?= $Page->renderFieldHeader($Page->cidae_fat) ?></div></th>
<?php } ?>
<?php if ($Page->uf_fat->Visible) { // uf_fat ?>
        <th data-name="uf_fat" class="<?= $Page->uf_fat->headerCellClass() ?>"><div id="elh_view_comunicado_interno_uf_fat" class="view_comunicado_interno_uf_fat"><?= $Page->renderFieldHeader($Page->uf_fat) ?></div></th>
<?php } ?>
<?php if ($Page->origem_fat->Visible) { // origem_fat ?>
        <th data-name="origem_fat" class="<?= $Page->origem_fat->headerCellClass() ?>"><div id="elh_view_comunicado_interno_origem_fat" class="view_comunicado_interno_origem_fat"><?= $Page->renderFieldHeader($Page->origem_fat) ?></div></th>
<?php } ?>
<?php if ($Page->dia_vencto_fat->Visible) { // dia_vencto_fat ?>
        <th data-name="dia_vencto_fat" class="<?= $Page->dia_vencto_fat->headerCellClass() ?>"><div id="elh_view_comunicado_interno_dia_vencto_fat" class="view_comunicado_interno_dia_vencto_fat"><?= $Page->renderFieldHeader($Page->dia_vencto_fat) ?></div></th>
<?php } ?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
        <th data-name="quantidade" class="<?= $Page->quantidade->headerCellClass() ?>"><div id="elh_view_comunicado_interno_quantidade" class="view_comunicado_interno_quantidade"><?= $Page->renderFieldHeader($Page->quantidade) ?></div></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
        <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div id="elh_view_comunicado_interno_cargo" class="view_comunicado_interno_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->escala->Visible) { // escala ?>
        <th data-name="escala" class="<?= $Page->escala->headerCellClass() ?>"><div id="elh_view_comunicado_interno_escala" class="view_comunicado_interno_escala"><?= $Page->renderFieldHeader($Page->escala) ?></div></th>
<?php } ?>
<?php if ($Page->periodo->Visible) { // periodo ?>
        <th data-name="periodo" class="<?= $Page->periodo->headerCellClass() ?>"><div id="elh_view_comunicado_interno_periodo" class="view_comunicado_interno_periodo"><?= $Page->renderFieldHeader($Page->periodo) ?></div></th>
<?php } ?>
<?php if ($Page->intrajornada_tipo->Visible) { // intrajornada_tipo ?>
        <th data-name="intrajornada_tipo" class="<?= $Page->intrajornada_tipo->headerCellClass() ?>"><div id="elh_view_comunicado_interno_intrajornada_tipo" class="view_comunicado_interno_intrajornada_tipo"><?= $Page->renderFieldHeader($Page->intrajornada_tipo) ?></div></th>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <th data-name="acumulo_funcao" class="<?= $Page->acumulo_funcao->headerCellClass() ?>"><div id="elh_view_comunicado_interno_acumulo_funcao" class="view_comunicado_interno_acumulo_funcao"><?= $Page->renderFieldHeader($Page->acumulo_funcao) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_idproposta" class="el_view_comunicado_interno_idproposta">
<span<?= $Page->idproposta->viewAttributes() ?>>
<?= $Page->idproposta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dt_proposta->Visible) { // dt_proposta ?>
        <td data-name="dt_proposta"<?= $Page->dt_proposta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_dt_proposta" class="el_view_comunicado_interno_dt_proposta">
<span<?= $Page->dt_proposta->viewAttributes() ?>>
<?= $Page->dt_proposta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->consultor->Visible) { // consultor ?>
        <td data-name="consultor"<?= $Page->consultor->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_consultor" class="el_view_comunicado_interno_consultor">
<span<?= $Page->consultor->viewAttributes() ?>>
<?= $Page->consultor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_cliente" class="el_view_comunicado_interno_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cnpj_cli->Visible) { // cnpj_cli ?>
        <td data-name="cnpj_cli"<?= $Page->cnpj_cli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_cnpj_cli" class="el_view_comunicado_interno_cnpj_cli">
<span<?= $Page->cnpj_cli->viewAttributes() ?>>
<?= $Page->cnpj_cli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->end_cli->Visible) { // end_cli ?>
        <td data-name="end_cli"<?= $Page->end_cli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_end_cli" class="el_view_comunicado_interno_end_cli">
<span<?= $Page->end_cli->viewAttributes() ?>>
<?= $Page->end_cli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nr_cli->Visible) { // nr_cli ?>
        <td data-name="nr_cli"<?= $Page->nr_cli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_nr_cli" class="el_view_comunicado_interno_nr_cli">
<span<?= $Page->nr_cli->viewAttributes() ?>>
<?= $Page->nr_cli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bairro_cli->Visible) { // bairro_cli ?>
        <td data-name="bairro_cli"<?= $Page->bairro_cli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_bairro_cli" class="el_view_comunicado_interno_bairro_cli">
<span<?= $Page->bairro_cli->viewAttributes() ?>>
<?= $Page->bairro_cli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cep_cli->Visible) { // cep_cli ?>
        <td data-name="cep_cli"<?= $Page->cep_cli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_cep_cli" class="el_view_comunicado_interno_cep_cli">
<span<?= $Page->cep_cli->viewAttributes() ?>>
<?= $Page->cep_cli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cidade_cli->Visible) { // cidade_cli ?>
        <td data-name="cidade_cli"<?= $Page->cidade_cli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_cidade_cli" class="el_view_comunicado_interno_cidade_cli">
<span<?= $Page->cidade_cli->viewAttributes() ?>>
<?= $Page->cidade_cli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uf_cli->Visible) { // uf_cli ?>
        <td data-name="uf_cli"<?= $Page->uf_cli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_uf_cli" class="el_view_comunicado_interno_uf_cli">
<span<?= $Page->uf_cli->viewAttributes() ?>>
<?= $Page->uf_cli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contato_cli->Visible) { // contato_cli ?>
        <td data-name="contato_cli"<?= $Page->contato_cli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_contato_cli" class="el_view_comunicado_interno_contato_cli">
<span<?= $Page->contato_cli->viewAttributes() ?>>
<?= $Page->contato_cli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->email_cli->Visible) { // email_cli ?>
        <td data-name="email_cli"<?= $Page->email_cli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_email_cli" class="el_view_comunicado_interno_email_cli">
<span<?= $Page->email_cli->viewAttributes() ?>>
<?= $Page->email_cli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tel_cli->Visible) { // tel_cli ?>
        <td data-name="tel_cli"<?= $Page->tel_cli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_tel_cli" class="el_view_comunicado_interno_tel_cli">
<span<?= $Page->tel_cli->viewAttributes() ?>>
<?= $Page->tel_cli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->faturamento->Visible) { // faturamento ?>
        <td data-name="faturamento"<?= $Page->faturamento->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_faturamento" class="el_view_comunicado_interno_faturamento">
<span<?= $Page->faturamento->viewAttributes() ?>>
<?= $Page->faturamento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cnpj_fat->Visible) { // cnpj_fat ?>
        <td data-name="cnpj_fat"<?= $Page->cnpj_fat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_cnpj_fat" class="el_view_comunicado_interno_cnpj_fat">
<span<?= $Page->cnpj_fat->viewAttributes() ?>>
<?= $Page->cnpj_fat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->end_fat->Visible) { // end_fat ?>
        <td data-name="end_fat"<?= $Page->end_fat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_end_fat" class="el_view_comunicado_interno_end_fat">
<span<?= $Page->end_fat->viewAttributes() ?>>
<?= $Page->end_fat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bairro_fat->Visible) { // bairro_fat ?>
        <td data-name="bairro_fat"<?= $Page->bairro_fat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_bairro_fat" class="el_view_comunicado_interno_bairro_fat">
<span<?= $Page->bairro_fat->viewAttributes() ?>>
<?= $Page->bairro_fat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cidae_fat->Visible) { // cidae_fat ?>
        <td data-name="cidae_fat"<?= $Page->cidae_fat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_cidae_fat" class="el_view_comunicado_interno_cidae_fat">
<span<?= $Page->cidae_fat->viewAttributes() ?>>
<?= $Page->cidae_fat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uf_fat->Visible) { // uf_fat ?>
        <td data-name="uf_fat"<?= $Page->uf_fat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_uf_fat" class="el_view_comunicado_interno_uf_fat">
<span<?= $Page->uf_fat->viewAttributes() ?>>
<?= $Page->uf_fat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->origem_fat->Visible) { // origem_fat ?>
        <td data-name="origem_fat"<?= $Page->origem_fat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_origem_fat" class="el_view_comunicado_interno_origem_fat">
<span<?= $Page->origem_fat->viewAttributes() ?>>
<?= $Page->origem_fat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dia_vencto_fat->Visible) { // dia_vencto_fat ?>
        <td data-name="dia_vencto_fat"<?= $Page->dia_vencto_fat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_dia_vencto_fat" class="el_view_comunicado_interno_dia_vencto_fat">
<span<?= $Page->dia_vencto_fat->viewAttributes() ?>>
<?= $Page->dia_vencto_fat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantidade->Visible) { // quantidade ?>
        <td data-name="quantidade"<?= $Page->quantidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_quantidade" class="el_view_comunicado_interno_quantidade">
<span<?= $Page->quantidade->viewAttributes() ?>>
<?= $Page->quantidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_cargo" class="el_view_comunicado_interno_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->escala->Visible) { // escala ?>
        <td data-name="escala"<?= $Page->escala->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_escala" class="el_view_comunicado_interno_escala">
<span<?= $Page->escala->viewAttributes() ?>>
<?= $Page->escala->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->periodo->Visible) { // periodo ?>
        <td data-name="periodo"<?= $Page->periodo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_periodo" class="el_view_comunicado_interno_periodo">
<span<?= $Page->periodo->viewAttributes() ?>>
<?= $Page->periodo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->intrajornada_tipo->Visible) { // intrajornada_tipo ?>
        <td data-name="intrajornada_tipo"<?= $Page->intrajornada_tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_intrajornada_tipo" class="el_view_comunicado_interno_intrajornada_tipo">
<span<?= $Page->intrajornada_tipo->viewAttributes() ?>>
<?= $Page->intrajornada_tipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <td data-name="acumulo_funcao"<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_comunicado_interno_acumulo_funcao" class="el_view_comunicado_interno_acumulo_funcao">
<span<?= $Page->acumulo_funcao->viewAttributes() ?>>
<?= $Page->acumulo_funcao->getViewValue() ?></span>
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
    ew.addEventHandlers("view_comunicado_interno");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
