<?php

namespace PHPMaker2024\contratos;

// Page object
$CargoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cargo: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fcargoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcargoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["cargo", [fields.cargo.visible && fields.cargo.required ? ew.Validators.required(fields.cargo.caption) : null], fields.cargo.isInvalid],
            ["abreviado", [fields.abreviado.visible && fields.abreviado.required ? ew.Validators.required(fields.abreviado.caption) : null], fields.abreviado.isInvalid],
            ["funcao_idfuncao", [fields.funcao_idfuncao.visible && fields.funcao_idfuncao.required ? ew.Validators.required(fields.funcao_idfuncao.caption) : null], fields.funcao_idfuncao.isInvalid],
            ["salario", [fields.salario.visible && fields.salario.required ? ew.Validators.required(fields.salario.caption) : null, ew.Validators.float], fields.salario.isInvalid],
            ["tipo_uniforme_idtipo_uniforme", [fields.tipo_uniforme_idtipo_uniforme.visible && fields.tipo_uniforme_idtipo_uniforme.required ? ew.Validators.required(fields.tipo_uniforme_idtipo_uniforme.caption) : null], fields.tipo_uniforme_idtipo_uniforme.isInvalid],
            ["escala_idescala", [fields.escala_idescala.visible && fields.escala_idescala.required ? ew.Validators.required(fields.escala_idescala.caption) : null], fields.escala_idescala.isInvalid],
            ["periodo_idperiodo", [fields.periodo_idperiodo.visible && fields.periodo_idperiodo.required ? ew.Validators.required(fields.periodo_idperiodo.caption) : null], fields.periodo_idperiodo.isInvalid],
            ["jornada", [fields.jornada.visible && fields.jornada.required ? ew.Validators.required(fields.jornada.caption) : null, ew.Validators.float], fields.jornada.isInvalid],
            ["nr_horas_mes", [fields.nr_horas_mes.visible && fields.nr_horas_mes.required ? ew.Validators.required(fields.nr_horas_mes.caption) : null, ew.Validators.range(192, 220)], fields.nr_horas_mes.isInvalid],
            ["nr_horas_ad_noite", [fields.nr_horas_ad_noite.visible && fields.nr_horas_ad_noite.required ? ew.Validators.required(fields.nr_horas_ad_noite.caption) : null, ew.Validators.range(0, 7)], fields.nr_horas_ad_noite.isInvalid],
            ["intrajornada", [fields.intrajornada.visible && fields.intrajornada.required ? ew.Validators.required(fields.intrajornada.caption) : null], fields.intrajornada.isInvalid],
            ["vt_dia", [fields.vt_dia.visible && fields.vt_dia.required ? ew.Validators.required(fields.vt_dia.caption) : null, ew.Validators.float], fields.vt_dia.isInvalid],
            ["vr_dia", [fields.vr_dia.visible && fields.vr_dia.required ? ew.Validators.required(fields.vr_dia.caption) : null, ew.Validators.float], fields.vr_dia.isInvalid],
            ["va_mes", [fields.va_mes.visible && fields.va_mes.required ? ew.Validators.required(fields.va_mes.caption) : null, ew.Validators.float], fields.va_mes.isInvalid],
            ["benef_social", [fields.benef_social.visible && fields.benef_social.required ? ew.Validators.required(fields.benef_social.caption) : null, ew.Validators.float], fields.benef_social.isInvalid],
            ["plr", [fields.plr.visible && fields.plr.required ? ew.Validators.required(fields.plr.caption) : null, ew.Validators.float], fields.plr.isInvalid],
            ["assis_medica", [fields.assis_medica.visible && fields.assis_medica.required ? ew.Validators.required(fields.assis_medica.caption) : null, ew.Validators.float], fields.assis_medica.isInvalid],
            ["assis_odonto", [fields.assis_odonto.visible && fields.assis_odonto.required ? ew.Validators.required(fields.assis_odonto.caption) : null, ew.Validators.float], fields.assis_odonto.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code in JAVASCRIPT here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Multi-Page
        .setMultiPage(true)

        // Dynamic selection lists
        .setLists({
            "funcao_idfuncao": <?= $Page->funcao_idfuncao->toClientList($Page) ?>,
            "tipo_uniforme_idtipo_uniforme": <?= $Page->tipo_uniforme_idtipo_uniforme->toClientList($Page) ?>,
            "escala_idescala": <?= $Page->escala_idescala->toClientList($Page) ?>,
            "periodo_idperiodo": <?= $Page->periodo_idperiodo->toClientList($Page) ?>,
            "intrajornada": <?= $Page->intrajornada->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcargoadd" id="fcargoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cargo">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_CargoAdd"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_cargo1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_cargo1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_cargo2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_cargo2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(3) ?>" data-bs-target="#tab_cargo3" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_cargo3" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(3)) ?>"><?= $Page->pageCaption(3) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_cargo1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->cargo->Visible) { // cargo ?>
    <div id="r_cargo"<?= $Page->cargo->rowAttributes() ?>>
        <label id="elh_cargo_cargo" for="x_cargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cargo->caption() ?><?= $Page->cargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cargo->cellAttributes() ?>>
<span id="el_cargo_cargo">
<input type="<?= $Page->cargo->getInputTextType() ?>" name="x_cargo" id="x_cargo" data-table="cargo" data-field="x_cargo" value="<?= $Page->cargo->EditValue ?>" data-page="1" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->cargo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cargo->formatPattern()) ?>"<?= $Page->cargo->editAttributes() ?> aria-describedby="x_cargo_help">
<?= $Page->cargo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cargo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->abreviado->Visible) { // abreviado ?>
    <div id="r_abreviado"<?= $Page->abreviado->rowAttributes() ?>>
        <label id="elh_cargo_abreviado" for="x_abreviado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->abreviado->caption() ?><?= $Page->abreviado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->abreviado->cellAttributes() ?>>
<span id="el_cargo_abreviado">
<input type="<?= $Page->abreviado->getInputTextType() ?>" name="x_abreviado" id="x_abreviado" data-table="cargo" data-field="x_abreviado" value="<?= $Page->abreviado->EditValue ?>" data-page="1" size="25" maxlength="25" placeholder="<?= HtmlEncode($Page->abreviado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->abreviado->formatPattern()) ?>"<?= $Page->abreviado->editAttributes() ?> aria-describedby="x_abreviado_help">
<?= $Page->abreviado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->abreviado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->funcao_idfuncao->Visible) { // funcao_idfuncao ?>
    <div id="r_funcao_idfuncao"<?= $Page->funcao_idfuncao->rowAttributes() ?>>
        <label id="elh_cargo_funcao_idfuncao" for="x_funcao_idfuncao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->funcao_idfuncao->caption() ?><?= $Page->funcao_idfuncao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->funcao_idfuncao->cellAttributes() ?>>
<span id="el_cargo_funcao_idfuncao">
    <select
        id="x_funcao_idfuncao"
        name="x_funcao_idfuncao"
        class="form-control ew-select<?= $Page->funcao_idfuncao->isInvalidClass() ?>"
        data-select2-id="fcargoadd_x_funcao_idfuncao"
        data-table="cargo"
        data-field="x_funcao_idfuncao"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->funcao_idfuncao->caption())) ?>"
        data-modal-lookup="true"
        data-page="1"
        data-value-separator="<?= $Page->funcao_idfuncao->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->funcao_idfuncao->getPlaceHolder()) ?>"
        <?= $Page->funcao_idfuncao->editAttributes() ?>>
        <?= $Page->funcao_idfuncao->selectOptionListHtml("x_funcao_idfuncao") ?>
    </select>
    <?= $Page->funcao_idfuncao->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->funcao_idfuncao->getErrorMessage() ?></div>
