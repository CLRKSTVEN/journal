<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Technical_model extends CI_Model
{
    public function get_all()
    {
        $hasEvent = $this->db->field_exists('event_id', 'technical_officials');

        if ($hasEvent) {
            $this->db->select("
                t.*,
                COALESCE(t.event_name, em.event_name)       AS event_name_display,
                COALESCE(t.event_group, eg.group_name)      AS event_group_display,
                COALESCE(t.category, ec.category_name)      AS category_display
            ", false);
            $this->db->from('technical_officials t');
            $this->db->join('event_master em', 'em.event_id = t.event_id', 'left');
            $this->db->join('event_groups eg', 'eg.group_id = em.group_id', 'left');
            $this->db->join('event_categories ec', 'ec.category_id = em.category_id', 'left');
        } else {
            $this->db->select('t.*', false);
            $this->db->from('technical_officials t');
        }

        return $this->db
            ->order_by("FIELD(role, 'Tournament Manager', 'Technical Official')", '', false)
            ->order_by('name', 'ASC')
            ->get()
            ->result();
    }

    public function get($id)
    {
        return $this->db->get_where('technical_officials', array('id' => (int) $id))->row();
    }

    public function create($name, $role, $eventId = null, $eventName = null, $eventGroup = null, $category = null)
    {
        $data = array(
            'name' => $name,
            'role' => $role,
        );

        if ($this->db->field_exists('event_id', 'technical_officials')) {
            $data['event_id'] = $eventId;
            $data['event_name'] = $eventName;
            $data['event_group'] = $eventGroup;
            $data['category'] = $category;
        }

        return $this->db->insert('technical_officials', $data);
    }

    public function update($id, $name, $role, $eventId = null, $eventName = null, $eventGroup = null, $category = null)
    {
        $data = array('name' => $name, 'role' => $role);
        if ($this->db->field_exists('event_id', 'technical_officials')) {
            $data['event_id'] = $eventId;
            $data['event_name'] = $eventName;
            $data['event_group'] = $eventGroup;
            $data['category'] = $category;
        }

        return $this->db->update(
            'technical_officials',
            $data,
            array('id' => (int) $id)
        );
    }

    public function delete($id)
    {
        return $this->db->delete('technical_officials', array('id' => (int) $id));
    }

    public function get_by_event($eventId)
    {
        $eventId = (int) $eventId;
        if ($eventId <= 0) {
            return array();
        }

        $this->db->select('t.*', false);
        $this->db->from('technical_officials t');
        $this->db->where('t.event_id', $eventId);
        $this->db->order_by("FIELD(role, 'Tournament Manager', 'Technical Official')", '', false);
        $this->db->order_by('name', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Fallback lookup: match by event name/group/category when IDs don't align.
     */
    public function get_by_labels($name = '', $group = '', $category = '')
    {
        $name = trim((string) $name);
        if ($name === '') {
            return array();
        }

        $this->db->select('t.*', false);
        $this->db->from('technical_officials t');
        $this->db->group_start()
            ->like('t.event_name', $name)
            ->or_where('SOUNDEX(t.event_name)=SOUNDEX(' . $this->db->escape($name) . ')', null, false)
            ->group_end();
        if ($group !== '') {
            $this->db->like('t.event_group', $group);
        }
        if ($category !== '') {
            $this->db->like('t.category', $category);
        }
        $this->db->order_by("FIELD(role, 'Tournament Manager', 'Technical Official')", '', false);
        $this->db->order_by('name', 'ASC');

        return $this->db->get()->result();
    }
}
