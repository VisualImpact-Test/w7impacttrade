<div></div>
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
    <hr />
    <table cellpadding="3" width="100%">
        <tr style="height: 1px;">
            <td width="25%" style="height: 1px;"></td>
            <td width="25%" style="height: 1px;"></td>
            <td width="25%" style="height: 1px;"></td>
            <td width="25%" style="height: 1px;"></td>
        </tr>
        <?php $contador = 0;
        foreach ($visita["fotos"] as $keyFoto => $foto) {
        ?>
            <?php if ($contador % 4 == 1) { ?>
                <tr>
                <?php } ?>
                <td>
                    <img class="foto" src="<?= verificarUrlFotos($foto["imgRef"]) . $foto["carpetaFoto"] .'/'. $foto["imgRef"] ?>" />
                    <table class="infoFoto">
                        <tr>
                            <td class="nombreDatoInfoFoto">Hora:</td>
                            <td><?= $foto["horaFoto"] ?></td>
                        </tr>
                        <tr>
                            <td class="nombreDatoInfoFoto">Tipo Foto:</td>
                            <td><?= $foto["tipoFoto"] ?></td>
                        </tr>
                    </table>
                </td>
                <?php end($visita["fotos"]);
                if ($contador % 4 == 0 || $keyFoto === key($visita["fotos"])) { ?>
                </tr>
            <?php } ?>
        <?php } ?>

    </table>
    <div></div>
<?php } ?>