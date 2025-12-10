<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <!-- Normal container with padding -->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
                                <div class="mb-2">
                                    <h4 class="page-title mb-0">Account Settings – Profile</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Centered, narrower card -->
                    <div class="row mt-3 justify-content-center">
                        <div class="col-12 col-md-10 col-lg-7 col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Profile Details</h5>

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

                                    <?= form_open_multipart('Page/profile'); ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>First Name</label>
                                            <input type="text" name="fName" class="form-control"
                                                value="<?= set_value('fName', $user->fName ?? ''); ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Last Name</label>
                                            <input type="text" name="lName" class="form-control"
                                                value="<?= set_value('lName', $user->lName ?? ''); ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Middle Name</label>
                                            <input type="text" name="mName" class="form-control"
                                                value="<?= set_value('mName', $user->mName ?? ''); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>ID Number</label>
                                            <input type="text" name="IDNumber" class="form-control"
                                                value="<?= set_value('IDNumber', $user->IDNumber ?? ''); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="<?= set_value('email', $user->email ?? ''); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Position</label>
                                        <input type="text" name="position" class="form-control"
                                            value="<?= set_value('position', $user->position ?? ''); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Avatar</label>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('upload/profile/' . ($user->avatar ?? 'default.png')); ?>"
                                                alt="avatar"
                                                class="rounded-circle mr-3"
                                                width="60" height="60"
                                                onerror="this.src='<?= base_url('upload/profile/default.png'); ?>'">
                                            <input type="file" name="avatar" class="form-control-file" accept="image/*">
                                        </div>
                                        <small class="text-muted">JPG/PNG up to 2MB.</small>
                                    </div>

                                    <button type="submit" name="submit" value="1" class="btn btn-primary">
                                        Save Changes
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
</body>

</html>