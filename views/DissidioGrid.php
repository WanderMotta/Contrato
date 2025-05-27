<?php

namespace PHPMaker2024\contratos;

// Set up and run Grid object
$Grid = Container("DissidioGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fdissidiogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { dissidio: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdissidiogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["cargo", [fields.cargo.visible && fields.cargo.required ? ew.Validators.required(fields.cargo.caption) : null], fields.cargo.isInvalid],
            ["salario_antes", [fields.salario_antes.visible && fields.salario_antes.required ? ew.Validators.required(fields.salario_antes.caption) : null], fields.salario_antes.isInvalid],
            ["salario_atual", [fields.salario_atual.visible && fields.salario_atual.required ? ew.Validators.required(fields.salario_atual.caption) : null, ew.Validators.float], fields.salario_atual.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["cargo",false],["salario_antes",false],["salario_atual",false]];
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
<div id="fdissidiogrid" class="ew-form ew-list-form">
<div id="gmp_dissidio" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_dissidiogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->cargo->Visible) { // cargo ?>
        <th data-name="cargo" class="<?= $Grid->cargo->headerCellClass() ?>"><div id="elh_dissidio_cargo" class="dissidio_cargo"><?= $Grid->renderFieldHeader($Grid->cargo) ?></div></th>
<?php } ?>
<?php if ($Grid->salario_antes->Visible) { // salario_antes ?>
        <th data-name="salario_antes" class="<?= $Grid->salario_antes->headerCellClass() ?>"><div id="elh_dissidio_salario_antes" class="dissidio_salario_antes"><?= $Grid->renderFieldHeader($Grid->salario_antes) ?></div></th>
<?php } ?>
<?php if ($Grid->salario_atual->Visible) { // salario_atual ?>
        <th data-name="salario_atual" class="<?= $Grid->salario_atual->headerCellClass() ?>"><div id="elh_dissidio_salario_atual" class="dissidio_salario_atual"><?= $Grid->renderFieldHeader($Grid->salario_atual) ?></div></th>
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
    <?php if ($Grid->cargo->Visible) { // cargo ?>
        <td data-name="cargo"<?= $Grid->cargo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_dissidio_cargo" class="el_dissidio_cargo">
<input type="<?= $Grid->cargo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cargo" id="x<?= $Grid->RowIndex ?>_cargo" data-table="dissidio" data-field="x_cargo" value="<?= $Grid->cargo->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->cargo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cargo->formatPattern()) ?>"<?= $Grid->cargo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cargo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="dissidio" data-field="x_cargo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cargo" id="o<?= $Grid->RowIndex ?>_cargo" value="<?= HtmlEncode($Grid->cargo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_dissidio_cargo" class="el_dissidio_cargo">
<span<?= $Grid->cargo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cargo->getDisplayValue($Grid->cargo->EditValue))) ?>"></span>
<input type="hidden" data-table="dissidio" data-field="x_cargo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cargo" id="x<?= $Grid->RowIndex ?>_cargo" value="<?= HtmlEncode($Grid->cargo->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_dissidio_cargo" class="el_dissidio_cargo">
<span<?= $Grid->cargo->viewAttributes() ?>>
<?= $Grid->cargo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="dissidio" data-field="x_cargo" data-hidden="1" name="fdissidiogrid$x<?= $Grid->RowIndex ?>_cargo" id="fdissidiogrid$x<?= $Grid->RowIndex ?>_cargo" value="<?= HtmlEncode($Grid->cargo->FormValue) ?>">
<input type="hidden" data-table="dissidio" data-field="x_cargo" data-hidden="1" data-old name="fdissidiogrid$o<?= $Grid->RowIndex ?>_cargo" id="fdissidiogrid$o<?= $Grid->RowIndex ?>_cargo" value="<?= HtmlEncode($Grid->cargo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->salario_antes->Visible) { // salario_antes ?>
        <td data-name="salario_antes"<?= $Grid->salario_antes->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_dissidio_salario_antes" class="el_dissidio_salario_antes">
