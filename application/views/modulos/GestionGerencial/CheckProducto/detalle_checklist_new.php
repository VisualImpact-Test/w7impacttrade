<style>
    .fixTableHead {
      overflow-y: auto;
      height: 700px;
    }
    .fixTableHead thead .filaDesc {
      position: sticky;
      top: 45px;
    }
    .fixTableHead thead .filafecha {
      position: sticky;
      top: 0;
    }
    table {
      border-collapse: collapse;        
      width: 100%;
    }
    .filafecha th,
    .filaDesc th {
      background: #ffffff;
    }
    .trSegmentador:hover{
        background-color: rgb(82 76 78) !important;
        color: white; 
    }

    .trClientes:hover{
        background-color: rgb(112 66 72) !important;
        color: white; 
    }
    .trProductos:hover{
        background-color: rgb(170 32 48) !important;
        color: white; 
    }
</style>
<div class="card-datatable fixTableHead">
    <table class="fold-table table table-condensed">
        <thead class="">
            <tr class="filafecha">
                <th></th>
                <th></th>
                <th></th>
                <? foreach ($fechas as $f) : ?>
                    <th colspan="3 " class="text-center"><?= date_change_format($f['fecha']) ?></th>
                <? endforeach; ?>
            </tr>
            <tr class="filaDesc">
                <th></th>
                <th></th>
                <th></th>
                <? foreach ($fechas as $f) : ?>
                    <th colspan="1">PRESENCIA</th>
                    <th colspan="1">MOTIVO</th>
                    <th colspan="1">FOTO</th>
                <? endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?
            $sg = 0;
            $cli = 0;
            foreach ($segmentadores as $seg) : ?>
                <tr class="trSegmentador" data-segmentacion="<?= $seg['id'] ?>" style="background-color: rgb(191 191 191);">
                    <td colspan="3">
                        <i class="btn btn-sm btn-outline-trade-visual far <?= $sg == 0 ? 'fa-minus' : 'fa-plus' ?> showClientes" data-segmentacion="<?= $seg['id'] ?>"></i>
                        <?= $seg['nombre'] ?>
                    </td>
                    <? foreach ($fechas as $f) : ?>
                        <td class="text-center">
                            <?= !empty($presencia[$f['fecha'].$seg['id']]) ? count($presencia[$f['fecha'].$seg['id']]) : '0' ?>
                        </td>
                        <td></td>
                        <td class="text-center">
                            <? if (!empty($fotos[$f['fecha'].$seg['id']])) { ?>
                                <button class="opengallery btn btn-outline-secondary" data-image="0" data-seg="<?= $f['fecha'].$seg['id'] ?>">
                                 <i class="far fa-images"></i>
                                </button>
                            <? } ?>
                        </td>
                    <? endforeach; ?>
                </tr>
                <? foreach ($clientes[$seg['id']] as $cliente) : ?>
                    <tr class=" trClientes trClientes-<?= $seg['id'] ?> <?= $sg > 0 ? 'd-none' : '' ?>" data-cliente="<?= $cliente['idCliente'] ?>" style="background-color: #cfcdcd;">
                        <td></td>
                        <td colspan="100%">
                            <i class="btn btn-sm btn-outline-trade-visual far <?= $cli == 0 ? 'fa-minus' : 'fa-plus' ?> showProductos showProductos-seg-<?= $seg['id'] ?>" data-cliente="<?= $cliente['idCliente'] ?>"></i>
                            <?= $cliente['razonSocial'] ?>
                        </td>
                    </tr>
                    <? foreach ($productos[$cliente['idCliente']] as $producto) : ?>
                        <tr class="trProductos trProductos-seg-<?= $seg['id'] ?> trProductos-<?= $cliente['idCliente'] ?> <?= $cli > 0 ? 'd-none' : '' ?>" data-cliente="<?= $cliente['idCliente'] ?>" style="background-color: #e5e5e5;">
                            <td></td>
                            <td></td>
                            <td><?= $producto['nombre'] ?></td>
                            <? foreach ($fechas as $f) : ?>
                                <th colspan="1">
                                    <?= isset($detalle_new[$f['fecha']][$cliente['idCliente']][$producto['idProducto']]['presencia']) ? ($detalle_new[$f['fecha']][$cliente['idCliente']][$producto['idProducto']]['presencia'] == 1 ? 'SI' : 'NO') : '-' ?>
                                </th>
                                <th colspan="1">
                                    <?= !empty($detalle_new[$f['fecha']][$cliente['idCliente']][$producto['idProducto']]['motivo']) ? $detalle_new[$f['fecha']][$cliente['idCliente']][$producto['idProducto']]['motivo'] : '-' ?>
                                </th>
                                <?
                                $fotoImg = "";
                                if (!empty($detalle_new[$f['fecha']][$cliente['idCliente']][$producto['idProducto']]['foto'])) {
                                    $fotoImg = rutafotoModulo(['foto' => $detalle_new[$f['fecha']][$cliente['idCliente']][$producto['idProducto']]['foto'], 'modulo' => 'checklist', 'icono' => 'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']);
                                }
                                ?>
                                <th colspan="1">
                                    <?= (!empty($fotoImg) ? $fotoImg : '-'); ?>
                                </th>
                            <? endforeach; ?>
                        </tr>
                    <? endforeach; ?>
                <? $cli++;
                endforeach; ?>
            <? $sg++;
            endforeach; ?>
        </tbody>
    </table>

</div>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe. 
         It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. 
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="Share"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>


<script>
    var pswpElement = document.querySelectorAll('.pswp')[0];
    var fotos = <?= json_encode($fotos) ?>

    var items = [];
    $.each(fotos, (k, v) => {
        items[k] = [];
        $.each(v, (k1, v1) => {
            items[k].push({
                src: `${site_url}controlFoto/obtener_carpeta_foto/checklist/${v1.foto}`,
                w: 900,
                h: 600,
                author: v1.usuario,
                title: `${v1.producto} - ${v1.motivo}`
            });
        })
    });
    var options = {
        barsSize: {
            top: 100,
            bottom: 'auto'
        },
        index: 0,
        bgOpacity: 0.85,
        showHideOpacity: true,
        captionEl: true,
        fullscreenEl: true,
        zoomEl: true,
        shareEl: false,
    };

    var x = document.querySelectorAll(".opengallery");

    for (let i = 0; i < x.length; i++) {
        x[i].addEventListener("click", function() {
            opengallery(x[i].dataset.image, x[i].dataset.seg);
        });
    }

    function opengallery(j, seg) {

        //options.index = parseInt(j); Abrir numero de foto
        gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items[seg], options);
        gallery.init();
    }
</script>