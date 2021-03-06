<?php
	global $wpdb;
	$items = $wpdb->get_results("SELECT * FROM  wp_wc_order_stats WHERE status = 'wc-completed' AND net_total > 0");
	//printr($items);
 ?>
 <style type="text/css">
 	table.table-data tfoot{display:table-footer-group;}
 </style>
<div class="wrap">
	<br>
	<h1><?php _e('Informe de comisiones', 'fdc') ?></h1>
	<div class="metabox-holder">
		<table class="table table-striped table-bordered table-data">
			<thead class="">
				<tr style="background:#555a6b;color:white;border:1px solid red;">
					<th><?php _e('Nº de Pedido', 'fdc') ?></th>
					<th><?php _e('Mes', 'fdc') ?></th>
					<th><?php _e('Año', 'fdc') ?></th>
					<th><?php _e('Importe Neto del Pedido', 'fdc') ?></th>
					<th><?php _e('Importe Comisión', 'fdc') ?></th>
				</tr>
			</thead>

			<tbody>
			<?php foreach ($items as $item): ?>
				<?php $precio_negativo=wc_price($item->net_total); ?>
				 
				<?php $date = new DateTime($item->date_created_gmt); ?>
				<?php $commission = intval($item->net_total) * 15/100; ?>
				<tr>
					<td>#<?php echo $item->order_id ?></td>
					<td><?php _e($date->format('F')) ?></td>
					<td><?php echo $date->format('Y') ?></td>
					<td><?php echo wc_price($item->net_total) ?></td>
					<td style="color:#000;"><b><?php echo wc_price($commission) ?></b></td>
				</tr>
			
			<?php endforeach; ?>
			</tbody>
			<tfoot>
	            <tr>
					<th colspan="4" style="text-align:right">Total: (Cálculo del 15% de comisión sobre el importe total)</th>
	                <th style="text-align:center;"></th>
	            </tr>
	        </tfoot>
		</table>
	</div>
</div>

<script>
(function($) {
	$(document).ready(function(){
		var table = $('.table-data').DataTable({
			"columnDefs": [
	            {
	                "targets": [1, 2],
	                "orderable": false
	            }
	        ],
	        "footerCallback": function ( row, data, start, end, display ) {
	            var api = this.api(), data;
	 
	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            total = api
	                .column( 4 )
	                .data()
	                .reduce( function (a, b) {
	                	var txt = b.replace(/(<([^>]+)>)/ig,"").replace("€","").replace(",",".");
	                    return intVal(a) + intVal(txt);
	                }, 0 );

	            // Total over this page
	            pageTotal = api
	                .column( 4, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                	var txt = b.replace(/(<([^>]+)>)/ig,"").replace("€","").replace(",",".");
	                    return intVal(a) + intVal(txt);
	                }, 0 );
	 
	            // Update footer
	            $( api.column( 4 ).footer() ).html('<span class="total">' + pageTotal +'€</span>');
	        },
	        initComplete: function () {
		        this.api().columns([1]).every(function(i){
		            var column = this;
		            var select = $('<select class="form-control"><option value=""><?php _e('Selecciona un mes...', 'fdc') ?></option></select>')
		                .appendTo($(column.header()).empty())
		                .on('change', function(){
		                    var val = $.fn.dataTable.util.escapeRegex(
		                        $(this).val()
		                    );
		                    column
		                        .search(val ? '^'+val+'$' : '', true, false)
		                        .draw();
		                });
		            column.data().unique().sort().each(function(d, j){
		                select.append('<option value="'+d+'">'+d+'</option>')
		            });
		        });
		        this.api().columns([2]).every(function(i){
		            var column = this;
		            var select = $('<select class="form-control"><option value=""><?php _e('Selecciona un año...', 'fdc') ?></option></select>')
		                .appendTo($(column.header()).empty())
		                .on('change', function(){
		                    var val = $.fn.dataTable.util.escapeRegex(
		                        $(this).val()
		                    );
		                    column
		                        .search(val ? '^'+val+'$' : '', true, false)
		                        .draw();
		                });
		            column.data().unique().sort().each(function(d, j){
		                select.append('<option value="'+d+'">'+d+'</option>')
		            });
		        });
		    },
			dom: 'Bfrtip',
			lengthMenu: [
	            [ -1, 1, 25, 50, 100],
				[ "Todo", 10, 25, 50, 100],
	        ],
			buttons: [
				{
					extend: 'pageLength',
					text: '<?php _e('Paginación', 'fdc') ?>'
					
				},
				{
					extend: 'excelHtml5',
					autoFilter: true,
					title: "<?php _e('Informe de Comisiones', 'fdc') ?>",
					customize: function (xlsx) {
						var sheet = xlsx.xl.worksheets['sheet1.xml'];
						var total = ($('.table-data').find('.total').text());
						console.log(sheet);
						$('row[r=2] c[r="B2"] is t', sheet).text("<?php _e('Mes', 'fdc') ?>");
						$('row[r=2] c[r="C2"] is t', sheet).text("<?php _e('Año', 'fdc') ?>");

						var total_row = '';
						for (var i = 0; i < cols; i++) {
							var last_cell = "";
							if (i == cols - 2){
								last_cell = '<?php _e('Total', 'fdc') ?>';
							}
							if (i == cols - 1){
								last_cell = total;
							}
							var total_row = total_row + '<c t="inlineStr" r="" s="2"><is><t xml:space="preserve">'+last_cell+'</t></is></c>';
						}

						$('sheetData row:last', sheet).after('<row r="'+(rows+3)+'">'+total_row+'</row>');
					}
				},
				{
					extend: 'pdfHtml5',
					title: "<?php _e('Informe de Comisiones', 'fdc') ?>",
					customize: function (doc) {
						if (doc) {
							console.log(doc);
							/* headers */
							doc.styles.tableHeader.fillColor = color;
							doc.content[1].table.widths = [ '20%', '20%', '20%', '20%', '20%' ]; // 5 columnas 5 parámetros
							doc.content[1].table.body[0][1].text = '<?php _e('Mes', 'fdc') ?>';
							doc.content[1].table.body[0][2].text = '<?php _e('Año', 'fdc') ?>';
							var len = doc.content[1].table.body.length;
							var total = ($('.table-data').find('.total').text());
							doc.content[1].table.body.push([
								{'text': '', 'fillColor': color}, 
								{'text': '', 'fillColor': color}, 
								{'text': '', 'fillColor': color}, 
								{'text': '', 'fillColor': color, 'color': 'white'}, 
								{'text': 'Total ' + total, 'fillColor': color, 'color': 'white'}
							]);

							$(doc.content[1].table.body).each(function(a){
								$(this).each(function(b){
									$(this)[0].alignment = 'center';
								});
							});
							doc.content[1].table.body[len][3].alignment = 'right';
						}
					}
				}
			],
			language: {
		       // url: '/wp-content/themes/betheme-child/admin/views/i18n/es_ES.json'
			  
            
            "zeroRecords": "No se ha encontrado ningún dato",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos para mostrar",
			"search":  "Buscar:",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			}
        }
			
		});
		var rows = table.rows().count();
		var cols = table.columns().count();
		var color = '#555a6b';
	});
})(jQuery);
</script>