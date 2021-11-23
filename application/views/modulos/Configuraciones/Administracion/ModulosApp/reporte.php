<?$i = 1;?>
<?foreach($aplicacion as $kapp => $vapp){?>
    <div class="row mb-3">
        <div class="col-md-12 px-5 py-2">
            <h3 class="mb-2"><?=$vapp?></h3>
        </div>
        <div class="col-md-12 px-5">
            <div class="row">
            <?foreach($prioridad[$kapp] as $kprio => $vprio){?>
                <?foreach($cabecera[$kapp][$kprio] as $kcab => $vcab){?>
                    <div class="col-md-3 mb-4">
                        <div class="card border">
                            <div class="card-header h-auto">
                                <div class="form-check form-check-inline m-2" style="height: 40px;">
                                    <input type="checkbox" class="check-moduloEdit form-check-input cursor-pointer" id="check-moduloEdit-<?=$kcab?>" style="width: 15px; height: 15px;"
                                        data-id-tipo-usuario="<?=empty($vcab['idTipoUsuario']) ? 0 : $vcab['idTipoUsuario']?>"
                                        data-id-canal="<?=empty($vcab['idCanal']) ? 0 : $vcab['idCanal']?>"
                                    >
                                    <label class="form-check-label cursor-pointer mb-0 ml-2" for="check-moduloEdit-<?=$kcab?>">
                                        <?if( !empty($vcab['tipoUsuario']) ){?>
                                            <span class="d-block"><b>Tipo Usuario:</b> <?=$vcab['tipoUsuario']?></span>
                                        <?}?>
                                        <?if( !empty($vcab['canal']) ){?>
                                            <span class="d-block"><b>Canal:</b> <?=$vcab['canal']?></span>
                                        <?}?>
                                    </label>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush" style="height: 350px; overflow-y: auto;">
                                <?foreach($modulos[$kapp][$kprio][$kcab] as $kmod => $vmod){?>
                                    <li class="list-group-item py-2" data-id="<?=$kmod?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <?
                                                    $estadoColor = ' text-danger';
                                                    $estadoIcon = ' fa-circle';
                                                    $estadoText = 'Inactivo';
                                                    if( !empty($vmod['estado']) ){
                                                        $estadoColor = ' text-success';
                                                        $estadoText = 'Activo';
                                                    }
                                                ?>
                                                <i class="fad<?=$estadoIcon.$estadoColor?>" title="<?=$estadoText?>"></i>
                                                <?=$vmod['nombre']?>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <?
                                                    $obligColor = ' text-muted';
                                                    $obligFlag = 0;
                                                    $obligText = 'No es ';
                                                    if( !empty($vmod['obligatorio']) ){
                                                        $obligColor = ' text-danger';
                                                        $obligFlag = 1;
                                                        $obligText = 'Es ';
                                                    }
                                                ?>
                                                <button type="button" class="btn-moduloApp-oblig btn btn-sm px-1<?=$obligColor?>"
                                                    title="<?=$obligText?>Obligatorio"
                                                    data-flag-obligatorio="<?=$obligFlag?>"
                                                >
                                                    <i class="fas fa-exclamation-circle fa-lg"></i>
                                                </button>
                                                <button type="button" class="btn-moduloApp-eliminar btn btn-sm px-1 text-primary"
                                                    title="Borrar"
                                                >
                                                    <i class="fas fa-trash-alt fa-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                    </div>
                <?}?>
            <?}?>
            </div>
        </div>
    </div>
<?}?>
