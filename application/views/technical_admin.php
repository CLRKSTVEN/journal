<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    body {
        font-family: var(--app-font);
        background: #f8fafc;
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
</style>

<body>
    <div id="wrapper">

        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <?php
                    $technical = isset($technical) ? $technical : array();
                    $events = isset($events) ? $events : array();
                    $event_groups = isset($event_groups) ? $event_groups : array();
                    $event_categories = isset($event_categories) ? $event_categories : array();
                    $appSlug = app_slug();
                    $meet_title = isset($meet->meet_title) ? $meet->meet_title : app_name();
                    $meet_year  = isset($meet->meet_year)  ? $meet->meet_year  : date('Y');
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
                                <div class="mb-2">
                                    <h4 class="page-title mb-0">
                                        <?= htmlspecialchars($meet_title . ' ' . $meet_year, ENT_QUOTES, 'UTF-8'); ?> – Technical Officials
                                    </h4>
                                </div>
                                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">

                                </div>
                            </div>
                            <hr style="border:0;height:2px;background:linear-gradient(90deg,#059669 0%,#0ea5e9 50%,#22c55e 100%);border-radius:999px;margin-top:4px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <?= $this->session->flashdata('success'); ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <?= $this->session->flashdata('error'); ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h5 class="card-title mb-0">Technical lineup</h5>
                                            <small class="text-muted">List the Tournament Manager and any Technical Officials.</small>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addTechnicalModal">
                                            <i class="mdi mdi-plus"></i> Add Entry
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="technicalTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Event</th>
                                                    <th>Group</th>
                                                    <th>Category</th>
                                                    <th class="text-right" style="width: 140px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($technical)): ?>
                                                    <?php foreach ($technical as $row): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->role, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->event_name_display ?? $row->event_name ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->event_group_display ?? $row->event_group ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->category_display ?? $row->category ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td class="text-right">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-outline-secondary btn-sm btn-icon btn-edit-tech"
                                                                    data-id="<?= (int) $row->id; ?>"
                                                                    data-name="<?= htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-role="<?= htmlspecialchars($row->role, ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-group="<?= htmlspecialchars($row->event_group ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-category="<?= htmlspecialchars($row->category ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-event_id="<?= isset($row->event_id) ? (int) $row->event_id : ''; ?>"
                                                                    title="Edit official" data-toggle="tooltip" data-placement="top">
                                                                    <i class="mdi mdi-pencil" aria-hidden="true"></i>
                                                                    <span class="sr-only">Edit official</span>
                                                                </button>
                                                                <form class="d-inline" action="<?= app_url('delete_technical'); ?>" method="post"
                                                                    onsubmit="return confirm('Delete this entry?');">
                                                                    <input type="hidden" name="id" value="<?= (int) $row->id; ?>">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-icon"
                                                                        title="Delete official" data-toggle="tooltip" data-placement="top">
                                                                        <i class="mdi mdi-delete-outline" aria-hidden="true"></i>
                                                                        <span class="sr-only">Delete official</span>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">No technical officials yet.</td>
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

    <!-- Add Modal -->
    <div class="modal fade" id="addTechnicalModal" tabindex="-1" role="dialog" aria-labelledby="addTechnicalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTechnicalModalLabel">Add Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open($appSlug . '/add_technical'); ?>
                <div class="modal-body">
                   <div class="form-group">
                       <label>Event</label>
                        <select name="event_id" id="addEventSelect" class="form-control form-control-lg" required>
                           <option value="">Select event</option>
                            <?php foreach ($events as $ev): ?>
                                <option value="<?= (int) $ev->event_id; ?>"
                                    data-group-id="<?= isset($ev->group_id) ? (int) $ev->group_id : ''; ?>"
                                    data-group-name="<?= htmlspecialchars($ev->group_name ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    data-category-id="<?= isset($ev->category_id) ? (int) $ev->category_id : ''; ?>"
                                    data-category-name="<?= htmlspecialchars($ev->category_name ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    <?= htmlspecialchars($ev->event_name, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Group</label>
                            <select name="event_group" id="addGroupInput" class="form-control form-control-lg" required>
                                <option value="">Select group</option>
                                <?php foreach ($event_groups as $g): ?>
                                    <option value="<?= htmlspecialchars($g->group_name, ENT_QUOTES, 'UTF-8'); ?>">
                                        <?= htmlspecialchars($g->group_name, ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                       </div>
                       <div class="form-group col-md-6">
                           <label>Category</label>
                            <select name="event_category" id="addCategoryInput" class="form-control form-control-lg" required>
                                <option value="">Select category</option>
                                <?php foreach ($event_categories as $c): ?>
                                    <option value="<?= htmlspecialchars($c->category_name, ENT_QUOTES, 'UTF-8'); ?>">
                                        <?= htmlspecialchars($c->category_name, ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                       </div>
                   </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>Officials</strong>
                            <div class="text-muted small">Add Tournament Manager and Technical Officials.</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addOfficialRow">
                            <i class="mdi mdi-plus"></i> Add another
                        </button>
                    </div>
                    <div id="officialRows">
                        <div class="form-row official-row mb-2">
                            <div class="col-md-7 mb-2 mb-md-0">
                                <input type="text" name="names[]" class="form-control form-control-lg" placeholder="Full name" required>
                            </div>
                            <div class="col-md-5 d-flex align-items-center">
                                <select name="roles[]" class="form-control form-control-lg" required>
                                    <option value="Tournament Manager">Tournament Manager</option>
                                    <option value="Technical Official" selected>Technical Official</option>
                                </select>
                                <button type="button" class="btn btn-link text-danger ml-2 remove-official-row" title="Remove">
                                    <i class="mdi mdi-close"></i>
                                </button>
                            </div>
                        </div>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editTechnicalModal" tabindex="-1" role="dialog" aria-labelledby="editTechnicalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTechnicalModalLabel">Edit Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open($appSlug . '/update_technical'); ?>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editTechId">
                    <div class="form-group">
                        <label>Event</label>
                        <select name="event_id" id="editEventSelect" class="form-control" required>
                            <option value="">Select event</option>
                            <?php foreach ($events as $ev): ?>
                                <option value="<?= (int) $ev->event_id; ?>"
                                    data-group-id="<?= isset($ev->group_id) ? (int) $ev->group_id : ''; ?>"
                                    data-group-name="<?= htmlspecialchars($ev->group_name ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    data-category-id="<?= isset($ev->category_id) ? (int) $ev->category_id : ''; ?>"
                                    data-category-name="<?= htmlspecialchars($ev->category_name ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    <?= htmlspecialchars($ev->event_name, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Group</label>
                            <select name="event_group" id="editGroupInput" class="form-control form-control-lg" required>
                                <option value="">Select group</option>
                                <?php foreach ($event_groups as $g): ?>
                                    <option value="<?= htmlspecialchars($g->group_name, ENT_QUOTES, 'UTF-8'); ?>">
                                        <?= htmlspecialchars($g->group_name, ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Category</label>
                            <select name="event_category" id="editCategoryInput" class="form-control form-control-lg" required>
                                <option value="">Select category</option>
                                <?php foreach ($event_categories as $c): ?>
                                    <option value="<?= htmlspecialchars($c->category_name, ENT_QUOTES, 'UTF-8'); ?>">
                                        <?= htmlspecialchars($c->category_name, ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="editTechName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" id="editTechRole" class="form-control" required>
                            <option value="Tournament Manager">Tournament Manager</option>
                            <option value="Technical Official">Technical Official</option>
                        </select>
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
            var eventsMeta = <?= json_encode(array_map(function ($ev) {
                return array(
                    'id' => (int)$ev->event_id,
                    'name' => $ev->event_name,
                    'group_id' => isset($ev->group_id) ? (int)$ev->group_id : null,
                    'group_name' => $ev->group_name ?? '',
                    'category_id' => isset($ev->category_id) ? (int)$ev->category_id : null,
                    'category_name' => $ev->category_name ?? '',
                );
            }, $events)); ?>;

            function applyEventMeta($eventSelect, $groupSelect, $catSelect) {
                var id = parseInt($eventSelect.val() || '0', 10);
                var match = eventsMeta.find(function(ev){ return ev.id === id; });

                $groupSelect.empty().append('<option value="">Select group</option>');
                $catSelect.empty().append('<option value="">Select category</option>');

                if (match) {
                    if (match.group_id || match.group_name) {
                        $groupSelect.append(
                            $('<option>', {
                                value: match.group_id || match.group_name,
                                text: match.group_name || ''
                            })
                        ).val(match.group_id || match.group_name);
                    }
                    if (match.category_id || match.category_name) {
                        $catSelect.append(
                            $('<option>', {
                                value: match.category_id || match.category_name,
                                text: match.category_name || ''
                            })
                        ).val(match.category_id || match.category_name);
                    }
                }
            }

            $('#addEventSelect').on('change', function() {
                applyEventMeta($('#addEventSelect'), $('#addGroupInput'), $('#addCategoryInput'));
            });
            $('#editEventSelect').on('change', function() {
                applyEventMeta($('#editEventSelect'), $('#editGroupInput'), $('#editCategoryInput'));
            });

            $('#addOfficialRow').on('click', function() {
                var row = `
                    <div class="form-row official-row mb-2">
                        <div class="col-md-7 mb-2 mb-md-0">
                            <input type="text" name="names[]" class="form-control" placeholder="Full name" required>
                        </div>
        <div class="col-md-5 d-flex align-items-center">
                            <select name="roles[]" class="form-control" required>
                                <option value="Tournament Manager">Tournament Manager</option>
                                <option value="Technical Official" selected>Technical Official</option>
                            </select>
                            <button type="button" class="btn btn-link text-danger ml-2 remove-official-row" title="Remove">
                                <i class="mdi mdi-close"></i>
                            </button>
                        </div>
                    </div>`;
                $('#officialRows').append(row);
            });

            $(document).on('click', '.remove-official-row', function() {
                var rows = $('#officialRows .official-row').length;
                if (rows > 1) {
                    $(this).closest('.official-row').remove();
                }
            });

            $('.btn-edit-tech').on('click', function() {
                var $btn = $(this);
                $('#editTechId').val($btn.data('id'));
                $('#editTechName').val($btn.data('name'));
                $('#editTechRole').val($btn.data('role'));
                var eventId = $btn.data('event_id') || '';
                $('#editEventSelect').val(eventId);
                $('#editGroupInput').val($btn.data('group') || '');
                $('#editCategoryInput').val($btn.data('category') || '');
                applyEventMeta($('#editEventSelect'), $('#editGroupInput'), $('#editCategoryInput'));
                $('#editTechnicalModal').modal('show');
            });

            if ($.fn.DataTable) {
                $('#technicalTable').DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    order: [
                        [1, 'asc'],
                        [2, 'asc']
                    ],
                    autoWidth: false,
                    columnDefs: [{
                        targets: -1,
                        orderable: false,
                        searchable: false
                    }]
                });
            }
        });
    </script>

</body>

</html>
