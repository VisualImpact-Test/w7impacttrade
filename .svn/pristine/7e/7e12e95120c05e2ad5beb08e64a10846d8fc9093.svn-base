<?php
$cantidadVisitasObligatorio = !empty($visitasVisibilidadAuditoria['obligatorio']['visitas']) ? count($visitasVisibilidadAuditoria['obligatorio']['visitas']) : 0;
$cantidadVisitasAdicional = !empty($visitasVisibilidadAuditoria['adicional']['visitas']) ? count($visitasVisibilidadAuditoria['adicional']['visitas']) : 0;
$cantidadVisitasIniciativa = !empty($visitasVisibilidadAuditoria['iniciativa']['visitas']) ? count($visitasVisibilidadAuditoria['iniciativa']['visitas']) : 0;
$cantidadElementosObligatorio = !empty($visitasVisibilidadAuditoria['obligatorio']['elementosVisibilidad']) ? count($visitasVisibilidadAuditoria['obligatorio']['elementosVisibilidad']) : 0;
$cantidadElementosAdicional = !empty($visitasVisibilidadAuditoria['adicional']['elementosVisibilidad']) ? count($visitasVisibilidadAuditoria['adicional']['elementosVisibilidad']) : 0;
$cantidadElementosIniciativa = !empty($visitasVisibilidadAuditoria['iniciativa']['elementosVisibilidad']) ? count($visitasVisibilidadAuditoria['iniciativa']['elementosVisibilidad']) : 0;
?>

<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <ul class="nav">
                <li class="nav-item"><a data-toggle="tab" href="#visibilidadAuditoriaObligatorio" class="nav-link show active">Vis. Auditoria Obligatorio <span class="badge badge-secondary"><?= $cantidadVisitasObligatorio ?> Visitas | <?= $cantidadElementosObligatorio ?> Elementos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#visibilidadAuditoriaIniciativa" class="nav-link show">Vis. Auditoria Iniciativa <span class="badge badge-secondary"><?= $cantidadVisitasIniciativa ?> Visitas | <?= $cantidadElementosIniciativa ?> Elementos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#visibilidadAuditoriaAdicional" class="nav-link show">Vis. Auditoria Adicional <span class="badge badge-secondary"><?= $cantidadVisitasAdicional ?> Visitas | <?= $cantidadElementosAdicional ?> Elementos</span></a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane show active" id="visibilidadAuditoriaObligatorio" role="tabpanel">
                </div>
                <div class="tab-pane show" id="visibilidadAuditoriaIniciativa" role="tabpanel">
                </div>
                <div class="tab-pane show" id="visibilidadAuditoriaAdicional" role="tabpanel">
                </div>
            </div>
        </div>
    </div>
</div>