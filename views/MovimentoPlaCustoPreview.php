<?php

namespace PHPMaker2024\contratos;

// Page object
$MovimentoPlaCustoPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { movimento_pla_custo: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
    <?php if (!$Page->planilha_custo_idplanilha_custo->Sortable || !$Page->sortUrl($Page->planilha_custo_idplanilha_custo)) { ?>
        <th class="<?= $Page->planilha_custo_idplanilha_custo->headerCellClass() ?>"><?= $Page->planilha_custo_idplanilha_custo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->planilha_custo_idplanilha_custo->headerCellClass() ?>"><div role="button" data-table="movimento_pla_custo" data-sort="<?= HtmlEncode($Page->planilha_custo_idplanilha_custo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->planilha_custo_idplanilha_custo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->planilha_custo_idplanilha_custo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->planilha_custo_idplanilha_custo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
    <?php if (!$Page->modulo_idmodulo->Sortable || !$Page->sortUrl($Page->modulo_idmodulo)) { ?>
        <th class="<?= $Page->modulo_idmodulo->headerCellClass() ?>"><?= $Page->modulo_idmodulo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->modulo_idmodulo->headerCellClass() ?>"><div role="button" data-table="movimento_pla_custo" data-sort="<?= HtmlEncode($Page->modulo_idmodulo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->modulo_idmodulo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->modulo_idmodulo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->modulo_idmodulo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
    <?php if (!$Page->itens_modulo_iditens_modulo->Sortable || !$Page->sortUrl($Page->itens_modulo_iditens_modulo)) { ?>
        <th class="<?= $Page->itens_modulo_iditens_modulo->headerCellClass() ?>"><?= $Page->itens_modulo_iditens_modulo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->itens_modulo_iditens_modulo->headerCellClass() ?>"><div role="button" data-table="movimento_pla_custo" data-sort="<?= HtmlEncode($Page->itens_modulo_iditens_modulo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->itens_modulo_iditens_modulo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->itens_modulo_iditens_modulo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->itens_modulo_iditens_modulo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { // porcentagem ?>
    <?php if (!$Page->porcentagem->Sortable || !$Page->sortUrl($Page->porcentagem)) { ?>
        <th class="<?= $Page->porcentagem->headerCellClass() ?>"><?= $Page->porcentagem->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->porcentagem->headerCellClass() ?>"><div role="button" data-table="movimento_pla_custo" data-sort="<?= HtmlEncode($Page->porcentagem->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->porcentagem->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->porcentagem->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->porcentagem->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
    <?php if (!$Page->valor->Sortable || !$Page->sortUrl($Page->valor)) { ?>
        <th class="<?= $Page->valor->headerCellClass() ?>"><?= $Page->valor->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->valor->headerCellClass() ?>"><div role="button" data-table="movimento_pla_custo" data-sort="<?= HtmlEncode($Page->valor->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->valor->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->valor->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->valor->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <?php if (!$Page->obs->Sortable || !$Page->sortUrl($Page->obs)) { ?>
        <th class="<?= $Page->obs->headerCellClass() ?>"><?= $Page->obs->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->obs->headerCellClass() ?>"><div role="button" data-table="movimento_pla_custo" data-sort="<?= HtmlEncode($Page->obs->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->obs->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->obs->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->obs->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
    <?php if (!$Page->calculo_idcalculo->Sortable || !$Page->sortUrl($Page->calculo_idcalculo)) { ?>
        <th class="<?= $Page->calculo_idcalculo->headerCellClass() ?>"><?= $Page->calculo_idcalculo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->calculo_idcalculo->headerCellClass() ?>"><div role="button" data-table="movimento_pla_custo" data-sort="<?= HtmlEncode($Page->calculo_idcalculo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->calculo_idcalculo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->calculo_idcalculo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->calculo_idcalculo->getSortIcon() ?></span>
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
<?php if ($Page->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
        <!-- planilha_custo_idplanilha_custo -->
        <td<?= $Page->planilha_custo_idplanilha_custo->cellAttributes() ?>>
<span<?= $Page->planilha_custo_idplanilha_custo->viewAttributes() ?>>
<?= $Page->planilha_custo_idplanilha_custo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <!-- modulo_idmodulo -->
        <td<?= $Page->modulo_idmodulo->cellAttributes() ?>>
<span<?= $Page->modulo_idmodulo->viewAttributes() ?>>
<?= $Page->modulo_idmodulo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
        <!-- itens_modulo_iditens_modulo -->
        <td<?= $Page->itens_modulo_iditens_modulo->cellAttributes() ?>>
<span<?= $Page->itens_modulo_iditens_modulo->viewAttributes() ?>>
<?= $Page->itens_modulo_iditens_modulo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { // porcentagem ?>
        <!-- porcentagem -->
        <td<?= $Page->porcentagem->cellAttributes() ?>>
<span<?= $Page->porcentagem->viewAttributes() ?>>
<?= $Page->porcentagem->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <!-- valor -->
        <td<?= $Page->valor->cellAttributes() ?>>
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
        <!-- obs -->
        <td<?= $Page->obs->cellAttributes() ?>>
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
        <!-- calculo_idcalculo -->
        <td<?= $Page->calculo_idcalculo->cellAttributes() ?>>
<span<?= $Page->calculo_idcalculo->viewAttributes() ?>>
<?= $Page->calculo_idcalculo->getViewValue() ?></span>
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
<?php if ($Page->planilha_custo_idplanilha_custo->Visible) { // planilha_custo_idplanilha_custo ?>
        <!-- planilha_custo_idplanilha_custo -->
        <td class="<?= $Page->planilha_custo_idplanilha_custo->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->modulo_idmodulo->Visible) { // modulo_idmodulo ?>
        <!-- modulo_idmodulo -->
        <td class="<?= $Page->modulo_idmodulo->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->itens_modulo_iditens_modulo->Visible) { // itens_modulo_iditens_modulo ?>
        <!-- itens_modulo_iditens_modulo -->
        <td class="<?= $Page->itens_modulo_iditens_modulo->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->itens_modulo_iditens_modulo->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->porcentagem->Visible) { // porcentagem ?>
        <!-- porcentagem -->
        <td class="<?= $Page->porcentagem->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->porcentagem->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <!-- valor -->
        <td class="<?= $Page->valor->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->valor->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
        <!-- obs -->
        <td class="<?= $Page->obs->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->calculo_idcalculo->Visible) { // calculo_idcalculo ?>
        <!-- calculo_idcalculo -->
        <td class="<?= $Page->calculo_idcalculo->footerCellClass() ?>">
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
