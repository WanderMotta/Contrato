<?php

namespace PHPMaker2024\contratos;

// Table
$contrato = Container("contrato");
$contrato->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($contrato->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_contratomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($contrato->idcontrato->Visible) { // idcontrato ?>
        <tr id="r_idcontrato"<?= $contrato->idcontrato->rowAttributes() ?>>
            <td class="<?= $contrato->TableLeftColumnClass ?>"><?= $contrato->idcontrato->caption() ?></td>
            <td<?= $contrato->idcontrato->cellAttributes() ?>>
<span id="el_contrato_idcontrato">
<span<?= $contrato->idcontrato->viewAttributes() ?>>
<?= $contrato->idcontrato->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($contrato->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <tr id="r_cliente_idcliente"<?= $contrato->cliente_idcliente->rowAttributes() ?>>
            <td class="<?= $contrato->TableLeftColumnClass ?>"><?= $contrato->cliente_idcliente->caption() ?></td>
            <td<?= $contrato->cliente_idcliente->cellAttributes() ?>>
<span id="el_contrato_cliente_idcliente">
<span<?= $contrato->cliente_idcliente->viewAttributes() ?>>
<?= $contrato->cliente_idcliente->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($contrato->valor->Visible) { // valor ?>
        <tr id="r_valor"<?= $contrato->valor->rowAttributes() ?>>
            <td class="<?= $contrato->TableLeftColumnClass ?>"><?= $contrato->valor->caption() ?></td>
            <td<?= $contrato->valor->cellAttributes() ?>>
<span id="el_contrato_valor">
<span<?= $contrato->valor->viewAttributes() ?>>
<?= $contrato->valor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($contrato->ativo->Visible) { // ativo ?>
        <tr id="r_ativo"<?= $contrato->ativo->rowAttributes() ?>>
            <td class="<?= $contrato->TableLeftColumnClass ?>"><?= $contrato->ativo->caption() ?></td>
            <td<?= $contrato->ativo->cellAttributes() ?>>
<span id="el_contrato_ativo">
<span<?= $contrato->ativo->viewAttributes() ?>>
<?= $contrato->ativo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
