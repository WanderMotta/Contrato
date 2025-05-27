<?php

namespace PHPMaker2024\contratos;

// Set up and run Grid object
$Grid = Container("MovInsumoClienteGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fmov_insumo_clientegrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { mov_insumo_cliente: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmov_insumo_clientegrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["tipo_insumo_idtipo_insumo", [fields.tipo_insumo_idtipo_insumo.visible && fields.tipo_insumo_idtipo_insumo.required ? ew.Validators.required(fields.tipo_insumo_idtipo_insumo.caption) : null], fields.tipo_insumo_idtipo_insumo.isInvalid],
            ["insumo_idinsumo", [fields.insumo_idinsumo.visible && fields.insumo_idinsumo.required ? ew.Validators.required(fields.insumo_idinsumo.caption) : null], fields.insumo_idinsumo.isInvalid],
            ["qtde", [fields.qtde.visible && fields.qtde.required ? ew.Validators.required(fields.qtde.caption) : null, ew.Validators.float], fields.qtde.isInvalid],
            ["frequencia", [fields.frequencia.visible && fields.frequencia.required ? ew.Validators.required(fields.frequencia.caption) : null], fields.frequencia.isInvalid],
            ["vr_unit", [fields.vr_unit.visible && fields.vr_unit.required ? ew.Validators.required(fields.vr_unit.caption) : null], fields.vr_unit.isInvalid],
            ["vr_total", [fields.vr_total.visible && fields.vr_total.required ? ew.Validators.required(fields.vr_total.caption) : null], fields.vr_total.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["tipo_insumo_idtipo_insumo",false],["insumo_idinsumo",false],["qtde",false],["frequencia",false],["vr_unit",false],["vr_total",false]];
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
            "tipo_insumo_idtipo_insumo": <?= $Grid->tipo_insumo_idtipo_insumo->toClientList($Grid) ?>,
            "insumo_idinsumo": <?= $Grid->insumo_idinsumo->toClientList($Grid) ?>,
            "frequencia": <?= $Grid->frequencia->toClientList($Grid) ?>,
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
<div id="fmov_insumo_clientegrid" class="ew-form ew-list-form">
<div id="gmp_mov_insumo_cliente" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_mov_insumo_clientegrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <th data-name="tipo_insumo_idtipo_insumo" class="<?= $Grid->tipo_insumo_idtipo_insumo->headerCellClass() ?>"><div id="elh_mov_insumo_cliente_tipo_insumo_idtipo_insumo" class="mov_insumo_cliente_tipo_insumo_idtipo_insumo"><?= $Grid->renderFieldHeader($Grid->tipo_insumo_idtipo_insumo) ?></div></th>
<?php } ?>
<?php if ($Grid->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <th data-name="insumo_idinsumo" class="<?= $Grid->insumo_idinsumo->headerCellClass() ?>"><div id="elh_mov_insumo_cliente_insumo_idinsumo" class="mov_insumo_cliente_insumo_idinsumo"><?= $Grid->renderFieldHeader($Grid->insumo_idinsumo) ?></div></th>
<?php } ?>
<?php if ($Grid->qtde->Visible) { // qtde ?>
        <th data-name="qtde" class="<?= $Grid->qtde->headerCellClass() ?>"><div id="elh_mov_insumo_cliente_qtde" class="mov_insumo_cliente_qtde"><?= $Grid->renderFieldHeader($Grid->qtde) ?></div></th>
<?php } ?>
<?php if ($Grid->frequencia->Visible) { // frequencia ?>
        <th data-name="frequencia" class="<?= $Grid->frequencia->headerCellClass() ?>"><div id="elh_mov_insumo_cliente_frequencia" class="mov_insumo_cliente_frequencia"><?= $Grid->renderFieldHeader($Grid->frequencia) ?></div></th>
<?php } ?>
<?php if ($Grid->vr_unit->Visible) { // vr_unit ?>
        <th data-name="vr_unit" class="<?= $Grid->vr_unit->headerCellClass() ?>"><div id="elh_mov_insumo_cliente_vr_unit" class="mov_insumo_cliente_vr_unit"><?= $Grid->renderFieldHeader($Grid->vr_unit) ?></div></th>
<?php } ?>
<?php if ($Grid->vr_total->Visible) { // vr_total ?>
        <th data-name="vr_total" class="<?= $Grid->vr_total->headerCellClass() ?>"><div id="elh_mov_insumo_cliente_vr_total" class="mov_insumo_cliente_vr_total"><?= $Grid->renderFieldHeader($Grid->vr_total) ?></div></th>
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
    <?php if ($Grid->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <td data-name="tipo_insumo_idtipo_insumo"<?= $Grid->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_tipo_insumo_idtipo_insumo" class="el_mov_insumo_cliente_tipo_insumo_idtipo_insumo">
<template id="tp_x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="mov_insumo_cliente" data-field="x_tipo_insumo_idtipo_insumo" name="x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo" id="x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo"<?= $Grid->tipo_insumo_idtipo_insumo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo"
    name="x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo"
    value="<?= HtmlEncode($Grid->tipo_insumo_idtipo_insumo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo"
    data-target="dsl_x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->tipo_insumo_idtipo_insumo->isInvalidClass() ?>"
    data-table="mov_insumo_cliente"
    data-field="x_tipo_insumo_idtipo_insumo"
    data-value-separator="<?= $Grid->tipo_insumo_idtipo_insumo->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Grid->tipo_insumo_idtipo_insumo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->tipo_insumo_idtipo_insumo->getErrorMessage() ?></div>
<?= $Grid->tipo_insumo_idtipo_insumo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo_insumo_idtipo_insumo") ?>
</span>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_tipo_insumo_idtipo_insumo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo" id="o<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo" value="<?= HtmlEncode($Grid->tipo_insumo_idtipo_insumo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_tipo_insumo_idtipo_insumo" class="el_mov_insumo_cliente_tipo_insumo_idtipo_insumo">
<template id="tp_x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="mov_insumo_cliente" data-field="x_tipo_insumo_idtipo_insumo" name="x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo" id="x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo"<?= $Grid->tipo_insumo_idtipo_insumo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo"
    name="x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo"
    value="<?= HtmlEncode($Grid->tipo_insumo_idtipo_insumo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo"
    data-target="dsl_x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->tipo_insumo_idtipo_insumo->isInvalidClass() ?>"
    data-table="mov_insumo_cliente"
    data-field="x_tipo_insumo_idtipo_insumo"
    data-value-separator="<?= $Grid->tipo_insumo_idtipo_insumo->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Grid->tipo_insumo_idtipo_insumo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->tipo_insumo_idtipo_insumo->getErrorMessage() ?></div>
<?= $Grid->tipo_insumo_idtipo_insumo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo_insumo_idtipo_insumo") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_tipo_insumo_idtipo_insumo" class="el_mov_insumo_cliente_tipo_insumo_idtipo_insumo">
<span<?= $Grid->tipo_insumo_idtipo_insumo->viewAttributes() ?>>
<?= $Grid->tipo_insumo_idtipo_insumo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_tipo_insumo_idtipo_insumo" data-hidden="1" name="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo" id="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo" value="<?= HtmlEncode($Grid->tipo_insumo_idtipo_insumo->FormValue) ?>">
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_tipo_insumo_idtipo_insumo" data-hidden="1" data-old name="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo" id="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_tipo_insumo_idtipo_insumo" value="<?= HtmlEncode($Grid->tipo_insumo_idtipo_insumo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <td data-name="insumo_idinsumo"<?= $Grid->insumo_idinsumo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_insumo_idinsumo" class="el_mov_insumo_cliente_insumo_idinsumo">
    <select
        id="x<?= $Grid->RowIndex ?>_insumo_idinsumo"
        name="x<?= $Grid->RowIndex ?>_insumo_idinsumo"
        class="form-control ew-select<?= $Grid->insumo_idinsumo->isInvalidClass() ?>"
        data-select2-id="fmov_insumo_clientegrid_x<?= $Grid->RowIndex ?>_insumo_idinsumo"
        data-table="mov_insumo_cliente"
        data-field="x_insumo_idinsumo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->insumo_idinsumo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->insumo_idinsumo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->insumo_idinsumo->getPlaceHolder()) ?>"
        <?= $Grid->insumo_idinsumo->editAttributes() ?>>
        <?= $Grid->insumo_idinsumo->selectOptionListHtml("x{$Grid->RowIndex}_insumo_idinsumo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->insumo_idinsumo->getErrorMessage() ?></div>
<?= $Grid->insumo_idinsumo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_insumo_idinsumo") ?>
<script>
loadjs.ready("fmov_insumo_clientegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_insumo_idinsumo", selectId: "fmov_insumo_clientegrid_x<?= $Grid->RowIndex ?>_insumo_idinsumo" };
    if (fmov_insumo_clientegrid.lists.insumo_idinsumo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_insumo_idinsumo", form: "fmov_insumo_clientegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_insumo_idinsumo", form: "fmov_insumo_clientegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.mov_insumo_cliente.fields.insumo_idinsumo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_insumo_idinsumo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_insumo_idinsumo" id="o<?= $Grid->RowIndex ?>_insumo_idinsumo" value="<?= HtmlEncode($Grid->insumo_idinsumo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_insumo_idinsumo" class="el_mov_insumo_cliente_insumo_idinsumo">
    <select
        id="x<?= $Grid->RowIndex ?>_insumo_idinsumo"
        name="x<?= $Grid->RowIndex ?>_insumo_idinsumo"
        class="form-control ew-select<?= $Grid->insumo_idinsumo->isInvalidClass() ?>"
        data-select2-id="fmov_insumo_clientegrid_x<?= $Grid->RowIndex ?>_insumo_idinsumo"
        data-table="mov_insumo_cliente"
        data-field="x_insumo_idinsumo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->insumo_idinsumo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->insumo_idinsumo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->insumo_idinsumo->getPlaceHolder()) ?>"
        <?= $Grid->insumo_idinsumo->editAttributes() ?>>
        <?= $Grid->insumo_idinsumo->selectOptionListHtml("x{$Grid->RowIndex}_insumo_idinsumo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->insumo_idinsumo->getErrorMessage() ?></div>
<?= $Grid->insumo_idinsumo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_insumo_idinsumo") ?>
<script>
loadjs.ready("fmov_insumo_clientegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_insumo_idinsumo", selectId: "fmov_insumo_clientegrid_x<?= $Grid->RowIndex ?>_insumo_idinsumo" };
    if (fmov_insumo_clientegrid.lists.insumo_idinsumo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_insumo_idinsumo", form: "fmov_insumo_clientegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_insumo_idinsumo", form: "fmov_insumo_clientegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.mov_insumo_cliente.fields.insumo_idinsumo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_insumo_idinsumo" class="el_mov_insumo_cliente_insumo_idinsumo">
<span<?= $Grid->insumo_idinsumo->viewAttributes() ?>>
<?= $Grid->insumo_idinsumo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_insumo_idinsumo" data-hidden="1" name="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_insumo_idinsumo" id="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_insumo_idinsumo" value="<?= HtmlEncode($Grid->insumo_idinsumo->FormValue) ?>">
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_insumo_idinsumo" data-hidden="1" data-old name="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_insumo_idinsumo" id="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_insumo_idinsumo" value="<?= HtmlEncode($Grid->insumo_idinsumo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->qtde->Visible) { // qtde ?>
        <td data-name="qtde"<?= $Grid->qtde->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_qtde" class="el_mov_insumo_cliente_qtde">
<input type="<?= $Grid->qtde->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_qtde" id="x<?= $Grid->RowIndex ?>_qtde" data-table="mov_insumo_cliente" data-field="x_qtde" value="<?= $Grid->qtde->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Grid->qtde->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->qtde->formatPattern()) ?>"<?= $Grid->qtde->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->qtde->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_qtde" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_qtde" id="o<?= $Grid->RowIndex ?>_qtde" value="<?= HtmlEncode($Grid->qtde->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_qtde" class="el_mov_insumo_cliente_qtde">
<input type="<?= $Grid->qtde->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_qtde" id="x<?= $Grid->RowIndex ?>_qtde" data-table="mov_insumo_cliente" data-field="x_qtde" value="<?= $Grid->qtde->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Grid->qtde->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->qtde->formatPattern()) ?>"<?= $Grid->qtde->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->qtde->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_qtde" class="el_mov_insumo_cliente_qtde">
<span<?= $Grid->qtde->viewAttributes() ?>>
<?= $Grid->qtde->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_qtde" data-hidden="1" name="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_qtde" id="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_qtde" value="<?= HtmlEncode($Grid->qtde->FormValue) ?>">
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_qtde" data-hidden="1" data-old name="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_qtde" id="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_qtde" value="<?= HtmlEncode($Grid->qtde->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->frequencia->Visible) { // frequencia ?>
        <td data-name="frequencia"<?= $Grid->frequencia->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_frequencia" class="el_mov_insumo_cliente_frequencia">
<template id="tp_x<?= $Grid->RowIndex ?>_frequencia">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="mov_insumo_cliente" data-field="x_frequencia" name="x<?= $Grid->RowIndex ?>_frequencia" id="x<?= $Grid->RowIndex ?>_frequencia"<?= $Grid->frequencia->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_frequencia" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_frequencia"
    name="x<?= $Grid->RowIndex ?>_frequencia"
    value="<?= HtmlEncode($Grid->frequencia->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_frequencia"
    data-target="dsl_x<?= $Grid->RowIndex ?>_frequencia"
    data-repeatcolumn="6"
    class="form-control<?= $Grid->frequencia->isInvalidClass() ?>"
    data-table="mov_insumo_cliente"
    data-field="x_frequencia"
    data-value-separator="<?= $Grid->frequencia->displayValueSeparatorAttribute() ?>"
    <?= $Grid->frequencia->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->frequencia->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_frequencia" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_frequencia" id="o<?= $Grid->RowIndex ?>_frequencia" value="<?= HtmlEncode($Grid->frequencia->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_frequencia" class="el_mov_insumo_cliente_frequencia">
<template id="tp_x<?= $Grid->RowIndex ?>_frequencia">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="mov_insumo_cliente" data-field="x_frequencia" name="x<?= $Grid->RowIndex ?>_frequencia" id="x<?= $Grid->RowIndex ?>_frequencia"<?= $Grid->frequencia->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_frequencia" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_frequencia"
    name="x<?= $Grid->RowIndex ?>_frequencia"
    value="<?= HtmlEncode($Grid->frequencia->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_frequencia"
    data-target="dsl_x<?= $Grid->RowIndex ?>_frequencia"
    data-repeatcolumn="6"
    class="form-control<?= $Grid->frequencia->isInvalidClass() ?>"
    data-table="mov_insumo_cliente"
    data-field="x_frequencia"
    data-value-separator="<?= $Grid->frequencia->displayValueSeparatorAttribute() ?>"
    <?= $Grid->frequencia->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->frequencia->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_frequencia" class="el_mov_insumo_cliente_frequencia">
<span<?= $Grid->frequencia->viewAttributes() ?>>
<?= $Grid->frequencia->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_frequencia" data-hidden="1" name="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_frequencia" id="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_frequencia" value="<?= HtmlEncode($Grid->frequencia->FormValue) ?>">
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_frequencia" data-hidden="1" data-old name="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_frequencia" id="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_frequencia" value="<?= HtmlEncode($Grid->frequencia->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->vr_unit->Visible) { // vr_unit ?>
        <td data-name="vr_unit"<?= $Grid->vr_unit->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_vr_unit" class="el_mov_insumo_cliente_vr_unit">
<input type="<?= $Grid->vr_unit->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_vr_unit" id="x<?= $Grid->RowIndex ?>_vr_unit" data-table="mov_insumo_cliente" data-field="x_vr_unit" value="<?= $Grid->vr_unit->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->vr_unit->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->vr_unit->formatPattern()) ?>"<?= $Grid->vr_unit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->vr_unit->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_vr_unit" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_vr_unit" id="o<?= $Grid->RowIndex ?>_vr_unit" value="<?= HtmlEncode($Grid->vr_unit->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_vr_unit" class="el_mov_insumo_cliente_vr_unit">
<span<?= $Grid->vr_unit->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vr_unit->getDisplayValue($Grid->vr_unit->EditValue))) ?>"></span>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_vr_unit" data-hidden="1" name="x<?= $Grid->RowIndex ?>_vr_unit" id="x<?= $Grid->RowIndex ?>_vr_unit" value="<?= HtmlEncode($Grid->vr_unit->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_vr_unit" class="el_mov_insumo_cliente_vr_unit">
<span<?= $Grid->vr_unit->viewAttributes() ?>>
<?= $Grid->vr_unit->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_vr_unit" data-hidden="1" name="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_vr_unit" id="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_vr_unit" value="<?= HtmlEncode($Grid->vr_unit->FormValue) ?>">
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_vr_unit" data-hidden="1" data-old name="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_vr_unit" id="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_vr_unit" value="<?= HtmlEncode($Grid->vr_unit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->vr_total->Visible) { // vr_total ?>
        <td data-name="vr_total"<?= $Grid->vr_total->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_vr_total" class="el_mov_insumo_cliente_vr_total">
<input type="<?= $Grid->vr_total->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_vr_total" id="x<?= $Grid->RowIndex ?>_vr_total" data-table="mov_insumo_cliente" data-field="x_vr_total" value="<?= $Grid->vr_total->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->vr_total->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->vr_total->formatPattern()) ?>"<?= $Grid->vr_total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->vr_total->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_vr_total" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_vr_total" id="o<?= $Grid->RowIndex ?>_vr_total" value="<?= HtmlEncode($Grid->vr_total->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_vr_total" class="el_mov_insumo_cliente_vr_total">
<span<?= $Grid->vr_total->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->vr_total->getDisplayValue($Grid->vr_total->EditValue))) ?>"></span>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_vr_total" data-hidden="1" name="x<?= $Grid->RowIndex ?>_vr_total" id="x<?= $Grid->RowIndex ?>_vr_total" value="<?= HtmlEncode($Grid->vr_total->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_mov_insumo_cliente_vr_total" class="el_mov_insumo_cliente_vr_total">
<span<?= $Grid->vr_total->viewAttributes() ?>>
<?= $Grid->vr_total->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_vr_total" data-hidden="1" name="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_vr_total" id="fmov_insumo_clientegrid$x<?= $Grid->RowIndex ?>_vr_total" value="<?= HtmlEncode($Grid->vr_total->FormValue) ?>">
<input type="hidden" data-table="mov_insumo_cliente" data-field="x_vr_total" data-hidden="1" data-old name="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_vr_total" id="fmov_insumo_clientegrid$o<?= $Grid->RowIndex ?>_vr_total" value="<?= HtmlEncode($Grid->vr_total->OldValue) ?>">
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
loadjs.ready(["fmov_insumo_clientegrid","load"], () => fmov_insumo_clientegrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
    <?php if ($Grid->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <td data-name="tipo_insumo_idtipo_insumo" class="<?= $Grid->tipo_insumo_idtipo_insumo->footerCellClass() ?>"><span id="elf_mov_insumo_cliente_tipo_insumo_idtipo_insumo" class="mov_insumo_cliente_tipo_insumo_idtipo_insumo">
        </span></td>
    <?php } ?>
    <?php if ($Grid->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <td data-name="insumo_idinsumo" class="<?= $Grid->insumo_idinsumo->footerCellClass() ?>"><span id="elf_mov_insumo_cliente_insumo_idinsumo" class="mov_insumo_cliente_insumo_idinsumo">
        </span></td>
    <?php } ?>
    <?php if ($Grid->qtde->Visible) { // qtde ?>
        <td data-name="qtde" class="<?= $Grid->qtde->footerCellClass() ?>"><span id="elf_mov_insumo_cliente_qtde" class="mov_insumo_cliente_qtde">
        </span></td>
    <?php } ?>
    <?php if ($Grid->frequencia->Visible) { // frequencia ?>
        <td data-name="frequencia" class="<?= $Grid->frequencia->footerCellClass() ?>"><span id="elf_mov_insumo_cliente_frequencia" class="mov_insumo_cliente_frequencia">
        </span></td>
    <?php } ?>
    <?php if ($Grid->vr_unit->Visible) { // vr_unit ?>
        <td data-name="vr_unit" class="<?= $Grid->vr_unit->footerCellClass() ?>"><span id="elf_mov_insumo_cliente_vr_unit" class="mov_insumo_cliente_vr_unit">
        </span></td>
    <?php } ?>
    <?php if ($Grid->vr_total->Visible) { // vr_total ?>
        <td data-name="vr_total" class="<?= $Grid->vr_total->footerCellClass() ?>"><span id="elf_mov_insumo_cliente_vr_total" class="mov_insumo_cliente_vr_total">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->vr_total->ViewValue ?></span>
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
<input type="hidden" name="detailpage" value="fmov_insumo_clientegrid">
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
    ew.addEventHandlers("mov_insumo_cliente");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
