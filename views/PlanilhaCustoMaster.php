<?php

namespace PHPMaker2024\contratos;

// Table
$planilha_custo = Container("planilha_custo");
$planilha_custo->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($planilha_custo->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_planilha_customaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($planilha_custo->idplanilha_custo->Visible) { // idplanilha_custo ?>
        <tr id="r_idplanilha_custo"<?= $planilha_custo->idplanilha_custo->rowAttributes() ?>>
            <td class="<?= $planilha_custo->TableLeftColumnClass ?>"><?= $planilha_custo->idplanilha_custo->caption() ?></td>
            <td<?= $planilha_custo->idplanilha_custo->cellAttributes() ?>>
<span id="el_planilha_custo_idplanilha_custo">
<span<?= $planilha_custo->idplanilha_custo->viewAttributes() ?>>
<?= $planilha_custo->idplanilha_custo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($planilha_custo->proposta_idproposta->Visible) { // proposta_idproposta ?>
        <tr id="r_proposta_idproposta"<?= $planilha_custo->proposta_idproposta->rowAttributes() ?>>
            <td class="<?= $planilha_custo->TableLeftColumnClass ?>"><?= $planilha_custo->proposta_idproposta->caption() ?></td>
            <td<?= $planilha_custo->proposta_idproposta->cellAttributes() ?>>
<span id="el_planilha_custo_proposta_idproposta">
<span<?= $planilha_custo->proposta_idproposta->viewAttributes() ?>>
<?= $planilha_custo->proposta_idproposta->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($planilha_custo->escala_idescala->Visible) { // escala_idescala ?>
        <tr id="r_escala_idescala"<?= $planilha_custo->escala_idescala->rowAttributes() ?>>
            <td class="<?= $planilha_custo->TableLeftColumnClass ?>"><?= $planilha_custo->escala_idescala->caption() ?></td>
            <td<?= $planilha_custo->escala_idescala->cellAttributes() ?>>
<span id="el_planilha_custo_escala_idescala">
<span<?= $planilha_custo->escala_idescala->viewAttributes() ?>>
<?= $planilha_custo->escala_idescala->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($planilha_custo->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
        <tr id="r_periodo_idperiodo"<?= $planilha_custo->periodo_idperiodo->rowAttributes() ?>>
            <td class="<?= $planilha_custo->TableLeftColumnClass ?>"><?= $planilha_custo->periodo_idperiodo->caption() ?></td>
            <td<?= $planilha_custo->periodo_idperiodo->cellAttributes() ?>>
<span id="el_planilha_custo_periodo_idperiodo">
<span<?= $planilha_custo->periodo_idperiodo->viewAttributes() ?>>
<?= $planilha_custo->periodo_idperiodo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($planilha_custo->tipo_intrajornada_idtipo_intrajornada->Visible) { // tipo_intrajornada_idtipo_intrajornada ?>
        <tr id="r_tipo_intrajornada_idtipo_intrajornada"<?= $planilha_custo->tipo_intrajornada_idtipo_intrajornada->rowAttributes() ?>>
            <td class="<?= $planilha_custo->TableLeftColumnClass ?>"><?= $planilha_custo->tipo_intrajornada_idtipo_intrajornada->caption() ?></td>
            <td<?= $planilha_custo->tipo_intrajornada_idtipo_intrajornada->cellAttributes() ?>>
<span id="el_planilha_custo_tipo_intrajornada_idtipo_intrajornada">
<span<?= $planilha_custo->tipo_intrajornada_idtipo_intrajornada->viewAttributes() ?>>
<?= $planilha_custo->tipo_intrajornada_idtipo_intrajornada->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($planilha_custo->cargo_idcargo->Visible) { // cargo_idcargo ?>
        <tr id="r_cargo_idcargo"<?= $planilha_custo->cargo_idcargo->rowAttributes() ?>>
            <td class="<?= $planilha_custo->TableLeftColumnClass ?>"><?= $planilha_custo->cargo_idcargo->caption() ?></td>
            <td<?= $planilha_custo->cargo_idcargo->cellAttributes() ?>>
<span id="el_planilha_custo_cargo_idcargo">
<span<?= $planilha_custo->cargo_idcargo->viewAttributes() ?>>
<?= $planilha_custo->cargo_idcargo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($planilha_custo->acumulo_funcao->Visible) { // acumulo_funcao ?>
        <tr id="r_acumulo_funcao"<?= $planilha_custo->acumulo_funcao->rowAttributes() ?>>
            <td class="<?= $planilha_custo->TableLeftColumnClass ?>"><?= $planilha_custo->acumulo_funcao->caption() ?></td>
            <td<?= $planilha_custo->acumulo_funcao->cellAttributes() ?>>
<span id="el_planilha_custo_acumulo_funcao">
<span<?= $planilha_custo->acumulo_funcao->viewAttributes() ?>>
<?= $planilha_custo->acumulo_funcao->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($planilha_custo->quantidade->Visible) { // quantidade ?>
        <tr id="r_quantidade"<?= $planilha_custo->quantidade->rowAttributes() ?>>
            <td class="<?= $planilha_custo->TableLeftColumnClass ?>"><?= $planilha_custo->quantidade->caption() ?></td>
            <td<?= $planilha_custo->quantidade->cellAttributes() ?>>
<span id="el_planilha_custo_quantidade">
<span<?= $planilha_custo->quantidade->viewAttributes() ?>>
<?= $planilha_custo->quantidade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
