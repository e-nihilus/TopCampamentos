<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class listar_productos extends WP_List_Table
{

    public function prepare_items(){
      $this->process_bulk_action();
      $columns = $this->get_columns();
      $hidden = $this->get_hidden_columns();
      $sortable = $this->get_sortable_columns();

      $data = $this->table_data();
      if(count($data) > 0)
        usort( $data, array( &$this, 'sort_data' ) );
      $perPage = 20;
      $currentPage = $this->get_pagenum();
      $totalItems = count($data);
      $searchcol = array('nombre');

      if(count($data) > 0)
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
      if(count($data) > 0)
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
      $this->_column_headers = array($columns, $hidden, $sortable);
      $this->items = $data;
    }

    function no_items() {
      _e( 'No hay productos.' );
    }

    public function get_hidden_columns(){
      return array('id');
    }

    public function get_columns(){
      
        $columns = array(
            'cb'              => '<input type="checkbox" />',
            'sku'          => __('SKU', 'adpnsy'),
            'user'           => __('Inversor', 'adpnsy'),
            'beneficio'       => __('Beneficio', 'adpnsy'),
            'ventas'       => __('Ventas', 'adpnsy'),
            'devoluciones'       => __('Devoluciones', 'adpnsy'),
        );
        return $columns;
    }

    public function column_sku($item) {
      $actions['edit'] = sprintf("<a href='%s'>%s</a>'",add_query_arg("page", "adpnsy_producto", add_query_arg( "edit", $item['id'])), __('Editar', 'adpnsy'));
      $actions['asignar'] = sprintf("<a href='%s'>%s</a>'",add_query_arg( "asignar", $item['id']), __('Asignar anteriores', 'adpnsy'));
      $actions['asignar_todos'] = sprintf("<a href='%s'>%s</a>'",add_query_arg( "asignar_todos", $item['id']), __('Volver a calcular todos', 'adpnsy'));
      $actions['delete'] = sprintf("<a href='%s'>%s</a>'",add_query_arg( "delete", $item['id']), __('Borrar', 'adpnsy'));
      return sprintf('%1$s %2$s', $item['sku'], $this->row_actions($actions) );
    }

    public function column_user($item) {
    	$data_user = get_userdata($item['user']);
    	return $data_user->display_name . "($item[user])";
    }

    public function column_ventas($item) {
      global $wpdb;
      $inv_operaciones = $wpdb->prefix . "inv_operaciones";
      return $wpdb->get_var("SELECT count(*) FROM $inv_operaciones WHERE sku='$item[sku]' AND devolucion='0'");
    }

    public function column_devoluciones($item) {
      global $wpdb;
      $inv_operaciones = $wpdb->prefix . "inv_operaciones";
      return $wpdb->get_var("SELECT count(*) FROM $inv_operaciones WHERE sku='$item[sku]' AND devolucion='1'");
    }

    public function column_cb($item) {
      return sprintf('<input type="checkbox" name="ids[]" value="%d" />', $item['id']);    
    }

    public function get_sortable_columns(){
      return array(
        'sku' => array('sku', false),
        'user' => array('user', false),
        'beneficio' => array('beneficio', false)
      );
    }

    private function table_data(){
  		$s = "";
  		if(isset($_GET['s'])){
  			$s = $_GET['s'];
  			$s = "WHERE (sku LIKE '%$s%' or data_extra LIKE '%$s%' or user LIKE '%$s%' or id LIKE '%$s%')";
  		}

  		global $wpdb;
  		$inv_productos = $wpdb->prefix . "inv_productos";

  		return $wpdb->get_results( "SELECT id,sku,beneficio,user FROM $inv_productos $s;", ARRAY_A );
    }

    public function column_default( $item, $column_name ){
        switch( $column_name ) {
            case 'id':
            case 'sku':
            case 'beneficio':
            case 'user':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }

    public function get_bulk_actions() {
      return array(
        'recalc'      => __( 'Volver a calcular', 'adpnsy' )
      );
    }

    public function process_bulk_action() {

        // security check!
        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Error de validación' );

        }

        $action = $this->current_action();

        switch ( $action ) {
          case 'recalc':
            $this->recalc_all($_POST['ids']);
            break;
          default:
            return;
            break;
        }

        return;
    }

    private function recalc_all($ids = null){
      global $wpdb;
      $inv_productos = $wpdb->prefix . "inv_productos";
      $inv_operaciones = $wpdb->prefix . "inv_operaciones";
      $exitos = 0;
      $errores = 0;
      $mensaje = [];

      foreach ($ids as $id) {
        $_pr = $wpdb->get_row("SELECT * FROM $inv_productos WHERE id='$id'", ARRAY_A);
        if($_pr){
          $_operaciones = $wpdb->get_results("SELECT * FROM $inv_operaciones WHERE sku='$_pr[sku]'", ARRAY_A);
          $_p = 0;
          $_e = 0;
          foreach($_operaciones as $_operacion){
            if(!$_operacion["devolucion"]){
              $_operacion["beneficio"] = $_pr["beneficio"];
              $_operacion["user"] = $_pr["user"];
              $_operacion["compra"] = $_operacion["cantidad"] * $_pr['pdc_siva'];
              $_operacion["inversion"] = $_operacion["cantidad"] * $_pr['coste'];
              $_operacion["beneficio_total"] = $_operacion["base"] + $_operacion["fba"] + $_operacion["amz"] - ( $_operacion["cantidad"] * ($_pr['pdc_siva'] + $_pr['preparacion'] + $_pr['otros'] + $_pr['transporte']));
              $_operacion["beneficio_user"] = number_format((($_operacion["beneficio_total"]/100)*$_pr['beneficio']),2,".","");
              $_operacion["margen"] = number_format(($_operacion["beneficio_total"]/($_operacion["base"]+$_operacion["iva"]))* 100,0,".","");
              $_operacion["margen_user"] = number_format((($_operacion["margen"]/100)*$_pr['beneficio']), 0,".","");
              $_operacion["roi"] = number_format(($_operacion["beneficio_total"]/$_operacion["inversion"])* 100,0,".","");
              $_operacion["roi_user"] = number_format((($_operacion["roi"]/100)*$_pr['beneficio']), 0,".","");
            }else{
              $_operacion["beneficio"] = $_pr["beneficio"];
              $_operacion["user"] = $_pr["user"];
              $_operacion["beneficio_user"] = number_format((($_operacion["beneficio_total"]/100)*$_pr['beneficio']),2,".","");
            }
            if($wpdb->replace($inv_operaciones, $_operacion) !== false){
              $_p++;
              $exitos++;
            }else{
              $_e++;
              $errores++;
            }
          }
          $mensaje[] = "<p>Para el SKU: $_pr[sku] se asignaron $_p operación(es) al usuario con $_e error(es)</p>";
        }else{
          $mensaje[] = "<p>No se encontró el producto con el ID: $id</p>";
        }
      }

      echo "<div class='notice notice-success is-dismissible'>
        <p>Operaciones completadas, en se seleccionaron ".count($ids)." producto(s), se completaron $exitos operación(es), se encontraron $errores error(es)</p>";
        foreach($mensaje as $m) echo $m;
      echo "</div>";
      
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


