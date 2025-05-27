<?php

namespace PHPMaker2024\contratos;

// Table
$modulo = Container("modulo");
$modulo->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($modulo->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_modulomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($modulo->modulo->Visible) { // modulo ?>
        <tr id="r_modulo"<?= $modulo->modulo->rowAttributes() ?>>
            <td class="<?= $modulo->TableLeftColumnClass ?>"><?= $modulo->modulo->caption() ?></td>
            <td<?= $modulo->modulo->cellAttributes() ?>>
<span id="el_modulo_modulo">
<span<?= $modulo->modulo->viewAttributes() ?>>
<?= $modulo->modulo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($modulo->posicao->Visible) { // posicao ?>
        <tr id="r_posicao"<?= $modulo->posicao->rowAttributes() ?>>
            <td class="<?= $modulo->TableLeftColumnClass ?>"><?= $modulo->posicao->caption() ?></td>
            <td<?= $modulo->posicao->cellAttributes() ?>>
<span id="el_modulo_posicao">
<span<?= $modulo->posicao->viewAttributes() ?>>
<?= $modulo->posicao->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
