<?php

namespace PHPMaker2024\contratos;

// Set up and run Grid object
$Grid = Container("FaturamentoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ffaturamentogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { faturamento: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffaturamentogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["faturamento", [fields.faturamento.visible && fields.faturamento.required ? ew.Validators.required(fields.faturamento.caption) : null], fields.faturamento.isInvalid],
            ["cnpj", [fields.cnpj.visible && fields.cnpj.required ? ew.Validators.required(fields.cnpj.caption) : null], fields.cnpj.isInvalid],
            ["endereco", [fields.endereco.visible && fields.endereco.required ? ew.Validators.required(fields.endereco.caption) : null], fields.endereco.isInvalid],
            ["bairro", [fields.bairro.visible && fields.bairro.required ? ew.Validators.required(fields.bairro.caption) : null], fields.bairro.isInvalid],
            ["cidade", [fields.cidade.visible && fields.cidade.required ? ew.Validators.required(fields.cidade.caption) : null], fields.cidade.isInvalid],
            ["uf", [fields.uf.visible && fields.uf.required ? ew.Validators.required(fields.uf.caption) : null], fields.uf.isInvalid],
            ["dia_vencimento", [fields.dia_vencimento.visible && fields.dia_vencimento.required ? ew.Validators.required(fields.dia_vencimento.caption) : null, ew.Validators.range(1, 30)], fields.dia_vencimento.isInvalid],
            ["origem", [fields.origem.visible && fields.origem.required ? ew.Validators.required(fields.origem.caption) : null], fields.origem.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["faturamento",false],["cnpj",false],["endereco",false],["bairro",false],["cidade",false],["uf",false],["dia_vencimento",false],["origem",false]];
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
            "origem": <?= $Grid->origem->toClientList($Grid) ?>,
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
<div id="ffaturamentogrid" class="ew-form ew-list-form">
<div id="gmp_faturamento" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_faturamentogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->faturamento->Visible) { // faturamento ?>
        <th data-name="faturamento" class="<?= $Grid->faturamento->headerCellClass() ?>"><div id="elh_faturamento_faturamento" class="faturamento_faturamento"><?= $Grid->renderFieldHeader($Grid->faturamento) ?></div></th>
<?php } ?>
<?php if ($Grid->cnpj->Visible) { // cnpj ?>
        <th data-name="cnpj" class="<?= $Grid->cnpj->headerCellClass() ?>"><div id="elh_faturamento_cnpj" class="faturamento_cnpj"><?= $Grid->renderFieldHeader($Grid->cnpj) ?></div></th>
<?php } ?>
<?php if ($Grid->endereco->Visible) { // endereco ?>
        <th data-name="endereco" class="<?= $Grid->endereco->headerCellClass() ?>"><div id="elh_faturamento_endereco" class="faturamento_endereco"><?= $Grid->renderFieldHeader($Grid->endereco) ?></div></th>
<?php } ?>
<?php if ($Grid->bairro->Visible) { // bairro ?>
        <th data-name="bairro" class="<?= $Grid->bairro->headerCellClass() ?>"><div id="elh_faturamento_bairro" class="faturamento_bairro"><?= $Grid->renderFieldHeader($Grid->bairro) ?></div></th>
<?php } ?>
<?php if ($Grid->cidade->Visible) { // cidade ?>
        <th data-name="cidade" class="<?= $Grid->cidade->headerCellClass() ?>"><div id="elh_faturamento_cidade" class="faturamento_cidade"><?= $Grid->renderFieldHeader($Grid->cidade) ?></div></th>
<?php } ?>
<?php if ($Grid->uf->Visible) { // uf ?>
        <th data-name="uf" class="<?= $Grid->uf->headerCellClass() ?>"><div id="elh_faturamento_uf" class="faturamento_uf"><?= $Grid->renderFieldHeader($Grid->uf) ?></div></th>
<?php } ?>
<?php if ($Grid->dia_vencimento->Visible) { // dia_vencimento ?>
        <th data-name="dia_vencimento" class="<?= $Grid->dia_vencimento->headerCellClass() ?>"><div id="elh_faturamento_dia_vencimento" class="faturamento_dia_vencimento"><?= $Grid->renderFieldHeader($Grid->dia_vencimento) ?></div></th>
<?php } ?>
<?php if ($Grid->origem->Visible) { // origem ?>
        <th data-name="origem" class="<?= $Grid->origem->headerCellClass() ?>"><div id="elh_faturamento_origem" class="faturamento_origem"><?= $Grid->renderFieldHeader($Grid->origem) ?></div></th>
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
    <?php if ($Grid->faturamento->Visible) { // faturamento ?>
        <td data-name="faturamento"<?= $Grid->faturamento->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_faturamento" class="el_faturamento_faturamento">
<input type="<?= $Grid->faturamento->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_faturamento" id="x<?= $Grid->RowIndex ?>_faturamento" data-table="faturamento" data-field="x_faturamento" value="<?= $Grid->faturamento->EditValue ?>" size="50" maxlength="150" placeholder="<?= HtmlEncode($Grid->faturamento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->faturamento->formatPattern()) ?>"<?= $Grid->faturamento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->faturamento->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="faturamento" data-field="x_faturamento" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_faturamento" id="o<?= $Grid->RowIndex ?>_faturamento" value="<?= HtmlEncode($Grid->faturamento->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_faturamento" class="el_faturamento_faturamento">
<input type="<?= $Grid->faturamento->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_faturamento" id="x<?= $Grid->RowIndex ?>_faturamento" data-table="faturamento" data-field="x_faturamento" value="<?= $Grid->faturamento->EditValue ?>" size="50" maxlength="150" placeholder="<?= HtmlEncode($Grid->faturamento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->faturamento->formatPattern()) ?>"<?= $Grid->faturamento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->faturamento->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_faturamento" class="el_faturamento_faturamento">
<span<?= $Grid->faturamento->viewAttributes() ?>>
<?= $Grid->faturamento->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="faturamento" data-field="x_faturamento" data-hidden="1" name="ffaturamentogrid$x<?= $Grid->RowIndex ?>_faturamento" id="ffaturamentogrid$x<?= $Grid->RowIndex ?>_faturamento" value="<?= HtmlEncode($Grid->faturamento->FormValue) ?>">
<input type="hidden" data-table="faturamento" data-field="x_faturamento" data-hidden="1" data-old name="ffaturamentogrid$o<?= $Grid->RowIndex ?>_faturamento" id="ffaturamentogrid$o<?= $Grid->RowIndex ?>_faturamento" value="<?= HtmlEncode($Grid->faturamento->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cnpj->Visible) { // cnpj ?>
        <td data-name="cnpj"<?= $Grid->cnpj->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_cnpj" class="el_faturamento_cnpj">
<input type="<?= $Grid->cnpj->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cnpj" id="x<?= $Grid->RowIndex ?>_cnpj" data-table="faturamento" data-field="x_cnpj" value="<?= $Grid->cnpj->EditValue ?>" size="18" maxlength="18" placeholder="<?= HtmlEncode($Grid->cnpj->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cnpj->formatPattern()) ?>"<?= $Grid->cnpj->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cnpj->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="faturamento" data-field="x_cnpj" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cnpj" id="o<?= $Grid->RowIndex ?>_cnpj" value="<?= HtmlEncode($Grid->cnpj->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_cnpj" class="el_faturamento_cnpj">
<input type="<?= $Grid->cnpj->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cnpj" id="x<?= $Grid->RowIndex ?>_cnpj" data-table="faturamento" data-field="x_cnpj" value="<?= $Grid->cnpj->EditValue ?>" size="18" maxlength="18" placeholder="<?= HtmlEncode($Grid->cnpj->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cnpj->formatPattern()) ?>"<?= $Grid->cnpj->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cnpj->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_cnpj" class="el_faturamento_cnpj">
<span<?= $Grid->cnpj->viewAttributes() ?>>
<?= $Grid->cnpj->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="faturamento" data-field="x_cnpj" data-hidden="1" name="ffaturamentogrid$x<?= $Grid->RowIndex ?>_cnpj" id="ffaturamentogrid$x<?= $Grid->RowIndex ?>_cnpj" value="<?= HtmlEncode($Grid->cnpj->FormValue) ?>">
<input type="hidden" data-table="faturamento" data-field="x_cnpj" data-hidden="1" data-old name="ffaturamentogrid$o<?= $Grid->RowIndex ?>_cnpj" id="ffaturamentogrid$o<?= $Grid->RowIndex ?>_cnpj" value="<?= HtmlEncode($Grid->cnpj->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->endereco->Visible) { // endereco ?>
        <td data-name="endereco"<?= $Grid->endereco->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_endereco" class="el_faturamento_endereco">
<input type="<?= $Grid->endereco->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_endereco" id="x<?= $Grid->RowIndex ?>_endereco" data-table="faturamento" data-field="x_endereco" value="<?= $Grid->endereco->EditValue ?>" size="50" maxlength="150" placeholder="<?= HtmlEncode($Grid->endereco->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->endereco->formatPattern()) ?>"<?= $Grid->endereco->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->endereco->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="faturamento" data-field="x_endereco" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_endereco" id="o<?= $Grid->RowIndex ?>_endereco" value="<?= HtmlEncode($Grid->endereco->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_endereco" class="el_faturamento_endereco">
<input type="<?= $Grid->endereco->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_endereco" id="x<?= $Grid->RowIndex ?>_endereco" data-table="faturamento" data-field="x_endereco" value="<?= $Grid->endereco->EditValue ?>" size="50" maxlength="150" placeholder="<?= HtmlEncode($Grid->endereco->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->endereco->formatPattern()) ?>"<?= $Grid->endereco->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->endereco->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_endereco" class="el_faturamento_endereco">
<span<?= $Grid->endereco->viewAttributes() ?>>
<?= $Grid->endereco->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="faturamento" data-field="x_endereco" data-hidden="1" name="ffaturamentogrid$x<?= $Grid->RowIndex ?>_endereco" id="ffaturamentogrid$x<?= $Grid->RowIndex ?>_endereco" value="<?= HtmlEncode($Grid->endereco->FormValue) ?>">
<input type="hidden" data-table="faturamento" data-field="x_endereco" data-hidden="1" data-old name="ffaturamentogrid$o<?= $Grid->RowIndex ?>_endereco" id="ffaturamentogrid$o<?= $Grid->RowIndex ?>_endereco" value="<?= HtmlEncode($Grid->endereco->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bairro->Visible) { // bairro ?>
        <td data-name="bairro"<?= $Grid->bairro->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_bairro" class="el_faturamento_bairro">
<input type="<?= $Grid->bairro->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_bairro" id="x<?= $Grid->RowIndex ?>_bairro" data-table="faturamento" data-field="x_bairro" value="<?= $Grid->bairro->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->bairro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->bairro->formatPattern()) ?>"<?= $Grid->bairro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bairro->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="faturamento" data-field="x_bairro" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_bairro" id="o<?= $Grid->RowIndex ?>_bairro" value="<?= HtmlEncode($Grid->bairro->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_bairro" class="el_faturamento_bairro">
<input type="<?= $Grid->bairro->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_bairro" id="x<?= $Grid->RowIndex ?>_bairro" data-table="faturamento" data-field="x_bairro" value="<?= $Grid->bairro->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->bairro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->bairro->formatPattern()) ?>"<?= $Grid->bairro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bairro->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_bairro" class="el_faturamento_bairro">
<span<?= $Grid->bairro->viewAttributes() ?>>
<?= $Grid->bairro->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="faturamento" data-field="x_bairro" data-hidden="1" name="ffaturamentogrid$x<?= $Grid->RowIndex ?>_bairro" id="ffaturamentogrid$x<?= $Grid->RowIndex ?>_bairro" value="<?= HtmlEncode($Grid->bairro->FormValue) ?>">
<input type="hidden" data-table="faturamento" data-field="x_bairro" data-hidden="1" data-old name="ffaturamentogrid$o<?= $Grid->RowIndex ?>_bairro" id="ffaturamentogrid$o<?= $Grid->RowIndex ?>_bairro" value="<?= HtmlEncode($Grid->bairro->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cidade->Visible) { // cidade ?>
        <td data-name="cidade"<?= $Grid->cidade->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_cidade" class="el_faturamento_cidade">
<input type="<?= $Grid->cidade->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cidade" id="x<?= $Grid->RowIndex ?>_cidade" data-table="faturamento" data-field="x_cidade" value="<?= $Grid->cidade->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->cidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cidade->formatPattern()) ?>"<?= $Grid->cidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cidade->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="faturamento" data-field="x_cidade" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cidade" id="o<?= $Grid->RowIndex ?>_cidade" value="<?= HtmlEncode($Grid->cidade->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_cidade" class="el_faturamento_cidade">
<input type="<?= $Grid->cidade->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cidade" id="x<?= $Grid->RowIndex ?>_cidade" data-table="faturamento" data-field="x_cidade" value="<?= $Grid->cidade->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->cidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cidade->formatPattern()) ?>"<?= $Grid->cidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cidade->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_cidade" class="el_faturamento_cidade">
<span<?= $Grid->cidade->viewAttributes() ?>>
<?= $Grid->cidade->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="faturamento" data-field="x_cidade" data-hidden="1" name="ffaturamentogrid$x<?= $Grid->RowIndex ?>_cidade" id="ffaturamentogrid$x<?= $Grid->RowIndex ?>_cidade" value="<?= HtmlEncode($Grid->cidade->FormValue) ?>">
<input type="hidden" data-table="faturamento" data-field="x_cidade" data-hidden="1" data-old name="ffaturamentogrid$o<?= $Grid->RowIndex ?>_cidade" id="ffaturamentogrid$o<?= $Grid->RowIndex ?>_cidade" value="<?= HtmlEncode($Grid->cidade->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->uf->Visible) { // uf ?>
        <td data-name="uf"<?= $Grid->uf->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_uf" class="el_faturamento_uf">
<input type="<?= $Grid->uf->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_uf" id="x<?= $Grid->RowIndex ?>_uf" data-table="faturamento" data-field="x_uf" value="<?= $Grid->uf->EditValue ?>" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->uf->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->uf->formatPattern()) ?>"<?= $Grid->uf->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->uf->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="faturamento" data-field="x_uf" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_uf" id="o<?= $Grid->RowIndex ?>_uf" value="<?= HtmlEncode($Grid->uf->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_uf" class="el_faturamento_uf">
<input type="<?= $Grid->uf->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_uf" id="x<?= $Grid->RowIndex ?>_uf" data-table="faturamento" data-field="x_uf" value="<?= $Grid->uf->EditValue ?>" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->uf->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->uf->formatPattern()) ?>"<?= $Grid->uf->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->uf->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_uf" class="el_faturamento_uf">
<span<?= $Grid->uf->viewAttributes() ?>>
<?= $Grid->uf->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="faturamento" data-field="x_uf" data-hidden="1" name="ffaturamentogrid$x<?= $Grid->RowIndex ?>_uf" id="ffaturamentogrid$x<?= $Grid->RowIndex ?>_uf" value="<?= HtmlEncode($Grid->uf->FormValue) ?>">
<input type="hidden" data-table="faturamento" data-field="x_uf" data-hidden="1" data-old name="ffaturamentogrid$o<?= $Grid->RowIndex ?>_uf" id="ffaturamentogrid$o<?= $Grid->RowIndex ?>_uf" value="<?= HtmlEncode($Grid->uf->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dia_vencimento->Visible) { // dia_vencimento ?>
        <td data-name="dia_vencimento"<?= $Grid->dia_vencimento->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_dia_vencimento" class="el_faturamento_dia_vencimento">
<input type="<?= $Grid->dia_vencimento->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dia_vencimento" id="x<?= $Grid->RowIndex ?>_dia_vencimento" data-table="faturamento" data-field="x_dia_vencimento" value="<?= $Grid->dia_vencimento->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Grid->dia_vencimento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->dia_vencimento->formatPattern()) ?>"<?= $Grid->dia_vencimento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dia_vencimento->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="faturamento" data-field="x_dia_vencimento" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_dia_vencimento" id="o<?= $Grid->RowIndex ?>_dia_vencimento" value="<?= HtmlEncode($Grid->dia_vencimento->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_dia_vencimento" class="el_faturamento_dia_vencimento">
<input type="<?= $Grid->dia_vencimento->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dia_vencimento" id="x<?= $Grid->RowIndex ?>_dia_vencimento" data-table="faturamento" data-field="x_dia_vencimento" value="<?= $Grid->dia_vencimento->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Grid->dia_vencimento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->dia_vencimento->formatPattern()) ?>"<?= $Grid->dia_vencimento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dia_vencimento->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_dia_vencimento" class="el_faturamento_dia_vencimento">
<span<?= $Grid->dia_vencimento->viewAttributes() ?>>
<?= $Grid->dia_vencimento->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="faturamento" data-field="x_dia_vencimento" data-hidden="1" name="ffaturamentogrid$x<?= $Grid->RowIndex ?>_dia_vencimento" id="ffaturamentogrid$x<?= $Grid->RowIndex ?>_dia_vencimento" value="<?= HtmlEncode($Grid->dia_vencimento->FormValue) ?>">
<input type="hidden" data-table="faturamento" data-field="x_dia_vencimento" data-hidden="1" data-old name="ffaturamentogrid$o<?= $Grid->RowIndex ?>_dia_vencimento" id="ffaturamentogrid$o<?= $Grid->RowIndex ?>_dia_vencimento" value="<?= HtmlEncode($Grid->dia_vencimento->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->origem->Visible) { // origem ?>
        <td data-name="origem"<?= $Grid->origem->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_origem" class="el_faturamento_origem">
<template id="tp_x<?= $Grid->RowIndex ?>_origem">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="faturamento" data-field="x_origem" name="x<?= $Grid->RowIndex ?>_origem" id="x<?= $Grid->RowIndex ?>_origem"<?= $Grid->origem->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_origem" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_origem"
    name="x<?= $Grid->RowIndex ?>_origem"
    value="<?= HtmlEncode($Grid->origem->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_origem"
    data-target="dsl_x<?= $Grid->RowIndex ?>_origem"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->origem->isInvalidClass() ?>"
    data-table="faturamento"
    data-field="x_origem"
    data-value-separator="<?= $Grid->origem->displayValueSeparatorAttribute() ?>"
    <?= $Grid->origem->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->origem->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="faturamento" data-field="x_origem" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_origem" id="o<?= $Grid->RowIndex ?>_origem" value="<?= HtmlEncode($Grid->origem->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_origem" class="el_faturamento_origem">
<template id="tp_x<?= $Grid->RowIndex ?>_origem">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="faturamento" data-field="x_origem" name="x<?= $Grid->RowIndex ?>_origem" id="x<?= $Grid->RowIndex ?>_origem"<?= $Grid->origem->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_origem" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_origem"
    name="x<?= $Grid->RowIndex ?>_origem"
    value="<?= HtmlEncode($Grid->origem->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_origem"
    data-target="dsl_x<?= $Grid->RowIndex ?>_origem"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->origem->isInvalidClass() ?>"
    data-table="faturamento"
    data-field="x_origem"
    data-value-separator="<?= $Grid->origem->displayValueSeparatorAttribute() ?>"
    <?= $Grid->origem->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->origem->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_faturamento_origem" class="el_faturamento_origem">
<span<?= $Grid->origem->viewAttributes() ?>>
<?= $Grid->origem->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="faturamento" data-field="x_origem" data-hidden="1" name="ffaturamentogrid$x<?= $Grid->RowIndex ?>_origem" id="ffaturamentogrid$x<?= $Grid->RowIndex ?>_origem" value="<?= HtmlEncode($Grid->origem->FormValue) ?>">
<input type="hidden" data-table="faturamento" data-field="x_origem" data-hidden="1" data-old name="ffaturamentogrid$o<?= $Grid->RowIndex ?>_origem" id="ffaturamentogrid$o<?= $Grid->RowIndex ?>_origem" value="<?= HtmlEncode($Grid->origem->OldValue) ?>">
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
loadjs.ready(["ffaturamentogrid","load"], () => ffaturamentogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="ffaturamentogrid">
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
    ew.addEventHandlers("faturamento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
