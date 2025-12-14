<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Landing page = Provincial controller (exposed publicly as /journal)
$route['default_controller'] = 'provincial';

// Friendly alias for the journalism landing/admin URLs
$route['journal/login'] = 'login';
$route['journal/login/auth'] = 'login/auth';
$route['journal/logout'] = 'login/logout';
$route['journal/home_page'] = 'login';
$route['journal/home_page.php'] = 'login';
$route['journal/update-settings'] = 'provincial/update_meet_settings';
$route['journal/top5'] = 'provincial/top5_winners';
$route['journal/save_top5'] = 'provincial/save_top5_winners';
$route['journal/add_municipality'] = 'provincial/add_municipality';
$route['journal/update_municipality'] = 'provincial/update_municipality';
$route['journal/delete_municipality'] = 'provincial/delete_municipality';
$route['journal/delete_winner/(:num)'] = 'provincial/delete_winner/$1';
$route['journal/update_winner'] = 'provincial/update_winner';
$route['journal/add_event'] = 'provincial/add_event';
$route['journal/update_event'] = 'provincial/update_event';
$route['journal/delete_event/(:num)'] = 'provincial/delete_event/$1';
$route['journal'] = 'provincial/index';
$route['journal/teams'] = 'provincial/municipalities'; // explicit alias (avoid CI looking for Provincial::teams)
// catch-all for provincial routes when prefixed with /journal
$route['journal/(:any)'] = 'provincial/$1';

// When the app is already hosted under /journal/, allow slugless shortcuts
$route['standings'] = 'provincial/index';
$route['admin'] = 'provincial/admin';
$route['teams'] = 'provincial/municipalities';
$route['technical'] = 'provincial/technical';
$route['para'] = 'provincial/para';
$route['events'] = 'provincial/events';
$route['report'] = 'provincial/report';
$route['live_results'] = 'provincial/live_results';
$route['update-settings'] = 'provincial/update_meet_settings';
$route['top5'] = 'provincial/top5_winners';
$route['save_top5'] = 'provincial/save_top5_winners';
$route['add_municipality'] = 'provincial/add_municipality';
$route['update_municipality'] = 'provincial/update_municipality';
$route['delete_municipality'] = 'provincial/delete_municipality';
$route['delete_winner/(:num)'] = 'provincial/delete_winner/$1';
$route['update_winner'] = 'provincial/update_winner';
$route['add_event'] = 'provincial/add_event';
$route['update_event'] = 'provincial/update_event';
$route['delete_event/(:num)'] = 'provincial/delete_event/$1';

// keep these for admin login
$route['login']      = 'login';
$route['login/auth'] = 'login/auth';
$route['home_page.php'] = 'login';
$route['home_page']     = 'login';

// Provincial routes
$route['provincial']           = 'provincial/index';      // optional
$route['provincial/standings'] = 'provincial/index';      // same landing
$route['provincial/admin']     = 'provincial/admin';
$route['provincial/municipalities'] = 'provincial/municipalities';
$route['provincial/teams'] = 'provincial/municipalities';
$route['provincial/technical'] = 'provincial/technical';
$route['provincial/para'] = 'provincial/para';
$route['provincial/events'] = 'provincial/events';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['provincial/update-settings'] = 'provincial/update_meet_settings';
