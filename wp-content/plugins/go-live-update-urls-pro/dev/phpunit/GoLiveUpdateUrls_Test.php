<?php


/**
 * GoLiveUpdateUrls_Test
 *
 * @author Mat Lipe
 * @since  8/14/2015
 *
 */
class GoLiveUpdateUrls_Test extends WP_UnitTestCase {
	const OPTION = 'gluu_testing_data';

	private $data = array(
		'single' => 'nowhere.com',
		'sub'    => 'www.nowhere.com',
		'text'   => 'I am going" nowhere but yet I can still find nowhere.com and www.nowhere.com'
	);

	public function setUp(){
		parent::setUp();
		update_option( self::OPTION, $this->data );
	}


	public function test_domain_switch(){
		global $wpdb;
		$class         = GoLiveUpdateUrls::get_instance();
		$tables = wp_list_pluck( $class::get_all_tables(), 'TABLE_NAME' );
		$class->tables = array_combine( $tables, $tables );
		$class->oldurl = 'nowhere.com';
		$class->newurl = 'somewhere.com';
		$class->makeTheUpdates();

		//have to do it this way because of cache not refresh till next page load
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s LIMIT 1", self::OPTION ) );

		$data = unserialize( $row->option_value );

		$this->assertEquals( 'somewhere.com', $data[ 'single' ] );
		$this->assertEquals( 'www.somewhere.com', $data[ 'sub' ] );
		$this->assertNotContains( 'nowhere.com', $data[ 'text' ] );

	}

	public function test_subdomain_addition(){
		global $wpdb;
		$class = GoLiveUpdateUrls::get_instance();
		$tables = wp_list_pluck( $class::get_all_tables(), 'TABLE_NAME' );
		$class->tables = array_combine( $tables, $tables );
		$class->oldurl = 'nowhere.com';
		$class->newurl = 'www.nowhere.com';
		$class->makeTheUpdates();
		//have to do it this way because of cache not refresh till next page load
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s LIMIT 1", self::OPTION ) );

		$data = unserialize( $row->option_value );

		$this->assertEquals( 'www.nowhere.com', $data[ 'single' ] );
		$this->assertEquals( 'www.nowhere.com', $data[ 'sub' ] );
		$this->assertNotContains( 'www.www.nowhere.com', $data[ 'text' ] );
	}

}