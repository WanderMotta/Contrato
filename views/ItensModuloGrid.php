<?php

namespace PHPMaker2024\contratos;

// Set up and run Grid object
$Grid = Container("ItensModuloGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fitens_modulogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { itens_modulo: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fitens_modulogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["item", [fields.item.visible && fields.item.required ? ew.Validators.required(fields.item.caption) : null], fields.item.isInvalid],
            ["porcentagem_valor", [fields.porcentagem_valor.visible && fields.porcentagem_valor.required ? ew.Validators.required(fields.porcentagem_valor.caption) : null, ew.Validators.float], fields.porcentagem_valor.isInvalid],
            ["incidencia_inss", [fields.incidencia_inss.visible && fields.incidencia_inss.required ? ew.Validators.required(fields.incidencia_inss.caption) : null], fields.incidencia_inss.isInvalid],
            ["ativo", [fields.ativo.visible && fields.ativo.required ? ew.Validators.required(fields.ativo.caption) : null], fields.ativo.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["item",false],["porcentagem_valor",false],["incidencia_inss",false],["ativo",false]];
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
            "incidencia_inss": <?= $Grid->incidencia_inss->toClientList($Grid) ?>,
            "ativo": <?= $Grid->ativo->toClientList($Grid) ?>,
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
<div id="fitens_modulogrid" class="ew-form ew-list-form">
<div id="gmp_itens_modulo" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_itens_modulogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->item->Visible) { // item ?>
        <th data-name="item" class="<?= $Grid->item->headerCellClass() ?>"><div id="elh_itens_modulo_item" class="itens_modulo_item"><?= $Grid->renderFieldHeader($Grid->item) ?></div></th>
<?php } ?>
<?php if ($Grid->porcentagem_valor->Visible) { // porcentagem_valor ?>
        <th data-name="porcentagem_valor" class="<?= $Grid->porcentagem_valor->headerCellClass() ?>"><div id="elh_itens_modulo_porcentagem_valor" class="itens_modulo_porcentagem_valor"><?= $Grid->renderFieldHeader($Grid->porcentagem_valor) ?></div></th>
<?php } ?>
<?php if ($Grid->incidencia_inss->Visible) { // incidencia_inss ?>
        <th data-name="incidencia_inss" class="<?= $Grid->incidencia_inss->headerCellClass() ?>"><div id="elh_itens_modulo_incidencia_inss" class="itens_modulo_incidencia_inss"><?= $Grid->renderFieldHeader($Grid->incidencia_inss) ?></div></th>
<?php } ?>
<?php if ($Grid->ativo->Visible) { // ativo ?>
        <th data-name="ativo" class="<?= $Grid->ativo->headerCellClass() ?>"><div id="elh_itens_modulo_ativo" class="itens_modulo_ativo"><?= $Grid->renderFieldHeader($Grid->ativo) ?></div></th>
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
    <?php if ($Grid->item->Visible) { // item ?>
        <td data-name="item"<?= $Grid->item->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_item" class="el_itens_modulo_item">
<input type="<?= $Grid->item->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_item" id="x<?= $Grid->RowIndex ?>_item" data-table="itens_modulo" data-field="x_item" value="<?= $Grid->item->EditValue ?>" size="50" maxlength="155" placeholder="<?= HtmlEncode($Grid->item->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->item->formatPattern()) ?>"<?= $Grid->item->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->item->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="itens_modulo" data-field="x_item" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_item" id="o<?= $Grid->RowIndex ?>_item" value="<?= HtmlEncode($Grid->item->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_item" class="el_itens_modulo_item">
<input type="<?= $Grid->item->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_item" id="x<?= $Grid->RowIndex ?>_item" data-table="itens_modulo" data-field="x_item" value="<?= $Grid->item->EditValue ?>" size="50" maxlength="155" placeholder="<?= HtmlEncode($Grid->item->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->item->formatPattern()) ?>"<?= $Grid->item->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->item->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_item" class="el_itens_modulo_item">
<span<?= $Grid->item->viewAttributes() ?>>
<?= $Grid->item->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="itens_modulo" data-field="x_item" data-hidden="1" name="fitens_modulogrid$x<?= $Grid->RowIndex ?>_item" id="fitens_modulogrid$x<?= $Grid->RowIndex ?>_item" value="<?= HtmlEncode($Grid->item->FormValue) ?>">
<input type="hidden" data-table="itens_modulo" data-field="x_item" data-hidden="1" data-old name="fitens_modulogrid$o<?= $Grid->RowIndex ?>_item" id="fitens_modulogrid$o<?= $Grid->RowIndex ?>_item" value="<?= HtmlEncode($Grid->item->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->porcentagem_valor->Visible) { // porcentagem_valor ?>
        <td data-name="porcentagem_valor"<?= $Grid->porcentagem_valor->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_porcentagem_valor" class="el_itens_modulo_porcentagem_valor">
<input type="<?= $Grid->porcentagem_valor->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_porcentagem_valor" id="x<?= $Grid->RowIndex ?>_porcentagem_valor" data-table="itens_modulo" data-field="x_porcentagem_valor" value="<?= $Grid->porcentagem_valor->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Grid->porcentagem_valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->porcentagem_valor->formatPattern()) ?>"<?= $Grid->porcentagem_valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->porcentagem_valor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="itens_modulo" data-field="x_porcentagem_valor" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_porcentagem_valor" id="o<?= $Grid->RowIndex ?>_porcentagem_valor" value="<?= HtmlEncode($Grid->porcentagem_valor->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_porcentagem_valor" class="el_itens_modulo_porcentagem_valor">
<input type="<?= $Grid->porcentagem_valor->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_porcentagem_valor" id="x<?= $Grid->RowIndex ?>_porcentagem_valor" data-table="itens_modulo" data-field="x_porcentagem_valor" value="<?= $Grid->porcentagem_valor->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Grid->porcentagem_valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->porcentagem_valor->formatPattern()) ?>"<?= $Grid->porcentagem_valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->porcentagem_valor->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_porcentagem_valor" class="el_itens_modulo_porcentagem_valor">
<span<?= $Grid->porcentagem_valor->viewAttributes() ?>>
<?= $Grid->porcentagem_valor->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="itens_modulo" data-field="x_porcentagem_valor" data-hidden="1" name="fitens_modulogrid$x<?= $Grid->RowIndex ?>_porcentagem_valor" id="fitens_modulogrid$x<?= $Grid->RowIndex ?>_porcentagem_valor" value="<?= HtmlEncode($Grid->porcentagem_valor->FormValue) ?>">
<input type="hidden" data-table="itens_modulo" data-field="x_porcentagem_valor" data-hidden="1" data-old name="fitens_modulogrid$o<?= $Grid->RowIndex ?>_porcentagem_valor" id="fitens_modulogrid$o<?= $Grid->RowIndex ?>_porcentagem_valor" value="<?= HtmlEncode($Grid->porcentagem_valor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->incidencia_inss->Visible) { // incidencia_inss ?>
        <td data-name="incidencia_inss"<?= $Grid->incidencia_inss->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_incidencia_inss" class="el_itens_modulo_incidencia_inss">
<template id="tp_x<?= $Grid->RowIndex ?>_incidencia_inss">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="itens_modulo" data-field="x_incidencia_inss" name="x<?= $Grid->RowIndex ?>_incidencia_inss" id="x<?= $Grid->RowIndex ?>_incidencia_inss"<?= $Grid->incidencia_inss->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_incidencia_inss" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_incidencia_inss"
    name="x<?= $Grid->RowIndex ?>_incidencia_inss"
    value="<?= HtmlEncode($Grid->incidencia_inss->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_incidencia_inss"
    data-target="dsl_x<?= $Grid->RowIndex ?>_incidencia_inss"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->incidencia_inss->isInvalidClass() ?>"
    data-table="itens_modulo"
    data-field="x_incidencia_inss"
    data-value-separator="<?= $Grid->incidencia_inss->displayValueSeparatorAttribute() ?>"
    <?= $Grid->incidencia_inss->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->incidencia_inss->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="itens_modulo" data-field="x_incidencia_inss" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_incidencia_inss" id="o<?= $Grid->RowIndex ?>_incidencia_inss" value="<?= HtmlEncode($Grid->incidencia_inss->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_incidencia_inss" class="el_itens_modulo_incidencia_inss">
<template id="tp_x<?= $Grid->RowIndex ?>_incidencia_inss">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="itens_modulo" data-field="x_incidencia_inss" name="x<?= $Grid->RowIndex ?>_incidencia_inss" id="x<?= $Grid->RowIndex ?>_incidencia_inss"<?= $Grid->incidencia_inss->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_incidencia_inss" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_incidencia_inss"
    name="x<?= $Grid->RowIndex ?>_incidencia_inss"
    value="<?= HtmlEncode($Grid->incidencia_inss->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_incidencia_inss"
    data-target="dsl_x<?= $Grid->RowIndex ?>_incidencia_inss"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->incidencia_inss->isInvalidClass() ?>"
    data-table="itens_modulo"
    data-field="x_incidencia_inss"
    data-value-separator="<?= $Grid->incidencia_inss->displayValueSeparatorAttribute() ?>"
    <?= $Grid->incidencia_inss->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->incidencia_inss->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_incidencia_inss" class="el_itens_modulo_incidencia_inss">
<span<?= $Grid->incidencia_inss->viewAttributes() ?>>
<?= $Grid->incidencia_inss->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="itens_modulo" data-field="x_incidencia_inss" data-hidden="1" name="fitens_modulogrid$x<?= $Grid->RowIndex ?>_incidencia_inss" id="fitens_modulogrid$x<?= $Grid->RowIndex ?>_incidencia_inss" value="<?= HtmlEncode($Grid->incidencia_inss->FormValue) ?>">
<input type="hidden" data-table="itens_modulo" data-field="x_incidencia_inss" data-hidden="1" data-old name="fitens_modulogrid$o<?= $Grid->RowIndex ?>_incidencia_inss" id="fitens_modulogrid$o<?= $Grid->RowIndex ?>_incidencia_inss" value="<?= HtmlEncode($Grid->incidencia_inss->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ativo->Visible) { // ativo ?>
        <td data-name="ativo"<?= $Grid->ativo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_ativo" class="el_itens_modulo_ativo">
<template id="tp_x<?= $Grid->RowIndex ?>_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="itens_modulo" data-field="x_ativo" name="x<?= $Grid->RowIndex ?>_ativo" id="x<?= $Grid->RowIndex ?>_ativo"<?= $Grid->ativo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ativo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_ativo"
    name="x<?= $Grid->RowIndex ?>_ativo"
    value="<?= HtmlEncode($Grid->ativo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_ativo"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ativo"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ativo->isInvalidClass() ?>"
    data-table="itens_modulo"
    data-field="x_ativo"
    data-value-separator="<?= $Grid->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->ativo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="itens_modulo" data-field="x_ativo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ativo" id="o<?= $Grid->RowIndex ?>_ativo" value="<?= HtmlEncode($Grid->ativo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_ativo" class="el_itens_modulo_ativo">
<template id="tp_x<?= $Grid->RowIndex ?>_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="itens_modulo" data-field="x_ativo" name="x<?= $Grid->RowIndex ?>_ativo" id="x<?= $Grid->RowIndex ?>_ativo"<?= $Grid->ativo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ativo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_ativo"
    name="x<?= $Grid->RowIndex ?>_ativo"
    value="<?= HtmlEncode($Grid->ativo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_ativo"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ativo"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ativo->isInvalidClass() ?>"
    data-table="itens_modulo"
    data-field="x_ativo"
    data-value-separator="<?= $Grid->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->ativo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_itens_modulo_ativo" class="el_itens_modulo_ativo">
<span<?= $Grid->ativo->viewAttributes() ?>>
<?= $Grid->ativo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="itens_modulo" data-field="x_ativo" data-hidden="1" name="fitens_modulogrid$x<?= $Grid->RowIndex ?>_ativo" id="fitens_modulogrid$x<?= $Grid->RowIndex ?>_ativo" value="<?= HtmlEncode($Grid->ativo->FormValue) ?>">
<input type="hidden" data-table="itens_modulo" data-field="x_ativo" data-hidden="1" data-old name="fitens_modulogrid$o<?= $Grid->RowIndex ?>_ativo" id="fitens_modulogrid$o<?= $Grid->RowIndex ?>_ativo" value="<?= HtmlEncode($Grid->ativo->OldValue) ?>">
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
loadjs.ready(["fitens_modulogrid","load"], () => fitens_modulogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
    <?php if ($Grid->item->Visible) { // item ?>
        <td data-name="item" class="<?= $Grid->item->footerCellClass() ?>"><span id="elf_itens_modulo_item" class="itens_modulo_item">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Grid->item->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->porcentagem_valor->Visible) { // porcentagem_valor ?>
        <td data-name="porcentagem_valor" class="<?= $Grid->porcentagem_valor->footerCellClass() ?>"><span id="elf_itens_modulo_porcentagem_valor" class="itens_modulo_porcentagem_valor">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->porcentagem_valor->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->incidencia_inss->Visible) { // incidencia_inss ?>
        <td data-name="incidencia_inss" class="<?= $Grid->incidencia_inss->footerCellClass() ?>"><span id="elf_itens_modulo_incidencia_inss" class="itens_modulo_incidencia_inss">
        </span></td>
    <?php } ?>
    <?php if ($Grid->ativo->Visible) { // ativo ?>
        <td data-name="ativo" class="<?= $Grid->ativo->footerCellClass() ?>"><span id="elf_itens_modulo_ativo" class="itens_modulo_ativo">
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
<input type="hidden" name="detailpage" value="fitens_modulogrid">
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
    ew.addEventHandlers("itens_modulo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
