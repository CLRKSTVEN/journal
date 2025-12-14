<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surprise_winners_model extends CI_Model
{
    private $table = 'surprise_winners';

    public function __construct()
    {
        parent::__construct();
        $this->ensure_table();
    }

    private function ensure_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `rank` tinyint(2) NOT NULL,
            `event_name` varchar(255) NOT NULL,
            `winner_name` varchar(255) NOT NULL,
            `municipality` varchar(150) DEFAULT NULL,
            `school` varchar(200) DEFAULT NULL,
            `coach` varchar(200) DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uniq_rank` (`rank`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->db->query($sql);

        // Add missing columns if the table already existed
        $columns = $this->db->list_fields($this->table);
        if (!in_array('event_group', $columns, true)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `event_group` varchar(100) DEFAULT NULL AFTER `event_name`");
        }
        if (!in_array('category', $columns, true)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `category` varchar(150) DEFAULT NULL AFTER `event_group`");
        }
    }

    public function get_all()
    {
        return $this->db->order_by('rank', 'ASC')->get($this->table)->result();
    }

    public function replace_all($rows)
    {
        $this->db->trans_start();
        $this->db->truncate($this->table);
        foreach ($rows as $row) {
            $this->db->insert($this->table, $row);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => (int) $id));
    }
}
