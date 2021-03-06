<style>
    #tb-resumen-checkProductos_filter {
        display: none;
    }
    .fixedHeader-floating{
        display: none;
    }
</style>
<div class="card-datatable w-100" style="overflow-x: auto;max-height: 590px;padding:0px !important ">
    <table id="tb-resumen-checkProductos" class=" table table-sm table-bordered nowrap" width="100%" style="font-size: 15px;">
        <thead>
            <tr>
                <th style="text-align:center">CATEGORIA</th>
                <th style="text-align:center">MARCA</th>
                <th style="text-align:center;width:20%">PRODUCTO</th>
                <th style="text-align:center;background-color: lightgray;">PRESENCIA</th>
                <th style="text-align:center;background-color: lightgray;"> % PRESENCIA</th>
                <th style="text-align:center;background-color: lightgray;"> QUIEBRES</th>
                <? foreach ($segs as $idSegs => $segr) : ?>
                    <th style="text-align:center;background-color: #24A23F;color:white"><?= $segr['nombre'] ?></th>
                <? endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <? foreach ($productos as $k => $v) : ?>
                <tr>
                    <td style="text-align:center;"><?= $v['categoria'] ?></td>
                    <td style="text-align:center;"><?= $v['marca'] ?></td>
                    <td style="text-align:left;"><?= $v['producto'] ?></td>
                    <!-- Columnas -->
                    <td style="text-align:center;">
                        <? if (!empty($v['totalPresencia'])) { ?>
                            <a href="javascript:;" class="lk-detalle" data-tipo="presencia" data-id-tipo-reporte = "<?=$v['idTipoReporte']?>" data-fecha = "<?=$v['fecha']?>" data-producto = "<?=$k?>" data-grupocanal = <?=$grupoCanal?> > 
                                <?= $v['totalPresencia'] ?>
                            </a>
                        <? } else echo 0; ?>
                    </td>
                    <td style="text-align:right;"> <?= !empty($tiendasVisitadas['tiendasVisitadas']) && !empty($v['totalPresencia']) ?  get_porcentaje($tiendasVisitadas['tiendasVisitadas'], $v['totalPresencia']) : '0' ?>%</td>
                    <td style="text-align:center;">
                        <? if (!empty($v['totalQuiebres'])) { ?>
                            <a href="javascript:;" class="lk-detalle" data-tipo="quiebre" data-id-tipo-reporte = "<?=$v['idTipoReporte']?>" data-fecha = "<?=$v['fecha']?>" data-producto = "<?=$k?>" data-grupocanal = <?=$grupoCanal?> > 
                                <?= $v['totalQuiebres'] ?>
                            </a>
                        <? } else echo 0; ?>
                    </td>
                    <? foreach ($segs as $idSegs => $segr) : ?>
                        <td style="font-weight: bold;text-align:center;background-color: <?= (!empty($v[$tipoReporte][$idSegs])) && ($v[$tipoReporte][$idSegs] != '-') ? '#7cd360' : 'white' ?>;text-align:center;color: <?= (!empty($v[$tipoReporte][$idSegs])) && ($v[$tipoReporte][$idSegs] != '-') ? 'white' : 'black' ?>">
                            <? if (!empty($v[$tipoReporte][$idSegs]) && ($v[$tipoReporte][$idSegs] != '-')) { ?>
                                <a href="javascript:;" class="lk-detalle" data-tipo="<?=$tipoReporte?>" data-id-tipo-reporte = "<?=$v['idTipoReporte']?>" data-seg = "<?=$idSegs?>" data-fecha = "<?=$v['fecha']?>" data-producto = "<?=$k?>"  data-grupocanal = <?=$grupoCanal?> style="color: white;">
                                    <?= $v[$tipoReporte][$idSegs] ?>
                                </a>
                            <? } else { ?>
                                <span style="color: black;"> - </span>
                            <? } ?>
                        </td>
                    <? endforeach; ?>
                </tr>
            <? endforeach;   ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {


        var org_buildButton = $.fn.DataTable.Buttons.prototype._buildButton;
        $.fn.DataTable.Buttons.prototype._buildButton = function(config, collectionButton) {
            var button = org_buildButton.apply(this, arguments);
            $(document).one('init.dt', function(e, settings, json) {
                if (config.container && $(config.container).length) {
                    $(button.inserter[0]).detach().appendTo(config.container)
                }
            })
            return button;
        }

        CheckProductos.tb_resumen = $('#tb-resumen-checkProductos').DataTable({
            buttons: [{
                    'extend': 'excel',
                    'text': '<i class="fal fa-file-excel"></i> Excel',
                    'exportOptions': {
                        'columns': ':not(.excel-borrar)'
                    },
                    'titleAttr': 'Exportar a excel',
                    'container': '.botonesTable'
                },
                {
                    'extend': 'colvis',
                    'text': '<i class="far fa-eye"></i>',
                    'columns': ':not(.noVis)',
                    'titleAttr': 'Ocultar/Mostrar columnas',
                    'container': '.botonesTable'
                },
                {
                    'text': '<i class="fal fa-expand"></i>',
                    'action': function(e, dt, node, config) {
                        $(node).find('i').toggleClass('fa-expand fa-compress');
                        Fn.fullScreen();
                    },
                    'titleAttr': 'Pantalla completa',
                    'container': '.botonesTable'
                }
            ],

            columnDefs: [{

                targets: [0, 1, 4],
                visible: false
            }, ],
            paging: false,
            scrollX: true,
            scrollCollapse: true,
            fixedHeader: true,
            fixedColumns: {
                leftColumns: 6,
            },
        });

        setTimeout(function() {
            if (CheckProductos.tb_resumen) {
                CheckProductos.tb_resumen.columns.adjust();
            }
        }, 500);

        $('#customInputFilterResumen').keyup(function() {
            CheckProductos.tb_resumen.search($(this).val()).draw();
        })
    })
</script>