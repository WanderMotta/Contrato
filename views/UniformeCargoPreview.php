<?php

namespace PHPMaker2024\contratos;

// Page object
$UniformeCargoPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { uniforme_cargo: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->uniforme_iduniforme->Visible) { // uniforme_iduniforme ?>
    <?php if (!$Page->uniforme_iduniforme->Sortable || !$Page->sortUrl($Page->uniforme_iduniforme)) { ?>
        <th class="<?= $Page->uniforme_iduniforme->headerCellClass() ?>"><?= $Page->uniforme_iduniforme->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->uniforme_iduniforme->headerCellClass() ?>"><div role="button" data-table="uniforme_cargo" data-sort="<?= HtmlEncode($Page->uniforme_iduniforme->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->uniforme_iduniforme->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->uniforme_iduniforme->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->uniforme_iduniforme->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
    <?php if (!$Page->tipo_uniforme_idtipo_uniforme->Sortable || !$Page->sortUrl($Page->tipo_uniforme_idtipo_uniforme)) { ?>
        <th class="<?= $Page->tipo_uniforme_idtipo_uniforme->headerCellClass() ?>"><?= $Page->tipo_uniforme_idtipo_uniforme->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tipo_uniforme_idtipo_uniforme->headerCellClass() ?>"><div role="button" data-table="uniforme_cargo" data-sort="<?= HtmlEncode($Page->tipo_uniforme_idtipo_uniforme->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->tipo_uniforme_idtipo_uniforme->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tipo_uniforme_idtipo_uniforme->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tipo_uniforme_idtipo_uniforme->getSortIcon() ?></span>
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
<?php if ($Page->uniforme_iduniforme->Visible) { // uniforme_iduniforme ?>
        <!-- uniforme_iduniforme -->
        <td<?= $Page->uniforme_iduniforme->cellAttributes() ?>>
<span<?= $Page->uniforme_iduniforme->viewAttributes() ?>>
<?= $Page->uniforme_iduniforme->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <!-- tipo_uniforme_idtipo_uniforme -->
        <td<?= $Page->tipo_uniforme_idtipo_uniforme->cellAttributes() ?>>
<span<?= $Page->tipo_uniforme_idtipo_uniforme->viewAttributes() ?>>
<?= $Page->tipo_uniforme_idtipo_uniforme->getViewValue() ?></span>
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
<?php if ($Page->uniforme_iduniforme->Visible) { // uniforme_iduniforme ?>
        <!-- uniforme_iduniforme -->
        <td class="<?= $Page->uniforme_iduniforme->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->uniforme_iduniforme->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
        <!-- tipo_uniforme_idtipo_uniforme -->
        <td class="<?= $Page->tipo_uniforme_idtipo_uniforme->footerCellClass() ?>">
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
