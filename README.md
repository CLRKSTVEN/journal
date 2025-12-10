# Journalism Rankings Hub

Landing page and admin console for campus journalism results, rebranded from the DepEd sports template. Officials can log in to encode winners, while the public landing page shows live rankings and medal tallies for each delegation.

## Features
- Public landing page with animated hero, medal tallies, and filters for Elementary/Secondary (or PARA)
- Admin console to encode winners (event, group, category, medal, municipality) with recent-entry preview
- Editable meet header (title, year, subtitle) shown on the landing page with journalism branding
- User management (create/disable users), profile + avatar upload, and password change
- Friendly `/journal` URLs with backwards-compatible `/provincial` routes

## Requirements
- PHP 7.4+ (CodeIgniter 3.x)
- MySQL/MariaDB
- Apache with `mod_rewrite` enabled (tested with XAMPP)

## Quick start (local/XAMPP)
1) Place the project in `htdocs/journal` (or adjust `RewriteBase` in `.htaccess` and `base_url` in `application/config/config.php`).
2) Create a database, e.g. `provincial_meet` (or reuse your existing DB).


## Key files
- `application/config/config.php` – base URL, session, and clean URL settings
- `application/config/database.php` – database credentials
- `application/config/routes.php` – routes (`journal` alias points to the Provincial controller)
- `.htaccess` – rewrite rules to drop `index.php`
- `database script.txt` – bundled SQL seed for the `users` table

## Notes
- If clean URLs fail, recheck `mod_rewrite`, `AllowOverride All`, and the `RewriteBase` path.
- Assets and profile images live under `assets/` and `upload/profile/`; ensure the latter is writable.
