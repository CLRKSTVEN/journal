<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    /* Top 5 modal entry type buttons */
    .entry-type-toggle .entry-type-btn {
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 4px 10px;
        border-radius: 6px;
        background: #f8fafc;
        font-size: 12px;
        margin-right: 6px;
        transition: all 0.15s ease;
    }

    .entry-type-toggle .entry-type-btn.active {
        background: #2563eb;
        border-color: #1d4ed8;
        color: #fff;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
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
                    $entries = isset($surprise_winners) ? $surprise_winners : array();
                    // Prefill rows 1-5
                    $byRank = array();
                    if (!empty($entries)) {
                        foreach ($entries as $e) {
                            $r = isset($e->rank) ? (int) $e->rank : 0;
                            if ($r >= 1 && $r <= 5) {
                                $byRank[$r] = $e;
                            }
                        }
                    }
                    $events_list = isset($events_list) ? $events_list : array();
                    $event_groups_list = isset($event_groups) ? $event_groups : array();
                    $event_categories_list = isset($event_categories) ? $event_categories : array();
                    ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
                                <div class="mb-2">
                                    <h4 class="page-title mb-0">Top 5 Winners</h4>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success"><?= htmlspecialchars($this->session->flashdata('success'), ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($this->session->flashdata('error'), ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                <h5 class="card-title mb-0">Encode Top 5 Winners</h5>
                                                <small class="text-muted">Admin-only; entries here never appear on the public viewing page.</small>
                                            </div>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#top5Modal">
                                                <i class="mdi mdi-plus-circle-outline"></i> Add / Edit Entries
                                            </button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="top5Modal" tabindex="-1" role="dialog" aria-labelledby="top5ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 960px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="top5ModalLabel"><i class="mdi mdi-trophy-outline"></i> Top 5 Winners</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?= form_open(app_url('save_top5'), array('id' => 'top5Form')); ?>
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-4 mb-2">
                                            <label class="mb-0">Event</label>
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <small class="text-muted">Click Type or Select to switch</small>
                                                <button type="button" class="btn btn-link btn-sm p-0 toggle-top5-event-mode" data-mode="custom">Type</button>
                                            </div>
                                            <input type="text" id="top5EventNameCustom" class="form-control mb-2 d-none" placeholder="Enter event name">
                                            <select id="top5EventSelect" class="form-control">
                                                <option value="">-- Select Event --</option>
                                                <?php foreach ($events_list as $ev): ?>
                                                    <?php $label = trim($ev->event_name ?? ''); ?>
                                                    <option value="<?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>"
                                                        data-group="<?= htmlspecialchars($ev->group_name ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                        data-category="<?= htmlspecialchars($ev->category_name ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                                        <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 mb-2">
                                            <label class="mb-0">Group</label>
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <small class="text-muted">Click Type or Select to switch</small>
                                                <button type="button" class="btn btn-link btn-sm p-0 toggle-top5-group-mode" data-mode="custom">Type</button>
                                            </div>
                                            <select id="top5GroupSelect" class="form-control group-select">
                                                <option value="">-- Select Group --</option>
                                                <?php foreach ($event_groups_list as $g): ?>
                                                    <?php $glabel = trim($g->group_name ?? ''); ?>
                                                    <option value="<?= htmlspecialchars($glabel, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($glabel, ENT_QUOTES, 'UTF-8'); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <input type="text" id="top5GroupCustom" class="form-control d-none mt-1 group-input" placeholder="Enter group name">
                                        </div>
                                        <div class="form-group col-md-4 mb-2">
                                            <label class="mb-0">Category</label>
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <small class="text-muted">Click Type or Select to switch</small>
                                                <button type="button" class="btn btn-link btn-sm p-0 toggle-top5-category-mode" data-mode="custom">Type</button>
                                            </div>
                                            <select id="top5CategorySelect" class="form-control category-select">
                                                <option value="">-- Select Category --</option>
                                                <?php foreach ($event_categories_list as $c): ?>
                                                    <?php $clabel = trim($c->category_name ?? ''); ?>
                                                    <option value="<?= htmlspecialchars($clabel, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($clabel, ENT_QUOTES, 'UTF-8'); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <input type="text" id="top5CategoryCustom" class="form-control d-none mt-1 category-input" placeholder="Enter category name">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted small">Add entries one by one (max 5 placements).</span>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="addTop5Row"><i class="mdi mdi-plus"></i> Add Entry</button>
                                    </div>

                                    <div id="top5Rows" class="d-flex flex-column" style="gap:10px;"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Save Top 5 Winners</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Current Top 5 Winners</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width:80px;">Rank</th>
                                                    <th>Event</th>
                                                    <th>Winner</th>
                                                    <th>Team</th>
                                                    <th>School</th>
                                                    <th>Coach</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($entries)): ?>
                                                    <?php foreach ($entries as $e): ?>
                                                        <tr>
                                                            <td class="text-center font-weight-bold"><?= (int)$e->rank; ?></td>
                                                            <td><?= htmlspecialchars($e->event_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($e->winner_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($e->municipality ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($e->school ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($e->coach ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">No top 5 winners yet.</td>
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

    <script>
        (function() {
            var $rankSelects = $('.rank-select');
            var rowCounter = 0;
            var eventsMeta = <?= json_encode(array_map(function ($ev) {
                                    return array(
                                        'name' => $ev->event_name ?? '',
                                        'group_name' => $ev->group_name ?? '',
                                        'category_name' => $ev->category_name ?? ''
                                    );
                                }, $events_list)); ?>;
            var groupOptions = <?= json_encode(array_map(function ($g) {
                                    return $g->group_name ?? '';
                                }, $event_groups_list)); ?>;
            var categoryOptions = <?= json_encode(array_map(function ($c) {
                                        return $c->category_name ?? '';
                                    }, $event_categories_list)); ?>;
            var existingRows = <?= json_encode(array_values($byRank)); ?>;
            var $eventSelect = $('#top5EventSelect');
            var $eventNameCustom = $('#top5EventNameCustom');
            var $groupSelect = $('#top5GroupSelect');
            var $groupInput = $('#top5GroupCustom');
            var $categorySelect = $('#top5CategorySelect');
            var $categoryInput = $('#top5CategoryCustom');
            var $eventModeToggle = $('.toggle-top5-event-mode');
            var $groupModeToggle = $('.toggle-top5-group-mode');
            var $categoryModeToggle = $('.toggle-top5-category-mode');
            var municipalityOptionsHtml = (function() {
                var opts = '<option value=\"\">-- Select Team --</option>';
                <?php if (!empty($municipalities)): ?>
                    <?php foreach ($municipalities as $m): ?>
                        opts += '<option value="<?= htmlspecialchars($m->municipality ?? '', ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($m->municipality ?? '', ENT_QUOTES, 'UTF-8'); ?></option>';
                    <?php endforeach; ?>
                <?php endif; ?>
                return opts;
            })();

            function currentEventName() {
                return $eventSelect.prop('disabled') ? $.trim($eventNameCustom.val() || '') : $.trim($eventSelect.val() || '');
            }

            function currentGroupName() {
                return $groupSelect.prop('disabled') ? $.trim($groupInput.val() || '') : $.trim($groupSelect.val() || '');
            }

            function currentCategoryName() {
                return $categorySelect.prop('disabled') ? $.trim($categoryInput.val() || '') : $.trim($categorySelect.val() || '');
            }

            function setEventMode(mode) {
                var useCustom = mode === 'custom';
                $eventNameCustom.toggleClass('d-none', !useCustom).prop('disabled', !useCustom);
                $eventSelect.toggle(!useCustom).prop('disabled', useCustom);
                $eventModeToggle.text(useCustom ? 'Select' : 'Type').data('mode', useCustom ? 'select' : 'custom');
                if (useCustom && $eventNameCustom.val().trim() === '' && $eventSelect.val()) {
                    $eventNameCustom.val($eventSelect.find('option:selected').text());
                }
                if (!useCustom) {
                    $eventNameCustom.val('');
                }
            }

            function setGroupMode(mode) {
                var useCustom = mode === 'custom';
                $groupInput.toggleClass('d-none', !useCustom).prop('disabled', !useCustom);
                $groupSelect.toggleClass('d-none', useCustom).prop('disabled', useCustom);
                $groupModeToggle.text(useCustom ? 'Select' : 'Type').data('mode', useCustom ? 'select' : 'custom');
                if (useCustom && $groupInput.val().trim() === '' && $groupSelect.val()) {
                    $groupInput.val($groupSelect.find('option:selected').text());
                }
                if (!useCustom) {
                    $groupInput.val('');
                }
            }

            function setCategoryMode(mode) {
                var useCustom = mode === 'custom';
                $categoryInput.toggleClass('d-none', !useCustom).prop('disabled', !useCustom);
                $categorySelect.toggleClass('d-none', useCustom).prop('disabled', useCustom);
                $categoryModeToggle.text(useCustom ? 'Select' : 'Type').data('mode', useCustom ? 'select' : 'custom');
                if (useCustom && $categoryInput.val().trim() === '' && $categorySelect.val()) {
                    $categoryInput.val($categorySelect.find('option:selected').text());
                }
                if (!useCustom) {
                    $categoryInput.val('');
                }
            }

            $eventModeToggle.on('click', function() {
                setEventMode($(this).data('mode'));
            });
            $groupModeToggle.on('click', function() {
                setGroupMode($(this).data('mode'));
            });
            $categoryModeToggle.on('click', function() {
                setCategoryMode($(this).data('mode'));
            });

            // sync group/category when event is selected
            $eventSelect.on('change', function() {
                var $opt = $(this).find('option:selected');
                var grp = $opt.data('group') || '';
                var cat = $opt.data('category') || '';
                if (grp !== '') {
                    if ($groupSelect.prop('disabled')) {
                        $groupInput.val(grp);
                    } else {
                        $groupSelect.val(grp);
                    }
                }
                if (cat !== '') {
                    if ($categorySelect.prop('disabled')) {
                        $categoryInput.val(cat);
                    } else {
                        $categorySelect.val(cat);
                    }
                }
            });

            // Default to select mode on load
            setEventMode('select');
            setGroupMode('select');
            setCategoryMode('select');

            function getUsedRanks() {
                var used = {};
                $('#top5Rows').find('.rank-select').each(function() {
                    var val = ($(this).val() || '').toString();
                    if (val !== '') used[val] = true;
                });
                return used;
            }

            function firstAvailableRank() {
                var used = getUsedRanks();
                for (var i = 1; i <= 5; i++) {
                    if (!used[i]) return String(i);
                }
                return '1';
            }

            function refreshRankOptions() {
                var used = getUsedRanks();
                $('#top5Rows').find('.rank-select').each(function() {
                    var current = ($(this).val() || '').toString();
                    $(this).find('option').each(function() {
                        var val = ($(this).val() || '').toString();
                        var disable = used[val] && val !== current;
                        $(this).prop('disabled', disable);
                        $(this).prop('hidden', disable);
                    });
                });
            }

            function buildOptions(list, selected) {
                var html = '<option value="">-- Select --</option>';
                list.forEach(function(item) {
                    if (!item) return;
                    var sel = (item === selected) ? 'selected' : '';
                    html += '<option value="' + $('<div>').text(item).html() + '" ' + sel + '>' + $('<div>').text(item).html() + '</option>';
                });
                return html;
            }

            function buildEventOptions(selected) {
                var html = '<option value="">-- Select Event --</option>';
                eventsMeta.forEach(function(ev) {
                    var label = ev.name || '';
                    if (!label) return;
                    var sel = (label === selected) ? 'selected' : '';
                    html += '<option value="' + $('<div>').text(label).html() + '" ' + sel + '>' + $('<div>').text(label).html() + '</option>';
                });
                return html;
            }

            function assignEventMetaToRow($row, evName, grpName, catName) {
                $row.find('.event-name-hidden').val(evName || '');
                $row.find('.event-group-hidden').val(grpName || '');
                $row.find('.category-hidden').val(catName || '');
            }

            function addTop5Row(data) {
                if ($('#top5Rows .top5-row').length >= 5) return;
                data = data || {};
                rowCounter += 1;
                var index = rowCounter;
                var evName = data.event_name || currentEventName();
                var grpName = data.event_group || currentGroupName();
                var catName = data.category || currentCategoryName();
                var rankVal = data.rank ? String(data.rank) : firstAvailableRank();
                var $row = $(
                    '<div class="card top5-row" data-index="' + index + '" style="border:1px solid #e2e8f0;">' +
                    '<div class="card-body p-3">' +
                    '<div class="d-flex align-items-center justify-content-between mb-2">' +
                    '<div class="d-flex align-items-center">' +
                    '<span class="badge badge-medal badge-gold mr-2">Placement</span>' +
                    '<small class="text-muted">Entry</small>' +
                    '</div>' +
                    '<button type="button" class="btn btn-link text-danger p-0 btn-remove-row">Remove</button>' +
                    '</div>' +
                    '<div class="form-row align-items-end">' +
                    '<div class="form-group col-md-4 mb-2">' +
                    '<label class="small text-muted mb-1">Placement</label>' +
                    '<select name="surprise[' + index + '][rank]" class="form-control form-control-sm rank-select">' +
                    '<option value="">-- Select --</option>' +
                    '<option value="1">1st (Gold)</option>' +
                    '<option value="2">2nd (Silver)</option>' +
                    '<option value="3">3rd (Bronze)</option>' +
                    '<option value="4">4th Place</option>' +
                    '<option value="5">5th Place</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-8 mb-2">' +
                    '<label class="small text-muted mb-1">Entry type</label>' +
                    '<div class="entry-type-toggle">' +
                    '<input type="hidden" class="entry-type-value" name="surprise[' + index + '][entry_type]" value="Individual">' +
                    '<button type="button" class="entry-type-btn" data-type="Individual">Individual</button>' +
                    '<button type="button" class="entry-type-btn" data-type="Team">Team</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-row align-items-end mb-2 team-fields d-none">' +
                    '<div class="form-group col-md-12 mb-2">' +
                    '<label class="small text-muted mb-1">Team members / names</label>' +
                    '<textarea name="surprise[' + index + '][team_names]" class="form-control form-control-sm" rows="2" placeholder="Enter one or multiple names for this team"></textarea>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-row individual-fields mb-2">' +
                    '<div class="form-group col-md-4 mb-2">' +
                    '<label class="small text-muted mb-1">First name</label>' +
                    '<input type="text" name="surprise[' + index + '][first_name]" class="form-control form-control-sm">' +
                    '</div>' +
                    '<div class="form-group col-md-4 mb-2">' +
                    '<label class="small text-muted mb-1">Middle name</label>' +
                    '<input type="text" name="surprise[' + index + '][middle_name]" class="form-control form-control-sm">' +
                    '</div>' +
                    '<div class="form-group col-md-4 mb-2">' +
                    '<label class="small text-muted mb-1">Last name</label>' +
                    '<input type="text" name="surprise[' + index + '][last_name]" class="form-control form-control-sm">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-row mb-0">' +
                    '<div class="form-group col-md-4 mb-2">' +
                    '<label class="small text-muted mb-1">Team</label>' +
                    '<select name="surprise[' + index + '][municipality]" class="form-control form-control-sm">' + municipalityOptionsHtml + '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-4 mb-2">' +
                    '<label class="small text-muted mb-1">School</label>' +
                    '<input type="text" name="surprise[' + index + '][school]" class="form-control form-control-sm" placeholder="School">' +
                    '</div>' +
                    '<div class="form-group col-md-4 mb-2">' +
                    '<label class="small text-muted mb-1">Coach</label>' +
                    '<input type="text" name="surprise[' + index + '][coach]" class="form-control form-control-sm" placeholder="Coach">' +
                    '</div>' +
                    '</div>' +
                    '<input type="hidden" class="event-name-hidden" name="surprise[' + index + '][event_name]" value="">' +
                    '<input type="hidden" class="event-group-hidden" name="surprise[' + index + '][event_group]" value="">' +
                    '<input type="hidden" class="category-hidden" name="surprise[' + index + '][category]" value="">' +
                    '<input type="hidden" class="winner-name-hidden" name="surprise[' + index + '][winner_name]" value="">' +
                    '</div>' +
                    '</div>'
                );

                $('#top5Rows').append($row);

                $row.find('.rank-select').val(rankVal);
                $row.find('input[name="surprise[' + index + '][first_name]"]').val(data.first_name || data.winner_name || '');
                $row.find('input[name="surprise[' + index + '][middle_name]"]').val(data.middle_name || '');
                $row.find('input[name="surprise[' + index + '][last_name]"]').val(data.last_name || '');
                $row.find('textarea[name="surprise[' + index + '][team_names]"]').val(data.team_names || '');
                $row.find('select[name="surprise[' + index + '][municipality]"]').val(data.municipality || '');
                $row.find('input[name="surprise[' + index + '][school]"]').val(data.school || '');
                $row.find('input[name="surprise[' + index + '][coach]"]').val(data.coach || '');

                assignEventMetaToRow($row, evName, grpName, catName);

                $row.find('.rank-select').on('change', refreshRankOptions);
                $row.find('.entry-type-btn').on('click', function() {
                    var mode = $(this).data('type');
                    setRowMode($row, mode);
                });
                $row.find('.btn-remove-row').on('click', function() {
                    $(this).closest('.top5-row').remove();
                    refreshRankOptions();
                });

                setRowMode($row, data.entry_type || (data.team_names ? 'Team' : 'Individual'));
                refreshRankOptions();
            }

            $('#addTop5Row').on('click', function() {
                addTop5Row({
                    event_name: ($eventSelect.is(':visible') ? $eventSelect.val() : $eventNameCustom.val()) || '',
                    event_group: ($groupSelect.is(':visible') ? $groupSelect.val() : $groupInput.val()) || '',
                    category: ($categorySelect.is(':visible') ? $categorySelect.val() : $categoryInput.val()) || ''
                });
            });

            function setRowMode($row, mode) {
                mode = (mode || 'Individual').toString().toLowerCase();
                var isTeam = mode === 'team';
                $row.find('.entry-type-value').val(isTeam ? 'Team' : 'Individual');
                $row.find('.entry-type-btn').removeClass('active btn-primary text-white').addClass('btn-outline-secondary');
                var $active = $row.find('.entry-type-btn[data-type="' + (isTeam ? 'Team' : 'Individual') + '"]');
                $active.addClass('active btn-primary text-white').removeClass('btn-outline-secondary');
                $row.find('.individual-fields').toggleClass('d-none', isTeam);
                $row.find('.team-fields').toggleClass('d-none', !isTeam);
                if (isTeam) {
                    $row.find('.individual-fields input').val('');
                } else {
                    $row.find('textarea[name$="[team_names]"]').val('');
                }
            }

            // Before submit, build winner_name from individual or team fields
            $('#top5Form').on('submit', function() {
                var evName = currentEventName();
                var grpName = currentGroupName();
                var catName = currentCategoryName();
                $('#top5Rows .top5-row').each(function() {
                    var $row = $(this);
                    var isTeam = ($row.find('.entry-type-value').val() || '').toLowerCase() === 'team';
                    var winnerName = '';
                    if (isTeam) {
                        winnerName = $.trim($row.find('textarea[name$="[team_names]"]').val() || '');
                    } else {
                        var first = $.trim($row.find('input[name$="[first_name]"]').val() || '');
                        var middle = $.trim($row.find('input[name$="[middle_name]"]').val() || '');
                        var last = $.trim($row.find('input[name$="[last_name]"]').val() || '');
                        winnerName = $.trim([first, middle, last].filter(Boolean).join(' '));
                    }
                    var nameInput = $row.find('.winner-name-hidden');
                    nameInput.val(winnerName);
                    assignEventMetaToRow($row, evName, grpName, catName);
                });
            });

            // Seed existing rows
            if (existingRows.length) {
                existingRows.forEach(function(row) {
                    addTop5Row(row);
                });
            } else {
                addTop5Row();
            }
        })();
    </script>
</body>

</html>
