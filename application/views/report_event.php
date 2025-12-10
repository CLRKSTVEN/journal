<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
    body {
        font-family: var(--app-font, 'Segoe UI', Arial, sans-serif);
        background: #f8fafc;
    }

    .content-page {
        background: #f8fafc;
    }

    .page-title-box h4 {
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .report-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.04);
    }

    .report-header {
        text-align: center;
        margin-bottom: 16px;
    }

    .report-header img {
        height: 70px;
        margin-bottom: 8px;
    }

    .report-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
    }

    .report-header h4 {
        margin: 4px 0;
        font-size: 20px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .report-header .meta {
        font-size: 13px;
        color: #374151;
        margin-top: 4px;
    }

    .event-title {
        font-size: 16px;
        font-weight: 700;
        margin: 18px 0 8px;
        text-align: center;
    }

    .table-report {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }

    .table-report th,
    .table-report td {
        border: 1px solid #e5e7eb;
        padding: 10px 12px;
        font-size: 13px;
    }

    .table-report th {
        background: #f9fafb;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .sign-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 24px;
        font-size: 14px;
    }

    .sign-slot {
        flex: 1;
        border-top: 1px solid #111827;
        padding-top: 8px;
        text-align: center;
        font-weight: 600;
    }

    .filter-form {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .filter-form select {
        min-width: 260px;
    }

    .btn-print {
        margin-left: auto;
    }

    @media print {
        body {
            background: #ffffff;
        }

        .left-side-menu,
        .topnav,
        .page-title-box,
        .filter-form,
        .btn-print,
        .btn-back {
            display: none !important;
        }

        .content-page {
            margin-left: 0 !important;
        }

        .report-card {
            box-shadow: none;
            border: none;
            margin: 0;
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
                    <div class="page-title-box">
                        <div class="page-title-right">

                        </div>
                        <h4 class="page-title">Generate Report</h4>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <form method="get" action="<?= site_url('provincial/report'); ?>" class="filter-form">
                                <div class="form-group mb-0">
                                    <label class="mr-2 mb-0 text-muted small">Event</label>
                                    <?php
                                    $events_list = is_array($events) ? $events : array();
                                    if (!empty($events_list)) {
                                        // Keep only events that actually have winners
                                        $events_list = array_filter($events_list, function($ev) {
                                            return isset($ev->winners_count) && (int)$ev->winners_count > 0;
                                        });
                                        usort($events_list, function ($a, $b) {
                                            return strcasecmp($a->event_name ?? '', $b->event_name ?? '');
                                        });
                                    }
                                    $uniqueEvents = array();
                                    $seen = array();
                                    foreach ($events_list as $ev) {
                                        // Deduplicate by name + group + category so distinct categories remain selectable
                                        $keyParts = array(
                                            strtolower(trim($ev->event_name ?? '')),
                                            strtolower(trim($ev->group_name ?? '')),
                                            strtolower(trim($ev->category_name ?? ''))
                                        );
                                        $key = implode('|', $keyParts);
                                        if (isset($seen[$key])) {
                                            continue;
                                        }
                                        $seen[$key] = true;
                                        $uniqueEvents[] = $ev;
                                    }
                                    ?>
                                    <select name="event_id" class="form-control" id="eventSelect">
                                        <option value="">Select event</option>
                                        <?php foreach ($uniqueEvents as $ev): ?>
                                            <?php $wcount = isset($ev->winners_count) ? (int) $ev->winners_count : 0; ?>
                                            <option value="<?= (int)$ev->event_id; ?>"
                                                data-winners="<?= $wcount; ?>"
                                                <?= ($selected_id === (int)$ev->event_id) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($ev->event_name . ' (' . ($ev->group_name ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                                <?= $wcount > 0 ? ' — ' . $wcount . ' winner' . ($wcount > 1 ? 's' : '') : ''; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Load</button>
                                <button type="button" class="btn btn-outline-secondary btn-back" onclick="window.history.back();">Back</button>
                                <?php if ($selected_event): ?>
                                    <button type="button" class="btn btn-success ml-auto btn-print" onclick="window.print();">
                                        <i class="mdi mdi-printer"></i> Print
                                    </button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <?php if ($selected_event): ?>
                        <div class="report-card">
                            <div class="report-header">
                                <img src="<?= base_url('assets/images/DepEd_logo.png'); ?>" alt="Logo" onerror="this.style.display='none';">
                                <h3>Republic of the Philippines</h3>
                                <h4>Department of Education</h4>
                                <div class="meta">
                                    REGION XI • SCHOOLS DIVISION OF DAVAO ORIENTAL<br>
                                    Government Center, Dahican, City of Mati, Davao Oriental
                                </div>
                            </div>

                            <div class="event-title">
                                Event: <?= htmlspecialchars($selected_event->event_name ?? '—', ENT_QUOTES, 'UTF-8'); ?>
                                <?php if (!empty($selected_event->group_name)): ?>
                                    <div class="text-muted small"><?= htmlspecialchars($selected_event->group_name, ENT_QUOTES, 'UTF-8'); ?></div>
                                <?php endif; ?>
                            </div>

                            <table class="table-report">
                                <thead>
                                    <tr>
                                        <th style="width:70px;">Rank</th>
                                        <th>Name of Athlete/Team</th>
                                        <th>Municipality</th>
                                        <th>School</th>
                                        <th>Coach</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($winners)): ?>
                                        <?php
                                        $rank = 1;
                                        foreach ($winners as $w):
                                            $fullName = !empty($w->full_name)
                                                ? $w->full_name
                                                : trim(($w->first_name ?? '') . ' ' . ($w->middle_name ?? '') . ' ' . ($w->last_name ?? ''));
                                        ?>
                                            <tr>
                                                <td style="text-align:center;"><?= $rank++; ?></td>
                                                <td><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?= htmlspecialchars($w->municipality ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?= htmlspecialchars($w->school ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?= htmlspecialchars($w->coach ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" style="text-align:center;">No winners encoded for this event yet.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <?php
                            $tournamentMgrs = array_filter($technical ?? array(), function ($t) {
                                return $t->role === 'Tournament Manager';
                            });
                            $techOfficials  = array_filter($technical ?? array(), function ($t) {
                                return $t->role === 'Technical Official';
                            });
                            ?>

                            <div class="sign-row">
                                <div class="sign-slot">
                                    Tournament Manager:<br>
                                    <?= !empty($tournamentMgrs) ? htmlspecialchars(reset($tournamentMgrs)->name, ENT_QUOTES, 'UTF-8') : '________________________'; ?>
                                </div>
                                <div class="sign-slot">
                                    Technical Officials:<br>
                                    <?php
                                    if (!empty($techOfficials)) {
                                        $names = array_map(function ($t) {
                                            return $t->name;
                                        }, $techOfficials);
                                        echo htmlspecialchars(implode(', ', $names), ENT_QUOTES, 'UTF-8');
                                    } else {
                                        echo '________________________';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card">
                            <div class="card-body text-center text-muted">
                                Select an event to generate the report.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/footer_plugins.php'); ?>
    <script>
        (function(){
            var select = document.getElementById('eventSelect');
            var form = select ? select.closest('form') : null;
            if (select && form) {
                select.addEventListener('change', function() {
                    if (this.value) {
                        form.submit();
                    }
                });
            }
        })();
    </script>
</body>

</html>
