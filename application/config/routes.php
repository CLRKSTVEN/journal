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
$route['journal'] = 'provincial/index';
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
