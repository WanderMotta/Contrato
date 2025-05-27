<?php

namespace PHPMaker2024\contratos;

// Set up and run Grid object
$Grid = Container("MovimentoPlaCustoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fmovimento_pla_custogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { movimento_pla_custo: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmovimento_pla_custogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["planilha_custo_idplanilha_custo", [fields.planilha_custo_idplanilha_custo.visible && fields.planilha_custo_idplanilha_custo.required ? ew.Validators.required(fields.planilha_custo_idplanilha_custo.caption) : null, ew.Validators.integer], fields.planilha_custo_idplanilha_custo.isInvalid],
            ["modulo_idmodulo", [fields.modulo_idmodulo.visible && fields.modulo_idmodulo.required ? ew.Validators.required(fields.modulo_idmodulo.caption) : null], fields.modulo_idmodulo.isInvalid],
            ["itens_modulo_iditens_modulo", [fields.itens_modulo_iditens_modulo.visible && fields.itens_modulo_iditens_modulo.required ? ew.Validators.required(fields.itens_modulo_iditens_modulo.caption) : null], fields.itens_modulo_iditens_modulo.isInvalid],
            ["porcentagem", [fields.porcentagem.visible && fields.porcentagem.required ? ew.Validators.required(fields.porcentagem.caption) : null, ew.Validators.float], fields.porcentagem.isInvalid],
            ["valor", [fields.valor.visible && fields.valor.required ? ew.Validators.required(fields.valor.caption) : null, ew.Validators.float], fields.valor.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
            ["calculo_idcalculo", [fields.calculo_idcalculo.visible && fields.calculo_idcalculo.required ? ew.Validators.required(fields.calculo_idcalculo.caption) : null, ew.Validators.integer], fields.calculo_idcalculo.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["planilha_custo_idplanilha_custo",false],["modulo_idmodulo",false],["itens_modulo_iditens_modulo",false],["porcentagem",false],["valor",false],["obs",false],["calculo_idcalculo",false]];
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
            "modulo_idmodulo": <?= $Grid->modulo_idmodulo->toClientList($Grid) ?>,
            "itens_modulo_iditens_modulo": <?= $Grid->itens_modulo_iditens_modulo->toClientList($Grid) ?>,
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
<div id="fmovimento_pla_custogrid" class="ew-form ew-list-form">
<div id="gmp_movimento_pla_custo" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_movimento_pla_custogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
        <th data-name="planilha_custo_idplanilha_custo" class="<?= $Grid->planilha_custo_idplanilha_custo->headerCellClass() ?>"><div id="elh_movimento_pla_custo_planilha_custo_idplanilha_custo" class="movimento_pla_custo_planilha_custo_idplanilha_custo"><?= $Grid->renderFieldHeader($Grid->planilha_custo_idplanilha_custo) ?></div></th>
<?php } ?>
<?php if ($Grid->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <th data-name="modulo_idmodulo" class="<?= $Grid->modulo_idmodulo->headerCellClass() ?>"><div id="elh_movimento_pla_custo_modulo_idmodulo" class="movimento_pla_custo_modulo_idmodulo"><?= $Grid->renderFieldHeader($Grid->modulo_idmodulo) ?></div></th>
<?php } ?>
<?php if ($Grid->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
        <th data-name="itens_modulo_iditens_modulo" class="<?= $Grid->itens_modulo_iditens_modulo->headerCellClass() ?>"><div id="elh_movimento_pla_custo_itens_modulo_iditens_modulo" class="movimento_pla_custo_itens_modulo_iditens_modulo"><?= $Grid->renderFieldHeader($Grid->itens_modulo_iditens_modulo) ?></div></th>
<?php } ?>
<?php if ($Grid->porcentagem->Visible) { // porcentagem ?>
        <th data-name="porcentagem" class="<?= $Grid->porcentagem->headerCellClass() ?>"><div id="elh_movimento_pla_custo_porcentagem" class="movimento_pla_custo_porcentagem"><?= $Grid->renderFieldHeader($Grid->porcentagem) ?></div></th>
<?php } ?>
<?php if ($Grid->valor->Visible) { // valor ?>
        <th data-name="valor" class="<?= $Grid->valor->headerCellClass() ?>"><div id="elh_movimento_pla_custo_valor" class="movimento_pla_custo_valor"><?= $Grid->renderFieldHeader($Grid->valor) ?></div></th>
<?php } ?>
<?php if ($Grid->obs->Visible) { // obs ?>
        <th data-name="obs" class="<?= $Grid->obs->headerCellClass() ?>"><div id="elh_movimento_pla_custo_obs" class="movimento_pla_custo_obs"><?= $Grid->renderFieldHeader($Grid->obs) ?></div></th>
<?php } ?>
<?php if ($Grid->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
        <th data-name="calculo_idcalculo" class="<?= $Grid->calculo_idcalculo->headerCellClass() ?>"><div id="elh_movimento_pla_custo_calculo_idcalculo" class="movimento_pla_custo_calculo_idcalculo"><?= $Grid->renderFieldHeader($Grid->calculo_idcalculo) ?></div></th>
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
    <?php if ($Grid->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
        <td data-name="planilha_custo_idplanilha_custo"<?= $Grid->planilha_custo_idplanilha_custo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->planilha_custo_idplanilha_custo->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_planilha_custo_idplanilha_custo" class="el_movimento_pla_custo_planilha_custo_idplanilha_custo">
<span<?= $Grid->planilha_custo_idplanilha_custo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->planilha_custo_idplanilha_custo->getDisplayValue($Grid->planilha_custo_idplanilha_custo->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" name="x<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" value="<?= HtmlEncode($Grid->planilha_custo_idplanilha_custo->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_planilha_custo_idplanilha_custo" class="el_movimento_pla_custo_planilha_custo_idplanilha_custo">
<input type="<?= $Grid->planilha_custo_idplanilha_custo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" id="x<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" data-table="movimento_pla_custo" data-field="x_planilha_custo_idplanilha_custo" value="<?= $Grid->planilha_custo_idplanilha_custo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->planilha_custo_idplanilha_custo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->planilha_custo_idplanilha_custo->formatPattern()) ?>"<?= $Grid->planilha_custo_idplanilha_custo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->planilha_custo_idplanilha_custo->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_planilha_custo_idplanilha_custo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" id="o<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" value="<?= HtmlEncode($Grid->planilha_custo_idplanilha_custo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->planilha_custo_idplanilha_custo->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_planilha_custo_idplanilha_custo" class="el_movimento_pla_custo_planilha_custo_idplanilha_custo">
<span<?= $Grid->planilha_custo_idplanilha_custo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->planilha_custo_idplanilha_custo->getDisplayValue($Grid->planilha_custo_idplanilha_custo->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" name="x<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" value="<?= HtmlEncode($Grid->planilha_custo_idplanilha_custo->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_planilha_custo_idplanilha_custo" class="el_movimento_pla_custo_planilha_custo_idplanilha_custo">
<input type="<?= $Grid->planilha_custo_idplanilha_custo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" id="x<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" data-table="movimento_pla_custo" data-field="x_planilha_custo_idplanilha_custo" value="<?= $Grid->planilha_custo_idplanilha_custo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->planilha_custo_idplanilha_custo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->planilha_custo_idplanilha_custo->formatPattern()) ?>"<?= $Grid->planilha_custo_idplanilha_custo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->planilha_custo_idplanilha_custo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_planilha_custo_idplanilha_custo" class="el_movimento_pla_custo_planilha_custo_idplanilha_custo">
<span<?= $Grid->planilha_custo_idplanilha_custo->viewAttributes() ?>>
<?= $Grid->planilha_custo_idplanilha_custo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_planilha_custo_idplanilha_custo" data-hidden="1" name="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" id="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" value="<?= HtmlEncode($Grid->planilha_custo_idplanilha_custo->FormValue) ?>">
<input type="hidden" data-table="movimento_pla_custo" data-field="x_planilha_custo_idplanilha_custo" data-hidden="1" data-old name="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" id="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_planilha_custo_idplanilha_custo" value="<?= HtmlEncode($Grid->planilha_custo_idplanilha_custo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <td data-name="modulo_idmodulo"<?= $Grid->modulo_idmodulo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_modulo_idmodulo" class="el_movimento_pla_custo_modulo_idmodulo">
    <select
        id="x<?= $Grid->RowIndex ?>_modulo_idmodulo"
        name="x<?= $Grid->RowIndex ?>_modulo_idmodulo"
        class="form-control ew-select<?= $Grid->modulo_idmodulo->isInvalidClass() ?>"
        data-select2-id="fmovimento_pla_custogrid_x<?= $Grid->RowIndex ?>_modulo_idmodulo"
        data-table="movimento_pla_custo"
        data-field="x_modulo_idmodulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->modulo_idmodulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->modulo_idmodulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->modulo_idmodulo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Grid->modulo_idmodulo->editAttributes() ?>>
        <?= $Grid->modulo_idmodulo->selectOptionListHtml("x{$Grid->RowIndex}_modulo_idmodulo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->modulo_idmodulo->getErrorMessage() ?></div>
<?= $Grid->modulo_idmodulo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_modulo_idmodulo") ?>
<script>
loadjs.ready("fmovimento_pla_custogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_modulo_idmodulo", selectId: "fmovimento_pla_custogrid_x<?= $Grid->RowIndex ?>_modulo_idmodulo" };
    if (fmovimento_pla_custogrid.lists.modulo_idmodulo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_modulo_idmodulo", form: "fmovimento_pla_custogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_modulo_idmodulo", form: "fmovimento_pla_custogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.movimento_pla_custo.fields.modulo_idmodulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_modulo_idmodulo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_modulo_idmodulo" id="o<?= $Grid->RowIndex ?>_modulo_idmodulo" value="<?= HtmlEncode($Grid->modulo_idmodulo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_modulo_idmodulo" class="el_movimento_pla_custo_modulo_idmodulo">
    <select
        id="x<?= $Grid->RowIndex ?>_modulo_idmodulo"
        name="x<?= $Grid->RowIndex ?>_modulo_idmodulo"
        class="form-control ew-select<?= $Grid->modulo_idmodulo->isInvalidClass() ?>"
        data-select2-id="fmovimento_pla_custogrid_x<?= $Grid->RowIndex ?>_modulo_idmodulo"
        data-table="movimento_pla_custo"
        data-field="x_modulo_idmodulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->modulo_idmodulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->modulo_idmodulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->modulo_idmodulo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Grid->modulo_idmodulo->editAttributes() ?>>
        <?= $Grid->modulo_idmodulo->selectOptionListHtml("x{$Grid->RowIndex}_modulo_idmodulo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->modulo_idmodulo->getErrorMessage() ?></div>
<?= $Grid->modulo_idmodulo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_modulo_idmodulo") ?>
<script>
loadjs.ready("fmovimento_pla_custogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_modulo_idmodulo", selectId: "fmovimento_pla_custogrid_x<?= $Grid->RowIndex ?>_modulo_idmodulo" };
    if (fmovimento_pla_custogrid.lists.modulo_idmodulo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_modulo_idmodulo", form: "fmovimento_pla_custogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_modulo_idmodulo", form: "fmovimento_pla_custogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.movimento_pla_custo.fields.modulo_idmodulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_modulo_idmodulo" class="el_movimento_pla_custo_modulo_idmodulo">
<span<?= $Grid->modulo_idmodulo->viewAttributes() ?>>
<?= $Grid->modulo_idmodulo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_modulo_idmodulo" data-hidden="1" name="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_modulo_idmodulo" id="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_modulo_idmodulo" value="<?= HtmlEncode($Grid->modulo_idmodulo->FormValue) ?>">
<input type="hidden" data-table="movimento_pla_custo" data-field="x_modulo_idmodulo" data-hidden="1" data-old name="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_modulo_idmodulo" id="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_modulo_idmodulo" value="<?= HtmlEncode($Grid->modulo_idmodulo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
        <td data-name="itens_modulo_iditens_modulo"<?= $Grid->itens_modulo_iditens_modulo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_itens_modulo_iditens_modulo" class="el_movimento_pla_custo_itens_modulo_iditens_modulo">
    <select
        id="x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo"
        name="x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo"
        class="form-control ew-select<?= $Grid->itens_modulo_iditens_modulo->isInvalidClass() ?>"
        data-select2-id="fmovimento_pla_custogrid_x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo"
        data-table="movimento_pla_custo"
        data-field="x_itens_modulo_iditens_modulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->itens_modulo_iditens_modulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->itens_modulo_iditens_modulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->itens_modulo_iditens_modulo->getPlaceHolder()) ?>"
        <?= $Grid->itens_modulo_iditens_modulo->editAttributes() ?>>
        <?= $Grid->itens_modulo_iditens_modulo->selectOptionListHtml("x{$Grid->RowIndex}_itens_modulo_iditens_modulo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->itens_modulo_iditens_modulo->getErrorMessage() ?></div>
<?= $Grid->itens_modulo_iditens_modulo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_itens_modulo_iditens_modulo") ?>
<script>
loadjs.ready("fmovimento_pla_custogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo", selectId: "fmovimento_pla_custogrid_x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo" };
    if (fmovimento_pla_custogrid.lists.itens_modulo_iditens_modulo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo", form: "fmovimento_pla_custogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo", form: "fmovimento_pla_custogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.movimento_pla_custo.fields.itens_modulo_iditens_modulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_itens_modulo_iditens_modulo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo" id="o<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo" value="<?= HtmlEncode($Grid->itens_modulo_iditens_modulo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_itens_modulo_iditens_modulo" class="el_movimento_pla_custo_itens_modulo_iditens_modulo">
    <select
        id="x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo"
        name="x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo"
        class="form-control ew-select<?= $Grid->itens_modulo_iditens_modulo->isInvalidClass() ?>"
        data-select2-id="fmovimento_pla_custogrid_x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo"
        data-table="movimento_pla_custo"
        data-field="x_itens_modulo_iditens_modulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->itens_modulo_iditens_modulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->itens_modulo_iditens_modulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->itens_modulo_iditens_modulo->getPlaceHolder()) ?>"
        <?= $Grid->itens_modulo_iditens_modulo->editAttributes() ?>>
        <?= $Grid->itens_modulo_iditens_modulo->selectOptionListHtml("x{$Grid->RowIndex}_itens_modulo_iditens_modulo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->itens_modulo_iditens_modulo->getErrorMessage() ?></div>
<?= $Grid->itens_modulo_iditens_modulo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_itens_modulo_iditens_modulo") ?>
<script>
loadjs.ready("fmovimento_pla_custogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo", selectId: "fmovimento_pla_custogrid_x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo" };
    if (fmovimento_pla_custogrid.lists.itens_modulo_iditens_modulo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo", form: "fmovimento_pla_custogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo", form: "fmovimento_pla_custogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.movimento_pla_custo.fields.itens_modulo_iditens_modulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_itens_modulo_iditens_modulo" class="el_movimento_pla_custo_itens_modulo_iditens_modulo">
<span<?= $Grid->itens_modulo_iditens_modulo->viewAttributes() ?>>
<?= $Grid->itens_modulo_iditens_modulo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_itens_modulo_iditens_modulo" data-hidden="1" name="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo" id="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo" value="<?= HtmlEncode($Grid->itens_modulo_iditens_modulo->FormValue) ?>">
<input type="hidden" data-table="movimento_pla_custo" data-field="x_itens_modulo_iditens_modulo" data-hidden="1" data-old name="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo" id="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_itens_modulo_iditens_modulo" value="<?= HtmlEncode($Grid->itens_modulo_iditens_modulo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->porcentagem->Visible) { // porcentagem ?>
        <td data-name="porcentagem"<?= $Grid->porcentagem->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_porcentagem" class="el_movimento_pla_custo_porcentagem">
<input type="<?= $Grid->porcentagem->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_porcentagem" id="x<?= $Grid->RowIndex ?>_porcentagem" data-table="movimento_pla_custo" data-field="x_porcentagem" value="<?= $Grid->porcentagem->EditValue ?>" size="5" maxlength="5" placeholder="<?= HtmlEncode($Grid->porcentagem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->porcentagem->formatPattern()) ?>"<?= $Grid->porcentagem->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->porcentagem->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_porcentagem" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_porcentagem" id="o<?= $Grid->RowIndex ?>_porcentagem" value="<?= HtmlEncode($Grid->porcentagem->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_porcentagem" class="el_movimento_pla_custo_porcentagem">
<input type="<?= $Grid->porcentagem->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_porcentagem" id="x<?= $Grid->RowIndex ?>_porcentagem" data-table="movimento_pla_custo" data-field="x_porcentagem" value="<?= $Grid->porcentagem->EditValue ?>" size="5" maxlength="5" placeholder="<?= HtmlEncode($Grid->porcentagem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->porcentagem->formatPattern()) ?>"<?= $Grid->porcentagem->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->porcentagem->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_porcentagem" class="el_movimento_pla_custo_porcentagem">
<span<?= $Grid->porcentagem->viewAttributes() ?>>
<?= $Grid->porcentagem->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_porcentagem" data-hidden="1" name="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_porcentagem" id="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_porcentagem" value="<?= HtmlEncode($Grid->porcentagem->FormValue) ?>">
<input type="hidden" data-table="movimento_pla_custo" data-field="x_porcentagem" data-hidden="1" data-old name="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_porcentagem" id="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_porcentagem" value="<?= HtmlEncode($Grid->porcentagem->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->valor->Visible) { // valor ?>
        <td data-name="valor"<?= $Grid->valor->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_valor" class="el_movimento_pla_custo_valor">
<input type="<?= $Grid->valor->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_valor" id="x<?= $Grid->RowIndex ?>_valor" data-table="movimento_pla_custo" data-field="x_valor" value="<?= $Grid->valor->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->valor->formatPattern()) ?>"<?= $Grid->valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->valor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_valor" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_valor" id="o<?= $Grid->RowIndex ?>_valor" value="<?= HtmlEncode($Grid->valor->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_valor" class="el_movimento_pla_custo_valor">
<input type="<?= $Grid->valor->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_valor" id="x<?= $Grid->RowIndex ?>_valor" data-table="movimento_pla_custo" data-field="x_valor" value="<?= $Grid->valor->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->valor->formatPattern()) ?>"<?= $Grid->valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->valor->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_valor" class="el_movimento_pla_custo_valor">
<span<?= $Grid->valor->viewAttributes() ?>>
<?= $Grid->valor->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_valor" data-hidden="1" name="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_valor" id="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_valor" value="<?= HtmlEncode($Grid->valor->FormValue) ?>">
<input type="hidden" data-table="movimento_pla_custo" data-field="x_valor" data-hidden="1" data-old name="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_valor" id="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_valor" value="<?= HtmlEncode($Grid->valor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->obs->Visible) { // obs ?>
        <td data-name="obs"<?= $Grid->obs->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_obs" class="el_movimento_pla_custo_obs">
<input type="<?= $Grid->obs->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_obs" id="x<?= $Grid->RowIndex ?>_obs" data-table="movimento_pla_custo" data-field="x_obs" value="<?= $Grid->obs->EditValue ?>" size="50" maxlength="155" placeholder="<?= HtmlEncode($Grid->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->obs->formatPattern()) ?>"<?= $Grid->obs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->obs->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_obs" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_obs" id="o<?= $Grid->RowIndex ?>_obs" value="<?= HtmlEncode($Grid->obs->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_obs" class="el_movimento_pla_custo_obs">
<input type="<?= $Grid->obs->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_obs" id="x<?= $Grid->RowIndex ?>_obs" data-table="movimento_pla_custo" data-field="x_obs" value="<?= $Grid->obs->EditValue ?>" size="50" maxlength="155" placeholder="<?= HtmlEncode($Grid->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->obs->formatPattern()) ?>"<?= $Grid->obs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->obs->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_obs" class="el_movimento_pla_custo_obs">
<span<?= $Grid->obs->viewAttributes() ?>>
<?= $Grid->obs->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_obs" data-hidden="1" name="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_obs" id="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_obs" value="<?= HtmlEncode($Grid->obs->FormValue) ?>">
<input type="hidden" data-table="movimento_pla_custo" data-field="x_obs" data-hidden="1" data-old name="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_obs" id="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_obs" value="<?= HtmlEncode($Grid->obs->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
        <td data-name="calculo_idcalculo"<?= $Grid->calculo_idcalculo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->calculo_idcalculo->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_calculo_idcalculo" class="el_movimento_pla_custo_calculo_idcalculo">
<span<?= $Grid->calculo_idcalculo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->calculo_idcalculo->getDisplayValue($Grid->calculo_idcalculo->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_calculo_idcalculo" name="x<?= $Grid->RowIndex ?>_calculo_idcalculo" value="<?= HtmlEncode($Grid->calculo_idcalculo->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_calculo_idcalculo" class="el_movimento_pla_custo_calculo_idcalculo">
<input type="<?= $Grid->calculo_idcalculo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_calculo_idcalculo" id="x<?= $Grid->RowIndex ?>_calculo_idcalculo" data-table="movimento_pla_custo" data-field="x_calculo_idcalculo" value="<?= $Grid->calculo_idcalculo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->calculo_idcalculo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->calculo_idcalculo->formatPattern()) ?>"<?= $Grid->calculo_idcalculo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->calculo_idcalculo->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_calculo_idcalculo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_calculo_idcalculo" id="o<?= $Grid->RowIndex ?>_calculo_idcalculo" value="<?= HtmlEncode($Grid->calculo_idcalculo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->calculo_idcalculo->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_calculo_idcalculo" class="el_movimento_pla_custo_calculo_idcalculo">
<span<?= $Grid->calculo_idcalculo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->calculo_idcalculo->getDisplayValue($Grid->calculo_idcalculo->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_calculo_idcalculo" name="x<?= $Grid->RowIndex ?>_calculo_idcalculo" value="<?= HtmlEncode($Grid->calculo_idcalculo->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_calculo_idcalculo" class="el_movimento_pla_custo_calculo_idcalculo">
<input type="<?= $Grid->calculo_idcalculo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_calculo_idcalculo" id="x<?= $Grid->RowIndex ?>_calculo_idcalculo" data-table="movimento_pla_custo" data-field="x_calculo_idcalculo" value="<?= $Grid->calculo_idcalculo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->calculo_idcalculo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->calculo_idcalculo->formatPattern()) ?>"<?= $Grid->calculo_idcalculo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->calculo_idcalculo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_movimento_pla_custo_calculo_idcalculo" class="el_movimento_pla_custo_calculo_idcalculo">
<span<?= $Grid->calculo_idcalculo->viewAttributes() ?>>
<?= $Grid->calculo_idcalculo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="movimento_pla_custo" data-field="x_calculo_idcalculo" data-hidden="1" name="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_calculo_idcalculo" id="fmovimento_pla_custogrid$x<?= $Grid->RowIndex ?>_calculo_idcalculo" value="<?= HtmlEncode($Grid->calculo_idcalculo->FormValue) ?>">
<input type="hidden" data-table="movimento_pla_custo" data-field="x_calculo_idcalculo" data-hidden="1" data-old name="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_calculo_idcalculo" id="fmovimento_pla_custogrid$o<?= $Grid->RowIndex ?>_calculo_idcalculo" value="<?= HtmlEncode($Grid->calculo_idcalculo->OldValue) ?>">
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
loadjs.ready(["fmovimento_pla_custogrid","load"], () => fmovimento_pla_custogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
    <?php if ($Grid->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
        <td data-name="planilha_custo_idplanilha_custo" class="<?= $Grid->planilha_custo_idplanilha_custo->footerCellClass() ?>"><span id="elf_movimento_pla_custo_planilha_custo_idplanilha_custo" class="movimento_pla_custo_planilha_custo_idplanilha_custo">
        </span></td>
    <?php } ?>
    <?php if ($Grid->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <td data-name="modulo_idmodulo" class="<?= $Grid->modulo_idmodulo->footerCellClass() ?>"><span id="elf_movimento_pla_custo_modulo_idmodulo" class="movimento_pla_custo_modulo_idmodulo">
        </span></td>
    <?php } ?>
    <?php if ($Grid->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
        <td data-name="itens_modulo_iditens_modulo" class="<?= $Grid->itens_modulo_iditens_modulo->footerCellClass() ?>"><span id="elf_movimento_pla_custo_itens_modulo_iditens_modulo" class="movimento_pla_custo_itens_modulo_iditens_modulo">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Grid->itens_modulo_iditens_modulo->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->porcentagem->Visible) { // porcentagem ?>
        <td data-name="porcentagem" class="<?= $Grid->porcentagem->footerCellClass() ?>"><span id="elf_movimento_pla_custo_porcentagem" class="movimento_pla_custo_porcentagem">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->porcentagem->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->valor->Visible) { // valor ?>
        <td data-name="valor" class="<?= $Grid->valor->footerCellClass() ?>"><span id="elf_movimento_pla_custo_valor" class="movimento_pla_custo_valor">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->valor->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->obs->Visible) { // obs ?>
        <td data-name="obs" class="<?= $Grid->obs->footerCellClass() ?>"><span id="elf_movimento_pla_custo_obs" class="movimento_pla_custo_obs">
        </span></td>
    <?php } ?>
    <?php if ($Grid->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
        <td data-name="calculo_idcalculo" class="<?= $Grid->calculo_idcalculo->footerCellClass() ?>"><span id="elf_movimento_pla_custo_calculo_idcalculo" class="movimento_pla_custo_calculo_idcalculo">
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
<input type="hidden" name="detailpage" value="fmovimento_pla_custogrid">
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
    ew.addEventHandlers("movimento_pla_custo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
