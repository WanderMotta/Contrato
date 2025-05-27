<?php

namespace PHPMaker2024\contratos;

// Page object
$PlanilhaCustoContratoPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { planilha_custo_contrato: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid <?= $Page->TableGridClass ?>"><!-- .card -->
<div class="card-header ew-grid-upper-panel ew-preview-upper-panel"><!-- .card-header -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-header -->
<div class="card-body ew-preview-middle-panel ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>"><!-- .card-body -->
<table class="<?= $Page->TableClass ?>"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
    <?php if (!$Page->quantidade->Sortable || !$Page->sortUrl($Page->quantidade)) { ?>
        <th class="<?= $Page->quantidade->headerCellClass() ?>"><?= $Page->quantidade->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->quantidade->headerCellClass() ?>"><div role="button" data-table="planilha_custo_contrato" data-sort="<?= HtmlEncode($Page->quantidade->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->quantidade->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->quantidade->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->quantidade->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
    <?php if (!$Page->escala_idescala->Sortable || !$Page->sortUrl($Page->escala_idescala)) { ?>
        <th class="<?= $Page->escala_idescala->headerCellClass() ?>"><?= $Page->escala_idescala->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->escala_idescala->headerCellClass() ?>"><div role="button" data-table="planilha_custo_contrato" data-sort="<?= HtmlEncode($Page->escala_idescala->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->escala_idescala->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->escala_idescala->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->escala_idescala->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
    <?php if (!$Page->periodo_idperiodo->Sortable || !$Page->sortUrl($Page->periodo_idperiodo)) { ?>
        <th class="<?= $Page->periodo_idperiodo->headerCellClass() ?>"><?= $Page->periodo_idperiodo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->periodo_idperiodo->headerCellClass() ?>"><div role="button" data-table="planilha_custo_contrato" data-sort="<?= HtmlEncode($Page->periodo_idperiodo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->periodo_idperiodo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->periodo_idperiodo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->periodo_idperiodo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
    <?php if (!$Page->tipo_intrajornada_idtipo_intrajornada->Sortable || !$Page->sortUrl($Page->tipo_intrajornada_idtipo_intrajornada)) { ?>
        <th class="<?= $Page->tipo_intrajornada_idtipo_intrajornada->headerCellClass() ?>"><?= $Page->tipo_intrajornada_idtipo_intrajornada->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tipo_intrajornada_idtipo_intrajornada->headerCellClass() ?>"><div role="button" data-table="planilha_custo_contrato" data-sort="<?= HtmlEncode($Page->tipo_intrajornada_idtipo_intrajornada->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->tipo_intrajornada_idtipo_intrajornada->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tipo_intrajornada_idtipo_intrajornada->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tipo_intrajornada_idtipo_intrajornada->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
    <?php if (!$Page->cargo_idcargo->Sortable || !$Page->sortUrl($Page->cargo_idcargo)) { ?>
        <th class="<?= $Page->cargo_idcargo->headerCellClass() ?>"><?= $Page->cargo_idcargo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cargo_idcargo->headerCellClass() ?>"><div role="button" data-table="planilha_custo_contrato" data-sort="<?= HtmlEncode($Page->cargo_idcargo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->cargo_idcargo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cargo_idcargo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cargo_idcargo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
    <?php if (!$Page->acumulo_funcao->Sortable || !$Page->sortUrl($Page->acumulo_funcao)) { ?>
        <th class="<?= $Page->acumulo_funcao->headerCellClass() ?>"><?= $Page->acumulo_funcao->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->acumulo_funcao->headerCellClass() ?>"><div role="button" data-table="planilha_custo_contrato" data-sort="<?= HtmlEncode($Page->acumulo_funcao->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->acumulo_funcao->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->acumulo_funcao->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->acumulo_funcao->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecordCount = 0;
$Page->RowCount = 0;
while ($Page->fetch()) {
    // Init row class and style
    $Page->RecordCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->CurrentRow);
    $Page->aggregateListRowValues(); // Aggregate row values

    // Render row
    $Page->RowType = RowType::PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Set up row attributes
    $Page->RowAttrs->merge([
        "data-rowindex" => $Page->RowCount,
        "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",

        // Add row attributes for expandable row
        "data-widget" => "expandable-table",
        "aria-expanded" => "false",
    ]);

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
        <!-- quantidade -->
        <td<?= $Page->quantidade->cellAttributes() ?>>
<span<?= $Page->quantidade->viewAttributes() ?>>
<?= $Page->quantidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <!-- escala_idescala -->
        <td<?= $Page->escala_idescala->cellAttributes() ?>>
<span<?= $Page->escala_idescala->viewAttributes() ?>>
<?= $Page->escala_idescala->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <!-- periodo_idperiodo -->
        <td<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span<?= $Page->periodo_idperiodo->viewAttributes() ?>>
<?= $Page->periodo_idperiodo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <!-- tipo_intrajornada_idtipo_intrajornada -->
        <td<?= $Page->tipo_intrajornada_idtipo_intrajornada->cellAttributes() ?>>
<span<?= $Page->tipo_intrajornada_idtipo_intrajornada->viewAttributes() ?>>
<?= $Page->tipo_intrajornada_idtipo_intrajornada->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <!-- cargo_idcargo -->
        <td<?= $Page->cargo_idcargo->cellAttributes() ?>>
<span<?= $Page->cargo_idcargo->viewAttributes() ?>>
<?= $Page->cargo_idcargo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <!-- acumulo_funcao -->
        <td<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span<?= $Page->acumulo_funcao->viewAttributes() ?>>
<?= $Page->acumulo_funcao->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
} // while
?>
    </tbody>
<?php
    // Render aggregate row
    $Page->RowType = RowType::AGGREGATE; // Aggregate
    $Page->aggregateListRow(); // Prepare aggregate row

    // Render list options
    $Page->renderListOptions();
?>
    <tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options (footer, left)
$Page->ListOptions->render("footer", "left");
?>
<?php if ($Page->quantidade->Visible) { // quantidade ?>
        <!-- quantidade -->
        <td class="<?= $Page->quantidade->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->quantidade->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
        <!-- escala_idescala -->
        <td class="<?= $Page->escala_idescala->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <!-- periodo_idperiodo -->
        <td class="<?= $Page->periodo_idperiodo->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <!-- tipo_intrajornada_idtipo_intrajornada -->
        <td class="<?= $Page->tipo_intrajornada_idtipo_intrajornada->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <!-- cargo_idcargo -->
        <td class="<?= $Page->cargo_idcargo->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->cargo_idcargo->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <!-- acumulo_funcao -->
        <td class="<?= $Page->acumulo_funcao->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php
// Render list options (footer, right)
$Page->ListOptions->render("footer", "right");
?>
    </tr>
    </tfoot>
</table><!-- /.table -->
</div><!-- /.card-body -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-footer -->
</div><!-- /.card -->
<?php } else { // No record ?>
<div class="card border-0"><!-- .card -->
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card -->
<?php } ?>
<?php
foreach ($Page->DetailCounts as $detailTblVar => $detailCount) {
?>
<div class="ew-detail-count d-none" data-table="<?= $detailTblVar ?>" data-count="<?= $detailCount ?>"><?= FormatInteger($detailCount) ?></div>
<?php
}
?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
$Page->Recordset?->free();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
