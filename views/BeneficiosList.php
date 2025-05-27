<?php

namespace PHPMaker2024\contratos;

// Page object
$BeneficiosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { beneficios: currentTable } });
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
            ["data", [fields.data.visible && fields.data.required ? ew.Validators.required(fields.data.caption) : null], fields.data.isInvalid],
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
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "dissidio_anual") {
    if ($Page->MasterRecordExists) {
        include_once "views/DissidioAnualMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
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
<input type="hidden" name="t" value="beneficios">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "dissidio_anual" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="dissidio_anual">
<input type="hidden" name="fk_iddissidio_anual" value="<?= HtmlEncode($Page->dissidio_anual_iddissidio_anual->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_beneficios" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_beneficioslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->data->Visible) { // data ?>
        <th data-name="data" class="<?= $Page->data->headerCellClass() ?>"><div id="elh_beneficios_data" class="beneficios_data"><?= $Page->renderFieldHeader($Page->data) ?></div></th>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <th data-name="vt_dia" class="<?= $Page->vt_dia->headerCellClass() ?>"><div id="elh_beneficios_vt_dia" class="beneficios_vt_dia"><?= $Page->renderFieldHeader($Page->vt_dia) ?></div></th>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <th data-name="vr_dia" class="<?= $Page->vr_dia->headerCellClass() ?>"><div id="elh_beneficios_vr_dia" class="beneficios_vr_dia"><?= $Page->renderFieldHeader($Page->vr_dia) ?></div></th>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
        <th data-name="va_mes" class="<?= $Page->va_mes->headerCellClass() ?>"><div id="elh_beneficios_va_mes" class="beneficios_va_mes"><?= $Page->renderFieldHeader($Page->va_mes) ?></div></th>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
        <th data-name="benef_social" class="<?= $Page->benef_social->headerCellClass() ?>"><div id="elh_beneficios_benef_social" class="beneficios_benef_social"><?= $Page->renderFieldHeader($Page->benef_social) ?></div></th>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
        <th data-name="plr" class="<?= $Page->plr->headerCellClass() ?>"><div id="elh_beneficios_plr" class="beneficios_plr"><?= $Page->renderFieldHeader($Page->plr) ?></div></th>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <th data-name="assis_medica" class="<?= $Page->assis_medica->headerCellClass() ?>"><div id="elh_beneficios_assis_medica" class="beneficios_assis_medica"><?= $Page->renderFieldHeader($Page->assis_medica) ?></div></th>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <th data-name="assis_odonto" class="<?= $Page->assis_odonto->headerCellClass() ?>"><div id="elh_beneficios_assis_odonto" class="beneficios_assis_odonto"><?= $Page->renderFieldHeader($Page->assis_odonto) ?></div></th>
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
    <?php if ($Page->data->Visible) { // data ?>
        <td data-name="data"<?= $Page->data->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_data" class="el_beneficios_data">
<input type="<?= $Page->data->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_data" id="x<?= $Page->RowIndex ?>_data" data-table="beneficios" data-field="x_data" value="<?= $Page->data->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->data->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->data->formatPattern()) ?>"<?= $Page->data->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->data->getErrorMessage() ?></div>
<?php if (!$Page->data->ReadOnly && !$Page->data->Disabled && !isset($Page->data->EditAttrs["readonly"]) && !isset($Page->data->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["<?= $Page->FormName ?>", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("<?= $Page->FormName ?>", "x<?= $Page->RowIndex ?>_data", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="beneficios" data-field="x_data" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_data" id="o<?= $Page->RowIndex ?>_data" value="<?= HtmlEncode($Page->data->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_data" class="el_beneficios_data">
<span<?= $Page->data->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->data->getDisplayValue($Page->data->EditValue))) ?>"></span>
<input type="hidden" data-table="beneficios" data-field="x_data" data-hidden="1" name="x<?= $Page->RowIndex ?>_data" id="x<?= $Page->RowIndex ?>_data" value="<?= HtmlEncode($Page->data->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_data" class="el_beneficios_data">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <td data-name="vt_dia"<?= $Page->vt_dia->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_vt_dia" class="el_beneficios_vt_dia">
<input type="<?= $Page->vt_dia->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_vt_dia" id="x<?= $Page->RowIndex ?>_vt_dia" data-table="beneficios" data-field="x_vt_dia" value="<?= $Page->vt_dia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->vt_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vt_dia->formatPattern()) ?>"<?= $Page->vt_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vt_dia->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_vt_dia" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_vt_dia" id="o<?= $Page->RowIndex ?>_vt_dia" value="<?= HtmlEncode($Page->vt_dia->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_vt_dia" class="el_beneficios_vt_dia">
<input type="<?= $Page->vt_dia->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_vt_dia" id="x<?= $Page->RowIndex ?>_vt_dia" data-table="beneficios" data-field="x_vt_dia" value="<?= $Page->vt_dia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->vt_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vt_dia->formatPattern()) ?>"<?= $Page->vt_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vt_dia->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_vt_dia" class="el_beneficios_vt_dia">
<span<?= $Page->vt_dia->viewAttributes() ?>>
<?= $Page->vt_dia->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <td data-name="vr_dia"<?= $Page->vr_dia->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_vr_dia" class="el_beneficios_vr_dia">
<input type="<?= $Page->vr_dia->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_vr_dia" id="x<?= $Page->RowIndex ?>_vr_dia" data-table="beneficios" data-field="x_vr_dia" value="<?= $Page->vr_dia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->vr_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_dia->formatPattern()) ?>"<?= $Page->vr_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vr_dia->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_vr_dia" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_vr_dia" id="o<?= $Page->RowIndex ?>_vr_dia" value="<?= HtmlEncode($Page->vr_dia->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_vr_dia" class="el_beneficios_vr_dia">
<input type="<?= $Page->vr_dia->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_vr_dia" id="x<?= $Page->RowIndex ?>_vr_dia" data-table="beneficios" data-field="x_vr_dia" value="<?= $Page->vr_dia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->vr_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_dia->formatPattern()) ?>"<?= $Page->vr_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->vr_dia->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_vr_dia" class="el_beneficios_vr_dia">
<span<?= $Page->vr_dia->viewAttributes() ?>>
<?= $Page->vr_dia->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->va_mes->Visible) { // va_mes ?>
        <td data-name="va_mes"<?= $Page->va_mes->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_va_mes" class="el_beneficios_va_mes">
<input type="<?= $Page->va_mes->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_va_mes" id="x<?= $Page->RowIndex ?>_va_mes" data-table="beneficios" data-field="x_va_mes" value="<?= $Page->va_mes->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->va_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->va_mes->formatPattern()) ?>"<?= $Page->va_mes->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->va_mes->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_va_mes" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_va_mes" id="o<?= $Page->RowIndex ?>_va_mes" value="<?= HtmlEncode($Page->va_mes->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_va_mes" class="el_beneficios_va_mes">
<input type="<?= $Page->va_mes->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_va_mes" id="x<?= $Page->RowIndex ?>_va_mes" data-table="beneficios" data-field="x_va_mes" value="<?= $Page->va_mes->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->va_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->va_mes->formatPattern()) ?>"<?= $Page->va_mes->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->va_mes->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_va_mes" class="el_beneficios_va_mes">
<span<?= $Page->va_mes->viewAttributes() ?>>
<?= $Page->va_mes->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->benef_social->Visible) { // benef_social ?>
        <td data-name="benef_social"<?= $Page->benef_social->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_benef_social" class="el_beneficios_benef_social">
<input type="<?= $Page->benef_social->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_benef_social" id="x<?= $Page->RowIndex ?>_benef_social" data-table="beneficios" data-field="x_benef_social" value="<?= $Page->benef_social->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->benef_social->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->benef_social->formatPattern()) ?>"<?= $Page->benef_social->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->benef_social->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_benef_social" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_benef_social" id="o<?= $Page->RowIndex ?>_benef_social" value="<?= HtmlEncode($Page->benef_social->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_benef_social" class="el_beneficios_benef_social">
<input type="<?= $Page->benef_social->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_benef_social" id="x<?= $Page->RowIndex ?>_benef_social" data-table="beneficios" data-field="x_benef_social" value="<?= $Page->benef_social->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->benef_social->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->benef_social->formatPattern()) ?>"<?= $Page->benef_social->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->benef_social->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_benef_social" class="el_beneficios_benef_social">
<span<?= $Page->benef_social->viewAttributes() ?>>
<?= $Page->benef_social->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->plr->Visible) { // plr ?>
        <td data-name="plr"<?= $Page->plr->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_plr" class="el_beneficios_plr">
<input type="<?= $Page->plr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_plr" id="x<?= $Page->RowIndex ?>_plr" data-table="beneficios" data-field="x_plr" value="<?= $Page->plr->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->plr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->plr->formatPattern()) ?>"<?= $Page->plr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->plr->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_plr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_plr" id="o<?= $Page->RowIndex ?>_plr" value="<?= HtmlEncode($Page->plr->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_plr" class="el_beneficios_plr">
<input type="<?= $Page->plr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_plr" id="x<?= $Page->RowIndex ?>_plr" data-table="beneficios" data-field="x_plr" value="<?= $Page->plr->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->plr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->plr->formatPattern()) ?>"<?= $Page->plr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->plr->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_plr" class="el_beneficios_plr">
<span<?= $Page->plr->viewAttributes() ?>>
<?= $Page->plr->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <td data-name="assis_medica"<?= $Page->assis_medica->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_assis_medica" class="el_beneficios_assis_medica">
<input type="<?= $Page->assis_medica->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_assis_medica" id="x<?= $Page->RowIndex ?>_assis_medica" data-table="beneficios" data-field="x_assis_medica" value="<?= $Page->assis_medica->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->assis_medica->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_medica->formatPattern()) ?>"<?= $Page->assis_medica->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assis_medica->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_assis_medica" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_assis_medica" id="o<?= $Page->RowIndex ?>_assis_medica" value="<?= HtmlEncode($Page->assis_medica->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_assis_medica" class="el_beneficios_assis_medica">
<input type="<?= $Page->assis_medica->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_assis_medica" id="x<?= $Page->RowIndex ?>_assis_medica" data-table="beneficios" data-field="x_assis_medica" value="<?= $Page->assis_medica->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->assis_medica->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_medica->formatPattern()) ?>"<?= $Page->assis_medica->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assis_medica->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_assis_medica" class="el_beneficios_assis_medica">
<span<?= $Page->assis_medica->viewAttributes() ?>>
<?= $Page->assis_medica->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <td data-name="assis_odonto"<?= $Page->assis_odonto->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_assis_odonto" class="el_beneficios_assis_odonto">
<input type="<?= $Page->assis_odonto->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_assis_odonto" id="x<?= $Page->RowIndex ?>_assis_odonto" data-table="beneficios" data-field="x_assis_odonto" value="<?= $Page->assis_odonto->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->assis_odonto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_odonto->formatPattern()) ?>"<?= $Page->assis_odonto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assis_odonto->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_assis_odonto" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_assis_odonto" id="o<?= $Page->RowIndex ?>_assis_odonto" value="<?= HtmlEncode($Page->assis_odonto->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_assis_odonto" class="el_beneficios_assis_odonto">
<input type="<?= $Page->assis_odonto->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_assis_odonto" id="x<?= $Page->RowIndex ?>_assis_odonto" data-table="beneficios" data-field="x_assis_odonto" value="<?= $Page->assis_odonto->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->assis_odonto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_odonto->formatPattern()) ?>"<?= $Page->assis_odonto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->assis_odonto->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_beneficios_assis_odonto" class="el_beneficios_assis_odonto">
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
    ew.addEventHandlers("beneficios");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
