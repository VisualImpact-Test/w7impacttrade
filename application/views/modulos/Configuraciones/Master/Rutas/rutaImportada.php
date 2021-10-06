<div id="data_ruta_importada"></div>
<script>
		var container = document.getElementById('data_ruta_importada');
		var settings = {
					licenseKey: 'non-commercial-and-evaluation',
					data: [<?=$visitas?>], 
					/* dataSchema: {nombreRuta:null, idGtm:null, idCliente:null, lunes:null,martes:null,miercoles:null,jueves:null, viernes:null, sabado:null, domingo:null }, */
					colHeaders: ['IDCLIENTE', 'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO'],
					startRows: 10,
					//startCols: 4,
					columns: [
						{data: 'idCliente', type:'numeric', allowEmpty: false},
						{data: 'lunes', type:'numeric'},
						{data: 'martes', type:'numeric'},
						{data: 'miercoles', type:'numeric'},
						{data: 'jueves', type:'numeric'},
						{data: 'viernes', type:'numeric'},
						{data: 'sabado', type:'numeric'},
						{data: 'domingo', type:'numeric'},
						
					],
					minSpareCols: 1, //always keep at least 1 spare row at the right
					minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
					rowHeaders: true, //n° contador de las filas
					//filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
					contextMenu: true,
					dropdownMenu: true, //desplegable en la columna, ofrece oopciones
					height: 300,
					//width: '100%',
					stretchH: 'all', //Expande todas las columnas al 100%
					maxRows: 50, //cantidad máxima de filas
					manualColumnResize: true,
					//FUNCIONES
					cells: function(row,col, prop){
						if (col==3) {
							//console.log('row - col',row+'-'+col);
						}
					},
					
				};

				Modulacion.handsontable = new Handsontable(container, settings);
				console.log('Carga Masiva');
				setTimeout(function(){
					//$.fn.dataTable.tables( { visible: true, api: true } ).columns.adjust();
				Modulacion.handsontable.render(); 
				}, 1000);
			

</script>

