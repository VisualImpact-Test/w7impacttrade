<?
$www = base_url() . 'public/assets/';
?>
<style>
    .img-title {
        background-color: gray;
        color: white;
        width: 15%;
        font-weight: bold;
        text-align: justify;
        text-justify: inter-word;
        padding: 10px;
    }

    .img-content {
        text-align: center;
        width: 35%;

    }

    .center {
        margin: auto;
        border: 3px solid green;
        padding: 10px;
    }

    figure {
        float: right;
        width: 30%;
        text-align: center;
        font-style: italic;
        font-size: smaller;
        text-indent: 0;
        border: thin silver solid;
        margin: 0.5em;
        padding: 0.5em;
    }
</style>
<hr>
<table style="width:100%;float:left;">
    <?
    $i = 0;
    foreach ($evidenciaFotografica as $idTipoFoto => $tipoFoto) {
        ?>
        <?foreach ($tipoFoto as $v) {?>
            <? if ($i == 0 || ($i % 2) == 0) { ?>
                <tr>
                <? } ?>
                <td class="img-title">
                    <span><?= $v['tipoFoto'] ?></span>
                    <br><br>
                    <hr style="color: white;" class="center">
                    <br><br>
                    <span><?= $v['tipoFotoEvidencia'] ?></span>
                </td>
                <?
                $ruta = '';
                if (!empty($v['foto'])) {

                    $params = explode("_", $v['foto']);
                    $last = end($params);
                    $pos = strpos($last, "WASABI");

                    if ($pos === false) $ruta = 'http://movil.visualimpact.com.pe/fotos/impactTrade_android/';
                    else $ruta = 'https://s3.us-west-1.wasabisys.com/visualimpact.app/fotos/impactTrade_Android/';
                }


                ?>
                <?= !empty($v['foto']) ? $img = $ruta . $v['carpetaFoto'] . '/' . $v['foto'] : $img = $www . 'images/sin_imagen.jpg' ?>
                <td class="img-content" style="<?= !empty($v['foto']) ? 'background-color: #DFDEDE;' : '' ?>">
                    <img class=scaled src="<?= $img ?>" alt="<?= $v['tipoFoto'] ?>" style="height:250px;width:auto;margin-top: 1%;">
                </td>

                <? if (count($promociones) == 1) { ?>
                    <td class="img-title" style="background-color: white !important;"></td>
                    <td class="img-content"></td>
                <? } ?>

                <? if ($i == 0 || ($i % 2) == 0) { ?>
                </tr>
            <? } ?>
    <?
            $i++;
        }
    }
    ?>
</table>