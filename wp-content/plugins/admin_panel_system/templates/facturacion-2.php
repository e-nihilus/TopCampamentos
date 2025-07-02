<?php
    $user_id = get_current_user_id();
    $user_data = get_userdata($user_id);
    if(!in_array('administrator', $user_data->roles) ){
        wp_redirect(home_url());
        exit;
    }
    global $wpdb;
    $camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
    $sql = $wpdb->get_results("SELECT MONTH(fecha) as M, YEAR(fecha) as Y FROM {$camp_bookings_top} GROUP BY YEAR(fecha), MONTH(fecha) ORDER BY fecha DESC");
    $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    $options = [];
    if(!empty($sql)) foreach ($sql as $d) {
        $options["{$d->Y}-{$d->M}"] = $meses[($d->M-1)] . " " . $d->Y;
    }
?>
<div class="filter_booking_adp filter_booking_adpnsy_pg row mt-3 fill">
    <div class="col s12">
        <div class="card material-table table-top-camps row valign-wrapper">
            <div class="col s8">
                <select name="" id="select_fil_fact_booking_camp">
                    <option value="" selected>Todos los meses</option>
                    <?php if(!empty($options)) foreach ($options as $key => $value) { ?>
                        <option value="<?=$key;?>"><?=$value;?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col s4">
                <button class="filter_booking_btn btn btn-valid fil no_fil width-100 back_top_second" id="btn_fil_fact_booking_camp">Filtrar</button>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col s12">
        <div class="card material-table table-top-camps load_booking_rs_table">
            <table id="facutracion_admin">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Campamento</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Reservaciones</th>
                        <th>Empresa</th>
                        <th>Comisión</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal_fc_info_pg" class="disabled">
    <div class="container_content">
        <div class="content_modal_rs_pg">
            <i class="material-icons icon-menu tbl_fc_close">close</i>
            <h2>Reserva #<span></span></h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Campamento</th>
                        <th>Fechas</th>
                        <th>Plazas</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>