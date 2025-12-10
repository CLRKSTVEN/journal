<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    .field-error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.1rem rgba(220, 53, 69, 0.12);
    }
</style>

<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
                                <div class="mb-2">
                                    <h4 class="page-title mb-0">Account Settings – Manage Users</h4>
                                </div>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal">
                                    <i class="mdi mdi-account-plus-outline"></i> Add User
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php if ($this->session->flashdata('success')): ?>
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <?= $this->session->flashdata('success'); ?>
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($this->session->flashdata('danger')): ?>
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <?= $this->session->flashdata('danger'); ?>
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        </div>
                                    <?php endif; ?>
                                    <?= validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>'); ?>

                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Username</th>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Status</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($users)): ?>
                                                    <?php foreach ($users as $u): ?>
                                                        <?php
                                                        $fullName = trim(($u->fName ?? '') . ' ' . ($u->mName ?? '') . ' ' . ($u->lName ?? ''));
                                                        $isActive = isset($u->is_active) ? (int)$u->is_active === 1 : 1;
                                                        ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($u->username, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($fullName ?: '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($u->position ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td>
                                                                <?php if (!empty($has_status)): ?>
                                                                    <?php if ($isActive): ?>
                                                                        <span class="badge badge-success">Active</span>
                                                                    <?php else: ?>
                                                                        <span class="badge badge-secondary">Inactive</span>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <span class="badge badge-light text-muted">N/A</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <div class="btn-group btn-group-sm" role="group">
                                                                    <button type="button" class="btn btn-outline-secondary reset-btn"
                                                                        data-user-id="<?= $u->userID; ?>"
                                                                        data-username="<?= htmlspecialchars($u->username, ENT_QUOTES, 'UTF-8'); ?>"
                                                                        data-toggle="modal" data-target="#resetModal"
                                                                        data-tooltip="true" data-placement="top"
                                                                        title="Reset password">
                                                                        <i class="mdi mdi-lock-reset"></i>
                                                                    </button>
                                                                    <form action="<?= site_url('Page/manage_users'); ?>" method="post" class="d-inline">
                                                                        <input type="hidden" name="action" value="toggle">
                                                                        <input type="hidden" name="user_id" value="<?= $u->userID; ?>">
                                                                        <input type="hidden" name="active" value="<?= $isActive ? 0 : 1; ?>">
                                                                        <button type="submit"
                                                                            class="btn btn-outline-<?= $isActive ? 'secondary' : 'success'; ?>"
                                                                            <?= empty($has_status) ? 'disabled title="Add is_active column to enable toggling"' : ''; ?>
                                                                            data-tooltip="true" data-placement="top"
                                                                            title="<?= $isActive ? 'Deactivate user' : 'Activate user'; ?>">
                                                                            <i class="mdi mdi-toggle-switch<?= $isActive ? '' : '-off'; ?>"></i>
                                                                        </button>
                                                                    </form>
                                                                    <?php if ($this->session->userdata('userID') != $u->userID): ?>
                                                                        <button type="button" class="btn btn-outline-danger delete-btn"
                                                                            data-user-id="<?= $u->userID; ?>"
                                                                            data-username="<?= htmlspecialchars($u->username, ENT_QUOTES, 'UTF-8'); ?>"
                                                                            data-toggle="modal" data-target="#deleteModal"
                                                                            data-tooltip="true" data-placement="top"
                                                                            title="Delete user">
                                                                            <i class="mdi mdi-delete-outline"></i>
                                                                        </button>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="<?= !empty($has_status) ? '5' : '4'; ?>" class="text-center text-muted">No users found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add User Modal -->
                    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUserModalLabel"><i class="mdi mdi-account-plus-outline"></i> Add User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?= form_open_multipart('Page/manage_users'); ?>
                                <input type="hidden" name="action" value="add">
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Username</label>
                                            <input type="text" name="username" id="addUsername" class="form-control" value="<?= set_value('username'); ?>" required autocomplete="off">
                                            <small id="usernameStatus" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Email</label>
                                            <input type="email" name="email" id="addEmail" class="form-control" value="<?= set_value('email'); ?>" autocomplete="off">
                                            <small id="emailStatus" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="addPassword" class="form-control" required autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-pass" type="button" data-target="#addPassword">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small id="passwordStatus" class="form-text text-muted">Minimum 8 characters.</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" name="confirm_password" id="addPasswordConfirm" class="form-control" required autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-pass" type="button" data-target="#addPasswordConfirm">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small id="confirmStatus" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>First Name</label>
                                            <input type="text" name="fName" class="form-control" value="<?= set_value('fName'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Middle Name</label>
                                            <input type="text" name="mName" class="form-control" value="<?= set_value('mName'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Last Name</label>
                                            <input type="text" name="lName" class="form-control" value="<?= set_value('lName'); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Position</label>
                                            <select name="position" class="form-control">
                                                <option value="Administrator" <?= set_select('position', 'Administrator', TRUE); ?>>Administrator</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>ID Number</label>
                                            <input type="text" name="IDNumber" id="addIDNumber" class="form-control" value="<?= set_value('IDNumber'); ?>" autocomplete="off">
                                            <small id="idNumberStatus" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Avatar</label>
                                            <input type="file" name="avatar" class="form-control-file" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="addUserSubmit">Create User</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Reset Password Modal -->
                    <div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="resetModalLabel"><i class="mdi mdi-lock-reset"></i> Reset Password</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?= form_open('Page/manage_users'); ?>
                                <input type="hidden" name="action" value="reset">
                                <input type="hidden" name="user_id" id="resetUserId">
                                <div class="modal-body">
                                    <p class="mb-1">Reset password for <strong id="resetUsername"></strong>?</p>
                                    <small class="text-muted">A random secure password will be generated and shown after reset.</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Confirm Reset</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Delete User Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel"><i class="mdi mdi-delete-outline"></i> Delete User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?= form_open('Page/manage_users'); ?>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="user_id" id="deleteUserId">
                                <div class="modal-body">
                                    <p class="mb-1">Delete user <strong id="deleteUsername"></strong>?</p>
                                    <small class="text-muted">This action cannot be undone.</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/footer_plugins.php'); ?>

    <script>
        (function() {
            $('.reset-btn').on('click', function() {
                $('#resetUserId').val($(this).data('user-id'));
                $('#resetUsername').text($(this).data('username'));
            });

            $('.delete-btn').on('click', function() {
                $('#deleteUserId').val($(this).data('user-id'));
                $('#deleteUsername').text($(this).data('username'));
            });

            <?php if (!empty($open_modal)): ?>
                $('#<?= $open_modal; ?>').modal('show');
            <?php endif; ?>

            $('[data-tooltip="true"]').tooltip();

            // Form validation helpers
            var usernameTimer, emailTimer, idTimer;
            var usernameOk = false;
            var emailOk = true; // optional
            var passwordOk = false;
            var idOk = true; // optional field

            function updateSubmitState() {
                $('#addUserSubmit').prop('disabled', !(usernameOk && emailOk && passwordOk && idOk));
            }

            // Live username availability check
            $('#addUsername').on('input', function() {
                clearTimeout(usernameTimer);
                var username = $(this).val().trim();
                var $status = $('#usernameStatus');
                var $input = $('#addUsername');
                usernameOk = false;
                updateSubmitState();

                if (!username.length) {
                    $status.text('');
                    $input.removeClass('field-error');
                    return;
                }

                $status.text('Checking availability...');
                $status.removeClass('text-danger text-success').addClass('text-muted');
                $input.removeClass('field-error');

                usernameTimer = setTimeout(function() {
                    $.get('<?= site_url('Page/check_username'); ?>', {
                        username: username
                    }, function(res) {
                        var data;
                        try {
                            data = typeof res === 'string' ? JSON.parse(res) : res;
                        } catch (e) {
                            data = {};
                        }
                        if (data.exists) {
                            $status.text('Username already exists.').removeClass('text-muted text-success').addClass('text-danger');
                            $input.addClass('field-error');
                            usernameOk = false;
                        } else {
                            $status.text('Username is available.').removeClass('text-muted text-danger').addClass('text-success');
                            $input.removeClass('field-error');
                            usernameOk = true;
                        }
                        updateSubmitState();
                    }).fail(function() {
                        $status.text('Could not verify username right now.').removeClass('text-muted text-success').addClass('text-danger');
                        $input.addClass('field-error');
                        usernameOk = false;
                        updateSubmitState();
                    });
                }, 250);
            });

            // Live email availability check (optional)
            $('#addEmail').on('input', function() {
                clearTimeout(emailTimer);
                var email = $(this).val().trim();
                var $status = $('#emailStatus');
                var $input = $('#addEmail');
                emailOk = true; // default if empty

                if (!email.length) {
                    $status.text('');
                    $input.removeClass('field-error');
                    updateSubmitState();
                    return;
                }

                $status.text('Checking email...');
                $status.removeClass('text-danger text-success').addClass('text-muted');
                $input.removeClass('field-error');
                emailOk = false;
                updateSubmitState();

                emailTimer = setTimeout(function() {
                    $.get('<?= site_url('Page/check_email'); ?>', {
                        email: email
                    }, function(res) {
                        var data;
                        try {
                            data = typeof res === 'string' ? JSON.parse(res) : res;
                        } catch (e) {
                            data = {};
                        }
                        if (data.exists) {
                            $status.text('Email already exists.').removeClass('text-muted text-success').addClass('text-danger');
                            $input.addClass('field-error');
                            emailOk = false;
                        } else {
                            $status.text('Email is available.').removeClass('text-muted text-danger').addClass('text-success');
                            $input.removeClass('field-error');
                            emailOk = true;
                        }
                        updateSubmitState();
                    }).fail(function() {
                        $status.text('Could not verify email right now.').removeClass('text-muted text-success').addClass('text-danger');
                        $input.addClass('field-error');
                        emailOk = false;
                        updateSubmitState();
                    });
                }, 250);
            });

            function validatePasswordFields() {
                var pw = $('#addPassword').val();
                var pwc = $('#addPasswordConfirm').val();
                var $pwStatus = $('#passwordStatus');
                var $pwcStatus = $('#confirmStatus');
                passwordOk = false;

                if (pw.length < 8) {
                    $pwStatus.text('Minimum 8 characters.').removeClass('text-success').addClass('text-danger');
                    $('#addPassword, #addPasswordConfirm').addClass('field-error');
                    $pwcStatus.text('');
                    updateSubmitState();
                    return;
                } else {
                    $pwStatus.text('Password length OK.').removeClass('text-danger').addClass('text-success');
                    $('#addPassword').removeClass('field-error');
                }

                if (pwc.length && pw !== pwc) {
                    $pwcStatus.text('Passwords do not match.').removeClass('text-success').addClass('text-danger');
                    $('#addPasswordConfirm').addClass('field-error');
                    updateSubmitState();
                    return;
                } else if (pwc.length) {
                    $pwcStatus.text('Passwords match.').removeClass('text-danger').addClass('text-success');
                    $('#addPasswordConfirm').removeClass('field-error');
                } else {
                    $pwcStatus.text('');
                    $('#addPasswordConfirm').removeClass('field-error');
                }

                passwordOk = true;
                updateSubmitState();
            }

            $('#addPassword, #addPasswordConfirm').on('input', validatePasswordFields);

            // Toggle password visibility
            $('.toggle-pass').on('click', function() {
                var target = $(this).data('target');
                var $input = $(target);
                var $icon = $(this).find('i');
                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
                }
            });

            // Initial state
            validatePasswordFields();
            updateSubmitState();

            // Live ID number availability (optional field)
            $('#addIDNumber').on('input', function() {
                clearTimeout(idTimer);
                var idNumber = $(this).val().trim();
                var $status = $('#idNumberStatus');
                var $input = $('#addIDNumber');
                idOk = true; // default if empty

                if (!idNumber.length) {
                    $status.text('');
                    $input.removeClass('field-error');
                    updateSubmitState();
                    return;
                }

                $status.text('Checking ID Number...');
                $status.removeClass('text-danger text-success').addClass('text-muted');
                $input.removeClass('field-error');
                idOk = false;
                updateSubmitState();

                idTimer = setTimeout(function() {
                    $.get('<?= site_url('Page/check_idnumber'); ?>', {
                        idNumber: idNumber
                    }, function(res) {
                        var data;
                        try {
                            data = typeof res === 'string' ? JSON.parse(res) : res;
                        } catch (e) {
                            data = {};
                        }
                        if (data.exists) {
                            $status.text('ID Number already exists.').removeClass('text-muted text-success').addClass('text-danger');
                            $input.addClass('field-error');
                            idOk = false;
                        } else {
                            $status.text('ID Number is available.').removeClass('text-muted text-danger').addClass('text-success');
                            $input.removeClass('field-error');
                            idOk = true;
                        }
                        updateSubmitState();
                    }).fail(function() {
                        $status.text('Could not verify ID Number right now.').removeClass('text-muted text-success').addClass('text-danger');
                        $input.addClass('field-error');
                        idOk = false;
                        updateSubmitState();
                    });
                }, 250);
            });
        })();
    </script>
</body>

</html>