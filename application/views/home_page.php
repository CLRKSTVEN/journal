<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    body {
        background: linear-gradient(to bottom right, #EEF2FF 0%, #E0E7FF 50%, #FEF3C7 100%);
        color: #1f2937;
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    body::before,
    body::after {
        content: '';
        position: fixed;
        border-radius: 50%;
        opacity: 0.35;
        z-index: 0;
        filter: blur(2px);
    }

    body::before {
        width: 420px;
        height: 420px;
        background: radial-gradient(circle, #6366F1 0%, transparent 70%);
        top: -140px;
        right: -180px;
    }

    body::after {
        width: 360px;
        height: 360px;
        background: radial-gradient(circle, #F59E0B 0%, transparent 70%);
        bottom: -120px;
        left: -160px;
    }

    .login-page-wrapper {
        position: relative;
        z-index: 1;
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 32px 16px;
    }

    .login-card {
        width: 100%;
        max-width: 480px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 18px 46px rgba(99, 102, 241, 0.14);
        padding: 28px 26px 26px;
    }

    .login-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 999px;
        background: #EEF2FF;
        color: #4f46e5;
        font-weight: 700;
        font-size: 0.85rem;
        border: 1px solid #e0e7ff;
    }

    .login-header {
        text-align: center;
        margin: 14px 0 10px;
    }

    .login-header h3 {
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-bottom: 6px;
        color: #111827;
    }

    .login-header small {
        color: #6b7280;
    }

    .form-floating-label {
        position: relative;
        margin-bottom: 1rem;
    }

    .form-floating-label input {
        padding: 0.85rem 2.6rem 0.45rem 2.5rem;
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
        transition: all 0.15s ease;
        font-weight: 500;
    }

    .form-floating-label input:focus {
        border-color: #6366F1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    }

    .form-floating-label label {
        position: absolute;
        left: 2.6rem;
        top: 50%;
        transform: translateY(-50%);
        margin: 0;
        font-size: 0.85rem;
        color: #9ca3af;
        pointer-events: none;
        transition: all 0.15s ease;
        background: #fff;
        padding: 0 6px;
    }

    .form-floating-label input:focus+label,
    .form-floating-label input:not(:placeholder-shown)+label {
        top: -1px;
        font-size: 0.75rem;
        color: #4f46e5;
    }

    .input-icon {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1.05rem;
    }

    .toggle-password {
        position: absolute;
        right: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #9ca3af;
        font-size: 1.15rem;
    }

    .login-footer-text {
        font-size: 0.85rem;
        margin-top: 1rem;
        text-align: center;
        color: #6b7280;
    }

    .login-footer-text a {
        font-weight: 700;
        color: #4f46e5;
    }

    .alert {
        font-size: 0.85rem;
    }

    .meta-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        margin-bottom: 10px;
    }

    .meta-links a {
        color: #4b5563;
        font-weight: 600;
    }

    .meta-links a:hover {
        color: #4f46e5;
        text-decoration: none;
    }
</style>

<body>

    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-ball"></div>
        </div>
    </div>
    <!-- Loader ends-->

    <section class="login-page-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="login-card">
                        <span class="login-pill"><i class="mdi mdi-shield-account-outline"></i> Admin Access</span>
                        <div class="login-header">
                            <h3><?= htmlspecialchars(app_name(), ENT_QUOTES, 'UTF-8'); ?> Console</h3>
                            <small><?= htmlspecialchars(app_tagline(), ENT_QUOTES, 'UTF-8'); ?></small>
                        </div>

                        <!-- Flash messages -->
                        <?php if ($this->session->flashdata('message')): ?>
                            <div class="alert alert-info alert-dismissible fade show mt-2" role="alert">
                                <?= $this->session->flashdata('message'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                <?= $this->session->flashdata('success'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('danger')): ?>
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                <?= $this->session->flashdata('danger'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <div class="meta-links">
                            <a href="<?= app_url('standings'); ?>"><i class="mdi mdi-arrow-left"></i> Back to rankings</a>
                            <a href="<?= site_url(); ?>">Home</a>
                        </div>

                        <!-- Login form -->
                        <form action="<?= site_url('Login/auth'); ?>" method="post" class="mt-3">

                            <!-- Username -->
                            <div class="form-floating-label">
                                <span class="input-icon">
                                    <i class="mdi mdi-email-outline"></i>
                                </span>
                                <input
                                    type="text"
                                    name="username"
                                    class="form-control"
                                    required
                                    autocomplete="username"
                                    placeholder=" ">
                                <label>Email / Username</label>
                            </div>

                            <!-- Password -->
                            <div class="form-floating-label">
                                <span class="input-icon">
                                    <i class="mdi mdi-lock-outline"></i>
                                </span>
                                <input
                                    type="password"
                                    id="loginPassword"
                                    name="password"
                                    class="form-control"
                                    required
                                    autocomplete="current-password"
                                    placeholder=" ">
                                <label>Password</label>
                                <span class="toggle-password" data-target="#loginPassword">
                                    <i class="mdi mdi-eye-outline"></i>
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rememberMe">
                                    <label class="custom-control-label text-muted" for="rememberMe">Remember me</label>
                                </div>
                                <a class="link" href="<?= site_url('login/forgot'); ?>">Forgot Password?</a>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block" style="background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); border: none; box-shadow: 0 10px 24px rgba(99, 102, 241, 0.35);">
                                Sign in
                            </button>

                        </form>

                        <div class="login-footer-text">
                            Access is limited to authorized meet officials. Contact the Administrator if you need an account.
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JS -->
    <script src="<?= base_url(); ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/icons/feather-icon/feather-icon.js"></script>
    <script src="<?= base_url(); ?>assets/js/config.js"></script>
    <script src="<?= base_url(); ?>assets/js/script.js"></script>

    <script>
        // Show / hide password
        $(document).on('click', '.toggle-password', function() {
            var targetSelector = $(this).data('target');
            var $input = $(targetSelector);
            var $icon = $(this).find('i');

            if ($input.attr('type') === 'password') {
                $input.attr('type', 'text');
                $icon.removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
            } else {
                $input.attr('type', 'password');
                $icon.removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
            }
        });
    </script>

</body>

</html>
