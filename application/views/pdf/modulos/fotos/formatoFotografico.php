<table class="informacionCliente">
    <tr>
        <td>
            <h3 class="razonSocial"><?= $fotosCliente['razonSocial'] ?></h3>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="nombresInfo">COD VI:</td>
        <td colspan="2"><?= $fotosCliente["idCliente"] ?></td>
        <td colspan="2" class="nombresInfo">COD PDV:</td>
        <td colspan="2"><?= $fotosCliente["codCliente"] ?></td>
        <td colspan="2" class="nombresInfo">CANAL:</td>
        <td colspan="2"><?= $fotosCliente["canal"] ?></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td colspan="2" class="nombresInfo">UBICACIÓN:</td>
        <td colspan="4"><?= $fotosCliente["departamento"] . " - " . $fotosCliente["provincia"] . " - " . $fotosCliente["distrito"] ?></td>
        <td colspan="2" class="nombresInfo">DIRECCIÓN:</td>
        <td colspan="4"><?= $fotosCliente["direccion"] ?></td>
    </tr>
</table>

<?php foreach ($fotosCliente["visitas"] as $keyVisita => $visita) {
    $cantidadFotos = count($visita["fotos"]);
?>
    <h6>FECHA: <?= $visita["fecha"] ?> | <?= $visita["tipoUsuario"] ?>: <?= $visita["usuario"] ?> | FOTOS: <?= $cantidadFotos ?> </h6>
    <hr class="hrFotos" />
    <div>
        <?php $contador = 0;
            foreach ($visita["fotos"] as $keyFoto => $foto) {
                $contador++; ?>
            <div style="text-align:center;">
                <img class="foto" src="http://movil.visualimpact.com.pe/fotos/impactTrade_android/moduloFotos/<?= $foto["imgRef"] ?>" style="height:310px;width:550px;margin:0px;margin-top:5px;padding:0px;" />
                <table class="infoFoto" style="width:550px;text-align:left;margin:0 auto;">
                    <tr>
                        <td class="nombreDatoInfoFoto">Hora:</td>
                        <td><?= $foto["horaFoto"] ?></td>
                    </tr>
                    <tr>
                        <td class="nombreDatoInfoFoto">Tipo Foto:</td>
                        <td><?= $foto["tipoFoto"] ?></td>
                    </tr>
                </table>
            </div>
        <?php } ?>
    </div>
<?php } ?>