<div style="display:flex;">
    <div class="col-md-6">
        <div class="mb-3 card">
            <div class="card-header card-header-spotlight">
                <i class="fas fa-question-square"></i>&nbsp;Preguntas Abiertas
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3 widget-content" style="border-style: inset;">
                            <div class="widget-content-wrapper" style="padding: 20px;">
                                <div class="widget-content-left">
                                    <div class="widget-heading"><strong>¿Qué tanto te ha afectado la cuarentena?</strong></div>
                                    <div class="widget-subheading">El <strong>75%</strong> de encuestados respondieron esta pregunta.</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-primary"><span>75%</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 widget-content" style="border-style: inset;">
                            <div class="widget-content-wrapper" style="padding: 20px;">
                                <div class="widget-content-left">
                                    <div class="widget-heading"><strong>¿Has pensado en realizar servicios de delivery?</strong></div>
                                    <div class="widget-subheading">El <strong>90%</strong> de encuestados respondieron esta pregunta.</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-primary"><span>90%</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3 card">
            <div class="card-header card-header-spotlight">
                <i class="fas fa-question-square"></i>&nbsp;Preguntas con Respuesta Única
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($graficosPieAC as $key => $value) { ?>
                        <div class="col-md-6">
                            <div id="containerPie<?= $key ?>" style="height: 14rem;">
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header card-header-spotlight">
            <i class="fas fa-question-square"></i>&nbsp;Preguntas con Respuesta Múltiple
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($graficosColumnAC as $key => $value) { ?>
                    <div class="col-md-12">
                        <div id="containerColumn<?= $key ?>" style="height: 14rem;">
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header card-header-spotlight">
            <i class="fas fa-question-square"></i>&nbsp;Preguntas con Respuesta Múltiple (Barras)
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($graficosColumnAC as $key => $value) { ?>
                    <div class="col-md-6">
                        <div id="containerBar<?= $key ?>" style="height: 50rem;">
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>