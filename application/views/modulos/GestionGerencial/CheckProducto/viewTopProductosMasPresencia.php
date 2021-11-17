<style>
    html,
    body,
    #top-productos-mas-presencia {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #top-productos-mas-presencia {
        height: 500px !important;
    }
</style>

<div id="top-productos-mas-presencia"></div>
<script>
    // create data
   
    var data = <?= json_encode($productosMasPresencia) ?>;
    var rawData = [];
    $.each(data, function(index, r) {
        rawData.push({x:index, value: r.value, fill:r.color});
    });

    // create a chart
    chart = anychart.bar();

    // create a bar series and set the data
    var series = chart.bar(rawData);
    series.stroke("#FFB612");
    series.name('Tiendas con presencia <?= $this->sessNomCuentaCorto ?>: ');
    // set the container id
    chart.xAxis().title("Productos");
    chart.yAxis().title("Presencia");
    chart.container("top-productos-mas-presencia");
    // initiate drawing the chart
    chart.draw();
</script>