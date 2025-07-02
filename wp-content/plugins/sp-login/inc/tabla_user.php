<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class lista_spuser extends WP_List_Table
{

    public function prepare_items(){
      $this->process_bulk_action();
      $columns = $this->get_columns();
      $hidden = $this->get_hidden_columns();
      $sortable = $this->get_sortable_columns();
      $data = $this->table_data();
      if(count($data) > 0)
        usort( $data, array( &$this, 'sort_data' ) );
      $perPage = 30;
      $currentPage = $this->get_pagenum();
      $totalItems = count($data);
      $searchcol = array('nombre');

      if(count($data) > 0)
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
      if(count($data) > 0) $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
      $this->_column_headers = array($columns, $hidden, $sortable);
      $this->items = $data;
    }

    function no_items() {
      _e( 'No hay productos.' );
    }

    public function get_sortable_columns(){
      return array(
        'cif' => array('cif', false),
        'nombre_fiscal' => array('nombre_fiscal', false),
        'nombre_comercial' => array('nombre_comercial', false),
        'responsable' => array('responsable', false)
      );
    }

    public function get_hidden_columns(){
      return array();
    }

    public function get_columns(){
      
        $columns = array(
            'cb'                => '<input type="checkbox" />',
            'cif'               => __('CIF', 'spuser'),
            'nombre_fiscal'     => __('Nombre Fiscal', 'spuser'),
            'nombre_comercial'  => __('Nombre Comercial', 'spuser'),
            'responsable'       => __('Responsable', 'spuser'),
            'estado'            => __('Estado', 'spuser')
        );
        return $columns;
    }

    public function column_cb($item) {
        return sprintf('<input type="checkbox" name="ids[]" value="%d" />', $item['id']);    
    }

    public function column_estado($item) {
        return $item["data_user"]?'Registrado':'Pendiente';    
    }

    public function column_cif($item) {
        $actions['viwer'] = sprintf("<a href='#' class='viwer_register' dts='%s'>%s</a>'",json_encode($item), __('Ver', 'spuser'));
        if(!$item["data_user"])$actions['aprobar'] = sprintf("<a href='%s'>%s</a>'",add_query_arg("aprobar", $item['id']), __('Aprobar', 'spuser'));
        if($item["data_user"] && !$item["code"])$actions['desactivar'] = sprintf("<a href='%s'>%s</a>'",add_query_arg("desactivar", $item['id']), __('Desactivar acceso', 'spuser'));
        if($item["data_user"] && $item["code"])$actions['activar'] = sprintf("<a href='%s'>%s</a>'",add_query_arg("activar", $item['id']), __('Activar acceso', 'spuser'));
        $actions['delete'] = sprintf("<a href='%s'>%s</a>'",add_query_arg( "delete", $item['cif']), __('Borrar', 'spuser'));
        return sprintf('%1$s %2$s', $item['cif'], $this->row_actions($actions) );
    }

    private function table_data(){
      $s = "";
      if(isset($_GET['s'])){
        $s = $_GET['s'];
        $s = "WHERE (cif LIKE '%$s%' or responsable LIKE '%$s%' or nombre_fiscal LIKE '%$s%' or nombre_comercial LIKE '%$s%' or direccion LIKE '%$s%')";
      }

      global $wpdb;
      $spuser_data = $wpdb->prefix . "spuser_data";
      $data_p = $wpdb->get_results( "SELECT id,nombre_comercial, nombre_fiscal, direccion, cif, poblacion, provincia, zip, responsable, telefono, movil, correo, data_user, code  FROM $spuser_data $s;", ARRAY_A );
      return $data_p;
    }

    public function column_default( $item, $column_name ){
        switch( $column_name ) {
            case 'cif':
            case 'nombre_fiscal':
            case 'nombre_comercial':
            case 'responsable':
            case 'estado':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }


    public function get_bulk_actions() {
      return array(
        'delete'   => __( 'Borrar', 'exty' ),
        'delete'   => __( 'Borrar', 'exty' )
      );
    }

    public function process_bulk_action() {

        // security check!
        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( '¡Error! ¡El control de seguridad falló!' );

        }

        $action = $this->current_action();

        switch ( $action ) {
            case 'delete':
                break;

            default:
                return;
                break;
        }

        return;
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */

    private function sort_data( $a, $b ){
        // Set defaults
        $orderby = 'id';
        $order = 'desc';
        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }
        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }
        $result = strnatcmp( $a[$orderby], $b[$orderby] );
        if($order === 'asc')
        {
            return $result;
        }
        return -$result;
    }

}


