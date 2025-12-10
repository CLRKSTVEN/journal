<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>
    <style>
        .toggle-eye {
            position: absolute;
            top: 33px;
            right: 12px;
            cursor: pointer;
            color: #6c757d;
        }

        .toggle-eye i {
            font-size: 20px;
        }
    </style>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <!-- Normal container with padding -->
                <div class="container-fluid">

                    <!-- Title block -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
                                <div class="mb-2">
                                    <h4 class="page-title mb-0">Account Settings – Change Password</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Centered, smaller card -->
                    <div class="row mt-3 justify-content-center">
                        <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Change Password</h5>

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

                                    <?= validation_errors(
                                        '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>',
                                        '</div>'
                                    ); ?>

                                    <?= form_open('Page/change_password'); ?>

                                    <div class="form-group position-relative">
                                        <label>Current Password</label>
                                        <input type="password" id="current_password" name="current_password" class="form-control" required autocomplete="current-password">

                                        <span class="toggle-eye" onclick="togglePassword('current_password', this)">
                                            <i class="mdi mdi-eye-off"></i>
                                        </span>
                                    </div>

                                    <div class="form-group position-relative">
                                        <label>New Password</label>
                                        <input type="password" id="new_password" name="new_password" class="form-control" required autocomplete="new-password">

                                        <span class="toggle-eye" onclick="togglePassword('new_password', this)">
                                            <i class="mdi mdi-eye-off"></i>
                                        </span>
                                    </div>

                                    <div class="form-group position-relative">
                                        <label>Confirm New Password</label>
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required autocomplete="new-password">

                                        <span class="toggle-eye" onclick="togglePassword('confirm_password', this)">
                                            <i class="mdi mdi-eye-off"></i>
                                        </span>
                                    </div>

                                    <button type="submit" name="submit" value="1" class="btn btn-primary">
                                        Update Password
                                    </button>

                                    <?= form_close(); ?>

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
    <script>
        function togglePassword(fieldId, iconElement) {
            const input = document.getElementById(fieldId);
            const icon = iconElement.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("mdi-eye-off");
                icon.classList.add("mdi-eye");
            } else {
                input.type = "password";
                icon.classList.remove("mdi-eye");
                icon.classList.add("mdi-eye-off");
            }
        }
    </script>

</body>

</html>