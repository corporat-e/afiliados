<?php
/**
 * Betheme Child Theme
 *
 * @package Betheme Child Theme
 * @author Muffin group
 * @link https://muffingroup.com
 */

/**
 * Child Theme constants
 * You can change below constants
 */

// white label

define('WHITE_LABEL', false);

/**
 * Enqueue Styles
 */

function mfnch_enqueue_styles()
{
	// enqueue the parent stylesheet
	// however we do not need this if it is empty
	// wp_enqueue_style('parent-style', get_template_directory_uri() .'/style.css');

	// enqueue the parent RTL stylesheet

	if (is_rtl()) {
		wp_enqueue_style('mfn-rtl', get_template_directory_uri() . '/rtl.css');
	}

	// enqueue the child stylesheet

	wp_dequeue_style('style');
	wp_enqueue_style('style', get_stylesheet_directory_uri() .'/style.css');
}
add_action('wp_enqueue_scripts', 'mfnch_enqueue_styles', 101);

/**
 * Load Textdomain
 */

function mfnch_textdomain()
{
	load_child_theme_textdomain('betheme', get_stylesheet_directory() . '/languages');
	load_child_theme_textdomain('mfn-opts', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'mfnch_textdomain');

/** Oculta precio y añadir al carrito a usuarios no conectados **/

add_filter('woocommerce_get_price_html', 'ayudawp_show_price_logged');
 
function ayudawp_show_price_logged($price){
if(is_user_logged_in() ){
return $price;
}
else
{
add_action( 'woocommerce_single_product_summary', 'ayudawp_print_login_to_see', 31 );
add_action( 'woocommerce_after_shop_loop_item', 'ayudawp_print_login_to_see', 11 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
}
}
 
function ayudawp_print_login_to_see() {
echo '<a href="' . get_permalink(wc_get_page_id('myaccount')) . '">' . __('', 'theme_name') . '</a>';
}

add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab($tabs) {
unset($tabs['reviews']);
return $tabs;
}


 /*Edita el CSS del admin panel */
add_action('admin_head', 'my_custom_css');

function my_custom_css() {
  echo '<style>
    /*.toplevel_page_woocommerce {
      display:none!important;
    } */
	 .woocommerce-layout__header {
	display:none; 
	}
	#adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
	background:#555a6b!important;
	}
	#adminmenu .opensub .wp-submenu li.current a, #adminmenu .wp-submenu li.current, #adminmenu .wp-submenu li.current a, #adminmenu .wp-submenu li.current a:focus, #adminmenu .wp-submenu li.current a:hover, #adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a {
	background: #555a6b!important;
	}
	body {background:white!important;}
	body.admin-bar, body.admin-bar #wpcontent, body.admin-bar #adminmenu {
	margin-top:20px!important;
	}
	
	#month_9 {
		display:none!important;
	}
	/*Datatable*/
	.table.dataTable thead .sorting {
		background:none!important;
	}
	.table.dataTable thead th, table.dataTable thead td {
		border:none;
		vertical-align: middle;
		text-align: center;
	}
	.wp-core-ui select {
	background-color:#30333e!important;	
	border:none;
	color:white;
	}
	.wp-core-ui select:hover {
	color:white;	
	}
	.table-bordered td, .table-bordered th {
    border: 1px solid #ececec;
	}
	button.dt-button, div.dt-button, a.dt-button {
	background-color: #555a6b!important;	
	background-image:none!important;
	border:none;
	color:white;
	}
	.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
	background-color: #555a6b!important;	
	background-image:none!important;
	border:none;
	color:white!important;
	}
	button.dt-button:hover, div.dt-button, a.dt-button {
		border:none!important;
		background-color: #30333e!important;
	}
	td {
		text-align: center;
	}
	.css-unzpkb-Flex-Root {
	display:none!important;
	}
  </style>';
}

