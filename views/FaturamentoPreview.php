<?php

namespace PHPMaker2024\contratos;

// Page object
$FaturamentoPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { faturamento: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->faturamento->Visible) { // faturamento ?>
    <?php if (!$Page->faturamento->Sortable || !$Page->sortUrl($Page->faturamento)) { ?>
        <th class="<?= $Page->faturamento->headerCellClass() ?>"><?= $Page->faturamento->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->faturamento->headerCellClass() ?>"><div role="button" data-table="faturamento" data-sort="<?= HtmlEncode($Page->faturamento->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->faturamento->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->faturamento->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->faturamento->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cnpj->Visible) { // cnpj ?>
    <?php if (!$Page->cnpj->Sortable || !$Page->sortUrl($Page->cnpj)) { ?>
        <th class="<?= $Page->cnpj->headerCellClass() ?>"><?= $Page->cnpj->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cnpj->headerCellClass() ?>"><div role="button" data-table="faturamento" data-sort="<?= HtmlEncode($Page->cnpj->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->cnpj->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cnpj->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cnpj->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->endereco->Visible) { // endereco ?>
    <?php if (!$Page->endereco->Sortable || !$Page->sortUrl($Page->endereco)) { ?>
        <th class="<?= $Page->endereco->headerCellClass() ?>"><?= $Page->endereco->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->endereco->headerCellClass() ?>"><div role="button" data-table="faturamento" data-sort="<?= HtmlEncode($Page->endereco->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->endereco->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->endereco->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->endereco->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bairro->Visible) { // bairro ?>
    <?php if (!$Page->bairro->Sortable || !$Page->sortUrl($Page->bairro)) { ?>
        <th class="<?= $Page->bairro->headerCellClass() ?>"><?= $Page->bairro->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bairro->headerCellClass() ?>"><div role="button" data-table="faturamento" data-sort="<?= HtmlEncode($Page->bairro->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->bairro->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->bairro->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->bairro->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
    <?php if (!$Page->cidade->Sortable || !$Page->sortUrl($Page->cidade)) { ?>
        <th class="<?= $Page->cidade->headerCellClass() ?>"><?= $Page->cidade->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cidade->headerCellClass() ?>"><div role="button" data-table="faturamento" data-sort="<?= HtmlEncode($Page->cidade->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->cidade->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cidade->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cidade->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
    <?php if (!$Page->uf->Sortable || !$Page->sortUrl($Page->uf)) { ?>
        <th class="<?= $Page->uf->headerCellClass() ?>"><?= $Page->uf->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->uf->headerCellClass() ?>"><div role="button" data-table="faturamento" data-sort="<?= HtmlEncode($Page->uf->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->uf->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->uf->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->uf->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dia_vencimento->Visible) { // dia_vencimento ?>
    <?php if (!$Page->dia_vencimento->Sortable || !$Page->sortUrl($Page->dia_vencimento)) { ?>
        <th class="<?= $Page->dia_vencimento->headerCellClass() ?>"><?= $Page->dia_vencimento->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dia_vencimento->headerCellClass() ?>"><div role="button" data-table="faturamento" data-sort="<?= HtmlEncode($Page->dia_vencimento->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->dia_vencimento->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->dia_vencimento->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->dia_vencimento->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->origem->Visible) { // origem ?>
    <?php if (!$Page->origem->Sortable || !$Page->sortUrl($Page->origem)) { ?>
        <th class="<?= $Page->origem->headerCellClass() ?>"><?= $Page->origem->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->origem->headerCellClass() ?>"><div role="button" data-table="faturamento" data-sort="<?= HtmlEncode($Page->origem->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->origem->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->origem->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->origem->getSortIcon() ?></span>
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
<?php if ($Page->faturamento->Visible) { // faturamento ?>
        <!-- faturamento -->
        <td<?= $Page->faturamento->cellAttributes() ?>>
<span<?= $Page->faturamento->viewAttributes() ?>>
<?= $Page->faturamento->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cnpj->Visible) { // cnpj ?>
        <!-- cnpj -->
        <td<?= $Page->cnpj->cellAttributes() ?>>
<span<?= $Page->cnpj->viewAttributes() ?>>
<?= $Page->cnpj->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->endereco->Visible) { // endereco ?>
        <!-- endereco -->
        <td<?= $Page->endereco->cellAttributes() ?>>
<span<?= $Page->endereco->viewAttributes() ?>>
<?= $Page->endereco->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bairro->Visible) { // bairro ?>
        <!-- bairro -->
        <td<?= $Page->bairro->cellAttributes() ?>>
<span<?= $Page->bairro->viewAttributes() ?>>
<?= $Page->bairro->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cidade->Visible) { // cidade ?>
        <!-- cidade -->
        <td<?= $Page->cidade->cellAttributes() ?>>
<span<?= $Page->cidade->viewAttributes() ?>>
<?= $Page->cidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
        <!-- uf -->
        <td<?= $Page->uf->cellAttributes() ?>>
<span<?= $Page->uf->viewAttributes() ?>>
<?= $Page->uf->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dia_vencimento->Visible) { // dia_vencimento ?>
        <!-- dia_vencimento -->
        <td<?= $Page->dia_vencimento->cellAttributes() ?>>
<span<?= $Page->dia_vencimento->viewAttributes() ?>>
<?= $Page->dia_vencimento->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->origem->Visible) { // origem ?>
        <!-- origem -->
        <td<?= $Page->origem->cellAttributes() ?>>
<span<?= $Page->origem->viewAttributes() ?>>
<?= $Page->origem->getViewValue() ?></span>
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
