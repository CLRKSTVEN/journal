<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_all()
    {
        $hasStatus = $this->db->field_exists('is_active', 'users');
        $this->db->select('userID, IDNumber, username, position, fName, mName, lName, email, avatar, dateCreated');
        if ($hasStatus) {
            $this->db->select('is_active');
        }
        $this->db->from('users');
        $this->db->order_by('dateCreated', 'DESC');

        $results = $this->db->get()->result();

        if (!$hasStatus) {
            foreach ($results as $row) {
                $row->is_active = 1; // assume active if column is missing
            }
        }

        return $results;
    }

    public function get_by_id($userID)
    {
        return $this->db->get_where('users', array('userID' => $userID), 1)->row();
    }

    public function get_by_email($email)
    {
        return $this->db->get_where('users', array('email' => $email), 1)->row();
    }

    public function get_by_idnumber($idNumber)
    {
        return $this->db->get_where('users', array('IDNumber' => $idNumber), 1)->row();
    }

    public function get_by_username($username)
    {
        return $this->db->get_where('users', array('username' => $username), 1)->row();
    }

    public function create($data)
    {
        return $this->db->insert('users', $data);
    }

    public function update($userID, $data)
    {
        $this->db->where('userID', $userID);
        return $this->db->update('users', $data);
    }

    public function delete($userID)
    {
        $this->db->where('userID', $userID);
        return $this->db->delete('users');
    }

    public function reset_password($userID, $passwordHash)
    {
        return $this->update($userID, array('password' => $passwordHash));
    }

    public function toggle_active($userID, $active)
    {
        if (!$this->db->field_exists('is_active', 'users')) {
            return false;
        }
        return $this->update($userID, array('is_active' => $active ? 1 : 0));
    }
}
