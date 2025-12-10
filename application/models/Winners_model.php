<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Winners_model extends CI_Model
{
    /**
     * Apply include/exclude filter for Para/Paralympic events.
     *
     * @param CI_DB_query_builder $builder
     * @param string $mode 'exclude' (default), 'include', or 'all'
     * @param string $field SQL field/alias for event_name
     */
    private function apply_para_filter($builder, $mode = 'all', $field = 'event_name')
    {
        $field = trim($field) !== '' ? $field : 'event_name';
        if ($mode === 'all') {
            return;
        }

        $builder->group_start();
        if ($mode === 'include') {
            $builder->like("LOWER({$field})", 'paragames');
            $builder->or_like("LOWER({$field})", 'para games');
            $builder->or_like("LOWER({$field})", 'para game');
            $builder->or_like("LOWER({$field})", 'paralympic games');
        } else {
            $builder->not_like("LOWER({$field})", 'paragames');
            $builder->not_like("LOWER({$field})", 'para games');
            $builder->not_like("LOWER({$field})", 'para game');
            $builder->not_like("LOWER({$field})", 'paralympic games');
        }
        $builder->group_end();
    }

    public function insert_winner($data)
    {
        return $this->db->insert('winners', $data);
    }

    public function update_winner($id, $data)
    {
        return $this->db->update('winners', $data, array('id' => (int) $id));
    }

    public function delete_winner($id)
    {
        return $this->db->delete('winners', array('id' => (int) $id));
    }

    public function get_winners_by_event($event_id)
    {
        $event_id = (int) $event_id;
        if ($event_id <= 0) {
            return array();
        }

        $this->db->select("
            id,
            event_id,
            event_name,
            event_group,
            category,
            first_name,
            middle_name,
            last_name,
            CASE
                WHEN TRIM(IFNULL(last_name, '')) = '' THEN TRIM(CONCAT_WS(' ', first_name, middle_name))
                ELSE TRIM(CONCAT_WS(' ', CONCAT(last_name, ','), first_name, middle_name))
            END AS full_name,
            medal,
            municipality,
            school,
            coach,
            created_at
        ", false);
        $this->db->from('winners');
        $this->db->where('event_id', $event_id);
        $this->db->order_by("FIELD(medal, 'Gold', 'Silver', 'Bronze')", '', false);
        $this->db->order_by('full_name', 'ASC');

        return $this->db->get()->result();
    }

    public function get_winner($id)
    {
        return $this->db
            ->get_where('winners', array('id' => (int) $id))
            ->row();
    }

    public function get_winners_list($event_group = null, $municipality = null, $paraMode = 'all', $municipalityMatch = 'exact')
    {
        // Build a medal tally subquery so we can rank rows by municipality performance first
        $tallyBuilder = $this->db->select("
            municipality,
            SUM(medal = 'Gold')   AS gold_count,
            SUM(medal = 'Silver') AS silver_count,
            SUM(medal = 'Bronze') AS bronze_count,
            COUNT(*)              AS total_medals
        ", FALSE)->from('winners');
        $this->apply_para_filter($tallyBuilder, $paraMode, 'event_name');

        if ($event_group === 'Elementary' || $event_group === 'Secondary') {
            $tallyBuilder->where('event_group', $event_group);
        }
        if (!empty($municipality)) {
            if ($municipalityMatch === 'like') {
                $tallyBuilder->like('municipality', $municipality);
            } else {
                $tallyBuilder->where('municipality', $municipality);
            }
        }

        $tallyBuilder->group_by('municipality');
        $medalTallySql = $tallyBuilder->get_compiled_select();

        $this->db->select("
            w.event_name,
            w.event_group,
            w.category,
            CASE
                WHEN TRIM(IFNULL(w.last_name, '')) = '' THEN TRIM(CONCAT_WS(' ', w.first_name, w.middle_name))
                ELSE TRIM(CONCAT_WS(' ', CONCAT(w.last_name, ','), w.first_name, w.middle_name))
            END AS full_name,
            w.medal,
            w.municipality,
            w.school,
            w.coach,
            w.created_at,
            m.gold_count,
            m.silver_count,
            m.bronze_count,
            m.total_medals
        ", FALSE);
        $this->db->from('winners w');
        $this->db->join("({$medalTallySql}) m", 'm.municipality = w.municipality', 'left');
        $this->apply_para_filter($this->db, $paraMode, 'w.event_name');

        if ($event_group === 'Elementary' || $event_group === 'Secondary' || $event_group === 'PARA') {
            $this->db->where('w.event_group', $event_group);
        }
        if (!empty($municipality)) {
            if ($municipalityMatch === 'like') {
                $this->db->like('w.municipality', $municipality);
            } else {
                $this->db->where('w.municipality', $municipality);
            }
        }

        // Order: municipality medal tally, then medal, then event/group/category/name
        $this->db->order_by('m.gold_count', 'DESC');
        $this->db->order_by('m.silver_count', 'DESC');
        $this->db->order_by('m.bronze_count', 'DESC');
        $this->db->order_by('m.total_medals', 'DESC');
        $this->db->order_by("FIELD(w.medal, 'Gold', 'Silver', 'Bronze')", '', FALSE);
        $this->db->order_by('w.event_name', 'ASC');
        $this->db->order_by('w.event_group', 'ASC');
        $this->db->order_by('w.category', 'ASC');
        $this->db->order_by('full_name', 'ASC');

        return $this->db->get()->result();
    }

    public function get_recent_winners($limit = 10)
    {
        $this->db->select("
        id,
        event_id,
        event_name,
        event_group,
        category,
        first_name,
        middle_name,
        last_name,
        CASE
            WHEN TRIM(IFNULL(last_name, '')) = '' THEN TRIM(CONCAT_WS(' ', first_name, middle_name))
            ELSE TRIM(CONCAT_WS(' ', CONCAT(last_name, ','), first_name, middle_name))
        END AS full_name,
        medal,
        municipality,
        school,
        coach,
        created_at
    ", FALSE);
        $this->db->from('winners');
        $this->db->order_by('created_at', 'DESC');

        // ✅ Only apply limit if a positive integer is given
        if ($limit !== null && (int) $limit > 0) {
            $this->db->limit((int) $limit);
        }

        return $this->db->get()->result();
    }

    // Medal tally by municipality (all groups)
    public function get_medal_tally($paraMode = 'all')
    {
        $this->db->select("
            municipality,
            SUM(medal = 'Gold')   AS gold,
            SUM(medal = 'Silver') AS silver,
            SUM(medal = 'Bronze') AS bronze,
            COUNT(*)              AS total_medals
        ", FALSE);
        $this->db->from('winners');
        $this->apply_para_filter($this->db, $paraMode, 'event_name');
        $this->db->group_by('municipality');
        $this->db->order_by('gold', 'DESC');
        $this->db->order_by('silver', 'DESC');
        $this->db->order_by('bronze', 'DESC');
        $this->db->order_by('municipality', 'ASC');

        return $this->db->get()->result();
    }

    // Medal tally by municipality + group (Elementary / Secondary)
    public function get_medal_tally_by_group($event_group, $paraMode = 'all')
    {
        $this->db->select("
            municipality,
            event_group,
            SUM(medal = 'Gold')   AS gold,
            SUM(medal = 'Silver') AS silver,
            SUM(medal = 'Bronze') AS bronze,
            COUNT(*)              AS total_medals
        ", FALSE);
        $this->db->from('winners');
        $this->db->where('event_group', $event_group);
        $this->apply_para_filter($this->db, $paraMode, 'event_name');
        $this->db->group_by(array('municipality', 'event_group'));
        $this->db->order_by('gold', 'DESC');
        $this->db->order_by('silver', 'DESC');
        $this->db->order_by('bronze', 'DESC');
        $this->db->order_by('municipality', 'ASC');

        return $this->db->get()->result();
    }

    // NEW: overview stats for the header cards
    public function get_overview($event_group = null, $municipality = null, $paraMode = 'all')
    {
        $this->db->select("
        COUNT(DISTINCT event_id)             AS events,           -- 🔁 use event_id, not event_name
        COUNT(DISTINCT municipality)         AS municipalities,
        SUM(medal = 'Gold')                  AS gold,
        SUM(medal = 'Silver')                AS silver,
        SUM(medal = 'Bronze')                AS bronze,
        COUNT(*)                             AS total_medals,
        MAX(created_at)                      AS last_update
    ", FALSE);
        $this->db->from('winners');

        // PARA include/exclude based on event_name
        $this->apply_para_filter($this->db, $paraMode, 'event_name');

        // Only filter by event_group when it's clearly Elementary/Secondary
        if ($event_group === 'Elementary' || $event_group === 'Secondary') {
            $this->db->where('event_group', $event_group);
        }

        if (!empty($municipality)) {
            $this->db->where('municipality', $municipality);
        }

        return $this->db->get()->row();
    }

    /**
     * Per-event results: one row per event with Gold / Silver / Bronze municipalities.
     * Use this for the "Events with Results" table (overall + PARA).
     */
    public function get_event_results_overview($event_group = null, $municipality = null, $paraMode = 'all')
    {
        $this->db->select("
        event_id,
        event_name,
        event_group,
        category,
        MAX(CASE WHEN medal = 'Gold'   THEN municipality END) AS gold_team,
        MAX(CASE WHEN medal = 'Silver' THEN municipality END) AS silver_team,
        MAX(CASE WHEN medal = 'Bronze' THEN municipality END) AS bronze_team
    ", FALSE);
        $this->db->from('winners');

        // Include/exclude PARA based on event_name
        $this->apply_para_filter($this->db, $paraMode, 'event_name');

        // For main standings: Elementary / Secondary filter
        if ($event_group === 'Elementary' || $event_group === 'Secondary') {
            $this->db->where('event_group', $event_group);
        }

        // Optional: only events where this municipality appears as medalist
        if (!empty($municipality)) {
            $this->db->where('municipality', $municipality);
        }

        // 1 row per event
        $this->db->group_by(array(
            'event_id',
            'event_name',
            'event_group',
            'category'
        ));

        $this->db->order_by('event_group', 'ASC');
        $this->db->order_by('event_name', 'ASC');
        $this->db->order_by('category', 'ASC');

        return $this->db->get()->result();
    }


    /**
     * Check if an event has any winners.
     */
    public function event_has_winners($event_id)
    {
        $id = (int) $event_id;
        if ($id <= 0) {
            return false;
        }
        return $this->db
            ->where('event_id', $id)
            ->limit(1)
            ->count_all_results('winners') > 0;
    }
    /**
     * Check if a winner already exists for the same event + medal + person/team + municipality.
     *
     * This works for both Individual and Team entries because team names are stored in first_name.
     */
    public function winner_exists($eventId, $medal, $firstName, $middleName, $lastName, $municipality)
    {
        $eventId      = (int) $eventId;
        $medal        = trim((string) $medal);
        $firstName    = trim((string) $firstName);
        $middleName   = trim((string) $middleName);
        $lastName     = trim((string) $lastName);
        $municipality = trim((string) $municipality);

        if ($eventId <= 0 || $medal === '' || $firstName === '' || $municipality === '') {
            return false;
        }

        $this->db->from('winners');
        $this->db->where('event_id', $eventId);
        $this->db->where('medal', $medal);
        $this->db->where('first_name', $firstName);
        $this->db->where('middle_name', $middleName);
        $this->db->where('last_name', $lastName);
        $this->db->where('municipality', $municipality);
        $this->db->limit(1);

        return $this->db->count_all_results() > 0;
    }
}
