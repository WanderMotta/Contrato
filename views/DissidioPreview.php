<?php

namespace PHPMaker2024\contratos;

// Page object
$DissidioPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { dissidio: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->cargo->Visible) { // cargo ?>
    <?php if (!$Page->cargo->Sortable || !$Page->sortUrl($Page->cargo)) { ?>
        <th class="<?= $Page->cargo->headerCellClass() ?>"><?= $Page->cargo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cargo->headerCellClass() ?>"><div role="button" data-table="dissidio" data-sort="<?= HtmlEncode($Page->cargo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->cargo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cargo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cargo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->salario_antes->Visible) { // salario_antes ?>
    <?php if (!$Page->salario_antes->Sortable || !$Page->sortUrl($Page->salario_antes)) { ?>
        <th class="<?= $Page->salario_antes->headerCellClass() ?>"><?= $Page->salario_antes->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->salario_antes->headerCellClass() ?>"><div role="button" data-table="dissidio" data-sort="<?= HtmlEncode($Page->salario_antes->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->salario_antes->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->salario_antes->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->salario_antes->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->salario_atual->Visible) { // salario_atual ?>
    <?php if (!$Page->salario_atual->Sortable || !$Page->sortUrl($Page->salario_atual)) { ?>
        <th class="<?= $Page->salario_atual->headerCellClass() ?>"><?= $Page->salario_atual->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->salario_atual->headerCellClass() ?>"><div role="button" data-table="dissidio" data-sort="<?= HtmlEncode($Page->salario_atual->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->salario_atual->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->salario_atual->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->salario_atual->getSortIcon() ?></span>
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
<?php if ($Page->cargo->Visible) { // cargo ?>
        <!-- cargo -->
        <td<?= $Page->cargo->cellAttributes() ?>>
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->salario_antes->Visible) { // salario_antes ?>
        <!-- salario_antes -->
        <td<?= $Page->salario_antes->cellAttributes() ?>>
<span<?= $Page->salario_antes->viewAttributes() ?>>
<?= $Page->salario_antes->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->salario_atual->Visible) { // salario_atual ?>
        <!-- salario_atual -->
        <td<?= $Page->salario_atual->cellAttributes() ?>>
<span<?= $Page->salario_atual->viewAttributes() ?>>
<?= $Page->salario_atual->getViewValue() ?></span>
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
