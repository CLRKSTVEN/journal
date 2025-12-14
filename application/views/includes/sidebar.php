<style>
    /* Optional: if you really have no nested menus elsewhere,
       you can remove these overrides entirely. Leaving blank
       here so they don't interfere with MetisMenu. */
</style>

<div class="left-side-menu">
    <div class="slimscroll-menu">

        <?php
        $currentUri = trim(uri_string(), '/');
        $appSlug = app_slug();

        $isActive = function ($patterns) use ($currentUri) {
            foreach ((array)$patterns as $p) {
                $p = trim($p, '/');
                if ($p === '') {
                    continue;
                }
                if (stripos($currentUri, $p) === 0) {
                    return 'mm-active active';
                }
            }
            return '';
        };
        ?>

        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">

                <li class="menu-title"><?= htmlspecialchars(app_name(), ENT_QUOTES, 'UTF-8'); ?></li>

                <!-- Dashboard -->
                <li class="<?= $isActive(['Page/admin']); ?>">
                    <a href="<?= base_url('Page/admin'); ?>" class="waves-effect">
                        <i class="bi bi-house-door"></i>
                        <span>Dashboard </span>
                    </a>
                </li>

                <!-- Events -->
                <li class="<?= $isActive([$appSlug . '/events']); ?>">
                    <a href="<?= app_url('events'); ?>" class="waves-effect">
                        <i class="mdi mdi-calendar-multiple-check"></i>
                        <span> Events </span>
                    </a>
                </li>

                <!-- Teams -->
                <li class="<?= $isActive([$appSlug . '/teams']); ?>">
                    <a href="<?= app_url('teams'); ?>" class="waves-effect">
                        <i class="mdi mdi-city"></i>
                        <span> Teams </span>
                    </a>
                </li>

                <!-- Technical Officials -->
                <li class="<?= $isActive([$appSlug . '/technical']); ?>">
                    <a href="<?= app_url('technical'); ?>" class="waves-effect">
                        <i class="mdi mdi-account-tie"></i>
                        <span> Technical Officials </span>
                    </a>
                </li>

                <!-- Top 5 Winners (hidden from public) -->
                <li class="<?= $isActive([$appSlug . '/top5']); ?>">
                    <a href="<?= app_url('top5'); ?>" class="waves-effect">
                        <i class="mdi mdi-gift-outline"></i>
                        <span> Top 5 Winners </span>
                    </a>
                </li>

                <!-- Reports -->
                <li class="<?= $isActive([$appSlug . '/report']); ?>">
                    <a href="<?= app_url('report'); ?>" class="waves-effect">
                        <i class="mdi mdi-printer"></i>
                        <span> Generate Report </span>
                    </a>
                </li>

                <!-- Account Settings (submenu kept but simple) -->
                <?php
                $accountActive = $isActive([
                    'Page/change_password',
                    'Page/profile',
                    'Page/manage_users'
                ]);
                $accountExpanded = $accountActive ? 'true' : 'false';
                $accountShow     = $accountActive ? 'mm-show' : '';
                ?>
                <li class="<?= $accountActive; ?>">
                    <a href="javascript:void(0);" class="waves-effect" aria-expanded="<?= $accountExpanded; ?>">
                        <i class="ion ion-md-settings"></i>
                        <span> Account Settings </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level <?= $accountShow; ?>" aria-expanded="<?= $accountExpanded; ?>">
                        <li class="<?= $isActive('Page/change_password'); ?>">
                            <a href="<?= base_url('Page/change_password'); ?>">Change Password</a>
                        </li>
                        <li class="<?= $isActive('Page/profile'); ?>">
                            <a href="<?= base_url('Page/profile'); ?>">Change Profile</a>
                        </li>
                        <li class="<?= $isActive('Page/manage_users'); ?>">
                            <a href="<?= base_url('Page/manage_users'); ?>">Manage Users</a>
                        </li>
                    </ul>
                </li>

                <!-- Logout -->
                <li>
                    <a href="<?= base_url('Login/logout'); ?>" class="waves-effect logout-confirm">
                        <i class="bi bi-box-arrow-right"></i>
                        <span> Logout </span>
                    </a>
                </li>

            </ul>
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<!-- Logout confirmation only -->
<script>
    (function() {
        if (window.__logoutConfirmInitialized) {
            return;
        }
        window.__logoutConfirmInitialized = true;

        function handleLogoutClick(event) {
            event.preventDefault();
            var targetUrl = this.getAttribute('href');

            function proceed() {
                window.location.href = targetUrl;
            }

            if (window.Swal && typeof window.Swal.fire === 'function') {
                window.Swal.fire({
                    title: 'Log out?',
                    text: 'You will be logged out of your account.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, log out',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#348cd4',
                    cancelButtonColor: '#6c757d'
                }).then(function(result) {
                    var confirmed = false;
                    if (result) {
                        if (typeof result.isConfirmed !== 'undefined') {
                            confirmed = result.isConfirmed;
                        } else if (typeof result.value !== 'undefined') {
                            confirmed = !!result.value;
                        } else if (result === true) {
                            confirmed = true;
                        }
                    }
                    if (confirmed) {
                        proceed();
                    }
                });
            } else if (window.confirm('Are you sure you want to log out?')) {
                proceed();
            }
        }

        function bindLogoutConfirm() {
            var links = document.querySelectorAll('.logout-confirm');
            if (!links.length) return;

            Array.prototype.forEach.call(links, function(link) {
                if (link.__logoutConfirmBound) return;
                link.__logoutConfirmBound = true;
                link.addEventListener('click', handleLogoutClick);
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bindLogoutConfirm);
        } else {
            bindLogoutConfirm();
        }
    })();
</script>
