<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    body {
        font-family: var(--app-font);
        background: #f8fafc;
    }

    .page-title-box h4 {
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.04);
    }

    .card-title {
        font-weight: 800;
        color: #111827;
    }

    .recent-winners-table th,
    .recent-winners-table td {
        vertical-align: middle;
    }

    .recent-winners-actions,
    .table-actions {
        display: inline-flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .recent-winners-actions form,
    .table-actions form {
        margin: 0;
    }

    .btn-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .btn-icon .mdi {
        font-size: 1rem;
        line-height: 1;
    }

    .event-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 10px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.78rem;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .event-status-badge.filled {
        background: #ecfdf3;
        color: #166534;
        border-color: #bbf7d0;
    }

    .event-status-badge.empty {
        background: #f8fafc;
        color: #64748b;
        border-color: #e2e8f0;
    }

    .event-status-meta {
        display: block;
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 2px;
    }

    /* When toggled, always show winner details and hide placeholders */
    #eventsTable.table-show-winners .event-status-detail {
        display: inline !important;
    }

    #eventsTable.table-show-winners .event-status-placeholder {
        display: none !important;
    }

    .table thead th {
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        color: #6b7280;
        border-bottom-width: 2px;
    }

    .badge-medal {
        font-weight: 800;
        padding: 6px 10px;
        border-radius: 10px;
    }

    .badge-gold {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-silver {
        background: #e5e7eb;
        color: #374151;
    }

    .badge-bronze {
        background: #ffedd5;
        color: #9a3412;
    }

    .medal-section {
        border: 1px dashed #e5e7eb;
        background: #fff;
        border-radius: 12px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .medal-section .medal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .medal-row {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .medal-row .card-body {
        padding: 10px;
    }

    .medal-row .form-group {
        margin-bottom: 0.4rem;
    }

    /* Winner modal spacing tightener */
    #winnerModal .modal-body .form-group {
        margin-bottom: 0.55rem;
    }

    #winnerModal .medal-header {
        margin-bottom: 6px;
    }

    #winnerModal .alert-info {
        margin-bottom: 10px;
        padding: 8px 10px;
    }

    /* Entry type segmented toggle */
    .entry-type-toggle {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .entry-type-btn {
        border: 1px solid #d1d5db;
        background: #fff;
        color: #374151;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 0.9rem;
        line-height: 1.2;
        transition: all 0.15s ease;
    }

    .entry-type-btn.active {
        background: #eef2ff;
        border-color: #6366f1;
        color: #312e81;
        box-shadow: 0 1px 2px rgba(99, 102, 241, 0.18);
    }

    .entry-type-btn:hover {
        background: #f3f4f6;
    }

    .entry-type-toggle .entry-type-btn.active {
        background: #0ea5e9;
        color: #fff;
        border-color: #0ea5e9;
    }

    .entry-type-toggle .entry-type-btn {
        min-width: 110px;
    }

    /* Mobile-friendly table tweaks */
    @media (max-width: 640px) {

        .table td,
        .table th {
            padding: 0.45rem 0.5rem;
        }

        /* Hide less critical columns on mobile */
        .recent-winners-table th:nth-child(2),
        .recent-winners-table td:nth-child(2),
        .recent-winners-table th:nth-child(3),
        .recent-winners-table td:nth-child(3),
        .recent-winners-table th:nth-child(7),
        .recent-winners-table td:nth-child(7),
        .recent-winners-table th:nth-child(8),
        .recent-winners-table td:nth-child(8) {
            display: none;
        }

        #eventsTable th:nth-child(3),
        #eventsTable td:nth-child(3) {
            display: none;
        }
    }
</style>

