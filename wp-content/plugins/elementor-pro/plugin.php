<?php
namespace ElementorPro;

use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main class plugin
 */
class Plugin {

	/**
	 * @var Plugin
	 */
	private static $_instance;

	/**
	 * @var Manager
	 */
	public $modules_manager;

	private $classes_aliases = [
		'ElementorPro\Modules\PanelPostsControl\Module' => 'ElementorPro\Modules\QueryControl\Module',
		'ElementorPro\Modules\PanelPostsControl\Controls\Group_Control_Posts' => 'ElementorPro\Modules\QueryControl\Controls\Group_Control_Posts',
		'ElementorPro\Modules\PanelPostsControl\Controls\Query' => 'ElementorPro\Modules\QueryControl\Controls\Query',
	];

	/**
	 * @deprecated
	 *
	 * @return string
	 */
	public function get_version() {
		return ELEMENTOR_PRO_VERSION;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'elementor-pro' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'elementor-pro' ), '1.0.0' );
	}

	/**
	 * @return \Elementor\Plugin
	 */

	public static function elementor() {
		return \Elementor\Plugin::$instance;
	}

	/**
	 * @return Plugin
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	private function _includes() {
		require ELEMENTOR_PRO_PATH . 'includes/modules-manager.php';

		if ( is_admin() ) {
			require ELEMENTOR_PRO_PATH . 'includes/upgrades.php';
			require ELEMENTOR_PRO_PATH . 'includes/admin.php';
		}
	}

	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$has_class_alias = isset( $this->classes_aliases[ $class ] );

		// Backward Compatibility: Save old class name for set an alias after the new class is loaded
		if ( $has_class_alias ) {
			$class_alias_name = $this->classes_aliases[ $class ];
			$class_to_load = $class_alias_name;
		} else {
			$class_to_load = $class;
		}

		if ( ! class_exists( $class_to_load ) ) {
			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class_to_load
				)
			);
			$filename = ELEMENTOR_PRO_PATH . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include( $filename );
			}
		}

		if ( $has_class_alias ) {
			class_alias( $class_alias_name, $class );
		}
	}

	public function enqueue_styles() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$direction_suffix = is_rtl() ? '-rtl' : '';

		wp_enqueue_style(
			'elementor-pro',
			ELEMENTOR_PRO_ASSETS_URL . 'css/frontend' . $direction_suffix . $suffix . '.css',
			[],
			ELEMENTOR_PRO_VERSION
		);
	}

	public function enqueue_frontend_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script(
			'elementor-pro-frontend',
			ELEMENTOR_PRO_URL . 'assets/js/frontend' . $suffix . '.js',
			[
				'jquery',
			],
			ELEMENTOR_PRO_VERSION,
			true
		);

		$post = get_post();

		$locale_settings = [
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'elementor-pro-frontend' ),
			// TODO: Temp since 1.3.0
			'postTitle' => $post->post_title,
			'postDescription' => $post->post_excerpt,
			// End temp
		];

		wp_localize_script(
			'elementor-pro-frontend',
			'ElementorProFrontendConfig',
			apply_filters( 'elementor_pro/frontend/localize_settings', $locale_settings )
		);
	}

	public function enqueue_editor_scripts() {
		$suffix = Utils::is_script_debug() ? '' : '.min';

		wp_enqueue_script(
			'elementor-pro',
			ELEMENTOR_PRO_URL . 'assets/js/editor' . $suffix . '.js',
			[
				'backbone-marionette',
			],
			ELEMENTOR_PRO_VERSION,
			true
		);

		$is_license_active = false;

		$license_key = License\Admin::get_license_key();

		if ( ! empty( $license_key ) ) {
			$license_data = License\API::get_license_data();

			if ( ! empty( $license_data['license'] ) && License\API::STATUS_VALID === $license_data['license'] ) {
				$is_license_active = true;
			}
		}

		$locale_settings = [
			'i18n' => [],
			'isActive' => $is_license_active,
		];

		wp_localize_script(
			'elementor-pro',
			'ElementorProConfig',
			apply_filters( 'elementor_pro/editor/localize_settings', $locale_settings )
		);
	}

	public function register_frontend_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_script(
			'smartmenus',
			ELEMENTOR_PRO_URL . 'assets/lib/smartmenus/jquery.smartmenus' . $suffix . '.js',
			[
				'jquery',
			],
			'1.0.1',
			true
		);

		wp_register_script(
			'social-share',
			ELEMENTOR_PRO_URL . 'assets/lib/social-share/social-share' . $suffix . '.js',
			[
				'jquery',
			],
			'0.2.17',
			true
		);
	}

	public function enqueue_editor_styles() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style(
			'elementor-pro',
			ELEMENTOR_PRO_URL . 'assets/css/editor' . $suffix . '.css',
			[
				'elementor-editor'
			],
			ELEMENTOR_PRO_VERSION
		);
	}

	public function elementor_init() {
		$this->modules_manager = new Manager();

		$elementor = \Elementor\Plugin::$instance;

		// Add element category in panel
		$elementor->elements_manager->add_category(
			'pro-elements',
			[
				'title' => __( 'Pro Elements', 'elementor-pro' ),
				'icon' => 'font',
			],
			1
		);

		$elementor->editor->add_editor_template( __DIR__ . '/includes/templates/editor.php' );

		do_action( 'elementor_pro/init' );
	}

	private function setup_hooks() {
		add_action( 'elementor/init', [ $this, 'elementor_init' ] );

		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'register_frontend_scripts' ] );

		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );

		add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'enqueue_frontend_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ] );
	}

	/**
	 * Plugin constructor.
	 */
	private function __construct() {
		spl_autoload_register( [ $this, 'autoload' ] );

		$this->_includes();

		$this->setup_hooks();

		if ( is_admin() ) {
			new Upgrades();
			new Admin();
			new License\Admin();
		}
	}
}

if ( ! defined( 'ELEMENTOR_PRO_TESTS' ) ) {
	// In tests we run the instance manually.
	Plugin::instance();
}