//cargamos libreria datatable
add_action('admin_enqueue_scripts', 'betheme_child_admin_scripts_styles');
function betheme_child_admin_scripts_styles(){
	wp_enqueue_style('datatables', 'https://cdn.datatables.net/v/dt/dt-1.10.18/b-1.5.6/b-html5-1.5.6/datatables.min.css');
	wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');

	wp_register_script ('datatables', 'https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/datatables.min.js' ,array() ,false , true);
	wp_register_script ('pdfmake', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js' ,array() ,false , true);
	wp_register_script ('vfs_fonts', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js' ,array() ,false , true);
	wp_register_script ('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' ,array() ,false , true);
	
	wp_enqueue_script ('datatables');
	wp_enqueue_script ('pdfmake');
	wp_enqueue_script ('vfs_fonts');
	wp_enqueue_script ('bootstrap');
}


//funciona para el calculo de comisiones
add_filter( 'the_content', 'dcms_list_data' );
 
function dcms_list_data( $content ) {
	$slug_page = 'simulador-de-comisiones'; //slug de la página
	$table_name = 'msc_4_wc_order_stats'; // nombre de la tabla
	//carga la lbreria para integrar pdf
	

	
	if (is_page($slug_page)){
	    global $wpdb;	
	    $items = $wpdb->get_results("SELECT * FROM `msc_4_wc_order_stats` WHERE `status` = 'wc-completed' ");
	    $result = '';
		$suma=0;
		$i=0;
		$comision=0;
		//printr($_POST);
		//echo "MUESTRA EL MES: ".$_POST[month];
		
		

		//echo "Comisión del 10%<br>";
		echo "<form method='POST' style='margin-bottom:10px;'>";
		
		echo "<select name='month' style='height:30px;vertical-align:middle;margin-right:5px;>";
		for ($i=0;$i<=12;$i++)
		{
			
			switch ($i) {
				case 1:
				$nombre_mes[$i]="Enero";
				break;
				case 2:
				$nombre_mes[$i]="Febrero";
				break;
				case 3:
				$nombre_mes[$i]="Marzo";
				break;
				case 4:
				$nombre_mes[$i]="Abril";
				break;
				case 5:
				$nombre_mes[$i]="Mayo";
				break;
				case 6:
				$nombre_mes[$i]="Junio";
				break;
				case 7:
				$nombre_mes[$i]="Julio";
				break;
				case 8:
				$nombre_mes[$i]="Agosto";
				break;
				case 9:
				$nombre_mes[$i]="Septiembre";
				break;
				case 10:
				$nombre_mes[$i]="Octubre";
				break;
				case 11:
				$nombre_mes[$i]="Noviembre";
				break;
				case 12:
				$nombre_mes[$i]="Diciembre";
				break;
			}
			
			
			if ($_POST[month]==$i)
			{
			echo "<option value='".$i."' selected>".$nombre_mes[$i]."</option>";
			$nombre_mes_final=$nombre_mes[$i];
			}
			else {
			echo "<option value='".$i."'>".$nombre_mes[$i]."</option>";
			}
		}
		
				
			
		echo "</select>";
		echo "<select name='yeary' style='height:30px;vertical-align:middle;'>;
				<option value='2020'>2020</option>"; 
			  
		 $year_actual=date("Y");
		 $year_inicio=2020;
		 
		 if ($year_inicio!=$year_actual)
		 {
			 if ($year_actual==$_POST[yeary])
			 {
				 echo "<option value='".$year_actual."' selected>".$year_actual."</option>";
			 }
			 else{
			 echo "<option value='".$year_actual."'>".$year_actual."</option>";
			 }
			 $year_inicio=$year_inicio+1;
		 }
		 
		 echo "</select>
		<input type='Submit' style='height:30px;vertical-align:middle;background:red;color:white;border:none;border-radius:3px;' value='Consultar Fecha'></input>
		</form>"; 
		
		// nombre de los campos de la tabla
		foreach ($items as $item) {
			$fecha=$item->date_created;
			$neto=$item->net_total;
			$neto=number_format($neto, 2,',','.');
			$mes=explode("-",$fecha);
			$mes_actual=$mes[1];
			//echo "MUESTRA MES ACTUAL: ".$mes_actual;
			$year=$mes[0];
			
			$comision=$neto*10/100;
			$comision=number_format($comision, 2,',','.');
			
			
			if (empty($_POST))
			{
				
				switch ($mes[1]) {
				case 1:
				$nombre_mes2="Enero";
				break;
				case 2:
				$nombre_mes2="Febrero";
				break;
				case 3:
				$nombre_mes2="Marzo";
				break;
				case 4:
				$nombre_mes2="Abril";
				break;
				case 5:
				$nombre_mes2="Mayo";
				break;
				case 6:
				$nombre_mes2="Junio";
				break;
				case 7:
				$nombre_mes2="Julio";
				break;
				case 8:
				$nombre_mes2="Agosto";
				break;
				case 9:
				$nombre_mes2="Septiembre";
				break;
				case 10:
				$nombre_mes2="Octubre";
				break;
				case 11:
				$nombre_mes2="Noviembre";
				break;
				case 12:
				$nombre_mes2="Diciembre";
				break;
			}
				
								
				$result .= '<tr>
				<td style="text-align:center;"><b>#'.$item->order_id.'</b></td>
				<td style="text-align:center;">'.$nombre_mes2.'</td>
				<td style="text-align:center;">'.$year.'</td>
				<td style="text-align:center;">'.$neto.' €</td>
				<td style="text-align:center;">'.$comision.' €</td>
				</tr>';
				$total_comision=$suma+$comision;
				$suma=$total_comision;
			}
			else {
					
					
					if ($_POST[month]==$mes_actual && $_POST[yeary]==$year)
					{
						$result .= '<tr>
						<td style="text-align:center;"><b>#'.$item->order_id.'</b></td>
						<td style="text-align:center;">'.$nombre_mes_final.'</td>
						<td style="text-align:center;">'.$year.'</td>
						<td style="text-align:center;">'.$neto.' €</td>
						<td style="text-align:center;">'.$comision.' €</td>
						</tr>';
						$total_comision=$suma+$comision;
						$suma=$total_comision;
					}
								
			}
					
		}
	$var="'+d+'";
	$var2='"';
	$total_comision=number_format($total_comision, 2,',','.');
		$template = "<table class='table-data' style='margin-bottom:15px;'>
			         <thead style='background:red;color:white;border:1px solid red;'>
					 <tr>
			            <th style='text-align:center;border:1px solid #d80000;'>Nº de Pedido</th>
						<th style='text-align:center;border:1px solid #d80000;'>Mes</th>
						<th style='text-align:center;border:1px solid #d80000;'>Año</th>
						<th style='text-align:center;border:1px solid #d80000;'>Importe neto</th>
						<th style='text-align:center;border:1px solid #d80000;'>Comisión</th>
			          </tr>
					  </thead>
					 <tbody>
			          {data}
					 </tbody>
			        </table>
					<br>
					<table class='table-data2'>
			          <tr>
			            <th style='background:red;color:white;border:1px solid #d80000;text-align:center;'>Total comisiones</th>
						<th style='background:#f8898d;color:white;border:1px solid #ff6c6c;text-align:right;'>Cálculo de el 10% de comisión sobre el importe total</th>
						<th style='text-align:right;'>$total_comision €</th>
			          </tr>
			        </table>
					

					<script type='text/javascript' src='../wp-content/themes/betheme-child/datatables.min.js'></script>
					
					
					
					
					<script>
				(function($) {
	$(document).ready(function(){
    	$('.table-data').DataTable({
			
			 
	       
		});
	});
})(jQuery);
</script>";
	
		if (function_exists("wpptopdfenh_display_icon")) echo wpptopdfenh_display_icon();

	    return $content.str_replace('{data}', $result, $template);
		
		
	}
	
	return $content;
	}

require_once( get_stylesheet_directory().'/admin/commission.php' );
