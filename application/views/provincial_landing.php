<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/design.css'); ?>">


<body>

    <!-- Loader -->
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

    <section class="landing-page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 landing-card">
                    <div class="landing-card-inner">

                        <!-- Header Banner -->
                        <div class="landing-header banner-hero">
                            <?php
                            $appName    = app_name();
                            $meet_title = isset($meet->meet_title) ? $meet->meet_title : $appName;
                            $meet_year  = isset($meet->meet_year)  ? $meet->meet_year  : '';
                            $activeMunicipalityHeader = isset($active_municipality) ? trim((string) $active_municipality) : '';
                            $activeMunicipalityFilter = $activeMunicipalityHeader;
                            $group = isset($active_group) ? $active_group : 'ALL';
                            $baseLandingUrl = app_url();
                            $paraLandingUrl = app_url('para');
                            $makeGroupUrl = function ($targetGroup) use ($activeMunicipalityFilter, $baseLandingUrl, $paraLandingUrl) {
                                $params = array();
                                if ($activeMunicipalityFilter !== '') {
                                    $params[] = 'municipality=' . urlencode($activeMunicipalityFilter);
                                }
                                $base = $baseLandingUrl;
                                if ($targetGroup === 'Elementary' || $targetGroup === 'Secondary') {
                                    $params[] = 'group=' . urlencode($targetGroup);
                                } elseif ($targetGroup === 'PARA') {
                                    $base = $paraLandingUrl;
                                }
                                $query = empty($params) ? '' : '?' . implode('&', $params);
                                return $base . $query;
                            };
                            $isLoggedIn = isset($this) && isset($this->session) ? (bool)$this->session->userdata('logged_in') : false;
                            $loginUrl   = $isLoggedIn ? app_url('admin') : site_url('login');
                            $loginText  = $isLoggedIn ? 'Admin Dashboard' : 'Login';

                            // Placement helpers to map medal values to 1st–5th labels
                            $placementLabel = function ($medal) {
                                $m = strtolower(trim((string) $medal));
                                if ($m === 'gold' || $m === '1st' || $m === 'first') return '1st';
                                if ($m === 'silver' || $m === '2nd' || $m === 'second') return '2nd';
                                if ($m === 'bronze' || $m === '3rd' || $m === 'third') return '3rd';
                                if ($m === '4th' || $m === 'fourth') return '4th';
                                if ($m === '5th' || $m === 'fifth') return '5th';
                                return ucfirst($medal);
                            };
                            $placementKey = function ($medal) use ($placementLabel) {
                                $label = $placementLabel($medal);
                                if ($label === '1st') return 'first';
                                if ($label === '2nd') return 'second';
                                if ($label === '3rd') return 'third';
                                if ($label === '4th') return 'fourth';
                                if ($label === '5th') return 'fifth';
                                return 'other';
                            };
                            $placementOrder = array('first', 'second', 'third', 'fourth', 'fifth');

                            $getCount = function ($stats, $fields) {
                                $sum = 0;
                                foreach ($fields as $f) {
                                    if (isset($stats->$f)) {
                                        $sum += (int) $stats->$f;
                                    }
                                }
                                return $sum;
                            };
                            ?>
                            <?php if ($activeMunicipalityHeader === ''): ?>
                                <img src="<?= base_url('upload/banners/journal.jpg'); ?>" alt="<?= htmlspecialchars($meet_title . ' banner', ENT_QUOTES, 'UTF-8'); ?>" class="banner-image">
                            <?php else: ?>
                                <div class="landing-title">
                                    <h4>Official Result Board</h4>
                                    <h2 style="margin-bottom:4px;"><?= htmlspecialchars($activeMunicipalityHeader, ENT_QUOTES, 'UTF-8'); ?></h2>
                                    <small>Viewing team details and standings. Use the tabs below to switch groups.</small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Group/login controls -->
                        <div class="group-bar">
                            <div class="group-pills">
                                <a href="<?= $makeGroupUrl('ALL'); ?>"
                                    class="btn btn-sm <?= $group === 'ALL' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                    Overall
                                </a>
                                <a href="<?= $makeGroupUrl('Elementary'); ?>"
                                    class="btn btn-sm <?= $group === 'Elementary' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                    Elementary
                                </a>
                                <a href="<?= $makeGroupUrl('Secondary'); ?>"
                                    class="btn btn-sm <?= $group === 'Secondary' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                    Secondary
                                </a>
                                <!-- <a href="<?= $makeGroupUrl('PARA'); ?>"
                                    class="btn btn-sm <?= $group === 'PARA' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                    PARAGAMES
                                </a> -->
                            </div>
                            <a href="<?= $loginUrl; ?>" class="login-btn" title="Admin">
                                <?= $loginText; ?>
                            </a>
                        </div>

                        <!-- Summary row -->
                        <?php
                        $overview       = isset($overview) ? $overview : null;
                        $activeMunicipality = isset($active_municipality) ? $active_municipality : '';
                        $teamsTotal     = isset($municipalities_all) && is_array($municipalities_all) ? count($municipalities_all) : 0;
                        $municipalities = $teamsTotal;
                        $events         = $overview ? (int)$overview->events : 0;
                        $firstTotal     = $overview ? $getCount($overview, array('first', 'gold')) : 0;
                        $secondTotal    = $overview ? $getCount($overview, array('second', 'silver')) : 0;
                        $thirdTotal     = $overview ? $getCount($overview, array('third', 'bronze')) : 0;
                        $fourthTotal    = $overview ? $getCount($overview, array('fourth')) : 0;
                        $fifthTotal     = $overview ? $getCount($overview, array('fifth')) : 0;
                        $totalMedals    = $overview ? (int)$overview->total_medals : ($firstTotal + $secondTotal + $thirdTotal + $fourthTotal + $fifthTotal);
                        // Assume last_update is stored in UTC in the DB
                        if ($overview && !empty($overview->last_update)) {
                            try {
                                $dt = new DateTime($overview->last_update, new DateTimeZone('UTC')); // source timezone
                                $dt->setTimezone(new DateTimeZone('Asia/Manila'));
                                // No timezone text, include seconds
                                $lastUpdate = $dt->format('M d, Y h:i:s A');
                                // Example: "Dec 08, 2025 02:48:05 AM"

                            } catch (Exception $e) {
                                // Fallback: show raw value if something goes wrong
                                $lastUpdate = $overview->last_update;
                            }
                        } else {
                            $lastUpdate = 'No data yet';
                        }


                        $tally = isset($municipality_tally) ? $municipality_tally : array();
                        $allMunicipalities = isset($municipalities_all) ? $municipalities_all : array();
                        $logoMap = isset($municipality_logos) ? $municipality_logos : array();

                        $normalizeName = function ($name) {
                            return strtolower(trim((string) $name));
                        };
                        $tallyMap = array();
                        foreach ($tally as $row) {
                            $key = $normalizeName(isset($row->municipality) ? $row->municipality : '');
                            if ($key === '') continue;
                            $tallyMap[$key] = $row;
                        }

                        // Prepare medal-sorted winners and event summaries (used by panels)
                        $winnersSorted = $winners ?? array();
                        if (!empty($winnersSorted) && is_array($winnersSorted)) {
                            usort($winnersSorted, function ($a, $b) {
                                $weight = ['Gold' => 3, 'Silver' => 2, 'Bronze' => 1];
                                $medalDiff = ($weight[$b->medal] ?? 0) - ($weight[$a->medal] ?? 0);
                                if ($medalDiff !== 0) return $medalDiff;
                                $eventDiff = strcasecmp($a->event_name ?? '', $b->event_name ?? '');
                                if ($eventDiff !== 0) return $eventDiff;
                                return strcasecmp($a->municipality ?? '', $b->municipality ?? '');
                            });
                        }
                        $isParaGroup = (isset($group) && strtoupper($group) === 'PARA');

                        $eventSummaries = array();
                        foreach ($winnersSorted as $w) {
                            $eventId = $w->event_id ?? null;
                            $placeKey = $placementKey($w->medal ?? '');

                            // ✅ Same grouping logic for ALL groups (including PARAGAMES):
                            // one summary per Event + Group + Category
                            $key = $eventId !== null
                                ? 'id-' . $eventId
                                : 'name-' . md5(
                                    ($w->event_name  ?? '') .
                                        ($w->event_group ?? '') .
                                        ($w->category    ?? '')
                                );

                            if (!isset($eventSummaries[$key])) {
                                $eventSummaries[$key] = array(
                                    'event_name'   => $w->event_name ?? 'Unknown Event',
                                    'event_group'  => $w->event_group ?? '-',
                                    'category'     => $w->category ?? '-',
                                    'first'        => 0,
                                    'second'       => 0,
                                    'third'        => 0,
                                    'fourth'       => 0,
                                    'fifth'        => 0,
                                    'teams'        => array(),
                                    'first_teams'  => array(),
                                    'second_teams' => array(),
                                    'third_teams'  => array(),
                                    'fourth_teams' => array(),
                                    'fifth_teams'  => array()
                                );
                            }

                            $teamName = trim((string)($w->municipality ?? ''));
                            if ($teamName !== '' && !in_array($teamName, $eventSummaries[$key]['teams'], true)) {
                                $eventSummaries[$key]['teams'][] = $teamName;
                            }

                            if (in_array($placeKey, $placementOrder, true)) {
                                $eventSummaries[$key][$placeKey] += 1;
                                $teamBucket = $placeKey . '_teams';
                                if ($teamName !== '' && !in_array($teamName, $eventSummaries[$key][$teamBucket], true)) {
                                    $eventSummaries[$key][$teamBucket][] = $teamName;
                                }
                            }
                        }


                        $eventSummaries = array_values($eventSummaries);
                        usort($eventSummaries, function ($a, $b) {
                            return strcasecmp($a['event_name'], $b['event_name']);
                        });
                        // Fallback: if no winners list was provided, build summaries from events_list counts
                        if (empty($eventSummaries) && !empty($events_list) && is_array($events_list)) {
                            foreach ($events_list as $ev) {
                                $g = isset($ev->gold_count) ? (int) $ev->gold_count : 0;
                                $s = isset($ev->silver_count) ? (int) $ev->silver_count : 0;
                                $b = isset($ev->bronze_count) ? (int) $ev->bronze_count : 0;
                                $total = $g + $s + $b;
                                if ($total <= 0) continue;
                                $key = isset($ev->event_id) ? 'id-' . $ev->event_id : 'name-' . md5(($ev->event_name ?? '') . ($ev->group_name ?? '') . ($ev->category_name ?? ''));
                                if (!isset($eventSummaries[$key])) {
                                    $eventSummaries[$key] = array(
                                        'event_name' => $ev->event_name ?? 'Unknown Event',
                                        'event_group' => $ev->group_name ?? '-',
                                        'category' => $ev->category_name ?? '-',
                                        'first' => 0,
                                        'second' => 0,
                                        'third' => 0,
                                        'fourth' => 0,
                                        'fifth' => 0,
                                        'teams' => array()
                                    );
                                }
                                $eventSummaries[$key]['first'] += $g;
                                $eventSummaries[$key]['second'] += $s;
                                $eventSummaries[$key]['third'] += $b;
                            }
                            $eventSummaries = array_values($eventSummaries);
                            usort($eventSummaries, function ($a, $b) {
                                return strcasecmp($a['event_name'], $b['event_name']);
                            });
                        }
                        $events = !empty($eventSummaries) ? count($eventSummaries) : 0;

                        ?>

                        <?php if (empty($activeMunicipality)): ?>
                            <div class="row summary-row">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="summary-card clickable" id="municipalityCard"
                                        data-toggle="modal" data-target="#municipalityModal"
                                        data-bs-toggle="modal" data-bs-target="#municipalityModal"
                                        role="button" tabindex="0">
                                        <div class="summary-label">Participating Teams</div>
                                        <div class="summary-value" id="stat-municipalities"><?= $municipalities; ?></div>
                                        <!-- <div class="summary-sub">Total registered teams</div> -->
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="summary-card clickable" id="eventsRecordedCard" role="button" tabindex="0"
                                        aria-label="View events with posted results">
                                        <div class="summary-label">Events Recorded</div>
                                        <div class="summary-value" id="stat-events"><?= $events; ?></div>
                                        <!-- <div class="summary-sub">completed with reported winners</div> -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="summary-card clickable" id="totalMedalsCard" role="button" tabindex="0"
                                        aria-label="View medal breakdown">
                                        <div class="summary-label">Total Medals</div>
                                        <div class="summary-value">
                                            <span id="stat-total-medals"><?= $totalMedals; ?></span>
                                            <span id="stat-medal-breakdown"
                                                style="font-size:0.9rem;font-weight:700;color:#2563eb;">
                                                (<span class="medal-filter" data-medal="1st" style="cursor:pointer;"><?= $firstTotal; ?>×1st</span>
                                                · <span class="medal-filter" data-medal="2nd" style="cursor:pointer;"><?= $secondTotal; ?>×2nd</span>
                                                · <span class="medal-filter" data-medal="3rd" style="cursor:pointer;"><?= $thirdTotal; ?>×3rd</span>
                                                · <span class="medal-filter" data-medal="4th" style="cursor:pointer;"><?= $fourthTotal; ?>×4th</span>
                                                · <span class="medal-filter" data-medal="5th" style="cursor:pointer;"><?= $fifthTotal; ?>×5th</span>)
                                            </span>
                                        </div>
                                        <!--<div class="summary-sub">-->
                                        <!--    Last update:-->
                                        <!--    <span id="stat-last-update"><?= $lastUpdate; ?></span>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                            </div>

                            <!-- Participating Teams (default view) -->
                            <?php
                            $teamRows = is_array($allMunicipalities) ? $allMunicipalities : array();
                            if (!empty($teamRows)) {
                                usort($teamRows, function ($a, $b) use ($tallyMap, $normalizeName) {
                                    $aName = isset($a->municipality) ? trim($a->municipality) : '';
                                    $bName = isset($b->municipality) ? trim($b->municipality) : '';
                                    $aKey = $normalizeName($aName);
                                    $bKey = $normalizeName($bName);
                                    $aStats = $tallyMap[$aKey] ?? null;
                                    $bStats = $tallyMap[$bKey] ?? null;
                                    $aGold = $aStats ? (int) $aStats->gold : 0;
                                    $bGold = $bStats ? (int) $bStats->gold : 0;
                                    if ($aGold !== $bGold) return $bGold - $aGold;
                                    $aSilver = $aStats ? (int) $aStats->silver : 0;
                                    $bSilver = $bStats ? (int) $bStats->silver : 0;
                                    if ($aSilver !== $bSilver) return $bSilver - $aSilver;
                                    $aBronze = $aStats ? (int) $aStats->bronze : 0;
                                    $bBronze = $bStats ? (int) $bStats->bronze : 0;
                                    if ($aBronze !== $bBronze) return $bBronze - $aBronze;
                                    $aTotal = $aStats ? (int) $aStats->total_medals : 0;
                                    $bTotal = $bStats ? (int) $bStats->total_medals : 0;
                                    if ($aTotal !== $bTotal) return $bTotal - $aTotal;
                                    return strcasecmp($aName, $bName);
                                });
                            }
                            $groupParam = ($group === 'ALL') ? '' : '&group=' . urlencode($group);
                            ?>
                            <div class="winners-table-wrapper mt-4" id="liveTallyWrapper">
                                <div class="winners-toolbar">
                                    <div class="winners-toolbar-left">
                                        <h5 class="winners-heading">Official Results Board - Live Tally</h5>
                                        <p class="winners-subtext mb-0">Last update:
                                            <span id="stat-last-update"><?= $lastUpdate; ?></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0 winners-table">
                                        <thead>
                                            <tr>
                                                <th>Team</th>
                                                <th class="text-center col-gold">1st</th>
                                                <th class="text-center col-silver">2nd</th>
                                                <th class="text-center col-bronze">3rd</th>
                                                <th class="text-center">4th</th>
                                                <th class="text-center">5th</th>
                                                <th class="text-center">Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php if (!empty($teamRows)): ?>
                                                <?php foreach ($teamRows as $row): ?>
                                                    <?php
                                                    $mName = isset($row->municipality) ? $row->municipality : '';
                                                    $mKey = $normalizeName($mName);
                                                    $stats = $tallyMap[$mKey] ?? null;
                                                    $hasData = $stats && ((int)$stats->total_medals > 0 || (int)$stats->gold > 0 || (int)$stats->silver > 0 || (int)$stats->bronze > 0);
                                                    $first = $stats ? $getCount($stats, array('first', 'gold')) : 0;
                                                    $second = $stats ? $getCount($stats, array('second', 'silver')) : 0;
                                                    $third = $stats ? $getCount($stats, array('third', 'bronze')) : 0;
                                                    $fourth = $stats ? $getCount($stats, array('fourth')) : 0;
                                                    $fifth = $stats ? $getCount($stats, array('fifth')) : 0;
                                                    $total = $first + $second + $third + $fourth + $fifth;
                                                    $goldClass = ($first > 0) ? ' col-gold' : '';
                                                    $silverClass = ($second > 0) ? ' col-silver' : '';
                                                    $bronzeClass = ($third > 0) ? ' col-bronze' : '';
                                                    $logo = isset($logoMap[$mName]) ? $logoMap[$mName] : '';
                                                    $filterUrl = app_url() . '?municipality=' . urlencode($mName) . $groupParam;
                                                    ?>
                                                    <tr>
                                                        <td class="align-middle">
                                                            <a href="<?= $filterUrl; ?>" class="d-flex align-items-center" style="gap:10px; text-decoration:none; color:inherit;">
                                                                <?php if (!empty($logo)): ?>
                                                                    <img src="<?= base_url('upload/team_logos/' . $logo); ?>" alt="<?= htmlspecialchars($mName, ENT_QUOTES, 'UTF-8'); ?> logo" class="team-logo">
                                                                <?php endif; ?>
                                                                <span><?= htmlspecialchars($mName, ENT_QUOTES, 'UTF-8'); ?></span>
                                                            </a>
                                                        </td>
                                                        <td class="text-center font-weight-bold<?= $goldClass; ?>">
                                                            <?php if ($hasData): ?>
                                                                <a href="<?= $filterUrl; ?>" class="medal-filter-link" data-medal="1st"><?= $first; ?></a>
                                                                <?php else: ?>—<?php endif; ?>
                                                        </td>
                                                        <td class="text-center font-weight-bold<?= $silverClass; ?>">
                                                            <?php if ($hasData): ?>
                                                                <a href="<?= $filterUrl; ?>" class="medal-filter-link" data-medal="2nd"><?= $second; ?></a>
                                                                <?php else: ?>—<?php endif; ?>
                                                        </td>
                                                        <td class="text-center font-weight-bold<?= $bronzeClass; ?>">
                                                            <?php if ($hasData): ?>
                                                                <a href="<?= $filterUrl; ?>" class="medal-filter-link" data-medal="3rd"><?= $third; ?></a>
                                                                <?php else: ?>—<?php endif; ?>
                                                        </td>
                                                        <td class="text-center font-weight-bold">
                                                            <?php if ($hasData && $fourth > 0): ?>
                                                                <a href="<?= $filterUrl; ?>" class="medal-filter-link" data-medal="4th"><?= $fourth; ?></a>
                                                                <?php else: ?>—<?php endif; ?>
                                                        </td>
                                                        <td class="text-center font-weight-bold">
                                                            <?php if ($hasData && $fifth > 0): ?>
                                                                <a href="<?= $filterUrl; ?>" class="medal-filter-link" data-medal="5th"><?= $fifth; ?></a>
                                                                <?php else: ?>—<?php endif; ?>
                                                        </td>
                                                        <td class="text-center font-weight-bold">
                                                            <?php if ($hasData): ?>
                                                                <a href="<?= $filterUrl; ?>" class="medal-filter-link" data-medal="All"><?= $total; ?></a>
                                                                <?php else: ?>—<?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr class="no-results-row">
                                                    <td colspan="5" class="text-center py-4 text-muted">No teams found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="winners-table-wrapper mt-3" id="eventsRecordedPanel" style="display:none;">
                                <div class="winners-toolbar">
                                    <div class="winners-toolbar-left">
                                        <h5 class="winners-heading mb-0">Posted Events</h5>
                                        <p class="winners-subtext mb-0">Events that already have recorded placements.</p>
                                    </div>
                                    <div class="winners-actions">
                                        <button class="btn btn-sm btn-light" id="hideEventsPanel">Hide</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0 winners-table">
                                        <thead>
                                            <tr>
                                                <th>Event</th>
                                                <th class="text-center">Group</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center col-gold">1st</th>
                                                <th class="text-center col-silver">2nd</th>
                                                <th class="text-center col-bronze">3rd</th>
                                                <th class="text-center">4th</th>
                                                <th class="text-center">5th</th>
                                            </tr>
                                        </thead>

                                        <tbody id="eventsRecordedBody">
                                            <?php if (!empty($eventSummaries)): ?>
                                                <?php foreach ($eventSummaries as $ev): ?>
                                                    <?php
                                                    $first = (int) $ev['first'];
                                                    $second = (int) $ev['second'];
                                                    $third = (int) $ev['third'];
                                                    $fourth = (int) ($ev['fourth'] ?? 0);
                                                    $fifth = (int) ($ev['fifth'] ?? 0);
                                                    $total = $first + $second + $third + $fourth + $fifth;
                                                    $goldCls = $first > 0 ? ' col-gold' : '';
                                                    $silverCls = $second > 0 ? ' col-silver' : '';
                                                    $bronzeCls = $third > 0 ? ' col-bronze' : '';
                                                    $rowCls = $total > 0 ? ' class="has-medal-row"' : '';
                                                    $firstTeams = !empty($ev['first_teams']) ? implode(', ', $ev['first_teams']) : '—';
                                                    $secondTeams = !empty($ev['second_teams']) ? implode(', ', $ev['second_teams']) : '—';
                                                    $thirdTeams = !empty($ev['third_teams']) ? implode(', ', $ev['third_teams']) : '—';
                                                    $fourthTeams = !empty($ev['fourth_teams']) ? implode(', ', $ev['fourth_teams']) : '—';
                                                    $fifthTeams = !empty($ev['fifth_teams']) ? implode(', ', $ev['fifth_teams']) : '—';
                                                    ?>
                                                    <tr<?= $rowCls; ?>>
                                                        <td><?= htmlspecialchars($ev['event_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center"><?= htmlspecialchars($ev['event_group'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center"><?= htmlspecialchars($ev['category'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center font-weight-bold<?= $goldCls; ?>"><?= htmlspecialchars($firstTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center font-weight-bold<?= $silverCls; ?>"><?= htmlspecialchars($secondTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center font-weight-bold<?= $bronzeCls; ?>"><?= htmlspecialchars($thirdTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center font-weight-bold"><?= htmlspecialchars($fourth > 0 ? $fourthTeams : '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center font-weight-bold"><?= htmlspecialchars($fifth > 0 ? $fifthTeams : '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr class="no-results-row">
                                                        <td colspan="8" class="text-center py-4 text-muted">
                                                            No events with posted results yet.
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <?php ?>
                            <div class="winners-table-wrapper mt-3" id="medalBreakdownPanel" style="display:none;">
                                <div class="winners-toolbar">
                                    <div class="winners-toolbar-left">
                                        <h5 class="winners-heading mb-0">Placement Overview</h5>
                                        <p class="winners-subtext mb-0">All events with posted placements (1st–5th).</p>
                                    </div>
                                    <div class="winners-actions">
                                        <button class="btn btn-sm btn-light" id="hideMedalBreakdown">Hide</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0 winners-table">
                                        <thead>
                                            <tr>
                                                <th style="min-width:180px;">Event</th>
                                                <th class="text-center">Group</th>
                                                <th class="text-center">Category</th>
                                                <th>Winner</th>
                                                <th class="text-center">Placement</th>
                                                <th>Team</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($winnersSorted)): ?>
                                                <?php foreach ($winnersSorted as $w): ?>
                                                    <?php
                                                    $medal = $w->medal ?? 'Silver';
                                                    $placement = $placementLabel($medal);
                                                    $chipClass = 'chip-silver';
                                                    if ($placement === '1st') $chipClass = 'chip-gold';
                                                    elseif ($placement === '3rd') $chipClass = 'chip-bronze';
                                                    $fullName = '';
                                                    if (!empty($w->full_name)) {
                                                        $fullName = $w->full_name;
                                                    } else {
                                                        $fullNameParts = array_filter(array($w->first_name ?? '', $w->middle_name ?? '', $w->last_name ?? ''));
                                                        $fullName = implode(' ', $fullNameParts);
                                                    }
                                                    $teamLogo = $logoMap[$w->municipality ?? ''] ?? '';
                                                    ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($w->event_name ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center"><?= htmlspecialchars($w->event_group ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center"><?= htmlspecialchars($w->category ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center">
                                                            <span class="chip-medal <?= $chipClass; ?>"><?= htmlspecialchars($placement, ENT_QUOTES, 'UTF-8'); ?></span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center" style="gap:8px;">
                                                                <?php if (!empty($teamLogo)): ?>
                                                                    <img src="<?= base_url('upload/team_logos/' . $teamLogo); ?>" alt="<?= htmlspecialchars($w->municipality ?? '', ENT_QUOTES, 'UTF-8'); ?> logo" class="team-logo">
                                                                <?php endif; ?>
                                                                <span><?= htmlspecialchars($w->municipality ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr class="no-results-row">
                                                    <td colspan="6" class="text-center py-4 text-muted">No medal data yet.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php
                            $selectedName = $activeMunicipality;
                            $selectedKey = $normalizeName($selectedName);
                            $teamStats = $tallyMap[$selectedKey] ?? null;
                            $teamGold = $teamStats ? (int) $teamStats->gold : 0;
                            $teamSilver = $teamStats ? (int) $teamStats->silver : 0;
                            $teamBronze = $teamStats ? (int) $teamStats->bronze : 0;
                            $teamTotal = $teamStats ? (int) $teamStats->total_medals : 0;
                            $teamLogo = isset($logoMap[$selectedName]) ? $logoMap[$selectedName] : '';
                            $backUrl = app_url() . ($group === 'ALL' ? '' : '?group=' . urlencode($group));
                            ?>

                            <div class="winners-table-wrapper mt-4" id="teamDashboardPanel">
                                <div class="winners-toolbar">
                                    <div class="winners-toolbar-left">
                                        <h5 class="winners-heading">Team Dashboard</h5>
                                        <p class="winners-subtext mb-0">
                                            Viewing all encoded events for <strong><?= htmlspecialchars($selectedName, ENT_QUOTES, 'UTF-8'); ?></strong>.
                                        </p>
                                    </div>
                                    <div class="winners-actions">
                                        <div class="filter-chip filter-chip-primary medal-filter" data-medal="1st">1st: <?= $teamGold; ?></div>
                                        <div class="filter-chip filter-chip-accent medal-filter" data-medal="2nd">2nd: <?= $teamSilver; ?></div>
                                        <div class="filter-chip filter-chip-muted medal-filter" data-medal="3rd">3rd: <?= $teamBronze; ?></div>
                                        <div class="filter-chip" id="clearMedalFilter" style="cursor:pointer;">Show All</div>
                                        <a class="btn btn-sm btn-light" href="<?= $backUrl; ?>">← Back to all teams</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0 winners-table">
                                        <thead>
                                            <tr>
                                                <th style="min-width:180px;">Event</th>
                                                <th class="text-center">Group</th>
                                                <th class="text-center">Category</th>
                                                <th>Name</th>
                                                <th class="text-center">Placement</th>
                                                <!-- School/Coach removed per request -->
                                            </tr>
                                        </thead>
                                        <tbody id="winners-body">
                                            <?php if (!empty($winners)): ?>
                                                <?php foreach ($winners as $w): ?>
                                                    <?php
                                                    $medal = isset($w->medal) ? $w->medal : 'Silver';
                                                    $placement = $placementLabel($medal);
                                                    $chipClass = 'chip-silver';
                                                    if ($placement === '1st') $chipClass = 'chip-gold';
                                                    elseif ($placement === '3rd') $chipClass = 'chip-bronze';
                                                    $fullName = '';
                                                    if (!empty($w->full_name)) {
                                                        $fullName = $w->full_name;
                                                    } else {
                                                        $fullNameParts = array_filter(array($w->first_name ?? '', $w->middle_name ?? '', $w->last_name ?? ''));
                                                        $fullName = implode(' ', $fullNameParts);
                                                    }
                                                    ?>
                                                    <tr data-medal="<?= htmlspecialchars($placement, ENT_QUOTES, 'UTF-8'); ?>">
                                                        <td class="align-middle">
                                                            <span><?= htmlspecialchars($w->event_name ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                                                        </td>
                                                        <td class="align-middle text-center"><?= htmlspecialchars($w->event_group ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="align-middle text-center"><?= htmlspecialchars($w->category ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="align-middle"><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="align-middle text-center">
                                                            <span class="chip-medal <?= $chipClass; ?>"><?= htmlspecialchars($placement, ENT_QUOTES, 'UTF-8'); ?></span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr class="no-results-row">
                                                    <td colspan="5" class="text-center py-5 text-muted">
                                                        No encoded events for this team yet.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="footer-note">
                            <!-- <span>
                                For questions or clarification on these results, please coordinate with the Meet Coordinator.
                            </span> -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    ?>
    <!-- Participating Teams Modal -->
    <?php
    $tally = isset($municipality_tally) ? $municipality_tally : array();
    $allMunicipalities = isset($municipalities_all) ? $municipalities_all : array();
    $groupContext = isset($active_group) ? $active_group : 'ALL';
    $baseUrl = ($groupContext === 'PARA') ? app_url('para') : app_url();
    $groupQuery = ($groupContext === 'Elementary' || $groupContext === 'Secondary')
        ? '&group=' . urlencode($groupContext)
        : '';
    $tallyMap = array();
    $normalizeName = function ($name) {
        return strtolower(trim((string) $name));
    };
    foreach ($tally as $row) {
        $key = $normalizeName(isset($row->municipality) ? $row->municipality : '');
        if ($key === '') {
            continue;
        }
        $tallyMap[$key] = $row;
    }
    // Order municipalities by medal tally (gold > silver > bronze) and place those with no data after
    $sortedMunicipalities = is_array($allMunicipalities) ? $allMunicipalities : array();
    if (!empty($sortedMunicipalities)) {
        usort($sortedMunicipalities, function ($a, $b) use ($tallyMap, $normalizeName) {
            $aName = isset($a->municipality) ? trim($a->municipality) : '';
            $bName = isset($b->municipality) ? trim($b->municipality) : '';

            $aKey = $normalizeName($aName);
            $bKey = $normalizeName($bName);

            $aStats = isset($tallyMap[$aKey]) ? $tallyMap[$aKey] : null;
            $bStats = isset($tallyMap[$bKey]) ? $tallyMap[$bKey] : null;

            if ($aStats && $bStats) {
                $goldDiff = (int) $bStats->gold - (int) $aStats->gold;
                if ($goldDiff !== 0) {
                    return $goldDiff;
                }
                $silverDiff = (int) $bStats->silver - (int) $aStats->silver;
                if ($silverDiff !== 0) {
                    return $silverDiff;
                }
                $bronzeDiff = (int) $bStats->bronze - (int) $aStats->bronze;
                if ($bronzeDiff !== 0) {
                    return $bronzeDiff;
                }
            } elseif ($aStats && !$bStats) {
                return -1;
            } elseif (!$aStats && $bStats) {
                return 1;
            }

            return strcasecmp($aName, $bName);
        });
    }
    ?>
    <div class="modal fade" id="municipalityModal" tabindex="-1" role="dialog" aria-labelledby="municipalityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="municipalityModalLabel">Participating Teams</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size:1.4rem;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($allMunicipalities)): ?>
                        <div class="municipality-picker" id="municipalityPicker"
                            data-base-url="<?= $baseUrl; ?>" data-group-query="<?= $groupQuery; ?>">
                            <span class="municipality-picker-label">Jump to a team dashboard</span>
                            <div class="municipality-picker-row">
                                <select class="form-control form-control-sm" id="municipalitySelect">
                                    <option value="">Select team</option>
                                    <?php foreach ($allMunicipalities as $row): ?>
                                        <option value="<?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?>">
                                            <?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-primary btn-sm" id="municipalityViewButton">
                                    Details
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover winners-table">
                                <thead>
                                    <tr>
                                        <th>Team</th>
                                        <th class="text-center col-gold">1st</th>
                                        <th class="text-center col-silver">2nd</th>
                                        <th class="text-center col-bronze">3rd</th>
                                        <th class="text-center">4th</th>
                                        <th class="text-center">5th</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($sortedMunicipalities as $row): ?>
                                        <?php
                                        $mName = $row->municipality;
                                        $logo = isset($row->logo) ? $row->logo : '';
                                        $mKey = $normalizeName($mName);
                                        $stats = isset($tallyMap[$mKey]) ? $tallyMap[$mKey] : null;
                                        $hasData = $stats && ((int) $stats->total_medals > 0 || (int) $stats->gold > 0 || (int) $stats->silver > 0 || (int) $stats->bronze > 0);
                                        $filterUrl = $baseUrl . '?municipality=' . urlencode($mName) . $groupQuery;
                                        ?>
                                        <?php
                                        $first = $stats ? $getCount($stats, array('first', 'gold')) : 0;
                                        $second = $stats ? $getCount($stats, array('second', 'silver')) : 0;
                                        $third = $stats ? $getCount($stats, array('third', 'bronze')) : 0;
                                        $fourth = $stats ? $getCount($stats, array('fourth')) : 0;
                                        $fifth = $stats ? $getCount($stats, array('fifth')) : 0;
                                        $totalRow = $first + $second + $third + $fourth + $fifth;
                                        $goldCls = ($hasData && $first > 0) ? ' col-gold' : '';
                                        $silverCls = ($hasData && $second > 0) ? ' col-silver' : '';
                                        $bronzeCls = ($hasData && $third > 0) ? ' col-bronze' : '';
                                        ?>
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center" style="gap:10px;">
                                                    <?php if (!empty($logo)): ?>
                                                        <img src="<?= base_url('upload/team_logos/' . $logo); ?>" alt="<?= htmlspecialchars($mName, ENT_QUOTES, 'UTF-8'); ?> logo" class="team-logo">
                                                    <?php endif; ?>
                                                    <span><?= htmlspecialchars($mName, ENT_QUOTES, 'UTF-8'); ?></span>
                                                </div>
                                            </td>
                                            <td class="text-center font-weight-bold<?= $goldCls; ?>"><?= $hasData ? $first : '—'; ?></td>
                                            <td class="text-center font-weight-bold<?= $silverCls; ?>"><?= $hasData ? $second : '—'; ?></td>
                                            <td class="text-center font-weight-bold<?= $bronzeCls; ?>"><?= $hasData ? $third : '—'; ?></td>
                                            <td class="text-center font-weight-bold"><?= $hasData && $fourth > 0 ? $fourth : '—'; ?></td>
                                            <td class="text-center font-weight-bold"><?= $hasData && $fifth > 0 ? $fifth : '—'; ?></td>
                                            <td class="text-center"><?= $hasData ? $totalRow : '—'; ?></td>
                                            <td class="text-right">
                                                <?php if ($hasData): ?>
                                                    <a href="<?= $filterUrl; ?>" class="btn btn-sm btn-outline-primary">
                                                        Details
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">No data yet</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-3">No municipalities recorded yet.</div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

        <!-- Events Recorded Modal -->
        <div class="modal fade" id="eventsRecordedModal" tabindex="-1" role="dialog" aria-labelledby="eventsRecordedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventsRecordedModalLabel">Events with Posted Results</h5>
                        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size:1.4rem;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($eventSummaries)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th class="text-center">Group</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center col-gold">1st</th>
                                            <th class="text-center col-silver">2nd</th>
                                            <th class="text-center col-bronze">3rd</th>
                                            <th class="text-center">4th</th>
                                            <th class="text-center">5th</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($eventSummaries as $ev): ?>
                                            <?php
                                            $first = (int) $ev['first'];
                                            $second = (int) $ev['second'];
                                            $third = (int) $ev['third'];
                                            $fourth = (int) ($ev['fourth'] ?? 0);
                                            $fifth = (int) ($ev['fifth'] ?? 0);
                                            $total = $first + $second + $third + $fourth + $fifth;
                                            $goldCls = $first > 0 ? ' col-gold' : '';
                                            $silverCls = $second > 0 ? ' col-silver' : '';
                                            $bronzeCls = $third > 0 ? ' col-bronze' : '';
                                            $rowCls = $total > 0 ? ' class="has-medal-row"' : '';
                                            $firstTeams = !empty($ev['first_teams']) ? implode(', ', $ev['first_teams']) : '—';
                                            $secondTeams = !empty($ev['second_teams']) ? implode(', ', $ev['second_teams']) : '—';
                                            $thirdTeams = !empty($ev['third_teams']) ? implode(', ', $ev['third_teams']) : '—';
                                            $fourthTeams = !empty($ev['fourth_teams']) ? implode(', ', $ev['fourth_teams']) : '—';
                                            $fifthTeams = !empty($ev['fifth_teams']) ? implode(', ', $ev['fifth_teams']) : '—';
                                            ?>
                                            <tr<?= $rowCls; ?>>
                                                <td><?= htmlspecialchars($ev['event_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center"><?= htmlspecialchars($ev['event_group'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center"><?= htmlspecialchars($ev['category'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center font-weight-bold<?= $goldCls; ?>"><?= htmlspecialchars($firstTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center font-weight-bold<?= $silverCls; ?>"><?= htmlspecialchars($secondTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center font-weight-bold<?= $bronzeCls; ?>"><?= htmlspecialchars($thirdTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center font-weight-bold"><?= htmlspecialchars($fourth > 0 ? $fourthTeams : '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center font-weight-bold"><?= htmlspecialchars($fifth > 0 ? $fifthTeams : '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-3">No events with results yet.</div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="<?= base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
    <script>
        window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\\/script>');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const ACTIVE_MUNICIPALITY = <?= json_encode($activeMunicipality); ?>;
        const IS_PARA_GROUP = <?= json_encode(strtoupper($group ?? 'ALL') === 'PARA'); ?>;

        window.ALL_MUNICIPALITIES = <?= json_encode(array_values(array_map(function ($mun) {
                                        return isset($mun->municipality) ? trim($mun->municipality) : '';
                                    }, isset($sortedMunicipalities) && is_array($sortedMunicipalities) ? $sortedMunicipalities : array()))); ?>;
        (function($, bootstrap) {
            if (!$) {
                console.error('jQuery did not load; municipal modal and live updates are disabled.');
                return;
            }

            function normalizeKey(val) {
                return (val || '').trim().toLowerCase();
            }

            function formatDateTime(dtString) {
                if (!dtString) return 'No data yet';

                // Treat dtString as UTC (e.g. "2025-12-08 02:24:00")
                var iso = dtString.replace(' ', 'T');
                if (!iso.endsWith('Z')) {
                    iso += 'Z'; // force UTC
                }

                var d = new Date(iso);
                if (isNaN(d.getTime())) return dtString;

                var options = {
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    timeZone: 'Asia/Manila'
                };

                // You can pass 'en-PH' or leave undefined
                return d.toLocaleString('en-PH', options);
            }

            function toPlacement(medal) {
                var m = (medal || '').toString().trim().toLowerCase();
                if (m === 'gold' || m === '1st' || m === 'first') return '1st';
                if (m === 'silver' || m === '2nd' || m === 'second') return '2nd';
                if (m === 'bronze' || m === '3rd' || m === 'third') return '3rd';
                if (m === '4th' || m === 'fourth') return '4th';
                if (m === '5th' || m === 'fifth') return '5th';
                return medal || '';
            }

            function placementKey(medal) {
                var p = toPlacement(medal);
                if (p === '1st') return 'first';
                if (p === '2nd') return 'second';
                if (p === '3rd') return 'third';
                if (p === '4th') return 'fourth';
                if (p === '5th') return 'fifth';
                return 'other';
            }


            var eventsPanelWasVisible = false;

            function openMunicipalityModal() {
                var modalEl = document.getElementById('municipalityModal');
                if (!modalEl) return;

                if ($.fn && $.fn.modal) {
                    $(modalEl).modal('show');
                    return;
                }

                if (bootstrap && bootstrap.Modal) {
                    var instance = bootstrap.Modal.getOrCreateInstance ?
                        bootstrap.Modal.getOrCreateInstance(modalEl) :
                        new bootstrap.Modal(modalEl);
                    instance.show();
                    return;
                }

                modalEl.classList.add('show');
                modalEl.style.display = 'block';
                modalEl.removeAttribute('aria-hidden');
                modalEl.setAttribute('aria-modal', 'true');
            }

            function openEventsRecordedModal() {
                var modalEl = document.getElementById('eventsRecordedModal');
                if (!modalEl) return;

                if ($.fn && $.fn.modal) {
                    $(modalEl).modal('show');
                    return;
                }

                if (bootstrap && bootstrap.Modal) {
                    var instance = bootstrap.Modal.getOrCreateInstance ?
                        bootstrap.Modal.getOrCreateInstance(modalEl) :
                        new bootstrap.Modal(modalEl);
                    instance.show();
                    return;
                }

                modalEl.classList.add('show');
                modalEl.style.display = 'block';
                modalEl.removeAttribute('aria-hidden');
                modalEl.setAttribute('aria-modal', 'true');
            }

            function toggleMedalPanel(show) {
                var $panel = $('#medalBreakdownPanel');
                var $tally = $('#liveTallyWrapper');
                var $eventsPanel = $('#eventsRecordedPanel');
                if (!$panel.length) return;
                if (show) {
                    eventsPanelWasVisible = $eventsPanel.length && $eventsPanel.is(':visible');
                    if (eventsPanelWasVisible) {
                        $eventsPanel.hide();
                    }
                    if ($tally.length) $tally.hide();
                    $panel.stop(true, true).slideDown(160);
                    var top = $panel.offset().top - 80;
                    $('html, body').animate({
                        scrollTop: top
                    }, 200);
                } else {
                    $panel.stop(true, true).slideUp(140, function() {
                        if (eventsPanelWasVisible && $eventsPanel.length) {
                            $eventsPanel.show();
                        } else if ($tally.length) {
                            $tally.show();
                        }
                        eventsPanelWasVisible = false;
                    });
                }
            }

            function toggleEventsPanel(show) {
                var $panel = $('#eventsRecordedPanel');
                var $tally = $('#liveTallyWrapper');
                if (!$panel.length) return;
                if (show) {
                    if ($tally.length) $tally.hide();
                    $('#medalBreakdownPanel').hide();
                    $panel.stop(true, true).slideDown(160);
                    var top = $panel.offset().top - 80;
                    $('html, body').animate({
                        scrollTop: top
                    }, 200);
                } else {
                    $panel.stop(true, true).slideUp(140, function() {
                        if ($tally.length) $tally.show();
                    });
                }
            }

            function renderWinnersRows(winners) {
                var hasResults = winners && winners.length > 0;

                if (hasResults) {
                    var tallies = {};
                    var medalWeight = {
                        Gold: 3,
                        Silver: 2,
                        Bronze: 1
                    };

                    winners.forEach(function(row) {
                        var key = normalizeKey(row.municipality);
                        if (!key) return;
                        if (!tallies[key]) {
                            tallies[key] = {
                                gold: 0,
                                silver: 0,
                                bronze: 0,
                                total: 0
                            };
                        }
                        var medalLower = (row.medal || '').toLowerCase();
                        if (medalLower === 'gold') tallies[key].gold++;
                        else if (medalLower === 'silver') tallies[key].silver++;
                        else if (medalLower === 'bronze') tallies[key].bronze++;
                        tallies[key].total++;
                    });

                    var sortedWinners = winners.slice().sort(function(a, b) {
                        var aKey = normalizeKey(a.municipality);
                        var bKey = normalizeKey(b.municipality);
                        var aStats = tallies[aKey] || {
                            gold: 0,
                            silver: 0,
                            bronze: 0,
                            total: 0
                        };
                        var bStats = tallies[bKey] || {
                            gold: 0,
                            silver: 0,
                            bronze: 0,
                            total: 0
                        };

                        var diff = bStats.gold - aStats.gold;
                        if (diff !== 0) return diff;
                        diff = bStats.silver - aStats.silver;
                        if (diff !== 0) return diff;
                        diff = bStats.bronze - aStats.bronze;
                        if (diff !== 0) return diff;
                        diff = bStats.total - aStats.total;
                        if (diff !== 0) return diff;

                        var medalDiff = (medalWeight[b.medal] || 0) - (medalWeight[a.medal] || 0);
                        if (medalDiff !== 0) return medalDiff;

                        var aEvent = (a.event_name || '').toLowerCase();
                        var bEvent = (b.event_name || '').toLowerCase();
                        if (aEvent !== bEvent) return aEvent.localeCompare(bEvent);

                        var aGroup = (a.event_group || '').toLowerCase();
                        var bGroup = (b.event_group || '').toLowerCase();
                        if (aGroup !== bGroup) return aGroup.localeCompare(bGroup);

                        var aCat = (a.category || '').toLowerCase();
                        var bCat = (b.category || '').toLowerCase();
                        if (aCat !== bCat) return aCat.localeCompare(bCat);

                        var aName = (a.full_name || '').toLowerCase();
                        var bName = (b.full_name || '').toLowerCase();
                        return aName.localeCompare(bName);
                    });

                    var rows = '';
                    sortedWinners.forEach(function(row) {
                        var placement = toPlacement(row.medal || '2nd');
                        var chipClass = 'chip-silver';
                        if (placement === '1st') chipClass = 'chip-gold';
                        else if (placement === '3rd') chipClass = 'chip-bronze';

                        rows += '<tr>' +
                            '<td class="align-middle">' + $('<div>').text(row.event_name || '').html() + '</td>' +
                            '<td class="align-middle" style="white-space:nowrap;">' + $('<div>').text(row.event_group || '').html() + '</td>' +
                            '<td class="align-middle" style="white-space:nowrap;">' + $('<div>').text(row.category || '-').html() + '</td>' +
                            '<td class="align-middle">' + $('<div>').text(row.full_name || '').html() + '</td>' +
                            '<td class="align-middle text-center">' +
                            '<span class="chip-medal ' + chipClass + '">' +
                            $('<div>').text(placement).html() +
                            '</span>' +
                            '</td>' +
                            '<td class="align-middle">' + $('<div>').text(row.municipality || '').html() + '</td>' +
                            '</tr>';
                    });
                    return rows;
                }

                var placeholders = [];
                if (Array.isArray(window.ALL_MUNICIPALITIES)) {
                    window.ALL_MUNICIPALITIES.forEach(function(name) {
                        if (!name) return;
                        placeholders.push(name);
                    });
                }

                if (placeholders.length === 0) {
                    return '<tr class="no-results-row">' +
                        '<td colspan="6" class="text-center py-5" style="color:#9ca3af;font-size:1.05rem;">' +
                        '🏅 No results are available yet. Please wait for the organizers to post the official list of winners.' +
                        '</td></tr>';
                }

                var rows = '';
                placeholders.forEach(function(name) {
                    rows += '<tr class="no-results-row">' +
                        '<td class="align-middle text-muted">—</td>' +
                        '<td class="align-middle text-muted">—</td>' +
                        '<td class="align-middle text-muted">—</td>' +
                        '<td class="align-middle text-muted">No winners posted yet</td>' +
                        '<td class="align-middle text-center text-muted">—</td>' +
                        '<td class="align-middle">' + $('<div>').text(name).html() + '</td>' +
                        '</tr>';
                });

                return rows;
            }

            function renderEventSummaries(rows) {
                if (!rows || rows.length === 0) {
                    return '<tr class="no-results-row"><td colspan="8" class="text-center py-4 text-muted">No events with posted results yet.</td></tr>';
                }
                var summary = {};
                rows.forEach(function(r) {
                    var key;
                    if (IS_PARA_GROUP) {
                        // ✅ Same PARA key logic as PHP
                        var sig = (
                            (r.event_name || '') + '|' +
                            (r.event_group || '') + '|' +
                            (r.category || '') + '|' +
                            (r.full_name || '') + '|' +
                            (r.municipality || '') + '|' +
                            (r.medal || '')
                        ).toLowerCase();
                        key = 'para-' + sig;
                    } else {
                        // 🔁 Original for non-PARA
                        key = (r.event_id !== undefined && r.event_id !== null) ?
                            'id-' + r.event_id :
                            'name-' + ((r.event_name || '') + '|' + (r.event_group || '') + '|' + (r.category || '')).toLowerCase();
                    }

                    if (!summary[key]) {
                        summary[key] = {
                            event_name: r.event_name || 'Unknown Event',
                            event_group: r.event_group || '-',
                            category: r.category || '-',
                            first: 0,
                            second: 0,
                            third: 0,
                            fourth: 0,
                            fifth: 0,
                            teams: [],
                            firstTeams: [],
                            secondTeams: [],
                            thirdTeams: [],
                            fourthTeams: [],
                            fifthTeams: []
                        };
                    }

                    var teamName = (r.municipality || '').trim();
                    if (teamName && summary[key].teams.indexOf(teamName) === -1) {
                        summary[key].teams.push(teamName);
                    }
                    var place = placementKey(r.medal);
                    var buckets = ['first', 'second', 'third', 'fourth', 'fifth'];
                    if (buckets.indexOf(place) !== -1) {
                        summary[key][place]++;
                        var teamBucket = place + 'Teams';
                        if (teamName && summary[key][teamBucket].indexOf(teamName) === -1) {
                            summary[key][teamBucket].push(teamName);
                        }
                    }
                });
                var list = Object.values(summary).sort(function(a, b) {
                    return (a.event_name || '').localeCompare(b.event_name || '');
                });
                var html = '';
                list.forEach(function(ev) {
                    var total = ev.first + ev.second + ev.third + ev.fourth + ev.fifth;
                    var rowCls = total > 0 ? ' class="has-medal-row"' : '';
                    var goldCls = ev.first > 0 ? ' col-gold' : '';
                    var silverCls = ev.second > 0 ? ' col-silver' : '';
                    var bronzeCls = ev.third > 0 ? ' col-bronze' : '';
                    var firstTeams = (ev.firstTeams && ev.firstTeams.length) ? ev.firstTeams.join(', ') : '—';
                    var secondTeams = (ev.secondTeams && ev.secondTeams.length) ? ev.secondTeams.join(', ') : '—';
                    var thirdTeams = (ev.thirdTeams && ev.thirdTeams.length) ? ev.thirdTeams.join(', ') : '—';
                    var fourthTeams = (ev.fourthTeams && ev.fourthTeams.length) ? ev.fourthTeams.join(', ') : '—';
                    var fifthTeams = (ev.fifthTeams && ev.fifthTeams.length) ? ev.fifthTeams.join(', ') : '—';
                    html += '<tr' + rowCls + '>' +
                        '<td>' + $('<div>').text(ev.event_name).html() + '</td>' +
                        '<td class="text-center">' + $('<div>').text(ev.event_group).html() + '</td>' +
                        '<td class="text-center">' + $('<div>').text(ev.category).html() + '</td>' +
                        '<td class="text-center font-weight-bold' + goldCls + '">' + $('<div>').text(firstTeams).html() + '</td>' +
                        '<td class="text-center font-weight-bold' + silverCls + '">' + $('<div>').text(secondTeams).html() + '</td>' +
                        '<td class="text-center font-weight-bold' + bronzeCls + '">' + $('<div>').text(thirdTeams).html() + '</td>' +
                        '<td class="text-center font-weight-bold">' + $('<div>').text(ev.fourth > 0 ? fourthTeams : '—').html() + '</td>' +
                        '<td class="text-center font-weight-bold">' + $('<div>').text(ev.fifth > 0 ? fifthTeams : '—').html() + '</td>' +
                        '</tr>';
                });
                return html || '<tr class="no-results-row"><td colspan="8" class="text-center py-4 text-muted">No events with posted results yet.</td></tr>';
            }

            function refreshResults() {
                if (ACTIVE_MUNICIPALITY) {
                    return; // do not override the focused team view with live refresh rows
                }
                var TEAM_COUNT = <?= $teamsTotal; ?>;

                $.getJSON('<?= app_url('live_results'); ?>', function(resp) {
                    if (!resp) return;

                    if (resp.overview) {
                        var o = resp.overview;
                        $('#stat-municipalities').text(TEAM_COUNT || o.municipalities || 0);

                        // (No stat-events here anymore)

                        var first = o.first || o.gold || 0;
                        var second = o.second || o.silver || 0;
                        var third = o.third || o.bronze || 0;
                        var fourth = o.fourth || 0;
                        var fifth = o.fifth || 0;
                        var total = o.total_medals || (first + second + third + fourth + fifth);

                        $('#stat-total-medals').text(total);
                        $('#stat-medal-breakdown').text(
                            '(' + first + '×1st · ' + second + '×2nd · ' + third + '×3rd · ' + fourth + '×4th · ' + fifth + '×5th)'
                        );
                        $('#stat-last-update').text(formatDateTime(o.last_update));
                    }


                    if (resp) {
                        // Make sure winners is always an array
                        var winnersArr = Array.isArray(resp.winners) ? resp.winners : [];

                        // Update tables (main winners and events recorded panel)
                        $('#winners-body').html(renderWinnersRows(winnersArr));
                        $('#eventsRecordedBody').html(renderEventSummaries(winnersArr));

                        var eventsCount;

                        if (IS_PARA_GROUP) {
                            // ✅ For PARAGAMES: count each distinct winner entry (same logic as PHP key)
                            var eventKeys = {};
                            winnersArr.forEach(function(r) {
                                var sig = (
                                    (r.event_name || '') + '|' +
                                    (r.event_group || '') + '|' +
                                    (r.category || '') + '|' +
                                    (r.full_name || '') + '|' +
                                    (r.municipality || '') + '|' +
                                    (r.medal || '')
                                ).toLowerCase();
                                eventKeys['para-' + sig] = true;
                            });
                            eventsCount = Object.keys(eventKeys).length;
                        } else {
                            // 🔁 Original behavior for non-PARA
                            var eventKeys = {};
                            winnersArr.forEach(function(r) {
                                var key;
                                if (r.event_id !== null && r.event_id !== undefined) {
                                    key = 'id-' + r.event_id;
                                } else {
                                    key = 'name-' + ((r.event_name || '') + '|' + (r.event_group || '') + '|' + (r.category || '')).toLowerCase();
                                }
                                eventKeys[key] = true;
                            });
                            eventsCount = Object.keys(eventKeys).length;
                        }

                        $('#stat-events').text(eventsCount);

                    }


                }).fail(function() {
                    // fail silently for now
                });
            }

            $(function() {
                $('.loader-wrapper').fadeOut(200);

                $('#municipalityCard').on('click keypress', function(e) {
                    if (e.type === 'click' || e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        openMunicipalityModal();
                    }
                });

                $('#eventsRecordedCard').on('click keypress', function(e) {
                    if (e.type === 'click' || e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleEventsPanel(true);
                    }
                });

                $('#totalMedalsCard').on('click keypress', function(e) {
                    if (e.type === 'click' || e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleMedalPanel(true);
                    }
                });

                $('#stat-medal-breakdown, #stat-total-medals').css('cursor', 'pointer').on('click', function(e) {
                    e.preventDefault();
                    toggleMedalPanel(true);
                });

                $('#hideMedalBreakdown').on('click', function(e) {
                    e.preventDefault();
                    toggleMedalPanel(false);
                });

                $('#hideEventsPanel').on('click', function(e) {
                    e.preventDefault();
                    toggleEventsPanel(false);
                });

                refreshResults();
                setInterval(refreshResults, 30000);

                var $picker = $('#municipalityPicker');
                if ($picker.length) {
                    var $select = $('#municipalitySelect');
                    var $viewBtn = $('#municipalityViewButton');

                    function goToMunicipality(municipality) {
                        if (!municipality) return;
                        var baseUrl = $picker.data('base-url') || '<?= app_url(); ?>';
                        var groupQuery = $picker.data('group-query') || '';
                        var url = baseUrl + '?municipality=' + encodeURIComponent(municipality) + groupQuery;
                        window.location.href = url;
                    }

                    $viewBtn.on('click', function() {
                        goToMunicipality($select.val());
                    });

                    // (optional) If you want changing the select to auto-jump, uncomment:
                    // $select.on('change', function() {
                    //     goToMunicipality($(this).val());
                    // });
                }
            });
        })(window.jQuery, window.bootstrap);

        // Medal filter on winners table: click totals to show rows with that medal; click again to reset.
        (function($) {
            var activeMedal = null;
            var $rows = $('#winners-body').find('tr');
            var $clearBtn = $('#clearMedalFilter');

            function applyMedalFilter() {
                if (!activeMedal) {
                    $rows.show();
                    return;
                }
                $rows.each(function() {
                    var medal = ($(this).data('medal') || '').toString();
                    $(this).toggle(medal === activeMedal);
                });
            }

            $('.medal-filter').on('click', function() {
                var medal = ($(this).data('medal') || '').toString();
                activeMedal = (activeMedal === medal) ? null : medal;
                applyMedalFilter();
            });

            if ($clearBtn.length) {
                $clearBtn.on('click', function() {
                    activeMedal = null;
                    applyMedalFilter();
                });
            }
        })(window.jQuery);
    </script>

</body>

</html>