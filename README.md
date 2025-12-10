# Provincial Meet Results

Live provincial meet standings built on CodeIgniter. Officials can log in to encode winners, while the public landing page shows live results and medal tallies grouped by Elementary and Secondary.

## Features
- Public landing page with animated hero, medal tallies, and filters for Elementary/Secondary
- Admin console to encode winners (event, group, category, medal, municipality) with recent-entry preview
- Editable meet header (title, year, subtitle) shown on the landing page
- User management (create/disable users), profile + avatar upload, and password change

## Requirements
- PHP 7.4+ (CodeIgniter 3.x)
- MySQL/MariaDB
- Apache with `mod_rewrite` enabled (tested with XAMPP)

## Quick start (local/XAMPP)
1) Place the project in `htdocs/provincial` (or adjust `RewriteBase` in `.htaccess` and `base_url` in `application/config/config.php`).
2) Create a database, e.g. `provincial_meet`.


## Key files
- `application/config/config.php` – base URL, session, and clean URL settings
- `application/config/database.php` – database credentials
- `application/config/routes.php` – routes (`provincial` is the default controller)
- `.htaccess` – rewrite rules to drop `index.php`
- `database script.txt` – bundled SQL seed for the `users` table

## Notes
- If clean URLs fail, recheck `mod_rewrite`, `AllowOverride All`, and the `RewriteBase` path.
- Assets and profile images live under `assets/` and `upload/profile/`; ensure the latter is writable.