<?= $Page->funcao_idfuncao->Lookup->getParamTag($Page, "p_x_funcao_idfuncao") ?>
<script>
loadjs.ready("fcargoadd", function() {
    var options = { name: "x_funcao_idfuncao", selectId: "fcargoadd_x_funcao_idfuncao" };
    if (fcargoadd.lists.funcao_idfuncao?.lookupOptions.length) {
        options.data = { id: "x_funcao_idfuncao", form: "fcargoadd" };
    } else {
        options.ajax = { id: "x_funcao_idfuncao", form: "fcargoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.cargo.fields.funcao_idfuncao.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->salario->Visible) { // salario ?>
    <div id="r_salario"<?= $Page->salario->rowAttributes() ?>>
        <label id="elh_cargo_salario" for="x_salario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->salario->caption() ?><?= $Page->salario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->salario->cellAttributes() ?>>
<span id="el_cargo_salario">
<input type="<?= $Page->salario->getInputTextType() ?>" name="x_salario" id="x_salario" data-table="cargo" data-field="x_salario" value="<?= $Page->salario->EditValue ?>" data-page="1" size="30" placeholder="<?= HtmlEncode($Page->salario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->salario->formatPattern()) ?>"<?= $Page->salario->editAttributes() ?> aria-describedby="x_salario_help">
<?= $Page->salario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->salario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_uniforme_idtipo_uniforme->Visible) { // tipo_uniforme_idtipo_uniforme ?>
    <div id="r_tipo_uniforme_idtipo_uniforme"<?= $Page->tipo_uniforme_idtipo_uniforme->rowAttributes() ?>>
        <label id="elh_cargo_tipo_uniforme_idtipo_uniforme" for="x_tipo_uniforme_idtipo_uniforme" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_uniforme_idtipo_uniforme->caption() ?><?= $Page->tipo_uniforme_idtipo_uniforme->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_uniforme_idtipo_uniforme->cellAttributes() ?>>
<span id="el_cargo_tipo_uniforme_idtipo_uniforme">
    <select
        id="x_tipo_uniforme_idtipo_uniforme"
        name="x_tipo_uniforme_idtipo_uniforme"
        class="form-control ew-select<?= $Page->tipo_uniforme_idtipo_uniforme->isInvalidClass() ?>"
        data-select2-id="fcargoadd_x_tipo_uniforme_idtipo_uniforme"
        data-table="cargo"
        data-field="x_tipo_uniforme_idtipo_uniforme"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->tipo_uniforme_idtipo_uniforme->caption())) ?>"
        data-modal-lookup="true"
        data-page="1"
        data-value-separator="<?= $Page->tipo_uniforme_idtipo_uniforme->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_uniforme_idtipo_uniforme->getPlaceHolder()) ?>"
        <?= $Page->tipo_uniforme_idtipo_uniforme->editAttributes() ?>>
        <?= $Page->tipo_uniforme_idtipo_uniforme->selectOptionListHtml("x_tipo_uniforme_idtipo_uniforme") ?>
    </select>
    <?= $Page->tipo_uniforme_idtipo_uniforme->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_uniforme_idtipo_uniforme->getErrorMessage() ?></div>
<?= $Page->tipo_uniforme_idtipo_uniforme->Lookup->getParamTag($Page, "p_x_tipo_uniforme_idtipo_uniforme") ?>
<script>
loadjs.ready("fcargoadd", function() {
    var options = { name: "x_tipo_uniforme_idtipo_uniforme", selectId: "fcargoadd_x_tipo_uniforme_idtipo_uniforme" };
    if (fcargoadd.lists.tipo_uniforme_idtipo_uniforme?.lookupOptions.length) {
        options.data = { id: "x_tipo_uniforme_idtipo_uniforme", form: "fcargoadd" };
    } else {
        options.ajax = { id: "x_tipo_uniforme_idtipo_uniforme", form: "fcargoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.cargo.fields.tipo_uniforme_idtipo_uniforme.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_cargo2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->escala_idescala->Visible) { // escala_idescala ?>
    <div id="r_escala_idescala"<?= $Page->escala_idescala->rowAttributes() ?>>
        <label id="elh_cargo_escala_idescala" class="<?= $Page->LeftColumnClass ?>"><?= $Page->escala_idescala->caption() ?><?= $Page->escala_idescala->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->escala_idescala->cellAttributes() ?>>
<span id="el_cargo_escala_idescala">
<template id="tp_x_escala_idescala">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cargo" data-field="x_escala_idescala" name="x_escala_idescala" id="x_escala_idescala"<?= $Page->escala_idescala->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_escala_idescala" class="ew-item-list"></div>
<selection-list hidden
    id="x_escala_idescala"
    name="x_escala_idescala"
    value="<?= HtmlEncode($Page->escala_idescala->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_escala_idescala"
    data-target="dsl_x_escala_idescala"
    data-repeatcolumn="10"
    class="form-control<?= $Page->escala_idescala->isInvalidClass() ?>"
    data-table="cargo"
    data-field="x_escala_idescala"
    data-page="2"
    data-value-separator="<?= $Page->escala_idescala->displayValueSeparatorAttribute() ?>"
    <?= $Page->escala_idescala->editAttributes() ?>></selection-list>
<?= $Page->escala_idescala->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->escala_idescala->getErrorMessage() ?></div>
<?= $Page->escala_idescala->Lookup->getParamTag($Page, "p_x_escala_idescala") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->periodo_idperiodo->Visible) { // periodo_idperiodo ?>
    <div id="r_periodo_idperiodo"<?= $Page->periodo_idperiodo->rowAttributes() ?>>
        <label id="elh_cargo_periodo_idperiodo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periodo_idperiodo->caption() ?><?= $Page->periodo_idperiodo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periodo_idperiodo->cellAttributes() ?>>
<span id="el_cargo_periodo_idperiodo">
<template id="tp_x_periodo_idperiodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cargo" data-field="x_periodo_idperiodo" name="x_periodo_idperiodo" id="x_periodo_idperiodo"<?= $Page->periodo_idperiodo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_periodo_idperiodo" class="ew-item-list"></div>
<selection-list hidden
    id="x_periodo_idperiodo"
    name="x_periodo_idperiodo"
    value="<?= HtmlEncode($Page->periodo_idperiodo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_periodo_idperiodo"
    data-target="dsl_x_periodo_idperiodo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodo_idperiodo->isInvalidClass() ?>"
    data-table="cargo"
    data-field="x_periodo_idperiodo"
    data-page="2"
    data-value-separator="<?= $Page->periodo_idperiodo->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodo_idperiodo->editAttributes() ?>></selection-list>
<?= $Page->periodo_idperiodo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->periodo_idperiodo->getErrorMessage() ?></div>
<?= $Page->periodo_idperiodo->Lookup->getParamTag($Page, "p_x_periodo_idperiodo") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jornada->Visible) { // jornada ?>
    <div id="r_jornada"<?= $Page->jornada->rowAttributes() ?>>
        <label id="elh_cargo_jornada" for="x_jornada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jornada->caption() ?><?= $Page->jornada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->jornada->cellAttributes() ?>>
<span id="el_cargo_jornada">
<input type="<?= $Page->jornada->getInputTextType() ?>" name="x_jornada" id="x_jornada" data-table="cargo" data-field="x_jornada" value="<?= $Page->jornada->EditValue ?>" data-page="2" size="5" maxlength="2" placeholder="<?= HtmlEncode($Page->jornada->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->jornada->formatPattern()) ?>"<?= $Page->jornada->editAttributes() ?> aria-describedby="x_jornada_help">
<?= $Page->jornada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jornada->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nr_horas_mes->Visible) { // nr_horas_mes ?>
    <div id="r_nr_horas_mes"<?= $Page->nr_horas_mes->rowAttributes() ?>>
        <label id="elh_cargo_nr_horas_mes" for="x_nr_horas_mes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nr_horas_mes->caption() ?><?= $Page->nr_horas_mes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nr_horas_mes->cellAttributes() ?>>
<span id="el_cargo_nr_horas_mes">
<input type="<?= $Page->nr_horas_mes->getInputTextType() ?>" name="x_nr_horas_mes" id="x_nr_horas_mes" data-table="cargo" data-field="x_nr_horas_mes" value="<?= $Page->nr_horas_mes->EditValue ?>" data-page="2" size="5" maxlength="3" placeholder="<?= HtmlEncode($Page->nr_horas_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nr_horas_mes->formatPattern()) ?>"<?= $Page->nr_horas_mes->editAttributes() ?> aria-describedby="x_nr_horas_mes_help">
<?= $Page->nr_horas_mes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nr_horas_mes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nr_horas_ad_noite->Visible) { // nr_horas_ad_noite ?>
    <div id="r_nr_horas_ad_noite"<?= $Page->nr_horas_ad_noite->rowAttributes() ?>>
        <label id="elh_cargo_nr_horas_ad_noite" for="x_nr_horas_ad_noite" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nr_horas_ad_noite->caption() ?><?= $Page->nr_horas_ad_noite->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nr_horas_ad_noite->cellAttributes() ?>>
<span id="el_cargo_nr_horas_ad_noite">
<input type="<?= $Page->nr_horas_ad_noite->getInputTextType() ?>" name="x_nr_horas_ad_noite" id="x_nr_horas_ad_noite" data-table="cargo" data-field="x_nr_horas_ad_noite" value="<?= $Page->nr_horas_ad_noite->EditValue ?>" data-page="2" size="5" maxlength="2" placeholder="<?= HtmlEncode($Page->nr_horas_ad_noite->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nr_horas_ad_noite->formatPattern()) ?>"<?= $Page->nr_horas_ad_noite->editAttributes() ?> aria-describedby="x_nr_horas_ad_noite_help">
<?= $Page->nr_horas_ad_noite->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nr_horas_ad_noite->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->intrajornada->Visible) { // intrajornada ?>
    <div id="r_intrajornada"<?= $Page->intrajornada->rowAttributes() ?>>
        <label id="elh_cargo_intrajornada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->intrajornada->caption() ?><?= $Page->intrajornada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->intrajornada->cellAttributes() ?>>
<span id="el_cargo_intrajornada">
<template id="tp_x_intrajornada">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cargo" data-field="x_intrajornada" name="x_intrajornada" id="x_intrajornada"<?= $Page->intrajornada->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_intrajornada" class="ew-item-list"></div>
<selection-list hidden
    id="x_intrajornada"
    name="x_intrajornada"
    value="<?= HtmlEncode($Page->intrajornada->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_intrajornada"
    data-target="dsl_x_intrajornada"
    data-repeatcolumn="5"
    class="form-control<?= $Page->intrajornada->isInvalidClass() ?>"
    data-table="cargo"
    data-field="x_intrajornada"
    data-page="2"
    data-value-separator="<?= $Page->intrajornada->displayValueSeparatorAttribute() ?>"
    <?= $Page->intrajornada->editAttributes() ?>></selection-list>
<?= $Page->intrajornada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->intrajornada->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(3) ?>" id="tab_cargo3" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->vt_dia->Visible) { // vt_dia ?>
    <div id="r_vt_dia"<?= $Page->vt_dia->rowAttributes() ?>>
        <label id="elh_cargo_vt_dia" for="x_vt_dia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vt_dia->caption() ?><?= $Page->vt_dia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vt_dia->cellAttributes() ?>>
<span id="el_cargo_vt_dia">
<input type="<?= $Page->vt_dia->getInputTextType() ?>" name="x_vt_dia" id="x_vt_dia" data-table="cargo" data-field="x_vt_dia" value="<?= $Page->vt_dia->EditValue ?>" data-page="3" size="10" placeholder="<?= HtmlEncode($Page->vt_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vt_dia->formatPattern()) ?>"<?= $Page->vt_dia->editAttributes() ?> aria-describedby="x_vt_dia_help">
<?= $Page->vt_dia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vt_dia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vr_dia->Visible) { // vr_dia ?>
    <div id="r_vr_dia"<?= $Page->vr_dia->rowAttributes() ?>>
        <label id="elh_cargo_vr_dia" for="x_vr_dia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vr_dia->caption() ?><?= $Page->vr_dia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vr_dia->cellAttributes() ?>>
<span id="el_cargo_vr_dia">
<input type="<?= $Page->vr_dia->getInputTextType() ?>" name="x_vr_dia" id="x_vr_dia" data-table="cargo" data-field="x_vr_dia" value="<?= $Page->vr_dia->EditValue ?>" data-page="3" size="10" placeholder="<?= HtmlEncode($Page->vr_dia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vr_dia->formatPattern()) ?>"<?= $Page->vr_dia->editAttributes() ?> aria-describedby="x_vr_dia_help">
<?= $Page->vr_dia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vr_dia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->va_mes->Visible) { // va_mes ?>
    <div id="r_va_mes"<?= $Page->va_mes->rowAttributes() ?>>
        <label id="elh_cargo_va_mes" for="x_va_mes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->va_mes->caption() ?><?= $Page->va_mes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->va_mes->cellAttributes() ?>>
<span id="el_cargo_va_mes">
<input type="<?= $Page->va_mes->getInputTextType() ?>" name="x_va_mes" id="x_va_mes" data-table="cargo" data-field="x_va_mes" value="<?= $Page->va_mes->EditValue ?>" data-page="3" size="10" placeholder="<?= HtmlEncode($Page->va_mes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->va_mes->formatPattern()) ?>"<?= $Page->va_mes->editAttributes() ?> aria-describedby="x_va_mes_help">
<?= $Page->va_mes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->va_mes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->benef_social->Visible) { // benef_social ?>
    <div id="r_benef_social"<?= $Page->benef_social->rowAttributes() ?>>
        <label id="elh_cargo_benef_social" for="x_benef_social" class="<?= $Page->LeftColumnClass ?>"><?= $Page->benef_social->caption() ?><?= $Page->benef_social->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->benef_social->cellAttributes() ?>>
<span id="el_cargo_benef_social">
<input type="<?= $Page->benef_social->getInputTextType() ?>" name="x_benef_social" id="x_benef_social" data-table="cargo" data-field="x_benef_social" value="<?= $Page->benef_social->EditValue ?>" data-page="3" size="10" placeholder="<?= HtmlEncode($Page->benef_social->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->benef_social->formatPattern()) ?>"<?= $Page->benef_social->editAttributes() ?> aria-describedby="x_benef_social_help">
<?= $Page->benef_social->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->benef_social->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->plr->Visible) { // plr ?>
    <div id="r_plr"<?= $Page->plr->rowAttributes() ?>>
        <label id="elh_cargo_plr" for="x_plr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->plr->caption() ?><?= $Page->plr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->plr->cellAttributes() ?>>
<span id="el_cargo_plr">
<input type="<?= $Page->plr->getInputTextType() ?>" name="x_plr" id="x_plr" data-table="cargo" data-field="x_plr" value="<?= $Page->plr->EditValue ?>" data-page="3" size="10" placeholder="<?= HtmlEncode($Page->plr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->plr->formatPattern()) ?>"<?= $Page->plr->editAttributes() ?> aria-describedby="x_plr_help">
<?= $Page->plr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->plr->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->assis_medica->Visible) { // assis_medica ?>
    <div id="r_assis_medica"<?= $Page->assis_medica->rowAttributes() ?>>
        <label id="elh_cargo_assis_medica" for="x_assis_medica" class="<?= $Page->LeftColumnClass ?>"><?= $Page->assis_medica->caption() ?><?= $Page->assis_medica->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->assis_medica->cellAttributes() ?>>
<span id="el_cargo_assis_medica">
<input type="<?= $Page->assis_medica->getInputTextType() ?>" name="x_assis_medica" id="x_assis_medica" data-table="cargo" data-field="x_assis_medica" value="<?= $Page->assis_medica->EditValue ?>" data-page="3" size="10" placeholder="<?= HtmlEncode($Page->assis_medica->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_medica->formatPattern()) ?>"<?= $Page->assis_medica->editAttributes() ?> aria-describedby="x_assis_medica_help">
<?= $Page->assis_medica->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->assis_medica->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->assis_odonto->Visible) { // assis_odonto ?>
    <div id="r_assis_odonto"<?= $Page->assis_odonto->rowAttributes() ?>>
        <label id="elh_cargo_assis_odonto" for="x_assis_odonto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->assis_odonto->caption() ?><?= $Page->assis_odonto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->assis_odonto->cellAttributes() ?>>
<span id="el_cargo_assis_odonto">
<input type="<?= $Page->assis_odonto->getInputTextType() ?>" name="x_assis_odonto" id="x_assis_odonto" data-table="cargo" data-field="x_assis_odonto" value="<?= $Page->assis_odonto->EditValue ?>" data-page="3" size="10" placeholder="<?= HtmlEncode($Page->assis_odonto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->assis_odonto->formatPattern()) ?>"<?= $Page->assis_odonto->editAttributes() ?> aria-describedby="x_assis_odonto_help">
<?= $Page->assis_odonto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->assis_odonto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcargoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcargoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("cargo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
