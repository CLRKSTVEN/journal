<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Events_model extends CI_Model
{
    /**
     * Fetch all categories for filtering/labels.
     */
    public function get_categories()
    {
        return $this->db
            ->order_by('category_name', 'ASC')
            ->get('event_categories')
            ->result();
    }

    public function get_groups()
    {
        return $this->db
            ->order_by('group_name', 'ASC')
            ->get('event_groups')
            ->result();
    }

    public function get_category($category_id)
    {
        return $this->db
            ->get_where('event_categories', array('category_id' => (int) $category_id))
            ->row();
    }

    public function get_category_by_name($name)
    {
        $name = trim($name);
        if ($name === '') {
            return null;
        }

        return $this->db
            ->where('LOWER(category_name)', strtolower($name))
            ->get('event_categories')
            ->row();
    }

    public function ensure_category($name)
    {
        $name = trim($name);
        if ($name === '') {
            return null;
        }

        $existing = $this->get_category_by_name($name);
        if ($existing) {
            return (int) $existing->category_id;
        }

        $this->create_category($name);
        return (int) $this->db->insert_id();
    }

    public function get_group($group_id)
    {
        return $this->db
            ->get_where('event_groups', array('group_id' => (int) $group_id))
            ->row();
    }

    public function create_category($name)
    {
        return $this->db->insert('event_categories', array(
            'category_name' => $name,
        ));
    }

    public function update_category($category_id, $name)
    {
        return $this->db->update(
            'event_categories',
            array('category_name' => $name),
            array('category_id' => (int) $category_id)
        );
    }

    public function delete_category($category_id)
    {
        return $this->db->delete('event_categories', array('category_id' => (int) $category_id));
    }

    /**
     * Check if a combination of event_name + group_id + category_id
     * already exists in event_master (optionally excluding one event_id).
     */
    public function has_duplicate_combo($name, $group_id, $category_id = null, $excludeEventId = null)
    {
        $this->db->from('event_master em');
        $this->db->where('em.event_name', trim($name));
        $this->db->where('em.group_id', (int) $group_id);

        if ($category_id === null) {
            // category_id IS NULL
            $this->db->where('em.category_id IS NULL', null, false);
        } else {
            $this->db->where('em.category_id', (int) $category_id);
        }

        if ($excludeEventId !== null) {
            $this->db->where('em.event_id !=', (int) $excludeEventId);
        }

        return $this->db->count_all_results() > 0;
    }

    public function create_event($name, $group_id, $category_id = null)
    {
        $data = array(
            'event_name'  => trim($name),
            'group_id'    => (int) $group_id,
            'category_id' => $category_id !== null ? (int) $category_id : null,
        );

        // ── Check for duplicate BEFORE insert (using helper) ─────────────
        if ($this->has_duplicate_combo($data['event_name'], $data['group_id'], $data['category_id'])) {
            // Duplicate found – do NOT insert, just return info
            return array(
                'success'  => false,
                'error'    => 'duplicate',
                'message'  => 'An event with the same name, group, and category already exists.',
                'event_id' => null,
            );
        }

        // ── No duplicate, proceed with insert ───────────────────────────
        $ok = $this->db->insert('event_master', $data);

        if ($ok) {
            return array(
                'success'  => true,
                'error'    => null,
                'event_id' => (int) $this->db->insert_id(),
            );
        }

        // Some other DB error (not duplicate)
        $dbError = $this->db->error(); // ['code' => ..., 'message' => ...]
        return array(
            'success'  => false,
            'error'    => 'db',
            'message'  => 'Unable to save event. Please contact the administrator.',
            'db_error' => $dbError,
        );
    }

    public function update_event($event_id, $name, $group_id, $category_id = null)
    {
        return $this->db->update(
            'event_master',
            array(
                'event_name'  => $name,
                'group_id'    => (int) $group_id,
                'category_id' => $category_id !== null ? (int) $category_id : null,
            ),
            array('event_id' => (int) $event_id)
        );
    }

    public function delete_event($event_id)
    {
        return $this->db->delete('event_master', array('event_id' => (int) $event_id));
    }

    /**
     * Fetch all events with their group/category labels for dropdowns.
     */
    public function get_events_with_meta()
    {
        $this->db->select('
            em.event_id,
            em.event_name,
            em.group_id,
            em.category_id,
            eg.group_name,
            ec.category_name
        ');
        $this->db->from('event_master em');
        $this->db->join('event_groups eg', 'eg.group_id = em.group_id', 'left');
        $this->db->join('event_categories ec', 'ec.category_id = em.category_id', 'left');
        $this->db->order_by('eg.group_name', 'ASC');
        $this->db->order_by('em.event_name', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Fetch events with group/category and winner tallies.
     */
    public function get_events_with_meta_and_counts($paraMode = 'all')
    {
        $this->db->select('
            em.event_id,
            em.event_name,
            em.group_id,
            em.category_id,
            eg.group_name,
            ec.category_name,
            COUNT(w.id) AS winners_count,
            SUM(w.medal = "Gold")   AS gold_count,
            SUM(w.medal = "Silver") AS silver_count,
            SUM(w.medal = "Bronze") AS bronze_count
        ', false);
        $this->db->from('event_master em');
        $this->db->join('event_groups eg', 'eg.group_id = em.group_id', 'left');
        $this->db->join('event_categories ec', 'ec.category_id = em.category_id', 'left');
        $this->db->join('winners w', 'w.event_id = em.event_id', 'left');

        if ($paraMode === 'include') {
            $this->db->group_start();
            $this->db->like('LOWER(em.event_name)', 'paragames');
            $this->db->or_like('LOWER(em.event_name)', 'para games');
            $this->db->or_like('LOWER(em.event_name)', 'para game');
            $this->db->or_like('LOWER(em.event_name)', 'paralympic games');
            $this->db->group_end();
        } elseif ($paraMode === 'exclude') {
            $this->db->group_start();
            $this->db->not_like('LOWER(em.event_name)', 'paragames');
            $this->db->not_like('LOWER(em.event_name)', 'para games');
            $this->db->not_like('LOWER(em.event_name)', 'para game');
            $this->db->not_like('LOWER(em.event_name)', 'paralympic games');
            $this->db->group_end();
        }

        $this->db->group_by(array(
            'em.event_id',
            'em.event_name',
            'em.group_id',
            'em.category_id',
            'eg.group_name',
            'ec.category_name'
        ));
        $this->db->order_by('eg.group_name', 'ASC');
        $this->db->order_by('em.event_name', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Fetch a single event with its group/category names.
     */
    public function get_event_details($event_id)
    {
        $this->db->select('
            em.event_id,
            em.event_name,
            em.group_id,
            em.category_id,
            eg.group_name,
            ec.category_name
        ');
        $this->db->from('event_master em');
        $this->db->join('event_groups eg', 'eg.group_id = em.group_id', 'left');
        $this->db->join('event_categories ec', 'ec.category_id = em.category_id', 'left');
        $this->db->where('em.event_id', $event_id);

        return $this->db->get()->row();
    }
}
