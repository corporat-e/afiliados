<?php

add_action('admin_menu', 'register_custom_menu_page');
function register_custom_menu_page() {
    add_menu_page('Commissions', 'Comisiones', 'view_woocommerce_reports', 'commissions', 'fdc_views', 'dashicons-money-alt', 63);
}

function fdc_views(){
	include dirname( __FILE__ ) . '/views/commissions.php';
}
