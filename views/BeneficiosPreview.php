<?php

namespace PHPMaker2024\contratos;

// Page object
$BeneficiosPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { beneficios: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->data->Visible) { // data ?>
    <?php if (!$Page->data->Sortable || !$Page->sortUrl($Page->data)) { ?>
        <th class="<?= $Page->data->headerCellClass() ?>"><?= $Page->data->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->data->headerCellClass() ?>"><div role="button" data-table="beneficios" data-sort="<?= HtmlEncode($Page->data->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->data->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->data->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->data->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
    <?php if (!$Page->vt_dia->Sortable || !$Page->sortUrl($Page->vt_dia)) { ?>
        <th class="<?= $Page->vt_dia->headerCellClass() ?>"><?= $Page->vt_dia->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->vt_dia->headerCellClass() ?>"><div role="button" data-table="beneficios" data-sort="<?= HtmlEncode($Page->vt_dia->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->vt_dia->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->vt_dia->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->vt_dia->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
    <?php if (!$Page->vr_dia->Sortable || !$Page->sortUrl($Page->vr_dia)) { ?>
        <th class="<?= $Page->vr_dia->headerCellClass() ?>"><?= $Page->vr_dia->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->vr_dia->headerCellClass() ?>"><div role="button" data-table="beneficios" data-sort="<?= HtmlEncode($Page->vr_dia->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->vr_dia->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->vr_dia->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->vr_dia->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
    <?php if (!$Page->va_mes->Sortable || !$Page->sortUrl($Page->va_mes)) { ?>
        <th class="<?= $Page->va_mes->headerCellClass() ?>"><?= $Page->va_mes->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->va_mes->headerCellClass() ?>"><div role="button" data-table="beneficios" data-sort="<?= HtmlEncode($Page->va_mes->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->va_mes->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->va_mes->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->va_mes->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
    <?php if (!$Page->benef_social->Sortable || !$Page->sortUrl($Page->benef_social)) { ?>
        <th class="<?= $Page->benef_social->headerCellClass() ?>"><?= $Page->benef_social->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->benef_social->headerCellClass() ?>"><div role="button" data-table="beneficios" data-sort="<?= HtmlEncode($Page->benef_social->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->benef_social->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->benef_social->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->benef_social->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
    <?php if (!$Page->plr->Sortable || !$Page->sortUrl($Page->plr)) { ?>
        <th class="<?= $Page->plr->headerCellClass() ?>"><?= $Page->plr->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->plr->headerCellClass() ?>"><div role="button" data-table="beneficios" data-sort="<?= HtmlEncode($Page->plr->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->plr->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->plr->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->plr->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
    <?php if (!$Page->assis_medica->Sortable || !$Page->sortUrl($Page->assis_medica)) { ?>
        <th class="<?= $Page->assis_medica->headerCellClass() ?>"><?= $Page->assis_medica->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->assis_medica->headerCellClass() ?>"><div role="button" data-table="beneficios" data-sort="<?= HtmlEncode($Page->assis_medica->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->assis_medica->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->assis_medica->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->assis_medica->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
    <?php if (!$Page->assis_odonto->Sortable || !$Page->sortUrl($Page->assis_odonto)) { ?>
        <th class="<?= $Page->assis_odonto->headerCellClass() ?>"><?= $Page->assis_odonto->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->assis_odonto->headerCellClass() ?>"><div role="button" data-table="beneficios" data-sort="<?= HtmlEncode($Page->assis_odonto->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->assis_odonto->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->assis_odonto->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->assis_odonto->getSortIcon() ?></span>
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
<?php if ($Page->data->Visible) { // data ?>
        <!-- data -->
        <td<?= $Page->data->cellAttributes() ?>>
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
        <!-- vt_dia -->
        <td<?= $Page->vt_dia->cellAttributes() ?>>
<span<?= $Page->vt_dia->viewAttributes() ?>>
<?= $Page->vt_dia->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
        <!-- vr_dia -->
        <td<?= $Page->vr_dia->cellAttributes() ?>>
<span<?= $Page->vr_dia->viewAttributes() ?>>
<?= $Page->vr_dia->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
        <!-- va_mes -->
        <td<?= $Page->va_mes->cellAttributes() ?>>
<span<?= $Page->va_mes->viewAttributes() ?>>
<?= $Page->va_mes->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
        <!-- benef_social -->
        <td<?= $Page->benef_social->cellAttributes() ?>>
<span<?= $Page->benef_social->viewAttributes() ?>>
<?= $Page->benef_social->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
        <!-- plr -->
        <td<?= $Page->plr->cellAttributes() ?>>
<span<?= $Page->plr->viewAttributes() ?>>
<?= $Page->plr->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
        <!-- assis_medica -->
        <td<?= $Page->assis_medica->cellAttributes() ?>>
<span<?= $Page->assis_medica->viewAttributes() ?>>
<?= $Page->assis_medica->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
        <!-- assis_odonto -->
        <td<?= $Page->assis_odonto->cellAttributes() ?>>
<span<?= $Page->assis_odonto->viewAttributes() ?>>
<?= $Page->assis_odonto->getViewValue() ?></span>
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
