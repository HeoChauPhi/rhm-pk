# starttheme
1. Import database in `sql` folder into phpmyadmin.
2. Copy `build\wp-config\wp-config.env.example.php` and change name to `wp-config.local.php`
3. Config site in `build\wp-config\wp-config.local.php` file.
4. Download and extract `Wordpress Core` into `build` folder.
5. Move `custom-theme-composer` theme to `build\wp-content\themes\`.
6. Move `wp-config.php` in `build\wp-config` folder to `build` folder.
7. Run: `composer install`.
8. Create Vitual Host for project on local with curent folder `build`.
9. Run project with Vitual Host.