<?php 

global $wpdb;
$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
$reviews = $wpdb->prefix . 'jet_reviews';
$reviews_consulta = "SELECT COUNT(*) FROM {$reviews}";
$sql_reviews = $wpdb->get_var($reviews_consulta);
$sql_chart  = "SELECT SUM(plazas) as vl FROM {$camp_bookings_top}";
$gains = "SELECT SUM(precio) FROM {$camp_bookings_top}";
$sql_filter_admin = "SELECT MONTH(fecha) as m, YEAR(fecha) as y FROM {$camp_bookings_top} GROUP BY YEAR(fecha), MONTH(fecha) ORDER BY fecha DESC";
$filter_1_sql = $wpdb->get_results($sql_filter_admin);
$meses_for_admin = [];
$user_id = get_current_user_id();
$user_data = get_userdata($user_id);
$bookings = $wpdb->get_var($sql_chart);
$args_users = array(
    'role__not_in' => array( 'administrator', 'gestor_campamento' ),
);
$users_dat = count(get_users($args_users));
$users_dat = ($users_dat) ? $users_dat : 0;
$gest_users_args = array(
	'role' => 'gestor_campamento',
);
$gest_users = count(get_users($gest_users_args));
$gest_users = ($gest_users) ? $gest_users : 0;

$where = (in_array('gestor_campamento', $user_data->roles)) ? " AND id_gest_camp = '{$user_id}'" : "";
$ultimos_12meses = $wpdb->get_results("SELECT YEAR(fecha) as a, MONTH(fecha) as m, SUM(plazas) as c FROM {$camp_bookings_top} WHERE DATEDIFF(CURDATE(), fecha) < 365 {$where} GROUP BY YEAR(fecha), MONTH(fecha) ORDER BY fecha DESC LIMIT 12");
$u12m_r = [];
foreach($ultimos_12meses as $dts){ if(!isset($u12m_r[$dts->a])) $u12m_r[$dts->a] = []; $u12m_r[$dts->a][$dts->m] = $dts->c;}
$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
$labels = [];
$values = [];
for($i=11;$i>=0;$i--){
	$mes = date("n", strtotime("-{$i} months"));
	$ano = date("Y", strtotime("-{$i} months"));
	$labels[] = $meses[$mes - 1];
	$values[] = (isset($u12m_r[$ano]) && isset(($u12m_r[$ano][$mes]))) ? $u12m_r[$ano][$mes] : 0 ;
}

if(!empty($filter_1_sql)) foreach($filter_1_sql as $rg){
	$meses_for_admin[$rg->y.'-'.$rg->m] = $meses[$rg->m-1].' '.$rg->y;
}

function labels_booking_last_year_TOP(){
	$months = array();
	$meses = array(
		'january' => 'Enero',
		'february' => 'Febrero',
		'march' => 'Marzo',
		'april' => 'Abril',
		'may' => 'Mayo',
		'june' => 'Junio',
		'july' => 'Julio',
		'august' => 'Agosto',
		'september' => 'Septiembre',
		'october' => 'Octubre',
		'november' => 'Noviembre',
		'december' => 'Diciembre',
	);
	for($i=0;$i<=12;$i++){
		$month = date('Y-m-01', strtotime(date('Y-m-01') . '- '.$i.' month'));
		$month = date('F', strtotime($month));
		$months[] = $meses[strtolower($month)];
	}

	return $months;
}

function conslt_vls_booking($cnslt, $add = false){
	global $wpdb;
	$sql = [];
	for($i=0;$i<=12;$i++){
		$month = date('Y-m-01', strtotime(date('Y-m-01').'- '.$i.' month'));
		$month_next = date('Y-m-d', strtotime($month . '+ 1 month'));
		$month_final = date('Y-m-d', strtotime($month_next . '- 1 days'));
		$add_cnslt = ($add === false) ? '' : $add;
		$cnslt .= " WHERE fecha BETWEEN '{$month}' AND '{$month_final}'";
		$cnslt .= $add_cnslt;
		$sql[] = (int)$wpdb->get_var($cnslt);
	}
	return $sql;
}

