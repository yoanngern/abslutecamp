<?php


/**
 * Gluu_SerializedTest.php
 *
 * @author  mat
 * @since   11/22/2014
 *
 * @package wordpress *
 */
class Gluu_SerializedTest extends WP_UnitTestCase {

	/**
	 * o
	 *
	 * @var Gluu_Serialized
	 */
	private $o;


	function setUp(){
		parent::setUp();
		$c = new Gluu_Checkboxes();
		$g = GoLiveUpdateUrls::get_instance();
		$possibles = $c->custom();
		$this->o = new Gluu_Serialized( $possibles->tables, $g->getSerializedTables() );

	}

	function test_check_tables(){
		global $wpdb;
		$required = array( $wpdb->options, $wpdb->postmeta, $wpdb->commentmeta );
		$tables = array_keys( $this->o->get_tables() );
		foreach( $required as $_table ){
			$this->assertContains( $_table, $tables, "We are not getting the all required tables back" );
		}

	}


	function test_check_for_serialized_column(){
		global $wpdb;

		$columns = $this->o->check_for_serialized_column( $wpdb->options );

		$this->assertContains( 'option_value', $columns, "The check for serialized columns broke" );

	}
}
 