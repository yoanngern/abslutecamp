<?php
/**
 * Gluu_Serialized
 *
 * @author mat
 * @since 10/30/2014
 *
 */
class Gluu_Serialized {
	private $serialize_tables = array();

	private $possible = array();

	private $types = array(
		'longtext',
		'text',
		'mediumtext',
		'longtext'
	);


	/**
	 * wpdb
	 *
	 * @var wpdb $wpdb
	 */
	private $wpdb;


	/**
	 * Constructor
	 *
	 * @param array $custom_tables     - all custom tables in database
	 * @param array $serialized_tables - table previously marked as serialized
	 *
	 */
	public function __construct( $custom_tables, $serialized_tables ){
		$this->serialize_tables = $serialized_tables;
		$this->possible = $custom_tables;

		$this->wpdb = $GLOBALS[ 'wpdb' ];

		$this->update_list();
	}


	/**
	 * get_tables
	 *
	 * Get the finished list included the newly found serialized
	 *
	 * @return array
	 */
	public function get_tables(){
		return $this->serialize_tables;
	}


	/**
	 * update_list
	 *
	 * Run through the possibles and add matching ones
	 * to the class var
	 *
	 * @uses $this->check_for_serialized_column
	 * @return void
	 */
	public function update_list(){
		foreach( $this->possible as $table ){
			if( in_array( $table, $this->serialize_tables ) ){
				continue;
			}

			$this->check_for_serialized_column( $table );
		}
	}


	/**
	 * check_for_serialized_column
	 *
	 * Checks a tables columns for types which could
	 * possibly house serialized data
	 *
	 * @param $table
	 *
	 * @uses $this->serialized_tables
	 *
	 * @return array - ( returned mostly for testing )
	 */
	public function check_for_serialized_column( $table ){
		$columns = $this->wpdb->get_results( "DESCRIBE $table" );
		$new_columns = array();

		foreach( $columns as $column ){
			if( in_array( $column->Type, $this->types ) ){
				if( !empty( $this->serialize_tables[ $table ] ) && !is_array( $this->serialize_tables[ $table ] ) ){
					$this->serialize_tables[ $table ] = array( $this->serialize_tables[ $table ] );
				}
				$this->serialize_tables[ $table ][] = $column->Field;
				$new_columns[] = $column->Field;
			}
		}

		return $new_columns;
	}
} 