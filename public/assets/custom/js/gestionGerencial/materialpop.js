var MaterialPop = {

    frmRutas: 'frm-material-pop',
    contentDetalle: 'idContentMaterialPop',
    url: 'gestionGerencial/MaterialPop/',
    urlActivo: 'filtrar',
    datatable: {},

    load: function () {
        $(document).ready(function () {

            $(".flt_grupoCanal").change();
            $('#btn-filtrar').click();

        });
       
        $(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('#btn-filtrar').click();
        });

        $(document).on('click', '#btn-filtrar', function (e) {
            e.preventDefault();


            var config = {
                'idFrm': MaterialPop.frmRutas
                , 'url': MaterialPop.url + MaterialPop.urlActivo
                , 'contentDetalle': MaterialPop.contentDetalle
            };

            Fn.loadReporte_validado(config);

        });
        $(document).on('click', '#btn-toggle-menu', function (e) {
            setTimeout(function(){
                Fn.dataTableAdjust();
            }, 500);
        });


    }
}

MaterialPop.load();