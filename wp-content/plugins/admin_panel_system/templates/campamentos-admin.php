<script>
    let emptyCamps = true;
</script>
<?php 
$user_id = get_current_user_id();
$user_data = get_userdata($user_id);
if(!in_array('administrator', $user_data->roles) ){
    wp_redirect(home_url());
    exit;
}
global $wpdb;
$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
$topcamps = [];
$args = array(
    'post_type' => 'topcampamentos',
    'posts_per_page' => -1,
);

$posts = get_posts($args);
if($posts){

    foreach($posts as $key => $post){
        $post_id = $post->ID;
        $cnslt = "SELECT SUM(plazas) as rs, SUM(precio) as pr FROM {$camp_bookings_top} WHERE id_camp = '{$post_id}'";
        $sql = $wpdb->get_results($cnslt);
        $topcamps[$key]['camp'] = $post->post_title;
        $user = get_userdata($post->post_author);
        $topcamps[$key]['empresa'] = $user->display_name;
        $topcamps[$key]['reservas'] = ($sql[0]->rs) ? $sql[0]->rs : 0;
        $topcamps[$key]['gains'] = $sql[0]->pr;
        $topcamps[$key]['id'] = $post_id;
    }

}else{ ?>
<script>
    emptyCamps = false;
</script>
<?php } ?>

<div class="row mt-3">
    <div class="col s12">
        <div class="card material-table table-top-camps load_booking_rs_table">
            <table id="campamentos_admin_panel">
                <thead>
                    <tr>
                        <th>Campamento</th>
                        <th>Empresa</th>
                        <th>Reservaciones</th>
                        <th>Ganancias generadas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($topcamps as $camp){ ?>
                        <tr>
                            <td class="title_camp_dlt" nmdlt="<?= $camp['id'] ?>"><?= $camp['camp'] ?></td>
                            <td><?= $camp['empresa'] ?></td>
                            <td><?= $camp['reservas'] ?></td>
                            <td><?= wc_price($camp['gains']) ?></td>
                            <td><i class="material-icons icon-menu delete_camps" dlt="<?= $camp['id'] ?>" title="Eliminar <?= $camp['camp'] ?>">delete</i></td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>