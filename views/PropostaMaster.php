<?php

namespace PHPMaker2024\contratos;

// Table
$proposta = Container("proposta");
$proposta->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($proposta->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_propostamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($proposta->idproposta->Visible) { // idproposta ?>
        <tr id="r_idproposta"<?= $proposta->idproposta->rowAttributes() ?>>
            <td class="<?= $proposta->TableLeftColumnClass ?>"><?= $proposta->idproposta->caption() ?></td>
            <td<?= $proposta->idproposta->cellAttributes() ?>>
<span id="el_proposta_idproposta">
<span<?= $proposta->idproposta->viewAttributes() ?>>
<?= $proposta->idproposta->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($proposta->dt_cadastro->Visible) { // dt_cadastro ?>
        <tr id="r_dt_cadastro"<?= $proposta->dt_cadastro->rowAttributes() ?>>
            <td class="<?= $proposta->TableLeftColumnClass ?>"><?= $proposta->dt_cadastro->caption() ?></td>
            <td<?= $proposta->dt_cadastro->cellAttributes() ?>>
<span id="el_proposta_dt_cadastro">
<span<?= $proposta->dt_cadastro->viewAttributes() ?>>
<?= $proposta->dt_cadastro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($proposta->cliente_idcliente->Visible) { // cliente_idcliente ?>
        <tr id="r_cliente_idcliente"<?= $proposta->cliente_idcliente->rowAttributes() ?>>
            <td class="<?= $proposta->TableLeftColumnClass ?>"><?= $proposta->cliente_idcliente->caption() ?></td>
            <td<?= $proposta->cliente_idcliente->cellAttributes() ?>>
<span id="el_proposta_cliente_idcliente">
<span<?= $proposta->cliente_idcliente->viewAttributes() ?>>
<?= $proposta->cliente_idcliente->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($proposta->validade->Visible) { // validade ?>
        <tr id="r_validade"<?= $proposta->validade->rowAttributes() ?>>
            <td class="<?= $proposta->TableLeftColumnClass ?>"><?= $proposta->validade->caption() ?></td>
            <td<?= $proposta->validade->cellAttributes() ?>>
<span id="el_proposta_validade">
<span<?= $proposta->validade->viewAttributes() ?>>
<?= $proposta->validade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($proposta->mes_ano_conv_coletiva->Visible) { // mes_ano_conv_coletiva ?>
        <tr id="r_mes_ano_conv_coletiva"<?= $proposta->mes_ano_conv_coletiva->rowAttributes() ?>>
            <td class="<?= $proposta->TableLeftColumnClass ?>"><?= $proposta->mes_ano_conv_coletiva->caption() ?></td>
            <td<?= $proposta->mes_ano_conv_coletiva->cellAttributes() ?>>
<span id="el_proposta_mes_ano_conv_coletiva">
<span<?= $proposta->mes_ano_conv_coletiva->viewAttributes() ?>>
<?= $proposta->mes_ano_conv_coletiva->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($proposta->sindicato->Visible) { // sindicato ?>
        <tr id="r_sindicato"<?= $proposta->sindicato->rowAttributes() ?>>
            <td class="<?= $proposta->TableLeftColumnClass ?>"><?= $proposta->sindicato->caption() ?></td>
            <td<?= $proposta->sindicato->cellAttributes() ?>>
<span id="el_proposta_sindicato">
<span<?= $proposta->sindicato->viewAttributes() ?>>
<?= $proposta->sindicato->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($proposta->cidade->Visible) { // cidade ?>
        <tr id="r_cidade"<?= $proposta->cidade->rowAttributes() ?>>
            <td class="<?= $proposta->TableLeftColumnClass ?>"><?= $proposta->cidade->caption() ?></td>
            <td<?= $proposta->cidade->cellAttributes() ?>>
<span id="el_proposta_cidade">
<span<?= $proposta->cidade->viewAttributes() ?>>
<?= $proposta->cidade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($proposta->nr_meses->Visible) { // nr_meses ?>
        <tr id="r_nr_meses"<?= $proposta->nr_meses->rowAttributes() ?>>
            <td class="<?= $proposta->TableLeftColumnClass ?>"><?= $proposta->nr_meses->caption() ?></td>
            <td<?= $proposta->nr_meses->cellAttributes() ?>>
<span id="el_proposta_nr_meses">
<span<?= $proposta->nr_meses->viewAttributes() ?>>
<?= $proposta->nr_meses->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($proposta->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <tr id="r_usuario_idusuario"<?= $proposta->usuario_idusuario->rowAttributes() ?>>
            <td class="<?= $proposta->TableLeftColumnClass ?>"><?= $proposta->usuario_idusuario->caption() ?></td>
            <td<?= $proposta->usuario_idusuario->cellAttributes() ?>>
<span id="el_proposta_usuario_idusuario">
<span<?= $proposta->usuario_idusuario->viewAttributes() ?>>
<?= $proposta->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
