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

    .table thead th {
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        color: #6b7280;
        border-bottom-width: 2px;
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
</style>

<body>
    <div id="wrapper">

        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <?php
                    $validation_list       = validation_errors('<li>', '</li>');
                    $error_message         = $this->session->flashdata('error');
                    $success_message       = $this->session->flashdata('success');
                    $event_categories_list = isset($event_categories) ? $event_categories : array();
                    $event_groups_list     = isset($event_groups) ? $event_groups : array();
                    $events_list           = isset($events) ? $events : array();
                    $appSlug               = app_slug();
                    ?>

                    <div class="row align-items-center mb-3">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-1">Events Manager</h4>
                                <p class="text-muted mb-0">Add, edit, or delete events; categories auto-fill when selecting an event.</p>
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
                    </div>

                    <!-- Alerts (kept but hidden; SweetAlert will show instead) -->
                    <div class="row">
                        <div class="col-lg-8">
                            <?php if (!empty($success_message)): ?>
                                <div class="alert alert-success alert-dismissible fade show d-none">
                                    <?= $success_message; ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($error_message)): ?>
                                <div class="alert alert-danger alert-dismissible fade show d-none">
                                    <?= $error_message; ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($validation_list)): ?>
                                <div class="alert alert-danger alert-dismissible fade show d-none">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <ul class="mb-0 pl-3" style="list-style: disc;">
                                        <?= $validation_list; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
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
                                                        <tr data-winners="<?= isset($event->winners_count) ? (int)$event->winners_count : 0; ?>"
                                                            data-has-winner="<?= isset($event->winners_count) && (int)$event->winners_count > 0 ? 1 : 0; ?>"
                                                            data-original-index="<?= $eventIndex; ?>">
                                                            <td><?= htmlspecialchars($event->event_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($event->group_name ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($event->category_name ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <?php
                                                            $winnerCount = isset($event->winners_count) ? (int)$event->winners_count : 0;
                                                            $goldCount   = isset($event->gold_count) ? (int)$event->gold_count : 0;
                                                            $silverCount = isset($event->silver_count) ? (int)$event->silver_count : 0;
                                                            $bronzeCount = isset($event->bronze_count) ? (int)$event->bronze_count : 0;
                                                            $hasWinners  = $winnerCount > 0;
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
                                                                <span class="d-inline-flex align-items-center justify-content-end" style="gap: 6px;">
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-outline-secondary btn-sm btn-icon btn-edit-event"
                                                                        data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        title="Edit"
                                                                        aria-label="Edit"
                                                                        data-id="<?= (int)$event->event_id; ?>"
                                                                        data-name="<?= htmlspecialchars($event->event_name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-group-id="<?= $event->group_id !== null ? (int)$event->group_id : ''; ?>"
                                                                        data-category-name="<?= htmlspecialchars($event->category_name ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                                                        <i class="mdi mdi-pencil"></i>
                                                                    </button>
                                                                    <form action="<?= app_url('delete_event/' . (int) $event->event_id); ?>"
                                                                        method="post" onsubmit="return confirm('Delete this event?');" class="m-0 p-0">
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
                                <option value="<?= (int)$group->group_id; ?>">
                                    <?= htmlspecialchars($group->group_name, ENT_QUOTES, 'UTF-8'); ?>
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

    <script>
        $(function() {

            // Helper: SweetAlert or fallback to alert()
            function showSwal(type, title, htmlMessage) {
                if (typeof Swal !== 'undefined' && Swal.fire) {
                    Swal.fire({
                        icon: type,
                        title: title,
                        html: htmlMessage,
                        confirmButtonColor: (type === 'success') ? '#3085d6' : '#d33'
                    });
                } else if (typeof swal !== 'undefined') {
                    // SweetAlert v1 fallback
                    swal({
                        title: title,
                        text: $("<div>").html(htmlMessage).text(),
                        icon: type
                    });
                } else {
                    // Browser alert fallback
                    alert(title + "\n\n" + $("<div>").html(htmlMessage).text());
                }
            }

            // ✅ Show SweetAlert for flash messages (does NOT block saving)
            <?php if (!empty($success_message)): ?>
                showSwal('success', 'Success', <?= json_encode($success_message); ?>);
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                showSwal('error', 'Error', <?= json_encode($error_message); ?>);
            <?php endif; ?>

            <?php if (!empty($validation_list)): ?>
                showSwal(
                    'warning',
                    'Validation Error',
                    `<ul style="text-align:left; margin-left:20px;"><?= $validation_list; ?></ul>`
                );
            <?php endif; ?>

            if ($.fn.tooltip) {
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'body'
                });
            }

            var createEventAction = "<?= app_url('add_event'); ?>";
            var updateEventAction = "<?= app_url('update_event'); ?>";
            var eventsTable = null;
            var $eventForm = $('#eventForm');
            var $eventModalLabel = $('#eventModalLabel');
            var $eventSubmitBtn = $('#eventSubmitBtn');
            var $eventIdField = $('#eventIdField');
            var $eventNameInput = $('#eventName');
            var $eventGroupSelect = $('#eventGroup');
            var $eventCategorySelect = $('#eventCategory');

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

            $('#openAddEventModal').on('click', function() {
                setEventCreateMode();
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

            // ⚠️ No SweetAlert on submit here – form posts normally to CI controller.

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
                        // Sort by winners desc, then Event asc
                        eventsTable.order([
                            [3, 'desc'],
                            [0, 'asc']
                        ]).draw();
                    } else {
                        // ✅ always sort by Event only when showing all
                        eventsTable.order([
                            [0, 'asc']
                        ]).draw();
                    }
                    return;
                }

                // Fallback (non-DataTables) – not really used in your setup
                var $tbody = $('#eventsTable tbody');
                var rows = $tbody.children('tr').get();

                rows.sort(function(a, b) {
                    if (showWinnersOnly) {
                        var bw = parseInt($(b).data('winners'), 10) || 0;
                        var aw = parseInt($(a).data('winners'), 10) || 0;
                        var diff = bw - aw;
                        if (diff !== 0) return diff;
                    }
                    var ai = parseInt(a.dataset.originalIndex || '0', 10);
                    var bi = parseInt(b.dataset.originalIndex || '0', 10);
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
                        var winners = parseInt($(node).data('winners'), 10) || 0;
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
                    }
                });
            }

            if ($.fn.DataTable) {
                eventsTable = $('#eventsTable').DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    // ✅ default sort: Event only
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
                eventsTable.column(3).visible(false);
                eventsTable.on('draw', function() {
                    updateWinnerVisibility();
                });
            } else {
                $('#eventsTable .winner-col').hide();
            }

            updateWinnerVisibility();
            applyEventsFilter();
        });
    </script>

</body>

</html>
