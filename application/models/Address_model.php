<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Address_model extends CI_Model
{
    /**
     * Returns distinct municipalities (City column) sorted alphabetically.
     */
    public function get_municipalities()
    {
        $this->db->select('MIN(AddID) AS address_id, City AS municipality, MAX(logo) AS logo');
        $this->db->from('settings_address');
        $this->db->where('City IS NOT NULL');
        $this->db->where('City !=', '');
        $this->db->group_by('City');
        $this->db->order_by('City', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Check if a city/municipality already exists (case-insensitive).
     */
    public function city_exists($city)
    {
        $this->db->from('settings_address');
        $this->db->where('City', $city);

        return $this->db->count_all_results() > 0;
    }

    /**
     * Insert a new city into the address lookup.
     */
    public function add_city($city)
    {
        return $this->db->insert('settings_address', array(
            'Province' => '',
            'City'     => $city,
            'Brgy'     => '',
            'logo'     => null,
        ));
    }

    /**
     * Update a city name across all matching records.
     */
    public function update_city($currentCity, $newCity, $logo = null)
    {
        $data = array('City' => $newCity);
        if ($logo !== null && $logo !== '') {
            $data['logo'] = $logo;
        }

        return $this->db->update('settings_address', $data, array('City' => $currentCity));
    }

    /**
     * Remove a city and all related address rows.
     */
    public function delete_city($city)
    {
        return $this->db->delete('settings_address', array('City' => $city));
    }

    /**
     * Save/replace a logo for a given city.
     */
    public function set_logo($city, $fileName)
    {
        if (trim($city) === '') {
            return false;
        }

        return $this->db->update(
            'settings_address',
            array('logo' => $fileName),
            array('City' => $city)
        );
    }
}
