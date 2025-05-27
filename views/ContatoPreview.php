<?php

namespace PHPMaker2024\contratos;

// Page object
$ContatoPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { contato: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->contato->Visible) { // contato ?>
    <?php if (!$Page->contato->Sortable || !$Page->sortUrl($Page->contato)) { ?>
        <th class="<?= $Page->contato->headerCellClass() ?>"><?= $Page->contato->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->contato->headerCellClass() ?>"><div role="button" data-table="contato" data-sort="<?= HtmlEncode($Page->contato->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->contato->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->contato->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->contato->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <?php if (!$Page->_email->Sortable || !$Page->sortUrl($Page->_email)) { ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><?= $Page->_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><div role="button" data-table="contato" data-sort="<?= HtmlEncode($Page->_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->telefone->Visible) { // telefone ?>
    <?php if (!$Page->telefone->Sortable || !$Page->sortUrl($Page->telefone)) { ?>
        <th class="<?= $Page->telefone->headerCellClass() ?>"><?= $Page->telefone->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->telefone->headerCellClass() ?>"><div role="button" data-table="contato" data-sort="<?= HtmlEncode($Page->telefone->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->telefone->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->telefone->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->telefone->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <?php if (!$Page->status->Sortable || !$Page->sortUrl($Page->status)) { ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><?= $Page->status->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><div role="button" data-table="contato" data-sort="<?= HtmlEncode($Page->status->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <?php if (!$Page->ativo->Sortable || !$Page->sortUrl($Page->ativo)) { ?>
        <th class="<?= $Page->ativo->headerCellClass() ?>"><?= $Page->ativo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ativo->headerCellClass() ?>"><div role="button" data-table="contato" data-sort="<?= HtmlEncode($Page->ativo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->ativo->getNextSort() ?>">
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
<?php if ($Page->contato->Visible) { // contato ?>
        <!-- contato -->
        <td<?= $Page->contato->cellAttributes() ?>>
<span<?= $Page->contato->viewAttributes() ?>>
<?= $Page->contato->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <!-- email -->
        <td<?= $Page->_email->cellAttributes() ?>>
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->telefone->Visible) { // telefone ?>
        <!-- telefone -->
        <td<?= $Page->telefone->cellAttributes() ?>>
<span<?= $Page->telefone->viewAttributes() ?>>
<?= $Page->telefone->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <!-- status -->
        <td<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
