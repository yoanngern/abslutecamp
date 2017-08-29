<?php


/**
 * Gluu_Checkboxes
 *
 * @author Mat Lipe
 *
 */
class Gluu_Checkboxes {

	private $checkboxes;

	/**
	 * wpdb
	 *
	 * @var wpdb $wpdb ;
	 */
	private $wpdb;


	public function __construct(){
		$this->wpdb = $GLOBALS[ 'wpdb' ];

		$this->create_checkbox_list();
	}


	/**
	 * Retrieve the list of tables to update based on
	 * which types are checked.
	 *
	 *
	 * @param $tables
	 *
	 * @return array
	 */
	public function swap_tables( $tables ){
		$clean_tables = array();

		foreach( $tables as $table ){
			if( isset( $this->checkboxes[ $table ] ) ){
				$clean_tables = array_merge( $this->checkboxes[ $table ]->tables, $clean_tables );
			}
		}

		return array_flip( $clean_tables );
	}


	private function create_checkbox_list(){
		$this->checkboxes = array(
			'posts'    => $this->posts(),
			'comments' => $this->comments(),
			'terms'    => $this->terms(),
			'options'  => $this->options(),
			'user'     => $this->users(),
			'custom'   => $this->custom()
		);
		if( is_multisite() ){
			$this->checkboxes[ 'network' ] = $this->network();
		}
	}


	public function render(){
		?>
		<ul id="gluu-checkboxes">
			<?php
			foreach( $this->checkboxes as $checkbox => $data ){
				?>
				<li>
					<?php
					if( version_compare( GLUU_VERSION, "4.0.0", ">=" ) ){
						printf( '<input name="%s[]" type="checkbox" value="%s" checked /> %s', GoLiveUpdateUrls::TABLE_INPUT_NAME, $checkbox, $data->label );

					} else {
						printf( '<input name="%s" type="checkbox" value="%s" checked /> %s', $checkbox, $checkbox, $data->label );
					}
					?>
				</li>
				<?php

			}
			?>
		</ul>
		<?php
	}


	private function comments(){
		return (object) array(
			'label'  => __( 'Comments', 'gluu' ),
			'tables' => array(
				$this->wpdb->commentmeta,
				$this->wpdb->comments
			)
		);
	}


	private function users(){
		return (object) array(
			'label'  => __( 'Users', 'gluu' ),
			'tables' => array(
				$this->wpdb->usermeta
			)
		);
	}


	private function terms(){
		$data = (object) array(
			'label'  => __( 'Categories, Tags, Custom Taxonomies', 'gluu' ),
			'tables' => array(
				$this->wpdb->terms,
				$this->wpdb->term_relationships,
				$this->wpdb->term_taxonomy
			)
		);

		//term meta support since WP 4.4
		if( isset( $this->wpdb->termmeta ) ){
			$data->tables[] = $this->wpdb->termmeta;
		}
		return $data;

	}


	private function options(){
		return (object) array(
			'label'  => __( 'Site Options, Widgets', 'gluu' ),
			'tables' => array(
				$this->wpdb->options
			)
		);
	}


	private function posts(){
		return (object) array(
			'label'  => __( 'Posts, Pages, Custom Post Types', 'gluu' ),
			'tables' => array(
				$this->wpdb->posts,
				$this->wpdb->postmeta,
				$this->wpdb->links
			)
		);
	}


	private function network(){
		return (object) array(
			'label'  => __( 'Network Settings', 'gluu' ),
			'tables' => array(
				$this->wpdb->sitemeta,
				$this->wpdb->site
			)
		);
	}


	public function custom(){
		static $custom;
		if( !empty( $custom ) ){
			return $custom;
		}

		$default_tables = $this->wpdb->tables();
		$all_tables     = wp_list_pluck( GoLiveUpdateUrls::get_all_tables(), 'TABLE_NAME' );
		$all_tables = array_flip( $all_tables );
		foreach( $default_tables as $table ){
			unset( $all_tables[ $table ] );
		}

		$custom = (object)array(
			'label'  => __( 'Custom tables created by other plugins', 'gluu' ),
			'tables' => array_flip( $all_tables )
		);

		return $custom;


	}


}