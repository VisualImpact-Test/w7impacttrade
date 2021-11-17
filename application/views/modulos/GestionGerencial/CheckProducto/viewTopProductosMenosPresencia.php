<style>
    html,
    body,
    #top-productos-menos-presencia {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #top-productos-menos-presencia {
        height: 500px !important;
        font-size: 15px !important;
    }
</style>

<div id="top-productos-menos-presencia"></div>
<script>
    // create data
   
    var data1 = <?= json_encode($productosMenosPresencia) ?>;
    var rawData1 = [];
    $.each(data1, function(index, r) {
        rawData1.push({x:index, value: r.value, fill:r.color});
    });

    // create a chart
    chart = anychart.bar();

    // create a bar series and set the data
    var series = chart.bar(rawData1);
    series.stroke("#DCDCDD");
    series.name('Tiendas con quiebres <?= $this->sessNomCuentaCorto ?>: ');
    // set the container id
    chart.xAxis().title("Productos");
    chart.yAxis().title("Quiebres");
    chart.container("top-productos-menos-presencia");
    // initiate drawing the chart
    chart.draw();
</script>