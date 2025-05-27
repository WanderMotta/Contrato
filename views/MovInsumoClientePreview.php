<?php

namespace PHPMaker2024\contratos;

// Page object
$MovInsumoClientePreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { mov_insumo_cliente: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
    <?php if (!$Page->tipo_insumo_idtipo_insumo->Sortable || !$Page->sortUrl($Page->tipo_insumo_idtipo_insumo)) { ?>
        <th class="<?= $Page->tipo_insumo_idtipo_insumo->headerCellClass() ?>"><?= $Page->tipo_insumo_idtipo_insumo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tipo_insumo_idtipo_insumo->headerCellClass() ?>"><div role="button" data-table="mov_insumo_cliente" data-sort="<?= HtmlEncode($Page->tipo_insumo_idtipo_insumo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->tipo_insumo_idtipo_insumo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tipo_insumo_idtipo_insumo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tipo_insumo_idtipo_insumo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
    <?php if (!$Page->insumo_idinsumo->Sortable || !$Page->sortUrl($Page->insumo_idinsumo)) { ?>
        <th class="<?= $Page->insumo_idinsumo->headerCellClass() ?>"><?= $Page->insumo_idinsumo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->insumo_idinsumo->headerCellClass() ?>"><div role="button" data-table="mov_insumo_cliente" data-sort="<?= HtmlEncode($Page->insumo_idinsumo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->insumo_idinsumo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->insumo_idinsumo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->insumo_idinsumo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
    <?php if (!$Page->qtde->Sortable || !$Page->sortUrl($Page->qtde)) { ?>
        <th class="<?= $Page->qtde->headerCellClass() ?>"><?= $Page->qtde->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->qtde->headerCellClass() ?>"><div role="button" data-table="mov_insumo_cliente" data-sort="<?= HtmlEncode($Page->qtde->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->qtde->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->qtde->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->qtde->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
    <?php if (!$Page->frequencia->Sortable || !$Page->sortUrl($Page->frequencia)) { ?>
        <th class="<?= $Page->frequencia->headerCellClass() ?>"><?= $Page->frequencia->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->frequencia->headerCellClass() ?>"><div role="button" data-table="mov_insumo_cliente" data-sort="<?= HtmlEncode($Page->frequencia->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->frequencia->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->frequencia->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->frequencia->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->vr_unit->Visible) { // vr_unit ?>
    <?php if (!$Page->vr_unit->Sortable || !$Page->sortUrl($Page->vr_unit)) { ?>
        <th class="<?= $Page->vr_unit->headerCellClass() ?>"><?= $Page->vr_unit->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->vr_unit->headerCellClass() ?>"><div role="button" data-table="mov_insumo_cliente" data-sort="<?= HtmlEncode($Page->vr_unit->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->vr_unit->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->vr_unit->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->vr_unit->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->vr_total->Visible) { // vr_total ?>
    <?php if (!$Page->vr_total->Sortable || !$Page->sortUrl($Page->vr_total)) { ?>
        <th class="<?= $Page->vr_total->headerCellClass() ?>"><?= $Page->vr_total->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->vr_total->headerCellClass() ?>"><div role="button" data-table="mov_insumo_cliente" data-sort="<?= HtmlEncode($Page->vr_total->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->vr_total->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->vr_total->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->vr_total->getSortIcon() ?></span>
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
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <!-- tipo_insumo_idtipo_insumo -->
        <td<?= $Page->tipo_insumo_idtipo_insumo->cellAttributes() ?>>
<span<?= $Page->tipo_insumo_idtipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo_idtipo_insumo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <!-- insumo_idinsumo -->
        <td<?= $Page->insumo_idinsumo->cellAttributes() ?>>
<span<?= $Page->insumo_idinsumo->viewAttributes() ?>>
<?= $Page->insumo_idinsumo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
        <!-- qtde -->
        <td<?= $Page->qtde->cellAttributes() ?>>
<span<?= $Page->qtde->viewAttributes() ?>>
<?= $Page->qtde->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
        <!-- frequencia -->
        <td<?= $Page->frequencia->cellAttributes() ?>>
<span<?= $Page->frequencia->viewAttributes() ?>>
<?= $Page->frequencia->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->vr_unit->Visible) { // vr_unit ?>
        <!-- vr_unit -->
        <td<?= $Page->vr_unit->cellAttributes() ?>>
<span<?= $Page->vr_unit->viewAttributes() ?>>
<?= $Page->vr_unit->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->vr_total->Visible) { // vr_total ?>
        <!-- vr_total -->
        <td<?= $Page->vr_total->cellAttributes() ?>>
<span<?= $Page->vr_total->viewAttributes() ?>>
<?= $Page->vr_total->getViewValue() ?></span>
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
<?php if ($Page->tipo_insumo_idtipo_insumo->Visible) { // tipo_insumo_idtipo_insumo ?>
        <!-- tipo_insumo_idtipo_insumo -->
        <td class="<?= $Page->tipo_insumo_idtipo_insumo->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->insumo_idinsumo->Visible) { // insumo_idinsumo ?>
        <!-- insumo_idinsumo -->
        <td class="<?= $Page->insumo_idinsumo->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->qtde->Visible) { // qtde ?>
        <!-- qtde -->
        <td class="<?= $Page->qtde->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
        <!-- frequencia -->
        <td class="<?= $Page->frequencia->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->vr_unit->Visible) { // vr_unit ?>
        <!-- vr_unit -->
        <td class="<?= $Page->vr_unit->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->vr_total->Visible) { // vr_total ?>
        <!-- vr_total -->
        <td class="<?= $Page->vr_total->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->vr_total->ViewValue ?></span>
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
