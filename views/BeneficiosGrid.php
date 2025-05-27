<?php

namespace PHPMaker2024\contratos;

// Set up and run Grid object
$Grid = Container("BeneficiosGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fbeneficiosgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { beneficios: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fbeneficiosgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

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

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["data",false],["vt_dia",false],["vr_dia",false],["va_mes",false],["benef_social",false],["plr",false],["assis_medica",false],["assis_odonto",false]];
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
        })
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<main class="list">
<div id="ew-header-options">
<?php $Grid->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Grid->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Grid->TableGridClass ?>">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="fbeneficiosgrid" class="ew-form ew-list-form">
<div id="gmp_beneficios" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_beneficiosgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = RowType::HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->data->Visible) { // data ?>
        <th data-name="data" class="<?= $Grid->data->headerCellClass() ?>"><div id="elh_beneficios_data" class="beneficios_data"><?= $Grid->renderFieldHeader($Grid->data) ?></div></th>
<?php } ?>
<?php if ($Grid->vt_dia->Visible) { // vt_dia ?>
        <th data-name="vt_dia" class="<?= $Grid->vt_dia->headerCellClass() ?>"><div id="elh_beneficios_vt_dia" class="beneficios_vt_dia"><?= $Grid->renderFieldHeader($Grid->vt_dia) ?></div></th>
<?php } ?>
<?php if ($Grid->vr_dia->Visible) { // vr_dia ?>
        <th data-name="vr_dia" class="<?= $Grid->vr_dia->headerCellClass() ?>"><div id="elh_beneficios_vr_dia" class="beneficios_vr_dia"><?= $Grid->renderFieldHeader($Grid->vr_dia) ?></div></th>
<?php } ?>
<?php if ($Grid->va_mes->Visible) { // va_mes ?>
        <th data-name="va_mes" class="<?= $Grid->va_mes->headerCellClass() ?>"><div id="elh_beneficios_va_mes" class="beneficios_va_mes"><?= $Grid->renderFieldHeader($Grid->va_mes) ?></div></th>
<?php } ?>
<?php if ($Grid->benef_social->Visible) { // benef_social ?>
        <th data-name="benef_social" class="<?= $Grid->benef_social->headerCellClass() ?>"><div id="elh_beneficios_benef_social" class="beneficios_benef_social"><?= $Grid->renderFieldHeader($Grid->benef_social) ?></div></th>
<?php } ?>
<?php if ($Grid->plr->Visible) { // plr ?>
        <th data-name="plr" class="<?= $Grid->plr->headerCellClass() ?>"><div id="elh_beneficios_plr" class="beneficios_plr"><?= $Grid->renderFieldHeader($Grid->plr) ?></div></th>
<?php } ?>
<?php if ($Grid->assis_medica->Visible) { // assis_medica ?>
        <th data-name="assis_medica" class="<?= $Grid->assis_medica->headerCellClass() ?>"><div id="elh_beneficios_assis_medica" class="beneficios_assis_medica"><?= $Grid->renderFieldHeader($Grid->assis_medica) ?></div></th>
<?php } ?>
<?php if ($Grid->assis_odonto->Visible) { // assis_odonto ?>
        <th data-name="assis_odonto" class="<?= $Grid->assis_odonto->headerCellClass() ?>"><div id="elh_beneficios_assis_odonto" class="beneficios_assis_odonto"><?= $Grid->renderFieldHeader($Grid->assis_odonto) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Grid->getPageNumber() ?>">
<?php
$Grid->setupGrid();
$isInlineAddOrCopy = ($Grid->isCopy() || $Grid->isAdd());
while ($Grid->RecordCount < $Grid->StopRecord || $Grid->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Grid->RowIndex == 0) {
    if (
        $Grid->CurrentRow !== false &&
        $Grid->RowIndex !== '$rowindex$' &&
        (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy") &&
        !($isInlineAddOrCopy && $Grid->RowIndex == 0)
    ) {
        $Grid->fetch();
    }
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Grid->RowAction != "delete" &&
            $Grid->RowAction != "insertdelete" &&
            !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow()) &&
            $Grid->RowAction != "hide"
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->data->Visible) { // data ?>
        <td data-name="data"<?= $Grid->data->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_data" class="el_beneficios_data">
<input type="<?= $Grid->data->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_data" id="x<?= $Grid->RowIndex ?>_data" data-table="beneficios" data-field="x_data" value="<?= $Grid->data->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->data->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->data->formatPattern()) ?>"<?= $Grid->data->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->data->getErrorMessage() ?></div>
<?php if (!$Grid->data->ReadOnly && !$Grid->data->Disabled && !isset($Grid->data->EditAttrs["readonly"]) && !isset($Grid->data->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbeneficiosgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbeneficiosgrid", "x<?= $Grid->RowIndex ?>_data", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="beneficios" data-field="x_data" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_data" id="o<?= $Grid->RowIndex ?>_data" value="<?= HtmlEncode($Grid->data->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_data" class="el_beneficios_data">
<span<?= $Grid->data->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->data->getDisplayValue($Grid->data->EditValue))) ?>"></span>
<input type="hidden" data-table="beneficios" data-field="x_data" data-hidden="1" name="x<?= $Grid->RowIndex ?>_data" id="x<?= $Grid->RowIndex ?>_data" value="<?= HtmlEncode($Grid->data->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_data" class="el_beneficios_data">
<span<?= $Grid->data->viewAttributes() ?>>
<?= $Grid->data->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="beneficios" data-field="x_data" data-hidden="1" name="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_data" id="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_data" value="<?= HtmlEncode($Grid->data->FormValue) ?>">
<input type="hidden" data-table="beneficios" data-field="x_data" data-hidden="1" data-old name="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_data" id="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_data" value="<?= HtmlEncode($Grid->data->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->vt_dia->Visible) { // vt_dia ?>
        <td data-name="vt_dia"<?= $Grid->vt_dia->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_vt_dia" class="el_beneficios_vt_dia">
<input type="<?= $Grid->vt_dia->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_vt_dia" id="x<?= $Grid->RowIndex ?>_vt_dia" data-table="beneficios" data-field="x_vt_dia" value="<?= $Grid->vt_dia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->vt_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->vt_dia->formatPattern()) ?>"<?= $Grid->vt_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->vt_dia->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_vt_dia" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_vt_dia" id="o<?= $Grid->RowIndex ?>_vt_dia" value="<?= HtmlEncode($Grid->vt_dia->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_vt_dia" class="el_beneficios_vt_dia">
<input type="<?= $Grid->vt_dia->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_vt_dia" id="x<?= $Grid->RowIndex ?>_vt_dia" data-table="beneficios" data-field="x_vt_dia" value="<?= $Grid->vt_dia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->vt_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->vt_dia->formatPattern()) ?>"<?= $Grid->vt_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->vt_dia->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_vt_dia" class="el_beneficios_vt_dia">
<span<?= $Grid->vt_dia->viewAttributes() ?>>
<?= $Grid->vt_dia->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="beneficios" data-field="x_vt_dia" data-hidden="1" name="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_vt_dia" id="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_vt_dia" value="<?= HtmlEncode($Grid->vt_dia->FormValue) ?>">
<input type="hidden" data-table="beneficios" data-field="x_vt_dia" data-hidden="1" data-old name="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_vt_dia" id="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_vt_dia" value="<?= HtmlEncode($Grid->vt_dia->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->vr_dia->Visible) { // vr_dia ?>
        <td data-name="vr_dia"<?= $Grid->vr_dia->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_vr_dia" class="el_beneficios_vr_dia">
<input type="<?= $Grid->vr_dia->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_vr_dia" id="x<?= $Grid->RowIndex ?>_vr_dia" data-table="beneficios" data-field="x_vr_dia" value="<?= $Grid->vr_dia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->vr_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->vr_dia->formatPattern()) ?>"<?= $Grid->vr_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->vr_dia->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_vr_dia" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_vr_dia" id="o<?= $Grid->RowIndex ?>_vr_dia" value="<?= HtmlEncode($Grid->vr_dia->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_vr_dia" class="el_beneficios_vr_dia">
<input type="<?= $Grid->vr_dia->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_vr_dia" id="x<?= $Grid->RowIndex ?>_vr_dia" data-table="beneficios" data-field="x_vr_dia" value="<?= $Grid->vr_dia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->vr_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->vr_dia->formatPattern()) ?>"<?= $Grid->vr_dia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->vr_dia->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_vr_dia" class="el_beneficios_vr_dia">
<span<?= $Grid->vr_dia->viewAttributes() ?>>
<?= $Grid->vr_dia->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="beneficios" data-field="x_vr_dia" data-hidden="1" name="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_vr_dia" id="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_vr_dia" value="<?= HtmlEncode($Grid->vr_dia->FormValue) ?>">
<input type="hidden" data-table="beneficios" data-field="x_vr_dia" data-hidden="1" data-old name="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_vr_dia" id="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_vr_dia" value="<?= HtmlEncode($Grid->vr_dia->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->va_mes->Visible) { // va_mes ?>
        <td data-name="va_mes"<?= $Grid->va_mes->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_va_mes" class="el_beneficios_va_mes">
<input type="<?= $Grid->va_mes->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_va_mes" id="x<?= $Grid->RowIndex ?>_va_mes" data-table="beneficios" data-field="x_va_mes" value="<?= $Grid->va_mes->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->va_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->va_mes->formatPattern()) ?>"<?= $Grid->va_mes->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->va_mes->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_va_mes" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_va_mes" id="o<?= $Grid->RowIndex ?>_va_mes" value="<?= HtmlEncode($Grid->va_mes->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_va_mes" class="el_beneficios_va_mes">
<input type="<?= $Grid->va_mes->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_va_mes" id="x<?= $Grid->RowIndex ?>_va_mes" data-table="beneficios" data-field="x_va_mes" value="<?= $Grid->va_mes->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->va_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->va_mes->formatPattern()) ?>"<?= $Grid->va_mes->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->va_mes->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_va_mes" class="el_beneficios_va_mes">
<span<?= $Grid->va_mes->viewAttributes() ?>>
<?= $Grid->va_mes->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="beneficios" data-field="x_va_mes" data-hidden="1" name="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_va_mes" id="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_va_mes" value="<?= HtmlEncode($Grid->va_mes->FormValue) ?>">
<input type="hidden" data-table="beneficios" data-field="x_va_mes" data-hidden="1" data-old name="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_va_mes" id="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_va_mes" value="<?= HtmlEncode($Grid->va_mes->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->benef_social->Visible) { // benef_social ?>
        <td data-name="benef_social"<?= $Grid->benef_social->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_benef_social" class="el_beneficios_benef_social">
<input type="<?= $Grid->benef_social->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_benef_social" id="x<?= $Grid->RowIndex ?>_benef_social" data-table="beneficios" data-field="x_benef_social" value="<?= $Grid->benef_social->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->benef_social->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->benef_social->formatPattern()) ?>"<?= $Grid->benef_social->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->benef_social->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_benef_social" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_benef_social" id="o<?= $Grid->RowIndex ?>_benef_social" value="<?= HtmlEncode($Grid->benef_social->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_benef_social" class="el_beneficios_benef_social">
<input type="<?= $Grid->benef_social->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_benef_social" id="x<?= $Grid->RowIndex ?>_benef_social" data-table="beneficios" data-field="x_benef_social" value="<?= $Grid->benef_social->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->benef_social->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->benef_social->formatPattern()) ?>"<?= $Grid->benef_social->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->benef_social->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_benef_social" class="el_beneficios_benef_social">
<span<?= $Grid->benef_social->viewAttributes() ?>>
<?= $Grid->benef_social->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="beneficios" data-field="x_benef_social" data-hidden="1" name="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_benef_social" id="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_benef_social" value="<?= HtmlEncode($Grid->benef_social->FormValue) ?>">
<input type="hidden" data-table="beneficios" data-field="x_benef_social" data-hidden="1" data-old name="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_benef_social" id="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_benef_social" value="<?= HtmlEncode($Grid->benef_social->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->plr->Visible) { // plr ?>
        <td data-name="plr"<?= $Grid->plr->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_plr" class="el_beneficios_plr">
<input type="<?= $Grid->plr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_plr" id="x<?= $Grid->RowIndex ?>_plr" data-table="beneficios" data-field="x_plr" value="<?= $Grid->plr->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->plr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->plr->formatPattern()) ?>"<?= $Grid->plr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->plr->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_plr" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_plr" id="o<?= $Grid->RowIndex ?>_plr" value="<?= HtmlEncode($Grid->plr->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_plr" class="el_beneficios_plr">
<input type="<?= $Grid->plr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_plr" id="x<?= $Grid->RowIndex ?>_plr" data-table="beneficios" data-field="x_plr" value="<?= $Grid->plr->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->plr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->plr->formatPattern()) ?>"<?= $Grid->plr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->plr->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_plr" class="el_beneficios_plr">
<span<?= $Grid->plr->viewAttributes() ?>>
<?= $Grid->plr->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="beneficios" data-field="x_plr" data-hidden="1" name="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_plr" id="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_plr" value="<?= HtmlEncode($Grid->plr->FormValue) ?>">
<input type="hidden" data-table="beneficios" data-field="x_plr" data-hidden="1" data-old name="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_plr" id="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_plr" value="<?= HtmlEncode($Grid->plr->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->assis_medica->Visible) { // assis_medica ?>
        <td data-name="assis_medica"<?= $Grid->assis_medica->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_assis_medica" class="el_beneficios_assis_medica">
<input type="<?= $Grid->assis_medica->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_assis_medica" id="x<?= $Grid->RowIndex ?>_assis_medica" data-table="beneficios" data-field="x_assis_medica" value="<?= $Grid->assis_medica->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->assis_medica->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->assis_medica->formatPattern()) ?>"<?= $Grid->assis_medica->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->assis_medica->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_assis_medica" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_assis_medica" id="o<?= $Grid->RowIndex ?>_assis_medica" value="<?= HtmlEncode($Grid->assis_medica->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_assis_medica" class="el_beneficios_assis_medica">
<input type="<?= $Grid->assis_medica->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_assis_medica" id="x<?= $Grid->RowIndex ?>_assis_medica" data-table="beneficios" data-field="x_assis_medica" value="<?= $Grid->assis_medica->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->assis_medica->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->assis_medica->formatPattern()) ?>"<?= $Grid->assis_medica->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->assis_medica->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_assis_medica" class="el_beneficios_assis_medica">
<span<?= $Grid->assis_medica->viewAttributes() ?>>
<?= $Grid->assis_medica->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="beneficios" data-field="x_assis_medica" data-hidden="1" name="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_assis_medica" id="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_assis_medica" value="<?= HtmlEncode($Grid->assis_medica->FormValue) ?>">
<input type="hidden" data-table="beneficios" data-field="x_assis_medica" data-hidden="1" data-old name="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_assis_medica" id="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_assis_medica" value="<?= HtmlEncode($Grid->assis_medica->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->assis_odonto->Visible) { // assis_odonto ?>
        <td data-name="assis_odonto"<?= $Grid->assis_odonto->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_assis_odonto" class="el_beneficios_assis_odonto">
<input type="<?= $Grid->assis_odonto->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_assis_odonto" id="x<?= $Grid->RowIndex ?>_assis_odonto" data-table="beneficios" data-field="x_assis_odonto" value="<?= $Grid->assis_odonto->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->assis_odonto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->assis_odonto->formatPattern()) ?>"<?= $Grid->assis_odonto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->assis_odonto->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="beneficios" data-field="x_assis_odonto" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_assis_odonto" id="o<?= $Grid->RowIndex ?>_assis_odonto" value="<?= HtmlEncode($Grid->assis_odonto->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_assis_odonto" class="el_beneficios_assis_odonto">
<input type="<?= $Grid->assis_odonto->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_assis_odonto" id="x<?= $Grid->RowIndex ?>_assis_odonto" data-table="beneficios" data-field="x_assis_odonto" value="<?= $Grid->assis_odonto->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->assis_odonto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->assis_odonto->formatPattern()) ?>"<?= $Grid->assis_odonto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->assis_odonto->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_beneficios_assis_odonto" class="el_beneficios_assis_odonto">
<span<?= $Grid->assis_odonto->viewAttributes() ?>>
<?= $Grid->assis_odonto->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="beneficios" data-field="x_assis_odonto" data-hidden="1" name="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_assis_odonto" id="fbeneficiosgrid$x<?= $Grid->RowIndex ?>_assis_odonto" value="<?= HtmlEncode($Grid->assis_odonto->FormValue) ?>">
<input type="hidden" data-table="beneficios" data-field="x_assis_odonto" data-hidden="1" data-old name="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_assis_odonto" id="fbeneficiosgrid$o<?= $Grid->RowIndex ?>_assis_odonto" value="<?= HtmlEncode($Grid->assis_odonto->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == RowType::ADD || $Grid->RowType == RowType::EDIT) { ?>
<script data-rowindex="<?= $Grid->RowIndex ?>">
loadjs.ready(["fbeneficiosgrid","load"], () => fbeneficiosgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

    // Reset for template row
    if ($Grid->RowIndex === '$rowindex$') {
        $Grid->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0) {
        $Grid->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fbeneficiosgrid">
</div><!-- /.ew-list-form -->
<?php
// Close result set
$Grid->Recordset?->free();
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Grid->FooterOptions?->render("body") ?>
</div>
</main>
<?php if (!$Grid->isExport()) { ?>
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
