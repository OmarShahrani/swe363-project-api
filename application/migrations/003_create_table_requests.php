<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Migration_create_table_users
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_create_table_requests extends CI_Migration
{

	protected $table = 'requests';


	public function up()
	{
		$fields = array(
			'id'         => [
				'type'           => 'INT(11)',
				'auto_increment' => true,
				'unsigned'       => true,
			],
			'service'  => [
				'type' => 'VARCHAR(50)',
			],
			'requestedBy'  => [
				'type' => 'VARCHAR(50)',
			],
			'assignedTo'  => [
				'type' => 'VARCHAR(50)',
				'null' => true
			],
			'status' => [
				'type' =>	'VARCHAP(50)'
			],
			'requestedAt' => [
				'type' => 'DATE',
			],
			'due' => [
				'type' => 'DATE',
				'null' => true
			],
			'notes' => [
				'type' => 'TEXT',
				'null' => true
			],

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table, true);
	}


	public function down()
	{
		if ($this->db->table_exists($this->table)) {
			$this->dbforge->drop_table($this->table);
		}
	}
}
