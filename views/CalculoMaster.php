<?php

namespace PHPMaker2024\contratos;

// Table
$calculo = Container("calculo");
$calculo->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($calculo->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_calculomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($calculo->idcalculo->Visible) { // idcalculo ?>
        <tr id="r_idcalculo"<?= $calculo->idcalculo->rowAttributes() ?>>
            <td class="<?= $calculo->TableLeftColumnClass ?>"><?= $calculo->idcalculo->caption() ?></td>
            <td<?= $calculo->idcalculo->cellAttributes() ?>>
<span id="el_calculo_idcalculo">
<span<?= $calculo->idcalculo->viewAttributes() ?>>
<?= $calculo->idcalculo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($calculo->dt_cadastro->Visible) { // dt_cadastro ?>
        <tr id="r_dt_cadastro"<?= $calculo->dt_cadastro->rowAttributes() ?>>
            <td class="<?= $calculo->TableLeftColumnClass ?>"><?= $calculo->dt_cadastro->caption() ?></td>
            <td<?= $calculo->dt_cadastro->cellAttributes() ?>>
<span id="el_calculo_dt_cadastro">
<span<?= $calculo->dt_cadastro->viewAttributes() ?>>
<?= $calculo->dt_cadastro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($calculo->calculo->Visible) { // calculo ?>
        <tr id="r_calculo"<?= $calculo->calculo->rowAttributes() ?>>
            <td class="<?= $calculo->TableLeftColumnClass ?>"><?= $calculo->calculo->caption() ?></td>
            <td<?= $calculo->calculo->cellAttributes() ?>>
<span id="el_calculo_calculo">
<span<?= $calculo->calculo->viewAttributes() ?>>
<?= $calculo->calculo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
