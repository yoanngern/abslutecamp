<?php
/**
 * Gluu_Pro
 *
 * @author mat
 * @since 10/30/2014
 *
 * @todo move the call to $this->checkboxes->render() to new action 'gluu_after_checkboxes'
 *       Have to wait until people have updated the basic version.
 *
 */
class Gluu_Pro {

	/**
	 * checkboxes
	 *
	 * @var Gluu_Checkboxes $checkboxes
	 */
	private $checkboxes;


	private function __construct(){
		$this->checkboxes = new Gluu_Checkboxes();

		$this->hooks();

	}


	private function hooks(){
		add_filter( 'gluu-uncheck-message', array( $this, 'check_message' ) );

		add_filter( 'go-live-update-urls-serialized-tables', array( $this, 'add_serialized_tables' ) );
		add_filter( 'go-live-update-urls-success-message', array( $this, 'success_message' ) );

		if( version_compare( GLUU_VERSION, "3.1.0" ) === -1 ){
			add_filter( 'gluu-seralized-tables', array( $this, 'add_serialized_tables' ) );
		}

		if( version_compare( GLUU_VERSION, "4.0.0", ">=" ) ){
			add_action( 'gluu_after_checkboxes', array( $this, 'checkboxes' ) );
			add_filter( 'gluu-use-default_checkboxes', '__return_false' );
			add_action( 'gluu_before_checkboxes', array( $this, 'safe_to_update_message' ) );

		} else {
			add_filter( 'gluu-top-message', array( $this, 'top_message' ) );
			add_filter( 'gluu-use-default_checkboxes', array( $this, 'checkboxes' ) );
		}
		add_action( 'gluu-before-make-update', array( $this, 'swap_tables' ), 2 );
	}

	public function success_message(){
		return __( 'The URLS in the checked sections have been updated.', 'go-live-update-urls' );
	}

	public function safe_to_update_message(){
		?>
		<div id="message" class="updated notice notice-success is-dismissible">
			<p>
				<?php echo $this->top_message( "" ); ?>
			</p>
		</div>
		<?php
	}


	/**
	 * add_serialized_tables
	 *
	 * Go through the custom tables, pull out the serialized ones and
	 * add them to the array so we update them properly
	 *
	 * Do nothing is we do not have custom checked
	 *
	 * @param $tables
	 *
	 * @return array
	 */
	public function add_serialized_tables( $tables ){
		$custom = $this->checkboxes->custom();

		$serial = new Gluu_Serialized( $custom->tables, $tables );

		return $serial->get_tables();
	}


	/**
	 * swap_tables
	 *
	 * Convert tables to standard values
	 * This will receive a list of table categories
	 * We need table names
	 *
	 * @param GoLiveUpdateUrls $GLUU
	 *
	 * @return void
	 */
	public function swap_tables( $GLUU ){
		$GLUU->tables = $this->checkboxes->swap_tables( $GLUU->tables );
	}


	public function checkboxes(){
		$this->checkboxes->render();

		//prevent default checkboxes from running with basic version < 4.0.0
		return false;
	}


	public function check_message( $message ){
		return __( 'Only the checked sections will be updated.', 'gluu' );
	}


	public function top_message( $message ){
		return __( 'All tables are safe to update.', 'gluu' );
	}

	//********** SINGLETON FUNCTIONS **********/

	/**
	 * Instance of this class for use as singleton
	 */
	private static $instance;


	/**
	 * Create the instance of the class
	 *
	 * @static
	 * @return void
	 */
	public static function init(){
		self::$instance = self::get_instance();
	}


	/**
	 * Get (and instantiate, if necessary) the instance of the
	 * class
	 *
	 * @static
	 * @return self
	 */
	public static function get_instance(){
		if( !is_a( self::$instance, __CLASS__ ) ){
			self::$instance = new self();
		}

		return self::$instance;
	}
} 