<?php

namespace PHPMaker2024\contratos;

// Page object
$ItensModuloPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { itens_modulo: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->item->Visible) { // item ?>
    <?php if (!$Page->item->Sortable || !$Page->sortUrl($Page->item)) { ?>
        <th class="<?= $Page->item->headerCellClass() ?>"><?= $Page->item->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->item->headerCellClass() ?>"><div role="button" data-table="itens_modulo" data-sort="<?= HtmlEncode($Page->item->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->item->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->item->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->item->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->porcentagem_valor->Visible) { // porcentagem_valor ?>
    <?php if (!$Page->porcentagem_valor->Sortable || !$Page->sortUrl($Page->porcentagem_valor)) { ?>
        <th class="<?= $Page->porcentagem_valor->headerCellClass() ?>"><?= $Page->porcentagem_valor->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->porcentagem_valor->headerCellClass() ?>"><div role="button" data-table="itens_modulo" data-sort="<?= HtmlEncode($Page->porcentagem_valor->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->porcentagem_valor->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->porcentagem_valor->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->porcentagem_valor->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->incidencia_inss->Visible) { // incidencia_inss ?>
    <?php if (!$Page->incidencia_inss->Sortable || !$Page->sortUrl($Page->incidencia_inss)) { ?>
        <th class="<?= $Page->incidencia_inss->headerCellClass() ?>"><?= $Page->incidencia_inss->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->incidencia_inss->headerCellClass() ?>"><div role="button" data-table="itens_modulo" data-sort="<?= HtmlEncode($Page->incidencia_inss->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->incidencia_inss->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->incidencia_inss->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->incidencia_inss->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <?php if (!$Page->ativo->Sortable || !$Page->sortUrl($Page->ativo)) { ?>
        <th class="<?= $Page->ativo->headerCellClass() ?>"><?= $Page->ativo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ativo->headerCellClass() ?>"><div role="button" data-table="itens_modulo" data-sort="<?= HtmlEncode($Page->ativo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->ativo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ativo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ativo->getSortIcon() ?></span>
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
<?php if ($Page->item->Visible) { // item ?>
        <!-- item -->
        <td<?= $Page->item->cellAttributes() ?>>
<span<?= $Page->item->viewAttributes() ?>>
<?= $Page->item->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->porcentagem_valor->Visible) { // porcentagem_valor ?>
        <!-- porcentagem_valor -->
        <td<?= $Page->porcentagem_valor->cellAttributes() ?>>
<span<?= $Page->porcentagem_valor->viewAttributes() ?>>
<?= $Page->porcentagem_valor->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->incidencia_inss->Visible) { // incidencia_inss ?>
        <!-- incidencia_inss -->
        <td<?= $Page->incidencia_inss->cellAttributes() ?>>
<span<?= $Page->incidencia_inss->viewAttributes() ?>>
<?= $Page->incidencia_inss->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <!-- ativo -->
        <td<?= $Page->ativo->cellAttributes() ?>>
<span<?= $Page->ativo->viewAttributes() ?>>
<?= $Page->ativo->getViewValue() ?></span>
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
<?php if ($Page->item->Visible) { // item ?>
        <!-- item -->
        <td class="<?= $Page->item->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->item->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->porcentagem_valor->Visible) { // porcentagem_valor ?>
        <!-- porcentagem_valor -->
        <td class="<?= $Page->porcentagem_valor->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->porcentagem_valor->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->incidencia_inss->Visible) { // incidencia_inss ?>
        <!-- incidencia_inss -->
        <td class="<?= $Page->incidencia_inss->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
        <!-- ativo -->
        <td class="<?= $Page->ativo->footerCellClass() ?>">
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
