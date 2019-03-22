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
class Migration_create_table_services extends CI_Migration
{


	protected $table = 'services';


	public function up()
	{
		$fields = array(
			'id'         => [
				'type'           => 'INT(11)',
				'auto_increment' => true,
				'unsigned'       => true,
			],
			'name'  => [
				'type' => 'VARCHAR(50)',
			],
			'description'      => [
				'type'   => 'TEXT'
			],
			'icon'   => [
				'type' => 'VARCHAR(64)',
			],
			'status' => [
				'type' =>	'VARCHAR(50)',
				'default' => 'active'
			]
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table, true);

		$this->db->insert($this->table, [
			'name'      => "maintenance",
			'description'   => "Fixing and maintaining mechanical equipment, rooms, and machines. Tasks include plumbing work, flooring repair and upkeep, electrical repairs and heating and air conditioning system maintenance.",
			'icon'  => "fa fa-cogs"
		]);
		$this->db->insert($this->table, [
			'name'      => "cleaning",
			'description'   => "Stocking and supplying designated facility areas (dusting, sweeping, vacuuming, mopping, cleaning ceiling vents).",
			'icon'  => "fa fa-shower"
		]);
		$this->db->insert($this->table, [
			'name'      => "painting",
			'description'   => "Responsible for mixing, matching, and applying paint to various surfaces, completing touchups, and coordinating large painting projects.",
			'icon'  => "fa fa-paint-brush"
		]);
	}


	public function down()
	{
		if ($this->db->table_exists($this->table)) {
			$this->dbforge->drop_table($this->table);
		}
	}
}
