                <input type="hidden" name="idConfClienteDet" value="<?=$idConfClienteAud?>">
                <div class='form-row funciones'>
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                    <input type="hidden" name="sl_cuenta" id="sl_cuenta" value="3">
                    <input type="hidden" name="sl_proyecto" id="sl_proyecto" value="3">
                        <!-- <label for='nombre'>Nombre</label><br>
                        <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'> -->
                    <button  class="btn btn-outline-primary border-0 btn-New-ClienteAudDet" title="Agregar"><i class="fa fa-plus"></i> Agregar</button>
                    <!-- <button  class="btn btn-outline-primary border-0 btn-refresh-ClienteAudDet" title="Refrescar"><i class="fa fa-refresh"></i> Refrescar</button> -->
                    </div>
                </div>

<?if(!empty($data)){?>
   <div class="card-datatable">
       <form action="" method="POST" id="formAudDet">
           <table class="mb-0 table table-bordered no-footer w-100 text-nowrap">
               <thead class="thead-light"> 
                   <tr>
                       <th class="text-center">#</th>
                       <th class="text-center" style="width: 10%;">TIPO AUDITORIA</th>
                       <th class="text-center">CÓDIGO</th>
                       <th class="text-center"><?=strtoupper($data[0]['tipoAuditoria'])?></th>
                       <th class="text-center">PRESENCIA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $i => $value) {

                        $icon_presencia = ($value['presencia']) ? 'fas fa-check': 'fas fa-times';
                        $color_presencia = ($value['presencia']) ? 'green': 'red';
                        ?>
                                <tr  data-id="<?= $value['idConfClienteAudDet'] ?>" data-fechaReg =" <?=  date_change_format($value['fechaReg'] )?>">
                                <td><?=$i+1?></td>
                                <td><?= !empty($value['tipoAuditoria']) ? $value['tipoAuditoria'] : '-' ?></td>
                                <td class="text-center"><?= !empty($value['codigoSKU']) ? generarCorrelativo($value['codigoSKU'],6) : '-' ?></td>
                                <td><?= !empty($value['material']) ? $value['material'] : '-' ?></td>
                                <td class="text-center"><div class="btn btn-presencia  <?=$icon_presencia?>" style="background-color: <?=$color_presencia?>;color:white"></div></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
            </form>
                </div>
<?}else{
    echo getMensajeGestion('noResultados');
}?>