<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_users
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_create_table_users extends CI_Migration {


	protected $table = 'users';


	public function up()
	{
		$fields = array(
			'id'         => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'username'  => [
				'type' => 'VARCHAR(50)',
			],
			'email'      => [
				'type'   => 'VARCHAR(255)',
				'unique' => TRUE,
			],
			'password'   => [
				'type' => 'VARCHAR(64)',
			],
			'name'  => [
				'type' => 'VARCHAR(100)',
			],
			'role'  => [
				'type' => 'VARCHAR(50)',
			],
			'status'  => [
				'type' => 'VARCHAR(50)',
			],
			'created_at' => [
				'type' => 'DATETIME',
			],
    );
    $this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($this->table, TRUE);

		$this->db->insert($this->table, [
			'username'  => "admin",
			'email'      => "s201416900@kfupm.edu.sa",
			'password'   => password_hash('admin', PASSWORD_DEFAULT),
			'name'  => "Omar Alshahrani",
			'role'  => "admin",
			'status'  => "active",
			'created_at' => date('Y-m-d H:i:s'),
		]);
	}


	public function down()
	{
		if ($this->db->table_exists($this->table))
		{
			$this->dbforge->drop_table($this->table);
		}
	}

}