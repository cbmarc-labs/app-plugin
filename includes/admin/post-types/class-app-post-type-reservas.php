<?php

if ( ! defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly
}

if( !class_exists( 'APP_Post_Type_Reservas' ) ) :

/**
 * APP_Post_Type_Reservas
 *
 * APP_Post_Type_Reservas
 *
 * @class 		APP_Post_Type_Reservas
 * @version		1.0.0
 * @package		application/includes/admin/post-types/APP_Post_Type_Reservas
 * @category	Class
 * @author 		cbmarc
 */
class APP_Post_Type_Reservas
{

	// singleton instance
	private static $_instance;
	
	const POST_TYPE = 'cpt_reservas';

	private $plural = 'reservas';
	private $singular = 'reserva';

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		App::log( 'APP_Post_Type_Reservas Class Initialized' );
		
		// Initialise
		add_action( "init", array( &$this, 'init' ) );
		
		add_action( "manage_" . self::POST_TYPE . "_posts_custom_column", array( &$this, 'manage_posts_custom_column' ), 10, 2 );
		add_action( 'admin_head', array( &$this, 'admin_head' ) );
		add_action( "admin_bar_menu", array( &$this, 'admin_bar_menu' ), 99);
		add_action( 'pre_get_posts', array( &$this, 'pre_get_posts' ) );
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );

		add_filter( "request", array( &$this, 'request' ) );
		add_filter( "manage_edit-" . self::POST_TYPE . "_sortable_columns", array( &$this, 'manage_edit_sortable_columns' ) );
		add_filter( "manage_" . self::POST_TYPE . "_posts_columns", array( &$this, 'manage_posts_columns' ) );
		add_filter( "nav_menu_items_" . self::POST_TYPE, array( &$this, 'nav_menu_items' ), null, 3 );
	}

	// --------------------------------------------------------------------

	/**
	 * getInstance method
	 *
	 * @access public
	 */
	public static function instance()
	{
		if ( is_null( self::$_instance ) )
		{
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}

	// --------------------------------------------------------------------

	/**
	 * init method
	 *
	 * @access public
	 */
	function init()
	{
		global $wp_rewrite;
		
		register_post_type( self::POST_TYPE, array(
				'labels' => array(
						'name'					=> _x( ucwords( $this->plural ), 'post type general name' ),
						'singular_name'			=> _x( ucwords( $this->plural ), 'post type singular name' ),
						'add_new'				=> _x( 'Add New ' . ucwords( $this->singular ), 'add new reserva' ),
						'add_new_item'			=> __( 'Add New ' . ucwords( $this->singular ) ),
						'edit_item'				=> __( 'Edit ' . ucwords( $this->singular ) ),
						'new_item'				=> __( 'New ' . ucwords( $this->singular ) ),
						'all_items'				=> __( 'Todas las ' . ucwords( $this->plural ) ),
						'view_item'				=> __( 'View ' . ucwords( $this->singular ) ),
						'search_items'			=> __( 'Search ' . ucwords( $this->singular ) ),
						'not_found'				=> __( 'No ' . 'Reservas found' ),
						'not_found_in_trash'	=> __( 'No ' . 'Reservas found in Trash'),
						'parent_item_colon'		=> '',
						'menu_name'				=> ucwords( $this->plural )
				),
				'public'				=> false, //true
				'show_ui'				=> true,
				//'hierarchical'			=> true,
				'has_archive'			=> true,
				'exclude_from_search'	=> true,
				'publicly_queryable'	=> true,
				'ep_mask'				=> EP_PERMALINK,
				//'taxonomies' => array('category'),
				'supports'			=> array( 'editor', 'custom-fields' ),
				'rewrite'				=> array(
						'slug'	=> $this->singular, 'with_front' => FALSE
				),
		) );
		
		// se registran las mismas categorias que el plugin tribe_events
		register_taxonomy_for_object_type( 'category', 'tribe_events' );
	}

	// --------------------------------------------------------------------

	/**
	 * admin_init method
	 *
	 * @access public
	 */
	function admin_init()
	{
		register_setting( 'reservas_option_group', 'reservas_options' );
	}

	// --------------------------------------------------------------------

	/**
	 * request method
	 *
	 * @access public
	 */
	function request( $vars )
	{
		return $vars;
	}

	// --------------------------------------------------------------------
	
	/**
	 * pre_get_posts method
	 *
	 * @access public
	 */
	function admin_menu()
	{		
		add_submenu_page(
			"edit.php?post_type=" . self::POST_TYPE,
			'Options',
			'Opcions',
			'manage_options',
			self::POST_TYPE . '_options',
			 array( &$this, 'options_page' )
		);
	}

	// --------------------------------------------------------------------
	
	/**
	 * pre_get_posts method
	 *
	 * @access public
	 */
	function options_page()
	{
		?>
		
		<div class="wrap">
        	<h2>Opcions de Reservas</h2>
        
        	<?php settings_errors(); ?>
        
        	<form method="post" action="options.php">
        
            	<?php settings_fields('reservas_option_group'); ?>
            	<?php $options = get_option('reservas_options'); ?>
            
            	<table class="form-table">
            		<tbody>
            		
            			<tr>
							<th scope="row">
								<label for="blogdescription">Enviar reserves per email</label>
							</th>
							<td>
								<input name="reservas_options[send_email]" type="text" id="send_email" value="<?php echo $options[ 'send_email' ]; ?>" class="regular-text">
								<p class="description">Quan es crea una reserva s'envia a les direccions de correu electrònic definits aquí. <br>Ex.: dest1@domini1.com, dest2@domini2.com</p>
							</td>
						</tr>
						
						<tr>
							<th scope="row">Contestar reserva</th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span>Contestar reserva</span>
									</legend>
									
									<p>
										<label for="blacklist_keys">Contestació de reserva efectuada al destinatari.</label>
									</p>
									
									<p>
										<textarea name="reservas_options[send_email_text]" rows="10" cols="50" id="send_email_text" class="large-text code"><?php echo $options[ 'send_email_text' ]; ?></textarea>
									</p>
								</fieldset>
							</td>
						</tr>
						
                	</tbody>
            	</table>
            	
            	<p class="submit">
            		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            	</p>
            
        </form>
        
    	</div>
		
		<?php
	}

	// --------------------------------------------------------------------
	
	/**
	 * pre_get_posts method
	 *
	 * @access public
	 */
	function pre_get_posts( $query )
	{
		if( ! is_admin() )
		{
			return;
		}
		
		$orderby = $query->get( 'orderby');
		
		if( $orderby == 'res_start_date' )
		{
			$query->set( 'meta_key', 'res_start_date' );
			$query->set( 'orderby', 'res_start_date' );
		}
	}

	// --------------------------------------------------------------------

	/**
	 * manage_edit_sortable_columns method
	 *
	 * @access public
	 */
	function manage_edit_sortable_columns( $columns )
	{
		$columns['res_start_date'] = 'res_start_date';
		
		return $columns;
	}

	// --------------------------------------------------------------------

	/**
	 * manage_posts_columns method
	 *
	 * @access public
	 */
	function manage_posts_columns( $columns )
	{
		return array_merge(
				$columns,
				array('res_start_date' => __('Data inici esdeveniment')
				)
		);
	}

	// --------------------------------------------------------------------

	/**
	 * manage_posts_custom_column method
	 *
	 * @access public
	 */
	function manage_posts_custom_column( $column, $post_id )
	{
		switch ( $column )
		{
			case 'res_start_date' :
				$res_start_date = get_post_meta( $post_id, 'res_start_date', TRUE );
				
				echo gmdate("d/m/Y", $res_start_date);
				echo "<br>";
				echo gmdate("H:i:s", $res_start_date);
				
				break;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * admin_head method
	 *
	 * @access public
	 */
	function admin_head()
	{
		echo '<style>.column-res_start_date { width: 20% }</style>';
	}

	// --------------------------------------------------------------------

	/**
	 * nav_menu_items method
	 * 
	 * Crea un apartado en el apartado menu, para ver todas las entradas
	 *
	 * @access public
	 */
	public function nav_menu_items( $posts, $args, $post_type )
	{
		global $_nav_menu_placeholder, $wp_rewrite;
		
		$_nav_menu_placeholder = ( 0 > $_nav_menu_placeholder ) ? intval($_nav_menu_placeholder) - 1 : -1;
		$url = '?post_type=' . self::POST_TYPE;
		
		if( get_option('permalink_structure') )
		{
			$url = $this->plural;
		}
		
		array_unshift( $posts, (object) array(
				'ID' => 0,
				'object_id' => $_nav_menu_placeholder,
				'post_content' => '',
				'post_excerpt' => '',
				'post_title' => $post_type['args']->labels->all_items,
				'post_type' => 'nav_menu_item',
				'type' => 'custom',
				'url' => get_site_url() . "/" . $url
		) );
		
		return $posts;
	}

	// --------------------------------------------------------------------

	/**
	 * admin_bar_menu method
	 * 
	 * Crea un link en la parte superior del front-end para acceder a las entradas
	 *
	 * @access public
	 */	
	public function admin_bar_menu()
	{
		global $wp_admin_bar;
		
		$url = '?post_type=' . self::POST_TYPE;
		
		if( get_option('permalink_structure') )
		{
			$url = $this->plural;
		}
		
		$args = array(
				'id' => 'admin-bar-menu-' . self::POST_TYPE,
				'title' => ucwords( $this->plural ),
				'href' => get_site_url() . "/" . $url,
				'meta' => array(
						'class' => 'admin-bar-menu-class-' . self::POST_TYPE
				)
		);
		
		$wp_admin_bar->add_node($args);
	} 

	// --------------------------------------------------------------------

	/**
	 * add_new_reserva method
	 * 
	 * Crea una nueva entrada por codigo. Ej.:
	 *
	 * global $CPT_Reservas;
	 * $CPT_Reservas->add_new_reserva($title, $content);
	 *
	 * @access public
	 */
	public function add_new_reserva($title, $content, $metadata)
	{
		// Create post object
		$new_entry = array();
		$new_entry['post_title'] = esc_html($title);
		$new_entry['post_content'] = wp_kses($content, $allowed_html);
		$new_entry['post_status'] = 'publish';
		$new_entry['post_type'] = self::POST_TYPE;
		//$new_entry['post_author'] = $userID;

		// Insert the post into the database
		$entry_id = wp_insert_post( $new_entry );
		
		// Insert metadata into the database
		foreach ( $metadata as $key => $val )
		{
			add_post_meta( $entry_id, $key, $val );
		}
	}

} // end class APP_CPT_Reservas

endif;

/**
 * Create instance
 */
global $APP_Post_Type_Reservas;
if( class_exists( 'APP_Post_Type_Reservas' ) && !$APP_Post_Type_Reservas )
{
	$APP_Post_Type_Reservas = APP_Post_Type_Reservas::instance();
}