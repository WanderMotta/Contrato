<?php

namespace PHPMaker2024\contratos;

// Set up and run Grid object
$Grid = Container("PlanilhaCustoContratoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fplanilha_custo_contratogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { planilha_custo_contrato: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplanilha_custo_contratogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["quantidade", [fields.quantidade.visible && fields.quantidade.required ? ew.Validators.required(fields.quantidade.caption) : null, ew.Validators.range(1, 10)], fields.quantidade.isInvalid],
            ["escala_idescala", [fields.escala_idescala.visible && fields.escala_idescala.required ? ew.Validators.required(fields.escala_idescala.caption) : null], fields.escala_idescala.isInvalid],
            ["periodo_idperiodo", [fields.periodo_idperiodo.visible && fields.periodo_idperiodo.required ? ew.Validators.required(fields.periodo_idperiodo.caption) : null], fields.periodo_idperiodo.isInvalid],
            ["tipo_intrajornada_idtipo_intrajornada", [fields.tipo_intrajornada_idtipo_intrajornada.visible && fields.tipo_intrajornada_idtipo_intrajornada.required ? ew.Validators.required(fields.tipo_intrajornada_idtipo_intrajornada.caption) : null], fields.tipo_intrajornada_idtipo_intrajornada.isInvalid],
            ["cargo_idcargo", [fields.cargo_idcargo.visible && fields.cargo_idcargo.required ? ew.Validators.required(fields.cargo_idcargo.caption) : null], fields.cargo_idcargo.isInvalid],
            ["acumulo_funcao", [fields.acumulo_funcao.visible && fields.acumulo_funcao.required ? ew.Validators.required(fields.acumulo_funcao.caption) : null], fields.acumulo_funcao.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["quantidade",false],["escala_idescala",false],["periodo_idperiodo",false],["tipo_intrajornada_idtipo_intrajornada",false],["cargo_idcargo",false],["acumulo_funcao",false]];
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
            "escala_idescala": <?= $Grid->escala_idescala->toClientList($Grid) ?>,
            "periodo_idperiodo": <?= $Grid->periodo_idperiodo->toClientList($Grid) ?>,
            "tipo_intrajornada_idtipo_intrajornada": <?= $Grid->tipo_intrajornada_idtipo_intrajornada->toClientList($Grid) ?>,
            "cargo_idcargo": <?= $Grid->cargo_idcargo->toClientList($Grid) ?>,
            "acumulo_funcao": <?= $Grid->acumulo_funcao->toClientList($Grid) ?>,
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
<div id="fplanilha_custo_contratogrid" class="ew-form ew-list-form">
<div id="gmp_planilha_custo_contrato" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_planilha_custo_contratogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->quantidade->Visible) { // quantidade ?>
        <th data-name="quantidade" class="<?= $Grid->quantidade->headerCellClass() ?>"><div id="elh_planilha_custo_contrato_quantidade" class="planilha_custo_contrato_quantidade"><?= $Grid->renderFieldHeader($Grid->quantidade) ?></div></th>
<?php } ?>
<?php if ($Grid->escala_idescala->Visible) { // escala_idescala ?>
        <th data-name="escala_idescala" class="<?= $Grid->escala_idescala->headerCellClass() ?>"><div id="elh_planilha_custo_contrato_escala_idescala" class="planilha_custo_contrato_escala_idescala"><?= $Grid->renderFieldHeader($Grid->escala_idescala) ?></div></th>
<?php } ?>
<?php if ($Grid->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <th data-name="periodo_idperiodo" class="<?= $Grid->periodo_idperiodo->headerCellClass() ?>"><div id="elh_planilha_custo_contrato_periodo_idperiodo" class="planilha_custo_contrato_periodo_idperiodo"><?= $Grid->renderFieldHeader($Grid->periodo_idperiodo) ?></div></th>
<?php } ?>
<?php if ($Grid->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <th data-name="tipo_intrajornada_idtipo_intrajornada" class="<?= $Grid->tipo_intrajornada_idtipo_intrajornada->headerCellClass() ?>"><div id="elh_planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada" class="planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada"><?= $Grid->renderFieldHeader($Grid->tipo_intrajornada_idtipo_intrajornada) ?></div></th>
<?php } ?>
<?php if ($Grid->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <th data-name="cargo_idcargo" class="<?= $Grid->cargo_idcargo->headerCellClass() ?>"><div id="elh_planilha_custo_contrato_cargo_idcargo" class="planilha_custo_contrato_cargo_idcargo"><?= $Grid->renderFieldHeader($Grid->cargo_idcargo) ?></div></th>
<?php } ?>
<?php if ($Grid->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <th data-name="acumulo_funcao" class="<?= $Grid->acumulo_funcao->headerCellClass() ?>"><div id="elh_planilha_custo_contrato_acumulo_funcao" class="planilha_custo_contrato_acumulo_funcao"><?= $Grid->renderFieldHeader($Grid->acumulo_funcao) ?></div></th>
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
    <?php if ($Grid->quantidade->Visible) { // quantidade ?>
        <td data-name="quantidade"<?= $Grid->quantidade->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_quantidade" class="el_planilha_custo_contrato_quantidade">
<input type="<?= $Grid->quantidade->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_quantidade" id="x<?= $Grid->RowIndex ?>_quantidade" data-table="planilha_custo_contrato" data-field="x_quantidade" value="<?= $Grid->quantidade->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Grid->quantidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->quantidade->formatPattern()) ?>"<?= $Grid->quantidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->quantidade->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_quantidade" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_quantidade" id="o<?= $Grid->RowIndex ?>_quantidade" value="<?= HtmlEncode($Grid->quantidade->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_quantidade" class="el_planilha_custo_contrato_quantidade">
<input type="<?= $Grid->quantidade->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_quantidade" id="x<?= $Grid->RowIndex ?>_quantidade" data-table="planilha_custo_contrato" data-field="x_quantidade" value="<?= $Grid->quantidade->EditValue ?>" size="5" placeholder="<?= HtmlEncode($Grid->quantidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->quantidade->formatPattern()) ?>"<?= $Grid->quantidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->quantidade->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_quantidade" class="el_planilha_custo_contrato_quantidade">
<span<?= $Grid->quantidade->viewAttributes() ?>>
<?= $Grid->quantidade->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_quantidade" data-hidden="1" name="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_quantidade" id="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_quantidade" value="<?= HtmlEncode($Grid->quantidade->FormValue) ?>">
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_quantidade" data-hidden="1" data-old name="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_quantidade" id="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_quantidade" value="<?= HtmlEncode($Grid->quantidade->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->escala_idescala->Visible) { // escala_idescala ?>
        <td data-name="escala_idescala"<?= $Grid->escala_idescala->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_escala_idescala" class="el_planilha_custo_contrato_escala_idescala">
<template id="tp_x<?= $Grid->RowIndex ?>_escala_idescala">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_escala_idescala" name="x<?= $Grid->RowIndex ?>_escala_idescala" id="x<?= $Grid->RowIndex ?>_escala_idescala"<?= $Grid->escala_idescala->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_escala_idescala" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_escala_idescala"
    name="x<?= $Grid->RowIndex ?>_escala_idescala"
    value="<?= HtmlEncode($Grid->escala_idescala->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_escala_idescala"
    data-target="dsl_x<?= $Grid->RowIndex ?>_escala_idescala"
    data-repeatcolumn="10"
    class="form-control<?= $Grid->escala_idescala->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_escala_idescala"
    data-value-separator="<?= $Grid->escala_idescala->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Grid->escala_idescala->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->escala_idescala->getErrorMessage() ?></div>
<?= $Grid->escala_idescala->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_escala_idescala") ?>
</span>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_escala_idescala" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_escala_idescala" id="o<?= $Grid->RowIndex ?>_escala_idescala" value="<?= HtmlEncode($Grid->escala_idescala->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_escala_idescala" class="el_planilha_custo_contrato_escala_idescala">
<template id="tp_x<?= $Grid->RowIndex ?>_escala_idescala">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_escala_idescala" name="x<?= $Grid->RowIndex ?>_escala_idescala" id="x<?= $Grid->RowIndex ?>_escala_idescala"<?= $Grid->escala_idescala->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_escala_idescala" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_escala_idescala"
    name="x<?= $Grid->RowIndex ?>_escala_idescala"
    value="<?= HtmlEncode($Grid->escala_idescala->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_escala_idescala"
    data-target="dsl_x<?= $Grid->RowIndex ?>_escala_idescala"
    data-repeatcolumn="10"
    class="form-control<?= $Grid->escala_idescala->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_escala_idescala"
    data-value-separator="<?= $Grid->escala_idescala->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Grid->escala_idescala->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->escala_idescala->getErrorMessage() ?></div>
<?= $Grid->escala_idescala->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_escala_idescala") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_escala_idescala" class="el_planilha_custo_contrato_escala_idescala">
<span<?= $Grid->escala_idescala->viewAttributes() ?>>
<?= $Grid->escala_idescala->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_escala_idescala" data-hidden="1" name="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_escala_idescala" id="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_escala_idescala" value="<?= HtmlEncode($Grid->escala_idescala->FormValue) ?>">
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_escala_idescala" data-hidden="1" data-old name="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_escala_idescala" id="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_escala_idescala" value="<?= HtmlEncode($Grid->escala_idescala->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <td data-name="periodo_idperiodo"<?= $Grid->periodo_idperiodo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_periodo_idperiodo" class="el_planilha_custo_contrato_periodo_idperiodo">
<template id="tp_x<?= $Grid->RowIndex ?>_periodo_idperiodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_periodo_idperiodo" name="x<?= $Grid->RowIndex ?>_periodo_idperiodo" id="x<?= $Grid->RowIndex ?>_periodo_idperiodo"<?= $Grid->periodo_idperiodo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_periodo_idperiodo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_periodo_idperiodo"
    name="x<?= $Grid->RowIndex ?>_periodo_idperiodo"
    value="<?= HtmlEncode($Grid->periodo_idperiodo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_periodo_idperiodo"
    data-target="dsl_x<?= $Grid->RowIndex ?>_periodo_idperiodo"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->periodo_idperiodo->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_periodo_idperiodo"
    data-value-separator="<?= $Grid->periodo_idperiodo->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Grid->periodo_idperiodo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->periodo_idperiodo->getErrorMessage() ?></div>
<?= $Grid->periodo_idperiodo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_periodo_idperiodo") ?>
</span>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_periodo_idperiodo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_periodo_idperiodo" id="o<?= $Grid->RowIndex ?>_periodo_idperiodo" value="<?= HtmlEncode($Grid->periodo_idperiodo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_periodo_idperiodo" class="el_planilha_custo_contrato_periodo_idperiodo">
<template id="tp_x<?= $Grid->RowIndex ?>_periodo_idperiodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_periodo_idperiodo" name="x<?= $Grid->RowIndex ?>_periodo_idperiodo" id="x<?= $Grid->RowIndex ?>_periodo_idperiodo"<?= $Grid->periodo_idperiodo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_periodo_idperiodo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_periodo_idperiodo"
    name="x<?= $Grid->RowIndex ?>_periodo_idperiodo"
    value="<?= HtmlEncode($Grid->periodo_idperiodo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_periodo_idperiodo"
    data-target="dsl_x<?= $Grid->RowIndex ?>_periodo_idperiodo"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->periodo_idperiodo->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_periodo_idperiodo"
    data-value-separator="<?= $Grid->periodo_idperiodo->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Grid->periodo_idperiodo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->periodo_idperiodo->getErrorMessage() ?></div>
<?= $Grid->periodo_idperiodo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_periodo_idperiodo") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_periodo_idperiodo" class="el_planilha_custo_contrato_periodo_idperiodo">
<span<?= $Grid->periodo_idperiodo->viewAttributes() ?>>
<?= $Grid->periodo_idperiodo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_periodo_idperiodo" data-hidden="1" name="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_periodo_idperiodo" id="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_periodo_idperiodo" value="<?= HtmlEncode($Grid->periodo_idperiodo->FormValue) ?>">
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_periodo_idperiodo" data-hidden="1" data-old name="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_periodo_idperiodo" id="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_periodo_idperiodo" value="<?= HtmlEncode($Grid->periodo_idperiodo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <td data-name="tipo_intrajornada_idtipo_intrajornada"<?= $Grid->tipo_intrajornada_idtipo_intrajornada->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada" class="el_planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada">
<template id="tp_x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_tipo_intrajornada_idtipo_intrajornada" name="x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada" id="x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada"<?= $Grid->tipo_intrajornada_idtipo_intrajornada->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada"
    name="x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada"
    value="<?= HtmlEncode($Grid->tipo_intrajornada_idtipo_intrajornada->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada"
    data-target="dsl_x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->tipo_intrajornada_idtipo_intrajornada->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_tipo_intrajornada_idtipo_intrajornada"
    data-value-separator="<?= $Grid->tipo_intrajornada_idtipo_intrajornada->displayValueSeparatorAttribute() ?>"
    <?= $Grid->tipo_intrajornada_idtipo_intrajornada->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->tipo_intrajornada_idtipo_intrajornada->getErrorMessage() ?></div>
<?= $Grid->tipo_intrajornada_idtipo_intrajornada->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo_intrajornada_idtipo_intrajornada") ?>
</span>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_tipo_intrajornada_idtipo_intrajornada" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada" id="o<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada" value="<?= HtmlEncode($Grid->tipo_intrajornada_idtipo_intrajornada->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada" class="el_planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada">
<template id="tp_x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_tipo_intrajornada_idtipo_intrajornada" name="x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada" id="x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada"<?= $Grid->tipo_intrajornada_idtipo_intrajornada->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada"
    name="x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada"
    value="<?= HtmlEncode($Grid->tipo_intrajornada_idtipo_intrajornada->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada"
    data-target="dsl_x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->tipo_intrajornada_idtipo_intrajornada->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_tipo_intrajornada_idtipo_intrajornada"
    data-value-separator="<?= $Grid->tipo_intrajornada_idtipo_intrajornada->displayValueSeparatorAttribute() ?>"
    <?= $Grid->tipo_intrajornada_idtipo_intrajornada->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->tipo_intrajornada_idtipo_intrajornada->getErrorMessage() ?></div>
<?= $Grid->tipo_intrajornada_idtipo_intrajornada->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo_intrajornada_idtipo_intrajornada") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada" class="el_planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada">
<span<?= $Grid->tipo_intrajornada_idtipo_intrajornada->viewAttributes() ?>>
<?= $Grid->tipo_intrajornada_idtipo_intrajornada->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_tipo_intrajornada_idtipo_intrajornada" data-hidden="1" name="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada" id="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada" value="<?= HtmlEncode($Grid->tipo_intrajornada_idtipo_intrajornada->FormValue) ?>">
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_tipo_intrajornada_idtipo_intrajornada" data-hidden="1" data-old name="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada" id="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_tipo_intrajornada_idtipo_intrajornada" value="<?= HtmlEncode($Grid->tipo_intrajornada_idtipo_intrajornada->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <td data-name="cargo_idcargo"<?= $Grid->cargo_idcargo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_cargo_idcargo" class="el_planilha_custo_contrato_cargo_idcargo">
    <select
        id="x<?= $Grid->RowIndex ?>_cargo_idcargo"
        name="x<?= $Grid->RowIndex ?>_cargo_idcargo"
        class="form-control ew-select<?= $Grid->cargo_idcargo->isInvalidClass() ?>"
        data-select2-id="fplanilha_custo_contratogrid_x<?= $Grid->RowIndex ?>_cargo_idcargo"
        data-table="planilha_custo_contrato"
        data-field="x_cargo_idcargo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->cargo_idcargo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->cargo_idcargo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cargo_idcargo->getPlaceHolder()) ?>"
        <?= $Grid->cargo_idcargo->editAttributes() ?>>
        <?= $Grid->cargo_idcargo->selectOptionListHtml("x{$Grid->RowIndex}_cargo_idcargo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cargo_idcargo->getErrorMessage() ?></div>
<?= $Grid->cargo_idcargo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cargo_idcargo") ?>
<script>
loadjs.ready("fplanilha_custo_contratogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cargo_idcargo", selectId: "fplanilha_custo_contratogrid_x<?= $Grid->RowIndex ?>_cargo_idcargo" };
    if (fplanilha_custo_contratogrid.lists.cargo_idcargo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cargo_idcargo", form: "fplanilha_custo_contratogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cargo_idcargo", form: "fplanilha_custo_contratogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.planilha_custo_contrato.fields.cargo_idcargo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_cargo_idcargo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cargo_idcargo" id="o<?= $Grid->RowIndex ?>_cargo_idcargo" value="<?= HtmlEncode($Grid->cargo_idcargo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_cargo_idcargo" class="el_planilha_custo_contrato_cargo_idcargo">
    <select
        id="x<?= $Grid->RowIndex ?>_cargo_idcargo"
        name="x<?= $Grid->RowIndex ?>_cargo_idcargo"
        class="form-control ew-select<?= $Grid->cargo_idcargo->isInvalidClass() ?>"
        data-select2-id="fplanilha_custo_contratogrid_x<?= $Grid->RowIndex ?>_cargo_idcargo"
        data-table="planilha_custo_contrato"
        data-field="x_cargo_idcargo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->cargo_idcargo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->cargo_idcargo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cargo_idcargo->getPlaceHolder()) ?>"
        <?= $Grid->cargo_idcargo->editAttributes() ?>>
        <?= $Grid->cargo_idcargo->selectOptionListHtml("x{$Grid->RowIndex}_cargo_idcargo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cargo_idcargo->getErrorMessage() ?></div>
<?= $Grid->cargo_idcargo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cargo_idcargo") ?>
<script>
loadjs.ready("fplanilha_custo_contratogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cargo_idcargo", selectId: "fplanilha_custo_contratogrid_x<?= $Grid->RowIndex ?>_cargo_idcargo" };
    if (fplanilha_custo_contratogrid.lists.cargo_idcargo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cargo_idcargo", form: "fplanilha_custo_contratogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cargo_idcargo", form: "fplanilha_custo_contratogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.planilha_custo_contrato.fields.cargo_idcargo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_cargo_idcargo" class="el_planilha_custo_contrato_cargo_idcargo">
<span<?= $Grid->cargo_idcargo->viewAttributes() ?>>
<?= $Grid->cargo_idcargo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_cargo_idcargo" data-hidden="1" name="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_cargo_idcargo" id="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_cargo_idcargo" value="<?= HtmlEncode($Grid->cargo_idcargo->FormValue) ?>">
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_cargo_idcargo" data-hidden="1" data-old name="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_cargo_idcargo" id="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_cargo_idcargo" value="<?= HtmlEncode($Grid->cargo_idcargo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <td data-name="acumulo_funcao"<?= $Grid->acumulo_funcao->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_acumulo_funcao" class="el_planilha_custo_contrato_acumulo_funcao">
<template id="tp_x<?= $Grid->RowIndex ?>_acumulo_funcao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_acumulo_funcao" name="x<?= $Grid->RowIndex ?>_acumulo_funcao" id="x<?= $Grid->RowIndex ?>_acumulo_funcao"<?= $Grid->acumulo_funcao->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_acumulo_funcao" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_acumulo_funcao"
    name="x<?= $Grid->RowIndex ?>_acumulo_funcao"
    value="<?= HtmlEncode($Grid->acumulo_funcao->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_acumulo_funcao"
    data-target="dsl_x<?= $Grid->RowIndex ?>_acumulo_funcao"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->acumulo_funcao->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_acumulo_funcao"
    data-value-separator="<?= $Grid->acumulo_funcao->displayValueSeparatorAttribute() ?>"
    <?= $Grid->acumulo_funcao->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->acumulo_funcao->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_acumulo_funcao" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_acumulo_funcao" id="o<?= $Grid->RowIndex ?>_acumulo_funcao" value="<?= HtmlEncode($Grid->acumulo_funcao->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_acumulo_funcao" class="el_planilha_custo_contrato_acumulo_funcao">
<template id="tp_x<?= $Grid->RowIndex ?>_acumulo_funcao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="planilha_custo_contrato" data-field="x_acumulo_funcao" name="x<?= $Grid->RowIndex ?>_acumulo_funcao" id="x<?= $Grid->RowIndex ?>_acumulo_funcao"<?= $Grid->acumulo_funcao->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_acumulo_funcao" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_acumulo_funcao"
    name="x<?= $Grid->RowIndex ?>_acumulo_funcao"
    value="<?= HtmlEncode($Grid->acumulo_funcao->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_acumulo_funcao"
    data-target="dsl_x<?= $Grid->RowIndex ?>_acumulo_funcao"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->acumulo_funcao->isInvalidClass() ?>"
    data-table="planilha_custo_contrato"
    data-field="x_acumulo_funcao"
    data-value-separator="<?= $Grid->acumulo_funcao->displayValueSeparatorAttribute() ?>"
    <?= $Grid->acumulo_funcao->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->acumulo_funcao->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_planilha_custo_contrato_acumulo_funcao" class="el_planilha_custo_contrato_acumulo_funcao">
<span<?= $Grid->acumulo_funcao->viewAttributes() ?>>
<?= $Grid->acumulo_funcao->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_acumulo_funcao" data-hidden="1" name="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_acumulo_funcao" id="fplanilha_custo_contratogrid$x<?= $Grid->RowIndex ?>_acumulo_funcao" value="<?= HtmlEncode($Grid->acumulo_funcao->FormValue) ?>">
<input type="hidden" data-table="planilha_custo_contrato" data-field="x_acumulo_funcao" data-hidden="1" data-old name="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_acumulo_funcao" id="fplanilha_custo_contratogrid$o<?= $Grid->RowIndex ?>_acumulo_funcao" value="<?= HtmlEncode($Grid->acumulo_funcao->OldValue) ?>">
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
loadjs.ready(["fplanilha_custo_contratogrid","load"], () => fplanilha_custo_contratogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
    <?php if ($Grid->quantidade->Visible) { // quantidade ?>
        <td data-name="quantidade" class="<?= $Grid->quantidade->footerCellClass() ?>"><span id="elf_planilha_custo_contrato_quantidade" class="planilha_custo_contrato_quantidade">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->quantidade->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->escala_idescala->Visible) { // escala_idescala ?>
        <td data-name="escala_idescala" class="<?= $Grid->escala_idescala->footerCellClass() ?>"><span id="elf_planilha_custo_contrato_escala_idescala" class="planilha_custo_contrato_escala_idescala">
        </span></td>
    <?php } ?>
    <?php if ($Grid->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <td data-name="periodo_idperiodo" class="<?= $Grid->periodo_idperiodo->footerCellClass() ?>"><span id="elf_planilha_custo_contrato_periodo_idperiodo" class="planilha_custo_contrato_periodo_idperiodo">
        </span></td>
    <?php } ?>
    <?php if ($Grid->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <td data-name="tipo_intrajornada_idtipo_intrajornada" class="<?= $Grid->tipo_intrajornada_idtipo_intrajornada->footerCellClass() ?>"><span id="elf_planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada" class="planilha_custo_contrato_tipo_intrajornada_idtipo_intrajornada">
        </span></td>
    <?php } ?>
    <?php if ($Grid->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <td data-name="cargo_idcargo" class="<?= $Grid->cargo_idcargo->footerCellClass() ?>"><span id="elf_planilha_custo_contrato_cargo_idcargo" class="planilha_custo_contrato_cargo_idcargo">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Grid->cargo_idcargo->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <td data-name="acumulo_funcao" class="<?= $Grid->acumulo_funcao->footerCellClass() ?>"><span id="elf_planilha_custo_contrato_acumulo_funcao" class="planilha_custo_contrato_acumulo_funcao">
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
<input type="hidden" name="detailpage" value="fplanilha_custo_contratogrid">
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
    ew.addEventHandlers("planilha_custo_contrato");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