<input type="<?= $Grid->salario_antes->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_salario_antes" id="x<?= $Grid->RowIndex ?>_salario_antes" data-table="dissidio" data-field="x_salario_antes" value="<?= $Grid->salario_antes->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->salario_antes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->salario_antes->formatPattern()) ?>"<?= $Grid->salario_antes->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->salario_antes->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="dissidio" data-field="x_salario_antes" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_salario_antes" id="o<?= $Grid->RowIndex ?>_salario_antes" value="<?= HtmlEncode($Grid->salario_antes->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_dissidio_salario_antes" class="el_dissidio_salario_antes">
<span<?= $Grid->salario_antes->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->salario_antes->getDisplayValue($Grid->salario_antes->EditValue))) ?>"></span>
<input type="hidden" data-table="dissidio" data-field="x_salario_antes" data-hidden="1" name="x<?= $Grid->RowIndex ?>_salario_antes" id="x<?= $Grid->RowIndex ?>_salario_antes" value="<?= HtmlEncode($Grid->salario_antes->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_dissidio_salario_antes" class="el_dissidio_salario_antes">
<span<?= $Grid->salario_antes->viewAttributes() ?>>
<?= $Grid->salario_antes->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="dissidio" data-field="x_salario_antes" data-hidden="1" name="fdissidiogrid$x<?= $Grid->RowIndex ?>_salario_antes" id="fdissidiogrid$x<?= $Grid->RowIndex ?>_salario_antes" value="<?= HtmlEncode($Grid->salario_antes->FormValue) ?>">
<input type="hidden" data-table="dissidio" data-field="x_salario_antes" data-hidden="1" data-old name="fdissidiogrid$o<?= $Grid->RowIndex ?>_salario_antes" id="fdissidiogrid$o<?= $Grid->RowIndex ?>_salario_antes" value="<?= HtmlEncode($Grid->salario_antes->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->salario_atual->Visible) { // salario_atual ?>
        <td data-name="salario_atual"<?= $Grid->salario_atual->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_dissidio_salario_atual" class="el_dissidio_salario_atual">
<input type="<?= $Grid->salario_atual->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_salario_atual" id="x<?= $Grid->RowIndex ?>_salario_atual" data-table="dissidio" data-field="x_salario_atual" value="<?= $Grid->salario_atual->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->salario_atual->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->salario_atual->formatPattern()) ?>"<?= $Grid->salario_atual->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->salario_atual->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="dissidio" data-field="x_salario_atual" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_salario_atual" id="o<?= $Grid->RowIndex ?>_salario_atual" value="<?= HtmlEncode($Grid->salario_atual->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_dissidio_salario_atual" class="el_dissidio_salario_atual">
<input type="<?= $Grid->salario_atual->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_salario_atual" id="x<?= $Grid->RowIndex ?>_salario_atual" data-table="dissidio" data-field="x_salario_atual" value="<?= $Grid->salario_atual->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->salario_atual->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->salario_atual->formatPattern()) ?>"<?= $Grid->salario_atual->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->salario_atual->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_dissidio_salario_atual" class="el_dissidio_salario_atual">
<span<?= $Grid->salario_atual->viewAttributes() ?>>
<?= $Grid->salario_atual->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="dissidio" data-field="x_salario_atual" data-hidden="1" name="fdissidiogrid$x<?= $Grid->RowIndex ?>_salario_atual" id="fdissidiogrid$x<?= $Grid->RowIndex ?>_salario_atual" value="<?= HtmlEncode($Grid->salario_atual->FormValue) ?>">
<input type="hidden" data-table="dissidio" data-field="x_salario_atual" data-hidden="1" data-old name="fdissidiogrid$o<?= $Grid->RowIndex ?>_salario_atual" id="fdissidiogrid$o<?= $Grid->RowIndex ?>_salario_atual" value="<?= HtmlEncode($Grid->salario_atual->OldValue) ?>">
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
loadjs.ready(["fdissidiogrid","load"], () => fdissidiogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fdissidiogrid">
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
    ew.addEventHandlers("dissidio");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
