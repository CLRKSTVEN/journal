<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Provincial extends CI_Controller
{
    protected $appSlug;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Winners_model');
        $this->load->model('Events_model');
        $this->load->model('Address_model');
        $this->load->model('MeetSettings_model'); // NEW
        $this->load->model('Technical_model'); // NEW
        $this->load->library(array('form_validation', 'session'));
        $this->load->helper(array('url', 'form'));
        $this->appSlug = app_slug();
    }

    public function index()
    {
        $group = $this->input->get('group', TRUE);
        $municipality = $this->input->get('municipality', TRUE);

        $isGrouped = ($group === 'Elementary' || $group === 'Secondary');
        $paraMode = ($group === 'PARA') ? 'include' : 'exclude';

        $municipalityMatch = ($group === 'PARA') ? 'like' : 'exact';
        $winners  = $this->Winners_model->get_winners_list($isGrouped ? $group : null, $municipality, $paraMode, $municipalityMatch);
        $overview = $this->Winners_model->get_overview($isGrouped ? $group : null, $municipality, $paraMode);
        $active   = $isGrouped ? $group : 'ALL';
        $tally    = $isGrouped
            ? $this->Winners_model->get_medal_tally_by_group($group, $paraMode)
            : $this->Winners_model->get_medal_tally($paraMode);

        // 🔹 NEW: one-row-per-event medal overview for "Events with Results"
        $events_results = $this->Winners_model->get_event_results_overview(
            $isGrouped ? $group : null,
            $municipality,
            $paraMode
        );

        $data = array(
            'active_group' => $active,
            'active_municipality' => $municipality,
            'winners'      => $winners,
            'overview'     => $overview,
            'events_list'  => $this->Events_model->get_events_with_meta_and_counts('exclude'),
            'municipality_tally' => $tally,
            'municipalities_all' => $this->Address_model->get_municipalities(),
            'meet'         => $this->MeetSettings_model->get_settings(),
            'events_results' => $events_results, // 👈 pass to view
        );

        // Map municipality => logo for quick lookup in views
        $logoMap = array();
        if (!empty($data['municipalities_all'])) {
            foreach ($data['municipalities_all'] as $m) {
                $name = isset($m->municipality) ? $m->municipality : '';
                if ($name !== '') {
                    $logoMap[$name] = isset($m->logo) ? $m->logo : '';
                }
            }
        }
        $data['municipality_logos'] = $logoMap;

        $this->load->view('provincial_landing', $data);
    }


    // Optional alias
    public function standings()
    {
        $this->index();
    }

    public function para()
    {
        $municipality = $this->input->get('municipality', TRUE);
        $paraMode = 'include';

        $winners  = $this->Winners_model->get_winners_list(null, $municipality, $paraMode, 'like');
        $overview = $this->Winners_model->get_overview(null, $municipality, $paraMode);
        $tally    = $this->Winners_model->get_medal_tally($paraMode);

        // 🔹 NEW: per-event medals for PARA events
        $events_results = $this->Winners_model->get_event_results_overview(
            null,          // no Elementary/Secondary filter
            $municipality,
            $paraMode      // include only PARA/Paragames based on event_name
        );

        $data = array(
            'active_group' => 'PARA',
            'active_municipality' => $municipality,
            'winners'      => $winners,
            'overview'     => $overview,
            'events_list'  => $this->Events_model->get_events_with_meta_and_counts('include'),
            'municipality_tally' => $tally,
            'municipalities_all' => $this->Address_model->get_municipalities(),
            'meet'         => $this->MeetSettings_model->get_settings(),
            'events_results' => $events_results, // 👈 pass to view
        );

        // Map municipality => logo for quick lookup in views
        $logoMap = array();
        if (!empty($data['municipalities_all'])) {
            foreach ($data['municipalities_all'] as $m) {
                $name = isset($m->municipality) ? $m->municipality : '';
                if ($name !== '') {
                    $logoMap[$name] = isset($m->logo) ? $m->logo : '';
                }
            }
        }
        $data['municipality_logos'] = $logoMap;

        $this->load->view('provincial_landing', $data);
    }


    public function admin()
    {
        if ($this->input->post('submit')) {

            $this->form_validation->set_rules('event_id', 'Event', 'trim|regex_match[/^[0-9]*$/]');
            $this->form_validation->set_rules('event_name_custom', 'Event Name', 'trim');
            $this->form_validation->set_rules('group_custom', 'Group', 'trim');
            $this->form_validation->set_rules('category_custom', 'Category', 'trim');
            $rawRows = $this->input->post('winners', TRUE);
            list($winnerRows, $rowErrors, $skippedRows) = $this->normalize_winner_rows($rawRows, false);

            if ($this->form_validation->run()) {
                if (!empty($rowErrors)) {
                    $this->session->set_flashdata('error', implode('<br>', $rowErrors));
                    redirect(app_url('admin'));
                    return;
                }

                if (empty($winnerRows)) {
                    $this->session->set_flashdata('error', 'Please add at least one winner.');
                    redirect(app_url('admin'));
                    return;
                }

                $eventId = (int) $this->input->post('event_id', TRUE);
                $eventNameCustom = trim((string) $this->input->post('event_name_custom', TRUE));
                $groupId = (int) $this->input->post('group_id', TRUE);
                $groupCustom = trim((string) $this->input->post('group_custom', TRUE));
                $categoryId = (int) $this->input->post('category_id', TRUE);
                $categoryCustom = trim((string) $this->input->post('category_custom', TRUE));

                if ($eventId <= 0 && $eventNameCustom === '') {
                    $this->session->set_flashdata('error', 'Please select or type an event.');
                    redirect(app_url('admin'));
                    return;
                }

                // Resolve group
                $resolvedGroupId = null;
                $resolvedGroupName = '';
                if ($groupCustom !== '') {
                    $resolvedGroupId = $this->Events_model->ensure_group($groupCustom);
                    $resolvedGroupName = $groupCustom;
                } elseif ($groupId > 0) {
                    $resolvedGroupId = $groupId;
                    $groupRow = $this->Events_model->get_group($groupId);
                    if ($groupRow && !empty($groupRow->group_name)) {
                        $resolvedGroupName = $groupRow->group_name;
                    }
                }

                if ($resolvedGroupId === null) {
                    $this->session->set_flashdata('error', 'Please select or type a group.');
                    redirect(app_url('admin'));
                    return;
                }

                // Resolve category (optional)
                $resolvedCategoryId = null;
                $resolvedCategoryName = '';
                if ($categoryCustom !== '') {
                    $resolvedCategoryId = $this->Events_model->ensure_category($categoryCustom);
                    $resolvedCategoryName = $categoryCustom;
                } elseif ($categoryId > 0) {
                    $resolvedCategoryId = $categoryId;
                    $categoryRow = $this->Events_model->get_category($categoryId);
                    if ($categoryRow && !empty($categoryRow->category_name)) {
                        $resolvedCategoryName = $categoryRow->category_name;
                    }
                }

                // Resolve event
                if ($eventId <= 0) {
                    $createResult = $this->Events_model->create_event($eventNameCustom, $resolvedGroupId, $resolvedCategoryId);
                    if (!$createResult['success']) {
                        $message = isset($createResult['message']) ? $createResult['message'] : 'Unable to save event.';
                        $this->session->set_flashdata('error', $message);
                        redirect(app_url('admin'));
                        return;
                    }
                    $eventId = (int) $createResult['event_id'];
                }

                $event = $this->Events_model->get_event_details($eventId);
                if (!$event) {
                    $this->session->set_flashdata('error', 'Selected event could not be found. Please pick a valid event.');
                    redirect(app_url('admin'));
                    return;
                }

                // Override with custom/selected labels if provided
                $groupName = $resolvedGroupName !== '' ? $resolvedGroupName : (isset($event->group_name) ? $event->group_name : '');
                $categoryName = $resolvedCategoryName !== '' ? $resolvedCategoryName : ($event->category_name ?? '');

                $inserted   = 0;
                $duplicates = array();

                foreach ($winnerRows as $row) {
                    $groupId    = $resolvedGroupId;
                    $categoryId = $resolvedCategoryId;
                    $groupName  = $groupName ?? (isset($event->group_name) ? $event->group_name : '');
                    $categoryName = $categoryName ?? ($event->category_name ?? '');

                    // 🔁 Duplicate guard: same event + same medal + same winner/team + same municipality
                    // if ($this->Winners_model->winner_exists(
                    //     $event->event_id,
                    //     $row['medal'],
                    //     $row['first_name'],
                    //     $row['middle_name'],
                    //     $row['last_name'],
                    //     $row['municipality']
                    // )) {
                    //     $displayName = trim($row['first_name'] . ' ' . $row['last_name']);
                    //     if ($displayName === '') {
                    //         $displayName = $row['first_name'];
                    //     }
                    //     $duplicates[] = sprintf(
                    //         '%s – %s (%s)',
                    //         $row['medal'],
                    //         $displayName,
                    //         $row['municipality']
                    //     );
                    //     continue;
                    // }

                    $insert = array(
                        'event_id'     => $event->event_id,
                        'event_name'   => $event->event_name,
                        'event_group'  => $groupName,
                        'category'     => $categoryName,
                        'first_name'   => $row['first_name'],
                        'middle_name'  => $row['middle_name'],
                        'last_name'    => $row['last_name'],
                        'medal'        => $row['medal'],
                        'municipality' => $row['municipality'],
                        'school'       => $row['school'],
                        'coach'        => $row['coach'],
                    );

                    $this->Winners_model->insert_winner($insert);
                    $inserted++;
                }


                // Build final feedback message
                $messageParts = array();

                if ($inserted > 0) {
                    $base = $inserted > 1
                        ? $inserted . ' winners saved successfully.'
                        : 'Winner saved successfully.';
                    if (!empty($skippedRows)) {
                        $base .= ' (Skipped ' . $skippedRows . ' incomplete row' . ($skippedRows > 1 ? 's' : '') . '.)';
                    }
                    $messageParts[] = $base;
                }

                if (!empty($duplicates)) {
                    $messageParts[] = 'Duplicate entries skipped (same event, winner, and medal already exist): ' .
                        implode('; ', $duplicates);
                }

                // If absolutely nothing was saved
                if (empty($messageParts)) {
                    $messageParts[] = 'No winners were saved. All rows were duplicate or incomplete.';
                }

                // Decide whether to show as success or error
                if ($inserted > 0) {
                    $this->session->set_flashdata('success', implode(' ', $messageParts));
                } else {
                    $this->session->set_flashdata('error', implode(' ', $messageParts));
                }

                redirect(app_url('admin'));
                return;
            }
        }

        // pass meet settings to the admin form
        $data['meet'] = $this->MeetSettings_model->get_settings();
        // Show a larger slice so bulk entries aren't hidden
        // Load ALL winners so DataTables search can see every encoded event
        $data['recent_winners'] = $this->Winners_model->get_recent_winners(null);
        $data['event_categories'] = $this->Events_model->get_categories();
        $data['event_groups'] = $this->Events_model->get_groups();
        $data['events'] = $this->Events_model->get_events_with_meta_and_counts();
        $data['municipalities'] = $this->Address_model->get_municipalities();
        $data['technical'] = $this->Technical_model->get_all();

        $this->load->view('dashboard_admin', $data);
    }

    /**
     * Standalone Events manager.
     */
    public function events()
    {
        $this->require_login();
        $data['meet'] = $this->MeetSettings_model->get_settings();
        $data['events'] = $this->Events_model->get_events_with_meta_and_counts();
        $data['event_groups'] = $this->Events_model->get_groups();
        $data['event_categories'] = $this->Events_model->get_categories();
        $this->load->view('events_admin', $data);
    }

    /**
     * Technical officials manager.
     */
    public function technical()
    {
        $this->require_login();
        $data['meet'] = $this->MeetSettings_model->get_settings();
        $data['technical'] = $this->Technical_model->get_all();
        $data['events'] = $this->Events_model->get_events_with_meta_and_counts();
        $data['event_groups'] = $this->Events_model->get_groups();
        $data['event_categories'] = $this->Events_model->get_categories();
        $this->load->view('technical_admin', $data);
    }

    public function report()
    {
        $this->require_login();
        $selectedId = (int) $this->input->get('event_id', TRUE);
        $events = $this->Events_model->get_events_with_meta_and_counts();
        $selectedEvent = null;
        foreach ($events as $ev) {
            if ((int)$ev->event_id === $selectedId) {
                $selectedEvent = $ev;
                break;
            }
        }

        $winners = array();
        $technical = array();
        if ($selectedEvent) {
            $winners = $this->Winners_model->get_winners_by_event($selectedId);
            $technical = $this->Technical_model->get_by_event($selectedId);
            // Fallback if IDs don't align but names match (legacy data)
            if (empty($technical)) {
                $technical = $this->Technical_model->get_by_labels(
                    $selectedEvent->event_name ?? '',
                    $selectedEvent->group_name ?? '',
                    $selectedEvent->category_name ?? ''
                );
            }
        }

        $data = array(
            'meet' => $this->MeetSettings_model->get_settings(),
            'events' => $events,
            'selected_event' => $selectedEvent,
            'winners' => $winners,
            'technical' => $technical,
            'selected_id' => $selectedId,
        );

        $this->load->view('report_event', $data);
    }

    public function add_technical()
    {
        $this->require_login();
        $this->form_validation->set_rules('event_id', 'Event', 'required|integer|greater_than[0]');

        if ($this->form_validation->run()) {
            $eventId = (int) $this->input->post('event_id', TRUE);
            $event = $this->Events_model->get_event_details($eventId);
            if (!$event) {
                $this->session->set_flashdata('error', 'Selected event not found.');
                redirect(app_url('technical'));
                return;
            }

            $names = $this->input->post('names');
            $roles = $this->input->post('roles');
            $groupInput = trim((string) $this->input->post('event_group', TRUE));
            $categoryInput = trim((string) $this->input->post('event_category', TRUE));
            $groupLabel = $groupInput !== '' ? $groupInput : ($event->group_name ?? '');
            $categoryLabel = $categoryInput !== '' ? $categoryInput : ($event->category_name ?? '');
            $saved = 0;
            if (is_array($names) && is_array($roles)) {
                foreach ($names as $idx => $name) {
                    $name = trim((string) $name);
                    $role = isset($roles[$idx]) ? $roles[$idx] : 'Technical Official';
                    if ($name === '') {
                        continue;
                    }
                    $this->Technical_model->create(
                        $name,
                        $role,
                        $eventId,
                        $event->event_name ?? '',
                        $groupLabel,
                        $categoryLabel
                    );
                    $saved++;
                }
            }

            if ($saved > 0) {
                $this->session->set_flashdata('success', $saved . ' entr' . ($saved > 1 ? 'ies' : 'y') . ' added.');
            } else {
                $this->session->set_flashdata('error', 'Please add at least one name.');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect(app_url('technical'));
    }

    public function update_technical()
    {
        $this->require_login();
        $this->form_validation->set_rules('id', 'ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[Tournament Manager,Technical Official]');
        $this->form_validation->set_rules('event_id', 'Event', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('event_group', 'Group', 'trim');
        $this->form_validation->set_rules('event_category', 'Category', 'trim');

        if ($this->form_validation->run()) {
            $id = (int) $this->input->post('id', TRUE);
            $existing = $this->Technical_model->get($id);
            if (!$existing) {
                $this->session->set_flashdata('error', 'Entry not found.');
                redirect(app_url('technical'));
                return;
            }

            $eventId = (int) $this->input->post('event_id', TRUE);
            $event = $this->Events_model->get_event_details($eventId);
            if (!$event) {
                $this->session->set_flashdata('error', 'Selected event not found.');
                redirect(app_url('technical'));
                return;
            }

            $groupInput = trim((string) $this->input->post('event_group', TRUE));
            $categoryInput = trim((string) $this->input->post('event_category', TRUE));
            $groupLabel = $groupInput !== '' ? $groupInput : ($event->group_name ?? '');
            $categoryLabel = $categoryInput !== '' ? $categoryInput : ($event->category_name ?? '');

            $this->Technical_model->update(
                $id,
                $this->input->post('name', TRUE),
                $this->input->post('role', TRUE),
                $eventId,
                $event->event_name ?? '',
                $groupLabel,
                $categoryLabel
            );
            $this->session->set_flashdata('success', 'Entry updated.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect(app_url('technical'));
    }

    public function delete_technical()
    {
        $this->require_login();
        $this->form_validation->set_rules('id', 'ID', 'required|integer|greater_than[0]');

        if ($this->form_validation->run()) {
            $id = (int) $this->input->post('id', TRUE);
            $existing = $this->Technical_model->get($id);
            if (!$existing) {
                $this->session->set_flashdata('error', 'Entry not found.');
            } else {
                $this->Technical_model->delete($id);
                $this->session->set_flashdata('success', 'Entry deleted.');
            }
        }

        redirect(app_url('technical'));
    }

    /**
     * Municipality manager – city-only CRUD.
     */
    public function municipalities()
    {
        $this->require_login();

        $data['meet'] = $this->MeetSettings_model->get_settings();
        $data['municipalities'] = $this->Address_model->get_municipalities();

        $this->load->view('municipalities_admin', $data);
    }

    public function add_municipality()
    {
        $this->require_login();
        $this->form_validation->set_rules('city', 'Municipality/City', 'required|trim');

        if ($this->form_validation->run()) {
            $city = trim($this->input->post('city', TRUE));

            if ($this->Address_model->city_exists($city)) {
                $this->session->set_flashdata('error', 'Municipality already exists.');
            } else {
                $upload = $this->handle_logo_upload('logo');
                if ($upload['error']) {
                    $this->session->set_flashdata('error', $upload['message']);
                    redirect(app_url('teams'));
                    return;
                }

                $this->Address_model->add_city($city);
                if ($upload['file']) {
                    $this->Address_model->set_logo($city, $upload['file']);
                }
                $this->session->set_flashdata('success', 'Municipality added.');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect(app_url('teams'));
    }

    public function update_municipality()
    {
        $this->require_login();
        $this->form_validation->set_rules('current_city', 'Current Municipality', 'required|trim');
        $this->form_validation->set_rules('city', 'Municipality/City', 'required|trim');

        if ($this->form_validation->run()) {
            $current = trim($this->input->post('current_city', TRUE));
            $city    = trim($this->input->post('city', TRUE));

            if (!$this->Address_model->city_exists($current)) {
                $this->session->set_flashdata('error', 'Municipality not found.');
                redirect(app_url('teams'));
                return;
            }

            if ($this->Address_model->city_exists($city) && strcasecmp($current, $city) !== 0) {
                $this->session->set_flashdata('error', 'Another entry already uses that municipality.');
                redirect(app_url('teams'));
                return;
            }

            $upload = $this->handle_logo_upload('logo');
            if ($upload['error']) {
                $this->session->set_flashdata('error', $upload['message']);
                redirect(app_url('teams'));
                return;
            }

            // If name unchanged and no logo uploaded, nothing to do
            if ($current === $city && empty($upload['file'])) {
                $this->session->set_flashdata('success', 'No changes to save.');
                redirect(app_url('teams'));
                return;
            }

            $this->Address_model->update_city($current, $city, $upload['file']);
            $this->session->set_flashdata('success', 'Teams updated.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect(app_url('teams'));
    }

    public function delete_municipality()
    {
        $this->require_login();
        $this->form_validation->set_rules('city', 'Municipality/City', 'required|trim');

        if ($this->form_validation->run()) {
            $city = trim($this->input->post('city', TRUE));

            if (!$this->Address_model->city_exists($city)) {
                $this->session->set_flashdata('error', 'Municipality not found.');
            } else {
                $this->Address_model->delete_city($city);
                $this->session->set_flashdata('success', 'Municipality deleted.');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect(app_url('teams'));
    }

    public function update_winner()
    {
        $this->form_validation->set_rules('winner_id', 'Winner ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('event_id', 'Event', 'required|integer|greater_than[0]');
        $rawRows = $this->input->post('winners', TRUE);

        // Backward compatibility if the request comes from the old single-entry form
        if (!is_array($rawRows)) {
            $rawRows = array(array(
                'first_name'   => $this->input->post('first_name', TRUE),
                'middle_name'  => $this->input->post('middle_name', TRUE),
                'last_name'    => $this->input->post('last_name', TRUE),
                'medal'        => $this->input->post('medal', TRUE),
                'municipality' => $this->input->post('municipality', TRUE),
                'school'       => $this->input->post('school', TRUE),
                'coach'        => $this->input->post('coach', TRUE),
                'group_id'     => $this->input->post('group_id', TRUE),
                'category_id'  => $this->input->post('category_id', TRUE),
            ));
        }

        list($winnerRows, $rowErrors) = $this->normalize_winner_rows($rawRows, true);

        if ($this->form_validation->run()) {
            if (!empty($rowErrors)) {
                $this->session->set_flashdata('error', implode('<br>', $rowErrors));
                redirect(app_url('admin'));
                return;
            }

            if (empty($winnerRows)) {
                $this->session->set_flashdata('error', 'Please enter the winner details to update.');
                redirect(app_url('admin'));
                return;
            }

            if (count($winnerRows) > 1) {
                $this->session->set_flashdata('error', 'Please edit one winner at a time.');
                redirect(app_url('admin'));
                return;
            }

            $winnerId = (int) $this->input->post('winner_id', TRUE);
            $eventId  = (int) $this->input->post('event_id', TRUE);

            $winner = $this->Winners_model->get_winner($winnerId);
            if (!$winner) {
                $this->session->set_flashdata('error', 'Winner not found.');
                redirect(app_url('admin'));
                return;
            }

            $event = $this->Events_model->get_event_details($eventId);
            if (!$event) {
                $this->session->set_flashdata('error', 'Selected event could not be found. Please pick a valid event.');
                redirect(app_url('admin'));
                return;
            }

            $groupId = (int) $this->input->post('group_id', TRUE);
            $categoryId = (int) $this->input->post('category_id', TRUE);
            $groupName = isset($event->group_name) ? $event->group_name : '';
            $categoryName = $event->category_name;

            if ($groupId > 0) {
                $groupRow = $this->Events_model->get_group($groupId);
                if ($groupRow && !empty($groupRow->group_name)) {
                    $groupName = $groupRow->group_name;
                }
            }

            if ($categoryId > 0) {
                $categoryRow = $this->Events_model->get_category((int) $categoryId);
                if ($categoryRow && !empty($categoryRow->category_name)) {
                    $categoryName = $categoryRow->category_name;
                }
            }

            $payload = $winnerRows[0];
            $update = array(
                'event_id'    => $event->event_id,
                'event_name'  => $event->event_name,
                'event_group' => $groupName,
                'category'    => $categoryName,
                'first_name'   => $payload['first_name'],
                'middle_name'  => $payload['middle_name'],
                'last_name'    => $payload['last_name'],
                'medal'        => $payload['medal'],
                'municipality' => $payload['municipality'],
                'school'       => $payload['school'],
                'coach'        => $payload['coach'],
            );

            $this->Winners_model->update_winner($winnerId, $update);
            $this->session->set_flashdata('success', 'Winner updated successfully.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect(app_url('admin'));
    }

    public function delete_winner($winner_id = null)
    {
        $id = (int) $winner_id;
        if ($id <= 0) {
            $this->session->set_flashdata('error', 'Invalid winner.');
            redirect(app_url('admin'));
            return;
        }

        $existing = $this->Winners_model->get_winner($id);
        if (!$existing) {
            $this->session->set_flashdata('error', 'Winner not found.');
            redirect(app_url('admin'));
            return;
        }

        $this->Winners_model->delete_winner($id);
        $this->session->set_flashdata('success', 'Winner deleted.');
        redirect(app_url('admin'));
    }

    // CRUD: create category
    public function add_category()
    {
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');

        if ($this->form_validation->run()) {
            $name = $this->input->post('category_name', TRUE);
            $this->Events_model->create_category($name);
            $this->session->set_flashdata('success', 'Category added.');
        } else {
            $this->session->set_flashdata('category_error', validation_errors('', ''));
        }

        redirect(app_url('admin'));
    }

    // CRUD: update category
    public function update_category()
    {
        $this->form_validation->set_rules('category_id', 'Category ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');

        if ($this->form_validation->run()) {
            $id   = (int) $this->input->post('category_id', TRUE);
            $name = $this->input->post('category_name', TRUE);

            $existing = $this->Events_model->get_category($id);
            if (!$existing) {
                $this->session->set_flashdata('category_error', 'Category not found.');
                redirect(app_url('admin'));
                return;
            }

            $this->Events_model->update_category($id, $name);
            $this->session->set_flashdata('success', 'Category updated.');
        } else {
            $this->session->set_flashdata('category_error', validation_errors('', ''));
        }

        redirect(app_url('admin'));
    }

    // CRUD: delete category
    public function delete_category($category_id = null)
    {
        $id = (int) $category_id;
        if ($id <= 0) {
            $this->session->set_flashdata('error', 'Invalid category.');
            redirect(app_url('admin'));
            return;
        }

        $existing = $this->Events_model->get_category($id);
        if (!$existing) {
            $this->session->set_flashdata('error', 'Category not found.');
            redirect(app_url('admin'));
            return;
        }

        $this->Events_model->delete_category($id);
        $this->session->set_flashdata('success', 'Category deleted.');
        redirect(app_url('admin'));
    }

    // CRUD: create event
    public function add_event()
    {
        $this->form_validation->set_rules('event_name', 'Event Name', 'required|trim');
        $this->form_validation->set_rules('group_id', 'Group', 'integer');
        $this->form_validation->set_rules('group_custom', 'Group', 'trim');
        $this->form_validation->set_rules('category_id', 'Category', 'integer');
        $this->form_validation->set_rules('category_custom', 'Category', 'trim');
        $this->form_validation->set_rules('category_name', 'Category', 'trim'); // legacy support

        if ($this->form_validation->run()) {
            $name            = $this->input->post('event_name', TRUE);
            $groupId         = (int) $this->input->post('group_id', TRUE);
            $groupCustom     = trim((string) $this->input->post('group_custom', TRUE));
            $categoryIdInput = (int) $this->input->post('category_id', TRUE);
            $categoryCustom  = trim((string) $this->input->post('category_custom', TRUE));
            $categoryLegacy  = $this->input->post('category_name', TRUE); // legacy text field

            // Resolve group (required)
            $resolvedGroupId = null;
            if ($groupCustom !== '') {
                $resolvedGroupId = $this->Events_model->ensure_group($groupCustom);
            } elseif ($groupId > 0) {
                $resolvedGroupId = $groupId;
            }

            if ($resolvedGroupId === null) {
                $this->session->set_flashdata('error', 'Please select or type a group.');
                $this->redirect_back();
                return;
            }

            // Resolve category (optional)
            $resolvedCategoryId = null;
            if ($categoryCustom !== '') {
                $resolvedCategoryId = $this->Events_model->ensure_category($categoryCustom);
            } elseif ($categoryIdInput > 0) {
                $resolvedCategoryId = $categoryIdInput;
            } elseif (!empty($categoryLegacy)) {
                $resolvedCategoryId = $this->Events_model->ensure_category($categoryLegacy);
            }

            $result = $this->Events_model->create_event($name, $resolvedGroupId, $resolvedCategoryId);

            // New: handle structured result from model
            if (is_array($result) && array_key_exists('success', $result)) {

                if ($result['success']) {
                    $this->session->set_flashdata('success', 'Event added successfully.');
                } else {
                    if ($result['error'] === 'duplicate') {
                        $this->session->set_flashdata(
                            'error',
                            'Cannot add event: an event with the same name, group, and category already exists.'
                        );
                    } else {
                        $this->session->set_flashdata(
                            'error',
                            'Sorry, an error occurred while saving the event. Please try again.'
                        );
                        // Optional: log technical DB error
                        // log_message('error', 'create_event DB error: ' . print_r($result['db_error'], true));
                    }
                }
            } else {
                // Fallback if some other part still returns plain bool
                if ($result) {
                    $this->session->set_flashdata('success', 'Event added successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Unable to save event. Please try again.');
                }
            }
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        $this->redirect_back();
    }

    // CRUD: update event
    public function update_event()
    {
        $this->form_validation->set_rules('event_id', 'Event ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('event_name', 'Event Name', 'required|trim');
        $this->form_validation->set_rules('group_id', 'Group', 'integer');
        $this->form_validation->set_rules('group_custom', 'Group', 'trim');
        $this->form_validation->set_rules('category_id', 'Category', 'integer');
        $this->form_validation->set_rules('category_custom', 'Category', 'trim');
        $this->form_validation->set_rules('category_name', 'Category', 'trim'); // legacy

        if ($this->form_validation->run()) {
            $eventId      = (int) $this->input->post('event_id', TRUE);
            $name         = $this->input->post('event_name', TRUE);
            $groupId      = (int) $this->input->post('group_id', TRUE);
            $groupCustom  = trim((string) $this->input->post('group_custom', TRUE));
            $categoryIdInput = (int) $this->input->post('category_id', TRUE);
            $categoryCustom  = trim((string) $this->input->post('category_custom', TRUE));
            $categoryLegacy  = $this->input->post('category_name', TRUE); // legacy

            // Make sure the record exists
            $existing = $this->Events_model->get_event_details($eventId);
            if (!$existing) {
                $this->session->set_flashdata('error', 'Event not found.');
                $this->redirect_back();
                return;
            }

            // Resolve group
            $resolvedGroupId = null;
            if ($groupCustom !== '') {
                $resolvedGroupId = $this->Events_model->ensure_group($groupCustom);
            } elseif ($groupId > 0) {
                $resolvedGroupId = $groupId;
            }

            if ($resolvedGroupId === null) {
                $this->session->set_flashdata('error', 'Please select or type a group.');
                $this->redirect_back();
                return;
            }

            // Resolve category
            $resolvedCategoryId = null;
            if ($categoryCustom !== '') {
                $resolvedCategoryId = $this->Events_model->ensure_category($categoryCustom);
            } elseif ($categoryIdInput > 0) {
                $resolvedCategoryId = $categoryIdInput;
            } elseif (!empty($categoryLegacy)) {
                $resolvedCategoryId = $this->Events_model->ensure_category($categoryLegacy);
            }

            // 🔒 DUPLICATE GUARD:
            // Check if another row already has the same (event_name + group_id + category_id)
            // Exclude the current event_id from the check.
            if ($this->Events_model->has_duplicate_combo($name, $resolvedGroupId, $resolvedCategoryId, $eventId)) {
                $this->session->set_flashdata(
                    'error',
                    'Cannot update event: another event with the same name, group, and category already exists.'
                );
                $this->redirect_back();
                return;
            }

            // Safe to update
            $this->Events_model->update_event($eventId, $name, $resolvedGroupId, $resolvedCategoryId);
            $this->session->set_flashdata('success', 'Event updated.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        $this->redirect_back();
    }

    // CRUD: delete event
    public function delete_event($event_id = null)
    {
        $id = (int) $event_id;
        if ($id <= 0) {
            $this->session->set_flashdata('error', 'Invalid event.');
            $this->redirect_back();
        }

        $existing = $this->Events_model->get_event_details($id);
        if (!$existing) {
            $this->session->set_flashdata('error', 'Event not found.');
            $this->redirect_back();
        }

        if ($this->Winners_model->event_has_winners($id)) {
            $this->session->set_flashdata('error', 'Cannot delete this event because winners are already encoded. Remove the winners first.');
            $this->redirect_back();
        }

        $this->Events_model->delete_event($id);
        $this->session->set_flashdata('success', 'Event deleted.');
        $this->redirect_back();
    }

    /**
     * Normalize the posted winners payload: skip empty rows and surface per-row errors.
     *
     * @param array|null $rawRows
     * @return array [$validRows, $errors]
     */
    private function normalize_winner_rows($rawRows, $strictMissing = false)
    {
        $validRows = array();
        $errors    = array();
        $allowed   = array('Gold', 'Silver', 'Bronze', '4th', '5th');
        $medalCounts = array('Gold' => 0, 'Silver' => 0, 'Bronze' => 0, '4th' => 0, '5th' => 0);
        $skippedMissing = 0;

        if (!is_array($rawRows)) {
            return array($validRows, $errors, $skippedMissing);
        }

        foreach ($rawRows as $index => $row) {
            if (!is_array($row)) {
                continue;
            }

            $first = isset($row['first_name']) ? trim($row['first_name']) : '';
            $middle = isset($row['middle_name']) ? trim($row['middle_name']) : '';
            $last = isset($row['last_name']) ? trim($row['last_name']) : '';
            $entryType = strtolower(isset($row['entry_type']) ? trim($row['entry_type']) : 'individual');
            $teamNames = isset($row['team_names']) ? trim($row['team_names']) : '';
            $municipality = isset($row['municipality']) ? trim($row['municipality']) : '';
            $school = isset($row['school']) ? trim($row['school']) : '';
            $coach = isset($row['coach']) ? trim($row['coach']) : '';
            $medal = isset($row['medal']) ? trim($row['medal']) : '';

            $allEmpty = ($first === '' && $middle === '' && $last === '' && $municipality === '' && $teamNames === '');
            if ($allEmpty) {
                continue;
            }

            $labelMedal = in_array($medal, $allowed, true) ? $medal : 'Entry';
            $medalCounts[$labelMedal] = isset($medalCounts[$labelMedal]) ? $medalCounts[$labelMedal] + 1 : 1;
            $label = ($labelMedal !== 'Entry')
                ? $labelMedal . ' entry #' . $medalCounts[$labelMedal]
                : 'Entry #' . ($index + 1);

            if (!in_array($medal, $allowed, true)) {
                $errors[] = $label . ' needs a valid placement (1st–5th).';
                continue;
            }

            if ($entryType === 'team') {
                if ($teamNames === '' || $municipality === '') {
                    if ($strictMissing) {
                        $errors[] = $label . ' is missing team names or municipality.';
                    } else {
                        $skippedMissing++;
                    }
                    continue;
                }
                // Map team entry into first_name for storage; leave middle/last blank
                $first = $teamNames;
                $middle = '';
                $last = '';
            } else {
                if ($first === '' || $last === '' || $municipality === '') {
                    if ($strictMissing) {
                        $errors[] = $label . ' is missing first name, last name, or municipality.';
                    } else {
                        $skippedMissing++;
                    }
                    continue;
                }
            }

            $validRows[] = array(
                'first_name'   => $first,
                'middle_name'  => $middle,
                'last_name'    => $last,
                'medal'        => $medal,
                'municipality' => $municipality,
                'school'       => $school,
                'coach'        => $coach,
                'entry_type'   => ($entryType === 'team') ? 'team' : 'individual',
                'team_names'   => $teamNames,
            );
        }

        return array($validRows, $errors, $skippedMissing);
    }

    // NEW: update meet title/year/subtitle from admin
    public function update_meet_settings()
    {
        $this->form_validation->set_rules('meet_title', 'Meet Title', 'required|trim');
        $this->form_validation->set_rules('meet_year', 'Meet Year', 'required|trim');

        if ($this->form_validation->run()) {
            $data = array(
                'meet_title' => $this->input->post('meet_title', TRUE),
                'meet_year'  => $this->input->post('meet_year', TRUE),
                'subtitle'   => $this->input->post('subtitle', TRUE),
            );

            $this->MeetSettings_model->update_settings($data);
            $this->session->set_flashdata('success', 'Meet header updated.');
        }

        redirect(app_url('admin'));
    }

    /**
     * Require an authenticated session before accessing admin endpoints.
     */
    private function require_login()
    {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Please log in to continue.');
            redirect('login');
            exit;
        }
    }

    /**
     * Resolve a safe redirect target from POST data (used by shared forms).
     */
    private function redirect_back($default = null)
    {
        $fallback = $default ?: (app_url('admin'));
        $target = trim((string) $this->input->post('return_to', TRUE));
        if ($target === '' || stripos($target, 'http://') === 0 || stripos($target, 'https://') === 0 || strpos($target, '//') === 0) {
            $target = $fallback;
        }
        redirect($target);
    }

    /**
     * Handle optional team logo upload; returns ['error'=>bool,'message'=>string,'file'=>string|null]
     */
    private function handle_logo_upload($field)
    {
        if (empty($_FILES[$field]['name'])) {
            return array('error' => false, 'message' => '', 'file' => null);
        }

        $config = array(
            'upload_path'   => FCPATH . 'upload/team_logos',
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'encrypt_name'  => true,
            'max_size'      => 2048,
        );

        if (!is_dir($config['upload_path'])) {
            @mkdir($config['upload_path'], 0775, true);
        }

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($field)) {
            return array('error' => true, 'message' => $this->upload->display_errors('', ''), 'file' => null);
        }

        $data = $this->upload->data();
        return array('error' => false, 'message' => '', 'file' => $data['file_name']);
    }
}
