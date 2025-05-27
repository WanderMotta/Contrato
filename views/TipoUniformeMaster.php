<?php

namespace PHPMaker2024\contratos;

// Table
$tipo_uniforme = Container("tipo_uniforme");
$tipo_uniforme->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($tipo_uniforme->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_tipo_uniformemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($tipo_uniforme->tipo_uniforme->Visible) { // tipo_uniforme ?>
        <tr id="r_tipo_uniforme"<?= $tipo_uniforme->tipo_uniforme->rowAttributes() ?>>
            <td class="<?= $tipo_uniforme->TableLeftColumnClass ?>"><?= $tipo_uniforme->tipo_uniforme->caption() ?></td>
            <td<?= $tipo_uniforme->tipo_uniforme->cellAttributes() ?>>
<span id="el_tipo_uniforme_tipo_uniforme">
<span<?= $tipo_uniforme->tipo_uniforme->viewAttributes() ?>>
<?= $tipo_uniforme->tipo_uniforme->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