if(in_array('administrator', $user_data->roles)){ 
	$sql_gains = $wpdb->get_var($gains);
?>

<div class="row">
	<div class="col s12">
		<div class="card row pl-3 pr-3 pb-1 pt-1 mt-3 card_top_radius z-depth-2 center_topcamp">
			<div class="col l4 m4 s12 p-0">			
				<h5 class="text-capitalize sidebar-title topcamp-text-title">Elegir mes</h5>
			</div>
			<div class="col l4 m4 s12 pl-2 pr-2 top-np top-mtb">
				<select name="months_dash_admin_pnl">
					<option value="" selected>Todos los meses</option>
					<?php 
					foreach($meses_for_admin as $m => $d){ ?>
						<option value="<?= $m ?>"><?= $d ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col l4 m4 s12 p-0">
				<button class="btn col s12 card_top_radius button_color_top" id="fill_admin_data_dash">Filtrar</button>
			</div>
		</div>
	</div>
</div>
<div class="row mt-3 top-c-mt">
	<div class="col s12">
		<div class="row">
			<div class="col l4 m6 s12 pl-0 pr-2 top-npm">
				<div class="row central_point_dash z-depth-3">
					<div class="col s12 pt-6 pb-6">
						<div class="row">
						<div class="col s6">
							<i class="material-icons background-round mt-5 white-text">euro_symbol</i>
						</div>
						<div class="col s6">
							<span class="end_align_dts">
								<p class="adpnsy_dash_gains"><?= wc_price($sql_gains) ?></p>
								<p>Ganancias</p>
							</span>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col l4 m6 s12 pl-0 pr-0 topmt-3">
				<div class="row central_point_dash z-depth-3">
					<div class="col s12 pt-6 pb-6">
						<div class="row">
						<div class="col s6">
							<i class="material-icons background-round mt-5 white-text">forum</i>
						</div>
						<div class="col s6">
							<span class="end_align_dts">
								<p class="op_all_camps"><?= $sql_reviews ?></p>
								<p>Opiniones</p>
							</span>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col pl-2 pr-0 l4 m12 s12 top-npm top-tmt3 top-npt">
				<div class="row central_point_dash z-depth-3">
					<div class="col s12 pt-6 pb-6 top-pdtb-n">
						<div class="row">
						<div class="col s6">
							<i class="material-icons background-round mt-5 white-text">shopping_cart</i>
						</div>
						<div class="col s6">
							<span class="end_align_dts">
								<p class="adpnsy_dash_books"><?= $bookings ?></p>
								<p>Reservas</p>
							</span>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row mt-3">
	<div class="col s12">
		<div class="row">
			<div class="col l4 m6 s12 top-npm pl-0 pr-2">
				<div class="row central_point_dash z-depth-3">
					<div class="col s12 pt-6 pb-6">
						<div class="row">
						<div class="col s6">
							<i class="material-icons background-round mt-5 white-text">group</i>
						</div>
						<div class="col s6">
							<span class="end_align_dts">
								<p><?= $users_dat ?></p>
								<p>Campistas</p>
							</span>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col l4 m6 s12 pl-0 pr-0 topmt-3">
				<div class="row central_point_dash z-depth-3">
					<div class="col s12 pt-6 pb-6">
						<div class="row">
						<div class="col s6">
							<i class="material-icons background-round mt-5 white-text">cabin</i>
						</div>
						<div class="col s6">
							<span class="end_align_dts">
								<p><?= $gest_users ?></p>
								<p>Empresas</p>
							</span>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row mt-3">
	<div class="col s12">
		<div class="card animate fadeUp TOP_radius_med z-depth-2">
			<div class="card-content">
				<h4 class="header mt-0 topcamp-text-title">
					Evolución de las ganancias en el último año
				</h4>
				<div class="row">
					<div class="col s12">
						<div class="container_canvas" style="width: 100%; height: 80vh">
							<canvas class="charts" data-fondo='rgba(243, 12, 12, 1)' data-currency="0" data-type='line' data-line="rgba(243, 12, 12, 1)" data-labels='<?=json_encode( $labels );?>' data-datos='<?=json_encode($values);?>' data-label='Plazas' height="100"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<button id="comi_btn_option">Comisión</button>
<div id="gest_comi_all" class="disabled">
	<div class="comi_content">
		<i class="material-icons icon-menu comi_close">close</i>
		<form action="">
			<label for="">Introducir comisión</label>
			<input type="number" name="comision" required>
			<button>Guardar</button>
		</form>
	</div>
</div>

<?php }else if (in_array('gestor_campamento', $user_data->roles)){
	$views_table = $wpdb->prefix . 'postmeta'; 
	$campamentos = get_posts(['author' => get_current_user_id(), 'posts_per_page' => -1, 'post_type' => 'topcampamentos', 'fields' => 'ids']);
	$consult_views = '';
	$bookings_dash = 0;
	$_review_to_print = 0;
	if(!empty($campamentos)){
		$_camps = implode(",", $campamentos);
		$bookings_dash = $wpdb->get_var($sql_chart." WHERE id_gest_camp = '{$user_id}'");
		$reviews_consulta .= " WHERE post_id IN ({$_camps})";
		$reviews_sql_gest = $wpdb->get_var($reviews_consulta);
		$_review_to_print = ($reviews_sql_gest) ? $reviews_sql_gest : 0;
		$consult_views = "SELECT SUM(meta_value) FROM {$views_table} WHERE meta_key = 'entry_views' AND post_id IN ({$_camps})";
	}
	$sql_views = $wpdb->get_var($consult_views);
	$sql_view_results = ($sql_views) ? $sql_views : 0;
?>
<div class="row">
	<div class="col s12">
		<div class="card row pl-3 pr-3 pb-1 pt-1 mt-3 card_top_radius z-depth-2 center_topcamp">
			<div class="col s12 p-0">			
				<h5 class="text-capitalize sidebar-title topcamp-text-title">Elegir campamento</h5>
			</div>
			<div class="col s12 pl-2 pr-2 top-npm top-mtb">
				<select name="camp_dash_gest_pnl">
					<option value="" selected>Todos</option>
					<?php 
						$args = array(
							'post_type'      => 'topcampamentos',
							'posts_per_page' => -1,
							'post_status'    => array('publish', 'draft'),
							'author'         => $user_id,
						);
						$posts = get_posts($args);
						foreach($posts as $post){ ?>
							<option value="<?= $post->ID ?>"><?= $post->post_title ?></option>
						<?php } ?>
				</select>
			</div>
			<div class="col s12 p-0">
				<button class="btn col s12 card_top_radius button_color_top" id="fill_gest_data_dash" usr="<?= $user_id ?>">Filtrar</button>
			</div>
		</div>
	</div>
</div>
<div class="row mt-3">
	<div class="col s12">
		<div class="row">
			<div class="col l4 m6 s12 pl-0 pr-2">
				<div class="row central_point_dash z-depth-3">
					<div class="col s12 pt-6 pb-6">
						<div class="row">
						<div class="col s6">
							<i class="material-icons background-round mt-5 white-text">group</i>
						</div>
						<div class="col s6">
							<span class="end_align_dts">
								<p class="gest_views_all"><?= $sql_view_results ?></p>
								<p>Visitas</p>
							</span>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col l4 m6 s12 pl-0 pr-0 topmt-3">
				<div class="row central_point_dash z-depth-3">
					<div class="col s12 pt-6 pb-6">
						<div class="row">
						<div class="col s6">
							<i class="material-icons background-round mt-5 white-text">forum</i>
						</div>
						<div class="col s6">
							<span class="end_align_dts">
								<p class="op_gest_camps"><?= $_review_to_print ?></p>
								<p>Opiniones</p>
							</span>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col l4 m6 s12 pl-2 pr-0 top-np top-mtt">
				<div class="row central_point_dash z-depth-3">
					<div class="col s12 pt-6 pb-6">
						<div class="row">
						<div class="col s6">
							<i class="material-icons background-round mt-5 white-text">shopping_cart</i>
						</div>
						<div class="col s6">
							<span class="end_align_dts">
								<p class="booking_camp_pg_admin"><?= $bookings_dash ?></p>
								<p>Reservas</p>
							</span>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row mt-3">
	<div class="col s12">
		<div class="card animate fadeUp TOP_radius_med z-depth-2">
			<div class="card-content">
				<h4 class="header mt-0 topcamp-text-title">
					Evolución de las ganancias en el último año
				</h4>
				<div class="row">
					<div class="col s12">
					<div class="container_canvas" style="width: 100%; height: 80vh">
						<canvas class="charts" data-fondo='rgba(243, 12, 12, 1)' data-currency="0" data-type='line' data-line="rgba(243, 12, 12, 1)" data-labels='<?=json_encode( $labels );?>' data-datos='<?=json_encode($values);?>' data-label='Plazas' height="100"></canvas>					
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }else{
	wp_redirect(home_url());
    exit;
}