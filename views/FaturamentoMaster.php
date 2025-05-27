<?php

namespace PHPMaker2024\contratos;

// Table
$faturamento = Container("faturamento");
$faturamento->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($faturamento->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_faturamentomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($faturamento->faturamento->Visible) { // faturamento ?>
        <tr id="r_faturamento"<?= $faturamento->faturamento->rowAttributes() ?>>
            <td class="<?= $faturamento->TableLeftColumnClass ?>"><?= $faturamento->faturamento->caption() ?></td>
            <td<?= $faturamento->faturamento->cellAttributes() ?>>
<span id="el_faturamento_faturamento">
<span<?= $faturamento->faturamento->viewAttributes() ?>>
<?= $faturamento->faturamento->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($faturamento->cnpj->Visible) { // cnpj ?>
        <tr id="r_cnpj"<?= $faturamento->cnpj->rowAttributes() ?>>
            <td class="<?= $faturamento->TableLeftColumnClass ?>"><?= $faturamento->cnpj->caption() ?></td>
            <td<?= $faturamento->cnpj->cellAttributes() ?>>
<span id="el_faturamento_cnpj">
<span<?= $faturamento->cnpj->viewAttributes() ?>>
<?= $faturamento->cnpj->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($faturamento->endereco->Visible) { // endereco ?>
        <tr id="r_endereco"<?= $faturamento->endereco->rowAttributes() ?>>
            <td class="<?= $faturamento->TableLeftColumnClass ?>"><?= $faturamento->endereco->caption() ?></td>
            <td<?= $faturamento->endereco->cellAttributes() ?>>
<span id="el_faturamento_endereco">
<span<?= $faturamento->endereco->viewAttributes() ?>>
<?= $faturamento->endereco->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($faturamento->bairro->Visible) { // bairro ?>
        <tr id="r_bairro"<?= $faturamento->bairro->rowAttributes() ?>>
            <td class="<?= $faturamento->TableLeftColumnClass ?>"><?= $faturamento->bairro->caption() ?></td>
            <td<?= $faturamento->bairro->cellAttributes() ?>>
<span id="el_faturamento_bairro">
<span<?= $faturamento->bairro->viewAttributes() ?>>
<?= $faturamento->bairro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($faturamento->cidade->Visible) { // cidade ?>
        <tr id="r_cidade"<?= $faturamento->cidade->rowAttributes() ?>>
            <td class="<?= $faturamento->TableLeftColumnClass ?>"><?= $faturamento->cidade->caption() ?></td>
            <td<?= $faturamento->cidade->cellAttributes() ?>>
<span id="el_faturamento_cidade">
<span<?= $faturamento->cidade->viewAttributes() ?>>
<?= $faturamento->cidade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($faturamento->uf->Visible) { // uf ?>
        <tr id="r_uf"<?= $faturamento->uf->rowAttributes() ?>>
            <td class="<?= $faturamento->TableLeftColumnClass ?>"><?= $faturamento->uf->caption() ?></td>
            <td<?= $faturamento->uf->cellAttributes() ?>>
<span id="el_faturamento_uf">
<span<?= $faturamento->uf->viewAttributes() ?>>
<?= $faturamento->uf->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($faturamento->dia_vencimento->Visible) { // dia_vencimento ?>
        <tr id="r_dia_vencimento"<?= $faturamento->dia_vencimento->rowAttributes() ?>>
            <td class="<?= $faturamento->TableLeftColumnClass ?>"><?= $faturamento->dia_vencimento->caption() ?></td>
            <td<?= $faturamento->dia_vencimento->cellAttributes() ?>>
<span id="el_faturamento_dia_vencimento">
<span<?= $faturamento->dia_vencimento->viewAttributes() ?>>
<?= $faturamento->dia_vencimento->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($faturamento->origem->Visible) { // origem ?>
        <tr id="r_origem"<?= $faturamento->origem->rowAttributes() ?>>
            <td class="<?= $faturamento->TableLeftColumnClass ?>"><?= $faturamento->origem->caption() ?></td>
            <td<?= $faturamento->origem->cellAttributes() ?>>
<span id="el_faturamento_origem">
<span<?= $faturamento->origem->viewAttributes() ?>>
<?= $faturamento->origem->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
