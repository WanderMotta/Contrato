<?php

namespace PHPMaker2024\contratos;

// Set up and run Grid object
$Grid = Container("UniformeCargoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var funiforme_cargogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { uniforme_cargo: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("funiforme_cargogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["uniforme_iduniforme", [fields.uniforme_iduniforme.visible && fields.uniforme_iduniforme.required ? ew.Validators.required(fields.uniforme_iduniforme.caption) : null], fields.uniforme_iduniforme.isInvalid],
            ["tipo_uniforme_idtipo_uniforme", [fields.tipo_uniforme_idtipo_uniforme.visible && fields.tipo_uniforme_idtipo_uniforme.required ? ew.Validators.required(fields.tipo_uniforme_idtipo_uniforme.caption) : null], fields.tipo_uniforme_idtipo_uniforme.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["uniforme_iduniforme",false],["tipo_uniforme_idtipo_uniforme",false]];
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
            "uniforme_iduniforme": <?= $Grid->uniforme_iduniforme->toClientList($Grid) ?>,
            "tipo_uniforme_idtipo_uniforme": <?= $Grid->tipo_uniforme_idtipo_uniforme->toClientList($Grid) ?>,
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
<div id="funiforme_cargogrid" class="ew-form ew-list-form">
<div id="gmp_uniforme_cargo" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_uniforme_cargogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->uniforme_iduniforme->Visible) { // uniforme_iduniforme ?>
        <th data-name="uniforme_iduniforme" class="<?= $Grid->uniforme_iduniforme->headerCellClass() ?>"><div id="elh_uniforme_cargo_uniforme_iduniforme" class="uniforme_cargo_uniforme_iduniforme"><?= $Grid->renderFieldHeader($Grid->uniforme_iduniforme) ?></div></th>
<?php } ?>
<?php if ($Grid->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <th data-name="tipo_uniforme_idtipo_uniforme" class="<?= $Grid->tipo_uniforme_idtipo_uniforme->headerCellClass() ?>"><div id="elh_uniforme_cargo_tipo_uniforme_idtipo_uniforme" class="uniforme_cargo_tipo_uniforme_idtipo_uniforme"><?= $Grid->renderFieldHeader($Grid->tipo_uniforme_idtipo_uniforme) ?></div></th>
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
    <?php if ($Grid->uniforme_iduniforme->Visible) { // uniforme_iduniforme ?>
        <td data-name="uniforme_iduniforme"<?= $Grid->uniforme_iduniforme->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_uniforme_cargo_uniforme_iduniforme" class="el_uniforme_cargo_uniforme_iduniforme">
    <select
        id="x<?= $Grid->RowIndex ?>_uniforme_iduniforme"
        name="x<?= $Grid->RowIndex ?>_uniforme_iduniforme"
        class="form-control ew-select<?= $Grid->uniforme_iduniforme->isInvalidClass() ?>"
        data-select2-id="funiforme_cargogrid_x<?= $Grid->RowIndex ?>_uniforme_iduniforme"
        data-table="uniforme_cargo"
        data-field="x_uniforme_iduniforme"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->uniforme_iduniforme->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->uniforme_iduniforme->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->uniforme_iduniforme->getPlaceHolder()) ?>"
        <?= $Grid->uniforme_iduniforme->editAttributes() ?>>
        <?= $Grid->uniforme_iduniforme->selectOptionListHtml("x{$Grid->RowIndex}_uniforme_iduniforme") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->uniforme_iduniforme->getErrorMessage() ?></div>
<?= $Grid->uniforme_iduniforme->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_uniforme_iduniforme") ?>
<script>
loadjs.ready("funiforme_cargogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_uniforme_iduniforme", selectId: "funiforme_cargogrid_x<?= $Grid->RowIndex ?>_uniforme_iduniforme" };
    if (funiforme_cargogrid.lists.uniforme_iduniforme?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_uniforme_iduniforme", form: "funiforme_cargogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_uniforme_iduniforme", form: "funiforme_cargogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.uniforme_cargo.fields.uniforme_iduniforme.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="uniforme_cargo" data-field="x_uniforme_iduniforme" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_uniforme_iduniforme" id="o<?= $Grid->RowIndex ?>_uniforme_iduniforme" value="<?= HtmlEncode($Grid->uniforme_iduniforme->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_uniforme_cargo_uniforme_iduniforme" class="el_uniforme_cargo_uniforme_iduniforme">
    <select
        id="x<?= $Grid->RowIndex ?>_uniforme_iduniforme"
        name="x<?= $Grid->RowIndex ?>_uniforme_iduniforme"
        class="form-control ew-select<?= $Grid->uniforme_iduniforme->isInvalidClass() ?>"
        data-select2-id="funiforme_cargogrid_x<?= $Grid->RowIndex ?>_uniforme_iduniforme"
        data-table="uniforme_cargo"
        data-field="x_uniforme_iduniforme"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->uniforme_iduniforme->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->uniforme_iduniforme->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->uniforme_iduniforme->getPlaceHolder()) ?>"
        <?= $Grid->uniforme_iduniforme->editAttributes() ?>>
        <?= $Grid->uniforme_iduniforme->selectOptionListHtml("x{$Grid->RowIndex}_uniforme_iduniforme") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->uniforme_iduniforme->getErrorMessage() ?></div>
<?= $Grid->uniforme_iduniforme->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_uniforme_iduniforme") ?>
<script>
loadjs.ready("funiforme_cargogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_uniforme_iduniforme", selectId: "funiforme_cargogrid_x<?= $Grid->RowIndex ?>_uniforme_iduniforme" };
    if (funiforme_cargogrid.lists.uniforme_iduniforme?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_uniforme_iduniforme", form: "funiforme_cargogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_uniforme_iduniforme", form: "funiforme_cargogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.uniforme_cargo.fields.uniforme_iduniforme.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_uniforme_cargo_uniforme_iduniforme" class="el_uniforme_cargo_uniforme_iduniforme">
<span<?= $Grid->uniforme_iduniforme->viewAttributes() ?>>
<?= $Grid->uniforme_iduniforme->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="uniforme_cargo" data-field="x_uniforme_iduniforme" data-hidden="1" name="funiforme_cargogrid$x<?= $Grid->RowIndex ?>_uniforme_iduniforme" id="funiforme_cargogrid$x<?= $Grid->RowIndex ?>_uniforme_iduniforme" value="<?= HtmlEncode($Grid->uniforme_iduniforme->FormValue) ?>">
<input type="hidden" data-table="uniforme_cargo" data-field="x_uniforme_iduniforme" data-hidden="1" data-old name="funiforme_cargogrid$o<?= $Grid->RowIndex ?>_uniforme_iduniforme" id="funiforme_cargogrid$o<?= $Grid->RowIndex ?>_uniforme_iduniforme" value="<?= HtmlEncode($Grid->uniforme_iduniforme->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <td data-name="tipo_uniforme_idtipo_uniforme"<?= $Grid->tipo_uniforme_idtipo_uniforme->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->tipo_uniforme_idtipo_uniforme->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_uniforme_cargo_tipo_uniforme_idtipo_uniforme" class="el_uniforme_cargo_tipo_uniforme_idtipo_uniforme">
<span<?= $Grid->tipo_uniforme_idtipo_uniforme->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->tipo_uniforme_idtipo_uniforme->getDisplayValue($Grid->tipo_uniforme_idtipo_uniforme->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" name="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" value="<?= HtmlEncode($Grid->tipo_uniforme_idtipo_uniforme->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_uniforme_cargo_tipo_uniforme_idtipo_uniforme" class="el_uniforme_cargo_tipo_uniforme_idtipo_uniforme">
<template id="tp_x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="uniforme_cargo" data-field="x_tipo_uniforme_idtipo_uniforme" name="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" id="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme"<?= $Grid->tipo_uniforme_idtipo_uniforme->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme"
    name="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme"
    value="<?= HtmlEncode($Grid->tipo_uniforme_idtipo_uniforme->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme"
    data-target="dsl_x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme"
    data-repeatcolumn="10"
    class="form-control<?= $Grid->tipo_uniforme_idtipo_uniforme->isInvalidClass() ?>"
    data-table="uniforme_cargo"
    data-field="x_tipo_uniforme_idtipo_uniforme"
    data-value-separator="<?= $Grid->tipo_uniforme_idtipo_uniforme->displayValueSeparatorAttribute() ?>"
    <?= $Grid->tipo_uniforme_idtipo_uniforme->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->tipo_uniforme_idtipo_uniforme->getErrorMessage() ?></div>
<?= $Grid->tipo_uniforme_idtipo_uniforme->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo_uniforme_idtipo_uniforme") ?>
</span>
<?php } ?>
<input type="hidden" data-table="uniforme_cargo" data-field="x_tipo_uniforme_idtipo_uniforme" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" id="o<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" value="<?= HtmlEncode($Grid->tipo_uniforme_idtipo_uniforme->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->tipo_uniforme_idtipo_uniforme->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_uniforme_cargo_tipo_uniforme_idtipo_uniforme" class="el_uniforme_cargo_tipo_uniforme_idtipo_uniforme">
<span<?= $Grid->tipo_uniforme_idtipo_uniforme->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->tipo_uniforme_idtipo_uniforme->getDisplayValue($Grid->tipo_uniforme_idtipo_uniforme->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" name="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" value="<?= HtmlEncode($Grid->tipo_uniforme_idtipo_uniforme->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_uniforme_cargo_tipo_uniforme_idtipo_uniforme" class="el_uniforme_cargo_tipo_uniforme_idtipo_uniforme">
<template id="tp_x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="uniforme_cargo" data-field="x_tipo_uniforme_idtipo_uniforme" name="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" id="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme"<?= $Grid->tipo_uniforme_idtipo_uniforme->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme"
    name="x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme"
    value="<?= HtmlEncode($Grid->tipo_uniforme_idtipo_uniforme->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme"
    data-target="dsl_x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme"
    data-repeatcolumn="10"
    class="form-control<?= $Grid->tipo_uniforme_idtipo_uniforme->isInvalidClass() ?>"
    data-table="uniforme_cargo"
    data-field="x_tipo_uniforme_idtipo_uniforme"
    data-value-separator="<?= $Grid->tipo_uniforme_idtipo_uniforme->displayValueSeparatorAttribute() ?>"
    <?= $Grid->tipo_uniforme_idtipo_uniforme->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->tipo_uniforme_idtipo_uniforme->getErrorMessage() ?></div>
<?= $Grid->tipo_uniforme_idtipo_uniforme->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo_uniforme_idtipo_uniforme") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_uniforme_cargo_tipo_uniforme_idtipo_uniforme" class="el_uniforme_cargo_tipo_uniforme_idtipo_uniforme">
<span<?= $Grid->tipo_uniforme_idtipo_uniforme->viewAttributes() ?>>
<?= $Grid->tipo_uniforme_idtipo_uniforme->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="uniforme_cargo" data-field="x_tipo_uniforme_idtipo_uniforme" data-hidden="1" name="funiforme_cargogrid$x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" id="funiforme_cargogrid$x<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" value="<?= HtmlEncode($Grid->tipo_uniforme_idtipo_uniforme->FormValue) ?>">
<input type="hidden" data-table="uniforme_cargo" data-field="x_tipo_uniforme_idtipo_uniforme" data-hidden="1" data-old name="funiforme_cargogrid$o<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" id="funiforme_cargogrid$o<?= $Grid->RowIndex ?>_tipo_uniforme_idtipo_uniforme" value="<?= HtmlEncode($Grid->tipo_uniforme_idtipo_uniforme->OldValue) ?>">
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
loadjs.ready(["funiforme_cargogrid","load"], () => funiforme_cargogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<?php
// Render aggregate row
$Grid->RowType = RowType::AGGREGATE;
$Grid->resetAttributes();
$Grid->renderRow();
?>
<?php if ($Grid->TotalRecords > 0 && $Grid->CurrentMode == "view") { ?>
<tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options
$Grid->renderListOptions();

// Render list options (footer, left)
$Grid->ListOptions->render("footer", "left");
?>
    <?php if ($Grid->uniforme_iduniforme->Visible) { // uniforme_iduniforme ?>
        <td data-name="uniforme_iduniforme" class="<?= $Grid->uniforme_iduniforme->footerCellClass() ?>"><span id="elf_uniforme_cargo_uniforme_iduniforme" class="uniforme_cargo_uniforme_iduniforme">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Grid->uniforme_iduniforme->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <td data-name="tipo_uniforme_idtipo_uniforme" class="<?= $Grid->tipo_uniforme_idtipo_uniforme->footerCellClass() ?>"><span id="elf_uniforme_cargo_tipo_uniforme_idtipo_uniforme" class="uniforme_cargo_tipo_uniforme_idtipo_uniforme">
        </span></td>
    <?php } ?>
<?php
// Render list options (footer, right)
$Grid->ListOptions->render("footer", "right");
?>
    </tr>
</tfoot>
<?php } ?>
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
<input type="hidden" name="detailpage" value="funiforme_cargogrid">
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
    ew.addEventHandlers("uniforme_cargo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
