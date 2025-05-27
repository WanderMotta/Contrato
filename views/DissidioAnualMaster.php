<?php

namespace PHPMaker2024\contratos;

// Table
$dissidio_anual = Container("dissidio_anual");
$dissidio_anual->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($dissidio_anual->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_dissidio_anualmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($dissidio_anual->data->Visible) { // data ?>
        <tr id="r_data"<?= $dissidio_anual->data->rowAttributes() ?>>
            <td class="<?= $dissidio_anual->TableLeftColumnClass ?>"><?= $dissidio_anual->data->caption() ?></td>
            <td<?= $dissidio_anual->data->cellAttributes() ?>>
<span id="el_dissidio_anual_data">
<span<?= $dissidio_anual->data->viewAttributes() ?>>
<?= $dissidio_anual->data->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($dissidio_anual->obs->Visible) { // obs ?>
        <tr id="r_obs"<?= $dissidio_anual->obs->rowAttributes() ?>>
            <td class="<?= $dissidio_anual->TableLeftColumnClass ?>"><?= $dissidio_anual->obs->caption() ?></td>
            <td<?= $dissidio_anual->obs->cellAttributes() ?>>
<span id="el_dissidio_anual_obs">
<span<?= $dissidio_anual->obs->viewAttributes() ?>>
<?= $dissidio_anual->obs->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
