                <input type="hidden" name="idConfCliente" value="<?=$idConfCliente?>">
                <div class='form-row funciones'>
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                    <input type="hidden" name="sl_cuenta" id="sl_cuenta" value="3">
                    <input type="hidden" name="sl_proyecto" id="sl_proyecto" value="3">
                        <!-- <label for='nombre'>Nombre</label><br>
                        <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'> -->
                    <button  class="btn btn-outline-primary border-0 btn-New-ClienteAud" title="Agregar"><i class="fa fa-plus"></i> Agregar</button>
                    <button  class="btn btn-outline-primary border-0 btn-refresh-ClienteAud" title="Refrescar"><i class="fa fa-refresh"></i> Refrescar</button>
                    </div>
                </div>
<?if(!empty($data)){?>
                <div class="card-datatable">
                    <table class="mb-0 table table-bordered no-footer w-100 text-nowrap">
                        <thead class="thead-light"> 
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">DETALLE</th>
                                <th class="text-center">CODIGO</th>
                                <th class="text-center">RAZON SOCIAL</th>
                                <th class="text-center">TIPO CLIENTE</th>
                                <th class="text-center">TIPO AUDITORIA</th>
                                <th class="text-center">VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $i => $value) {
                                
                                ?>
                                <tr  data-nombreaudext="<?=$value['tipoAuditoria']?>" data-idaudext="<?=$value['idExtAudTipo']?>" data-id="<?= $value['idConfClienteAud'] ?>" data-fechaReg =" <?=  date_change_format($value['fechaReg'] )?>">
                                    <td><?=$i+1?></td>
                                    <td class="text-center">
                                        <div>
                                            <button class="btn btn-ClienteAudDet btn-outline-secondary border-0" title="Detalle Auditoria"><i class="fas fa-list"></i></button>
                                            <button class="btn btn-cargaMasiva_clienteAud btn-outline-secondary border-0" title="Carga Masiva"><i class="fas fa-folder-plus"></i></button>
                                        </div>
                                    </td>
                                    <td><?= !empty($value['idCliente']) ? $value['idCliente'] : '-' ?></td>
                                    <td><?= !empty($value['razonSocial']) ? $value['razonSocial'] : '-' ?></td>
                                    <td><?= !empty($value['tipoCliente']) ? $value['tipoCliente'] : '-' ?></td>
                                    <td><?= !empty($value['tipoAuditoria']) ? $value['tipoAuditoria'] : '-' ?></td>
                                    <td><?= !empty($value['valor']) ? $value['valor'] : '0' ?></td>
                                   
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

<?}else{
    echo getMensajeGestion('noResultados');
}?>