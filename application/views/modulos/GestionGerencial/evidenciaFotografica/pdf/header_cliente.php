<style>
    .td-title{
        background-color: #e2001a ;
        color: white ;
        width: 15%;
        font-weight: bold;
        padding-left: 10px;
    }
    .td-content{
        text-align: left;
        width: 35%;
        padding-left: 10px;
    }
</style>
<table style="width:100%;float:left;">
    <tr>
        <td class="td-title">COD VISUAL</td>';
        <td class="td-content"><?=$idCliente?> </td>
        <td class="td-title">COD <?=$this->sessNomCuentaCorto?></td>';
        <td class="td-content"><?=$codCliente?> </td>
    </tr>
    <tr>
        <? $i = 0 ;foreach ($segmentacion['headers'] as $k => $v) { ?>
            <td class="td-title"><?= strtoupper($v['header']) ?></td>';
            <td class="td-content"><?= (!empty($colDyn[($v['columna'])]) ? $colDyn[($v['columna'])] : '-') ?></td>
            <?if($i >=2 ){break;}?>
        <? $i++;} ?>
    </tr>
    <tr>
        <td class="td-title">GRUPO CANAL</td>';
        <td class="td-content"><?=$grupoCanal?> </td>
        <td class="td-title">CANAL</td>';
        <td class="td-content"><?=$canal?> </td>
    </tr>
    <tr>
        <td class="td-title">RAZÓN SOCIAL</td>';
        <td class="td-content"><?=$razonSocial?> </td>
        <td class="td-title">USUARIO</td>';
        <td class="td-content"><?=$nombreUsuario?> </td>
    </tr>
    <tr>
        <td class="td-title">DIRECCIÓN</td>';
        <td class="td-content"><?=$direccion?> </td>
    </tr>
</table>