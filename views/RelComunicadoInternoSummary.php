<?php

namespace PHPMaker2024\contratos;

// Page object
$RelComunicadoInternoSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_comunicado_interno: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<a id="top"></a>
<!-- Content Container -->
<div id="ew-report" class="ew-report container-fluid">
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
    $Page->FilterOptions->render("body");
}
?>
</div>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<form name="frel_comunicado_internosrch" id="frel_comunicado_internosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_comunicado_internosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_comunicado_interno: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_comunicado_internosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_comunicado_internosrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idproposta", [], fields.idproposta.isInvalid]
        ])
        // Validate form
        .setValidate(
            async function () {
                if (!this.validateRequired)
                    return true; // Ignore validation
                let fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
                return true;
            }
        )

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code in JAVASCRIPT here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "idproposta": <?= $Page->idproposta->toClientList($Page) ?>,
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = RowType::SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->idproposta->Visible) { // idproposta ?>
<?php
if (!$Page->idproposta->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_idproposta" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->idproposta->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_idproposta" class="ew-search-caption ew-label"><?= $Page->idproposta->caption() ?></label>
        </div>
        <div id="el_rel_comunicado_interno_idproposta" class="ew-search-field">
    <select
        id="x_idproposta"
        name="x_idproposta"
        class="form-select ew-select<?= $Page->idproposta->isInvalidClass() ?>"
        <?php if (!$Page->idproposta->IsNativeSelect) { ?>
        data-select2-id="frel_comunicado_internosrch_x_idproposta"
        <?php } ?>
        data-table="rel_comunicado_interno"
        data-field="x_idproposta"
        data-value-separator="<?= $Page->idproposta->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idproposta->getPlaceHolder()) ?>"
        <?= $Page->idproposta->editAttributes() ?>>
        <?= $Page->idproposta->selectOptionListHtml("x_idproposta") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->idproposta->getErrorMessage() ?></div>
<?= $Page->idproposta->Lookup->getParamTag($Page, "p_x_idproposta") ?>
<?php if (!$Page->idproposta->IsNativeSelect) { ?>
<script>
loadjs.ready("frel_comunicado_internosrch", function() {
    var options = { name: "x_idproposta", selectId: "frel_comunicado_internosrch_x_idproposta" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frel_comunicado_internosrch.lists.idproposta?.lookupOptions.length) {
        options.data = { id: "x_idproposta", form: "frel_comunicado_internosrch" };
    } else {
        options.ajax = { id: "x_idproposta", form: "frel_comunicado_internosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.rel_comunicado_interno.fields.idproposta.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->ShowReport) { ?>
<!-- Summary report (begin) -->
<main class="report-summary<?= ($Page->TotalGroups == 0) ? " ew-no-record" : "" ?>">
<?php
while ($Page->RecordCount < count($Page->DetailRecords) && $Page->RecordCount < $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<div class="<?= $Page->ReportContainerClass ?>">
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Top pager -->
<div class="card-header ew-grid-upper-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_rel_comunicado_interno" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->idproposta->Visible) { ?>
    <th data-name="idproposta" class="<?= $Page->idproposta->headerCellClass() ?>"><div class="rel_comunicado_interno_idproposta"><?= $Page->renderFieldHeader($Page->idproposta) ?></div></th>
<?php } ?>
<?php if ($Page->dt_proposta->Visible) { ?>
    <th data-name="dt_proposta" class="<?= $Page->dt_proposta->headerCellClass() ?>"><div class="rel_comunicado_interno_dt_proposta"><?= $Page->renderFieldHeader($Page->dt_proposta) ?></div></th>
<?php } ?>
<?php if ($Page->consultor->Visible) { ?>
    <th data-name="consultor" class="<?= $Page->consultor->headerCellClass() ?>"><div class="rel_comunicado_interno_consultor"><?= $Page->renderFieldHeader($Page->consultor) ?></div></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
    <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div class="rel_comunicado_interno_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->cnpj_cli->Visible) { ?>
    <th data-name="cnpj_cli" class="<?= $Page->cnpj_cli->headerCellClass() ?>"><div class="rel_comunicado_interno_cnpj_cli"><?= $Page->renderFieldHeader($Page->cnpj_cli) ?></div></th>
<?php } ?>
<?php if ($Page->end_cli->Visible) { ?>
    <th data-name="end_cli" class="<?= $Page->end_cli->headerCellClass() ?>"><div class="rel_comunicado_interno_end_cli"><?= $Page->renderFieldHeader($Page->end_cli) ?></div></th>
<?php } ?>
<?php if ($Page->nr_cli->Visible) { ?>
    <th data-name="nr_cli" class="<?= $Page->nr_cli->headerCellClass() ?>"><div class="rel_comunicado_interno_nr_cli"><?= $Page->renderFieldHeader($Page->nr_cli) ?></div></th>
<?php } ?>
<?php if ($Page->bairro_cli->Visible) { ?>
    <th data-name="bairro_cli" class="<?= $Page->bairro_cli->headerCellClass() ?>"><div class="rel_comunicado_interno_bairro_cli"><?= $Page->renderFieldHeader($Page->bairro_cli) ?></div></th>
<?php } ?>
<?php if ($Page->cep_cli->Visible) { ?>
    <th data-name="cep_cli" class="<?= $Page->cep_cli->headerCellClass() ?>"><div class="rel_comunicado_interno_cep_cli"><?= $Page->renderFieldHeader($Page->cep_cli) ?></div></th>
<?php } ?>
<?php if ($Page->cidade_cli->Visible) { ?>
    <th data-name="cidade_cli" class="<?= $Page->cidade_cli->headerCellClass() ?>"><div class="rel_comunicado_interno_cidade_cli"><?= $Page->renderFieldHeader($Page->cidade_cli) ?></div></th>
<?php } ?>
<?php if ($Page->uf_cli->Visible) { ?>
    <th data-name="uf_cli" class="<?= $Page->uf_cli->headerCellClass() ?>"><div class="rel_comunicado_interno_uf_cli"><?= $Page->renderFieldHeader($Page->uf_cli) ?></div></th>
<?php } ?>
<?php if ($Page->contato_cli->Visible) { ?>
    <th data-name="contato_cli" class="<?= $Page->contato_cli->headerCellClass() ?>"><div class="rel_comunicado_interno_contato_cli"><?= $Page->renderFieldHeader($Page->contato_cli) ?></div></th>
<?php } ?>
<?php if ($Page->email_cli->Visible) { ?>
    <th data-name="email_cli" class="<?= $Page->email_cli->headerCellClass() ?>"><div class="rel_comunicado_interno_email_cli"><?= $Page->renderFieldHeader($Page->email_cli) ?></div></th>
<?php } ?>
<?php if ($Page->tel_cli->Visible) { ?>
    <th data-name="tel_cli" class="<?= $Page->tel_cli->headerCellClass() ?>"><div class="rel_comunicado_interno_tel_cli"><?= $Page->renderFieldHeader($Page->tel_cli) ?></div></th>
<?php } ?>
<?php if ($Page->faturamento->Visible) { ?>
    <th data-name="faturamento" class="<?= $Page->faturamento->headerCellClass() ?>"><div class="rel_comunicado_interno_faturamento"><?= $Page->renderFieldHeader($Page->faturamento) ?></div></th>
<?php } ?>
<?php if ($Page->cnpj_fat->Visible) { ?>
    <th data-name="cnpj_fat" class="<?= $Page->cnpj_fat->headerCellClass() ?>"><div class="rel_comunicado_interno_cnpj_fat"><?= $Page->renderFieldHeader($Page->cnpj_fat) ?></div></th>
<?php } ?>
<?php if ($Page->end_fat->Visible) { ?>
    <th data-name="end_fat" class="<?= $Page->end_fat->headerCellClass() ?>"><div class="rel_comunicado_interno_end_fat"><?= $Page->renderFieldHeader($Page->end_fat) ?></div></th>
<?php } ?>
<?php if ($Page->bairro_fat->Visible) { ?>
    <th data-name="bairro_fat" class="<?= $Page->bairro_fat->headerCellClass() ?>"><div class="rel_comunicado_interno_bairro_fat"><?= $Page->renderFieldHeader($Page->bairro_fat) ?></div></th>
<?php } ?>
<?php if ($Page->cidae_fat->Visible) { ?>
    <th data-name="cidae_fat" class="<?= $Page->cidae_fat->headerCellClass() ?>"><div class="rel_comunicado_interno_cidae_fat"><?= $Page->renderFieldHeader($Page->cidae_fat) ?></div></th>
<?php } ?>
<?php if ($Page->uf_fat->Visible) { ?>
    <th data-name="uf_fat" class="<?= $Page->uf_fat->headerCellClass() ?>"><div class="rel_comunicado_interno_uf_fat"><?= $Page->renderFieldHeader($Page->uf_fat) ?></div></th>
<?php } ?>
<?php if ($Page->origem_fat->Visible) { ?>
    <th data-name="origem_fat" class="<?= $Page->origem_fat->headerCellClass() ?>"><div class="rel_comunicado_interno_origem_fat"><?= $Page->renderFieldHeader($Page->origem_fat) ?></div></th>
<?php } ?>
<?php if ($Page->dia_vencto_fat->Visible) { ?>
    <th data-name="dia_vencto_fat" class="<?= $Page->dia_vencto_fat->headerCellClass() ?>"><div class="rel_comunicado_interno_dia_vencto_fat"><?= $Page->renderFieldHeader($Page->dia_vencto_fat) ?></div></th>
<?php } ?>
<?php if ($Page->quantidade->Visible) { ?>
    <th data-name="quantidade" class="<?= $Page->quantidade->headerCellClass() ?>"><div class="rel_comunicado_interno_quantidade"><?= $Page->renderFieldHeader($Page->quantidade) ?></div></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
    <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div class="rel_comunicado_interno_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->escala->Visible) { ?>
    <th data-name="escala" class="<?= $Page->escala->headerCellClass() ?>"><div class="rel_comunicado_interno_escala"><?= $Page->renderFieldHeader($Page->escala) ?></div></th>
<?php } ?>
<?php if ($Page->periodo->Visible) { ?>
    <th data-name="periodo" class="<?= $Page->periodo->headerCellClass() ?>"><div class="rel_comunicado_interno_periodo"><?= $Page->renderFieldHeader($Page->periodo) ?></div></th>
<?php } ?>
<?php if ($Page->intrajornada_tipo->Visible) { ?>
    <th data-name="intrajornada_tipo" class="<?= $Page->intrajornada_tipo->headerCellClass() ?>"><div class="rel_comunicado_interno_intrajornada_tipo"><?= $Page->renderFieldHeader($Page->intrajornada_tipo) ?></div></th>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { ?>
    <th data-name="acumulo_funcao" class="<?= $Page->acumulo_funcao->headerCellClass() ?>"><div class="rel_comunicado_interno_acumulo_funcao"><?= $Page->renderFieldHeader($Page->acumulo_funcao) ?></div></th>
<?php } ?>
    </tr>
</thead>
<tbody>
<?php
        if ($Page->TotalGroups == 0) {
            break; // Show header only
        }
        $Page->ShowHeader = false;
    } // End show header
?>
<?php
    $Page->loadRowValues($Page->DetailRecords[$Page->RecordCount]);
    $Page->RecordCount++;
    $Page->RecordIndex++;
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = RowType::DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idproposta->Visible) { ?>
        <td data-field="idproposta"<?= $Page->idproposta->cellAttributes() ?>>
<span<?= $Page->idproposta->viewAttributes() ?>>
<?= $Page->idproposta->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dt_proposta->Visible) { ?>
        <td data-field="dt_proposta"<?= $Page->dt_proposta->cellAttributes() ?>>
<span<?= $Page->dt_proposta->viewAttributes() ?>>
<?= $Page->dt_proposta->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->consultor->Visible) { ?>
        <td data-field="consultor"<?= $Page->consultor->cellAttributes() ?>>
<span<?= $Page->consultor->viewAttributes() ?>>
<?= $Page->consultor->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cliente->Visible) { ?>
        <td data-field="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cnpj_cli->Visible) { ?>
        <td data-field="cnpj_cli"<?= $Page->cnpj_cli->cellAttributes() ?>>
<span<?= $Page->cnpj_cli->viewAttributes() ?>>
<?= $Page->cnpj_cli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->end_cli->Visible) { ?>
        <td data-field="end_cli"<?= $Page->end_cli->cellAttributes() ?>>
<span<?= $Page->end_cli->viewAttributes() ?>>
<?= $Page->end_cli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nr_cli->Visible) { ?>
        <td data-field="nr_cli"<?= $Page->nr_cli->cellAttributes() ?>>
<span<?= $Page->nr_cli->viewAttributes() ?>>
<?= $Page->nr_cli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bairro_cli->Visible) { ?>
        <td data-field="bairro_cli"<?= $Page->bairro_cli->cellAttributes() ?>>
<span<?= $Page->bairro_cli->viewAttributes() ?>>
<?= $Page->bairro_cli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cep_cli->Visible) { ?>
        <td data-field="cep_cli"<?= $Page->cep_cli->cellAttributes() ?>>
<span<?= $Page->cep_cli->viewAttributes() ?>>
<?= $Page->cep_cli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cidade_cli->Visible) { ?>
        <td data-field="cidade_cli"<?= $Page->cidade_cli->cellAttributes() ?>>
<span<?= $Page->cidade_cli->viewAttributes() ?>>
<?= $Page->cidade_cli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->uf_cli->Visible) { ?>
        <td data-field="uf_cli"<?= $Page->uf_cli->cellAttributes() ?>>
<span<?= $Page->uf_cli->viewAttributes() ?>>
<?= $Page->uf_cli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->contato_cli->Visible) { ?>
        <td data-field="contato_cli"<?= $Page->contato_cli->cellAttributes() ?>>
<span<?= $Page->contato_cli->viewAttributes() ?>>
<?= $Page->contato_cli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->email_cli->Visible) { ?>
        <td data-field="email_cli"<?= $Page->email_cli->cellAttributes() ?>>
<span<?= $Page->email_cli->viewAttributes() ?>>
<?= $Page->email_cli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tel_cli->Visible) { ?>
        <td data-field="tel_cli"<?= $Page->tel_cli->cellAttributes() ?>>
<span<?= $Page->tel_cli->viewAttributes() ?>>
<?= $Page->tel_cli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->faturamento->Visible) { ?>
        <td data-field="faturamento"<?= $Page->faturamento->cellAttributes() ?>>
<span<?= $Page->faturamento->viewAttributes() ?>>
<?= $Page->faturamento->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cnpj_fat->Visible) { ?>
        <td data-field="cnpj_fat"<?= $Page->cnpj_fat->cellAttributes() ?>>
<span<?= $Page->cnpj_fat->viewAttributes() ?>>
<?= $Page->cnpj_fat->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->end_fat->Visible) { ?>
        <td data-field="end_fat"<?= $Page->end_fat->cellAttributes() ?>>
<span<?= $Page->end_fat->viewAttributes() ?>>
<?= $Page->end_fat->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bairro_fat->Visible) { ?>
        <td data-field="bairro_fat"<?= $Page->bairro_fat->cellAttributes() ?>>
<span<?= $Page->bairro_fat->viewAttributes() ?>>
<?= $Page->bairro_fat->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cidae_fat->Visible) { ?>
        <td data-field="cidae_fat"<?= $Page->cidae_fat->cellAttributes() ?>>
<span<?= $Page->cidae_fat->viewAttributes() ?>>
<?= $Page->cidae_fat->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->uf_fat->Visible) { ?>
        <td data-field="uf_fat"<?= $Page->uf_fat->cellAttributes() ?>>
<span<?= $Page->uf_fat->viewAttributes() ?>>
<?= $Page->uf_fat->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->origem_fat->Visible) { ?>
        <td data-field="origem_fat"<?= $Page->origem_fat->cellAttributes() ?>>
<span<?= $Page->origem_fat->viewAttributes() ?>>
<?= $Page->origem_fat->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dia_vencto_fat->Visible) { ?>
        <td data-field="dia_vencto_fat"<?= $Page->dia_vencto_fat->cellAttributes() ?>>
<span<?= $Page->dia_vencto_fat->viewAttributes() ?>>
<?= $Page->dia_vencto_fat->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->quantidade->Visible) { ?>
        <td data-field="quantidade"<?= $Page->quantidade->cellAttributes() ?>>
<span<?= $Page->quantidade->viewAttributes() ?>>
<?= $Page->quantidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cargo->Visible) { ?>
        <td data-field="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->escala->Visible) { ?>
        <td data-field="escala"<?= $Page->escala->cellAttributes() ?>>
<span<?= $Page->escala->viewAttributes() ?>>
<?= $Page->escala->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->periodo->Visible) { ?>
        <td data-field="periodo"<?= $Page->periodo->cellAttributes() ?>>
<span<?= $Page->periodo->viewAttributes() ?>>
<?= $Page->periodo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->intrajornada_tipo->Visible) { ?>
        <td data-field="intrajornada_tipo"<?= $Page->intrajornada_tipo->cellAttributes() ?>>
<span<?= $Page->intrajornada_tipo->viewAttributes() ?>>
<?= $Page->intrajornada_tipo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->acumulo_funcao->Visible) { ?>
        <td data-field="acumulo_funcao"<?= $Page->acumulo_funcao->cellAttributes() ?>>
<span<?= $Page->acumulo_funcao->viewAttributes() ?>>
<?= $Page->acumulo_funcao->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
<?php
    $Page->resetAttributes();
    $Page->RowType = RowType::TOTAL;
    $Page->RowTotalType = RowSummary::GRAND;
    $Page->RowTotalSubType = RowTotal::FOOTER;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
<?php if ($Page->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
<?php } ?>
</tfoot>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if ($Page->TotalGroups > 0) { ?>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
</main>
<!-- /.report-summary -->
<!-- Summary report (end) -->
<?php } ?>
</div>
<!-- /.ew-report -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
