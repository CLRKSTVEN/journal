<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MeetSettings_model extends CI_Model
{
    public function get_settings()
    {
        return $this->db->get_where('meet_settings', ['id' => 1])->row();
    }

    public function update_settings($data)
    {
        return $this->db->update('meet_settings', $data, ['id' => 1]);
    }
}
