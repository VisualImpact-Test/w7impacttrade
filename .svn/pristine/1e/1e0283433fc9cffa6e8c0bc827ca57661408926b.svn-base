<div id="contenido_filtrado">

    <table class="table" id="tabla_find">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Categoria</th>
                <th scope="col">Resultado</th>
      <th scope="col">Ruta</th>
    </tr>
</thead>
<tbody>
    <? $i= 0;foreach ($data->result() as $row){?>
        <tr>
            <th scope="row"><?=$i++?></th>
            <td><?=$row->grupoMenu?></td>
        <td><li class="<?=$row->cssIcono?>"></li><a href="<?=base_url().$row->page?>"> <?=" ".$row->nombre?></a></td>
        <td><?=base_url().$row->page?></td>
    </tr>
    <?}?>
    
</tbody>
</table>

</div>