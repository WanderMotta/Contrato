<?php

namespace PHPMaker2024\contratos;

// Set up and run Grid object
$Grid = Container("ContatoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fcontatogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { contato: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcontatogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["contato", [fields.contato.visible && fields.contato.required ? ew.Validators.required(fields.contato.caption) : null], fields.contato.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
            ["telefone", [fields.telefone.visible && fields.telefone.required ? ew.Validators.required(fields.telefone.caption) : null], fields.telefone.isInvalid],
            ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
            ["ativo", [fields.ativo.visible && fields.ativo.required ? ew.Validators.required(fields.ativo.caption) : null], fields.ativo.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["contato",false],["_email",false],["telefone",false],["status",false],["ativo",false]];
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
            "status": <?= $Grid->status->toClientList($Grid) ?>,
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
<div id="fcontatogrid" class="ew-form ew-list-form">
<div id="gmp_contato" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_contatogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->contato->Visible) { // contato ?>
        <th data-name="contato" class="<?= $Grid->contato->headerCellClass() ?>"><div id="elh_contato_contato" class="contato_contato"><?= $Grid->renderFieldHeader($Grid->contato) ?></div></th>
<?php } ?>
<?php if ($Grid->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Grid->_email->headerCellClass() ?>"><div id="elh_contato__email" class="contato__email"><?= $Grid->renderFieldHeader($Grid->_email) ?></div></th>
<?php } ?>
<?php if ($Grid->telefone->Visible) { // telefone ?>
        <th data-name="telefone" class="<?= $Grid->telefone->headerCellClass() ?>"><div id="elh_contato_telefone" class="contato_telefone"><?= $Grid->renderFieldHeader($Grid->telefone) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_contato_status" class="contato_status"><?= $Grid->renderFieldHeader($Grid->status) ?></div></th>
<?php } ?>
<?php if ($Grid->ativo->Visible) { // ativo ?>
        <th data-name="ativo" class="<?= $Grid->ativo->headerCellClass() ?>"><div id="elh_contato_ativo" class="contato_ativo"><?= $Grid->renderFieldHeader($Grid->ativo) ?></div></th>
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
    <?php if ($Grid->contato->Visible) { // contato ?>
        <td data-name="contato"<?= $Grid->contato->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_contato" class="el_contato_contato">
<input type="<?= $Grid->contato->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contato" id="x<?= $Grid->RowIndex ?>_contato" data-table="contato" data-field="x_contato" value="<?= $Grid->contato->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->contato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->contato->formatPattern()) ?>"<?= $Grid->contato->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contato->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="contato" data-field="x_contato" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_contato" id="o<?= $Grid->RowIndex ?>_contato" value="<?= HtmlEncode($Grid->contato->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_contato" class="el_contato_contato">
<input type="<?= $Grid->contato->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contato" id="x<?= $Grid->RowIndex ?>_contato" data-table="contato" data-field="x_contato" value="<?= $Grid->contato->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->contato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->contato->formatPattern()) ?>"<?= $Grid->contato->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contato->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_contato" class="el_contato_contato">
<span<?= $Grid->contato->viewAttributes() ?>>
<?= $Grid->contato->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="contato" data-field="x_contato" data-hidden="1" name="fcontatogrid$x<?= $Grid->RowIndex ?>_contato" id="fcontatogrid$x<?= $Grid->RowIndex ?>_contato" value="<?= HtmlEncode($Grid->contato->FormValue) ?>">
<input type="hidden" data-table="contato" data-field="x_contato" data-hidden="1" data-old name="fcontatogrid$o<?= $Grid->RowIndex ?>_contato" id="fcontatogrid$o<?= $Grid->RowIndex ?>_contato" value="<?= HtmlEncode($Grid->contato->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_email->Visible) { // email ?>
        <td data-name="_email"<?= $Grid->_email->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato__email" class="el_contato__email">
<input type="<?= $Grid->_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" data-table="contato" data-field="x__email" value="<?= $Grid->_email->EditValue ?>" size="50" maxlength="120" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_email->formatPattern()) ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="contato" data-field="x__email" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>__email" id="o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato__email" class="el_contato__email">
<input type="<?= $Grid->_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" data-table="contato" data-field="x__email" value="<?= $Grid->_email->EditValue ?>" size="50" maxlength="120" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_email->formatPattern()) ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato__email" class="el_contato__email">
<span<?= $Grid->_email->viewAttributes() ?>>
<?= $Grid->_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="contato" data-field="x__email" data-hidden="1" name="fcontatogrid$x<?= $Grid->RowIndex ?>__email" id="fcontatogrid$x<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->FormValue) ?>">
<input type="hidden" data-table="contato" data-field="x__email" data-hidden="1" data-old name="fcontatogrid$o<?= $Grid->RowIndex ?>__email" id="fcontatogrid$o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->telefone->Visible) { // telefone ?>
        <td data-name="telefone"<?= $Grid->telefone->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_telefone" class="el_contato_telefone">
<input type="<?= $Grid->telefone->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_telefone" id="x<?= $Grid->RowIndex ?>_telefone" data-table="contato" data-field="x_telefone" value="<?= $Grid->telefone->EditValue ?>" size="45" maxlength="60" placeholder="<?= HtmlEncode($Grid->telefone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->telefone->formatPattern()) ?>"<?= $Grid->telefone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->telefone->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="contato" data-field="x_telefone" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_telefone" id="o<?= $Grid->RowIndex ?>_telefone" value="<?= HtmlEncode($Grid->telefone->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_telefone" class="el_contato_telefone">
<input type="<?= $Grid->telefone->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_telefone" id="x<?= $Grid->RowIndex ?>_telefone" data-table="contato" data-field="x_telefone" value="<?= $Grid->telefone->EditValue ?>" size="45" maxlength="60" placeholder="<?= HtmlEncode($Grid->telefone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->telefone->formatPattern()) ?>"<?= $Grid->telefone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->telefone->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_telefone" class="el_contato_telefone">
<span<?= $Grid->telefone->viewAttributes() ?>>
<?= $Grid->telefone->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="contato" data-field="x_telefone" data-hidden="1" name="fcontatogrid$x<?= $Grid->RowIndex ?>_telefone" id="fcontatogrid$x<?= $Grid->RowIndex ?>_telefone" value="<?= HtmlEncode($Grid->telefone->FormValue) ?>">
<input type="hidden" data-table="contato" data-field="x_telefone" data-hidden="1" data-old name="fcontatogrid$o<?= $Grid->RowIndex ?>_telefone" id="fcontatogrid$o<?= $Grid->RowIndex ?>_telefone" value="<?= HtmlEncode($Grid->telefone->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status"<?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_status" class="el_contato_status">
<template id="tp_x<?= $Grid->RowIndex ?>_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contato" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status"<?= $Grid->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status"
    name="x<?= $Grid->RowIndex ?>_status"
    value="<?= HtmlEncode($Grid->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status->isInvalidClass() ?>"
    data-table="contato"
    data-field="x_status"
    data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="contato" data-field="x_status" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_status" class="el_contato_status">
<template id="tp_x<?= $Grid->RowIndex ?>_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contato" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status"<?= $Grid->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status"
    name="x<?= $Grid->RowIndex ?>_status"
    value="<?= HtmlEncode($Grid->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status->isInvalidClass() ?>"
    data-table="contato"
    data-field="x_status"
    data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_status" class="el_contato_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="contato" data-field="x_status" data-hidden="1" name="fcontatogrid$x<?= $Grid->RowIndex ?>_status" id="fcontatogrid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="contato" data-field="x_status" data-hidden="1" data-old name="fcontatogrid$o<?= $Grid->RowIndex ?>_status" id="fcontatogrid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ativo->Visible) { // ativo ?>
        <td data-name="ativo"<?= $Grid->ativo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_ativo" class="el_contato_ativo">
<template id="tp_x<?= $Grid->RowIndex ?>_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contato" data-field="x_ativo" name="x<?= $Grid->RowIndex ?>_ativo" id="x<?= $Grid->RowIndex ?>_ativo"<?= $Grid->ativo->editAttributes() ?>>
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
    data-table="contato"
    data-field="x_ativo"
    data-value-separator="<?= $Grid->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->ativo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="contato" data-field="x_ativo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ativo" id="o<?= $Grid->RowIndex ?>_ativo" value="<?= HtmlEncode($Grid->ativo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_ativo" class="el_contato_ativo">
<template id="tp_x<?= $Grid->RowIndex ?>_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contato" data-field="x_ativo" name="x<?= $Grid->RowIndex ?>_ativo" id="x<?= $Grid->RowIndex ?>_ativo"<?= $Grid->ativo->editAttributes() ?>>
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
    data-table="contato"
    data-field="x_ativo"
    data-value-separator="<?= $Grid->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->ativo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_contato_ativo" class="el_contato_ativo">
<span<?= $Grid->ativo->viewAttributes() ?>>
<?= $Grid->ativo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="contato" data-field="x_ativo" data-hidden="1" name="fcontatogrid$x<?= $Grid->RowIndex ?>_ativo" id="fcontatogrid$x<?= $Grid->RowIndex ?>_ativo" value="<?= HtmlEncode($Grid->ativo->FormValue) ?>">
<input type="hidden" data-table="contato" data-field="x_ativo" data-hidden="1" data-old name="fcontatogrid$o<?= $Grid->RowIndex ?>_ativo" id="fcontatogrid$o<?= $Grid->RowIndex ?>_ativo" value="<?= HtmlEncode($Grid->ativo->OldValue) ?>">
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
loadjs.ready(["fcontatogrid","load"], () => fcontatogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fcontatogrid">
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
    ew.addEventHandlers("contato");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
