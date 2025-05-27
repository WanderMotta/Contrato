<?php

namespace PHPMaker2024\contratos;

// Table
$cliente = Container("cliente");
$cliente->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($cliente->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_clientemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($cliente->cliente->Visible) { // cliente ?>
        <tr id="r_cliente"<?= $cliente->cliente->rowAttributes() ?>>
            <td class="<?= $cliente->TableLeftColumnClass ?>"><?= $cliente->cliente->caption() ?></td>
            <td<?= $cliente->cliente->cellAttributes() ?>>
<span id="el_cliente_cliente">
<span<?= $cliente->cliente->viewAttributes() ?>>
<?= $cliente->cliente->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cliente->contato->Visible) { // contato ?>
        <tr id="r_contato"<?= $cliente->contato->rowAttributes() ?>>
            <td class="<?= $cliente->TableLeftColumnClass ?>"><?= $cliente->contato->caption() ?></td>
            <td<?= $cliente->contato->cellAttributes() ?>>
<span id="el_cliente_contato">
<span<?= $cliente->contato->viewAttributes() ?>>
<?= $cliente->contato->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cliente->_email->Visible) { // email ?>
        <tr id="r__email"<?= $cliente->_email->rowAttributes() ?>>
            <td class="<?= $cliente->TableLeftColumnClass ?>"><?= $cliente->_email->caption() ?></td>
            <td<?= $cliente->_email->cellAttributes() ?>>
<span id="el_cliente__email">
<span<?= $cliente->_email->viewAttributes() ?>>
<?= $cliente->_email->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cliente->telefone->Visible) { // telefone ?>
        <tr id="r_telefone"<?= $cliente->telefone->rowAttributes() ?>>
            <td class="<?= $cliente->TableLeftColumnClass ?>"><?= $cliente->telefone->caption() ?></td>
            <td<?= $cliente->telefone->cellAttributes() ?>>
<span id="el_cliente_telefone">
<span<?= $cliente->telefone->viewAttributes() ?>>
<?= $cliente->telefone->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cliente->ativo->Visible) { // ativo ?>
        <tr id="r_ativo"<?= $cliente->ativo->rowAttributes() ?>>
            <td class="<?= $cliente->TableLeftColumnClass ?>"><?= $cliente->ativo->caption() ?></td>
            <td<?= $cliente->ativo->cellAttributes() ?>>
<span id="el_cliente_ativo">
<span<?= $cliente->ativo->viewAttributes() ?>>
<?= $cliente->ativo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
