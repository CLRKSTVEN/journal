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

    .team-logo {
        width: 48px;
        height: 48px;
        object-fit: cover;
        aspect-ratio: 1 / 1;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
    }
</style>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
    <div id="wrapper">

        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <?php
                    $municipalities = isset($municipalities) ? $municipalities : array();
                    $appSlug = app_slug();
                    $meet_title = isset($meet->meet_title) ? $meet->meet_title : app_name();
                    $meet_year  = isset($meet->meet_year)  ? $meet->meet_year  : date('Y');
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
                                <div class="mb-2">
                                    <h4 class="page-title mb-0">
                                        <?= htmlspecialchars($meet_title . ' ' . $meet_year, ENT_QUOTES, 'UTF-8'); ?> – Teams
                                    </h4>
                                </div>

                            </div>
                            <hr style="border:0;height:2px;background:linear-gradient(90deg,#059669 0%,#0ea5e9 50%,#22c55e 100%);border-radius:999px;margin-top:4px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php if ($this->session->flashdata('success')): ?>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: <?= json_encode($this->session->flashdata('success')); ?>,
                                            timer: 3000,
                                            showConfirmButton: false
                                        });
                                    });
                                </script>
                            <?php endif; ?>

                            <?php if ($this->session->flashdata('error')): ?>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: <?= json_encode($this->session->flashdata('error')); ?>,
                                            confirmButtonText: 'OK'
                                        });
                                    });
                                </script>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h5 class="card-title mb-0">Teams list</h5>
                                            <small class="text-muted">Manage team names and logos.</small>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addMunicipalityModal">
                                            <i class="mdi mdi-plus"></i> Add Team
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="municipalityTable">
                                            <thead>
                                                <tr>
                                                    <th style="width:80px;">Logo</th>
                                                    <th> Team </th>
                                                    <th class="text-right" style="width: 140px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($municipalities)): ?>
                                                    <?php foreach ($municipalities as $row): ?>
                                                        <?php $city = isset($row->municipality) ? $row->municipality : ''; ?>
                                                        <?php $logo = isset($row->logo) ? $row->logo : ''; ?>
                                                        <tr>
                                                            <td class="align-middle">
                                                                <?php if (!empty($logo)): ?>
                                                                    <img src="<?= base_url('upload/team_logos/' . $logo); ?>" alt="<?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?> logo" class="team-logo">
                                                                <?php else: ?>
                                                                    <span class="text-muted">—</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td class="text-right">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-outline-secondary btn-sm btn-icon btn-edit-city"
                                                                    data-city="<?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Edit team">
                                                                    <i class="mdi mdi-pencil" aria-hidden="true"></i>
                                                                    <span class="sr-only">Edit team</span>
                                                                </button>
                                                                <form class="d-inline form-delete-municipality" action="<?= app_url('delete_municipality'); ?>" method="post">
                                                                    <input type="hidden" name="city" value="<?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?>">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-icon"
                                                                        title="Delete team" data-toggle="tooltip" data-placement="top">
                                                                        <i class="mdi mdi-delete-outline" aria-hidden="true"></i>
                                                                        <span class="sr-only">Delete team</span>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="2" class="text-center text-muted">No teams found.</td>
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

    <!-- Add Team Modal -->
    <div class="modal fade" id="addMunicipalityModal" tabindex="-1" role="dialog" aria-labelledby="addMunicipalityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMunicipalityModalLabel">Add Team</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open_multipart($appSlug . '/add_municipality'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label> Team </label>
                        <input type="text" name="city" class="form-control" required placeholder="e.g. Team Alpha">
                    </div>
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" name="logo" class="form-control-file" accept="image/*">
                        <small class="form-text text-muted">PNG/JPG/WebP up to 2MB.</small>
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

    <!-- Edit Team Modal -->
    <div class="modal fade" id="editMunicipalityModal" tabindex="-1" role="dialog" aria-labelledby="editMunicipalityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMunicipalityModalLabel">Edit Team</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open_multipart($appSlug . '/update_municipality'); ?>
                <div class="modal-body">
                    <input type="hidden" name="current_city" id="editCurrentCity">
                    <div class="form-group">
                        <label> Team </label>
                        <input type="text" name="city" id="editCityName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" name="logo" class="form-control-file" accept="image/*">
                        <small class="form-text text-muted">Leave empty to keep the current logo.</small>
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

            $('.btn-edit-city').on('click', function() {
                var city = $(this).data('city') || '';
                $('#editCurrentCity').val(city);
                $('#editCityName').val(city);
                $('#editMunicipalityModal').modal('show');
            });

            if ($.fn.DataTable) {
                $('#municipalityTable').DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    order: [
                        [0, 'asc']
                    ],
                    autoWidth: false,
                    columnDefs: [{
                        targets: -1,
                        orderable: false,
                        searchable: false
                    }]
                });
            }

            $('.form-delete-municipality').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                Swal.fire({
                    title: 'Delete this municipality?',
                    text: 'This removes every matching address row.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

</body>

</html>
