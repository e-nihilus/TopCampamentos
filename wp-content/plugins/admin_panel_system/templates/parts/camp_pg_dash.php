<div class="row mt-3">
    <div class="col s4">
        <button class="add_camp_TOP" act="add_camp">Añadir Campamento</button>
    </div>
</div>

<div class="row mt-3">
    <div class="col s12">
        <div class="card material-table table-top-camps">
            <table id="registro_campamentos">
                <thead>
                    <tr>
                        <th>Campamentos</th>
                        <th>Visitas</th>
                        <th>Reservas</th>
                        <th>Opiniones</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
		            global $wpdb;
		            $camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		            $views_table = $wpdb->prefix . 'postmeta'; 
		            $reviews = $wpdb->prefix . 'jet_reviews';
                    $args = array(
                        'post_type'      => 'topcampamentos',
                        'posts_per_page' => -1,
                        'post_status'    => array('publish', 'draft'),
                        'author'         => get_current_user_id(),
                    );
                    
                    $posts = get_posts($args);
                    
                    foreach ($posts as $post) { 
                        $reviews_consulta = $wpdb->get_var("SELECT COUNT(*) FROM {$reviews} WHERE post_id = {$post->ID}");
                        $reviews_consulta = ($reviews_consulta) ? $reviews_consulta : 0;
                        $views = $wpdb->get_var("SELECT SUM(meta_value) FROM {$views_table} WHERE meta_key = 'entry_views' AND post_id = {$post->ID}");
                        $views = ($views) ? $views: 0;
                        $reservas = $wpdb->get_var("SELECT SUM(plazas) FROM {$camp_bookings_top} WHERE id_camp = {$post->ID}");
                        $reservas = ($reservas) ? $reservas : 0;
                    ?>
                    <tr>
                        <td> <?= $post->post_title ?> </td>
                        <td><?= $views ?></td>
                        <td><?= $reservas ?></td>
                        <td><?= $reviews_consulta ?></td>
                        <td> <?= ($post->post_status == 'publish') ? 'Publicado' : 'Borrador'; ?> </td>
                        <td class="camps_acts">
                            <a target="_blank" href="<?= get_permalink($post->ID) ?>" title="Enlace al campamento <?= get_the_title($post->ID) ?>">
                                <i class="material-icons icon-menu">visibility</i>
                            </a>
                            <a href="#" class="btns_acts_camps" act="<?= $post->ID ?>" title="Editar <?= get_the_title($post->ID) ?>">
                                <i class="material-icons icon-menu">edit</i>
                            </a>
                        </td>
                    </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>