<body>
    <div id="wrapper">

        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page title -->
                    <?php
                    $validation_list = validation_errors('<li>', '</li>');
                    $error_message   = $this->session->flashdata('error');
                    $category_error  = $this->session->flashdata('category_error');
                    $event_categories_list = isset($event_categories) ? $event_categories : array();
                    $event_groups_list = isset($event_groups) ? $event_groups : array();
                    $events_list = isset($events) ? $events : array();
                    $municipalities_list = isset($municipalities) ? $municipalities : array();
                    $appSlug = app_slug();
                    $meet_title = isset($meet->meet_title) ? $meet->meet_title : app_name();
                    $meet_year  = isset($meet->meet_year)  ? $meet->meet_year  : date('Y');
                    $flash_success = $this->session->flashdata('success');
                    $flash_error   = $this->session->flashdata('error');
                    $placementLabel = function ($medal) {
                        $m = strtolower(trim((string) $medal));
                        if ($m === 'gold' || $m === '1st' || $m === 'first') return '1st';
                        if ($m === 'silver' || $m === '2nd' || $m === 'second') return '2nd';
                        if ($m === 'bronze' || $m === '3rd' || $m === 'third') return '3rd';
                        if ($m === '4th' || $m === 'fourth') return '4th';
                        if ($m === '5th' || $m === 'fifth') return '5th';
                        return ucfirst($medal);
                    };
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
                                <div class="mb-2">
                                    <h4 class="page-title mb-0">
                                        <?= htmlspecialchars($meet_title . ' ' . $meet_year, ENT_QUOTES, 'UTF-8'); ?> – Admin
                                    </h4>
                                </div>
                                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">

                                    <!-- Primary action -->
                                    <button class="btn btn-sm btn-outline-primary" id="openWinnerModal" data-toggle="modal" data-target="#winnerModal">
                                        <i class="mdi mdi-plus"></i> Add Winners
                                    </button>
                                    <!-- Secondary action -->
                                    <a href="<?= app_url('standings'); ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="mdi mdi-trophy"></i> View Standings
                                    </a>

                                    <!-- Settings -->
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#meetHeaderModal">
                                        <i class="mdi mdi-cog-outline"></i> Meet Header
                                    </button>

                                </div>

                            </div>
                            <!-- Updated gradient: green + blue, no purple -->
                            <hr style="border:0;height:2px;background:linear-gradient(90deg,#059669 0%,#0ea5e9 50%,#22c55e 100%);border-radius:999px;margin-top:4px;">
                        </div>
                    </div>

                    <!-- Alerts -->
                    <div class="row">
                        <div class="col-lg-8">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <?= $this->session->flashdata('success'); ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($error_message)): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <?= $error_message; ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($category_error)): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <?= $category_error; ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($validation_list)): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <ul class="mb-0 pl-3" style="list-style: disc;">
                                        <?= $validation_list; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Main content -->
                    <div class="row">
                        <!-- Recent winners preview -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-start mb-3">
                                        <div>
                                            <h5 class="card-title mb-0">Recent winners</h5>
                                            <small class="text-muted">Latest entries saved to the standings.</small>
                                        </div>

                                    </div>

                                    <?php $recent_winners = isset($recent_winners) ? $recent_winners : array(); ?>
                                    <?php if (!empty($recent_winners)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0 recent-winners-table" id="recentWinnersTable">
                                                <thead>
                                                    <tr>
                                                        <th>Event</th>
                                                        <th>Group</th>
                                                        <th>Category</th>
                                                        <th>Winner</th>
                                                        <th class="text-center">Placement</th>
                                                        <th>Team</th>
                                                        <th>School</th>
                                                        <th>Coach</th>
                                                        <th class="d-none">Created</th>
                                                        <th class="text-right" style="width: 140px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($recent_winners as $row): ?>
                                                        <?php
                                                        $placementText = $placementLabel($row->medal);
                                                        $badgeClass = 'badge-silver';
                                                        if ($placementText === '1st') {
                                                            $badgeClass = 'badge-gold';
                                                        } elseif ($placementText === '3rd') {
                                                            $badgeClass = 'badge-bronze';
                                                        }
                                                        $orderMap = array(
                                                            '5th' => 1,
                                                            '4th' => 2,
                                                            '3rd' => 3,
                                                            '2nd' => 4,
                                                            '1st' => 5
                                                        );
                                                        $medalOrder = isset($orderMap[$placementText]) ? $orderMap[$placementText] : 0;
                                                        $createdAt = $row->created_at ?? '';
                                                        $createdSort = $createdAt ? strtotime($createdAt) : 0;
                                                        ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($row->event_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->event_group, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->category ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->full_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td class="text-center" data-order="<?= $medalOrder; ?>">
                                                                <span class="badge badge-medal <?= $badgeClass; ?>"><?= htmlspecialchars($placementText, ENT_QUOTES, 'UTF-8'); ?></span>
                                                            </td>
                                                            <td><?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->school ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->coach ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td class="d-none" data-order="<?= $createdSort; ?>"><?= htmlspecialchars($createdAt, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td class="text-right align-middle">
                                                                <span class="recent-winners-actions">
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-outline-secondary btn-sm btn-icon btn-edit-winner"
                                                                        data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        title="Edit"
                                                                        aria-label="Edit"
                                                                        data-id="<?= (int) $row->id; ?>"
                                                                        data-event-id="<?= (int) $row->event_id; ?>"
                                                                        data-event-name="<?= htmlspecialchars($row->event_name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-event-group="<?= htmlspecialchars($row->event_group, ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-category-name="<?= htmlspecialchars($row->category ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-first-name="<?= htmlspecialchars($row->first_name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-middle-name="<?= htmlspecialchars($row->middle_name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-last-name="<?= htmlspecialchars($row->last_name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-medal="<?= htmlspecialchars($row->medal, ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-municipality="<?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-school="<?= htmlspecialchars($row->school ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-coach="<?= htmlspecialchars($row->coach ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-entry-type="<?= htmlspecialchars($row->entry_type ?? 'Individual', ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-team-names="<?= htmlspecialchars($row->team_names ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                                                        <i class="mdi mdi-pencil"></i>
                                                                    </button>

                                                                    <form action="<?= app_url('delete_winner/' . (int) $row->id); ?>"
                                                                        method="post" onsubmit="return confirm('Delete this winner?');">
                                                                        <button type="submit"
                                                                            class="btn btn-outline-danger btn-sm btn-icon"
                                                                            data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Delete"
                                                                            aria-label="Delete">
                                                                            <i class="mdi mdi-delete-outline"></i>
                                                                        </button>
                                                                    </form>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center text-muted py-4">
                                            <i class="mdi mdi-trophy-outline" style="font-size: 1.6rem;"></i>
                                            <p class="mb-0">No entries yet. Click “Add Winners” to start encoding.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Events CRUD -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h5 class="card-title mb-0">Events</h5>
                                            <small class="text-muted">Add, edit, or delete events; categories auto-fill when selecting an event.</small>
                                        </div>
                                        <div class="d-flex align-items-center" style="gap: 8px;">
                                            <button type="button" class="btn btn-outline-success btn-sm" id="filterWinnersBtn">
                                                Show with winners
                                            </button>
                                            <button class="btn btn-sm btn-primary" id="openAddEventModal" data-toggle="modal" data-target="#eventModal">
                                                <i class="mdi mdi-plus"></i> Add Event
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover mb-0" id="eventsTable">
                                            <thead>
                                                <tr>
                                                    <th style="width:32%;">Event</th>
                                                    <th style="width:18%;">Group</th>
                                                    <th style="width:18%;">Category</th>
                                                    <th style="width:20%;" class="winner-col">Winners</th>
                                                    <th style="width:120px;" class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($events_list)): ?>
                                                    <?php $eventIndex = 0; ?>
                                                    <?php foreach ($events_list as $event): ?>
                                                        <tr data-winners="<?= isset($event->winners_count) ? (int) $event->winners_count : 0; ?>"
                                                            data-has-winner="<?= isset($event->winners_count) && (int) $event->winners_count > 0 ? 1 : 0; ?>"
                                                            data-original-index="<?= $eventIndex; ?>">
                                                            <td><?= htmlspecialchars($event->event_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($event->group_name ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($event->category_name ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <?php
                                                            $winnerCount = isset($event->winners_count) ? (int) $event->winners_count : 0;
                                                            $goldCount = isset($event->gold_count) ? (int) $event->gold_count : 0;
                                                            $silverCount = isset($event->silver_count) ? (int) $event->silver_count : 0;
                                                            $bronzeCount = isset($event->bronze_count) ? (int) $event->bronze_count : 0;
                                                            $hasWinners = $winnerCount > 0;
                                                            ?>
                                                            <td class="align-middle winner-col event-winner-cell"
                                                                data-winners="<?= $winnerCount; ?>"
                                                                data-has-winner="<?= $hasWinners ? 1 : 0; ?>"
                                                                data-order="<?= $winnerCount; ?>">
                                                                <span class="event-status-detail" style="display:none;">
                                                                    <?php if ($hasWinners): ?>
                                                                        <span class="event-status-badge filled">
                                                                            <i class="mdi mdi-check-circle-outline"></i>
                                                                            Has winners
                                                                        </span>
                                                                        <span class="event-status-meta">
                                                                            <?= $winnerCount; ?> posted · <?= $goldCount; ?>G / <?= $silverCount; ?>S / <?= $bronzeCount; ?>B
                                                                        </span>
                                                                    <?php endif; ?>
                                                                </span>
                                                                <span class="event-status-placeholder text-muted small">—</span>
                                                            </td>
                                                            <td class="text-right align-middle">
                                                                <span class="table-actions">
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-outline-secondary btn-sm btn-icon btn-edit-event"
                                                                        data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        title="Edit"
                                                                        aria-label="Edit"
                                                                        data-id="<?= (int) $event->event_id; ?>"
                                                                        data-name="<?= htmlspecialchars($event->event_name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-group-id="<?= $event->group_id !== null ? (int) $event->group_id : ''; ?>"
                                                                        data-category-name="<?= htmlspecialchars($event->category_name ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                                                        <i class="mdi mdi-pencil"></i>
                                                                    </button>
                                                                    <form action="<?= app_url('delete_event/' . (int) $event->event_id); ?>"
                                                                        method="post"
                                                                        class="confirm-submit"
                                                                        data-confirm="Delete this event?"
                                                                        data-confirm-title="Delete event">
                                                                        <input type="hidden" name="return_to" value="<?= uri_string(); ?>">
                                                                        <button type="submit"
                                                                            class="btn btn-outline-danger btn-sm btn-icon"
                                                                            data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Delete"
                                                                            aria-label="Delete">
                                                                            <i class="mdi mdi-delete-outline"></i>
                                                                        </button>
                                                                    </form>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <?php $eventIndex++; ?>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">No events found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php include('includes/footer.php'); ?>

        </div>

    </div>

    <?php include('includes/footer_plugins.php'); ?>

    <!-- Meet Header Modal -->
    <?php
    $meet_title = isset($meet->meet_title) ? $meet->meet_title : app_name();
    $meet_year  = isset($meet->meet_year)  ? $meet->meet_year  : date('Y');
    $subtitle   = isset($meet->subtitle)
        ? $meet->subtitle
        : 'Live results encoded by authorized officials. Read-only landing page for public viewing.';
    ?>
    <div class="modal fade" id="meetHeaderModal" tabindex="-1" role="dialog" aria-labelledby="meetHeaderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meetHeaderModalLabel"><i class="mdi mdi-cog-outline"></i> Meet Header Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open($appSlug . '/update_meet_settings'); ?>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Meet Title</label>
                        <input type="text" name="meet_title" class="form-control form-control-sm"
                            value="<?= htmlspecialchars($meet_title, ENT_QUOTES, 'UTF-8'); ?>"
                            required>
                    </div>

                    <div class="form-group mb-2">
                        <label>Year</label>
                        <input type="text" name="meet_year" class="form-control form-control-sm"
                            placeholder="e.x: 2025 or 2025–2026"
                            value="<?= htmlspecialchars($meet_year, ENT_QUOTES, 'UTF-8'); ?>"
                            required>
                    </div>

                    <div class="form-group mb-2">
                        <label>Subtitle</label>
                        <textarea name="subtitle" class="form-control form-control-sm" rows="2"
                            placeholder="Shown under the title on the landing page"><?= htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Header</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Add/Edit Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open($appSlug . '/add_event', array('id' => 'eventForm')); ?>
                <div class="modal-body">
                    <input type="hidden" name="return_to" value="<?= uri_string(); ?>">
                    <input type="hidden" name="event_id" id="eventIdField" value="">
                    <div class="form-group">
                        <label>Event Name</label>
                        <input type="text" name="event_name" id="eventName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Group</label>
                        <select name="group_id" id="eventGroup" class="form-control" required>
                            <option value="">-- Select Group --</option>
                            <?php foreach ($event_groups_list as $group): ?>
                                <?php $groupLabel = trim($group->group_name ?? '') !== '' ? $group->group_name : ''; ?>
                                <option value="<?= (int) $group->group_id; ?>">
                                    <?= htmlspecialchars($groupLabel, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" name="category_name" id="eventCategory" class="form-control" placeholder="Type a category name">
                        <small class="form-text text-muted">Leave blank if the event is uncategorized.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="eventSubmitBtn">Save Event</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Add Winner Modal -->
    <div class="modal fade" id="winnerModal" tabindex="-1" role="dialog" aria-labelledby="winnerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="winnerModalLabel"><i class="mdi mdi-plus-circle-outline"></i> Add Winners</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open($appSlug . '/admin', array('id' => 'winnerForm')); ?>
                <div class="modal-body">
                    <input type="hidden" name="winner_id" id="winnerIdField" value="">
                    <div class="form-group">
                        <label>Event <span class="text-danger">*</span></label>
                        <select name="event_id" id="eventSelect" class="form-control" required>
                            <option value="">-- Select Event --</option>
                            <?php
                            $events_list_sorted = is_array($events_list) ? $events_list : array();
                            if (!empty($events_list_sorted)) {
                                usort($events_list_sorted, function ($a, $b) {
                                    return strcasecmp($a->event_name ?? '', $b->event_name ?? '');
                                });
                            }
                            $eventSeen = array();
                            foreach ($events_list_sorted as $event):
                                $eventName = trim($event->event_name);
                                $labelKey = strtolower($eventName);
                                if (isset($eventSeen[$labelKey])) {
                                    continue; // avoid duplicate event names
                                }
                                $eventSeen[$labelKey] = true;
                            ?>
                                <option value="<?= (int) $event->event_id; ?>"
                                    data-group-name="<?= htmlspecialchars($event->group_name ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    data-category-name="<?= htmlspecialchars($event->category_name ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    <?= htmlspecialchars($eventName, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">Select the event; pick the matching group and category below.</small>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Group</label>
                            <select name="group_id" id="winnerGroupSelect" class="form-control">
                                <option value="">-- Select Group --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Category</label>
                            <select name="category_id" id="winnerCategorySelect" class="form-control">
                                <option value="">-- Select Category --</option>
                            </select>
                        </div>
                    </div>

                    <div class="alert alert-info py-2">
                        Add placements (1st–5th) in one go. Empty rows are skipped.
                    </div>

                    <div id="municipalityOptionsTemplate" class="d-none">
                        <option value="">-- Select Team --</option>
                        <?php foreach ($municipalities_list as $municipality): ?>
                            <?php $name = $municipality->municipality; ?>
                            <option value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
                                <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </div>

                    <div class="medal-section" data-medal="Gold">
                        <div class="medal-header mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-medal badge-gold mr-2">1st Place</span>
                                <span class="text-muted small">Winners for this placement</span>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-add-medal" data-medal="Gold">
                                <i class="mdi mdi-plus"></i> Add 1st place
                            </button>
                        </div>
                        <div class="medal-rows" id="goldRows"></div>
                    </div>

                    <div class="medal-section" data-medal="Silver">
                        <div class="medal-header mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-medal badge-silver mr-2">2nd Place</span>
                                <span class="text-muted small">Add one or more 2nd placers</span>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-add-medal" data-medal="Silver">
                                <i class="mdi mdi-plus"></i> Add 2nd place
                            </button>
                        </div>
                        <div class="medal-rows" id="silverRows"></div>
                    </div>

                    <div class="medal-section mb-0" data-medal="Bronze">
                        <div class="medal-header mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-medal badge-bronze mr-2">3rd Place</span>
                                <span class="text-muted small">Add any 3rd placers</span>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-add-medal" data-medal="Bronze">
                                <i class="mdi mdi-plus"></i> Add 3rd place
                            </button>
                        </div>
                        <div class="medal-rows" id="bronzeRows"></div>
                    </div>

                    <div class="medal-section mb-0" data-medal="4th">
                        <div class="medal-header mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-medal badge-silver mr-2">4th Place</span>
                                <span class="text-muted small">Optional: capture 4th place finishers</span>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-add-medal" data-medal="4th">
                                <i class="mdi mdi-plus"></i> Add 4th place
                            </button>
                        </div>
                        <div class="medal-rows" id="fourthRows"></div>
                    </div>

                    <div class="medal-section mb-0" data-medal="5th">
                        <div class="medal-header mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-medal badge-silver mr-2">5th Place</span>
                                <span class="text-muted small">Optional: capture 5th place finishers</span>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-add-medal" data-medal="5th">
                                <i class="mdi mdi-plus"></i> Add 5th place
                            </button>
                        </div>
                        <div class="medal-rows" id="fifthRows"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" value="1" class="btn btn-success" id="winnerSubmitBtn">
                        <i class="mdi mdi-content-save-outline"></i> Save Winners
                    </button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open($appSlug . '/add_category'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Event Name</label>
                        <input type="text" name="category_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open($appSlug . '/update_category'); ?>
                <div class="modal-body">
                    <input type="hidden" name="category_id" id="editCategoryId">
                    <div class="form-group">
                        <label>Event Name</label>
                        <input type="text" name="category_name" id="editCategoryName" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            if ($.fn.tooltip) {
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'body'
                });
            }
            if (window.Swal) {
                var flashSuccess = <?= json_encode($flash_success ?? ''); ?>;
                var flashError = <?= json_encode($flash_error ?? ''); ?>;
                if (flashSuccess) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: flashSuccess,
                        timer: 2200,
                        showConfirmButton: false
                    });
                }
                if (flashError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Notice',
                        text: flashError
                    });
                }
            }

            var createAction = "<?= app_url('admin'); ?>";
            var updateAction = "<?= app_url('update_winner'); ?>";
            var createEventAction = "<?= app_url('add_event'); ?>";
            var updateEventAction = "<?= app_url('update_event'); ?>";
            var eventsTable = null;
            var $eventSelect = $('#eventSelect');
            var $winnerGroupSelect = $('#winnerGroupSelect');
            var $winnerCategorySelect = $('#winnerCategorySelect');
            var $winnerForm = $('#winnerForm');
            var $winnerSubmitBtn = $('#winnerSubmitBtn');
            var $winnerModalLabel = $('#winnerModalLabel');
            var $eventForm = $('#eventForm');
            var $eventModalLabel = $('#eventModalLabel');
            var $eventSubmitBtn = $('#eventSubmitBtn');
            var $eventIdField = $('#eventIdField');
            var $eventNameInput = $('#eventName');
            var $eventGroupSelect = $('#eventGroup');
            var $eventCategorySelect = $('#eventCategory');
            var eventsMeta = <?= json_encode(array_map(function ($ev) {
                                    return array(
                                        'id' => (int)$ev->event_id,
                                        'name' => $ev->event_name,
                                        'group_id' => isset($ev->group_id) ? (int)$ev->group_id : null,
                                        'group_name' => $ev->group_name ?? '',
                                        'category_id' => isset($ev->category_id) ? (int)$ev->category_id : null,
                                        'category_name' => $ev->category_name ?? '',
                                    );
                                }, $events_list)); ?>;
            eventsMeta.sort(function(a, b) {
                return (a.name || '').localeCompare(b.name || '');
            });
            var groupOptions = <?= json_encode(array_map(function ($g) {
                                    $label = isset($g->group_name) && trim($g->group_name) !== '' ? $g->group_name : '';
                                    return array(
                                        'id' => (int) $g->group_id,
                                        'name' => $label,
                                    );
                                }, $event_groups_list)); ?>;
            groupOptions.sort(function(a, b) {
                return (a.name || '').localeCompare(b.name || '');
            });
            var medalContainers = {
                Gold: $('#goldRows'),
                Silver: $('#silverRows'),
                Bronze: $('#bronzeRows'),
                '4th': $('#fourthRows'),
                '5th': $('#fifthRows')
            };
            var municipalityOptionsHtml = $('#municipalityOptionsTemplate').html();
            var rowCounter = 0;
            var isEditMode = false;

            function setEventCreateMode() {
                $eventForm.attr('action', createEventAction);
                $eventModalLabel.text('Add Event');
                $eventSubmitBtn.text('Save Event');
                $eventIdField.val('');
                $eventNameInput.val('');
                $eventGroupSelect.val('');
                $eventCategorySelect.val('');
            }

            function setEventEditMode(data) {
                $eventForm.attr('action', updateEventAction);
                $eventModalLabel.text('Edit Event');
                $eventSubmitBtn.text('Update Event');
                $eventIdField.val(data.id || '');
                $eventNameInput.val(data.name || '');
                $eventGroupSelect.val(data.group_id || '');
                $eventCategorySelect.val(data.category_name || '');
            }

            function rebuildGroupAndCategoryOptions(eventId) {
                var selected = eventsMeta.find(function(ev) {
                    return ev.id === parseInt(eventId, 10);
                });
                var nameKey = selected ? (selected.name || '').toLowerCase() : '';

                // Always allow full group list (Elementary/Secondary)
                $winnerGroupSelect.empty().append('<option value="">-- Select Group --</option>');
                groupOptions.forEach(function(g) {
                    $winnerGroupSelect.append(
                        $('<option>', {
                            value: g.id,
                            text: g.name || ''
                        })
                    );
                });

                // Build unique categories for matching event name
                var categories = {};
                eventsMeta.forEach(function(ev) {
                    if (!nameKey || (ev.name || '').toLowerCase() === nameKey) {
                        var cKey = (ev.category_id || '') + '|' + (ev.category_name || '');
                        categories[cKey] = {
                            id: ev.category_id,
                            name: ev.category_name
                        };
                    }
                });
                $winnerCategorySelect.empty().append('<option value="">-- Select Category --</option>');
                Object.values(categories).forEach(function(c) {
                    if (!c.name) return;
                    $winnerCategorySelect.append(
                        $('<option>', {
                            value: c.id || c.name,
                            text: c.name
                        })
                    );
                });

                if (selected) {
                    if (selected.group_id) {
                        $winnerGroupSelect.val(selected.group_id.toString());
                    }
                    if (selected.category_id) {
                        $winnerCategorySelect.val(selected.category_id);
                    } else if (selected.category_name) {
                        $winnerCategorySelect.val(selected.category_name);
                    }
                }
            }

            function clearAllRows() {
                $.each(medalContainers, function(key, $container) {
                    $container.empty();
                });
            }

            function setRowMode($row, mode) {
                mode = (mode || 'Individual').toString().toLowerCase();
                var isTeam = mode === 'team';
                $row.find('.entry-type-value').val(isTeam ? 'Team' : 'Individual');
                $row.find('.entry-type-btn').removeClass('active');
                $row.find('.entry-type-btn[data-type="' + (isTeam ? 'Team' : 'Individual') + '"]').addClass('active');
                $row.find('.individual-fields').toggleClass('d-none', isTeam);
                $row.find('.team-fields').toggleClass('d-none', !isTeam);
                if (isTeam) {
                    // Clear individual name fields when switching to team mode
                    $row.find('.individual-fields input').val('');
                } else {
                    // Clear team textarea when switching back
                    $row.find('textarea[name$="[team_names]"]').val('');
                }
            }

            function addWinnerRow(medal, data) {
                data = data || {};
                if (!medalContainers[medal]) {
                    return;
                }

                if (isEditMode) {
                    clearAllRows();
                }

                rowCounter += 1;
                var index = rowCounter;
                var badgeClass = 'badge-bronze';
                var badgeLabel = medal;
                if (medal === 'Gold') {
                    badgeClass = 'badge-gold';
                    badgeLabel = '1st Place';
                } else if (medal === 'Silver') {
                    badgeClass = 'badge-silver';
                    badgeLabel = '2nd Place';
                } else if (medal === 'Bronze') {
                    badgeClass = 'badge-bronze';
                    badgeLabel = '3rd Place';
                } else if (medal === '4th' || medal === '5th') {
                    badgeClass = 'badge-silver';
                    badgeLabel = medal + ' Place';
                }

                var entryNumber = medalContainers[medal].find('.medal-row').length + 1;
                var $row = $(
                    '<div class="medal-row card mb-2" data-medal="' + medal + '">' +
                    '<div class="card-body pb-2">' +
                    '<div class="d-flex align-items-center justify-content-between mb-2">' +
                    '<div class="d-flex align-items-center">' +
                    '<span class="badge badge-medal ' + badgeClass + ' mr-2">' + badgeLabel + '</span>' +
                    '<small class="text-muted">Entry ' + entryNumber + '</small>' +
                    '</div>' +
                    '<button type="button" class="btn btn-link text-danger p-0 btn-remove-row">Remove</button>' +
                    '</div>' +
                    '<div class="form-row align-items-end">' +
                    '<div class="form-group col-md-4">' +
                    '<label class="small text-muted mb-1">Entry type</label>' +
                    '<div class="entry-type-toggle">' +
                    '<input type="hidden" class="entry-type-value" name="winners[' + index + '][entry_type]" value="Individual">' +
                    '<button type="button" class="entry-type-btn" data-type="Individual">Individual</button>' +
                    '<button type="button" class="entry-type-btn" data-type="Team">Team</button>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group col-md-8 team-fields d-none">' +
                    '<label class="small text-muted mb-1">Team members / names</label>' +
                    '<textarea name="winners[' + index + '][team_names]" class="form-control form-control-sm" rows="2" placeholder="Enter one or multiple names for this team"></textarea>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-row individual-fields">' +
                    '<div class="form-group col-md-4">' +
                    '<label class="small text-muted mb-1">First name</label>' +
                    '<input type="text" name="winners[' + index + '][first_name]" class="form-control form-control-sm">' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<label class="small text-muted mb-1">Middle name</label>' +
                    '<input type="text" name="winners[' + index + '][middle_name]" class="form-control form-control-sm">' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<label class="small text-muted mb-1">Last name</label>' +
                    '<input type="text" name="winners[' + index + '][last_name]" class="form-control form-control-sm">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-row">' +
                    '<div class="form-group col-md-4">' +
                    '<label class="small text-muted mb-1">Team</label>' +
                    '<select name="winners[' + index + '][municipality]" class="form-control form-control-sm">' +
                    municipalityOptionsHtml +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<label class="small text-muted mb-1">School</label>' +
                    '<input type="text" name="winners[' + index + '][school]" class="form-control form-control-sm" placeholder="School name">' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<label class="small text-muted mb-1">Coach</label>' +
                    '<input type="text" name="winners[' + index + '][coach]" class="form-control form-control-sm" placeholder="Coach">' +
                    '</div>' +
                    '</div>' +
                    '<input type="hidden" name="winners[' + index + '][medal]" value="' + medal + '">' +
                    '</div>' +
                    '</div>'
                );

                $row.find('input[name="winners[' + index + '][first_name]"]').val(data.first_name || '');
                $row.find('input[name="winners[' + index + '][middle_name]"]').val(data.middle_name || '');
                $row.find('input[name="winners[' + index + '][last_name]"]').val(data.last_name || '');
                var combinedNames = $.trim([data.first_name, data.middle_name, data.last_name].filter(Boolean).join(' '));
                $row.find('textarea[name="winners[' + index + '][team_names]"]').val(data.team_names || combinedNames || '');
                $row.find('select[name="winners[' + index + '][municipality]"]').val(data.municipality || '');
                $row.find('input[name="winners[' + index + '][school]"]').val(data.school || '');
                $row.find('input[name="winners[' + index + '][coach]"]').val(data.coach || '');

                medalContainers[medal].append($row);
                var mode = (data.entry_type || 'Individual');
                setRowMode($row, mode);

                $row.find('.entry-type-btn').on('click', function() {
                    setRowMode($row, $(this).data('type'));
                });
            }

            function seedDefaultRows() {
                clearAllRows();
                rowCounter = 0;
                addWinnerRow('Gold');
            }

            function ensureBaseRows() {
                if (medalContainers.Gold.find('.medal-row').length === 0) {
                    addWinnerRow('Gold');
                }
            }

            $(document).on('click', '.btn-add-medal', function() {
                var medal = $(this).data('medal');
                addWinnerRow(medal);
            });

            $(document).on('click', '.btn-remove-row', function() {
                $(this).closest('.medal-row').remove();
            });

            function setCreateMode() {
                isEditMode = false;
                $winnerForm.attr('action', createAction);
                $('#winnerIdField').val('');
                $eventSelect.val('').trigger('change');
                $winnerGroupSelect.empty().append('<option value="">-- Select Group --</option>');
                $winnerCategorySelect.empty().append('<option value="">-- Select Category --</option>');
                $winnerSubmitBtn.html('<i class="mdi mdi-content-save-outline"></i> Save Winners');
                $winnerModalLabel.text('Add Winners');
                seedDefaultRows();
            }

            function setEditMode(data) {
                isEditMode = true;
                $winnerForm.attr('action', updateAction);
                $('#winnerIdField').val(data.id || '');

                var eventId = data.event_id ? String(data.event_id) : '';
                var eventName = (data.event_name || '').toString();

                // 1) Select event (by ID if possible, else by name, else create custom option)
                if (eventId && $eventSelect.find('option[value="' + eventId + '"]').length) {
                    $eventSelect.val(eventId);
                } else if (eventName) {
                    var matchedId = '';
                    $eventSelect.find('option').each(function() {
                        if ($.trim($(this).text()).toLowerCase() === eventName.toLowerCase()) {
                            matchedId = $(this).val();
                        }
                    });
                    if (matchedId) {
                        $eventSelect.val(matchedId);
                    } else {
                        // create a temp option so the original event name still shows
                        var tempValue = 'custom_' + Date.now();
                        $eventSelect.append(
                            $('<option>', {
                                value: tempValue,
                                text: eventName
                            })
                        );
                        $eventSelect.val(tempValue);
                    }
                } else {
                    $eventSelect.val('');
                }

                // 2) Rebuild Group + Category options based on selected event
                rebuildGroupAndCategoryOptions($eventSelect.val());

                // 3) Restore previous group (by name)
                var groupName = (data.event_group || '').toString();
                if (groupName) {
                    var groupId = '';
                    groupOptions.forEach(function(g) {
                        if ((g.name || '').toLowerCase() === groupName.toLowerCase()) {
                            groupId = g.id;
                        }
                    });

                    if (groupId && $winnerGroupSelect.find('option[value="' + groupId + '"]').length) {
                        $winnerGroupSelect.val(String(groupId));
                    } else {
                        // fallback: match by text or add a custom option
                        var groupMatched = false;
                        $winnerGroupSelect.find('option').each(function() {
                            if ($.trim($(this).text()).toLowerCase() === groupName.toLowerCase()) {
                                groupMatched = true;
                                $winnerGroupSelect.val($(this).val());
                            }
                        });
                        if (!groupMatched) {
                            var customVal = 'custom_' + groupName.replace(/\s+/g, '_');
                            $winnerGroupSelect.append(
                                $('<option>', {
                                    value: customVal,
                                    text: groupName
                                })
                            );
                            $winnerGroupSelect.val(customVal);
                        }
                    }
                }

                // 4) Restore previous category (by name)
                var categoryName = (data.category_name || '').toString();
                if (categoryName) {
                    var catMatched = false;
                    $winnerCategorySelect.find('option').each(function() {
                        if ($.trim($(this).text()).toLowerCase() === categoryName.toLowerCase()) {
                            catMatched = true;
                            $winnerCategorySelect.val($(this).val());
                        }
                    });
                    if (!catMatched) {
                        var customCatVal = 'custom_' + categoryName.replace(/\s+/g, '_');
                        $winnerCategorySelect.append(
                            $('<option>', {
                                value: customCatVal,
                                text: categoryName
                            })
                        );
                        $winnerCategorySelect.val(customCatVal);
                    }
                }

                // 5) Load the winner row fields (name, team, school, coach, etc.)
                clearAllRows();
                rowCounter = 0;
                addWinnerRow(data.medal || 'Gold', data);

                $winnerSubmitBtn.html('<i class="mdi mdi-content-save-outline"></i> Update Winner');
                $winnerModalLabel.text('Edit Winner');
            }


            $('#openWinnerModal').on('click', function() {
                setCreateMode();
            });

            $eventSelect.on('change', function() {
                var val = $(this).val() || '';
                rebuildGroupAndCategoryOptions(val);
            });

            $('#openAddEventModal').on('click', function() {
                setEventCreateMode();
            });

            $('#winnerModal').on('shown.bs.modal', function() {
                if (!isEditMode) {
                    ensureBaseRows();
                }
            });

            $('.btn-edit-winner').on('click', function() {
                var $btn = $(this);
                var data = {
                    id: $btn.data('id'),
                    event_id: $btn.data('event-id'),
                    event_name: $btn.data('event-name') || '',
                    event_group: $btn.data('event-group') || '',
                    category_name: $btn.data('category-name') || '',
                    first_name: $btn.data('first-name'),
                    middle_name: $btn.data('middle-name'),
                    last_name: $btn.data('last-name'),
                    medal: $btn.data('medal'),
                    municipality: $btn.data('municipality'),
                    school: $btn.data('school'),
                    coach: $btn.data('coach'),
                    entry_type: $btn.data('entry-type') || 'Individual',
                    team_names: $btn.data('team-names') || ''
                };

                setEditMode(data);
                $('#winnerModal').modal('show');
            });


            $('.btn-edit-event').on('click', function() {
                var $btn = $(this);
                var data = {
                    id: $btn.data('id'),
                    name: $btn.data('name'),
                    group_id: ($btn.data('group-id') || '').toString(),
                    category_name: ($btn.data('category-name') || '').toString()
                };
                setEventEditMode(data);
                $('#eventModal').modal('show');
            });

            seedDefaultRows();

            if ($.fn.DataTable) {
                $('#recentWinnersTable').DataTable({
                    pageLength: 25,
                    lengthChange: true,
                    order: [
                        [8, 'desc'],
                        [4, 'desc']
                    ],
                    columnDefs: [{
                            targets: -1,
                            orderable: false,
                            searchable: false
                        },
                        {
                            targets: 8,
                            visible: false
                        }
                    ],
                    autoWidth: false
                });

                eventsTable = $('#eventsTable').DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    order: [
                        [0, 'asc']
                    ],
                    columnDefs: [{
                        targets: -1,
                        orderable: false,
                        searchable: false
                    }],
                    autoWidth: false
                });
                // hide winners column by default
                eventsTable.column(3).visible(false);
                eventsTable.on('draw', function() {
                    updateWinnerVisibility();
                });
            } else {
                $('#eventsTable .winner-col').hide();
            }

            var showWinnersOnly = false;
            var $filterWinnersBtn = $('#filterWinnersBtn');

            function updateWinnerVisibility() {
                $('.event-winner-cell').each(function() {
                    var has = parseInt($(this).data('has-winner'), 10) === 1 || (parseInt($(this).data('winners'), 10) || 0) > 0;
                    if (showWinnersOnly && has) {
                        $(this).find('.event-status-detail').show();
                        $(this).find('.event-status-placeholder').hide();
                    } else {
                        $(this).find('.event-status-detail').hide();
                        $(this).find('.event-status-placeholder').show();
                    }
                });
            }

            function applyEventsFilter() {
                if (eventsTable) {
                    eventsTable.column(3).visible(showWinnersOnly);
                    if (showWinnersOnly) {
                        eventsTable.order([
                            [3, 'desc']
                        ]).draw();
                    } else {
                        eventsTable.order([
                            [1, 'asc'],
                            [0, 'asc']
                        ]).draw();
                    }
                    return;
                }

                var $tbody = $('#eventsTable tbody');
                var rows = $tbody.children('tr').get();

                rows.sort(function(a, b) {
                    if (showWinnersOnly) {
                        var bw = parseInt($(b).data('winners'), 10) || 0;
                        var aw = parseInt($(a).data('winners'), 10) || 0;
                        var diff = bw - aw;
                        if (diff !== 0) return diff;
                    }
                    var ai = parseInt($(a).data('original-index'), 10) || 0;
                    var bi = parseInt($(b).data('original-index'), 10) || 0;
                    return ai - bi;
                });

                $tbody.empty();
                rows.forEach(function(row) {
                    var winners = parseInt($(row).data('winners'), 10) || 0;
                    if (showWinnersOnly && winners === 0) return;
                    $tbody.append(row);
                });

                $('#eventsTable .winner-col').toggle(showWinnersOnly);
            }

            if ($filterWinnersBtn.length) {
                if ($.fn.dataTable && $.fn.dataTable.ext && $.fn.dataTable.ext.search) {
                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        if (!eventsTable || settings.nTable !== $('#eventsTable')[0]) {
                            return true;
                        }
                        if (!showWinnersOnly) {
                            return true;
                        }
                        var node = eventsTable.row(dataIndex).node();
                        var winners = parseInt($(node).getAttribute('data-winners'), 10) || 0;
                        return winners > 0;
                    });
                }

                $filterWinnersBtn.on('click', function() {
                    showWinnersOnly = !showWinnersOnly;
                    $(this)
                        .toggleClass('btn-outline-success', !showWinnersOnly)
                        .toggleClass('btn-success', showWinnersOnly)
                        .text(showWinnersOnly ? 'Show all events' : 'Show with winners');
                    $('#eventsTable').toggleClass('table-show-winners', showWinnersOnly);
                    updateWinnerVisibility();
                    applyEventsFilter();
                    if (eventsTable) {
                        eventsTable.columns.adjust();
                        if (showWinnersOnly) {
                            eventsTable.order([
                                [3, 'desc']
                            ]).draw();
                        }
                    }
                });
            }

            updateWinnerVisibility();
            applyEventsFilter();
            if (showWinnersOnly && eventsTable) {
                eventsTable.order([
                    [3, 'desc']
                ]).draw();
            }

            // Generic confirm using SweetAlert
            $('.confirm-submit').on('submit', function(e) {
                var form = this;
                var title = form.getAttribute('data-confirm-title') || 'Are you sure?';
                var text = form.getAttribute('data-confirm') || 'Proceed with this action?';
                if (!window.Swal) {
                    return true;
                }
                e.preventDefault();
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, continue',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33'
                }).then(function(result) {
                    if (result && (result.isConfirmed || result.value === true)) {
                        form.submit();
                    }
                });
                return false;
            });

            <?php if (!empty($validation_list) || !empty($error_message)): ?>
                setCreateMode();
                $('#winnerModal').modal('show');
            <?php endif; ?>
        });
    </script>

</body>

</html>
